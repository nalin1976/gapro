<?php
include "../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($RequestType=="getScDetails")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$styleId = $_GET["styleId"];
$cdnDateTo = $_GET["cdnDateTo"];
$buyer = $_GET["buyer"];
$cdnDateFrom = $_GET["cdnDateFrom"];

$toDate = $_GET["toDate"];
$fromDate = $_GET["fromDate"];


if($toDate!=""){
	$AppDateToArray		= explode('/',$toDate);
	//$AppDateToArray2		= explode(' ',$AppDateToArray[2]);	
	$toDate = $AppDateToArray[2]."-".$AppDateToArray[1]."-".$AppDateToArray[0];
	}
	
if($fromDate!=""){
	$AppDateFromArray		= explode('/',$fromDate);
	//$AppDateFromArray2		= explode(' ',$AppDateFromArray[2]);	
	$fromDate = $AppDateFromArray[2]."-".$AppDateFromArray[1]."-".$AppDateFromArray[0];
	}
	
	

$ResponseXML = "<XMLLoadDetails>\n";

				$sql="SELECT
				specification.intSRNO,
				orders.strStyle,
				buyers.strName as buyer,
				orders.intStyleId,
				deliveryschedule.intBPO,
				deliveryschedule.dblQty AS bpoQty,
				orders.strOrderColorCode,
				mainstores.strName as fty,
				deliveryschedule.estimatedDate AS xFacDate,
				deliveryschedule.dtmHandOverDate AS handOverDate,
				date(deliveryschedule.dtDateofDelivery) AS dateofDelivery,
				country.strCountry,
				orders.reaSMV,
				shipmentmode.strDescription,
				orders.reaFOB,
				companies.reaCMforPowiseCostingRpt,
				orders.intQty
				FROM
				orders
				INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId
				INNER JOIN shipmentmode ON deliveryschedule.strShippingMode = shipmentmode.intShipmentModeId
				INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
				INNER JOIN specification ON orders.intStyleId = specification.intStyleId
				INNER JOIN mainstores ON deliveryschedule.intManufacturingLocation = mainstores.intCompanyId
				INNER JOIN country ON buyers.strCountry = country.intConID
				INNER JOIN companies ON deliveryschedule.intManufacturingLocation = companies.intCompanyID
				WHERE 
				orders.intStatus<>14";

if($styleId != 'Select One'){
							$sql .= " AND orders.intStyleId ='$styleId'";
							}
							
if($buyer != 'Select One'){
							$sql .= " AND buyers.intBuyerID ='$buyer'";
							}
							
if($toDate !="" && $fromDate !=""){
							$sql .= " AND date(deliveryschedule.dtDateofDelivery) BETWEEN '$fromDate' AND '$toDate' ";
							}
				
				$sql .= " GROUP BY
				orders.intStyleId,
				deliveryschedule.intBPO";


				
				
$result=$db->RunQuery($sql);
//echo $sql;

