<?php
// ----- begin of function library -----
// Excel begin of file header
session_start();		
//global $i;
$i=5;
include "../../Connector.php" ;	
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
	$intStatus			= $_GET["status"];

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
header ("Content-Disposition: attachment; filename=BulkGrnRegistor.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream

$sql = "SELECT distinct BGH.intYear, BGH.intBulkGrnNo, BGH.intBulkPoNo, BGH.intBulkPoYear, S.strTitle, BPH.strPINO, BGH.dtRecdDate ,
(select CT.strCurrency from currencytypes CT where CT.intCurID=BPH.strCurrency)as currencyName
FROM bulkgrnheader BGH
inner join bulkgrndetails BGD on BGD.intBulkGrnNo=BGH.intBulkGrnNo and BGD.intYear=BGH.intYear
Inner Join bulkpurchaseorderheader BPH ON BPH.intBulkPoNo = BGH.intBulkPoNo AND BPH.intYear=BGH.intYear 
Inner Join suppliers S ON S.strSupplierID = BPH.strSupplierID 
inner join matitemlist MIL on MIL.intItemSerial=BGD.intMatDetailID where BGH.intStatus=$intStatus";			

if($noFrom!="")
	$sql .= " and BGH.intBulkGrnNo >= '$noFrom'";
if($noTo!="")
	$sql .= " and BGH.intBulkGrnNo <= '$noTo'";
if ($intCompany!="")
	$sql .= " and BGH.intCompanyID=$intCompany ";
if ($intMeterial!= "")
	$sql .= " and MIL.intMainCatID=$intMeterial ";	
if ($intCategory!= "")
	$sql .= " and MIL.intSubCatID=$intCategory " ;
if ($intDescription!= "")
	$sql .= " and MIL.intItemSerial=$intDescription " ;
if ($intSupplier!="")
	$sql .= " and BPH.strSupplierID=$intSupplier ";
if($dtmDateFrom!="")
	$sql .= " and DATE_FORMAT(BGH.dtRecdDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
if($dtmDateTo!="")
	$sql .= " and DATE_FORMAT(BGH.dtRecdDate,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			
$sql .= " order by BGH.intYear,BGH.intBulkGrnNo";
$result_2 = $db->RunQuery($sql);
$rowCount	= mysql_num_rows($result_2);

xlsWriteLabel(2,5,"BULK GRN REGISTER"); 

if ($intStatus==1) $RType= "(CONFIRMED LIST)"; 
elseif ($intStatus==0) $RType= "(PENDING LIST)";					 
elseif ($intStatus==10) $RType= "(CANCELED LIST)"; 	
						
	xlsWriteLabel(3,5,$RType); 
	xlsWriteLabel(4,0,"PO NO");
	xlsWriteLabel(4,1,"GRN NO");
	xlsWriteLabel(4,2,"Mat");
	xlsWriteLabel(4,3,"Description"); 
	xlsWriteLabel(4,4,"Color");
	xlsWriteLabel(4,5,"Size");
	xlsWriteLabel(4,6,"Unit");
	xlsWriteLabel(4,7,"Qty");
	xlsWriteLabel(4,8,"Rate");
	xlsWriteLabel(4,9,"Amount");
					//xlsWriteLabel(4,10,"Ret To Supp.");
	while ($rowdata=mysql_fetch_array($result_2))
	{
		$detailSql="SELECT distinct GH.intBulkGrnNo,GH.intYear, 
			BGD.intMatDetailID,
			MIL.intMainCatID, 
			MIL.intSubCatID,GH.intStatus,
			MMC.strDescription, 
			MIL.strItemDescription, 
			BGD.strColor , 
			BGD.strSize,
			BGD.dblQty AS dblQty, ((BGD.dblExQty +BGD.dblQty) - BGD.dblBalance) AS retToSup, 
			POD.dblUnitPrice, POD.strUnit 
			FROM bulkgrnheader GH
			INNER JOIN bulkgrndetails BGD ON GH.intBulkGrnNo=BGD.intBulkGrnNo AND GH.intYear=BGD.intYear 
			INNER JOIN bulkpurchaseorderheader POH ON GH.intBulkPoNo=POH.intbulkPONo AND GH.intYear=POH.intYear 
			INNER JOIN matitemlist MIL ON BGD.intMatDetailID=MIL.intItemSerial 
			INNER JOIN matmaincategory MMC ON MIL.intMainCatID=MMC.intID
			inner join bulkpurchaseorderdetails POD on POH.intbulkPoNo= POD.intbulkPoNo and POH.intYear= POD.intYear and POD.intMatDetailID=BGD.intMatDetailID 			and POD.strColor=BGD.strColor and POD.strSize=BGD.strSize 
			WHERE GH.intStatus=$intStatus AND GH.intBulkGrnNo =".$rowdata["intBulkGrnNo"]." AND GH.intYear =".$rowdata["intYear"]."";
			
			if ($intCompany!="")
				$detailSql .= " AND GH.intCompanyID=$intCompany  ";
			if ($intMeterial!= "")
				$detailSql .= " AND MIL.intMainCatID=$intMeterial ";
			if ($intCategory!= "")
				$detailSql .= " AND MIL.intSubCatID=$intCategory " ;
			if ($intDescription!= "")
				$detailSql .= " AND POD.intMatDetailID=$intDescription ";	
		$result = $db->RunQuery($detailSql); 					
		while($details= mysql_fetch_array($result))
		{	
			xlsWriteLabel($i,0,$details["intYear"]."/".$details["intBulkGrnNo"]);  		
			xlsWriteLabel($i,1,$rowdata["intYear"]."/".$rowdata["intBulkGrnNo"]);  	 	
			xlsWriteLabel($i,2,substr($details["strDescription"],0,3));  
			xlsWriteLabel($i,3,$details["strItemDescription"]);
			xlsWriteLabel($i,4,$details["strColor"]); 
			xlsWriteLabel($i,5,$details["strSize"]); 
			xlsWriteLabel($i,6,$details["strUnit"]); 
			xlsWriteLabel($i,7,$details["dblQty"]); 
			xlsWriteLabel($i,8,number_format($details["dblUnitPrice"],4));
			xlsWriteLabel($i,9,number_format($details["dblQty"]*$details["dblUnitPrice"],2));
			$i++;					
		}
	$i=$i++;
	}	 	 
			xlsEOF();

function GetCurrencyName($currecyId)
{
global $db;
	$sql="select strCurrency from currencytypes where intCurID='$currecyId'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strCurrency"];
}
?>