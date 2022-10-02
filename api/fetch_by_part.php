<?php
include '../common/db.inc.php';
$response=array();
$sql="SELECT * from videos_lists where video_part='season 1'";
$results=mysqli_query($conn,$sql);
$rows=mysqli_num_rows($results);
$response['videos_count']=0;
if ($rows!=0) {
	while ($rows=mysqli_fetch_assoc($results)) {
		$genres=explode(',', $rows['genres']);
		//print_r($genres);
		if (in_array($_POST['genre'], $genres)) {
			$response['status']=true;
			$response['genre']=$_POST['genre'];
			$response['list'][]=$rows;
			$response['videos_count']+=1;

		}
	}
}else{
	$response['status']=false;
	$response['list']="";
}

echo json_encode($response);

?>