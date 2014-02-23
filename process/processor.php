<?php
if( !isset( $_SESSION[ 'userid' ] ) )  {
    session_start();
}
class processor
{
    public function updateArticle( $article_id , $article , $title , $city ) {
        require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "update article_data set article_data = '" . $article . "', article_title = '" . $title . "', city = '" . $city . "' where article_id = '" . $article_id . "'";//DIP PERMANENTLY CODED THIS, ALTERATION IS STRICTLY PROHIBITTED
		$access->insert($query);
		$access->dbclose();
    }
    
    public function getUserName( $userIdParam ) {
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "select * from tbl_user where id = "  . $userIdParam . " ; ";
		$result = $access->show($query);
		$arr = array() ;
		while( $row = mysql_fetch_array( $result ) ) {
            $brr = $row[ 'fname' ] . " " . $row[ 'lname' ] ;
			$arr[] = $brr ;
		}
		$access->dbclose();
		return $arr ;
	}
    
	public function insertCity( $cityName , $stateName ) {
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "INSERT INTO us_city_info VALUES ( '' , '" . $cityName . "' , '" . $stateName . "' ) ; ";
		$access->insert($query);
		$access->dbclose();
	}
	
	public function getAllCity() {
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "select * from us_city_info ; ";
		$result = $access->show($query);
		$arr = array() ;
		while( $row = mysql_fetch_array( $result ) ) {
			$arr[] = $row ;
		}
		$access->dbclose();
		return $arr ;
	}
	
    public function getinfo()
    {
        require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "SELECT * FROM tbl_intro WHERE id = '1'";
		$result = $access->show($query);
        $row = mysql_fetch_array($result);
		$access->dbclose();
		return $row;
    }
	
	public function getArticleData() {
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "SELECT * FROM article_data ";
		$result = $access->show($query);
		$arr = array() ;
		while( $row = mysql_fetch_array( $result ) ) {
			$arr[] = $row ;
		}
		$access->dbclose();
		return $arr;
	}
	
	public function insertArticle( $data , $title , $city ) {
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "INSERT INTO article_data VALUES ( '' , '" . $data . "' , '" . $title . "' , '".date('Y-m-d')."' , '".$_SESSION['userid']."' , '".$city."' ) ; ";
		$access->insert($query);
		$access->dbclose();
	}
	
	public function authentication($username,$pass)
    {
        require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "SELECT * FROM tbl_authentication WHERE `username` = '$username' and `password` = '$pass' and `status` = 1";
		$result = $access->show($query);
		$access->dbclose();
		return $result;
    }
	public function authentication_by_email($username,$passw)
    {
        require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "SELECT * FROM tbl_user WHERE `email` = '$username' and `pass` = '$passw' and `status` = 1";
		$result = $access->show($query);
		$access->dbclose();
		return $result;
    }
	public function adduser($fname,$lname,$email,$pass,$amount,$password)
	{
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "INSERT INTO `tbl_user` (`fname`, `lname`, `email`, `pass`, `rate`, `status`) VALUES ('$fname', '$lname', '$email', '$pass', '$amount', '1')";
		$access->insert($query);
		$access->dbclose();
		$result = $this->send_email_to_user($fname,$lname,$email,$password);
		return $result;
		
	}
	public function create_admin($email,$pass,$username,$password)
	{
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "INSERT INTO `tbl_authentication` (`username`, `password`, `email`, `notification`, `status`) VALUES ('$username', '$pass', '$email', '1', '1')";
		$access->insert($query);
		$access->dbclose();
		$result = $this->send_email_to_admin($email,$pass,$username,$password);
		return $result;
		
	}
	public function send_email_to_user($fname,$lname,$email,$password)
	{
		
		$subject = "Registration Successfull!!";
		
		$message = "
		<html>
		<head>
		<title>Login Details</title>
		</head>
		<body>
		
		<center>Hello ".$fname." ".$lname."</center>
		<center>Your Registration has been done.</center>
		<center>Username: ".$email."</center>
		<center>Password: ".$password."</center>
		
		</body>
		</html>
		";
		
		//Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		if(mail($email,$subject,$message,$headers))
		{
			return true;
		}
		
	}
	
	public function send_email_to_admin($email,$username,$password)
	{
		
		$subject = "Registration Successfull!!";
		
		$message = "
		<html>
		<head>
		<title>Login Details</title>
		</head>
		<body>
		
		<center>Your Registration has been done.</center>
		<center>Username: ".$username."</center>
		<center>Password: ".$password."</center>
		
		</body>
		</html>
		";
		
		//Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		if(mail($email,$subject,$message,$headers))
		{
			return true;
		}
		
	}
	public function show_active_user()
	{
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "SELECT * FROM tbl_user";
		$result = $access->show($query);
		$access->dbclose();
		return $result;
	}
	public function show_articles_for_user($userid)
	{
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "SELECT * FROM tbl_user WHERE id = '$userid'";
		$result = $access->show($query);
		$access->dbclose();
		return $result;
	}
	public function show_indivisual_user($user)
	{
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "SELECT * FROM tbl_user WHERE id = '$user'";
		$result = $access->show($query);
		$access->dbclose();
		return $result;
	}
	public function upgrade_user_info($fname,$lname,$email,$amount,$userid)
	{
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "UPDATE `tbl_user` SET `fname` = '$fname',`lname` = '$lname',`email` = '$email',`rate` = '$amount' WHERE `id` = '$userid'";
		$result = $access->insert($query);
		$access->dbclose();
		return $result;
	}
	public function delete_user_info($userid)
	{
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "DELETE FROM `tbl_user` WHERE `id` = '$userid'";
		$result = $access->insert($query);
		$access->dbclose();
		return $result;
	}
	public function disable_user($userid)
	{
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "UPDATE `tbl_user` SET `status` = '0' WHERE `id` = '$userid'";
		$result = $access->insert($query);
		$access->dbclose();
		return $result;
	}
	public function enable_user($userid)
	{
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "UPDATE `tbl_user` SET `status` = '1' WHERE `id` = '$userid'";
		$result = $access->insert($query);
		$access->dbclose();
		return $result;
	}
	public function upgrade_user_password($userid,$npass)
	{
		
		require_once('dbconnect.php');
		$pass = md5($npass);
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "UPDATE `tbl_user` SET `pass` = '$pass' WHERE `id` = '$userid'";
		$result = $access->insert($query);
		$access->dbclose();
		return $result;
	}
	public function upgrade_admin_password($userid,$npass)
	{
		
		require_once('dbconnect.php');
		$pass = md5($npass);
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "UPDATE `tbl_authentication` SET `password` = '$pass' WHERE `id` = '$userid'";
		$result = $access->insert($query);
		$access->dbclose();
		return $result;
	}
	public function showcity()
	{
		require_once('dbconnect.php');
		$access = new dbconnect();
		$access->dbconn();
		$access->selectdb();
		$query = "SELECT * FROM us_city_info ";
		$result = $access->show($query);
		$access->dbclose();
		return $result;
	}
	
}

?>