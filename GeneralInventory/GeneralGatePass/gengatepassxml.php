<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId  =$_SESSION["FactoryID"];
$userId		= $_SESSION["UserID"];

//----------------General Gatepass Status-------------------------
// 0 - Pending
// 1 - Confirm
//----------------------------------------------------------------

//start 2011-04-25 dinushi 
//begin laod subcategory details according to the main category
if($RequestType=="loadSubCategory")
{	
$intMainCatId = $_GET["mainCatId"];
$ResponseXML .= "<genmatsubcategory>";

	$SQL="SELECT intSubCatNo,StrCatName FROM genmatsubcategory WHERE intCatNo =$intMainCatId   ORDER BY StrCatName";
	
	$result = $db->RunQuery($SQL);
	$str = "<option value =\"".""."\">"."Select One"."</option>";
		while($row = mysql_fetch_array($result))
		{
			 $str .= "<option value=\"".$row["intSubCatNo"]."\">".$row["StrCatName"]."</option>";  
		}
$ResponseXML .= "<intSubCatNo><![CDATA[" . $str  . "]]></intSubCatNo>\n";
$ResponseXML .= "</genmatsubcategory>";
echo $ResponseXML;
}
//end laod subcategory details according to the main category

//begin load popup item details  
elseif($RequestType=="LoadPopItems")
{
	
$intMainStoresId = GetMainStoresID($companyId);

$ResponseXML = "<XMLURLLoadPopItems>";

$mainCat 	= $_GET["MainCat"];
$subCat 	= $_GET["SubCat"];
$itemDesc 	= $_GET["ItemDesc"];

  # =================================================================================
  # Comment On - 11/11/2013
  # Descirption - 
  # =================================================================================


	/*$sql="select GMIL.intItemSerial, GMIL.strItemDescription,GST.strUnit,sum(GST.dblQty) as stockQty,GST.intGRNNo,GST.intGRNYear,
GST.intCostCenterId,CC.strDescription as costCenterDes,GST.intGLAllowId,
(SELECT GL.strAccID FROM glaccounts GL WHERE GL.intGLAccID = GLA.GLAccNo) AS glCode,
(SELECT C.strCode FROM costcenters C WHERE C.intCostCenterId = GLA.FactoryCode) AS costCenterCode
	from genstocktransactions GST inner join genmatitemlist GMIL on
	GST.intMatDetailId = GMIL.intItemSerial
	inner join costcenters CC on CC.intCostCenterId=GST.intCostCenterId
	inner join glallowcation GLA on GLA.GLAccAllowNo = GST.intGLAllowId
	where GST.strMainStoresID='$intMainStoresId'";*/
	
 # =================================================================================
   
   $sql = " select GMIL.intItemSerial, GMIL.strItemDescription,GST.strUnit,sum(GST.dblQty) as stockQty,GST.intGRNNo,GST.intGRNYear,
GST.intCostCenterId, GST.intGLAllowId, GMIL.strItemCode
	from genstocktransactions GST inner join genmatitemlist GMIL on
	GST.intMatDetailId = GMIL.intItemSerial 	
	where GST.strMainStoresID='$intMainStoresId'";

	if($mainCat!="")	
		$sql .= "and GMIL.intMainCatID=$mainCat ";
	if($subCat!="")
		$sql .= "and GMIL.intSubCatID=$subCat ";
	if($itemDesc!="")
		$sql .= "and GMIL.strItemDescription like '%$itemDesc%' ";
	
	//$sql .= "group by GMIL.intItemSerial,GST.intGRNNo,GST.intGRNYear,GST.intCostCenterId,GST.intGLAllowId
	//having sum(GST.dblQty)>0";
	
	# ========================================================
	# Comment On - 11/27/2013
	# Description - Remove group clause
	# =========================================================
	  // $sql .= "group by GMIL.intItemSerial,GST.intGRNNo,GST.intGRNYear having sum(GST.dblQty)>0";
	 
	 # =========== END ========================================= 
	 
	 //$sql .= " group by GMIL.intItemSerial having sum(GST.dblQty)>0";
	 $sql .= " group by GMIL.intItemSerial,GST.intGRNNo,GST.intGRNYear having sum(GST.dblQty)>0";
	
	
	//echo $sql;
	$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			# =================================================================================================
			# Comment On - 12/05/2013
			# Description - Remove deduction of MRN qty from stock balance
			# =================================================================================================
			//$mrnQty = getGenMRNQty($row["intItemSerial"],$companyId,$row["intGRNNo"],$row["intGRNYear"],$row["intCostCenterId"],$row["intGLAllowId"]);
			//$stockBalQty = $row["stockQty"] - $mrnQty;			
			# =================================================================================================
			
			$stockBalQty = $row["stockQty"];
			
			$ResponseXML .= "<ItemId><![CDATA[" . $row["intItemSerial"]  . "]]></ItemId>\n";	
			$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";	
			$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";	
			$ResponseXML .= "<balQty><![CDATA[" . $stockBalQty  . "]]></balQty>\n";	
			$ResponseXML .= "<GRNNo><![CDATA[" . $row["intGRNNo"]  . "]]></GRNNo>\n";	
			$ResponseXML .= "<GRNYear><![CDATA[" . $row["intGRNYear"]  . "]]></GRNYear>\n";	
			$ResponseXML .= "<costCenterId><![CDATA[" . $row["intCostCenterId"]  . "]]></costCenterId>\n";
			$ResponseXML .= "<costCenterDes><![CDATA[" . $row["costCenterDes"]  . "]]></costCenterDes>\n";
			$ResponseXML .= "<intGLAllowId><![CDATA[" . $row["intGLAllowId"]  . "]]></intGLAllowId>\n";
			$ResponseXML .= "<glCode><![CDATA[" . $row["glCode"]  . "]]></glCode>\n";
			$ResponseXML .= "<costCenterCode><![CDATA[" . $row["costCenterCode"]  . "]]></costCenterCode>\n";
			$ResponseXML .= "<ItemCode><![CDATA[" . $row["strItemCode"]  . "]]></ItemCode>\n";
			
		}
