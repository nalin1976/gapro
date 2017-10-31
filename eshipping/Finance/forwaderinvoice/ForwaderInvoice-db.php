<?php

include "../../Connector.php";
$id=$_GET['id'];

if($id=="loadGrid")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<GridDetails>";

	$forwaderId=$_GET['forwaderId'];
	$carrierName=$_GET['carrierName'];
	
	$sql="SELECT
			commercial_invoice_detail.strBuyerPONo,
			commercial_invoice_detail.strEntryNo,
			commercial_invoice_header.intCusdec,
			commercial_invoice_header.intInvoiceId,
			commercial_invoice_header.strInvoiceNo,
			commercial_invoice_header.strCarrier,
			commercial_invoice_header.strForwader
			FROM
			commercial_invoice_detail
			INNER JOIN commercial_invoice_header ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo";
			
	if($forwaderId!=0 && $carrierName!='')
		$sql.=" WHERE strForwader='$forwaderId' AND strCarrier='$carrierName';";
	else if($forwaderId!=0 && $carrierName=='')
		$sql.=" WHERE strForwader='$forwaderId';";
	else if($carrierName!='' && $forwaderId==0)
		$sql.=" WHERE strCarrier='$carrierName';";
	
	//echo $sql;	
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$BPONo=$row["strBuyerPONo"];
		$sql1="SELECT strBpoNo FROM forwader_invoice_detail WHERE intForwaderId=$forwaderId AND strBpoNo='$BPONo';";
	    $result1=$db->RunQuery($sql1);
		
		if(mysql_num_rows($result1)==0)
		{
			$ResponseXML .= "<CusdecNo><![CDATA[" . $row["strEntryNo"]  . "]]></CusdecNo>\n";
			$ResponseXML .= "<BPONo><![CDATA[" . $row["strBuyerPONo"]  . "]]></BPONo>\n";
			$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
		}
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;	
}

if($id=='checkExists')
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<CheckDetails>";

	$forwaderId=$_GET['forwaderId'];
	
	$sql="SELECT strBpoNo FROM forwader_invoice_detail WHERE intForwaderId=$forwaderId;";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<BPONo><![CDATA[" . $row["strBpoNo"]  . "]]></BPONo>\n";
	}
	$ResponseXML .= "</CheckDetails>";
	echo $ResponseXML;	
}

if($id=="saveHeader")
{
	$forwaderId=$_GET['forwaderId'];
	$carrierName=$_GET['carrierName'];
	$forwaderInvNo=$_GET['forwaderInvNo'];
	$amount=$_GET['amount'];
	$forInvDate=$_GET['forInvDate'];
	$submitStatus=$_GET['submitStatus'];
	$submitDate=$_GET['submitDate'];
	
	$dateForInvArray 	= explode('/',$forInvDate);
	$FormatDateForInv   = $dateForInvArray[2]."-".$dateForInvArray[1]."-".$dateForInvArray[0];
	
	$dateSubmitArray 	= explode('/',$submitDate);
	$FormatDateSubmit   = $dateSubmitArray[2]."-".$dateSubmitArray[1]."-".$dateSubmitArray[0];
	
	if($submitStatus==0)
	{
		$sql="INSERT INTO forwader_invoice_header (intForwaderId,strInvoiceNo,dtmDate,dblAmount)
		 	 VALUES($forwaderId,'$forwaderInvNo','$FormatDateForInv',$amount)";
	}
	else
	{
		$sql="INSERT INTO forwader_invoice_header (intForwaderId,strInvoiceNo,dtmDate,dblAmount,intSubmitStatus,dtmSubmitDate)
		 	 VALUES($forwaderId,'$forwaderInvNo','$FormatDateForInv',$amount,$submitStatus,'$FormatDateSubmit')";
	}
	$result=$db->RunQuery($sql);
	
	
	if($result)
		echo 1;
	else
		echo 0;
	
}

if($id=="updateHeader")
{
	$forwaderId=$_GET['forwaderId'];
	$invoiceNo=$_GET['invoiceNo'];
	$newAmount=$_GET['newAmount'];
	$newDate=$_GET['newDate'];
	$submitStatus=$_GET['submitStatus'];
	$submitDate=$_GET['submitDate'];
	
	$dateForInvArray 	= explode('/',$newDate);
	$FormatDateForInv   = $dateForInvArray[2]."-".$dateForInvArray[1]."-".$dateForInvArray[0];
	
	$dateSubmitArray 	= explode('/',$submitDate);
	$FormatDateSubmit   = $dateSubmitArray[2]."-".$dateSubmitArray[1]."-".$dateSubmitArray[0];
	
	if($submitStatus==0)
	{
		$sql="UPDATE forwader_invoice_header 
			SET 
			dtmDate='$FormatDateForInv',
			dblAmount=$newAmount,
			intSubmitStatus=$submitStatus
			WHERE
			intForwaderId=$forwaderId AND strInvoiceNo='$invoiceNo';";
	}
	else
	{
		$sql="UPDATE forwader_invoice_header 
			SET 
			dtmDate='$FormatDateForInv',
			dblAmount=$newAmount,
			intSubmitStatus=$submitStatus,
			dtmSubmitDate='$FormatDateSubmit'
			WHERE
			intForwaderId=$forwaderId AND strInvoiceNo='$invoiceNo';";
	}
	$result=$db->RunQuery($sql);
	
	if($result)
	{
		$sql_del="DELETE FROM forwader_invoice_detail WHERE intForwaderId=$forwaderId AND strInvoiceNo='$invoiceNo';";
		$result_del=$db->RunQuery($sql_del);
		echo 1;
	}
	else
		echo 0;
	
}

