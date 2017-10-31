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
			$ResponseXML .= "<PaymentNo><![CDATA[" . $row["intPaymentNo"]  . "]]></PaymentNo>\n";
			$ResponseXML .= "<paydate><![CDATA[" . $row["dtmPayDate"]  . "]]></paydate>\n";
			$ResponseXML .= "<poamount><![CDATA[" . number_format($row["dblPoAmt"],2)  . "]]></poamount>\n";
			$ResponseXML .= "<taxamount><![CDATA[" . number_format($row["dblTaxAmt"],2)  . "]]></taxamount>\n";
			$ResponseXML .= "<totalamount><![CDATA[" . number_format($row["dblTotAmt"],2)  . "]]></totalamount>\n";
			/*$ResponseXML .= "<POno><![CDATA[" . $row["POno"]  . "]]></POno>\n";
			$ResponseXML .= "<POYear><![CDATA[" . $row["POYear"]  . "]]></POYear>\n";*/
		
		 }
		 $ResponseXML .= "</AdvacePaymentFind>";
		 echo $ResponseXML;
	}
	
	else if (strcmp($DBOprType,"showAnalizeData") == 0)//OK
	{	
					
		 $supID=$_GET["supID"];
		 $dateFrom=$_GET["dateFrom"];
		 $dateTo=$_GET["dateTo"];	
		 
		 
		 $ResponseXML = "";
		 $ResponseXML .= "<ShowAdvacePaymentFind>\n";	 
		 	
		 $result=showAdvacePayment($supID,$dateFrom,$dateTo,$strPaymentType);
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<strTitle><![CDATA[" . $row["strTitle"] . "]]></strTitle>\n";
			$ResponseXML .= "<POno><![CDATA[" . $row["intPOno"] . "]]></POno>\n";
			$ResponseXML .= "<PayDate><![CDATA[" . $row["dtmPayDate"] . "]]></PayDate>\n";
			$ResponseXML .= "<paidAmount><![CDATA[" . $row["dblpaidAmount"] . "]]></paidAmount>\n";
			$ResponseXML .= "<PaymentNo><![CDATA[" . $row["intPaymentNo"] . "]]></PaymentNo>\n";
			$ResponseXML .= "<AdvanceSettled><![CDATA[" . $row["settledAmt"] . "]]></AdvanceSettled>\n";
			
			$ResponseXML .= "<CurID><![CDATA[" . $row["intCurID"] . "]]></CurID>\n";
			$ResponseXML .= "<Currency><![CDATA[" . $row["strCurrency"] . "]]></Currency>\n";
			$ResponseXML .= "<rate><![CDATA[" . $row["rate"] . "]]></rate>\n";
			
			
			$ResponseXML .= "<ExcessQty><![CDATA[" . $row["dblExcessQty"] . "]]></ExcessQty>\n";
			$ResponseXML .= "<dblQty><![CDATA[" . $row["dblQty"] . "]]></dblQty>\n";
			$ResponseXML .= "<PoPrice><![CDATA[" . $row["dblPoPrice"] . "]]></PoPrice>\n";
			
			
	
			/*$ResponseXML .= "<POYear><![CDATA[" . $row["POYear"]  . "]]></POYear>\n";*/
		
		 }
		 $ResponseXML .= "</ShowAdvacePaymentFind>";
		 echo $ResponseXML;
	}
	else if(strcmp($DBOprType,"dbloadcurr") == 0)
	{
			
	  $curID=$_GET['curID'];
	   $ResponseXML .= "<Result>\n";
		      $sql="select DISTINCT
						 exchangerate.rate from exchangerate 
						  inner JOIN currencytypes on exchangerate.currencyID = currencytypes.intCurID
						 where currencytypes.intCurID = '$curID' AND exchangerate.intStatus=1;";
					//echo $sql;
			$res=$db->RunQuery($sql);
			while ($row=mysql_fetch_array($res)) {
		
			$ResponseXML .= "<Exrate><![CDATA[" .  $row["rate"] . "]]></Exrate>\n";
			
			}
			$ResponseXML .= "</Result>\n";
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
	
	function getCurrencyTypes()
	{
	global $db;
	$strSQL="SELECT strCurrency,dblRate FROM currencytypes WHERE intStatus=1";
	$result=$db->RunQuery($strSQL);
	return $result; 
	}
	function findAdvacePayment($supid,$dateFrom,$dateTo,$strPaymentType,$poNo,$poYear)
	{
		global $db;
	$dateFrom = dtoy($dateFrom);
	$dateTo   = dtoy($dateTo);
			$strSQL=" SELECT
						advancepayment.intPaymentNo,
						advancepayment.dtmPayDate,
						advancepayment.dblPoAmt,
						advancepayment.dblTaxAmt,
						advancepayment.dblTotAmt
						FROM
						advancepayment
						Inner Join advancepaymentpos ON advancepayment.intPaymentNo = advancepaymentpos.intPaymentNo 
						AND advancepayment.strType = advancepaymentpos.strType
						WHERE
						advancepayment.strType =  '$strPaymentType'";
			if(!empty($supid)){
				$strSQL.=" and advancepayment.intSupplierId='$supid'";
			}
			if(!empty($dateFrom) && !empty($dateTo)){
				$strSQL.=" and date(advancepayment.dtmPayDate) >= '$dateFrom'  and date(advancepayment.dtmPayDate) <= '$dateTo'" ;
			}
			if(!empty($poNo) && !empty($poYear)){
				$strSQL.=" and advancepaymentpos.POno='$poNo'  and advancepaymentpos.POYear='0'";
			}
			$strSQL.=" ORDER BY advancepayment.dtmPayDate desc";
	
		$result=$db->RunQuery($strSQL);
		//echo $strSQL;
		return $result; 
	}
	
function showAdvacePayment($supid,$dateFrom,$dateTo,$strPaymentType)
	{
		global $db;
	$dateFrom = dtoy($dateFrom);
	$dateTo   = dtoy($dateTo);
			if($strPaymentType =="S" )
			{
			$strSQL="SELECT 
									suppliers.strTitle as strTitle,
									advancepaymentpos.intPOno,
									advancepaymentpos.intPOYear,
									advancepayment.intPaymentNo,
									Sum(advancepayment.dblPoAmt),
									Sum(advancepaymentpos.dblpaidAmount) as dblpaidAmount,
									advancepayment.dtmPayDate,
									currencytypes.strCurrency,
									exchangerate.rate,
									Sum(grndetails.dblQty) as dblQty,
									grndetails.dblPoPrice,
									Sum(grndetails.dblAdvPayAmt) as settledAmt
									FROM
									advancepayment
									Inner Join advancepaymentpos ON advancepaymentpos.intPaymentNo = advancepayment.intPaymentNo AND 		                                     advancepaymentpos.strType = advancepayment.strType
									Inner Join suppliers ON suppliers.strSupplierID = advancepayment.intSupplierId
									Inner Join purchaseorderheader ON purchaseorderheader.intPONo = advancepaymentpos.intPOno AND                                    purchaseorderheader.intYear = advancepaymentpos.intPOYear AND suppliers.strSupplierID =                   purchaseorderheader.strSupplierID
									
                                    left Join grnheader ON advancepaymentpos.intPOno = grnheader.intPoNo AND advancepaymentpos.intPOYear =  grnheader.intYear
                                    left Join grndetails ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear
									Inner Join currencytypes ON currencytypes.intCurID = advancepayment.intCurrency
									Inner Join exchangerate ON exchangerate.currencyID = advancepayment.intCurrency
									WHERE advancepayment.strType='$strPaymentType' AND exchangerate.intStatus=1";
									
							if(!empty ($supid)){
								$strSQL.=" and advancepayment.intSupplierId='$supid'";
							}
							if(!empty($dateFrom) && !empty($dateTo)){
								$strSQL.=" and date(advancepayment.dtmPayDate) >= '$dateFrom'  and date(advancepayment.dtmPayDate) <= '$dateTo'" ;
							}
							
							$strSQL.="Group BY   advancepayment.intPaymentNo ,advancepaymentpos.intPOno ,advancepaymentpos.intPOYear ORDER BY advancepayment.dtmPayDate desc";
													
																		 


			}
			
				else if($strPaymentType =="B")
				{
	

 					
			       $strSQL=" SELECT
							advancepayment.intPaymentNo,
							Sum(advancepayment.dblPoAmt),
							Sum(advancepaymentpos.dblpaidAmount) AS dblpaidAmount,
							advancepaymentpos.intPOYear as intPOYear,
							advancepaymentpos.intPOno as intPOno,
							currencytypes.intCurID,
							currencytypes.strCurrency,
							exchangerate.rate,
							bulkgrndetails.dblRate as dblPoPrice,
							Sum(bulkgrndetails.dblQty) AS dblQty,
							advancepayment.dtmPayDate,
							suppliers.strTitle as strTitle,
							bulkgrndetails.dblBalance as settledAmt

							FROM
							advancepayment
							Inner Join currencytypes ON currencytypes.intCurID = advancepayment.intCurrency
							Inner Join exchangerate ON exchangerate.currencyID = currencytypes.intCurID
							Inner Join advancepaymentpos ON advancepayment.intPaymentNo = advancepaymentpos.intPaymentNo
							Inner Join bulkpurchaseorderheader ON advancepaymentpos.intPOno = bulkpurchaseorderheader.intBulkPoNo AND advancepaymentpos.intPOYear = bulkpurchaseorderheader.intYear
							Left Join bulkgrnheader ON bulkpurchaseorderheader.intBulkPoNo = bulkgrnheader.intBulkPoNo AND bulkpurchaseorderheader.intYear = bulkgrnheader.intBulkPoYear
							Left Join bulkgrndetails ON bulkgrndetails.intBulkGrnNo = bulkgrnheader.intBulkGrnNo AND bulkgrndetails.intYear = bulkgrnheader.intYear
							Inner Join suppliers ON suppliers.strSupplierID = advancepayment.intSupplierId
							WHERE advancepayment.strType='$strPaymentType' AND exchangerate.intStatus=1";
									
							if(!empty ($supid)){
								$strSQL.=" and advancepayment.intSupplierId='$supid'";
							}
							if(!empty($dateFrom) && !empty($dateTo)){
								$strSQL.=" and date(advancepayment.dtmPayDate) >= '$dateFrom'  and date(advancepayment.dtmPayDate) <= '$dateTo'" ;
							}
							
							$strSQL.="Group BY   advancepayment.intPaymentNo ,advancepaymentpos.intPOno ,advancepaymentpos.intPOYear ORDER BY advancepayment.dtmPayDate desc";

		
		
				}
				
	else if($strPaymentType =="G")
				{
								
			       $strSQL="SELECT
							advancepayment.intPaymentNo,
							Sum(advancepayment.dblPoAmt),
							Sum(advancepaymentpos.dblpaidAmount) AS dblpaidAmount,
							advancepaymentpos.intPOYear AS intPOYear,
							advancepaymentpos.intPOno AS intPOno,
							currencytypes.intCurID,
							currencytypes.strCurrency,
							exchangerate.rate,
							gengrndetails.dblRate AS dblPoPrice,
							Sum(gengrndetails.dblQty) AS dblQty,
							advancepayment.dtmPayDate,
							suppliers.strTitle AS strTitle,
							gengrndetails.dblBalance AS settledAmt
							FROM
							advancepayment
							Inner Join currencytypes ON currencytypes.intCurID = advancepayment.intCurrency
							Inner Join exchangerate ON exchangerate.currencyID = currencytypes.intCurID
							Inner Join advancepaymentpos ON advancepayment.intPaymentNo = advancepaymentpos.intPaymentNo
							Inner Join generalpurchaseorderheader ON advancepaymentpos.intPOno = generalpurchaseorderheader.intGenPONo AND advancepaymentpos.intPOYear = generalpurchaseorderheader.intYear
							Left Join gengrnheader ON generalpurchaseorderheader.intGenPONo = gengrnheader.intGenPONo AND generalpurchaseorderheader.intYear = gengrnheader.intGenPOYear
							Left Join gengrndetails ON gengrndetails.strGenGrnNo = gengrnheader.intGenPONo AND gengrndetails.intYear = gengrnheader.intYear
							Inner Join suppliers ON suppliers.strSupplierID = advancepayment.intSupplierId
							WHERE advancepayment.strType='$strPaymentType' AND exchangerate.intStatus=1";
									
							if(!empty ($supid)){
								$strSQL.=" and advancepayment.intSupplierId='$supid'";
							}
							if(!empty($dateFrom) && !empty($dateTo)){
								$strSQL.=" and date(advancepayment.dtmPayDate) >= '$dateFrom'  and date(advancepayment.dtmPayDate) <= '$dateTo'" ;
							}
							
							$strSQL.="Group BY   advancepayment.intPaymentNo ,advancepaymentpos.intPOno ,advancepaymentpos.intPOYear ORDER BY advancepayment.dtmPayDate desc";

							
				
				}
				
				$result=$db->RunQuery($strSQL);
				//echo $strSQL;
				return $result; 
	}

function dtoy($ddt)
{
if ($ddt) {
$vl=split('/',$ddt);
$day = $vl[2];
$month = $vl[1];
$year = $vl[0];
return "$year-$month-$day";
}
else
{return ""; }
}
?>