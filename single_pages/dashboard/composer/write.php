<?php defined('C5_EXECUTE') or die("Access Denied.");

// Include CSS
include('themes/niyaysociety2020/inc/head_inc.php'); ?>
<div class="preloader"></div>
<?php
Loader::model('user');
$u = new User();

if($u->getUserName() != "admin"){

	include('single_pages/dashboard/composer/write-user.php'); 

}else{

	include('single_pages/dashboard/composer/write-admin.php');

}

include('themes/niyaysociety2020/inc/foot_inc.php');
?>