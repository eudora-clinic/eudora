<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ControllerEmployeeApps extends CI_Controller
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
        $this->load->model('ModelEmployeeApps');

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
                case 'addEmployeeAccount':
                    $data = [
                        'title' => 'Add Employee Account',
                        'content' => 'EmployeeApps/addEmployeeAccount',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'employeeAttendanceHistory':
                    $data = [
                        'title' => 'Add Employee Account',
                        'content' => 'EmployeeApps/employeeAttendanceHistory',
                    ];
                    $data['mod'] = $type;
                    $data['id'] = $this->uri->segment(2);
                    break;
                case 'employeeAttendanceList':
                    $data = [
                        'title' => 'Add Employee Account',
                        'content' => 'EmployeeApps/employeeAttendanceList',
                    ];
                    $data['mod'] = $type;
                    $data['locations'] = $this->ModelEmployeeApps->get_location();
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
                case 'hrSetLocationPin':
                    $data = [
                        'title' => 'Set location pin',
                        'content' => 'EmployeeApps/hrSetLocationPin',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'employeeAccountList':
                    $data = [
                        'title' => 'Employee Account List',
                        'content' => 'EmployeeApps/employeeAccountList',
                    ];
                    $data['mod'] = $type;
                    $data['locations'] = $this->ModelEmployeeApps->get_location();
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

        // Hilangkan semua karakter non-angka
        $phonenumber_valid = preg_replace('/\D/', '', $phonenumber);

        $mobile_number = $phonenumber_valid; // default

        if (!preg_match("/[^0-9]/", trim($phonenumber_valid))) {
            // Jika sudah pakai 62 di depan
            if (substr($phonenumber_valid, 0, 2) == '62') {
                $mobile_number = $phonenumber_valid;
            }
            // Jika pakai 0 di depan → ganti jadi 62
            else if (substr($phonenumber_valid, 0, 1) == '0') {
                $mobile_number = '62' . substr($phonenumber_valid, 1);
            }
        }

        return $mobile_number;
    }


    public function getEmployees()
    {
        header('Content-Type: application/json');

        $search = $this->input->get('search');
        $data = $this->ModelEmployeeApps->getEmployees($search);

        echo json_encode($data);
    }

    public function getEmployeeDetail($id)
    {
        header('Content-Type: application/json');

        $data = $this->ModelEmployeeApps->get_employee_by_id($id);

        if ($data) {
            echo json_encode([
                'status' => true,
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Employee tidak ditemukan'
            ]);
        }
    }

    // Documentation - Versi Simpan IMG ke dalam Path uploads/employee/attendances
    public function employeeAttendances()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $db_oriskin = $this->load->database('oriskin', true);

        $employeeaccountid = $this->input->post('employeeaccountid');
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');
        $attendance_type = $this->input->post('attendance_type');

        $employee = $db_oriskin->select('*')
            ->from('msemployee')
            ->where('id', $employeeaccountid)
            ->get()
            ->row_array();

        $employeeaccount = $db_oriskin->select('*')
            ->from('employee_account')
            ->where('employeeid', $employeeaccountid)
            ->get()
            ->row_array();

        $today = date('Y-m-d');

        $attendance_checkin = $db_oriskin->select('*')
            ->from('employee_attendance')
            ->where('employeeaccountid', $employeeaccountid)
            ->where('attendance_type', 'checkin')
            ->where('createdat >=', $today . ' 00:00:00')
            ->where('createdat <=', $today . ' 23:59:59')
            ->where('status', 1)
            ->get()
            ->row_array();

        $attendance_checkout = $db_oriskin->select('*')
            ->from('employee_attendance')
            ->where('employeeaccountid', $employeeaccountid)
            ->where('attendance_type', 'checkout')
            ->where('createdat >=', $today . ' 00:00:00')
            ->where('createdat <=', $today . ' 23:59:59')
            ->where('status', 1)
            ->get()
            ->row_array();

        if (!$employeeaccountid || !$latitude || !$longitude) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Lokasi dan koordinat kosong, coba lagi'
            ]);
            return;
        }

        if ($employeeaccount['isactive'] == 0) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Akun anda di non aktif, hubungi HR'
            ]);
            return;
        }

        if ($attendance_type === 'checkin' && $attendance_checkin) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Anda sudah melakukan absensi checkin hari ini'
            ]);
            return;
        }

        if ($attendance_type === 'checkout') {
            if (!$attendance_checkin) {
                echo json_encode([
                    'status' => 'failed',
                    'message' => 'Anda belum melakukan checkin hari ini, tidak bisa melakukan absensi checkout'
                ]);
                return;
            }

            if ($attendance_checkout) {
                echo json_encode([
                    'status' => 'failed',
                    'message' => 'Anda sudah melakukan absensi checkout hari ini'
                ]);
                return;
            }
        }

        $nip = $employee['nip'] ?? null;

        $image_path = null;

        if (empty($_FILES)) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Tidak ada file yang dikirim',
                'debug' => $_FILES
            ]);
            return;
        }


        if (!empty($_FILES['images']['name'])) {
            $upload_path = './uploads/employee/attendance/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0775, true);
                chmod($upload_path, 0777);
            }

            $file_ext = pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION);
            $new_name = uniqid() . '.' . strtolower($file_ext);
            $full_path = $upload_path . $new_name;

            if (move_uploaded_file($_FILES['images']['tmp_name'], $full_path)) {
                $image_path = 'uploads/employee/attendance/' . $new_name;

            } else {
                echo json_encode([
                    'status' => 'failed',
                    'message' => 'Gagal upload file'
                ]);
                return;
            }
        }

        $attendance_time = new DateTime();

        $locationname = $this->ModelEmployeeApps->get_nearest_locationname($latitude, $longitude);

        $data = [
            'employeeaccountid' => $employeeaccountid,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'images' => $image_path,
            'imagebase64' => null,
            'attendance_type' => $attendance_type,
            'createdat' => date('Y-m-d H:i:s'),
            'updatedat' => date('Y-m-d H:i:s'),
            'attendance_time' => $attendance_time->format('H:i:s'),
            'status' => 1,
            'employeenip' => $nip,
            'locationname' => $locationname
        ];


        $result = $this->ModelEmployeeApps->insert_employee_attendances($data);

        if ($result === true) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Berhasil melakukan absensi',
                'data' => $data
            ]);
        } else {
            $db_error = $db_oriskin->error();
            echo json_encode([
                'status' => 'failed',
                'message' => 'Terjadi kesalahan di server, coba lagi',
                'db_error' => $db_error
            ]);
        }
    }

    public function getAllEmployeeAttendances()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $db_oriskin->select("*");
        $db_oriskin->from('employee_attendance');
        $query = $db_oriskin->get();
        $data = $query->result_array();

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Berhasil menampilkan data!',
                'employeeAttendances' => $data
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data belum tersedia!'
            ]);
        }
    }

    public function getAllEmployeeAccount()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $location = $this->input->get('location') ?? null;

        $data = $this->ModelEmployeeApps->get_employee_account($location);

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Berhasil menampilkan data!',
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data belum tersedia!'
            ]);
        }
    }

    public function getEmployeeAttendanceById($employeeaccountid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $employeeaccountid = $this->input->post('employeeaccountid');
        $data = $this->ModelEmployeeApps->get_employee_attendances_by_id($employeeaccountid);

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Berhasil menampilkan data!',
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data belum tersedia!'
            ]);
        }
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menampilkan data!'
        ]);
    }

    public function getEmployeeAttendanceByIdByMonth()
    {
        $employeeaccountid = $this->input->get('employeeaccountid');
        $date = $this->input->get('date');

        $data = $this->ModelEmployeeApps->get_employee_attendances_by_id_by_month($employeeaccountid, $date);

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Berhasil menampilkan data!',
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data belum tersedia!'
            ]);
        }
    }

    // public function getAttendanceByEmployee($employeeaccountid)
    // {
    //     $data = $this->Employee_model->getEmployeeAttendanceById($employeeaccountid);

    //     $events = [];
    //     foreach ($data as $row) {
    //         $events[] = [
    //             'title' => "Check-in: " . ($row['checkin_time'] ?? '-') . " | Check-out: " . ($row['checkout_time'] ?? '-'),
    //             'start' => $row['attendance_date'] . 'T' . ($row['checkin_time'] ?? '00:00:00'),
    //             'end'   => $row['attendance_date'] . 'T' . ($row['checkout_time'] ?? '23:59:59'),
    //             'description' => "Work Hours: " . ($row['work_hours'] ?? 0) . " Jam"
    //         ];
    //     }

    //     echo json_encode($events);
    // }

    public function login()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);

        $nip = $postData["nip"] ?? null;
        $password = $postData["password"] ?? null;
        $phone_model = $postData["phone_model"] ?? null;
        $phone_brand = $postData["phone_brand"] ?? null;

        if (!$nip || !$password) {
            echo json_encode([
                'status' => false,
                'message' => 'NIP dan Password wajib diisi.'
            ]);
            return;
        }

        $user = $db_oriskin->select('a.employeeid, a.password, e.nip, e.name,a.isactive,a.phone_model,a.phone_brand,a.token')
            ->from('employee_account a')
            ->join('msemployee e', 'e.id = a.employeeid', 'left')
            ->where('e.nip', $nip)
            ->get()
            ->row_array();

        if (!$user) {
            echo json_encode([
                'status' => false,
                'message' => 'NIP anda tidak terdaftar.'
            ]);
            return;
        }

        if ($user['isactive'] == 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Akun anda nonaktif.Silahkan menghubungi HR untuk mengaktifkan akun.'
            ]);
            return;
        }

        if ($password != $user['password']) {
            echo json_encode([
                'status' => false,
                'message' => 'Password salah.'
            ]);
            return;
        }

        if ($user['phone_model'] == null && $user['phone_brand'] == null) {
            $db_oriskin->where('employeeid', $user['employeeid'])
                ->update('employee_account', [
                    'phone_model' => $phone_model,
                    'phone_brand' => $phone_brand,
                ]);
        } else if ($phone_model != $user['phone_model'] && $phone_brand != $user['phone_brand']) {
            echo json_encode([
                'status' => false,
                'message' => 'Silahkan login menggunakan perangkat terdaftar.Hubungi HR untuk reset informasi akun.'
            ]);
            return;
        }



        $token = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 25);
        $db_oriskin->where('employeeid', $user['employeeid'])
            ->update('employee_account', ['token' => $token]);

        // else {
        //     echo json_encode([
        //         'status' => false,
        //         'message' => 'Anda terdeteksi telah login.Silahkan meminta reset akun kepada bagian HR.'
        //     ]);
        //     return;
        // }

        echo json_encode([
            'status' => true,
            'message' => 'Berhasil login ke akun anda',
            'token' => $user['token'],
            'data' => [
                'nip' => $user['nip'],
                'name' => $user['name'],
                'employeeid' => $user['employeeid'],
                'token' => $token
            ]
        ]);
    }

    public function resetPassword()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $user_id = $this->session->userdata('userid');
        $id = $this->input->post('id');

        if (empty($id)) {
            echo json_encode([
                'status' => false,
                'message' => 'Silahkan pilih employee terlebih dahulu'
            ]);
            return;
        }

        $employeeaccount = $db_oriskin->select('a.*, e.name, e.cellphonenumber, e.nip, a.phone_model, a.phone_brand, a.token')
            ->from('employee_account a')
            ->join('msemployee e', 'e.id = a.employeeid')
            ->where('a.id', $id)
            ->get()
            ->row_array();

        if (!$employeeaccount) {
            echo json_encode([
                'status' => "error",
                'message' => "Akun belum terdaftar, silahkan registrasi terlebih dahulu"
            ]);
            return;
        }
        $newPassword = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 8);
        $db_oriskin->trans_start();
        $db_oriskin->where('id', $id)
            ->update('employee_account', [
                'password' => $newPassword,
                'updatedby' => $user_id,
                'updatedat' => date('Y-m-d H:i:s'),
                'token' => null,
                'phone_brand' => null,
                'phone_model' => null
            ]);

        $db_oriskin->trans_complete();

        if ($db_oriskin->trans_status() === FALSE) {
            echo json_encode([
                'status' => "error",
                'message' => "Gagal mereset password, transaksi dibatalkan!"
            ]);
            return;
        }

        $phone = $this->formatPhoneNumber($employeeaccount['cellphonenumber']);
        $data = [
            "recipient_type" => "individual",
            "to" => $phone,
            "type" => "text",
            "text" => [
                "body" =>
                    "Password akun anda telah direset." .
                    "\nNIP : " . $employeeaccount['nip'] .
                    "\nNama : " . $employeeaccount['name'] .
                    "\nPassword Baru : " . $newPassword .
                    "\n\nSilahkan untuk mendownload aplikasi absen Eudora Company pada link berikut:" .
                    "\n\nUntuk iOS: https://apps.apple.com/us/app/eudora-company/id6752916273" .
                    "\n\n Untuk Android: https://play.google.com/store/apps/details?id=com.company.eudorainternalapplication&pcampaignid=web_share"
            ]
        ];

        $this->sendNotif($data);

        echo json_encode([
            'status' => "success",
            'message' => "Password berhasil direset dan dikirim ke nomor HP!"
        ]);
    }

    public function toggleActive()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $this->output->set_content_type('application/json');

        $id = $this->input->post('id');

        $account = $this->ModelEmployeeApps->get_employee_account_by_id($id);

        if (!$account) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);
            return;
        }

        $newStatus = $account['isactive'] == 1 ? 0 : 1;

        $data = [
            'isactive' => $newStatus,
            'updatedby' => $this->session->userdata('userid'),
            'updatedat' => date('Y-m-d H:i:s')
        ];

        $update = $this->ModelEmployeeApps->update_employee_account($id, $data);

        if ($update) {
            echo json_encode([
                'status' => 'success',
                'message' => "Status berhasil diubah menjadi " . ($newStatus == 1 ? 'Active' : 'Nonactive')
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => "Gagal update status",
                'db_error' => $db_oriskin->error()
            ]);
        }
        exit;
    }


    public function deleteEmployee()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $this->output->set_content_type('application/json');

        $id = $this->input->post('id');

        $data = [
            'isdeleted' => 1
        ];

        $update = $this->ModelEmployeeApps->deletedEmployee($id, $data);

        if ($update) {
            echo json_encode([
                'status' => 'success',
                'message' => "Berhasil menghapus data karyawan"
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => "Gagal update status",
                'db_error' => $db_oriskin->error()
            ]);
        }
        exit;
    }



    public function toggleActiveAccount($id)
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $this->output->set_content_type('application/json');

        $account = $this->ModelEmployeeApps->get_employee_account_by_id($id);

        if (!$account) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);
            return;
        }

        $newStatus = $account['isactive'] == 1 ? 0 : 1;

        $update = $this->ModelEmployeeeApps->update_employee_account($id, [
            'isactive' => $newStatus,
            'updatedby' => $this->session->userdata('userid'),
            'updatedat' => date('Y-m-d H:i:s')
        ]);

        if ($update) {
            echo json_encode([
                'status' => 'success',
                'message' => "Status berhasil diubah menjadi " . ($newStatus == 1 ? 'Active' : 'Nonactive')
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => "Gagal update status",
                'db_error' => $db_oriskin->error()
            ]);
        }
        exit;
    }

    public function getEmployeeAttendanceByIdAndDate($employeeaccountid, $date)
    {
        $data = $this->ModelEmployeeApps->getEmployeeAttendanceByIdAndDate($employeeaccountid, $date);

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Berhasil menampilkan data!',
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data belum tersedia!'
            ]);
        }
    }

    public function getAllEmployeeAttendance()
    {
        $date = $this->input->get('date');
        $location = $this->input->get('location');

        $data = $this->ModelEmployeeApps->get_employee_attendance($date, $location);

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Berhasil menampilkan data!',
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data belum tersedia!',
                'data' => []
            ]);
        }
    }

    public function updateStatus()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $id = $this->input->post('id');

        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan']);
            return;
        }

        $attendance = $db_oriskin->select('*')
            ->from('employee_attendance')
            ->where('id', $id)
            ->get()
            ->row_array();

        if (!$attendance) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Data attendance tidak ditemukan']);
            return;
        }

        $status = $attendance['status'];
        $newStatus = null;
        $message = '';

        if ($status === 0) {
            $newStatus = 1;
            $message = 'Attendance approved successfully';
        } elseif ($status === 1) {
            $newStatus = 0;
            $message = 'Attendance rejected successfully';
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Status tidak valid untuk update']);
            return;
        }

        $update = $this->ModelEmployeeApps->updateStatus($id, $newStatus);

        if ($update) {
            echo json_encode(['success' => true, 'message' => $message]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Gagal update status']);
        }
    }
    public function get_employee_detail($employeeaccountid)
    {
        $data = $this->ModelEmployeeApps->get_employee_detail($employeeaccountid);

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Berhasil menampilkan data!',
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data belum tersedia!'
            ]);
        }
    }


    public function accountRegistration()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $db_oriskin = $this->load->database('oriskin', true);
        $user_id = $this->session->userdata('userid');

        $employeeid = $this->input->post('employeeid');

        if (empty($employeeid)) {
            echo json_encode([
                'status' => false,
                'message' => 'Silahkan pilih employee terlebih'
            ]);
            return;
        }

        if (empty($employeeid)) {
            echo json_encode([
                'status' => false,
                'message' => 'Silahkan pilih employee terlebih'
            ]);
            return;
        }

        $randomPassword = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 8);

        $cek = $db_oriskin->where('employeeid', $employeeid)
            ->get('employee_account')
            ->row_array();
        $employee = $db_oriskin->select('*')
            ->where('id', $employeeid)
            ->get('msemployee')
            ->row_array();
        if (empty($employee['nip'])) {
            echo json_encode([
                'status' => false,
                'message' => 'NIP belum terdaftar'
            ]);
            return;
        }

        if (!$cek) {
            $employeeData = [
                'employeeid' => $employeeid,
                'password' => $randomPassword,
                'createdby' => $user_id,
                'employeenip' => $employee['nip'],
                'isactive' => 1,
            ];
            $insert = $db_oriskin->insert('employee_account', $employeeData);
            $phone = $this->formatPhoneNumber($employee['cellphonenumber']);
            if ($insert) {
                $data = array(
                    "recipient_type" => "individual",
                    "to" => $phone,
                    "type" => "text",
                    "text" => array(
                        "body" => "Berhasil mendaftarkan akun anda.\nNIP : " . $employee['nip'] . "\nNama : " . $employee['name'] . "\nPassword : " . $randomPassword . "\nSilahkan untuk mendownload aplikasi absen Eudora Company pada link berikut \n\nUntuk IOS \nhttps://apps.apple.com/us/app/eudora-company/id6752916273 \n\nUntuk Android \nhttps://play.google.com/store/apps/details?id=com.company.eudorainternalapplication&pcampaignid=web_share"
                    )
                );
                $this->sendNotif($data);
                echo json_encode([
                    'status' => "success",
                    'message' => "Berhasil mendaftarkan akun!"
                ]);
            } else {
                echo json_encode([
                    'status' => "error",
                    'message' => "Gagal menambahkan akun!"
                ]);
            }

        } else {
            echo json_encode([
                'status' => "error",
                'message' => "Akun employee telah terdaftar"
            ]);
        }
    }

    public function getPins()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $data = $db_oriskin->select('*')->from('location_pins')->get()->result_array();

        if ($data) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Berhasil menampilkan data location!',
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data belum tersedia!'
            ]);
        }
    }

    public function savePin()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $user_id = $this->session->userdata('userid');

        if (empty($postData['lat']) || empty($postData['lng'])) {
            echo json_encode(['status' => false, 'message' => 'Lat/Lng kosong']);
            return;
        }

        $data = [
            'locationname' => $postData['location_name'],
            'latitude' => $postData['lat'],
            'longitude' => $postData['lng'],
            'createdat' => date('Y-m-d H:i:s'),
            'createdby' => $user_id,
            'isactive' => 1,
        ];

        $db_oriskin->insert('location_pins', $data);

        if ($db_oriskin->affected_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Pin tersimpan'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal simpan'
            ]);
        }
    }

    public function deletePin($id)
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $db_oriskin->delete('location_pins', ['id' => $id]);
        if ($db_oriskin->affected_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Pin berhasil dihapus!'
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'Gagal menghapus pin'
            ]);
        }

    }

    public function disablePin($id)
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $db_oriskin->where('id', $id);
        $db_oriskin->update('location_pins', ['isactive' => 0]);
        if ($db_oriskin->affected_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Pin berhasil dinonaktifkan!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal menonaktifkan pin'
            ]);
        }
    }

    public function enablePin($id)
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $db_oriskin->where('id', $id);
        $db_oriskin->update('location_pins', ['isactive' => 1]);
        if ($db_oriskin->affected_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Pin berhasil diaktifkan!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal mengaktifkan pin'
            ]);
        }
    }

    public function getMonthlyAttendanceSummary()
    {
        $employee_id = $this->input->get('employeeaccountid');
        $month = $this->input->get('date');

        if (!$employee_id || !$month) {
            echo json_encode(['status' => 'error', 'message' => 'Parameter tidak lengkap']);
            return;
        }

        $this->load->model('ModelEmployeeApps');
        $result = $this->ModelEmployeeApps->get_monthly_attendance_summary($employee_id, $month);

        echo json_encode([
            'status' => 'success',
            'summary' => $result['summary']
        ]);
    }

    public function updateAllLocationNames()
    {
        $this->load->model('ModelEmployeeApps');
        $this->ModelEmployeeApps->update_all_locationnames();
    }

    public function getNearestLocation()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        header('Content-Type: application/json');

        $rawData = file_get_contents("php://input");
        $json = json_decode($rawData, true);

        $latitude = $json['latitude'] ?? $this->input->post('latitude');
        $longitude = $json['longitude'] ?? $this->input->post('longitude');

        if (!$latitude || !$longitude) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Latitude dan longitude harus dikirim.'
            ]);
            return;
        }

        $result = $this->ModelEmployeeApps->get_distance_employee($latitude, $longitude);

        if ($result === 'Unknown') {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Tidak ditemukan lokasi terdekat.'
            ]);
            return;
        }

        echo json_encode([
            'status' => 'success',
            'data' => $result
        ]);
    }


    public function blastAccountEmployee()
    {
        $db_oriskin = $this->load->database('oriskin', true);

        $employeeAccounts = $db_oriskin->select('a.*, e.name, e.cellphonenumber, e.nip, a.phone_model, a.phone_brand, a.token')
            ->from('employee_account a')
            ->join('msemployee e', 'e.id = a.employeeid')
            ->where('a.token IS NULL', null, false)
            ->get()
            ->result_array();

        if (!empty($employeeAccounts)) {
            foreach ($employeeAccounts as $index => $employeeaccount) {
                $phone = $this->formatPhoneNumber($employeeaccount['cellphonenumber']);

                $data = [
                    "recipient_type" => "individual",
                    "to" => $phone,
                    "type" => "text",
                    "text" => [
                        "body" =>
                            "Password akun anda telah direset." .
                            "\nNIP : " . $employeeaccount['nip'] .
                            "\nNama : " . $employeeaccount['name'] .
                            "\nPassword Baru : " . $employeeaccount['password'] .
                            "\n\nSilahkan untuk mendownload aplikasi absen Eudora Company pada link berikut:" .
                            "\n\nUntuk iOS: https://apps.apple.com/us/app/eudora-company/id6752916273" .
                            "\n\nUntuk Android: https://play.google.com/store/apps/details?id=com.company.eudorainternalapplication&pcampaignid=web_share"
                    ]
                ];

                $this->sendNotif($data);
                echo "Notifikasi berhasil dikirim ke: " . $employeeaccount['name'] . " (" . $phone . ")<br>";

                sleep(5);
            }

            echo json_encode([
                'status' => "success",
                'message' => "Password berhasil direset dan dikirim ke nomor HP semua akun!"
            ]);
        } else {
            echo json_encode([
                'status' => "info",
                'message' => "Tidak ada akun yang perlu dikirim notifikasi."
            ]);
        }
    }

}


