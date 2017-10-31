<?php
session_start();
include "../Connector.php";
$id=$_GET["id"];
if($id=="ConfirmInvoicePrice")
{		
$PONO 			 = $_GET["POno"];
$POYear 		 = $_GET["POYear"];
$strStyleID 	 = $_GET["strStyleID"];
$strBuyerPOid 	 = $_GET["strBuyerPOid"];
$intMatDetailID  = $_GET["intMatDetailID"];
$strColor 		 = $_GET["strColor"];
$strUnit 		 = $_GET["strUnit"];
$strSize 		 = $_GET["strSize"];
$dblQty 		 = $_GET["dblQty"];
$POprice 		 = $_GET["POprice"];
$dblInvoicePrice = $_GET["dblInvoicePrice"];
$GRNNo 			 = $_GET["GRNNo"];
$GRNyear 		 = $_GET["GRNyear"];
		
$SQL = "update purchaseorderdetails set dblInvoicePrice='$dblInvoicePrice' where  intPoNo = '$PONO' and intYear = '$POYear' and intStyleId = '$strStyleID' and intMatDetailID = '$intMatDetailID' and strColor = '$strColor' and strSize = '$strSize' and strBuyerPONO = '$strBuyerPOid' " ;
$intSave = $db->RunQuery($SQL);		
if(!$intSave)
{
	echo "error->Error in Updating Invoice Price";
	return;
}
else
{
	$SQLgrn = "update grndetails set dblPaymentPrice = '$dblInvoicePrice' where intGrnNo = '$GRNNo' and intGRNYear = '$GRNyear' and intStyleId = '$strStyleID' and strBuyerPONO = '$strBuyerPOid' and intMatDetailID = '$intMatDetailID' and strColor = '$strColor' and strSize = '$strSize' ";
	$intSaveGRN = $db->RunQuery($SQLgrn);
	if(!intSaveGRN)
	{
		echo "error->Error in Updating Invoice Price";
		return;
	}
}		
}		
?>