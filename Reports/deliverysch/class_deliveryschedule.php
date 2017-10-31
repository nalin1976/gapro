<?php

class deliveryschedule{
	
	function GetBuyerList(){
		
		include "../../Connector.php"; 	
	
		$SQL = "SELECT intBuyerID, strName FROM buyers order by strName;";
		
		$result = $db->RunQuery($SQL);
		
		return 	$result;
		
	}
	
}


?>