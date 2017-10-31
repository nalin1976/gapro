<?php
	session_start();
	include "../Connector.php";
	
	$DBOprType = $_GET["DBOprType"]; 
	$strPaymentType=$_GET["strPaymentType"];

	if (strcmp($DBOprType,"getSupList") == 0)
	{
			header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $ResponseXML = "";
		 $ResponseXML .= "<SupList>\n";
		
		 $result=getSupliersList();
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<supID><![CDATA[" . $row["strSupplierID"]  . "]]></supID>\n";
			$ResponseXML .= "<supName><![CDATA[" . $row["strSupName"]  . "]]></supName>\n";
		 }
		 
		 $ResponseXML .= "</SupList>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"getSupGLList") == 0)
	{
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $supID=$_GET["supID"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<GLList>\n";
		
		 $result=getSupliersGLList($supID);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<accNo><![CDATA[" . $row["strAccID"]  . "]]></accNo>\n";
			$ResponseXML .= "<accName><![CDATA[" . $row["strDescription"]  . "]]></accName>\n";
		 }
		 
		 $ResponseXML .= "</GLList>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"getBatches") == 0)
	{
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $ResponseXML = "";
		 $ResponseXML .= "<Batches>\n";
		
		 $result=getAccPackBatches();
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<batchID><![CDATA[" . $row["intBatch"]  . "]]></batchID>\n";
			$ResponseXML .= "<batchDes><![CDATA[" . $row["strDescription"]  . "]]></batchDes>\n";
		 }
		 
		 $ResponseXML .= "</Batches>";
		 echo $ResponseXML;
	}

		
	else if (strcmp($DBOprType,"getFactoryList") == 0)
	{
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $ResponseXML = "";
		 $ResponseXML .= "<Factory>\n";
		
		 $result=getFactoryList();
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<compID><![CDATA[" . $row["strComCode"]  . "]]></compID>\n";
			$ResponseXML .= "<compName><![CDATA[" . $row["strName"]  . "]]></compName>\n";
		 }
		 
		 $ResponseXML .= "</Factory>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"getGLAccountList") == 0)
	{
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $fc=$_GET["facID"];
		 $NameLike=$_GET["NameLike"];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<GLAccs>\n";

		 $result=getGLAccList($fc,$NameLike);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<accNo><![CDATA[" . $row["strAccID"]  . "]]></accNo>\n";
			$ResponseXML .= "<accDes><![CDATA[" . $row["strDescription"]  . "]]></accDes>\n";
		 }
		 
		 $ResponseXML .= "</GLAccs>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"getGRNList") == 0) //OK
	{
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $poNo=$_GET["poNo"];
		 $styleNo=$_GET["styleNo"];

		 
		 $ResponseXML = "";
		 $ResponseXML .= "<GRNList>\n";
				 
		 $result=getGRNList($poNo,$styleNo,$strPaymentType );
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<grnNo><![CDATA[" . $row["intGrnNo"]  . "]]></grnNo>\n";
			$ResponseXML .= "<description><![CDATA[" . $row["strItemDescription"]  . "]]></description>\n";
			$ResponseXML .= "<qty><![CDATA[" . $row["dblQty"]  . "]]></qty>\n";
			$ResponseXML .= "<rate><![CDATA[" . $row["dblUnitPrice"]  . "]]></rate>\n";
			$ResponseXML .= "<value><![CDATA[" . $row["dblValue"]  . "]]></value>\n";
			$ResponseXML .= "<matmainid><![CDATA[" . $row["intMainCatID"]  . "]]></matmainid>\n";
			$ResponseXML .= "<matsubid><![CDATA[" . $row["intSubCatID"]  . "]]></matsubid>\n";
			$ResponseXML .= "<matdetailid><![CDATA[" . $row["intItemSerial"]  . "]]></matdetailid>\n";
		 }
		 
		 $ResponseXML .= "</GRNList>";
		 echo $ResponseXML;
	}

	
	else if (strcmp($DBOprType,"getSupPOList") == 0) //OK
	{
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $supID=$_GET["supID"];
		
		
		 $ResponseXML = "";
		 $ResponseXML .= "<POList>\n";
				 
		 $result=getAvailableSupPO($supID,$strPaymentType);
		 
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<poNo><![CDATA[" . $row["intPONo"]  . "]]></poNo>\n";
			$ResponseXML .= "<currency><![CDATA[" . $row["strCurrency"]  . "]]></currency>\n";
			$ResponseXML .= "<currencyId><![CDATA[" . $row["intCurID"]  . "]]></currencyId>\n";
			$ResponseXML .= "<poAmount><![CDATA[" . $row["dblPOValue"]  . "]]></poAmount>\n";
			$ResponseXML .= "<poBalance><![CDATA[" . $row["dblPOBalance"]  . "]]></poBalance>\n";
			$ResponseXML .= "<payTerm><![CDATA[" . $row["payTerm"]  . "]]></payTerm>\n";
			$ResponseXML .= "<payCurrency><![CDATA[" . $row["strCurrency"]  . "]]></payCurrency>\n";
			$ResponseXML .= "<payrate><![CDATA[" . $row["rate"]  . "]]></payrate>\n";
			
		 }
		 
		 $ResponseXML .= "</POList>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"getTaxTypes") == 0)//OK
	{	
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $ResponseXML = "";
		 $ResponseXML .= "<TaxTypes>\n";
				 
		 $result=getTaxTypes();
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<taxTypeID><![CDATA[" . $row["strTaxTypeID"]  . "]]></taxTypeID>\n";
			$ResponseXML .= "<taxType><![CDATA[" . $row["strTaxType"]  . "]]></taxType>\n";
			$ResponseXML .= "<taxRate><![CDATA[" . $row["dblRate"]  . "]]></taxRate>\n";
		 }
		 $ResponseXML .= "</TaxTypes>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"getTypeOfCurrency") == 0)//OK
	{	
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $ResponseXML = "";
		 $ResponseXML .= "<CurrencyTypes>\n";
				 
		 $result=getCurrencyTypes();
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<currType><![CDATA[" . $row["strCurrency"]  . "]]></currType>\n";
			$ResponseXML .= "<currRate><![CDATA[" . $row["dblRate"]  . "]]></currRate>\n";
		 }
		 $ResponseXML .= "</CurrencyTypes>";
		 echo $ResponseXML;
	}
	else if (strcmp($DBOprType,"AdvPaymentNoTask") == 0)//OK
	{	
		
		$result=getAdvancePaymentNo($strPaymentType);

		while($row = mysql_fetch_array($result))
		{
			$text =$row["dblAdvancePayNo"] ;
		}
		echo $text;
	}
	else if (strcmp($DBOprType,"SaveAdvPayment") == 0)//OK
	{	
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		$paymentno=$_GET["paymentno"];
		$supid=$_GET["supid"];
		$description=$_GET["description"];
		$batchno=$_GET["batchno"];
		$draft=$_GET["draft"];
		$discount=$_GET["discount"];
		$frightcharge=$_GET["frightcharge"];
		$couriercharge=$_GET["couriercharge"];
		$bankcharge=$_GET["bankcharge"];
		$poamount=$_GET["poamount"];
		$taxamount=$_GET["taxamount"];
		$totalamount=$_GET["totalamount"];
		$currency=$_GET["currency"];
		$ExRate=$_GET["ExRate"];
		
		$ResponseXML = "";
		$ResponseXML .= "<AdvSave>\n";
			 
		if(SaveAdvancePayment($paymentno,$supid,$description,$batchno,$draft,$discount,$frightcharge,$couriercharge,$bankcharge,$poamount,$taxamount,$totalamount,$currency,$strPaymentType,$ExRate))
		{ 
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		}
		else
		{
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
		 
		$ResponseXML .= "</AdvSave>";
		echo $ResponseXML;
	}
	
	else if (strcmp(DBOprType,"getCType") == 0)
	{
	header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $ResponseXML = "";
		 $ResponseXML .= "<CurrencyTypes>\n";
		
		 //$sql_curType="";		 
		 $result=getCurID();
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<currType><![CDATA[" . $row["strCurrency"]  . "]]></currType>\n";
			$ResponseXML .= "<currId><![CDATA[" . $row["intCurID"]  . "]]></currId>>\n";
		 }
		 $ResponseXML .= "</CurrencyTypes>";
		 echo $ResponseXML;
		
	}
	else if (strcmp($DBOprType,"SaveAdvTax") == 0)//OK
	{	
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		$paymentno=$_GET["paymentno"];
		$tax=$_GET["tax"];
		$rate=$_GET["rate"];
		$amount=$_GET["amount"];
		
		$ResponseXML = "";
		$ResponseXML .= "<TaxSave>\n";
			 
		if(SaveTax($paymentno,$tax,$rate,$amount,$strPaymentType ))
		{ 
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		}
		else
		{
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
		 
		$ResponseXML .= "</TaxSave>";
		echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"SaveAdvGLs") == 0)//OK
	{	
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		$paymentno=$_GET["paymentno"];
		$glaccno=$_GET["glaccno"];
		$amount=$_GET["amount"];
		
		$ResponseXML = "";
		$ResponseXML .= "<TaxSave>\n";
			 
		if(SaveGLs($paymentno,$glaccno,$amount,$strPaymentType))
		{ 
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		}
		else
		{
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
		 
		$ResponseXML .= "</TaxSave>";
		echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"SaveAdvPOs") == 0)//OK
	{	
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		$paymentno=$_GET["paymentno"];
		$pono=$_GET["poNo"];
		$intPoYear=$_GET["poYear"];
		$paidamount=$_GET["paidamount"];
		
		$ResponseXML = "";
		$ResponseXML .= "<TaxSave>\n";
			 
		if(SavePOs($paymentno,$pono,$intPoYear,$paidamount,$strPaymentType))
		{ 
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		}
		else
		{
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		}
		 
		$ResponseXML .= "</TaxSave>";
		echo $ResponseXML;
	}	
	else if (strcmp($DBOprType,"getAdvacePaymentsList") == 0)//OK
	{	
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $ResponseXML = "";
		 $ResponseXML .= "<AdvacePaymentNosList>\n";
				 
		 $supid=$_GET["supid"];		 
		  
		 $result=getAdvacePaymentsList($supid,$strPaymentType);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<AdvPayNo><![CDATA[" . $row["PaymentNo"]  . "]]></AdvPayNo>\n";
		 }
		 $ResponseXML .= "</AdvacePaymentNosList>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"getAdvacePaymentsData") == 0)//OK
	{	
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $ResponseXML = "";
		 $ResponseXML .= "<AdvacePaymentNosList>\n";
				 
		 $advpayno=$_GET["advpayno"];		 
		 
		 
		 $result=getAdvacePaymentsData($advpayno,$strPaymentType);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<Payee><![CDATA[" . $row["payee"]  . "]]></Payee>\n";
			$ResponseXML .= "<PayNo><![CDATA[" . $row["PaymentNo"]  . "]]></PayNo>\n";
			$ResponseXML .= "<PayDate><![CDATA[" . $row["paydate"]  . "]]></PayDate>\n";
			$ResponseXML .= "<PayDesc><![CDATA[" . $row["description"]  . "]]></PayDesc>\n";
			$ResponseXML .= "<POAmount><![CDATA[" . $row["paidAmount"]  . "]]></POAmount>\n";
			
			$ResponseXML .= "<payTax><![CDATA[" . $row["taxamount"]  . "]]></payTax>\n";
			$ResponseXML .= "<payCharge><![CDATA[" . $row["charge"]  . "]]></payCharge>\n";
			$ResponseXML .= "<payDiscount><![CDATA[" . $row["discount"]  . "]]></payDiscount>\n";
			
			$ResponseXML .= "<payTotalAmount><![CDATA[" . $row["totalamount"]  . "]]></payTotalAmount>\n";
			
		 }
		 $ResponseXML .= "</AdvacePaymentNosList>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"getAdvacePaymentsDataGL") == 0)//OK
	{	
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $ResponseXML = "";
		 $ResponseXML .= "<GLAccs>\n";
				 
		 $advpayno=$_GET["advpayno"];		  
		 
		 $result=getAdvacePaymentsDataGL($advpayno,$strPaymentType);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<glacc><![CDATA[" . $row["strDescription"]  . "]]></glacc>\n";
			$ResponseXML .= "<accno><![CDATA[" . $row["GLAccAllowNo"]  . "]]></accno>\n";
			$ResponseXML .= "<amount><![CDATA[" . $row["Amount"]  . "]]></amount>\n";
			$ResponseXML .= "<factory><![CDATA[" . $row["strName"]  . "]]></factory>\n";
			
		 }
		 $ResponseXML .= "</GLAccs>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"findAdvData") == 0)//OK
	{	
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		 $supID=$_GET["supID"];
		 $dateFrom=$_GET["dateFrom"];
		 $dateTo=$_GET["dateTo"];	
		  
		 $ResponseXML = "";
		 $ResponseXML .= "<AdvacePaymentFind>\n";	 
		 			
		 $result=findAdvacePayment($supID,$dateFrom,$dateTo,$strPaymentType);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<PaymentNo><![CDATA[" . $row["intPaymentNo"]  . "]]></PaymentNo>\n";
			$ResponseXML .= "<paydate><![CDATA[" . $row["dtmPayDate"]  . "]]></paydate>\n";
			$ResponseXML .= "<poamount><![CDATA[" . $row["dblPoAmt"]  . "]]></poamount>\n";
			$ResponseXML .= "<taxamount><![CDATA[" . $row["dblTaxAmt"]  . "]]></taxamount>\n";
			$ResponseXML .= "<totalamount><![CDATA[" . $row["dblTotAmt"]  . "]]></totalamount>\n";
			
			
		 }
		 $ResponseXML .= "</AdvacePaymentFind>";
		 echo $ResponseXML;
	}
	else if($DBOprType=='getFacCode')
	{
		$facCode=$_GET['facCode'];
		$sql_fac="select strComCode FROM companies where intCompanyID=$facCode";
		$res_fac=$db->RunQuery($sql_fac);
		$fac_code=mysql_fetch_array($res_fac);
		echo $fac_code['strComCode'];
	}
	else if(strcmp($DBOprType,"dbloadcurr") == 0)
	{
	 header('Content-Type: text/xml'); 
	 echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
	  $curID=$_GET['curID'];
	   $ResponseXML .= "<Result>\n";
		      $sql="select DISTINCT
						 exchangerate.rate from exchangerate 
						  inner JOIN currencytypes on exchangerate.currencyID = currencytypes.intCurID
						 where currencytypes.intCurID = '$curID';";
					//echo $sql;
			$res=$db->RunQuery($sql);
			while ($row=mysql_fetch_array($res)) {
		
			$ResponseXML .= "<Exrate><![CDATA[" .  $row["rate"] . "]]></Exrate>\n";
			
			}
			$ResponseXML .= "</Result>\n";
			echo $ResponseXML;
	}
	
	else if(strcmp($DBOprType,"loadBatchAccCurr") == 0)
	{
	 header('Content-Type: text/xml'); 
     echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	 
	 $CurrencyTo = $_GET["CurrencyTo"];
	 
	 $sql = "SELECT
				batch.strDescription,
				batch.intBatch
				FROM
				batch
				Inner Join currencytypes ON batch.strCurrency = currencytypes.intCurID
				WHERE
				currencytypes.intCurID =  '$CurrencyTo' AND batch.intBatchType ='2'";
       $result =$db->RunQuery($sql);
	   $ResponseXML .= "<option selected=\"selected\" value=\"\"></option>";
	   while($row = mysql_fetch_array($result))
	   {
	   $ResponseXML .= "<option  value=".$row["intBatch"].">".$row["strDescription"]."</option>";	
	  }
      $ResponseXML .= "<loadBatchNo>";	
      echo $ResponseXML;			
	}
	

