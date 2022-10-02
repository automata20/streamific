<?php
include '../common/db.inc.php';
$response=array();
// print_r($_POST);
$id=$_POST['id'];
// $sql="SELECT videos.*, GROUP_CONCAT(genres.genres) as genres FROM videos JOIN videos_genres ON videos.id = videos_genres.videos_id JOIN genres on videos_genres.genres_id = genres.id where videos.id=$id";
$sql="SELECT videos.*, GROUP_CONCAT(DISTINCT genres.genres) as genres, GROUP_CONCAT(DISTINCT videos_lists.series_parts) as total_part FROM videos JOIN videos_genres ON videos.id = videos_genres.videos_id JOIN genres on videos_genres.genres_id = genres.id join videos_lists on videos.id=videos_lists.videos_id where videos.id=$id
";
$results=mysqli_query($conn,$sql);
$rows=mysqli_num_rows($results);
if ($rows!=0) {
	$rows=mysqli_fetch_assoc($results);
	$response['status']=true;

	$response['list']=$rows;
	
	$sql1="SELECT * from wishlist where videos_id=$id and user_id=1";
		$results2=mysqli_query($conn,$sql1);
		$exist_row=mysqli_num_rows($results2);
		if ($exist_row==1) {
			$response['list']['isadded']=true;
		}
		else{
			$response['list']['isadded']=false;
		}
}else{
	$response['status']=false;
	$response['msg']="No Data";
}
// print_r($response);

echo json_encode($response);
?>

