<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {
    function __construct() {
		parent::__construct();
		$this->load->model('m_content');
		$this->load->model('m_link');
		$this->load->model('m_news_category');
		$this->load->model('m_regulation_category');
	}

	public function sejarah(){
		// DATA
		$data['setting']             = getSetting();
		$data['link']                = $this->m_link->read('','','');
		$data['content']             = $this->m_content->get('sejarah');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');

		// TEMPLATE
		$view         = "_frontend/profil/sejarah";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}

    public function visi_misi(){
		// DATA
		$data['setting']             = getSetting();
		$data['link']                = $this->m_link->read('','','');
		$data['content']             = $this->m_content->get('visi');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');

		// TEMPLATE
		$view         = "_frontend/profil/visi";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}

	public function sambutan(){
		// DATA
		$data['setting']             = getSetting();
		$data['link']                = $this->m_link->read('','','');
		$data['content']             = $this->m_content->get('sambutan');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');

		// TEMPLATE
		$view         = "_frontend/profil/sambutan";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}

    public function tugas_pokok_fungsi(){
		// DATA
		$data['setting']             = getSetting();
		$data['link']                = $this->m_link->read('','','');
		$data['content']             = $this->m_content->get('tupoksi');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');

		// TEMPLATE
		$view         = "_frontend/profil/tupoksi";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}


    public function maklumat_pelayanan(){
		// DATA
		$data['setting']             = getSetting();
		$data['link']                = $this->m_link->read('','','');
		$data['content']             = $this->m_content->get('maklumat');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');

		// TEMPLATE
		$view         = "_frontend/profil/maklumat";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}


	public function struktur_organisasi(){
		// DATA
		$data['setting']             = getSetting();
		$data['link']                = $this->m_link->read('','','');
		$data['content']             = $this->m_content->get('struktur');
		$data['news_category']       = $this->m_news_category->read('','','');
		$data['regulation_category'] = $this->m_regulation_category->read('','','');

		// TEMPLATE
		$view         = "_frontend/profil/struktur";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}

	
}
