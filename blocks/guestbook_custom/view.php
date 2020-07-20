<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<link rel="stylesheet" href="/blocks/guestbook/css/samples.css">
<link rel="stylesheet" href="/blocks/guestbook/toolbarconfigurator/lib/codemirror/neo.css">

<?php $c = Page::getCurrentPage(); ?>
<!-- <h2 class="guestBook-title"><?php //echo $controller->title?></h2> -->
<?php if($invalidIP) { ?>
<div class="ccm-error"><p><?php echo $invalidIP?></p></div>
<?php } ?>
<?php
$u = new User();
if (!$dateFormat) {
	$dateFormat = t('M jS, Y');
}
$posts = $controller->getEntries('DESC');
$bp = $controller->getPermissionObject(); 
$dh = Loader::helper('date'); 
$av = Loader::helper('concrete/avatar');
$user = UserInfo::getByID($u->getUserID());


 if (isset($response)) { ?>
	<?php echo '<div class="alert alert-success">'.$response.'</div>'; ?>
<?php } ?>
<?php if($controller->displayGuestBookForm) { ?>
	<?php
	if( $controller->authenticationRequired && !$u->isLoggedIn() ){ ?>
		<div class="alert alert-warning">กรุณา<a data-toggle="modal" data-target="#modalLogin">เข้าสู่ระบบ</a>เพื่อแสดงความคิดเห็น</div>
	<?php }else{ ?>
		<a name="guestBookForm-<?php echo $controller->bID?>"></a>

		<div id="guestBook-formBlock-<?php echo $controller->bID?>" class="guestBook-formBlock">

			<form method="post" action="<?php echo $this->action('form_save_entry', '#guestBookForm-'.$controller->bID)?>">
			<?php if(isset($Entry->entryID)) { ?>
				<input type="hidden" name="entryID" value="<?php echo $Entry->entryID?>" />
			<?php } ?>
			
			<?php if(!$controller->authenticationRequired){ ?>
				<div class="form-group">
					<?php echo (isset($errors['name'])?"<span class=\"error\">".$errors['name']."</span>":"")?>
					<input placeholder="Name" type="text" class="form-control" name="name" value="<?php echo $Entry->user_name ?>" />
				</div>

				<div class="form-group">
					<?php echo (isset($errors['email'])?"<span class=\"error\">".$errors['email']."</span>":"")?>
					<input placeholder="Email" type="email" class="form-control" name="email" value="<?php echo $Entry->user_email ?>" /> <span class="note">(<?php echo t('อีเมล์ของคุณจะไม่แสดงให้คนอื่นเห็น')?>)</span>
				</div>
			<?php } ?>
			
			<?php echo (isset($errors['commentText'])?"<br /><span class=\"error\">".$errors['commentText']."</span>":"")?>

			<textarea id="editor" placeholder="แสดงความคิดเห็น" name="commentText" class="form-control" rows="3"><?php echo $Entry->commentText ?></textarea>

			<?php
			if($controller->displayCaptcha) {
							 
				
				$captcha = Loader::helper('validation/captcha');				
					$captcha->label();
					$captcha->showInput();
				$captcha->display();

				echo isset($errors['captcha'])?'<span class="error">' . $errors['captcha'] . '</span>':'';
				
			}
			?>
			<div class="btn-wrapper">
				<button class="btn-gradient" type="submit" name="Post Comment"><?php echo t('แสดงความคิดเห็น')?></button>
			</div>
			</form>
		</div>
	<?php } ?>
<?php } ?>

