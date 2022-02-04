<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<title><?php echo $setting[0]->setting_appname;?></title>
		<meta content="" name="description">
		<meta content="" name="keywords">
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
		<!-- Template Main CSS File -->
		<link href="<?php echo base_url()?>assets/core-front/css/style.css" rel="stylesheet">
	</head>
	<body style="background-size: cover; background-image: url(<?php echo base_url();?>assets/core-images/bg-tes.png)">
	
		<main id="main" style="margin-top:100px">
			<center>
				<img src="<?php echo base_url();?>assets/core-images/<?php echo $setting[0]->setting_logo;?>" height="100"><br>
				<h1 class="title"><?php echo $setting[0]->setting_owner_name;?></h1>
			</center>
			<section id="icon-boxes" class="icon-boxes" style="margin-top:5%">
				<div class="container">
					<center>
					<div class="row">
						<div class="col-lg-1  aos-init aos-animate" data-aos="fade-up"></div>
						<div class="col-lg-2  aos-init aos-animate" data-aos="fade-up">
							<a href="<?php echo site_url('page/layanan')?>">
								<img class="animate__animated animate__fadeInDown" src="<?php echo base_url();?>assets/core-front/img/icon/syarat-rounded.png" height="170">
								<h4 class="title animate__animated animate__fadeInDown" >Syarat</h4>
							</a>
						</div>
						<div class="col-lg-2  aos-init aos-animate" data-aos="fade-up">
							<a href="<?php echo site_url('page/tracking')?>">
								<img class="animate__animated animate__fadeInDown" src="<?php echo base_url();?>assets/core-front/img/icon/tracking-rounded.png" height="170">
								<h4 class="title animate__animated animate__fadeInDown" >Tracking</h4>
							</a>
						</div>
						<div class="col-lg-2  aos-init aos-animate" data-aos="fade-up">
							<a href="<?php echo site_url('page/regulasi')?>">
								<img class="animate__animated animate__fadeInDown" src="<?php echo base_url();?>assets/core-front/img/icon/regulasi-rounded.png" height="170">
								<h4 class="title animate__animated animate__fadeInDown" >Regulasi</h4>
							</a>
						</div>
						<div class="col-lg-2  aos-init aos-animate" data-aos="fade-up">
							<a href="<?php echo site_url('page/link_terkait')?>">
								<img class="animate__animated animate__fadeInDown" src="<?php echo base_url();?>assets/core-front/img/icon/link-rounded.png" height="170">
								<h4 class="title animate__animated animate__fadeInDown" >Link Terkait</h4>
							</a>
						</div>
						<div class="col-lg-2  aos-init aos-animate" data-aos="fade-up">
							<a href="<?php echo site_url('home')?>">
								<img class="animate__animated animate__fadeInDown" src="<?php echo base_url();?>assets/core-front/img/icon/website-rounded.png" height="170">
								<h4 class="title animate__animated animate__fadeInDown" >Website</h4>
							</a>
						</div>
						<div class="col-lg-1  aos-init aos-animate" data-aos="fade-up"></div>
					</div>
					</center>
				</div>
			</section>
		</main>



		<div id="preloader"></div>
		<!-- Vendor JS Files -->
		<script src="<?php echo base_url()?>assets/core-front/vendor/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url()?>assets/core-front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo base_url()?>assets/core-front/vendor/jquery.easing/jquery.easing.min.js"></script>
		<script src="<?php echo base_url()?>assets/core-front/vendor/php-email-form/validate.js"></script>
		<script src="<?php echo base_url()?>assets/core-front/vendor/owl.carousel/owl.carousel.min.js"></script>
		<script src="<?php echo base_url()?>assets/core-front/vendor/venobox/venobox.min.js"></script>
		<script src="<?php echo base_url()?>assets/core-front/vendor/isotope-layout/isotope.pkgd.min.js"></script>
		<script src="<?php echo base_url()?>assets/core-front/vendor/aos/aos.js"></script>
		<!-- Template Main JS File -->
		<script src="<?php echo base_url()?>assets/core-front/js/main.js"></script>
		<script language="JavaScript" type="text/javascript">
				$(document).ready(function(){
					$('.carousel').carousel({
						interval: 5000
					})
				});    
		</script>
	</body>
</html>

