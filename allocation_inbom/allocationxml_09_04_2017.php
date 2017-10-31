<?php
include "../Connector.php";
$RequestType	= $_GET["RequestType"];
//$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];


if($RequestType=="viewBulkDetails")
{

$matDetailId = $_GET["matID"];
$MainStoreID   = $_GET["MainStoreID"];
$StyleID     = $_GET["StyleID"];
$color_array 	= array();
$size_array 	= array();


$companyId   = GetCompanyDetails($MainStoreID);

$loop1 =0;
$sql_color="select distinct strColor from materialratio where intStyleId='$StyleID' and strMatDetailID='$matDetailId '";
$result_color=$db->RunQuery($sql_color);
while($row_color=mysql_fetch_array($result_color))
{
	$color_array[$loop1] = "'" . $row_color["strColor"] . "'";
	$loop1++;
}

$loop2 =0;
$sql_size="select distinct strSize from materialratio where intStyleId='$StyleID' and strMatDetailID='$matDetailId '";
$result_size=$db->RunQuery($sql_size);
while($row_size=mysql_fetch_array($result_size))
{
	$size_array[$loop2] = "'" . $row_size["strSize"] . "'";
	$loop2++;
}

		
	$color	= implode(",", $color_array); 
	$size 	= implode(",", $size_array); 


	
$ResponseXML ="";

	$ResponseXML .=	"<tr bgcolor=\"#498CC2\">
			<td width=\"1%\" class=\"normaltxtmidb2\">&nbsp;</td>
            <td width=\"10%\" class=\"normaltxtmidb2\">Bulk PO No</td>
              <td width=\"10%\" class=\"normaltxtmidb2\">Bulk GRN No</td>
              <td width=\"10%\" class=\"normaltxtmidb2\">Invoice No</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Main Store</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Color</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Size</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Unit</td>
            <td width=\"10%\" class=\"normaltxtmidb2\">PO Qty</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Bal Qty</td>
			<td width=\"1%\" class=\"normaltxtmidb2\"></td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Allocate Qty</td>
            <td width=\"8%\" class=\"normaltxtmidb2\">PO price</td>
			</tr>";
			//<input type=\"checkbox\" id=\"chkBulkCheckAll\" name=\"chkBulkCheckAll\" onclick=\"chkBulkCheckAll(this);\"/>
	/*$sql_2 =   "select bulkGH.intBulkPoNo as BPONo, bulkGD.intBulkGrnNo, bulkGH.strInvoiceNo, S.strColor,
			S.strSize,S.strUnit,bulkPO.dblQty as BulkPOQty, bulkGD.dblQty as grnQty,MS.strName,
			strMainStoresID, sum(S.dblQty) as GRNBalanceQty,bulkPO.intYear as POyear, bulkGH.intYear as grnYear,
			bulkPO.dblUnitPrice,BPOH.strCurrency
			from stocktransactions_bulk S 
			inner join mainstores MS on S.strMainStoresID=MS.strMainID 
			inner join bulkgrndetails bulkGD on bulkGD.intBulkGrnNo = S.intDocumentNo and 
			bulkGD.intYear = S.intDocumentYear and S.intMatDetailId = bulkGD.intMatDetailID and 
			bulkGD.strColor = S.strColor and  bulkGD.strSize= S.strSize
			inner join bulkgrnheader bulkGH on bulkGH.intBulkGrnNo = bulkGD.intBulkGrnNo and 
			bulkGH.intYear = bulkGH.intYear
			inner join bulkpurchaseorderdetails bulkPO on bulkPO.intBulkPoNo = bulkGH.intBulkPoNo and 
			bulkPO.intYear = bulkGH.intYear and bulkPO.intMatDetailId = S.intMatDetailId and 
			bulkPO.strColor = S.strColor and  bulkPO.strSize = bulkGD.strSize
			inner join bulkpurchaseorderheader BPOH on BPOH.intBulkPoNo=bulkPO.intBulkPoNo and 
BPOH.intYear = bulkPO.intYear
			where  S.intMatDetailId='$matDetailId' and MS.strMainID = '$MainStoreID' and bulkPO.strSize in ($size) 
			and bulkPO.strColor in ($color)
			group by bulkGH.intBulkPoNo , bulkGD.intBulkGrnNo, bulkGH.strInvoiceNo, S.strColor,
			S.strSize,S.strUnit,bulkPO.dblQty , bulkGD.dblQty ,MS.strName,
			strMainStoresID,bulkPO.intYear , bulkGH.intYear ,
			bulkPO.dblUnitPrice,BPOH.strCurrency ";*/
			
			$sql_2 = " select  bulkGH.intBulkPoNo as BPONo, bulkGH.intBulkGrnNo, bulkGH.strInvoiceNo, S.strColor,
			S.strSize,S.strUnit,bulkPO.dblQty as BulkPOQty, MS.strName,
			strMainStoresID, 
 sum(S.dblQty) as GRNBalanceQty,
bulkPO.intYear as POyear, bulkGH.intYear as grnYear,
			bulkPO.dblUnitPrice,BPOH.strCurrency
			from stocktransactions_bulk S 
			inner join mainstores MS on S.strMainStoresID=MS.strMainID 
			inner join bulkgrnheader bulkGH on bulkGH.intBulkGrnNo = S.intBulkGrnNo and 
			bulkGH.intYear = S.intBulkGrnYear
			inner join bulkpurchaseorderdetails bulkPO on bulkPO.intBulkPoNo = bulkGH.intBulkPoNo and 
			bulkPO.intYear = bulkGH.intBulkPoYear and bulkPO.intMatDetailId = S.intMatDetailId and 
			bulkPO.strColor = S.strColor and  bulkPO.strSize = S.strSize
			inner join bulkpurchaseorderheader BPOH on BPOH.intBulkPoNo=bulkPO.intBulkPoNo and 
BPOH.intYear = bulkPO.intYear
			where  S.intMatDetailId='$matDetailId' and MS.strMainID = '$MainStoreID' and bulkPO.strSize in ($size) 
			and bulkPO.strColor in ($color)
 group by bulkGH.intBulkPoNo , bulkGH.intBulkGrnNo, bulkGH.strInvoiceNo, S.strColor,
			S.strSize,S.strUnit,bulkPO.dblQty , MS.strName,
			strMainStoresID,bulkPO.intYear , bulkGH.intYear ,
			bulkPO.dblUnitPrice,BPOH.strCurrency ";

			
			$result_2=$db->RunQuery($sql_2);
			
	while($row_2=mysql_fetch_array($result_2))
	{
		
		$GRNBalanceQty = $row_2["GRNBalanceQty"];
		$PONo = $row_2["BPONo"];
		$poYear = $row_2["POyear"];
		$GRNno  = $row_2["intBulkGrnNo"];
		$GRNyear = $row_2["grnYear"];
		$BPONo   = $row_2["BPONo"];
		$strInvoiceNo = $row_2["strInvoiceNo"];
		$mainStoreName  = $row_2["strName"];
		$strColor       = $row_2["strColor"];
		$strSize        = $row_2["strSize"];
		$strUnit        = $row_2["strUnit"];
		$BulkPOQty      = $row_2["BulkPOQty"];
		$unitPrice      = $row_2["dblUnitPrice"];
		$currencyID		=  $row_2["strCurrency"];
		$bulkAlloQty = GetSavedBulkAlloQty($matDetailId,$row_2["strColor"],$row_2["strSize"],$PONo,$poYear,$GRNno,$GRNyear,$companyId);
		$balQty = round((float)$GRNBalanceQty-(float)$bulkAlloQty,2);
		//echo $balQty;
		
		//get ratio bal qty for this style 
		$matRatioQty = getMatRatioQty($matDetailId,$StyleID,$row_2["strColor"],$row_2["strSize"],'bal');
		$pengingBulkQty = GetPendingBulkAlloQty($matDetailId,$row_2["strColor"],$row_2["strSize"],$companyId,$StyleID);
		//get pending leftover allocation qty
		$pengingleftQty = GetPendingLeftAlloQty($StyleID,$matDetailId,$row_2["strColor"],$row_2["strSize"],$companyId);
		//get pending liability allocation qty
		$pendingLiabilityQty = GetPendingLiabilityAlloQty($StyleID,$matDetailId,$row_2["strColor"],$row_2["strSize"],$companyId);
		
		$matBalQty = $matRatioQty - $pengingBulkQty-$pengingleftQty-$pendingLiabilityQty;
		$totRatioQty = getMatRatioQty($matDetailId,$StyleID,$row_2["strColor"],$row_2["strSize"],'ratio');
		
		$baseCurrncy = getBaseCurrency();
		$baseCurrencyVal = $unitPrice;
		if ($currencyID != trim($baseCurrncy))
				{
					$baseCurrencyVal = getUSDValue($unitPrice,$currencyID);
				}
		if($balQty>0){
		
			$ResponseXML .= "<tr class=\"bcgcolor-tblrowWhite\">"; 
			$ResponseXML .= "<td width=\"20\" class=\"normalfntMid\"> ".++$i."</td>";
        $ResponseXML .=" <td width=\"100\" class=\"normalfntMid\" id=". $poYear . ">$BPONo </td>
             <td width=\"100\" class=\"normalfntMid\" id=". $GRNyear .">" .$GRNno."</td>
             <td width=\"100\" class=\"normalfntMid\">". $strInvoiceNo . "</td>
		<td width=\"200\" class=\"normalfntMid\" id=" . $mainStore .">" .$mainStoreName ."</td>
		<td width=\"100\" class=\"normalfntMid\" id=". $matBalQty.">" .$strColor ."</td>
		<td width=\"100\" class=\"normalfntMid\" id=". $totRatioQty.">" . $strSize . "</td>
		<td width=\"100\" class=\"normalfntMid\">" . $strUnit ."</td>
        <td width=\"100\" class=\"normalfntRite\">" .$BulkPOQty . "</td>
		<td width=\"100\" class=\"normalfntRite\">" .$balQty . "</td>
		<td class=\"normalfntMid\"><input type=\"checkbox\" id=\"chkBulkCheckLeft\" name=\"chkBulkCheckLeft\" onclick=\"GetBulkQty(this);\"/></td>
		<td class=\"normalfntMid\"><input type=\"text\" id=\"txtBulkTransferQty\" class=\"txtbox\" style=\"width:75%;text-align:right\" name=\"txtBulkTransferQty\" value=\"\" onkeyup=\"ValidateBulkQty(this);\" onkeypress=\"return isNumberKey(event);\"/></td>
         <td width=\"100\" class=\"normalfntRite\">" . $baseCurrencyVal . "</td>
	</tr>";
		}
	}
		//$ResponseXML .= $sql_2;
		echo $ResponseXML;
}

