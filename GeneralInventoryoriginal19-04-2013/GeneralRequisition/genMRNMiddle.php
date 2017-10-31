<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$userID			= $_SESSION["UserID"];
$companyId  	= $_SESSION["FactoryID"];
$RequestType 	= $_GET["RequestType"];

//----------------General MRN Status------------------------------
// 0 - Saved
// 1 - Confirmed
//----------------------------------------------------------------
if (strcmp($RequestType,"getMatInfo") == 0)
{
 	global $db;
	$ResponseXML = "";
	//$stockQty=0;
	$mainCatID	  = $_GET["mainCatID"];
	$subCatID	  = $_GET["subCatID"];
	$chkAllItem   = $_GET["chkAllItem"];
	$costCenterId = $_GET["costCenterId"];
	$ResponseXML .= "<MatInfo>\n";
	
	 $sql="SELECT genmatitemlist.strItemDescription, genmatitemlist.intItemSerial FROM genmatitemlist
	 		WHERE genmatitemlist.intMainCatID = '$mainCatID'";
	 if($subCatID!="")
	 	$sql .= " AND genmatitemlist.intSubCatID = '$subCatID' ";
	 
	 $result=$db->RunQuery($sql);	
	 while($row = mysql_fetch_array($result))
  	 {
		 $MatID=$row["intItemSerial"];
		 $description=$row["strItemDescription"];

		$mrnQty		= GetMrnQty($MatID,$companyId);
		$issueQty	= GetIssueQty($MatID,$companyId);
		
	
	//------------------------------lahiru  04/05/2011 --------------------------------------
		$sql_stock="SELECT COALESCE(Sum(genstocktransactions.dblQty),0) AS dblStock,intGRNNo,intGRNYear,
					concat(GL.strAccID,'-',C.strCode) as GLCode,genstocktransactions.intGLAllowId
				    FROM genstocktransactions 
					inner join glallowcation GLA on GLA.GLAccAllowNo=genstocktransactions.intGLAllowId
					inner join glaccounts GL on GL.intGLAccID=GLA.GLAccNo
					inner join costcenters C on GLA.FactoryCode=C.intCostCenterId
				    WHERE genstocktransactions.strMainStoresID = '". $companyId ."' 
				    AND genstocktransactions.intMatDetailId =  '". $MatID ."'
					AND genstocktransactions.intCostCenterId =  '". $costCenterId ."'
				    group by strMainStoresID,intMatDetailId,intGRNYear,intGRNNo,genstocktransactions.intGLAllowId ;"; 			
		$result_stock=$db->RunQuery($sql_stock);
		while($row_stock = mysql_fetch_array($result_stock))
		{
		
			$stockQty = $row_stock["dblStock"];
			$balQty		= ($stockQty+$issueQty)-$mrnQty;
			
			if($chkAllItem == 'false' && $stockQty<=0 )
			continue;
			 
			 $ResponseXML .= "<Item><![CDATA[" .$description. "]]></Item>\n";		
			 $ResponseXML .= "<MatDetailID><![CDATA[" . $MatID . "]]></MatDetailID>\n";
			 $ResponseXML .= "<BalQty><![CDATA[" .round($balQty,2). "]]></BalQty>\n";
			 $ResponseXML .= "<MRNRaised><![CDATA[" .round($mrnQty,2). "]]></MRNRaised>\n";
			 $ResponseXML .= "<Issued><![CDATA[" .round($issueQty,2). "]]></Issued>\n";
			 $ResponseXML .= "<stockBalance><![CDATA[" .round($stockQty,2). "]]></stockBalance>\n";
			 $ResponseXML .= "<intGRNNo><![CDATA[" .$row_stock["intGRNNo"]. "]]></intGRNNo>\n";
			 $ResponseXML .= "<intGRNYear><![CDATA[" .$row_stock["intGRNYear"]. "]]></intGRNYear>\n";
			 $ResponseXML .= "<GLCode><![CDATA[" .$row_stock["GLCode"]. "]]></GLCode>\n";
			 $ResponseXML .= "<GLAllowId><![CDATA[" .$row_stock["intGLAllowId"]. "]]></GLAllowId>\n";
		 
		 }
		 
	 }
	 $ResponseXML .= "</MatInfo>";
	 echo $ResponseXML;
	
}
else if(strcmp($RequestType,"LoadNo") == 0)
{
	$intMaxNo=0;
	$ResponseXML .="<LoadGenMRNno>";
	$NoYear = date('Y');	
		 //--------------------hem----------------------------------- 
		    $SQL="SELECT dblGMRNNo FROM syscontrol WHERE intCompanyID='$companyId'";
			$result =  $db->RunQuery($SQL);
			$rowcount = mysql_num_rows($result);
			if($rowcount>0)
			{
				while($row = mysql_fetch_array($result))
				{
					$intGenMRNNo =  $row["dblGMRNNo"];
					$SQL = "UPDATE syscontrol set dblGMRNNo=dblGMRNNo+1 where intCompanyID='$companyId'";
					$result = $db->RunQuery($SQL);
					
					$ResponseXML .= "<Validate><![CDATA[TRUE]]></Validate>\n";
					$ResponseXML .= "<No><![CDATA[".$intGenMRNNo."]]></No>\n";
					$ResponseXML .= "<Year><![CDATA[".$NoYear."]]></Year>\n";
				}
			}
			else
			{
				$ResponseXML .= "<Validate><![CDATA[FALSE]]></Validate>\n";
			}
					
	$ResponseXML .="</LoadGenMRNno>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"SaveHeader") == 0)
{
	$genMRNno			= $_GET["genMRNno"];
	$genMRNyear			= $_GET["genMRNyear"]; 
	$departementCode	= $_GET["departementCode"];
	$costCenterId		= $_GET["costCenterId"];

	deleteMRNDetails($genMRNno,$genMRNyear);
	$result = saveMrnHeader($genMRNno,$genMRNyear,$departementCode,$userID,0,$userID,$companyId,$costCenterId);
}
else if(strcmp($RequestType,"SaveMRNDetails") == 0)
{
$mrnNo			= $_GET["genMRNno"];
$mrnYear		= $_GET["genMRNyear"];
$qty			= $_GET["balQty"];
$balQty			= $_GET["balQty"];
$notes			= $_GET["notes"];
$assetNo		= $_GET["assetNo"];
$MatID			= $_GET["MatID"];
$GRNNo			= $_GET["GRNNo"];
$GRNYear		= $_GET["GRNYear"];
$GLAllowId		= $_GET["GLAllowId"];

	$res = saveMrnDetails($mrnNo,$mrnYear,$MatID,$qty,$balQty,$notes,$assetNo,$GRNNo,$GRNYear,$GLAllowId);
	

}
else if(strcmp($RequestType,"UpdateStatus") == 0)
{
$genMRNno			= $_GET["genMRNno"];
$genMRNyear			= $_GET["genMRNyear"]; 
$ResponseXML .="<XMLMRNresponse>";
	$res = updateMRNheaderStatus($genMRNno,$genMRNyear);
	
$ResponseXML .= "<confirmResponse><![CDATA[".$res."]]></confirmResponse>\n";
$ResponseXML .="</XMLMRNresponse>";
	echo $ResponseXML;	
}

else if(strcmp($RequestType,"getAck") == 0)
{
	$mrnNo			= $_GET["mrnNo"];
	$mrnArray		= explode('/',$mrnNo);
	$count			= $_GET["count"];
	$ResponseXML	= "";
	$ResponseXML    .="<Acknowledgement>";
	global $db;
	
	$sql="SELECT COUNT(intMatRequisitionNo)AS ackCount FROM genmatrequisition where intMatRequisitionNo='$mrnArray[1]' and intMRNYear='$mrnArray[0]';";
	
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$mrnCount=$row["ackCount"];	
			if($mrnCount>0)
			{
				$ResponseXML .= "<mrnHeader><![CDATA[TRUE]]></mrnHeader>\n";
			}
			else
			{
				$ResponseXML .= "<mrnHeader><![CDATA[FALSE]]></mrnHeader>\n";	
			}
	}
	
	$sql="SELECT COUNT(intMatRequisitionNo) AS MrnDetailCount FROM genmatrequisitiondetails m where intmatRequisitionNo='$mrnArray[1]' and intYear='$mrnArray[0]';";
	$result=$db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
		$mrnDetailCount=$row["MrnDetailCount"];	
			if($mrnDetailCount==$count)
			{
			$ResponseXML .= "<mrnDetail><![CDATA[TRUE]]></mrnDetail>\n";
			}
			else
			{
			$ResponseXML .= "<mrnDetail><![CDATA[FALSE]]></mrnDetail>\n";
			}
	}	
	$ResponseXML.="</Acknowledgement>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"getMrnAccYear") == 0)
{

$year=$_GET["year"];
$ResponseXML="";
$ResponseXML.="<MrnNOMain>";
global $db;
$sql="SELECT intmatRequisitionNo FROM genmatrequisition m where intMRNYear='$year';";
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$mrnNo=$row["intmatRequisitionNo"];
$ResponseXML .= "<MrnNo><![CDATA[".$mrnNo."]]></MrnNo>\n";
}
$ResponseXML.="</MrnNOMain>";
echo $ResponseXML;
}

