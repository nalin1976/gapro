<?php
	session_start();
	include "../../Connector.php" ;

	$backwardseperator  = "../../";
	$strStyleNo			= $_GET["strStyleNo"];
	$strBPo				= $_GET["strBPo"];
	$intMeterial 		= $_GET["intMeterial"];
	$intCategory 		= $_GET["intCategory"];
	$intDescription 	= $_GET["intDescription"];
	$intSupplier 		= $_GET["intSupplier"];
	$intBuyer 	  		= $_GET["intBuyer"];
	$dtmDateFrom		= $_GET["dtmDateFrom"];
	$dtmDateTo 	  		= $_GET["dtmDateTo"];
	$intCompany    		= $_GET["intCompany"];
	$poNoFrom			= $_GET["noFrom"];
	$poNoTo				= $_GET["noTo"];
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
header ("Content-Disposition: attachment; filename=StyleReportReturntoSupplier.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream

				$i=4;
				   xlsWriteLabel(2,5,"RETURN TO SUPPLIER");
				   
			
				xlsWriteLabel($i,0,"RETURN No");
				//xlsWriteLabel($i,1,$rowdata["intReturnToSupYear"].'/'.$rowdata["intReturnToSupNo"]);  
								
				xlsWriteLabel($i,1,"Return Date ");
				xlsWriteLabel($i,2,"Material Ratio ID ");
				xlsWriteLabel($i,3,"Supplier Name");
				xlsWriteLabel($i,4,"GRN No");
				xlsWriteLabel($i,5,"Order No");
				xlsWriteLabel($i,6,"Buyer PoNo");
				xlsWriteLabel($i,7,"Mat");
				xlsWriteLabel($i,8,"Item Description");
				xlsWriteLabel($i,9,"Color");
				xlsWriteLabel($i,10,"Size");
				xlsWriteLabel($i,11,"Qty");
			
				$i++;
				
				$sql_details="SELECT
RSH.intReturnToSupNo,
RSH.intReturnToSupYear,
RSD.intGrnNo,
RSD.intGrnYear,
RSD.intStyleId,
RSD.strBuyerPoNo,
MIL.strItemDescription,
RSD.strColor,
RSD.strSize,
RSD.dblQty,
MMC.strID,
o.strStyle,
o.strOrderNo,
RSH.dtmRetDate,
(select strTitle from suppliers S where S.strSupplierID=RSH.intRetSupplierID) AS supplierName,
materialratio.materialRatioID
FROM
returntosupplierheader AS RSH
INNER JOIN returntosupplierdetails AS RSD ON RSH.intReturnToSupNo = RSD.intReturnToSupNo AND RSH.intReturnToSupYear = RSD.intReturnToSupYear
INNER JOIN matitemlist AS MIL ON MIL.intItemSerial = RSD.intMatdetailID
INNER JOIN matmaincategory AS MMC ON MIL.intMainCatID = MMC.intID
INNER JOIN orders AS o ON o.intStyleId = RSD.intStyleId
INNER JOIN materialratio ON RSD.intStyleId = materialratio.intStyleId AND RSD.intMatdetailID = materialratio.strMatDetailID AND RSD.strColor = materialratio.strColor AND RSD.strSize = materialratio.strSize
where RSH.intStatus='$intStatus'

 ";		
			
			if ($poNoFrom != "")
			{ 
				$sql_details .= " and RSH.intReturnToSupNo >='$poNoFrom' ";
			}
			if ($poNoTo!= "")
			{ 
				$sql_details .= " and RSH.intReturnToSupNo <='$poNoTo' ";
			}
			if ($strStyleNo!= "")
			{ 
				$sql_details = $sql_details." AND RSD.intStyleId ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql_details = $sql_details." and RSD.strBuyerPoNo='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$sql_details = $sql_details." AND MIL.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$sql_details = $sql_details." AND MIL.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "")
			{
				$sql_details = $sql_details." AND RSD.intMatDetailID=$intDescription ";						
			}
			if ($txtMatItem!= "")
			{				
				$sql_details .= " and MIL.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intCompany!="")
			{
				$sql_details = $sql_details."  AND RSH.intCompanyID=$intCompany ";
			}
			
			if (($dtmDateFrom!=""))
			{					
				$sql_details = $sql_details." and DATE_FORMAT(RSH.dtmRetDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
			}
			
			if (($dtmDateTo!=""))
			{					
				$sql_details = $sql_details."  AND DATE_FORMAT(RSH.dtmRetDate,'%Y/%m/%d') < DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
			$sql_details .= " order by  RSH.intReturnToSupNo";	
			$result_details = $db->RunQuery($sql_details);
			
			
			
			
			while ($row_details=mysql_fetch_array($result_details))
			{
				xlsWriteLabel($i,0,$row_details["intReturnToSupYear"].'/'.$row_details["intReturnToSupNo"]);
				xlsWriteLabel($i,1,$row_details["dtmRetDate"]);
				xlsWriteLabel($i,2,$row_details["materialRatioID"]);
				xlsWriteLabel($i,3,$row_details["supplierName"]); 
				xlsWriteLabel($i,4,$row_details["intGrnYear"].'/'.$row_details["intGrnNo"]);
				xlsWriteLabel($i,5,$row_details["strOrderNo"]);
				xlsWriteLabel($i,6,$row_details["strBuyerPoNo"]);
				xlsWriteLabel($i,7,$row_details["strID"]);
				xlsWriteLabel($i,8,$row_details["strItemDescription"]);
				xlsWriteLabel($i,9,$row_details["strColor"]);
				xlsWriteLabel($i,10,$row_details["strSize"]);
				xlsWriteNumber($i,11,$row_details["dblQty"]);
				$i++;	
			}
				
		//}					
			
			xlsEOF();
?>