$ResponseXML .= "</XMLURLLoadPopItems>\n";
echo $ResponseXML;
}
//end  load popup item details 
//begin generate new gatepass no 
else if($RequestType=="LoadGenGPno")
{		
$No=0;
$ResponseXML .="<LoadNo>\n";
	
	$Sql="select intCompanyID,dblGGatNo from syscontrol where intCompanyID='$companyId'";
	
	$result =$db->RunQuery($Sql);	
	$rowcount = mysql_num_rows($result);
	
	if ($rowcount > 0)
	{	
		while($row = mysql_fetch_array($result))
		{				
			$No=$row["dblGGatNo"];
			$NextNo=$No+1;
			$sqlUpdate="UPDATE syscontrol SET dblGGatNo='$NextNo' WHERE intCompanyID='$companyId';";				
			$db->executeQuery($sqlUpdate);
			$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
			$ResponseXML .= "<genGPNo><![CDATA[".$No."]]></genGPNo>\n";
			$ResponseXML .= "<genGPYear><![CDATA[".date('Y')."]]></genGPYear>\n";
		}
			
	}
	else
	{
		$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
	}	
$ResponseXML .="</LoadNo>";
echo $ResponseXML;
}
//end get new gatepass no

//begin save general GP header details
else if($RequestType=="saveGenGPheader")
{
$ResponseXML = "<XMLGenGPheader>";

$GenGPNo		= $_GET["GenGPNo"];
$GenGPYear		= $_GET["GenGPYear"];
$GPtoFac 		= $_GET["GPtoFac"];
$attentionBy 	= $_GET["attentionBy"];
$txtthrough 	= $_GET["txtthrough"];
$instruct 		= $_GET["instruct"];
	
	//Begin Delete General Gatepass Header & detail table data
	deleteGenGPHeaderData($GenGPNo,$GenGPYear);
	deleteGenGPDetailData($GenGPNo,$GenGPYear);
	//End Delete General Gatepass Header & detail table data
	
	$response = insertGenGPHeaderdetails($GenGPNo,$GenGPYear,$GPtoFac,$attentionBy,$txtthrough,$instruct,$companyId);
		
	$ResponseXML .= "<genGPHeaderResponse><![CDATA[".$response."]]></genGPHeaderResponse>\n";

$ResponseXML .="</XMLGenGPheader>";
echo $ResponseXML;
}
//end  save general GP header details

