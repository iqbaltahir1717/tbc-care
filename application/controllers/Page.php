<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
    function __construct() {
		parent::__construct();
		$this->load->model('m_regulation');
		$this->load->model('m_news');
		$this->load->model('m_gallery');
		$this->load->model('m_field');
		$this->load->model('m_message');
		$this->load->model('m_link');
		$this->load->model('m_regulation');
        $this->load->model('m_news_category');
		$this->load->model('m_regulation_category');
	}

	// REGULASI
	public function regulation(){

		$this->session->unset_userdata('sess_search_regulation');

        // PAGINATION
        $baseUrl    = base_url() . "page/regulation/".$this->uri->segment(3);
        $totalRows  = count((array) $this->m_regulation->read('','','', $this->uri->segment(3)));
        $perPage    = 10;
        $uriSegment = 4;
        $paging     = generatePaginationBlog($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
		// DATA
		$data['setting']                  = getSetting();
		$data['link']                     = $this->m_link->read('','','');
		$data['regulation']               = $this->m_regulation->read($perPage, $page,'',$this->uri->segment(3));
		$data['news_category']            = $this->m_news_category->read('','','');
		$data['regulation_category']      = $this->m_regulation_category->read('','','');
		$data['recent']                   = $this->m_news->read(3,0,'',1,'');
		$data['regulation_category_name'] = $this->m_regulation_category->get($this->uri->segment(3));

		// TEMPLATE
		$view         = "_frontend/page/regulation";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}


	public function regulation_search(){

		if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_regulation', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_regulation');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "page/regulation_search/".$this->uri->segment(3)."/".$data['search']."/";
        $totalRows  = count((array)$this->m_regulation->read('','',$data['search'], $this->uri->segment(3)));
        $perPage    = 10;
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting']                  = getSetting();
        $data['link']                     = $this->m_link->read('','','');
        $data['regulation']               = $this->m_regulation->read($perPage, $page, $data['search'], $this->uri->segment(3));
        $data['news_category']            = $this->m_news_category->read('','','');
        $data['regulation_category']      = $this->m_regulation_category->read('','','');
        $data['recent']                   = $this->m_news->read(3,0,'',1,'');
        $data['regulation_category_name'] = $this->m_regulation_category->get($this->uri->segment(3));

		// TEMPLATE
		$view         = "_frontend/page/regulation";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}



	// INFORMATION
    public function information(){
		$this->session->unset_userdata('sess_search_information');

        // PAGINATION
        $baseUrl    = base_url() . "page/information/".$this->uri->segment(3)."/".$this->uri->segment(4)."/";
        $totalRows  = count((array) $this->m_news->read('','','',$this->uri->segment(3),$this->uri->segment(4)));
        $perPage    = 10;
        $uriSegment = 5;
        $paging     = generatePaginationBlog($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
		// DATA
		$data['setting']             = getSetting();
		$data['news']                = $this->m_news->read($perPage, $page,'', $this->uri->segment(3),$this->uri->segment(4));
		$data['field']               = $this->m_field->read('','','');
		$data['recent']              = $this->m_news->read(4,0,'',1,'');
		$data['link']                = $this->m_link->read('','','');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');
		$data['news_category_name']  = $this->m_news_category->get($this->uri->segment(3));

		// TEMPLATE
		$view         = "_frontend/page/news";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}

	public function information_search(){

		if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_information', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_information');
        }
        
        // PAGINATION
        $baseUrl    = base_url() . "page/information_search/".$this->uri->segment(3)."/".$this->uri->segment(4)."/".$data['search']."/";
        $totalRows  = count((array)$this->m_news->read('','',$data['search'],$this->uri->segment(3), $this->uri->segment(4)));
        $perPage    = 10;
        $uriSegment = 6;
        $paging     = generatePaginationBlog($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
        //DATA
        $data['setting']             = getSetting();
        $data['news']                = $this->m_news->read($perPage, $page, $data['search'],$this->uri->segment(3), $this->uri->segment(4));
        $data['field']               = $this->m_field->read('','','');
        $data['recent']              = $this->m_news->read(4,0,'',1,'');
        $data['link']                = $this->m_link->read('','','');
        $data['news_category']       = $this->m_news_category->read('','','');
        $data['regulation_category'] = $this->m_regulation_category->read('','','');
        $data['news_category_name']  = $this->m_news_category->get($this->uri->segment(3));
        

		// TEMPLATE
		$view         = "_frontend/page/news";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}

	

    public function information_detail(){
		// DATA
		$data['setting']             = getSetting();
		$data['news']                = $this->m_news->getBySlug($this->uri->segment(5));
		$data['field']               = $this->m_field->read('','','');
		$data['recent']              = $this->m_news->read(4,0,'',1,'');
		$data['link']                = $this->m_link->read('','','');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');
        $data['news_category_name']  = $this->m_news_category->get($this->uri->segment(3));

		// COUNT VIEW
		$news['news_id']         = $data['news'][0]->news_id;
		$news['news_count_view'] = ($data['news'][0]->news_count_view + 1);
		$this->m_news->update($news);
		
		
		// TEMPLATE
		$view         = "_frontend/page/news_detail";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}


	// KONTAK/PESAN
    public function contact(){
		// DATA
		$data['setting']             = getSetting();
		$data['link']                = $this->m_link->read('','','');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');

		// TEMPLATE
		$view         = "_frontend/page/contact";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}

    public function tracking(){
		// DATA
		$data['setting']             = getSetting();
		$data['tracking']            = "";
		$data['link']                = $this->m_link->read('','','');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');

		// TEMPLATE
		$view         = "_frontend/page/contact_tracking";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}

    public function tracking_search(){
		// DATA
		$data['setting']             = getSetting();
		$data['tracking']            = $this->m_message->getByCode($this->input->post('key'));
		$data['link']                = $this->m_link->read('','','');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');

		// TEMPLATE
		$view         = "_frontend/page/contact_tracking";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}

	public function create_message() {
        csrfValidate();
        // POST
        $data['message_id']      = '';
        $data['message_name']    = $this->input->post('message_name');
        $data['message_email']   = $this->input->post('message_email');
        $data['message_phone']   = $this->input->post('message_phone');
        $data['message_subject'] = $this->input->post('message_subject');
        $data['message_text']    = $this->input->post('message_text');
        $data['message_reply']   = "";
        $data['message_code']    = "M-".date('YmdHis');
        $data['message_status']  = 0;
        $data['message_date']    = date('Y-m-d');
        $data['createtime']      = date('Y-m-d H:i:s');
        $this->m_message->create($data);

    
        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Pesan Anda berhasil di terima oleh kami. Pesan akan kami proses. Untuk mengetahui progress dari pesan anda silahkan melakukan tracking dengan code berikut : <b style='color:red;'>".$data['message_code']."</b>, pastikan anda menyimpan kode tersebut untuk mengecek progress pesan anda. Atas perhatiannya kami ucapkan Terima Kasih";
        getAlert($alertStatus, $alertMessage);

        redirect('page/contact');
    }

    // GALLERY VIDEO
    public function gallery(){

        // PAGINATION
        $baseUrl    = base_url() . "page/gallery/".$this->uri->segment(3)."/";
        $totalRows  = count((array) $this->m_gallery->read('','','',$this->uri->segment(3)));
        $perPage    = 10;
        $uriSegment = 4;
        $paging     = generatePaginationBlog($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;
        
        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows ;
        
		// DATA
		$data['setting']             = getSetting();
		$data['gallery']             = $this->m_gallery->read($perPage, $page,'', $this->uri->segment(3));
		$data['field']               = $this->m_field->read('','','');
		$data['recent']              = $this->m_news->read(4,0,'',1,'');
		$data['link']                = $this->m_link->read('','','');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');

		// TEMPLATE
        if($this->uri->segment(3) == 'photo'){
            $view         = "_frontend/page/gallery_photo";
        }else{
            $view         = "_frontend/page/gallery_video";
        }
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}

    public function gallery_detail(){
		// DATA
		$data['setting']             = getSetting();
		$data['gallery']             = $this->m_gallery->read_gallery('', '','', $this->uri->segment(4));
		$data['field']               = $this->m_field->read('','','');
		$data['recent']              = $this->m_news->read(4,0,'',1,'');
		$data['link']                = $this->m_link->read('','','');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');
		$data['gallery_name']        = $this->m_gallery->get($this->uri->segment(4));

        $view         = "_frontend/page/detail_gallery_photo";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}

	
}
