<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('m_auth');
	}

	
	public function index(){
		// check session data
		if ($this->session->userdata('user_id')) {
			// ALERT
			$alertStatus  = 'success';
			$alertMessage = 'Selamat Datang, '.$this->session->userdata('user_fullname');
			getAlert($alertStatus, $alertMessage);
			redirect('admin/dashboard');
		}else{
			// DATA
			$data['setting'] = getSetting();

			// TEMPLATE
			$view         = "_backend/auth/login";
			$viewCategory = "single";
			renderTemplate($data, $view, $viewCategory);
		}
	}


	public function validate(){
		csrfValidate();
		if ($_POST) {
			$result           = $this->m_auth->validate(str_replace (' ','',$this->db->escape_str($this->input->post('username'))));
			if (!!($result)) {
				if(password_verify($this->input->post('password'), $result[0]->user_password)){
					// SESSION DATA
					$data = array(
						'user_id'         => $result[0]->user_id,
						'user_name'       => $result[0]->user_name,
						'user_fullname'   => $result[0]->user_fullname,
						'user_photo'      => $result[0]->user_photo,
						'user_email'      => $result[0]->user_email,
						'user_group'      => $result[0]->group_id,
						'user_createtime' => $result[0]->createtime,
						'sess_rowpage'    => 10,
						'IsAuthorized'    => true
					);
					$this->session->set_userdata($data);

					// LOG
					$logMessage = $data['user_fullname'] . " melakukan login ke sistem";
					createLog($logMessage);

					redirect('admin/dashboard');
				}else{
                    // ALERT
					$alertStatus  = 'failed';
					$alertMessage = 'Username atau Password salah';
					getAlert($alertStatus, $alertMessage);
                    redirect('auth');
                }
			} else {
				// ALERT
				$alertStatus  = 'failed';
				$alertMessage = 'Akun tidak valid';
				getAlert($alertStatus, $alertMessage);
                redirect('auth');
			}
		}
	}


	public function logout() {
		$this->session->sess_destroy();
		redirect('auth');
	}
}
