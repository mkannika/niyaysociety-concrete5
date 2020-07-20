<?php      defined('C5_EXECUTE') or die("Access Denied."); ?>
<div id="ccm-profile-wrapper" class="test">
   <?php Loader::element('profile/sidebar', array('profile'=> $profile)); ?>    
    <div id="ccm-profile-body">	
        <h1><?php     echo t('My Bookmarks') ?></h1>
        <?php     
		if( !$rows ){ ?>
			<div style="padding:16px 0px;">
				<?php     echo t('No Bookmarks found.')?>
			</div>
		<?php      
		}else {?>
			<table><tr><th><?php      echo t('Page');?></th><th><?php      echo t('Description');?></th><th><?php      echo t('Options');?></th></tr>
			<?php      foreach($rows as $row){ 
				echo '<tr>';
				echo '<td><a href="'.$row['url'].'" rel="nofollow">'.$row['name'].'</a></td>';
				echo '<td>'.$row['description'].'</td>';
				echo '<td><form method="post" action="'.$this->action('delete').'" >';
				echo '<input type="hidden" name="uID" value="'.$row['uID'].'"/><input type="hidden" name="cID" value="'.$row['cID'].'"/><input type="submit" value="'.t('Delete').'"/>';
				echo '</form></td>';
				echo '</tr>';
			}
		} ?>
		</table>	
    </div>
	
	<div class="ccm-spacer"></div>
</div>