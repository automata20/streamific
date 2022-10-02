<?php
include '../common/db.inc.php';
require_once "../common/mails.php";

$response=array();
$id=$_POST['id'];
$firstname=$_POST['fname'];
$lastname=$_POST['lname'];
$username=$_POST['uname'];
$email=$_POST['email'];
$mobile=$_POST['mobile'];
// $date = date('y/m/d h:m:s');
// print_r(NOW());
$sql="UPDATE `users` SET `firstname` = '$firstname',`lastname` = '$lastname',`username` = '$username',`modified_date`=current_timestamp WHERE `users`.`id` = $id";

$results=mysqli_query($conn,$sql);
if ($results==true) {
	$response['status']=true;
	$response['message']="Account details is updated";
	change_account_details($email,'Plex account details is updated',$username);
}else{
	$response['status']=false;
	$response['message']="failed to update account details";
}

echo json_encode($response);
?>