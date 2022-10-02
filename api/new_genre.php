<?php
include '../common/db.inc.php';
$response=array();
// print_r($_POST);
$genre=$_REQUEST['genre'];
$id=$_REQUEST['id'];


$sql="SELECT videos.*, GROUP_CONCAT(genres.genres) as genres FROM videos JOIN videos_genres ON videos.id = videos_genres.videos_id JOIN genres on videos_genres.genres_id = genres.id where videos.id=$id GROUP by videos.id
";

$results=mysqli_query($conn,$sql);
$rows=mysqli_num_rows($results);
$response['videos_count']=0;
if ($rows==1) {
	$rows=mysqli_fetch_assoc($results);
	$genres=explode(',', $rows['genres']);
	if (in_array($genre, $genres)) {
		$response['status']=true;

		$response['genre']=$genre;
		$response['list']=$rows;
		$response['videos_count']+=1;
		$id1=$rows['id'];
		$sql1="SELECT * from wishlist where videos_id=$id1";
		$results2=mysqli_query($conn,$sql1);
		$exist_row=mysqli_num_rows($results2);
		if ($exist_row==1) {
			$response['list']['isadded']=true;
		}
		else{
			$response['list']['isadded']=false;
		}
// print_r($response);
	}
}else{
	$response=array("status"=>false,"msg"=>"Something Went wrong");
}

echo json_encode($response);
?>