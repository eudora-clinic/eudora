<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelEmployeeApps extends CI_Model
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

	public function getEmployeeAttendanceByIdAndDate($employeaccountid, $date)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$query = "SELECT 
					a.id AS employeeid,
					a.name AS employeename,
					s.id AS shiftid,
					s.shiftname + ' ( ' + CONVERT(VARCHAR(5), s.timein, 120) + ' - ' + CONVERT(VARCHAR(5), s.timeout, 120) + ' )' AS shiftname,
					MIN(CASE 
							WHEN ea.attendance_type = 'checkin' THEN ea.attendance_time 
						END) AS checkin,
					MAX(CASE 
							WHEN ea.attendance_type = 'checkout' THEN ea.attendance_time 
						END) AS checkout
				FROM msemployee a
				LEFT JOIN employeeshift b 
					ON a.id = b.employeeid 
				AND b.shiftdate = ?
				LEFT JOIN msshift s 
					ON s.id = COALESCE(b.shiftid, a.defaultshiftid)
				LEFT JOIN employee_attendance ea 
					ON ea.employeeaccountid = a.id
				AND CONVERT(VARCHAR(10), ea.createdat, 120) = ?
				WHERE a.id = ?
				GROUP BY 
					a.id, a.name, s.id, s.shiftname, a.nip, s.timein, s.timeout
				";
		return $db_oriskin->query($query, [$date, $date, $employeaccountid])->row_array();
	}

	public function get_employee_detail($employeaccountid)
	{
		$query = $this->db_oriskin->select('a.name as employeename, a.nip as nip, a.id as employeeid, d.name as jobname')
			->from('msemployee a')
			->join('msemployeedetail c', 'a.id = c.employeeid', 'inner')
			->join('msjob d', 'c.jobid = d.id', 'inner')
			->where('a.id', $employeaccountid)
			->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return [];
		}
	}

	public function get_location()
	{
		$this->db_oriskin->select("id,CONCAT(name, ' - ', shortcode) as text");
		$this->db_oriskin->from('mslocation');
		$this->db_oriskin->order_by('name', 'ASC');
		return $this->db_oriskin->get()->result_array();
	}

	public function get_employee_account($location = null)
	{
		$this->db_oriskin->select('e.name,e.nip,e.cellphonenumber,ea.isactive,ea.employeeid,ea.id,l.name AS location_name,ed.locationid');
		$this->db_oriskin->from('employee_account ea');
		$this->db_oriskin->join('msemployee e', 'e.id=ea.employeeid');
		$this->db_oriskin->join('msemployeedetail ed', 'e.id=ed.employeeid');
		$this->db_oriskin->join('mslocation l', 'l.id=ed.locationid');
		if (!empty($location)) {
			$this->db_oriskin->where('ed.locationid', $location);
		}
		$this->db_oriskin->order_by('name', 'ASC');
		return $this->db_oriskin->get()->result();
	}

	public function get_employee_attendance($date = null, $location = null)
	{
		$db_oriskin = $this->load->database('oriskin', true);

		$this->db_oriskin->select("
			a.id,
			e.name,
			e.nip,
			e.cellphonenumber,
			ea.isactive,
			ea.employeeid,
			a.employeeaccountid,
			ea2.id AS employeeaccount_id,
			a.attendance_type,
			a.attendance_time,
			a.status,
			a.images,
			a.imagebase64,
			a.locationname
		");
		$this->db_oriskin->from('employee_attendance a');
		$this->db_oriskin->join('employee_account ea', 'ea.id = a.employeeaccountid', 'left');
		$this->db_oriskin->join('msemployee e', 'e.id = a.employeeaccountid', 'left');
		$this->db_oriskin->join('employee_account ea2', 'ea2.employeeid = e.id', 'left');
		$this->db_oriskin->join('msemployeedetail d', 'd.employeeid = e.id', 'left');

		if ($date != null) {
			$this->db_oriskin->where("a.createdat >=", $date . ' 00:00:00');
			$this->db_oriskin->where("a.createdat <=", $date . ' 23:59:59');
		}

		if ($location != null) {
			$this->db_oriskin->where("d.locationid", $location);
		}

		return $this->db_oriskin->get()->result_array();
	}



	public function updateStatus($id, $status)
	{
		$this->db_oriskin->where('id', $id);
		return $this->db_oriskin->update('employee_attendance', ['status' => $status]);
	}

	public function update_employee_account($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		return $this->db_oriskin->update('employee_account', $data);
	}

	public function deletedEmployee($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		return $this->db_oriskin->update('msemployee', $data);
	}

	public function get_employee_account_by_id($id)
	{
		$this->db_oriskin->select('ea.id,e.name,e.nip,e.cellphonenumber,ea.isactive,ea.employeeid');
		$this->db_oriskin->from('employee_account ea');
		$this->db_oriskin->join('msemployee e', 'e.id=ea.employeeid');
		$this->db_oriskin->join('msemployeedetail ed', 'e.id=ed.employeeid');
		$this->db_oriskin->where('ea.id', $id);
		return $this->db_oriskin->get()->row_array();
	}

	public function getEmployees($search = null)
	{
		$this->db_oriskin->select("id, CONCAT(name, ' (', nip, ')') as text", false);
		$this->db_oriskin->from('msemployee');

		if (!empty($search)) {
			$this->db_oriskin->group_start()
				->like('name', $search)
				->or_like('nip', $search)
				->group_end();
		}

		$this->db_oriskin->order_by('name', 'ASC');
		return $this->db_oriskin->get()->result();
	}

	public function insert_employee_attendances($data)
	{
		$this->db_oriskin->insert('employee_attendance', $data);
		$error = $this->db_oriskin->error();
		if ($error['code'] != 0) {
			return $error;
		}
		return true;
	}

	public function get_all_employee_attendances()
	{
		$query = $this->db_oriskin->select('*')
			->from('employee_attendance')
			->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return [];
		}
	}

	public function get_employee_by_id($id)
	{
		$query = $this->db_oriskin->select('e.id as employeeid, e.nip, e.name, j.name AS jobname, l.name AS locationname')
			->from('msemployee e')
			->join('msemployeedetail d', 'e.id=d.employeeid', 'left')
			->join('mslocation l', 'l.id=d.locationid', 'left')
			->join('msjob j', 'j.id=d.jobid', 'left')
			->where('e.id', $id)
			->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return null;
		}
	}

	public function getEmployeeAttendanceById($employeeaccountid)
	{
		$this->db_oriskin->select("
			ea.id,
			CONVERT(date, a.createdat) AS attendance_date,
			MAX(CASE WHEN a.attendance_type = 'checkin' THEN a.attendance_time END) AS checkin_time,
			MAX(CASE WHEN a.attendance_type = 'checkout' THEN a.attendance_time END) AS checkout_time,
			DATEDIFF(MINUTE,
				MIN(CASE WHEN a.attendance_type = 'checkin' THEN a.attendance_time END),
				MAX(CASE WHEN a.attendance_type = 'checkout' THEN a.attendance_time END)
			)/60.0 AS work_hours
		");
		$this->db_oriskin->from('employee_account ea');
		$this->db_oriskin->join('employee_attendance a', 'a.employeeaccountid = ea.id', 'left');
		$this->db_oriskin->where('ea.id', $employeeaccountid);
		$this->db_oriskin->group_by('ea.id, CONVERT(date, a.createdat)');

		return $this->db_oriskin->get()->result_array();
	}

	public function get_employee_attendances_by_id($employeeaccountid)
	{
		$query = $this->db_oriskin->select('*')
			->from('employee_attendance')
			->where('employeeaccountid', $employeeaccountid)
			->row_array();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return [];
		}
	}

	public function get_employee_attendances_by_id_by_month($employeeaccountid, $monthYear)
	{
		$startDate = $monthYear . "-01";
		$endDate = date("Y-m-t", strtotime($startDate));

		$query = $this->db_oriskin->select("
					ea.id as employeeaccountid,
					e.name,
					e.nip,
					a.attendance_type,
					CONVERT(date, a.createdat) AS attendance_date,
					a.attendance_time,
					a.images,
					a.status
				")
			->from('employee_account ea')
			->join('msemployee e', 'e.id = ea.employeeid')
			->join(
				'employee_attendance a',
				"a.employeeaccountid = ea.employeeid 
					AND a.createdat BETWEEN '$startDate' AND '$endDate'",
				'left'
			)
			->where('ea.id', $employeeaccountid)
			->order_by('a.createdat', 'ASC')
			->get();

		return $query->result_array();
	}

	public function get_employee_attendances_by_id_date($employeeaccountid, $datestart, $dateend)
	{
		$query = $this->db_oriskin->select('*')
			->from('employee_attendance')
			->where('employeeaccountid', $employeeaccountid)
			->where('date >=', $datestart)
			->where('date <=', $dateend)
			->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return [];
		}
	}

	// Function untuk mencari loaksi terdekat
	private function haversine_distance($lat1, $lon1, $lat2, $lon2)
	{
		$R = 6371;
		$dLat = deg2rad($lat2 - $lat1);
		$dLon = deg2rad($lon2 - $lon1);
		$a = sin($dLat / 2) * sin($dLat / 2) +
			cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
			sin($dLon / 2) * sin($dLon / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		return $R * $c;
	}


	public function get_monthly_attendance_summary($employee_id, $month)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$query = $db_oriskin->select('
				ea.id,
				ea.latitude,
				ea.longitude,
				ea.attendance_time,
				ea.attendance_type,
				e.id AS employeeaccountid,
				e.name AS employee_name,
				e.nip AS employee_nip
			')
			->from('employee_attendance ea')
			->join('msemployee e', 'e.id = ea.employeeaccountid', 'left')
			->join('employee_account a', 'a.employeeid = e.id', 'left')
			->where('a.id', $employee_id)
			->where("FORMAT(ea.createdat, 'yyyy-MM') = '$month'", NULL, FALSE)
			->get();

		if (!$query) {
			echo $db_oriskin->last_query();
			var_dump($db_oriskin->error());
			return;
		}
		$attendance = $query->result_array();
		$locations = $db_oriskin->get('location_pins')->result_array();
		$summary = [];
		foreach ($attendance as $absen) {
			$closest = null;
			$minDist = INF;

			foreach ($locations as $loc) {
				if (!isset($absen['latitude'], $absen['longitude'], $loc['latitude'], $loc['longitude']))
					continue;

				$dist = $this->haversine_distance(
					$absen['latitude'],
					$absen['longitude'],
					$loc['latitude'],
					$loc['longitude']
				);

				if ($dist < $minDist) {
					$minDist = $dist;
					$closest = $loc['locationname'] ?? 'Unknown';
				}
			}

			if ($closest) {
				if (!isset($summary[$closest]))
					$summary[$closest] = 0;
				$summary[$closest]++;
			}
		}

		return ['summary' => $summary];
	}

	public function get_nearest_locationname($latitude, $longitude)
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$locations = $db_oriskin->get('location_pins')->result_array();

		if (empty($locations) || !$latitude || !$longitude) {
			return 'Unknown';
		}

		$closest = 'Unknown';
		$minDist = INF;

		foreach ($locations as $loc) {
			if (!isset($loc['latitude'], $loc['longitude']))
				continue;

			$dist = $this->haversine_distance(
				$latitude,
				$longitude,
				$loc['latitude'],
				$loc['longitude']
			);

			if ($dist < $minDist) {
				$minDist = $dist;
				$closest = $loc['locationname'] ?? 'Unknown';
			}
		}

		return $closest;
	}

	public function update_all_locationnames()
	{
		$db_oriskin = $this->load->database('oriskin', true);
		$attendance = $db_oriskin->select('id, latitude, longitude')
			->from('employee_attendance')
			->where('latitude IS NOT NULL')
			->where('longitude IS NOT NULL')
			->get()
			->result_array();

		$locations = $db_oriskin->get('location_pins')->result_array();

		if (empty($attendance) || empty($locations)) {
			echo "Tidak ada data absensi atau lokasi ditemukan.";
			return;
		}

		$updatedCount = 0;

		foreach ($attendance as $absen) {
			$closest = null;
			$minDist = INF;

			foreach ($locations as $loc) {
				if (!isset($loc['latitude'], $loc['longitude']))
					continue;

				$dist = $this->haversine_distance(
					$absen['latitude'],
					$absen['longitude'],
					$loc['latitude'],
					$loc['longitude']
				);

				if ($dist < $minDist) {
					$minDist = $dist;
					$closest = $loc['locationname'] ?? 'Unknown';
				}
			}

			if ($closest) {
				$db_oriskin->where('id', $absen['id'])
					->update('employee_attendance', ['locationname' => $closest]);
				$updatedCount++;
			}
		}

		echo "Update selesai. Total data diperbarui: {$updatedCount}";
	}

	public function get_distance_employee($latitude, $longitude)
	{
		if (!$latitude || !$longitude) {
			return 'Unknown';
		}

		$db_oriskin = $this->load->database('oriskin', true);

		$sql = "
        SELECT TOP 1
            locationname,
            latitude,
            longitude,
            FLOOR(
                (6371 * ACOS(
                    COS(RADIANS($latitude)) * COS(RADIANS(latitude)) *
                    COS(RADIANS(longitude) - RADIANS($longitude)) +
                    SIN(RADIANS($latitude)) * SIN(RADIANS(latitude))
                )) * 1000
            ) AS distance_meters
        FROM location_pins
        ORDER BY distance_meters ASC
    ";

		$row = $db_oriskin->query($sql)->row_array();

		if (!$row) {
			return 'Unknown';
		}

		return [
			'locationname' => $row['locationname'],
			'distance' => (int) $row['distance_meters'],
			'within_radius' => $row['distance_meters'] <= 100
		];

	}

}
