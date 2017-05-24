                </div>
        <!-- /page content -->
        
        <div
            class="modal fade bs-example-modal-lg confirm-modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true"
            style="z-index: 11264;"
        >
            <div class="vertical-alignment-helper">
                <div class="modal-dialog vertical-align-center">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Confirm</h4>
                        </div>
                        <div class="modal-body confirm-conten text-center"></div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary accept-confirm">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if($_SESSION['admin_user']) {
        ?>
        <!-- footer content -->
        <footer>
            test
        </footer>
        <!-- /footer content -->
        <?php
        }
        ?>
            </div>
        </div>
    </body>
<!--</main>-->
    
    <?=Init::getScript("jquery.min.js", "assets/vendors/jquery/dist/")?>
    <?=Init::getScript("bootstrap.min.js", "assets/vendors/bootstrap/dist/js/")?>
    <?=Init::getScript("fastclick.js", "assets/vendors/fastclick/lib/")?>
    <?=Init::getScript("nprogress.js", "assets/vendors/nprogress/")?>
    <?=Init::getScript("gauge.min.js", "assets/vendors/gauge.js/dist/")?>
    <?=Init::getScript("bootstrap-progressbar.min.js", "assets/vendors/bootstrap-progressbar/")?>
    <?=Init::getScript("skycons.js", "assets/vendors/skycons/")?>
    <?=Init::getScript("jquery.flot.js", "assets/vendors/Flot/")?>
    <?=Init::getScript("jquery.flot.pie.js", "assets/vendors/Flot/")?>
    <?=Init::getScript("jquery.flot.time.js", "assets/vendors/Flot/")?>
    <?=Init::getScript("jquery.flot.stack.js", "assets/vendors/Flot/")?>
    <?=Init::getScript("jquery.flot.resize.js", "assets/vendors/Flot/")?>
    <?=Init::getScript("jquery.flot.orderBars.js", "assets/vendors/flot.orderbars/js/")?>
    <?=Init::getScript("jquery.flot.spline.min.js", "assets/vendors/flot-spline/js/")?>
    <?=Init::getScript("curvedLines.js", "assets/vendors/flot.curvedlines/")?>
    

<!-- iCheck -->
    <?=Init::getScript("icheck.min.js", "assets/vendors/iCheck/")?>
<!-- Datatables -->
    <?=Init::getScript("jquery.dataTables.min.js", "assets/vendors/datatables.net/js/")?>
    <?=Init::getScript("dataTables.bootstrap.min.js", "assets/vendors/datatables.net-bs/js/")?>
    <?=Init::getScript("dataTables.buttons.min.js", "assets/vendors/datatables.net-buttons/js/")?>
    <?=Init::getScript("buttons.bootstrap.min.js", "assets/vendors/datatables.net-buttons-bs/js/")?>
    
<!--    <script src="<?=$APP_CONF['base_url']?>assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?=$APP_CONF['base_url']?>assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?=$APP_CONF['base_url']?>assets/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>-->
    <!--<script src="<?=$APP_CONF['base_url']?>assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>-->
    <!--<script src="<?=$APP_CONF['base_url']?>assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>-->
    <!--<script src="<?=$APP_CONF['base_url']?>assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>-->
    <!--<script src="<?=$APP_CONF['base_url']?>assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>-->
    <!--<script src="<?=$APP_CONF['base_url']?>assets/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>-->
    <!--<script src="<?=$APP_CONF['base_url']?>assets/vendors/jszip/dist/jszip.min.js"></script>-->
    <!--<script src="<?=$APP_CONF['base_url']?>assets/vendors/pdfmake/build/pdfmake.min.js"></script>-->
    <!--<script src="<?=$APP_CONF['base_url']?>assets/vendors/pdfmake/build/vfs_fonts.js"></script>-->
    
    <!--<script src="<?=$APP_CONF['base_url']?>build/js/custom.min.js"></script>-->
    
    
    <!-- Bootstrap Colorpicker -->
    <?=Init::getScript("bootstrap-colorpicker.min.js", "assets/vendors/mjolnic-bootstrap-colorpicker/dist/js/")?>
    <!-- jquery.inputmask -->
    <?=Init::getScript("jquery.inputmask.bundle.min.js", "assets/vendors/jquery.inputmask/dist/min/")?>
    <!-- bootstrap-daterangepicker -->
    <?=Init::getScript("moment.min.js", "assets/vendors/moment/min/")?>
    <?=Init::getScript("daterangepicker.js", "assets/vendors/bootstrap-daterangepicker/")?>
    <!-- Switchery -->
    <?=Init::getScript("switchery.min.js", "assets/vendors/switchery/dist/")?>
    
    <!-- PNotify -->
    <?=Init::getScript("pnotify.js", "assets/vendors/pnotify/dist/")?>
    <?=Init::getScript("pnotify.buttons.js", "assets/vendors/pnotify/dist/")?>
    <?=Init::getScript("pnotify.nonblock.js", "assets/vendors/pnotify/dist/")?>
    
    <!--fileupload-dropzone-->
    <?=Init::getScript("dropzone.min.js", "assets/vendors/dropzone/dist/min/")?>
    
    <!-- bootstrap-wysiwyg -->
    <?=Init::getScript("bootstrap3-wysihtml5.all.js", "assets/vendors/bootstrap3-wysihtml5-bower/dist/")?>
    
    <?=Init::getScript("scope.js")?>
    <?=Init::getScript("custom.js")?>
    <?=Init::getScript("Admin.js")?>
    <?=Init::getScript("{$strPage}.js")?>
    
</html>