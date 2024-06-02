<?php /* Template Name: Payment */
include('./alumniadmin/function/function.php');
// include_once("./alumniadmin/function/function.php");
?>
<?php get_header();
// $_SESSION['user_id'] = 78;
// print_r($_SESSION);
if(empty($_SESSION['user_id'])){
    redirect('/');
}
$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
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
<?php
$query = 'select membership, charge, currency, email, number, member from user where id="' . $_SESSION['user_id'] . '"';
record_set('check_user', $query);
$row_id = mysqli_fetch_assoc($check_user);
$profile = 'select firstname, middlename, lastname, country from user_profile where user_id="' . $_SESSION['user_id'] . '"';
record_set('check_profile', $profile);
$row_profile = mysqli_fetch_assoc($check_profile);
$wshopquery = 'select price,wshopid,payid from wshop_booking where userid="' . $_SESSION['user_id'] . '" and payid is null';
record_set('check_wshop', $wshopquery);
while($row_wshop = mysqli_fetch_assoc($check_wshop)){
    $charget+=$row_wshop['price'];  
}
$donationquery = 'select amount from donation where userid="' . $_SESSION['user_id'] . '" and payid is null';
record_set('check_donation', $donationquery);
while($row_donation = mysqli_fetch_assoc($check_donation)){
    $charged+=$row_donation['amount'];  
}


$apquery = 'select price from ap_booking where userid="' . $_SESSION['user_id'] . '" and payid is null';
record_set('check_ap', $apquery);
while($row_ap = mysqli_fetch_assoc($check_ap)){
    $chargeap+=$row_ap['price'];  
}
$amount = $row_id['charge'] + $charget;

record_set('payment', "SELECT amount FROM `payment_details` where userid='".$_SESSION['user_id']."' and order_status='Success'");
while($howmuchpay = mysqli_fetch_assoc($payment)){
    $payamount+=$howmuchpay['amount'];
    $amount=$amount-$payamount;
}
$payamount = $amount + $charged + $chargeap;
?>
<div class="bg-grey padding50">
    <div class="container clearfix">
        <div class="container">
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <div class="card card-info">
                    <div class="card-header">
                        <h5 class="card-title">Payment Details</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">                            
                            <tbody>
                                <tr>
                                    <th>Type of membership:</th>
                                    <td><span> <?php                          
                                    
                                    if($row_id['membership']==2){
                                        echo "Global PGI Alumni Summit";
                                    }else{
                                        echo get_mtype($row_id['membership']);
                                    }
                                    ?></span></td>
                                </tr>
                                <?php if($amount > 0){ ?>
                                <tr>
                                    <th>Registration Fee:</th>
                                    <td><?php echo $row_id['currency']; ?><span> <?php echo format_amount($amount, 2); ?></span></td>
                                </tr>
                                <?php } if($charged > 0){ ?>
                                <tr>
                                    <th>Donation:</th>
                                    <td><?php echo $row_id['currency']; ?><span> <?php echo format_amount($charged, 2); ?></span></td>
                                </tr>
                                <?php } ?><?php if($chargeap > 0){ ?>
                                <tr>
                                    <th><?php echo $totalRows_check_ap; ?> Accompanying Charge:</th>
                                    <td><?php echo $row_id['currency']; ?><span> <?php echo format_amount($chargeap, 2); ?></span></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <th>Status:</th>
                                    <td><strong>Pending</strong>, Click on Pay Now</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <?php
                                        $gatewayurl = '/payment/ccavRequestHandler.php';
                                        $redirect_url = '/payment/ccavResponseHandler.php';
                                        ?>
                                        <form method="POST" name="customerData" action="<?php echo $gatewayurl; ?>">
                                            <input type="hidden" name="tid" id="tid" readonly />
                                            <input type="hidden" name="order_id" value="<?php echo rand(10000, 99999999); ?>" />
                                            <input type="hidden" id="pamt" name="amount" value="<?php echo $payamount; ?>" />
                                            <input type="hidden" name="reg_charge" id="reg_charge" value="<?php echo $payamount; ?>" />
                                            <input type="hidden" name="merchant_id" value="3349101" />
                                            <input type="hidden" name="currency" value="<?php echo $row_id['currency']; ?>" />
                                            <input type="hidden" name="redirect_url" value="<?php echo get_home_url().$redirect_url; ?>" />
                                            <input type="hidden" name="cancel_url" value="<?php echo get_home_url().$redirect_url; ?>" />
                                            <input type="hidden" name="language" value="EN" />
                                            <input type="hidden" name="billing_name" value="<?php echo clean( $row_profile['firstname'].' '.$row_profile['middlename'].' '.$row_profile['lastname']); ?>" />
                                            <input type="hidden" name="billing_address" value="<?php echo clean($_SESSION['address']); ?>" />
                                            <input type="hidden" name="billing_city" value="<?php echo clean($_SESSION['city']); ?>" />
                                            <input type="hidden" name="billing_state" value="<?php echo clean($_SESSION['state']); ?>" />
                                            <input type="hidden" name="billing_zip" value="<?php echo $_SESSION['zip']; ?>" />
                                            <input type="hidden" name="billing_country" value="<?php echo $row_profile['country']; ?>" />
                                            <input type="hidden" name="billing_tel" value="<?php echo $row_id['number']; ?>" />
                                            <input type="hidden" name="billing_email" value="<?php echo $row_id['email']; ?>" />
                                            <input type="hidden" name="merchant_param1" value="<?php echo $_SESSION['user_id']; ?>" />
                                            <button type="submit" id="pay_now_btn" class="btn btn-warning btn-lg" name="pay_now">Pay Now</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
<script>
</script>