function getSupliersGLList($supID)
{
	global $db;
	$intCompany = $_SESSION["FactoryID"];		
	$strSQL = "SELECT
				glaccounts.strDescription,
				glaccounts.strAccID
				FROM
				glallocationforsupplier
				Inner Join glaccounts ON (glallocationforsupplier.strAccID = glaccounts.strAccID)
				WHERE
				glallocationforsupplier.strSupplierId =  '$supID' AND
				glaccounts.intCompany =  '$intCompany'";		
	//echo $strSQL;
	$result=$db->ExecuteQuery($strSQL);
	return $result;
	
	
}
function SaveTax($paymentno,$tax,$rate,$amount,$strPaymentType )
{
	global $db;
	$strSQL="INSERT INTO advancepaymenttax(PaymentNo,tax,rate,amount,strType) VALUES('$paymentno','$tax', '$rate','$amount', '$strPaymentType')";
	
	
	$db->ExecuteQuery($strSQL);
	return true;
}

function SaveGLs($paymentno,$glaccno,$amount,$strPaymentType)
{
	global $db;

	$strSQL="INSERT INTO advancepaymentsglallowcation(paymentNo,glAccNo,Amount,strType) VALUES('$paymentno','$glaccno','$amount', '$strPaymentType')";
	
	$db->ExecuteQuery($strSQL);
	return true;
}
function SavePOs($paymentno,$pono,$intPoYear,$paidamount,$strPaymentType)
{
	global $db;
	//$strSQL="INSERT INTO advancepaymentpos(PaymentNo,POno,intPoYear,paidAmount,strType) VALUES('$paymentno','$pono','$intPoYear','$paidamount', '$strPaymentType')";
	$strSQL="insert into advancepaymentpos(intPaymentNo,intPOno,dblpaidAmount,strType,intPoYear) values('$paymentno','$pono','$paidamount','$strPaymentType','$intPoYear');";
	
	$db->ExecuteQuery($strSQL);
	
	if($strPaymentType=="S")
	{
		$strSQL="UPDATE purchaseorderheader SET dblPOBalance=dblPOBalance-'$paidamount' WHERE intPONo='$pono' and intYear=$intPoYear";
	}
	else if($strPaymentType=="G")
	{
		$strSQL="UPDATE generalpurchaseorderheader SET dblPoBalance=dblPoBalance-'$paidamount' WHERE intGenPONo='$pono' and intYear= $intPoYear";
	}
	else if($strPaymentType=="B")
	{
		$strSQL="UPDATE bulkpurchaseorderheader SET dblPoBalance=dblPoBalance-'$paidamount' WHERE intBulkPoNo='$pono' and intYear= '$intPoYear';";
		//echo $strSQL;
	}
	$db->ExecuteQuery($strSQL);
	
	
	return true;
}
	
