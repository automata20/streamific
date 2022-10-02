<?php
include '../common/db.inc.php';
$series_id=$_POST['series_id'];

// $type=$_POST['type'];
// if ($type="MV") {
// 	$sql="SELECT * from episodes where series_id=$series_id";
// 	// print_r($sql);
// 	$results=mysqli_query($conn,$sql);
// 	$rows=mysqli_num_rows($results);
// 	if ($rows!=0) {
// 		$response['status']=true;
// 		while ($rows=mysqli_fetch_assoc($results)) {
// 			$response['data'][]=$rows;
// 		}
// 	}else{
// 		$response['status']=false;
// 	}
// }else{
	$sql="SELECT * from episodes where series_id=$series_id";
	// print_r($sql);
	$results=mysqli_query($conn,$sql);
	$rows=mysqli_num_rows($results);
	if ($rows!=0) {
		$response['status']=true;
		while ($rows=mysqli_fetch_assoc($results)) {
			$response['data'][]=$rows;
		}
	}else{
		$response['status']=false;
	}
// }


echo json_encode($response);

?>