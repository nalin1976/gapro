<?php

/**
 * @Prasad Rajapaksha 
 * @copyright 2008
 * Database Access Controller for Login Database 
 */

class LoginDBManager
{
/*private $server 	= 'localhost';
private $userName 	= 'root';
private $password 	= 'He20La13';
private $database 	= 'gaprodb';
*/

private $server 	= 'localhost:3306';
private $userName 	= 'root';
private $password 	= '';
private $database 	= 'gaprodb';
//private $database 	= 'epl';


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
