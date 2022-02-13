<div class="content-wrapper">
    <section class="content-header">
        <h1 class="fontPoppins">
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
        <div class="box">
            <div class="box-header with-border">
                <div class="box-tools pull-left">
                    <div class="form-inline">
                        <select class="form-control" id="rowpage">
                            <?php
                            $rowpage = array(5, 10, 25, 50, 100);
                            for ($r = 0; $r < count($rowpage); $r++) {
                                if ($rowpage[$r] == $this->session->userdata('sess_rowpage')) {
                                    echo '<option value="' . $rowpage[$r] . '" selected>' . $rowpage[$r] . '</option>';
                                } else {
                                    echo '<option value="' . $rowpage[$r] . '">' . $rowpage[$r] . '</option>';
                                }
                            }
                            ?>

                        </select>
                        <div class="input-group margin">
                            <?php echo form_open("admin/user/search") ?>
                            <input type="text" class="form-control" name="key" placeholder="Masukkan kata kunci pencarian">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-danger btn-flat">cari</button>
                            </span>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
                <div class="box-tools pull-right">
                    <div style="padding-top:10px">
                        <a href="<?php echo site_url('admin/user') ?>" class="btn btn-success btn-flat" title="Refresh halaman">refresh</a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <?php
                if ($this->session->flashdata('alert')) {
                    echo $this->session->flashdata('alert');
                }

                if ($this->uri->segment(3) == "search") {
                    echo "Kata Kunci Pencarian : <span class='label label-danger label-inline font-weight-lighter mr-2'>" . $search . "</span><hr style='border: 0.5px dashed #d2d6de'>";
                }
                ?>
                <table class="table table-bordered">
                    <tr style="background-color: gray;color:white">
                        <th style="width: 60px">No</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis Kelamin</th>
                        <th>Umur (Tahun)</th>
                        <th>Berat Badan (kg)</th>
                        <th>Tinggi Badan (cm)</th>
                        <th>Status</th>
                        <th style="width: 15%">#aksi</th>
                    </tr>
                    <?php
                    if ($pasien) {
                        $nox = 1;
                        $no = 1;
                        foreach ($pasien as $key) {

                    ?>
                            <tr>
                                <td><?php echo $no + $numbers; ?></td>
                                <td><?php echo $key->user_fullname; ?></td>

                                <td>
                                    <?php if ("W" == $key->user_gender) {
                                        echo "Perempuan";
                                    }
                                    if ("L" == $key->user_gender) {
                                        echo "Laki-Laki";
                                    } ?>
                                </td>
                                <td>
                                    <?php
                                    $tanggal = new  DateTime($key->user_birth);
                                    $today = new DateTime('today');
                                    $y = $today->diff($tanggal)->y;

                                    echo $y;
                                    ?></td>
                                <td><?php echo $key->user_bb; ?></td>
                                <td><?php echo $key->user_tb; ?></td>
                                <td><?php echo $key->user_status; ?></td>
                                <td>
                                    <button class="btn btn-xs btn-flat btn-info" data-toggle="modal" data-target="#modalDetail<?php echo $key->user_id; ?>">detail</button>
                                    <button class="btn btn-xs btn-flat btn-warning" data-toggle="modal" data-target="#modalUpdate<?php echo $key->user_id; ?>">update</button>
                                </td>
                            </tr>

                            <!-- Modal Update-->
                            <div class="modal fade" id="modalUpdate<?php echo $key->user_id ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Update Data</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <?php echo form_open("admin/pasien/update") ?>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for=""><b style="color: black">Nama Pasien <span style="color:red">*</span></b></label>
                                                <?php echo csrf(); ?>
                                                <input type="text" class="form-control" placeholder="Nama Lengkap" name="user_fullname" required="required" value="<?php echo $key->user_fullname; ?>">
                                                <input type="hidden" class="form-control" name="user_id" required="required" value="<?php echo $key->user_id; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for=""><b style="color: black">Status <span style="color:red">*</span></b></label>
                                                <select class="form-control" name="user_status" required="required">
                                                    <option value="">-Status Pasien-</option>
                                                    <?php
                                                    $rowpage = array('Masa Pengobatan', 'Selesai');
                                                    for ($r = 0; $r < count($rowpage); $r++) {
                                                        if ($rowpage[$r] == $key->user_status) {
                                                            echo '<option value="' . $rowpage[$r] . '" selected>' . $rowpage[$r] . '</option>';
                                                        } else {
                                                            echo '<option value="' . $rowpage[$r] . '">' . $rowpage[$r] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for=""><b style="color: black">Aktifitas <span style="color:red">*</span></b></label>
                                                <select class="form-control" name="user_activity" required="required">
                                                    <option value="">-Aktifitas Pasien-</option>
                                                    <?php
                                                    $rowpage = array('Sangat Ringan', 'Ringan', 'Sedang', 'Berat', 'Sangat Berat');
                                                    for ($r = 0; $r < count($rowpage); $r++) {
                                                        if ($rowpage[$r] == $key->user_activity) {
                                                            echo '<option value="' . $rowpage[$r] . '" selected>' . $rowpage[$r] . '</option>';
                                                        } else {
                                                            echo '<option value="' . $rowpage[$r] . '">' . $rowpage[$r] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for=""><b style="color: black">Berat Badan Pasien (kg) <span style="color:red">*</span></b></label>
                                                        <?php echo csrf(); ?>
                                                        <input type="text" class="form-control" placeholder="Berat Badan (kg)" name="user_bb" required="required" value="<?php echo $key->user_bb; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for=""><b style="color: black">Tinggi Badan Pasien (cm)<span style="color:red">*</span></b></label>
                                                        <?php echo csrf(); ?>
                                                        <input type="text" class="form-control" placeholder="Berat Badan (cm)" name="user_tb" required="required" value="<?php echo $key->user_tb; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr style="border: 0.5px dashed #000">
                                            <div class="form-group">
                                                <label for=""><b style="color: black">Tanggal Lahir<span style="color:red">*</span></b></label>
                                                <?php echo csrf(); ?>
                                                <input type="date" class="form-control" placeholder="" name="user_birth" required="required" value="<?php echo $key->user_birth; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for=""><b style="color: black">Jenis Kelamin <span style="color:red">*</span></b></label>
                                                <select class="form-control" name="user_gender" required="required">
                                                    <option value="">-Jenis Kelamin-</option>
                                                    <?php
                                                    $rowpage = array('L', 'W');
                                                    for ($r = 0; $r < count($rowpage); $r++) {
                                                        if ($rowpage[$r] == $key->user_gender) {
                                                            echo '<option value="' . $rowpage[$r] . '" selected>' . $rowpage[$r] . '</option>';
                                                        } else {
                                                            echo '<option value="' . $rowpage[$r] . '">' . $rowpage[$r] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for=""><b style="color: black">Alamat<span style="color:red">*</span></b></label>
                                                <?php echo csrf(); ?>
                                                <input type="text" class="form-control" placeholder="Alamat Pasien" name="user_alamat" required="required" value="<?php echo $key->user_alamat; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for=""><b style="color: black">No. HP<span style="color:red">*</span></b></label>
                                                <?php echo csrf(); ?>
                                                <input type="text" class="form-control" placeholder="cth: 62852xxxxxxxx" maxlength="14" name="user_no" required="required" value="<?php echo $key->user_no; ?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning font-weight-bold">Update</button>
                                            <?php echo form_close(); ?>
                                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Delete-->
                            <div class="modal fade" id="modalDelete<?php echo $key->user_id ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <?php echo form_open("admin/user/delete") ?>
                                        <div class="modal-body">
                                            Apakah anda yakin akan menghapus data user : <?php echo $key->user_name; ?> ?
                                            <?php echo csrf(); ?>
                                            <input type="hidden" class="form-control" placeholder="Nama user" name="user_name" required="required" value="<?php echo $key->user_name; ?>">
                                            <input type="hidden" class="form-control" name="user_id" required="required" value="<?php echo $key->user_id; ?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger font-weight-bold">Hapus</button>
                                            <?php echo form_close(); ?>
                                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Detail-->
                            <div class="modal fade" id="modalDetail<?php echo $key->user_id ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <b>Nama User :</b><br><?php echo $key->user_fullname; ?><br>
                                            <b>Email :</b><br><?php echo $key->user_email; ?><br>
                                            <b>Group :</b><br><?php echo $key->group_name; ?><br>
                                            <b>Username :</b><br><?php echo $key->user_name; ?><br>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


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


                </table>
            </div>
            <div class="box-footer">



                <!-- PAGINATION -->
                <div class="float-right"><?php echo $links; ?></div>

                <!-- COUNT DATA -->
                <?php if ($pasien) { ?>
                    <div class="float-left">Tampil <?php echo ($nox + $numbers) . " - " . (count($pasien) + $numbers) . " dari " . $total_data; ?> Data</div>
                <?php } else { ?>
                    <div class="float-left">Tampil 0 <?php echo " dari " . $total_data; ?> Data</div>
                <?php } ?>
                <small>Page rendered in <strong>{elapsed_time}</strong> seconds.</small>
            </div>
        </div>
    </section>
</div>