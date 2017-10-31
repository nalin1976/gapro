<?php

include "../../Connector.php";
$id=$_GET['id'];

if($id=="loadBankLetter")
{
	$buyerId=$_GET['buyerId'];
	$response="<option value=0></option>";
	
	if($buyerId!=0)
	{
		$sql="SELECT
				bankletter_header.intSerialNo
				FROM
				bankletter_header
				WHERE strBuyerCode='$buyerId'
				;";
	}
	else
	{
		$sql="SELECT
				bankletter_header.intSerialNo
				FROM
				bankletter_header
				;";
	}
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$response.="<option value=".$row['intSerialNo'].">".$row['intSerialNo']."</option>";
	}
	echo $response;
}
if($id=="loadGrid")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<GridDetails>";

	$masterbuyerCode=$_GET['masterbuyerCode'];
	$chk_val=$_GET['chk_val'];
	$dateFrom=$_GET['dateFrom'];
	$dateTo=$_GET['dateTo'];
	$bankCode=$_GET['bankCode'];
	$bankLetterNo=$_GET['bankLetterNo'];
	
	$dateFromArray 	= explode('/',$dateFrom);
	$FormatDateFrom = $dateFromArray[2]."-".$dateFromArray[1]."-".$dateFromArray[0];
	
	$dateToArray 	= explode('/',$dateTo);
	$FormatDateTo   = $dateToArray[2]."-".$dateToArray[1]."-".$dateToArray[0];
	
	if($bankLetterNo==0)
	{
	
	 $sql="SELECT DISTINCT
			SUM(commercial_invoice_detail.dblQuantity) As dblQuantity,
			ROUND(SUM(commercial_invoice_detail.dblAmount),2) AS dblAmount,
			ROUND(commercial_invoice_header.dblDiscountAmt,2) AS dblDiscountAmt,
			commercial_invoice_detail.strInvoiceNo,
			commercial_invoice_header.dtmInvoiceDate,
			buyers.strBuyerID,
			commercial_invoice_detail.strBuyerPONo,
			commercial_invoice_detail.strStyleID,
			buyers.strName,
			buyers_main.strMainBuyerName,
			orderspec.strWFXId
			FROM
			commercial_invoice_detail
			INNER JOIN commercial_invoice_header ON commercial_invoice_header.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
			INNER JOIN orderspec ON orderspec.strStyle_No = commercial_invoice_detail.strStyleID
			INNER JOIN buyers ON buyers.strBuyerID = commercial_invoice_header.strBuyerID
			INNER JOIN buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId
			WHERE buyers_main.intMainBuyerId ='$masterbuyerCode'
			GROUP BY commercial_invoice_detail.strInvoiceNo ;";
	}
	else
	{
	 $sql="SELECT DISTINCT
			SUM(commercial_invoice_detail.dblQuantity) As dblQuantity,
			ROUND(SUM(commercial_invoice_detail.dblAmount),2) AS dblAmount,
			ROUND(commercial_invoice_header.dblDiscountAmt,2) AS dblDiscountAmt,
			commercial_invoice_detail.strInvoiceNo,
			commercial_invoice_header.dtmInvoiceDate,
			buyers.strBuyerID,
			commercial_invoice_detail.strBuyerPONo,
			commercial_invoice_detail.strStyleID,
			buyers.strName,
			orderspec.strWFXId
			FROM
			commercial_invoice_detail
			INNER JOIN commercial_invoice_header ON commercial_invoice_header.strInvoiceNo = commercial_invoice_detail.strInvoiceNo
			INNER JOIN orderspec ON orderspec.strStyle_No = commercial_invoice_detail.strStyleID
			INNER JOIN bankletter_detail ON bankletter_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
			INNER JOIN buyers ON buyers.strBuyerID = commercial_invoice_header.strBuyerID
			INNER JOIN buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId
			WHERE buyers_main.intMainBuyerId ='$masterbuyerCode'
			GROUP BY commercial_invoice_detail.strInvoiceNo  ;";
	}
	if($chk_val==1)
		$sql.=" AND dtmInvoiceDate>='$FormatDateFrom' AND dtmInvoiceDate<='$FormatDateTo';";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$invNo=$row["strInvoiceNo"];
		$buyerInvId = $row["strBuyerID"];
		$sql_check="SELECT
					receipt_detail.strInvoiceNo,
					receipt_header.strBankCode
					FROM
					receipt_detail
					INNER JOIN receipt_header ON receipt_detail.intSerialNo = receipt_header.intSerialNo
					WHERE strBuyerCode='$masterbuyerCode' AND strInvoiceNo='$invNo' AND receipt_header.intCancelStatus=0;";
		$result_check=$db->RunQuery($sql_check);
		$row_check=mysql_fetch_array($result_check);
		
		 $sql2="SELECT
				ROUND(SUM(finalinvoice.dblDiscount),2) AS dblDiscount,
				finalinvoice.strDiscountType
				FROM
				finalinvoice
				WHERE strInvoiceNo='$invNo' GROUP BY strInvoiceNo";
		$result2=$db->RunQuery($sql2);
		$row2=mysql_fetch_array($result2);
		
		if(mysql_num_rows($result_check)==0)
		{
			$value="value";
			$discount=0;
			$dateToArray 	= explode(' ',$row["dtmInvoiceDate"]);
			$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$ResponseXML .= "<InvAmount><![CDATA[" . $row["dblAmount"]  . "]]></InvAmount>\n";
			$ResponseXML .= "<InvDate><![CDATA[" . $dateToArray[0]  . "]]></InvDate>\n";
			$ResponseXML .= "<PoNo><![CDATA[" . $row["strBuyerPONo"]  . "]]></PoNo>\n";
			$ResponseXML .= "<Style><![CDATA[" .$row["strStyleID"] . "]]></Style>\n";
			$ResponseXML .= "<wfxid><![CDATA[" .$row["strWFXId"] . "]]></wfxid>\n";
			
			if(mysql_num_rows($result2)>0)
			{
				$ResponseXML .= "<Discount><![CDATA[" . $row2["dblDiscount"]  . "]]></Discount>\n";
				$ResponseXML .= "<DiscountType><![CDATA[" . $row2["strDiscountType"]  . "]]></DiscountType>\n";
			}
			else
			{
				$ResponseXML .= "<Discount><![CDATA[" . $discount  . "]]></Discount>\n";
				$ResponseXML .= "<DiscountType><![CDATA[" . $value  . "]]></DiscountType>\n";
			}
			//$ResponseXML .= "<BuyerId><![CDATA[" . $buyerInvId  . "]]></BuyerId>\n";
			//$ResponseXML .= "<BuyerName><![CDATA[" . $row["strName"]  . "]]></BuyerName>\n";
		}
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;
}

