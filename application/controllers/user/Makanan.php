<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Makanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_food');
        $this->load->model('m_category_food');

        if (!$this->session->userdata('user_id') or $this->session->userdata('user_group') != 1) {
            // ALERT
            $alertStatus  = 'failed';
            $alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
            getAlert($alertStatus, $alertMessage);
            redirect('admin/dashboard');
        }
    }


    public function index()
    {
        $this->session->unset_userdata('sess_search_food');

        // PAGINATION
        $baseUrl    = base_url() . "admin/user/index/";
        $totalRows  = count((array) $this->m_food->read('', '', ''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;

        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows;

        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Menu Makanan';
        $data['food']    = $this->m_food->read($perPage, $page, '');
        $data['category_food']   = $this->m_category_food->read('', '', '');


        // TEMPLATE
        $view         = "_backend/main/makanan";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }


    public function search()
    {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_food', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_food');
        }

        // PAGINATION
        $baseUrl    = base_url() . "admin/makanan/search/" . $data['search'] . "/";
        $totalRows  = count((array)$this->m_food->read('', '', $data['search']));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;

        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows;

        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'List Menu Makanan';
        $data['food']    = $this->m_food->read($perPage, $page, $data['search']);
        $data['category_food']   = $this->m_category_food->read('', '', '');

        // TEMPLATE
        $view         = "_backend/main/makanan";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }


    public function create()
    {
        csrfValidate();
        // POST
        $data['food_id']        = '';
        $data['food_name']      = $this->input->post('food_name');
        $data['food_kkal']  = $this->input->post('food_kkal');
        $data['food_name2']     = $this->input->post('food_name2');
        $data['food_kkal2']  = $this->input->post('food_kkal2');
        $data['food_name3']     = $this->input->post('food_name3');
        $data['food_kkal3']  = $this->input->post('food_kkal3');
        $data['category_food_id']       = $this->input->post('category_food_id');
        $data['food_details']       = $this->input->post('food_details');
        $this->m_food->create($data);

        // LOG
        $message    = $this->session->userdata('user_name') . " menambah data makanan ";
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil menambah data makanan #" . $data['food_id'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/makanan');
    }


    public function update()
    {
        csrfValidate();
        // POST
        $data['food_id']       = $this->input->post('food_id');
        $data['food_name']      = $this->input->post('food_name');
        $data['food_kkal']  = $this->input->post('food_kkal');
        $data['food_name2']     = $this->input->post('food_name2');
        $data['food_kkal2']  = $this->input->post('food_kkal2');
        $data['food_name3']     = $this->input->post('food_name3');
        $data['food_kkal3']  = $this->input->post('food_kkal3');
        $data['category_food_id']       = $this->input->post('category_food_id');
        $data['food_details']       = $this->input->post('food_details');
        $this->m_food->update($data);

        // LOG
        $message    = $this->session->userdata('user_name') . " mengubah data makanan dengan ID = " . $data['food_id'] . " - " . $data['food_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil mengubah data makanan : #" . $data['food_id'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/makanan');
    }


    public function delete()
    {
        csrfValidate();
        // POST
        $this->m_food->delete($this->input->post('food_id'));

        // LOG
        $message    = $this->session->userdata('food_id') . " menghapus data makanan dengan ID = " . $this->input->post('food_id') . " - " . $this->input->post('food_id');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data makanan : " . $this->input->post('food_nid');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/makanan');
    }
}
