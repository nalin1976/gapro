<?php


class LoginDBManager
{

private $server = 'localhost';
private $userName = 'root';
private $password = 'soft';
private $database = 'eshippingeamdb';
/*private $server = '192.168.1.14';
private $userName = 'root';
private $password = 'linux';
private $database = 'eshippingeamdb';*/



private $con = null;

	public function OpenConnection()
	{
		$this->con = mysql_connect($this->server, $this->userName, $this->password);
		if (!$this->con)
		{
		  die($password . 'Could not connect: ' . mysql_error());
		}
	}
	
	function RunQuery($SQL)
	{
		$this->OpenConnection();
		mysql_select_db($this->database,  $this->con);
		$result = mysql_query($SQL);
		$this->CloseConnection();	
			
		return $result;
	}
	
	function ExecuteQuery($SQL)
	{
		$this->OpenConnection();
		mysql_select_db($this->database,  $this->con);
		$result = mysql_query($SQL);
		$this->CloseConnection();
	}
	
	
	function CheckRecordAvailability($SQL)
	{
		$this->OpenConnection();
		mysql_select_db($this->database,  $this->con);
		$result = mysql_query($SQL);
		$this->CloseConnection();
		while($row = mysql_fetch_array($result))
  		{
  			return true;
  		}
  		return false;		
	}
	
	function CloseConnection()
	{
		mysql_close($this->con);		
	}
	
	
}



?>
