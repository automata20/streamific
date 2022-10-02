<?php
session_name('plex');
session_start();
include_once ('../common/db.inc.php');

date_default_timezone_set("Asia/Calcutta");

$response=array();
$keyword=$_POST['search'];

$sql="SELECT * from videos where title like '%$keyword%'";
if (empty($keyword)) {
	$sql="SELECT * from videos where title like null";
}
$results=mysqli_query($conn,$sql);
$rows=mysqli_num_rows($results);

if ($rows!=0) {
	
	while ($rows=mysqli_fetch_assoc($results)) {
		$response['status']=true;
		$response['list'][]=$rows;
	}
}else{
	$response['status']=false;
}
echo json_encode($response);

?>