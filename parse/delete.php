<?php
session_start();

$userid = $_GET['userid'];
if(is_numeric($userid))
{
	include('../process/processor.php');
	$access = new processor();
	$result = $access->delete_user_info($userid);
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