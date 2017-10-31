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
header ("Content-Disposition: attachment; filename=StyleReportMRN.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream

	
			$i=4;
				  xlsWriteLabel(2,5,"MRN REGISTER");
				   
			/*while ($rowdata=mysql_fetch_array($result))
			{*/
				xlsWriteLabel($i,0,"MRN No");
				xlsWriteLabel($i,1,"Date");	
				xlsWriteLabel($i,2,"Material Ratio ID");	
				xlsWriteLabel($i,3,"Department From");
				xlsWriteLabel($i,4,"To");
				xlsWriteLabel($i,5,"Order No");
				xlsWriteLabel($i,6,"SCNo");
				xlsWriteLabel($i,7,"Buyer PoNo");
				xlsWriteLabel($i,8,"Mat");
				xlsWriteLabel($i,9,"Item Description");
				xlsWriteLabel($i,10,"Color");
				xlsWriteLabel($i,11,"Size");
				xlsWriteLabel($i,12,"Qty");
				xlsWriteLabel($i,13,"Issue Qty");
				xlsWriteLabel($i,14,"User");
				
				$i++;
				
				$detailSql="SELECT
mrn.intMatRequisitionNo,
mrn.intMRNYear,
o.strOrderNo,
sp.intSRNO,
mrd.strBuyerPONO,
mil.strItemDescription,
matCat.strDescription,
date(mrn.dtmDate) AS mrnDate,
mrd.strColor,
mrd.strSize,
mrd.dblQty,
(mrd.dblQty-mrd.dblBalQty) AS issueQty,
d.strDepartment,
ms.strName AS storeName,
ua.Name AS mrnUser,
materialratio.materialRatioID
FROM
matrequisition AS mrn
INNER JOIN matrequisitiondetails AS mrd ON mrn.intMatRequisitionNo = mrd.intMatRequisitionNo AND mrn.intMRNYear = mrd.intYear
INNER JOIN orders AS o ON o.intStyleId = mrd.intStyleId
INNER JOIN specification AS sp ON sp.intStyleId = o.intStyleId
INNER JOIN matitemlist AS mil ON mil.intItemSerial = mrd.strMatDetailID
INNER JOIN matmaincategory AS matCat ON matCat.intID = mil.intMainCatID
INNER JOIN department AS d ON mrn.strDepartmentCode = d.intDepID
INNER JOIN mainstores AS ms ON mrn.strMainStoresID = ms.strMainID
INNER JOIN useraccounts AS ua ON mrn.intUserId = ua.intUserID
INNER JOIN materialratio ON materialratio.intStyleId = mrd.intStyleId AND materialratio.strMatDetailID = mrd.strMatDetailID AND mrd.strColor = materialratio.strColor AND mrd.strSize = materialratio.strSize
WHERE mrn.intStatus=$intStatus ";
			
			if ($intCompany!="")
			{
				$detailSql .= " AND mrn.intCompanyID=$intCompany ";
			}

			if ($strStyleNo!= "")
			{ 
				$detailSql .= " AND mrd.intStyleId ='$strStyleNo' ";
			}
			
			if ($strBPo	!= "")
			{
				$sql = $sql." and  mrd.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " AND mil.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$detailSql .= " AND mil.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "")
			{
				$detailSql .= " AND mrd.strMatDetailID=$intDescription ";						
			}
			if ($txtMatItem!= "")
			{				
				$detailSql .= " and mil.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($poNoFrom!="")
			{
				$detailSql .= " AND mrn.intMatRequisitionNo>=$poNoFrom ";
			}
			if ($poNoTo!="")
			{
				$detailSql .= " AND mrn.intMatRequisitionNo<=$poNoTo ";
			}
			if ($intBuyer!="")
			{			
				$detailSql = $detailSql." and o.intBuyerID=$intBuyer";				
			}
			
			if ($dtmDateFrom!="")
			{					
				$detailSql = $detailSql." and DATE_FORMAT(mrn.dtmDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
			}
			
			if ($dtmDateTo!="")
			{					
				$detailSql = $detailSql."  and DATE_FORMAT(mrn.dtmDate,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
				$detailSql .= "order by mrn.intMatRequisitionNo ";	
				
			$detailResult = $db->RunQuery($detailSql);
			
			while ($details=mysql_fetch_array($detailResult))
			{
				xlsWriteLabel($i,0,$details["intMRNYear"].'/'.$details["intMatRequisitionNo"]);
				xlsWriteLabel($i,1,$details["mrnDate"]);
				xlsWriteLabel($i,2,$details["materialRatioID"]);
				xlsWriteLabel($i,3,$details["strDepartment"]);
				xlsWriteLabel($i,4,$details["storeName"]);
				xlsWriteLabel($i,5,$details["strOrderNo"]);
				xlsWriteLabel($i,6,$details["intSRNO"]);
				xlsWriteLabel($i,7,$details["strBuyerPONO"]);
				xlsWriteLabel($i,8,substr($details["strDescription"],0,3));
				xlsWriteLabel($i,9,$details["strItemDescription"]);
				xlsWriteLabel($i,10,$details["strColor"]);
				xlsWriteLabel($i,11,$details["strSize"]);
				xlsWriteNumber($i,12,$details["dblQty"]);
				xlsWriteNumber($i,13,$details["issueQty"]);
				xlsWriteLabel($i,14,$details["mrnUser"]);
				$i++;
			}
xlsEOF();
?>