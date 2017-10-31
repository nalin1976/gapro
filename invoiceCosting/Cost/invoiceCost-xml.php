<?php
session_start();
include "../../Connector.php";
//$id="loadGrnHeader";
$id=$_GET["id"];

if($id=="loadCostHeader")
{
$cbointStyleId	=$_GET["cbointStyleId"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$ResponseXML .="<InvoiceCostHeader>";
	
	$SQL = "SELECT 
		 O.strStyle,
		 O.strOrderNo,
		 O.reaFob,
		 O.intQty,
		 O.strDescription,
		 MIL.strItemDescription,
		 O.reaNewCM,
		 O.reaSMV,
		 O.reaSMVRate
		 FROM orders O
		 INNER JOIN orderdetails OD ON O.intStyleId = OD.intStyleId
		 INNER JOIN matitemlist MIL ON OD.intMatDetailID = MIL.intItemSerial 
		 where O.intStyleId = '$cbointStyleId' -- and OD.intMainFabricStatus=1 
		 order by MIL.intMainCatID"; 
	$result = $db->RunQuery($SQL);	
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<intStyleId><![CDATA[" . $cbointStyleId . "]]></intStyleId>\n";
		 $ResponseXML .= "<Status><![CDATA[0]]></Status>\n";
		 $ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n"; 
		 $ResponseXML .= "<strOrderNo><![CDATA[" . trim($row["strOrderNo"])  . "]]></strOrderNo>\n";
		 $ResponseXML .= "<dblFob><![CDATA[" . trim($row["reaFob"])  . "]]></dblFob>\n";
		 $ResponseXML .= "<dblQty><![CDATA[" . trim($row["intQty"])  . "]]></dblQty>\n";
		 $ResponseXML .= "<fabric><![CDATA[" . trim($row["strItemDescription"])  . "]]></fabric>\n";
		 $ResponseXML .= "<dblNewCM><![CDATA[" . number_format($row["reaSMV"]*$row["reaSMVRate"],2) . "]]></dblNewCM>\n";
		 $ResponseXML .= "<strDescription><![CDATA[" . trim($row["strDescription"])  . "]]></strDescription>\n";
		 $ResponseXML .= "<ReduceCM><![CDATA[" . number_format($row["reaSMV"]*$row["reaSMVRate"],2) . "]]></ReduceCM>\n";
		 break;
	}
	$ResponseXML .= "</InvoiceCostHeader>";
	echo $ResponseXML;

}
if($id=="loadCostDetails")
{
$cbointStyleId	=$_GET["cbointStyleId"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .="<InvoiceCostDetails>";
$SQL="SELECT distinct	
MIL.strItemDescription,					
OD.reaConPc,
OD.reaWastage,
OD.dblUnitPrice,
OD.dblFreight,
MIL.intItemSerial,
OD.intOriginNo,
MIL.intMainCatID,
MSC.StrCatName,
OD.intMainFabricStatus
FROM
orders O
INNER JOIN orderdetails OD ON O.intStyleId = OD.intStyleId 
INNER JOIN matitemlist MIL ON OD.intMatDetailID = MIL.intItemSerial
inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID
WHERE
OD.intStyleId	= '$cbointStyleId' group by  MIL.strItemDescription
order by MIL.intMainCatID,MIL.strItemDescription";

$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<dblUnitPrice><![CDATA[" . round($row["dblUnitPrice"]+$row["dblFreight"],4)  . "]]></dblUnitPrice>\n";	
		 $ResponseXML .= "<reaConPc><![CDATA[" . round($row["reaConPc"]*12,4)  . "]]></reaConPc>\n";
		 $ResponseXML .= "<reaWastage><![CDATA[" . trim($row["reaWastage"])  . "]]></reaWastage>\n";
		 $ResponseXML .= "<FinancePercent><![CDATA[" . "0" . "]]></FinancePercent>\n";
		 $ResponseXML .= "<intItemSerial><![CDATA[" . trim($row["intItemSerial"])  . "]]></intItemSerial>\n";
		 $ResponseXML .= "<strItemDescription><![CDATA[" . trim($row["strItemDescription"])  . "]]></strItemDescription>\n";
		 $ResponseXML .= "<strOriginType><![CDATA[" . createCombo($row["intOriginNo"])  .  "]]></strOriginType>\n";
		 
		 $subCatName		= substr($row["StrCatName"],0,9);
		 $mainFabricName 	= $row["intMainFabricStatus"];
		 $mainId			= $row["intMainCatID"];
		 $className			= "bcgcolor-tblrowWhite";
		 //ChangeClassByCategory($mainId,$subCatName,$mainFabricName);	
		 
		if($mainId==1)
		{
			if($mainFabricName=='1' || $mainId=='1')
			{
				$id=1;
				$className	= "bcgcolor-InvoiceCostFabric";
			}
			
			if(stristr(strtoupper($row["strItemDescription"]),'POC'))
			{
				$id=2;
				$className	= "bcgcolor-InvoiceCostPocketing";
			}			
			/*else
			{
				$id=3;
				$className	= "bcgcolor-InvoiceCostTrim";
			}*/
		}
		else if($mainId==2)
		{
			$id=3;
			$className	= "bcgcolor-InvoiceCostTrim";
		}
		else if($mainId==3)
		{
			$id=3;
			$className	= "bcgcolor-InvoiceCostTrim";
		}
		else if($mainId==4)
		{
			$id = 4;
			$className	= "bcgcolor-InvoiceCostService";
		}
		else if($mainId==5)
		{
			$id = 5;
			$className	= "bcgcolor-InvoiceCostOther";
		}
		else if($mainId==6)
		{
			$id = 4;
			$className	= "bcgcolor-InvoiceCostService";
		}	
		
		 $ResponseXML .= "<Category><![CDATA[" . createCategoryCombo($id)  .  "]]></Category>\n";	 
		 $ResponseXML .= "<ClassName><![CDATA[" . $className  .  "]]></ClassName>\n";	
		 $ResponseXML .= "<Type><![CDATA[" . createTypeCombo(0)  .  "]]></Type>\n";
	}
$ResponseXML .= "</InvoiceCostDetails>";
echo $ResponseXML;
}