elseif($RequestType=="viewLeftOver")
{

$color_array 	= array();
$size_array 	= array();
$styleId        = $_GET["toStyleId"];
$matDetailId    = $_GET["matDetailId"];
#$MainStoreID    = $_GET["MainStoreID"];
$strColor       = $_GET["itemColor"];
$itemSize       = $_GET["itemSize"];
$iOption        = $_GET["opt"];
//echo "Style Code - '$styleId' ";
//echo "Color is '$strColor'";
//$companyId   = GetCompanyDetails($MainStoreID);



	/*$header = "<tr bgcolor=\"#498CC2\">
			<td width=\"1%\" class=\"normaltxtmidb2\">&nbsp;</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Main Store</td>
			<td width=\"10%\" height=\"15\" class=\"normaltxtmidb2\">Order No</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Buyer PoNo</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Color</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Size</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Unit</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Stock Qty</td>
			<td width=\"1%\" class=\"normaltxtmidb2\"></td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Transfer Qty</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">GRN No</td>
			<td width=\"8%\" class=\"normaltxtmidb2\">GRN Year</td>
			<td width=\"8%\" class=\"normaltxtmidb2\">GRN Type</td>
		</tr>"; */

    $header = "<tr bgcolor=\"#498CC2\">
                <td width=\"2%\" class=\"normaltxtmidb2\">&nbsp;</td>
                <td width=\"9%\" class=\"normaltxtmidb2\">Main Store</td>
                <td width=\"4%\" height=\"15\" class=\"normaltxtmidb2\">SC No</td>
                <td width=\"10%\" height=\"15\" class=\"normaltxtmidb2\">Style No</td>
                <td width=\"6%\" class=\"normaltxtmidb2\">Buyer PoNo</td>
                <td width=\"8%\" class=\"normaltxtmidb2\">Color</td>
                <td width=\"8%\" class=\"normaltxtmidb2\">Size</td>
                <td width=\"4%\" class=\"normaltxtmidb2\">Unit</td>
                <td width=\"6%\" class=\"normaltxtmidb2\">Stock Qty</td>
                <td width=\"2%\" class=\"normaltxtmidb2\"></td>
                <td width=\"6%\" class=\"normaltxtmidb2\">Transfer Qty</td>
                <td width=\"5%\" class=\"normaltxtmidb2\">GRN No</td>
                <td width=\"5%\" class=\"normaltxtmidb2\">GRN Year</td>
                <td width=\"3%\" class=\"normaltxtmidb2\">GRN Type </td>
                <td width=\"5%\" class=\"normaltxtmidb2\">Sub Stores</td>
                <td width=\"7%\" class=\"normaltxtmidb2\">Location </td>
                <td width=\"5%\" class=\"normaltxtmidb2\">BIN No</td>
		</tr>";
		//<input type=\"checkbox\" id=\"chkCheckAll\" name=\"chkCheckAll\" onclick=\"chkCheckAll(this);\"/>
/*		$loop1 =0;
$sql_color="select distinct strColor from materialratio where intStyleId='$styleId' and strMatDetailID='$matDetailId '";
echo $sql_color;
$result_color=$db->RunQuery($sql_color);
while($row_color=mysql_fetch_array($result_color))
{
	$color_array[$loop1] = "'" . $row_color["strColor"] . "'";
	$loop1++;
}

$loop2 =0;
$sql_size="select distinct strSize from materialratio where intStyleId='$styleId' and strMatDetailID='$matDetailId '";
$result_size=$db->RunQuery($sql_size);
while($row_size=mysql_fetch_array($result_size))
{
	$size_array[$loop2] = "'" . $row_size["strSize"] . "'";
	$loop2++;
}*/
#	$color	= implode(",", $color_array); 
#	$size 	= implode(",", $size_array); 
	
	/*$sql_1=" select sum(S.dblQty)as stockQty, strMainStoresID, strName, S.intStyleId, O.strOrderNo, S.strBuyerPoNo, strColor, strSize, strUnit,intGrnNo,intGrnYear,strGRNType from stocktransactions_leftover S  inner join mainstores MS on S.strMainStoresID=MS.strMainID  inner join orders O on O.intStyleId=S.intStyleId
                 where  S.intMatDetailId='$matDetailId' and strColor in ($strColor) and strSize in ($itemSize)  group by strMainStoresID,intStyleId,strBuyerPoNo,strColor,strSize,intGrnNo,intGrnYear,strGRNType ";*/
        $sql_1 = " select sum(S.dblQty)as stockQty, strMainStoresID, strName, S.intStyleId, O.strOrderNo, S.strBuyerPoNo, strColor, strSize, strUnit,intGrnNo,intGrnYear,strGRNType, specification.intSRNO,
                    substores.strSubID, substores.strSubStoresName, storeslocations.strLocID, storeslocations.strLocName, storesbins.strBinID, storesbins.strBinName
                   from stocktransactions_leftover AS S INNER JOIN mainstores AS MS ON S.strMainStoresID = MS.strMainID INNER JOIN orders AS O ON O.intStyleId = S.intStyleId
INNER JOIN specification ON O.intStyleId = specification.intStyleId
INNER JOIN substores ON substores.strMainID = S.strMainStoresID AND substores.strSubID = S.strSubStores
INNER JOIN storeslocations ON storeslocations.strMainID = S.strMainStoresID AND storeslocations.strSubID = S.strSubStores AND storeslocations.strLocID = S.strLocation
INNER JOIN storesbins ON storesbins.strLocID = S.strLocation AND storesbins.strMainID = S.strMainStoresID AND storesbins.strSubID = S.strSubStores AND storesbins.strBinID = S.strBin
                   where  S.intMatDetailId='$matDetailId'";
        if($iOption == 2){
            $sql_1 .= " and strColor in ($strColor) and strSize in ($itemSize)";
        }
                         
              $sql_1 .= "group by strMainStoresID,intStyleId,strBuyerPoNo,strColor,strSize,intGrnNo,intGrnYear,strGRNType, substores.strSubStoresName, storeslocations.strLocName, storesbins.strBinName "; 
        //AND S.strMainStoresID='$MainStoreID'
	$result_1=$db->RunQuery($sql_1);
	//echo $sql_1;
	while($row_1=mysql_fetch_array($result_1))
	{
		$savedAlloQty = GetSavedAlloQty($row_1["intStyleId"],$matDetailId,$row_1["strColor"],$row_1["strSize"],$companyId,$row_1["intGrnNo"],$row_1["intGrnYear"],$row_1["strGRNType"]);
		
		$qty = $row_1["stockQty"];
		//$stockQty =(float)$qty-(float)$savedAlloQty;
                $stockQty =(float)$qty;
		if($stockQty>0){
		
		if(trim($row_1["strBuyerPoNo"])=="#Main Ratio#")
			$buyerPoNo = "#Main Ratio#";
		else 
			$buyerPoNo = GetBuyerPoName($row_1["strBuyerPoNo"]);
		
		//get ratio bal qty for this style 
		$matRatioQty = getMatRatioQty($matDetailId,$styleId,$strColor,$itemSize,'bal');
		$pengingBulkQty = GetPendingBulkAlloQty($matDetailId,$row_1["strColor"],$row_1["strSize"],$companyId,$styleId);
		//get pending leftover allocation qty
		$pengingleftQty = GetPendingLeftAlloQty($styleId,$matDetailId,$row_1["strColor"],$row_1["strSize"],$companyId);
		//pending liability allocation qty
		$pendingLiabilityQty = GetPendingLiabilityAlloQty($styleId,$matDetailId,$row_1["strColor"],$row_1["strSize"],$companyId);
		$matBalQty = $matRatioQty - $pengingBulkQty-$pengingleftQty-$pendingLiabilityQty;
		$totRatioQty = getMatRatioQty($matDetailId,$styleId,$strColor,$strColor,'ratio');
		
		if($row_1["strGRNType"]=='B')
			$grnType = 'Bulk';
		elseif($row_1["strGRNType"]=='S')
			$grnType = 'Style';
		$tblStr .= "<tr class=\"bcgcolor-tblrowWhite\">
		<td class=\"normalfntMid\">". ++$loop ."</td>
		<td class=\"normalfntMid\" id=" . $row_1["strMainStoresID"]. ">". $row_1["strName"] ."</td>
                <td class=\"normalfntMid\" id=". $row_1["intStyleId"]. ">". $row_1["intSRNO"] ."</td>    
		<td class=\"normalfntMid\" id=". $row_1["intStyleId"]. ">". $row_1["strOrderNo"] ."</td>
		<td class=\"normalfntMid\" id=\"". $row_1["strBuyerPoNo"]."\">". $buyerPoNo ."</td>
		<td class=\"normalfntMid\" id=". $matBalQty.">". $row_1["strColor"] ."</td>
		<td class=\"normalfntMid\" id=". $matRatioQty.">". $row_1["strSize"] ."</td>
		<td class=\"normalfntMid\" >" . $row_1["strUnit"] ."</td>
		<td class=\"normalfntMid\">" . $stockQty ."</td>
		<td class=\"normalfntMid\"><input type=\"checkbox\" id=\"chkCheckLeft\" name=\"chkCheckLeft\" onclick=\"GetQty(this);\"/></td>
		<td class=\"normalfntMid\"><input type=\"text\" id=\"txtTransferQty\" class=\"txtbox\" style=\"width:75%;text-align:right\" name=\"txtTransferQty\"   onkeyup=\"ValidateQty(this);\" onkeypress=\"return isNumberKey(event);\"/></td>
		<td class=\"normalfntMid\">". $row_1["intGrnNo"] ."</td>
		<td class=\"normalfntMid\">" . $row_1["intGrnYear"] ."</td>
		<td class=\"normalfntMid\" id=\"" . $row_1["strGRNType"] ."\">". $grnType ."</td>
                <td class=\"normalfntMid\" id=". $row_1["strSubID"]. ">". $row_1["strSubStoresName"] ."</td>
                <td class=\"normalfntMid\" id=". $row_1["strLocID"]. ">". $row_1["strLocName"] ."</td>
                <td class=\"normalfntMid\" id=". $row_1["strBinID"]. ">". $row_1["strBinName"] ."</td>
	</tr>";
			}
	}
	
	echo $header.$tblStr;
}

