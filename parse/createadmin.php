<?php
session_start();

$email="";
$username="";

if(isset($_POST['email'])){
	$email=$_POST['email'];
	}
	
if(isset($_POST['username'])){
	$amount=$_POST['username'];
	}
//echo $amount.'<br>'.$fname.'<br>'.$lname.'<br>'.$email.'<br>';


include('../process/processor.php');

//generate Password
$length = 6;
$password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

$pass = md5($password);

//Inserting Data
$access = new processor();
$result = $access->create_admin($email,$pass,$username,$password);


?>