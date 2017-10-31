<?php
session_start();
include "../Connector.php";
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
$Opperation=$_GET["Opperation"];

	
	//echo($Opperation);
	
if(strcmp($Opperation,"getStyleBuyerPONo") == 0)
{	
	$StyleNo=$_GET["StyleNo"];

	
	
	
	$ResponseXML = "";
	$ResponseXML .= "<BuyerPONO>\n";
			 
	global $db;
	$strSQL="SELECT strBuyerPONO FROM style_buyerponos  WHERE intStyleId='$StyleNo'";
	
	$result=$db->RunQuery($strSQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<strBuyerPONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></strBuyerPONO>\n";
	}
	$ResponseXML .= "</BuyerPONO>";
	echo $ResponseXML;
			
}
else if(strcmp($Opperation,"getSubCategoies") == 0)
{	
	$StyleNo=$_GET["StyleNo"];
	$MainMatID=$_GET["MainMatID"];
	
	$ResponseXML = "";
	$ResponseXML .= "<Categories>\n";
			 
	global $db;
	$strSQL="SELECT   matsubcategory.StrCatName,  matitemlist.intSubCatID FROM  orderdetails  INNER JOIN orders ON (orderdetails.strOrderNo=orders.strOrderNo)  AND (orderdetails.intStyleId=orders.intStyleId)  INNER JOIN matitemlist ON (orderdetails.intMatDetailID=matitemlist.intItemSerial) INNER JOIN matsubcategory ON (matitemlist.intSubCatID=matsubcategory.intSubCatNo) WHERE  (orders.intStyleId = '$StyleNo') AND (matitemlist.intMainCatID = '$MainMatID') group by matsubcategory.StrCatName,  matitemlist.intSubCatID  ORDER BY matsubcategory.StrCatName";
	
	//echo($strSQL);
	
	$result=$db->RunQuery($strSQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<StrCatName><![CDATA[" . $row["StrCatName"]  . "]]></StrCatName>\n";
		$ResponseXML .= "<intSubCatID><![CDATA[" . $row["intSubCatID"]  . "]]></intSubCatID>\n";
	}
	$ResponseXML .= "</Categories>";
	echo $ResponseXML;
			
}

