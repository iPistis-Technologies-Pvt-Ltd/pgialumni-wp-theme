<footer id="footer-area"> 
  <div class="footer-widget section-padding">
    <div class="container">
      <div class="row"> 
        <div class="col-lg-4 col-sm-6">
          <div class="single-widget-wrap">
            <div class="widgei-body">
              <div class="footer-about">
              <?php dynamic_sidebar('footerabout'); ?>    
            </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="single-widget-wrap">
            
          <?php dynamic_sidebar('footernavigation'); ?>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="single-widget-wrap">
          <?php dynamic_sidebar('footerusefullink'); ?>
          </div>
        </div>
        <div class="col-lg-2 col-sm-6">
          <div class="single-widget-wrap">
          <?php dynamic_sidebar('importantlinks'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="footer-bottom-text">
          <?php dynamic_sidebar('lastfooter'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<a href="#" class="scroll-top"> <i class="fa fa-angle-up"></i> </a>
<?php wp_footer(); ?> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/jquery/jquery-3.3.1.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/bootstrap/js/popper.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/bootstrap/js/bootstrap.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/navbar/bootstrap-4-navbar.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/owl-carousel/owl.carousel.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/waypoint/waypoints.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/counterup/jquery.counterup.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/isotope/isotope.pkgd.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/magnific/jquery.magnific-popup.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/smooth-scroll/jquery.smooth-scroll.min.js"></script> 
<!-- <script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/jquery-easing/jquery.easing.1.3.min.js"></script>  -->
<!--<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/nice-select/jquery.nice-select.js"></script>--> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/validation/jquery.validate.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/validation/additional-methods.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/js-offcanvas/js/js-offcanvas.pkgd.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/jquery.countdown/jquery.countdown.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/theme.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/custom.js"></script> 
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/select2.min.css" rel="stylesheet" />
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/select2.min.js"></script>
<script id="switcherhandle" src="<?php echo get_template_directory_uri(); ?>/assets/switcher/switcher.js"></script>
<?php if($_GET["specialization"]){ ?>
<script>
$(document).ready(function(){
    $("#dir-members-search").val("<?php echo $_GET["specialization"]; ?>");
    $("#dir-members-search-submit").click();
});
</script>
<?php } ?>
</body>
</html>