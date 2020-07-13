<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php');

//Load helper
Loader::model('page_counter');
global $u;
$ih = Loader::helper('image');
$nh = Loader::helper('navigation');
$th = Loader::helper('text');
$date = Loader::helper("date");
$db = Loader::db();
$av = Loader::helper('concrete/avatar');
$iph = Loader::helper('validation/ip');
$datetime = Loader::helper('form/date_time');


//Get story thumbnail
$img = $c->getAttribute('thumbnail');


// Get description and keywords
$description = $c->getCollectionAttributeValue('meta_description');
$keywords = $c->getCollectionAttributeValue('meta_keywords');

//Get writer name
$original_author = Page::getByID($c->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();

//Get avatar
$userID = $c->getCollectionUserID();
$pageOwner = UserInfo::getByID($userID);
$userOwner = $pageOwner->getUserName();

// Global ID
$uID = $u->getUserID();
$cID = $c->getCollectionID();

//Get Attribute
$color = "";
$status = $c->getAttribute('status');
if($status == 'ยังไม่จบ'){ $color = "incomplete"; }
if($status == 'จบแล้ว' ){ $color = "complete"; }

// Get View
$views = PageCounter::getTotalPageViewsForPageID($c->cID);

//Get Category
$category = Page::getByID($c->getCollectionParentID());

$query_score = "SELECT * FROM `VoteScore` WHERE `cID` = $cID";
$row_score = $db->Execute($query_score);

function DateThai($strDate){
	$strMonth = intval($strDate);
	$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	$strMonthThai=$strMonthCut[$strMonth];
	return "$strMonthThai";
}

include('themes/niyaysociety2020/vote.php');

?>

<main id="main" class="main-area">
	<header class="page-header">
		<div class="container d-flex">
			<div class="page-header-left">
				<div class="cover-work">
				<?php if( $img ) { ?>
					<a href="<?php echo $nh->getLinkToCollection($c); ?>"><img src="<?php echo $ih->getThumbnail($img, 200, 303, true)->src; ?>" alt="<?php echo $title ?>"></a>
				<?php } else { ?>
					<a href="<?php echo $nh->getLinkToCollection($c); ?>"><img src="<?php echo $this->getThemePath(); ?>/img/no_cover.jpg" alt="<?php echo $c->getCollectionName(); ?>"></a>
				<?php } ?>
				</div>
				<div class="report">
					<a href="#" class="icon-report">Report</a>
				</div>
			</div>
			<div class="page-info">
				<div class="title-group">
					<div class="story-meta">
						<h2 class="title-name"><?php echo $c->getCollectionName(); ?></h2>
						<ul class="tags-list d-flex">
							<?php echo $keywords; ?>
						</ul>
					</div>
					<div class="author-group">
						<div class="avatar-img">
							<?php
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
									echo '<a href="/profile/view/'.$userID.'"><img src="'.$this->getThemePath().'/img/no_img.png" alt="'.$userOwner.'"></a>';
								}
							?>
						</div>
						<div class="follow-group">
							<span class="username">
								<?php if($pageOwner->getAttribute('penname') != ""){
									echo $pageOwner->getAttribute('penname');
								} else {
									echo $original_author;
								} ?>
							</span>
							<a class="btn-white" href="/profile/friends/add_friend/<?php echo $userID; ?>">+ Follow</a>
						</div>
					</div>
				</div>
				<div class="page-desc">
					<div class="page-meta">
						<div class="category"><?php echo $category->getCollectionName(); ?></div>
						<div class="status"><?php echo $status; ?></div>
					</div>
					<p class="description"><?php echo $description; ?></p>
				</div>
			</div>
		</div>
	</header>
	<div class="btn-follow">
		<!-- <a href="#" class="btn-gradient"><span>ติดตามเรื่องนี้</span></a> -->
		<?php $bookmark = new GlobalArea('Bookmark');
			$bookmark->setBlockLimit(1);
			$bookmark->display(); ?>
	</div>
	<!-- /.page-header -->

	<!-- <div id="btn-fixed" style="opacity: 0">
		<ul class="d-flex">
			<li><a id="btn-follow" href="#">ติดตามเรื่องนี้</a></li>
			<li>
				<a id="btn-vote" href="#" class="btn-gradient3">
				<span>ให้คะแนนเรื่องนี้</span>
				<div class="rate-calc"><img src="<?php //echo $this->getThemePath(); ?>/img/demo_rating.png"></div></a>
			</li>
		</ul>
	</div> -->

	<div class="container">
		<!-- <div class="survey-block">
			<?php $survey = new GlobalArea('Survey');
			$survey->setBlockLimit(1);
			$survey->display(); ?>
		</div> -->
	</div>

	<div class="page-score-view">
		<ul class="container d-flex">
			<li>
				<div id="ranking">
					<form method="post" action="/index.php?cID=<?php echo $c->getCollectionID(); ?>">
					<fieldset>
					<span class="star-cb-group">
						<input type="radio" name="vote" style="vertical-align: middle" value="5" id="rating-1"><label title="5 คะแนน" for="rating-1"></label>
						<input type="radio" name="vote" style="vertical-align: middle" value="4" id="rating-2"><label for="rating-2" title="4 คะแนน"></label>
						<input type="radio" name="vote" style="vertical-align: middle" value="3" id="rating-3"><label for="rating-3" title="3 คะแนน"></label>
						<input type="radio" name="vote" style="vertical-align: middle" value="2" id="rating-4"><label for="rating-4" title="2 คะแนน"></label>
						<input type="radio" name="vote" style="vertical-align: middle" value="1" id="rating-5"><label for="rating-5" title="1 คะแนน"></label>
					</span>
					</fieldset>
					<?php if( $u -> isLoggedIn () == false ){ ?>
						<div class="popup">
							<div class="btn-alert">
								<svg class="svg-logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 47.27 39.95">
									<defs>
										<style>
											.gradient-1 { fill: url(#linear-gradient); }
											.gradient-2 { fill: url(#linear-gradient-2); }
											.gradient-3 { fill: #fff; }
										</style>
										<linearGradient id="linear-gradient" x1="38.22" y1="-14.87" x2="-9.97" y2="50.31" gradientUnits="userSpaceOnUse">
											<stop offset="0" stop-color="#f37063" />
											<stop offset="1" stop-color="#ef5394" />
										</linearGradient>
										<linearGradient id="linear-gradient-2" x1="52.58" y1="-4.25" x2="4.39" y2="60.93" xlink:href="#linear-gradient" />
									</defs>
									<g id="svg-logo">
										<path class="gradient-1" d="M23.64,40c-7-1.69-14.36-3.14-21.3-4.91C.63,34.61.06,33.83.05,31.91c0-1.07,0-2.15,0-3.24s0-2,0-3v-.77c0-1,0-2,0-3v-.77c0-.5,0-1,0-1.49v-6.1c0-.24,0-.48,0-.72v-2.3C0,8,0,5.56.06,3.19.09.65,1.21-.31,3.47.09,10,1.24,17,3.18,23.64,4.54Z" />
										<path class="gradient-2" d="M47.27,16.19v3.36c0,1.09,0,2.18,0,3.26v.92c0,2.78,0,5.52,0,8.18,0,1.92-.58,2.7-2.29,3.13C38,36.81,30.68,38.26,23.64,40V4.53C30.29,3.18,37.27,1.24,43.8.09c2.26-.4,3.38.56,3.41,3.09C47.26,7.37,47.27,11.77,47.27,16.19Z" />
										<path id="icon-search" class="gradient-3" d="M44.63,16.67a7.45,7.45,0,0,0,.21-1.77,7.64,7.64,0,1,0-2.13,5.28l4.55,2.35v-.91c0-1.07,0-2.15,0-3.22V18ZM37.2,18.82a3.93,3.93,0,1,1,3.93-3.92A3.92,3.92,0,0,1,37.2,18.82Z" />
										<path id="finger1" class="path-finger gradient-3" d="M7.88,12.67a1.57,1.57,0,0,1-.56,1.19,2,2,0,0,1-1.36.5H0v-.87c0-.24,0-.48,0-.72V11H6A1.82,1.82,0,0,1,7.88,12.67Z" />
										<path id="finger2" class="path-finger gradient-3" d="M0,18.62H10.11a1.77,1.77,0,0,0,1.23-.49,1.69,1.69,0,0,0-1.23-2.9H0Z" />
										<path id="finger3" class="path-finger gradient-3" d="M10.16,21.19a1.73,1.73,0,0,1-.48,1.2,1.65,1.65,0,0,1-1.17.49H.05c0-1.12,0-2.26,0-3.39H8.51A1.68,1.68,0,0,1,10.16,21.19Z" />
										<path id="finger4" class="path-finger gradient-3" d="M7.41,25.45a1.62,1.62,0,0,1-.57,1.2,2.09,2.09,0,0,1-1.36.49H.07c0-1.12,0-2.25,0-3.39H5.48A1.83,1.83,0,0,1,7.41,25.45Z" />
									</g>
								</svg>
								<span>คุณจะโหวตได้เมื่อ<a href="/login">เข้าสู่ระบบ</a>ค่ะ</span>
							</div>
						</div>
					<?php } else { ?>
						<div class="btn-vote">
							<input class="btn-gradient" type="submit" name="submit" disabled="disabled" value="Vote">
						</div>
					<?php } ?>
					</form>
				</div>
				<span class="text-score"><?php
					$score = $db->GetOne("SELECT `score` FROM `VoteScore` WHERE `cID` = $cID");

					if($score){
						echo $score.' คะแนน';
					}else{
						echo '0 คะแนน';
					}
				?></span>
			</li>
			<li>
				<div class="icon-view">
					<svg class="svg-view" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23.93 15.25">
						<defs>
							<style>.path-view{fill:#f16379;}</style>
						</defs>
						<g data-name="view">
							<path class="path-view" d="M12,15.25C5.46,15.25.37,8.38.15,8.09a.8.8,0,0,1,0-.93C.37,6.87,5.46,0,12,0s11.6,6.87,11.81,7.16a.77.77,0,0,1,0,.93C23.56,8.38,18.47,15.25,12,15.25ZM1.79,7.62C3,9.11,7.17,13.67,12,13.67s8.94-4.55,10.17-6c-1.23-1.5-5.38-6-10.17-6S3,6.13,1.79,7.62Z"/>
							<path class="path-view" d="M12,12.36a4.74,4.74,0,1,1,4.73-4.74A4.74,4.74,0,0,1,12,12.36Zm0-7.89a3.16,3.16,0,1,0,3.16,3.15A3.15,3.15,0,0,0,12,4.47Z"/>
						</g>
					</svg>
					<?php echo $views; ?>
				</div>
				<span>ยอดคนอ่าน</span>
			</li>
			<li>
				<div class="icon-follower">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26">
						<defs>
							<style>.path-follow{fill:#f16379;}</style>
						</defs>
						<g class="svg-follower" data-name="follower">
							<path class="path-follow" d="M21.89,0H4.11A4.29,4.29,0,0,0,0,4.44V15.67a4.29,4.29,0,0,0,4.11,4.44H9.45l2.88,5.48a.75.75,0,0,0,1.34,0l2.88-5.48h5.34A4.29,4.29,0,0,0,26,15.67V4.44A4.29,4.29,0,0,0,21.89,0Zm2.59,15.67a2.77,2.77,0,0,1-2.59,2.92h-5.8a.76.76,0,0,0-.67.41L13,23.6,10.58,19a.76.76,0,0,0-.67-.41H4.11a2.77,2.77,0,0,1-2.59-2.92V4.44A2.77,2.77,0,0,1,4.11,1.52H21.89a2.77,2.77,0,0,1,2.59,2.92Z"/>
							<path class="path-follow" d="M12.16,8.54a2.92,2.92,0,1,0-4.45,0A4.91,4.91,0,0,0,4.84,13v0a1.37,1.37,0,0,0,1.37,1.37h7.45A1.37,1.37,0,0,0,15,13v0a4.93,4.93,0,0,0-2.87-4.47ZM9.93,5.28A1.39,1.39,0,1,1,8.55,6.67,1.39,1.39,0,0,1,9.93,5.28Zm-3.57,7.6A3.39,3.39,0,0,1,9.75,9.62h.37a3.38,3.38,0,0,1,3.38,3.26Z"/>
							<path class="path-follow" d="M19.59,6.2a.6.6,0,0,0-.3.07L18,7.08a.6.6,0,0,0-.29.54c0,.31.2.63.5.63a.4.4,0,0,0,.25-.09l.3-.18v5.17c0,.32.39.48.79.48s.79-.16.79-.48V6.69c0-.3-.38-.49-.7-.49Z"/>
						</g>
					</svg>
					<?php
						$db = Loader::db();
						$q = "SELECT * from `bookmarkedPage` WHERE `cID` = $cID";
						$row = $db->Execute($q);
						if($row->RecordCount() > 0){
							echo $row->RecordCount().' คน';
						}else{
							echo '0 คน';
						}
					?>
				</div>
				<span>ยอดคนติดตาม</span>
			</li>
		</ul>
	</div>

	<article class="story-content">
		<div class="container">
			<section id="prologue" class="sec-area">
				<div class="title bg3">อารัมภบท</div>
				<div class="body">
					<ul class="btns-setting d-flex">
						<li>
							<div class="slc-wrapper">
								<select class="font-type">
									<option value="">รูปแบบอักษร</option>
									<option value="Bai Jamjuree">Bai Jamjuree</option>
									<option value="Kanit">Kanit</option>
									<option value="Niramit">Niramit</option>
									<option value="Pridi">Pridi</option>
									<option value="Prompt">Prompt</option>
									<option value="Sarabun">Sarabun</option>
									<option value="Thasadith">Thasadith</option>
								</select>
							</div>
						</li>
						<li>
							<ul class="slc-wrapper">
								<select class="mode-theme">
									<option value="light-mode">Light Mode</option>
									<option value="dark-mode">Dark Mode</option>
								</select>
							</ul>
							<ul class="btn-zoom">
								<li>
									<button id="zoom-in" type="button"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 20"><defs><style>.cls-1{fill:none;}.cls-2{clip-path:url(#clip-path);}.cls-3{fill:#f16379;}</style><clipPath id="clip-path" transform="translate(0 0)"><rect class="cls-1" width="20" height="20"/></clipPath></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g class="cls-2"><path class="cls-3" d="M19.77,18.67,14.13,13A8,8,0,1,0,13,14.13l5.65,5.64a.78.78,0,0,0,1.1-1.1ZM12.5,12.5a6.41,6.41,0,1,1,0-9.06,6.41,6.41,0,0,1,0,9.06Z" transform="translate(0 0)"/></g><path class="cls-3" d="M11.79,7.19h-3V4.14a.78.78,0,0,0-1.56,0V7.19H4.14a.78.78,0,1,0,0,1.56H7.19v3a.78.78,0,1,0,1.56,0v-3h3a.78.78,0,0,0,0-1.56Z" transform="translate(0 0)"/></g></g></svg></button>
								</li>
								<li>
									<button id="zoom-out" type="button"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 19.51 19.51"><defs><style>.cls-1{fill:none;}.cls-2{clip-path:url(#clip-path);}.cls-3{fill:#f16379;}</style><clipPath id="clip-path" transform="translate(0 0)"><rect class="cls-1" width="19.51" height="19.51"/></clipPath></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g class="cls-2"><path class="cls-3" d="M19.29,18.21l-5.5-5.5a7.78,7.78,0,1,0-1.08,1.08l5.5,5.5a.76.76,0,0,0,1.08-1.08Zm-7.1-6a6.25,6.25,0,1,1,0-8.84,6.25,6.25,0,0,1,0,8.84Z" transform="translate(0 0)"/></g><path class="cls-3" d="M11.51,7H4a.76.76,0,0,0-.76.76A.77.77,0,0,0,4,8.54h7.47a.77.77,0,0,0,.76-.77A.76.76,0,0,0,11.51,7Z" transform="translate(0 0)"/></g></g></svg></button>
								</li>
							</ul>
						</li>
					</ul>
					<div class="prologue-desc">
						<?php
							$prologue = new Area('Add Prologue Text');
							$prologue->display($c);
						?>
					</div>
					<div class="share-group"></div>
				</div>
			</section>
			<!-- /#prologue -->

			<section id="chapters" class="sec-area">
				<table class="table-stripe">
					<thead>
						<tr>
							<th><span>ชื่อตอน</span></th>
							<th><span class="icon-update"></span></th>
							<th><span class="icon-comment"></span></th>
							<th><span class="icon-view"></span></th>
						</tr>
					</thead>
					<tbody><?php
					$pl = new PageList();
					$pl->filterByParentID($c->getCollectionID());
					$pages = $pl->getPage();
					if(!empty($pages)){
					foreach ($pages as $page):
					$title = $th->entities($page->getCollectionName());
					$url = $nh->getLinkToCollection($page);
					$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
					$monthTH = DateThai($page->getCollectionDateLastModified('m'));
					$last_edited = $page->getCollectionDateLastModified('d '.$monthTH.' Y, H:i น.');
					$target = empty($target) ? '_self' : $target;

					// Guestbook
					$sql = "SELECT * FROM `btGuestBookEntries` WHERE  `cID` = $page->cID"; 
					$r = $db->Execute($sql);
					$rows = $r->RecordCount();
					//$row_guestbook = $r->FetchRow(); ?>
					<tr>
						<td><a href="<?php echo $url ?>"><?php echo $title; ?></a></td>
						<td><?php echo $last_edited; ?></td>
						<td><?php echo $rows; ?></td>
						<td><?php echo PageCounter::getTotalPageViewsForPageID($page->cID); ?></td>
					</tr>
					<?php endforeach; } ?>
					</tbody>
				</table>
			</section>
			<!-- /#chapters -->

			<div class="button-share">
				<span>กดแชร์</span>
				<ul>
					<li>
						<div class="fb-share-button" data-href="<?php echo $nh->getCollectionURL($c); ?>" data-layout="button_count" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore icon-facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fniyaysociety.com%2F&amp;src=sdkpreparse"><svg class="svg-share" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 33.85 33.85"><g class="g-opacity"><path class="path-white" d="M29.89,0H4A4,4,0,0,0,0,4V29.89a4,4,0,0,0,4,4H29.89a4,4,0,0,0,4-4V4a4,4,0,0,0-4-4Zm1.32,29.89a1.32,1.32,0,0,1-1.32,1.32H22.35V20.43h4.08l.68-4.1H22.35V13.49a2,2,0,0,1,2-2H27V7.41H24.33a6.08,6.08,0,0,0-6.08,6.09v2.83h-4v4.1h4V31.21H4a1.33,1.33,0,0,1-1.33-1.32V4A1.34,1.34,0,0,1,4,2.64H29.89A1.33,1.33,0,0,1,31.21,4Z"/></g></svg></a>
						</div>
					</li>
					<li><a class="icon-twitter" href="#">
						<svg class="svg-share" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 33.85 33.85">
							<g class="g-opacity">
								<path class="path-white" d="M29.09,10.65a9.68,9.68,0,0,1-2.68.74,4.7,4.7,0,0,0,2.05-2.58,9.23,9.23,0,0,1-3,1.13,4.66,4.66,0,0,0-8.07,3.19,4.59,4.59,0,0,0,.11,1.06A13.19,13.19,0,0,1,7.93,9.31a4.74,4.74,0,0,0-.64,2.36,4.67,4.67,0,0,0,2.07,3.88A4.75,4.75,0,0,1,7.25,15v0A4.7,4.7,0,0,0,11,19.61a4.8,4.8,0,0,1-1.22.15,4.24,4.24,0,0,1-.88-.08,4.7,4.7,0,0,0,4.35,3.25,9.36,9.36,0,0,1-5.78,2,8.32,8.32,0,0,1-1.12-.07A13.1,13.1,0,0,0,13.5,27,13.18,13.18,0,0,0,26.77,13.68c0-.21,0-.41,0-.61a9.1,9.1,0,0,0,2.33-2.42Z"/>
								<path class="path-white" d="M30.77,2a1.08,1.08,0,0,1,1.08,1.09V30.77a1.08,1.08,0,0,1-1.08,1.08H3.09A1.08,1.08,0,0,1,2,30.77V3.09A1.09,1.09,0,0,1,3.09,2H30.77m0-2H3.09A3.09,3.09,0,0,0,0,3.09V30.77a3.08,3.08,0,0,0,3.09,3.08H30.77a3.08,3.08,0,0,0,3.08-3.08V3.09A3.08,3.08,0,0,0,30.77,0Z"/>
							</g>
						</svg>
					</a></li>
					<li><a class="icon-link" href="#">
						<svg class="svg-share" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34">
							<g class="g-opacity">
								<path class="path-white" d="M34,17.2V28.69A5.31,5.31,0,0,1,28.69,34H5.31A5.31,5.31,0,0,1,0,28.69V5.31A5.31,5.31,0,0,1,5.31,0H16.87a1.33,1.33,0,0,1,0,2.66H5.31A2.65,2.65,0,0,0,2.66,5.31V28.69a2.65,2.65,0,0,0,2.65,2.65H28.69a2.65,2.65,0,0,0,2.65-2.65V17.2a1.33,1.33,0,1,1,2.66,0ZM18.14,12.34l.08.15c.11.15.34.51.61.87l-4.36,4.36a1.33,1.33,0,1,0,1.88,1.88l2.4-2.41c.06.11.11.21.16.32a3.47,3.47,0,0,1,.36,1.5A6.5,6.5,0,0,1,17,23.35l-.13.11-.13.14-.11.12A6.5,6.5,0,0,1,12.32,26a3.58,3.58,0,0,1-2.11-.7l-.08-.06L10,25.1a5.15,5.15,0,0,1-.56-.5A4,4,0,0,1,8.1,21.75a6.56,6.56,0,0,1,2.25-4.35l.12-.1a1.85,1.85,0,0,0,.14-.14l.1-.12a7.58,7.58,0,0,1,3.35-2.13,1.33,1.33,0,1,0-.63-2.58A10.14,10.14,0,0,0,8.8,15.19l-.06.07-.08.09-.09.08-.07.06a9.1,9.1,0,0,0-3,6.26,6.57,6.57,0,0,0,2.11,4.73,7.11,7.11,0,0,0,.83.73l0,0,.12.1a6.24,6.24,0,0,0,3.77,1.28,9.1,9.1,0,0,0,6.25-3.05l.07-.08.07-.08.09-.08.07-.07A9.08,9.08,0,0,0,21.93,19a6.07,6.07,0,0,0-.63-2.66v0a12.3,12.3,0,0,0-.6-1.08L25,11A1.33,1.33,0,0,0,23.1,9.09l-2.37,2.37-.23-.34a3.47,3.47,0,0,1-.33-1.45,6.56,6.56,0,0,1,2.25-4.34l.12-.1a1.85,1.85,0,0,0,.14-.14l.1-.12a6.56,6.56,0,0,1,4.35-2.25,3.55,3.55,0,0,1,2.11.71l.07.06.13.1c.19.15.38.31.57.49a4,4,0,0,1,1.33,2.86,6.5,6.5,0,0,1-2.24,4.34l-.13.11-.13.13-.11.13a7.22,7.22,0,0,1-3.44,2.07,1.33,1.33,0,0,0,.28,2.63l.28,0a9.76,9.76,0,0,0,4.79-2.83.23.23,0,0,0,.07-.07l.08-.08.08-.08a.23.23,0,0,0,.07-.07A9.08,9.08,0,0,0,34,6.94a6.54,6.54,0,0,0-2.12-4.73,7.94,7.94,0,0,0-.82-.73l0,0-.12-.1A6.28,6.28,0,0,0,27.13.07a9.1,9.1,0,0,0-6.26,3.05l-.06.07-.08.09-.09.08-.07.06a9.08,9.08,0,0,0-3.05,6.26,6.2,6.2,0,0,0,.62,2.66Z"/>
							</g>
						</svg>
					</a></li>
				</ul>
			</div>	

			<!-- <section id="users-list" class="sec-area">
				<h2 class="page-title"><span>คนที่ชอบเรื่องนี้</span></h2>
				
			</section> -->		

			<section id="recent" class="sec-area">
				<h2 class="page-title"><span>เรื่องอื่นๆ ของไรเตอร์</span></h2>
				<?php include('themes/niyaysociety2020/content/recent.php'); ?>
			</section>

			<section id="comment" class="sec-area">
				<h2 class="page-title"><span>แสดงความคิดเห็น</span></h2>
				<div class="guestbook"><?php
					$a = new GlobalArea('Main Guest Book');
					$a->setBlockLimit(1);
					$a->display(); ?>
				</div>
			</section>
			<!-- /#guestbook -->
		</div>
	</article>

</main>

<?php $this->inc('elements/footer.php'); ?>
