<?php
class dbconnect
{
	private $host="Localhost";
	private $user="root";
	private $pass="natasha143#";
	private $connection;
	public function dbconn()
	{
		$this->connection =  mysql_connect($this->host,$this->user,$this->pass);
		return $this->connection;
	}
	public function dbclose()
	{
		mysql_close($this->connection);
	}
	public function selectdb()
	{
		mysql_select_db("unique_content",$this->connection);
	}
	public function insert($sql)
	{
		$abc = mysql_query($sql);
		return $abc;
	}
	public function show($show)
	{
		if(!mysql_query($show))
		echo mysql_error();
		else return $result = mysql_query($show);
	}
    
    public function onjonCon() {
        $conn = mysql_connect( "localhost" , "root" , "natasha143#" );
        mysql_select_db( "unique_content" , $conn );
    }
}
?>