function getStockqty($matDetaiID,$compId)
{
global $db;
$stockQty=0;

$sql="SELECT COALESCE(Sum(genstocktransactions.dblQty),0) AS dblStock
	  FROM genstocktransactions 
	  WHERE genstocktransactions.strMainStoresID =  '". $compId ."' 
	  AND genstocktransactions.intMatDetailId =  '". $matDetaiID ."' ";	
	  
	
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
	$stockQty=$row["dblStock"];

	if($stockQty=="" || $stockQty==NULL)
	{
		$stockQty=-100;
	}

}

return $stockQty;

}

function saveMrnHeader($mrnNo,$mrnYear,$departmentCode,$requestBy,$status,$userID,$companyID,$costCenterId)
{
	global $db;
	$sql="INSERT INTO 
	genmatrequisition(intMatRequisitionNo,intMRNYear,dtmDate,strDepartmentCode,intRequestedBy,intStatus,intUserId,intCompanyID,intCostCenterId)
	VALUES('$mrnNo','$mrnYear',NOW(),'$departmentCode','$requestBy','$status','$userID','$companyID','$costCenterId');";	
	return $db->RunQuery($sql);
}

function saveMrnDetails($mrnNo,$year,$matDetailID,$qty,$balQty,$notes,$assetNo,$GRNNo,$GRNYear,$GLAllowId)
{
	global $db;
	$sql="INSERT INTO genmatrequisitiondetails(intMatRequisitionNo,intYear,strMatDetailID,dblQty,dblBalQty,strNotes,intGRNNo,intGRNYear,strAssetNo,intGLAllowId) VALUES('$mrnNo','$year','$matDetailID','$qty','$balQty','$notes','$GRNNo','$GRNYear','$assetNo','$GLAllowId');";	
	return $db->RunQuery($sql);
}


