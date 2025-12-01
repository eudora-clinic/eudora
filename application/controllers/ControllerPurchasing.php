<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ControllerPurchasing extends CI_Controller
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
		$this->load->model('ModelPurchasing');
		$this->load->library('Utility');
		$this->load->library('Datatables');
		$this->load->library('numbertowords');
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
				case 'listWarehouse':
					$data['level'] = $this->session->userdata('level');
					$data['title'] = 'listWarehouse';
					$data['content'] = 'Purchasing/listWarehouse';
					$data['mod'] = $type;
					break;
				case 'generateBarcode':
					$data['level'] = $this->session->userdata('level');
					$data['title'] = 'GenerateBarcode';
					$data['content'] = 'generateBarcode';
					$data['mod'] = $type;
					break;
				case 'listSupplier':
					$data['level'] = $this->session->userdata('level');
					$data['title'] = 'listSupplier';
					$data['content'] = 'Purchasing/listSupplier';
					$data['mod'] = $type;
					$data['cityList'] = $this->MApp->getCityList();
					break;
				case 'deliveryOrder':
					$data['title'] = 'deliveryOrder';
					$data['content'] = 'Purchasing/deliveryOrder';
					$data['mod'] = $type;
					$data['cityList'] = $this->MApp->getCityList();
					$id = $this->uri->segment(2);
					if ($id) {
						$data['id'] = $id;
					}
					break;
				case 'deliveryOrderPurchasing':
					$data['title'] = 'deliveryOrderPurchasing';
					$data['content'] = 'Purchasing/deliveryOrderPurchasing';
					$data['mod'] = $type;
					$data['cityList'] = $this->MApp->getCityList();
					$id = $this->uri->segment(4);
					if ($id) {
						$data['id'] = $id;
					}
					break;
				case 'deliveryOrderPurchasingChecked':
					$data['title'] = 'deliveryOrderPurchasingChecked';
					$data['content'] = 'Purchasing/deliveryOrderPurchasingChecked';
					$data['mod'] = $type;
					$data['cityList'] = $this->MApp->getCityList();
					$id = $this->uri->segment(4);
					if ($id) {
						$data['id'] = $id;
					}
					break;
				case 'deliveryOrderChecked':
					$data['title'] = 'deliveryOrderChecked';
					$data['content'] = 'Purchasing/deliveryOrderChecked';
					$data['mod'] = $type;
					$data['cityList'] = $this->MApp->getCityList();
					$id = $this->uri->segment(2);
					if ($id) {
						$data['id'] = $id;
					}
					break;
				case 'deliveryOrderList':
					$data['title'] = 'deliveryOrderList';
					$data['content'] = 'Purchasing/deliveryOrderList';
					$data['mod'] = $type;
					$data['cityList'] = $this->MApp->getCityList();
					$data['companies'] = $this->ModelPurchasing->getCompanyMasters();
					$id = $this->uri->segment(4);
					if ($id) {
						$data['id'] = $id;
					}
					break;
				case 'purchaseOrderApproval':
					$data['title'] = 'purchaseOrderApproval';
					$data['content'] = 'Purchasing/purchaseOrderListApproval1';
					$data['mod'] = $type;
					$data['companies'] = $this->ModelPurchasing->getCompanyMasters();
					break;
				case 'purchaseRequestByUser':
					$data['title'] = 'purchaseRequestByUser';
					$data['content'] = 'Purchasing/purchaseRequestbyUser';
					$data['mod'] = $type;
					$data['cityList'] = $this->MApp->getCityList();
					$id = $this->uri->segment(4);
					if ($id) {
						$data['id'] = $id;
					}
					break;
				case 'purchaseRequestList':
					$data['title'] = 'purchaseRequestList';
					$data['content'] = 'Purchasing/purchaseRequestList';
					$data['mod'] = $type;
					$data['companies'] = $this->ModelPurchasing->getCompanyMasters();
					break;
				case 'financeApproval':
					$level = $this->session->userdata('level');
					$data['title'] = 'financeApproval';
					$data['content'] = 'Purchasing/financeApproval';
					$data['mod'] = $type;
					break;
				case 'addPurchaseOrder':
					$data['title'] = 'Add Purchase Order';
					$data['content'] = 'Purchasing/addPurchaseOrder';
					$data['mod'] = $type;
					$id = $this->uri->segment(2);
					if ($id) {
						$data['id'] = $id;
					}

					break;
				case 'purchaseRequest':
					$data['level'] = $this->session->userdata('level');
					$data['title'] = 'purchaseRequest';
					$data['content'] = 'Purchasing/purchaseRequest';
					$data['mod'] = $type;
					// $this->load->model('MApp');
					// $db_oriskin = $this->load->database('oriskin', true);
					// $userid = $this->session->userdata('userid');
					$locationid = $this->session->userdata('locationid');
					$data['user'] = $this->ModelPurchasing->get_location_data_by_id($locationid);
					// $data['supplierLists'] = $this->MApp->getSuppliers();
					// $data['employeeList'] = $this->MApp->getEmployeePurchaseRequest();
					break;
				case 'purchaseOrder':
					$data['title'] = 'purchaseOrderList';
					$data['content'] = 'Purchasing/purchaseOrderList';
					$data['mod'] = $type;
					$data['companies'] = $this->ModelPurchasing->getCompanyMasters();
					break;
				case 'detailPurchaseOrder':
					$data['title'] = 'detailPurchaseOrder';
					$data['content'] = 'Purchasing/detailPurchaseOrder';
					$data['mod'] = $type;
					$id = $this->uri->segment(2);
					$data['po'] = $this->ModelPurchasing->get_purchase_order_by_id($id);
					if ($id) {
						$data['id'] = $id;
					}
					break;
				case 'editPurchaseOrder':
					$data['title'] = 'editPurchaseOrder';
					$data['content'] = 'Purchasing/editPurchaseOrder';
					$data['mod'] = $type;
					$id = $this->uri->segment(2);
					if ($id) {
						$data['id'] = $id;
					}
					break;
				case 'editPurchaseRequest':
					$data['title'] = 'purchaseRequestList';
					$data['content'] = 'Purchasing/editPurchaseRequest';
					$data['mod'] = $type;
					$this->load->model('MApp');
					$db_oriskin = $this->load->database('oriskin', true);
					$userid = $this->session->userdata('userid');
					$locationid = $this->session->userdata('locationid');
					// $data['purchase_request'] = $this->MApp->get_purchase_request_by_id($id);
					// $data['employeeList'] = $this->MApp->getEmployeePurchaseRequest();
					break;
				case 'reportOrderMonthly':
					$data['companies'] = $this->ModelPurchasing->getCompanyMasters();
					$data['title'] = 'purchaseRequestList';
					$data['content'] = 'Purchasing/reportOrderMonthly';
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


	public function getCompanyMaster()
	{
		error_reporting(0);
		ini_set('display_errors', 0);

		$data = $this->ModelCompany->getCompanyMaster();

		echo json_encode([
			'listCompany' => $data,
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

	public function createCompanyMaster()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);

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
	public function listCity()
	{
		$data = $this->ModelPurchasing->getCityList();

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => "{$row->name}"
			];
		}
		echo json_encode($result);
	}


	public function listProvince()
	{
		$keyword = $this->input->get('term');
		$data = $this->ModelPurchasing->getProvinceList($keyword);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => $row->name
			];
		}
		echo json_encode($result);
	}

	public function listCityByProvince()
	{
		$provinceid = $this->input->get('provinceid');
		$keyword = $this->input->get('term');
		$data = $this->ModelPurchasing->getCityByProvince($provinceid, $keyword);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => $row->name
			];
		}
		echo json_encode($result);
	}

	public function getAlternatives($ingredientId)
	{
		$db = $this->load->database('oriskin', true);
		$db->select('*')->from('alternativeunitingredient')->where('ingredientid', $ingredientId);
		$result = $db->get()->result_array();

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	public function saveSupplier()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$user_id = $this->session->userdata('userid');
		$this->output->set_content_type('application/json');

		$data = json_decode(file_get_contents('php://input'), true);
		if (!$data) {
			$data = $this->input->post(); // fallback untuk form-data
		}

		if (!$data) {
			echo json_encode(['status' => 'error', 'db_error' => 'Data kosong']);
			return;
		}

		// Data supplier
		$supplierData = [
			'suppliercode' => $data['suppliercode'] ?? null,
			'name' => $data['name'] ?? null,
			'address' => $data['address'] ?? null,
			'provinceid' => $data['provinceid'] ?? null,
			'cityid' => $data['cityid'] ?? null,
			'zipcode' => $data['zipcode'] ?? null,
			'phone' => $data['phone'] ?? null,
			'email' => $data['email'] ?? null,
			'bank_name' => $data['bank_name'] ?? null,
			'account' => $data['account'] ?? null,
			'isactive' => 1,
		];

		$db_oriskin->trans_start();

		// Insert supplier
		$insert = $db_oriskin->insert('mssupplier', $supplierData);
		$supplierId = $db_oriskin->insert_id();

		if (!$insert) {
			$error = $db_oriskin->error();
			echo json_encode(['status' => 'error', 'db_error' => $error]);
			return;
		}

		// Insert sales kalau ada
		if (!empty($data['items'])) {
			foreach ($data['items'] as $item) {
				$salesData = [
					'supplierid' => $supplierId,
					'nama' => $item['nama'] ?? null,
					'email' => $item['email'] ?? null,
					'phonenumber' => $item['phone'] ?? null,
					'address' => $item['address'] ?? null,
					'isactive' => 1,
					'createdat' => date('Y-m-d H:i:s'),
					'createdby' => $user_id,
				];

				$ok = $db_oriskin->insert('suppliersales', $salesData);

				if (!$ok) {
					$error = $db_oriskin->error();
					echo json_encode(['status' => 'error', 'db_error' => $error]);
					return;
				}
			}
		}

		$db_oriskin->trans_complete();

		if ($db_oriskin->trans_status() === false) {
			echo json_encode(['status' => 'error', 'db_error' => $db_oriskin->error()]);
		} else {
			echo json_encode(['status' => 'success']);
		}
	}

	public function getSuppliers()
	{
		$data = $this->ModelPurchasing->getSuppliers();
		echo json_encode(['data' => $data]);
	}

	public function getSupplierById($id)
	{
		$db_oriskin = $this->load->database('oriskin', TRUE);

		// Ambil data supplier
		$data = $db_oriskin
			->select('
				s.*,
				p.name AS province_name,
				c.name AS city_name
			')
			->from('mssupplier s')
			->join('msprovince p', 'p.id = s.provinceid', 'left')
			->join('mscity c', 'c.id = s.cityid', 'left')
			->where('s.id', $id)
			->get()
			->row_array();

		// Ambil semua sales yang terkait supplier ini
		$sales = $db_oriskin
			->select('*')
			->from('suppliersales')
			->where('supplierid', $id)
			->get()
			->result_array();

		// Gabungkan ke dalam 1 response
		$data['sales'] = $sales;

		echo json_encode($data);
	}

	public function updateSupplier()
	{
		$db_oriskin = $this->load->database('oriskin', TRUE);
		$id = $this->input->post('id');
		$user_id = $this->session->userdata('userid');
		$updateData = [
			'name' => $this->input->post('name'),
			'suppliercode' => $this->input->post('suppliercode'),
			'address' => $this->input->post('address'),
			'provinceid' => $this->input->post('provinceid'),
			'cityid' => $this->input->post('cityid'),
			'zipcode' => $this->input->post('zipcode'),
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'bank_name' => $this->input->post('bank_name'),
			'account' => $this->input->post('account'),
			'updateuserid' => $user_id,
			'updatedate' => date('Y-m-d H:i:s')
		];

		$inser = $db_oriskin->where('id', $id)->update('mssupplier', $updateData);
		echo json_encode(['status' => 'success']);
	}

	public function deleteSupplier()
	{
		$db_oriskin = $this->load->database('oriskin', TRUE);
		header('Content-Type: application/json');

		$id = $this->input->post('id');

		try {
			// ambil supplier
			$supplier = $db_oriskin->where('id', $id)->get('mssupplier')->row_array();

			if (!$supplier) {
				echo json_encode(['status' => 'error', 'message' => 'Supplier not found']);
				return;
			}

			// toggle isactive
			$newStatus = $supplier['isactive'] == 1 ? 0 : 1;

			$updated = $db_oriskin->where('id', $id)->update('mssupplier', [
				'isactive' => $newStatus,
				'updatedate' => date('Y-m-d H:i:s')
			]);

			if ($updated) {
				echo json_encode(['status' => 'success', 'newStatus' => $newStatus]);
			} else {
				$error = $db_oriskin->error();
				echo json_encode(['status' => 'error', 'message' => $error['message']]);
			}

		} catch (Exception $e) {
			echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
		}
	}

	function bulanRomawi($bulan)
	{
		$romawi = [
			1 => 'I',
			2 => 'II',
			3 => 'III',
			4 => 'IV',
			5 => 'V',
			6 => 'VI',
			7 => 'VII',
			8 => 'VIII',
			9 => 'IX',
			10 => 'X',
			11 => 'XI',
			12 => 'XII'
		];

		return $romawi[(int) $bulan] ?? '';
	}

	// public function savePurchaseRequest()
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$post = json_decode(file_get_contents('php://input'), true);
	// 	$userid = $this->session->userdata('userid');

	// 	if (!$post) {
	// 		echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
	// 		return;
	// 	}

	// 	$companyData = $db_oriskin->select('companycode')
	// 		->from('mscompany')
	// 		->where('id', $post['companyid'])
	// 		->get()
	// 		->row_array();

	// 	$companyCode = isset($companyData['companycode']) ? str_replace(' ', '', $companyData['companycode']) : 'COMPANY';

	// 	$month = date('m', strtotime($post['requestdate']));
	// 	$year = date('Y', strtotime($post['requestdate']));

	// 	$db_oriskin->where('companyid', $post['companyid']);
	// 	$db_oriskin->where('MONTH(requestdate)', $month);
	// 	$db_oriskin->where('YEAR(requestdate)', $year);
	// 	$total = $db_oriskin->count_all_results('purchase_request') + 1;
	// 	$totalFormatted = str_pad($total, 3, '0', STR_PAD_LEFT);

	// 	$employee = $db_oriskin->get_where('msemployeedetail', ['id' => $post['requesterid']])->row_array();

	// 	$requestcode = "PR-" . $companyCode . "-" . $month . $year ."-". $totalFormatted;

	// 	$db_oriskin->trans_begin();

	// 	// Simpan purchase_request
	// 	$data_pr = [
	// 		'createdby' => $userid,
	// 		'requestdate' => $post['requestdate'],
	// 		'requesterid' => $post['requesterid'],
	// 		'warehouseid' => $post['warehouseid'],
	// 		'companyid' => $post['companyid'],
	// 		'departmentid'=>$employee['departmentid'],
	// 		'status' => 1,
	// 		'notes' => $post['notes'],
	// 		'requestnumber' => $requestcode
	// 	];

	// 	$insertPR = $db_oriskin->insert('purchase_request', $data_pr);
	// 	if (!$insertPR) {
	// 		$error = $db_oriskin->error(); // Tangkap error SQL Server
	// 		$db_oriskin->trans_rollback();
	// 		echo json_encode(['status' => 'error', 'message' => 'Gagal insert purchase request', 'error' => $error]);
	// 		return;
	// 	}

	// 	$prid = $db_oriskin->insert_id();

	// 	// Simpan item list
	// 	foreach ($post['itemLists'] as $items) {
	// 		if (empty($items['itemid']) || empty($items['qty'])) continue;

	// 		$pritems = [
	// 			'itemid' => $items['itemid'],
	// 			'quantity' => $items['qty'],
	// 			'purchase_request_id' => $prid,
	// 			'status' => 1, 
	// 			'description' => $items['description'], 
	// 			'created_by'=>$post['requesterid']
	// 		];

	// 		$insertItem = $db_oriskin->insert('purchase_request_items', $pritems);
	// 		if (!$insertItem) {
	// 			$error = $db_oriskin->error();
	// 			$db_oriskin->trans_rollback();
	// 			echo json_encode(['status' => 'error', 'message' => 'Gagal insert purchase request item', 'error' => $error]);
	// 			return;
	// 		}
	// 	}

	// 	if ($db_oriskin->trans_status() === FALSE) {
	// 		$db_oriskin->trans_rollback();
	// 		$response = ['status' => 'error', 'message' => 'Transaction failed'];
	// 	} else {
	// 		$db_oriskin->trans_commit();
	// 		$response = ['status' => 'success', 'message' => 'Berhasil menambahkan purchase request'];
	// 	}

	// 	echo json_encode($response);
	// }

	// 	public function savePurchaseRequest()
// {
//     $db_oriskin = $this->load->database('oriskin', true);
//     $post = json_decode(file_get_contents('php://input'), true);
//     $userid = $this->session->userdata('userid');

	//     if (!$post) {
//         echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
//         return;
//     }

	//     try {
//         // Ambil company code
//         $companyData = $db_oriskin->select('companycode')
//             ->from('mscompany')
//             ->where('id', $post['companyid'])
//             ->get()
//             ->row_array();

	//         $companyCode = isset($companyData['companycode']) ? str_replace(' ', '', $companyData['companycode']) : 'COMPANY';

	//         // Format bulan & tahun dari requestdate
//         $month = date('m', strtotime($post['requestdate']));
//         $year = date('Y', strtotime($post['requestdate']));

	//         // Hitung total PR bulan & tahun berjalan
//         $db_oriskin->where('companyid', $post['companyid']);
//         $db_oriskin->where('MONTH(requestdate)', $month);
//         $db_oriskin->where('YEAR(requestdate)', $year);
//         $total = $db_oriskin->count_all_results('purchase_request') + 1;
//         $totalFormatted = str_pad($total, 3, '0', STR_PAD_LEFT);

	//         // Ambil detail requester
//         $employee = $db_oriskin->get_where('msemployeedetail', ['id' => $post['requesterid']])->row_array();

	//         // Generate request code
//         $requestcode = "PR-" . $companyCode . "-" . $month . $year . "-" . $totalFormatted;

	//         $db_oriskin->trans_begin();

	//         // Simpan purchase_request
//         $data_pr = [
//             'createdby'     => $userid,
//             'requestdate'   => $post['requestdate'],
//             'requesterid'   => $post['requesterid'],
//             'warehouseid'   => $post['warehouseid'],
//             'companyid'     => $post['companyid'],
//             'departmentid'  => $employee['departmentid'] ?? null,
//             'status'        => 1,
//             'notes'         => $post['notes'],
//             'requestnumber' => $requestcode
//         ];

	//         $insertPR = $db_oriskin->insert('purchase_request', $data_pr);
//         if (!$insertPR) {
//             $error = $db_oriskin->error();
//             $db_oriskin->trans_rollback();
//             echo json_encode(['status' => 'error', 'message' => 'Gagal insert purchase request', 'error' => $error]);
//             return;
//         }

	//         $prid = $db_oriskin->insert_id();

	//         // Simpan item list
//         if (!empty($post['itemLists'])) {
//             foreach ($post['itemLists'] as $items) {
//                 if (empty($items['itemid']) || empty($items['qty'])) continue;

	//                 $pritems = [
//                     'itemid'               => $items['itemid'],
//                     'quantity'             => $items['qty'],
//                     'purchase_request_id'  => $prid,
//                     'status'               => 1,
//                     'description'          => $items['description'] ?? null,
//                     'created_by'           => $userid
//                 ];

	//                 $insertItem = $db_oriskin->insert('purchase_request_items', $pritems);
//                 if (!$insertItem) {
//                     $error = $db_oriskin->error();
//                     $db_oriskin->trans_rollback();
//                     echo json_encode(['status' => 'error', 'message' => 'Gagal insert purchase request item', 'error' => $error]);
//                     return;
//                 }
//             }
//         }

	//         if ($db_oriskin->trans_status() === FALSE) {
//             $db_oriskin->trans_rollback();
//             $response = ['status' => 'error', 'message' => 'Transaction failed'];
//         } else {
//             $db_oriskin->trans_commit();
//             $response = [
//                 'status'  => 'success',
//                 'message' => 'Berhasil menambahkan purchase request',
//                 'requestnumber' => $requestcode
//             ];
//         }
//     } catch (Exception $e) {
//         $db_oriskin->trans_rollback();
//         $response = ['status' => 'error', 'message' => $e->getMessage()];
//     }

	//     echo json_encode($response);
// }

	public function savePurchaseRequest()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$userid = $this->session->userdata('userid');
		$level = $this->session->userdata('level');

		// --- Ambil data POST (karena dikirim lewat FormData)
		$post = $this->input->post();

		if (!$post) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid or empty data received']);
			return;
		}

		try {
			// --- Ambil kode perusahaan ---
			$companyData = $db_oriskin->select('companycode')
				->from('mscompany')
				->where('id', $post['companyid'])
				->get()
				->row_array();

			$companyCode = isset($companyData['companycode']) ? str_replace(' ', '', $companyData['companycode']) : 'COMPANY';

			// --- Format nomor PR ---
			$month = date('m', strtotime($post['requestdate']));
			$year = date('Y', strtotime($post['requestdate']));
			$monthRomawi = $this->bulanRomawi($month);

			$total = $db_oriskin->count_all_results('purchase_request') + 1;
			$totalFormatted = str_pad($total, 6, '0', STR_PAD_LEFT);

			$employee = $db_oriskin->get_where('msemployeedetail', ['id' => $post['requesterid']])->row_array();
			$requestcode = $totalFormatted . "/" . $companyCode . "/PR/EDR-" . $monthRomawi . "-" . $year;

			$db_oriskin->trans_begin();

			// --- Insert header PR ---
			$data_pr = [
				'createdby' => $userid,
				'requestdate' => $post['requestdate'],
				'requesterid' => $post['requesterid'],
				'warehouseid' => $post['warehouseid'],
				'companyid' => $post['companyid'],
				'departmentid' => $employee['departmentid'] ?? null,
				'status' => 1,
				'notes' => $post['notes'],
				'requestnumber' => $requestcode
			];

			$insertPR = $db_oriskin->insert('purchase_request', $data_pr);
			if (!$insertPR) {
				$db_oriskin->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Gagal insert purchase request']);
				return;
			}

			$prid = $db_oriskin->insert_id();

			// --- Insert detail item ---
			$itemCount = isset($post['items']) ? count($post['items']) : 0;

			for ($i = 0; $i < $itemCount; $i++) {
				$itemid = $post['items'][$i]['id'] ?? null;
				$qty = $post['items'][$i]['qty'] ?? null;
				$unitid = $post['items'][$i]['unitid'] ?? null;
				$desc = $post['items'][$i]['description'] ?? null;

				if (empty($itemid) || empty($qty))
					continue;

				$pritems = [
					'itemid' => $itemid,
					'quantity' => $qty,
					'purchase_request_id' => $prid,
					'status' => 0,
					'description' => $desc,
					'created_by' => $userid,
					'alternativeunitid' => $unitid
				];

				$insertItem = $db_oriskin->insert('purchase_request_items', $pritems);
				if (!$insertItem) {
					$db_oriskin->trans_rollback();
					echo json_encode(['status' => 'error', 'message' => 'Gagal insert purchase request item']);
					return;
				}

				$itemInsertId = $db_oriskin->insert_id();

				if (!empty($_FILES['images']['name'][$i])) {
					$files = $_FILES['images'];

					$uploadPath = './uploads/purchase_request_items/';
					if (!is_dir($uploadPath))
						mkdir($uploadPath, 0777, true);

					$countFiles = count($files['name'][$i]);
					for ($j = 0; $j < $countFiles; $j++) {
						$_FILES['file']['name'] = $files['name'][$i][$j];
						$_FILES['file']['type'] = $files['type'][$i][$j];
						$_FILES['file']['tmp_name'] = $files['tmp_name'][$i][$j];
						$_FILES['file']['error'] = $files['error'][$i][$j];
						$_FILES['file']['size'] = $files['size'][$i][$j];

						$config['upload_path'] = $uploadPath;
						$config['allowed_types'] = 'jpg|jpeg|png';
						$config['max_size'] = 2048;
						$config['encrypt_name'] = true;

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if ($this->upload->do_upload('file')) {
							$uploadData = $this->upload->data();
							$filePath = 'uploads/purchase_request_items/' . $uploadData['file_name'];

							$imgData = [
								'purchase_request_item_id' => $itemInsertId,
								'image_path' => $filePath,
								'description' => null
							];
							$db_oriskin->insert('purchase_request_item_images', $imgData);
						}
					}
				}
			}

			// --- Commit transaksi
			if ($db_oriskin->trans_status() === FALSE) {
				$db_oriskin->trans_rollback();
				$response = ['status' => 'error', 'message' => 'Transaction failed'];
			} else {
				$db_oriskin->trans_commit();

				// --- Kirim notifikasi WA approval ---
				$user = $db_oriskin->where('id', 23)->get('msuser')->row_array();
				if ($user) {
					$token = bin2hex(random_bytes(32));
					$expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));
					$db_oriskin->insert('user_token', [
						'userid' => 23,
						'magic_token' => $token,
						'expired_time' => $expired,
						'createdby' => $userid,
					]);

					$magic_link = base_url('magic_login?token=' . $token . '&redirect=purchaseRequestList');
					$data = [
						"recipient_type" => "individual",
						"to" => "6285776761415",
						"type" => "text",
						"text" => ["body" => "Halo,\n\nAda permintaan approval Purchase Request baru.\nKlik link berikut untuk melakukan approval:\n{$magic_link}."]
					];
					$this->sendNotif($data);
				}

				$redirectUrl = !in_array($level, [23, 7])
					? "https://sys.eudoraclinic.com:84/app/purchaseRequestLists"
					: "https://sys.eudoraclinic.com:84/app/purchaseRequestList";

				$response = [
					'status' => 'success',
					'message' => 'Berhasil menambahkan purchase request',
					'requestnumber' => $requestcode,
					'redirect' => $redirectUrl
				];
			}

		} catch (Exception $e) {
			$db_oriskin->trans_rollback();
			$response = ['status' => 'error', 'message' => $e->getMessage()];
		}

		echo json_encode($response);
	}


	public function getAllPurchaseRequest()
	{
		$this->load->model('ModelPurchasing');

		$data = $this->ModelPurchasing->get_all_purchase_request();

		echo json_encode($data);
	}

	public function getAllDeliveryOrder()
	{
		$this->load->model('ModelPurchasing');
		$date = $this->input->get('date') ?? null;
		$company = $this->input->get('company');

		$userid = $this->session->userdata('userid');
		$level = $this->session->userdata('level');


		$data = $this->ModelPurchasing->get_all_delivery_order_by_date($date, $company, $userid);

		echo json_encode($data);
	}

	public function getAllPurchaseRequestByUser()
	{
		$this->load->model('ModelPurchasing');
		$date = $this->input->get('date') ?? date('Y-m-d');
		$user = $this->session->userdata('userid');
		$data = $this->ModelPurchasing->get_all_purchase_request_by_user($user, $date);

		echo json_encode($data);
	}

	public function getAllPurchaseRequestByDate()
	{
		$this->load->model('ModelPurchasing');

		$date = $this->input->get('date') ?? null;
		$company = $this->input->get('company') ?? null;

		$data = $this->ModelPurchasing->get_all_purchase_request_by_date($date, $company);

		echo json_encode($data);
	}

	public function getSalesBySupplier($id)
	{
		$this->load->model('ModelPurchasing');
		$data = $this->ModelPurchasing->get_sales_supplier($id);

		echo json_encode($data);
	}

	public function getAllPurchaseOrder()
	{
		$this->load->model('ModelPurchasing');
		$data = $this->ModelPurchasing->get_all_purchase_order();

		echo json_encode($data);
	}

	public function getAllPurchaseOrderByDate()
	{
		$this->load->model('ModelPurchasing');
		$userid = $this->session->userdata('userid');
		$level = $this->session->userdata('level');
		$date = $this->input->get('date') ?? null;
		$company = $this->input->get('company') ?? null;

		if ($level == 7 || $level == 20 || $level == 21 || $level == 9 || $level == 4 || $level == 24 || $level == 22) {
			$data = $this->ModelPurchasing->get_all_purchase_order_by_date($date, $company);
		} else {
			$data = $this->ModelPurchasing->get_all_purchase_order_by_date_user($date, $userid);
		}
		echo json_encode($data);
	}

	public function getAllPurchaseOrderByDateApproval()
	{
		$this->load->model('ModelPurchasing');
		$userid = $this->session->userdata('userid');
		$level = $this->session->userdata('level');
		$date = $this->input->get('date') ?? date('Y-m-d');
		$company = $this->input->get('company');
		$data = $this->ModelPurchasing->get_all_purchase_order_by_date_approval($date, $userid);
		echo json_encode($data);
	}

	public function getAllPurchaseOrderByUser()
	{
		$this->load->model('ModelPurchasing');

		// Ambil tanggal dari request (GET/POST), default hari ini
		$date = $this->input->get('date') ?? date('Y-m-d');
		$user = $this->session->userdata('userid');

		$data = $this->ModelPurchasing->get_all_purchase_order_by_date($date, $user);

		echo json_encode($data);
	}

	public function getPurchaseOrderById($id)
	{
		$this->load->model('ModelPurchasing');
		$data = $this->ModelPurchasing->get_purchase_order_by_id($id);

		// Kembalikan JSON
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function getDeliveryOrderById($id)
	{
		$this->load->model('ModelPurchasing');
		$data = $this->ModelPurchasing->get_delivery_order_by_id($id);

		// Kembalikan JSON
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function getPurchaseRequestById($id)
	{
		$this->load->model('ModelPurchasing');
		$data = $this->ModelPurchasing->get_purchase_request_by_id($id);

		// Kembalikan JSON
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	// public function saveDeliveryOrder()
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$post = $this->input->post();

	// 	$userid = $this->session->userdata('userid');

	// 	$purchaseOrderId = $post['purchaseorderid'] ?? 0;
	// 	$poAdditionalNotes = $post['po_additional_notes'] ?? '';

	// 	if(!$purchaseOrderId){
	// 		echo json_encode(['status' => false, 'message' => 'Purchase Order ID tidak valid']);
	// 		return;
	// 	}

	// 	$prData = $db_oriskin->select('r.companyid,c.companycode,do.createdat')
	// 		->from('delivery_orders do')
	// 		->join('purchase_order o', 'o.id = do.purchaseorderid', 'left')
	// 		->join('purchase_request r', 'r.id = o.purchaserequestid', 'left')
	// 		->join('mscompany c', 'c.id = r.companyid', 'left')
	// 		->where('do.purchaseorderid', $purchaseOrderId)
	// 		->get()
	// 		->row_array();

	// 	$companyCode = isset($prData['companycode']) ? str_replace(' ', '', $prData['companycode']):

	// 	$total = $db_oriskin
	// 			->from('delivery_orders')
	// 			->count_all_results();
	// 	$total += 1; // tambah 1 untuk nomor PO berikutnya
	// 	$totalFormatted =  str_pad($total, 6, "0", STR_PAD_LEFT);
	// 	$month = date('m', strtotime($prData['createdat']));
	// 	$year = date('Y', strtotime($prData['createdat']));
	// 	$monthRomawi = $this->bulanRomawi($month);
	// 	$delivery_number = $totalFormatted."/".$companyCode."/DO/EDR-".$monthRomawi."-".$year;

	// 	// Update PO notes tambahan
	// 	$db_oriskin->where('id', $purchaseOrderId);
	// 	$db_oriskin->update('delivery_orders', [
	// 		'notes' => $poAdditionalNotes,
	// 		'delivery_number' => $delivery_number,
	// 		'delivery_date' => date('Y-m-d'),
	// 		'delivery_time' => date('H:i:s'),
	// 		'updatedat'=> date('Y-m-d H:i:s'),
	// 		'updatedby'=> $userid
	// 	]);

	// 	$allItemsCompleted = true;

	// 	if(!empty($post['items'])){
	// 		foreach($post['items'] as $item){
	// 			$itemId = $item['ingredientsid'] ?? 0;
	// 			$checked = isset($item['checked']) ? 1 : 0;
	// 			$notes = $item['notes'] ?? '';
	// 			$doItemId = $item['doitemid'] ?? '';

	// 			if($checked && $itemId){
	// 				// Update item notes + status = 1
	// 				$db_oriskin->where('id', $doItemId);
	// 				$db_oriskin->update('delivery_order_items', [
	// 					'notes' => $notes,
	// 					'status' => 1
	// 				]);
	// 			} else {
	// 				$allItemsCompleted = false;
	// 			}
	// 		}
	// 	} else {
	// 		$allItemsCompleted = false;
	// 	}

	// 	// Jika semua item sudah completed, ubah status delivery_order
	// 	if($allItemsCompleted){
	// 		$db_oriskin->where('id', $purchaseOrderId);
	// 		$db_oriskin->update('delivery_orders', ['status' => 1]);
	// 	}

	// 	echo json_encode([
	// 		'status' => true,
	// 		'message' => 'Data berhasil disimpan',
	// 		'allItemsCompleted' => $allItemsCompleted
	// 	]);
	// }

	public function saveDeliveryOrder()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$post = $this->input->post();
		$userid = $this->session->userdata('userid');
		$purchaseOrderId = $post['purchaseorderid'] ?? 0;
		$poAdditionalNotes = $post['po_additional_notes'] ?? '';

		if (!$purchaseOrderId) {
			echo json_encode(['status' => false, 'message' => 'Purchase Order ID tidak valid']);
			return;
		}

		// === CEK APAKAH PURCHASEORDERID SUDAH ADA DI DELIVERY_ORDERS ===
		$existingDO = $db_oriskin
			->from('delivery_orders')
			->where('purchaseorderid', $purchaseOrderId)
			->get()
			->row_array();

		if ($existingDO) {
			echo json_encode([
				'status' => false,
				'message' => 'Delivery Order untuk Purchase Order ini sudah ada',
				'delivery_number' => $existingDO['delivery_number'] ?? ''
			]);
			return;
		}

		// Ambil data PR dan company
		$prData = $db_oriskin->select('r.companyid,c.companycode,do.createdat')
			->from('delivery_orders do')
			->join('purchase_order o', 'o.id = do.purchaseorderid', 'left')
			->join('purchase_request r', 'r.id = o.purchaserequestid', 'left')
			->join('mscompany c', 'c.id = r.companyid', 'left')
			->where('do.purchaseorderid', $purchaseOrderId)
			->get()
			->row_array();

		$companyCode = isset($prData['companycode']) ? str_replace(' ', '', $prData['companycode']) : '';
		$total = $db_oriskin->from('delivery_orders')->count_all_results();
		$total += 1; // tambah 1 untuk nomor DO berikutnya 
		$totalFormatted = str_pad($total, 6, "0", STR_PAD_LEFT);
		$month = date('m', strtotime($prData['createdat']));
		$year = date('Y', strtotime($prData['createdat']));
		$monthRomawi = $this->bulanRomawi($month);
		$delivery_number = $totalFormatted . "/" . $companyCode . "/DO/EDR-" . $monthRomawi . "-" . $year;

		// Simpan / update delivery_orders
		$db_oriskin->where('id', $purchaseOrderId);
		$db_oriskin->update('delivery_orders', [
			'notes' => $poAdditionalNotes,
			'delivery_number' => $delivery_number,
			'delivery_date' => date('Y-m-d'),
			'delivery_time' => date('H:i:s'),
			'updatedat' => date('Y-m-d H:i:s'),
			'updatedby' => $userid
		]);

		$allItemsCompleted = true;

		if (!empty($post['items'])) {
			foreach ($post['items'] as $item) {
				$itemId = $item['ingredientsid'] ?? 0;
				$checked = isset($item['checked']) ? 1 : 0;
				$notes = $item['notes'] ?? '';
				$doItemId = $item['doitemid'] ?? '';

				if ($checked && $itemId) {
					// Update item notes + status = 1 
					$db_oriskin->where('id', $doItemId);
					$db_oriskin->update('delivery_order_items', [
						'notes' => $notes,
						'status' => 1
					]);
				} else {
					$allItemsCompleted = false;
				}
			}
		} else {
			$allItemsCompleted = false;
		}

		// Jika semua item sudah completed, ubah status delivery_order 
		if ($allItemsCompleted) {
			$db_oriskin->where('id', $purchaseOrderId);
			$db_oriskin->update('delivery_orders', ['status' => 1]);
		}

		echo json_encode([
			'status' => true,
			'message' => 'Data berhasil disimpan',
			'allItemsCompleted' => $allItemsCompleted
		]);
	}


	public function getAlternativeUnit($itemId)
	{
		$db_oriskin = $this->load->database('oriskin', true);

		// Ambil default unit dari ingredient
		$ingredient = $db_oriskin->select('i.id, i.unitid, i.qty, u.name as unit_name')
			->from('msingredients i')
			->join('msunitingredients u', 'u.id = i.unitid', 'left')
			->where('i.id', $itemId)
			->get()
			->row();

		$result = [];

		if ($ingredient) {
			$result[] = [
				'id' => 0, // default unit tidak punya alt_id
				'unitid' => $ingredient->unitid,
				'unit_name' => $ingredient->unit_name,
				'quantity' => $ingredient->qty ?: 1,
				'is_default' => true
			];
		}

		// Ambil alternatif unit
		$alternatives = $db_oriskin->select('a.id as alt_id, a.unitid, a.qtytouom, u.name as unit_name')
			->from('alternativeunitingredient a')
			->join('msunitingredients u', 'u.id = a.unitid', 'left')
			->where('a.ingredientid', $itemId)
			->get()
			->result();

		foreach ($alternatives as $alt) {
			$result[] = [
				'id' => $alt->alt_id, // pakai alt_id sebagai identitas unik
				'unitid' => $alt->unitid,
				'unit_name' => $alt->unit_name,
				'quantity' => $alt->qtytouom,
				'is_default' => false
			];
		}

		// Return JSON
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	public function magic_login()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$token = $this->input->get('token', TRUE);
		$redirect = $this->input->get('redirect', TRUE);

		$user_token = $db_oriskin->where('magic_token', $token)
			->get('user_token')
			->row_array();

		$user = $db_oriskin->where('id', $user_token['userid'])
			->get('msuser')
			->row_array();

		if (!$user) {
			echo "Token tidak valid";
			echo $db_oriskin->last_query();
			exit;
		}

		$this->session->set_userdata([
			'userid' => $user['id'],
			'name' => $user['name'],
			'locationid' => $user['locationid'],
			'level' => $user['level'],
			'is_login' => true
		]);

		// redirect ke halaman tujuan
		if ($redirect) {
			redirect($redirect);
		} else {
			redirect('purchaseOrderApproval');
		}
	}



	// public function getPurchaseRequestById($id) 
	// {
	// 	$this->load->model('ModelPurchasing');
	// 	$data = $this->ModelPurchasing->get_purchase_request_by_id($id);

	// 	// Kembalikan JSON
	// 	$this->output
	// 		->set_content_type('application/json')
	// 		->set_output(json_encode($data));
	// }

	// public function updatePurchaseRequest()
	// {
	// 	$this->load->model('ModelPurchasing');
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$userid = $this->session->userdata('userid');

	// 	$json = $this->input->raw_input_stream;
	// 	$data = json_decode($json, true);

	// 	if (!$data) {
	// 		echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
	// 		return;
	// 	}

	// 	$db_oriskin->trans_begin();

	// 	try {
	// 		// Update data utama purchase_request
	// 		$requestData = [
	// 			'requestdate' => $data['requestdate'],
	// 			'requesterid' => $data['requesterid'],
	// 			'warehouseid' => $data['warehouseid'],
	// 			'companyid'   => $data['companyid'],
	// 			'notes'       => $data['notes'],
	// 			'updated_at'  => date('Y-m-d H:i:s'),
	// 			'status'	=> 1,
	// 			'updated_by'  => $userid,
	// 		]; 

	// 		$this->ModelPurchasing->updatePurchaseRequest($data['id'], $requestData);

	// 		// Loop item
	// 		foreach ($data['items'] as $item) {
	// 			$itemData = [
	// 				'itemid'     	=> $item['itemid'],
	// 				'quantity'        	=> $item['qty'],
	// 				'description'	=> $item['description']
	// 			];

	// 			if (isset($item['pri_id']) && !empty($item['pri_id'])) {
	// 				// Update item
	// 				$update = $this->ModelPurchasing->updatePurchaseRequestItem($item['pri_id'], $itemData);
	// 				if (!$update) {
	// 					$db_oriskin->trans_rollback();
	// 					echo json_encode(['status' => 'error', 'message' => 'Update item gagal']);
	// 					return;
	// 				}
	// 			} else {
	// 				// Insert item baru
	// 				$itemData['purchase_request_id'] = $data['id']; 
	// 				$insert = $this->ModelPurchasing->insertPurchaseRequestItem($itemData);
	// 				if (!$insert) {
	// 					$db_oriskin->trans_rollback();
	// 					echo json_encode(['status' => 'error', 'message' => 'Insert item gagal']);
	// 					return;
	// 				}
	// 			}
	// 		}

	// 		if ($db_oriskin->trans_status() === FALSE) {
	// 			$db_oriskin->trans_rollback();
	// 			echo json_encode(['status' => 'error', 'message' => 'Transaction failed']);
	// 		} else {
	// 			$db_oriskin->trans_commit();
	// 			echo json_encode(['status' => 'success', 'message' => 'Purchase request updated successfully']);
	// 		}
	// 	} catch (Exception $e) {
	// 		$db_oriskin->trans_rollback();
	// 		log_message('error', 'Exception updatePurchaseRequest: ' . $e->getMessage());
	// 		echo json_encode(['status' => 'error', 'message' => 'Exception: ' . $e->getMessage()]);
	// 	}
	// }
	// public function updatePurchaseRequest()
	// {
	// 	$this->load->model('ModelPurchasing');
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$userid = $this->session->userdata('userid');
	// 	$level = $this->session->userdata('level');

	// 	$json = $this->input->raw_input_stream;
	// 	$data = json_decode($json, true);

	// 	$this->output->set_content_type('application/json');

	// 	if (!$data) {
	// 		echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
	// 		return;
	// 	}

	// 	$db_oriskin->trans_begin();

	// 	try {
	// 		// Data utama purchase_request (header)
	// 		$requestData = [
	// 			'requestdate'      => $data['requestdate'],
	// 			'requesterid'      => $data['requesterid'],
	// 			'warehouseid'      => $data['warehouseid'],
	// 			'companyid'        => $data['companyid'],
	// 			'notes'            => $data['notes'],
	// 			'updatedat'       => date('Y-m-d H:i:s'),
	// 			'status'           => 1,
	// 			'updatedby'       => $userid,
	// 		]; 

	// 		$updateHeader = $this->ModelPurchasing->updatePurchaseRequest($data['id'], $requestData);
	// 		if (!$updateHeader) {
	// 			$db_oriskin->trans_rollback();
	// 			echo json_encode(['status' => 'error', 'message' => 'Update header gagal']);
	// 			return;
	// 		}

	// 		// Loop items
	// 		foreach ($data['items'] as $item) {
	// 			$itemData = [
	// 				'itemid'      => $item['itemid'],
	// 				'quantity'    => $item['qty'],
	// 				'description' => $item['description']
	// 			];

	// 			if (!empty($item['pri_id'])) {
	// 				// Update item
	// 				$update = $this->ModelPurchasing->updatePurchaseRequestItem($item['pri_id'], $itemData);
	// 				if (!$update) {
	// 					$db_oriskin->trans_rollback();
	// 					echo json_encode(['status' => 'error', 'message' => 'Update item gagal']);
	// 					return;
	// 				}
	// 			} else {
	// 				// Insert item baru
	// 				$itemData['purchase_request_id'] = $data['id']; 
	// 				$insert = $this->ModelPurchasing->insertPurchaseRequestItem($itemData);
	// 				if (!$insert) {
	// 					$db_oriskin->trans_rollback();
	// 					echo json_encode(['status' => 'error', 'message' => 'Insert item gagal']);
	// 					return;
	// 				}
	// 			}
	// 		}

	// 		if ($db_oriskin->trans_status() === FALSE) {
	// 			$db_oriskin->trans_rollback();
	// 			echo json_encode([
	// 				'status' => 'error', 
	// 				'message' => 'Transaction failed'
	// 			]);
	// 		} else {
	// 			$db_oriskin->trans_commit();
	// 			if (!in_array($level, [23, 7])) {
	// 				$response = [
	// 					'status'  => 'success',
	// 					'message' => 'Berhasil menambahkan purchase request',
	// 					'redirect'=>"https://sys.eudoraclinic.com:84/app/purchaseRequestLists"
	// 				];
	// 			}else{
	// 				$response = [
	// 					'status'  => 'success',
	// 					'message' => 'Berhasil menambahkan purchase request',
	// 					'redirect'=>"https://sys.eudoraclinic.com:84/app/purchaseRequestList"
	// 				];
	// 			}
	// 		}
	// 	} catch (Exception $e) {
	// 		$db_oriskin->trans_rollback();
	// 		log_message('error', 'Exception updatePurchaseRequest: ' . $e->getMessage());
	// 		echo json_encode(['status' => 'error', 'message' => 'Exception: ' . $e->getMessage()]);
	// 	}
	// }

	public function updatePurchaseRequest()
	{
		$this->load->model('ModelPurchasing');
		$db_oriskin = $this->load->database('oriskin', true);
		$userid = $this->session->userdata('userid');
		$level = $this->session->userdata('level');

		$json = $this->input->raw_input_stream;
		$data = json_decode($json, true);

		$this->output->set_content_type('application/json');

		// Validasi JSON
		if (!$data) {
			$this->output->set_output(json_encode([
				'status' => 'error',
				'message' => 'Invalid JSON data'
			]));
			return;
		}

		// Validasi field wajib
		$requiredFields = ['id', 'requestdate', 'requesterid', 'warehouseid', 'companyid', 'items'];
		foreach ($requiredFields as $field) {
			if (!isset($data[$field]) || $data[$field] === '') {
				$this->output->set_output(json_encode([
					'status' => 'error',
					'message' => "Missing required field: $field"
				]));
				return;
			}
		}

		$db_oriskin->trans_begin();

		try {
			// --- Update Header Purchase Request ---
			$requestData = [
				'requestdate' => $data['requestdate'],
				'requesterid' => $data['requesterid'],
				'warehouseid' => $data['warehouseid'],
				'companyid' => $data['companyid'],
				'notes' => $data['notes'],
				'updatedat' => date('Y-m-d H:i:s'),
				'status' => 1,
				'updatedby' => $userid,
			];

			$updateHeader = $this->ModelPurchasing->updatePurchaseRequest($data['id'], $requestData);
			if (!$updateHeader) {
				$db_oriskin->trans_rollback();
				$this->output->set_output(json_encode([
					'status' => 'error',
					'message' => 'Update header gagal'
				]));
				return;
			}

			// --- Loop Update/Insert Items ---
			foreach ($data['items'] as $item) {
				if (empty($item['itemid']) || empty($item['qty'])) {
					$db_oriskin->trans_rollback();
					$this->output->set_output(json_encode([
						'status' => 'error',
						'message' => 'Item tidak valid'
					]));
					return;
				}

				// pastikan alternativeunitid dikonversi ke NULL jika kosong
				$alternativeunitid = isset($item['alternativeunitid']) && $item['alternativeunitid'] !== ''
					? $item['alternativeunitid']
					: null;

				$itemData = [
					'itemid' => $item['itemid'],
					'quantity' => $item['qty'],
					'description' => $item['description'] ?? '',
					'alternativeunitid' => $alternativeunitid
				];

				if (!empty($item['pri_id'])) {
					// Update item
					$update = $this->ModelPurchasing->updatePurchaseRequestItem($item['pri_id'], $itemData);
					if (!$update) {
						$db_oriskin->trans_rollback();
						$this->output->set_output(json_encode([
							'status' => 'error',
							'message' => 'Update item gagal pada pri_id: ' . $item['pri_id']
						]));
						return;
					}
				} else {
					// Insert item baru
					$itemData['purchase_request_id'] = $data['id'];
					$insert = $this->ModelPurchasing->insertPurchaseRequestItem($itemData);
					if (!$insert) {
						$db_oriskin->trans_rollback();
						$this->output->set_output(json_encode([
							'status' => 'error',
							'message' => 'Insert item gagal'
						]));
						return;
					}
				}
			}

			// --- Commit Transaction ---
			if ($db_oriskin->trans_status() === FALSE) {
				$db_oriskin->trans_rollback();
				$this->output->set_output(json_encode([
					'status' => 'error',
					'message' => 'Transaction failed'
				]));
			} else {
				$db_oriskin->trans_commit();

				$redirectUrl = (!in_array($level, [23, 7]))
					? "https://sys.eudoraclinic.com:84/app/purchaseRequestLists"
					: "https://sys.eudoraclinic.com:84/app/purchaseRequestList";

				$this->output->set_output(json_encode([
					'status' => 'success',
					'message' => 'Berhasil memperbarui purchase request',
					'redirect' => $redirectUrl
				]));
			}
		} catch (Exception $e) {
			$db_oriskin->trans_rollback();
			log_message('error', 'Exception updatePurchaseRequest: ' . $e->getMessage());
			$this->output->set_output(json_encode([
				'status' => 'error',
				'message' => 'Exception: ' . $e->getMessage()
			]));
		}
	}



	public function deletePurchaseRequestItem($pri_id)
	{
		$this->load->model('ModelPurchasing');
		$db_oriskin = $this->load->database('oriskin', true);

		$this->output->set_content_type('application/json');

		if (empty($pri_id)) {
			echo json_encode(['status' => 'error', 'message' => 'ID item tidak ditemukan']);
			return;
		}

		$db_oriskin->trans_begin();

		try {
			$delete = $this->ModelPurchasing->deletePurchaseRequestItem($pri_id);

			if (!$delete) {
				$db_oriskin->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus item']);
				return;
			}

			$db_oriskin->trans_commit();
			echo json_encode(['status' => 'success', 'message' => 'Item berhasil dihapus']);
		} catch (Exception $e) {
			$db_oriskin->trans_rollback();
			log_message('error', 'Exception deletePurchaseRequestItem: ' . $e->getMessage());
			echo json_encode(['status' => 'error', 'message' => 'Exception: ' . $e->getMessage()]);
		}
	}


	public function generatePurchaseRequestPDF($id)
	{
		ob_start();

		$this->load->model('ModelPurchasing');
		$this->load->library('Ltcpdf');

		$data['purchase_request'] = $this->ModelPurchasing->get_purchase_request_by_id($id);

		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Eudora Clinic');
		$pdf->SetMargins(15, 20, 15);
		$pdf->SetAutoPageBreak(TRUE, 15);

		// Hilangkan garis header
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false); // optional, jika ingin hilangkan footer juga

		$pdf->AddPage();

		$html = $this->load->view('content/Purchasing/pdfPurchaseRequest', $data, true);

		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->Output('PurchaseRequest_' . $id . '.pdf', 'I');
	}

	public function generateDeliveryOrderPDF($id)
	{
		ob_start();

		$this->load->model('ModelPurchasing');
		$this->load->library('Ltcpdf');

		$data['purchase_order'] = $this->ModelPurchasing->get_delivery_order_by_id($id);

		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Eudora Clinic');
		$pdf->SetMargins(15, 20, 15);
		$pdf->SetAutoPageBreak(TRUE, 15);

		// Hilangkan garis header
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false); // optional, jika ingin hilangkan footer juga

		$pdf->AddPage();

		$html = $this->load->view('content/Purchasing/deliveryOrderPdf', $data, true);

		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->Output('DeliveryOrder_' . $id . '.pdf', 'I');
	}

	public function generateDeliveryOrderByPOPDF($id)
	{
		ob_start();

		$this->load->model('ModelPurchasing');
		$this->load->library('Ltcpdf');

		$data['purchase_order'] = $this->ModelPurchasing->get_delivery_order_by_poid($id);

		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Eudora Clinic');
		$pdf->SetMargins(15, 20, 15);
		$pdf->SetAutoPageBreak(TRUE, 15);

		// Hilangkan garis header
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false); // optional, jika ingin hilangkan footer juga

		$pdf->AddPage();

		$html = $this->load->view('content/Purchasing/deliveryOrderPdf', $data, true);

		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->Output('DeliveryOrder_' . $id . '.pdf', 'I');
	}


	public function get_department_list()
	{
		$this->load->model('ModelPurchasing');
		$departments = $this->ModelPurchasing->get_all_department();
		echo json_encode(['data' => $departments]);
	}

	public function insert_department()
	{
		$this->load->model('ModelPurchasing');
		$userid = $this->session->userdata('userid');

		$data = [
			'department_name' => $this->input->post('department_name'),
			'department_code' => $this->input->post('department_code'),
			'isactive' => 1,
			'created_by' => $userid,
			'created_at' => date('Y-m-d H:i:s')
		];

		$insert = $this->ModelPurchasing->insert_department($data);

		if ($insert) {
			echo json_encode(['status' => 'success']);
		} else {
			// ambil error dari database
			$db_error = $this->db->error();
			// log error ke application/logs/
			log_message('error', 'Insert Department failed: ' . print_r($db_error, true));

			echo json_encode([
				'status' => 'error',
				'message' => $db_error['message'],
				'code' => $db_error['code']
			]);
		}
	}

	// public function approvePurchaseRequest($id)
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$userid = $this->session->userdata('userid');

	// 	 if (!$id) {
	// 		echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
	// 		return;
	// 	}

	// 	$db_oriskin->trans_begin();
	// 	$original = $db_oriskin->get_where('purchase_request', ['id' => $id])->row_array();
	// 	if (!$original) {
	// 		echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
	// 		return;
	// 	}

	// 	$companyData = $db_oriskin->select('companycode')
	// 		->from('mscompany')
	// 		->where('id', $original['companyid'])
	// 		->get()
	// 		->row_array();

	// 	$companyCode = isset($companyData['companycode']) ? str_replace(' ', '', $companyData['companycode']) : 'COMPANY';
	// 	$month = date('m', strtotime($original['requestdate']));
	// 	$year = date('Y', strtotime($original['requestdate']));
	// 	$monthRomawi = $this->bulanRomawi($month);
	// 	$total = $db_oriskin->count_all_results('purchase_request') + 1;
	// 	$totalFormatted = str_pad($total, 6, '0', STR_PAD_LEFT);

	// 	$requestcode = $totalFormatted . "/" . $companyCode . "/PR/EDR-" . $monthRomawi . "-" . $year;

	// 	$db_oriskin->where('id', $id)->update('purchase_request', [
	// 		'status'       => 2,
	// 		'approved_by'  => $userid ?? null,
	// 		'approved_at'  => date('Y-m-d H:i:s')
	// 	]);

	// 	$data_pr = [
	// 		'createdby'     => $userid,
	// 		'requestdate'   => date('Y-m-d'),
	// 		'requesterid'   => $userid,
	// 		'warehouseid'   => $original['warehouseid'],
	// 		'companyid'     => 15,
	// 		'departmentid'  => $original['departmentid'] ?? null,
	// 		'status'        => 1,
	// 		'notes'         => ($original['notes'] ?? '') . ' | Reference from ' . ($original['requestnumber'] ?? ''),
	// 		'requestnumber' => $requestcode,
	// 		'createdat'    => date('Y-m-d H:i:s'),
	// 		'createdby'    => $userid
	// 	];

	// 	$insertPR = $db_oriskin->insert('purchase_request', $data_pr);
	// 	if (!$insertPR) {
	// 		$error = $db_oriskin->error();
	// 		$db_oriskin->trans_rollback();
	// 		echo json_encode(['status' => 'error', 'message' => 'Gagal duplikasi PR', 'error' => $error]);
	// 		return;
	// 	}

	// 	$newPRid = $db_oriskin->insert_id();

	// 	$items = $db_oriskin->get_where('purchase_request_items', ['purchase_request_id' => $id])->result_array();
	// 	foreach ($items as $item) {
	// 		unset($item['id'], $item['purchase_request_id'], $item['status'], $item['created_by']);
	// 		$item['purchase_request_id'] = $newPRid;
	// 		$item['status'] = 0;
	// 		$item['created_by'] = $userid;
	// 		$db_oriskin->insert('purchase_request_items', $item);
	// 	}

	// 	if ($db_oriskin->trans_status() === FALSE) {
	// 		$db_oriskin->trans_rollback();
	// 		echo json_encode(['status' => 'error', 'message' => 'Gagal approve dan duplikasi PR']);
	// 	} else {
	// 		$db_oriskin->trans_commit();

	// 		echo json_encode([
	// 			'status'  => 'success',
	// 			'message' => 'Berhasil approve dan buat PR baru',
	// 			'new_pr_id' => $newPRid,
	// 			'new_requestnumber' => $requestcode
	// 		]);
	// 	}
	// }

	public function approvePurchaseRequest($id)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$userid = $this->session->userdata('userid');

		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
			return;
		}

		$db_oriskin->trans_begin();
		$original = $db_oriskin->get_where('purchase_request', ['id' => $id])->row_array();
		if (!$original) {
			echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
			return;
		}
		$db_oriskin->where('id', $id)->update('purchase_request', [
			'status' => 2,
			'approved_by' => $userid ?? null,
			'approved_at' => date('Y-m-d H:i:s')
		]);
		if (($original['companyid'] ?? 0) != 15) {

			$companyData = $db_oriskin->select('companycode')
				->from('mscompany')
				->where('id', $original['companyid'])
				->get()
				->row_array();

			$companyCode = isset($companyData['companycode']) ? str_replace(' ', '', $companyData['companycode']) : 'COMPANY';
			$month = date('m', strtotime($original['requestdate']));
			$year = date('Y', strtotime($original['requestdate']));
			$monthRomawi = $this->bulanRomawi($month);
			$total = $db_oriskin->count_all_results('purchase_request') + 1;
			$totalFormatted = str_pad($total, 6, '0', STR_PAD_LEFT);

			$requestcode = $totalFormatted . "/" . $companyCode . "/PR/EDR-" . $monthRomawi . "-" . $year;

			$data_pr = [
				'createdby' => $userid,
				'requestdate' => date('Y-m-d'),
				'requesterid' => $userid,
				'warehouseid' => $original['warehouseid'],
				'companyid' => 15,
				'departmentid' => $original['departmentid'] ?? null,
				'status' => 1,
				'notes' => ($original['notes'] ?? '') . ' | Reference from ' . ($original['requestnumber'] ?? ''),
				'requestnumber' => $requestcode,
				'createdat' => date('Y-m-d H:i:s'),
			];

			$insertPR = $db_oriskin->insert('purchase_request', $data_pr);
			if (!$insertPR) {
				$error = $db_oriskin->error();
				$db_oriskin->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Gagal duplikasi PR', 'error' => $error]);
				return;
			}

			$newPRid = $db_oriskin->insert_id();

			$items = $db_oriskin->get_where('purchase_request_items', ['purchase_request_id' => $id])->result_array();
			foreach ($items as $item) {
				unset($item['id'], $item['purchase_request_id'], $item['status'], $item['created_by']);
				$item['purchase_request_id'] = $newPRid;
				$item['status'] = 0;
				$item['created_by'] = $userid;
				$db_oriskin->insert('purchase_request_items', $item);
			}

			$response = [
				'status' => 'success',
				'message' => 'Berhasil approve dan buat PR baru',
				'new_pr_id' => $newPRid,
				'new_requestnumber' => $requestcode
			];
		} else {
			$response = [
				'status' => 'success',
				'message' => 'Berhasil approve purchase request'
			];
		}

		if ($db_oriskin->trans_status() === FALSE) {
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Gagal approve PR']);
		} else {
			$db_oriskin->trans_commit();
			echo json_encode($response);
		}
	}

	public function generatePurchaseOrderPDF($id)
	{
		ob_start();

		$this->load->model('ModelPurchasing');
		$this->load->library('Ltcpdf');

		$data['purchase_order'] = $this->ModelPurchasing->get_purchase_order_by_id($id);
		$status = $data['purchase_order']['status'];
		$companyid = $data['purchase_order']['companyid'];
		$db_oriskin = $this->load->database('oriskin', true);
		$totalItems = $db_oriskin->select_sum('total_price')
			->where('purchaseorderid', $id)
			->get('purchase_order_items')
			->row()
			->total_price ?? 0;

		if (
			in_array($status, [6, 10, 11, 2, 3]) &&
			(
				$companyid == 15 &&
				$totalItems >= 5000000
			)
		) {
			$data['ttd2'] = "ttd_buk_sabrina.jpg";
			$data['ttd1'] = "ttd_desi.jpg";
			$data['tes'] = "2";
		} else if (
			in_array($status, [4, 6, 10, 11, 7, 2, 3]) &&
			(
				$companyid != 15 &&
				$totalItems <= 5000000
			)
		) {
			$data['ttd1'] = "ttd_desi.jpg";
			$data['tes'] = "1";
		} else {
			$data['tes'] = "2";
			$data['ttd1'] = "ttd_desi.jpg";
		}


		$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Eudora Clinic');
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetAutoPageBreak(TRUE, 15);

		// Matikan header (garis di atas)
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false); // jika ingin juga menghilangkan footer

		$pdf->AddPage();

		$html = $this->load->view('content/Purchasing/pdfPurchaseOrder', $data, true);

		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->Output('PurchaseRequest_' . $id . '.pdf', 'I');

		ob_end_flush(); // kirim buffer
	}

	public function grouppedPurchaseOrder()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$po_ids = $this->input->post('po_ids'); // ambil dari ajax
		if (!is_array($po_ids)) {
			$po_ids = explode(',', $po_ids);
		}

		$response = [];

		foreach ($po_ids as $id) {
			$po = $db_oriskin->where('id', $id)->get('purchase_order')->row();

			if ($po) {
				// ambil purchase_request terkait
				$purchase_request = $db_oriskin
					->select('pr.*, e.name AS employee_name, c.companyname, w.warehouse_name')
					->from('purchase_request pr')
					->join('msemployee e', 'e.employeeid = pr.requesterid', 'left')
					->join('mscompany c', 'c.companyid = pr.companyid', 'left')
					->join('warehouse w', 'w.id = pr.warehouseid', 'left')
					->where('pr.id', $po->purchaserequestid)
					->get()
					->row();

				$db_oriskin->select('
					poi.id AS poi_id,
					pri.id AS pri_id,
					pri.quantity AS qty,
					pri.itemid,
					mi.id AS ingredient_id,
					mi.name AS itemname,
					mi.code AS item_code,
					pri.description
				');
				$db_oriskin->from('purchase_order_items poi');
				$db_oriskin->join('purchase_request_items pri', 'pri.id = poi.purchaserequestitemid', 'left');
				$db_oriskin->join('msingredients mi', 'pri.itemid = mi.id', 'left');
				$db_oriskin->where('poi.purchaseorderid', $po->id);
				$items = $db_oriskin->get()->result() ?? [];

				$response[] = [
					'poid' => $po->id,
					'status' => $po->status_pembayaran ?? '-',
					'purchase_request' => $purchase_request ? [
						'id' => $purchase_request->id,
						'requestnumber' => $purchase_request->requestnumber ?? '-',
						'request_date' => $purchase_request->requestdate ?? '-',
						'requested_by' => $purchase_request->requested_by ?? '-',
						'companyname' => $purchase_request->companyname ?? '-',
						'warehouse_name' => $purchase_request->warehouse_name ?? '-',
					] : null,
					'items' => array_map(function ($item) {
						return [
							'item_code' => $item->item_code ?? '-',
							'itemname' => $item->itemname ?? '-',
							'qty' => $item->qty ?? 0,
							'description' => $item->description ?? ''
						];
					}, $items)
				];
			}
		}

		echo json_encode($response);
	}

	public function addPurchaseOrderByRequest($id)
	{
		$db_oriskin = $this->load->database('oriskin', true);

		$this->load->model('ModelPurchasing');
		$data = $this->ModelPurchasing->add_purchase_order_by_request($id);

		// Kembalikan JSON
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));

		echo json_encode($response);
	}

	public function savePurchaseOrder()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$data = json_decode(file_get_contents('php://input'), true);
		$userid = $this->session->userdata('userid');

		$this->output->set_content_type('application/json');
		if (!$data || empty($data['items'])) {
			echo json_encode(['status' => false, 'msg' => 'Data kosong atau items belum diisi']);
			return;
		}

		$db_oriskin->trans_start();

		$prData = $db_oriskin->select('companyid')
			->from('purchase_request')
			->where('id', $data['purchaserequestid'])
			->get()
			->row_array();

		$companyId = $prData['companyid'] ?? null;

		$companyData = $db_oriskin->select('companycode')
			->from('mscompany')
			->where('id', $companyId)
			->get()
			->row_array();

		$companyCode = isset($companyData['companycode']) ? str_replace(' ', '', $companyData['companycode']) : 'COMPANY';
		$month = date('m', strtotime($data['orderdate']));
		$year = date('Y', strtotime($data['orderdate']));

		$total = $db_oriskin
			->from('purchase_order po')
			->count_all_results();

		$total += 1; // tambah 1 untuk nomor PO berikutnya
		$totalFormatted = str_pad($total, 6, "0", STR_PAD_LEFT);
		$monthRomawi = $this->bulanRomawi($month);
		$order_number = $totalFormatted . "/" . $companyCode . "/PO/EDR-" . $monthRomawi . "-" . $year;
		// Siapkan data purchase order
		$po = [
			'order_number' => $order_number ?? null,
			'orderdate' => $data['orderdate'] ?? null,
			'createdby' => $userid,
			'ordererid' => $data['ordererid'] ?? null,
			'purchaserequestid' => $data['purchaserequestid'] ?? null,
			'notes' => $data['notes'] ?? null,
			'supplierid' => $data['supplierid'],
			'status' => 0,
			'status_pembayaran' => $data['status_pembayaran'],
			'createdat' => date('Y-m-d H:i:s')
		];

		$db_oriskin->insert('purchase_order', $po);
		$poid = $db_oriskin->insert_id();

		foreach ($data['items'] as $item) {
			if (!empty($item['purchaserequestitemid'])) {
				// Cek status item
				$status = $db_oriskin->select('status')
					->where('id', $item['purchaserequestitemid'])
					->get('purchase_request_items')
					->row();

				if ($status && $status->status != 1) {
					// Insert hanya jika status != 1
					$db_oriskin->insert('purchase_order_items', [
						'purchaseorderid' => $poid,
						'purchaserequestitemid' => $item['purchaserequestitemid'],
						'fixed_price' => $item['fixed_price'],
						'total_price' => $item['total_price'],
						'discount_type' => $item['discount_type'],
						'discount_value' => $item['discount_value'],
					]);

					// Update status jadi 1
					$db_oriskin->where('id', $item['purchaserequestitemid'])
						->update('purchase_request_items', ['status' => 1]);
				}
			}
		}

		// Update status purchase request
		if (!empty($data['purchaserequestid'])) {
			$prdata = ['status' => 2];
			$this->ModelPurchasing->update_pr($data['purchaserequestid'], $prdata);
		}

		$db_oriskin->trans_complete();

		// Hasil transaksi
		if ($db_oriskin->trans_status() === FALSE) {
			echo json_encode([
				'status' => false,
				'msg' => 'Gagal menyimpan Purchase Order',
				'db_error' => $db_oriskin->error()
			]);
		} else {
			echo json_encode([
				'status' => true,
				'msg' => 'Purchase Order berhasil disimpan!',
				'po_id' => $poid
			]);
		}
		exit;
	}

	// public function savePurchaseOrder()
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$data = json_decode(file_get_contents('php://input'), true);
	// 	$userid = $this->session->userdata('userid');

	// 	$this->output->set_content_type('application/json');

	// 	Validasi data dasar
	// 	if (!$data || empty($data['items'])) {
	// 		echo json_encode(['status' => false, 'msg' => 'Data kosong atau items belum diisi']);
	// 		return;
	// 	}

	// 	====== CEK STATUS PURCHASE REQUEST ======
	// 	$purchaseRequest = $db_oriskin->select('status')
	// 		->from('purchase_request')
	// 		->where('id', $data['purchaserequestid'])
	// 		->get()
	// 		->row();

	// 	if ($purchaseRequest && $purchaseRequest->status == 3) {
	// 		echo json_encode([
	// 			'status' => false,
	// 			'msg' => 'Purchase Request ini sudah selesai (status = 2), tidak bisa membuat Purchase Order lagi'
	// 		]);
	// 		return;
	// 	}

	// 	$db_oriskin->trans_start();

	// 	=== Dapatkan companycode untuk nomor PO ===
	// 	$prData = $db_oriskin->select('companyid')
	// 		->from('purchase_request')
	// 		->where('id', $data['purchaserequestid'])
	// 		->get()
	// 		->row_array();

	// 	$companyId = $prData['companyid'] ?? null;

	// 	$companyData = $db_oriskin->select('companycode')
	// 		->from('mscompany')
	// 		->where('id', $companyId)
	// 		->get()
	// 		->row_array();

	// 	$companyCode = isset($companyData['companycode']) ? str_replace(' ', '', $companyData['companycode']) : 'COMPANY';
	// 	$month = date('m', strtotime($data['orderdate']));
	// 	$year = date('Y', strtotime($data['orderdate']));

	// 	$total = $db_oriskin->from('purchase_order po')->count_all_results();
	// 	$total += 1;
	// 	$totalFormatted = str_pad($total, 6, "0", STR_PAD_LEFT);
	// 	$monthRomawi = $this->bulanRomawi($month);
	// 	$order_number = $totalFormatted."/".$companyCode."/PO/EDR-".$monthRomawi."-".$year;

	// 	=== Simpan Purchase Order ===
	// 	$po = [
	// 		'order_number'       => $order_number,
	// 		'orderdate'          => $data['orderdate'] ?? null,
	// 		'createdby'          => $userid,
	// 		'ordererid'          => $data['ordererid'] ?? null,
	// 		'purchaserequestid'  => $data['purchaserequestid'] ?? null,
	// 		'notes'              => $data['notes'] ?? null,
	// 		'supplierid'         => $data['supplierid'],
	// 		'status'             => 0,
	// 		'status_pembayaran'  => $data['status_pembayaran'],
	// 		'createdat'          => date('Y-m-d H:i:s')
	// 	];

	// 	$db_oriskin->insert('purchase_order', $po);
	// 	$poid = $db_oriskin->insert_id();

	// 	=== Loop Items ===
	// 	foreach ($data['items'] as $item) {
	// 		if (!empty($item['purchaserequestitemid'])) {
	// 			$status = $db_oriskin->select('status')
	// 				->where('id', $item['purchaserequestitemid'])
	// 				->get('purchase_request_items')
	// 				->row();

	// 			if ($status && $status->status != 1) {
	// 				$db_oriskin->insert('purchase_order_items', [
	// 					'purchaseorderid'       => $poid,
	// 					'purchaserequestitemid' => $item['purchaserequestitemid'],
	// 					'fixed_price'           => $item['fixed_price'],
	// 					'total_price'           => $item['total_price'],
	// 				]);

	// 				$db_oriskin->where('id', $item['purchaserequestitemid'])
	// 					->update('purchase_request_items', ['status' => 1]);
	// 			}
	// 		}
	// 	}

	// 	=== Cek apakah semua item dari purchase_request sudah status 1 ===
	// 	$remaining = $db_oriskin->from('purchase_request_items')
	// 		->where('purchaserequestid', $data['purchaserequestid'])
	// 		->where('status !=', 1)
	// 		->count_all_results();

	// 	if ($remaining == 0) {
	// 		Semua item sudah status 1 → update purchase_request jadi status 2
	// 		$db_oriskin->where('id', $data['purchaserequestid'])
	// 			->update('purchase_request', ['status' => 3]);
	// 	}

	// 	$db_oriskin->trans_complete();

	// 	Hasil transaksi
	// 	if ($db_oriskin->trans_status() === FALSE) {
	// 		echo json_encode([
	// 			'status' => false,
	// 			'msg' => 'Gagal menyimpan Purchase Order',
	// 			'db_error' => $db_oriskin->error()
	// 		]);
	// 	} else {
	// 		echo json_encode([
	// 			'status' => true,
	// 			'msg' => 'Purchase Order berhasil disimpan!',
	// 			'po_id' => $poid
	// 		]);
	// 	}
	// 	exit;
	// }

	// public function rejectPurchaseRequest()
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$data = json_decode(file_get_contents('php://input'), true);
	// 	$userid = $this->session->userdata('userid');

	// 	$this->output->set_content_type('application/json');

	// 	$rjct = [
	// 		'purchasing_notes'  => $data['purchasingnotes'] ?? null,
	// 		'updatedby'         => $userid,
	// 		'updatedat'         => date('Y-m-d H:i:s'),
	// 		'status'			=> 5
	// 	];

	// 	// Update status purchase request
	// 	$insert= $this->ModelPurchasing->update_pr($data['purchaserequestid'], $rjct);

	// 	if (!$insert) {
	// 		echo json_encode([
	// 			'status' => false,
	// 			'msg' => 'Gagal menyimpan Purchase Order',
	// 			'db_error' => $db_oriskin->error()
	// 		]);
	// 	} else {
	// 		echo json_encode([
	// 			'status' => true,
	// 			'msg' => 'Purchase Order berhasil disimpan!',
	// 		]);
	// 	}
	// }



	// public function create_bk($purchaseorderid) 
	// {
	// 	$jenis_bk   = $this->input->post('jenis_bk');
	// 	$jml_keluar = $this->input->post('jml_keluar');
	// 	$created_by = $this->session->userdata('userid');

	// 	if (!$jenis_bk) {
	// 		$this->session->set_flashdata('error', 'Jenis BK wajib dipilih');
	// 		redirect('ControllerPurchasing/detailPO/'.$purchaseorderid);
	// 	}

	// 	// Ambil data purchase order
	// 	$poData = $this->ModelPurchasing->get_purchase_order_by_id($purchaseorderid);

	// 	// Data untuk PDF
	// 	$dataView = [
	// 		'poData'         => $poData,
	// 		'jenis_bk'   => $jenis_bk,
	// 		'jml_keluar' => $jenis_bk === 'ongkir' ? $jml_keluar : $poData->total,
	// 		'created_by' => $created_by,
	// 		'tanggal'    => date('d/m/Y')
	// 	];

	// 	// Load TCPDF
	// 	$this->load->library('tcpdf/Tcpdf');
	// 	$pdf = new Tcpdf('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

	// 	$pdf->SetCreator(PDF_CREATOR);
	// 	$pdf->SetAuthor('PT. EGI');
	// 	$pdf->SetTitle('Bukti Pengeluaran Kas');
	// 	$pdf->SetMargins(10, 10, 10);
	// 	$pdf->SetAutoPageBreak(TRUE, 10);
	// 	$pdf->AddPage();

	// 	// Load view untuk di-render jadi HTML
	// 	$html = $this->load->view('content/Purchasing/generateBkPdf', $dataView, TRUE);
	// 	$pdf->writeHTML($html, true, false, true, false, '');

	// 	// Path file
	// 	$fileName = 'BK_'.$purchaseorderid.'_'.time().'.pdf';
	// 	$filePath = FCPATH.'upload/purchase_order/'.$fileName;

	// 	// Simpan file
	// 	$pdf->Output($filePath, 'F');

	// 	// Simpan ke database
	// 	$data = [
	// 		'purchaseorderid' => $purchaseorderid,
	// 		'jenis_bk'        => $jenis_bk,
	// 		'jml_keluar'      => $jenis_bk === 'ongkir' ? $jml_keluar : null,
	// 		'file_path'       => 'upload/purchase_order/'.$fileName,
	// 		'created_by'      => $created_by,
	// 		'created_at'      => date('Y-m-d H:i:s')
	// 	];

	// 	$this->ModelPurchasing->insert_bk($data);

	// 	$this->session->set_flashdata('success', 'BK berhasil dibuat & file digenerate');
	// 	redirect('ControllerPurchasing/detailPurchaseOrder/'.$purchaseorderid);
	// }

	public function create_bk($purchaseorderid)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$jenis_bk = $this->input->post('jenis_bk');
		$jml_keluar = $this->input->post('jml_keluar');
		$created_by = $this->session->userdata('userid');

		if (!$jenis_bk) {
			$this->session->set_flashdata('error', 'Jenis BK wajib dipilih');
			redirect('ControllerPurchasing/detailPO/' . $purchaseorderid);
		}

		// Ambil data purchase order
		$data['purchase_order'] = $this->ModelPurchasing->get_purchase_order_by_id($purchaseorderid);
		$data['jenis_bk'] = $jenis_bk;
		$data['jml_keluar'] = $jml_keluar;
		$grandTotal = 0;
		if (!empty($data['purchase_order']['items'])) {
			foreach ($data['purchase_order']['items'] as $item) {
				$grandTotal += (float) $item['total_price'];
			}
		}
		$data['grand_total'] = $grandTotal;
		$data['purchase_order']['other_cost'] = $other_cost;
		$data['subtotal'] = $grandTotal + (float) $jml_keluar + (float) $other_cost;

		$companyCode = $data['purchase_order']['companycode'] ?? null;

		$rowCount = $db_oriskin->count_all_results('bukti_pengeluaran_kas');
		$month = date('m');
		$year = date('Y');

		$rowCount += 1;
		$totalFormatted = str_pad($rowCount, 6, "0", STR_PAD_LEFT);
		$monthRomawi = $this->bulanRomawi($month);
		$bk_number = $totalFormatted . "/" . $companyCode . "/BK/EDR-" . $monthRomawi . "-" . $year;
		$data['no_bk'] = $bk_number;

		$this->load->library('ltcpdf');
		$pdf = new Ltcpdf('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('PT. EGI');
		$pdf->SetTitle('Bukti Pengeluaran Kas');
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetAutoPageBreak(TRUE, 10);

		// Hilangkan garis header
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false); // optional, jika ingin hilangkan footer juga
		$pdf->AddPage();



		// Load view untuk HTML PDF
		$html = $this->load->view('content/Purchasing/generateBkPdf', $data, TRUE);
		$pdf->writeHTML($html, true, false, true, false, '');

		// Path file
		$fileName = 'BK_' . $purchaseorderid . '_' . time() . '.pdf';
		$filePath = FCPATH . 'uploads/purchase_order/' . $fileName;

		// Simpan file
		$pdf->Output($filePath, 'F');

		$db_oriskin->where('id', $purchaseorderid);
		$db_oriskin->update('purchase_order', [
			'bk_attachment' => $fileName
		]);
		// Simpan ke DB
		$data = [
			'purchaseorderid' => $purchaseorderid,
			'jenis_bk' => $jenis_bk,
			'jml_keluar' => $jenis_bk === 'ongkir' ? $jml_keluar : null,
			'file_path' => 'uploads/purchase_order/' . $fileName,
			'created_by' => $created_by,
			'created_at' => date('Y-m-d H:i:s'),
			'no_bk' => $bk_number
		];
		$this->ModelPurchasing->insert_bk($data);

		$this->session->set_flashdata('success', 'BK berhasil dibuat & file digenerate');
		redirect('detailPurchaseOrder/' . $purchaseorderid);
	}

	public function create_bk_ajax($purchaseorderid)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$user_id = $this->session->userdata('userid');

		$po = $db_oriskin->get_where('purchase_order', ['id' => $purchaseorderid])->row_array();
		if (!$po) {
			echo json_encode(['status' => 'error', 'message' => 'PO tidak ditemukan']);
			return;
		}
		$data['purchase_order'] = $this->ModelPurchasing->get_purchase_order_by_id($purchaseorderid);

		$items = $db_oriskin->get_where('purchase_order_items', ['purchaseorderid' => $purchaseorderid])->result_array();
		$rowCount = $db_oriskin->count_all_results('bukti_pengeluaran_kas');
		$month = date('m');
		$year = date('Y');
		$rowCount += 1;
		$totalFormatted = str_pad($rowCount, 6, "0", STR_PAD_LEFT);
		$monthRomawi = $this->bulanRomawi($month); // buat function bulanRomawi jika belum ada
		$companyCode = $data['purchase_order']['companycode'] ?? null;
		$bk_number = $totalFormatted . "/" . $companyCode . "/BK/EDR-" . $monthRomawi . "-" . $year;
		// generate PDF dengan LTCPDF (sama seperti yang Anda punya). Pastikan library ada.
		$this->load->library('ltcpdf');
		$pdf = new Ltcpdf('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('EUDORA AESTHETIC CLINIC');
		$pdf->SetTitle('Bukti Pengeluaran Kas');
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetAutoPageBreak(TRUE, 10);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		// prepare data untuk view generateBkPdf
		$grandTotal = 0;
		if (!empty($data['purchase_order']['items'])) {
			foreach ($data['purchase_order']['items'] as $item) {
				$grandTotal += (float) $item['total_price'];
			}
		}
		$ongkir = (float) ($po['ongkir'] ?? 0);
		$other_cost = (float) ($po['other_cost'] ?? 0);
		$subtotal = $grandTotal + $ongkir + $other_cost;
		$data['grand_total'] = $grandTotal;
		$data['subtotal'] = $subtotal;
		$data['no_bk'] = $bk_number;
		$status = $data['purchase_order']['status'];
		if (!in_array($status, [0, 1, 4, 5, 7, 11])) {
			$data['ttd2'] = "ttd_buk_sabrina.jpg";
			$data['ttd1'] = "ttd_desi.jpg";
		}
		if (!in_array($status, [0, 1, 5])) {
			$data['ttd1'] = "ttd_desi.jpg";
		}

		$html = $this->load->view('content/Purchasing/generateBkPdf', $data, TRUE);
		$pdf->writeHTML($html, true, false, true, false, '');
		$fileName = 'BK_' . $purchaseorderid . '_' . time() . '.pdf';
		$filePath = FCPATH . 'uploads/purchase_order/' . $fileName;
		if (!is_dir(dirname($filePath)))
			mkdir(dirname($filePath), 0755, true);
		$pdf->Output($filePath, 'F');
		$db_oriskin->where('id', $purchaseorderid);
		$db_oriskin->update('purchase_order', [
			'bk_attachment' => $fileName,
			'status' => 7
		]);
		$insert = [
			'purchaseorderid' => $purchaseorderid,
			'jenis_bk' => 'Purchase Order',
			'jml_keluar' => $ongkir,
			'file_path' => 'uploads/purchase_order/' . $fileName,
			'created_by' => $this->session->userdata('userid') ?? null,
			'created_at' => date('Y-m-d H:i:s'),
			'no_bk' => $bk_number
		];
		$result = $db_oriskin->insert('bukti_pengeluaran_kas', $insert);

		$user = $db_oriskin->where('id', 68)->get('msuser')->row_array();
		if (!$user) {
			echo json_encode(['success' => false, 'message' => 'User tidak ditemukan']);
			return;
		}
		$token = bin2hex(random_bytes(32));
		$expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));
		$db_oriskin->insert('user_token', [
			'userid' => 68,
			'magic_token' => $token,
			'expired_time' => $expired,
			'createdby' => $user_id,
		]);

		$magic_link = base_url('magic_login?token=' . $token . '&redirect=detailPurchaseOrder/' . $purchaseorderid);

		if ($result) {
			$data = [
				"recipient_type" => "individual",
				"to" => "6583330666",
				"type" => "text",
				"text" => [
					"body" => "Halo Bu Sabrina Gouw,\n\nAda permintaan approval Purchase Order baru.\nKlik link berikut untuk melakukan approval:\n{$magic_link}"
				]
			];
			$response = $this->sendNotif($data);
			$data2 = [
				"recipient_type" => "individual",
				"to" => "628111699404",
				"type" => "text",
				"text" => [
					"body" => "Halo Bu Sabrina Gouw,\n\nAda permintaan approval Purchase Order baru.\nKlik link berikut untuk melakukan approval:\n{$magic_link}"
				]
			];
			$response2 = $this->sendNotif($data2);
			echo json_encode(['success' => true, 'message' => 'Berhasil menghasilkan BK dan mengirim approval!']);
			return;
		}
	}

	public function create_bk_ajaxs($purchaseorderid)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$user_id = $this->session->userdata('userid');

		$po = $db_oriskin->get_where('purchase_order', ['id' => $purchaseorderid])->row_array();
		if (!$po) {
			echo json_encode(['status' => 'error', 'message' => 'PO tidak ditemukan']);
			return;
		}
		$data['purchase_order'] = $this->ModelPurchasing->get_purchase_order_by_id($purchaseorderid);

		$items = $db_oriskin->get_where('purchase_order_items', ['purchaseorderid' => $purchaseorderid])->result_array();
		$rowCount = $db_oriskin->count_all_results('bukti_pengeluaran_kas');
		$month = date('m');
		$year = date('Y');
		$rowCount += 1;
		$totalFormatted = str_pad($rowCount, 6, "0", STR_PAD_LEFT);
		$monthRomawi = $this->bulanRomawi($month); // buat function bulanRomawi jika belum ada
		$companyCode = $data['purchase_order']['companycode'] ?? null;
		$bk_number = $totalFormatted . "/" . $companyCode . "/BK/EDR-" . $monthRomawi . "-" . $year;

		// generate PDF dengan LTCPDF (sama seperti yang Anda punya). Pastikan library ada.
		$this->load->library('ltcpdf');
		$pdf = new Ltcpdf('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('EUDORA AESTHETIC CLINIC');
		$pdf->SetTitle('Bukti Pengeluaran Kas');
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetAutoPageBreak(TRUE, 10);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		// prepare data untuk view generateBkPdf
		$grandTotal = 0;
		if (!empty($data['purchase_order']['items'])) {
			foreach ($data['purchase_order']['items'] as $item) {
				$grandTotal += (float) $item['total_price'];
			}
		}
		$ongkir = (float) ($po['ongkir'] ?? 0);
		$other_cost = (float) ($po['other_cost'] ?? 0);
		$subtotal = $grandTotal + $ongkir + $other_cost;
		$data['grand_total'] = $grandTotal;
		$data['subtotal'] = $subtotal;
		$data['no_bk'] = $bk_number;
		$status = $data['purchase_order']['status'];
		if (!in_array($status, [0, 1, 4, 5, 7, 11])) {
			$data['ttd2'] = "ttd_buk_sabrina.jpg";
			$data['ttd1'] = "ttd_desi.jpg";
		}
		if (!in_array($status, [0, 1, 5])) {
			$data['ttd1'] = "ttd_desi.jpg";
		}

		$html = $this->load->view('content/Purchasing/generateBkPdf', $data, TRUE);
		$pdf->writeHTML($html, true, false, true, false, '');

		$fileName = 'BK_' . $purchaseorderid . '_' . time() . '.pdf';
		$filePath = FCPATH . 'uploads/purchase_order/' . $fileName;
		if (!is_dir(dirname($filePath)))
			mkdir(dirname($filePath), 0755, true);
		$pdf->Output($filePath, 'F');
		$db_oriskin->where('id', $purchaseorderid);
		$db_oriskin->update('purchase_order', [
			'bk_attachment' => $fileName,
		]);

		$insert = [
			'purchaseorderid' => $purchaseorderid,
			'jenis_bk' => 'Purchas Order',
			'jml_keluar' => $ongkir,
			'file_path' => 'uploads/purchase_order/' . $fileName,
			'created_by' => $this->session->userdata('userid') ?? null,
			'created_at' => date('Y-m-d H:i:s'),
			'no_bk' => $bk_number
		];
		$result = $db_oriskin->insert('bukti_pengeluaran_kas', $insert);
	}

	// public function rejectPurchaseRequest()
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$data = json_decode(file_get_contents('php://input'), true);
	// 	$userid = $this->session->userdata('userid');

	// 	$this->output->set_content_type('application/json');

	// 	$rjct = [
	// 		'purchasing_notes'  => $data['purchasingnotes'] ?? null,
	// 		'updatedby'         => $userid,
	// 		'updatedat'         => date('Y-m-d H:i:s'),
	// 		'status'            => 5 
	// 	];

	// 	$update = $this->ModelPurchasing->update_pr($data['purchaserequestid'], $rjct);

	// 	if (!$update) {
	// 		echo json_encode([
	// 			'status' => false,
	// 			'msg'    => 'Gagal reject Purchase Request',
	// 			'db_error' => $db_oriskin->error()
	// 		]);
	// 	} else {
	// 		echo json_encode([
	// 			'status' => true,
	// 			'msg'    => 'Purchase Request berhasil di-reject!'
	// 		]);
	// 	}
	// 	exit;
	// }

	public function rejectPurchaseRequest()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$data = json_decode(file_get_contents('php://input'), true);
		$userid = $this->session->userdata('userid');

		$this->output->set_content_type('application/json');

		$rjct = [
			'purchasing_notes' => $data['purchasingnotes'] ?? null,
			'updatedby' => $userid,
			'updatedat' => date('Y-m-d H:i:s'),
			'status' => 5
		];

		$update = $this->ModelPurchasing->update_pr($data['purchaserequestid'], $rjct);

		if (!$update) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Gagal reject Purchase Request',
			]);
		} else {
			echo json_encode([
				'status' => 'success',
				'message' => 'Purchase Request berhasil di-reject!'
			]);
		}
		exit;
	}

	// public function saveVaInfo()
	// {
	// 	$this->output->set_content_type('application/json');
	// 	$db_oriskin = $this->load->database('oriskin', true);

	// 	$post = $this->input->post();
	// 	$id   = isset($post['id']) ? $post['id'] : null;

	// 	if (!$id) {
	// 		echo json_encode(['status' => false, 'message' => 'ID tidak valid']);
	// 		return;
	// 	}

	// 	// Ambil data PR dulu
	// 	$pr = $this->ModelPurchasing->get_purchase_order_by_id($id);
	// 	if (!$pr) {
	// 		echo json_encode(['status' => false, 'message' => 'Data Purchase order tidak ditemukan']);
	// 		return;
	// 	}
	// 	$dataVa = [
	// 		'purchaseorderid' => $id,
	// 		'ecommerce_name'  => $post['ecommerce'],
	// 		'va_number'       => $post['va_number'],
	// 		'createdat'      => date('Y-m-d H:i:s'),
	// 		'updatedat'      => date('Y-m-d H:i:s')
	// 	];

	// 	$exists = $db_oriskin->get_where('ecommerce_virtual_account', ['purchaseorderid' => $id])->row_array();

	// 	if ($exists) {
	// 		$db_oriskin->where('purchaseorderid', $id)->update('ecommerce_virtual_account', $dataVa);
	// 	} else {
	// 		$db_oriskin->insert('ecommerce_virtual_account', $data);
	// 	}

	// 	$db_oriskin = $this->load->database('oriskin', true); 
	//     $user_id = $this->session->userdata('userid');

	//     $po = $db_oriskin->get_where('purchase_order', ['id'=>$purchaseorderid])->row_array();
	//     if(!$po){
	//         echo json_encode(['status'=>'error','message'=>'PO tidak ditemukan']); return;
	//     }
	// 	$data['purchase_order'] = $this->ModelPurchasing->get_purchase_order_by_id($purchaseorderid);

	//     $items = $db_oriskin->get_where('purchase_order_items', ['purchaseorderid' => $purchaseorderid])->result_array();
	// 		$rowCount = $db_oriskin->count_all_results('bukti_pengeluaran_kas');
	// 		$month = date('m');
	// 		$year = date('Y');
	// 		$rowCount += 1;
	// 		$totalFormatted = str_pad($rowCount, 6, "0", STR_PAD_LEFT);
	// 		$monthRomawi = $this->bulanRomawi($month); // buat function bulanRomawi jika belum ada
	// 		$companyCode = $data['purchase_order']['companycode'] ?? null;
	// 		$bk_number = $totalFormatted."/".$companyCode."/BK/EDR-".$monthRomawi."-".$year;

	// 		// generate PDF dengan LTCPDF (sama seperti yang Anda punya). Pastikan library ada.
	// 		$this->load->library('ltcpdf');
	// 		$pdf = new Ltcpdf('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
	// 		$pdf->SetCreator(PDF_CREATOR);
	// 		$pdf->SetAuthor('EUDORA AESTHETIC CLINIC');
	// 		$pdf->SetTitle('Bukti Pengeluaran Kas');
	// 		$pdf->SetMargins(10, 10, 10);
	// 		$pdf->SetAutoPageBreak(TRUE, 10);
	// 		$pdf->setPrintHeader(false);
	// 		$pdf->setPrintFooter(false);
	// 		$pdf->AddPage();
	// 		// prepare data untuk view generateBkPdf
	// 		$grandTotal = 0;
	// 		if (!empty($data['purchase_order']['items'])) {
	// 			foreach ($data['purchase_order']['items'] as $item) {
	// 				$grandTotal += (float) $item['total_price'];
	// 			}
	// 		}
	// 		$ongkir = (float) ($po['ongkir'] ?? 0);
	// 		$subtotal = $grandTotal + $ongkir;
	// 		$data['grand_total'] = $grandTotal;
	// 		$data['subtotal'] = $subtotal;
	// 		$data['no_bk'] = $bk_number;
	// 		$data['no_bk'] = $bk_number;

	// 		$html = $this->load->view('content/Purchasing/generateBkPdf', $data, TRUE);
	// 		$pdf->writeHTML($html, true, false, true, false, '');

	// 		$fileName = 'BK_'.$purchaseorderid.'_'.time().'.pdf';
	// 		$filePath = FCPATH.'uploads/purchase_order/'.$fileName;
	// 		if(!is_dir(dirname($filePath))) mkdir(dirname($filePath), 0755, true);
	// 		$pdf->Output($filePath, 'F');
	// 		$db_oriskin->where('id', $purchaseorderid);
	// 		$db_oriskin->update('purchase_order', [
	// 			'bk_attachment' => $fileName,
	// 			'status' => 7
	// 		]);

	// 		$insert = [
	//         'purchaseorderid' => $purchaseorderid,
	//         'jenis_bk' => 'ongkir',
	//         'jml_keluar' => $ongkir,
	//         'file_path' => 'uploads/purchase_order/'.$fileName,
	//         'created_by' => $this->session->userdata('userid') ?? null,
	//         'created_at' => date('Y-m-d H:i:s'),
	//         'no_bk' => $bk_number
	//     ];
	//     $result = $db_oriskin->insert('bukti_pengeluaran_kas', $insert);

	// 	$user = $db_oriskin->where('id', 68)->get('msuser')->row_array();
	// 	if (!$user) {
	// 		echo json_encode(['success' => false, 'message' => 'User tidak ditemukan']);
	// 		return;
	// 	}
	// 	$token   = bin2hex(random_bytes(32));
	// 	$expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));
	// 	$db_oriskin->insert('user_token', [
	// 		'userid'       => 68,   
	// 		'magic_token'  => $token,
	// 		'expired_time' => $expired,
	// 		'createdby'    => $user_id,
	// 	]);

	// 	$magic_link = base_url('magic_login?token=' . $token . '&redirect=detailPurchaseOrder/'.$purchaseorderid);

	// 	if($result){
	// 			$data = [
	// 			"recipient_type" => "individual",
	// 			"to"   => "6281267219935", 
	// 			"type" => "text",
	// 			"text" => [
	// 				"body" => "Halo Bu Sabrina Gouw,\n\nAda permintaan approval Purchase Order baru.\nKlik link berikut untuk melakukan approval:\n{$magic_link}\n\nLink berlaku 15 menit."
	// 			]
	// 		];
	// 		$response = $this->sendNotif($data);
	// 	}

	// 	if ($db_oriskin->affected_rows() > 0) {
	// 		echo json_encode(['status' => true, 'message' => $msg]);
	// 	} else {
	// 		echo json_encode([
	// 			'status'  => false,
	// 			'message' => 'Gagal menyimpan data',
	// 			'db_error' => $db_oriskin->error()
	// 		]);
	// 	}
	// }

	public function saveVaInfo()
	{
		$this->output->set_content_type('application/json');
		$db_oriskin = $this->load->database('oriskin', true);
		$post = $this->input->post();

		$purchaseorderid = $post['purchaseorderid'] ?? null;
		if (!$purchaseorderid) {
			echo json_encode(['status' => false, 'message' => 'ID tidak valid']);
			return;
		}

		$po = $this->ModelPurchasing->get_purchase_order_by_id($purchaseorderid);
		if (!$po) {
			echo json_encode(['status' => false, 'message' => 'Data Purchase Order tidak ditemukan']);
			return;
		}

		$db_oriskin->trans_begin();

		try {
			$dataVa = [
				'purchaseorderid' => $purchaseorderid,
				'ecommerce_name' => $post['ecommerce'] ?? null,
				'va_number' => $post['va_number'] ?? null,
				'createdat' => date('Y-m-d H:i:s'),
				'updatedat' => date('Y-m-d H:i:s')
			];

			$ongkir = (float) ($post['ongkir'] ?? 0);
			$other_cost = (float) ($post['other_cost'] ?? 0);

			$exists = $db_oriskin->get_where('ecommerce_virtual_account', ['purchaseorderid' => $purchaseorderid])->row_array();

			if ($exists) {
				$db_oriskin->where('purchaseorderid', $purchaseorderid)->update('ecommerce_virtual_account', $dataVa);
			} else {
				$db_oriskin->insert('ecommerce_virtual_account', $dataVa);
			}
			$updateData = [
				'ongkir' => $ongkir,
				'other_cost' => $other_cost
			];

			if ((int) $po['status'] === 10) {
				$updateData['status'] = 4;
			}

			$db_oriskin->where('id', $purchaseorderid)->update('purchase_order', $updateData);

			if ($db_oriskin->trans_status() === FALSE) {
				throw new Exception("Transaksi gagal, rollback...");
			}

			$db_oriskin->trans_commit();

			echo json_encode(['status' => true, 'message' => 'Data Virtual Account berhasil disimpan']);

		} catch (Exception $e) {
			$db_oriskin->trans_rollback();
			echo json_encode([
				'status' => false,
				'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
				'db_error' => $db_oriskin->error()
			]);
		}
	}


	public function toggleActive($id)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$this->output->set_content_type('application/json');

		$pr = $this->ModelPurchasing->get_purchase_request_by_id($id);

		if (!$pr) {
			echo json_encode(['status' => false, 'msg' => 'Data tidak ditemukan']);
			return;
		}

		$newStatus = $pr['isactive'] == 1 ? 0 : 1;

		$update = $this->ModelPurchasing->update_pr($id, [
			'isactive' => $newStatus,
			'updatedby' => $this->session->userdata('userid'),
			'updatedat' => date('Y-m-d H:i:s')
		]);

		if ($update) {
			echo json_encode([
				'status' => true,
				'message' => "Status berhasil diubah menjadi " . ($newStatus == 1 ? 'Active' : 'Nonactive')
			]);
		} else {
			echo json_encode([
				'status' => false,
				'message' => "Gagal update status",
				'db_error' => $db_oriskin->error()
			]);
		}
		exit;
	}


	public function deleteAlternative($id)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$this->output->set_content_type('application/json');

		if (!$id) {
			echo json_encode(['status' => false, 'msg' => 'ID tidak valid']);
			return;
		}

		$db_oriskin->where('id', $id)->delete('alternativeunitingredient');

		if ($db_oriskin->affected_rows() > 0) {
			echo json_encode(['status' => true, 'msg' => 'Alternatif berhasil dihapus']);
		} else {
			echo json_encode(['status' => false, 'msg' => 'Alternatif tidak ditemukan / gagal dihapus']);
		}
	}


	public function saveAlternatives()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$this->output->set_content_type('application/json');

		// Ambil input JSON
		$rawInput = $this->input->raw_input_stream;
		$postData = json_decode($rawInput, true);

		if (!$postData) {
			$postData = $this->input->post();
		}

		log_message('debug', 'SaveAlternatives POST: ' . print_r($postData, true));

		$ingredientId = $postData['ingredientId'] ?? null;
		$alternatives = $postData['alternatives'] ?? null;
		$userid = $this->session->userdata('userid');

		if (empty($ingredientId)) {
			echo json_encode(['status' => false, 'msg' => 'ingredientId wajib']);
			return;
		}

		if (empty($alternatives) || !is_array($alternatives)) {
			echo json_encode(['status' => false, 'msg' => 'Data alternatif kosong']);
			return;
		}

		$db_oriskin->trans_start();

		foreach ($alternatives as $alt) {
			$data = [
				'ingredientid' => $ingredientId,
				'unitid' => !empty($alt['unitid']) ? (int) $alt['unitid'] : null,
				'quantity' => isset($alt['quantity']) ? floatval($alt['quantity']) : 0,
				'qtytouom' => isset($alt['qtytouom']) ? floatval($alt['qtytouom']) : null,
				'amount' => isset($alt['amount']) ? floatval($alt['amount']) : null,
				'description' => $alt['description'] ?? null,
				'updatedat' => date('Y-m-d H:i:s'),
				'updatedby' => $userid
			];

			if (!empty($alt['id'])) {
				// UPDATE kalau ada id
				$db_oriskin->where('id', $alt['id']);
				$db_oriskin->update('alternativeunitingredient', $data);
			} else {
				// INSERT baru
				$data['createdat'] = date('Y-m-d H:i:s');
				$data['createdby'] = $userid;
				$db_oriskin->insert('alternativeunitingredient', $data);
			}
		}

		$db_oriskin->trans_complete();

		if ($db_oriskin->trans_status() === false) {
			echo json_encode([
				'status' => false,
				'msg' => 'Gagal menyimpan data alternatif',
				'error' => $db_oriskin->error()
			]);
		} else {
			echo json_encode([
				'status' => true,
				'msg' => 'Data alternatif berhasil disimpan'
			]);
		}
	}

	public function searchSuppliers()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$search = $this->input->get('q');

		$db_oriskin->select('id, name');
		$db_oriskin->from('mssupplier');


		if (!empty($search)) {
			$db_oriskin->like('name', $search);
		}
		$db_oriskin->where('isactive', 1);
		$db_oriskin->order_by('name', 'ASC');
		$suppliers = $db_oriskin->get()->result_array();

		$data = [];
		foreach ($suppliers as $s) {
			$data[] = [
				'id' => $s['id'],
				'name' => $s['name']
			];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function searchLocation()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$search = $this->input->get('q');

		$db_oriskin->select('shorcode, name');
		$db_oriskin->from('mssupplier');


		if (!empty($search)) {
			$db_oriskin->like('name', $search);
		}
		$db_oriskin->where('isactive', 1);
		$db_oriskin->order_by('name', 'ASC');
		$suppliers = $db_oriskin->get()->result_array();

		$data = [];
		foreach ($suppliers as $s) {
			$data[] = [
				'id' => $s['id'],
				'name' => $s['name']
			];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	// public function searchSalesSuppliers()
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$search = $this->input->get('q');

	// 	$db_oriskin->select('
	// 		s.id,
	// 		ss.id AS salesid,
	// 		s.name AS supplier_name,
	// 		s.isactive AS supplier_isactive,
	// 		s.email AS supplier_email,
	// 		s.address AS supplier_address,
	// 		s.suppliercode,
	// 		ss.nama AS sales_name,
	// 		ss.phonenumber AS sales_phone,
	// 		ss.address AS sales_address,
	// 		ss.email AS sales_email,
	// 		ss.isactive AS sales_isactive
	// 	');
	// 	$db_oriskin->from('suppliersales ss');
	// 	$db_oriskin->join('mssupplier s', 'ss.supplierid = s.id', 'left');

	// 	if (!empty($search)) {
	// 		$db_oriskin->like('ss.nama', $search); // pakai alias tabel biar aman
	// 		$db_oriskin->or_like('s.name', $search); // kalau mau sekalian cari supplier juga
	// 	}

	// 	$db_oriskin->order_by('ss.nama', 'ASC');
	// 	$suppliers = $db_oriskin->get()->result_array();

	// 	$data = [];
	// 	foreach ($suppliers as $s) {
	// 		$data[] = [
	// 			'id' => $s['salesid'],
	// 			'name' => $s['sales_name'] . " (" . $s['supplier_name'] . ")"
	// 		];
	// 	}

	// 	$this->output
	// 		->set_content_type('application/json')
	// 		->set_output(json_encode($data));
	// }

	// public function searchSalesSuppliers()
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$search = $this->input->get('q');

	// 	// 1. Ambil data suppliersales + supplier
	// 	$db_oriskin->select('
	// 		ss.id AS id,
	// 		ss.nama AS name,
	// 		s.name AS supplier_name,
	// 		s.suppliercode AS code,
	// 	');
	// 	$db_oriskin->from('suppliersales ss');
	// 	$db_oriskin->join('mssupplier s', 'ss.supplierid = s.id', 'left');

	// 	if (!empty($search)) {
	// 		$db_oriskin->group_start();
	// 		$db_oriskin->like('ss.nama', $search);
	// 		$db_oriskin->or_like('s.name', $search);
	// 		$db_oriskin->or_like('s.suppliercode', $search);
	// 		$db_oriskin->group_end();
	// 	}

	// 	$db_oriskin->order_by('ss.nama', 'ASC');
	// 	$sales = $db_oriskin->get()->result_array();

	// 	// Reset query builder sebelum query baru
	// 	$db_oriskin->reset_query();

	// 	// 2. Ambil semua data mscompany
	// 	$db_oriskin->select('id,suppliercode, name');
	// 	$db_oriskin->from('mssupplier');

	// 	if (!empty($search)) {
	// 		$db_oriskin->group_start();
	// 		$db_oriskin->like('name', $search);
	// 		$db_oriskin->or_like('suppliercode', $search);
	// 		$db_oriskin->group_end();
	// 	}

	// 	$db_oriskin->order_by('name', 'ASC');
	// 	$companies = $db_oriskin->get()->result_array();

	// 	// 3. Gabungkan kedua data
	// 	$data = [];

	// 	foreach ($sales as $s) {
	// 		$data[] = [
	// 			'id' => $s['id'],
	// 			'name' => $s['name'] . " (" . $s['supplier_name'] . ")",
	// 			'code' => $s['code']
	// 		];
	// 	}

	// 	foreach ($companies as $c) {
	// 		$data[] = [
	// 			'id' => $c['id'],
	// 			'name' => $c['name'] . " (" . $c['suppliercode'] . ")",
	// 			'code' => $c['suppliercode']
	// 		];
	// 	}

	// 	// 4. Output JSON
	// 	$this->output
	// 		->set_content_type('application/json')
	// 		->set_output(json_encode($data));
	// }

	public function searchSalesSuppliers()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$search = $this->input->get('q');

		$db_oriskin->select('
			ss.id AS id,
			ss.nama AS name,
			s.name AS supplier_name,
			s.isactive,
			s.suppliercode AS code
		');
		$db_oriskin->from('suppliersales ss');
		$db_oriskin->join('mssupplier s', 'ss.supplierid = s.id', 'left');
		$db_oriskin->where('s.isactive', 1);

		if (!empty($search)) {
			$db_oriskin->group_start();
			$db_oriskin->like('ss.nama', $search);
			$db_oriskin->or_like('s.name', $search);
			$db_oriskin->or_like('s.suppliercode', $search);
			$db_oriskin->group_end();
		}

		$db_oriskin->order_by('ss.nama', 'ASC');
		$sales = $db_oriskin->get()->result_array();

		$db_oriskin->reset_query();

		$db_oriskin->select('id, suppliercode, name, isactive');
		$db_oriskin->from('mssupplier');
		$db_oriskin->where('isactive', 1);

		if (!empty($search)) {
			$db_oriskin->group_start();
			$db_oriskin->like('name', $search);
			$db_oriskin->or_like('suppliercode', $search);
			$db_oriskin->group_end();
		}
		$db_oriskin->order_by('name', 'ASC');
		$companies = $db_oriskin->get()->result_array();

		$data = [];

		foreach ($sales as $s) {
			$data[] = [
				'id' => $s['id'],
				'name' => $s['name'] . " (" . $s['supplier_name'] . ")",
				'code' => $s['code']
			];
		}

		foreach ($companies as $c) {
			$data[] = [
				'id' => $c['id'],
				'name' => $c['name'] . " (" . $c['suppliercode'] . ")",
				'code' => $c['suppliercode']
			];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}



	public function getEmployees()
	{
		header('Content-Type: application/json');
		$level = $this->session->userdata('level');
		$search = $this->input->get('search');
		$locationid = $this->session->userdata('locationid');
		$data = $this->ModelPurchasing->getEmployees($search, $level, $locationid);

		echo json_encode($data);
	}

	public function getLocation()
	{
		header('Content-Type: application/json');

		$id = $this->input->post('id');
		$data = $this->MApp->get_location($id);

		echo json_encode($data);
	}

	public function getLocationById()
	{
		header('Content-Type: application/json');

		$search = $this->input->get('search');
		$data = $this->MApp->get_location($search);

		echo json_encode($data);
	}

	public function getWarehouses()
	{
		$search = $this->input->get('search', true);
		$level = $this->session->userdata('level');
		$locationid = $this->session->userdata('locationid');

		$this->load->model('ModelPurchasing');
		$warehouses = $this->ModelPurchasing->getWarehouse($search, $level, $locationid);

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($warehouses));
	}

	public function getAllSalesSupplier($id)
	{
		$this->load->model('ModelPurchasing');
		$data = $this->ModelPurchasing->get_all_sales_supplier($id);

		echo json_encode($data);
	}

	public function updateLocation($id = null)
	{
		$this->output->set_content_type('application/json');
		$user_id = $this->session->userdata('userid');

		// ambil id dari POST kalau ada
		if ($this->input->post('id')) {
			$id = $this->input->post('id');
		}

		if (!$id) {
			echo json_encode([
				'status' => 'error',
				'message' => 'ID lokasi tidak ditemukan'
			]);
			return;
		}

		$data = [
			'name' => $this->input->post('name'),
			'shortcode' => $this->input->post('shortcode'),
			'address' => $this->input->post('address'),
			'mobilephone' => $this->input->post('mobilephone'),
			'companyid' => $this->input->post('companyid'),
			'warehouseid' => $this->input->post('warehouseid'),
			'shortname' => $this->input->post('shortname'),
			'longitude' => $this->input->post('longitude'),
			'latitude' => $this->input->post('latitude'),
			'updatedate' => date('Y-m-d H:i:s'),
			'updateuserid' => $user_id
		];

		$update = $this->ModelPurchasing->update_location($id, $data);

		if ($update) {
			echo json_encode([
				'status' => 'success',
				'message' => 'Data lokasi berhasil diperbarui'
			]);
		} else {
			$db_error = $this->db->error();
			echo json_encode([
				'status' => 'error',
				'message' => 'Gagal update lokasi',
				'db_error' => $db_error,
				'db_error' => $db_error,
				'post' => $_POST,
				'query' => $this->db->last_query()
			]);
		}
	}

	public function addLocation()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$this->output->set_content_type('application/json');
		$user_id = $this->session->userdata('userid');
		$db_oriskin = $this->load->database('oriskin', true);

		$name = $this->input->post('name');
		$shortcode = $this->input->post('shortcode');
		$address = $this->input->post('address');
		$cityid = $this->input->post('cityid');

		if (!$name || !$shortcode || !$address || !$cityid) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Silahkan lengkapi data lokasi'
			]);
		} else {
			$data = [
				'name' => $this->input->post('name'),
				'shortcode' => $this->input->post('shortcode'),
				'address' => $this->input->post('address'),
				'mobilephone' => $this->input->post('mobilephone'),
				'companyid' => $this->input->post('companyid'),
				'shortname' => $this->input->post('shortname'),
				'longitude' => $this->input->post('longitude'),
				'latitude' => $this->input->post('latitude'),
				'updatedate' => date('Y-m-d H:i:s'),
				'updateuserid' => $user_id,
				'isactive' => 1,
				'warehouseid' => $this->input->post('warehouseid'),
				'cityid' => $this->input->post('cityid'),
				'placeid' => $this->input->post('placeid'),
				'starttimeoperational' => $this->input->post('starttimeoperational'),
				'operationalTime' => $this->input->post('operationalTime')
			];

			$update = $this->ModelPurchasing->add_location($data);

			if ($update) {
				echo json_encode([
					'status' => 'success',
					'message' => 'Data lokasi berhasil diperbarui'
				]);
			} else {
				$db_error = $db_oriskin->error();
				echo json_encode([
					'status' => 'error',
					'message' => 'Gagal update lokasi',
					'db_error' => $db_error,
					'db_error' => $db_error,
					'post' => $_POST,
					'query' => $db_oriskin->last_query()
				]);
			}
		}
	}



	public function searchEmployee()
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

	public function getCompanies()
	{
		$search = $this->input->get('search', true);
		$level = $this->session->userdata('level');
		$search = $this->input->get('search');
		$locationid = $this->session->userdata('locationid');

		$this->load->model('ModelPurchasing');
		$companies = $this->ModelPurchasing->getCompany($search, $level, $locationid);

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($companies));
	}

	// public function getWarehouses()
	// {
	// 	$search = $this->input->get('search', true);

	// 	$this->load->model('ModelPurchasing');
	// 	$companies = $this->ModelPurchasing->getCompany($search);

	// 	$this->output
	// 		->set_content_type('application/json')
	// 		->set_output(json_encode($companies));
	// }

	public function searchItems()
	{
		$this->load->model('ModelPurchasing');
		$id = $this->input->get('id');
		$search = $this->input->get('q');

		if ($id) {
			$row = $this->MApp->get_item_by_id($id);
			echo json_encode([
				[
					'id' => $row->id,
					'text' => "{$row->code} - {$row->name}"
				]
			]);
			return;
		}

		$search = $this->input->get('search');
		$data = $this->MApp->search_items($search);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => "{$row->code} - {$row->name}"
			];
		}

		echo json_encode($result);
	}

	public function markPurchaseOrderDone($id)
	{
		$this->load->model('ModelPurchasing');

		$update = $this->ModelPurchasing->update($id, ['status' => 1]);

		if ($update) {
			echo json_encode(['status' => true, 'message' => 'Purchase Order berhasil ditandai selesai.']);
		} else {
			echo json_encode(['status' => false, 'message' => 'Gagal update status.']);
		}
	}

	// public function uploadDocumentsPurchaseOrder()
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$this->output->set_content_type('application/json');

	// 	$purchaseorderid = $this->input->post('purchaseorderid');
	// 	if (empty($purchaseorderid)) {
	// 		$resp = ['status' => 'error', 'message' => 'Missing purchaseorderid'];
	// 		$this->output->set_output(json_encode($resp));
	// 		return;
	// 	}

	// 	// Path upload
	// 	$uploadPath = './uploads/purchase_order/';
	// 	if (!is_dir($uploadPath)) {
	// 		// buat folder (0755 lebih aman daripada 0777)
	// 		mkdir($uploadPath, 0755, true);
	// 	}

	// 	// Konfigurasi dasar
	// 	$allowed_types = 'pdf|jpg|jpeg|png';
	// 	$max_size = 5000; // KB

	// 	$data_update = [];
	// 	$errors = [];

	// 	// --- Upload BK Document (field name: bk_attachment) ---
	// 	if (isset($_FILES['bk_attachment']) && !empty($_FILES['bk_attachment']['name'])) {
	// 		$config = [
	// 			'upload_path'   => $uploadPath,
	// 			'allowed_types' => $allowed_types,
	// 			'max_size'      => $max_size,
	// 			'file_name'     => 'BK_'.$purchaseorderid.'_'.time(),
	// 			'overwrite'     => false
	// 		];
	// 		$this->load->library('upload');
	// 		$this->upload->initialize($config);

	// 		if ($this->upload->do_upload('bk_attachment')) {
	// 			$u = $this->upload->data();
	// 			$data_update['bk_attachment'] = $u['file_name'];
	// 		} else {
	// 			// ambil error tanpa tag HTML
	// 			$errors['bk_attachment'] = strip_tags($this->upload->display_errors('', ''));
	// 		}
	// 	}

	// 	// --- Upload Vendor Invoice (field name: vendor_invoice) ---
	// 	if (isset($_FILES['vendor_invoice']) && !empty($_FILES['vendor_invoice']['name'])) {
	// 		// reuse config, ganti file_name
	// 		$config['file_name'] = 'INV_'.$purchaseorderid.'_'.time();
	// 		$this->upload->initialize($config);

	// 		if ($this->upload->do_upload('vendor_invoice')) {
	// 			$u = $this->upload->data();
	// 			$data_update['vendor_invoice'] = $u['file_name'];
	// 		} else {
	// 			$errors['vendor_invoice'] = strip_tags($this->upload->display_errors('', ''));
	// 		}
	// 	}

	// 	// Simpan nama file ke DB jika ada yang berhasil diupload
	// 	if (!empty($data_update)) {
	// 		// Catatan: gunakan table yang benar. Di project kamu header PO menggunakan table 'purchase_order'
	// 		$db_oriskin->where('id', $purchaseorderid);
	// 		$ok = $db_oriskin->update('purchase_order', $data_update);

	// 		if (!$ok) {
	// 			$resp = [
	// 				'status'  => 'error',
	// 				'message' => 'Gagal menyimpan nama file ke database'
	// 			];
	// 			$this->output->set_output(json_encode($resp));
	// 			return;
	// 		}
	// 	}

	// 	// Susun response
	// 	if (!empty($errors) && !empty($data_update)) {
	// 		// sebagian berhasil, sebagian gagal
	// 		$resp = [
	// 			'status'    => 'partial',
	// 			'message'   => 'Beberapa file berhasil diupload, namun ada error pada file lain.',
	// 			'uploaded'  => $data_update,
	// 			'errors'    => $errors
	// 		];
	// 	} elseif (!empty($errors) && empty($data_update)) {
	// 		// semua gagal
	// 		$resp = [
	// 			'status'  => 'error',
	// 			'message' => 'Gagal upload file',
	// 			'errors'  => $errors
	// 		];
	// 	} elseif (!empty($data_update)) {
	// 		// semua berhasil (atau setidaknya satu berhasil dan tidak ada error)
	// 		$resp = [
	// 			'status'   => 'success',
	// 			'message'  => 'File berhasil diupload',
	// 			'uploaded' => $data_update
	// 		];
	// 	} else {
	// 		// tidak ada file dikirim
	// 		$resp = [
	// 			'status'  => 'error',
	// 			'message' => 'Tidak ada file yang diupload'
	// 		];
	// 	}

	// 	$this->output->set_output(json_encode($resp));
	// }

	// public function uploadDocumentsPurchaseOrder()
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$this->output->set_content_type('application/json');

	// 	$purchaseorderid = $this->input->post('purchaseorderid');
	// 	if (empty($purchaseorderid)) {
	// 		$resp = ['status' => false, 'message' => 'purchaseorderid wajib diisi'];
	// 		$this->output->set_output(json_encode($resp));
	// 		return;
	// 	}

	// 	// Path upload
	// 	$uploadPath = './uploads/purchase_order/';
	// 	if (!is_dir($uploadPath)) {
	// 		mkdir($uploadPath, 0755, true);
	// 	}

	// 	$allowed_types = 'pdf|jpg|jpeg|png';
	// 	$max_size = 5000; // KB

	// 	$data_update = [];
	// 	$errors = [];
	// 	// --- Upload Vendor Invoice ---
	// 	if (isset($_FILES['vendor_invoice']) && !empty($_FILES['vendor_invoice']['name'])) {
	// 		$config['file_name'] = 'INV_'.$purchaseorderid.'_'.time();
	// 		$this->upload->initialize($config);

	// 		if ($this->upload->do_upload('vendor_invoice')) {
	// 			$u = $this->upload->data();
	// 			$data_update['vendor_invoice'] = $u['file_name'];
	// 		} else {
	// 			$errors['vendor_invoice'] = strip_tags($this->upload->display_errors('', ''));
	// 		}
	// 	}

	// 	// Simpan ke DB
	// 	if (!empty($data_update)) {
	// 		$db_oriskin->where('id', $purchaseorderid);
	// 		$ok = $db_oriskin->update('purchase_order', $data_update);

	// 		if (!$ok) {
	// 			$resp = ['status' => false, 'message' => 'Gagal menyimpan data ke database'];
	// 			$this->output->set_output(json_encode($resp));
	// 			return;
	// 		}
	// 	}

	// 	// Susun response
	// 	if (!empty($errors) && !empty($data_update)) {
	// 		$resp = [
	// 			'status'  => true,
	// 			'message' => 'Sebagian file berhasil diupload, sebagian gagal',
	// 			'uploaded'=> $data_update,
	// 			'errors'  => $errors
	// 		];
	// 	} elseif (!empty($errors) && empty($data_update)) {
	// 		$resp = [
	// 			'status'  => false,
	// 			'message' => 'Upload gagal',
	// 			'errors'  => $errors
	// 		];
	// 	} elseif (!empty($data_update)) {
	// 		$resp = [
	// 			'status'  => true,
	// 			'message' => 'Upload berhasil',
	// 			'uploaded'=> $data_update
	// 		];
	// 	} else {
	// 		$resp = [
	// 			'status'  => false,
	// 			'message' => 'Tidak ada file yang dikirim'
	// 		];
	// 	}

	// 	$this->output->set_output(json_encode($resp));
	// }

	// 	public function uploadDocumentsPurchaseOrder()
