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
                                        <?php echo form_open("admin/log/search") ?>
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
                                    <a href="<?php echo site_url('admin/log') ?>" class="btn btn-success btn-flat" title="Refresh halaman">refresh</a>
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
                                    <th>Message</th>
                                    <th>Time</th>
                                    <th>Executor</th>
                                    <th>IP Address</th>
                                </tr>
                                <?php
                                if ($log) {
                                    $nox = 1;
                                    $no = 1;
                                    foreach ($log as $key) {

                                ?>
                                        <tr>
                                            <td><?php echo $no + $numbers; ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-flat btn-info" data-toggle="modal" data-target="#modalDetail<?php echo $key->log_id; ?>">detail</button>
                                            </td>
                                            <td><?php echo $key->log_message; ?></td>
                                            <td><?php echo $key->log_time; ?></td>
                                            <td><?php echo $key->user_name; ?></td>
                                            <td><?php echo $key->log_ipaddress; ?></td>
                                        </tr>

                                        <!-- Modal Detail-->
                                        <div class="modal fade" id="modalDetail<?php echo $key->log_id ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <i aria-hidden="true" class="ki ki-close"></i>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <b>Message :</b><br><?php echo $key->log_message; ?><br>
                                                        <b>Time :</b><br><?php echo $key->log_time; ?><br>
                                                        <b>Executor :</b><br><?php echo $key->user_name; ?><br>
                                                        <b>IP Address :</b><br><?php echo $key->log_ipaddress; ?><br>

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
                            <?php if ($log) { ?>
                                <div class="float-left">Tampil <?php echo ($nox + $numbers) . " - " . (count($log) + $numbers) . " dari " . $total_data; ?> Data</div>
                            <?php } else { ?>
                                <div class="float-left">Tampil 0 <?php echo " dari " . $total_data; ?> Data</div>
                            <?php } ?>
                            <small>Page rendered in <strong>{elapsed_time}</strong> seconds.</small>
                        </div>
                    </div>
                </section>
            </div>