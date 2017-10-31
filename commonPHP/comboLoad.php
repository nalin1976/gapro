<?php
include "../Connector.php";


	$sql = $_GET["sql"];
	$result = $db->RunQuery($sql);
	$value = '<option value=""></option>';
	while($row = mysql_fetch_array($result))
	{
		$id = $row[0];
		$name= $row[1];
		$value.="<option value=\"$id\">".cdata($name)."</option>";
	}
	 
	 echo $value;
?>	
