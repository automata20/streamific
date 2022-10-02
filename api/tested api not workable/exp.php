<?php
include '../common/db.inc.php';
$response=array();
// print_r($_POST);
$sql="SELECT * from wishlist
";
$results=mysqli_query($conn,$sql);
// $rows=mysqli_num_rows($results);

while ( $arr=mysqli_fetch_assoc($results) ) {
	$marr[]=$arr['videos_id'];
	
}
// print_r($marr);

$sql="SELECT videos.*, GROUP_CONCAT(genres.genres) as genres FROM videos JOIN videos_genres ON videos.id = videos_genres.videos_id JOIN genres on videos_genres.genres_id = genres.id where videos.id=$id GROUP by videos.id
";
$results=mysqli_query($conn,$sql);
$rows=mysqli_num_rows($results);
$response['videos_count']=0;
if ($rows!=0) {
	while ($rows=mysqli_fetch_assoc($results)) {
		$genres=explode(',', $rows['genres']);
		if (in_array('Crime', $genres)) {
			$response['status']=true;

			$response['genre']='Crime';
			$response['list'][$rows['id']-1]=$rows;
			$response['videos_count']+=1;
			if (in_array($rows['id'], $marr)) {
				$response['list'][$rows['id']-1]['isadded']="Y";
			}
			else{
				$response['list'][$rows['id']-1]['isadded']="N";
			}
		}
		
		

	}
}else{
	$response=array("status"=>false,"msg"=>"Something Went wrong");
}

echo json_encode($response);
?>