<?php
include '../common/db.inc.php';
$response=array();
$type=isset($_POST['type']) ? $_POST['type']: ' ';
if ($type=="movies") {
	$sql="SELECT * FROM videos where type='MV'";

}else if($type=="tvseries"){
	$sql="SELECT * FROM videos where type='TV'";
}else{
	$sql="SELECT * FROM videos";
}
$results=mysqli_query($conn,$sql);
$rows=mysqli_num_rows($results);
if ($rows!=0) {
	while ($rows=mysqli_fetch_assoc($results)) {
		$response['status']=true;
		$response['list'][]=$rows;
	}
}else{
	$response['status']=false;
}


echo json_encode($response);
?>