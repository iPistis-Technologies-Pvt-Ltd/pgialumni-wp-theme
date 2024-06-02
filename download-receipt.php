<?php /* Template Name: Download Receipt */ include('./alumniadmin/function/function.php');?>
<?php get_header();
if(is_user_logged_in()){
}else{
    $rurl = '/';
	redirect($rurl);
}
$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); ?>
<div class="banner" id="page-title-area" style="background-image:url(<?php echo $featured_img_url; ?>);">
  <div class="banner-bg">
    <div class="container">
      <div class="page-title-content text-center">
      <h1 class="text-white">
        <?php the_title(); ?>
      </h1>
    </div>
    </div>
  </div>
</div>
<div class="bg-grey padding50">
  <div class="container clearfix">
    <div class="content-wrapper">
        <div class="container">
            <div class="content-wrapper">
            <?php global $current_user;
            $email = $current_user->user_email;
            record_set('user', 'select id from user where email="' . $email . '"');
            if($totalRows_user>0){
                $row_user = mysqli_fetch_assoc($user);
                $rurl = '/alumniadmin/pdfs_doc/'.$row_user['id'].'.pdf';
                redirect($rurl);
            }else{
                echo 'Receipt is not generated.';
            }
            ?>
    </div>
  </div>
</div>
  </div>
  </div>
<?php get_footer(); ?>