// {
//     $db_oriskin = $this->load->database('oriskin', true);
//     $this->output->set_content_type('application/json');

	//     $purchaseorderid = $this->input->post('purchaseorderid');
//     if (empty($purchaseorderid)) {
//         $resp = ['status' => false, 'message' => 'purchaseorderid wajib diisi'];
//         $this->output->set_output(json_encode($resp));
//         return;
//     }

	//     // Path upload
//     $uploadPath = './uploads/purchase_order/';
//     if (!is_dir($uploadPath)) {
//         mkdir($uploadPath, 0755, true);
//     }

	//     $config['upload_path']   = $uploadPath;
//     $config['allowed_types'] = 'pdf|jpg|jpeg|png';
//     $config['max_size']      = 5000; // KB

	//     $this->load->library('upload', $config);

	//     $data_update = [];
//     $errors = [];

	//     // --- Upload Vendor Invoice saja ---
//     if (isset($_FILES['vendor_invoice']) && !empty($_FILES['vendor_invoice']['name'])) {
//         $config['file_name'] = 'INV_'.$purchaseorderid.'_'.time();
//         $this->upload->initialize($config);

	//         if ($this->upload->do_upload('vendor_invoice')) {
//             $u = $this->upload->data();
//             $data_update['vendor_invoice'] = $u['file_name'];
//         } else {
//             $errors['vendor_invoice'] = strip_tags($this->upload->display_errors('', ''));
//         }
//     }

	//     // Simpan ke DB
