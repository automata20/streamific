<?php
include '../common/db.inc.php';
$response=array();
// print_r($_POST);
$sql="INSERT into wishlist(user_id, movie_id) values($_POST['user_id'],$_POST['movie_id'])";
$results=mysqli_query($conn,$sql);
if($results==1){
	$response['status']=true;
	$response['msg']="added";
}else{
	$response['status']=false;
	$response['msg']="not added";
}
// print_r($response);

echo json_encode($response);
?>