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

<?php 
foreach($posts as $p) { ?>
	<?php if($p['approved'] || $bp->canWrite()) { ?>
    
    <div class="panel panel-default">
	<div class="panel-body"><div class="guestBook-entry<?php if ($c->getVersionObject()->getVersionAuthorUserName() == $u->getUserName()) {?> authorPost <?php }?>">
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
							echo $ui->getUserName();
						}
					}else echo $p['user_name']; ?>
				</div> 
				<div class="contentDate">
					<?php echo $dh->date($dateFormat,strtotime($p['entryDate']));?>
				</div>
			</div>
			<?php echo nl2br($p['commentText'])?>
	</div></div>
	</div>
	<?php } ?>
<?php } ?>

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

