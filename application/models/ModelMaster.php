<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelMaster extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->db_oriskin = $this->load->database('oriskin', true);
    }

    public function searchJob($search)
    {
        $this->db_oriskin->select('id, name');
        $this->db_oriskin->from('msjob');
        $this->db_oriskin->like('name', $search);
        $this->db_oriskin->where('isactive', 1);
        $this->db_oriskin->order_by('id', 'ASC');
        $this->db_oriskin->limit(30);

        return $this->db_oriskin->get()->result();
    }

    public function searchUser($search)
    {
        $this->db_oriskin->select('id, name');
        $this->db_oriskin->from('msuser');
        $this->db_oriskin->like('name', $search);
        $this->db_oriskin->where('isactive', 1);
        $this->db_oriskin->order_by('id', 'ASC');
        $this->db_oriskin->limit(30);

        return $this->db_oriskin->get()->result();
    }

    public function searchLocation($search)
    {
        $this->db_oriskin->select('id, name');
        $this->db_oriskin->from('mslocation');
        $this->db_oriskin->like('name', $search);
        // $this->db_oriskin->where('isactive', 1);
        $this->db_oriskin->order_by('id', 'ASC');
        $this->db_oriskin->limit(30);

        return $this->db_oriskin->get()->result();
    }

    public function searchCompany($search)
    {
        $this->db_oriskin->select('id, companyname as name');
        $this->db_oriskin->from('mscompany');
        $this->db_oriskin->like('companyname', $search);
        $this->db_oriskin->where('isactive', 1);
        $this->db_oriskin->order_by('id', 'ASC');
        $this->db_oriskin->limit(30);

        return $this->db_oriskin->get()->result();
    }

    public function searchWarehouse($search)
    {
        $this->db_oriskin->select('id, warehouse_name as name');
        $this->db_oriskin->from('mswarehouse');
        $this->db_oriskin->like('warehouse_name', $search);
        $this->db_oriskin->where('is_active', 1);
        $this->db_oriskin->order_by('id', 'ASC');
        $this->db_oriskin->limit(30);

        return $this->db_oriskin->get()->result();
    }

    public function searchAllowance($search)
    {
        $this->db_oriskin->select('id, allowance_name as name');
        $this->db_oriskin->from('msallowancetype');
        $this->db_oriskin->like('allowance_name', $search);
        $this->db_oriskin->where('isactive', 1);
        $this->db_oriskin->order_by('id', 'ASC');
        $this->db_oriskin->limit(30);

        return $this->db_oriskin->get()->result();
    }


    public function searchEmployee($search)
    {
        $this->db_oriskin->select('MIN(id) as id, nip, name');
        $this->db_oriskin->from('msemployee');
        $this->db_oriskin->where('isactive', 1);
        $this->db_oriskin->group_start();
        $this->db_oriskin->like('name', $search);
        $this->db_oriskin->or_like('nip', $search);
        $this->db_oriskin->group_end();
        $this->db_oriskin->group_by(['nip', 'name']);
        $this->db_oriskin->order_by('id', 'ASC');
        $this->db_oriskin->limit(30);

        return $this->db_oriskin->get()->result();
    }


}
