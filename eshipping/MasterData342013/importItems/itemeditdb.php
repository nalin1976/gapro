<?php 
session_start();
include("../../Connector.php");	

	$request=$_GET["REQUEST"];
	$itemname=	$_GET['ITEMNAME'];
	$unit=	$_GET['UNIT'];
	$commodity=$_GET['COMMODITY'];
	$remarks=	$_GET['REMARKS'];
	$itemcode=$_GET['CODE'];
	//die($itemcode);

if($request=="insert") 
	{		
		
	$sql = "INSERT INTO item ( strDescription,strCommodityCode, strRemarks,strUnit)
	VALUES ('$itemname','$commodity','$remarks','$unit')";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully saved."; 	
				
		}	
		
	
}
if ($request=="update")
{	

	$sql = "UPDATE item SET strDescription='$itemname',strCommodityCode='$commodity', strRemarks='$remarks', strUnit='$unit' WHERE strItemCode='$itemcode'";
	$result = $db->RunQuery($sql);
	
	
		if ($result)
		{		
			echo "Successfully updated."; 		
		}

}
if ($request=="delete")
{
$sql = "DELETE FROM item WHERE strItemCode='$itemcode'";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully deleted."; 	
		}

}
	


?>