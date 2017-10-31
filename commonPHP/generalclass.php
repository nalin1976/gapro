<?php
class GeneralClass{
	
	function GetMainStores(){
		
		global $db;
		
		$sql = " SELECT mainstores.strName, mainstores.strMainID ".
		       " FROM   mainstores ".
			   " WHERE  mainstores.intStatus =  '1'";
			   
		$result = $db->RunQuery($sql);		
		return $result;		
	}
	
	function GetCustomers(){
		
		global $db;
		
		$sql = " SELECT buyers.intBuyerID, buyers.strName ".
		       " FROM   buyers ".
			   " WHERE  buyers.intStatus =  '1'";
			   
		$result = $db->RunQuery($sql);		
		return $result;	   		
	}
	
	
	function GetMainCategoryList(){
		
		global $db;
		
		$sql = " SELECT matmaincategory.intID, matmaincategory.strDescription ".
		       " FROM matmaincategory";
		
		$result = $db->RunQuery($sql);
		return $result;
	}
	
}

?>