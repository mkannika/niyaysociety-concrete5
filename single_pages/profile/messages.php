<?php defined('C5_EXECUTE') or die("Access Denied.");

$dh = Loader::helper('date');
/* @var $dh DateHelper */
global $u;
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
					echo '<a href="/profile/view/'.$userID.'"><img src="/themes/niyaysociety2020/img/no_img.png" alt="'.$userOwner.'"></a>';
				} ?>
			</div><!--/.avatar-->
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
				<?php if($pageOwner->getUserID() != $u->getUserID()){ ?>
				<li><a class="icon-dash" href="/profile/view/">กลับไปยังหน้าสมาชิก</a></li>
				<?php }elseif($pageOwner->getUserID() === $u->getUserID()){ ?>
				<li><a class="icon-edit" href="/profile/edit/">แก้ไขข้อมูลส่วนตัว</a></li>
				<?php } ?>
				<li><a class="icon-signout" href="/login/logout/">ลงชื่อออก</a></li>
			</ul>
		</div>
	</aside>

	<div id="content" class="content-area">
		<div class="private-messages">
		<?php //echo $error->output(); ?>
		<?php switch($this->controller->getTask()) {

			case 'view_message': ?>

				<section id="sec-msg">
					<div><a href="<?php echo $this->url('/profile/messages', 'view_mailbox', $box)?>">&lt;&lt; <?php echo t('Back to Mailbox')?></a></div><br/>

					<h1><?php echo t('Message Details')?></h1>
					<form method="post" action="<?php echo $this->action('reply', $box, $msg->getMessageID())?>">
					<div class="ccm-profile-detail">
						<div class="ccm-profile-section">
							<div class="table-responsive">
								<table border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td valign="top" class="ccm-profile-message-from"><a href="<?php echo $this->url('/profile', 'view', $msg->getMessageRelevantUserID())?>"><?php echo $av->outputUserAvatar($msg->getMessageRelevantUserObject())?></a>
									<a href="<?php echo $this->url('/profile', 'view', $msg->getMessageRelevantUserID())?>"><?php echo $msg->getMessageRelevantUserName()?></a>

									</td>
									<td valign="top">
										<h2><?php echo $subject?></h2>
										<div><?php echo $dateAdded?></div>
									</td>
								</tr>
								</table>
							</div>
						</div>

						<?php echo $msg->getFormattedMessageBody()?>
					</div>
					<div class="ccm-profile-buttons">
						<?php if ($msg->getMessageAuthorID() != $ui->getUserID()) { ?>
							<?php
							$mui = $msg->getMessageRelevantUserObject();
							if (is_object($mui)) {
								if ($mui->getUserProfilePrivateMessagesEnabled()) { ?>
									<?php echo $form->submit('button_submit', t('Reply'))?>
								<?php }

							}?>
						<?php } ?>
						<?php echo $form->submit('button_delete', t('Delete'), array('onclick' => 'if(confirm(\'' . t('Delete this message?') . '\')) { window.location.href=\'' . $deleteURL . '\'}; return false'))?>
						<?php echo $form->submit('button_cancel', t('Back'), array('onclick' => 'window.location.href=\'' . $backURL . '\'; return false'))?>
					</div>
					</form>
				</section><?php

			break;
			case 'view_mailbox': ?>

				<section id="sec-mailbox">
					<div><a href="<?php echo $this->url('/profile/messages')?>">&lt;&lt; <?php echo t('Back to Mailbox List')?></a></div><br/>
					<div class="pagelist-author table-responsive">
						<table class="table table-condensed">
						<tr>
							<th><?php if ($mailbox == 'sent') { ?><?php echo t('To')?><?php } else { ?><?php echo t('From')?><?php } ?></th>
							<th><?php echo t('Subject')?></th>
							<th><?php echo t('Sent At')?></th>
							<th><?php echo t('Status')?></th>
						</tr>



						<?php
							if (is_array($messages)) {
								foreach($messages as $msg) { ?>

								<tr>
									<td class="ccm-profile-message-from">
									<a href="<?php echo $this->url('/profile', 'view', $msg->getMessageRelevantUserID())?>"><?php echo $av->outputUserAvatar($msg->getMessageRelevantUserObject())?></a>
									<a href="<?php echo $this->url('/profile', 'view', $msg->getMessageRelevantUserID())?>"><?php echo $msg->getMessageRelevantUserName()?></a>
									</td>
									<td class="ccm-profile-messages-item-name"><a href="<?php echo $this->url('/profile/messages', 'view_message', $mailbox, $msg->getMessageID())?>"><?php echo $msg->getFormattedMessageSubject()?></a></td>
									<td style="white-space: nowrap"><?php echo $dh->formatDateTime($msg->getMessageDateAdded(), true, false)?></td>
									<td><?php echo $msg->getMessageStatus()?></td>
								</tr>



							<?php } ?>
						<?php } else { ?>
							<tr>
								<Td colspan="4"><?php echo t('No messages found.')?></td>
							</tr>
						<?php } ?>
						</table>
					</div>
				</section><?php

			$messageList->displayPaging();
			break;
			case 'reply_complete': ?>

				<section id="sec-reply">
					<h2><?php echo t('Reply Sent.')?></h2>
					<a href="<?php echo $this->url('/profile/messages', 'view_message', $box, $msgID)?>"><?php echo t('Return to Message.')?></a>
				</section><?php

			break;
			case 'send_complete': ?>

				<section id="sec-complete">
					<div class="inner">
						<div class="sec-title"><?php echo t('ส่งข้อความถึงคุณ')?><span><?php echo $recipient->getUserName()?></span><?php echo t('เรียบร้อย')?></div>	
						<div class="btn-back">
							<a class="btn-gradient" href="<?php echo $this->url('/profile', 'view', $recipient->getUserID())?>"><?php echo t('กลับไปยังโปรไฟล์ของคุณ ')?><?php echo $recipient->getUserName()?></a>
						</div>
					</div>
				</section>

			<?php
				break;
			case 'over_limit': ?>
				
				<section id="sec-error">
					<h2><?php echo t('Woops!')?></h2>
					<p><?php echo t("You've sent more messages than we can handle just now, that last one didn't go out.
					We've notified an administrator to check into this.
					Please wait a few minutes before sending a new message."); ?></p>
				</section>

				<?php break;
			case 'send':
			case 'reply':
			case 'write': ?>

				<section id="sec-compose">
					<div id="ccm-profile-message-compose">
					<form method="post" action="<?php echo $this->action('send')?>">

					<?php echo $form->hidden("uID", $recipient->getUserID())?>
					<?php if ($this->controller->getTask() == 'reply') { ?>
						<?php echo $form->hidden("msgID", $msgID)?>
						<?php echo $form->hidden("box", $box)?>
					<?php
						$subject = t('Re: %s', $text->entities($msgSubject));
					} else {
						$subject = $text->entities($msgSubject);
					}
					?>

					<h2 class="page-title"><span>ส่งข้อความ</span></h2>
					<div class="ccm-profile-section">
						<div class="sec-title"><?php echo t('ส่งข้อความถึงคุณ')?><span><?php echo $recipient->getUserName()?></span></div>	
					</div>

					<div class="ccm-profile-detail">
						<div class="ccm-profile-section">
							<?php //echo $form->label('subject', t('Subject'))?>
							<div><?php echo $form->text('msgSubject', $subject, array('placeholder' => 'หัวข้อเรื่อง'));?></div>
						</div>

						<div class="ccm-profile-section-bare">
							<?php //echo $form->label('body', t('Message'))?> <span class="ccm-required">*</span>
							<div><?php echo $form->textarea('msgBody', $msgBody, array('placeholder' => 'ข้อความ')); ?></div>
						</div>
					</div>

					<div class="ccm-profile-buttons">
						<?php echo $form->submit('button_submit', t('ส่งข้อความ'), array('class' => 'btn-gradient'))?>
						<?php echo $form->submit('button_cancel', t('ยกเลิก'), array('class' => 'btn-gradient', 'onclick' => 'window.location.href=\'' . $backURL . '\'; return false'))?>
					</div>

					<?php echo $vt->output('validate_send_message');?>

					</form>
					</div>
				</section>


			<?php break;

			default:
				// the inbox and sent box and other controls ?>
			<div class="pagelist-author table-responsive">
				<table class="table table-condensed">
				<tr>
					<th><?php echo t('Mailbox')?></th>
					<th><?php echo t('Messages')?></th>
					<th><?php echo t('Latest Message')?></th>
				</tr>
				<tr>
					<td class="ccm-profile-messages-item-name"><a href="<?php echo $this->action('view_mailbox', 'inbox')?>"><?php echo t('Inbox')?></a></td>
					<td><?php echo $inbox->getTotalMessages()?></td>
					<td class="ccm-profile-mailbox-last-message"><?php
					$msg = $inbox->getLastMessageObject();
					if (is_object($msg)) {
						print t('<strong>%s</strong>, sent by %s on %s', $msg->getFormattedMessageSubject(), $msg->getMessageAuthorName(), $dh->formatDateTime($msg->getMessageDateAdded(), true, false));
					}
					?></td>
				</tr>
				<tr>
					<td class="ccm-profile-messages-item-name"><a href="<?php echo $this->action('view_mailbox', 'sent')?>"><?php echo t('Sent Messages')?></a></td>
					<td><?php echo $sent->getTotalMessages()?></td>
					<td class="ccm-profile-mailbox-last-message"><?php
					$msg = $sent->getLastMessageObject();
					if (is_object($msg)) {
						print t('<strong>%s</strong>, sent by %s on %s', $msg->getFormattedMessageSubject(), $msg->getMessageAuthorName(), $dh->formatDateTime($msg->getMessageDateAdded(), true, false));
					}
					?>
				</td>
				</tr>
				</table>
			</div>

			<?php
				break;
		} ?>
		</div>
	</div>
</main>