<?php $count = 0; foreach($posts as $p) { $count++; } ?>
<h3 class="title-comment"><span class="icon-comment"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.67 17.81">
	<g class="svg-comment">
		<path d="M13.38,12.09a8.07,8.07,0,0,0,3.24-2.36,5,5,0,0,0,0-6.5A7.89,7.89,0,0,0,13.38.87,11.35,11.35,0,0,0,8.91,0,11.4,11.4,0,0,0,4.43.87,7.89,7.89,0,0,0,1.19,3.23,5.12,5.12,0,0,0,0,6.48,5,5,0,0,0,.9,9.31a7.36,7.36,0,0,0,2.47,2.24c-.09.2-.17.39-.26.56a3.08,3.08,0,0,1-.32.48c-.12.16-.22.28-.28.37s-.18.21-.33.37-.25.27-.3.32l0,.06-.05.06s0,0-.05.06l-.05.07,0,.07a.19.19,0,0,0,0,.07.25.25,0,0,0,0,.08.28.28,0,0,0,0,.09.4.4,0,0,0,.15.26.37.37,0,0,0,.26.1h0a9.63,9.63,0,0,0,1.08-.2,10.78,10.78,0,0,0,3.52-1.62,12.24,12.24,0,0,0,2.23.2,11.34,11.34,0,0,0,4.47-.86Z"/>
		<path d="M21.77,12.56a4.93,4.93,0,0,0-.05-5.75,7.41,7.41,0,0,0-2.58-2.26,6.52,6.52,0,0,1-.56,5.14,8.38,8.38,0,0,1-2.42,2.68A11.29,11.29,0,0,1,12.82,14a13.4,13.4,0,0,1-3.91.57c-.26,0-.63,0-1.12-.05a10.6,10.6,0,0,0,6,1.67A12.24,12.24,0,0,0,16,16a10.78,10.78,0,0,0,3.52,1.62,9.43,9.43,0,0,0,1.09.2.34.34,0,0,0,.27-.09.45.45,0,0,0,.17-.27.11.11,0,0,1,0-.09s0,0,0-.08l0-.07,0-.07a.5.5,0,0,0,0-.07s0-.05-.05-.06L20.84,17l-.05-.06-.29-.32a2.83,2.83,0,0,1-.33-.37l-.29-.37a2.46,2.46,0,0,1-.31-.48,5.85,5.85,0,0,1-.26-.56,7.5,7.5,0,0,0,2.46-2.23Z"/>
	</g></svg></span><?php echo $count; ?> Comments
</h3>
<div id="comments" class="comments">
<?php 
	foreach($posts as $p) { ?>
	<?php if($p['approved'] || $bp->canWrite()) { ?>
	<div class="comment">
		<div class="guestBook-avater">
			<?php
			if( intval($p['uID']) ){
				$ui = UserInfo::getByID(intval($p['uID']));
				// if (is_object($ui)) {
				// 	echo $ui->getUserName();
				// }
				$avatarImgPath = $av->getImagePath( $ui, false );
					if(!empty($avatarImgPath)){ ?>
						<a href="/profile/view/<?php echo $ui->getUserID(); ?>"><img src="<?php echo $avatarImgPath; ?>" alt="<?php echo $ui->getUserName(); ?>" /></a><?php
					}else{ ?>
						<a href="/profile/view/<?php echo $ui->getUserID(); ?>"><img src="<?php echo $this->getThemePath(); ?>/img/no_img.png" alt="no-image"></a><?php
					}
				}else{ ?>
					<?php // echo $p['user_name']; ?>
					<img src="<?php echo $this->getThemePath(); ?>/img/no_img.png" alt="no-image">
				<?php } ?>
		</div>
		<div class="guestBook-entry<?php if ($c->getVersionObject()->getVersionAuthorUserName() == $u->getUserName()) {?> authorPost <?php }?>">
			<?php if($bp->canWrite()) { ?> 
				<div class="guestBook-manage-links">
					<a href="<?php echo $this->action('loadEntry')."&entryID=".$p['entryID'];?>#guestBookForm"><?php echo t('Edit')?></a> | 
					<a href="<?php echo $this->action('removeEntry')."&entryID=".$p['entryID'];?>" onclick="return confirm('<?php echo t("Are you sure you would like to remove this comment?")?>');"><?php echo t('Remove')?></a> |
					<?php if($p['approved']) { ?>
						<a href="<?php echo $this->action('unApproveEntry')."&entryID=".$p['entryID'];?>"><?php echo t('Un-Approve')?></a>
						<?php } else { ?>
						<a href="<?php echo $this->action('approveEntry')."&entryID=".$p['entryID'];?>"><?php echo t('Approve')?></a>
					<?php } ?>
				</div>
			<?php } ?>

			<div class="contentByLine">
				<div class="userName">
					<?php
					if( intval($p['uID']) ){
						$ui = UserInfo::getByID(intval($p['uID']));
						if (is_object($ui)) {
							echo '<a href="/profile/view/'.$p['uID'].'">'.$ui->getUserName().'</a>';
						}
					}else echo $p['user_name']; ?>
				</div> 
				<div class="contentDate">
					<?php echo $dh->date($dateFormat,strtotime($p['entryDate']));?>
				</div>
			</div>
			<?php echo nl2br($p['commentText'])?>
		</div>
	</div>
	<?php } ?>
<?php } ?>
<?php if(empty($posts)){ ?>
	<div class="no-comment">ยังไม่มีคอมเมนต์</div>
<?php } ?>
</div>

<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script>
	ClassicEditor
		.create( document.querySelector( '#editor' ))
		.catch( error => {
				console.error( error );
		} );
</script> -->

<script src="/blocks/guestbook/ckeditor.js"></script>
<script src="/blocks/guestbook/js/sample.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		initSample();
	});
</script>

