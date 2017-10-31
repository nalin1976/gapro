<?php	
	session_start();
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	include "../../Connector.php";
	$RequestType	= $_GET["RequestType"];
	$CompanyId  	= $_SESSION["FactoryID"];
	$userId			= $_SESSION["UserID"];



if($RequestType=="LoadIOUheader")
{
	$invoiceno=$_GET['invoice'];
	
	
	$sqlstr="SELECT 	intIOUNo,
	(SELECT 	strName FROM customers WHERE strCustomerID=ih.strCompanyID)AS customer,
	ih.strInvoiceNo, 
	(SELECT strName	FROM buyers WHERE strBuyerID=ih.strBuyerID)AS buyer, 
	intIOUPrint, 
	strReasonDupIOU, 
	strVessel, 
	strType, 
	intSettled, 
	intInvoiced, 
	intEDIIOU, 
	strPaymentTerms, 
	strLCNumber
	 
	FROM 
	tblexiouheader iou  left JOIN invoiceheader ih  ON iou.strInvoiceNo=ih.strInvoiceNo
	WHERE 
	iou.intIOUNo='$invoiceno' ";
	
	$result_iouheader=$db->RunQuery($sqlstr);
	
	if(mysql_fetch_array($result_iouheader)<1)
	{$sqlstr="SELECT 	intIOUNo,
	(SELECT 	strName FROM customers WHERE strCustomerID=ih.strCompanyID)AS customer,
	ih.strInvoiceNo, 
	(SELECT strName	FROM buyers WHERE strBuyerID=ih.strBuyerID)AS buyer, 
	intIOUPrint, 
	strReasonDupIOU, 
	strVessel, 
	strType, 
	intSettled, 
	intInvoiced, 
	intEDIIOU, 
	strPaymentTerms, 
	strLCNumber
	 
	FROM 
	invoiceheader ih   left JOIN tblexiouheader iou ON iou.strInvoiceNo=ih.strInvoiceNo
	WHERE ih.strInvoiceNo='$invoiceno' ";
		
	}
	$result_iouheader=$db->RunQuery($sqlstr);
	$ResponseXML ="<DATA>";
	$ResponseXML .="<InvoiceHeader>";
	while($row_iouHeader=mysql_fetch_array($result_iouheader))
	{
		
			$ResponseXML .= "<IOUNo><![CDATA[" . $row_iouHeader["intIOUNo"]  . "]]></IOUNo>\n";
			$ResponseXML .= "<customer><![CDATA[" . $row_iouHeader["customer"]  . "]]></customer>\n";
			$ResponseXML .= "<buyer><![CDATA[" . $row_iouHeader["buyer"]  . "]]></buyer>\n";
			$ResponseXML .= "<InvoiceNo><![CDATA[" . $row_iouHeader["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			
	}
	$ResponseXML .="</InvoiceHeader>";
	$ResponseXML .="</DATA>";
	echo $ResponseXML;
}

if($RequestType=="LoadExpenceType")
{
	$deliveryNo	= $_GET["deliveryNo"];
	$ResponseXML .="<LoadExpenceType>\n";
	
$booiou = true;	
$sqliou="SELECT
	intIOUNo, 	 
	et.intExpensesID,
	strDescription,
	dblEstimate, 
	dblActual, 
	dblInvoice	 
	FROM 
	
	tblexioudetail  id left join expensestype et on
	id.intExpensesID=et.intExpensesID	
	WHERE intIOUNo='$deliveryNo' order by intExpensesID";

$result_iou=$db->RunQuery($sqliou);
	while($row_iou=mysql_fetch_array($result_iou))
	{
		$booiou = false;
			$ResponseXML .= "<IOUNo><![CDATA[" . $row_iou["intIOUNo"]  . "]]></IOUNo>\n";
			$ResponseXML .= "<ExpensesID><![CDATA[" . $row_iou["intExpensesID"]  . "]]></ExpensesID>\n";
			$ResponseXML .= "<ExpenceType><![CDATA[" . $row_iou["strDescription"]  . "]]></ExpenceType>\n";
			$ResponseXML .= "<Estimate><![CDATA[" . $row_iou["dblEstimate"]  . "]]></Estimate>\n";
			$ResponseXML .= "<Actual><![CDATA[" . $row_iou["dblActual"]  . "]]></Actual>\n";
			$ResponseXML .= "<Invoice><![CDATA[" . $row_iou["dblInvoice"]  . "]]></Invoice>\n";
	}
	if($booiou)
	{
	$sql="select * from expensestype where booDeleted=0 Order BY intExpensesID";
	//echo $sql;
	$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<IOUNo><![CDATA[0]]></IOUNo>\n";
			$ResponseXML .= "<ExpensesID><![CDATA[" . $row["intExpensesID"]  . "]]></ExpensesID>\n";
			$ResponseXML .= "<ExpenceType><![CDATA[" . $row["strDescription"]  . "]]></ExpenceType>\n";
			$ResponseXML .= "<Estimate><![CDATA[]]></Estimate>\n";
			$ResponseXML .= "<Actual><![CDATA[]]></Actual>\n";
			$ResponseXML .= "<Invoice><![CDATA[]]></Invoice>\n";
		}
	}
	$ResponseXML .="</LoadExpenceType>";
	echo $ResponseXML;
}

if($RequestType=="SaveIOUHeader")
{	$iouNo	= $_GET["iouNo"];
	$invoice	= $_GET["invoice"];
	$update	= $_GET["update"];	
	$strDeleteFirst="
DELETE FROM tblexiouheader WHERE intIOUNo = '$iouNo' AND strInvoiceNo = '$invoice' ;
 ";
	$deleteresult=$db->RunQuery($strDeleteFirst);	
	$strInsert="INSERT INTO tblexiouheader 
	(intIOUNo, 
	strInvoiceNo
	
	)
	VALUES
	('$iouNo', 
	'$invoice');";
	
	$insertresult=$db->RunQuery($strInsert);
	if($insertresult ){
	echo"Successfully saved.";
	if($update==1){
	$strupdatecontrol="UPDATE syscontrol 
	SET
	dblExportIOUNo = dblExportIOUNo+1";
	$updateresult=$db->RunQuery($strupdatecontrol);	
	$strUPStatus="UPDATE exportcusdechead SET intStatus=10 WHERE strInvoiceNo='$invoice'";
	$updateresult=$db->RunQuery($strUPStatus);	
	}
	}
}

if($RequestType=="SaveIOUDetails")
{
	$iouNo	= $_GET["iouNo"];
	$expenceID	= $_GET["expenceID"];	
	$estimate	= $_GET["estimate"];
	$expenceID	= $_GET["expenceID"];
	
	
	$strDeleteFirst="DELETE FROM tblexioudetail WHERE intIOUNo = '$iouNo' AND intExpensesID = '$expenceID' ";
	$deleteresult=$db->RunQuery($strDeleteFirst);
	$strInsert="INSERT INTO tblexioudetail 
	(intIOUNo, 
	intExpensesID, 
	dblEstimate, 
	dblActual, 
	dblInvoice, 
	intDoInvoice
	)
	VALUES
	('$iouNo', 
	'$expenceID', 
	'$estimate', 
	'0', 
	'0', 
	'0'
	);
";
	$insertresult=$db->RunQuery($strInsert);
	if($insertresult)
	echo"Successfully saved.";
	
}


?>