<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pasien extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_pasien');
        $this->load->model('m_user');
        $this->load->model('m_group');
        $this->load->model('m_food');

        if (!$this->session->userdata('user_id') or $this->session->userdata('user_group') != 1) {
            // ALERT
            $alertStatus  = 'failed';
            $alertMessage = 'Anda tidak memiliki Hak Akses atau Session anda sudah habis';
            getAlert($alertStatus, $alertMessage);
            redirect('admin/dashboard');
        }
    }


    public function index()
    {
        $this->session->unset_userdata('sess_search_user');

        // PAGINATION
        $baseUrl    = base_url() . "admin/user/index/";
        $totalRows  = count((array) $this->m_pasien->read('', '', ''));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 4;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;

        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows;

        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'User';
        $data['pasien']    = $this->m_pasien->read($perPage, $page, '');
        $data['group']   = $this->m_group->read('', '', '');

        //kebutuhan energi
        foreach ($data['pasien'] as $p) {
            $tanggal = new  DateTime($p->user_birth);
            $today = new DateTime('today');
            $y = $today->diff($tanggal)->y;
            if ($p->user_gender == "L") {
                $bmr = (66.5 + (13.7 * $p->user_bb) + (5.0 * $p->user_tb) - (6.8 * $y));
                if ($p->user_activity == "Sangat Ringan") {
                    $l = $bmr * 1.30;
                }
                if ($p->user_activity == "Ringan") {
                    $l = $bmr * 1.56;
                }
                if ($p->user_activity == "Sedang") {
                    $l = $bmr * 1.76;
                }
                if ($p->user_activity == "Berat") {
                    $l = $bmr * 2.10;
                }
            }
            if ($p->user_gender == "W") {
                $bmr = (665 + (9.6 * $p->user_bb) + (1.8 * $p->user_tb) - (4.7 * $y));
                if ($p->user_activity == "Sangat Ringan") {
                    $l = $bmr * 1.30;
                }
                if ($p->user_activity == "Ringan") {
                    $l = $bmr * 1.55;
                }
                if ($p->user_activity == "Sedang") {
                    $l = $bmr * 1.70;
                }
                if ($p->user_activity == "Berat") {
                    $l = $bmr * 2.00;
                }
            }

            $nilai_menu_a = 0;
            $nilai_menu_b = 0;
            $nilai_menu_c = 0;
            $nilai_menu_d = 0;
            $nilai_menu_e = 0;


            //menu_a
            if ($l <= 700) {
                $data["menu"] = $this->m_food->get(1);
            } else {
                if ($l <= 700) {
                    $data["menu"] = $this->m_food->get(2);
                } else {
                    $data["menu"] = $this->m_food->get(2);
                }
            }

            //menu_b
            if ($l >= 700 && $l <= 1200) {
                $data["menu"] = $this->m_food->get(1);
            }
            if ($l > 1200 && $l <= 1800) {
                $data["menu"] = $this->m_food->get(1);
            }
            if ($l > 1800 && $l <= 2400) {
                $data["menu"] = $this->m_food->get(1);
            }
            if ($l > 2400) {
                $data["menu"] = $this->m_food->get(2);
            }

            $data["data"][] = [$p->user_id, $p->user_fullname, $p->user_gender, $p->user_birth, $p->user_bb, $p->user_tb, $p->user_status, $p->user_email, $p->user_no, $p->user_activity, $l, $bmr,  $data["menu"]];
        }
        // echo "<pre>";
        // print_r($data["data"]);
        // echo "</pre>";
        // die;

        // TEMPLATE
        $view         = "_backend/main/pasien";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }




    public function search()
    {
        if ($this->input->post('key')) {
            $data['search'] = $this->input->post('key');
            $this->session->set_userdata('sess_search_pasien', $data['search']);
        } else {
            $data['search'] = $this->session->userdata('sess_search_pasien');
        }

        // PAGINATION
        $baseUrl    = base_url() . "admin/pasien/search/" . $data['search'] . "/";
        $totalRows  = count((array)$this->m_pasien->read('', '', $data['search']));
        $perPage    = $this->session->userdata('sess_rowpage');
        $uriSegment = 5;
        $paging     = generatePagination($baseUrl, $totalRows, $perPage, $uriSegment);
        $page       = ($this->uri->segment($uriSegment)) ? $this->uri->segment($uriSegment) : 0;

        $data['numbers']    = $paging['numbers'];
        $data['links']      = $paging['links'];
        $data['total_data'] = $totalRows;

        //DATA
        $data['setting'] = getSetting();
        $data['title']   = 'Pasien';
        $data['pasien']    = $this->m_pasien->read($perPage, $page, $data['search']);
        $data['group']   = $this->m_group->read('', '', '');



        // TEMPLATE
        $view         = "_backend/main/pasien";
        $viewCategory = "all";
        renderTemplate($data, $view, $viewCategory);
    }

    public function update()
    {
        csrfValidate();
        // POST
        $data['user_id']       = $this->input->post('user_id');
        $data['user_fullname'] = $this->input->post('user_fullname');
        $data['user_gender']    = $this->input->post('user_gender');
        $data['user_birth']      = $this->input->post('user_birth');
        $data['user_activity']      = $this->input->post('user_activity');
        $data['user_alamat']      = $this->input->post('user_alamat');
        $data['user_status']      = $this->input->post('user_status');
        $data['user_no']      = $this->input->post('user_no');
        $data['user_bb']      = $this->input->post('user_bb');
        $data['user_tb']      = $this->input->post('user_tb');
        $this->m_pasien->update($data);

        // LOG
        $message    = $this->session->userdata('user_fullname') . " mengubah data pasien dengan ID = " . $data['user_id'] . " - " . $data['user_fullname'];
        createLog($message);



        // ALERT
        $alertStatus  = "success";
        $alertMessage = "Berhasil mengubah data pasien : " . $data['user_fullname'];
        getAlert($alertStatus, $alertMessage);

        redirect('admin/pasien');
    }
}