function createCombo($intOrigin)
{
	global $db;
	$SQL1		  ="SELECT intOriginNo,strOriginType FROM itempurchasetype where intStatus=1";
	$result1 = $db->RunQuery($SQL1);
	$string='';
	while($row1 = mysql_fetch_array($result1))
	{
		$type = $row1["strOriginType"];
		if(((int)$row1["intOriginNo"])==((int)$intOrigin))
			$string .= "<option selected=\"selected\" value=\"".$row1["intOriginNo"]."\">$type</option>";	
		else
			$string .=  "<option value=\"".$row1["intOriginNo"]."\">$type</option>";
				
			//$string = "<option>123</option>";
	}
		//$string = mysql_num_rows($result1);
		$string = "<select id=\"cboOrigin\" class=\"txtbox keymove\" style=\"width:50px\">$string</select>";
		return $string;
}

function createCategoryCombo($intOrigin)
{
	global $db;
	$SQL1		  ="SELECT intCategoryId,intCategoryName FROM invoicecostingcategory where intStatus=1 order by intOrderId ";
	$result1 = $db->RunQuery($SQL1);
	$string='';
		$string .= "<option selected=\"selected\" value=\""."0"."\">"."Select One"."</option>";	
	while($row1 = mysql_fetch_array($result1))
	{
		$type = $row1["intCategoryName"];
		if(((int)$row1["intCategoryId"])==((int)$intOrigin))
			$string .= "<option selected=\"selected\" value=\"".$row1["intCategoryId"]."\">$type</option>";	
		else
			$string .=  "<option value=\"".$row1["intCategoryId"]."\">$type</option>";
	}
		$string = "<select id=\"cboOrigin\" class=\"txtbox\" style=\"width:80px\" onchange=\"ChangeRowColor(this,this.value)\">$string</select>";
		return $string;
}
function createTypeCombo($type1)
{
	if($type1==0)	
	{
		$string .= "<option selected=\"selected\" value=\"".$type1."\">Item</option>";
		$string .=  "<option value=\""."1"."\">ICNA</option>";
	}
	else
	{
		$string .= "<option selected=\"selected\" value=\"".$type1."\">ICNA</option>";
		$string .=  "<option value=\""."0"."\">Item</option>";
	}
	$string = "<select id=\"cboType\" class=\"txtbox\" style=\"width:60px\" onchange=\"ChangeTypeRowColor(this,this.value)\">$string</select>";
	return $string;
}	
//------------------------------------------------------Invoice Costing List-------------------------------------------------------------	
if($id=="loadInvoiceCosting")
{
$intStatus		= $_GET["intStatus"];
$orderId		= $_GET["OrderId"];
$orderNo		= $_GET["OrderNo"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$limitText = " limit 0,50 ";
		
$ResponseXML .= "<invoiceCosting>";

	$SQL = "SELECT orders.intStyleId,orders.strOrderNo,invoicecostingheader.dblNewCM,invoicecostingheader.strFabric FROM invoicecostingheader INNER JOIN orders ON invoicecostingheader.intStyleId = orders.intStyleId WHERE invoicecostingheader.intStatus =  '$intStatus'";
	
	if($orderId!="")
	$SQL .=" and invoicecostingheader.intStyleId='$orderId'";
	
	if($orderNo!="")
	$SQL .=" and orders.strOrderNo like '%$orderNo%'";
	
	if($cbointStyleId!="")
	$limitText = "";
	
	$SQL.=" ORDER BY invoicecostingheader.intStyleId";
	//echo $SQL;
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{		
		$ResponseXML .= "<intStyleId><![CDATA[" . $row["intStyleId"]  . "]]></intStyleId>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . $row["strOrderNo"]  . "]]></strStyle>\n"; 
		$ResponseXML .= "<strItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></strItemDescription>\n";
		$ResponseXML .= "<strFabric><![CDATA[" . $row["strFabric"]  . "]]></strFabric>\n";
		$ResponseXML .= "<dblNewCM><![CDATA[" . $row["dblNewCM"]  . "]]></dblNewCM>\n";				 
	}