function GetMrnQty($MatID,$companyId)
{
global $db;
$sql="";
$sql="select COALESCE(sum(dblQty),0)AS mrnQty from
genmatrequisition GMRH 
Inner Join genmatrequisitiondetails GMRD ON GMRH.intMatRequisitionNo=GMRD.intMatRequisitionNo AND GMRH.intMRNYear=GMRD.intYear
where strMatDetailID='$MatID' 
AND GMRH.intCompanyID='$companyId'";

$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		return  $row["mrnQty"];
	}

}

function GetIssueQty($MatID,$companyId)
{
global $db;
$sql="";
$sql="select COALESCE(sum(dblQty),0)AS issueQty from
genissues IH 
Inner Join genissuesdetails ID ON IH.intIssueNo=ID.intIssueNo AND IH.intIssueYear=ID.intIssueYear
where ID.intMatDetailID='$MatID' 
AND IH.intCompanyID='$companyId'";
$result=$db->RunQuery($sql);
		
	while($row=mysql_fetch_array($result))
	{
		return $row["issueQty"];
	}
		 
}


if($RequestType=="loadMainCategory")
{	
		$ResponseXML .= "<genmatmaincategory>\n";
		$SQL="SELECT intID,strDescription FROM genmatmaincategory ORDER BY strDescription";
				
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{
			 $ResponseXML .= "<intID><![CDATA[" . $row["intID"]  . "]]></intID>\n";
			 $ResponseXML .= "<strDescription><![CDATA[" . $row["strDescription"]  . "]]></strDescription>\n";  
		}
		$ResponseXML .= "</genmatmaincategory>";
		echo $ResponseXML;
}

