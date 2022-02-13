    <body class="<?php echo $setting[0]->setting_layout; ?> sidebar-mini <?php echo $setting[0]->setting_color; ?> fontPoppins">
        <div class="preloader">
            <div class="loading text-center">
                <img src="<?php echo base_url(); ?>assets/core-images/load.gif" width="50">
                <br>
                <p><b class="fontPoppins">Harap Tunggu</b></p>
            </div>
        </div>
        <div class="wrapper">
            <header class="main-header">
                <a href="<?php echo site_url('admin/dashboard') ?>" class="logo">
                    <span class="logo-mini"><b><?php echo $setting[0]->setting_short_appname; ?></b></span>
                    <span class="logo-lg"><b><?php echo $setting[0]->setting_short_appname; ?></b></span>
                </a>

                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php
                                    if ($this->session->userdata('user_photo') == "") {
                                        echo '<img src="' . base_url() . 'upload/user/noimage.png" class="user-image" alt="User Image">';
                                    } else {
                                        echo '<img src="' . base_url() . 'upload/user/' . $this->session->userdata('user_photo') . '" class="user-image" alt="User Image">';
                                    }
                                    ?>
                                    <span class="hidden-xs"><?php echo $this->session->userdata('user_name'); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <?php
                                        if ($this->session->userdata('user_photo') == "") {
                                            echo '<img src="' . base_url() . 'upload/user/noimage.png" class="img-circle" alt="User Image">';
                                        } else {
                                            echo '<img src="' . base_url() . 'upload/user/' . $this->session->userdata('user_photo') . '" class="img-circle" alt="User Image">';
                                        }
                                        ?>
                                        <p>
                                            <?php echo $this->session->userdata('user_fullname'); ?>
                                            <small>Member since<br><?php echo $this->session->userdata('user_createtime'); ?></small>
                                        </p>
                                    </li>

                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo site_url('admin/profile') ?>" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo site_url('auth/logout') ?>" class="btn btn-google btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <?php if ($this->session->userdata('user_group') == 1) { ?>
                                <li>
                                    <a href="<?php echo site_url('admin/setting'); ?>" title="Pengaturan Aplikasi"><i class="fa fa-gears"></i></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </nav>
            </header>

            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <?php
                            if ($this->session->userdata('user_photo') == "") {
                                echo '<img src="' . base_url() . 'upload/user/noimage.png" class="img-circle" alt="User Image">';
                            } else {
                                echo '<img src="' . base_url() . 'upload/user/' . $this->session->userdata('user_photo') . '" class="img-circle" alt="User Image">';
                            }
                            ?>
                        </div>
                        <div class="pull-left info">
                            <?php
                            if (strlen($this->session->userdata('user_fullname')) > 15) {
                                echo '<p>' . substr($this->session->userdata('user_fullname'), 0, 15) . '..</p>';
                            } else {
                                echo '<p>' . $this->session->userdata('user_fullname') . '</p>';
                            }
                            ?>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>

                        </div>
                    </div>

                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>

                    <?php if ($this->session->userdata('user_group') == 1) { ?>
                        <!-- Administrator Menu -->
                        <ul class="sidebar-menu" data-widget="tree">
                            <li class="header">Main Menu</li>
                            <li class="active"><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                            <li><a href="<?php echo site_url('admin/pasien') ?>"><i class="fa fa-user"></i> <span>List Pasien</span></a></li>
                            <li><a href="<?php echo site_url('admin/makanan') ?>"><i class="fa fa-circle"></i> <span>List Makanan</span></a></li>
                            <li><a href="<?php echo site_url('admin/slider') ?>"><i class="fa fa-gears"></i> <span>Manajemen Output</span></a></li>
                            <li class="header">Pengaturan Sistem</li>
                            <li class="treeview">
                                <a href="#"> <i class="fa fa-list"></i> <span>Profil Sistem</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo site_url('admin/content/page/sambutan'); ?>"><i class="fa fa-circle-o"></i> Kata Sambutan</a></li>
                                    <li><a href="<?php echo site_url('admin/slider') ?>"><i class="fa fa-file-image-o"></i> <span>Slider Informasi</span></a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#"> <i class="fa fa-newspaper-o"></i> <span>Manajemen Artikel</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo site_url('admin/news') ?>"><i class="fa fa-circle-o"></i> List Artikel</a></li>
                                    <li><a href="<?php echo site_url('admin/news_category') ?>"><i class="fa fa-circle-o"></i> Kategori Artikel</a></li>
                                    <li><a href="<?php echo site_url('admin/field') ?>"><i class="fa fa-circle-o"></i> Tag</a></li>
                                </ul>
                            </li>

                            <li><a href="<?php echo site_url('admin/faq'); ?>"><i class="fa fa-database"></i> <span>F.A.Q</span></a></li>
                            <li><a href="<?php echo site_url('admin/group'); ?>"><i class="fa fa-database"></i> <span>Group</span></a></li>
                            <li><a href="<?php echo site_url('admin/user'); ?>"><i class="fa fa-database"></i> <span>User</span></a></li>
                            <li><a href="<?php echo site_url('admin/log'); ?>"><i class="fa fa-circle-o text-red"></i> <span>Sistem Log</span></a></li>
                            <li><a href="<?php echo site_url('admin/slider') ?>"><i class="fa fa-newspaper-o"></i> <span>Tentang Aplikasi</span></a></li>
                        </ul>
                    <?php } elseif ($this->session->userdata('user_group') == 2) { ?>

                        <!-- Inputer Menu -->
                        <ul class="sidebar-menu" data-widget="tree">
                            <li class="header">Main Menu</li>
                            <li class="active"><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                            <li><a href="<?php echo site_url('admin/slider') ?>"><i class="fa fa-file-image-o"></i> <span>Detail Riwayat Pasien</span></a></li>
                            <li><a href="<?php echo site_url('admin/slider') ?>"><i class="fa fa-newspaper-o"></i> <span>Tentang Aplikasi</span></a></li>
                        </ul>

                    <?php } ?>
                </section>
            </aside>