<?php
session_start();
	include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

//$productionId = "";

if($RequestType=="LoadMaterial")
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

	$SQL ="SELECT concat(GSH.intYear,'/',GSH.intGatepassId) as intIssueNo , GSH.dtmDate ,GSH.intStatus, GSH.intToStores AS strName 
FROM  nomgatepassheader GSH 
WHERE GSH.intStatus = 1 AND GSH.intCompanyID='$companyId'";
	//echo $SQL;
	if ($issueYearFrom!="")
	{
			$SQL .="AND intGatepassId >='" . $issueNoFrom . "' AND intYear = '" . $issueYearFrom . "' "; 
	}
	if ($issueYearTo!="")
	{
			$SQL .="AND intGatepassId <='" . $issueNoTo . "' AND intYear = '" . $issueYearTo . "' ";
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
else if($RequestType=="LoadIssueno")
{		
	$No=0;
	$ResponseXML = "<NormalGatePassNo>\n";
	
	$Sql="select intCompanyID,dblNormalGatepassNo,dblSequenceStart,dblSequenceEnd from syscontrol where intCompanyID='$companyId'";
	
	$result =$db->RunQuery($Sql);		
	$rowcount = mysql_num_rows($result);
	
	if ($rowcount > 0)
	{	
			while($row = mysql_fetch_array($result))
			{				
				$No				= $row["dblNormalGatepassNo"];
				$sequenceStart	= $row["dblSequenceStart"];
				$sequenceEnd	= $row["dblSequenceEnd"];
				$nextNo			= $No+1;
				$year 			= date('Y');
			}
			if($No>=(int)$sequenceStart && $No<(int)$sequenceEnd)
			{
				$sqlUpdate="UPDATE syscontrol SET dblNormalGatepassNo='$nextNo' WHERE intCompanyID='$companyId';";
				$db->executeQuery($sqlUpdate);			
				$ResponseXML .= "<Admin><![CDATA[TRUE]]></Admin>\n";		
				$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
				$ResponseXML .= "<Year><![CDATA[".$year."]]></Year>\n";
			}
			else
			{
				$ResponseXML .= "<Admin><![CDATA[FALSE]]></Admin>\n";
				$ResponseXML .= "<Message><![CDATA[Incorrect Normal GatePass Sequence No\nPlease contact system administrator]]></Message>\n";
			}
			
	}
	else
	{
		$ResponseXML .= "<Admin><![CDATA[FALSE]]></Admin>\n";
		$ResponseXML .= "<Message><![CDATA[No Normal GatePass No assign to your company\nPlease contact system administrator]]></Message>\n";
	}	
$ResponseXML .="</NormalGatePassNo>";
echo $ResponseXML;

}
else if ($RequestType=="SaveHeader")
{
	$no 			= $_GET["No"];
	$year 			= $_GET["Year"];
	$gatePassTo 	= $_GET["GatePassTo"];	
	$instructBy 	= $_GET["InstructBy"];
	$attentionBy 	=  $_GET["AttentionBy"];
	$through 		=  $_GET["Through"];
	$instructions 	=  $_GET["specialInstructions"];
	$remarks 		=  $_GET["remarks"];
	$styleNo 		=  $_GET["styleNo"];
	$noOfPackages 	=  $_GET["NoOfPackages"];
	
	$sql_delete = "delete from nomgatepassdetail 
					where
					intGatepassId = '$no' and intYear = '$year';";
	$db->executeQuery($sql_delete);
		
	$booCheck = CheckAvailableHeader($no,$year);
	if($booCheck)
	{
		$sql = "insert into nomgatepassheader (intGatepassId,intYear,intToStores,strAttention,strThrough,intInstructedBy,dtmDate,intStatus,intCompanyId,intUserId,strInstructions,strRemarks,strStyleID,intCreatedBy,intCreatedDate,strNoOfPackages)values('". $no ."','". $year ."','". $gatePassTo ."','". $attentionBy ."','". $through ."','". $instructBy ."',now(),0,$companyId,'$userId','$instructions','$remarks','$styleNo','$userId',now(),'$noOfPackages');";			 				
		$db->executeQuery($sql);
	}
	else
	{
		$sql = "update nomgatepassheader 
				set
				intToStores = '$gatePassTo' , 
				strAttention = '$attentionBy' , 
				strThrough = '$through' , 
				intInstructedBy = '$instructBy' , 
				dtmDate = now(), 
				intStatus = '0' , 
				intCompanyId = '$companyId' , 
				intUserId = '$userId' , 
				strInstructions = '$instructions' , 
				strRemarks = '$remarks' , 
				strStyleID = '$styleNo',
				strNoOfPackages='$noOfPackages' 
				where
				intGatepassId = '$no' and intYear = '$year' ;";
		$db->executeQuery($sql);
	}
}
else if ($RequestType=="SaveDetails")
{
	$no 			= $_GET["No"];
	$year 			= $_GET["Year"];
	$itemdDetailID 	= $_GET["itemdDetailID"];
	$qty 			= $_GET["qty"];
	$Unit 			= $_GET["Unit"];	
	$returnable 	= $_GET["returnable"];
	
	
		$SQL = " insert into nomgatepassdetail (intGatepassId,intYear,intMatDetailID,dblQty,intUnitId,intReturnable)values ($no,$year,'". $itemdDetailID ."',$qty,$Unit,$returnable);";	 
		$db->executeQuery($SQL);
					
}
else if ($RequestType=="ResponseValidate")
{
	$issueNo 		= $_GET["issueNo"];
	$Year 			= $_GET["Year"];
	$validateCount 	= $_GET["validateCount"];
	
	$ResponseXML .="<ResponseValidate>";
	$SQL="SELECT COUNT(intGatepassId) AS headerRecCount FROM nomgatepassheader where intGatepassId=$issueNo AND intYear=$Year";

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
	$SQL="SELECT COUNT(intGatepassId) AS issuesdetails FROM nomgatepassdetail where intGatepassId=$issueNo AND intYear=$Year";

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
	$SQL="SELECT DISTINCT IH.intGatepassId,IH.intYear  ".
		 "FROM nomgatepassheader AS IH ".
		 "INNER JOIN nomgatepassdetail AS ID ".
		 "ON IH.intGatepassId=ID.intGatepassId AND IH.intYear=ID.intYear ".
		 "WHERE IH.intStatus='$state'";
//echo $SQL;
	
	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		//$ResponseXML .= "<IssueNo><![CDATA[" . $row["intIssueNo"]. "]]></IssueNo>\n";
		$ResponseXML .= "<IssueNo><![CDATA[" . $row["intGatepassId"]. "]]></IssueNo>\n";
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

$sql="SELECT concat(GH.intYear,'/',GH.intGatepassId)AS gatePassNo,GH.strRemarks,GH.strAttention,GH.strThrough,GH.intToStores,GH.intInstructedBy,GH.strStyleID,GH.strInstructions,GH.intStatus,GH.strNoOfPackages FROM nomgatepassheader GH WHERE GH.intGatepassId = '$no' AND GH.intYear = '$year'";

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
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]. "]]></Status>\n";
		$ResponseXML .= "<NoOfPackages><![CDATA[" . $row["strNoOfPackages"]. "]]></NoOfPackages>\n";
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

$sql="SELECT GD.intMatDetailID,GD.dblQty,GD.intUnitId,GD.intReturnable 
FROM nomgatepassdetail GD
WHERE GD.intGatepassId = '$no'
AND GD.intYear = '$year'";

	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{		
		$ResponseXML .= "<Description><![CDATA[" . $row["intMatDetailID"]. "]]></Description>\n";
		$ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]. "]]></Qty>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["intUnitId"]. "]]></Unit>\n";
		$ResponseXML .= "<Returnable><![CDATA[" . $row["intReturnable"]. "]]></Returnable>\n";
	}

