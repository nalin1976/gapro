<?php
session_start();
include "../../Connector.php";
include("../class.glcode.php");
$objgl = new glcode();

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId  =$_SESSION["FactoryID"];
$userId		= $_SESSION["UserID"];

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
	$SQL="select intID,strDescription from genmatmaincategory Order By strDescription";
	$result =$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<ID><![CDATA[". $row["intID"] ."]]></ID>\n";
		$ResponseXML .= "<Description><![CDATA[".  $row["strDescription"] ."]]></Description>\n";
	}
	$ResponseXML .="</LoadMaterial>";
	echo $ResponseXML;
}

else if($RequestType=="loadMrnDetailsToGrid")
{		
	$MatId=$_GET["MatId"];
	$IssLike=$_GET["IssLike"];
	
	$ResponseXML .= "<loadMrnDetailsToGrid>";
						
		$SQL = "SELECT genmatitemlist.strItemDescription,
				genmatitemlist.strUnit,
				genissuesdetails.intIssueNo,
				genissuesdetails.intIssueYear,
				genissuesdetails.intMatDetailID,
				genissuesdetails.dblBalanceQty,
				concat(genissuesdetails.intGRNYear,'/',genissuesdetails.intGRNNo) as GRNNo,
				genmatmaincategory.strDescription,
				genissuesdetails.intCostCenterId,
				genissuesdetails.intGLAllowId
				FROM
				genmatitemlist
				Inner Join genissuesdetails ON genmatitemlist.intItemSerial = genissuesdetails.intMatDetailID
				Inner Join genmatmaincategory ON genmatitemlist.intMainCatID = genmatmaincategory.intID
				WHERE
				genmatitemlist.intMainCatID =  '" . $MatId . "' and genissuesdetails.dblBalanceQty >0 ";
				
				if($IssLike != "")
				{
					$SQL .= " AND genissuesdetails.intIssueNo LIKE '". "%" . $IssLike ."%" ."'  ";
				}
		
		$result = $db->RunQuery($SQL);
		
			while($row = mysql_fetch_array($result))
			{
				$GLAllowId    = $row["intGLAllowId"];
				$GLCode       = $objgl-> getGLCode($GLAllowId);
				$ResponseXML .= "<GLCode><![CDATA[" . $GLCode  . "]]></GLCode>\n";
				$ResponseXML .= "<GLAllowId><![CDATA[" . $GLAllowId  . "]]></GLAllowId>\n";
				$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDescription>\n";
				$ResponseXML .= "<IssueNo><![CDATA[" . $row["intIssueNo"]  . "]]></IssueNo>\n";
				$ResponseXML .= "<IssueYear><![CDATA[" . $row["intIssueYear"]  . "]]></IssueYear>\n";
				$ResponseXML .= "<MatDetailID><![CDATA[" . $row["intMatDetailID"]  . "]]></MatDetailID>\n";
				$ResponseXML .= "<MatCatID><![CDATA[" . $row["strDescription"]  . "]]></MatCatID>\n";
				$ResponseXML .= "<IssueBalQty><![CDATA[" . $row["dblBalanceQty"]  . "]]></IssueBalQty>\n";
				$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
				$ResponseXML .= "<GrnNo><![CDATA[" . $row["GRNNo"]  . "]]></GrnNo>\n";	
				$ResponseXML .= "<costCenterId><![CDATA[" . $row["intCostCenterId"]  . "]]></costCenterId>\n";	
				$ResponseXML .= "<costCenterDes><![CDATA[" . $row["CostCenterDes"]  . "]]></costCenterDes>\n";			 			
			}
			
	$ResponseXML .= "</loadMrnDetailsToGrid>";
		echo $ResponseXML;

} 
else if($RequestType=="GetLoadSavedDetails")
{
	$strIssueNoFrom = $_GET["strIssueNoFrom"];
	$ArrayissueNo = explode('/',$issueNo);
	$strIssueNoTo = $_GET["strIssueNoTo"];
	$ArrayissuetoNo = explode('/',$issueTo);
	$chkdate = $_GET["chkdate"];
	$issuedatefrom =$_GET["issuedatefrom"];	
	$DateFromArray=explode('/',$issuedatefrom);
	$formatedfromDate=$DateFromArray[2]."-".$DateFromArray[1]."-".$DateFromArray[0];
	$issuedateto=$_GET["issuedateto"];
	$DateToArray=explode('/',$issuedateto);
	$formatedToDate=$DateToArray[2]."-".$DateToArray[1]."-".$DateToArray[0];
	$ReportSatus = $_GET["ReportSatus"];
	
	$ResponseXML .= "<GetLoadSavedDetails>";
	
	$SQL ="SELECT concat(intRetYear,'/',intReturnId) as intIssueNo , genreturnheader.dtmRetDate, genreturnheader.intStatus, department.strDepartment 
			FROM  genreturnheader join department on genreturnheader.intReturnedBy=department.intDepID 
			WHERE genreturnheader.intStatus ='$ReportSatus' AND genreturnheader.intCompanyID='$companyId' ";	
	if ($issueYearFrom!="")
	{
			$SQL .="AND intReturnId >='" . $ArrayissueNo[1] . "' AND intRetYear = '" . $ArrayissueNo[0] . "' "; 
	}
	if ($issueYearTo!="")
	{
			$SQL .="AND intReturnId <='" . $ArrayissuetoNo[1] . "' AND intRetYear = '" . $ArrayissuetoNo[0] . "' ";
	}
		if ($chkdate=="true")
		{
			if ($issueDateFrom!="")
			{
					$SQL .="AND dtmRetDate >= '" . $formatedfromDate . "' ";
			}
			if ($issueDateTo!="")
			{
					$SQL .="AND dtmRetDate <= '" . $formatedToDate . "' ";
			}
		}
	 
	$result = $db->RunQuery($SQL);

	while ($row = mysql_fetch_array($result))	
	{
		$ResponseXML .= "<IssueNo><![CDATA[" . $row["intIssueNo"]  . "]]></IssueNo>\n";
		$ResponseXML .= "<IssuedDate><![CDATA[" . $row["dtmRetDate"]  . "]]></IssuedDate>\n";
		$ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n";
		$ResponseXML .= "<department><![CDATA[" . $row["strDepartment"]  . "]]></department>\n";
	}
	$ResponseXML .= "</GetLoadSavedDetails>";
		echo $ResponseXML;
}

