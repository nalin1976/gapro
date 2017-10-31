<?php
include "../Connector.php";
include "../HeaderConnector.php";
include "../permissionProvider.php";
$xml = simplexml_load_file("../config.xml");
$XMLAllowableMainCategoryId = $xml->BulkPurchaseOrder->AllowableMainCategoryId;

$id=$_GET["id"];

if($id=="loadMainCategory")
{	
	$SQL="SELECT intID,strDescription FROM matmaincategory where intID in($XMLAllowableMainCategoryId) ORDER BY intID";			
	$result = $db->RunQuery($SQL);	
	while($row = mysql_fetch_array($result))
	{
		 echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
	}
}

if($id=="loadSubCategory")
{	
$intMainCatId = $_GET["mainCatId"];
$allowableSubCaterorise = GetAllowableSubCaterorise(); //this subcategories define by system administrator		
		
	$SQL="SELECT intSubCatNo,StrCatName FROM matsubcategory WHERE intCatNo =$intMainCatId and intSubCatNo in($allowableSubCaterorise) ORDER BY StrCatName";	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
	}
}
if($id=="getSuppliers")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML="";
	$ResponseXML .= "<suppliers>\n";

	global $db;
	$sql="SELECT strTitle,strSupplierID FROM suppliers s where intStatus='1' ORDER BY s.strTitle;";
	$result=$db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$ResponseXML .= "<SupID><![CDATA[" . $row["strSupplierID"]. "]]></SupID>\n";
			$ResponseXML .= "<Supplier><![CDATA[" . $row["strTitle"]. "]]></Supplier>\n";
		}
	$ResponseXML .= "</suppliers>\n";
	echo $ResponseXML;
}

if($id=="loadMaterial")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML 	= "<matSubCategory>";
$mainCatId 		= trim($_GET["mainCatId"]);
$subCatId 		= trim($_GET["subCatId"]);
$txtDetailsLike = trim($_GET["txtDetailsLike"]);
$popAll			= trim($_GET["popAll"]);
$supplier		= trim($_GET["supplier"]);
$allowableSubCaterorise = GetAllowableSubCaterorise(); //this subcategories define by system administrator
		
	if($popAll=="false")
	{
		$SQL="SELECT matitemlist.intItemSerial,strItemDescription,strUnit FROM matitemlist inner join supplierwitem on supplierwitem.intItemSerial=matitemlist.intItemSerial WHERE intMainCatID =$mainCatId and matitemlist.intStatus=1 and supplierwitem.intSupplierID='$supplier'";
		
		if($subCatId!="")
			$SQL .="  AND intSubCatID =$subCatId ";
		if($txtDetailsLike!="")
			$SQL .="  AND strItemDescription like '%$txtDetailsLike%' ";
		if($subCatId=="")	
			$SQL .="  AND intSubCatID in ($allowableSubCaterorise) ";
		
			$SQL.="  ORDER BY strItemDescription";
	}
	else
	{
		$SQL="SELECT intItemSerial,strItemDescription,strUnit FROM matitemlist WHERE intMainCatID =$mainCatId and intStatus=1 ";
		
		if($subCatId!="")
			$SQL .="  AND intSubCatID =$subCatId ";
		if($txtDetailsLike!="")
			$SQL .="  AND strItemDescription like '%$txtDetailsLike%' ";
		if($subCatId=="")	
			$SQL .="  AND intSubCatID in ($allowableSubCaterorise) ";
			
			$SQL.="  ORDER BY strItemDescription";
	}
	//echo 	$SQL;	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<intItemSerial><![CDATA[" . $row["intItemSerial"]  . "]]></intItemSerial>\n";
		 $ResponseXML .= "<strItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></strItemDescription>\n";  
		 $ResponseXML .= "<strUnit><![CDATA[" . $row["strUnit"]  . "]]></strUnit>\n";  
	}
$ResponseXML .= "</matSubCategory>";
echo $ResponseXML;
}

if($id=="loadColor")
{	
		$SQL="SELECT distinct strColor FROM colors ORDER BY strColor";
		$result = $db->RunQuery($SQL);
		while($row = mysql_fetch_array($result))
		{
			 $text .= "<option>" . $row["strColor"]  ."</option>\n";
		}
		echo $text;
}

