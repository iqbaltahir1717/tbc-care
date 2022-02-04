    <section id="hero" >
        <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
            <div class="carousel-inner" role="listbox">
                <?php $i =1; foreach($slider as $s){?>
                <div class="carousel-item <?php if($i==1){echo "active";}?>" style="background-image: url(<?php echo base_url();?>upload/slider/<?php echo $s->slider_image;?>)">
                    <div class="carousel-container">
                        <div class="container">
                            <h2 class="animate__animated animate__fadeInDown"><?php echo $s->slider_title;?></h2>
                            <p class="animate__animated animate__fadeInUp"><?php echo $s->slider_text;?></p>
                            
                        </div>
                    </div>
                </div>
                <?php $i++; } ?>
            </div>
        </div>
    </section>

    <div class="marquee pb-0">
        <marquee behavior="" direction="" scrollamount="6"><small><?php echo $setting[0]->setting_running_text;?></small></marquee>
    </div>


    <main id="main">
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Kata Sambutan Pimpinan</h2>
                </div>
                <div class="row content">
                    <div class="col-lg-3">
                        <img src="<?php echo base_url();?>upload/content/<?php echo $sambutan[0]->content_image;?>" height="200px" >
                    </div>
                    <div class="col-lg-9">
                        <?php echo $sambutan[0]->content_text;?>
                    </div>
                </div>
            </div>
        </section>

        <section id="blog" class="blog" style="background-color: #f1f8ff">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Berita Terbaru</h2>
                    <p>Kumpulan berita mengenai <?php echo $setting[0]->setting_owner_name;?> yang selalu up-to-date</p>
                </div>
                <div class="row">
                    <?php foreach($news as $n){ ?>
                        <div class="col-lg-3">
                            <article class="entry" style="background-color: #fff">
                                <div class="entry-img">
                                    <img src="<?php echo base_url();?>upload/news/<?php echo $n->news_cover;?>" height="200px" width="100%" alt="">
                                </div>
                                <h2 class="entry-title">
                                    <a href="<?php echo site_url('page/artikel_detail/'.$n->news_category_id.'/'.$n->field_id.'/'.$n->news_slug);?>"><?php echo substr($n->news_title,0,30)."...";?></a>
                                </h2>
                                <div class="entry-meta" style="color:#777777;font-size:12px;">
                                    <ul>
                                        <li class="d-flex align-items-center"> <i class="icofont-calendar"></i> <?php echo indonesiaDate($n->news_date);?></li>
                                        <li class="d-flex align-items-center"> <i class="icofont-eye-alt"></i> <b><?php echo $n->news_count_view;?>x dilihat</b></li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <div class="read-more" style="text-align-last:center">
                                        <a style="width:100%" href="<?php echo site_url('page/information_detail/'.$n->news_category_id.'/'.$n->field_id.'/'.$n->news_slug);?>">Selengkapnya</a>
                                    </div>
                                </div>

                            </article>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        
        <section id="clients" class="clients">
            <div class="container" data-aos="zoom-in">
                <div class="owl-carousel clients-carousel">
                    <?php foreach($link as $l){ ?>
                        <a href="<?php echo $l->link_url;?>" target="_blank"><img src="<?php echo base_url();?>upload/link/<?php echo $l->link_image;?>" alt=""></a>
                    <?php }?>
                </div>

            </div>
        </section>

        <section id="portfolio" class="portfoio" style="background-color: #f1f8ff;">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>GALERI</h2>
                    <p>Kumpulan Galeri Foto <?php echo $setting[0]->setting_owner_name;?>. Dari berbagai tanggal dan momen berbeda</p>
                </div>
                
                <div class="row portfolio-container">
                    <?php foreach($gallery as $g){ ?>
                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <img src="<?php echo base_url();?>upload/gallery/cover/<?php echo $g->gallery_cover;?>" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <?php if(strlen($g->gallery_name) > 16){ ?>
                                <h4><?php echo substr($g->gallery_name,0,15)."...";?></h4>
                            <?php }else{?>
                                <h4><?php echo $g->gallery_name;?></h4>
                            <?php }?>
                            <a href="<?php echo site_url('page/gallery_detail/photo/'.$g->gallery_id)?>" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 1"><i class="icofont-eye-alt"></i></a>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </section>
        
        <section id="cta" class="cta">
            <div class="container">
                <div class="row" data-aos="zoom-in">
                    <div class="col-lg-9 text-center text-lg-left">
                        <h3>Tracking Pesan/Aduan/Kritik Anda</h3>
                        <p> Ingin mengetahui progress dari pesan/aduan/kritik yang telah anda sampaikan pada kami? Silahkan klik tombol Tracking untuk mengetahui detailnya.</p>
                    </div>
                    <div class="col-lg-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle" href="<?php echo site_url('page/tracking');?>">Tracking Pesan</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="faq section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>F.A.Q</h2>
                </div>

                <div class="faq-list">
                    <ul>
                        <?php $no=1; foreach($faq as $f){ ?>
                        <li data-aos="fade-up" data-aos="fade-up" data-aos-delay="<?php echo $no;?>00">
                            <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" class="collapse" href="#faq-list-<?php echo $no;?>"><?php echo $f->faq_question;?> <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-<?php echo $no;?>" class="collapse" data-parent=".faq-list">
                                <p>
                                    <?php echo $f->faq_answer;?>
                                </p>
                            </div>
                        </li>
                        <?php $no++;} ?>
                    </ul>
                </div>

            </div>
        </section>
        
        <section id="contact" class="contact">
            <div class="container-fluid" data-aos="fade-up">
                <div class="section-title">
                    <h2>HUBUNGI KAMI</h2>
                    <p>Jika memiliki pertanyaan atau sesuatu mengenai <?php echo $setting[0]->setting_owner_name;?>, silahkan mengisi form dibawah agar kami <br>tahu mengenai apa yang ingin kamu ketahui lebih dari kami. Atas perhatianmu kami ucapkan Terimakasih</p>
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