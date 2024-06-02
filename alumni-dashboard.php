<?php /* Template Name: Alumni Dashboard */
include('./alumniadmin/function/function.php'); ?>
<?php get_header();
if (empty($_SESSION['user_id'])) {
    redirect('/alumni-login');
}
$user_id = $_SESSION['user_id'];
// $user_id = 617;
$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
record_set("user_deatil", "SELECT user.*,user_profile.* FROM user JOIN user_profile ON user.id=user_profile.user_id and user.id='" . $user_id . "' ");
if ($totalRows_user_deatil > 0) {
    $row_get_user = mysqli_fetch_assoc($user_deatil);
}
$title = get_title($row_get_user['title']);

// Code for WP Login 
$user = get_user_by('email', $row_get_user['email']);
if (!$user) {
} else {
 $creds = array(
    'user_login'    => $user->user_login, // Use the user's login from the retrieved user object
    'user_password' => $row_get_user['password'],
    'remember'      => true
);
$user_signon = wp_signon($creds, false);   
}
// Code for WP Login 
?>
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
                                            <td><?php
                                                if ($row_get_user['number']) {
                                                    echo $row_get_user['ccode'] . $row_get_user['number'];
                                                } else {
                                                    echo 'NA';
                                                } ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">WhatsApp Contact Number</th>
                                            <td colspan="2"><?php if ($row_get_user['whatsapp']) {
                                                                echo $row_get_user['wacode'] . $row_get_user['whatsapp'];
                                                            } else {
                                                                echo 'NA';
                                                            } ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Year of passing latest degree from PGIMER</th>
                                            <td colspan="2"><?php
                                                            if ($row_get_user['degreeyear']) {
                                                                echo $row_get_user['degreeyear'];
                                                            } else {
                                                                echo 'NA';
                                                            } ?></td>
                                        <tr>
                                            <th colspan="2">Year of joining PGIMER as faculty</th>
                                            <td colspan="2"><?php if ($row_get_user['facultyyear']) {
                                                                echo $row_get_user['facultyyear'];
                                                            } else {
                                                                echo 'NA';
                                                            } ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Country</th>
                                            <td colspan="2"><?php if ($row_get_user['country']) {
                                                                echo $row_get_user['country'];
                                                            } else {
                                                                echo 'NA';
                                                            } ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Membership Type</th>
                                            <td colspan="2"><?php
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
                                            <th colspan="2">Any degree completed from PGIMER</th>
                                            <td colspan="2"><?php
                                                            record_set("degree", "SELECT name FROM degree WHERE id='" . $row_get_user['degree'] . "'");
                                                            $datadegree = mysqli_fetch_assoc($degree);
                                                            if ($datadegree['name']) {
                                                                echo $datadegree['name'];
                                                            } else {
                                                                echo "NA";
                                                            }
                                                            ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Department you were related to at PGIMER</th>
                                            <td colspan="2"><?php
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
                                            <th colspan="2">MemberID</th>
                                            <td colspan="2"><?php echo $row_get_user['MembershipId']; ?></td>
                                        </tr>
                                        <?php $roomquery = 'select * from room_booking where userid="' . $_SESSION['user_id'] . '" and cstatus=1';
                                        record_set('check_room', $roomquery);
                                        if ($totalRows_check_room > 0) {
                                            $row_roombooking = mysqli_fetch_assoc($check_room);
                                            $roomcharge = $row_roombooking['price'];
                                            $hquery = 'select name from hotels where id="' . $row_roombooking['hotel'] . '"';
                                            record_set('check_hotel', $hquery);
                                            if ($totalRows_check_hotel > 0) {
                                                $row_hotel = mysqli_fetch_assoc($check_hotel);
                                            }
                                            $rquery = 'select name from room_type where id="' . $row_roombooking['room_type'] . '"';
                                            record_set('check_room', $rquery);
                                            if ($totalRows_check_room > 0) {
                                                $row_room = mysqli_fetch_assoc($check_room);
                                            }
                                        ?>
                                            <tr>
                                                <th colspan="2">Accomodation</th>
                                                <td colspan="2"><?php echo $row_hotel['name']; ?>, <?php echo $row_room['name']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        record_set("apname", "SELECT name FROM `ap_booking` WHERE userid=" . $_SESSION['user_id'] . " and cstatus=1"); ?>
                                        <?php if ($totalRows_apname > 0) {
                                        ?>
                                            <tr>
                                                <td colspan="2">
                                                    <b>Accompanying Person</b>
                                                </td>
                                                <td colspan="2">
                                                    <?php while ($row_apname = mysqli_fetch_assoc($apname)) {
                                                        echo $row_apname['name'] . '<br>';
                                                    } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php
                                record_set('check_wshop', 'select userid from wshop_booking where payid IS NOT NULL AND userid="' . $_SESSION['user_id'] . '"');
                                $row_wshop = mysqli_fetch_assoc($check_wshop);
                                if (empty($row_wshop['userid'])) { ?>
                                    <center>
                                        <a class="btn  btn-warning btn-lg" data-dismiss="modal" data-toggle="modal" data-target="#wshopmodal" data-backdrop="static" data-keyboard="false">JOIN PGI ALUMNI SUMMIT</a><br><br>
                                    </center>
                                <?php } ?>
                                <a style="display: none;" href="#" class="btn btn-warning mr-2 addap btnp btn-lg" data-toggle="modal" data-target="#aperson">Add Accompanying Person</a>
                            </div>
                            <table class="table table-bordered">
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
                                        record_set('get_ap_price', 'SELECT COUNT(id) as ap_count, SUM(price) as ap_total from ap_booking WHERE payid = "' . $row_get_payment["tracking_id"] . '" and userid=' . $_SESSION['user_id'] . " and cstatus=1");
                                        $row_get_ap_price = mysqli_fetch_assoc($get_ap_price);
                                        $price += $row_get_ap_price['ap_total'];
                                        record_set('ws', 'SELECT * FROM wshop_booking WHERE userid="' . $_SESSION['user_id'] . '" and payid="' . $row_get_payment['tracking_id'] . '"');
                                        $row_ws = mysqli_fetch_assoc($ws);
                                        record_set('donation', 'SELECT * FROM donation WHERE userid="' . $_SESSION['user_id'] . '" and payid="' . $row_get_payment['tracking_id'] . '"');
                                        $row_donation = mysqli_fetch_assoc($donation);
                                        record_set('get_wshop', 'SELECT COUNT(id) as wshop_count, SUM(price) as wshop_total from wshop_booking WHERE payid = "' . $row_get_payment["tracking_id"] . '" and userid=' . $_SESSION['user_id'] . " and cstatus=1");
                                        $row_get_wshop = mysqli_fetch_assoc($get_wshop);
                                        $price += $row_get_wshop['wshop_total'];

                                        $roomamount = 'select * from room_booking where userid="' . $_SESSION['user_id'] . '" and cstatus=1';
                                        record_set('check_roomamount', $roomamount);
                                        if ($totalRows_check_roomamount > 0) {
                                            $row_roomamount = mysqli_fetch_assoc($check_room);
                                            $roomchargeamount = $row_roomamount['price'];
                                        }
                                        if ($count == 1) {
                                            $charges = $price + $reg_fee['charge'] + $row_donation['amount'] + $roomchargeamount;

                                            $type = "Main";
                                        } else {
                                            $charges = $price + $row_donation['amount'] + $roomchargeamount;
                                            $type = "Other";
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $reg_profile['MembershipId'] . $row_get_payment['id']; ?></td>
                                            <td><?php echo date('d M Y', strtotime($row_get_payment['cdate'])); ?></td>
                                            <td><?php echo $type; ?></td>
                                            <!-- <td><?php //echo $row_get_ap_price['ap_count']; 
                                                        ?></td> -->
                                            <td><?php echo $row_get_user['currency'] . ' ' . $charges; ?></td>
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
                    <br>
                    <div class="card card-info">
                        <div class="card-body">
                            <?php if ($row_get_user['currency'] == 'INR') { ?>
                                <div class="alert alert-info">
                                    <div class="form-group" id="inrcont" style="display: block;">
                                        <p style="margin-bottom: 0px;"><b>Please support the PGI Alumni Society well-being through meaningful and valuable contributions</b></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="donate" id="inr5000" value="5000">
                                            <label class="form-check-label" for="inr5000">INR <?php echo format_amount(5000, 2); ?></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="donate" id="inr10000" value="10000">
                                            <label class="form-check-label" for="inr10000">INR <?php echo format_amount(10000, 2); ?></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="donate" id="inr50000" value="50000">
                                            <label class="form-check-label" for="inr50000">INR <?php echo format_amount(50000, 2); ?></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="donate" id="inrlakh" value="100000">
                                            <label class="form-check-label" for="inrlakh">INR <?php echo format_amount(100000, 2); ?></label>
                                        </div><br>
                                        <button id="donatedash" class="btn btn-info btn-lg">Submit</button>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="alert alert-success">
                                <p>PGI OFFERS DISCOUNTED OR FREE TREATMENT TO FINANCIALLY CHALLENGED PATIENTS THROUGH THE “POOR PATIENTS FUND” THAT IS FUNDED BY DONORS LIKE YOU. </p>
                                <p>ANY AMOUNT WOULD CONTRIBUTE TO A LIFE SAVING MEANS FOR THESE DESTITUDE PATIENTS.</p>
                                <a href="https://pgimer.edu.in/PGIMER_PORTAL/PGIMERPORTAL/GlobalPages/JSP/Page_Data.jsp?dep_id=5676" target="_blank" rel="noopener noreferrer"> PLEASE CLICK HERE TO DONATE</a>.
                            </div>
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
                                <h6><strong>Mobile:</strong> <span><?php echo $row_get_user['ccode'] . $row_get_user['number'] ?></span></h6>
                                <h6><strong>Email:</strong> <span><?php echo $row_get_user['email'] ?></span></h6>
                                <div>
                                    <!-- New button for Accomodations jty -->
                                    <a class="btn btn-primary btn-lg" href="https://pgialumni.org/hotels-accommodations/">Click Here For Accomodations</a>
                                    <a class="btn btn-warning btn-lg" data-dismiss="modal" data-toggle="modal" data-target="#resetpassword" data-backdrop="static" data-keyboard="false">Reset Password</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="wshopmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<div id="aperson" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Accompanying Person</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="panel-group" id="accordion">
                    <form action="" method="POST" id="ap_form">
                        <div id="apbox">
                            <?php
                            record_set("count_ap", "SELECT id FROM `ap_booking` WHERE userid=" . $_SESSION['user_id'] . " and cstatus=1"); ?>
                            <input name="apcharge" type="hidden" id="apcharge" value="<?php echo $row_get_user['apcharge']; ?>">
                            <?php if ($row_get_user['ap_transid'] > 0) {
                            } else { ?>
                                <p>"Kindly enter details of Accompanying person (if any) <?php echo $row_get_user['aperson']; ?></p>
                                <input type="range" id="aper" min="0" max="<?php echo (3 - $totalRows_count_ap) ?>" step="1" value="0" onChange="apersont()">
                            <?php } ?>
                        </div>
                        <br>
                        <p id="ap_text"></p>
                    </form>
                    <a class="btn btn-warning btn-block btn-lg" value="Login" id="ap_submit" name="Login">Submit</a>
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
        $('#donatedash').click(function() {
            if (!$("input[name='donate']").is(':checked')) {
                alert('Please Select donation amount.');
                return;
            } else {
                var donate = $("input[type='radio'][name='donate']:checked").val();
            }
            var uid = '<?php echo $_SESSION['user_id']; ?>';
            var currency = '<?php echo $row_get_user['currency']; ?>';
            var form_data = new FormData();
            form_data.append("action", 'donatedashboard');
            form_data.append("donate", donate);
            form_data.append("uid", uid);
            form_data.append("currency", currency);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo get_home_URL(); ?>/ajax_common.php',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.dfile == 'notallowed') {
                        alert('Only pdf, jpg, JPEG, png file allowed.');
                    } else if (response.data == 1) {
                        window.location.href = "/payments";
                        $("input").val('');
                    } else {
                        $("#regmsg").css('color', '#f00000');
                        $("#regmsg").html(response.msg);
                    }

                }
            });








        });



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

    function amountformat(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function apersont() {
        var nofp = $("#aper").val();
        $("#accop").val(nofp);
        var ppapcharge = "0";
        var apcharge = nofp * ppapcharge;
        $("#apcharge").val(apcharge);
        //   get_membership_charges();
        if (nofp > 0) {
            $("#ap_text").html("<br>" + nofp + " Accompanying Person fee = INR " + amountformat(apcharge) + ".00");
        } else {
            $("#ap_text").html("");
        }
        if (nofp == '0') {
            $(".pname").remove();
        } else if (nofp == '1') {
            $(".pname").remove();
            $("#apbox").append("<div class='form-group pname'><label for='ap1'>Enter Accompanying person name</label><input onChange='setap1()' required name='apname[]' id='ap1' type='text' placeholder='&nbsp;' class='form-control'></div>");
            if (localStorage.getItem("ap1") != null) {
                $("#ap1").val(localStorage.getItem("ap1"));
            }
        } else if (nofp == '2') {
            $(".pname").remove();
            $("#apbox").append("<div class='form-group pname'><label for='ap1'>Enter Accompanying person name</label><input onChange='setap1()' required name='apname[]' id='ap1' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap2'>Enter Accompanying person name</label><input  onChange='setap2()' name='apname[]' required id='ap2' type='text' placeholder='&nbsp;' class='form-control'></div>");
            if (localStorage.getItem("ap1") != null) {
                $("#ap1").val(localStorage.getItem("ap1"));
            }
            if (localStorage.getItem("ap2") != null) {
                $("#ap2").val(localStorage.getItem("ap2"));
            }
        } else if (nofp == '3') {
            $(".pname").remove();
            $("#apbox").append("<div class='form-group pname'><label for='ap1'>Enter Accompanying person name</label><input onChange='setap1()' name='apname[]' required id='ap1' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap2'>Enter Accompanying person name</label><input onChange='setap2()' name='apname[]' required id='ap2' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap3'>Enter Accompanying person name</label><input onChange='setap3()' name='apname[]' required id='ap3' type='text' placeholder='&nbsp;' class='form-control'></div>");
            if (localStorage.getItem("ap1") != null) {
                $("#ap1").val(localStorage.getItem("ap1"));
            }
            if (localStorage.getItem("ap2") != null) {
                $("#ap2").val(localStorage.getItem("ap2"));
            }
            if (localStorage.getItem("ap3") != null) {
                $("#ap3").val(localStorage.getItem("ap3"));
            }
        } else if (nofp == '4') {
            $(".pname").remove();
            $("#apbox").append("<div class='form-group pname'><label for='ap1'>Enter Accompanying person name</label><input onChange='setap1()' name='apname[]' required id='ap1' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap2'>Enter Accompanying person name</label><input onChange='setap2()' name='apname[]' required id='ap2' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap3'>Enter Accompanying person name</label><input onChange='setap3()' name='apname[]' required id='ap3' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap4'>Enter Accompanying person name</label><input onChange='setap4()' name='apname[]' required id='ap4' type='text' placeholder='&nbsp;' class='form-control'></div>");
            if (localStorage.getItem("ap1") != null) {
                $("#ap1").val(localStorage.getItem("ap1"));
            }
            if (localStorage.getItem("ap2") != null) {
                $("#ap2").val(localStorage.getItem("ap2"));
            }
            if (localStorage.getItem("ap3") != null) {
                $("#ap3").val(localStorage.getItem("ap3"));
            }
            if (localStorage.getItem("ap4") != null) {
                $("#ap4").val(localStorage.getItem("ap4"));
            }
        } else if (nofp == '5') {
            $(".pname").remove();
            $("#apbox").append("<div class='form-group pname'><label for='ap1'>Enter Accompanying person name</label><input onChange='setap1()' name='apname[]' required id='ap1' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap2'>Enter Accompanying person name</label><input onChange='setap2()' name='apname[]' required id='ap2' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap3'>Enter Accompanying person name</label><input onChange='setap3()' name='apname[]' required id='ap3' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap4'>Enter Accompanying person name</label><input onChange='setap4()' name='apname[]' required id='ap4' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap5'>Enter Accompanying person name</label><input onChange='setap5()' name='apname[]' required id='ap5' type='text' placeholder='&nbsp;' class='form-control'></div>");
            if (localStorage.getItem("ap1") != null) {
                $("#ap1").val(localStorage.getItem("ap1"));
            }
            if (localStorage.getItem("ap2") != null) {
                $("#ap2").val(localStorage.getItem("ap2"));
            }
            if (localStorage.getItem("ap3") != null) {
                $("#ap3").val(localStorage.getItem("ap3"));
            }
            if (localStorage.getItem("ap4") != null) {
                $("#ap4").val(localStorage.getItem("ap4"));
            }
            if (localStorage.getItem("ap5") != null) {
                $("#ap5").val(localStorage.getItem("ap5"));
            }
        } else if (nofp == '6') {
            $(".pname").remove();
            $("#apbox").append("<div class='form-group pname'><label for='ap1'>Enter Accompanying person name</label><input onChange='setap1()' name='apname[]' required id='ap1' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap2'>Enter Accompanying person name</label><input onChange='setap2()' name='apname[]' required id='ap2' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap3'>Enter Accompanying person name</label><input onChange='setap3()' name='apname[]' required id='ap3' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap4'>Enter Accompanying person name</label><input onChange='setap4()' name='apname[]' required id='ap4' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap5'>Enter Accompanying person name</label><input onChange='setap5()' name='apname[]' required id='ap5' type='text' placeholder='&nbsp;' class='form-control'></div><div class='form-group pname'><label for='ap6'>Enter Accompanying person name</label><input onChange='setap6()' name='apname[]' required id='ap6' type='text' placeholder='&nbsp;' class='form-control'></div>");
            if (localStorage.getItem("ap1") != null) {
                $("#ap1").val(localStorage.getItem("ap1"));
            }
            if (localStorage.getItem("ap2") != null) {
                $("#ap2").val(localStorage.getItem("ap2"));
            }
            if (localStorage.getItem("ap3") != null) {
                $("#ap3").val(localStorage.getItem("ap3"));
            }
            if (localStorage.getItem("ap4") != null) {
                $("#ap4").val(localStorage.getItem("ap4"));
            }
            if (localStorage.getItem("ap5") != null) {
                $("#ap5").val(localStorage.getItem("ap5"));
            }
            if (localStorage.getItem("ap6") != null) {
                $("#ap6").val(localStorage.getItem("ap6"));
            }
        }
    }

    function setap1() {
        localStorage.setItem("ap1", $("#ap1").val());
    }

    function setap2() {
        localStorage.setItem("ap2", $("#ap2").val());
    }

    function setap3() {
        localStorage.setItem("ap3", $("#ap3").val());
    }

    function setap4() {
        localStorage.setItem("ap4", $("#ap4").val());
    }

    function setap5() {
        localStorage.setItem("ap5", $("#ap5").val());
    }

    function setap6() {
        localStorage.setItem("ap6", $("#ap6").val());
    }
    $('#ap_submit').click(function(e) {
        flag = 1;
        var aperson = $("#aper").val();
        var apcharge = $("#apcharge").val();
        if (aperson == 0) {
            alert('Please Select no. of person.');
            flag = 0;
            return false;
        }
        $.each($('.pname input'), function(e) {
            if ($(this).val().length == 0) {
                alert('Accompanying person name is empty.');
                flag = 0;
                return false;
            }
        });
        var category = "<?php echo $_SESSION['category'] ?>";
        var apersonname = $('input[name^=apname]').map(function(idx, elem) {
            return $(elem).val();
        }).get();
        var apname = apersonname;
        if (flag == 1) {
            var form_data = new FormData();
            form_data.append("action", 'ap_update');
            form_data.append("aperson", aperson);
            form_data.append("apcharge", apcharge);
            form_data.append("apname", apname);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo get_home_URL(); ?>/ajax_common.php',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {
                    if (result) {
                        localStorage.removeItem("ap1");
                        localStorage.removeItem("ap2");
                        localStorage.removeItem("ap3");
                        localStorage.removeItem("ap4");
                        localStorage.removeItem("ap5");
                        localStorage.removeItem("ap6");
                        window.location.href = "/payments";
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    alert("error" + xhr.responseText);
                }
            });
        }
    });
</script>
<style>
    @media (min-width: 576px) {

        #wshopmodal .modal-dialog,
        #aperson .modal-dialog {
            max-width: 800px;
            margin: 1.75rem auto;
        }
    }

    input[type=range] {
        display: block;
        width: 100%;
    }
</style>