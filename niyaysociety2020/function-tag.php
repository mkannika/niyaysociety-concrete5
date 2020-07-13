<?php 

// Get User
function getUser($user, $author){
	if($user->hasAvatar()){
		$avatarImgPath = $av->getImagePath( $user, false );
		$mw = ($maxWidth) ? $maxWidth : '200';
		$mh = ($maxHeight) ? $maxHeight : '200';
		if( substr($avatarImgPath,0,strlen(DIR_REL))==DIR_REL ) $avatarImgPath=substr($avatarImgPath,strlen(DIR_REL));
		$thumb = $ih->getThumbnail( DIR_BASE.$avatarImgPath, $mw, $mh);
		if($thumb->src){
			ob_start();
			$ih->outputThumbnail(DIR_BASE.$avatarImgPath, $mw, $mh);
			$avatarHTML=ob_get_contents();
			ob_end_clean();
		}else{
			$avatarHTML = '<img src="'.$avatarImgPath.'" alt="'.$author.'" />';
		}
		echo '<a href="/profile/view/'.$userID.'">'.$avatarHTML.'</a>';
	}else{
		echo '<a href="/profile/view/'.$userID.'"><img src="'.$this->getThemePath().'/img/no_img.png" alt="'.$author.'"></a>';
	}
}

?>