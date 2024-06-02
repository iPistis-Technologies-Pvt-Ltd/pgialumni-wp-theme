<?php /* Template Name: Alumni Dashboard bkp */
include('./alumniadmin/function/function.php'); ?>
<?php get_header();
if (empty($_SESSION['user_id'])) {
    redirect('/alumni-login');
}
$user_id = $_SESSION['user_id'];
// $user_id = 617;
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
            <div class="row">
                <div class="col-lg-8 col-sm-7 col-12">
                    <div class="card card-info">
                        <div class="card-body">
                            <?php
                            record_set("user_deatil", "SELECT user.*,user_profile.* FROM user JOIN user_profile ON user.id=user_profile.user_id and user.id='" . $user_id . "' ");
                            if ($totalRows_user_deatil > 0) {
                                $row_get_user = mysqli_fetch_assoc($user_deatil);
                            }
                            $title = get_title($row_get_user['title']);
                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Full Name</th>
                                            <td><?php echo $title . " " . $row_get_user['firstname'] . " " . $row_get_user['middlename'] . " " . $row_get_user['lastname']; ?></td>
                                            <th>Date of Birth</th>
                                            <td><?php echo date("d M Y", strtotime($row_get_user['dob'])); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <input type="hidden" id="umail" value="<?php echo $row_get_user['email']; ?>">
                                            <td><?php if ($row_get_user['email']) {
                                                    echo $row_get_user['email'];
                                                }  ?></td>
                                            <th>Mobile</th>
                                            <td><?php echo $row_get_user['ccode'];
                                                if ($row_get_user['number']) {
                                                    echo $row_get_user['number'];
                                                } else {
                                                    echo 'NA';
                                                } ?></td>
                                        </tr>
                                        <tr>
                                            <th>WhatsApp Contact Number</th>
                                            <td><?php if ($row_get_user['whatsapp']) {
                                                    echo $row_get_user['whatsapp'];
                                                } else {
                                                    echo 'NA';
                                                } ?></td>
                                            <th>Year of passing latest degree from PGIMER</th>
                                            <td><?php
                                                if ($row_get_user['degreeyear']) {
                                                    echo $row_get_user['degreeyear'];
                                                } else {
                                                    echo 'NA';
                                                } ?></td>
                                        <tr>
                                            <th>Year of joining PGIMER as faculty</th>
                                            <td><?php if ($row_get_user['facultyyear']) {
                                                    echo $row_get_user['facultyyear'];
                                                } else {
                                                    echo 'NA';
                                                } ?></td>
                                            <th>Country</th>
                                            <td><?php if ($row_get_user['country']) {
                                                    echo $row_get_user['country'];
                                                } else {
                                                    echo 'NA';
                                                } ?></td>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <th>Membership Type</th>
                                            <td colspan="3"><?php
                                                $wshopquery = 'select price,wshopid from wshop_booking where userid="' . $_SESSION['user_id'] . '" and payid IS NOT NULL';
                                                record_set('check_wshop', $wshopquery);
                                                while ($row_wshop = mysqli_fetch_assoc($check_wshop)) {
                                                    $charget += $row_wshop['price'];
                                                }

                                                if ($row_get_user['member'] == 2 &&  $charget) {
                                                    echo "Membership + Global PGI Alumni Summit";
                                                } else {
                                                    echo get_mtype($row_get_user['membership']);
                                                } ?></td>
                                        </tr>
                                        <tr>
                                            <th>Any degree completed from PGIMER</th>
                                            <td><?php
                                                record_set("degree", "SELECT name FROM degree WHERE id='" . $row_get_user['degree'] . "'");
                                                $datadegree = mysqli_fetch_assoc($degree);
                                                if ($datadegree['name']) {
                                                    echo $datadegree['name'];
                                                } else {
                                                    echo "NA";
                                                }
                                                ?></td>
                                            <th>Department you were related to at PGIMER</th>
                                            <td><?php
                                                record_set("department", "SELECT name FROM `departments` where id='" . $row_get_user['faculty'] . "'");
                                                $datadepartment = mysqli_fetch_assoc($department);
                                                if ($datadepartment['name']) {
                                                    echo $datadepartment['name'];
                                                } else {
                                                    echo "NA";
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <th>MemberID</th>
                                            <td><?php echo $row_get_user['MembershipId']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php

                                record_set('check_wshop', 'select userid from wshop_booking where payid IS NOT NULL AND userid="' . $_SESSION['user_id'] . '"');
                                $row_wshop = mysqli_fetch_assoc($check_wshop);
                                if (empty($row_wshop['userid'])) { ?>
                                    <a class="btn  btn-success btn-lg" data-dismiss="modal" data-toggle="modal" data-target="#exampleModal" data-backdrop="static" data-keyboard="false">Add Workshop</a>
                                <?php } ?>
                            </div><table class="table table-bordered">
                        <thead>
                            <tr>
                                <td colspan="5"><strong>Provisional Receipt</strong></td>
                            </tr>
                            <tr>
                                <td>Receipt ID</td>
                                <td>Date</td>
                                <td>Type</td>
                                <!-- <td>Accompanying</td> -->
                                <td>Fee</td>
                                <td>Options</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            record_set('get_payment', 'select id,tracking_id,cdate,order_id from payment_details where userid="' . $_SESSION['user_id'] . '" and order_status="Success" and cstatus=1');

                            record_set('reg_fee', "SELECT * FROM user where id=' " . $_SESSION['user_id'] . "'");
                            $reg_fee = mysqli_fetch_assoc($reg_fee);

                            record_set('reg_profile', "SELECT * FROM user_profile where user_id=' " . $_SESSION['user_id'] . "'");
                            $reg_profile = mysqli_fetch_assoc($reg_profile);
                            

                            $count = 1;
                            while ($row_get_payment = mysqli_fetch_assoc($get_payment)) {
                                $price = 0;
                                // record_set('get_ap_price', 'SELECT COUNT(id) as ap_count, SUM(price) as ap_total from ap_booking WHERE payid = "' . $row_get_payment["tracking_id"] . '" and userid=' . $_SESSION['user_id'] . " and cstatus=1");
                                // $row_get_ap_price = mysqli_fetch_assoc($get_ap_price);
                                // $price += $row_get_ap_price['ap_total'];



                                record_set('ws', 'SELECT * FROM wshop_booking WHERE userid="' . $_SESSION['user_id'] . '" and payid is not null');
                                $row_ws = mysqli_fetch_assoc($ws);
                              
                              
                                record_set('donation', 'SELECT * FROM donation WHERE userid="' . $_SESSION['user_id'] . '" and payid is not null');
                                $row_donation = mysqli_fetch_assoc($donation);



                                record_set('get_wshop', 'SELECT COUNT(id) as wshop_count, SUM(price) as wshop_total from wshop_booking WHERE payid = "' . $row_get_payment["tracking_id"] . '" and userid=' . $_SESSION['user_id'] . " and cstatus=1");
                                $row_get_wshop = mysqli_fetch_assoc($get_wshop);
                                $price += $row_get_wshop['wshop_total'];

                                if ($count == 1) {
                                    $charges += $price + $reg_fee['charge'] + $row_ws['price'] + $row_donation['amount'];
                                    $type = "Main";
                                } else {
                                    $charges = $price;
                                    $type = "Other";
                                }
                                
                            ?>
                                <tr>
                                    <td><?php echo $reg_profile['MembershipId'] . $row_get_payment['id']; ?></td>
                                    <td><?php echo date('d M Y', strtotime($row_get_payment['cdate'])); ?></td>
                                    <td><?php echo $type; ?></td>
                                    <!-- <td><?php //echo $row_get_ap_price['ap_count']; ?></td> -->
                                    <td>INR <?php echo $charges; ?></td>
                                    <td>
                                    <a target="_blank" href="/payment-receipt.php?tracking_id=<?php echo $row_get_payment["tracking_id"]; ?>">Check Receipt</a>
                                       
                                    </td>
                                </tr>
                            <?php $count++;
                            
                            }  ?>


                            
                        </tbody>
                    </table>
                        </div>
                    </div>





                    








                </div>
                <div class="col-lg-4 col-sm-5 col-12">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="user text-center">
                                <div class="">
                                    <img src="<?php echo get_home_URL(); ?>/img/user.png" alt="" height="150px">
                                </div>
                                <h6><strong>Registration ID:</strong> <span><?php echo $row_get_user['MembershipId']; ?></span></h6>
                                <h6><strong>Name:</strong> <span><?php echo  $row_get_user['firstname'] . " " . $row_get_user['lastname']; ?></span></h6>
                                <h6><strong>Mobile:</strong> <span><?php echo $row_get_user['number'] ?></span></h6>
                                <h6><strong>Email:</strong> <span><?php echo $row_get_user['email'] ?></span></h6>
                                <div><a class="btn btn-warning btn-lg" data-dismiss="modal" data-toggle="modal" data-target="#resetpassword" data-backdrop="static" data-keyboard="false">Reset Password</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Workshop</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="workshop" class="form-group"><input type="radio" id="workshop" name="mtype" onchange="membership_charge()" value="2"> Global PGI Alumni Summit</label>
                            <div style="margin-top:20px;display: none;" class="alert alert-info" id="charge_display"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-lg" id="add_workshop">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="resetpassword" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="display: block;">
                            <h5 class="modal-title">Change Password?
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            </h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="oldpassword">Old Password <span>*</span></label>
                                <input type="password" name="oldpassword" id="oldpassword" class="form-control" value="" placeholder="&nbsp;">
                            </div>
                            <div class="form-group"><label for="newpassword">New Password <span>*</span></label>
                                <input type="password" name="newpassword" id="newpassword" class="form-control" value="" placeholder="&nbsp;">
                                <span id="pmsg"></span>
                            </div>
                            <div class="form-group"><label for="conformpassword">Conform Password <span>*</span></label>
                                <input type="password" name="conformpassword" id="conformpassword" class="form-control" value="" placeholder="&nbsp;">
                                <span id="vmsg"></span>
                            </div>
                            <br>
                            <div class="text-right">
                                <button name="change_password" id="change_password" class="btn btn-warning btn-lg">Submit</button>
                            </div>
                            <div id="popupmsg"></div>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#newpassword').on('keyup', function() {
            if ($('#newpassword').val().length < 6) {
                $('#pmsg').html('Password must be 6 digits').css('color', 'red');
                $("#change_password").prop('disabled', true);
                return false;
            } else {
                $('#pmsg').html('').css('color', 'green');
                $("#change_password").prop('disabled', false);
            }
        });
        $('#conformpassword').on('keyup', function() {
            if ($('#newpassword').val() == $('#conformpassword').val()) {
                $('#vmsg').html('').css('color', 'green');
                $("#change_password").prop('disabled', false);
            } else {
                $('#vmsg').html('Please Enter Correct Password').css('color', 'red');
                $("#change_password").prop('disabled', true);
                return false;
            }
        });
    });
    $("#change_password").on('click', function() {
        var oldpassword = $("#oldpassword").val();
        if (oldpassword == '') {
            document.getElementById("oldpassword").style.borderColor = "#ff0000";
            document.getElementById("oldpassword").focus();
            return false;
        } else {
            document.getElementById("oldpassword").style.borderColor = "#ced4da";
        }
        var newpassword = $("#newpassword").val();
        if (newpassword == '') {
            document.getElementById("newpassword").style.borderColor = "#ff0000";
            document.getElementById("newpassword").focus();
            flag = 0;
            return false;
        } else {
            document.getElementById("newpassword").style.borderColor = "#ced4da";
        }
        var conformpassword = $("#conformpassword").val();
        if (conformpassword == '') {
            document.getElementById("conformpassword").style.borderColor = "#ff0000";
            document.getElementById("conformpassword").focus();
            flag = 0;
            return false;
        } else {
            document.getElementById("conformpassword").style.borderColor = "#ced4da";
        }
        var oldpassword = $("#oldpassword").val();
        var newpassword = $("#newpassword").val();
        var conformpassword = $("#conformpassword").val();
        var email = $("#umail").val();
        var form_data = new FormData();
        form_data.append("action", 'reset_password');
        form_data.append("oldpassword", oldpassword);
        form_data.append("newpassword", newpassword);
        form_data.append("conformpassword", conformpassword);
        form_data.append("email", email);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '<?php echo get_home_URL(); ?>/ajax_common.php',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {
                if (result.status == 0) {
                    $("#popupmsg").html(result.msg);
                } else {
                    $("#popupmsg").html(result.msg);
                    setTimeout(function() {
                        $('#resetpassword').modal('hide');
                    }, 3000);
                    $("#oldpassword, #newpassword, #conformpassword").val('');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                alert("error" + xhr.responseText);
                console.log(xhr.responseText);
            }
        });
    });




    $("#add_workshop").on('click', function(event) {
        if (!$("input[name='mtype']:checked").val()) {
            alert('Select membership type.');
            return false;
        } else {
            var membership = $('input[name="mtype"]:checked').val();
        }
        var userid = "<?php echo $_SESSION['user_id'] ?>";
        <?php if ($row_get_user['country'] == 'India') { ?>
            var charge = 5000;
        <?php } else { ?>
            var charge = 250;
        <?php } ?>
        var form_data = new FormData();
        form_data.append("action", 'add_workshop');
        form_data.append("charge", charge);
        form_data.append("membership", membership);
        form_data.append("user_id", userid);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '<?php echo get_home_URL(); ?>/ajax_common.php',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                if (response.msg == 's') {
                    window.location.href = "/payments";
                } else if (response.msg == 'notf') {
                    alert("Try Again.");
                }

            }
        });
    });
</script>