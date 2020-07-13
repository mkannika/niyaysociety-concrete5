<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1"><?php
	// Include <meta> and CSS
	include('themes/niyaysociety2020/inc/meta.php');
	include('themes/niyaysociety2020/inc/head_inc.php');
	include('themes/niyaysociety2020/inc/facebook.php');
	Loader::element('header_required');
	?>

</head>
<body class="<?php echo $c->getCollectionTypeHandle(); ?>">
<div class="preloader"></div>
<nav id="mode-toggle">
	<div class="theme-switch-wrapper">
		<label class="theme-switch" for="checkbox" title="โหมดกลางคืน">
			<input type="checkbox" value="dark-mode" id="checkbox" />
			<div class="icon-slider round"></div>
		</label>
	</div>
</nav>
<header id="header">
	<div class="container d-flex">
		<div id="navbar" class="d-flex">
			<a class="logo" href="/">
			<svg class="svg-logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 47.27 39.95">
				<defs>
					<style>
						.gradient-1 { fill: url(#linear-gradient); }
						.gradient-2 { fill: url(#linear-gradient-2); }
						.gradient-3 { fill: #fff; }
					</style>
					<linearGradient id="linear-gradient" x1="38.22" y1="-14.87" x2="-9.97" y2="50.31" gradientUnits="userSpaceOnUse">
						<stop offset="0" stop-color="#f37063" />
						<stop offset="1" stop-color="#ef5394" />
					</linearGradient>
					<linearGradient id="linear-gradient-2" x1="52.58" y1="-4.25" x2="4.39" y2="60.93" xlink:href="#linear-gradient" />
				</defs>
				<g id="svg-logo">
					<path class="gradient-1" d="M23.64,40c-7-1.69-14.36-3.14-21.3-4.91C.63,34.61.06,33.83.05,31.91c0-1.07,0-2.15,0-3.24s0-2,0-3v-.77c0-1,0-2,0-3v-.77c0-.5,0-1,0-1.49v-6.1c0-.24,0-.48,0-.72v-2.3C0,8,0,5.56.06,3.19.09.65,1.21-.31,3.47.09,10,1.24,17,3.18,23.64,4.54Z" />
					<path class="gradient-2" d="M47.27,16.19v3.36c0,1.09,0,2.18,0,3.26v.92c0,2.78,0,5.52,0,8.18,0,1.92-.58,2.7-2.29,3.13C38,36.81,30.68,38.26,23.64,40V4.53C30.29,3.18,37.27,1.24,43.8.09c2.26-.4,3.38.56,3.41,3.09C47.26,7.37,47.27,11.77,47.27,16.19Z" />
					<path class="gradient-3" d="M44.63,16.67a7.45,7.45,0,0,0,.21-1.77,7.64,7.64,0,1,0-2.13,5.28l4.55,2.35v-.91c0-1.07,0-2.15,0-3.22V18ZM37.2,18.82a3.93,3.93,0,1,1,3.93-3.92A3.92,3.92,0,0,1,37.2,18.82Z" />
					<path class="gradient-3" d="M7.88,12.67a1.57,1.57,0,0,1-.56,1.19,2,2,0,0,1-1.36.5H0v-.87c0-.24,0-.48,0-.72V11H6A1.82,1.82,0,0,1,7.88,12.67Z" />
					<path class="gradient-3" d="M0,18.62H10.11a1.77,1.77,0,0,0,1.23-.49,1.69,1.69,0,0,0-1.23-2.9H0Z" />
					<path class="gradient-3" d="M10.16,21.19a1.73,1.73,0,0,1-.48,1.2,1.65,1.65,0,0,1-1.17.49H.05c0-1.12,0-2.26,0-3.39H8.51A1.68,1.68,0,0,1,10.16,21.19Z" />
					<path class="gradient-3" d="M7.41,25.45a1.62,1.62,0,0,1-.57,1.2,2.09,2.09,0,0,1-1.36.49H.07c0-1.12,0-2.25,0-3.39H5.48A1.83,1.83,0,0,1,7.41,25.45Z" />
				</g>
			</svg>
			</a>
			<div id="toggle-menu">
				<div class="icon-bar"></div>
				<div class="icon-bar"></div>
				<div class="icon-bar"></div>
			</div>
			<nav class="header-menu d-flex">
				<ul class="main-menu d-flex">
					<li class="dropdown">
						<a class="dropdown-toggle">นิยาย<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/all-niyay/drama">ดราม่า</a></li>
							<li><a href="/all-niyay/romantic">โรแมนติก</a></li>
							<li><a href="/all-niyay/comedy">คอมเมดี้</a></li>
							<li><a href="/all-niyay/erotic">อีโรติก</a></li>
							<li><a href="/all-niyay/fantasy">แฟนตาซี</a></li>
							<li><a href="/all-niyay/investigate">สืบสวนสอบสวน</a></li>
							<li><a href="/all-niyay/action">ต่อสู้</a></li>
							<li><a href="/all-niyay/y">นิยาย Y</a></li>
							<li><a href="/all-niyay/fanfic">แฟนฟิค</a></li>
						</ul>
					</li>
					<li><a href="/writers">นักเขียน</a></li>
					<li><a href="/blog.niyaysociety.com">บทความ</a></li>
				</ul>
				<ul class="btn-group <?php if( $c->getCollectionHandle() == 'home' || $c->getCollectionHandle() == 'writers'){ echo 'btn-inverse'; } ?> d-flex">
				<?php
					$u = new User();
					$username = $c->getVersionObject()->getVersionAuthorUserName();
					$ui = UserInfo::getByUserName($username);
					if ($u->isRegistered()) {
						if (Config::get("ENABLE_USER_PROFILES")) {
							$userName = '<a href="' . $this->url('/profile') . '">' . $u->getUserName() . '</a>';
						} else {
							$userName = $u->getUserName();
						} ?>
					<li class="login-msg"><span rel="<?php echo $u->getUserID(); ?>"><?php echo t('สวัสดีคุณ <b>%s</b>', $userName)?></span></li>
					<li><a class="btn-gradient" href="<?php echo $this->url('/login', 'logout')?>"><span>ออกจากระบบ</span></a></li>
					<?php } else {  ?>
						<li><a class="btn-gradient" href="/login"><span>เข้าสู่ระบบ</span></a></li>
						<li><a class="btn-gradient" href="/register"><span>สมัครสมาชิก</span></a></li>
					<?php } ?>
				</ul>
			</nav>
		</div>
	</div>
</header>