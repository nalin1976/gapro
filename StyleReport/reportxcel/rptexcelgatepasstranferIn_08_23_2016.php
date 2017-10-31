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
				
				xlsWriteLabel($i,3,"Material Ratio ID "); 		
				xlsWriteLabel($i,4,"Order No");
					xlsWriteLabel($i,5,"ScNo");
					xlsWriteLabel($i,6,"Buyer PoNo");
					xlsWriteLabel($i,7,"Mat");
					xlsWriteLabel($i,8,"Item Description");
					xlsWriteLabel($i,9,"Color");
					xlsWriteLabel($i,10,"Size");
					xlsWriteLabel($i,11,"Unit");
					xlsWriteLabel($i,12,"Qty");
					
					$detailSql="SELECT
GH.intTransferInNo,
GH.intTINYear,
GH.intGatePassNo,
GH.intGPYear,
GH.dtmDate,
GD.intStyleId,
GD.strBuyerPONO,
GD.intMatDetailId,
GD.strColor,
GD.strSize,
MIL.strItemDescription,
MIL.strUnit,
GD.dblQty,
SP.intSRNO,
MMC.strID,
o.strStyle,
o.strOrderNo,
materialratio.materialRatioID
FROM
gategasstransferinheader AS GH
INNER JOIN gategasstransferindetails AS GD ON GH.intTransferInNo = GD.intTransferInNo AND GH.intTINYear = GD.intTINYear
INNER JOIN specification AS SP ON SP.intStyleId = GD.intStyleId
INNER JOIN matitemlist AS MIL ON GD.intMatDetailId = MIL.intItemSerial
INNER JOIN matmaincategory AS MMC ON MMC.intID = MIL.intMainCatID
INNER JOIN orders AS o ON o.intStyleId = SP.intStyleId 
INNER JOIN materialratio ON GD.intStyleId = materialratio.intStyleId AND GD.intMatDetailId = materialratio.strMatDetailID AND GD.strColor = materialratio.strColor AND GD.strSize = materialratio.strSize";
					
					if($noFrom!=""){
						$detailSql .= " and GH.intTransferInNo >= '$noFrom'";
					}
					if($noTo!=""){
						$detailSql .= " and GH.intTransferInNo <= '$noTo'";
					}		
					if ($strStyleNo!= "")
					{ 
						$detailSql .= " and GD.intStyleId  ='$strStyleNo' ";
					}
					
					if ($strBPo	!= "")
					{
						$detailSql .= " and GD.strBuyerPONO='$strBPo' " ;
					}		
					
					if ($intMeterial!= "")
					{					
						$detailSql .= " AND MIL.intMainCatID=$intMeterial ";
					}
					if ($txtMatItem!= "")
					{				
						$detailSql .= " and MIL.strItemDescription like '%$txtMatItem%' " ;
					}
					if ($intCategory!= "")
					{
						$detailSql .= " AND MIL.intSubCatID=$intCategory " ;
					}
		
					if ($intDescription!= "")
					{
						$detailSql .= " AND MIL.intItemSerial=$intDescription ";						
					}
					if ($intBuyer!="")
					{			
						$detailSql = $detailSql." and O.intBuyerID=$intBuyer";				
					}
					if($dtmDateFrom!="")
					{					
						$detailSql = $detailSql." and DATE_FORMAT(GH.dtmDate ,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
					}
					
					if($dtmDateTo!="")
					{					
					$detailSql = $detailSql." and DATE_FORMAT(GH.dtmDate ,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
					}
			
	$detailSql = $detailSql . " GROUP BY GD.intMatDetailId,GD.strColor, GD.strSize, MIL.strItemDescription, MIL.strUnit,GD.intGrnNo,GH.intTransferInNo order by GH.intTransferInNo";	
					$detailResult = $db->RunQuery($detailSql);
				$i++;


					while ($details=mysql_fetch_array($detailResult))
					{
					
					xlsWriteLabel($i,0,$details["intTINYear"].'/'.$details["intTransferInNo"]); 
					xlsWriteLabel($i,1,$details["intGPYear"].'/'.$details["intGatePassNo"]); 
					xlsWriteLabel($i,2,$details["dtmDate"]); 
					xlsWriteLabel($i,3,$details["materialRatioID"]); 
						xlsWriteLabel($i,4,$details["strOrderNo"]); 
						xlsWriteNumber($i,5,$details["intSRNO"]); 
						xlsWriteLabel($i,6,$details["strBuyerPoNo"]); 
						xlsWriteLabel($i,7,$details["strID"]); 
						xlsWriteLabel($i,8,$details["strItemDescription"]); 
						xlsWriteLabel($i,9,$details["strColor"]); 
						xlsWriteLabel($i,10,$details["strSize"]);
						$sqlstock="select strUnit from stocktransactions 
			where intDocumentNo='".$details["intTransferInNo"]."'
			and intDocumentYear='".$details["intTINYear"]."'
			and intStyleId='".$details["intStyleId"]."'
			and strBuyerPoNo ='".$details["strBuyerPONO"]."'
			and intMatDetailId ='".$details["intMatDetailId"]."'
			and strColor ='".$details["strColor"]."'
			and strSize ='".$details["strSize"]."'";
			$result_stock = $db->RunQuery($sqlstock);
			$row_sqlstock = mysql_fetch_array($result_stock);
			$unit = $row_sqlstock["strUnit"];
						xlsWriteLabel($i,11,$unit);
						xlsWriteNumber($i,12,$details["dblQty"]);
						$i++;			
					}
							
			
			
			xlsEOF();	
?>