$rmcPc = 0;
while($row=mysql_fetch_array($result))
{

	//$poQty = GetPoDetails($styleId,$row["strBuyerPONO"],$row["strMatDetailID"]);
$sc = $row["intSRNO"];
$bpoQty = $row["bpoQty"];
$odrQty = $row["intQty"];
	
$_dblFabricCost = CalculateFabricCost($sc, $bpoQty, $odrQty,1);
$_dblSewCost    = CalculateFabricCost($sc, $bpoQty, $odrQty,2);
$_dblPacCost    = CalculateFabricCost($sc, $bpoQty, $odrQty,3);
$_dblSerCost    = CalculateFabricCost($sc, $bpoQty, $odrQty,4);

$_getStyle = getShippingStyle($sc,$row["intBPO"]);

$_ShippedQty    = ShippedQty($_getStyle,$row["intBPO"]);
$_ShippingFob    = ShippingFob($_getStyle,$row["intBPO"]);
$_cdnDate       = cdnDate($_getStyle,$row["intBPO"]);


$rmcPc = $_dblFabricCost+$_dblSewCost+$_dblPacCost+$_dblSerCost;

	$ResponseXML .= "<intSRNO><![CDATA[".$row["intSRNO"]."]]></intSRNO>\n";
	$ResponseXML .= "<styleName><![CDATA[".$row["strStyle"]."]]></styleName>\n";	
	$ResponseXML .= "<buyer><![CDATA[".$row["buyer"]."]]></buyer>\n";
	$ResponseXML .= "<intStyleId><![CDATA[".$row["intStyleId"]."]]></intStyleId>\n";
	$ResponseXML .= "<intBPO><![CDATA[".$row["intBPO"]."]]></intBPO>\n";
	$ResponseXML .= "<bpoQty><![CDATA[".$row["bpoQty"]."]]></bpoQty>\n";
	$ResponseXML .= "<odrColor><![CDATA[".$row["strOrderColorCode"]."]]></odrColor>\n";
	$ResponseXML .= "<fty><![CDATA[".$row["fty"]."]]></fty>\n";
	$ResponseXML .= "<xFacDate><![CDATA[".$row["xFacDate"]."]]></xFacDate>\n";
	$ResponseXML .= "<handOverDate><![CDATA[".$row["handOverDate"]."]]></handOverDate>\n";
	$ResponseXML .= "<dateofDelivery><![CDATA[".$row["dateofDelivery"]."]]></dateofDelivery>\n";
	$ResponseXML .= "<shpMode><![CDATA[".$row["strDescription"]."]]></shpMode>\n";
	$ResponseXML .= "<strCountry><![CDATA[".$row["strCountry"]."]]></strCountry>\n";
	$ResponseXML .= "<reaFOB><![CDATA[".$row["reaFOB"]."]]></reaFOB>\n";
	$ResponseXML .= "<smv><![CDATA[".$row["reaSMV"]."]]></smv>\n";
	$ResponseXML .= "<CM><![CDATA[".$row["reaCMforPowiseCostingRpt"]."]]></CM>\n";
	$ResponseXML .= "<rmcPc><![CDATA[".$rmcPc."]]></rmcPc>\n";
	$ResponseXML .= "<shippedQty><![CDATA[".$_ShippedQty."]]></shippedQty>\n";
	$ResponseXML .= "<shpFob><![CDATA[".$_ShippingFob."]]></shpFob>\n";
	$ResponseXML .= "<cdnDate><![CDATA[".$_cdnDate  ."]]></cdnDate>\n";	
}
$ResponseXML .= "</XMLLoadDetails>\n";
echo $ResponseXML;
}


