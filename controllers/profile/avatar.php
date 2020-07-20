<?php
defined('C5_EXECUTE') or die("Access Denied.");
Loader::controller('/profile/edit');

class ProfileAvatarController extends Concrete5_Controller_Profile_Avatar {

	public function saveImage() {
		$user = new User();
		$ui = $this->get('ui');
		if (!is_object($ui) || $ui->getUserID() < 1) {
			return false;
		}

		if(isset($_POST['image-data']) && strlen($_POST['image-data'])) {
			$thumb = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['image-data']));
			$fp = fopen(DIR_FILES_AVATARS."/".$ui->getUserID().".jpg","w");
			if($fp) {
				fwrite($fp, $thumb);
				fclose($fp);
				$data['uHasAvatar'] = 1;
				$ui->update($data);
			}
		}
		$this->redirect('/profile/avatar', 'saved');
	}

	public function saved() {
		$this->set('message', 'Avatar updated!');
	}
	public function deleted() {
		$this->set('message', 'Avatar removed.');
	}
	public function delete(){
		$ui = $this->get('ui');
		$av = $this->get('av');
		$av->removeAvatar($ui);
		$this->redirect('/profile/avatar', 'deleted');
	}

}

