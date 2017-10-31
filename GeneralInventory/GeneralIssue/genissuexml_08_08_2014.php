<?php
session_start();
include "../../Connector.php";
include("../class.glcode.php");
$objgl = new glcode();

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];
//$companyId   = $_SESSION["FactoryID"];
$companyId   = $_SESSION["FactoryID"];
$userId		 = $_SESSION["UserID"];

//$companyId = GetMainStoresID($companyId);

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
	$SQL="select intID,strDescription from genmatmaincategory order by strDescription";
	$result =$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<ID><![CDATA[". $row["intID"] ."]]></ID>\n";
		$ResponseXML .= "<Description><![CDATA[".  $row["strDescription"] ."]]></Description>\n";
	}
	$ResponseXML .="</LoadMaterial>";
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
	
	$SQL ="SELECT concat(intIssueYear,'/',intIssueNo) as intIssueNo , dtmIssuedDate ,strProdLineNo ,genissues.intStatus,
companies.strName FROM  genissues Inner Join companies ON genissues.intCompanyID = companies.intCompanyID WHERE genissues.intStatus = 1 AND genissues.intCompanyID='$companyId'";
	
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
		$ResponseXML .= "<company><![CDATA[" . $row["strName"]  . "]]></company>\n";
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

	 $FactoryID				= $_SESSION["FactoryID"];
	$ResponseXML .="<LoadIssueno>";
	
	
		 //--------------------hem----------------------------------- 
		 
		    $SQL="SELECT dblGIssueNo FROM syscontrol WHERE intCompanyID='$FactoryID'";
			$result =  $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$intGenIssueNo =  $row["dblGIssueNo"];
				$SQL = "UPDATE syscontrol set dblGIssueNo=dblGIssueNo+1 where intCompanyID='$FactoryID'";
				$result = $db->RunQuery($SQL);
				break;
			}
			$ResponseXML .= "<issueNo><![CDATA[" . $intGenIssueNo . "]]></issueNo>\n";				
			
		//--------------------------------------------------------------		 
	
	
	$ResponseXML .="</LoadIssueno>";
	echo $ResponseXML;
}
else if ($RequestType=="SaveIssueHeader")
{
	$issueNo =$_GET["issueNo"];
	$issueYear =$_GET["issueYear"];
	$productionId =$_GET["productionId"];	
		
 		$SQL= " INSERT INTO genissues (intIssueNo,intIssueYear,dtmIssuedDate,strProdLineNo,intStatus,intUserid,intCompanyID)  ". 
				" VALUES ($issueNo,$issueYear,now(),'$productionId',1,'" . $_SESSION["UserID"] . "',$companyId) ";	
	$db->executeQuery($SQL);
}
else if ($RequestType=="SaveIssueDetails")
{
	$issueNo 		= $_GET["issueNo"];
	$issueYear 		= $_GET["issueYear"];
	$mrnNo 			= $_GET["mrnNo"];
	$mrnArray		= explode('/',$mrnNo);
	$itemdDetailID 	= $_GET["itemdDetailID"];
	$qty 			= $_GET["qty"];	
	$dtmDate		= date("Y-m-d");
	$grnNo 			= $_GET["grnNo"];
	if($grnNo == "1/1"){$grnNo = "0/0";}
	$grnArray		= explode('/',$grnNo);
	/*$CostCenterId 	= $_GET["CostCenterId"];
	$GLAllowId		= $_GET["GLAllowId"];*/
	$itmUnit 		= $_GET["itmUnit"];
	
	$mainStoresId = GetMainStoresID($companyId);
	
$SQL= " INSERT INTO genissuesdetails (intIssueNo,intIssueYear,intGrnNo,intGrnYear,			intMatRequisitionNo,intMatReqYear,intMatDetailID,dblQty, ".
	  " dblBalanceQty,intCostCenterId,intGLAllowId)
	   VALUES ('$issueNo','$issueYear','$grnArray[1]','$grnArray[0]','$mrnArray[1]','$mrnArray[0]','$itemdDetailID','$qty','$qty','0','0') ";	
		$db->executeQuery($SQL);	
	
$SQL =" UPDATE genmatrequisitiondetails SET dblBalQty = dblBalQty - $qty WHERE intMatRequisitionNo = '$mrnArray[1]' AND intYear = '$mrnArray[0]' ".
		  " AND strMatDetailID='$itemdDetailID' ";		  
		   $db->executeQuery($SQL);
		  
		  $SQL =" UPDATE genmatitemlist SET dblStock = dblStock - $qty WHERE intItemSerial='$itemdDetailID' ";
		  $db->executeQuery($SQL);
		  
		  /* Stock Transaction */
		  $SQL = "";
		$SQL = "insert into genstocktransactions 
					(intYear, 
					strMainStoresID, 
					intDocumentNo, 
					intDocumentYear, 
					intMatDetailId, 
					strType, 
					strUnit, 
					dblQty, 
					dtmDate, 
					intUser,
					intGRNNo,
					intGRNYear,
					intCostCenterId,
					intGLAllowId
					)
					values
					('". $issueYear ."', 
					'$mainStoresId',
					'". $issueNo ."', 
					'". $issueYear ."', 
					'". $itemdDetailID ."', 
					'ISSUE', 
					'". $itmUnit ."', 
					'". ($qty * -1) ."', 
					'". $dtmDate ."', 
					'".  $_SESSION["UserID"] ."',
					'". $grnArray[1] ."', 
					'". $grnArray[0] ."',
					'0',
					'0'
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
		 " ('$Year','$mainStores','$subStores','$location','$binId','$styleId','$BuyerPoNo','$issueNo','$Year','$itemdDetailID', ".
         " '$color','$size','ISSUE','$units','$qty',now(),'$userId') ";
				
	$db->executeQuery($SQL);
	
}
else if ($RequestType=="ResponseValidate")
{
	$issueNo = $_GET["issueNo"];
	$Year = $_GET["Year"];
	$validateCount = $_GET["validateCount"];
	
	$ResponseXML .="<ResponseValidate>";
	$SQL="SELECT COUNT(intIssueNo) AS headerRecCount FROM genissues where intIssueNo='$issueNo' AND intIssueYear='$Year'";

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
	$SQL="SELECT COUNT(intIssueNo) AS issuesdetails FROM genissuesdetails where intIssueNo='$issueNo' AND intIssueYear='$Year'";

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
	$SQL="SELECT DISTINCT IH.intIssueNo ".
		 "FROM genissues AS IH ".
		 "INNER JOIN genissuesdetails AS ID ".
		 "ON IH.intIssueNo=ID.intIssueNo AND IH.intIssueYear=ID.intIssueYear ".
		 "WHERE IH.intStatus='$state' AND IH.intIssueYear='$year'";
	
	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
	$ResponseXML .= "<IssueNo><![CDATA[" . $row["intIssueNo"]. "]]></IssueNo>\n";
	}
	$ResponseXML.="</LoadPopUpIssueNo>";
	echo $ResponseXML;
}
/////------------------------------start 2011-05-03---------------------------------------------------
//start laod gen MRN no main category wise
else if($RequestType=="LoadMrnNo")
{
$mainCatId = $_GET["mainCatId"];		
	$ResponseXML .= "<LoadMrnNo>";			
		$SQL="SELECT DISTINCT concat(genmatrequisition.intMRNYear,'/',genmatrequisition.intMatRequisitionNo) as strMrnNo 
FROM genmatrequisition INNER JOIN 
genmatrequisitiondetails ON genmatrequisition.intMatRequisitionNo = genmatrequisitiondetails.intMatRequisitionNo
inner join genmatitemlist gmil on  gmil.intItemSerial =  genmatrequisitiondetails.strMatDetailID
WHERE (genmatrequisition.intStatus =1)  AND (genmatrequisitiondetails.dblBalQty >0)   AND (genmatrequisition.intCompanyID='$companyId') ";	

	if($mainCatId != '')
		$SQL .= " and gmil.intMainCatID='$mainCatId' ";
	$SQL .= " order by genmatrequisition.intMRNYear,genmatrequisition.intMatRequisitionNo desc ";	
	
		$result = $db->RunQuery($SQL);
		$str = "<option value=\"".""."\">" .""."</option>";
			while($row = mysql_fetch_array($result))
			{ 
				$str .= "<option value=\"". $row["strMrnNo"] ."\">" . $row["strMrnNo"] ."</option>"; 
			}
	$ResponseXML .= "<MrnNo><![CDATA[" . $str  . "]]></MrnNo>\n";		
	$ResponseXML .= "</LoadMrnNo>";
		echo $ResponseXML;

}
//end laod gen MRN no main category wise
//start load MRN details to item popup grid 
else if($RequestType=="loadMrnDetailsToGrid")
{		
	
	$mrnno=$_GET["strMrnNo"];
	$arrayMRNNo	= explode('/',$mrnno);
	$MatId=$_GET["MatId"];
	
	$ResponseXML .= "<loadMrnDetailsToGrid>";
  		
				$SQL = "SELECT 			
						MD.strMatDetailID,
						MD.dblQty AS dblQty, 
						MD.dblBalQty, 
						MAT_L.strItemDescription, 
						MAT_L.strUnit AS strUnit, 
						MAT_L.dblStock AS dblStockQty ,
						concat(MD.intGRNYear,'/',MD.intGRNNo) as grnNo,
						GMR.strDepartmentCode,
						GMR.intCostCenterId,
						GMC.strDescription as MainCatDes,
						MD.intGLAllowId,
						MAT_L.strItemCode
						
						FROM 
						genmatrequisitiondetails AS MD 
						Inner Join genmatitemlist AS MAT_L ON MD.strMatDetailID = MAT_L.intItemSerial 
						INNER JOIN genmatmaincategory MC ON MAT_L.intMainCatID = MC.intID
						Inner Join genmatrequisition GMR ON GMR.intMatRequisitionNo = MD.intMatRequisitionNo
						Inner Join useraccounts AS UA ON GMR.intUserId = UA.intUserID 
						Inner join genmatmaincategory GMC ON GMC.intID=MAT_L.intMainCatID
						WHERE 
						(MD.intMatRequisitionNo = '" . $arrayMRNNo[1] . "') AND 
						(MD.intYear ='" . $arrayMRNNo[0] . "') AND 
						(MD.dblBalQty >  0) AND 
						GMR.intRequestLocationId ='$companyId'";
						//GMR.intCompanyID ='$companyId'";
		if ($MatId!="")
		{
			$SQL .=" AND MAT_L.intMainCatID='" . $MatId . "' ";
		}
		
		$SQL .=" GROUP BY MD.strMatDetailID,MD.intGRNNo"; 
	
		//echo $SQL;
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$GLAllowId = $row["intGLAllowId"];
				$GLCode    = $objgl-> getGLCode($GLAllowId);
				$ResponseXML .= "<GLCode><![CDATA[" . $GLCode  . "]]></GLCode>\n";
				$ResponseXML .= "<GLAllowId><![CDATA[" . $GLAllowId  . "]]></GLAllowId>\n";
				$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDescription>\n";
				$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
				$ResponseXML .= "<BalQty><![CDATA[" . $row["dblBalQty"]  . "]]></BalQty>\n";
				$ResponseXML .= "<MatDetailID><![CDATA[" . $row["strMatDetailID"]  . "]]></MatDetailID>\n";
				$ResponseXML .= "<MatMainID><![CDATA[" . $row["strDescription"]  . "]]></MatMainID>\n";
							
				$stockQty = getStockQty($row["strMatDetailID"],$companyId,$row["intCostCenterId"]);
				$ResponseXML .= "<StockQty><![CDATA[" . $stockQty  . "]]></StockQty>\n";
				$ResponseXML .= "<GRNNo><![CDATA[" . $row["grnNo"]  . "]]></GRNNo>\n";
				$ResponseXML .= "<Department><![CDATA[" . $row["strDepartmentCode"]  . "]]></Department>\n";
				$ResponseXML .= "<costCenterId><![CDATA[" . $row["intCostCenterId"]  . "]]></costCenterId>\n";
				$ResponseXML .= "<costCenterDes><![CDATA[" . $row["CostCenterDes"]  . "]]></costCenterDes>\n";
				$ResponseXML .= "<MainCatDes><![CDATA[" . $row["MainCatDes"]  . "]]></MainCatDes>\n";
				$ResponseXML .= "<ItemCode><![CDATA[" . $row["strItemCode"]  . "]]></ItemCode>\n";
						
			}			  		
		$ResponseXML .= "</loadMrnDetailsToGrid>";
		echo $ResponseXML;

}elseif($RequestType=="loadGRNList"){
	
	$intMatDetailId = $_GET['intMatItemCode'];
	
	$intMainStoresId = GetMainStoresID($companyId);
	
	$ResponseXML .= "<loadGRNDetails>";
	
	/*$SQL = " SELECT
gengrndetails.strGenGrnNo,
gengrndetails.intYear,
genstocktransactions.strUnit,
Sum(genstocktransactions.dblQty) AS BalQty,
genstocktransactions.strType
FROM
genstocktransactions
Left Join gengrndetails ON gengrndetails.strGenGrnNo = genstocktransactions.intGRNNo AND gengrndetails.intYear = genstocktransactions.intGRNYear
WHERE
genstocktransactions.strMainStoresID =  '$intMainStoresId' AND
genstocktransactions.intMatDetailId =  '$intMatDetailId' ";*/


	$SQL = " SELECT
genstocktransactions.intDocumentNo,
genstocktransactions.intDocumentYear,
genstocktransactions.strUnit,
Sum(genstocktransactions.dblQty) AS BalQty,
genstocktransactions.strType
FROM
genstocktransactions
Left Join gengrndetails ON gengrndetails.strGenGrnNo = genstocktransactions.intGRNNo AND gengrndetails.intYear = genstocktransactions.intGRNYear
WHERE
genstocktransactions.strMainStoresID =  '$intMainStoresId' AND
genstocktransactions.intMatDetailId =  '$intMatDetailId' ";

	$SQL .= " GROUP BY gengrndetails.strGenGrnNo, gengrndetails.intYear, genstocktransactions.strUnit ";
	
	$result = $db->RunQuery($SQL);
	
	while($row=mysql_fetch_array($result)){
		
		/*$ResponseXML .= "<GRNNo><![CDATA[" . $row['strGenGrnNo']  . "]]></GRNNo>\n";
		$ResponseXML .= "<GRNYear><![CDATA[" . $row['intYear']  . "]]></GRNYear>\n";*/
		$ResponseXML .= "<GRNNo><![CDATA[" . $row['intDocumentNo']  . "]]></GRNNo>\n";
		$ResponseXML .= "<GRNYear><![CDATA[" . $row['intDocumentYear']  . "]]></GRNYear>\n";
		$ResponseXML .= "<UNIT><![CDATA[" . $row["strUnit"]  . "]]></UNIT>\n";
		$ResponseXML .= "<QTY><![CDATA[" . $row["BalQty"]  . "]]></QTY>\n";
		$ResponseXML .= "<TYPE><![CDATA[" . $row["strType"]  . "]]></TYPE>\n";		
	}
	
	$ResponseXML .= "</loadGRNDetails>";
	echo $ResponseXML;

	
}
//end load MRN details to item popup grid 
function getStockQty($matDetailId,$companyId,$costCenterId)
{
	global $db;
	/*$sql ="SELECT COALESCE(Sum(genstocktransactions.dblQty),0) AS dblStockQty FROM genstocktransactions WHERE genstocktransactions.strMainStoresID  = '". $companyId ."'	AND genstocktransactions.intMatDetailId =  '$matDetailId' AND genstocktransactions.intCostCenterId =  '$costCenterId' "; */
	$sql = "SELECT COALESCE(Sum(genstocktransactions.dblQty),0) AS dblStockQty FROM genstocktransactions Inner Join mainstores ON genstocktransactions.strMainStoresID = mainstores.strMainID
WHERE
mainstores.intCompanyId =  '". $companyId ."' AND
genstocktransactions.intMatDetailId =  '$matDetailId'";
				
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["dblStockQty"];
}

function GetMainStoresID($prmCompanyId){
	
	global $db;
	
	$sql = " SELECT * FROM mainstores WHERE intCompanyId = ".$prmCompanyId;
	
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result)){		
		return $row['strMainID'];		
	}
}

?>