$ResponseXML .= "</invoiceCosting>";
echo $ResponseXML;
}

//----------------------------------------------------List Loading--------------------------------------------------------------------------

if($id=="loadCostHeaderFromInvCostTbl")
{
$styleId	=$_GET["cbointStyleId"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .="<InvoiceCostHeader>";

	$SQL = "SELECT O.strStyle,IH.strOrderNo,O.reaFOB as dblFob,IH.dblQty,IH.strDescription,IH.strFabric,IH.dblNewCM,IH.dblReduceCM,IH.intStatus FROM invoicecostingheader IH INNER JOIN orders O ON IH.intStyleId = O.intStyleId where IH.intStyleId = '$styleId'";			
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<intStyleId><![CDATA[" . $cbointStyleId . "]]></intStyleId>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]. "]]></Status>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . trim($row["strStyle"])  . "]]></strStyle>\n";
		$ResponseXML .= "<strOrderNo><![CDATA[" . trim($row["strOrderNo"])  . "]]></strOrderNo>\n";
		$ResponseXML .= "<dblFob><![CDATA[" . trim($row["dblFob"])  . "]]></dblFob>\n";
		$ResponseXML .= "<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";
		$ResponseXML .= "<fabric><![CDATA[" . trim($row["strFabric"])  . "]]></fabric>\n";
		$ResponseXML .= "<dblNewCM><![CDATA[" . trim($row["dblNewCM"])  . "]]></dblNewCM>\n";
		$ResponseXML .= "<strDescription><![CDATA[" . trim($row["strDescription"])  . "]]></strDescription>\n";
		$ResponseXML .= "<ReduceCM><![CDATA[" . $row["dblReduceCM"] . "]]></ReduceCM>\n";	
	 break;
	}
