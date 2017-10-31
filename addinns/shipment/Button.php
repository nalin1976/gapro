<?php
	include "../../Connector.php";
	
	$strButton=$_GET["q"];
		
		$strDescription=trim($_GET["strDescription"],' ');
		$intStatus=$_GET["intStatus"];
		$strCode=$_GET["strCode"];
if($strButton=="New")
{
	$sql_insert  = "INSERT INTO shipmentmode (strDescription,strCode,intStatus) values
				  ('$strDescription','$strCode','$intStatus')";
	$db->ExecuteQuery($sql_insert);		
	echo "Saved successfully.";		
}
elseif($strButton=="Save")
{  
$cboshipment=$_GET["cboshipment"];
$strCode=$_GET["strCode"];
$strDescription=trim($_GET["strDescription"],' ');
	
	$SQL_Check1="SELECT * FROM shipmentmode where strDescription='$strDescription' AND intStatus != '10'";
	$result_check1 = $db->RunQuery($SQL_Check1);	
	
	$SQL_Check="SELECT intShipmentModeId,strDescription,intStatus FROM shipmentmode where                           intShipmentModeId='$cboshipment' AND intStatus != '10'";
	
	$result_check = $db->RunQuery($SQL_Check);	
	$row = mysql_fetch_array($result_check);
	
	$SQL_Update="UPDATE shipmentmode SET  strDescription='$strDescription',strCode='$strCode',
		intStatus='$intStatus' 
		WHERE intShipmentModeId='$cboshipment'"; 
	$db->ExecuteQuery($SQL_Update);
	echo "Updated successfully.";
}
elseif($strButton=="Delete")
{	
$cboshipment=$_GET["cboshipment"];
	$SQL="delete from shipmentmode  where intShipmentModeId='$cboshipment'";
	$result = $db->RunQuery2($SQL);
	 if(gettype($result)=='string')
	 {
		echo $result;
		return;
	 }	
	 echo "Deleted successfully.";
}		 
else if($strButton =="loadshipModes")
{
	$SQL = "SELECT shipmentmode.intShipmentModeId, shipmentmode.strDescription FROM shipmentmode where intStatus<>10   order by strDescription;";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intShipmentModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
}
?>