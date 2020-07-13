<?php

// Add main fonts
$this->addHeaderItem($html->css('https://fonts.googleapis.com/css?family=Open+Sans|Roboto'));

// Add main CSS
$this->addHeaderItem($html->css('/themes/niyaysociety2020/css/common.css'));
$this->addHeaderItem($html->css('/themes/niyaysociety2020/css/dark-mode.css'));
$this->addHeaderItem($html->css('/themes/niyaysociety2020/css/style.css'));

if($c->getCollectionName() != "Edit"){
// 	$this->addHeaderItem($html->css('/concrete/css/jquery.ui.css'));
// 	$this->addFooterItem($html->javascript('/concrete/js/bootstrap.js'));
// 	$this->addFooterItem($html->javascript('/concrete/js/jquery.ui.js'));
// 	$this->addFooterItem($html->javascript('/concrete/js/jquery.form.js'));
// 	$this->addFooterItem($html->javascript('/concrete/js/jquery.rating.js'));
}

// if( $c->getCollectionHandle() == 'home'){
// 	$this->addFooterItem($html->javascript('https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js'));
// 	// Slick Slide
// 	$this->addHeaderItem($html->css('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css'));
// 	$this->addFooterItem($html->javascript('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js'));
// }