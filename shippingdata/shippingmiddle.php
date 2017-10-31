<?php
include "../Connector.php";
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$request=$_GET['req'];
if($request=="loadshipping")
{ 
	$ResponseXML="<XMLShippingdata>";
	$data=$_GET['data'];
	$booCheck = CheckSaveData($data);
	if($booCheck)
	{
		$result = GetOrderData($data);
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleID"]  . "]]></StyleID>\n";
			$ResponseXML .= "<PcsPerpack><![CDATA[" . $row["dblPcsPerPack"]  . "]]></PcsPerpack>\n";
			$ResponseXML .= "<Dimension><![CDATA[" . $row["strDimention"]  . "]]></Dimension>\n";
			$ResponseXML .= "<WashCode><![CDATA[" . $row["strWashCode"]  . "]]></WashCode>\n";
			$ResponseXML .= "<Qty><![CDATA[" . $row["intQty"]  . "]]></Qty>\n";
			$ResponseXML .= "<Vessal><![CDATA[" . $row["strVessal"]  . "]]></Vessal>\n";
			$ResponseXML .= "<VessalData><![CDATA[" . $row["dtVessalDate"]  . "]]></VessalData>\n";
			$ResponseXML .= "<Gender><![CDATA[" . $row["strGender"]  . "]]></Gender>\n";
			$ResponseXML .= "<Buyer><![CDATA[" . $row["intBuyerID"]  . "]]></Buyer>\n";
			$ResponseXML .= "<Name ><![CDATA[" . $row["strName"]  . "]]></Name>\n";
			$ResponseXML .= "<BuyerPoNo ><![CDATA[" . $row["strPONo"]  . "]]></BuyerPoNo>\n";		
			$ResponseXML .= "<GarmentType ><![CDATA[" . $row["strGrmtType"]  . "]]></GarmentType>\n";
			$ResponseXML .= "<QuataCat><![CDATA[" . $row["strQuataCat"]  . "]]></QuataCat>\n";
			$ResponseXML .= "<CtnType><![CDATA[" . $row["strCTNType"]  . "]]></CtnType>\n";
			$ResponseXML .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
			$ResponseXML .= "<FabricRefNo><![CDATA[" . $row["strFabricRefNo"]  . "]]></FabricRefNo>\n";
			$ResponseXML .= "<Mill><![CDATA[" . $row["strSupplierID"]  . "]]></Mill>\n";			
			$ResponseXML .= "<Mode><![CDATA[" . $row["intShipMode"]  . "]]></Mode>\n";
			$ResponseXML .= "<ShipmentTerm><![CDATA[" . $row["intShipTerm"]  . "]]></ShipmentTerm>\n";
			$ResponseXML .= "<PayMode><![CDATA[" . $row["intPayTerm"]  . "]]></PayMode>\n";
			$ResponseXML .= "<PaymentTer><![CDATA[" . $row[""]  . "]]></PaymentTer>\n";
			$ResponseXML .= "<Material><![CDATA[" . $row["strMaterial"]  . "]]></Material>\n";
			$ResponseXML .= "<Type><![CDATA[" . 1  . "]]></Type>\n";
		}
	}
	else
	{
		$result = GetOrdersData($data);
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<StyleID><![CDATA[" . $row["strStyle"]  . "]]></StyleID>\n";
			$ResponseXML .= "<Dimension><![CDATA[" . $row["dblDimension"]  . "]]></Dimension>\n";
			$ResponseXML .= "<WashCode><![CDATA[" . $row["strColorCode"]  . "]]></WashCode>\n";
			$ResponseXML .= "<Qty><![CDATA[" . $row["intQty"]  . "]]></Qty>\n";
			$ResponseXML .= "<Vessal><![CDATA[" . ""  . "]]></Vessal>\n";
			$ResponseXML .= "<VessalData><![CDATA[" . ""  . "]]></VessalData>\n";
			$ResponseXML .= "<Gender><![CDATA[" . ""  . "]]></Gender>\n";
			$ResponseXML .= "<Buyer><![CDATA[" . $row["intBuyerID"]  . "]]></Buyer>\n";
			$ResponseXML .= "<Name><![CDATA[" . $row["strName"]  . "]]></Name>\n";
			$ResponseXML .= "<GarmentType ><![CDATA[" . "" . "]]></GarmentType>\n";
			$ResponseXML .= "<QuataCat><![CDATA[" . ""  . "]]></QuataCat>\n";
			$ResponseXML .= "<CtnType><![CDATA[" . ""  . "]]></CtnType>\n";
			$ResponseXML .= "<Description><![CDATA[" . $row["strItemDescription"]  . "]]></Description>\n";
			$ResponseXML .= "<Material><![CDATA[" . ""  . "]]></Material>\n";
			$ResponseXML .= "<Mode><![CDATA[" . ""  . "]]></Mode>\n";		
			$ResponseXML .= "<BuyerPoNo><![CDATA[" . ""  . "]]></BuyerPoNo>\n";
			$ResponseXML .= "<FabricRefNo><![CDATA[" . $row["strFabricRefNo"]  . "]]></FabricRefNo>\n";
			$ResponseXML .= "<PayMode><![CDATA[" . ""  . "]]></PayMode>\n";
			
			$ResponseXML .= "<ShipmentTerm><![CDATA[" . $row[""]  . "]]></ShipmentTerm>\n";
			$ResponseXML .= "<PaymentTer><![CDATA[" . $row[""]  . "]]></PaymentTer>\n";
			$ResponseXML .= "<Mill><![CDATA[" . $row["strSupplierID"]  . "]]></Mill>\n";
			$ResponseXML .= "<PcsPerpack><![CDATA[" . $row[""]  . "]]></PcsPerpack>\n";			
			$ResponseXML .= "<Type><![CDATA[" . 0  . "]]></Type>\n";
		}	
	}
$ResponseXML .="</XMLShippingdata>"; 
echo $ResponseXML;
}
else if($request=="LoadOrderNo")
{
$styleNo	= $_GET["StyleNo"];
	$result = LoadOrderNo($styleNo);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
}

function CheckSaveData($orderId)
{
global $db;
	$boo = false;
	$sql="select intStyleID from orderdata where intStyleID='$orderId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$boo = true;
	}
return $boo;
}

function GetOrderData($data)
{
global $db;
$sql="SELECT intStyleID,dblPcsPerPack,strDimention,strWashCode,intQty,strVessal,dtVessalDate,strGender,intBuyerID ,strPONo,intPayTerm,intShipTerm,strGrmtType,strQuataCat,strDescription,strCTNType,intDestination,strName,strFabricRefNo,strSupplierID,intShipMode,strFabricRefNo,strMaterial FROM orderdata WHERE intStyleId='".$data."';";
return $db->RunQuery($sql);
}

function GetOrdersData($data)
{
global $db;
	$sql="select O.strStyle,O.dblDimension,O.strColorCode,O.intQty,O.intBuyerID,O.strFabricRefNo,MIL.strItemDescription,B.strName,O.strSupplierID from orders O inner join orderdetails OD on OD.intStyleId=O.intStyleId inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID inner join buyers B on B.intBuyerID=O.intBuyerID where OD.intMainFabricStatus=1 and O.intStyleId='".$data."';";
	return $db->RunQuery($sql);
}

function LoadOrderNo($styleNo)
{
global $db;
	$sql="select O.intStyleId,O.strOrderNo from orders O where O.strStyle like '%$styleNo%' order by O.strOrderNo";
	return $db->RunQuery($sql);
}
?>

