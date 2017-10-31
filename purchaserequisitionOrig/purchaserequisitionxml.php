<?php
/*BEGIN - PR status
0	= Pending and not send for the approval.
1	= send to factory approval.
2	= factory approved and send to HO approval.
3	= HO approved and ready for raised the General Purchade Order.
END - PR status*/
include "../Connector.php";
$requestType 	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];

if($requestType=="URLLoadCurrencyRate")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadCurrencyRate>\n";
$currId = $_GET["CurrId"];
	$budgetBaseCurrency = GetBudgerBaseCurrency();
	$baseCurrencyExRate = GetBaseCurrencyExRate($budgetBaseCurrency);
	$sql="select rate from exchangerate where currencyID=$currId and intStatus=1";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($budgetBaseCurrency<>$currId)
			$rate = ((1/$row["rate"])*$baseCurrencyExRate);
		else
			$rate = 1;
		$ResponseXML .= "<Rate><![CDATA[" . round($rate,6) . "]]></Rate>\n";	
	}
$ResponseXML .= "</XMLLoadCurrencyRate>\n";
echo $ResponseXML;
}
elseif($requestType=="URLLoadSubCategory")
{

$mainCat = $_GET["MainCat"];
	$sql="select intSubCatNo,StrCatName from genmatsubcategory where intStatus=1 and intCatNo=$mainCat order by StrCatName";
	$result=$db->RunQuery($sql);
		echo "<option value="."".">"."All"."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=".$row["intSubCatNo"].">".$row["StrCatName"]."</option>\n";
	}

}
elseif($requestType=="URLLoadPopItems")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLURLLoadPopItems>";

$mainCat 	= $_GET["MainCat"];
$subCat 	= $_GET["SubCat"];
$itemDesc 	= $_GET["ItemDesc"];
	$sql="select intMainCatID,intItemSerial,strItemDescription,strUnit from genmatitemlist where intStatus=1 ";
if($mainCat!="")	
	$sql .= "and intMainCatID=$mainCat ";
if($subCat!="")
	$sql .= "and intSubCatID=$subCat ";
if($itemDesc!="")
	$sql .= "and strItemDescription like '%$itemDesc%' ";
	
	$sql .= "order by strItemDescription ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<MainCatId><![CDATA[" . $row["intMainCatID"]  . "]]></MainCatId>\n";
		$ResponseXML .= "<ItemId><![CDATA[" . $row["intItemSerial"]  . "]]></ItemId>\n";	
		$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";	
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";	
	}
$ResponseXML .= "</XMLURLLoadPopItems>\n";
echo $ResponseXML;
}
elseif($requestType=="URLLoadDetailsToItemTbl")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadDetailsToItemTbl>";

$itemId 	= $_GET["ItemId"];
$costCenter	= $_GET["CostCenter"];

	$sql="select GMIL.intItemSerial,GMIL.strItemDescription,GMIL.strUnit,GMIL.dblLastPrice,DATE_FORMAT(GMIL.dtmDate,'%d-%m-%Y ')as priceDate,GMIL.dtmDate,GMIL.intMainCatID,COALESCE((select sum(dblQty) from genstocktransactions GST where strMainStoresID=$companyId and intMatDetailId=$itemId),0)as stockBal,COALESCE((select dblReorderLevel from genitemwisereorderlevel where intMatDetailID='$itemId' and intCostCenterId='$costCenter'),0)as dblReorderLevel  from genmatitemlist GMIL where GMIL.intItemSerial=$itemId ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<ItemId><![CDATA[" . $row["intItemSerial"]  . "]]></ItemId>\n";	
		$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";	
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		$ResponseXML .= "<UPrice><![CDATA[" . round($row["dblLastPrice"],4)  . "]]></UPrice>\n";
		$ResponseXML .= "<FUPriceDate><![CDATA[" . $row["priceDate"]  . "]]></FUPriceDate>\n";
		$ResponseXML .= "<UPriceDate><![CDATA[" . $row["dtmDate"]  . "]]></UPriceDate>\n";
		$ResponseXML .= "<MainCat><![CDATA[" . $row["intMainCatID"]  . "]]></MainCat>\n";
		$ResponseXML .= "<MainCat><![CDATA[" . $row["intMainCatID"]  . "]]></MainCat>\n";
		$ResponseXML .= "<ReorderLevel><![CDATA[" . $row["dblReorderLevel"]  . "]]></ReorderLevel>\n";
		$ResponseXML .= "<StockBal><![CDATA[" . $row["stockBal"]  . "]]></StockBal>\n";
	}
