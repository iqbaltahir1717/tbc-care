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

            //umur_pasien
            $tanggal = new  DateTime($p->user_birth);
            $today = new DateTime('today');
            $y = $today->diff($tanggal)->y;

            if ($p->user_bb == 0 && $p->user_tb == 0) {
                $hs = "kosong";
                $bmr = "-";
                $data["menu"] = $this->m_food->get(1);
                $output = "-";
                $total_akhirs = "-";
                $data["data"][] = [$p->user_id, $p->user_fullname, $p->user_gender, $p->user_birth, $p->user_bb, $p->user_tb, $p->user_status, $p->user_email, $p->user_no, $p->user_activity, $hs, $bmr,  $data["menu"], $output, $total_akhirs];
            } else {
                //bmr dan harris benedict berdasar jenis kelamin dan aktifias
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

                //nilai harris_benedict/nilai kebutuhan kalori
                $hs = round($l, 1);

                //variabel_input
                $value_bb = $p->user_bb;
                $value_tb = $p->user_tb;

                //------------------fuzzyfikasi berat badan------------------

                //ringan
                if ($value_bb <= 45) {
                    $bb_ringan = 1;
                } else if (45 <= $value_bb &&  $value_bb <= 55) {
                    $bb_ringan = (55 - $value_bb) / 10;
                } else {
                    $bb_ringan = 0;
                }

                //normal
                if ($value_bb <= 45) {
                    $bb_normal = 0;
                } else if (45 <= $value_bb && $value_bb <= 55) {
                    $bb_normal = ($value_bb - 45) / 10;
                } else if (55 <= $value_bb && $value_bb <= 65) {
                    $bb_normal = (65 - $value_bb) / 10;
                } else {
                    $bb_normal = 0;
                }

                //berat
                if ($value_bb >= 55) {
                    $bb_berat = 1;
                } else if (55 <= $value_bb &&  $value_bb <= 65) {
                    $bb_berat = ($value_bb - 55) / 10;
                } else {
                    $bb_berat = 0;
                }

                //------------------fuzzyfikasi tinggi badan------------------

                //pendek
                if ($value_tb <= 150) {
                    $tb_pendek = 1;
                } else if (150 <= $value_tb &&  $value_tb <= 165) {
                    $tb_pendek = (165 - $value_tb) / 15;
                } else {
                    $tb_pendek = 0;
                }

                //normal
                if ($value_tb <= 150) {
                    $tb_normal = 0;
                } else if (150 <= $value_tb && $value_tb <= 165) {
                    $tb_normal = ($value_tb - 150) / 15;
                } else if (165 <= $value_tb && $value_tb <= 175) {
                    $tb_normal = (175 - $value_tb) / 10;
                } else {
                    $tb_normal = 0;
                }

                //tinggi
                if ($value_tb >= 175) {
                    $tb_tinggi = 1;
                } else if (165 <= $value_tb &&  $value_tb <= 175) {
                    $tb_tinggi = ($value_tb - 165) / 10;
                } else {
                    $tb_tinggi = 0;
                }

                //------------------implikasi------------------------


                $rules[0] = min($bb_ringan, $tb_pendek);
                $rules[1] = min($bb_ringan, $tb_normal);
                $rules[2] = min($bb_ringan, $tb_tinggi);
                $rules[3] = min($bb_normal, $tb_pendek);
                $rules[4] = min($bb_normal, $tb_normal);
                $rules[5] = min($bb_normal, $tb_tinggi);
                $rules[6] = min($bb_berat, $tb_pendek);
                $rules[7] = min($bb_berat, $tb_normal);
                $rules[8] = min($bb_berat, $tb_tinggi);

                $zpredikat[0] = 25 - $rules[0]; //normal
                $zpredikat[1] = 18.5 - $rules[1]; //kurang
                $zpredikat[2] = 17 - $rules[2]; //sangat_kurang
                $zpredikat[3] = 27 - $rules[3]; //gizi_lebih
                $zpredikat[4] = 25 - $rules[4]; //normal
                $zpredikat[5] = 18.5 - $rules[5]; //kurang
                $zpredikat[6] = 17 - $rules[6]; //sangaat lebih
                $zpredikat[7] = 27 - $rules[7]; //lebih 
                $zpredikat[8] = 25 - $rules[8]; //normal


                //----------------------defuzyfikasi
                $value_atas[0] = $zpredikat[0] * $rules[0];
                $value_atas[1] = $zpredikat[1] * $rules[1];
                $value_atas[2] = $zpredikat[2] * $rules[2];
                $value_atas[3] = $zpredikat[3] * $rules[3];
                $value_atas[4] = $zpredikat[4] * $rules[4];
                $value_atas[5] = $zpredikat[5] * $rules[5];
                $value_atas[6] = $zpredikat[6] * $rules[6];
                $value_atas[7] = $zpredikat[7] * $rules[7];
                $value_atas[8] = $zpredikat[8] * $rules[8];
                $total_atas = $value_atas[0] + $value_atas[1] + $value_atas[2] + $value_atas[3] + $value_atas[4] + $value_atas[5] + $value_atas[6] + $value_atas[7] + $value_atas[8];

                $total_bawah = $rules[0] + $rules[1] + $rules[2] + $rules[3] + $rules[4] + $rules[5] + $rules[6] + $rules[7] + $rules[8];

                if ($total_atas != 0 &&  $total_bawah != 0) {
                    $total_akhirs = round($total_atas / $total_bawah, 4);
                } else {
                    $total_akhirs  = 0;
                }


                //output
                if (13 <= $total_akhirs && $total_akhirs <= 17) {
                    $output = "Kurus Tingkat Berat";
                } else if (16 <= $total_akhirs && $total_akhirs <= 18.5) {
                    $output = "Kurus Tingkat Ringan";
                } else if (17.5 <= $total_akhirs && $total_akhirs <= 25) {
                    $output = "Normal";
                } else if (24 <= $total_akhirs && $total_akhirs <= 27) {
                    $output = "Gemuk Tingkat Ringan";
                } else if (26 <= $total_akhirs && $total_akhirs <= 33) {
                    $output = "Gemuk Tingkat Berat";
                } else {
                    $output = "-";
                }

                // echo "<pre>";
                // print_r($output);
                // echo "</pre>";
                // die;

                //menu

                if ($output == "Kurus Tingkat Berat") {
                    $data['menu'] = $this->m_food->get(1);
                } else if ($output == "Kurus Tingkat Ringan") {
                    $data['menu'] = $this->m_food->get(2);
                } else if ($output == "Normal") {
                    $data['menu'] = $this->m_food->get(3);
                } else if ($output == "Gemuk Tingkat Ringan") {
                    $data['menu'] = $this->m_food->get(4);
                } else if ($output == "Gemuk Tingkat Berat") {
                    $data['menu'] = $this->m_food->get(5);
                } else if ($output == "-") {
                    $data['menu'] = "try again";
                }


                $data["data"][] = [$p->user_id, $p->user_fullname, $p->user_gender, $p->user_birth, $p->user_bb, $p->user_tb, $p->user_status, $p->user_email, $p->user_no, $p->user_activity, $hs, $bmr,  $data["menu"], $output, $total_akhirs];
            }
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

        //kebutuhan energi
        //kebutuhan energi
        foreach ($data['pasien'] as $p) {

            //umur_pasien
            $tanggal = new  DateTime($p->user_birth);
            $today = new DateTime('today');
            $y = $today->diff($tanggal)->y;

            if ($p->user_bb == 0 && $p->user_tb == 0) {
                $hs = "kosong";
                $bmr = "-";
                $data["menu"] = $this->m_food->get(1);
                $output = "-";
                $total_akhirs = "-";
                $data["data"][] = [$p->user_id, $p->user_fullname, $p->user_gender, $p->user_birth, $p->user_bb, $p->user_tb, $p->user_status, $p->user_email, $p->user_no, $p->user_activity, $hs, $bmr,  $data["menu"], $output, $total_akhirs];
            } else {
                //bmr dan harris benedict berdasar jenis kelamin dan aktifias
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

                //nilai harris_benedict/nilai kebutuhan kalori
                $hs = round($l, 1);

                //variabel_input
                $value_bb = $p->user_bb;
                $value_tb = $p->user_tb;

                //------------------fuzzyfikasi berat badan------------------

                //ringan
                if ($value_bb <= 45) {
                    $bb_ringan = 1;
                } else if (45 <= $value_bb &&  $value_bb <= 55) {
                    $bb_ringan = (55 - $value_bb) / 10;
                } else {
                    $bb_ringan = 0;
                }

                //normal
                if ($value_bb <= 45) {
                    $bb_normal = 0;
                } else if (45 <= $value_bb && $value_bb <= 55) {
                    $bb_normal = ($value_bb - 45) / 10;
                } else if (55 <= $value_bb && $value_bb <= 65) {
                    $bb_normal = (65 - $value_bb) / 10;
                } else {
                    $bb_normal = 0;
                }

                //berat
                if ($value_bb >= 55) {
                    $bb_berat = 1;
                } else if (55 <= $value_bb &&  $value_bb <= 65) {
                    $bb_berat = ($value_bb - 55) / 10;
                } else {
                    $bb_berat = 0;
                }

                //------------------fuzzyfikasi tinggi badan------------------

                //pendek
                if ($value_tb <= 150) {
                    $tb_pendek = 1;
                } else if (150 <= $value_tb &&  $value_tb <= 165) {
                    $tb_pendek = (165 - $value_tb) / 15;
                } else {
                    $tb_pendek = 0;
                }

                //normal
                if ($value_tb <= 150) {
                    $tb_normal = 0;
                } else if (150 <= $value_tb && $value_tb <= 165) {
                    $tb_normal = ($value_tb - 150) / 15;
                } else if (165 <= $value_tb && $value_tb <= 175) {
                    $tb_normal = (175 - $value_tb) / 10;
                } else {
                    $tb_normal = 0;
                }

                //tinggi
                if ($value_tb >= 175) {
                    $tb_tinggi = 1;
                } else if (165 <= $value_tb &&  $value_tb <= 175) {
                    $tb_tinggi = ($value_tb - 165) / 10;
                } else {
                    $tb_tinggi = 0;
                }

                //------------------implikasi------------------------


                $rules[0] = min($bb_ringan, $tb_pendek);
                $rules[1] = min($bb_ringan, $tb_normal);
                $rules[2] = min($bb_ringan, $tb_tinggi);
                $rules[3] = min($bb_normal, $tb_pendek);
                $rules[4] = min($bb_normal, $tb_normal);
                $rules[5] = min($bb_normal, $tb_tinggi);
                $rules[6] = min($bb_berat, $tb_pendek);
                $rules[7] = min($bb_berat, $tb_normal);
                $rules[8] = min($bb_berat, $tb_tinggi);

                $zpredikat[0] = 25 - $rules[0]; //normal
                $zpredikat[1] = 18.5 - $rules[1]; //kurang
                $zpredikat[2] = 17 - $rules[2]; //sangat_kurang
                $zpredikat[3] = 27 - $rules[3]; //gizi_lebih
                $zpredikat[4] = 25 - $rules[4]; //normal
                $zpredikat[5] = 18.5 - $rules[5]; //kurang
                $zpredikat[6] = 17 - $rules[6]; //sangaat lebih
                $zpredikat[7] = 27 - $rules[7]; //lebih 
                $zpredikat[8] = 25 - $rules[8]; //normal


                //----------------------defuzyfikasi
                $value_atas[0] = $zpredikat[0] * $rules[0];
                $value_atas[1] = $zpredikat[1] * $rules[1];
                $value_atas[2] = $zpredikat[2] * $rules[2];
                $value_atas[3] = $zpredikat[3] * $rules[3];
                $value_atas[4] = $zpredikat[4] * $rules[4];
                $value_atas[5] = $zpredikat[5] * $rules[5];
                $value_atas[6] = $zpredikat[6] * $rules[6];
                $value_atas[7] = $zpredikat[7] * $rules[7];
                $value_atas[8] = $zpredikat[8] * $rules[8];
                $total_atas = $value_atas[0] + $value_atas[1] + $value_atas[2] + $value_atas[3] + $value_atas[4] + $value_atas[5] + $value_atas[6] + $value_atas[7] + $value_atas[8];

                $total_bawah = $rules[0] + $rules[1] + $rules[2] + $rules[3] + $rules[4] + $rules[5] + $rules[6] + $rules[7] + $rules[8];

                if ($total_atas != 0 &&  $total_bawah != 0) {
                    $total_akhirs = round($total_atas / $total_bawah, 4);
                } else {
                    $total_akhirs  = 0;
                }


                //output
                if (13 <= $total_akhirs && $total_akhirs <= 17) {
                    $output = "Kurus Tingkat Berat";
                } else if (16 <= $total_akhirs && $total_akhirs <= 18.5) {
                    $output = "Kurus Tingkat Ringan";
                } else if (17.5 <= $total_akhirs && $total_akhirs <= 25) {
                    $output = "Normal";
                } else if (24 <= $total_akhirs && $total_akhirs <= 27) {
                    $output = "Gemuk Tingkat Ringan";
                } else if (26 <= $total_akhirs && $total_akhirs <= 33) {
                    $output = "Gemuk Tingkat Berat";
                } else {
                    $output = "-";
                }

                // echo "<pre>";
                // print_r($output);
                // echo "</pre>";
                // die;

                //menu

                if ($output == "Kurus Tingkat Berat") {
                    $data['menu'] = $this->m_food->get(1);
                } else if ($output == "Kurus Tingkat Ringan") {
                    $data['menu'] = $this->m_food->get(2);
                } else if ($output == "Normal") {
                    $data['menu'] = $this->m_food->get(3);
                } else if ($output == "Gemuk Tingkat Ringan") {
                    $data['menu'] = $this->m_food->get(4);
                } else if ($output == "Gemuk Tingkat Berat") {
                    $data['menu'] = $this->m_food->get(5);
                } else if ($output == "-") {
                    $data['menu'] = "try again";
                }


                $data["data"][] = [$p->user_id, $p->user_fullname, $p->user_gender, $p->user_birth, $p->user_bb, $p->user_tb, $p->user_status, $p->user_email, $p->user_no, $p->user_activity, $hs, $bmr,  $data["menu"], $output, $total_akhirs];
            }
        }



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
