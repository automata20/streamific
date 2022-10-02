<?php
session_name('plex');
session_start();
include_once ('../common/db.inc.php');
include_once ('function.php');
require_once "../common/mails.php";

date_default_timezone_set("Asia/Calcutta");

$response=array();
$id=$_POST['user_id'];
$ispaid=$_POST['ispaid'];
$sqlcheck="SELECT package_type from users where id=$id";
$resultsc=mysqli_query($conn,$sqlcheck);
$rowcheck=mysqli_fetch_assoc($resultsc);
if ($rowcheck['package_type']=='2') {
	$currentDateTime = date('Y-m-d H:i:s');
	$extendedDate = date('Y-m-d H:i:s', strtotime($currentDateTime. ' + 30 days'));
	$money='1';
}else if ($rowcheck['package_type']=='3') {
	$currentDateTime = date('Y-m-d H:i:s');
	$extendedDate = date('Y-m-d H:i:s', strtotime($currentDateTime. ' + 365 days'));
	$money='10';
}
$sql="UPDATE `users` SET `ispaid` = '$ispaid',`package_expiry_date`='$extendedDate' WHERE `users`.`id` = $id";
if ($results=mysqli_query($conn,$sql)) {
	$response['status']=true;	
	$response['msg']="Your payment done, we have send you mail, wait to be redirect to home";
	$response['url']="home.php";
	$sql="SELECT * from users where id=$id and ispaid='Y'";
	$results=mysqli_query($conn,$sql);
	$rows=mysqli_fetch_assoc($results);
	payment_mail($rows['email'],'Plex Account payment is done',$rows['username'],$money);
}else{
	$response['status']=false;
	$response['msg']="Your payment is failed wait to redirect to repayment";
	$response['url']="index.php";	
}
echo json_encode($response);

?>