<?php defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_food');
		$this->load->model('m_user');
		$this->load->model('m_news');
		// check session data
		if (!$this->session->userdata('user_id') or $this->session->userdata('user_group') != 2) {
			// ALERT
			$alertStatus  = 'failed';
			$alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
			getAlert($alertStatus, $alertMessage);
			redirect('admin/dashboard');
		}
	}

	public function index()
	{
		// DATA
		$data['setting'] = getSetting();

		$data['food'] =   $this->m_food->widget();
		$data['pasien'] =   $this->m_user->widget();
		$data['artikel'] =   $this->m_news->widget();


		// TEMPLATE
		$view         = "_backend/dashboard";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
	}
}
