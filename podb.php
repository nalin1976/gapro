<?php
include "Connector.php";
$RequestType = $_GET["RequestType"];
if($RequestType=="URLLoadInstruPOPopup")
{
	$sql = "select distinct concat(PH.intYear,'/',PH.intPONo)as pono,PH.strInstructions from purchaseorderheader PH inner join purchaseorderdetails PD on PH.intPoNo=PD.intPoNo and PH.intYear=PD.intYear where PH.strInstructions Is Not Null and PH.strInstructions<>'' order by pono DESC";
	$result = $db->RunQuery($sql);	
	while($row=mysql_fetch_array($result))
	{
		$pr_arr.= $row['pono']."|";		 
	}
echo $pr_arr;
}
elseif($RequestType=="URLLoadPoInstruction")
{
$poArray = explode('/',$_GET["PoNo"]);
	$sql = "select strInstructions from purchaseorderheader where intPONo='$poArray[1]' and intYear='$poArray[0]'";
	$result = $db->RunQuery($sql);	
	while($row=mysql_fetch_array($result))
	{
		 $echo = $row["strInstructions"];
	}
echo $echo ;
}
?>