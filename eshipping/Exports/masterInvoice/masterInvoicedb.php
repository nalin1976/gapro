<?php
session_start();
require_once('../../Connector.php');
header('Content-Type: text/xml'); 

$request 	= $_GET['request'];
$companyId  = $_SESSION["FactoryID"];
$userId	 	= $_SESSION["UserID"];

if($request=="getInvoiceDetails")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<getInvoiceDetails>\n";
	$carrier      = $_GET["carrier"];
	$dateTo      = $_GET["dateTo"];
	$dateFrom      = $_GET["dateFrom"];
	
	$sql = "SELECT CID.strInvoiceNo,CID.strDescOfGoods,CID.strBuyerPONo,CID.strStyleID,SUM(CID.intNoOfCTns) AS intNoOfCTns,SUM(CID.dblQuantity) AS dblQuantity,CID.dblUnitPrice,ROUND(SUM(CID.dblAmount),2) AS dblAmount
			FROM commercial_invoice_detail CID
			INNER JOIN commercial_invoice_header CIH ON CID.strInvoiceNo=CIH.strInvoiceNo
			WHERE CIH.strCarrier='$carrier' AND CIH.dtmETA<='$dateTo' AND CIH.dtmETA>='$dateFrom'  GROUP BY CIH.strInvoiceNo;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array( $result)) 
	{
		$ResponseXML .= "<InvoiceNo><![CDATA[".($row["strInvoiceNo"])  . "]]></InvoiceNo>\n";	
		$ResponseXML .= "<DescOfGoods><![CDATA[".($row["strDescOfGoods"])  . "]]></DescOfGoods>\n";
		$ResponseXML .= "<BuyerPONo><![CDATA[".($row["strBuyerPONo"])  . "]]></BuyerPONo>\n";
		$ResponseXML .= "<Style><![CDATA[".($row["strStyleID"])  . "]]></Style>\n";
		$ResponseXML .= "<NoOfCTns><![CDATA[".($row["intNoOfCTns"])  . "]]></NoOfCTns>\n";	
		$ResponseXML .= "<Quantity><![CDATA[".($row["dblQuantity"])  . "]]></Quantity>\n";
		$ResponseXML .= "<UnitPrice><![CDATA[".($row["dblUnitPrice"])  . "]]></UnitPrice>\n";
		$ResponseXML .= "<Amount><![CDATA[".($row["dblAmount"])  . "]]></Amount>\n";	
	}
	$ResponseXML .= "</getInvoiceDetails>";
	echo $ResponseXML;
}
if($request=="saveHeaderData")
{
	$InvId			 = $_GET["InvId"];
	$masterInvoiceNo = $_GET["masterInvoiceNo"];
	$buyerId		 = $_GET["buyerId"];
	$date			 = $_GET["date"];
	$dateArry		 = explode('/',$date);
	$newDate		 = $dateArry[2].'-'.$dateArry[1].'-'.$dateArry[0];
	
	$sql_deleteH = "delete from masterinvoice_header 
					where
					intMasterInvId = '$InvId'";
	$result_deleteH = $db->RunQuery($sql_deleteH);
	
	$sql_deleteD = "delete from masterinvoice_detail 
					where
					intMasterInvId = '$InvId'";
	$result_deleteD = $db->RunQuery($sql_deleteD);
	
	$sql_insertH = "insert into masterinvoice_header 
					(
					intMasterInvId,
					strMasterInvNo, 
					dtmDate, 
					dtmSaveDate,
					intBuyerId,
					intUserId
					)
					values
					(
					'$InvId',
					'$masterInvoiceNo', 
					'$newDate', 
					 now(),
					'$buyerId',
					'$userId'
					)";
	$result_insertH = $db->RunQuery($sql_insertH);
	if($result_insertH)
		echo "headerSaved";
	else
		echo "ErrorH";					
}
if($request=="saveDetailData")
{
	$InvId 			 = $_GET["InvId"];
	$invNo 			 = $_GET["invNo"];
	$Description 	 = $_GET["Description"];
	$PONo			 = $_GET["PONo"];
	$styleNo 		 = $_GET["styleNo"];
	$CTNS 		     = $_GET["CTNS"];
	$Pcs 			 = $_GET["Pcs"];
	$UPrice 		 = $_GET["UPrice"];
	$amount 		 = $_GET["amount"];

	$sql_insertD = "insert into masterinvoice_detail 
					(
					intMasterInvId, 
					strInvoiceNo, 
					strDescription, 
					strBuyerPONo, 
					strStyleNo, 
					intCTNS, 
					intPcs, 
					dblUnitPrice, 
					dblAmount
					)
					values
					(
					'$InvId', 
					'$invNo', 
					'$Description', 
					'$PONo', 
					'$styleNo', 
					'$CTNS', 
					'$Pcs', 
					'$UPrice', 
					'$amount'
					)";
	$result_insertD = $db->RunQuery($sql_insertD);
	if($result_insertD)
		echo "detailSaved";
	else
		echo "ErrorD";		
}
if($request=="getMasterInvId")
{
	$sql = "select intMasterInvoiceId from syscontrol where intCompanyID='$companyId'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$MasterInvId = $row["intMasterInvoiceId"];
	
	$sql_u = "update syscontrol set intMasterInvoiceId=intMasterInvoiceId+1 where intCompanyID='$companyId'";
	$result_u = $db->RunQuery($sql_u);
	
	echo $MasterInvId;
}
if($request=="loadMasterInvHData")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<loadMasterInvHData>\n";
	$masterInvNo   = $_GET["masterInvNo"];
	
	$sql_loadH = "select 	
					strMasterInvNo, 
					date(dtmDate) as dtmDate, 
					intBuyerId 
					from masterinvoice_header 
					where intMasterInvId='$masterInvNo'";
					
	$resultH = $db->RunQuery($sql_loadH);
	while($row=mysql_fetch_array( $resultH)) 
	{
		$date = $row["dtmDate"];
		$dateArray = explode('-',$date);
		$newDate = $dateArray[2].'/'.$dateArray[1].'/'.$dateArray[0];
		
		$ResponseXML .= "<MasterInvNo><![CDATA[".($row["strMasterInvNo"])  . "]]></MasterInvNo>\n";	
		$ResponseXML .= "<Date><![CDATA[".($newDate)  . "]]></Date>\n";
		$ResponseXML .= "<BuyerId><![CDATA[".($row["intBuyerId"])  . "]]></BuyerId>\n";
	}
	$ResponseXML .= "</loadMasterInvHData>";
	echo $ResponseXML;
}
if($request=="loadMasterInvDData")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<loadMasterInvDData>\n";
	$masterInvNo   = $_GET["masterInvNo"];
	
	$sql_loadD = "select 	
					strInvoiceNo, 
					strDescription, 
					strBuyerPONo, 
					strStyleNo, 
					intCTNS, 
					intPcs, 
					dblUnitPrice, 
					dblAmount
					from 
					masterinvoice_detail 
					where intMasterInvId='$masterInvNo'";
					
	$resultD = $db->RunQuery($sql_loadD);
	while($row=mysql_fetch_array( $resultD)) 
	{
		$ResponseXML .= "<InvoiceNo><![CDATA[".($row["strInvoiceNo"])  . "]]></InvoiceNo>\n";	
		$ResponseXML .= "<DescOfGoods><![CDATA[".($row["strDescription"])  . "]]></DescOfGoods>\n";
		$ResponseXML .= "<BuyerPONo><![CDATA[".($row["strBuyerPONo"])  . "]]></BuyerPONo>\n";
		$ResponseXML .= "<Style><![CDATA[".($row["strStyleNo"])  . "]]></Style>\n";
		$ResponseXML .= "<NoOfCTns><![CDATA[".($row["intCTNS"])  . "]]></NoOfCTns>\n";	
		$ResponseXML .= "<Quantity><![CDATA[".($row["intPcs"])  . "]]></Quantity>\n";
		$ResponseXML .= "<UnitPrice><![CDATA[".($row["dblUnitPrice"])  . "]]></UnitPrice>\n";
		$ResponseXML .= "<Amount><![CDATA[".($row["dblAmount"])  . "]]></Amount>\n";
	}
	$ResponseXML .= "</loadMasterInvDData>";
	echo $ResponseXML;
}
if($request=="load_carrier")
{
	$sql="SELECT DISTINCT strCarrier FROM commercial_invoice_header";	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$shippingLine_arr.=$row['strCarrier']."|";
				 
	}
	echo $shippingLine_arr;
}

if($request=="checkMasterInvNoAvailble")
{
	$masterInvId = $_GET["masterInvId"];
	$masterInvNo = $_GET["masterInvNo"];
	
	$sql = "select strMasterInvNo from masterinvoice_header where strMasterInvNo='$masterInvNo' and intMasterInvId<>'$masterInvId'";
	$result = $db->RunQuery($sql);
	$output = false;
	while($row = mysql_fetch_array($result))
	{
		$output = true;
	}
	 echo $output;
}



?>