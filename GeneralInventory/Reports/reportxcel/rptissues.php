<?php
	session_start();
	include "../../../Connector.php" ;

	$backwardseperator  = "../../../";
	$intMeterial 		= $_GET["intMeterial"];
	$intCategory 		= $_GET["intCategory"];
	$intDescription 	= $_GET["intDescription"];
	$intSupplier 		= $_GET["intSupplier"];
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
				  xlsWriteLabel(2,5,"ISSUE REGISTERrrr");
				   
			/*while ($rowdata=mysql_fetch_array($result))
			{*/
				xlsWriteLabel($i,0,"ISSUE No");			
				xlsWriteLabel($i,1,"Date");
				xlsWriteLabel($i,2,"Department");
				xlsWriteLabel($i,3,"Mat");
				xlsWriteLabel($i,4,"Item Code");
				xlsWriteLabel($i,5,"Item Description");
				xlsWriteLabel($i,6,"Qty");
				xlsWriteLabel($i,7,"Ret To Supp.");
				
				$i++;
				
				/*$detailSql="SELECT  genissues.intIssueNo,
genissues.intIssueYear, 
genissues.dtmIssuedDate, 
genmatitemlist.strItemDescription,
genmatitemlist.intItemSerial,
genmatitemlist.strItemCode,
genmatmaincategory.strDescription,
genissuesdetails.dblQty,
(genissuesdetails.dblQty-genissuesdetails.dblBalanceQty)AS retToStoress,
department.strDepartment
FROM genissues 
INNER JOIN genissuesdetails ON genissues.intissueno= genissuesdetails.intissueno and genissues.intIssueYear= genissuesdetails.intIssueYear 
INNER JOIN genmatitemlist ON genissuesdetails.intMatDetailID=genmatitemlist.intItemSerial 
INNER JOIN department on genissues.strProdLineNo=department.strDepartmentCode 
INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatId=genmatmaincategory.intID 
INNER JOIN genmatsubcategory ON genmatitemlist.intSubCatId=genmatsubcategory.intSubCatNo and genmatitemlist.intMainCatId=genmatsubcategory.intCatNo
WHERE genissues.intStatus=$intStatus ";*/

$detailSql="SELECT  genissues.intIssueNo,
genissues.intIssueYear, 
genissues.dtmIssuedDate, 
genmatitemlist.strItemDescription,
genmatitemlist.intItemSerial,
genmatitemlist.strItemCode,
genmatmaincategory.strDescription,
genissuesdetails.dblQty,
(genissuesdetails.dblQty-genissuesdetails.dblBalanceQty)AS retToStoress,
department.strDepartment
FROM genissues 
INNER JOIN genissuesdetails ON genissues.intissueno= genissuesdetails.intissueno and genissues.intIssueYear= genissuesdetails.intIssueYear 
INNER JOIN genmatitemlist ON genissuesdetails.intMatDetailID=genmatitemlist.intItemSerial 
INNER JOIN department on genissues.strProdLineNo=department.intDepID 
INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatId=genmatmaincategory.intID 
INNER JOIN genmatsubcategory ON genmatitemlist.intSubCatId=genmatsubcategory.intSubCatNo and genmatitemlist.intMainCatId=genmatsubcategory.intCatNo
WHERE genissues.intStatus=$intStatus ";


			
			/*if ($intCompany!="")
			{
				$detailSql .= " AND genissues.intCompanyID=$intCompany ";
			}*/
			if ($intMeterial!= "")
			{					
				$detailSql .= " AND genmatitemlist.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$detailSql .= " AND genmatitemlist.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "")
			{
				$detailSql .= " AND genissuesdetails.intMatDetailID=$intDescription ";						
			}
			if ($txtMatItem!= "")
			{				
				$detailSql .= " and genmatitemlist.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($poNoFrom!="")
			{
				$detailSql .= " AND genissues.intIssueNo>=$poNoFrom ";
			}
			if ($poNoTo!="")
			{
				$detailSql .= " AND genissues.intIssueNo<=$poNoTo ";
			}
			if ($dtmDateFrom!="")
			{					
				$detailSql = $detailSql." and DATE_FORMAT(genissues.dtmIssuedDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
			}
			
			if ($dtmDateTo!="")
			{					
				$detailSql = $detailSql."  and DATE_FORMAT(genissues.dtmIssuedDate,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
				$detailSql .= "order by genissues.intIssueNo ";	
			$detailResult = $db->RunQuery($detailSql);
			
			
			$i = 5;
			while ($details=mysql_fetch_array($detailResult))
			{
				xlsWriteLabel($i,0,$details["intIssueYear"].'/'.$details["intIssueNo"]);
				xlsWriteLabel($i,1,$details["dtmIssuedDate"]);
				xlsWriteLabel($i,2,$details["strDepartment"]);
				//intItemSerial
				xlsWriteLabel($i,3,substr($details["strDescription"],0,3));
				xlsWriteLabel($i,4,$details["strItemCode"]);
				xlsWriteLabel($i,5,$details["strItemDescription"]);
				xlsWriteNumber($i,6,$details["dblQty"]);
				xlsWriteNumber($i,7,$details["retToStoress"]);
				$i++;
			}
							
		//}
			
			
			xlsEOF();
?>