<?php
session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];

if($RequestType=="LoadBuyetPoNo")
{
	$StyleID=$_GET["StyleID"];
	
	$ResponseXML .="<LoadBuyetPoNo>\n";
	
	//$SQL="SELECT DISTINCT strBuyerPONO from issuesdetails where intStyleId='$StyleID'";
	$SQL="SELECT DISTINCT I.strBuyerPONO, I.intStyleId
		from issuesdetails I 
		where I.intStyleId='$StyleID'";
	
	$result=$db->RunQuery($SQL);
	
	while ($row=mysql_fetch_array($result))
	{		
		$buyerPONO	 = $row["strBuyerPONO"];
		$styleid	 = $row["intStyleId"];
		$buyerPoName = $row["strBuyerPONO"];
		
		if($buyerPONO != '#Main Ratio#')
		    //$buyerPoName = getBuyerPOName($styleid,$buyerPONO);
                    $buyerPoName = getBuyerPONameForChange($styleid,$buyerPONO);
				
		 $ResponseXML .= "<BuyerPoNo><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPoNo>\n";
		  $ResponseXML .= "<BuyerPoName><![CDATA[" . $buyerPoName . "]]></BuyerPoName>\n";			
	}
	$ResponseXML .="</LoadBuyetPoNo>";
	echo $ResponseXML;
}	
elseif($RequestType=="LoadSubStores")
{
	$mainStores=$_GET["mainStores"];
	
	$ResponseXML .="<LoadSubStores>\n";
	
	$SQL="select strSubID,strSubStoresName from substores where strMainID='$mainStores'";	
	$result=$db->RunQuery($SQL);	
	while ($row=mysql_fetch_array($result))
	{		
		$ResponseXML .= "<SubStoresName><![CDATA[" . $row["strSubStoresName"]  . "]]></SubStoresName>\n";		
		$ResponseXML .= "<SubID><![CDATA[" . $row["strSubID"]  . "]]></SubID>\n";	
	}
	$sql_main = "select intCommonBin from mainstores where strMainID=$mainStores";
	$result_main=$db->RunQuery($sql_main);
	$row_main = mysql_fetch_array($result_main);
		$ResponseXML .= "<CommonBinId><![CDATA[" . $row_main["intCommonBin"]  . "]]></CommonBinId>\n";	
	$ResponseXML .="</LoadSubStores>";
	echo $ResponseXML;
}	
elseif($RequestType=="LoadBinDetauls")
{
	$mainStoreID    = $_GET["mainStoreID"];
	$subStoreID		= $_GET["subStoreID"];
	$location		= $_GET["location"];
	$subCatID		= $_GET["subCatID"];
	
	$ResponseXML .="<LoadBinDetauls>\n";
	
	$SQL="SELECT ".
		"SBA.strMainID, ".
		"SBA.strSubID, ".
		"SBA.strLocID, ".
		"SBA.strBinID, ".
		"SBA.intSubCatNo, ".		
		"SBA.strUnit, ".		
		"(sum(SBA.dblCapacityQty)-sum(SBA.dblFillQty))as BalQty, ".
		"SB.strBinName ".
		"FROM ".
		"storesbinallocation AS SBA ".
		"Inner Join storesbins AS SB ON ".
		"SBA.strMainID = SB.strMainID AND ".
		"SBA.strSubID = SB.strSubID AND ".
		"SBA.strLocID = SB.strLocID AND ".
		"SBA.strBinID = SB.strBinID ".
		"WHERE ".		
		"SBA.strMainID =  '$mainStoreID' AND ".
		"SBA.strSubID =  '$subStoreID' AND ".
		"SBA.strLocID =  '$location' AND ".
		"SBA.intSubCatNo =  '$subCatID' AND ".
		"SBA.intStatus =  '1' ".
		"GROUP BY ".
		"SBA.strMainID, ".
		"SBA.strSubID, ".
		"SBA.strLocID, ".
		"SBA.strBinID, ".
		"SBA.intSubCatNo;";
	
	$result=$db->RunQuery($SQL);
	
	while ($row=mysql_fetch_array($result))
	{
		$BalQty		= $row["BalQty"];
		if($BalQty>0){
			 $ResponseXML .= "<Diferent><![CDATA[" . $BalQty  . "]]></Diferent>\n";		
			 $ResponseXML .= "<BinName><![CDATA[" . $row["strBinName"]  . "]]></BinName>\n";	
			 $ResponseXML .= "<BinID><![CDATA[" . $row["strBinID"]  . "]]></BinID>\n";	
			 $ResponseXML .= "<MainID><![CDATA[" . $row["strMainID"]  . "]]></MainID>\n";	
			 $ResponseXML .= "<SubID><![CDATA[" . $row["strSubID"]  . "]]></SubID>\n";	
			 $ResponseXML .= "<LocID><![CDATA[" . $row["strLocID"]  . "]]></LocID>\n";	
			 $ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		 }
	}
	$ResponseXML .="</LoadBinDetauls>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadNo")
{		
    $No=0;
	$ResponseXML .="<LoadNo>\n";
	
		$Sql="select intCompanyID,dblStoresRetNo from syscontrol where intCompanyID='$companyId'";
		
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{				
					$No=$row["dblStoresRetNo"];
					$NextNo=$No+1;
					$ReturnYear = date('Y');
					$sqlUpdate="UPDATE syscontrol SET dblStoresRetNo='$NextNo' WHERE intCompanyID='$companyId';";
					$db->executeQuery($sqlUpdate);
					$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
					$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
					$ResponseXML .= "<Year><![CDATA[".$ReturnYear."]]></Year>\n";
				}
				
		}
		else
		{
			$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
		}	
	$ResponseXML .="</LoadNo>";
	echo $ResponseXML;
}												
else if ($RequestType=="SaveHeader")
{
	$ReturnNo =$_GET["returnNo"];
	$ReturnYear =$_GET["returnYear"];
	$Remarks =$_GET["remarks"];	
	$ReturnBy =$_GET["returnBy"];
	$boolCheck = checkDataAvailble($ReturnNo,$ReturnYear);
	if($boolCheck)
	{
		$sqlUpdate = "update returntostoresheader 
						set
						strReturnedBy = '$ReturnBy' ,
						strRemarks = '$Remarks' , 
						intUserId = '$UserID' , 
						dtmRetDate = now() , 
						intCompanyID = '$companyId'
						where
						intReturnNo = '$ReturnNo' and intReturnYear = '$ReturnYear'";
		$db->executeQuery($sqlUpdate);
	}
	else
	{
		$sqlInsert = "insert into returntostoresheader 
						(
						intReturnNo, 
						intReturnYear, 
						strReturnedBy, 
						intStatus, 
						strRemarks, 
						intUserId, 
						dtmRetDate, 
						intCompanyID, 
						intCreateBy, 
						dtmCreateDate
						)
						values
						(
						'$ReturnNo',
						'$ReturnYear',
						'$ReturnBy',
						'0',
						'$Remarks',
						'$UserID',
						 now(),
						'$companyId',
						'$UserID',
						now()
						)";
		$db->executeQuery($sqlInsert);
	}
}
else if ($RequestType=="SaveDetails")
{
	$ReturnNo 			= $_GET["returnNo"];
	$ReturnYear 		= $_GET["returnYear"];
	$StyleID 			= $_GET["StyleID"];	
	$buyerPoNo 			= $_GET["buyerPoNo"];
	$itemDetailID 		= $_GET["itemDetailID"];	
	$color 				= $_GET["color"];
	$size 				= $_GET["size"];
	$units 				= $_GET["units"];
	$issueNo 			= $_GET["issueNo"];
		$issueNoArray	= explode('/',$issueNo);
	$qty 				= $_GET["qty"];
	$mrnNo 				= $_GET["mrnNo"];
		$mrnNoArray	= explode('/',$mrnNo);
	$status				= $_GET["status"];
	
	$grnNo 				= $_GET["grnNo"];
		$arrGRNno 		= explode('/',$grnNo);
	$grnType			=$_GET["grnType"];
	
	$SQL="insert into returntostoresdetails (intReturnNo,intReturnYear,intIssueNo,intIssueYear,intMatrequisitionNo,
		intMatrequisitionYear,intStyleId,strBuyerPoNo,intMatdetailID,strColor,strSize,dblReturnQty,dblBalQty,intGrnNo,
		intGrnYear,	strGRNType) values ('$ReturnNo','$ReturnYear','$issueNoArray[1]','$issueNoArray[0]','$mrnNoArray[1]',
		'$mrnNoArray[0]','$StyleID','$buyerPoNo','$itemDetailID','$color','$size',$qty,$qty,$arrGRNno[1],$arrGRNno[0],'$grnType')";	
		$db->executeQuery($SQL);
		
	//if($status==0)
