<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Group extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_group');
        if (!$this->session->userdata('user_id') OR $this->session->userdata('user_group')!=1) {
			// ALERT
			$alertStatus  = 'failed';
			$alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
			getAlert($alertStatus, $alertMessage);
			redirect('admin/dashboard');
		}
    }
    

    public function index() {
        $this->session->unset_userdata('sess_search_group');

        // PAGINATION
        $baseUrl    = base_url() . "admin/group/index/";
        $totalRows  = count((array) $this->m_group->read('','',''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        

        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Group';
        $data['group']   = $this->m_group->read($perPage, $page,'');
		
        
        // TEMPLATE
		$view         = "_backend/master_data/group";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function search() {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_group', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_group');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "admin/group/search/".$data['search']."/";
        $totalRows  = count((array)$this->m_group->read('','',$data['search']));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Group';
        $data['group']   = $this->m_group->read($perPage, $page, $data['search']);
        
        // TEMPLATE
		$view         = "_backend/master_data/group";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function create() {
        csrfValidate();
        // POST
        $data['group_id']   = '';
        $data['group_name'] = $this->input->post('group_name');
        $data['createtime'] = date('Y-m-d H:i:s');
        $this->m_group->create($data);

        // LOG
        $message    = $this->session->userdata('user_name')." menambah data group ".$data['group_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil menambah data group ".$data['group_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/group');
    }
    

    public function update() {
        csrfValidate();
        // POST
        $data['group_id']      = $this->input->post('group_id');
        $data['group_name']    = $this->input->post('group_name');
        $this->m_group->update($data);

        // LOG
        $message    = $this->session->userdata('user_name')." mengubah data group dengan ID = ".$data['group_id']." - ".$data['group_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil mengubah data group : ".$data['group_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/group');
    }
    

    public function delete() {
        csrfValidate();
        // POST
        $this->m_group->delete($this->input->post('group_id'));
        
        // LOG
        $message    = $this->session->userdata('user_name')." menghapus data group dengan ID = ".$this->input->post('group_id')." - ".$this->input->post('group_name');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data group : ".$this->input->post('group_name');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/group');
    }
    
}
?>