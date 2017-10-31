<?php
session_start();
	include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId  =$_SESSION["FactoryID"];
$userId		= $_SESSION["UserID"];

//$productionId = "";

if($RequestType=="loadStyle")
{		
	$ResponseXML .= "<loadStyle>";
	
		$SQL="SELECT DISTINCT ". 
			 "SP.intSRNO, ".
			 "SP.intStyleId ".
			 "FROM ".
			 "genmatrequisitiondetails AS MRD ".
			 "Inner Join specification AS SP ON MRD.intStyleId = SP.intStyleId ".
			 "Inner Join genmatrequisition AS MRH ON MRH.intMatRequisitionNo = MRD.intMatRequisitionNo ".
			 "AND MRD.intYear = MRH.intMRNYear  ".
			 "WHERE ".
			 "MRH.intCompanyID ='$companyId' ".
			 "AND ".
			 "MRD.dblBalQty >0 ".
			 "ORDER BY ".
			 "MRD.intStyleId ASC";
					
		$result = $db->RunQuery($SQL);
		
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<SRNO><![CDATA[" . $row["intSRNO"]  . "]]></SRNO>\n";
				 $ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"]  . "]]></StyleID>\n";  
			}
			
	$ResponseXML .= "</loadStyle>";
		echo $ResponseXML;

} 	
else if($RequestType=="LoadMaterial")
{
	$ResponseXML .="<LoadMaterial>";	
	$SQL="select intID,strDescription from genmatmaincategory";
	$result =$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<ID><![CDATA[". $row["intID"] ."]]></ID>\n";
		$ResponseXML .= "<Description><![CDATA[".  $row["strDescription"] ."]]></Description>\n";
	}
	$ResponseXML .="</LoadMaterial>";
	echo $ResponseXML;
}

if($RequestType=="loadSubCategory")
{	

		$intMainCatId = $_GET["mainCatId"];
			
		$ResponseXML .= "<genmatsubcategory>";

		$SQL="SELECT intSubCatNo,StrCatName FROM genmatsubcategory WHERE intCatNo =$intMainCatId   ORDER BY StrCatName";
				
		$result = $db->RunQuery($SQL);
		$ResponseXML .= "<intSubCatNo><![CDATA[" . "" . "]]></intSubCatNo>\n";
		$ResponseXML .= "<StrCatName><![CDATA[" . ""  . "]]></StrCatName>\n";
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<intSubCatNo><![CDATA[" . $row["intSubCatNo"]  . "]]></intSubCatNo>\n";
				 $ResponseXML .= "<StrCatName><![CDATA[" . $row["StrCatName"]  . "]]></StrCatName>\n";  
			}
			$ResponseXML .= "</genmatsubcategory>";
			echo $ResponseXML;
}

else if($RequestType=="LoadBuyerPoNo")
{		
	$strStyleName=$_GET["strStyleName"];
	$ResponseXML .= "<BuyerPONO>";
	$SQL="Select Distinct strBuyerPONO,intStyleId  from genmatrequisitiondetails where intStyleId = '" . $strStyleName ."' ORDER BY strBuyerPONO ";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<BuyerPONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONO>\n";
	}
	$ResponseXML .= "</BuyerPONO>";
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

/*	$SQL ="SELECT concat(GSH.intYear,'/',GSH.strGatepassID) as intIssueNo , GSH.dtmDate ,GSH.intStatus, MST.strName FROM  nomgatepassheader GSH Inner Join mainstores MST ON GSH.intToStores = MST.strMainID WHERE GSH.intStatus = 1 AND GSH.intCompanyID='$companyId'";*/
	$SQL ="SELECT concat(GSH.intYear,'/',GSH.strGatepassID) as intIssueNo , GSH.dtmDate ,GSH.intStatus, GSH.intToStores AS strName 
