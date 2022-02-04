<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?php echo $setting[0]->setting_appname;?></title>
        <link rel="icon" href="<?php echo base_url();?>assets/core-images/<?php echo $setting[0]->setting_logo;?>" >
        <link rel="stylesheet" href="<?php echo base_url();?>assets/core-admin/core-component/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/core-admin/core-component/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/core-admin/core-component/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/core-admin/core-component/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/core-admin/core-component/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/core-admin/core-component/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/core-admin/core-plugin/iCheck/all.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/core-thirdparty/dropzone/dist/dropzone.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/core-thirdparty/dropzone/dist/basic.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/core-admin/core-plugin/timepicker/bootstrap-timepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/core-admin/core-dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/core-admin/core-dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link href="https://fonts.googleapis.com/css?family=Anton|Permanent+Marker|Quicksand" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" rel="stylesheet"> 
        <style type="text/css">
            .fontQuicksand{
                font-family: 'Quicksand', sans-serif;
            }

            .fontPoppins{
                font-family: 'Poppins', sans-serif;
            }

            .preloader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 9999;
                background-color: #fff;
            }

            .preloader .loading {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%,-50%);
                font: 14px arial;
            }

            .dropzone {
                border: 2px dashed #0087F7;
            }
        </style>
        
    </head>

