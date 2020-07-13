<?php       
defined('C5_EXECUTE') or die(_("Access Denied."));

class BookmarkedPageBlockController extends BlockController {

	protected $btTable = 'btBookmark';
	protected $btInterfaceWidth = "300";
	protected $btInterfaceHeight = "260";


	public function getBlockTypeDescription() {
		return t("Allows users to save their bookmarks");
	}

	public function getBlockTypeName() {
		return t("Bookmark");
	}
	public function save($data) { 
		$args['name'] = isset($data['name']) ? $data['name'] : '';
		parent::save($args);
	}

	function action_add_bookmark(){
		$txt=loader::helper('text');
		$name=$txt->sanitize($_POST['bookmark-name']);
		$description=$txt->sanitize($_POST['bookmark-description']);
		$url=$_POST['page-url'];
		$id=$_POST['bookmark-user-id'];
		$cid=$_POST['bookmark-page-id'];
		$db = Loader::db();
		$q = "SELECT * from bookmarkedPage where cID = ? AND uID = ?";
		$vals=array($cid, $id);
		$r = $db->getAll($q, $vals);
		if (!$r) {
			$sql = "INSERT INTO bookmarkedPage (name, description, url, uID, cID) VALUES (?, ?, ?, ?, ?)";
			$vals=array($name, $description, $url, $id, $cid);
			$db->query($sql, $vals);
			$message = t('<a href="#" class="btn-gradient" id="add-bookmark"><span>เลิกติดตามเรื่องนี้</span></a>');
			$this->set('message', $message);
		}else{
			$message = t('<a href="#" class="btn-gradient" id="add-bookmark"><span>เลิกติดตามเรื่องนี้</span></a>');
			$this->set('message', $message);
		}
	}
		
}

?>