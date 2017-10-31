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
header ("Content-Disposition: attachment; filename=StyleReportGRN.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream
	

	$i=4;
		 xlsWriteLabel(2,5,"GENERAL GRN REGISTER");
		 
				xlsWriteLabel($i,0,"GRN No");
				xlsWriteLabel($i,1,"PO No");
				xlsWriteLabel($i,2,"Supplier");
				xlsWriteLabel($i,3,"Invoice No");
				xlsWriteLabel($i,4,"PI No");
				xlsWriteLabel($i,5,"Date");
				xlsWriteLabel($i,6,"Mat");
				xlsWriteLabel($i,7,"Item Code");
				xlsWriteLabel($i,8,"Item Description");
				xlsWriteLabel($i,9,"Unit");
				xlsWriteLabel($i,10,"Qty");
				xlsWriteLabel($i,11,"Rate");
				xlsWriteLabel($i,12,"Amount");
				xlsWriteLabel($i,13,"Ret To Supp.");
				
				$i++;
				
				$detailSql="SELECT  GH.strGenGrnNo,
GH.intYear,  

gengrndetails.intMatDetailID, 
GH.dtRecdDate,
genmatitemlist.intMainCatID,
genmatitemlist.intSubCatID,
GH.intStatus, 
genmatmaincategory.strDescription, 
genmatitemlist.strItemCode,
genmatitemlist.strItemDescription,
gengrndetails.dblQty AS dblQty, 
((gengrndetails.dblQty) -  gengrndetails.dblBalance) AS retToSup,
POD.dblUnitPrice,
POD.strUnit,
suppliers.strTitle, 
GH.intGenPONo,
GH.intGenPOYear,
GH.strInvoiceNo, 
POH.strPINO
FROM gengrnheader GH
INNER JOIN gengrndetails ON GH.strGenGrnNo=gengrndetails.strGenGrnNo AND GH.intYear=gengrndetails.intYear 
inner join generalpurchaseorderheader POH on GH.intGenPONo =POH.intGenPONo AND GH.intGenPOYear=POH.intYear
inner join genmatitemlist on gengrndetails.intMatDetailID=genmatitemlist.intItemSerial 
INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatID=genmatmaincategory.intID
inner join suppliers on POH.intSupplierID=suppliers.strSupplierID 
 inner join generalpurchaseorderdetails POD on POH.intGenPoNo= POD.intGenPoNo and POH.intYear= POD.intYear and POD.intMatDetailID=gengrndetails.intMatDetailID  
WHERE GH.intStatus='$intStatus' ";

			if($noFrom!=""){
				$detailSql .= " and GH.strGenGrnNo >= '$noFrom'";
			}
			if($noTo!=""){
				$detailSql .= " and GH.strGenGrnNo <= '$noTo'";
			}	
			/*if ($intCompany!="")
			{
				$detailSql .= " AND GH.intCompId=$intCompany  ";
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
				$detailSql .= " AND POD.intMatDetailID=$intDescription ";						
			}
			if ($txtMatItem!= "")
			{				
				$detailSql .= " and genmatitemlist.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intSupplier!="")
			{			
				$detailSql = $detailSql." and POH.intSupplierID=$intSupplier ";
			}
			if($dtmDateFrom!="")
			{					
				$detailSql = $detailSql." and DATE_FORMAT(GH.dtRecdDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
			}
			if($dtmDateTo!="")
			{					
			$detailSql = $detailSql." and DATE_FORMAT(GH.dtRecdDate,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
			
				$detailSql .= "order by GH.strGenGrnNo ";	
			$detailResult = $db->RunQuery($detailSql);
			
			
			while ($details=mysql_fetch_array($detailResult))
			{
				xlsWriteLabel($i,0,$details["intYear"].'/'.$details["strGenGrnNo"]); 
				xlsWriteLabel($i,1,$details["intGenPOYear"].'/'.$details["intGenPONo"]); 
				xlsWriteLabel($i,2,$details["strTitle"]);
				xlsWriteLabel($i,3,$details["strInvoiceNo"]);
				xlsWriteLabel($i,4,$details["strPINO"]);
				xlsWriteLabel($i,5,$details["dtRecdDate"]);
				xlsWriteLabel($i,6,substr($details["strDescription"],0,3));
				//materialRatioID
				xlsWriteLabel($i,7,$details["strItemCode"]);
				xlsWriteLabel($i,8,$details["strItemDescription"]);
				xlsWriteLabel($i,9,$details["strUnit"]);
				xlsWriteNumber($i,10,$details["dblQty"]);
				xlsWriteLabel($i,11,$details["dblUnitPrice"]);
				xlsWriteNumber($i,12,$details["dblQty"]*$details["dblUnitPrice"]);
				xlsWriteNumber($i,13,$details["retToSup"]);
				$i++;	
			}
			
		//}				
			xlsEOF();
?>