function SaveAdvancePayment($paymentno, $supid, $description, $batchno, $draft, $discount, $frightcharge, $couriercharge,$bankcharge,$poamount,$taxamount,$totalamount,$currency,$strPaymentType,$ExRate) //OK
{
	
	global $db;
	
	$SQL = "select intCompanyID from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$userFactory= $row["intCompanyID"];
	}
	$userID= $_SESSION["UserID"];
	
	//$paymentno = getAdvancePaymentNo($strPaymentType);

		 $strSQL="INSERT INTO advancepayment (intPaymentNo, dtmPayDate, intSupplierId, strDescription, intBatchNo, strDraftNo, dblDiscount,  dblCourierCharge,dblFreightCharge,dblBankCharge,dblPoAmt,dblTaxAmt,intCurrency,intUserId,strType,intCompanyId,dblTotAmt,dblExchangeRate) VALUES('$paymentno',now(), '$supid', '$description', '$batchno','$draft','$discount','$couriercharge','$frightcharge','$bankcharge','$poamount','$taxamount','$currency','$userID','$strPaymentType','$userFactory','$totalamount','$ExRate')";
	
	//echo $strSQL;
	   $result = $db->RunQuery($strSQL);

		return true;
}

function getAdvancePaymentNo($strPaymentType)
{
	$compCode=$_SESSION["FactoryID"];
	global $db; 
		if($strPaymentType=="S")
		{
			$strSQL			=	"SELECT dblAdvancePayNo FROM syscontrol  WHERE syscontrol.intCompanyID='$compCode'";
			$result			=	$db->RunQuery($strSQL);
			$strSQL			=	"update syscontrol set  dblAdvancePayNo= dblAdvancePayNo+1  WHERE syscontrol.intCompanyID='$compCode'";
			$result_update	=	$db->RunQuery($strSQL);
		}
		else if($strPaymentType=="G")
		{
			$strSQL			=	"SELECT dblGeneralAdvancePayNo as dblAdvancePayNo FROM syscontrol  WHERE syscontrol.intCompanyID='$compCode'";
			$result			=	$db->RunQuery($strSQL);
			$strSQL			=	"update syscontrol set  dblGeneralAdvancePayNo= dblGeneralAdvancePayNo+1  WHERE syscontrol.intCompanyID='$compCode'";	
			$result_update	=	$db->RunQuery($strSQL);
		}
		else if($strPaymentType=="B")
		{
			$strSQL			=	"SELECT dblBulkAdvancePayNo as dblAdvancePayNo FROM syscontrol  WHERE syscontrol.intCompanyID='$compCode'";
			$result			=	$db->RunQuery($strSQL);
			$strSQL			=	"update syscontrol set  dblBulkAdvancePayNo= dblBulkAdvancePayNo+1  WHERE syscontrol.intCompanyID='$compCode'";	
			$result_update	=	$db->RunQuery($strSQL);
		}
		return $result; 
}