if($id=='saveHeader')
{
	$serialNo=$_GET['serialNo'];
	$buyerCode=$_GET['buyerId'];
	$bankCode=$_GET['bankId'];
	$newDate=$_GET['date'];
	$buyerClaim=$_GET['buyerClaim'];
	$remarks=$_GET['remarks'];
	
	$dateArray 	= explode('/',$newDate);
	$FormatDate = $dateArray[2]."-".$dateArray[1]."-".$dateArray[0];
	
	if($serialNo==0)
	{
		$sql_increment="UPDATE syscontrol
						SET
						intReceiptNo=intReceiptNo+1;";
		$result_increment=$db->RunQuery($sql_increment);
		
		$sql_select="SELECT intReceiptNo FROM syscontrol;";
		$result_select=$db->RunQuery($sql_select);
		$row_select=mysql_fetch_array($result_select);
		
		$serialNo=$row_select['intReceiptNo'];
	}
		
		$sql_insert="INSERT INTO receipt_header (intSerialNo,strBuyerCode,strBankCode,dtmReceiptDate,dblBuyerClaim,strRemarks,intStatus)
					  VALUES ($serialNo,'$buyerCode','$bankCode','$FormatDate',$buyerClaim,'$remarks',0);";
		$result_insert=$db->RunQuery($sql_insert);
		if($result_insert)
			echo $serialNo;
		else
			echo 0;
}