if($id=="loadSize")
{	
		$SQL="SELECT distinct strSize FROM sizes ORDER BY strSize";
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $text .= "<option>" . $row["strSize"]  . "</option>\n";
			}
			echo $text;
}

if($id=="setCurrency")
{	
		$supId = $_GET["supId"];
		$SQL="SELECT strCurrency FROM suppliers  where intStatus='1' AND strSupplierID=$supId";
		$result = $db->RunQuery($SQL);
		$text= "";
		while($row = mysql_fetch_array($result))
		{
			 $text =  $row["strCurrency"]  ;
		}
		echo $text;
}

if($id=="loadBulkPo")
{
		$fromDate		= $_GET["fromDate"];
		$toDate			= $_GET["toDate"];
		$intStatus		= $_GET["intStatus"];
		$intPoNo		= $_GET["poNo"];
		$strSupplierID	= $_GET["strSupplierID"];
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .= "<BulkPo>";
		$SQL=  "	SELECT
					bulkpurchaseorderheader.intBulkPoNo,
					bulkpurchaseorderheader.intYear,
					suppliers.strTitle
					FROM
					bulkpurchaseorderheader
					Inner Join suppliers ON suppliers.strSupplierID = bulkpurchaseorderheader.strSupplierID
					WHERE
					bulkpurchaseorderheader.intStatus =  '$intStatus'
					";
				

				if($fromDate!="")
				{
					$SQL.=" AND bulkpurchaseorderheader.dtDate>='$fromDate' ";
				}
				if($toDate!="")
				{
					$SQL.=" AND bulkpurchaseorderheader.dtDate<='$toDate'";
				}
				
				if($intPoNo!="")
				{
					$SQL.=" AND bulkpurchaseorderheader.intBulkPoNo LIKE '%$intPoNo%' ";
				}
				if($strSupplierID!="")
				{
					$SQL.=" AND bulkpurchaseorderheader.strSupplierID = '$strSupplierID' ";
				}
				
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strBulkPONo><![CDATA[" . $row["intBulkPoNo"]  . "]]></strBulkPONo>\n";
				 $ResponseXML .= "<intYear><![CDATA[" . $row["intYear"]  . "]]></intYear>\n"; 
				 $ResponseXML .= "<strTitle><![CDATA[" . $row["strTitle"]  . "]]></strTitle>\n";
				 
			}
			$ResponseXML .= "</BulkPo>";
			echo $ResponseXML;
}

