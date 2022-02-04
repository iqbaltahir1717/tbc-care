<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Field extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_field');
        if (!($this->session->userdata('user_id'))) {
            // ALERT
			$alertStatus  = 'failed';
			$alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
			getAlert($alertStatus, $alertMessage);
			redirect('auth');
        }
    }
    

    public function index() {
        $this->session->unset_userdata('sess_search_field');

        // PAGINATION
        $baseUrl    = base_url() . "admin/field/index/";
        $totalRows  = count((array) $this->m_field->read('','',''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        

        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Bidang';
        $data['field']   = $this->m_field->read($perPage, $page,'');
		
        
        // TEMPLATE
		$view         = "_backend/news/field";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function search() {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_field', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_field');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "admin/field/search/".$data['search']."/";
        $totalRows  = count((array)$this->m_field->read('','',$data['search']));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Bidang';
        $data['field']   = $this->m_field->read($perPage, $page, $data['search']);
        
        // TEMPLATE
		$view         = "_backend/news/field";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function create() {
        csrfValidate();
        // POST
        $data['field_id']   = '';
        $data['field_name'] = $this->input->post('field_name');
        $data['createtime']         = date('Y-m-d H:i:s');
        $this->m_field->create($data);

        // LOG
        $message    = $this->session->userdata('user_name')." menambah data kategori bidang berita ".$data['field_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil menambah data kategori bidang berita ".$data['field_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/field');
    }
    

    public function update() {
        csrfValidate();
        // POST
        $data['field_id']   = $this->input->post('field_id');
        $data['field_name'] = $this->input->post('field_name');
        $this->m_field->update($data);

        // LOG
        $message    = $this->session->userdata('user_name')." mengubah data kategori bidang berita dengan ID = ".$data['field_id']." - ".$data['field_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil mengubah data kategori bidang berita : ".$data['field_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/field');
    }
    

    public function delete() {
        csrfValidate();
        // POST
        $this->m_field->delete($this->input->post('field_id'));
        
        // LOG
        $message    = $this->session->userdata('user_name')." menghapus data kategori bidang berita dengan ID = ".$this->input->post('field_id')." - ".$this->input->post('field_name');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data kategori bidang berita : ".$this->input->post('field_name');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/field');
    }
    
}
?>