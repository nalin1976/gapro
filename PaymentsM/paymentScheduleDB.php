<?php
//updated from roshan 2009-10-12
	session_start();
	include "../Connector.php";
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$compCode=$_SESSION["FactoryID"];
	
	
	$DBOprType = $_GET["DBOprType"]; 
	$strPaymentType=$_GET["strPaymentType"];
	
	
	if (strcmp($DBOprType,"getTaxTypes") == 0)
	{	
		 $INVNo	=	$_GET["INVNo"];
		 $type	= 	$_GET['type'];
		 	
		 $ResponseXML = "";
		 $ResponseXML .= "<TaxTypes>\n";
				 
		 $result=getTaxTypes($INVNo,$type);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<taxType><![CDATA[" . $row["strTaxType"]  . "]]></taxType>\n";
			$ResponseXML .= "<taxRate><![CDATA[" . $row["dblRate"]  . "]]></taxRate>\n";
			$ResponseXML .= "<taxAmount><![CDATA[" . $row["dblamount"]  . "]]></taxAmount>\n";
			$ResponseXML .= "<taxInvNo><![CDATA[" . $row["strinvoiceno"]  . "]]></taxInvNo>\n";
		 }
		 $ResponseXML .= "</TaxTypes>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"getSupInvoices") == 0)//OK
	{	
		 $supID=$_GET["supID"];
		 
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<SupInvoices>\n";
				 
		 $result=getSupInvoices($supID,'', $strPaymentType);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<invoiceno><![CDATA[" . $row["strInvoiceNo"]  . "]]></invoiceno>\n";
			$ResponseXML .= "<amount><![CDATA[" . $row["dblAmount"]  . "]]></amount>\n";
			$ResponseXML .= "<grnno><![CDATA[" . $row["intGrnNo"]  . "]]></grnno>\n";
			$ResponseXML .= "<grnYear><![CDATA[" . $row["intGRNYear"]  . "]]></grnYear>\n";
			$ResponseXML .= "<totamount><![CDATA[" . $row["dblTotalAmount"]  . "]]></totamount>\n";
			$ResponseXML .= "<balance><![CDATA[" . $row["dblBalance"]  . "]]></balance>\n";
			$ResponseXML .= "<paidammount><![CDATA[" . $row["dblPaidAmount"]  . "]]></paidammount>\n";
			$ResponseXML .= "<SchdAmount><![CDATA[" . $row["dblSchAmount"]  . "]]></SchdAmount>\n";
			$ResponseXML .= "<pono><![CDATA[" . $row["intPoNo"]  . "]]></pono>\n";
		 }
		 $ResponseXML .= "</SupInvoices>";
		 echo $ResponseXML;
		 
	}
	
	else if (strcmp($DBOprType,"findSupInvoices") == 0)
	{	
		 $supID=$_GET["supID"];
		 $invNo=$_GET["invNo"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<SupInvoices>\n";
				 
		 $result=getSupInvoices($supID,$invNo,$strPaymentType);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<invoiceno><![CDATA[" . $row["strInvoiceNo"]  . "]]></invoiceno>\n";
			$ResponseXML .= "<amount><![CDATA[" . $row["dblAmount"]  . "]]></amount>\n";
			$ResponseXML .= "<grnno><![CDATA[" . $row["intGrnNo"]  . "]]></grnno>\n";
			$ResponseXML .= "<totamount><![CDATA[" . $row["dblTotalAmount"]  . "]]></totamount>\n";
			$ResponseXML .= "<balance><![CDATA[" . $row["dblBalance"]  . "]]></balance>\n";
			$ResponseXML .= "<paidammount><![CDATA[" . $row["dblPaidAmount"]  . "]]></paidammount>\n";
			$ResponseXML .= "<pono><![CDATA[" . $row["intPoNo"]  . "]]></pono>\n";
		 }
		 $ResponseXML .= "</SupInvoices>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"getGRNItemsList") == 0)
	{	
		 $supId=$_GET["supId"];
		 $strPaymentType=$_GET["strPaymentType"];
		 $invNo=$_GET["invNo"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<GRNList>\n";
		
		 $result=getGRNDetails($supId,$strPaymentType,$invNo);
			
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<invoiceno><![CDATA[" . $row["strInvoiceNo"]  . "]]></invoiceno>\n";
			$ResponseXML .= "<grnno><![CDATA[" .$row["intGRNYear"].'/'. $row["intGrnNo"]  . "]]></grnno>\n";
			$ResponseXML .= "<styleId><![CDATA[" . $row["intStyleId"]  . "]]></styleId>\n";
			$ResponseXML .= "<style><![CDATA[" . $row["strStyle"]  . "]]></style>\n";
			$ResponseXML .= "<orderNo><![CDATA[" . $row["strOrderNo"]  . "]]></orderNo>\n";
			$ResponseXML .= "<description><![CDATA[" . $row["strItemDescription"]  . "]]></description>\n";
			$ResponseXML .= "<qty><![CDATA[" . $row["dblQty"]  . "]]></qty>\n";
			$ResponseXML .= "<rate><![CDATA[" . $row["dblUnitPrice"]  . "]]></rate>\n";
			$ResponseXML .= "<dblValueBalance><![CDATA[" . $row["dblValueBalance"]  . "]]></dblValueBalance>\n";
			$ResponseXML .= "<mainID><![CDATA[" . $row["intMainId"]  . "]]></mainID>\n";
			$ResponseXML .= "<catID><![CDATA[" . $row["intSubId"]  . "]]></catID>\n";
			$ResponseXML .= "<detailID><![CDATA[" . $row["intMatDetailId"]  . "]]></detailID>\n";
			$ResponseXML .= "<color><![CDATA[" . $row["strColor"]  . "]]></color>\n";
			$ResponseXML .= "<size><![CDATA[" . $row["strSize"]  . "]]></size>\n";
			$ResponseXML .= "<intStyleId><![CDATA[" . $row["intStyleId"]  . "]]></intStyleId>\n";
			
			$ResponseXML .= "<po><![CDATA[" . $row["intPoNo"]  . "]]></po>\n";
			$ResponseXML .= "<poyear><![CDATA[" . $row["intPoYear"]  . "]]></poyear>\n";
			$ResponseXML .= "<grnyear><![CDATA[" . $row["intGRNYear"]  . "]]></grnyear>\n";
			//$ResponseXML .= "<avlschdAmt><![CDATA[" . $row["dblSchdAmt"]  . "]]></avlschdAmt>\n";
			
		 }
	
		 $ResponseXML .= "</GRNList>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"getScheduleNo") == 0)
	{	
	 	$task=$_GET["task"];
	 	
		
		$ResponseXML = "";
		$ResponseXML .= "<ScheduleNo>\n";
				 
		$result=getScheduleNo($task,$strPaymentType);
		while($row = mysql_fetch_array($result))
		{
			$ResponseXML .= "<schNo><![CDATA[" . $row["dblSPayScheduleNo"]  . "]]></schNo>\n";
 		}
		$ResponseXML .= "</ScheduleNo>";
		echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"savePaymentScheduleHeader") == 0)
	{	
		 
		 $SupID=$_GET["SupID"];
		 $dblPaid=$_GET["dblPaid"];
		 $dblBalance=$_GET["dblBalance"];
		 $strPaymentType=$_GET["strPaymentType"];
		
		$result=getScheduleNo('get',$strPaymentType);
		while($row = mysql_fetch_array($result))
		{
			 $ScheduelNo=$row["dblSPayScheduleNo"];
		}
		
		$ResponseXML = "";
		$ResponseXML .= "<ScheduleSave>\n";
		if(saveSchedualHeader($ScheduelNo,$SupID,$strPaymentType,$dblBalance,$dblPaid))
		{
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		}
		else
		{
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
		
		$ResponseXML .= "<Schedule><![CDATA[".$ScheduelNo."]]></Schedule>\n";
		$ResponseXML .= "</ScheduleSave>";
		echo $ResponseXML;	
	}
	
	else if (strcmp($DBOprType,"savePaymentScheduleDetails") == 0)
	{	
		 $scheduelNo=$_GET["scheduelNo"];
		 $InvoiceNo=$_GET["InvoiceNo"];
		 $PONO=$_GET["PONO"];
		 $POYear=$_GET["POYear"];
		 $GRNNO=$_GET["GRNNO"];
		 $GRNYear=$_GET["GRNYear"];
		 $StyleID=$_GET["StyleID"];
		 $MatId=$_GET["MatId"];
		 $MatCatId=$_GET["MatCatId"];
		 $MatDetailId=$_GET["MatDetailId"];
		 $Colour=$_GET["Colour"];
		 $Size=$_GET["Size"];
		 $Qty=$_GET["Qty"];
		 $Rate=$_GET["Rate"];
		 $PaidAmt=$_GET["PaidAmt"];
		 $SupID=$_GET["SupID"];	

		$ResponseXML = "";
		$ResponseXML .= "<ScheduleSave>\n";
		
		
		
		if(saveSchedualDetails($scheduelNo,$InvoiceNo,$PONO,$POYear,$GRNNO,$GRNYear,$StyleID,$MatId,$MatCatId,$MatDetailId,$Colour,$Size,$Qty,$Rate,$PaidAmt,$strPaymentType,$SupID))
		{
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		}
		else
		{
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
		
		$ResponseXML .= "</ScheduleSave>";
		echo $ResponseXML;
		
		
	}
	
	
function saveSchedualHeader($ScheduelNo,$SupID,$strPaymentType,$dblBalance,$dblPaid)
{
	global $db;
	$datex=date("Y-m-d");
	$UserID=$_SESSION["UserID"];
	
	$strSQL="INSERT INTO paymentscheduleheader(strScheduelNo,strSupplierId,strUserID,dtmDate,strType) VALUES('$ScheduelNo','$SupID','$UserID','$datex','$strPaymentType')";	
	//echo($strSQL);
	$db->ExecuteQuery($strSQL);

	return true;
}

function saveSchedualDetails($scheduelNo,$strInvoiceNo,$strPONO,$strPOYear,$strGRNNO,$strGRNYear,$strStyleID,$strMatId,$strMatCat,$strMatDetailID,$strColour,$strSize,$dblQty,$dblRate,$dblPaid,$strPaymentType,$SupID)
{
	//UPDATE PAYMENT SHEDULE DETAILS
	global $db;
	$strSQL="INSERT INTO paymentscheduledetails (strScheduelNo, strInvoiceNo, strPONO, strPOYear, strGRNNO, strGRNYear, intStyleId, strMatId, strMatCat,strMatDetailID,strColour,strSize,dblQty,dblRate,dblSheduled,dblPaid,strType) VALUES('$scheduelNo','$strInvoiceNo','$strPONO','$strPOYear','$strGRNNO','$strGRNYear','$strStyleID',$strMatId,$strMatCat, '$strMatDetailID','$strColour','$strSize',$dblQty,$dblRate,$dblPaid,0,'$strPaymentType')";	
	$db->ExecuteQuery($strSQL);	
	//echo $strSQL;
	
	$update_inv = "update invoiceheader set intStatus = '1' where strInvoiceNo = '$strInvoiceNo' AND strType = '$strPaymentType'";
	$db->ExecuteQuery($update_inv);	

	if($strPaymentType=='S'){
	//UPDATE GRN DETAILS - VALUEBALANCE
	$update_grn = "update grnheader set intGRNComplete = '1'
	               where intGrnNo='$strGRNNO' AND intGRNYear='$strGRNYear' AND strInvoiceNo='$strInvoiceNo'";
	$db->ExecuteQuery($update_grn);
	
		$strSQLUpdate="UPDATE grndetails SET dblValueBalance='0'
					  WHERE intGrnNo='$strGRNNO' and
							intGRNYear='$strGRNYear' and
							intStyleId='$strStyleID' and
							intMatDetailID='$strMatDetailID' and
							strColor='$strColour' and
							strSize='$strSize'";
							
		$db->ExecuteQuery($strSQLUpdate);
		return true;
	}
	#################################--lasantha--###################################### 
	else if($strPaymentType=='G'){
	
	   $update_grn = "update gengrnheader set intGRNComplete = '1'
	                  where strGenGrnNo='$strGRNNO' AND intYear='$strGRNYear' AND strInvoiceNo='$strInvoiceNo'";
	   $db->ExecuteQuery($update_grn);
	
		$strSQLUpdate="UPDATE gengrndetails SET dblValueBalance='0'
					  WHERE strGenGrnNo='$strGRNNO' and
							intYear='$strGRNYear' and
							intMatDetailID='$strMatDetailID'";
							
		$db->ExecuteQuery($strSQLUpdate);
		//echo $strSQLUpdate;
		return true;
	}
	#### 09-04-2011
	else if($strPaymentType=='B'){
	
	   $update_grn = "update bulkgrnheader set intGRNComplete = '1'
	                  where intBulkGrnNo='$strGRNNO' AND intYear='$strGRNYear' AND strInvoiceNo='$strInvoiceNo'";
	   $db->ExecuteQuery($update_grn);
	   
		$strSQLUpdate="UPDATE bulkgrndetails SET dblBalance='0'
						WHERE intBulkGrnNo='$strGRNNO' and
						intYear='$strGRNYear' and
						intMatDetailID='$strMatDetailID';";
							
		$db->ExecuteQuery($strSQLUpdate);
		//echo $strSQLUpdate;
		return true;
	}
	###################################################################################
}

function getScheduleNo($job,$strPaymentType)
{
	$compCode=$_SESSION["FactoryID"];
	
	global $db;
	

		
		if($strPaymentType=="S")
		{
			$strSQL			=	"SELECT dblSPayScheduleNo FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
			$result			=	$db->RunQuery($strSQL);
			$strSQL			=	"update syscontrol set dblSPayScheduleNo=dblSPayScheduleNo+1  WHERE syscontrol.intCompanyID='$compCode'";	
			$result_update	=	$db->RunQuery($strSQL);
		}
		else if($strPaymentType=="G")
		{
			$strSQL			=	"SELECT dblGeneralPayScheduleNo as dblSPayScheduleNo FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
			$result			=	$db->RunQuery($strSQL);
			$strSQL			=	"update syscontrol set dblGeneralPayScheduleNo=dblGeneralPayScheduleNo+1 WHERE syscontrol.intCompanyID='$compCode'";	
			$result_update	=	$db->RunQuery($strSQL);
		}
		else if($strPaymentType=="B")
		{
			$strSQL			=	"SELECT dblBulkPayScheduleNo as dblSPayScheduleNo FROM syscontrol WHERE syscontrol.intCompanyID='$compCode'";
			$result			=	$db->RunQuery($strSQL);
			$strSQL			=	"update syscontrol set dblBulkPayScheduleNo=dblBulkPayScheduleNo+1 WHERE syscontrol.intCompanyID='$compCode'";	
			$result_update	=	$db->RunQuery($strSQL);
		}
		return $result; 
	
}	

function getTaxTypes($InvNo,$type)
{
	global $db;
	//$strSQL="SELECT   invoicetaxes.strinvoiceno,  taxtypes.strTaxType,  taxtypes.dblRate,  invoicetaxes.dblamount FROM  invoicetaxes  INNER JOIN taxtypes ON (invoicetaxes.strtaxtypeid = taxtypes.strTaxTypeID)
	 //WHERE  invoicetaxes.strtype = 'S' AND   invoicetaxes.strinvoiceno = $InvNo";
	if($type=='S'){
		$strSQL = "SELECT   invoicetaxes.strinvoiceno,  taxtypes.strTaxType,  taxtypes.dblRate,  invoicetaxes.dblamount FROM 
		 invoicetaxes  INNER JOIN taxtypes ON (invoicetaxes.strtaxtypeid = taxtypes.strTaxTypeID)
		 WHERE  invoicetaxes.strtype = 'S' AND   invoicetaxes.strinvoiceno = '$InvNo'";
		$result=$db->RunQuery($strSQL);
		return $result; 
	}
	else if($type=='G'){
		$strSQL = "SELECT   invoicetaxes.strinvoiceno,  taxtypes.strTaxType,  taxtypes.dblRate,  invoicetaxes.dblamount FROM 
		 invoicetaxes  INNER JOIN taxtypes ON (invoicetaxes.strtaxtypeid = taxtypes.strTaxTypeID)
		 WHERE  invoicetaxes.strtype = 'G' AND   invoicetaxes.strinvoiceno = '$InvNo'";
		 //echo $strSQL;
		$result=$db->RunQuery($strSQL);
		return $result; 
	}
	else if($type=='B'){
		$strSQL = "SELECT   invoicetaxes.strinvoiceno,  taxtypes.strTaxType,  taxtypes.dblRate,  invoicetaxes.dblamount FROM 
		 invoicetaxes  INNER JOIN taxtypes ON (invoicetaxes.strtaxtypeid = taxtypes.strTaxTypeID)
		 WHERE  invoicetaxes.strtype = 'B' AND   invoicetaxes.strinvoiceno = '$InvNo'";
		 //echo $strSQL;
		$result=$db->RunQuery($strSQL);
		return $result; 
	}
}

function getSupInvoices($supID,$invNo,$strPaymentType)
{
	
	global $db;
	if($invNo=="")
	{
	
		if( $strPaymentType=="S")
		{
/*			$strSQL="SELECT invoiceheader.strInvoiceNo,  invoiceheader.dblAmount,  grnheader.intGrnNo
			, grnheader.intGRNYear, invoiceheader.dblTotalAmount,  invoiceheader.dblBalance,  invoiceheader.dblPaidAmount,  grnheader.intPoNo 
			FROM   invoiceheader 
			INNER JOIN grnheader ON (invoiceheader.strInvoiceNo = grnheader.strInvoiceNo)  
			INNER JOIN purchaseorderheader ON (invoiceheader.strSupplierId = purchaseorderheader.strSupplierID)  
			AND (grnheader.intPoNo = purchaseorderheader.intPONo) AND (grnheader.intYear=purchaseorderheader.intYear) 
			WHERE   invoiceheader.intStatus = '0' AND invoiceheader.strSupplierId = '$supID'  
			AND round(invoiceheader.dblBalance,2) >0 And grnheader.intStatus=1 
			AND (invoiceheader.strType = '$strPaymentType') 
			GROUP BY  invoiceheader.strInvoiceNo,  invoiceheader.dblAmount,  
			grnheader.intGrnNo,grnheader.intGRNYear,  invoiceheader.dblTotalAmount, 
			 invoiceheader.dblBalance,  invoiceheader.dblPaidAmount,  grnheader.intPoNo";*/
		
		$strSQL = "SELECT invoiceheader.strInvoiceNo,  invoiceheader.dblAmount,  'GrnNo' as intGrnNo
			, 'Year' as intGRNYear, invoiceheader.dblTotalAmount,  invoiceheader.dblBalance,  invoiceheader.dblPaidAmount,  'PoNo' as intPoNo 
			FROM   invoiceheader 
			WHERE   invoiceheader.intStatus = '0' AND invoiceheader.strSupplierId = '$supID'  
			AND round(invoiceheader.dblBalance,2) >0 
			AND (invoiceheader.strType = '$strPaymentType') 
			";
		
		
		//$strSQL="SELECT invoiceheader.strInvoiceNo,invoiceheader.dblAmount,grnheader.intGrnNo,invoiceheader.dblTotalAmount, invoiceheader.dblBalance,invoiceheader.dblPaidAmount,grnheader.intPoNo,sum(paymentscheduledetails.dblPaid) as dblSchAmountFROM invoiceheader Inner Join grnheader ON (invoiceheader.strInvoiceNo = grnheader.strInvoiceNo) Inner Join purchaseorderheader ON (invoiceheader.strSupplierId = purchaseorderheader.strSupplierID) AND (grnheader.intPoNo = purchaseorderheader.intPONo) AND (grnheader.intYear = purchaseorderheader.intYear) Inner Join paymentscheduledetails ON invoiceheader.strInvoiceNo = paymentscheduledetails.strInvoiceNo AND paymentscheduledetails.strPONO = purchaseorderheader.intPONo AND paymentscheduledetails.strPOYear = purchaseorderheader.intYear AND grnheader.intGrnNo = paymentscheduledetails.strGRNNO AND grnheader.intGRNYear = paymentscheduledetails.strGRNYear WHERE   invoiceheader.intStatus = '0' AND invoiceheader.strSupplierId = '$supID' AND invoiceheader.dblBalance>0  AND grnheader.intStatus=1 AND (invoiceheader.strType = '$strPaymentType') GROUP BY  invoiceheader.strInvoiceNo,  invoiceheader.dblAmount,  grnheader.intGrnNo,  invoiceheader.dblTotalAmount, invoiceheader.dblBalance,  invoiceheader.dblPaidAmount,  grnheader.intPoNo";
		}
		else if( $strPaymentType=="G")
		{
		
				$strSQL="SELECT invoiceheader.strInvoiceNo,invoiceheader.dblAmount,invoiceheader.dblTotalAmount,  invoiceheader.dblBalance,  invoiceheader.dblPaidAmount,gengrnheader.strGenGrnNo as intGrnNo,gengrnheader.intYear as intGRNYear,  gengrnheader.intGenPONo as intPoNo,  invoiceheader.strSupplierId FROM  invoiceheader INNER JOIN gengrnheader ON (invoiceheader.strInvoiceNo=gengrnheader.strInvoiceNo)  INNER JOIN generalpurchaseorderheader ON (invoiceheader.strSupplierId=generalpurchaseorderheader.intSupplierID)  AND (gengrnheader.intGenPONo=generalpurchaseorderheader.intGenPONo)  AND (gengrnheader.intGenPOYear=generalpurchaseorderheader.intYear) WHERE  (invoiceheader.intStatus = '0') AND (invoiceheader.strSupplierId = '$supID') And (gengrnheader.intStatus='1') AND   (invoiceheader.dblBalance > 0) AND   (invoiceheader.strType = 'G')GROUP BY invoiceheader.strInvoiceNo,invoiceheader.dblAmount,invoiceheader.dblTotalAmount, invoiceheader.dblBalance,invoiceheader.dblPaidAmount,gengrnheader.intGenPONo, gengrnheader.strGenGrnNo";

		}
		else if($strPaymentType=="B"){
		$strSQL = "SELECT invoiceheader.strInvoiceNo,  invoiceheader.dblAmount,  'GrnNo' as intGrnNo
			, 'Year' as intGRNYear, invoiceheader.dblTotalAmount,  invoiceheader.dblBalance,  invoiceheader.dblPaidAmount,  'PoNo' as intPoNo 
			FROM   invoiceheader 
			WHERE   invoiceheader.intStatus = '0' AND invoiceheader.strSupplierId = '$supID'  
			AND round(invoiceheader.dblBalance,2) >0 
			AND (invoiceheader.strType = '$strPaymentType') 
			";
		}
	}
	else
	{
		
		if( $strPaymentType=="S")
		{

			$strSQL="SELECT invoiceheader.strInvoiceNo,  invoiceheader.dblAmount,  grnheader.intGrnNo,  invoiceheader.dblTotalAmount,  invoiceheader.dblBalance,  invoiceheader.dblPaidAmount,  grnheader.intPoNo FROM   invoiceheader  INNER JOIN grnheader ON (invoiceheader.strInvoiceNo = grnheader.strInvoiceNo)  INNER JOIN purchaseorderheader ON (invoiceheader.strSupplierId = purchaseorderheader.strSupplierID)  AND (grnheader.intPoNo = purchaseorderheader.intPONo) WHERE   invoiceheader.intStatus = '0' And grnheader.intStatus=1 AND invoiceheader.strSupplierId = '$supID' AND invoiceheader.strInvoiceNo='$invNo'  AND invoiceheader.dblBalance>0  GROUP BY  invoiceheader.strInvoiceNo,  invoiceheader.dblAmount,  grnheader.intGrnNo,  invoiceheader.dblTotalAmount,  invoiceheader.dblBalance,  invoiceheader.dblPaidAmount,  grnheader.intPoNo";
			
		}
		else if($strPaymentType=="G") 
		{
		
			$strSQL="SELECT invoiceheader.strInvoiceNo,invoiceheader.dblAmount,invoiceheader.dblTotalAmount,  invoiceheader.dblBalance,  invoiceheader.dblPaidAmount,gengrnheader.strGenGrnNo as intGrnNo,  gengrnheader.intGenPONo  as intPoNo,  invoiceheader.strSupplierId FROM  invoiceheader INNER JOIN gengrnheader ON (invoiceheader.strInvoiceNo=gengrnheader.strInvoiceNo)  INNER JOIN generalpurchaseorderheader ON (invoiceheader.strSupplierId=generalpurchaseorderheader.intSupplierID)  AND (gengrnheader.intGenPONo=generalpurchaseorderheader.intGenPONo)  AND (gengrnheader.intGenPOYear=generalpurchaseorderheader.intYear) WHERE  (invoiceheader.intStatus = '0') AND (invoiceheader.strSupplierId = '$supID') And (gengrnheader.intStatus='1') AND   (invoiceheader.dblBalance > 0) And invoiceheader.strInvoiceNo='$invNo' AND   (invoiceheader.strType = 'G')GROUP BY invoiceheader.strInvoiceNo,invoiceheader.dblAmount,invoiceheader.dblTotalAmount, invoiceheader.dblBalance,invoiceheader.dblPaidAmount,gengrnheader.intGenPONo, gengrnheader.strGenGrnNo";
			
		}
		else if($strPaymentType=="B") 
		{
		
			/*$strSQL="SELECT invoiceheader.strInvoiceNo,invoiceheader.dblAmount,invoiceheader.dblTotalAmount,  invoiceheader.dblBalance,  invoiceheader.dblPaidAmount,gengrnheader.strGenGrnNo as intGrnNo,  gengrnheader.intGenPONo  as intPoNo,  invoiceheader.strSupplierId FROM  invoiceheader INNER JOIN gengrnheader ON (invoiceheader.strInvoiceNo=gengrnheader.strInvoiceNo)  INNER JOIN generalpurchaseorderheader ON (invoiceheader.strSupplierId=generalpurchaseorderheader.intSupplierID)  AND (gengrnheader.intGenPONo=generalpurchaseorderheader.intGenPONo)  AND (gengrnheader.intGenPOYear=generalpurchaseorderheader.intYear) WHERE  (invoiceheader.intStatus = '0') AND (invoiceheader.strSupplierId = '$supID') And (gengrnheader.intStatus='1') AND   (invoiceheader.dblBalance > 0) And invoiceheader.strInvoiceNo='$invNo' AND   (invoiceheader.strType = 'G')GROUP BY invoiceheader.strInvoiceNo,invoiceheader.dblAmount,invoiceheader.dblTotalAmount, invoiceheader.dblBalance,invoiceheader.dblPaidAmount,gengrnheader.intGenPONo, gengrnheader.strGenGrnNo";*/
			
		}
	}
	//echo $strSQL;
	$result=$db->RunQuery($strSQL);
	return $result; 
	
}

function getGRNDetails($supId,$strPaymentType,$invNo)
{
	global $db;
	$strSQL = "";
	
	if($strPaymentType=="S")
	{
		$strSQL = "SELECT
					grnheader.strInvoiceNo,
					grndetails.intGrnNo,
					grndetails.intGRNYear,
					grndetails.intStyleId,
					orders.strStyle,
					orders.strOrderNo,
					orders.intStyleId,
					matitemlist.strItemDescription,
					grndetails.dblValueBalance,
					purchaseorderdetails.dblUnitPrice as dblUnitPrice,
					purchaseorderdetails.intPoNo as intPoNo,
					purchaseorderdetails.intYear as intPoYear,
					grndetails.intMatDetailID as intMatDetailId,
					matitemlist.intMainCatID as intMainId,
					matitemlist.intSubCatID as intSubId,
					grndetails.strColor as strColor,
					grndetails.strSize as strSize,
					grndetails.dblQty as dblQty
					
					FROM
					grndetails
					Inner Join grnheader ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear
					Inner Join matitemlist ON matitemlist.intItemSerial = grndetails.intMatDetailID
					Inner Join purchaseorderdetails ON purchaseorderdetails.intPoNo = grnheader.intPoNo AND purchaseorderdetails.intYear = grnheader.intYear AND purchaseorderdetails.intStyleId = grndetails.intStyleId AND purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID AND purchaseorderdetails.strColor = grndetails.strColor AND purchaseorderdetails.strSize = grndetails.strSize AND grndetails.strBuyerPONO = purchaseorderdetails.strBuyerPONO
					Inner Join purchaseorderheader ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear AND purchaseorderheader.intPONo = grnheader.intPoNo AND purchaseorderheader.intYear = grnheader.intYear
					Inner Join orders ON orders.intStyleId=grndetails.intStyleId
					WHERE 
					grnheader.strInvoiceNo =  '$invNo' AND
				    purchaseorderheader.strSupplierID = '$supId'";


	
	//echo $strSQL;
		
	}
	else if($strPaymentType=="G")
	{
	
		$strSQL = "	SELECT
					gengrnheader.strInvoiceNo,
					gengrnheader.intYear AS intGRNYear,
					gengrnheader.strGenGrnNo AS intGrnNo,
					'-' AS intStyleId,
					gengrndetails.intMatDetailID AS intMatDetailId,
					genmatitemlist.strItemDescription,
					gengrndetails.dblQty,
					generalpurchaseorderdetails.dblUnitPrice,
					(gengrndetails.dblRate*gengrndetails.dblQty) AS dblValueBalance,
					genmatitemlist.intMainCatID AS intMainId,
					genmatitemlist.intSubCatID AS intSubId,
					'-' AS strColor,
					'-' AS strSize,
					generalpurchaseorderdetails.intGenPoNo AS intPoNo,
					generalpurchaseorderdetails.intYear AS poyear,
					gengrndetails.dblValueBalance as dblValueBalance
					FROM
					gengrndetails
					Inner Join gengrnheader ON gengrndetails.strGenGrnNo = gengrnheader.strGenGrnNo AND gengrnheader.intYear = gengrndetails.intYear
					Inner Join generalpurchaseorderdetails ON gengrnheader.intGenPONo = generalpurchaseorderdetails.intGenPoNo 
					AND gengrnheader.intGenPOYear = generalpurchaseorderdetails.intYear AND 
					generalpurchaseorderdetails.intMatDetailID = gengrndetails.intMatDetailID
					Inner Join genmatitemlist ON genmatitemlist.intItemSerial = gengrndetails.intMatDetailID AND 
					genmatitemlist.intItemSerial = generalpurchaseorderdetails.intMatDetailID
					Inner Join generalpurchaseorderheader ON generalpurchaseorderheader.intGenPONo = generalpurchaseorderdetails.intGenPoNo AND generalpurchaseorderheader.intYear = generalpurchaseorderdetails.intYear
					WHERE 
					gengrnheader.strInvoiceNo = '$invNo' AND generalpurchaseorderheader.intSupplierID =  '$supId'";
		//print($strSQL);
	}	
	else if($strPaymentType=="B")
		{
			$strSQL = "	SELECT
						bulkgrnheader.strInvoiceNo,
						bulkgrnheader.intYear AS intGRNYear,
						bulkgrnheader.intBulkGrnNo AS intGrnNo,
						'-' AS intStyleId,
						bulkgrndetails.intMatDetailID AS intMatDetailId,
						matitemlist.strItemDescription,
						bulkgrndetails.dblQty,
						bulkpurchaseorderdetails.dblUnitPrice,
						( bulkgrndetails.dblRate * bulkgrndetails.dblQty ) AS dblValueBalance,
						matitemlist.intMainCatID AS intMainId,
						matitemlist.intSubCatID AS intSubId,
						'-' AS strColor,
						'-' AS strSize,
						bulkpurchaseorderdetails.intBulkPoNo AS intPoNo,
						bulkpurchaseorderdetails.intYear AS poyear,
						bulkgrndetails.strColor,
						bulkpurchaseorderdetails.strColor,
						bulkgrndetails.strSize,
						bulkpurchaseorderdetails.strSize
						FROM
						bulkgrndetails
						Left Join bulkgrnheader ON bulkgrndetails.intBulkGrnNo = bulkgrnheader.intBulkGrnNo AND bulkgrnheader.intYear = bulkgrndetails.intYear
						Left Join bulkpurchaseorderdetails ON bulkgrnheader.intBulkPoNo = bulkpurchaseorderdetails.intBulkPoNo AND bulkgrnheader.intBulkPoYear = bulkpurchaseorderdetails.intYear AND bulkpurchaseorderdetails.intMatDetailId = bulkgrndetails.intMatDetailID AND bulkgrndetails.strSize = bulkpurchaseorderdetails.strSize
						Left Join matitemlist ON matitemlist.intItemSerial = bulkgrndetails.intMatDetailID AND matitemlist.intItemSerial = bulkpurchaseorderdetails.intMatDetailId
						Left Join bulkpurchaseorderheader ON bulkpurchaseorderheader.intBulkPoNo = bulkpurchaseorderdetails.intBulkPoNo AND bulkpurchaseorderheader.intYear = bulkpurchaseorderdetails.intYear
						WHERE bulkgrnheader.strInvoiceNo = '$invNo' AND bulkpurchaseorderheader.strSupplierID =  '$supId'
						group by bulkgrndetails.strColor,bulkgrndetails.strSize,bulkgrndetails.intMatDetailID,bulkgrnheader.intBulkGrnNo";
		}
	//echo $strSQL;
	$result=$db->RunQuery($strSQL);
	return $result; 
	
}


?>