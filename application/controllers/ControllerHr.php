<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ControllerHr extends CI_Controller
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
                case 'presensiEmployee':
                    $userid = $this->session->userdata('userid');
                    $level = $this->session->userdata('level');
                    $db_oriskin = $this->load->database('oriskin', true);

                    $query = $db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
                    $locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';
                    $locationListAppointment = $db_oriskin->query("SELECT DISTINCT id, name FROM mslocation WHERE id IN ($locationAccsesIds)")->result_array();
                    $shiftList = $this->ModelHr->getShift();

                    $data['locationListAppointment'] = $locationListAppointment;
                    $data['level'] = $level;
                    $data['locationId'] = $locationListAppointment[0]['id'];
                    $data['shiftList'] = $shiftList;

                    $data['title'] = 'PRESENSI EMPLOYEE';
                    $data['content'] = 'HR/presensiEmployee';
                    $data['mod'] = $type;
                    break;
                case 'summaryPresensiEmployee':
                    $userid = $this->session->userdata('userid');
                    $level = $this->session->userdata('level');
                    $db_oriskin = $this->load->database('oriskin', true);

                    $query = $db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
                    $locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';
                    $locationListPresensi = $db_oriskin->query("SELECT DISTINCT id, name FROM mslocation WHERE id IN ($locationAccsesIds)")->result_array();

                    $locationId = $this->input->post('locationId') ? $this->input->post('locationId') : $locationListPresensi[0]['id'];

                    $data['locationListPresensi'] = $locationListPresensi;
                    $data['level'] = $level;
                    $data['locationId'] = $locationId;

                    $data['title'] = 'SUMMARY PRESENSI EMPLOYEE';
                    $data['content'] = 'HR/summaryPresensiEmployee';
                    $data['mod'] = $type;
                    break;
                case 'summaryPresensiEmployeeClinic':
                    $userid = $this->session->userdata('userid');
                    $level = $this->session->userdata('level');
                    $db_oriskin = $this->load->database('oriskin', true);

                    $query = $db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
                    $locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';
                    $locationListPresensi = $db_oriskin->query("SELECT DISTINCT id, name FROM mslocation WHERE id IN ($locationAccsesIds)")->result_array();

                    $locationId = $this->input->post('locationId') ? $this->input->post('locationId') : $locationListPresensi[0]['id'];

                    $data['locationListPresensi'] = $locationListPresensi;
                    $data['level'] = $level;
                    $data['locationId'] = $locationId;

                    $data['title'] = 'SUMMARY PRESENSI EMPLOYEE';
                    $data['content'] = 'HR/summaryPresensiEmployeeClinic';
                    $data['mod'] = $type;
                    break;
                case 'listShift':
                    $data['title'] = 'listShift';
                    $data['content'] = 'HR/listShift';
                    $data['mod'] = $type;
                    break;
                case 'listLeaveType':
                    $data['title'] = 'listLeaveType';
                    $data['content'] = 'HR/listLeaveType';
                    $data['mod'] = $type;
                    break;
                case 'listAllowanceType':
                    $data['title'] = 'listAllowanceType';
                    $data['content'] = 'HR/listAllowanceType';
                    $data['mod'] = $type;
                    break;
                case 'listDeductionType':
                    $data['title'] = 'listDeductionType';
                    $data['content'] = 'HR/listDeductionType';
                    $data['mod'] = $type;
                    break;
                // Added At 13-08-2025
                case 'employeeAllowanceMonthly':
                    $data['title'] = 'Employee Allowance Monthly';
                    $data['content'] = 'HR/createAllowanceMonthly';
                    $data['mod'] = $type;
                    $selected_period = $this->input->get('period') ?? date('Y-m');
                    $this->load->model('ModelHr');
                    $data['allowance_data'] = $this->ModelHr->get_by_period($selected_period);
                    $data['selected_period'] = $selected_period;
                    break;
                case 'employeeSalaryMonthly':
                    $data['title'] = 'employeeSalaryMonthly';
                    $data['content'] = 'HR/employeeSalaryMonthly';
                    $data['mod'] = $type;
                    break;
                case 'employeeDeductionMonthly':
                    $data['title'] = 'Employee Deduction Monthly';
                    $data['content'] = 'HR/createDeductionMonthly';
                    $data['mod'] = $type;
                    break;
                case 'leavePermissionRequest':
                    $level = $this->session->userdata('level');
                    $db_oriskin = $this->load->database('oriskin', true);
                    $queryTreatments = $db_oriskin->query("
                        SELECT * FROM msleavetype
                    ");
                    $data['listType'] = $queryTreatments->result_array();
                    $data['level'] = $level;
                    $data['title'] = 'Permission Request';
                    $data['content'] = 'HR/leavePermissionRequest';
                    $data['mod'] = $type;
                    break;
                case 'listJob':
                    $data['title'] = 'listJob';
                    $data['content'] = 'HR/listJob';
                    $data['mod'] = $type;
                    break;
                case 'publicHolidayCalender':
                    $data['title'] = 'publicHolidayCalender';
                    $data['content'] = 'HR/publicHolidayCalender';
                    $data['mod'] = $type;
                    break;
                case 'createAttandanceLogManual':
                    $data['title'] = 'createAttandanceLogManual';
                    $data['content'] = 'HR/createAttandanceLogManual';
                    $data['mod'] = $type;
                    break;
                case 'listEmployeeCompany':
                    $data['title'] = 'listEmployeeCompany';
                    $data['content'] = 'HR/listEmployeeCompany';
                    $data['mod'] = $type;
                    break;
                case 'generateEmployeePayroll':
                    $data['title'] = 'generateEmployeePayroll';
                    $data['content'] = 'HR/generateEmployeePayroll';
                    $data['mod'] = $type;
                    break;
                case 'approvedEmployeePayroll':
                    $data['title'] = 'approvedEmployeePayroll';
                    $data['content'] = 'HR/approvedEmployeePayroll';
                    $data['mod'] = $type;
                    break;
                case 'allowanceUncertain':
                    $data['title'] = 'allowanceUncertain';
                    $data['content'] = 'HR/allowanceUncertain';
                    $data['mod'] = $type;
                    break;
                case 'deductionUncertain':
                    $data['title'] = 'deductionUncertain';
                    $data['content'] = 'HR/deductionUncertain';
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
    public function getPresensiLog()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $locationid = $this->input->get("locationId");
        $db_oriskin = $this->load->database('oriskin', true);
        $selected_date = $this->input->get('date'); // Ambil tanggal dari AJAX

        if (!$selected_date) {
            echo json_encode(["error" => "Tanggal tidak ditemukan"]);
            return;
        }

        $queryTreatments = $db_oriskin->query("
        	EXEC [spEudoraClinicPresensiEmployee] ?, ?
    	", [$selected_date, $locationid]);

        echo json_encode([
            'presensiEmployees' => $queryTreatments->result(),
        ]);
    }

    public function getListLeavePermissionPending()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $userid = $this->session->userdata('userid');

        $pending_leaves = $db_oriskin->query(" 
            SELECT 
                l.*, 
                e.name AS employee_name, 
                lt.leavename,
                u.name AS user_name
            FROM leavepermission l
            JOIN msemployee e ON l.employeeid = e.id
            JOIN msemployeedetail ed ON e.id = ed.employeeid
            JOIN msleavetype lt ON l.leavetypeid = lt.id
            LEFT JOIN msuser u ON l.approved_by = u.id
            WHERE l.status = 0 AND ed.locationid IN (
            SELECT locationid FROM msuser_location_access 
            WHERE userid = $userid AND isactive = 1)
        ");


        $approved_leaves = $db_oriskin->query("
            SELECT 
                l.*, 
                e.name AS employee_name, 
                lt.leavename,
                u.name AS user_name
            FROM leavepermission l
            JOIN msemployee e ON l.employeeid = e.id
            JOIN msemployeedetail ed ON e.id = ed.employeeid
            JOIN msleavetype lt ON l.leavetypeid = lt.id
            LEFT JOIN msuser u ON l.approved_by = u.id
            WHERE l.status = 1 AND ed.locationid IN (
            SELECT locationid FROM msuser_location_access 
            WHERE userid = $userid AND isactive = 1)
        ");

        $rejected_leaves = $db_oriskin->query("
            SELECT 
                l.*, 
                e.name AS employee_name, 
                lt.leavename,
                u.name AS user_name
            FROM leavepermission l
            JOIN msemployee e ON l.employeeid = e.id
            JOIN msemployeedetail ed ON e.id = ed.employeeid
            JOIN msleavetype lt ON l.leavetypeid = lt.id
            LEFT JOIN msuser u ON l.approved_by = u.id
            WHERE l.status = 2 AND ed.locationid IN (
            SELECT locationid FROM msuser_location_access 
            WHERE userid = $userid AND isactive = 1)
        ");

        echo json_encode([
            'listRequestPending' => $pending_leaves->result_array(),
            'listRequestApproved' => $approved_leaves->result_array(),
            'listRequestRejected' => $rejected_leaves->result_array(),
        ]);
    }

    public function getListShift()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryTreatments = $db_oriskin->query("
        	SELECT * FROM msshift
    	");

        echo json_encode([
            'listShift' => $queryTreatments->result_array(),
        ]);
    }

    public function getListLeaveType()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryTreatments = $db_oriskin->query("
        	SELECT * FROM msleavetype
    	");

        echo json_encode([
            'listLeaveType' => $queryTreatments->result_array(),
        ]);
    }

    public function getListAllowanceType()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryTreatments = $db_oriskin->query("
        	SELECT * FROM msallowancetype
    	");

        echo json_encode([
            'allowanceType' => $queryTreatments->result_array(),
        ]);
    }

    public function getListDeductionType()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryTreatments = $db_oriskin->query("
        	SELECT * FROM msdeductiontype
    	");

        echo json_encode([
            'allowanceType' => $queryTreatments->result_array(),
        ]);
    }


    public function getSummaryPresensiEmployee()
    {

        $locationId = $this->input->get("locationId");
        $dateStart = $this->input->get("dateStart");
        $dateEnd = $this->input->get("dateEnd");
        $db_oriskin = $this->load->database('oriskin', true);

        $queryTreatments = $db_oriskin->query("
        	EXEC [spEudoraClinicSummaryPresensiEmployee] ?, ?, ?, ?
    	", [$dateStart, $dateEnd, $locationId, 1]);

        $queryDay = $db_oriskin->query("
        	EXEC [spEudoraClinicSummaryPresensiEmployee] ?, ?, ?, ?
    	", [$dateStart, $dateEnd, $locationId, 2]);

        $queryEmployee = $db_oriskin->query("
        	EXEC [spEudoraClinicSummaryPresensiEmployee] ?, ?, ?, ?
    	", [$dateStart, $dateEnd, $locationId, 3]);

        $queryType = $db_oriskin->query("
        	EXEC [spEudoraClinicSummaryPresensiEmployee] ?, ?, ?, ?
    	", [$dateStart, $dateEnd, $locationId, 5]);

        $queryTotal = $db_oriskin->query("
        	EXEC [spEudoraClinicSummaryPresensiEmployee] ?, ?, ?, ?
    	", [$dateStart, $dateEnd, $locationId, 4]);

        $queryTypeDeduction = $db_oriskin->query("
        	EXEC [spEudoraClinicSummaryPresensiEmployee] ?, ?, ?, ?
    	", [$dateStart, $dateEnd, $locationId, 6]);

        $queryTypeAllowance = $db_oriskin->query("
        	EXEC [spEudoraClinicSummaryPresensiEmployee] ?, ?, ?, ?
    	", [$dateStart, $dateEnd, $locationId, 7]);

        $queryDeductionEmployee = $db_oriskin->query("
        	EXEC [spEudoraClinicSummaryPresensiEmployee] ?, ?, ?, ?
    	", [$dateStart, $dateEnd, $locationId, 9]);

        $queryAllowanceEmployee = $db_oriskin->query("
        	EXEC [spEudoraClinicSummaryPresensiEmployee] ?, ?, ?, ?
    	", [$dateStart, $dateEnd, $locationId, 8]);

        echo json_encode([
            'presensiEmployees' => $queryTreatments->result_array(),
            'day' => $queryDay->result_array(),
            'employee' => $queryEmployee->result_array(),
            'type' => $queryType->result_array(),
            'summaryTotal' => $queryTotal->result_array(),
            'deductionType' => $queryTypeDeduction->result_array(),
            'allowanceType' => $queryTypeAllowance->result_array(),
            'allowance' => $queryAllowanceEmployee->result_array(),
            'deduction' => $queryDeductionEmployee->result_array(),
        ]);
    }



    public function createShiftEmployee()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $employeeid = $this->input->post('employeeId');
        $shiftid = $this->input->post('shiftId');
        $shiftdate = $this->input->post('shiftDate');

        if (!$employeeid || !$shiftid || !$shiftdate) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $db_oriskin->where('employeeid', $employeeid);
        $db_oriskin->where('shiftdate', $shiftdate);
        $query = $db_oriskin->get('employeeshift');

        if ($query->num_rows() > 0) {
            // Jika ada, update shiftid
            $db_oriskin->where('employeeid', $employeeid);
            $db_oriskin->where('shiftdate', $shiftdate);
            $update = $db_oriskin->update('employeeshift', [
                'shiftid' => $shiftid,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if ($update) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Shift berhasil diupdate',
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Gagal update shift',
                ]);
            }
        } else {
            // Jika tidak ada, insert baru
            $insert = $db_oriskin->insert('employeeshift', [
                'employeeid' => $employeeid,
                'shiftid' => $shiftid,
                'shiftdate' => $shiftdate,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if ($insert) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Shift berhasil ditambahkan',
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Gagal menambahkan shift',
                ]);
            }
        }

    }


    public function saveShift()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $post = $this->input->post();
        $userid = $this->session->userdata('userid');

        $shiftcode = $post['shiftcode'] ?? '';
        $shiftname = $post['shiftname'] ?? '';
        $timein = date('H:i:s', strtotime($post['timein'] ?? '00:00'));
        $timeout = date('H:i:s', strtotime($post['timeout'] ?? '00:00'));
        $isactive = isset($post['isactive']) ? 1 : 0;

        $sql = "INSERT INTO msshift (shiftcode, shiftname, timein, timeout, isactive, createdby, created_at)
				VALUES (?, ?, ?, ?, ?, ?, GETDATE())";

        $result = $db_oriskin->query($sql, [
            $shiftcode,
            $shiftname,
            $timein,
            $timeout,
            $isactive,
            $userid
        ]);

        if ($result) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);

        } else {
            $error = $db_oriskin->error();
            echo json_encode(['status' => 'error', 'message' => $error['message']]);
        }
    }

    public function createShift()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $shiftname = $this->input->post('shiftname');
        $shiftcode = $this->input->post('shiftcode');
        $timein = $this->input->post('timein');
        $timeout = $this->input->post('timeout');
        $isoff = $this->input->post('isoff');

        if (!$timeout || !$timein || !$shiftname || !$shiftcode) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $db_oriskin->select('shiftcode');
        $db_oriskin->from('msshift');
        $db_oriskin->where('shiftcode', $shiftcode);
        $shiftcodeCheck = $db_oriskin->get()->row('shiftcode');

        if ($shiftcodeCheck) {
            echo json_encode([
                'success' => false,
                'message' => 'Kode ini sudah ada',
            ]);
            return;
        }

        $updateData = [
            'shiftcode' => $shiftcode,
            'shiftname' => $shiftname,
            'timein' => $timein,
            'created_at' => date('Y-m-d H:i:s'),
            'createdby' => $this->session->userdata('userid'),
            'timeout' => $timeout,
            'isoff' => $isoff,
            'isactive' => 1
        ];

        $result = $this->ModelHr->createShift($updateData);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Data berhasil diinsert'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data gagal di insert',
            ]);
        }
    }

    public function updateShiftMaster()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $id = $this->input->post('id');
        $shiftname = $this->input->post('shiftname');
        $shiftcode = $this->input->post('shiftcode');
        $timein = $this->input->post('timein');
        $timeout = $this->input->post('timeout');
        $isactive = $this->input->post('isactive');
        $isoff = $this->input->post('isoff');

        if (!$shiftname || !$shiftcode || !$timein || !$timeout || !$id) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $updateData = [
            'shiftcode' => $shiftcode,
            'shiftname' => $shiftname,
            'timein' => $timein,
            'updatedate' => date('Y-m-d H:i:s'),
            'updatedby' => $this->session->userdata('userid'),
            'timeout' => $timeout,
            'isactive' => $isactive,
            'isoff' => $isoff
        ];

        $result = $this->ModelHr->updateShiftMaster($id, $updateData);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Data berhasil diinsert'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data gagal di insert',
            ]);
        }
    }

    public function getDetailShift($id)
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelHr->getDetailShift($id);

        if ($data) {
            $this->output->set_output(json_encode([
                'success' => true,
                'data' => $data
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Data not found'
            ]));
        }
    }

    public function getDetailLeaveType($id)
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelHr->getDetailLeaveType($id);

        if ($data) {
            $this->output->set_output(json_encode([
                'success' => true,
                'data' => $data
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Data not found'
            ]));
        }
    }

    public function getDetailAllowanceType($id)
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelHr->getDetailAllowanceType($id);

        if ($data) {
            $this->output->set_output(json_encode([
                'success' => true,
                'data' => $data
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Data not found'
            ]));
        }
    }


    public function getDetailDeductionType($id)
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelHr->getDetailDeductionType($id);

        if ($data) {
            $this->output->set_output(json_encode([
                'success' => true,
                'data' => $data
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Data not found'
            ]));
        }
    }

    public function createLeaveType()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $leavename = $this->input->post('leavename');
        $leavecode = $this->input->post('leavecode');
        $leavedescription = $this->input->post('leavedescription');
        $isdeductedquota = $this->input->post('isdeductedquota');
        $isdeductedsallary = $this->input->post('isdeductedsallary');

        if (!$leavename || !$leavecode) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $db_oriskin->select('leavecode');
        $db_oriskin->from('msleavetype');
        $db_oriskin->where('leavecode', $leavecode);
        $leavecodeCheck = $db_oriskin->get()->row('leavecode');

        if ($leavecodeCheck) {
            echo json_encode([
                'success' => false,
                'message' => 'Kode ini sudah ada',
            ]);
            return;
        }

        $updateData = [
            'leavename' => $leavename,
            'leavecode' => $leavecode,
            'leavedescription' => $leavedescription,
            'created_at' => date('Y-m-d H:i:s'),
            'createdby' => $this->session->userdata('userid'),
            'isdeductedquota' => $isdeductedquota,
            'isdeductedsallary' => $isdeductedsallary,
            'isactive' => 1
        ];

        $result = $this->ModelHr->createLeaveType($updateData);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Data berhasil diinsert'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data gagal di insert',
            ]);
        }
    }



    public function updateLeaveTypeMaster()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $id = $this->input->post('id');
        $leavename = $this->input->post('leavename');
        $leavecode = $this->input->post('leavecode');
        $leavedescription = $this->input->post('leavedescription');
        $isdeductedquota = $this->input->post('isdeductedquota');
        $isdeductedsallary = $this->input->post('isdeductedsallary');
        $isactive = $this->input->post('isactive');

        if (!$leavename || !$leavecode) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $updateData = [
            'leavename' => $leavename,
            'leavecode' => $leavecode,
            'leavedescription' => $leavedescription,
            'updatedate' => date('Y-m-d H:i:s'),
            'updatedby' => $this->session->userdata('userid'),
            'isdeductedquota' => $isdeductedquota,
            'isdeductedsallary' => $isdeductedsallary,
            'isactive' => $isactive
        ];

        $result = $this->ModelHr->updateLeaveTypeMaster($id, $updateData);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Data berhasil diinsert'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data gagal di insert',
            ]);
        }
    }


    public function updateAllowanceType()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $id = $this->input->post('id');
        $allowance_name = $this->input->post('allowance_name');
        $description = $this->input->post('description');
        $isactive = $this->input->post('isactive');

        if (!$allowance_name || !$description) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $updateData = [
            'allowance_name' => $allowance_name,
            'description' => $description,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('userid'),
            'isactive' => $isactive
        ];

        $result = $this->ModelHr->updateAllowanceType($id, $updateData);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Data berhasil diinsert'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data gagal di insert',
            ]);
        }
    }


    public function updateDeductionType()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $id = $this->input->post('id');
        $deduction_name = $this->input->post('deduction_name');
        $description = $this->input->post('description');
        $isactive = $this->input->post('isactive');

        if (!$deduction_name || !$description) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $updateData = [
            'deduction_name' => $deduction_name,
            'description' => $description,
            'updatedate' => date('Y-m-d H:i:s'),
            'updatedby' => $this->session->userdata('userid'),
            'isactive' => $isactive
        ];

        $result = $this->ModelHr->updateDeductionType($id, $updateData);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Data berhasil diinsert'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data gagal di insert',
            ]);
        }
    }

    public function addLeavePermission()
    {
        $status = $this->input->post('status');

        if ($status == 1) {
            $data = array(
                'employeeid' => $this->input->post('employeeid'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'leavetypeid' => $this->input->post('leavetypeid'),
                'description' => $this->input->post('description'),
                'status' => $status,
                'createdby' => $this->session->userdata('userid'),
                'created_at' => date('Y-m-d H:i:s'),
                'attachment' => null,
                'isactive' => 1,
                'approved_by' => $this->session->userdata('userid'),
                'approve_date' => date('Y-m-d H:i:s'),
            );
        } elseif ($status == 0) {
            $data = array(
                'employeeid' => $this->input->post('employeeid'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'leavetypeid' => $this->input->post('leavetypeid'),
                'description' => $this->input->post('description'),
                'status' => $status,
                'createdby' => $this->session->userdata('userid'),
                'created_at' => date('Y-m-d H:i:s'),
                'attachment' => null,
                'isactive' => 1
            );
        }


        $result = $this->ModelHr->addLeavePermission($data);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Data berhasil diinsert'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data gagal di insert',
            ]);
        }
    }

    public function searchEmployee()
    {
        $search = $this->input->get('search');
        $data = $this->ModelHr->searchEmployee($search);

        $result = [];
        foreach ($data as $row) {
            $result[] = [
                'id' => $row->id,
                'text' => "{$row->name} - {$row->nip} - {$row->jobname}",
                'data' => $row
            ];
        }
        echo json_encode($result);
    }


    public function updateStatusLeavePermission()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $id = $this->input->post('id');
        $status = $this->input->post('status');


        if (!$status || !$id) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        if ($status == 1) {
            $updateData = [
                'status' => $status,
                'approved_by' => $this->session->userdata('userid'),
                'approve_date' => date('Y-m-d H:i:s'),
            ];

        } elseif ($status == 2) {
            $updateData = [
                'status' => $status,
                'updatedby' => $this->session->userdata('userid'),
                'updatedate' => date('Y-m-d H:i:s'),
            ];
        }

        $result = $this->ModelHr->updateStatusLeavePermission($id, $updateData);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data gagal di diupdate',
            ]);
        }
    }


    public function createAllowanceType()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $allowance_name = $this->input->post('allowance_name');
        $description = $this->input->post('description');

        if (!$description || !$allowance_name) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $updateData = [
            'description' => $description,
            'allowance_name' => $allowance_name,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('userid'),
            'isactive' => 1
        ];

        $result = $this->ModelHr->createAllowanceType($updateData);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Data berhasil diinsert'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data gagal di insert',
            ]);
        }
    }


    public function createDeductionType()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $deduction_name = $this->input->post('deduction_name');
        $description = $this->input->post('description');

        if (!$description || !$deduction_name) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $updateData = [
            'description' => $description,
            'deduction_name' => $deduction_name,
            'created_at' => date('Y-m-d H:i:s'),
            'createdby' => $this->session->userdata('userid'),
            'isactive' => 1
        ];

        $result = $this->ModelHr->createDeductionType($updateData);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Data berhasil diinsert'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data gagal di insert',
            ]);
        }
    }


    public function updateEmployee()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        ob_start();
        $db_oriskin = $this->load->database('oriskin', true);
        $post = json_decode(file_get_contents('php://input'), true);

        if (!$post) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        $db_oriskin->trans_begin();
        $id = $post['id'];

        $data_hdr = [
            'locationid' => $post['locationid'],
            'jobid' => $post['jobid'],
            'enddate' => !empty($post['enddate']) ? $post['enddate'] : null,
            'startdate' => !empty($post['startdate']) ? $post['startdate'] : null,
            'accountnumber' => !empty($post['accountnumber']) ? $post['accountnumber'] : null,
            'address' => !empty($post['address']) ? $post['address'] : null
        ];

        $db_oriskin->where('employeeid', $id);
        $db_oriskin->update('msemployeedetail', $data_hdr);

        $dataHeader = [
            'isactive' => 1,
            'name' => $post['name'],
            'cellphonenumber' => $post['cellphonenumber'],
            'code' => !empty($post['nip']) ? $post['nip'] : null,
            'religionid' => !empty($post['religionid']) ? $post['religionid'] : null,
            'defaultshiftid' => !empty($post['defaultshiftid']) ? $post['defaultshiftid'] : null,
            'nik' => !empty($post['nik']) ? $post['nik'] : null,
            'nip' => !empty($post['nip']) ? $post['nip'] : null,
            'placeofbirth' => !empty($post['placeofbirth']) ? $post['placeofbirth'] : null,
            'sex' => !empty($post['sex']) ? $post['sex'] : null,
            'dateofbirth' => !empty($post['dateofbirth']) ? $post['dateofbirth'] : null,
            'sallary' => !empty($post['sallary']) ? $post['sallary'] : null,
            'isneedpresensi' => $post['isneedpresensi'],
            'companyid' => $post['companyId']
        ];

        $db_oriskin->where('id', $id);
        $updateHeader = $db_oriskin->update('msemployee', $dataHeader);

        if ($db_oriskin->trans_status() === FALSE) {
            $db_oriskin->trans_rollback();
            $response = ['status' => 'error', 'message' => 'Transaction failed'];
        } else {
            $db_oriskin->trans_commit();
            $response = ['status' => 'success', 'message' => 'Berhasil update data customer'];
        }

        echo json_encode($response);
        exit;
    }


    public function addEmployee()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        ob_start();
        $db_oriskin = $this->load->database('oriskin', true);
        $userid = $this->session->userdata('userid');
        $post = json_decode(file_get_contents('php://input'), true);

        if (!$post) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        $db_oriskin->trans_begin();

        $data_hdr = [
            'name' => $post['name'],
            'isactive' => $post['isactive'],
            'code' => $post['employeecode'],
            'companyid' => $post['companyId'],
            'updateuserid' => $userid,
            'defaultshiftid' => !empty($post['defaultshiftid']) ? $post['defaultshiftid'] : null,
            'religionid' => !empty($post['religionid']) ? $post['religionid'] : null,
            'cellphonenumber' => !empty($post['cellphonenumber']) ? $post['cellphonenumber'] : null,
            'nik' => !empty($post['nik']) ? $post['nik'] : null,
            'nip' => !empty($post['nip']) ? $post['nip'] : null,
            'placeofbirth' => !empty($post['placeofbirth']) ? $post['placeofbirth'] : null,
            'sex' => !empty($post['sex']) ? $post['sex'] : null,
            'dateofbirth' => !empty($post['dateofbirth']) ? $post['dateofbirth'] : null,
            'sallary' => !empty($post['sallary']) ? $post['sallary'] : null,
            'isneedpresensi' => $post['isneedpresensi'],
        ];

        $insert = $db_oriskin->insert('msemployee', $data_hdr);

        if ($insert) {
            $insert_id = $db_oriskin->insert_id();
            $data_dtl = [
                'jobid' => $post['jobid'],
                'employeeid' => $insert_id,
                'locationid' => $post['locationid'],
                'updateuserid' => $userid,
                'address' => !empty($post['address']) ? $post['address'] : null,
                'enddate' => !empty($post['enddate']) ? $post['enddate'] : null,
                'startdate' => !empty($post['startdate']) ? $post['startdate'] : null,
                'accountnumber' => !empty($post['accountnumber']) ? $post['accountnumber'] : null,
            ];
            $db_oriskin->insert('msemployeedetail', $data_dtl);
        }

        if ($db_oriskin->trans_status() === FALSE) {
            $db_oriskin->trans_rollback();
            $response = ['status' => 'error', 'message' => 'Transaction failed', 'data' => $data_hdr];
        } else {
            $db_oriskin->trans_commit();
            $response = ['status' => 'success', 'message' => 'Berhasil update data customer'];
        }

        echo json_encode($response);
        exit;
    }

    public function employeeAllowanceSave()
    {
        $user_id = $this->session->userdata('userid');

        $employeeid = $this->input->post('employeeid');
        $allowancetypeid = $this->input->post('allowancetypeid');
        $amount = $this->input->post('amount');

        if (!empty($allowancetypeid) && !empty($amount)) {
            foreach ($allowancetypeid as $index => $allowanceTypeId) {
                $amount = $amount[$index];
                $data = [
                    'allowancetypeid' => $allowanceTypeId,
                    'amount' => $amount,
                    'employeeid' => $employeeid,
                    'created_by' => $user_id
                ];
                $db_oriskin = $this->load->database('oriskin', true);
                $db_oriskin->insert('msallowance', $data);
            }

            $this->session->set_flashdata('success', 'Tunjangan berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Data tunjangan tidak lengkap.');
        }
    }

    public function searchEmployees()
    {
        $term = $this->input->get('search');
        $db_oriskin = $this->load->database('oriskin', TRUE);

        $results = $db_oriskin->select('
			msemployee.id, 
			msemployee.name AS employee_name, 
			msemployee.nip AS nip,
			msemployeedetail.locationid, 
			mslocation.name AS location_name
		')
            ->from('msemployee')
            ->join('msemployeedetail', 'msemployeedetail.employeeid = msemployee.id', 'left')
            ->join('mslocation', 'mslocation.id = msemployeedetail.locationid', 'left')
            ->group_start()
            ->like('msemployee.name', $term)
            ->or_like('msemployee.nip', $term)
            ->group_end()
            ->limit(20)
            ->get()
            ->result();

        $data = [];
        foreach ($results as $row) {
            $data[] = [
                'id' => $row->id,
                'text' => $row->employee_name . ' ( ' . $row->nip . ' )'
            ];
        }

        echo json_encode($data);
    }

    public function saveAllowanceMonthly()
    {
        $db_oriskin = $this->load->database('oriskin', TRUE);
        $user_id = $this->session->userdata('userid');
        $employeeid = $this->input->post('employeeid');


        $companyid = $db_oriskin->select('companyid')
            ->from('msemployee')
            ->where('id', $employeeid)
            ->get()
            ->row();
        $location = $db_oriskin->select('locationid')
            ->from('msemployeedetail')
            ->where('employeeid', $employeeid)
            ->get()
            ->row();

        $data = [
            'employeeid' => $this->input->post('employeeid'),
            'allowancetypeid' => $this->input->post('allowancetypeid'),
            'datestart' => $this->input->post('datestart'),
            'dateend' => $this->input->post('dateend') ?: null,
            'period' => $this->input->post('period'),
            'amount' => $this->input->post('amount'),
            'companyid' => $companyid->companyid,
            'locationid' => $location->locationid,
            'createbyid' => $user_id,
        ];

        try {
            $insert = $db_oriskin->insert('employeeallowancemonthly', $data);

            if ($insert) {
                echo json_encode(['status' => 'success']);
            } else {
                $error = $db_oriskin->error();
                echo json_encode(['status' => 'error', 'message' => $error['message']]);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function saveDeductionMonthly()
    {
        $db_oriskin = $this->load->database('oriskin', TRUE);
        $user_id = $this->session->userdata('userid');
        $employeeid = $this->input->post('employeeid');


        $companyid = $db_oriskin->select('companyid')
            ->from('msemployee')
            ->where('id', $employeeid)
            ->get()
            ->row();
        $location = $db_oriskin->select('locationid')
            ->from('msemployeedetail')
            ->where('employeeid', $employeeid)
            ->get()
            ->row();

        $data = [
            'employeeid' => $this->input->post('employeeid'),
            'deductiontypeid' => $this->input->post('deductiontypeid'),
            'datestart' => $this->input->post('datestart'),
            'dateend' => $this->input->post('dateend') ?: null,
            'period' => $this->input->post('period'),
            'amount' => $this->input->post('amount'),
            'companyid' => $companyid->companyid,
            'locationid' => $location->locationid,
            'createbyid' => $user_id,
        ];

        try {
            $insert = $db_oriskin->insert('employeedeductionmonthly', $data);

            if ($insert) {
                echo json_encode(['status' => 'success']);
            } else {
                $error = $db_oriskin->error();
                echo json_encode(['status' => 'error', 'message' => $error['message']]);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function get_allowance_all()
    {
        $this->load->model('ModelHr');

        // Ambil period dari GET, default null
        $period = $this->input->get('period');

        $data = $this->ModelHr->get_all_allowance($period);

        // Output json, pastikan header dan exit
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function get_deduction_all()
    {
        $this->load->model('ModelHr');

        // Ambil period dari GET, default null
        $period = $this->input->get('period');

        $data = $this->ModelHr->get_by_period_deduction($period);

        // Output json, pastikan header dan exit
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function get_allowance_detail()
    {
        $id = $this->input->get('id');
        if (empty($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID diperlukan']);
            return;
        }

        $row = $this->ModelHr->get_allowance_detail($id);

        header('Content-Type: application/json');
        if ($row) {
            echo json_encode($row);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Data tidak ditemukan']);
        }
    }

    public function get_deduction_detail()
    {
        $id = $this->input->get('id');
        if (empty($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID diperlukan']);
            return;
        }

        $row = $this->ModelHr->get_deduction_detail($id);

        header('Content-Type: application/json');
        if ($row) {
            echo json_encode($row);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Data tidak ditemukan']);
        }
    }

    public function get_deduction_types()
    {
        $db_oriskin = $this->load->database('oriskin', TRUE);
        $db_oriskin->select('id, deduction_name');
        $db_oriskin->from('mssalarydeductiontype');
        $query = $this->db_oriskin->get();

        header('Content-Type: application/json');
        echo json_encode($query->result_array());
    }

    public function update_allowance()
    {
        $id = $this->input->post('id');
        $allowancetypeid = $this->input->post('allowancetypeid');
        $datestart = $this->input->post('start_date');
        $dateend = $this->input->post('end_date');
        $amount = $this->input->post('amount');
        $period = $this->input->post('period');

        if (empty($id) || empty($datestart) || empty($amount)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
            return;
        }

        $data_update = [
            'datestart' => $datestart,
            'dateend' => $dateend ?: null,
            'amount' => $amount,
            'period' => $period
        ];

        $updated = $this->ModelHr->update_allowance($id, $data_update);

        header('Content-Type: application/json');
        if ($updated) {
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Gagal update data']);
        }
    }


    public function update_deduction()
    {
        $id = $this->input->post('id');
        $employeeid = $this->input->post('employeeid');
        $deductiontypeid = $this->input->post('deductiontypeid');
        $datestart = $this->input->post('start_date');
        $dateend = $this->input->post('end_date');
        $amount = $this->input->post('amount');
        $period = $this->input->post('period');

        if (empty($id) || empty($datestart) || empty($amount)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
            return;
        }

        $data_update = [
            'datestart' => $datestart,
            'dateend' => $dateend ?: null,
            'amount' => $amount,
            'period' => $period,
        ];

        $updated = $this->ModelHr->update_deduction($id, $data_update);

        header('Content-Type: application/json');
        if ($updated) {
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Gagal update data']);
        }
    }

    public function delete_allowance()
    {
        $id = $this->input->post('id');
        if (empty($id)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'ID diperlukan']);
            return;
        }

        $deleted = $this->ModelHr->delete_allowance($id);

        header('Content-Type: application/json');
        if ($deleted) {
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data']);
        }
    }

    public function get_salary_data()
    {
        $db_oriskin = $this->load->database('oriskin', TRUE);
        $employeeid = $this->input->post('employeeid');
        $period = $this->input->post('period');

        // Ambil allowance
        $allowance = $this->ModelHr->get_all_allowance_by_emp_period($employeeid, $period);

        // Ambil deduction
        $deduction = $this->ModelHr->get_all_deduction_by_emp_period($employeeid, $period);

        // Ambil salary
        $salaryData = $db_oriskin
            ->select('salary')
            ->from('msemployeedetail')
            ->where('employeeid', $employeeid)
            ->get()
            ->row_array();
        $salary = $salaryData ? $salaryData['salary'] : 0;

        echo json_encode([
            'allowance' => $allowance,
            'deduction' => $deduction,
            'salary' => $salary
        ]);
    }

    public function getDataSalary()
    {
        $selected_period = $this->input->get('period');
        $company_id = $this->input->get('companyid');

        $this->load->model('ModelHr');
        $data = $this->ModelHr->get_all_with_details($selected_period, $company_id);

        echo json_encode([
            'status' => 'success',
            'employees' => $data
        ]);
    }

    public function getListJob()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $data = $this->ModelHr->getListJob();

        echo json_encode([
            'listJobs' => $data,
        ]);
    }

    public function getJobById($id)
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelHr->getJobById($id);

        if ($data) {
            $this->output->set_output(json_encode([
                'success' => true,
                'data' => $data
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Data not found'
            ]));
        }
    }

    public function createJob()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $isactive = $this->input->post('isactive');

        if (!$name) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }
        $data = [
            'name' => $name,
            'isactive' => $isactive,
            'updateuserid' => $this->session->userdata('userid')
        ];

        if ($id) {
            $result = $this->ModelHr->updateJob($id, $data);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User berhasil diupdate',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'User gagal diupdate',
                    'data' => $data
                ]);
            }
        } else {
            $result = $this->ModelHr->createJob($data);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User berhasil dibuat',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'User gagal dibuat',
                    'data' => $data
                ]);
            }
        }
    }


    public function getListPublicHolidayCalender()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $data = $this->ModelHr->getListPublicHolidayCalender();

        echo json_encode([
            'listJobs' => $data,
        ]);
    }

    public function getListPublicHolidayCalenderById($id)
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelHr->getListPublicHolidayCalenderById($id);

        if ($data) {
            $this->output->set_output(json_encode([
                'success' => true,
                'data' => $data
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Data not found'
            ]));
        }
    }


    public function createPublicHolidayCalender()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $id = $this->input->post('id');
        $public_holiday_name = $this->input->post('public_holiday_name');
        $public_holiday_date = $this->input->post('public_holiday_date');
        $locationid = $this->input->post('locationid');
        $description = $this->input->post('description');
        $isactive = $this->input->post('isactive');

        if (!$public_holiday_name || !$public_holiday_date) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }
        $data = [
            'public_holiday_name' => $public_holiday_name,
            'public_holiday_date' => $public_holiday_date,
            'locationid' => $locationid,
            'description' => $description,
            'isactive' => $isactive
        ];

        if ($id) {
            $data['updated_by'] = $this->session->userdata('userid');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $result = $this->ModelHr->updatePublicHolidayCalender($id, $data);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User berhasil diupdate',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'User gagal diupdate',
                    'data' => $data
                ]);
            }
        } else {
            $data['created_by'] = $this->session->userdata('userid');
            $result = $this->ModelHr->createPublicHolidayCalender($data);
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User berhasil dibuat',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'User gagal dibuat',
                    'data' => $data
                ]);
            }
        }
    }

    public function addAllowanceEmployee()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        ob_start();
        $db_oriskin = $this->load->database('oriskin', true);
        $post = json_decode(file_get_contents('php://input'), true);

        if (!$post) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        $db_oriskin->trans_begin();

        foreach ($post['itemList'] as $items) {
            $data_hdr = [
                'allowancetypeid' => $items['allowanceid'],
                'amount' => $items['amountallowance'],
                'employeeid' => $post['employeeid'],
                'created_by' => $this->session->userdata('userid'),
                'isactive' => 1
            ];

            if ($post['employeeid']) {
                $exists = $this->ModelHr->checkAllowanceEmployee($post['employeeid'], $items['allowanceid']);
            }

            if ($exists) {
                $db_oriskin->where('allowancetypeid', $items['allowanceid']);
                $db_oriskin->where('employeeid', $post['employeeid']);
                $db_oriskin->update('msallowance', $data_hdr);
            } else {
                $db_oriskin->insert('msallowance', $data_hdr);
            }
        }

        if ($db_oriskin->trans_status() === FALSE) {
            $db_oriskin->trans_rollback();
            $response = ['status' => 'error', 'message' => 'Transaction failed'];
        } else {
            $db_oriskin->trans_commit();
            $response = ['status' => 'success', 'message' => 'Berhasil menambahkan tunjangan'];
        }

        echo json_encode($response);
        exit;
    }


    public function deleteTunjangan()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        ob_start();
        $db_oriskin = $this->load->database('oriskin', true);
        $post = json_decode(file_get_contents('php://input'), true);

        if (!$post) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        $db_oriskin->trans_begin();
        $id = $post['id'];

        $deleted_data = $db_oriskin->get_where('msallowance', ['id' => $id])->row_array();

        if (!$deleted_data) {
            throw new Exception('Data not found');
        }

        $db_oriskin->where('id', $id);
        $db_oriskin->update('msallowance', ['isactive' => 0]);

        if ($db_oriskin->trans_status() === FALSE) {
            $db_oriskin->trans_rollback();
            $response = ['status' => 'error', 'message' => 'Transaction failed'];
        } else {
            $db_oriskin->trans_commit();
            $response = ['status' => 'success', 'message' => 'Berhasil menambahkan stock out'];
        }

        echo json_encode($response);
        exit;
    }


    public function getAttandanceLogManual()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $data = $this->ModelHr->getAttandanceLogManual();

        echo json_encode([
            'listJobs' => $data,
        ]);
    }

    public function createAttandanceLogManual()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $id = $this->input->post('id');
        $employeeid = $this->input->post('employeeid');
        $employee_nip = $this->input->post('employee_nip');
        $attandance_date = $this->input->post('attandance_date');
        $check_in_time = $this->input->post('check_in_time');
        $check_out_time = $this->input->post('check_out_time');
        $description = $this->input->post('description');
        $isactive = $this->input->post('isactive');

        if (!$employeeid || !$employee_nip || !$attandance_date || !$check_in_time || !$check_out_time) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $data = [
            'employeeid' => $employeeid,
            'employee_nip' => $employee_nip,
            'attandance_date' => $attandance_date,
            'check_in_time' => $check_in_time,
            'check_out_time' => $check_out_time,
            'description' => $description,
            'isactive' => $isactive
        ];

        if ($id) {
            $data['updated_by'] = $this->session->userdata('userid');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $result = $this->ModelHr->updateAttandanceLogManual($id, $data);
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User berhasil diupdate',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'User gagal diupdate',
                    'data' => $data
                ]);
            }
        } else {
            $data['created_by'] = $this->session->userdata('userid');
            $result = $this->ModelHr->createAttandanceLogManual($data);
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User berhasil dibuat',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'User gagal dibuat',
                    'data' => $data
                ]);
            }
        }
    }


    public function getAttandanceLogManualById($id)
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelHr->getAttandanceLogManualById($id);

        if ($data) {
            $this->output->set_output(json_encode([
                'success' => true,
                'data' => $data
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Data not found'
            ]));
        }
    }


    public function generateSummaryAttandance()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $companyId = $this->input->get('companyid', TRUE);
        $month = $this->input->get('month', TRUE);

        if (!$companyId || !$month) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Parameter companyid dan month wajib diisi.'
            ]);
            return;
        }

        $company = $db_oriskin->select('*')
            ->from('mscompany')
            ->where('id', $companyId)
            ->get()
            ->row_array();

        $payrollGroups = $db_oriskin->get('mspayrollgroup')->result();

        if (empty($payrollGroups)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Payroll group tidak ditemukan untuk company ini.'
            ]);
            return;
        }

        $allResults = [];

        foreach ($payrollGroups as $group) {
            $periodStart = (int) $group->period_startdate;
            $periodEnd = $group->period_enddate ? (int) $group->period_enddate : null;
            $payrollId = $group->id;

            list($year, $monthNum) = explode('-', $month);
            $lastDay = date('t', strtotime("$month-01"));

            if (is_null($periodEnd)) {
                $dateStart = date('Y-m-d', strtotime("$month-$periodStart"));
                $dateEnd = date('Y-m-d', strtotime("$month-$lastDay"));
            } elseif ($periodStart > $periodEnd) {
                $prevMonth = date('Y-m', strtotime("$month-01 -1 month"));
                $dateStart = date('Y-m-d', strtotime("$prevMonth-$periodStart"));
                $dateEnd = date('Y-m-d', strtotime("$month-$periodEnd"));
            } else {
                $dateStart = date('Y-m-d', strtotime("$month-$periodStart"));
                $dateEnd = date('Y-m-d', strtotime("$month-$periodEnd"));
            }

            $sql = "
            EXEC spEudoraClinicSummaryPresensiEmployeeGenerate
                @DATESTART = '$dateStart',
                @DATEEND = '$dateEnd',
                @COMPANYID = $companyId,
                @PAYROLLID = $payrollId,
                @TYPE = 2
        ";
            $db_oriskin->query($sql);
        }

        list($year, $month) = explode('-', $month);
        $data = $this->ModelHr->employeePayroll($companyId, $month, $year);
        $grouped = [];
        foreach ($data as $row) {
            $pid = $row['payrollid'];
            if (!isset($grouped[$pid])) {
                $grouped[$pid] = [
                    'payrollid' => $pid,
                    'payroll_group' => $row['payroll_group'],
                    'companyname' => $row['companyname'],
                    'period_start' => $row['datestart'],
                    'period_end' => $row['dateend'],
                    'data' => []
                ];
            }
            $grouped[$pid]['data'][] = $row;
        }
        echo json_encode([
            'status' => 'success',
            'message' => 'Summary presensi berhasil digenerate untuk semua payroll group.',
            'results' => array_values($grouped)
        ]);
    }

    //SOME REVAMP
    public function listEmployeeCompany()
    {
        try {
            $isactive = $this->input->get('isactive', true);
            $locationid = $this->input->get('locationid', true);
            $employeeid = $this->input->get('employeeid', true);

            $data = $this->ModelHr->listEmployeeCompany($isactive, $locationid, $employeeid);

            echo json_encode([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getLocations()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $data = $db_oriskin->select('id, name')->from('mslocation')->get()->result_array();
        echo json_encode($data);
    }

    public function getCompany()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $data = $db_oriskin->select('id, companyname')->from('mscompany')->get()->result_array();
        echo json_encode($data);
    }

    public function searchEmployeeCompany()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $search = $this->input->get('search', TRUE);

        $data = $db_oriskin
            ->select('id, name')
            ->from('msemployee')
            ->like('name', $search)
            ->where('isdeleted', 0)
            ->get()
            ->result_array();

        echo json_encode($data);
    }


    public function getEmployeeDetail($id = null)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        // Jika edit, load data employee. Jika tambah, data kosong
        if ($id && $id != '0') {
            $data['employee'] = $this->ModelHr->editModalEmployee($id);
        } else {
            $data['employee'] = []; // Data kosong untuk tambah
        }

        $data['locationListt'] = $this->MApp->get_location_list_company();
        $data['jobList'] = $this->MApp->getJobList();
        $data['religionList'] = $this->MApp->getReligionList();
        $listShift = $db_oriskin->query("select * from msshift order by id")->result_array();
        $data['listShift'] = $listShift;
        $data['categoryTax'] = $db_oriskin->query("select * from mspayroll_taxcategory order by id")->result_array();

        $title = $id && $id != '0' ? 'Edit Karyawan' : 'Tambah Karyawan';
        $buttonText = $id && $id != '0' ? 'Simpan' : 'Tambah';

        $modal_data = [
            'modal_id' => 'employeeEditModal',
            'title' => $title,
            'modal_size' => 'modal-xl',
            'content' => $this->load->view('hr/employee/editForm', $data, TRUE),
            'footer' => '
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" onclick="saveEmployee(' . ($id ?? '0') . ')">' . $buttonText . '</button>
        '
        ];
        $this->load->view('component/modalEditDetailEmployee', $modal_data);
    }

    public function updateDataEmployeeDetail()
    {
        $this->load->library('form_validation');
        $db_oriskin = $this->load->database('oriskin', true);

        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('isneedpresensi', 'Need Presensi', 'required');
        $this->form_validation->set_rules('cellphonenumber', 'Handphone', 'required');
        $this->form_validation->set_rules('defaultshiftid', 'Default Shift', 'required');
        $this->form_validation->set_rules('locationid', 'Lokasi', 'required');
        $this->form_validation->set_rules('jobid', 'Job', 'required');
        $this->form_validation->set_rules('startdate', 'Tanggal Bergabung', 'required');
        $this->form_validation->set_rules('nip', 'NIP', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'success' => false,
                'errors' => $this->form_validation->error_array()
            ]);
            return;
        }

        // Check duplicate NIP (kecuali untuk data yang sedang diedit)
        $employee = $db_oriskin->select('*')
            ->from('msemployee')
            ->where('nip', $this->input->post('nip'))
            ->where('isdeleted', 0)
            ->get()
            ->row_array();

        $currentId = $this->input->post('id');

        if ($employee && $employee['id'] != $currentId) {
            echo json_encode([
                'success' => false,
                'errors' => ['Data dengan nip ini sudah ada di database']
            ]);
            return;
        }

        $data = [
            'nik' => $this->input->post('nik') ?: null,
            'name' => $this->input->post('name'),
            'sex' => $this->input->post('sex') ?: null,
            'placeofbirth' => $this->input->post('placeofbirth') ?: null,
            'dateofbirth' => $this->input->post('dateofbirth') ?: null,
            'cellphonenumber' => $this->input->post('cellphonenumber'),
            'nip' => $this->input->post('nip'),
            'isactive' => $this->input->post('isactive'),
            'isneedpresensi' => $this->input->post('isneedpresensi'),
            'defaultshiftid' => $this->input->post('defaultshiftid'),
            'religionid' => $this->input->post('religionid') ?: null,
            'taxcategoryid' => $this->input->post('taxcategoryid') ?: null,
            'bloodtype' => $this->input->post('bloodtype') ?: null,
            'isofficeemployee' => (int) $this->input->post('isofficeemployee') ?: 0,

            'email' => $this->input->post('email') ?: null,
            'bpjstknumber' => $this->input->post('bpjstknumber') ?: null,
            'bpjshealtnumber' => $this->input->post('bpjshealtnumber') ?: null,
            'updatedate' => date('Y-m-d H:i:s'),
            'updateuserid' => $this->session->userdata('userid')
        ];

        $dataDetail = [
            'jobid' => $this->input->post('jobid'),
            'locationid' => $this->input->post('locationid'),
            'startdate' => $this->input->post('startdate'),
            'enddate' => $this->input->post('enddate') ?: null,
            'address' => $this->input->post('address') ?: null,
            'accountnumber' => $this->input->post('accountnumber') ?: null,
            'npwp' => $this->input->post('npwp') ?: null,
            'updatedate' => date('Y-m-d H:i:s'),
            'updateuserid' => $this->session->userdata('userid')
        ];

        $db_oriskin->where('id', $currentId);
        $result = $db_oriskin->update('msemployee', $data);

        $db_oriskin->where('employeeid', $currentId);
        $resultdetail = $db_oriskin->update('msemployeedetail', $dataDetail);

        if ($result && $resultdetail) {
            echo json_encode([
                'success' => true,
                'employeeId' => $currentId,
                'employeeName' => $this->input->post('name')
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'errors' => ['Gagal mengupdate data karyawan']
            ]);
        }
    }

    public function createDataEmployeeDetail()
    {
        $this->load->library('form_validation');
        $db_oriskin = $this->load->database('oriskin', true);

        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('isneedpresensi', 'Need Presensi', 'required');
        $this->form_validation->set_rules('cellphonenumber', 'Handphone', 'required');
        $this->form_validation->set_rules('defaultshiftid', 'Default Shift', 'required');
        $this->form_validation->set_rules('locationid', 'Lokasi', 'required');
        $this->form_validation->set_rules('jobid', 'Job', 'required');
        $this->form_validation->set_rules('startdate', 'Tanggal Bergabung', 'required');
        $this->form_validation->set_rules('nip', 'NIP', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'success' => false,
                'errors' => $this->form_validation->error_array()
            ]);
            return;
        }

        $existingEmployee = $db_oriskin->select('*')
            ->from('msemployee')
            ->where('nip', $this->input->post('nip'))
            ->get()
            ->row_array();

        if ($existingEmployee) {
            echo json_encode([
                'success' => false,
                'errors' => ['Data dengan nip ini sudah ada di database']
            ]);
            return;
        }


        $data = [
            'nik' => $this->input->post('nik') ?: null,
            'name' => $this->input->post('name'),
            'sex' => $this->input->post('sex') ?: null,
            'placeofbirth' => $this->input->post('placeofbirth') ?: null,
            'dateofbirth' => $this->input->post('dateofbirth') ?: null,
            'cellphonenumber' => $this->input->post('cellphonenumber'),
            'nip' => $this->input->post('nip'),
            'isactive' => (int) $this->input->post('isactive'),
            'isneedpresensi' => (int) $this->input->post('isneedpresensi'),
            'defaultshiftid' => $this->input->post('defaultshiftid') ?: null,
            'religionid' => $this->input->post('religionid') ?: null,
            'taxcategoryid' => $this->input->post('taxcategoryid') ?: null,
            'bloodtype' => $this->input->post('bloodtype') ?: null,
            'isofficeemployee' => (int) $this->input->post('isofficeemployee') ?: 0,
            'email' => $this->input->post('email') ?: null,
            'bpjstknumber' => $this->input->post('bpjstknumber') ?: null,
            'bpjshealtnumber' => $this->input->post('bpjshealtnumber') ?: null,
            'updatedate' => date('Y-m-d H:i:s'),
            'updateuserid' => $this->session->userdata('userid')
        ];


        $insertEmployee = $db_oriskin->insert('msemployee', $data);
        $employeeId = $db_oriskin->insert_id();

        $error = $db_oriskin->error();
        $last_query = $db_oriskin->last_query();

        if (!$insertEmployee || !$employeeId) {
            $error = $db_oriskin->error();
            echo json_encode([
                'success' => false,
                'errors' => ['Gagal menambahkan data karyawan ke tabel utama'],
                'debug' => [
                    'insert_employee_failed' => true,
                    'db_error' => $error,
                    'last_query' => $last_query,
                    'employee_data' => $data
                ]
            ]);
            return;
        }


        $dataDetail = [
            'employeeid' => $employeeId,
            'jobid' => $this->input->post('jobid'),
            'locationid' => $this->input->post('locationid'),
            'startdate' => $this->input->post('startdate'),
            'enddate' => $this->input->post('enddate') ?: null,
            'address' => $this->input->post('address') ?: null,
            'accountnumber' => $this->input->post('accountnumber') ?: null,
            'npwp' => $this->input->post('npwp') ?: null,
            'updatedate' => date('Y-m-d H:i:s'),
            'updateuserid' => $this->session->userdata('userid')
        ];
        $resultdetail = $db_oriskin->insert('msemployeedetail', $dataDetail);
        if ($employeeId && $resultdetail) {
            echo json_encode([
                'success' => true,
                'employeeId' => $employeeId,
                'employeeName' => $this->input->post('name')
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'errors' => ['Gagal menambahkan data karyawan']
            ]);
        }
    }

    private function generateEmployeeCode()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $latest = $db_oriskin->select('code')
            ->from('msemployee')
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get()
            ->row_array();

        if ($latest && !empty($latest['code'])) {
            $numericPart = (int) substr($latest['code'], -6) + 1;
            return 'EMP' . str_pad($numericPart, 6, '0', STR_PAD_LEFT);
        } else {
            return 'EMP000001';
        }
    }


    public function getEmployeeCompany($id = null, $employeeid = null)
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $db_oriskin = $this->load->database('oriskin', true);

        $data['companyList'] = $db_oriskin->query("SELECT * FROM mscompany WHERE isactive = 1 ORDER BY companyname")->result_array();
        $data['departmentList'] = $db_oriskin->query("SELECT * FROM msdepartment WHERE isactive = 1 ORDER BY name")->result_array();
        $data['jobList'] = $this->MApp->getJobList();
        $data['employmentTypeList'] = $db_oriskin->query("SELECT * FROM msemploymenttype WHERE isactive = 1 ORDER BY name")->result_array();
        $data['salaryTypeList'] = $db_oriskin->query("SELECT * FROM mssalarytype WHERE isactive = 1 ORDER BY name")->result_array();
        $data['payrollGroupList'] = $db_oriskin->query("SELECT * FROM mspayrollgroup WHERE isactive = 1 ORDER BY groupname")->result_array();

        if ($id) {
            $companyData = $db_oriskin->query("SELECT * FROM employee_company WHERE id = ?", [$id])->row_array();
            $data['companyData'] = $companyData;
            $data['employeeid'] = $companyData['employeeid'];
        } else {
            $data['companyData'] = [];
            $data['employeeid'] = $employeeid;
        }

        $modal_data = [
            'modal_id' => 'companyModal',
            'title' => $id ? 'Edit Company' : 'Tambah Company',
            'modal_size' => 'modal-xl',
            'content' => $this->load->view('hr/employee/employeeCompanyForm', $data, TRUE),
            'footer' => '
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" onclick="saveCompany()">Simpan</button>
        '
        ];
        $this->load->view('component/modalEditDetailEmployee', $modal_data);
    }


    public function saveEmployeeCompany()
    {
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('employeeid', 'Employee ID', 'required');
        $this->form_validation->set_rules('companyid', 'Company', 'required');
        $this->form_validation->set_rules('jobid', 'Job', 'required');
        $this->form_validation->set_rules('employmenttypeid', 'Employment Type', 'required');
        $this->form_validation->set_rules('salarytypeid', 'Salary Type', 'required');
        $this->form_validation->set_rules('basesalary', 'Base Salary', 'required|numeric');
        $this->form_validation->set_rules('payrollgroupid', 'Payroll Group', 'required');
        $this->form_validation->set_rules('startdate', 'Start Date', 'required');
        $this->form_validation->set_rules('isactive', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'success' => false,
                'errors' => $this->form_validation->error_array()
            ]);
            return;
        }

        $db_oriskin = $this->load->database('oriskin', true);

        $data = [
            'employeeid' => $this->input->post('employeeid'),
            'companyid' => $this->input->post('companyid'),
            'departmentid' => $this->input->post('departmentid') ?: null,
            'jobid' => $this->input->post('jobid'),
            'employmenttypeid' => $this->input->post('employmenttypeid'),
            'salarytypeid' => $this->input->post('salarytypeid'),
            'basesalary' => $this->input->post('basesalary'),
            'payrollgroupid' => $this->input->post('payrollgroupid'),
            'startdate' => $this->input->post('startdate'),
            'enddate' => $this->input->post('enddate') ?: null,
            'isactive' => $this->input->post('isactive'),
            'is_bpjs_health_registered' => $this->input->post('is_bpjs_health_registered'),
            'is_bpjs_tk_registered' => $this->input->post('is_bpjs_tk_registered'),
            'updatedate' => date('Y-m-d H:i:s'),
            'updatedby' => $this->session->userdata('userid')
        ];

        $id = $this->input->post('id');

        if ($id) {
            $db_oriskin->where('id', $id);
            $result = $db_oriskin->update('employee_company', $data);
        } else {
            $data['createdate'] = date('Y-m-d H:i:s');
            $data['createdby'] = $this->session->userdata('userid');
            $result = $db_oriskin->insert('employee_company', $data);
        }

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode([
                'success' => false,
                'errors' => ['Gagal menyimpan data company']
            ]);
        }
    }



    public function getEmployeeAllowance($id = null, $employeeid = null, $companyid = null)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $data['allowanceTypeList'] = $db_oriskin->query("
        SELECT * FROM msallowancetype 
        ORDER BY isactive DESC, allowance_name
    ")->result_array();
        if ($id) {

            $allowance = $db_oriskin->query("
            SELECT a.*, e.name as employee_name, c.companyname 
            FROM msallowance a
            LEFT JOIN msemployee e ON a.employeeid = e.id
            LEFT JOIN mscompany c ON a.companyid = c.id
            WHERE a.id = ?
        ", [$id])->row_array();

            $data['allowance'] = $allowance;
            $data['employeeid'] = $allowance['employeeid'];
            $data['companyid'] = $allowance['companyid'];
            $data['employeeName'] = $allowance['employee_name'] ?? 'N/A';
            $data['companyName'] = $allowance['companyname'] ?? 'N/A';
        } else {
            $data['allowance'] = [];
            $data['employeeid'] = $employeeid;
            $data['companyid'] = $companyid;

            $employee = $db_oriskin->query("SELECT name FROM msemployee WHERE id = ?", [$employeeid])->row_array();
            $company = $db_oriskin->query("SELECT companyname FROM mscompany WHERE id = ?", [$companyid])->row_array();

            $data['employeeName'] = $employee['name'] ?? 'N/A';
            $data['companyName'] = $company['companyname'] ?? 'N/A';
        }

        $modal_data = [
            'modal_id' => 'allowanceModal',
            'title' => $id ? 'Edit Tunjangan' : 'Tambah Tunjangan',
            'modal_size' => 'modal-lg',
            'content' => $this->load->view('hr/employee/employeeAllowanceForm', $data, TRUE),
            'footer' => '
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" onclick="saveAllowance()">Simpan</button>
        '
        ];

        $this->load->view('component/modalEditDetailEmployee', $modal_data);
    }


    public function saveEmployeeAllowance()
    {
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('employeeid', 'Employee ID', 'required');
        $this->form_validation->set_rules('companyid', 'Company ID', 'required');
        $this->form_validation->set_rules('allowancetypeid', 'Jenis Tunjangan', 'required');
        $this->form_validation->set_rules('amount', 'Jumlah Tunjangan', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('isactive', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'success' => false,
                'errors' => $this->form_validation->error_array()
            ]);
            return;
        }

        $db_oriskin = $this->load->database('oriskin', true);

        $data = [
            'employeeid' => $this->input->post('employeeid'),
            'companyid' => $this->input->post('companyid'),
            'allowancetypeid' => $this->input->post('allowancetypeid'),
            'amount' => $this->input->post('amount'),
            'isactive' => $this->input->post('isactive'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('user_id')
        ];

        $id = $this->input->post('id');
        $existing = $db_oriskin->query("
        SELECT id FROM msallowance 
        WHERE employeeid = ? AND companyid = ? AND allowancetypeid = ? AND id != ?
    ", [
            $data['employeeid'],
            $data['companyid'],
            $data['allowancetypeid'],
            $id ?: 0
        ])->row_array();

        if ($existing) {
            echo json_encode([
                'success' => false,
                'errors' => ['Jenis tunjangan ini sudah ada untuk karyawan dan perusahaan yang sama']
            ]);
            return;
        }
        if ($id) {
            $db_oriskin->where('id', $id);
            $result = $db_oriskin->update('msallowance', $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('user_id');
            $result = $db_oriskin->insert('msallowance', $data);
        }
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode([
                'success' => false,
                'errors' => ['Gagal menyimpan data tunjangan']
            ]);
        }
    }


    public function deleteEmployeeCompanyById()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $this->output->set_content_type('application/json');

        $id = $this->input->post('id');

        if (!$id) {
            echo json_encode([
                'status' => 'error',
                'message' => 'ID tidak ditemukan'
            ]);
            exit;
        }
        
        $db_oriskin->where('id', $id);
        $delete = $db_oriskin->delete('employee_company');

        if ($delete) {
            echo json_encode([
                'status' => 'success',
                'message' => "Berhasil menghapus data karyawan"
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => "Gagal menghapus data",
                'db_error' => $db_oriskin->error()
            ]);
        }

        exit;
    }


    public function generatePayrollPreview()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $db = $this->load->database('oriskin', true);
        $companyId = $this->input->get('companyid', TRUE);
        $monthInput = $this->input->get('month', TRUE); // YYYY-MM

        if (!$companyId || !$monthInput) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Parameter companyid dan month wajib diisi.'
            ]);
            return;
        }

        // Extract year & month once only
        list($year, $monthNum) = explode('-', $monthInput);

        $company = $db->get_where('mscompany', ['id' => $companyId])->row_array();

        $payrollGroups = $db->get('mspayrollgroup')->result();
        if (empty($payrollGroups)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Payroll group tidak ditemukan.'
            ]);
            return;
        }

        $allResults = [];

        foreach ($payrollGroups as $group) {

            $periodStart = (int) $group->period_startdate;
            $periodEnd = $group->period_enddate ? (int) $group->period_enddate : null;
            $payrollId = $group->id;

            // Last day of month
            $lastDay = date("t", strtotime("$monthInput-01"));

            if (is_null($periodEnd)) {
                $dateStart = "$monthInput-0$periodStart";
                $dateEnd = "$monthInput-$lastDay";

            } elseif ($periodStart > $periodEnd) {
                $prev = date("Y-m", strtotime("$monthInput-01 -1 month"));
                $dateStart = "$prev-$periodStart";
                $dateEnd = "$monthInput-$periodEnd";

            } else {
                $dateStart = "$monthInput-$periodStart";
                $dateEnd = "$monthInput-$periodEnd";
            }

            // Call SP
            $sql = "
            EXEC spEudoraClinicSummaryPresensiEmployeeGenerate
                @DATESTART = '$dateStart',
                @DATEEND = '$dateEnd',
                @COMPANYID = $companyId,
                @PAYROLLID = $payrollId,
                @TYPE = 1
        ";

        // echo json_encode([
        //         'status' => 'error',
        //         'message' => $sql
        //     ]);

            $query = $db->query($sql);
            $rows = $query->result_array();

            // Extract JSON result correctly
            $jsonString = $rows[0]['JSON_RESULT'] ?? null;
            if (!$jsonString)
                continue;

            $jsonData = json_decode($jsonString, true);

            // Payroll array
            $payrollList = $jsonData['payroll'] ?? [];

            foreach ($payrollList as $p) {
                $allResults[] = $p;
            }
        }

        // Group by payroll group
        $grouped = [];
        foreach ($allResults as $row) {
            $pid = $row['payrollid'];

            if (!isset($grouped[$pid])) {
                $grouped[$pid] = [
                    'payrollid' => $pid,
                    'payroll_group' => $row['payroll_group'],
                    'companyname' => $row['companyname'],
                    'period_start' => $row['datestart'],
                    'period_end' => $row['dateend'],
                    'data' => []
                ];
            }

            $grouped[$pid]['data'][] = $row;
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Summary presensi berhasil digenerate.',
            'results' => array_values($grouped)
        ]);
    }


    public function generatePayroll()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $companyId = $this->input->get('companyid', TRUE);
        $month = $this->input->get('month', TRUE);

        if (!$companyId || !$month) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Parameter companyid dan month wajib diisi.'
            ]);
            return;
        }

        $company = $db_oriskin->select('*')
            ->from('mscompany')
            ->where('id', $companyId)
            ->get()
            ->row_array();

        $payrollGroups = $db_oriskin->get('mspayrollgroup')->result();

        if (empty($payrollGroups)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Payroll group tidak ditemukan untuk company ini.'
            ]);
            return;
        }

        $allResults = [];

        foreach ($payrollGroups as $group) {
            $periodStart = (int) $group->period_startdate;
            $periodEnd = $group->period_enddate ? (int) $group->period_enddate : null;
            $payrollId = $group->id;

            list($year, $monthNum) = explode('-', $month);
            $lastDay = date('t', strtotime("$month-01"));

            if (is_null($periodEnd)) {
                $dateStart = date('Y-m-d', strtotime("$month-$periodStart"));
                $dateEnd = date('Y-m-d', strtotime("$month-$lastDay"));
            } elseif ($periodStart > $periodEnd) {
                $prevMonth = date('Y-m', strtotime("$month-01 -1 month"));
                $dateStart = date('Y-m-d', strtotime("$prevMonth-$periodStart"));
                $dateEnd = date('Y-m-d', strtotime("$month-$periodEnd"));
            } else {
                $dateStart = date('Y-m-d', strtotime("$month-$periodStart"));
                $dateEnd = date('Y-m-d', strtotime("$month-$periodEnd"));
            }

            $sql = "
            EXEC spEudoraClinicSummaryPresensiEmployeeGenerate
                @DATESTART = '$dateStart',
                @DATEEND = '$dateEnd',
                @COMPANYID = $companyId,
                @PAYROLLID = $payrollId,
                @TYPE = 2
        ";
            $db_oriskin->query($sql);
        }

        list($year, $month) = explode('-', $month);
        $data = $this->ModelHr->employeePayroll($companyId, $month, $year);
        $grouped = [];
        foreach ($data as $row) {
            $pid = $row['payrollid'];
            if (!isset($grouped[$pid])) {
                $grouped[$pid] = [
                    'payrollid' => $pid,
                    'payroll_group' => $row['payroll_group'],
                    'companyname' => $row['companyname'],
                    'period_start' => $row['datestart'],
                    'period_end' => $row['dateend'],
                    'data' => []
                ];
            }
            $grouped[$pid]['data'][] = $row;
        }
        echo json_encode([
            'status' => 'success',
            'message' => 'Summary presensi berhasil digenerate untuk semua payroll group.',
            'results' => array_values($grouped)
        ]);
    }

    public function employeePayroll()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $companyId = $this->input->get('companyid', TRUE);
        $month = $this->input->get('month', TRUE);

        if (!$companyId || !$month) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Parameter companyid dan month wajib diisi.'
            ]);
            return;
        }

        list($year, $month) = explode('-', $month);
        $data = $this->ModelHr->employeePayroll($companyId, $month, $year);
        $grouped = [];
        foreach ($data as $row) {
            $pid = $row['payrollid'];
            if (!isset($grouped[$pid])) {
                $grouped[$pid] = [
                    'payrollid' => $pid,
                    'payroll_group' => $row['payroll_group'],
                    'companyname' => $row['companyname'],
                    'period_start' => $row['datestart'],
                    'period_end' => $row['dateend'],
                    'data' => []
                ];
            }
            $grouped[$pid]['data'][] = $row;
        }
        echo json_encode([
            'status' => 'success',
            'message' => 'Summary presensi berhasil digenerate untuk semua payroll group.',
            'results' => array_values($grouped)
        ]);
    }

    public function updatePaymentStatus()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $this->output->set_content_type('application/json');

        $id = $this->input->post('id');

        if (!$id) {
            echo json_encode([
                'status' => 'error',
                'message' => 'ID tidak ditemukan'
            ]);
            exit;
        }

        $data = [
            'status' => 'Paid'
        ];

        $db_oriskin->where('id', $id);
        $update = $db_oriskin->update('trpayroll', $data);

        if ($update) {
            echo json_encode([
                'status' => 'success',
                'message' => "Berhasil mengupdate status pembayaran"
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => "Gagal mengupdate status pembayaran",
                'db_error' => $db_oriskin->error()
            ]);
        }

        exit;
    }


    public function allowanceUncertain()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $companyId = $this->input->get('companyid', TRUE);
        $monthFilter = $this->input->get('month', TRUE);

        if (!$monthFilter) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Parameter companyid dan bulan wajib diisi.'
            ]);
            return;
        }

        list($year, $month) = explode('-', $monthFilter);
        $data = $this->ModelHr->allowanceUncertain($companyId, $month, $year);
        echo json_encode([
            'status' => 'success',
            'message' => 'Tunjangan tak tentu berhasil di tampilkan.',
            'month' => $monthFilter,
            'results' => array_values($data)
        ]);
    }



    public function getAllowanceUncertain($id = null, $month = null)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        if ($id && $id != '0') {
            $data['allowanceUncertain'] = $this->ModelHr->getAllowanceUncertain($id);
        } else {
            $data['allowanceUncertain'] = [];
        }

        $data["month"] = $month;
        $data['allowancetype'] = $db_oriskin->query("SELECT * FROM msallowancetype WHERE allowance_type = 'uncertain' ORDER BY id")->result_array();

        $title = $id && $id != '0' ? 'Edit Allowance' : 'Tambah Allowance';
        $buttonText = $id && $id != '0' ? 'Simpan' : 'Tambah';

        $modal_data = [
            'modal_id' => 'uncertainAllowanceModal',
            'title' => $title,
            'modal_size' => 'modal-lg',
            'content' => $this->load->view('hr/employee/allowanceUncertainForm', $data, TRUE),
            'footer' => '
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" onclick="saveAllowance(' . ($id ?? '0') . ')">' . $buttonText . '</button>
        '
        ];
        $this->load->view('component/modal', $modal_data);
    }


    public function searchEmployeeForUncertainAllowance()
    {
        $search = $this->input->get('search');
        $data = $this->ModelHr->searchEmployeeForUncertainAllowance($search);

        $result = [];
        foreach ($data as $row) {
            $result[] = [
                'id' => $row->id,
                'text' => "{$row->name} - {$row->nip} - {$row->jobname} - {$row->companyname}",
                'data' => $row
            ];
        }
        echo json_encode($result);
    }


    public function saveEmployeeAllowanceUncertain()
    {
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('employeeid', 'Employee ID', 'required');
        $this->form_validation->set_rules('companyid', 'Company ID', 'required');
        $this->form_validation->set_rules('allowanceid', 'Jenis Tunjangan', 'required');
        $this->form_validation->set_rules('amount', 'Jumlah Tunjangan', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('isactive', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'success' => false,
                'errors' => $this->form_validation->error_array()
            ]);
            return;
        }

        $db_oriskin = $this->load->database('oriskin', true);
        $monthInput = $this->input->post('month');

        list($year, $month) = explode('-', $monthInput);

        $allowancetype = $db_oriskin->select('*')
            ->from('msallowancetype')
            ->where('id', $this->input->post('allowanceid'))
            ->get()
            ->row_array();

        $allowancename = $allowancetype['allowance_name'] ?? null;

        $data = [
            'employeeid' => $this->input->post('employeeid'),
            'employeecompanyid' => $this->input->post('employeecompanyid'),
            'companyid' => $this->input->post('companyid'),
            'allowanceid' => $this->input->post('allowanceid'),
            'amount' => $this->input->post('amount'),
            'isactive' => $this->input->post('isactive'),
            'periodmonth' => $month,
            'periodyear' => $year,
            'allowancename' => $allowancename,
            'payrollid' => $this->input->post('payrollid'),
            'isfromgenerate' => 0,
            'description' => $this->input->post('description') ?: null,
        ];

        $id = $this->input->post('id');

        $existing = $db_oriskin->query("
                SELECT id FROM trpayroll_detail_allowance 
                WHERE employeeid = ? AND companyid = ? AND allowanceid = ? AND periodmonth = ? AND periodyear = ? AND payrollid = ? AND id != ?
            ", [
            $data['employeeid'],
            $data['companyid'],
            $data['allowanceid'],
            $data['periodmonth'],
            $data['periodyear'],
            $data['payrollid'],
            $id ?: 0
        ])->row_array();


        $existingPaid = $db_oriskin->query("
                SELECT id FROM trpayroll 
                WHERE employeeid = ? AND companyid = ? AND periodmonth = ? AND periodyear = ? AND payrollid = ? AND status = 'Paid'
            ", [
            $data['employeeid'],
            $data['companyid'],
            $data['periodmonth'],
            $data['periodyear'],
            $data['payrollid']
        ])->row_array();

        if ($existingPaid) {
            echo json_encode([
                'success' => false,
                'errors' => ['Data karyawan ini di bulan ini sudah di bayarkan tidak bisa menambah di bulan ini']
            ]);
            return;
        }

        if ($existing) {
            echo json_encode([
                'success' => false,
                'errors' => ['Jenis tunjangan ini sudah ada untuk karyawan dan perusahaan yang sama']
            ]);
            return;
        }

        if ($id) {
            $db_oriskin->where('id', $id);
            $result = $db_oriskin->update('trpayroll_detail_allowance', $data);
        } else {
            $result = $db_oriskin->insert('trpayroll_detail_allowance', $data);
        }
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode([
                'success' => false,
                'errors' => ['Gagal menyimpan data tunjangan'],
                'data' => $data
            ]);
        }
    }


    public function deductionUncertain()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $companyId = $this->input->get('companyid', TRUE);
        $monthFilter = $this->input->get('month', TRUE);

        if (!$monthFilter) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Parameter companyid dan bulan wajib diisi.'
            ]);
            return;
        }

        list($year, $month) = explode('-', $monthFilter);
        $data = $this->ModelHr->deductionUncertain($companyId, $month, $year);
        echo json_encode([
            'status' => 'success',
            'message' => 'Potongan tak tentu berhasil di tampilkan.',
            'month' => $monthFilter,
            'results' => array_values($data)
        ]);
    }




    public function getDeductionUncertain($id = null, $month = null)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        if ($id && $id != '0') {
            $data['deductionUncertain'] = $this->ModelHr->getDeductionUncertain($id);
        } else {
            $data['deductionUncertain'] = [];
        }

        $data["month"] = $month;
        $data['deductiontype'] = $db_oriskin->query("SELECT * FROM msdeductiontype ORDER BY id")->result_array();

        $title = $id && $id != '0' ? 'Edit Potongan' : 'Tambah Potongan';
        $buttonText = $id && $id != '0' ? 'Simpan' : 'Tambah';

        $modal_data = [
            'modal_id' => 'uncertainDeductionModal',
            'title' => $title,
            'modal_size' => 'modal-lg',
            'content' => $this->load->view('hr/employee/deductionUncertainForm', $data, TRUE),
            'footer' => '
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" onclick="saveDeduction(' . ($id ?? '0') . ')">' . $buttonText . '</button>
        '
        ];
        $this->load->view('component/modal', $modal_data);
    }


    public function saveEmployeeDeductionUncertain()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('employeeid', 'Employee ID', 'required');
        $this->form_validation->set_rules('companyid', 'Company ID', 'required');
        $this->form_validation->set_rules('deductionid', 'Jenis Tunjangan', 'required');
        $this->form_validation->set_rules('amount', 'Jumlah Tunjangan', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('isactive', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'success' => false,
                'errors' => $this->form_validation->error_array()
            ]);
            return;
        }

        $db_oriskin = $this->load->database('oriskin', true);
        $monthInput = $this->input->post('month');

        list($year, $month) = explode('-', $monthInput);

        $deductiontype = $db_oriskin->select('*')
            ->from('msdeductiontype')
            ->where('id', $this->input->post('deductionid'))
            ->get()
            ->row_array();

        $deductionname = $deductiontype['deduction_name'] ?? null;

        $data = [
            'employeeid' => $this->input->post('employeeid'),
            'employeecompanyid' => $this->input->post('employeecompanyid'),
            'companyid' => $this->input->post('companyid'),
            'deductionid' => $this->input->post('deductionid'),
            'amount' => $this->input->post('amount'),
            'isactive' => $this->input->post('isactive'),
            'periodmonth' => $month,
            'periodyear' => $year,
            'deductionname' => $deductionname,
            'payrollid' => $this->input->post('payrollid'),
            'isfromgenerate' => 0,
            'description' => $this->input->post('description') ?: null,
        ];

        $id = $this->input->post('id');

        $existing = $db_oriskin->query("
                SELECT id FROM trpayroll_detail_deduction 
                WHERE employeeid = ? AND companyid = ? AND deductionid = ? AND periodmonth = ? AND periodyear = ? AND payrollid = ? AND id != ?
            ", [
            $data['employeeid'],
            $data['companyid'],
            $data['deductionid'],
            $data['periodmonth'],
            $data['periodyear'],
            $data['payrollid'],
            $id ?: 0
        ])->row_array();


        $existingPaid = $db_oriskin->query("
                SELECT id FROM trpayroll 
                WHERE employeeid = ? AND companyid = ? AND periodmonth = ? AND periodyear = ? AND payrollid = ? AND status = 'Paid'
            ", [
            $data['employeeid'],
            $data['companyid'],
            $data['periodmonth'],
            $data['periodyear'],
            $data['payrollid']
        ])->row_array();

        if ($existingPaid) {
            echo json_encode([
                'success' => false,
                'errors' => ['Data karyawan ini di bulan ini sudah di bayarkan tidak bisa menambah di bulan ini']
            ]);
            return;
        }

        if ($existing) {
            echo json_encode([
                'success' => false,
                'errors' => ['Jenis tunjangan ini sudah ada untuk karyawan dan perusahaan yang sama']
            ]);
            return;
        }

        if ($id) {
            $db_oriskin->where('id', $id);
            $result = $db_oriskin->update('trpayroll_detail_deduction', $data);
        } else {
            $result = $db_oriskin->insert('trpayroll_detail_deduction', $data);
        }
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode([
                'success' => false,
                'errors' => ['Gagal menyimpan data tunjangan'],
                'data' => $data
            ]);
        }
    }
}


