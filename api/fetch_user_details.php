<?php
include '../common/db.inc.php';
$response=array();
$id=$_POST['id'];
$sql="SELECT * FROM users where id=$id";
$results=mysqli_query($conn,$sql);

function dateDiffInDays($date1, $date2)  
{ 
    // Calulating the difference in timestamps 
    $diff = strtotime($date2) - strtotime($date1); 
      
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 
    return abs(round($diff / 86400)); 
} 
  
// // Start date 
// $date1 = "17-09-2018"; 
  
// // End date 
// $date2 = "31-09-2018"; 
  
// // Function call to find date difference 
 


while ($rows=mysqli_fetch_assoc($results)) {
	$date2 = $rows['package_expiry_date'];
	$date1 = $date = date('Y-m-d H:i:s');
	$dateDiff = dateDiffInDays($date1, $date2);
	$response[0]=$rows;
	$response[0]['dateDiff'] = $dateDiff;
}

echo json_encode($response);
?>