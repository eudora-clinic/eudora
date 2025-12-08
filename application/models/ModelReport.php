<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelReport extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db_oriskin = $this->load->database('oriskin', true);
	}

	public function getReportRevenueByCustomer($period, $type)
	{
		$query = "Exec SpEudoraRevenueByCustomer ?, ?, ?";
		return $this->db_oriskin->query($query, [$period, 1, $type])->result_array();
	}

	// public function getDetailStockOpnameAdjustment($locationid, $date)
	// {
	// 	$query = "Exec [spEudoraReportUsingIngredients] ?, ?, ?";
	// 	return $this->db_oriskin->query($query, [$locationid, $date, 2])->result_array();
	// }

	public function getDetailStockOpnameAdjustment($locationid, $date)
	{
		$query = "EXEC [spEudoraReportUsingIngredients] ?, ?, ?";
		$results = $this->db_oriskin->query($query, [$locationid, $date, 2])->result_array();

		if (empty($results)) {
			return $results;
		}

		// Ambil INGREDIENTSID dari hasil SP (case-sensitive)
		$ingredientIds = array_map('intval', array_column($results, 'INGREDIENTSID'));
		$ingredientIds = array_filter($ingredientIds);

		if (!empty($ingredientIds)) {
			// Ambil unitid dan name dari msunitingredients, lalu beri alias unitname
			$unitData = $this->db_oriskin
				->select('i.id AS ingredientsid, i.unitid, u.name AS unitname')
				->from('msingredients i')
				->join('msunitingredients u', 'i.unitid = u.id', 'left')
				->where_in('i.id', $ingredientIds)
				->get()
				->result_array();

			// Buat mapping cepat berdasarkan ingredientsid
			$unitMap = [];
			foreach ($unitData as $u) {
				$unitMap[(int) $u['ingredientsid']] = [
					'unitid' => $u['unitid'],
					'unitname' => $u['unitname'],
				];
			}

			// Tambahkan data ke setiap hasil SP
			foreach ($results as &$row) {
				$ingredientId = isset($row['INGREDIENTSID']) ? (int) $row['INGREDIENTSID'] : 0;

				if (isset($unitMap[$ingredientId])) {
					$row['unitid'] = $unitMap[$ingredientId]['unitid'];
					$row['unitname'] = $unitMap[$ingredientId]['unitname'];
				} else {
					$row['unitid'] = null;
					$row['unitname'] = null;
				}
			}
			unset($row); // untuk menghindari referensi tak sengaja
		}

		return $results;
	}


	public function getStockOpnameList($dateStart, $dateEnd)
	{
		$this->db_oriskin->select('e.*,  ml.name as locationname');
		$this->db_oriskin->from('stock_opname e');
		$this->db_oriskin->join('mslocation ml', 'e.locationid = ml.id', 'inner');
		$this->db_oriskin->where('e.stockopnamedate >=', $dateStart);
		$this->db_oriskin->where('e.stockopnamedate <=', $dateEnd);
		// $this->db_oriskin->where('e.isactive', 1);

		return $this->db_oriskin->get()->result_array();
	}

	public function getFacilityCategory($search = null)
	{
		$this->db_oriskin->select('id, category_name AS text');
		$this->db_oriskin->from('facility_category');
		$this->db_oriskin->where('isactive', 1);

		if (!empty($search)) {
			$this->db_oriskin->like('category_name', $this->db_oriskin->escape_str($search));
		}

		$this->db_oriskin->order_by('id', 'ASC');
		return $this->db_oriskin->get()->result_array();
	}

	public function getAllFacility($locationid = null, $categoryid = null, $status = null)
	{
		$this->db_oriskin->select('f.*, fc.category_name, l.name AS location_name');
		$this->db_oriskin->from('msfacility f');
		$this->db_oriskin->join('mslocation l', 'l.id = f.locationid', 'left');
		$this->db_oriskin->join('facility_category fc', 'fc.id = f.categoryid', 'left');

		if (!empty($locationid)) {
			$this->db_oriskin->where('f.locationid', $locationid);
		}

		if (!empty($categoryid)) {
			$this->db_oriskin->where('f.categoryid', $categoryid);
		}

		if (!empty($status)) {
			$this->db_oriskin->where('f.status', $status);
		}

		$query = $this->db_oriskin->get();
		return $query->result_array();
	}

	public function getFacilityById($id)
	{
		$this->db_oriskin->select('f.*, fc.category_name,l.name AS location_name');
		$this->db_oriskin->from('msfacility f');
		$this->db_oriskin->join('mslocation l', 'l.id=f.locationid');
		$this->db_oriskin->join('facility_category fc', 'fc.id=f.categoryid');
		$this->db_oriskin->where('f.id', $id);
		$this->db_oriskin->order_by('f.id', 'ASC');

		$facility = $this->db_oriskin->get()->row_array();

		$this->db_oriskin->select('*');
		$this->db_oriskin->from('facility_images');
		$this->db_oriskin->where('facilityid', $id);
		$images = $this->db_oriskin->get()->result_array();

		$facility['images'] = $images;

		return $facility;
	}

	public function insertConditionItem($data)
	{
		return $this->db_oriskin->insert('facility_condition', $data);
	}

	public function updateFacility($facilityId, $data)
	{
		return $this->db_oriskin->where('id', $facilityId)->update('msfacility', $data);
	}

	public function getFacilityImage($facilityId)
	{
		return $this->db_oriskin->where('facilityid', $facilityId)->get('facility_images')->row();
	}

	public function updateFacilityImage($facilityId, $data)
	{
		return $this->db_oriskin->where('facilityid', $facilityId)->update('facility_images', $data);
	}

	public function updateConditionById($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		return $this->db_oriskin->update('facility_condition', $data);
	}

	public function getFacilityConditionById($id)
	{
		$this->db_oriskin
			->select('fco.*, f.facility_name, f.type, f.merk, f.facility_code, f.description AS facility_description, f.quantity, 
					fc.category_name, l.name AS location_name')
			->from('facility_condition AS fco')
			->join('msfacility AS f', 'fco.facilityid = f.id', 'left')
			->join('mslocation AS l', 'l.id = f.locationid', 'left')
			->join('facility_category AS fc', 'fc.id = f.categoryid', 'left')
			->where('fco.facilityid', $id)
			->order_by('fco.id', 'ASC');

		$query = $this->db_oriskin->get();

		// Cek apakah data ditemukan
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return []; // kosong
		}
	}

	public function getAllLocation()
	{
		$this->db_oriskin->select("id, CONCAT(shortcode, ' - ', name) AS text");
		$this->db_oriskin->from('mslocation');

		$this->db_oriskin->order_by('id', 'ASC');
		return $this->db_oriskin->get()->result_array();
	}


	public function getFacilityByLocation($locationid = null)
	{
		$this->db_oriskin->select('id, facility_name AS text');
		$this->db_oriskin->from('msfacility');
		$this->db_oriskin->where('locationid', $locationid);

		if (!empty($locationid)) {
			$this->db_oriskin->where('locationid', $locationid);
		}

		$this->db_oriskin->order_by('id', 'ASC');
		return $this->db_oriskin->get()->result_array();
	}


	public function createStockOpname($data)
	{
		$this->db_oriskin->insert('stock_opname', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function insertFacility($data)
	{
		$this->db_oriskin->insert('msfacility', $data);
		return $this->db_oriskin->insert_id();
	}

	public function insertFacilityImage($data)
	{
		return $this->db_oriskin->insert('facility_images', $data);
	}

	public function updateStockOpname($data, $id)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('stock_opname', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function getDetailStockOpname($id)
	{
		$query = "SELECT a.*, b.name as locationname FROM stock_opname a inner join mslocation b ON a.locationid = b.id WHERE a.id = $id";
		return $this->db_oriskin->query($query)->row_array();
	}

	public function getStockOpnameDetail($id)
	{
		$query = "SELECT * FROM stock_opname_detail WHERE id = $id";
		return $this->db_oriskin->query($query)->row_array();
	}


	public function createStockOpnameAdjustment($data)
	{
		$this->db_oriskin->insert('stock_opname_detail', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function updateStockOpnameAdjustment($data, $id)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('stock_opname_detail', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function getReportTransactionByProduct($dateStart, $dateEnd, $locationid, $productid, $producttypeid)
	{

		if ($producttypeid == 1) {
			$this->db_oriskin->select('e.*,  ml.name as locationname, phdr.name as productname, msem.name as employeename, msc.firstname as customername, msc.cellphonenumber as cellphonenumber, dtl.qty as qty');
			$this->db_oriskin->from('slinvoicetreatmenthdr e');
			$this->db_oriskin->join('mslocation ml', 'e.locationid = ml.id', 'inner');
			$this->db_oriskin->join('slinvoicetreatmentdtl dtl', 'e.id = dtl.id', 'inner');
			$this->db_oriskin->join('mstreatment phdr', 'dtl.productid = phdr.id', 'inner');
			$this->db_oriskin->join('msemployee msem', 'e.salesid = msem.id', 'inner');
			$this->db_oriskin->join('mscustomer msc', 'e.customerid = msc.id', 'inner');
			$this->db_oriskin->where('e.invoicedate >=', $dateStart);
			$this->db_oriskin->where('e.invoicedate <=', $dateEnd);
			$this->db_oriskin->where('e.status !=', 3);
			$this->db_oriskin->where('e.locationid =', $locationid);
			$this->db_oriskin->where('phdr.id =', $productid);
		} elseif ($producttypeid == 2) {
			$this->db_oriskin->select('e.*,  ml.name as locationname, phdr.name as productname, msem.name as employeename, msc.firstname as customername, msc.cellphonenumber as cellphonenumber, dtl.totalmonth as qty');
			$this->db_oriskin->from('slinvoicemembershiphdr e');
			$this->db_oriskin->join('mslocation ml', 'e.locationsalesid = ml.id', 'inner');
			$this->db_oriskin->join('slinvoicemembershipdtl dtl', 'e.id = dtl.id', 'inner');
			$this->db_oriskin->join('msproductmembershiphdr phdr', 'dtl.productmembershiphdrid = phdr.id', 'inner');
			$this->db_oriskin->join('msemployee msem', 'e.salesid = msem.id', 'inner');
			$this->db_oriskin->join('mscustomer msc', 'e.customerid = msc.id', 'inner');
			$this->db_oriskin->where('e.invoicedate >=', $dateStart);
			$this->db_oriskin->where('e.invoicedate <=', $dateEnd);
			$this->db_oriskin->where('e.status !=', 3);
			$this->db_oriskin->where('e.locationsalesid =', $locationid);
			$this->db_oriskin->where('phdr.id =', $productid);
		} elseif ($producttypeid == 3) {
			$this->db_oriskin->select('e.*,  ml.name as locationname, phdr.name as productname, msem.name as employeename, msc.firstname as customername, msc.cellphonenumber as cellphonenumber, dtl.qty as qty');
			$this->db_oriskin->from('slinvoicehdr e');
			$this->db_oriskin->join('mslocation ml', 'e.locationid = ml.id', 'inner');
			$this->db_oriskin->join('slinvoicedtl dtl', 'e.id = dtl.id', 'inner');
			$this->db_oriskin->join('msproduct phdr', 'dtl.productid = phdr.id', 'inner');
			$this->db_oriskin->join('msemployee msem', 'e.salesid = msem.id', 'inner');
			$this->db_oriskin->join('mscustomer msc', 'e.customerid = msc.id', 'inner');
			$this->db_oriskin->where('e.invoicedate >=', $dateStart);
			$this->db_oriskin->where('e.invoicedate <=', $dateEnd);
			$this->db_oriskin->where('e.status !=', 3);
			$this->db_oriskin->where('e.locationid =', $locationid);
			$this->db_oriskin->where('phdr.id =', $productid);
		}

		return $this->db_oriskin->get()->result_array();
	}


	public function getReportCustomerDoingAndSpending($dateStart, $dateEnd)
	{
		$userid = $this->session->userdata('userid');
		$query = "Exec [SpEudoraReportCustomerDoingSpending] ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid, 1])->result_array();
	}

	public function getReportCustomerDoingAndSpendingDetail($dateStart, $dateEnd)
	{
		$userid = $this->session->userdata('userid');
		$query = "Exec [SpEudoraReportCustomerDoingSpending] ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid, 2])->result_array();
	}

	public function getReportCustomerLast2YearSpendingAndPrepaidLeft($loationId)
	{
		$query = "Exec SpEudoraCustomerLast2YearPurchase ?";
		return $this->db_oriskin->query($query, [$loationId])->result_array();
	}

	public function getReportTransactionGuestEventRoadshow($dateStart, $dateEnd)
	{
		$locationid = $this->session->userdata('locationid');
		$query = "Exec [spReportTransactionCustomerRoadshow] ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $locationid])->result_array();
	}



	public function get_commission_report_invoice_lifetime($start_date, $end_date)
	{
		$detail_query = "
            SELECT 
                a.invoiceno, 
                a.invoicedate, 
                c.name as product_name, 
                d.name as sales_name, 
                b.totalamount, 
                b.totalmonth, 
                e.name as location_name,
                CASE 
                    WHEN b.totalamount BETWEEN 9990000 AND 10000000 THEN 100000
                    WHEN b.totalamount BETWEEN 19900000 AND 20000000 THEN 250000
                    ELSE 0
                END AS commission,
				e.name as locationname
            FROM slinvoicemembershiphdr a 
            INNER JOIN slinvoicemembershipdtl b ON a.id = b.id 
            INNER JOIN msproductmembershiphdr c ON b.productmembershiphdrid = c.id 
            INNER JOIN msemployee d ON a.salesid = d.id
            INNER JOIN mslocation e ON a.locationsalesid = e.id
            WHERE productmembershiphdrid IN (2142, 2143, 2144, 2145)  AND a.status NOT IN (3)
                AND (CONVERT(VARCHAR(10), invoicedate, 120) BETWEEN ? AND ?)
            ORDER BY a.invoicedate DESC
        ";

		$details = $this->db_oriskin->query($detail_query, [$start_date, $end_date])->result_array();
		$summary_query = "
            SELECT 
                d.name AS sales_name,
                COUNT(a.invoiceno) AS total_transaksi,
                SUM(b.totalamount) AS total_amount,
                SUM(
                    CASE 
                        WHEN b.totalamount BETWEEN 9990000 AND 10000000 THEN 100000
                        WHEN b.totalamount BETWEEN 19900000 AND 20000000 THEN 250000
                        ELSE 0
                    END
                ) AS total_commission,
				 e.name as locationname
            FROM slinvoicemembershiphdr a 
            INNER JOIN slinvoicemembershipdtl b ON a.id = b.id 
            INNER JOIN msproductmembershiphdr c ON b.productmembershiphdrid = c.id 
            INNER JOIN msemployee d ON a.salesid = d.id
            INNER JOIN mslocation e ON a.locationsalesid = e.id
            WHERE productmembershiphdrid IN (2142, 2143, 2144, 2145) AND a.status NOT IN (3)
                AND (CONVERT(VARCHAR(10), invoicedate, 120) BETWEEN ? AND ?)
            GROUP BY d.name, e.name
            ORDER BY total_commission DESC
        ";

		$summary = $this->db_oriskin->query($summary_query, [$start_date, $end_date])->result_array();

		return [
			'details' => $details,
			'summary' => $summary
		];
	}



	public function get_commission_report_invoice_product_therapist($start_date, $end_date)
	{
		$detail_query = "
            SELECT 
				a.invoiceno, 
				a.invoicedate, 
				c.name as productname, 
				b.total as amount, 
				b.qty as qty, 
				d.name as salesname, 
				e.name as locationname,
				CASE 
					WHEN b.total >= 50000 AND b.productid IN (44, 48, 1123) THEN b.qty * 20000
					WHEN b.total >= 80000 AND b.productid IN (128, 130) AND qty = 1 THEN b.qty * 10000
					WHEN b.total >= 120000 AND b.productid IN (128, 130) AND qty > 1 THEN b.qty * 25000
					ELSE 0
				END as komisi
				FROM slinvoicehdr a 
				INNER JOIN slinvoicedtl b ON a.id = b.invoicehdrid 
				INNER JOIN msproduct c ON b.productid = c.id
				INNER JOIN msemployee d ON a.salesid = d.id
				INNER JOIN msemployeeinvoice q ON d.id = q.employeeid
				INNER JOIN mslocation e ON a.locationid = e.id
				WHERE productid IN (44, 48, 1123, 128, 130) AND status NOT IN (3)
				AND (CONVERT(varchar(10), invoicedate, 120) BETWEEN ? AND ?) AND jobid = 6
        ";

		$details = $this->db_oriskin->query($detail_query, [$start_date, $end_date])->result_array();

		$summary_query = "
				SELECT 
					e.name as locationname,
					d.name as salesname,
					SUM(
						CASE 
							WHEN b.total >= 50000 AND b.productid IN (44, 48, 1123) THEN b.qty * 20000
							WHEN b.total >= 80000 AND b.productid IN (128, 130) AND b.qty = 1 THEN b.qty * 10000
							WHEN b.total >= 120000 AND b.productid IN (128, 130) AND b.qty > 1 THEN b.qty * 25000
							ELSE 0
						END
					) as total_komisi,
					COUNT(DISTINCT a.invoiceno) as total_transaksi,
					SUM(b.qty) as total_qty,
					SUM(b.total) as total_amount
				FROM slinvoicehdr a 
				INNER JOIN slinvoicedtl b ON a.id = b.invoicehdrid 
				INNER JOIN msproduct c ON b.productid = c.id
				INNER JOIN msemployee d ON a.salesid = d.id
				INNER JOIN msemployeeinvoice q ON d.id = q.employeeid
				INNER JOIN mslocation e ON a.locationid = e.id
				WHERE b.productid IN (44, 48, 1123, 128, 130)  AND status NOT IN (3)
					AND (CONVERT(varchar(10), a.invoicedate, 120) BETWEEN ? AND ?) 
					AND q.jobid = 6
				GROUP BY 
					e.name, 
					d.name
				ORDER BY 
					e.name, 
					d.name;
        ";

		$summary = $this->db_oriskin->query($summary_query, [$start_date, $end_date])->result_array();

		return [
			'details' => $details,
			'summary' => $summary
		];
	}

	public function getSummaryReportAchievement($period, $userid)
	{
		$query = "Exec SpEudoraReportAchievement ?, ?";
		return $this->db_oriskin->query($query, [$period, $userid])->result_array();
	}



}