elseif($RequestType=="viewLiability")
{

$color_array 	= array();
$size_array 	= array();
$styleId        = $_GET["toStyleId"];
$matDetailId    = $_GET["matDetailId"];
$MainStoreID    = $_GET["MainStoreID"];
$companyId   = GetCompanyDetails($MainStoreID);

	$header = "<tr bgcolor=\"#498CC2\">
			<td width=\"1%\" class=\"normaltxtmidb2\">&nbsp;</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Main Store</td>
			<td width=\"10%\" height=\"15\" class=\"normaltxtmidb2\">Order No</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Buyer PoNo</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Color</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Size</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Unit</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Stock Qty</td>
			<td width=\"1%\" class=\"normaltxtmidb2\"></td>
			<td width=\"10%\" class=\"normaltxtmidb2\">Transfer Qty</td>
			<td width=\"10%\" class=\"normaltxtmidb2\">GRN No</td>
			<td width=\"8%\" class=\"normaltxtmidb2\">GRN Year</td>
			<td width=\"8%\" class=\"normaltxtmidb2\">GRN Type</td>
		</tr>"; 
		//<input type=\"checkbox\" id=\"chkCheckAll\" name=\"chkCheckAll\" onclick=\"chkCheckAll(this);\"/>
		$loop1 =0;
$sql_color="select distinct strColor from materialratio where intStyleId='$styleId' and strMatDetailID='$matDetailId '";
$result_color=$db->RunQuery($sql_color);
while($row_color=mysql_fetch_array($result_color))
{
	$color_array[$loop1] = "'" . $row_color["strColor"] . "'";
	$loop1++;
}

$loop2 =0;
$sql_size="select distinct strSize from materialratio where intStyleId='$styleId' and strMatDetailID='$matDetailId '";
$result_size=$db->RunQuery($sql_size);
while($row_size=mysql_fetch_array($result_size))
{
	$size_array[$loop2] = "'" . $row_size["strSize"] . "'";
	$loop2++;
}
	$color	= implode(",", $color_array); 
	$size 	= implode(",", $size_array); 
	
	$sql_1="select sum(S.dblQty)as stockQty, strMainStoresID, strName, S.intStyleId, O.strOrderNo, S.strBuyerPoNo, strColor, strSize, strUnit,intGrnNo,intGrnYear,strGRNType from stocktransactions_liability S  inner join mainstores MS on S.strMainStoresID=MS.strMainID  inner join orders O on O.intStyleId=S.intStyleId
where  S.intMatDetailId='$matDetailId' and strColor in ($color) and strSize in ($size) AND S.strMainStoresID='$MainStoreID' group by strMainStoresID,intStyleId,strBuyerPoNo,strColor,strSize,intGrnNo,intGrnYear,strGRNType ";
	$result_1=$db->RunQuery($sql_1);
	//echo $sql_1;
	while($row_1=mysql_fetch_array($result_1))
	{
		$savedAlloQty = GetSavedLiabilityAlloQty($row_1["intStyleId"],$matDetailId,$row_1["strColor"],$row_1["strSize"],$companyId,$row_1["intGrnNo"],$row_1["intGrnYear"],$row_1["strGRNType"]);
		
		$qty = $row_1["stockQty"];
		$stockQty =(float)$qty-(float)$savedAlloQty;
		if($stockQty>0){
		
		if(trim($row_1["strBuyerPoNo"])=="#Main Ratio#")
			$buyerPoNo = "#Main Ratio#";
		else 
			$buyerPoNo = GetBuyerPoName($row_1["strBuyerPoNo"]);
		
		//get ratio bal qty for this style 
		$matRatioQty = getMatRatioQty($matDetailId,$styleId,$row_1["strColor"],$row_1["strSize"],'bal');
		$pengingBulkQty = GetPendingBulkAlloQty($matDetailId,$row_1["strColor"],$row_1["strSize"],$companyId,$styleId);
		//get pending leftover allocation qty
		$pengingleftQty = GetPendingLeftAlloQty($styleId,$matDetailId,$row_1["strColor"],$row_1["strSize"],$companyId);
		//pending liability allocation qty
		$pendingLiabilityQty = GetPendingLiabilityAlloQty($styleId,$matDetailId,$row_1["strColor"],$row_1["strSize"],$companyId);
		
		$matBalQty = $matRatioQty - $pengingBulkQty-$pengingleftQty - $pendingLiabilityQty;
		$totRatioQty = getMatRatioQty($matDetailId,$styleId,$row_1["strColor"],$row_1["strSize"],'ratio');
		
		if($row_1["strGRNType"]=='B')
			$grnType = 'Bulk';
		elseif($row_1["strGRNType"]=='S')
			$grnType = 'Style';
		$tblStr .= "<tr class=\"bcgcolor-tblrowWhite\">
		<td class=\"normalfntMid\">". ++$loop ."</td>
		<td class=\"normalfntMid\" id=" . $row_1["strMainStoresID"]. ">". $row_1["strName"] ."</td>
		<td class=\"normalfntMid\" id=". $row_1["intStyleId"]. ">". $row_1["strOrderNo"] ."</td>
		<td class=\"normalfntMid\" id=\"". $row_1["strBuyerPoNo"]."\">". $buyerPoNo ."</td>
		<td class=\"normalfntMid\" id=". $matBalQty.">". $row_1["strColor"] ."</td>
		<td class=\"normalfntMid\" id=". $totRatioQty.">". $row_1["strSize"] ."</td>
		<td class=\"normalfntMid\" >" . $row_1["strUnit"] ."</td>
		<td class=\"normalfntMid\">" . $stockQty ."</td>
		<td class=\"normalfntMid\"><input type=\"checkbox\" id=\"chkCheckLiability\" name=\"chkCheckLiability\" onclick=\"GetLiabilityQty(this);\"/></td>
		<td class=\"normalfntMid\"><input type=\"text\" id=\"txtTransferQty\" class=\"txtbox\" style=\"width:75%;text-align:right\" name=\"txtTransferQty\"   onkeyup=\"ValidateLiabilityQty(this);\" onkeypress=\"return isNumberKey(event);\"/></td>
		<td class=\"normalfntMid\">". $row_1["intGrnNo"] ."</td>
		<td class=\"normalfntMid\">" . $row_1["intGrnYear"] ."</td>
		<td class=\"normalfntMid\" id=\"" . $row_1["strGRNType"] ."\">". $grnType ."</td>
	</tr>";
			}
	}
	
	echo $header.$tblStr;
}