if($RequestType=="loadSubCategory")
{	
$intMainCatId = $_GET["mainCatId"];
$ResponseXML .= "<genmatsubcategory>";

	$SQL="SELECT intSubCatNo,StrCatName FROM genmatsubcategory WHERE intCatNo =$intMainCatId   ORDER BY StrCatName";

	$result = $db->RunQuery($SQL);
	$str = "<option value =\"".""."\">".""."</option>";
	while($row = mysql_fetch_array($result))
	{
		$str .= "<option value=\"".$row["intSubCatNo"]."\">".$row["StrCatName"]."</option>";
	}
$ResponseXML .= "<genSubCat><![CDATA[" . $str  . "]]></genSubCat>\n";
$ResponseXML .= "</genmatsubcategory>";
echo $ResponseXML;
}

if($RequestType=="loadMRNList")
{
		$fromDate		= $_GET["fromDate"];
		$toDate			= $_GET["toDate"];
		$intMrnNo		= $_GET["mrnNo"];
		$strCompanyID	= $_GET["strCompanyID"];
		 
		$ResponseXML .= "<GenMRN>";
		$SQL = "  	SELECT genmatrequisition.intMatRequisitionNo, genmatrequisition.intMRNYear, department.strDepartment,
					companies.strName FROM genmatrequisition 
					Inner Join department ON genmatrequisition.strDepartmentCode = department.strDepartmentCode
					Inner Join companies ON genmatrequisition.intCompanyID = companies.intCompanyID
					WHERE genmatrequisition.intStatus = 1 OR genmatrequisition.intStatus = 0 ";
				
				if($fromDate!="")
				{
					$SQL.=" AND genmatrequisition.dtmDate>='$fromDate' ";
				}
				if($toDate!="")
				{
					$SQL.=" AND genmatrequisition.dtmDate<='$toDate'";
				}
				
				if($intMrnNo!="")
				{
					$SQL.=" AND genmatrequisition.intMatRequisitionNo LIKE '%$intMrnNo%' ";
				}
				if($strCompanyID!="")
				{
					$SQL.=" AND genmatrequisition.intCompanyID = '$strCompanyID' ";
				}
				
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strMrnNo><![CDATA[" . $row["intMatRequisitionNo"]  . "]]></strMrnNo>\n";
				 $ResponseXML .= "<intYear><![CDATA[" . $row["intMRNYear"]  . "]]></intYear>\n"; 
				 $ResponseXML .= "<strDepartment><![CDATA[" . $row["strDepartment"]  . "]]></strDepartment>\n";
				 
			}
			$ResponseXML .= "</GenMRN>";
			echo $ResponseXML;
}

if($RequestType=="loadMrnHeader")
{
	$strMrnNo	=$_GET["strMrnNo"];
	$intYear	=$_GET["intYear"];
	
		$ResponseXML .="<MrnHeader>";
		
		$SQL		  ="SELECT
						genmatrequisition.intMatRequisitionNo,
						genmatrequisition.intMRNYear,
						date_format(genmatrequisition.dtmDate,'%d/%m/%Y') as dtmdate,
						genmatrequisition.strDepartmentCode,
						genmatrequisition.intStatus,
						genmatrequisition.intUserId,
						useraccounts.Name,
						genmatrequisition.intCanceledBy,
						genmatrequisition.dtmCancelledDate,
						genmatrequisition.intCompanyID,
						genmatrequisition.intCostCenterId
						FROM
						genmatrequisition
						Inner Join useraccounts ON genmatrequisition.intRequestedBy = useraccounts.intUserID
						WHERE
						genmatrequisition.intMRNYear = '$intYear' AND
						genmatrequisition.intMatRequisitionNo = '$strMrnNo' ";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strMrnNo><![CDATA[" . trim($row["intMatRequisitionNo"])  . "]]></strMrnNo>\n";
				 $ResponseXML .= "<intYear><![CDATA[" . trim($row["intMRNYear"])  . "]]></intYear>\n";
				 $ResponseXML .= "<strCompanyId><![CDATA[" . trim($row["intCompanyID"])  . "]]></strCompanyId>\n";
				 $ResponseXML .= "<strDepartmentCode><![CDATA[" . trim($row["strDepartmentCode"])  . "]]></strDepartmentCode>\n";
				 $ResponseXML .= "<dtDate><![CDATA[" . trim($row["dtmdate"])  . "]]></dtDate>\n";
				 $ResponseXML .= "<strRequestedBy><![CDATA[" . trim($row["Name"])  . "]]></strRequestedBy>\n";
				 $ResponseXML .= "<costCenterId><![CDATA[" . trim($row["intCostCenterId"])  . "]]></costCenterId>\n";
				 break;
			}
			$ResponseXML .= "</MrnHeader>";
			echo $ResponseXML;
}

