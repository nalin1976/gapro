<?php
// ----- begin of function library -----
// Excel begin of file header
session_start();
include "../../../Connector.php" ;	
	$intMeterial 		= $_GET["intMeterial"];
	$intCategory 		= $_GET["intCategory"];
	$intDescription 	= $_GET["intDescription"];
	$intSupplier 		= $_GET["intSupplier"];
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
header ("Content-Disposition: attachment; filename=StyleReportPurchaseOrder.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" ); 
xlsBOF();   // begin Excel stream
	
	
$detailSql="SELECT DISTINCT
generalpurchaseorderdetails.intGenPoNo,
generalpurchaseorderdetails.intYear,
generalpurchaseorderheader.strPINO,
generalpurchaseorderheader.intSupplierID,
suppliers.strTitle,
generalpurchaseorderheader.dtmDate,
generalpurchaseorderheader.dtmDeliveryDate,
generalpurchaseorderdetails.dblQty,
generalpurchaseorderdetails.dblUnitPrice,
generalpurchaseorderdetails.dblQty*generalpurchaseorderdetails.dblUnitPrice AS amount,
genmatmaincategory.strDescription,
genmatitemlist.strItemDescription,
genmatitemlist.strItemCode,
generalpurchaseorderdetails.strUnit,
generalpurchaseorderdetails.dblQty-generalpurchaseorderdetails.dblPending AS deleveryQty,
generalpurchaseorderheader.strCurrency,
generalpurchaseorderdetails.strRemarks  
FROM generalpurchaseorderheader  
INNER JOIN generalpurchaseorderdetails ON generalpurchaseorderheader.intGenPoNo = generalpurchaseorderdetails.intGenPoNo AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear
 INNER JOIN genmatitemlist ON generalpurchaseorderdetails.intMatDetailID= genmatitemlist.intItemSerial INNER JOIN suppliers ON generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID 
INNER JOIN genmatmaincategory ON genmatitemlist.intMainCatID=genmatmaincategory.intID INNER JOIN genmatsubcategory ON genmatitemlist.intSubCatID= genmatsubcategory.intSubCatNo
WHERE generalpurchaseorderheader.intStatus=$intStatus ";
			
			if ($noFrom!="")
			{
			 	$detailSql .= " AND generalpurchaseorderheader.intGenPoNo>=$noFrom ";
			}
			if ($noTo!="")
			{
				$detailSql .= " AND generalpurchaseorderheader.intGenPoNo<=$noTo ";
			}
			
			if ($intCompany!="")
			{
			 	$detailSql .= " AND generalpurchaseorderheader.intCompId=$intCompany ";
			}
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " and genmatitemlist.intMainCatID=$intMeterial ";	
			}			

			if ($intCategory!= "")
			{				
				$detailSql .= " and genmatitemlist.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "")
			{
				$detailSql .= " and generalpurchaseorderdetails.intMatDetailID=$intDescription ";						
			}	
			
			if ($intSupplier!="")
			{			
				$detailSql .= " and generalpurchaseorderheader.strSupplierID=$intSupplier ";
			}

			
			if ($dtmDateFrom!="")
			{						
				$detailSql .= " and DATE_FORMAT(generalpurchaseorderheader.dtmDate,'%Y/%m/%d')>= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
			}
			
			if ($dtmDateTo!="")
			{						
				$detailSql .= " AND DATE_FORMAT(generalpurchaseorderheader.dtmDate,'%Y/%m/%d')<= DATE_FORMAT('$dtmDateTo','%Y/%m/%d') ";
			}	
			$detailSql .=" order By generalpurchaseorderdetails.intGenPoNo,generalpurchaseorderdetails.intYear";				
			//echo $detailSql;
				 $result = $db->RunQuery($detailSql); 
				 $i=5;
				   xlsWriteLabel(2,5,"GENERAL PURCHASE ORDER REGISTER"); 
				
					xlsWriteLabel(4,0,"Po No");
					xlsWriteLabel(4,1,"Currency"); 
					xlsWriteLabel(4,2,"Date");
					xlsWriteLabel(4,3,"Supplier Name");
					xlsWriteLabel(4,4,"Main Category");
					//materialRatioID
					xlsWriteLabel(4,5,"Item Code");
					xlsWriteLabel(4,6,"Item Description");
					xlsWriteLabel(4,7,"Unit");
					xlsWriteLabel(4,8,"Qty");
					xlsWriteLabel(4,9,"Unit Price");
					xlsWriteLabel(4,10,"Amount");
					
				 while($row= mysql_fetch_array($result))
				 {			 	
				 	xlsWriteLabel($i,0,$row["intYear"].'/'.$row["intGenPoNo"]);  
				 	xlsWriteLabel($i,1,$row["strCurrency"]);
				 	xlsWriteLabel($i,2,$row["dtmDate"]); 
				 	xlsWriteLabel($i,3,$row["strTitle"]); 
					xlsWriteLabel($i,4,(substr($row["strDescription"],0,3))); 
					xlsWriteLabel($i,5,$row["strItemCode"]); 
					xlsWriteLabel($i,6,$row["strItemDescription"]); 
					xlsWriteLabel($i,7,$row["strUnit"]);
					xlsWriteNumber($i,8,round($row["dblQty"],2));
					xlsWriteNumber($i,9,number_format($row["dblUnitPrice"],4));
					xlsWriteNumber($i,10,number_format($row["amount"],4));
					$totalQty += $row["dblQty"];
					$totalAmount += $row["amount"];		 	  
				 	$i++;					
				 	}
				 	
				 	$totSal = 12;
				 	xlsWriteLabel($i,1,"Total"); 				 		 
				 	xlsWriteNumber($i,8,round($totalQty,2));
					xlsWriteNumber($i,10,round($totalAmount,2));
				 	$i += 2;				 	 
					xlsEOF();

?>
