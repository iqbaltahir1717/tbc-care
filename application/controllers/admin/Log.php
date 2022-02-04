<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Log extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_log');
        if (!$this->session->userdata('user_id') OR $this->session->userdata('user_group')!=1) {
			// ALERT
			$alertStatus  = 'failed';
			$alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
			getAlert($alertStatus, $alertMessage);
			redirect('admin/dashboard');
		}
    }
    

    public function index() {
        $this->session->unset_userdata('sess_search_log');

        // PAGINATION
        $baseUrl    = base_url() . "admin/log/index/";
        $totalRows  = count((array) $this->m_log->read('','',''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        

        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Log Sistem';
        $data['log']     = $this->m_log->read($perPage, $page,'');
		
        
        // TEMPLATE
		$view         = "_backend/log";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function search() {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_log', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_log');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "admin/log/search/".$data['search']."/";
        $totalRows  = count((array)$this->m_log->read('','',$data['search']));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Log Sistem';
        $data['log']     = $this->m_log->read($perPage, $page, $data['search']);
        
        // TEMPLATE
		$view         = "_backend/log";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    
}
?>