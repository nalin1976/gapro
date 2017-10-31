<?php

include "../../Connector.php";
$id=$_GET['id'];

if($id=="loadBanks")
{
	$buyerId=$_GET['buyerId'];
	$response="<option value=0></option>";
	
	if($buyerId!=0)
	{
		$sql="SELECT DISTINCT
			bank.strBankCode,
			bank.strName
			FROM
			bank
			INNER JOIN commercial_invoice_header ON commercial_invoice_header.intBankId = bank.strBankCode
			WHERE commercial_invoice_header.strBuyerID='$buyerId'
			ORDER BY strName;";
	}
	else
	{
		$sql="SELECT DISTINCT
			bank.strBankCode,
			bank.strName
			FROM
			bank
			INNER JOIN commercial_invoice_header ON commercial_invoice_header.intBankId = bank.strBankCode
			ORDER BY strName;";
	}
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$response.="<option value=".$row['strBankCode'].">".$row['strName']."</option>";
	}
	echo $response;
}

if($id=="loadBuyer")
{
	$bankId=$_GET['bankId'];
	$response="<option value=0></option>";
	
	if($bankId!=0)
	{
		$sql="SELECT DISTINCT
				buyers.strBuyerID,
				buyers.strBuyerCode,
				buyers.strName
				FROM
				buyers
				INNER JOIN commercial_invoice_header ON commercial_invoice_header.strBuyerID = buyers.strBuyerID
				WHERE commercial_invoice_header.intBankId=$bankId
				ORDER BY strName
				;";
	}
	else
	{
		$sql="SELECT DISTINCT
				buyers.strBuyerID,
				buyers.strBuyerCode,
				buyers.strName
				FROM
				buyers
				INNER JOIN commercial_invoice_header ON commercial_invoice_header.strBuyerID = buyers.strBuyerID
				ORDER BY strName
				;";
	}
	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$response.="<option value=".$row['strBuyerId'].">".$row['strName']."</option>";
	}
	echo $response;
}


if($id=="loadGrid")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<GridDetails>";

	$buyerId=$_GET['buyerId'];
	$bankId=$_GET['bankId'];
	
	
	$sql="SELECT DISTINCT
			commercial_invoice_header.dtmInvoiceDate,
			commercial_invoice_header.strInvoiceNo,
			commercial_invoice_detail.strBuyerPONo,
			commercial_invoice_detail.strStyleID,
			SUM(commercial_invoice_detail.dblQuantity) As dblQuantity,
			ROUND(SUM(commercial_invoice_detail.dblAmount),2) AS dblAmount,
			ROUND(commercial_invoice_header.dblDiscountAmt,2) AS dblDiscountAmt,
			buyers_main.strMainBuyerCode
			FROM
			commercial_invoice_header
			INNER JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
			INNER JOIN buyers ON buyers.strBuyerID = commercial_invoice_header.strBuyerID
			INNER JOIN buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId
			WHERE commercial_invoice_header.intDiscounted=0 AND buyers_main.intMainBuyerId=$buyerId
			GROUP BY commercial_invoice_header.strInvoiceNo
			;";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$invoiceNum=$row["strInvoiceNo"];
		//$sql1="SELECT strInvoiceNo FROM discount_detail WHERE strInvoiceNo='$invoiceNum' and ;";
		//$result1=$db->RunQuery($sql1);
		
		 $sql2="SELECT
				finalinvoice.dblDiscount,
				finalinvoice.strDiscountType
				FROM
				finalinvoice
				WHERE strInvoiceNo='$invoiceNum';";
		$result2=$db->RunQuery($sql2);
		$row2=mysql_fetch_array($result2);
		
		//if(mysql_num_rows($result1)==0)
		//{
			$value="value";
			$discount=0;
			$dateToArray 	= explode(' ',$row["dtmInvoiceDate"]);
			$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$ResponseXML .= "<InvAmount><![CDATA[" . $row["dblAmount"]  . "]]></InvAmount>\n";
			$ResponseXML .= "<InvDate><![CDATA[" . $dateToArray[0]  . "]]></InvDate>\n";
			$ResponseXML .= "<StyleId><![CDATA[" . $row["strStyleID"]  . "]]></StyleId>\n";
			$ResponseXML .= "<BuyerPoNo><![CDATA[" . $row["strBuyerPONo"]  . "]]></BuyerPoNo>\n";
			
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
		//}

	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;
}

