<?php
include '../common/db.inc.php';
require_once "../common/mails.php";

$response=array();
$id=$_POST['id'];
$cpassword=$_POST['cpassword'];
$npassword=$_POST['npassword'];
$cnpassword=$_POST['cnpassword'];
$sqlc="SELECT * FROM users WHERE id=$id";
$results=mysqli_query($conn,$sqlc);
$rows=mysqli_fetch_assoc($results);
if($rows['password']==md5($cpassword)){
	$npassword=md5($npassword);
	$sql="UPDATE `users` SET `password` = '$npassword' WHERE `users`.`id` = $id";
	$results=mysqli_query($conn,$sql);
	if ($results==true) {
		$response['status']=true;
		$response['message']="Your password is updated";
		change_password_mail($rows['email'],'Plex password is updated',$rows['username']);
	}else{
		$response['status']=false;
		$response['message']="failed to update password";
	}

}else{
	$response['status']=false;
	$response['message']="failed to update password end";
}
echo json_encode($response);
?>