//{	
		$returnQty = GetReturnQty($issueNoArray[1],$issueNoArray[0],$mrnNoArray[1],$mrnNoArray[0],$StyleID,$buyerPoNo,$itemDetailID,$color,$size,$arrGRNno[1],$arrGRNno[0],$grnType);
		$SQL2="update issuesdetails ".
			 "set ".
			 "dblBalanceQty = dblQty - '$returnQty' ".
			 "where ".
			 "intIssueNo = '$issueNoArray[1]' and ".
			 "intIssueYear = '$issueNoArray[0]' and ".
			 "intMatRequisitionNo = '$mrnNoArray[1]' and ".
			 "intMatReqYear = '$mrnNoArray[0]' and ".
			 "intStyleId = '$StyleID' and ".
			 "strBuyerPONO = '$buyerPoNo' and ".
			 "intMatDetailID = '$itemDetailID' and ".
			 "strColor = '$color' and ".
			 "strSize = '$size' and intGrnNo = '$arrGRNno[1]' and intGrnYear = '$arrGRNno[0]' and strGRNType='$grnType'";
			
		$db->executeQuery($SQL2);
//}
}
else if ($RequestType=="SaveBinDetails")
{
	$commonBin			= $_GET["commonBin"];
	
	$ReturnNo 			= $_GET["returnNo"];
	$ReturnYear 		= $_GET["returnYear"];	
	$StyleID			= $_GET["StyleID"];
	$buyerPoNo 			= $_GET["buyerPoNo"];
	$itemDetailID 		= $_GET["itemDetailID"];
	$color 				= $_GET["color"];
	$size 				= $_GET["size"];
	$units 				= $_GET["units"];
	$binQty 			= $_GET["binQty"];		
	$mainStoreId 		= $_GET["mainStoreId"];
	$subStoreId 		= $_GET["subStoreId"];
	$locationId 		= $_GET["locationId"];
	$binId 				= $_GET["binId"];
	$subCatID			= $_GET["subCatID"];		
	$grnNo				= $_GET["grnNo"];
	$arrGRNno 			= explode('/',$grnNo);
	$grnType			=$_GET["grnType"];
	
	if($mainStoreId == '')
	{
		$mainStoreId = '';
		$subStoreId  = '';
		$locationId  = '';
		$binId       = '';
	}
		
	if($commonBin==1 && $mainStoreId != '')
	{
		$sqlCommon="select * from storesbins where strMainID='$mainStoreId' AND strSubID='$subStoreId' AND intStatus=1";
		
		$resultCommon=$db->RunQuery($sqlCommon);
		while($rowCommon = mysql_fetch_array($resultCommon))
		{
			$locationId		= $rowCommon["strLocID"];
			$binId			= $rowCommon["strBinID"];
		}
		
		
		$resBinAllo = chkBinAllocationAv($mainStoreId,$subStoreId,$locationId,$binId,$subCatID);
				
				if($resBinAllo != '1')
				{
					//insert data to storesbinallocation 
					$saveRes = saveStorebinAllocationDetails($mainStoreId,$subStoreId,$locationId,$binId,$subCatID);
					if(!$saveRes)
					{
						//echo 'error->Bin allocation error. ';
						return;
					}
				}
	}	
	
/*
	
$sql="update storesbinallocation ".
	 "set ".
	 "dblFillQty = dblFillQty + $binQty ".
	 "where ".
	 "strMainID = '$mainStoreId' AND ".
	 "strSubID = '$subStoreId ' AND ".
	 "strLocID = '$locationId' AND ".
	 "strBinID = '$binId' AND ".
	 "intSubCatNo = '$subCatID';";

$db->executeQuery($sql);	*/

/*$sql="";
$sql="delete from stocktransactions 
where intDocumentNo ='$ReturnNo' 
and intDocumentYear ='$ReturnYear'
and intStyleId ='$StyleID'
and strBuyerPoNo ='$buyerPoNo'
and intMatDetailId ='$itemDetailID'
and strColor ='$color'
and strSize ='$size'
and strType ='SRTS'
and strMainStoresID='$mainStoreId' 
and strSubStores='$subStoreId'
and strLocation='$locationId'
and strBin='$binId' and intGrnNo='$arrGRNno[1]' and  intGrnYear= '$arrGRNno[0]'";
$db->executeQuery($sql);*/

$sqlbin="INSERT INTO  stocktransactions_temp (intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId, strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,
intGrnYear,strGRNType) VALUES ('$ReturnYear','$mainStoreId','$subStoreId','$locationId','$binId','$StyleID','$buyerPoNo',
'$ReturnNo','$ReturnYear','$itemDetailID','$color','$size','SRTS','$units','$binQty',now(),'$UserID','$arrGRNno[1]','$arrGRNno[0]','$grnType')";
	//echo $sqlbin;
	$db->executeQuery($sqlbin);
}
else if ($RequestType=="SaveValidate")
{
	$ReturnNo=$_GET["returnNo"];
	$ReturnYear =$_GET["returnYear"];
	$validateCount =$_GET["validateCount"];		
	$validateBinCount =$_GET["validateBinCount"];	
	$pub_state		 = $_GET["pub_state"];
		if($pub_state==0)
			$stocktable = "stocktransactions_temp";
		elseif($pub_state==1)
			$stocktable = "stocktransactions";
	$ResponseXML .="<SaveValidate>\n";
	
	$SQLHeder="SELECT COUNT(intReturnNo) AS headerRecCount FROM returntostoresheader where intReturnNo=$ReturnNo AND intReturnYear=$ReturnYear";
	
	$resultHeader=$db->RunQuery($SQLHeder);
	
			while($row = mysql_fetch_array($resultHeader))
			{		
				$recCountHeader=$row["headerRecCount"];
			
				if($recCountHeader>0)
				{
					$ResponseXML .= "<recCountHeader><![CDATA[TRUE]]></recCountHeader>\n";
				}
				else
				{	
					$ResponseXML .= "<recCountHeader><![CDATA[FALSE]]></recCountHeader>\n";
				}
			}	
			
	$SQLDetail="SELECT COUNT(intReturnNo) AS DetailsRecCount FROM returntostoresdetails where intReturnNo=$ReturnNo AND intReturnYear=$ReturnYear";
	
	$resultDetail=$db->RunQuery($SQLDetail);
		
			while($row =mysql_fetch_array($resultDetail))
			{
				$recCountDetails=$row["DetailsRecCount"];
				
					if($recCountDetails==$validateCount)
					{
						$ResponseXML .= "<recCountDetails><![CDATA[TRUE]]></recCountDetails>\n";
					}
					else
					{
						$ResponseXML .= "<recCountDetails><![CDATA[FALSE]]></recCountDetails>\n";
					}
			}
		$SQL="SELECT COUNT(intDocumentNo) AS binDetails FROM $stocktable where intDocumentNo=$ReturnNo AND intDocumentYear=$ReturnYear and strType='SRTS'";	
	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$recCountBin=$row["binDetails"];		
		
			if($recCountBin==$validateBinCount)
			{
				$ResponseXML .= "<recCountBinDetails><![CDATA[TRUE]]></recCountBinDetails>\n";
			}
			else
			{
				$ResponseXML .= "<recCountBinDetails><![CDATA[FALSE]]></recCountBinDetails>\n";
			}
	}	
	
	$ResponseXML .="</SaveValidate>";
	echo $ResponseXML;
}
else if($RequestType=="LoadPopUpReturnNo")
{
	$state=$_GET["state"];
	$year=$_GET["year"];

	$SQL="SELECT DISTINCT RTSH.intReturnNo  ".
		 "FROM returntostoresheader AS RTSH  ".
		 "INNER JOIN  returntostoresdetails AS RTSD  ".
		 "ON RTSH.intReturnNo=RTSD.intReturnNo AND RTSH.intReturnYear=RTSD.intReturnYear ".
		 "WHERE RTSH.intStatus='$state' AND  RTSH.intReturnYear='$year' AND intCompanyID='$companyId';";
		$ResponseXML .= "<option value =\"".""."\">"."Select One"."</option>";
	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value =\"".$row["intReturnNo"]."\">".$row["intReturnNo"]."</option>";
	}	