if($id=='saveDetail')
{
	$serialNo=$_GET['serialNo'];
	$invoiceNo=$_GET['invoiceNo'];
	$invoiceAmt=$_GET['invoiceAmt'];
	$invoiceDate=$_GET['invoiceDate'];
	$invoiceNetAmt=$_GET['invoiceNetAmt'];
	$invoiceDiscAmt=$_GET['invoiceDiscount'];
	$bankId=$_GET['bankId'];
	$buyerId=$_GET['buyerId'];
	$date=$_GET['date'];
	$styleid=$_GET['styleid'];
	
	
	$finvoiceamt=$_GET['finvoiceamt'];
	$txtNetReceiptAmt=$_GET['txtNetReceiptAmt'];
	$txtTotNetAmt=$_GET['txtTotNetAmt'];
	
	$dateArray 	= explode('/',$date);
	$FormatDate = $dateArray[2]."-".$dateArray[1]."-".$dateArray[0];
	
	
	 $sql="INSERT INTO receipt_detail (intSerialNo,strInvoiceNo,dblInvoiceAmt,dtmInvoiceDate,dblInvoiceDiscountAmt,dblInvoiceNetAmt,intStatus, intBuyerId,strWFXId)
	      VALUES($serialNo,'$invoiceNo',$invoiceAmt,'$invoiceDate',$invoiceDiscAmt,$invoiceNetAmt,0,$buyerId,'$styleid');";
	$result=$db->RunQuery($sql);
	
	$sql_discount="SELECT strInvoiceNo FROM discount_detail WHERE strInvoiceNo='$invoiceNo';
";
	$result_discount=$db->RunQuery($sql_discount);
	if(mysql_num_rows($result_discount)==0)
		$discounted=0;
	else
		$discounted=1;
	
	if($result)
	{
		/*$sql_ms="INSERT INTO export_data.receipt_detail 			(strBuyerCode,iSerialNo,dDate,fAmount,strBankCode,cType,bDiscounted,cStyleCode,cInvoiceNo,dInvoiceDate,fInvoiceAmt,fReturnAmt)
	      VALUES('$buyerId',$serialNo,'$FormatDate','$invoiceNetAmt','$bankId','r',$discounted,'','$invoiceNo','$invoiceDate',$invoiceNetAmt,0);";*/
		
		
		
  $sql_ms="INSERT INTO ReceiptDetail 			(strBuyerCode,iSerialNo,dDate,fAmount,strBankCode,cType,bDiscounted,cStyleCode,cInvoiceNo,dInvoiceDate,fInvoiceAmount,fReturnAmount)
	      VALUES('$buyerId',$serialNo,'$FormatDate',$invoiceNetAmt,'$bankId','r',$discounted,'$styleid','$invoiceNo','$invoiceDate',$finvoiceamt,0);";	  
		$result_ms=$msdb->RunQueryMS($sql_ms);
	//echo $result_ms;

	
	
	}
	
	 $sql_update_comm="UPDATE commercial_invoice_header
						SET 
						intDiscReceipt=1,
						dtmDiscReceiptDate='$invoiceDate',
						dblDiscReceiptAmt='$invoiceNetAmt'
						WHERE
						strInvoiceNo='$invoiceNo'";
						
	$result_update_comm=$db->RunQuery($sql_update_comm);
}


