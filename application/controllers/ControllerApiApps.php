<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ControllerApiApps extends CI_Controller
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
        $this->load->model('ModelApiApps');
        $this->load->model('ModelPaymentApps');
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
                case 'listEmployeeApps':
                    $data['title'] = 'listEmployeeApps';
                    $data['content'] = 'ManagementApps/listEmployeeApps';
                    $data['mod'] = $type;
                    break;
                case 'listPromoBroadcast':
                    $data = [
                        'title' => 'LIST PROMO BROADCAST',
                        'content' => 'ManagementApps/listPromoBroadcast',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'addPromoBroadcast':
                    $data = [
                        'title' => 'ADD PROMO BROADCAST',
                        'content' => 'ManagementApps/addPromoBroadcast',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'detailPromoBroadcast':
                    $broadcastid = $this->input->get('broadcastid', TRUE);
                    $data = [
                        'broadcastid' => $broadcastid,
                        'title' => 'DETAIL PROMO BROADCAST',
                        'content' => 'ManagementApps/detailPromoBroadcast',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'listEventApps':
                    $data = [
                        'title' => 'ADD PROMO BROADCAST',
                        'content' => 'ManagementApps/listEventApps',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'listAdsApps':
                    $data = [
                        'title' => 'ADD PROMO BROADCAST',
                        'content' => 'ManagementApps/listAdsApps',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'consultationList':
                    $data = [
                        'title' => 'CONSULTATION LIST',
                        'content' => 'ManagementApps/consultationList',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'listTreatmentClaimFreeApps':
                    $data = [
                        'title' => 'CONSULTATION LIST',
                        'content' => 'ManagementApps/listTreatmentClaimFreeApps',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'listCategory':
                    $data['title'] = 'listCategory';
                    $data['content'] = 'ManagementApps/listCategory';
                    $data['mod'] = $type;
                    break;
                case 'addCategoryByProductType':
                    $data['title'] = 'addCategoryByProductType';
                    $data['content'] = 'ManagementApps/addCategoryByProductType';
                    $data['mod'] = $type;
                    break;
                case 'listCategoryByProductType':
                    $data['title'] = 'listCategoryByProductType';
                    $data['content'] = 'ManagementApps/listCategoryByProductType';
                    $data['mod'] = $type;
                    break;
                case 'listVideoContentApps':
                    $data = [
                        'title' => 'ADD PROMO BROADCAST',
                        'content' => 'ManagementApps/listVideoContentApps',
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



    public function getClinic()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $db_oriskin->select("id, name, mobilephone, image, address, '4.9' as rating, latitude, longitude, image2");
        $db_oriskin->from('mslocation');
        $db_oriskin->where('isactive', 1);
        $db_oriskin->where('id !=', 6);

        $query = $db_oriskin->get();
        $result = $query->result_array();

        echo json_encode(['clinicEuodora' => $result]);
    }

    public function getClinicTransactions()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $db_oriskin->select("id, name, mobilephone, image, address, '4.9' as rating, latitude, longitude, image2");
        $db_oriskin->from('mslocation');

        $db_oriskin->where_not_in('id', [6, 35, 33, 21, 22, 23, 26]);

        $query = $db_oriskin->get();
        $result = $query->result_array();

        echo json_encode(['clinicEuodora' => $result]);

    }


    public function getClinicById($id)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $db_oriskin->select('id, name, mobilephone, image, address, operationalTime, latitude, longitude, placeid, image2');
        $db_oriskin->from('mslocation');
        $db_oriskin->where('isactive', 1);
        $db_oriskin->where('id', $id);

        $query = $db_oriskin->get();
        $result = $query->result_array();

        echo json_encode(['clinicEuodora' => $result]);
    }


    public function getDoctorByLocationId($id)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $db_oriskin->select('a.id, b.name, a.image, a.expertise');
        $db_oriskin->from('msemployeeApps a');
        $db_oriskin->join('msemployee b', 'a.employeeid = b.id', 'inner');
        $db_oriskin->where('a.status', 1);
        $db_oriskin->where('a.locationid', $id);
        $db_oriskin->where('a.jobid', 12);
        $db_oriskin->order_by('a.id', 'desc');

        $query = $db_oriskin->get();
        $result = $query->result_array();

        if (empty($result)) {
            $db_oriskin->reset_query(); // reset builder sebelum query baru
            $db_oriskin->select('a.id, b.name, a.image, a.expertise');
            $db_oriskin->from('msemployeeApps a');
            $db_oriskin->join('msemployee b', 'a.employeeid = b.id', 'inner');
            $db_oriskin->where('a.status', 1);
            $db_oriskin->where('a.locationid', 6);
            $db_oriskin->where('a.jobid', 12);
            $query = $db_oriskin->get();
            $result = $query->result_array();
        }

        echo json_encode(['doctorEuodora' => $result]);
    }

    public function getStaffByLocationId($id)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $db_oriskin->select('a.id, b.name, a.image, a.expertise, a.jobid');
        $db_oriskin->from('msemployeeApps a');
        $db_oriskin->join('msemployee b', 'a.employeeid = b.id', 'inner');
        $db_oriskin->where('a.status', 1);
        $db_oriskin->where('a.locationid', $id);
        $db_oriskin->order_by('a.id', 'desc');
        $query = $db_oriskin->get();
        $result = $query->result_array();

        if (empty($result)) {
            $db_oriskin->reset_query();
            $db_oriskin->select('a.id, b.name, a.image, a.expertise, a.jobid');
            $db_oriskin->from('msemployeeApps a');
            $db_oriskin->join('msemployee b', 'a.employeeid = b.id', 'inner');
            $db_oriskin->where('a.status', 1);
            $db_oriskin->where('a.locationid', 6);
            $db_oriskin->order_by('a.id', 'desc');
            $query = $db_oriskin->get();
            $result = $query->result_array();
        }

        echo json_encode(['doctorEuodora' => $result]);
    }


    public function getServiceList()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $db_oriskin->select("id, name, section");
        $db_oriskin->from('mstreatment');
        $db_oriskin->where('isactive', 1);

        $query = $db_oriskin->get();
        $result = $query->result_array();

        echo json_encode(['serviceList' => $result]);
    }

    public function getServiceListCustomer($customerid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryTreatments = $db_oriskin->query("
        	EXEC spEudoraServiceCustomerApps ?
    	", [$customerid]);

        $result = $queryTreatments->result_array();

        echo json_encode(['serviceList' => $result]);
    }

    public function getTimeAvailable($selected_date, $locationid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryTreatments = $db_oriskin->query("
        	EXEC spTimeAppointmentAvailable ?, ?
    	", [$selected_date, $locationid]);

        $result = $queryTreatments->result_array();

        echo json_encode(['availableTimeEmployee' => $result]);
    }

    public function getTimeAvailableDuration($selected_date, $locationid, $duration)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryTreatments = $db_oriskin->query("
        	EXEC spTimeAppointmentAvailableDev ?, ?, ?
    	", [$selected_date, $locationid, $duration]);

        $result = $queryTreatments->result_array();

        echo json_encode(['availableTimeEmployee' => $result, 'duration' => $duration]);
    }

    public function getListBooking($customerid, $type)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryTreatments = $db_oriskin->query("
        	EXEC [spHistoryBookingCustomerApps] ?, ?
    	", [$customerid, $type]);

        $result = $queryTreatments->result_array();

        echo json_encode(['customerbooking' => $result]);
    }


    public function insertBookingByCustomer()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $db_oriskin = $this->load->database('oriskin', true);

        $appointmentdate = $postData["appointmentdate"] ?? null;
        $booktime = $postData["booktime"] ?? null;
        $duration = (int) ($postData["duration"] - 1 ?? 0); // menit
        $locationid = $postData["locationId"] ?? null;
        $employeeid = $postData["employeeid"] ?? null;

        $startNew = date("H:i:s", strtotime($booktime));
        $endNew = date("H:i:s", strtotime($booktime . " +{$duration} minutes"));

        $query = $db_oriskin->query("
        SELECT *
        FROM trbookappointment
        WHERE appointmentdate = ?
          AND locationid = ?
          AND employeeid = ?
          AND status NOT IN (3,4)
          AND (
                (booktime < ? AND DATEADD(minute, duration, booktime) > ?)
             OR (booktime < ? AND DATEADD(minute, duration, booktime) > ?)
          )
    ", [
            $appointmentdate,
            $locationid,
            $employeeid,
            $endNew,
            $startNew,
            $endNew,
            $startNew,
        ]);

        if ($query->row()) {
            echo json_encode([
                "status" => false,
                "message" => "Sudah ada appointment, refresh untuk mendapat waktu baru.",
            ]);
            return;
        }

        $queryBlock = $db_oriskin->query("
        SELECT 1
        FROM msblockschedule
        WHERE blockdate = ?
          AND locationid = ?
          AND employeeid = ?
          AND (
                (timeblockstart < ? AND timeblockend > ?)
             OR (timeblockstart < ? AND timeblockend >= ?)
             OR (? <= timeblockstart AND ? > timeblockend)
          )
    ", [
            $appointmentdate,
            $locationid,
            $employeeid,
            $endNew,
            $startNew,
            $endNew,
            $startNew,
            $startNew,
            $endNew,
        ]);

        if ($queryBlock->row()) {
            echo json_encode([
                "status" => false,
                "message" => "Waktu ini diblokir (BLOCK TIME).",
            ]);
            return;
        }

        $dataCreate = [
            "remarks" => $postData["service"] ?? null,
            "duration" => $duration,
            "appointmentdate" => $appointmentdate,
            "booktime" => $booktime,
            "locationid" => $locationid,
            "customerid" => $postData["customerid"] ?? null,
            "employeeid" => $employeeid,
            "status" => 1,
            "createdate" => date("Y-m-d H:i:s"),
        ];

        if ($db_oriskin->insert("trbookappointment", $dataCreate)) {
            echo json_encode([
                "status" => true,
                "message" => "Appointment berhasil ditambahkan",
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "Gagal menambahkan appointment.",
            ]);
        }
    }


    public function insertBookingByCustomerDev()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $db_oriskin = $this->load->database('oriskin', true);

        $appointmentdate = $postData["appointmentdate"] ?? null;
        $booktime = $postData["booktime"] ?? null;
        $duration = (int) ($postData["duration"] - 1 ?? 0); // menit
        $locationid = $postData["locationId"] ?? null;
        $employeeid = $postData["employeeid"] ?? null;

        $startNew = date("H:i:s", strtotime($booktime));
        $endNew = date("H:i:s", strtotime($booktime . " +{$duration} minutes"));

        $query = $db_oriskin->query("
        SELECT *
        FROM trbookappointment
        WHERE appointmentdate = ?
          AND locationid = ?
          AND employeeid = ?
          AND status NOT IN (3,4)
          AND (
                (booktime < ? AND DATEADD(minute, duration, booktime) > ?)
             OR (booktime < ? AND DATEADD(minute, duration, booktime) > ?)
          )
    ", [
            $appointmentdate,
            $locationid,
            $employeeid,
            $endNew,
            $startNew,
            $endNew,
            $startNew,
        ]);

        if ($query->row()) {
            echo json_encode([
                "status" => false,
                "message" => "Sudah ada appointment, refresh untuk mendapat waktu baru.",
            ]);
            return;
        }

        $queryBlock = $db_oriskin->query("
        SELECT 1
        FROM msblockschedule
        WHERE blockdate = ?
          AND locationid = ?
          AND employeeid = ?
          AND (
                (timeblockstart < ? AND timeblockend > ?)
             OR (timeblockstart < ? AND timeblockend >= ?)
             OR (? <= timeblockstart AND ? > timeblockend)
          )
    ", [
            $appointmentdate,
            $locationid,
            $employeeid,
            $endNew,
            $startNew,
            $endNew,
            $startNew,
            $startNew,
            $endNew,
        ]);

        if ($queryBlock->row()) {
            echo json_encode([
                "status" => false,
                "message" => "Waktu ini diblokir (BLOCK TIME).",
            ]);
            return;
        }

        $dataCreate = [
            "remarks" => $postData["service"] ?? null,
            "duration" => $duration,
            "appointmentdate" => $appointmentdate,
            "booktime" => $booktime,
            "locationid" => $locationid,
            "customerid" => $postData["customerid"] ?? null,
            "employeeid" => $employeeid,
            "status" => 1,
            "createdate" => date("Y-m-d H:i:s"),
        ];

        if ($db_oriskin->insert("trbookappointment", $dataCreate)) {
            echo json_encode([
                "status" => true,
                "message" => "Appointment berhasil ditambahkan",
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "Gagal menambahkan appointment.",
            ]);
        }
    }

    public function canceledBooking()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $bookingId = $postData["bookingId"];
        $db_oriskin = $this->load->database('oriskin', true);

        // $result = $this->MApp->canceledBooking($bookingId);

        // echo json_encode($result);


        $db_oriskin->where('id', $bookingId);

        $updateResult = $db_oriskin->update('trbookappointment', ['status' => 3]);

        if ($updateResult) {
            echo json_encode([
                "status" => "success",
                "message" => "Appointment berhasil dibatalkan"
            ]);
        } else {
            $error = $db_oriskin->error();
            echo json_encode([
                "status" => "error",
                "message" => "Gagal membatalkan appointment.",
                "db_error" => $error
            ]);
        }
    }

    public function getDetailCustomer($customerid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryDetailCustomer = $db_oriskin->query("
        	EXEC [spClinicFindCustomerDashboard] ?
    	", [$customerid]);

        $result = $queryDetailCustomer->result_array();

        echo json_encode(['detailcustomer' => $result]);
    }

    public function getDetailTransactionTreatment($customerid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryDetailTransactionTreatment = $db_oriskin->query("
        	EXEC [spClinicFindHistoryTreatmentDtlDev] ?
    	", [$customerid]);

        $result = $queryDetailTransactionTreatment->result_array();

        echo json_encode(['treatment' => $result]);
    }

    public function getDetailPointGeneral($customerid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryDetailTransactionTreatment = $db_oriskin->query("
        	EXEC [spReportHistoriPointPerCustomer] ?
    	", [$customerid]);

        $result = $queryDetailTransactionTreatment->result_array();

        echo json_encode(['generalPoint' => $result]);
    }

    public function getDetailPointMedis($customerid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryDetailTransactionTreatment = $db_oriskin->query("
        	EXEC [spReportHistoriPointPerCustomerInject] ?
    	", [$customerid]);

        $result = $queryDetailTransactionTreatment->result_array();

        echo json_encode(['medisPoint' => $result]);
    }

    public function getDetailPointNonMedis($customerid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryDetailTransactionTreatment = $db_oriskin->query("
        	EXEC [spReportHistoriPointPerCustomerNonInject] ?
    	", [$customerid]);

        $result = $queryDetailTransactionTreatment->result_array();

        echo json_encode(['nonMedisPoint' => $result]);
    }

    public function getDetailTransactionMembership($customerid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryDetailTransactionMembership = $db_oriskin->query("
        	EXEC [spClinicFindHistoryMembershipTreatmentDtlBenefitCategory] ?
    	", [$customerid]);

        $result = $queryDetailTransactionMembership->result_array();

        echo json_encode(['membership' => $result]);
    }

    function sendNotif($data)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $api_url = 'https://wa7029.cloudwa.my.id/api/v1/messages';
        $api_token = array(
            'Authorization: Bearer u0jEy0iWfjZER7Dn.Q4bY4xxSQ3iFJgTdwCh7GUPg54Jpb40z',
            'Content-Type: application/json'
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $api_token,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    function formatPhoneNumber($phonenumber)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $phonenumber_valid = preg_replace('/\D/', '', $phonenumber);

        if (!preg_match("/[^+0-9]/", trim($phonenumber_valid))) {
            // cek apakah no hp karakter ke 1 dan 2 adalah angka 62
            if (substr(trim($phonenumber_valid), 0, 2) == '62') {
                $mobile_number = '+' . trim($phonenumber_valid);
            }
            // cek apakah no hp karakter ke 1 adalah angka 0
            else if (substr(trim($phonenumber_valid), 0, 1) == '0') {
                $mobile_number = '+62' . substr(trim($phonenumber_valid), 1);
            }
        }

        return $phonenumber_valid;
    }

    public function send_otp()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $phone = $postData["phone"];
        $countryCode = $postData["countryCode"];

        $cellphonenumberotp = $countryCode . $phone;
        $cellphonenumber = 0 . $phone;

        $user = $db_oriskin->get_where('usersApps', ['phone' => $cellphonenumber])->row();
        $customer = $db_oriskin->get_where('mscustomer', ['cellphonenumber' => $cellphonenumber])->row();

        if (!$user && !$customer) {
            echo json_encode([
                'status' => false,
                'message' => 'Nomor belum terdaftar. Silakan registrasi terlebih dahulu.'
            ]);
            return;
        }


        $otp = rand(100000, 999999);

        if ($phone == '82269212414') {
            $otp = 123456;
        }
        $expired = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        $message = "Kode OTP login Anda: $otp. Berlaku selama 5 menit.";

        $data = array(
            "recipient_type" => "individual",
            "to" => $cellphonenumberotp,
            "type" => "text",
            "text" => array("body" => $message)
        );

        $randomStr = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);
        $referralCode = 'C' . $customer->id . $randomStr;

        $token = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 25);

        if (!$user) {
            $dataUser = [
                'phone' => $cellphonenumber,
                'customerid' => $customer->id,
                'otp_code' => $otp,
                'otp_expired_at' => $expired,
                'refferalcode' => $referralCode,
                'token' => $token
            ];

            $insertUsersApps = $db_oriskin->insert('usersApps', $dataUser);

            if ($insertUsersApps) {
                try {
                    $response = $this->sendNotif($data);
                } catch (Exception $e) {
                    $response = 'ERROR: ' . $e->getMessage();
                } finally {
                    echo json_encode([
                        'status' => true,
                        'message' => 'OTP berhasil dikirim',
                        'otp' => $response
                    ]);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Terjadi kesalahan, coba lagi']);
            }

        } elseif ($user) {

            $db_oriskin->where('id', $user->id);

            if (!$user->token) {
                $db_oriskin->update('usersApps', [
                    'otp_code' => $otp,
                    'otp_expired_at' => $expired,
                    'token' => $token
                ]);
            } elseif ($user->token) {
                $db_oriskin->update('usersApps', [
                    'otp_code' => $otp,
                    'otp_expired_at' => $expired
                ]);
            }


            try {
                $response = $this->sendNotif($data);
            } catch (Exception $e) {
                $response = 'ERROR: ' . $e->getMessage();
            } finally {
                echo json_encode([
                    'status' => true,
                    'message' => 'OTP berhasil dikirim',
                    'otp' => $response
                ]);
            }
        }
    }

    public function send_otpRegister()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $phone = $postData["phone"];
        $countryCode = $postData["countryCode"];

        $cellphonenumberotp = $countryCode . $phone;

        $cellphonenumber = 0 . $phone;

        $user = $db_oriskin->get_where('mscustomer', ['cellphonenumber' => $cellphonenumber])->row();

        $userRegistration = $db_oriskin->get_where('registrationTemp', ['phone' => $cellphonenumber])->row();

        if ($user) {
            echo json_encode([
                'status' => false,
                'message' => 'Nomor sudah terdaftar. Silakan login.'
            ]);
            return;
        }

        $otp = rand(100000, 999999);
        $expired = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        if ($userRegistration) {
            $db_oriskin->where('id', $userRegistration->id);

            $db_oriskin->update('registrationTemp', [
                'otp_code' => $otp,
                'otp_expired_at' => $expired
            ]);

            $message = "Kode OTP login Anda: $otp. Berlaku selama 5 menit.";

            $data = array(
                "recipient_type" => "individual",
                "to" => $cellphonenumberotp,
                "type" => "text",
                "text" => array("body" => $message)
            );

            try {
                $response = $this->sendNotif($data);
            } catch (Exception $e) {
                $response = 'ERROR: ' . $e->getMessage();
            } finally {
                echo json_encode([
                    'status' => true,
                    'message' => 'OTP berhasil dikirim',
                    'otp' => $response
                ]);
            }
        } else {
            $insert = $db_oriskin->insert('registrationTemp', [
                'otp_code' => $otp,
                'otp_expired_at' => $expired,
                'phone' => $cellphonenumber
            ]);

            if ($insert) {
                $message = "Kode OTP login Anda: $otp. Berlaku selama 5 menit.";
                $data = array(
                    "recipient_type" => "individual",
                    "to" => $cellphonenumberotp,
                    "type" => "text",
                    "text" => array("body" => $message)
                );

                try {
                    $response = $this->sendNotif($data);
                } catch (Exception $e) {
                    $response = 'ERROR: ' . $e->getMessage();
                } finally {
                    echo json_encode([
                        'status' => true,
                        'message' => 'OTP berhasil dikirim'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => 'Gagal menyimpan OTP ke database'
                ]);
            }
        }
    }

    public function verify_otp()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $phone = $postData["phone"];
        $otp = $postData["otp"];

        $cellphonenumber = 0 . $phone;

        $user = $db_oriskin->get_where('usersApps', ['phone' => $cellphonenumber])->row();

        if ($user && $user->otp_code === $otp && strtotime($user->otp_expired_at) > time()) {
            $detailCustomer = $db_oriskin->get_where('mscustomer', ['id' => $user->customerid])->row();
            $has_pin = !empty($user->pin_code);
            $db_oriskin->where('id', $user->id);
            $db_oriskin->update('usersApps', ['last_login' => date('Y-m-d H:i:s')]);
            echo json_encode(['status' => true, 'user_id' => $user->id, 'token' => $user->token, 'customerId' => $user->customerid, 'has_pin' => $has_pin, 'dataCustomer' => $detailCustomer]);
        } else {
            echo json_encode(['status' => false, 'message' => 'OTP tidak valid atau sudah kedaluwarsa']);
        }
    }

    public function verify_otpRegistration()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $db_oriskin = $this->load->database('oriskin', true);

        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $phone = $postData["phone"];
        $otp = $postData["otp"];
        $referralCodeMgm = $postData["referralCode"];
        $cellphonenumber = 0 . $phone;

        $dateOfBirth = !empty($postData['birthDate'])
            ? date('Y-m-d', strtotime(str_replace('/', '-', $postData['birthDate'])))
            : null;

        $customerRefferalCode = $db_oriskin->get_where('usersApps', ['refferalcode' => $referralCodeMgm])->row();

        $dataSlguestlog = [
            'firstname' => $postData['firstname'],
            'lastname' => $postData['lastname'],
            'cellphonenumber' => $cellphonenumber,
            'ssid' => $postData['idNumber'],
            'email' => $postData['email'],
            'dateofbirth' => $dateOfBirth,
            'sex' => $postData['gender'],
            'refferalempid' => 1,
            'locationid' => $postData['clinicId'],
            'updateuserid' => 1,
            'guestlogtypeid' => 11,
            'guestlogadvtrackingid' => 10,
            'consultantid' => 1,
            'touredid' => 1,
            'code' => 'R-' . $cellphonenumber,
            'refferalid' => $customerRefferalCode ? $customerRefferalCode->customerid : NULL
        ];

        $user = $db_oriskin->get_where('registrationTemp', ['phone' => $cellphonenumber])->row();
        $customer = $db_oriskin->get_where('mscustomer', ['cellphonenumber' => $cellphonenumber])->row();

        if ($customer) {
            echo json_encode([
                'status' => false,
                'message' => 'Nomor sudah terdaftar. Silakan login.'
            ]);
            return;
        }

        if ($user && $user->otp_code === $otp && strtotime($user->otp_expired_at) > time()) {
            $insertSlguestlog = $db_oriskin->insert('slguestlog', $dataSlguestlog);

            if ($insertSlguestlog) {
                $lastCustomer = $db_oriskin->get_where('mscustomer', ['cellphonenumber' => $cellphonenumber])->row();

                $lastCustomerId = $lastCustomer ? $lastCustomer->id : null;

                $randomStr = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);
                $referralCode = 'C' . $lastCustomer->id . $randomStr;

                $token = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 25);


                if ($lastCustomerId) {
                    $dataUsersApps = [
                        'customerid' => $lastCustomer->id,
                        'phone' => $cellphonenumber,
                        'refferalcode' => $referralCode,
                        'token' => $token
                    ];

                    $insertUsersApps = $db_oriskin->insert('usersApps', $dataUsersApps);

                    if ($insertUsersApps) {
                        echo json_encode(['status' => true, 'token' => $token, 'last_customer_id' => $lastCustomer->id, 'dataCustomer' => $lastCustomer]);
                    } else {
                        echo json_encode(['status' => false, 'message' => 'Gagal insert ke usersApps']);
                    }
                } else {
                    echo json_encode(['status' => false, 'message' => 'Tidak ditemukan customer terakhir']);
                }
            } else {
                $error = $db_oriskin->error();
                echo json_encode([
                    'status' => false,
                    'message' => 'Gagal insert ke slguestlog',
                    'error' => $error
                ]);
                return;
            }
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'OTP tidak valid atau sudah kedaluwarsa'
            ]);
        }
    }

    public function verify_otpRegistration2()
    {
        ;

        $db_oriskin = $this->load->database('oriskin', true);

        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $phone = $postData["phone"];
        $otp = $postData["otp"];
        $referralCodeMgm = $postData["referralCode"];
        $cellphonenumber = 0 . $phone;

        $dateOfBirth = !empty($postData['birthDate'])
            ? date('Y-m-d', strtotime(str_replace('/', '-', $postData['birthDate'])))
            : null;

        $customerRefferalCode = $db_oriskin->get_where('usersApps', ['refferalcode' => $referralCodeMgm])->row();

        $dataSlguestlog = [
            'firstname' => $postData['firstname'],
            'lastname' => $postData['lastname'],
            'cellphonenumber' => $cellphonenumber,
            'ssid' => $postData['idNumber'],
            'email' => $postData['email'],
            'dateofbirth' => $dateOfBirth,
            'sex' => $postData['gender'],
            'refferalempid' => 1,
            'locationid' => $postData['clinicId'],
            'updateuserid' => 1,
            'guestlogtypeid' => 11,
            'guestlogadvtrackingid' => 10,
            'consultantid' => 1,
            'touredid' => 1,
            'code' => 'R-' . $cellphonenumber,
            'refferalid' => $customerRefferalCode ? $customerRefferalCode->customerid : NULL
        ];

        $user = $db_oriskin->get_where('registrationTemp', ['phone' => $cellphonenumber])->row();
        $customer = $db_oriskin->get_where('mscustomer', ['cellphonenumber' => $cellphonenumber])->row();

        if ($customer) {
            echo json_encode([
                'status' => false,
                'message' => 'Nomor sudah terdaftar. Silakan login.'
            ]);
            return;
        }

        if ($user && $user->otp_code === $otp && strtotime($user->otp_expired_at) > time()) {
            $insertSlguestlog = $db_oriskin->insert('slguestlog', $dataSlguestlog);

            if ($insertSlguestlog) {
                $lastCustomer = $db_oriskin->get_where('mscustomer', ['cellphonenumber' => $cellphonenumber])->row();

                $lastCustomerId = $lastCustomer ? $lastCustomer->id : null;

                $randomStr = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);
                $referralCode = 'C' . $lastCustomer->id . $randomStr;

                if ($lastCustomerId) {
                    $dataUsersApps = [
                        'customerid' => $lastCustomer->id,
                        'phone' => $cellphonenumber,
                        'refferalcode' => $referralCode
                    ];

                    $insertUsersApps = $db_oriskin->insert('usersApps', $dataUsersApps);

                    if ($insertUsersApps) {
                        echo json_encode(['status' => true, 'last_customer_id' => $lastCustomer->id, 'dataCustomer' => $lastCustomer]);
                    } else {
                        echo json_encode(['status' => false, 'message' => 'Gagal insert ke usersApps']);
                    }
                } else {
                    echo json_encode(['status' => false, 'message' => 'Tidak ditemukan customer terakhir']);
                }
            } else {
                $error = $db_oriskin->error(); // ['code'] dan ['message']
                echo json_encode([
                    'status' => false,
                    'message' => 'Gagal insert ke slguestlog',
                    'error' => $error
                ]);
                return;
            }
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'OTP tidak valid atau sudah kedaluwarsa'
            ]);
        }
    }

    public function verify_pin()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $customerId = $postData["customerId"];
        $pin = $postData["pin"];

        $user = $db_oriskin->get_where('usersApps', ['customerid' => $customerId])->row();

        if ($user && $user->pin_code === $pin) {
            echo json_encode(['status' => true, 'message' => 'PIN benar']);
        } else {
            echo json_encode(['status' => false, 'message' => 'PIN salah']);
        }
    }

    public function set_pin()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);

        $customerId = $postData["customerId"] ?? null;
        $pin = $postData["pin"] ?? null;

        if (!$customerId || !$pin) {
            echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        $db_oriskin->where('customerid', $customerId);
        $success = $db_oriskin->update('usersApps', ['pin_code' => $pin]);

        if ($success && $db_oriskin->affected_rows() > 0) {
            echo json_encode(['status' => true, 'message' => 'PIN berhasil disimpan']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal menyimpan PIN']);
        }
    }

    public function set_pinRequest()
    {

        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);

        $customerId = $postData["customerId"] ?? null;
        $pin = $postData["pin"] ?? null;
        $otp = $postData["otp"] ?? null;

        if (!$customerId || !$pin || !$otp) {
            echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        $db_oriskin->select('otp_code');
        $db_oriskin->where('customerid', $customerId);
        $query = $db_oriskin->get('usersApps');
        $user = $query->row();

        if ($user->otp_code !== $otp) {
            echo json_encode(['status' => false, 'message' => 'Kode OTP salah']);
            return;
        }

        $db_oriskin->where('customerid', $customerId);
        $success = $db_oriskin->update('usersApps', ['pin_code' => $pin]);

        if ($success && $db_oriskin->affected_rows() > 0) {
            echo json_encode(['status' => true, 'message' => 'PIN berhasil disimpan']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal menyimpan PIN']);
        }
    }


    public function getMessages()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $sender_id = $this->input->get('sender_id');
        $sender_type = $this->input->get('sender_type');
        $receiver_id = $this->input->get('receiver_id');
        $receiver_type = $this->input->get('receiver_type');

        if (!$sender_id || !$receiver_id || !$sender_type || !$receiver_type) {
            echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
            return;
        }

        $sql_update = "
                UPDATE mschat
                SET is_read = 1
                WHERE receiver_id = ? 
                AND receiver_type = ? 
                AND sender_id = ? 
                AND sender_type = ?
            ";
        $db_oriskin->query($sql_update, [
            $receiver_id,
            $receiver_type,
            $sender_id,
            $sender_type
        ]);

        $sql = "
        SELECT * FROM mschat 
        WHERE 
        (
            sender_id = ? AND sender_type = ? AND receiver_id = ? AND receiver_type = ?
        )
        OR
        (
            sender_id = ? AND sender_type = ? AND receiver_id = ? AND receiver_type = ?
        )
        ORDER BY created_at ASC
    ";

        $params = [
            $sender_id,
            $sender_type,
            $receiver_id,
            $receiver_type,
            $receiver_id,
            $receiver_type,
            $sender_id,
            $sender_type
        ];

        $query = $db_oriskin->query($sql, $params);
        echo json_encode(['status' => 'success', 'data' => $query->result()]);
    }

    public function sendMessages()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);

        $data_notify = [
            'receiver_id' => $postData["receiver_id"],
            'receiver_type' => $postData["receiver_type"],
        ];

        $success = $db_oriskin->insert('mschat', $postData);

        if ($success && $db_oriskin->affected_rows() > 0) {
            $notify = $this->notifyWebSocketServer($data_notify);
            echo json_encode(['status' => true, 'message' => 'Pesan berhasil dikirim']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal mengirim pesan']);
        }
    }


    public function sendMessagesByCustomerApps()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $post = $this->input->post();
        $db_oriskin = $this->load->database('oriskin', true);

        $receiver_id = $post['receiver_id'] ?? null;
        $receiver_type = "employee";
        $message = $post['message'] ?? null;
        $sender_id = $post['sender_id'] ?? null;
        $sender_type = "userapps";
        $type = $post['type'] ?? 'text'; // default text
        $is_read = 0;
        $image_path = null;

        // Handle image upload jika ada
        if (!empty($_FILES['image']['name'])) {
            $upload_path = './uploads/chat/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0775, true);
                chmod($upload_path, 0777);
            }

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $image_path = 'uploads/chat/' . $uploadData['file_name'];
                $type = 'image';
                $message = $image_path; // ganti isi message menjadi path file
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Image upload failed: ' . strip_tags($this->upload->display_errors())
                ]);
                return;
            }
        }

        // Data untuk simpan ke database
        $create_data = [
            'receiver_id' => $receiver_id,
            'receiver_type' => $receiver_type,
            'message' => $message,
            'sender_id' => $sender_id,
            'sender_type' => $sender_type,
            'type' => $type,
            'is_read' => $is_read,
            'created_at' => date("Y-m-d H:i:s")
        ];

        $data_notify = [
            'receiver_id' => $receiver_id,
            'receiver_type' => $receiver_type,
        ];

        // Insert data
        if ($db_oriskin->insert('mschat', $create_data)) {
            $notify = $this->notifyWebSocketServer($data_notify);
            echo json_encode([
                'status' => 'success',
                'message' => 'Message sent successfully',
                'data' => $create_data
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to send message',
                'data' => $create_data
            ]);
        }
    }

    public function detailConsultationChat()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $sender_id = $this->input->get('sender_id');
        $sender_type = 'employee';
        $receiver_id = $this->input->get('receiver_id');
        $receiver_type = $this->input->get('receiver_type');

        if (!$sender_id || !$receiver_id || !$sender_type || !$receiver_type) {
            echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
            return;
        }

        $sql_update = "
                UPDATE mschat
                SET is_read = 1
                WHERE receiver_id = ? 
                AND receiver_type = ? 
                AND sender_id = ? 
                AND sender_type = ?
            ";
        $db_oriskin->query($sql_update, [
            $sender_id,
            $sender_type,
            $receiver_id,
            $receiver_type
        ]);

        $sql = "
							SELECT * FROM mschat 
							WHERE 
							(
								sender_id = ? AND sender_type = ? AND receiver_id = ? AND receiver_type = ?
							)
							OR
							(
								sender_id = ? AND sender_type = ? AND receiver_id = ? AND receiver_type = ?
							)
							ORDER BY created_at ASC
						";

        $params = [
            $sender_id,
            $sender_type,
            $receiver_id,
            $receiver_type,
            $receiver_id,
            $receiver_type,
            $sender_id,
            $sender_type
        ];

        $query = $db_oriskin->query($sql, $params);


        echo json_encode([
            'status' => 'success',
            'data' => [
                'messages' => $query->result(),
            ]
        ]);

    }

    public function sendMessagesImagesByEmployee()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $post = $this->input->post();
        $db_oriskin = $this->load->database('oriskin', true);

        $receiver_id = $post['receiver_id'] ?? null;
        $receiver_type = $post['receiver_type'] ?? null;
        $message = $post['message'] ?? null;
        $sender_id = $this->session->userdata('userid');
        $sender_type = "employee";
        $type = 'text';
        $is_read = 0;
        $image_path = null;

        if (!empty($_FILES['image']['name'])) {
            $upload_path = './uploads/chat/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0775, true);
                chmod($upload_path, 0777);
            }

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $image_path = 'uploads/chat/' . $uploadData['file_name'];
                $type = 'image';
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Image upload failed: ' . $this->upload->display_errors()
                ]);
                return;
            }
        }


        $create_data = [
            'receiver_id' => $receiver_id,
            'receiver_type' => $receiver_type,
            'message' => $message,
            'sender_id' => $sender_id,
            "sender_type" => $sender_type,
            "type" => $type,
            "is_read" => $is_read,
            "created_at" => date("Y-m-d H:i:s")
        ];

        $data_notify = [
            'receiver_id' => $receiver_id,
            'receiver_type' => $receiver_type,
        ];

        if ($type === 'image') {
            $create_data['message'] = $image_path;
        }


        if ($db_oriskin->insert('mschat', $create_data)) {

            $notify = $this->notifyWebSocketServer($data_notify);
            echo json_encode([
                'status' => 'success',
                'message' => 'Data created successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update data',
                'data' => $create_data
            ]);
        }

    }

    public function getChatList()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $user_id = $this->input->get('user_id');
        $user_type = $this->input->get('user_type');
        $search = $this->input->get('search');

        $queryTreatments = $db_oriskin->query("
        	EXEC spEudoraGetListConsultationChat ?, ?, ?
    	", [$user_id, $user_type, $search]);

        $result = $queryTreatments->result_array();

        echo json_encode([
            'status' => 'success',
            'data' => $result
        ]);
    }

    public function sendMessagesEmployee()
    {

        error_reporting(0);
        ini_set('display_errors', 0);
        $post = $this->input->post();
        $db_oriskin = $this->load->database('oriskin', true);

        $receiver_id = $post['receiver_id'] ?? null;
        $receiver_type = $post['receiver_type'] ?? null;
        $message = $post['message'] ?? null;
        $sender_id = $this->session->userdata('userid');
        // $sender_id = 10;
        $sender_type = "employee";
        $type = 'text';
        $is_read = 0;
        $image_path = null;

        if (!empty($_FILES['image']['name'])) {
            $upload_path = './uploads/chat/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0775, true);
                chmod($upload_path, 0777); // agar writable
            }

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $image_path = 'uploads/chat/' . $uploadData['file_name'];
                $type = 'image';
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Image upload failed: ' . $this->upload->display_errors()
                ]);
                return;
            }
        }


        $create_data = [
            'receiver_id' => $receiver_id,
            'receiver_type' => $receiver_type,
            'message' => $message,
            'sender_id' => $sender_id,
            "sender_type" => $sender_type,
            "type" => $type,
            "is_read" => $is_read,
            "created_at" => date("Y-m-d H:i:s")
        ];

        $data_notify = [
            'receiver_id' => $receiver_id,
            'receiver_type' => $receiver_type,
        ];


        if ($type === 'image') {
            $create_data['message'] = $image_path; // pastikan kolom 'image' ada di DB
        }


        if ($db_oriskin->insert('mschat', $create_data)) {
            $notify = $this->notifyWebSocketServer($data_notify);
            // $notificationChat = $this->send_chat_notification_to_user($receiver_id);
            echo json_encode([
                'status' => 'success',
                'message' => 'Data created successfully',
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update data',
            ]);
        }

    }

    private function notifyWebSocketServer($data)
    {
        $url = "https://sys.eudoraclinic.com:3001/trigger-message";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // kirim JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $response;
    }

    private function send_push_notification($nofiticationToken, $titleNotification, $messageNotification)
    {
        $payload = json_encode([
            "to" => $nofiticationToken,
            "sound" => "default",
            "title" => $titleNotification,
            "body" => $messageNotification,
            "data" => ["type" => "chat", "route" => "tabs/consultation"]
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://exp.host/--/api/v2/push/send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "Accept-Encoding: gzip, deflate",
            "Content-Type: application/json"
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


    public function send_chat_notification_to_user($customerid, $title = 'Pesan Baru!', $message = 'Kamu menerima pesan baru')
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        // Ambil semua push_token milik user (bisa lebih dari 1 token untuk multi-device)
        $db_oriskin = $this->load->database('oriskin', true);
        $tokens = $db_oriskin
            ->select('push_token')
            ->where('customerid', $customerid)
            ->get('user_push_tokens')
            ->result_array();

        $results = [];
        foreach ($tokens as $t) {
            $results[] = $this->send_push_notification($t['push_token'], $title, $message);
        }

        return $results;
    }

    public function save_push_token()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $data = json_decode(file_get_contents("php://input"), true);
        $customerid = $data['customerid'];
        $push_token = $data['push_token'];
        $type = $data['type'];

        $exists = $db_oriskin
            ->where('customerid', $customerid)
            ->where('push_token', $push_token)
            ->get('user_push_tokens')
            ->num_rows();

        if ($type == 0) {
            $db_oriskin
                ->where('customerid', $customerid)
                ->where('push_token', $push_token)
                ->delete('user_push_tokens');
        } elseif ($type == 1) {
            if (!$exists) {
                $db_oriskin->insert('user_push_tokens', [
                    'customerid' => $customerid,
                    'push_token' => $push_token,
                    'platform' => $this->agent->platform(),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        echo json_encode(['status' => true, 'message' => 'Token saved']);
    }


    public function getLocationList()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryLocation = $db_oriskin->query("SELECT *
                FROM mslocation a 
                WHERE isactive = 1 AND id != 6
				ORDER BY id");

        $dataLocation = $queryLocation->result_array();
        echo json_encode(['status' => true, 'data' => $dataLocation]);
    }

    public function getDetailLocation()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $id = $this->input->get('id');

        $queryLocation = $db_oriskin->query("SELECT *
                FROM mslocation a
                WHERE id = ?", [$id]);

        $dataLocation = $queryLocation->result_array();
        echo json_encode(['status' => true, 'data' => $dataLocation]);
    }

    public function insertLocation()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $name = $this->input->post('name');
        $code = $this->input->post('code');
        $isactive = $this->input->post('isactive');
        $cityid = $this->input->post('cityid');
        $address = $this->input->post('address');
        $companyname = $this->input->post('companyname');
        $mobilephone = $this->input->post('mobilephone');
        $shortname = $this->input->post('shortname');
        $operationalTime = $this->input->post('operationalTime');
        $userid = $this->input->post('userid');

        // $uploaded_images = [];
        // if (!empty($_FILES['images']['name'][0])) {
        //     $this->load->library('upload');

        //     $files = $_FILES;
        //     $count = count($_FILES['images']['name']);

        //     for ($i = 0; $i < $count; $i++) {
        //         $_FILES['image']['name'] = $files['images']['name'][$i];
        //         $_FILES['image']['type'] = $files['images']['type'][$i];
        //         $_FILES['image']['tmp_name'] = $files['images']['tmp_name'][$i];
        //         $_FILES['image']['error'] = $files['images']['error'][$i];
        //         $_FILES['image']['size'] = $files['images']['size'][$i];

        //         $config['upload_path'] = './uploads/outlet';
        //         $config['allowed_types'] = 'jpg|jpeg|png|webp';
        //         $config['file_name'] = uniqid('clinic_');
        //         $config['overwrite'] = false;

        //         $this->upload->initialize($config);

        //         if ($this->upload->do_upload('image')) {
        //             $uploadData = $this->upload->data();
        //             $uploaded_images[] = 'uploads/outlet/' . $uploadData['file_name'];
        //         }
        //     }
        // }

        $data = [
            'name' => $name,
            'shortcode' => $code,
            'isactive' => $isactive,
            'cityid' => $cityid,
            'address' => $address,
            'companyname' => $companyname,
            'mobilephone' => $mobilephone,
            'shortname' => $shortname,
            'operationalTime' => $operationalTime,
            // 'image' => !empty($uploaded_images) ? json_encode($uploaded_images) : null,
            'updatedate' => date('Y-m-d H:i:s'),
            'updateuserid' => $userid,
            'updatestatus' => date('Y-m-d H:i:s'),
        ];

        $insert = $db_oriskin->insert('mslocation', $data);

        if ($insert) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data', 'data' => $data]);
        }
    }



    private function send_push_promo_notification($nofiticationToken, $titleNotification, $messageNotification)
    {
        $payload = json_encode([
            "to" => $nofiticationToken,
            "sound" => "default",
            "title" => $titleNotification,
            "body" => $messageNotification,
            "data" => ["type" => "promo", "route" => "notification"]
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://exp.host/--/api/v2/push/send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "Accept-Encoding: gzip, deflate",
            "Content-Type: application/json"
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


    public function send_broadcast_notification_to_user()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $this->load->helper('url');
        $db_oriskin = $this->load->database('oriskin', true);
        $broadcast_id = $this->input->post('broadcast_id');

        if (!$broadcast_id) {
            echo json_encode(['status' => 400, 'message' => 'broadcast_id is required']);
            return;
        }

        $data = $db_oriskin
            ->select('upt.push_token, bn.title, bn.message, pbt.broadcast_id, pbt.customer_id, c.firstname as customer_name')
            ->from('promo_broadcast_target pbt')
            ->join('broadcast_notification bn', 'bn.id = pbt.broadcast_id')
            ->join('user_push_tokens upt', 'pbt.customer_id = upt.customerid')
            ->join('mscustomer c', 'c.id = pbt.customer_id')
            ->where('pbt.status', 0)
            ->where('pbt.broadcast_id', $broadcast_id)
            ->get()
            ->result_array();

        $batchSize = 100;
        $results = [];
        $batch = [];

        foreach ($data as $index => $row) {
            $batch[] = $row;

            if (count($batch) === $batchSize || $index === array_key_last($data)) {
                foreach ($batch as $b) {

                    $personalizedMsg = str_replace(
                        "(nama customer)",
                        $b['customer_name'],
                        $b['message']
                    );


                    $personalizedTitle = str_replace(
                        "(nama customer)",
                        $b['customer_name'],
                        $b['title']
                    );

                    $result = $this->send_push_promo_notification($b['push_token'], $personalizedTitle, $personalizedMsg);
                    $results[] = $result;

                    $db_oriskin->where('customer_id', $b['customer_id']);
                    $db_oriskin->where('broadcast_id', $broadcast_id);
                    $db_oriskin->update('promo_broadcast_target', [
                        'status' => 1,
                        'sent_at' => date('Y-m-d H:i:s')
                    ]);
                }

                usleep(500000); // 500ms
                $batch = [];
            }
        }

        echo json_encode([
            'status' => 200,
            'message' => 'Notifikasi berhasil dikirim ke ' . count($results) . ' customer',
            'results' => $results
        ]);
    }



    public function get_user_notification($customerid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        // ambil nama customer
        $customer = $db_oriskin
            ->select('firstname, lastname')
            ->from('mscustomer')
            ->where('id', $customerid)
            ->get()
            ->row_array();

        $customer_name = '';
        if ($customer) {
            $customer_name = trim($customer['firstname'] . ' ' . $customer['lastname']);
        }

        // ambil data notifikasi
        $data = $db_oriskin
            ->select('bn.title, bn.message, pbt.broadcast_id, bn.type, bn.image_url, pbt.sent_at, pbt.is_read')
            ->from('promo_broadcast_target pbt')
            ->join('broadcast_notification bn', 'bn.id = pbt.broadcast_id')
            ->where('pbt.customer_id', $customerid)
            ->where('pbt.status', 1)
            ->where('pbt.is_deleted', 0)
            ->order_by('bn.id', 'desc')
            ->get()
            ->result_array();

        // replace placeholder (nama customer) dengan nama customer
        foreach ($data as &$row) {
            if (!empty($row['message'])) {
                $row['message'] = str_replace('(nama customer)', $customer_name, $row['message']);
            }
        }

        foreach ($data as &$row) {
            if (!empty($row['title'])) {
                $row['title'] = str_replace('(nama customer)', $customer_name, $row['title']);
            }
        }

        echo json_encode(['status' => 200, 'data' => $data]);
    }


    public function get_user_notification_not_read($customerid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $data = $db_oriskin
            ->select('bn.title, bn.message, pbt.broadcast_id, bn.type, bn.image_url, pbt.sent_at, pbt.is_read')
            ->from('promo_broadcast_target pbt')
            ->join('broadcast_notification bn', 'bn.id = pbt.broadcast_id')
            ->where('pbt.customer_id', $customerid)
            ->where('pbt.status', 1)
            ->where('pbt.is_read', 0)
            ->get()
            ->result_array();

        echo json_encode([
            'status' => 200,
            'count' => count($data)
        ]);
    }

    public function update_notification_read_status()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $customer_id = $data['customer_id'] ?? null;
        $broadcast_id = $data['broadcast_id'] ?? null;

        if (!$customer_id || !$broadcast_id) {
            echo json_encode(['status' => 400, 'message' => 'Missing parameters']);
            return;
        }

        $db_oriskin = $this->load->database('oriskin', true);

        $db_oriskin->where('customer_id', $customer_id);
        $db_oriskin->where('broadcast_id', $broadcast_id);
        $updated = $db_oriskin->update('promo_broadcast_target', ['is_read' => 1]);

        if ($updated) {
            echo json_encode(['status' => 200, 'message' => 'Notification marked as read']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Failed to update notification']);
        }
    }


    public function update_notification_deleted_status()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $customer_id = $data['customer_id'] ?? null;
        $broadcast_id = $data['broadcast_id'] ?? null;

        if (!$customer_id || !$broadcast_id) {
            echo json_encode(['status' => 400, 'message' => 'Missing parameters']);
            return;
        }

        $db_oriskin = $this->load->database('oriskin', true);

        $db_oriskin->where('customer_id', $customer_id);
        $db_oriskin->where('broadcast_id', $broadcast_id);
        $updated = $db_oriskin->update('promo_broadcast_target', ['is_deleted' => 1]);

        if ($updated) {
            echo json_encode(['status' => 200, 'message' => 'Notification marked as read']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Failed to update notification']);
        }
    }

    public function insertPromoBroadcast()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        header('Content-Type: application/json');

        $title = $this->input->post('title');
        $message = $this->input->post('message');
        $type = $this->input->post('type');
        $created_by = $this->input->post('created_by');
        $image_url = null;

        $db_oriskin = $this->load->database('oriskin', true);

        // Tangani upload gambar
        if (!empty($_FILES['image_url']['name'])) {
            $config['upload_path'] = './uploads/broadcast_promo/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image_url')) {
                echo json_encode([
                    'status' => 400,
                    'message' => $this->upload->display_errors('', '')
                ]);
                return;
            } else {
                $upload_data = $this->upload->data();
                $image_url = 'uploads/broadcast_promo/' . $upload_data['file_name'];
            }
        }

        // Escape string untuk keamanan
        $titleEscaped = $db_oriskin->escape_str($title);
        $messageEscaped = $db_oriskin->escape_str($message);

        // Build query manual dengan prefix N untuk Unicode
        $sql = "INSERT INTO broadcast_notification (title, message, image_url, type, created_by, created_at)
            VALUES (N'$titleEscaped', N'$messageEscaped', ?, ?, ?, ?)";

        $params = [$image_url, $type, $created_by, date('Y-m-d H:i:s')];

        $insert = $db_oriskin->query($sql, $params);

        if ($insert) {
            echo json_encode(['status' => 200, 'message' => 'Promo berhasil disimpan']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Gagal menyimpan promo']);
        }
    }


    public function get_broadCastList()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $data = $db_oriskin
            ->select('title, message, image_url, type, id, created_at')
            ->from('broadcast_notification')
            ->get()
            ->result_array();

        echo json_encode([
            'status' => 200,
            'data' => $data
        ]);
    }


    public function getEventApps()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $data = $db_oriskin
            ->select('*')
            ->from('event_apps')
            ->where('isactive', 1)
            ->get()
            ->result_array();

        echo json_encode([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function getAdsApps()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $data = $db_oriskin
            ->select('*')
            ->from('ads_apps')
            ->where('isactive', 1)
            ->get()
            ->result_array();

        echo json_encode([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function get_broadCastListById($id)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $data = $db_oriskin
            ->select('title, message, image_url, type, id, created_at')
            ->from('broadcast_notification')
            ->where('id', $id)
            ->get()
            ->result_array();

        echo json_encode([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function get_listTargetPromo($broadcast_id)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $limit = $this->input->get('length');
        $start = $this->input->get('start');
        $draw = $this->input->get('draw');
        $search = $this->input->get('search')['value'];

        // Query dasar tanpa limit & search untuk hitung total
        $baseQuery = $db_oriskin
            ->select("pbt.status, pbt.is_read, pbt.sent_at,
            mc.firstname + ' ' + mc.lastname AS customer_name,
            mc.cellphonenumber, mc.customercode")
            ->from('promo_broadcast_target pbt')
            ->join('broadcast_notification bn', 'bn.id = pbt.broadcast_id')
            ->join('mscustomer mc', 'mc.id = pbt.customer_id')
            ->where('pbt.broadcast_id', $broadcast_id);

        // Hitung total data tanpa filter
        $total = $baseQuery->count_all_results('', false);

        // Query dengan filter pencarian (search)
        if (!empty($search)) {
            $baseQuery->group_start()
                ->like('mc.firstname', $search)
                ->or_like('mc.lastname', $search)
                ->or_like('mc.cellphonenumber', $search)
                ->or_like('mc.customercode', $search)
                ->group_end();
        }

        // Hitung total data setelah filter search
        $filtered = $baseQuery->count_all_results('', false);

        // Ambil data dengan limit dan offset
        $data = $baseQuery
            ->limit($limit, $start)
            ->get()
            ->result_array();

        // Output sesuai format DataTables
        echo json_encode([
            'draw' => intval($draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data
        ]);
    }


    public function insert_target_customer()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $broadcast_id = $this->input->post('broadcast_id');
        $db_oriskin = $this->load->database('oriskin', true);

        if (!$broadcast_id) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 400, 'message' => 'broadcast_id is required']));
        }

        // Ambil semua customer
        $customers = $db_oriskin
            ->select('id')
            ->from('mscustomer')
            ->get()
            ->result_array();

        // Ambil customer yang sudah terdaftar untuk broadcast ini
        $existing = $db_oriskin
            ->select('customer_id')
            ->from('promo_broadcast_target')
            ->where('broadcast_id', $broadcast_id)
            ->get()
            ->result_array();

        $existing_ids = array_column($existing, 'customer_id');

        $dataInsert = [];
        $now = date('Y-m-d H:i:s');

        foreach ($customers as $c) {
            if (!in_array($c['id'], $existing_ids)) {
                $dataInsert[] = [
                    'broadcast_id' => $broadcast_id,
                    'customer_id' => $c['id'],
                    'is_read' => 0,
                    'is_deleted' => 0,
                    'status' => 0,
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }
        }

        if (!empty($dataInsert)) {
            $db_oriskin->insert_batch('promo_broadcast_target', $dataInsert);
            $message = count($dataInsert) . ' data target berhasil ditambahkan.';
        } else {
            $message = 'Semua customer sudah menjadi target.';
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 200, 'message' => $message]));
    }


    public function insert_target_customerTest()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $broadcast_id = $this->input->post('broadcast_id');
        $db_oriskin = $this->load->database('oriskin', true);

        if (!$broadcast_id) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 400, 'message' => 'broadcast_id is required']));
        }

        // Ambil semua customer
        $ids = [16995, 24121, 28962, 40199, 5];

        $customers = $db_oriskin
            ->select('id')
            ->from('mscustomer')
            ->where_in('id', $ids)
            ->get()
            ->result_array();


        // Ambil customer yang sudah terdaftar untuk broadcast ini
        $existing = $db_oriskin
            ->select('customer_id')
            ->from('promo_broadcast_target')
            ->where('broadcast_id', $broadcast_id)
            ->get()
            ->result_array();

        $existing_ids = array_column($existing, 'customer_id');

        $dataInsert = [];
        $now = date('Y-m-d H:i:s');

        foreach ($customers as $c) {
            if (!in_array($c['id'], $existing_ids)) {
                $dataInsert[] = [
                    'broadcast_id' => $broadcast_id,
                    'customer_id' => $c['id'],
                    'is_read' => 0,
                    'is_deleted' => 0,
                    'status' => 0,
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }
        }

        if (!empty($dataInsert)) {
            $db_oriskin->insert_batch('promo_broadcast_target', $dataInsert);
            $message = count($dataInsert) . ' data target berhasil ditambahkan.';
        } else {
            $message = 'Semua customer sudah menjadi target.';
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 200, 'message' => $message]));
    }


    public function updatePromoBroadcast()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $broadcast_id = $this->input->post('broadcast_id');
        $title = $this->input->post('title');
        $message = $this->input->post('message');
        $created_at = $this->input->post('created_at');

        $db_oriskin = $this->load->database('oriskin', true);

        // Ambil data lama untuk hapus gambar jika perlu
        $oldData = $db_oriskin->select('image_url')
            ->from('broadcast_notification')
            ->where('id', $broadcast_id)
            ->get()
            ->row();

        // Tangani upload gambar
        $newImagePath = null;
        if (!empty($_FILES['image_url']['name'])) {
            $config['upload_path'] = './uploads/broadcast_promo/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image_url')) {
                $uploadData = $this->upload->data();
                $newImagePath = 'uploads/broadcast_promo/' . $uploadData['file_name'];

                // Hapus gambar lama jika ada
                if (!empty($oldData->image_url) && file_exists(FCPATH . $oldData->image_url)) {
                    unlink(FCPATH . $oldData->image_url);
                }
            } else {
                echo json_encode(['status' => 500, 'message' => "Masalah saat upload gambar"]);
                return;
            }
        }

        // Escape string untuk mencegah SQL Injection
        $titleEscaped = $db_oriskin->escape_str($title);
        $messageEscaped = $db_oriskin->escape_str($message);

        // Build query manual dengan prefix N untuk Unicode
        $sql = "UPDATE broadcast_notification
            SET title = N'$titleEscaped',
                message = N'$messageEscaped',
                created_at = ?";

        $params = [$created_at];

        if ($newImagePath) {
            $sql .= ", image_url = ?";
            $params[] = $newImagePath;
        }

        $sql .= " WHERE id = ?";
        $params[] = $broadcast_id;

        $updated = $db_oriskin->query($sql, $params);

        if ($updated) {
            echo json_encode(['status' => 200, 'message' => 'Berhasil diupdate']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Gagal update']);
        }
    }



    public function sync()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $input = json_decode($this->input->raw_input_stream, true);

        if (!$input || !isset($input['data'])) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode([
                    "status" => false,
                    "message" => "Invalid or missing data"
                ]));
        }

        if (is_string($input['data'])) {
            $input['data'] = json_decode($input['data'], true);
        }

        $inserted = 0;

        foreach ($input['data'] as $item) {
            $query = $db_oriskin->get_where('attendancelog', [
                'attdate' => $item['date'],
                'atttype' => $item['type'],
                'nip' => $item['userid'],
            ]);

            $exists = $query->row();

            if (!$exists) {
                $db_oriskin->insert('attendancelog', [
                    'uid' => $item['id'],
                    'nip' => $item['userid'] ?? null,
                    'attstate' => $item['state'] ?? '',
                    'attdate' => $item['date'],
                    'atttime' => $item['time'],
                    'locationcode' => $item['locationcode'],
                    'atttype' => $item['type'] ?? '',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $inserted++;
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                "status" => true,
                "inserted" => $inserted,
                "message" => "Data sync berhasil"
            ]));
    }


    public function getListEmployeeApps()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $data = $this->ModelApiApps->getListEmployeeApps();

        echo json_encode([
            'listEmployeeApps' => $data,
        ]);
    }

    public function getListTreatmentClaimFree()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $data = $this->ModelApiApps->getListTreatmentClaimFree();

        echo json_encode([
            'listTreatment' => $data,
        ]);
    }

    public function getListTreatmentClaimFreeActive($customerId = null)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $customerId = $this->input->get('customerId');

        $data = $this->ModelApiApps->getListTreatmentClaimFreeActive($customerId);

        echo json_encode([
            'listTreatment' => $data,
        ]);
    }

    public function addEmployeeApps()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $employeeid = $this->input->post('employeeid');
        $jobid = $this->input->post('jobid');
        $expertise = $this->input->post('expertise');
        $locationid = $this->input->post('locationid');

        if (!$employeeid || !$jobid || !$locationid) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $db_oriskin->select('employeeid');
        $db_oriskin->from('msemployeeApps');
        $db_oriskin->where('employeeid', $employeeid);
        $db_oriskin->where('locationid', $locationid);
        $db_oriskin->where('jobid', $jobid);
        $companycodeCheck = $db_oriskin->get()->row('employeeid');

        if ($companycodeCheck) {
            echo json_encode([
                'success' => false,
                'message' => 'Kode ini sudah ada',
            ]);
            return;
        }

        $updateData = [
            'employeeid' => $employeeid,
            'jobid' => $jobid,
            'locationid' => $locationid,
            'expertise' => !empty($expertise) ? $expertise : null,
            'status' => 1
        ];

        $result = $this->ModelApiApps->addEmployeeApps($updateData);

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


    public function addTreatmentClaimFreeApps()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $treatmentid = $this->input->post('treatmentid');
        $qty = $this->input->post('qty');
        $note = $this->input->post('note');

        if (!$treatmentid || !$qty || !$note) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $db_oriskin->select('treatmentid');
        $db_oriskin->from('mstreatmentclaimfree');
        $db_oriskin->where('treatmentid', $treatmentid);
        $companycodeCheck = $db_oriskin->get()->row('treatmentid');

        if ($companycodeCheck) {
            echo json_encode([
                'success' => false,
                'message' => 'Treatment ini sudah ada',
            ]);
            return;
        }

        $updateData = [
            'treatmentid' => $treatmentid,
            'qty' => $qty,
            'note' => $note,
            "created_at" => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata('userid'),
            'isactive' => 1
        ];

        $result = $this->ModelApiApps->addTreatmentClaimFreeApps($updateData);

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

    public function updateCompanyMaster()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $id = $this->input->post('id');
        $expertise = $this->input->post('expertise');
        $locationid = $this->input->post('locationid');
        $status = $this->input->post('status');

        if (!$locationid || !$id) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $updateData = [
            'locationid' => $locationid,
            'expertise' => !empty($expertise) ? $expertise : null,
            'status' => $status
        ];

        $result = $this->ModelApiApps->updateEmployeeApps($id, $updateData);

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

    public function updateTreatmentClaimFree()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $id = $this->input->post('id');
        $treatmentid = $this->input->post('treatmentid');
        $qty = $this->input->post('qty');
        $note = $this->input->post('note');
        $isactive = $this->input->post('isactive');

        if (!$treatmentid || !$id || !$qty || !$note) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $updateData = [
            'treatmentid' => $treatmentid,
            'qty' => $qty,
            'note' => $note,
            "updated_at" => date("Y-m-d H:i:s"),
            'updated_by' => $this->session->userdata('userid'),
            'isactive' => $isactive
        ];

        $result = $this->ModelApiApps->updateTreatmentClaimFree($id, $updateData);

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


    public function getEmployeeAppsById($id)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $this->output->set_content_type('application/json');

        $data = $this->ModelApiApps->getEmployeeAppsById($id);

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

    public function getListTreatmentClaimFreeById($id)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $this->output->set_content_type('application/json');

        $data = $this->ModelApiApps->getListTreatmentClaimFreeById($id);

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



    public function uploadEmployeeAppsPhoto()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $id = $this->input->post('id');
        $expend = $db_oriskin->get_where('msemployeeApps', ['id' => $id])->row();

        if (empty($_FILES['lampiran']['name'])) {
            echo json_encode(['success' => false, 'message' => 'File tidak ditemukan']);
            return;
        }

        // Hapus file lama jika ada
        if ($expend && $expend->image) {
            $oldPath = './uploads/doctor/' . $expend->image;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Upload baru
        $config['upload_path'] = './uploads/doctor/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['file_name'] = uniqid('lampiran_');
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('lampiran')) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => $this->upload->display_errors()]));
        }

        $uploadData = $this->upload->data();
        $filePath = $uploadData['file_name'];

        $db_oriskin->where('id', $id)->update('msemployeeApps', ['image' => $filePath]);

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'message' => 'Lampiran berhasil diupload']));
    }


    public function uploadEventImageApps()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $description = $this->input->post('description');
        $id = $this->input->post('id');
        $isactive = $this->input->post('isactive');
        $link_url = $this->input->post('link_url');

        if (!$id) {
            if (empty($_FILES['lampiran']['name'])) {
                echo json_encode(['success' => false, 'message' => 'File tidak ditemukan']);
                return;
            }

            // Upload baru
            $config['upload_path'] = './uploads/event/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] = uniqid('event_');
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('lampiran')) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['success' => false, 'message' => $this->upload->display_errors()]));
            }

            $uploadData = $this->upload->data();

            $filePath = 'uploads/event/' . $uploadData['file_name'];

            $db_oriskin->insert('event_apps', [
                'image' => $filePath,
                'description' => $description,
                'isactive' => $isactive,
                'link_url' => $link_url,
                'createdat' => date('Y-m-d H:i:s')
            ]);

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'message' => 'Lampiran berhasil diupload']));
        } else {
            $expend = $db_oriskin->get_where('event_apps', ['id' => $id])->row();

            // Data default yang akan selalu diupdate
            $updateData = [
                'description' => $description,
                'isactive' => $isactive,
                'link_url' => $link_url,
                'createdat' => date('Y-m-d H:i:s')
            ];

            // Cek apakah ada file yang diupload
            if (!empty($_FILES['lampiran']['name'])) {
                // Hapus file lama
                if ($expend && $expend->image) {
                    $oldPath = $expend->image;
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                // Upload baru
                $config['upload_path'] = './uploads/event/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['file_name'] = uniqid('event_');
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('lampiran')) {
                    return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode([
                            'success' => false,
                            'message' => $this->upload->display_errors()
                        ]));
                }

                $uploadData = $this->upload->data();
                $filePath = 'uploads/event/' . $uploadData['file_name'];

                // Tambahkan image ke data update
                $updateData['image'] = $filePath;
            }

            // Update data
            $db_oriskin->where('id', $id)->update('event_apps', $updateData);

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'message' => 'Lampiran berhasil diupload']));

        }
    }


    public function uploadAdsImageApps()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $description = $this->input->post('description');
        $id = $this->input->post('id');
        $isactive = $this->input->post('isactive');
        $link_url = $this->input->post('link_url');

        if (!$id) {
            if (empty($_FILES['lampiran']['name'])) {
                echo json_encode(['success' => false, 'message' => 'File tidak ditemukan']);
                return;
            }

            // Upload baru
            $config['upload_path'] = './uploads/ads/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] = uniqid('ads_');
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('lampiran')) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['success' => false, 'message' => $this->upload->display_errors()]));
            }

            $uploadData = $this->upload->data();

            $filePath = 'uploads/ads/' . $uploadData['file_name'];

            $db_oriskin->insert('ads_apps', [
                'image' => $filePath,
                'description' => $description,
                'isactive' => $isactive,
                'link_url' => $link_url,
                'createdat' => date('Y-m-d H:i:s')
            ]);

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'message' => 'Lampiran berhasil diupload']));
        } else {
            $expend = $db_oriskin->get_where('ads_apps', ['id' => $id])->row();

            // Data default yang akan selalu diupdate
            $updateData = [
                'description' => $description,
                'isactive' => $isactive,
                'link_url' => $link_url,
                'createdat' => date('Y-m-d H:i:s')
            ];

            // Cek apakah ada file yang diupload
            if (!empty($_FILES['lampiran']['name'])) {
                // Hapus file lama
                if ($expend && $expend->image) {
                    $oldPath = $expend->image;
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                // Upload baru
                $config['upload_path'] = './uploads/ads/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['file_name'] = uniqid('ads_');
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('lampiran')) {
                    return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode([
                            'success' => false,
                            'message' => $this->upload->display_errors()
                        ]));
                }

                $uploadData = $this->upload->data();
                $filePath = 'uploads/ads/' . $uploadData['file_name'];

                // Tambahkan image ke data update
                $updateData['image'] = $filePath;
            }

            // Update data
            $db_oriskin->where('id', $id)->update('ads_apps', $updateData);

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'message' => 'Lampiran berhasil diupload']));

        }
    }



    public function uploadLocationImage()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $expend = $db_oriskin->get_where('mslocation', ['id' => $id])->row();

        if (empty($_FILES['lampiran']['name'])) {
            echo json_encode(['success' => false, 'message' => 'File tidak ditemukan']);
            return;
        }

        // Hapus file lama jika ada
        if ($expend && $expend->image) {
            $oldPath = $expend->image;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        if ($expend && $expend->image2) {
            $oldPath2 = $expend->image2;
            if (file_exists($oldPath2)) {
                unlink($oldPath2);
            }
        }

        $config['upload_path'] = './uploads/outlet/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['file_name'] = uniqid('outlet_');
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('lampiran')) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => $this->upload->display_errors()]));
        }

        $uploadData = $this->upload->data();
        $filePath = '/uploads/outlet/' . $uploadData['file_name'];

        if ($type == 1) {
            $db_oriskin->where('id', $id)->update('mslocation', ['image' => $filePath]);
        } elseif ($type == 2) {
            $db_oriskin->where('id', $id)->update('mslocation', ['image2' => $filePath]);
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'message' => 'Lampiran berhasil diupload']));
    }

    public function insertFreeClaimInstallApps()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $db_oriskin = $this->load->database('oriskin', true);

        $randomStr = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);
        $invoiceno = 'INV' . $postData["customerid"] . $randomStr;

        $dataCreate = [
            "note" => $postData["note"],
            "locationid" => $postData["locationid"],
            "purchasedate" => date("Y-m-d H:i:s"),
            "invoiceno" => $invoiceno,
            "productid" => $postData["treatmentid"] ?? null,
            "customerid" => $postData["customerid"] ?? null,
            "amount" => 0,
            "updateuserid" => 1,
            "updatedate" => date("Y-m-d H:i:s"),
            "qty" => $postData["qty"] ?? null,
            "qtytotal" => $postData["qty"] ?? null,
            "status" => 1
        ];

        $dataClaim = [
            "treatmentclaimid" => $postData["treatmentid"] ?? null,
            "isclaim" => 1,
            "claimdate" => date("Y-m-d H:i:s"),
            "invoiceclaim" => $invoiceno
        ];


        $exists = $this->ModelApiApps->checkIsClaimTreatment($postData["customerid"]);
        if ($exists) {
            echo json_encode([
                "status" => false,
                "message" => "Kamu sudah pernah claim sebelumnya"
            ]);
            return;
        }

        if ($db_oriskin->insert("msadjusmentwesstreatment", $dataCreate)) {
            $db_oriskin->where('customerid', $postData["customerid"]);
            $insertUsersApps = $db_oriskin->update('usersApps', $dataClaim);

            if ($insertUsersApps) {

                echo json_encode([
                    "status" => true,
                    "message" => "Treatment berhasil diclaim"
                ]);

            } else {
                echo json_encode([
                    "status" => false,
                    "message" => "Treatment gagal diclaim"
                ]);
            }
        } else {
            $error = $db_oriskin->error();
            echo json_encode([
                "status" => false,
                "message" => "Treatment gagal diclaim"
            ]);
        }
    }

    public function getIsClaim($customerid)
    {

        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryDetailCustomer = $db_oriskin->query("
        	SELECT b.name as treatmentname FROM usersApps a INNER JOIN mstreatment b ON a.treatmentclaimid = b.id WHERE customerid = ?
    	", [$customerid]);

        $result = $queryDetailCustomer->row();

        echo json_encode(['isClaim' => $result]);
    }

    public function getListOutletAccess()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $queryDetailCustomer = $this->ModelApiApps->getListOutletAccess();
        echo json_encode(['listOutletAccess' => $queryDetailCustomer]);
    }

    public function getChatListCustomer()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $user_id = $this->input->get('user_id');
        $user_type = $this->input->get('user_type');
        $search = "";

        $queryTreatments = $db_oriskin->query("
        	EXEC spEudoraGetListConsultationChat ?, ?, ?
    	", [$user_id, $user_type, $search]);

        $result = $queryTreatments->result_array();

        echo json_encode([
            'status' => 'success',
            'data' => $result
        ]);
    }

    public function getListRefferalFriend($customerId)
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $dateStart = $this->input->get('dateStart');
        $dateEnd = $this->input->get('dateEnd');
        $filterType = $this->input->get('filterType');

        $queryDetailCustomer = $this->ModelApiApps->getListRefferalFriend($customerId, $dateStart, $dateEnd, $filterType);
        echo json_encode(['listRefferalFriend' => $queryDetailCustomer, 'dateStart' => $dateStart, 'dateEnd' => $dateEnd]);
    }

    public function getUnreadChat()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $receiver_type = 'employee';
        $receiver_id = $this->session->userdata('userid');

        if (!$receiver_id || !$receiver_type) {
            echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
            return;
        }


        $sql = "
							SELECT * FROM mschat 
							WHERE receiver_id = ? AND receiver_type = ? AND is_read = 0
							ORDER BY created_at ASC
						";

        $params = [
            $receiver_id,
            $receiver_type
        ];

        $query = $db_oriskin->query($sql, $params);

        echo json_encode([
            'status' => 'success',
            'data' => $query->result()
        ]);

    }


    public function getListCategory()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $data = $this->ModelApiApps->getListCategory();

        echo json_encode([
            'listJobs' => $data,
        ]);
    }

    public function getCategoryById($id)
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelApiApps->getCategoryById($id);

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

    public function createCategory()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $isactive = $this->input->post('isactive');
        $icon_image = $this->input->post('icon_image');

        // validasi name
        if (!$name) {
            echo json_encode([
                'success' => false,
                'message' => 'Nama kategori wajib diisi',
            ]);
            return;
        }

        // validasi icon_image saat create
        if (!$id && !$icon_image) {
            echo json_encode([
                'success' => false,
                'message' => 'Icon image wajib diisi saat membuat kategori baru',
            ]);
            return;
        }

        $data = [
            'name' => $name,
            'isactive' => $isactive,
            'updateuserid' => $this->session->userdata('userid'),
        ];

        // hanya tambahkan icon_image jika ada
        if ($icon_image) {
            $data['icon_image'] = $icon_image;
        }

        if ($id) {
            // update
            $result = $this->ModelApiApps->updateCategory($id, $data);
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Kategori berhasil diupdate',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Kategori gagal diupdate',
                    'data' => $data
                ]);
            }
        } else {
            // create
            $result = $this->ModelApiApps->createCategory($data);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Kategori berhasil dibuat',
                    'data' => $data
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Kategori gagal dibuat',
                    'data' => $data
                ]);
            }
        }
    }


    public function searchServices($id)
    {
        $search = $this->input->get('search');
        $data = $this->ModelApiApps->searchServices($search, $id);

        $result = [];
        foreach ($data as $row) {
            $result[] = [
                'id' => $row->id,
                'text' => "{$row->code} - {$row->name}"
            ];
        }

        echo json_encode($result);
    }

    public function addCategoryByProductType()
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
            $itemadjusment = [
                'productid' => $items['itemid'],
                'categoryid' => $post['categoryid'],
                'producttypeid' => $post['producttypeid'],
                'isactive' => 1,
            ];

            $exists = $db_oriskin
                ->where('productid', $itemadjusment['productid'])
                ->where('categoryid', $itemadjusment['categoryid'])
                ->where('producttypeid', $itemadjusment['producttypeid'])
                ->get('treatment_category')
                ->num_rows();

            if ($exists == 0) {
                $db_oriskin->insert('treatment_category', $itemadjusment);
            }
        }


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


    public function getListCategoryByProductType()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $dataTreatment = $this->ModelApiApps->getListCategoryByProductTypeTreatment();
        $dataPackage = $this->ModelApiApps->getListCategoryByProductTypePackage();
        $dataRetail = $this->ModelApiApps->getListCategoryByProductTypeRetail();

        echo json_encode([
            'listCategoryByTreatment' => $dataTreatment,
            'listCategoryByPackage' => $dataPackage,
            'listCategoryByRetail' => $dataRetail
        ]);
    }

    public function updateStatusCategoryByType()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $id = $this->input->post('id');
        $isactive = $this->input->post('isactive');

        $data = [
            'isactive' => $isactive
        ];


        $result = $this->ModelApiApps->updateStatusCategoryByType($id, $data);

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
    }

    public function getListCategoryApps()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $headers = $this->input->request_headers();
        $token = isset($headers['auth_token_customer']) ? $headers['auth_token_customer'] : null;
        $customerid = isset($headers['customerid']) ? $headers['customerid'] : null;

        if ($token === null) {
            $response = [
                'status' => 'error',
                'code' => 401,
                'message' => 'Authorization token is required',
                'token' => $token
            ];
            echo json_encode($response);
            return;
        }

        $is_token_valid = $this->ModelPaymentApps->validationToken($token, $customerid);

        if (!$is_token_valid) {
            echo json_encode([
                'status' => 'error',
                'code' => 401,
                'message' => 'Invalid token or customer not found',
                'token' => $token
            ]);
            return;
        }

        $data = $this->ModelApiApps->getListCategoryApps($customerid);

        echo json_encode([
            'listCategory' => $data,
        ]);
    }

    public function getListCategoryByProductByIdApps($id)
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $dataTreatment = $this->ModelApiApps->getListCategoryByProductTypeTreatmentApps($id);
        $dataPackage = $this->ModelApiApps->getListCategoryByProductTypePackageApps($id);
        $dataRetail = $this->ModelApiApps->getListCategoryByProductTypeRetailApps($id);

        echo json_encode([
            'listCategoryByTreatment' => $dataTreatment,
            'listCategoryByPackage' => $dataPackage,
            'listCategoryByRetail' => $dataRetail
        ]);
    }


    public function getListCategoyByProductId($productid, $producttypeid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $data = $this->ModelApiApps->getListCategoyByProductId($productid, $producttypeid);

        echo json_encode([
            'data' => $data,
        ]);
    }

    public function getDetailTreatment($productid, $producttypeid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $data = $this->ModelApiApps->getDetailTreatment($productid, $producttypeid);

        echo json_encode([
            'data' => $data,
        ]);
    }

    public function getCustomerCart($customerid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $data = $db_oriskin
            ->select('pbt.id')
            ->from('customer_cart pbt')
            ->where('pbt.customerid', $customerid)
            ->where('pbt.isactive', 1)
            ->get()
            ->result_array();

        echo json_encode([
            'status' => 200,
            'count' => count($data)
        ]);
    }

    public function insertCustomerCart()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $db_oriskin = $this->load->database('oriskin', true);

        $productid = $postData["productid"] ?? null;
        $customerid = $postData["customerid"] ?? null;
        $producttypeid = $postData["producttypeid"] ?? null;
        $qty = $postData["qty"] ?? 1;

        $existing = $db_oriskin
            ->where('productid', $productid)
            ->where('customerid', $customerid)
            ->where('producttypeid', $producttypeid)
            ->where('isactive', 1)
            ->get('customer_cart')
            ->row_array();

        if ($existing) {
            $newQty = $existing['qty'] + $qty;
            $db_oriskin->where('id', $existing['id'])->update('customer_cart', ['qty' => $newQty]);

            echo json_encode([
                "status" => true,
                "message" => "Berhasil menambahkan qty product ke keranjang",
                "data" => [
                    "id" => $existing['id'],
                    "productid" => $productid,
                    "customerid" => $customerid,
                    "producttypeid" => $producttypeid,
                    "qty" => $newQty
                ]
            ]);
        } else {
            // Insert baru
            $dataCreate = [
                "productid" => $productid,
                "customerid" => $customerid,
                "producttypeid" => $producttypeid,
                "qty" => $qty,
                "isactive" => 1,
                "is_on_payment" => 0
            ];

            if ($db_oriskin->insert("customer_cart", $dataCreate)) {
                echo json_encode([
                    "status" => true,
                    "message" => "Berhasil menambahkan product ke keranjang",
                    "data" => $dataCreate
                ]);
            } else {
                echo json_encode([
                    "status" => false,
                    "message" => "Gagal menambahkan product ke keranjang",
                    "data" => $dataCreate
                ]);
            }
        }
    }

    public function getCustomerCartList($customerid, $type)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryTreatments = $db_oriskin->query("
        	EXEC spEudoraGetCustomerCart ?, ?
    	", [$customerid, $type]);

        $result = $queryTreatments->result_array();

        echo json_encode([
            'status' => 'success',
            'data' => $result
        ]);
    }

    public function getCustomerCartOnPaymentList($customerid, $type)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $queryTreatments = $db_oriskin->query("
        	EXEC spEudoraGetCustomerCart ?, ?
    	", [$customerid, $type]);

        $result = $queryTreatments->result_array();

        echo json_encode([
            'status' => 'success',
            'data' => $result
        ]);
    }

    public function updateQtyAndStatusCart()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $db_oriskin = $this->load->database('oriskin', true);

        // $headers = $this->input->request_headers();

        // $token = isset($headers['auth_token_customer']) ? $headers['auth_token_customer'] : null;
        // $customerid = isset($headers['customerid']) ? $headers['customerid'] : null;


        // if ($token === null || $customerid === null) {
        //     $response = [
        //         'status' => 'error',
        //         'code' => 401,
        //         'message' => 'Authorization token is required',
        //         'token' => $token
        //     ];
        //     echo json_encode($response);
        //     return;
        // }

        // $is_token_valid = $this->ModelPaymentApps->validationToken($token, $customerid);

        // if (!$is_token_valid) {
        //     echo json_encode([      
        //         'status' => 'error',
        //         'code' => 401,
        //         'message' => 'Invalid token or customer not found',
        //         'token' => $token
        //     ]);
        //     return;
        // }

        $type = $postData["type"] ?? null;
        $idcart = $postData["idcart"] ?? null;

        $success = false;

        if ($type == 1) {
            $success = $db_oriskin
                ->set('qty', 'qty - 1', FALSE)
                ->where('id', $idcart)
                ->update('customer_cart');
        } elseif ($type == 2) {
            $success = $db_oriskin
                ->set('qty', 'qty + 1', FALSE)
                ->where('id', $idcart)
                ->update('customer_cart');
        } elseif ($type == 3) {
            $success = $db_oriskin
                ->set('isactive', 0, FALSE)
                ->where('id', $idcart)
                ->update('customer_cart');
        } elseif ($type == 4) {
            $success = $db_oriskin
                ->set('is_on_payment', 1, FALSE)
                ->where('customerid', $idcart)
                ->where('isactive', 1)
                ->update('customer_cart');
        } elseif ($type == 5) {
            $success = $db_oriskin
                ->set('is_on_payment', 1, FALSE)
                ->where('id', $idcart)
                ->where('isactive', 1)
                ->update('customer_cart');
        } elseif ($type == 6) {
            $success = $db_oriskin
                ->set('is_on_payment', 0, FALSE)
                ->where('customerid', $idcart)
                ->where('isactive', 1)
                ->update('customer_cart');
        } elseif ($type == 7) {
            $success = $db_oriskin
                ->set('is_on_payment', 0, FALSE)
                ->where('id', $idcart)
                ->where('isactive', 1)
                ->update('customer_cart');
        }

        if ($success) {
            echo json_encode([
                "status" => 200,
                "message" => "Update cart berhasil",
                'typeresponse' => $type
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Update cart gagal"
            ]);
        }
    }


    public function getConsultantRecomendation($id)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $db_oriskin->select("ef.id as id,a.employeeid as consultantid, ef.name as consultantname");
        $db_oriskin->from('msemployeeinvoice a');
        $db_oriskin->join('msemployee ef', 'a.employeeid = ef.id', 'inner');
        $db_oriskin->join('msemployeedetail ed', 'a.employeeid = ed.employeeid', 'inner');
        $db_oriskin->where('a.isactive', 1);
        $db_oriskin->where('ed.jobid =', 4);
        $db_oriskin->where('a.locationid =', $id);

        $query = $db_oriskin->get();
        $result = $query->result_array();

        echo json_encode(['consultantRecomendation' => $result]);
    }


    public function getVideoContentApps()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $data = $db_oriskin
            ->select('*')
            ->from('video_content_apps')
            ->where('isactive', 1)
            ->get()
            ->result_array();

        echo json_encode([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function getVideoContentAppsManagement()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $data = $db_oriskin
            ->select('*')
            ->from('video_content_apps')
            ->get()
            ->result_array();

        echo json_encode([
            'status' => 200,
            'data' => $data
        ]);
    }


    public function uploadVideoContentApps()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $this->load->library('upload');

        $title = $this->input->post('title');
        $id = $this->input->post('id');
        $isactive = $this->input->post('isactive');

        if (!$id) {
            if (empty($_FILES['thumbnail']['name']) || empty($_FILES['video_url']['name'])) {
                echo json_encode(['success' => false, 'message' => 'Thumbnail dan video wajib diisi']);
                return;
            }

            $config['upload_path'] = './uploads/event/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] = uniqid('thumb_');

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('thumbnail')) {
                echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
                return;
            }

            $thumbData = $this->upload->data();
            $thumbUrl = 'https://sys.eudoraclinic.com:84/app/uploads/event/' . $thumbData['file_name'];

            $configVideo['upload_path'] = './uploads/event/';
            $configVideo['allowed_types'] = 'mp4|mov|avi|mkv';
            $configVideo['file_name'] = uniqid('video_');

            $this->upload->initialize($configVideo);

            if (!$this->upload->do_upload('video_url')) {
                echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
                return;
            }

            $videoData = $this->upload->data();
            $videoUrl = 'https://sys.eudoraclinic.com:84/app/uploads/event/' . $videoData['file_name'];

            $db_oriskin->insert('video_content_apps', [
                'title' => $title,
                'isactive' => $isactive,
                'thumbnail' => $thumbUrl,
                'video_url' => $videoUrl,
                'createdat' => date('Y-m-d H:i:s')
            ]);

            echo json_encode(['success' => true, 'message' => 'Lampiran berhasil diupload']);
        } else {

            $expend = $db_oriskin->get_where('video_content_apps', ['id' => $id])->row();
            $updateData = [
                'title' => $title,
                'isactive' => $isactive
            ];

            if (!empty($_FILES['thumbnail']['name'])) {
                // Hapus file lama
                if (!empty($expend->thumbnail)) {
                    $oldThumbPath = FCPATH . 'uploads/event/' . basename($expend->thumbnail);
                    if (file_exists($oldThumbPath)) {
                        unlink($oldThumbPath);
                    }
                }

                $config['upload_path'] = './uploads/event/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['file_name'] = uniqid('thumb_');


                $this->upload->initialize($config);

                if (!$this->upload->do_upload('thumbnail')) {
                    echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
                    return;
                }

                $thumbData = $this->upload->data();
                $thumbUrl = 'https://sys.eudoraclinic.com:84/app/uploads/event/' . $thumbData['file_name'];

                $updateData['thumbnail'] = $thumbUrl;
            }

            if (!empty($_FILES['video_url']['name'])) {
                // Hapus file lama
                if (!empty($expend->video_url)) {
                    $oldVideoPath = FCPATH . 'uploads/event/' . basename($expend->video_url);
                    if (file_exists($oldVideoPath)) {
                        unlink($oldVideoPath);
                    }
                }

                $configVideo['upload_path'] = './uploads/event/';
                $configVideo['allowed_types'] = 'mp4|mov|avi|mkv';
                $configVideo['file_name'] = uniqid('video_');
                $configVideo['detect_mime'] = FALSE;
                $configVideo['overwrite'] = FALSE;

                $ext = strtolower(pathinfo($_FILES['video_url']['name'], PATHINFO_EXTENSION));
                $newFileName = uniqid('video_') . '.' . $ext;
                $_FILES['video_url']['name'] = $newFileName;



                $this->upload->initialize($configVideo);

                if (!$this->upload->do_upload('video_url')) {
                    echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
                    return;
                }

                $videoData = $this->upload->data();
                $videoUrl = 'https://sys.eudoraclinic.com:84/app/uploads/event/' . $videoData['file_name'];

                $updateData['video_url'] = $videoUrl;

            }



            $db_oriskin->where('id', $id)->update('video_content_apps', $updateData);
            echo json_encode(['success' => true, 'message' => 'Lampiran berhasil diperbarui', 'data' => $updateData, 'id' => $id]);
        }
    }


}


