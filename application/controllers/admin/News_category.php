<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class News_category extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_news_category');
        if (!$this->session->userdata('user_id') OR $this->session->userdata('user_group')!=1) {
			// ALERT
			$alertStatus  = 'failed';
			$alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
			getAlert($alertStatus, $alertMessage);
			redirect('admin/dashboard');
		}
    }
    

    public function index() {
        $this->session->unset_userdata('sess_search_news_category');

        // PAGINATION
        $baseUrl    = base_url() . "admin/news_category/index/";
        $totalRows  = count((array) $this->m_news_category->read('','',''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        

        
        //DATA
        $data['setting']       = getSetting();
        $data['title']         = 'Kategori Informasi';
        $data['news_category'] = $this->m_news_category->read($perPage, $page,'');
		
        
        // TEMPLATE
		$view         = "_backend/news/news_category";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function search() {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_news_category', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_news_category');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "admin/news_category/search/".$data['search']."/";
        $totalRows  = count((array)$this->m_news_category->read('','',$data['search']));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting']       = getSetting();
        $data['title']         = 'Kategori Informasi';
        $data['news_category'] = $this->m_news_category->read($perPage, $page, $data['search']);
        
        // TEMPLATE
		$view         = "_backend/news/news_category";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function create() {
        csrfValidate();
        // POST
        $data['news_category_id']   = '';
        $data['news_category_name'] = $this->input->post('news_category_name');
        $data['createtime']         = date('Y-m-d H:i:s');
        $this->m_news_category->create($data);

        // LOG
        $message    = $this->session->userdata('user_name')." menambah data kategori informasi ".$data['news_category_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil menambah data kategori informasi ".$data['news_category_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/news_category');
    }
    

    public function update() {
        csrfValidate();
        // POST
        $data['news_category_id']   = $this->input->post('news_category_id');
        $data['news_category_name'] = $this->input->post('news_category_name');
        $this->m_news_category->update($data);

        // LOG
        $message    = $this->session->userdata('user_name')." mengubah data kategori informasi dengan ID = ".$data['news_category_id']." - ".$data['news_category_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil mengubah data kategori informasi : ".$data['news_category_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/news_category');
    }
    

    public function delete() {
        csrfValidate();
        // POST
        $this->m_news_category->delete($this->input->post('news_category_id'));
        
        // LOG
        $message    = $this->session->userdata('user_name')." menghapus data kategori informasi dengan ID = ".$this->input->post('news_category_id')." - ".$this->input->post('news_category_name');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data kategori informasi : ".$this->input->post('news_category_name');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/news_category');
    }
    
}
?>