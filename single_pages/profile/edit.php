<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php global $u;
$user = UserInfo::getByID($u->getUserID());
?>

<main id="primary" class="container d-flex">
	<aside id="sidebar" class="sidebar">
		<div id="member-avatar" class="widget">
			<div class="avatar-img">
				<?php
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
					echo '<a href="/profile/view/'.$userID.'"><img src="/themes/niyaysociety2020/img/no_img.png" alt="'.$userOwner.'"></a>';
				} ?>
			</div>
			<div class="group-name">
				<?php if($user->getAttribute('penname') != ""):
					echo '<div class="penname" href="/profile/view/'.$userID.'">'.$user->getAttribute('penname').'</div>';
					echo '<div class="username"><a href="/profile/view/'.$userID.'">@'.$userOwner.'</a></div>'; ?>
				<?php else: ?>
				<?php
					echo '<div class="penname" href="/profile/view/'.$userID.'">'.$userOwner.'</div>';
					echo '<div class="username"><a href="/profile/view/'.$userID.'">@'.$userOwner.'</a></div>'; ?>
				<?php endif; ?>
			</div>
		</div>
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
				<li><a class="icon-dash" href="/profile/view/">กลับไปยังหน้าสมาชิก</a></li>
				<li><a class="icon-signout" href="/login/logout/">ลงชื่อออก</a></li>
			</ul>
		</div>
		<?php  //Loader::element('profile/sidebar', array('profile'=> $ui)); ?>
	</aside>

	<div id="content" class="content-area">
		<h2 class="page-title"><span>แก้ไขข้อมูลสมาชิก</span></h2>
		<?php
			if (isset($error) && $error->has()) {
				$error->output();
			}else if (isset($message)) { ?>
			<div class="alert"><?php echo $message ?></div>
			<script type="text/javascript">
			$(function() {
				$("div.message").show('highlight', {}, 500);
			});
			</script>
		<?php  } ?>

		<form method="post" action="<?php echo $this->action('save')?>" enctype="multipart/form-data">
			<section class="sec-area"><?php
				$valt->output('profile_edit');
				$attribs = UserAttributeKey::getEditableInProfileList();
				if(is_array($attribs) && count($attribs)) { ?>

				<div class="control-group input-icon">
					<span class="icon icon-envelop"></span>
					<?php echo $form->text('uEmail',$ui->getUserEmail(), array('placeholder' => 'Email', 'disabled' => 'disabled'))?>
				</div>

				<?php  if(ENABLE_USER_TIMEZONES) { ?>
				<div class="form-group">
					<?php echo  $form->label('uTimezone', t('Time Zone'))?> <span class="ccm-required">*</span><br/>
					<?php echo  $form->select('uTimezone',
						$date->getTimezones(), ($ui->getUserTimezone() ? $ui->getUserTimezone():date_default_timezone_get())
				); ?>
				</div>
				<?php  } ?>

				<?php
				$af = Loader::helper('form/attribute');
				$af->setAttributeObject($ui);
				foreach($attribs as $ak) {
					print $af->display($ak, $ak->isAttributeKeyRequiredOnProfile());
				} ?>
			<?php  } ?>
		</section>

		<section class="sec-area">
			<h2 class="page-title"><span>เปลี่ยนรหัสผ่าน</span></h2>
			<div class="control-group input-icon">
				<span class="icon icon-password"></span>
				<?php echo $form->password('uPasswordNew', array('class' => 'form-control', 'placeholder' => 'รหัสผ่านใหม่'))?>
			</div>
			<div class="control-group input-icon">
				<span class="icon icon-password"></span>
				<?php echo $form->password('uPasswordNewConfirm', array('class' => 'form-control', 'placeholder' => 'ยืนยันรหัสผ่านใหม่'))?>
			</div>
			<div class="text-center">
				<?php echo $form->submit('save', t('บันทึก'), array('class' => 'btn-gradient'))?>
			</div>
		</section>
		</form>
	</div>
</main>