echo $ResponseXML;
}
else if($RequestType=="LoadPopUpReturnYear")
{
	$SQL = "SELECT DISTINCT intReturnYear FROM returntostoresheader ORDER BY intReturnYear DESC;";	
	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value =\"".$row["intReturnYear"]."\">".$row["intReturnYear"]."</option>";
	}
	echo $ResponseXML;
}
else if($RequestType=="loadStyleName")
{
	$scNO=$_GET["scNO"];
	//$year=$_GET["year"];
	
	$SQL="SELECT DISTINCT ".
				"orders.strStyle  ".
				"FROM ".
				"issuesdetails AS ID ".
				"Inner Join orders ON ID.intStyleId = orders.intStyleId  ".
				"Inner Join issues ON ID.intIssueNo = issues.intIssueNo AND ID.intIssueYear = issues.intIssueYear ".
				"WHERE ".
				"ID.dblBalanceQty > 0 AND ".
				"issues.intCompanyID ='$companyId' AND orders.intStyleId = '$scNO'  order by orders.strStyle";	
	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value =\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
	}
	echo $ResponseXML;
}
else if ($RequestType=="LoadPopUpHeaderDetails")
{
	$No =$_GET["No"];
	$Year=$_GET["Year"];
	
	$ResponseXML .="<LoadPopUpHeaderDetails>\n";
	
	$SQL="SELECT ".
		 "CONCAT(RTSH.intReturnYear,'/',RTSH.intReturnNo) AS ReturnNo, ".
		 "RTSH.strReturnedBy, ".
		 "RTSH.intStatus, ".
		 "RTSH.strRemarks, ".
		 "RTSH.dtmRetDate ".
		 "FROM ".
		 "returntostoresheader AS RTSH WHERE ".
		 "RTSH.intReturnNo =  '$No' AND ".
		 "RTSH.intReturnYear =  '$Year';";

	$result=$db->RunQuery($SQL);
		
		while($row=mysql_fetch_array($result))
		{			
			$ResponseXML .= "<ReturnNo><![CDATA[" . $row["ReturnNo"] . "]]></ReturnNo>\n";
			$ResponseXML .= "<ReturnedBy><![CDATA[" . $row["strReturnedBy"] . "]]></ReturnedBy>\n";			
			$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"] . "]]></Status>\n";
			$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"] . "]]></Remarks>\n";						
				$Date =substr($row["dtmRetDate"],0,10);
				$NOArray=explode('-',$Date);
				$formatedDate=$NOArray[2]."/".$NOArray[1]."/".$NOArray[0];
			$ResponseXML .= "<formatedDate><![CDATA[" . $formatedDate . "]]></formatedDate>\n";				
		}
	
	$ResponseXML .="</LoadPopUpHeaderDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="LoadPopUpDetails")
{
	$No =$_GET["No"];
	$Year =$_GET["Year"];

	$ResponseXML .="<LoadPopUpDetails>\n";
	
	$SQL="SELECT
RTSD.intIssueNo,
RTSD.intIssueYear,
RTSD.intStyleId,
RTSD.strBuyerPoNo,
RTSD.intMatdetailID,
RTSD.strColor,
RTSD.strSize,
RTSD.dblReturnQty,
RTSD.dblBalQty,
MIL.strItemDescription,
MIL.strUnit,
MIL.intSubCatID,
RTSD.intMatrequisitionNo,
RTSD.intMatrequisitionYear,
O.strStyle,
RTSD.intGrnNo,
RTSD.intGrnYear,
RTSD.strGRNType,
RTSD.intReturnNo,
RTSD.intReturnYear,
Sum(issuesdetails.dblQty) as IssueQty,
issuesdetails.strColor,
issuesdetails.strSize
FROM
returntostoresdetails AS RTSD
INNER JOIN matitemlist AS MIL ON RTSD.intMatdetailID = MIL.intItemSerial
INNER JOIN orders AS O ON O.intStyleId = RTSD.intStyleId
INNER JOIN issuesdetails ON RTSD.intMatrequisitionNo = issuesdetails.intMatRequisitionNo AND RTSD.intIssueNo = issuesdetails.intIssueNo AND RTSD.intMatdetailID = issuesdetails.intMatDetailID AND RTSD.strColor = issuesdetails.strColor AND RTSD.strSize = issuesdetails.strSize

		WHERE 
		RTSD.intReturnNo =  '$No' AND 
		RTSD.intReturnYear =  '$Year'
		GROUP BY
RTSD.intMatdetailID,
RTSD.intMatrequisitionNo,
RTSD.strColor,
RTSD.strSize,
RTSD.intIssueNo,
RTSD.intGrnNo,intStyleId,
RTSD.strBuyerPoNo
";
// =====================================
// Add On - 2016/07/05
// Add By - Nalin Jayakody
// Adding - Add buyer PO number to the 'GROUP BY' clause above query
// ======================================		
		//echo $SQL;
	$result=$db->RunQuery($SQL);
		while($row=mysql_fetch_array($result))
		{
			$IssueNo=$row["intIssueNo"];
			$IssueYear=$row["intIssueYear"];
			$StyleID=$row["intStyleId"];
			$BuyerPONO=$row["strBuyerPoNo"];
			$MatDetailID=$row["intMatdetailID"];
			$Color=$row["strColor"];
			$Size=$row["strSize"];
			$grnNo = $row["intGrnYear"].'/'.$row["intGrnNo"];
			$grnType = $row["strGRNType"];
			
			if($BuyerPONO != '#Main Ratio#')
				$BuyerPONO = getBuyerPOName($StyleID,$row["strBuyerPoNo"]);
				
			//$IssueQty=getIssueQty($IssueNo,$IssueYear,$StyleID,$row["strBuyerPoNo"],$MatDetailID,$Color,$Size,$row["intGrnNo"],$row["intGrnYear"],$grnType);
			$IssueQty = $row["IssueQty"];		
			
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
			$ResponseXML .= "<IssueNo><![CDATA[" . $IssueNo . "]]></IssueNo>\n";
			$ResponseXML .= "<IssueYear><![CDATA[" . $IssueYear . "]]></IssueYear>\n";
			$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"] . "]]></ItemDescription>\n";
			$ResponseXML .= "<MatdetailId><![CDATA[" . $MatDetailID . "]]></MatdetailId>\n";
			$ResponseXML .= "<StyleID><![CDATA[" . $StyleID . "]]></StyleID>\n";
			$ResponseXML .= "<StyleName><![CDATA[" . $row["strStyle"] . "]]></StyleName>\n";
			$ResponseXML .= "<BuyerPONO><![CDATA[" . $row["strBuyerPoNo"]. "]]></BuyerPONO>\n";
			$ResponseXML .= "<BuyerPOName><![CDATA[" . $BuyerPONO . "]]></BuyerPOName>\n";
			$ResponseXML .= "<Color><![CDATA[" . $Color . "]]></Color>\n";				
			$ResponseXML .= "<Size><![CDATA[" . $Size . "]]></Size>\n";
			$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"] . "]]></Unit>\n";			
			$ResponseXML .= "<IssueQty><![CDATA[" . $IssueQty . "]]></IssueQty>\n";
			$ResponseXML .= "<ReturnQty><![CDATA[" . $row["dblReturnQty"] . "]]></ReturnQty>\n";
			$ResponseXML .= "<MatSubCatID><![CDATA[" . $row["intSubCatID"] . "]]></MatSubCatID>\n";
			$ResponseXML .= "<MatrequisitionNo><![CDATA[" . $row["intMatrequisitionNo"] . "]]></MatrequisitionNo>\n";
			$ResponseXML .= "<MatrequisitionYear><![CDATA[" . $row["intMatrequisitionYear"] . "]]></MatrequisitionYear>\n";
			$ResponseXML .= "<GRNno><![CDATA[" . $grnNo . "]]></GRNno>\n";
			$ResponseXML .= "<grnType><![CDATA[" . $grnType . "]]></grnType>\n";
			$ResponseXML .= "<strGRNType><![CDATA[" . $strGRNType . "]]></strGRNType>\n";
					
		}
	$ResponseXML .="</LoadPopUpDetails>";
	echo $ResponseXML;
}
else if ($RequestType=="Cancel")
{
	$No=$_GET["No"];
		$ReturnNoArray=explode('/',$No);
				
	$ResponseXML .="<LoadDetails>\n";
	$chkStockAv = checkStockAvailability($ReturnNoArray[1],$ReturnNoArray[0]);
	if($chkStockAv)
	{
		$SqlUpdate ="update returntostoresheader  ".
				"set intCancledBy =$UserID, ".
				"dtmCancledDate = now(), ".
				"intStatus =10 ".	
				"where intReturnNo =$ReturnNoArray[1] ".
				"AND intReturnYear =$ReturnNoArray[0]";
	
	$resultUpdate = $db->RunQuery($SqlUpdate);
	
	$sql_1=" select intIssueNo,intIssueYear,intMatrequisitionNo,intMatrequisitionYear,intStyleId,
	strBuyerPoNo,intMatdetailID,strColor,strSize,dblReturnQty,intGrnNo,intGrnYear,strGRNType 
	from returntostoresdetails 
	where intReturnNo='$ReturnNoArray[1]' 
	and intReturnYear='$ReturnNoArray[0]'";
	$result_1=$db->RunQuery($sql_1);
	while($row_1=mysql_fetch_array($result_1))
	{
		$issueNo			= $row_1["intIssueNo"];
		$issueYear			= $row_1["intIssueYear"];
		$matrequisitionNo	= $row_1["intMatrequisitionNo"];
		$matrequisitionYear	= $row_1["intMatrequisitionYear"];
		$styleID			= $row_1["intStyleId"];
		$buyerPoNo			= $row_1["strBuyerPoNo"];
		$matdetailId		= $row_1["intMatdetailID"];
		$color				= $row_1["strColor"];
		$size				= $row_1["strSize"];
		$qty				= $row_1["dblReturnQty"];
		$grnNo 				= $row_1["intGrnNo"];
		$grnYear			= $row_1["intGrnYear"];
		$grnType			= $row_1["strGRNType"];
		
		ReturnDetailsRevise($issueNo,$issueYear,$matrequisitionNo,$matrequisitionYear,$styleID,$buyerPoNo,$matdetailId,$color,$size,$qty,$grnNo,$grnYear,$grnType);
	}
	
	  $sql ="SELECT ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin, ".
			"ST.intStyleId,ST.strBuyerPoNo,ST.intDocumentNo,ST.intDocumentYear,ST.intMatDetailId, ".
			"ST.strColor,ST.strSize,ST.strUnit,ST.dblQty,ST.intGrnNo, ST.intGrnYear,ST.strGRNType ".
			"FROM stocktransactions AS ST ".
			"WHERE ST.intDocumentNo =$ReturnNoArray[1] AND ST.intDocumentYear =$ReturnNoArray[0] AND strType='SRTS'";
	
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
				$BinQty ="-". $Qty;
				
			$intGrnNo = $row["intGrnNo"];
			$intGrnYear = $row["intGrnYear"];
			$strGRNtype = $row["strGRNType"];
				
			StockRevise($DocumentYear,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$BinQty,$UserID,$intGrnNo,$intGrnYear,$strGRNtype);
			ReviseStockAllocation($MainStores,$SubStores,$Location,$Bin,$MatDetailId,$Qty);
		}		
	}
	else
	{
		$resultUpdate = "Some items not in stock.";
	}
	$ResponseXML .= "<cancelResponse><![CDATA[" . $resultUpdate . "]]></cancelResponse>\n";
	$ResponseXML .="</LoadDetails>";
	echo $ResponseXML;
}
else if($RequestType=="ConfirmReturn")
{
	$no = $_GET["no"];
	$noArray=explode('/',$no);		
	
	$sqlstock = "INSERT INTO stocktransactions ( intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) SELECT intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear,intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType FROM stocktransactions_temp  
	where intDocumentNo='$noArray[1]' and intDocumentYear='$noArray[0]' and strType='SRTS'";
	$resultstock = $db->RunQuery($sqlstock);
	
	$result_Temp = getStockTempData($noArray[1],$noArray[0]);
	while($row=mysql_fetch_array($result_Temp))
	{
		$matDetailID  = $row["intMatDetailId"];
		$subCatID  = getSubcatID($matDetailID);
		$mainStoreId = $row["strMainStoresID"];
		$subStoreId  = $row["strSubStores"];
		$locationId  = $row["strLocation"];
		$binId  = $row["strBin"];
		$binQty  = $row["dblQty"];
		$binResponse = updateBindetails($binQty,$mainStoreId,$subStoreId,$locationId,$binId,$subCatID);
	}
	
	if($resultstock >0)
	{
		$sqldel = "delete from stocktransactions_temp where intDocumentNo='$noArray[1]' and intDocumentYear='$noArray[0]' and strType='SRTS'";
		$resultdel	= $db->RunQuery($sqldel);
	}
	
	if($resultdel>0)
	{
		$sqlconfirm="Update returntostoresheader ".
		"set intConfirmedBy = '$UserID',dtmConfirmedOn = now(), ".
		"intStatus =1 ".
		"where intReturnNo = '$noArray[1]' and intReturnYear = '$noArray[0]' ";
	$result=0;
	$result = $db->RunQuery($sqlconfirm);
	}
	
	$ResponseXML .="<confirmResponse>\n";
	$ResponseXML .= "<confirmResult><![CDATA[" . $result . "]]></confirmResult>\n";
	$ResponseXML .="</confirmResponse>";
	
	echo $ResponseXML;
}
else if($RequestType=="deleteReturnStoreDetails")
{
	$ReturnNo 			= $_GET["returnNo"];
	$ReturnYear 		= $_GET["returnYear"];	
	
	$SQL = "delete from returntostoresdetails where intReturnNo = '$ReturnNo' and intReturnYear = '$ReturnYear' ;";	
	$db->executeQuery($SQL);	
	$sqldel = "delete from stocktransactions_temp where intDocumentNo='$ReturnNo' and intDocumentYear='$ReturnYear' and strType='SRTS'";
	$resultdel	= $db->RunQuery($sqldel);
	$sqldel = "delete from stocktransactions where intDocumentNo='$ReturnNo' and intDocumentYear='$ReturnYear' and strType='SRTS'";
	$resultdel	= $db->RunQuery($sqldel);
}

