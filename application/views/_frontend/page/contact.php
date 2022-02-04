

     
     <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">

            <ol>
                <li><a href="<?php echo site_url('home')?>">Home</a></li>
                <li><a href="#">Kontak</a></li>
            </ol>
            <h2>Kontak</h2>

        </div>
    </section>
    <main id="main">
       
    
    <section id="contact" class="contact">
        <div class="container-fluid" data-aos="fade-up">
            <div class="section-title">
                <h2>Kontak</h2>
            </div>
            <div class="row mt-1 d-flex justify-content-end" data-aos="fade-right" data-aos-delay="100">
                <div class="col-lg-4">
                    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $setting[0]->setting_apikey_map;?>&callback=initMap&libraries=&v=weekly" async></script>
                    <script>
                        var infos = [
                            ['<b>Nama Instansi :</b> <br><?php echo $setting[0]->setting_owner_name;?><br> <br><b>Alamat :</b> <br><?php echo $setting[0]->setting_address;?><br><br> <b>Telepon :</b> <br><?php echo $setting[0]->setting_phone;?> <br><br> <b>Email :</b><br> <?php echo $setting[0]->setting_email;?>', <?php echo $setting[0]->setting_coordinate;?>],
                        ];

                        function initMap() {

                            const place = { lat: infos[0][1], lng: infos[0][2] };
                            const map = new google.maps.Map(document.getElementById("map-canvas"), {
                                zoom: 17,
                                center: place,
                            });
                            const contentString = infos[0][0];
                            const infowindow = new google.maps.InfoWindow({
                                content: contentString,
                            });
                            const marker = new google.maps.Marker({
                                position: place,
                                map,
                            });
                            marker.addListener("click", () => {
                                infowindow.open(map, marker);
                            });
                        }

                    </script>
                    <div id="map-canvas"></div>

                    
                </div>
                <div class="col-lg-2">
                    <div class="info">
                        <div class="address">
                            <i class="icofont-google-map"></i>
                            <h4>Lokasi Kantor:</h4>
                            <p><?php echo $setting[0]->setting_address;?></p>
                        </div>

                        <div class="email">
                            <i class="icofont-envelope"></i>
                            <h4>Email:</h4>
                            <p><?php echo $setting[0]->setting_email;?></p>
                        </div>

                        <div class="phone">
                            <i class="icofont-phone"></i>
                            <h4>Telepon:</h4>
                            <p><?php echo $setting[0]->setting_phone;?></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="100">
                    <?php
                        if($this->session->flashdata('alert')){
                            echo $this->session->flashdata('alert');
                        }

                        
                    ?>
                    <?php echo form_open_multipart("page/create_message")?>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <?php echo csrf();?>
                                <input type="text" name="message_name" class="form-control" id="name" placeholder="Nama Anda" data-rule="minlen:4" data-msg="Nama minimal 4 karakter" required/>
                                <div class="validate"></div>
                            </div>
                            <div class="col-md-3 form-group">
                                <input type="text" class="form-control" name="message_phone" id="email" placeholder="Nomor HP Anda" data-rule="minlen:16" data-msg="Masukkan nomor telpon yang valid" required/>
                                <div class="validate"></div>
                            </div>
                            <div class="col-md-3 form-group">
                                <input type="email" class="form-control" name="message_email" id="email" placeholder="Email Anda" data-rule="email" data-msg="Masukkan email anda yang valid" required/>
                                <div class="validate"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="message_subject" id="subject" placeholder="Subjek Pesan" data-rule="minlen:4" data-msg="Subject minimal 4-8 karakter" required/>
                            <div class="validate"></div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="message_text" rows="5" data-rule="required" data-msg="Tulis sesuatu dikolom pesan" placeholder="Pesan Anda" required></textarea>
                            <div class="validate"></div>
                        </div>
                        
                        <div class="text-center"><button class="btn btn-danger" type="submit">Kirim Pesan</button></div>
                    <?php echo form_close(); ?>

                </div>

            </div>
        </div>
    </section>
        
    </main>