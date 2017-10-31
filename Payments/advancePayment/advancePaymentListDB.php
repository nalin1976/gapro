<?php 
session_start();
	include "../../Connector.php";
	$DBOprType = $_GET["DBOprType"]; 
	$strPaymentType=$_GET["strPaymentType"];
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	if (strcmp($DBOprType,"findAdvData") == 0)//OK
	{	
					
		 $supID=$_GET["supID"];
		 $dateFrom=$_GET["dateFrom"];
		 $dateTo=$_GET["dateTo"];	
		 $poNo=$_GET['poNo'];
		 $poYear=$_GET['poYear'];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<AdvacePaymentFind>\n";	 
		 	
		 $result=findAdvacePayment($supID,$dateFrom,$dateTo,$strPaymentType,$poNo,$poYear);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<PaymentNo><![CDATA[" . $row["PaymentNo"]  . "]]></PaymentNo>\n";
			$ResponseXML .= "<paydate><![CDATA[" . $row["paydate"]  . "]]></paydate>\n";
			$ResponseXML .= "<poamount><![CDATA[" . number_format($row["poamount"],2)  . "]]></poamount>\n";
			$ResponseXML .= "<taxamount><![CDATA[" . number_format($row["taxamount"],2)  . "]]></taxamount>\n";
			$ResponseXML .= "<totalamount><![CDATA[" . number_format($row["totalamount"],2)  . "]]></totalamount>\n";
			/*$ResponseXML .= "<POno><![CDATA[" . $row["POno"]  . "]]></POno>\n";
			$ResponseXML .= "<POYear><![CDATA[" . $row["POYear"]  . "]]></POYear>\n";*/
		
		 }
		 $ResponseXML .= "</AdvacePaymentFind>";
		 echo $ResponseXML;
	}
	
	function findAdvacePayment($supid,$dateFrom,$dateTo,$strPaymentType,$poNo,$poYear)
	{
		global $db;
	
			$strSQL=" SELECT  distinct advancepayment.PaymentNo, advancepayment.paydate,advancepayment.poamount,advancepayment.taxamount,
			advancepayment.totalamount
			FROM advancepayment 
			inner join advancepaymentpos on advancepaymentpos.PaymentNo=advancepayment.PaymentNo
			WHERE advancepayment.strType='$strPaymentType' ";
			if(!empty($supid)){
				$strSQL.=" and advancepayment.supid='$supid'";
			}
			if(!empty($dateFrom) && !empty($dateTo)){
				$strSQL.=" and advancepayment.paydate>='$dateFrom'  and advancepayment.paydate<='$dateTo'" ;
			}
			if(!empty($poNo) && !empty($poYear)){
				$strSQL.=" and advancepaymentpos.POno='$poNo'  and advancepaymentpos.POYear='$poYear'";
			}
			$strSQL.=" ORDER BY advancepayment.paydate desc";
	
		$result=$db->RunQuery($strSQL);
		//echo $strSQL;
		return $result; 
	}
?>