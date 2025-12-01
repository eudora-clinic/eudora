<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ControllerCommission extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("If-Modified-Since: Mon, 22 Jan 2008 00:00:00 GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Cache-Control: private");
        header("Pragma: no-cache");
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type');
        $this->load->model('MApp');
        $this->load->model('ModelHr');
        $this->load->model('ModelCompany');
        $this->load->model('ModelCommission');
        $this->load->library('Utility');
        $this->load->library('Datatables');
        date_default_timezone_set('Asia/Jakarta');
    }

    function content($type = "", $param1 = "", $param2 = "")
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata('is_login')) {
            $this->load->view('login');
        } else {
            switch ($type) {
                case 'reportCommissionSubscription':
                    $period = $this->input->post('period') ? $this->input->post('period') : date('Y-m');
                    $data['level'] = $this->session->userdata('level');
                    $data['title'] = 'reportCommissionSubscription';
                    $data['period'] = $period;
                    $data['listCommissionSubscription'] = $this->ModelCommission->getCommissionSubscription($period);
                    $data['content'] = 'Commission/reportCommissionSubscription';
                    $data['mod'] = $type;
                    break;
                case 'reportCommissionPerInvoice':
                    $userid = $this->session->userdata('userid');
                    $dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-01');
                    ;
                    $dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
                    $data = [
                        'listPrescriptionDoctor' => $this->ModelCommission->getReportCommissionPerInvoice($dateStart, $dateEnd, $userid, 1),
                        'listPrescriptionDoctorSummary' => $this->ModelCommission->getReportCommissionPerInvoice($dateStart, $dateEnd, $userid, 2),
                        'title' => 'REPORT COMMISSION PER INVOICE',
                        'content' => 'Commission/reportCommissionPerInvoice',
                        'dateStart' => $dateStart,
                        'dateEnd' => $dateEnd,
                        'locationList' => $this->MApp->get_location_list(),
                    ];
                    $data['mod'] = $type;
                    break;
            }
            $db_oriskin = $this->load->database('oriskin', true);
            $userid = $this->session->userdata('userid');
            $locationid = $this->session->userdata('locationid');
            $query = $db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
            $locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';
            $locationList = $db_oriskin->query("SELECT DISTINCT id, name FROM mslocation WHERE id IN ($locationAccsesIds)")->result_array();
            $data['locationList'] = $locationList;
            $data['locationId'] = $locationid;
            $data['userId'] = $userid;
            $this->load->view('index', $data);
        }
    }

    public function generatePayrollCommissionHandWork()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $db_oriskin = $this->load->database('oriskin', true);

        $dateStart = $this->input->get('dateStart', TRUE);
        $dateEnd = $this->input->get('dateEnd', TRUE);
        $locationId = $this->input->get('locationId', TRUE);

        // Validasi input
        if (!$dateStart || !$dateEnd || !$locationId) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Parameter dateStart, dateEnd, dan locationId wajib diisi.'
            ]);
            return;
        }

        try {
            $sql = "
            EXEC spDetailCommissionDoingTreatmentRangeDatePerClinicSummaryDev 
                @PERIODSTART = ?, 
                @PERIODEND   = ?, 
                @LOCATIONID  = ?, 
                @TYPE        = 2
        ";

            $query = $db_oriskin->query($sql, [
                $dateStart,
                $dateEnd,
                $locationId
            ]);

            // Jika SP gagal dieksekusi
            if (!$query) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Gagal mengeksekusi stored procedure.'
                ]);
                return;
            }

            $results = $query->result_array();

            // Jika berhasil
            echo json_encode([
                'status' => 'success',
                'message' => 'Summary berhasil digenerate.',
                'results' => $results
            ]);

        } catch (Exception $e) {
            // Jika terjadi exception
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }


}


