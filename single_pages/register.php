<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php // Include CSS
	include('themes/niyaysociety2020/inc/head_inc.php');
	include('themes/niyaysociety2020/inc/foot_inc.php'); ?>

<script>
	var count = 1;
	//var checkStatus = "connected";
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
			testAPI();
    } else {
      // The person is not logged into your app or we are unable to tell.
			console.log("Please login Facebook");
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '1866929160193121',
    cookie     : true,  // enable cookies to allow the server to access
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.8' // use graph api version 2.8
  });

  // Now that we've initialized the JavaScript SDK, we call
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  /*FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });*/

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI(status) {

		FB.login(function(response) {
		    if (response.authResponse) {

				 FB.api('/me', {fields: 'first_name, last_name, email, link, gender, location'} , function(response) {

		 			$.post('/check-user/', {
		 				user_id: response.id,
		 				user_link: response.link,
		 				user_email : response.email,
		 				user_first_name : response.first_name,
		 				user_last_name : response.last_name,
		 				user_gender : response.gender,
		 				user_location : response.location
		 			}, function(a){
		 				//success redirect to /profile page
		 				window.location = "https://niyaysociety.com/profile/view/";
		 			});

		     });
		    } else {
		     console.log('User cancelled login or did not fully authorize.');
		    }
		}, {scope: 'public_profile, email, user_birthday, user_location'});

  }
</script>

<div class="preloader"></div>
<div class="d-flex">
<aside id="side-member" class="sidebar">
	<div class="side-logo"><a href="./" class="img-logo"><img src="/themes/niyaysociety2020/img/logo_white.png" alt="Niyay Society"></a></div>
	<div class="leading-text">สมัครสมาชิก<br>เพื่อลงงานเขียนกับเรา</div>
	<div class="side-btn text-center"><a href="/login" class="btn-white">เข้าสู่ระบบ</a></div>
	<ul class="btn-social">
		<li><a href=""><img src="/themes/niyaysociety2020/img/icon_facebook_white.png" alt="Facebook"></a></li>
		<li><a href=""><img src="/themes/niyaysociety2020/img/icon_twitter_white.png" alt="Twitter"></a></li>
		<li><a href=""><img src="/themes/niyaysociety2020/img/icon_ig_white.png" alt="Instagram"></a></li>
	</ul>
	<div class="text-email"><a href="">webmaster@niyaysociety.com</a></div>
</aside>
<div id="primary" class="content-area">
<section id="sec-login" class="sec-area sec-register sec-active">
	<div class="center-box">
		<div class="page-header"><h1>Registration</h1></div><?php
		$attribs = UserAttributeKey::getRegistrationList();

		if($success) {

			switch($success) {
				case "registered": ?>
				<div class="alert"><?php echo $successMsg ?><br>
				<a href="<?php echo $this->url('/')?>"><?php echo t('Return to Home')?></a></div><?php
				break;

				case "validate": ?>
				<p><?php echo $successMsg[0] ?></p>
				<p><?php echo $successMsg[1] ?></p>
				<p><a href="<?php echo $this->url('/')?>"><?php echo t('Return to Home')?></a></p><?php
				break;

				case "pending": ?>
				<p><?php echo $successMsg ?></p>
				<p><a href="<?php echo $this->url('/')?>"><?php echo t('Return to Home')?></a></p><?php
				break;
			}

		} else { ?>

		<form method="post" action="<?php echo $this->url('/register', 'do_register')?>">

			<div class="form-group input-gradient">
				<?php echo $form->text('uName' , array('class' => '', 'placeholder' => 'Username')); ?>
			</div>

			<div class="form-group input-gradient">
				<?php echo $form->text('uEmail', array('class' => '', 'placeholder' => 'Email')); ?>
			</div>

			<div class="form-group input-gradient">
				<?php echo $form->password('uPassword', array('class' => '', 'placeholder' => 'Password')); ?>
			</div>

			<div class="form-group input-gradient">
				<?php echo $form->password('uPasswordConfirm', array('class' => '', 'placeholder' => 'Password Confirm')); ?>
			</div>

			<?php if (count($attribs) > 0) { ?>
			<div class="checkbox">
				<legend><?php echo t('Options')?></legend>
				<?php
				$af = Loader::helper('form/attribute');

				foreach($attribs as $ak) { ?>
						<?php echo $af->display($ak, $ak->isAttributeKeyRequiredOnRegister());	?>
				<?php } ?>
			</div>

			<?php } ?>

			<?php if (ENABLE_REGISTRATION_CAPTCHA) { ?>
			
				<div id="captcha-input" class="form-group">
					<?php $captcha = Loader::helper('validation/captcha'); ?>
					<?php echo $captcha->label(); ?>
					<?php
						$captcha->showInput();
						$captcha->display();
					?>
				</div>
				
			<?php } ?>

			<div class="form-group text-center">
				<?php echo $form->hidden('rcID', $rcID); ?>
				<?php echo $form->submit('register', t('สมัครสมาชิก'), array('class' => 'btn-gradient'))?>
			</div>

		</form>
		<?php } ?>

		<!-- <div class="action form-group text-center">
			<button onclick="checkLoginState();" id="btn-fb-login" type="button" class="btn btn-facebook-login" name="button"><i class="fa fa-facebook-official"></i>Login with Facebook</button>
		</div> -->
		
	</div>
</section>
</div>
</div>
