<?php
include '../common/db.inc.php';
$response=array();

if (isset($_REQUEST['user_id'])) {
	$user_id=$_REQUEST['user_id'];
	$sql="SELECT videos.*,GROUP_CONCAT(genres.genres) as genres from wishlist join videos on videos_id=videos.id join videos_genres on videos.id=videos_genres.videos_id join genres on videos_genres.genres_id=genres.id where wishlist.user_id=$user_id GROUP by wishlist.videos_id";
	if ($results=mysqli_query($conn,$sql)) {
		$response['status']=true;
		$response['videos_count']=mysqli_num_rows($results);
		if (mysqli_num_rows($results)!=0) {
			while ($rows=mysqli_fetch_assoc($results)) {
				$response['data'][]=$rows;
			}
		}
		else{
			$response['data']="";
		}
	}else{
		$response=array("status"=>false,"msg"=>"Something Went wrong");
	}
	
}else{
	$response=array("status"=>false,"msg"=>"Invalid user");
}

echo json_encode($response);
?>