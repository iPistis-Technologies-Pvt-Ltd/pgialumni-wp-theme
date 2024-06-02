<?php get_header();
$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); ?>
<div class="banner" style="background-image:url(<?php echo $featured_img_url; ?>);">
<div class="banner-bg padding100">
    <div class="container">
      <h1 class="text-white">
        <?php echo the_title(); ?>
      </h1>
    </div>
    </div>
</div>
  <div class="container clearfix">
   <div class="row m-50">
   <div class="col-md-12">
  <div class="doctor_blog"> <?php if(have_posts()){ while(have_posts()){ the_post();
the_content();
}} ?>
<?php if (comments_open() || get_comments_number()){comments_template();}?>
</div>
</div>
</div>
  </div>
<?php get_footer(); ?>