else if(strcmp($Opperation,"getItems") == 0)
{	
	$StyleNo=$_GET["StyleNo"];
	$MainMatID=$_GET["MainMatID"];
	$SubCatID=$_GET["SubCatID"];
	
	
	$ResponseXML = "";
	$ResponseXML .= "<Data>\n";
			 
	global $db;
	$strSQL="SELECT   matitemlist.strItemDescription,  matitemlist.intItemSerial FROM orderdetails INNER JOIN orders ON (orderdetails.strOrderNo=orders.strOrderNo)  AND (orderdetails.intStyleId=orders.intStyleId) INNER JOIN matitemlist ON (orderdetails.intMatDetailID=matitemlist.intItemSerial) WHERE  (orders.intStyleId = '$StyleNo') AND   (matitemlist.intMainCatID = '$MainMatID')AND   (matitemlist.intSubCatID = '$SubCatID')";
	
	$result=$db->RunQuery($strSQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<strItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></strItemDescription>\n";
		$ResponseXML .= "<intItemSerial><![CDATA[" . $row["intItemSerial"]  . "]]></intItemSerial>\n";
	}
	$ResponseXML .= "</Data>";
	echo $ResponseXML;
			
}
else if(strcmp($Opperation,"getMRNDetails") == 0)
{	
	$StyleNo=$_GET["StyleNo"];
	$MainMatID=$_GET["MainMatID"];
	$SubCatID=$_GET["SubCatID"];
	$MatDetailID=$_GET["MatDetailID"];
	$BuyerPO=$_GET["BuyerPO"];
	$optOption=$_GET["optOption"];
	
	$ResponseXML = "";
	$ResponseXML .= "<Data>\n";
			 
	global $db;
	$strSQL="SELECT   ISD.dblBalanceQty as dblBalanceQtytoIssue,  ISD.dblQty as issueQty,  MIL.strItemDescription, MIL.intMainCatID,  MIL.intSubCatID,  MRH.intMatRequisitionNo,  MRH.intMRNYear, DATE_FORMAT(MRH.dtmDate,'%Y/%c/%e') AS dtmDate ,  MRH.strDepartmentCode,  MRH.intRequestedBy,  MRH.intStatus,  MRH.intUserId,  MRH.intCompanyID,  MRD.intMatRequisitionNo,  MRD.intYear,  MRD.intStyleId,  MRD.strBuyerPONO,  MRD.strMatDetailID,  MRD.strColor,  MRD.strSize,  MRD.dblQty,  MRD.dblBalQty,  MRD.strNotes  FROM matrequisition MRH INNER JOIN matrequisitiondetails MRD ON (MRH.intMatRequisitionNo=MRD.intMatRequisitionNo)  AND (MRH.intMRNYear=MRD.intYear) INNER JOIN matitemlist MIL ON (MRD.strMatDetailID=MIL.intItemSerial) LEFT JOIN issuesdetails ISD ON (ISD.intMatRequisitionNo=MRD.intMatRequisitionNo)   AND (ISD.intMatReqYear=MRD.intYear)   AND  (MRD.intStyleId=ISD.intStyleId) WHERE (MRD.intStyleId = '$StyleNo') ";
  
  	if($optOption=="Confirmed")
	{
		$strSQL.="AND (MRH.intStatus = '10')";
	}
	
	else if($optOption=="Canceled")
	{
		$strSQL.="AND (MRH.intStatus = '0')";
	}
	
	else if($optOption=="BalancedToIssue")
	{
		$strSQL.="AND ( MRD.dblQty > 0)";
	}
	
	else if($optOption=="TotalIssued")
	{
		$strSQL.="AND ( MRD.dblQty =0)";
	}
	
	
   	if($BuyerPO!="0")
	{
		$strSQL.="AND (MRD.strBuyerPONO = '$BuyerPO')";
	}
	else if($BuyerPO=="0")
	{
  		$strSQL.="AND (MRD.strBuyerPONO = '#Main Ratio#')";
	}
	
	if($MainMatID!=0)
	{
  		$strSQL.="AND (MIL.intMainCatID = '$MainMatID')" ;
 	}
	
	if($SubCatID!=0)
	{
  		$strSQL.="AND (MIL.intSubCatID = '$SubCatID')" ;
  	}
	
	if($MatDetailID!=0)
	{
		$strSQL.="AND (MRD.strMatDetailID = '$MatDetailID')";
	}
	
	//$strSQL.="ORDER BY ";
	//echo $strSQL;
	
	$result=$db->RunQuery($strSQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<intMatRequisitionNo><![CDATA[" . $row["intMatRequisitionNo"]  . "]]></intMatRequisitionNo>\n";
		$styleName  = getStyleName($row["intStyleId"]);
		$ResponseXML .= "<strStyleNo><![CDATA[" . $styleName  . "]]></strStyleNo>\n";
		$ResponseXML .= "<dtmDate><![CDATA[" . $row["dtmDate"]  . "]]></dtmDate>\n";
		$ResponseXML .= "<strItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></strItemDescription>\n";
		$ResponseXML .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n";
		$ResponseXML .= "<strSize><![CDATA[" . $row["strSize"]  . "]]></strSize>\n";
		$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"]  . "]]></dblQty>\n";
		$ResponseXML .= "<issueQty><![CDATA[" . $row["issueQty"]  . "]]></issueQty>\n";
		$ResponseXML .= "<dblBalanceQtytoIssue><![CDATA[" . $row["dblBalanceQtytoIssue"]  . "]]></dblBalanceQtytoIssue>\n";
		
	}
	$ResponseXML .= "</Data>";
	echo $ResponseXML;
			
}

function getStyleName($styleID)
{
	global $db;
	
	$SQL = "select strStyle from orders where intStyleId='$styleID'";
	$result=$db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	
	return $row["strStyle"];
}
?>