<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelPurchasing extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db_oriskin = $this->load->database('oriskin', true);
	}

	public function getCityMaster()
	{
		$query = "SELECT * FROM mscity";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getProvinceMaster()
	{
		$query = "SELECT * FROM msprovince";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getCountryMaster()
	{
		$query = "SELECT * FROM mscountry";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getCompanyMaster()
	{
		$query = "SELECT a.*, b.name as cityname, c.name as provincename, d.countryname as countryname FROM mscompany a LEFT JOIN mscity b ON a.cityid = b.id LEFT JOIN msprovince c ON a.provinceid = c.id  LEFT JOIN mscountry d ON a.countryid = d.id";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getCompanyMasters()
	{
		$this->db_oriskin->select("id, CONCAT(companycode, ' - ', companyname) as text");
		$this->db_oriskin->from('mscompany');
		$this->db_oriskin->order_by('id', 'ASC');
		return $this->db_oriskin->get()->result_array();
	}


	public function getCompanyMasterById($id)
	{
		$query = "SELECT * FROM mscompany WHERE id = $id";
		return $this->db_oriskin->query($query)->row_array();
	}

	public function getCompany($search = null, $level = null, $locationid = null)
	{
		$this->db_oriskin->select("c.id, CONCAT(c.companycode, ' - ', c.companyname) as text");
		$this->db_oriskin->from('mscompany c');

		if ($level == 1 && !empty($locationid)) {
			$this->db_oriskin->join('mslocation l', 'l.companyid = c.id', 'left');
			$this->db_oriskin->where('l.id', $locationid);
			return $this->db_oriskin->get()->row_array();
		}

		if (!empty($search)) {
			$this->db_oriskin->like('companycode', $search);
			$this->db_oriskin->or_like('companyname', $search);
			$this->db_oriskin->order_by('id', 'ASC');
			return $this->db_oriskin->get()->result_array();
		}
	}

	public function getWarehouse($search = null, $level = null, $locationid = null)
	{
		$this->db_oriskin->select("w.id, CONCAT(w.warehouse_code, ' - ', w.warehouse_name) as text");
		$this->db_oriskin->from('mswarehouse w');

		if ($level == 1 && !empty($locationid)) {
			$this->db_oriskin->join('mslocation l', 'l.warehouseid = w.id', 'left');
			$this->db_oriskin->where('l.id', $locationid);
			return $this->db_oriskin->get()->row_array();
		}

		if (!empty($search) && $level != 1) {
			$this->db_oriskin->like('warehouse_code', $search);
			$this->db_oriskin->or_like('warehouse_name', $search);
			$this->db_oriskin->order_by('id', 'ASC');
			return $this->db_oriskin->get()->result_array();
		}

	}

	public function get_location($search = null)
	{
		$this->db_oriskin->select("id, CONCAT(shortcode, ' - ', name) as text");
		$this->db_oriskin->from('mslocation');

		if (!empty($search)) {
			$this->db_oriskin->like('shortcode', $search);
			$this->db_oriskin->or_like('name', $search);
		}

		$this->db_oriskin->order_by('id', 'ASC');
		return $this->db_oriskin->get()->result_array();
	}

	public function get_location_by_id($id)
	{
		$this->db_oriskin->select("c.companyname,c.companycode");
		$this->db_oriskin->from('mslocation l');
		$this->db_oriskin->join('mscompany c', 'c.id=l.companyid');
		$this->db_oriskin->where('id', $id);
		return $this->db_oriskin->get()->result_array();
	}

	public function get_location_data_by_id($id)
	{
		$this->db_oriskin->select("l.*, c.companyname, c.companycode, w.warehouse_name");
		$this->db_oriskin->from('mslocation l');
		$this->db_oriskin->join('mscompany c', 'c.id = l.companyid', 'left');
		$this->db_oriskin->join('mswarehouse w', 'w.id = l.warehouseid', 'left');
		$this->db_oriskin->where('l.id', $id);
		return $this->db_oriskin->get()->row();
	}

	public function update_location($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$result = $this->db_oriskin->update('mslocation', $data);

		log_message('error', 'UPDATE SQL: ' . $this->db_oriskin->last_query());
		log_message('error', 'RESULT: ' . json_encode($result));

		return $result;
	}

	public function add_location($data)
	{
		$result = $this->db_oriskin->insert('mslocation', $data);
		return $result;
	}

	public function deletePurchaseRequestItem($pri_id)
	{
		return $this->db_oriskin->where('id', $pri_id)->delete('purchase_request_items');
	}

	// public function getWarehouse($search = null)
	// {
	// 	$this->db_oriskin->select("id, CONCAT(warehouse_code, ' - ', warehouse_name) as text");
	// 	$this->db_oriskin->from('mswarehouse');

	// 	if (!empty($search)) {
	// 		$this->db_oriskin->like('warehouse_code', $search);
	// 		$this->db_oriskin->or_like('warehouse_name', $search);
	// 	}

	// 	$this->db_oriskin->order_by('id', 'ASC');
	// 	return $this->db_oriskin->get()->result_array();
	// }



	public function createCompanyMaster($data)
	{
		$this->db_oriskin->insert('mscompany', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function insert_bk($data)
	{
		$this->db_oriskin->insert('bukti_pengeluaran_kas', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function updateCompanyMaster($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('mscompany', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function update_pr($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('purchase_request', $data);

		if ($this->db_oriskin->affected_rows() > 0) {
			return true; // ada data yang berubah
		} else {
			return false; // tidak ada perubahan (atau gagal)
		}
	}

	public function update_employee_account($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('employee_account', $data);

		if ($this->db_oriskin->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function insert($data)
	{
		$this->db_oriskin->insert('bukti_pengeluaran_kas', $data);
		return $this->db->insert_id();
	}

	public function getByPurchaseOrder($purchaseorderid)
	{
		return $this->db_oriskin->where('purchaseorderid', $purchaseorderid)
			->get('bukti_pengeluaran_kas')
			->result();
	}

	public function saveSupplier($data)
	{
		try {
			$insert = $this->db_oriskin->insert('mssupplier', $data);

			if ($insert) {
				return true;
			} else {
				$error = $this->db_oriskin->error();
				return $error['message'];
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function insertSupplier($data)
	{
		try {
			$insert = $this->db_oriskin->insert('mssupplier', $data);

			if ($insert) {
				return true;
			} else {
				$error = $this->db_oriskin->error();
				log_message('error', 'Insert Supplier Error: ' . $error['message']);
				return $error['message'];
			}
		} catch (Exception $e) {
			log_message('error', 'Exception Insert Supplier: ' . $e->getMessage());
			return $e->getMessage();
		}
	}

	public function search_items($search)
	{
		$this->db_oriskin->select('id, code, name');
		$this->db_oriskin->from('msingredients');
		$this->db_oriskin->where('isactive', 1);
		$this->db_oriskin->where("(code LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
		$this->db_oriskin->order_by('code', 'ASC');
		$this->db_oriskin->limit(50); // Batasi hasil agar lebih cepat
		return $this->db_oriskin->get()->result();
	}



	public function insertSupplierSales($data)
	{
		try {
			$insert = $this->db_oriskin->insert('suppliersales', $data);

			if ($insert) {
				return true;
			} else {
				$error = $this->db_oriskin->error();
				log_message('error', 'Insert Supplier Error: ' . $error['message']);
				return $error['message'];
			}
		} catch (Exception $e) {
			log_message('error', 'Exception Insert Supplier: ' . $e->getMessage());
			return $e->getMessage();
		}
	}

	public function getSuppliers()
	{
		$query = $this->db_oriskin->select('
				s.*,
				p.name AS province_name,
				c.name AS city_name
			')
			->from('mssupplier s')
			->join('msprovince p', 'p.id = s.provinceid', 'left')
			->join('mscity c', 'c.id = s.cityid', 'left')
			// ->where('isactive',1)
			->get();

		return $query->result_array();
	}

	public function getSupplierById($id)
	{
		$query = $this->db_oriskin
			->select('
				s.*,
				p.name AS province_name,
				c.name AS city_name
			')
			->from('mssupplier s')
			->join('msprovince p', 'p.id = s.provinceid', 'left')
			->join('mscity c', 'c.id = s.cityid', 'left')
			->where('s.id', $id)
			->limit(1)
			->get();

		return $query->row_array(); // row_array karena hanya 1 data
	}

	public function getCityLists($keyword = null)
	{
		$this->db_oriskin->select('id, name');
		$this->db_oriskin->from('mscity');
		if (!empty($keyword)) {
			$this->db_oriskin->like('name', $keyword);
		}
		return $this->db_oriskin->get()->result();
	}

	public function getProvinceList($keyword = null)
	{
		$this->db_oriskin->select('id, name');
		$this->db_oriskin->from('msprovince');
		if (!empty($keyword)) {
			$this->db_oriskin->like('name', $keyword);
		}
		return $this->db_oriskin->get()->result();
	}

	public function getCityByProvince($provinceid, $keyword = null)
	{
		$this->db_oriskin->select('id, name');
		$this->db_oriskin->from('mscity');
		$this->db_oriskin->where('provinceid', $provinceid);
		if (!empty($keyword)) {
			$this->db_oriskin->like('name', $keyword);
		}
		return $this->db_oriskin->get()->result();
	}

	public function get_all_purchase_request()
	{
		$this->db_oriskin->select('
            r.id,
            r.requestnumber,
            r.requestdate,
			r.requesterid,
            r.status,
			r.updatedat,
            r.notes,
            r.description,
            e.name AS requester_name,
            d.department_name,
            c.companyname AS company_name,
            w.warehouse_name AS warehouse_name
        ');
		$this->db_oriskin->from('purchase_request r');
		$this->db_oriskin->join('msemployee e', 'r.requesterid = e.id', 'left');
		$this->db_oriskin->join('msemployeedetail ed', 'ed.employeeid = e.id', 'left');
		$this->db_oriskin->join('msdepartment d', 'ed.departmentid = d.id', 'left');
		$this->db_oriskin->join('mscompany c', 'r.companyid = c.id', 'left');
		$this->db_oriskin->join('mswarehouse w', 'r.warehouseid = w.id', 'left');
		$this->db_oriskin->order_by('r.id', 'DESC');

		$query = $this->db_oriskin->get();
		return $query->result_array();
	}

	public function get_all_purchase_request_by_user($user, $date)
	{
		$this->db_oriskin->select('
            r.id,
            r.requestnumber,
            r.requestdate,
			r.requesterid,
			r.isactive,
            r.status,
            r.notes,
			r.updatedat,
            r.description,
            e.name AS requester_name,
            d.department_name,
            c.companyname AS company_name,
            w.warehouse_name AS warehouse_name
        ');
		$this->db_oriskin->from('purchase_request r');
		$this->db_oriskin->join('msemployee e', 'r.requesterid = e.id', 'left');
		$this->db_oriskin->join('msemployeedetail ed', 'ed.employeeid = e.id', 'left');
		$this->db_oriskin->join('msdepartment d', 'ed.departmentid = d.id', 'left');
		$this->db_oriskin->join('mscompany c', 'r.companyid = c.id', 'left');
		$this->db_oriskin->join('mswarehouse w', 'r.warehouseid = w.id', 'left');
		$this->db_oriskin->where("r.requestdate >=", $date . ' 00:00:00');
		$this->db_oriskin->where("r.requestdate <=", $date . ' 23:59:59');
		$this->db_oriskin->where('r.createdby', $user);
		$this->db_oriskin->order_by('r.id', 'DESC');

		$query = $this->db_oriskin->get();
		return $query->result_array();
	}

	public function get_all_purchase_request_by_date($date = null, $company = null)
	{
		$this->db_oriskin->select('
            r.id,
            r.requestnumber,
            r.requestdate,
			r.requesterid,
            r.status,
			r.isactive,
            r.notes,
			r.updatedat,
            r.description,
            e.name AS requester_name,
            d.department_name,
            c.companyname AS company_name,
            w.warehouse_name AS warehouse_name
        ');
		$this->db_oriskin->from('purchase_request r');
		$this->db_oriskin->join('msemployee e', 'r.requesterid = e.id', 'left');
		$this->db_oriskin->join('msemployeedetail ed', 'ed.employeeid = e.id', 'left');
		$this->db_oriskin->join('msdepartment d', 'ed.departmentid = d.id', 'left');
		$this->db_oriskin->join('mscompany c', 'r.companyid = c.id', 'left');
		$this->db_oriskin->join('mswarehouse w', 'r.warehouseid = w.id', 'left');

		if (!empty($date)) {
			$this->db_oriskin->where("r.requestdate >=", $date . ' 00:00:00');
			$this->db_oriskin->where("r.requestdate <=", $date . ' 23:59:59');
		}

		if (!empty($company)) {
			$this->db_oriskin->where('r.companyid', $company);
		}
		$this->db_oriskin->order_by('r.id', 'DESC');
		$query = $this->db_oriskin->get();
		return $query->result_array();
	}


	public function get_all_purchase_order()
	{
		$this->db_oriskin->select('
            o.*,
			o.id,
			r.id AS request_id,
            r.requestnumber,
            r.requestdate,
            o.status,
            r.notes,
            r.description,
			o.order_number,
            e.name AS requester_name,
			e2.name AS orderer_name,
            d.name AS department_name,
            c.companyname AS company_name,
            w.warehouse_name AS warehouse_name
        ');
		$this->db_oriskin->from('purchase_order o');
		$this->db_oriskin->join('purchase_request r', 'o.purchaserequestid = r.id', 'left');
		$this->db_oriskin->join('msemployee e', 'r.requesterid = e.id', 'left');
		$this->db_oriskin->join('msemployee e2', 'o.ordererid = e2.id', 'left');
		$this->db_oriskin->join('msdepartment d', 'r.departmentid = d.id', 'left');
		$this->db_oriskin->join('mscompany c', 'r.companyid = c.id', 'left');
		$this->db_oriskin->join('mswarehouse w', 'r.warehouseid = w.id', 'left');
		$this->db_oriskin->order_by('r.id', 'DESC');

		$query = $this->db_oriskin->get();
		return $query->result_array();
	}



	public function get_all_purchase_order_by_user($date, $user)
	{
		$this->db_oriskin->select('
			o.*,
			o.id,
			r.id AS request_id,
			r.requestnumber,
			r.requestdate,
			o.status,
			r.notes,
			r.description,
			o.order_number,
			e.name AS requester_name,
			e2.name AS orderer_name,
			d.name AS department_name,
			c.companyname AS company_name,
			w.warehouse_name AS warehouse_name
		');
		$this->db_oriskin->from('purchase_order o');
		$this->db_oriskin->join('purchase_request r', 'o.purchaserequestid = r.id', 'left');
		$this->db_oriskin->join('msemployee e', 'r.requesterid = e.id', 'left');
		$this->db_oriskin->join('msemployee e2', 'o.ordererid = e2.id', 'left');
		$this->db_oriskin->join('msdepartment d', 'r.departmentid = d.id', 'left');
		$this->db_oriskin->join('mscompany c', 'r.companyid = c.id', 'left');
		$this->db_oriskin->join('mswarehouse w', 'r.warehouseid = w.id', 'left');

		// filter by userid langsung
		if ($user) {
			$this->db_oriskin->where('o.orderer_id', $user);
		}

		$this->db_oriskin->order_by('o.orderer_date', 'DESC');

		$query = $this->db_oriskin->get();
		return $query->result_array();
	}

	public function get_all_purchase_order_by_date_approval($date, $user)
	{
		$this->db_oriskin->select('
			o.*,
			o.id,
			r.id AS request_id,
			r.requestnumber,
			r.requestdate,
			o.status,
			r.notes,
			o.notes AS order_notes,
			r.description,
			o.order_number,
			e.name AS requester_name,
			e2.name AS orderer_name,
			d.name AS department_name,
			c.companyname AS company_name,
			w.warehouse_name AS warehouse_name
		');
		$this->db_oriskin->from('purchase_order o');
		$this->db_oriskin->join('purchase_request r', 'o.purchaserequestid = r.id', 'left');
		$this->db_oriskin->join('msemployee e', 'r.requesterid = e.id', 'left');
		$this->db_oriskin->join('msemployee e2', 'o.ordererid = e2.id', 'left');
		$this->db_oriskin->join('msdepartment d', 'r.departmentid = d.id', 'left');
		$this->db_oriskin->join('mscompany c', 'r.companyid = c.id', 'left');
		$this->db_oriskin->join('mswarehouse w', 'r.warehouseid = w.id', 'left');

		// filter by userid langsung
		if ($user) {
			$this->db_oriskin->where('o.orderer_id', $user);
		}


		$this->db_oriskin->order_by('o.orderer_date', 'DESC');

		$query = $this->db_oriskin->get();
		return $query->result_array();
	}

	public function get_all_purchase_order_by_date($date = null, $company = null)
	{
		// Select kolom-kolom yang dibutuhkan
		$this->db_oriskin->select('
			o.*,
			o.id,
			o.orderdate,
			r.id AS request_id,
			r.requestnumber,
			r.requestdate,
			o.status,
			r.notes,
			o.notes AS order_notes,
			r.description,
			o.order_number,
			e.name AS requester_name,
			e2.name AS orderer_name,
			d.name AS department_name,
			c.companyname AS company_name,
			w.warehouse_name AS warehouse_name
		');

		// Tabel utama
		$this->db_oriskin->from('purchase_order o');

		// Join tabel terkait
		$this->db_oriskin->join('purchase_request r', 'o.purchaserequestid = r.id', 'left');
		$this->db_oriskin->join('msemployee e', 'r.requesterid = e.id', 'left');
		$this->db_oriskin->join('msemployee e2', 'o.ordererid = e2.id', 'left');
		$this->db_oriskin->join('msdepartment d', 'r.departmentid = d.id', 'left');
		$this->db_oriskin->join('mscompany c', 'r.companyid = c.id', 'left');
		$this->db_oriskin->join('mswarehouse w', 'r.warehouseid = w.id', 'left');

		if (!empty($date)) {
			$this->db_oriskin->where("o.orderdate >=", $date . ' 00:00:00');
			$this->db_oriskin->where("o.orderdate <=", $date . ' 23:59:59');
		}

		if (!empty($company)) {
			$this->db_oriskin->where('r.companyid', $company);
		}
		// Urutkan dari yang terbaru
		$this->db_oriskin->order_by('o.id', 'DESC');

		// Jalankan query
		$query = $this->db_oriskin->get();

		// Log query untuk debug
		log_message('error', 'Query Purchase Order by Date: ' . $this->db_oriskin->last_query());

		// Kembalikan hasil sebagai array
		return $query->result_array();
	}

	public function get_all_purchase_order_by_date_user($date, $userid)
	{
		// Select kolom-kolom yang dibutuhkan
		$this->db_oriskin->select('
			o.*,
			o.id,
			o.orderdate,
			r.id AS request_id,
			r.requestnumber,
			r.requestdate,
			o.status,
			r.notes,
			r.description,
			o.order_number,
			e.name AS requester_name,
			e2.name AS orderer_name,
			d.name AS department_name,
			c.companyname AS company_name,
			w.warehouse_name AS warehouse_name
		');

		$this->db_oriskin->from('purchase_order o');
		$this->db_oriskin->join('purchase_request r', 'o.purchaserequestid = r.id', 'left');
		$this->db_oriskin->join('msemployee e', 'r.requesterid = e.id', 'left');
		$this->db_oriskin->join('msemployee e2', 'o.ordererid = e2.id', 'left');
		$this->db_oriskin->join('msdepartment d', 'r.departmentid = d.id', 'left');
		$this->db_oriskin->join('mscompany c', 'r.companyid = c.id', 'left');
		$this->db_oriskin->join('mswarehouse w', 'r.warehouseid = w.id', 'left');

		$this->db_oriskin->where("o.orderdate >=", $date . ' 00:00:00');
		$this->db_oriskin->where("o.orderdate <=", $date . ' 23:59:59');

		$this->db_oriskin->group_start()
			->where("r.createdby", $userid)
			->or_where("r.updatedby", $userid)
			->group_end();

		$this->db_oriskin->order_by('o.id', 'DESC');
		$query = $this->db_oriskin->get();
		log_message('error', 'Query Purchase Order by Date: ' . $this->db_oriskin->last_query());

		return $query->result_array();
	}

	public function get_all_delivery_order_by_date($date = null, $company = null, $userid = null)
	{
		// Select kolom-kolom yang dibutuhkan
		$this->db_oriskin->select('
			do.*,
			o.id AS po_id,
			o.ordererid,
			o.orderdate,
			r.id AS request_id,
			r.requestnumber,
			r.requestdate,
			r.companyid,
			o.status AS order_status,
			r.notes AS request_notes,
			r.description AS request_description,
			o.order_number,
			e.name AS requester_name,
			e2.name AS orderer_name,
			d.name AS department_name,
			c.companyname AS company_name,
			w.warehouse_name AS warehouse_name
		');

		// Tabel utama
		$this->db_oriskin->from('delivery_orders do');

		// Join tabel terkait
		$this->db_oriskin->join('purchase_order o', 'do.purchaseorderid = o.id', 'left');
		$this->db_oriskin->join('purchase_request r', 'o.purchaserequestid = r.id', 'left');
		$this->db_oriskin->join('msemployee e', 'r.requesterid = e.id', 'left');
		$this->db_oriskin->join('msemployee e2', 'o.ordererid = e2.id', 'left');
		$this->db_oriskin->join('msdepartment d', 'r.departmentid = d.id', 'left');
		$this->db_oriskin->join('mscompany c', 'r.companyid = c.id', 'left');
		$this->db_oriskin->join('mswarehouse w', 'r.warehouseid = w.id', 'left');

		// Filter berdasarkan tanggal order (SQL Server)
		if ($date) {
			$this->db_oriskin->where("do.createdat >=", $date . ' 00:00:00');
			$this->db_oriskin->where("do.createdat <=", $date . ' 23:59:59');
		}

		if ($company) {
			$this->db_oriskin->where("r.companyid", $company);
		}
		if (!in_array($userid, [67, 68, 69, 17, 71, 23, 29])) {
			$this->db_oriskin->where("o.ordererid", $userid);
		}

		// Urutkan dari yang terbaru
		$this->db_oriskin->order_by('do.id', 'DESC');

		// Jalankan query
		$query = $this->db_oriskin->get();

		// Log query untuk debug
		log_message('error', 'Query Delivery Order by Date: ' . $this->db_oriskin->last_query());

		// Kembalikan hasil sebagai array
		return $query->result_array();
	}

	public function get_all_delivery_order_by_date_user($date, $userid)
	{
		// Select kolom-kolom yang dibutuhkan
		$this->db_oriskin->select('
			do.*,
			o.id AS po_id,
			o.ordererid,
			o.orderdate,
			r.id AS request_id,
			r.requestnumber,
			r.requestdate,
			o.status AS order_status,
			r.notes AS request_notes,
			r.description AS request_description,
			o.order_number,
			e.name AS requester_name,
			e2.name AS orderer_name,
			d.name AS department_name,
			c.companyname AS company_name,
			w.warehouse_name AS warehouse_name
		');

		// Tabel utama
		$this->db_oriskin->from('delivery_orders do');

		// Join tabel terkait
		$this->db_oriskin->join('purchase_order o', 'do.purchaseorderid = o.id', 'left');
		$this->db_oriskin->join('purchase_request r', 'o.purchaserequestid = r.id', 'left');
		$this->db_oriskin->join('msemployee e', 'r.requesterid = e.id', 'left');
		$this->db_oriskin->join('msemployee e2', 'o.ordererid = e2.id', 'left');
		$this->db_oriskin->join('msdepartment d', 'r.departmentid = d.id', 'left');
		$this->db_oriskin->join('mscompany c', 'r.companyid = c.id', 'left');
		$this->db_oriskin->join('mswarehouse w', 'r.warehouseid = w.id', 'left');

		// Filter berdasarkan tanggal order (SQL Server)
		$this->db_oriskin->where("do.createdat >=", $date . ' 00:00:00');
		$this->db_oriskin->where("do.createdat <=", $date . ' 23:59:59');
		$this->db_oriskin->where("o.ordererid", $userid);

		// Urutkan dari yang terbaru
		$this->db_oriskin->order_by('do.id', 'DESC');

		// Jalankan query
		$query = $this->db_oriskin->get();

		// Log query untuk debug
		log_message('error', 'Query Delivery Order by Date: ' . $this->db_oriskin->last_query());

		// Kembalikan hasil sebagai array
		return $query->result_array();
	}



	public function updatePurchaseRequest($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$result = $this->db_oriskin->update('purchase_request', $data);

		if ($result) {
			// query berhasil dijalankan (meskipun tidak ada row yang berubah)
			return true;
		} else {
			// query gagal (misal ada error SQL)
			return false;
		}
	}

	public function insertPurchaseRequest($data)
	{
		$this->db_oriskin->insert('purchase_request', $data);
		return $this->db_oriskin->insert_id();
	}

	public function insertPurchaseRequestItem($itemData)
	{
		$this->db_oriskin->insert('purchase_request_items', $itemData);
		return $this->db_oriskin->insert_id();
	}

	public function updatePurchaseRequestItem($pri_id, $itemData)
	{
		$this->db_oriskin->where('id', $pri_id);
		$update = $this->db_oriskin->update('purchase_request_items', $itemData);

		return $update;
	}

	public function deletePurchaseRequestItems($requestId)
	{
		$this->db_oriskin->where('purchase_request_id', $requestId);
		$result = $this->db_oriskin->delete('purchase_request_items');

		return true;
	}


	public function generateRequestNumber()
	{
		$prefix = "PR-GB-" . date('mY');
		$query = $this->db_oriskin
			->like('requestnumber', $prefix)
			->order_by('id', 'DESC')
			->get('purchase_request');

		if ($query->num_rows() > 0) {
			$last = $query->row();
			$lastNumber = intval(substr($last->requestnumber, -3));
			$next = str_pad($lastNumber + 1, 3, "0", STR_PAD_LEFT);
		} else {
			$next = "001";
		}

		return $prefix . "-" . $next;
	}

	public function get_all_unit_ingredient($keyword = null)
	{
		$this->db_oriskin->select('id, name');
		$this->db_oriskin->from('msunitingredients');
		$this->db_oriskin->where('isactive', 1);
		if (!empty($keyword)) {
			$this->db_oriskin->like('name', $keyword);
		}
		return $this->db_oriskin->get()->result();
	}

	public function get_sales_supplier($id)
	{
		$this->db_oriskin->select('
			s.id,
			s.name AS supplier_name,
			s.isactive AS supplier_isactive,
			s.email AS supplier_email,
			s.address AS supplier_address,
			s.suppliercode,
			ss.nama AS sales_name,
			ss.phonenumber AS sales_phone,
			ss.address AS sales_address,
			ss.email AS sales_email,
			ss.isactive AS sales_isactive,
		');
		$this->db_oriskin->from('suppliersales ss');
		$this->db_oriskin->join('mssupplier s', 'ss.supplierid = s.id', 'left');
		$this->db_oriskin->where('s.id', $id);
		// $this->db_oriskin->row_array();
		return $this->db_oriskin->get()->result();
	}

	// public function get_alternative_unit($id) 
	// {
	// 	// === [PERUBAHAN 1] Ambil dulu alternative unit dari tabel alternativeunitingredient ===
	// 	$this->db_oriskin->select('
	// 		aui.id AS alternative_id,
	// 		i.id AS ingredient_id,
	// 		ui.id AS unit_id,
	// 		ui.name AS unit_name,
	// 		i.unitprice
	// 	');
	// 	$this->db_oriskin->from('alternativeunitingredient aui');
	// 	$this->db_oriskin->join('msingredients i', 'aui.ingredientid = i.id', 'left');
	// 	$this->db_oriskin->join('msunitingredients ui', 'aui.unitid = ui.id', 'left');
	// 	$this->db_oriskin->where('aui.ingredientid', $id);

	// 	$result = $this->db_oriskin->get()->result_array();

	// 	if (!empty($result)) {
	// 		return $result; 
	// 	}

	// 	$this->db_oriskin->select('
	// 		NULL AS alternative_id,  
	// 		i.id AS ingredient_id,
	// 		ui.id AS unit_id,
	// 		ui.name AS unit_name,
	// 		i.unitprice
	// 	');
	// 	$this->db_oriskin->from('msingredients i');
	// 	$this->db_oriskin->join('msunitingredients ui', 'ui.id = i.unitid', 'left');
	// 	$this->db_oriskin->where('i.id', $id);

	// 	$default = $this->db_oriskin->get()->row_array();

	// 	return $default ? [$default] : [];
	// }

	public function get_alternative_unit($id)
	{
		$this->db_oriskin->select('
        aui.id AS alternative_id,
        i.id AS ingredient_id,
        ui.id AS unit_id,
        ui.name AS unit_name,
        i.unitprice,
        aui.quantity,
        aui.amount,
        aui.description
    ');
		$this->db_oriskin->from('alternativeunitingredient aui');
		$this->db_oriskin->join('msingredients i', 'aui.ingredientid = i.id', 'left');
		$this->db_oriskin->join('msunitingredients ui', 'aui.unitid = ui.id', 'left');
		$this->db_oriskin->where('aui.ingredientid', $id);

		$result = $this->db_oriskin->get()->result_array();

		if (!empty($result)) {
			echo json_encode($result);
			return;
		}

		// Kalau tidak ada alternative, ambil default dari msingredients
		$this->db_oriskin->select('
        NULL AS alternative_id,  
        i.id AS ingredient_id,
        ui.id AS unit_id,
        ui.name AS unit_name,
        i.unitprice,
        1 as quantity,
        i.unitprice as amount,
        "" as description
    ');
		$this->db_oriskin->from('msingredients i');
		$this->db_oriskin->join('msunitingredients ui', 'ui.id = i.unitid', 'left');
		$this->db_oriskin->where('i.id', $id);

		$default = $this->db_oriskin->get()->row_array();

		echo json_encode($default ? [$default] : []);
	}



	public function get_all_sales_supplier($id)
	{
		$this->db_oriskin->select('
			s.id AS supplier_id,
			s.name AS supplier_name,
			ss.nama AS sales_name,
			ss.phonenumber AS sales_phone,
			ss.address AS sales_address,
			ss.email AS sales_email,
			ss.isactive AS sales_isactive,
		');
		$this->db_oriskin->from('suppliersales ss');
		$this->db_oriskin->join('mssupplier s', 'ss.supplierid = s.id', 'left');
		$this->db_oriskin->where('s.id', $id);
		// $this->db_oriskin->row_array();
		return $this->db_oriskin->get()->result();
	}


	public function get_purchase_request_by_id($id)
	{
		$this->db_oriskin->select('
			r.id,
			r.requestnumber,
			r.purchasing_notes,
			r.requesterid,
			r.requestdate,
			r.companyid,
			r.warehouseid,
			r.status,
			r.isactive,
			r.notes,
			r.description,
			e.name AS requester_name,
			e.cellphonenumber AS requester_phone,
			d.name AS department_name,
			c.companyname AS company_name,
			c.companycode AS company_code,
			w.warehouse_name AS warehouse_name
		');
		$this->db_oriskin->from('purchase_request r');
		$this->db_oriskin->join('msemployee e', 'r.requesterid = e.id', 'left');
		$this->db_oriskin->join('msdepartment d', 'r.departmentid = d.id', 'left');
		$this->db_oriskin->join('mscompany c', 'r.companyid = c.id', 'left');
		$this->db_oriskin->join('mswarehouse w', 'r.warehouseid = w.id', 'left');
		$this->db_oriskin->where('r.id', $id);
		$purchase_request = $this->db_oriskin->get()->row_array();

		// Ambil purchase_request_items terkait
		$this->db_oriskin->select('
			pri.id AS pri_id,
			pri.quantity AS qty,
			pri.itemid,
			mi.id AS ingredient_id,
			mi.name AS itemname,
			mi.code AS item_code,
			mi.price AS item_price,
			mi.qtypersatuan,
			mi.unitprice AS item_unit_price,
			pri.description,
			pri.status,
			ui.name AS unit_name,
			pri.alternativeunitid,
			ui2.name AS alternativeunitname,
			aui.qtytouom,
		');
		$this->db_oriskin->from('purchase_request_items pri');
		$this->db_oriskin->join('msingredients mi', 'pri.itemid = mi.id', 'left');
		$this->db_oriskin->join('msunitingredients ui', 'mi.unitid = ui.id', 'left');
		$this->db_oriskin->join('alternativeunitingredient aui', 'pri.alternativeunitid = aui.id', 'left');
		$this->db_oriskin->join('msunitingredients ui2', 'aui.unitid = ui2.id', 'left');
		$this->db_oriskin->where('pri.purchase_request_id', $id);
		$items = $this->db_oriskin->get()->result_array();

		$this->db_oriskin->select('
			e.name AS employee_name,
		');
		$this->db_oriskin->from('purchase_request r');
		$this->db_oriskin->join('mscompany c', 'r.companyid = c.id', 'left');
		$this->db_oriskin->join('msemployee e', 'r.requesterid = e.id', 'left');
		$this->db_oriskin->join('msemployeedetail ed', 'e.id = ed.employeeid', 'left');
		$this->db_oriskin->join('mslocation l', 'l.id = ed.locationid', 'left');
		$this->db_oriskin->where('r.id', $id);
		$this->db_oriskin->where('ed.jobid', 21);
		$this->db_oriskin->where('e.isactive', 1);

		$om_name = $this->db_oriskin->get()->row_array();

		foreach ($items as &$item) {
			$this->db_oriskin->select('
				pii.id,
				pii.image_path
			');
			$this->db_oriskin->from('purchase_request_item_images pii');
			$this->db_oriskin->where('pii.purchase_request_item_id', $item['pri_id']);
			$images = $this->db_oriskin->get()->result_array();

			$item['images'] = $images ?: [];
		}

		// Gabungkan items ke dalam purchase_request
		$purchase_request['items'] = $items;
		$purchase_request['om_name'] = $om_name;

		return $purchase_request;
	}

	public function get_purchase_order_by_id($id)
	{
		$this->db_oriskin->select('
			o.id AS po_id,
			o.orderdate,
			o.order_number,
			o.updatedat,
			o.createdat,
			o.createdby,
			o.updatedby,
			o.ordererid,
			o.purchaserequestid,
			o.bk_attachment,
			o.status_pembayaran,
			o.bukti_transfer,
			o.vendor_invoice,
			o.ongkir,
			o.other_cost,
			o.status,
			o.supplierid,
			o.notes,
			r.id AS pr_id,
			r.companyid,
			r.warehouseid,
			r.requestnumber,
			c.companyname,
			c.companycode,
			l.address AS company_address,
			c.postalcode AS company_postalcode,
			l.mobilephone AS company_phone,
			s.bank_name AS supplier_bank,
			s.account AS supplier_account,
			s.phone AS supplier_phone,
			s.name AS supplier_name,
			s.address AS supplier_address,
			s.zipcode AS supplier_zipcode,
			s.phone AS supplier_phone,
			e.name AS orderer_name,
			e2.name AS requester_name,
			cy.name AS city_name,
			p.name AS province_name,
			w.warehouse_name,
			l.name AS location_name,
			e3.name AS om_name,
			ev.ecommerce_name,
			ev.va_number
		');
		$this->db_oriskin->from('purchase_order o');
		$this->db_oriskin->join('purchase_request r', 'r.id = o.purchaserequestid', 'left');
		$this->db_oriskin->join('mscompany c', 'c.id = r.companyid', 'left');
		$this->db_oriskin->join('mscity cy', 'cy.id = c.cityid', 'left');
		$this->db_oriskin->join('msprovince p', 'p.id = c.provinceid', 'left');
		$this->db_oriskin->join('msemployee e', 'e.id = o.ordererid', 'left');
		$this->db_oriskin->join('msemployee e2', 'e2.id = r.requesterid', 'left');
		$this->db_oriskin->join('mswarehouse w', 'w.id = r.warehouseid', 'left');
		// $this->db_oriskin->join('suppliersales ss', 'ss.id = o.supplierid', 'left');
		$this->db_oriskin->join('mssupplier s', 's.id = o.supplierid', 'left');
		$this->db_oriskin->join('mslocation l', 'l.companyid = c.id', 'left');
		$this->db_oriskin->join('msemployeedetail ed', 'l.id = ed.locationid', 'left');
		$this->db_oriskin->join('msemployee e3', 'e3.id = ed.employeeid', 'left');
		$this->db_oriskin->join('ecommerce_virtual_account ev', 'ev.purchaseorderid = o.id', 'left');
		$this->db_oriskin->where('o.id', $id);

		$purchase_order = $this->db_oriskin->get()->row_array();

		if (!$purchase_order) {
			return null;
		}

		// Ambil items terkait
		$this->db_oriskin->select('
			poi.id AS poi_id,
			pri.id AS pri_id,
			pri.quantity AS qty,
			pri.itemid,
			poi.fixed_price,
			poi.total_price,
			poi.discount_type,
			poi.discount_value,
			mi.id AS ingredient_id,
			mi.name AS itemname,
			mi.code AS item_code,
			mi.price AS item_price,
			mi.qtypersatuan,
			mi.unitprice AS item_unit_price,
			mui.name AS unit_name,
			poi.description,
			pri.alternativeunitid,
			ui2.name AS alternativeunitname,
			aui.qtytouom,
		');
		$this->db_oriskin->from('purchase_order_items poi');
		$this->db_oriskin->join('purchase_request_items pri', 'pri.id = poi.purchaserequestitemid', 'left');
		$this->db_oriskin->join('msingredients mi', 'pri.itemid = mi.id', 'left');
		$this->db_oriskin->join('msunitingredients mui', 'mi.unitid = mui.id', 'left');
		$this->db_oriskin->join('alternativeunitingredient aui', 'pri.alternativeunitid = aui.id', 'left');
		$this->db_oriskin->join('msunitingredients ui2', 'aui.unitid = ui2.id', 'left');
		$this->db_oriskin->where('poi.purchaseorderid', $id);
		$items = $this->db_oriskin->get()->result_array();

		$purchase_order['items'] = $items;

		$this->db_oriskin->select('
			jml_keluar,
			created_at,
			created_by,
			jenis_bk,
			file_path,
		');
		$this->db_oriskin->from('bukti_pengeluaran_kas');
		$this->db_oriskin->where('purchaseorderid', $id);
		$bk = $this->db_oriskin->get()->result_array();

		$purchase_order['bk'] = $bk;

		return $purchase_order;
	}

	public function get_delivery_order_by_id($id)
	{
		$this->db_oriskin->select('
			do.id,
			do.status,
			do.delivery_number,
			do.delivery_date,
			do.delivery_time,
			o.id AS po_id,
			o.orderdate,
			o.order_number,
			o.purchaserequestid,
			o.bk_attachment,
			o.vendor_invoice,
			o.status AS order_status,
			r.id AS pr_id,
			r.companyid,
			r.warehouseid,
			r.requestnumber,
			c.companyname,
			c.address AS company_address,
			c.postalcode AS company_postalcode,
			c.phone AS company_phone,
			s.phone AS supplier_phone,
			s.name AS supplier_name,
			s.address AS supplier_address,
			s.zipcode AS supplier_zipcode,
			s.phone AS supplier_phone,
			ss.nama AS sales_name,
			ss.address AS sales_address,
			ss.email AS sales_email,
			ss.phonenumber AS sales_phone,
			e.name AS orderer_name,
			e2.name AS requester_name,
			cy.name AS city_name,
			p.name AS province_name,
			w.warehouse_name,
			l.name AS location_name,
			e3.name AS om_name,
		');
		$this->db_oriskin->from('delivery_orders do');
		$this->db_oriskin->join('purchase_order o', 'o.id = do.purchaseorderid', 'left');
		$this->db_oriskin->join('purchase_request r', 'r.id = o.purchaserequestid', 'left');
		$this->db_oriskin->join('mscompany c', 'c.id = r.companyid', 'left');
		$this->db_oriskin->join('mscity cy', 'cy.id = c.cityid', 'left');
		$this->db_oriskin->join('msprovince p', 'p.id = c.provinceid', 'left');
		$this->db_oriskin->join('msemployee e', 'e.id = o.ordererid', 'left');
		$this->db_oriskin->join('msemployee e2', 'e2.id = r.requesterid', 'left');
		$this->db_oriskin->join('mswarehouse w', 'w.id = r.warehouseid', 'left');
		$this->db_oriskin->join('suppliersales ss', 'ss.id = o.supplierid', 'left');
		$this->db_oriskin->join('mssupplier s', 's.id = ss.supplierid', 'left');
		$this->db_oriskin->join('mslocation l', 'l.companyid = c.id', 'left');
		$this->db_oriskin->join('msemployeedetail ed', 'l.id = ed.locationid', 'left');
		$this->db_oriskin->join('msemployee e3', 'e3.id = ed.employeeid', 'left');
		$this->db_oriskin->where('do.id', $id);

		$purchase_order = $this->db_oriskin->get()->row_array();

		if (!$purchase_order) {
			return null;
		}

		// Ambil items terkait
		$this->db_oriskin->select('
			doi.id,
			doi.status,
			doi.photo,
			poi.id AS poi_id,
			pri.id AS pri_id,
			pri.quantity AS qty,
			pri.itemid,
			poi.fixed_price,
			poi.total_price,
			mi.id AS ingredient_id,
			mi.name AS itemname,
			mi.code AS item_code,
			mi.price AS item_price,
			mi.qtypersatuan,
			mi.unitprice AS item_unit_price,
			mui.name AS unit_name,
			pri.description,
			pri.alternativeunitid,
			ui2.name AS alternativeunitname,
			aui.qtytouom,
		');
		$this->db_oriskin->from('delivery_order_items doi');
		$this->db_oriskin->join('purchase_order_items poi', 'poi.id = doi.purchaseorderitemid', 'left');
		$this->db_oriskin->join('purchase_request_items pri', 'pri.id = poi.purchaserequestitemid', 'left');
		$this->db_oriskin->join('msingredients mi', 'pri.itemid = mi.id', 'left');
		$this->db_oriskin->join('msunitingredients mui', 'mi.unitid = mui.id', 'left');
		$this->db_oriskin->join('alternativeunitingredient aui', 'pri.alternativeunitid = aui.id', 'left');
		$this->db_oriskin->join('msunitingredients ui2', 'aui.unitid = ui2.id', 'left');
		$this->db_oriskin->where('doi.deliveryorderid', $id);
		$items = $this->db_oriskin->get()->result_array();

		$purchase_order['items'] = $items;

		return $purchase_order;
	}

	public function get_delivery_order_by_poid($id)
	{
		$this->db_oriskin->select('
			do.id,
			do.status,
			do.delivery_number,
			do.delivery_date,
			do.delivery_time,
			do.purchaseorderid,
			o.id AS po_id,
			o.orderdate,
			o.order_number,
			o.purchaserequestid,
			o.bk_attachment,
			o.vendor_invoice,
			o.status AS order_status,
			r.id AS pr_id,
			r.companyid,
			r.warehouseid,
			r.requestnumber,
			c.companyname,
			c.address AS company_address,
			c.postalcode AS company_postalcode,
			c.phone AS company_phone,
			s.phone AS supplier_phone,
			s.name AS supplier_name,
			s.address AS supplier_address,
			s.zipcode AS supplier_zipcode,
			s.phone AS supplier_phone,
			ss.nama AS sales_name,
			ss.address AS sales_address,
			ss.email AS sales_email,
			ss.phonenumber AS sales_phone,
			e.name AS orderer_name,
			e2.name AS requester_name,
			cy.name AS city_name,
			p.name AS province_name,
			w.warehouse_name,
			l.name AS location_name,
			e3.name AS om_name,
		');
		$this->db_oriskin->from('delivery_orders do');
		$this->db_oriskin->join('purchase_order o', 'o.id = do.purchaseorderid', 'left');
		$this->db_oriskin->join('purchase_request r', 'r.id = o.purchaserequestid', 'left');
		$this->db_oriskin->join('mscompany c', 'c.id = r.companyid', 'left');
		$this->db_oriskin->join('mscity cy', 'cy.id = c.cityid', 'left');
		$this->db_oriskin->join('msprovince p', 'p.id = c.provinceid', 'left');
		$this->db_oriskin->join('msemployee e', 'e.id = o.ordererid', 'left');
		$this->db_oriskin->join('msemployee e2', 'e2.id = r.requesterid', 'left');
		$this->db_oriskin->join('mswarehouse w', 'w.id = r.warehouseid', 'left');
		$this->db_oriskin->join('suppliersales ss', 'ss.id = o.supplierid', 'left');
		$this->db_oriskin->join('mssupplier s', 's.id = ss.supplierid', 'left');
		$this->db_oriskin->join('mslocation l', 'l.companyid = c.id', 'left');
		$this->db_oriskin->join('msemployeedetail ed', 'l.id = ed.locationid', 'left');
		$this->db_oriskin->join('msemployee e3', 'e3.id = ed.employeeid', 'left');
		$this->db_oriskin->where('do.purchaseorderid', $id);

		$purchase_order = $this->db_oriskin->get()->row_array();

		if (!$purchase_order) {
			return null;
		}

		// Ambil items terkait
		$this->db_oriskin->select('
			doi.id,
			doi.status,
			poi.id AS poi_id,
			pri.id AS pri_id,
			pri.quantity AS qty,
			pri.itemid,
			poi.fixed_price,
			poi.total_price,
			mi.id AS ingredient_id,
			mi.name AS itemname,
			mi.code AS item_code,
			mi.price AS item_price,
			mi.qtypersatuan,
			mi.unitprice AS item_unit_price,
			mui.name AS unit_name,
			pri.description,
			pri.alternativeunitid,
			ui2.name AS alternativeunitname,
			aui.qtytouom,
		');
		$this->db_oriskin->from('delivery_order_items doi');
		$this->db_oriskin->join('purchase_order_items poi', 'poi.id = doi.purchaseorderitemid', 'left');
		$this->db_oriskin->join('purchase_request_items pri', 'pri.id = poi.purchaserequestitemid', 'left');
		$this->db_oriskin->join('msingredients mi', 'pri.itemid = mi.id', 'left');
		$this->db_oriskin->join('msunitingredients mui', 'mi.unitid = mui.id', 'left');
		$this->db_oriskin->join('alternativeunitingredient aui', 'pri.alternativeunitid = aui.id', 'left');
		$this->db_oriskin->join('msunitingredients ui2', 'aui.unitid = ui2.id', 'left');
		$this->db_oriskin->where('doi.deliveryorderid', $purchase_order['id']);
		$items = $this->db_oriskin->get()->result_array();

		$purchase_order['items'] = $items;

		return $purchase_order;
	}


	public function get_do_purchase_order_by_id($id)
	{
		$this->db_oriskin->select('
			do.id AS do_id,
			o.id AS po_id,
			o.orderdate,
			o.order_number,
			o.purchaserequestid,
			o.bk_attachment,
			o.vendor_invoice,
			o.status,
			r.id AS pr_id,
			r.companyid,
			r.warehouseid,
			r.requestnumber,
			c.companyname,
			c.address AS company_address,
			c.postalcode AS company_postalcode,
			c.phone AS company_phone,
			s.phone AS supplier_phone,
			s.name AS supplier_name,
			s.address AS supplier_address,
			s.zipcode AS supplier_zipcode,
			s.phone AS supplier_phone,
			ss.nama AS sales_name,
			ss.address AS sales_address,
			ss.email AS sales_email,
			ss.phonenumber AS sales_phone,
			e.name AS orderer_name,
			e2.name AS requester_name,
			cy.name AS city_name,
			p.name AS province_name,
			w.warehouse_name,
			l.name AS location_name,
			e3.name AS om_name,
		');
		$this->db_oriskin->from('delivery_orders do');
		$this->db_oriskin->join('purchase_order o', 'o.id = o.purchaseorderid', 'left');
		$this->db_oriskin->join('purchase_request r', 'r.id = o.purchaserequestid', 'left');
		$this->db_oriskin->join('mscompany c', 'c.id = r.companyid', 'left');
		$this->db_oriskin->join('mscity cy', 'cy.id = c.cityid', 'left');
		$this->db_oriskin->join('msprovince p', 'p.id = c.provinceid', 'left');
		$this->db_oriskin->join('msemployee e', 'e.id = o.ordererid', 'left');
		$this->db_oriskin->join('msemployee e2', 'e2.id = r.requesterid', 'left');
		$this->db_oriskin->join('mswarehouse w', 'w.id = r.warehouseid', 'left');
		$this->db_oriskin->join('suppliersales ss', 'ss.id = o.supplierid', 'left');
		$this->db_oriskin->join('mssupplier s', 's.id = ss.supplierid', 'left');
		$this->db_oriskin->join('mslocation l', 'l.companyid = c.id', 'left');
		$this->db_oriskin->join('msemployeedetail ed', 'l.id = ed.locationid', 'left');
		$this->db_oriskin->join('msemployee e3', 'e3.id = ed.employeeid', 'left');
		$this->db_oriskin->where('delivery_orders.id', $id);

		$purchase_order = $this->db_oriskin->get()->row_array();

		if (!$purchase_order) {
			return null;
		}

		// Ambil items terkait
		$this->db_oriskin->select('
			doi.id AS doi_id,
			doi.notes AS doi_notes,
			poi.id AS poi_id,
			pri.id AS pri_id,
			pri.quantity AS qty,
			pri.itemid,
			poi.fixed_price,
			poi.total_price,
			mi.id AS ingredient_id,
			mi.name AS itemname,
			mi.code AS item_code,
			mi.price AS item_price,
			mi.qtypersatuan,
			mi.unitprice AS item_unit_price,
			mui.name AS unit_name,
			pri.description,
			pri.alternativeunitid,
			ui2.name AS alternativeunitname,
			aui.qtytouom,
		');
		$this->db_oriskin->from('delivery_order_items doi');
		$this->db_oriskin->join('purchase_order_items poi', 'poi.id = doi.purchaseorderitemid', 'left');
		$this->db_oriskin->join('purchase_request_items pri', 'pri.id = poi.purchaserequestitemid', 'left');
		$this->db_oriskin->join('msingredients mi', 'pri.itemid = mi.id', 'left');
		$this->db_oriskin->join('msunitingredients mui', 'mi.unitid = mui.id', 'left');
		$this->db_oriskin->join('alternativeunitingredient aui', 'pri.alternativeunitid = aui.id', 'left');
		$this->db_oriskin->join('msunitingredients ui2', 'aui.unitid = ui2.id', 'left');
		$this->db_oriskin->where('doi.deliveryorderid', $id);
		$items = $this->db_oriskin->get()->result_array();

		$purchase_order['items'] = $items;

		return $purchase_order;
	}


	public function add_purchase_order_by_request($id)
	{
		$this->db_oriskin->select('
			r.id,
			r.requestnumber,
			r.requesterid,
			r.requestdate,
			r.companyid,
			r.warehouseid,
			r.status,
			r.notes,
			r.description,
			e.name AS requester_name,
			e.cellphonenumber AS requester_phone,
			d.name AS department_name,
			c.companyname AS company_name,
			c.companycode AS company_code,
			w.warehouse_name AS warehouse_name
		');
		$this->db_oriskin->from('purchase_request r');
		$this->db_oriskin->join('msemployee e', 'r.requesterid = e.id', 'left');
		$this->db_oriskin->join('msdepartment d', 'r.departmentid = d.id', 'left');
		$this->db_oriskin->join('mscompany c', 'r.companyid = c.id', 'left');
		$this->db_oriskin->join('mswarehouse w', 'r.warehouseid = w.id', 'left');
		$this->db_oriskin->where('r.id', $id);
		$purchase_request = $this->db_oriskin->get()->row_array();

		// Ambil purchase_request_items terkait
		$this->db_oriskin->select('
			pri.id AS pri_id,
			pri.quantity AS qty,
			pri.itemid,
			mi.id AS ingredient_id,
			mi.name AS itemname,
			mi.code AS item_code,
			mi.price AS item_price,
			mi.unitprice AS item_unit_price,
			pri.description
		');
		$this->db_oriskin->from('purchase_request_items pri');
		$this->db_oriskin->join('msingredients mi', 'pri.itemid = mi.id', 'left');
		$this->db_oriskin->where('pri.purchase_request_id', $id);
		$items = $this->db_oriskin->get()->result_array();

		// Gabungkan items ke dalam purchase_request
		$purchase_request['items'] = $items;

		return $purchase_request;
	}

	public function update_status_purchase_order($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		return $this->db->update('purchase_order', $data);
	}

	public function getAll()
	{
		return $this->db->get($this->table)->result_array();
	}

	public function getEmployees($search = null, $level = null, $locationid = null)
	{
		$this->db_oriskin->select('e.id, e.name as text');
		$this->db_oriskin->from('msemployee e');

		if ($level == 1 && !empty($locationid)) {
			$this->db_oriskin->join('msemployeedetail ed', 'ed.employeeid = e.id', 'left');
			$this->db_oriskin->where('ed.locationid', $locationid);
		}

		if (!empty($search)) {
			$this->db_oriskin->like('e.name', $search);
		}

		$this->db_oriskin->order_by('e.name', 'ASC');
		return $this->db_oriskin->get()->result();
	}

	public function getPurchaseOrderWithDelivery($purchaseOrderId)
	{
		$this->db_oriskin->select('o.id as purchaseorderid, o.ordernumber, o.orderdate, 
                                   r.requestnumber, r.requestdate, 
                                   o.description, o.notes, 
                                   d.id as deliveryorderid, d.status as delivery_status, d.notes as delivery_notes');
		$this->db_oriskin->from('purchase_order o');
		$this->db_oriskin->join('purchase_request r', 'r.id = o.purchaserequestid', 'left');
		$this->db_oriskin->join('delivery_orders d', 'd.purchaseorderid = o.id', 'left');
		$this->db_oriskin->where('o.id', $purchaseOrderId);
		return $this->db_oriskin->get()->row_array();
	}

	// ✅ Get Purchase Order Items + Delivery Items
	public function getPurchaseOrderItemsWithDelivery($purchaseOrderId)
	{
		$this->db_oriskin->select('i.id as purchaseorderitemid, i.item_name, i.qty, i.unit_price, 
                                   (i.qty * i.unit_price) as total_price,
                                   di.id as deliveryorderitemid, di.status as deliveryitem_status, di.notes as deliveryitem_notes');
		$this->db_oriskin->from('purchase_order_items i');
		$this->db_oriskin->join('delivery_order_items di', 'di.purchaseorderitemid = i.id', 'left');
		$this->db_oriskin->where('i.purchaseorderid', $purchaseOrderId);
		return $this->db_oriskin->get()->result_array();
	}

	// ✅ Update Notes Delivery Order
	public function updateDeliveryOrderNotes($deliveryOrderId, $notes)
	{
		$this->db_oriskin->where('id', $deliveryOrderId);
		return $this->db_oriskin->update('delivery_orders', ['notes' => $notes]);
	}

	// ✅ Update Status Delivery Order Item
	public function updateDeliveryOrderItemStatus($itemId, $status, $notes = null)
	{
		$data = ['status' => $status];
		if ($notes !== null) {
			$data['notes'] = $notes;
		}
		$this->db_oriskin->where('id', $itemId);
		return $this->db_oriskin->update('delivery_order_items', $data);
	}

	// ✅ Check apakah semua item sudah status = 1
	public function checkAllDeliveryItemsDone($deliveryOrderId)
	{
		$this->db_oriskin->from('delivery_order_items');
		$this->db_oriskin->where('deliveryorderid', $deliveryOrderId);
		$this->db_oriskin->where('status', 0);
		$count = $this->db_oriskin->count_all_results();
		return $count == 0; // semua sudah status 1
	}

	// ✅ Update status Delivery Order
	public function updateDeliveryOrderStatus($deliveryOrderId, $status)
	{
		$this->db_oriskin->where('id', $deliveryOrderId);
		return $this->db_oriskin->update('delivery_orders', ['status' => $status]);
	}



	public function getPurchaseOrderItem($poi_id)
	{
		$db = $this->load->database('oriskin', true);
		$sql = "
        SELECT 
            poi.id AS poi_id,
            poi.purchaseorderid,
            poi.fixed_price,
            poi.discount_type,
            poi.discount_value,
            poi.discount_amount,
            poi.total_price,
            poi.description,
            ing.code as item_code,
            ing.name AS itemname,
			CASE 
				WHEN ai.id IS NOT NULL THEN pri.quantity * ai.qtytouom
				ELSE pri.quantity
			END AS quantity
        FROM purchase_order_items poi
		INNER JOIN purchase_request_items pri ON poi.purchaserequestitemid = pri.id
        LEFT JOIN msingredients ing ON pri.itemid = ing.id
		LEFT JOIN alternativeunitingredient ai ON pri.alternativeunitid = ai.id
        WHERE poi.id = ?
    ";
		$query = $db->query($sql, [$poi_id]);
		return $query->row_array();
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


	public function approvePurchaseOrderTempoDo($id)
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
			return false;
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
			return false;
		}

		$db_oriskin->trans_commit();
		return true;
	}



}
