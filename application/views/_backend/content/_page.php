            <div class="content-wrapper">
                <section class="content-header">
                    <h1 class="fontPoppins">
                        <?php echo strtoupper($this->uri->segment(4));?>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
                        <?php 
                            if($this->uri->segment(3)){
                                echo '<li class="active"><a href="'.site_url('admin/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4)).'">'.strtoupper($this->uri->segment(2)).'</a></li>';
                                echo '<li class="active">'.strtoupper($this->uri->segment(3)).'</li>';
                                echo '<li class="active">'.strtoupper($this->uri->segment(4)).'</li>';
                            }else{
                                echo '<li class="active">'.strtoupper($this->uri->segment(2)).'</li>';
                            }
                        ?>
                       
                    </ol>
                </section>
                
                <section class="content">
                    <div class="box">
                        


                        <?php echo form_open_multipart("admin/content/update")?>
                        <div class="box-header with-border">
                            
                            <div class="box-tools pull-right">
                                <div style="padding-top:10px">
                                    <a href="<?php echo site_url('admin/content/page/'.$content[0]->content_menu)?>" class="btn btn-success btn-flat" title="Refresh halaman">refresh</a>
                                    <button type="submit" class="btn btn-warning btn-flat" title="Update data"> update</button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <?php echo csrf();?>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                        if($this->session->flashdata('alert')){
                                            echo $this->session->flashdata('alert');
                                        }
                                    ?>

                                    <div class="form-group">
                                        <label for=""><b style="color: black">Menu <span style="color:red">*</span></b></label>
                                        <input type="text" class="form-control" placeholder="Judul Berita" required="required" value="<?php echo $content[0]->content_title;?>" readonly>
                                        <input type="hidden" class="form-control" name="content_id" required="required" value="<?php echo $content[0]->content_id;?>">
                                        <input type="hidden" class="form-control" name="content_menu" required="required" value="<?php echo $content[0]->content_menu;?>">
                                        
                                    </div>
                                    <?php if($this->uri->segment(4)=="sambutan"){?>
                                    <div class="form-group">
                                        <label for=""><b style="color: black">Foto Kepala Dinas </b></label><br>
                                        <span class="text-red">file sebelumnya: </span><a href="<?php echo base_url();?>upload/content/<?php echo $content[0]->content_image;?>"><?php echo $content[0]->content_image;?></a>
                                        <input type="file" class="form-control" placeholder="Foto Kepala Dinas" name="content_image" accept=".png, .jpeg, .jpg">
                                        <input type="hidden" class="form-control" name="content_image_old" value="<?php echo $content[0]->content_image;?>">
                                    </div>
                                    <?php }elseif($this->uri->segment(4)=="struktur"){?>
                                    <div class="form-group">
                                        <label for=""><b style="color: black">Foto Struktur Organisasi </b></label><br>
                                        <span class="text-red">file sebelumnya: </span><a href="<?php echo base_url();?>upload/content/<?php echo $content[0]->content_image;?>"><?php echo $content[0]->content_image;?></a>
                                        <input type="file" class="form-control" placeholder="Foto Struktur Organisasi" name="content_image" accept=".png, .jpeg, .jpg">
                                        <input type="hidden" class="form-control" name="content_image_old" value="<?php echo $content[0]->content_image;?>">
                                    </div>
                                    <?php } ?>

                                    <div class="form-group">
                                        <label for=""><b style="color: black">Isi Konten <span style="color:red">*</span></b></label>
                                        <textarea cols="80" id="editor" name="content_text" rows="10" style="resize:none;max-width:700px;"><?php echo $content[0]->content_text;?></textarea>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <small>Page rendered in <strong>{elapsed_time}</strong> seconds.</small>
                        </div>
                        <?php echo form_close(); ?>

                    </div>
                </section>
            </div>