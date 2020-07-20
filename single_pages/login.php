<?php defined('C5_EXECUTE') or die("Access Denied.");
	Loader::library('authentication/open_id');
	$form = Loader::helper('form');
	$this->addHeaderItem('<meta name="viewport" content="width=device-width, initial-scale=1">');

	// Include CSS
	include('themes/niyaysociety2020/inc/head_inc.php');

	// If user have logged in redirect to /profile/view/ page
	global $u;
	if ($u -> isLoggedIn ()) { echo "<script> window.location = 'https://niyaysociety.com/profile/view/'; </script>"; }
?>

<script type="text/javascript">
	$(function() {
		$("input[name=uName]").focus();
	});
</script>

<?php include('themes/niyaysociety2020/inc/facebook.php'); ?>

<div class="preloader"></div>
<div class="page-login page-full">
	<div class="d-flex">
		<aside id="side-member" class="sidebar">
			<div class="side-logo"><a href="./" class="img-logo"><img src="/themes/niyaysociety2020/img/logo_white.png" alt="Niyay Society"></a></div>
			<div class="leading-text">สมัครสมาชิก<br>เพื่อลงงานเขียนกับเรา</div>
			<div class="side-btn text-center"><a href="/register" class="btn-white">สมัครสมาชิก</a></div>
			<ul class="btn-social">
				<li><a href=""><img src="/themes/niyaysociety2020/img/icon_facebook_white.png" alt="Facebook"></a></li>
				<li><a href=""><img src="/themes/niyaysociety2020/img/icon_twitter_white.png" alt="Twitter"></a></li>
				<li><a href=""><img src="/themes/niyaysociety2020/img/icon_ig_white.png" alt="Instagram"></a></li>
			</ul>
			<div class="text-email"><a href="">webmaster@niyaysociety.com</a></div>
		</aside>
		<div id="primary" class="content-area">
			<section id="sec-login" class="sec-area sec-active">
				<div class="center-box">

				<?php if (isset($intro_msg)) { ?>
					<div class="alert-message">
						<p><?php echo $intro_msg?></p>
					</div>
				<?php } ?>

				<?php if( $passwordChanged ){ ?>

					<div class="block-message info alert-message"><p><?php echo t('Password changed.  Please login to continue. ') ?></p></div>

				<?php } ?>