//     if (!empty($data_update)) {
//         $db_oriskin->where('id', $purchaseorderid);
//         $ok = $db_oriskin->update('purchase_order', $data_update);

	//         if (!$ok) {
//             $resp = ['status' => false, 'message' => 'Gagal menyimpan data ke database'];
//             $this->output->set_output(json_encode($resp));
//             return;
//         }
//     }

	//     // Susun response
//     if (!empty($errors) && !empty($data_update)) {
//         $resp = [
//             'status'  => true,
//             'message' => 'Vendor Invoice berhasil diupload, tapi ada error sebagian',
//             'uploaded'=> $data_update,
//             'errors'  => $errors
//         ];
//     } elseif (!empty($errors) && empty($data_update)) {
//         $resp = [
//             'status'  => false,
//             'message' => 'Upload Vendor Invoice gagal',
//             'errors'  => $errors
//         ];
//     } elseif (!empty($data_update)) {
//         $resp = [
//             'status'  => true,
//             'message' => 'Vendor Invoice berhasil diupload',
//             'uploaded'=> $data_update
//         ];
//     } else {
//         $resp = [
//             'status'  => false,
//             'message' => 'Tidak ada file Vendor Invoice yang dikirim'
//         ];
//     }

	//     $this->output->set_output(json_encode($resp));
