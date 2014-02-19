<?php
session_start();
//if(isset($_session['userid']))
//$_SESSION['userid'];
//$_SESSION['user'];
if($_SESSION['userid'] == "" || $_SESSION['user'] == "")
{
    header('Location: ../login.php');
    exit();
}
?>