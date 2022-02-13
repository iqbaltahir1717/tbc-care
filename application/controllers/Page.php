<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	// REGULASI

	// KONTAK/PESAN
	public function contact()
	{
		// DATA
		$data['setting']             = getSetting();
		$data['link']                = $this->m_link->read('', '', '');
		$data['news_category']       = $this->m_news_category->read('', '', '');
		$data['regulation_category'] = $this->m_regulation_category->read('', '', '');

		// TEMPLATE
		$view         = "_frontend/page/contact";
		$viewCategory = "all";
		renderTemplateFront($data, $view, $viewCategory);
	}
}