else if ($RequestType=="LoadPendingConfirmBinDetails")
{
	$returnNo=$_GET["returnNo"];
		$returnArr=explode('/',$returnNo);
	$StyleId=$_GET["styleId"];
	$buyerPoNo=$_GET["buyerPoNo"];
	$MatDetailID=$_GET["matDetailID"];
	$Color=$_GET["color"];
	$Size=$_GET["size"];	
	$pub_state = $_GET["pub_state"];
	
	if($pub_state == 0)
		$tblName = 'stocktransactions_temp';
	else
		$tblName = 'stocktransactions';
		
	$ResponseXML .="<LoadPendingConfirmBinDetails>\n";
	
	/*$SQLBIN="SELECT ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin,Sum(ST.dblQty) as BinQty,MIL.intSubCatID 
			FROM $tblName AS ST 
			Inner Join matitemlist MIL on MIL.intItemSerial=ST.intMatDetailId 
			WHERE ST.intDocumentNo =  '$returnArr[1]' AND ST.intDocumentYear =  '$returnArr[0]' 
			AND ST.intStyleId =  '$StyleId' AND ST.strBuyerPoNo =  '$buyerPoNo' 
			AND ST.intMatDetailId =  '$MatDetailID' AND ST.strColor =  '$Color' AND ST.strSize =  '$Size' and strType='SRTS' 
			GROUP BY ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin;";*/
	
	$SQLBIN="SELECT ST.strMainStoresID,ST.strSubStores,ST.strLocation,ST.strBin,Sum(ST.dblQty) as BinQty,MIL.intSubCatID 
			FROM $tblName AS ST 
			Inner Join matitemlist MIL on MIL.intItemSerial=ST.intMatDetailId 
			WHERE ST.intDocumentNo =  '$returnArr[1]' AND ST.intDocumentYear =  '$returnArr[0]' 
			AND ST.intStyleId =  '$StyleId' AND ST.strBuyerPoNo =  '$buyerPoNo' 
			AND ST.intMatDetailId =  '$MatDetailID' AND ST.strColor =  '$Color' AND ST.strSize =  '$Size' and strType='SRTS'";		
			
// echo $SQLBIN;
	$result=$db->RunQuery($SQLBIN);
		while($row=mysql_fetch_array($result))
		{
			$BinQty=$row["BinQty"];
				$Qty =substr($BinQty,1);	
			$ResponseXML .="<Qty><![CDATA[". round($Qty,2) ."]]></Qty>\n";		
			$ResponseXML .="<MainStoresID><![CDATA[". $row["strMainStoresID"] ."]]></MainStoresID>\n";
			$ResponseXML .="<SubStores><![CDATA[". $row["strSubStores"] ."]]></SubStores>\n";
			$ResponseXML .="<Location><![CDATA[". $row["strLocation"] ."]]></Location>\n";
			$ResponseXML .="<Bin><![CDATA[". $row["strBin"] ."]]></Bin>\n";		
			$ResponseXML .="<MatSubCatId><![CDATA[". $row["intSubCatID"] ."]]></MatSubCatId>\n";
		}		
	$ResponseXML .="</LoadPendingConfirmBinDetails>";
	echo $ResponseXML;
}
else if($RequestType=="GetAllocatedBinQty")
{
$ResponseXML = "<LoadStores>\n";

$mainStoreId	= $_GET["msId"];
$subStoreId		= $_GET["ssId"];
$locationId		= $_GET["locId"];
$binId			= $_GET["binId"];

	$sql=" select MS.strName,SS.strSubStoresName,SL.strLocName,SB.strBinName
		from mainstores MS 
		inner join substores SS on SS.strMainID=MS.strMainID
		inner join storeslocations SL on SL.strMainID=MS.strMainID and SL.strSubID=SS.strSubID
		inner join storesbins SB on SB.strMainID=MS.strMainID and SB.strSubID=SS.strSubID and SB.strLocID=SL.strLocID
		where MS.strMainID='$mainStoreId'
		and SS.strSubID='$subStoreId'
		and SL.strLocID='$locationId'
		and SB.strBinID='$binId'";
		
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<MainStore><![CDATA[".$row["strName"]."]]></MainStore>\n";
		$ResponseXML .= "<SubStore><![CDATA[".$row["strSubStoresName"]."]]></SubStore>\n";
		$ResponseXML .= "<Location><![CDATA[".$row["strLocName"]."]]></Location>\n";
		$ResponseXML .= "<Bin><![CDATA[".$row["strBinName"]."]]></Bin>\n";
	}
