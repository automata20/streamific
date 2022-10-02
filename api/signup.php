<?php
session_name('plex');
session_start();
include_once ('../common/db.inc.php');
require_once "../common/mails.php";
date_default_timezone_set("Asia/Calcutta");

$response=array();

$username=$_POST['name'];
$mobile_number=$_POST['phonenumber'];
$email=$_POST['email'];
$password=$_POST['password'];
$cpassword=$_POST['cpassword'];
$p_a_t=$_POST['p_a_t'];

$usernameflag=false;
$emailflag=false;
$passwordflag=false;
$cpasswordflag=false;

$usernamemsg='';
$emailmsg='';
$passwordmsg='';
$cpasswordmsg='';
if (empty($username)) {
	$usernameflag=false;
	$usernamemsg="Don't Leave username input blanks";
}else{
	$usernameflag=false;
	if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$usernameflag=true;
	}else{
		$usernameflag=false;
		$usernamemsg="Only Character & _ ";
	}
}

if (empty($email)) {
	$emailflag=false;
	$emailmsg="Don't Leave email input blanks";
}else{
	$emailflag=false;
	if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$emailflag=true;
	}else{
		$emailflag=false;
		$emailmsg="Invalid Email Combination";
	}
}
if (empty($password)) {
	$passwordflag=false;
	$passwordmsg="Don't Leave password input blanks";
}else{
	if (strlen($password)>4) {
		$passwordflag=true;
	}else{	
		$passwordflag=false;
		$passwordmsg="Invalid password";
	}
}

if (empty($cpassword)) {
	$cpasswordflag=false;
	$cpasswordmsg="Don't Leave password input blanks";
}else{
	if (strlen($cpassword)>4) {
		if ($cpassword==$password) {
			$cpasswordflag=true;
		}else{
			$cpasswordflag=false;
			$cpasswordflag="This password doesn't match to above one";
		}
	}else{	
		$cpasswordflag=false;
		$cpasswordmsg="Invalid password";
	}
}

if ($emailflag==true && $passwordflag==true) {
	if ($p_a_t=='1') {
		
		$currentDateTime = date('Y-m-d H:i:s');
		$extendedDate = date('Y-m-d H:i:s', strtotime($currentDateTime. ' + 30 days'));
	}else if ($p_a_t=='2') {
		$currentDateTime = date('Y-m-d H:i:s');
		$extendedDate = date('Y-m-d H:i:s', strtotime($currentDateTime. ' + 30 days'));
	}else if ($p_a_t=='3') {
		$currentDateTime = date('Y-m-d H:i:s');
		$extendedDate = date('Y-m-d H:i:s', strtotime($currentDateTime. ' + 365 days'));
	}
	$password=md5($password);
	$sql="SELECT * FROM users where `email`='$email' and `password`='$password'";
	$results=mysqli_query($conn,$sql);
	$row=mysqli_num_rows($results);
	$row_data=mysqli_fetch_assoc($results);
	if ($row==1) {
		$response['status']=false;
		$response['message']= "This email already exists";
	}else{	
		$sql="INSERT INTO `users` (`username`, `email`, `password`,`mobile_number`,`created_date`,`ispaid`,`package_type`,`package_expiry_date`) VALUES ('$username','$email', '$password',$mobile_number,current_timestamp,'N','$p_a_t','$extendedDate')";
		$results=mysqli_query($conn,$sql);
		$sql1="SELECT * FROM users where `email`='$email' and `password`='$password'";
		$results1=mysqli_query($conn,$sql1);
		$row_set=mysqli_fetch_assoc($results1);
		$id=$row_set["id"];
		$_SESSION['id']=$id;
		$_SESSION['name']=$row_set["username"];
		$response['status']=true;
		// $response['url']="home.php?id=".$row_data['id'];	
		if ($p_a_t==1) {
			$response['url']="home.php"; 
		}
		else{
			$response['url']=""; 
		}
		$response['message']= "Your account has been created";
		create_account_mail($email,"Your account is created on Plex",$username);
	}
}
else{
	$response['status']=false;
	$response['message']['usernamemsg']=$usernameerror;
	$response['message']['emailmsgr']=$emailerror;
	$response['message']['passwordmsg']=$passworderror;
	$response['message']['cpasswordmsg']=$cpassworderror;
}

echo json_encode($response);
?>