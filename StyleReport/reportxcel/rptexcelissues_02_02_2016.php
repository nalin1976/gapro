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
header ("Content-Disposition: attachment; filename=StyleReportISSUE.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream

	
			$i=4;
				  xlsWriteLabel(2,5,"ISSUE REGISTER");
				   
			/*while ($rowdata=mysql_fetch_array($result))
			{*/
				xlsWriteLabel($i,0,"ISSUE No");
				xlsWriteLabel($i,1,"MRN No");	
				xlsWriteLabel($i,2,"Date");
				xlsWriteLabel($i,3,"Department");
				xlsWriteLabel($i,4,"Order No");
				xlsWriteLabel($i,5,"SCNo");
				xlsWriteLabel($i,6,"Buyer PoNo");
				xlsWriteLabel($i,7,"Mat");
				xlsWriteLabel($i,8,"Item Description");
				xlsWriteLabel($i,9,"Color");
				xlsWriteLabel($i,10,"Size");
				xlsWriteLabel($i,11,"Qty");
				xlsWriteLabel($i,12,"Return To Stores");
				
				$i++;
				
				$detailSql="SELECT  issues.intIssueNo,
issues.intIssueYear, 
issues.dtmIssuedDate, 
issuesdetails.intStyleId,
issuesdetails.strBuyerPoNo,
matitemlist.strItemDescription,
matmaincategory.strDescription,
issuesdetails.strColor,
issuesdetails.strSize,
issuesdetails.dblQty,
SP.intSRNO, orders.strOrderNo,
(issuesdetails.dblQty-issuesdetails.dblBalanceQty)AS retToStoress,
department.strDepartment,
concat(issuesdetails.intMatReqYear,'/',issuesdetails.intMatRequisitionNo)as mrnNo
FROM issues 
INNER JOIN issuesdetails ON issues.intissueno= issuesdetails.intissueno and issues.intIssueYear= issuesdetails.intIssueYear 
INNER JOIN matitemlist ON issuesdetails.intMatDetailID=matitemlist.intItemSerial 
INNER JOIN department on issues.strProdLineNo=department.intDepID 
INNER JOIN orders ON issuesdetails.intStyleId=orders.intStyleId 
INNER JOIN matmaincategory ON matitemlist.intMainCatId=matmaincategory.intID 
INNER JOIN matsubcategory ON matitemlist.intSubCatId=matsubcategory.intSubCatNo and matitemlist.intMainCatId=matsubcategory.intCatNo
INNER JOIN specification SP ON SP.intStyleId=issuesdetails.intStyleId
WHERE issues.intStatus=$intStatus ";
			
			if ($intCompany!="")
			{
				$detailSql .= " AND issues.intCompanyID=$intCompany ";
			}

			if ($strStyleNo!= "")
			{ 
				$detailSql .= " AND issuesdetails.intStyleId ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql = $sql." and issuesdetails.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " AND matitemlist.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$detailSql .= " AND matitemlist.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "")
			{
				$detailSql .= " AND issuesdetails.intMatDetailID=$intDescription ";						
			}
			if ($txtMatItem!= "")
			{				
				$detailSql .= " and matitemlist.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($poNoFrom!="")
			{
				$detailSql .= " AND issues.intIssueNo>=$poNoFrom ";
			}
			if ($poNoTo!="")
			{
				$detailSql .= " AND issues.intIssueNo<=$poNoTo ";
			}
			if ($intBuyer!="")
			{			
				$detailSql = $detailSql." and orders.intBuyerID=$intBuyer";				
			}
			
			if ($dtmDateFrom!="")
			{					
				$detailSql = $detailSql." and DATE_FORMAT(issues.dtmIssuedDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
			}
			
			if ($dtmDateTo!="")
			{					
				$detailSql = $detailSql."  and DATE_FORMAT(issues.dtmIssuedDate,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
				$detailSql .= "order by issues.intIssueNo ";	
			$detailResult = $db->RunQuery($detailSql);
			
			while ($details=mysql_fetch_array($detailResult))
			{
				xlsWriteLabel($i,0,$details["intIssueYear"].'/'.$details["intIssueNo"]);
				xlsWriteLabel($i,1,$details["mrnNo"]);
				xlsWriteLabel($i,2,$details["dtmIssuedDate"]);
				xlsWriteLabel($i,3,$details["strDepartment"]);
				xlsWriteLabel($i,4,$details["strOrderNo"]);
				xlsWriteLabel($i,5,$details["intSRNO"]);
				xlsWriteLabel($i,6,$details["strBuyerPoNo"]);
				xlsWriteLabel($i,7,substr($details["strDescription"],0,3));
				xlsWriteLabel($i,8,$details["strItemDescription"]);
				xlsWriteLabel($i,9,$details["strColor"]);
				xlsWriteLabel($i,10,$details["strSize"]);
				xlsWriteNumber($i,11,$details["dblQty"]);
				xlsWriteNumber($i,12,$details["retToStoress"]);
				$i++;
			}
xlsEOF();
?>