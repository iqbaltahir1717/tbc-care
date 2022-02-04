<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<title><?php echo $setting[0]->setting_appname;?></title>
		
		<meta name="title" content="<?php echo $setting[0]->setting_appname;?>">
		<meta name="description" content="<?php echo $setting[0]->setting_about;?>">
		<meta name="keywords" content="website, kendari, sultra, sulawesi tenggara, <?php echo $setting[0]->setting_appname;?>, <?php echo $setting[0]->setting_owner_name;?>">
		<meta name="robots" content="index, nofollow">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="author" content="<?php echo $setting[0]->setting_owner_name;?>">

		<!-- Favicons -->
		<link href="<?php echo base_url();?>assets/core-images/<?php echo $setting[0]->setting_logo;?>" rel="icon">
		<link href="<?php echo base_url();?>assets/core-images/<?php echo $setting[0]->setting_logo;?>" rel="apple-touch-icon">
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
		<!-- Vendor CSS Files -->
		<link href="<?php echo base_url()?>assets/core-front/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url()?>assets/core-front/vendor/icofont/icofont.min.css" rel="stylesheet">
		<link href="<?php echo base_url()?>assets/core-front/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
		<link href="<?php echo base_url()?>assets/core-front/vendor/animate.css/animate.min.css" rel="stylesheet">
		<link href="<?php echo base_url()?>assets/core-front/vendor/remixicon/remixicon.css" rel="stylesheet">
		<link href="<?php echo base_url()?>assets/core-front/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
		<link href="<?php echo base_url()?>assets/core-front/vendor/venobox/venobox.css" rel="stylesheet">
		<link href="<?php echo base_url()?>assets/core-front/vendor/aos/aos.css" rel="stylesheet">
		<link href="<?php echo base_url()?>assets/core-front/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

		<!-- Template Main CSS File -->
		<link href="<?php echo base_url()?>assets/core-front/css/style.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
		<style type="text/css">
            .fontRubik{
                font-family: 'Rubik', sans-serif;
            }

			.marquee {
				background-color: #e89a20;;
				color: #fff;
			}

            #map-canvas {
                width: 100%;
                height: 300px;
                border: solid;
            }
        </style>
	</head>