<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    function __construct() {
		parent::__construct();
		$this->load->model('m_slider');
		$this->load->model('m_content');
		$this->load->model('m_link');
		$this->load->model('m_faq');
		$this->load->model('m_gallery');
		$this->load->model('m_news');
		$this->load->model('m_news_category');
		$this->load->model('m_regulation_category');
	}

	public function index(){
		// DATA
		$data['setting']             = getSetting();
		$data['slider']              = $this->m_slider->read('','','');
		$data['news']                = $this->m_news->read(4,0,'',1,'');
		$data['sambutan']            = $this->m_content->get('sambutan');
		$data['link']                = $this->m_link->read('','','');
		$data['faq']                 = $this->m_faq->read('','','');
		$data['gallery']             = $this->m_gallery->read('','','','photo');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');

		// TEMPLATE
		$view         = "_frontend/home";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}
}
