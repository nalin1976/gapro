<?php
session_start();
include "Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];

if($RequestType=="SavePartDetails")
{
	$StyleId 	=$_GET["StyleId"];
	$PartNo		=$_GET["PartNo"];
	$PartName	=$_GET["PartName"];
	$SMV		=$_GET["SMV"];
	$EFF		=$_GET["EFF"];
	$SMVRate 	=$_GET["SMVRate"];
        $PackSMV        =$_GET["pSMV"];
	
	$sqlDel="delete from stylepartdetails ".
			"where ".
			"intStyleId = '$StyleId' and intPartId = '$PartNo'";
	
	$db->executeQuery($sqlDel);	
		
	$sqlInsert="insert into stylepartdetails ".
				"(intStyleId, ".
				"intPartId, ".
				"intPartNo, ".
				"strPartName, ".
				"dblsmv, ".
				"dblSmvRate, ".
				"dblEffLevel, ".
				"intStatus, ".
                                "dblPackSMV) ".
				"values ".
				"('$StyleId', ".
				"'$PartNo', ".
				"'$PartNo', ".
				"'$PartName', ".
				"'$SMV', ".
				"'$SMVRate', ".
				"'$EFF', ".
				"'1',".
                                "'$PackSMV')";	
	
	$db->executeQuery($sqlInsert);	
//	===================================		
	$sqlsub="delete from stylepartdetails_sub ".
			"where ".
			"intStyleId = '$StyleId' and intPartId = '$PartNo'";
	
	$db->executeQuery($sqlsub);	
		
	$sqlsub="insert into stylepartdetails_sub ".
				"(intStyleId, ".
				"intPartId, ".
				"intPartNo, ".
				"strPartName, ".
				"dblCM, ".
				"dblTransportCost, ".
				"intStatus) ".
				"values ".
				"('$StyleId', ".
				"'$PartNo', ".
				"'$PartNo', ".
				"'$PartName', ".
				"'0', ".
				"'0', ".			
				"'1')";	
	
	$db->executeQuery($sqlsub);	
}
else if($RequestType=="CalculateEff")
{
	$SMV	=$_GET["SMV"];
	$Qty	=$_GET["Qty"];
	
	$ResponseXML .="<Calculate>\n";
	
	$SQL="SELECT efficiency_qty.strFromQty, efficiency_qty.strToQty, efficiency_smv.strFromSMV, ".
       	 "efficiency_smv.strToSMV, efficiency_qtysmvgrid.dblEfficiency ".
		 "FROM efficiency_qtysmvgrid ".
		 "INNER JOIN efficiency_qty ".
		 "ON efficiency_qtysmvgrid.intQtyID = efficiency_qty.intQtyID ".
		 "INNER JOIN efficiency_smv ".
		 "ON efficiency_qtysmvgrid.intSMVID = efficiency_smv.intSMVID ".
		 "WHERE ($Qty BETWEEN efficiency_qty.strFromQty AND efficiency_qty.strToQty) ".
		 "AND $SMV BETWEEN efficiency_smv.strFromSMV  AND efficiency_smv.strToSMV ".
		 "AND efficiency_qtysmvgrid.dblEfficiency > 0 ";
	//echo $SQL;
	$result=$db->RunQuery($SQL);
	
	while ($row=mysql_fetch_array($result))
	{		
		 $ResponseXML .= "<CalculateEff><![CDATA[" . $row["dblEfficiency"]  . "]]></CalculateEff>\n";		
	}
	
	$ResponseXML .="</Calculate>";
	echo $ResponseXML;
}
elseif($RequestType=="DeleteRow")
{
	$StyleId 	=$_GET["StyleId"];
	$PartNo 	=$_GET["PartNo"];
	
	$sqlDel="delete from stylepartdetails ".
			"where ".
			"intStyleId = '$StyleId' and intPartId = '$PartNo'";
	$db->executeQuery($sqlDel);	
}
?>