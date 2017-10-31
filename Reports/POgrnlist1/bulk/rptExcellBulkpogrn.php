<?php 
session_start();
include "../../../Connector.php";
$backwardseperator 	= "../../../";
$report_companyId 	= $_SESSION["FactoryID"];

$cboPONo			= $_GET["cboPONo"];
$cboGRN 			= $_GET["cboGRN"];
$cboInvoice			= $_GET["cboInvoice"];

$txtInvoiceNo		= trim($_GET["txtInvoiceNo"]);
$txtPONo			= trim($_GET["txtPONo"]);
$txtGRNNo			= trim($_GET["txtGRNNo"]);

$cboPONoArray 	= explode('/',$cboPONo);
$cboGRNArray 	= explode('/',$cboGRN);

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
header ("Content-Disposition: attachment; filename=SBulkPOgrnlist.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream

$i=3;
xlsWriteLabel(1,5,"Bulk Purchase Order vs. GRN Report"); 

xlsWriteLabel($i,0,"PO No"); 
xlsWriteLabel($i,1,"GRN No"); 
xlsWriteLabel($i,2,"Invoice No"); 		
xlsWriteLabel($i,3,"Date"); 
xlsWriteLabel($i,4,"Description");
xlsWriteLabel($i,5,"Color");
xlsWriteLabel($i,6,"Size");
xlsWriteLabel($i,7,"Unit");
xlsWriteLabel($i,8,"Qty With Excess");
xlsWriteLabel($i,9,"Excess Qty");
xlsWriteLabel($i,10,"Rate");
xlsWriteLabel($i,11,"Value");
$i++;

$total = 0;
			
$sql="select BGH.intBulkGrnNo,BGH.intYear,BGH.intBulkPoNo,BGH.intBulkPoYear,MSC.StrCatName,
		MIL.strItemDescription,BGD.strColor,BGD.strSize,BGD.strUnit,round(BGD.dblQty,2) as GrnQty,BGD.dblRate,
		round(BGD.dblExQty,2) as dblExQty,round(BGD.dblBalance,4) as dblBalance ,BGH.strInvoiceNo,
		BGH.intStatus,BGD.intMatDetailID,date(BGH.dtmConfirmedDate) as dtmConfirmedDate
		FROM bulkgrndetails BGD 
		INNER JOIN bulkgrnheader BGH ON (BGD.intBulkGrnNo=BGH.intBulkGrnNo)  AND (BGH.intYear=BGD.intYear) 
		INNER JOIN matitemlist MIL ON (BGD.intMatDetailID=MIL.intItemSerial) 
		INNER JOIN matsubcategory MSC ON (MIL.intSubCatID=MSC.intSubCatNo)
		WHERE BGH.intBulkPoNo <> 'a'";

if($cboPONo!="")
	$sql .= "and BGH.intBulkPoNo='$cboPONoArray[1]' and BGH.intBulkPoYear='$cboPONoArray[0]' ";

if($txtPONo!="")
	$sql .= "and BGH.intBulkPoNo like '%$txtPONo%' ";
	
if($cboGRN!="")
	$sql .= "and BGH.intBulkGrnNo='$cboGRNArray[1]' and BGH.intYear='$cboGRNArray[0]' ";

if($txtGRNNo!="")
	$sql .= "and BGH.intBulkGrnNo like '%$txtGRNNo%' ";
	
if($cboInvoice!="")
	$sql .= "and BGH.strInvoiceNo='$cboInvoice' ";
	
if($txtInvoiceNo!="")
	$sql .= "and BGH.strInvoiceNo like '%$txtInvoiceNo%' ";
	
$sql .= " order by BGH.intBulkPoYear,BGH.intBulkPoNo ";
$result=$db->RunQuery($sql);
while ($details=mysql_fetch_array($result))
{

	xlsWriteLabel($i,0,$details["intBulkPoYear"].'/'.$details["intBulkPoNo"]); 
	xlsWriteLabel($i,1,$details["intYear"].'/'.$details["intBulkGrnNo"]); 
	xlsWriteLabel($i,2,$details["strInvoiceNo"]); 
	xlsWriteLabel($i,3,$details["dtmConfirmedDate"]); 
	xlsWriteLabel($i,4,$details["strItemDescription"]); 
	xlsWriteLabel($i,5,$details["strColor"]); 
	xlsWriteLabel($i,6,$details["strSize"]); 
	xlsWriteLabel($i,7,$details["strUnit"]); 
	xlsWriteNumber($i,8,$details["GrnQty"]);
	xlsWriteNumber($i,9,$details["dblExQty"]);
	xlsWriteNumber($i,10,$details["dblRate"]);
	xlsWriteNumber($i,11,round($details["dblRate"] * $details["GrnQty"],4));
	
	$totalQty		+= $details["GrnQty"];
	$totalUnitPrice	+= $details["dblRate"] ;
	$totalValue		+= $details["dblRate"]  * $details["GrnQty"];
	$totalExQty		+= $details["dblExQty"];
$i++;
}
xlsWriteNumber($i,8,$totalQty);
xlsWriteNumber($i,9,$totalExQty);
xlsWriteNumber($i,10,round($totalUnitPrice,4));
xlsWriteNumber($i,11,round($totalValue,4));
xlsEOF();	
?>