$ResponseXML .= "</XMLLoadDetailsToItemTbl>\n";
echo $ResponseXML;
}
elseif($requestType=="URLLoadDetailsToGLTbl")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadDetailsToItemTbl>";

$costCenter 	= $_GET["CostCenter"];
$itemId 		= $_GET["ItemId"];

	$sql="select BAMC.intGlId,GA.strAccID,GA.strDescription,C.strCode,GF.GLAccAllowNo
from budget_glallocationtomaincategory BAMC 
inner join glaccounts GA on GA.intGLAccID = BAMC.intGlId 
inner join glallowcation GF on GF.GLAccNo=GA.intGLAccID
inner join costcenters C on C.intCostCenterId=GF.FactoryCode
where intMatCatId=$itemId  and GF.FactoryCode=$costCenter ";
//echo $sql;
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$year = date("Y");
		$month = date("m");
		$amount		  = GetBudgetAmount($row["GLAccAllowNo"],$year,$month,0,0);
		$ResponseXML .= "<GlID><![CDATA[" . $row["GLAccAllowNo"]  . "]]></GlID>\n";	
		$ResponseXML .= "<GlDesc><![CDATA[" . $row["strDescription"]  . "]]></GlDesc>\n";	
		$ResponseXML .= "<GlCode><![CDATA[" . CreateGlCode($row["strAccID"],$row["strCode"])  . "]]></GlCode>\n";
		$ResponseXML .= "<ModAmount><![CDATA[" . $amount[0] . "]]></ModAmount>\n";
		$ResponseXML .= "<AddAmount><![CDATA[" . $amount[1] . "]]></AddAmount>\n";
		$ResponseXML .= "<TransInAmount><![CDATA[" . $amount[2] . "]]></TransInAmount>\n";
		$ResponseXML .= "<BalAmount><![CDATA[" . $amount[3] . "]]></BalAmount>\n";
		$ResponseXML .= "<ActualAmount><![CDATA[" . $amount[4] . "]]></ActualAmount>\n";
		$ResponseXML .= "<Varience><![CDATA[" . ($amount[3]-$amount[4]) . "]]></Varience>\n";
		$ResponseXML .= "<Requested><![CDATA[" . $amount[5] . "]]></Requested>\n";
		$ResponseXML .= "<Pending><![CDATA[" . $amount[6] . "]]></Pending>\n";
	}
$ResponseXML .= "</XMLLoadDetailsToItemTbl>\n";
echo $ResponseXML;
}
elseif($requestType=="URLLoadSuppDetails")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadSuppDetails>";

$suppId 	= $_GET["SuppId"];

	$sql="select strCurrency from suppliers where strSupplierID=$suppId ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<CurrId><![CDATA[" . $row["strCurrency"]  . "]]></CurrId>\n";	
	}
$ResponseXML .= "</XMLLoadSuppDetails>\n";
echo $ResponseXML;
}
elseif($requestType=="RemoveFile")
{
	$url	= $_GET["url"];
	$fh = fopen($url, 'a');
	fclose($fh);	
	unlink($url);
}
elseif($requestType=="URLLoadSaved_Header")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadSaved_Header>";
$year 	= $_GET["Year"];
$no 	= $_GET["No"];
	$sql="select PRH.strPRNo,PRH.intSupplierId,PRH.intCurrencyId,PRH.intDepartmentId,PRH.intCostCenterId,PRH.strAttension,PRH.strRemarks,PRH.strJobNo,PRH.intStatus,PRH.intJobType from purchaserequisition_header PRH where PRH.intPRNo='$no' and PRH.intPRYear='$year';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{	
		$ResponseXML .= "<PRNo><![CDATA[" . $row["strPRNo"]  . "]]></PRNo>\n";
		$ResponseXML .= "<SerialNo><![CDATA[" . $year.'/'.$no  . "]]></SerialNo>\n";
		$ResponseXML .= "<SuppId><![CDATA[" . $row["intSupplierId"]  . "]]></SuppId>\n";	
		$ResponseXML .= "<CurrId><![CDATA[" . $row["intCurrencyId"]  . "]]></CurrId>\n";
		$ResponseXML .= "<DeptId><![CDATA[" . $row["intDepartmentId"]  . "]]></DeptId>\n";
		$ResponseXML .= "<CostCenterId><![CDATA[" . $row["intCostCenterId"]  . "]]></CostCenterId>\n";
		$ResponseXML .= "<Attension><![CDATA[" . $row["strAttension"]  . "]]></Attension>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$ResponseXML .= "<JobNo><![CDATA[" . $row["strJobNo"]  . "]]></JobNo>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		$ResponseXML .= "<JobType><![CDATA[" . $row["intJobType"]  . "]]></JobType>\n";
	}
