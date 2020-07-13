<?php
defined('C5_EXECUTE') or die("Access Denied.");
Loader::model('user');
if ((!$c->isAdminArea()) && ($c->getCollectionPath() != '/login')) {
	$smm = Config::get('SITE_MAINTENANCE_MODE');
	$u = new User();
	if ($smm == 1 && ($u->getUserName() != "admin") && ($u->getUserName() != "mkannika")) {
		$v = View::getInstance();
		$v->render('/maintenance_mode/');
		exit;
	}
	// if ($smm == 1 && ($_SERVER['REQUEST_METHOD'] != 'POST' || Loader::helper('validation/token')->validate() == false)) {
	// 	if($u->getUserName() != "admin"){
	// 		$v = View::getInstance();
	// 		$v->render('/maintenance_mode/');
	// 		exit;
	// 	}
	// }
}
// if ((!$c->isAdminArea()) && ($c->getCollectionPath() != '/login')) {

// 	$smm = Config::get('SITE_MAINTENANCE_MODE');
// 	if ($smm == 1 && ($_SERVER['REQUEST_METHOD'] != 'POST' || Loader::helper('validation/token')->validate() == false)) {
// 		$v = View::getInstance();
// 		$v->render('/maintenance_mode/');
// 		exit;
// 	}
	
// }