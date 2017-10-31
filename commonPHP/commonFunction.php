<?php
include "../Connector.php";


	//$table 		= $_GET['table'];
	//$idField 	= $_GET['idField'];
	//$id 		= $_GET['id'];
	$id=$_GET['id'];
	
/*	function setUsed($table,$idField,$id)
	{
		$sql = "update  $table set intUsed=1 where $idField=$id";
		$result = $db->RunQuery($sql);
	}*/

	
	if($id=='getZipCode')
	{
		$countryId = $_GET['countryId'];
		
		$sql = "select strZipCode from country where intConID=$countryId";
		$result = $db->RunQuery($sql);
		while($row =mysql_fetch_array($result))
		{
			$zipCode = $row['strZipCode'];
		}
		echo $zipCode;
	}
	 

?>	