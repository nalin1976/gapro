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
		 $GRNNo=$_GET["GRNNo"];
		 $ResponseXML = "";
		 $ResponseXML .= "<GRNList>\n";
		
		 $GRNNo = str_replace('\\','',$GRNNo);
		// echo $GRNNo;
		 $result=getGRNDetails($GRNNo,$strPaymentType);
			
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
	
	else if (strcmp($DBOprType,"loadSchedulePO") == 0)
	{	
		 $InvoiceNo	=	$_GET["InvoiceNo"];
		 $SupID		=	$_GET["SupID"];	

		$ResponseXML = "";
		$ResponseXML .= "<SchedulePO>\n";
		$Res=getPOs($InvoiceNo,$SupID,$strPaymentType);
		while($row=mysql_fetch_array($Res)){
		$PO=$row['PONo'];
		$Year=$row['POYear'];
			$ResponseXML .= "<PONo><![CDATA[".$row['PO']."]]></PONo>";
			$ResponseXML .= "<POAmount><![CDATA[".$row['POAmount']."]]></POAmount>";
			$ResponseXML .= "<AdvanceAmount><![CDATA[".$row['AdvanceAmount']."]]></AdvanceAmount>";
			$ResponseXML .= "<PrePaid><![CDATA[".loadPrePaidAmount($PO,$Year,$InvoiceNo,$SupID)."]]></PrePaid>";
		}
		$ResponseXML .= "</SchedulePO>";
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
	if($strStyleID=='-'){
		$strStyleID=0;
	}
	global $db;
	$strSQL="INSERT INTO paymentscheduledetails (strScheduelNo, strInvoiceNo, strPONO, strPOYear, strGRNNO, strGRNYear, intStyleId, strMatId, strMatCat,strMatDetailID,strColour,strSize,dblQty,dblRate,dblSheduled,dblPaid,strType) VALUES('$scheduelNo','$strInvoiceNo','$strPONO','$strPOYear','$strGRNNO','$strGRNYear','$strStyleID',$strMatId,$strMatCat, '$strMatDetailID','$strColour','$strSize',$dblQty,$dblRate,$dblPaid,0,'$strPaymentType')";	
	$db->ExecuteQuery($strSQL);
	
	//echo $strSQL;
	
	//UPDATE INVOICE HEADER 
	$strSQLUpdate="UPDATE invoiceheader SET dblPaidAmount=dblPaidAmount+$dblPaid,dblBalance=dblBalance-$dblPaid WHERE strInvoiceNo='$strInvoiceNo' and strType='$strPaymentType'";
	$db->ExecuteQuery($strSQLUpdate);
	
	if($strPaymentType=='S'){
	//UPDATE GRN DETAILS - VALUEBALANCE
		$strSQLUpdate="UPDATE grndetails SET dblValueBalance=dblValueBalance-$dblPaid
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
		$strSQLUpdate="UPDATE gengrndetails SET dblValueBalance=dblValueBalance-$dblPaid
					  WHERE strGenGrnNo='$strGRNNO' and
							intYear='$strGRNYear' and
							intMatDetailID='$strMatDetailID'";
							
		$db->ExecuteQuery($strSQLUpdate);
		//echo $strSQLUpdate;
		return true;
	}
	else if($strPaymentType=='B'){
		$strSQLUpdate="UPDATE bulkgrndetails SET dblBalance=dblBalance-$dblPaid
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

function getGRNDetails($GRNNo,$strPaymentType)
{
	global $db;
	$strSQL = "";
	
	if($strPaymentType=="S")
	{
		/*$strSQL="SELECT   grnheader.strInvoiceNo,  grnheader.intGrnNo,  grndetails.intStyleId,  grndetails.intMatDetailID,  matitemlist.strItemDescription,  SUM(grndetails.dblQty) AS dblQty,  purchaseorderdetails.dblUnitPrice,  SUM(grndetails.dblQty * purchaseorderdetails.dblUnitPrice) AS dblAmount,  matitemlist.intMainCatID,  matitemlist.intSubCatID,  grndetails.strColor,   grndetails.strSize,grnheader.intPoNo,grnheader.intYear  AS poyear,  grnheader.intGrnNo,  grnheader.intGRNYear  AS grnyear, aa.dblSchdAmt AS dblSchdAmt FROM  grnheader  INNER JOIN grndetails ON (grnheader.intGrnNo=grndetails.intGrnNo)   AND (grnheader.intGRNYear=grndetails.intGRNYear)  INNER JOIN matitemlist ON (grndetails.intMatDetailID=matitemlist.intItemSerial)  INNER JOIN purchaseorderdetails ON (grnheader.intPoNo=purchaseorderdetails.intPoNo)   AND (grnheader.intYear=purchaseorderdetails.intYear) AND (grndetails.intMatDetailID=purchaseorderdetails.intMatDetailID)  AND (grndetails.strColor=purchaseorderdetails.strColor)  AND (grndetails.strSize=purchaseorderdetails.strSize) AND (purchaseorderdetails.strBuyerPONO=grndetails.strBuyerPONO) And (grndetails.intStyleId=purchaseorderdetails.intStyleId) LEFT OUTER JOIN (SELECT SUM(paymentscheduledetails.dblPaid) AS dblSchdAmt,strPONO,strInvoiceNo FROM paymentscheduledetails GROUP BY strPONO,strInvoiceNo) AS aa ON (grnheader.intPoNo=aa.strPONO)   AND (grnheader.strInvoiceNo=aa.strInvoiceNo) WHERE   grnheader.intGRNApproved = 1 AND  $GRNNo GROUP BY   grnheader.strInvoiceNo,  grnheader.intGrnNo,  grndetails.intStyleId,  grndetails.intMatDetailID,  matitemlist.strItemDescription,  purchaseorderdetails.dblUnitPrice,  matitemlist.intMainCatID,  matitemlist.intSubCatID,  grndetails.strColor,  grndetails.strSize,  grnheader.intPoNo,grnheader.intYear,grnheader.intGrnNo,grnheader.intGRNYear  ORDER BY grnheader.intGrnNo, matitemlist.strItemDescription";*/
		$strSQL = "SELECT
					grnheader.strInvoiceNo,
					grndetails.intGrnNo,
					grndetails.intGRNYear,
					grndetails.intStyleId,
					orders.strStyle,
					orders.strOrderNo,
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
					WHERE $GRNNo";
/*					grndetails.intGrnNo =  'xxxx' AND
					grndetails.intGRNYear =  'xxxxx' AND
					grnheader.strInvoiceNo =  'xxxxx'*/


	
	//echo $strSQL;
		
	}
	else if($strPaymentType=="G")
	{
/*		$strSQL="SELECT   gengrnheader.strInvoiceNo,gengrnheader.intYear as intGRNYear,  gengrnheader.strGenGrnNo as intGrnNo, '-' as intStyleId ,gengrndetails.intMatDetailID as intMatDetailId,  genmatitemlist.strItemDescription,  SUM(gengrndetails.dblQty) AS dblQty,  generalpurchaseorderdetails.dblUnitPrice,  SUM(gengrndetails.dblQty * generalpurchaseorderdetails.dblUnitPrice) AS dblValueBalance,  genmatitemlist.intMainCatID as intMainId,  genmatitemlist.intSubCatID as intSubId ,'-' as strColor,'-' as strSize , gengrnheader.intGenPONo as intPoNo,gengrnheader.intYear  AS poyear,  gengrnheader.strGenGrnNo as intGrnNo,  gengrnheader.intYear  AS grnyear,aa.dblSchdAmt AS dblSchdAmt FROM  gengrnheader  INNER JOIN gengrndetails ON (gengrnheader.strGenGrnNo=gengrndetails.strGenGrnNo)   AND (gengrnheader.intYear=gengrndetails.intYear)  INNER JOIN genmatitemlist ON (gengrndetails.intMatDetailID=genmatitemlist.intItemSerial)  INNER JOIN generalpurchaseorderdetails ON (gengrnheader.intGenPONo=generalpurchaseorderdetails.intGenPONo)   AND (gengrnheader.intYear=generalpurchaseorderdetails.intYear) AND (gengrndetails.intMatDetailID=generalpurchaseorderdetails.intMatDetailID) LEFT OUTER JOIN (SELECT SUM(paymentscheduledetails.dblPaid) AS dblSchdAmt,strPONO,strInvoiceNo FROM paymentscheduledetails WHERE strType='G' GROUP BY strPONO,strInvoiceNo) AS aa ON (gengrnheader.intGenPONo=aa.strPONO) AND (gengrnheader.strInvoiceNo=aa.strInvoiceNo) WHERE   gengrnheader.intGRNApproved = 1 AND $GRNNo GROUP BY   gengrnheader.strInvoiceNo, gengrnheader.strGenGrnNo,  gengrndetails.intMatDetailID,  genmatitemlist.strItemDescription,  generalpurchaseorderdetails.dblUnitPrice,  genmatitemlist.intMainCatID,  genmatitemlist.intSubCatID,  gengrnheader.intGenPONo, gengrnheader.intYear,gengrnheader.strGenGrnNo,gengrnheader.intYear  ORDER BY gengrnheader.strGenGrnNo, genmatitemlist.strItemDescription ";*/
	
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
					WHERE $GRNNo";
		//print($strSQL);
	}	
	else if($strPaymentType=="B")
		{
	
		
			$strSQL = "	SELECT
						bulkgrnheader.strInvoiceNo,
						bulkgrnheader.intYear AS intGRNYear,
						bulkgrnheader.intBulkGrnNo AS intGrnNo,
						'-' AS intStyleId,
						'-' AS strStyle,
						bulkgrndetails.intMatDetailID AS intMatDetailId,
						matitemlist.strItemDescription,
						bulkgrndetails.dblQty,
						bulkpurchaseorderdetails.dblUnitPrice,( bulkgrndetails.dblRate * bulkgrndetails.dblQty ) AS dblValueBalance,
						matitemlist.intMainCatID AS intMainId,
						matitemlist.intSubCatID AS intSubId,
						'-' AS strColor,
						'-' AS strSize,
						bulkpurchaseorderdetails.intBulkPoNo AS intPoNo,
						bulkpurchaseorderdetails.intYear AS poyear,
						bulkgrndetails.dblBalance as dblValueBalance
						FROM
						bulkgrndetails
						Inner Join bulkgrnheader ON bulkgrndetails.intBulkGrnNo = bulkgrnheader.intBulkGrnNo AND bulkgrnheader.intYear = bulkgrndetails.intYear

						Inner Join bulkpurchaseorderdetails ON bulkgrnheader.intbulkPONo = bulkpurchaseorderdetails.intBulkPoNo 

						AND bulkgrnheader.intbulkPOYear = bulkpurchaseorderdetails.intYear AND 

						bulkpurchaseorderdetails.intMatDetailID = bulkgrndetails.intMatDetailID

						Inner Join matitemlist ON matitemlist.intItemSerial = bulkgrndetails.intMatDetailID AND 

						matitemlist.intItemSerial = bulkpurchaseorderdetails.intMatDetailID

						Inner Join bulkpurchaseorderheader ON bulkpurchaseorderheader.intbulkPONo = bulkpurchaseorderdetails.intbulkPoNo AND bulkpurchaseorderheader.intYear = bulkpurchaseorderdetails.intYear
						WHERE $GRNNo";
		}
	//echo $strSQL;
	$result=$db->RunQuery($strSQL);
	return $result; 
	
}

function getPOs($invNo,$supId,$type){
	global $db;
	if($type=="S"){
	$sql="SELECT purchaseorderheader.intYear AS POYear,purchaseorderheader.intPONo AS PONo,
				concat(purchaseorderheader.intYear,'/',purchaseorderheader.intPONo) AS PO,
				purchaseorderheader.strCurrency AS strCurrency,
				purchaseorderheader.dblPOValue AS POAmount,
				purchaseorderheader.dblPOBalance AS dblPoBalance,
				sum(grndetails.dblQty * purchaseorderdetails.dblUnitPrice) as totalGrnValue,
(select dblAmount from invoiceheader where strInvoiceNo='$invNo' and invoiceheader.strSupplierId =  '$supId' and strType='$type') as invoiceAmount,
				advancepaymentpos.paidAmount as AdvanceAmount
				
				FROM
				purchaseorderheader
				Inner Join grnheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear
				Inner Join grndetails ON grndetails.intGrnNo = grnheader.intGrnNo AND grndetails.intGRNYear = grnheader.intGRNYear
				left Join purchaseorderdetails ON purchaseorderdetails.intPoNo = purchaseorderheader.intPONo 
				AND purchaseorderdetails.intYear = purchaseorderheader.intYear 
				AND purchaseorderdetails.intStyleId = grndetails.intStyleId 
				AND purchaseorderdetails.intMatDetailID = grndetails.intMatDetailID 
				AND purchaseorderdetails.strColor = grndetails.strColor 	
				AND purchaseorderdetails.strSize = grndetails.strSize 
				AND purchaseorderdetails.strBuyerPONO = grndetails.strBuyerPONO
				left join advancepaymentpos on advancepaymentpos.POno=purchaseorderheader.intPONo and advancepaymentpos.POYear =purchaseorderheader.intYear
				WHERE (grnheader.strInvoiceNo =  '$invNo') AND (grnheader.intStatus = '1') AND (purchaseorderheader.strSupplierID =  '$supId') AND (purchaseorderheader.intStatus <> '11')
				GROUP BY
				purchaseorderheader.intPONo,
				purchaseorderheader.intYear;";
				}
			else if($type=='B'){
			$sql="SELECT bulkpurchaseorderheader.intYear AS POYear,bulkpurchaseorderheader.intBulkPONo AS PONo,
				concat(bulkpurchaseorderheader.intYear,'/',bulkpurchaseorderheader.intBulkPONo) AS PO,
				bulkpurchaseorderheader.strCurrency AS strCurrency,
				bulkpurchaseorderheader.dblTotalValue AS POAmount,
				bulkpurchaseorderheader.dblPOBalance AS dblPoBalance,
				sum(bulkgrndetails.dblQty * bulkpurchaseorderdetails.dblUnitPrice) as totalGrnValue,
(select dblAmount from invoiceheader where strInvoiceNo='$invNo' and invoiceheader.strSupplierId =  '$supId' and strType='$type') as invoiceAmount,
				advancepaymentpos.paidAmount as AdvanceAmount
				
				FROM
				bulkpurchaseorderheader
				Inner Join bulkgrnheader ON bulkgrnheader.intBulkPoNo = bulkpurchaseorderheader.intBulkPONo AND bulkgrnheader.intYear = bulkpurchaseorderheader.intYear
				Inner Join bulkgrndetails ON bulkgrndetails.intBulkGrnNo = bulkgrnheader.intBulkGrnNo AND bulkgrndetails.intYear = bulkgrnheader.intYear
				left Join bulkpurchaseorderdetails ON bulkpurchaseorderdetails.intBulkPONo= bulkpurchaseorderheader.intBulkPONo 
				AND bulkpurchaseorderdetails.intYear = bulkpurchaseorderheader.intYear 
				AND bulkpurchaseorderdetails.intMatDetailId = bulkgrndetails.intMatDetailID 
				AND bulkpurchaseorderdetails.strColor = bulkgrndetails.strColor 	
				AND bulkpurchaseorderdetails.strSize = bulkgrndetails.strSize 
				left join advancepaymentpos on advancepaymentpos.POno=bulkpurchaseorderheader.intBulkPONo and advancepaymentpos.POYear =bulkpurchaseorderheader.intYear
				WHERE bulkgrnheader.strInvoiceNo =  '$invNo'  AND bulkgrnheader.intStatus = '1'  AND bulkpurchaseorderheader.strSupplierID =  '$supId' AND bulkpurchaseorderheader.intStatus <> '11'  
				GROUP BY
				bulkpurchaseorderheader.intBulkPONo,
				bulkpurchaseorderheader.intYear;";
			}
				//echo $sql;
				return $db->RunQuery($sql);
}

function loadPrePaidAmount($PONo,$Year,$invNo,$supId){
	global $db;
	$sql="SELECT
		Sum(paymentscheduledetails.dblSheduled) as PrePaid,
		paymentscheduledetails.strPONO,
		paymentscheduledetails.strPOYear
		FROM paymentscheduleheader Inner Join paymentscheduledetails ON paymentscheduleheader.strScheduelNo = paymentscheduledetails.strScheduelNo
		WHERE
		paymentscheduleheader.strSupplierId =  '$supId' AND
		paymentscheduledetails.strInvoiceNo =  '$invNo' AND
		paymentscheduledetails.strPONO =  '$PONo' AND
		paymentscheduledetails.strPOYear =  '$Year'
		GROUP BY
		paymentscheduledetails.strPONO,
		paymentscheduledetails.strPOYear;";
		//echo $sql;
	$res=$db->RunQuery($sql);
	while($row=mysql_fetch_array($res)){
		return $row['PrePaid'];
	}
}
?>