<?php if($changePasswordForm){ ?>

	<div class="page-header"><h1>Reset Password</h1></div>
	<div class="alert alert-warning"><?php echo t('Enter your new password below.') ?></div>
	<form id="reset-password" method="post" action="<?php echo $this->url( '/login', 'change_password', $uHash )?>">

		<div class="form-group">
			<input type="password" name="uPassword" placeholder="<?php echo t('New Password')?>" id="uPassword" class="ccm-input-text">
		</div>

		<div class="form-group">
			<input type="password" name="uPasswordConfirm" placeholder="<?php echo t('Confirm Password')?>" id="uPasswordConfirm" class="ccm-input-text">
		</div>

		<?php echo $form->submit('submit', t('Sign In'), array('class' => 'btn btn-success btn-lg btn-block'))?>
	</form>


<?php } elseif($validated) { ?>

<div class="page-header"><h1>Email Address Verified</h1></div>

<div class="success alert-message block-message">
<p>
<?php echo t('The email address <b>%s</b> has been verified and you are now a fully validated member of this website.', $uEmail)?>
</p>
<div class="alert-actions"><a class="btn small" href="<?php echo $this->url('/')?>"><?php echo t('Continue to Site')?></a></div>
</div>


<?php } else if (isset($_SESSION['uOpenIDError']) && isset($_SESSION['uOpenIDRequested'])) { ?>

<div class="ccm-form">

<?php switch($_SESSION['uOpenIDError']) {
	case OpenIDAuth::E_REGISTRATION_EMAIL_INCOMPLETE: ?>

		<form method="post" action="<?php echo $this->url('/login', 'complete_openid_email')?>">
			<p><?php echo t('To complete the signup process, you must provide a valid email address.')?></p>
			<div class="form-group">
				<label for="uEmail"><?php echo t('Email Address')?></label><br/>
				<?php echo $form->text('uEmail')?>
			</div>
			<div class="form-group">
			<?php echo $form->submit('submit', t('Sign In'), array('class' => 'btn btn-success btn-lg btn-block'))?>
			</div>
		</form>

	<?php break;
	case OpenIDAuth::E_REGISTRATION_EMAIL_EXISTS:

	$ui = UserInfo::getByID($_SESSION['uOpenIDExistingUser']);

	?>

		<div class="page-header"><h1>Login</h1></div>
		<form method="post" action="<?php echo $this->url('/login', 'do_login')?>">
			<p><?php echo t('The OpenID account returned an email address already registered on this site. To join this OpenID to the existing user account, login below:')?></p>
			<label for="uEmail"><?php echo t('Email Address')?></label><br/>
			<div><strong><?php echo $ui->getUserEmail()?></strong></div>
			<br/>

			<div>
			<label for="uName"><?php if (USER_REGISTRATION_WITH_EMAIL_ADDRESS == true) { ?>
				<?php echo t('Email Address')?>
			<?php } else { ?>
				<?php echo t('Username')?>
			<?php } ?></label><br/>
			<input type="text" name="uName" id="uName" <?php echo (isset($uName)?'value="'.$uName.'"':'');?> class="ccm-input-text">
			</div>			<div>

			<label for="uPassword"><?php echo t('Password')?></label><br/>
			<input type="password" name="uPassword" id="uPassword" class="ccm-input-text">
			</div>

			<div class="ccm-button">
			<?php echo $form->submit('submit', t('Sign In') . ' &gt;', array('class' => 'btn btn-success btn-lg btn-block'))?>
			</div>
		</form>

	<?php break;

	}
?>

</div>

<?php } else if ($invalidRegistrationFields == true) { ?>

<p><?php echo t('You must provide the following information before you may login.')?></p>

<form method="post" action="<?php echo $this->url('/login', 'do_login')?>">
	<?php
	$attribs = UserAttributeKey::getRegistrationList();
	$af = Loader::helper('form/attribute');

	$i = 0;
	foreach($unfilledAttributes as $ak) {
		if ($i > 0) {
			print '<br/><br/>';
		}
		print $af->display($ak, $ak->isAttributeKeyRequiredOnRegister());
		$i++;
	}
	?>

	<?php echo $form->hidden('uName', Loader::helper('text')->entities($_POST['uName']))?>
	<?php echo $form->hidden('uPassword', Loader::helper('text')->entities($_POST['uPassword']))?>
	<?php echo $form->hidden('uOpenID', $uOpenID)?>
	<?php echo $form->hidden('completePartialProfile', true)?>

	<div class="ccm-button">
		<?php echo $form->submit('submit', t('Sign In'))?>
		<?php echo $form->hidden('rcID', $rcID); ?>
	</div>

</form>

<?php } else { ?>

	<div class="page-header"><h1>Login</h1></div>
	<form id="loginForm" method="post" action="<?php echo $this->url('/login', 'do_login')?>">
		<div class="form-group input-gradient">
			<input type="text" class="form-control login-field" placeholder="<?php if (USER_REGISTRATION_WITH_EMAIL_ADDRESS == true) { ?><?php echo t('Email Address')?><?php } else { ?><?php echo t('Username')?><?php } ?>" name="uName" id="uName" <?php echo (isset($uName)?'value="'.$uName.'"':'');?> />
		</div>
		<div class="form-group input-gradient">
			<input type="password" class="form-control" name="uPassword" id="uPassword" placeholder="Password" data-toggle="password" data-placement="after" />
		</div>
		<div class="form-group d-flex">
			<div class="checkbox">
				<input type="checkbox" name="uMaintainLogin" id="uMaintainLogin" value="1">
				<label for="uMaintainLogin"><?php echo t('จำฉันไว้ในระบบ')?></label>	
			</div>
			<div data-target="#sec-forgot-password" class="btn-link text-link">ลืมรหัสผ่าน?</div>
			<!-- <a data-toggle="modal" data-target="#forgetPass"></a> -->
		</div>

		<div class="action form-group btn-submit">
			<?php echo $form->submit('submit', t('เข้าสู่ระบบ'), array('class' => 'btn-gradient'))?>
		</div>

		<?php if (isset($locales) && is_array($locales) && count($locales) > 0) { ?>
			<div class="form-group">
				<label for="USER_LOCALE" class="control-label"><?php echo t('Language')?></label>
				<div class="form-control"><?php echo $form->select('USER_LOCALE', $locales)?></div>
			</div>
		<?php } ?>

		<?php $rcID = isset($_REQUEST['rcID']) ? Loader::helper('text')->entities($_REQUEST['rcID']) : $rcID; ?>
		<input type="hidden" name="rcID" value="<?php echo $rcID?>" />

	<?php if (OpenIDAuth::isEnabled()) { ?>
		<fieldset>
		<legend><?php echo t('OpenID')?></legend>

		<div class="form-group">
			<label for="uOpenID" class="control-label"><?php echo t('Login with OpenID')?>:</label>
			<div class="form-control">
				<input type="text" name="uOpenID" id="uOpenID" <?php echo (isset($uOpenID)?'value="'.$uOpenID.'"':'');?> class="ccm-input-openid">
			</div>
		</div>
		</fieldset>
	<?php } ?>
	</form>

<?php } ?>
				</div>
				<!-- <div class="action form-group">
					<button onclick="checkLoginState();" id="btn-fb-login" type="button" class="btn btn-facebook-login" name="button"><i class="fa fa-facebook-official"></i>Login with Facebook</button>
				</div> -->
			</section>

			<section id="sec-forgot-password" class="sec-area">
				<div class="toggle-login">
					<div class="icon"></div>
					<div class="icon"></div>
					<div class="icon"></div>
				</div>
				<form method="post" action="<?php echo $this->url('/login', 'forgot_password'); ?>">
					<div class="page-header">
						<h1>ลืมรหัสผ่าน</h1>
					</div>
					<div class="alert">
						<?php echo t("กรอกอีเมล์ของท่าน ระบบส่งจะลิ้งค์ไปยังอีเมล์ของท่านเพื่อตั้งรหัสผ่านใหม่"); ?>
					</div>
					<input type="hidden" name="rcID" value="<?php echo $rcID; ?>" />
					<div class="form-group input-gradient">
						<input type="text" name="uEmail" placeholder="Email Address" value="">
					</div>
					<div class="action form-group btn-submit">
						<?php echo $form->submit('submit', t('Reset Email and Password'), array('class' => 'btn-gradient')); ?>
					</div>
				</form>
			</section>
		</div>
	</div>
</div>

<!-- Load script for login with Facebook -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=1866929160193121";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- End load script for login with Facebook -->

<?php include('themes/niyaysociety2020/inc/foot_inc.php'); ?>
