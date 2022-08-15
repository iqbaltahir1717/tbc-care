<style>
    .label-pill {
        padding-right: .6em;
        padding-left: .6em;
        border-radius: 10rem;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo strtoupper($title); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
            <?php
            if ($this->uri->segment(3)) {
                echo '<li class="active"><a href="' . site_url('admin/' . $this->uri->segment(2)) . '">' . strtoupper($title) . '</a></li>';
                echo '<li class="active">' . strtoupper($this->uri->segment(3)) . '</li>';
            } else {
                echo '<li class="active">' . strtoupper($title) . '</li>';
            }
            ?>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Profil Pasien</h3>
                    </div>
                    <div class="box-body box-profile">
                        <?php
                        if ($this->session->userdata('user_photo') == "") {
                            echo '<img class="profile-user-img img-responsive img-circle" src="' . base_url() . 'upload/user/noimage.png" alt="User profile picture">';
                        } else {
                            echo '<img class="profile-user-img img-responsive img-circle" src="' . base_url() . 'upload/user/' . $profile[0]->user_photo . '" alt="User profile picture">';
                        }
                        ?>
                        <h3 class="profile-username text-center"><?php echo $profile[0]->user_fullname; ?></h3>
                        <br>
                        <strong><i class="fa fa-circle-o text-red"></i> Username</strong> : <?php echo $profile[0]->user_name; ?> <br>
                        <hr style="border: 0.5px dashed #d2d6de">
                        <strong><i class="fa fa-circle-o text-red"></i> Tanggal Lahir</strong> : <?php echo $profile[0]->user_birth; ?> <br>
                        <hr style="border: 0.5px dashed #d2d6de">
                        <strong><i class="fa fa-circle-o text-red"></i> Jenis Kelamin</strong> : <?php if ($profile[0]->user_gender == "L") echo "Laki-Laki";
                                                                                                    else echo "Perempuan" ?>
                        <hr style="border: 0.5px dashed #d2d6de">
                        <strong><i class="fa fa-circle-o text-red"></i> Umur </strong> : <?php $tanggal = new  DateTime($profile[0]->user_birth);
                                                                                            $today = new DateTime('today');
                                                                                            $y = $today->diff($tanggal)->y;

                                                                                            echo $y; ?> Tahun <br>
                        <hr style="border: 0.5px dashed #d2d6de">
                        <strong><i class="fa fa-circle-o text-red"></i> Email</strong> : <?php echo $profile[0]->user_email; ?>
                        <hr style="border: 0.5px dashed #d2d6de">
                        <strong><i class="fa fa-circle-o text-red"></i> Alamat</strong> : <?php echo $profile[0]->user_alamat; ?>
                        <hr style="border: 0.5px dashed #d2d6de">

                        <small>Page rendered in <strong>{elapsed_time}</strong> seconds.</small>

                    </div>
                </div>

            </div>

            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#activity" data-toggle="tab">Form Input</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="settings">
                            <?php
                            if ($this->session->flashdata('alert')) {
                                echo $this->session->flashdata('alert');
                                unset($_SESSION['alert']);
                            }
                            ?>
                            <?php echo form_open_multipart("user/kalkulator/fuzzy", 'class="form-horizontal"') ?>
                            <div class="form-group">
                                <label for="text" class="col-sm-2 control-label">Aktifitas Pasien</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="user_activity" required="required">
                                        <option value="">-Aktifitas Pasien-</option>
                                        <?php
                                        $rowpage = array('Sangat Ringan', 'Ringan', 'Sedang', 'Berat');
                                        for ($r = 0; $r < count($rowpage); $r++) {
                                            if ($rowpage[$r] == $profile[0]->user_activity) {
                                                echo '<option value="' . $rowpage[$r] . '" selected>' . $rowpage[$r] . '</option>';
                                            } else {
                                                echo '<option value="' . $rowpage[$r] . '">' . $rowpage[$r] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBB" class="col-sm-2 control-label">Berat Badan (kg)</label>
                                <div class="col-sm-10">
                                    <?php echo csrf(); ?>
                                    <input type="number" class="form-control" placeholder="Berat Badan" name="user_bb" value="<?php echo $profile[0]->user_bb; ?>" required>
                                    <input type="hidden" class="form-control" name="user_id" value="<?php echo $profile[0]->user_id; ?>">
                                    <input type="hidden" class="form-control" name="user_name" value="<?php echo $profile[0]->user_name; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputTB" class="col-sm-2 control-label">Tinggi Badan (cm)</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" placeholder="Tinggi Badan" name="user_tb" value="<?php echo $profile[0]->user_tb; ?>" required>
                                </div>
                            </div>

                            <hr style="border: 0.5px dashed #d2d6de">
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success">Hitung Sekarang</button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#activity" data-toggle="tab">Result Input</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="settings">
                            <?php echo form_open_multipart("user/kalkulator/fuzzy", 'class="form-horizontal"') ?>
                            <?php
                            if ($data) {
                                $nox = 1;
                                $no = 1;
                                foreach ($data as $ab => $key) {
                            ?>
                                    <div class="form-group">
                                        <label for="text" class="col-sm-2 control-label">Kebutuhan Kalori</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" placeholder="Nama User" disabled value="<?php echo $key[10]; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">Nilai IMT/BMI</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" disabled placeholder="" value="<?php echo round($key[15], 2) ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail" class="col-sm-2 control-label">Status Gizi</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" disabled placeholder="Email" value="<?php echo  $key[13]; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail" class="col-sm-2 control-label">Nilai Akhir Defuzzyfikasi</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" placeholder="Email" disabled value="<?php echo  $key[14]; ?>">
                                        </div>
                                    </div>
                                    <hr style="border: 0.5px dashed #d2d6de">
                                    <h4><b>Saran Menu Makanan :</b></h4>
                                    <table class="table table-hover table-striped">
                                        <tr style="background-color: #484848;color:white">
                                            <th style="width: 60px">No</th>
                                            <th style="width: 8%">Rekomendasi Menu</th>
                                            <th>Menu Pagi (Kkal)</th>
                                            <th>Menu Siang (Kkal)</th>
                                            <th>Menu Malam (Kkal)</th>
                                            <th>Total (Kkal)/Hari</th>
                                            <th>Keterangan</th>
                                        </tr>
                                        <?php
                                        if ($key[12]) {
                                            $nox = 1;
                                            foreach ($key[12] as $food) { ?>
                                                <tr>
                                                    <td><?php echo $nox++; ?></td>
                                                    <td><?php echo $food->category_food_name; ?></td>
                                                    <td><?php echo $food->food_name; ?> <span class="label label-pill label-primary">(<?php echo $food->food_kkal; ?>)</span></td>
                                                    <td><?php echo $food->food_name2; ?> <span class="label label-pill label-warning">(<?php echo $food->food_kkal2; ?>)</span></td>
                                                    <td><?php echo $food->food_name3; ?> <span class="label label-pill label-success">(<?php echo $food->food_kkal3; ?>)</b></td>
                                                    <td><b><?php echo $food->food_kkal + $food->food_kkal2 + $food->food_kkal3; ?></span></td>
                                                    <td><span class="label label-pill label-danger"><?php echo $food->food_details; ?></span></td>
                                                </tr>
                                        <?php }
                                        } else {
                                            echo '
                            <tr>
                                <td colspan="3">Tidak ada ditemukan</td>
                            </tr>
                            ';
                                        } ?>
                                    </table>


                            <?php
                                    $no++;
                                }
                            } else {
                                echo '
                            <tr>
                                <td colspan="3">Tidak ada ditemukan</td>
                            </tr>
                            ';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>