<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelHr extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db_oriskin = $this->load->database('oriskin', true);
	}

	public function getShift()
	{
		$query = "SELECT * FROM msshift";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function createShift($data)
	{
		$this->db_oriskin->insert('msshift', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function createLeaveType($data)
	{
		$this->db_oriskin->insert('msleavetype', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function createAllowanceType($data)
	{
		$this->db_oriskin->insert('msallowancetype', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}


	public function createDeductionType($data)
	{
		$this->db_oriskin->insert('msdeductiontype', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}


	public function updateShiftMaster($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('msshift', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function updateLeaveTypeMaster($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('msleavetype', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function updateAllowanceType($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('msallowancetype', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function updateDeductionType($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('msdeductiontype', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}


	public function getDetailShift($id)
	{
		return $this->db_oriskin->get_where('msshift', ['id' => $id])->row_array();
	}

	public function getDetailAllowanceType($id)
	{
		return $this->db_oriskin->get_where('msallowancetype', ['id' => $id])->row_array();
	}

	public function getDetailLeaveType($id)
	{
		return $this->db_oriskin->get_where('msleavetype', ['id' => $id])->row_array();
	}

	public function getDetailDeductionType($id)
	{
		return $this->db_oriskin->get_where('msdeductiontype', ['id' => $id])->row_array();
	}

	public function searchEmployee($search)
	{
		$userid = $this->session->userdata('userid');
		$this->db_oriskin->select('a.*, b.jobid, c.name as jobname, b.locationid');
		$this->db_oriskin->from('msemployee a');
		$this->db_oriskin->join('msemployeedetail b', 'a.id = b.employeeid', 'inner');
		$this->db_oriskin->join('msjob c', 'b.jobid = c.id', 'inner');
		$this->db_oriskin->where('a.isactive', 1);
		$this->db_oriskin->where('a.isdeleted', 0);

		$this->db_oriskin->where("b.locationid IN (
        SELECT locationid 
        FROM msuser_location_access 
        WHERE userid = " . $this->db_oriskin->escape($userid) . " AND isactive = 1
    )", NULL, FALSE);

		// filter berdasarkan search
		$this->db_oriskin->where("(
        a.name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%'
        OR a.cellphonenumber LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
        OR a.nip LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%'
    )", NULL, FALSE);

		$this->db_oriskin->order_by('a.nip', 'ASC');
		$this->db_oriskin->limit(50);

		return $this->db_oriskin->get()->result();
	}



	public function addLeavePermission($data)
	{
		$this->db_oriskin->insert('leavepermission', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function updateStatusLeavePermission($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('leavepermission', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}


	public function get_all_consultations()
	{
		$this->db_oriskin->select('
			formconsultationresult.*, 
			mscustomer.firstname AS customer_firstname, 
			mscustomer.lastname AS customer_lastname, 
			msemployee.name AS employee_name
		')
			->from('formconsultationresult')
			->join('mscustomer', 'mscustomer.id = formconsultationresult.customerid', 'left')
			->join('msemployeedetail', 'msemployeedetail.employeeid = formconsultationresult.consulted_employee_id', 'left')
			->join('msemployee', 'msemployee.id = formconsultationresult.consulted_employee_id', 'left');

		$query = $this->db_oriskin->get();

		return $query->result_array();
	}

	public function get_by_period($selected_period)
	{
		$this->db_oriskin->select('
			employeeallowancemonthly.*, 
			msemployee.name AS employee_name,
			mscompany.companyname, 
			msallowancetype.allowance_name,
			mslocation.name AS location_name
		');
		$this->db_oriskin->from('employeeallowancemonthly');
		$this->db_oriskin->join('msemployee', 'msemployee.id = employeeallowancemonthly.employeeid', 'left');
		$this->db_oriskin->join('mscompany', 'mscompany.id = msemployee.companyid', 'left');
		$this->db_oriskin->join('msallowancetype', 'msallowancetype.id = employeeallowancemonthly.allowancetypeid', 'left');
		$this->db_oriskin->join('msemployeedetail', 'msemployeedetail.employeeid = msemployee.id', 'left');
		$this->db_oriskin->join('mslocation', 'mslocation.id = msemployeedetail.locationid', 'left');
		$this->db_oriskin->where('employeeallowancemonthly.period', $selected_period);

		$query = $this->db_oriskin->get();
		return $query->result_array();
	}

	public function get_by_period_deduction($period = null)
	{
		$this->db_oriskin->select('
			employeedeductionmonthly.*,
			msemployee.name AS employee_name,
			mscompany.companyname, 
			mssalarydeductiontype.deduction_name,
			mslocation.name AS location_name
		');
		$this->db_oriskin->from('employeedeductionmonthly');
		$this->db_oriskin->join('msemployee', 'msemployee.id = employeedeductionmonthly.employeeid', 'left');
		$this->db_oriskin->join('mscompany', 'mscompany.id = msemployee.companyid', 'left');
		$this->db_oriskin->join('mssalarydeductiontype', 'mssalarydeductiontype.id = employeedeductionmonthly.deductiontypeid', 'left');
		$this->db_oriskin->join('msemployeedetail', 'msemployeedetail.employeeid = msemployee.id', 'left');
		$this->db_oriskin->join('mslocation', 'mslocation.id = msemployeedetail.locationid', 'left');
		$this->db_oriskin->where('employeedeductionmonthly.period', $period);

		if (!empty($period)) {
			// Gunakan LIKE supaya cocok bulan dan tahun
			$this->db_oriskin->like('employeedeductionmonthly.period', $period, 'after');
			// artinya WHERE period LIKE '2025-07%'
		}

		$query = $this->db_oriskin->get();
		if ($query === false) {
			$error = $this->db_oriskin->error(); // Ambil error database
			log_message('error', 'DB Error: ' . print_r($error, true));
			return false; // atau handle error sesuai kebutuhan
		}

		return $query->result_array();
	}

	public function get_all_allowance($period = null)
	{
		$this->db_oriskin->select('
			employeeallowancemonthly.*, 
			msemployee.name AS employee_name, 
			msallowancetype.allowance_name AS allowance_type
		')
			->from('employeeallowancemonthly')
			->join('msemployee', 'msemployee.id = employeeallowancemonthly.employeeid', 'left')
			->join('msallowancetype', 'msallowancetype.id = employeeallowancemonthly.allowancetypeid', 'left');

		if (!empty($period)) {
			// Gunakan LIKE supaya cocok bulan dan tahun
			$this->db_oriskin->like('employeeallowancemonthly.period', $period, 'after');
			// artinya WHERE period LIKE '2025-07%'
		}

		$query = $this->db_oriskin->get();
		return $query->result_array();
	}

	public function get_allowance_detail($id)
	{
		if (empty($id))
			return null;

		$this->db_oriskin->select('
            employeeallowancemonthly.*, 
            msemployee.name AS employee_name, 
            msallowancetype.allowance_name AS allowance_type
        ')
			->from('employeeallowancemonthly')
			->join('msemployee', 'msemployee.id = employeeallowancemonthly.employeeid', 'left')
			->join('msallowancetype', 'msallowancetype.id = employeeallowancemonthly.allowancetypeid', 'left')
			->where('employeeallowancemonthly.id', $id);

		$query = $this->db_oriskin->get();
		return $query->row_array();
	}

	public function get_deduction_detail($id)
	{
		if (empty($id))
			return null;

		$this->db_oriskin->select('
            employeedeductionmonthly.*, 
            msemployee.name AS employee_name, 
            mssalarydeductiontype.deduction_name AS deduction_type
        ')
			->from('employeedeductionmonthly')
			->join('msemployee', 'msemployee.id = employeedeductionmonthly.employeeid', 'left')
			->join('mssalarydeductiontype', 'mssalarydeductiontype.id = employeedeductionmonthly.deductiontypeid', 'left')
			->where('employeedeductionmonthly.id', $id);

		$query = $this->db_oriskin->get();
		return $query->row_array();
	}

	public function update_allowance($id, $data)
	{
		if (empty($id) || empty($data))
			return false;

		$this->db_oriskin->where('id', $id);
		return $this->db_oriskin->update('employeeallowancemonthly', $data);
	}

	public function update_deduction($id, $data)
	{
		if (empty($id) || empty($data))
			return false;

		$this->db_oriskin->where('id', $id);
		return $this->db_oriskin->update('employeedeductionmonthly', $data);
	}

	// Delete allowance by id
	public function delete_allowance($id)
	{
		if (empty($id))
			return false;

		$this->db_oriskin->where('id', $id);
		return $this->db_oriskin->delete('employeeallowancemonthly');
	}

	public function get_all_deduction($period = null)
	{
		$this->db_oriskin->select('
			employeedeductionmonthly.*, 
			msemployee.name AS employee_name, 
			mssalarydeductiontype.deduction_name AS deduction_type
		')
			->from('employeedeductionmonthly')
			->join('msemployee', 'msemployee.id = employeedeductionmonthly.employeeid', 'left')
			->join('mssalarydeductiontype', 'mssalarydeductiontype.id = employeedeductionmonthly.deductiontypeid', 'left');

		if (!empty($period)) {
			// Gunakan LIKE supaya cocok bulan dan tahun
			$this->db_oriskin->like('employeedeductionmonthly.period', $period, 'after');
			// artinya WHERE period LIKE '2025-07%'
		}

		$query = $this->db_oriskin->get();
		return $query->result_array();
	}

	// Update data employeeallowancemonthly berdasarkan id
	public function update_allowance_monthly($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		return $this->db_oriskin->update('employeeallowancemonthly', $data);
	}

	// Ambil data employeeallowancemonthly berdasarkan id
	public function get_allowance_by_id($id)
	{
		return $this->db_oriskin->get_where('employeeallowancemonthly', ['id' => $id])->row_array();
	}

	public function count_all_allowance()
	{
		return $this->db_oriskin->count_all('employeeallowancemonthly');
	}

	public function get_all_allowance_by_emp_period($employeeid, $period)
	{
		return $this->db_oriskin->select('ea.id, ea.allowancetypeid, at.allowance_name as allowance_name, ea.amount, ea.datestart, ea.dateend')
			->from('employeeallowancemonthly ea')
			->join('msallowancetype at', 'at.id = ea.allowancetypeid', 'left')
			->where('ea.employeeid', $employeeid)
			->where('ea.period', $period)
			->order_by('ea.datestart', 'ASC')
			->get()
			->result();
	}

	public function get_all_deduction_by_emp_period($employeeid, $period)
	{
		return $this->db_oriskin->select('ed.id, ed.deductiontypeid, dt.deduction_name as deduction_name, ed.amount, ed.datestart, ed.dateend')
			->from('employeedeductionmonthly ed')
			->join('mssalarydeductiontype dt', 'dt.id = ed.deductiontypeid', 'left')
			->where('ed.employeeid', $employeeid)
			->where('ed.period', $period)
			->order_by('ed.datestart', 'ASC')
			->get()
			->result();
	}

	public function get_all_with_details($selected_period, $company_id = null)
	{
		$this->db_oriskin->select("
			e.id AS employee_id,
			e.name AS employee_name,
			ed.accountnumber AS account,
			ed.salary AS salary,
			c.id AS company_id,
			c.companyname AS company_name,
			j.id AS job_id,
			j.name AS job_name,
			eam.allowancetypeid,
			eam.amount AS allowance_amount,
			eam.period AS allowance_period,
			edm.deductiontypeid,
			edm.amount AS deduction_amount,
			edm.period AS deduction_period
		");

		$this->db_oriskin->from('msemployee e');
		$this->db_oriskin->join('mscompany c', 'e.companyid = c.id', 'left');
		$this->db_oriskin->join('msemployeedetail ed', 'e.id = ed.employeeid', 'left');
		$this->db_oriskin->join('msjob j', 'ed.jobid = j.id', 'left');
		$this->db_oriskin->join('employeeallowancemonthly eam', 'e.id = eam.employeeid', 'left');
		$this->db_oriskin->join('employeedeductionmonthly edm', 'e.id = edm.employeeid', 'left');

		$this->db_oriskin->group_start()
			->where('eam.period', $selected_period)
			->or_where('edm.period', $selected_period)
			->group_end();

		if (!empty($company_id)) {
			$this->db_oriskin->where('e.companyid', $company_id);
		}

		$query = $this->db_oriskin->get();
		if (!$query) {
			$error = $this->db_oriskin->error();
			log_message('error', 'DB Error: ' . print_r($error, true));
			return [];
		}
		return $query->result();
	}

	public function getListJob()
	{
		$query = "SELECT * FROM msjob";
		return $this->db_oriskin->query($query)->result_array();
	}


	public function getJobById($id)
	{
		$query = "SELECT * FROM msjob WHERE id = $id";
		return $this->db_oriskin->query($query)->row_array();
	}

	public function updateJob($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('msjob', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function createJob($data)
	{
		$this->db_oriskin->insert('msjob', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function getListPublicHolidayCalender()
	{
		$query = "SELECT a.*, b.name as locationname FROM ms_calender_public_holiday a inner join mslocation b ON a.locationid = b.id";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getListPublicHolidayCalenderById($id)
	{
		$query = "SELECT a.*, b.name as locationname FROM ms_calender_public_holiday a INNER JOIN mslocation b ON a.locationid = b.id  WHERE a.id = $id";
		return $this->db_oriskin->query($query)->row_array();
	}

	public function updatePublicHolidayCalender($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('ms_calender_public_holiday', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function createPublicHolidayCalender($data)
	{
		$this->db_oriskin->insert('ms_calender_public_holiday', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}


	public function checkAllowanceEmployee($employeeid, $allowanceid)
	{
		$this->db_oriskin->from('msallowance');
		$this->db_oriskin->where('allowancetypeid', $allowanceid);
		$this->db_oriskin->where('employeeid', $employeeid);
		$query = $this->db_oriskin->get();
		return $query->num_rows() > 0;
	}

	public function getAttandanceLogManual()
	{
		$query = "SELECT a.*, b.name as employeename FROM attendancelog_manual a INNER JOIN  msemployee b ON a.employeeid = b.id";
		return $this->db_oriskin->query($query)->result_array();
	}



	public function updateAttandanceLogManual($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('attendancelog_manual', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function createAttandanceLogManual($data)
	{
		$this->db_oriskin->insert('attendancelog_manual', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function getAttandanceLogManualById($id)
	{
		$query = "SELECT a.*, b.name as employeename 
		FROM attendancelog_manual a INNER JOIN  msemployee b ON a.employeeid = b.id
		WHERE a.id = $id
		";
		return $this->db_oriskin->query($query)->row_array();
	}

	public function listEmployeeCompany($isactive = null, $locationid = null, $employeeid = null)
	{
		$this->db_oriskin->select('a.id, a.name, a.nip, a.isactive, ml.name as locationname, a.cellphonenumber, 
		ea.id as accountid, ea.isactive as isaccountactive, ea.password');
		$this->db_oriskin->from('msemployee a');
		$this->db_oriskin->join('msemployeedetail mdt', 'a.id = mdt.employeeid', 'inner');
		$this->db_oriskin->join('mslocation ml', 'mdt.locationid = ml.id', 'inner');
		$this->db_oriskin->join('employee_account ea', 'a.id = ea.employeeid', 'left');
		$this->db_oriskin->where('mdt.locationid !=', 6);
		$this->db_oriskin->where('a.isdeleted !=', 1);

		if ($isactive !== null && $isactive !== '') {
			$this->db_oriskin->where('a.isactive', $isactive);
		}

		if ($locationid !== null && $locationid !== '') {
			$this->db_oriskin->where('mdt.locationid', $locationid);
		}

		if ($employeeid !== null && $employeeid !== '') {
			$this->db_oriskin->where('a.id', $employeeid);
		}

		$employees = $this->db_oriskin->get()->result_array();

		foreach ($employees as &$emp) {
			$companies = $this->db_oriskin->select('ec.id as employee_companyid, c.companyname, mpg.groupname as payrollgroup, 
				mj.name as jobname, ec.basesalary, ec.startdate, ec.enddate,
				met.name as employmenttype, mst.name as salarytype, c.id,
				ec.is_bpjs_tk_registered, ec.is_bpjs_health_registered
				')
				->from('employee_company ec')
				->join('mscompany c', 'c.id = ec.companyid')
				->join('mspayrollgroup mpg', 'ec.payrollgroupid = mpg.id', 'left')
				->join('msjob mj', 'ec.jobid = mj.id', 'left')
				->join('msemploymenttype met', 'ec.employmenttypeid = met.id', 'left')
				->join('mssalarytype mst', 'ec.salarytypeid = mst.id', 'left')
				->where('ec.employeeid', $emp['id'])
				->get()
				->result_array();

			foreach ($companies as &$comp) {
				$comp['allowances'] = $this->db_oriskin
					->select('t.allowance_name, a.amount, a.id, a.isactive')
					->from('msallowance a')
					->join('msallowancetype t', 't.id = a.allowancetypeid', 'left')
					->where('a.employeeid', $emp['id'])
					->where('a.companyid', $comp['id'])
					->get()
					->result_array();
			}
			$emp['companies'] = $companies;
		}

		return $employees;
	}

	public function editModalEmployee($id)
	{
		$query = "SELECT a.*, b.address, b.jobid, b.locationid, b.startdate, b.accountnumber, b.npwp, b.enddate
		FROM msemployee a 
		INNER JOIN msemployeedetail b ON a.id = b.employeeid 
		WHERE a.id = $id";
		return $this->db_oriskin->query($query)->row_array();
	}

	public function employeePayroll($companyId, $month, $year)
	{
		$this->db_oriskin->select('a.*, me.*, mpg.groupname as payroll_group, mc.companyname as companyname, a.is_bpjs_health_registered as is_bpjs_health_registered, a.is_bpjs_tk_registered as is_bpjs_tk_registered, ec.startdate as join_date, ec.enddate as end_date, a.id as sallarypayrollid');
		$this->db_oriskin->from('trpayroll a');
		$this->db_oriskin->join('msemployee me', 'a.employeeid = me.id', 'inner');
		$this->db_oriskin->join('mspayrollgroup mpg', 'a.payrollid = mpg.id', 'inner');
		$this->db_oriskin->join('mscompany mc', 'a.companyid = mc.id', 'inner');
		$this->db_oriskin->join('employee_company ec', 'a.employeecompanyid = ec.id', 'inner');
		$this->db_oriskin->where('a.periodmonth', $month);
		$this->db_oriskin->where('a.periodyear', $year);
		$this->db_oriskin->where('a.companyid', $companyId);

		$payroll = $this->db_oriskin->get()->result_array();

		// jika tidak ada payroll return langsung
		if (empty($payroll))
			return $payroll;

		// ambil semua employeeid dari payroll
		$employeeIds = array_column($payroll, 'employeeid');

		// ambil semua allowance untuk company+period, group by employeeid
		$allowRows = $this->db_oriskin
			->select('*')
			->from('trpayroll_detail_allowance')
			->where_in('employeeid', $employeeIds)
			->where('companyid', $companyId)
			->where('periodmonth', $month)
			->where('periodyear', $year)
			->get()
			->result_array();

		$allowMap = [];
		foreach ($allowRows as $r) {
			$allowMap[$r['employeeid']][] = $r;
		}

		// ambil semua deduction
		$deductRows = $this->db_oriskin
			->select('*')
			->from('trpayroll_detail_deduction')
			->where_in('employeeid', $employeeIds)
			->where('companyid', $companyId)
			->where('periodmonth', $month)
			->where('periodyear', $year)
			->get()
			->result_array();

		$deductMap = [];
		foreach ($deductRows as $r) {
			$deductMap[$r['employeeid']][] = $r;
		}

		// ambil semua leave
		$leaveRows = $this->db_oriskin
			->select('*')
			->from('trpayroll_detail_leave')
			->where_in('employeeid', $employeeIds)
			->where('companyid', $companyId)
			->where('periodmonth', $month)
			->where('periodyear', $year)
			->get()
			->result_array();

		$leaveMap = [];
		foreach ($leaveRows as $r) {
			$leaveMap[$r['employeeid']][] = $r;
		}

		// Attach ke payroll
		foreach ($payroll as &$pay) {
			$eid = $pay['employeeid'];
			$pay['allowance'] = isset($allowMap[$eid]) ? $allowMap[$eid] : [];
			$pay['deduction'] = isset($deductMap[$eid]) ? $deductMap[$eid] : [];
			$pay['leave'] = isset($leaveMap[$eid]) ? $leaveMap[$eid] : [];
		}
		unset($pay); // sangat penting untuk menghilangkan reference

		return $payroll;
	}



	public function allowanceUncertain($companyId = null, $month, $year)
	{
		$this->db_oriskin->select('a.id, me.name as employeename, mc.companyname, a.amount, a.allowancename, a.isactive, a.description');
		$this->db_oriskin->from('trpayroll_detail_allowance a');
		$this->db_oriskin->join('msemployee me', 'a.employeeid = me.id', 'inner');
		$this->db_oriskin->join('mscompany mc', 'a.companyid = mc.id', 'inner');
		$this->db_oriskin->join('employee_company ec', 'a.employeecompanyid = ec.id', 'inner');
		$this->db_oriskin->where('a.periodmonth', $month);
		$this->db_oriskin->where('a.periodyear', $year);
		$this->db_oriskin->where('a.isfromgenerate', 0);
		if ($companyId) {
			$this->db_oriskin->where('a.companyid', $companyId);
		}
		$allowanceUncertain = $this->db_oriskin->get()->result_array();
		return $allowanceUncertain;
	}


	public function getAllowanceUncertain($id)
	{
		$this->db_oriskin->select('a.id, me.name as employeename, mc.companyname, 
		a.amount, a.allowanceid, a.employeeid, a.employeecompanyid, a.companyid, a.payrollid, a.isactive, a.description');
		$this->db_oriskin->from('trpayroll_detail_allowance a');
		$this->db_oriskin->join('msemployee me', 'a.employeeid = me.id', 'inner');
		$this->db_oriskin->join('mscompany mc', 'a.companyid = mc.id', 'inner');
		$this->db_oriskin->join('employee_company ec', 'a.employeecompanyid = ec.id', 'inner');
		$this->db_oriskin->where('a.id', $id);
		$allowanceUncertain = $this->db_oriskin->get()->row_array();
		return $allowanceUncertain;
	}



	public function searchEmployeeForUncertainAllowance($search)
	{
		$this->db_oriskin->select('a.*, b.jobid, c.name as jobname, b.locationid, 
			ec.id as employeecompanyid, mc.id as companyidemployee
			, mc.companyname as companyname, ec.payrollgroupid as payrollid
		');
		$this->db_oriskin->from('msemployee a');
		$this->db_oriskin->join('msemployeedetail b', 'a.id = b.employeeid', 'inner');
		$this->db_oriskin->join('msjob c', 'b.jobid = c.id', 'inner');
		$this->db_oriskin->join('employee_company ec', 'a.id = ec.employeeid', 'inner');
		$this->db_oriskin->join('mscompany mc', 'ec.companyid = mc.id', 'inner');
		$this->db_oriskin->where('a.isactive', 1);
		$this->db_oriskin->where('a.isdeleted', 0);
		$this->db_oriskin->where('ec.isactive', 1);

		$this->db_oriskin->where("(
        a.name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%'
        OR a.cellphonenumber LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
        OR a.nip LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%'
    )", NULL, FALSE);

		$this->db_oriskin->order_by('a.nip', 'ASC');
		$this->db_oriskin->limit(50);

		return $this->db_oriskin->get()->result();
	}


	public function deductionUncertain($companyId = null, $month, $year)
	{
		$this->db_oriskin->select('a.id, me.name as employeename, mc.companyname, a.amount, a.deductionname, a.isactive, a.description');
		$this->db_oriskin->from('trpayroll_detail_deduction a');
		$this->db_oriskin->join('msemployee me', 'a.employeeid = me.id', 'inner');
		$this->db_oriskin->join('mscompany mc', 'a.companyid = mc.id', 'inner');
		$this->db_oriskin->join('employee_company ec', 'a.employeecompanyid = ec.id', 'inner');
		$this->db_oriskin->where('a.periodmonth', $month);
		$this->db_oriskin->where('a.periodyear', $year);
		$this->db_oriskin->where('a.isfromgenerate', 0);
		if ($companyId) {
			$this->db_oriskin->where('a.companyid', $companyId);
		}
		$allowanceUncertain = $this->db_oriskin->get()->result_array();
		return $allowanceUncertain;
	}


	public function getDeductionUncertain($id)
	{
		$this->db_oriskin->select('a.id, me.name as employeename, mc.companyname, 
		a.amount, a.deductionid, a.employeeid, a.employeecompanyid, a.companyid, a.payrollid, a.isactive, a.description');
		$this->db_oriskin->from('trpayroll_detail_deduction a');
		$this->db_oriskin->join('msemployee me', 'a.employeeid = me.id', 'inner');
		$this->db_oriskin->join('mscompany mc', 'a.companyid = mc.id', 'inner');
		$this->db_oriskin->join('employee_company ec', 'a.employeecompanyid = ec.id', 'inner');
		$this->db_oriskin->where('a.id', $id);
		$allowanceUncertain = $this->db_oriskin->get()->row_array();
		return $allowanceUncertain;
	}



}
