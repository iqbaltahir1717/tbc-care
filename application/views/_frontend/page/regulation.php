

    
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="<?php echo site_url('home')?>">Home</a></li>
                <li><a href="#">Produk Hukum</a></li>
                <li><a href="#"><?php echo $regulation_category_name[0]->regulation_category_name;?></a></li>
            </ol>
            <h2><?php echo $regulation_category_name[0]->regulation_category_name;?></h2>
        </div>
    </section>
    <main id="main">
       
        <section id="services" class="blog">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="sidebar-item search-form">
                            <?php echo form_open("page/regulation_search/".$this->uri->segment(3), "class='form-inline'")?>
                                <input type="text" class="form-control" style="width:50%" placeholder="Cari Nama Produk Hukum" name="key">
                                <button class ="btn  btn-danger" type="submit">Cari Produk Hukum : <?php echo $regulation_category_name[0]->regulation_category_name;?></button>
                            <?php echo form_close();?>
                        </div>
                        <br>
                        <?php 
                            if($this->uri->segment(2)=="regulation_search"){
                                echo "Kata Kunci Pencarian : <span class='badge badge-danger font-weight-lighter mr-2'>".$search."</span><hr style='border: 0.5px dashed #d2d6de'>";
                            }
                        ?> 
                        <br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk Hukum</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if($regulation){
                                    $no=1; foreach($regulation as $r){ ?>
                                <tr>
                                    <td><?php echo $no+$numbers;?></td>
                                    <td><?php echo $r->regulation_name;?></td>
                                    <td><a class="badge badge-success" href="<?php echo base_url()?>upload/regulation/<?php echo $r->regulation_file;?>" target="_blank">Download File</a></td>
                                </tr>
                                <?php $no++;} }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4">
                        <div class="sidebar">
                            <h3 class="sidebar-title">Kategori Produk Hukum</h3>
                            <hr style="border: 0.9px dashed #d2d6de">
                            <div class="sidebar-item categories">
                                <ul>
                                    <?php foreach($regulation_category as $rc){?>
                                        <li><a href="<?php echo site_url('page/regulation/'.$rc->regulation_category_id);?>"><?php echo $rc->regulation_category_name;?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>

                            
                            <h3 class="sidebar-title">Berita Terbaru</h3>
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
                <hr>
                <div class="blog-pagination"><?php echo $links;?></div>
            </div>
        </section>
    </main><!-- End #main -->