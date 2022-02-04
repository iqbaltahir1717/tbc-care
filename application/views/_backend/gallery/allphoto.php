            <div class="content-wrapper">
                <section class="content-header">
                    <h1 class="fontPoppins">
                        <?php echo strtoupper($title." ".substr($gallery_name[0]->gallery_name, 0, 20)."...");?>
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
                                    
                                </div>
                            </div>
                            <div class="box-tools pull-right">
                                <div style="padding-top:10px">
                                    <a href="<?php echo site_url('admin/gallery/data/photo')?>" class="btn btn-warning btn-flat" title="Kembali">kembali</a>
                                    <a href="<?php echo site_url('admin/gallery/all_photo/'.$this->uri->segment(4))?>" class="btn btn-success btn-flat" title="Refresh halaman">refresh</a>
                                    <a href="<?php echo site_url('admin/gallery/dropzone_photo/'.$this->uri->segment(4))?>" class="btn btn-primary btn-flat" title="Tambah">Tambah</a>
                                    
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
                                    <th style="width: 15%">#aksi</th>
                                    <th>Foto</th>
                                    <th>Token</th>
                                </tr>
                                <?php 

                                
                                    if($allphoto){
                                        $nox = 1; $no=1; foreach($allphoto as $key){
                                        
                                ?>
                                    <tr>
                                        <td><?php echo $no+$numbers;?></td>
                                        <td>
                                            <button class="btn btn-xs btn-flat btn-danger" data-toggle="modal" data-target="#modalDelete<?php echo $key->gallery_photo_id?>">hapus</button>
                                            
                                        </td>
                                        <td><a href="<?php echo base_url()."upload/gallery/photo/".$key->gallery_photo_name;?>" target="_blank" ><?php echo $key->gallery_photo_name;?></a></td>
                                        <td><?php echo $key->gallery_photo_token;?></td>
                                    </tr>


                                    <div class="modal fade" id="modalDelete<?php echo $key->gallery_photo_id;?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <i aria-hidden="true" class="ki ki-close"></i>
                                                    </button>
                                                </div>
                                                <?php echo form_open("admin/gallery/delete_gallery")?>
                                                <div class="modal-body">
                                                    Apakah anda yakin akan menghapus data foto : <?php echo $key->gallery_photo_name;?> ?
                                                    <?php echo csrf();?>
                                                    <input type="hidden" class="form-control" placeholder="Judul Galeri" name="gallery_photo_name" required="required" value="<?php echo $key->gallery_photo_name;?>">
                                                    <input type="hidden" class="form-control" name="gallery_photo_id" required="required" value="<?php echo $key->gallery_photo_id;?>">
                                                    <input type="hidden" class="form-control" name="gallery_id" required="required" value="<?php echo $key->gallery_id;?>">
                                                    <input type="hidden" class="form-control" name="gallery_photo_token" required="required" value="<?php echo $key->gallery_photo_token;?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger font-weight-bold">Hapus</button>
                                                    <?php echo form_close(); ?>
                                                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
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
                            <?php if($allphoto){?>
                            <div class="float-left">Tampil <?php echo ($nox+$numbers) ." - ". (count($allphoto)+$numbers) ." dari ". $total_data;?> Data</div>
                            <?php }else{ ?>
                            <div class="float-left">Tampil 0 <?php echo " dari ". $total_data;?> Data</div>
                            <?php }?>
                            <small>Page rendered in <strong>{elapsed_time}</strong> seconds.</small>
                        </div>
                    </div>
                </section>
            </div>