$ResponseXML .= "</InvoiceCostHeader>";
echo $ResponseXML;
}
elseif($id=="loadCostDetailsFromInvCostTbl")
{
	$cbointStyleId	= $_GET["cbointStyleId"];
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$ResponseXML .="<InvoiceCostDetails>";
	
	$SQL ="SELECT						
		ID.reaConPc,
		ID.reaWastage,
		ID.dblUnitPrice,
		ID.strItemCode,
		MIL.strItemDescription,
		ID.intOrigin,
		ID.strType,
		ID.dblFinance,
		ID.intDifference
		FROM invoicecostingdetails ID INNER JOIN matitemlist MIL ON ID.strItemCode = MIL.intItemSerial					
		WHERE ID.intStyleId = '$cbointStyleId'
		order by MIL.intMainCatID,MIL.strItemDescription";
		
/*	$SQL ="(SELECT						
			ID.reaConPc,
			ID.reaWastage,
			ID.dblUnitPrice,
			ID.strItemCode,
			MIL.strItemDescription,
			ID.intOrigin,
			ID.strType,
			ID.dblFinance,
			ID.intDifference
			FROM invoicecostingdetails ID 
			INNER JOIN matitemlist MIL ON ID.strItemCode = MIL.intItemSerial					
			WHERE ID.intStyleId = '$cbointStyleId')
			union 
			(select OD.reaConPc,
			OD.reaWastage,
			OD.dblUnitPrice,
			OD.intMatDetailID as strItemCode,
			MIL.strItemDescription,
			OD.intOriginNo,
			MIL.intMainCatID+1 as strType,
			0 as dblFinance,
			1 as intDifference
			from orderdetails OD
			INNER JOIN matitemlist MIL ON OD.intMatDetailID = MIL.intItemSerial
			WHERE OD.intStyleId = '$cbointStyleId' and OD.intMatDetailID not in
			( select id.strItemCode from invoicecostingdetails id inner join orderdetails od on
			id.strItemCode = od.intMatDetailID and id.intStyleId = od.intStyleId where id.intStyleId='$cbointStyleId'))
			order by strType,strItemDescription";*/
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<dblUnitPrice><![CDATA[" . trim($row["dblUnitPrice"])  . "]]></dblUnitPrice>\n";	
		$ResponseXML .= "<reaConPc><![CDATA[" . trim($row["reaConPc"])  . "]]></reaConPc>\n";
		$ResponseXML .= "<reaWastage><![CDATA[" . trim($row["reaWastage"])  . "]]></reaWastage>\n";
		$ResponseXML.= "<intItemSerial><![CDATA[" . trim($row["strItemCode"])  . "]]></intItemSerial>\n";
		$ResponseXML.= "<FinancePercent><![CDATA[" . trim($row["dblFinance"])  . "]]></FinancePercent>\n";
		$ResponseXML .= "<strItemDescription><![CDATA[" . trim($row["strItemDescription"])  . "]]></strItemDescription>\n";
		$ResponseXML .= "<strOriginType><![CDATA[" . createCombo($row["intOrigin"])  .  "]]></strOriginType>\n";
		
		 $mainId	= $row["strType"];
		 $className	= "bcgcolor-tblrowWhite";
		
		if($mainId==1)
		 {
		 	$id=1;
			$className	= "bcgcolor-InvoiceCostFabric";
		 }
		 else if($mainId==2)
		 {
		 	$id=2;
			$className	= "bcgcolor-InvoiceCostPocketing";
		 }
		 else if($mainId==3)
		 {
		 	$id=3;
			$className	= "bcgcolor-InvoiceCostTrim";
		 }
		 else if($mainId==4)
		 {
		 	$id = 4;
			$className	= "bcgcolor-InvoiceCostService";
		 }
		 else if($mainId==5)
		 {
		 	$id = 5;
			$className	= "bcgcolor-InvoiceCostOther";
		 }
		 else if($mainId==6)
		 {
		 	$id = 6;
			$className	= "bcgcolor-InvoiceCostOther";
		 }
		 
		 if($row["intDifference"])
		 	$className	= "bcgcolor-InvoiceCostICNA";
			
		 $ResponseXML .= "<Category><![CDATA[" . createCategoryCombo($id)  .  "]]></Category>\n";
		$ResponseXML .= "<ClassName><![CDATA[" . $className  .  "]]></ClassName>\n";
		$ResponseXML .= "<Type><![CDATA[" . createTypeCombo($row["intDifference"])  .  "]]></Type>\n";
	}
	$ResponseXML .= "</InvoiceCostDetails>";
	echo $ResponseXML;
}
elseif($id=="loadOrderNo")
{
$ResponseXML = "<XMLLoadOrderNo>\n";
$styleNo	= $_GET["styleNo"];
	$sql ="SELECT  distinct orders.intStyleId,orders.strOrderNo FROM orders WHERE orders.intStyleId  NOT IN (SELECT invoicecostingheader.intStyleId FROM invoicecostingheader) and orders.strStyle='$styleNo' and intStatus=11 ORDER BY orders.strStyle";
	$result=$db->RunQuery($sql);
		$ResponseXML .="<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .="<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>";
	}
