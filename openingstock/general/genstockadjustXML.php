<?php
include "../../Connector.php";
$requestType 	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($requestType=="URLLoadSubCat")
{
	$intMainCatId = $_GET["mainCatId"];	
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$ResponseXML .= "<genmatsubcategory>";

		$SQL="SELECT intSubCatNo,StrCatName FROM genmatsubcategory WHERE intCatNo =$intMainCatId   ORDER BY StrCatName";
				
		$result = $db->RunQuery($SQL);
		$str = '';
		$str .= "<option value=\"". "" ."\">" . "" ."</option>";
		
			while($row = mysql_fetch_array($result))
			{
				 $str .= "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>";
			}
			$ResponseXML .= "<SubCat><![CDATA[" . $str  . "]]></SubCat>\n";
			$ResponseXML .= "</genmatsubcategory>";
			echo $ResponseXML;
}
if($requestType=="getStockQty")
{
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<XMLURLgetStockQty>";
	$qty = 0;
	$matId 		  = $_GET["matId"];
	$costcenter = $_GET["costcenter"];
	
	$sql = "select intMatDetailId,intCostCenterId,round(sum(dblQty),2) as StockQty
			from genstocktransactions
			where intCostCenterId='$costcenter' and intMatDetailId='$matId'
			group by intMatDetailId,intCostCenterId ";
	
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["StockQty"];
		$pendingAllowQty = PendingAllocation($matId,$costcenter);
		$qty	= $qty - $pendingAllowQty;
	}
	$ResponseXML .= "<stockQty><![CDATA[" .  round($qty,2) . "]]></stockQty>\n";	
	$ResponseXML .= "</XMLURLgetStockQty>\n";
	echo $ResponseXML;
}

elseif($requestType=="URLLoadPopItems")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLURLLoadPopItems>";

//$styleId	= $_GET["StyleId"];
$mainCat 	= $_GET["MainCat"];
$subCat 	= $_GET["SubCat"];
$itemDesc 	= $_GET["ItemDesc"];
$itemCode 	= $_GET["ItemCode"];
	$sql="select GMIL.strItemDescription,GMIL.strUnit,GMIL.intItemSerial,GMMC.strDescription,GMSC.StrCatName,
			GMIL.intMainCatID
			from genmatitemlist GMIL
			inner join genmatmaincategory GMMC on GMMC.intID=GMIL.intMainCatID
			inner join genmatsubcategory GMSC on GMSC.intSubCatNo=GMIL.intSubCatID
			where GMIL.intStatus=1 ";

if($mainCat!="")	
	$sql .= "and GMIL.intMainCatID=$mainCat ";
if($subCat!="")
	$sql .= "and GMIL.intSubCatID=$subCat ";
if($itemDesc!="")
	$sql .= "and GMIL.strItemDescription like '%$itemDesc%' ";
if($itemCode!="")
	$sql .= "and GMIL.intItemSerial = '$itemCode' ";
	
	$sql .= "order by GMIL.strItemDescription ";
//echo $sql;
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<ItemId><![CDATA[" . $row["intItemSerial"]  . "]]></ItemId>\n";	
		$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";	
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		$ResponseXML .= "<mainCategory><![CDATA[" . $row["strDescription"]  . "]]></mainCategory>\n";
		$ResponseXML .= "<subCategory><![CDATA[" . $row["StrCatName"]  . "]]></subCategory>\n";	
		$ResponseXML .= "<mainCatId><![CDATA[" . $row["intMainCatID"]  . "]]></mainCatId>\n";	
	}
