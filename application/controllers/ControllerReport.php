<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ControllerReport extends CI_Controller
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
        $this->load->model('ModelReport');
        $this->load->model('MApp');
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
                case 'reportRevenueByCustomer':
                    $data['title'] = 'reportRevenueByCustomer';
                    $data['content'] = 'Report/reportRevenueByCustomer';
                    $data['mod'] = $type;
                    break;
                case 'reportStockOpname':
                    // $data['title'] = 'reportStockOpname';
                    // $data['content'] = 'Report/reportStockOpname';
                    // $data['mod'] = $type;
                    $data = [
                        'title' => 'reportStockOpname',
                        'content' => 'Report/reportStockOpname',
                        'mod' => $type,
                        'locationListEmployee' => $this->MApp->get_location_list_purchasing(),
                        'location_id' => $this->session->userdata('locationid'),
                    ];
                    // $data['locationListEmployee'] = $this->MApp->get_location_list_purchasing();
                    // $data['location_id'] =$this->session->userdata('locationid'); 
                    break;
                case 'conditionReport':
                    $id = $this->uri->segment(2);
                    $data = [
                        'title' => 'conditionReport',
                        'content' => 'Report/conditionReport',
                        'mod' => $type,
                        'locationListEmployee' => $this->MApp->get_location_list_purchasing(),
                        'location_id' => $this->session->userdata('locationid'),
                        'location' => $this->ModelReport->getAllLocation(),
                        'facility' => $this->ModelReport->getFacilityById($id),
                        'id' => $id
                    ];
                    break;
                case 'facilityReportList':
                    $data = [
                        'title' => 'facilityReportList',
                        'content' => 'Report/facilityReportList',
                        'mod' => $type,
                        'locationListEmployee' => $this->MApp->get_location_list_purchasing(),
                        'location' => $this->ModelReport->getAllLocation(),
                        'category' => $this->ModelReport->getFacilityCategory(),
                        'location_id' => $this->session->userdata('locationid'),
                        'level' => $this->session->userdata('level'),
                    ];
                    break;
                case 'addFacilityByLocation':
                    $data = [
                        'title' => 'addFacilityByLocation',
                        'content' => 'Report/addFacilityByLocation',
                        'mod' => $type,
                        'locationListEmployee' => $this->MApp->get_location_list_purchasing(),
                        'location_id' => $this->session->userdata('locationid'),
                    ];
                    break;
                case 'stockOpnameDetail':
                    $id = $this->input->get('stock_opname_id', TRUE);
                    $data = $this->ModelReport->getDetailStockOpname($id);
                    $data = [
                        'title' => 'STOCK OPNAME DETAIL',
                        'content' => 'Report/stockOpnameDetail',
                        'data' => $data
                    ];
                    $data['mod'] = $type;
                    break;
                case 'reportTransactionsByProduct':
                    $data = [
                        'title' => 'STOCK OPNAME DETAIL',
                        'content' => 'Report/reportTransactionsByProduct',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'reportCustomerDoingAndSpending':
                    $data = [
                        'title' => 'STOCK OPNAME DETAIL',
                        'content' => 'Report/reportCustomerDoingAndSpending',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'reportLastCustomerSpendingAndPrepaidLeft':

                    $locationIdDefault = $this->session->userdata('locationid');
                    $locationIdSearch = $this->input->post('locationIdSearch') ? $this->input->post('locationIdSearch') : $locationIdDefault;

                    $data = [
                        'title' => 'STOCK OPNAME DETAIL',
                        'content' => 'Report/reportLastCustomerSpendingAndPrepaidLeft',
                        'locationIdSearch' => $locationIdSearch,
                        'locationList' => $this->MApp->get_location_list(),
                        'listCustomerLastSpending' => $this->ModelReport->getReportCustomerLast2YearSpendingAndPrepaidLeft($locationIdSearch),
                    ];
                    $data['mod'] = $type;
                    break;
                case 'reportTransactionCustomerEventRoadshow':
                    $dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
                    $dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
                    $data = [
                        'reportTransactionCustomerEventRoadshow' => $this->ModelReport->getReportTransactionGuestEventRoadshow($dateStart, $dateEnd, 1),
                        'title' => 'REPORT GUEST ADMIN',
                        'content' => 'Report/reportTransactionCustomerEventRoadshow',
                        'dateStart' => $dateStart,
                        'dateEnd' => $dateEnd
                    ];
                    $data['mod'] = $type;
                    break;
                case 'reportInvoiceLifeTimePackage':
                    $data = [
                        'title' => 'STOCK OPNAME DETAIL',
                        'content' => 'Report/reportInvoiceLifeTimePackage',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'reportFirstVisit':
                    $data = [
                        'title' => 'STOCK OPNAME DETAIL',
                        'content' => 'Report/reportFirstVisit',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'reportCommissionInvoiceProductTherapist':
                    $data = [
                        'title' => 'STOCK OPNAME DETAIL',
                        'content' => 'Report/reportCommissionInvoiceProductTherapist',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'reportAppointment':
                    $data = [
                        'title' => 'STOCK OPNAME DETAIL',
                        'content' => 'Report/reportAppointment',
                    ];
                    $data['mod'] = $type;
                    break;
                case 'reportAchievementConsultant':
                    $userid = $this->session->userdata('userid');
                    $period = $this->input->post('period') ? $this->input->post('period') : date('Y-m');
                    $start_date = $period . '-01';
                    $end_date = date('Y-m-t', strtotime($start_date));
                    $data = [
                        'summaryRevenueBySales' => $this->ModelReport->getSummaryReportAchievement($period, $userid),
                        'detailRevenueBySales' => $this->MApp->getDetailRevenueBySalesIncludeCommission($period, $userid),
                        'detailUnitNewMember' => $this->MApp->getDetailUnitNewMember($period, $userid),
                        'staffSalesInvoice' => $this->MApp->getStaffSalesInvoice($start_date, $end_date, $userid),
                        'title' => 'REPORT KPI CONSULTANT',
                        'content' => 'Report/reportAchievementConsultant',
                        'locationList' => $this->MApp->get_location_list(),
                        'period' => $period 
                    ];
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

    function handleReportRevenueByCustomer()
    {
        $period = $this->input->post('periodSearch') ?: date('Y-m');

        $reportDataCustomerExpend = $this->ModelReport->getReportRevenueByCustomer($period, 1);
        $reportDataSummary = $this->ModelReport->getReportRevenueByCustomer($period, 2);
        $reportDataNewMember = $this->ModelReport->getReportRevenueByCustomer($period, 3);

        if ($this->input->is_ajax_request()) {
            echo json_encode([
                'status' => 200,
                'dataCustomerSpend' => $reportDataCustomerExpend,
                'dataSummary' => $reportDataSummary,
                'dataNewMember' => $reportDataNewMember
            ]);
            exit;
        }
    }

    function getStockOpnameList()
    {
        $dateStart = $this->input->post('dateStart') ?: date('Y-m-d');
        $dateEnd = $this->input->post('dateEnd') ?: date('Y-m-d');


        $reportData = $this->ModelReport->getStockOpnameList($dateStart, $dateEnd);

        if ($this->input->is_ajax_request()) {
            echo json_encode([
                'status' => 200,
                'data' => $reportData
            ]);
            exit;
        }
    }

    public function zip_old_photos()
    {
        $files = $this->FileModel->get_files_by_past_months();

        if (empty($files)) {
            echo "Tidak ada file dari bulan sebelumnya.";
            return;
        }

        // kelompokkan berdasarkan bulan-tahun
        $grouped = [];
        foreach ($files as $f) {
            $month = date('m-Y', strtotime($f['upload_date']));
            $grouped[$month][] = $f['file_path'];
        }

        foreach ($grouped as $month_year => $paths) {
            $this->zip->clear_data();

            foreach ($paths as $path) {
                $fullPath = FCPATH . $path;
                if (file_exists($fullPath)) {
                    $this->zip->read_file($fullPath, basename($fullPath));
                }
            }

            $zip_name = $month_year . '.zip';
            $save_path = FCPATH . 'application/archives/' . $zip_name;
            $this->zip->archive($save_path);
        }

        echo "ZIP file berhasil dibuat di folder /application/archives/";
    }

    function getDetailStockOpnameAdjustment()
    {
        $locationid = $this->input->post('locationid');
        $date = $this->input->post('date');

        // echo json_encode([
        //     'status' => 200,
        //     'data' => $locationid,
        //     'date' => $date
        // ]);

        $reportData = $this->ModelReport->getDetailStockOpnameAdjustment($locationid, $date);

        if ($this->input->is_ajax_request()) {
            echo json_encode([
                'status' => 200,
                'data' => $reportData
            ]);
            exit;
        }
    }

    public function createStockOpname()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $id = $this->input->post('id');
        $stockopnamedate = $this->input->post('stockopnamedate');
        $locationid = $this->input->post('locationid');
        $isactive = $this->input->post('isactive');
        $remarks = $this->input->post('remarks');

        if (!$stockopnamedate || !$locationid) {
            echo json_encode([
                'success' => false,
                'message' => 'data tidak valid',
            ]);
        }

        $db_oriskin->select('id');
        $db_oriskin->from('stock_opname');
        $db_oriskin->where('locationid', $locationid);
        $db_oriskin->where('stockopnamedate', $stockopnamedate);
        $hasId = $db_oriskin->get()->row('id');

        if ($hasId && $hasId != $id) {
            echo json_encode([
                'success' => false,
                'message' => 'Data stock opname sudah ada',
            ]);
            return;
        }

        $updateData = [
            'stockopnamedate' => $stockopnamedate,
            'locationid' => $locationid,
            'remarks' => $remarks,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('userid'),
            'isactive' => $isactive
        ];


        if ($id) {
            $result = $this->ModelReport->updateStockOpname($updateData, $id);
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User berhasil diupdate',
                    'data' => $updateData
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'User gagal diupdate',
                    'data' => $updateData
                ]);
            }
        } else {
            $result = $this->ModelReport->createStockOpname($updateData);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User berhasil dibuat',
                    'data' => $updateData
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'User gagal dibuat',
                    'data' => $updateData
                ]);
            }
        }
    }

    // public function getDetailStockOpname($id)
    // {
    //     $this->output->set_content_type('application/json');

    //     $data = $this->ModelReport->getDetailStockOpname($id);

    //     if ($data) {
    //         $this->output->set_output(json_encode([
    //             'success' => true,
    //             'data' => $data
    //         ]));
    //     } else {
    //         $this->output->set_output(json_encode([
    //             'success' => false,
    //             'message' => 'Data not found'
    //         ]));
    //     }
    // }

    public function getDetailStockOpname($id)
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelReport->getDetailStockOpname($id);

        if ($data) {
            // Ambil exp_date & quantity dari tabel stock_opname_expdate
            $db_oriskin = $this->load->database('oriskin', true);
            $db_oriskin->select('id, exp_date, quantity');
            $db_oriskin->from('stock_opname_expdate');
            $db_oriskin->where('stockopnamedetail_id', $id);
            $expData = $db_oriskin->get()->result_array();

            $this->output->set_output(json_encode([
                'success' => true,
                'data' => $data,
                'expdates' => $expData
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Data not found'
            ]));
        }
    }


    public function getFacilityCategory()
    {
        $this->output->set_content_type('application/json');

        $search = $this->input->get('search');

        $data = $this->ModelReport->getFacilityCategory($search);

        if ($data) {
            $response = [
                'success' => true,
                'message' => 'Berhasil menampilkan data',
                'data' => $data,
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Data not found'
            ];
        }

        echo json_encode($response);
    }

    public function getFacilityById($id)
    {
        $this->output->set_content_type('application/json');

        $search = $this->input->get('search');

        $data = $this->ModelReport->getFacilityById($id);

        if ($data) {
            $response = [
                'success' => true,
                'message' => 'Berhasil menampilkan data',
                'data' => $data,
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Data not found'
            ];
        }

        echo json_encode($response);
    }
    public function getAllFacility()
    {
        $this->output->set_content_type('application/json');

        $locationid = $this->input->get('locationid');
        $categoryid = $this->input->get('categoryid');
        $status = $this->input->get('status');

        // kirim parameter ke model
        $data = $this->ModelReport->getAllFacility($locationid, $categoryid, $status);

        if ($data) {
            $response = [
                'success' => true,
                'message' => 'Berhasil menampilkan data',
                'data' => $data,
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Data not found',
                'data' => []
            ];
        }

        echo json_encode($response);
    }

    public function getAllLocation()
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelReport->getAllLocation();

        if ($data) {
            $response = [
                'success' => true,
                'message' => 'Berhasil menampilkan data',
                'data' => $data,
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Data not found'
            ];
        }

        echo json_encode($response);
    }

    public function getFacilityByLocation()
    {
        $this->output->set_content_type('application/json');

        $locationid = $this->session->userdata('locationid');

        $data = $this->ModelReport->getFacilityByLocation($locationid);

        if ($data) {
            $response = [
                'success' => true,
                'message' => 'Berhasil menampilkan data',
                'data' => $data,
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Data not found'
            ];
        }

        echo json_encode($response);
    }

    public function getFacilityConditionById($id)
    {
        $this->output->set_content_type('application/json');

        $data = $this->ModelReport->getFacilityConditionById($id);

        if ($data) {
            $response = [
                'success' => true,
                'message' => 'Berhasil menampilkan data',
                'data' => $data,
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Data not found'
            ];
        }

        echo json_encode($response);
    }

    // public function saveCondition()
    // {
    //     $this->output->set_content_type('application/json');
    //     $user_id = $this->session->userdata('userid');
    //     $db_oriskin = $this->load->database('oriskin', true);

    //     $facility_id   = $this->input->post('facility_id'); 
    //     $categoryid    = $this->input->post('categoryid');
    //     $locationid    = $this->input->post('locationid');
    //     $facility_name = $this->input->post('facility_name');
    //     $type          = $this->input->post('type');
    //     $merk          = $this->input->post('merk');
    //     $quantity      = $this->input->post('quantity');
    //     $description   = $this->input->post('description');
    //     $code          = $this->input->post('code');
    //     $status        = $this->input->post('status');
    //     $items         = $this->input->post('items');

    //     if (empty($locationid) || empty($facility_name)) {
    //         echo json_encode(['status' => 'error', 'message' => 'Data utama belum lengkap!']);
    //         return;
    //     }

    //     $db_oriskin->trans_begin();

    //     $facilityData = [
    //         'facility_name' => $facility_name,
    //         'type'          => $type,
    //         'categoryid'    => (int)$categoryid,
    //         'locationid'    => (int)$locationid,
    //         'merk'          => $merk,
    //         'description'   => $description,
    //         'quantity'      => (int)$quantity,
    //         'facility_code' => $code,
    //         'isactive'      => 1,
    //         'status'        => $status,
    //         'updatedat'     => date('Y-m-d H:i:s'),
    //         'updatedby'     => $user_id
    //     ];
    //     if (!empty($facility_id)) {
    //         $updated = $this->ModelReport->updateFacility($facility_id, $facilityData, $db_oriskin);
    //         if (!$updated) {
    //             echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data facility']);
    //             return;
    //         }
    //         $facilityId = $facility_id;
    //     } else {
    //         $facilityData['createdat'] = date('Y-m-d H:i:s');
    //         $facilityData['createdby'] = $user_id;
    //         $facilityId = $this->ModelReport->insertFacility($facilityData, $db_oriskin);
    //     }

    //     if (!empty($items) && is_array($items)) {
    //         foreach ($items as $index => $item) {
    //             $imagePath = null;
    //             if (!empty($_FILES['items']['name'][$index]['images'])) {
    //                 $imgName = $_FILES['items']['name'][$index]['images'];
    //                 $tmp_name = $_FILES['items']['tmp_name'][$index]['images'];

    //                 $uploadDir = FCPATH . 'uploads/facility/';
    //                 if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

    //                 $newFileName = time() . '_' . preg_replace('/\s+/', '_', $imgName);
    //                 $destination = $uploadDir . $newFileName;

    //                 if (move_uploaded_file($tmp_name, $destination)) {
    //                     $imagePath = 'uploads/facility/' . $newFileName;
    //                 }
    //             }

    //             $conditionData = [
    //                 'facilityid'  => $facilityId,
    //                 'report'      => $item['report'] ?? '',
    //                 'description' => $item['description'] ?? '',
    //                 'deadline'    => !empty($item['deadline']) ? $item['deadline'] : null,
    //                 'images'      => $imagePath,
    //                 'createdby'   => $user_id,
    //                 'createdat'   => date('Y-m-d H:i:s'),
    //                 'isactive'    => 1
    //             ];

    //             $this->ModelReport->insertConditionItem($conditionData);
    //         }
    //     }

    //     $uploadDir = FCPATH . 'uploads/facility/';
    //     if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

    //     foreach ($_FILES as $field => $file) {
    //         if (!empty($file['name']) && $field != 'items') {
    //             $config = [
    //                 'upload_path'   => $uploadDir,
    //                 'allowed_types' => 'jpg|jpeg|png',
    //                 'max_size'      => 2048,
    //                 'file_name'     => time() . '_' . preg_replace('/\s+/', '_', $file['name']),
    //             ];
    //             $this->load->library('upload', $config);

    //             if ($this->upload->do_upload($field)) {
    //                 $uploadData = $this->upload->data();
    //                 $uploadedPath = 'uploads/facility/' . $uploadData['file_name'];

    //                 // update jika sudah ada foto, kalau tidak insert
    //                 $existingImage = $this->ModelReport->getFacilityImage($facilityId);
    //                 if ($existingImage) {
    //                     $this->ModelReport->updateFacilityImage($facilityId, [
    //                         'images'      => $uploadedPath,
    //                         'description' => $description,
    //                         'updatedat'   => date('Y-m-d H:i:s'),
    //                         'updatedby'   => $user_id
    //                     ]);
    //                 } else {
    //                     $this->ModelReport->insertFacilityImage([
    //                         'facilityid'  => $facilityId,
    //                         'images'      => $uploadedPath,
    //                         'description' => $description,
    //                         'isactive'    => 1,
    //                         'createdat'   => date('Y-m-d H:i:s'),
    //                         'createdby'   => $user_id
    //                     ]);
    //                 }
    //             }
    //         }
    //     }

    //     // === Commit / Rollback ===
    //     if ($db_oriskin->trans_status() === FALSE) {
    //         $db_oriskin->trans_rollback();
    //         echo json_encode(['status' => 'error', 'message' => 'Transaksi gagal disimpan!']);
    //     } else {
    //         $db_oriskin->trans_commit();
    //         echo json_encode([
    //             'status' => 'success',
    //             'message' => 'Data facility & condition berhasil disimpan!',
    //             'redirect' => base_url('ControllerCondition/conditionList')
    //         ]);
    //     }
    // }

    public function saveCondition()
    {
        $this->output->set_content_type('application/json');
        $user_id = $this->session->userdata('userid');
        $db_oriskin = $this->load->database('oriskin', true);

        $facility_id = $this->input->post('facility_id');
        $categoryid = $this->input->post('categoryid');
        $locationid = $this->input->post('locationid');
        $facility_name = $this->input->post('facility_name');
        $type = $this->input->post('type');
        $merk = $this->input->post('merk');
        $quantity = $this->input->post('quantity');
        $description = $this->input->post('description');
        $code = $this->input->post('code');
        $status = $this->input->post('status');
        $items = $this->input->post('items'); // optional, insert only for new facility

        if (empty($locationid) || empty($facility_name)) {
            echo json_encode(['status' => 'error', 'message' => 'Data utama belum lengkap!']);
            return;
        }

        $db_oriskin->trans_begin();

        $facilityData = [
            'facility_name' => $facility_name,
            'type' => $type,
            'categoryid' => (int) $categoryid,
            'locationid' => (int) $locationid,
            'merk' => $merk,
            'description' => $description,
            'quantity' => (int) $quantity,
            'facility_code' => $code,
            'status' => $status,
            'updatedat' => date('Y-m-d H:i:s'),
            'updatedby' => $user_id
        ];

        if (!empty($facility_id)) {
            $updated = $this->ModelReport->updateFacility($facility_id, $facilityData, $db_oriskin);
            if (!$updated) {
                $db_oriskin->trans_rollback();
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data facility']);
                return;
            }
            $facilityId = $facility_id;
        } else {
            $facilityData['createdat'] = date('Y-m-d H:i:s');
            $facilityData['createdby'] = $user_id;
            $facilityId = $this->ModelReport->insertFacility($facilityData, $db_oriskin);

            if (!empty($items) && is_array($items)) {
                foreach ($items as $index => $item) {
                    $uploadedImages = [];
                    if (!empty($_FILES['items']['name'][$index]['images'])) {
                        $imgName = $_FILES['items']['name'][$index]['images'];
                        $tmp_name = $_FILES['items']['tmp_name'][$index]['images'];

                        $uploadDir = FCPATH . 'uploads/facility/';
                        if (!file_exists($uploadDir))
                            mkdir($uploadDir, 0777, true);

                        $newFileName = time() . '_' . preg_replace('/\s+/', '_', $imgName);
                        if (move_uploaded_file($tmp_name, $uploadDir . $newFileName)) {
                            $uploadedImages[] = 'uploads/facility/' . $newFileName;
                        }
                    }

                    $conditionData = [
                        'facilityid' => $facilityId,
                        'report' => $item['report'] ?? '',
                        'description' => $item['description'] ?? '',
                        'deadline' => !empty($item['deadline']) ? $item['deadline'] : null,
                        'images' => !empty($uploadedImages) ? json_encode($uploadedImages) : null,
                        'createdby' => $user_id,
                        'createdat' => date('Y-m-d H:i:s'),
                        'isactive' => 1
                    ];

                    $this->ModelReport->insertConditionItem($conditionData);
                }
            }
        }

        $uploadDir = FCPATH . 'uploads/facility/';
        if (!file_exists($uploadDir))
            mkdir($uploadDir, 0777, true);

        foreach (['image1', 'image2'] as $field) {
            if (!empty($_FILES[$field]['name'])) {
                $config = [
                    'upload_path' => $uploadDir,
                    'allowed_types' => 'jpg|jpeg|png',
                    'max_size' => 2048,
                    'file_name' => time() . '_' . preg_replace('/\s+/', '_', $_FILES[$field]['name'])
                ];
                $this->load->library('upload', $config);

                if ($this->upload->do_upload($field)) {
                    $uploadData = $this->upload->data();
                    $uploadedPath = 'uploads/facility/' . $uploadData['file_name'];

                    $updateData = [
                        $field => $uploadedPath,
                        'updatedat' => date('Y-m-d H:i:s'),
                        'updatedby' => $user_id
                    ];
                    $this->ModelReport->updateFacility($facilityId, $updateData);
                }
            }
        }

        if ($db_oriskin->trans_status() === FALSE) {
            $db_oriskin->trans_rollback();
            echo json_encode(['status' => 'error', 'message' => 'Transaksi gagal disimpan!']);
        } else {
            $db_oriskin->trans_commit();
            echo json_encode([
                'status' => 'success',
                'message' => 'Data facility berhasil disimpan!',
                'redirect' => base_url('facilityReportList')
            ]);
        }
    }

    public function saveFacility()
    {
        $this->output->set_content_type('application/json');

        $user_id = $this->session->userdata('userid');
        $db_oriskin = $this->load->database('oriskin', true);

        $categoryid = $this->input->post('categoryid');
        $locationid = $this->input->post('locationid');
        $facility_name = $this->input->post('facility_name');
        $type = $this->input->post('type');
        $merk = $this->input->post('merk');
        $quantity = $this->input->post('quantity');
        $description = $this->input->post('description');
        $code = $this->input->post('code');
        $status = $this->input->post('status');

        $facilityData = [
            'facility_name' => $facility_name,
            'type' => $type,
            'categoryid' => (int) $categoryid,
            'locationid' => (int) $locationid,
            'merk' => $merk,
            'description' => $description,
            'quantity' => $quantity,
            'facility_code' => $code,
            'isactive' => 1,
            'status' => 0,
            'createdat' => date('Y-m-d H:i:s'),
            'createdby' => $user_id
        ];

        $facilityId = $this->ModelReport->insertFacility($facilityData, $db_oriskin);

        if (!$facilityId) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal menyimpan data facility ke database'
            ]);
            return;
        }

        $uploadDir = FCPATH . 'uploads/facility/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uploadedFiles = [];
        foreach ($_FILES as $field => $file) {
            if (!empty($file['name'])) {
                $config = [
                    'upload_path' => $uploadDir,
                    'allowed_types' => 'jpg|jpeg|png',
                    'max_size' => 2048,
                    'file_name' => time() . '_' . preg_replace('/\s+/', '_', $file['name']),
                ];
                $this->load->library('upload', $config);

                if ($this->upload->do_upload($field)) {
                    $uploadData = $this->upload->data();
                    $uploadedPath = 'uploads/facility/' . $uploadData['file_name'];
                    $uploadedFiles[] = $uploadedPath;

                    $imageData = [
                        'facilityid' => $facilityId,
                        'images' => $uploadedPath,
                        'description' => $description,
                        'isactive' => 1,
                        'createdat' => date('Y-m-d H:i:s'),
                        'createdby' => $user_id
                    ];

                    $this->ModelReport->insertFacilityImage($imageData, $db_oriskin);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => $this->upload->display_errors()
                    ]);
                    return;
                }
            }
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Facility dan gambar berhasil disimpan!',
            'facility_id' => $facilityId,
            'images' => $uploadedFiles
        ]);
    }

    public function updateCondition()
    {
        $this->output->set_content_type('application/json');

        $id = $this->input->post('id');
        $progress = $this->input->post('progress');
        $action = $this->input->post('action');
        $status = $this->input->post('status');

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID not provided']);
            return;
        }

        $data = [
            'progress' => $progress,
            'action' => $action,
            'status' => intval($status),
            'updatedat' => date('Y-m-d H:i:s')
        ];

        $updated = $this->ModelReport->updateConditionById($id, $data);

        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Condition updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update condition']);
        }
    }


    public function deleteStockOpnameExpDate($id)
    {
        header('Content-Type: application/json');

        $db_oriskin = $this->load->database('oriskin', true);

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan']);
            return;
        }

        // pastikan data ada dulu
        $data = $db_oriskin->get_where('stock_opname_expdate', ['id' => $id])->row_array();
        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
            return;
        }

        // hapus data
        $db_oriskin->where('id', $id);
        $deleted = $db_oriskin->delete('stock_opname_expdate');

        if ($deleted) {
            echo json_encode(['success' => true, 'message' => 'Data exp date berhasil dihapus']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus data exp date']);
        }
    }

    public function getStockOpnameDetail($ingredientid, $stock_opname_id)
    {
        $this->output->set_content_type('application/json');
        $db_oriskin = $this->load->database('oriskin', true);

        // Ambil satu baris detail sesuai locationid, ingredientid, dan stock_opname_id
        $detail = $db_oriskin->select('*')
            ->from('stock_opname_detail')
            ->where('stock_opname_id', $stock_opname_id)
            ->where('ingredientid', $ingredientid)
            ->get()
            ->row_array();

        if ($detail) {
            // Ambil exp_date & quantity berdasarkan id detail yang ditemukan
            $db_oriskin->select('stockopnamedetail_id, exp_date, quantity,id');
            $db_oriskin->from('stock_opname_expdate');
            $db_oriskin->where('stockopnamedetail_id', $detail['id']);
            $expData = $db_oriskin->get()->result_array();

            $this->output->set_output(json_encode([
                'success' => true,
                'details' => $detail,
                'expdates' => $expData
            ]));
        } else {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Data not found'
            ]));
        }
    }



    // public function createStockOpnameAdjustment()
    // {
    //     error_reporting(0);
    //     ini_set('display_errors', 0);
    //     $db_oriskin = $this->load->database('oriskin', true);

    //     $ingredientid = $this->input->post('ingredientid');
    //     $stock_opname_id = $this->input->post('stock_opname_id');
    //     $last_stock = $this->input->post('last_stock');
    //     $stock = $this->input->post('stock');
    //     $note = $this->input->post('note');
    //     $exp_date = $this->input->post('exp_date') ?? null;

    //     if (!$ingredientid || !$stock_opname_id) {
    //         echo json_encode([
    //             'success' => false,
    //             'message' => 'data tidak valid',
    //         ]);
    //     }

    //     $db_oriskin->select('id');
    //     $db_oriskin->from('stock_opname_detail');
    //     $db_oriskin->where('ingredientid', $ingredientid);
    //     $db_oriskin->where('stock_opname_id', $stock_opname_id);
    //     $hasId = $db_oriskin->get()->row('id');



    //     $updateData = [
    //         'stock_opname_id' => $stock_opname_id,
    //         'last_stock' => $last_stock,
    //         'stock' => $stock,
    //         'note' => $note,
    //         'created_at' => date('Y-m-d H:i:s'),
    //         'created_by' => $this->session->userdata('userid'),
    //         'ingredientid' => $ingredientid,
    //         'exp_date' => $exp_date,
    //     ];

    //     if ($hasId) {
    //         $result = $this->ModelReport->updateStockOpnameAdjustment($updateData, $hasId);
    //         if ($result) {
    //             echo json_encode([
    //                 'success' => true,
    //                 'message' => 'User berhasil diupdate',
    //                 'data' => $updateData
    //             ]);
    //         } else {
    //             echo json_encode([
    //                 'success' => false,
    //                 'message' => 'User gagal diupdate',
    //                 'data' => $updateData
    //             ]);
    //         }
    //     } else {
    //         $result = $this->ModelReport->createStockOpnameAdjustment($updateData);

    //         if ($result) {
    //             echo json_encode([
    //                 'success' => true,
    //                 'message' => 'User berhasil dibuat',
    //                 'data' => $updateData
    //             ]);
    //         } else {
    //             echo json_encode([
    //                 'success' => false,
    //                 'message' => 'User gagal dibuat',
    //                 'data' => $updateData
    //             ]);
    //         }
    //     }
    // }

    public function createStockOpnameAdjustment()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);

        $ingredientid = $this->input->post('ingredientid');
        $last_stock = $this->input->post('last_stock');
        $stock = $this->input->post('stock');
        $note = $this->input->post('note');
        $exp_dates = $this->input->post('exp_dates');
        $quantities = $this->input->post('quantities');
        $stock_opname_id = $this->input->post('stock_opname_id');

        if (!$ingredientid && $stock_opname_id) {
            echo json_encode([
                'success' => false,
                'message' => 'Data tidak valid',
            ]);
            return;
        }

        $db_oriskin->select('id');
        $db_oriskin->from('stock_opname_detail');
        $db_oriskin->where('ingredientid', $ingredientid);
        $db_oriskin->where('stock_opname_id', $stock_opname_id);
        $hasId = $db_oriskin->get()->row('id');

        $updateData = [
            'stock_opname_id' => $stock_opname_id,
            'last_stock' => $last_stock,
            'stock' => $stock,
            'note' => $note,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('userid'),
            'ingredientid' => $ingredientid,
        ];

        if ($hasId) {
            $result = $this->ModelReport->updateStockOpnameAdjustment($updateData, $hasId);
            $detailId = $hasId;
        } else {
            $result = $this->ModelReport->createStockOpnameAdjustment($updateData);
            $detailId = $db_oriskin->insert_id();
        }

        if ($result && $detailId) {
            if (!empty($exp_dates) && is_array($exp_dates)) {
                foreach ($exp_dates as $i => $exp) {
                    $expInsert = [
                        'stockopnamedetail_id' => $detailId,
                        'exp_date' => !empty($exp) ? $exp : null,
                        'quantity' => $quantities[$i] ?? 0,
                        'createdat' => date('Y-m-d H:i:s'),
                        'createdby' => $this->session->userdata('userid'),
                    ];
                    $db_oriskin->insert('stock_opname_expdate', $expInsert);
                }
            }
            echo json_encode([
                'success' => true,
                'message' => 'Stock Opname berhasil disimpan',
                'data' => $updateData,
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal menyimpan Stock Opname',
            ]);
        }
    }


    public function saveStockOpnameBulk()
    {
        // $items = $this->input->post('items'); // array dari JS
        $db_oriskin = $this->load->database('oriskin', true);

        $json = $this->input->raw_input_stream;
        $post = json_decode($json, true);

        $items = $post['items'] ?? [];

        if (!$items) {
            echo json_encode(['success' => false, 'message' => 'No data received']);
            return;
        }

        $results = [];
        $successCount = 0;
        $failCount = 0;
        $hasData = 0;
        $dataProcess = 0;

        foreach ($items as $item) {
            $dataProcess++;
            try {
                $ingredientid = $item['ingredientid'];
                $stockOpnameId = $item['stock_opname_id'];

                $exists = $db_oriskin->where('stock_opname_id', $stockOpnameId)
                    ->where('ingredientid', $ingredientid)
                    ->get('adjustment_stock')
                    ->row();

                $data = [
                    'stock_opname_id' => $stockOpnameId,
                    'ingredientid' => $ingredientid,
                    'qty' => abs($item['difference']),
                    'note' => $item['note'],
                    'type' => $item['type'],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->userdata('userid')
                ];

                if ($exists) {
                    $ok = $db_oriskin->where('id', $exists->id)->update('adjustment_stock', $data);
                    if ($ok) {
                        $successCount++;
                        $hasData++;
                        $results[] = ['ingredientid' => $ingredientid, 'status' => 'updated'];
                    } else {
                        $failCount++;
                        $results[] = ['ingredientid' => $ingredientid, 'status' => 'failed update'];
                    }
                } else {
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = $this->session->userdata('userid');
                    $ok = $db_oriskin->insert('adjustment_stock', $data);
                    if ($ok) {
                        $successCount++;
                        $results[] = ['ingredientid' => $ingredientid, 'status' => 'inserted'];
                    } else {
                        $failCount++;
                        $results[] = ['ingredientid' => $ingredientid, 'status' => 'failed insert'];
                    }
                }
            } catch (Exception $e) {
                $failCount++;
                $results[] = [
                    'ingredientid' => $item['ingredientid'] ?? null,
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }

        echo json_encode([
            'success' => ($failCount == 0),
            'success_count' => $successCount,
            'hasData' => $hasData,
            'dataProcess' => $dataProcess,
            'fail_count' => $failCount,
            'details' => $results,
            'items' => $items
        ]);
    }

    public function getProductsByType($typeId)
    {
        $db_oriskin = $this->load->database('oriskin', true);

        if ($typeId == 1) {
            $products = $db_oriskin
                ->select('id, name')
                ->from('mstreatment')
                ->get()
                ->result_array();
        } elseif ($typeId == 2) {
            $products = $db_oriskin
                ->select('id, name')
                ->from('msproductmembershiphdr')
                ->get()
                ->result_array();
        } elseif ($typeId == 3) {
            $products = $db_oriskin
                ->select('id, name')
                ->from('msproduct')
                ->get()
                ->result_array();
        }
        echo json_encode($products);
    }

    function getReportTransactionByProduct()
    {
        $dateStart = $this->input->post('dateStart') ?: date('Y-m-d');
        $dateEnd = $this->input->post('dateEnd') ?: date('Y-m-d');
        $locationid = $this->input->post('locationid');
        $productid = $this->input->post('productid');
        $producttypeid = $this->input->post('producttypeid');

        $reportData = $this->ModelReport->getReportTransactionByProduct($dateStart, $dateEnd, $locationid, $productid, $producttypeid);

        if ($this->input->is_ajax_request()) {
            echo json_encode([
                'status' => 200,
                'data' => $reportData
            ]);
            exit;
        }
    }

    function getReportCustomerDoingAndSpending()
    {
        $dateStart = $this->input->post('dateStart') ?: date('Y-m-d');
        $dateEnd = $this->input->post('dateEnd') ?: date('Y-m-d');

        $reportData = $this->ModelReport->getReportCustomerDoingAndSpending($dateStart, $dateEnd);
        $reportDataDetail = $this->ModelReport->getReportCustomerDoingAndSpendingDetail($dateStart, $dateEnd);




        if ($this->input->is_ajax_request()) {
            echo json_encode([
                'status' => 200,
                'data' => $reportData,
                'data_detail' => $reportDataDetail
            ]);
            exit;
        }

        return [
            'reportCustomerDoingAndSpending' => $reportData,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd
        ];
    }


    public function get_commission_report_invoice_lifetime()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Set default date if empty
        if (empty($start_date)) {
            $start_date = date('Y-m-01');
        }
        if (empty($end_date)) {
            $end_date = date('Y-m-t');
        }

        $data = $this->ModelReport->get_commission_report_invoice_lifetime($start_date, $end_date);

        echo json_encode([
            'status' => 'success',
            'data' => $data['details'],
            'summary' => $data['summary'],
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }


    public function getReportFirstVisit()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $datestart = $this->input->get('datestart', TRUE);
        $dateend = $this->input->get('dateend', TRUE);

        if (!$datestart || !$dateend) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Parameter dateend dan datestart wajib diisi.'
            ]);
            return;
        }


        $allResults = [];


        $sql = "
            EXEC [spEudoraFirstVisitCustomer]
                @DATESTART = '$datestart',
                @DATEEND = '$dateend'
        ";

        $query = $db_oriskin->query($sql);
        $result = $query->result_array();

        // Gabungkan semua baris hasil JSON (kadang SQL Server potong output panjang jadi beberapa baris)
        $jsonOutput = '';
        foreach ($result as $row) {
            $jsonOutput .= implode('', $row);
        }

        // Decode JSON hasil SP
        $dataArray = json_decode($jsonOutput, true);

        $allResults[] = [
            'data' => $dataArray['first_visit_summary'] ?? []
        ];


        echo json_encode([
            'status' => 'success',
            'message' => 'Summary presensi berhasil digenerate untuk semua payroll group.',
            'total_customer' => $dataArray['total_customer'] ?? 0,
            'grand_total_amount' => $dataArray['grand_total_amount'] ?? 0,
            'results' => $allResults
        ]);
    }



    public function get_commission_report_invoice_product_therapist()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Set default date if empty
        if (empty($start_date)) {
            $start_date = date('Y-m-01');
        }
        if (empty($end_date)) {
            $end_date = date('Y-m-t');
        }

        $data = $this->ModelReport->get_commission_report_invoice_product_therapist($start_date, $end_date);

        echo json_encode([
            'status' => 'success',
            'data' => $data['details'],
            'summary' => $data['summary'],
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }



    public function get_appointment_report()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $status_filter = $this->input->get('status_filter');

        if (empty($start_date) || empty($end_date)) {
            echo json_encode(['success' => false, 'message' => 'Start date and end date are required']);
            return;
        }

        $detail_data = $this->ModelReport->get_appointment_detail($start_date, $end_date, $status_filter);
        $summary_data = $this->ModelReport->get_appointment_summary($start_date, $end_date, $status_filter);

        echo json_encode([
            'success' => true,
            'detail' => $detail_data,
            'summary' => $summary_data
        ]);
    }

    public function get_report()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $status = $this->input->get('status');
        $db_oriskin = $this->load->database('oriskin', true);

        if (empty($start_date) || empty($end_date)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Tanggal mulai dan akhir harus diisi.'
            ]);
            return;
        }

        // Query utama
        $sql = "
        SELECT 
            a.appointmentdate, 
            b.name AS status, 
            c.name AS locationname, 
            d.firstname + ' ' + d.lastname AS customername, 
            d.cellphonenumber
        FROM trbookappointment a
        INNER JOIN msappointmentstatus b ON a.status = b.id
        INNER JOIN mslocation c ON a.locationid = c.id
        INNER JOIN mscustomer d ON a.customerid = d.id
        WHERE 
            (CONVERT(varchar(10), a.appointmentdate, 120) BETWEEN ? AND ?)
            AND (
                a.status IN (5, 6)
                OR (
                    a.status BETWEEN 1 AND 4
                    AND NOT EXISTS (
                        SELECT 1 
                        FROM trbookappointment a2 
                        WHERE a2.customerid = a.customerid 
                            AND CONVERT(varchar(10), a2.appointmentdate, 120) = CONVERT(varchar(10), a.appointmentdate, 120)
                            AND a2.status IN (5, 6)
                    )
                )
            )
    ";

        $params = [$start_date, $end_date];

        // Filter status jika dikirim
        if (!empty($status)) {
            $sql .= " AND a.status = ? ";
            $params[] = $status;
        }

        $sql .= "
        GROUP BY 
            a.appointmentdate, 
            b.name, 
            c.name, 
            d.firstname, 
            d.lastname, 
            d.cellphonenumber
        ORDER BY 
            c.name,
            a.appointmentdate
    ";

        $query = $db_oriskin->query($sql, $params);

        if (!$query) {
            // Tampilkan pesan error SQL untuk debugging
            $error = $db_oriskin->error();
            echo json_encode([
                'status' => 'error',
                'message' => 'Query gagal dijalankan.',
                'sql_error' => $error
            ]);
            return;
        }

        $data = $query->result_array();

        // Buat summary berdasarkan lokasi
        $summary = [];
        foreach ($data as $row) {
            $loc = $row['locationname'];
            if (!isset($summary[$loc])) {
                $summary[$loc] = [
                    'locationname' => $loc,
                    'total_appointment' => 0,
                    'checkin_finished' => 0
                ];
            }

            $summary[$loc]['total_appointment']++;

            if (in_array(strtolower($row['status']), ['checkin', 'finished'])) {
                $summary[$loc]['checkin_finished']++;
            }
        }

        $summary = array_values($summary);

        echo json_encode([
            'status' => 'success',
            'summary' => $summary,
            'data' => $data
        ]);
    }

}