FROM  nomgatepassheader GSH 
WHERE GSH.intStatus = 1 AND GSH.intCompanyID='$companyId'";
	//echo $SQL;
	if ($issueYearFrom!="")
	{
			$SQL .="AND strGatepassID >='" . $issueNoFrom . "' AND intYear = '" . $issueYearFrom . "' "; 
	}
	if ($issueYearTo!="")
	{
			$SQL .="AND strGatepassID <='" . $issueNoTo . "' AND intYear = '" . $issueYearTo . "' ";
	}
		if ($chkdate=="true")
		{
			if ($issueDateFrom!="")
			{
					$SQL .="AND dtmDate >= '" . $formatedfromDate . "' ";
			}
			if ($issueDateTo!="")
			{
					$SQL .="AND dtmDate <= '" . $formatedToDate . "' ";
			}
		}

	$result = $db->RunQuery($SQL);
	
	while ($row = mysql_fetch_array($result))	
	{
		$ResponseXML .= "<IssueNo><![CDATA[" . $row["intIssueNo"]  . "]]></IssueNo>\n";
		$ResponseXML .= "<IssuedDate><![CDATA[" . $row["dtmDate"]  . "]]></IssuedDate>\n";
		$ResponseXML .= "<SecurityNo><![CDATA[" . $row["strName"]  . "]]></SecurityNo>\n";
		$ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n";
	}
	$ResponseXML .= "</GetLoadSavedDetails>";
		echo $ResponseXML;
}
else if ($RequestType=="GetBinDetails")
{
	$styleId =$_GET["styleId"];
	$buyerPoNo =$_GET["buyerPoNo"];
	$buyerPoNo = str_replace("Main Ratio","#Main Ratio#",$buyerPoNo);
	$matdetailId =$_GET["matdetailId"];
	$color =$_GET["color"];
	$size =$_GET["size"];
	
	$ResponseXML .="<GetBinDetails>";
	
/* 		$SQL =" SELECT strBin,strType,SUM(dblQty) as dblstockBal,strMainStoresID,strSubStores,strLocation,strUnit  from  stocktransactions WHERE intStyleId ='" . $styleId . "'  AND strBuyerPoNo='" . $buyerPoNo . "' AND intMatDetailId ='" . $matdetailId . "' AND strColor='" . $color . "' AND  strSize='" . $size . "' GROUP BY strBin ";*/
	
	$SQL="SELECT ".
		 "ST.strBin, ".
		 "ST.strType, ".
		 "Sum(dblQty) AS dblstockBal, ".
		 "ST.strMainStoresID, ".
		 "ST.strSubStores, ".
		 "ST.strLocation, ".
		 "ST.strUnit ".
		 "FROM stocktransactions AS ST ".
		 "Inner Join useraccounts AS UA ON ST.intUser = UA.intUserID ".
		 "WHERE ".
		 "ST.intStyleId ='$styleId' AND ".
		 "ST.strBuyerPoNo ='$buyerPoNo' AND ".
		 "ST.intMatDetailId ='$matdetailId' AND ".
		 "ST.strColor ='$color' AND ".
		 "ST.strSize ='$size' AND ".
		 "UA.intCompanyID ='$companyId' ".
		 "GROUP BY ".
		 "ST.strBin, ".
		 "ST.strLocation, ".
		 "ST.strSubStores, ".
		 "ST.strMainStoresID";
	
	$result = $db->RunQuery($SQL);
	
	while ($row = mysql_fetch_array($result))
	{
		$ResponseXML .="<Bin><![CDATA[" . $row["strBin"] . "]]></Bin>\n";
		$ResponseXML .="<stockBal><![CDATA[" . $row["dblstockBal"] . "]]></stockBal>\n";
		$ResponseXML .="<MainStoresID><![CDATA[" . $row["strMainStoresID"] . "]]></MainStoresID>\n";
		$ResponseXML .="<SubStore><![CDATA[" . $row["strSubStores"] . "]]></SubStore>\n";
		$ResponseXML .="<Location><![CDATA[" . $row["strLocation"] . "]]></Location>\n";
		$ResponseXML .="<Unit><![CDATA[" . $row["strUnit"] . "]]></Unit>\n";
	}
	$ResponseXML .="</GetBinDetails>";
	echo $ResponseXML;
}
else if($RequestType=="LoadIssueno")
{		
/*	//$NextIssueNo = NGatepass."".$companyId;
	$NextIssueNo = "NGatepass"."".$companyId;
    //echo $NextIssueNo;
	$ResponseXML .="<LoadIssueno>";
	
		$SQL="select strValue AS issueNo from settings where strKey = '$NextIssueNo' ";		
		
		$result =$db->RunQuery($SQL);
	
		while($row = mysql_fetch_array($result))
		{
			$ResponseXML .= "<issueNo><![CDATA[" . $row["issueNo"] . "]]></issueNo>\n";				
			
			$issue=$row["issueNo"]+ 1;
		}
		
		$sql = "update settings set strValue =$issue where strKey = '$NextIssueNo' ";
		$db->executeQuery($sql);
		
	$ResponseXML .="</LoadIssueno>";
	echo $ResponseXML;*/
	
//	-----------------------------------------

	$NextId = "NGatepass".$companyId;
	$intMaxNo=0;
	$ResponseXML .="<LoadIssueno>";
	
	$SqlRange="select strValue AS companyRange from settings where strKey ='$companyId'";
		
		$resultRange =$db->RunQuery($SqlRange);
		
			while($row = mysql_fetch_array($resultRange))
				{
					$companyRange=explode("-",$row["companyRange"]);				
				}
				
		$SQL="select strValue AS No from settings where strKey = '$NextId' ";		
		
		$result =$db->RunQuery($SQL);
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{				
					$maxNo=$row["No"];
				}
				$intMaxNo=(int)$maxNo;
		}
		else 
		{		
			$intMaxNo=(int)$companyRange[0];
			$SQLIN ="INSERT INTO settings (strKey,strValue) VALUES ('$NextId',$intMaxNo)";			 
			$db->executeQuery($SQLIN);
		}		
		if($intMaxNo>=(int)$companyRange[0] && $intMaxNo<(int)$companyRange[1])
			{
				$NoYear = date('Y');
				$ResponseXML .= "<No><![CDATA[".$intMaxNo."]]></No>\n";
				$ResponseXML .= "<Year><![CDATA[".$NoYear."]]></Year>\n";
				$nextNo=$intMaxNo+1;
				$sqlUpdate="UPDATE settings SET strValue='$nextNo' WHERE strKey='$NextId';";
				$db->executeQuery($sqlUpdate);
			}
	//----------------------------	
	$ResponseXML .="</LoadIssueno>";
	echo $ResponseXML;
}
else if ($RequestType=="SaveIssueHeader")
{
	$issueNo =$_GET["issueNo"];
	$issueYear =$_GET["issueYear"];
	$productionId =$_GET["productionId"];
	
	$instructbyId = $_GET["instructbyId"];
	$attention =  $_GET["attention"];
	$through =  $_GET["through"];
	$instructions =  $_GET["specialInstructions"];
	$instructions = str_replace("'","''",$instructions);
	
	$remarks =  $_GET["remarks"];
	$remarks = str_replace("'","''",$remarks);
	
	$styleNo =  $_GET["styleNo"];
	$styleNo = str_replace("'","''",$styleNo);
		
	$sql="delete from nomgatepassheader where strGatepassID='$issueNo' and intYear='$issueYear'";
 	$db->executeQuery($sql);	
	
	$SQL = "insert into nomgatepassheader 
				(strGatepassID, 
				intYear, 
				intToStores, 
				strAttention,
				strThrough,
				intInstructedBy,
				dtmDate, 
				intStatus, 
				intCompanyId, 
				intUserId,
				strInstructions,
				strRemarks,
				strStyleID
				)
				values
				('". $issueNo ."', 
				'". $issueYear ."', 
				'". $productionId ."', 
				'". $attention ."',
				'". $through ."',
				'". $instructbyId ."',
				now(), 
				1, 
				'". $companyId ."', 
				'$userId', 
				'$instructions',
				'$remarks',
				'$styleNo');";			 				
	$db->executeQuery($SQL);
}
else if ($RequestType=="SaveIssueDetails")
{
	$issueNo =$_GET["issueNo"];
	$issueYear =$_GET["issueYear"];
	$itemdDetailID =$_GET["itemdDetailID"];
	$qty = $_GET["qty"];
	$Unit = $_GET["Unit"];	
	$returnable = $_GET["returnable"];	
	
	$sql="delete from nomgatepassdetail where strGatepassID='$issueNo' and intYear='$issueYear' and intMatDetailID='$itemdDetailID'";
 	$db->executeQuery($sql);
	
 	$SQL = " insert into nomgatepassdetail 
			(strGatepassID, 
			intYear, 
			intMatDetailID, 
			dblQty,
			strUnit,
			intReturnable
			)
			values
			('". $issueNo ."', 
			'". $issueYear ."', 
			'". $itemdDetailID ."', 
			'". $qty ."',
			'". $Unit ."',
			'$returnable'
			);";	 
	$db->executeQuery($SQL);		
}
else if ($RequestType=="SaveBinDetails")
{
	$issueNo = $_GET["issueNo"];
	$Year =$_GET["Year"];
	$mainStores = $_GET["mainStores"];
	$subStores =$_GET["subStores"];
	$location = $_GET["location"];
	$binId =$_GET["binId"];
	$styleId =$_GET["styleId"];
	$BuyerPoNo = $_GET["BuyerPoNo"];
	$BuyerPoNo = str_replace("Main Ratio","#Main Ratio#",$BuyerPoNo);
	$itemdDetailID = $_GET["itemdDetailID"];
	$color = $_GET["color"];
	$size = $_GET["size"];
	$units =$_GET["units"];
	$issueQty = $_GET["issueQty"];
	$qty ="-". $issueQty;
	
	$SQL="INSERT INTO stocktransactions(intYear,strMainStoresID,strSubStores,strLocation,strBin,intStyleId,strBuyerPoNo,intDocumentNo,intDocumentYear, ".
         " intMatDetailId,strColor,strSize,strType,strUnit,dblQty,dtmDate,intUser) VALUES ".
		 " ($Year,'$mainStores','$subStores','$location','$binId','$styleId','$BuyerPoNo',$issueNo,$Year,$itemdDetailID, ".
         " '$color','$size','ISSUE','$units',$qty,now(),$userId) ";
				
	$db->executeQuery($SQL);
	
}
else if ($RequestType=="ResponseValidate")
{
	$issueNo = $_GET["issueNo"];
	$Year = $_GET["Year"];
	$validateCount = $_GET["validateCount"];
//	$validateBinCount = $_GET["validateBinCount"];
	
	$ResponseXML .="<ResponseValidate>";
	$SQL="SELECT COUNT(strGatepassID) AS headerRecCount FROM nomgatepassheader where strGatepassID=$issueNo AND intYear=$Year";

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
	$SQL="SELECT COUNT(strGatepassID) AS issuesdetails FROM nomgatepassdetail where strGatepassID=$issueNo AND intYear=$Year";

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
	
	$ResponseXML .="</ResponseValidate>";
	echo $ResponseXML;
}
else if($RequestType=="LoadPopUpIssueNo")
{

	$state=$_GET["state"];
	$year=$_GET["year"];

	$ResponseXML.="<LoadPopUpIssueNo>";
	global $db;
	/*$SQL="SELECT DISTINCT IH.intIssueNo ".
		 "FROM issues AS IH ".
		 "INNER JOIN issuesdetails AS ID ".
		 "ON IH.intIssueNo=ID.intIssueNo AND IH.intIssueYear=ID.intIssueYear ".
		 "WHERE IH.intStatus='$state' AND IH.intIssueYear='$year'";*/
	$SQL="SELECT DISTINCT IH.strGatepassID,IH.intYear  ".
		 "FROM nomgatepassheader AS IH ".
		 "INNER JOIN nomgatepassdetail AS ID ".
		 "ON IH.strGatepassID=ID.strGatepassID AND IH.intYear=ID.intYear ".
		 "WHERE IH.intStatus='$state'";
//echo $SQL;
	
	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		//$ResponseXML .= "<IssueNo><![CDATA[" . $row["intIssueNo"]. "]]></IssueNo>\n";
		$ResponseXML .= "<IssueNo><![CDATA[" . $row["strGatepassID"]. "]]></IssueNo>\n";
		$ResponseXML .= "<Year><![CDATA[" . $row["intYear"]. "]]></Year>\n";
	}
	$ResponseXML.="</LoadPopUpIssueNo>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadHeaderDetails")
{
$no			= $_GET["no"];
$year		= $_GET["year"];

$ResponseXML = "";
$ResponseXML .= "<LoadHeaderDetails>";

$sql="SELECT concat(GH.intYear,'/',GH.strGatepassID)AS gatePassNo,GH.strRemarks,GH.strAttention,GH.strThrough,GH.intToStores,GH.intInstructedBy,GH.strStyleID,GH.strInstructions ".
"FROM nomgatepassheader GH ".
"WHERE GH.strGatepassID = '$no' ". 
"AND GH.intYear = '$year'";

	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{		
		$ResponseXML .= "<GatePassNo><![CDATA[" . $row["gatePassNo"]. "]]></GatePassNo>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]. "]]></Remarks>\n";
		$ResponseXML .= "<Attention><![CDATA[" . $row["strAttention"]. "]]></Attention>\n";
		$ResponseXML .= "<Through><![CDATA[" . $row["strThrough"]. "]]></Through>\n";
		$ResponseXML .= "<ToStores><![CDATA[" . $row["intToStores"]. "]]></ToStores>\n";
		$ResponseXML .= "<InstructedBy><![CDATA[" . $row["intInstructedBy"]. "]]></InstructedBy>\n";
		$ResponseXML .= "<StyleID><![CDATA[" . $row["strStyleID"]. "]]></StyleID>\n";
		$ResponseXML .= "<Instructions><![CDATA[" . $row["strInstructions"]. "]]></Instructions>\n";
	}

$ResponseXML .= "</LoadHeaderDetails>";
echo $ResponseXML;
}
elseif($RequestType=="LoadGatePassDetails")
{
$no			= $_GET["no"];
$year		= $_GET["year"];

$ResponseXML = "";
$ResponseXML .= "<LoadGatePassDetails>";

$sql="SELECT GD.intMatDetailID,GD.dblQty,GD.strUnit,GD.intReturnable 
FROM nomgatepassdetail GD
WHERE GD.strGatepassID = '$no'
AND GD.intYear = '$year'";

	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{		
		$ResponseXML .= "<Description><![CDATA[" . $row["intMatDetailID"]. "]]></Description>\n";
		$ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]. "]]></Qty>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]. "]]></Unit>\n";
		$ResponseXML .= "<Returnable><![CDATA[" . $row["intReturnable"]. "]]></Returnable>\n";
	}

$ResponseXML .= "</LoadGatePassDetails>";
echo $ResponseXML;
}
?>