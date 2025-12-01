<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ControllerFingerPrintCustomer extends CI_Controller
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
        $this->load->model('ModelMaster');
        $this->load->library('Utility');
        $this->load->library('Datatables');
        date_default_timezone_set('Asia/Jakarta');
        $this->load->database('oriskin', true);
    }


    public function register()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $input = json_decode($this->input->raw_input_stream, true);
        $customerid = $input['customerid'] ?? null;
        $fingerprint = $input['fingerprint'] ?? null;

        if (!$customerid || !$fingerprint) {
            echo json_encode(['status' => false, 'message' => 'customerid / fingerprint required']);
            return;
        }
        $db_oriskin->where('customerid', $customerid);
        $exists = $db_oriskin->get('customer_fingerprints')->row();

        if ($exists) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Fingerprint customer sudah terdaftar sebelumnya',
                'data' => $exists
            ]);
            return;
        }

        $data = [
            'customerid' => $customerid,
            'reader_id' => $input['reader_id'] ?? '',
            'fingerprint' => $fingerprint,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $db_oriskin->insert('customer_fingerprints', $data);
        echo json_encode(['status' => 'success', 'message' => 'Fingerprint customer berhasil di daftarkan', 'data' => $data]);
    }

    public function log_match()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $input = json_decode($this->input->raw_input_stream, true);
        $customerid = $input['customerid'] ?? null;

        if (!$customerid) {
            echo json_encode(['status' => false, 'message' => 'customerid / fingerprint required']);
            return;
        }

        $data = [
            'customerid' => $customerid
        ];

        $db_oriskin->insert('fingerprint_customer_log', $data);

        $today = date('Y-m-d');

        $db_oriskin->where('customerid', $customerid);
        $db_oriskin->where("CAST(treatmentdate AS DATE) =", $today);
        $db_oriskin->update('trdoingtreatment', ['status_finger_customer' => 1]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Fingerprint saved & trdoingtreatment updated',
            'data' => $data
        ]);
    }

    public function get_all()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $db_oriskin->select("a.customerid, a.fingerprint, (b.firstname + ' ' + b.lastname) as customername, b.cellphonenumber as cellphonenumber, b.customercode");
        $db_oriskin->from('customer_fingerprints a');
        $db_oriskin->join('mscustomer b', 'a.customerid = b.id', 'inner');
        $query = $db_oriskin->get();

        $result = $query->result_array();

        echo json_encode([
            'status' => 'success',
            'data' => $result
        ]);
    }

    // Endpoint dummy verify (opsional, kalau mau tetap server-side)
    public function verify()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $input = json_decode($this->input->raw_input_stream, true);
        $fingerprint = $input['fingerprint'] ?? null;

        if (!$fingerprint) {
            echo json_encode(['status' => 'error', 'message' => 'fingerprint required']);
            return;
        }

        $query = $db_oriskin->get('customer_fingerprints');
        $users = $query->result();

        $matchedUserId = null;

        foreach ($users as $user) {
            if ($user->fingerprint === $fingerprint) {
                $matchedUserId = $user->customerid;
                break;
            }
        }

        if ($matchedUserId) {
            echo json_encode(['status' => 'success', 'customerid' => $matchedUserId]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No match']);
        }
    }

    public function searchCustomer()
    {
        $q = $this->input->get('q', TRUE); // ambil query parameter "q"
        $db_oriskin = $this->load->database('oriskin', true);

        $db_oriskin->select('id as customerid, customercode, firstname, lastname, cellphonenumber');
        $db_oriskin->from('mscustomer');

        if (!empty($q)) {
            $db_oriskin->group_start();
            $db_oriskin->like('customercode', $q);
            $db_oriskin->or_like('firstname', $q);
            $db_oriskin->or_like('lastname', $q);
            $db_oriskin->or_like('cellphonenumber', $q);
            $db_oriskin->group_end();
        }

        $db_oriskin->limit(10);

        $query = $db_oriskin->get();
        $result = $query->result_array();

        $response = [
            'status' => 'success',
            'count' => count($result),
            'data' => $result
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}


