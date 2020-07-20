<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php global $u;
$user = UserInfo::getByID($u->getUserID());
?>

<main id="primary" class="container d-flex">
	<aside id="sidebar" class="sidebar">
		<div id="member-avatar" class="widget">
			<div class="avatar-img"><?php
				//Load For Display Author
				$u = new User();
				$userID = $u->getUserID();
				$pageOwner = UserInfo::getByID($userID);
				$ih = Loader::helper('image');
				$av = Loader::helper('concrete/avatar');
				$userOwner = $pageOwner->getUserName();

				if($pageOwner->hasAvatar()){
					$avatarImgPath = $av->getImagePath( $pageOwner, false );
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
						$avatarHTML = '<img src="'.$avatarImgPath.'" alt="'.$userOwner.'" />';
					}
					echo '<a href="/profile/view/'.$userID.'">'.$avatarHTML.'</a>';
				}else{
					echo '<a href="/profile/view/'.$userID.'"><img src="/themes/niyaysociety/img/no_img.png" alt="'.$userOwner.'"></a>';
				} ?>
			</div>
			<div class="group-name">
				<?php if($user->getAttribute('penname') != ""):
				echo '<div class="penname">'.$user->getAttribute('penname').'</div>';
				echo '<div class="username"><a href="/profile/view/'.$userID.'">@'.$userOwner.'</a></div>'; ?>
				<?php else: ?>
				<?php
					echo '<div class="penname">'.$userOwner.'</div>';
					echo '<div class="username"><a href="/profile/view/'.$userID.'">@'.$userOwner.'</a></div>'; ?>
				<?php endif; ?>
			</div>
		</div>
		<?php if($user->getUserID() != $u->getUserID()){ ?>
		<div id="profile-list" class="widget">
			<?php Loader::element('profile/sidebar', array('profile'=> $user)); ?>
		</div>
		<?php }elseif($user->getUserID() === $u->getUserID()){ ?>
		<div id="member-menu" class="widget">
			<ul>
				<li><a class="icon-dash" href="/dashboard/composer/drafts">Dashboard</a></li>
				<li><a class="icon-message" href="/profile/messages/">ข้อความ</a></li>
				<li><a class="icon-friends" href="/profile/friends/">เพื่อน</a></li>
				<li><a class="icon-avatar" href="/profile/avatar/">รูปประจำตัว</a></li>
			</ul>
			<ul id="create-menu" class="widget">
				<li><a class="icon-write" href="/dashboard/composer/write/">สร้างผลงานใหม่</a></li>
				<li><a class="icon-add" href="/dashboard/composer/write/">เพิ่มตอนใหม่</a></li>
			</ul>
		</div>
		<?php } ?>
		<!-- <div id="side-social" class="widget"><?php
			// $facebook = '#';
			// $twitter = '#';
			// if($user->getAttribute('facebook') != ""){
			// 	$facebook = $user->getAttribute('facebook');
			// }
			// if($user->getAttribute('twitter') != ""){
			// 	$twitter = $user->getAttribute('twitter');
			// }
			?>
			<ul>
				<li><a class="icon-facebook" href="<?php //echo $facebook; ?>" target="_blank">Facebook</a></li>
				<li><a class="icon-twitter" href="<?php //echo $twitter; ?>">Twiter</a></li>
			</ul>
		</div> -->
		<div id="setting-menu" class="widget">
			<ul>
				<?php if($user->getUserID() != $u->getUserID()){ ?>
				<li><a class="icon-dash" href="/profile/view/">กลับไปยังหน้าสมาชิก</a></li>
				<?php }elseif($user->getUserID() === $u->getUserID()){ ?>
				<li><a class="icon-edit" href="/profile/edit/">แก้ไขข้อมูลส่วนตัว</a></li>
				<?php } ?>
				<li><a class="icon-signout" href="/login/logout/">ลงชื่อออก</a></li>
			</ul>
		</div>
	</aside>

	<div id="content" class="content-area">
		<h2 class="page-title"><span>แก้ไขรูปประจำตัว</span></h2>
		<div class="upload-avatar">
			<form action="<?php print $this->action("saveImage");?>" method="post" enctype="multipart/form-data">
				<div class="image-editor">
					<div class="input-file"><input type="file" class="cropit-image-input"></div>
					<div class="cropit-wrapper">
						<div class="cropit-image-preview"></div>
					</div>
					<input type="range" class="cropit-image-zoom-input">
					<input type="hidden" name="image-data" class="hidden-image-data">
					<button id="btn-upload" type="submit" disabled name="submit_avatar_file" class="btn-gradient">Upload</button>
				</div>
			</form>
		</div>
		<?php if ($ui->hasAvatar()) { ?>
			<div class="text-center"><a href="<?php echo $this->action('delete')?>" class="btn-gradient"><?php echo t('ลบรูปประจำตัว')?></a></div>
		<?php } ?>

		<script>
		$(function() {
			$('.image-editor').cropit({
				exportZoom: 1.25,
				imageBackground: true,
				imageBackgroundBorderWidth: 20,
				imageState: {
					src: '',
				},
				smallImage: 'allow'
			});

			$('.image-editor').find('input.cropit-image-zoom-input');

			$('form').submit(function() {
			var imageData = $('.image-editor').cropit('export');
				$('.hidden-image-data').val(imageData);
			});
		});
		</script>
	</div>
</main>

<script type="text/javascript">
$(function() {
	 $("input.cropit-image-input:file").change(function (){
		 $('#btn-upload').removeAttr("disabled");
	 });
});
</script>
