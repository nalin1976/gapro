<?php
session_start();
//include "Connector.php";

?>

<script type="text/javascript">
<?php

$SQL = "select intID,strID,strDescription,preorderExcessallowed,preorderWastageAllowed from matmaincategory ";
$result = $db->RunQuery($SQL);
while($row = mysql_fetch_array($result))
{
	if ($row["preorderExcessallowed"])
	{
		echo "var "."_" . str_replace(" ","",$row["intID"]). "ExcessAllowed=true;\n";
	}
	else
	{
		echo "var "."_" . str_replace(" ","",$row["intID"]). "ExcessAllowed=false;\n";
	}
	
	if ($row["preorderWastageAllowed"])
	{
		echo "var "."_" . str_replace(" ","",$row["intID"]). "WastageAllowed=true;\n";
	}
	else
	{
		echo "var "."_" .str_replace(" ","",$row["intID"]). "WastageAllowed=false;\n";
	}
}
?>

</script>