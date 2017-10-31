<?php
# Connect MYSQL Database 
# 2013/12/10 
#============================
class ClassConnectMYSQL{
	
private $strServerName = 'localhost';
private $strDBName = 'gapro';
private $strUserName = 'root';
private $strPassword = 'He20La14';	
private $conGAPRODb = null;
	
public function ConnectMYSQLDb(){
	
	#=========================================================
	# Connection settings for UBUNTU / LINUX environment
	#=========================================================	
		$this->conGAPRODb = mysql_connect($this->strServerName, $this->strUserName, $this->strPassword);
			
		if(!$this->conGAPRODb){
			die('Could not connect MY SQL server '. $this->strServerName);	
		}
	#=========================================================	

}


public function RunQuery($prmQuery){
	
	$this->ConnectMYSQLDb();
	
	#=========================================================
	# Connection settings for UBUNTU / LINUX environment
	#=========================================================
		mysql_select_db($this->strDBName, $this->conGAPRODb);
		$QueryResult = mysql_query($prmQuery, $this->conGAPRODb);
		
		
		if(!$QueryResult){
			die('MYSQL error '. mysql_error());	
		}else{
			return $QueryResult;	
		}
	#=========================================================
	
}
	
}


?>