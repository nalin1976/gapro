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
			$ResponseXML .= "<facId><![CDATA[" . $row["ACCID"]  . "]]></facId>\n";
			$ResponseXML .= "<facAccId><![CDATA[" . $row["strAccountNo"]  . "]]></facAccId>\n";
			
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
			$ResponseXML .= "<GLAccID><![CDATA[" . $row["GLAccAllowNo"]  . "]]></GLAccID>\n";
			$ResponseXML .= "<accDes><![CDATA[" . $row["strDescription"]  . "]]></accDes>\n";
			$ResponseXML .= "<AccountNo><![CDATA[" . $row["strCode"]  . "]]></AccountNo>\n";
			
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
			
		 $supID	=	$_GET["supID"];
		 $bCrr	=	$_GET['bCrr'];
		 $batchId	=	$_GET['batchId'];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<POList>\n";
				 
		 $result=getAvailableSupPO($supID,$strPaymentType,$bCrr,$batchId);
		 
		 while($row = mysql_fetch_array($result))
		 {
		 $currency="";
			 if($bCrr=='0'){
				$currency=$row["poCrr"];
			 }
			 else
			 {
			 	$currency=$bCrr;
			 }
			$ResponseXML .= "<poNo><![CDATA[" . $row["intPONo"]  . "]]></poNo>\n";
			$ResponseXML .= "<currency><![CDATA[" . getCurrency($row["poCrr"])  . "]]></currency>\n";
			$ResponseXML .= "<poAmount><![CDATA[" . $row["dblPOValue"]  . "]]></poAmount>\n";
			$ResponseXML .= "<poBalance><![CDATA[" . $row["dblPOBalance"]  . "]]></poBalance>\n";
			$ResponseXML .= "<payTerm><![CDATA[" . $row["payTerm"]  . "]]></payTerm>\n";
			$ResponseXML .= "<payCurrency><![CDATA[" . $row["strCurrency"] . "]]></payCurrency>\n";
			
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
	if(strcmp($DBOprType,"saveCharges")== 0)
	{
		$payNo	=	$_GET['payNo'];
		$glId	=	$_GET['glId'];
		$amount	=	$_GET['amount'];
		$tbl	=	$_GET['tbl'];
		$type	=	$_GET['strPaymentType'];
		$supId	=	$_GET['supId'];
		$sql="insert into `$tbl`(strAdvancePayNo,intSupplierId,dtmDate,intAccID,dblAmount,strType) values('$payNo','$supId',now(),'$glId','$amount','$type');";
		$ResponseXML .= "<Result>\n";
		
		
			$ResponseXML .= "<RES><![CDATA[" . saveCharges($sql)  . "]]></RES>\n";
	
		$ResponseXML .= "</Result>";
		echo $ResponseXML;
	}
	elseif(strcmp($DBOprType,"setTaxTypes") == 0){
	
		$supID=$_GET["supID"];
		header('Content-Type: text/xml'); 
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
		$ResponseXML = "";
		$ResponseXML .= "<supTaxType>\n";
	 	$res=getSuptax($supID);
		while($rowT = mysql_fetch_array($res)){
			$ResponseXML .= "<suptax><![CDATA[" . $rowT["strTaxTypeID"]  . "]]></suptax>\n";
		}
		$ResponseXML .= "</supTaxType>";
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
		$exRate=$_GET["exRate"];
		$entryNo=$_GET["entryNo"];
		$lineNo	=$_GET['lineNo'];
		$ResponseXML = "";
		$ResponseXML .= "<AdvSave>\n";
			 
		if(SaveAdvancePayment($paymentno,$supid,$description,$batchno,$draft,$discount,$frightcharge,$couriercharge,$bankcharge,$poamount,$taxamount,$totalamount,$currency,$strPaymentType,$exRate,$entryNo,$lineNo))
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
		 $poNo=$_GET['poNo'];
		 $poYear=$_GET['poYear'];
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<AdvacePaymentFind>\n";	 
		 			
		 $result=findAdvacePayment($supID,$dateFrom,$dateTo,$strPaymentType,$poNo,$poYear);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<PaymentNo><![CDATA[" . $row["PaymentNo"]  . "]]></PaymentNo>\n";
			$ResponseXML .= "<paydate><![CDATA[" . $row["paydate"]  . "]]></paydate>\n";
			$ResponseXML .= "<poamount><![CDATA[" . $row["poamount"]  . "]]></poamount>\n";
			$ResponseXML .= "<taxamount><![CDATA[" . $row["taxamount"]  . "]]></taxamount>\n";
			$ResponseXML .= "<totalamount><![CDATA[" . $row["totalamount"]  . "]]></totalamount>\n";
			$ResponseXML .= "<POno><![CDATA[" . $row["POno"]  . "]]></POno>\n";
			$ResponseXML .= "<POYear><![CDATA[" . $row["POYear"]  . "]]></POYear>\n";
		
		 }
		 $ResponseXML .= "</AdvacePaymentFind>";
		 echo $ResponseXML;
	}
	else if(strcmp($DBOprType,"getExchangeRate")==0){
		header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		 $batchId = $_GET['batchId'];
		 $ResponseXML = "";
		 $ResponseXML .= "<ExchangeRate>\n";
		 $res=getExchangeRate($batchId);
		 while($row=mysql_fetch_array($res)){
		 	$ResponseXML .= "<Currency><![CDATA[" . $row["strCurrency"]  . "]]></Currency>";
			$ResponseXML .= "<CurrencyId><![CDATA[" . $row["CId"]  . "]]></CurrencyId>";
			$ResponseXML .= "<Rate><![CDATA[" . $row["rate"]  . "]]></Rate>";
			$ResponseXML .= "<EntryNo><![CDATA[" . getEntryNo($batchId) . "]]></EntryNo>";
		 }	
		 $ResponseXML .= "</ExchangeRate>";
		 echo $ResponseXML;
	}
	else if(strcmp($DBOprType,"getSupCurrency")==0){
			header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		 $supId = $_GET['supId'];
		 $ResponseXML = "";
		 $ResponseXML .= "<Currency>\n";
		 $res= getSupCurrency($supId);
		 while($row=mysql_fetch_array($res)){
			 $ResponseXML .= "<CurrencyId><![CDATA[" . $row['strCurrency']  . "]]></CurrencyId>";
			 $ResponseXML .= "<rate><![CDATA[" . $row['rate']  . "]]></rate>";
		 }
		 $ResponseXML .= "</Currency>";
		 echo $ResponseXML;
	}