else if($RequestType == "getCDNScDetails"){
	
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLLoadDetails>\n";
$styleId = $_GET["styleId"];
$cdnDateTo = $_GET["cdnDateTo"];
$buyer = $_GET["buyer"];
$cdnDateFrom = $_GET["cdnDateFrom"];

$toDate = $_GET["toDate"];
$fromDate = $_GET["fromDate"];


if($toDate!=""){
	$AppDateToArray		= explode('/',$toDate);
	$toDate = $AppDateToArray[2]."-".$AppDateToArray[1]."-".$AppDateToArray[0];
	}
	
if($fromDate!=""){
	$AppDateFromArray		= explode('/',$fromDate);
	$fromDate = $AppDateFromArray[2]."-".$AppDateFromArray[1]."-".$AppDateFromArray[0];
	}
	
if($cdnDateTo!=""){
	$AppCdnDateToArray		= explode('/',$cdnDateTo);
	$cdnDateTo = $AppCdnDateToArray[2]."-".$AppCdnDateToArray[1]."-".$AppCdnDateToArray[0];
	}

if($cdnDateFrom!=""){
	$AppCdnDateFromArray		= explode('/',$cdnDateFrom);
	$cdnDateFrom = $AppCdnDateFromArray[2]."-".$AppCdnDateFromArray[1]."-".$AppCdnDateFromArray[0];
	}
		
$con_Eshipping = mysql_connect('172.23.1.15','exporemote','Exp0U$3r2016') or die (mysql_error());
$shipping_db = mysql_select_db('myexpo',$con_Eshipping) or die ('Connection to gapros db failed.');

		    $cdn_query = "SELECT
			cdn_header.intCDNNo,
			cdn_header.strInvoiceNo,
			cdn_header.dtmDate,
			pre_invoice_detail.strStyleID,
			pre_invoice_detail.strBuyerPONo,
			pre_invoice_detail.strSC_No
			FROM
			cdn_header
			INNER JOIN pre_invoice_detail ON cdn_header.strInvoiceNo = pre_invoice_detail.strInvoiceNo
			WHERE
			cdn_header.dtmDate BETWEEN '$cdnDateFrom' AND '$cdnDateTo'";

		$result_CDN= @mysql_query($cdn_query);
		while($_rowCdn = mysql_fetch_array($result_CDN)){
		$cdnSC  = $_rowCdn['strSC_No'];
		$cdnBpo = $_rowCdn['strBuyerPONo'];

	



				$sql="SELECT
				specification.intSRNO,
				orders.strStyle,
				buyers.strName as buyer,
				orders.intStyleId,
				deliveryschedule.intBPO,
				deliveryschedule.dblQty AS bpoQty,
				orders.strOrderColorCode,
				mainstores.strName as fty,
				deliveryschedule.estimatedDate AS xFacDate,
				deliveryschedule.dtmHandOverDate AS handOverDate,
				date(deliveryschedule.dtDateofDelivery) AS dateofDelivery,
				country.strCountry,
				orders.reaSMV,
				shipmentmode.strDescription,
				orders.reaFOB,
				companies.reaCMforPowiseCostingRpt,
				orders.intQty
				FROM
				orders
				INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId
				INNER JOIN shipmentmode ON deliveryschedule.strShippingMode = shipmentmode.intShipmentModeId
				INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
				INNER JOIN specification ON orders.intStyleId = specification.intStyleId
				INNER JOIN mainstores ON deliveryschedule.intManufacturingLocation = mainstores.intCompanyId
				INNER JOIN country ON buyers.strCountry = country.intConID
				INNER JOIN companies ON deliveryschedule.intManufacturingLocation = companies.intCompanyID
				WHERE 
				orders.intStatus<>14";
				if($styleId != 'Select One'){
							$sql .= " AND orders.intStyleId ='$styleId'";
							}
							
				if($buyer != 'Select One'){
							$sql .= " AND buyers.intBuyerID ='$buyer'";
							}
							
							
				if($toDate !="" && $fromDate !=""){
							$sql .= " AND date(deliveryschedule.dtDateofDelivery) BETWEEN '$fromDate' AND '$toDate' ";
							}
				$sql .= " AND specification.intSRNO = '$cdnSC' AND deliveryschedule.intBPO = '$cdnBpo' 
		    	GROUP BY
				orders.intStyleId,
				deliveryschedule.intBPO ";
			
$result=$db->RunQuery($sql);
//echo $sql;

$rmcPc = 0;
while($row=mysql_fetch_array($result))
{

	//$poQty = GetPoDetails($styleId,$row["strBuyerPONO"],$row["strMatDetailID"]);
$sc = $row["intSRNO"];
$bpoQty = $row["bpoQty"];
$odrQty = $row["intQty"];
	
$_dblFabricCost = CalculateFabricCost($sc, $bpoQty, $odrQty,1);
$_dblSewCost    = CalculateFabricCost($sc, $bpoQty, $odrQty,2);
$_dblPacCost    = CalculateFabricCost($sc, $bpoQty, $odrQty,3);
$_dblSerCost    = CalculateFabricCost($sc, $bpoQty, $odrQty,4);

$_getStyle = getShippingStyle($sc,$row["intBPO"]);

$_ShippedQty    = ShippedQty($_getStyle,$row["intBPO"]);
$_ShippingFob    = ShippingFob($_getStyle,$row["intBPO"]);
$_cdnDate       = cdnDate($_getStyle,$row["intBPO"]);


$rmcPc = $_dblFabricCost+$_dblSewCost+$_dblPacCost+$_dblSerCost;

	$ResponseXML .= "<intSRNO><![CDATA[".$row["intSRNO"]."]]></intSRNO>\n";
	$ResponseXML .= "<styleName><![CDATA[".$row["strStyle"]."]]></styleName>\n";	
	$ResponseXML .= "<buyer><![CDATA[".$row["buyer"]."]]></buyer>\n";
	$ResponseXML .= "<intStyleId><![CDATA[".$row["intStyleId"]."]]></intStyleId>\n";
	$ResponseXML .= "<intBPO><![CDATA[".$row["intBPO"]."]]></intBPO>\n";
	$ResponseXML .= "<bpoQty><![CDATA[".$row["bpoQty"]."]]></bpoQty>\n";
	$ResponseXML .= "<odrColor><![CDATA[".$row["strOrderColorCode"]."]]></odrColor>\n";
	$ResponseXML .= "<fty><![CDATA[".$row["fty"]."]]></fty>\n";
	$ResponseXML .= "<xFacDate><![CDATA[".$row["xFacDate"]."]]></xFacDate>\n";
	$ResponseXML .= "<handOverDate><![CDATA[".$row["handOverDate"]."]]></handOverDate>\n";
	$ResponseXML .= "<dateofDelivery><![CDATA[".$row["dateofDelivery"]."]]></dateofDelivery>\n";
	$ResponseXML .= "<shpMode><![CDATA[".$row["strDescription"]."]]></shpMode>\n";
	$ResponseXML .= "<strCountry><![CDATA[".$row["strCountry"]."]]></strCountry>\n";
	$ResponseXML .= "<reaFOB><![CDATA[".$row["reaFOB"]."]]></reaFOB>\n";
	$ResponseXML .= "<smv><![CDATA[".$row["reaSMV"]."]]></smv>\n";
	$ResponseXML .= "<CM><![CDATA[".$row["reaCMforPowiseCostingRpt"]."]]></CM>\n";
	$ResponseXML .= "<rmcPc><![CDATA[".$rmcPc."]]></rmcPc>\n";
	$ResponseXML .= "<shippedQty><![CDATA[".$_ShippedQty."]]></shippedQty>\n";
	$ResponseXML .= "<shpFob><![CDATA[".$_ShippingFob."]]></shpFob>\n";
	$ResponseXML .= "<cdnDate><![CDATA[".$_cdnDate  ."]]></cdnDate>\n";	
}}
$ResponseXML .= "</XMLLoadDetails>\n";
echo $ResponseXML;

	//}

		mysql_close($con_Eshipping);
}

