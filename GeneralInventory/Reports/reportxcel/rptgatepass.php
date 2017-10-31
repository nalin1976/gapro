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
header ("Content-Disposition: attachment; filename=StyleReportGatepass.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream

			
			$i=4;
				   xlsWriteLabel(2,5,"GATE PASS DETAILS"); 
				   
				  // xlsWriteLabel(4,0,"Gate Pass Number"); 
			
				
					//
					 xlsWriteLabel($i,0,"Gate Pass Number"); 
					xlsWriteLabel($i,1,"Destination :"); 
					xlsWriteLabel($i,2,"ATTENTION BY :"); 		
					xlsWriteLabel($i,3,"Dispatched :"); 
					xlsWriteLabel($i,4,"Date & Time :"); 			
					xlsWriteLabel($i,5,"Main Category");
					xlsWriteLabel($i,6,"Main Category");
					xlsWriteLabel($i,7,"Item Description");
					xlsWriteLabel($i,8,"Unit");
					xlsWriteLabel($i,9,"Qty");
					xlsWriteLabel($i,10,"GP Trans Qty");
					$i++;
					
$detailSql="SELECT distinct GH.strGatepassID as intGatePassNo,
GH.intYear AS intGPYear,  
GD.intMatDetailID,
MIL.strItemCode,
MIL.strItemDescription,
MIL.strUnit,
GD.dblQty,
(GD.dblQty-GD.dblBalQty)AS transInQty,
GH.strGatepassID as intGatePassNo,
GH.intYear as intGPYear,
GH.dtmDate,
GH.strAttention,
(select  strName from companies MS where MS.intCompanyID=GH.intToStores)AS destination, 
(select  strName from companies MS where MS.intCompanyID=GH.intCompanyId)AS Dispatched
FROM gengatepassheader GH
INNER JOIN gengatepassdetail GD ON GH.strGatepassID=GD.strGatepassID AND GH.intYear=GD.intYear
INNER JOIN genmatitemlist MIL ON GD.intMatDetailID=MIL.intItemSerial 
where GH.intStatus=$intStatus";			

			if($noFrom!=""){
				$detailSql .= " and GH.strGatepassID >= '$noFrom'";
			}
			if($noTo!=""){
				$detailSql .= " and GH.strGatepassID <= '$noTo'";
			}			
			/*if ($intCompany!="")
			{
				$detailSql = $detailSql." and GH.intCompanyId=$intCompany ";
			}*/
						
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
						
						$detailResult = $db->RunQuery($detailSql);
					
						while ($details=mysql_fetch_array($detailResult))
						{
					
									xlsWriteLabel($i,0,$details["intGPYear"].'/'.$details["intGatePassNo"]); 
									xlsWriteLabel($i,1,$details["destination"]); 
								    xlsWriteNumber($i,2,$details["strAttention"]); 
									xlsWriteLabel($i,3,$details["Dispatched"]); 
									xlsWriteLabel($i,4,$details["dtmDate"]); 
									xlsWriteLabel($i,5,$details["strItemCode"]); 
									xlsWriteLabel($i,6,$details["strID"]); 
									xlsWriteLabel($i,7,$details["strItemDescription"]); 
									$sqlstock="select strUnit from $tbl 
			where intDocumentNo='".$details["intGatePassNo"]."'
			and intDocumentYear='".$details["intGPYear"]."'
			and strStyleID='".$details["strStyleID"]."'
			and strBuyerPoNo ='".$details["strBuyerPONO"]."'
			and intMatDetailId ='".$details["intMatDetailID"]."'
			and strColor ='".$details["strColor"]."'
			and strSize ='".$details["strSize"]."'";
			$result_stock = $db->RunQuery($sqlstock);
			$row_sqlstock = mysql_fetch_array($result_stock);
			$unit = $row_sqlstock["strUnit"];
									xlsWriteNumber($i,8,$details["strUnit"]);
									xlsWriteNumber($i,9,$details["dblQty"]);
									xlsWriteNumber($i,10,$details["transInQty"]);
									
									$i++;
								}
								
								
								
			//}
			
			xlsEOF();							
?>