function getSupCurrency($supId){
	global $db;
	$sql="select suppliers.strCurrency,exchangerate.rate from suppliers 
inner join exchangerate on exchangerate.currencyID=suppliers.strCurrency
 where ";
 if($supId!=0){
 	$sql.="suppliers.strSupplierID='$supId' and ";
 }
 $sql.="exchangerate.intStatus='1';";
 //echo $sql;
	$res=$db->RunQuery($sql);
	
	return $res;
}
function getEntryNo($batchId){
	global $db;
	$sql="select max(intEntryNo) EntryNo from batch where intBatch='$batchId';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['EntryNo']+1;
}

function getSupliersGLList($supID)
{
	global $db;
	$strSQL="SELECT
			gla.FactoryCode,
			gl.strDescription,
			c.strAccountNo,
			gls.strAccID as ACCID,
			gl.strAccID
			from glallocationforsupplier gls 
			Inner Join glallowcation AS gla ON gla.GLAccAllowNo = gls.strAccID
			Inner Join glaccounts AS gl ON gl.intGLAccID = gla.GLAccNo
			Inner Join companies AS c ON c.intCompanyID = gla.FactoryCode
			where gls.strSupplierId='$supID' and gl.intStatus='1' GROUP BY
			gl.strFacCode,gl.strDescription order by gl.strDescription ";
	$result=$db->ExecuteQuery($strSQL);
	return $result;
	
	
}

