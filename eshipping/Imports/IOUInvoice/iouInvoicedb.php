<?php
session_start();
include("../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["REQUEST"];

if ($request=='getData')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$deliveryno=$_GET['deliveryno'];
	

	$sql="SELECT intIOUNo,deliverynote.intDeliveryNo, tbliouheader.strCustomerID ,intExporterID,deliverynote.strLCNO,deliverynote.strReasonDupIOU,
	strLCNO,tbliouheader.strVessel,deliverynote.dblPackages,deliverynote.strReasonDupIOU,
	deliverynote.strMerchandiser,customers.strName AS CustomerName,deliverynote.strPrevDoc,
	suppliers.strName AS SupplierName,wharfclerks.strName AS WharfClerk, forwaders.strName AS Forwader 
	FROM tbliouheader  LEFT JOIN customers ON tbliouheader.strCustomerID = customers.strCustomerID
	LEFT JOIN suppliers ON   tbliouheader.intExporterID = suppliers.strSupplierId
	LEFT JOIN wharfclerks ON  tbliouheader.intWharfClerk= wharfclerks.intWharfClerkID
	LEFT JOIN forwaders ON tbliouheader.intForwarder=forwaders.intForwaderID
	LEFT JOIN deliverynote ON  tbliouheader.intDeliveryNo=deliverynote.intDeliveryNo
	WHERE intIOUNo='$deliveryno'";
//die($sql);
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";
	
	
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{
		$XMLString .= "<blno><![CDATA[" . $row["strPrevDoc"]  . "]]></blno>\n";
		$XMLString .= "<deliveryno><![CDATA[" . $row["intIOUNo"]  . "]]></deliveryno>\n";
		$XMLString .= "<Consignee><![CDATA[" . $row["CustomerName"]  . "]]></Consignee>\n";
		$XMLString .= "<Frowader><![CDATA[" . $row["Forwader"]  . "]]></Frowader>\n";
		$XMLString .= "<Exportar><![CDATA[" . $row["SupplierName"]  . "]]></Exportar>\n";
		$XMLString .= "<Vessel><![CDATA[" . $row["strVessel"]  . "]]></Vessel>\n";
		$XMLString .= "<noOfPkg><![CDATA[" . $row["dblPackages"]  . "]]></noOfPkg>\n";
		$XMLString .= "<Merchandiser><![CDATA[" . $row["strMerchandiser"]  . "]]></Merchandiser>\n";
		$XMLString .= "<Clerk><![CDATA[" . $row["WharfClerk"]  . "]]></Clerk>\n";
		$XMLString .= "<lcno><![CDATA[" . $row["strLCNO"]  . "]]></lcno>\n";
		$XMLString .= "<reason><![CDATA[" . $row["strReasonDupIOU"]  . "]]></reason>\n";
		$XMLString .= "<CustomerID><![CDATA[" . $row["strCustomerID"]  . "]]></CustomerID>\n";
		
				
	}
	
	$XMLString .= "</DeliveryData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

else if ($request=='ioudetail')
{
	$deliveryno=$_GET['deliveryno'];
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$ResponseXML .="<LoadExpenceType>\n";
	

$sqliou="SELECT ID.intIOUNo,intExpensesID,
(SELECT strDescription FROM expensestype ET WHERE ET.intExpensesID=ID.intExpensesID)AS expenceType,
dblEstimate,	dblActual,		dblInvoice 		FROM tblioudetails ID	WHERE ID.intIOUNo='$deliveryno'";
	//	die($sqliou);		
		//echo $sqliou;
$result_iou=$db->RunQuery($sqliou);
	while($row_iou=mysql_fetch_array($result_iou))
	{
		
			$ResponseXML .= "<ExpensesID><![CDATA[" . $row_iou["intExpensesID"]  . "]]></ExpensesID>\n";
			$ResponseXML .= "<ExpenceType><![CDATA[" . $row_iou["expenceType"]  . "]]></ExpenceType>\n";
			$ResponseXML .= "<Estimate><![CDATA[" . $row_iou["dblEstimate"]  . "]]></Estimate>\n";
			$ResponseXML .= "<Actual><![CDATA[" . $row_iou["dblActual"]  . "]]></Actual>\n";
			$ResponseXML .= "<Invoice><![CDATA[" . $row_iou["dblInvoice"]  . "]]></Invoice>\n";
	
	
	}
	$ResponseXML .="</LoadExpenceType>";
	echo $ResponseXML;


}

else if ($request=='updateiou')
{

	$iouno=$_GET['iouno'];
	$id=$_GET['id'];
	$invoice=$_GET['invoice'];
	$checked=$_GET['checked'];
	
	$sql="UPDATE tblioudetails 
	SET	
	
	dblInvoice = '$invoice',
	intDoInvoice='$checked'
	WHERE
	intIOUNo = '$iouno' AND intExpensesID = '$id'" ;
	//die($sql);
	$result=$db->RunQuery($sql);
	if($result)
	{
		echo"updated";	
	
	}

}

else if ($request=='iouinvoice')
{
$iouno=$_GET['iouno'];
$invoiceno=$_GET['invoiceno'];
$invdate=$_GET['invdate'];
$totInvoice=$_GET['totInvoice'];
$customerid=$_GET['customerid'];
		$InvoiceDateArray 	= explode('/',$invdate);
		$FormatInvoiceDate = $InvoiceDateArray[0]."-".$InvoiceDateArray[1]."-".$InvoiceDateArray[2];

$seesql="SELECT intInvoiceNo FROM tbliouinvoice WHERE  intInvoiceNo='$invoiceno' ";
$seeresult=$db->RunQuery($seesql);
	if(mysql_fetch_array($seeresult)>0)
	{
		$iouupdate="UPDATE tbliouinvoice 
	SET
	dtmInvoiceDate = '$FormatInvoiceDate' , 
	dblTotalAmount = '$totInvoice'
	
	WHERE
	intInvoiceNo = '$invoiceno' ";
	$updtresult=$db->RunQuery($iouupdate);
			if($updtresult)
			{
				echo"Successfully updated.";			
			
			}
		
	}
	else
	{	
		$sql="INSERT INTO tbliouinvoice 
		(intInvoiceNo, 
		intIOUNo, 
		strCustomerID, 
		dtmInvoiceDate, 
		strEntryNo, 
		strSENo, 
		dblTotalAmount
		)
		VALUES
		('$invoiceno', 
		'$iouno', 
		'$customerid', 
		'$FormatInvoiceDate', 
		'0', 
		'0', 
		'$totInvoice'
		)";
	$insertresult=$db->RunQuery($sql);
	if($insertresult)
	{
		$sqlinc="UPDATE syscontrol SET
		intInvoiceno  = intInvoiceno+1 WHERE intInvoiceno = '$invoiceno'";
		 $updateresult=$db->RunQuery($sqlinc);
			if($updateresult)
			{
		 		
		 		$sqliou="UPDATE tbliouheader 
				SET
				intSettled = '2' 
				WHERE
				intIOUNo = '$iouno' " ;

				$iouresult=$db->RunQuery($sqliou);
				if($iouresult)
					{	
						echo"Successfully Saved";
					}
		 	}
	}

	}

}

?>