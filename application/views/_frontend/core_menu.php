    <body class="fontRubik">    
        <header id="header" class="fixed-top ">
            <div class="container d-flex align-items-center">

            <h5 class="logo mr-auto" style="color:white;font-size:20px"><a href="<?php echo base_url();?>" class="scrollto"><img src="<?php echo base_url()?>assets/core-images/<?php echo $setting[0]->setting_logo;?>"> <?php echo $setting[0]->setting_appname;?></a> </h5>
            

            <nav class="nav-menu d-none d-lg-block">
                <ul>
                    <li class="active"><a href="<?php echo base_url();?>">Home</a></li>
                    <li class="drop-down"><a href="#">Profil</a>
                        <ul>
                            <li><a href="<?php echo site_url('profil/sejarah')?>">Sejarah</a></li>
                            <li><a href="<?php echo site_url('profil/visi_misi')?>">Visi Misi</a></li>
                            <li><a href="<?php echo site_url('profil/sambutan')?>">Kata Sambutan</a></li>
                            <li><a href="<?php echo site_url('profil/tugas_pokok_fungsi')?>">Tugas Pokok & Fungsi</a></li>
                            <li><a href="<?php echo site_url('profil/maklumat_pelayanan')?>">Maklumat Pelayanan</a></li>
                            <li><a href="<?php echo site_url('profil/struktur_organisasi')?>">Struktur Organisasi</a></li>
                        </ul>
                    </li>
                    <li class="drop-down"><a href="#">Informasi</a>
                        <ul>
                            <?php foreach($news_category as $nc){ ?>
                            <li><a href="<?php echo site_url('page/information/'.$nc->news_category_id.'/1')?>"><?php echo $nc->news_category_name;?></a></li>
                            <?php }?>
                        </ul>
                    </li>
                    <li class="drop-down"><a href="#">Produk Hukum</a>
                        <ul>
                            <?php foreach($regulation_category as $rc){ ?>
                            <li><a href="<?php echo site_url('page/regulation/'.$rc->regulation_category_id)?>"><?php echo $rc->regulation_category_name;?></a></li>
                            <?php }?>
                        </ul>
                    </li>
                    <li class="drop-down"><a href="#">Galeri</a>
                        <ul>
                            <li><a href="<?php echo site_url('page/gallery/photo')?>">Foto</a></li>
                            <li><a href="<?php echo site_url('page/gallery/video')?>">Video</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo site_url('page/contact')?>">Kontak</a></li>
                </ul>
            </nav><!-- .nav-menu -->

            </div>
        </header><!-- End Header -->