// }

	// public function uploadDocumentsPurchaseOrder()
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$this->output->set_content_type('application/json');

	// 	$purchaseorderid = $this->input->post('purchaseorderid');
	// 	if (empty($purchaseorderid)) {
	// 		$resp = ['status' => false, 'message' => 'purchaseorderid wajib diisi'];
	// 		$this->output->set_output(json_encode($resp));
	// 		return;
	// 	}

	// 	// Path upload
	// 	$uploadPath = './uploads/purchase_order/';
	// 	if (!is_dir($uploadPath)) {
	// 		mkdir($uploadPath, 0755, true);
	// 	}

	// 	$config['upload_path']   = $uploadPath;
	// 	$config['allowed_types'] = 'pdf|jpg|jpeg|png';
	// 	$config['max_size']      = 5000; // KB

	// 	$this->load->library('upload', $config);

	// 	$data_update = [];
	// 	$errors = [];

	// 	// --- Upload Vendor Invoice saja ---
	// 	if (isset($_FILES['vendor_invoice']) && !empty($_FILES['vendor_invoice']['name'])) {
	// 		$config['file_name'] = 'INV_'.$purchaseorderid.'_'.time();
	// 		$this->upload->initialize($config);

	// 		if ($this->upload->do_upload('vendor_invoice')) {
	// 			$u = $this->upload->data();
	// 			$data_update['vendor_invoice'] = $u['file_name'];
	// 		} else {
	// 			$errors['vendor_invoice'] = strip_tags($this->upload->display_errors('', ''));
	// 		}
	// 	}

	// 	// --- Tambahan: Ongkos Kirim ---
	// 	$ongkir = $this->input->post('ongkir');
	// 	$other_cost = $this->input->post('other_cost');
	// 	if ($ongkir !== null && $ongkir !== '') {
	// 		$data_update['ongkir'] = $ongkir; 
	// 		$data_update['other_cost'] = $other_cost; 
	// 	}

	// 	// Simpan ke DB
	// 	if (!empty($data_update)) {
	// 		$db_oriskin->where('id', $purchaseorderid);
	// 		$ok = $db_oriskin->update('purchase_order', $data_update);

	// 		if (!$ok) {
	// 			$resp = ['status' => false, 'message' => 'Gagal menyimpan data ke database'];
	// 			$this->output->set_output(json_encode($resp));
	// 			return;
	// 		}
	// 	}

	// 	// Susun response
	// 	if (!empty($errors) && !empty($data_update)) {
	// 		$resp = [
	// 			'status'  => true,
	// 			'message' => 'Vendor Invoice berhasil diupload, tapi ada error sebagian',
	// 			'uploaded'=> $data_update,
	// 			'errors'  => $errors
	// 		];
	// 	} elseif (!empty($errors) && empty($data_update)) {
	// 		$resp = [
	// 			'status'  => false,
	// 			'message' => 'Upload Vendor Invoice gagal',
	// 			'errors'  => $errors
	// 		];
	// 	} elseif (!empty($data_update)) {
	// 		$resp = [
	// 			'status'  => true,
	// 			'message' => 'Vendor Invoice berhasil diupload',
	// 			'uploaded'=> $data_update
	// 		];
	// 	} else {
	// 		$resp = [
	// 			'status'  => false,
	// 			'message' => 'Tidak ada file Vendor Invoice yang dikirim'
	// 		];
	// 	}

	// 	$this->output->set_output(json_encode($resp));
	// }

	public function uploadDocumentsPurchaseOrder()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$this->output->set_content_type('application/json');

		$purchaseorderid = $this->input->post('purchaseorderid');
		if (empty($purchaseorderid)) {
			$resp = ['status' => false, 'message' => 'purchaseorderid wajib diisi'];
			$this->output->set_output(json_encode($resp));
			return;
		}

		$uploadPath = './uploads/purchase_order/';
		if (!is_dir($uploadPath)) {
			mkdir($uploadPath, 0755, true);
		}

		$config['upload_path'] = $uploadPath;
		$config['allowed_types'] = 'pdf|jpg|jpeg|png';
		$config['max_size'] = 5000; // KB

		$this->load->library('upload', $config);

		$uploadedFiles = [];
		$errors = [];

		// --- Tangani multiple vendor_invoice[] ---
		if (isset($_FILES['vendor_invoice']) && !empty($_FILES['vendor_invoice']['name'][0])) {
			$filesCount = count($_FILES['vendor_invoice']['name']);
			$limit = min($filesCount, 3); // maksimal 3 file

			for ($i = 0; $i < $limit; $i++) {
				$_FILES['file']['name'] = $_FILES['vendor_invoice']['name'][$i];
				$_FILES['file']['type'] = $_FILES['vendor_invoice']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['vendor_invoice']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['vendor_invoice']['error'][$i];
				$_FILES['file']['size'] = $_FILES['vendor_invoice']['size'][$i];

				$config['file_name'] = 'INV_' . $purchaseorderid . '_' . time() . "_$i";
				$this->upload->initialize($config);

				if ($this->upload->do_upload('file')) {
					$u = $this->upload->data();
					$uploadedFiles[] = $u['file_name'];
				} else {
					$errors[] = strip_tags($this->upload->display_errors('', ''));
				}
			}
		}

		// --- Gabung hasil upload jadi text ---
		$data_update = [];
		if (!empty($uploadedFiles)) {
			$data_update['vendor_invoice'] = implode(',', $uploadedFiles);
		}

		// --- Tambahan: Ongkir dan biaya lain ---
		$ongkir = $this->input->post('ongkir');
		$other_cost = $this->input->post('other_cost');
		if ($ongkir !== null && $ongkir !== '') {
			$data_update['ongkir'] = $ongkir;
			$data_update['other_cost'] = $other_cost;
		}

		// --- Simpan ke database ---
		if (!empty($data_update)) {
			$db_oriskin->where('id', $purchaseorderid);
			$ok = $db_oriskin->update('purchase_order', $data_update);

			if (!$ok) {
				$this->output->set_output(json_encode([
					'status' => false,
					'message' => 'Gagal menyimpan data ke database'
				]));
				return;
			}
		}

		// --- Response ---
		if (!empty($uploadedFiles)) {
			$resp = [
				'status' => true,
				'message' => 'Vendor Invoice berhasil diupload',
				'uploaded' => $uploadedFiles,
				'errors' => $errors
			];
		} else {
			$resp = [
				'status' => false,
				'message' => 'Tidak ada file Vendor Invoice yang dikirim atau gagal upload',
				'errors' => $errors
			];
		}

		$this->output->set_output(json_encode($resp));
	}




	public function checkDeliveryOrder($id)
	{
		$this->load->database();
		$exists = $this->db->where('purchaseorderid', $id)
			->get('delivery_orders')
			->row();

		// Jika belum ada, kembalikan ID PO, kalau sudah ada kembalikan null
		echo json_encode([
			'id' => $exists ? null : $id
		]);
	}


	// public function requestToApproval()
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$purchaseorderid = $this->input->post('purchaseorderid');

	// 	$update = $db_oriskin->where('id', $purchaseorderid)
	// 		->update('purchase_order', ['status' => 1]);

	// 	$data = array(
	//         "recipient_type" => "individual",
	//         "to" => "6289603512873",
	//         "type" => "text",
	//         "text" => array("body" => "Permintaan approval Purchase Order terbaru diterima. Silahkan masuk ke halaman https://sys.eudoraclinic.com:84/app/purchaseOrderApproval untuk melakukan approval Purchase Order.")
	//     );

	// 	if ($update) {
	// 	$response = $this->sendNotif($data);
	// 		if($response){
	// 			echo json_encode([
	// 			'success' => true,
	// 			'message' => 'Request to Approval berhasil dikirim'
	// 		]);
	// 		} else{
	// 			echo json_encode([
	// 			'success' => false,
	// 			'message' => 'Gagal mengirim pesan'
	// 		]);
	// 		}
	// 	} else {
	// 		echo json_encode([
	// 			'success' => false,
	// 			'message' => 'Gagal mengirim Request to approval'
	// 		]);
	// 	}
	// }

	public function requestToApproval()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$purchaseorderid = $this->input->post('purchaseorderid');
		$user_id = $this->session->userdata('userid');

		$update = $db_oriskin->where('id', $purchaseorderid)
			->update('purchase_order', ['status' => 1]);

		if (!$update) {
			echo json_encode([
				'success' => false,
				'message' => 'Gagal mengirim Request to approval'
			]);
			return;
		}
		$user = $db_oriskin->where('id', 67)->get('msuser')->row_array();
		if (!$user) {
			echo json_encode(['success' => false, 'message' => 'User tidak ditemukan']);
			return;
		}
		$token = bin2hex(random_bytes(32));
		$expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));
		$db_oriskin->insert('user_token', [
			'userid' => 67,
			'magic_token' => $token,
			'expired_time' => $expired,
			'createdby' => $user_id,
		]);

		$username = $user['name'];
		$magic_link = base_url('magic_login?token=' . $token . '&redirect=detailPurchaseOrder/' . $purchaseorderid);
		$data = [
			"recipient_type" => "individual",
			"to" => "6289603512873",
			"type" => "text",
			"text" => [
				"body" => "Halo Bu Desi,\n\nAda permintaan approval Purchase Order baru.\nKlik link berikut untuk melakukan approval:\n{$magic_link}."
			]
		];

		$response = $this->sendNotif($data);

		if ($response) {
			echo json_encode([
				'success' => true,
				'message' => 'Link untuk approval berhasil dikirim via WhatsApp'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => 'Gagal mengirim link approval'
			]);
		}
	}



	// public function saveStockInDummy()
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$purchaseorderid = $this->input->post('purchaseorderid');
	// 	$items = $this->input->post('items');

	// 	$response = [
	// 		'status'  => 'error',
	// 		'message' => 'Terjadi kesalahan'
	// 	];

	// 	try {
	// 		// Mulai transaksi
	// 		$db_oriskin->trans_begin();

	// 		// === 1. Insert ke msingredientsstockindummy (header) ===
	// 		$headerData = [
	// 			'tolocationid'   => 1, // TODO: bisa ambil dari session / PO
	// 			'updateuserid'   => $this->session->userdata('userid'),
	// 			'stockindate'    => date('Y-m-d H:i:s'),
	// 			'remarks'        => 'Stock In from PO ' . $purchaseorderid,
	// 			'updatedate'     => date('Y-m-d H:i:s'),
	// 			'refferenceno'   => $purchaseorderid,
	// 			'status'         => 1,
	// 			'stockmovement'  => 5,
	// 			'code'           => 'STOCK' . date('YmdHis'),
	// 			'issuedby'       => $this->session->userdata('userid'),
	// 			'fromlocationid' => 1, // TODO: ambil dari PO kalau ada
	// 			'producttype'    => null,
	// 			'supplierid'     => null
	// 		];
	// 		$db_oriskin->insert('msingredientsstockindummy', $headerData);
	// 		$stockinid = $db_oriskin->insert_id();

	// 		// === 2. Insert detail ke itemstockindummy ===
	// 		$detailInserted = false;

	// 		if ($items) {
	// 			foreach ($items as $item) {
	// 				if (isset($item['checked']) && $item['checked'] == "1") {
	// 					$detailData = [
	// 						'ingredientsid' => $item['ingredientsid'],
	// 						'stockinid'     => $stockinid,
	// 						'qty'           => $item['qty'],
	// 						'stockinqty'    => $item['stockinqty']
	// 					];
	// 					$db_oriskin->insert('itemstockindummy', $detailData);
	// 					$detailInserted = true;
	// 				}
	// 			}
	// 		}

	// 		if (!$detailInserted) {
	// 			throw new Exception("Tidak ada item yang dipilih untuk disimpan");
	// 		}

	// 		// Commit atau rollback
	// 		if ($db_oriskin->trans_status() === FALSE) {
	// 			$db_oriskin->trans_rollback();
	// 			throw new Exception("Gagal menyimpan StockIn Dummy");
	// 		} else {
	// 			$db_oriskin->trans_commit();
	// 			$response = [
	// 				'status'  => 'success',
	// 				'message' => 'StockIn Dummy berhasil disimpan',
	// 				'redirect_url' => base_url('ControllerPurchasing/detail/' . $purchaseorderid)
	// 			];
	// 		}

	// 	} catch (Exception $e) {
	// 		$response = [
	// 			'status'  => 'error',
	// 			'message' => $e->getMessage()
	// 		];
	// 	}

	// 	// Output JSON
	// 	$this->output
	// 		->set_content_type('application/json')
	// 		->set_output(json_encode($response));
	// }


	public function saveStockInDummy()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$post = $this->input->post();
		$userid = $this->session->userdata('userid');

		$purchaseorderid = $post['purchaseorderid'] ?? 0;
		$poAdditionalNotes = $post['po_additional_notes'] ?? '';
		$items = $post['items'] ?? [];

		$response = [
			'status' => 'error',
			'message' => 'Terjadi kesalahan'
		];

		try {
			if (!$purchaseorderid) {
				throw new Exception("Purchase Order ID tidak dikirim");
			}

			$prData = $db_oriskin->select('r.companyid,c.companycode,do.createdat,do.purchaseorderid,o.order_number')
				->from('delivery_orders do')
				->join('purchase_order o', 'o.id = do.purchaseorderid', 'left')
				->join('purchase_request r', 'r.id = o.purchaserequestid', 'left')
				->join('mscompany c', 'c.id = r.companyid', 'left')
				->where('do.id', $purchaseorderid)
				->get()
				->row_array();

			if (!$prData) {
				throw new Exception("Data Delivery Order untuk PurchaseOrderID {$purchaseorderid} tidak ditemukan");
			}

			$companyCode = isset($prData['companycode']) ? str_replace(' ', '', $prData['companycode']) : '';

			$total = $db_oriskin->from('delivery_orders')->where('status', 1)->count_all_results() + 1;
			$totalFormatted = str_pad($total, 6, "0", STR_PAD_LEFT);
			$month = date('m', strtotime($prData['createdat']));
			$year = date('Y', strtotime($prData['createdat']));
			$monthRomawi = $this->bulanRomawi($month);
			$delivery_number = $totalFormatted . "/" . $companyCode . "/DO/EDR-" . $monthRomawi . "-" . $year;

			$db_oriskin->trans_begin();

			$do = $db_oriskin->where('purchaseorderid', $purchaseorderid)
				->get('delivery_orders')
				->row();

			if ($do) {
				$deliveryOrderId = $do->id;
				$db_oriskin->where('purchaseorderid', $purchaseorderid)
					->update('delivery_orders', [
						'notes' => $poAdditionalNotes,
						'delivery_date' => date('Y-m-d H:i:s'),
						'delivery_time' => date('H:i:s'),
						'updatedat' => date('Y-m-d H:i:s'),
						'updatedby' => $userid
					]);

				log_message('debug', 'Updated delivery_orders ID: ' . $deliveryOrderId);
			} else {
				log_message('error', 'Delivery order tidak ditemukan untuk purchaseorderid: ' . $purchaseorderid);
			}

			$allItemsCompleted = true;
			if (!empty($items)) {
				foreach ($items as $item) {
					$itemId = $item['ingredientsid'] ?? 0;
					$checked = isset($item['checked']) ? 1 : 0;
					$notes = $item['notes'] ?? '';
					$doItemId = $item['doitemid'] ?? 0;

					if ($checked && $itemId) {
						$db_oriskin->where('id', $doItemId);
						$db_oriskin->update('delivery_order_items', [
							'updatedat' => date('Y-m-d H:i:s'),
							'updatedby' => $userid,
							'notes' => $notes,
							'status' => 1
						]);
					} else {
						$allItemsCompleted = false;
					}
				}
			} else {
				$allItemsCompleted = false;
			}

			if ($allItemsCompleted) {
				$db_oriskin->where('id', $purchaseorderid);
				$db_oriskin->update('delivery_orders', ['status' => 2]);
			}

			$headerData = [
				'towarehouseid' => $prData['warehouseid'] ?? 1,
				'updateuserid' => $userid,
				'stockindate' => date('Y-m-d H:i:s'),
				'remarks' => 'Stock In from PO ' . ($prData['order_number'] ?? $purchaseorderid),
				'updatedate' => date('Y-m-d H:i:s'),
				'refferenceno' => $delivery_number,
				'status' => 1,
				'stockmovement' => 6,
				'code' => $companyCode . date('YmdHis'),
				'issuedby' => $userid,
				'fromlocationid' => $prData['fromlocationid'] ?? null,
				'producttype' => $prData['producttype'] ?? null,
				'supplierid' => $prData['supplierid'] ?? null
			];
			$db_oriskin->insert('msingredientsstockin', $headerData);

			$stockinid = $db_oriskin->insert_id();

			if (!$stockinid) {
				throw new Exception("Gagal insert header stockin");
			}

			$detailInserted = false;
			foreach ($items as $item) {
				if (isset($item['checked']) && $item['checked'] == "1") {
					$detailData = [
						'ingredientsid' => $item['ingredientsid'],
						'stockinid' => $stockinid,
						'qty' => $item['qty'],
						'stockinqty' => $item['stockinqty']
					];
					$db_oriskin->insert('itemstockin', $detailData);

					if ($db_oriskin->affected_rows() == 0) {
						throw new Exception("Gagal insert detail item");
					}
					$detailInserted = true;
				}
			}

			if (!$detailInserted) {
				throw new Exception("Tidak ada item yang dicentang, detail kosong");
			}


			$db_oriskin->where('id', $prData['purchaseorderid'])
				->update('purchase_order', ['status' => 3]);

			if ($db_oriskin->affected_rows() == 0) {
				throw new Exception("Gagal update status purchase_order menjadi 3");
			}

			if ($db_oriskin->trans_status() === FALSE) {
				$db_oriskin->trans_rollback();
				throw new Exception("Transaksi gagal");
			} else {
				$db_oriskin->trans_commit();
				$user = $db_oriskin->where('id', 69)->get('msuser')->row_array();
				if (!$user) {
					echo json_encode(['success' => false, 'message' => 'User tidak ditemukan']);
					return;
				}
				$token = bin2hex(random_bytes(32));
				$expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));
				$db_oriskin->insert('user_token', [
					'userid' => 69,
					'magic_token' => $token,
					'expired_time' => $expired,
					'createdby' => $userid,
				]);
				$response = [
					'status' => 'success',
					'message' => 'Delivery Order & StockIn berhasil disimpan',
					'redirect_url' => base_url('deliveryOrderChecked/' . $purchaseorderid)
				];
			}

		} catch (Exception $e) {
			$db_oriskin->trans_rollback();
			$response = [
				'status' => 'error',
				'message' => $e->getMessage()
			];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}



	public function updateDeliveryOrderStatus()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$poId = $this->input->post('purchaseorderid');
		$userid = $this->session->userdata('userid');

		if (!$poId) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid Delivery Order ID']);
			return;
		}

		// langsung update tanpa model
		$db_oriskin->where('id', $poId);
		$update = $db_oriskin->update('delivery_orders', ['status' => 1]);

		if ($update) {
			$user = $db_oriskin->where('id', 69)->get('msuser')->row_array();
			if (!$user) {
				echo json_encode(['success' => false, 'message' => 'User tidak ditemukan']);
				return;
			}
			$token = bin2hex(random_bytes(32));
			$expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));
			$db_oriskin->insert('user_token', [
				'userid' => 69,
				'magic_token' => $token,
				'expired_time' => $expired,
				'createdby' => $userid,
			]);

			$magic_link = base_url('magic_login?token=' . $token . '&redirect=deliveryOrderChecked/' . $poId);
			$data = array(
				"recipient_type" => "individual",
				"to" => "6287884139208",
				"type" => "text",
				"text" => array("body" => "Halo,\n\nAda permintaan review pada delivery order terbaru.\nKlik link berikut untuk melakukan review:\n{$magic_link}.")
			);
			$this->sendNotif($data);
			echo json_encode([
				'status' => 'success',
				'message' => 'Delivery Order berhasil diselesaikan',
				'redirect_url' => site_url('deliveryOrderList')
			]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Gagal update status Delivery Order']);
		}
	}

	public function uploadDeliveryOrderItemPhoto()
	{
		$db_oriskin = $this->load->database('oriskin', true);

		$doItemId = $this->input->post('doitemid');
		if (!$doItemId) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid DO Item ID']);
			return;
		}

		// Konfigurasi upload
		$config['upload_path'] = FCPATH . '/uploads/purchase_order/delivery_order_items/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size'] = 2048; // 2MB
		$config['encrypt_name'] = TRUE; // biar nama file unik

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('photo_file')) {
			echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors('', '')]);
			return;
		}

		$uploadData = $this->upload->data();
		$filename = $uploadData['file_name'];

		// Simpan ke database (kolom `photo` misalnya di tabel delivery_order_items)
		$db_oriskin->where('id', $doItemId);
		$update = $db_oriskin->update('delivery_order_items', ['photo' => $filename]);

		if ($update) {
			echo json_encode([
				'status' => 'success',
				'message' => 'Foto berhasil diupload',
				'filename' => $filename
			]);
		} else {
			// kalau upload sukses tapi DB gagal, hapus file
			@unlink($config['upload_path'] . $filename);
			echo json_encode(['status' => 'error', 'message' => 'Gagal simpan ke database']);
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

	public function send_message()
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

	// public function approvePurchaseOrder($id)
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);

	// 	if(!$id){
	// 		echo json_encode(['status' => 'error', 'message' => 'ID PO tidak valid']);
	// 		return;
	// 	}

	// 	// Update status jadi 2 (Approved)
	// 	$db_oriskin->where('id', $id);
	// 	$update = $db_oriskin->update('purchase_order', ['status' => 2]);

	// 	if($update){
	// 		echo json_encode(['status' => 'success', 'message' => 'Purchase Order berhasil di-approve']);
	// 	} else {
	// 		echo json_encode(['status' => 'error', 'message' => 'Gagal approve Purchase Order']);
	// 	}
	// }

	// public function approvePurchaseOrder($id)
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);

	// 	if(!$id){
	// 		echo json_encode(['status' => 'error', 'message' => 'ID PO tidak valid']);
	// 		return;
	// 	}

	// 	// Ambil user id dari session (CI default)
	// 	$userId = $this->session->userdata('id'); 
	// 	$now = date('Y-m-d H:i:s');

	// 	// --- Mulai transaksi supaya aman
	// 	$db_oriskin->trans_begin();

	// 	// 1. Update status PO jadi 2 (Approved)
	// 	$db_oriskin->where('id', $id);
	// 	$update = $db_oriskin->update('purchase_order', [
	// 		'status'     => 2,
	// 		'updatedat'  => $now,
	// 		'updatedby'  => $userId
	// 	]);

	// 	if(!$update){
	// 		$db_oriskin->trans_rollback();
	// 		echo json_encode(['status' => 'error', 'message' => 'Gagal update status PO']);
	// 		return;
	// 	}

	// 	// 2. Insert ke delivery_orders
	// 	$deliveryData = [
	// 		'purchaseorderid' => $id,
	// 		'createdat'       => $now,
	// 		'createdby'       => $userId
	// 	];
	// 	$db_oriskin->insert('delivery_orders', $deliveryData);
	// 	$deliveryOrderId = $db_oriskin->insert_id();

	// 	if(!$deliveryOrderId){
	// 		$db_oriskin->trans_rollback();
	// 		echo json_encode(['status' => 'error', 'message' => 'Gagal membuat Delivery Order']);
	// 		return;
	// 	}

	// 	// 3. Ambil semua item dari purchase_order_items
	// 	$items = $db_oriskin->get_where('purchase_order_items', ['purchaseorderid' => $id])->result();

	// 	// 4. Insert ke delivery_order_items
	// 	foreach($items as $item){
	// 		$db_oriskin->insert('delivery_order_items', [
	// 			'deliveryorderid'   => $deliveryOrderId,
	// 			'purchaseorderitemid' => $item->id,
	// 			'createdat'         => $now,
	// 			'createdby'         => $userId
	// 		]);
	// 	}

	// 	// Commit transaksi jika semua berhasil
	// 	if ($db_oriskin->trans_status() === FALSE) {
	// 		$db_oriskin->trans_rollback();
	// 		echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat membuat Delivery Order']);
	// 	} else {
	// 		$db_oriskin->trans_commit();
	// 		echo json_encode(['status' => 'success', 'message' => 'Purchase Order berhasil di-approve dan Delivery Order dibuat']);
	// 	}
	// }

	// 	public function approvePurchaseOrder($id)
