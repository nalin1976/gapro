<?php
include "../Connector.php";


	$table 		= $_GET['table'];
	$idField 	= $_GET['idField'];
	$id 		= $_GET['id'];
	
	
	$sql = "update  $table set intUsed=1 where $idField=$id";
	$result = $db->RunQuery($sql);
	 
	 echo $result;
?>	