if($id=='getRefNo')
{
	$sql_increment="UPDATE syscontrol
						SET
						intDisRefNo=intDisRefNo+1;";
		$result_increment=$db->RunQuery($sql_increment);
		
		$sql_select="SELECT intDisRefNo FROM syscontrol;";
		$result_select=$db->RunQuery($sql_select);
		$row_select=mysql_fetch_array($result_select);
		
		$refNo=$row_select['intDisRefNo'];
		echo $refNo;
}

if($id=='saveHeader')
{
	$bankId=$_GET['bankId'];
	$buyerId=$_GET['buyerId'];
	$refNo=$_GET['refNo'];
	$discountAmt=$_GET['discountAmt'];
	$grantedAmt=$_GET['grantedAmt'];
	$interest=$_GET['interest'];
	$cboRefNo=$_GET['cboRefNo'];
	
	if($cboRefNo=='')
	{
		/*$sql_del_header="DELETE FROM discount_header WHERE strRefNo='$cboRefNo'; ";
		$result_del_header=$db->RunQuery($sql_del_header);
		
		$sql_del_detail="DELETE FROM discount_detail WHERE strRefNo='$cboRefNo'; ";
		$resultdel_detail=$db->RunQuery($sql_del_detail);
		
	}*/
	
	$sql="INSERT INTO discount_header(strRefNo,strBankId,intBuyerID,dblDiscountAmt,dblGrantedAmt,dblInterest)
	      VALUES('$refNo','$bankId','$buyerId','$discountAmt','$grantedAmt','$interest')";
	$result=$db->RunQuery($sql);
	if($result)
		echo 1;
	else
		echo 0;
	}
	
}
if($id=='saveDetail')
{
	$refNo=$_GET['refNo'];
	$invoiceNo=$_GET['invoiceNo'];
	$invoiceAmt=$_GET['invoiceAmt'];
	$invoiceDate=$_GET['invoiceDate'];
	$discountInvAmt=$_GET['discountAmt'];
	$netAmt=$_GET['netAmt'];
	$bankId=$_GET['bankId'];
	$buyerId=$_GET['buyerId'];
	$styleid=$_GET['styleid'];
	
	$sql="INSERT INTO discount_detail (strRefNo,strInvoiceNo,dblInvoiceAmt,dtmInvoiceDate,dblDiscountAmt,dblNetAmt)
	      VALUES('$refNo','$invoiceNo',$invoiceAmt,'$invoiceDate','$discountInvAmt','$netAmt');";
	$result=$db->RunQuery($sql);
	
	if($result)
	{	
 $sql_ms="INSERT INTO ReceiptDetail 			(strBuyerCode,iSerialNo,dDate,fAmount,strBankCode,cType,bDiscounted,cStyleCode,cInvoiceNo,dInvoiceDate,fInvoiceAmount,fReturnAmount)
	      VALUES('$buyerId',$refNo,'$invoiceDate',$netAmt,'$bankId','d',1,'$styleid','$invoiceNo','$invoiceDate',$invoiceAmt,0);";
		$result_ms=$msdb->RunQueryMS($sql_ms);
	}
	
$sql_update_comm="UPDATE commercial_invoice_header
						SET 
						intDiscounted=1,
						dtmDiscountDate='$invoiceDate',
						dblDiscountAmt='$invoiceAmt'
						WHERE
						strInvoiceNo='$invoiceNo';";
						
	$result_update_comm=$db->RunQuery($sql_update_comm);
	if($result_update_comm)
	{
		echo 1;
	}
}