//get BulkAllocatedQty for relavent Style
elseif($RequestType=="viewAllocatedBulkQtyforStyle")
{
global $db;
	$color_array 	= array();
	$size_array 	= array();
	$styleId        = $_GET["toStyleId"];
	$matDetailId    = $_GET["matDetailId"];
	
	
	$loop1 =0;
	$sql_color="select distinct strColor from materialratio where intStyleId='$styleId' and strMatDetailID='$matDetailId '";
	$result_color=$db->RunQuery($sql_color);
	while($row_color=mysql_fetch_array($result_color))
	{
		$color_array[$loop1] = "'" . $row_color["strColor"] . "'";
		$loop1++;
	}
	
	$loop2 =0;
	$sql_size="select distinct strSize from materialratio where intStyleId='$styleId' and strMatDetailID='$matDetailId '";
	$result_size=$db->RunQuery($sql_size);
	while($row_size=mysql_fetch_array($result_size))
	{
		$size_array[$loop2] = "'" . $row_size["strSize"] . "'";
		$loop2++;
	}

		
	$color	= implode(",", $color_array); 
	$size 	= implode(",", $size_array); 
	
	$SQL = "select sum(dblQty) as totQty 
			from commonstock_bulkdetails CBD inner join commonstock_bulkheader CBH on
			CBH.intTransferNo = CBD.intTransferNo and 
			CBH.intTransferYear = CBD.intTransferYear 
			where CBD.intMatDetailId='$matDetailId' and CBH.intToStyleId='$styleId' and CBD.strColor in ($color) and CBD.strSize in ($size) ";
			//echo $SQL;
			$result=$db->RunQuery($SQL);
			$row=mysql_fetch_array($result);
			
			$totQty = $row["totQty"];
			echo $totQty;
	
}

