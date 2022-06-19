<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_user');
        $this->load->model('m_group');
        $this->load->library('upload');

        if (!$this->session->userdata('user_id') or $this->session->userdata('user_group') != 2) {
            // ALERT
            $alertStatus  = 'failed';
            $alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
            getAlert($alertStatus, $alertMessage);
            redirect('user/dashboard');
        }
    }


    public function index()
    {
        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Profil';
        $data['profile'] = $this->m_user->get($this->session->userdata('user_id'));
        $data['group']   = $this->m_group->read('', '', '');

        // TEMPLATE
        $view         = "_backend/profile";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }


    public function update()
    {
        csrfValidate();

        // PASSWORD VALIDATOR
        if ($this->input->post('password') != "") {
            if (password_verify($this->input->post('password'), $this->input->post('old_password'))) {
                if ($this->input->post('new_password') == $this->input->post('confirm_password')) {
                    if ($this->input->post('confirm_password') != "") {
                        $data['user_password']  = password_hash($this->input->post('confirm_password'), PASSWORD_BCRYPT);
                    } else {

                        // ALERT
                        $alertStatus  = "failed";
                        $alertMessage = "Password baru tidak boleh bernilai kosong";
                        getAlert($alertStatus, $alertMessage);
                        redirect('user/profile');
                        // clean_all_processes();
                    }
                } else {

                    // ALERT
                    $alertStatus  = "failed";
                    $alertMessage = "Password baru dan konfirmasi tidak cocok";
                    getAlert($alertStatus, $alertMessage);
                    redirect('user/profile');
                    // clean_all_processes();
                }
            } else {

                // ALERT
                $alertStatus  = "failed";
                $alertMessage = "Password Lama Tidak Sama dengan database";
                getAlert($alertStatus, $alertMessage);
                redirect('user/profile');
                // clean_all_processes();
            }
        }


        // IMAGE VALIDATOR
        if ($_FILES['userfile']['name'] != '') {
            $path = './upload/user/';

            // REMOVE OLD PHOTO
            unlink($path . $this->input->post('old_photo'));

            // IMAGE CONFIG
            $filename                = "profile-" . $this->input->post('user_id') . '-' . date('YmdHis');
            $config['upload_path']   = $path;
            $config['allowed_types'] = "jpg|jpeg|png";
            $config['overwrite']     = "true";
            $config['max_size']      = "0";
            $config['max_width']     = "10000";
            $config['max_height']    = "10000";
            $config['file_name']     = '' . $filename;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload()) {
                echo $this->upload->display_errors();
            } else {
                $dat             = $this->upload->data();

                // COMPRESS IMAGE
                compressImages($path, $dat['file_name']);
                $data['user_photo'] = $dat['file_name'];
            }
        } else {
            $data['user_photo'] = '';
        }


        // POST
        $data['user_id']       = $this->input->post('user_id');
        $data['user_name']     = $this->input->post('user_name');
        $data['user_email']    = $this->input->post('user_email');
        $data['user_fullname'] = $this->input->post('user_fullname');
        $this->m_user->update($data);

        // SET SESSION
        $session = array(
            'user_name'       => $data['user_name'],
            'user_fullname'   => $data['user_fullname'],
            'user_photo'      => $data['user_photo'],
            'user_email'      => $data['user_email'],
        );
        $this->session->set_userdata($session);

        // LOG
        $message    = $this->session->userdata('user_name') . " mengubah data profile dengan ID = " . $data['user_id'] . " - " . $data['user_name'];
        createLog($message);

        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil mengubah data profile : " . $data['user_name'];
        getAlert($alertStatus, $alertMessage);

        redirect('user/profile');
    }
}
