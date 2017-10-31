<?php

session_start();
$backwardseperator = "../";
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId  =$_SESSION["FactoryID"];
$userId		= $_SESSION["UserID"];

if($RequestType=="LoadMrnNo")
{
$mainStore	= $_GET["mainStore"];
	$ResponseXML  = ""; 
	$ResponseXML.="<LoadPopUpIssueNo>";
	
	 $SQL="SELECT distinct concat(MR.intMRNYear,'/',MR.intMatRequisitionNo) as MrnNo ".
			"FROM ".
			"matrequisition AS MR ".
			"Inner Join matrequisitiondetails AS MRD ".
			"ON MRD.intMatRequisitionNo = MR.intMatRequisitionNo AND MR.intMRNYear = MRD.intYear ".
			"Inner Join mainstores MS ON MS.strMainID=MR.strMainStoresID ".
			"WHERE MS.intCompanyId ='1' AND MS.strMainID ='$mainStore'  AND ".
			"round(MRD.dblBalQty,2) >'0' AND MR.intStatus = 10 Order By MR.intMatRequisitionNo ";
	$result=$db->RunQuery($SQL);
		$ResponseXML .= "<option value=\"".""."\">".""."</option>";
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"".$row["MrnNo"]."\">".$row["MrnNo"]."</option>"; 
	}
	$ResponseXML.="</LoadPopUpIssueNo>";
	echo $ResponseXML;
}else if($RequestType=="loadMrnDetailsToGrid")
{		
	$StyleId=$_GET["StyleId"];
$BuyerPoNo=$_GET["BuyerPoNo"];
	$StyleId="";
$BuyerPoNo="";

	$MrnYear=$_GET["mrnYear"];
	$MrnNo=$_GET["mrnNo"];
	$MatId=$_GET["MatId"];
	$MatId="";
	$mainStoreId = $_GET["mainStoreId"];
	$ResponseXML  = "";
	$ResponseXML .= "<loadMrnDetailsToGrid>";
	
	
		  $SQL1="SELECT distinct (MR.intMatRequisitionNo) as MrnNo,MR.intMRNYear, concat(MR.intMRNYear,'/',MR.intMatRequisitionNo) AS MrnYrNo ".
			"FROM ".
			"matrequisition AS MR ".
			"Inner Join matrequisitiondetails AS MRD ".
			"ON MRD.intMatRequisitionNo = MR.intMatRequisitionNo AND MR.intMRNYear = MRD.intYear ".
			"Inner Join mainstores MS ON MS.strMainID=MR.strMainStoresID ".
			"WHERE MS.intCompanyId ='1' AND MS.strMainID ='$mainStoreId'  AND ".
			"round(MRD.dblBalQty,2) >'0' AND MR.intStatus = 10 Order By MR.intMatRequisitionNo ";
	$result1=$db->RunQuery($SQL1);
		$ResponseXML .= "<option value=\"".""."\">".""."</option>";
	while($row1 = mysql_fetch_array($result1))
	{
		 $Mrn_No= $row1["MrnNo"];
		 $MRNYear= $row1["intMRNYear"];
		 $MrnYrNo= $row1["MrnYrNo"];
	
		
	
		$SQL = "select distinct concat(MH.intMRNYear,'/',MH.intMatRequisitionNo)AS MrnNo,
			date(dtmDate) as dtmDate,
			MH.intMRNYear,
			MH.intMatRequisitionNo,
			(select strDepartment from department D where MH.strDepartmentCode=D.intDepID)AS Department,
			(select UA.Name from useraccounts UA where MH.intUserId=UA.intUserID)AS IssueUser,
			 (SELECT strName FROM mainstores CO WHERE MH.strMainStoresID=CO.strMainID)AS Company,
			 (SELECT strMainStoresID FROM mainstores CO WHERE MH.strMainStoresID=CO.strMainID)AS CompanyID
			from matrequisition MH
			inner join matrequisitiondetails MD on MH.intMatRequisitionNo=MD.intMatRequisitionNo AND MH.intMRNYear=MD.intYear
			WHERE MH.intMRNYear=$MRNYear AND MH.intMatRequisitionNo='$Mrn_No' ";
	
		$result = $db->RunQuery($SQL);
	//echo $SQL;
			while($row = mysql_fetch_array($result))
			{
				$styleID = $row["intStyleId"];
				$StyleName = getStyleName($styleID);
				$grnType = $row["strGRNType"];
				
				$BuyerPOName = $row["strBuyerPONO"]; 
				if($row["strBuyerPONO"] != '#Main Ratio#')
					$BuyerPOName = getBuyerPOName($styleID,$BuyerPOName);
					
				$stockQty = getStockBalance($styleID,$BuyerPOName,$row["strMatDetailID"],$row["strColor"],$row["strSize"],$row["intGrnNo"],$row["intGrnYear"],$mainStoreId,$grnType);	
				
				switch($grnType)
				{
					case 'S':
					{
						$strGRNType = 'Style';
						break;
					}
					case 'B':
					{
						$strGRNType = 'Bulk';
						break;
					}
				} 
				 $ResponseXML .= "<MRNno><![CDATA[" . $row["MrnNo"]  . "]]></MRNno>\n";
				 $ResponseXML .= "<Date><![CDATA[" . $row["dtmDate"]  . "]]></Date>\n";
				 $ResponseXML .= "<Department><![CDATA[" . $row["Department"]  . "]]></Department>\n";
				 $ResponseXML .= "<IssueUser><![CDATA[" . $row["IssueUser"]  . "]]></IssueUser>\n";
				 $ResponseXML .= "<Company><![CDATA[" . $row["Company"] . "]]></Company>\n";
				  $ResponseXML .= "<CompanyID><![CDATA[" . $row["CompanyID"] . "]]></CompanyID>\n";
				 $ResponseXML .= "<Year><![CDATA[" . $row["intMRNYear"]  . "]]></Year>\n";
				  $ResponseXML .= "<No><![CDATA[" . $row["intMatRequisitionNo"]  . "]]></No>\n";
				 		 				
			}
	}
	$ResponseXML .= "</loadMrnDetailsToGrid>";
		echo $ResponseXML;

} 



