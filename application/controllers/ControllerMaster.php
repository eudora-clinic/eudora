<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ControllerMaster extends CI_Controller
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
        $this->load->model('ModelMaster');
        $this->load->library('Utility');
        $this->load->library('Datatables');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function searchJob()
    {
        $search = $this->input->get('search', TRUE); // TRUE untuk XSS filter
        $data = $this->ModelMaster->searchJob($search);

        $result = array_map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
            ];
        }, $data);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function searchUser()
    {
        $search = $this->input->get('search', TRUE); // TRUE untuk XSS filter
        $data = $this->ModelMaster->searchUser($search);

        $result = array_map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
            ];
        }, $data);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }


    public function searchLocation()
    {
        $search = $this->input->get('search', TRUE); // TRUE untuk XSS filter
        $data = $this->ModelMaster->searchLocation($search);

        $result = array_map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
            ];
        }, $data);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function searchLocationEmployeeAppointment()
    {
        $search = $this->input->get('search', TRUE);
        $data = $this->ModelMaster->searchLocation($search);

        $result = [];
        foreach ($data as $row) {
            $result[] = [
                'id' => $row->id,
                'text' => $row->name // ✅ ubah dari 'name' ke 'text'
            ];
        }

        echo json_encode($result);
    }

    public function searchJobEmployeeAppointment()
    {
        $search = $this->input->get('search', TRUE); // TRUE untuk XSS filter
        $data = $this->ModelMaster->searchJob($search);

        $result = [];
        foreach ($data as $row) {
            $result[] = [
                'id' => $row->id,
                'text' => $row->name // ✅ ubah dari 'name' ke 'text'
            ];
        }

        echo json_encode($result);
    }


    public function searchCompany()
    {
        $search = $this->input->get('search', TRUE); // TRUE untuk XSS filter
        $data = $this->ModelMaster->searchCompany($search);

        $result = array_map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
            ];
        }, $data);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function searchWarehouse()
    {
        $search = $this->input->get('search', TRUE); // TRUE untuk XSS filter
        $data = $this->ModelMaster->searchWarehouse($search);

        $result = array_map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
            ];
        }, $data);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }


    public function searchAllowance()
    {
        $search = $this->input->get('search', TRUE); // TRUE untuk XSS filter
        $data = $this->ModelMaster->searchAllowance($search);

        $result = array_map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
            ];
        }, $data);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }


    public function searchEmployee()
    {
        $search = $this->input->get('search', TRUE); // TRUE untuk XSS filter
        $data = $this->ModelMaster->searchEmployee($search);

        $result = array_map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
                'nip' => $row->nip
            ];
        }, $data);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

}


