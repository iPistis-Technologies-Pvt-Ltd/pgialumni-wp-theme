<?php /* Template Name: Reset Password */ include('./alumniadmin/function/function.php'); ?>
<?php get_header();
$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
if (!empty($_GET['key'])) {
    $query = 'select * from user where auth_key="' . $_GET['key'] . '" limit 1';
    record_set('check_user', $query);
    if ($totalRows_check_user > 0) {
		$row_get_id = mysqli_fetch_assoc($check_user);
        $uemail = $row_get_id['email'];
    } else {
        redirect('/alumni-login');
    }
}
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
            <div class="row mt-5">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" aria-describedby="emailHelp" placeholder="Password">
                                <span id="pmsg"></span>
                            </div>
                            <div class="form-group">
                                <label for="confirmpassword">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmpassword" placeholder="Confirm Password">
                                <span id="vmsg"></span>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg" id="setnewpassword">Submit</button>
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
    $(function() {
        $('#password').on('keyup', function() {
            if ($('#password').val().length < 6) {
                $('#pmsg').html('Password must be 6 digits').css('color', 'red');
                $('#setnewpassword').attr('disabled', 'disabled');
                return false;
            } else {
                $('#pmsg').html('').css('color', 'green');
                $('#setnewpassword').removeAttr('disabled');
            }
        });
        $('#confirmpassword').on('keyup', function() {
            if ($('#password').val() == $('#confirmpassword').val()) {
                $('#vmsg').html('').css('color', 'green');
                $('#setnewpassword').removeAttr('disabled');
            } else {
                $('#vmsg').html('Please Enter Correct Password').css('color', 'red');
                $('#setnewpassword').attr('disabled', 'disabled');
                return false;
            }
        });
        $("#setnewpassword").on('click', function() {
            var randkey = "<?php echo $_GET['key'] ?>";
            var email = "<?php echo $uemail; ?>";
            var password = $("#password").val();
            var confirm = $("#confirmpassword").val();
            if (password == '') {
                document.getElementById("password").style.borderColor = "#ff0000";
                document.getElementById("password").focus();
                flag = 0;
                return false;
            }
            if (confirm == '') {
                document.getElementById("confirmpassword").style.borderColor = "#ff0000";
                document.getElementById("confirmpassword").focus();
                flag = 0;
                return false;
            }
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo get_home_URL(); ?>/ajax_common.php',
                data: {
                    action: 'setpassword',
                    passowrd: password,
                    confirmpass: confirm,
                    key: randkey,
                    email : email
                },
                success: function(result) {
                    if (result.msg == 'changed') {
                        alert("Your password has been changed successfully.")
                        window.location.href = "/alumni-login";
                    } else if (result.msg == 'nchanged') {
                        alert("Some error occured. Please try again...");
                    } else if (result.msg == 'notmatched') {
                        alert("Password Mismatch. Please Re-enter Correct Password");
                    }
                }
            })
        });
    });
</script>