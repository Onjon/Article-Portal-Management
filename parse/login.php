<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include('../process/processor.php');

$username = $_GET['user'];
$pass = md5($_GET['pass']);
$passw = $_GET['pass'];
$access = new processor();

if (strpos($username,'@') !== false) {
	
    $result = $access->authentication_by_email($username,$pass);
	if(mysql_num_rows($result) == 1)
	{
		$row = mysql_fetch_array($result);
		$_SESSION['userid'] = $row['id'];
		$_SESSION['access'] = 'user';
		$_SESSION['pw'] = $row['pass'];
		$_SESSION['user'] = $row['username'];
		header('Location: ../userhome.php');
	}
	else
	{
		$_SESSION['try'] = 1;
		header('Location: ../login.php');
		exit();
	}
}
else
{
	$result = $access->authentication($username,$pass);
	if(mysql_num_rows($result) == 1)
	{
		$row = mysql_fetch_array($result);
		$_SESSION['userid'] = $row['id'];
		$_SESSION['access'] = 'admin';
		$_SESSION['pw'] = $row['password'];
		$_SESSION['user'] = $row['username'];
		header('Location: ../index.php');
	}
	else
	{
		$_SESSION['try'] = 1;
		header('Location: ../login.php');
		exit();
	}
}

?>