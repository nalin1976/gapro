<?php

/**
 * @Prasad Rajapaksha 
 * @copyright 2008
 * Database Handling Module 
 */

class DBManager
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
		//if (mysql_error())
		//echo mysql_error() . "<br>" . $SQL . "<br>";	
		$this->CloseConnection();		
		return $result;
	}
	
	public function ExecuteQuery($SQL)
	{
		$this->OpenConnection();
		mysql_select_db($this->database,  $this->con);
		$result = mysql_query($SQL);
		//if (mysql_error())
			//echo mysql_error() . "<br>" . $SQL . "<br>";
		if (mysql_error())	
			$result = false;
		$this->CloseConnection();
		return $result;
	}
	
	public function AutoIncrementExecuteQuery($SQL)
	{
		$id = -1;
		$this->OpenConnection();
		mysql_select_db($this->database,  $this->con);
		$result = mysql_query($SQL);	
		//echo mysql_error();	
		$id =  mysql_insert_id();
		$this->CloseConnection();
		return $id;
	}
	
	public function AffectedExecuteQuery($SQL)
	{
		$id = 0;
		$this->OpenConnection();
		mysql_select_db($this->database,  $this->con);
		$result = mysql_query($SQL);	
		//echo mysql_error();	
		$id =  mysql_affected_rows();
		$this->CloseConnection();
		return $id;
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

function createQueryString($SQL)
{
	$query = strtoupper("#".$SQL);
	$query2 = "#".$SQL;
	$intPos = stripos($query,"INSERT INTO");
	if($intPos>0)
	{
		$strTable = trim(substr($query2,$intPos+11,strpos($query,"(")-($intPos+11)));
		saveQueries($strTable,1,$SQL);
	}
	else
	{
		$intPos = stripos($query,"UPDATE");
		if($intPos>0)
		{
				$strTable = trim(substr($query2,$intPos+6,strpos($query,"SET")-($intPos+6)));
				saveQueries($strTable,2,$SQL);
		}
		else
		{
				$intPos = stripos($query,"DELETE FROM");
				if($intPos>0)
				{
					$strTable = trim(substr($query2,$intPos+11,strpos($query,"WHERE")-($intPos+11)));
					saveQueries($strTable,3,$SQL);
				}
		}
	}
}
function saveQueries($tableName,$operation,$query)
{
	$sql="INSERT INTO queries(tableName,operation,sqlStatement) VALUES(\"".$tableName."\",".$operation.",\"".$query."\");";
	mysql_query($sql);
}
?>