if($id=="loadSavedHeader")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<GridDetails>";

	$serialNo=$_GET['serialNo'];
	
	
	 $sql="SELECT
			receipt_header.strBuyerCode,
			receipt_header.strBankCode,
			receipt_header.dtmReceiptDate,
			receipt_header.dblBuyerClaim,
			receipt_header.strRemarks
			FROM
			receipt_header
			WHERE receipt_header.intSerialNo=$serialNo AND receipt_header.intStatus=0
			;";
	$result=$db->RunQuery($sql);
	
	//echo $sql;
	while($row=mysql_fetch_array($result))
	{
			$dateArray 	= explode('-',$row["dtmReceiptDate"]);
			$foramtDateArray= $dateArray[2]."/".$dateArray[1]."/".$dateArray[0];
			
			
			$ResponseXML .= "<BuyerCode><![CDATA[" . $row["strBuyerCode"]  . "]]></BuyerCode>\n";
			$ResponseXML .= "<BankCode><![CDATA[" . $row["strBankCode"]  . "]]></BankCode>\n";
			$ResponseXML .= "<ReceiptDate><![CDATA[" .$foramtDateArray  . "]]></ReceiptDate>\n";
			$ResponseXML .= "<BuyerClaim><![CDATA[" .$row["dblBuyerClaim"]  . "]]></BuyerClaim>\n";
			$ResponseXML .= "<Remarks><![CDATA[" .$row["strRemarks"]  . "]]></Remarks>\n";
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;
}

 if($id=="loadSavedDetail")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<GridDetails>";

	$serialNo=$_GET['serialNo'];
	
	
	$sql="SELECT
			receipt_detail.intSerialNo,
			receipt_detail.strInvoiceNo,
			receipt_detail.dblInvoiceAmt,
			receipt_detail.dtmInvoiceDate,
			receipt_detail.dblInvoiceDiscountAmt,
			receipt_detail.dblInvoiceNetAmt,
			receipt_detail.intBuyerId,
			
			commercial_invoice_detail.strStyleID,
			commercial_invoice_detail.strBuyerPONo,
			receipt_detail.strWFXId
			FROM
			receipt_detail
			INNER JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo = receipt_detail.strInvoiceNo
			WHERE receipt_detail.intSerialNo=$serialNo AND receipt_detail.intStatus=0
			GROUP BY receipt_detail.strInvoiceNo;";
	$result=$db->RunQuery($sql);
	
	//echo $sql;
	while($row=mysql_fetch_array($result))
	{
			$dateArray 	= explode(' ',$row["dtmInvoiceDate"]);
			
			$ResponseXML .= "<InvNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvNo>\n";
			$ResponseXML .= "<InvAmt><![CDATA[" . $row["dblInvoiceAmt"]  . "]]></InvAmt>\n";
			$ResponseXML .= "<InvDate><![CDATA[" .$dateArray[0]  . "]]></InvDate>\n";
			$ResponseXML .= "<PoNo><![CDATA[" .$row["strBuyerPONo"]  . "]]></PoNo>\n";
			$ResponseXML .= "<Style><![CDATA[" . $row["strStyleID"]  . "]]></Style>\n";
			$ResponseXML .= "<InvDiscAmt><![CDATA[" .$row["dblInvoiceDiscountAmt"]  . "]]></InvDiscAmt>\n";
			$ResponseXML .= "<InvNetAmt><![CDATA[" .$row["dblInvoiceNetAmt"]  . "]]></InvNetAmt>\n";
			$ResponseXML .= "<InvBuyerId><![CDATA[" .$row["intBuyerId"]  . "]]></InvBuyerId>\n";
			$ResponseXML .= "<wfxid><![CDATA[" .$row["strWFXId"] . "]]></wfxid>\n";
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;
}
if($id=='cancelReceipt')
{
	$serialNo=$_GET['serialNo'];
	
	$sql_delete_header="UPDATE receipt_header
						SET intStatus=1
						WHERE receipt_header.intSerialNo=$serialNo
						;";
	$result_delete_header=$db->RunQuery($sql_delete_header);
	
	$sql_delete_detail="UPDATE receipt_detail
			SET intStatus=1
			WHERE receipt_detail.intSerialNo=$serialNo
			;";
	$result_delete_detail=$db->RunQuery($sql_delete_detail);
	
	echo "Receipt Cancelled";
}

