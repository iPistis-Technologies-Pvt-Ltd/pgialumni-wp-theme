<?php get_header();?>
<section id="slider-area">
  <div class="slider-active-wrap owl-carousel text-center text-md-left">
    <?php
  $slider_array = get_posts(
	array(
		'order' => 'ASC',
		'post_type' => 'home_slider',
		'numberposts' => '-1',
	)
  );
  	$i = 0;
	foreach ( $slider_array as $post ) : setup_postdata( $post );
	$i = $i + 1;
	if($i==1){
		$sliderclass='single-slide-wrap slide-bg-1';
	}
	else{
		$sliderclass='single-slide-wrap slide-bg-2';
	}
	?>
    <div style="background-image:url(<?php echo $url = get_the_post_thumbnail_url( $post->ID, 'full' ); ?>)" class="<?php echo $sliderclass; ?>">
      <div class="container">
        <div class="row">
          <div class="col-lg-9">
            <div class="slider-content">
              <?php the_content(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; wp_reset_postdata(); ?>
  </div>
  <!--<div class="social-networks-icon">
    <ul>
      <li><a href="#"><i class="fa fa-facebook"></i> <span>7.2k Likes</span></a></li>
      <li><a href="#"><i class="fa fa-linkedin"></i> <span>7.2k Likes</span></a></li>
      <li><a href="#"><i class="fa fa-google-plus"></i> <span>2.2k Subscribers</span></a></li>
    </ul>
  </div>-->
</section>
<section id="upcoming-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="upcoming-event-wrap">
          <div class="up-event-titile">
            <h3>Upcoming event</h3>
          </div>
          <div class="upcoming-event-content owl-carousel">
            <?php
$slider_array = get_posts(
	array(
		'order' => 'ASC',
		'post_type' => 'event_slider',
	)
);
	$i = 0;
	foreach ( $slider_array as $post ) : setup_postdata( $post );
	$i = $i + 1;
	if($i==1){
		$sliderclass='single-upcoming-event';
	}
	else{
		$sliderclass='single-upcoming-event';
	}
	?>
            <div class="<?php echo $sliderclass; ?>">
              <div class="row">
                <div class="col-lg-5">
                  <div class="up-event-thumb">
                    <?php the_post_thumbnail(); ?>
                    <h4 class="up-event-date">It’s 27 February 2019</h4>
                  </div>
                </div>
                <div class="col-lg-7">
                  <div class="display-table">
                    <div class="display-table-cell">
                      <div class="up-event-text">
                        <div class="event-countdown">
                          <div class="event-countdown-counter" data-date="2018/9/22"></div>
                          <p>Remaining</p>
                        </div>
                        <h3><a href="#">
                          <?php the_title(); ?>
                          </a></h3>
                        <p>
                          <?php the_content(); ?>
                        </p>
                        <a class="btn btn-brand btn-brand-dark" href="#">join with us</a> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; wp_reset_postdata(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="container clearfix">
  <?php if(have_posts()){ while(have_posts()){ the_post();
the_content();
}} ?>
</div>
<?php get_footer(); ?>