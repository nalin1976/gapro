<?php
include "../Connector.php";


	$table 	= $_GET['table'];
	$field 	= $_GET['field'];
	$value 	= $_GET['value'];
	$idField= $_GET['idField'];
	$id 	= $_GET['id'];
	
	
	$sql = "select $field from $table where $field='$value' and $idField<>'$id'";
	$result = $db->RunQuery($sql);
	$output = false;
	while($row = mysql_fetch_array($result))
	{
		$output = true;
	}
	 
	 echo $output;
?>	