<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $setting[0]->setting_appname; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="<?php echo base_url(); ?>assets/core-images/<?php echo $setting[0]->setting_logo; ?>">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core-admin/core-component/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core-admin/core-component/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core-admin/core-component/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core-admin/core-dist/css/AdminLTE.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" rel="stylesheet">
    <!-- Template Edited CSS File -->
    <link href="<?php echo base_url() ?>assets/core-front/css/edited/main.css" rel="stylesheet">
    <style type="text/css">
        .fontPoppins {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="hold-transition login-page fontPoppins" style="background-position: center; background-repeat: no-repeat; background-size: cover; background-image: url(<?php echo base_url(); ?>assets/core-images/<?php echo $setting[0]->setting_background; ?>)">
    <div class="login-box">

        <br><br>
        <div class="login-box-body">

            <p class="login-box-msg">Sign in to start your session</p>
            <p style="margin-bottom: 25px;">Silahkan masuk terlebih dahulu untuk melanjutkan</p>
            <?php
            if ($this->session->flashdata('alert')) {
                echo $this->session->flashdata('alert');
                unset($_SESSION['alert']);
            }
            ?>
            <!-- Start Form Login -->
            <?php echo form_open("auth/validate", "class='login-form'"); ?>
            <div class="form-group has-feedback">
                <?php echo csrf(); ?>
                <input type="text" class="form-control" placeholder="Username" name="username">
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password">
            </div>
            <!-- <hr style="border: 0.5px dashed #d2d6de"> -->
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" style="padding: 15px 20px !important;" class="bttn bttn-blue btn-block btn-flat"><b>Masuk</b></button>
                </div>
            </div>
            <?php echo form_close(); ?>
            <!-- End Form Login -->



            <hr style="border: 0.5px solid #ffff">
            <p style="font-size:16px ; ">
                <b><?php echo $setting[0]->setting_owner_name; ?></b>
                Since @<?php echo date('Y'); ?>
            </p>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/core-admin/core-component/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/core-admin/core-component/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>