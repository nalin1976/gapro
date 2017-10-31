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
					xlsWriteLabel($i,5,"Material Ratio ID :"); 		
					xlsWriteLabel($i,6,"Order No");
					xlsWriteLabel($i,7,"ScNo");
					xlsWriteLabel($i,8,"Buyer PoNo");
					xlsWriteLabel($i,9,"Main Category");
					xlsWriteLabel($i,10,"Item Description");
					xlsWriteLabel($i,11,"Color");
					xlsWriteLabel($i,12,"Size");
					xlsWriteLabel($i,13,"Unit");
					xlsWriteLabel($i,14,"Qty");
					xlsWriteLabel($i,15,"RTN");
					xlsWriteLabel($i,16,"GP Trans Qty");
					$i++;
					
					$detailSql="SELECT
GH.intGatePassNo,
GH.intGPYear,
GD.intStyleId,
GD.strBuyerPONO,
GD.intMatDetailId,
GD.strColor,
GD.strSize,
SP.intSRNO,
MIL.strItemDescription,
specificationdetails.strUnit,
GD.dblQty,
GD.intRTN,
(GD.dblQty-GD.dblBalQty) AS transInQty,
o.strOrderNo,
MMC.strID,
GH.intStatus,
if(strCategory='I',(select distinct strName from mainstores MS where MS.strMainID=GH.strTo),
					(select distinct strName from subcontractors  where  strSubContractorID=GH.strTo)) AS destination,
GH.strAttention,
GH.dtmDate,
GH.strTo,
materialratio.materialRatioID
FROM
gatepass AS GH
INNER JOIN gatepassdetails AS GD ON GH.intGatePassNo = GD.intGatePassNo AND GH.intGPYear = GD.intGPYear
INNER JOIN specification AS SP ON GD.intStyleId = SP.intStyleId
INNER JOIN matitemlist AS MIL ON GD.intMatDetailId = MIL.intItemSerial
INNER JOIN matmaincategory AS MMC ON MIL.intMainCatID = MMC.intID
INNER JOIN orders AS o ON o.intStyleId = GD.intStyleId
INNER JOIN specificationdetails ON GD.intStyleId = specificationdetails.intStyleId AND GD.intMatDetailId = specificationdetails.strMatDetailID
INNER JOIN materialratio ON GD.intStyleId = materialratio.intStyleId AND GD.intMatDetailId = materialratio.strMatDetailID AND GD.strColor = materialratio.strColor AND GD.strSize = materialratio.strSize
where  GH.intStatus ='$intStatus'";
					
								
						if ($strStyleNo!= "")
						{ 
							$detailSql .= " and GD.intStyleId ='$strStyleNo' ";
						}
						
						if ($strBPo	!= "")
						{
							$detailSql .= " AND GD.strBuyerPONO='$strBPo' " ;
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
						if ($txtMatItem!= "")
						{				
							$detailSql .= " and MIL.strItemDescription like '%$txtMatItem%' " ;
						}
						if($noFrom!=""){
							$detailSql .= " and GH.intGatePassNo >= '$noFrom'";
						}
						if($noTo!=""){
							$detailSql .= " and GH.intGatePassNo <= '$noTo'";
						}
						
						if ($intBuyer!="")
						{			
							$sql = $sql." and O.intBuyerID=$intBuyer";				
						}
						
						if($dtmDateFrom!="")
						{					
							$detailSql = $detailSql." and DATE_FORMAT(GH.dtmDate ,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
						}
						
						if($dtmDateTo!="")
						{					
						$detailSql = $detailSql." and DATE_FORMAT(GH.dtmDate ,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
						}
						
						$detailSql = $detailSql. " order by GH.intGatePassNo";				
						
						$detailResult = $db->RunQuery($detailSql);
					
						while ($details=mysql_fetch_array($detailResult))
						{
								$strTo = $details["strTo"];
								$xml = simplexml_load_file('../../config.xml');
					$AllowSubContractorToGatePass = $xml->styleInventory->AllowSubContractorToGatePass;
					if($AllowSubContractorToGatePass=="true"){
					$sql="select strSubContractorID,strName from subcontractors  where  strSubContractorID='$strTo'";
					
						$result=$db->RunQuery($sql);
						while($row=mysql_fetch_array($result))
						{
							$detination =  $row["strName"];
					
						}
					}
					else{
					   $detination = $details["destination"];
					}
					
					if($intStatus == '0')
						$tbl = 'stocktransactions_temp';
					else
						$tbl = 'stocktransactions';
						
					$sqlstore="SELECT DISTINCT strMainID,strName FROM $tbl ST
					INNER JOIN mainstores MS ON ST.strMainStoresID=MS.strMainID 
					WHERE intDocumentNo=".$details["intGatePassNo"]." AND intDocumentYear=".$details["intGPYear"]." and strType='SGatePass'";
					$result1=$db->RunQuery($sqlstore);
					while($row1=mysql_fetch_array($result1))
					{
						$Dispatched = $row1["strName"];
					}
					
					xlsWriteLabel($i,0,$details["intGPYear"].'/'.$details["intGatePassNo"]); 
					xlsWriteLabel($i,1,$detination); 
								    xlsWriteNumber($i,2,$details["strAttention"]); 
									xlsWriteLabel($i,3,$Dispatched); 
									xlsWriteLabel($i,4,$details["dtmDate"]); 
									xlsWriteLabel($i,5,$details["materialRatioID"]); 
									xlsWriteLabel($i,6,$details["strOrderNo"]); 
								    xlsWriteNumber($i,7,$details["intSRNO"]); 
									xlsWriteLabel($i,8,$details["strBuyerPONO"]); 
									xlsWriteLabel($i,9,$details["strID"]); 
									xlsWriteLabel($i,10,$details["strItemDescription"]); 
									xlsWriteLabel($i,11,$details["strColor"]); 
									xlsWriteLabel($i,12,$details["strSize"]);
									$sqlstock="select strUnit from $tbl 
			where intDocumentNo='".$details["intGatePassNo"]."'
			and intDocumentYear='".$details["intGPYear"]."'
			and intStyleId='".$details["intStyleId"]."'
			and strBuyerPoNo ='".$details["strBuyerPONO"]."'
			and intMatDetailId ='".$details["intMatDetailID"]."'
			and strColor ='".$details["strColor"]."'
			and strSize ='".$details["strSize"]."'";
			$result_stock = $db->RunQuery($sqlstock);
			$row_sqlstock = mysql_fetch_array($result_stock);
			$unit = $row_sqlstock["strUnit"];
									xlsWriteLabel($i,13,$unit);
									xlsWriteNumber($i,14,$details["dblQty"]);
									xlsWriteNumber($i,15,$details["intRTN"]);
									xlsWriteNumber($i,16,$details["transInQty"]);
									
									$i++;
								}
								
								
								
			//}
			
			xlsEOF();							
?>