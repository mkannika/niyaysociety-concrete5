<div class="recent-list">
<?php		
$pl = new PageList();
// $pl->filterByKeywords($keywords); 
// $pl->filter(false, '(ak_age = 10 OR ak_age IN (13,17,25) OR ak_age > 23)');
$pl->filterByUserID($userID);
$pl->filterByCollectionTypeHandle('home_fiction');
$pl->sortByPublicDateDescending('desc');
$pages = $pl->getPage();

foreach ($pages as $page):
	$title = $th->entities($page->getCollectionName());
	$url = $nh->getLinkToCollection($page);
	$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
	$target = empty($target) ? '_self' : $target;
	$description = $page->getCollectionDescription();
	$description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
	$description = $th->entities($description);
	$date = Loader::helper('date')->formatDate($page->getCollectionDatePublic(), true);
	$last_edited_by = $page->getVersionObject()->getVersionAuthorUserName();
	$last_edited = $page->getCollectionDateLastModified('d.m.Y, H:i');
	$original_author = Page::getByID($page->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();
	$category = Page::getByID($page->getCollectionParentID());

	$userID = $page->getCollectionUserID();
	$pageOwner = UserInfo::getByID($userID);

	$cID = $page->getCollectionID();
	$score = 0;
	$getScore = $db->GetOne("SELECT `score` FROM `VoteScore` WHERE `cID` = $cID");
	if($getScore != ''){
		$score = intval($getScore);
	}else{
		$score = 0;
	}
	$color = "";
	$status = $page->getAttribute('status');
	if($status == 'ยังไม่จบ'){ $color = "incomplete"; }
	if($status == 'จบแล้ว' ){ $color = "complete"; }

	$img = $page->getAttribute('thumbnail');
	$thumb = $ih->getThumbnail($img, 290, 435, true); ?>
	<div class="item-work"><a class="inner" href="<?php echo $url ?>">
		<div class="d-flex">
			<div class="cover-work">
			<?php if( $thumb->src != "" ) { ?>
				<img src="<?php echo $thumb->src; ?>" alt="<?php echo $title ?>">
			<?php } else { ?>
				<img src="<?php echo $this->getThemePath(); ?>/img/no_cover.jpg" alt="<?php echo $title ?>">
			<?php } ?>
			</div>
			<div class="info-work">
				<h3><?php echo $title; ?></h3>
				<div class="cat">
					<div class="d-flex">
						<span class="info-cat"><?php echo $category->getCollectionName(); ?></span>
						<span class="info-author">
							<?php if($pageOwner->getAttribute('penname') != ""){
								echo $pageOwner->getAttribute('penname');
							} else {
								echo $original_author;
							} ?>
						</span>
					</div>
				</div>
				<div class="d-flex">
					<div class="rating"><img src="/themes/niyaysociety2020/img/rating.png"></div>
					<div class="vote"><span class="num-score"><?php echo $score; ?></span> คะแนน</div>
					<ul class="list-info">
						<li class="info-view">
							<span class="title">ยอดคนอ่าน</span>
							<span><span class="view-number"><?php echo PageCounter::getTotalPageViewsForPageID($page->cID); ?></span> วิว</span>
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
	</a></div>
<?php endforeach; ?>
</div>