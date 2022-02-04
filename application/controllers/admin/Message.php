<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Message extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_message');
        if (!$this->session->userdata('user_id') OR $this->session->userdata('user_group')!=1) {
			// ALERT
			$alertStatus  = 'failed';
			$alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
			getAlert($alertStatus, $alertMessage);
			redirect('admin/dashboard');
		}
    }
    

    public function index() {
        $this->session->unset_userdata('sess_search_message');

        // PAGINATION
        $baseUrl    = base_url() . "admin/message/index/";
        $totalRows  = count((array) $this->m_message->read('','','',''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        

        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Pesan';
        $data['message'] = $this->m_message->read($perPage, $page,'','');
		
        
        // TEMPLATE
		$view         = "_backend/message";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function search() {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_message', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_message');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "admin/message/search/".$data['search']."/";
        $totalRows  = count((array)$this->m_message->read('','',$data['search'],''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Pesan';
        $data['message'] = $this->m_message->read($perPage, $page, $data['search'],'');
        
        // TEMPLATE
		$view         = "_backend/message";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function update() {
        csrfValidate();
        // POST
        $data['message_id']     = $this->input->post('message_id');
        $data['message_reply']  = $this->input->post('message_reply');
        $data['message_status'] = 1;
        $this->m_message->update($data);

        // LOG
        $message    = $this->session->userdata('user_name')." mengubah data message dengan ID = ".$this->input->post('message_code');
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil mengubah data message : ".$this->input->post('message_code');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/message');
    }
    

    public function delete() {
        csrfValidate();
        // POST
        $this->m_message->delete($this->input->post('message_id'));
        
        // LOG
        $message    = $this->session->userdata('user_name')." menghapus data message dengan ID = ".$this->input->post('message_id')." - ".$this->input->post('message_name');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data message : ".$this->input->post('message_name');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/message');
    }
    
}
?>