$ResponseXML .="</LoadStores>";
echo $ResponseXML;
}
function getIssueQty($IssueNo,$IssueYear,$StyleID,$BuyerPONO,$MatDetailID,$Color,$Size,$grnNo,$grnYear,$grnType)
{
	global $db;
	global $companyId;
	
	$SQLStock="SELECT SUM(I.dblQty) AS IssueQty FROM issuesdetails AS I WHERE I.intIssueNo =  '$IssueNo' AND 
				I.intIssueYear =  '$IssueYear' AND I.intStyleId =  '$StyleID' AND I.strBuyerPONO =  '$BuyerPONO' AND 
				I.intMatDetailID =  '$MatDetailID' AND I.strColor =  '$Color' AND I.strSize =  '$Size' and I.intGrnNo='$grnNo' and I.intGrnYear='$grnYear' and I.strGRNType='$grnType'";
	//echo $SQLStock;			
	$resultStock=$db->RunQuery($SQLStock);
	$rowcount = mysql_num_rows($resultStock);
	if ($rowcount > 0)
	{
		while($rowStock=mysql_fetch_array($resultStock))
		{
			return $rowStock["IssueQty"];
		}
	}
	else 
	{
		return 0;
	}
}
function StockRevise($DocumentYear,$MainStores,$SubStores,$Location,$Bin,$StyleNo,$BuyerPoNo,$DocumentNo,$DocumentYear,$MatDetailId,$Color,$Size,$Unit,$BinQty,$UserID,$grnNo,$grnYear,$grnType)
{
			global $db;
			
$sqlInStock="INSERT INTO stocktransactions ".
         "(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear, ".
         "intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser,intGrnNo,intGrnYear,strGRNType) VALUES ".
		 "($DocumentYear,'$MainStores','$SubStores','$Location','$Bin','$StyleNo','$BuyerPoNo',$DocumentNo,$DocumentYear,$MatDetailId, ".
         "'$Color','$Size','CSRTS','$Unit',$BinQty,now(),'$UserID','$grnNo','$grnYear','$grnType')";
		
		$db->executeQuery($sqlInStock);
}