elseif($RequestType=="viewAllocatedLeftQtyforStyle")
{

	$color_array 	= array();
	$size_array 	= array();
	$styleId        = $_GET["toStyleId"];
	$matDetailId    = $_GET["matDetailId"];
	
	
	$loop1 =0;
	$sql_color="select distinct strColor from materialratio where intStyleId='$styleId' and strMatDetailID='$matDetailId '";
	$result_color=$db->RunQuery($sql_color);
	while($row_color=mysql_fetch_array($result_color))
	{
		$color_array[$loop1] = "'" . $row_color["strColor"] . "'";
		$loop1++;
	}
	
	$loop2 =0;
	$sql_size="select distinct strSize from materialratio where intStyleId='$styleId' and strMatDetailID='$matDetailId '";
	$result_size=$db->RunQuery($sql_size);
	while($row_size=mysql_fetch_array($result_size))
	{
		$size_array[$loop2] = "'" . $row_size["strSize"] . "'";
		$loop2++;
	}

		
	$color	= implode(",", $color_array); 
	$size 	= implode(",", $size_array); 
	
	$SQL = " select sum(dblQty) as totQty 
			from commonstock_leftoverdetails CBD inner join commonstock_leftoverheader CBH on
			CBH.intTransferNo = CBD.intTransferNo and 
			CBH.intTransferYear = CBD.intTransferYear 
			where CBD.intMatDetailId='$matDetailId' and CBH.intToStyleId='$styleId' and CBD.strColor in ($color) and CBD.strSize in ($size) ";
			
			$result=$db->RunQuery($SQL);
			$row=mysql_fetch_array($result);
			
			$totQty = $row["totQty"];
			echo $totQty;
	
}