//begin save general GP details
else if ($RequestType=="saveGenGPdetails")
{
$ResponseXML = "<XMLGenGPdetails>";

$GenGPNo		= $_GET["GenGPNo"];
$GenGPYear		= $_GET["GenGPYear"];
$matId			= $_GET["matId"];
$gpQty			= $_GET["gpQty"];
$balQty			= $_GET["gpQty"];
$itemUnit		= $_GET["itemUnit"];
$grnno			= $_GET["grnno"];
$grnyear		= $_GET["grnyear"];	
$GPtoFac 		= $_GET["GPtoFac"];
$costCenterId	= $_GET["costCenterId"];
$glAlloId		= $_GET["glAlloId"];

	$resInsertGPdetails = insertGPDetails($GenGPNo,$GenGPYear,$matId,$gpQty,$balQty,$itemUnit,$grnno,$grnyear,$costCenterId,$glAlloId);
	
	//StockTransaction Record  - Gate Pass To (+)
	//$strType = 'GPT';
	//$resGPto	= insertGenStocktransation($GPtoFac,$GenGPNo,$GenGPYear,$matId,$strType,$itemUnit,$gpQty);	  
		 
	 $ResponseXML .= "<genGPDetailRes><![CDATA[".$resInsertGPdetails."]]></genGPDetailRes>\n";
	 	 
$ResponseXML .="</XMLGenGPdetails>";
echo $ResponseXML;		
}
//end save general GP details

//begin load Gen GP no list for popup
else if ($RequestType=="loadPopupGenGPNoList")
{
$ResponseXML = "<XMLGenGPNoList>";

$status		= $_GET["status"];
$GPyear		= $_GET["GPyear"];

	$sql = " select strGatepassID from gengatepassheader where intYear=$GPyear and intStatus='$status' and intCompanyId='$companyId' order by strGatepassID desc";
	$result = $db->RunQuery($sql);
	$str = "<option value =\"".""."\">"."Select One"."</option>";
	while($row = mysql_fetch_array($result))
	{
		 $str .= "<option value=\"".$row["strGatepassID"]."\">".$row["strGatepassID"]."</option>";  
	}
$ResponseXML .= "<GPNoList><![CDATA[" . $str  . "]]></GPNoList>\n";
$ResponseXML .="</XMLGenGPNoList>";
echo $ResponseXML;	
}
//end load Gen GP no list for popup

//begin load general gatepass details to general gp form
else if ($RequestType=="loadGenGPHeaderDetails")
{
$ResponseXML = "<XMLGenGPHeaderDetails>";

$status		= $_GET["status"];
$GPyear		= $_GET["GPyear"];
$GPNo		= $_GET["GPNo"];

	$result = getGenGPHeaderData($GPNo,$GPyear,$status);
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<intToStores><![CDATA[" . $row["intToStores"]  . "]]></intToStores>\n"; 
		 $ResponseXML .= "<strAttention><![CDATA[" . $row["strAttention"]  . "]]></strAttention>\n";
		 $ResponseXML .= "<strThrough><![CDATA[" . $row["strThrough"]  . "]]></strThrough>\n"; 
		 $ResponseXML .= "<intInstructedBy><![CDATA[" . $row["intInstructedBy"]  . "]]></intInstructedBy>\n"; 
	}
$ResponseXML .="</XMLGenGPHeaderDetails>";
echo $ResponseXML;
}

