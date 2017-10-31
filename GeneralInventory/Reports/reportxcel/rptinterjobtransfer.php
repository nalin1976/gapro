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
	$report_companyId =$_SESSION["FactoryID"];
	$txtMatItem			= $_GET["txtMatItem"];
	
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
header ("Content-Disposition: attachment; filename=StyleReportInterJob.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream

	$detailSql="select IT.intTransferId,
IT.intTransferYear,
IT.strStyleFrom,
(select intSRNO from specification where specification.strStyleID=IT.strStyleFrom)AS fromScNo,
IT.strStyleTo,
(select intSRNO from specification where specification.strStyleID=IT.strStyleTo)AS toScNo,
dtmTransferDate,
strBuyerPoNo,
MIL.strItemDescription,
strColor,
strSize,
ITD.strUnit,
ITD.dblQty,
ITD.dblUnitPrice,
(ITD.dblQty*ITD.dblUnitPrice)AS amount,
MMC.strDescription
from itemtransfer IT
INNER JOIN itemtransferdetails ITD ON IT.intTransferId=ITD.intTransferId and IT.intTransferYear=ITD.intTransferYear
INNER JOIN matitemlist MIL ON MIL.intItemSerial=ITD.intMatDetailId
INNER JOIN orders O ON O.strStyleID=IT.strStyleTo
INNER JOIN matmaincategory MMC ON MMC.intID=MIL.intMainCatID
WHERE IT.intStatus=$intStatus ";
			
			if ($noFrom!="")
			{
			 	$detailSql .= " AND IT.intTransferId>=$noFrom ";
			}
			if ($noTo!="")
			{
				$detailSql .= " AND IT.intTransferId<=$noTo ";
			}
			
			if ($intCompany!="")
			{
			 	$detailSql .= " AND IT.intFactoryCode=$intCompany ";
			}
			
			if ($strStyleNo!= "")
			{ 
				$detailSql .= " and IT.strStyleTo ='$strStyleNo' ";						
			}
			
			if ($strBPo	!= "")
			{
				$detailSql .= " and ITD.strBuyerPoNo='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " and MIL.intMainCatID=$intMeterial ";	
			}			

			if ($intCategory!= "")
			{				
				$detailSql .= " and MIL.intSubCatID=$intCategory " ;
			}
			if ($txtMatItem!= "")
			{				
				$detailSql .= " and MIL.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intDescription!= "")
			{
				$detailSql .= " and ITD.intMatDetailId=$intDescription ";						
			}				

			if ($intBuyer!="")
			{
				$detailSql .= " and orders.intBuyerID=$intBuyer";				
			}
			
			if ($dtmDateFrom!="")
			{						
				$detailSql .= " and DATE_FORMAT(IT.dtmTransferDate,'%Y/%m/%d')>= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
			}
			
			if ($dtmDateTo!="")
			{						
				$detailSql .= " AND DATE_FORMAT(IT.dtmTransferDate,'%Y/%m/%d')<= DATE_FORMAT('$dtmDateTo','%Y/%m/%d') ";
			}				
			
			 $detailSql .= "order by IT.intTransferId ";
		  	$detailResult = $db->RunQuery($detailSql);
			$checkNoAndYear="";
			
			$i=4;
				   xlsWriteLabel(2,5,"INTER JOB TRANSFER IN DETAILS");
				   
				   xlsWriteLabel($i,0,"Inter Job Trans In No :"); 
				   xlsWriteLabel($i,1,"From Order No:"); 
				   xlsWriteLabel($i,2,"From SC No:");
				   xlsWriteLabel($i,3,"Create Date :");
				   xlsWriteLabel($i,4,"To Order No:");
				   xlsWriteLabel($i,5,"To SC No:");
				   xlsWriteLabel($i,6,"Buyer PoNo");
					xlsWriteLabel($i,7,"Mat");
					xlsWriteLabel($i,8,"Item Description");
					xlsWriteLabel($i,9,"Color");
					xlsWriteLabel($i,10,"Size");
					xlsWriteLabel($i,11,"Unit");
					xlsWriteLabel($i,12,"Qty");
					xlsWriteLabel($i,13,"Rate"); 
					xlsWriteLabel($i,14,"Amount"); 
					$i++;
			
			while ($details=mysql_fetch_array($detailResult))
			{
					$noAndYear = $details["intTransferYear"].'/'.$details["intTransferId"];				 
					 xlsWriteLabel($i,0,$noAndYear); 
				  $fromOrderNo = getStyleName($details["strStyleFrom"]);
					 xlsWriteLabel($i,1,$fromOrderNo); 
					 xlsWriteLabel($i,2,$details["fromScNo"]);
					 xlsWriteLabel($i,3,$details["dtmTransferDate"]); 
					 $ToOrderNo = getStyleName($details["strStyleTo"]);
					 xlsWriteLabel($i,4,$ToOrderNo); 
					 
					  xlsWriteLabel($i,5,$details["toScNo"]);  
					  
				 	xlsWriteLabel($i,6,$details["strBuyerPoNo"]);
					xlsWriteLabel($i,7,substr($details["strDescription"],0,3));
					xlsWriteLabel($i,8,$details["strItemDescription"].' - '.$details["strRemarks"]);
					xlsWriteLabel($i,9,$details["strColor"]);
					xlsWriteLabel($i,10,$details["strSize"]);
					xlsWriteLabel($i,11,$details["strUnit"]);
					xlsWriteNumber($i,12,$details["dblQty"]);
					xlsWriteNumber($i,13,$details["dblUnitPrice"]);
					xlsWriteNumber($i,14,$details["amount"]); 
					
					$i++;
			}
		xlsEOF();	
		
function getStyleName($StyleID)
{
	$SQL = "Select strOrderNo From orders Where strStyleID='$StyleID'";
			 
			 global $db;
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$Stylename = $row["strOrderNo"];
			}
		return $Stylename;	 
			 
}	
?>