function getAdvacePaymentsDataGL($advpayNo,$strPaymentType)
{
	global $db;
	$strSQL="SELECT glallowcation.GLAccAllowNo,  glallowcation.GLAccNo,  advancepaymentsglallowcation.Amount,  advancepaymentsglallowcation.paymentNo,  glaccounts.strFacCode,  companies.strName,glaccounts.strDescription FROM   glaccounts  INNER JOIN glallowcation ON (glaccounts.strAccID = glallowcation.GLAccNo)  INNER JOIN advancepaymentsglallowcation ON (glallowcation.GLAccAllowNo = advancepaymentsglallowcation.glAccNo)  INNER JOIN companies ON (glaccounts.strFacCode = companies.strComCode) WHERE   advancepaymentsglallowcation.paymentNo = '$advpayNo' and advancepaymentsglallowcation.strType='$strPaymentType'";
	
	
	$result=$db->RunQuery($strSQL);
	return $result; 
	
}	

function findAdvacePayment($supid,$dateFrom,$dateTo,$strPaymentType)
{
	global $db;
	if($supid=="0")
	{
		$strSQL="SELECT intPaymentNo,dtmPayDate,dblPoAmt,dblTaxAmt,dblTotAmt FROM advancepayment WHERE dtmPayDate>='$dateFrom' AND dtmPayDate<='$dateTo' and strType='$strPaymentType'  ORDER BY dtmPayDate desc";
		
		
		
	}
	else
	{
	 $strSQL="SELECT intPaymentNo,dtmPayDate,dblPoAmt,dblTaxAmt,dblTotAmt FROM advancepayment WHERE intSupplierId='$supid' AND dtmPayDate>='$dateFrom' AND dtmPayDate<='$dateTo'  and strType='$strPaymentType'  ORDER BY dtmPayDate desc";
		
	}
	$result=$db->RunQuery($strSQL);
	//echo $strSQL;
	return $result; 
}

