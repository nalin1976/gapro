<?php

/**
 * @Nalin Channa Jayakody
 * @copyright 2015
 * HelaClothing MIS Department
 *  
 */

class Location{
	
	private $dbConnection;
	
	public function SetConnection($connection){
            $this->dbConnection = $connection;	
	}
        
        public function GetLocationList(){
            
            $sql= "SELECT strName,intCompanyID FROM companies where intStatus='1' order by strName;";
            
            $result = $this->dbConnection->RunQuery($sql);
		
            return $result;	
            
        }
	
}

?>