$ResponseXML .= "</XMLLoadSaved_Header>";
echo $ResponseXML;
}
elseif($requestType=="URLLoadSaved_details")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<LoadSaved_details>";
$year 	= $_GET["Year"];
$no 	= $_GET["No"];
	$sql="select PRD.intMatDetailId,MIL.strItemDescription,PRD.strUnit,PRD.dblUnitPrice,MIL.intMainCatID,MIL.dblReorderLevel,PRD.dblQty,PRD.dblDiscount,DATE_FORMAT(MIL.dtmDate,'%d-%m-%Y ')as formatedDate,MIL.dtmDate,intGLAllowId from purchaserequisition_details PRD
	inner join genmatitemlist MIL on MIL.intItemSerial=PRD.intMatDetailId where PRD.intPRNo='$no' and PRD.intPRYear='$year';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{	
		$ResponseXML .= "<DetailId><![CDATA[" . $row["intMatDetailId"]  . "]]></DetailId>\n";	
		$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";
		$ResponseXML .= "<UnitId><![CDATA[" . $row["strUnit"]  . "]]></UnitId>\n";
		$ResponseXML .= "<UPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></UPrice>\n";
		$ResponseXML .= "<MainCat><![CDATA[" . $row["intMainCatID"]  . "]]></MainCat>\n";
		$ResponseXML .= "<ReorderLevel><![CDATA[" . $row["dblReorderLevel"]  . "]]></ReorderLevel>\n";
		$ResponseXML .= "<StockBal><![CDATA[" . GetItemWiseStockQty($row["intMatDetailId"])  . "]]></StockBal>\n";
		$ResponseXML .= "<OrderQty><![CDATA[" . $row["dblQty"] . "]]></OrderQty>\n";
		$ResponseXML .= "<DisPercent><![CDATA[" . $row["dblDiscount"] . "]]></DisPercent>\n";
		$ResponseXML .= "<FormatedDate><![CDATA[" . $row["formatedDate"] . "]]></FormatedDate>\n";
		$ResponseXML .= "<Date><![CDATA[" . $row["dtmDate"] . "]]></Date>\n";
		$ResponseXML .= "<GLAllowId><![CDATA[" . $row["intGLAllowId"] . "]]></GLAllowId>\n";
	}
$ResponseXML .= "</LoadSaved_details>";
echo $ResponseXML;
}
elseif($requestType=="URLLoadSaved_GLdetails")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<LoadSaved_details>";
$year 	= $_GET["Year"];
$no 	= $_GET["No"];
	$sql="select PRH.intPRNo,PRH.intPRYear,PRGD.intMainCatId,PRGD.intGLAllowId,G.strAccID,C.strCode,G.strDescription,MONTH(dtmCreatedDate)as createMonth,YEAR(dtmCreatedDate)as createYear from purchaserequisition_gldetails PRGD inner join purchaserequisition_header PRH on PRH.intPRNo=PRGD.intPRNo and PRH.intPRYear=PRGD.intPRYear inner join glallowcation GA on GA.GLAccAllowNo=PRGD.intGLAllowId inner join glaccounts G on G.intGLAccID=GA.GLAccNo inner join costcenters C on C.intCostCenterId=GA.FactoryCode where PRGD.intPRNo='$no' and PRGD.intPRYear='$year';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{	
		$year 		  = $row["createYear"];
		$month 		  = $row["createMonth"];
		$amount		  = GetBudgetAmount($row["intGLAllowId"],$year,$month,$row["intPRYear"],$row["intPRNo"]);
		$ResponseXML .= "<MainCatId><![CDATA[" . $row["intMainCatId"]  . "]]></MainCatId>\n";
		$ResponseXML .= "<GlID><![CDATA[" . $row["intGLAllowId"]  . "]]></GlID>\n";	
		$ResponseXML .= "<GlDesc><![CDATA[" . $row["strDescription"]  . "]]></GlDesc>\n";	
		$ResponseXML .= "<GlCode><![CDATA[" . CreateGlCode($row["strAccID"],$row["strCode"])  . "]]></GlCode>\n";
		$ResponseXML .= "<ModAmount><![CDATA[" . $amount[0] . "]]></ModAmount>\n";
		$ResponseXML .= "<AddAmount><![CDATA[" . $amount[1] . "]]></AddAmount>\n";
		$ResponseXML .= "<TransInAmount><![CDATA[" . $amount[2] . "]]></TransInAmount>\n";
		$ResponseXML .= "<BalAmount><![CDATA[" . $amount[3] . "]]></BalAmount>\n";
		$ResponseXML .= "<ActualAmount><![CDATA[" . $amount[4] . "]]></ActualAmount>\n";
		$ResponseXML .= "<Varience><![CDATA[" . ($amount[3]-$amount[4]) . "]]></Varience>\n";
		$ResponseXML .= "<Requested><![CDATA[" . $amount[5] . "]]></Requested>\n";
		$ResponseXML .= "<Pending><![CDATA[" . $amount[6] . "]]></Pending>\n";
	}
