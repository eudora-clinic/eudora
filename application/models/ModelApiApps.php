<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelApiApps extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db_oriskin = $this->load->database('oriskin', true);
	}

	public function getListEmployeeApps()
	{
		$query = "SELECT a.*, b.name as locationname, c.name as jobname, d.name as employeename FROM msemployeeApps a
        INNER JOIN mslocation b ON a.locationid = b.id
        INNER JOIN msjob c ON a.jobid = c.id
        INNER JOIN msemployee d ON a.employeeid = d.id";
		return $this->db_oriskin->query($query)->result_array();
	}


	public function getListTreatmentClaimFree()
	{
		$query = "SELECT a.*, b.name as treatmentname, b.description as description FROM mstreatmentclaimfree a
        INNER JOIN mstreatment b ON a.treatmentid = b.id";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getListOutletAccess()
	{
		$query = "SELECT a.id, a.userid, a.locationid, a.username as name, b.image FROM msoutlet_access_user a INNER JOIN mslocation b
					ON a.locationid = b.id";
		return $this->db_oriskin->query($query)->result_array();
	}


	public function getListTreatmentClaimFreeActive($customerId = null)
	{
		$sql = "
        SELECT a.*, b.apps_name AS treatmentname, b.description AS description
        FROM mstreatmentclaimfree a
        INNER JOIN mstreatment b ON a.treatmentid = b.id
    ";

		if (!empty($customerId)) {
			$sub = $this->db_oriskin->query("
            SELECT g.refferalempid
            FROM mscustomer c
            INNER JOIN slguestlog g ON c.guestlogid = g.id
            WHERE c.id = ?
        ", [$customerId])->row();

			$restricted = [1874, 1875, 1876, 1877, 1878];
			if (!empty($sub) && in_array($sub->refferalempid, $restricted)) {
				$sql .= " WHERE a.id IN (4, 15)";
			} else {
				$sql .= " WHERE a.id NOT IN (14, 15)";
			}
		}

		return $this->db_oriskin->query($sql)->result_array();
	}


	public function getEmployeeAppsById($id)
	{
		$query = "SELECT a.*, b.name as locationname, c.name as jobname, d.name as employeename FROM msemployeeApps a
        INNER JOIN mslocation b ON a.locationid = b.id
        INNER JOIN msjob c ON a.jobid = c.id
        INNER JOIN msemployee d ON a.employeeid = d.id
        WHERE a.id = $id";
		return $this->db_oriskin->query($query)->row_array();
	}

	public function getListTreatmentClaimFreeById($id)
	{
		$query = "SELECT a.*, b.name as treatmentname FROM mstreatmentclaimfree a
        INNER JOIN mstreatment b ON a.treatmentid = b.id
        WHERE a.id = $id";
		return $this->db_oriskin->query($query)->row_array();
	}

	public function addEmployeeApps($data)
	{
		$this->db_oriskin->insert('msemployeeApps', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function addTreatmentClaimFreeApps($data)
	{
		$this->db_oriskin->insert('mstreatmentclaimfree', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function updateEmployeeApps($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('msemployeeApps', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function updateTreatmentClaimFree($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('mstreatmentclaimfree', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function getListRefferalFriend($customerId, $dateStart, $dateEnd, $filterType)
	{
		$db_oriskin = $this->load->database('oriskin', true);

		$queryWithFilterShow = "
        SELECT 
            CONVERT(varchar(10), a.visitdate, 120) AS registerdate, 
            b.name AS location,
            a.firstname + ' ' + a.lastname AS refferalname,
            a.cellphonenumber AS cellphonenumber,
            CONVERT(varchar(10), t.first_treatment_date, 120) AS first_treatment_date
        FROM 
            slguestlog a
            INNER JOIN mslocation b ON a.locationid = b.id
            INNER JOIN mscustomer c ON a.id = c.guestlogid
            OUTER APPLY (
                SELECT MIN(tr.treatmentdate) AS first_treatment_date
                FROM trdoingtreatment tr
                WHERE tr.customerid = c.id
                AND tr.status = 17
            ) t
        WHERE 
            a.refferalid = ? 
            AND (CONVERT(varchar(10), t.first_treatment_date, 120) BETWEEN ? AND ?)
        ORDER BY 
            a.visitdate DESC
    ";

		$queryWithFilterRegistration = "
        SELECT 
            CONVERT(varchar(10), a.visitdate, 120) AS registerdate, 
            b.name AS location,
            a.firstname + ' ' + a.lastname AS refferalname,
            a.cellphonenumber AS cellphonenumber,
            CONVERT(varchar(10), t.first_treatment_date, 120) AS first_treatment_date
        FROM 
            slguestlog a
            INNER JOIN mslocation b ON a.locationid = b.id
            INNER JOIN mscustomer c ON a.id = c.guestlogid
            OUTER APPLY (
                SELECT MIN(tr.treatmentdate) AS first_treatment_date
                FROM trdoingtreatment tr
                WHERE tr.customerid = c.id
                AND tr.status = 17
            ) t
        WHERE 
            a.refferalid = ? 
            AND (CONVERT(varchar(10), a.visitdate, 120) BETWEEN ? AND ?)
        ORDER BY 
            a.visitdate DESC
    ";

		$query = "
        SELECT 
            CONVERT(varchar(10), a.visitdate, 120) AS registerdate, 
            b.name AS location,
            a.firstname + ' ' + a.lastname AS refferalname,
            a.cellphonenumber AS cellphonenumber,
            CONVERT(varchar(10), t.first_treatment_date, 120) AS first_treatment_date
        FROM 
            slguestlog a
            INNER JOIN mslocation b ON a.locationid = b.id
            INNER JOIN mscustomer c ON a.id = c.guestlogid
            OUTER APPLY (
                SELECT MIN(tr.treatmentdate) AS first_treatment_date
                FROM trdoingtreatment tr
                WHERE tr.customerid = c.id
                AND tr.status = 17
            ) t
        WHERE 
            a.refferalid = ? 
        ORDER BY 
            a.visitdate DESC
    ";

		if ($dateStart && $dateEnd && $filterType == 'show') {
			$result = $db_oriskin->query($queryWithFilterShow, [$customerId, $dateStart, $dateEnd]);
		} elseif ($dateStart && $dateEnd && $filterType == 'registration') {
			$result = $db_oriskin->query($queryWithFilterRegistration, [$customerId, $dateStart, $dateEnd]);
		} else {
			$result = $db_oriskin->query($query, [$customerId]);
		}


		if (!$result) {
			$error = $db_oriskin->error();
			log_message('error', 'SQL Error in getListRefferalFriend: ' . $error['message']);
			return [];
		}

		return $result->result_array();
	}




	public function getListCategory()
	{
		$query = "SELECT * FROM mscategory";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getCategoryById($id)
	{
		$query = "SELECT * FROM mscategory WHERE id = $id";
		return $this->db_oriskin->query($query)->row_array();
	}

	public function updateCategory($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('mscategory', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function createCategory($data)
	{
		$this->db_oriskin->insert('mscategory', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function searchServices($search, $id)
	{
		if ($id == 1) {
			$this->db_oriskin->select('id, code, name');
			$this->db_oriskin->from('mstreatment');
			$this->db_oriskin->where('isactive', 1);
			$this->db_oriskin->where("(code LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
			$this->db_oriskin->order_by('code', 'ASC');

			$this->db_oriskin->limit(50);
			return $this->db_oriskin->get()->result();
		} elseif ($id == 2) {
			$this->db_oriskin->select('id, code, name');
			$this->db_oriskin->from('msproductmembershiphdr');
			$this->db_oriskin->where('isactive', 1);
			$this->db_oriskin->where("(code LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
			$this->db_oriskin->order_by('code', 'ASC');

			$this->db_oriskin->limit(50);
			return $this->db_oriskin->get()->result();
		} elseif ($id == 3) {
			$this->db_oriskin->select('id, code, name');
			$this->db_oriskin->from('msproduct');
			$this->db_oriskin->where('isactive', 1);
			$this->db_oriskin->where("(code LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
			$this->db_oriskin->order_by('code', 'ASC');

			$this->db_oriskin->limit(50);
			return $this->db_oriskin->get()->result();
		}

	}


	public function getListCategoryByProductTypeTreatment()
	{
		$query = "SELECT a.id, b.name as categoryname, c.apps_name as productname, 'TREATMENT' as type, a.isactive  FROM treatment_category a inner join mscategory b on a.categoryid = b.id inner join mstreatment c ON a.productid = c.id
					WHERE a.producttypeid = 1";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getListCategoryByProductTypePackage()
	{
		$query = "SELECT a.id, b.name as categoryname, c.apps_name as productname, 'PACKAGE' as type, a.isactive  FROM treatment_category a inner join mscategory b on a.categoryid = b.id inner join msproductmembershiphdr c ON a.productid = c.id
		WHERE a.producttypeid = 2";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getListCategoryByProductTypeRetail()
	{
		$query = "SELECT a.id, b.name as categoryname, c.apps_name as productname, 'RETAIL' as type, a.isactive  FROM treatment_category a inner join mscategory b on a.categoryid = b.id inner join msproduct c ON a.productid = c.id
		WHERE a.producttypeid = 3";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function updateStatusCategoryByType($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('treatment_category', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}


	public function getListCategoryApps($customerid)
	{
		$queryDetailCustomer = $this->db_oriskin->query("
        	EXEC [spClinicFindCustomerDashboard] ?
    	", [$customerid]);

		$customerData = $queryDetailCustomer->row_array();
		$query = "SELECT * FROM mscategory WHERE isactive = 1";

		if (isset($customerData['ISNEWCUSTOMER']) && $customerData['ISNEWCUSTOMER'] == 1) {
			$query = "SELECT * FROM mscategory WHERE isactive = 1 AND id NOT IN (10)";
		}

		return $this->db_oriskin->query($query)->result_array();
	}


	public function getListCategoryByProductTypeTreatmentApps($id)
	{
		$query = "SELECT a.id, b.name as categoryname, c.apps_name as productname, 'TREATMENT' as type, a.isactive,
					c.id as productid, c.price, a.producttypeid, c.image, c.normal_price as normal_price
					FROM treatment_category a inner join mscategory b on a.categoryid = b.id
					inner join mstreatment c ON a.productid = c.id
					WHERE a.producttypeid = 1 and a.isactive = 1 AND a.categoryid = $id";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getListCategoryByProductTypePackageApps($id)
	{
		$query = "SELECT a.id, b.name as categoryname, c.apps_name as productname, 'PACKAGE' as type, a.isactive,
					c.id as productid, d.totalprice as price, a.producttypeid, c.image, d.normal_price as normal_price
		FROM treatment_category a inner join mscategory b on a.categoryid = b.id
		inner join msproductmembershiphdr c ON a.productid = c.id
		INNER JOIN msproductmembershipdtl d ON c.id = d.id
		-- INNER JOIN msproductmembershipbenefit e ON d.productbenefitid = e.membershipbenefitid
		WHERE a.producttypeid = 2 and a.isactive = 1 AND a.categoryid = $id";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getListCategoryByProductTypeRetailApps($id)
	{
		$query = "SELECT a.id, b.name as categoryname, c.apps_name as productname, 'RETAIL' as type, a.isactive,
					c.id as productid, c.price1 as price, a.producttypeid, c.image, c.normal_price as normal_price
		FROM treatment_category a inner join mscategory b on a.categoryid = b.id
		inner join msproduct c ON a.productid = c.id
		WHERE a.producttypeid = 3 and a.isactive = 1 AND a.categoryid = $id";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getListCategoyByProductId($productid, $producttypeid)
	{
		$query = "SELECT * FROM mscategory a inner join treatment_category b ON a.id = b.categoryid WHERE a.isactive = 1 AND b.isactive = 1 AND b.productid = $productid AND b.producttypeid = $producttypeid";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getDetailTreatment($id, $producttypeid)
	{
		if ($producttypeid == 1) {
			$query = "SELECT a.apps_name as productname, a.price as price, ISNULL(a.description, '-') AS description, a.image as image, a.normal_price as normal_price
			FROM mstreatment a WHERE a.id = $id";
			return $this->db_oriskin->query($query)->row();
		} elseif ($producttypeid == 2) {
			$query = "SELECT a.apps_name as productname, b.totalprice as price, ISNULL(a.description, '-') AS description, a.image as image, b.normal_price as normal_price
			FROM msproductmembershiphdr a 
			INNER JOIN msproductmembershipdtl b ON a.id = b.id
			WHERE a.id = $id";
			return $this->db_oriskin->query($query)->row();
		} elseif ($producttypeid == 3) {
			$query = "SELECT a.apps_name as productname, a.price1 as price, ISNULL(a.description, '-') AS description, a.image as image, a.normal_price as normal_price
			FROM msproduct a WHERE a.id = $id";
			return $this->db_oriskin->query($query)->row();
		}

	}

	public function checkIsClaimTreatment($customer_id)
	{
		$this->db_oriskin->from('usersApps');
		$this->db_oriskin->where('customerid', $customer_id);
		$this->db_oriskin->where('isclaim', 1);
		$query = $this->db_oriskin->get();
		return $query->num_rows() > 0;
	}

}
