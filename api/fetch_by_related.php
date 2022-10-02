<?php
include '../common/db.inc.php';
$response=array();
$genre=$_POST['genres'];
// print_r($genre);
$sql="SELECT videos.*, GROUP_CONCAT(genres.genres) as genres FROM videos JOIN videos_genres ON videos.id = videos_genres.videos_id JOIN genres on videos_genres.genres_id = genres.id GROUP by videos.id
";

$results=mysqli_query($conn,$sql);
$rows=mysqli_num_rows($results);
if ($rows!=0) {
	while ($rows=mysqli_fetch_assoc($results)) {
		// print_r($genre);
		$genres=explode(',', $rows['genres']);
		// print_r($genres);
		if (array_intersect($genre, $genres)) {
			$response['list'][]=$rows;
			$response['status']=true;
		}
		// else{
		// 	$response['status']=false;
		// 	$response['msg']="No";	
		// 	break;		
		// }
	}
}else{
	$response['status']=false;
	$response['msg']="No Data";
}
// print_r($response);

echo json_encode($response);
?>