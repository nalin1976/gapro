<?php

/**
 * @Prasad Rajapaksha 
 * @copyright 2008
 * Database Handling Module 
 */

class HeaderDBManager
{

private $server = '';
private $userName = '';
private $password = '';
private $database = '';

private $con = null;

	public function SetConnectionString($Server, $UserName, $Password, $Database)
	{
		$this->server = $Server;
		$this->userName = $UserName;
		$this->password = $Password;
		$this->database = $Database;		
	}
	
	public function OpenConnection()
	{
		$this->con = mysql_connect($this->server, $this->userName, $this->password);
		if (!$this->con)
		{
		  die($password . 'Could not connect: ' . mysql_error());
		}
	}
	
	public function RunQuery($SQL)
	{
		$this->OpenConnection();
		mysql_select_db($this->database,  $this->con);
		$result = mysql_query($SQL);
		$this->CloseConnection();		
		return $result;
	}
	
	public function ExecuteQuery($SQL)
	{
		$this->OpenConnection();
		mysql_select_db($this->database,  $this->con);
		$result = mysql_query($SQL);
		$this->CloseConnection();
		return $result;
	}
	
	
	public function CheckRecordAvailability($SQL)
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
	
	public function CloseConnection()
	{
		mysql_close($this->con);		
	}
}


?>