else if ($RequestType=="loadGenGPDetailsData")
{
$ResponseXML = "<XMLGenGPDetailsData>";

$GPyear		= $_GET["GPyear"];
$GPNo		= $_GET["GPNo"];

	$result = getGenGPDetailsData($GPNo,$GPyear);
	while($row = mysql_fetch_array($result))
	{
		 $gpQty = $row["dblQty"];
		 $stockQty = getGPStockQty($row["intMatDetailID"],$companyId,$row["intCostCenterId"],$row["intGLAllowId"],$row["intGrnNo"],$row["intGrnYear"]);
		 $mrnQty = getGenMRNQty($row["intMatDetailID"],$companyId,$row["intGrnNo"],$row["intGrnYear"],$row["intCostCenterId"],$row["intGLAllowId"]);
		 $stockBalQty = $stockQty - $mrnQty;
		 
		 $GLcode = $row["glCode"].'-'.$row["ccCode"];
		 $ResponseXML .= "<intMatDetailID><![CDATA[" . $row["intMatDetailID"]  . "]]></intMatDetailID>\n"; 
		 $ResponseXML .= "<strItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></strItemDescription>\n";
		 $ResponseXML .= "<strUnit><![CDATA[" . $row["strUnit"]  . "]]></strUnit>\n"; 
		 $ResponseXML .= "<gpQty><![CDATA[" . $gpQty  . "]]></gpQty>\n"; 
		 $ResponseXML .= "<stockBalQty><![CDATA[" . $stockBalQty  . "]]></stockBalQty>\n";
		 $ResponseXML .= "<grnNo><![CDATA[" . $row["intGrnNo"]  . "]]></grnNo>\n";
		 $ResponseXML .= "<grnYear><![CDATA[" . $row["intGrnYear"]  . "]]></grnYear>\n";
		 $ResponseXML .= "<CostCenterId><![CDATA[" . $row["intCostCenterId"]  . "]]></CostCenterId>\n"; 
		 $ResponseXML .= "<CostCenterDes><![CDATA[" . $row["cosCenterDes"]  . "]]></CostCenterDes>\n";
		 $ResponseXML .= "<GLAlloID><![CDATA[" . $row["intGLAllowId"]  . "]]></GLAlloID>\n";
		 $ResponseXML .= "<GLcode><![CDATA[" . $GLcode  . "]]></GLcode>\n";
	}
$ResponseXML .="</XMLGenGPDetailsData>";
echo $ResponseXML;
}
//end load general gatepass details to general gp form

//begin confirm GP data
else if ($RequestType=="confirmGenGPDetails")
{
$ResponseXML = "<XMLconfirmGenGPDetailsData>";

$GPyear		= $_GET["GPyear"];
$GPNo		= $_GET["GPNo"];
$recCount = 0;
$msg = '';
	$intStatus = getGPstatus($GPNo,$GPyear);
	if($intStatus == '0')
	{
		$result = getGenGPDetailsData($GPNo,$GPyear);
		while($row = mysql_fetch_array($result))
		{
			 
			 $mainStoresId = GetMainStoresID($companyId);
			 
			 $gpQty = $row["dblQty"];
		//$stockQty = getGPStockQty($row["intMatDetailID"],$companyId,$row["intCostCenterId"],$row["intGLAllowId"],$row["intGrnNo"],$row["intGrnYear"]);
		$stockQty = getGPStockQty($row["intMatDetailID"],$mainStoresId,$row["intCostCenterId"],$row["intGLAllowId"],$row["intGrnNo"],$row["intGrnYear"]);
			
			 # =========================================================================
			 # Comment On - 12/05/2013
			 # Description - Remove deduction of MRN Qty from stock balance
			 # =========================================================================	
			 //$mrnQty = getGenMRNQty($row["intMatDetailID"],$companyId,$row["intGrnNo"],$row["intGrnNo"],$row["intCostCenterId"],$row["intGLAllowId"]);
			 //$stockBalQty = $stockQty - $mrnQty;
			# =========================================================================	
			
			$stockBalQty = $stockQty;
			
			 if($gpQty>$stockBalQty)
			 {
			 	$recCount++;
			 	$msg = "Item :".$row["strItemDescription"]." does not have enough stock";
			 	 $ResponseXML .= "<message><![CDATA[" . $msg  . "]]></message>\n";
				 $ResponseXML .="</XMLconfirmGenGPDetailsData>";
				 echo $ResponseXML;
				 return;
			 }
		 }
		
		 if($recCount==0)
		 {
		 	$resStock = updateStockDetails($GPNo,$GPyear,$companyId);
			if($resStock == '1')
				$resStatus = updateGenGPheader($GPNo,$GPyear);
			else
				$msg = 'Error in updating stock';	
		 }
	}
	else
	{
		$msg = 'No Pending Gatepass not available';
	}
	
	if($resStatus == '1')
		$msg = 'saved';
	else
		$msg = 'Error in updating Gatepass header';	
		
	$ResponseXML .= "<message><![CDATA[" . $msg  . "]]></message>\n";
	
	
$ResponseXML .="</XMLconfirmGenGPDetailsData>";
echo $ResponseXML;
}
//end confirm GP data
//---------------------------

