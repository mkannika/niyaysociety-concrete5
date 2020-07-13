<?php 
$query_score = "SELECT * FROM `VoteScore` WHERE `cID` = $cID";
$row_score = $db->Execute($query_score);
$checkVoteScore = '';

if($row_score->RecordCount() > 0){
	$checkVoteScore = 'true';
} else {
	$checkVoteScore = 'false';
}

// Message for success
function successMsg($score){

	$scoreVoted = $score;

	$html = '';

	$html .=<<<EOS
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
			<span>ขอบคุณค่ะ!</strong> คุณได้โหวตให้เรื่องนี้ {$scoreVoted}  คะแนน</span>
		</div>
	</div>
	<script type="text/javascript">
	$(function() {
		$(".popup").fadeIn().toggleClass('open');
	});
	</script>
EOS;
	print_r($html);
}

// <script type="text/javascript">
// $(function() {
// 	$('#actionStatus').modal('show');
// });
// </script>

// Message for error
function errorMsg(){

	$html = '';

	$html .=<<<EOS
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
			<span>คุณโหวตเรื่องนี้ไปแล้ว สามารถโหวตได้ใหม่ในอีก 1 ชั่วโมงข้างหน้า</span>
		</div>
	</div>
	<script type="text/javascript">
	$(function() {
		$(".popup").fadeIn().toggleClass('open');
	});
	</script>
EOS;
	print_r($html);

}

/**
 *
 * Form Ranking Submit
 *
 */

if(isset($_POST['submit'])){

	/**

		TODO:
		- Step 1. Check if VoteSystem table has data
		- Step 2. Check if timestamp isn't lower than an hour.
		- Step 3. Check if VoteScore table has page id

	 **/


	// Step 1. Check if VoteSystem table has data

	if( $u -> isLoggedIn () == true ):

	$query = "SELECT * FROM `VoteSystem` WHERE `uID` = $uID AND `cID` = $cID";
	$row = $db->Execute($query);

	if($row->RecordCount() > 0){

		// If database do has data
		$getLastTimeVoted = $db->GetOne("SELECT `timestamp` FROM `VoteSystem` WHERE `uID` = $uID AND `cID` = $cID");

		$nextHour = strtotime($getLastTimeVoted) + 3600;
		$currentTime = strtotime(date('Y-m-d H:i:s'));

		// Step 2. Check if timestamp isn't lower than an hour.
		if($currentTime >= $nextHour){

			//Update data of current page id. Set current `timestamp`
			$q = "UPDATE `VoteSystem` SET `timestamp` = now() WHERE `uID` = $uID AND `cID` = $cID";
			$db->Execute($q);

			//Step 3. Check if VoteScore table has page id
			if( $checkVoteScore == 'true' ){

				$getScore = $db->GetOne("SELECT `score` FROM `VoteScore` WHERE `cID` = $cID");
				$total = $getScore + intval($_POST['vote']);

				$q = "UPDATE `VoteScore` SET `score` = $total WHERE `cID` = $cID";
				$db->Execute($q);
				successMsg($_POST['vote']);

			}else{

				$v = array( $cID, intval($_POST['vote']));
				$q = "INSERT INTO `VoteScore` (`cID`, `score`) VALUES (?, ?)";
				$db->Execute($q, $v);
				successMsg($_POST['vote']);

			}

			successMsg($_POST['vote']);

		}else{

			//Display error message.
			errorMsg();

		}


	} else {

		$v = array( $uID, $cID, $iph->getRequestIP());
		$q = "INSERT INTO `VoteSystem` (`uID`, `cID`, `ipAddress`) VALUES (?, ?, ?)";
		$db->Execute($q, $v);

		//Step 3. Check if VoteScore table has page id
		if( $checkVoteScore == 'true' ){

			$getScore = $db->GetOne("SELECT `score` FROM `VoteScore` WHERE `cID` = $cID");
			$total = $getScore + intval($_POST['vote']);

			$q = "UPDATE `VoteScore` SET `score` = $total WHERE `cID` = $cID";
			$db->Execute($q);
			successMsg($_POST['vote']);

		}else{

			$v = array( $cID, intval($_POST['vote']));
			$q = "INSERT INTO `VoteScore` (`cID`, `score`) VALUES (?, ?)";
			$db->Execute($q, $v);
			successMsg($_POST['vote']);

		}

	}

	endif; //end check loggedin


}//end submit

?>