if($id=='deleteFromMs')
{
	$serialNo=$_GET['serialNo'];
	$invoiceNo=$_GET['invoiceNo'];
	$invoiceAmt=$_GET['invoiceAmt'];
	$invoiceDate=$_GET['invoiceDate'];
	$invoiceNetAmt=$_GET['invoiceNetAmt'];
	$invoiceDiscAmt=$_GET['invoiceDiscount'];
	$bankId=$_GET['bankId'];
	$buyerId=$_GET['buyerId'];
	$date=$_GET['date'];
	
	$sql_discount="SELECT strInvoiceNo FROM discount_detail WHERE strInvoiceNo='$invoiceNo';
";
	$result_discount=$db->RunQuery($sql_discount);
	if(mysql_num_rows($result_discount)==0)
		$discounted=0;
	else
		$discounted=1;
	
	$sql_ms="INSERT INTO export_data.receipt_detail 			(strBuyerCode,iSerialNo,dDate,fAmount,strBankCode,cType,bDiscounted,cStyleCode,cInvoiceNo,dInvoiceDate,fInvoiceAmt,fReturnAmt)
	      VALUES('$buyerId',$serialNo,'$date','$invoiceNetAmt','$bankId','r',$discounted,'','$invoiceNo','$invoiceDate',$invoiceNetAmt,$invoiceNetAmt);";
	$result_ms=$db->RunQuery($sql_ms);

	$sql_ms="INSERT INTO ReceiptDetail 			(strBuyerCode,iSerialNo,dDate,fAmount,strBankCode,cType,bDiscounted,cStyleCode,cInvoiceNo,dInvoiceDate,fInvoiceAmount,fReturnAmount)
	      VALUES('$buyerId',$serialNo,'$date','$invoiceNetAmt','$bankId','r',$discounted,'','$invoiceNo','$invoiceDate',$invoiceNetAmt,$invoiceNetAmt);";
	$result_ms=$msdb->RunQueryMS($sql_ms);
}


if($id=='CancelInv')
{	
	$invoiceNo=$_GET['invoiceNo'];
	$cboSerialNo=$_GET['cboSerialNo'];
	
	$serialNo=$_GET['cboSerialNo'];
	$invoiceAmt=$_GET['invoiceAmt'];
	$invoiceDate=$_GET['invoiceDate'];
	$invoiceNetAmt=$_GET['invoiceNetAmt'];
	$invoiceDiscAmt=$_GET['invoiceDiscount'];
	$bankId=$_GET['bankId'];
	$buyerId=$_GET['buyerId'];
	$styleid=$_GET['styleid'];
	$date=$_GET['date'];
	$txtDate=$_GET['txtDate'];
	
	$finvoiceamt=$_GET['finvoiceamt'];
	$txtNetReceiptAmt=$_GET['txtNetReceiptAmt'];
	$txtTotNetAmt=$_GET['txtTotNetAmt'];
	
	$sql_discount="SELECT strInvoiceNo FROM discount_detail WHERE strInvoiceNo='$invoiceNo';
";
	$result_discount=$db->RunQuery($sql_discount);
	if(mysql_num_rows($result_discount)==0)
		$discounted=0;
	else
		$discounted=1;
	
	
	 $sql_status="UPDATE receipt_header	
					SET intCancelStatus=1
					WHERE intSerialNo='$cboSerialNo' ;";
					
	$result=$db->RunQuery($sql_status);
	// echo $cboSerialNo;
	
	if($result)
	{
	 $sql_update_comm="UPDATE commercial_invoice_header
						SET 
						commercial_invoice_header.intDiscReceipt=0
						WHERE
						strInvoiceNo='$invoiceNo' ;";
						
	$result_update_comm=$db->RunQuery($sql_update_comm);
	// echo $invoiceNo;
	 // $result_update_comm;
	}
	  if($result_update_comm)
	  	{
	  
				 $sql_dec="SELECT DISTINCT strInvoiceNo
						FROM receipt_detail
						WHERE strInvoiceNo='$invoiceNo';";
					
					$result_dec=$db->RunQuery($sql_dec);
		}
					
				while($row=mysql_fetch_array($result_dec))
				{
	
		  $invoiceNo=$row["strInvoiceNo"];
		
 $sql_ms="INSERT INTO ReceiptDetail 							(strBuyerCode,iSerialNo,dDate,fAmount,strBankCode,cType,bDiscounted,cStyleCode,cInvoiceNo,dInvoiceDate,fInvoiceAmount,fReturnAmount)
	      VALUES('$buyerId',$serialNo,'$invoiceDate',$invoiceNetAmt,'$bankId','r',$discounted,'$styleid','$invoiceNo','$invoiceDate',0,$finvoiceamt);";	  
		$result_ms=$msdb->RunQueryMS($sql_ms);
	
				}
}



