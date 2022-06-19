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
                                    <button type="submit" class="btn btn-primary btn-flat" title="Tambah data" data-toggle="modal" data-target="#modalCreate"> tambah</button>
                                </div>

                                <!-- Modal-->
                                <div class="modal fade" id="modalCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Baru</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                </button>
                                            </div>
                                            <?php echo form_open("admin/user/create") ?>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for=""><b style="color: black">Nama User <span style="color:red">*</span></b></label>
                                                    <?php echo csrf(); ?>
                                                    <input type="text" class="form-control" placeholder="Nama User/Fullname" name="user_fullname" required="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for=""><b style="color: black">Email <span style="color:red">*</span></b></label>
                                                    <input type="email" class="form-control" placeholder="Email User" name="user_email" required="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for=""><b style="color: black">Group <span style="color:red">*</span></b></label>
                                                    <select class="form-control" name="group_id" required>
                                                        <option value="">- Pilih Group -</option>
                                                        <?php
                                                        foreach ($group as $g) {
                                                            echo '<option value="' . $g->group_id . '">' . $g->group_name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <hr style="border: 0.5px dashed #d2d6de">
                                                <div class="form-group">
                                                    <label for=""><b style="color: black">Username <span style="color:red">*</span></b></label>
                                                    <input type="text" class="form-control" placeholder="Username" name="user_name" required="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for=""><b style="color: black">Password <span style="color:red">*</span></b></label>
                                                    <input type="password" class="form-control" placeholder="Password" name="user_password" required="required">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                                                <?php echo form_close(); ?>
                                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <?php
                            if ($this->session->flashdata('alert')) {
                                echo $this->session->flashdata('alert');
                                unset($_SESSION['alert']);
                            }

                            if ($this->uri->segment(3) == "search") {
                                echo "Kata Kunci Pencarian : <span class='label label-danger label-inline font-weight-lighter mr-2'>" . $search . "</span><hr style='border: 0.5px dashed #d2d6de'>";
                            }
                            ?>
                            <table class="table table-bordered">
                                <tr style="background-color: gray;color:white">
                                    <th style="width: 60px">No</th>
                                    <th style="width: 20%">#aksi</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Group</th>
                                </tr>
                                <?php
                                if ($user) {
                                    $nox = 1;
                                    $no = 1;
                                    foreach ($user as $key) {

                                ?>
                                        <tr>
                                            <td><?php echo $no + $numbers; ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-flat btn-info" data-toggle="modal" data-target="#modalDetail<?php echo $key->user_id; ?>">detail</button>
                                                <button class="btn btn-xs btn-flat btn-warning" data-toggle="modal" data-target="#modalUpdate<?php echo $key->user_id; ?>">update</button>
                                                <button class="btn btn-xs btn-flat btn-danger" data-toggle="modal" data-target="#modalDelete<?php echo $key->user_id ?>">hapus</button>
                                            </td>
                                            <td><?php echo $key->user_fullname; ?></td>
                                            <td><?php echo $key->user_name; ?></td>
                                            <td><?php echo $key->user_email; ?></td>
                                            <td><?php echo $key->group_name; ?></td>
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
                                                    <?php echo form_open("admin/user/update") ?>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for=""><b style="color: black">Nama User <span style="color:red">*</span></b></label>
                                                            <?php echo csrf(); ?>
                                                            <input type="text" class="form-control" placeholder="Nama User/Fullname" name="user_fullname" required="required" value="<?php echo $key->user_fullname; ?>">
                                                            <input type="hidden" class="form-control" name="user_id" required="required" value="<?php echo $key->user_id; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for=""><b style="color: black">Email <span style="color:red">*</span></b></label>
                                                            <input type="email" class="form-control" placeholder="Email User" name="user_email" required="required" value="<?php echo $key->user_email; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for=""><b style="color: black">Group <span style="color:red">*</span></b></label>
                                                            <select class="form-control" name="group_id" required>
                                                                <option value="">- Pilih Group -</option>
                                                                <?php
                                                                foreach ($group as $g) {
                                                                    if ($key->group_id == $g->group_id) {
                                                                        echo '<option value="' . $g->group_id . '" selected>' . $g->group_name . '</option>';
                                                                    } else {
                                                                        echo '<option value="' . $g->group_id . '">' . $g->group_name . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <hr style="border: 0.5px dashed #d2d6de">
                                                        <div class="form-group">
                                                            <label for=""><b style="color: black">Username <span style="color:red">*</span></b></label>
                                                            <input type="text" class="form-control" placeholder="Username" name="user_name" required="required" value="<?php echo $key->user_name; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for=""><b style="color: black">Password <span style="color:red">*</span></b><br><small style="color:red"><i>Kosongkan jika tidak ingin mengubah password</i></small></b></label>
                                                            <input type="password" class="form-control" placeholder="Password" name="user_password">
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
                            <?php if ($user) { ?>
                                <div class="float-left">Tampil <?php echo ($nox + $numbers) . " - " . (count($user) + $numbers) . " dari " . $total_data; ?> Data</div>
                            <?php } else { ?>
                                <div class="float-left">Tampil 0 <?php echo " dari " . $total_data; ?> Data</div>
                            <?php } ?>
                            <small>Page rendered in <strong>{elapsed_time}</strong> seconds.</small>
                        </div>
                    </div>
                </section>
            </div>