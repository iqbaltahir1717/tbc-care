<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Regulation extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_regulation');
        $this->load->model('m_regulation_category');
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
        $this->session->unset_userdata('sess_search_regulation');

        // PAGINATION
        $baseUrl    = base_url() . "admin/regulation/index/";
        $totalRows  = count((array) $this->m_regulation->read('','','',''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        

        
        //DATA
        $data['setting']             = getSetting();
        $data['title']               = 'Produk Hukum';
        $data['regulation']          = $this->m_regulation->read($perPage, $page,'','');
        $data['regulation_category'] = $this->m_regulation_category->read($perPage, $page,'');
		
        
        // TEMPLATE
		$view         = "_backend/regulation/regulation";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function search() {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_regulation', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_regulation');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "admin/regulation/search/".$data['search']."/";
        $totalRows  = count((array)$this->m_regulation->read('','',$data['search'],''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting']             = getSetting();
        $data['title']               = 'Produk Hukum';
        $data['regulation']          = $this->m_regulation->read($perPage, $page, $data['search'],'');
        $data['regulation_category'] = $this->m_regulation_category->read($perPage, $page,'');
        
        // TEMPLATE
		$view         = "_backend/regulation/regulation";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function create() {
        csrfValidate();

        $path = './upload/regulation/';

        $filename_1              = "regulation-".date('YmdHis');
        $config['upload_path']   = $path;
        $config['allowed_types'] = "doc|docx|pdf|xls|xlsx";
        $config['overwrite']     = "true";
        $config['max_size']      = "0";
        $config['max_width']     = "10000";
        $config['max_height']    = "10000";
        $config['file_name']     = '' . $filename_1;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('regulation_file')) { 
            // ALERT
            $alertStatus  = "failed";
            $alertMessage = $this->upload->display_errors();
            getAlert($alertStatus, $alertMessage);
        } else {
            $dat  = $this->upload->data();

            // POST
            $data['regulation_id']          = '';
            $data['regulation_name']        = $this->input->post('regulation_name');
            $data['regulation_category_id'] = $this->input->post('regulation_category_id');
            $data['regulation_file']        = $dat['file_name'];
            $data['createtime']             = date('Y-m-d H:i:s');
            $this->m_regulation->create($data);

            // LOG
            $message    = $this->session->userdata('user_name')." menambah data produk hukum dengan nama = ".$data['regulation_file'];
            createLog($message);

            // ALERT
            $alertStatus  = "success";
            $alertMessage = "Berhasil menambah data produk hukum dengan nama = ".$data['regulation_file'];
            getAlert($alertStatus, $alertMessage);
        }
        

        redirect('admin/regulation');
    }
    

    public function update() {
        csrfValidate();

        if($_FILES['regulation_file']['name'] !=""){
            $path = './upload/regulation/';

            $filename_1              = "regulation-".date('YmdHis');
            $config['upload_path']   = $path;
            $config['allowed_types'] = "doc|docx|pdf|xls|xlsx";
            $config['overwrite']     = "true";
            $config['max_size']      = "0";
            $config['max_width']     = "10000";
            $config['max_height']    = "10000";
            $config['file_name']     = '' . $filename_1;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('regulation_file')) { 
                // ALERT
                $alertStatus  = "failed";
                $alertMessage = $this->upload->display_errors();
                getAlert($alertStatus, $alertMessage);
            } else {
                $dat  = $this->upload->data();
                unlink($path.$this->input->post('regulation_file_old'));
                // POST
                $data['regulation_id']          = $this->input->post('regulation_id');
                $data['regulation_name']        = $this->input->post('regulation_name');
                $data['regulation_category_id'] = $this->input->post('regulation_category_id');
                $data['regulation_file']        = $dat['file_name'];
                $this->m_regulation->update($data);

                // LOG
                $message    = $this->session->userdata('user_name')." menambah data produk hukum dengan ID = ".$data['regulation_id'];
                createLog($message);

                // ALERT
                $alertStatus  = "success";
                $alertMessage = "Berhasil menambah data produk hukum ".$data['regulation_id'];
                getAlert($alertStatus, $alertMessage);
            }
        }else{
            // POST
            $data['regulation_id']          = $this->input->post('regulation_id');
            $data['regulation_name']        = $this->input->post('regulation_name');
            $data['regulation_category_id'] = $this->input->post('regulation_category_id');
            $this->m_regulation->update($data);

            // LOG
            $message    = $this->session->userdata('user_name')." mengubah data produk hukum dengan ID = ".$data['regulation_id'];
            createLog($message);

            // ALERT
            $alertStatus  = "success";
            $alertMessage = "Berhasil mengubah data produk hukum dengan ID = ".$data['regulation_id'];
            getAlert($alertStatus, $alertMessage);
        }


        redirect('admin/regulation');
    }
    

    public function delete() {
        csrfValidate();
        // POST
        $this->m_regulation->delete($this->input->post('regulation_id'));
        unlink('./upload/regulation/'.$this->input->post('regulation_file'));
        // LOG
        $message    = $this->session->userdata('user_name')." menghapus data produk hukum dengan ID = ".$this->input->post('regulation_id')." - ".$this->input->post('regulation_id');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data produk hukum : ".$this->input->post('regulation_id');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/regulation');
    }
    
}
?>