function ReviseStockAllocation($MainStores,$SubStores,$Location,$Bin,$MatDetailId,$Qty)
{
	global $db;
	$sql_allocation="select intSubCatID from matitemlist where intItemSerial='$MatDetailId'";
	$result_allocation=$db->RunQuery($sql_allocation);
	$row_allocation =mysql_fetch_array($result_allocation);
	
		$subCatId	= $row_allocation["intSubCatID"];
	
	$sqlbinallocation="update storesbinallocation ".
						"set ".
						"dblFillQty = dblFillQty-$Qty ".
						"where ".
						"strMainID = '$MainStores' ".
						"and strSubID = '$SubStores' ".
						"and strLocID = '$Location' ".
						"and strBinID = '$Bin' ".
						"and intSubCatNo = '$subCatId';";
	
	$db->executeQuery($sqlbinallocation);
}
function ReturnDetailsRevise($issueNo,$issueYear,$matrequisitionNo,$matrequisitionYear,$styleID,$buyerPoNo,$matdetailId,$color,$size,$qty,$grnNo,$grnYear,$grnType)
{
	global $db;	
	$SQL="update issuesdetails ".
		 "set ".
		 "dblBalanceQty = dblBalanceQty + $qty ".
		 "where ".
		 "intIssueNo = '$issueNo' and ".
		 "intIssueYear = '$issueYear' and ".
		 "intMatRequisitionNo = '$matrequisitionNo' and ".
		 "intMatReqYear = '$matrequisitionYear' and ".
		 "intStyleId = '$styleID' and ".
		 "strBuyerPONO = '$buyerPoNo' and ".
		 "intMatDetailID = '$matdetailId' and ".
		 "strColor = '$color' and ".
		 "strSize = '$size'
		 and intGrnNo='$grnNo' and  intGrnYear = '$grnYear' and strGRNType= '$grnType'
		 ";			 
	$db->executeQuery($SQL);
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

function GetReturnQty($issueNo,$issueYear,$mrnNo,$mrnYear,$StyleID,$buyerPoNo,$itemDetailID,$color,$size,$grnNo,$grnYear,$grnType)
{
	global $db;
	$qty = 0;
	$sql="select COALESCE(sum(RD.dblReturnQty),0)as dblReturnQty  from returntostoresdetails RD ".
		"inner join returntostoresheader RH on RH.intReturnNo=RD.intReturnNo and RH.intReturnYear=RD.intReturnYear ".
		"where RD.intIssueNo = '$issueNo' ".
		"and RD.intIssueYear = '$issueYear' ".
		"and RD.intMatrequisitionNo = '$mrnNo' ".
		"and RD.intMatrequisitionYear = '$mrnYear' ".
		"and RD.intStyleId = '$StyleID' ".
		"and RD.strBuyerPoNo = '$buyerPoNo' ".
		"and RD.intMatdetailID = '$itemDetailID' ".
		"and RD.strColor = '$color' ".
		"and RD.strSize = '$size' ".
		"and RD.intGrnNo = '$grnNo' ".
		"and RD.intGrnYear = '$grnYear' ".
		"and RD.strGRNType='$grnType' ".
		"and RH.intStatus <>10";
		
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["dblReturnQty"];
	}
	return $qty;
}

