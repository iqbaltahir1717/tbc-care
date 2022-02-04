
            <div class="content-wrapper">
                <section class="content-header">
                    <h1 class="fontPoppins">
                        <?php echo strtoupper($title);?>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url('core_feature/dashboard');?>"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
                        <?php 
                            if($this->uri->segment(3)){
                                echo '<li class="active"><a href="'.site_url('core_feature/'.$this->uri->segment(2)).'">'.strtoupper($this->uri->segment(2)).'</a></li>';
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
                                    <a href="<?php echo site_url('admin/gallery/dropzone_photo/'.$this->uri->segment(4))?>" class="btn btn-success btn-flat" title="Refresh halaman">refresh</a>
                                    <a href="<?php echo site_url('admin/gallery/all_photo/'.$this->uri->segment(4))?>" class="btn btn-warning btn-flat" title="Refresh halaman">kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            

                            <div class="dropzone">
                                <div class="dz-message">
                                    <h3> Klik atau Drop gambar disini</h3>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <small>Page rendered in <strong>{elapsed_time}</strong> seconds.</small>
                        </div>
                    </div>

                    <script src="<?php echo base_url();?>assets/core-thirdparty/dropzone/dist/dropzone.js"></script>
                    <script type="text/javascript">

                        Dropzone.autoDiscover = false;

                        var foto_upload= new Dropzone(".dropzone",{
                            url                : "<?php echo base_url('index.php/admin/gallery/ajaxupload/'.$this->uri->segment(4)) ?>",
                            maxFilesize        : 2,
                            method             : "post",
                            acceptedFiles      : "image/*",
                            paramName          : "userfile",
                            dictInvalidFileType: "Type file ini tidak dizinkan",
                            addRemoveLinks     : true,
                        });


                        //Event ketika Memulai mengupload
                        foto_upload.on("sending",function(a,b,c){
                            a.token='token-'+'<?php echo date('YmdHis')?>'+'-'+Math.random();
                            c.append("token",a.token);
                        });


                        //Event ketika foto dihapus
                        foto_upload.on("removedfile",function(a){
                            var token=a.token;
                            $.ajax({
                                type:"post",
                                data:{token:token},
                                url:"<?php echo base_url('index.php/admin/gallery/ajaxremove/'.$this->uri->segment(4)) ?>",
                                cache:false,
                                dataType: 'json',
                                success: function(){
                                    console.log("Foto terhapus");
                                },
                                error: function(){
                                    console.log("Error");

                                }
                            });
                        });


                    </script>
                </section>
            </div>