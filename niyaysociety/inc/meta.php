<?php
	$nh = Loader::helper('navigation');
	$ih = Loader::helper('image');
	$ak_url = $nh->getCollectionURL($c);;
	$ak_title = $c->getCollectionName();
	$akd = $c->getCollectionAttributeValue('meta_description');
	$akk = $c->getCollectionAttributeValue('meta_keywords');


	if($c->getCollectionTypeHandle() == 'single_post'){

		$cPage = Page::getByID($c->getCollectionParentID());
		$ak_img = $cPage->getAttribute('thumbnail');

	} else {

		$ak_img = $c->getAttribute('thumbnail');

	}

	$thumb = $ih->getThumbnail($ak_img, 290, 435, true);
	$ak_img_url = $thumb->src;

	if($ak_img_url == ''){
		$ak_img_url = '/themes/niyaysociety/img/niyaysociety_thumb_share.png';
	}
?>

<!-- SEO content -->
<meta property="og:url" content="<?php echo $ak_url; ?>" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $ak_title; ?> :: อาณาจักรคนรักนิยาย" />
<meta property="og:description" content="<?php echo $akd;  ?>" />
<meta property="og:image:width" content="200"/>
<meta property="og:image:height" content="303"/>
<meta property="og:image:secure_url" content="/themes/niyaysociety/img/niyaysociety_thumb_share.png" />
<meta property="og:image" content="niyaysociety.com<?php echo $ak_img_url; ?>" />