function GetSavedAlloQty($styleId,$matDetailId,$color,$size,$companyId,$grnNo,$grnYear,$grnType)
{
global $db;
//global $companyId;
$sql="select sum(LD.dblQty)as stockQty from commonstock_leftoverdetails LD
inner join commonstock_leftoverheader LH on LH.intTransferNo=LD.intTransferNo and LH.intTransferYear=LD.intTransferYear
where LD.intFromStyleId='$styleId'
and LD.intMatDetailId='$matDetailId'
and LD.strColor='$color'
and LD.strSize='$size'
and LH.intStatus=0
and LD.intGrnNo='$grnNo'
and LD.intGrnYear='$grnYear' and LD.strGRNType = '$grnType' ";
//and LH.intCompanyId='$companyId'
//echo $sql;
$result=$db->RunQuery($sql);
$qty = 0;
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["stockQty"];		
	}
	return $qty;	
}

function GetSavedBulkAlloQty($matDetailId,$color,$size,$poNo, $poYear,$grnNo,$grnYear,$companyId)
{
global $db;
//global $companyId;
$sql="select sum(BD.dblQty) as AlloQty from commonstock_bulkdetails BD
inner join commonstock_bulkheader BH on BH.intTransferNo=BD.intTransferNo and BH.intTransferYear=BD.intTransferYear
where BD.intMatDetailId='$matDetailId'
and BD.strColor='$color'
and BD.strSize='$size'
and BH.intCompanyId='$companyId'
and BH.intStatus=0
and BD.intBulkPoNo='$poNo'
and BD.intBulkPOYear='$poYear'
and BD.intBulkGrnNo='$grnNo'
and BD.intBulkGRNYear='$grnYear'";
$result=$db->RunQuery($sql);
$qty = 0;
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["AlloQty"];		
	}
	return $qty;	
}

