<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.png" />
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/vendor/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/vendor/navbar/bootstrap-4-navbar.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/vendor/animate/animate.css" media="all" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/vendor/fontawesome/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/vendor/owl-carousel/owl.carousel.css" media="all" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/vendor/magnific/magnific-popup.css" media="all" />
<!--<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/vendor/nice-select/nice-select.css" media="all" />-->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/vendor/js-offcanvas/css/js-offcanvas.css" media="all" />
<script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/modernizr/modernizr-custom.js"></script>
<?php wp_head();
// WP Session Management
$wpuserid = get_current_user_id();
if ( current_user_can('administrator') ) {
  // Nothing to do
  } else {
if (empty($_SESSION['user_id']) && empty($wpuserid)) {
  // echo 'S';
} else if(empty($_SESSION['user_id']) && !empty($wpuserid)){
  wp_logout();
  // echo 'A';
} else if(empty($wpuserid) && !empty($_SESSION['user_id'])){
  // echo 'U';
  @session_destroy();
} else {
  // echo 'R';
}
  }
  if(!empty($wpuserid)){
    $profile = bbp_get_user_profile_edit_url( $wpuserid );
    ?>
<script>
  jQuery(document).ready(function(){
    console.log('Saurabh');
    jQuery("body.members #buddypress").prepend('<div class="alert alert-success">Kindly complete your profile <a href="<?php echo $profile; ?>">here</a> to view complete details of other alumni members.</div>');
  });
</script>
    <?php
  }
// WP Session Management
?>
<link id="cbx-style" data-layout="1" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style-default.min.css" media="all" />
</head>
<body <?php body_class(); ?>>
<?php if($_GET['message']=='show'){ ?> <div class="outmsg">Logged out Successfully.</div><?php } ?>
<header id="header-area">
  <div class="preheader-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-sm-7">
          <div class="preheader-left"> 
          <?php dynamic_sidebar('topleft'); ?>
          </div>
        </div>
        <div class="col-lg-4 col-sm-5 text-right">
          <div class="preheader-right"> 
          <?php if($_SESSION['user_id']){ ?>
    <a title="Logout" style="background-color:#dc1313;" class="btn-auth btn-auth-rev" href="/logout.php">Logout</a>
<?php }else{ ?>
          <a title="Login" class="btn-auth btn-auth-rev" href="<?php echo get_home_URL(); ?>/alumni-login">Login</a> <a title="Register" class="btn-auth btn-auth" href="<?php echo get_permalink(1412); ?>">Signup</a>
          <?php }//dynamic_sidebar('topright'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="header-bottom-area" id="fixheader">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
        <nav class="main-menu navbar navbar-expand-lg navbar-light"> <a class="navbar-brand" href="<?php echo get_home_url(); ?>"> <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="logo"></a></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menucontent" aria-controls="menucontent" aria-expanded="false" aria-label="false"> <span  class="navbar-toggler-icon"></span> </button>
  <div class="collapse navbar-collapse" id="menucontent">
<?php wp_nav_menu(array( 'theme_location' => 'primary', 'menu_class' => 'navbar-nav ml-auto', 'container'=> false, 'fallback_cb' => 'topmenu', 'walker' =>  new My_Walker_Nav_Menu())); ?>
   <?php dynamic_sidebar('searchbox'); ?>
  </div>
</nav>
        </div>
      </div>
    </div>
  </div>
</header>