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
		
		$sql = " SELECT intBuyerID,strName FROM buyers b where intStatus='1' order by strName " ;
			   
		$result = $this->dbConnection->RunQuery($sql);
		
		return $result;		
	}

	public function GetBuyerNameByCode($prmBuyerCode){

		$BuyerName = "";

		$sql = " SELECT intBuyerID,strName FROM buyers b where intStatus='1' and intBuyerID = '$prmBuyerCode'" ;
			   
		$result = $this->dbConnection->RunQuery($sql);

		$arrBuyer = mysql_fetch_row($result);

		$BuyerName = $arrBuyer[1];

		return $BuyerName;


	}
	
}


?>