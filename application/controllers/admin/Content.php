<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Content extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_content');
        $this->load->library('upload');

        if (!$this->session->userdata('user_id') OR $this->session->userdata('user_group')!=1) {
			// ALERT
			$alertStatus  = 'failed';
			$alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
			getAlert($alertStatus, $alertMessage);
			redirect('admin/dashboard');
		}
    }
    
    public function page() {
        //DATA
        $data['setting']   = getSetting();
        $data['content']   = $this->m_content->get($this->uri->segment(4));
		
        // TEMPLATE
        $view         = "_backend/content/_page";
		$viewCategory = "all";
		renderTemplate($data, $view, $viewCategory);
    }


    public function update() {
        csrfValidate();
        if($this->input->post('content_menu')== "sambutan" OR $this->input->post('content_menu')== "struktur"){
            if($_FILES['content_image']['name']!=""){  
                $filename_1              = "content-".date('YmdHis');
                $config['upload_path']   = "./upload/content/";
                $config['allowed_types'] = "jpg|png|jpeg";
                $config['overwrite']     = "true";
                $config['max_size']      = "0";
                $config['max_width']     = "10000";
                $config['max_height']    = "10000";
                $config['file_name']     = '' . $filename_1;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('content_image')) {
                    
                    // ALERT
                    $alertStatus  = "failed";
                    $alertMessage = $this->upload->display_errors();
                    getAlert($alertStatus, $alertMessage);

                } else {
                    $dat  = $this->upload->data();

                    unlink('./upload/content/'. $this->input->post('content_image_old'));

                    $data['content_id']         = $this->input->post('content_id');
                    $data['content_image']      = $dat['file_name'];
                    $data['content_text']       = $this->input->post('content_text');
                    $data['createtime']         = date('Y-m-d H:i:s');
                    $this->m_content->update($data);
        
                    // LOG
                    $message    = $this->session->userdata('user_name')." mengubah data konten profil dinas menu = ".$this->input->post('content_menu');
                    createLog($message);
        
                    // ALERT
                    $alertStatus  = "success";
                    $alertMessage = "Berhasil mengubah data konten profil dinas menu : ".$this->input->post('content_menu');
                    getAlert($alertStatus, $alertMessage);
                }
            }else{
                // POST
                $data['content_id']         = $this->input->post('content_id');
                $data['content_text']       = $this->input->post('content_text');
                $data['createtime']         = date('Y-m-d H:i:s');
                $this->m_content->update($data);

                // LOG
                $message    = $this->session->userdata('user_name')." mengubah data konten profil dinas dengan ID = ".$this->input->post('content_menu');
                createLog($message);

                // ALERT
                $alertStatus  = "success";
                $alertMessage = "Berhasil mengubah data konten profil dinas menu : ".$this->input->post('content_menu');
                getAlert($alertStatus, $alertMessage);
            }
        }else{
            // POST
            $data['content_id']         = $this->input->post('content_id');
            $data['content_text']       = $this->input->post('content_text');
            $data['createtime']         = date('Y-m-d H:i:s');
            $this->m_content->update($data);

            // LOG
            $message    = $this->session->userdata('user_name')." mengubah data konten profil dinas dengan ID = ".$this->input->post('content_menu');
            createLog($message);

            // ALERT
            $alertStatus  = "success";
            $alertMessage = "Berhasil mengubah data konten profil dinas menu : ".$this->input->post('content_menu');
            getAlert($alertStatus, $alertMessage);
        }
        

        redirect('admin/content/page/'.$this->input->post('content_menu'));
    }


    
    

    


    
}
?>