

    
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="<?php echo site_url('home')?>">Home</a></li>
                <li><a href="#">Tracking Pesan</a></li>
            </ol>
            <h2>Tracking Pesan</h2>
        </div>
    </section>
    <main id="main">
       
        <section id="services" class="blog">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="sidebar-item search-form">
                            <?php echo form_open("page/tracking_search/".$this->uri->segment(3), "class='form-inline'")?>
                                <input type="text" class="form-control" style="width:50%" placeholder="Masukkan Kode Tracking" name="key">
                                <button class ="btn  btn-danger" type="submit">Cek Progress Pesan</button>
                            <?php echo form_close();?>
                        </div>
                        <br>
                       
                        <br>
                        
                        <?php 
                            if($tracking){ 
                                echo "Kode Tracking  <b style='color:red;'>".$tracking[0]->message_code."</b><br>";
                                if($tracking[0]->message_status == 0){
                                    echo "<span class='badge badge-danger'>Belum Di Proses</span><br>";
                                }else{
                                    echo "<span class='badge badge-success'>Sudah Di Proses</span><br>";
                                }
                                echo "<b>Pesan Anda :</b><br>".$tracking[0]->message_text;

                                if($tracking[0]->message_reply !=""){
                                    echo "<br><br><b style='color:green;'>Respon Kami :</b><br>".$tracking[0]->message_reply;
                                }
                            }else{
                               if($this->uri->segment(2)=="tracking"){
                                   echo "Masukkan kode tracking anda agar memperoleh informasi progress pesan anda";
                               }else{
                                   echo "Kode yang anda masukkan tidak terdaftar";
                               }
                            }
                        ?>
                            
                    </div>
                    
                </div>
                <hr>
                
            </div>
        </section>
    </main><!-- End #main -->