<?php /* Template Name: Alumni Register */ include('./alumniadmin/function/function.php');?>
<?php get_header();
if(is_user_logged_in()){
	$rurl = '/members/' . bp_core_get_username( get_current_user_id() ) . '/profile/';
	redirect($rurl);
}
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
    <?php 
if (!empty($_POST['submit'])) {
  if (!empty($_POST['title']) && !empty($_POST['surname']) && !empty($_POST['first_name']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['payment_date']) && !empty($_POST['payment_id']) && !empty($_POST['payment_amount']) && !empty($_FILES['proof']['name'])) {
    $check_arr = array(
      'email' => $_POST['email']
    );
    $check_userName_arr = array(
      'username' => $_POST['username']
    );
    $check = check_user('user', $check_arr);
    $check_userName=check_user('user', $check_userName_arr);
    if ($check == 0 && $check_userName==0) {
      $user_data = array(
        "username" => $_POST['username'],
        "password" => $_POST['password'],
        "password_hash" => md5($_POST['password']),
        "email"   => $_POST['email'],
        "created_at" => strtotime('now')
      );
      $insert = dbRowInsert("user", $user_data);
      if (!empty($insert)) {
        $user_profile = array(
          "user_id" => $insert,
          "firstname" => $_POST['first_name'],
          "lastname" => $_POST['surname'],
          "title" => $_POST['title'],
          "transactiondate"   => $_POST['payment_date'],
          "transactionid"  => $_POST['payment_id'],
          "transactionamount" => $_POST['payment_amount'],
          'locale' => 'en-US',
          'MembershipId' => ''
        );
        if ($_FILES['proof']['name'] != '') {
          $file_name = $_FILES['proof']['name'];
          $file_tempname = $_FILES['proof']['tmp_name'];
          $folder = "./uploads";
          $file_name = $_FILES["proof"]["name"];
          $temp_name = $_FILES["proof"]["tmp_name"];
          $image_id = 'IMG' . "-" . rand(1000, 100000);
          $image = upload_image1($folder, $file_name, $temp_name, $image_id);
          if (!empty($image)) {
            $user_profile["proof_path"] = $image;
            $user_profile["proof_base_url"] = getHomeUrl() . 'uploads/';
          }
        }
        // print_r($user_profile);exit;
        dbRowInsert('user_profile', $user_profile);
        $str = strtotime("now");
        $time_line = array("public_identity" => $_POST['email'], "user_id" => $insert, "date" => $str);
        $response = json_encode($time_line);
        $timeline_event = array(
          "application" => 'backend',
          "category" => 'user',
          "event" => 'signup',
          "data" => $response,
          "created_at" => $str
        );
        $ins_timeline = dbRowInsert('timeline_event', $timeline_event);
        $msg = "User Added Successfully";
        reDirect("thankyou");
		if ( wp_redirect( "thankyou" ) ) {
    exit;
}
      } else {
        $msg = "Some Error Occured,please try again...s";
      }
    } else {
      if($check_userName>0){
        giveAlert("This Username already exist.");

      }else{
        giveAlert("User email already exist with same email Id.");
      }
    }
  } else {
    giveAlert("All Fields Are Mandatory.");
  }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <div class="container">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <div class="row">
        <div class="col-sm-8">
          <div class="card card-info">
            <div class="card-header">
              <h5 class="card-title">Alumni Registration Form</h5>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="POST" enctype="multipart/form-data" id="add_alumni_form">
              <div class="card-body">
                <div class="form-group row">
                  <label for="title" class="col-sm-4 col-form-label">Title*</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="title">
                      <?php foreach (title() as $key => $val) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                      <?php  } ?>

                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="surname" class="col-sm-4 col-form-label">Surname*</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="surname" placeholder="Surname" id="surname">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="first_name" class="col-sm-4 col-form-label">Firstname*</label>
                  <div class="col-sm-8">
                    <input id="first_name" type="text" class="form-control" name="first_name" placeholder="Firstname">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-4 col-form-label">Upload relevent Proof*</label>
                  <div class="col-sm-8">
                    <input type="file" class="form-control" name="proof" id="proof" accept="image/jpg, image/gif, image/png, image/jpeg, application/pdf">
                    <p>Upload relevant proof for PGI alumnus identification(ID card/Degree copy etc. (JPG,PNG,GIF,PDF only))</p>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="username" class="col-sm-4 col-form-label">Username*</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-4 col-form-label">Password*</label>
                  <div class="col-sm-8">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-sm-4 col-form-label">E-mail / Login ID*</label>
                  <div class="col-sm-8">
                    <input type="email" class="form-control" name="email" placeholder="Email" id="email">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="payment_date" class="col-sm-4 col-form-label">Payment Transaction Date*</label>
                  <div class="col-sm-8">
                    <input type="date" class="form-control" name="payment_date" id="payment_date" placeholder="Payment Transaction Date">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="payment_id" class="col-sm-4 col-form-label">Payment Transaction ID*</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="payment_id" id="payment_id" placeholder="Payment Transaction ID">
                    <p>Please provide the Transaction ID of your payment.</p>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="payment_amount" class="col-sm-4 col-form-label">Payment Amount*</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="payment_amount" id="payment_amount">
                      <option value="">Select Amount Paid</option>
                      <option value="Rs. 500">Rs. 500</option>
                      <option value="$30">$30</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="payment_amount" class="col-sm-4 col-form-label">Enter captcha code*</label>
                  <div class="col-sm-8">
                    <input type="text" name="vercode" id="vercode" class="form-control" onChange="verifycode()" required="required" placeholder="&nbsp;">
                  <p id="msg"></p>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/img/refresh.png" alt="reload" id="refresh" class="refresh" onClick="captchachnage()">
                  <img src="<?php echo get_template_directory_uri(); ?>/captcha.php" id="imgcaptcha">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="offset-sm-4 col-sm-8">
                    <div class="form-check">
                      <input required="required" type="checkbox" class="form-check-input" id="checkbox">
                      <label class="form-check-label" for="checkbox"> <a target="_blank" href="<?php echo the_permalink(13); ?>">I agree to the Eligibility rules of the membership</a></label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card">
                <button type="submit" id="add_alumni" name="submit" value="submit" class="btn btn-info btn-lg" disabled>Signup</button>
              </div>
              <!-- /.card-footer -->
            </form>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card card-info">
            <div class="card-header">
              <h5 class="card-title">Payment Instructions</h5>
            </div>
            <div style="padding:10px;">
              <p>INR 500 for Indian Residents and residents of other SAARC countries.</p><br />
              <p>USD25 for all others.</p><br />
              <p>Bank details are-<br />
                State Bank of INDIA, MEDICAL INSTITUTE branch<br />
                Account No.39103473905<br />
                Account Name. PCAAS<br />
                IFSC CODE-SBIN0001524<br />
                MICR CODE 160002007<br />
                SWIFT CODE SBININB B443</p><br />
                <div align="center"><img src="https://pgialumni.org/wp-content/uploads/2022/04/sbi-qr.jpg"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.Main content -->
    </div>
  </div>