else if($RequestType == "getBPo"){
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
 	$ResponseXML="";
	
    $stytleOrSc = $_GET["stytleOrSc"];
	$type = $_GET["type"];

	   $SQL = "SELECT
				deliveryschedule.intBPO,
				specification.intSRNO,
				orders.strStyle,
				specification.intStyleId
				FROM
				deliveryschedule
				INNER JOIN specification ON deliveryschedule.intStyleId = specification.intStyleId
				INNER JOIN orders ON deliveryschedule.intStyleId = orders.intStyleId";
				
				if($type == 'sc'){
				$SQL .= " WHERE specification.intStyleId ='$stytleOrSc'";
				}
				
				if($type == 'style'){
				$SQL .= " WHERE specification.intStyleId ='$stytleOrSc'";
				}
				" GROUP BY	deliveryschedule.intBPO	";
	
	//echo $SQL;
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\""."Select One"."\" selected=\"selected\">Select One</option>";
		$str .= "<option value=\""."#Main Ratio#"."\" >#Main Ratio#</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intBPO"] ."\">" . $row["intBPO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
}



//Start functions

function GetBuyerPoName($buyerPoId)
{
global $db;
$sql="select strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoId'";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
return $row["strBuyerPoName"];
}

function GetPoDetails($styleId,$bpo,$matId)
{
global $db;

//echo "bpo = ".$bpo." mat = ".$matId;
$sql="SELECT
purchaseorderdetails.intPoNo,
purchaseorderdetails.intStyleId,
purchaseorderdetails.intMatDetailID,
Sum(purchaseorderdetails.dblQty) AS PoQty,
purchaseorderdetails.strBuyerPONO
FROM
purchaseorderdetails
WHERE
purchaseorderdetails.intStyleId = '$styleId' AND
purchaseorderdetails.strBuyerPONO = '$bpo' AND
purchaseorderdetails.intMatDetailID = '$matId' 
GROUP BY
purchaseorderdetails.intStyleId,
purchaseorderdetails.strBuyerPONO,
purchaseorderdetails.intMatDetailID";
$result=$db->RunQuery($sql);

//echo $sql;
$row=mysql_fetch_array($result);
return $row["PoQty"];
}



function CalculateFabricCost($sc, $bpoQty, $qty_in_pcs,$mat_type){
global $db;
$_dblTotalMatCost = 0;

	//echo "aaaaaaaa";
	
	 $sql_FabCost = "SELECT
	orderdetails.reaConPc as reaConPc,
	orderdetails.reaWastage as reaWastage,
	orderdetails.dblUnitPrice as dblUnitPrice,
	orderdetails.intstatus,
	orderdetails.intOriginNo,
	orderdetails.intStyleId,
	specification.intSRNO
	FROM
	orderdetails
	INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial
	INNER JOIN specification ON orderdetails.intStyleId = specification.intStyleId
	WHERE
	matitemlist.intMainCatID = '$mat_type' AND
	specification.intSRNO ='$sc' AND
	(orderdetails.intstatus = '1' OR
	orderdetails.intstatus IS NULL) ";
	
	$result=$db->RunQuery($sql_FabCost);

	while($rowFabric = mysql_fetch_array($result)){
		$_dblConPerPc = $rowFabric['reaConPc'];
	
		$_dblWastage = $rowFabric['reaWastage'];
		$_dblUnitPrice = $rowFabric['dblUnitPrice'];
		$_intOriginType = $rowFabric['intOriginNo'];
		//$_dblReqQty =  $bpoQty * $_dblConPerPc; ->
		$_dblReqQty =  $qty_in_pcs * $_dblConPerPc;
		// ***************** qty_in_pcs = cdnQty
		
		//echo "qty_in_pcs = ".$qty_in_pcs ." _dblConPerPc = ".$_dblConPerPc."XX"; 
		
		$_dblWastageQty = ($_dblReqQty /100) * $_dblWastage;
		


		$_dblTotReqQty = ($_dblReqQty + $_dblWastageQty);
	

		$_dblTotalValue = ($_dblTotReqQty * $_dblUnitPrice);

		$_dblCostPerPc = ($_dblTotalValue / $qty_in_pcs); 




		$_dblTotalMatCost +=  ($_dblCostPerPc);


		
	}	
	return $_dblTotalMatCost;
}



