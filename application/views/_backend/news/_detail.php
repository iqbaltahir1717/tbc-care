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
                            
                            <div class="box-tools pull-right">
                                <div style="padding-top:10px">
                                    <a href="<?php echo site_url('admin/news')?>" class="btn btn-warning btn-flat" title="kembali ke halaman sebelumnya">kembali</a>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <b>Judul Informasi :</b><br> <?php echo $news[0]->news_title;?><br><br>
                            <b>Isi Informasi :</b><br> <?php echo $news[0]->news_text;?>

                        </div>
                        <div class="box-footer">
                            <small>Page rendered in <strong>{elapsed_time}</strong> seconds.</small>
                        </div>
                        

                    </div>
                </section>
            </div>