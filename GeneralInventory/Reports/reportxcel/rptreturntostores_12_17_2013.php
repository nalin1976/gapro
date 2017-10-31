<?php
	session_start();
	include "../../../Connector.php" ;

	$backwardseperator  = "../../../";
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
	$txtMatItem 		= $_GET["txtMatItem"];
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
header ("Content-Disposition: attachment; filename=StyleReportISSUE.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream

	
			$i=4;
				  xlsWriteLabel(2,5,"RETURN TO STORES");
				   
			/*while ($rowdata=mysql_fetch_array($result))
			{*/
				xlsWriteLabel($i,0,"RETURN No");
				///xlsWriteLabel($i,1,$rowdata["intReturnYear"].'/'.$rowdata["intReturnNo"]);  
				xlsWriteLabel($i,1,"Return Date ");
				xlsWriteLabel($i,2,"Return By");	
				xlsWriteLabel($i,3,"Issue No");
				xlsWriteLabel($i,4,"Category");
				xlsWriteLabel($i,5,"Item Code");
				xlsWriteLabel($i,6,"Item Description");
				xlsWriteLabel($i,7,"Qty");
				
				$i++;
				
				$detailSql="SELECT DISTINCT
RSD.strReturnID,
RSD.intRetYear,
RSD.strIssueNo,
RSD.intIssYear,
dtmRetDate, 
MIL.strItemCode, 
MIL.strItemDescription, 
RSD.dblQtyReturned,
MMC.intID,
(select strDepartment from department D where D.strDepartmentCode=RSH.strReturnedBy)as departmentName, 
MMC.strDescription
from genreturnheader RSH
inner join genreturndetail RSD on RSH.strReturnID=RSD.strReturnID and RSH.intRetYear=RSD.intRetYear
inner join genmatitemlist MIL on  MIL.intItemSerial=RSD.intMatdetailID
inner join genmatmaincategory MMC on MIL.intMainCatID=MMC.intID
where RSH.intStatus=$intStatus ";		
		

/*			if ($strStyleNo!= "")
			{ 
				$sql_details = $sql_details." AND RSD.strStyleID ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql_details = $sql_details." and RSD.strBuyerPoNo='$strBPo' " ;
			}
*/			
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
			
			if ($intCompany!="")
			{
				$sql_details = $sql_details."  AND RSH.intCompanyId=$intCompany ";
			}
			
			if (($dtmDateFrom!=""))
			{					
				$sql_details = $sql_details." and DATE_FORMAT(RSH.dtmRetDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
			}
			
			if (($dtmDateTo!=""))
			{					
				$sql_details = $sql_details."  AND DATE_FORMAT(RSH.dtmRetDate,'%Y/%m/%d') < DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
					
	
			$detailResult = $db->RunQuery($detailSql);
			
			
			$i = 5;
			while ($details=mysql_fetch_array($detailResult))
			{
				xlsWriteLabel($i,0,$row_details["intReturnYear"].'/'.$row_details["intReturnNo"]);
				xlsWriteLabel($i,1,$row_details["dtmRetDate"]);
				xlsWriteLabel($i,2,$row_details["departmentName"]);
				xlsWriteLabel($i,3,$row_details["intIssueYear"].'/'.$row_details["intIssueNo"]);
				xlsWriteLabel($i,4,$row_details["strID"]);
				//materialRatioID
				xlsWriteLabel($i,5,$row_details["materialRatioID"]);
				xlsWriteLabel($i,6,$row_details["strItemDescription"]);
				xlsWriteNumber($i,7,$row_details["dblReturnQty"]);
				$i++;
			}
							
		//}
			
			
			xlsEOF();
?>