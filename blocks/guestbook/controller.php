<?php
	defined('C5_EXECUTE') or die("Access Denied.");
	class GuestbookBlockController extends Concrete5_Controller_Block_Guestbook {		
		/** 
	    * gets a list of all guestbook entries for the current block
	    *
	    * @param string $order ASC|DESC
	    * @return array
	   */
	   function getEntries($order = 'DESC') {  // Changed from ASC
	      $bo = $this->getBlockObject();
	      $c = Page::getCurrentPage();
	      return GuestBookBlockEntry::getAll($this->bID, $c->getCollectionID(), $order);
	   }
	}
	
	class GuestBookBlockEntry extends Concrete5_Controller_Block_GuestbookEntry {

	
	}