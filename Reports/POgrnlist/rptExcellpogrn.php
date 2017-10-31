<?php 
session_start();
//include "../../../Connector.php";
include "../../Connector.php";
$backwardseperator 	= "../../";
$report_companyId 	= $_SESSION["FactoryID"];

$cboPONo			= $_GET["cboPONo"];
$cboOrderNo			= $_GET["cboOrderNo"];
$cboStyle			= $_GET["cboStyle"];
$cboGRN 			= $_GET["cboGRN"];
$cboInvoice			= $_GET["cboInvoice"];
$cboSupplier		= $_GET["cboSupplier"];

$txtInvoiceNo		= trim($_GET["txtInvoiceNo"]);
$txtPONo			= trim($_GET["txtPONo"]);
$txtGRNNo			= trim($_GET["txtGRNNo"]);
$txtOrderNo			= trim($_GET["txtOrderNo"]);
$txtStyleNo			= trim($_GET["txtStyleNo"]);
$txtSupplier		= trim($_GET["txtSupplier"]);

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
header ("Content-Disposition: attachment; filename=POGrnList.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream

$i=3;
xlsWriteLabel(1,5,"Purchase Order vs. GRN Report"); 

xlsWriteLabel($i,0,"PO No"); 
xlsWriteLabel($i,1,"GRN No"); 
xlsWriteLabel($i,2,"Invoice No"); 		
xlsWriteLabel($i,3,"Date"); 
xlsWriteLabel($i,4,"Style No"); 			
xlsWriteLabel($i,5,"SC No");
xlsWriteLabel($i,6,"Description");
xlsWriteLabel($i,7,"Color");
xlsWriteLabel($i,8,"Size");
xlsWriteLabel($i,9,"Unit");
xlsWriteLabel($i,10,"Qty With Excess");
xlsWriteLabel($i,11,"Excess Qty");
xlsWriteLabel($i,12,"Rate");
xlsWriteLabel($i,13,"Value");
/*xlsWriteLabel($i,14,"PO Price");
xlsWriteLabel($i,15,"Invoice Price");
xlsWriteLabel($i,16,"Payment Price");*/
xlsWriteLabel($i,14,"GRN Qty");
xlsWriteLabel($i,15,"Return To Supplier Qty");


$i++;

$total = 0;
			
$sql="select GH.intGrnNo,GH.intGRNYear,GH.intPoNo,GH.intYear,GH.dtmRecievedDate,GD.intStyleId,GD.strBuyerPONO,MSC.StrCatName,MIL.strItemDescription,GD.strColor,GD.strSize,MIL.strUnit,  GD.dblQty,GD.dblPoPrice,GD.dblInvoicePrice,GD.dblPaymentPrice,  GD.dblExcessQty,GD.dblBalance,GH.strInvoiceNo,O.strOrderNo,O.strStyle,GH.intStatus,PD.dblUnitPrice,S.strTitle, specification.intSRNO, MIL.intItemSerial
FROM grndetails GD 
INNER JOIN grnheader GH ON (GD.intGrnNo=GH.intGrnNo)  AND (GH.intGRNYear=GD.intGRNYear) 
INNER JOIN matitemlist MIL ON (GD.intMatDetailID=MIL.intItemSerial) 
INNER JOIN matsubcategory MSC ON (MIL.intSubCatID=MSC.intSubCatNo)
inner join orders O on O.intStyleId = GD.intStyleId
inner join purchaseorderdetails PD on PD.intPoNo=GH.intPoNo and PD.intYear=GH.intYear and PD.intStyleId=GD.intStyleId and PD.intMatDetailID=GD.intMatDetailID and PD.strColor=GD.strColor and PD.strSize=GD.strSize and PD.strBuyerPONO=GD.strBuyerPONO
Inner Join purchaseorderheader POH ON GH.intPoNo = POH.intPONo AND GH.intYear =  POH.intYear 
Inner Join suppliers S ON POH.strSupplierID = S.strSupplierID
Inner Join specification ON O.intStyleId = specification.intStyleId
WHERE GH.intStatus <> 'a' ";

if($cboPONo!="")
	$sql .= "and GH.intPoNo='$cboPONoArray[1]' and GH.intYear='$cboPONoArray[0]' ";

if($txtPONo!="")
	$sql .= "and GH.intPoNo like '%$txtPONo%' ";
	
if($cboStyle!="")
	$sql .= "and O.strStyle='$cboStyle' ";

if($txtStyleNo!="")
	$sql .= "and O.strStyle like '%$txtStyleNo%' ";
	
if($cboOrderNo!="")
	$sql .= "and GD.intStyleId='$cboOrderNo'";

if($txtOrderNo!="")
	$sql .= "and O.strOrderNo like '%$txtOrderNo%'";
	
if($cboGRN!="")
	$sql .= "and GH.intGrnNo='$cboGRNArray[1]' and GH.intGRNYear='$cboGRNArray[0]' ";

if($txtGRNNo!="")
	$sql .= "and GH.intGrnNo like '%$txtGRNNo%' ";
	
if($cboInvoice!="")
	$sql .= "and GH.strInvoiceNo='$cboInvoice' ";
	
if($txtInvoiceNo!="")
	$sql .= "and GH.strInvoiceNo like '%$txtInvoiceNo%' ";

if($cboSupplier!="")
	$sql .= "and POH.strSupplierID='$cboSupplier' ";
	
if($txtSupplier!="")
	$sql .= "and S.strTitle like '%$txtSupplier%' ";

$sql .= " order by GH.intGRNYear,GH.intGrnNo ";
$result=$db->RunQuery($sql);
while ($details=mysql_fetch_array($result))
{
	xlsWriteLabel($i,0,$details["intYear"].'/'.$details["intPoNo"]); 
	xlsWriteLabel($i,1,$details["intGRNYear"].'/'.$details["intGrnNo"]); 
	xlsWriteLabel($i,2,$details["strInvoiceNo"]); 
	xlsWriteLabel($i,3,$details["dtmRecievedDate"]); 
	xlsWriteLabel($i,4,$details["strStyle"]); 
	xlsWriteLabel($i,5,$details["intSRNO"]); 
	xlsWriteLabel($i,6,$details["strItemDescription"]); 
	xlsWriteLabel($i,7,$details["strColor"]); 
	xlsWriteLabel($i,8,$details["strSize"]); 
	xlsWriteLabel($i,9,$details["strUnit"]); 
	xlsWriteNumber($i,10,$details["dblQty"]);
	xlsWriteNumber($i,11,$details["dblExcessQty"]);
	xlsWriteNumber($i,12,$details["dblUnitPrice"]);
	xlsWriteNumber($i,13,round($details["dblUnitPrice"] * $details["dblQty"],4));
        
        $rcvdQty = GetGrnQty($details["intGrnNo"], $details["intGRNYear"], $details["intStyleId"], $details["intItemSerial"], $details["strColor"],$details["strSize"]);
        $returnToSupQty = GetSupplierReturnQty($details["intGrnNo"], $details["intGRNYear"], $details["intStyleId"], $details["intItemSerial"], $details["strColor"],$details["strSize"]);
        
	/*xlsWriteNumber($i,14,$details["dblPoPrice"]);
	xlsWriteNumber($i,15,$details["dblInvoicePrice"]);
	xlsWriteNumber($i,16,$details["dblPaymentPrice"]);*/
	xlsWriteNumber($i,14,round($rcvdQty,2));
        xlsWriteNumber($i,15,round($returnToSupQty,2));
	$totalQty		+= $details["dblQty"];
	$totalUnitPrice	+= $details["dblUnitPrice"];
	$totalValue		+= $details["dblUnitPrice"] * $details["dblQty"];
	$totalExQty		+= $details["dblExcessQty"];
$i++;
}
xlsWriteNumber($i,10,$totalQty);
xlsWriteNumber($i,11,$totalExQty);
xlsWriteNumber($i,12,round($totalUnitPrice,4));
xlsWriteNumber($i,13,round($totalValue,4));
xlsEOF();


function GetGrnQty($grnNo, $grnYear, $styleId, $matDetailId, $itemColor, $itemSize){
    
    global $db;
    
    $sql = " SELECT Sum(grndetails.dblQty) AS RecviedQty FROM grndetails
             WHERE grndetails.intGrnNo =  '$grnNo' AND grndetails.intGRNYear =  '$grnYear' AND grndetails.intStyleId =  '$styleId' AND 
                   grndetails.intMatDetailID =  '$matDetailId' AND grndetails.strColor =  '$itemColor' AND grndetails.strSize =  '$itemSize'";
    
    $result = $db->RunQuery($sql);
    
    while($row = mysql_fetch_array($result)){
        
        return $RecievedQty = $row["RecviedQty"];
        
    }
}

function GetSupplierReturnQty($grnNo, $grnYear, $styleId, $matItemId, $itemColor, $itemSize){
    
    global $db;
    
    $dblReturnQty = 0;
    
    $sql = " SELECT Sum(returntosupplierdetails.dblQty) AS ReturnSupQty FROM returntosupplierdetails WHERE intGrnNo = '$grnNo' AND intGrnYear = '$grnYear' AND intStyleId = '$styleId' AND intMatdetailID = '$matItemId' AND strColor = '$itemColor' AND strSize = '$itemSize'";
    
    $result = $db->RunQuery($sql);
    
    while($row = mysql_fetch_array($result)){
        
        $dblReturnQty = $row["ReturnSupQty"];
        
    }
    
    return $dblReturnQty;
}
?>