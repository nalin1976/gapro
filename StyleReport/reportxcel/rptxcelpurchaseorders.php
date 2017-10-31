<?php
// ----- begin of function library -----
// Excel begin of file header
session_start();
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
	$txtMatItem			= $_GET["txtMatItem"];
	$ReportId			= $_GET["ReportId"];
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
	
	
$detailSql = "SELECT DISTINCT purchaseorderdetails.intPoNo ,purchaseorderdetails.intYear, purchaseorderdetails.strBuyerPONO, purchaseorderheader.strPINO,purchaseorderheader.strSupplierID,suppliers.strTitle ,purchaseorderheader.dtmDate,purchaseorderheader.dtmDeliveryDate  , specification.intSRNO, purchaseorderdetails.dblQty,purchaseorderdetails.dblUnitPrice,purchaseorderdetails.dblQty*purchaseorderdetails.dblUnitPrice AS amount,purchaseorderdetails.strColor, matmaincategory.strDescription,matitemlist.strItemDescription ,purchaseorderdetails.strSize,purchaseorderdetails.strUnit,purchaseorderdetails.dblQty-purchaseorderdetails.dblPending deleveryQty, purchaseorderdetails.intStyleId, purchaseorderheader.strCurrency, purchaseorderdetails.strRemarks,purchaseorderdetails.dblAdditionalQty,orders.strOrderNo,purchaseorderdetails.intMatDetailID FROM purchaseorderheader INNER JOIN purchaseorderdetails ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear INNER JOIN specification ON purchaseorderdetails.intStyleId = specification.intStyleId INNER JOIN matitemlist ON purchaseorderdetails.intMatDetailID= matitemlist.intItemSerial INNER JOIN suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID INNER JOIN matmaincategory ON matitemlist.intMainCatID=matmaincategory.intID INNER JOIN matsubcategory ON matitemlist.intSubCatID= matsubcategory.intSubCatNo INNER JOIN orders ON purchaseorderdetails.intStyleId=orders.intStyleId WHERE  purchaseorderheader.intStatus=$intStatus";
			
			if($ReportId == "radCompPo")
			{
			 	$detailSql .= " AND purchaseorderdetails.dblPending='0' ";
			}
			if($ReportId == "radOpenPO")
			{
			 	$detailSql .= " AND purchaseorderdetails.dblPending>0 and purchaseorderdetails.dblPending <> purchaseorderdetails.dblQty ";
			}
			if ($noFrom!="")
			{
			 	$detailSql .= " AND purchaseorderheader.intPoNo>=$noFrom ";
			}
			if ($noTo!="")
			{
				$detailSql .= " AND purchaseorderheader.intPoNo<=$noTo ";
			}
			
			if ($intCompany!="")
			{
			 	$detailSql .= " AND purchaseorderheader.intCompanyID=$intCompany ";
			}
			
			if ($strStyleNo!= "")
			{ 
				$detailSql .= " and purchaseorderdetails.intStyleId ='$strStyleNo' ";						
			}
			
			if ($strBPo	!= "")
			{
				$detailSql .= " and purchaseorderdetails.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " and matitemlist.intMainCatID=$intMeterial ";	
			}			
			if ($txtMatItem!= "")
			{				
				$detailSql .= " and matitemlist.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intCategory!= "")
			{				
				$detailSql .= " and matitemlist.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "")
			{
				$detailSql .= " and purchaseorderdetails.intMatDetailID=$intDescription ";						
			}	
			
			if ($intSupplier!="")
			{			
				$detailSql .= " and purchaseorderheader.strSupplierID=$intSupplier ";
			}

			if ($intBuyer!="")
			{
				$detailSql .= " and orders.intBuyerID=$intBuyer";				
			}
			
			if ($dtmDateFrom!="")
			{						
				$detailSql .= " and DATE_FORMAT(purchaseorderheader.dtmDate,'%Y/%m/%d')>= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d') "; 
			}
			
			if ($dtmDateTo!="")
			{						
				$detailSql .= " AND DATE_FORMAT(purchaseorderheader.dtmDate,'%Y/%m/%d')<= DATE_FORMAT('$dtmDateTo','%Y/%m/%d') ";
			}
				 $detailSql .=" Order By purchaseorderdetails.intYear,purchaseorderheader.intPoNo";
				//echo  $detailSql;
				 $result = $db->RunQuery($detailSql); 
				 $i=5;
				   xlsWriteLabel(2,5,"PURCHASE ORDER REGISTER"); 
				
					xlsWriteLabel(4,0,"Po No");
					xlsWriteLabel(4,1,"Currency"); 
					xlsWriteLabel(4,2,"Date");
					xlsWriteLabel(4,3,"Supplier Name");
					xlsWriteLabel(4,4,"Order No");
					xlsWriteLabel(4,5,"ScNo");
					xlsWriteLabel(4,6,"Buyer PoNo");
					xlsWriteLabel(4,7,"Main Category");
					xlsWriteLabel(4,8,"Item Description");
					xlsWriteLabel(4,9,"Color");
					xlsWriteLabel(4,10,"Size");
					xlsWriteLabel(4,11,"Unit");
					xlsWriteLabel(4,12,"PO Qty");
					xlsWriteLabel(4,13,"Confirm GRN Qty");
					xlsWriteLabel(4,14,"GRN Recieved Date");
                                        xlsWriteLabel(4,15,"Unit Price");
					xlsWriteLabel(4,16,"Amount");
					xlsWriteLabel(4,17,"GRN Location");
					
				 while($row= mysql_fetch_array($result))
				 {			 	
				 	xlsWriteLabel($i,0,$row["intYear"].'/'.$row["intPoNo"]);  
				 	xlsWriteLabel($i,1,GetCurrencyName($row["strCurrency"]));
				 	xlsWriteLabel($i,2,$row["dtmDate"]); 
				 	xlsWriteLabel($i,3,$row["strTitle"]); 
					xlsWriteLabel($i,4,$row["strOrderNo"]); 
					xlsWriteNumber($i,5,$row["intSRNO"]); 
					xlsWriteLabel($i,6,$row["strBuyerPONO"]); 
					xlsWriteLabel($i,7,(substr($row["strDescription"],0,3))); 
					xlsWriteLabel($i,8,$row["strItemDescription"]); 
					xlsWriteLabel($i,9,$row["strColor"]); 
					xlsWriteLabel($i,10,$row["strSize"]);
					xlsWriteLabel($i,11,$row["strUnit"]);
					xlsWriteNumber($i,12,round($row["dblQty"],2));
					xlsWriteNumber($i,13,round(GetGRNQty($row["intPoNo"],$row["intYear"],$row["intStyleId"],$row["strBuyerPONO"],$row["intMatDetailID"],$row["strColor"],$row["strSize"]),2));
					xlsWriteLabel($i,14,GRNRecievedDate($row["intPoNo"],$row["intYear"]));
                                        xlsWriteNumber($i,15,number_format($row["dblUnitPrice"],4));
					xlsWriteNumber($i,16,number_format($row["amount"],4));
					xlsWriteLabel($i,17, GetGRNLocation($row["intPoNo"],$row["intYear"]));
					$totalQty += $row["dblQty"];
					$totalAmount += $row["amount"];		 	  
				 	$i++;					
				 	}
				 	
				 	$totSal = 12;
				 	xlsWriteLabel($i,1,"Total"); 				 		 
				 	xlsWriteNumber($i,12,round($totalQty,2));
					xlsWriteNumber($i,16,round($totalAmount,2));
				 	$i += 2;				 	 
					xlsEOF();

function GetCurrencyName($currecyId)
{
global $db;
$sql="select strCurrency from currencytypes where intCurID='$currecyId'";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
return $row["strCurrency"];
}

function GRNRecievedDate($poNo,$poYear)
{
global $db;
$sql="SELECT
grnheader.intPoNo,
grnheader.intYear,
date(grnheader.dtmRecievedDate) AS RecievedDate
FROM
grnheader
WHERE
grnheader.intPoNo = '$poNo' AND
grnheader.intYear = '$poYear'
GROUP BY
grnheader.intPoNo
";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
$recievedDate=$row['RecievedDate'];
return $recievedDate;
}

function GetGRNQty($poNo,$poYear,$styleId,$buyerPoNo,$matId,$color,$size)
{
global $db;
$qty = 0;
	$sql="select sum(GD.dblQty)as qty from grnheader GH  
	inner join grndetails GD on GH.intGrnNo=GD.intGrnNo and GH.intGRNYear=GD.intGRNYear
	where GH.intPoNo='$poNo' and GH.intYear='$poYear' and GD.intStyleId='$styleId' and GD.strBuyerPONO='$buyerPoNo' and GD.intMatDetailID='$matId' and GD.strColor='$color' and GD.strSize='$size' and GH.intStatus=1";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["qty"];
	}
return $qty;
}

function GetGRNLocation($poNo, $poYear){

	global $db;

	$sql = " SELECT mainstores.strName
             FROM  purchaseorderheader Inner Join mainstores ON purchaseorderheader.intDelToCompID = mainstores.intCompanyId
             WHERE purchaseorderheader.intPONo =  '$poNo' AND mainstores.intStatus =  '1' AND purchaseorderheader.intYear = '$poYear' "; 

    $result = $db->RunQuery($sql);

    $arrGRNLocation = mysql_fetch_row($result);

    return $arrGRNLocation[0];
}
?>