if($RequestType=="loadMrnDetails")
{
	$strMrnNo	=$_GET["strMrnNo"];
	$intYear	=$_GET["intYear"];
	
		$ResponseXML .="<MrnDetails>";
		
		$SQL		  ="SELECT
						genmatrequisitiondetails.strMatDetailID,
						genmatrequisitiondetails.dblQty,
						genmatrequisitiondetails.dblBalQty,
						genmatrequisitiondetails.strNotes,
						genmatrequisitiondetails.strAssetNo,
						genmatrequisitiondetails.intGRNNo,
						genmatrequisitiondetails.intGRNYear,
						genmatrequisitiondetails.intGLAllowId,
						concat(glaccounts.strAccID,'-',costcenters.strCode) as GLCode,
						genmatitemlist.strItemDescription As Description,
						genmatmaincategory.strDescription As MainCat
						FROM
						genmatrequisitiondetails
						Inner Join genmatitemlist ON genmatrequisitiondetails.strMatDetailID = genmatitemlist.intItemSerial
						Inner Join genmatmaincategory ON genmatitemlist.intMainCatID = genmatmaincategory.intID
						inner join glallowcation on glallowcation.GLAccAllowNo=genmatrequisitiondetails.intGLAllowId
						inner join glaccounts on glaccounts.intGLAccID=glallowcation.GLAccNo
						inner join costcenters on costcenters.intCostCenterId=glallowcation.FactoryCode
						WHERE
						genmatrequisitiondetails.intYear = '$intYear' AND
						genmatrequisitiondetails.intMatRequisitionNo = '$strMrnNo' ";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$MatID = $row["strMatDetailID"];
				$stockQty	= getStockqty($MatID,$companyId);
				$mrnQty		= GetMrnQty($MatID,$companyId);
				$issueQty	= GetIssueQty($MatID,$companyId);
				$balQty		= ($stockQty+$issueQty)-$mrnQty;
				 $ResponseXML .= "<strMatDetailID><![CDATA[" . trim($row["strMatDetailID"])  . "]]></strMatDetailID>\n";
				 $ResponseXML .= "<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";
				 $ResponseXML .= "<dblBalQty><![CDATA[" . trim($balQty)  . "]]></dblBalQty>\n";
				 $ResponseXML .= "<strNotes><![CDATA[" . trim($row["strNotes"])  . "]]></strNotes>\n";
				  $ResponseXML .= "<strAssetNo><![CDATA[" . $row["strAssetNo"]  . "]]></strAssetNo>\n";
				 $ResponseXML .= "<Description><![CDATA[" . trim($row["Description"])  . "]]></Description>\n";
				 $ResponseXML .= "<MainCat><![CDATA[" . trim($row["MainCat"])  . "]]></MainCat>\n";
				 $ResponseXML .= "<GRNNo><![CDATA[" . trim($row["intGRNNo"])  . "]]></GRNNo>\n";
				 $ResponseXML .= "<GRNYear><![CDATA[" . trim($row["intGRNYear"])  . "]]></GRNYear>\n";
				 $ResponseXML .= "<GLCode><![CDATA[" . trim($row["GLCode"])  . "]]></GLCode>\n";
				 $ResponseXML .= "<GLAllowId><![CDATA[" . trim($row["intGLAllowId"])  . "]]></GLAllowId>\n";
				
			}
			$ResponseXML .= "</MrnDetails>";
			echo $ResponseXML;
}
function deleteMRNDetails($genMRNno,$genMRNyear)
{
	global $db;
	
	$sql = "delete from genmatrequisitiondetails where intMatRequisitionNo = '$genMRNno' and intYear = '$genMRNyear'";
	$result = $db->RunQuery($sql);
}
function updateMRNheaderStatus($genMRNno,$genMRNyear)
{
	global $db;
	global $companyId;
	global $userID;
	$sql = "update genmatrequisition set intStatus = '1',intConfirmedBy='$userID',dtmConfirmed = now()
 where
	intMatRequisitionNo = '$genMRNno' and intMRNYear = '$genMRNyear' ";
	return $db->RunQuery($sql);
}
?>