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
header ("Content-Disposition: attachment; filename=StyleReportGatepass.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream

$i=3;
xlsWriteLabel(1,5,"Purchase Order vs. GRN Report"); 

xlsWriteLabel($i,0,"PO No"); 
xlsWriteLabel($i,1,"GRN No"); 
xlsWriteLabel($i,2,"Invoice No"); 		
xlsWriteLabel($i,3,"Date"); 
xlsWriteLabel($i,4,"Description");
xlsWriteLabel($i,5,"Unit");
xlsWriteLabel($i,6,"Qty With Excess");
xlsWriteLabel($i,7,"Excess Qty");
xlsWriteLabel($i,8,"Rate");
xlsWriteLabel($i,9,"Value");
$i++;

$total = 0;
			
$sql="select GH.strGenGrnNo,GH.intYear,GH.intGenPONo,GH.intGenPOYear,GD.intMatDetailID,MSC.StrCatName,MMC.strDescription,
		MIL.strItemDescription,MIL.strUnit,GD.dblQty,GD.dblExQty,
		GH.strInvoiceNo,GH.intStatus,date(GH.dtRecdDate) as dtmRecievedDate,GD.dblRate
		FROM gengrndetails GD 
		INNER JOIN gengrnheader GH ON (GD.strGenGrnNo=GH.strGenGrnNo)  AND (GH.intYear=GD.intYear) 
		INNER JOIN genmatitemlist MIL ON (GD.intMatDetailID=MIL.intItemSerial) 
		INNER JOIN genmatsubcategory MSC ON (MIL.intSubCatID=MSC.intSubCatNo)
		INNER JOIN genmatmaincategory MMC ON (MIL.intMainCatID=MMC.intID)
		WHERE GH.intStatus <> 'a' ";

if($cboPONo!="")
	$sql .= "and GH.intGenPONo='$cboPONoArray[1]' and GH.intGenPOYear='$cboPONoArray[0]' ";

if($txtPONo!="")
	$sql .= "and GH.intGenPONo like '%$txtPONo%' ";
	
if($cboGRN!="")
	$sql .= "and GH.strGenGrnNo='$cboGRNArray[1]' and GH.intYear='$cboGRNArray[0]' ";

if($txtGRNNo!="")
	$sql .= "and GH.strGenGrnNo like '%$txtGRNNo%' ";
	
if($cboInvoice!="")
	$sql .= "and GH.strInvoiceNo='$cboInvoice' ";
	
if($txtInvoiceNo!="")
	$sql .= "and GH.strInvoiceNo like '%$txtInvoiceNo%' ";

$sql .= " order by GH.strGenGrnNo,GH.intYear ";
$result=$db->RunQuery($sql);
while ($details=mysql_fetch_array($result))
{
	xlsWriteLabel($i,0,$details["intGenPOYear"].'/'.$details["intGenPONo"]); 
	xlsWriteLabel($i,1,$details["intYear"].'/'.$details["strGenGrnNo"]); 
	xlsWriteLabel($i,2,$details["strInvoiceNo"]); 
	xlsWriteLabel($i,3,$details["dtmRecievedDate"]); 
	xlsWriteLabel($i,4,$details["strItemDescription"]); 
	xlsWriteLabel($i,5,$details["strUnit"]); 
	xlsWriteNumber($i,6,$details["dblQty"]);
	xlsWriteNumber($i,7,$details["dblExQty"]);
	xlsWriteNumber($i,8,round($details["dblRate"],4));
	xlsWriteNumber($i,9,round($details["dblRate"]*$details["dblQty"],4));
	
	$totalQty		+= $details["dblQty"];
	$totalUnitPrice	+= $details["dblRate"];
	$totalValue		+= $details["dblRate"]*$details["dblQty"];
	$totalExQty		+= $details["dblExQty"];
$i++;
}
xlsWriteNumber($i,6,$totalQty);
xlsWriteNumber($i,7,$totalExQty);
xlsWriteNumber($i,8,round($totalUnitPrice,4));
xlsWriteNumber($i,9,round($totalValue,4));
xlsEOF();	
?>