$ResponseXML .= "</LoadSaved_details>";
echo $ResponseXML;
}
elseif($requestType=="URLLoadDetailsToGLTbl_Multiple")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadDetailsToItemTbl>";

$costCenter 	= $_GET["CostCenter"];
$itemId 		= $_GET["ItemId"];

	$sql="select BAMC.intGlId,GA.strAccID,GA.strDescription,C.strCode,GF.GLAccAllowNo
from budget_glallocationtomaincategory BAMC 
inner join glaccounts GA on GA.intGLAccID = BAMC.intGlId 
inner join glallowcation GF on GF.GLAccNo=GA.intGLAccID
inner join costcenters C on C.intCostCenterId=GF.FactoryCode
where GF.GLAccAllowNo=$itemId  and GF.FactoryCode=$costCenter ";
//echo $sql;
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$year = date("Y");
		$month = date("m");
		$amount		  = GetBudgetAmount($row["GLAccAllowNo"],$year,$month,0,0);
		$ResponseXML .= "<GlID><![CDATA[" . $row["GLAccAllowNo"]  . "]]></GlID>\n";	
		$ResponseXML .= "<GlDesc><![CDATA[" . $row["strDescription"]  . "]]></GlDesc>\n";	
		$ResponseXML .= "<GlCode><![CDATA[" . CreateGlCode($row["strAccID"],$row["strCode"])  . "]]></GlCode>\n";
		$ResponseXML .= "<ModAmount><![CDATA[" . $amount[0] . "]]></ModAmount>\n";
		$ResponseXML .= "<AddAmount><![CDATA[" . $amount[1] . "]]></AddAmount>\n";
		$ResponseXML .= "<TransInAmount><![CDATA[" . $amount[2] . "]]></TransInAmount>\n";
		$ResponseXML .= "<BalAmount><![CDATA[" . $amount[3] . "]]></BalAmount>\n";
		$ResponseXML .= "<ActualAmount><![CDATA[" . $amount[4] . "]]></ActualAmount>\n";
		$ResponseXML .= "<Varience><![CDATA[" . ($amount[3]-$amount[4]) . "]]></Varience>\n";
		$ResponseXML .= "<Requested><![CDATA[" . $amount[5] . "]]></Requested>\n";
		$ResponseXML .= "<Pending><![CDATA[" . $amount[6] . "]]></Pending>\n";
	}
$ResponseXML .= "</XMLLoadDetailsToItemTbl>\n";
echo $ResponseXML;
}
elseif($requestType=="URLLoadDetailsToItemTbl_Multiple")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadDetailsToItemTbl>";

