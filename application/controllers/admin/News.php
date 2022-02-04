<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class News extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_news');
        $this->load->model('m_news_category');
        $this->load->model('m_field');
        $this->load->library('upload');

        if (!($this->session->userdata('user_id'))) {
            // ALERT
			$alertStatus  = 'failed';
			$alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
			getAlert($alertStatus, $alertMessage);
			redirect('auth');
        }
    }
    

    public function index() {
        $this->session->unset_userdata('sess_search_news');

        // PAGINATION
        $baseUrl    = base_url() . "admin/news/index/";
        $totalRows  = count((array) $this->m_news->read('','','','',''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        

        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Informasi';
        $data['news']    = $this->m_news->read($perPage, $page,'','','');
		
        
        // TEMPLATE
		$view         = "_backend/news/data";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function search() {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_news', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_news');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "admin/news/search/".$data['search']."/";
        $totalRows  = count((array)$this->m_news->read('','',$data['search'],'',''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Informasi';
        $data['news']    = $this->m_news->read($perPage, $page, $data['search'],'','');
        
        // TEMPLATE
		$view         = "_backend/news/data";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }


    public function create_page() {
        //DATA
        $data['setting']       = getSetting();
        $data['title']         = 'Informasi';
        $data['field']         = $this->m_field->read('','','',);
        $data['news_category'] = $this->m_news_category->read('','','');
		
        // TEMPLATE
		$view         = "_backend/news/_create";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }


    public function update_page() {
        //DATA
        $data['setting']       = getSetting();
        $data['title']         = 'Informasi';
        $data['news']          = $this->m_news->get($this->uri->segment(4));
        $data['field']         = $this->m_field->read('','','');
        $data['news_category'] = $this->m_news_category->read('','','');
		
        // TEMPLATE
		$view         = "_backend/news/_update";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }


    public function detail_page() {
        //DATA
        $data['setting']       = getSetting();
        $data['title']         = 'Informasi';
        $data['news']          = $this->m_news->get($this->uri->segment(4));
        $data['field']         = $this->m_field->read('','','');
        $data['news_category'] = $this->m_news_category->read('','','');
		
        // TEMPLATE
		$view         = "_backend/news/_detail";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }
    

    public function create() {
        csrfValidate();

        $filename_1              = "thumbnailnews-".date('YmdHis');
        $config['upload_path']   = "./upload/news/";
        $config['allowed_types'] = "jpg|png|jpeg";
        $config['overwrite']     = "true";
        $config['max_size']      = "0";
        $config['max_width']     = "10000";
        $config['max_height']    = "10000";
        $config['file_name']     = '' . $filename_1;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('news_cover')) {
            // ALERT
            $alertStatus  = "failed";
            $alertMessage = $this->upload->display_errors();
            getAlert($alertStatus, $alertMessage);

        } else {
            $dat  = $this->upload->data();
            $data['news_cover']       = $dat['file_name'];
        }


        // POST
        $data['news_id']          = '';
        $data['news_title']       = $this->input->post('news_title');
        $data['news_text']        = $this->input->post('news_text');
        $data['news_date']        = date('Y-m-d');
        $data['news_count_view']  = 0;
        $data['news_slug']        = url_title($data['news_title'], 'dash', true);
        $data['field_id']         = $this->input->post('field_id');
        $data['news_category_id'] = $this->input->post('news_category_id');
        $data['user_id']          = $this->session->userdata('user_id');
        $data['createtime']       = date('Y-m-d H:i:s');
        $this->m_news->create($data);

        // LOG
        $message    = $this->session->userdata('user_name')." menambah data informasi ";
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil menambah data informasi ";
        getAlert($alertStatus, $alertMessage);

        redirect('admin/news');
    }
    

    public function update() {
        csrfValidate();

        if($_FILES['news_cover']['name']!=""){  
            $filename_1              = "thumbnailnews-".date('YmdHis');
            $config['upload_path']   = "./upload/news/";
            $config['allowed_types'] = "jpg|png|jpeg";
            $config['overwrite']     = "true";
            $config['max_size']      = "0";
            $config['max_width']     = "10000";
            $config['max_height']    = "10000";
            $config['file_name']     = '' . $filename_1;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('news_cover')) {
                
                // ALERT
                $alertStatus  = "failed";
                $alertMessage = $this->upload->display_errors();
                getAlert($alertStatus, $alertMessage);

            } else {
                $dat  = $this->upload->data();

                unlink('./upload/news/'. $this->input->post('news_cover_old'));


                $data['news_id']          = $this->input->post('news_id');
                $data['news_title']       = $this->input->post('news_title');
                $data['news_cover']       = $dat['file_name'];
                $data['news_text']        = $this->input->post('news_text');
                $data['news_slug']        = url_title($data['news_title'], 'dash', true);
                $data['field_id']         = $this->input->post('field_id');
                $data['news_category_id'] = $this->input->post('news_category_id');
                $this->m_news->update($data);
    
                // LOG
                $message    = $this->session->userdata('user_name')." mengubah data informasi dengan ID = ".$data['news_id'];
                createLog($message);
    
                // ALERT
                $alertStatus  = "success";
                $alertMessage = "Berhasil mengubah data informasi ID : ".$data['news_id'];
                getAlert($alertStatus, $alertMessage);
            }
        }else{
            // POST
            $data['news_id']          = $this->input->post('news_id');
            $data['news_title']       = $this->input->post('news_title');
            $data['news_text']        = $this->input->post('news_text');
            $data['news_slug']        = url_title($data['news_title'], 'dash', true);
            $data['field_id']         = $this->input->post('field_id');
            $data['news_category_id'] = $this->input->post('news_category_id');
            $this->m_news->update($data);

            // LOG
            $message    = $this->session->userdata('user_name')." mengubah data informasi dengan ID = ".$data['news_id'];
            createLog($message);

            // ALERT
            $alertStatus  = "success";
            $alertMessage = "Berhasil mengubah data informasi ID : ".$data['news_id'];
            getAlert($alertStatus, $alertMessage);
        }

        

        redirect('admin/news');
    }
    

    public function delete() {
        csrfValidate();
        // POST
        $this->m_news->delete($this->input->post('news_id'));
        
        // LOG
        $message    = $this->session->userdata('user_name')." menghapus data informasi dengan ID = ".$this->input->post('news_id');
        createLog($message);

        // ALERT
        $alertStatus  = "failed";
        $alertMessage = "Menghapus data informasi ID : ".$this->input->post('news_id');
        getAlert($alertStatus, $alertMessage);

        redirect('admin/news');
    }


    
}
?>