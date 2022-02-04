<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Regulation_category extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_regulation_category');
        if (!$this->session->userdata('user_id') OR $this->session->userdata('user_group')!=1) {
			// ALERT
			$alertStatus  = 'failed';
			$alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
			getAlert($alertStatus, $alertMessage);
			redirect('admin/dashboard');
		}
    }
    

    public function index() {
        $this->session->unset_userdata('sess_search_regulation_category');

        // PAGINATION
        $baseUrl    = base_url() . "admin/regulation_category/index/";
        $totalRows  = count((array) $this->m_regulation_category->read('','',''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        

        
        //DATA
        $data['setting']             = getSetting();
        $data['title']               = 'Kateogri Produk Hukum';
        $data['regulation_category'] = $this->m_regulation_category->read($perPage, $page,'');
		
        
        // TEMPLATE
		$view         = "_backend/regulation/regulation_category";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function search() {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_regulation_category', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_regulation_category');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "admin/regulation_category/search/".$data['search']."/";
        $totalRows  = count((array)$this->m_regulation_category->read('','',$data['search']));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting']             = getSetting();
        $data['title']               = 'Kateogri Produk Hukum';
        $data['regulation_category'] = $this->m_regulation_category->read($perPage, $page, $data['search']);
        
        // TEMPLATE
		$view         = "_backend/regulation/regulation_category";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function create() {
        csrfValidate();
        // POST
        $data['regulation_category_id']   = '';
        $data['regulation_category_name'] = $this->input->post('regulation_category_name');
        $data['createtime']               = date('Y-m-d H:i:s');
        $this->m_regulation_category->create($data);

        // LOG
        $message    = $this->session->userdata('user_name')." menambah data kategori produk hukum ".$data['regulation_category_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil menambah data kategori produk hukum ".$data['regulation_category_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/regulation_category');
    }
    

    public function update() {
        csrfValidate();
        // POST
        $data['regulation_category_id']   = $this->input->post('regulation_category_id');
        $data['regulation_category_name'] = $this->input->post('regulation_category_name');
        $this->m_regulation_category->update($data);

        // LOG
        $message    = $this->session->userdata('user_name')." mengubah data kategori produk hukum dengan ID = ".$data['regulation_category_id']." - ".$data['regulation_category_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil mengubah data kategori produk hukum : ".$data['regulation_category_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/regulation_category');
    }
    

    public function delete() {
        csrfValidate();
        // POST
        $this->m_regulation_category->delete($this->input->post('regulation_category_id'));
        
        // LOG
        $message    = $this->session->userdata('user_name')." menghapus data kategori produk hukum dengan ID = ".$this->input->post('regulation_category_id')." - ".$this->input->post('regulation_category_name');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data kategori produk hukum : ".$this->input->post('regulation_category_name');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/regulation_category');
    }
    
}
?>