else if($RequestType=="LoadNo")
{		
	
	$ResponseXML .="<LoadIssueno>";
	
		 //--------------------hem----------------------------------- 
			 $NoYear = date('Y');
		    $SQL="SELECT dblGReturnToStores FROM syscontrol WHERE intCompanyID='$companyId'";
			$result =  $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$retSupNo =  $row["dblGReturnToStores"];
				$SQL = "UPDATE syscontrol set dblGReturnToStores=dblGReturnToStores+1 where intCompanyID='$companyId'";
				$result = $db->RunQuery($SQL);
				break;
			}
				$ResponseXML .= "<issueNo><![CDATA[".$retSupNo."]]></issueNo>\n";
				$ResponseXML .= "<Year><![CDATA[".$NoYear."]]></Year>\n";
		//--------------------------------------------------------------		 
			
	//----------------------------	
	$ResponseXML .="</LoadIssueno>";
	echo $ResponseXML;
}
else if ($RequestType=="SaveIssueHeader")
{
	$issueNo =$_GET["issueNo"];
	$issueYear =$_GET["issueYear"];
	$productionId =$_GET["productionId"];	
	
	$sql_delete = "delete from genreturndetail 
					where
					intReturnId = '$issueNo' 
					and intRetYear = '$issueYear' ";
	$db->executeQuery($sql_delete);
	
	$booCheck = CheckAvailableHeader($issueNo,$issueYear);
	if($booCheck)
	{
	
 		$SQL= " INSERT INTO genreturnheader (intReturnId,intRetYear,dtmRetDate,intReturnedBy,intStatus,intUserid,intCompanyId)  ". 
				" VALUES ($issueNo,$issueYear,now(),'$productionId',0,'" . $_SESSION["UserID"] . "',$companyId) ";	
		$db->executeQuery($SQL);
	}
	else
	{
		$sql_update = "update genreturnheader 
						set 
						intReturnedBy = '$productionId' , 
						dtmRetDate = now() , 
						intStatus = '0' , 
						intCompanyId = '$companyId' , 
						intUserId = '$userId' , 
						where
						intReturnId = '$issueNo' and intRetYear = '$issueYear'";
		$db->executeQuery($sql_update);
	}
}
else if ($RequestType=="SaveIssueDetails")
{
	$issueNo =$_GET["issueNo"];
	$issueYear =$_GET["issueYear"];
	$issueno =$_GET["issueno"];
	$issuenoArray=explode('/',$issueno);
	$itemdDetailID =$_GET["itemdDetailID"];
	$qty = $_GET["qty"];
	$issqty = $_GET["issqty"];
	$itmUnit = $_GET["itmUnit"];
	$grnNo =$_GET["grnNo"]; 
	$grnNoArray=explode('/',$grnNo);	
	/*$costCenterId =$_GET["costCenterId"]; 
	$GLAllowId =$_GET["GLAllowId"]; */
	
	 $SQL= " INSERT INTO genreturndetail (intReturnId,intRetYear,intGRNNo,intGRNYear,intIssueNo,intIssYear,intMatDetailID,dblQty,dblBalQty,strUnit,intCostCenterId,intGLAllowId) VALUES ('$issueNo','$issueYear','$grnNoArray[1]','$grnNoArray[0]','$issuenoArray[1]','$issuenoArray[0]','$itemdDetailID','$qty','$qty','$itmUnit','0','0'); ";	
		$db->executeQuery($SQL);	
		  
	$returnQty = GetReturnQty($issueNo,$issueYear,$issuenoArray[1],$issuenoArray[0],$itemdDetailID,$grnNoArray[1],$grnNoArray[0],$costCenterId,$GLAllowId);
		  $SQL =" update genissuesdetails 
					set
					dblBalanceQty = dblBalanceQty - '$returnQty'
					where intIssueNo = '$issuenoArray[1]' 
					and intIssueYear = '$issuenoArray[0]' 
					and intGrnNo = '$grnNoArray[1]' 
					and intGrnYear = '$grnNoArray[0]' 
					and intMatDetailID = '$itemdDetailID' 
					and intCostCenterId = '$costCenterId'
					and intGLAllowId = '$GLAllowId' ;";
		  $db->executeQuery($SQL);

		  /*$SQL =" UPDATE genmatitemlist SET dblStock = dblStock + $qty WHERE intItemSerial=$itemdDetailID ";
		  $db->executeQuery($SQL);	 */ 
		  
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
	
	$ResponseXML .="<ResponseValidate>";
	$SQL="SELECT COUNT(intReturnId) AS headerRecCount FROM genreturnheader where intReturnId='$issueNo' AND intRetYear='$Year'";

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
	$SQL="SELECT COUNT(intReturnId) AS issuesdetails FROM genreturndetail where intReturnId='$issueNo' AND intRetYear='$Year'";

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
	$SQL="SELECT DISTINCT IH.intReturnId ".
		 "FROM genreturnheader AS IH ".
		 "INNER JOIN genreturndetail AS ID ".
		 "ON IH.intReturnId=ID.intReturnId AND IH.intRetYear=ID.intRetYear ".
		 "WHERE IH.intStatus='$state' AND IH.intRetYear='$year'";
	
	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
	$ResponseXML .= "<IssueNo><![CDATA[" . $row["intIssueNo"]. "]]></IssueNo>\n";
	}
	$ResponseXML.="</LoadPopUpIssueNo>";
	echo $ResponseXML;
}
if($RequestType=="confirmRetun")
{
	
	$returnNo 		= $_GET["returnNo"];
	$returnNoArray  = explode('/',$returnNo);
	$itemdDetailID 	= $_GET["itemdDetailID"];
	$qty 			= $_GET["qty"];
	$itmUnit 		= $_GET["itmUnit"];
	$grnNo 			= $_GET["grnNo"];
	$grnNoArray	 	= explode('/',$grnNo);
	/*$costCenterId 	= $_GET["costCenterId"];
	$GLAllowId 		= $_GET["GLAllowId"];*/
	
	$ResponseXML.="<confirmReturn>";
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
					('". $returnNoArray[0] ."', 
					'$companyId',
					'". $returnNoArray[1] ."', 
					'". $returnNoArray[0] ."', 
					'". $itemdDetailID ."', 
					'RSTO', 
					'". $itmUnit ."', 
					'". $qty ."', 
					now(), 
					'".  $_SESSION["UserID"] ."',
					'".$grnNoArray[1]."',
					'".$grnNoArray[0]."',
					'0',
					'0'
					);";
			$result=$db->RunQuery($SQL);
	if($result)
	{
		$sql_status = "update genreturnheader 
					set
					intStatus = '1' , 
					intConfirmedBy = '$userId' , 
					dtmConfirmedDate = now()
					where
					intReturnId = '$returnNoArray[1]' and intRetYear = '$returnNoArray[0]'";
		$result_status = $db->RunQuery($sql_status);
		if($result_status)
		{
			$ResponseXML .= "<responceConfirm><![CDATA[TRUE]]></responceConfirm>\n";
		}
		else
		{
			$ResponseXML .= "<responceConfirm><![CDATA[FALSE]]></responceConfirm>\n";
		}
	}
	else
	{
		$ResponseXML .= "<responceConfirm><![CDATA[FALSE]]></responceConfirm>\n";	
	}
	$ResponseXML.="</confirmReturn>";
	echo $ResponseXML;
}
if($RequestType=="loadGenReturnHeaderDetails")
{	
	$ResponseXML = "<XMLGenReturnHeaderDetails>";
	
	$status		= $_GET["status"];
	$GPyear		= $_GET["GPyear"];
	$GPNo		= $_GET["GPNo"];
	
	$result = getGenReturnHeaderData($GPNo,$GPyear,$status);
	while($row = mysql_fetch_array($result))
	{
		$RetDate 		 = $row["RetDate"];
		$RetDateArray	 = explode('-',$RetDate);
		$formatedRetDate = $RetDateArray[2]."/".$RetDateArray[1]."/".$RetDateArray[0];
		
		 $ResponseXML .= "<ReturnedBy><![CDATA[" . $row["intReturnedBy"]  . "]]></ReturnedBy>\n"; 
		 $ResponseXML .= "<ReturneDate><![CDATA[" . $formatedRetDate  . "]]></ReturneDate>\n"; 
	}
	$ResponseXML .="</XMLGenReturnHeaderDetails>";
	echo $ResponseXML;
}
if($RequestType=="loadGenReturnDetailsData")
{
	$ResponseXML = "<XMLGenReturnDetailsData>";
	
	$GPyear		= $_GET["GPyear"];
	$GPNo		= $_GET["GPNo"];
	$status		= $_GET["status"];
	
	$result = getGenReturnDetailsData($GPNo,$GPyear);
	while($row = mysql_fetch_array($result))
	{
		$GLAllowId    = $row["intGLAllowId"];
		$GLCode       = $objgl-> getGLCode($GLAllowId);
		$ResponseXML .= "<GLCode><![CDATA[" . $GLCode  . "]]></GLCode>\n";
		$ResponseXML .= "<GLAllowId><![CDATA[" . $GLAllowId  . "]]></GLAllowId>\n";
		$ResponseXML .= "<MatDetailID><![CDATA[" . $row["intMatDetailID"]  . "]]></MatDetailID>\n"; 
		$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDescription>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n"; 
		$ResponseXML .= "<RetQty><![CDATA[" . $row["dblQty"]  . "]]></RetQty>\n"; 
		$ResponseXML .= "<IssueQty><![CDATA[" . $row["dblBalanceQty"]  . "]]></IssueQty>\n";
		$ResponseXML .= "<grnNo><![CDATA[" . $row["intGRNNo"]  . "]]></grnNo>\n";
		$ResponseXML .= "<grnYear><![CDATA[" . $row["intGRNYear"]  . "]]></grnYear>\n";
		$ResponseXML .= "<IssueNo><![CDATA[" . $row["intIssueNo"]  . "]]></IssueNo>\n";
		$ResponseXML .= "<IssYear><![CDATA[" . $row["intIssYear"]  . "]]></IssYear>\n";
		/*$ResponseXML .= "<CostCenterId><![CDATA[" . $row["intCostCenterId"]  . "]]></CostCenterId>\n"; 
		$ResponseXML .= "<CostCenterDes><![CDATA[" . $row["strDescription"]  . "]]></CostCenterDes>\n";*/
	}
	$ResponseXML .="</XMLGenReturnDetailsData>";
	echo $ResponseXML;
}
function getGenReturnHeaderData($GPNo,$GPyear,$status)
{
	global $db;
	$sql = " select intReturnedBy,date(dtmRetDate) as RetDate from genreturnheader where intReturnId = '$GPNo' and intRetYear = '$GPyear' and intStatus = '$status'";
	return $db->RunQuery($sql);	
}
function getGenReturnDetailsData($GPNo,$GPyear)
{
	global $db;
	$sql = "select 	GRD.intReturnId, 
			GRD.intRetYear, 
			GRD.intGRNNo, 
			GRD.intGRNYear, 
			GRD.intIssueNo, 
			GRD.intIssYear, 
			GRD.intMatDetailID, 
			GRD.dblQty, 
			GRD.dblBalQty, 
			GRD.strUnit, 
			GRD.intCostCenterId,
			gmil.strItemDescription,
			GID.dblBalanceQty
			from 
			genreturndetail GRD
			inner join genmatitemlist gmil on GRD.intMatDetailID = gmil.intItemSerial
			inner join genissuesdetails GID on GID.intIssueNo=GRD.intIssueNo and GID.intIssueYear=GRD.intIssYear 
			and GID.intGrnNo=GRD.intGRNNo and GID.intGrnYear=GRD.intGRNYear
			where intReturnId='$GPNo' and intRetYear='$GPyear'";
	
	return $db->RunQuery($sql);	
}
function GetReturnQty($returnNo,$returnYear,$issueNo,$issueYear,$itemDetailID,$grnNo,$grnYear,$costCenterId,$GLAllowId)
{
	global $db;
	$qty = 0;
	$sql="select COALESCE(sum(GRD.dblQty),0)as dblReturnQty  from genreturndetail GRD 
			inner join genreturnheader GRH on GRH.intReturnId=GRD.intReturnId and GRH.intRetYear=GRD.intRetYear 
			where GRD.intIssueNo = '$issueNo' 
			and GRD.intIssYear = '$issueYear' 
			and GRD.intReturnId = '$returnNo' 
			and GRD.intRetYear = '$returnYear' 
			and GRD.intMatDetailID = '$itemDetailID' 
			and GRD.intGRNNo = '$grnNo' 
			and GRD.intGRNYear = '$grnYear' 
			and GRD.intCostCenterId = '$costCenterId'
			and GRD.intGLAllowId = '$GLAllowId'
			and GRH.intStatus <>10";
		
	$result=$db->RunQuery($sql);
	echo $sql;
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["dblReturnQty"];
	}
	return $qty;
}
function CheckAvailableHeader($no,$year)
{
	global $db;
	$sql = "select count(intReturnId)as count from genreturnheader where intReturnId='$no' and intRetYear='$year'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	if($row["count"]=='0')
		return true;
	else
		return false;
}

?>