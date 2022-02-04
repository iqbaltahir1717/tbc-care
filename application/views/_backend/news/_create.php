            <div class="content-wrapper">
                <section class="content-header">
                    <h1 class="fontPoppins">
                        <?php echo strtoupper($title);?>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
                        <?php 
                            if($this->uri->segment(3)){
                                echo '<li class="active"><a href="'.site_url('admin/'.$this->uri->segment(2)).'">'.strtoupper($title).'</a></li>';
                                echo '<li class="active">'.strtoupper($this->uri->segment(3)).'</li>';
                            }else{
                                echo '<li class="active">'.strtoupper($title).'</li>';
                            }
                        ?>
                       
                    </ol>
                </section>
                
                <section class="content">
                    <div class="box">
                        <?php echo form_open_multipart("admin/news/create")?>
                        <div class="box-header with-border">
                            
                            <div class="box-tools pull-right">
                                <div style="padding-top:10px">
                                    <a href="<?php echo site_url('admin/news')?>" class="btn btn-warning btn-flat" title="kembali ke halaman sebelumnya">kembali</a>
                                    <button type="submit" class="btn btn-primary btn-flat" title="Tambah data"> tambah</button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <?php echo csrf();?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for=""><b style="color: black">Bidang Publikasi <span style="color:red">*</span></b></label>
                                        <select class="form-control select2" name="field_id" required style="width:100%">
                                            <option value="">-Pilih Bidang Publikasi-</option>
                                            <?php
                                                foreach($field as $f){
                                                    echo '<option value="'.$f->field_id.'">'.$f->field_name.'</option>';
                                                }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b style="color: black">Kategori Informasi <span style="color:red">*</span></b></label>
                                        <select class="form-control select2" name="news_category_id" required style="width:100%">
                                            <option value="">-Pilih Kategori Informasi-</option>
                                            <?php
                                                foreach($news_category as $nw){
                                                    echo '<option value="'.$nw->news_category_id.'">'.$nw->news_category_name.'</option>';
                                                }
                                            ?>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for=""><b style="color: black">Judul Informasi <span style="color:red">*</span></b></label>
                                        <input type="text" class="form-control" placeholder="Judul Informasi" name="news_title" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for=""><b style="color: black">Cover/Thumbnail Informasi</b></label>
                                        <input type="file" class="form-control" placeholder="Cover/Thumbnail Informasi" name="news_cover" accept=".png, .jpeg, .jpg">
                                    </div>

                                    <div class="form-group">
                                        <label for=""><b style="color: black">Isi Informasi <span style="color:red">*</span></b></label>
                                        <textarea cols="80" id="editor" name="news_text" rows="10" style="resize:none;max-width:700px;"></textarea>
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