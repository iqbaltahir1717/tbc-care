        <footer id="footer">
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 footer-info">
                            <h3>Tentang Aplikasi</h3>
                            <p><?php echo $setting[0]->setting_about; ?></p>
                            <div class="social-links mt-3">
                                <a href="<?php echo $setting[0]->setting_facebook; ?>" class="facebook"><i class="bx bxl-facebook"></i></a>
                                <a href="<?php echo $setting[0]->setting_instagram; ?>" class="instagram"><i class="bx bxl-instagram"></i></a>
                                <a href="<?php echo $setting[0]->setting_youtube; ?>" class="youtube"><i class="bx bxl-youtube"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 footer-links">

                        </div>
                        <div class="col-lg-3 col-md-6 footer-contact">
                            <h4>Kontak Kami</h4>
                            <p>
                                <?php echo $setting[0]->setting_address; ?> <br>
                                <?php echo $setting[0]->setting_phone; ?><br>
                                <?php echo $setting[0]->setting_email; ?><br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="copyright">
                    &copy; Copyright <strong><span><?php echo $setting[0]->setting_owner_name; ?></span></strong>. All Rights Reserved
                </div>
            </div>
        </footer><!-- End Footer -->

        <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>
        <div id="preloader"></div>

        <!-- Vendor JS Files -->
        <script src="<?php echo base_url() ?>assets/core-front/vendor/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>assets/core-front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url() ?>assets/core-front/vendor/jquery.easing/jquery.easing.min.js"></script>
        <script src="<?php echo base_url() ?>assets/core-front/vendor/php-email-form/validate.js"></script>
        <script src="<?php echo base_url() ?>assets/core-front/vendor/owl.carousel/owl.carousel.min.js"></script>
        <script src="<?php echo base_url() ?>assets/core-front/vendor/venobox/venobox.min.js"></script>
        <script src="<?php echo base_url() ?>assets/core-front/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="<?php echo base_url() ?>assets/core-front/vendor/aos/aos.js"></script>
        <script src="<?php echo base_url() ?>assets/core-front/vendor/glightbox/js/glightbox.min.js"></script>
        <!-- Template Main JS File -->
        <script src="<?php echo base_url() ?>assets/core-front/js/main.js"></script>
        <script language="JavaScript" type="text/javascript">
            $(document).ready(function() {
                $('.carousel').carousel({
                    interval: 5000
                })
            });
        </script>

        <script>
            var lightbox = GLightbox();
            lightbox.on('open', (target) => {
                console.log('lightbox opened');
            });
            var lightboxDescription = GLightbox({
                selector: '.glightbox2'
            });
            var lightboxVideo = GLightbox({
                selector: '.glightbox3'
            });
            lightboxVideo.on('slide_changed', ({
                prev,
                current
            }) => {
                console.log('Prev slide', prev);
                console.log('Current slide', current);

                const {
                    slideIndex,
                    slideNode,
                    slideConfig,
                    player
                } = current;

                if (player) {
                    if (!player.ready) {
                        // If player is not ready
                        player.on('ready', (event) => {
                            // Do something when video is ready
                        });
                    }

                    player.on('play', (event) => {
                        console.log('Started play');
                    });

                    player.on('volumechange', (event) => {
                        console.log('Volume change');
                    });

                    player.on('ended', (event) => {
                        console.log('Video ended');
                    });
                }
            });

            var lightboxInlineIframe = GLightbox({
                selector: '.glightbox4'
            });
        </script>
        </body>

        </html>