//start 2011-04-26 dinushi 
function getGenMRNQty($matdetailID,$companyId,$grnNo,$grnYear,$costCenterId,$glAlloId)
{
	global $db;
	
	$sql = "select sum(gmrd.dblBalQty) as mrnQty
			from genmatrequisitiondetails gmrd inner join genmatrequisition gmrn on
			gmrd.intMatRequisitionNo = gmrn.intMatRequisitionNo and 
			gmrd.intYear = gmrn.intMRNYear
			where gmrd.strMatDetailID ='$matdetailID' and gmrn.intCompanyID=$companyId and gmrd.intGRNNo='$grnNo'
			and  gmrd.intGRNYear = '$grnYear' and gmrn.intCostCenterId = '$costCenterId' and gmrd.intGLAllowId='$glAlloId'
			having  sum(gmrd.dblBalQty)>0";
			
	$result=$db->RunQuery($sql);
	$rowCount = mysql_num_rows($result);
	$row = mysql_fetch_array($result);
	
	if($rowCount>0)
		return $row["mrnQty"];
	else
		return 0;	
}

function insertGenGPHeaderdetails($GenGPNo,$GenGPYear,$GPtoFac,$attentionBy,$txtthrough,$instruct,$companyId)
{
	global $db;
	global $userId;
	
	$sql = "insert into gengatepassheader (strGatepassID,intYear,intToStores,strAttention,strThrough,intInstructedBy,dtmDate, 
			intStatus,intCompanyId,intUserId)
			values 	('$GenGPNo','$GenGPYear','$GPtoFac','$attentionBy','$txtthrough','$instruct',now(), 
			'0','$companyId','$userId')";
	return 	$db->RunQuery($sql);
}
function insertGPDetails($GenGPNo,$GenGPYear,$matId,$gpQty,$balQty,$itemUnit,$grnno,$grnyear,$costCenterId,$glAlloId)
{
	global $db;
		
	$sql = "insert into gengatepassdetail (strGatepassID,intYear,intMatDetailID,dblQty,dblBalQty,strUnit,intGrnNo,intGrnYear,intCostCenterId,intGLAllowId)	values('$GenGPNo', '$GenGPYear', 
	'$matId', '$gpQty','$balQty','$itemUnit','$grnno','$grnyear','$costCenterId','$glAlloId')";
	return 	$db->RunQuery($sql);	
}

function insertGenStocktransation($companyId,$GenGPNo,$GenGPYear,$matId,$strType,$itemUnit,$gpQty,$grnno,$grnyear,$coscenterId,$glAlloId)
{
	global $db;
	global $userId;
	$intYear = date('Y');
	$sql = "insert into genstocktransactions (intYear,strMainStoresID,intDocumentNo,				            intDocumentYear,intMatDetailId,strType,strUnit,dblQty,dtmDate,intUser,intGRNNo,intGRNYear,intCostCenterId,intGLAllowId)
			values ($intYear,'$companyId','$GenGPNo','$GenGPYear', '$matId', '$strType','$itemUnit','$gpQty', now(),'$userId','$grnno','$grnyear','$coscenterId','$glAlloId')";
	
	return 	$db->RunQuery($sql);			
}

function deleteGenGPHeaderData($gpNo,$gpYear)
{
	global $db;
	$sql = " delete from gengatepassheader 	where strGatepassID = '$gpNo' and intYear = '$gpYear' ";
	$result = $db->RunQuery($sql);	
}

function deleteGenGPDetailData($gpNo,$gpYear)
{
	global $db;
	$sql = " delete from gengatepassdetail 	where strGatepassID = '$gpNo' and intYear = '$gpYear' ";
	$result = $db->RunQuery($sql);	
}

function getGenGPHeaderData($GPNo,$GPyear,$status)
{
	global $db;
	$sql = " select * from gengatepassheader where strGatepassID = '$GPNo' and intYear = '$GPyear' and intStatus = '$status'";
	return $db->RunQuery($sql);	
}

