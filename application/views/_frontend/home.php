<section id="hero">
    <img class="bg-pattern" src="<?php echo base_url() ?>assets/core-front/img/frame.png" alt="">
    <div class="container">
        <div class="hero-content">
            <div class="left-content">
                <span>Tempat Terbaik Untuk</span>
                <h1>Capai Badan yang Sehat Bersama <b>TBC-CARE</b></h1>
                <div class="mini-content">
                    <div class="video-content">
                        <img src="" alt="">
                        <img src="" alt="">
                    </div>
                    <p>The Health Center Program Compliance Manual and other resources to help current and prospective health centers understand program requirements.</p>
                </div>
                <!-- <a href="<?php echo site_url('auth') ?>" class="btn-primary bttn bttn-blue">Daftar</a> -->
            </div>
            <div class="right-content">
                <img src="<?php echo base_url() ?>assets/core-front/img/hero-image.png" alt="">
            </div>
        </div>
    </div>
</section>

<main id="main">
    <section id="about" class="about">
        <img class="bg-pattern" src="<?php echo base_url() ?>assets/core-front/img/frame.png" alt="">
        <div class="container" data-aos="fade-up">
            <div class="row content" style="padding: 70px 0;">
                <div class="col-lg-6">
                    <img src="<?php echo base_url(); ?>assets/core-front/img/image-doctor-dummy.png" height="500px">
                    <p>Serah Lunax James R.</p>
                    <span style="padding-left: 20px;">Ketua Rumah Sakit</span>
                </div>
                <div class="col-lg-6 images-doktor">
                    <span>Mengapa TBC-CARE ❓</span>
                    <h1>Memberikan Kesehatan Terbaik untuk orang baik</h1>
                    <p>The Health Center Program Compliance Manual and other resources to help current. <br>✅ Hemat Biaya <br>✅ Dokter Profesional <br>✅ Saran Makanan
                    </p>

                    <a href="#footer" class="btn-primary bttn bttn-border-blue" style="font-size:16px">Kontak Kami</a>
                </div>
            </div>
        </div>
    </section>
    <!-- <section id="about" class="about">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Kata Sambutan Pimpinan</h2>
            </div>
            <div class="row content">
                <div class="col-lg-3">
                    <img src="<?php echo base_url(); ?>upload/content/<?php echo $sambutan[0]->content_image; ?>" height="200px">
                </div>
                <div class="col-lg-9">
                    <?php echo $sambutan[0]->content_text; ?>
                </div>
            </div>
        </div>
    </section> -->




    <section id="faq" class="faq section-bg">
        <img class="bg-pattern" src="<?php echo base_url() ?>assets/core-front/img/frame.png" alt="">
        <div class="container" data-aos="fade-up" style="padding: 30px 0;">
            <div class="row content">
                <div class="col-lg-6">
                    <p class="title">F.A.Q</p>
                    <p>The Health Center Program Compliance Manual and other resources to help current.
                    </p>
                    <div class="faq-list">
                        <ul>
                            <?php $no = 1;
                            foreach ($faq as $f) { ?>
                                <li data-aos="fade-up" data-aos="fade-up" data-aos-delay="<?php echo $no; ?>00">
                                    <a style="color:#525252" data-toggle="collapse" class="collapse" href="#faq-list-<?php echo $no; ?>">❓ <?php echo $f->faq_question; ?> <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                                    <div id="faq-list-<?php echo $no; ?>" class="collapse" data-parent=".faq-list">
                                        <p>
                                            <?php echo $f->faq_answer; ?>
                                        </p>
                                    </div>
                                </li>
                            <?php $no++;
                            } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- <p class="title">Review</p> -->
                    <div class="review-list">
                        <img src="<?php echo base_url() ?>assets/core-front/img/hero-image2.png" alt="">
                        <!-- <p class="review-member">“Saya pernah ke beberapa tempat berbeda sebelumnya, tetapi tidak ada yang sebanding dengan ini.”</p>
                        <div class="row content">
                            <div class="col-lg-3">
                                <img src="<?php echo base_url(); ?>assets/core-front/img/avatar.png" alt="">
                            </div>
                            <div class="col-lg-6">
                                <p><b>John Kennedy</b> <br>
                                    TBC-CARE Member</p>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

        </div>
    </section>


    <section id="blog" class="blog" style="background-color: #fff; position:relative">
        <img class="bg-pattern" src="<?php echo base_url() ?>assets/core-front/img/frame.png" alt="">
        <div class="container" data-aos="fade-up" style="padding: 50px 0;">
            <p class="title" style=" font-weight: 100;font-size: 38px;">ARTIKEL</p>
            <p style="margin-bottom: 30px;">Kumpulan artikel yang selalu update</p>
            <div class="row">
                <?php foreach ($news as $n) { ?>
                    <div class="col-lg-3">
                        <article class="entry" style="background-color: #fff">
                            <div class="entry-img">
                                <a href="<?php echo site_url('page/information_detail/' . $n->news_category_id . '/' . $n->field_id . '/' . $n->news_slug); ?>">
                                    <img src="<?php echo base_url(); ?>upload/news/<?php echo $n->news_cover; ?>" style="object-fit: cover;" height="200px" width="100%" alt="">
                                </a>

                            </div>
                            <div class="entry-meta" style="color:#777777;font-size:12px;">
                                <ul style="display: flex;justify-content: space-between; ">
                                    <li class="">
                                        <?php echo indonesiaDate($n->news_date); ?>
                                    </li>
                                    <?php echo $n->news_count_view; ?>x dilihat</li>
                                </ul>
                            </div>
                            <h2 class="entry-title">
                                <a href="<?php echo site_url('page/information_detail/' . $n->news_category_id . '/' . $n->field_id . '/' . $n->news_slug); ?>"><?php echo substr($n->news_title, 0, 100); ?></a>
                            </h2>

                        </article>
                    </div>
                <?php } ?>
            </div>
            <a style="font-weight: 200;font-size: 16px;text-decoration-line: underline;color: #525252" class="float-right" href="<?php echo site_url('page/information/' . $n->news_category_id . '/') .  1 ?>"><u>Artikel Lainnya -></u></a>
        </div>
    </section>
</main>