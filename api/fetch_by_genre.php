<?php
include '../common/db.inc.php';
$response=array();
// print_r($_POST);
$sql="SELECT videos.*, GROUP_CONCAT(genres.genres) as genres FROM videos JOIN videos_genres ON videos.id = videos_genres.videos_id JOIN genres on videos_genres.genres_id = genres.id GROUP by videos.id
";
$results=mysqli_query($conn,$sql);
$rows=mysqli_num_rows($results);
$response['videos_count']=0;
if ($rows!=0) {
	while ($rows=mysqli_fetch_assoc($results)) {
		$genres=explode(',', $rows['genres']);
		if (in_array($_POST['genre'], $genres)) {
			$response['status']=true;
			$response['genre']=$_POST['genre'];
			$response['list'][]=$rows;
			$response['videos_count']+=1;
		}


	}
}else{
	$response=array("status"=>false,"msg"=>"Something Went wrong");
}


// print_r($response);

echo json_encode($response);
?>