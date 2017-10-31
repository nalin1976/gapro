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

private $msserver   = '';
private $msuserName = '';
private $mspassword = '';
private $msdatabase = '';

private $con = null;
private $mscon = null;

	public function SetConnectionString($Server, $UserName, $Password, $Database)
	{
		$this->server = $Server;
		$this->userName = $UserName;
		$this->password = $Password;
		$this->database = $Database;		
	}
	
	public function SetConnectionStringMS($Server, $UserName, $Password, $Database)
	{
		$this->msserver   = $Server;
		$this->msuserName = $UserName;
		$this->mspassword = $Password;
		$this->msdatabase = $Database;		
	}
	
	public function OpenConnection()
	{
		$this->con = mysql_connect($this->server, $this->userName, $this->password);
		if (!$this->con)
		{
		  die($password . 'Could not connect: ' . mysql_error());
		}
	}
	
	public function OpenConnectionMS()
	{
		$this->mscon = mssql_connect($this->msserver, $this->msuserName, $this->mspassword);
		//return $msserver;  
		//echo $msuserName;
		//echo $mspassword; 
		//echo $msdatabase;
		/*if (!$this->mscon)
		{
		  die("Couldn't connect to Ms SQL Server on $msServer");
		}*/
	}
	
	public function RunQueryMS($SQL)
	{
		$this->OpenConnectionMS();
		mssql_select_db($this->msdatabase,$this->mscon);
		//createQueryString($SQL);
		$result = mssql_query($SQL);
		
		/*if(!$result>0)
		{
			failQueryMS($SQL);
		}*/
		//if (mysql_error())
		//echo mysql_error() . "<br>" . $SQL . "<br>";	
		//$this->CloseConnectionMS();		
		return $result;
		
	}
	
	public function RunQuery($SQL)
	{
		$this->OpenConnection();
		mysql_select_db($this->database,  $this->con);
		createQueryString($SQL);
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
		createQueryString($SQL);
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
		mysql_select_db($this->database,$this->con);
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
	
	public function setNULL($obj)
	{
		if($obj=="")
		{
			$obj='Null';
		}
		return $obj;
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
	global $_SESSION;
	global $_SERVER;
	$ip = "";
	 if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
	if ($_SERVER['HTTP_X_FORWARD_FOR']) 
	{
		$ip = $_SERVER['HTTP_X_FORWARD_FOR'];
	} 
	else 
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	//$ip = $REMOTE_ADDR;
	$userCode =  $_SESSION["UserID"];
	$sql="INSERT INTO queries(tableName,operation,sqlStatement,userID, IP) VALUES(\"".$tableName."\",".$operation.",\"".$query."\",\"".$userCode."\",\"".$ip."\");";
	mysql_query($sql);
}
?>