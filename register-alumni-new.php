<?php /* Template Name: Alumni Register New */ include('./alumniadmin/function/function.php'); ?>
<?php get_header();
if (is_user_logged_in()) {
    $rurl = '/members/' . bp_core_get_username(get_current_user_id()) . '/profile/';
    redirect($rurl);
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
<div class="bg-grey padding50">
    <div class="container clearfix">
        <div class="container">
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <div class="card card-info">
                    <div class="card-header">
                        <h5 class="card-title">Alumni Registration Form</h5>
                    </div>
                    <div class="card-body">
                    <div class="alert alert-success">
   Global PGI Alumni Summit Brochure <strong><a href="https://pgialumni.org/img/global-pgi.pdf" target="_blank" rel="noopener noreferrer">Download</a></strong>
</div>
                        <div class="mb-3 mt-4">
                            <label for="exampleInputEmail1" class="form-label"> Are you an existing member of PCAAS</label><br />
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="member" id="yes" value="yes" onclick="myFunctionYes()">
                                <label class="form-check-label" for="yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="member" id="no" value="no" onclick="myFunctionYes()">
                                <label class="form-check-label" for="no">No</label>
                            </div>
                        </div>
                        <div id="boxyes" style="display: none;">
                            <div class="form-group mb-3">
                                <label for="" class="form-label">Membership Number </label>
                                <input onkeyup="memberid()" id="membershipno" type="text" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="" class="form-label"><b>or</b> Enter Registered EmailID /Contact Number </label>
                                <input onkeyup="contactid()" id="contactdetail" type="text" class="form-control">
                            </div>
                            <button type="button" class="btn btn-primary btn-lg w-100" id="checkmember">SUBMIT</button>
                            <div class="membermsg"></div>
                        </div>
                        <div id="boxno" style="display: none;">
                            <div class="alert alert-warning">
                                Since you have not been registered with us, so lets start your membership registration process now.
                            </div>
                            <div class="form-group">
                                <label for="title">Title <span>*</span></label>
                                <select id="title" class="form-control select2" name="title">
                                    <?php foreach (title() as $key => $val) { ?>
                                        <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="fname">First Name <span>*</span></label>
                                    <input id="fname" type="text" class="form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="mname">Middle Name</label>
                                    <input id="mname" type="text" class="form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="lname">Last Name <span>*</span></label>
                                    <input id="lname" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth <span>*</span></label>
                                <input id="dob" type="date" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label style="width: 100%;" for="number">Contact Number <span>*</span></label>
                                    <input type="tel" value="+91" class="ccode cocode" name="ccode" class="form-control">
                                    <input onchange="validatenumber()" id="number" type="number" class="form-control">
                                    <small id="numbererror" style="color: #f00;"></small> <small>Please remember this number as it will be used as your login ID for this website</small>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label style="width: 100%;" id="samenobox"><input type="checkbox" id="sameno"> Tick the checkbox if your contact number is same as your what's app contact number</label>
                                    <div class="wabox">
                                        <input type="tel" value="+91" class="ccode wacode" name="ccode" class="form-control">
                                        <input placeholder="WhatsApp enabled Contact Number" id="whatsapp" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="degreeyear">Select Year of passing latest degree from PGIMER</label>
                                    <input id="degreeyear" type="year" class="form-control yearpicker">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="facultyyear">Select year of joining PGIMER as faculty/senior resident</label>
                                    <input id="facultyyear" type="year" class="form-control yearpicker">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="degree">Select any degree completed from PGIMER</label>
                                    <select id="degree" class="form-select select2">
                                        <option value="">--</option>
                                        <?php record_set('degree_list', 'SELECT * FROM degree where cstatus = 1 order by id desc');
                                        if ($totalRows_degree_list > 0) {
                                            while ($result = mysqli_fetch_array($degree_list)) { ?>
                                                <option value="<?php echo $result['id']; ?>"><?php echo $result['name']; ?></option>
                                            <?php

                                            }
                                        } else { ?>
                                            <option value="">Not Found</option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="faculty">Select department you were related to at PGIMER <span>*</span></label>
                                    <select id="faculty" class="form-select select2">
                                        <?php record_set('department_list', 'SELECT * FROM departments where cstatus = 1 order by id desc');
                                        if ($totalRows_department_list > 0) {
                                            while ($result = mysqli_fetch_array($department_list)) { ?>
                                                <option value="<?php echo $result['id']; ?>"><?php echo $result['name']; ?></option>
                                            <?php
                                            }
                                        } else { ?>
                                            <option value="">Not Found</option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>



                                <div class="col-md-6 form-group">
                                    <label for="email">Email ID <span>*</span></label>
                                    <input onchange="validateemail()" id="email" type="text" class="form-control">
                                    <small id="emailerror" style="color: #f00;"></small> <small>Please remember this email id as it will be used as your login ID for this website</small>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="country">Residence Country <span>*</span></label> <label class="saarccheck" style="float:right;" for="saarc"><input id="saarc" type="checkbox"> SAARC Countries?</label>
                                    <select style="height: 39px;" onchange="membership_charge()" id="country" class="form-control">
                                        <?php foreach ($countrylist as $key => $val) { ?>
                                            <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                        <?php  } ?>

                                    </select>
                                </div>



                                <div class="col-md-6 form-group">
                                    <label for="pass">Create Password <span>*</span></label>
                                    <input type="password" class="form-control" name="pass" id="pass" value="" placeholder="&nbsp;">
                                    <span id="pmsg"></span>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="vpass">Confirm Password <span>*</span></label>
                                    <input class="form-control" type="password" name="vpass" id="vpass" value="" placeholder="&nbsp;">
                                    <span id="vmsg"></span>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="practisestate">The state that you practice</label>
                                    <input class="form-control" type="text" name="practisestate" id="practisestate" value="" placeholder="&nbsp;">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="cspecialisation">Current practice specialty</label>
                                    <input class="form-control" type="text" name="cspecialisation" id="cspecialisation" value="" placeholder="&nbsp;">
                                </div>
                            </div>
                            <div class="form-group">
                                <p style="margin-bottom: 0px;"><b>Membership Type <span>*</span></b></p>
                                <div class="form-check form-check-inline">
                                    <input onclick="membership_charge()" class="form-check-input" type="radio" name="mtype" id="Lifetime" value="1">
                                    <label class="form-check-label" for="Lifetime">Membership</label>
                                </div><br>
                                <div class="form-check form-check-inline">
                                    <input onclick="membership_charge()" class="form-check-input" type="radio" name="mtype" id="Membership" value="2">
                                    <label class="form-check-label" for="Membership">Membership + Global PGI Alumni Summit <a href="#" data-toggle="modal" data-target="#attendsummit">(Kindly check eligibility to attend summit)</a></label>
                                </div>
                            </div>
                            <div class="modal" id="attendsummit">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Eligibility</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                           <img src="/img/eligibility.jpg" alt="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dfile">Upload documentary proof for your association as alumnus with PGI</label>
                                <input type="file" name="dfile" id="dfile" class="form-control">
                            </div>
                            <input type="hidden" id="currency">
                            <div style="margin-top:20px;display: none;" class="alert alert-info" id="charge_display">
                            </div>
                            <div class="form-group" id="inrcont" style="display: block;">
                                <p style="margin-bottom: 0px;"><b>Please support the PGI Alumni Society well-being through meaningful and valuable contributions</b></p>
                                <div class="form-check form-check-inline">
                                    <input onclick="membership_charge()" class="form-check-input" type="radio" name="donate" id="inr5000" value="5000">
                                    <label class="form-check-label" for="inr5000">INR <?php echo format_amount(5000, 2); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input onclick="membership_charge()" class="form-check-input" type="radio" name="donate" id="inr10000" value="10000">
                                    <label class="form-check-label" for="inr10000">INR <?php echo format_amount(10000, 2); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input onclick="membership_charge()" class="form-check-input" type="radio" name="donate" id="inr50000" value="50000">
                                    <label class="form-check-label" for="inr50000">INR <?php echo format_amount(50000, 2); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input onclick="membership_charge()" class="form-check-input" type="radio" name="donate" id="inrlakh" value="100000">
                                    <label class="form-check-label" for="inrlakh">INR <?php echo format_amount(100000, 2); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input onclick="membership_charge()" class="form-check-input" type="radio" name="donate" id="inr0" value="0">
                                    <label class="form-check-label" for="inr0">Not interested at this moment</label>
                                </div>
                            </div>
                            <div class="form-group" id="usdcont" style="display: none;">
                                <p style="margin-bottom: 0px;"><b>Please support the PGI Alumni Society well-being through meaningful and valuable contributions</b></p>

                                <div class="form-check form-check-inline">
                                    <input onclick="membership_charge()" class="form-check-input" type="radio" name="donate" id="usd50" value="50">
                                    <label class="form-check-label" for="usd50">USD <?php echo format_amount(50, 2); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input onclick="membership_charge()" class="form-check-input" type="radio" name="donate" id="usd100" value="100">
                                    <label class="form-check-label" for="usd100">USD <?php echo format_amount(100, 2); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input onclick="membership_charge()" class="form-check-input" type="radio" name="donate" id="usd200" value="200">
                                    <label class="form-check-label" for="usd200">USD <?php echo format_amount(200, 2); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input onclick="membership_charge()" class="form-check-input" type="radio" name="donate" id="usd500" value="500">
                                    <label class="form-check-label" for="usd500">USD <?php echo format_amount(500, 2); ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input onclick="membership_charge()" class="form-check-input" type="radio" name="donate" id="usd0" value="0">
                                    <label class="form-check-label" for="usd0">Not interested at this moment</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="vercode">Enter captcha code</label>
                                    <input type="text" name="vercode" id="vercode" class="form-control" onChange="verifycode()" required="required" placeholder="&nbsp;">
                                    <p id="msg"></p>
                                </div>
                                <div class="col-md-6">
                                    <p style="margin-bottom: 4px;">&nbsp;</p>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/refresh.png" alt="reload" id="refresh" class="refresh" onClick="captchachnage()">
                                    <img src="<?php echo get_template_directory_uri(); ?>/captcha.php" id="imgcaptcha">
                                </div>
                            </div>
                            <div class="form-group"> <b class="concentc">
                    <input type="checkbox" name="consent" id="consent" required="">
                    I agree that all the above information is correct to the best of my knowledge</b>                  
                </div>
                            
                            <button id="add_alumni" class="btn btn-info btn-block btn-lg">Submit</button>
                            <p id="regmsg"></p>
                            <br>
                            <div class="alert alert-danger">
                                <p style="font-size: 26px;line-height: 1.6;">For any technical assistance regarding registration (Please Call  on <a href="tel:9463654426">9463654426</a>) and (WhatsApp on <a href="https://api.whatsapp.com/send/?phone=916280606365">6280606365</a>)</p>
                            </div>
                            <div class="alert alert-success">
                                <p>PGI OFFERS DISCOUNTED OR FREE TREATMENT TO FINANCIALLY CHALLENGED PATIENTS THROUGH THE “POOR PATIENTS FUND” THAT IS FUNDED BY DONORS LIKE YOU. </p>
                                <p>ANY AMOUNT WOULD CONTRIBUTE TO A LIFE SAVING MEANS FOR THESE DESTITUDE PATIENTS.</p>
                                <a href="https://pgimer.edu.in/PGIMER_PORTAL/PGIMERPORTAL/GlobalPages/JSP/Page_Data.jsp?dep_id=5676" target="_blank" rel="noopener noreferrer"> PLEASE CLICK HERE TO DONATE</a>.
                            </div>
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
    $(document).ready(function() {
        $(".saarccheck").click(function(){
            if ($('#saarc').prop('checked')) {
                $("#country").html("");
                $("#country").append('<option value="India">India</option><option value="Afghanistan">Afghanistan</option><option value="Bangladesh">Bangladesh</option><option value="Bhutan">Bhutan</option><option value="Maldives">Maldives</option><option value="Nepal">Nepal</option><option value="Sri-Lanka">Sri-Lanka</option>');
                } else {
                    $("#country").html("");
                $("#country").append('<option value="India">India</option>');
                }
        });
        $(".cocode").keyup(function() {
            $("#numbererror").html("Select Country from Dropdown.");
            $("#number").focus();
            setTimeout(function() {
                $("#numbererror").html("");
            }, 2500);
            return false;
        });
    });
    $('#samenobox').click(function() {
        if ($('#sameno').is(':checked')) {
            var cnumber = $("#number").val();
            var cocode = $(".cocode").val();
            $('#whatsapp').val(cnumber);
            $('#whatsapp').attr('readonly', true);
            $('.wacode').val(cocode);
            $('.wabox').css('opacity', 0);
        } else {
            $('#whatsapp').attr('readonly', false);
            $('.wabox').css('opacity', 100);
        }
    });
    $('#pass').on('keyup', function() {
        if ($('#pass').val().length < 6) {
            $('#pmsg').html('Password must be 6 digits').css('color', 'red');
            $('#add_alumni').attr('disabled', 'disabled');
            return false;
        } else {
            $('#pmsg').html('').css('color', 'green');
            $('#add_alumni').removeAttr('disabled');
        }
    });
    $('#vpass').on('keyup', function() {
        if ($('#pass').val() == $('#vpass').val()) {
            $('#vmsg').html('').css('color', 'green');
            $('#add_alumni').removeAttr('disabled');
        } else {
            $('#vmsg').html('Please Enter Correct Password').css('color', 'red');
            $('#add_alumni').attr('disabled', 'disabled');
            return false;
        }
    });

    function membership_charge() {
        if (!$("input[name='mtype']").is(':checked')) {
            var delegate_type = 0;
        } else {
            var delegate_type = $("input[type='radio'][name='mtype']:checked").val();
        }
        var country = $("#country").val();
        if (country == 'India' || country == 'Afghanistan' || country == 'Bangladesh' || country == 'Bhutan' || country == 'Maldives' || country == 'Nepal' || country == 'Sri-Lanka') {
            if ($('#inrcont').css("display") == "none") {
                $('input[name="donate"]').prop("checked", false);
            }
            $("#inrcont").show();
            $("#usdcont").hide();
            var currency = 'INR';
            if (delegate_type == 1) {
                var charge = 500;
            } else {
                var charge = 5500;
            }
        } else {
            if ($('#usdcont').css("display") == "none") {
                $('input[name="donate"]').prop("checked", false);
            }
            $("#usdcont").show();
            $("#inrcont").hide();
            var currency = 'USD';
            if (delegate_type == 1) {
                var charge = 25;
            } else {
                var charge = 275;
            }
        }
        $("#currency").val(currency);
        if (delegate_type != 0 && country != '') {
            $("#charge_display").show();
        }
        $("#charge_display").html('<b>Registration Charge: </b>' + currency + ' ' + charge);

    }
    // $("#checkbox").on('click', function() {
    //     if ($(this).is(':checked')) {
    //         $("#add_alumni").attr('disabled', false);
    //     } else {
    //         $("#add_alumni").attr('disabled', true);
    //     }
    // });
    $("#add_alumni").on('click', function(event) {
        var title = $("#title").val();
        var fname = $("#fname").val();
        var mname = $("#mname").val();
        var lname = $("#lname").val();
        var dob = $("#dob").val();
        var ccode = $(".cocode").val();
        var number = $("#number").val();
        var wacode = $(".wacode").val();
        var whatsapp = $("#whatsapp").val();
        var degreeyear = $("#degreeyear").val();
        var facultyyear = $("#facultyyear").val();
        var degree = $("#degree").val();
        var faculty = $("#faculty").val();
        var email = $("#email").val();
        var vercode = $("#vercode").val();
        var country = $("#country").val();
        var pass = $("#pass").val();
        var vpass = $("#vpass").val();
        if (title == '') {
            document.getElementById("title").style.borderColor = "#ff0000";
            document.getElementById("title").focus();
            return false;
        } else {
            document.getElementById("title").style.borderColor = "#ced4da";
        }
        if (fname == '') {
            document.getElementById("fname").style.borderColor = "#ff0000";
            document.getElementById("fname").focus();
            return false;
        } else {
            document.getElementById("fname").style.borderColor = "#ced4da";
        }
        if (lname == '') {
            document.getElementById("lname").style.borderColor = "#ff0000";
            document.getElementById("lname").focus();
            return false;
        } else {
            document.getElementById("lname").style.borderColor = "#ced4da";
        }
        if (dob == '') {
            document.getElementById("dob").style.borderColor = "#ff0000";
            document.getElementById("dob").focus();
            return false;
        } else {
            document.getElementById("dob").style.borderColor = "#ced4da";
        }
        if (number == '') {
            document.getElementById("number").style.borderColor = "#ff0000";
            document.getElementById("number").focus();
            return false;
        } else {
            document.getElementById("number").style.borderColor = "#ced4da";
        }
        // if (degree == '') {
        //     $('.select2-selection[aria-labelledby="select2-degree-container"]').css({
        //         'border-color': '#ff0000',
        //     });
        //     document.getElementById("degree").focus();
        //     return false;
        // } else {
        //     $('.select2-selection[aria-labelledby="select2-degree-container"]').css({
        //         'border-color': '#ced4da',
        //     });
        // }
        if (faculty == '') {
            document.getElementById("faculty").style.borderColor = "#ff0000";
            document.getElementById("faculty").focus();
            return false;
        } else {
            document.getElementById("faculty").style.borderColor = "#ced4da";
        }
        if (email == '') {
            document.getElementById("email").style.borderColor = "#ff0000";
            document.getElementById("email").focus();
            return false;
        } else {
            if (!validateemailid(email)) {
                document.getElementById("email").style.borderColor = "#ff0000";
                document.getElementById("email").focus();
                return false;
            }
            document.getElementById("email").style.borderColor = "#ced4da";
        }
        if (pass == '') {
            document.getElementById("pass").style.borderColor = "#ff0000";
            document.getElementById("pass").focus();
            return false;
        } else {
            document.getElementById("pass").style.borderColor = "#ced4da";
        }
        if (vpass == '') {
            document.getElementById("vpass").style.borderColor = "#ff0000";
            document.getElementById("vpass").focus();
            return false;
        } else {
            document.getElementById("vpass").style.borderColor = "#ced4da";
        }
        if (!$("input[name='mtype']:checked").val()) {
            alert('Select membership type.');
            return false;
        } else {
            var membership = $('input[name="mtype"]:checked').val();
        }
        var currency = $('#currency').val();
        if (vercode == '') {
            document.getElementById("vercode").style.borderColor = "#ff0000";
            document.getElementById("vercode").focus();
            return false;
        } else {
            document.getElementById("vercode").style.borderColor = "#ced4da";
        }
        if($("#consent").prop('checked') == true){
            $('.concentc').css({
                'border': 'none'
            });
        } else {
            $('.concentc').css({
                'border': '1px solid #ff0000'
            });
            return false;
        }


        var donate = $('input[name="donate"]:checked').val();
        var practisestate = $('#practisestate').val();
        var cspecialisation = $('#cspecialisation').val();
        var dfile = $('#dfile')[0].files[0];
        var form_data = new FormData();
        form_data.append("action", 'register');
        form_data.append("title", title);
        form_data.append("fname", fname);
        form_data.append("mname", mname);
        form_data.append("lname", lname);
        form_data.append("dob", dob);
        form_data.append("number", number);
        form_data.append("ccode", ccode);
        form_data.append("wacode", wacode);
        form_data.append("whatsapp", whatsapp);
        form_data.append("degreeyear", degreeyear);
        form_data.append("facultyyear", facultyyear);
        form_data.append("degree", degree);
        form_data.append("faculty", faculty);
        form_data.append("email", email);
        form_data.append("membership", membership);
        form_data.append("currency", currency);
        form_data.append("country", country);
        form_data.append("dfile", dfile);
        form_data.append("password", pass);
        form_data.append("donate", donate);
        form_data.append("practisestate", practisestate);
        form_data.append("cspecialisation", cspecialisation);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '<?php echo get_home_URL(); ?>/ajax_common.php',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                // var data = JSON.parse(response);
                if (response.dfile == 'notallowed') {
                    alert('Only pdf, jpg, JPEG, png file allowed.');
                } else if (response.data == 1) {
                    // $("#regmsg").css('color', '#008000');
                    // $("#regmsg").html(response.msg);
                    window.location.href = "/payments";
                    $("input").val('');
                } else {
                    $("#regmsg").css('color', '#f00000');
                    $("#regmsg").html(response.msg);
                }

            }
        });
    });

    function captchachnage() {
        $("#imgcaptcha").attr("src", "<?php echo get_template_directory_uri(); ?>/captcha.php");
    }

    function verifycode() {
        var vcode = $('#vercode').val();
        if (vcode) {
            $.ajax({
                type: 'POST',
                url: '<?php echo get_template_directory_uri(); ?>/captcha_verify.php',
                data: {
                    vercode: vcode
                },
                success: function(html) {
                    if (html == "successfully verified") {
                        $('#msg').html(html);
                        $('#msg').addClass('text-primary');
                        $('#add_alumni').prop('disabled', false);
                    } else {
                        $('#msg').html(html);
                        $('#msg').addClass('text-danger');
                        $('#add_alumni').prop('disabled', true);
                    }
                }
            });
        }
    }

    function validatenumber() {
        var number = $("#number").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo get_home_URL(); ?>/ajax_common.php',
            data: {
                action: 'validatenumber',
                number: number
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.data == 1) {
                    $("#number").val('');
                    $("#numbererror").html(data.msg);
                } else {
                    $("#numbererror").html('');
                }
            }
        });
    }

    function validateemail() {
        var email = $("#email").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo get_home_URL(); ?>/ajax_common.php',
            data: {
                action: 'validateemail',
                email: email
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.data == 1) {
                    $("#email").val('');
                    $("#emailerror").html(data.msg);
                } else {
                    $("#emailerror").html('');
                }
            }
        });
    }

    function myFunctionYes() {
        var member = $('input[name="member"]:checked').val();
        // alert(member);
        if (member == 'yes') {
            $("#boxyes").show();
            $("#boxno").hide();
        } else if (member == 'no') {
            $("#boxyes").hide();
            $("#boxno").show();
        }
    }

    function memberid() {
        $('#contactdetail').val('');
    }

    function contactid() {
        $('#membershipno').val('');
    }
    $('#checkmember').click(function() {
        var membershipno = $('#membershipno').val();
        var contact = $('#contactdetail').val();
        if (membershipno == '' && contact == '') {
            alert('Enter membership no. or contact detail.');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo get_home_URL(); ?>/ajax_common.php',
            data: {
                action: 'validate',
                membershipno: membershipno,
                contact: contact
            },
            success: function(response) {
                var data = JSON.parse(response);
                $('.membermsg').html(data.msg);
            }
        });
    });




    $(".yearpicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });

    function validateemailid($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test($email);
    }
</script>
<script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/js/intlTelInput.min.js"></script>
<script>
    $(window).load(function() {
        if ($.isFunction($.fn.intlTelInput)) {
            $(".ccode").intlTelInput({
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
            });
            $(".intl-tel-input").show();
        }
    });
</script>