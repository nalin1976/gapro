<?php

/**
 * @Nalin Channa Jayakody
 * @copyright 2015
 * HelaClothing MIS Department
 *  
 */

class Buyer{
	
	private $dbConnection;
	
	public function SetConnection($connection){
		$this->dbConnection = $connection;	
	}
	
	public function GetBuyerList(){
		
		$sql = " SELECT intBuyerID,strName FROM buyers b where intStatus='1' " ;
			   
		$result = $this->dbConnection->RunQuery($sql);
		
		return $result;		
	}
	
}


?>