<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MApp extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db_oriskin = $this->load->database('oriskin', true);
	}

	function getData($type, $param1 = "", $param2 = "", $param3 = "", $param4 = "")
	{
		switch ($type) {
			case 'login':
				$db_oriskin = $this->load->database('oriskin', true);
				$sql = "SELECT a.id as userid, a.name, a.locationid, a.level
						FROM msuser a
		                WHERE a.name='" . $param1 . "' AND a.password='" . $param2 . "'";
				return $db_oriskin->query($sql)->row();
				break;
			case 'invoice_membership_dtl':
				$db_oriskin = $this->load->database('oriskin', true);
				$sql = "SELECT id, productmembershiphdrid, totalamount, enddate, activationdate
						FROM slinvoicemembershipdtl
						WHERE id = " . $param1;
				return $db_oriskin->query($sql)->result_array();
				break;
			case 'list_msemployeedetail':
				$db_oriskin = $this->load->database('oriskin', true);
				$sql = "SELECT a.id, a.employeeid, a.jobid, a.locationid, a.statusid, j.name as jobname, l.name as locationname, a.enddate as enddate, a.enddate as enddate
						FROM msemployeedetail a
						INNER JOIN msjob j on a.jobid = j.id
						INNER JOIN mslocation l on a.locationid = l.id
						WHERE a.employeeid = " . $param1;
				return $db_oriskin->query($sql)->result_array();
				break;
		}
	}

	function updateMsemployeedetail($post = "")
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);
		# quer

		$sql = "UPDATE msemployeedetail
				SET jobid = '" . $post['jobid'] . "', locationid = '" . $post['locationid'] . "'
				WHERE id = " . $post['id'];

		$query = $db_oriskin->query($sql);
		return 'Data berhasil disimpan.';
	}

	function updateMsemployee($post = "")
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);
		# query
		$sql = "UPDATE msemployee
					SET name = '" . $post['name'] . "', cellphonenumber = '" . $post['cellphonenumber'] . "', isactive = '" . $post['isactive'] . "'
					WHERE id = " . $post['id'];

		$query = $db_oriskin->query($sql);
		return 'Data berhasil disimpan.';
	}



	function setPassword($post = "")
	{
		$username = $this->session->userdata('name');
		$md5password = $this->db->query("SELECT password FROM user WHERE name='" . $username . "'")->row()->password;

		if (md5($post['password_lama']) != $md5password) {
			return 'Password lama tidak sama.';
		} elseif ($post['password_baru'] != $post['konfirmasi_password']) {
			return 'Konfirmasi password baru tidak sama.';
		} else {
			$this->db->query("UPDATE user SET password='" . md5($post['password_baru']) . "' WHERE name='" . $username . "'");
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				# Something went wrong.
				$this->db->trans_rollback();
				return 0;
			} else {
				# Everything is Perfect.
				# Committing data to the database.
				$this->db->trans_commit();
				return 1;
			}
		}
	}

	function updateCustomerDetail($post = "")
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);
		// Escape data to prevent SQL injection
		$firstname = $db_oriskin->escape_str($post['firstname']);
		$lastname = $db_oriskin->escape_str($post['lastname']);
		$ssid = $db_oriskin->escape_str($post['ssid']);
		$address = $db_oriskin->escape_str($post['address']);
		$dateofbirth = $db_oriskin->escape_str($post['dateofbirth']);
		$id = (int) $post['id']; // Cast to integer for safety
		$userid = $this->session->userdata('userid');

		// Build the SQL query
		$sql = "UPDATE mscustomer
                SET firstname = '$firstname', lastname = '$lastname', ssid = '$ssid', address = '$address', dateofbirth = '$dateofbirth', 
				updateuserid = $userid, updatedate = GETDATE()
                WHERE id = $id";

		// Execute the query
		$query = $db_oriskin->query($sql);

		if ($query) {
			return 'Data berhasil disimpan.';
		} else {
			return 'Gagal menyimpan data.';
		}
	}
	function updateCustomerEmail($post = "")
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);
		// Escape data to prevent SQL injection
		$email = $db_oriskin->escape_str($post['email']);
		$id = (int) $post['id']; // Cast to integer for safety
		$userid = $this->session->userdata('userid');

		// Build the SQL query
		$sql = "UPDATE mscustomer
                SET email = '$email', updateuserid = $userid, updatedate = GETDATE()
                WHERE id = $id";

		// Execute the query
		$query = $db_oriskin->query($sql);

		if ($query) {
			return 'Data berhasil disimpan.';
		} else {
			return 'Gagal menyimpan data.';
		}
	}

	//modul treatment

	function updateStatusDoing($post = "")
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$vstatus = $db_oriskin->escape_str($post['vstatus']);
		$id = (int) $post['id'];
		$userid = $this->session->userdata('userid');


		if ($vstatus == 3) {
			// Jika vstatus adalah 3 (CANCEL), maka perbarui status pada tabel trdoingtreatment
			$sql = "UPDATE trdoingtreatment SET vstatus = 3, status = 3, updateuserid = $userid WHERE id = $id";
		} else {
			// Jika vstatus adalah 2 (CONFIRM) atau 4 (RESCHEDULE), maka perbarui vstatus pada tabel trdoingtreatment
			$sql = "UPDATE trdoingtreatment SET vstatus = '$vstatus', updateuserid = $userid WHERE id = $id";
		}

		$query = $db_oriskin->query($sql);

		if ($query) {
			return 'Status berhasil diperbarui.';
		} else {
			return 'Gagal memperbarui status.';
		}
	}

	function updateDoingTreatment($doingId, $treatmentDate, $startTreatment, $endTreatment, $duration, $followup, $remarks)
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);

		// Escape data to prevent SQL injection
		$treatmentDate = $db_oriskin->escape_str($treatmentDate);
		$startTreatment = $db_oriskin->escape_str($startTreatment);
		$endTreatment = $db_oriskin->escape_str($endTreatment);
		$duration = (float) $duration; // Cast to float for safety
		$followup = $db_oriskin->escape_str($followup);
		$remarks = $db_oriskin->escape_str($remarks);
		$doingId = (int) $doingId; // Cast to integer for safety
		$userid = $this->session->userdata('userid');

		// Build the SQL query
		$sql = "UPDATE trdoingtreatment
				SET treatmentdate = '$treatmentDate', starttreatment = '$startTreatment', endtreatment = '$endTreatment', duration = $duration,
				followupdate = '$followup', remarks = '$remarks', updateuserid =  $userid
				WHERE id = $doingId";

		// Execute the query
		$query = $db_oriskin->query($sql);

		if ($query) {
			return 'Data berhasil disimpan.';
		} else {
			return 'Gagal menyimpan data.';
		}
	}

	function updateRemarksOneMembershipActive($id, $remarks)
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);

		// Escape data to prevent SQL injection
		$remarks = $db_oriskin->escape_str($remarks);
		$id = (int) $id; // Cast to integer for safety

		// Build the SQL query
		$sql = "UPDATE sllcwithonemembershipactive
				SET remarks = '$remarks'
				WHERE id = $id";

		// Execute the query
		$query = $db_oriskin->query($sql);

		if ($query) {
			return 'Data berhasil disimpan.';
		} else {
			return 'Gagal menyimpan data.';
		}
	}

	//end modul treatment



	public function updateTrDoingTreatmentStatus($post = "")
	{
		$db_oriskin = $this->load->database('oriskin', true);

		$status = $db_oriskin->escape_str($post['status']);
		$id = (int) $post['id'];
		$userid = $this->session->userdata('userid');


		if ($status == 17) {
			// Jika tombol "Finish" diklik, periksa apakah tombol "Start" sudah diklik
			$startStatus = $db_oriskin->query("SELECT status FROM trdoingtreatment WHERE id = $id")->row()->status;

			if ($startStatus != 16) {
				// Jika tombol "Finish" diklik tetapi tombol "Start" belum diklik, keluarkan pengingat
				return 'Harap klik tombol "Start" terlebih dahulu.';
			}
		}

		// Update status sesuai dengan tombol yang diklik
		$sql = "UPDATE trdoingtreatment SET status = $status, updateuserid = $userid WHERE id = $id";
		$query = $db_oriskin->query($sql);

		if ($query) {
			return 'Status berhasil diperbarui.';
		} else {
			return 'Gagal memperbarui status.';
		}
	}

	// update status v.2 by Yudha
	public function updateTrDoingTreatmentStatusV2($post = "")
	{
		$db_oriskin = $this->load->database('oriskin', true);

		// Escape nilai yang diterima dari $post untuk menghindari SQL injection
		$status = $db_oriskin->escape_str($post['status']);
		$id = (int) $post['id'];
		$dateDoing = $post['dateDoing'];
		$userid = $this->session->userdata('userid');

		$guestLogId = $db_oriskin->query("SELECT ISNULL(c.id, '') AS guestlogid FROM trdoingtreatment a 
                                      INNER JOIN mscustomer b ON a.customerid = b.id
                                      INNER JOIN slguestlog c ON b.guestlogid = c.id
                                      WHERE a.id = $id")->row()->guestlogid ?? 0;

		$customerId = $db_oriskin->query("SELECT ISNULL(customerid, '') AS customerid FROM trdoingtreatment where id = $id")->row()->customerid ?? 0;

		// Mendapatkan refferalempid
		$queryReffId = $db_oriskin->query("SELECT ISNULL(b.refferalempid, '') AS refferalempid FROM mscustomer a 
                                       INNER JOIN slguestlog b ON a.guestlogid = b.id 
                                       WHERE b.refferalempid = 6029 AND a.guestlogid = $guestLogId")->row()->refferalempid ?? 0;

		// Query untuk mendapatkan data pelanggan yang sesuai dengan status tertentu
		$queryRows = $db_oriskin->query("SELECT ISNULL(a.id, '') AS id FROM mscustomer a 
                                     INNER JOIN slguestlog b ON a.guestlogid = b.id 
                                     INNER JOIN trdoingtreatment c ON a.id = c.customerid  
                                     WHERE a.guestlogid = $guestLogId
                                     AND c.status IN (2, 16, 17)");

		// Mendapatkan data dari hasil query
		$doingData = $queryRows->row()->id ?? 0;
		$num_rows = $queryRows->num_rows();

		if ($status == 17) {
			$startStatusQuery = $db_oriskin->query("SELECT status FROM trdoingtreatment WHERE id = ?", array($id));

			if ($startStatusQuery->num_rows() > 0) {
				$startStatus = $startStatusQuery->row()->status;

				if ($startStatus != 16) {
					return 'Harap klik tombol "Start" terlebih dahulu.';
				}
			} else {
				return 'ID tidak valid atau tidak ditemukan.';
			}
		}

		if ($status == 1) {
			$sql = "UPDATE trdoingtreatment 
            SET statusshowdokter = ?, updateuserid = ? 
            WHERE CONVERT(VARCHAR(10), treatmentdate, 120) = ? AND customerid = ?";

			$query = $db_oriskin->query($sql, array($status, $userid, $dateDoing, $customerId));

			if ($query) {
				return 'Status berhasil diperbarui.';
			} else {
				return 'Gagal memperbarui status.';
			}
		}

		if ($status == 5) {
			$sql = "UPDATE trdoingtreatment SET statusshowdokter2 = ?, updateuserid = ? WHERE id = ?";
			$query = $db_oriskin->query($sql, array(1, $userid, $id));

			if ($query) {
				return 'Status berhasil diperbarui.';
			} else {
				return 'Gagal memperbarui status.';
			}
		}

		if ($status == 3) {
			if ($queryReffId == 6029) {
				if ($num_rows == 1) {
					$db_oriskin->query("UPDATE slguestlog SET remarks = NULL WHERE id = $guestLogId");
				}
			}
		}

		// Update status sesuai dengan tombol yang diklik
		$sql = "UPDATE trdoingtreatment SET status = ?, updateuserid = ? WHERE id = ?";
		$query = $db_oriskin->query($sql, array($status, $userid, $id));

		if ($query) {
			return 'Status berhasil diperbarui.';
		} else {
			return 'Gagal memperbarui status.';
		}
	}


	public function model_data_tabs_btc($period, $locationid)
	{
		$db_oriskin = $this->load->database('oriskin', true);

		$data_waktu_btc = $db_oriskin->query("
					SELECT TIMESTART, TIMEFINISH
					FROM [fnReportAbsenceDoingEudora]('" . $period . "', '" . $locationid . "')
					GROUP BY TIMESTART, TIMEFINISH
				")->result_array();

		// echo 'data_waktu_btc: '.$db_oriskin->last_query().'<br><br>';
		# S: HENDI
		$data_absen = $db_oriskin->query("
					SELECT *
					FROM [fnReportAbsenceDoingEudora]('" . $period . "', '" . $locationid . "')
				")->result_array();

		$data_slot = $db_oriskin->query("
					SELECT *
					FROM [fnReportSlotByType]('" . $period . "', '" . $locationid . "')
				")->result_array();

		$data_btc = $db_oriskin->query("
					SELECT TIMESTART, TIMEFINISH, EMPLOYEEID, REMARKS, EMPLOYEENAME, CUSTOMERID, CUSTOMERNAME, CELLPHONENUMBER, TREATMENTNAME, QTY, DOINGID, ABSENCETIME, REMARKSBOOKING
					FROM [fnReportAbsenceDoingEudora]('" . $period . "', '" . $locationid . "')
					ORDER BY EMPLOYEENAME ASC
				")->result_array();

		# E: HENDI
		$result = array();

		foreach ($data_waktu_btc as $row) {
			# S: HENDI
			$time_start = $row['TIMESTART'];
			$time_finish = $row['TIMEFINISH'];

			# =========== data slot filtered
			$data_slot_filtered = array_filter($data_slot, function ($var) use ($time_start) {
				return ($var['TIMESTART'] == $time_start);
			});
			# reindex array
			$data_slot_filtered = array_values($data_slot_filtered);

			# =========== count NEW
			$data_absen_new = array_filter($data_absen, function ($var) use ($time_start, $period) {
				return ($var['TIMESTART'] == $time_start && $var['ABSENCEDATE'] == $period && $var['MEMBERTYPE'] == 'NEW');
			});
			# reindex array
			$data_absen_new = array_values($data_absen_new);
			$count_new = count($data_absen_new);

			# =========== count LC
			$data_absen_lc = array_filter($data_absen, function ($var) use ($time_start, $period) {
				return ($var['TIMESTART'] == $time_start && $var['ABSENCEDATE'] == $period && $var['MEMBERTYPE'] == 'LC');
			});
			# reindex array
			$data_absen_lc = array_values($data_absen_lc);
			$count_lc = count($data_absen_lc);

			# =========== count FREE
			$data_absen_free = array_filter($data_absen, function ($var) use ($time_start, $period) {
				return ($var['TIMESTART'] == $time_start && $var['ABSENCEDATE'] == $period && $var['MEMBERTYPE'] == 'FREE');
			});
			# reindex array
			$data_absen_free = array_values($data_absen_free);
			$count_free = count($data_absen_free);

			if ($count_free == 0) {
				$result_slot_new = 0;
				$result_slot_lc = 0;
			} else {
				$result_slot_new = max(($data_slot_filtered[0]['SLOTNEW'] ?? 0) - $count_new, 0);
				$result_slot_lc = max(($data_slot_filtered[0]['SLOTLC'] ?? 0) - $count_lc, 0);
			}

			# =========== DATA BTC
			$data_btc_filtered = array_filter($data_btc, function ($var) use ($time_start, $time_finish) {
				return ($var['TIMESTART'] == $time_start && $var['TIMEFINISH'] == $time_finish && $var['ABSENCETIME'] <= $time_start);
			});
			# reindex array
			$data_btc_filtered = array_values($data_btc_filtered);
			# E: HENDI
			$result[] = array('waktu_btc' => $row, 'result_slot_new' => $result_slot_new, 'result_slot_lc' => $result_slot_lc, 'data_btc' => $data_btc_filtered);
		}

		return $result;
	}

	private function getCount($counts, $type)
	{
		# S: HENDI
		$filterBy = $type;
		$filtered = array_filter($counts, function ($var) use ($filterBy) {
			return ($var['MEMBERTYPE'] === $filterBy);
		});
		# reindex array
		$filtered = array_values($filtered);
		return $filtered[0]['jml'];
		# E: HENDI
	}
	// END DATA TABS BTC

	// DATA TABS DOKTER
	public function model_data_tabs_dokter($period, $locationid)
	{
		$db_oriskin = $this->load->database('oriskin', true);

		$data_waktu_dokter = $db_oriskin->query("
					SELECT TIMESTART, TIMEFINISH
					FROM [fnReportAbsenceDoingDoctor]('" . $period . "', '" . $locationid . "')
					GROUP BY TIMESTART, TIMEFINISH
				")->result_array();

		# S: HENDI
		$data_dokter = $db_oriskin->query("
					SELECT TIMESTART, TIMEFINISH, EMPLOYEEID, REMARKS, EMPLOYEENAME, CUSTOMERID, CUSTOMERNAME, TREATMENTNAME, QTY, DOINGID, ABSENCETIME, REMARKSBOOKING
					FROM [fnReportAbsenceDoingDoctor]('" . $period . "', '" . $locationid . "')
					ORDER BY EMPLOYEENAME ASC
				")->result_array();
		# E: HENDI
		$result = array();

		foreach ($data_waktu_dokter as $row) {
			# S: HENDI
			$time_start = $row['TIMESTART'];
			$time_finish = $row['TIMEFINISH'];
			$data_dokter_filtered = array_filter($data_dokter, function ($var) use ($time_start, $time_finish) {
				return ($var['TIMESTART'] == $time_start && $var['TIMEFINISH'] == $time_finish && $var['ABSENCETIME'] <= $time_start);
			});
			# reindex array
			$data_dokter_filtered = array_values($data_dokter_filtered);
			# E: HENDI
			$result[] = array('data_dokter' => $data_dokter_filtered, 'waktu_dokter' => $row);
		}
		return $result;
	}

	public function data_shift($period, $locationid)
	{
		$db_oriskin = $this->load->database('oriskin', true);

		$data_shift = $db_oriskin->query("
					SELECT *
					FROM msshift
					ORDER BY id
				")->result_array();

		# S: HENDI
		$data_dokter = $db_oriskin->query("
					SELECT TIMESTART, TIMEFINISH, EMPLOYEEID, REMARKS, EMPLOYEENAME, CUSTOMERID, CUSTOMERNAME, TREATMENTNAME, QTY, DOINGID, ABSENCETIME, REMARKSBOOKING
					FROM [fnReportAbsenceDoingDoctor]('" . $period . "', '" . $locationid . "')
					ORDER BY EMPLOYEENAME ASC
				")->result_array();
		# E: HENDI
		$result = array();

		foreach ($data_waktu_dokter as $row) {
			# S: HENDI
			$time_start = $row['TIMESTART'];
			$time_finish = $row['TIMEFINISH'];
			$data_dokter_filtered = array_filter($data_dokter, function ($var) use ($time_start, $time_finish) {
				return ($var['TIMESTART'] == $time_start && $var['TIMEFINISH'] == $time_finish && $var['ABSENCETIME'] <= $time_start);
			});
			# reindex array
			$data_dokter_filtered = array_values($data_dokter_filtered);
			# E: HENDI
			$result[] = array('data_dokter' => $data_dokter_filtered, 'waktu_dokter' => $row);
		}
		return $result;
	}

	function updateEmployeeAsm($post = "")
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);

		# mulai transaksi
		$db_oriskin->trans_start();

		# query update msreferalsales
		$sql1 = "UPDATE msreferalsales
			 SET employeeid = '" . $post['employeeid'] . "'
			 WHERE customerid = " . $post['CUSTOMERID'];
		$query1 = $db_oriskin->query($sql1);

		# query update sldatalead
		$sql2 = "UPDATE sldatalead
			 SET employeeid = '" . $post['employeeid'] . "'
			 WHERE customerid = " . $post['CUSTOMERID'];
		$query2 = $db_oriskin->query($sql2);

		# selesaikan transaksi
		$db_oriskin->trans_complete();

		# cek apakah transaksi sukses
		if ($db_oriskin->trans_status() === FALSE) {
			# jika transaksi gagal
			return 'Terjadi kesalahan saat menyimpan data.';
		} else {
			# jika transaksi sukses
			return 'Data berhasil disimpan.';
		}
	}



	function updateTrdoingTreatment($post = "")
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);
		$userid = $this->session->userdata('userid');
		# query
		$sql = "UPDATE trdoingtreatment
				SET treatmentdate = '" . $post['treatmentdate'] . "', qty = '" . $post['qty'] . "' ,status = '" . $post['status'] . "', updateuserid = '" . $userid . "'
				WHERE id = " . $post['id'];

		$query = $db_oriskin->query($sql);
		return 'Data berhasil disimpan.';
	}

	function postShift($post = "")
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);
		$userid = $this->session->userdata('userid');
		# query
		$data = [
			'shiftcode' => $post['shiftcode'],
			'shiftname' => $post['shiftname'],
			'timein' => $post['timein'],
			'timeout' => $post['timeout'],
		];
		$insert = $db_oriskin->insert('msshift', $data);
		$query = $db_oriskin->query($sql);
		return 'Data berhasil disimpan.';
	}

	public function get_location_list()
	{
		return $this->db_oriskin->query("
            SELECT *
            FROM mslocation
            WHERE isactive = 1 
            AND name NOT LIKE '%NEW TRIX%' 
            AND name NOT LIKE '%ON PROGRESS%' 
            AND id NOT IN (6)
            ORDER BY id
        ")->result_array();
	}

	public function get_location_list_company()
	{
		return $this->db_oriskin->query("
            SELECT *
            FROM mslocation
            WHERE name NOT LIKE '%NEW TRIX%' 
            AND name NOT LIKE '%ON PROGRESS%' 
            AND id NOT IN (6)
            ORDER BY id
        ")->result_array();
	}

	public function get_location_list_purchasingv2()
	{
		return $this->db_oriskin->query("
            SELECT 
				mslocation.id, 
				mslocation.name,
				mswarehouse.warehouse_name
			FROM mslocation
			LEFT JOIN mswarehouse
				ON mslocation.warehouseid = mswarehouse.id
			WHERE mslocation.name NOT LIKE '%NEW TRIX%'
			AND mslocation.name NOT LIKE '%ON PROGRESS%'
			AND mslocation.id NOT IN (6)
			ORDER BY mslocation.id;
        ")->result_array();
	}


	public function get_location_list_purchasing()
	{
		return $this->db_oriskin->query("
            SELECT 
				a.id, 
				b.name,
				c.warehouse_name,
				c.id as warehouseid
			FROM pivotwarehouselocation a
			INNER JOIN mslocation b ON a.locationid = b.id
			INNER JOIN mswarehouse c ON a.warehouseid = c.id
			WHERE b.name NOT LIKE '%NEW TRIX%'
			AND b.name NOT LIKE '%ON PROGRESS%'
			ORDER BY b.id;
        ")->result_array();
	}

	public function get_supplier_list()
	{
		return $this->db_oriskin->query("
            SELECT id, name 
            FROM mssupplier
        ")->result_array();
	}
	public function getPackageList()
	{
		return $this->db_oriskin->query("SELECT 
						b.productbenefitid as PRODUCTBENEFITID, a.id as ID, a.code as CODE, a.name as NAME, b.totalprice as PRICE, CASE 
						WHEN a.isactive = 1 THEN 'Yes'
						WHEN a.isactive = 0 THEN 'No'
					END AS PUBLISHED, CASE 
						WHEN a.pointsection = 2 THEN 'NON MEDIS'
						WHEN a.pointsection = 1 THEN 'MEDIS'
						WHEN a.pointsection = 0 THEN 'NO'
					END AS POINTSECTION, a.image FROM msproductmembershiphdr a 
					INNER JOIN msproductmembershipdtl b ON a.id = b.id
        ")->result_array();
	}

	public function getServiceList($type)
	{
		if ($type == 1) {
			return $this->db_oriskin->query("SELECT 
						t.id AS ID,
						t.code AS CODE,
						t.name AS NAME,
						t.price AS PRICE,
						t.ingredientscategoryid,
						ic.name AS INGREDIENT_CATEGORY_NAME,
						CASE 
							WHEN t.isactive = 1 THEN 'Yes'
							WHEN t.isactive = 0 THEN 'No'
						END AS PUBLISHED,
						CASE 
							WHEN t.pointsection = 2 THEN 'NON MEDIS'
							WHEN t.pointsection = 1 THEN 'MEDIS'
							WHEN t.pointsection = 0 THEN 'NO'
						END AS POINTSECTION,
						CASE 
							WHEN d.ingredientscategoryid IS NOT NULL THEN 'Ada COGS'
							ELSE 'Tidak Ada COGS'
						END AS COGS_STATUS
					FROM mstreatment t
					LEFT JOIN mstreatment ic ON t.ingredientscategoryid = ic.id
					LEFT JOIN (
						SELECT DISTINCT ingredientscategoryid
						FROM mstreatmentingredients
					) d ON t.ingredientscategoryid = d.ingredientscategoryid
					ORDER BY t.ingredientscategoryid
        ")->result_array();
		} else if ($type == 2) {
			return $this->db_oriskin->query("SELECT 
						id as ID, code as CODE, name as NAME, price as PRICE, ingredientscategoryid,
						CASE 
							WHEN isactive = 1 THEN 'Yes'
							WHEN isactive = 0 THEN 'No'
						END AS PUBLISHED 
						FROM mstreatment WHERE ingredientscategoryid NOT IN (SELECT DISTINCT ingredientscategoryid FROM mstreatmentingredients)
        ")->result_array();
		} else if ($type == 3) {
			return $this->db_oriskin->query("SELECT 
						DISTINCT b.id as ID, b.code as CODE, b.name as NAME, b.price as PRICE, b.ingredientscategoryid,
						CASE 
							WHEN b.isactive = 1 THEN 'Yes'
							WHEN b.isactive = 0 THEN 'No'
						END AS PUBLISHED  from slinvoicetreatmentdtl a inner join mstreatment b on a.productid = b.id where productid IN(
			SELECT DISTINCT mt.ingredientscategoryid
			FROM mstreatment mt
			WHERE mt.ingredientscategoryid IS NOT NULL
			AND mt.ingredientscategoryid NOT IN (
				SELECT DISTINCT ingredientscategoryid
				FROM mstreatmentingredients
				WHERE ingredientscategoryid IS NOT NULL
			)
		)
        ")->result_array();
		}
	}

	public function getRetailList()
	{
		return $this->db_oriskin->query("SELECT 
						id as ID, code as CODE, name as NAME, price1 as PRICE, 
						CASE 
							WHEN isactive = 1 THEN 'Yes'
							WHEN isactive = 0 THEN 'No'
						END AS PUBLISHED 
						FROM msproduct WHERE isactive = 1
        ")->result_array();
	}

	public function getIngredientsList()
	{
		return $this->db_oriskin->query("SELECT 
						a.id as ID, a.code as CODE, a.name as NAME, a.price as PRICE,
						CASE 
							WHEN a.isactive = 1 THEN 'Yes'
							WHEN a.isactive = 0 THEN 'No'
						END AS PUBLISHED,
						b.name AS UOM,
						a.qty AS QTYTOUOM,
						a.unitprice AS UNITPRICE
						FROM msingredients a 
						INNER JOIN msunitingredients b ON a.unitid = b.id
						-- WHERE a.isactive = 1
        ")->result_array();
	}

	public function get_city_list()
	{
		return $this->db_oriskin->query("
            SELECT id, name 
            FROM msguestlogadvtracking 
            WHERE isactive = 1 
            ORDER BY id
        ")->result_array();
	}

	public function get_product_membership_list()
	{
		$location_id = $this->session->userdata('locationid');

		if ($location_id == 31 || $location_id == 19) {
			return $this->db_oriskin->query("
            SELECT a.id, a.name, b.subscriptionmonth, b.bonusmonth, b.totalmonth, 
                   b.registrationfee, b.termprice, b.totalprice, 
                   b.monthlyfee, b.firstmonthfee, b.lastmonthfee, a.pointsection
            FROM msproductmembershiphdr a 
            INNER JOIN msproductmembershipdtl b ON a.id = b.productmembershiphdrid 
            WHERE a.isactive = 1 
            ORDER BY a.id
        ")->result_array();
		} else {
			return $this->db_oriskin->query("
            SELECT a.id, a.name, b.subscriptionmonth, b.bonusmonth, b.totalmonth, 
                   b.registrationfee, b.termprice, b.totalprice, 
                   b.monthlyfee, b.firstmonthfee, b.lastmonthfee, a.pointsection
            FROM msproductmembershiphdr a 
            INNER JOIN msproductmembershipdtl b ON a.id = b.productmembershiphdrid 
            WHERE a.isactive = 1 AND a.id NOT IN (2148)
            ORDER BY a.id
        ")->result_array();
		}

	}

	public function get_product_treatment_list($type)
	{
		if ($type == 1) {
			return $this->db_oriskin->query("
            SELECT * FROM mstreatment 
            WHERE isactive = 1 
            ORDER BY id
        ")->result_array();
		} elseif ($type == 2) {
			return $this->db_oriskin->query("
            SELECT * FROM mstreatment 
            WHERE isactive = 0 and name LIKE '%voucher shopee%'
            ORDER BY id
        ")->result_array();
		}
	}

	public function get_product_retail_list()
	{
		return $this->db_oriskin->query("
            SELECT * FROM msproduct 
            WHERE isactive = 1 
            ORDER BY id
        ")->result_array();
	}

	public function get_payment_list($location_id)
	{
		if ($location_id == 12) {
			return $this->db_oriskin->query("
            SELECT id, name 
            FROM mspaymenttype 
            WHERE isactive = 1 AND id not in (48, 50, 51, 49, 59, 58, 65)
            ORDER BY id
        ")->result_array();
		} else {
			return $this->db_oriskin->query("
            SELECT id, name 
            FROM mspaymenttype 
            WHERE isactive = 1 
            ORDER BY id
        ")->result_array();
		}
	}

	public function getReportAppointmentCustomerCareOnline($dateStart, $dateEnd)
	{
		return $this->db_oriskin->query("
            SELECT 
				CASE status
					WHEN 1 THEN 'Waiting Confirmation'
					WHEN 2 THEN 'Confirmed'
					WHEN 3 THEN 'Last Minute Cancel'
					WHEN 4 THEN 'Not Show'
					WHEN 5 THEN 'Finished'
					WHEN 6 THEN 'Checkin'
					ELSE 'Unknown'
				END AS STATUS,
				(CONVERT(VARCHAR(10), createdate,120)) AS CREATEDATE,
				(CONVERT(VARCHAR(10), appointmentdate,120)) AS APPOINTMENTDATE,
				b.firstname + ' ' + b.lastname AS CUSTOMERNAME,
				b.cellphonenumber AS CELLPHONENUMBER,
				c.name AS LOCATIONNAME
			FROM trbookappointment a 
			INNER JOIN mscustomer b ON a.customerid = b.id
			INNER JOIN mslocation c ON a.locationid = c.id
			WHERE createbyuserid = 49 AND customerid NOT IN (5)
			AND (CONVERT(VARCHAR(10), a.createdate,120) between ? and ?)
        ", [$dateStart, $dateEnd])->result_array();

	}

	public function get_edc_list($location_id)
	{

		return $this->db_oriskin->query("
            SELECT id, name 
            FROM msedc 
            WHERE isactive = 1 
            AND locationid = ? 
            ORDER BY id
        ", [$location_id])->result_array();
	}

	public function get_consultant_list($location_id)
	{
		if ($location_id == 12 || $location_id == 11 || $location_id == 13) {
			return $this->db_oriskin->query("
            SELECT a.id, a.name 
            FROM msemployeeinvoice d 
			INNER JOIN msemployee a ON d.employeeid = a.id
            INNER JOIN msemployeedetail b ON a.id = b.employeeid 
            INNER JOIN msjob c ON b.jobid = c.id 
            WHERE d.locationid = ?
            AND d.isactive = 1 
            AND (c.name like '%DOKTER%' or c.name LIKE '%CONSULTANT%' or c.name LIKE '%OM%')
            ORDER BY a.name
        ", [$location_id])->result_array();
		} else {
			return $this->db_oriskin->query("
            SELECT a.id, a.name 
            FROM msemployeeinvoice d 
			INNER JOIN msemployee a ON d.employeeid = a.id
            INNER JOIN msemployeedetail b ON a.id = b.employeeid 
            INNER JOIN msjob c ON b.jobid = c.id 
            WHERE d.locationid = ?
            AND d.isactive = 1 
            AND (c.name LIKE '%CONSULTANT%')
            ORDER BY a.name
        ", [$location_id])->result_array();
		}
	}

	public function get_consultant_list_for_retail($location_id)
	{
		return $this->db_oriskin->query("
				SELECT a.id, a.name 
				FROM msemployeeinvoice d 
				INNER JOIN msemployee a ON d.employeeid = a.id
				INNER JOIN msemployeedetail b ON a.id = b.employeeid 
				INNER JOIN msjob c ON b.jobid = c.id 
				WHERE d.locationid = ?
				AND d.isactive = 1 
				AND (c.name like '%FRONT DESK%' or c.name like '%BEAUTY THERAPIST%' or c.name like '%DOKTER%' or c.name LIKE '%CONSULTANT%'  or c.name LIKE '%OM%' or c.name LIKE '%OFFICE BOY%' or c.name LIKE '%NURSE%')
				ORDER BY a.name
        ", [$location_id])->result_array();
	}


	public function get_card_list()
	{
		return $this->db_oriskin->query("
            select id, name from  mscard where isactive  = 1 order by id
        ")->result_array();
	}

	public function get_bank_list()
	{
		return $this->db_oriskin->query("
            select id, name from  msbank order by id
        ")->result_array();
	}

	public function get_insatllment_list()
	{
		return $this->db_oriskin->query("
            select id, name from  msinstallment where isactive  = 1 order by id
        ")->result_array();
	}

	public function get_frontdesk_list($location_id)
	{
		$level = $this->session->userdata('level');

		if ($level == 11 || $location_id == 36 || $location_id == 48) {
			return $this->db_oriskin->query("
				SELECT a.id, a.name 
				FROM msemployeeinvoice d 
				INNER JOIN msemployee a ON d.employeeid = a.id
				INNER JOIN msemployeedetail b ON a.id = b.employeeid 
				INNER JOIN msjob c ON b.jobid = c.id 
				WHERE d.locationid = ?
				AND a.isactive = 1 
				AND c.name LIKE '%CONSULTANT%'
				ORDER BY a.name
			", [$location_id])->result_array();
		} else {
			return $this->db_oriskin->query("
				SELECT a.id, a.name 
				FROM msemployeeinvoice d 
				INNER JOIN msemployee a ON d.employeeid = a.id
				INNER JOIN msemployeedetail b ON a.id = b.employeeid 
				INNER JOIN msjob c ON b.jobid = c.id 
				WHERE d.locationid = ?
				AND a.isactive = 1 
				AND c.name LIKE '%FRONT DESK%'
				ORDER BY a.name
			", [$location_id])->result_array();
		}
	}

	public function getEmployeeForBooking($location_id, $level)
	{
		if ($level == 2) {
			return $this->db_oriskin->query("
            select id, name from msemployee where id in (1040, 1041, 1042, 1043)
        	")->result_array();
		} else if ($level == 12) {
			return $this->db_oriskin->query("
            select id, name from msemployee where title = 'TRILOGY'
        	")->result_array();
		} else if ($level == 13) {
			return $this->db_oriskin->query("
            select id, name from msemployee where id in (1871, 1040)
        	")->result_array();
		} else {
			return $this->db_oriskin->query("
				select a.id, a.name from msemployee a inner join msemployeedetail b on a.id = b.employeeid inner join msjob c on b.jobid = c.id where b.locationid  = ? and a.isactive  = 1 AND (c.name like '%FRONT DESK%' or c.name LIKE '%CONSULTANT%') order by a.name 
			", [$location_id])->result_array();
		}
	}

	public function get_doctor_list($location_id)
	{


		return $this->db_oriskin->query("
            	SELECT a.id, a.name 
				FROM msemployeeinvoice d 
				INNER JOIN msemployee a ON d.employeeid = a.id
				INNER JOIN msemployeedetail b ON a.id = b.employeeid 
				INNER JOIN msjob c ON b.jobid = c.id 
				WHERE d.locationid = ?
				AND d.isactive = 1 
				AND c.name LIKE '%DOKTER%'
				ORDER BY a.name
        ", [$location_id])->result_array();
	}

	public function get_discount_reason_list()
	{
		return $this->db_oriskin->query("
            select * from msdiscountreason where isactive = 1
        ")->result_array();
	}

	public function get_treatmentDp_list($location_id)
	{
		return $this->db_oriskin->query("
           select a.id as ID, 
		   a.downpaymentno as DPNO, 
		   a.downpaymentdate as DPDATE, 
		   c.firstname as FIRSTNAME, 
		   c.lastname as LASTNAME, 
		   b.total as TOTALAMOUNT, 
		   sum(d.amount) as AMOUNT 
		   from sldownpaymenttreatmenthdr a 
		   inner join sldownpaymenttreatmentdtl b on a.id = b.downpaymenthdrid 
		   inner join mscustomer c on a.customerid = c.id 
		   inner join sldownpaymenttreatmentpayment d on a.id = d.downpaymenthdrid 
		   where a.locationid = ? and a.status = 10
		   GROUP BY a.id, a.downpaymentno, a.downpaymentdate, c.firstname, c.lastname, b.total
        ", [$location_id])->result_array();
	}

	public function get_membershipDp_list($location_id)
	{
		return $this->db_oriskin->query("
            select 
				a.id as ID, 
				a.downpaymentno as DPNO, 
				a.downpaymentdate as DPDATE, 
				c.firstname as FIRSTNAME, 
				c.lastname as LASTNAME, 
				b.totalamount as TOTALAMOUNT, 
				sum(d.amount) as AMOUNT 
				from sldownpaymentmembershiphdr a 
				INNER JOIN sldownpaymentmembershipdtl b ON a.id = b.id 
				INNER JOIN mscustomer c ON a.customerid = c.id 
				INNER JOIN sldownpaymentmembershippayment d ON a.id = d.downpaymenthdrid 
				WHERE a.locationsalesid = ? and a.status = 10
				GROUP BY a.id, a.downpaymentno, a.downpaymentdate, c.firstname, c.lastname, b.totalamount
        ", [$location_id])->result_array();
	}

	public function get_retailDp_list($location_id)
	{
		return $this->db_oriskin->query("
           SELECT 
                                            a.id AS ID, 
                                            a.downpaymentno AS DPNO, 
                                            a.downpaymentdate AS DPDATE, 
                                            c.firstname AS FIRSTNAME, 
                                            c.lastname AS LASTNAME, 
                                            SUM(b.total) AS TOTALAMOUNT,
                                            d.amount AS AMOUNT
                                        FROM 
                                            sldownpaymentproducthdr a
                                        INNER JOIN 
                                            sldownpaymentproductdtl b ON a.id = b.downpaymenthdrid
                                        INNER JOIN 
                                            mscustomer c ON a.customerid = c.id
                                        INNER JOIN 
                                            sldownpaymentproductpayment d ON a.id = d.downpaymenthdrid
                                        WHERE 
                                            a.locationid = ?
                                            AND a.status = 10
                                        GROUP BY 
                                            a.id, a.downpaymentno, a.downpaymentdate, c.firstname, c.lastname, d.amount
                                        ORDER BY 
                                            a.id
        ", [$location_id])->result_array();
	}

	public function getDetailGeneralStockIn($id)
	{
		return $this->db_oriskin->query("SELECT 
                                            a.id,
											a.updateuserid, a.stockindate, a.remarks, a.updatedate, a.refferenceno, a.status, a.stockmovement, a.code,a.issuedby, a.producttype, a.supplierid, b.id AS fromlocationid, c.id as tolocationid
                                        FROM 
                                            msingredientsstockin a LEFT join pivotwarehouselocation b ON a.fromlocationid = b.locationid AND a.fromwarehouseid = b.warehouseid
											LEFT JOIN pivotwarehouselocation c ON a.tolocationid = c.locationid AND a.towarehouseid = c.warehouseid
                                        WHERE 
                                            a.id = ?
        ", [$id])->result_array();
	}

	public function getDetailStockIn($id)
	{
		return $this->db_oriskin->query("SELECT 
                                            a.id, a.stockinqty, b.name as INGREDIENTSNAME
                                        FROM 
                                            itemstockin a
										INNER JOIN msingredients b ON a.ingredientsid = b.id
                                        WHERE 
                                            a.stockinid = ?
        ", [$id])->result_array();
	}

	public function getCustomerDetail($id)
	{
		return $this->db_oriskin->query("SELECT
                                            a.firstname, a.lastname, a.customercode,
											a.cellphonenumber, a.id, a.email, a.ssid, a. dateofbirth,
											b.googlename, b.linkreview, b.employeeid
                                        FROM 
                                            mscustomer a left join mslinkreview b
											ON a.id = b.customerid
                                        WHERE
                                            a.id = ?
        ", [$id])->result_array();
	}

	public function getListEmployee()
	{
		$userid = $this->session->userdata('userid');

		return $this->db_oriskin->query("SELECT a.name as NAME, a.id as HDRID, 
										b.id as DTLID, a.cellphonenumber as CELLPHONENUMBER,
										a.code as EMPLOYEECODE, CASE 
											WHEN a.isactive = 0 THEN 'No'
											WHEN a.isactive = 1 THEN 'Yes'
										END AS PUBLISHED,
										c.name as LOCATIONNAME, d.name as JOBNAME, a.nip AS NIP,
										b.jobid as JOBID, b.locationid AS LOCATIONID,
										a.isactive as ISACTIVE,b.enddate, mcp.companyname
										from msemployee a 
										inner join msemployeedetail b on a.id = b.employeeid 
										inner join mslocation c on b.locationid = c.id
										inner join msjob d on b.jobid = d.id
										left join mscompany mcp on a.companyid = mcp.id
										WHERE b.locationid IN (SELECT locationid FROM msuser_location_access WHERE userid = $userid AND isactive = 1)
										-- AND a.isactive = 1    
        ")->result_array();
	}

	public function getListEmployeeAppointment()
	{
		$userid = $this->session->userdata('userid');
		$query = $this->db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
		$locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';

		$locationid = $this->session->userdata('locationid');
		$level = $this->session->userdata('level');

		if ($level == 4) {
			return $this->db_oriskin->query("SELECT		
										b.name as NAME, 
										a.id as EMPAPPTID, 
										b.code as EMPLOYEECODE, 
										CASE 
											WHEN a.isactive = 0 THEN 'No'
											WHEN a.isactive = 1 THEN 'Yes'
										END AS PUBLISHED,
										c.name as LOCATIONNAME, 
										d.name as JOBNAME
										from msemployeeappointment a 
										inner join msemployee b on a.employeeid = b.id
										inner join msemployeedetail f on a.employeeid = f.employeeid
										inner join mslocation c on a.locationid = c.id
										inner join msjob d on f.jobid = d.id
										where a.locationid IN ($locationAccsesIds)
        ")->result_array();
		} else {
			return $this->db_oriskin->query("SELECT		
										b.name as NAME, 
										a.id as EMPAPPTID, 
										b.code as EMPLOYEECODE, 
										CASE 
											WHEN a.isactive = 0 THEN 'No'
											WHEN a.isactive = 1 THEN 'Yes'
										END AS PUBLISHED,
										c.name as LOCATIONNAME, 
										d.name as JOBNAME
										from msemployeeappointment a 
										inner join msemployee b on a.employeeid = b.id
										inner join msemployeedetail f on a.employeeid = f.employeeid
										inner join mslocation c on a.locationid = c.id
										inner join msjob d on f.jobid = d.id
										where a.locationid = $locationid
        ")->result_array();
		}
	}

	public function getListEmployeeInvoice()
	{
		$userid = $this->session->userdata('userid');
		$query = $this->db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
		$locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';

		$locationid = $this->session->userdata('locationid');
		$level = $this->session->userdata('level');

		if ($level == 4) {
			return $this->db_oriskin->query("SELECT		
										b.name as NAME, 
										a.id as EMPAPPTID, 
										b.code as EMPLOYEECODE, 
										CASE 
											WHEN a.isactive = 0 THEN 'No'
											WHEN a.isactive = 1 THEN 'Yes'
										END AS PUBLISHED,
										c.name as LOCATIONNAME, 
										d.name as JOBNAME
										from msemployeeinvoice a 
										inner join msemployee b on a.employeeid = b.id
										inner join msemployeedetail f on a.employeeid = f.employeeid
										inner join mslocation c on a.locationid = c.id
										inner join msjob d on f.jobid = d.id
										where a.locationid IN ($locationAccsesIds)
        ")->result_array();
		} else {
			return $this->db_oriskin->query("SELECT		
										b.name as NAME, 
										a.id as EMPAPPTID, 
										b.code as EMPLOYEECODE, 
										CASE 
											WHEN a.isactive = 0 THEN 'No'
											WHEN a.isactive = 1 THEN 'Yes'
										END AS PUBLISHED,
										c.name as LOCATIONNAME, 
										d.name as JOBNAME
										from msemployeeinvoice a 
										inner join msemployee b on a.employeeid = b.id
										inner join msemployeedetail f on a.employeeid = f.employeeid
										inner join mslocation c on a.locationid = c.id
										inner join msjob d on f.jobid = d.id
										where a.locationid = $locationid
        ")->result_array();
		}
	}

	public function getEmployeeDetail($id)
	{
		return $this->db_oriskin->query("SELECT a.name as NAME, a.id as HDRID, 
										b.id as DTLID, a.cellphonenumber as CELLPHONENUMBER,
										a.code as EMPLOYEECODE, a.isactive AS PUBLISHED,
										b.locationid as LOCATIONID, b.jobid as JOBID, a.nip, a.sex,
										a.dateofbirth, a.placeofbirth, a.sallary, b.accountnumber,
										b.enddate, b.startdate, a.religionid, a.nik, a.defaultshiftid, a.isneedpresensi, a.companyid, b.address
										from msemployee a 
										inner join msemployeedetail b on a.id = b.employeeid 
										where a.id = ?
        ", [$id])->result_array();
	}

	public function getJobList()
	{
		return $this->db_oriskin->query("SELECT 
                                            *
                                        FROM 
                                            msjob WHERE isactive = 1
										
        ")->result_array();
	}

	public function getReligionList()
	{
		return $this->db_oriskin->query("SELECT 
                                            *
                                        FROM 
                                            msreligion
										
        ")->result_array();
	}

	public function getCityList()
	{
		return $this->db_oriskin->query("SELECT 
                                            *
                                        FROM 
                                            mscity
        ")->result_array();
	}

	public function getLocationList()
	{
		$userid = $this->session->userdata('userid');

		$query = $this->db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
		$locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';

		return $this->db_oriskin->query("SELECT DISTINCT id, name 
										FROM mslocation WHERE id IN ($locationAccsesIds)
        ")->result_array();
	}

	public function getDetailGeneralStockOut($id)
	{
		return $this->db_oriskin->query("SELECT 
                                            a.id,
											a.updateuserid, a.stockoutdate, a.remarks, a.updatedate, a.refferenceno, a.status, 
											a.stockmovement, a.code,a.issuedby, a.producttype, b.id AS fromlocationid, c.id as tolocationid
                                        FROM 
                                            msingredientsstockout a 
											LEFT join pivotwarehouselocation b ON a.fromlocationid = b.locationid AND a.fromwarehouseid = b.warehouseid
											LEFT JOIN pivotwarehouselocation c ON a.tolocationid = c.locationid AND a.towarehouseid = c.warehouseid
                                        WHERE 
                                            a.id = ?
        ", [$id])->result_array();
	}

	public function getDetailStockOut($id)
	{
		return $this->db_oriskin->query("SELECT 
                                            a.id, a.stockoutqty, b.name as INGREDIENTSNAME
                                        FROM 
                                            itemstockout a
										INNER JOIN msingredients b ON a.ingredientsid = b.id
                                        WHERE 
                                            a.stockoutid = ?
        ", [$id])->result_array();
	}

	public function getPackageDetail($id)
	{
		return $this->db_oriskin->query("SELECT b.productbenefitid as PRODUCTBENEFITID, a.id as ID, a.code, a.name, b.totalprice , a.isactive ,
											a.image, a.description,a.apps_name
										FROM msproductmembershiphdr a 
										INNER JOIN msproductmembershipdtl b ON a.id = b.id 
										WHERE a.id = ?
        ", [$id])->result_array();
	}

	public function getIngredientsDetail($id)
	{
		return $this->db_oriskin->query("SELECT a.*, b.name as uom
										FROM msingredients a
										INNER JOIN msunitingredients b ON a.unitid = b.id
										WHERE a.id = ?
        ", [$id])->result_array();
	}


	public function getRetailDetail($id)
	{
		return $this->db_oriskin->query("SELECT price1 , id , code , name , isactive,apps_name,image, description
										FROM msproduct
										WHERE id = ?
        ", [$id])->result_array();
	}


	public function getServiceDetail($id)
	{
		return $this->db_oriskin->query("SELECT price as PRICE, id as ID, code as CODE, name as NAME, isactive as ISACTIVE, treatmentgroupid, section, iscanfree,apps_name,image, description
										FROM mstreatment
										WHERE id = ?
        ", [$id])->result_array();
	}
	public function getCogsService($id)
	{
		return $this->db_oriskin->query("SELECT 
										a.price as PRICE, a.id as ID, b.code as CODE, b.name as NAME, a.qty as QTY, a.isactive
										FROM mstreatmentingredients a
										INNER JOIN msingredients b ON a.ingredientsid = b.id
										WHERE ingredientscategoryid = ?
        ", [$id])->result_array();
	}

	public function getServiceGroup()
	{
		return $this->db_oriskin->query("SELECT 
										id, name
										FROM mstreatmentgroup
        ")->result_array();
	}


	public function getBenefitPackage($id)
	{
		return $this->db_oriskin->query("SELECT a.price as PRICE, b.id as TRID, a.id as ID, b.code as CODE, b.name as NAME, a.treatmenttimespermonth as QTY, a.benefitcategoryid as BENEFITID 
										FROM msproductmembershipbenefit a 
										INNER JOIN mstreatment b on a.treatmentid = b.id 
										WHERE membershipbenefitid = ?
        ", [$id])->result_array();
	}

	public function get_type_list()
	{
		return $this->db_oriskin->query("
          select id, name from mstalenttype order by id
        ")->result_array();
	}

	public function getEmployeeStockOut($location_id, $level)
	{
		if ($level == 1) {
			return $this->db_oriskin->query("
          select a.id, a.name from msemployee a inner join msemployeedetail b on a.id = b.employeeid where (b.locationid = ? or a.title = 'PURCHASING') and a.isactive = 1
        ", [$location_id])->result_array();
		} else {
			return $this->db_oriskin->query("
			select a.id, a.name from msemployee a inner join msemployeedetail b on a.id = b.employeeid where (b.jobid = 20 or a.title = 'PURCHASING') and a.isactive = 1
		  ")->result_array();
		}
	}

	public function get_gender_list()
	{
		return $this->db_oriskin->query("
            select id, name from msgender  order by id
        ")->result_array();
	}

	public function get_province_list()
	{
		return $this->db_oriskin->query("
           	select id, name from msprovince  order by id
        ")->result_array();
	}

	public function get_talent_list()
	{
		return $this->db_oriskin->query("
            SELECT top 5000 id, name FROM msemployee order by id desc
        ")->result_array();
	}

	public function get_adv_list()
	{
		return $this->db_oriskin->query("
            select id, name from msguestlogadvtracking where isactive='true'  order by id
        ")->result_array();
	}

	function isExist($field, $value)
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);
		# query
		$sql = "SELECT COUNT(*) AS jumlah FROM slguestlog WHERE " . $field . " = '" . $value . "'";

		$jumlah = $db_oriskin->query($sql)->row()->jumlah;
		return ($jumlah > 0 ? true : false);
	}

	function insertTalent($post = "")
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$location_id = $this->session->userdata('locationid');
		$updateuserid = $this->session->userdata('userid');
		$sql = "SELECT shortcode as SHORTCODE FROM mslocation WHERE id = ?";
		$query = $db_oriskin->query($sql, [$location_id])->row();

		$shortcode = $query->SHORTCODE;

		$tahun = date('Y');
		$bulan = date('m');
		$tanggal = date('d');

		$customer_code = $shortcode . $tahun . $bulan . $tanggal;
		$data = [
			'firstname' => $post['firstname'],
			'lastname' => $post['lastname'],
			'cellphonenumber' => $post['cellphonenumber'],
			'ssid' => $post['ssid'],
			'email' => $post['email'],
			'dateofbirth' => $post['dateofbirth'],
			'sex' => $post['sex'],
			'refferalempid' => 1,
			'locationid' => $location_id,
			'updateuserid' => $updateuserid,
			'guestlogtypeid' => 11,
			'guestlogadvtrackingid' => $post['guestlogadvtrackingid'],
			'consultantid' => 1,
			'touredid' => 1,
			'code' => $customer_code
		];
		$insert = $db_oriskin->insert('slguestlog', $data);
		if ($db_oriskin->affected_rows() > 0) {
			$existing_id = $db_oriskin->insert_id();
			if ($existing_id) {
				return true;
			} else {
				$error = $db_oriskin->error();
				return $error['message'];
			}
		}
	}

	function insertTalentMarketing($post = "")
	{
		$db_oriskin = $this->load->database('oriskin', true);

		$updateuserid = $this->session->userdata('userid');


		$sql = "SELECT shortcode as SHORTCODE FROM mslocation WHERE id = ?";
		$query = $db_oriskin->query($sql, [$post['locationId']])->row();

		$shortcode = $query->SHORTCODE;


		$tahun = date('Y'); // Tahun 4 digit (e.g., 2023)
		$bulan = date('m'); // Bulan 2 digit (e.g., 01 untuk Januari)
		$tanggal = date('d'); // Tanggal 2 digit (e.g., 01)

		// Gabungkan shortcode dengan tahun, bulan, dan tanggal
		$customer_code = $shortcode . $tahun . $bulan . $tanggal;


		// Data yang akan di-insert
		$data = [
			'firstname' => $post['firstname'],
			'lastname' => $post['lastname'],
			'cellphonenumber' => $post['cellphonenumber'],
			'ssid' => $post['ssid'],
			'email' => $post['email'],
			'dateofbirth' => $post['dateofbirth'],
			'sex' => $post['sex'],
			'refferalempid' => 1,
			'locationid' => $post['locationId'],
			'updateuserid' => $updateuserid,
			'guestlogtypeid' => 11,
			'guestlogadvtrackingid' => $post['guestlogadvtrackingid'],
			'consultantid' => 1,
			'touredid' => 1,
			'code' => $customer_code
		];

		// Insert menggunakan Query Builder
		$insert = $db_oriskin->insert('slguestlog', $data);


		if ($db_oriskin->affected_rows() > 0) {
			$existing_id = $db_oriskin->insert_id();
			// return $existing_id ? true : false;
			if ($existing_id) {
				return true;
			} else {
				$error = $db_oriskin->error();
				return $error['message'];
			}
		}
	}

	public function getReportGuestOnlineAdminCso($dateStart, $dateEnd, $userType)
	{
		$query = "Exec spReportSummaryByGuestOnlineCSOEudoraDev ?, ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, $userType, 0])->result_array();
	}

	public function getReportCustomerTrial($locationid)
	{
		$query = "Exec [spClinicCustomerTrialEudora] ?";
		return $this->db_oriskin->query($query, [$locationid])->result_array();
	}

	public function getReportGuestShow($dateStart, $dateEnd)
	{
		$userid = $this->session->userdata('userid');

		$query = "Exec [spReportGuestDetailClinic] ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid, 1])->result_array();
	}

	public function getEmployeeRefferal($dateStart, $dateEnd)
	{
		$userid = $this->session->userdata('userid');
		$query = "Exec [spReportGuestDetailClinic] ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid, 3])->result_array();
	}

	public function getReportTopSpender($dateStart, $dateEnd)
	{
		$userid = $this->session->userdata('userid');
		$query = "Exec [spReportGuestDetailClinic] ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid, 4])->result_array();
	}


	public function getReportUsedIngridients($dateStart, $dateEnd)
	{
		$query = "Exec spReportUsedIngredients ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, 1])->result_array();
	}

	public function getReportUsedIngridientsIncludeCost($dateStart, $dateEnd)
	{
		$query = "Exec spReportUsedIngredientsIncludeCostEudora ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, 1])->result_array();
	}

	public function getIngridientsPrepaidIncludeCost($dateStart, $dateEnd)
	{
		$query = "Exec spReportUsedIngredientsIncludeCostEudora ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, 1])->result_array();
	}

	public function getTreatmentPrepaid($dateStart, $dateEnd)
	{
		$query = "Exec spReportUsedIngredients ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, 2])->result_array();
	}

	public function getIngridientsPrepaid($dateStart, $dateEnd)
	{
		$query = "Exec spReportUsedIngredients ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, 3])->result_array();
	}



	public function getReportGuestShowSummary($dateStart, $dateEnd)
	{
		$userid = $this->session->userdata('userid');
		$query = "Exec [spReportGuestDetailClinic] ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid, 2])->result_array();
	}


	public function getReportGuestEvent($dateStart, $dateEnd, $locationId, $userType)
	{
		$userid = $this->session->userdata('userid');
		$query = "Exec spReportGuestEventDetail ?, ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid, $locationId, $userType])->result_array();
	}

	public function getReportNewCustomer($dateStart, $dateEnd, $userid, $locationId, $userType)
	{
		$query = "Exec [spReportGuestEventDetail] ?, ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid, $locationId, $userType])->result_array();
	}

	public function getReportGuestOnlineAdminCsoSummary($dateStart, $dateEnd, $userType)
	{
		$query = "Exec spReportSummaryByGuestOnlineCSOEudoraDevSummary ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, $userType])->result_array();
	}

	public function getReportGuestEventSummary($dateStart, $dateEnd, $locationId, $userType)
	{
		$userid = $this->session->userdata('userid');
		$query = "Exec spReportGuestEventDetail ?, ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid, $locationId, $userType])->result_array();
	}

	public function getReportGuestEventSummaryManager($dateStart, $dateEnd, $locationId, $userType)
	{
		$userid = $this->session->userdata('userid');
		$query = "Exec spReportGuestEventDetail ?, ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid, $locationId, $userType])->result_array();
	}

	public function getReportCallAppt($period, $locationid, $type)
	{
		$query = "Exec spReportCallApptEU ?, ?, ?";
		return $this->db_oriskin->query($query, [$period, $locationid, $type])->result_array();
	}

	public function getGuestFromLinkRefferal($locationId)
	{
		$query = "Exec spReportGuestFromLinkRangeDateAllClinic ?";
		return $this->db_oriskin->query($query, [$locationId])->result_array();
	}

	public function getPrepaidCustomerMembershipBenefit($customerId)
	{
		$query = "Exec spClinicFindHistoryMembershipTreatmentDtlBenefitCategory ?";
		return $this->db_oriskin->query($query, [$customerId])->result_array();
	}

	public function getPrepaidCustomerMembershipForExchange($customerId)
	{
		$query = "Exec spClinicFindHistoryMembershipTreatmentDtl_FR_INJECT ?";
		return $this->db_oriskin->query($query, [$customerId])->result_array();
	}


	public function getReportGuestOnlineAdminCsoByRegister($dateStart, $dateEnd, $userType)
	{
		$locationId = $this->session->userdata('locationid');
		$query = "Exec spReportSummaryByGuestOnlineCSOEudoraByRegister ?, ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, $userType, $locationId])->result_array();
	}

	public function getReportNewGuestNoAppointment($dateStart, $dateEnd)
	{

		$userid = $this->session->userdata('userid');

		// Kalau userid antara 44 - 48, pakai 1
		if ($userid >= 44 && $userid <= 48) {
			$userid = 1;
		}
		$query = "Exec spEudoraReportNewGuestNoAppointmentByRegister ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid])->result_array();
	}

	public function getSummaryRevenueBySales($dateStart, $dateEnd, $userid)
	{
		$query = "Exec SpRevenuebySales  ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid])->result_array();
	}

	public function getSummaryRevenueBySalesIncludeCommission($period, $userid)
	{

		if ($period >= '2025-08') {
			$query = "Exec SpEudoraRevenuebySalesIncludeCommission ?, ?, ?";
			return $this->db_oriskin->query($query, [$period, $userid, 1])->result_array();
		} else {
			$query = "Exec SpRevenuebySalesIncludeCommission ?, ?";
			return $this->db_oriskin->query($query, [$period, $userid])->result_array();
		}


	}



	public function getSummaryCommissionOm($period, $userid)
	{
		$query = "Exec SpCommissionOperationalManagerEudora ?, ?, ?";
		return $this->db_oriskin->query($query, [$period, $userid, 1])->result_array();
	}

	public function getReportHandWorkCommissionDokterTherapist($dateStart, $dateEnd, $loationId)
	{
		$query = "Exec spDetailRevenuDoingDev   ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $loationId])->result_array();
	}

	public function getReportHandWorkCommissionDokterTherapistPerMey2025($dateStart, $dateEnd, $loationId)
	{
		$query = "Exec spDetailCommissionDoingTreatmentRangeDatePerClinicDev   ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $loationId])->result_array();
	}

	public function getReportSummaryHandWork($dateStart, $dateEnd, $loationId)
	{
		$query = "Exec spDetailRevenuDoingSummary   ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $loationId])->result_array();
	}

	public function getReportSummaryHandWorkPerMey2025($dateStart, $dateEnd, $loationId)
	{
		$query = "Exec spDetailCommissionDoingTreatmentRangeDatePerClinicSummaryDev   ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $loationId, 1])->result_array();
	}

	public function getCustomerByLastDoing($dateStart, $dateEnd, $loationId)
	{
		$query = "Exec spReportCallApptEUCustomerWithNoPrepaid   ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $loationId])->result_array();
	}

	public function getReportCommissionApptShow($period, $loationId)
	{
		$query = "Exec spEudoraCommissionTherapistAndCso   ?, ?";
		return $this->db_oriskin->query($query, [$period, $loationId])->result_array();
	}

	public function getReportPrescriptionDoctor($dateStart, $dateEnd, $userid)
	{
		$query = "Exec SpPreceptionDocterDetail   ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid])->result_array();
	}

	public function getReportPrescriptionDoctorSummary($dateStart, $dateEnd, $userid)
	{
		$query = "Exec SpPreceptionDocterSummary   ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid])->result_array();
	}

	public function getReportHandWorkCommissionTherapist($dateStart, $dateEnd, $loationId)
	{
		$query = "Exec spDetailRevenueDoingTherapist   ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $loationId])->result_array();
	}


	public function getReportDoingNotInInvoiceLocation($dateStart, $dateEnd, $userid)
	{
		$query = "Exec SpReportDoingNotInInvoiceLocationEudora  ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid])->result_array();
	}

	public function getReportAppointmentDoingByClinic($period, $userid)
	{
		$query = "Exec SpReportApptDoingbycLINIC  ?, ?";
		return $this->db_oriskin->query($query, [$period, $userid])->result_array();
	}

	public function getDetailRevenueBySales($dateStart, $dateEnd, $userid)
	{
		$query = "Exec SpRevenuebySalesDetail  ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid])->result_array();
	}

	public function getDetailRevenueBySalesIncludeCommission($period, $userid)
	{
		$query = "Exec SpRevenuebySalesDetailIncludeCommission  ?, ?";
		return $this->db_oriskin->query($query, [$period, $userid])->result_array();
	}


	public function getDetailUnitNewMember($period, $userid)
	{
		if ($period >= '2025-08') {
			$query = "Exec SpEudoraRevenuebySalesIncludeCommission ?, ?, ?";
			return $this->db_oriskin->query($query, [$period, $userid, 2])->result_array();
		} else {
			$query = "Exec SpReportDetailNewMemberEudora  ?, ?";
			return $this->db_oriskin->query($query, [$period, $userid])->result_array();
		}
	}

	public function getSaleTicketDetail($dateStart, $dateEnd, $userid)
	{
		$level = $this->session->userdata('level');

		if ($level == 4) {
			$query = "Exec SpSaleTicketDetail  ?, ?, ?, 2";
			return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid])->result_array();
		} else {
			$query = "Exec SpSaleTicketDetail  ?, ?, ?, 1";
			return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid])->result_array();
		}

	}

	public function getServiceSales($dateStart, $dateEnd, $type)
	{
		$query = "Exec spReportServiceSales ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $type])->result_array();
	}

	public function getReportGuestMarketing($dateStart, $dateEnd)
	{
		$query = "Exec spReportSummaryByGuestOnlineCSOEudora ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, 1])->result_array();
	}

	public function getReportGuestMarketingSummary($dateStart, $dateEnd)
	{
		$query = "Exec spReportSummaryByGuestOnlineCSOEudora ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, 2])->result_array();
	}

	public function getReportGuestMarketingForClinic($dateStart, $dateEnd)
	{
		$locationId = $this->session->userdata('locationid');
		$query = "Exec spReportSummaryByGuestOnlineCSOEudoraForClinic ?, ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, $locationId, 1])->result_array();
	}

	public function getReportGuestMarketingForClinicSummary($dateStart, $dateEnd)
	{
		$locationId = $this->session->userdata('locationid');
		$query = "Exec spReportSummaryByGuestOnlineCSOEudoraForClinic ?, ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, $locationId, 2])->result_array();
	}

	public function getReportGuestAffiliate($dateStart, $dateEnd, $empId)
	{
		$query = "Exec spReportSummaryByGuestOnlineCSOEudoraAffiliate ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, $empId])->result_array();
	}

	public function getReportReviewSummary($dateStart, $dateEnd)
	{
		$userid = $this->session->userdata('userid');
		$query = "Exec [spClinicFilledLinkReview]  ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 4, $userid])->result_array();
	}

	public function getReportReviewNotReview($dateStart, $dateEnd)
	{
		$userid = $this->session->userdata('userid');
		$query = "Exec [spClinicFilledLinkReview]  ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 3, $userid])->result_array();
	}

	public function getReportReviewReview($dateStart, $dateEnd)
	{
		$userid = $this->session->userdata('userid');
		$query = "Exec [spClinicFilledLinkReview]  ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 2, $userid])->result_array();
	}

	public function getReportReviewReviewByDate($dateStart, $dateEnd)
	{
		$userid = $this->session->userdata('userid');
		$query = "Exec [spClinicFilledLinkReview]  ?, ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, 1, $userid])->result_array();
	}

	function updateInvoiceMembershipHdr($post = "")
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$sql = "UPDATE slinvoicemembershiphdr
				SET invoicedate = '" . $post['invoicedate'] . "', status = '" . $post['status'] . "'
				WHERE id = " . $post['id'];

		$query = $db_oriskin->query($sql);
		return 'Data berhasil disimpan.';
	}

	function updateInvoiceMembershipDtl($post = "")
	{
		$db_oriskin = $this->load->database('oriskin', true);

		$sql = "UPDATE slinvoicemembershipdtl
				SET enddate = '" . $post['enddate'] . "', activationdate = '" . $post['activationdate'] . "'
				WHERE id = " . $post['id'];

		$query = $db_oriskin->query($sql);
		return 'Data berhasil disimpan.';
	}

	function updateInvoiceTreatment($post = "")
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);
		# query
		$sql = "UPDATE slinvoicetreatmenthdr
				SET invoiceno = '" . $post['invoiceno'] . "', invoicedate = '" . $post['invoicedate'] . "', status = '" . $post['status'] . "'
				WHERE id = " . $post['id'];

		$query = $db_oriskin->query($sql);
		return 'Data berhasil disimpan.';
	}
	function updateInvoiceProduct($post = "")
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);
		# query
		$sql = "UPDATE slinvoicehdr
					SET invoiceno = '" . $post['invoiceno'] . "', invoicedate = '" . $post['invoicedate'] . "', status = '" . $post['status'] . "'
					WHERE id = " . $post['id'];

		$query = $db_oriskin->query($sql);
		return 'Data berhasil disimpan.';
	}

	function updateInvoiceDpTreatment($post = "")
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);
		# query
		$sql = "UPDATE sldownpaymenttreatmenthdr
			SET downpaymentdate = '" . $post['downpaymentdate'] . "', status = '" . $post['status'] . "'
			WHERE id = " . $post['id'];

		$query = $db_oriskin->query($sql);
		return 'Data berhasil disimpan.';
	}

	function updateInvoiceDpMembership($post = "")
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);
		# query
		$sql = "UPDATE sldownpaymentmembershiphdr
			SET downpaymentdate = '" . $post['downpaymentdate'] . "', status = '" . $post['status'] . "'
			WHERE id = " . $post['id'];

		$query = $db_oriskin->query($sql);
		return 'Data berhasil disimpan.';
	}
	function updateInvoiceDpProduct($post = "")
	{
		# load database oriskin
		# lihat di config/database.php
		$db_oriskin = $this->load->database('oriskin', true);
		# query
		$sql = "UPDATE sldownpaymentproducthdr
			SET downpaymentdate = '" . $post['downpaymentdate'] . "', status = '" . $post['status'] . "'
			WHERE id = " . $post['id'];

		$query = $db_oriskin->query($sql);
		return 'Data berhasil disimpan.';
	}


	public function search_customers($search)
	{


		$this->db_oriskin->select('id, firstname, lastname, cellphonenumber, customercode, membercode');
		$this->db_oriskin->from('mscustomer');
		$this->db_oriskin->where("(firstname LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR lastname LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR cellphonenumber LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
								 OR membercode LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR customercode LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
		$this->db_oriskin->order_by('membercode', 'ASC');
		$this->db_oriskin->limit(50); // Batasi hasil agar lebih cepat
		return $this->db_oriskin->get()->result();
	}

	public function search_city($search)
	{


		$this->db_oriskin->select('id, name');
		$this->db_oriskin->from('mscity');
		$this->db_oriskin->where("(name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
		$this->db_oriskin->order_by('provinceid', 'ASC');
		$this->db_oriskin->limit(50);
		return $this->db_oriskin->get()->result();
	}

	public function get_item_by_id($id)
	{
		return $this->db_oriskin->select('id, code, name')
			->from('msingredients')
			->where('id', $id)
			->where('isactive', 1)
			->get()
			->row();
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

	public function searchServices($search)
	{
		$this->db_oriskin->select('id, code, name, price, ingredientscategoryid');
		$this->db_oriskin->from('mstreatment');
		// $this->db_oriskin->where('isactive', 1);
		$this->db_oriskin->where("(code LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
		$this->db_oriskin->order_by('code', 'ASC');

		$this->db_oriskin->limit(50); // Batasi hasil agar lebih cepat
		return $this->db_oriskin->get()->result();
	}

	public function searchRetail($search)
	{
		$this->db_oriskin->select('id, code, name');
		$this->db_oriskin->from('msproduct');
		$this->db_oriskin->where('isactive', 1);
		$this->db_oriskin->where("(code LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
		$this->db_oriskin->order_by('code', 'ASC');
		$this->db_oriskin->limit(50); // Batasi hasil agar lebih cepat
		return $this->db_oriskin->get()->result();
	}

	public function searchLocation($search)
	{
		$this->db_oriskin->select('id, name, shortcode');
		$this->db_oriskin->from('mslocation');
		$this->db_oriskin->where('isactive', 1);
		$this->db_oriskin->where('id !=', 6);
		$this->db_oriskin->where("(name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR shortcode LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
		$this->db_oriskin->order_by('name', 'ASC');
		$this->db_oriskin->limit(50);
		return $this->db_oriskin->get()->result();
	}

	public function searchConsultant($search)
	{
		$this->db_oriskin->select('e.id, e.name as name, ef.name as locationname');
		$this->db_oriskin->from('msemployee e');
		$this->db_oriskin->join('msemployeedetail ed', 'e.id = ed.employeeid', 'inner');
		$this->db_oriskin->join('mslocation ef', 'ed.locationid = ef.id', 'inner');
		$this->db_oriskin->where('e.isactive', 1);
		$this->db_oriskin->where('ed.locationid !=', 6);
		$this->db_oriskin->where("(e.name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
		$this->db_oriskin->order_by('e.name', 'ASC');
		$this->db_oriskin->limit(50);
		return $this->db_oriskin->get()->result();
	}


	public function searchServicesCogs($search)
	{
		$this->db_oriskin->distinct();
		$this->db_oriskin->select('mt.id, mt.code, mt.name, mt.price, mt.ingredientscategoryid');
		$this->db_oriskin->from('mstreatment mt');
		$this->db_oriskin->join('mstreatmentingredients mti', 'mt.ingredientscategoryid = mti.ingredientscategoryid', 'inner');
		$this->db_oriskin->group_start();
		$this->db_oriskin->like('mt.code', $search);
		$this->db_oriskin->or_like('mt.name', $search);
		$this->db_oriskin->group_end();
		$this->db_oriskin->order_by('mt.code', 'ASC');
		$this->db_oriskin->limit(50);
		return $this->db_oriskin->get()->result();
	}


	public function searchSalon($search)
	{
		$this->db_oriskin->select('id, code, name, price');
		$this->db_oriskin->from('msingredients');
		$this->db_oriskin->where("(code LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
		$this->db_oriskin->order_by('code', 'ASC');
		$this->db_oriskin->limit(50); // Batasi hasil agar lebih cepat
		return $this->db_oriskin->get()->result();
	}

	public function searchPaymentMethod($search)
	{
		$this->db_oriskin->select('id, name');
		$this->db_oriskin->from('mspaymenttype');
		$this->db_oriskin->where('isactive', 1);
		$this->db_oriskin->where("(name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
		$this->db_oriskin->order_by('name', 'ASC');
		$this->db_oriskin->limit(50);
		return $this->db_oriskin->get()->result();
	}

	public function addAppointment($data)
	{
		$treatmentToday = date('Y-m-d');
		$customerid = $data['customerid'];
		$appointmentdate = $data['appointmentdate'];
		$userid = $this->session->userdata('userid');

		$existing = $this->db_oriskin->get_where('trbookappointment', [
			'appointmentdate' => $treatmentToday,
			'customerid' => $customerid
		])->row();

		if ($this->db_oriskin->insert("trbookappointment", $data)) {
			$insert_id = $this->db_oriskin->insert_id();
			$dataPoint = [
				'bookingid' => $insert_id,
				'customerid' => $customerid,
				'point' => 10000,
				'status' => 1,
				'createbyuserid' => $userid
			];
			if ($existing) {
				if ($appointmentdate > $treatmentToday) {
					$this->db_oriskin->insert('mspointnextappointment', $dataPoint);
					return ["status" => "success", "message" => "Appointment berhasil ditambahkan. dan customer mendapatkan point dari next appointment"];
				} else {
					return ["status" => "success", "message" => "Appointment berhasil ditambahkan"];
				}
			} else {
				return ["status" => "success", "message" => "Appointment berhasil ditambahkan"];
			}
		} else {
			return ["status" => "error", "message" => "Gagal menambahkan appointment."];
		}
	}


	public function updateAppointment($id, $data)
	{
		$treatmentToday = date('Y-m-d');
		$customerid = $data['customerid'];
		$appointmentdate = $data['appointmentdate'];
		$userid = $this->session->userdata('userid');

		$existingApptToday = $this->db_oriskin->get_where('trbookappointment', [
			'appointmentdate' => $treatmentToday,
			'customerid' => $customerid
		])->row();

		$existingPointNextApptWithCustomerId = $this->db_oriskin->get_where('mspointnextappointment', [
			'bookingid' => $id,
			'customerid' => $customerid
		])->row();

		$existingPointNextApptWithOutCustomerId = $this->db_oriskin->get_where('mspointnextappointment', [
			'bookingid' => $id
		])->row();

		$this->db_oriskin->where("id", $id);

		if ($this->db_oriskin->update("trbookappointment", $data)) {
			if ($existingPointNextApptWithCustomerId && $existingPointNextApptWithOutCustomerId) {
				$dataUpdatePoint = ['status' => $data['status']];
				$this->db_oriskin->where("bookingid", $id);
				$this->db_oriskin->update("mspointnextappointment", $dataUpdatePoint);
				return ["status" => "success", "message" => "Appointment berhasil diperbarui."];
			} else if (!$existingPointNextApptWithCustomerId && $existingPointNextApptWithOutCustomerId) {

				$dataPointUpdate = [
					'customerid' => $customerid,
					'status' => $data['status'],
					'updateuserid' => $userid,
					'updatedate' => date('Y-m-d H:i:s')
				];

				if ($existingApptToday) {
					if ($appointmentdate > $treatmentToday) {
						$this->db_oriskin->where("bookingid", $id);
						$this->db_oriskin->update('mspointnextappointment', $dataPointUpdate);
						return ["status" => "success", "message" => "Appointment berhasil diperbarui. Customer mendapatkan point dari next appointment 1"];
					} else {
						return ["status" => "success", "message" => "Appointment berhasil diperbarui"];
					}
				} else {
					$dataUpdatePoint = ['status' => 3];
					$this->db_oriskin->where("bookingid", $id);
					$this->db_oriskin->update("mspointnextappointment", $dataUpdatePoint);
					return ["status" => "success", "message" => "Appointment berhasil diperbarui"];
				}
			} else {
				$dataPoint = [
					'bookingid' => $id,
					'customerid' => $customerid,
					'point' => 10000,
					'status' => 1,
					'createbyuserid' => $userid
				];
				if ($existingApptToday) {
					if ($appointmentdate > $treatmentToday) {
						$this->db_oriskin->insert('mspointnextappointment', $dataPoint);
						return ["status" => "success", "message" => "Appointment berhasil diperbarui. Customer mendapatkan point dari next appointment 2"];
					} else {
						return ["status" => "success", "message" => "Appointment berhasil diperbarui"];
					}
				} else {
					return ["status" => "success", "message" => "Appointment berhasil diperbarui"];
				}
			}
		} else {
			return ["status" => "error", "message" => "Gagal memperbarui appointment."];
		}
	}
	public function getPrepaidCustomerMembership($customerId)
	{
		$query = "Exec spClinicFindHistoryMembershipTreatmentDtlDev ?";
		return $this->db_oriskin->query($query, [$customerId])->result_array();
	}

	public function getPrepaidCustomerTreatment($customerId)
	{
		$query = "Exec spClinicFindHistoryTreatmentDtl ?";
		return $this->db_oriskin->query($query, [$customerId])->result_array();
	}

	public function getPrepaidCustomerTreatmentDev($customerId)
	{
		$query = "Exec spClinicFindHistoryTreatmentDtlDev ?";
		return $this->db_oriskin->query($query, [$customerId])->result_array();
	}

	public function getPrepaidCustomerHistory($customerId)
	{
		$query = "Exec spClinicFindHistoryTreatmentMemberErm ?";
		return $this->db_oriskin->query($query, [$customerId])->result_array();
	}

	public function getAppointmentDetail($appointmentId)
	{
		$query = "
				SELECT a.appointmentdate AS TREATMENTDATE, 
				a.booktime AS START, 
				COALESCE(b.firstname, '') + ' ' + COALESCE(b.lastname, '') AS CUSTOMERNAME,
				COALESCE(NULLIF(b.cellphonenumber, ''), '-') AS CELLPHONENUMBER,
				c.name AS LOCATIONNAME,
				d.name AS EMPLOYEENAME,
				a.status AS STATUS,
				b.customercode as CUSTOMERCODE,
				d.id as EMPLOYEEID,
				b.id as CUSTOMERID,
				e.name AS CREATEBY,
				f.name AS UPDATEBY,
				a.createdate AS CREATETIME,
				a.updatedate AS LASTMODIFIED,
				g.googlename AS GOOGLENAME,
				g.linkreview AS LINKREVIEW,
				h.id AS STAFFID,
				h.name AS STAFFNAME
			FROM trbookappointment a
			INNER JOIN mscustomer b ON a.customerid = b.id
			INNER JOIN mslocation c ON a.locationid = c.id
			LEFT JOIN msemployee d ON a.employeeid = d.id
			LEFT JOIN msuser e ON a.createbyuserid = e.id
			LEFT JOIN msuser f ON a.updateuserid = f.id
			LEFT JOIN mslinkreview g ON b.id = g.customerid
			LEFT JOIN msemployee h ON g.employeeid = h.id
			WHERE a.id = ?
        ";


		return $this->db_oriskin->query($query, [$appointmentId])->result_array();
	}

	public function detailPrepaidConsumption($appointmentId)
	{
		$query = "SELECT 
						a.invoiceno as INVOICENO, 
						b.name as TREATMENTNAME, 
						a.qty as QTY, 
						c.name as ASSISTBY,
						a.id as ID,
						d.status as STATUS,
						d.id as BOOKINGID,
						e.name as DOINGBY,
						a.treatmentdoingbyid as DOINGBYID,
						a.treatmentassistbyid as ASSISTBYID,
						CONVERT(VARCHAR(10), d.appointmentdate, 120) AS APPOINTMENTDATE,
						g.id as treatmentidchange,
						f.qty as qtychange,
						g.name as treatmentchangename,
						f.remarks as remarks,
						f.status as statuschange,
						a.status_finger_customer
						from trdoingtreatment a 
						inner join mstreatment b on a.producttreatmentid = b.id 
						left join msemployee c on a.treatmentassistbyid = c.id
						inner join trbookappointment d on d.id = a.bookingid
						inner join msemployee e on a.treatmentdoingbyid = e.id
						left join mschangetreatmentprepaid f on a.id = f.doingid
						left join mstreatment g on f.treatmentid = g.id
						where bookingid = ? and a.status <> 3
        ";

		return $this->db_oriskin->query($query, [$appointmentId])->result_array();
	}

	public function prepaidFinished($dateYesterday, $locationid)
	{
		$query = "EXEC spGetPrepaidFinishedYesterday ?, ?";

		return $this->db_oriskin->query($query, [$dateYesterday, $locationid])->result_array();
	}

	public function getFrontdeskPrepaid($locationId)
	{

		if ($locationId == 36 || $locationId == 48) {
			$query = "SELECT 
						a.id, a.name, b.locationid FROM msemployee a
						INNER JOIN msemployeedetail b ON a.id = b.employeeid
						INNER JOIN msjob c ON b.jobid = c.id
						WHERE a.isactive = 1
						AND locationid = ?
						AND (c.name like '%FRONT DESK%' OR c.name like '%BEAUTY CONSULTANT%')
						ORDER BY a.name

		
        ";

		} else {
			$query = "SELECT 
						a.id, a.name, b.locationid FROM msemployee a
						INNER JOIN msemployeedetail b ON a.id = b.employeeid
						INNER JOIN msjob c ON b.jobid = c.id
						WHERE a.isactive = 1
						AND locationid = ?
						AND c.name like '%FRONT DESK%'
						ORDER BY a.name
        ";

		}
		return $this->db_oriskin->query($query, [$locationId])->result_array();
	}

	public function getStaffHandWork($dateStart, $dateEnd, $locationId)
	{
		$query = "SELECT 
						DISTINCT b.id, b.name as name FROM trdoingtreatment a
						INNER JOIN msemployee b on a.treatmentdoingbyid = b.id
						WHERE (CONVERT(VARCHAR(10), treatmentdate,120) BETWEEN ? AND ?) AND a.locationid = ?
        ";

		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $locationId])->result_array();
	}

	public function getTargetConsultant($period)
	{
		$query = "SELECT 
						a.id AS ID, b.name as CONSULTANTNAME, a.period AS PERIOD, a.target AS TARGET, a.targetunit AS TARGETUNIT, d.name AS LOCATION,
						d.id AS LOCATIONID, a.statusConsultant, a.job
						FROM mstargetconsultant a
						INNER JOIN msemployee b on a.employeeid = b.id
						INNER JOIN mslocation d ON a.locationid = d.id
						WHERE (CONVERT(VARCHAR(7), a.period ,120) = ?)
        ";
		return $this->db_oriskin->query($query, [$period])->result_array();
	}

	public function getTargetOutlet($period)
	{
		$query = "SELECT 
						a.id AS ID, b.name as LOCATIONNAME, a.period AS PERIOD, a.targetbep AS TARGET, a.targetunit AS TARGETUNIT FROM mstarget a
						INNER JOIN mslocation b on a.locationid = b.id
						WHERE (CONVERT(VARCHAR(7), a.period ,120) = ?)
        ";
		return $this->db_oriskin->query($query, [$period])->result_array();
	}


	public function getStaffSalesInvoice($dateStart, $dateEnd, $userid)
	{
		$query = "Exec SpGetStaffSalesInvoice ?, ?, ?";
		return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid])->result_array();
	}



	public function getAssistPrepaid($locationId, $employeeid)
	{
		$level = $this->session->userdata('level');

		if ($level == 1) {
			$query = "SELECT 
						b.id, b.name FROM msemployeeappointment a
						INNER JOIN msemployee b ON a.employeeid = b.id
						INNER JOIN msemployeedetail c ON b.id = c.employeeid
						WHERE a.isactive = 1
						AND a.locationid = ?
						AND c.jobid in(6,72)
						AND a.employeeid not in ($employeeid)
						ORDER BY b.name
        ";
			return $this->db_oriskin->query($query, [$locationId])->result_array();
		} else {
			$query = "SELECT 
						b.id, b.name FROM msemployeeappointment a
						INNER JOIN msemployee b ON a.employeeid = b.id
						INNER JOIN msemployeedetail c ON b.id = c.employeeid
						WHERE a.isactive = 1
						AND a.locationid = ?
						AND c.jobid in(6,72)
						ORDER BY b.name
        ";
			return $this->db_oriskin->query($query, [$locationId])->result_array();
		}
	}

	public function getEmployeeDoing($locationId)
	{
		$query = "SELECT 
						a.id, a.name FROM msemployee a
						LEFT JOIN msemployeeappointment b ON a.id = b.employeeid
						WHERE (b.isactive = 1
						AND b.locationid = ? OR a.id = 388)
						ORDER BY a.name
        ";

		return $this->db_oriskin->query($query, [$locationId])->result_array();
	}


	public function getDetailPackage($packageid)
	{
		$query = "SELECT 
						treatmenttimespermonth AS TTPM, 
							benefitcategoryid AS BCID, 
							STRING_AGG(treatmentname, ' / ') AS TRNAME
						FROM msproductmembershipbenefit a inner join msproductmembershipdtl b on a.membershipbenefitid = b.productbenefitid
						WHERE b.id = ? and treatmentid <> 0
						GROUP BY treatmenttimespermonth, benefitcategoryid
        ";

		return $this->db_oriskin->query($query, [$packageid])->result_array();
	}


	public function getEmployeeAffiliate()
	{
		$query = "SELECT 
					b.fromemployeeid as FROMEMPLOYEEID, c.name as FROMEMPLOYEENAME, a.id AS ID, a.name as NAME, b.startdate as DATEJOIN, b.accountnumber as ACCOUNTNUMBER,
					CASE 
						WHEN a.isactive = 1 THEN 'Aktif'
						WHEN a.isactive = 0 THEN 'Nonaktif'
					END AS STATUS,
					a.isactive as STATUSID
					FROM msemployee a 
					inner join msemployeedetail b on a.id = b.employeeid
					LEFT JOIN msemployee c ON b.fromemployeeid = c.id 
					where a.title = 'AFFILIATE' and a.isactive = 1
					ORDER BY a.id
        ";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getEmployeeMarketing()
	{
		$query = "SELECT 
					a.id as ID, a.name as NAME, c.name as LOCATIONNAME
					FROM msemployee a INNER JOIN msemployeedetail b ON a.id = b.employeeid
					INNER JOIN mslocation c ON b.locationid = c.id
					WHERE a.isactive = 1 AND jobid = 4
					ORDER BY c.id
        ";
		return $this->db_oriskin->query($query)->result_array();
	}
	public function getEmployeeForAppointment($search)
	{
		$locationId = $this->session->userdata('locationid');
		$level = $this->session->userdata('level');
		$searchParam = '%' . $this->db_oriskin->escape_like_str($search) . '%';

		if ($level == 1) {
			$sql = "SELECT 
					a.id as EMPLOYEEID, a.name as NAME, b.locationid as LOCATIONID, c.name as LOCATIONNAME
				FROM msemployee a 
				INNER JOIN msemployeedetail b ON a.id = b.employeeid
				INNER JOIN mslocation c ON b.locationid = c.id
				WHERE b.locationid = ? 
				AND b.jobid IN (6, 12, 72) 
				AND a.isactive = 1
				AND a.name LIKE ?
				ORDER BY a.id";
			return $this->db_oriskin->query($sql, [$locationId, $searchParam])->result_array();
		} else {
			$sql = "SELECT 
					a.id as EMPLOYEEID, a.name as NAME, b.locationid as LOCATIONID, c.name as LOCATIONNAME
				FROM msemployee a 
				INNER JOIN msemployeedetail b ON a.id = b.employeeid
				INNER JOIN mslocation c ON b.locationid = c.id
				WHERE b.jobid IN (6, 12, 72) 
				AND a.isactive = 1
				AND a.name LIKE ?
				ORDER BY a.id";
			return $this->db_oriskin->query($sql, [$searchParam])->result_array();
		}
	}


	public function getEmployeeForInvoice($search)
	{
		$locationId = $this->session->userdata('locationid');
		$level = $this->session->userdata('level');
		$searchParam = '%' . $this->db_oriskin->escape_like_str($search) . '%';

		if ($level == 1) {
			$sql = "SELECT 
					a.id as EMPLOYEEID, a.name as NAME, b.locationid as LOCATIONID, c.name as LOCATIONNAME
				FROM msemployee a 
				INNER JOIN msemployeedetail b ON a.id = b.employeeid
				INNER JOIN mslocation c ON b.locationid = c.id
				WHERE b.locationid = ? 
				AND b.jobid IN (6, 12, 72, 4, 20, 21, 104)
				AND a.isactive = 1
				AND a.name LIKE ?
				ORDER BY a.id";
			return $this->db_oriskin->query($sql, [$locationId, $searchParam])->result_array();
		} else {
			$sql = "SELECT 
					a.id as EMPLOYEEID, a.name as NAME, b.locationid as LOCATIONID, c.name as LOCATIONNAME
				FROM msemployee a 
				INNER JOIN msemployeedetail b ON a.id = b.employeeid
				INNER JOIN mslocation c ON b.locationid = c.id
				WHERE b.jobid IN (6, 12, 72, 4, 20, 21, 104)
				AND a.isactive = 1
				AND a.name LIKE ?
				ORDER BY a.id";
			return $this->db_oriskin->query($sql, [$searchParam])->result_array();
		}
	}




	public function insert_employee($data)
	{
		$this->db_oriskin->insert('msemployee', $data);
		return $this->db_oriskin->insert_id();
	}

	public function insert_employee_detail($data)
	{
		return $this->db_oriskin->insert('msemployeedetail', $data);
	}

	public function getListStockOut($dateStart, $dateEnd)
	{
		$query = "SELECT 
					a.id AS ID, 
					a.stockoutdate AS STOCKOUTDATE, 
					a.code AS CODE, 
					a.refferenceno AS REFNO, 
					b.name AS ISSUEDBY,
					CASE 
						WHEN a.status = 1 THEN 'Draft'
						WHEN a.status = 2 THEN 'Approved'
						WHEN a.status = 3 THEN 'Void'
					END AS STATUS,
					CASE 
						WHEN a.stockmovement = 1 THEN 'Movement (Out)'
						WHEN a.stockmovement = 2 THEN 'Refund (Out)'
					END AS MOVEMENT,
					c.name as LOCNAME,
					q.warehouse_name as WHNAME
				FROM msingredientsstockout a 
				LEFT JOIN msemployee b ON a.issuedby = b.id
				LEFT JOIN mslocation c ON a.fromlocationid = c.id
				LEFT JOIN mswarehouse q ON a.fromwarehouseid = q.id
				WHERE a.stockoutdate BETWEEN ? AND ? AND a.status != 3
        ";

		return $this->db_oriskin->query($query, [$dateStart, $dateEnd])->result_array();
	}

	public function getListStockIn($dateStart, $dateEnd)
	{
		$query = "SELECT 
					a.id AS ID, 
					a.stockindate AS STOCKINDATE, 
					a.code AS CODE, 
					a.refferenceno AS REFNO, 
					b.name AS ISSUEDBY,
					CASE 
						WHEN a.status = 1 THEN 'Draft'
						WHEN a.status = 2 THEN 'Approved'
						WHEN a.status = 3 THEN 'Void'
					END AS STATUS,
					CASE 
						WHEN a.stockmovement = 3 THEN 'Movement (In)'
						WHEN a.stockmovement = 4 THEN 'Opening (In)'
						WHEN a.stockmovement = 5 THEN 'Purchase (In)'
					END AS MOVEMENT,
					c.name as LOCNAME,
					d.name as SUPPLIERNAME,
					q.warehouse_name as WHNAME
				FROM msingredientsstockin a
				LEFT JOIN msemployee b ON a.issuedby = b.id
				LEFT JOIN mslocation c ON a.tolocationid = c.id
				LEFT JOIN mswarehouse q ON a.towarehouseid = q.id
				LEFT JOIN mssupplier d ON a.supplierid = d.id
				WHERE a.stockindate BETWEEN ? AND ? AND a.status != 3
        ";

		return $this->db_oriskin->query($query, [$dateStart, $dateEnd])->result_array();
	}

	public function getLinkCustomerRefferal($search, $location_id)
	{
		$search = '%' . $search . '%';

		return $this->db_oriskin->query("
        SELECT TOP 20 a.id, a.firstname + ' ' + a.lastname AS fullname, a.cellphonenumber, a.customercode 
        FROM mscustomer a 
        INNER JOIN slguestlog b ON a.guestlogid = b.id
        WHERE a.locationid = ?
        AND (
            a.firstname LIKE ? 
            OR b.lastname LIKE ? 
            OR a.cellphonenumber LIKE ? 
            OR a.customercode LIKE ?
        )
        ORDER BY a.firstname
    ", [$location_id, $search, $search, $search, $search])->result_array();
	}


	public function getLinkDocter($location_id)
	{

		return $this->db_oriskin->query("
        SELECT a.id, a.name as fullname, a.code 
        FROM msemployee a 
        INNER JOIN msemployeedetail b ON a.id = b.employeeid
        WHERE b.locationid = ? AND b.jobid = 12 AND a.isactive = 1
        ORDER BY a.name
    ", [$location_id])->result_array();
	}

	public function getLinkRegistrasiConsultant($location_id)
	{
		$level = $this->session->userdata('level');

		if ($level == 12) {
			return $this->db_oriskin->query("
			SELECT a.id, a.name as fullname, a.code 
			FROM msemployee a 
			WHERE a.title = 'TRILOGY'
			ORDER BY a.name
		")->result_array();
		} else {
			return $this->db_oriskin->query("
			SELECT a.id, a.name as fullname, a.code 
			FROM msemployee a 
			INNER JOIN msemployeedetail b ON a.id = b.employeeid
			INNER JOIN msemployeeinvoice c ON a.id = c.employeeid
			WHERE c.locationid = ? AND b.jobid = 4 AND c.isactive = 1
			ORDER BY a.name
		", [$location_id])->result_array();
		}
	}

	public function getListSaleTicket($search)
	{
		$searchLike = '%' . $search . '%';

		$searchInt = $search;

		return $this->db_oriskin->query("
        SELECT TOP 20 a.id AS APPTID, 
		a.remarks AS REMARKS, a.duration AS DURATION, 
		a.appointmentdate AS APPTDATE, a.customerid AS CUSTOMERID, 
		a.employeeid AS EMPID, a.booktime AS BOOKTIME,
		a.locationid AS LOCATIONID, a.status AS STATUS,
		b.invoiceno AS INVOICENO, b.id AS DOINGID,
		c.firstname + ' ' + c.lastname AS FULLNAME
        FROM trbookappointment a
        INNER JOIN trdoingtreatment b ON a.id = b.bookingid
		INNER JOIN mscustomer c ON a.customerid = c.id
        WHERE (
            a.id LIKE ? 
            OR b.invoiceno LIKE ? 
            OR a.customerid LIKE ? 
            OR b.id LIKE ?
        ) AND a.status = 5
    ", [$searchInt, $searchLike, $searchInt, $searchInt])->result_array();
	}

	public function getBalancePrepaidWess($search)
	{
		// Trim untuk memastikan tidak ada spasi kosong
		$search = trim($search);

		// Jika kosong, return array kosong
		if ($search === '') {
			return [];
		}

		$searchLike = '%' . $search . '%';

		$sql = "
        SELECT *
        FROM balanceprepaidwess
        WHERE 
            code LIKE ? 
            OR customer LIKE ? 
            OR purchaseat LIKE ?
            OR invoiceno LIKE ?
    ";

		return $this->db_oriskin->query($sql, [
			$searchLike,
			$searchLike,
			$searchLike,
			$searchLike
		])->result_array();
	}


	public function getListAppointment($customerId)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$query = "SELECT 
					CONVERT(varchar(10), a.appointmentdate, 120) AS APPOINTMENTDATE, 
					b.name AS LOCATION,
					a.status,
					CASE a.status
						WHEN 1 THEN 'Waiting Confirmation'
						WHEN 2 THEN 'Confirmed'
						WHEN 6 THEN 'Checkin'
						WHEN 3 THEN 'Last Minute Cancel'
						WHEN 4 THEN 'Not Show'
						WHEN 5 THEN 'Finished'
						ELSE 'Unknown'
					END AS STATUS_TEXT,
					a.remarks AS REMARKS,
					a.booktime AS TIME,
					c.firstname + ' ' + c.lastname as FULLNAME
				FROM 
					trbookappointment a
					INNER JOIN mslocation b ON a.locationid = b.id
					INNER JOIN mscustomer c ON a.customerid = c.id
				WHERE 
					a.customerid = ? AND a.appointmentdate >= CAST(GETDATE() AS DATE)
				ORDER BY a.appointmentdate DESC
				";
		return $db_oriskin->query($query, [$customerId])->result_array();
	}

	public function getListHistoryRetail($customerId)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$query = "SELECT 
					CONVERT(varchar(10), a.invoicedate, 120) AS INVOICEDATE, 
					b.name AS LOCATION,
					e.name AS PRODUCT,
					d.qty AS QTY,
					a.invoiceno AS INVOICENO,
					c.firstname + ' ' + c.lastname as FULLNAME
				FROM 
					slinvoicehdr a
					INNER JOIN mslocation b ON a.locationid = b.id
					INNER JOIN mscustomer c ON a.customerid = c.id
					INNER JOIN slinvoicedtl d ON a.id = d.invoicehdrid
					INNER JOIN msproduct e ON d.productid = e.id
				WHERE 
					a.customerid = ? AND a.status = 2
				ORDER BY a.invoicedate DESC
				";
		return $db_oriskin->query($query, [$customerId])->result_array();
	}

	public function getListHistoryExchangeInvoice($customerId)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$query = "SELECT 
					CONVERT(varchar(10), a.exchangedate, 120) AS EXCHANGEDATE, 
					d.name AS TREATMENT,
					a.qty AS QTY,
					a.invoiceno AS INVOICENO,
					a.point AS AMOUNT,
					c.firstname + ' ' + c.lastname as FULLNAME
				FROM 
					msexchangetreatment a
					INNER JOIN mscustomer c ON a.customerid = c.id
					INNER JOIN mstreatment d ON a.productid = d.id
				WHERE
					a.customerid = ? AND a.status = 1
				";
		return $db_oriskin->query($query, [$customerId])->result_array();
	}


	public function authenticationErp()
	{
		$data = [
			"clientId" => "CA733C8255A64582A622902FD540BE0E",
			"orgId" => "F1DB055E5F9C49C5BEDAC653A24F317B",
			"username" => "eudora-adminapi",
			"password" => "EudoraAPI_erp_911"
		];

		$ch = curl_init('https://api.ukm-erp.com/api/users/auth');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Accept: application/json',
			'Content-Type: application/json',
		]);
		$response = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($response, true);

		if (isset($data['token'])) {
			$this->session->set_userdata('token', $data['token']);
			return ([
				'success' => true,
				'token' => $data['token'],
			]);
		} else {
			return ([
				'success' => false,
			]);
		}
	}

	public function syncCogsErp()
	{
		$token = $this->session->userdata('token');

		if (!$token) {
		}

		$url = 'https://api.ukm-erp.com/api/erp/get?service=Product&params=' . urlencode(json_encode(["_startRow" => 0, "_endRow" => 2000]));

		// Inisialisasi cURL
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPGET, true); // Menggunakan GET secara eksplisit
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		]);

		// Eksekusi request
		$response = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		// Tangani error cURL
		if (curl_errno($ch)) {
			return json_encode(['error' => curl_error($ch)]);
		}

		curl_close($ch);

		// Cek kode HTTP response
		if ($httpcode !== 200) {
			return json_encode(['error' => "Request gagal dengan status $httpcode", 'response' => $response]);
		}

		return $response;
	}

	public function insertSalesOrderToErp($orderData)
	{
		$data = [
			"data" => $orderData,
		];

		$token = $this->session->userdata('token');

		$ch = curl_init('https://api.ukm-erp.com/api/erp/post?service=penjualan');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		]);
		$response = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($response, true);

		if ($data['success'] == true && isset($data['response']['data'][0]['id'])) {
			return $data['response']['data'][0]['id'];
		} else {
			return null;
		}
	}

	public function insertSalesOrderLineToErp($orderData)
	{
		$data = [
			"data" => $orderData,
		];

		$token = $this->session->userdata('token');

		$ch = curl_init('https://api.ukm-erp.com/api/erp/post?service=penjualanLine');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: Bearer ' . $token
		]);
		$response = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($response, true);

		if ($data['success'] == true) {
			return ([
				'success' => true,
				'message' => 'Success insert data to detail',
				'data' => $data
			]);
		} else {
			return ([
				'success' => false,
				'message' => 'Failed insert data to detail',
			]);
		}
	}

	public function searchDocter($search)
	{
		$this->db_oriskin->select('e.id, e.name as name, ef.name as locationname');
		$this->db_oriskin->from('msemployee e');
		$this->db_oriskin->join('msemployeedetail ed', 'e.id = ed.employeeid', 'inner');
		$this->db_oriskin->join('mslocation ef', 'ed.locationid = ef.id', 'inner');
		$this->db_oriskin->where('e.isactive', 1);
		$this->db_oriskin->where('ed.jobid', 12);
		$this->db_oriskin->where('ed.locationid !=', 6);
		$this->db_oriskin->where("(e.name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
		$this->db_oriskin->order_by('e.name', 'ASC');
		$this->db_oriskin->limit(50);
		return $this->db_oriskin->get()->result();
	}

	public function searchPackage($search)
	{
		$this->db_oriskin->select('id, code, name');
		$this->db_oriskin->from('msproductmembershiphdr');
		$this->db_oriskin->where('isactive', 1);
		$this->db_oriskin->where("(code LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR name LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
		$this->db_oriskin->order_by('code', 'ASC');
		$this->db_oriskin->limit(50); // Batasi hasil agar lebih cepat
		return $this->db_oriskin->get()->result();
	}


	// public function getServiceListBackEnd()
	// {

	// 	return $this->db_oriskin->query("SELECT 
	// 					t.id AS ID,
	// 					t.code AS CODE,
	// 					t.name AS NAME,
	// 					t.price AS PRICE,
	// 					t.ingredientscategoryid,
	// 					ic.name AS INGREDIENT_CATEGORY_NAME,
	// 					CASE 
	// 						WHEN t.isactive = 1 THEN 'Yes'
	// 						WHEN t.isactive = 0 THEN 'No'
	// 					END AS PUBLISHED,
	// 					CASE 
	// 						WHEN t.pointsection = 2 THEN 'NON MEDIS'
	// 						WHEN t.pointsection = 1 THEN 'MEDIS'
	// 						WHEN t.pointsection = 0 THEN 'NO'
	// 					END AS POINTSECTION,
	// 					CASE 
	// 						WHEN d.ingredientscategoryid IS NOT NULL THEN 'Ada COGS'
	// 						ELSE 'Tidak Ada COGS'
	// 					END AS COGS_STATUS
	// 				FROM mstreatment t
	// 				LEFT JOIN mstreatment ic ON t.ingredientscategoryid = ic.id
	// 				LEFT JOIN (
	// 					SELECT DISTINCT ingredientscategoryid
	// 					FROM mstreatmentingredients
	// 				) d ON t.ingredientscategoryid = d.ingredientscategoryid
	// 				ORDER BY t.ingredientscategoryid
	//     ")->result_array();
	// }

	public function getServiceListBackEnd()
	{

		return $this->db_oriskin->query("SELECT 
    t.id AS ID,
    t.code AS CODE,
    t.name AS NAME,
    t.price AS PRICE,
    t.ingredientscategoryid,
    ic.name AS INGREDIENT_CATEGORY_NAME,
    ic.code AS CODECHANGETO,
    ic.id AS IDCHANGETO,
    CASE 
        WHEN t.isactive = 1 THEN 'Yes'
        WHEN t.isactive = 0 THEN 'No'
    END AS PUBLISHED,
    CASE 
        WHEN t.section = 1 THEN 'THERAPIST'
        WHEN t.section = 2 THEN 'DOKTER'
        WHEN t.section = 3 THEN 'GATAU'
        WHEN t.section = 4 THEN 'GATAU'
    END AS SECTION,
    CASE 
        WHEN t.pointsection = 2 THEN 'NON MEDIS'
        WHEN t.pointsection = 1 THEN 'MEDIS'
        WHEN t.pointsection = 0 THEN 'NO'
    END AS POINTSECTION,
    CASE 
        WHEN d.ingredientscategoryid IS NOT NULL THEN 'Ada COGS'
        ELSE 'Tidak Ada COGS'
    END AS COGS_STATUS,
    STUFF((
        SELECT DISTINCT ', ' + msc2.name
        FROM treatment_category tc2
        INNER JOIN mscategory msc2 ON tc2.categoryid = msc2.id
        WHERE tc2.productid = t.id AND tc2.producttypeid = 1
        FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2, ''
    ) AS category
FROM mstreatment t
LEFT JOIN mstreatment ic ON t.idchange = ic.id
LEFT JOIN (
    SELECT DISTINCT ingredientscategoryid
    FROM mstreatmentingredients
) d ON t.ingredientscategoryid = d.ingredientscategoryid
ORDER BY t.ingredientscategoryid;

        ")->result_array();

	}
	public function getDetailListRecon($id)
	{
		// Ambil data berdasarkan ID terlebih dahulu
		$recon = $this->db_oriskin->get_where('msreconciliation', ['id' => $id])->row_array();

		if (!$recon) {
			return []; // Jika tidak ditemukan
		}

		// Ambil nilai-nilai yang dibutuhkan
		$transactiondate = $recon['transactiondate'];
		$locationid = $recon['locationid'];
		$paymentid = $recon['paymentid'];

		// Query berdasarkan nilai-nilai yang diambil tadi dan tambahkan kondisi status != 0
		$this->db_oriskin->where('transactiondate', $transactiondate);
		$this->db_oriskin->where('locationid', $locationid);
		$this->db_oriskin->where('paymentid', $paymentid);
		$this->db_oriskin->where('status !=', 0); // Tambahkan kondisi status tidak sama dengan 0
		$query = $this->db_oriskin->get('msreconciliation');

		return $query->result_array();
	}



	public function getDetail($id)
	{
		return $this->db_oriskin->get_where('msreconciliation', ['id' => $id])->result_array();
	}

	public function getDetailExpendCost($id)
	{
		return $this->db_oriskin->get_where('expendcost', ['id' => $id])->row_array();
	}


	// ReconciliationModel.php

	public function updateReconciliation($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('msreconciliation', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function deleteReconciliation($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('msreconciliation', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function createReconciliation($data)
	{
		$this->db_oriskin->insert('msreconciliation', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function getExpendCost($dateStart, $dateEnd)
	{
		$this->db_oriskin->select('e.*, ed.name as expendcosttype, ef.id as costtypeid, ml.name as locationname');
		$this->db_oriskin->from('expendcost e');
		$this->db_oriskin->join('msexpendcosttype ed', 'e.expendcostid = ed.id', 'inner');
		$this->db_oriskin->join('mscosttype ef', 'ed.costtypeid = ef.id', 'inner');
		$this->db_oriskin->join('mslocation ml', 'e.locationid = ml.id', 'inner');
		$this->db_oriskin->where('e.expenddate >=', $dateStart);
		$this->db_oriskin->where('e.expenddate <=', $dateEnd);
		$this->db_oriskin->where('e.status', 1);

		return $this->db_oriskin->get()->result_array();
	}

	public function getProfitAndLoss($period, $locationId)
	{
		$query = "Exec SpEudoraReportProfitAndLoss ?, ?";
		return $this->db_oriskin->query($query, [$period, $locationId])->result_array();
	}

	public function getExpendCostType()
	{
		$query = "SELECT * FROM msexpendcosttype";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getUomList()
	{
		$query = "SELECT * FROM msunitingredients";
		return $this->db_oriskin->query($query)->result_array();
	}
	public function createExpend($data)
	{
		$this->db_oriskin->insert('expendcost', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function updateExpend($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('expendcost', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function getSkinCare()
	{
		return $this->db_oriskin->query("SELECT 
										id, name
										FROM msskincare WHERE isactive = 1 order by id
        ")->result_array();
	}

	public function getDoctorConsultation()
	{
		$locationid = $this->session->userdata('locationid');
		return $this->db_oriskin->query("SELECT 
						b.id, b.name FROM msemployeeappointment a
						INNER JOIN msemployee b ON a.employeeid = b.id
						INNER JOIN msemployeedetail c ON b.id = c.employeeid
						WHERE a.isactive = 1
						AND a.locationid = $locationid
						AND c.jobid in(12)
						ORDER BY b.name
        ")->result_array();
	}



	public function getPastTreatment()
	{
		return $this->db_oriskin->query("SELECT 
										id, name
										FROM mspasttreatment WHERE isactive = 1 order by id
        ")->result_array();
	}

	public function getSkinCondition()
	{
		return $this->db_oriskin->query("SELECT 
										id, name
										FROM msskincondition WHERE isactive = 1 order by id
        ")->result_array();
	}

	public function getOccupied()
	{
		return $this->db_oriskin->query("SELECT 
										id, name
										FROM msoccupied WHERE isactive = 1 order by id
        ")->result_array();
	}

	public function getNettIncome()
	{
		return $this->db_oriskin->query("SELECT 
										id, name
										FROM msnettincome WHERE isactive = 1 order by id
        ")->result_array();
	}

	public function getAdvTracking()
	{
		return $this->db_oriskin->query("SELECT 
										id, name
										FROM msguestlogadvtracking WHERE isactive = 1 order by id
        ")->result_array();
	}


	public function search_customersConsultation($search)
	{

		$this->db_oriskin->select('mscustomer.*, slguestlog.guestlogadvtrackingid');
		$this->db_oriskin->from('mscustomer');
		$this->db_oriskin->join('slguestlog', 'slguestlog.id = mscustomer.guestlogid', 'inner');
		$this->db_oriskin->where("(mscustomer.firstname LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR mscustomer.lastname LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR mscustomer.cellphonenumber LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
								 OR mscustomer.membercode LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%' 
                                OR mscustomer.customercode LIKE '%" . $this->db_oriskin->escape_like_str($search) . "%')", NULL, FALSE);
		$this->db_oriskin->order_by('mscustomer.membercode', 'ASC');
		$this->db_oriskin->limit(50);
		return $this->db_oriskin->get()->result();
	}


	public function updateEmployee($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		return $this->db_oriskin->update('msemployee', $data);
	}

	public function updateEmployeeDetail($id, $data)
	{
		$this->db_oriskin->where('employeeid', $id);
		return $this->db_oriskin->update('msemployeedetail', $data);
	}
	public function getWarehouse($search = null)
	{
		$this->db_oriskin->select('id, warehouse_name as text');
		$this->db_oriskin->from('mswarehouse');

		if (!empty($search)) {
			$this->db_oriskin->like('warehouse_name', $search);
		}

		$this->db_oriskin->order_by('id', 'ASC');
		return $this->db_oriskin->get()->result_array();
	}

	public function getCompany($search = null)
	{
		$this->db_oriskin->select('id, companyname as text');
		$this->db_oriskin->from('mscompany');

		if (!empty($search)) {
			$this->db_oriskin->like('companyname', $search);
		}

		$this->db_oriskin->order_by('id', 'ASC');
		return $this->db_oriskin->get()->result_array();
	}

	public function getEmployees($search = null)
	{
		$this->db_oriskin->select('id, name as text');
		$this->db_oriskin->from('msemployee');

		if (!empty($search)) {
			$this->db_oriskin->like('name', $search);
		}

		$this->db_oriskin->order_by('name', 'ASC');
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

}
