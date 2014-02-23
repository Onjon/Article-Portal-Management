<?php
session_start();
if(isset($_SESSION['userid']))
{
   if($_SESSION['access'] != 'user')
   {
	   header('Location: login.php');
	   exit();
   }
}
else
{
	header('Location: login.php');
    exit();
}
?>