$itemId 	= $_GET["ItemId"];
$costCenter	= $_GET["CostCenter"];

	$sql="select GMIL.intItemSerial,GMIL.strItemDescription,GMIL.strUnit,GMIL.dblLastPrice,DATE_FORMAT(GMIL.dtmDate,'%d-%m-%Y ')as priceDate,GMIL.dtmDate,GMIL.intMainCatID,COALESCE((select sum(dblQty) 
	from genstocktransactions GST 
	where strMainStoresID=$companyId and intMatDetailId=$itemId),0)as stockBal,COALESCE((select dblReorderLevel from genitemwisereorderlevel 
	where intMatDetailID='$itemId' and intCostCenterId='$costCenter'),0)as dblReorderLevel  
	from genmatitemlist GMIL where GMIL.intItemSerial=$itemId ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<ItemId><![CDATA[" . $row["intItemSerial"]  . "]]></ItemId>\n";	
		$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";	
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		$ResponseXML .= "<UPrice><![CDATA[" . round($row["dblLastPrice"],4)  . "]]></UPrice>\n";
		$ResponseXML .= "<FUPriceDate><![CDATA[" . $row["priceDate"]  . "]]></FUPriceDate>\n";
		$ResponseXML .= "<UPriceDate><![CDATA[" . $row["dtmDate"]  . "]]></UPriceDate>\n";
		$ResponseXML .= "<MainCat><![CDATA[" . $row["intMainCatID"]  . "]]></MainCat>\n";
		$ResponseXML .= "<MainCat><![CDATA[" . $row["intMainCatID"]  . "]]></MainCat>\n";
		$ResponseXML .= "<ReorderLevel><![CDATA[" . $row["dblReorderLevel"]  . "]]></ReorderLevel>\n";
		$ResponseXML .= "<StockBal><![CDATA[" . $row["stockBal"]  . "]]></StockBal>\n";
	}
$ResponseXML .= "</XMLLoadDetailsToItemTbl>\n";
echo $ResponseXML;
}
//BEGIN - Functions
function CreateGlCode($glId,$facid)
{
	return $glId."-".$facid;
}
//End - Functions

function GetBudgetAmount($glAlloNo,$year,$month,$prYear,$prNo)
{
global $db;
$amount = array();
	$sql = "select COALESCE((select sum(dblQty) from budget_transaction where  strType='bgtmod' and intGLNO=$glAlloNo and intBudgetYear='$year' and intBudgetMonth='$month' group by intGLNO,intBudgetYear,intBudgetMonth),0) as modAmount,
COALESCE((select sum(dblQty) from budget_transaction where  strType='bgtAddi' and intGLNO=$glAlloNo and intBudgetYear='$year' and intBudgetMonth='$month' group by intGLNO,intBudgetYear,intBudgetMonth),0) as addAmount,
COALESCE((select sum(dblQty) from budget_transaction where  strType='bgttransin' and intGLNO=$glAlloNo and intBudgetYear='$year' and intBudgetMonth='$month' group by intGLNO,intBudgetYear,intBudgetMonth),0) as transInAmount,
COALESCE((select sum(dblQty) from budget_transaction where intGLNO=$glAlloNo and intBudgetYear='$year' and intBudgetMonth='$month'
group by intGLNO,intBudgetYear,intBudgetMonth),0) as balAmount,
COALESCE((select sum(dblActual) from budget_modification_details where intYear='$year' and intMonth='$month' and intAlloGLNo=$glAlloNo),0)as actualAmount,
COALESCE((select sum(dblQty) from budget_transaction where strType in('bgtPR','CbgtPR') and intGLNO=$glAlloNo and intBudgetYear='$year' and intBudgetMonth='$month' group by intGLNO,intBudgetYear,intBudgetMonth),0) as requested,
COALESCE((select sum(dblQty) from budget_transaction_temp where strType='bgtPR' and intGLNO=$glAlloNo and intBudgetYear='$year' and intBudgetMonth='$month' ";
if($prNo!='0')
	$sql .= "and intDocumentNo<>'$prNo' and intSerialYear='$prYear' ";
$sql .= "group by intGLNO,intBudgetYear,intBudgetMonth),0) as pending;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$amount[0] = $row["modAmount"];
		$amount[1] = $row["addAmount"];
		$amount[2] = $row["transInAmount"];
		$amount[3] = $row["balAmount"];
		$amount[4] = $row["actualAmount"];
		$amount[5] = abs($row["requested"]);
		$amount[6] = abs($row["pending"]);
	}
return $amount;
}

function GetBudgerBaseCurrency()
{
global $db;
	$sql="select intBudgetBaseCurrency from systemconfiguration;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["intBudgetBaseCurrency"];
	}
}

function GetBaseCurrencyExRate($budgetBaseCurrency)
{
global $db;
$rate = 0;
	$sql="select rate from  exchangerate where currencyID='$budgetBaseCurrency' and intStatus=1;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$rate = $row["rate"];
	}
	return $rate;
}

function GetItemWiseStockQty($itemId)
{
global $db;
global $companyId;
$qty = 0;
	$sql="select COALESCE(sum(dblQty),0)as stockBal from genstocktransactions GST where strMainStoresID=$companyId and intMatDetailId=$itemId;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["stockBal"];
	}
return $qty;
}
?>