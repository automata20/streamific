<?php
include '../common/db.inc.php';

$response=array();
$id=$_POST['id'];
$p_a_t=$_POST['p_a_t'];

$sql="UPDATE `users` SET `package_type` = '$p_a_t' WHERE `users`.`id` = $id ";

$results=mysqli_query($conn,$sql);
if ($results==true) {
	$response['status']=true;
	$response['url']="index.php";
	$response['message']="";
}else{
	$response['status']=false;
	$response['url']="fails.php";
	$response['message']="failed to process forward";
}

echo json_encode($response);
?>