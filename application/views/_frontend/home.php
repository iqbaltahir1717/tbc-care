<section id="hero">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
        <div class="carousel-inner" role="listbox">
            <?php $i = 1;
            foreach ($slider as $s) { ?>
                <div class="carousel-item <?php if ($i == 1) {
                                                echo "active";
                                            } ?>" style="background-image: url(<?php echo base_url(); ?>upload/slider/<?php echo $s->slider_image; ?>)">
                    <div class="carousel-container">
                        <div class="container">
                            <h2 class="animate__animated animate__fadeInDown"><?php echo $s->slider_title; ?></h2>
                            <p class="animate__animated animate__fadeInUp"><?php echo $s->slider_text; ?></p>

                        </div>
                    </div>
                </div>
            <?php $i++;
            } ?>
        </div>
    </div>
</section>

<main id="main">
    <section id="about" class="about">
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
    </section>




    <section id="faq" class="faq section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>F.A.Q</h2>
            </div>

            <div class="faq-list">
                <ul>
                    <?php $no = 1;
                    foreach ($faq as $f) { ?>
                        <li data-aos="fade-up" data-aos="fade-up" data-aos-delay="<?php echo $no; ?>00">
                            <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" class="collapse" href="#faq-list-<?php echo $no; ?>"><?php echo $f->faq_question; ?> <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
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
    </section>


    <section id="blog" class="blog" style="background-color: #fff">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Artikel Terbaru</h2>
                <p>Kumpulan Artikel mengenai <?php echo $setting[0]->setting_owner_name; ?> yang selalu up-to-date</p>
            </div>
            <div class="row">
                <?php foreach ($news as $n) { ?>
                    <div class="col-lg-3">
                        <article class="entry" style="background-color: #fff">
                            <div class="entry-img">
                                <img src="<?php echo base_url(); ?>upload/news/<?php echo $n->news_cover; ?>" height="200px" width="100%" alt="">
                            </div>
                            <h2 class="entry-title">
                                <a href="<?php echo site_url('page/artikel_detail/' . $n->news_category_id . '/' . $n->field_id . '/' . $n->news_slug); ?>"><?php echo substr($n->news_title, 0, 30) . "..."; ?></a>
                            </h2>
                            <div class="entry-meta" style="color:#777777;font-size:12px;">
                                <ul>
                                    <li class="d-flex align-items-center"> <i class="icofont-calendar"></i> <?php echo indonesiaDate($n->news_date); ?></li>
                                    <li class="d-flex align-items-center"> <i class="icofont-eye-alt"></i> <b><?php echo $n->news_count_view; ?>x dilihat</b></li>
                                </ul>
                            </div>
                            <div class="entry-content">
                                <div class="read-more" style="text-align-last:center">
                                    <a style="width:100%" href="<?php echo site_url('page/information_detail/' . $n->news_category_id . '/' . $n->field_id . '/' . $n->news_slug); ?>">Selengkapnya</a>
                                </div>
                            </div>

                        </article>
                    </div>
                <?php } ?>
            </div>
            <a class="float-right" href="<?php echo site_url('auth') ?>"><u>Artikel Lainnya -></u></a>
        </div>
    </section>
</main>