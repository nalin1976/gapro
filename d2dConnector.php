<?php
# Connect MYSQL Database 
# 2013/12/10 
#============================
class ClassConnectD2D{
	
private $strServerName = '172.23.1.136';
private $strDBName = 'hela_admin';
private $strUserName = 'root';
private $strPassword = 'He20La14';	
private $conD2DDb = null;
	
public function ConnectMYSQLDb(){
	
	#=========================================================
	# Connection settings for UBUNTU / LINUX environment
	#=========================================================	
		$this->conD2DDb = mysql_connect($this->strServerName, $this->strUserName, $this->strPassword);
			
		if(!$this->conD2DDb){
			die('Could not connect MY SQL server '. $this->strServerName);	
		}
	#=========================================================	

}


public function RunQuery($prmQuery){
	
	$this->ConnectMYSQLDb();
	
	#=========================================================
	# Connection settings for UBUNTU / LINUX environment
	#=========================================================
		mysql_select_db($this->strDBName, $this->conD2DDb);
		$QueryResult = mysql_query($prmQuery, $this->conD2DDb);
		
		
		if(!$QueryResult){
			die('MYSQL error '. mysql_error());	
		}else{
			return $QueryResult;	
		}
	#=========================================================
	
}
	
}


?>