$ResponseXML .= "</XMLLoadOrderNo>";
echo $ResponseXML;
}
elseif($id=="CopyInvoiceCosting")
{
header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
$sourceOrderNo	= GetOrderNo($_GET["sourceOrderNo"]);
$targetOrderNo	= GetOrderNo($_GET["targetOrderNo"]);

$ResponseXML 	= "<XMLCopyInvoiceCosting>\n";
	
	$ResponseXML .= CopyOrder($sourceOrderNo,$targetOrderNo);
	CopyProceses($sourceOrderNo,$targetOrderNo);
	
$ResponseXML   .= "</XMLCopyInvoiceCosting>";
echo $ResponseXML;
}
elseif($id=="URLLoadOrderNoToPopUpSearch")
{
	$sql = "SELECT  distinct orders.strOrderNo FROM orders WHERE orders.intStyleId  NOT IN (SELECT invoicecostingheader.intStyleId FROM invoicecostingheader) and intStatus=11 ORDER BY orders.strStyle";
	$result = $db->RunQuery($sql);	
	while($row=mysql_fetch_array($result))
	{
		$pr_arr.= $row['strOrderNo']."|";
		 
	}
	echo $pr_arr;
}
elseif($id=="URLSetOrderNo")
{
$orderNo = $_GET["OrderNo"];
	$sql = "select intStyleId from orders where strOrderNo='$orderNo'";
	$result = $db->RunQuery($sql);	
	while($row=mysql_fetch_array($result))
	{
		echo $row["intStyleId"];		 
	}
}
elseif($id=="URLLoadSourceOrderNo")
{
	$sql = "select O.strOrderNo from invoicecostingheader IH inner join orders O on O.intStyleId=IH.intStyleId where IH.intStatus <>10";
	$result = $db->RunQuery($sql);	
	while($row=mysql_fetch_array($result))
	{
		$pr_arr.= $row['strOrderNo']."|";
		 
	}
	echo $pr_arr;
}
elseif($id=="URLLoadTargetOrderNo")
{
	$sql = "SELECT O.strOrderNo FROM orders O WHERE O.intStyleId  NOT IN (SELECT invoicecostingheader.intStyleId FROM invoicecostingheader) and  O.intStatus=11 ORDER BY O.strOrderNo";
	$result = $db->RunQuery($sql);	
	while($row=mysql_fetch_array($result))
	{
		$pr_arr.= $row['strOrderNo']."|";
		 
	}
	echo $pr_arr;
}
elseif($id=="URLGetOrderNo")
{
	echo GetOrderNo($_GET["TargetOrderNo"]);	
}
elseif($id=="URLAddItemToMainGrid")
{
$orderNo	= $_GET["OrderNo"];
$itemId	= $_GET["ItemId"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML ="<XMLAddItemToMainGrid>";
$SQL="SELECT distinct	
MIL.strItemDescription,					
OD.reaConPc,
OD.reaWastage,
OD.dblUnitPrice,
OD.dblFreight,
MIL.intItemSerial,
OD.intOriginNo,
MIL.intMainCatID,
MSC.StrCatName,
OD.intMainFabricStatus
FROM
orders O
INNER JOIN orderdetails OD ON O.intStyleId = OD.intStyleId 
INNER JOIN matitemlist MIL ON OD.intMatDetailID = MIL.intItemSerial
inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID
WHERE
OD.intStyleId	= '$orderNo' and OD.intMatDetailID in ($itemId)
order by MIL.intMainCatID,MIL.strItemDescription";
//echo $SQL;
$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<dblUnitPrice><![CDATA[" . round($row["dblUnitPrice"]+$row["dblFreight"],4)  . "]]></dblUnitPrice>\n";	
		 $ResponseXML .= "<reaConPc><![CDATA[" . round($row["reaConPc"]*12,4)  . "]]></reaConPc>\n";
		 $ResponseXML .= "<reaWastage><![CDATA[" . trim($row["reaWastage"])  . "]]></reaWastage>\n";
		 $ResponseXML .= "<FinancePercent><![CDATA[" . "0" . "]]></FinancePercent>\n";
		 $ResponseXML .= "<intItemSerial><![CDATA[" . trim($row["intItemSerial"])  . "]]></intItemSerial>\n";
		 $ResponseXML .= "<strItemDescription><![CDATA[" . trim($row["strItemDescription"])  . "]]></strItemDescription>\n";
		 $ResponseXML .= "<strOriginType><![CDATA[" . createCombo($row["intOriginNo"])  .  "]]></strOriginType>\n";
		 
		 $subCatName		= substr($row["StrCatName"],0,9);
		 $mainFabricName 	= $row["intMainFabricStatus"];
		 $mainId			= $row["intMainCatID"];
		 $className			= "bcgcolor-tblrowWhite";
		 //ChangeClassByCategory($mainId,$subCatName,$mainFabricName);	
		 
		if($mainId==1)
		{
			if(strtoupper($subCatName)=="POCKETING")
			{
				$id=2;
				$className	= "bcgcolor-InvoiceCostPocketing";
			}
			elseif($mainFabricName)
			{
				$id=1;
				$className	= "bcgcolor-InvoiceCostFabric";
			}
			else
			{
				$id=3;
				$className	= "bcgcolor-InvoiceCostTrim";
			}
		}
		else if($mainId==2)
		{
			$id=3;
			$className	= "bcgcolor-InvoiceCostTrim";
		}
		else if($mainId==3)
		{
			$id=3;
			$className	= "bcgcolor-InvoiceCostTrim";
		}
		else if($mainId==4)
		{
			$id = 4;
			$className	= "bcgcolor-InvoiceCostService";
		}
		else if($mainId==5)
		{
			$id = 5;
			$className	= "bcgcolor-InvoiceCostOther";
		}
		else if($mainId==6)
		{
			$id = 6;
			$className	= "bcgcolor-InvoiceCostOther";
		}
		
		 $ResponseXML .= "<Category><![CDATA[" . createCategoryCombo($id)  .  "]]></Category>\n";	 
		 $ResponseXML .= "<ClassName><![CDATA[" . $className  .  "]]></ClassName>\n";	
		 $ResponseXML .= "<Type><![CDATA[" . createTypeCombo(0)  .  "]]></Type>\n";
	}
$ResponseXML .= "</XMLAddItemToMainGrid>";
echo $ResponseXML;
}