if($id=="loadBulkPoHeader")
{


	$strBulkPoNo	=$_GET["strBulkPoNo"];
	$intYear		=$_GET["intYear"];	
	
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<BulPoHeader>";
		
		$SQL		  ="SELECT 	bpo.intBulkPoNo,bpo.intYear,bpo.strSupplierID,bpo.dtDate,bpo.dtDeliveryDate,bpo.strCurrency,bpo.intStatus,
bpo.intCompId,bpo.intDeliverTo,bpo.strPayTerm,bpo.intPayMode,bpo.intShipmentModeId,bpo.intShipmentTermID,
bpo.strInstructions,bpo.strPINO,bpo.intInvoiceComp,bpo.dtmETA,bpo.dtmETD,bpo.intMerchandiser,s.strCountry
FROM bulkpurchaseorderheader bpo inner join suppliers s on
s.strSupplierID = bpo.strSupplierID
WHERE intYear ='$intYear' AND intBulkPoNo = '$strBulkPoNo';";
						
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strBulkPONo><![CDATA[" . trim($row["intBulkPoNo"])  . "]]></strBulkPONo>\n";
				 $ResponseXML .= "<intYear><![CDATA[" . trim($row["intYear"])  . "]]></intYear>\n";
				 $ResponseXML .= "<strSupplierID><![CDATA[" . trim($row["strSupplierID"])  . "]]></strSupplierID>\n";
				 $ResponseXML .= "<dtDate><![CDATA[" . trim($row["dtDate"])  . "]]></dtDate>\n";
				 $ResponseXML .= "<dtDeliveryDate><![CDATA[" . trim($row["dtDeliveryDate"])  . "]]></dtDeliveryDate>\n";
				 $ResponseXML .= "<strCurrency><![CDATA[" . trim($row["strCurrency"])  . "]]></strCurrency>\n";
				 $ResponseXML .= "<intStatus><![CDATA[" . trim($row["intStatus"])  . "]]></intStatus>\n";
				 $ResponseXML .= "<intCompId><![CDATA[" . trim($row["intCompId"])  . "]]></intCompId>\n";
				 $ResponseXML .= "<intDeliverTo><![CDATA[" . trim($row["intDeliverTo"])  . "]]></intDeliverTo>\n";
				 $ResponseXML .= "<strPayTerm><![CDATA[" . trim($row["strPayTerm"])  . "]]></strPayTerm>\n";
				 $ResponseXML .= "<intPayMode><![CDATA[" . trim($row["intPayMode"])  . "]]></intPayMode>\n";
				 $ResponseXML .= "<intShipmentModeId><![CDATA[" . trim($row["intShipmentModeId"])  . "]]></intShipmentModeId>\n";
				 $ResponseXML .= "<intShipmentTermID><![CDATA[" . trim($row["intShipmentTermID"])  . "]]></intShipmentTermID>\n";
				 $ResponseXML .= "<strInstructions><![CDATA[" . trim($row["strInstructions"])  . "]]></strInstructions>\n";
				 $ResponseXML .= "<strPINO><![CDATA[" . trim($row["strPINO"])  . "]]></strPINO>\n";
				 $ResponseXML .= "<intInvoiceComp><![CDATA[" . trim($row["intInvoiceComp"])  . "]]></intInvoiceComp>\n";
				 $ResponseXML .= "<ETADate><![CDATA[" . trim($row["dtmETA"])  . "]]></ETADate>\n";
				 $ResponseXML .= "<ETDDate><![CDATA[" . trim($row["dtmETD"])  . "]]></ETDDate>\n";
				 $ResponseXML .= "<intMerchandiser><![CDATA[" . trim($row["intMerchandiser"])  . "]]></intMerchandiser>\n";
				 $ResponseXML .= "<supCountry><![CDATA[" . trim($row["strCountry"])  . "]]></supCountry>\n";
				 break;
			}
			$ResponseXML .= "</BulPoHeader>";
			echo $ResponseXML;

}