if($id=="loadSavedDataToGrid")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<GridDetails>";

	$refNo=$_GET['refNo'];
	
	
	$sql="SELECT DISTINCT
			discount_header.strBankId,
			discount_header.intBuyerID,
			discount_header.dblGrantedAmt,
			discount_header.dblInterest,
			discount_detail.strInvoiceNo,
			discount_detail.dblInvoiceAmt,
			discount_detail.dtmInvoiceDate,
			discount_detail.dblDiscountAmt,
			discount_detail.dblNetAmt,
			commercial_invoice_detail.strStyleID,
			commercial_invoice_detail.strBuyerPONoz
			FROM
			discount_detail
			INNER JOIN discount_header ON discount_header.strRefNo = discount_detail.strRefNo
			INNER JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo = discount_detail.strInvoiceNo
			WHERE discount_detail.strRefNo='$refNo';";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
		$ResponseXML .= "<InvAmount><![CDATA[" . $row["dblInvoiceAmt"]  . "]]></InvAmount>\n";
		$ResponseXML .= "<BankId><![CDATA[" . $row["strBankId"]  . "]]></BankId>\n";
		$ResponseXML .= "<BuyerId><![CDATA[" . $row["intBuyerID"]  . "]]></BuyerId>\n";
		$ResponseXML .= "<GrantedAmt><![CDATA[" . $row["dblGrantedAmt"]  . "]]></GrantedAmt>\n";
		$ResponseXML .= "<Interest><![CDATA[" . $row["dblInterest"]  . "]]></Interest>\n";
		$ResponseXML .= "<InvDate><![CDATA[" . $row["dtmInvoiceDate"]  . "]]></InvDate>\n";
		$ResponseXML .= "<DiscountAmt><![CDATA[" . $row["dblDiscountAmt"]  . "]]></DiscountAmt>\n";
		$ResponseXML .= "<NetAmt><![CDATA[" . $row["dblNetAmt"]  . "]]></NetAmt>\n";
		$ResponseXML .= "<Style><![CDATA[" . $row["strStyleID"]  . "]]></Style>\n";
		$ResponseXML .= "<PoNo><![CDATA[" . $row["strBuyerPONo"]  . "]]></PoNo>\n";
		
	}
	$ResponseXML .= "</GridDetails>";
	echo $ResponseXML;
}


if($id=='CancelInv')
{	

	//$serialNo=$_GET['serialNo'];
	 $invoiceAmt=$_GET['invoiceAmt'];
	$invoiceDate=$_GET['invoiceDate'];
	//$invoiceNetAmt=$_GET['invoiceNetAmt'];
	$invoiceDiscAmt=$_GET['invoiceDiscount'];
	$bankId=$_GET['bankId'];
	$buyerId=$_GET['buyerId'];
	 $netAmt=$_GET['netAmt'];
 	$txtDate=$_GET['txtDate'];
	$styleid=$_GET['styleid'];

	$invoiceNo=$_GET['invoiceNo'];
	$cboRefNo=$_GET['cboRefNo'];
	
	$sql_status="UPDATE discount_header	
					SET intCancelStatus=1
					WHERE strRefNo='$cboRefNo' ;";
					
	$result=$db->RunQuery($sql_status);
	 //$cboRefNo;
	
	if($result)
	{
		$sql_update_comm="UPDATE commercial_invoice_header
						SET 
						commercial_invoice_header.intDiscounted=0
						WHERE
						strInvoiceNo='$invoiceNo'";
						
	$result_update_comm=$db->RunQuery($sql_update_comm);
	 //echo $cboRefNo;
	  $result_update_comm;
	}
	if($result_update_comm)
		{
			 $sql_dis="SELECT DISTINCT strInvoiceNo
						FROM discount_detail
						WHERE strInvoiceNo='$invoiceNo'";
					
					$result_dis=$db->RunQuery($sql_dis);
		}
					
				while($row=mysql_fetch_array($result_dis))
	{
	 $invoiceNo=$row["strInvoiceNo"];
	
	
  $sql_ms="INSERT INTO ReceiptDetail 			(strBuyerCode,iSerialNo,dDate,fAmount,strBankCode,cType,bDiscounted,cStyleCode,cInvoiceNo,dInvoiceDate,fInvoiceAmount,fReturnAmount)
	      VALUES('$buyerId',$cboRefNo,'$txtDate',$netAmt,'$bankId','d',1,'$styleid','$invoiceNo','$invoiceDate',0,$invoiceAmt);";
		  
		$result_ms=$msdb->RunQueryMS($sql_ms);
		
		}
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
	
	/*$sql_ms="INSERT INTO export_data.receipt_detail 			(strBuyerCode,iSerialNo,dDate,fAmount,strBankCode,cType,bDiscounted,cStyleCode,cInvoiceNo,dInvoiceDate,fInvoiceAmt,fReturnAmt)
	      VALUES('$buyerId',$serialNo,'$date','$invoiceNetAmt','$bankId','d',1,'','$invoiceNo','$invoiceDate',$invoiceNetAmt,$invoiceNetAmt);";*/
		  
	$sql_ms="INSERT INTO receipt_detail 			(strBuyerCode,iSerialNo,dDate,fAmount,strBankCode,cType,bDiscounted,cStyleCode,cInvoiceNo,dInvoiceDate,fInvoiceAmount,fReturnAmount)
	      VALUES('$buyerId',$serialNo,'$date','$invoiceNetAmt','$bankId','d',1,'','$invoiceNo','$invoiceDate',$invoiceNetAmt,$invoiceNetAmt);";
	$result_ms=$msdb->RunQueryMS($sql_ms);
}


?>
