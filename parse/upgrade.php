<?php
session_start();
$fname="";
$lname="";
$email="";
$amount="";
$userid="";
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
if(isset($_POST['userid'])){
	$userid=$_POST['userid'];
	}


include('../process/processor.php');


//Inserting Data
$access = new processor();
$result = $access->upgrade_user_info($fname,$lname,$email,$amount,$userid);
if($result == true)
{
	header('Location: ../update.php?userid=$userid');
}

?>