</div>
  </div>
  </div>
<?php get_footer(); ?>
<script>
  $("#checkbox").on('click', function() {
    if ($(this).is(':checked')) {
      $("#add_alumni").attr('disabled', false);
    } else {
      $("#add_alumni").attr('disabled', true);
    }
  });
  $("#add_alumni").on('click', function(event) {
    var surname = $("#surname").val();
    var first_name = $("#first_name").val();
    var proof = $("#proof").val();
    var username = $("#first_name").val();
    var password = $("#password").val();
    var email = $("#email").val();
    var payment_date = $("#payment_date").val();
    var payment_id = $("#payment_id").val();
    var payment_amount = $("#payment_amount").val();
    if (surname == '') {
      event.preventDefault();
      alert('Please enter surname');
      return false;
    }
    if (first_name == '') {
      event.preventDefault();
      alert('Please enter first name');
      return false;
    }
    if (proof == '') {
      event.preventDefault();
      alert('Please select proof');
      return false;
    }
   if (proof != '') {
      formData = new FormData($('#add_alumni_form')[0]); //This will contain your form data
      var exten = $("#proof").val().split('.').pop().toLowerCase();
      if (jQuery.inArray(exten, ['jpg','jpeg','png','gif','pdf']) == -1) {
        event.preventDefault();
        alert("Invalid File");
      return false;
      }
    }
    if (username == '') {
      event.preventDefault();
      alert('Please enter username');
      return false;
    }
    if (password == '') {
      event.preventDefault();
      alert('Please enter password');
      return false;
    }
    if (email == '') {
      event.preventDefault();
      alert('Please enter email');
      return false;
    }
    if (email != '') {
      if (!validateEmail(email)) {
        event.preventDefault();
        alert('Please enter valid email syntax');
        return false;
      }
    }
    if (payment_date == '') {
      event.preventDefault();
      alert('Please select payment date');
      return false;
    }
    if (payment_id == '') {
      event.preventDefault();
      alert('Please enter payment id');
      return false;
    }
    if (payment_amount == '') {
      event.preventDefault();
      alert('Please enter payment amount');
      return false;
    }
  });
  $('#checkbox').click(function() {
      if ($(this).prop("checked") == true) {
        $('#add_alumni').removeAttr('disabled');
      } else if ($(this).prop("checked") == false) {
        $('#add_alumni').attr('disabled', 'disabled');
      }
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
    } else {
    }
  }
</script>
