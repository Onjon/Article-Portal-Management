<?php
session_start();

$cpass = md5($_POST['cpass']);

$npass = $_POST['npass'];

$cnpass = $_POST['cnpass'];

$userid = $_SESSION['userid'];

if($cpass == "" || $npass == "" || $cnpass == "")
{
	$_SESSION['pwd'] = 'empty';
	header('Location: ../change.php');
	exit();
}
else
{
	if($_SESSION['pw'] == $cpass)
	{
		if($npass == $cnpass)
		{
			require_once('../process/processor.php');
			$access = new processor();
			$result = $access->upgrade_admin_password($userid,$npass);
			if($result == true)
			{
				$_SESSION['pwd'] = 'done';
				header('Location: ../change.php');
				exit();
			}
		}
		else
		{
			$_SESSION['pwd'] = 'notmatch';
			header('Location: ../change.php');
			exit();
		}
	}
	else
	{
		$_SESSION['pwd'] = 'wrong';
		header('Location: ../change.php');
		exit();
	}
}

?>