function getAdvacePaymentsList($supid,$strPaymentType)
{
	global $db;
	
	$strSQL="SELECT PaymentNo FROM advancepayment WHERE supid='$supid' and strType='$strPaymentType' ORDER BY paydate desc";
	
	$result=$db->RunQuery($strSQL);
	return $result; 
}
function getAdvacePaymentsData($advpayno,$strPaymentType)
{
	global $db;
	$strSQL="SELECT advancepaymentpos.intPaymentNo,suppliers.strTitle as payee,  advancepayment.PaymentNo,  advancepayment.paydate,  advancepayment.description,  advancepaymentpos.intPOno,  purchaseorderheader.dblPOValue,  purchaseorderheader.dblPOBalance,  advancepaymentpos.dblpaidAmount,  advancepayment.taxamount,  advancepayment.discount,  advancepayment.totalamount,  (advancepayment.frightcharge + advancepayment.couriercharge + advancepayment.bankcharge) AS charge,  advancepayment.poamount,  advancepayment.frightcharge,  advancepayment.couriercharge,  advancepayment.bankcharge FROM advancepayment  INNER JOIN suppliers ON (advancepayment.supid = suppliers.strSupplierID)  INNER JOIN advancepaymentpos ON (advancepayment.PaymentNo = advancepaymentpos.intPaymentNo)  INNER JOIN purchaseorderheader ON (advancepaymentpos.intPOno = purchaseorderheader.intPONo) WHERE  advancepaymentpos.intPaymentNo = '$advpayno' and advancepaymentpos.strType='$strPaymentType' GROUP BY  suppliers.intCurrency,  advancepaymentpos.intPaymentNo,  suppliers.strTitle,  advancepayment.PaymentNo,  advancepayment.paydate,  advancepayment.description,  advancepaymentpos.intPONo,  purchaseorderheader.dblPOValue,  purchaseorderheader.dblPOBalance,  advancepaymentpos.dblpaidAmount,  advancepayment.taxamount,  advancepayment.discount";
		
	$result=$db->RunQuery($strSQL);
	return $result; 
}

