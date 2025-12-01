<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelCompany extends CI_Model
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
		$query = "SELECT a.*, b.name as cityname, c.name as provincename, 
		d.countryname as countryname, b.umk
		FROM mscompany a 
		LEFT JOIN mscity b ON a.cityid = b.id 
		LEFT JOIN msprovince c ON a.provinceid = c.id  
		LEFT JOIN mscountry d ON a.countryid = d.id";
		return $this->db_oriskin->query($query)->result_array();
	}


	public function getListUsers()
	{
		$query = "SELECT a.*, b.name as locationname FROM msuser a
				INNER JOIN mslocation b ON a.locationid = b.id";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getWarehouseMaster()
	{
		$query = "SELECT a.*, b.name as cityname
		FROM mswarehouse a 
		LEFT JOIN mscity b ON a.cityid = b.id";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function getCompanyMasterById($id)
	{
		$query = "SELECT * FROM mscompany WHERE id = $id";
		return $this->db_oriskin->query($query)->row_array();
	}

	public function getUserById($id)
	{
		$query = "SELECT * FROM msuser WHERE id = $id";
		return $this->db_oriskin->query($query)->row_array();
	}

	public function getWarehouseMasterById($id)
	{
		$query = "SELECT * FROM mswarehouse WHERE id = $id";
		return $this->db_oriskin->query($query)->row_array();
	}

	public function createCompanyMaster($data)
	{
		$this->db_oriskin->insert('mscompany', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function createUser($data)
	{
		$this->db_oriskin->insert('msuser', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function createWarehouseMaster($data)
	{
		$this->db_oriskin->insert('mswarehouse', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function updateCompanyMaster($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('mscompany', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function updateUser($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('msuser', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function updateWarehouseMaster($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		$this->db_oriskin->update('mswarehouse', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function getListUsersAccessLocation()
	{
		$query = "SELECT a.*, b.name as locationname, c.name as username FROM msuser_location_access a
				INNER JOIN mslocation b ON a.locationid = b.id
				INNER JOIN msuser c ON a.userid = c.id";
		return $this->db_oriskin->query($query)->result_array();
	}

	public function checkUserLocationAccess($userid, $locationid)
	{
		$this->db_oriskin->from('msuser_location_access');
		$this->db_oriskin->where('userid', $userid);
		$this->db_oriskin->where('locationid', $locationid);
		$query = $this->db_oriskin->get();
		return $query->num_rows() > 0;
	}

	public function createUserLocationAccess($data)
	{
		$this->db_oriskin->insert('msuser_location_access', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}


	public function getListUsersAccessCompany()
	{
		$query = "SELECT a.*, b.companyname as companyname, c.name as username FROM msuser_company_access a
				INNER JOIN mscompany b ON a.companyid = b.id
				INNER JOIN msuser c ON a.userid = c.id";
		return $this->db_oriskin->query($query)->result_array();
	}


	public function checkUserCompanyAccess($userid, $companyid)
	{
		$this->db_oriskin->from('msuser_company_access');
		$this->db_oriskin->where('userid', $userid);
		$this->db_oriskin->where('companyid', $companyid);
		$query = $this->db_oriskin->get();
		return $query->num_rows() > 0;
	}

	public function createUserCompanyAccess($data)
	{
		$this->db_oriskin->insert('msuser_company_access', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}

	public function getListUsersAccessWarehouse()
	{
		$query = "SELECT a.*, b.warehouse_name as warehouse_name, c.name as username FROM msuser_warehouse_access a
				INNER JOIN mswarehouse b ON a.warehouseid = b.id
				INNER JOIN msuser c ON a.userid = c.id";
		return $this->db_oriskin->query($query)->result_array();
	}


	public function checkUserWarehouseAccess($userid, $warehouseid)
	{
		$this->db_oriskin->from('msuser_warehouse_access');
		$this->db_oriskin->where('userid', $userid);
		$this->db_oriskin->where('warehouseid', $warehouseid);
		$query = $this->db_oriskin->get();
		return $query->num_rows() > 0;
	}

	public function createUserWarehouseAccess($data)
	{
		$this->db_oriskin->insert('msuser_warehouse_access', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}


	public function sendBlastWhatsapp($data)
	{
		$api_url = 'https://chatapps.8x8.com/api/v1/subaccounts/subAccountId/messages/batch';
		$api_token = 'Bearer 7z6eXHNBdWwP1mz9AUweHHF5XHvLxZMQylt8n2fN18Q';

		$headers = [
			'Authorization: ' . $api_token,
			'Content-Type: application/json'
		];

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $api_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => $headers,
		]);

		$response = curl_exec($curl);
		$error = curl_error($curl);
		curl_close($curl);

		if ($error) {
			return ['status' => 'error', 'message' => $error];
		}

		return json_decode($response, true);
	}


	public function getCompanyById($id)
	{
		$query = "SELECT * FROM mscompany WHERE id = $id";
		return $this->db_oriskin->query($query)->row_array();
	}


	public function getAllCity()
	{
		return $this->db_oriskin
			->select('c.id, c.name AS cityname, c.provinceid, p.name AS provincename, c.umk, c.updateuserid, c.updatedate')
			->from('mscity c')
			->join('msprovince p', 'p.id = c.provinceid', 'left')
			->order_by('p.name, c.name')
			->get()
			->result_array();
	}


	public function updateUmkCity($id, $umk)
	{
		$data = [
			'umk' => $umk,
			'updatedate' => date('Y-m-d H:i:s'),
			'updateuserid' => 1
		];
		return $this->db_oriskin->where('id', $id)->update('mscity', $data);
	}
}