if($id=='saveDetail')
{
	$forwaderId=$_GET['forwaderId'];
	$forwaderInvNo=$_GET['forwaderInvNo'];
	$cusdecNo=$_GET['cusdecNo'];
	$bpoNo=$_GET['bpoNo'];
	$commercialInvoiceNo=$_GET['commercialInvoiceNo'];
	
	$sql="INSERT INTO forwader_invoice_detail (intForwaderId,strInvoiceNo,intCusdecNo,strBpoNo,strCommercialInvoiceNo)
		  VALUES($forwaderId,'$forwaderInvNo','$cusdecNo','$bpoNo','$commercialInvoiceNo');";
	//echo $sql;
		  
	$result=$db->RunQuery($sql);
	
	$sql_update_CommInv="UPDATE commercial_invoice_header
							SET
							intFInvReceived=1
							WHERE strInvoiceNo='$commercialInvoiceNo'";
	$result_update_CommInv=$db->RunQuery($sql_update_CommInv);
}

if($id=='loadInvoiceCombo')
{
	$forwaderId=$_GET['forwaderId'];
	$sql="SELECT
		  forwader_invoice_header.strInvoiceNo
		  FROM
		  forwader_invoice_header
		  WHERE intForwaderId=$forwaderId
			";
	$result=$db->RunQuery($sql);
	$response="<option value='0'></option>";
	while($row=mysql_fetch_array($result))
	{
		$response.="<option value=".$row['strInvoiceNo'].">".$row['strInvoiceNo']."</option>";
	}
	echo $response;
}

if($id=='loadSavedInvoiceDetail')
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<GridDetails>";

	$forwaderId=$_GET['forwaderId'];
	$invoiceNo=$_GET['invoiceNo'];
	
	$sql="SELECT
		forwader_invoice_header.intForwaderId,
		forwader_invoice_header.strInvoiceNo,
		forwader_invoice_header.dtmDate,
		forwader_invoice_header.strChequeNo,
		forwader_invoice_header.dblPaidAmount,
		forwader_invoice_header.dblAmount,
		forwader_invoice_detail.intCusdecNo,
		forwader_invoice_detail.strBpoNo,
		forwader_invoice_detail.strCommercialInvoiceNo,
		forwader_invoice_header.intSubmitStatus,
		forwader_invoice_header.dtmSubmitDate
		FROM
		forwader_invoice_header
		INNER JOIN forwader_invoice_detail ON forwader_invoice_header.intForwaderId = forwader_invoice_detail.intForwaderId AND forwader_invoice_header.strInvoiceNo = forwader_invoice_detail.strInvoiceNo
		WHERE forwader_invoice_header.intForwaderId=$forwaderId AND forwader_invoice_header.strInvoiceNo='$invoiceNo';";

	
	//echo $sql;	
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$dateArray  = explode('-',$row["dtmDate"]);
		$dateFormat = $dateArray[2]."/".$dateArray[1]."/".$dateArray[0];
		
		$dateSubmitArray  = explode('-',$row["dtmSubmitDate"]);
		$dateSubmit = $dateSubmitArray[2]."/".$dateSubmitArray[1]."/".$dateSubmitArray[0];
		
		$ResponseXML .= "<Date><![CDATA[" . $dateFormat  . "]]></Date>\n";
		$ResponseXML .= "<ChequeNO><![CDATA[" . $row["strChequeNo"]  . "]]></ChequeNO>\n";
		$ResponseXML .= "<PaidAmount><![CDATA[" . $row["dblPaidAmount"]  . "]]></PaidAmount>\n";
		$ResponseXML .= "<Amount><![CDATA[" . $row["dblAmount"]  . "]]></Amount>\n";
		$ResponseXML .= "<SubmitStatus><![CDATA[" . $row["intSubmitStatus"]  . "]]></SubmitStatus>\n";
		$ResponseXML .= "<SubmitDate><![CDATA[" . $dateSubmit  . "]]></SubmitDate>\n";
		
		
		$ResponseXML .= "<CusdecNo><![CDATA[" . $row["intCusdecNo"]  . "]]></CusdecNo>\n";
		$ResponseXML .= "<BPONo><![CDATA[" . $row["strBpoNo"]  . "]]></BPONo>\n";
		$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strCommercialInvoiceNo"]  . "]]></InvoiceNo>\n";
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;	
}