function getSuptax($supID){
	global $db;
	$strSQL="select strTaxTypeID from suppliers  where strSupplierID='$supID'";
	$res=$db->ExecuteQuery($strSQL);
	return $res;
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
	$strSQL="insert into advancepaymentpos(PaymentNo,POno,POYear,paidAmount,strType) values('$paymentno','$pono','$intPoYear','$paidamount','$strPaymentType');";
	//echo $strSQL;
	$db->ExecuteQuery($strSQL);
	
	if($strPaymentType=="S")
	{
		$strSQL="UPDATE purchaseorderheader SET dblPOBalance=dblPOBalance-'$paidamount' WHERE intPONo='$pono' and intYear='$intPoYear'";
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
	
function SaveAdvancePayment($paymentno, $supid, $description, $batchno, $draft, $discount, $frightcharge, $couriercharge,$bankcharge,$poamount,$taxamount,$totalamount,$currency,$strPaymentType,$exRate,$entryNo,$lineNo) //OK
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

		$strSQL="INSERT INTO advancepayment (PaymentNo, paydate, supid, description, batchno, draftno, discount, frightcharge, couriercharge,bankcharge,poamount,taxamount,totalamount,currency,userID,strType,userFactory,dblexRate,intEntryNo,intLineNo) VALUES('$paymentno',now(), '$supid', '$description', '$batchno','$draft','$discount','$frightcharge','$couriercharge','$bankcharge','$poamount','$taxamount','$totalamount','$currency','$userID','$strPaymentType','$userFactory','$exRate','$entryNo','$lineNo')";
	
	//echo $strSQL;
	$result = $db->ExecuteQuery($strSQL);
	$sqlUpBatch="update batch set intUsed='1' where intBatch='$batchno';";
	$db->RunQuery($sqlUpBatch);
	
	$strSQLE="UPDATE batch SET intEntryNo='$entryNo' WHERE intBatch='$batchno';";
	$db->RunQuery($strSQLE);
	
	if($result>0)
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

function findAdvacePayment($supid,$dateFrom,$dateTo,$strPaymentType,$poNo,$poYear)
{
	global $db;

		$strSQL="SELECT advancepayment.PaymentNo,advancepayment.paydate,advancepayment.poamount,advancepayment.taxamount,advancepayment.totalamount,
		advancepaymentpos.POno,advancepaymentpos.POYear 
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
	$strSQL="SELECT advancepaymentpos.PaymentNo,suppliers.strTitle as payee,  advancepayment.PaymentNo,  advancepayment.paydate,  advancepayment.description,  advancepaymentpos.POno,  purchaseorderheader.dblPOValue,  purchaseorderheader.dblPOBalance,  advancepaymentpos.paidAmount,  advancepayment.taxamount,  advancepayment.discount,  advancepayment.totalamount,  (advancepayment.frightcharge + advancepayment.couriercharge + advancepayment.bankcharge) AS charge,  advancepayment.poamount,  advancepayment.frightcharge,  advancepayment.couriercharge,  advancepayment.bankcharge FROM advancepayment  INNER JOIN suppliers ON (advancepayment.supid = suppliers.strSupplierID)  INNER JOIN advancepaymentpos ON (advancepayment.PaymentNo = advancepaymentpos.PaymentNo)  INNER JOIN purchaseorderheader ON (advancepaymentpos.POno = purchaseorderheader.intPONo) WHERE  advancepaymentpos.PaymentNo = '$advpayno' and advancepaymentpos.strType='$strPaymentType' GROUP BY  suppliers.strCurrency,  advancepaymentpos.PaymentNo,  suppliers.strTitle,  advancepayment.PaymentNo,  advancepayment.paydate,  advancepayment.description,  advancepaymentpos.POno,  purchaseorderheader.dblPOValue,  purchaseorderheader.dblPOBalance,  advancepaymentpos.paidAmount,  advancepayment.taxamount,  advancepayment.discount";
		
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
	$strSQL="SELECT strTaxTypeID,strTaxType,dblRate FROM taxtypes where intStatus='1' order by strTaxType";
	$result=$db->RunQuery($strSQL);
	return $result; 
}

function getAvailableSupPO($SupID,$strPaymentType,$bCrr,$batchId) //OK
{
	global $db;

	if($strPaymentType =="S")
	{
		$strSQL="SELECT   concat(purchaseorderheader.intYear,'/',purchaseorderheader.intPONo)as intPONo,  purchaseorderheader.strCurrency poCrr,  purchaseorderheader.dblPOValue, 		purchaseorderheader.dblPOBalance,  popaymentterms.strDescription AS payTerm,  suppliers.strCurrency FROM  purchaseorderheader  INNER JOIN popaymentterms ON (purchaseorderheader.strPayTerm = popaymentterms.strPayTermId)  INNER JOIN suppliers ON (purchaseorderheader.strSupplierID = suppliers.strSupplierID) WHERE  purchaseorderheader.strSupplierID = '$SupID' AND     purchaseorderheader.intStatus = 10 and ROUND(purchaseorderheader.dblPOBalance,2)>0 
		AND popaymentterms.intAdvance='1'";
		if($batchId!="0"){
			$strSQL.=" and purchaseorderheader.strCurrency='$bCrr'";
		}
		//echo($strSQL);
	}
	else if($strPaymentType =="G")
	{
		$strSQL = "	SELECT
					concat(generalpurchaseorderheader.intYear,'/',generalpurchaseorderheader.intGenPONo) AS intPONo,
					generalpurchaseorderheader.strCurrency,
					generalpurchaseorderheader.dblPOBalance,
					popaymentterms.strDescription AS payTerm,
					suppliers.strCurrency,
					Sum((generalpurchaseorderdetails.dblQty * generalpurchaseorderdetails.dblUnitPrice)) AS dblPOValue
					
					FROM
					generalpurchaseorderheader
					Inner Join popaymentterms ON (generalpurchaseorderheader.strPayTerm = popaymentterms.strPayTermId)
					Inner Join suppliers ON (generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID)
					Inner Join generalpurchaseorderdetails ON generalpurchaseorderdetails.intGenPoNo = generalpurchaseorderheader.intGenPONo AND generalpurchaseorderdetails.intYear = generalpurchaseorderheader.intYear
					WHERE  generalpurchaseorderheader.intSupplierID = '$SupID' AND     generalpurchaseorderheader.intStatus = 1 and ROUND(generalpurchaseorderheader.dblPOBalance,2)>0 AND popaymentterms.intAdvance='1'
					GROUP BY
					generalpurchaseorderdetails.intGenPoNo
					";
	
	
		/*$strSQL="SELECT   generalpurchaseorderheader.intGenPONo as intPONo,  generalpurchaseorderheader.strCurrency,  generalpurchaseorderheader.dblTotalValue as dblPOValue,  generalpurchaseorderheader.dblPOBalance,  popaymentterms.strDescription AS payTerm,  suppliers.strCurrency FROM  generalpurchaseorderheader  INNER JOIN popaymentterms ON (generalpurchaseorderheader.strPayTerm = popaymentterms.strPayTermId)  INNER JOIN suppliers ON (generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID) WHERE  generalpurchaseorderheader.intSupplierID = '$SupID' AND     generalpurchaseorderheader.intStatus = 10 and generalpurchaseorderheader.dblPOBalance>0";
*/	}

	else if($strPaymentType =="B")
	{
		$strSQL = "SELECT   concat(bulkpurchaseorderheader.intYear,'/',bulkpurchaseorderheader.intBulkPoNo)as intPONo,  bulkpurchaseorderheader.strCurrency poCrr,  
bulkpurchaseorderheader.dblTotalValue as dblPOValue,bulkpurchaseorderheader.dblPoBalance as dblPOBalance,  popaymentterms.strDescription AS payTerm,  suppliers.strCurrency FROM  bulkpurchaseorderheader  INNER JOIN popaymentterms ON (bulkpurchaseorderheader.strPayTerm = popaymentterms.strPayTermId)  
INNER JOIN suppliers ON (bulkpurchaseorderheader.strSupplierID = suppliers.strSupplierID) 
WHERE  bulkpurchaseorderheader.strSupplierID = '$SupID' AND     bulkpurchaseorderheader.intStatus = 1 and ROUND(bulkpurchaseorderheader.dblPOBalance,2)>0 
		AND popaymentterms.intAdvance='1'";
		if($batchId!="0"){
			$strSQL.=" and bulkpurchaseorderheader.strCurrency='$bCrr'";
		}
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
    $strSQL="SELECT strComCode ,strName FROM companies WHERE intStatus=1 ORDER BY strName";
	$result=$db->RunQuery($strSQL);
	return $result;
}

function getGLAccList($facID,$NameLike)
{
	global $db;
    $strSQL="SELECT  * FROM glaccounts WHERE strFacCode='$facID' and strDescription like '$NameLike%'";

	//echo $strSQL;
	//"SELECT glallowcation.FactoryCode,glallowcation.GLAccAllowNo,glaccounts.strDescription FROM glallowcation  INNER JOIN glaccounts ON (glallowcation.GLAccNo = glaccounts.strAccID) WHERE  glallowcation.FactoryCode= '$facID'";
	//print($strSQL);
	//echo $strSQL;
	$result=$db->RunQuery($strSQL);
	return $result;
}
function getCurrency($cr){
	global $db;
	$sqlC="SELECT strCurrency FROM currencytypes WHERE intCurID ='$cr';";
	$res=$db->RunQuery($sqlC);
	while($rowC=mysql_fetch_array($res)){
		return $rowC['strCurrency'];
	}
}

function getExchangeRate($batch){
global $db;
$sql="select ex.rate,b.strCurrency CId,ct.strCurrency from exchangerate ex 
	inner join batch b on b.strCurrency=ex.currencyID 
	inner join currencytypes ct on ct.intCurID= b.strCurrency
	where ex.intStatus='1' and b.intBatch='$batch'";
	
$res=$db->RunQuery($sql);
return $res;
}

function saveCharges($sql)
{
	global $db;	
	return $db->RunQuery($sql);
}
if($DBOprType=="load_GLID")
{
	$sql = "select distinct concat(gl.strAccID,c.strCode) as glCode from  glallowcation gla 
			inner join glaccounts gl on gl.intGLAccID=gla.GLAccNo
			inner join costcenters c on c.intCostCenterId = gla.FactoryCode
			order by glCode; ";
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
			{
				$pr_arr.= $row['glCode']."|";
				 
			}
			echo $pr_arr;
	
}
?>