function checkStockAvailability($returnNo,$returnYear)
{
	global $db;
	$sql_1=" select intIssueNo,intIssueYear,intMatrequisitionNo,intMatrequisitionYear,intStyleId,
	strBuyerPoNo,intMatdetailID,strColor,strSize,dblReturnQty,intGrnNo,intGrnYear 
	from returntostoresdetails 
	where intReturnNo='$returnNo' 
	and intReturnYear='$returnYear'";
	
	$result_1=$db->RunQuery($sql_1);
	$rowCount = mysql_num_rows($result_1);
	$rwCnt =0;
	while($row_1=mysql_fetch_array($result_1))
	{
		$styleID			= $row_1["intStyleId"];
		$buyerPoNo			= $row_1["strBuyerPoNo"];
		$matdetailId		= $row_1["intMatdetailID"];
		$color				= $row_1["strColor"];
		$size				= $row_1["strSize"];
		$qty				= $row_1["dblReturnQty"];
		$grnNo 				= $row_1["intGrnNo"];
		$grnYear			= $row_1["intGrnYear"];
		
		$stockQty = getStockAvailableQty($styleID,$buyerPoNo,$matdetailId,$color,$size,$grnNo,$grnYear);
		
		if($stockQty >= $qty)
			$rwCnt++;
	}
	
	if($rwCnt == $rowCount)
		return true;
	else
		return false;	
}