function getGenGPDetailsData($GPNo,$GPyear)
{
	global $db;
	
	#==========================================================================
	# Comment On - 11/11/2013
	# Description - Remove GL & cost center link
	#==========================================================================
	/*$sql = "select gpd.intMatDetailID,gpd.dblQty,gmil.strItemDescription, gmil.strUnit,gpd.intGrnNo, gpd.intGrnYear,gpd.intCostCenterId,CC.strDescription as cosCenterDes,gpd.intGLAllowId,
(select gl.strAccID from glaccounts gl where gla.GLAccNo = gl.intGLAccID) as glCode,
(select c.strCode from costcenters c where c.intCostCenterId= gla.FactoryCode) as ccCode
from gengatepassdetail gpd inner join genmatitemlist gmil on
gpd.intMatDetailID = gmil.intItemSerial
inner join costcenters CC on CC.intCostCenterId=gpd.intCostCenterId
inner join glallowcation gla on gla.GLAccAllowNo = gpd.intGLAllowId
			where gpd.strGatepassID='$GPNo' and gpd.intYear='$GPyear' ";*/
	#==========================================================================		
	$sql = " select gpd.intMatDetailID,gpd.dblQty,gmil.strItemDescription, gmil.strUnit,gpd.intGrnNo, gpd.intGrnYear,gpd.intCostCenterId ,gpd.intGLAllowId
from gengatepassdetail gpd inner join genmatitemlist gmil on
gpd.intMatDetailID = gmil.intItemSerial	where gpd.strGatepassID='$GPNo' and gpd.intYear='$GPyear' ";	
		
	return $db->RunQuery($sql);		
}

function getGPStockQty($matDetailID,$companyId,$costCenterId,$glAlloId,$GPNo,$GPyear)
{
	global $db;
	//$sql = "select sum(dblQty) as stockQty from genstocktransactions where intMatDetailId='$matDetailID' and strMainStoresID='$companyId' and intCostCenterId='$costCenterId' and  intGLAllowId='$glAlloId' and intGRNNo='$GPNo' and intGRNYear = '$GPyear' ";
	
	$sql = "select sum(dblQty) as stockQty from genstocktransactions where intMatDetailId='$matDetailID' and strMainStoresID='$companyId' and intGRNNo='$GPNo' and intGRNYear = '$GPyear' ";
	//echo $sql;
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["stockQty"];
}

function getGPstatus($GPNo,$GPyear)
{
	global $db;
	$sql = "Select intStatus from gengatepassheader where strGatepassID = '$GPNo' and intYear = '$GPyear'";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	return $row["intStatus"];
}

function updateStockDetails($GPNo,$GPyear,$companyId)
{
	global $db;
	$result = getGenGPDetailsData($GPNo,$GPyear);
	$rwCount = mysql_num_rows($result);
	$rw=0;
	while($row = mysql_fetch_array($result))
	{	
		$rw++;
		$gpQty = $row["dblQty"]*-1;
		
		$mainStoresId = GetMainStoresID($companyId);
		
		//$resGPto = insertGenStocktransation($companyId,$GPNo,$GPyear,$row["intMatDetailID"],'GPF',$row["strUnit"],$gpQty,$row["intGrnNo"],$row["intGrnYear"],$row["intCostCenterId"],$row["intGLAllowId"]);	
		
		$resGPto = insertGenStocktransation($mainStoresId,$GPNo,$GPyear,$row["intMatDetailID"],'GPF',$row["strUnit"],$gpQty,$row["intGrnNo"],$row["intGrnYear"],$row["intCostCenterId"],$row["intGLAllowId"]);
	}
	if($rwCount == $rw)
		return true;
	else
		return false;	
}

function updateGenGPheader($GPNo,$GPyear)
{
	global $db;
	$sql = " update gengatepassheader set intStatus = '1' where 	strGatepassID = '$GPNo' and intYear = '$GPyear' ";
	return  $db->RunQuery($sql);	
}

function GetMainStoresID($prmCompanyId){
	
	global $db;
	
	$sql = " SELECT * FROM mainstores WHERE intCompanyId = ".$prmCompanyId;
	
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result)){		
		return $row['strMainID'];		
	}
}
//----------------------
?>