function CopyOrder($sourceOrderNo,$targetOrderNo)
{
	//CopyTargetStyleFromOrders($targetOrderNo);
	$result_t = GetTargetOrderData($targetOrderNo);
	//$result_s = GetSourceOrderData($sourceOrderNo);	
	while($row_t=mysql_fetch_array($result_t))
	{
		$t_originNo		= $row_t["intOriginNo"];	
		$t_matDetailId	= $row_t["intMatDetailID"];
		$t_conPc		= round($row_t["reaConPc"]*12,4);
		$t_wastage		= $row_t["reaWastage"];
		$t_unitPrice	= $row_t["dblUnitPrice"]+$row_t["dblFreight"];
		$t_description	= $row_t["strItemDescription"];
		$t_subCatName	= $row_t["StrCatName"];
		$t_mainCatId	= $row_t["intMainCatID"];
		$booSAvailable 	= false;		
		$result_s 		= GetSourceOrderData($sourceOrderNo,$t_matDetailId);
		while($row_s=mysql_fetch_array($result_s))
		{
			$booSAvailable 	= true;
			$s_originNo		= $row_s["intOrigin"];
			$s_matDetailId	= $row_s["strItemCode"];
			$s_conPc		= $row_s["reaConPc"];
			$s_wastage		= $row_s["reaWastage"];
			$s_unitPrice	= $row_s["dblUnitPrice"];
			$s_FinanceP		= $row_s["dblFinance"];			
		}
		$subCatName		= substr($t_subCatName,0,9);
		$mainId			= $t_mainCatId;
		$className		= "bcgcolor-tblrowWhite";
		$type			= 0;
		$mainFabricName = $row_t["intMainFabricStatus"];
		//ChangeClassByCategory($mainId,$subCatName,$mainFabricName);
		if($mainId==1)
		{
			/*if(strtoupper($subCatName)=="POCKETING")
			{
				$id=2;
				$className	= "bcgcolor-InvoiceCostPocketing";
			}*/
			if(stristr(strtoupper($t_description),'POC'))
			{
				$id=2;
				$className	= "bcgcolor-InvoiceCostPocketing";
			}
			elseif($mainFabricName)
			{
				$id=1;
				$className	= "bcgcolor-InvoiceCostFabric";
			}
			else
			{
				$id=3;
				$className	= "bcgcolor-InvoiceCostTrim";
			}
		}
		else if($mainId==2)
		{
			$id=3;
			$className	= "bcgcolor-InvoiceCostTrim";
		}
		else if($mainId==3)
		{
			$id=3;
			$className	= "bcgcolor-InvoiceCostTrim";
		}
		else if($mainId==4)
		{
			$id = 4;
			$className	= "bcgcolor-InvoiceCostService";
		}
		else if($mainId==5)
		{
			$id = 5;
			$className	= "bcgcolor-InvoiceCostOther";
		}
		else if($mainId==6)
		{
			$id = 6;
			$className	= "bcgcolor-InvoiceCostOther";
		}
		//echo "$t_conPc&nbsp;$s_conPc";
		//break;
		if($booSAvailable)
		{
			$unitPrice	   = $s_unitPrice;
			$conPc		   = $s_conPc;
			$wastage	   = $s_wastage;
			//if($t_conPc!=$s_conPc)
			//{
				//$className 	= "bcgcolor-InvoiceCostICNA";
				//$conPc 		= $t_conPc;
				//$type		= 1;
			//}
			//elseif($t_wastage!=$s_wastage)
			//{
				//$className 	= "bcgcolor-InvoiceCostICNA";
				//$wastage	= $t_wastage;
				//$type		= 1;
			//}
			//elseif($t_unitPrice!=$s_unitPrice)
			//{
				//$className 	= "bcgcolor-InvoiceCostICNA";
				//$unitPrice 	= $t_unitPrice;
				//$type		= 1;
			//}
				
			$ResponseXML .= "<dblUnitPrice><![CDATA[" . $unitPrice  . "]]></dblUnitPrice>\n";	
			$ResponseXML .= "<reaConPc><![CDATA[" . $conPc  . "]]></reaConPc>\n";
			$ResponseXML .= "<reaWastage><![CDATA[" . $wastage  . "]]></reaWastage>\n";
			$ResponseXML .= "<FinancePercent><![CDATA[" . $s_FinanceP . "]]></FinancePercent>\n";
			$ResponseXML .= "<intItemSerial><![CDATA[" . $s_matDetailId  . "]]></intItemSerial>\n";
			$ResponseXML .= "<strItemDescription><![CDATA[" . $t_description  . "]]></strItemDescription>\n";
			$ResponseXML .= "<strOriginType><![CDATA[" . createCombo($s_originNo)  .  "]]></strOriginType>\n";
		}
		else
		{
			$ResponseXML .= "<dblUnitPrice><![CDATA[" . $t_unitPrice  . "]]></dblUnitPrice>\n";	
			$ResponseXML .= "<reaConPc><![CDATA[" . $t_conPc  . "]]></reaConPc>\n";
			$ResponseXML .= "<reaWastage><![CDATA[" . $t_wastage  . "]]></reaWastage>\n";
			$ResponseXML .= "<FinancePercent><![CDATA[" . "0" . "]]></FinancePercent>\n";
			$ResponseXML .= "<intItemSerial><![CDATA[" . $t_matDetailId  . "]]></intItemSerial>\n";
			$ResponseXML .= "<strItemDescription><![CDATA[" . $t_description  . "]]></strItemDescription>\n";
			$ResponseXML .= "<strOriginType><![CDATA[" . createCombo($t_originNo)  .  "]]></strOriginType>\n";
			$className 	  = "bcgcolor-InvoiceCostICNA";
			$type		  = 1;
		}
			$ResponseXML .= "<Category><![CDATA[" . createCategoryCombo($id)  .  "]]></Category>\n";	 
			$ResponseXML .= "<ClassName><![CDATA[" . $className  .  "]]></ClassName>\n";
			$ResponseXML .= "<Type><![CDATA[" . createTypeCombo($type)  .  "]]></Type>\n";
	}
return $ResponseXML;
}

