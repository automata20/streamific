<?php
session_name('plex');
session_start();
include_once ('../common/db.inc.php');
include_once ('function.php');
date_default_timezone_set("Asia/Calcutta");

$response=array();
$id=$_SESSION['id'];
$sql="SELECT * FROM users where id=$id";
$results=mysqli_query($conn,$sql);
$row=mysqli_num_rows($results);
if ($row==1) {
	$row=mysqli_fetch_assoc($results);
	$response['status']=true;	
	$response['data']=$row;
}else{
	$response['status']=false;
	$response['message']="Failed to load details";	
}
echo json_encode($response);

?>