$ResponseXML .= "</LoadGatePassDetails>";
echo $ResponseXML;
}
elseif($RequestType=="URLConfirmNormalGatePass")
{
$no			= $_GET["No"];
$noArray	= explode('/',$no);

$ResponseXML = "<XMLConfirmNormalGatePass>";

$sql="update nomgatepassheader set intStatus=1,intConfirmBy='$userId',dtmConfirmDate=now() where intGatepassId='$noArray[1]' and intYear='$noArray[0]'";
$result=$db->RunQuery($sql);
if($result){
	$ResponseXML .= "<Valid><![CDATA[TRUE]]></Valid>\n";
	$ResponseXML .= "<Message><![CDATA[Confirmed successfully.]]></Message>\n";
}else{
	$ResponseXML .= "<Valid><![CDATA[False]]></Valid>\n";
	$ResponseXML .= "<Message><![CDATA[Error appear while current process is runing.]]></Message>\n";
}

$ResponseXML .= "</XMLConfirmNormalGatePass>";
echo $ResponseXML;
}
elseif($RequestType=="URLCancelNormalGatePass")
{
$no			= $_GET["No"];
$noArray	= explode('/',$no);

$ResponseXML = "<XMLCancelNormalGatePass>";

$sql="update nomgatepassheader set intStatus=10,intCanceledBy='$userId',dtmCanceledDate=now() where intGatepassId='$noArray[1]' and intYear='$noArray[0]'";
$result=$db->RunQuery($sql);
if($result){
	$ResponseXML .= "<Valid><![CDATA[TRUE]]></Valid>\n";
	$ResponseXML .= "<Message><![CDATA[Canceled successfully.]]></Message>\n";
}else{
	$ResponseXML .= "<Valid><![CDATA[False]]></Valid>\n";
	$ResponseXML .= "<Message><![CDATA[Error appear while current process is runing.]]></Message>\n";
}

$ResponseXML .= "</XMLCancelNormalGatePass>";
echo $ResponseXML;
}

function CheckAvailableHeader($no,$year)
{
	global $db;
	$sql = "select count(intGatepassId)as count from nomgatepassheader where intGatepassId='$no' and intYear='$year'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	if($row["count"]=='0')
		return true;
	else
		return false;
}
?>