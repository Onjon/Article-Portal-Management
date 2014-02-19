<?php
session_start();

$userid = $_GET['userid'];
if(is_numeric($userid))
{
	include('../process/processor.php');
	$access = new processor();
	$result = $access->enable_user($userid);
	if($result == true)
	{
		header('Location: ../updateuser.php');
	}
	else
	{
		header('Location: ../updateuser.php');
	}
}
else
{
	header('Location: ../updateuser.php');
}


?>