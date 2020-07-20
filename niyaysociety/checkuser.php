<?php  defined('C5_EXECUTE') or die("Access Denied.");

Loader::model('user_attributes');
$db = Loader::db();

$user_link = $_POST['user_link'];
$user_email = $_POST['user_email'];
$user_first_name = $_POST['user_first_name'];
$user_last_name = $_POST['user_last_name'];
$user_gender = $_POST['user_gender'];
$user_location = $_POST['user_location'];

//$q = "SELECT * FROM `Users` WHERE `uEmail` = '$uEmail'";
//$r = $db->Execute( "SELECT * FROM `tb_facebook` WHERE `FACEBOOK_ID` = '$user_id'" );
$row = $db->Execute( "SELECT * FROM `Users` WHERE `uEmail` = '$user_email'" );
//$row = $db->Execute($query);

if($user_email != ""){

  if($row->RecordCount() > 0){

    //Already is member then update Facebook attribute.
    $uID = $db->GetOne("SELECT `uID` FROM `Users` WHERE `uEmail` = '$user_email'");
    $u = new User;
    $u->logout();
    $u->loginByUserID($uID);
    $ui = UserInfo::getByID($uID);

    //Update user attributes
    $ui->setAttribute('facebook', $user_link);

    if ($ui->getAttribute('gender') == ""){
      $ui->setAttribute('gender', $user_gender);
    }

    if ($ui->getAttribute('location') == ""){
      $ui->setAttribute('location', $user_location['name']);
    }

    //print_r($u->checkLogin());

  } else {

    //Add new user
    $userData['uName'] = $user_first_name.$user_last_name;
    $userData['uEmail'] = $user_email;
    $userData['uPassword'] = '';
    $userData['uPasswordConfirm'] = '';
    $ui = UserInfo::register($userData);

    // assign the new user to a group
    /*$g = Group::getByName('FB Member');
    $u = $ui->getUserObject();
    $u->enterGroup($g);*/

  }

}

?>
