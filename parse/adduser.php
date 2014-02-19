<?php
session_start();
$fname="";
$lname="";
$email="";
$amount="";

if(isset($_POST['fname'])){
	$fname=$_POST['fname'];
	}

if(isset($_POST['lname'])){
	$lname=$_POST['lname'];
	}
	
if(isset($_POST['email'])){
	$email=$_POST['email'];
	}
	
if(isset($_POST['amount'])){
	$amount=$_POST['amount'];
	}
//echo $amount.'<br>'.$fname.'<br>'.$lname.'<br>'.$email.'<br>';


include('../process/processor.php');

//generate Password
$length = 6;
$password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

$pass = md5($password);

//Inserting Data
$access = new processor();
$result = $access->adduser($fname,$lname,$email,$pass,$amount,$password);

?>