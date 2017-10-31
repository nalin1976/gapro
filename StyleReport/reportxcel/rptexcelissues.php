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
				xlsWriteLabel($i,3,"Item Code");
				xlsWriteLabel($i,4,"Department");
				xlsWriteLabel($i,5,"Order No");
				xlsWriteLabel($i,6,"SCNo");
				xlsWriteLabel($i,7,"Buyer PoNo");
				xlsWriteLabel($i,8,"Mat");
				xlsWriteLabel($i,9,"Item Description");
				xlsWriteLabel($i,10,"Color");
				xlsWriteLabel($i,11,"Size");
				xlsWriteLabel($i,12,"Qty");
				xlsWriteLabel($i,13,"Return To Stores");
				
				$i++;
				
				# =======================================================================
				// Comment For - Add Material ratio ID to the list
				// Comment On - 05/06/2016
				// Comment By - Nalin Jayakody
				# =======================================================================
				/* $detailSql="SELECT  issues.intIssueNo,
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
WHERE issues.intStatus=$intStatus "; */

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
concat(issuesdetails.intMatReqYear,'/',issuesdetails.intMatRequisitionNo)as mrnNo,
materialratio.materialRatioID
FROM issues
Inner Join issuesdetails ON issues.intIssueNo = issuesdetails.intIssueNo AND issues.intIssueYear = issuesdetails.intIssueYear
Inner Join matitemlist ON issuesdetails.intMatDetailID = matitemlist.intItemSerial
Inner Join department ON issues.strProdLineNo = department.intDepID
Inner Join orders ON issuesdetails.intStyleId = orders.intStyleId
Inner Join matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
Inner Join matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo AND matitemlist.intMainCatID = matsubcategory.intCatNo
Inner Join specification AS SP ON SP.intStyleId = issuesdetails.intStyleId
Inner Join materialratio ON issuesdetails.intStyleId = materialratio.intStyleId AND issuesdetails.intMatDetailID = materialratio.strMatDetailID AND issuesdetails.strColor = materialratio.strColor AND issuesdetails.strSize = materialratio.strSize AND issuesdetails.strBuyerPONO = materialratio.strBuyerPONO
WHERE issues.intStatus=$intStatus ";

			# =======================================================================
			
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
				xlsWriteLabel($i,3,$details["materialRatioID"]);
				xlsWriteLabel($i,4,$details["strDepartment"]);
				xlsWriteLabel($i,5,$details["strOrderNo"]);
				xlsWriteLabel($i,6,$details["intSRNO"]);
				xlsWriteLabel($i,7,$details["strBuyerPoNo"]);
				xlsWriteLabel($i,8,substr($details["strDescription"],0,3));
				xlsWriteLabel($i,9,$details["strItemDescription"]);
				xlsWriteLabel($i,10,$details["strColor"]);
				xlsWriteLabel($i,11,$details["strSize"]);
				xlsWriteNumber($i,12,$details["dblQty"]);
				xlsWriteNumber($i,13,$details["retToStoress"]);
				$i++;
			}
xlsEOF();
?>