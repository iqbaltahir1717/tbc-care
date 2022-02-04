<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Corebase_crud extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_corebase_crud');
        if (!$this->session->userdata('user_id') OR $this->session->userdata('user_group')!=1) {
			// ALERT
			$alertStatus  = 'failed';
			$alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
			getAlert($alertStatus, $alertMessage);
			redirect('admin/dashboard');
		}
    }
    

    public function index() {
        $this->session->unset_userdata('sess_search_corebase_crud');

        // PAGINATION
        $baseUrl    = base_url() . "admin/corebase_crud/index/";
        $totalRows  = count((array) $this->m_corebase_crud->read('','',''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        

        
        //DATA
        $data['setting']       = getSetting();
        $data['title']         = 'Corebase CRUD';
        $data['corebase_crud'] = $this->m_corebase_crud->read($perPage, $page,'');
		
        
        // TEMPLATE
		$view         = "_backend/corebase_crud";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function search() {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_corebase_crud', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_corebase_crud');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "admin/corebase_crud/search/".$data['search']."/";
        $totalRows  = count((array)$this->m_corebase_crud->read('','',$data['search']));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting']       = getSetting();
        $data['title']         = 'Corebase CRUD';
        $data['corebase_crud'] = $this->m_corebase_crud->read($perPage, $page, $data['search']);
        
        // TEMPLATE
		$view         = "_backend/corebase_crud";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function create() {
        csrfValidate();
        // POST
        $data['corebase_crud_id']   = '';
        $data['corebase_crud_name'] = $this->input->post('corebase_crud_name');
        $data['createtime']         = date('Y-m-d H:i:s');
        $this->m_corebase_crud->create($data);

        // LOG
        $message    = $this->session->userdata('user_name')." menambah data corebase_crud ".$data['corebase_crud_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil menambah data corebase_crud ".$data['corebase_crud_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/corebase_crud');
    }
    

    public function update() {
        csrfValidate();
        // POST
        $data['corebase_crud_id']   = $this->input->post('corebase_crud_id');
        $data['corebase_crud_name'] = $this->input->post('corebase_crud_name');
        $this->m_corebase_crud->update($data);

        // LOG
        $message    = $this->session->userdata('user_name')." mengubah data corebase_crud dengan ID = ".$data['corebase_crud_id']." - ".$data['corebase_crud_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil mengubah data corebase_crud : ".$data['corebase_crud_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/corebase_crud');
    }
    

    public function delete() {
        csrfValidate();
        // POST
        $this->m_corebase_crud->delete($this->input->post('corebase_crud_id'));
        
        // LOG
        $message    = $this->session->userdata('user_name')." menghapus data corebase_crud dengan ID = ".$this->input->post('corebase_crud_id')." - ".$this->input->post('corebase_crud_name');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data corebase_crud : ".$this->input->post('corebase_crud_name');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/corebase_crud');
    }
    
}
?>