else if($RequestType=="LoadMRNDetail")
{		


	$MrnYear=$_GET["year"];
	$MrnNo=$_GET["no"];
	
	
	
	//$mainStoreId = $_GET["mainStoreId"];
	$ResponseXML .= "<loadMrnDetailsToGrid>";
	

		
	
	$SQL = " SELECT MD.intStyleId AS intStyleId, MD.intGrnNo,MD.intGrnYear,
(select intSRNO from specification SP where SP.intStyleId=MD.intStyleId)AS SCNO, 
MD.strMatDetailID, MD.strBuyerPONO AS strBuyerPONO, 
MD.strColor AS strColor, MD.strSize AS strSize, MD.dblQty AS dblQty, round(MD.dblBalQty,2) as dblBalQty, MAT_L.strItemDescription, MAT_L.strUnit AS strUnit,
 strDescription,MD.strGRNType,
 IF(strGRNType='S','Style','Bulk') GrnType  
FROM matrequisitiondetails AS MD Inner Join matitemlist AS MAT_L ON MD.strMatDetailID = MAT_L.intItemSerial INNER JOIN matmaincategory MC ON 
MAT_L.intMainCatID = MC.intID 
 WHERE (MD.intMatRequisitionNo = '$MrnNo') AND (MD.intYear ='$MrnYear') AND (round(MD.dblBalQty,2) >  0) 
Order by MD.intStyleId ,MD.strMatDetailID,MD.strBuyerPONO,MD.strColor,MD.strSize, MD.intGrnNo,MD.intGrnYear ";
	
		$result = $db->RunQuery($SQL);
	echo $SQL;
			while($row = mysql_fetch_array($result))
			{
				
				 $ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDescription>\n";
				 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
				 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
				 $ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
				 $ResponseXML .= "<BalQty><![CDATA[" . round($row["dblBalQty"],2)  . "]]></BalQty>\n";
				 $ResponseXML .= "<MatDetailID><![CDATA[" . $row["strMatDetailID"]  . "]]></MatDetailID>\n";
				 $ResponseXML .= "<MatMainID><![CDATA[" . $row["strDescription"]  . "]]></MatMainID>\n";
				 $ResponseXML .= "<StockQty><![CDATA[" . round($stockQty,2)  . "]]></StockQty>\n";	
				 $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
				 $ResponseXML .= "<StyleName><![CDATA[" . $StyleName  . "]]></StyleName>\n";		
				 $ResponseXML .= "<BuyerPONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONO>\n";
				 $ResponseXML .= "<BuyerPOName><![CDATA[" . $BuyerPOName  . "]]></BuyerPOName>\n";
				 $ResponseXML .= "<SCNO><![CDATA[" . $row["SCNO"]  . "]]></SCNO>\n";
				 $ResponseXML .= "<GRNno><![CDATA[" . $row["intGrnNo"]  . "]]></GRNno>\n";
				 $ResponseXML .= "<GRNyear><![CDATA[" . $row["intGrnYear"]  . "]]></GRNyear>\n";
				 $ResponseXML .= "<grnType><![CDATA[" . $row["strGRNType"]  . "]]></grnType>\n";
				 $ResponseXML .= "<strGRNType><![CDATA[" . $row["GrnType"]  . "]]></strGRNType>\n";
				 		 				
			}
	
	$ResponseXML .= "</loadMrnDetailsToGrid>";
		echo $ResponseXML;

} 

function getStyleName($styleID)
{
	global $db;
	$SQL = " SELECT strOrderNo FROM orders WHERE intStyleId='$styleID' ";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strOrderNo"];	
}
function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}


function getStockBalance($styleId,$buyerPo,$matID,$color,$size,$grnNo,$grnYear,$storeID,$grnType)
{
	global $db;
	$SQL = " SELECT  sum(dblQty) as dblQty 
FROM stocktransactions s inner join mainstores m on 
m.strMainID = s.strMainStoresID
WHERE intStyleId='$styleId' AND strBuyerPoNo='$buyerPo' AND intMatDetailId='$matID' 
AND strColor='$color' AND strSize='$size' 
and intGrnNo = '$grnNo' and intGrnYear = '$grnYear' and m.strMainID='$storeID' and intStatus=1 and s.strGRNType = '$grnType'";
//echo $SQL;
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];
}










			?>