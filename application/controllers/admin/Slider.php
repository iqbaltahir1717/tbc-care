<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Slider extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_slider');
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
        $this->session->unset_userdata('sess_search_slider');

        // PAGINATION
        $baseUrl    = base_url() . "admin/slider/index/";
        $totalRows  = count((array) $this->m_slider->read('','',''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        

        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Slider';
        $data['slider']  = $this->m_slider->read($perPage, $page,'');
		
        
        // TEMPLATE
		$view         = "_backend/slider";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function search() {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_slider', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_slider');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "admin/slider/search/".$data['search']."/";
        $totalRows  = count((array)$this->m_slider->read('','',$data['search']));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Slider';
        $data['slider']  = $this->m_slider->read($perPage, $page, $data['search']);
        
        // TEMPLATE
		$view         = "_backend/slider";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function create() {
        csrfValidate();

        $path = './upload/slider/';

        $filename_1              = "slider-".date('YmdHis');
        $config['upload_path']   = $path;
        $config['allowed_types'] = "png|jpeg|jpg";
        $config['overwrite']     = "true";
        $config['max_size']      = "0";
        $config['max_width']     = "10000";
        $config['max_height']    = "10000";
        $config['file_name']     = '' . $filename_1;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('slider_image')) { 
            // ALERT
            $alertStatus  = "failed";
            $alertMessage = $this->upload->display_errors();
            getAlert($alertStatus, $alertMessage);
        } else {
            $dat  = $this->upload->data();

            // POST
            $data['slider_id']    = '';
            $data['slider_title'] = $this->input->post('slider_title');
            $data['slider_text']  = $this->input->post('slider_text');
            $data['slider_image'] = $dat['file_name'];
            $data['createtime']   = date('Y-m-d H:i:s');
            $this->m_slider->create($data);

            // LOG
            $message    = $this->session->userdata('user_name')." menambah data slider dengan name = ".$data['slider_image'];
            createLog($message);

            // ALERT
            $alertStatus  = "success";
            $alertMessage = "Berhasil menambah data slider dengan name = ".$data['slider_image'];
            getAlert($alertStatus, $alertMessage);
        }
        

        redirect('admin/slider');
    }
    

    public function update() {
        csrfValidate();

        if($_FILES['slider_image']['name'] !=""){
            $path = './upload/slider/';

            $filename_1              = "slider-".date('YmdHis');
            $config['upload_path']   = $path;
            $config['allowed_types'] = "png|jpeg|jpg";
            $config['overwrite']     = "true";
            $config['max_size']      = "0";
            $config['max_width']     = "10000";
            $config['max_height']    = "10000";
            $config['file_name']     = '' . $filename_1;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('slider_image')) { 
                // ALERT
                $alertStatus  = "failed";
                $alertMessage = $this->upload->display_errors();
                getAlert($alertStatus, $alertMessage);
            } else {
                $dat  = $this->upload->data();
                unlink($path.$this->input->post('slider_image_old'));
                // POST
                $data['slider_id']   = $this->input->post('slider_id');
                $data['slider_title'] = $this->input->post('slider_title');
                $data['slider_text']  = $this->input->post('slider_text');
                $data['slider_image'] = $dat['file_name'];
                $data['createtime']   = date('Y-m-d H:i:s');
                $this->m_slider->update($data);

                // LOG
                $message    = $this->session->userdata('user_name')." mengubah data slider dengan ID = ".$data['slider_id'];
                createLog($message);

                // ALERT
                $alertStatus  = "success";
                $alertMessage = "Berhasil mengubah data slider ".$data['slider_id'];
                getAlert($alertStatus, $alertMessage);
            }
        }else{
            // POST
            $data['slider_id']   = $this->input->post('slider_id');
            $data['slider_title'] = $this->input->post('slider_title');
            $data['slider_text']  = $this->input->post('slider_text');
            $data['createtime']   = date('Y-m-d H:i:s');
            $this->m_slider->update($data);

            // LOG
            $message    = $this->session->userdata('user_name')." mengubah data slider dengan ID = ".$data['slider_id'];
            createLog($message);

            // ALERT
            $alertStatus  = "success";
            $alertMessage = "Berhasil mengubah data slider dengan ID = ".$data['slider_id'];
            getAlert($alertStatus, $alertMessage);
        }



        redirect('admin/slider');
    }
    

    public function delete() {
        csrfValidate();
        // POST
        $this->m_slider->delete($this->input->post('slider_id'));
        unlink('./upload/slider/'.$this->input->post('slider_image'));
        // LOG
        $message    = $this->session->userdata('user_name')." menghapus data slider dengan ID = ".$this->input->post('slider_id')." - ".$this->input->post('slider_id');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data slider : ".$this->input->post('slider_id');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/slider');
    }
    
}
?>