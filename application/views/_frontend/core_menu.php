    <body class="fontRubik">
        <header id="header" class="fixed-top ">
            <div class="container d-flex align-items-center">

                <h5 class="logo mr-auto" style="color:white;font-size:20px"><a href="<?php echo base_url(); ?>" class="scrollto"><img src="<?php echo base_url() ?>assets/core-images/<?php echo $setting[0]->setting_logo; ?>"> <?php echo $setting[0]->setting_appname; ?></a> </h5>


                <nav class="nav-menu d-none d-lg-block">
                    <ul>
                        <li class="active"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li><a href="<?php echo site_url('page/contact') ?>">Tentan Aplikasi</a></li>
                        <li><a href="<?php echo site_url('auth') ?>">Login</a></li>
                    </ul>
                </nav><!-- .nav-menu -->

            </div>
        </header><!-- End Header -->