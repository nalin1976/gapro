<?php
$backwardseperator = "../";
	include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId  =$_SESSION["FactoryID"];
$userId		= $_SESSION["UserID"];

if($RequestType=="loadStyle")
{	
$styleNo	= $_GET["styleNo"];
$mainStore	= $_GET["mainStore"];
	$ResponseXML  = "";
	$ResponseXML .= "<loadStyle>";
	$arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	$SQL="SELECT DISTINCT ". 
		 "SP.intSRNO, ".
		 "SP.intStyleId, ".
		 "MS.intCommonBin, ".
		 " O.strOrderNo ".
		 " FROM ".
		 "matrequisitiondetails AS MRD ".
		 "Inner Join specification AS SP ON MRD.intStyleId = SP.intStyleId ".
		 "Inner Join matrequisition AS MRH ON MRH.intMatRequisitionNo = MRD.intMatRequisitionNo ". 
		 "Inner Join mainstores MS ON MS.strMainID=MRH.strMainStoresID ".
		 "Inner Join orders O on O.intStyleId = SP.intStyleId ".
		 " AND MRD.intYear = MRH.intMRNYear  ".
		 "WHERE ".
		 "MS.intCompanyId ='$companyId' and MS.intStatus = 1 and O.intStatus in($headerPub_AllowOrderStatus) ".
		 "AND round(MRD.dblBalQty,2) >0 and MRH.intStatus=10 ";
		 
		 if($styleNo!="")
			$SQL.="and O.strStyle='$styleNo' ";
			
		 if($mainStore!="")
			$SQL.="and MS.strMainID='$mainStore' ";
		
		# ====================================================
		# Comment On - 03/07/2014
		# Description - If using 'ORDER BY' clause query load getting slow
		# Comment By - Nalin Jayakody
		# ====================================================
		// $SQL.="ORDER BY O.strOrderNo ASC";	
		# ====================================================
		
		$result = $db->RunQuery($SQL);		
		while($row = mysql_fetch_array($result))
		{
			 $ResponseXML .= "<CommonBin><![CDATA[" . $row["intCommonBin"]  . "]]></CommonBin>\n";
			 //$ResponseXML .= "<SRNO><![CDATA[" . GetSCNo($styleNo,$mainStore) . "]]></SRNO>\n";
			 $ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"]  . "]]></StyleID>\n"; 	
			 $ResponseXML .= "<StyleName><![CDATA[" . $row["strOrderNo"]  . "]]></StyleName>\n"; 		
		}
			$ResponseXML .= "<SRNO><![CDATA[" . GetSCNo($styleNo,$headerPub_AllowOrderStatus) . "]]></SRNO>\n";
	$ResponseXML .= "</loadStyle>";
	echo $ResponseXML;

}
else if($RequestType=="LoadStyleNo")
{	
$mainStore	= $_GET["mainStore"];
	$ResponseXML  = "";
	$ResponseXML .= "<loadStyle>";
	$arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	
	$SQL="SELECT DISTINCT  O.strStyle FROM matrequisitiondetails AS MRD Inner Join matrequisition AS MRH ON MRH.intMatRequisitionNo = MRD.intMatRequisitionNo and MRD.intYear = MRH.intMRNYear Inner Join mainstores MS ON MS.strMainID=MRH.strMainStoresID Inner Join orders O on MRD.intStyleId = O.intStyleId WHERE MS.intCompanyId ='$companyId' and MS.strMainID='$mainStore' and MS.intStatus = 1 and O.intStatus in($headerPub_AllowOrderStatus) AND round(MRD.dblBalQty,2) >0 and MRH.intStatus=10 ORDER BY O.strStyle ";			 
	$result = $db->RunQuery($SQL);
			 $ResponseXML .= "<option value=\"".""."\">"."Select One"."</option>"; 
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<option value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>"; 		
	}
			
	$ResponseXML .= "</loadStyle>";
	echo $ResponseXML;

} 
else if($RequestType=="LoadMaterial")
{
$ResponseXML = "<LoadMaterial>";
	
	$SQL="select intID,strDescription from matmaincategory";	
	$result =$db->RunQuery($SQL);
		$ResponseXML .= "<option value=\"".""."\">".""."</option>";
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"".$row["intID"]."\">".$row["strDescription"]."</option>";
	}	
$ResponseXML .="</LoadMaterial>";
echo $ResponseXML;
}
else if($RequestType=="LoadBuyerPoNo")
{		
	$strStyleName=$_GET["strStyleName"];
	$ResponseXML  = "";
	$ResponseXML .= "<BuyerPONO>";
			
		$SQL="select distinct strBuyerPONO,intStyleId  from matrequisitiondetails where intStyleId = '" . $strStyleName ."' ORDER BY strBuyerPONO ";
		/*$SQL = "SELECT DISTINCT SB.strBuyerPONO, SB.strBuyerPoName
FROM style_buyerponos SB INNER JOIN matrequisitiondetails MD ON MD.intStyleId = SB.intStyleId AND MD.strBuyerPONO= SB.strBuyerPONO
WHERE SB.intStyleId='$strStyleName'";*/

		$result = $db->RunQuery($SQL);
		
			while($row = mysql_fetch_array($result))
			{
				$BuyerPOName = $row["strBuyerPONO"];
				if($row["strBuyerPONO"] != '#Main Ratio#')
					$BuyerPOName = getBuyerPOName($strStyleName,$row["strBuyerPONO"]);
					
				 $ResponseXML .= "<BuyerPOid><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPOid>\n";
				  $ResponseXML .= "<BuyerPOName><![CDATA[" . $BuyerPOName  . "]]></BuyerPOName>\n";
			}
			
	$ResponseXML .= "</BuyerPONO>";
		echo $ResponseXML;

} 
else if($RequestType=="loadProductionLineNo")
{		
	$mrnno	= $_GET["mrnno"];
		$mrnnoArray	= explode('/',$mrnno);
	$ResponseXML .= "<loadProductionLineNo>";
			
		$SQL="SELECT ".
			 "MR.strDepartmentCode ".
			 "FROM ".
			 "matrequisition AS MR ".			
			 "WHERE ".
			 "MR.intMatRequisitionNo =  '$mrnnoArray[1]' AND ".
			 "MR.intMRNYear =  '$mrnnoArray[0]';";
		
		$result = $db->RunQuery($SQL);
		
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<Department><![CDATA[" . $row["strDepartmentCode"]  . "]]></Department>\n";
				 
			}
			
	$ResponseXML .= "</loadProductionLineNo>";
		echo $ResponseXML;

} 
else if($RequestType=="LoadMrnNo")
{		
	$strStyleName=$_GET["strStyleName"];
	$strBuyerPoNo=$_GET["strBuyerPoNo"];
	$strMainStore = $_GET["strMainStore"];
	
	$ResponseXML  = "";
	$ResponseXML .= "<LoadMrnNo>";
			
	$SQL="SELECT DISTINCT concat(matrequisition.intMRNYear,'/',matrequisition.intMatRequisitionNo) as strMrnNo ".
		 "FROM matrequisition INNER JOIN ".
		 "     matrequisitiondetails ON matrequisition.intMatRequisitionNo = matrequisitiondetails.intMatRequisitionNo ".
		"     WHERE     (matrequisitiondetails.intStyleId = '" . $strStyleName . "') ".
		 "     AND (matrequisition.intStatus =10) ".
		 "     AND (matrequisitiondetails.strBuyerPONO = '" . $strBuyerPoNo . "') ".			 
		 "     AND round(matrequisitiondetails.dblBalQty,2) >0 ".
		 "     AND (matrequisition.strMainStoresID='$strMainStore')";
	$result = $db->RunQuery($SQL);
		 $ResponseXML .= "<option value=\"".""."\">".""."</option>"; 
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<option value=\"".$row["strMrnNo"]."\">".$row["strMrnNo"]."</option>"; 
	}			
	$ResponseXML .= "</LoadMrnNo>";
		echo $ResponseXML;

} 

