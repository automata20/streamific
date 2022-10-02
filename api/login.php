<?php
session_name('plex');
session_start();
include_once ('../common/db.inc.php');
include_once ('function.php');
$response=array();

$email=$_POST['email'];
$password=$_POST['password'];
// $email="admin@admin.com";
// $password='admin1234';

$emailflag=false;
$passwordflag=false;
$emailerror='';
$passworderror='';
if (empty($email)) {
	$emailflag=false;
	$emailerror="Don't Leave email input blanks";
}else{
	$emailflag=false;
	if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$emailflag=true;
	}else{
		$emailflag=false;
		$emailerror="Invalid Email Combination";
	}
}
if (empty($password)) {
	$passwordflag=false;
	$passworderror="Don't Leave password input blanks";
}else{
	if (strlen($password)>7) {
		$passwordflag=true;
	}else{
		$passwordflag=false;
		$passworderror="Invalid password";
	}
}

if ($emailflag==true && $passwordflag==true) {
	$password=md5($password);
	$sql="SELECT * FROM users where `email`='$email' and `password`='$password'";
	$results=mysqli_query($conn,$sql);
	$row=mysqli_num_rows($results);
	$row_data=mysqli_fetch_assoc($results);
	if ($row==1) {
		if ($row_data['ispaid']=='Y') {
			$id=$row_data["id"];
			$_SESSION['id']=$id;
			$_SESSION['name']=$row_data["username"];
			
			setcookie('auth_id', $id,time()+86400*30,'/');
			setcookie('auth_user', $row_data["username"],time()+86400*30,'/');
			$sql="UPDATE `users` SET `last_login_date` = current_timestamp WHERE `users`.`id` = $id ";
			$results=mysqli_query($conn,$sql);
			$response['status']=true;
			$response['url']="home.php?type=ALL";	
			$response['message']= "Your Login Sucessfully";
		}else{
			$response['status']=false;
			$response['message']= "Your payment is pending";
			$response['url']="payment.php";	

		}
		
	}else{	
		$response['status']=false;
		$response['message']= "Your Login Credential are not valid";
	}
}
else{
	$response['status']=false;
	$response['message']['emailerror']=$emailerror;
	$response['message']['passworderror']=$passworderror;
}
// print_r($_SESSION);
echo json_encode($response);
?>