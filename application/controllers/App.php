<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Controller
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
		#S: tambahan untuk bisa post/ajax
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Max-Age: 1000');
		header('Access-Control-Allow-Headers: Content-Type');
		#E: tambahan untuk bisa post/ajax
		$this->load->model('MApp');
		$this->load->library('Utility');
		$this->load->library('Datatables');
		#waktu local
		date_default_timezone_set('Asia/Jakarta');
		#waktu server (hosting)
		//date_default_timezone_set('Etc/GMT+7');
	}

	public function index()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		if ($this->session->userdata('is_login') == true) {
			$db_oriskin = $this->load->database('oriskin', true);
			$userid = $this->session->userdata('userid');
			$locationid = $this->session->userdata('locationid');
			$query = $db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
			$locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';
			$locationList = $db_oriskin->query("SELECT DISTINCT id, name FROM mslocation WHERE id IN ($locationAccsesIds)")->result_array();
			$data['locationList'] = $locationList;
			$data['locationId'] = $locationid;
			$data['title'] = 'Beranda';
			$data['content'] = 'beranda';
			$data['userId'] = $userid;
			$data['notif'] = 0;
			$this->load->view('index', $data);
		} else {
			$this->load->view('login');
		}
	}

	public function set_ajax()
	{
		if ($this->input->is_ajax_request()) {
			$locationid = $this->input->post('locationid');
			if ($locationid) {
				$this->session->set_userdata('locationid', $locationid);
				echo json_encode(['status' => 'success']);
				return;
			}
		}
		http_response_code(400);
		echo json_encode(['status' => 'error']);
	}

	#S: Auth
	function doLogin()
	{
		#PHP v5.x
		//$this->load->library('encrypt');
		#PHP v7.x
		$username = $this->input->post('name', TRUE, TRUE);
		$password = $this->input->post('password', TRUE, TRUE);
		$data = $this->MApp->getData('login', $username, $password);

		if ($data) {
			$this->session->set_userdata('userid', $data->userid);
			$this->session->set_userdata('name', $data->name);
			$this->session->set_userdata('locationid', $data->locationid);
			$this->session->set_userdata('level', $data->level);
			$this->session->set_userdata('is_login', true);
		} else {
			$this->session->set_flashdata('pesan', 'username atau password salah...');
		}

		redirect(base_url());
	}

	function doLogout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}

	function show_404()
	{
		$this->output->set_status_header('404');
		$this->load->view('page_not_found');
	}

	#E: Auth

	function content($type = "", $param1 = "", $param2 = "")
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		if (!$this->session->userdata('is_login')) {
			$this->load->view('login');
		} else {
			switch ($type) {
				case 'ubah_password':
					$data['title'] = 'Ubah Password';
					$data['content'] = 'ubah_password';
					$data['mod'] = $type;
					break;
				case 'bookingtreatment':
					$data['title'] = 'Booking Treatment';
					$data['content'] = 'bookingtreatment';
					$data['mod'] = $type;
					break;
				case 'booking_add':
					$data['title'] = 'Input Booking Online';
					$data['content'] = 'booking_add';
					$data['mod'] = $type;
					break;
				case 'invoice_treatment':
					$data['title'] = 'Data Repeat Order';
					$data['content'] = 'invoice_treatment';
					$data['mod'] = $type;
					break;
				// Content Consultation History
				case 'consultationHistory':
					$data['title'] = 'consultationHistory';
					$data['content'] = 'consultationHistory';
					$data['mod'] = $type;
					break;
				case 'datarolessthan14days':
					$data['title'] = 'Data Repeat Order Less 14days';
					$data['content'] = 'datarolessthan14days';
					$data['mod'] = $type;
					break;
				case 'appt_doing':
					$data['title'] = 'Data Appt Doing';
					$data['content'] = 'appt_doing';
					$data['mod'] = $type;
					break;
				case 'summarydetailorder':
					$data['title'] = 'Summary Detail Order';
					$data['content'] = 'summaryreport';
					$data['mod'] = $type;
					break;
				case 'summaryreportdonedeal':
					$data['title'] = 'Summary Detail Order';
					$data['content'] = 'summaryreportdonedeal';
					$data['mod'] = $type;
					break;
				case 'detaildonedealdaily':
					$data['title'] = 'detaildonedealdaily';
					$data['content'] = 'detaildonedealdaily';
					$data['mod'] = $type;
					break;
				case 'detaildonedealdailyallclinic':
					$data['title'] = 'detaildonedealdailyallclinic';
					$data['content'] = 'detaildonedealdailyallclinic';
					$data['mod'] = $type;
					break;
				case 'summaryreport_RoDaily':
					$data['title'] = 'Summary Detail Order Daily';
					$data['content'] = 'summaryreport_RoDaily';
					$data['mod'] = $type;
					break;
				case 'guest':
					$data['title'] = 'Data Guest Oriskin';
					$data['content'] = 'guest';
					$data['mod'] = $type;
					break;
				case 'guest_add':
					$data['title'] = 'Input Guest Oriskin';
					$data['content'] = 'guest_add';
					$data['mod'] = $type;
					break;
				case 'summaryreportguestonline':
					$data['title'] = 'Summary Report Guest Online';
					$data['content'] = 'summaryreport_guest';
					$data['mod'] = $type;
					break;
				case 'refferal':
					$location_id = $this->session->userdata('locationid');
					$search = $this->input->post('search') ? $this->input->post('search') : " ";
					$data = [
						'listCustomer' => $this->MApp->getLinkCustomerRefferal($search, $location_id),
						'title' => 'LINK CUSTOMER REFFERAL/MGM CLINIC',
						'content' => 'refferal',
						'search' => $search,
						'type' => $type,
					];
					$data['mod'] = $type;
					break;
				case 'linkDocter':
					$location_id = $this->session->userdata('locationid');
					$data = [
						'listDocter' => $this->MApp->getLinkDocter($location_id),
						'title' => 'LINK DOKTER',
						'content' => 'linkDocter',
						'type' => $type,
					];
					$data['mod'] = $type;
					break;
				case 'listLinkRegistrasiConsultant':
					$location_id = $this->session->userdata('locationid');
					$data = [
						'listDocter' => $this->MApp->getLinkRegistrasiConsultant($location_id),
						'title' => 'LIST LINK REGISTRASI CONSULTANT',
						'content' => 'listLinkRegistrasiConsultant',
						'type' => $type,
					];
					$data['mod'] = $type;
					break;
				case 'refferal_add':
					$data['title'] = 'Input Refferal';
					$data['content'] = 'refferal_add';
					$data['mod'] = $type;
					break;
				case 'databookingtreatment':
					$data['title'] = 'Booking Treatment';
					$data['content'] = 'databookingtreatment';
					$data['mod'] = $type;
					break;
				case 'callforappt':
					$data['title'] = 'Call For Appt Doing';
					$data['content'] = 'callforappt';
					$data['mod'] = $type;
					break;
				case 'datamissguest':
					$data['title'] = 'Data Miss Guest';
					$data['content'] = 'datamissguest';
					$data['mod'] = $type;
					break;
				case 'datapotentialnew':
					$data['title'] = 'Data New Leaver';
					$data['content'] = 'datapotentialnew';
					$data['mod'] = $type;
					break;
				case 'databodrangeclinic':
					$data['title'] = 'Data Birth of Date';
					$data['content'] = 'databodrangeclinic';
					$data['mod'] = $type;
					break;
				case 'updateemail':
					$data['title'] = 'Update Email Customer';
					$data['content'] = 'updateemail';
					$data['mod'] = $type;
					break;
				case 'customerPoint':
					$data['title'] = 'Customer Point';
					$data['content'] = 'customerPoint';
					$data['mod'] = $type;
					break;
				case 'refferal_from_link':
					$data['title'] = 'Data Refferal From Link';
					$data['content'] = 'refferal_from_link';
					$data['mod'] = $type;
					break;
				case 'refferal_employee':
					$data['title'] = 'Get Link Team Unit';
					$data['content'] = 'refferal_employee';
					$data['mod'] = $type;
					break;
				case 'datarecurring':
					$data['title'] = 'Data Recurring';
					$data['content'] = 'datarecurring';
					$data['mod'] = $type;
					break;
				case 'guestfromlink':
					$location_id = $this->session->userdata('locationid');
					$data = [
						'listGuestFromLinkRefferal' => $this->MApp->getGuestFromLinkRefferal($location_id),
						'title' => 'GUEST FROM REFFERAL LINK',
						'content' => 'guestfromlink',
					];
					$data['mod'] = $type;
					break;
				case 'guestfromlinkemplo':
					$data['title'] = 'Data Guest from Employee LINK';
					$data['content'] = 'guestfromlinkemplo';
					$data['mod'] = $type;
					break;
				case 'linkforpromo':
					$data['title'] = 'Data Link For Promo Oriskin';
					$data['content'] = 'linkforpromo';
					$data['mod'] = $type;
					break;
				case 'doingverification':
					$data['title'] = 'Data Doing Verification';
					$data['content'] = 'doingverification';
					$data['mod'] = $type;
					break;
				case 'erm':
					$data['csrf'] = array(
						'name' => $this->security->get_csrf_token_name(),
						'hash' => $this->security->get_csrf_hash()
					);
					$data['title'] = 'Input Talent Oriskin';
					$data['content'] = 'erm';
					$data['mod'] = $type;
					break;
				case 'new_menu':
					$data['title'] = 'ELECTRONIC MEDICAL RECORD';
					$data['content'] = 'new_menu';
					$data['mod'] = $type;
					break;
				case 'new_menu_dev':
					$data['title'] = 'ELECTRONIC MEDICAL RECORD';
					$data['content'] = 'new_menu_dev';
					$data['mod'] = $type;
					break;
				case 'data_new_menu':
					$data['title'] = 'ELECTRONIC MEDICAL RECORD';
					$data['content'] = 'data_new_menu';
					$data['mod'] = $type;
					break;

				case 'dataappt_bycc':
					$data['title'] = 'DATA APPT BY CUSTOMER CARE';
					$data['content'] = 'dataappt_bycc';
					$data['mod'] = $type;
					break;

				case 'reportdetailnewlc':
					$data['title'] = 'DATA REPORT DETAIL NEW LC VS DOING';
					$data['content'] = 'reportdetailnewlc';
					$data['mod'] = $type;
					break;
				case 'lcwithonemembershipactive':
					$data['title'] = 'DATA LC WITH ONE MEMBERSHIP ACTIVE';
					$data['content'] = 'lcwithonemembershipactive';
					$data['mod'] = $type;
					break;
				case 'callapptfd':
					$locationid = $this->session->userdata('locationid');
					$currentMonth = date('Y-m');
					$data['listCallAppt'] = $this->MApp->getReportCallAppt($currentMonth, $locationid, 1);
					$data['title'] = 'CALL MEMBER ACTIVE';
					$data['content'] = 'callapptfd';
					$data['mod'] = $type;
					break;
				case 'datanew6month':
					$data['title'] = 'DATA NEW 6 MONTH';
					$data['content'] = 'datanew6month';
					$data['mod'] = $type;
					break;

				case 'call_appt_new_member_21days':
					$data['title'] = 'CALL DATA NEW MEMBER 21 DAYS';
					$data['content'] = 'call_appt_new_member_21days';
					$data['mod'] = $type;
					break;

				case 'refferalsales':
					$data['title'] = 'Report Refferal By Sales';
					$data['content'] = 'refferalsales';
					$data['mod'] = $type;
					break;

				case 'call_appt_retention_21days':
					$data['title'] = 'CALL DATA RETENTION 21 DAYS';
					$data['content'] = 'call_appt_retention_21days';
					$data['mod'] = $type;
					break;

				case 'call_appt_potential_21days':
					$data['title'] = 'CALL DATA POTENTIAL 21 DAYS';
					$data['content'] = 'call_appt_potential_21days';
					$data['mod'] = $type;
					break;
				case 'call_appt_not_active_21days':
					$locationid = $this->session->userdata('locationid');
					$locationId = $this->input->post('locationId') ? $this->input->post('locationId') : $locationid;
					$currentMonth = date('Y-m');
					$data['listCallAppt'] = $this->MApp->getReportCallAppt($currentMonth, $locationId, 2);
					$data['title'] = 'CALL DATA NOT ACTIVE 21 DAYS';
					$data['content'] = 'call_appt_not_active_21days';
					$data['locationList'] = $this->MApp->get_location_list();
					$data['locationId'] = $locationId;
					$data['mod'] = $type;
					break;
				case 'call_appt_potential':
					$data['title'] = 'CALL DATA POTENTIAL';
					$data['content'] = 'call_appt_potential';
					$data['mod'] = $type;
					break;
				case 'stock_weekly':
					$data['title'] = 'STOCK WEEKLY';
					$data['content'] = 'stock_weekly';
					$data['mod'] = $type;
					break;
				case 'stock_weekly_dev':
					$data['title'] = 'STOCK WEEKLY';
					$data['content'] = 'stock_weekly_dev';
					$data['mod'] = $type;
					break;
				case 'reportbookingtreatment':
					$data['title'] = 'Report Booking';
					$data['content'] = 'reportbookingtreatment';
					$data['mod'] = $type;
					break;
				case 'stock':
					$data['title'] = 'Stock Ingredients';
					$data['content'] = 'stock_ingredients';
					$data['mod'] = $type;
					break;
				case 'redeem_voucher':
					$data['title'] = 'Redeem Voucher';
					$data['content'] = 'redeem_voucher';
					$data['mod'] = $type;
					break;
				case 'report_ingredients':
					$data['title'] = 'Report Ingredients';
					$data['content'] = 'report_ingredients';
					$data['mod'] = $type;
					break;
				case 'summaryfirstappt':
					$data['title'] = 'Detail H-1 Appt Clinic';
					$data['content'] = 'summaryfirstappt';
					$data['mod'] = $type;
					break;
				case 'report_consultation_docter':
					$data['title'] = 'Report Consultation Docter';
					$data['content'] = 'report_consultation_docter';
					$data['mod'] = $type;
					break;
				case 'qtyBotox':
					$data['title'] = 'Perkalian Botox';
					$data['content'] = 'qtyBotox';
					$data['mod'] = $type;
					break;
				case 'createSelling':
					$data['title'] = 'Tambah Transaksi';
					$data['content'] = 'createSelling';
					$data['mod'] = $type;
					break;
				case 'dailySalesReport':
					$data['title'] = 'Daily Sales Report';
					$data['content'] = 'dailySalesReport';
					$data['mod'] = $type;
					break;
				case 'dailySalesReconciliation':
					$data['title'] = 'RECONCILIATION';
					$data['content'] = 'dailySalesReconciliation';
					$data['mod'] = $type;
					break;
				case 'reportDoingCommission':
					$location_id = $this->session->userdata('locationid');
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-01');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$outletId = $this->input->post('locationId') ? $this->input->post('locationId') : $location_id;

					$data = [
						'listHandWorkDokterTherapist' => $this->MApp->getReportHandWorkCommissionDokterTherapistPerMey2025($dateStart, $dateEnd, $outletId),
						'summaryHandWork' => $this->MApp->getReportSummaryHandWorkPerMey2025($dateStart, $dateEnd, $outletId),
						'staffEmployee' => $this->MApp->getStaffHandWork($dateStart, $dateEnd, $outletId),
						'title' => 'REPORT HAND WORK COMMISSION DOKTER & THERAPIST',
						'content' => 'reportDoingCommission',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd,
						'outletId' => $outletId,
						'locationList' => $this->MApp->get_location_list(),
					];
					$data['mod'] = $type;
					break;
				case 'summaryRevenuePerDay':
					$data['title'] = 'Report Summary Revenue Per Day';
					$data['content'] = 'summaryRevenuePerDay';
					$data['mod'] = $type;
					break;
				case 'createDownPayment':
					$location_id = $this->session->userdata('locationid');
					$level = $this->session->userdata('level');
					$data = [
						'title' => 'Data Entry',
						'location_id' => $location_id,
						'level' => $level,
						'location_list' => $this->MApp->get_location_list(),
						'city_list' => $this->MApp->get_city_list(),
						'product_membership_list' => $this->MApp->get_product_membership_list(),
						'product_treatment_list' => $this->MApp->get_product_treatment_list(1),
						'product_retail_list' => $this->MApp->get_product_retail_list(),
						'payment_list' => $this->MApp->get_payment_list($location_id),
						'edc_list' => $this->MApp->get_edc_list($location_id),
						'consultant_list' => $this->MApp->get_consultant_list($location_id),
						'consultant_list_retail' => $this->MApp->get_consultant_list_for_retail($location_id),
						'card_list' => $this->MApp->get_card_list(),
						'bank_list' => $this->MApp->get_bank_list(),
						'installment_list' => $this->MApp->get_insatllment_list(),
						'discount_reason_list' => $this->MApp->get_discount_reason_list(),
						'frontdesk_list' => $this->MApp->get_frontdesk_list($location_id),
						'doctor_list' => $this->MApp->get_doctor_list($location_id),
						'treatmentDp_list' => $this->MApp->get_treatmentDp_list($location_id),
						'membershipDp_list' => $this->MApp->get_membershipDp_list($location_id),
						'retailDp_list' => $this->MApp->get_retailDp_list($location_id),
						'type_list' => $this->MApp->get_type_list(),
						'gender_list' => $this->MApp->get_gender_list(),
						'province_list' => $this->MApp->get_province_list(),
						'talent_list' => $this->MApp->get_talent_list(),
						'adv_list' => $this->MApp->get_adv_list(),
						'content' => 'createDownPayment',
					];
					$data['mod'] = $type;
					break;
				case 'transactionTreatmentToday':
					$data['title'] = 'Transaction Treatment Today';
					$data['content'] = 'transactionTreatmentToday';
					$data['mod'] = $type;
					break;
				case 'transactionTodayPaket':
					$data['title'] = 'Transaction Package Today';
					$data['content'] = 'transactionTodayPaket';
					$data['mod'] = $type;
					break;
				case 'transactionTodayRetail':
					$data['title'] = 'Transaction Product Today';
					$data['content'] = 'transactionTodayRetail';
					$data['mod'] = $type;
					break;
				case 'doingTodayFinish':
					$data['title'] = 'Doing Finish Today';
					$data['content'] = 'doingTodayFinish';
					$data['mod'] = $type;
					break;
				case 'managementEmployee':
					$data['title'] = 'Management Employee';
					$data['content'] = 'managementEmployee';
					$data['mod'] = $type;
					break;
				case 'reportGuestOnlineAdminCso':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'reportGuestOnlineAdminCso' => $this->MApp->getReportGuestOnlineAdminCso($dateStart, $dateEnd, 1),
						'reportGuestOnlineAdminCsoSummary' => $this->MApp->getReportGuestOnlineAdminCsoSummary($dateStart, $dateEnd, 1),
						'reportGuestOnlineAdminCsoByRegister' => $this->MApp->getReportGuestOnlineAdminCsoByRegister($dateStart, $dateEnd, 1),
						'title' => 'REPORT GUEST ADMIN',
						'location_list' => $this->MApp->get_location_list(),
						'adv_list' => $this->MApp->get_adv_list(),
						'content' => 'reportGuestOnlineAdminCso',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'reportGuestShow':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'reportGuestShow' => $this->MApp->getReportGuestShow($dateStart, $dateEnd),
						'reportGuestShowSummary' => $this->MApp->getReportGuestShowSummary($dateStart, $dateEnd),
						'reportTopSpender' => $this->MApp->getReportTopSpender($dateStart, $dateEnd),
						'title' => 'REPORT GUEST SHOW JOIN',
						'location_list' => $this->MApp->get_location_list(),
						'adv_list' => $this->MApp->get_adv_list(),
						'employee' => $this->MApp->getEmployeeRefferal($dateStart, $dateEnd),
						'content' => 'reportGuestShow',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'reportUsedIngridients':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'reportUsedIngridients' => $this->MApp->getReportUsedIngridients($dateStart, $dateEnd),
						'title' => 'REPORT USED INGRIDIENTS',
						'location_list' => $this->MApp->get_location_list(),
						'treatment' => $this->MApp->getTreatmentPrepaid($dateStart, $dateEnd),
						'ingridients' => $this->MApp->getIngridientsPrepaid($dateStart, $dateEnd),
						'content' => 'reportUsedIngridients',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'reportUsedIngridientsIncludeCost':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'reportUsedIngridientsIncludeCost' => $this->MApp->getReportUsedIngridientsIncludeCost($dateStart, $dateEnd),
						'title' => 'REPORT USED INGRIDIENTS INCLUDE COST',
						'location_list' => $this->MApp->get_location_list(),
						'ingridients' => $this->MApp->getIngridientsPrepaidIncludeCost($dateStart, $dateEnd),
						'content' => 'reportUsedIngredientsIncludeCost',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'listNewCustomer':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$locationid = $this->session->userdata('locationid');
					$data = [
						'listNewCustomer' => $this->MApp->getReportNewCustomer($dateStart, $dateEnd, 1, $locationid, 2),
						'title' => 'REPORT NEW CUSTOMER',
						'location_list' => $this->MApp->get_location_list(),
						'adv_list' => $this->MApp->get_adv_list(),
						'content' => 'listNewCustomer',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'reportGuestOnlineAdminCsoNotShow':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'reportGuestOnlineAdminCsoNotShow' => $this->MApp->getReportGuestOnlineAdminCsoByRegister($dateStart, $dateEnd, 1),
						'title' => 'REPORT GUEST ADMIN',
						'location_list' => $this->MApp->get_location_list(),
						'adv_list' => $this->MApp->get_adv_list(),
						'content' => 'reportGuestOnlineAdminCsoNotShow',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'reportGuestCustomerServiceOnline':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'reportGuestOnlineAdminCso' => $this->MApp->getReportGuestOnlineAdminCso($dateStart, $dateEnd, 2),
						'reportGuestOnlineAdminCsoSummary' => $this->MApp->getReportGuestOnlineAdminCsoSummary($dateStart, $dateEnd, 2),
						// 'reportGuestOnlineAdminCsoByRegister' => $this->MApp->getReportGuestOnlineAdminCsoByRegister($dateStart, $dateEnd, 2),
						'title' => 'REPORT GUEST ADMIN',
						'location_list' => $this->MApp->get_location_list(),
						'adv_list' => $this->MApp->get_adv_list(),
						'content' => 'reportGuestCustomerServiceOnline',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'reportGuestEvent':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$locationId = $this->session->userdata('locationid');
					$data = [
						'reportGuestAdmin' => $this->MApp->getReportGuestEvent($dateStart, $dateEnd, $locationId, 1),
						'reportGuestAdminSummary' => $this->MApp->getReportGuestEventSummary($dateStart, $dateEnd, $locationId, 3),
						'reportGuestAdminSummaryManager' => $this->MApp->getReportGuestEventSummaryManager($dateStart, $dateEnd, $locationId, 4),
						'title' => 'REPORT GUEST EVENT',
						'location_list' => $this->MApp->get_location_list(),
						'adv_list' => $this->MApp->get_adv_list(),
						'content' => 'reportGuestEvent',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'reportGuestCustomerServiceOnlineNotShow':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'reportGuestOnlineAdminCsoNotShow' => $this->MApp->getReportGuestOnlineAdminCsoByRegister($dateStart, $dateEnd, 2),
						'title' => 'REPORT GUEST ADMIN',
						'location_list' => $this->MApp->get_location_list(),
						'adv_list' => $this->MApp->get_adv_list(),
						'content' => 'reportGuestCustomerServiceOnlineNotShow',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'reportNewGuestNoAppointment':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'reportNewGuestNoAppointment' => $this->MApp->getReportNewGuestNoAppointment($dateStart, $dateEnd),
						'title' => 'REPORT GUEST NO APPOINTMENT',
						'location_list' => $this->MApp->get_location_list(),
						'adv_list' => $this->MApp->get_adv_list(),
						'content' => 'reportNewGuestNoAppointment',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'reportGuestEventNotShow':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'reportGuestOnlineAdminCsoNotShow' => $this->MApp->getReportGuestOnlineAdminCsoByRegister($dateStart, $dateEnd, 3),
						'title' => 'REPORT GUEST EVENT NOT SHOW',
						'location_list' => $this->MApp->get_location_list(),
						'adv_list' => $this->MApp->get_adv_list(),
						'content' => 'reportGuestEventNotShow',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'appointment':
					$data['title'] = 'Book Appointment';
					$data['content'] = 'appointment';
					$data['mod'] = $type;
					break;
				case 'invoiceMembership':
					$location_id = $this->session->userdata('locationid');
					$data['payment_list'] = $this->MApp->get_payment_list($location_id);
					$data['title'] = 'Invoice Pembelian Package';
					$data['content'] = 'invoiceMembership';
					$data['mod'] = $type;
					break;
				case 'invoiceTreatment':
					$location_id = $this->session->userdata('locationid');
					$data['payment_list'] = $this->MApp->get_payment_list($location_id);
					$data['title'] = 'Invoice Pembelian Treatment';
					$data['content'] = 'invoiceTreatment';
					$data['mod'] = $type;
					break;
				case 'invoiceRetail':
					$location_id = $this->session->userdata('locationid');
					$data['payment_list'] = $this->MApp->get_payment_list($location_id);
					$data['title'] = 'Invoice Pembelian Retail';
					$data['content'] = 'invoiceRetail';
					$data['mod'] = $type;
					break;
				case 'invoiceDownMembership':
					$location_id = $this->session->userdata('locationid');
					$data['payment_list'] = $this->MApp->get_payment_list($location_id);
					$data['title'] = 'Invoice Down Payment Package';
					$data['content'] = 'invoiceDownMembership';
					$data['mod'] = $type;
					break;
				case 'invoiceDownTreatment':
					$location_id = $this->session->userdata('locationid');
					$data['payment_list'] = $this->MApp->get_payment_list($location_id);
					$data['title'] = 'Invoice Down Payment Treatment';
					$data['content'] = 'invoiceDownTreatment';
					$data['mod'] = $type;
					break;
				case 'invoiceDownProduct':
					$location_id = $this->session->userdata('locationid');
					$data['payment_list'] = $this->MApp->get_payment_list($location_id);
					$data['title'] = 'Invoice Down Payment Retail';
					$data['content'] = 'invoiceDownProduct';
					$data['mod'] = $type;
					break;
				case 'reportAppointmentCustomerCareOnline':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-01');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data['appointmentList'] = $this->MApp->getReportAppointmentCustomerCareOnline($dateStart, $dateEnd);
					$data['location_list'] = $this->MApp->get_location_list();
					$data['title'] = 'REPORT APPOINTMENT';
					$data['dateStart'] = $dateStart;
					$data['dateEnd'] = $dateEnd;
					$data['content'] = 'reportAppointmentCustomerCareOnline';
					$data['mod'] = $type;
					break;
				case 'bookAppointment':
					$data['title'] = 'Book Appointment';

					$db_oriskin = $this->load->database('oriskin', true);
					$userid = $this->session->userdata('userid');
					$level = $this->session->userdata('level');

					$query = $db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
					$locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';

					if ($level == 2) {
						$locationListAppointment = $db_oriskin->query("SELECT DISTINCT id, shortname as name,  
															CASE id 
																WHEN 9 THEN 1
																WHEN 14 THEN 2
																WHEN 15 THEN 3
																WHEN 16 THEN 4
																WHEN 17 THEN 5
																WHEN 18 THEN 6
																WHEN 24 THEN 7
																WHEN 19 THEN 8
																WHEN 20 THEN 9
																WHEN 11 THEN 10
																WHEN 12 THEN 11
																WHEN 13 THEN 12
																ELSE 999 
															END AS sort_order 
															FROM mslocation WHERE id IN ($locationAccsesIds) ORDER BY sort_order;")->result_array();
					} else {
						$locationListAppointment = $db_oriskin->query("SELECT DISTINCT id, name FROM mslocation WHERE id IN ($locationAccsesIds)")->result_array();
					}


					$data['locationListAppointment'] = $locationListAppointment;
					$data['level'] = $level;
					$data['locationId'] = $locationListAppointment[0]['id'];

					$data['content'] = 'bookAppointment';
					$data['mod'] = $type;
					break;
				case 'detailCustomer':
					$location_id = $this->session->userdata('locationid');
					$data = [
						'location_id' => $location_id,
						'location_list' => $this->MApp->get_location_list(),
						'city_list' => $this->MApp->get_city_list(),
						'product_membership_list' => $this->MApp->get_product_membership_list(),
						'product_treatment_list' => $this->MApp->get_product_treatment_list(2),
						'product_retail_list' => $this->MApp->get_product_retail_list(),
						'payment_list' => $this->MApp->get_payment_list($location_id),
						'edc_list' => $this->MApp->get_edc_list($location_id),
						'consultant_list' => $this->MApp->get_consultant_list($location_id),
						'card_list' => $this->MApp->get_card_list(),
						'bank_list' => $this->MApp->get_bank_list(),
						'installment_list' => $this->MApp->get_insatllment_list(),
						'discount_reason_list' => $this->MApp->get_discount_reason_list(),
						'frontdesk_list' => $this->MApp->get_frontdesk_list($location_id),
						'doctor_list' => $this->MApp->get_doctor_list($location_id),
						'treatmentDp_list' => $this->MApp->get_treatmentDp_list($location_id),
						'membershipDp_list' => $this->MApp->get_membershipDp_list($location_id),
						'retailDp_list' => $this->MApp->get_retailDp_list($location_id),
						'type_list' => $this->MApp->get_type_list(),
						'gender_list' => $this->MApp->get_gender_list(),
						'province_list' => $this->MApp->get_province_list(),
						'talent_list' => $this->MApp->get_talent_list(),
						'adv_list' => $this->MApp->get_adv_list(),
					];
					$data['title'] = 'Detail Customer Package';
					$data['content'] = 'detailCustomer';
					$data['mod'] = $type;
					break;
				case 'reportGuestMarketing':
					$data = [
						'title' => 'REPORT GUEST MARKETING',
						'content' => 'reportGuestMarketing',
						'mod' => $type
					];
					break;
				case 'listExpend':
					$data = [
						'title' => 'REPORT GUEST MARKETING',
						'content' => 'listExpend',
						'expendCostType' => $this->MApp->getExpendCostType(),
						'locationList' => $this->MApp->getLocationList(),
						'mod' => $type
					];
					break;
				case 'reportProfitAndLoss':
					$data = [
						'title' => 'REPORT PROFIT AND LOSS',
						'content' => 'reportProfitAndLoss',
						'locationList' => $this->MApp->getLocationList(),
						'mod' => $type
					];
					break;
				case 'linkAffiliate':
					$data = [
						'linkAffiliate' => $this->MApp->getEmployeeAffiliate(),
						'employeeMarketing' => $this->MApp->getEmployeeMarketing(),
						'title' => 'LINK AFFILIATE',
						'content' => 'linkAffiliate',
					];
					$data['mod'] = $type;
					break;
				case 'addAffiliate':
					$data = [
						'employeeMarketing' => $this->MApp->getEmployeeMarketing(),
						'title' => 'ADD AFFILIATE',
						'content' => 'addAffiliate',
					];
					$data['mod'] = $type;
					break;
				case 'addEmployeeAppointment':
					$location_id = $this->session->userdata('locationid');
					$locationId = $this->input->post('locationId') ? $this->input->post('locationId') : $location_id;
					$data = [
						'employeeForAppointment' => $this->MApp->getEmployeeForAppointment($locationId),
						'title' => 'ADD EMPLOYEE APPOINTMENT',
						'locationId' => $locationId,
						'content' => 'addEmployeeAppointment',
					];
					$data['mod'] = $type;
					break;
				case 'addEmployeeInvoice':
					$location_id = $this->session->userdata('locationid');
					$locationId = $this->input->post('locationId') ? $this->input->post('locationId') : $location_id;
					$data = [
						'employeeForInvoice' => $this->MApp->getEmployeeForInvoice($locationId),
						'title' => 'ADD EMPLOYEE INVOICE',
						'locationId' => $locationId,
						'content' => 'addEmployeeInvoice',
					];
					$data['mod'] = $type;
					break;
				case 'stockOut':
					$location_id = $this->session->userdata('locationid');
					$level = $this->session->userdata('level');
					$data = [
						'employeeStockOut' => $this->MApp->getEmployeeStockOut($location_id, $level),
						'locationListEmployee' => $this->MApp->get_location_list_purchasing(),
						// 'locationList' => $this->MApp->get_location_list_purchasings($location_id),
						'title' => 'STOCK OUT',
						'content' => 'stockOut',
						'location_id' => $location_id,
						'level' => $level,
					];
					$data['mod'] = $type;
					break;
				case 'stockOutDetail':
					$id = $this->input->get('stockOutId', TRUE);
					$location_id = $this->session->userdata('locationid');
					$level = $this->session->userdata('level');
					$data = [
						'employeeStockOut' => $this->MApp->getEmployeeStockOut($location_id, $level),
						'locationListEmployee' => $this->MApp->get_location_list_purchasing(),
						'locationList' => $this->MApp->get_location_list_purchasing(),
						'detailGeneral' => $this->MApp->getDetailGeneralStockOut($id),
						'detailStockOut' => $this->MApp->getDetailStockOut($id),
						'title' => 'STOCK OUT DETAIL',
						'content' => 'stockOutDetail',
					];
					$data['mod'] = $type;
					break;
				case 'stockIn':
					$location_id = $this->session->userdata('locationid');
					$level = $this->session->userdata('level');
					$data = [
						'employeeStockOut' => $this->MApp->getEmployeeStockOut($location_id, $level),
						'locationListEmployee' => $this->MApp->get_location_list_purchasing(),
						'locationList' => $this->MApp->get_location_list_purchasing(),
						'supplierlist' => $this->MApp->get_supplier_list(),
						'title' => 'STOCK IN',
						'content' => 'stockIn',
					];
					$data['mod'] = $type;
					break;
				case 'stockInDetail':
					$id = $this->input->get('stockInId', TRUE);
					$location_id = $this->session->userdata('locationid');
					$level = $this->session->userdata('level');
					$data = [
						'employeeStockOut' => $this->MApp->getEmployeeStockOut($location_id, $level),
						'detailGeneral' => $this->MApp->getDetailGeneralStockIn($id),
						'detailStockIn' => $this->MApp->getDetailStockIn($id),
						'locationListEmployee' => $this->MApp->get_location_list_purchasing(),
						'locationList' => $this->MApp->get_location_list_purchasing(),
						'supplierlist' => $this->MApp->get_supplier_list(),
						'title' => 'STOCK IN DETAIL',
						'content' => 'stockInDetail',
					];
					$data['mod'] = $type;
					break;
				case 'stockOutList':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'stockOutList' => $this->MApp->getListStockOut($dateStart, $dateEnd),
						'title' => 'STOCK OUT LIST',
						'content' => 'stockOutList',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'stockInList':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'stockInList' => $this->MApp->getListStockIn($dateStart, $dateEnd),
						'title' => 'STOCK IN LIST',
						'content' => 'stockInList',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'packageList':
					$data = [
						'packageList' => $this->MApp->getPackageList(),
						'title' => 'PACKAGE LIST',
						'content' => 'packageList',
					];
					$data['mod'] = $type;
					break;
				case 'packageDetail':
					$id = $this->input->get('packageId', TRUE);
					$productbenefitid = $this->input->get('productbenefitid', TRUE);
					$data = [
						'packageDetail' => $this->MApp->getPackageDetail($id),
						'benefitPackage' => $this->MApp->getBenefitPackage($productbenefitid),
						'title' => 'PACKAGE DETAIL',
						'content' => 'packageDetail',
					];
					$data['mod'] = $type;
					break;
				case 'detailIngredients':
					$id = $this->input->get('ingredientsId', TRUE);
					$data = [
						'detailIngredients' => $this->MApp->getIngredientsDetail($id),
						'uomList' => $this->MApp->getUomList(),
						'title' => 'ITEMS DETAIL',
						'content' => 'detailIngredients',
					];
					$data['mod'] = $type;
					break;
				case 'addPackage':
					$data = [
						'title' => 'ADD PACKAGE',
						'content' => 'addPackage',
					];
					$data['mod'] = $type;
					break;
				case 'serviceList':
					$type = $this->input->post('type') ? $this->input->post('type') : 1;
					$data = [
						'serviceList' => $this->MApp->getServiceList($type),
						'title' => 'SERVICE LIST',
						'content' => 'serviceList',
						'type' => $type,
					];
					$data['mod'] = $type;
					break;
				case 'listPrepaidFinished':
					$data = [
						'title' => 'LIST PREPAID FINISHED YESTERDAY',
						'content' => 'listPrepaidFinished',
						'type' => $type,
						'yes' => date('Y-m-d', strtotime('-1 day')),
						'loc' => $this->session->userdata('locationid')
					];
					$data['mod'] = $type;
					break;
				case 'retailList':
					$data = [
						'retailList' => $this->MApp->getRetailList(),
						'title' => 'RETAIL AND SALON LIST',
						'content' => 'retailList',
					];
					$data['mod'] = $type;
					break;
				case 'ingredientsList':
					$type = $this->input->post('type') ? $this->input->post('type') : 1;
					$data = [
						'ingredientsList' => $this->MApp->getIngredientsList($type),
						'title' => 'INGREDIENTS LIST',
						'content' => 'ingredientsList',
						'type' => $type,
					];
					$data['mod'] = $type;
					break;
				case 'serviceDetail':
					$id = $this->input->get('serviceId', TRUE);
					$ingredientscategoryid = $this->input->get('ingredientscategoryid', TRUE);
					$data = [
						'serviceDetail' => $this->MApp->getServiceDetail($id),
						'cogsService' => $this->MApp->getCogsService($ingredientscategoryid),
						'serviceGroup' => $this->MApp->getServiceGroup(),
						'title' => 'SERVICE DETAIL',
						'content' => 'serviceDetail',
					];
					$data['mod'] = $type;
					break;
				case 'detailLocation':
					$db_oriskin = $this->load->database('oriskin', true);
					$id = $this->input->get('locationid');
					$userid = $this->session->userdata('userid');

					$queryLocation = $db_oriskin->query("
						SELECT 
							a.*, 
							b.companyname AS companyname, 
							b.companycode AS companycode,
							c.warehouse_name AS warehousename, 
							c.warehouse_code AS warehousecode,
							d.name AS cityname, 
							e.name AS provincename,
							e.id AS provinceid
						FROM mslocation a
						LEFT JOIN mscompany b ON a.companyid = b.id
						LEFT JOIN mswarehouse c ON a.warehouseid = c.id
						LEFT JOIN mscity d ON a.cityid = d.id
						LEFT JOIN msprovince e ON d.provinceid = e.id
						WHERE a.id = ?
					", [$id]);

					$dataLocation = $queryLocation->row();
					$queryCity = $db_oriskin->query("
						SELECT id AS city_id, name AS cityname
						FROM mscity ");
					$dataCity = $queryCity->row();
					$data = [
						'detailLocation' => $dataLocation,
						'title' => 'LOCATION DETAIL',
						'userid' => $userid,
						'content' => 'detailLocation',
						'dataCity' => $dataCity,


					];
					$data['mod'] = $type;
					$data['cityList'] = $this->MApp->getCityList();
					break;
				case 'addService':
					$data = [
						'serviceGroup' => $this->MApp->getServiceGroup(),
						'title' => 'ADD SERVICE',
						'content' => 'addService',
					];
					$data['mod'] = $type;
					break;
				case 'addConsultation':
					$data = [
						'skincare' => $this->MApp->getSkinCare(),
						'pasttreatment' => $this->MApp->getPastTreatment(),
						'skincondition' => $this->MApp->getSkinCondition(),
						'occupied' => $this->MApp->getOccupied(),
						'nettincome' => $this->MApp->getNettIncome(),
						'advtracking' => $this->MApp->getAdvTracking(),
						'doctor' => $this->MApp->getDoctorConsultation(),
						'title' => 'ADD CONSULTATION',
						'content' => 'addConsultation',
					];
					$data['mod'] = $type;
					break;
				case 'addIngredients':
					$data = [
						'uomList' => $this->MApp->getUomList(),
						'title' => 'ADD ITEMS',
						'content' => 'addIngredients',
					];
					$data['mod'] = $type;
					break;
				case 'addInitialStock':
					$data = [
						'locationList' => $this->MApp->get_location_list(),
						'title' => 'ADD INITIAL STOCK',
						'content' => 'addInitialStock',
					];
					$data['mod'] = $type;
					break;
				case 'retailDetail':
					$id = $this->input->get('retailId', TRUE);
					$data = [
						'retailDetail' => $this->MApp->getRetailDetail($id),
						'title' => 'RETAIL DAN SALON DETAIL',
						'content' => 'retailDetail',
					];
					$data['mod'] = $type;
					break;
				case 'addRetail':
					$data = [
						'title' => 'ADD RETAIL',
						'content' => 'addRetail',
					];
					$data['mod'] = $type;
					break;
				case 'serviceSales':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$searchType = isset($_POST['searchType']) ? $_POST['searchType'] : 1;
					$data = [
						'serviceSales' => $this->MApp->getServiceSales($dateStart, $dateEnd, $searchType),
						'location_list' => $this->MApp->get_location_list(),
						'title' => 'SERVICE SALES',
						'content' => 'serviceSales',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd,
						'searchType' => $searchType
					];
					$data['mod'] = $type;
					break;
				case 'customerDetail':
					$id = $this->input->get('customerId', TRUE);
					$locationid = $this->session->userdata('locationid');
					$data = [
						'customerDetail' => $this->MApp->getCustomerDetail($id),
						'title' => 'Customer Detail',
						'content' => 'customerDetail',
					];
					$data['employeeDoing'] = $this->MApp->getEmployeeDoing($locationid);
					$data['mod'] = $type;
					break;
				case 'listEmployee':
					$data = [
						'listEmployee' => $this->MApp->getListEmployee(),
						'listEmployeeAppointment' => $this->MApp->getListEmployeeAppointment(),
						'listEmployeeInvoice' => $this->MApp->getListEmployeeInvoice(),
						'jobList' => $this->MApp->getJobList(),
						'locationListt' => $this->MApp->get_location_list_company(),
						'title' => 'List Employee',
						'content' => 'listEmployee',
					];
					$data['mod'] = $type;
					break;
				case 'listLocation':
					$data = [
						'listLocation' => $this->MApp->get_location_list_company(),
						'title' => 'LIST OUTLET',
						'content' => 'listLocation',
					];
					$data['mod'] = $type;
					break;
				case 'listTarget':
					$period = $this->input->post('period') ? $this->input->post('period') : date('Y-m');
					$data = [
						'listTargetOutlet' => $this->MApp->getTargetOutlet($period),
						'listTargetConsultant' => $this->MApp->getTargetConsultant($period),
						'title' => 'List Target Outlet & Consultant',
						'period' => $period,
						'content' => 'listTarget'
					];
					$data['mod'] = $type;
					break;
				case 'employeeDetail':
					$id = $this->input->get('employeeId', TRUE);
					$data = [
						'employeeDetail' => $this->MApp->getEmployeeDetail($id),
						'jobList' => $this->MApp->getJobList(),
						'locationListt' => $this->MApp->get_location_list_company(),
						'religionList' => $this->MApp->getReligionList(),
						'title' => 'Employee Detail',
						'content' => 'employeeDetail',
					];
					$data['mod'] = $type;
					break;
				case 'addEmployee':
					$data = [
						'jobList' => $this->MApp->getJobList(),
						'locationListt' => $this->MApp->get_location_list_company(),
						'religionList' => $this->MApp->getReligionList(),
						'title' => 'ADD EMPLOYEE',
						'content' => 'addEmployee',
					];
					$data['mod'] = $type;
					break;
				case 'addLocation':
					$userid = $this->session->userdata('userid');
					$data = [
						'cityList' => $this->MApp->getCityList(),
						'userid' => $userid,
						'title' => 'ADD LOCATION',
						'content' => 'addLocation',

					];
					$data['mod'] = $type;
					break;
				case 'reportRevenueBySales':
					$userid = $this->session->userdata('userid');
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'summaryRevenueBySales' => $this->MApp->getSummaryRevenueBySales($dateStart, $dateEnd, $userid),
						'detailRevenueBySales' => $this->MApp->getDetailRevenueBySales($dateStart, $dateEnd, $userid),
						'staffSalesInvoice' => $this->MApp->getStaffSalesInvoice($dateStart, $dateEnd, $userid),
						'title' => 'REVENUE BY SALES',
						'content' => 'reportRevenueBySales',
						'locationList' => $this->MApp->get_location_list(),
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'reportCommissionConsultant':
					$userid = $this->session->userdata('userid');
					$period = $this->input->post('period') ? $this->input->post('period') : date('Y-m');
					$start_date = $period . '-01';
					$end_date = date('Y-m-t', strtotime($start_date));
					$data = [
						'summaryRevenueBySales' => $this->MApp->getSummaryRevenueBySalesIncludeCommission($period, $userid),
						'detailRevenueBySales' => $this->MApp->getDetailRevenueBySalesIncludeCommission($period, $userid),
						'detailUnitNewMember' => $this->MApp->getDetailUnitNewMember($period, $userid),
						'staffSalesInvoice' => $this->MApp->getStaffSalesInvoice($start_date, $end_date, $userid),
						'title' => 'COMMISSION SALES',
						'content' => 'reportCommissionConsultant',
						'locationList' => $this->MApp->get_location_list(),
						'period' => $period
					];
					$data['mod'] = $type;
					break;
				case 'reportCommissionOM':
					$userid = $this->session->userdata('userid');
					$period = $this->input->post('period') ? $this->input->post('period') : date('Y-m');
					$data = [
						'summaryCommissionOm' => $this->MApp->getSummaryCommissionOm($period, $userid),
						'detailRevenueBySales' => $this->MApp->getDetailRevenueBySalesIncludeCommission($period, $userid),
						'detailUnitNewMember' => $this->MApp->getDetailUnitNewMember($period, $userid),
						'title' => 'COMMISSION OM',
						'content' => 'reportCommissionOM',
						'locationList' => $this->MApp->get_location_list(),
						'period' => $period
					];
					$data['mod'] = $type;
					break;
				case 'saleTicketDetail':
					$userid = $this->session->userdata('userid');
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');

					$locationId = $this->input->post('locationId') ? $this->input->post('locationId') : 9;

					$data = [
						'detailRevenueBySales' => $this->MApp->getSaleTicketDetail($dateStart, $dateEnd, $locationId),
						'title' => 'SALE TICKET DETAIL',
						'content' => 'saleTicketDetail',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd,
						'locationId' => $locationId,
						'locationList' => $this->MApp->get_location_list()
					];
					$data['mod'] = $type;
					break;
				case 'reportDoingNotInInvoiceLocation':
					$userid = $this->session->userdata('userid');
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'listDoingNotInInvoiceLocation' => $this->MApp->getReportDoingNotInInvoiceLocation($dateStart, $dateEnd, $userid),
						'title' => 'REPORT PREPAID NOT IN INVOICE LOCATION',
						'content' => 'reportDoingNotInInvoiceLocation',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'reportAppointmentDoingByClinic':
					$userid = $this->session->userdata('userid');
					$searchDate = $this->input->post('searchDate') ? $this->input->post('searchDate') : date('Y-m-d');
					$data = [
						'listAppointmentDoingByClinic' => $this->MApp->getReportAppointmentDoingByClinic($searchDate, $userid),
						'title' => 'REPORT APPOINTMENT DOING BY CLINIC',
						'content' => 'reportAppointmentDoingByClinic',
						'searchDate' => $searchDate
					];
					$data['mod'] = $type;
					break;
				case 'reportHandWorkCommissionDokterTherapist':
					$location_id = $this->session->userdata('locationid');
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-01');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$locationId = $this->input->post('locationId') ? $this->input->post('locationId') : $location_id;

					$data = [
						'listHandWorkDokterTherapist' => $this->MApp->getReportHandWorkCommissionDokterTherapist($dateStart, $dateEnd, $locationId),
						'listHandWorkTherapist' => $this->MApp->getReportHandWorkCommissionTherapist($dateStart, $dateEnd, $locationId),
						'summaryHandWork' => $this->MApp->getReportSummaryHandWork($dateStart, $dateEnd, $locationId),
						'staffEmployee' => $this->MApp->getStaffHandWork($dateStart, $dateEnd, $locationId),
						'title' => 'REPORT HAND WORK COMMISSION DOKTER & THERAPIST',
						'content' => 'reportHandWorkCommissionDokterTherapist',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd,
						'locationId' => $locationId,
						'locationList' => $this->MApp->get_location_list(),
					];
					$data['mod'] = $type;
					break;
				case 'reportCommissionAppointmentCSO':
					$locationIdDefault = $this->session->userdata('locationid');
					$period = $this->input->post('period') ? $this->input->post('period') : date('Y-m');
					$locationIdSearch = $this->input->post('locationIdSearch') ? $this->input->post('locationIdSearch') : $locationIdDefault;

					$data = [
						'listCommissionAppointmentCso' => $this->MApp->getReportCommissionApptShow($period, $locationIdSearch),
						'title' => 'REPORT COMMISSION CSO FROM DOING THERAPIST',
						'content' => 'reportCommissionAppointmentCSO',
						'period' => $period,
						'locationIdSearch' => $locationIdSearch,
						'locationList' => $this->MApp->get_location_list(),
					];
					$data['mod'] = $type;
					break;
				case 'reportPrescriptionDoctor':
					$userid = $this->session->userdata('userid');
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-01');
					;
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'listPrescriptionDoctor' => $this->MApp->getReportPrescriptionDoctor($dateStart, $dateEnd, $userid),
						'listPrescriptionDoctorSummary' => $this->MApp->getReportPrescriptionDoctorSummary($dateStart, $dateEnd, $userid),
						'title' => 'REPORT PRESCRIPTION DOCTER',
						'content' => 'reportPrescriptionDoctor',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd,
						'locationList' => $this->MApp->get_location_list(),
					];
					$data['mod'] = $type;
					break;
				case 'adjusmentTreatmentWess':
					$data = [
						'title' => 'ADJUSMENT TREATMENT WEZZ',
						'content' => 'adjusmentTreatmentWess',
						'locationList' => $this->MApp->get_location_list(),
					];
					$data['mod'] = $type;
					break;
				case 'changeTreatmentMixMax':
					$data = [
						'title' => 'CHANGE TREATMENT MIX MAX',
						'content' => 'changeTreatmentMixMax',
					];
					$data['mod'] = $type;
					break;
				case 'addTargetOutlet':
					$data = [
						'title' => 'ADD TARGET OUTLET',
						'content' => 'addTargetOutlet',
					];
					$data['mod'] = $type;
					break;
				case 'addTargetConsultant':
					$data = [
						'title' => 'ADD TARGET CONSULTANT',
						'content' => 'addTargetConsultant',
					];
					$data['mod'] = $type;
					break;
				case 'customerByLastDoing':
					$db_oriskin = $this->load->database('oriskin', true);
					$userid = $this->session->userdata('userid');
					$query = $db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
					$locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';

					$locationList = $db_oriskin->query("SELECT DISTINCT id, name FROM mslocation WHERE id IN ($locationAccsesIds)")->result_array();
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-01');
					;
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$locationId = $this->input->post('locationId') ? $this->input->post('locationId') : $locationList[0]['id'];

					$data = [
						'listCustomerByLastDoing' => $this->MApp->getCustomerByLastDoing($dateStart, $dateEnd, $locationId),
						'title' => 'REPORT CUSTOMER BY LAST DOING',
						'content' => 'customerByLastDoing',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd,
						'locationId' => $locationId,
						'locationList' => $locationList,
					];
					$data['mod'] = $type;
					break;
				case 'saleTicketList':
					$search = $this->input->post('search') ? $this->input->post('search') : "";
					$data = [
						'listSaleTicket' => $this->MApp->getListSaleTicket($search),
						'title' => 'SALE TICKET',
						'content' => 'saleTicketList',
						'search' => $search
					];
					$data['mod'] = $type;
					break;
				case 'balancePrepaidWess':
					$search = $this->input->post('search') ? $this->input->post('search') : "";
					$data = [
						'listSaleTicket' => $this->MApp->getBalancePrepaidWess($search),
						'title' => 'BALANCE PREPAID WESS',
						'content' => 'balancePrepaidWess',
						'search' => $search
					];
					$data['mod'] = $type;
					break;
				case 'reportCustomerTrial':
					$locationid = $this->session->userdata('locationid');
					$locationPost = $this->input->post('locationId') ? $this->input->post('locationId') : $locationid;
					$data = [
						'reportCustomerTrial' => $this->MApp->getReportCustomerTrial($locationPost),
						'title' => 'REPORT CUSTOMER TRIAL',
						'content' => 'reportCustomerTrial',
						'locationId' => $locationPost,
						'locationList' => $this->MApp->get_location_list(),
					];
					$data['mod'] = $type;
					break;
				case 'reportFilledLinkReview':
					$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-01');
					$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
					$data = [
						'summaryReview' => $this->MApp->getReportReviewSummary($dateStart, $dateEnd),
						'detailCustomerNotFill' => $this->MApp->getReportReviewNotReview($dateStart, $dateEnd),
						'detailCustomerFill' => $this->MApp->getReportReviewReview($dateStart, $dateEnd),
						'detailCustomerFillByDate' => $this->MApp->getReportReviewReviewByDate($dateStart, $dateEnd),
						'title' => 'REPORT REVIEW GOOGLE',
						'content' => 'reportFilledLinkReview',
						'dateStart' => $dateStart,
						'dateEnd' => $dateEnd
					];
					$data['mod'] = $type;
					break;
				case 'reportKPIBeautyConsultant':
					$userid = $this->session->userdata('userid');
					$period = $this->input->post('period') ? $this->input->post('period') : date('Y-m');
					$start_date = $period . '-01';
					$end_date = date('Y-m-t', strtotime($start_date));
					$data = [
						'summaryRevenueBySales' => $this->MApp->getSummaryRevenueBySalesIncludeCommission($period, $userid),
						'staffSalesInvoice' => $this->MApp->getStaffSalesInvoice($start_date, $end_date, $userid),
						'title' => 'REPORT KPI BEAUTY CONSULTANT',
						'content' => 'reportKPIBeautyConstultant',
						'locationList' => $this->MApp->get_location_list(),
						'period' => $period
					];
					$data['mod'] = $type;
					break;
				case 'presensiByPhoto':
					$data = [
						'title' => 'PRESENSI BY PHOTO',
						'content' => 'presensiByPhoto',
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

	function getJSON($type, $param1 = "", $param2 = "", $param3 = "", $param4 = "")
	{
		$result = array();
		if ($this->session->userdata('is_login')) {
			ini_set('memory_limit', '-1');

			$result = $this->MApp->getData($type, $param1, $param2, $param3, $param4);
			echo json_encode($result);
		} else {
			echo json_encode($result);
		}
	}

	function updateMsemployeedetail()
	{
		$post = array();
		foreach ($_POST as $k => $v)
			$post[$k] = $this->input->post($k);
		echo $this->MApp->updateMsemployeedetail($post);
	}

	function updateMsemployee()
	{
		$post = array();
		foreach ($_POST as $k => $v)
			$post[$k] = $this->input->post($k);
		echo $this->MApp->updateMsemployee($post);
	}

	function setPassword()
	{
		$post = array();
		foreach ($_POST as $k => $v)
			$post[$k] = $this->input->post($k);

		echo $this->MApp->setPassword($post);
	}

	function page_not_found()
	{
		$this->output->set_status_header('404');

		$this->load->view('page_not_found');
	}

	function updateCustomerDetail()
	{
		$post = array();
		foreach ($_POST as $k => $v)
			$post[$k] = $this->input->post($k);
		echo $this->MApp->updateCustomerDetail($post);
	}

	function updateCustomerEmail()
	{
		$post = array();
		foreach ($_POST as $k => $v)
			$post[$k] = $this->input->post($k);
		echo $this->MApp->updateCustomerEmail($post);
	}

	function editStockIngredients()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$post = array();

		foreach ($_POST as $k => $v) {
			$post[$k] = $this->input->post($k);
		}

		if (!empty($post) && is_array($post) && isset($post['ingredientsid']) && isset($post['stock_add']) && isset($post['userid']) && isset($post['locationid'])) {

			$ingredientsid = $post['ingredientsid'];
			$stock_add = $post['stock_add'];
			$userid = $post['userid'];
			$locationid = $post['locationid'];

			$sql = "INSERT INTO msingredientsstockin (ingredientsid, stock_add, userid, locationid)
					VALUES (?, ?, ?, ?)";

			$query = $db_oriskin->query($sql, array($ingredientsid, $stock_add, $userid, $locationid));

			if ($query) {
				echo json_encode(['success' => 'Berhasil menambah stock.']);
			} else {
				echo json_encode(['error' => 'Gagal menyimpan data.']);
			}
		} else {
			echo json_encode(['error' => 'Data tidak valid.']);
		}
	}
	public function editStockIngredientsUpdate()
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$data = $this->input->post();
		$response = $this->editStockIngredientsUpdateInternal($data);
		echo $response;
	}

	private function editStockIngredientsUpdateInternal($data)
	{
		$id = isset($data['id']) ? $data['id'] : null;
		$qty = isset($data['qty']) ? $data['qty'] : null;

		if (is_null($id) || is_null($qty)) {
			return json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
		}

		$db_oriskin = $this->load->database('oriskin', true);

		if (!$db_oriskin->conn_id) {
			return json_encode([
				'status' => 'error',
				'message' => 'Database connection failed'
			]);
		}

		$db_oriskin->where('id', $id);

		$update_data = [
			'STOCK' => $qty,
			'UPDATEDATE' => date('Y-m-d H:i:s')
		];

		if ($db_oriskin->update('msingredientsstock', $update_data)) {
			return json_encode([
				'status' => 'success',
				'message' => 'Data updated successfully'

			]);
		} else {
			return json_encode([
				'status' => 'error',
				'message' => 'Failed to update data'
			]);
		}
	}

	function addStockProduct()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$post = array();

		foreach ($_POST as $k => $v) {
			$post[$k] = $this->input->post($k);
		}

		if (!empty($post) && is_array($post) && isset($post['productid']) && isset($post['stock_add']) && isset($post['userid']) && isset($post['locationid'])) {

			$productid = $post['productid'];
			$stock_add = $post['stock_add'];
			$userid = $post['userid'];
			$locationid = $post['locationid'];

			$sql = "INSERT INTO msproductstockin (productid, stock_add, userid, locationid)
					VALUES (?, ?, ?, ?)";

			$query = $db_oriskin->query($sql, array($productid, $stock_add, $userid, $locationid));

			if ($query) {
				echo json_encode(['success' => 'Berhasil menambah stock product.']);
			} else {
				echo json_encode(['error' => 'Gagal menambah stock product.']);
			}
		} else {
			echo json_encode(['error' => 'Data tidak valid.']);
		}
	}

	public function editStockProductUpdate()
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$data = $this->input->post();
		$response = $this->editStockProductUpdateInternal($data);
		echo $response;
	}

	private function editStockProductUpdateInternal($data)
	{
		$id = isset($data['id']) ? $data['id'] : null;
		$qty = isset($data['qty']) ? $data['qty'] : null;

		if (is_null($id) || is_null($qty)) {
			return json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
		}

		$db_oriskin = $this->load->database('oriskin', true);

		if (!$db_oriskin->conn_id) {
			return json_encode([
				'status' => 'error',
				'message' => 'Database connection failed'
			]);
		}

		$db_oriskin->where('id', $id);

		$update_data = [
			'STOCK' => $qty,
			'UPDATEDATE' => date('Y-m-d H:i:s')
		];

		if ($db_oriskin->update('msproductstock', $update_data)) {
			return json_encode([
				'status' => 'success',
				'message' => 'Data updated successfully'

			]);
		} else {
			return json_encode([
				'status' => 'error',
				'message' => 'Failed to update data'
			]);
		}
	}

	function saveNoteFollowUpDoing()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$customerid = $this->input->post('customerid');
		$note = $this->input->post('note');
		$locationid = $this->input->post('locationid');
		$calldate = $this->input->post('calldate');
		$period = $this->input->post('period');

		$response = array();

		// Jika remarks sudah diisi, calldate diisi dengan tanggal hari ini
		if (!empty($note)) {
			if (empty($calldate)) {
				$calldate = date('Y-m-d');
			}
		} else {
			$calldate = null; // Set calldate menjadi null jika remarks kosong
		}

		$doingData = $db_oriskin->query("SELECT ISNULL(customerid, '') AS customerid FROM sllcwithonemembershipactive WHERE customerid = '$customerid'")->row()->customerid ?? 0;
		$response['data'] = $db_oriskin->query("SELECT ISNULL(customerid, '') AS customerid FROM sllcwithonemembershipactive WHERE customerid = '$customerid'")->row()->customerid ?? 0;

		try {
			if ($doingData != 0) {
				$db_oriskin->query("UPDATE sllcwithonemembershipactive SET remarks = '$note', calldate = '$calldate' WHERE customerid = '$customerid'");
				$response['status'] = 'success';
				$response['message'] = 'Note saved successfully!';
				$response['status'] = 'Update';
			} else {
				$db_oriskin->query("INSERT INTO sllcwithonemembershipactive (customerid, remarks, locationid, calldate, period) VALUES (?, ?, ?, ?, ?)", array($customerid, $note, $locationid, $calldate, $period));
				$response['status'] = 'success';
				$response['message'] = 'Note saved successfully!';
				$response['status'] = 'Create';
			}
		} catch (Exception $e) {
			$response['status'] = 'error';
			$response['message'] = 'Failed save note';
		}

		echo json_encode($response);
	}

	///// SAVE NOT FOR POTENTIAL
	function saveNoteFollowUpDoingPotential()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$customerid = $this->input->post('customerid');
		$note = $this->input->post('note');
		$locationid = $this->input->post('locationid');
		$calldate = $this->input->post('calldate');
		$period = $this->input->post('period');

		$response = array();

		// Jika remarks sudah diisi, calldate diisi dengan tanggal hari ini
		if (!empty($note)) {
			if (empty($calldate)) {
				$calldate = date('Y-m-d');
			}
		} else {
			$calldate = null; // Set calldate menjadi null jika remarks kosong
		}

		$doingData = $db_oriskin->query("SELECT ISNULL(customerid, '') AS customerid FROM sllcwithonemembershipactive WHERE customerid = '$customerid'")->row()->customerid ?? 0;
		$response['data'] = $db_oriskin->query("SELECT ISNULL(customerid, '') AS customerid FROM sllcwithonemembershipactive WHERE customerid = '$customerid'")->row()->customerid ?? 0;

		try {
			if ($doingData != 0) {
				$db_oriskin->query("UPDATE sllcwithonemembershipactive SET remarks = '$note', calldate = '$calldate' WHERE customerid = '$customerid'");
				$response['status'] = 'success';
				$response['message'] = 'Note saved successfully!';
				$response['status'] = 'Update';
			} else {
				$db_oriskin->query("INSERT INTO sllcwithonemembershipactive (customerid, remarks, locationid, calldate, period) VALUES (?, ?, ?, ?, ?)", array($customerid, $note, $locationid, $calldate, $period));
				$response['status'] = 'success';
				$response['message'] = 'Note saved successfully!';
				$response['status'] = 'Create';
			}
		} catch (Exception $e) {
			$response['status'] = 'error';
			$response['message'] = 'Failed save note';
		}

		echo json_encode($response);
	}

	///// SAVE NOT FOR RETENTION
	function saveNoteFollowUpDoingRetention()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$customerid = $this->input->post('customerid');
		$note = $this->input->post('note');
		$locationid = $this->input->post('locationid');
		$calldate = $this->input->post('calldate');
		$period = $this->input->post('period');

		$response = array();

		// Jika remarks sudah diisi, calldate diisi dengan tanggal hari ini
		if (!empty($note)) {
			if (empty($calldate)) {
				$calldate = date('Y-m-d');
			}
		} else {
			$calldate = null; // Set calldate menjadi null jika remarks kosong
		}

		$doingData = $db_oriskin->query("SELECT ISNULL(customerid, '') AS customerid FROM sllcwithonemembershipactiveV2 WHERE customerid = '$customerid'")->row()->customerid ?? 0;
		$response['data'] = $db_oriskin->query("SELECT ISNULL(customerid, '') AS customerid FROM sllcwithonemembershipactiveV2 WHERE customerid = '$customerid'")->row()->customerid ?? 0;

		try {
			if ($doingData != 0) {
				$db_oriskin->query("UPDATE sllcwithonemembershipactiveV2 SET remarks = '$note', calldate = '$calldate' WHERE customerid = '$customerid'");
				$response['status'] = 'success';
				$response['message'] = 'Note saved successfully!';
				$response['status'] = 'Update';
			} else {
				$db_oriskin->query("INSERT INTO sllcwithonemembershipactiveV2 (customerid, remarks, locationid, calldate, period) VALUES (?, ?, ?, ?, ?)", array($customerid, $note, $locationid, $calldate, $period));
				$response['status'] = 'success';
				$response['message'] = 'Note saved successfully!';
				$response['status'] = 'Create';
			}
		} catch (Exception $e) {
			$response['status'] = 'error';
			$response['message'] = 'Failed save note';
		}

		echo json_encode($response);
	}

	///// SAVE NOT FOR NOT ACTIVE
	function saveNoteFollowUpDoingNotActive()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$customerid = $this->input->post('customerid');
		$note = $this->input->post('note');
		$locationid = $this->input->post('locationid');
		$calldate = $this->input->post('calldate');
		$period = $this->input->post('period');

		$response = array();

		// Jika remarks sudah diisi, calldate diisi dengan tanggal hari ini
		if (!empty($note)) {
			if (empty($calldate)) {
				$calldate = date('Y-m-d');
			}
		} else {
			$calldate = null; // Set calldate menjadi null jika remarks kosong
		}

		$doingData = $db_oriskin->query("SELECT ISNULL(customerid, '') AS customerid FROM historyfollowup_cust_notactive WHERE customerid = '$customerid'")->row()->customerid ?? 0;
		$response['data'] = $db_oriskin->query("SELECT ISNULL(customerid, '') AS customerid FROM historyfollowup_cust_notactive WHERE customerid = '$customerid'")->row()->customerid ?? 0;

		try {
			if ($doingData != 0) {
				$db_oriskin->query("UPDATE historyfollowup_cust_notactive SET remarks = '$note', calldate = '$calldate' WHERE customerid = '$customerid'");
				$response['status'] = 'success';
				$response['message'] = 'Note saved successfully!';
				$response['status'] = 'Update';
			} else {
				$db_oriskin->query("INSERT INTO historyfollowup_cust_notactive (customerid, remarks, locationid, calldate, period) VALUES (?, ?, ?, ?, ?)", array($customerid, $note, $locationid, $calldate, $period));
				$response['status'] = 'success';
				$response['message'] = 'Note saved successfully!';
				$response['status'] = 'Create';
			}
		} catch (Exception $e) {
			$response['status'] = 'error';
			$response['message'] = 'Failed save note';
		}

		echo json_encode($response);
	}



	public function editStockAddIngredientsUpdate()
	{

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$data = $this->input->post();
		$response = $this->editStockAddIngredientsUpdateInternal($data);
		echo $response;
	}

	private function editStockAddIngredientsUpdateInternal($data)
	{
		$id = isset($data['id']) ? $data['id'] : null;
		$qty = isset($data['qty']) ? $data['qty'] : null;

		if (is_null($id) || is_null($qty)) {
			return json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
		}

		$db_oriskin = $this->load->database('oriskin', true);

		if (!$db_oriskin->conn_id) {
			return json_encode([
				'status' => 'error',
				'message' => 'Database connection failed'
			]);
		}

		$db_oriskin->where('id', $id);

		$update_data = [
			'STOCK_ADD' => $qty,
			'UPDATEDATE' => date('Y-m-d H:i:s')
		];

		if ($db_oriskin->update('msingredientsstockin', $update_data)) {
			return json_encode([
				'status' => 'success',
				'message' => 'Data updated successfully'

			]);
		} else {
			return json_encode([
				'status' => 'error',
				'message' => 'Failed to update data'
			]);
		}
	}

	public function insertStockActual()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$post = array();
		$updateuserid = $this->session->userdata('userid');

		foreach ($_POST as $k => $v) {
			$post[$k] = $this->input->post($k);
		}

		if (!empty($post) && is_array($post) && isset($post['ingredientsid']) && isset($post['stock_add']) && isset($post['period'])) {

			$ingredientsid = $post['ingredientsid'];
			$stock_add = $post['stock_add'];
			$period = $post['period'];
			$locationId = $post['locationId'];

			$sql = "INSERT INTO msingredientsactualstock (ingredientsid, locationid, actual_stock, period, updateuserid, updatedate)
					VALUES (?, ?, ?, ?, ?, ?)";

			// Corrected the array by removing the extra comma after $ingredientsid
			$query = $db_oriskin->query($sql, array($ingredientsid, $locationId, $stock_add, $period, $updateuserid, date('Y-m-d H:i:s')));

			if ($query) {
				echo json_encode(['success' => 'Berhasil menambah stock product.']);
			} else {
				echo json_encode(['error' => 'Gagal menambah stock product.']);
			}
		} else {
			echo json_encode(['error' => 'Data tidak valid.']);
		}
	}


	private function insertStockActualInternal($data)
	{
		// Validasi input data
		$ingredientsid = isset($data['ingredientsid']) ? $data['ingredientsid'] : null;
		$locationid = $this->session->userdata('locationid');
		$actual_stock = isset($data['actual_stock']) ? $data['actual_stock'] : null;
		$period = isset($data['period']) ? $data['period'] : null;
		$updateuserid = $this->session->userdata('userid');

		echo $ingredientsid, $locationid, $actual_stock, $period, $updateuserid;

		if (is_null($ingredientsid) || is_null($locationid) || is_null($actual_stock) || is_null($period) || is_null($updateuserid)) {
			return json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
		}

		if (!$this->db->conn_id) {
			return json_encode([
				'status' => 'error',
				'message' => 'Database connection failed'
			]);
		}

		$insert_data = [
			'ingredientsid' => $ingredientsid,
			'locationid' => $locationid,
			'actual_stock' => $actual_stock,
			'period' => $period,
			'updateuserid' => $updateuserid,
			'updatedate' => date('Y-m-d H:i:s'),
		];

		if ($this->db->insert('msingredientsactualstock', $insert_data)) {
			return json_encode([
				'status' => 'success',
				'message' => 'Stock Awal berhasil ditambahkan'
			]);
		} else {
			return json_encode([
				'status' => 'error',
				'message' => 'Gagal menambah Stock Awal'
			]);
		}
	}

	function erm_ref($id)
	{
		$data['title'] = 'Data Erm Oriskin';
		$data['content'] = 'erm';
		$data['id_ref'] = $id;

		$this->load->view('index', $data);
	}

	public function updateEmployeeAsm()
	{
		$post = array();
		foreach ($_POST as $k => $v)
			$post[$k] = $this->input->post($k);
		echo $this->MApp->updateEmployeeAsm($post);
	}

	public function saveNoteHistoryDoing()
	{
		$doingid = $this->input->post('doingid'); // Sesuaikan dengan nama parameter di JavaScript
		$remarksconsultation = $this->input->post('remarksconsultation');
		$db_oriskin = $this->load->database('oriskin', true);

		$response = array();

		try {
			// Update remarksconsultation field in trdoingtreatment table
			$db_oriskin->set('remarksconsultation', $remarksconsultation);
			$db_oriskin->where('id', $doingid);
			$db_oriskin->update('trdoingtreatment');

			$response['status'] = 'success';
			$response['message'] = 'Note saved successfully';
		} catch (Exception $e) {
			$response['status'] = 'error';
			$response['message'] = 'Failed to save note: ' . $e->getMessage();
		}

		echo json_encode($response);
	}

	function resep_dokter($id)
	{
		$db_oriskin = $this->load->database('oriskin', true);

		$data['title'] = 'Form Resep Dokter';
		$data['content'] = 'resep_dokter';
		$data['id_ref'] = $id;

		$data['data_ap'] = $db_oriskin->query('
				SELECT
				a.id AS MEMBERSHIPID,
				a.name AS MEMBERSHIPNAME,
				d.id AS TREATMENTID,
				d.name AS TREATMENTNAME
				FROM msproductmembershiphdr a INNER JOIN msproductmembershipdtl b ON a.id = b.productmembershiphdrid
				INNER JOIN msproductmembershipbenefit c ON b.productbenefitid = c.membershipbenefitid
				INNER JOIN mstreatment d ON c.treatmentid = d.id
				WHERE a.id = 2209
			')->result_array();

		$data_ap = $db_oriskin->query('
				SELECT
				a.id AS MEMBERSHIPID,
				a.name AS MEMBERSHIPNAME,
				d.id AS TREATMENTID,
				d.name AS TREATMENTNAME
				FROM msproductmembershiphdr a INNER JOIN msproductmembershipdtl b ON a.id = b.productmembershiphdrid
				INNER JOIN msproductmembershipbenefit c ON b.productbenefitid = c.membershipbenefitid
				INNER JOIN mstreatment d ON c.treatmentid = d.id
				WHERE a.id = 2209
			')->result_array();

		$data['data_bp'] = $db_oriskin->query("
					SELECT
					a.id AS MEMBERSHIPID,
					a.name AS MEMBERSHIPNAME,
					d.id AS TREATMENTID,
					d.name AS TREATMENTNAME
					FROM msproductmembershiphdr a INNER JOIN msproductmembershipdtl b ON a.id = b.productmembershiphdrid
					INNER JOIN msproductmembershipbenefit c ON b.productbenefitid = c.membershipbenefitid
					INNER JOIN mstreatment d ON c.treatmentid = d.id
					WHERE a.id = 2208 
					and d.id <> '13'
				")->result_array();

		foreach ($data_ap as $row) {

			// Nilai yang telah diberikan
			$values = $row['TREATMENTID'];

			// Konversi nilai tunggal menjadi array
			$valuesArray = str_split(strval($values), 3);

			// Mengonversi setiap elemen array menjadi string
			$stringValues = array_map('strval', $valuesArray);

			// Mengonversi array menjadi string
			$result = '"' . implode('", "', $stringValues) . '",';

			// echo var_dump($stringValues);

			$excludedIds = array("13", "516", "100", "413", "181", "416", "428", "19", "103", "70", "61", "28", "16", "91", "10", );
			$excludedIdsString = implode("' and id <> '", $excludedIds);

			$query = "
						select 
						id as TREATMENTID,
						name as TREATMENTNAME 
						from mstreatment 
						where isactive=1 
						and price >=10000 
						and name not like '%STOPCARD%' 
						and name not like '%MGM%' 
						and name not like '%redem%' 
						and name not like '%PROMO MARKETING%' 
						and name not like '%STOP CARD%'
						and productcategoryid in (5,11) 
						and treatmenttimes = 1 
						and id <> '" . $excludedIdsString . "'
					";

			$data['data_mps'] = $db_oriskin->query($query)->result_array();

			// echo $db_oriskin->last_query();

			// echo $row["TREATMENTID"];
		}


		$this->load->view('index', $data);
	}

	function proses_resep_dokter()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		// PROSES INSERT KE DATABASE
		$id_member = $this->input->post('id_member');
		$tgl = $this->input->post('tgl');
		$nama_lengkap = $this->input->post('nama_lengkap');
		$jk = $this->input->post('jk');
		$usia = $this->input->post('usia');
		$tb_bb = $this->input->post('tb_bb');
		$alamat = $this->input->post('alamat');
		$no_tlp = $this->input->post('no_tlp');
		$jenis_kulit = implode(",", $this->input->post('jenis_kulit'));
		$pemakaian_produk_skincare = $this->input->post('pemakaian_produk_skincare');
		$treatment = $this->input->post('treatment');
		$penyakit = $this->input->post('penyakit');
		$permasalahan_kulit = $this->input->post('permasalahan_kulit');
		$notes = $this->input->post('notes');

		// MANIPULASI $jenis_kulit
		$exploded_jenis_kulit1 = explode(",", $jenis_kulit);
		$cleaned_jenis_kulit1 = array_filter($exploded_jenis_kulit1, function ($value_jenis_kulit1) {
			return trim($value_jenis_kulit1) !== '';
		});
		$result_jenis_kulit1 = implode(",", $cleaned_jenis_kulit1);

		$exploded_jenis_kulit2 = explode(",", $result_jenis_kulit1);
		$modified_jenis_kulit2 = array_map(function ($item_jenis_kulit2) {
			return "'" . $item_jenis_kulit2 . "'";
		}, $exploded_jenis_kulit2);
		$result_jenis_kulit2 = "[" . implode(",", $modified_jenis_kulit2) . "]";
		// END MANIPULASI $jenis_kulit

		$data = array(
			'id_member' => $id_member,
			'tgl' => $tgl,
			'nama_lengkap' => $nama_lengkap,
			'jk' => $jk,
			'usia' => $usia,
			'tb_bb' => $tb_bb,
			'alamat' => $alamat,
			'no_tlp' => $no_tlp,
			'jenis_kulit' => $result_jenis_kulit2,
			'pemakaian_produk_skincare' => $pemakaian_produk_skincare,
			'treatment' => $treatment,
			'penyakit' => $penyakit,
			'permasalahan_kulit' => $permasalahan_kulit,
			'notes' => $notes,
		);

		$db_oriskin->insert('resep_dokter', $data);

		$aura_plus = $this->input->post('aura_plus');
		$qty_aura_plus = $this->input->post('qty_aura_plus');
		$kode_resep = 'A0001';
		$data['kode_resep'] = $kode_resep;

		if (!empty($aura_plus)) {
			foreach ($aura_plus as $ap) {
				$qap = isset($qty_aura_plus[$ap]) ? $qty_aura_plus[$ap] : 0;
				$data = [
					'id_member' => $id_member,
					'aura_plus' => $ap,
					'qty_aura_plus' => $qap,
					'kode_resep' => $kode_resep,
				];
				$db_oriskin->insert('aura_plus_rd', $data);
			}
		}

		$beauty_plus = $this->input->post('beauty_plus');
		$qty_beauty_plus = $this->input->post('qty_beauty_plus');

		if (!empty($beauty_plus)) {
			foreach ($beauty_plus as $ap) {
				$qap = isset($qty_beauty_plus[$ap]) ? $qty_beauty_plus[$ap] : 0;
				$data = [
					'id_member' => $id_member,
					'beauty_plus' => $ap,
					'qty_beauty_plus' => $qap,
					'kode_resep' => $kode_resep,
				];
				$db_oriskin->insert('beauty_plus_rd', $data);
			}
		}

		$mps = $this->input->post('mps');
		$qty_mps = $this->input->post('qty_mps');

		if (!empty($mps)) {
			foreach ($mps as $ap) {
				$qap = isset($qty_mps[$ap]) ? $qty_mps[$ap] : 0;
				$data = [
					'id_member' => $id_member,
					'mps' => $ap,
					'qty_mps' => $qap,
					'kode_resep' => $kode_resep,
				];
				$db_oriskin->insert('mps_rd', $data);
			}
		}

		$data['id_ref'] = $id_member;

		$data['tgl'] = $tgl;
		$data['nama_lengkap'] = $nama_lengkap;
		$data['jk'] = $jk;
		$data['usia'] = $usia;
		$data['tb_bb'] = $tb_bb;
		$data['alamat'] = $alamat;
		$data['no_tlp'] = $no_tlp;
		$data['jenis_kulit'] = $jenis_kulit;
		$data['pemakaian_produk_skincare'] = $pemakaian_produk_skincare;
		$data['treatment'] = $treatment;
		$data['penyakit'] = $penyakit;
		$data['permasalahan_kulit'] = $permasalahan_kulit;
		$data['aura_plus'] = $aura_plus;
		$data['qty_aura_plus'] = $qty_aura_plus;
		$data['beauty_plus'] = $beauty_plus;
		$data['qty_beauty_plus'] = $qty_beauty_plus;
		$data['mps'] = $mps;
		$data['qty_mps'] = $qty_mps;
		$data['notes'] = $notes;

		$this->load->view('content/pdf_resep_dokter', $data);
		// END PROSES INSERT KE DATABASE
	}

	public function updateReceiver()
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$data = $this->input->post();
		if (!$this->session->userdata('is_login')) {
			$this->load->view('login');
		} else {
			$response = $this->updateReceiverInternal($data);
			echo $response;
		}
	}

	private function updateReceiverInternal($data)
	{

		$stock_receive = isset($data['stock_receive']) ? $data['stock_receive'] : null;
		$id = isset($data['id']) ? $data['id'] : null;

		if (is_null($id) || is_null($stock_receive)) {
			return json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
		}

		$db_oriskin = $this->load->database('oriskin', true);

		if (!$db_oriskin->conn_id) {
			return json_encode([
				'status' => 'error',
				'message' => 'Database connection failed'
			]);
		}

		$db_oriskin->where('id', $id);

		$update_data = [
			'stock_receive' => $stock_receive,
			'approve_receiver' => 1,
		];

		if ($db_oriskin->update('msdeliveryingredientsstock', $update_data)) {
			return json_encode([
				'status' => 'success',
				'message' => 'Data updated successfully'

			]);
		} else {
			return json_encode([
				'status' => 'error',
				'message' => 'Failed to update data'
			]);
		}
	}


	public function createFakturPenjualan($locationId, $dateStart, $dateEnd)
	{
		$db_oriskin = $this->load->database('oriskin', true);


		if (!$locationId || !$dateStart || !$dateEnd) {
			show_error('Invalid parameters', 400);
			return;
		}

		$resultdata_new_menu = $db_oriskin->query("EXEC spReportUsingIngredientsAllClinicWeekly_Dev '" . $dateStart . "','" . $dateEnd . "', '" . $locationId . "' ")->result_array();

		foreach ($resultdata_new_menu as $row) {
			$checkQuery = $db_oriskin->query("
        SELECT 1
        FROM msdeliveryingredientsstock 
        WHERE ingredientsid = '" . $row['INGREDIENTSID'] . "'
        AND locationid = '" . $locationId . "'
        AND datestart = '" . $dateStart . "'
        AND dateend = '" . $dateEnd . "'
        AND approve_receiver = 1
        AND stock_send = stock_receive
    ")->row_array();

			if (!$checkQuery) {
				show_error('Invalid parameters', 400);
				return;
			}
		}

		$dataStock = $db_oriskin->query("
			SELECT 
				a.stock_receive AS qty, 
				b.name AS ingredientsName, 
				(a.stock_receive * b.price) AS total, 
				b.price AS pricePerUnit, 
				b.code AS code,
				a.date_send as dateSend
			FROM 
				msdeliveryingredientsstock a 
				INNER JOIN msingredients b ON a.ingredientsid = b.id
			WHERE 
				a.locationid = ?
				AND a.datestart = ?
				AND a.dateend = ?
				AND a.stock_receive != 0
		", [$locationId, $dateStart, $dateEnd])->result_array();

		$dataCompany = $db_oriskin->query(
			"
		SELECT 
			*
		FROM 
			mscompany 
		WHERE
			locationid = $locationId"
		)->result_array();

		if (empty($dataStock)) {
			show_error('No data found for the given parameters.', 404);
			return;
		}

		$totalSum = $db_oriskin->query("
    SELECT 
        SUM(a.stock_receive * b.price) AS totalSum
    FROM 
        msdeliveryingredientsstock a 
        INNER JOIN msingredients b ON a.ingredientsid = b.id
    WHERE 
        a.locationid = ?
        AND a.datestart = ?
        AND a.dateend = ?
        AND a.stock_receive != 0
", [$locationId, $dateStart, $dateEnd])->row_array();

		$data['total'] = $totalSum;


		$data['terbilang'] = $this->angkaTerbilang($totalSum['totalSum']);

		$data['data_stock'] = $dataStock;
		$data['data_company'] = $dataCompany;

		$year = date('Y', strtotime($dateEnd));
		$month = date('m', strtotime($dateEnd));
		$day = date('d', strtotime($dateEnd));

		$dayLocation = $day . str_pad($locationId, 2, '0', STR_PAD_LEFT);

		$invoiceCode = "INV-{$year}.{$month}.{$dayLocation}";

		$data['invoice'] = $invoiceCode;

		$this->load->view('content/faktur_penjualan', $data);
	}


	function angkaTerbilang($angka)
	{
		$angka = abs($angka);
		$terbilang = [
			" ",
			"Satu ",
			"Dua ",
			"Tiga ",
			"Empat ",
			"Lima ",
			"Enam ",
			"Tujuh ",
			"Delapan ",
			"Sembilan ",
			"Sepuluh ",
			"Sebelas "
		];
		$hasil = "";

		if ($angka < 12) {
			$hasil = " " . $terbilang[$angka];
		} elseif ($angka < 20) {
			$hasil = $this->angkaTerbilang($angka - 10) . " Belas ";
		} elseif ($angka < 100) {
			$hasil = $this->angkaTerbilang($angka / 10) . " Puluh " . $this->angkaTerbilang($angka % 10);
		} elseif ($angka < 200) {
			$hasil = " Seratus " . $this->angkaTerbilang($angka - 100);
		} elseif ($angka < 1000) {
			$hasil = $this->angkaTerbilang($angka / 100) . " Ratus " . $this->angkaTerbilang($angka % 100);
		} elseif ($angka < 2000) {
			$hasil = " Seribu " . $this->angkaTerbilang($angka - 1000);
		} elseif ($angka < 1000000) {
			$hasil = $this->angkaTerbilang($angka / 1000) . " Ribu " . $this->angkaTerbilang($angka % 1000);
		} elseif ($angka < 1000000000) {
			$hasil = $this->angkaTerbilang($angka / 1000000) . " Juta " . $this->angkaTerbilang($angka % 1000000);
		} elseif ($angka < 1000000000000) {
			$hasil = $this->angkaTerbilang($angka / 1000000000) . " Milyar " . $this->angkaTerbilang(fmod($angka, 1000000000));
		} elseif ($angka < 1000000000000000) {
			$hasil = $this->angkaTerbilang($angka / 1000000000000) . " Triliun " . $this->angkaTerbilang(fmod($angka, 1000000000000));
		}

		return trim($hasil);
	}

	function updateTrdoingTreatment()
	{
		$post = array();
		foreach ($_POST as $k => $v)
			$post[$k] = $this->input->post($k);
		echo $this->MApp->updateTrdoingTreatment($post);
	}

	// FUNGSI UNTUK MENYIMPAN TRANSAKSI DP/FULL/SETTLEMENT TREATMENT
	public function saveInvoiceTransaction()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET');

		// Tangkap output error yang tidak diinginkan
		ob_start();
		$db_oriskin = $this->load->database('oriskin', true);
		$location_id = $this->session->userdata('locationid');
		$post = json_decode(file_get_contents('php://input'), true);

		if (!$post) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
			return;
		}

		$db_oriskin->trans_begin();

		$invoicehdr_ids = [];

		foreach ($post['products'] as $product) {
			$amount = floatval($product['total']);
			$price = floatval($product['price']);
			$totalDiscount = floatval($product['totalDiscount']);

			$data_hdr = [
				'invoicedate' => date('Y-m-d H:i:s'),
				'locationid' => $location_id,
				'salesid' => $post['consultantId'] == "" ? NULL : $post['consultantId'],
				'frontdeskid' => $post['frontDeskId'] == "" ? NULL : $post['frontDeskId'],
				'assistid' => $post['assistantId'] == "" ? NULL : $post['assistantId'],
				'consultantid' => $post['bcId'] == "" ? NULL : $post['bcId'],
				'doctorid' => $post['doctorid'] == "" ? NULL : $post['doctorid'],
				'customerid' => $post['customerId'],
				'amount' => $amount,
				'downpaymenthdrid' => $post['downPaymentId'],
				'round' => 0,
				'status' => 2,
				'descriptions' => NULL,
				'updateuserid' => $post['updateuserId'],
				'remarks' => $product['remarks'] == "" ? NULL : $product['remarks']
			];

			$db_oriskin->insert('slinvoicetreatmenthdr', $data_hdr);
			$invoicehdrid = $db_oriskin->insert_id();

			if (!$invoicehdrid) {
				$db_oriskin->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to insert invoice header']);
				return;
			}

			$invoicehdr_ids[] = $invoicehdrid;

			$data_dtl = [
				'invoicehdrid' => $invoicehdrid,
				'productid' => $product['productId'],
				'qty' => $product['jumlah'],
				'price' => $price,
				'discountpercent' => $product['diskon'],
				'discountvalue' => floatval($product['diskonValue']),
				'discountreason' => $product['diskonReason'],
				'discountreasonid' => $product['discReasonId'] == "" ? NULL : $product['discReasonId'],
				'totaldiscount' => $totalDiscount,
				'total' => $amount,
				'updateuserid' => $post['updateuserId'],
			];

			$db_oriskin->insert('slinvoicetreatmentdtl', $data_dtl);

			foreach ($post['payments'] as $payment) {
				if ($payment['producttreatmentid'] == $product['productId']) {
					$amountPayment = floatval($payment['amount']);
					$data_payment = [
						'invoicehdrid' => $invoicehdrid,
						'paymentid' => $payment['paymentid'],
						'edcid' => $payment['edcid'] == "" ? NULL : $payment['edcid'],
						'cardid' => $payment['cardid'] == "" ? NULL : $payment['cardid'],
						'cardbankid' => $payment['cardbankid'] == "" ? NULL : $payment['cardbankid'],
						'cardcharge' => NULL,
						'amount' => $amountPayment,
						'installmentid' => $payment['installment'] == "" ? NULL : $payment['installment'],
						'danarefcode' => NULL,
						'mpfrominvoiceno' => NULL,
						'upgradefrominvoiceno' => NULL,
						'updateuserid' => $payment['updateuserid']
					];

					$db_oriskin->insert('slinvoicetreatmentpayment', $data_payment);
				}
			}
		}


		if ($db_oriskin->trans_status() === FALSE) {
			// $db_oriskin->trans_rollback();
			// echo json_encode(['status' => 'error', 'message' => 'Transaction failed']);
			$db_oriskin->trans_rollback();
			$response = ['status' => 'error', 'message' => 'Transaction failed'];
		} else {
			// $db_oriskin->trans_commit();
			// echo json_encode(['status' => 'success', 'invoicehdrids' => $invoicehdr_ids]);
			$db_oriskin->trans_commit();
			$response = ['status' => 'success', 'invoicehdrids' => $invoicehdr_ids];
		}

		$output = ob_get_clean();
		if (!empty($output)) {
			error_log("Unexpected output: " . $output);
		}

		// Kirim response JSON bersih
		echo json_encode($response);
		exit;
	}


	public function saveInvoiceTransactionTreatmentDownPayment()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET');

		// Tangkap output error yang tidak diinginkan
		ob_start();
		$db_oriskin = $this->load->database('oriskin', true);
		$location_id = $this->session->userdata('locationid');
		$post = json_decode(file_get_contents('php://input'), true);

		if (!$post) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
			return;
		}

		$db_oriskin->trans_begin();

		$invoicehdr_ids = [];

		foreach ($post['products'] as $product) {
			$amount = floatval($product['total']);
			$price = floatval($product['price']);
			$totalDiscount = floatval($product['totalDiscount']);

			$data_hdr = [
				'downpaymentdate' => date('Y-m-d H:i:s'),
				'locationid' => $location_id,
				'salesid' => $post['consultantId'],
				'frontdeskid' => $post['frontDeskId'],
				'customerid' => $post['customerId'],
				'doctorid' => $post['doctorid'] == "" ? NULL : $post['doctorid'],
				'amount' => $amount,
				'round' => 0,
				'status' => 10,
				'descriptions' => NULL,
				'updateuserid' => $post['updateuserId'],
				'remarks' => $product['remarks'] == "" ? NULL : $product['remarks']
			];

			$db_oriskin->insert('sldownpaymenttreatmenthdr', $data_hdr);
			$invoicehdrid = $db_oriskin->insert_id();

			if (!$invoicehdrid) {
				$db_oriskin->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to insert invoice header']);
				return;
			}

			$invoicehdr_ids[] = $invoicehdrid;

			$data_dtl = [
				'downpaymenthdrid' => $invoicehdrid,
				'productid' => $product['productId'],
				'qty' => $product['jumlah'],
				'price' => $price,
				'discountpercent' => $product['diskon'],
				'discountvalue' => floatval($product['diskonValue']),
				'discountreason' => $product['diskonReason'],
				// 'discountreasonid' => $product['discReasonId'] == "" ? NULL : $product['discReasonId'],
				'totaldiscount' => $totalDiscount,
				'total' => $amount,
				'updateuserid' => $post['updateuserId'],
			];

			$db_oriskin->insert('sldownpaymenttreatmentdtl', $data_dtl);

			foreach ($post['payments'] as $payment) {
				if ($payment['producttreatmentid'] == $product['productId']) {
					$amountPayment = floatval($payment['amount']);
					$data_payment = [
						'downpaymenthdrid' => $invoicehdrid,
						'paymentid' => $payment['paymentid'],
						'edcid' => $payment['edcid'] == "" ? NULL : $payment['edcid'],
						'cardid' => $payment['cardid'] == "" ? NULL : $payment['cardid'],
						'cardbankid' => $payment['cardbankid'] == "" ? NULL : $payment['cardbankid'],
						'cardcharge' => NULL,
						'amount' => $amountPayment,
						'installmentid' => $payment['installment'] == "" ? NULL : $payment['installment'],
						'danarefcode' => NULL,
						'mpfrominvoiceno' => NULL,
						'upgradefrominvoiceno' => NULL,
						'updateuserid' => $payment['updateuserid']
					];

					$db_oriskin->insert('sldownpaymenttreatmentpayment', $data_payment);
				}
			}
		}

		if ($db_oriskin->trans_status() === FALSE) {
			// $db_oriskin->trans_rollback();
			// echo json_encode(['status' => 'error', 'message' => 'Transaction failed']);
			$db_oriskin->trans_rollback();
			$response = ['status' => 'error', 'message' => 'Transaction failed'];
		} else {
			// $db_oriskin->trans_commit();
			// echo json_encode(['status' => 'success', 'invoicehdrids' => $invoicehdr_ids]);
			$db_oriskin->trans_commit();
			$response = ['status' => 'success', 'invoicehdrids' => $invoicehdr_ids];
		}

		$output = ob_get_clean();
		if (!empty($output)) {
			error_log("Unexpected output: " . $output);
		}

		// Kirim response JSON bersih
		echo json_encode($response);
		exit;
	}

	//END FUNGSI UNTUK MENYIMPAN TRANSAKSI DP/FULL/SETTLEMENT TREATMENT


	// FUNGSI UNTUK MENYIMPAN TRANSAKSI DP/FULL/SETTLEMENT MEMBERSHIP
	public function saveInvoiceMembershipTransaction()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$location_id = $this->session->userdata('locationid');
		$post = json_decode(file_get_contents('php://input'), true);

		if (!$post) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
			return;
		}

		$db_oriskin->trans_begin();

		$invoicehdr_ids = [];

		foreach ($post['memberships'] as $product) {
			$data_hdr = [
				'invoicedate' => date('Y-m-d H:i:s'),
				'locationsalesid' => $location_id,
				'locationactivatedid' => $location_id,
				'salesid' => $post['assistantDoctorId'] == "" ? NULL : $post['assistantDoctorId'],
				'assistid' => $post['beauticianId'] == "" ? NULL : $post['beauticianId'],
				'consultantid' => $post['doctorId'] == "" ? NULL : $post['doctorId'],
				'frontdeskid' => $post['frontDeskId'] == "" ? NULL : $post['frontDeskId'],
				'doctorid' => $post['prescreptionid'] == "" ? NULL : $post['prescreptionid'],
				'customerid' => $post['customerId'],
				'trusteename' => NULL,
				'trusteessid' => NULL,
				'trusteephone' => NULL,
				'autopaycardid' => NULL,
				'autopaycardno' => NULL,
				'autopaycardname' => NULL,
				'autopaycardexpired' => NULL,
				'autopaycardbankid' => NULL,
				'autopayssid' => NULL,
				'autopayaddress' => NULL,
				'autopayphone' => NULL,
				'autopaystartdate' => NULL,
				'status' => 2,
				'descriptions' => NULL,
				'documentiscompleted' => NULL,
				'ndp' => NULL,
				'cycle' => NULL,
				'statusmembership' => NULL,
				'reason' => NULL,
				'downpaymenthdrid' => $post['downPaymentId'],
				'referencemembershiphdrid' => NULL,
				'neworrejoin' => 'NEW',
				'updateuserid' => $post['updateuserId'],
				'remarks' => $product['remarks'] == "" ? NULL : $product['remarks']
			];


			$db_oriskin->insert('slinvoicemembershiphdr', $data_hdr);
			$invoicehdrid = $db_oriskin->insert_id();

			if (!$invoicehdrid) {

				$db_oriskin->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to insert invoice header']);
				return;
			}

			$query = $db_oriskin->get_where('slinvoicemembershiphdr', ['id' => $invoicehdrid]);
			if ($query->num_rows() == 0) {
				$db_oriskin->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Invoice header ID does not exist']);
				return;
			}

			$invoicehdr_ids[] = $invoicehdrid;

			$data_dtl = [
				'id' => $invoicehdrid,
				'productmembershiphdrid' => $product['membershipId'],
				'subscriptionmonth' => $product['sm'],
				'bonusmonth' => $product['bm'],
				'totalmonth' => $product['tm'],
				'registrationfee' => $product['admin'],
				'processingfee' => NULL,
				'monthlyfee' => floatval($product['monthly']),
				'firstmonthfee' => floatval($product['firstmonth']),
				'lastmonthfee' => floatval($product['lastmonth']),
				'termprice' => floatval($product['term']),
				'paidfee' => NULL,
				'totalamount' => floatval($product['total']),
				'buydate' => date('Y-m-d H:i:s'),
				'enddate' => date('Y-m-d H:i:s'),
				'activationdate' => date('Y-m-d H:i:s'),
				'updateuserid' => $product['updateuserId'],
			];

			$db_oriskin->insert('slinvoicemembershipdtl', $data_dtl);

			foreach ($post['payments'] as $payment) {
				if ($payment['producttreatmentid'] == $product['membershipId']) {
					$amountPayment = floatval($payment['amount']);
					$data_payment = [
						'invoicehdrid' => $invoicehdrid,
						'paymentid' => $payment['paymentid'],
						'edcid' => $payment['edcid'] == "" ? NULL : $payment['edcid'],
						'cardid' => $payment['cardid'] == "" ? NULL : $payment['cardid'],
						'cardbankid' => $payment['cardbankid'] == "" ? NULL : $payment['cardbankid'],
						'cardcharge' => NULL,
						'amount' => $amountPayment,
						'installmentid' => $payment['installment'] == "" ? NULL : $payment['installment'],
						'danarefcode' => NULL,
						'mpfrominvoiceno' => NULL,
						'upgradefrominvoiceno' => NULL,
						'updateuserid' => $payment['updateuserid']
					];

					$db_oriskin->insert('slinvoicemembershippayment', $data_payment);
				}
			}
		}

		if ($db_oriskin->trans_status() === FALSE) {
			$error = $db_oriskin->error();
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Transaction failed', 'error' => $error]);
		} else {
			$db_oriskin->trans_commit();
			echo json_encode(['status' => 'success', 'invoicehdrids' => $invoicehdr_ids]);
		}
	}

	public function saveMembershipTransactionDownPayment()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$location_id = $this->session->userdata('locationid');
		$post = json_decode(file_get_contents('php://input'), true);

		if (!$post) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
			return;
		}

		$db_oriskin->trans_begin();

		$invoicehdr_ids = [];

		foreach ($post['memberships'] as $product) {
			$data_hdr = [
				'downpaymentdate' => date('Y-m-d H:i:s'),
				'locationsalesid' => $location_id,
				'salesid' => $post['assistantDoctorId'],
				'frontdeskid' => $post['frontDeskId'],
				'customerid' => $post['customerId'],
				'doctorid' => $post['prescreptionid'] == "" ? NULL : $post['prescreptionid'],
				'status' => 10,
				'descriptions' => NULL,
				'updateuserid' => $post['updateuserId'],
				'remarks' => $product['remarks'] == "" ? NULL : $product['remarks']
			];


			$db_oriskin->insert('sldownpaymentmembershiphdr', $data_hdr);
			$invoicehdrid = $db_oriskin->insert_id();

			if (!$invoicehdrid) {
				$db_oriskin->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to insert invoice header']);
				return;
			}

			$query = $db_oriskin->get_where('sldownpaymentmembershiphdr', ['id' => $invoicehdrid]);
			if ($query->num_rows() == 0) {
				$db_oriskin->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Invoice header ID does not exist']);
				return;
			}

			$invoicehdr_ids[] = $invoicehdrid;

			$data_dtl = [
				'id' => $invoicehdrid,
				'productmembershiphdrid' => $product['membershipId'],
				'subscriptionmonth' => $product['sm'],
				'bonusmonth' => $product['bm'],
				'totalmonth' => $product['tm'],
				'registrationfee' => $product['admin'],
				'processingfee' => NULL,
				'monthlyfee' => floatval($product['monthly']),
				'firstmonthfee' => floatval($product['firstmonth']),
				'lastmonthfee' => floatval($product['lastmonth']),
				'termprice' => floatval($product['term']),
				'paidfee' => NULL,
				'totalamount' => floatval($product['total']),
				'buydate' => date('Y-m-d H:i:s'),
				'enddate' => date('Y-m-d H:i:s'),
				'activationdate' => date('Y-m-d H:i:s'),
				'updateuserid' => $product['updateuserId'],
			];

			$db_oriskin->insert('sldownpaymentmembershipdtl', $data_dtl);

			foreach ($post['payments'] as $payment) {
				if ($payment['producttreatmentid'] == $product['membershipId']) {
					$amountPayment = floatval($payment['amount']);
					$data_payment = [
						'downpaymenthdrid' => $invoicehdrid,
						'paymentid' => $payment['paymentid'],
						'edcid' => $payment['edcid'] == "" ? NULL : $payment['edcid'],
						'cardid' => $payment['cardid'] == "" ? NULL : $payment['cardid'],
						'cardbankid' => $payment['cardbankid'] == "" ? NULL : $payment['cardbankid'],
						'cardcharge' => NULL,
						'amount' => $amountPayment,
						'installmentid' => $payment['installment'] == "" ? NULL : $payment['installment'],
						'danarefcode' => NULL,
						'mpfrominvoiceno' => NULL,
						'upgradefrominvoiceno' => NULL,
						'updateuserid' => $payment['updateuserid']
					];

					$db_oriskin->insert('sldownpaymentmembershippayment', $data_payment);
				}
			}
		}

		if ($db_oriskin->trans_status() === FALSE) {
			$error = $db_oriskin->error();
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Transaction failed', 'error' => $error]);
		} else {
			$db_oriskin->trans_commit();
			echo json_encode(['status' => 'success', 'invoicehdrids' => $invoicehdr_ids]);
		}
	}
	// END FUNGSI UNTUK MENYIMPAN TRANSAKSI DP/FULL/SETTLEMENT MEMBERSHIP

	// FUNGSI UNTUK MENYIMPAN TRANSAKSI DP/FULL/SETTLEMENT RETAIL
	public function saveInvoiceRetailTransaction()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$location_id = $this->session->userdata('locationid');
		$post = json_decode(file_get_contents('php://input'), true);

		if (!$post) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
			return;
		}

		$db_oriskin->trans_begin();

		$data_hdr = [
			'invoicedate' => date('Y-m-d H:i:s'),
			'locationid' => $location_id,
			'salesid' => $post['consultantId'],
			'doctorid' => $post['prescriptionId'] == "" ? NULL : $post['prescriptionId'],
			'consultantid' => $post['bcId'] == "" ? NULL : $post['bcId'],
			'frontdeskid' => $post['frontDeskId'],
			'customerid' => $post['customerId'],
			'amount' => $post['totalAmount'],
			'round' => 0,
			'status' => 2,
			'descriptions' => NULL,
			'updateuserid' => $post['updateuserid'],
			'downpaymenthdrid' => $post['downPaymentId'],
		];

		$db_oriskin->insert('slinvoicehdr', $data_hdr);

		$invoicehdrid = $db_oriskin->insert_id();

		if (!$invoicehdrid) {
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Failed to insert invoice header']);
			return;
		}

		foreach ($post['products'] as $product) {
			$amount = floatval($product['total']);
			$price = floatval($product['price']);
			$totalDiscount = floatval($product['totalDiscount']);

			$data_dtl = [
				'invoicehdrid' => $invoicehdrid,
				'productid' => $product['productId'],
				'qty' => $product['jumlah'],
				'price' => $price,
				'discountpercent' => $product['diskon'],
				'discountvalue' => floatval($product['diskonValue']),
				'discountreason' => $product['diskonReason'],
				'totaldiscount' => $totalDiscount,
				'total' => $amount,
				'updateuserid' => $post['updateuserid'],
				'remarks' => $product['remarks'] == "" ? NULL : $product['remarks']
			];

			$db_oriskin->insert('slinvoicedtl', $data_dtl);
		}

		foreach ($post['payments'] as $payment) {
			$amountPayment = floatval($payment['amount']);
			$data_payment = [
				'invoicehdrid' => $invoicehdrid,
				'paymentid' => $payment['paymentid'],
				'edcid' => $payment['edcid'] == "" ? NULL : $payment['edcid'],
				'cardid' => $payment['cardid'] == "" ? NULL : $payment['cardid'],
				'cardbankid' => $payment['cardbankid'] == "" ? NULL : $payment['cardbankid'],
				'cardcharge' => NULL,
				'amount' => $amountPayment,
				'installmentid' => $payment['installment'] == "" ? NULL : $payment['installment'],
				'danarefcode' => NULL,
				'mpfrominvoiceno' => NULL,
				'upgradefrominvoiceno' => NULL,
				'updateuserid' => $post['updateuserid']
			];

			$db_oriskin->insert('slinvoicepayment', $data_payment);
		}

		if ($db_oriskin->trans_status() === FALSE) {
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Transaction failed']);
		} else {
			$db_oriskin->trans_commit();
			echo json_encode(['status' => 'success', 'invoicehdrids' => $invoicehdrid]);
		}
	}

	public function saveInvoiceRetailTransactionDownPayment()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$location_id = $this->session->userdata('locationid');
		$post = json_decode(file_get_contents('php://input'), true);

		if (!$post) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
			return;
		}

		$db_oriskin->trans_begin();

		$data_hdr = [
			'downpaymentdate' => date('Y-m-d H:i:s'),
			'locationid' => $location_id,
			'salesid' => $post['consultantId'],
			'frontdeskid' => $post['frontDeskId'],
			'customerid' => $post['customerId'],
			'doctorid' => $post['prescriptionId'] == "" ? NULL : $post['prescriptionId'],
			'amount' => $post['totalAmount'],
			'round' => 0,
			'status' => 10,
			'descriptions' => NULL,
			'updateuserid' => $post['updateuserid'],
		];

		$db_oriskin->insert('sldownpaymentproducthdr', $data_hdr);

		$invoicehdrid = $db_oriskin->insert_id();

		if (!$invoicehdrid) {
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Failed to insert invoice header']);
			return;
		}

		foreach ($post['products'] as $product) {
			$amount = floatval($product['total']);
			$price = floatval($product['price']);
			$totalDiscount = floatval($product['totalDiscount']);

			$data_dtl = [
				'downpaymenthdrid' => $invoicehdrid,
				'productid' => $product['productId'],
				'qty' => $product['jumlah'],
				'price' => $price,
				'discountpercent' => $product['diskon'],
				'discountvalue' => floatval($product['diskonValue']),
				'discountreason' => $product['diskonReason'],
				'totaldiscount' => $totalDiscount,
				'total' => $amount,
				'updateuserid' => $post['updateuserid'],
				'remarks' => $product['remarks'] == "" ? NULL : $product['remarks']
			];

			$db_oriskin->insert('sldownpaymentproductdtl', $data_dtl);
		}

		foreach ($post['payments'] as $payment) {

			$amountPayment = floatval($payment['amount']);

			$data_payment = [
				'downpaymenthdrid' => $invoicehdrid,
				'paymentid' => $payment['paymentid'],
				'edcid' => $payment['edcid'] == "" ? NULL : $payment['edcid'],
				'cardid' => $payment['cardid'] == "" ? NULL : $payment['cardid'],
				'cardbankid' => $payment['cardbankid'] == "" ? NULL : $payment['cardbankid'],
				'cardcharge' => NULL,
				'amount' => $amountPayment,
				'installmentid' => $payment['installment'] == "" ? NULL : $payment['installment'],
				'danarefcode' => NULL,
				'mpfrominvoiceno' => NULL,
				'upgradefrominvoiceno' => NULL,
				'updateuserid' => $post['updateuserid']
			];

			$db_oriskin->insert('sldownpaymentproductpayment', $data_payment);
		}

		if ($db_oriskin->trans_status() === FALSE) {
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Transaction failed']);
		} else {
			$db_oriskin->trans_commit();
			echo json_encode(['status' => 'success', 'invoicehdrids' => $invoicehdrid]);
		}
	}
	// END FUNGSI UNTUK MENYIMPAN TRANSAKSI DP/FULL/SETTLEMENT RETAIL

	function print_invoice($type, $id)
	{
		$this->load->library('Ltcpdf');
		$db_oriskin = $this->load->database('oriskin', true);

		$invoiceHdr = [];
		$invoicePayment = [];
		$invoiceDtl = [];

		// echo $id, $type;

		if ($type == 1) {
			$invoiceHdr = $db_oriskin->query('SELECT
				b.cellphonenumber as HP,
				b.address as ADDRESS, 
				a.invoiceno as INVOICENO, 
				a.invoicedate as INVOICEDATE, 
				b.firstname + ' . ' ' . ' + b.lastname AS FULLNAME, 
				c.name as FD, d.name as SALES,
				e.address as ADDRESSLOCATION,
				e.name as LOCATIONNAME 
				from slinvoicetreatmenthdr a 
				inner join mscustomer b on a.customerid = b.id 
				inner join msemployee c on a.frontdeskid = c.id 
				inner join mslocation e on a.locationid = e.id
				inner join msemployee d on d.id = a.salesid where a.id = ' . $id . '
			')->row_array();

			$invoiceDtl = $db_oriskin->query('SELECT
				b.name as TREATMENTNAME,
				a.qty as JUMLAH,
				a.total as TOTAL
				from slinvoicetreatmentdtl a 
				inner join mstreatment b on a.productid  = b.id
				where a.invoicehdrid = ' . $id . '
			')->result_array();


			$invoicePayment = $db_oriskin->query('SELECT
				a.amount as AMOUNT,
				b.name as PAYMENT,
				c.name as EDC
				from slinvoicetreatmentpayment a 
				inner join mspaymenttype b on a.paymentid  = b.id 
				left join msedc c on a.edcid  = c.id where a.invoicehdrid = ' . $id . '
			')->result_array();
		} else if ($type == 2) {
			$invoiceHdr = $db_oriskin->query('SELECT
				b.cellphonenumber as HP,
				b.address as ADDRESS,  
				a.downpaymentno as INVOICENO, 
				a.downpaymentdate as INVOICEDATE, 
				b.firstname + ' . ' ' . ' + b.lastname AS FULLNAME, 
				c.name as FD, 
				d.name as SALES,
				e.address as ADDRESSLOCATION,
				e.name as LOCATIONNAME
				from sldownpaymenttreatmenthdr a 
				inner join mscustomer b on a.customerid = b.id 
				inner join msemployee c on a.frontdeskid = c.id 
				inner join mslocation e on a.locationid = e.id
				inner join msemployee d on d.id = a.salesid 
				where a.id = ' . $id . '
			')->row_array();

			$invoiceDtl = $db_oriskin->query('SELECT
				b.name as TREATMENTNAME,
				a.qty as JUMLAH,
				a.total as TOTAL
				from sldownpaymenttreatmentdtl a 
				inner join mstreatment b on a.productid  = b.id
				where a.downpaymenthdrid = ' . $id . '
			')->result_array();



			$invoicePayment = $db_oriskin->query('SELECT
				a.amount as AMOUNT,
				b.name as PAYMENT,
				c.name as EDC
				from sldownpaymenttreatmentpayment a 
				inner join mspaymenttype b on a.paymentid  = b.id 
				left join msedc c on a.edcid  = c.id where a.downpaymenthdrid = ' . $id . '
			')->result_array();
		} else if ($type == 3) {
			$invoiceHdr = $db_oriskin->query('SELECT
				b.cellphonenumber as HP,
				b.address as ADDRESS, 
				a.invoiceno as INVOICENO, 
				a.invoicedate as INVOICEDATE, 
				b.firstname + ' . ' ' . ' + b.lastname AS FULLNAME, 
				c.name as FD, d.name as SALES,
				e.address as ADDRESSLOCATION,
				e.name as LOCATIONNAME
				from slinvoicemembershiphdr a 
				inner join mscustomer b on a.customerid = b.id 
				inner join msemployee c on a.frontdeskid = c.id
				inner join mslocation e on a.locationsalesid = e.id
				inner join msemployee d on d.id = a.salesid where a.id = ' . $id . '
			')->row_array();

			$invoiceDtl = $db_oriskin->query('SELECT
				b.name as TREATMENTNAME,
				a.totalmonth as JUMLAH,
				a.totalamount  as TOTAL
				from slinvoicemembershipdtl a 
				inner join msproductmembershiphdr b on a.productmembershiphdrid = b.id
				where a.id = ' . $id . '
			')->result_array();


			$invoicePayment = $db_oriskin->query('SELECT
				a.amount as AMOUNT,
				b.name as PAYMENT,
				c.name as EDC
				from slinvoicemembershippayment a 
				inner join mspaymenttype b on a.paymentid  = b.id 
				left join msedc c on a.edcid  = c.id where a.invoicehdrid = ' . $id . '
			')->result_array();
		} else if ($type == 4) {
			$invoiceHdr = $db_oriskin->query('SELECT
				b.cellphonenumber as HP,
				b.address as ADDRESS,  
				a.downpaymentno as INVOICENO, 
				a.downpaymentdate as INVOICEDATE, 
				b.firstname + ' . ' ' . ' + b.lastname AS FULLNAME, 
				c.name as FD, 
				d.name as SALES,
				e.address as ADDRESSLOCATION,
				e.name as LOCATIONNAME
				from sldownpaymentmembershiphdr a 
				inner join mscustomer b on a.customerid = b.id 
				inner join msemployee c on a.frontdeskid = c.id 
				inner join mslocation e on a.locationsalesid = e.id
				inner join msemployee d on d.id = a.salesid 
				where a.id = ' . $id . '
			')->row_array();

			$invoiceDtl = $db_oriskin->query('SELECT
				b.name as TREATMENTNAME,
				a.totalmonth as JUMLAH,
				a.totalamount  as TOTAL
				from sldownpaymentmembershipdtl a 
				inner join msproductmembershiphdr b on a.productmembershiphdrid = b.id
				where a.id  = ' . $id . '
			')->result_array();


			$invoicePayment = $db_oriskin->query('SELECT
				a.amount as AMOUNT,
				b.name as PAYMENT,
				c.name as EDC
				from sldownpaymentmembershippayment a 
				inner join mspaymenttype b on a.paymentid  = b.id 
				left join msedc c on a.edcid  = c.id where a.downpaymenthdrid = ' . $id . '
			')->result_array();
		} else if ($type == 5) {
			$invoiceHdr = $db_oriskin->query('SELECT
				b.cellphonenumber as HP,
				b.address as ADDRESS, 
				a.invoiceno as INVOICENO, 
				a.invoicedate as INVOICEDATE, 
				b.firstname + ' . ' ' . ' + b.lastname AS FULLNAME, 
				c.name as FD, d.name as SALES,
				e.address as ADDRESSLOCATION,
				e.name as LOCATIONNAME
				from slinvoicehdr a 
				inner join mscustomer b on a.customerid = b.id 
				inner join msemployee c on a.frontdeskid = c.id 
				inner join mslocation e on a.locationid = e.id
				inner join msemployee d on d.id = a.salesid where a.id = ' . $id . '
			')->row_array();

			$invoiceDtl = $db_oriskin->query('SELECT
				b.name as TREATMENTNAME,
				a.qty as JUMLAH,
				a.total  as TOTAL
				from slinvoicedtl a 
				inner join msproduct b on a.productid = b.id
				where a.invoicehdrid = ' . $id . '
			')->result_array();


			$invoicePayment = $db_oriskin->query('SELECT
				a.amount as AMOUNT,
				b.name as PAYMENT,
				c.name as EDC
				from slinvoicepayment a 
				inner join mspaymenttype b on a.paymentid  = b.id 
				left join msedc c on a.edcid  = c.id where a.invoicehdrid = ' . $id . '
			')->result_array();
		} else if ($type == 6) {
			$invoiceHdr = $db_oriskin->query('SELECT
				b.cellphonenumber as HP,
				b.address as ADDRESS,  
				a.downpaymentno as INVOICENO, 
				a.downpaymentdate as INVOICEDATE, 
				b.firstname + ' . ' ' . ' + b.lastname AS FULLNAME, 
				c.name as FD, 
				d.name as SALES,
				e.address as ADDRESSLOCATION,
				e.name as LOCATIONNAME
				from sldownpaymentproducthdr a 
				inner join mslocation e on a.locationid = e.id
				inner join mscustomer b on a.customerid = b.id 
				inner join msemployee c on a.frontdeskid = c.id 
				inner join msemployee d on d.id = a.salesid 
				where a.id = ' . $id . '
			')->row_array();

			$invoiceDtl = $db_oriskin->query('SELECT
				b.name as TREATMENTNAME,
				a.qty as JUMLAH,
				a.total  as TOTAL
				from sldownpaymentproductdtl a 
				inner join msproduct b on a.productid = b.id
				where a.downpaymenthdrid = ' . $id . '
			')->result_array();


			$invoicePayment = $db_oriskin->query('SELECT
				a.amount as AMOUNT,
				b.name as PAYMENT,
				c.name as EDC
				from sldownpaymentproductpayment a 
				inner join mspaymenttype b on a.paymentid  = b.id 
				left join msedc c on a.edcid  = c.id where a.downpaymenthdrid = ' . $id . '
			')->result_array();
		}
		// 	<button type="button" class="btn btn-primary btn-sm" style="background-color: #c49e8f; color: black;" data-toggle="modal" data-target="#listMembershipModal">
		// 	Add New Membership
		// </button>

		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		$pdf->SetMargins(0, 0, 0);
		$pdf->SetAutoPageBreak(false, 0);
		$pdf->AddPage();

		// Gambar Latar Belakang
		$bgImage = FCPATH . 'assets/img/ttepng.png'; // Sesuaikan dengan lokasi gambar Anda
		$pdf->Image($bgImage, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

		$pdf->SetFont('helvetica', '', 6);

		$pdf->SetXY(57, 22.5);
		$pdf->MultiCell(80, 5, $invoiceHdr['ADDRESSLOCATION'], 0, 'L');


		$pdf->SetFont('helvetica', '', 6);
		$pdf->SetXY(159.5, 15);
		$pdf->Cell(0, 10, $invoiceHdr['INVOICENO'], 0, 1);

		$pdf->SetXY(159.5, 9);
		$pdf->Cell(0, 10, $invoiceHdr['INVOICEDATE'], 0, 1);

		$pdf->SetXY(159.5, 20);
		$pdf->Cell(0, 10, $invoiceHdr['LOCATIONNAME'], 0, 1);


		$pdf->SetFont('helvetica', '', 6);
		$yPos1 = 62.5;
		$yPos2 = 196;

		foreach ($invoiceDtl as $invoiceDtl) {
			$pdf->SetXY(12, $yPos1);
			$pdf->Cell(0, 8, $invoiceDtl['TREATMENTNAME'], 0, 1);

			$pdf->SetXY(14, $yPos2);
			$pdf->Cell(0, 8, $invoiceDtl['TREATMENTNAME'], 0, 1);

			$pdf->SetXY(100, $yPos1);
			$pdf->Cell(0, 8, $invoiceDtl['JUMLAH'], 0, 1);

			$pdf->SetXY(102, $yPos2);
			$pdf->Cell(0, 8, $invoiceDtl['JUMLAH'], 0, 1);

			$pdf->SetXY(170, $yPos1);
			$pdf->Cell(0, 8, 'Rp ' . number_format($invoiceDtl['TOTAL'], 0, ',', '.'), 0, 0);

			$pdf->SetXY(172, $yPos2);
			$pdf->Cell(0, 8, 'Rp ' . number_format($invoiceDtl['TOTAL'], 0, ',', '.'), 0, 0);

			// Pindahkan posisi ke bawah agar tidak menumpuk
			$yPos1 += 4;
			$yPos2 += 4;
		}
		$pdf->SetXY(50, 31.5);
		$pdf->Cell(0, 8, $invoiceHdr['FULLNAME'], 0, 1);

		$pdf->SetXY(52, 164);
		$pdf->Cell(0, 8, $invoiceHdr['FULLNAME'], 0, 1);

		$pdf->SetXY(50, 38.5);
		$pdf->Cell(0, 8, $invoiceHdr['ADDRESS'] == NULL ? '-' : $invoiceHdr['ADDRESS'], 0, 1);

		$pdf->SetXY(52, 171);
		$pdf->Cell(0, 8, $invoiceHdr['ADDRESS'] == NULL ? '-' : $invoiceHdr['ADDRESS'], 0, 1);

		$pdf->SetXY(50, 45);
		$pdf->Cell(0, 8, $invoiceHdr['HP'], 0, 1);

		$pdf->SetXY(52, 178);
		$pdf->Cell(0, 8, $invoiceHdr['HP'], 0, 1);

		$pdf->SetXY(142, 49);
		$pdf->Cell(0, 8, $invoiceHdr['SALES'], 0, 1);

		$pdf->SetXY(144, 181.5);
		$pdf->Cell(0, 8, $invoiceHdr['SALES'], 0, 1);

		$pdf->SetXY(73, 149.5);
		$pdf->Cell(0, 8, $invoiceHdr['FD'], 0, 1);

		$pdf->SetXY(75, 283);
		$pdf->Cell(0, 8, $invoiceHdr['FD'], 0, 1);



		// Isi Produk
		$pdf->SetFont('helvetica', '', 6);
		$y = 108;
		$total_bayar = 0;

		foreach ($invoicePayment as $item) {
			$total = $item['AMOUNT'];
			$total_bayar += $total;

			$pdf->SetXY(13, $y);
			$pdf->Cell(57, 10, $item['PAYMENT'], 0, 0);
			$pdf->Cell(100, 10, $item['EDC'], 0, 0);
			$pdf->Cell(30, 10, 'Rp ' . number_format($item['AMOUNT'], 0, ',', '.'), 0, 0);
			// $pdf->Cell(30, 10, 'Rp ' . number_format($total, 0, ',', '.'), 1, 1, 'R');

			$y += 3;
		}

		// // Total
		$pdf->SetFont('helvetica', 'B', 9);
		$pdf->SetXY(122, 124);
		$pdf->Cell(67, 0, 'Rp ' . number_format($total_bayar, 0, ',', '.'), 0, 1, 'R');


		$pdf->SetFont('helvetica', '', 6);
		$y = 242;
		$total_bayar = 0;

		foreach ($invoicePayment as $item) {
			$total = $item['AMOUNT'];
			$total_bayar += $total;

			$pdf->SetXY(15, $y);
			$pdf->Cell(157, 10, $item['PAYMENT'], 0, 0);
			$pdf->Cell(100, 10, $item['EDC'], 0, 0);
			$pdf->Cell(30, 10, 'Rp ' . number_format($item['AMOUNT'], 0, ',', '.'), 0, 0);
			// $pdf->Cell(30, 10, 'Rp ' . number_format($total, 0, ',', '.'), 1, 1, 'R');

			$y += 3;
		}

		// // Total
		$pdf->SetFont('helvetica', 'B', 9);
		$pdf->SetXY(122, 257);
		$pdf->Cell(67, 0, 'Rp ' . number_format($total_bayar, 0, ',', '.'), 0, 1, 'R');


		// // Simpan atau tampilkan PDF
		$pdf->Output('receipt_.pdf', 'I');

		// echo $invoiceHdr['INVOICENO'];
	}


	public function integrationLocation()
	{

		$db_oriskin = $this->load->database('oriskin', true);
		$context = stream_context_create([
			"ssl" => [
				"verify_peer" => false,
				"verify_peer_name" => false,
			]
		]);

		$api_url = "https://103.31.233.78:84/pilatesbyorislim/api/showEmployee";
		$response = file_get_contents($api_url, false, $context);
		$locations = json_decode($response, true);


		$existing_locations = $db_oriskin->select('id')
			->from('mslocation')
			->get()
			->result_array();

		$existing_exid = array_column($existing_locations, 'id');

		$new_data = [];

		if (!$locations) {
			echo "Gagal mengambil data dari API";
			return;
		}

		foreach ($locations['data'] as $location) {
			// echo json_encode($location);
			if (!in_array($location['id'], $existing_exid)) {
				$new_data[] = [
					// 'id'   => $location['id'],
					'address' => $location['address'],
					'name' => $location['name'],
					'shortcode' => $location['shortcode'],
					'cityid' => $location['cityid'],
					'companyname' => $location['companyname'],
					'isactive' => $location['isactive'],
					'updateuserid' => $location['updateuserid'],
				];
			}
		}

		if (!empty($new_data)) {
			$db_oriskin->insert_batch('mslocation', $new_data);
			echo "Data berhasil disinkronisasi!";
			echo json_encode($new_data);
		} else {
			echo "Tidak ada data baru untuk disinkronisasi.";
		}
	}

	public function settlementDownPayment()
	{

		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$prev = $this->input->post('prev');

		if (!$id) {
			echo json_encode(["success" => false, "message" => "ID tidak ditemukan"]);
			return;
		}

		$queryHeader = "";
		$queryDetailProduct = "";
		$queryPayment = "";

		if ($prev == 3) {
			$queryHeader = "SELECT 
			a.id as DPID, 
			a.customerid, 
			a.locationid, 
			a.salesid, 
			a.frontdeskid, 
			a.doctorid,
			b.firstname as FIRSTNAME, 
			b.lastname as LASTNAME, 
			c.name as SALESNAME, 
			d.name as FDNAME 
			from sldownpaymentproducthdr a 
			inner join mscustomer b on a.customerid = b.id 
			inner join msemployee c on a.salesid = c.id 
			inner join msemployee d on a.frontdeskid = d.id where a.id = $id

        ";

			$queryDetailProduct = "SELECT 
			b.id as PRODUCTID, 
			b.name as PRODUCTNAME, 
			b.code as PRODUCTCODE, 
			a.price as PRODUCTPRICE, 
			a.qty as PRODUCTJUMLAH, 
			a.discountpercent as DISCOUNTPERCENT, 
			a.discountvalue as DISCOUNTVALUE, 
			a.discountreason as DISCOUNTREASON, 
			a.totaldiscount as TOTALDISCOUNT, 
			a.total as TOTAL
			from sldownpaymentproductdtl a 
			inner join msproduct b on a.productid = b.id 
			where a.downpaymenthdrid = $id
		";

			$queryPayment = "SELECT 
			a.downpaymenthdrid as DPID, 
			SUM(a.amount) as AMOUNT, 
			a.edcid as EDCID, 
			a.cardid as CARDID, 
			a.cardbankid as CARDBANKID, 
			a.installmentid as INSTALLMENTID, 
			b.name as EDCNAME, 
			c.name as CARDNAME, 
			d.name as BANKNAME, 
			e.name as INSTALLMENTNAME 
			from sldownpaymentproductpayment a 
			left join msedc b on a.edcid = b.id 
			left join mscard c on  a.cardid = c.id 
			left join msbank d on a.cardbankid = d.id 
			left join msinstallment e on a.installmentid = e.id 
			where downpaymenthdrid = $id
			GROUP BY a.downpaymenthdrid, a.edcid, a.cardid, a.cardbankid,a.installmentid, b.name, c.name,d.name, e.name

		";
		} else if ($prev == 1) {

			$queryHeader = "SELECT 
			a.id as DPID, 
			a.customerid, 
			a.locationid, 
			a.salesid, 
			a.frontdeskid, 
			a.doctorid,
			b.firstname as FIRSTNAME, 
			b.lastname as LASTNAME, 
			c.name as SALESNAME, 
			d.name as FDNAME 
			from sldownpaymenttreatmenthdr a 
			inner join mscustomer b on a.customerid = b.id 
			inner join msemployee c on a.salesid = c.id 
			inner join msemployee d on a.frontdeskid = d.id where a.id = $id

        ";

			$queryDetailProduct = "SELECT 
			b.id as PRODUCTID, 
			b.name as PRODUCTNAME, 
			b.code as PRODUCTCODE, 
			a.price as PRODUCTPRICE, 
			a.qty as PRODUCTJUMLAH, 
			a.discountpercent as DISCOUNTPERCENT, 
			a.discountvalue as DISCOUNTVALUE, 
			a.discountreason as DISCOUNTREASON, 
			a.totaldiscount as TOTALDISCOUNT, 
			a.total as TOTAL
			from sldownpaymenttreatmentdtl a 
			inner join mstreatment b on a.productid = b.id 
			where a.downpaymenthdrid = $id
		";

			$queryPayment = "SELECT 
			a.downpaymenthdrid as DPID, 
			SUM(a.amount) as AMOUNT, 
			a.edcid as EDCID, 
			a.cardid as CARDID, 
			a.cardbankid as CARDBANKID, 
			a.installmentid as INSTALLMENTID, 
			b.name as EDCNAME, 
			c.name as CARDNAME, 
			d.name as BANKNAME, 
			e.name as INSTALLMENTNAME 
			from sldownpaymenttreatmentpayment a 
			left join msedc b on a.edcid = b.id 
			left join mscard c on  a.cardid = c.id 
			left join msbank d on a.cardbankid = d.id 
			left join msinstallment e on a.installmentid = e.id 
			where downpaymenthdrid = $id
			GROUP BY a.downpaymenthdrid, a.edcid, a.cardid, a.cardbankid,a.installmentid, b.name, c.name,d.name, e.name

		";
		} else {
			$queryHeader = "SELECT
			a.id as DPID, 
			a.customerid, 
			a.locationsalesid, 
			a.salesid, 
			a.frontdeskid, 
			a.doctorid,
			b.firstname as FIRSTNAME, 
			b.lastname as LASTNAME, 
			c.name as SALESNAME, 
			d.name as FDNAME 
			from sldownpaymentmembershiphdr a 
			inner join mscustomer b on a.customerid = b.id 
			inner join msemployee c on a.salesid = c.id 
			inner join msemployee d on a.frontdeskid = d.id where a.id = $id

        ";

			$queryDetailProduct = "SELECT 
			b.id as PRODUCTID, 
			b.name as PRODUCTNAME, 
			a.totalmonth as TM, 
			a.totalamount as TOTALAMOUNT,
			a.subscriptionmonth as SM,
			a.bonusmonth  as BM,
			a.registrationfee as ADMIN,
			a.termprice as TERMPRICE,
			a.monthlyfee as MONTHLYFEE,
			a.firstmonthfee as FIRSTMONTHFEE,
			a.lastmonthfee  as LASTMONTHFEE
			from sldownpaymentmembershipdtl a 
			inner join msproductmembershiphdr b on a.productmembershiphdrid = b.id
			where a.id = $id
		";

			$queryPayment = "SELECT 
			a.downpaymenthdrid as DPID, 
			SUM(a.amount) as AMOUNT, 
			a.edcid as EDCID, 
			a.cardid as CARDID, 
			a.cardbankid as CARDBANKID, 
			a.installmentid as INSTALLMENTID, 
			b.name as EDCNAME, 
			c.name as CARDNAME, 
			d.name as BANKNAME, 
			e.name as INSTALLMENTNAME 
			from sldownpaymentmembershippayment a 
			left join msedc b on a.edcid = b.id 
			left join mscard c on  a.cardid = c.id 
			left join msbank d on a.cardbankid = d.id 
			left join msinstallment e on a.installmentid = e.id 
			where downpaymenthdrid = $id
			GROUP BY a.downpaymenthdrid, a.edcid, a.cardid, a.cardbankid,a.installmentid, b.name, c.name,d.name, e.name

		";
		}


		$resultHeader = $db_oriskin->query($queryHeader)->result_array();
		$resultDetailProduct = $db_oriskin->query($queryDetailProduct)->result_array();
		$resultPayment = $db_oriskin->query($queryPayment)->result_array();

		if ($resultHeader) {
			echo json_encode(["success" => true, "dataHeader" => $resultHeader, "dataDetailProduct" => $resultDetailProduct, "dataPayment" => $resultPayment, "prev" => $prev]);
		} else {
			echo json_encode(["success" => false, "message" => "Data tidak ditemukan"]);
		}
	}


	public function insertTalent()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$post = array();
		foreach ($_POST as $k => $v) {
			$post[$k] = $this->input->post($k);
		}

		# Validasi
		$this->load->library('form_validation');
		$this->load->helper(['security', 'file']);

		$this->form_validation->set_rules('firstname', 'Nama Depan', 'required|trim|xss_clean|max_length[100]');
		$this->form_validation->set_rules('lastname', 'Nama Belakang', 'required|trim|xss_clean|max_length[100]');
		$this->form_validation->set_rules('cellphonenumber', 'Whatsapp', 'required|trim|numeric|min_length[7]|max_length[18]');
		$this->form_validation->set_rules('ssid', 'Nomer ID/KTP', 'trim|numeric|min_length[16]|max_length[16]');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode([
				'success' => false,
				'message' => validation_errors()
			]);
			exit;
		}

		# Cek nomor HP
		$val_no_hp = $post['cellphonenumber'];
		if (!preg_match('/^(08|62|31|65|61|44|09|66|60|05|96)/', $val_no_hp)) {
			echo json_encode([
				'success' => false,
				'message' => 'Nomor HP harus diawali dengan "08" atau "62"'
			]);
			exit;
		}

		# Cek apakah nomor sudah terdaftar
		$isexist = $this->MApp->isExist('cellphonenumber', $val_no_hp); // Gantilah dengan query validasi dari database

		if ($isexist) {
			echo json_encode([
				'success' => false,
				'message' => 'Nomor Whatsapp sudah terdaftar'
			]);
			exit;
		}

		// echo json_encode([
		// 	'success' => false,
		// 	'message' => 'Terjadi Kesalahan: ',
		// 	'data' => $post // Menampilkan error jika gagal
		// ]);

		$res = $this->MApp->insertTalent($post);

		if ($res) {
			echo json_encode([
				'success' => true,
				'message' => 'Registrasi Berhasil'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => 'Terjadi Kesalahan: ' . $res // Menampilkan error jika gagal
			]);
		}
	}

	public function insertTalentMarketing()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$post = array();
		foreach ($_POST as $k => $v) {
			$post[$k] = $this->input->post($k);
		}

		# Validasi
		$this->load->library('form_validation');
		$this->load->helper(['security', 'file']);

		$this->form_validation->set_rules('firstname', 'Nama Depan', 'required|trim|xss_clean|max_length[100]');
		$this->form_validation->set_rules('lastname', 'Nama Belakang', 'required|trim|xss_clean|max_length[100]');
		$this->form_validation->set_rules('cellphonenumber', 'Whatsapp', 'required|trim|numeric|min_length[7]|max_length[18]');
		$this->form_validation->set_rules('ssid', 'Nomer ID/KTP', 'trim|numeric|min_length[16]|max_length[16]');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode([
				'success' => false,
				'message' => validation_errors()
			]);
			exit;
		}

		# Cek nomor HP
		$val_no_hp = $post['cellphonenumber'];
		if (!preg_match('/^(08|62|31|65|61|44|09|66|60|05|96)/', $val_no_hp)) {
			echo json_encode([
				'success' => false,
				'message' => 'Nomor HP harus diawali dengan "08" atau "62"'
			]);
			exit;
		}

		# Cek apakah nomor sudah terdaftar
		$isexist = $this->MApp->isExist('cellphonenumber', $val_no_hp); // Gantilah dengan query validasi dari database

		if ($isexist) {
			echo json_encode([
				'success' => false,
				'message' => 'Nomor Whatsapp sudah terdaftar'
			]);
			exit;
		}


		$res = $this->MApp->insertTalentMarketing($post);

		if ($res) {
			echo json_encode([
				'success' => true,
				'message' => 'Registrasi Berhasil'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => 'Terjadi Kesalahan: ' . $res // Menampilkan error jika gagal
			]);
		}
	}


	function voidController()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$rev = $this->input->post('rev');

		if (is_null($id) || is_null($rev)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
		}

		$db_oriskin->where('id', $id);

		$update_data = [
			'status' => 3,
		];

		if ($rev == 1) {
			// echo json_encode([
			// 	'status' => 'success',
			// 	'message' => 'Data updated successfully',
			// 	'rev' => $rev
			// ]);

			if ($db_oriskin->update('slinvoicetreatmenthdr', $update_data)) {
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
		} elseif ($rev == 2) {
			// echo json_encode([
			// 	'status' => 'success',
			// 	'message' => 'Data updated successfully',
			// 	'rev' => $rev
			// ]);

			if ($db_oriskin->update('sldownpaymenttreatmenthdr', $update_data)) {
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
		} elseif ($rev == 3) {
			// echo json_encode([
			// 	'status' => 'success',
			// 	'message' => 'Data updated successfully',
			// 	'rev' => $rev
			// ]);

			if ($db_oriskin->update('slinvoicemembershiphdr', $update_data)) {
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
		} elseif ($rev == 4) {
			// echo json_encode([
			// 	'status' => 'success',
			// 	'message' => 'Data updated successfully',
			// 	'rev' => $rev
			// ]);

			if ($db_oriskin->update('sldownpaymentmembershiphdr', $update_data)) {
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
		} elseif ($rev == 5) {
			// echo json_encode([
			// 	'status' => 'success',
			// 	'message' => 'Data updated successfully',
			// 	'rev' => $rev
			// ]);

			if ($db_oriskin->update('slinvoicehdr', $update_data)) {
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
		} elseif ($rev == 6) {
			// echo json_encode([
			// 	'status' => 'success',
			// 	'message' => 'Data updated successfully',
			// 	'rev' => $rev
			// ]);

			if ($db_oriskin->update('sldownpaymentproducthdr', $update_data)) {
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
		} elseif ($rev == 7) {
			// echo json_encode([
			// 	'status' => 'success',
			// 	'message' => 'Data updated successfully',
			// 	'rev' => $rev
			// ]);

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
	}


	function print_invoiceSummary($type, $id)
	{
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

	function updateInvoiceMembershipHdr()
	{
		$post = array();
		foreach ($_POST as $k => $v)
			$post[$k] = $this->input->post($k);
		echo $this->MApp->updateInvoiceMembershipHdr($post);
	}

	function updateInvoiceTreatment()
	{
		$post = array();
		foreach ($_POST as $k => $v)
			$post[$k] = $this->input->post($k);
		echo $this->MApp->updateInvoiceTreatment($post);
	}

	function updateInvoiceProduct()
	{
		$post = array();
		foreach ($_POST as $k => $v)
			$post[$k] = $this->input->post($k);
		echo $this->MApp->updateInvoiceProduct($post);
	}

	function updateInvoiceDpTreatment()
	{
		$post = array();
		foreach ($_POST as $k => $v)
			$post[$k] = $this->input->post($k);
		echo $this->MApp->updateInvoiceDpTreatment($post);
	}

	function updateInvoiceDpMembership()
	{
		$post = array();
		foreach ($_POST as $k => $v)
			$post[$k] = $this->input->post($k);
		echo $this->MApp->updateInvoiceDpMembership($post);
	}

	function updateInvoiceDpProduct()
	{
		$post = array();
		foreach ($_POST as $k => $v)
			$post[$k] = $this->input->post($k);
		echo $this->MApp->updateInvoiceDpProduct($post);
	}


	public function getEmployeeBlockTime()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$date = $this->input->get("date");
		$employeeid = $this->input->get("employeeid");

		if (!$employeeid) {
			echo json_encode(["error" => "Employee tidak ditemukan"]);
			return;
		}

		$sqlBlocak = "
					SELECT *
					FROM msblockschedule 
					WHERE employeeid = ? AND (CONVERT(varchar(10), blockdate,120) = ?)
					";

		$params = [
			$employeeid,
			$date
		];

		$queryBlock = $db_oriskin->query($sqlBlocak, $params);

		if ($queryBlock) {
			echo json_encode([
				'success' => true,
				'blockEmployee' => $queryBlock->result()
			]);
		} else {
			echo json_encode([
				'success' => false,
				'blockEmployee' => $queryBlock->result()
			]);
		}


	}

	public function deleteEmployeeBlockTime()
	{
		$id = $this->input->post('id'); // id dari msblockschedule

		if (!$id) {
			echo json_encode([
				'success' => false,
				'message' => 'ID tidak ditemukan'
			]);
			return;
		}

		$db = $this->load->database('oriskin', true);

		$db->where('id', $id);
		$delete = $db->delete('msblockschedule');

		if ($delete) {
			echo json_encode([
				'success' => true,
				'message' => 'Block time berhasil dihapus'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => 'Gagal menghapus block time'
			]);
		}
	}

	public function get_schedule()
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

		// Pisahkan `period` dan `tgl_absen` dari `selected_date`
		$date_parts = explode("-", $selected_date);
		if (count($date_parts) < 3) {
			echo json_encode(["error" => "Format tanggal salah"]);
			return;
		}

		$query = $db_oriskin->query(
			"
            EXEC spClinicBookAppointmentEmployee ?, ?",
			array($selected_date, $locationid)
		);

		$queryTreatments = $db_oriskin->query("
        	EXEC spClinicBookAppointment ?, ?
    	", [$selected_date, $locationid]);


		$sqlBlocak = "
					SELECT a.*,
					CASE 
						WHEN b.id = 6 THEN '10:00'
						ELSE b.starttimeoperational 
					END as starttimeoperational
					FROM msblockschedule a inner join mslocation b
					ON a.locationid = b.id
						WHERE a.locationid = ? 
						AND (CONVERT(varchar(10), a.blockdate,120) = ?)
					";

		$params = [
			$locationid,
			$selected_date,
		];

		$queryBlock = $db_oriskin->query($sqlBlocak, $params);

		echo json_encode([
			'employees' => $query->result(),
			'treatments' => $queryTreatments->result(),
			'blockEmployee' => $queryBlock->result()
		]);
	}
	public function saveBookAppointement()
	{
		error_reporting(0);
		ini_set('display_errors', 0);

		$userid = $this->session->userdata('userid');

		if (!$userid) {
			$this->load->view('login');
			return;
		}
		$id = $this->input->post("id");
		$dataCreate = [
			"remarks" => $this->input->post("remarks"),
			"duration" => $this->input->post("duration"),
			"appointmentdate" => $this->input->post("appointmentdate"),
			"booktime" => $this->input->post("starttreatment"),
			"locationid" => $this->input->post("locationId"),
			"customerid" => $this->input->post("customerid"),
			"employeeid" => $this->input->post("employeeid"),
			"status" => $this->input->post("status"),
			"bookinputbyemployeeid" => $this->input->post("employeeBooking"),
			"createbyuserid" => $userid,
			"createdate" => date("Y-m-d H:i:s"),
		];

		$dataUpdate = [
			"remarks" => $this->input->post("remarks"),
			"duration" => $this->input->post("duration"),
			"appointmentdate" => $this->input->post("appointmentdate"),
			"booktime" => $this->input->post("starttreatment"),
			"locationid" => $this->input->post("locationId"),
			"customerid" => $this->input->post("customerid"),
			"employeeid" => $this->input->post("employeeid"),
			"status" => $this->input->post("status"),
			"bookinputbyemployeeid" => $this->input->post("employeeBooking"),
			"updateuserid" => $userid,
			"updatedate" => date("Y-m-d H:i:s"),
		];

		if ($id != "") {
			$result = $this->MApp->updateAppointment($id, $dataUpdate);
		} else {
			$result = $this->MApp->addAppointment($dataCreate);
		}
		echo json_encode($result);
	}

	public function searchCustomer()
	{
		$search = $this->input->get('search');
		$data = $this->MApp->search_customers($search);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => "{$row->firstname} {$row->lastname} - {$row->cellphonenumber} ({$row->customercode})"
			];
		}
		echo json_encode($result);
	}


	public function searchItems()
	{
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

	public function searchServices()
	{
		$search = $this->input->get('search');
		$data = $this->MApp->searchServices($search);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => "{$row->code} - {$row->name}",
				'service' => $row->name,
				'price' => $row->price,
				'ingredientscategoryid' => $row->ingredientscategoryid
			];
		}

		echo json_encode($result);
	}

	public function searchServicesCogs()
	{
		$search = $this->input->get('search');
		$data = $this->MApp->searchServicesCogs($search);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => "{$row->code} - {$row->name}",
				'service' => $row->name,
				'price' => $row->price,
				'ingredientscategoryid' => $row->ingredientscategoryid
			];
		}

		echo json_encode($result);
	}

	public function searchSalon()
	{
		$search = $this->input->get('search');
		$data = $this->MApp->searchSalon($search);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => "{$row->code} - {$row->name}"
			];
		}

		echo json_encode($result);
	}

	public function updateAppointmentAfterDrop()
	{

		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$userid = $this->session->userdata('userid');
		$id = $this->input->post("id");
		$employeeid = $this->input->post("employeeid");
		$starttreatment = $this->input->post("starttreatment");

		// Lakukan pembaruan data di database
		$data = [
			"employeeid" => $employeeid,
			"booktime" => $starttreatment,
			"updatedate" => date("Y-m-d H:i:s"),
			"updateuserid" => $userid // Sesuaikan dengan session user
		];

		$db_oriskin->where("id", $id);
		$result = $db_oriskin->update("trbookappointment", $data);

		if ($result) {
			echo json_encode(["status" => "success", "message" => "Appointment berhasil diperbarui.", "data" => $data]);
		} else {
			echo json_encode(["status" => "error", "message" => "Gagal memperbarui appointment.", "data" => $data]);
		}
	}

	public function prepaidConsumption()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$userid = $this->session->userdata('userid');

		if (!$userid) {
			$this->load->view('login');
			return;
		}

		$customerid = $this->input->get('customerid', TRUE);
		$locationId = $this->input->get('locationId', TRUE);
		$appointmentId = $this->input->get('appointmentId', TRUE);
		$employeeid = $this->input->get('employeeid', TRUE);

		$data['customerName'] = $this->input->get('customerName', TRUE);
		$data['remarks'] = $this->input->get('remarks', TRUE);
		$data['duration'] = $this->input->get('duration', TRUE);
		$data['appointmentId'] = $this->input->get('appointmentId', TRUE);
		$data['appointmentdate'] = $this->input->get('appointmentdate', TRUE);
		$data['employeeid'] = $this->input->get('employeeid', TRUE);
		$data['customerid'] = $this->input->get('customerid', TRUE);
		$data['starttreatment'] = $this->input->get('starttreatment', TRUE);
		$data['locationId'] = $this->input->get('locationId', TRUE);
		$data['status'] = $this->input->get('status', TRUE);

		$data['membership_treatment'] = $this->MApp->getPrepaidCustomerMembership($customerid);
		$data['history_doing'] = $this->MApp->getPrepaidCustomerHistory($customerid);
		$data['treatment_info'] = $this->MApp->getPrepaidCustomerTreatmentDev($customerid);
		$data['appointmentDetail'] = $this->MApp->getAppointmentDetail($appointmentId);
		$data['assist_by'] = $this->MApp->getAssistPrepaid($locationId, $employeeid);
		$data['frontdesk'] = $this->MApp->getFrontdeskPrepaid($locationId);
		$data['employeeDoing'] = $this->MApp->getEmployeeDoing($locationId);
		$data['membership_treatmentBenefit'] = $this->MApp->getPrepaidCustomerMembershipBenefit($customerid);

		$data['title'] = 'Prepaid Consumption';
		$data['content'] = 'prepaidConsumption';

		$this->load->view('index', $data);
	}


	public function detailPrepaidConsumption()
	{
		error_reporting(0);
		ini_set('display_errors', 0);

		$appointmentId = $this->input->get("appointmentId");

		$result = $this->MApp->detailPrepaidConsumption($appointmentId);

		echo json_encode($result);
	}

	function savePrepaidConsumption()
	{

		error_reporting(0);
		ini_set('display_errors', 0);
		$post = $this->input->post();
		$db_oriskin = $this->load->database('oriskin', true);

		$data = [
			"treatmentdate" => $post['treatmentdate'],
			"starttreatment" => $post['starttreatment'],
			"endtreatment" => $post['endtreatment'],
			"duration" => $post['duration'],
			"locationid" => $post['locationid'],
			"frontdeskid" => $post['frontdeskid'],
			"producttreatmentid" => $post['producttreatmentid'],
			"customerid" => $post['idfromdb'],
			"treatmentdoingbyid" => $post['treatmentdoingbyid'],
			"treatmentassistbyid" => !empty($post['treatmentassistbyid']) ? $post['treatmentassistbyid'] : NULL,
			"invoiceno" => $post['invoiceno'],
			"qty" => 1,
			"voucherused" => $post['voucherused'],
			"status" => 16,
			"updateuserid" => $this->session->userdata('userid'),
			"updatedate" => date("Y-m-d H:i:s"),
			"bookingid" => $post['bookingid'],
			"remarks" => $post['remarks']
		];

		try {
			$db_oriskin->insert('trdoingtreatment', $data);
			echo json_encode(["status" => "success", "message" => "Data berhasil disimpan"]);
		} catch (Exception $e) {
			echo json_encode(["status" => "error", "message" => $e->getMessage()]);
		}
	}

	public function updatePrepaidConsumption()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');

		if (is_null($id)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
		}

		$db_oriskin->where('id', $id);

		$update_data = [
			'status' => 3,
		];


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

	public function updatePrepaidConsumptionV2()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$post = $this->input->post();
		$db_oriskin = $this->load->database('oriskin', true);

		$id = $post['updateId'] ?? null;
		$doingBy = $post['doingBy'] ?? null;
		$assistBy = $post['assistBy'] ?? null;

		// Validasi input
		if (empty($id) || empty($doingBy)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
			return;
		}

		// Data yang akan diupdate
		$update_data = [
			'treatmentdoingbyid' => $doingBy,
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


	public function updateBookAppointment()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$appointmentId = $this->input->post('appointmentId');

		if (empty($appointmentId)) {
			echo json_encode(['success' => false, 'message' => 'Appointment ID is required']);
			return;
		}

		$db_oriskin = $this->load->database('oriskin', true);

		$updateBook = [
			'status' => 5,
			'updatedate' => date('Y-m-d H:i:s'),
			'updateuserid' => $this->session->userdata('userid')
		];

		$db_oriskin->where('id', $appointmentId);
		$updateBookSuccess = $db_oriskin->update('trbookappointment', $updateBook);


		$updateTreatment = [
			'status' => 17,
			'updatedate' => date('Y-m-d H:i:s'),
			'updateuserid' => $this->session->userdata('userid')
		];

		$db_oriskin->where('bookingid', $appointmentId);
		$db_oriskin->where('status !=', 3);
		$updateTreatmentSuccess = $db_oriskin->update('trdoingtreatment', $updateTreatment);

		if ($updateBookSuccess && $updateTreatmentSuccess) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to update']);
		}
	}

	public function getDetailPackage()
	{
		error_reporting(0);
		ini_set('display_errors', 0);

		$packageid = $this->input->get('packageid');


		$result = $this->MApp->getDetailPackage($packageid);

		echo json_encode($result);
	}


	public function reportGuestAffiliate($empid)
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$dateStart = $this->input->post('dateStart') ? $this->input->post('dateStart') : date('Y-m-d');
		$dateEnd = $this->input->post('dateEnd') ? $this->input->post('dateEnd') : date('Y-m-d');
		$data = [
			'reportGuestAffiliate' => $this->MApp->getReportGuestAffiliate($dateStart, $dateEnd, $empid),
			'title' => 'REPORT GUEST AFFILIATE',
			'content' => 'reportGuestAffiliate',
			'dateStart' => $dateStart,
			'dateEnd' => $dateEnd,
			'empId' => $empid
		];

		$this->load->view('index', $data);
	}


	public function add_affiliate()
	{

		$db_oriskin = $this->load->database('oriskin', true);
		$db_oriskin->trans_start();
		$userid = $this->session->userdata('userid');
		$employeeData = array(
			'name' => $this->input->post('affiliateName'),
			'cellphonenumber' => $this->input->post('affiliateCellphoneNumber'),
			'updatedate' => date('Y-m-d H:i:s'),
			'updateuserid' => $userid,
			'isactive' => 1,
			'title' => 'AFFILIATE'
		);

		$employeeID = $this->MApp->insert_employee($employeeData);

		if ($employeeID) {
			// Data untuk `msemployeedetail`
			$employeeDetailData = array(
				'employeeid' => $employeeID,
				'fromemployeeid' => $this->input->post('fromemployeeid'),
				'locationid' => 6,
				'updatedate' => date('Y-m-d H:i:s'),
				'jobid' => 4,
				'statusid' => 2,
				'updateuserid' => $userid,
				'startdate' => $this->input->post('startDate'),
				'accountnumber' => $this->input->post('accountNumber')

			);

			$detailInserted = $this->MApp->insert_employee_detail($employeeDetailData); // Insert ke `msemployeedetail`
		}

		$db_oriskin->trans_complete();

		if ($db_oriskin->trans_status()) {
			echo json_encode(['success' => true, 'date' => $employeeID]);
		} else {
			echo json_encode(['success' => false, 'date' => $employeeID]);
		}
	}


	public function getPaymentTypes()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$query = $db_oriskin->get_where("mspaymenttype", ["isactive" => 1]);
		echo json_encode($query->result());
	}

	public function updatePayment()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$paymentType = $this->input->post('paymentType');
		$amount = $this->input->post('amount');

		$type = $this->input->post('type');

		$db_oriskin->where('id', $id);

		if ($type == 1) {
			if (
				$db_oriskin->update('slinvoicetreatmentpayment', [
					'paymentid' => $paymentType,
					'amount' => $amount
				])
			) {
				echo json_encode(['status' => 'berhasil']);
			} else {
				echo json_encode(['status' => 'gagal']);
			}
		} elseif ($type == 2) {

			if (
				$db_oriskin->update('slinvoicemembershippayment', [
					'paymentid' => $paymentType,
					'amount' => $amount
				])
			) {
				echo json_encode(['status' => 'berhasil']);
			} else {
				echo json_encode(['status' => 'gagal']);
			}
		} elseif ($type == 3) {

			if (
				$db_oriskin->update('slinvoicepayment', [
					'paymentid' => $paymentType,
					'amount' => $amount
				])
			) {
				echo json_encode(['status' => 'berhasil']);
			} else {
				echo json_encode(['status' => 'gagal']);
			}
		} elseif ($type == 4) {

			if (
				$db_oriskin->update('sldownpaymenttreatmentpayment', [
					'paymentid' => $paymentType,
					'amount' => $amount
				])
			) {
				echo json_encode(['status' => 'berhasil']);
			} else {
				echo json_encode(['status' => 'gagal']);
			}
		} elseif ($type == 5) {

			if (
				$db_oriskin->update('sldownpaymentmembershippayment', [
					'paymentid' => $paymentType,
					'amount' => $amount
				])
			) {
				echo json_encode(['status' => 'berhasil']);
			} else {
				echo json_encode(['status' => 'gagal']);
			}
		} elseif ($type == 6) {

			if (
				$db_oriskin->update('sldownpaymentproductpayment', [
					'paymentid' => $paymentType,
					'amount' => $amount
				])
			) {
				echo json_encode(['status' => 'berhasil']);
			} else {
				echo json_encode(['status' => 'gagal']);
			}
		}


		// echo json_encode(['status' => 'success']);
	}

	// public function updateInvoiceDetail()
	// {
	// 	error_reporting(0);
	// 	ini_set('display_errors', 0);
	// 	$db_oriskin = $this->load->database('oriskin', true);
	//     $id = $this->input->post('id');
	//     $qty = $this->input->post('qty');
	//     $total = $this->input->post('total');

	//     $db_oriskin->where('id', $id);
	//     $db_oriskin->update('slinvoicetreatmentdtl', [
	//         'qty' => $qty,
	//         'total' => $total
	//     ]);

	//     echo json_encode(['status' => 'success']);
	// }

	public function updateInvoiceHdr()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$salesid = $this->input->post('salesid');
		$consultantid = $this->input->post('consultantid');
		$assistid = $this->input->post('assistid');
		$status = $this->input->post('status');
		$invoicedate = $this->input->post('invoicedate');
		$type = $this->input->post('type');

		// Validasi input
		if (empty($id) || empty($status) || empty($invoicedate)) {
			echo json_encode(["success" => false, "message" => "Data tidak boleh kosong"]);
			return;
		}

		$data = [
			'salesid' => $salesid,
			'consultantid' => $consultantid == "" ? NULL : $consultantid,
			'assistid' => $assistid == "" ? NULL : $assistid,
			'status' => $status,
			'invoicedate' => $invoicedate
		];

		$dataRetail = [
			'salesid' => $salesid,
			'consultantid' => $consultantid == "" ? NULL : $consultantid,
			'doctorid' => $assistid == "" ? NULL : $assistid,
			'status' => $status,
			'invoicedate' => $invoicedate
		];

		$dataDownpayment = [
			'salesid' => $salesid,
			'status' => $status,
			'downpaymentdate' => $invoicedate
		];

		$db_oriskin->where('id', $id);

		if ($type == 1) {
			if ($db_oriskin->update('slinvoicetreatmenthdr', $data)) {
				echo json_encode(["success" => true, 'date' => $data]);
			} else {
				echo json_encode(["success" => false, 'date' => $data]);
			}
		} elseif ($type == 2) {
			if ($db_oriskin->update('slinvoicemembershiphdr', $data)) {
				echo json_encode(["success" => true, 'date' => $data]);
			} else {
				echo json_encode(["success" => false, 'date' => $data]);
			}
		} elseif ($type == 3) {
			if ($db_oriskin->update('slinvoicehdr', $dataRetail)) {
				echo json_encode(["success" => true, 'date' => $dataRetail]);
			} else {
				echo json_encode(["success" => false, 'date' => $dataRetail]);
			}
		} elseif ($type == 4) {
			if ($db_oriskin->update('sldownpaymenttreatmenthdr', $dataDownpayment)) {
				echo json_encode(["success" => true, 'date' => $dataDownpayment]);
			} else {
				echo json_encode(["success" => false, 'date' => $dataDownpayment]);
			}
		} elseif ($type == 5) {
			if ($db_oriskin->update('sldownpaymentmembershiphdr', $dataDownpayment)) {
				echo json_encode(["success" => true, 'date' => $dataDownpayment]);
			} else {
				echo json_encode(["success" => false, 'date' => $dataDownpayment]);
			}
		} elseif ($type == 6) {
			if ($db_oriskin->update('sldownpaymentproducthdr', $dataDownpayment)) {
				echo json_encode(["success" => true, 'date' => $dataDownpayment]);
			} else {
				echo json_encode(["success" => false, 'date' => $dataDownpayment]);
			}
		}
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

		$db_oriskin->trans_begin();

		$data_hdr = [
			'toLocationId' => $post['toLocationId'] == "" ? NULL : $post['toLocationId'],
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
			'fromLocationId' => $post['fromLocationId'],
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

		$type = $post['type'];

		$data_hdr = [
			'toLocationId' => $post['toLocationId'] == "" ? NULL : $post['toLocationId'],
			'updateuserid' => $userid,
			'stockoutdate' => $post['stockoutdate'],
			'remarks' => $post['remarks'] == "" ? NULL : $post['remarks'],
			'refferenceno' => $post['refferenceno'] == "" ? NULL : $post['refferenceno'],
			'status' => $post['status'],
			'stockmovement' => $post['stockmovement'],
			'issuedby' => $post['issuedby'] == "" ? NULL : $post['issuedby'],
			'fromLocationId' => $post['fromLocationId'],
		];

		$data_hdrstockin = [
			'toLocationId' => $post['toLocationId'] == "" ? NULL : $post['toLocationId'],
			'updateuserid' => $userid,
			'stockindate' => $post['stockoutdate'],
			'remarks' => $post['remarks'] == "" ? NULL : $post['remarks'],
			'refferenceno' => $post['refferenceno'] == "" ? NULL : $post['refferenceno'],
			'status' => $post['status'],
			'stockmovement' => $post['stockmovement'],
			'issuedby' => $post['issuedby'] == "" ? NULL : $post['issuedby'],
			'supplierid' => $post['supplierid'] == "" ? NULL : $post['supplierid'],
			'fromLocationId' => $post['fromLocationId'],
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

		$db_oriskin->trans_begin();

		$data_hdr = [
			'tolocationid' => $post['toLocationId'] == "" ? NULL : $post['toLocationId'],
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
			'fromlocationid' => $post['fromLocationId'],
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


	public function createDoNo()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$type = $this->input->post('type');

		$shortcode = 'DO';
		$tahun = date('Y');
		$bulan = date('m');
		$newNumber = str_pad($id + 1, 4, '0', STR_PAD_LEFT);
		$itemsCode = $shortcode . $tahun . $bulan . $newNumber;

		if (empty($id)) {
			echo json_encode(["success" => false, "message" => "Data tidak boleh kosong"]);
			return;
		}

		$data = [
			'dono' => $itemsCode,
		];

		$db_oriskin->where('id', $id);

		if ($type == 1) {
			if ($db_oriskin->update('msingredientsstockout', $data)) {
				echo json_encode(["success" => true, 'dono' => $data]);
			} else {
				echo json_encode(["success" => false, 'dono' => $data]);
			}
		}
	}

	public function updatePackage()
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

		$type = $post['type'];

		$data_hdr = [
			'isactive' => $post['isactive'],
			'code' => $post['code'],
			'name' => $post['name'],
		];

		$db_oriskin->where('id', $id);
		$db_oriskin->update('msproductmembershiphdr', $data_hdr);

		if (isset($post['totalprice'])) {
			$data_hdrstockin = [
				'totalprice' => $post['totalprice'],
			];

			$db_oriskin->where('productmembershiphdrid', $id);
			$db_oriskin->update('msproductmembershipdtl', $data_hdrstockin);
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

	public function deleteBenefit()
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

		$deleted_data = $db_oriskin->get_where('msproductmembershipbenefit', ['id' => $id])->row_array();

		if (!$deleted_data) {
			throw new Exception('Data not found');
		}

		$db_oriskin->where('id', $id);
		$db_oriskin->delete('msproductmembershipbenefit');

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

	public function addBenefit()
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

		foreach ($post['itemList'] as $items) {
			$data_hdr = [
				'membershipbenefitid' => $post['productbenefitid'] == "" ? NULL : $post['productbenefitid'],
				'treatmentid' => $items['itemid'],
				'treatmenttimespermonth' => $items['qty'],
				'isactive' => 1,
				'updateuserid' => $userid,
				'benefitcategoryid' => $items['benefitid'],
				'productid' => 0,
				'productname' => "",
				'price' => $items['price'],
				'treatmentname' => $items['servicename'],
				'membershipname' => $post['name'] == "" ? NULL : $post['name'],
			];

			$db_oriskin->insert('msproductmembershipbenefit', $data_hdr);
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

	public function addPackage()
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

		$data_hdr = [
			'name' => $post['name'],
			'producttypeid' => 1,
			'productgroupid' => 1,
			'productcategoryid' => 7,
			'alllocation' => 0,
			'isactive' => $post['isactive'],
			'updateuserid' => $userid,
			'code' => $post['code'],
		];
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
			'totalprice' => $post['totalprice'],
			'subscriptionmonth' => 1,
			'bonusmonth' => 0,
			'totalmonth' => 1,
			'isactive' => 1,
			'updateuserid' => $userid,
		];

		$db_oriskin->insert('msproductmembershipdtl', $data_dtl);

		foreach ($post['itemList'] as $items) {
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
				'membershipname' => $post['name'] == "" ? NULL : $post['name'],
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

	public function updateAffiliate()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$fromemployeeid = $this->input->post('fromemployeeid');
		$affiliatename = $this->input->post('affiliatename');
		$accountnumber = $this->input->post('accountnumber');
		$status = $this->input->post('status');

		if (empty($id) || empty($fromemployeeid) || empty($affiliatename) || empty($accountnumber)) {
			echo json_encode(["success" => false, "message" => "Data tidak boleh kosong"]);
			return;
		}

		$dataDetail = [
			'fromemployeeid' => $fromemployeeid,
			'accountnumber' => $accountnumber,
		];

		$dataHeader = [
			'name' => $affiliatename,
			'isactive' => $status,
		];

		$db_oriskin->trans_begin();

		$db_oriskin->where('employeeid', $id);
		$updateDetail = $db_oriskin->update('msemployeedetail', $dataDetail);

		$db_oriskin->where('id', $id);
		$updateHeader = $db_oriskin->update('msemployee', $dataHeader);

		if ($updateDetail && $updateHeader) {
			$db_oriskin->trans_commit(); // Simpan perubahan
			echo json_encode(["success" => true, 'data' => array_merge($dataDetail, $dataHeader)]);
		} else {
			$db_oriskin->trans_rollback(); // Batalkan perubahan jika gagal
			echo json_encode(["success" => false, "message" => "Gagal memperbarui data"]);
		}
	}

	public function addCogs()
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
				'ingredientscategoryid' => $post['ingredientscategoryid'],
				'ingredientsid' => $items['itemid'],
				'qty' => $items['qty'],
				'price' => $items['price'],
			];

			$db_oriskin->insert('mstreatmentingredients', $data_hdr);
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

	public function updateCogs()
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
			'isactive' => $post['isactive'],
			'code' => $post['code'],
			'name' => $post['name'],
			'treatmentgroupid' => $post['group'],
			'section' => $post['section'],
			'price' => $post['price'],
		];

		$db_oriskin->where('id', $id);
		$db_oriskin->update('mstreatment', $data_hdr);

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

	public function deleteCogs()
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

		$deleted_data = $db_oriskin->get_where('mstreatmentingredients', ['id' => $id])->row_array();

		if (!$deleted_data) {
			throw new Exception('Data not found');
		}

		$db_oriskin->where('id', $id);
		$db_oriskin->delete('mstreatmentingredients');

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

	public function addService()
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

		$data_hdr = [
			'name' => $post['name'],
			'code' => $post['code'],
			'productcategoryid' => 10,
			'price' => $post['price'],
			'treatmenttimes' => 1,
			'freetreatmenttimes' => 0,
			'durmin' => 60,
			'isactive' => $post['isactive'],
			'updateuserid' => $userid,
			'treatmentgroupid' => $post['group'],
			'section' => $post['section'],
		];
		$db_oriskin->insert('mstreatment', $data_hdr);
		$serviceid = $db_oriskin->insert_id();

		$data_ingredientscategoryid = [
			'ingredientscategoryid' => $serviceid
		];

		$db_oriskin->where('id', $serviceid);
		$db_oriskin->update('mstreatment', $data_ingredientscategoryid);

		foreach ($post['itemList'] as $items) {
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

	public function updateRetail()
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
			'isactive' => $post['isactive'],
			'code' => $post['code'],
			'name' => $post['name'],
			'price1' => $post['price1'],
		];

		$db_oriskin->where('id', $id);
		$db_oriskin->update('msproduct', $data_hdr);

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

	public function addRetail()
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

		$data_retail = [
			'name' => $post['name'],
			'code' => $post['code'],
			'uomid' => 1,
			'supplierid' => 1,
			'productcategoryid' => 15,
			'price1' => $post['price'],
			'price2' => 0,
			'price3' => 0,
			'price4' => 0,
			'price5' => 0,
			'isactive' => $post['isactive'],
			'updateuserid' => $userid,
		];

		$data_stock = [
			'name' => $post['name'],
			'code' => $post['code'],
			'unitid' => 21,
			'price' => $post['price'],
			'cost' => 0,
			'lowestprice' => 0,
			'section' => 0,
			'qtypersatuan' => 1,
			'isactive' => $post['isactive'],
		];

		// $db_oriskin->insert('msproduct', $data_hdr);
		$serviceid = $db_oriskin->insert_id();

		$data_ingredientscategoryid = [
			'ingredientscategoryid' => $serviceid
		];

		$db_oriskin->where('id', $serviceid);
		$db_oriskin->update('mstreatment', $data_ingredientscategoryid);

		foreach ($post['itemList'] as $items) {
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

	public function updateStockIn()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$stockinqty = $this->input->post('stockinqty');


		if (empty($id) || empty($stockinqty)) {
			echo json_encode(["success" => false, "message" => "Data tidak boleh kosong"]);
			return;
		}

		$dataDetail = [
			'stockinqty' => $stockinqty,
		];

		$db_oriskin->trans_begin();

		$db_oriskin->where('id', $id);
		$updateDetail = $db_oriskin->update('itemstockin', $dataDetail);

		if ($updateDetail) {
			$db_oriskin->trans_commit(); // Simpan perubahan
			echo json_encode(["success" => true, 'data' => array_merge($dataDetail)]);
		} else {
			$db_oriskin->trans_rollback(); // Batalkan perubahan jika gagal
			echo json_encode(["success" => false, "message" => "Gagal memperbarui data"]);
		}
	}

	public function updateCustomer()
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
			'firstname' => $post['firstname'],
			'lastname' => $post['lastname'],
			'cellphonenumber' => $post['cellphonenumber'],
			'customercode' => $post['customercode'],
			'email' => $post['email'],
			'ssid' => $post['ssid'],
			'dateofbirth' => $post['dateofbirth'],
		];

		$db_oriskin->where('id', $id);
		$db_oriskin->update('mscustomer', $data_hdr);

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
			'jobid' => $post['jobid']
		];

		$db_oriskin->where('employeeid', $id);
		$db_oriskin->update('msemployeedetail', $data_hdr);

		$dataHeader = [
			'isactive' => $post['isactive']
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

	public function copyCogs()
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
			'ingredientscategoryid' => $post['serviceid']
		];

		$db_oriskin->where('id', $id);
		$db_oriskin->update('mstreatment', $data_hdr);

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


	public function savePrepaidConsumptionV2()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$location_id = $this->session->userdata('locationid');
		$post = json_decode(file_get_contents('php://input'), true);

		if (!$post) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
			return;
		}

		$db_oriskin->trans_begin();

		foreach ($post['prepaid'] as $product) {
			$data_hdr = [
				"treatmentdate" => $post['treatmentdate'],
				"starttreatment" => $post['starttreatment'],
				"endtreatment" => $post['endtreatment'],
				"duration" => $post['duration'],
				"locationid" => $post['locationid'],
				"frontdeskid" => $product['frontdeskid'],
				"producttreatmentid" => $product['producttreatmentid'],
				"customerid" => $post['idfromdb'],
				"treatmentdoingbyid" => $post['treatmentdoingbyid'],
				"treatmentassistbyid" => $product['treatmentassistbyid'] == "" ? NULL : $product['treatmentassistbyid'],
				"invoiceno" => $product['invoiceno'],
				"qty" => $product['qty'],
				"voucherused" => $post['voucherusedno'],
				"status" => 17,
				"updateuserid" => $this->session->userdata('userid'),
				"updatedate" => date("Y-m-d H:i:s"),
				"bookingid" => $post['bookingid'],
				"remarks" => $post['remarks']
			];
			$db_oriskin->insert('trdoingtreatment', $data_hdr);
		}

		$updateBook = [
			'status' => 5,
			'updatedate' => date('Y-m-d H:i:s'),
			'updateuserid' => $this->session->userdata('userid')
		];

		$db_oriskin->where('id', $post['bookingid']);
		$db_oriskin->update('trbookappointment', $updateBook);


		if ($db_oriskin->trans_status() === FALSE) {
			$error = $db_oriskin->error();
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => $post['bookingid'], 'error' => $error]);
		} else {
			$db_oriskin->trans_commit();
			echo json_encode(['status' => 'success']);
		}
	}

	public function updateTimeBlock()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$blockId = $this->input->post('blockId');
		$startTime = $this->input->post('startTime');
		$endTime = $this->input->post('endTime');
		$blockDate = $this->input->post('blockDate');
		$locationId = $this->input->post('locationId');
		$employeeIdBlock = $this->input->post('employeeIdBlock');
		$remarksBlock = $this->input->post('remarksBlock');

		$db_oriskin->trans_begin();

		$data = [
			'timeblockstart' => $startTime,
			'timeblockend' => $endTime,
			'employeeid' => $employeeIdBlock,
			'locationid' => $locationId,
			'remarks' => $remarksBlock,
			'blockdate' => $blockDate
		];

		if (!$blockId) {
			$db_oriskin->insert('msblockschedule', $data);
		} else {
			$db_oriskin->where('id', $blockId);
			$db_oriskin->update('msblockschedule', $data);
		}

		if ($db_oriskin->trans_status() === FALSE) {
			$error = $db_oriskin->error();
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'message' => 'Transaction failed', 'error' => $error]);
		} else {
			$db_oriskin->trans_commit();
			echo json_encode(['status' => 'success']);
		}
	}

	public function getEmployeeBookingList()
	{
		$level = $this->session->userdata('level');
		$locationId = $this->input->post('locationId');

		// Query untuk mendapatkan daftar employee booking sesuai date & location
		$data = $this->MApp->getEmployeeForBooking($locationId, $level);

		echo json_encode($data);
	}


	public function addAdjusmentTreatmentWess()
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

		foreach ($post['itemList'] as $items) {
			$itemadjusment = [
				'locationid' => $post['invoiceLocationId'] == "" ? NULL : $post['invoiceLocationId'],
				'invoiceno' => $items['invoiceno'],
				'productid' => $items['itemid'],
				'qty' => $items['qty'],
				'qtytotal' => $items['qtytotal'] == "" ? NULL : $items['qtytotal'],
				'customerid' => $post['customerId'] == "" ? NULL : $post['customerId'],
				'purchasedate' => $items['purchasedate'],
				'amount' => $items['amount'],
				'status' => 1,
				'updateuserid' => $userid,
				'updatedate' => date('Y-m-d H:i:s'),
			];

			$db_oriskin->insert('msadjusmentwesstreatment', $itemadjusment);
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


	public function addChangeTreatmentMixMax()
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

		foreach ($post['itemList'] as $items) {
			$itemadjusment = [
				'doingid' => $items['doingid'],
				'treatmentid' => $items['itemid'],
				'qty' => $items['qty'],
				'createbyuserid' => $userid,
			];

			$db_oriskin->insert('mschangetreatmentprepaid', $itemadjusment);
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

	public function addTargetOutlet()
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

		foreach ($post['itemList'] as $items) {

			$locationid = $items['locationid'];
			$period = $items['period'];
			$target = $items['target'];
			$targetunit = $items['targetunit'];

			$existing = $db_oriskin->get_where('mstarget', [
				'locationid' => $locationid,
				'period' => $period
			])->row();


			$data = [
				'targetbep' => $target,
				'updateuserid' => $userid,
				'updatedate' => date('Y-m-d H:i:s'),
				'targetmembership' => 0,
				'targetspendro' => 0,
				'targetnailtrix' => 0,
				'targetreccuring' => 0,
				'targetmps' => 0,
				'targettreatmentori' => 0,
				'targetproduct' => 0,
				'targetunit' => $targetunit
			];

			if ($existing) {
				$db_oriskin->where('locationid', $locationid);
				$db_oriskin->where('period', $period);
				$db_oriskin->update('mstarget', $data);
			} else {
				$data['locationid'] = $locationid;
				$data['period'] = $period;
				$db_oriskin->insert('mstarget', $data);
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

	public function addTargetConsultant()
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

		foreach ($post['itemList'] as $items) {

			$employeeid = $items['employeeid'];
			$period = $items['period'];
			$target = $items['target'];
			$targetunit = $items['targetunit'];
			$locationid = $items['locationid'];
			$statusConsultant = $items['statusConsultant'];
			$job = $items['job'];

			$existing = $db_oriskin->get_where('mstargetconsultant', [
				'employeeid' => $employeeid,
				'period' => $period
			])->row();


			$data = [
				'target' => $target,
				'targetunit' => $targetunit,
				'locationid' => $locationid,
				'statusConsultant' => $statusConsultant,
				'job' => $job
			];

			if ($existing) {

				$data['updateuserid'] = $userid;
				$data['updatedate'] = date('Y-m-d H:i:s');

				$db_oriskin->where('employeeid', $employeeid);
				$db_oriskin->where('period', $period);
				$db_oriskin->update('mstargetconsultant', $data);
			} else {

				$data['employeeid'] = $employeeid;
				$data['period'] = $period;
				$data['createbyuserid'] = $userid;
				$data['createdate'] = date('Y-m-d H:i:s');

				$db_oriskin->insert('mstargetconsultant', $data);
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


	function updateEmpAppt()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$isactive = $this->input->post('isactive');

		if (is_null($id) || is_null($isactive)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
		}

		$db_oriskin->where('id', $id);

		$update_data = [
			'isactive' => $isactive,
		];

		if ($db_oriskin->update('msemployeeappointment', $update_data)) {
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

	function updateEmpInvoice()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$isactive = $this->input->post('isactive');

		if (is_null($id) || is_null($isactive)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
		}

		$db_oriskin->where('id', $id);

		$update_data = [
			'isactive' => $isactive,
		];

		if ($db_oriskin->update('msemployeeinvoice', $update_data)) {
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

	function updatePackagePublished()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$isactive = $this->input->post('isactive');

		if (is_null($id) || is_null($isactive)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
		}

		$db_oriskin->where('id', $id);

		$update_data = [
			'isactive' => $isactive,
		];

		if ($db_oriskin->update('msproductmembershiphdr', $update_data)) {
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


	public function addEmployeeAppt()
	{

		$db_oriskin = $this->load->database('oriskin', true);
		$db_oriskin->trans_start();
		$userid = $this->session->userdata('userid');

		$employeeId = $this->input->post('employeeId');
		$locationId = $this->input->post('locationId');
		$jobId = $this->input->post('jobId');
		$originLocationId = $this->input->post('originLocationId');


		$db_oriskin->where('employeeid', $employeeId);
		$db_oriskin->where('locationid', $locationId);
		$db_oriskin->where('jobid', $jobId);
		$db_oriskin->where('originLocationId', $originLocationId);
		$exists = $db_oriskin->get('msemployeeappointment')->row();

		if ($exists) {
			$db_oriskin->where('employeeid', $employeeId);
			$db_oriskin->where('locationid', $locationId);
			$db_oriskin->where('jobid', $jobId);
			$db_oriskin->where('originLocationId', $originLocationId);
			$db_oriskin->update('msemployeeappointment', ['isactive' => 1]);
		} else {
			$db_oriskin->insert('msemployeeappointment', [
				'employeeid' => $employeeId,
				'locationid' => $locationId,
				'jobid' => $jobId,
				'originLocationId' => $originLocationId,
				'isactive' => 1
			]);
		}

		$db_oriskin->trans_complete();

		if ($db_oriskin->trans_status()) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
	}

	public function addEmployeeInvoice()
	{

		$db_oriskin = $this->load->database('oriskin', true);
		$db_oriskin->trans_start();
		$userid = $this->session->userdata('userid');

		$employeeId = $this->input->post('employeeId');
		$locationId = $this->input->post('locationId');
		$jobId = $this->input->post('jobId');


		$db_oriskin->where('employeeid', $employeeId);
		$db_oriskin->where('locationid', $locationId);
		$db_oriskin->where('jobid', $jobId);
		$exists = $db_oriskin->get('msemployeeinvoice')->row();

		if ($exists) {
			$db_oriskin->where('employeeid', $employeeId);
			$db_oriskin->where('locationid', $locationId);
			$db_oriskin->where('jobid', $jobId);
			$db_oriskin->update('msemployeeinvoice', ['isactive' => 1]);
		} else {
			$db_oriskin->insert('msemployeeinvoice', [
				'employeeid' => $employeeId,
				'locationid' => $locationId,
				'jobid' => $jobId,
				'isactive' => 1
			]);
		}

		$db_oriskin->trans_complete();

		if ($db_oriskin->trans_status()) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
	}

	public function searchEmployeeAppointment()
	{
		$search = $this->input->get('search');
		$data = $this->MApp->getEmployeeForInvoice($search);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row['EMPLOYEEID'],
				'locationid' => $row['LOCATIONID'],
				'text' => "{$row['NAME']} - {$row['LOCATIONNAME']}"
			];
		}

		echo json_encode($result);
	}

	function pointSection()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$rev = $this->input->post('rev');

		if (is_null($id) || is_null($rev)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
		}

		$db_oriskin->where('id', $id);

		$update_data_medis = [
			'pointsection' => 1,
		];

		$update_data_nonmedis = [
			'pointsection' => 2,
		];

		$update_data_not = [
			'pointsection' => 0,
		];

		if ($rev == 1) {
			if ($db_oriskin->update('msproductmembershiphdr', $update_data_medis)) {
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
		} elseif ($rev == 2) {
			if ($db_oriskin->update('msproductmembershiphdr', $update_data_nonmedis)) {
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
		} elseif ($rev == 3) {
			if ($db_oriskin->update('msproductmembershiphdr', $update_data_not)) {
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
	}

	function pointSectionService()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$rev = $this->input->post('rev');

		if (is_null($id) || is_null($rev)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
		}

		$db_oriskin->where('id', $id);

		$update_data_medis = [
			'pointsection' => 1,
		];

		$update_data_nonmedis = [
			'pointsection' => 2,
		];

		$update_data_not = [
			'pointsection' => 0,
		];

		if ($rev == 1) {
			if ($db_oriskin->update('mstreatment', $update_data_medis)) {
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
		} elseif ($rev == 2) {
			if ($db_oriskin->update('mstreatment', $update_data_nonmedis)) {
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
		} elseif ($rev == 3) {
			if ($db_oriskin->update('mstreatment', $update_data_not)) {
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
	public function search_invoice()
	{
		$invoice = $this->input->get('invoice');
		$type = $this->input->get('type');
		$db_oriskin = $this->load->database('oriskin', true);

		if ($type == 1) {
			$query = $db_oriskin->query("SELECT 
				a.locationid AS LOCATIONID,  
				a.id AS INVOICEHDRID, 
				a.invoiceno AS INVOICENO, 
				CONVERT(varchar(10), a.invoicedate, 120) AS INVOICEDATE,                                     
				a.status AS STATUS, 
				e.id AS CONSULTANTID,
				e.name AS CONSULTANTNAME,
				f.id AS DOCTORID,
				f.name AS DOCTORNAME,
                b.id AS DTLID, 
				b.total AS TOTAL, 
				b.qty AS QTY,
				h.firstname + ' ' + h.lastname AS CUSTOMERNAME,
				h.customercode AS CUSTOMERCODE,
				h.id AS CUSTOMERID,
				h.cellphonenumber AS CELLPHONENUMBER,
				i.name AS ITEMNAME,
				i.id AS ITEMID,
				b.qty AS QTy
                from slinvoicetreatmenthdr a 
                INNER JOIN slinvoicetreatmentdtl b ON a.id = b.invoicehdrid 
                INNER JOIN msemployee e ON a.salesid = e.id
                LEFT JOIN msemployee f ON a.doctorid = f.id
				INNER JOIN mscustomer h ON a.customerid = h.id
				INNER JOIN mstreatment i ON b.productid = i.id
                WHERE invoiceno = ?
        		ORDER BY a.invoiceno", [$invoice]);

			$data = $query->row_array();


			$queryPayment = $db_oriskin->query("SELECT 
                c.id AS INVOICEPAYMENTID, 
				c.paymentid AS PAYMENTID, 
				c.amount AS AMOUNT, 
				d.name AS PAYMENTNAME, 
				a.invoiceno AS INVOICENO
                FROM slinvoicetreatmenthdr a 
                LEFT JOIN slinvoicetreatmentpayment c ON a.id = c.invoicehdrid 
                LEFT JOIN mspaymenttype d ON c.paymentid = d.id
                WHERE invoiceno = ? 
				ORDER BY invoiceno", [$invoice]);

			$dataPayment = $queryPayment->result_array();

			if ($data && $dataPayment) {
				echo json_encode([
					'success' => true,
					'data' => [
						'invoiceno' => $data['INVOICENO'],
						'status' => $data['STATUS'],
						'amount' => $data['TOTAL'],
						'consultantid' => $data['CONSULTANTID'],
						'doctorid' => $data['DOCTORID'],
						'consultantname' => $data['CONSULTANTNAME'],
						'doctorname' => $data['DOCTORNAME'],
						'customerid' => $data['CUSTOMERID'],
						'customername' => $data['CUSTOMERNAME'],
						'itemname' => $data['ITEMNAME'],
						'itemid' => $data['ITEMID'],
						'qty' => $data['QTY'],
						'invoicedate' => $data['INVOICEDATE'],
						'invoicehdrid' => $data['INVOICEHDRID']
					],
					'dataPayment' => $dataPayment
				]);
			} else {
				echo json_encode(['success' => false, 'invoice' => $invoice]);
			}
		} else if ($type == 2) {
			$query = $db_oriskin->query("SELECT 
				a.locationsalesid AS LOCATIONID,  
				a.id AS INVOICEHDRID, 
				a.invoiceno AS INVOICENO, 
				CONVERT(varchar(10), a.invoicedate, 120) AS INVOICEDATE,                                     
				a.status AS STATUS, 
				e.id AS CONSULTANTID,
				e.name AS CONSULTANTNAME,
				f.id AS DOCTORID,
				f.name AS DOCTORNAME,
                b.id AS DTLID, 
				b.totalamount AS TOTAL, 
				b.totalmonth AS QTY,
				h.firstname + ' ' + h.lastname AS CUSTOMERNAME,
				h.customercode AS CUSTOMERCODE,
				h.id AS CUSTOMERID,
				h.cellphonenumber AS CELLPHONENUMBER,
				i.name AS ITEMNAME,
				i.id AS ITEMID
                from slinvoicemembershiphdr a 
                INNER JOIN slinvoicemembershipdtl b ON a.id = b.id 
                INNER JOIN msemployee e ON a.salesid = e.id
                LEFT JOIN msemployee f ON a.doctorid = f.id
				INNER JOIN mscustomer h ON a.customerid = h.id
				INNER JOIN msproductmembershiphdr i ON b.productmembershiphdrid = i.id
                WHERE invoiceno = ?
        		ORDER BY a.invoiceno", [$invoice]);

			$data = $query->row_array();

			$queryPayment = $db_oriskin->query("SELECT 
                c.id AS INVOICEPAYMENTID, 
				c.paymentid AS PAYMENTID, 
				c.amount AS AMOUNT, 
				d.name AS PAYMENTNAME, 
				a.invoiceno AS INVOICENO
                FROM slinvoicemembershiphdr a 
                LEFT JOIN slinvoicemembershippayment c ON a.id = c.invoicehdrid 
                LEFT JOIN mspaymenttype d ON c.paymentid = d.id
                WHERE invoiceno = ? 
				ORDER BY invoiceno", [$invoice]);

			$dataPayment = $queryPayment->result_array();

			if ($data && $dataPayment) {
				echo json_encode([
					'success' => true,
					'data' => [
						'invoiceno' => $data['INVOICENO'],
						'status' => $data['STATUS'],
						'amount' => $data['TOTAL'],
						'consultantid' => $data['CONSULTANTID'],
						'doctorid' => $data['DOCTORID'],
						'consultantname' => $data['CONSULTANTNAME'],
						'doctorname' => $data['DOCTORNAME'],
						'customerid' => $data['CUSTOMERID'],
						'customername' => $data['CUSTOMERNAME'],
						'itemname' => $data['ITEMNAME'],
						'itemid' => $data['ITEMID'],
						'qty' => $data['QTY'],
						'invoicedate' => $data['INVOICEDATE'],
						'invoicehdrid' => $data['INVOICEHDRID']
					],
					'dataPayment' => $dataPayment
				]);
			} else {
				echo json_encode(['success' => false, 'invoice' => $invoice]);
			}
		} else if ($type == 3) {
			$query = $db_oriskin->query("SELECT 
				a.locationid AS LOCATIONID,  
				a.id AS INVOICEHDRID, 
				a.invoiceno AS INVOICENO, 
				CONVERT(varchar(10), a.invoicedate, 120) AS INVOICEDATE,                                     
				a.status AS STATUS, 
				e.id AS CONSULTANTID,
				e.name AS CONSULTANTNAME,
				f.id AS DOCTORID,
				f.name AS DOCTORNAME,
                b.id AS DTLID, 
				b.total AS TOTAL, 
				b.qty AS QTY,
				h.firstname + ' ' + h.lastname AS CUSTOMERNAME,
				h.customercode AS CUSTOMERCODE,
				h.id AS CUSTOMERID,
				h.cellphonenumber AS CELLPHONENUMBER,
				i.name AS ITEMNAME,
				i.id AS ITEMID,
				a.amount AS AMOUNTTOTAL
                from slinvoicehdr a 
                INNER JOIN slinvoicedtl b ON a.id = b.invoicehdrid 
                INNER JOIN msemployee e ON a.salesid = e.id
                LEFT JOIN msemployee f ON a.doctorid = f.id
				INNER JOIN mscustomer h ON a.customerid = h.id
				INNER JOIN msproduct i ON b.productid = i.id
                WHERE invoiceno = ?
        		ORDER BY a.invoiceno", [$invoice]);
			$data = $query->row_array();

			$dataDetail = $query->result_array();

			$queryPayment = $db_oriskin->query("SELECT 
                c.id AS INVOICEPAYMENTID, 
				c.paymentid AS PAYMENTID, 
				c.amount AS AMOUNT, 
				d.name AS PAYMENTNAME, 
				a.invoiceno AS INVOICENO
                FROM slinvoicehdr a 
                LEFT JOIN slinvoicepayment c ON a.id = c.invoicehdrid 
                LEFT JOIN mspaymenttype d ON c.paymentid = d.id
                WHERE invoiceno = ? 
				ORDER BY invoiceno", [$invoice]);

			$dataPayment = $queryPayment->result_array();

			if ($data && $dataPayment) {
				echo json_encode([
					'success' => true,
					'data' => [
						'invoiceno' => $data['INVOICENO'],
						'status' => $data['STATUS'],
						'amount' => $data['TOTAL'],
						'consultantid' => $data['CONSULTANTID'],
						'doctorid' => $data['DOCTORID'],
						'consultantname' => $data['CONSULTANTNAME'],
						'doctorname' => $data['DOCTORNAME'],
						'customerid' => $data['CUSTOMERID'],
						'customername' => $data['CUSTOMERNAME'],
						'itemname' => $data['ITEMNAME'],
						'itemid' => $data['ITEMID'],
						'qty' => $data['QTY'],
						'invoicedate' => $data['INVOICEDATE'],
						'invoicehdrid' => $data['INVOICEHDRID'],
						'amounttotal' => $data['AMOUNTTOTAL']
					],
					'dataPayment' => $dataPayment,
					'dataDetail' => $dataDetail
				]);
			} else {
				echo json_encode(['success' => false, 'invoice' => $invoice]);
			}
		}
	}
	public function searchDocter()
	{
		$search = $this->input->get('search');
		$data = $this->MApp->searchDocter($search);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => "{$row->name} - {$row->locationname}"
			];
		}

		echo json_encode($result);
	}

	public function saveAddPaymentMethod()
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

		foreach ($post['prepaid'] as $product) {
			$data_hdr = [
				"invoicehdrid" => $post['invoicehdrid'],
				"paymentid" => $product['itemsid'],
				"amount" => $product['price'],
				"updateuserid" => $this->session->userdata('userid'),
			];

			if ($post['type'] == 1) {
				$db_oriskin->insert('slinvoicetreatmentpayment', $data_hdr);
			} else if ($post['type'] == 2) {
				$db_oriskin->insert('slinvoicemembershippayment', $data_hdr);
			} else if ($post['type'] == 3) {
				$db_oriskin->insert('slinvoicepayment', $data_hdr);
			}
		}
		if ($db_oriskin->trans_status() === FALSE) {
			$error = $db_oriskin->error();
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'error' => $error]);
		} else {
			$db_oriskin->trans_commit();
			echo json_encode(['status' => 'success']);
		}
	}

	public function updateProductInvoice()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$post = $this->input->post();
		$db_oriskin = $this->load->database('oriskin', true);

		$idupdateProduct = $post['idupdateProduct'] ?? null;
		$amountupdateProduct = $post['amountupdateProduct'] ?? null;
		$updateIdProduct = $post['updateIdProduct'] ?? null;
		$updateqtyProduct = $post['qtyupdateProduct'] ?? null;

		$update_data = [
			'productid' => $idupdateProduct,
			'total' => $amountupdateProduct,
			'qty' => $updateqtyProduct
		];

		if (empty($idupdateProduct) || empty($amountupdateProduct) || !$updateIdProduct || !$updateqtyProduct) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid input data',
				'data' => $update_data
			]);
			return;
		}



		$db_oriskin->where('id', $updateIdProduct);


		if ($db_oriskin->update('slinvoicedtl', $update_data)) {
			$error = $db_oriskin->error();
			echo json_encode([
				'status' => 'success',
				'message' => 'Data updated successfully',
				'error' => $update_data
			]);
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Failed to update data'
			]);
		}
	}

	public function updatePaymentMethod()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$post = $this->input->post();
		$db_oriskin = $this->load->database('oriskin', true);

		$paymentid = $post['paymentMethodUpdate'] ?? null;
		$amount = $post['amountupdate'] ?? null;
		$id = $post['updateId'] ?? null;
		$type = $post['type'] ?? null;

		if (empty($id) || empty($paymentid) || !$amount || empty($type)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
			return;
		}

		$update_data = [
			'paymentid' => $paymentid,
			'amount' => $amount
		];

		$db_oriskin->where('id', $id);

		if ($type == 1) {
			if ($db_oriskin->update('slinvoicetreatmentpayment', $update_data)) {
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
		} else if ($type == 2) {
			if ($db_oriskin->update('slinvoicemembershippayment', $update_data)) {
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
		} else if ($type == 3) {
			if ($db_oriskin->update('slinvoicepayment', $update_data)) {
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
	}

	public function deletePaymentMethod()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$type = $this->input->post('type');

		if (is_null($id) || is_null($type)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid input data'
			]);
			return;
		}

		// Filter data yang akan dihapus
		$db_oriskin->where('id', $id);

		// Hanya hapus jika type == 1
		if ($type == 1) {
			if ($db_oriskin->delete('slinvoicetreatmentpayment')) {
				echo json_encode([
					'status' => 'success',
					'message' => 'Data deleted successfully'
				]);
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Failed to delete data'
				]);
			}
		} else if ($type == 2) {
			if ($db_oriskin->delete('slinvoicemembershippayment')) {
				echo json_encode([
					'status' => 'success',
					'message' => 'Data deleted successfully'
				]);
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Failed to delete data'
				]);
			}
		} else if ($type == 3) {
			if ($db_oriskin->delete('slinvoicepayment')) {
				echo json_encode([
					'status' => 'success',
					'message' => 'Data deleted successfully'
				]);
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Failed to delete data'
				]);
			}
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid type'
			]);
		}
	}


	public function updateStatusInvoice()
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

		$invoicehdrid = $post['invoicehdrid'];
		$type = $post['type'];
		$status = $post['status'];

		$update_data = [
			'status' => $status
		];

		$db_oriskin->where('id', $invoicehdrid);

		if ($type == 1) {
			$db_oriskin->update('slinvoicetreatmenthdr', $update_data);
		} else if ($type == 2) {
			$db_oriskin->update('slinvoicemembershiphdr', $update_data);
		} else if ($type == 3) {
			$db_oriskin->update('slinvoicehdr', $update_data);
		}


		if ($db_oriskin->trans_status() === FALSE) {
			$error = $db_oriskin->error();
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'error' => $error]);
		} else {
			$db_oriskin->trans_commit();
			echo json_encode(['status' => 'success']);
		}
	}

	public function updateInvoice()
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

		$invoicehdrid = $post['invoicehdrid'];
		$type = $post['type'];

		if ($type == 1) {
			$update_data_header_invoicetreatment = [
				'invoicedate' => $post['invoicedate'],
				'salesid' => $post['salesid'],
				'customerid' => $post['customerid'],
				'amount' => $post['amount'],
				'invoiceno' => $post['invoiceno'],
				'doctorid' => $post['doctorid']
			];

			$update_data_detail_invoicetreatment = [
				'productid' => $post['itempurchaseid'],
				'qty' => $post['qty'],
				'total' => $post['amount']
			];

			$db_oriskin->where('id', $invoicehdrid);
			$db_oriskin->update('slinvoicetreatmenthdr', $update_data_header_invoicetreatment);

			$db_oriskin->where('invoicehdrid', $invoicehdrid);
			$db_oriskin->update('slinvoicetreatmentdtl', $update_data_detail_invoicetreatment);
		} else if ($type == 2) {
			$update_data_header_membership = [
				'invoicedate' => $post['invoicedate'],
				'salesid' => $post['salesid'],
				'customerid' => $post['customerid'],
				'invoiceno' => $post['invoiceno'],
				'doctorid' => $post['doctorid']
			];

			$update_data_detail_membership = [
				'productmembershiphdrid' => $post['itempurchaseid'],
				'totalmonth' => $post['qty'],
				'subscriptionmonth' => $post['qty'],
				'totalamount' => $post['amount']
			];
			$db_oriskin->where('id', $invoicehdrid);
			$db_oriskin->update('slinvoicemembershiphdr', $update_data_header_membership);

			$db_oriskin->where('id', $invoicehdrid);
			$db_oriskin->update('slinvoicemembershipdtl', $update_data_detail_membership);
		} else if ($type == 3) {

			$update_data_header_retail = [
				'invoicedate' => $post['invoicedate'],
				'salesid' => (int) $post['salesid'],
				'customerid' => (int) $post['customerid'],
				'invoiceno' => $post['invoiceno'],
				'doctorid' => !empty($post['doctorid']) ? (int) $post['doctorid'] : null
			];
			$db_oriskin->where('id', $invoicehdrid);
			$db_oriskin->update('slinvoicehdr', $update_data_header_retail);
		}

		if ($db_oriskin->trans_status() === FALSE) {
			$error = $db_oriskin->error();
			$db_oriskin->trans_rollback();
			echo json_encode(['status' => 'error', 'error' => $error]);
		} else {
			$db_oriskin->trans_commit();
			echo json_encode(['status' => 'success']);
		}
	}

	public function searchPackage()
	{
		$search = $this->input->get('search');
		$data = $this->MApp->searchPackage($search);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => "{$row->code} - {$row->name}"
			];
		}

		echo json_encode($result);
	}

	public function saveExchangeTreatment()
	{

		$db_oriskin = $this->load->database('oriskin', true);
		// $db_oriskin->trans_start();
		$userid = $this->session->userdata('userid');

		$customerId = $this->input->post('customerId');
		$treatmentId = $this->input->post('treatmentId');
		$invoiceNo = $this->input->post('invoiceNo');
		$qty = $this->input->post('qty');
		$totalPoint = $this->input->post('totalPoint');
		$typeTransaction = $this->input->post('typeTransaction');

		if (empty($userid) || empty($customerId) || empty($treatmentId) || empty($invoiceNo) || empty($typeTransaction)) {
			echo json_encode(['status' => 'error', 'message' => 'Semua data harus diisi, coba login ulang']);
			return;
		}

		$data = [
			'customerid' => $customerId,
			'productid' => $treatmentId,
			'invoiceno' => $invoiceNo,
			'qty' => $qty,
			'point' => $totalPoint,
			'status' => 1,
			'updateuserid' => $userid,
			'exchangedate' => date('Y-m-d H:i:s')
		];

		if ($typeTransaction == 1) {
			$db_oriskin->insert('msexchangetreatment', $data);
		} elseif ($typeTransaction == 2) {
			$db_oriskin->insert('msexchange', $data);
		}


		$db_oriskin->trans_complete();

		if ($db_oriskin->trans_status()) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
	}

	public function getChatList()
	{
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

	public function detailConsultationChat()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$sender_id = 10;
		$sender_type = 'employee';
		$receiver_id = $this->input->get('receiver_id');
		$receiver_type = $this->input->get('receiver_type');

		if (!$sender_id || !$receiver_id || !$sender_type || !$receiver_type) {
			echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
			return;
		}

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
				// 'consultation_id' => $consultation->id ?? null,
			]
		]);

	}

	public function sendMessages()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$post = $this->input->post();
		$db_oriskin = $this->load->database('oriskin', true);

		$receiver_id = $post['receiver_id'] ?? null;
		$receiver_type = $post['receiver_type'] ?? null;
		$message = $post['message'] ?? null;
		// $sender_id = $this->session->userdata('userid');
		$sender_id = 10;
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

		if ($type === 'image') {
			$create_data['message'] = $image_path; // pastikan kolom 'image' ada di DB
		}


		if ($db_oriskin->insert('mschat', $create_data)) {
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
		$type = $post['type'] ?? null;
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

		if ($type === 'image') {
			$create_data['message'] = $image_path; // pastikan kolom 'image' ada di DB
		}


		if ($db_oriskin->insert('mschat', $create_data)) {
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

	public function getServiceListBackEnd()
	{
		$serviceList = $this->MApp->getServiceListBackEnd();
		echo json_encode(["message" => 'Berhasil', "status" => true, 'data' => $serviceList]);
	}




	function handleReportGuestMarketing()
	{
		$level = $this->session->userdata('level');
		$dateStart = $this->input->post('dateStart') ?: date('Y-m-d');
		$dateEnd = $this->input->post('dateEnd') ?: date('Y-m-d');

		if ($level == 1) {
			$reportData = $this->MApp->getReportGuestMarketingForClinic($dateStart, $dateEnd);
			$reportDataSummary = $this->MApp->getReportGuestMarketingForClinicSummary($dateStart, $dateEnd);
		} else {
			$reportData = $this->MApp->getReportGuestMarketing($dateStart, $dateEnd);
			$reportDataSummary = $this->MApp->getReportGuestMarketingSummary($dateStart, $dateEnd);
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode([
				'status' => 200,
				'data' => $reportData,
				'dataSummary' => $reportDataSummary
			]);
			exit;
		}

		return [
			'reportGuestMarketing' => $reportData,
			'reportGuestMarketingSummary' => $reportDataSummary,
			'dateStart' => $dateStart,
			'dateEnd' => $dateEnd,
		];
	}

	//NEW FOR RECON
	public function getDetailReconciliation($id)
	{
		$results = $this->MApp->getDetailListRecon($id);
		echo json_encode(['status' => 200, 'data' => $results]);
	}

	public function getDetailForEdit($id)
	{
		$this->output->set_content_type('application/json');

		$data = $this->MApp->getDetail($id);

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
	public function updateReconciliation()
	{
		error_reporting(0);
		ini_set('display_errors', 0);

		$id = $this->input->post('id');
		$newAmount = $this->input->post('amountreceived');
		$newDate = $this->input->post('receiveddate');
		$mdrUpdate = $this->input->post('mdrUpdate');

		if (!$id) {
			echo json_encode([
				'success' => false,
				'message' => 'Id tidak valid',
			]);
		}

		if (!$newAmount) {
			echo json_encode([
				'success' => false,
				'message' => 'Amount tidak valid',
			]);
		}

		if (!DateTime::createFromFormat('Y-m-d', $newDate)) {
			echo json_encode([
				'success' => false,
				'message' => 'Format tidak sesuai',
			]);
		}

		// Dapatkan data lama untuk menghitung ulang persen MDR
		// $oldData = $this->MApp->getDetail($id);
		// if (!$oldData) {
		// 	echo json_encode([
		// 		'success' => false,
		// 		'message' => 'Tidak ada old data',
		// 	]);
		// }

		// Update data
		$updateData = [
			'amountreceived' => $newAmount,
			'receiveddate' => $newDate,
			'mdr' => $mdrUpdate,
			'updatedate' => date('Y-m-d H:i:s'),
			'updatedby' => $this->session->userdata('userid') // sesuaikan dengan auth system
		];

		// Hitung ulang persen MDR
		// if ($oldData[0]['amountomset'] > 0) {
		// 	$updateData['mdr'] = ($oldData[0]['amountomset'] - $newAmount);
		// 	$updateData['persenmdr'] = round((($oldData[0]['amountomset'] - $newAmount) * 100 / $oldData[0]['amountomset']), 2);
		// } else {
		// 	$updateData['persenmdr'] = 0;
		// 	$updateData['mdr'] = 0;
		// }

		$result = $this->MApp->updateReconciliation($id, $updateData);

		if ($result) {
			echo json_encode([
				'success' => true,
				'message' => 'Data berhasil diperbarui'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => 'Data gagal insert diperbarui',
			]);
		}
	}


	public function createReconciliation()
	{
		error_reporting(0);
		ini_set('display_errors', 0);

		$amountreceived = $this->input->post('amountreceived');
		$receiveddate = $this->input->post('receiveddate');
		$paymentid = $this->input->post('paymentid');
		$locationid = $this->input->post('locationid');
		$amountomset = $this->input->post('amountomset');
		$transactiondate = $this->input->post('transactiondate');
		$mdrCreate = $this->input->post('mdrCreate');

		if (!$amountreceived || !$receiveddate || !$paymentid || !$locationid || !$amountomset || !$transactiondate) {
			echo json_encode([
				'success' => false,
				'message' => 'data tidak valid',
			]);
		}

		$updateData = [
			'amountreceived' => $amountreceived,
			'receiveddate' => $receiveddate,
			'created_at' => date('Y-m-d H:i:s'),
			'createdby' => $this->session->userdata('userid'),
			'amountomset' => $amountomset,
			'transactiondate' => $transactiondate,
			'status' => 1,
			'paymentid' => $paymentid,
			'locationid' => $locationid,
			'mdr' => $mdrCreate
		];

		$result = $this->MApp->createReconciliation($updateData);

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

	public function createExpend()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);

		$amount = $this->input->post('amount');
		$period = $this->input->post('period');
		$remarks = $this->input->post('remarks');
		$locationid = $this->input->post('locationid');
		$expendcostid = $this->input->post('expendcostid');

		if (!$amount || !$period || !$expendcostid || !$locationid) {
			echo json_encode([
				'success' => false,
				'message' => 'data tidak valid',
			]);
		}

		$db_oriskin->select('shortcode');
		$db_oriskin->from('mslocation');
		$db_oriskin->where('id', $locationid);
		$shortcode = $db_oriskin->get()->row('shortcode');

		if (!$shortcode) {
			echo json_encode([
				'success' => false,
				'message' => 'Kode outlet tidak ditemukan',
			]);
			return;
		}

		// Ambil tahun dan bulan dari period
		$year = date('Y', strtotime($period));
		$month = date('m', strtotime($period));

		// Hitung nomor urut untuk bulan & lokasi yang sama
		$db_oriskin->from('expendcost');
		$db_oriskin->where('status', 1);
		$db_oriskin->where('locationid', $locationid);
		$db_oriskin->where("FORMAT(expenddate, 'yyyy-MM') =", "$year-$month");
		$count = $db_oriskin->count_all_results();

		$sequence = str_pad($count + 1, 3, '0', STR_PAD_LEFT); // Nomor urut 3 digit

		// Buat BK Number
		$bknumber = 'BK' . $shortcode . $year . $month . $sequence;

		$updateData = [
			'amount' => $amount,
			'expenddate' => $period,
			'remarks' => $remarks,
			'created_at' => date('Y-m-d H:i:s'),
			'createdby' => $this->session->userdata('userid'),
			'locationid' => $locationid,
			'expendcostid' => $expendcostid,
			'status' => 1,
			'bknumber' => $bknumber
		];

		$result = $this->MApp->createExpend($updateData);

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

	public function deleteReconciliation($id)
	{
		$this->output->set_content_type('application/json');

		$updateData = [
			'status' => 0,
		];

		$data = $this->MApp->deleteReconciliation($id, $updateData);

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

	public function voidExpend($id)
	{
		$this->output->set_content_type('application/json');

		// Load database koneksi oriskin
		$db_oriskin = $this->load->database('oriskin', true);

		// Data yang akan diupdate
		$updateData = [
			'status' => 0,
		];

		// Update baris berdasarkan ID
		$db_oriskin->where('id', $id);
		$db_oriskin->update('expendcost', $updateData);

		// Cek apakah ada baris yang terpengaruh
		if ($db_oriskin->affected_rows() > 0) {
			$this->output->set_output(json_encode([
				'success' => true,
				'message' => 'Data berhasil diubah'
			]));
		} else {
			$this->output->set_output(json_encode([
				'success' => false,
				'message' => 'Data tidak ditemukan atau tidak berubah'
			]));
		}
	}
	public function approveReconciliation($id)
	{
		$this->output->set_content_type('application/json');

		$updateData = [
			'status' => 2,
			'approvedby' => $this->session->userdata('userid'),
			'approved_date' => date('Y-m-d H:i:s')
		];

		$data = $this->MApp->deleteReconciliation($id, $updateData);

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
	public function uploadLampiran()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$db_oriskin = $this->load->database('oriskin', true);

		$id = $this->input->post('id');
		$numberOfImage = $this->input->post('numberOfImage');

		if (empty($id)) {
			echo json_encode(['status' => 400, 'message' => 'ID tidak boleh kosong']);
			return;
		}

		if (empty($_FILES['lampiran']['name'])) {
			echo json_encode(['status' => 400, 'message' => 'Tidak ada file yang dikirim']);
			return;
		}

		// Konfigurasi upload
		$config['upload_path'] = './uploads/lampiran/';
		$config['allowed_types'] = 'jpg|jpeg|png|pdf|webp';
		$config['file_name'] = uniqid('lampiran_');
		$config['overwrite'] = true;

		// Pastikan folder upload ada
		if (!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'], 0755, true);
		}

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('lampiran')) {
			echo json_encode(['status' => 500, 'message' => $this->upload->display_errors()]);
			return;
		}

		$uploadData = $this->upload->data();
		$filePath = 'uploads/lampiran/' . $uploadData['file_name'];

		// Simpan ke database
		$db_oriskin->where('id', $id);

		if ($numberOfImage == 1) {
			$update = $db_oriskin->update('msreconciliation', [
				'image' => $filePath,
				'updatedate' => date('Y-m-d H:i:s'),
				'updatedby' => $this->session->userdata('userid')
			]);
		} else if ($numberOfImage == 2) {
			$update = $db_oriskin->update('msreconciliation', [
				'image_2' => $filePath,
				'updatedate' => date('Y-m-d H:i:s'),
				'updatedby' => $this->session->userdata('userid')
			]);
		}


		if ($update) {
			echo json_encode(['status' => 200, 'message' => 'Lampiran berhasil disimpan']);
		} else {
			echo json_encode(['status' => 500, 'message' => 'Gagal menyimpan lampiran']);
		}
	}

	public function updateLampiran()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$id = $this->input->post('id');
		$numberOfImage = $this->input->post('numberOfImage');
		$old_image = $this->input->post('old_image');
		$db_oriskin = $this->load->database('oriskin', true);

		if (empty($_FILES['lampiran-update']['name'])) {
			echo json_encode(['success' => false, 'message' => 'File tidak ditemukan']);
			return;
		}

		$config['upload_path'] = './uploads/lampiran/';
		$config['allowed_types'] = 'jpg|jpeg|png|webp';
		$config['file_name'] = uniqid('lampiran_');
		$config['overwrite'] = true;

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('lampiran-update')) {
			$uploadData = $this->upload->data();
			$filePath = 'uploads/lampiran/' . $uploadData['file_name'];

			// Hapus gambar lama jika ada
			if ($old_image && file_exists(FCPATH . $old_image)) {
				unlink(FCPATH . $old_image);
			}

			// Update ke DB
			$db_oriskin->where('id', $id);

			if ($numberOfImage == 1) {
				$updated = $db_oriskin->update('msreconciliation', ['image' => $filePath]);
			} else if ($numberOfImage == 2) {
				$updated = $db_oriskin->update('msreconciliation', ['image_2' => $filePath]);

			}


			echo json_encode([
				'success' => $updated,
				'message' => $updated ? 'Berhasil update' : 'Gagal update'
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => $this->upload->display_errors()
			]);
		}
	}


	function getExpendCost()
	{
		$dateStart = $this->input->post('dateStart') ?: date('Y-m-d');
		$dateEnd = $this->input->post('dateEnd') ?: date('Y-m-d');

		$reportData = $this->MApp->getExpendCost($dateStart, $dateEnd);


		if ($this->input->is_ajax_request()) {
			echo json_encode([
				'status' => 200,
				'data' => $reportData
			]);
			exit;
		}

		return [
			'reportGuestMarketing' => $reportData,
			'dateStart' => $dateStart,
			'dateEnd' => $dateEnd
		];
	}

	function getProfitAndLoss()
	{
		$period = $this->input->post('dateEnd') ?: date('Y-m');
		$locationid = $this->input->post('locationId');

		$reportData = $this->MApp->getProfitAndLoss($period, $locationid);


		if ($this->input->is_ajax_request()) {
			echo json_encode([
				'status' => 200,
				'data' => $reportData
			]);
			exit;
		}

		return [
			'reportGuestMarketing' => $reportData,
			'dateEnd' => $period,
			'locationId' => $locationid
		];
	}

	public function getDetailExpendCost($id)
	{
		$this->output->set_content_type('application/json');

		$data = $this->MApp->getDetailExpendCost($id);

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

	public function updateExpend()
	{
		error_reporting(0);
		ini_set('display_errors', 0);

		$id = $this->input->post('id');
		$amount = $this->input->post('amount');
		$period = $this->input->post('period');
		$remarks = $this->input->post('remarks');
		$locationid = $this->input->post('locationid');
		$expendcostid = $this->input->post('expendcostid');

		if (!$amount || !$period || !$expendcostid || !$locationid || !$id) {
			echo json_encode([
				'success' => false,
				'message' => 'data tidak valid',
			]);
		}

		$updateData = [
			'amount' => $amount,
			'expenddate' => $period,
			'remarks' => $remarks,
			'updatedate' => date('Y-m-d H:i:s'),
			'updatedby' => $this->session->userdata('userid'),
			'locationid' => $locationid,
			'expendcostid' => $expendcostid
		];

		$result = $this->MApp->updateExpend($id, $updateData);

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

	public function uploadLampiranExpend()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$id = $this->input->post('id');
		$expend = $db_oriskin->get_where('expendcost', ['id' => $id])->row();

		if (empty($_FILES['lampiran']['name'])) {
			echo json_encode(['success' => false, 'message' => 'File tidak ditemukan']);
			return;
		}

		// Hapus file lama jika ada
		if ($expend && $expend->lampiran) {
			$oldPath = $expend->lampiran;
			if (file_exists($oldPath)) {
				unlink($oldPath);
			}
		}

		// Upload baru
		$config['upload_path'] = './uploads/lampiranexpend/';
		$config['allowed_types'] = 'pdf';
		$config['file_name'] = uniqid('lampiran_');
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('lampiran')) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['success' => false, 'message' => $this->upload->display_errors()]));
		}

		$uploadData = $this->upload->data();
		$filePath = 'uploads/lampiranexpend/' . $uploadData['file_name'];

		$db_oriskin->where('id', $id)->update('expendcost', ['lampiran' => $filePath]);

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode(['success' => true, 'message' => 'Lampiran berhasil diupload']));
	}

	public function searchCustomerConsultation()
	{
		$search = $this->input->get('search');
		$data = $this->MApp->search_customersConsultation($search);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => "{$row->firstname} {$row->lastname} - {$row->cellphonenumber} ({$row->customercode})",
				'data' => $row
			];
		}
		echo json_encode($result);
	}

	function printConsultationResult($id)
	{
		ob_start();
		$this->load->library('Ltcpdf');
		$db_oriskin = $this->load->database('oriskin', true);

		$consultatiionResult = $db_oriskin->query("
			SELECT
				b.firstname + '  ' + b.lastname AS customername,  
				CONVERT(VARCHAR(10), b.dateofbirth, 120) AS dateofbirth,
				b.ssid,
				ISNULL(b.address, '-') AS address,
				ISNULL(b.ssid, '-') AS ssid,
				CASE 
					WHEN b.sex = 'F' THEN 'Wanita / Female'
					WHEN b.sex = 'M' THEN 'Pria / Male'
					ELSE '-' 
				END AS gender,
				d.guestlogadvtrackingid,
				a.*,
				e.name as occupied,
				f.name as nettincome
			FROM formconsultationresult a 
			INNER JOIN mscustomer b ON a.customerid = b.id 
			INNER JOIN msemployee c ON a.consulted_employee_id = c.id
			INNER JOIN slguestlog d ON b.guestlogid = d.id
			LEFT JOIN msoccupied e ON b.occupiedid = e.id
			LEFT JOIN msnettincome f ON b.nettincomeid = f.id
			WHERE a.id = $id
		")->row_array();

		$createdAt = $consultatiionResult['created_at'];

		$dayNameIndo = [
			'Sunday' => 'Minggu',
			'Monday' => 'Senin',
			'Tuesday' => 'Selasa',
			'Wednesday' => 'Rabu',
			'Thursday' => 'Kamis',
			'Friday' => 'Jumat',
			'Saturday' => 'Sabtu'
		];

		$monthNameIndo = [
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember'
		];

		$dateObj = new DateTime($createdAt);
		$dayName = $dayNameIndo[$dateObj->format('l')]; // 'Friday' -> 'Jumat'
		$day = $dateObj->format('j'); // 1
		$month = $monthNameIndo[$dateObj->format('m')]; // '08' -> 'Agustus'
		$year = $dateObj->format('Y');

		$formatted = "$dayName, $day $month $year";

		$dateBirth = new DateTime($consultatiionResult['dateofbirth']);
		$dayNameBirth = $dayNameIndo[$dateBirth->format('l')]; // 'Friday' -> 'Jumat'
		$dayBirth = $dateObj->format('j'); // 1
		$monthBirth = $monthNameIndo[$dateObj->format('m')]; // '08' -> 'Agustus'
		$yearBirth = $dateObj->format('Y');

		// Panggil nama gambar dari column database
		$consultationImage = $consultatiionResult['consultation_image'];

		$formattedBirth = "$dayNameBirth, $dayBirth $monthBirth $yearBirth";

		$allOptions = $db_oriskin->query("
			SELECT * FROM msskincare
		")->result_array();

		$allOptionsAdds = $db_oriskin->query("
			SELECT * FROM msguestlogadvtracking where isactive = 1
		")->result_array();

		$allOptionsSkinCondition = $db_oriskin->query("
			SELECT * FROM msskincondition
		")->result_array();

		$allOptionsPastTreatment = $db_oriskin->query("
			SELECT * FROM mspasttreatment
		")->result_array();

		$selectedIds = $db_oriskin->query("
			SELECT skincareid FROM formconsultationresult_skincare WHERE formresultid = ?
		", [$id])->result_array();

		$selectedIds = array_column($selectedIds, 'skincareid');

		$selectedIdAds = [$consultatiionResult['guestlogadvtrackingid']] ?? null;

		$selectedIdSkinCondition = $db_oriskin->query("
			SELECT skinconditionid FROM formconsultationresult_skin_condition WHERE formresultid = ?
		", [$id])->result_array();

		$selectedIdSkinCondition = array_column($selectedIdSkinCondition, 'skinconditionid');


		$selectedIdsPastTreatment = $db_oriskin->query("
			SELECT pasttreatmentid FROM formconsultationresult_treatment WHERE formresultid = ?
		", [$id])->result_array();

		$selectedIdsPastTreatment = array_column($selectedIdsPastTreatment, 'pasttreatmentid');

		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		$pdf->SetMargins(0, 0, 0);
		$pdf->SetAutoPageBreak(false, 0);
		$pdf->AddPage();

		$bgImage = FCPATH . 'assets/img/form_consultation_1.png';
		$pdf->Image($bgImage, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

		$pdf->SetFont('dejavusans', '', 8);

		$pdf->SetXY(58, 66);
		$pdf->MultiCell(80, 5, $consultatiionResult['customername'], 0, 'L');

		$pdf->SetXY(58, 78);
		$pdf->MultiCell(80, 5, $formattedBirth, 0, 'L');

		$pdf->SetFont('dejavusans', '', 7);
		$pdf->SetXY(160, 74);
		$pdf->MultiCell(40, 5, $consultatiionResult['occupied'], 0, 'L');

		$pdf->SetXY(160, 82);
		$pdf->MultiCell(40, 5, $consultatiionResult['nettincome'], 0, 'L');

		$pdf->SetFont('dejavusans', '', 8);
		$pdf->SetXY(58, 92);
		$pdf->MultiCell(80, 5, $consultatiionResult['address'], 0, 'L');

		$pdf->SetXY(58, 111);
		$pdf->MultiCell(80, 5, $consultatiionResult['ssid'], 0, 'L');

		$pdf->SetXY(162, 111);
		$pdf->MultiCell(80, 5, $consultatiionResult['gender'], 0, 'L');

		$pdf->SetFont('dejavusans', '', 7);
		$pdf->SetXY(11, 167);
		$pdf->MultiCell(170, 5, '- ' . $consultatiionResult['discussion_expectation'], 0, 'L');

		$pdf->SetFont('dejavusans', '', 8);
		$pdf->SetXY(33, 153);
		$pdf->MultiCell(80, 5, $consultatiionResult['skincarebrand'], 0, 'L');

		$xStart = 12;
		$y = 143;
		$colSpacing = 25;
		$lineHeight = 6;
		$colsPerRow = 10;

		foreach ($allOptions as $i => $opt) {
			$pdf->SetFont('dejavusans', '', 7);
			$col = $i % $colsPerRow;
			$row = floor($i / $colsPerRow);

			$x = $xStart + ($col * $colSpacing);
			$yRow = $y + ($row * $lineHeight);

			$pdf->Rect($x, $yRow, 3, 3);

			if (in_array($opt['id'], $selectedIds)) {
				$pdf->SetFont('dejavusans', '', 7);
				$pdf->Text($x + 0, $yRow, '✔');
			}
			$pdf->Text($x + 4, $yRow, $opt['name']);
		}

		$pdf->SetFont('dejavusans', '', 7);
		$pdf->SetXY(11, 246.5);
		$pdf->MultiCell(170, 5, '- ' . $consultatiionResult['detail_allergic'], 0, 'L');

		$pdf->SetFont('dejavusans', '', 7);
		$pdf->SetXY(11, 263.5);
		$pdf->MultiCell(170, 5, '- ' . $consultatiionResult['detail_medical'], 0, 'L');


		$xStart = 12;
		$y = 125;
		$colSpacing = 45;
		$lineHeight = 4;
		$colsPerRow = 4;

		foreach ($allOptionsAdds as $i => $opt) {
			$pdf->SetFont('dejavusans', '', 7);
			$col = $i % $colsPerRow;
			$row = floor($i / $colsPerRow);

			$x = $xStart + ($col * $colSpacing);
			$yRow = $y + ($row * $lineHeight);

			$pdf->Rect($x, $yRow, 3, 3);

			if (in_array($opt['id'], $selectedIdAds)) {
				$pdf->SetFont('dejavusans', '', 7);
				$pdf->Text($x + 0, $yRow, '✔');
			}
			$pdf->Text($x + 4, $yRow, $opt['name']);
		}


		$xStart = 15;
		$y = 200;
		$colSpacing = 25;
		$lineHeight = 5;
		$colsPerRow = 1;

		foreach ($allOptionsPastTreatment as $i => $opt) {
			$pdf->SetFont('dejavusans', '', 8);
			$col = $i % $colsPerRow;
			$row = floor($i / $colsPerRow);

			$x = $xStart + ($col * $colSpacing);
			$yRow = $y + ($row * $lineHeight);

			$pdf->Rect($x, $yRow, 4, 4);

			if (in_array($opt['id'], $selectedIdsPastTreatment)) {
				$pdf->SetFont('dejavusans', '', 8);
				$pdf->Text($x + 0, $yRow, '✔');
			}
			$pdf->Text($x + 4, $yRow, $opt['name']);
		}

		// done treatment?
		if ($consultatiionResult['has_done_treatment'] == 1) {
			$pdf->SetFont('dejavusans', '', 9);
			$pdf->Text(166, 190, '✔');
		} else {
			$pdf->SetFont('dejavusans', '', 9);
			$pdf->Text(186, 190, '✔');
		}

		// pregnant?
		if ($consultatiionResult['is_pregnant'] == 1) {
			$pdf->SetFont('dejavusans', '', 9);
			$pdf->Text(166, 230, '✔');
		} else {
			$pdf->SetFont('dejavusans', '', 9);
			$pdf->Text(186, 230, '✔');
		}

		// allergic?
		if ($consultatiionResult['is_allergic'] == 1) {
			$pdf->SetFont('dejavusans', '', 9);
			$pdf->Text(166, 240, '✔');
		} else {
			$pdf->SetFont('dejavusans', '', 9);
			$pdf->Text(186, 240, '✔');
		}

		// medical?
		if ($consultatiionResult['is_under_medical_treatment'] == 1) {
			$pdf->SetFont('dejavusans', '', 9);
			$pdf->Text(166, 256, '✔');
		} else {
			$pdf->SetFont('dejavusans', '', 9);
			$pdf->Text(186, 256, '✔');
		}


		$pdf->AddPage();
		$bgImage2 = FCPATH . 'assets/img/form_consultation_2.png';
		$pdf->Image($bgImage2, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

		$consultationImage = $consultatiionResult['consultation_image'];
		$imgPath = FCPATH . 'uploads/consultation/' . $consultationImage;

		if (file_exists($imgPath)) {

			$x = 20;
			$y = 80;
			$width = 70;
			$height = 70;

			$pdf->Image($imgPath, $x, $y, $width, $height, '', '', '', false, 300, '', false, false, 0);
		}

		$pdf->SetFont('dejavusans', '', 7);
		$pdf->SetXY(97, 99);
		$pdf->MultiCell(100, 4, $consultatiionResult['notes'], 0, 'L', false, 0);

		$xStart = 15;
		$y = 185;
		$colSpacing = 100;
		$lineHeight = 5;
		$colsPerRow = 2;

		foreach ($allOptionsSkinCondition as $i => $opt) {
			$pdf->SetFont('dejavusans', '', 9);
			$col = $i % $colsPerRow;
			$row = floor($i / $colsPerRow);

			$x = $xStart + ($col * $colSpacing);
			$yRow = $y + ($row * $lineHeight);

			$pdf->Rect($x, $yRow, 4, 4);

			if (in_array($opt['id'], $selectedIdSkinCondition)) {
				$pdf->SetFont('dejavusans', '', 9);
				$pdf->Text($x + 0, $yRow, '✔');
			}
			$pdf->Text($x + 4, $yRow, $opt['name']);
		}

		$pdf->SetXY(12, 250);
		$pdf->MultiCell(80, 5, $consultatiionResult['customername'], 0, 'L');

		$pdf->SetXY(12, 256); // geser ke bawah beberapa px
		$pdf->SetFont('dejavusans', '', 18); // font besar untuk kurungnya
		$pdf->MultiCell(80, 5, '(              )', 0, 'L');

		$pdf->SetFont('dejavusans', '', 9);
		$pdf->SetXY(112, 250);
		$pdf->MultiCell(80, 5, $formatted, 0, 'L');

		$pdf->Output('receipt_.pdf', 'I');
		ob_end_flush();

	}

	public function saveConsultation()
	{
		$db_oriskin = $this->load->database('oriskin', true);

		try {
			$filename = $this->input->post('consultation_image');

			if (!empty($_FILES['image_file']['name'])) {
				$upload_path = './uploads/consultation/';
				if (!is_dir($upload_path)) {
					mkdir($upload_path, 0777, true);
				}

				$config['upload_path'] = $upload_path;
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['overwrite'] = true;
				$config['file_name'] = $filename;

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('image_file')) {
					echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
					return;
				}
			}

			// Data konsultasi
			$data = array(
				'customerid' => $this->input->post('customer_id'),
				'skincarebrand' => $this->input->post('brandskincare'),
				'discussion_expectation' => $this->input->post('discussion_expectation'),
				'has_done_treatment' => $this->input->post('has_done_treatment'),
				'is_pregnant' => $this->input->post('is_pregnant'),
				'is_allergic' => $this->input->post('is_allergic'),
				'detail_allergic' => $this->input->post('detail_is_allergic'),
				'is_under_medical_treatment' => $this->input->post('is_under_medical_treatment'),
				'detail_medical' => $this->input->post('detail_is_under_medical_treatment'),
				'notes' => $this->input->post('note'),
				'created_at' => date('Y-m-d H:i:s'),
				'consultationdate' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('userid'),
				'locationid' => $this->session->userdata('locationid'),
				'consulted_employee_id' => $this->input->post('consulted_employee_id'),
				'consultation_image' => $filename // hanya nama file PNG
			);

			// Update data customer
			$dataUpdateCustomer = array(
				'dateofbirth' => $this->input->post('birthdate'),
				'nettincomeid' => $this->input->post('nettIncome'),
				'ssid' => $this->input->post('ssid'),
				'address' => $this->input->post('address'),
				'occupiedid' => $this->input->post('occupation'),
				'sex' => $this->input->post('gender'),
			);

			$db_oriskin->where("id", $this->input->post('customer_id'));
			$db_oriskin->update('mscustomer', $dataUpdateCustomer);

			// Simpan ke tabel utama
			$db_oriskin->insert('formconsultationresult', $data);
			$consultationId = $db_oriskin->insert_id();

			// Simpan skincare_used
			$skincare_used = $this->input->post('skincare_used');
			if (!empty($skincare_used)) {
				foreach ($skincare_used as $value) {
					$db_oriskin->insert('formconsultationresult_skincare', [
						'formresultid' => $consultationId,
						'skincareid' => $value
					]);
				}
			}

			// Simpan past treatments
			$past_treatments = $this->input->post('pasttreatmentid');
			if (!empty($past_treatments)) {
				foreach ($past_treatments as $value) {
					$db_oriskin->insert('formconsultationresult_treatment', [
						'formresultid' => $consultationId,
						'pasttreatmentid' => $value
					]);
				}
			}

			// Simpan skin condition
			$skincondition = $this->input->post('skincondition');
			if (!empty($skincondition)) {
				foreach ($skincondition as $value) {
					$db_oriskin->insert('formconsultationresult_skin_condition', [
						'formresultid' => $consultationId,
						'skinconditionid' => $value
					]);
				}
			}

			echo json_encode(['success' => true, 'id' => $consultationId]);

		} catch (Exception $e) {
			echo json_encode(['success' => false, 'message' => $e->getMessage()]);
		}
	}


	public function getListEmployee()
	{
		$serviceList = $this->MApp->getListEmployee();
		echo json_encode(["message" => 'Berhasil', "status" => true, 'data' => $serviceList]);
	}

	public function updateEmployeeBackOffice()
	{
		$response = ['success' => false, 'message' => 'Terjadi kesalahan'];

		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$nip = $this->input->post('nip');
		$phone = $this->input->post('phone');
		$locationId = $this->input->post('updateLocation');
		$jobId = $this->input->post('updateJob');
		$isActive = $this->input->post('updateIsactive');

		if (!$id || !$name) {
			$response['message'] = 'Data tidak lengkap';
			echo json_encode($response);
			return;
		}

		$dataUpdate = [
			'name' => $name,
			'nip' => $nip,
			'cellphonenumber' => $phone,
			'isactive' => $isActive,
			'updatedate' => date('Y-m-d H:i:s'),
			'updateuserid' => $this->session->userdata('userid')
		];

		$dataUpdateDetail = [
			'locationid' => $locationId,
			'jobid' => $jobId,
			'updatedate' => date('Y-m-d H:i:s'),
			'updateuserid' => $this->session->userdata('userid')
		];

		$result = $this->MApp->updateEmployee($id, $dataUpdate);

		$resultDetail = $this->MApp->updateEmployeeDetail($id, $dataUpdateDetail);

		if ($result && $resultDetail) {
			$response['success'] = true;
			$response['message'] = 'Data berhasil diperbarui';
		} else {
			$response['message'] = 'Gagal memperbarui data';
		}

		echo json_encode($response);
	}


	public function updateTargetOutlet()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$response = ['success' => false, 'message' => 'Gagal memperbarui data'];

		$updateId = $this->input->post('updateId');
		$target = $this->input->post('targetValue');
		$targetUnit = $this->input->post('targetUnit');

		if (!$updateId || !$target || !$targetUnit) {
			$response['message'] = 'Data tidak lengkap';
			echo json_encode($response);
			return;
		}

		// Siapkan data untuk update
		$dataUpdate = [
			'targetbep' => $target,
			'targetunit' => $targetUnit,
			'updatedate' => date('Y-m-d H:i:s'),
			'updateuserid' => $this->session->userdata('userid')
		];

		// Jalankan update
		$db_oriskin->where('id', $updateId);
		$result = $db_oriskin->update('mstarget', $dataUpdate);

		if ($result) {
			$response['success'] = true;
			$response['message'] = 'Data berhasil diperbarui';
		}

		echo json_encode($response);
	}

	public function updateTargetConsultant()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$response = ['success' => false, 'message' => 'Gagal memperbarui data'];

		$updateId = $this->input->post('updateIdConsultant');
		$target = $this->input->post('targetValueConsultant');
		$targetUnit = $this->input->post('targetUnitConsultant');
		$locationid = $this->input->post('updateLocationidConsultant');
		$statusConsultant = $this->input->post('updateStatusConsultant');
		$job = $this->input->post('updateJob');

		if (!$updateId || !$locationid || !$statusConsultant) {
			$response['message'] = 'Data tidak lengkap';
			echo json_encode($response);
			return;
		}

		// Siapkan data untuk update
		$dataUpdate = [
			'target' => $target,
			'targetunit' => $targetUnit,
			'locationid' => $locationid,
			'job' => $job,
			'statusConsultant' => $statusConsultant,
			'updatedate' => date('Y-m-d H:i:s'),
			'updateuserid' => $this->session->userdata('userid')
		];

		// Jalankan update
		$db_oriskin->where('id', $updateId);
		$result = $db_oriskin->update('mstargetconsultant', $dataUpdate);

		if ($result) {
			$response['success'] = true;
			$response['message'] = 'Data berhasil diperbarui';
		}

		echo json_encode($response);
	}

	public function consultationHistory()
	{
		$db_oriskin = $this->load->database('oriskin', TRUE);

		$db_oriskin->select('
			formconsultationresult.*, 
			mscustomer.firstname AS customer_firstname, 
			mscustomer.lastname AS customer_lastname, 
			msemployee.name AS employee_name
		')
			->from('formconsultationresult')
			->join('mscustomer', 'mscustomer.id = formconsultationresult.customerid', 'left')
			->join('msemployeedetail', 'msemployeedetail.employeeid = formconsultationresult.consulted_employee_id', 'left')
			->join('msemployee', 'msemployee.id = formconsultationresult.consulted_employee_id', 'left');

		$query = $db_oriskin->get();
		$data = $query->result_array();

		echo json_encode($data); // Kirim sebagai JSON
	}
	public function searchCustomerHistory()
	{
		$term = $this->input->get('search');
		$db_oriskin = $this->load->database('oriskin', TRUE);

		$results = $db_oriskin->select('id, firstname, lastname,membercode')
			->from('mscustomer')
			->like('firstname', $term)
			->or_like('lastname', $term)
			->or_like('membercode', $term)
			->limit(20)
			->get()
			->result();

		$data = [];
		foreach ($results as $row) {
			$data[] = [
				'id' => $row->id,
				'text' => $row->firstname . ' ' . $row->lastname . ' ( ' . $row->membercode . ' )'
			];
		}

		echo json_encode($data);
	}


	public function detailPrepaidInvoiceCustomer($customerid)
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$data['history_doing'] = $this->MApp->getPrepaidCustomerHistory($customerid);
		$data['treatment_info'] = $this->MApp->getPrepaidCustomerTreatmentDev($customerid);
		$data['membership_treatmentBenefit'] = $this->MApp->getPrepaidCustomerMembershipBenefit($customerid);
		$data['membershipExchange'] = $this->MApp->getPrepaidCustomerMembershipForExchange($customerid);
		$data['listAppointment'] = $this->MApp->getListAppointment($customerid);
		$data['listHistoryRetail'] = $this->MApp->getListHistoryRetail($customerid);
		$data['title'] = 'DETAIL PREPAID INVOICE';
		$data['content'] = 'detailPrepaidInvoiceCustomer';
		$data['customerId'] = $customerid;

		$this->load->view('index', $data);
	}

	public function searchRetail()
	{
		$search = $this->input->get('search');
		$data = $this->MApp->searchRetail($search);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => "{$row->code} - {$row->name}",
			];
		}

		echo json_encode($result);
	}

	public function searchLocation()
	{
		$search = $this->input->get('search');
		$data = $this->MApp->searchLocation($search);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => "{$row->shortcode} - {$row->name}"
			];
		}

		echo json_encode($result);
	}


	public function searchConsultant()
	{
		$search = $this->input->get('search');
		$data = $this->MApp->searchConsultant($search);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => "{$row->name} - {$row->locationname}"
			];
		}

		echo json_encode($result);
	}

	public function searchPaymentMethod()
	{
		$search = $this->input->get('search');
		$data = $this->MApp->searchPaymentMethod($search);

		$result = [];
		foreach ($data as $row) {
			$result[] = [
				'id' => $row->id,
				'text' => "{$row->name}"
			];
		}

		echo json_encode($result);
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

	function print_invoiceSummaryDownPayment($type, $id)
	{
		ob_start();
		$this->load->library('Ltcpdf');
		$db_oriskin = $this->load->database('oriskin', true);

		$dataHeaderDetail = $db_oriskin->query("Exec spPrintOfficalRecieptDownPayment ?, ?", [$type, $id])->result_array();

		$dataPayment = $db_oriskin->query("Exec spPrintOfficalRecieptPaymentDownPayment ?, ?", [$type, $id])->result_array();

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
		ob_end_flush();
	}



}
