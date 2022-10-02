<?php
include '../common/db.inc.php';
$response=array();
// print_r($_POST);
$id=$_REQUEST['id'];


$sql="SELECT videos.*, GROUP_CONCAT(genres.genres) as genres FROM videos JOIN videos_genres ON videos.id = videos_genres.videos_id JOIN genres on videos_genres.genres_id = genres.id where videos.id=$id GROUP by videos.id
";
$results=mysqli_query($conn,$sql);
$rows=mysqli_num_rows($results);
if ($rows==1) {
	$rows=mysqli_fetch_assoc($results);
	$response['status']=true;
	$response['list']=$rows;
	$id1=$rows['id'];
	$sqls="SELECT * from videos_lists where videos_id=$id1";
	$resultss=mysqli_query($conn,$sqls);
	// $rowss=mysqli_num_rows($resultss);
	while ($rowss=mysqli_fetch_assoc($resultss)) {
		$response['list']['series'][]=$rowss;
	}
	$rowss=mysqli_num_rows($resultss);
	if ($rowss!=0) {
		foreach ($response['list']['series'] as $key => $value) { 
			$series_id=$value['id'];
			$sqlep="SELECT * from episodes where series_id=$series_id";
			// print_r($value['id']);
			// $value['new']='dadsd';
			// print_r($value['new']);
			$resultsep=mysqli_query($conn,$sqlep);
			// print_r($sqlep);
			
			$episodes=array();
			while ($rowsep=mysqli_fetch_assoc($resultsep)) {
				$episodes[]=$rowsep;
			}
			$value['episodes']=$episodes;
			// print_r($value);
		}

	}else{
		// print_r('failde');
	}

	$sql1="SELECT * from wishlist where videos_id=$id1";
	$results2=mysqli_query($conn,$sql1);
	$exist_row=mysqli_num_rows($results2);
	if ($exist_row==1) {
		$response['list']['isadded']=true;
	}
	else{
		$response['list']['isadded']=false;
	}

}else{
	$response=array("status"=>false,"msg"=>"Something Went wrong");
}
echo json_encode($response);
?>