else if($RequestType=="loadMrnDetailsToGrid")
{		
	$StyleId=$_GET["StyleId"];
	$BuyerPoNo=$_GET["BuyerPoNo"];

	$MrnYear=$_GET["mrnYear"];
	$MrnNo=$_GET["mrnNo"];
	$MatId=$_GET["MatId"];
	$mainStoreId = $_GET["mainStoreId"];
	$ResponseXML  = "";
	$ResponseXML .= "<loadMrnDetailsToGrid>";
			 
		 /* $SQL ="SELECT ".
				"MD.intStyleId AS intStyleId, ".
				"(select intSRNO from specification SP where SP.intStyleId=MD.intStyleId)AS SCNO, ".
				"MD.strMatDetailID, ".
				"MD.strBuyerPONO AS strBuyerPONO, ".
				"MD.strColor AS strColor, ".
				"MD.strSize AS strSize, ".
				"MD.dblQty AS dblQty, ".
				"MD.dblBalQty, ".
				"MAT_L.strItemDescription, ".
				"MAT_L.strUnit AS strUnit, ".
				"strDescription, ".
				//"Sum(STOCK_T.dblQty) AS dblStockQty ".
				"(STOCK_T.dblQty) AS dblStockQty, ".
				"  MD.intGrnNo,MD.intGrnYear ".
				"FROM ".
				"matrequisitiondetails AS MD ".
				"Inner Join matitemlist AS MAT_L ON MD.strMatDetailID = MAT_L.intItemSerial ".
				"INNER JOIN matmaincategory MC ON MAT_L.intMainCatID = MC.intID ".
				"Inner Join stocktransactions AS STOCK_T ON STOCK_T.intStyleId = MD.intStyleId AND STOCK_T.strBuyerPoNo = MD.strBuyerPONO AND STOCK_T.intMatDetailId = MD.strMatDetailID AND STOCK_T.strColor = MD.strColor AND STOCK_T.strSize = MD.strSize ".
				"Inner Join mainstores AS MS ON STOCK_T.strMainStoresID = MS.strMainID  ".
				" and MD.intGrnNo = STOCK_T.intGrnNo and MD.intGrnYear=STOCK_T.intGrnYear ".
				"WHERE ".				
				"(MD.intMatRequisitionNo = '" . $MrnNo . "') AND ".
				"(MD.intYear ='" . $MrnYear . "') AND ".				
				"(MD.dblBalQty >  0) AND ".
				"MS.intCompanyId ='$companyId' ";*/
				
				#==============================================================
				# Comment On - 03/07/2015 
				# Comment By - Nalin Jayakody
				# Description - To add UOM in the BOM, currently it takes UOM in the item master file
				#==============================================================
				
				/*$SQL = " SELECT MD.intStyleId AS intStyleId, MD.intGrnNo,MD.intGrnYear,
(select intSRNO from specification SP where SP.intStyleId=MD.intStyleId)AS SCNO, 
MD.strMatDetailID, MD.strBuyerPONO AS strBuyerPONO, 
MD.strColor AS strColor, MD.strSize AS strSize, MD.dblQty AS dblQty, round(MD.dblBalQty,2) as dblBalQty, MAT_L.strItemDescription, MAT_L.strUnit AS strUnit,
 strDescription,MD.strGRNType  
FROM matrequisitiondetails AS MD Inner Join matitemlist AS MAT_L ON MD.strMatDetailID = MAT_L.intItemSerial INNER JOIN matmaincategory MC ON 
MAT_L.intMainCatID = MC.intID */
                
				#==============================================================
				
				$SQL = " SELECT MD.intStyleId AS intStyleId, MD.intGrnNo,MD.intGrnYear,
(select intSRNO from specification SP where SP.intStyleId=MD.intStyleId)AS SCNO, 
MD.strMatDetailID, MD.strBuyerPONO AS strBuyerPONO, 
MD.strColor AS strColor, MD.strSize AS strSize, MD.dblQty AS dblQty, round(MD.dblBalQty,2) as dblBalQty, MAT_L.strItemDescription, specificationdetails.strUnit  AS strUnit,
 strDescription,MD.strGRNType  
FROM matrequisitiondetails AS MD Inner Join matitemlist AS MAT_L ON MD.strMatDetailID = MAT_L.intItemSerial INNER JOIN matmaincategory MC ON 
MAT_L.intMainCatID = MC.intID Inner Join materialratio ON materialratio.intStyleId = MD.intStyleId and materialratio.strMatDetailID = MD.strMatDetailID and materialratio.strColor = MD.strColor and materialratio.strSize = MD.strSize and materialratio.strBuyerPONO = MD.strBuyerPONO
Inner Join specificationdetails ON specificationdetails.intStyleId = materialratio.intStyleId and specificationdetails.strMatDetailID = materialratio.strMatDetailID
 WHERE (MD.intMatRequisitionNo = '$MrnNo') AND (MD.intYear ='$MrnYear') AND (round(MD.dblBalQty,2) >  0) ";
				
		if($StyleId!="")
			$SQL .=" AND MD.intStyleId='$StyleId'";
			
		if($BuyerPoNo!="")
			$SQL .=" AND MD.strBuyerPONO='$BuyerPoNo'";	
			
		if ($MatId!="")
		{
			$SQL .=" AND MAT_L.intMainCatID='$MatId' ";
		}
		$SQL .= " Order by MD.intStyleId ,MD.strMatDetailID,MD.strBuyerPONO,MD.strColor,MD.strSize, MD.intGrnNo,MD.intGrnYear ";
		//$SQL .=" GROUP BY MD.intStyleId ,MD.strMatDetailID,MD.strBuyerPONO,MD.strColor,MD.strSize ";
	//	echo $SQL;
		$result = $db->RunQuery($SQL);
		
			while($row = mysql_fetch_array($result))
			{
				$styleID = $row["intStyleId"];
				$StyleName = getStyleName($styleID);
				$grnType = $row["strGRNType"];
				
				$BuyerPOName = $row["strBuyerPONO"]; 
				if($row["strBuyerPONO"] != '#Main Ratio#')
                                        $BuyerPOName =  getBuyerPONameForChange($styleID,$BuyerPOName);
					//$BuyerPOName = getBuyerPOName($styleID,$BuyerPOName);
					
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
				 $ResponseXML .= "<grnType><![CDATA[" . $grnType  . "]]></grnType>\n";
				 $ResponseXML .= "<strGRNType><![CDATA[" . $strGRNType  . "]]></strGRNType>\n";
				 				
			}
	$ResponseXML .= "</loadMrnDetailsToGrid>";
		echo $ResponseXML;

} 
else if($RequestType=="GetLoadSavedDetails")
{
	$issueNoFrom = $_GET["issueNoFrom"];
	$issueYearFrom =$_GET["issueYearFrom"];
	$issueNoTo	=$_GET["issueNoTo"];
	$issueYearTo =$_GET["issueYearTo"];
	$chkdate = $_GET["chkbox"];
	$issueDateFrom =$_GET["issueDateFrom"];	
	$DateFromArray=explode('/',$issueDateFrom);
	$formatedfromDate=$DateFromArray[2]."-".$DateFromArray[1]."-".$DateFromArray[0];
	$issueDateTo=$_GET["issueDateTo"];
	$DateToArray=explode('/',$issueDateTo);
	$formatedToDate=$DateToArray[2]."-".$DateToArray[1]."-".$DateToArray[0];
	
	$ResponseXML .= "<GetLoadSavedDetails>";
	
	$SQL ="SELECT concat(intIssueYear,'/',intIssueNo) as intIssueNo , dtmIssuedDate ,strSecurityNo ,intStatus FROM  issues WHERE intStatus = 1 AND intCompanyID='$companyId'";
	
	if ($issueYearFrom!="")
	{
			$SQL .="AND intIssueNo >='" . $issueNoFrom . "' AND intIssueYear = '" . $issueYearFrom . "' "; 
	}
	if ($issueYearTo!="")
	{
			$SQL .="AND intIssueNo <='" . $issueNoTo . "' AND intIssueYear = '" . $issueYearTo . "' ";
	}
		if ($chkdate=="true")
		{
			if ($issueDateFrom!="")
			{
					$SQL .="AND dtmIssuedDate >= '" . $formatedfromDate . "' ";
			}
			if ($issueDateTo!="")
			{
					$SQL .="AND dtmIssuedDate <= '" . $formatedToDate . "' ";
			}
		}
	 
	$result = $db->RunQuery($SQL);
	
	while ($row = mysql_fetch_array($result))	
	{
		$ResponseXML .= "<IssueNo><![CDATA[" . $row["intIssueNo"]  . "]]></IssueNo>\n";
		$ResponseXML .= "<IssuedDate><![CDATA[" . $row["dtmIssuedDate"]  . "]]></IssuedDate>\n";
		$ResponseXML .= "<SecurityNo><![CDATA[" . $row["strSecurityNo"]  . "]]></SecurityNo>\n";
		$ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n";
	}
	$ResponseXML .= "</GetLoadSavedDetails>";
		echo $ResponseXML;
}
else if ($RequestType=="GetBinDetails")
{
	$styleId =$_GET["styleId"];
	$buyerPoNo =$_GET["buyerPoNo"];

	$matdetailId =$_GET["matdetailId"];
	$color =$_GET["color"];
	$size =$_GET["size"];
	$mainStoreId = $_GET["mainStoreId"];
	$grnNo = $_GET["grnNo"];
	$arrGRNno = explode('/',$grnNo);
	$intGRNyear = $arrGRNno[0];
	$intGRNno = $arrGRNno[1];
	$grnType = $_GET["grnType"];
	
	$ResponseXML .="<GetBinDetails>";	

$SQL="SELECT ST.strBin,
	SB.strBinName,
	ST.strType, 
	Sum(dblQty) AS dblstockBal, 
	ST.strMainStoresID,
	MS.strName,
	ST.strSubStores,
	SS.strSubStoresName,
	ST.strLocation,
	SL.strLocName,
	ST.strUnit,
	MIL.intSubCatID 
	FROM stocktransactions AS ST 
	Inner Join mainstores MS ON MS.strMainID = ST.strMainStoresID 
	Inner Join storesbins SB On SB.strBinID=ST.strBin and SB.strMainID=ST.strMainStoresID and SB.strSubID=ST.strSubStores and SB.strLocID=ST.strLocation
	Inner Join substores SS on SS.strSubID=ST.strSubStores and SS.strMainID=ST.strMainStoresID
	Inner Join storeslocations SL on SL.strLocID=ST.strLocation and SL.strMainID=ST.strMainStoresID and SL.strSubID=ST.strSubStores
	Inner Join matitemlist MIL on MIL.intItemSerial=ST.intMatDetailId
	WHERE ST.intStyleId ='$styleId' 
	AND ST.strBuyerPoNo ='$buyerPoNo' 
	AND ST.intMatDetailId ='$matdetailId' 
	AND ST.strColor ='$color' 
	AND ST.strSize ='$size' 
	AND MS.strMainID ='$mainStoreId' and ST.intGrnNo='$intGRNno' and ST.intGrnYear='$intGRNyear' and ST.strGRNType='$grnType'
	GROUP BY ST.strBin, ST.strLocation, ST.strSubStores, ST.strMainStoresID";
	//echo $SQL;
	$result = $db->RunQuery($SQL);
	
	while ($row = mysql_fetch_array($result))
	{
		$ResponseXML .="<Bin><![CDATA[" . $row["strBin"] . "]]></Bin>\n";
		$ResponseXML .="<stockBal><![CDATA[" . round($row["dblstockBal"],2) . "]]></stockBal>\n";
		$ResponseXML .="<MainStoresID><![CDATA[" . $row["strMainStoresID"] . "]]></MainStoresID>\n";
		$ResponseXML .="<SubStore><![CDATA[" . $row["strSubStores"] . "]]></SubStore>\n";
		$ResponseXML .="<Location><![CDATA[" . $row["strLocation"] . "]]></Location>\n";
		$ResponseXML .="<Unit><![CDATA[" . $row["strUnit"] . "]]></Unit>\n";
		$ResponseXML .="<MatSubCatID><![CDATA[" . $row["intSubCatID"] . "]]></MatSubCatID>\n";
		
		$ResponseXML .="<BinName><![CDATA[" . $row["strBinName"] . "]]></BinName>\n";
		$ResponseXML .="<MainStoreName><![CDATA[" . $row["strName"] . "]]></MainStoreName>\n";
		$ResponseXML .="<SubStoresName><![CDATA[" . $row["strSubStoresName"] . "]]></SubStoresName>\n";
		$ResponseXML .="<LocationName><![CDATA[" . $row["strLocName"] . "]]></LocationName>\n";
	}
	$ResponseXML .="</GetBinDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="getItemStockQty")
{
	$styleId =$_GET["styleId"];
	$buyerPo =$_GET["buyerPo"];
	$matId =$_GET["matId"];
	$color =$_GET["color"];
	$size =$_GET["size"];
	$mainstore = $_GET["mainstore"];
	$grnNo = $_GET["grnNo"];
	$arrGRNno = explode('/',$grnNo);
	$intGRNyear = $arrGRNno[0];
	$intGRNno = $arrGRNno[1];
	$grnType = $_GET["grnType"];
	$issueQty = $_GET["issueQty"];
	
	$ResponseXML .="<GetBinDetails>";
	//check stock availability
	$sql = "select sum(dblQty) as Qty,strSubStores,strLocation,strBin,strMainStoresID,mil.intSubCatID
from stocktransactions st inner join matitemlist mil on
mil.intItemSerial = st.intMatDetailId
where strMainStoresID='$mainstore' and intStyleId='$styleId' and strBuyerPoNo='$buyerPo' and strColor='$color' and strSize='$size' and intGrnNo='$intGRNno' and intMatDetailId='$matId'
and intGrnYear='$intGRNyear' and strGRNType='$grnType'
group by strSubStores,strLocation,strBin,mil.intSubCatID
having Qty>0";

	$result =$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		//check stock Qty is equal or greater than issue Qty
		$stockQty = $row["Qty"];
		if($stockQty>=$issueQty)
		{
			$ResponseXML .="<result><![CDATA[true]]></result>\n";
			$ResponseXML .="<SubStore><![CDATA[" . $row["strSubStores"] . "]]></SubStore>\n";
			$ResponseXML .="<Location><![CDATA[" . $row["strLocation"] . "]]></Location>\n";
			$ResponseXML .="<Bin><![CDATA[" . $row["strBin"] . "]]></Bin>\n";
			$ResponseXML .="<subCategory><![CDATA[" . $row["intSubCatID"] . "]]></subCategory>\n";
			$ResponseXML .="</GetBinDetails>";
			echo $ResponseXML;
			return;	
		}
	}
	$ResponseXML .="<result><![CDATA[false]]></result>\n";
	$ResponseXML .="</GetBinDetails>";
	echo $ResponseXML;	
}
else if($RequestType=="LoadIssueno")
{
//Start - 15-10-2010 (Comment this and wrote a code to get issue no from the syscontrol)
/* 	$NextIssueNo = IssueNo."".$companyId;
    
	$ResponseXML .="<LoadIssueno>";
	
		$SQL="select strValue AS issueNo from settings where strKey = '$NextIssueNo' ";		
		
		$result =$db->RunQuery($SQL);
	
				while($row = mysql_fetch_array($result))
				{
					$issueYear = date('Y');
					$ResponseXML .= "<issueNo><![CDATA[" . $row["issueNo"] . "]]></issueNo>\n";	
					$ResponseXML .= "<issueYear><![CDATA[" . $issueYear. "]]></issueYear>\n";				
					
					$issue=$row["issueNo"]+ 1;
				}
				
			
				$sql = "update settings set strValue =$issue where strKey = '$NextIssueNo' ";
				$db->executeQuery($sql);
		
	$ResponseXML .="</LoadIssueno>";
		echo $ResponseXML;*/
//End - 15-10-2010 (Comment this and wrote a code to get issue no from the syscontrol)		

//Start - 15-10-2010 (wrote a code to get issue no from the syscontrol)    
	$No=0;
	$ResponseXML .="<LoadIssueno>\n";
	
	$Sql="select intCompanyID,dblSIssueNo from syscontrol where intCompanyID='$companyId'";
	$result =$db->RunQuery($Sql);	
	$rowcount = mysql_num_rows($result);
	
	if ($rowcount > 0)
	{	
			while($row = mysql_fetch_array($result))
			{				
				$No=$row["dblSIssueNo"];
				$NextNo=$No+1;
				$ReturnYear = date('Y');
				$sqlUpdate="UPDATE syscontrol SET dblSIssueNo='$NextNo' WHERE intCompanyID='$companyId';";
				$db->executeQuery($sqlUpdate);			
				$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";		
				$ResponseXML .= "<issueNo><![CDATA[".$No."]]></issueNo>\n";
				$ResponseXML .= "<issueYear><![CDATA[".$ReturnYear."]]></issueYear>\n";
			}
	}
	else
	{
		$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
	}	
$ResponseXML .="</LoadIssueno>";
echo $ResponseXML;
//End - 15-10-2010 (wrote a code to get issue no from the syscontrol)  
}
else if ($RequestType=="SaveIssueHeader")
{
	$issueNo =$_GET["issueNo"];
	$issueYear =$_GET["issueYear"];
	$productionId =$_GET["productionId"];	
	$securityNo  = $_GET["securityNo"];
	
 		$SQL= " INSERT INTO issues (intIssueNo,intIssueYear,dtmIssuedDate,strProdLineNo,intStatus,intUserid,intCompanyID,strSecurityNo)  ". 
				" VALUES ($issueNo,$issueYear,now(),'$productionId',1,'" . $_SESSION["UserID"] . "',$companyId,'$securityNo') ";	

	$db->executeQuery($SQL);
}
else if ($RequestType=="SaveIssueDetails")
{
	$issueNo =$_GET["issueNo"];
	$issueYear =$_GET["issueYear"];
	$mrnNo =$_GET["mrnNo"];
	$mrnNoArray=explode('/',$mrnNo);
	$styleId =$_GET["styleId"];
	$BuyerPoNo =$_GET["BuyerPoNo"];

	$itemdDetailID =$_GET["itemdDetailID"];
	$color = $_GET["color"];
	$size = $_GET["size"];
	$qty = $_GET["qty"];	
	$grnNo = $_GET["grnNo"];
	$grnNoArr = explode('/',$grnNo);
	$grnType = $_GET["grnType"];
	$SQL= " INSERT INTO issuesdetails (intIssueNo,intIssueYear,intGrnNo,intGrnYear,intMatRequisitionNo,intMatReqYear,intStyleId,strBuyerPONO,intMatDetailID,strColor,strSize,dblQty, dblBalanceQty,strGRNType) VALUES ($issueNo,$issueYear,$grnNoArr[1],$grnNoArr[0],$mrnNoArray[1],$mrnNoArray[0],'$styleId','$BuyerPoNo',$itemdDetailID,'$color','$size',$qty,$qty,'$grnType') ";	

		$db->executeQuery($SQL);	
	
	$SQL1 =" UPDATE matrequisitiondetails SET dblBalQty = dblBalQty - $qty WHERE intMatRequisitionNo = $mrnNoArray[1] AND intYear = $mrnNoArray[0] ".
		  " AND intStyleId ='$styleId' AND strBuyerPONO='$BuyerPoNo' AND strMatDetailID=$itemdDetailID AND strColor ='$color' AND strSize ='$size' and intGrnNo = '$grnNoArr[1]' and intGrnYear = '$grnNoArr[0]' and  strGRNType='$grnType'";
		 // echo $SQL1; 
		  $db->executeQuery($SQL1);
}
else if($RequestType=="SaveFabricRollDetails")
{
	$issueNo 				= $_GET["issueNo"];
	$issueYear 				= $_GET["issueYear"];
	$mrnNo 					= $_GET["mrnNo"];
		$mrnNoArray			= explode('/',$mrnNo);
	$rollSerialNo			= $_GET["rollSerialNo"];
		$rollSerialNoArray	= explode('/',$rollSerialNo);
	$rollNo					= $_GET["rollNo"];
	$styleId 				= $_GET["styleId"];
	$BuyerPoNo 				= $_GET["BuyerPoNo"];
	$itemdDetailID 			= $_GET["itemdDetailID"];
	$color 					= $_GET["color"];
	$size 					= $_GET["size"];
	$rollIssueQty			= $_GET["rollIssueQty"];
	
	$sqlroll= "insert into fabricrollissuedetails ".
			  "(intFRollSerialNO, ".
			  "intFRollSerialYear, ".
			  "intIssueNo, ".
			  "intIssueYear, ".
			  "intMatRequisitionNo, ".
			  "intMatReqYear, ".
			  "intRollNo, ".
			  "intStyleId, ".
			  "strBuyerPONO, ".
			  "intMatDetailID, ".
			  "strColor, ".
			  "strSize, ".
			  "intStoresID, ".
			  "dblIssueQty, ".
			  "intCompanyID, ".
			  "intUserID) ".
			  "values ('$rollSerialNoArray[1]', ".
			  "'$rollSerialNoArray[0]', ".
			  "$issueNo, ".
			  "$issueYear, ".
			  "$mrnNoArray[1], ".
			  "$mrnNoArray[0], ".
			  "$rollNo, ".
			  "'$styleId', ". 
			  "'$BuyerPoNo', ".
			  "'$itemdDetailID', ".
			  "'$color', ".
			  "'$size', ".
			  "1, ".
			  "$rollIssueQty, ".
			  "$companyId, ".
			  "$userId);";
	$db->executeQuery($sqlroll);	
	
	$sqlrollupdate ="update fabricrolldetails ".
					"set dblBalQty = dblBalQty-$rollIssueQty ".
					"where ".
					"intFRollSerialNO = $rollSerialNoArray[1] and ".
					"intFRollSerialYear = $rollSerialNoArray[0] and ".
					"intRollNo =$rollNo;";		  
	$db->executeQuery($sqlrollupdate);
}
else if ($RequestType=="SaveBinDetails")
{
	$issueNo 		= $_GET["issueNo"];
	$Year 			= $_GET["Year"];
	$mainStores 	= $_GET["mainStores"];
	$subStores 		= $_GET["subStores"];
	$location 		= $_GET["location"];
	$binId 			= $_GET["binId"];
	$styleId 		= $_GET["styleId"];
	$BuyerPoNo 		= $_GET["BuyerPoNo"];

	$itemdDetailID 	= $_GET["itemdDetailID"];
	$color 			= $_GET["color"];
	$size 			= $_GET["size"];
	$units 			= $_GET["units"];
	$issueQty 		= $_GET["issueQty"];
		$qty 		= "-". $issueQty;
	$commonBin		= $_GET["commonBin"];
	$subCatID		= $_GET["subCatID"];
	$grnNo 			= $_GET["grnNo"];
	$grnNoArr       = explode('/',$grnNo);
	$grnType		= $_GET["grnType"];

if($commonBin==1)
{
	$sqlCommon="select * from storesbins where strMainID='$mainStores' AND intStatus=1 ;";
	
	$resultCommon=$db->RunQuery($sqlCommon);
	while($rowCommon = mysql_fetch_array($resultCommon))
	{
		$subStores		= $rowCommon["strSubID"];
		$location		= $rowCommon["strLocID"];
		$binId			= $rowCommon["strBinID"];
	}	
	
}

	
$sqlbinallocation="update storesbinallocation ".
					"set ".
					"dblFillQty = dblFillQty-$issueQty	".
					"where ".
					"strMainID = '$mainStores' ".
					"and strSubID = '$subStores' ".
					"and strLocID = '$location' ".
					"and strBinID = '$binId' ".
					"and intSubCatNo = '$subCatID';";

$db->executeQuery($sqlbinallocation);

/*	
if($commonBin==1)
{
	$sqlMainBin="select strMainID,strName from mainstores where intCompanyId=$companyId;";
	
	$resultMainBin=$db->RunQuery($sqlMainBin);
	while($rowMainBin = mysql_fetch_array($resultMainBin))
	{
		$mainBin		= $rowMainBin["strMainID"];		
	}
	$sqlSub="select strSubID from substores where strMainID='$mainBin';";
	
	$resultSub=$db->RunQuery($sqlSub);
	while($rowSub = mysql_fetch_array($resultSub))
	{
		$subBin		= $rowSub["strSubID"];		
	}
	
	
	$sqlCommon="select * from storesbins where strMainID='$mainBin' AND strSubID='$subBin';";
	
	$resultCommon=$db->RunQuery($sqlCommon);
	while($rowCommon = mysql_fetch_array($resultCommon))
	{
		$mainStores		= $rowCommon["strMainID"];
		$subStores		= $rowCommon["strSubID"];
		$location		= $rowCommon["strLocID"];
		$binId			= $rowCommon["strBinID"];
	}	
}*/

	 $SQL="INSERT INTO stocktransactions(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear, ".
         " intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo, intGrnYear,strGRNType) VALUES ".
		 " ($Year,'$mainStores','$subStores','$location','$binId','$styleId','$BuyerPoNo',$issueNo,$Year,$itemdDetailID, ".
         " '$color','$size','ISSUE','$units',$qty,now(),$userId,'$grnNoArr[1]','$grnNoArr[0]','$grnType') ";
		
	$db->executeQuery($SQL);
	
}
else if ($RequestType=="ResponseValidate")
{
	$issueNo = $_GET["issueNo"];
	$Year = $_GET["Year"];
	$validateCount = $_GET["validateCount"];
	$validateBinCount = $_GET["validateBinCount"];
	
	$ResponseXML .="<ResponseValidate>";
	$SQL="SELECT COUNT(intIssueNo) AS headerRecCount FROM issues where intIssueNo=$issueNo AND intIssueYear=$Year";

	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{		
		$recCountIssueHeader=$row["headerRecCount"];
	
		if($recCountIssueHeader>0)
		{
			$ResponseXML .= "<recCountIssueHeader><![CDATA[TRUE]]></recCountIssueHeader>\n";
		}
		else
		{	
			$ResponseXML .= "<recCountIssueHeader><![CDATA[FALSE]]></recCountIssueHeader>\n";
		}
	}	
	$SQL="SELECT COUNT(intIssueNo) AS issuesdetails FROM issuesdetails where intIssueNo=$issueNo AND intIssueYear=$Year";

	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$recCountIssueDetails=$row["issuesdetails"];
		
		if($recCountIssueDetails==$validateCount)
		{
			$ResponseXML .= "<recCountIssueDetails><![CDATA[TRUE]]></recCountIssueDetails>\n";
		}
		else
		{
			$ResponseXML .= "<recCountIssueDetails><![CDATA[FALSE]]></recCountIssueDetails>\n";
		}
	}
	$SQL="SELECT COUNT(intDocumentNo) AS binDetails FROM stocktransactions where intDocumentNo=$issueNo AND intDocumentYear=$Year AND strType='ISSUE'";	

	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$recCountBinDetails=$row["binDetails"];
		
		if($recCountBinDetails==$validateBinCount)
		{
			$ResponseXML .= "<recCountBinDetails><![CDATA[TRUE]]></recCountBinDetails>\n";
		}
		else
		{
			$ResponseXML .= "<recCountBinDetails><![CDATA[FALSE]]></recCountBinDetails>\n";
		}
	}
	$ResponseXML .="</ResponseValidate>";
	echo $ResponseXML;
}
else if($RequestType=="LoadPopUpIssueNo")
{

	$state=$_GET["state"];
	$year=$_GET["year"];

	$ResponseXML.="<LoadPopUpIssueNo>";
	global $db;
	$SQL="SELECT DISTINCT IH.intIssueNo ".
		 "FROM issues AS IH ".
		 "INNER JOIN issuesdetails AS ID ".
		 "ON IH.intIssueNo=ID.intIssueNo AND IH.intIssueYear=ID.intIssueYear ".
		 "WHERE IH.intStatus='$state' AND IH.intIssueYear='$year' AND IH.intCompanyID='$companyId' order by IH.intIssueNo DESC";
	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<IssueNo><![CDATA[" . $row["intIssueNo"]. "]]></IssueNo>\n";
	}
	$ResponseXML.="</LoadPopUpIssueNo>";
	echo $ResponseXML;
}
else if($RequestType=="loadScWiseStyleNo")
{

	$cboScNo=$_GET["cboScNo"];
	$mainStore=$_GET["mainStore"];

	$ResponseXML.="<loadSCwiseStyle>";
	global $db;
	$SQL="SELECT DISTINCT  O.strStyle,O.intStyleId FROM matrequisitiondetails AS MRD Inner Join matrequisition AS MRH ON MRH.intMatRequisitionNo = MRD.intMatRequisitionNo and MRD.intYear = MRH.intMRNYear Inner Join mainstores MS ON MS.strMainID=MRH.strMainStoresID Inner Join orders O on MRD.intStyleId = O.intStyleId WHERE MS.intCompanyId ='$companyId' and MS.strMainID='$mainStore' and MS.intStatus = 1 and O.intStatus in($headerPub_AllowOrderStatus) AND round(MRD.dblBalQty,2) >0 and MRH.intStatus=10 ";	
	if($cboScNo!="")
		$SQL .= "and O.intStyleId='$cboScNo' ";
		
		$SQL .= "ORDER BY O.strStyle";	
		//echo $SQL;	 
	$result = $db->RunQuery($SQL);
			// $ResponseXML .= "<option value=\"".""."\">"."Select One"."</option>"; 
	//$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<STYLEno><![CDATA[" . $row["strStyle"]. "]]></STYLEno>\n";
	}
	$ResponseXML.="</loadSCwiseStyle>";
	echo $ResponseXML;
}
else if($RequestType=="LoadMrnNoDirectly")
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
			"WHERE MS.intCompanyId =$companyId  AND MS.strMainID =$mainStore  AND ".
			"round(MRD.dblBalQty,2) >'0' AND MR.intStatus = 10 Order By MR.intMatRequisitionNo ";
	$result=$db->RunQuery($SQL);
		$ResponseXML .= "<option value=\"".""."\">".""."</option>";
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"".$row["MrnNo"]."\">".$row["MrnNo"]."</option>"; 
	}
	$ResponseXML.="</LoadPopUpIssueNo>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"getStockTrance") == 0)
{
global $db;
$styleID=$_GET["styleNo"];
$buyerPO=$_GET["buyerPo"];

$matDetailID=$_GET["MatID"];
$color=$_GET["color"];
$size=$_GET["size"];
$total=0;
$ResponseXML = "";
$ResponseXML .="<stockTrance>";

$sql="SELECT strTypeName,dtmDate,dblQty FROM stocktransactions S ". 
	"Inner Join stocktype ST ON S.strType = ST.strType ".
	"Inner Join mainstores MS ON MS.strMainID=S.strMainStoresID  ".
	"WHERE intStyleId='$styleID' AND ".
	"strBuyerPoNo='$buyerPO' AND ".
	"intMatDetailId='$matDetailID' AND ".
	"strColor='$color' AND ".
	"strSize='$size' AND ".
	"intCompanyId='$companyId';";
//echo $sql;
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
 $ResponseXML .= "<type><![CDATA[" .$row["strTypeName"]. "]]></type>\n";
		 $ResponseXML .= "<date><![CDATA[" .$row["dtmDate"]. "]]></date>\n";
		 $ResponseXML .= "<qty><![CDATA[" . round($row["dblQty"],2). "]]></qty>\n";
$qty= $row["dblQty"];
$total+=$qty;
}
$ResponseXML .= "<Total><![CDATA[" . round($total,2). "]]></Total>\n";
$ResponseXML .="</stockTrance>";
echo $ResponseXML;
}
else if ($RequestType=="LoadPopUpHeaderDetails")
{
	$No 		= $_GET["No"];
	$Year		= $_GET["Year"];
	
	$ResponseXML .="<LoadPopUpHeaderDetails>\n";
	
	$SQL="SELECT CONCAT(I.intIssueYear,'/',I.intIssueNo) AS IssueNo, ".
		 "I.intStatus, ".
		 "I.dtmIssuedDate, ".
		 "I.strProdLineNo, ".
		 "I.strSecurityNo ".		
		 "FROM issues AS I ".
		 "WHERE I.intIssueNo =  '$No' AND ".
		 "I.intIssueYear =  '$Year';";
	
	$result=$db->RunQuery($SQL);
		
		while($row=mysql_fetch_array($result))
		{			
			$ResponseXML .= "<IssueNo><![CDATA[" . $row["IssueNo"] . "]]></IssueNo>\n";					
			$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"] . "]]></Status>\n";
			$ResponseXML .= "<ProdLineNo><![CDATA[" . $row["strProdLineNo"] . "]]></ProdLineNo>\n";						
				$Date =substr($row["dtmIssuedDate"],0,10);
				$NOArray=explode('-',$Date);
				$formatedDate=$NOArray[2]."/".$NOArray[1]."/".$NOArray[0];
			$ResponseXML .= "<formatedDate><![CDATA[" . $formatedDate . "]]></formatedDate>\n";
			$ResponseXML .= "<SecurityNo><![CDATA[" . $row["strSecurityNo"] . "]]></SecurityNo>\n";	
					
		}
	
	$ResponseXML .="</LoadPopUpHeaderDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadPopUpDetails")
{
	$No =$_GET["No"];
	$Year =$_GET["Year"];

	$ResponseXML .="<LoadPopUpDetails>\n";
	
	/*$SQL="SELECT  ".
		 "MMC.strDescription, ".
		 "MIL.strItemDescription, ".
		 "ID.strColor,  ".
		 "ID.strSize,  ".
		 "ID.dblQty,  ".
		 "ID.intMatDetailID, ".
		 "ID.intMatReqYear, ".
		 "ID.intMatRequisitionNo, ".
		 "ID.strBuyerPONO, ".
		 "ID.intStyleId ".	 
		 "FROM ".
		 "issuesdetails AS ID ".
		 "Inner Join matitemlist AS MIL ON ID.intMatDetailID = MIL.intItemSerial ".
		 "Inner Join matmaincategory As MMC ON MMC.intID=MIL.intMainCatID ".
		 "WHERE ".
		 "ID.intIssueNo =  '$No' AND ".
		 "ID.intIssueYear =  '$Year';";*/
		 
	$SQL = "SELECT  DISTINCT
			MMC.strDescription, 
			MIL.strItemDescription, 
			ID.strColor,  
			ID.strSize,  
			ID.dblQty,  
			ID.intMatDetailID, 
			ID.intMatReqYear, 
			ID.intMatRequisitionNo, 
			ID.strBuyerPONO,
			ID.intStyleId,
			ST.strUnit,
			ID.intGrnNo,
			ID.intGrnYear,
			SP.intSRNO,
			ID.strGRNType
			FROM 
			issuesdetails AS ID 
			Inner Join matitemlist AS MIL ON ID.intMatDetailID = MIL.intItemSerial 
			Inner Join matmaincategory As MMC ON MMC.intID=MIL.intMainCatID 
			inner join stocktransactions as ST ON ST.intStyleId= ID.intStyleId
			inner join specification SP on SP.intStyleId = ST.intStyleId
			AND 
			ST.strBuyerPoNo = ID.strBuyerPONO AND 
			ST.intMatDetailId = ID.intMatDetailID AND 
			ST.strColor = ID.strColor AND 
			ST.strSize = ID.strSize and 
			ST.intDocumentNo = ID.intIssueNo and 
			ST.intDocumentYear = ID.intIssueYear and
			ST.intGrnNo = ID.intGrnNo and
			ST.intGrnYear = ID.intGrnYear and 
			ST.strGRNType = ID.strGRNType
			WHERE 
			ID.intIssueNo =  '$No' AND ID.intIssueYear =  '$Year' AND ST.strType='ISSUE' ";
	
	$result=$db->RunQuery($SQL);
		while($row=mysql_fetch_array($result))
		{
			$MrnYear=$row["intMatReqYear"];
			$MrnNo=$row["intMatRequisitionNo"];
			$StyleID=$row["intStyleId"];
			$BuyerPONO=$row["strBuyerPONO"];
			$MatDetailID=$row["intMatDetailID"];
			$Color=$row["strColor"];
			$Size=$row["strSize"];
			$styleName = getStyleName($StyleID);
			$style = getStyle($StyleID);
			$BuyerPOName =$row["strBuyerPONO"];
			$grnType = $row["strGRNType"];
			if($BuyerPOName != '#Main Ratio#')
				 $BuyerPOName = getBuyerPOName($StyleID,$BuyerPONO);
			$MrnQty=getMrnQty($MrnNo,$MrnYear,$StyleID,$BuyerPONO,$MatDetailID,$Color,$Size,$row["intGrnNo"],$row["intGrnYear"],$grnType);		
			
			$grnType = $row["strGRNType"];
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
			$grnNo = $row["intGrnYear"].'/'.$row["intGrnNo"];
			
				$ResponseXML .= "<Description><![CDATA[" . $row["strDescription"] . "]]></Description>\n";
				$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"] . "]]></ItemDescription>\n";
				$ResponseXML .= "<Color><![CDATA[" . $row["strColor"] . "]]></Color>\n";
				$ResponseXML .= "<Size><![CDATA[" . $row["strSize"] . "]]></Size>\n";
				$ResponseXML .= "<IssueQty><![CDATA[" . $row["dblQty"] . "]]></IssueQty>\n";
				$ResponseXML .= "<MatDetailID><![CDATA[" . $row["intMatDetailID"] . "]]></MatDetailID>\n";
				$ResponseXML .= "<MrnNo><![CDATA[" . $MrnNo . "]]></MrnNo>\n";
				$ResponseXML .= "<MrnYear><![CDATA[" . $MrnYear . "]]></MrnYear>\n";				
				$ResponseXML .= "<BuyerPONO><![CDATA[" . $BuyerPOName . "]]></BuyerPONO>\n";
				$ResponseXML .= "<StyleId><![CDATA[" . $style . " - " . $styleName . "]]></StyleId>\n";			
				$ResponseXML .= "<MrnQty><![CDATA[" . $MrnQty . "]]></MrnQty>\n";
				$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"] . "]]></Unit>\n";
				$ResponseXML .= "<SCNo><![CDATA[" . $row["intSRNO"] . "]]></SCNo>\n";	
				$ResponseXML .= "<grnNo><![CDATA[" . $grnNo . "]]></grnNo>\n";	
				//$ResponseXML .= "<grnType><![CDATA[" . $grnType . "]]></grnType>\n";
				$ResponseXML .= "<strGRNType><![CDATA[" . $strGRNType . "]]></strGRNType>\n";		
				
		}
	$ResponseXML .="</LoadPopUpDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="Cancel")
{
	$No=$_GET["No"];
		$IssueNoArray=explode('/',$No);	
			
	$SqlUpdate ="update issues  ".
				"set intCancelledBy =$userId, ".
				"dtmCanceledDate = now(), ".
				"intStatus =10 ".	
				"where intIssueNo =$IssueNoArray[1] ".
				"AND intIssueYear =$IssueNoArray[0];";
	
	$resultUpdate = $db->RunQuery($SqlUpdate);		
	
	$sql1="select intMatRequisitionNo, ".
		  "intMatReqYear, ".
		  "intStyleId, ".
		  "strBuyerPONO, ".
		  "intMatDetailID, ".
		  "strColor, ".
		  "strSize, ".
		  "dblQty ".
		  "from ".
		  "issuesdetails ".
		  "where ".
		  "intIssueNo='$IssueNoArray[1]' AND ".
	      "intIssueYear='$IssueNoArray[0]';";
	 
	$result1 = $db->RunQuery($sql1);
	while($row1=mysql_fetch_array($result1))
	{			
			$MrnNo			= $row1["intMatRequisitionNo"];
			$MrnYear		= $row1["intMatReqYear"];			
			$StyleID		= $row1["intStyleId"];
			$BuyerPoNo		= $row1["strBuyerPONO"];
			$MatdetailID	= $row1["intMatDetailID"];
			$Color			= $row1["strColor"];
			$Size			= $row1["strSize"];
			$IssueQty			= $row1["dblQty"];	
				
			MrnQtyRevise($MrnNo,$MrnYear,$StyleID,$BuyerPoNo,$MatdetailID,$Color,$Size,$IssueQty);		
	}
	

	$sql ="SELECT ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin, ".
			"ST.intStyleId,ST.strBuyerPoNo,ST.intDocumentNo,ST.intDocumentYear,ST.intMatDetailId, ".
			"ST.strColor,ST.strSize,ST.strUnit,ST.dblQty ".
			"FROM stocktransactions AS ST ".
			"WHERE ST.intDocumentNo =$IssueNoArray[1] AND ST.intDocumentYear =$IssueNoArray[0] AND strType='ISSUE'";
	
	$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$MainStores=$row["strMainStoresID"];
			$SubStores=$row["strSubStores"];
			$Location=$row["strLocation"];
			$Bin=$row["strBin"];
			$StyleNo=$row["intStyleId"];
			$BuyerPoNo=$row["strBuyerPoNo"];
			$DocumentNo=$row["intDocumentNo"];
			$DocumentYear=$row["intDocumentYear"];
			$MatDetailId=$row["intMatDetailId"];
			$Color=$row["strColor"];
			$Size=$row["strSize"];
			$Unit=$row["strUnit"];
			$Qty=$row["dblQty"];	
				
			StockRevise($DocumentYear,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$Qty,$userId);
		}		
	
	echo $resultUpdate;
}
function getMrnQty($MrnNo,$MrnYear,$StyleID,$BuyerPONO,$MatDetailID,$Color,$Size,$grnNo,$grnYear,$grnType)
{
			global $db;
			global $companyId;
			
			$SQLStock="SELECT MRD.dblQty FROM matrequisitiondetails AS MRD WHERE MRD.intMatRequisitionNo =  '$MrnNo' AND 				MRD.intYear =  '$MrnYear' AND MRD.intStyleId =  '$StyleID' AND MRD.strBuyerPONO =  '$BuyerPONO' AND 				MRD.strMatDetailID =  '$MatDetailID' AND MRD.strColor =  '$Color' AND MRD.strSize =  '$Size' and MRD.intGrnNo ='$grnNo' and MRD.intGrnYear = '$grnYear' and  MRD.strGRNType = '$grnType' ";
			//echo $SQLStock;
			$resultStock=$db->RunQuery($SQLStock);
			$rowcount = mysql_num_rows($resultStock);
			if ($rowcount > 0)
			{
				while($rowStock=mysql_fetch_array($resultStock))
				{
					return $rowStock["dblQty"];
				}
			}
			else 
			{
				return 0;
			}
}
function MrnQtyRevise($MrnNo,$MrnYear,$StyleID,$BuyerPoNo,$MatdetailID,$Color,$Size,$IssueQty)
{
	global $db;
	
	$sqlMrnQtyRevise="update matrequisitiondetails ".
					"set ".
					"dblBalQty = dblBalQty + $IssueQty ".
					"where ".
					"intMatRequisitionNo = '$MrnNo' and ".
					"intYear = '$MrnYear' and ".
					"intStyleId = '$StyleID' and ".
					"strBuyerPONO = '$BuyerPoNo' and ".
					"strMatDetailID = '$MatdetailID' and ".
					"strColor = '$Color' and ".
					"strSize = '$Size';";
						
	$db->executeQuery($sqlMrnQtyRevise);
}
function StockRevise($DocumentYear,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$Qty,$UserID)
{
			global $db;
			
$sqlInStock="INSERT INTO stocktransactions ".
         "(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear, ".
         "intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser) VALUES ".
		 "($DocumentYear,'$MainStores','$SubStores','$Location','$Bin','$StyleNo','$BuyerPoNo',$DocumentNo,$DocumentYear,$MatDetailId, ".
         "'$Color','$Size','CISSUE','$Unit',$Qty,now(),'$UserID')";
		
		$db->executeQuery($sqlInStock);
}

