<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Link extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_link');
        $this->load->library('upload');
        if (!$this->session->userdata('user_id') OR $this->session->userdata('user_group')!=1) {
			// ALERT
			$alertStatus  = 'failed';
			$alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
			getAlert($alertStatus, $alertMessage);
			redirect('admin/dashboard');
		}
    }
    

    public function index() {
        $this->session->unset_userdata('sess_search_link');

        // PAGINATION
        $baseUrl    = base_url() . "admin/link/index/";
        $totalRows  = count((array) $this->m_link->read('','',''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        

        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Link Terkait';
        $data['link']    = $this->m_link->read($perPage, $page,'');
		
        
        // TEMPLATE
		$view         = "_backend/link";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function search() {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_link', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_link');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "admin/link/search/".$data['search']."/";
        $totalRows  = count((array)$this->m_link->read('','',$data['search']));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Link Terkait';
        $data['link']    = $this->m_link->read($perPage, $page, $data['search']);
        
        // TEMPLATE
		$view         = "_backend/link";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function create() {
        csrfValidate();

        $path = './upload/link/';

        $filename_1              = "link-".date('YmdHis');
        $config['upload_path']   = $path;
        $config['allowed_types'] = "jpg|jpeg|png";
        $config['overwrite']     = "true";
        $config['max_size']      = "0";
        $config['file_name']     = '' . $filename_1;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('link_image')) { 
            // ALERT
            $alertStatus  = "failed";
            $alertMessage = $this->upload->display_errors();
            getAlert($alertStatus, $alertMessage);
        } else {
            $dat  = $this->upload->data();

            // POST
            $data['link_id']    = '';
            $data['link_name']  = $this->input->post('link_name');
            $data['link_url']   = $this->input->post('link_url');
            $data['link_image'] = $dat['file_name'];
            $data['createtime'] = date('Y-m-d H:i:s');
            $this->m_link->create($data);

            // LOG
            $message    = $this->session->userdata('user_name')." menambah data link terkait dengan nama = ".$data['link_image'];
            createLog($message);

            // ALERT
            $alertStatus  = "success";
            $alertMessage = "Berhasil menambah data link terkait dengan nama = ".$data['link_image'];
            getAlert($alertStatus, $alertMessage);
        }
        

        redirect('admin/link');
    }
    

    public function update() {
        csrfValidate();

        if($_FILES['link_image']['name'] !=""){
            $path = './upload/link/';

            $filename_1              = "link-".date('YmdHis');
            $config['upload_path']   = $path;
            $config['allowed_types'] = "jpg|jpeg|png";
            $config['overwrite']     = "true";
            $config['max_size']      = "0";
            $config['file_name']     = '' . $filename_1;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('link_image')) { 
                // ALERT
                $alertStatus  = "failed";
                $alertMessage = $this->upload->display_errors();
                getAlert($alertStatus, $alertMessage);
            } else {
                $dat  = $this->upload->data();
                unlink($path.$this->input->post('link_image_old'));
                // POST
                $data['link_id']    = $this->input->post('link_id');
                $data['link_name']  = $this->input->post('link_name');
                $data['link_url']   = $this->input->post('link_url');
                $data['link_image'] = $dat['file_name'];
                $this->m_link->update($data);

                // LOG
                $message    = $this->session->userdata('user_name')." menambah data link terkait dengan ID = ".$data['link_id'];
                createLog($message);

                // ALERT
                $alertStatus  = "success";
                $alertMessage = "Berhasil menambah data link terkait ".$data['link_id'];
                getAlert($alertStatus, $alertMessage);
            }
        }else{
            // POST
            $data['link_id']   = $this->input->post('link_id');
            $data['link_name'] = $this->input->post('link_name');
            $data['link_url']  = $this->input->post('link_url');
            $this->m_link->update($data);

            // LOG
            $message    = $this->session->userdata('user_name')." mengubah data link terkait dengan ID = ".$data['link_id'];
            createLog($message);

            // ALERT
            $alertStatus  = "success";
            $alertMessage = "Berhasil mengubah data link terkait dengan ID = ".$data['link_id'];
            getAlert($alertStatus, $alertMessage);
        }


        redirect('admin/link');
    }
    

    public function delete() {
        csrfValidate();
        // POST
        $this->m_link->delete($this->input->post('link_id'));
        unlink('./upload/link/'.$this->input->post('link_image'));
        // LOG
        $message    = $this->session->userdata('user_name')." menghapus data link terkait dengan ID = ".$this->input->post('link_id')." - ".$this->input->post('link_id');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data link terkait : ".$this->input->post('link_id');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/link');
    }
    
}
?>