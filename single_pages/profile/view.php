<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php
global $u;
$av = Loader::helper('concrete/avatar');
$user = UserInfo::getByID($profile->getUserID());
?>

<main id="primary" class="container d-flex">
	<aside id="sidebar" class="sidebar">
		<div id="member-avatar" class="widget">
			<div class="avatar-img"><?php
				//Load For Display Author
				$ih = Loader::helper('image');
				$av = Loader::helper('concrete/avatar');
				if($user->hasAvatar()){
					$avatarImgPath = $av->getImagePath( $profile, false );
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
						$avatarHTML = '<img src="'.$avatarImgPath.'" alt="'.$profile->getUserName().'" />';
					}
					echo '<a href="/profile/view/'.$profile->getUserID().'">'.$avatarHTML.'</a>';
				}else{
					echo '<a href="/profile/view/'.$profile->getUserID().'"><img src="/themes/niyaysociety2020/img/no_img.png" alt="'.$profile->getUserName().'"></a>';
				} ?></div>
			<div class="group-name">
				<?php if($profile->getAttribute('penname') != ""):
					echo '<div class="penname">'.$user->getAttribute('penname').'</div>';
					echo '<div class="username"><a href="/profile/view/'.$profile->getUserID().'">@'.$profile->getUserName().'</a></div>'; ?>
				<?php else: ?>
				<?php
					echo '<div class="username"><a href="/profile/view/'.$userID.'">@'.$profile->getUserName().'</a></div>'; ?>
				<?php endif; ?>
			</div>
		</div>
		<?php if($profile->getUserID() != $u->getUserID()){ ?>
		<div id="profile-list" class="widget">
			<?php Loader::element('profile/sidebar', array('profile'=> $profile)); ?>
		</div>
		<?php }elseif($profile->getUserID() === $u->getUserID()){ ?>
		<div id="member-menu" class="widget">
			<ul>
				<li><a class="icon-dash" href="/dashboard/composer/drafts">Dashboard</a></li>
				<li><a class="icon-write" href="/profile/bookmarks/">เรื่องที่ติดตาม</a></li>
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
				<?php if($profile->getUserID() != $u->getUserID()){ ?>
				<li><a class="icon-dash" href="/profile/view/">กลับไปยังหน้าสมาชิก</a></li>
				<?php }elseif($profile->getUserID() === $u->getUserID()){ ?>
				<li><a class="icon-edit" href="/profile/edit/">แก้ไขข้อมูลส่วนตัว</a></li>
				<?php } ?>
				<li><a class="icon-signout" href="/login/logout/">ลงชื่อออก</a></li>
			</ul>
		</div>
		<?php //Loader::element('profile/sidebar', array('profile'=> $profile)); ?>
	</aside>

	<?php
		Loader::model('page_counter');
		$th = Loader::helper('text');
		$nh = Loader::helper('navigation');
		$page = Page::getByHandle('home_fiction');
		$pageID = $page->getCollectionID();
		$userID =  $profile->getUserID();
		$pl = new PageList();
		$pl->filterByUserID($userID);
		$pl->filterByCollectionTypeHandle('home_fiction');
		$pl->sortByPublicDateDescending('desc');
		$pages = $pl->getPage();
	?>
	<div id="content" class="content-area">
		<h2 class="content-title">ผลงานของฉัน<span class="count">ทั้งหมด <?php echo count($pages); ?> เรื่อง</span></h2>
		<?php if ($pages != '') { ?>
			<div class="work-slide row"><?php				
				foreach ($pages as $page):
				$title = $th->entities($page->getCollectionName());
				$url = $nh->getLinkToCollection($page);
				$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
				$target = empty($target) ? '_self' : $target;
				$last_edited = $page->getCollectionDateLastModified('d.m.Y เวลา H:i น.');

				$img = $page->getAttribute('thumbnail');
				$thumb = $ih->getThumbnail($img, 290, 435, true);

				$color = "";
				$status = $page->getAttribute('status');
				if($status == 'ยังไม่จบ'){ $color = "incomplete"; }
				if($status == 'จบแล้ว' ){ $color = "complete"; }
				$category = Page::getByID($page->getCollectionParentID());
				$desc = $page->getAttribute('meta_description'); ?>
				<div class="item-work">
					<a class="inner" href="<?php echo $url ?>">
						<div class="d-flex">
							<div class="cover-work">
							<?php if( $thumb->src != "" ) { ?>
								<img src="<?php echo $thumb->src; ?>" alt="<?php echo $title ?>">
							<?php } else { ?>
								<img src="/themes/niyaysociety2020/img/no_cover.jpg" alt="<?php echo $title ?>">
							<?php } ?>
							</div>
							<div class="info-work">
								<h3><?php echo $title; ?></h3>
								<div class="cat"><?php echo $category->getCollectionName(); ?></div>
								<div class="d-flex">
									<div class="rating"><img src="/themes/niyaysociety2020/img/rating.png"></div>
									<div class="vote"><?php
									$db= Loader::db();
									$cID = $page->getCollectionID();
									$score = $db->GetOne("SELECT `score` FROM `VoteScore` WHERE `cID` = $cID");
									if($score){ echo $score; }else{ echo '0'; } ?> คะแนน</div>
									<ul class="list-info">
									<li class="info-view">
										<span class="title">ยอดคนอ่าน</span>
										<span><?php echo PageCounter::getTotalPageViewsForPageID($page->cID); ?> วิว</span>
									</li>
									<li class="info-updated">
										<span class="title">อัพเดท</span>
										<span><?php echo $last_edited; ?></span>
									</li>
									<li class="info-status">
										<span class="title">สถานะ</span>
										<span class="<?php echo $color; ?>">
											<?php if($status != '' ){
												echo $page->getAttribute('status');
											}else{
												echo 'ไม่ระบุ';
											} ?></span>
									</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="work-desc"><?php if($desc != ''){
							echo $desc;
						}else{
							echo '';
						} ?></div>
					</a>
				</div>
				<?php endforeach;	?>
			</div>
		<?php } ?>
	</div>
</main>