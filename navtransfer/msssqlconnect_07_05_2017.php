<?php
# Connect MSSQL Database 
# 2013/12/10 
#============================
class ClassConnectMSSQL{
	
private $strServerName = '172.23.1.77';
private $strDBName = 'dbHela';
private $strUserName = 'sa';
private $strPassword = 'admin@123';	
private $conNAVIDb = null;
	
public function ConnectMSSQLDb(){
	
	#=========================================================
	# Connection settings for UBUNTU / LINUX environment
	#=========================================================	
		$this->conNAVIDb = mssql_connect($this->strServerName, $this->strUserName, $this->strPassword);
			
		if(!$this->conNAVIDb){
			die('Could not connect SQL server '. $this->strServerName);	
		}
	#=========================================================
	
	#=========================================================
	# Connection settings for WAMP 
	#=========================================================	
		/*$connectionSettings = array("UID"=>$this->strUserName, "PWD"=>$this->strPassword, "Database"=>$this->strDBName);
	
		$this->conNAVIDb = sqlsrv_connect($this->strServerName, $connectionSettings);
		
		if(!$this->conNAVIDb){
			echo "Error Connection to Navision";
		}*/
	#=========================================================
	
}


public function ExecuteQuery($prmQuery){
	
	$this->ConnectMSSQLDb();
	
	#=========================================================
	# Connection settings for UBUNTU / LINUX environment
	#=========================================================
		mssql_select_db($this->strDBName, $this->conNAVIDb);
		$QueryResult = mssql_query($prmQuery, $this->conNAVIDb);
		
		
		if(!$QueryResult){
			die('MSSQL error '. mssql_get_last_message());	
		}else{
			return $QueryResult;	
		}
	#=========================================================
	
	
	#=========================================================
	# Connection settings for WAMP 
	#=========================================================
	/*$QueryResult = sqlsrv_query($this->conNAVIDb, $prmQuery, array());
	if(!$QueryResult){
		return "Query Error";
	}else{
		return $QueryResult;	
	}*/
	#=========================================================
	
}
	
}


?>