if($id=="uploadFile")
{
	header('Content-Type: text/xml'); 
	 "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<GridDetails>";

	$GInvoiceNo=$_GET['GInvoiceNo'];
	$GpoNo=$_GET['GpoNo'];	
	

			
	
						 $sql_up="SELECT strInvoice_No
								FROM import_receipt
								WHERE strInvoice_No='$GInvoiceNo' AND strBuyer_PoNo='$GpoNo';";
		
	$result_up=$db->RunQuery($sql_up);
	
	
	//echo $sql_up;	
					while($row=mysql_fetch_array($result_up))
					{
						{
						 $invoiceNo=$row["strInvoice_No"];
						$sql_status="UPDATE import_receipt
									SET intStatus=1
									WHERE strInvoice_No='$invoiceNo';";
							$result_status=$db->RunQuery($sql_status);		
									
						}
						$ResponseXML .= "<InvNo><![CDATA[" . $row["strInvoice_No"]  . "]]></InvNo>";
					}
				
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;

					
}

if($id=="deleteuploadfile")
{

	$GpoNo=$_GET['masterbuyerCode'];
	$sql_dlt="DELETE FROM import_receipt;";
							$result_dlt=$db->RunQuery($sql_dlt);		
	

}


if($id=="chkerror")
{

	$cboSerialNo=$_GET['cboSerialNo'];
	 $sql_alrt="SELECT strInvoice_No
			FROM import_receipt	
				WHERE intStatus=0;";
							$result_alrt=$db->RunQuery($sql_alrt);	
								while($row=mysql_fetch_array($result_alrt))
				{
	
		 $strInvoice_No=$row["strInvoice_No"];	
				}
 echo $strInvoice_No;
}




if($id=="loadDeleteHeader")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<GridDetails>";

	$serialNo=$_GET['serialNo'];
	
	
	 $sql="SELECT
			receipt_header.strBuyerCode,
			receipt_header.strBankCode,
			receipt_header.dtmReceiptDate,
			receipt_header.dblBuyerClaim,
			receipt_header.strRemarks
			FROM
			receipt_header
			WHERE receipt_header.intSerialNo=$serialNo AND receipt_header.intStatus=0
			;";
	$result=$db->RunQuery($sql);
	
	//echo $sql;
	while($row=mysql_fetch_array($result))
	{
			$dateArray 	= explode('-',$row["dtmReceiptDate"]);
			$foramtDateArray= $dateArray[2]."/".$dateArray[1]."/".$dateArray[0];
			
			
			$ResponseXML .= "<BuyerCode><![CDATA[" . $row["strBuyerCode"]  . "]]></BuyerCode>\n";
			$ResponseXML .= "<BankCode><![CDATA[" . $row["strBankCode"]  . "]]></BankCode>\n";
			$ResponseXML .= "<ReceiptDate><![CDATA[" .$foramtDateArray  . "]]></ReceiptDate>\n";
			$ResponseXML .= "<BuyerClaim><![CDATA[" .$row["dblBuyerClaim"]  . "]]></BuyerClaim>\n";
			$ResponseXML .= "<Remarks><![CDATA[" .$row["strRemarks"]  . "]]></Remarks>\n";
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;
}
	
?>