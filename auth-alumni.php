<?php /* Template Name: Alumni Verification */ include('./alumniadmin/function/function.php');?>
<?php get_header();
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
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php
if(!empty($_GET['token'])){
	record_set('get_user','select id from user where auth_code="'.$_GET['token'].'"');
	$row_user=mysqli_fetch_assoc($get_user);
	$MembershipId='PCAAS'.str_pad($row_user['id'], 4, "0", STR_PAD_LEFT);
	$update_membership=array(
	'MembershipId'=>$MembershipId
	);
		$a = dbRowUpdate('user_profile', $update_membership, ' where user_id="' . $row_user['id'] . '"');

	$update_data = array(
		'status' => 1,
		
	);
	
	$a = dbRowUpdate('user', $update_data, ' where auth_code="' . $_GET['token'] . '"');
	
	
	
	
	
	
	if($a){ ?>
		<div class="text-center"><h1>Your account is approved.</h1>
		<a title="Login" class="btn-auth btn-auth-rev" href="<?php echo get_home_URL(); ?>/log-in">Login</a></div>
        <?php
	}else{ ?>
    <div class="text-center"><h1>Some error accured, please try again.</h1></div>
        <?php } } ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>