$ResponseXML .= "</XMLURLLoadPopItems>\n";
echo $ResponseXML;
}
elseif($requestType=="URLGetNewSerialNo")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
    $No=0;
	$ResponseXML = "<XMLGetNewSerialNo>\n";
	
		$Sql="select intCompanyID,dblGenOpenStockNo from syscontrol where intCompanyID='$companyId'";		
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{				
					$No=$row["dblGenOpenStockNo"];
					$NextNo=$No+1;
					$ReturnYear = date('Y');
					$sqlUpdate="UPDATE syscontrol SET dblGenOpenStockNo='$NextNo' WHERE intCompanyID='$companyId';";
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
	$ResponseXML .="</XMLGetNewSerialNo>";
	echo $ResponseXML;
}
elseif($requestType=="URLSaveHeader")
{
$serialNo	= $_GET["SerialNo"];
$serialYear	= $_GET["SerialYear"];

	$sql="insert into genopenstock_header (intSerialNo, intSerialYear, intStatus, intUserId, intCompanyId, dtmSaved)
values('$serialNo', '$serialYear', '0', '$userId', '$companyId', now());
";
	$result=$db->RunQuery($sql);
}
elseif($requestType=="URLSaveDetails")
{
	$serialNo		= $_GET["SerialNo"];
	$serialYear		= $_GET["SerialYear"];
	$matId			= $_GET["matId"];
	$ajMark			= $_GET["ajMark"];
	$unitprice		= $_GET["unitprice"];
	$unitPriceST	= ($ajMark=='+' ? $_GET["unitprice"]:0);
	$binQty			= $_GET["binQty"];
	$mainStoreId	= ($_GET["mainStoreId"]=="0"?$companyId:$_GET["mainStoreId"]);
	$grnNo			= $_GET["grnNo"];
	$grnYear		= $_GET["grnYear"];
	$Unit			= $_GET["Unit"];
	$StockQty		= ($ajMark=='+' ? $binQty:$ajMark.''.$binQty);
	$costCenterId	= $_GET["costCenterId"];
	$GLAllowId		= $_GET["GLAllowId"];

	$sql="insert into genopenstock_details (intSerialNo, intSerialYear, intMatDetailId, dblQty, strAdjustMark, dblUnitprice, intMainStoreId, intCostcenterId, intGrnNo, intGrnYear ,intGLAllowId)
values('$serialNo', '$serialYear', '$matId', '$binQty', '$ajMark', '$unitprice', '$mainStoreId', '$costCenterId', '$grnNo', '$grnYear', '$GLAllowId');
";
	$result=$db->RunQuery($sql);
	if($result)
	{
		$booCheck = updateGenStockTransactionTable($serialNo,$serialYear,$matId,$mainStoreId,$grnNo,$grnYear,$Unit,$StockQty,$costCenterId,$GLAllowId,$unitPriceST);
		if($booCheck)
			echo "Saved";
		else
			echo "Error";
		
	}
}
function updateGenStockTransactionTable($serialNo,$serialYear,$matId,$mainStoreId,$grnNo,$grnYear,$Unit,$StockQty,$costCenterId,$GLAllowId,$unitprice)
{
	global $db;
	global $userId;	
	
$sql = "insert into genstocktransactions 
				(intYear, strMainStoresID,intDocumentNo,intDocumentYear,intMatDetailId, 
				strType, strUnit, dblQty, dtmDate, intUser, intGRNNo, intGRNYear, intCostCenterId ,
				dblUnitPrice ,intGLAllowId
				)
				values
				('$serialYear', '$mainStoreId', '$serialNo', '$serialYear', 
				 '$matId', 'AdjustStock', '$Unit', '$StockQty', now(), '$userId', '$grnNo', 
				 '$grnYear', '$costCenterId' , '$unitprice' , '$GLAllowId' );";
		
	$result=$db->RunQuery($sql);
		if($result)
			return true;
		else
			return false;
}

function PendingAllocation($matId,$costcenter)
{
global $db;
$qty	= 0;
	$sql="SELECT coalesce(round(sum(MRD.dblBalQty),2),0) AS A
		FROM genmatrequisitiondetails AS MRD 
		Inner Join genmatrequisition AS MR ON MR.intMatRequisitionNo = MRD.intMatRequisitionNo AND MR.intMRNYear = MRD.intYear 
		WHERE 
		MRD.strMatDetailID ='$matId' AND 
		MR.intCostCenterId ='$costcenter' and
		dblBalQty>0 
		Group By MRD.strMatDetailID,MR.intCostCenterId ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty	= $row["pendingQty"];
	}
return $qty;
}
?>