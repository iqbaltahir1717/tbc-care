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
                        <div class="box-header with-border">
                            <div class="box-tools pull-left">
                                <div class="form-inline">
                                    <select class="form-control" id="rowpage">
                                        <?php 
                                            $rowpage = array(5,10,25,50,100);
                                            for($r=0; $r < count($rowpage); $r++){
                                                if($rowpage[$r] == $this->session->userdata('sess_rowpage')){
                                                    echo '<option value="'.$rowpage[$r].'" selected>'.$rowpage[$r].'</option>';
                                                }else{
                                                    echo '<option value="'.$rowpage[$r].'">'.$rowpage[$r].'</option>';
                                                }
                                            }
                                        ?>
                                        
                                    </select>
                                    <div class="input-group margin">
                                        <?php echo form_open("admin/gallery/search/".$this->uri->segment(4))?>
                                            <input type="text" class="form-control" name="key" placeholder="Masukkan kata kunci pencarian">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-danger btn-flat">cari</button>
                                            </span>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                            <div class="box-tools pull-right">
                                <div style="padding-top:10px">
                                    <a href="<?php echo site_url('admin/gallery/data/'.$this->uri->segment(4))?>" class="btn btn-success btn-flat" title="Refresh halaman">refresh</a>
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
                                            <?php echo form_open_multipart("admin/gallery/create")?>
                                            <div class="modal-body">
                                                <?php echo csrf();?>
                                                <div class="form-group">
                                                    <label for=""><b style="color: black">Judul Galeri <span style="color:red">*</span></b></label>
                                                    <input type="text" class="form-control" placeholder="Judul Galeri" name="gallery_name" required="required">
                                                    <input type="hidden" class="form-control" name="gallery_type" required="required" value="<?php echo $this->uri->segment(4);?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for=""><b style="color: black">Tanggal Galeri<span style="color:red">*</span></b></label>
                                                    <input type="text" class="form-control datepicker" placeholder="Tanggal Galeri" name="gallery_date" required="required">
                                                </div>
                                                <div class="form-group">
                                                    <label for=""><b style="color: black">Deskripsi Galeri <span style="color:red">*</span></b></label>
                                                    <textarea class="form-control" rows="3" name="gallery_description" placeholder="Deskripsi Galeri"></textarea>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for=""><b style="color: black">Galeri Cover <span style="color:red">*</span></b></label>
                                                    <input type="file" class="form-control" placeholder="Galeri Cover" name="gallery_cover" required="required" accept=".jpeg, .jpg, .png">
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
                                if($this->session->flashdata('alert')){
                                    echo $this->session->flashdata('alert');
                                }

                                if($this->uri->segment(3)=="search"){
                                    echo "Kata Kunci Pencarian : <span class='label label-danger label-inline font-weight-lighter mr-2'>".$search."</span><hr style='border: 0.5px dashed #d2d6de'>";
                                }
                            ?>
                            <table class="table table-bordered">
                                <tr style="background-color: gray;color:white">
                                    <th style="width: 60px">No</th>
                                    <th style="width: 25%">#aksi</th>
                                    <th>Judul Galeri</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal</th>
                                    <th>Cover Galeri</th>
                                </tr>
                                <?php 
                                    if($gallery){
                                        $nox = 1; $no=1; foreach($gallery as $key){
                                        
                                ?>
                                    <tr>
                                        <td><?php echo $no+$numbers;?></td>
                                        <td>
                                            <button class="btn btn-xs btn-flat btn-warning" data-toggle="modal" data-target="#modalUpdate<?php echo $key->gallery_id;?>">update</button>
                                            <button class="btn btn-xs btn-flat btn-danger" data-toggle="modal" data-target="#modalDelete<?php echo $key->gallery_id?>">hapus</button>
                                            <a href="<?php echo site_url('admin/gallery/all_photo/'.$key->gallery_id); ?>" class="btn btn-xs btn-flat btn-success" >kelola foto</a>
                                        </td>
                                        <td><?php echo $key->gallery_name;?></td>
                                        <td><?php echo $key->gallery_description;?></td>
                                        <td><?php echo indonesiaDate($key->gallery_date);?></td>
                                        <td><a href="<?php echo base_url()."upload/gallery/cover/".$key->gallery_cover;?>" target="_blank" ><?php echo $key->gallery_cover;?></a></td>
                                    </tr>

                                    <!-- Modal Update-->
                                    <div class="modal fade" id="modalUpdate<?php echo $key->gallery_id?>" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <i aria-hidden="true" class="ki ki-close"></i>
                                                    </button>
                                                </div>
                                                <?php echo form_open_multipart("admin/gallery/update")?>
                                                <div class="modal-body">
                                                    <?php echo csrf();?>
                                                    <div class="form-group">
                                                        <label for=""><b style="color: black">Judul Galeri <span style="color:red">*</span></b></label>
                                                        <input type="text" class="form-control" placeholder="Judul Galeri" name="gallery_name" required="required" value="<?php echo $key->gallery_name;?>">
                                                        <input type="hidden" class="form-control" name="gallery_id" required="required" value="<?php echo $key->gallery_id;?>">
                                                        <input type="hidden" class="form-control" name="gallery_cover_old" required="required" value="<?php echo $key->gallery_cover;?>">
                                                        <input type="hidden" class="form-control" name="gallery_type" required="required" value="<?php echo $this->uri->segment(4);?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b style="color: black">Tanggal Galeri <span style="color:red">*</span></b></label>
                                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Galeri" name="gallery_date" required="required" value="<?php echo $key->gallery_date;?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b style="color: black">Deskripsi Galeri <span style="color:red">*</span></b></label>
                                                        <textarea class="form-control" rows="3" name="gallery_description" placeholder="Deskripsi Galeri"><?php echo $key->gallery_description;?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for=""><b style="color: black">Galeri Cover</b></label><br>
                                                        <span class="text-red">file sebelumnya: </span><a href="<?php echo base_url()."upload/gallery/cover/".$key->gallery_cover;?>" target="_blank" ><?php echo $key->gallery_cover;?></a>
                                                        <input type="file" class="form-control" placeholder="Judul Galeri" name="gallery_cover" accept=".jpeg, .jpg, .png">
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
                                    <div class="modal fade" id="modalDelete<?php echo $key->gallery_id?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <i aria-hidden="true" class="ki ki-close"></i>
                                                    </button>
                                                </div>
                                                <?php echo form_open("admin/gallery/delete")?>
                                                <div class="modal-body">
                                                    Apakah anda yakin akan menghapus data gallery : <?php echo $key->gallery_name;?> ?
                                                    <?php echo csrf();?>
                                                    <input type="hidden" class="form-control" placeholder="Judul Galeri" name="gallery_name" required="required" value="<?php echo $key->gallery_name;?>">
                                                    <input type="hidden" class="form-control" name="gallery_id" required="required" value="<?php echo $key->gallery_id;?>">
                                                    <input type="hidden" class="form-control" name="gallery_cover" required="required" value="<?php echo $key->gallery_cover;?>">
                                                    <input type="hidden" class="form-control" name="gallery_type" required="required" value="<?php echo $this->uri->segment(4);?>">
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
                                    <div class="modal fade" id="modalDetail<?php echo $key->gallery_id?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <i aria-hidden="true" class="ki ki-close"></i>
                                                    </button>
                                                </div>
                                                
                                                <div class="modal-body">
                                                    <b>Judul Galeri :</b><br><?php echo $key->gallery_name;?><br><br>
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                       
                                <?php 
                                        $no++; }
                                    }else{
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
                            <div class="float-right"><?php echo $links;?></div>
                            
                            <!-- COUNT DATA -->
                            <?php if($gallery){?>
                            <div class="float-left">Tampil <?php echo ($nox+$numbers) ." - ". (count($gallery)+$numbers) ." dari ". $total_data;?> Data</div>
                            <?php }else{ ?>
                            <div class="float-left">Tampil 0 <?php echo " dari ". $total_data;?> Data</div>
                            <?php }?>
                            <small>Page rendered in <strong>{elapsed_time}</strong> seconds.</small>
                        </div>
                    </div>
                </section>
            </div>