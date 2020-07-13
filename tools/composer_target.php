<?php defined('C5_EXECUTE') or die("Access Denied.");
$navigation = Loader::helper('navigation');
$th = Loader::helper('text');
$sh = Loader::helper('concrete/dashboard');



$isLoggedIn = User::isLoggedIn();
$user = new User();

$user_login = $user->getUserID();


if (!$sh->canAccessComposer()) {
	die(t('Access Denied'));
}

$entry = ComposerPage::getByID($_REQUEST['cID'], 'RECENT');
if (!is_object($entry)) {
	die(t('Access Denied'));
}

$ct = CollectionType::getByID($entry->getCollectionTypeID());
$function = 'ccm_composerSelectParentPage';
if ($_REQUEST['submitOnChoose']) {
	$function = 'ccm_composerSelectParentPageAndSubmit';
}

switch($ct->getCollectionTypeComposerPublishMethod()) {
	case 'PAGE_TYPE': 
		Loader::model('page_list');
		$pages = array();
		$pl = new PageList();
		//$pl->sortByName();
		$pl->sortByPublicDateDescending();
		$pl->filterByCollectionTypeID($ct->getCollectionTypeComposerPublishPageTypeID());
		$pages = $pl->get();

		?>
	
	<!--<h1><?php echo t("Where do you want to publish this page?")?></h1>-->
	<h1><?php echo t("คุณต้องการเพิ่มลงที่ไหน?")?></h1>
	<ul class="item-select-list">
	<?php foreach($pages as $p) { 
		$trail = $navigation->getTrailToCollection($p);
		$crumbs = array();
		if(is_array($trail) && count($trail)) {
			$trail = array_reverse($trail,false);
			foreach($trail as $t) { 
				$crumbs[] = $th->shortText($t->getCollectionName(),10);
			}
		}

		$userID = $p->getCollectionUserID();


		// If not `admin`
		if($user_login != '1'){

			// Show just pages's user.
			if($user_login == $userID){ ?>

			<li class="item-select-page"><a href="javascript:void(0)" onclick="<?php echo $function?>(<?php echo $p->getCollectionID()?>)"><?php echo $p->getCollectionName()?></a>
				<div class="ccm-note" style="padding-left: 8px;"><?php echo implode(" &gt; ",$crumbs)?></div>
			</li>

			<?php }else{ ?>

				<?php // if dialog `เขียนเรื่องใหม่` show these pages. ?>

				<?php if($p->getCollectionID() == 130 || $p->getCollectionID() == 131 || $p->getCollectionID() == 132 || $p->getCollectionID() == 133 || $p->getCollectionID() == 135 || $p->getCollectionID() == 136 || $p->getCollectionID() == 137 || $p->getCollectionID() == 138 || $p->getCollectionID() == 234 ){ ?>
				<li class="item-select-page"><a href="javascript:void(0)" onclick="<?php echo $function?>(<?php echo $p->getCollectionID()?>)"><?php echo $p->getCollectionName()?></a>
					<div class="ccm-note" style="padding-left: 8px;"><?php echo implode(" &gt; ",$crumbs)?></div>
				</li>
				<?php } ?>

			<?php } ?>

		<?php } else { ?>

			<li class="item-select-page"><a href="javascript:void(0)" onclick="<?php echo $function?>(<?php echo $p->getCollectionID()?>)"><?php echo $p->getCollectionName()?></a>
				<div class="ccm-note" style="padding-left: 8px;"><?php echo implode(" &gt; ",$crumbs)?></div>
			</li>

		<?php } ?>

	<?php } ?>
	</ul>
	
	<?php
		break;
	case 'CHOOSE':
		$args['sitemapCombinedMode'] = $sitemapCombinedMode;
		$args['select_mode'] = 'select_page';
		$args['callback'] = $function;
		$args['display_mode'] = 'full';
		$args['instance_id'] = time();
		Loader::element('dashboard/sitemap', $args);	
		break;
}

exit;