// {
//     $db_oriskin = $this->load->database('oriskin', true);

	//     if (!$id) {
//         echo json_encode(['status' => 'error', 'message' => 'ID PO tidak valid']);
//         return;
//     }

	//     // Pastikan ada file bukti transfer
//     if (empty($_FILES['bukti_transfer']['name'])) {
//         echo json_encode(['status' => 'error', 'message' => 'Bukti transfer wajib diupload']);
//         return;
//     }

	//     // Konfigurasi upload
//     $config['upload_path']   = './uploads/purchase_order/bukti_transfer/';
//     $config['allowed_types'] = 'jpg|jpeg|png|pdf';
//     $config['max_size']      = 2048; // 2 MB
//     $config['file_name']     = 'BT_' . $id . '_' . time();

	//     $this->load->library('upload', $config);

	//     if (!$this->upload->do_upload('bukti_transfer')) {
//         echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
//         return;
//     }

	//     $uploadData = $this->upload->data();
//     $fileName   = $uploadData['file_name'];

	//     // Ambil user id dari session
//     $userId = $this->session->userdata('id');
//     $now = date('Y-m-d H:i:s');

	//     // --- Mulai transaksi supaya aman
//     $db_oriskin->trans_begin();

	//     // 1. Update status PO + bukti_transfer