function getCurID()
{
	global $db;
	$strSQL="SELECT intCurrency,intCurID FROM currencytypes WHERE intStatus=1";
	$result=$db->RunQuery($strSQL);
	return $result; 
}
function getCurrencyTypes()
{
	global $db;
	$strSQL="SELECT strCurrency,dblRate FROM currencytypes WHERE intStatus=1";
	$result=$db->RunQuery($strSQL);
	return $result; 
}

function getTaxTypes()
{
	global $db;
	$strSQL="SELECT strTaxTypeID,strTaxType,dblRate FROM taxtypes";
	$result=$db->RunQuery($strSQL);
	return $result; 
}

function getAvailableSupPO($SupID,$strPaymentType) //OK
{
	global $db;
    $compCode=$_SESSION["FactoryID"];
	if($strPaymentType =="S")
	{
		$strSQL="SELECT distinct
					concat(purchaseorderheader.intYear,'/',purchaseorderheader.intPONo) AS intPONo,
					purchaseorderheader.dblPOValue,
					purchaseorderheader.dblPOBalance,
					popaymentterms.strDescription AS payTerm,
					currencytypes.strCurrency,
					currencytypes.intCurID,
					exchangerate.rate
					FROM
					purchaseorderheader
					Inner Join popaymentterms ON (purchaseorderheader.strPayTerm = popaymentterms.strPayTermId)
					Inner Join suppliers ON (purchaseorderheader.strSupplierID = suppliers.strSupplierID)
					Inner Join currencytypes ON purchaseorderheader.strCurrency = currencytypes.intCurID
					Inner Join exchangerate ON currencytypes.intCurID = exchangerate.currencyID
					WHERE  purchaseorderheader.strSupplierID = '$SupID' AND    
					 purchaseorderheader.intStatus = 10 and ROUND(purchaseorderheader.dblPOBalance,2)>0
					 AND popaymentterms.intAdvance='1' AND purchaseorderheader.intInvCompID = '$compCode'";
		//echo($strSQL);
	}
	else if($strPaymentType =="G")
	{
								$strSQL = "SELECT DISTINCT
concat(generalpurchaseorderheader.intYear,'/',generalpurchaseorderheader.intGenPONo) AS intPONo,
generalpurchaseorderheader.dblPoBalance as dblPOBalance,
popaymentterms.strDescription AS payTerm,
(SELECT SUM(( generalpurchaseorderdetails.dblQty * generalpurchaseorderdetails.dblUnitPrice)) AS value  FROM generalpurchaseorderdetails WHERE generalpurchaseorderdetails.intGenPoNo=generalpurchaseorderheader.intGenPONo AND generalpurchaseorderdetails.intYear=generalpurchaseorderheader.intYear) AS dblPOValue,
currencytypes.strCurrency,
currencytypes.intCurID,
exchangerate.rate
FROM
generalpurchaseorderheader
Inner Join popaymentterms ON popaymentterms.strPayTermId = generalpurchaseorderheader.strPayTerm
Inner Join currencytypes ON currencytypes.strCurrency = generalpurchaseorderheader.strCurrency
Inner Join exchangerate ON exchangerate.currencyID = currencytypes.intCurID
WHERE  generalpurchaseorderheader.intSupplierID = '$SupID' AND     generalpurchaseorderheader.intStatus = 1 and ROUND(generalpurchaseorderheader.dblPOBalance,2)>0 AND popaymentterms.strPayTermId = 1


					";
	
	
		/*$strSQL="SELECT   generalpurchaseorderheader.intGenPONo as intPONo,  generalpurchaseorderheader.strCurrency,  generalpurchaseorderheader.dblTotalValue as dblPOValue,  generalpurchaseorderheader.dblPOBalance,  popaymentterms.strDescription AS payTerm,  suppliers.strCurrency FROM  generalpurchaseorderheader  INNER JOIN popaymentterms ON (generalpurchaseorderheader.strPayTerm = popaymentterms.strPayTermId)  INNER JOIN suppliers ON (generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID) WHERE  generalpurchaseorderheader.intSupplierID = '$SupID' AND     generalpurchaseorderheader.intStatus = 10 and generalpurchaseorderheader.dblPOBalance>0";
*/	}
	else if($strPaymentType =="B"){
					$strSQL = "SELECT distinct
			concat(bulkpurchaseorderheader.intYear,'/',bulkpurchaseorderheader.intBulkPoNo) AS intPONo,
			bulkpurchaseorderheader.strCurrency AS poCrr,
			bulkpurchaseorderheader.dblTotalValue AS dblPOValue,
			bulkpurchaseorderheader.dblPoBalance AS dblPOBalance,
			popaymentterms.strDescription AS payTerm,
			currencytypes.strCurrency,
			currencytypes.intCurID,
			exchangerate.rate
			FROM
			bulkpurchaseorderheader
			Inner Join popaymentterms ON (bulkpurchaseorderheader.strPayTerm = popaymentterms.strPayTermId)
			Inner Join suppliers ON (bulkpurchaseorderheader.strSupplierID = suppliers.strSupplierID)
			Inner Join currencytypes ON bulkpurchaseorderheader.strCurrency = currencytypes.intCurID
			Inner Join exchangerate ON currencytypes.intCurID = exchangerate.currencyID
			WHERE  bulkpurchaseorderheader.strSupplierID = '$SupID' AND     bulkpurchaseorderheader.intStatus = 1 and ROUND(bulkpurchaseorderheader.dblPOBalance,2)>0 
					AND popaymentterms.intAdvance='1'
			";
	}

	//print $strSQL;
	$result=$db->RunQuery($strSQL);
	return $result;
}

