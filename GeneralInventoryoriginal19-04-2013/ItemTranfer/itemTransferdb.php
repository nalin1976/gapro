<?php	
session_start();
header('Content-Type: text/xml'); 
include "../../Connector.php";
include("../class.glcode.php");
$objgl = new glcode();

$request	= $_GET["request"];
$companyId	= $_SESSION["FactoryID"];
$userId		= $_SESSION["UserID"];
$year		= date("Y");

if($request=='loadSubStores')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<XMLloadSubStores>";
	$mainStore = $_GET['mainStore'];
	
	$SQL="select intSubCatNo,StrCatName from genmatsubcategory where intStatus=1 
		  and intCatNo='$mainStore'";
	$result =$db->RunQuery($SQL);
	
	$ResponseXML .= "<option value=\"".""."\">"."Select One"."</option>";
	while ($row=mysql_fetch_array($result))
	{		
		$ResponseXML .= "<option value=\"".$row["intSubCatNo"]."\">".$row["StrCatName"]."</option>";
	}
	$ResponseXML.="</XMLloadSubStores>";
	echo $ResponseXML;
}
if($request=='loadSourceDetails')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<loadSourceDetails>";
	
	$category    = $_GET['category'];
	$subcategory = $_GET['subcategory'];
	$itemLike    = $_GET['itemLike'];
	$costCenter  = $_GET['costCenter'];
	
	$sqlLoad = "SELECT 
				GST.intMatDetailId as itemCode,
				GMIL.strItemDescription,
				GST.strUnit as unit,
				round(sum(GST.dblQty),0) as TotalQty,
				concat(GST.intGrnNo,'/',GST.intGrnYear) as GRNNo,
				GST.intGLAllowId
				FROM
				genstocktransactions GST
				Inner Join genmatitemlist GMIL ON GMIL.intItemSerial = GST.intMatDetailId
				WHERE GST.lngTransactionNo <>'a' ";
				
				if($category!="")
				$sqlLoad.="and GMIL.intMainCatID='$category' ";
				
				if($subcategory!="")
				$sqlLoad.="and GMIL.intSubCatID='$subcategory' ";
				
				if($costCenter!="")
				$sqlLoad.="and GST.intCostCenterId='$costCenter' ";
				
				if($itemLike!="")
				$sqlLoad.="and GMIL.strItemDescription like '%$itemLike%' ";
				
				$sqlLoad .="GROUP BY GST.intMatDetailId,GST.intGrnNo,GST.intGrnYear,GST.intCostCenterId
							having TotalQty>0 ";
	$resultLoad =$db->RunQuery($sqlLoad);
	while ($row=mysql_fetch_array($resultLoad))
	{
		$GLAllowId    = $row["intGLAllowId"];
		$GLCode       = $objgl-> getGLCode($GLAllowId);
		$ResponseXML .= "<GLCode><![CDATA[" . $GLCode  . "]]></GLCode>\n";
		$ResponseXML .= "<GLAllowId><![CDATA[" . $GLAllowId  . "]]></GLAllowId>\n";
		$ResponseXML .= "<MatDetailId><![CDATA[" . $row["itemCode"]  . "]]></MatDetailId>\n";
		$ResponseXML .= "<ItemDes><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDes>\n";
		$ResponseXML .= "<unit><![CDATA[" . $row["unit"]  . "]]></unit>\n";
		$ResponseXML .= "<TotalQty><![CDATA[" . $row["TotalQty"]  . "]]></TotalQty>\n";
		$ResponseXML .= "<GRNNo><![CDATA[" . $row["GRNNo"]  . "]]></GRNNo>\n";
	}
	$ResponseXML   .= "</loadSourceDetails>";
	echo $ResponseXML;
}
if($request=='GetNo')
{
	$No=0;
	$ResponseXML .="<LoadNo>\n";
	
	$Sql="select intCompanyID,dblGenItemTransNo from syscontrol where intCompanyID='$companyId'";
	$result =$db->RunQuery($Sql);	
	$rowcount = mysql_num_rows($result);
		
	if ($rowcount > 0)
	{	
		while($row = mysql_fetch_array($result))
		{						
			$No=$row["dblGenItemTransNo"];
			$NextNo=$No+1;
			$sqlUpdate="UPDATE syscontrol SET dblGenItemTransNo='$NextNo' WHERE intCompanyID='$companyId';";				
			$db->executeQuery($sqlUpdate);
			$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
			$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";					
		}
			
	}
	else
	{
		$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
	}	
	$ResponseXML .="</LoadNo>";
	echo $ResponseXML;
}
if($request=='SaveDetails')
{
	$sourceCostId = $_GET['sourceCostId'];
	$DesCostId	  = $_GET['DesCostId'];
	$MatDetId	  = $_GET['MatDetId'];
	$Iunit	 	  = $_GET['Iunit'];
	$TransQty	  = $_GET['TransQty'];
	$GrnNoArry	  = explode('/',$_GET['GrnNo']);
	$pub_No		  = $_GET['pub_No'];
	$GLAllowId	  = $_GET['GLAllowId'];
	
	$boolSourceSave = SaveSourceStock($year,$companyId,$pub_No,$MatDetId,$Iunit,$TransQty,$userId,$GrnNoArry[0],$GrnNoArry[1],$sourceCostId,$GLAllowId);
	$boolDestSave = SaveDestStock($year,$companyId,$pub_No,$MatDetId,$Iunit,$TransQty,$userId,$GrnNoArry[0],$GrnNoArry[1],$DesCostId,$GLAllowId);
	if($boolSourceSave==true && $boolDestSave==true)
		echo 'Saved';
	else
		echo 'Error';
}
function SaveSourceStock($year,$companyId,$pub_No,$MatDetId,$Iunit,$TransQty,$userId,$GrnNo,$GrnYear,$sourceCostId,$GLAllowId)
{
	global $db;
	$outQty	= $TransQty*-1;
	$sql = "insert into genstocktransactions 
	(intYear, strMainStoresID, intDocumentNo, intDocumentYear, intMatDetailId, strType, strUnit, dblQty, 
	dtmDate, intUser, intGRNNo, intGRNYear, intCostCenterId,intGLAllowId)
	values
	('$year', '$companyId', '$pub_No', '$year', '$MatDetId', 'ItemTransOut', 
	'$Iunit', '$outQty', now(), '$userId', '$GrnNo', '$GrnYear', '$sourceCostId','$GLAllowId');";
	$result = $db->RunQuery($sql);
	if($result)
		return true;
	else
		return false;	
}
function SaveDestStock($year,$companyId,$pub_No,$MatDetId,$Iunit,$TransQty,$userId,$GrnNo,$GrnYear,$DesCostId,$GLAllowId)
{
	global $db;
	$sql = "insert into genstocktransactions 
	(intYear, strMainStoresID, intDocumentNo, intDocumentYear, intMatDetailId, strType, strUnit, dblQty, 
	dtmDate, intUser, intGRNNo, intGRNYear, intCostCenterId,intGLAllowId)
	values
	('$year', '$companyId', '$pub_No', '$year', '$MatDetId', 'ItemTransIn', 
	'$Iunit', '$TransQty', now(), '$userId', '$GrnNo', '$GrnYear', '$DesCostId','$GLAllowId');";
	$result = $db->RunQuery($sql);
	if($result)
		return true;
	else
		return false;	
}

?>