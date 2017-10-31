<?php 
session_start();
include "../../Connector.php" ;	

$backwardseperator 	= "../../";	
	$strStyleNo			= $_GET["strStyleNo"];
	$strBPo				= $_GET["strBPo"];
	$intMeterial 		= $_GET["intMeterial"];
	$intCategory 		= $_GET["intCategory"];
	$intDescription 	= $_GET["intDescription"];
	$intSupplier 		= $_GET["intSupplier"];
	$intBuyer 	  		= $_GET["intBuyer"];
	$dtmDateFrom		= $_GET["dtmDateFrom"];
	$dtmDateTo 	  		= $_GET["dtmDateTo"];
	$noTo 	  			= $_GET["noTo"];
	$noFrom 	  		= $_GET["noFrom"];	
	$intCompany     	= $_GET["intCompany"];
	$intStatus 			= $_GET["status"];
	$txtMatItem			= $_GET["txtMatItem"];
	$report_companyId =$_SESSION["FactoryID"];
	
	function xlsBOF() {
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); 
    return;
}
// Excel end of file footer
function xlsEOF() {
    echo pack("ss", 0x0A, 0x00);
    return;
}
// Function to write a Number (double) into Row, Col
function xlsWriteNumber($Row, $Col, $Value) {
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
    echo pack("d", $Value);
    return;
}
// Function to write a label (text) into Row, Col
function xlsWriteLabel($Row, $Col, $Value) {
    $L = strlen($Value);
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    echo $Value;
return;
} 
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");    
header ("Pragma: no-cache");    
header ('Content-type: application/x-msexcel');
header ("Content-Disposition: attachment; filename=StyleReportGRN.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream
	

	$i=4;
		 xlsWriteLabel(2,5,"GRN REGISTER");
		 
				xlsWriteLabel($i,0,"GRN No");
				xlsWriteLabel($i,1,"PO No");
				xlsWriteLabel($i,2,"Supplier");
				xlsWriteLabel($i,3,"Currency");
				xlsWriteLabel($i,4,"Invoice No");
				xlsWriteLabel($i,5,"PI No");
				xlsWriteLabel($i,6,"Date");
				xlsWriteLabel($i,7,"Order No");
				xlsWriteLabel($i,8,"ScNo");
				xlsWriteLabel($i,9,"Buyer PoNo");
				xlsWriteLabel($i,10,"Mat");
				xlsWriteLabel($i,11,"Item Description");
				xlsWriteLabel($i,12,"Color");
				xlsWriteLabel($i,13,"Size");
				xlsWriteLabel($i,14,"Ratio ID");
				xlsWriteLabel($i,15,"Unit");
				xlsWriteLabel($i,16,"Qty");
				xlsWriteLabel($i,17,"Rate");
				xlsWriteLabel($i,18,"Amount");
				xlsWriteLabel($i,19,"Ret To Supp.");
				xlsWriteLabel($i,20,"Issue Qty");
				
				$i++;

			# ===============================================================================
			# Add On - 02/02/2016
			# Add By - Nalin Jayakody
			# Adding - Add Ratio ID from material Ratio
			# ===============================================================================	
				
				$detailSql="SELECT  GH.intGrnNo,
GH.intGRNYear,  
grndetails.strBuyerPONO,
grndetails.intStyleId,
grndetails.intMatDetailID, 
DATE_FORMAT(GH.dtmRecievedDate,'%m/%d/%Y') AS dtmRecievedDate,
matitemlist.intMainCatID,
matitemlist.intSubCatID,
GH.intStatus, 
matmaincategory.strDescription, 
matitemlist.strItemDescription,
grndetails.strColor , 
grndetails.strSize, 
grndetails.dblQty AS dblQty, 
((grndetails.dblQty) -  grndetails.dblBalance) AS retToSup,
POD.dblUnitPrice,
POD.strUnit,
specification.intSRNO,
orders.strOrderNo,
GH.intGRNYear,
suppliers.strTitle, 
POH.strPINO,
GH.strInvoiceNo,
POH.intPONo,
POH.intYear as POyear,
(select strCurrency from currencytypes CT where CT.intCurID=POH.strCurrency)as currencyName,
(select materialratio.materialRatioID  from materialratio where materialratio.intStyleId = grndetails.intStyleId and materialratio.strMatDetailID = grndetails.intMatDetailID and materialratio.strColor = grndetails.strColor and materialratio.strSize = grndetails.strSize and materialratio.strBuyerPONO = grndetails.strBuyerPONO) as ItemCode
FROM grnheader GH
INNER JOIN grndetails ON GH.intGrnNo=grndetails.intGrnNo AND GH.intGRNYear=grndetails.intGRNYear 
INNER JOIN purchaseorderheader POH ON GH.intPoNo=POH.intPONo AND GH.intYear=POH.intYear 
INNER JOIN specification ON grndetails.intStyleId=specification.intStyleId 
INNER JOIN matitemlist ON grndetails.intMatDetailID=matitemlist.intItemSerial 
INNER JOIN orders ON grndetails.intStyleId=orders.intStyleId 
INNER JOIN matmaincategory ON matitemlist.intMainCatID=matmaincategory.intID 
inner join suppliers on POH.strSupplierID=suppliers.strSupplierID
inner join purchaseorderdetails POD on POH.intPoNo= POD.intPoNo  and POH.intYear= POD.intYear and POD.intStyleId=grndetails.intStyleId and POD.intMatDetailID=grndetails.intMatDetailID and POD.strColor=grndetails.strColor and POD.strSize=grndetails.strSize
WHERE GH.intStatus='$intStatus' ";

			if($noFrom!=""){
				$detailSql .= " and GH.intGrnNo >= '$noFrom'";
			}
			if($noTo!=""){
				$detailSql .= " and GH.intGrnNo <= '$noTo'";
			}	
			if ($strStyleNo!= "")
			{ 
				$detailSql .= " and grndetails.intStyleId ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$detailSql .= " and grndetails.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intCompany!="")
			{
				$detailSql .= " AND GH.intCompanyID=$intCompany  ";
			}
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " AND matitemlist.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$detailSql .= " AND matitemlist.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "")
			{
				$detailSql .= " AND POD.intMatDetailID=$intDescription ";						
			}
			if ($txtMatItem!= "")
			{				
				$detailSql .= " and matitemlist.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intSupplier!="")
			{			
				$detailSql .= " and POH.strSupplierID=$intSupplier ";
			}

			if ($intBuyer!="")
			{			
				$detailSql .= " and orders.intBuyerID=$intBuyer";				
			}
			
			if($dtmDateFrom!="")
			{					
				$detailSql .= " and DATE_FORMAT(GH.dtmRecievedDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
			}
			
			if($dtmDateTo!="")
			{					
			$detailSql .= " and DATE_FORMAT(GH.dtmRecievedDate,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
			
				$detailSql .= " GROUP BY grndetails.intStyleId, grndetails.strBuyerPONO,GH.strInvoiceNo, grndetails.intMatDetailID, grndetails.strColor, grndetails.strSize, GH.intGrnNo order by GH.intGrnNo  ";	
			$detailResult = $db->RunQuery($detailSql);
			//echo $detailSql;
			
			while ($details=mysql_fetch_array($detailResult))
			{
				xlsWriteLabel($i,0,$details["intGRNYear"].'/'.$details["intGrnNo"]); 
				xlsWriteLabel($i,1,$details["POyear"].'/'.$details["intPONo"]); 
				xlsWriteLabel($i,2,$details["strTitle"]);
				xlsWriteLabel($i,3,$details["currencyName"]);
				xlsWriteLabel($i,4,$details["strInvoiceNo"]);
				xlsWriteLabel($i,5,$details["strPINO"]);
				xlsWriteLabel($i,6,$details["dtmRecievedDate"]);
				xlsWriteLabel($i,7,$details["strOrderNo"]);
				xlsWriteLabel($i,8,$details["intSRNO"]);
				xlsWriteLabel($i,9,$details["strBuyerPONO"]);
				xlsWriteLabel($i,10,substr($details["strDescription"],0,3));
				xlsWriteLabel($i,11,$details["strItemDescription"]);
				xlsWriteLabel($i,12,$details["strColor"]);
				xlsWriteLabel($i,13,$details["strSize"]);
				xlsWriteLabel($i,14,$details["ItemCode"]);
				xlsWriteLabel($i,15,$details["strUnit"]);
				xlsWriteNumber($i,16,$details["dblQty"]);
				xlsWriteLabel($i,17,$details["dblUnitPrice"]);
				xlsWriteNumber($i,18,$details["dblQty"]*$details["dblUnitPrice"]);
				xlsWriteNumber($i,19,$details["retToSup"]);
				xlsWriteNumber($i,20,round(GetISSUEQty($details["intGrnNo"],$details["intGRNYear"],$details["intStyleId"],$details["strBuyerPONO"],$details["intMatDetailID"],$details["strColor"],$details["strSize"]),2));
				$i++;	
			}
			
		//}				
			xlsEOF();
			
function GetISSUEQty($GrnNo,$GrnYear,$styleId,$buyerPoNo,$matId,$color,$size)
{
global $db;
$qty = 0;
	$sql="select sum(ID.dblQty)as qty 
			from issuesdetails ID 
			where ID.intGrnNo='$GrnNo' and ID.intGrnYear='$GrnYear' 
			and ID.intStyleId='$styleId' and ID.strBuyerPONO='$buyerPoNo' 
			and ID.intMatDetailID='$matId' and ID.strColor='$color' 
			and ID.strSize='$size';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["qty"];
	}
return $qty;
}


function ConvertDateFormat($FormatType, $DateValue){
	
    $FormattedDateValue='';
    $arrayDateValue = explode('-', $DateValue);

    switch($FormatType){

        case "UK":
            $FormattedDateValue = $arrayDateValue[2]."/".$arrayDateValue[1]."/".$arrayDateValue[0];
            if(($FormattedDateValue == '//') || ($FormattedDateValue == '00/00/0000')) {$FormattedDateValue = '';}

        break;	

    }

    return $FormattedDateValue;
}
?>
