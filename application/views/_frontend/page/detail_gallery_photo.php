

     
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">

            <ol>
                <li><a href="<?php echo site_url('home')?>">Home</a></li>
                <li><a href="#">Galeri</a></li>
                <li><a href="#">Foto</a></li>
            </ol>
            <h2>Foto : <?php echo $gallery_name[0]->gallery_name;?></h2>

        </div>
    </section>
    <main id="main">
       
        <section id="portfolio" class="portfoio">
            <div class="container" data-aos="fade-up">

                    <section id="blog" class="blog">
                        <div class="container" data-aos="fade-up">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h4>Deskripsi : </h4>
                                    <br><?php echo $gallery_name[0]->gallery_description;?>
                                    <hr style="border: 0.9px dashed #d2d6de">
                                    <div class="row portfolio-container">
                                    <?php 
                                        if($gallery){
                                            foreach($gallery as $g){ 
                                    ?>
                                        <div class="col-lg-3 portfolio-item ">
                                            <img src="<?php echo base_url();?>upload/gallery/photo/<?php echo $g->gallery_photo_name;?>" class="glightbox img-fluid " alt=""> 
                                        </div>
                                    <?php 
                                            }
                                        }else{ echo "Tidak Ada Gambar"; }
                                    ?>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="sidebar">
                                        <h3 class="sidebar-title">Galeri</h3>
                                        <hr style="border: 0.9px dashed #d2d6de">
                                        <div class="sidebar-item categories">
                                            <ul>
                                                <li><a href="<?php echo site_url('page/gallery/photo');?>">Foto</a></li>
                                                <li><a href="<?php echo site_url('page/gallery/video');?>">Video</a></li>
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