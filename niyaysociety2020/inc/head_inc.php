<?php
$html = Loader::helper('html');

// Add main fonts
$this->addHeaderItem($html->css('https://fonts.googleapis.com/css?family=Open+Sans|Roboto'));
$this->addHeaderItem($html->css('https://fonts.googleapis.com/css?family=Bai+Jamjuree:400,500,600,700&display=swap'));

// Add main CSS
$this->addHeaderItem($html->css('/themes/niyaysociety2020/css/common.css'));
// Slick Slide
$this->addHeaderItem($html->css('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css'));
$this->addHeaderItem($html->css('/themes/niyaysociety2020/css/style.css'));
$this->addHeaderItem($html->css('/themes/niyaysociety2020/css/dark-mode.css'));


// CSS for Single pages
if(($c->getCollectionHandle() == 'login') || ($c->getCollectionHandle() == 'register')){
	$this->addHeaderItem($html->css('/themes/niyaysociety2020/css/ccm.css'));
	$this->addFooterItem($html->javascript('/themes/niyaysociety2020/js/bootstrap-show-password.js'));
	$this->addFooterItem($html->javascript('/themes/niyaysociety2020/js/login.js'));
}

if($c->getCollectionName() == "Write"){
	$this->addHeaderItem($html->css('/themes/niyaysociety2020/css/dashboard.css'));
}

if($c->getCollectionName() == "Avatar"){
	$this->addFooterItem($html->javascript('/themes/niyaysociety2020/js/jquery.cropit.js'));
}