//     $db_oriskin->where('id', $id);
//     $update = $db_oriskin->update('purchase_order', [
//         'status'         => 2,
//         'bukti_transfer' => $fileName,
//         'updatedat'      => $now,
//         'updatedby'      => $userId
//     ]);

	//     if (!$update) {
//         $db_oriskin->trans_rollback();
//         echo json_encode(['status' => 'error', 'message' => 'Gagal update status PO']);
//         return;
//     }

	//     // 🔎 2. Cek apakah sudah ada DO untuk PO ini
//     $existingDO = $db_oriskin->get_where('delivery_orders', ['purchaseorderid' => $id])->row();
//     if ($existingDO) {
//         $db_oriskin->trans_rollback();
//         echo json_encode(['status' => 'error', 'message' => 'Delivery Order sudah pernah dibuat untuk PO ini']);
//         return;
//     }

	//     // 3. Ambil data tambahan untuk nomor DO
//     $prData = $db_oriskin->select('r.companyid,c.companycode,o.createdat')
//         ->from('purchase_order o')
//         ->join('purchase_request r', 'r.id = o.purchaserequestid', 'left')
//         ->join('mscompany c', 'c.id = r.companyid', 'left')
//         ->where('o.id', $id)
//         ->get()
//         ->row_array();

	//     $companyCode = isset($prData['companycode']) ? str_replace(' ', '', $prData['companycode']) : '';

	//     $total = $db_oriskin->from('delivery_orders')->count_all_results();
//     $total += 1; 
//     $totalFormatted = str_pad($total, 6, "0", STR_PAD_LEFT);
//     $month = date('m', strtotime($prData['createdat']));
//     $year = date('Y', strtotime($prData['createdat']));
//     $monthRomawi = $this->bulanRomawi($month);
//     $delivery_number = $totalFormatted."/".$companyCode."/DO/EDR-".$monthRomawi."-".$year;

	//     // 4. Insert ke delivery_orders
//     $deliveryData = [
//         'delivery_number' => $delivery_number,
//         'purchaseorderid' => $id,
//         'createdat'       => $now,
//         'createdby'       => $userId
//     ];
//     $db_oriskin->insert('delivery_orders', $deliveryData);
//     $deliveryOrderId = $db_oriskin->insert_id();

	//     if (!$deliveryOrderId) {
//         $db_oriskin->trans_rollback();
//         echo json_encode(['status' => 'error', 'message' => 'Gagal membuat Delivery Order']);
//         return;
//     }

	//     // 5. Ambil semua item dari purchase_order_items
//     $items = $db_oriskin->get_where('purchase_order_items', ['purchaseorderid' => $id])->result();

	//     if ($items) {
//         foreach ($items as $item) {
//             // ✅ gunakan purchaseorderitemid (bukan $item->id)
//             $db_oriskin->insert('delivery_order_items', [
//                 'deliveryorderid'     => $deliveryOrderId,
//                 'purchaseorderitemid' => $item->purchaseorderitemid,
//                 'createdat'           => $now,
//                 'createdby'           => $userId
//             ]);
//         }
//     }

	//     // Commit transaksi