function GetSavedLiabilityAlloQty($styleId,$matDetailId,$color,$size,$companyId,$grnNo,$grnYear,$grnType)
{
global $db;
//global $companyId;
$sql="select sum(LD.dblQty)as stockQty from commonstock_liabilitydetails LD
inner join commonstock_liabilityheader LH on LH.intTransferNo=LD.intTransferNo and LH.intTransferYear=LD.intTransferYear
where LD.intFromStyleId='$styleId'
and LD.intMatDetailId='$matDetailId'
and LD.strColor='$color'
and LD.strSize='$size'
and LH.intCompanyId='$companyId'
and LH.intStatus=0
and LD.intGrnNo='$grnNo'
and LD.intGrnYear='$grnYear' and LD.strGRNType = '$grnType' ";
//echo $sql;
$result=$db->RunQuery($sql);
$qty = 0;
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["stockQty"];		
	}
	return $qty;	
}

function GetPendingBulkAlloQty($matDetailId,$color,$size,$companyId,$StyleID)
{
global $db;
//global $companyId;
$sql="select sum(BD.dblQty) as AlloQty from commonstock_bulkdetails BD
inner join commonstock_bulkheader BH on BH.intTransferNo=BD.intTransferNo and BH.intTransferYear=BD.intTransferYear
where BD.intMatDetailId='$matDetailId'
and BD.strColor='$color'
and BD.strSize='$size'
and BH.intCompanyId='$companyId'
and BH.intStatus=0 and BH.intToStyleId = '$StyleID' ";

//echo $sql;
$result=$db->RunQuery($sql);
$qty = 0;
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["AlloQty"];		
	}
	return $qty;	
}
function GetPendingLeftAlloQty($styleId,$matDetailId,$color,$size,$companyId)
{
global $db;
//global $companyId;
$sql="select sum(LD.dblQty)as stockQty from commonstock_leftoverdetails LD
inner join commonstock_leftoverheader LH on LH.intTransferNo=LD.intTransferNo and LH.intTransferYear=LD.intTransferYear
where LH.intToStyleId='$styleId'
and LD.intMatDetailId='$matDetailId'
and LD.strColor='$color'
and LD.strSize='$size'
and LH.intCompanyId='$companyId'
and LH.intStatus=0 ";
//echo $sql;
$result=$db->RunQuery($sql);
$qty = 0;
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["stockQty"];		
	}
	return $qty;	
}
function GetPendingLiabilityAlloQty($styleId,$matDetailId,$color,$size,$companyId)
{
global $db;
//global $companyId;
$sql="select sum(LD.dblQty)as stockQty from commonstock_liabilitydetails LD
inner join commonstock_liabilityheader LH on LH.intTransferNo=LD.intTransferNo and LH.intTransferYear=LD.intTransferYear
where LH.intToStyleId='$styleId'
and LD.intMatDetailId='$matDetailId'
and LD.strColor='$color'
and LD.strSize='$size'
and LH.intCompanyId='$companyId'
and LH.intStatus=0 ";
//echo $sql;
$result=$db->RunQuery($sql);
$qty = 0;
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["stockQty"];		
	}
	return $qty;	
}
function GetCompanyDetails($MainStoreID)
{
	global $db;
	$SQL = "select intCompanyId 
			from mainstores
			where strMainID='$MainStoreID'";
			//where intStatus=1 and intAutomateCompany=0 and strMainID='$MainStoreID'
		$result=$db->RunQuery($SQL);	
		$row=mysql_fetch_array($result);
		
		return $row["intCompanyId"];	
}