//get Style Name from orders
function getStyleName($styleID)
{
	global $db;
	$SQL = " SELECT strOrderNo FROM orders WHERE intStyleId='$styleID' ";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strOrderNo"];	
}

function getStyle($styleID)
{
	global $db;
	$SQL = " SELECT strStyle FROM orders WHERE intStyleId='$styleID' ";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strStyle"];	
}

function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}

function getBuyerPONameForChange($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPoName='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}

//start 2010-11-03 getStockbalance from stocktransaction

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

function GetSCNo($styleNo,$headerPub_AllowOrderStatus)
{
global $db;
global $companyId;
	$SQL = "SELECT DISTINCT SP.intSRNO,SP.intStyleId FROM matrequisitiondetails AS MRD Inner Join specification AS SP ON MRD.intStyleId = SP.intStyleId Inner Join matrequisition AS MRH ON MRH.intMatRequisitionNo = MRD.intMatRequisitionNo Inner Join mainstores MS ON MS.strMainID=MRH.strMainStoresID Inner Join orders O on O.intStyleId = SP.intStyleId AND MRD.intYear = MRH.intMRNYear WHERE MS.intCompanyId ='$companyId' and MS.intStatus = 1 and O.intStatus in($headerPub_AllowOrderStatus) AND round(MRD.dblBalQty,2) >0 and MRH.intStatus=10 ";
	
	if($styleNo!="")
		$SQL .= "and O.strStyle='$styleNo' ";
	
	$SQL .= "order by SP.intSRNO desc";	
	//echo $SQL;
	$result = $db->RunQuery($SQL);
		 $ResponseXML .= "<option value=\"".""."\">".""."</option>"; 
	while($row=mysql_fetch_array($result))
	{
		 $ResponseXML .= "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>"; 		
	}
	return $ResponseXML;
}
?>