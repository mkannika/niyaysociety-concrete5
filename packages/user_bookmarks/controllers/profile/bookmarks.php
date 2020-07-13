<?php     
defined('C5_EXECUTE') or die("Access Denied.");

Loader::model('user_attributes');
Loader::model('users_friends');

class ProfileBookmarksController extends Controller {
	
	public $helpers = array('html', 'form'); 
	
	public function on_start(){
		$this->error = Loader::helper('validation/error');
		$this->addHeaderItem(Loader::helper('html')->css('ccm.profile.css'));
	}
	
	public function view($userID = 0) {
		//disable if profiles aren't enabled
		if(!ENABLE_USER_PROFILES) {
			$this->render("/page_not_found");
		}
		
		$html = Loader::helper('html');
		$canEdit = false;
		$u = new User();

		if ($userID > 0) {
			$profile = UserInfo::getByID($userID);
			if (!is_object($profile)) {
				throw new Exception('Invalid User ID.');
			}
		} else if ($u->isRegistered()) {
			$profile = UserInfo::getByID($u->getUserID());
			$canEdit = true;
		} else {
			$this->set('intro_msg', t('You must sign in order to access this page!'));
			$this->render('/login');
		}
		$db = Loader::db();
		$query = "SELECT * FROM bookmarkedPage where uID=?"; 
    	$rows = $db->getAll($query, array($u->getUserID()));
    	$this->set('rows', $rows);
		$this->set('profile', $profile);
		$this->set('av', Loader::helper('concrete/avatar'));
		$this->set('t', Loader::helper('text'));
		$this->set('canEdit',$canEdit);
	}
	public function delete(){
		$db = Loader::db();
		$query = "DELETE FROM bookmarkedPage where uID=? and cID=?"; 
    	$rows = $db->getAll($query, array($this->post('uID'),$this->post('cID')));
	}
	
}