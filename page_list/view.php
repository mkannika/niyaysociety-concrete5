<?php
defined('C5_EXECUTE') or die("Access Denied.");

$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
Loader::model('page_counter');
$th = Loader::helper('text');
$ih = Loader::helper('image');

//Note that $nh (navigation helper) is already loaded for us by the controller (for legacy reasons)
?>

<div class="grid row">

	<?php foreach ($pages as $page):

		// Prepare data for each page being listed...
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


		/* CUSTOM ATTRIBUTE EXAMPLES:
		 * $example_value = $page->getAttribute('example_attribute_handle');
		 *
		 * HOW TO USE IMAGE ATTRIBUTES:
		 * 1) Uncomment the "$ih = Loader::helper('image');" line up top.
		 * 2) Put in some code here like the following 2 lines:
		 *      $img = $page->getAttribute('example_image_attribute_handle');
		 *      $thumb = $ih->getThumbnail($img, 64, 9999, false);
		 *    (Replace "64" with max width, "9999" with max height. The "9999" effectively means "no maximum size" for that particular dimension.)
		 *    (Change the last argument from false to true if you want thumbnails cropped.)
		 * 3) Output the image tag below like this:
		 *		<img src="<?php echo $thumb->src ?>" width="<?php echo $thumb->width ?>" height="<?php echo $thumb->height ?>" alt="" />
		 *
		 * ~OR~ IF YOU DO NOT WANT IMAGES TO BE RESIZED:
		 * 1) Put in some code here like the following 2 lines:
		 * 	    $img_src = $img->getRelativePath();
		 * 	    list($img_width, $img_height) = getimagesize($img->getPath());
		 * 2) Output the image tag below like this:
		 * 	    <img src="<?php echo $img_src ?>" width="<?php echo $img_width ?>" height="<?php echo $img_height ?>" alt="" />
		 */

		/* End data preparation. */

		/* The HTML from here through "endforeach" is repeated for every item in the list... */ ?>

		<div class="item-work item-isotope" data-score="<?php echo $score; ?>" data-view="<?php echo PageCounter::getTotalPageViewsForPageID($page->cID); ?>" data-date="<?php echo $date; ?>">
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
						<div class="vote"><span class="num-score"><?php echo $score; ?></span> คะแนน</div>
						<ul class="list-info">
						<li class="info-view">
							<span class="title">ยอดคนอ่าน</span>
							<span><span class="num-view"><?php echo PageCounter::getTotalPageViewsForPageID($page->cID); ?></span> วิว</span>
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

	<?php endforeach; ?>


	<?php if ($showRss): ?>
		<div class="ccm-page-list-rss-icon">
			<a href="<?php echo $rssUrl ?>" target="_blank"><img src="<?php echo $rssIconSrc ?>" width="14" height="14" alt="<?php echo t('RSS Icon') ?>" title="<?php echo t('RSS Feed') ?>" /></a>
		</div>
		<link href="<?php echo BASE_URL.$rssUrl ?>" rel="alternate" type="application/rss+xml" title="<?php echo $rssTitle; ?>" />
	<?php endif; ?>

</div><!-- end .ccm-page-list -->


<?php if ($showPagination): ?>
	<div id="pagination">
		<div class="ccm-spacer"></div>
		<div class="ccm-pagination">
			<span class="ccm-page-left"><?php echo $paginator->getPrevious('&laquo; ' . t('Previous')) ?></span>
			<?php echo $paginator->getPages() ?>
			<span class="ccm-page-right"><?php echo $paginator->getNext(t('Next') . ' &raquo;') ?></span>
		</div>
	</div>
<?php endif; ?>
