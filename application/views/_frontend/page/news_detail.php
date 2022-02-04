

     
     <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="<?php echo site_url('home')?>">Home</a></li>
                <li><a href="#">Informasi</a></li>
                <li><a href="#"><?php echo $news_category_name[0]->news_category_name?></a></li>
            </ol>
            <h2><?php echo $news[0]->news_title;?></h2>

        </div>
    </section>
    <main id="main">
       
        <section id="services" class="services">
            <div class="container" data-aos="fade-up">
                <section id="blog" class="blog">
                    <div class="container" data-aos="fade-up">
                        <div class="row">
                            <div class="col-lg-8 entries">
                                <?php foreach($news as $n){ ?>
                                <article class="entry">
                                    <div class="entry-img">
                                        <img src="<?php echo base_url();?>upload/news/<?php echo $n->news_cover;?>" alt="" class="img-fluid">
                                    </div>

                                    <h2 class="entry-title">
                                        <a href=""><?php echo $n->news_title;?></a>
                                    </h2>

                                    <div class="entry-meta" style="color:#777777;font-size:12px;">
                                        <ul>
                                            
                                            <li class="d-flex align-items-center"> <i class="icofont-calendar"></i> <?php echo indonesiaDate($n->news_date)?> </li>
                                            <li class="d-flex align-items-center"> <i class="icofont-eye-alt"></i> <b><?php echo indonesiaDate($n->news_count_view)?>x dilihat</b></li>
                                            <li class="d-flex align-items-center"> <b class="badge badge-danger"><?php echo $news_category_name[0]->news_category_name;?></b> </li>
                                            <li class="d-flex align-items-center"> <b class="badge badge-success"><?php echo $n->field_name;?></b> </li>
                                        </ul>
                                    </div>

                                    <div class="entry-content">
                                        <p>
                                            <?php echo $n->news_text;?>
                                        </p>
                                        
                                    </div>
                                    <hr style="border: 0.9px dashed #d2d6de">
                                    <b>Share ke Social Media :</b>

                                    <!-- AddToAny BEGIN -->
                                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                        <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                                        <a class="a2a_button_facebook"></a>
                                        <a class="a2a_button_twitter"></a>
                                        <a class="a2a_button_whatsapp"></a>
                                        <a class="a2a_button_google_gmail"></a>
                                        <a class="a2a_button_copy_link"></a>
                                    </div>
                                    <script async src="https://static.addtoany.com/menu/page.js"></script>
                                    <!-- AddToAny END -->

                                </article>

                                <?php } ?>
                            </div>

                            <div class="col-lg-4">

                            <div class="sidebar">
                                    <h3 class="sidebar-title">Pencarian <?php echo $news_category_name[0]->news_category_name;?></h3>
                                    <hr style="border: 0.9px dashed #d2d6de">
                                    <div class="sidebar-item search-form">
                                        <?php echo form_open("page/information_search/".$this->uri->segment(3)."/".$this->uri->segment(4))?>
                                            <input type="text" name="key" placeholder="Cari Judul">
                                            <button type="submit">Cari</button>
                                        <?php echo form_close();?>
                                    </div>

                                    
                                    <h3 class="sidebar-title">Bidang Publikasi</h3>
                                    <hr style="border: 0.9px dashed #d2d6de">
                                    <div class="sidebar-item categories">
                                        <ul>
                                            <?php foreach($field as $f){?>
                                                <li><a href="<?php echo site_url('page/information/'.$this->uri->segment(3).'/'.$f->field_id);?>"><?php echo $f->field_name;?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>

                                    <h3 class="sidebar-title">Kategori</h3>
                                    <hr style="border: 0.9px dashed #d2d6de">
                                    <div class="sidebar-item categories">
                                        <ul>
                                            <?php foreach($news_category as $nc){?>
                                                <li><a href="<?php echo site_url('page/information/'.$nc->news_category_id.'/'.$this->uri->segment(4));?>"><?php echo $nc->news_category_name;?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    
                                    
                                    <h3 class="sidebar-title">Artikel Terbaru</h3>
                                    <hr style="border: 0.9px dashed #d2d6de">
                                    <div class="sidebar-item recent-posts">
                                        <?php foreach($recent as $r){ ?>
                                        <div class="post-item clearfix">
                                            <img src="<?php echo base_url();?>upload/news/<?php echo $r->news_cover?>" alt="">
                                            <h4><a href="<?php echo site_url('page/information_detail/'.$r->news_category_id.'/'.$r->field_id.'/'.$r->news_slug);?>"><?php echo $r->news_title;?></a></h4>
                                            <time style="color:gray"><i class="icofont-eye-alt"></i> <b><?php echo $r->news_count_view;?>x dilihat</b> &nbsp;&nbsp;<b class="badge badge-success"><?php echo $r->field_name;?></b></time>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </section>
            </div>
        </section>
    </main>