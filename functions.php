<?php
add_theme_support('post-thumbnails');
add_theme_support('menus');
add_post_type_support( 'page', 'excerpt' );
add_theme_support( 'custom-logo' );
add_action('after_setup_theme', 'woocommerce_support');
add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');
//add_action('wp_logout','auto_redirect_after_logout');




add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
function logout_without_confirm($action, $result)
{
    /**
     * Allow logout without confirmation
     */
    if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : get_permalink(750).'?message=show';
        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
        header("Location: $location");
        die;
    }
}



// Remove admin bar except Administrators
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}



// Add Woocommerce Support to theme
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
// add tag support to pages
function tags_support_all() {
	register_taxonomy_for_object_type('post_tag', 'page');
}
add_action('init', 'tags_support_all');
// ensure all tags are included in queries
function tags_support_query($wp_query) {
	if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}
add_action('pre_get_posts', 'tags_support_query');
register_nav_menus(array(
'primary' => __( 'Primary Menu','iptmenu' )
));
register_nav_menus(array(
'footermenu' => __( 'Footer Menu','iptmenu' )
));
// Walker Menu Configuration
class My_Walker_Nav_Menu extends Walker_Nav_Menu {
    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ){
      $GLOBALS['dd_children'] = ( isset($children_elements[$element->ID]) )? 1:0;
      $GLOBALS['dd_depth'] = (int) $depth;
      parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
   //function start_lvl(&$output, $depth) {
    function start_lvl( &$output, $depth = 0, $args = array() ){
     $indent = str_repeat("\t", $depth);
     $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
   }
  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){
    global $wp_query, $wpdb;
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    $li_attributes = '';
    $class_names = $value = '';
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    //Add class and attribute to LI element that contains a submenu UL.
    if (isset($args->has_children)){
      $classes[]    = 'dropdown';
      $li_attributes .= 'data-dropdown="dropdown"';
    }
    $classes[] = 'dropdown nav-item menu-item-' . $item->ID;
	$classes[] = 'dropdown-item';
	//If we are on the current page, add the active class to that menu item.
    $classes[] = ($item->current) ? 'active' : '';
    //Make sure you still add all of the WordPress classes.
    $class_names = join( ' ', apply_filters( 'nav_menu_css_class',     array_filter( $classes ), $item, $args ) );
    $class_names = ' class="' . esc_attr( $class_names ) . '"';
    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
    $has_children = $wpdb->get_var(
    $wpdb->prepare("
       SELECT COUNT(*) FROM $wpdb->postmeta
       WHERE meta_key = %s
       AND meta_value = %d
       ", '_menu_item_menu_item_parent', $item->ID)
     );
   //$output .= $indent . '<li' . $id . $value . $class_names .'>';
   $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';
   //Add attributes to link element.
   $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
   $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target     ) .'"' : '';
   $attributes .= ! empty( $item->xfn ) ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
   $attributes .= ! empty( $item->url ) ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
   // Check if menu item is in main menu
if ( $depth == 0 && $has_children > 0  ) {
    // These lines adds your custom class and attribute
    $attributes .= ' class="dropdown-toggle nav-link"';
    $attributes .= ' data-toggle="dropdown"';
}
   $item_output = $args->before;
   $item_output .= '<a class="nav-link"'. $attributes .'>';
   $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
   // Add the caret if menu level is 0
   if ( $depth == 0 && $has_children > 0  ) {
      $item_output .= ' <b class="dropdown-toggle"></b>';
   }
   $item_output .= '</a>';
   $item_output .= $args->after;
   $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
}
//Create Sliders
add_action( 'init', 'create_post_slider' );
function create_post_slider() {
  register_post_type( 'home_slider',
    array(
      'labels' => array(
        'name' => __( 'Slider' ),
        'singular_name' => __( 'Slider' )
      ),
      'public' => true,
      'has_archive' => true,
	  'rewrite' => array('slug' => 'slider'),
	  'menu_icon'           => 'dashicons-images-alt2',
	  'supports' => array( 'title', 'editor','thumbnail', 'custom-fields', 'page_template', 'excerpt' )
    )
  );
}
//Event Slider
add_action( 'init', 'create_event_slider' );
function create_event_slider() {
  register_post_type( 'event_slider',
    array(
      'labels' => array(
        'name' => __( 'Event Slider' ),
        'singular_name' => __( 'Event Slider' )
      ),
      'public' => true,
      'has_archive' => true,
	  'rewrite' => array('slug' => 'event slider'),
	  'menu_icon'           => 'dashicons-images-alt2',
	  'supports' => array( 'title', 'editor','thumbnail', 'custom-fields', 'page_template', 'excerpt' )
    )
  );
}
register_sidebar(array(
	'name' => 'Top Left',
	'id' => 'topleft',
	'description' => 'Appears in Right Sidebar',
	'before_widget' => '<div id="%1$s" class="leftbar widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<div class="headerbg">',
	'after_title' => '</div>',
));
register_sidebar(array(
	'name' => 'Top Right',
	'id' => 'topright',
	'description' => 'Appears in Right Sidebar',
	'before_widget' => '<div id="%1$s" class="leftbar widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<div class="headerbg">',
	'after_title' => '</div>',
));
register_sidebar(array(
	'name' => 'Footer About',
	'id' => 'footerabout',
	'description' => 'Appears in Footer About',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
));
register_sidebar(array(
	'name' => 'Footer Navigation',
	'id' => 'footernavigation',
	'description' => 'Appears in Footer Navigation',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
));
register_sidebar(array(
	'name' => 'Footer Useful Link',
	'id' => 'footerusefullink',
	'description' => 'Appears in Footer Useful Link',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
));
register_sidebar(array(
	'name' => 'Important Links',
	'id' => 'importantlinks',
	'description' => 'Appears in Important Links',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
));
register_sidebar(array(
	'name' => 'Last Footer',
	'id' => 'lastfooter',
	'description' => 'Appears in Last Footer',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
));

