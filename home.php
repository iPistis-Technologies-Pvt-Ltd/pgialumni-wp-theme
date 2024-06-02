<?php get_header();
$page_for_posts = get_option( 'page_for_posts' );
$featured_img_url = get_the_post_thumbnail_url($page_for_posts,'full'); ?>
<div class="banner" style="background-image:url(<?php echo $featured_img_url; ?>);">
  <div class="banner-bg padding100">
    <div class="container">
    <h1 class="text-white">
        <?php echo get_the_title($page_for_posts); ?>
      </h1>
    </div>
  </div>
</div>
  <div class="container mb-60 ">
    <div class="row">
    
      <div class="col-md-12 mt-20">
	  <?php if(have_posts()){ while(have_posts()){ the_post();
	 global $post;
	 //print_r($post);
	 ?>
        <div class="doctor_blog"> <?php the_post_thumbnail(); ?>
          <h5><?php the_title(); ?>
              <?php echo $post->ID; ?></h5>
              <p><?php the_excerpt(); ?></p>
              <a class="btn btn-info" href="<?php the_permalink(); ?>">Read more</a>
              
           </div>
		  <?php  }} ?>
      </div>
     
    </div>
  </div>
<?php get_footer(); ?>