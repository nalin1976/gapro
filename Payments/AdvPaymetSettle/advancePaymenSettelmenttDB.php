<?php
session_start();
	
	include "../../Connector.php";
	$companyId  =$_SESSION["FactoryID"];
    $userId		= $_SESSION["UserID"];

	
	//$db =new DBManager();
	$DBOprType = $_GET["DBOprType"]; 
	
	if (strcmp($DBOprType,"getStyle") == 0)
	{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		  $SupID = $_GET["SupID"];
		  $type =  $_GET['type'];
		  
		 $ResponseXML = "";
		 $ResponseXML .= "<StylePOs>\n";
		if($type=="S"){ 
		 	$result=getAvailableStylePO($SupID);
		 }
		 
		 if($type=="B"){ 
		 	$result=getAvailableBulkPO($SupID);
		 }
		 
		 while($row = mysql_fetch_array($result))
		 {
		    $ResponseXML .= "<PaymentNo><![CDATA[" . $row["PaymentNo"]  . "]]></PaymentNo>\n";
			$ResponseXML .= "<intYear><![CDATA[" . $row["intYear"]  . "]]></intYear>\n";
			$ResponseXML .= "<poNo><![CDATA[" . $row["intPONo"]  . "]]></poNo>\n";
			$ResponseXML .= "<poValue><![CDATA[" . $row["dblPOValue"]  . "]]></poValue>\n";
			$ResponseXML .= "<poBalance><![CDATA[" . ($row["paidAmount"] - $row["settledAmt"])  . "]]></poBalance>\n";
			$ResponseXML .= "<poPaidAmt><![CDATA[" . $row["paidAmount"]  . "]]></poPaidAmt>\n";              
			$ResponseXML .= "<poStyle><![CDATA[" . $row["intStyleId"]  . "]]></poStyle>\n";      
			$ResponseXML .= "<settledAmt><![CDATA[" . $row["settledAmt"]  . "]]></settledAmt>\n";        
		 }
		 
		 $ResponseXML .= "</StylePOs>";
		 echo $ResponseXML;
	}

	
	else if (strcmp($DBOprType,"UpdatePOforSurrender") == 0)
	{
		 $ResponseXML = "";
		 $ResponseXML .= "<GLAccs>\n";
		 $glAccNo = $_GET["AccNo"];
		 $glAccName = $_GET["AccName"];
		 $glAccType = $_GET["AccType"];
		 $glAccFactoryCode = $_GET["FactoryCode"];
		 
		 if(saveNewGLAcc($glAccNo,$glAccName,$glAccType,$glAccFactoryCode))
		 {
			$ResponseXML .= "<Result><![CDATA[True]]></Result>\n"; 
		 }
		 else
		 {
			$ResponseXML .= "<Result><![CDATA[False]]></Result>\n"; 
		 }
		 $ResponseXML .= "</GLAccs>";
		 echo $ResponseXML;
	}

function getAvailableStylePO($SupID)
{
	global $db;

	$strSQL="	SELECT DISTINCT
				purchaseorderheader.strSupplierID,
				purchaseorderheader.intYear,
				purchaseorderheader.intPONo,
				(purchaseorderheader.dblPOValue ) AS dblPOValue,
				purchaseorderdetails.intStyleId,
				advancepaymentpos.paidAmount as paidAmount, 
				if(isnull(purchaseorderheader.dblPOSettledAmt),0,purchaseorderheader.dblPOSettledAmt) as settledAmt,
				advancepaymentpos.PaymentNo,
               (advancepaymentpos.paidAmount + if(isnull(purchaseorderheader.dblPOSettledAmt),0,purchaseorderheader.dblPOSettledAmt))AS dblPoBalance
				FROM
				purchaseorderdetails
				Inner Join purchaseorderheader ON (purchaseorderdetails.intPoNo = purchaseorderheader.intPONo) AND (purchaseorderdetails.intYear = purchaseorderheader.intYear)
				Inner Join popaymentterms ON (purchaseorderheader.strPayTerm = popaymentterms.strPayTermId)
				Left Join purchaseorderheader_excess ON purchaseorderheader.intPONo = purchaseorderheader_excess.intPONo
				Inner Join advancepaymentpos ON purchaseorderheader.intPONo = advancepaymentpos.POno
				Left Join grnheader ON purchaseorderheader.intPONo = grnheader.intPoNo AND purchaseorderheader.intYear = grnheader.intYear
				Left Join grndetails ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear
				WHERE  purchaseorderheader.strSupplierID = '$SupID' AND popaymentterms.intAdvance='1' AND intSurended != 1
				GROUP BY  purchaseorderheader.strSupplierID,
				purchaseorderheader.intYear,  
				purchaseorderheader.intPONo
				ORDER BY advancepaymentpos.PaymentNo,purchaseorderdetails.intPoNo";
	
	//print($strSQL);
	
	$result=$db->RunQuery($strSQL);
	return $result;
}

