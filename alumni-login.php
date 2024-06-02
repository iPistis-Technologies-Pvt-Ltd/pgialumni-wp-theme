<?php /* Template Name: Alumni Login */ include('./alumniadmin/function/function.php'); ?>
<?php get_header();
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
            <div class="row mt-5">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="emaillogin">Email</label>
                                <input type="text" class="form-control" id="emaillogin">
                            </div>
                            <div class="form-group">
                                <label for="passwordlogin">Password</label>
                                <input type="password" class="form-control" id="passwordlogin">
                            </div>
                            <button class="btn btn-info btn-lg btn-block" id="loginsubmit">Submit</button>
                            <div class="text-center" style="margin-top: 10px;">
                                <a href="jquery:void(0)" data-toggle="modal" data-target="#forgetpass">Forgot Password?</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="forgetpass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Forgot password</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="email" class="form">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
            </div>
            <p id="fmsg" class="text-center"></p>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-lg" id="forgetpasss" name="sendemail">Submit</button>
                
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
<script type="text/javascript">
    $(function() {
        $("#loginsubmit").on('click', function() {
            var email = $("#emaillogin").val();
            var password = $("#passwordlogin").val();
            var flag = 1;

            function validateEmail(email) {
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
            }
            if (email == '') {
                document.getElementById("emaillogin").style.borderColor = "#ff0000";
                document.getElementById("emaillogin").focus();
                flag = 0;
                return false;
            } else {
                if (!validateEmail(email)) {
                    document.getElementById("emaillogin").style.borderColor = "#ff0000";
                    document.getElementById("emaillogin").focus();
                    return false;
                }
                document.getElementById("emaillogin").style.borderColor = "#ced4da";
                flag = 1;
            }
            if (password == '') {
                document.getElementById("passwordlogin").style.borderColor = "#ff0000";
                document.getElementById("passwordlogin").focus();
                flag = 0;
                return false;
            } else {
                document.getElementById("passwordlogin").style.borderColor = "#ced4da";
                flag = 1;
            }
            if (flag == 1) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '<?php echo get_home_URL(); ?>/ajax_common.php',
                    data: {
                        action: 'check_login',
                        email: email,
                        password: password,
                    },
                    success: function(result) {
                        if (result.acc == 'notmatched') {
                            alert("Invalid credential.");
                        } else if (result.mat == 'matched') {
                            // alert("Login Successfully")
                            if (result.payment == 'succe') {
                                window.location.href = "/alumni-dashboard";
                            } else {
                                // alert("payment Failed");
                                window.location.href = "/payments";
                            }

                        }
                    }
                });
            }

        });
        $("#forgetpasss").on('click', function() {
            var email = $("#email").val();
            if (email == '') {
                document.getElementById("email").style.borderColor = "#ff0000";
                document.getElementById("email").focus();
                flag = 0;
                return false;
            }
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo get_home_URL(); ?>/ajax_common.php',
                data: {
                    action: 'forgetpassword',
                    email: email
                },
                success: function(result) {
                    $("#fmsg").html("");
                    if (result.msg == 'notfound') {
                        $("#fmsg").html("Check your email, we don't have any record with this email.");
                    } else if (result.msg == 'retry') {
                        $("#fmsg").html("Some error accured, Please try again.");
                    } else if (result.msg == 'sent') {
                        $("#fmsg").html("Mail sent successfully.");
                    } else if (result.msg == 'notsent') {
                        $("#fmsg").html("Some error, Please try again.");
                    };
                }
            })
        });
    });
</script>