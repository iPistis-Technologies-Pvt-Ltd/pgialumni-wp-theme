<?php include('./alumniadmin/function/function.php'); ?>
<?php get_header();
global $current_user;
$uid = $current_user->ID;
$email = $current_user->user_email;
if ( metadata_exists( 'user', $uid, 'memid' ) ) {
}else{
  record_set('user', 'select id from user where email="' . $email . '"');
  if($totalRows_user>0){
    $row_user = mysqli_fetch_assoc($user);
    record_set('memid', 'select MembershipId from user_profile where user_id="' . $row_user['id'] . '"');
    if($totalRows_memid>0){
      $row_memid = mysqli_fetch_assoc($memid);
      add_user_meta( $uid, 'memid', $row_memid['MembershipId']);
    }
  }
}

$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); ?>

<div class="banner" id="page-title-area" style="background-image:url(<?php echo $featured_img_url; ?>);">

  <div class="banner-bg">

    <div class="container">

      <div class="page-title-content text-center">

      <h1 class="text-white">

        <span id="pcid"><?php echo get_user_meta($uid, 'memid', true); ?> - </span> <?php the_title(); ?>

      </h1>

</div>

    </div>

  </div>

</div>

<div class="bg-grey padding50">

  <div class="container clearfix">

    <?php if(have_posts()){ while(have_posts()){ the_post();

the_content();

}} ?>

  </div>

  </div>

<?php get_footer(); ?>

