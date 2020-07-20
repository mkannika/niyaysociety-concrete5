<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('page_statistics');

class PageCounter extends PageStatistics {

	public static function getTotalPageViewsForPageID($cID = null, $date = null) {
		$db = Loader::db();
		if ($date != null) {
			return $db->GetOne("select count(pstID) from PageStatistics where date = ? and cID = ?", array($date,$cID));
		} else {
			return $db->GetOne("select count(pstID) from PageStatistics where cID = ?", array($cID));
		}
	}

}
