<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ControllerCompany extends CI_Controller
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
                case 'listCompany':
                    $data['listCity'] = $this->ModelCompany->getCityMaster();
                    $data['listProvince'] = $this->ModelCompany->getProvinceMaster();
                    $data['listCountry'] = $this->ModelCompany->getCountryMaster();
                    $data['level'] = $this->session->userdata('level');
                    $data['title'] = 'listCompany';
                    $data['content'] = 'Company/listCompany';
                    $data['mod'] = $type;
                    break;
                case 'listWarehouse':
                    $data['listCity'] = $this->ModelCompany->getCityMaster();
                    $data['level'] = $this->session->userdata('level');
                    $data['title'] = 'listWarehouse';
                    $data['content'] = 'Company/listWarehouse';
                    $data['mod'] = $type;
                    break;
                case 'listUser':
                    $data['title'] = 'listUser';
                    $data['content'] = 'Company/listUser';
                    $data['mod'] = $type;
                    break;
                case 'listAccessLocationUser':
                    $data['title'] = 'listAccessLocationUser';
                    $data['content'] = 'Company/listAccessLocationUser';
                    $data['mod'] = $type;
                    break;
                case 'listAccessCompanyUser':
                    $data['title'] = 'listAccessCompanyUser';
                    $data['content'] = 'Company/listAccessCompanyUser';
                    $data['mod'] = $type;
                    break;
                case 'listAccessWarehouseUser':
                    $data['title'] = 'listAccessWarehouseUser';
                    $data['content'] = 'Company/listAccessWarehouseUser';
                    $data['mod'] = $type;
                    break;
                case 'listCity':
                    $data['title'] = 'listCity';
                    $data['cities'] = $this->ModelCompany->getAllCity();
                    $data['content'] = 'Company/listCity';
                    $data['mod'] = $type;
                    break;
            }
            $db_oriskin = $this->load->database('oriskin', true);
            $userid = $this->session->userdata('userid');
            $locationid = $this->session->userdata('locationid');
            $query = $db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
            $locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';
            $locationList = $db_oriskin->query("SELECT DISTINCT id, name FROM mslocation")->result_array();
            $data['locationList'] = $locationList;
            $data['locationId'] = $locationid;
            $data['userId'] = $userid;
            $this->load->view('index', $data);
        }
    }


    public function getCompanyMaster()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $data = $this->ModelCompany->getCompanyMaster();

        echo json_encode([
            'listCompany' => $data,
        ]);
    }
    public function getLocation()
    {
        header('Content-Type: application/json');

        $search = $this->input->get('search');
        $data = $this->ModelCompany->get_location($search);

        echo json_encode($data);
    }



    public function getListUsers()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $data = $this->ModelCompany->getListUsers();

        echo json_encode([
            'listUsers' => $data,
        ]);
    }

    public function getWarehouseMaster()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $data = $this->ModelCompany->getWarehouseMaster();

        echo json_encode([
            'listWarehouse' => $data,
        ]);
    }

    public function getCompanyMasterById($id)
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelCompany->getCompanyMasterById($id);

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

    public function getWarehouseMasterById($id)
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelCompany->getWarehouseMasterById($id);

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

    public function createCompanyMaster()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $companyname = $this->input->post('companyname');
        $companycode = $this->input->post('companycode');
        $location = $this->input->post('locationid');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $postalcode = $this->input->post('postalcode');
        $website = $this->input->post('website');
        $cityid = $this->input->post('cityid');
        $provinceid = $this->input->post('provinceid');
        $countryid = $this->input->post('countryid');

        if (!$companyname || !$companycode) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $db_oriskin->select('companycode');
        $db_oriskin->from('mscompany');
        $db_oriskin->where('companycode', $companycode);
        $companycodeCheck = $db_oriskin->get()->row('companycode');

        if ($companycodeCheck) {
            echo json_encode([
                'success' => false,
                'message' => 'Kode ini sudah ada',
            ]);
            return;
        }

        $updateData = [
            'companyname' => $companyname,
            'companycode' => $companycode,
            'address' => !empty($address) ? $address : null,
            'createdate' => date('Y-m-d H:i:s'),
            'createbyuserid' => $this->session->userdata('userid'),
            'phone' => !empty($phone) ? $phone : null,
            'email' => !empty($email) ? $email : null,
            'postalcode' => !empty($postalcode) ? $postalcode : null,
            'website' => !empty($website) ? $website : null,
            'cityid' => !empty($cityid) ? $cityid : null,
            'provinceid' => !empty($provinceid) ? $provinceid : null,
            'countryid' => !empty($countryid) ? $countryid : null,
            'isactive' => 1
        ];

        $result = $this->ModelCompany->createCompanyMaster($updateData);



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

    public function createWarehouseMaster()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $warehouse_name = $this->input->post('warehouse_name');
        $warehouse_code = $this->input->post('warehouse_code');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $cityid = $this->input->post('cityid');

        if (!$warehouse_name || !$warehouse_code) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $db_oriskin->select('warehouse_code');
        $db_oriskin->from('mswarehouse');
        $db_oriskin->where('warehouse_code', $warehouse_code);
        $companycodeCheck = $db_oriskin->get()->row('warehouse_code');

        if ($companycodeCheck) {
            echo json_encode([
                'success' => false,
                'message' => 'Kode ini sudah ada',
            ]);
            return;
        }

        $updateData = [
            'warehouse_name' => $warehouse_name,
            'warehouse_code' => $warehouse_code,
            'address' => !empty($address) ? $address : null,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('userid'),
            'phone' => !empty($phone) ? $phone : null,
            'email' => !empty($email) ? $email : null,
            'cityid' => !empty($cityid) ? $cityid : null,
            'is_active' => 1
        ];

        $result = $this->ModelCompany->createWarehouseMaster($updateData);

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
        $companyname = $this->input->post('companyname');
        $companycode = $this->input->post('companycode');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $postalcode = $this->input->post('postalcode');
        $website = $this->input->post('website');
        $cityid = $this->input->post('cityid');
        $provinceid = $this->input->post('provinceid');
        $countryid = $this->input->post('countryid');
        $isactive = $this->input->post('isactive');

        if (!$companyname || !$companycode || !$id) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $updateData = [
            'companyname' => $companyname,
            'companycode' => $companycode,
            'address' => !empty($address) ? $address : null,
            'updatedate' => date('Y-m-d H:i:s'),
            'updateuserid' => $this->session->userdata('userid'),
            'phone' => !empty($phone) ? $phone : null,
            'email' => !empty($email) ? $email : null,
            'postalcode' => !empty($postalcode) ? $postalcode : null,
            'website' => !empty($website) ? $website : null,
            'cityid' => !empty($cityid) ? $cityid : null,
            'provinceid' => !empty($provinceid) ? $provinceid : null,
            'countryid' => !empty($countryid) ? $countryid : null,
            'isactive' => $isactive
        ];

        $result = $this->ModelCompany->updateCompanyMaster($id, $updateData);

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

    public function updateWarehouseMaster()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $id = $this->input->post('id');
        $warehouse_name = $this->input->post('warehouse_name');
        $warehouse_code = $this->input->post('warehouse_code');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $cityid = $this->input->post('cityid');
        $isactive = $this->input->post('isactive');

        if (!$warehouse_name || !$warehouse_code || !$id) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $updateData = [
            'warehouse_name' => $warehouse_name,
            'warehouse_code' => $warehouse_code,
            'address' => !empty($address) ? $address : null,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('userid'),
            'phone' => !empty($phone) ? $phone : null,
            'email' => !empty($email) ? $email : null,
            'cityid' => !empty($cityid) ? $cityid : null,
            'is_active' => $isactive
        ];

        $result = $this->ModelCompany->updateWarehouseMaster($id, $updateData);

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

    public function createUser()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $level = $this->input->post('level');
        $locationid = $this->input->post('locationid');
        $locationaccsesid = $this->input->post('locationaccsesid');
        $isactive = $this->input->post('isactive');

        if (!$name || !$password || !$level || !$locationid || !$locationaccsesid || !$isactive) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }
        $data = [
            'name' => $name,
            'password' => $password,
            'level' => $level,
            'locationid' => $locationid,
            'locationaccsesid' => $locationaccsesid,
            'isactive' => $isactive,
            'updateuserid' => $this->session->userdata('userid')
        ];

        if ($id) {
            $result = $this->ModelCompany->updateUser($id, $data);

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
            $result = $this->ModelCompany->createUser($data);

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

    public function getUserById($id)
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelCompany->getUserById($id);

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



    public function getListUsersAccessLocation()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $data = $this->ModelCompany->getListUsersAccessLocation();

        echo json_encode([
            'listUsers' => $data,
        ]);
    }


    public function createUserLocationAccess()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $userid = $this->input->post('userid');
        $locationid = $this->input->post('locationid');
        $isactive = $this->input->post('isactive');

        if (!$userid || !$locationid) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $companycodeCheck = $this->ModelCompany->createUserLocationAccess($userid, $locationid);

        if ($companycodeCheck) {
            echo json_encode([
                'success' => false,
                'message' => 'Kode ini sudah ada',
            ]);
            return;
        }

        $updateData = [
            'userid' => $userid,
            'locationid' => $locationid,
            'isactive' => $isactive,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('userid')
        ];

        $result = $this->ModelCompany->createUserLocationAccess($updateData);

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



    public function getCompanyById($id)
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $data['listCountry'] = $db_oriskin->query("SELECT * FROM mscountry")->result_array();

        $data['companyData'] = [];
        if (!empty($id) && $id != '0') {
            $data['companyData'] = $this->ModelCompany->getCompanyById($id);
        }

        $title = (!empty($id) && $id != '0') ? 'Edit Company' : 'Tambah Company';
        $buttonText = (!empty($id) && $id != '0') ? 'Simpan' : 'Tambah';

        $modal_data = [
            'modal_id' => 'companyModal',
            'title' => $title,
            'modal_size' => 'modal-lg',
            'content' => $this->load->view('company/companyForm', $data, TRUE),
            'footer' => '
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" onclick="saveCompany()">' . $buttonText . '</button>
        '
        ];

        $this->load->view('component/modal', $modal_data);
    }



    public function createCompany()
    {
        $db = $this->load->database('oriskin', true);

        $data = [
            'companycode' => $this->input->post('companycode'),
            'companyname' => $this->input->post('companyname'),
            'address' => $this->input->post('address'),
            'cityid' => $this->input->post('cityid'),
            'provinceid' => $this->input->post('provinceid'),
            'countryid' => $this->input->post('countryid'),
            'postalcode' => $this->input->post('postalcode'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'website' => $this->input->post('website'),
            'isactive' => $this->input->post('isactive'),
            'createbyuserid' => $this->session->userdata('user_id'),
            'createdate' => date('Y-m-d H:i:s')
        ];

        $result = $db->insert('mscompany', $data);
        echo json_encode(['success' => $result, 'message' => $result ? 'Company berhasil dibuat' : 'Gagal membuat company']);
    }

    public function updateCompany()
    {
        $db = $this->load->database('oriskin', true);
        $id = $this->input->post('id');

        $data = [
            'companycode' => $this->input->post('companycode'),
            'companyname' => $this->input->post('companyname'),
            'address' => $this->input->post('address'),
            'cityid' => $this->input->post('cityid'),
            'provinceid' => $this->input->post('provinceid'),
            'countryid' => $this->input->post('countryid'),
            'postalcode' => $this->input->post('postalcode'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'website' => $this->input->post('website'),
            'isactive' => $this->input->post('isactive'),
            'updateuserid' => $this->session->userdata('user_id'),
            'updatedate' => date('Y-m-d H:i:s')
        ];

        $db->where('id', $id);
        $result = $db->update('mscompany', $data);
        echo json_encode(['success' => $result, 'message' => $result ? 'Company berhasil diupdate' : 'Gagal mengupdate company']);
    }



    public function getProvincesByCountry($countryId)
    {
        $db = $this->load->database('oriskin', true);
        $provinces = $db->select('id, name')
            ->from('msprovince')
            ->where('countryid', $countryId)
            ->order_by('name', 'ASC')
            ->get()
            ->result_array();

        echo json_encode(['success' => true, 'data' => $provinces]);
    }

    public function getCitiesByProvince($provinceId)
    {
        $db = $this->load->database('oriskin', true);
        $cities = $db->select('id, name')
            ->from('mscity')
            ->where('provinceid', $provinceId)
            ->order_by('name', 'ASC')
            ->get()
            ->result_array();

        echo json_encode(['success' => true, 'data' => $cities]);
    }


    public function updateUmkCity()
    {
        $id = $this->input->post('id');
        $umk = $this->input->post('umk');

        if (!$id || $umk === null) {
            echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        $update = $this->ModelCompany->updateUmkCity($id, $umk);
        if ($update) {
            echo json_encode(['status' => true, 'message' => 'UMK berhasil diperbarui']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal memperbarui UMK']);
        }
    }

}


