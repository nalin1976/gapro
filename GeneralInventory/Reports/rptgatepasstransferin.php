<?php 
session_start();
	include "../../../Connector.php" ;
	$backwardseperator 	= "../../../";	
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
	$report_companyId =$_SESSION["FactoryID"];
	$txtMatItem 		= $_GET["txtMatItem"];
	
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
header ("Content-Disposition: attachment; filename=StyleReportGPtranferIn.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream
	
	
			
			$i=4;
				   xlsWriteLabel(2,5,"GATE PASS TRANSFER IN DETAILS"); 
				   
				xlsWriteLabel($i,0,"GP Trans In Number");
				xlsWriteLabel($i,1,"Gate Pass No ");
				xlsWriteLabel($i,2,"Date "); 
				//xlsWriteLabel($i,2,$rowdata["intTINYear"].'/'.$rowdata["intTransferInNo"]); 
							
				///xlsWriteLabel($i,2,$rowdata["intGPYear"].'/'.$rowdata["intGatePassNo"]); 
						
					xlsWriteLabel($i,3,"Category");
					xlsWriteLabel($i,4,"Item Code");
					xlsWriteLabel($i,5,"Item Description");
					xlsWriteLabel($i,6,"Unit");
					xlsWriteLabel($i,7,"Qty");
					
$detailSql="SELECT distinct 
GH.intTransferInNo as intTransferInNo,
GH.intTransferInYear as intTINYear,
GH.intGatePassNo as intGatePassNo,
GH.intGPYear as intGPYear,
GH.dtmDate, 
GD.intMatDetailId,
MIL.strItemCode,
MIL.strItemDescription,
MIL.strUnit,
GD.dblQty,
MMC.strID
FROM gengatepasstransferinheader GH
INNER JOIN gengatepasstransferindetails GD ON GH.intTransferInNo=GD.intTransferInNo AND GH.intTransferInYear=GD.intTransferInYear
INNER JOIN genmatitemlist MIL ON GD.intMatDetailId=MIL.intItemSerial 
INNER JOIN genmatmaincategory MMC ON MMC.intID=MIL.intMainCatID 
where GH.intStatus=$intStatus";			

			if($intCompany!=""){
				$sql .= " and GH.intCompanyId= '$intCompany'";
			}
			if ($intMeterial!= "")
			{					
				$detailSql .= " AND MIL.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$detailSql .= " AND MIL.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "")
			{
				$detailSql .= " AND MIL.intItemSerial=$intDescription ";						
			}
					
			 // $detailSql;
					$detailResult = $db->RunQuery($detailSql);
				$i++;
					while ($details=mysql_fetch_array($detailResult))
					{
					
					xlsWriteLabel($i,0,$details["intTINYear"].'/'.$details["intTransferInNo"]); 
					xlsWriteLabel($i,1,$details["intGPYear"].'/'.$details["intGatePassNo"]); 
					xlsWriteLabel($i,2,$details["dtmDate"]); 
						xlsWriteLabel($i,3,$details["strID"]);
						xlsWriteLabel($i,4,$details["strItemCode"]);
						xlsWriteLabel($i,5,$details["strItemDescription"]); 
						
			$sqlstock="select strUnit from genstocktransactions 
			where intDocumentNo='".$details["intTransferInNo"]."'
			and intDocumentYear='".$details["intTINYear"]."'
			and intMatDetailId ='".$details["intMatDetailId"]."'";
			$result_stock = $db->RunQuery($sqlstock);
			$row_sqlstock = mysql_fetch_array($result_stock);
			$unit = $row_sqlstock["strUnit"];
						xlsWriteLabel($i,6,$unit);
						xlsWriteNumber($i,7,$details["dblQty"]);
						$i++;			
					}
							
			
			
			xlsEOF();	
?>