// Meta title generator
function custom_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() )
		return $title;
	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
		// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentythirteen' ), max( $paged, $page ) );
	return $title;
}
add_filter( 'wp_title', 'custom_wp_title', 10, 2 );
add_filter( 'wp_image_editors', 'change_graphic_lib' );
function change_graphic_lib($array) {
  return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}

//Alumni
add_action( 'init', 'create_alumni' );
function create_alumni() {
  register_post_type( 'alumni',
    array(
      'labels' => array(
        'name' => esc_html('Alumni'),
        'singular_name' => esc_html('Alumni')
      ),
      'public' => true,
      'has_archive' => true,
	  'rewrite' => array('slug' => 'alumni'),
	  'menu_icon'           => 'dashicons-admin-users',
	  'supports' => array( 'title', 'editor','thumbnail', 'page_template', 'excerpt' )
    )
  );
}

//Post
function blog_post($atts) {
  $a = shortcode_atts( array(
      'count' => '2',
  ), $atts );
  $count = esc_attr($a['count']);
  global $post;
  $post = array(
    array(
      'order' => 'ASC',
      'post_type' => 'post',
      'numberposts' => $count,
    )
  );
  $posts = get_posts( $post );
  ?>
  <div class="row">
  <?php
  foreach ( $posts as $post ) : setup_postdata( $post );
  ?>
  <div class="col-lg-4 col-md-6">
        <article class="single-blog-post">
          <figure class="blog-thumb">
            <div class="blog-thumbnail"> <?php the_post_thumbnail(); ?> </div>
            <figcaption class="blog-meta clearfix"> <a href="#" class="author">
              <div class="author-pic">	
<?php echo get_avatar( $post ); ?></div>
              <div class="author-info">
                <h5><?php echo get_the_author(); ?></h5>
                <p><?php echo get_the_date(); ?></p>
              </div>
              </a>
            </figcaption>
          </figure>
          <div class="blog-content">
            <h3><a href="#"><?php the_title(); ?></a></h3>
            <p><?php the_excerpt(); ?></p>
            <a href="<?php the_permalink(); ?>" class="btn btn-brand">Read More</a> </div>
        </article>
      </div>
  <?php
  endforeach; wp_reset_postdata();
  ?>
  </div>
  <?php
   }
   add_shortcode('get_post', 'blog_post');
   
   
function alumni($atts) {
  $a = shortcode_atts( array(
      'count' => '3',
  ), $atts );
  $count = esc_attr($a['count']);
  global $post;
  $get_alumni = get_posts(
  array(
    'order' => 'ASC',
    'post_type' => 'alumni',
    'numberposts' => $count,
  )
  );?>
<div class="row">
  <?php
          foreach ( $get_alumni as $post ) : setup_postdata( $post ); ?>
          <div class="col-lg-4 col-sm-6 text-center">
          <div class="single-job-opportunity">
            <div class="job-opportunity-text">
              <div class="job-oppor-logo">
                <div class="display-table">
                  <div class="display-table-cell"> <?php the_post_thumbnail(); ?> </div>
                </div>
              </div><br />
              <p><?php the_excerpt(); ?></p>
            </div>
            <a href="<?php the_permalink(); ?>" class="btn btn-job">View Detail</a>
        </div>
        </div>
      <?php endforeach;  wp_reset_postdata(); ?>
</div>
  <?php
   }
  add_shortcode('get_alumni', 'alumni');
  
  
function login_redirect( $redirect_to, $request, $user ){
    if(!is_admin()){
    return home_url('forums');
    }
}
add_filter( 'login_redirect', 'login_redirect', 10, 3 );


// Stop redirecting to wp login on wrong credential
add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login
function my_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( $referrer . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
      exit;
   }
}





