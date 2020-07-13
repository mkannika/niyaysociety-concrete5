<?php       

defined('C5_EXECUTE') or die(_("Access Denied."));

class UserBookmarksPackage extends Package {

	protected $pkgHandle = 'user_bookmarks';
	protected $appVersionRequired = '5.4';
	protected $pkgVersion = '1.1.4'; 
	
	public function getPackageDescription() {
		return t('Allows a user to bookmark pages on your site.');
	}
	
	public function getPackageName() {
		return t('Bookmarks');
	}
	
	
	public function install() {
		$pkg = parent::install();
		BlockType::installBlockTypeFromPackage('bookmarked_page', $pkg);
		Loader::model('single_page');
		$p = SinglePage::add('/profile/bookmarks',$pkg);
        $p->update(array('cName'=>t("Bookmarks"), 'cDescription'=>t("Users Saved Bookmarks")));
	}
}

?>
