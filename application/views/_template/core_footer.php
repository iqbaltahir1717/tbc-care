           
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 0.0.1
                </div>
                <strong>Copyright &copy; 2021 <?php echo $setting[0]->setting_owner_name;?>.</strong> All rights reserved.
            </footer>
            
        </div>
       
        <script src="<?php echo base_url();?>assets/core-admin/core-component/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url();?>assets/core-admin/core-component/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>assets/core-admin/core-component/select2/dist/js/select2.full.min.js"></script>
        <script src="<?php echo base_url();?>assets/core-admin/core-component/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/core-admin/core-component/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/core-admin/core-plugin/timepicker/bootstrap-timepicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/core-admin/core-component/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="<?php echo base_url();?>assets/core-admin/core-plugin/iCheck/icheck.min.js"></script>
        <script src="<?php echo base_url();?>assets/core-admin/core-component/fastclick/lib/fastclick.js"></script>
        <script src="<?php echo base_url();?>assets/core-admin/core-dist/js/adminlte.min.js"></script>
        <script src="<?php echo base_url();?>assets/core-admin/core-dist/js/demo.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/core-thirdparty/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/core-thirdparty/ckfinder/ckfinder.js"></script>

        <script>
            $(document).ready(function () {
              $('.sidebar-menu').tree();
              $('.preloader').fadeOut();

              $("#rowpage").change(function(){
					var row = $("#rowpage").val();
					$.ajax({
						type      : "POST",
						url       : "<?php echo base_url(); ?>admin/setting/setRows",
						data      : {row: row},
						success   : function(msg){
							location.reload();
						}
					});
				});


                //Select2
                $('.select2').select2();

                //Date picker
                $('.datepicker').datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd'
                })

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass   : 'iradio_minimal-blue'
                });
                

                //Colorpicker
                $('.colorpicker').colorpicker();

                //Timepicker
                $('.timepicker').timepicker({
                    showInputs: true
                });

                // CKEDITOR
                CKEDITOR.replace('editor',{
                    toolbar : 'MyToolbar',
                    width:"100%",
                    filebrowserBrowseUrl : '<?php echo base_url();?>assets/core-thirdparty/ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl : '<?php echo base_url();?>assets/core-thirdparty/ckfinder/ckfinder.html?type=Images',
                    filebrowserFlashBrowseUrl : '<?php echo base_url();?>assets/core-thirdparty/ckfinder/ckfinder.html?type=Flash',
                });



            })
        </script>
    </body>
</html>