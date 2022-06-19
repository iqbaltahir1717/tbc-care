<div class="content-wrapper">
    <section class="content-header">
        <h1 class="fontPoppins">
            <?php echo strtoupper($this->uri->segment(2)); ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
        </ol>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <?php if (!$this->session->userdata('user_id') or $this->session->userdata('user_group') == 2) { ?>
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <?php
                            if ($this->session->flashdata('alert')) {
                                echo $this->session->flashdata('alert');
                                unset($_SESSION['alert']);
                            }
                            ?>
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3><?php echo $artikel[0]->total_artikel ?></h3>
                                            <p>Total Artikel</p>
                                        </div>
                                        <a href="<?php echo site_url('page/information/3/1'); ?>" class="small-box-footer">
                                            More info <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- ./col -->
                            </div>
                        </div>
                        <div class="box-footer">
                            <small>Page rendered in <strong>{elapsed_time}</strong> seconds.</small>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (!$this->session->userdata('user_id') or $this->session->userdata('user_group') == 1) { ?>
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <?php
                            if ($this->session->flashdata('alert')) {
                                echo $this->session->flashdata('alert');
                                unset($_SESSION['alert']);
                            }
                            ?>
                            <div class="row">

                                <div class="col-lg-6 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3><?php echo $pasien[0]->total_pasien_baru ?></h3>
                                            <p>Total Pasien Pending</p>
                                        </div>
                                        <a href="<?php echo site_url('admin/pasien'); ?>" class="small-box-footer">
                                            More info <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>


                                <div class="col-lg-6 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3><?php echo $pasien[0]->total_pasien_proses ?></h3>
                                            <p>Total Pasien Masa Pengobatan</p>
                                        </div>
                                        <a href="<?php echo site_url('admin/pasien'); ?>" class="small-box-footer">
                                            More info <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3><?php echo $pasien[0]->total_pasien_selesai ?></h3>
                                            <p>Total Pasien Selesai</p>
                                        </div>
                                        <a href="<?php echo site_url('admin/pasien'); ?>" class="small-box-footer">
                                            More info <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3><?php echo $food[0]->total_food ?></h3>
                                            <p>Total Rekomendasi Makanan</p>
                                        </div>
                                        <a href="<?php echo site_url('admin/makanan'); ?>" class="small-box-footer">
                                            More info <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- ./col -->

                                <div class="col-lg-6 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3><?php echo $artikel[0]->total_artikel ?></h3>
                                            <p>Total Artikel</p>
                                        </div>
                                        <a href="<?php echo site_url('admin/news'); ?>" class="small-box-footer">
                                            More info <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- ./col -->



                            </div>
                        </div>
                        <div class="box-footer">
                            <small>Page rendered in <strong>{elapsed_time}</strong> seconds.</small>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </section>
</div>