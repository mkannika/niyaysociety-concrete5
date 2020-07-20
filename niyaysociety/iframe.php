<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/themes/niyaysociety/css/global.css">
<link rel="stylesheet" type="text/css" href="/themes/niyaysociety/css/custom-style.css">
<style type="text/css">
	body{
		background-color: transparent;
	}
	.navbar-nav {
		margin: 0;
		text-align: right;
		float: right;
	}
	.navbar-nav>li {
		float: left;
	}
	.navbar-nav>li>a {
		color: #fff;
		padding: 20px;
	}
	.navbar-nav>li>a:focus,
	.navbar-nav>li>a:hover {
		color: rgb(255, 255, 255);
		background-color: rgb(30, 43, 56);
	}
	.navbar-nav>.open>a,
	.navbar-nav>.open>a:focus,
	.navbar-nav>.open>a:hover {
		background-color: rgb(30, 43, 56);
	}
	.navbar-toggle {
		border-color: rgb(30, 43, 56);
		border-radius: 0;
		margin-top: 14px;
	}
	.navbar-toggle:hover,
	.navbar-toggle:focus {
		background-color: rgb(30, 43, 56);
	}
	.navbar-right .login-msg{
		padding: 18px 15px;
		color: #fff;
	}
</style>

<?php
	$u = new User();
	$username = $c->getVersionObject()->getVersionAuthorUserName();
	$ui = UserInfo::getByUserName($username);
	$ih = Loader::helper('image');

	if ($u->isRegistered()){
		$wSize = '310px';
	}else{
		$wSize = '260px';
	}
?>
<ul class="nav navbar-nav navbar-right" style="width: <?php echo $wSize; ?>">
<?php

if ($u->isRegistered()) {

    if (Config::get("ENABLE_USER_PROFILES")) {
        $userName = '<a target="_parent" href="' . $this->url('/profile') . '">' . $u->getUserName() . '</a>';
    } else {
        $userName = $u->getUserName();
    } ?>

<li class="login-msg">
    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;<?php echo t('สวัสดีคุณ <b>%s</b>', $userName)?>
</li>
<li>
    <a target="_parent" href="<?php echo $this->url('/login', 'logout')?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;<?php echo t('ออกจากระบบ')?>
    </a>
</li><?php

} else {  ?>

<li>
	<a target="_parent" href="https://niyaysociety.com/login"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&nbsp;เข้าสู่ระบบ</a>
</li>
<li>
	<a target="_parent" href="https://niyaysociety.com/register">
		<span class="glyphicon glyphicon-registration-mark" aria-hidden="true"></span>&nbsp;สมัครสมาชิก
	</a>
</li>
<?php } ?>
</ul>