function ShippedQty($shpStyle,$bpoNo){
	
$cdnQty = 0;

$con_Eshipping = mysql_connect('172.23.1.15','exporemote','Exp0U$3r2016') or die (mysql_error());
$shipping_db = mysql_select_db('myexpo',$con_Eshipping) or die ('Connection to gapros db failed.');
				
				
				
		$cm_query = "SELECT
					Sum(cdn_detail.dblQuantity) AS cdnQty,
					cdn_detail.strStyleID,
					cdn_detail.strBuyerPONo
					FROM
					cdn_detail
					WHERE
					
					cdn_detail.strStyleID = '$shpStyle' AND
					cdn_detail.strBuyerPONo = '$bpoNo'
					GROUP BY
					cdn_detail.strStyleID,
					cdn_detail.strBuyerPONo";

$result = @mysql_query($cm_query);
while($_rowCdn = mysql_fetch_array($result)){
$cdnQty=$_rowCdn['cdnQty'];

	
	}

return $cdnQty;
		mysql_close($con_Eshipping);
	 
}


function ShippingFob($shpStyle,$bpoNo){
	
$cdnQty = 0;

$con_Eshipping = mysql_connect('172.23.1.15','exporemote','Exp0U$3r2016') or die (mysql_error());
$shipping_db = mysql_select_db('myexpo',$con_Eshipping) or die ('Connection to gapros db failed.');
				
				
				
		$cm_query = "SELECT 
					cdn_detail.dblUnitPrice AS dblUnitPrice
					FROM
					cdn_detail
					WHERE
					cdn_detail.strStyleID = '$shpStyle' AND
					cdn_detail.strBuyerPONo = '$bpoNo'
					GROUP BY
					cdn_detail.strStyleID,
					cdn_detail.strBuyerPONo";

$result = @mysql_query($cm_query);
while($_rowCdn = mysql_fetch_array($result)){
$shpFob=$_rowCdn['dblUnitPrice'];

	
	}

return $shpFob;
		mysql_close($con_Eshipping);
	 
}



function cdnDate($shpStyle,$bpoNo){
	
$cdnQty = 0;

$con_Eshipping = mysql_connect('172.23.1.15','exporemote','Exp0U$3r2016') or die (mysql_error());
$shipping_db = mysql_select_db('myexpo',$con_Eshipping) or die ('Connection to gapros db failed.');
				
				
				
		$cm_query = "SELECT
		cdn_detail.strStyleID,
		cdn_detail.strBuyerPONo,
		date(cdn_header.dtmDate) as cdnDate
		FROM
		cdn_detail
		INNER JOIN cdn_header ON cdn_detail.strInvoiceNo = cdn_header.strInvoiceNo
		WHERE
							
							cdn_detail.strStyleID = '$shpStyle' AND
							cdn_detail.strBuyerPONo = '$bpoNo'
		GROUP BY
							cdn_detail.strStyleID,
							cdn_detail.strBuyerPONo";

$result = @mysql_query($cm_query);
while($_rowCdn = mysql_fetch_array($result)){
$cdnDate=$_rowCdn['cdnDate'];

	
	}

return $cdnDate;
		mysql_close($con_Eshipping);
	 
}



function getShippingStyle($sc,$bpoNo){
	
$cdnQty = 0;

$con_Eshipping = mysql_connect('172.23.1.15','exporemote','Exp0U$3r2016') or die (mysql_error());
$shipping_db = mysql_select_db('myexpo',$con_Eshipping) or die ('Connection to gapros db failed.');
				
				
				
		  $cm_query = "SELECT
					pre_invoice_detail.strSC_No,
					pre_invoice_detail.strStyleID,
					pre_invoice_detail.strBuyerPONo
					FROM
					pre_invoice_detail
					WHERE
					pre_invoice_detail.strSC_No = '$sc' AND
					pre_invoice_detail.strBuyerPONo = '$bpoNo'
					GROUP BY
					pre_invoice_detail.strSC_No";

$result = @mysql_query($cm_query);
while($_rowCdn = mysql_fetch_array($result)){
$shpStyle=$_rowCdn['strStyleID'];

	
	}

return $shpStyle;
		mysql_close($con_Eshipping);
	 
}
?>