function GetBuyerPoName($buyerPoId)
{
global $db;
$sql="select strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoId'";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
return $row["strBuyerPoName"];
}

function getMatRatioQty($matDetailId,$StyleID,$color,$size,$type)
{
	global $db;
	$SQL = " SELECT dblQty,dblBalQty FROM materialratio WHERE intStyleId = '$StyleID' AND strMatDetailID = '$matDetailId' and 		 strColor=$color and strSize=$size" ;
	//echo $SQL;
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);

	if($type == 'bal')
	{
		$balQty = $row["dblBalQty"];
		if($balQty == '' || is_null($balQty))
		{
			$balQty = 0;
		}
	}
	else
	{
		$balQty = $row["dblQty"];
	}
	
	//echo ($balQty);
	return $balQty;
}

function getUSDValue($value,$currency)
{
	global $db;
	$dollarRate = 1;
	$sql = "SELECT ER.rate FROM exchangerate ER WHERE ER.currencyID = '". $currency . "' and ER.intStatus=1;";
	$rst = $db->RunQuery($sql);
	while($rw = mysql_fetch_array($rst))
	{
		$dollarRate = $rw["rate"];
		break;
	}
	return round(($value / $dollarRate),4);
}

function getBaseCurrency()
{
	global $db;
	global $db;
	$sql="select intBaseCurrency from systemconfiguration";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["intBaseCurrency"];
}

?>