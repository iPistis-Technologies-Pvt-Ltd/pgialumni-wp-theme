<?php /*

Template Name: Contact-us

*/?>
<?php get_header();  ?>

<div class="content">
  <div class="container">
    <div class="bwhite">
      <div class="page-head">
        <div class="h">
          <?php the_title(); ?>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="incontent">
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <?php 
			if ( have_posts() ) {
					while ( have_posts() ) {
					the_post(); ?>
					
					<?php the_content(); ?> 
  <?php 
				} 
			} 
?>
            </div>
          </div>
          <div class="col-md-4">
            <div class="sidebar">
              <div class="detail">
                <?php dynamic_sidebar( 'contact-info' );?>
              </div>
              <div class="social">
                <?php dynamic_sidebar( 'footer-1' );?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer();  ?>