//     if ($db_oriskin->trans_status() === FALSE) {
//         $db_oriskin->trans_rollback();
//         echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat membuat Delivery Order']);
//     } else {
//         $db_oriskin->trans_commit();
//         echo json_encode(['status' => 'success', 'message' => 'PO berhasil di-approve dengan bukti transfer & DO dibuat']);
//     }
// }


	// public function approvePurchaseOrder($id)
	// {
	// 	$db_oriskin = $this->load->database('oriskin', true);
	// 	$userid = $this->session->userdata('userid');

	// 	if (!$id) {
	// 		echo json_encode(['status' => 'error', 'message' => 'ID PO tidak valid']);
	// 		return;
	// 	}

	// 	// Pastikan ada file bukti transfer
	// 	if (empty($_FILES['bukti_transfer']['name'])) {
	// 		echo json_encode(['status' => 'error', 'message' => 'Bukti transfer wajib diupload']);
	// 		return;
	// 	}


	// 	// Konfigurasi upload
	// 	$config['upload_path']   = './uploads/purchase_order/bukti_transfer/';
	// 	$config['allowed_types'] = 'jpg|jpeg|png|pdf';
	// 	$config['max_size']      = 2048; // 2 MB
	// 	$config['file_name']     = 'BT_' . $id . '_' . time();

	// 	$this->load->library('upload', $config);

	// 	if (!$this->upload->do_upload('bukti_transfer')) {
	// 		echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
	// 		return;
	// 	}

	// 	$uploadData = $this->upload->data();
	// 	$fileName   = $uploadData['file_name'];

	// 	// Ambil user id dari session
	// 	$userId = $this->session->userdata('id');
	// 	$now = date('Y-m-d H:i:s');

	// 	// --- Mulai transaksi supaya aman
	// 	$db_oriskin->trans_begin();

	// 	// 1. Update status PO + bukti_transfer
	// 	$db_oriskin->where('id', $id);
	// 	$update = $db_oriskin->update('purchase_order', [
	// 		'status'         => 2,
	// 		'bukti_transfer' => $fileName,
	// 		'updatedat'      => $now,
	// 		'updatedby'      => $userId
	// 	]);

	// 	if (!$update) {
	// 		$db_oriskin->trans_rollback();
	// 		echo json_encode(['status' => 'error', 'message' => 'Gagal update status PO']);
	// 		return;
	// 	}

	// 	$user = $db_oriskin->where('id', 23)->get('msuser')->row_array();
	// 			if (!$user) {
	// 				echo json_encode(['success' => false, 'message' => 'User tidak ditemukan']);
	// 				return;
	// 			}
	// 			$token   = bin2hex(random_bytes(32));
	// 			$expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));
	// 			$db_oriskin->insert('user_token', [
	// 				'userid'       => 23,   
	// 				'magic_token'  => $token,
	// 				'expired_time' => $expired,
	// 				'createdby'    => $userid,
	// 			]);

	// 			$magic_link = base_url('magic_login?token=' . $token . '&redirect=purchaseOrderList');
	// 			$data = array(
	// 				"recipient_type" => "individual",
	// 				"to" => "6285776761415",
	// 				"type" => "text",
	// 				"text" => array("body" => "Halo,\n\nPengajuan Purchase Order anda telah disetujui .\nKlik link berikut untuk melakukan approval:\n{$magic_link}.")
	// 			);
	// 			$this->sendNotif($data);

	// 	$existingDO = $db_oriskin->get_where('delivery_orders', ['purchaseorderid' => $id])->row();
	// 	// if ($existingDO) {
	// 	// 	$db_oriskin->trans_rollback();
	// 	// 	echo json_encode(['status' => 'error', 'message' => 'Delivery Order sudah pernah dibuat untuk PO ini']);
	// 	// 	return;
	// 	// }

	// 	// 3. Ambil data tambahan untuk nomor DO
	// 	$prData = $db_oriskin->select('r.companyid,c.companycode,o.createdat')
	// 		->from('purchase_order o')
	// 		->join('purchase_request r', 'r.id = o.purchaserequestid', 'left')
	// 		->join('mscompany c', 'c.id = r.companyid', 'left')
	// 		->where('o.id', $id)
	// 		->get()
	// 		->row_array();

	// 	$companyCode = isset($prData['companycode']) ? str_replace(' ', '', $prData['companycode']) : '';

	// 	$total = $db_oriskin->from('delivery_orders')->count_all_results();
	// 	$total += 1; 
	// 	$totalFormatted = str_pad($total, 6, "0", STR_PAD_LEFT);
	// 	$month = date('m', strtotime($prData['createdat']));
	// 	$year = date('Y', strtotime($prData['createdat']));
	// 	$monthRomawi = $this->bulanRomawi($month);
	// 	$delivery_number = $totalFormatted."/".$companyCode."/DO/EDR-".$monthRomawi."-".$year;

	// 	// 4. Insert ke delivery_orders
	// 	$deliveryData = [
	// 		'delivery_number' => $delivery_number,
	// 		'purchaseorderid' => $id,
	// 		'createdat'       => $now,
	// 		'createdby'       => $userId
	// 	];
	// 	$db_oriskin->insert('delivery_orders', $deliveryData);
	// 	$deliveryOrderId = $db_oriskin->insert_id();

	// 	if (!$deliveryOrderId) {
	// 		$db_oriskin->trans_rollback();
	// 		echo json_encode(['status' => 'error', 'message' => 'Gagal membuat Delivery Order']);
	// 		return;
	// 	}

	// 	$items = $db_oriskin->get_where('purchase_order_items', ['purchaseorderid' => $id])->result();

	// 	if ($items) {
	// 		foreach ($items as $item) {
	// 			$insertData = [
	// 				'deliveryorderid'     => $deliveryOrderId,
	// 				'purchaseorderitemid' => $item->id, 
	// 				'createdat'           => $now,
	// 				'createdby'           => $userId
	// 			];

	// 			$db_oriskin->insert('delivery_order_items', $insertData);

	// 			if ($db_oriskin->affected_rows() <= 0) {
	// 				log_message('error', 'Gagal insert DO item: ' . $db_oriskin->last_query());
	// 				log_message('error', 'DB Error: ' . print_r($db_oriskin->error(), true));
	// 			}
	// 		}
	// 	}

	// 	// Commit transaksi
	// 	if ($db_oriskin->trans_status() === FALSE) {
	// 		$db_oriskin->trans_rollback();
	// 		echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat membuat Delivery Order']);
	// 	} else {
	// 		$db_oriskin->trans_commit();
	// 		echo json_encode(['status' => 'success', 'message' => 'PO berhasil di-approve dengan bukti transfer & DO dibuat']);
	// 	}
	// }

	public function approvePurchaseOrder($id)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$userid = $this->session->userdata('userid');

		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'ID PO tidak valid']);
			return;
		}

		if (empty($_FILES['bukti_transfer']['name'])) {
			echo json_encode(['status' => 'error', 'message' => 'Bukti transfer wajib diupload']);
			return;
		}

		$config['upload_path'] = './uploads/purchase_order/bukti_transfer/';
		$config['allowed_types'] = 'jpg|jpeg|png|pdf';
		$config['max_size'] = 2048; // 2 MB
		$config['file_name'] = 'BT_' . $id . '_' . time();

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('bukti_transfer')) {
			echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
			return;
		}

		$uploadData = $this->upload->data();
		$fileName = $uploadData['file_name'];

		$userId = $this->session->userdata('id');
		$now = date('Y-m-d H:i:s');

		$po = $db_oriskin->get_where('purchase_order', ['id' => $id])->row_array();
		if (!$po) {
			echo json_encode(['status' => 'error', 'message' => 'Data Purchase Order tidak ditemukan']);
			return;
		}

		$db_oriskin->trans_begin();
		// if (empty($po['bukti_transfer'])) {

		// 	$db_oriskin->where('id', $id)->update('purchase_order', [
		// 		'status' => 2,
		// 		'bukti_transfer' => $fileName,
		// 		'updatedat' => $now,
		// 		'updatedby' => $userId
		// 	]);

		// 	if ($db_oriskin->trans_status() === FALSE) {
		// 		$db_oriskin->trans_rollback();
		// 		echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan bukti transfer']);
		// 		return;
		// 	}

		// 	$db_oriskin->trans_commit();
		// 	echo json_encode(['status' => 'success', 'message' => 'Bukti transfer berhasil diupload, status PO diperbarui ke 2']);
		// 	return;

		// } else {
		$db_oriskin->where('id', $id)->update('purchase_order', [
			'status' => 3,
			'bukti_transfer' => $fileName,
			'updatedat' => $now,
			'updatedby' => $userId
		]);

		if ($db_oriskin->affected_rows() <= 0) {
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Gagal update status PO']);
			return;
		}

		$user = $db_oriskin->where('id', 23)->get('msuser')->row_array();
		if ($user) {
			$token = bin2hex(random_bytes(32));
			$expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));

			$db_oriskin->insert('user_token', [
				'userid' => 23,
				'magic_token' => $token,
				'expired_time' => $expired,
				'createdby' => $userid,
			]);

			$magic_link = base_url('magic_login?token=' . $token . '&redirect=purchaseOrderList');
			$data = [
				"recipient_type" => "individual",
				"to" => "6285776761415",
				"type" => "text",
				"text" => ["body" => "Halo,\n\nPurchase Order anda telah disetujui dan siap dibuat Delivery Order.\nKlik link berikut:\n{$magic_link}."]
			];
			$this->sendNotif($data);
		}

		$prData = $db_oriskin->select('r.companyid,c.companycode,o.createdat')
			->from('purchase_order o')
			->join('purchase_request r', 'r.id = o.purchaserequestid', 'left')
			->join('mscompany c', 'c.id = r.companyid', 'left')
			->where('o.id', $id)
			->get()
			->row_array();

		$companyCode = isset($prData['companycode']) ? str_replace(' ', '', $prData['companycode']) : '';
		$total = $db_oriskin->from('delivery_orders')->count_all_results() + 1;
		$totalFormatted = str_pad($total, 6, "0", STR_PAD_LEFT);
		$month = date('m', strtotime($prData['createdat']));
		$year = date('Y', strtotime($prData['createdat']));
		$monthRomawi = $this->bulanRomawi($month);
		$delivery_number = "{$totalFormatted}/{$companyCode}/DO/EDR-{$monthRomawi}-{$year}";

		if ($po['status_pembayaran'] = 0) {
			$deliveryData = [
				'delivery_number' => $delivery_number,
				'purchaseorderid' => $id,
				'createdat' => $now,
				'createdby' => $userId
			];

			$db_oriskin->insert('delivery_orders', $deliveryData);
			$deliveryOrderId = $db_oriskin->insert_id();

			if (!$deliveryOrderId) {
				$db_oriskin->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Gagal membuat Delivery Order']);
				return;
			}
			$items = $db_oriskin->get_where('purchase_order_items', ['purchaseorderid' => $id])->result();
			foreach ($items as $item) {
				$db_oriskin->insert('delivery_order_items', [
					'deliveryorderid' => $deliveryOrderId,
					'purchaseorderitemid' => $item->id,
					'createdat' => $now,
					'createdby' => $userId
				]);
			}
		}

		if ($db_oriskin->trans_status() === FALSE) {
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat membuat DO']);
		} else {
			$db_oriskin->trans_commit();
			echo json_encode(['status' => 'success', 'message' => 'PO berhasil di-approve (status 3) dan DO berhasil dibuat']);
		}
		// }
	}


	public function getDeliveryOrderByPurchaseOrderId($purchaseOrderId)
	{
		$data['order'] = $this->ModelPurchasing->getPurchaseOrderWithDelivery($purchaseOrderId);
		$data['items'] = $this->ModelPurchasing->getPurchaseOrderItemsWithDelivery($purchaseOrderId);
		echo json_encode($data);
	}

	// public function approvePurchaseOrder1()
	// {
	// 	$purchaseOrderId = $this->input->post('purchaseorderid');
	// 	$user_id = $this->session->userdata('userid');
	// 	$db_oriskin = $this->load->database('oriskin', true);

	// 	if(!$purchaseOrderId){
	// 		$this->session->set_flashdata('error', 'Purchase Order ID tidak valid');
	// 		redirect('ControllerPurchasing/detailPurchaseOrder/'.$purchaseOrderId);
	// 	}

	// 	$po = $db_oriskin->get_where('purchase_order', ['id' => $purchaseOrderId])->row_array();

	// 	if (!$po) {
	// 		echo json_encode([
	// 			'success' => false,
	// 			'message' => 'Purchase Order tidak ditemukan'
	// 		]);
	// 		return;
	// 	}

	// 	if($po['supplierid']==999){
	// 		$update = $db_oriskin->where('id', $purchaseOrderId)
	// 				->update('purchase_order', [
	// 					'status'    => 10,
	// 					'updatedat' => date('Y-m-d H:i:s'),
	// 					'updatedby' => $user_id
	// 				]);
	// 		$data = [
	// 			"recipient_type" => "individual",
	// 			"to"   => "6285776761415", 
	// 			"type" => "text",
	// 			"text" => [
	// 				"body" => "Halo,\nPermintaan approval Purchase Order anda telah disetujui.\nSilahkan masukan Informasi Virtual Account dan Invoice pada menu Purchase Order."
	// 			]
	// 		];
	// 		$response = $this->sendNotif($data);

	// 		if($update){
	// 				echo json_encode([
	// 					'success' => true,
	// 					'message' => 'Purchase Order berhasil diapprove'
	// 				]);
	// 			} else {
	// 				echo json_encode([
	// 					'success' => false,
	// 					'message' => 'Gagal update Purchase Order'
	// 				]);
	// 			}

	// 	}else{
	// 		$update = $db_oriskin->where('id', $purchaseOrderId)
	// 				->update('purchase_order', [
	// 					'status'    => 4,
	// 					'updatedat' => date('Y-m-d H:i:s'),
	// 					'updatedby' => $user_id
	// 				]);
	// 		if($update){
	// 			echo json_encode([
	// 				'success' => true,
	// 				'message' => 'Purchase Order berhasil diapprove'
	// 			]);
	// 		} else {
	// 			echo json_encode([
	// 				'success' => false,
	// 				'message' => 'Gagal update Purchase Order'
	// 			]);
	// 		}
	// 	}
	// }

	// public function approvePurchaseOrder1()
	// {
	// 	$purchaseOrderId = $this->input->post('purchaseorderid');
	// 	$user_id = $this->session->userdata('userid');
	// 	$db_oriskin = $this->load->database('oriskin', true);

	// 	if (!$purchaseOrderId) {
	// 		$this->session->set_flashdata('error', 'Purchase Order ID tidak valid');
	// 		redirect('ControllerPurchasing/detailPurchaseOrder/' . $purchaseOrderId);
	// 	}

	// 	$po = $this->ModelPurchasing->get_purchase_order_by_id($id);

	// 	if (!$po) {
	// 		echo json_encode([
	// 			'success' => false,
	// 			'message' => 'Purchase Order tidak ditemukan'
	// 		]);
	// 		return;
	// 	}

	// 	$companyId = $po['companyid'] ?? null;
	// 	$items = $db_oriskin->get_where('purchase_order_items', ['purchaseorderid' => $purchaseOrderId])->result_array();
	// 	$totalHarga = 0;
	// 	foreach ($items as $item) {
	// 		$totalHarga += (float) $item['total_price'];
	// 	}
	// 	if ($companyId != 15) {
	// 		$update = $db_oriskin->where('id', $purchaseOrderId)
	// 			->update('purchase_order', [
	// 				'status'    => 6,
	// 				'updatedat' => date('Y-m-d H:i:s'),
	// 				'updatedby' => $user_id
	// 			]);

	// 		if ($update) {
	// 			if (method_exists($this, 'create_bk_ajaxs')) {
	// 				$this->create_bk_ajaxs($purchaseOrderId);
	// 			}

	// 			$token   = bin2hex(random_bytes(32));
	// 			$expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));
	// 			$db_oriskin->insert('user_token', [
	// 				'userid'       => 29,   
	// 				'magic_token'  => $token,
	// 				'expired_time' => $expired,
	// 				'createdby'    => $user_id,
	// 			]);

	// 			$username = $user['name'];
	// 			$magic_link = base_url('magic_login?token=' . $token . '&redirect=financeApproval');
	// 			$data = [
	// 				"recipient_type" => "individual",
	// 				"to"   => "6281528440883", 
	// 				"type" => "text",
	// 				"text" => [
	// 					"body" => "Halo,\n\nAda Purchase Order yang telah setujui.\nKlik link berikut untuk melakukan upload bukti transfer:\n{$magic_link}."
	// 				]
	// 			];

	// 			$response = $this->sendNotif($data);

	// 			echo json_encode([
	// 				'success' => true,
	// 				'message' => 'Purchase Order disetujui dan BK otomatis dibuat'
	// 			]);
	// 		} else {
	// 			echo json_encode([
	// 				'success' => false,
	// 				'message' => 'Gagal update status Purchase Order'
	// 			]);
	// 		}

	// 		return; 
	// 	}

	// 	if ($po['supplierid'] == 999) {
	// 		$update = $db_oriskin->where('id', $purchaseOrderId)
	// 			->update('purchase_order', [
	// 				'status'    => 10,
	// 				'updatedat' => date('Y-m-d H:i:s'),
	// 				'updatedby' => $user_id
	// 			]);

	// 		$data = [
	// 			"recipient_type" => "individual",
	// 			"to"   => "6285776761415",
	// 			"type" => "text",
	// 			"text" => [
	// 				"body" => "Halo,\nPermintaan approval Purchase Order anda telah disetujui.\nSilahkan masukan Informasi Virtual Account dan Invoice pada menu Purchase Order."
	// 			]
	// 		];
	// 		$response = $this->sendNotif($data);

	// 		if ($update) {
	// 			echo json_encode([
	// 				'success' => true,
	// 				'message' => 'Purchase Order berhasil diapprove (supplier 999)'
	// 			]);
	// 		} else {
	// 			echo json_encode([
	// 				'success' => false,
	// 				'message' => 'Gagal update Purchase Order'
	// 			]);
	// 		}
	// 		return;
	// 	}

	// 	if ($totalHarga > 5000000) {
	// 		$update = $db_oriskin->where('id', $purchaseOrderId)
	// 			->update('purchase_order', [
	// 				'status'    => 4, 
	// 				'updatedat' => date('Y-m-d H:i:s'),
	// 				'updatedby' => $user_id
	// 			]);

	// 		if ($update) {
	// 			echo json_encode([
	// 				'success' => true,
	// 				'message' => 'Purchase Order disetujui dengan status 4 (total > 5.000.000)'
	// 			]);
	// 		} else {
	// 			echo json_encode([
	// 				'success' => false,
	// 				'message' => 'Gagal update status Purchase Order'
	// 			]);
	// 		}
	// 		return;
	// 	}

	// 	$update = $db_oriskin->where('id', $purchaseOrderId)
	// 		->update('purchase_order', [
	// 			'status'    => 4,
	// 			'updatedat' => date('Y-m-d H:i:s'),
	// 			'updatedby' => $user_id
	// 		]);

	// 	if ($update) {
	// 		echo json_encode([
	// 			'success' => true,
	// 			'message' => 'Purchase Order berhasil diapprove (companyid 15)'
	// 		]);
	// 	} else {
	// 		echo json_encode([
	// 			'success' => false,
	// 			'message' => 'Gagal update Purchase Order'
	// 		]);
	// 	}
	// }

	public function approvePurchaseOrder1()
	{
		$purchaseOrderId = $this->input->post('purchaseorderid');
		$user_id = $this->session->userdata('userid');
		$db_oriskin = $this->load->database('oriskin', true);

		if (!$purchaseOrderId) {
			echo json_encode([
				'success' => false,
				'message' => 'Purchase Order ID tidak valid'
			]);
			return;
		}

		$po = $this->ModelPurchasing->get_purchase_order_by_id($purchaseOrderId);

		if (!$po) {
			echo json_encode([
				'success' => false,
				'message' => 'Purchase Order tidak ditemukan'
			]);
			return;
		}

		$companyId = $po['companyid'] ?? null;
		$supplierId = $po['supplierid'] ?? null;

		$items = $db_oriskin->get_where('purchase_order_items', [
			'purchaseorderid' => $purchaseOrderId
		])->result_array();

		$totalHarga = 0;
		foreach ($items as $item) {
			$totalHarga += (float) $item['total_price'];
		}

		if ($companyId != 15) {
			$update = $db_oriskin->where('id', $purchaseOrderId)->update('purchase_order', [
				'status' => 6,
				'updatedat' => date('Y-m-d H:i:s'),
				'updatedby' => $user_id
			]);



			if ($update) {
				$result = $this->ModelPurchasing->approvePurchaseOrderTempoDo($purchaseOrderId);

				if (method_exists($this, 'create_bk_ajaxs')) {
					$this->create_bk_ajaxs($purchaseOrderId);
				}

				$token = bin2hex(random_bytes(32));
				$expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));

				$db_oriskin->insert('user_token', [
					'userid' => 29,
					'magic_token' => $token,
					'expired_time' => $expired,
					'createdby' => $user_id,
				]);

				$magic_link = base_url('magic_login?token=' . $token . '&redirect=financeApproval');


				$data = [
					"recipient_type" => "individual",
					"to" => "6281528440883",
					"type" => "text",
					"text" => [
						"body" => "Halo,\n\nAda Purchase Order yang telah disetujui.\nKlik link berikut untuk upload bukti transfer:\n{$magic_link}."
					]
				];
				$this->sendNotif($data);

				$data2 = [
					"recipient_type" => "individual",
					"to" => "628111699404",
					"type" => "text",
					"text" => [
						"body" => "Halo,\n\nAda Purchase Order yang telah disetujui.\nKlik link berikut untuk upload bukti transfer:\n{$magic_link}."
					]
				];
				$this->sendNotif($data2);

				echo json_encode([
					'success' => true,
					'message' => 'Purchase Order disetujui dan BK otomatis dibuat (companyid ≠ 15)'
				]);
			} else {
				echo json_encode([
					'success' => false,
					'message' => 'Gagal update status Purchase Order'
				]);
			}
			return;
		}

		// 🔹 CASE 2: Jika supplier = 999 → langsung status 10 dan kirim notifikasi
		if ($supplierId == 999) {
			$update = $db_oriskin->where('id', $purchaseOrderId)->update('purchase_order', [
				'status' => 10,
				'updatedat' => date('Y-m-d H:i:s'),
				'updatedby' => $user_id
			]);

			if ($update) {
				$data = [
					"recipient_type" => "individual",
					"to" => "6285776761415",
					"type" => "text",
					"text" => [
						"body" => "Halo,\nPermintaan approval Purchase Order anda telah disetujui.\nSilakan masukkan Informasi Virtual Account dan Invoice pada menu Purchase Order."
					]
				];
				$this->sendNotif($data);

				echo json_encode([
					'success' => true,
					'message' => 'Purchase Order berhasil diapprove (supplier 999)'
				]);
			} else {
				echo json_encode([
					'success' => false,
					'message' => 'Gagal update Purchase Order (supplier 999)'
				]);
			}
			return;
		}

		if ($totalHarga > 5000000) {
			$update = $db_oriskin->where('id', $purchaseOrderId)->update('purchase_order', [
				'status' => 4,
				'updatedat' => date('Y-m-d H:i:s'),
				'updatedby' => $user_id
			]);

			if ($update && $po['status_pembayaran'] != 0) {
				$result = $this->ModelPurchasing->approvePurchaseOrderTempoDo($purchaseOrderId);
			}

			echo json_encode([
				'success' => $update,
				'message' => $update
					? 'Purchase Order disetujui dengan status 4 (total > 5.000.000)'
					: 'Gagal update status Purchase Order'
			]);
			return;
		}

		$update = $db_oriskin->where('id', $purchaseOrderId)->update('purchase_order', [
			'status' => 4,
			'updatedat' => date('Y-m-d H:i:s'),
			'updatedby' => $user_id
		]);

		if ($update && $po['status_pembayaran'] != 0) {
			$result = $this->ModelPurchasing->approvePurchaseOrderTempoDo($purchaseOrderId);
		}

		echo json_encode([
			'success' => $update,
			'message' => $update
				? 'Purchase Order berhasil diapprove (companyid 15, total ≤ 5jt)'
				: 'Gagal update Purchase Order'
		]);
	}


	public function rejectPurchaseOrder1()
	{
		$purchaseOrderId = $this->input->post('purchaseorderid');
		$userid = $this->session->userdata('userid');

		if (!$purchaseOrderId) {
			$this->session->set_flashdata('error', 'Purchase Order ID tidak valid');
			redirect('ControllerPurchasing/detailPurchaseOrder/' . $purchaseOrderId);
		}

		$db_oriskin = $this->load->database('oriskin', true);
		$update = $db_oriskin->where('id', $purchaseOrderId)
			->update('purchase_order', [
				'status' => 5,
				'updatedat' => date('Y-m-d H:i:s'),
				'updatedby' => $userid
			]);


		if ($update) {
			echo json_encode([
				'success' => true,
				'message' => 'Purchase Order berhasil diapprove'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => 'Gagal update Purchase Order'
			]);
		}
	}

	public function approvePurchaseOrder2()
	{
		$purchaseOrderId = $this->input->post('purchaseorderid');
		$user_id = $this->session->userdata('userid');

		if (!$purchaseOrderId) {
			echo json_encode([
				'success' => false,
				'message' => 'Purchase Order ID tidak valid'
			]);
			return;
		}

		$db_oriskin = $this->load->database('oriskin', true);
		$db_oriskin->where('id', $purchaseOrderId);
		$update = $db_oriskin->update('purchase_order', [
			'status' => 6,
			'updatedat' => date('Y-m-d H:i:s'),
			'updatedby' => $user_id
		]);

		$user = $db_oriskin->where('id', 29)->get('msuser')->row_array();
		if (!$user) {
			echo json_encode(['success' => false, 'message' => 'User tidak ditemukan']);
			return;
		}
		$token = bin2hex(random_bytes(32));
		$expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));
		$db_oriskin->insert('user_token', [
			'userid' => 29,
			'magic_token' => $token,
			'expired_time' => $expired,
			'createdby' => $user_id,
		]);

		$username = $user['name'];
		$magic_link = base_url('magic_login?token=' . $token . '&redirect=financeApproval');
		$data = [
			"recipient_type" => "individual",
			"to" => "6281528440883",
			"type" => "text",
			"text" => [
				"body" => "Halo,\n\nAda Purchase Order yang telah setujui.\nKlik link berikut untuk melakukan upload bukti transfer:\n{$magic_link}."
			]
		];

		$response = $this->sendNotif($data);

		if ($update) {
			$response = $this->sendNotif($data);
			echo json_encode([
				'success' => true,
				'message' => 'Purchase Order berhasil diapprove'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => 'Gagal update Purchase Order'
			]);
		}
	}

	public function rejectPurchaseOrder2()
	{
		$purchaseOrderId = $this->input->post('purchaseorderid');
		$userid = $this->session->userdata('userid');

		if (!$purchaseOrderId) {
			echo json_encode([
				'success' => false,
				'message' => 'Purchase Order ID tidak valid'
			]);
			return;
		}

		$db_oriskin = $this->load->database('oriskin', true);
		$db_oriskin->where('id', $purchaseOrderId);
		$update = $db_oriskin->update('purchase_order', [
			'status' => 5,
			'updatedat' => date('Y-m-d H:i:s'),
			'updatedby' => $userid
		]);

		if ($update) {
			echo json_encode([
				'success' => true,
				'message' => 'Purchase Order berhasil direject'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => 'Gagal reject Purchase Order'
			]);
		}
	}

	public function approvePurchaseOrder3()
	{
		$purchaseOrderId = $this->input->post('purchaseorderid');
		$user_id = $this->session->userdata('userid');

		if (!$purchaseOrderId) {
			echo json_encode([
				'success' => false,
				'message' => 'Purchase Order ID tidak valid'
			]);
			return;
		}

		$db_oriskin = $this->load->database('oriskin', true);
		$db_oriskin->where('id', $purchaseOrderId);
		$update = $db_oriskin->update('purchase_order', [
			'status' => 11,
			'updatedat' => date('Y-m-d H:i:s'),
			'updatedby' => $user_id
		]);

		$user = $db_oriskin->where('id', 29)->get('msuser')->row_array();
		if (!$user) {
			echo json_encode(['success' => false, 'message' => 'User tidak ditemukan']);
			return;
		}
		$token = bin2hex(random_bytes(32));
		$expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));
		$db_oriskin->insert('user_token', [
			'userid' => 29,
			'magic_token' => $token,
			'expired_time' => $expired,
			'createdby' => $user_id,
		]);

		$username = $user['name'];
		$magic_link = base_url('magic_login?token=' . $token . '&redirect=financeApproval');
		$data = [
			"recipient_type" => "individual",
			"to" => "6281528440883",
			"type" => "text",
			"text" => [
				"body" => "Halo,\n\nAda Purchase Order yang telah setujui.\nKlik link berikut untuk melakukan upload bukti transfer:\n{$magic_link}."
			]
		];

		$response = $this->sendNotif($data);

		if ($update) {
			$response = $this->sendNotif($data);
			echo json_encode([
				'success' => true,
				'message' => 'Purchase Order berhasil diapprove'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => 'Gagal update Purchase Order'
			]);
		}
	}

	public function rejectPurchaseOrder3()
	{
		$purchaseOrderId = $this->input->post('purchaseorderid');
		$userid = $this->session->userdata('userid');

		if (!$purchaseOrderId) {
			echo json_encode([
				'success' => false,
				'message' => 'Purchase Order ID tidak valid'
			]);
			return;
		}

		$db_oriskin = $this->load->database('oriskin', true);
		$db_oriskin->where('id', $purchaseOrderId);
		$update = $db_oriskin->update('purchase_order', [
			'status' => 5,
			'updatedat' => date('Y-m-d H:i:s'),
			'updatedby' => $userid
		]);

		if ($update) {
			echo json_encode([
				'success' => true,
				'message' => 'Purchase Order berhasil direject'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => 'Gagal reject Purchase Order'
			]);
		}
	}

	// ✅ Simpan Delivery Order + Items
	// public function saveDeliveryOrder() {
	//     $post = $this->input->post();
	//     $deliveryOrderId = $post['deliveryorderid'];
	//     $notes = $post['notes'];
	//     $items = $post['items']; // array of item_id

	//     $this->db_oriskin->trans_start();

	//     // update notes di delivery_orders
	//     $this->ModelPurchasing->updateDeliveryOrderNotes($deliveryOrderId, $notes);

	//     // update status item yang dichecked
	//     if (!empty($items)) {
	//         foreach ($items as $itemId) {
	//             $this->ModelPurchasing->updateDeliveryOrderItemStatus($itemId, 1, $notes);
	//         }
	//     }

	//     // cek apakah semua item sudah status = 1
	//     if ($this->ModelPurchasing->checkAllDeliveryItemsDone($deliveryOrderId)) {
	//         $this->ModelPurchasing->updateDeliveryOrderStatus($deliveryOrderId, 1);
	//     }

	//     $this->db_oriskin->trans_complete();

	//     if ($this->db_oriskin->trans_status() === FALSE) {
	//         echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan delivery order.']);
	//     } else {
	//         echo json_encode(['status' => 'success', 'message' => 'Berhasil menyimpan delivery order.']);
	//     }
	// }

	public function deleteBK()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$file_path = $this->input->post('file_path');

		if (!$id || !$file_path) {
			echo json_encode(['status' => false, 'message' => 'Invalid request']);
			return;
		}

		// hapus file fisik
		$fullPath = $file_path; // misal: 'uploads/bk/...'
		if (file_exists($fullPath)) {
			unlink($fullPath);
		}

		// hapus dari database
		$db_oriskin->where('id', $id)->delete('bukti_pengeluaran_kas'); // ganti 'bk_table' dengan nama table BK di DB

		echo json_encode(['status' => true, 'message' => 'BK berhasil dihapus']);
	}

	//    public function updatePurchaseOrder()
