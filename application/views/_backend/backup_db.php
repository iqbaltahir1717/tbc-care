            <div class="content-wrapper">
                <section class="content-header">
                    <h1 class="fontPoppins">
                        <?php echo strtoupper($title);?>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
                        <?php 
                            if($this->uri->segment(3)){
                                echo '<li class="active"><a href="'.site_url('admin/'.$this->uri->segment(2)).'">'.strtoupper($this->uri->segment(2)).'</a></li>';
                                echo '<li class="active">'.strtoupper($this->uri->segment(3)).'</li>';
                            }else{
                                echo '<li class="active">'.strtoupper($this->uri->segment(2)).'</li>';
                            }
                        ?>
                       
                    </ol>
                </section>
                
                <section class="content">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="box-tools pull-right">
                                <div style="padding-top:10px">
                                    <a href="<?php echo site_url('admin/backup')?>" class="btn btn-success btn-flat" title="Refresh halaman">refresh</a>
                                </div>
                            
                            </div>
                        </div>
                        <div class="box-body">
                            <?php
                                if($this->session->flashdata('alert')){
                                    echo $this->session->flashdata('alert');
                                }
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div style="border: 2px dashed #d2d6de; padding:10px;" class="text-center"> 
                                        <img src="<?php echo base_url();?>assets/core-images/backup.png"><br><br>
                                        <a href="<?php echo site_url('admin/backup/doBackupDatabases/gz')?>" class="btn btn-flat btn-danger">Backup Database(.gz)</a>
                                        <a href="<?php echo site_url('admin/backup/doBackupDatabases/sql')?>" class="btn btn-flat btn-danger">Backup Database(.sql)</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div style="border: 2px dashed #d2d6de; padding:10px;" class="text-center"> 
                                        <img src="<?php echo base_url();?>assets/core-images/restore.png"><br><br>
                                        <a href="<?php echo site_url('admin/backup/doRestoreDatabase')?>" class="btn btn-flat btn-success" title="Restore Database" data-toggle="modal" data-target="#modalRestore">Restore Database</a>

                                        <!-- Modal-->
                                        <div class="modal fade" id="modalRestore" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Restore DB</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <i aria-hidden="true" class="ki ki-close"></i>
                                                        </button>
                                                    </div>
                                                    <?php echo form_open_multipart("admin/backup/doRestoreDatabases")?>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for=""><b style="color: black">File Database <span style="color:red">*</span></b></label>
                                                            <?php echo csrf();?>
                                                            <input type="file" class="form-control" name="userfile" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success font-weight-bold">Restore</button>
                                                        <?php echo form_close(); ?>
                                                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                        <div class="box-footer">
                            <small>Page rendered in <strong>{elapsed_time}</strong> seconds.</small>
                        </div>
                    </div>
                </section>
            </div>