function getAvailableBulkPO($SupID){
/* $strSQL = "SELECT DISTINCT
bulkpurchaseorderheader.dblTotalValue AS dblPOValue,
advancepaymentpos.paidAmount
FROM
bulkpurchaseorderheader
Inner Join bulkpurchaseorderdetails ON bulkpurchaseorderheader.intBulkPoNo = bulkpurchaseorderdetails.intBulkPoNo AND bulkpurchaseorderheader.intYear = bulkpurchaseorderdetails.intYear
Inner Join popaymentterms ON bulkpurchaseorderheader.strPayTerm = popaymentterms.strPayTermId
Inner Join advancepaymentpos ON bulkpurchaseorderheader.intBulkPoNo = advancepaymentpos.POno
Inner Join bulkgrnheader ON bulkpurchaseorderheader.intBulkPoNo = bulkgrnheader.intBulkPoNo AND bulkpurchaseorderheader.intYear = bulkgrnheader.intBulkPoYear
Inner Join bulkgrndetails ON bulkgrnheader.intBulkGrnNo = bulkgrndetails.intBulkGrnNo AND bulkgrnheader.intYear = bulkgrndetails.intYear";*/
 global $db;
 $strSQL = "SELECT DISTINCT
				bulkpurchaseorderheader.strSupplierID,
				bulkpurchaseorderheader.intYear,
				bulkpurchaseorderheader.intBulkPoNo,
				(bulkpurchaseorderheader.dblTotalValue ) AS dblPOValue,
				0 as intStyleId,
				advancepaymentpos.paidAmount as paidAmount, 
				if(isnull(bulkpurchaseorderheader.dblPOSettledAmt),0,bulkpurchaseorderheader.dblPOSettledAmt) as settledAmt,
				advancepaymentpos.PaymentNo,
               (advancepaymentpos.paidAmount + if(isnull(bulkpurchaseorderheader.dblPOSettledAmt),0,bulkpurchaseorderheader.dblPOSettledAmt))AS dblPoBalance
				FROM
				bulkpurchaseorderdetails
				Inner Join bulkpurchaseorderheader ON (bulkpurchaseorderdetails.intBulkPoNo = bulkpurchaseorderheader.intBulkPoNo) AND (bulkpurchaseorderdetails.intYear = bulkpurchaseorderheader.intYear)
				Inner Join popaymentterms ON (bulkpurchaseorderheader.strPayTerm = popaymentterms.strPayTermId)

				
				Inner Join advancepaymentpos ON bulkpurchaseorderheader.intBulkPoNo = advancepaymentpos.POno
				Left Join bulkgrnheader ON bulkpurchaseorderheader.intBulkPoNo = bulkgrnheader.intBulkPoNo AND bulkpurchaseorderheader.intYear = bulkgrnheader.intYear
				Left Join bulkgrndetails ON bulkgrnheader.intBulkGrnNo = bulkgrndetails.intBulkGrnNo AND bulkgrnheader.intYear = bulkgrndetails.intYear
				WHERE  bulkpurchaseorderheader.strSupplierID = '$SupID' AND popaymentterms.intAdvance='1' AND intSurended != 1 AND advancepaymentpos.strType='B'
				GROUP BY  bulkpurchaseorderheader.strSupplierID,
				bulkpurchaseorderheader.intYear,  
				bulkpurchaseorderheader.intBulkPONo
				ORDER BY advancepaymentpos.PaymentNo,bulkpurchaseorderdetails.intBulkPoNo";
				$result=$db->RunQuery($strSQL);
	            return $result;
}


$RequestType = $_GET["RequestType"]; 