function GetTargetOrderData($targetOrderNo)
{
	global $db;
	$sql="select OD.intOriginNo,OD.intMatDetailID,OD.reaConPc,OD.reaWastage,OD.dblUnitPrice,OD.dblFreight,MIL.strItemDescription,MSC.StrCatName,MIL.intMainCatID,OD.intMainFabricStatus
		  from orderdetails OD
		  inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID
		  inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID
		  where intStyleId='$targetOrderNo'
		  order by MIL.intMainCatID,MIL.strItemDescription";
	return $db->RunQuery($sql);
}

function GetSourceOrderData($sourceOrderNo,$s_matDetailId)
{
	global $db;
	$sql="select intOrigin,strItemCode,reaConPc,reaWastage,dblUnitPrice,dblFinance from invoicecostingdetails where intStyleId='$sourceOrderNo' and strItemCode='$s_matDetailId'";
	return $db->RunQuery($sql);
	
}

function ChangeClassByCategory($mainId,$subCatName,$mainFabricName)
{
	if($mainId==1)
	{
		if(strtoupper($subCatName)=="POCKETING")
		{
			$id=2;
			$className	= "bcgcolor-InvoiceCostPocketing";
		}
		elseif($mainFabricName)
		{
			$id=1;
			$className	= "bcgcolor-InvoiceCostFabric";
		}
		else
		{
			$id=3;
			$className	= "bcgcolor-InvoiceCostTrim";
		}
	}
	else if($mainId==2)
	{
		$id=3;
		$className	= "bcgcolor-InvoiceCostTrim";
	}
	else if($mainId==3)
	{
		$id=3;
		$className	= "bcgcolor-InvoiceCostTrim";
	}
	else if($mainId==4)
	{
		$id = 4;
		$className	= "bcgcolor-InvoiceCostService";
	}
	else if($mainId==5)
	{
		$id = 5;
		$className	= "bcgcolor-InvoiceCostOther";
	}
	else if($mainId==6)
	{
		$id = 6;
		$className	= "bcgcolor-InvoiceCostOther";
	}
}

function GetOrderNo($orderNo)
{
global $db;
	$sql="select intStyleId from orders where strOrderNo='$orderNo';";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		return $row["intStyleId"];
	}

}

function CopyProceses($sourceOrderNo,$targetOrderNo)
{
global $db;
	$sql="insert into invoicecostingproceses (intStyleId,intProcessId,dblUnitPrice)select $targetOrderNo,intProcessId,dblUnitPrice from invoicecostingproceses where intStyleId='$sourceOrderNo';";
	$result = $db->RunQuery($sql);
}

	$sql = $_GET["loadOrderNo"];
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$id = $row[0];
		$name= $row[1];
		$value.="<option value=\"$id\">".cdata($name)."</option>";
	}
	 
	 echo $value;
?>