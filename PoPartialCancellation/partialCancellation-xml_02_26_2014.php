<?php
include "../Connector.php";		
$id	= $_GET["id"];
$userId	= $_SESSION["UserID"];
header('Content-Type: text/xml');

if($id=="getPoDetails")
{
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLgetPoDetails>";
$poNo	= $_GET["poNo"];
$year	= $_GET["year"];
	
	$SQL="	SELECT PD.intStyleId,PD.intMatDetailID,MIL.strItemDescription,PD.strColor,PD.strSize,PD.strBuyerPONO,PD.strRemarks,PD.dblUnitPrice,			PD.dblPending,O.strOrderNo FROM purchaseorderdetails PD Inner Join purchaseorderheader PH ON PH.intPONo = PD.intPoNo AND PH.intYear = PD.intYear 			Inner Join matitemlist MIL ON MIL.intItemSerial = PD.intMatDetailID inner join orders O on O.intStyleId = PD.intStyleId WHERE PD.intYear =  '$year' AND PD.intPoNo =  '$poNo' AND PD.dblPending >  '0' 	";	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<StyleId><![CDATA[" . $row["intStyleId"]  . "]]></StyleId>\n";
		$ResponseXML .= "<OrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></OrderNo>\n";	
		$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"] . "]]></ItemDesc>\n";
		$ResponseXML .= "<ItemDescId><![CDATA[" . $row["intMatDetailID"] . "]]></ItemDescId>\n";
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";	
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";	
		$ResponseXML .= "<BuyerPO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPO>\n";	
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";	
		$ResponseXML .= "<UnitPrice><![CDATA[" . round($row["dblUnitPrice"],4) . "]]></UnitPrice>\n";	
		$ResponseXML .= "<POQty><![CDATA[" . round($row["dblPending"],2) . "]]></POQty>\n";	
		$ResponseXML .= "<Value><![CDATA[" . round($row["dblUnitPrice"]*$row["dblPending"],2)  . "]]></Value>\n";	
	}
$ResponseXML .= "</XMLgetPoDetails>\n";
echo $ResponseXML;
} 

if($id=="getPONo")
{
	
$year = $_GET["intYear"];
	
	$sql ="select distinct PH.intYear,PH.intPONo from purchaseorderheader PH inner join purchaseorderdetails PD on PD.intPoNo=PH.intPoNo and PD.intYear=PH.intYear where PH.intStatus=10 and PH.intConfirmedBy=$userId and PD.dblPending>0 and PH.intYear='$year';";
	$result = $db->RunQuery($sql);
		$str .= "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["intPONo"] ."\">" . trim($row["intPONo"]) ."</option>";
	}	
echo $str;
}
?>