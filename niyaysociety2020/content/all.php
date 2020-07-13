<div class="grid row">
<?php
	// Global
	Loader::model('page_counter');
	$th = Loader::helper('text');
	$ih = Loader::helper('image');
	$nh = Loader::helper('navigation');
	$date = Loader::helper("date");
	$db = Loader::db();
	$pages = $db->query("SELECT * FROM `VoteScore` ORDER BY score DESC");
	$i = 0;

	$count = 0;
	$date = Loader::helper("date");
	$page_id = Page::getByID(128);
	$sub_page_ids = $page_id->getCollectionChildrenArray(1);
	$pl = new PageList();
	$pl->filterByParentID($sub_page_ids);
	$pl->sortBy('cvDateCreated', 'desc');
	$pages = $pl->getPage();

	foreach ($pages as $page):

	if($count != 12):

	$title = $th->entities($page->getCollectionName());
	$url = $nh->getLinkToCollection($page);
	$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
	$target = empty($target) ? '_self' : $target;
	$description = $page->getCollectionDescription();
	$description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
	$description = $th->entities($description);

	$img = $page->getAttribute('thumbnail');
	$thumb = $ih->getThumbnail($img, 290, 435, true);

	//Other useful page data...
	$date = Loader::helper('date')->formatDate($page->getCollectionDatePublic(), true);
	$last_edited_by = $page->getVersionObject()->getVersionAuthorUserName();
	$last_edited = $page->getCollectionDateLastModified('d.m.Y, H:i');
	$original_author = Page::getByID($page->getCollectionID(), 1)->getVersionObject()->getVersionAuthorUserName();
	$category = Page::getByID($page->getCollectionParentID());

	$userID = $page->getCollectionUserID();
	$pageOwner = UserInfo::getByID($userID);

	$color = "";
	$status = $page->getAttribute('status');
	if($status == 'ยังไม่จบ'){ $color = "incomplete"; }
	if($status == 'จบแล้ว' ){ $color = "complete"; }
	$category = Page::getByID($page->getCollectionParentID());
	$desc = $page->getAttribute('meta_description');
	$db= Loader::db();
	$cID = $page->getCollectionID();
	$score = 0;
	$getScore = $db->GetOne("SELECT `score` FROM `VoteScore` WHERE `cID` = $cID");
	if($getScore != ''){
		$score = intval($getScore);
	}else{
		$score = 0;
	}
	$date = strtotime($page->getCollectionDateLastModified('Y-m-d H:i:s'));
	?>

	<div class="item-work item-isotope" 
	data-score="<?php echo $score; ?>" data-view="<?php echo PageCounter::getTotalPageViewsForPageID($page->cID); ?>" data-date="<?php echo $date; ?>">
		<a class="inner" href="<?php echo $url ?>">
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
					<div class="cat"><?php echo $category->getCollectionName(); ?></div>
					<div class="d-flex">
						<div class="rating"><img src="<?php echo $this->getThemePath(); ?>/img/rating.png"></div>
						<div class="vote"><span class="num-vote"><?php echo $score; ?></span> คะแนน</div>
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
			<div class="work-desc"><?php if($desc != ''){
				echo $desc;
			}else{
				echo '';
			} ?></div>
		</a>
	</div>
	<?php $count++; endif; endforeach; ?>
</div>