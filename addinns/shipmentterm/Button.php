<?php
	include "../../Connector.php";
	
	$strButton=$_GET["q"];
		
    $strShipmentTerm=trim($_GET["strShipmentTerm"],' ');
	$intStatus=$_GET["intStatus"];
	$shipmentCode=$_GET['strShipmentCode'];

	//----------------------------------------------------------------------------------------------
if($strButton=="New")
{
	$SQL_Check="SELECT * FROM shipmentterms where strShipmentTerm='$strShipmentTerm' AND intStatus != '10'";
	$result_check = $db->RunQuery($SQL_Check);	
	if(mysql_num_rows($result_check)){
		echo "Shipment Term already exists";			
	}
	else
	{
		$sql_insert  = "INSERT INTO shipmentterms (strShipmentTerm,strCode,intStatus) values('$strShipmentTerm','$shipmentCode','$intStatus')";
		$db->ExecuteQuery($sql_insert);	
		echo "Saved successfully";		  
	}
}
elseif($strButton=="Save")
{  
    $shipmentTerm_cboshipment=$_GET["shipmentTerm_cboshipment"];
	$shipmentCode=$_GET['strShipmentCode'];
    $strShipmentTerm=trim($_GET["strShipmentTerm"],' ');
	
     $SQL_Check1="SELECT * FROM shipmentterms where strShipmentTerm='$strShipmentTerm' AND intStatus != '10'";
	 $result_check1 = $db->RunQuery($SQL_Check1);	

	  $strShipmentTerm.$SQL_Check="SELECT strShipmentTermId,strShipmentTerm,intStatus FROM shipmentterms where                           strShipmentTermId='$shipmentTerm_cboshipment' AND intStatus != '10'";

	 $result_check = $db->RunQuery($SQL_Check);	
	 $row = mysql_fetch_array($result_check);
	$SQL_Update="UPDATE shipmentterms SET  strShipmentTerm='$strShipmentTerm',strCode='$shipmentCode',intStatus='$intStatus' WHERE strShipmentTermId='$shipmentTerm_cboshipment'"; 
	    $db->ExecuteQuery($SQL_Update);
		echo "Updated successfully";
}
elseif($strButton=="Delete")
{	
$shipmentTerm_cboshipment=$_GET["shipmentTerm_cboshipment"];
	$SQL="delete from shipmentterms  where strShipmentTermId='$shipmentTerm_cboshipment'";
 	$result = $db->RunQuery2($SQL);
 	if(gettype($result)=='string')
 	{
		echo $result;
		return;
 	}
	echo "Deleted successfully.";
}
else if($strButton =="loadshipTerms")
{
	$SQL = "SELECT shipmentterms.strShipmentTermId, shipmentterms.strShipmentTerm FROM shipmentterms order by strShipmentTerm ";

	$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strShipmentTermId"] ."\">" . $row["strShipmentTerm"] ."</option>" ;
	}
}	
?>