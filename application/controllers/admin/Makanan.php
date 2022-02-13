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
        $data['title']   = 'User';
        $data['food']    = $this->m_food->read($perPage, $page, '');
        $data['category_fod']   = $this->m_category_food->read('', '', '');


        // TEMPLATE
        $view         = "_backend/main/makanan";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }


    public function search()
    {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_user', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_user');
        }

        // PAGINATION
        $baseUrl    = base_url() . "admin/user/search/" . $data['search'] . "/";
        $totalRows  = count((array)$this->m_user->read('', '', $data['search']));
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
        $data['user']    = $this->m_user->read($perPage, $page, $data['search']);
        $data['group']   = $this->m_group->read('', '', '');

        // TEMPLATE
        $view         = "_backend/master_data/user";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }


    public function create()
    {
        csrfValidate();
        // POST
        $data['user_id']        = '';
        $data['user_name']      = $this->input->post('user_name');
        $data['user_password']  = password_hash($this->input->post('user_password'), PASSWORD_BCRYPT);
        $data['user_fullname']  = $this->input->post('user_fullname');
        $data['user_email']     = $this->input->post('user_email');
        $data['user_lastlogin'] = '';
        $data['user_photo']     = '';
        $data['group_id']       = $this->input->post('group_id');
        $data['createtime']     = date('Y-m-d H:i:s');
        $this->m_user->create($data);

        // LOG
        $message    = $this->session->userdata('user_name') . " menambah data user " . $data['user_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil menambah data user " . $data['user_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/user');
    }


    public function update()
    {
        csrfValidate();
        // POST
        $data['user_id']       = $this->input->post('user_id');
        $data['user_name']     = $this->input->post('user_name');

        if ($this->input->post('user_password') != "") {
            $data['user_password'] = password_hash($this->input->post('user_password'), PASSWORD_BCRYPT);
        }

        $data['user_fullname'] = $this->input->post('user_fullname');
        $data['user_email']    = $this->input->post('user_email');
        $data['group_id']      = $this->input->post('group_id');
        $this->m_user->update($data);

        // LOG
        $message    = $this->session->userdata('user_name') . " mengubah data user dengan ID = " . $data['user_id'] . " - " . $data['user_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil mengubah data user : " . $data['user_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/user');
    }


    public function delete()
    {
        csrfValidate();
        // POST
        $this->m_user->delete($this->input->post('user_id'));

        // LOG
        $message    = $this->session->userdata('user_name') . " menghapus data user dengan ID = " . $this->input->post('user_id') . " - " . $this->input->post('user_name');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data user : " . $this->input->post('user_name');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/user');
    }
}