if($id=="loadBulkPoDetails")
{


		$strBulkPoNo	=$_GET["strBulkPoNo"];
		$intYear		=$_GET["intYear"];		
		
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
		$ResponseXML .="<BulPoDetails>";
		
		$SQL		  =" SELECT
						matitemlist.strItemDescription AS itemDescription,
						matmaincategory.strDescription AS strMainCategory,
						bulkpurchaseorderdetails.strColor,
						bulkpurchaseorderdetails.strSize,
						bulkpurchaseorderdetails.strUnit,
						bulkpurchaseorderdetails.dblUnitPrice,
						bulkpurchaseorderdetails.dblQty,
						bulkpurchaseorderdetails.intMatDetailId,
						bulkpurchaseorderheader.intStatus
						FROM
						bulkpurchaseorderdetails
						inner join matitemlist on matitemlist.intItemSerial=bulkpurchaseorderdetails.intMatDetailId
Inner Join matmaincategory ON matmaincategory.intID = matitemlist.intMainCatID
						Inner Join bulkpurchaseorderheader ON bulkpurchaseorderheader.intBulkPoNo = bulkpurchaseorderdetails.intBulkPoNo 
						AND bulkpurchaseorderheader.intYear = bulkpurchaseorderdetails.intYear
						WHERE						
						bulkpurchaseorderdetails.intYear 		= 	$intYear AND
						bulkpurchaseorderdetails.intBulkPoNo 	=   '$strBulkPoNo'";
		$result = $db->RunQuery($SQL);	
			while($row = mysql_fetch_array($result))
			{
				 $ResponseXML .= "<strMainCategory><![CDATA[" . trim($row["strMainCategory"])  . "]]></strMainCategory>\n";
				 $ResponseXML .= "<itemDescription><![CDATA[" . trim($row["itemDescription"])  . "]]></itemDescription>\n";
				 $ResponseXML .= "<strColor><![CDATA[" . trim($row["strColor"])  . "]]></strColor>\n";
				 $ResponseXML .= "<strSize><![CDATA[" . trim($row["strSize"])  . "]]></strSize>\n";
				 $ResponseXML .= "<strUnit><![CDATA[" . trim($row["strUnit"])  . "]]></strUnit>\n";
				 $ResponseXML .= "<dblUnitPrice><![CDATA[" . trim($row["dblUnitPrice"])  . "]]></dblUnitPrice>\n";
				 $ResponseXML .= "<dblBalance><![CDATA[" . trim($row["dblBalance"])  . "]]></dblBalance>\n";
				 $ResponseXML .= "<dblQty><![CDATA[" . trim($row["dblQty"])  . "]]></dblQty>\n";
				 $ResponseXML .= "<strMatDetailID><![CDATA[" . trim($row["intMatDetailId"])  . "]]></strMatDetailID>\n";
				 $ResponseXML .= "<Status><![CDATA[" . trim($row["intStatus"])  . "]]></Status>\n";
			}
			$ResponseXML .= "</BulPoDetails>";
			echo $ResponseXML;

}
if($id=="getCancelPOData")
{
$xml = simplexml_load_file('../config.xml');
$advanceID = $xml->PurchaseOrder->PaymentTermAdvanceID;

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		
$pono			= "";
$fromDate		= "";
$toDate			= "";
$ResponseXML	= "";
$pono			= $_GET["pono"];
$supplierID		= $_GET["supplierID"];
$fromDate		= $_GET["from"];
$toDate			= $_GET["to"];
$type			= $_GET["type"];

$ResponseXML 	.= "<CancelPO>\n";
$result=getCancelPOdata($pono,$supplierID,$fromDate,$toDate,$advanceID);

while($row = mysql_fetch_array($result))
		{
			$paymentTerm	= $row["strPayTerm"];
			$ResponseXML .= "<poNo><![CDATA[" . $row["intBulkPoNo"]. "]]></poNo>\n";
			$ResponseXML .= "<poYear><![CDATA[" . $row["intYear"]. "]]></poYear>\n";
			$ResponseXML .="<GRNState><![CDATA[".isValidtoCancel($row["intBulkPoNo"],$row["intYear"])."]]></GRNState>\n";
			$ResponseXML .= "<date><![CDATA[" . $row["datePO"]. "]]></date>\n";
			$ResponseXML .= "<poValue><![CDATA[" . $row["dblTotalValue"]. "]]></poValue>\n";
			
			if($type=="revision"){	
				if($paymentTerm==1){
					if($poRevisePTermAdvance)
						$ResponseXML .= "<PayTerm><![CDATA[1]]></PayTerm>\n";
					else
						$ResponseXML .= "<PayTerm><![CDATA[0]]></PayTerm>\n";
				}
				else
					$ResponseXML .= "<PayTerm><![CDATA[1]]></PayTerm>\n";	
			}
			elseif($type=="cancel"){
				if($paymentTerm==1){
					if($poCancelPTermAdvance)
						$ResponseXML .= "<PayTerm><![CDATA[1]]></PayTerm>\n";
					else
						$ResponseXML .= "<PayTerm><![CDATA[0]]></PayTerm>\n";
				}
				else
					$ResponseXML .= "<PayTerm><![CDATA[1]]></PayTerm>\n";			
			}
		}
		$ResponseXML .= "</CancelPO>\n";
		echo $ResponseXML;
}

if($id=="loadPendingBPONo")
{
$suplierID		= $_GET["suplierID"];

	if($suplierID!="0")
	{
		$sql="SELECT DISTINCT b.intBulkPoNo FROM bulkpurchaseorderheader b INNER JOIN bulkpurchaseorderdetails d ON b.intBulkPoNo=d.intBulkPoNo where b.intStatus='0' and b.strSupplierID='$suplierID'";
	}
	else
	{
		$sql="SELECT DISTINCT b.intBulkPoNo FROM bulkpurchaseorderheader b INNER JOIN bulkpurchaseorderdetails d ON b.intBulkPoNo=d.intBulkPoNo where b.intStatus='0' ";
	}	 
		echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intBulkPoNo"] ."\">" . $row["intBulkPoNo"] ."</option>" ;
	}
}

