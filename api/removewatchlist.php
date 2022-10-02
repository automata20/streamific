<?php
include '../common/db.inc.php';
$response=array();
$user_id=$_REQUEST['user_id'];
$videos_id=$_REQUEST['videos_id'];

$sql="Select * from users where id=$user_id";
$results=mysqli_query($conn,$sql);
$row=mysqli_num_rows($results);
if($row!=0){
	$sql="Select * from videos where id=$videos_id";
	$results=mysqli_query($conn,$sql);
	$row=mysqli_num_rows($results);
	if ($row!=0) {
		$sql="DELETE FROM `wishlist` where user_id=$user_id and videos_id=$videos_id";
		if ($results=mysqli_query($conn,$sql)) {
			$response = array("status" => true , "msg" => "Removed from Watchlist");
		}else{
			$response = array("status" => false , "msg" => "Something went wrong");
		}
	}else{
		$response = array("status" => false , "msg" => "Invalid movie id given");
	}
}else{
	$response = array("status" => false , "msg" => "Invalid user id given");	
}
echo json_encode($response);


?>