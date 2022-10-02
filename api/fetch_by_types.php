<?php
include '../common/db.inc.php';
$response=array();
$type=isset($_POST['type']) ? $_POST['type']: ' ';
if ($type=="movies") {
	$sql="SELECT * FROM videos where type='MV'";
	$results=mysqli_query($conn,$sql);
	$rows=mysqli_num_rows($results);
	if ($rows!=0) {
		while ($rows=mysqli_fetch_assoc($results)) {
			$response['status']=true;
			// $response['list']['watch next'][]=$rows;
		}
	}else{
		$response['status']=false;
	}

	$sql="SELECT * FROM `videos` join videos_lists on videos.id=videos_lists.videos_id where type='MV' and series_rating>8 order by rand() limit 7";
	$results=mysqli_query($conn,$sql);
	$rows=mysqli_num_rows($results);
	if ($rows!=0) {
		while ($rows=mysqli_fetch_assoc($results)) {
			$response['status']=true;
			$response['top'][]=$rows;
		}
	}else{
		$response['status']=false;
	}
	
	$sql="SELECT * FROM genres order by rand() limit 6";
	$results=mysqli_query($conn,$sql);
	$rows=mysqli_num_rows($results);
	if ($rows!=0) {
		$response['status']=true;
		while ($rows=mysqli_fetch_assoc($results)) {
			$genres_id=$rows['id'];
			$genres_name=$rows['genres'];
			$sql="SELECT videos.* FROM videos join videos_genres on videos.id=videos_genres.videos_id where videos_genres.genres_id=$genres_id and type='MV'";
			$results1=mysqli_query($conn,$sql);
			$rows1=mysqli_num_rows($results1);
			if ($rows1!=0) {	
				while ($rows12=mysqli_fetch_assoc($results1)) {
					$response['list'][$genres_name.' Movies'][]=$rows12;
					// $response['list'][]=$genres_name.' Movies';
				}
			}
			// else{
			// 	$response['status']=false;
			// }
		}
	}else{
		$response['status']=false;
	}


}else if($type=="tvseries"){
	$sql="SELECT * FROM videos where type='TV'";
	$results=mysqli_query($conn,$sql);
	$rows=mysqli_num_rows($results);
	if ($rows!=0) {
		while ($rows=mysqli_fetch_assoc($results)) {
			$response['status']=true;
			// $response['list']['watch next'][]=$rows;
		}
	}else{
		$response['status']=false;
	}

	$sql="SELECT * FROM `videos` join videos_lists on videos.id=videos_lists.videos_id where type='TV' and series_rating>8 order by rand() limit 7";
	$results=mysqli_query($conn,$sql);
	$rows=mysqli_num_rows($results);
	if ($rows!=0) {
		while ($rows=mysqli_fetch_assoc($results)) {
			$response['status']=true;
			$response['top'][]=$rows;
		}
	}else{
		$response['status']=false;
	}


	$sql="SELECT * FROM genres order by rand() limit 6";
	$results=mysqli_query($conn,$sql);
	$rows=mysqli_num_rows($results);
	if ($rows!=0) {
		$response['status']=true;
		while ($rows=mysqli_fetch_assoc($results)) {
			$genres_id=$rows['id'];
			$genres_name=$rows['genres'];
			$sql="SELECT videos.* FROM videos join videos_genres on videos.id=videos_genres.videos_id where videos_genres.genres_id=$genres_id and type='TV'";
			$results1=mysqli_query($conn,$sql);
			$rows1=mysqli_num_rows($results1);
			if ($rows1!=0) {	
				while ($rows12=mysqli_fetch_assoc($results1)) {
					$response['list'][$genres_name.' Movies'][]=$rows12;
					// $response['list'][]=$genres_name.' Movies';
				}
			}
			// else{
			// 	$response['status']=false;
			// }
		}
	}else{
		$response['status']=false;
	}

}else{
	$sql="SELECT * FROM videos";
	$results=mysqli_query($conn,$sql);
	$rows=mysqli_num_rows($results);
	if ($rows!=0) {
		while ($rows=mysqli_fetch_assoc($results)) {
			$response['status']=true;
			// $response['list']['watch next'][]=$rows;
		}
	}else{
		$response['status']=false;
	}

	$sql="SELECT * FROM `videos` join videos_lists on videos.id=videos_lists.videos_id where series_rating>8 order by rand() limit 7";
	$results=mysqli_query($conn,$sql);
	$rows=mysqli_num_rows($results);
	if ($rows!=0) {
		while ($rows=mysqli_fetch_assoc($results)) {
			$response['status']=true;
			$response['top'][]=$rows;
		}
	}else{
		$response['status']=false;
	}

	$sql="SELECT * FROM genres order by rand() limit 7";
	$results=mysqli_query($conn,$sql);
	$rows=mysqli_num_rows($results);
	if ($rows!=0) {
		$response['status']=true;
		while ($rows=mysqli_fetch_assoc($results)) {
			$genres_id=$rows['id'];
			$genres_name=$rows['genres'];
			$sql="SELECT videos.* FROM videos join videos_genres on videos.id=videos_genres.videos_id where videos_genres.genres_id=$genres_id";
			$results1=mysqli_query($conn,$sql);
			$rows1=mysqli_num_rows($results1);
			if ($rows1!=0) {	
				while ($rows12=mysqli_fetch_assoc($results1)) {
					$response['list'][$genres_name.' Movies & TV'][]=$rows12;
					// $response['list'][]=$genres_name.' Movies';
				}
			}
			// else{
			// 	$response['status']=false;
			// }
		}
	}else{
		$response['status']=false;
	}

}


echo json_encode($response);
?>