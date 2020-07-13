<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php
	$html = Loader::helper('html');
	$this->addHeaderItem($html->css('https://fonts.googleapis.com/css?family=Open+Sans|Roboto'));
	$this->addHeaderItem($html->css('https://fonts.googleapis.com/css?family=Bai+Jamjuree:400,500,600,700&display=swap'));
	$this->addHeaderItem($html->css('/themes/niyaysociety2020/css/common.css'));
	$this->addHeaderItem($html->css('/themes/niyaysociety2020/css/style.css'));
	$this->addHeaderItem($html->css('/themes/niyaysociety2020/css/dark-mode.css'));
	$this->addHeaderItem($html->css('/themes/niyaysociety2020/css/ccm.css'));
?>

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
					<div class="page-header"><h1>ปิดปรับปรุงเว็บไซต์</h1></div>
					<div class="alert">ขณะนี้อยู่ในช่วงปรับปรุงเว็บไซต์<br>อาจทำให้ข้อมูลบางส่วนขาดหายไป ขออภัยความไม่สะดวก</div>
				</div>
			</section>
		</div>
	</div>
</div>

<script src="/themes/niyaysociety2020/js/script.js"></script>
<script src="/themes/niyaysociety2020/js/login.js"></script>