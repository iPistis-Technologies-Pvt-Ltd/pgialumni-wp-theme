<?php /* Template Name: Payment Status */
include('./alumniadmin/function/function.php');
?>
<?php get_header();
// print_r($_SESSION);
if (!empty($_SESSION['response'])) {
    // echo 'fine';
    $session_user = $_SESSION['response'];
} else {
    // echo 'error';
    // exit;
    redirect('/');
}
session_destroy();
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
<div class="bg-grey padding50">
    <div class="container clearfix">
        <div class="container">
            <div class="content-wrapper">
                <div class="card card-info">
                    <div class="card-body">
                        <h3 class="text-center" style="margin-top: 20px"><?php if ($_GET['status'] == 'success') { ?>Thank you for successful registration.<?php } else { ?>
                            Payment not successful.
                        <?php } ?></h3>
                        <div>
                            <?php
                            record_set("PaymentDetails", "select * from payment_details where id='" . $_GET['pid'] . "'");
                            $row_PaymentDetails = mysqli_fetch_assoc($PaymentDetails);
                            record_set("GetDetails", "select title, firstname, lastname from user_profile where user_id='" . $row_PaymentDetails['userid'] . "'");
                            $row_GetDetails = mysqli_fetch_assoc($GetDetails);
                            record_set("getuser", "select currency from user where id='" . $row_PaymentDetails['userid'] . "'");
                            $row_getuser = mysqli_fetch_assoc($getuser);
                            ?>
                            Dear <b><?php echo $row_GetDetails['title'] . ' ' . $row_GetDetails['firstname'] . ' ' . $row_GetDetails['lastname']; ?></b>,
                            <br><br>
                            <?php if ($_GET['status'] == 'success') { ?>
                                Your payment is successful and you have successfully registered at <?php echo $brand_name_caps; ?>.
                            <?php } else { ?>
                                Your Payment is not successful.
                            <?php } ?>
                            <table class="table table-bordered mt-4" width="100%">
                                <tbody>
                                    <tr>
                                        <th>Order ID</th>
                                        <td><?php echo $row_PaymentDetails['order_id']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tracking ID</th>
                                        <td><?php echo $row_PaymentDetails['tracking_id']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Bank Reference No.</th>
                                        <td><?php echo $row_PaymentDetails['bank_ref_no']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Order Status</th>
                                        <td><?php echo $row_PaymentDetails['order_status']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Mode</th>
                                        <td><?php echo $row_PaymentDetails['payment_mode']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Amount</th>
                                        <td><?php echo $row_getuser['currency'].' ' .$row_PaymentDetails['amount']; ?></td>
                                    </tr>

                                    <tr>
                                        <th>Transaction Date & Time</th>
                                        <td><?php echo date("d M Y, H:i:s A", strtotime($row_PaymentDetails['cdate'])); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Please login to proceed. Your username is <b><?php // echo $row_GetDetails['email']; 
                                                                                ?></b> and password is (password as per reg form).
                            <br> -->

                            <br>
                            Thank you
                            <br>
                            Team PGI Alumni<br><br>
                        </div>
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