if($RequestType == "updateGrnDetails"){
	 $grnYear = $_GET["grnYear"];
	 $grnNo = $_GET["grnNo"];
	 $styleId = $_GET["styleId"];
	 $itemId = $_GET["itemId"];
	 $payAmt = $_GET["payAmt"];
	 $balanceAmt = $_GET["balanceAmt"];
	 $txtTotGrn = $_GET["txtTotGrn"];
	 $poNo = $_GET["poNo"];
	 $poYear = $_GET["poYear"];
	 
	  $sql_update_grnDetails = "update grndetails set dblAdvPayAmt = dblAdvPayAmt+'$payAmt',
	                                                 dblAdvBalAmt = '$balanceAmt'
							   where intGrnNo='$grnNo' AND intGRNYear = '$grnYear' and intStyleId = '$styleId' and intMatDetailID = '$itemId'";
	$res=$db->RunQuery($sql_update_grnDetails);	
	
    $sql_update_poHeader = "update purchaseorderheader set dblPOSettledAmt = dblPOSettledAmt+'$payAmt'
						   where intPONo='$poNo' AND intYear = '$poYear'";
	$res2=$db->RunQuery($sql_update_poHeader);	
	if($res == 1 && $res2 == 1){
	 echo "Saved Succesfully";
	}else{
	 echo "Saving error...";
	}					   
}

if($RequestType == "updateSurended"){
	 $poNo = $_GET["poNo"];
	 $poYear = $_GET["poYear"];
	 
    $sql_update_surended = "update purchaseorderheader set intSurended = 1
						   where intPONo='$poNo' AND intYear = '$poYear'";
	$res=$db->RunQuery($sql_update_surended);
    $sql_update_surended;
}



if($RequestType == "loadAdvPaySetGlAccNo"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$No=0;
	$ResponseXML .="<loadAdvPaySetGlAccNo>\n";
	
	$Sql="select intCompanyID,dblAdvPaySetGlAccNo from syscontrol where intCompanyID='$companyId'";
	$result =$db->RunQuery($Sql);	
	$rowcount = mysql_num_rows($result);
	
	if ($rowcount > 0)
	{	
			while($row = mysql_fetch_array($result))
			{				
				$No=$row["dblAdvPaySetGlAccNo"];
				$NextNo=$No+1;
				$sqlUpdate="UPDATE syscontrol SET dblAdvPaySetGlAccNo='$NextNo' WHERE intCompanyID='$companyId';";
				$db->executeQuery($sqlUpdate);			
				$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";		
				$ResponseXML .= "<dblAdvPaySetGlAccNo><![CDATA[".$No."]]></dblAdvPaySetGlAccNo>\n";
			}
	}
	else
	{
		$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
	}	
$ResponseXML .="</loadAdvPaySetGlAccNo>";
echo $ResponseXML;
}


if($RequestType == "saveGlAccounts"){
$dblAdvPaySetGlAccNo = $_GET["dblAdvPaySetGlAccNo"];
$paymentNo = $_GET["paymentNo"];
$txtPoNo = $_GET["txtPoNo"];
$glAccID = $_GET["glAccID"];
$supplier = $_GET["supplier"];
$glAmt = $_GET["glAmt"];

	echo $sql = "insert into tblAdvancePaySettlementGlAllocation(intAdvPaySetGlAccNo,paymentNo,intPoNo,glAccID,intCompany,intSupplier,dblAmt)
	                                                      values($dblAdvPaySetGlAccNo,$paymentNo,$txtPoNo,$glAccID,$companyId,$supplier,$glAmt)";
$res=$db->RunQuery($sql);
echo $res;	
}

if($RequestType == "loadBatchNo"){
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML .= "<loadBatchNo>";
$supplier = $_GET["supplier"];
$CurrencyTo = $_GET["CurrencyTo"];

 $sql = "SELECT DISTINCT
			batch.intBatch,
			batch.strDescription
			FROM
			suppliers
			Inner Join batch ON suppliers.strCurrency = batch.strCurrency
			WHERE
			batch.intBatchType =  '2' AND
			suppliers.strSupplierID =  '$supplier ' AND
			batch.strCurrency =  '$CurrencyTo'";
 $result =$db->RunQuery($sql);	
 $ResponseXML .= "<option selected=\"selected\" value=\"\"></option>";	
	 while($row = mysql_fetch_array($result))
	 {
	  $ResponseXML .= "<option  value=".$row["intBatch"].">".$row["strDescription"]."</option>";	
	 }
  $ResponseXML .= "<loadBatchNo>";	
  echo $ResponseXML;		
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