// {
//     $db_oriskin = $this->load->database('oriskin', true);
//     $data = json_decode(file_get_contents('php://input'), true);
//     $userid = $this->session->userdata('userid');

	//     $this->output->set_content_type('application/json');

	//     if (!$data || empty($data['items'])) {
//         echo json_encode(['status' => false, 'msg' => 'Data tidak lengkap']);
//         return;
//     }

	//     $poid = $data['purchaseorderid'] ?? null;
//     if (empty($poid)) {
//         echo json_encode(['status' => false, 'msg' => 'Purchase Order ID tidak ditemukan']);
//         return;
//     }

	//     foreach ($data['items'] as $item) {
//         $poi_id = (int)$item['poi_id'];

	//         if ($poi_id <= 0) {
//             log_message('error', 'PO Item tanpa poi_id dilewati: ' . json_encode($item));
//             continue;
//         }

	//         $itemData = [
//             'fixed_price' => isset($item['fixed_price']) ? (float)$item['fixed_price'] : 0,
//             'total_price' => isset($item['total_price']) ? (float)$item['total_price'] : 0,
//             'discount_type'  => $item['discount_type'] ?? null,
//             'discount_value' => isset($item['discount_amount']) ? (float)$item['discount_amount'] : 0,
//             'updated_by'     => $userid,
//             'updated_at'     => date('Y-m-d H:i:s')
//         ];

	//         $db_oriskin->where('id', $poi_id);
//         $updated = $db_oriskin->update('purchase_order_items', $itemData);

	//         if (!$updated) {
//             log_message('error', 'Gagal update PO item ID: ' . $poi_id . ' | Error: ' . json_encode($db_oriskin->error()));
//         }
//     }

	//     if (!$updated) {
//         $error = $db_oriskin->error();
//         echo json_encode([
//             'status' => false,
//             'msg' => 'Gagal mengupdate Purchase Order',
//             'db_error' => $error
//         ]);
//     } else {
//         echo json_encode([
//             'status' => true,
//             'msg' => 'Purchase Order berhasil diperbarui!',
//             'po_id' => $poid
//         ]);
//     }
// }

	// public function updatePurchaseOrder()
// {
//     $db_oriskin = $this->load->database('oriskin', true);
//     $data = json_decode(file_get_contents('php://input'), true);
//     $userid = $this->session->userdata('userid');

	//     $this->output->set_content_type('application/json');

	//     if (!$data || empty($data['items'])) {
//         echo json_encode(['status' => false, 'msg' => 'Data tidak lengkap']);
//         return;
//     }

	//     $poid = $data['purchaseorderid'] ?? null;
//     if (empty($poid)) {
//         echo json_encode(['status' => false, 'msg' => 'Purchase Order ID tidak ditemukan']);
//         return;
//     }

	//     $db_oriskin->trans_start();
//     $successCount = 0;

	//     foreach ($data['items'] as $item) {
//         $poi_id = (int)($item['poi_id'] ?? 0);
//         $pr_item_id = (int)($item['purchaserequestitemid'] ?? 0);

	//         if ($poi_id <= 0) {
//             log_message('error', 'PO Item tanpa poi_id dilewati: ' . json_encode($item));
//             continue;
//         }

	//         $fixed_price = isset($item['fixed_price']) ? (float)$item['fixed_price'] : 0;
//         $total_price = isset($item['total_price']) ? (float)$item['total_price'] : 0;
//         $discount_value = isset($item['discount_amount']) ? (float)$item['discount_amount'] : 0;
//         $discount_type = $item['discount_type'] ?? null;

	//         // --- Update data PO Item ---
//         $itemData = [
//             'fixed_price'      => $fixed_price,
//             'total_price'      => $total_price,
//             'discount_type'    => $discount_type,
//             'discount_value'   => $discount_value,
//         ];

	//         $db_oriskin->where('id', $poi_id);
//         $db_oriskin->update('purchase_order_items', $itemData);

	//         if ($db_oriskin->affected_rows() > 0) {
//             $successCount++;
//         }

	//         // --- Update quantity di purchase_request_items ---
//         if ($pr_item_id > 0 && isset($item['qty'])) {
//             $qty = (float)$item['qty'];
//             $db_oriskin->where('id', $pr_item_id);
//             $db_oriskin->update('purchase_request_items', [
//                 'quantity' => $qty,
//                 'updated_by' => $userid,
//                 'updated_at' => date('Y-m-d H:i:s')
//             ]);
//         }
//     }

	//     $db_oriskin->trans_complete();

	//     if ($db_oriskin->trans_status() === FALSE) {
//         $error = $db_oriskin->error();
//         echo json_encode([
//             'status' => false,
//             'msg' => 'Gagal mengupdate Purchase Order',
//             'db_error' => $error
//         ]);
//     } else {
//         echo json_encode([
//             'status' => $successCount > 0,
//             'msg' => $successCount > 0 
//                 ? "Purchase Order berhasil diperbarui ($successCount item berubah)"
//                 : "Tidak ada data yang berubah",
//             'po_id' => $poid
//         ]);
//     }
// }

	public function updatePurchaseOrder()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$data = json_decode(file_get_contents('php://input'), true);
		$userid = $this->session->userdata('userid');

		$this->output->set_content_type('application/json');

		if (!$data || empty($data['items'])) {
			echo json_encode(['status' => false, 'msg' => 'Data tidak lengkap']);
			return;
		}

		$poid = $data['purchaseorderid'] ?? null;
		if (empty($poid)) {
			echo json_encode(['status' => false, 'msg' => 'Purchase Order ID tidak ditemukan']);
			return;
		}

		$db_oriskin->trans_start();
		$successCount = 0;

		foreach ($data['items'] as $item) {
			$poi_id = (int) ($item['poi_id'] ?? 0);
			$pr_item_id = (int) ($item['purchaserequestitemid'] ?? 0);

			if ($poi_id <= 0)
				continue;

			$fixed_price = isset($item['fixed_price']) ? (float) $item['fixed_price'] : 0;
			$total_price = isset($item['total_price']) ? (float) $item['total_price'] : 0;
			$discount_amount = isset($item['discount_amount']) ? (float) $item['discount_amount'] : 0;
			$discount_type = $item['discount_type'] ?? null;

			// --- Update data PO Item ---
			$itemData = [
				'fixed_price' => $fixed_price,
				'total_price' => $total_price,
				'discount_type' => $discount_type,
				'discount_value' => $discount_amount, // gunakan kolom ini
				'updated_by' => $userid,
				'updated_at' => date('Y-m-d H:i:s')
			];

			$db_oriskin->where('id', $poi_id);
			$updated = $db_oriskin->update('purchase_order_items', $itemData);

			if (!$updated) {
				log_message('error', '❌ Gagal update PO item ID: ' . $poi_id . ' | Error: ' . json_encode($db_oriskin->error()));
			}

			if ($db_oriskin->affected_rows() > 0) {
				$successCount++;
			}
			if ($pr_item_id > 0 && isset($item['qty'])) {
				$qty = (float) $item['qty'];
				$db_oriskin->where('id', $pr_item_id);
				$db_oriskin->update('purchase_request_items', [
					'quantity' => $qty,
					'updated_by' => $userid,
					'updated_at' => date('Y-m-d H:i:s')
				]);
			}
		}

		$db_oriskin->trans_complete();

		if ($db_oriskin->trans_status() === FALSE) {
			$error = $db_oriskin->error();
			echo json_encode([
				'status' => false,
				'msg' => 'Gagal mengupdate Purchase Order',
				'db_error' => $error
			]);
		} else {
			echo json_encode([
				'status' => $successCount > 0,
				'msg' => $successCount > 0
					? "Purchase Order berhasil diperbarui ($successCount item berubah)"
					: "Tidak ada data yang berubah",
				'po_id' => $poid
			]);
		}
	}


	public function generateInvoicePDF($id)
	{
		ob_start();

		$this->load->model('ModelPurchasing');
		$this->load->library('Ltcpdf');

		$db_oriskin = $this->load->database('oriskin', true);

		// Ambil data PO
		$data['purchase_order'] = $this->ModelPurchasing->get_purchase_order_by_id($id);
		$data['date'] = date('d-m-Y');

		$ongkir = $this->input->get('ongkir');
		$other_cost = $this->input->get('other_cost');

		$updateData = [
			'updatedat' => date('Y-m-d H:i:s'),
		];

		if (!empty($ongkir)) {
			$updateData['ongkir'] = $ongkir;
			$data['purchase_order']['ongkir'] = $ongkir;
		}

		if (!empty($other_cost)) {
			$updateData['other_cost'] = $other_cost;
			$data['purchase_order']['other_cost'] = $other_cost;
		}

		// ==== Buat PDF ====
		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Eudora Clinic');
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetAutoPageBreak(TRUE, 15);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		$html = $this->load->view('content/Purchasing/generateInvoice', $data, true);
		$pdf->writeHTML($html, true, false, true, false, '');

		// ==== Cek kondisi supplier ====
		if (
			!empty($data['purchase_order']) &&
			$data['purchase_order']['supplierid'] == 25 &&
			empty($data['purchase_order']['vendor_invoice'])
		) {

			$fileName = 'INV-' . $id . '.pdf';
			$filePath = FCPATH . 'uploads/purchase_order/' . $fileName;
			if (!is_dir(FCPATH . 'uploads/purchase_order/')) {
				mkdir(FCPATH . 'uploads/purchase_order/', 0777, true);
			}


			$pdf->Output($filePath, 'F'); // 'F' = save to file

			$updateData['vendor_invoice'] = $fileName;

			$db_oriskin->where('id', $id);
			$db_oriskin->update('purchase_order', $updateData);

			$pdf->Output($fileName, 'I');
		} else {
			$pdf->Output('PurchaseRequest_' . $id . '.pdf', 'I');
		}

		ob_end_flush();


	}
	public function updatePurchaseOrderStatusByTotal()
	{
		$db_oriskin = $this->load->database('oriskin', true);

		$purchaseOrders = $db_oriskin
			->select('purchase_order.*, purchase_request.companyid')
			->from('purchase_order')
			->join('purchase_request', 'purchase_request.id = purchase_order.purchaserequestid')
			->where('purchase_order.status', 7)
			->where('purchase_request.companyid =', 15)
			->get()
			->result_array();

		$updatedCount = 0;

		foreach ($purchaseOrders as $po) {
			$purchaseOrderId = $po['id'];

			$totalItems = $db_oriskin->select_sum('total_price')
				->where('purchaseorderid', $purchaseOrderId)
				->get('purchase_order_items')
				->row()
				->total_price ?? 0;

			if ($totalItems < 5000000) {
				$db_oriskin->where('id', $purchaseOrderId)
					->update('purchase_order', [
						'status' => 6,
						'updatedat' => date('Y-m-d H:i:s'),
						'updatedby' => $this->session->userdata('userid')
					]);
				$updatedCount++;
			}
		}

		echo json_encode([
			'success' => true,
			'message' => "Berhasil memperbarui $updatedCount purchase order menjadi status 6."
		]);
	}


	public function uploadPrItemImageUpdate()
	{

		$db_oriskin = $this->load->database('oriskin', true);
		if (!isset($_POST['priid_update'])) {
			echo json_encode(['status' => false, 'message' => 'purchase_request_item_id tidak ditemukan']);
			return;
		}

		$purchase_request_item_id = $_POST['priid_update'];

		if (empty($_FILES['images']['name'][0])) {
			echo json_encode(['status' => false, 'message' => 'Tidak ada file yang diupload']);
			return;
		}

		$upload_path = './uploads/purchase_request_items/';

		$files = $_FILES['images'];
		$uploaded_files = [];

		for ($i = 0; $i < count($files['name']); $i++) {
			$_FILES['image']['name'] = $files['name'][$i];
			$_FILES['image']['type'] = $files['type'][$i];
			$_FILES['image']['tmp_name'] = $files['tmp_name'][$i];
			$_FILES['image']['error'] = $files['error'][$i];
			$_FILES['image']['size'] = $files['size'][$i];

			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size'] = 5120; // 5MB
			$config['file_name'] = uniqid() . '_' . basename($files['name'][$i]);

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('image')) {
				$data_upload = $this->upload->data();
				$file_path = 'uploads/purchase_request_items/' . $data_upload['file_name'];

				// Simpan ke database
				$db_oriskin->insert('purchase_request_item_images', [
					'purchase_request_item_id' => $purchase_request_item_id,
					'image_path' => $file_path,
					'description' => NULL
				]);

				$uploaded_files[] = $file_path;
			} else {
				echo json_encode([
					'status' => false,
					'message' => $this->upload->display_errors()
				]);
				return;
			}
		}

		echo json_encode([
			'status' => true,
			'message' => 'Upload berhasil',
			'files' => $uploaded_files
		]);
	}




	public function approvePurchaseOrderToDo($id)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$userid = $this->session->userdata('userid');

		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'ID PO tidak valid']);
			return;
		}

		$userId = $this->session->userdata('id');
		$now = date('Y-m-d H:i:s');

		$po = $db_oriskin->get_where('purchase_order', ['id' => $id])->row_array();
		if (!$po) {
			echo json_encode(['status' => 'error', 'message' => 'Data Purchase Order tidak ditemukan']);
			return;
		}

		$db_oriskin->trans_begin();

		$db_oriskin->where('id', $id)->update('purchase_order', [
			'status' => 3,
			'updatedat' => $now,
			'updatedby' => $userId
		]);

		if ($db_oriskin->affected_rows() <= 0) {
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Gagal update status PO']);
			return;
		}

		$user = $db_oriskin->where('id', 23)->get('msuser')->row_array();
		if ($user) {
			$token = bin2hex(random_bytes(32));
			$expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));

			$db_oriskin->insert('user_token', [
				'userid' => 23,
				'magic_token' => $token,
				'expired_time' => $expired,
				'createdby' => $userid,
			]);

			$magic_link = base_url('magic_login?token=' . $token . '&redirect=purchaseOrderList');
			$data = [
				"recipient_type" => "individual",
				"to" => "6285776761415",
				"type" => "text",
				"text" => ["body" => "Halo,\n\nPurchase Order anda telah disetujui dan siap dibuat Delivery Order.\nKlik link berikut:\n{$magic_link}."]
			];
			$this->sendNotif($data);
		}

		$prData = $db_oriskin->select('r.companyid,c.companycode,o.createdat')
			->from('purchase_order o')
			->join('purchase_request r', 'r.id = o.purchaserequestid', 'left')
			->join('mscompany c', 'c.id = r.companyid', 'left')
			->where('o.id', $id)
			->get()
			->row_array();

		$companyCode = isset($prData['companycode']) ? str_replace(' ', '', $prData['companycode']) : '';
		$total = $db_oriskin->from('delivery_orders')->count_all_results() + 1;
		$totalFormatted = str_pad($total, 6, "0", STR_PAD_LEFT);
		$month = date('m', strtotime($prData['createdat']));
		$year = date('Y', strtotime($prData['createdat']));
		$monthRomawi = $this->bulanRomawi($month);
		$delivery_number = "{$totalFormatted}/{$companyCode}/DO/EDR-{$monthRomawi}-{$year}";

		$deliveryData = [
			'delivery_number' => $delivery_number,
			'purchaseorderid' => $id,
			'createdat' => $now,
			'createdby' => $userId
		];

		$db_oriskin->insert('delivery_orders', $deliveryData);
		$deliveryOrderId = $db_oriskin->insert_id();

		if (!$deliveryOrderId) {
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Gagal membuat Delivery Order']);
			return;
		}
		$items = $db_oriskin->get_where('purchase_order_items', ['purchaseorderid' => $id])->result();
		foreach ($items as $item) {
			$db_oriskin->insert('delivery_order_items', [
				'deliveryorderid' => $deliveryOrderId,
				'purchaseorderitemid' => $item->id,
				'createdat' => $now,
				'createdby' => $userId
			]);
		}

		if ($db_oriskin->trans_status() === FALSE) {
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat membuat DO']);
		} else {
			$db_oriskin->trans_commit();
			echo json_encode(['status' => 'success', 'message' => 'PO berhasil di-approve (status 3) dan DO berhasil dibuat']);
		}
	}


	public function getPurchaseOrderItem($id)
	{
		$data = $this->ModelPurchasing->getPurchaseOrderItem($id);

		if ($data) {
			echo json_encode(['status' => 'success', 'data' => $data]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
		}
	}



	public function updatePurchaseOrderItem()
	{
		$db_oriskin = $this->load->database('oriskin', true);

		$poi_id = $this->input->post('poi_id', TRUE);
		$quantity = $this->input->post('quantity', TRUE);
		$fixed_price = str_replace('.', '', $this->input->post('fixed_price', TRUE));
		$discount_type = $this->input->post('discount_type', TRUE);
		$discount_value = str_replace('.', '', $this->input->post('discount_value', TRUE));

		if (empty($poi_id)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'ID item tidak ditemukan.'
			]);
			return;
		}

		$quantity = floatval($quantity);
		$fixed_price = floatval(str_replace(',', '.', $fixed_price));
		$discount_value = floatval(str_replace(',', '.', $discount_value));

		$discount_amount = 0;

		// Hitung discount amount
		if ($discount_type === 'persen') {
			$discount_amount = ($discount_value / 100) * $fixed_price * $quantity;
		} elseif ($discount_type === 'nominal') {
			$discount_amount = $discount_value;
		}

		// Hitung total price sebelum discount
		$subtotal = $fixed_price * $quantity;

		// Hitung total price setelah discount
		$total_price = $subtotal - $discount_amount;
		if ($total_price < 0) {
			$total_price = 0;
		}

		$data = [
			'fixed_price' => $fixed_price,
			'discount_type' => $discount_type ?: null,
			'discount_value' => $discount_value, // nilai discount asli (persen atau nominal)
			'discount_amount' => $discount_amount, // jumlah discount dalam rupiah
			'total_price' => $total_price,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $this->session->userdata('userid') ?? null
		];

		$db_oriskin->where('id', $poi_id);
		$update = $db_oriskin->update('purchase_order_items', $data);

		if ($update) {
			echo json_encode([
				'status' => 'success',
				'message' => 'Data item berhasil diperbarui.',
				'data' => [
					'poi_id' => $poi_id,
					'quantity' => $quantity,
					'fixed_price' => $fixed_price,
					'discount_type' => $discount_type,
					'discount_value' => $discount_value,
					'discount_amount' => $discount_amount,
					'total_price' => $total_price
				]
			]);
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Gagal memperbarui data item.'
			]);
		}
	}


	public function approvePurchaseOrderTempoDo($id)
	{
		$result = $this->ModelPurchasing->approvePurchaseOrderTempoDo($id);
	}


	public function getOrdersByMonth()
	{
		$month = $this->input->get('month') ?: date('Y-m');
		$export_type = $this->input->get('export');
		$company = $this->input->get('company');

		$db_oriskin = $this->load->database('oriskin', true);

		try {

			$params = [$month];
			$companyWhere = '';
			if (!empty($company)) {
				$companyWhere = ' AND r.companyid = ?';
				$params[] = $company;
			}
			$query = $db_oriskin->query("
				SELECT 
					po.id AS orderid,
					po.orderdate,
					po.order_number,
					d.companyname,
					e.warehouse_name AS outlet,
					CASE 
						WHEN f.name IS NOT NULL THEN f.name
						ELSE 'E-COMMERCE'
					END AS vendorname,
					po.ongkir,
					po.other_cost,
					ISNULL((
						SELECT SUM(b.total_price)
						FROM purchase_order_items b 
						WHERE b.purchaseorderid = po.id
					), 0) AS total_item_amount
				FROM purchase_order po
				INNER JOIN purchase_request r ON r.id = po.purchaserequestid
				LEFT JOIN mscompany d ON d.id = r.companyid
				LEFT JOIN mswarehouse e ON r.warehouseid = e.id
				LEFT JOIN mssupplier f ON po.supplierid = f.id
				WHERE CONVERT(varchar(7), po.orderdate, 120) = ?
					AND po.status = 3
					$companyWhere
				ORDER BY po.orderdate DESC
			", $params);

			if (!$query) {
				throw new Exception('Query PO gagal');
			}

			$poData = $query->result_array();

			if (empty($poData)) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode([
						'status' => true,
						'month' => $month,
						'data' => []
					]));
				return;
			}

			// Ambil order IDs
			$orderIds = array_column($poData, 'orderid');
			$placeholders = implode(',', array_fill(0, count($orderIds), '?'));

			// Query items
			$itemsQuery = $db_oriskin->query("
                SELECT 
                    b.purchaseorderid,
                    pri.quantity AS order_quantity,
                    CASE 
                        WHEN aui.id IS NOT NULL THEN ui2.name 
                        ELSE ui.name 
                    END AS satuan_order,
                    CASE 
                        WHEN aui.id IS NOT NULL THEN pri.quantity * aui.qtytouom 
                        ELSE pri.quantity 
                    END AS quantity,
                    ui.name,
                    mi.name AS itemname,
                    b.fixed_price AS itemprice,
                    b.total_price AS totalprice,
                    b.discount_value AS discount
                FROM purchase_order_items b
                INNER JOIN purchase_request_items pri ON b.purchaserequestitemid = pri.id
                LEFT JOIN msingredients mi ON pri.itemid = mi.id
                LEFT JOIN msunitingredients ui ON mi.unitid = ui.id
                LEFT JOIN alternativeunitingredient aui ON pri.alternativeunitid = aui.id
                LEFT JOIN msunitingredients ui2 ON aui.unitid = ui2.id
                WHERE b.purchaseorderid IN ($placeholders)
            ", $orderIds);

			$allItems = $itemsQuery->result_array();

			// Group items
			$itemsByOrder = [];
			foreach ($allItems as $item) {
				$orderId = $item['purchaseorderid'];
				unset($item['purchaseorderid']);
				$itemsByOrder[$orderId][] = $item;
			}

			// Process data
			foreach ($poData as &$po) {
				$orderId = $po['orderid'];
				$po['items'] = $itemsByOrder[$orderId] ?? [];

				$totalItemAmount = (float) $po['total_item_amount'];
				$ongkir = (float) ($po['ongkir'] ?? 0);
				$otherCost = (float) ($po['other_cost'] ?? 0);

				$po['total_amount'] = $totalItemAmount + $ongkir + $otherCost;
				$po['orderdate_formatted'] = date('d/m/Y', strtotime($po['orderdate']));
			}

			// Jika export PDF
			if ($export_type === 'pdf') {
				return $this->generate_pdf($poData, $month);
			}

			// Jika export Excel
			if ($export_type === 'excel') {
				return $this->generate_excel($poData, $month);
			}

			// Return JSON untuk tampilan normal
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode([
					'status' => true,
					'month' => $month,
					'data' => $poData
				]));

		} catch (Exception $e) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode([
					'status' => false,
					'message' => $e->getMessage()
				]));
		}
	}



	// Generate PDF dengan tampilan modern
	private function generate_pdf($data, $month)
	{
		$this->load->library('Ltcpdf');

		// Create new PDF document
		$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// Set document information
		$pdf->SetCreator('Sistem Purchasing');
		$pdf->SetAuthor('Purchasing Department');
		$pdf->SetTitle('Laporan PO - ' . $month);
		$pdf->SetSubject('Laporan Purchase Order');

		// Set margins untuk landscape
		$pdf->SetMargins(10, 15, 10);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);

		// Set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 15);

		// Add a page
		$pdf->AddPage();

		// Set some content
		$html = $this->load->view('/content/Purchasing/reportOrderMonthlyPdf', [
			'data' => $data,
			'month' => $month
		], TRUE);

		// Output HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		// Close and output PDF document
		$pdf->Output('laporan_po_modern_' . $month . '.pdf', 'D');
	}



}


