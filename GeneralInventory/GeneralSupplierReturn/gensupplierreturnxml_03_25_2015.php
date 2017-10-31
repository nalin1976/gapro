<?php
session_start();
include "../../Connector.php";
include("../class.glcode.php");
$objgl = new glcode();

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType	= $_GET["RequestType"];
//$companyId  	= $_SESSION["FactoryID"];
$factoryId      = $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

$companyId = GetMainStoresID($_SESSION["FactoryID"]);

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

else if($RequestType=="loadMrnDetailsToGrid")
{		
	$MatId		= $_GET["MatId"];
	$CatId		= $_GET["CatId"];
	$IssLike	= $_GET["IssLike"];
	$supplierId	= $_GET["supplierId"];
	
	$ResponseXML .= "<loadMrnDetailsToGrid>";
		
	$SQL = "SELECT
			GMIL.strItemDescription,
			GD.strUnit,			
			GD.intYear,
			GD.strGenGrnNo,
			GD.intMatDetailID,
			GD.dblBalance
			FROM
			genmatitemlist GMIL
			Inner Join gengrndetails GD ON GMIL.intItemSerial = GD.intMatDetailID
			Inner Join gengrnheader GH ON GH.strGenGrnNo=GD.strGenGrnNo AND GH.intYear=GD.intYear
			Inner Join generalpurchaseorderheader PH ON PH.intGenPONo=GH.intGenPONo AND PH.intYear=GH.intGenPOYear
			WHERE			
			PH.intSupplierID='$supplierId'";
			
				if($MatId != ""){
					
					$SQL .= " AND GMIL.intMainCatID = '" . $MatId . "'"; 	
				}
				
				if($IssLike != "")
				{
					$SQL .= " AND GMIL.strItemDescription LIKE '". "%" . $IssLike ."%" ."'  ";
				}
				if($CatId != "")
				{
					$SQL .= "AND GMIL.intSubCatID =  '" . $CatId . "'  ";
				}
				
			$SQL .= " AND PH.intDeliverTo = '".$factoryId."' ";	
		
		$result = $db->RunQuery($SQL);
		
			while($row = mysql_fetch_array($result))
			{
				$GLAllowId    = $row["intGLAllowId"];
				$GLCode       = $objgl-> getGLCode($GLAllowId);
				$ResponseXML .= "<GLCode><![CDATA[" . $GLCode  . "]]></GLCode>\n";
				$ResponseXML .= "<GLAllowId><![CDATA[" . $GLAllowId  . "]]></GLAllowId>\n";
				$ResponseXML .= "<costCenter><![CDATA[" . $row["intCostCenterId"]  . "]]></costCenter>\n";
				$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDescription>\n";
				$ResponseXML .= "<GrnNo><![CDATA[" . $row["intYear"] ."/".$row["strGenGrnNo"]. "]]></GrnNo>\n";
				$ResponseXML .= "<MatDetailID><![CDATA[" . $row["intMatDetailID"]  . "]]></MatDetailID>\n";				 
				$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";	
				$ResponseXML .= "<GrnBalance><![CDATA[" . $row["dblBalance"]  . "]]></GrnBalance>\n";	
				
				$stockbal=GetStock($companyId,$row["intMatDetailID"],$row["intYear"],$row["strGenGrnNo"]);
				$ResponseXML .= "<StockQty><![CDATA[" .  $stockbal  . "]]></StockQty>\n";
				 
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
	
	$SQL ="SELECT concat(GSH.intRetYear,'/',GSH.strReturnID) as intIssueNo , GSH.dtmRetDate ,GSH.intStatus, SUP.strTitle FROM  gensupreturnheader GSH Inner Join suppliers SUP ON GSH.intSupplierID = SUP.strSupplierID WHERE GSH.intStatus = 1 AND GSH.intCompanyID='$companyId'";
	
	if ($issueYearFrom!="")
	{
			$SQL .="AND strReturnID >='" . $issueNoFrom . "' AND intRetYear = '" . $issueYearFrom . "' "; 
	}
	if ($issueYearTo!="")
	{
			$SQL .="AND strReturnID <='" . $issueNoTo . "' AND intRetYear = '" . $issueYearTo . "' ";
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
		$ResponseXML .= "<SecurityNo><![CDATA[" . $row["strTitle"]  . "]]></SecurityNo>\n";
		$ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n";
	}
	$ResponseXML .= "</GetLoadSavedDetails>";
		echo $ResponseXML;
}
else if($RequestType=="LoadNo")
{	

	$ResponseXML .="<LoadNo>";
	
			
		 //--------------------hem----------------------------------- 
			 $NoYear = date('Y');
		    $SQL="SELECT dblGRetSupNo FROM syscontrol WHERE intCompanyID='$companyId'";
			$result =  $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$retSupNo =  $row["dblGRetSupNo"];
				$SQL = "UPDATE syscontrol set dblGRetSupNo=dblGRetSupNo+1 where intCompanyID='$companyId'";
				$result = $db->RunQuery($SQL);
				break;
			}
				$ResponseXML .= "<No><![CDATA[".$retSupNo."]]></No>\n";
				$ResponseXML .= "<Year><![CDATA[".$NoYear."]]></Year>\n";
		//--------------------------------------------------------------		 
			
	$ResponseXML .="</LoadNo>";
	echo $ResponseXML;
}
else if ($RequestType=="SaveHeader")
{
	$issueNo =$_GET["issueNo"];
	$issueYear =$_GET["issueYear"];
	$productionId =$_GET["productionId"];
	$reason = $_GET["reason"];	
	
 		$SQL= " INSERT INTO gensupreturnheader(strReturnID,intRetYear,dtmRetDate,intSupplierID,intReturnedBy,intStatus,intUserid,intCompanyId,strReason)  ". 
				" VALUES ($issueNo,$issueYear,now(),'$productionId','" . $_SESSION["UserID"] . "',1,'" . $_SESSION["UserID"] . "',$companyId,'$reason') ";	
				
				
				
	$db->executeQuery($SQL);
}
else if ($RequestType=="SaveDetails")
{
	$returnNo 		= $_GET["returnNo"];
	$returnYear 		= $_GET["returnYear"];
	$grnNo 			= $_GET["grnNo"];
	$grnNoArray		= explode('/',$grnNo);
	$itemdDetailID 	= $_GET["itemdDetailID"];
	$returnQty 			= $_GET["returnQty"];
	$unit 			= $_GET["unit"];
	//$GLAllowId		= $_GET["GLAllowId"];
	//$costCenter		= $_GET["costCenter"];
	$year			= date("Y");
	
	
		
	  $SQL= "INSERT INTO gensupreturndetail (strReturnID,intRetYear,strGRNNO,intGRNYear,intMatDetailID,dblQtyReturned,intGLAllowId) 
		VALUES ($returnNo,$returnYear,'$grnNoArray[1]',$grnNoArray[0],$itemdDetailID,$returnQty,0) ";	
		
	$db->executeQuery($SQL);	
	
	$SQL ="UPDATE genmatitemlist SET dblStock = dblStock - $returnQty WHERE intItemSerial=$itemdDetailID ";
	$db->executeQuery($SQL);
	
	$sql="update gengrndetails 
		set dblBalance = dblBalance - $returnQty
		where
		strGenGrnNo = '$grnNoArray[1]' 
		and intYear = '$grnNoArray[0]' 
		and intMatDetailID = '$itemdDetailID'
		and intGLAllowId = '$GLAllowId'
		and intCostCenterId = '$costCenter' ;";
	$db->executeQuery($sql);
	
	$sql="update generalpurchaseorderdetails 
			set dblPending = dblPending + $returnQty
			where
			intGenPoNo = (select intGenPONo from gengrnheader where strGenGrnNo='$grnNoArray[1]' and intYear='$grnNoArray[0]')  
			and intYear = (select intGenPOYear from gengrnheader where strGenGrnNo='$grnNoArray[1]' and intYear='$grnNoArray[0]') 
			and intMatDetailID = '$itemdDetailID'";
	$db->executeQuery($sql);

	
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
		($year, 
		'$companyId',
		'$returnNo', 
		'$returnYear', 
		'". $itemdDetailID ."', 
		'RSUP', 
		'$unit', 
		'". ($returnQty * -1) ."', 
		now(), 
		'$userId',
		'".$grnNoArray[1]."',
		'".$grnNoArray[0]."',
		'0',
		'0'
		);";	
	$db->executeQuery($SQL);
}
else if ($RequestType=="ResponseValidate")
{
	$issueNo = $_GET["issueNo"];
	$Year = $_GET["Year"];
	$validateCount = $_GET["validateCount"];
	
	$ResponseXML .="<ResponseValidate>";
	$SQL="SELECT COUNT(strReturnID) AS headerRecCount FROM gensupreturnheader where strReturnID=$issueNo AND intRetYear=$Year";

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
	$SQL="SELECT COUNT(strReturnID) AS issuesdetails FROM gensupreturndetail where strReturnID=$issueNo AND intRetYear=$Year";

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
	$SQL="SELECT DISTINCT IH.strReturnID ".
		 "FROM gensupreturnheader AS IH ".
		 "INNER JOIN gensupreturndetail AS ID ".
		 "ON IH.strReturnID=ID.strReturnID AND IH.intRetYear=ID.intRetYear ".
		 "WHERE IH.intStatus='$state' AND IH.intRetYear='$year'";

	
	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<IssueNo><![CDATA[" . $row["strReturnID"]. "]]></IssueNo>\n";
	}
	$ResponseXML.="</LoadPopUpIssueNo>";
	echo $ResponseXML;
}
function GetStock($companyid,$matid,$grnyear,$grnno)
{
	global $db;
	$qty = 0;
	 $SQL2 ="SELECT COALESCE(Sum(genstocktransactions.dblQty),0) AS dblStock
				FROM
				genstocktransactions
				WHERE strMainStoresID = '". $companyid ."'
				AND intMatDetailId =  '". $matid ."'  
				AND intGRNNo =  '". $grnno ."'  
				AND intGRNYear =  '". $grnyear ."'  ";		
	
	 $result2 = $db->RunQuery($SQL2);
	 while($row2 = mysql_fetch_array($result2))
	 {
		$qty = $row2["dblStock"]; 	
				
	 }
return $qty;
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