if (strcmp($id,"getSupplierDetails") == 0)
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	 $ResponseXML = "";
	 $suplierID=$_GET["suplierID"];
	 $ResponseXML .= "<supDetails>\n";
	 
	 $sql = "	SELECT
			suppliers.strPayTermId,
			suppliers.strPayModeId,
			suppliers.strShipmentTermId,
			suppliers.intShipmentModeId,
			suppliers.strCurrency,
			suppliers.strCountry
			FROM `suppliers`
			WHERE
			suppliers.strSupplierID =  '$suplierID'";
			
	 $result=$db->RunQuery($sql);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<strPayTermId><![CDATA[" . $row["strPayTermId"]  . "]]></strPayTermId>\n";
		 $ResponseXML .= "<strPayModeId><![CDATA[" . $row["strPayModeId"]  . "]]></strPayModeId>\n";
		 $ResponseXML .= "<strShipmentTermId><![CDATA[" . $row["strShipmentTermId"]  . "]]></strShipmentTermId>\n";
		 $ResponseXML .= "<intShipmentModeId><![CDATA[" . $row["intShipmentModeId"]  . "]]></intShipmentModeId>\n";
		 $ResponseXML .= "<strCurrency><![CDATA[" . $row["strCurrency"]  . "]]></strCurrency>\n";
		 $ResponseXML .= "<strCountry><![CDATA[" . $row["strCountry"]  . "]]></strCountry>\n";
                       
	 }
	 //$res = '123';
	  //$ResponseXML .= "<strPayTermId><![CDATA[" . $res . "]]></strPayTermId>\n";
	 $ResponseXML .= "</supDetails>";
	 echo $ResponseXML;
}

if(strcmp($id,"getExchangeRate") == 0)
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
$ResponseXML  = "<RateM>\n";
$currencyType = $_GET["curType"];

	$sql="SELECT ER.rate FROM exchangerate ER where ER.currencyID='$currencyType' and ER.intStatus=1;";
	//echo $sql;
	$result=$db->RunQuery($sql);
	$rate = "NA";
	while($row = mysql_fetch_array($result))
	{
		$rate = $row["rate"];	
	}
$ResponseXML .= "<Rate><![CDATA[" . $rate . "]]></Rate>\n";
$ResponseXML .= "</RateM>";
echo $ResponseXML;
}

if($id=="loadBuyerinBulk")
{
	$result=loadBuyers();
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
        
	 }
	 
	 echo $ResponseXML;
}

function loadBuyers()
{
	global $db;
	$sql="select intBuyerID,strName from buyers;";
	return $db->RunQuery($sql);
}

function getCancelPOdata($pono,$supplierID,$fromDate,$toDate,$advanceID)
{
$advanceID = -50;
global $db;
$mysqlDate=explode('/', $fromDate);
$mysqlFormatDate=$mysqlDate[2]."-".$mysqlDate[1]."-".$mysqlDate[0];
$mysqlToDate=explode('/', $toDate);
$mysqlFormatToDate=$mysqlToDate[2]."-".$mysqlToDate[1]."-".$mysqlToDate[0];

$sql="SELECT intBulkPoNo, intYear, DATE(dtDate)AS datePO,dblTotalValue,strPayTerm FROM bulkpurchaseorderheader WHERE intStatus='1' AND strPayTerm <> $advanceID ";
if($pono!="")
$sql .=" AND intBulkPoNo=$pono";

if($supplierID!=0)
$sql .=" AND strSupplierID='$supplierID'";

if($fromDate!="")
$sql .=" AND dtDate > '$mysqlFormatDate'";

if($toDate!="")
$sql .=" dtDate < '$mysqlFormatToDate'";

$sql .=" order by  dtDate ";
return $db->RunQuery($sql);
}

function isValidtoCancel($pono,$poyear)
{
global $db;
$sql="SELECT COUNT(intBulkPoNo) as poCount FROM bulkgrnheader where intBulkPoNo='$pono' and intBulkPoYear='$poyear' and intStatus=1;";

$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
return $row["poCount"];

}
return 0;
}

function GetAllowableSubCaterorise()
{
global $db;
	$sql="select strValue from settings where strKey='BulkPOAllowableSubCategories';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strValue"];
	}
}
?>