function getSupliersList() //OK
{
	global $db;
	$strSQL="SELECT strSupplierID,strTitle AS strSupName FROM suppliers WHERE intStatus=1 ORDER BY strTitle";
	
	//print($strSQL);
	
	$result=$db->RunQuery($strSQL);
	return $result;
}

function getGRNList($pono,$styleNo,$paymentType) //OK
{
	global $db;
	if($paymentType=="Style")
	{
		$strSQL="SELECT grnheader.intPoNo,grnheader.intGrnNo,grnheader.intGRNYear,grnheader.intYear,matitemlist.strItemDescription, matitemlist.intItemSerial,matitemlist.intMainCatID,matitemlist.intSubCatID,(grndetails.dblQty + grndetails.dblExcessQty) AS dblQty,purchaseorderdetails.dblUnitPrice,(purchaseorderdetails.dblUnitPrice * (grndetails.dblQty + grndetails.dblExcessQty)) AS dblValue FROM grnheader INNER JOIN grndetails ON (grnheader.intGrnNo = grndetails.intGrnNo) AND (grnheader.intGRNYear = grndetails.intGRNYear) INNER JOIN matitemlist ON (grndetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN purchaseorderdetails ON (grnheader.intYear = purchaseorderdetails.intYear) AND (grnheader.intPoNo = purchaseorderdetails.intPoNo) WHERE  grnheader.intPoNo = '$pono' AND purchaseorderdetails.intStyleId = '$styleNo'";
		
		//echo $strSQL;
	}
	else if($paymentType=="General")
	{
		
	}
	$result=$db->RunQuery($strSQL);
	return $result;
}

