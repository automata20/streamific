<?php
include '../common/db.inc.php';
$id=$_POST['id'];
$series_parts=$_POST['part'];
$sql="SELECT * from videos_lists where videos_id=$id and series_parts='$series_parts'";
// print_r($sql);
// exit();
// $sql="SELECT * from videos_lists where id=3 and series_parts='season 1'";
$results=mysqli_query($conn,$sql);
// $rows=mysqli_num_rows($results);
$rows=mysqli_fetch_assoc($results);



echo json_encode($rows);
?>