<?php
// ----- begin of function library -----
// Excel begin of file header
session_start();
include "../../Connector.php" ;	
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
	$intStatus			= $_GET["status"];
	$RequestType 		= $_GET["RequestType"];

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
header ("Content-Disposition: attachment; filename=BulkPurchaseOrderRegister.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream
	
	
$detailSql="SELECT
BPH.dtDate,
MIL.strItemDescription,
BPD.strColor,
BPD.strSize,
BPD.strUnit,
BPD.dblQty,
BPD.dblUnitPrice,
(BPD.dblQty*BPD.dblUnitPrice) amount,
BPD.intBulkPoNo,
BPD.intYear,
BPH.strCurrency,
suppliers.strTitle
FROM
bulkpurchaseorderdetails BPD
Inner Join bulkpurchaseorderheader BPH ON BPH.intBulkPoNo = BPD.intBulkPoNo AND BPH.intYear = BPD.intYear
Inner Join matitemlist MIL ON BPD.intMatDetailId = MIL.intItemSerial
Inner Join suppliers ON suppliers.strSupplierID = BPH.strSupplierID
WHERE BPH.intStatus =   $intStatus ";
			
if ($noFrom!="")
	$detailSql .= " AND BPH.intBulkPoNo >=$noFrom ";
if ($noTo!="")
	$detailSql .= " AND BPH.intBulkPoNo <=$noTo ";			
if ($intCompany!="")
	$detailSql .= " AND BPH.intCompId = $intCompany ";
if ($intMeterial!= "")
	$detailSql .= " AND MIL.intMainCatID=$intMeterial ";	
if ($intCategory!= "")
	$detailSql .= " AND MIL.intSubCatID=$intCategory " ;
if ($intDescription!= "")
	$detailSql .= " and BPD.intMatDetailId=$intDescription ";						
if ($intSupplier!="")
	$detailSql .= " and BPH.strSupplierID=$intSupplier ";
if ($dtmDateFrom!="")
	$detailSql .= " AND DATE_FORMAT(BPH.dtDate,'%Y/%m/%d') >=   DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
if ($dtmDateTo!="")
	$detailSql .= " AND DATE_FORMAT(BPH.dtDate,'%Y/%m/%d') <=  DATE_FORMAT('$dtmDateTo','%Y/%m/%d') ";
if($RequestType=="radOpenPO")
	$detailSql .= "AND BPD.dblPending > 0";
if($RequestType=="radCompPo")
	$detailSql .= "AND BPD.dblPending <= 0";

	$detailSql .=" order By BPD.intBulkPoNo,BPD.intYear;";
	 $result = $db->RunQuery($detailSql); 
	 $i=5;
		xlsWriteLabel(2,5,"BULK PURCHASE ORDER REGISTER"); 
		if ($intStatus==1)
			$listType="(CONFIRMED LIST)";
		elseif ($intStatus==0)
			$listType="(PENDING LIST)";		
		else
		 	$listType="(CANCELED LIST)"; 	
					 
		xlsWriteLabel(3,6, $listType);  
		xlsWriteLabel(4,0,"Po No");
		xlsWriteLabel(4,1,"Currency"); 
		xlsWriteLabel(4,2,"Date");
		xlsWriteLabel(4,3,"Supplier Name");
		xlsWriteLabel(4,4,"Item Description");
		xlsWriteLabel(4,5,"Color");
		xlsWriteLabel(4,6,"Size");
		xlsWriteLabel(4,7,"Unit");
		xlsWriteLabel(4,8,"Qty");
		xlsWriteLabel(4,9,"Unit Price");
		xlsWriteLabel(4,10,"Amount");
		
		while($row= mysql_fetch_array($result))
		{			 	
			xlsWriteLabel($i,0,$row["intYear"].'/'.$row["intBulkPoNo"]);  
			xlsWriteLabel($i,1,GetCurrencyName($row["strCurrency"]));
			xlsWriteLabel($i,2,substr($row["dtDate"],0,10)); 
			xlsWriteLabel($i,3,$row["strTitle"]); 
			xlsWriteLabel($i,4,$row["strItemDescription"]); 
			xlsWriteLabel($i,5,$row["strColor"]); 
			xlsWriteLabel($i,6,$row["strSize"]);
			xlsWriteLabel($i,7,$row["strUnit"]);
			xlsWriteNumber($i,8,round($row["dblQty"],2));
			xlsWriteNumber($i,9,number_format($row["dblUnitPrice"],4));
			xlsWriteNumber($i,10,number_format($row["amount"],4));
			$totalQty += $row["dblQty"];
			$totalAmount += $row["amount"];		 	  
			$i++;					
		}				 	
$totSal = 12;
xlsWriteLabel($i,1,"Total"); 				 		 
xlsWriteNumber($i,8,round($totalQty,2));
xlsWriteNumber($i,10,round($totalAmount,2));
$i += 2;				 	 
xlsEOF();

function GetCurrencyName($currecyId)
{
global $db;
$sql="select strCurrency from currencytypes where intCurID='$currecyId'";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
return $row["strCurrency"];
}
?>