function UpdatePOasSetOff($pono,$style) //OK
{
	global $db;
	$strSQL="UPDATE purchaseorderheader SET intAdvancedSurrended=1 WHERE intPONo='$pono'";
	$result=$db->RunQuery($strSQL);
	return $result;
}

function getAccPackBatches()
{
	global $db;
	$strSQL="SELECT intBatch,strDescription FROM batch WHERE intBatchType=2  AND posted=0 Order By strDescription";
	$result=$db->RunQuery($strSQL);
	return $result;
}

function getFactoryList()
{
	global $db;
	$strSQL="SELECT strComCode ,strName FROM companies WHERE intStatus=1 AND intCompanyID=".$_SESSION["FactoryID"]." ORDER BY strName";
	$result=$db->RunQuery($strSQL);
	return $result;
}

function getGLAccList($facID,$NameLike)
{
	global $db;
	$strSQL="SELECT  * FROM glaccounts WHERE intCompany=".$_SESSION["FactoryID"]." and strDescription like '$NameLike%'";
	//"SELECT glallowcation.FactoryCode,glallowcation.GLAccAllowNo,glaccounts.strDescription FROM glallowcation  INNER JOIN glaccounts ON (glallowcation.GLAccNo = glaccounts.strAccID) WHERE  glallowcation.FactoryCode= '$facID'";
	//print($strSQL);
	// echo $strSQL;
	$result=$db->RunQuery($strSQL);
	return $result;
}
?>