function getStockAvailableQty($styleID,$buyerPoNo,$matdetailId,$color,$size,$grnNo,$grnYear)
{
	global $db;
	
	$sql = " Select sum(dblQty) as StockQty from stocktransactions where intGrnNo='$grnNo' and intGrnYear='$grnYear' and intStyleId='$styleID' and strBuyerPoNo='$buyerPoNo'	and intMatDetailId='$matdetailId' and strColor='$color' and strSize='$size' ";
			
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["StockQty"];		
}

function getStockTempData($returnNo,$returnYear)
{
	global $db;
	
	$sql = "SELECT * FROM stocktransactions_temp  
	where intDocumentNo='$returnNo' and intDocumentYear='$returnYear' and strType='SRTS'";
	
	return $db->RunQuery($sql);
}
function getSubcatID($MatDetailId)
{
	global $db;
	$sql_allocation="select intSubCatID from matitemlist where intItemSerial='$MatDetailId'";
	$result_allocation=$db->RunQuery($sql_allocation);
	$row_allocation =mysql_fetch_array($result_allocation);
	
		return $row_allocation["intSubCatID"];
}

function updateBindetails($binQty,$mainStoreId,$subStoreId,$locationId,$binId,$subCatID)
{
	global $db;
	
	$sql="update storesbinallocation ".
	 "set ".
	 "dblFillQty = dblFillQty + $binQty ".
	 "where ".
	 "strMainID = '$mainStoreId' AND ".
	 "strSubID = '$subStoreId ' AND ".
	 "strLocID = '$locationId' AND ".
	 "strBinID = '$binId' AND ".
	 "intSubCatNo = '$subCatID';";
	
	return $db->RunQuery($sql);
}

function chkBinAllocationAv($strMainStoresID,$strSubStores,$strLocation,$strBin,$intSubCatNo)
{
	global $db;
	
	$SQLbinAllo = " Select * from storesbinallocation
where strMainID='$strMainStoresID' and strSubID='$strSubStores' and strLocID='$strLocation' and strBinID='$strBin' and intSubCatNo = '$intSubCatNo' ";

	return $db->CheckRecordAvailability($SQLbinAllo);
}
function checkDataAvailble($ReturnNo,$ReturnYear)
{
	global $db;
	$sql = "select intReturnNo,intReturnYear from returntostoresheader where intReturnNo='$ReturnNo' and intReturnYear='$ReturnYear'";
	$result=$db->RunQuery($sql);
	$rowCount = mysql_num_rows($result);
	if($rowCount>0)
		return true;
	else
		return false;
}
?>