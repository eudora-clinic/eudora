<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ControllerPOS extends CI_Controller
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

    function print_invoiceSummary($type, $id)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $this->load->library('Ltcpdf');
        $db_oriskin = $this->load->database('oriskin', true);

        $dataHeaderDetail = $db_oriskin->query("Exec spPrintOfficalReciept ?, ?", [$type, $id])->result_array();

        $dataPayment = $db_oriskin->query("Exec spPrintOfficalRecieptPayment ?, ?", [$type, $id])->result_array();

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->AddPage();

        $bgImage = FCPATH . 'assets/img/ttepng.png';
        $pdf->Image($bgImage, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

        $pdf->SetFont('helvetica', '', 6);

        $pdf->SetXY(57, 22.5);
        $pdf->MultiCell(80, 5, $dataHeaderDetail[0]['ADDRESS'], 0, 'L');


        $pdf->SetFont('helvetica', '', 6);
        $pdf->SetXY(159.5, 15);
        $pdf->Cell(0, 10, $dataHeaderDetail[0]['INVOICENO'], 0, 1);

        $pdf->SetXY(159.5, 9);
        $pdf->Cell(0, 10, $dataHeaderDetail[0]['INVOICEDATE'], 0, 1);

        $pdf->SetXY(159.5, 20);
        $pdf->Cell(0, 10, $dataHeaderDetail[0]['LOCATIONNAME'], 0, 1);


        $pdf->SetFont('helvetica', '', 6);
        $yPos1 = 62.5;
        $yPos2 = 196;

        foreach ($dataHeaderDetail as $dataHeader) {
            $pdf->SetXY(12, $yPos1);
            $pdf->Cell(0, 8, $dataHeader['MEMBERSHIPNAME'], 0, 1);

            $pdf->SetXY(14, $yPos2);
            $pdf->Cell(0, 8, $dataHeader['MEMBERSHIPNAME'], 0, 1);

            $pdf->SetXY(100, $yPos1);
            $pdf->Cell(0, 8, $dataHeader['QTY'], 0, 1);

            $pdf->SetXY(102, $yPos2);
            $pdf->Cell(0, 8, $dataHeader['QTY'], 0, 1);

            $pdf->SetXY(170, $yPos1);
            $pdf->Cell(0, 8, 'Rp ' . number_format($dataHeader['AMOUNT'], 0, ',', '.'), 0, 0);

            $pdf->SetXY(172, $yPos2);
            $pdf->Cell(0, 8, 'Rp ' . number_format($dataHeader['AMOUNT'], 0, ',', '.'), 0, 0);

            // Pindahkan posisi ke bawah agar tidak menumpuk
            $yPos1 += 3;
            $yPos2 += 3;
        }

        $pdf->SetXY(50, 31.5);
        $pdf->Cell(0, 8, $dataHeaderDetail[0]['LCNAME'], 0, 1);

        $pdf->SetXY(52, 164);
        $pdf->Cell(0, 8, $dataHeaderDetail[0]['LCNAME'], 0, 1);

        $pdf->SetXY(50, 38.5);
        $pdf->Cell(0, 8, $dataHeaderDetail[0]['ADDRESSNAME'] == NULL ? '-' : $dataHeaderDetail[0]['ADDRESSNAME'], 0, 1);

        $pdf->SetXY(52, 171);
        $pdf->Cell(0, 8, $dataHeaderDetail[0]['ADDRESSNAME'] == NULL ? '-' : $dataHeaderDetail[0]['ADDRESSNAME'], 0, 1);

        $pdf->SetXY(50, 45);
        $pdf->Cell(0, 8, $dataHeaderDetail[0]['CELLPHONE'], 0, 1);

        $pdf->SetXY(52, 178);
        $pdf->Cell(0, 8, $dataHeaderDetail[0]['CELLPHONE'], 0, 1);

        $pdf->SetXY(142, 49);
        $pdf->Cell(0, 8, $dataHeaderDetail[0]['SALESNAME'], 0, 1);

        $pdf->SetXY(144, 181.5);
        $pdf->Cell(0, 8, $dataHeaderDetail[0]['SALESNAME'], 0, 1);

        $pdf->SetXY(73, 149.5);
        $pdf->Cell(0, 8, $dataHeaderDetail[0]['FRONTDESKNAME'], 0, 1);

        $pdf->SetXY(75, 283);
        $pdf->Cell(0, 8, $dataHeaderDetail[0]['FRONTDESKNAME'], 0, 1);

        $pdf->SetFont('helvetica', '', 6);
        $y = 108;
        $total_bayar = 0;

        foreach ($dataPayment as $item) {
            $total = $item['AMOUNT'];
            $total_bayar += $total;

            $pdf->SetXY(13, $y);
            $pdf->Cell(157, 10, $item['PAYMENTTYPE'], 0, 0);

            $pdf->Cell(30, 10, 'Rp ' . number_format($item['AMOUNT'], 0, ',', '.'), 0, 0);
            $y += 3;
        }

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(122, 124);
        $pdf->Cell(67, 0, 'Rp ' . number_format($total_bayar, 0, ',', '.'), 0, 1, 'R');


        $pdf->SetFont('helvetica', '', 6);
        $y = 242;
        $total_bayar = 0;

        foreach ($dataPayment as $item) {
            $total = $item['AMOUNT'];
            $total_bayar += $total;

            $pdf->SetXY(15, $y);
            $pdf->Cell(157, 10, $item['PAYMENTTYPE'], 0, 0);

            $pdf->Cell(30, 10, 'Rp ' . number_format($item['AMOUNT'], 0, ',', '.'), 0, 0);
            $y += 3;
        }

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(122, 257);
        $pdf->Cell(67, 0, 'Rp ' . number_format($total_bayar, 0, ',', '.'), 0, 1, 'R');

        $pdf->Output('receipt_.pdf', 'I');
    }

    public function addIngredients()
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
            'name' => $post['name'],
            'code' => $post['code'],
            'price' => $post['price'],
            'isactive' => $post['isactive'],
            'section' => $post['section'],
            'unitid' => $post['uom'],
            'cost' => 0,
            'lowestprice' => 0,
            'qtypersatuan' => 1,
            'qty' => $post['qty'],
            'unitprice' => $post['unitprice']
        ];
        if ($id == 0) {
            $db_oriskin->insert('msingredients', $data_hdr);
        } else if ($id != 0) {
            $db_oriskin->where('id', $id);
            $db_oriskin->update('msingredients', $data_hdr);
        }

        if ($db_oriskin->trans_status() === FALSE) {
            $db_oriskin->trans_rollback();
            $response = ['status' => 'error', 'message' => 'Transaction failed'];
        } else {
            $db_oriskin->trans_commit();
            $response = ['status' => 'success', 'message' => 'Berhasil menambahkan package in'];
        }

        echo json_encode($response);
        exit;
    }

    public function voidBookingAndPrepaid()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $post = json_decode(file_get_contents('php://input'), true);

        if (!$post) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        $db_oriskin->trans_begin();

        $updateBook = [
            'status' => 1,
            'updatedate' => date('Y-m-d H:i:s'),
            'updateuserid' => $this->session->userdata('userid')
        ];

        $db_oriskin->where('id', $post['bookingid']);
        $db_oriskin->update('trbookappointment', $updateBook);

        $updatePrepaid = [
            'status' => 3,
            'updatedate' => date('Y-m-d H:i:s'),
            'updateuserid' => $this->session->userdata('userid')
        ];

        $db_oriskin->where('bookingid', $post['bookingid']);
        $db_oriskin->update('trdoingtreatment', $updatePrepaid);


        if ($db_oriskin->trans_status() === FALSE) {
            $error = $db_oriskin->error();
            $db_oriskin->trans_rollback();
            echo json_encode(['status' => 'error', 'message' => $post['bookingid'], 'error' => $error]);
        } else {
            $db_oriskin->trans_commit();
            echo json_encode(['status' => 'success']);
        }
    }


    public function updateGoogleReviewCustomer()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $post = $this->input->post();
        $db_oriskin = $this->load->database('oriskin', true);

        $customerId = $post['customerId'] ?? null;
        $googleAccount = $post['googleAccount'] ?? null;
        $linkReview = $post['linkReview'] ?? null;
        $employeeidLinkReview = $post['employeeidLinkReview'] ?? null;

        if (empty($customerId)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid input data'
            ]);
            return;
        }

        $db_oriskin->select('id');
        $db_oriskin->from('mslinkreview');
        $db_oriskin->where('customerid', $customerId);
        $db_oriskin->limit(1);
        $query = $db_oriskin->get();

        $update_data = [
            'googlename' => $googleAccount,
            'linkreview' => $linkReview,
            'employeeid' => $employeeidLinkReview,
            "updatebyuserid" => $this->session->userdata('userid'),
            "updatedate" => date("Y-m-d H:i:s"),
        ];

        $create_data = [
            'customerid' => $customerId,
            'googlename' => $googleAccount,
            'linkreview' => $linkReview,
            'employeeid' => $employeeidLinkReview,
            "createbyuserid" => $this->session->userdata('userid'),
            "createdate" => date("Y-m-d H:i:s"),
        ];

        if ($query->num_rows() > 0) {
            $db_oriskin->where('customerid', $customerId);
            if ($db_oriskin->update('mslinkreview', $update_data)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Data updated successfully'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to update data'
                ]);
            }
        } else {
            if ($db_oriskin->insert('mslinkreview', $create_data)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Data created successfully'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to update data'
                ]);
            }
        }
    }


    public function updatePrepaidConsumptionV2()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $post = $this->input->post();
        $db_oriskin = $this->load->database('oriskin', true);

        $id = $post['updateId'] ?? null;
        $qty = $post['doingQty'] ?? null;
        $doingBy = $post['doingBy'] ?? null;
        $assistBy = $post['assistBy'] ?? null;

        // Validasi input
        if (empty($id) || empty($doingBy) || empty($qty)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid input data'
            ]);
            return;
        }

        // Data yang akan diupdate
        $update_data = [
            'treatmentdoingbyid' => $doingBy,
            'qty' => $qty,
            'treatmentassistbyid' => ($assistBy === "") ? null : $assistBy,
        ];

        // Eksekusi update
        $db_oriskin->where('id', $id);
        if ($db_oriskin->update('trdoingtreatment', $update_data)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Data updated successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update data'
            ]);
        }
    }


    public function changeTreatmentPrepaid()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $post = $this->input->post();
        $db_oriskin = $this->load->database('oriskin', true);

        $doingidChange = $post['doingidChange'] ?? null;
        $qtyBefore = $post['qtyBefore'] ?? null;
        $treatmentExchangeId = $post['treatmentExchangeId'] ?? null;
        $qtyExchange = $post['qtyExchange'] ?? null;
        $remarkExchange = $post['remarkExchange'] ?? null;

        // Validasi input
        if (empty($doingidChange) || empty($qtyBefore) || empty($treatmentExchangeId) || empty($qtyExchange)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid input data'
            ]);
            return;
        }

        $check = $db_oriskin->get_where('mschangetreatmentprepaid', ['doingid' => $doingidChange])->row();

        // Data yang akan diupdate
        $update_data = [
            'doingid' => $doingidChange,
            'qty' => $qtyExchange,
            'treatmentid' => $treatmentExchangeId,
            'createbyuserid' => $this->session->userdata('userid'),
            'status' => 0,
            'remarks' => $remarkExchange,
            'qtybefore' => $qtyBefore,
        ];

        if ($check) {
            // Kalau sudah ada → Update
            $db_oriskin->where('doingid', $doingidChange);
            if ($db_oriskin->update('mschangetreatmentprepaid', $update_data)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Data updated successfully'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to update data'
                ]);
            }
        } else {
            // Kalau belum ada → Insert
            if ($db_oriskin->insert('mschangetreatmentprepaid', $update_data)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Data inserted successfully'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to insert data'
                ]);
            }
        }
    }


    public function addPackage()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        ob_start();
        $db_oriskin = $this->load->database('oriskin', true);

        $userid = $this->session->userdata('userid');

        $db_oriskin->trans_begin();
        $data_hdr = [
            'isactive' => $this->input->post('isactive'),
            'code' => $this->input->post('code'),
            'name' => $this->input->post('name'),
            'apps_name' => $this->input->post('apps_name'),
            'description' => $this->input->post('description'),
            'producttypeid' => 1,
            'productgroupid' => 1,
            'productcategoryid' => 7,
            'alllocation' => 0,
            'updateuserid' => $userid,
        ];

        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/service/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;
            $config['file_name'] = time() . '_' . $_FILES['image']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $data_hdr['image'] = 'https://sys.eudoraclinic.com:84/app/uploads/service/' . $uploadData['file_name'];
            } else {
                echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
                return;
            }
        }

        $db_oriskin->insert('msproductmembershiphdr', $data_hdr);
        $productmembershiphdrid = $db_oriskin->insert_id();

        $data_dtl = [
            'productmembershiphdrid' => $productmembershiphdrid,
            'productbenefitid' => $productmembershiphdrid,
            'startdate' => date('Y-m-d'),
            'enddate' => date('Y-m-d'),
            'registrationfee' => 0,
            'processingfee' => 0,
            'monthlyfee' => 0,
            'firstmonthfee' => 0,
            'lastmonthfee' => 0,
            'paidfee' => 0,
            'termprice' => 0,
            'totalprice' => $this->input->post('totalprice'),
            'subscriptionmonth' => 1,
            'bonusmonth' => 0,
            'totalmonth' => 1,
            'isactive' => 1,
            'updateuserid' => $userid,
        ];

        $db_oriskin->insert('msproductmembershipdtl', $data_dtl);

        $itemList = json_decode($this->input->post('itemList'), true);
        foreach ($itemList as $items) {
            $data_benefit = [
                'membershipbenefitid' => $productmembershiphdrid,
                'treatmentid' => $items['itemid'],
                'treatmenttimespermonth' => $items['qty'],
                'isactive' => 1,
                'updateuserid' => $userid,
                'benefitcategoryid' => $items['benefitid'],
                'productid' => 0,
                'productname' => "",
                'treatmentname' => $items['servicename'],
                'price' => $items['price'],
                'membershipname' => $this->input->post('name') == "" ? NULL : $this->input->post('name'),
            ];

            $db_oriskin->insert('msproductmembershipbenefit', $data_benefit);
        }

        if ($db_oriskin->trans_status() === FALSE) {
            $db_oriskin->trans_rollback();
            $response = ['status' => 'error', 'message' => 'Transaction failed'];
        } else {
            $db_oriskin->trans_commit();
            $response = ['status' => 'success', 'message' => 'Berhasil menambahkan package in'];
        }

        echo json_encode($response);
        exit;
    }


    public function addService()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        ob_start();
        $db_oriskin = $this->load->database('oriskin', true);

        $userid = $this->session->userdata('userid');

        $db_oriskin->trans_begin();

        $data_hdr = [
            'name' => $this->input->post('name'),
            'code' => $this->input->post('code'),
            'apps_name' => $this->input->post('apps_name'),
            'productcategoryid' => 10,
            'price' => $this->input->post('price'),
            'treatmenttimes' => 1,
            'freetreatmenttimes' => 0,
            'durmin' => 60,
            'description' => $this->input->post('description'),
            'isactive' => $this->input->post('isactive'),
            'updateuserid' => $userid,
            'treatmentgroupid' => $this->input->post('group'),
            'section' => $this->input->post('section'),
            'iscanfree' => $this->input->post('iscanfree')
        ];

        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/service/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;
            $config['file_name'] = time() . '_' . $_FILES['image']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $data_hdr['image'] = 'https://sys.eudoraclinic.com:84/app/uploads/service/' . $uploadData['file_name'];
            } else {
                echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
                return;
            }
        }

        $db_oriskin->insert('mstreatment', $data_hdr);
        $serviceid = $db_oriskin->insert_id();

        $data_ingredientscategoryid = [
            'ingredientscategoryid' => $serviceid
        ];

        $db_oriskin->where('id', $serviceid);
        $db_oriskin->update('mstreatment', $data_ingredientscategoryid);


        $itemList = json_decode($this->input->post('itemList'), true);

        foreach ($itemList as $items) {
            $data_cogs = [
                'ingredientscategoryid' => $serviceid,
                'ingredientsid' => $items['itemid'],
                'qty' => $items['qty'],
                'price' => $items['price'],
            ];
            $db_oriskin->insert('mstreatmentingredients', $data_cogs);
        }

        if ($db_oriskin->trans_status() === FALSE) {
            $db_oriskin->trans_rollback();
            $response = ['status' => 'error', 'message' => 'Transaction failed'];
        } else {
            $db_oriskin->trans_commit();
            $response = ['status' => 'success', 'message' => 'Berhasil menambahkan package in'];
        }
        echo json_encode($response);
        exit;
    }


    public function prepaidFinished()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $locationid = $this->session->userdata('locationid');
        $dateYesterday = date('Y-m-d', strtotime('-1 day'));

        $result = $this->MApp->prepaidFinished($dateYesterday, $locationid);

        echo json_encode($result);
    }


    function addRemarksPrepaidYesterday()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $doingid = $this->input->post('doingid');
        $customerid = $this->input->post('customerid');
        $remarks = $this->input->post('remarks');
        $userid = $this->session->userdata('userid');

        $db_oriskin->trans_begin();

        if (is_null($doingid) || is_null($customerid) || is_null($remarks)) {
            $response = [
                'status' => 'error',
                'message' => 'Invalid input data'
            ];
        }

        $existing = $db_oriskin->get_where('msfollowupdoingyesterday', [
            'doingid' => $doingid,
            'customerid' => $customerid
        ])->row();

        $data = [
            'remarks' => $remarks,
        ];

        if ($existing) {
            $data['updateuserid'] = $userid;
            $data['updatedate'] = date('Y-m-d H:i:s');
            $db_oriskin->where('doingid', $doingid);
            $db_oriskin->where('customerid', $customerid);
            $db_oriskin->update('msfollowupdoingyesterday', $data);
        } else {
            $data['doingid'] = $doingid;
            $data['customerid'] = $customerid;
            $data['createbyuserid'] = $userid;
            $data['createdate'] = date('Y-m-d H:i:s');
            $db_oriskin->insert('msfollowupdoingyesterday', $data);
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


    public function updateCogs()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        ob_start();

        $db_oriskin = $this->load->database('oriskin', true);

        $id = $this->input->post('id');

        $data_hdr = [
            'isactive' => $this->input->post('isactive'),
            'code' => $this->input->post('code'),
            'name' => $this->input->post('name'),
            'apps_name' => $this->input->post('apps_name'),
            'description' => $this->input->post('description'),
            'treatmentgroupid' => $this->input->post('group'),
            'section' => $this->input->post('section'),
            'price' => $this->input->post('price'),
            'iscanfree' => $this->input->post('iscanfree')
        ];

        // ✅ Handle upload image
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/service/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;
            $config['file_name'] = time() . '_' . $_FILES['image']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $data_hdr['image'] = 'https://sys.eudoraclinic.com:84/app/uploads/service/' . $uploadData['file_name'];
            } else {
                echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
                return;
            }
        }

        $db_oriskin->trans_begin();

        $db_oriskin->where('id', $id);
        $db_oriskin->update('mstreatment', $data_hdr);

        if ($db_oriskin->trans_status() === FALSE) {
            $db_oriskin->trans_rollback();
            $response = ['status' => 'error', 'message' => 'Transaction failed'];
        } else {
            $db_oriskin->trans_commit();
            $response = ['status' => 'success', 'message' => 'Data berhasil diperbarui'];
        }

        echo json_encode($response);
        exit;
    }


    public function updateStockInDetail()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        ob_start();
        $db_oriskin = $this->load->database('oriskin', true);
        $post = json_decode(file_get_contents('php://input'), true);

        $userid = $this->session->userdata('userid');

        if (!$post) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        $db_oriskin->trans_begin();

        $id = $post['id'];

        $to = $db_oriskin->select('*')
            ->from('pivotwarehouselocation')
            ->where('id', $post['toLocationId'])
            ->get()
            ->row_array();

        $from = $db_oriskin->select('*')
            ->from('pivotwarehouselocation')
            ->where('id', $post['fromLocationId'])
            ->get()
            ->row_array();


        $data_hdr = [
            'tolocationid' => $post['toLocationId'] == "" ? NULL : $to['locationid'],
            'towarehouseid' => $post['toLocationId'] == "" ? NULL : $to['warehouseid'],
            'updateuserid' => $userid,
            'stockindate' => $post['stockindate'],
            'remarks' => $post['remarks'] == "" ? NULL : $post['remarks'],
            'refferenceno' => $post['refferenceno'] == "" ? NULL : $post['refferenceno'],
            'stockmovement' => $post['stockmovement'],
            'producttype' => NULL,
            'issuedby' => $post['issuedby'] == "" ? NULL : $post['issuedby'],
            'supplierid' => $post['supplierid'] == "" ? NULL : $post['supplierid'],
            'fromlocationid' => $post['fromLocationId'] == "" ? NULL : $from['locationid'],
            'fromwarehouseid' => $post['fromLocationId'] == "" ? NULL : $from['warehouseid'],
        ];

        $db_oriskin->where('id', $id);
        $db_oriskin->update('msingredientsstockin', $data_hdr);

        if ($db_oriskin->trans_status() === FALSE) {
            $db_oriskin->trans_rollback();
            $response = ['status' => 'error', 'message' => 'Transaction failed'];
        } else {
            $db_oriskin->trans_commit();
            $response = ['status' => 'success', 'message' => 'Berhasil menambahkan stock in'];
        }

        echo json_encode($response);
        exit;
    }



    public function updateStockOut()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        ob_start();
        $db_oriskin = $this->load->database('oriskin', true);
        $post = json_decode(file_get_contents('php://input'), true);

        $userid = $this->session->userdata('userid');

        if (!$post) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        $db_oriskin->trans_begin();
        $id = $post['id'];

        $to = $db_oriskin->select('*')
            ->from('pivotwarehouselocation')
            ->where('id', $post['toLocationId'])
            ->get()
            ->row_array();

        $from = $db_oriskin->select('*')
            ->from('pivotwarehouselocation')
            ->where('id', $post['fromLocationId'])
            ->get()
            ->row_array();

        $type = $post['type'];

        $data_hdr = [
            'tolocationid' => $post['toLocationId'] == "" ? NULL : $to['locationid'],
            'towarehouseid' => $post['toLocationId'] == "" ? NULL : $to['warehouseid'],
            'updateuserid' => $userid,
            'stockoutdate' => $post['stockoutdate'],
            'remarks' => $post['remarks'] == "" ? NULL : $post['remarks'],
            'refferenceno' => $post['refferenceno'] == "" ? NULL : $post['refferenceno'],
            'status' => $post['status'],
            'stockmovement' => $post['stockmovement'],
            'issuedby' => $post['issuedby'] == "" ? NULL : $post['issuedby'],
            'fromlocationid' => $post['fromLocationId'] == "" ? NULL : $from['locationid'],
            'fromwarehouseid' => $post['fromLocationId'] == "" ? NULL : $from['warehouseid'],
        ];

        $data_hdrstockin = [
            'tolocationid' => $post['toLocationId'] == "" ? NULL : $to['locationid'],
            'towarehouseid' => $post['toLocationId'] == "" ? NULL : $to['warehouseid'],
            'updateuserid' => $userid,
            'stockindate' => $post['stockoutdate'],
            'remarks' => $post['remarks'] == "" ? NULL : $post['remarks'],
            'refferenceno' => $post['refferenceno'] == "" ? NULL : $post['refferenceno'],
            'status' => $post['status'],
            'stockmovement' => $post['stockmovement'],
            'issuedby' => $post['issuedby'] == "" ? NULL : $post['issuedby'],
            'supplierid' => $post['supplierid'] == "" ? NULL : $post['supplierid'],
            'fromlocationid' => $post['fromLocationId'] == "" ? NULL : $from['locationid'],
            'fromwarehouseid' => $post['fromLocationId'] == "" ? NULL : $from['warehouseid'],
        ];

        $db_oriskin->where('id', $id);

        if ($type == 1) {
            $db_oriskin->update('msingredientsstockin', $data_hdrstockin);
        } elseif ($type == 2) {
            $db_oriskin->update('msingredientsstockout', $data_hdr);
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


    public function updateStockOutDetail()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        ob_start();
        $db_oriskin = $this->load->database('oriskin', true);
        $post = json_decode(file_get_contents('php://input'), true);

        $userid = $this->session->userdata('userid');

        if (!$post) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        $db_oriskin->trans_begin();
        $id = $post['id'];

        $to = $db_oriskin->select('*')
            ->from('pivotwarehouselocation')
            ->where('id', $post['toLocationId'])
            ->get()
            ->row_array();

        $from = $db_oriskin->select('*')
            ->from('pivotwarehouselocation')
            ->where('id', $post['fromLocationId'])
            ->get()
            ->row_array();

        $data_hdr = [
            'tolocationid' => $post['toLocationId'] == "" ? NULL : $to['locationid'],
            'towarehouseid' => $post['toLocationId'] == "" ? NULL : $to['warehouseid'],
            'updateuserid' => $userid,
            'stockoutdate' => $post['stockoutdate'],
            'remarks' => $post['remarks'] == "" ? NULL : $post['remarks'],
            'refferenceno' => $post['refferenceno'] == "" ? NULL : $post['refferenceno'],
            'stockmovement' => $post['stockmovement'],
            'issuedby' => $post['issuedby'] == "" ? NULL : $post['issuedby'],
            'fromlocationid' => $post['fromLocationId'] == "" ? NULL : $from['locationid'],
            'fromwarehouseid' => $post['fromLocationId'] == "" ? NULL : $from['warehouseid'],
        ];

        $db_oriskin->where('id', $id);
        $db_oriskin->update('msingredientsstockout', $data_hdr);

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


    public function saveStockIn()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        ob_start();
        $db_oriskin = $this->load->database('oriskin', true);
        $post = json_decode(file_get_contents('php://input'), true);

        $userid = $this->session->userdata('userid');

        if (!$post) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }


        $sql = "SELECT shortcode as SHORTCODE FROM mslocation WHERE id = ?";
        $query = $db_oriskin->query($sql, [$post['toLocationId']])->row();
        $shortcode = $query->SHORTCODE;

        $tahun = date('Y');
        $bulan = date('m');

        $sql = "SELECT MAX(id) AS last_id FROM msingredientsstockin";
        $query = $db_oriskin->query($sql)->row();
        $lastId = $query->last_id ?? 0;
        $newNumber = str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        $itemsCode = $shortcode . $tahun . $bulan . $newNumber;

        $to = $db_oriskin->select('*')
            ->from('pivotwarehouselocation')
            ->where('id', $post['toLocationId'])
            ->get()
            ->row_array();

        $from = $db_oriskin->select('*')
            ->from('pivotwarehouselocation')
            ->where('id', $post['fromLocationId'])
            ->get()
            ->row_array();

        $db_oriskin->trans_begin();

        $data_hdr = [
            'tolocationid' => $post['toLocationId'] == "" ? NULL : $to['locationid'],
            'towarehouseid' => $post['toLocationId'] == "" ? NULL : $to['warehouseid'],
            'updateuserid' => $userid,
            'stockindate' => $post['stockindate'],
            'remarks' => $post['remarks'] == "" ? NULL : $post['remarks'],
            'refferenceno' => $post['refferenceno'] == "" ? NULL : $post['refferenceno'],
            'status' => $post['status'],
            'stockmovement' => $post['stockmovement'],
            'code' => $itemsCode,
            'producttype' => NULL,
            'issuedby' => $post['issuedby'] == "" ? NULL : $post['issuedby'],
            'supplierid' => $post['supplierid'] == "" ? NULL : $post['supplierid'],
            'fromlocationid' => $post['fromLocationId'] == "" ? NULL : $from['locationid'],
            'fromwarehouseid' => $post['fromLocationId'] == "" ? NULL : $from['warehouseid'],
        ];
        $db_oriskin->insert('msingredientsstockin', $data_hdr);
        $stockinid = $db_oriskin->insert_id();

        foreach ($post['itemLists'] as $items) {
            $itemstockout = [
                'ingredientsid' => $items['itemid'],
                'stockinqty' => $items['qty'],
                'stockinid' => $stockinid,
            ];

            if (!$stockinid) {
                $db_oriskin->trans_rollback();
                echo json_encode(['status' => 'error', 'message' => 'Failed to insert stock id']);
                return;
            }
            $db_oriskin->insert('itemstockin', $itemstockout);
        }

        if ($db_oriskin->trans_status() === FALSE) {
            $db_oriskin->trans_rollback();
            $response = ['status' => 'error', 'message' => 'Transaction failed'];
        } else {
            $db_oriskin->trans_commit();
            $response = ['status' => 'success', 'message' => 'Berhasil menambahkan stock in'];
        }

        echo json_encode($response);
        exit;
    }


    public function saveStockOut()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        ob_start();
        $db_oriskin = $this->load->database('oriskin', true);
        $post = json_decode(file_get_contents('php://input'), true);

        $userid = $this->session->userdata('userid');

        if (!$post) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        $sql = "SELECT shortcode as SHORTCODE FROM mslocation WHERE id = ?";
        $query = $db_oriskin->query($sql, [$post['fromLocationId']])->row();
        $shortcode = $query->SHORTCODE;

        $tahun = date('Y');
        $bulan = date('m');

        $sql = "SELECT MAX(id) AS last_id FROM msingredientsstockout";
        $query = $db_oriskin->query($sql)->row();
        $lastId = $query->last_id ?? 0;
        $newNumber = str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        $itemsCode = $shortcode . $tahun . $bulan . $newNumber;


        $to = $db_oriskin->select('*')
            ->from('pivotwarehouselocation')
            ->where('id', $post['toLocationId'])
            ->get()
            ->row_array();

        $from = $db_oriskin->select('*')
            ->from('pivotwarehouselocation')
            ->where('id', $post['fromLocationId'])
            ->get()
            ->row_array();


        $db_oriskin->trans_begin();

        $data_hdr = [
            'tolocationid' => $post['toLocationId'] == "" ? NULL : $to['locationid'],
            'towarehouseid' => $post['toLocationId'] == "" ? NULL : $to['warehouseid'],
            'updateuserid' => $userid,
            'stockoutdate' => $post['stockoutdate'],
            'remarks' => $post['remarks'] == "" ? NULL : $post['remarks'],
            'refferenceno' => $post['refferenceno'] == "" ? NULL : $post['refferenceno'],
            'status' => $post['status'],
            'stockmovement' => $post['stockmovement'],
            'code' => $itemsCode,
            'dono' => $post['dono'] == "" ? NULL : $post['dono'],
            'invoiceno' => $post['invoiceno'] == "" ? NULL : $post['invoiceno'],
            'producttype' => NULL,
            'issuedby' => $post['issuedby'] == "" ? NULL : $post['issuedby'],
            'fromlocationid' => $post['fromLocationId'] == "" ? NULL : $from['locationid'],
            'fromwarehouseid' => $post['fromLocationId'] == "" ? NULL : $from['warehouseid']
        ];
        $db_oriskin->insert('msingredientsstockout', $data_hdr);
        $stockoutid = $db_oriskin->insert_id();

        foreach ($post['itemLists'] as $items) {
            $itemstockout = [
                'ingredientsid' => $items['itemid'],
                'stockoutqty' => $items['qty'],
                'stockoutid' => $stockoutid,
            ];

            if (!$stockoutid) {
                $db_oriskin->trans_rollback();
                echo json_encode(['status' => 'error', 'message' => 'Failed to insert stock out']);
                return;
            }
            $db_oriskin->insert('itemstockout', $itemstockout);
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


    public function addRemarkCallAppointment21Days()
    {
        // Ambil data dari POST
         error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $customerid = $this->input->post('customerid');
        $period = $this->input->post('period');
        $remarks = $this->input->post('remarks');
        $userId = $this->session->userdata('userid'); // asumsikan ada session login

        if (empty($customerid) || empty($period) || empty($remarks) || empty($userId)) {
            echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        // Cek apakah record sudah ada
        $db_oriskin->where('customerid', $customerid);
        $db_oriskin->where('period', $period);
        $query = $db_oriskin->get('call_appointment_21days_remarks');
        $existing = $query->row();

        if ($existing) {
            $data = [
                'remarks' => $remarks,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $userId
            ];
            $db_oriskin->where('id', $existing->id);
            $db_oriskin->update('call_appointment_21days_remarks', $data);
            echo json_encode(['status' => true, 'message' => 'Remark berhasil diupdate']);
        } else {
            $data = [
                'customerid' => $customerid,
                'period' => $period,
                'remarks' => $remarks,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $userId
            ];
            $db_oriskin->insert('call_appointment_21days_remarks', $data);
            echo json_encode(['status' => true, 'message' => 'Remark berhasil disimpan']);
        }
    }
}


