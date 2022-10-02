<?php
include '../common/db.inc.php';
$response=array();

$sql="SELECT * FROM videos";
$results=mysqli_query($conn,$sql);

while ($rows=mysqli_fetch_assoc($results)) {
	$response[]=$rows;

}

echo json_encode($response);
?>