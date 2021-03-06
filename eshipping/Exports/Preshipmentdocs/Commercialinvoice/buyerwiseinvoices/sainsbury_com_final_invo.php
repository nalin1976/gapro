<?php 
session_start();
$document='NI';
include "../../../../Connector.php";
include "../../../../Reports/numbertotext.php";
$xmldoc=simplexml_load_file('../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
/*include("../../../../invoice_queries.php");	
include '../../../../common_report.php';*/
include("invoice_queries.php");	
include 'common_report.php';

$invoiceNo=$_GET['InvoiceNo'];
$type=($_GET['type']==""? "FOB":$_GET['type']);
 $sqlinvoiceheader="SELECT IH.strInvoiceNo, 
					date(dtmInvoiceDate) AS dtmInvoiceDate, 
					IH.bytType, 
					customers.strName AS CustomerName, 
					CONCAT(customers.strAddress1,' ',customers.strAddress2 ) AS CustomerAddress, 
					customers.strAddress1, 
					customers.strAddress2, 
					customers.strCountry AS CustomerCountry, 
					buyers.strBuyerID, 
					buyers.strName AS BuyerAName, 
					buyers.strAddress1 AS buyerAddress1, 
					buyers.strAddress2 AS buyerAddress2, 
					buyers.strCountry AS BuyerCountry, 
					buyers.strBuyerCode AS strBuyerCode, 
					soldto.strName AS soldtoAName, 
					soldto.strAddress1 AS soldtoAddress1, 
					soldto.strAddress2 AS soldtoAddress2, 
					soldto.strCountry AS soldtoCountry, 
					(SELECT cty.strCity FROM city cty where cty.strCityCode=IH.strFinalDest) AS strFinalDest, 
					IH.strNotifyID1, 
					IH.strNotifyID2, 
					IH.strLCNo AS LCNO, 
					IH.dtmLCDate AS LCDate, 
					IH.strLCBankID, 
					IH.dtmLCDate, 
					IH.strPortOfLoading, 
					city.strCity AS city, 
					IH.strCarrier, 
					IH.strVoyegeNo, 
					IH.dtmSailingDate, 
					IH.strCurrency, 
					IH.dblExchange, 
					SUM(IH.intNoOfCartons) AS intNoOfCartons,
					IH.intMode, 
					IH.strCartonMeasurement, 
					IH.strCBM, 
					IH.strMarksAndNos, 
					IH.strGenDesc, 
					IH.bytStatus, 
					IH.intFINVStatus, 
					IH.intCusdec, 
					IH.strTransportMode, 
					IH.strIncoterm, 
					IH.strPay_trms, 
					IH.strVesselName, 
					IH.dtmVesselDate, 
					IH.intPackingMthd,
					invoicedetail.dblGOHstatus, 
					invoicedetail.strBuyerPONo, 
					invoicedetail.dblNetMass, 
					invoicedetail.dblGrossMass,
					invoicedetail.strStyleID, 
					shipmentforecast_detail.strSC_No,
					shipmentforecast_detail.strDeptNo,
					shipmentforecast_detail.strCtnMes 
					FROM invoiceheader AS IH 
					LEFT JOIN customers ON IH.strCompanyID = customers.strCustomerID 
					LEFT JOIN buyers ON IH.strBuyerID = buyers.strBuyerID 
					LEFT JOIN buyers AS soldto ON IH.strSoldTo = soldto.strBuyerID 
					LEFT JOIN city ON IH.strFinalDest = city.strCityCode 
					INNER JOIN invoicedetail ON IH.strInvoiceNo = invoicedetail.strInvoiceNo 
					INNER JOIN shipmentforecast_detail ON shipmentforecast_detail.strPoNo = invoicedetail.strBuyerPONo AND 
					shipmentforecast_detail.strStyleNo = invoicedetail.strStyleID 
					WHERE 
					IH.strInvoiceNo='$invoiceNo' GROUP BY IH.strInvoiceNo";
	
	$idresult=$db->RunQuery($sqlinvoiceheader);
	$dataholder=mysql_fetch_array($idresult);
	
	$dateVariable = $dataholder['dtmInvoiceDate'];
	$dateInvoice = substr($dateVariable, 0, 10); 
	//die ("$sqlinvoiceheader"); 
	$dateLC = $dataholder['LCDate'];
	$LCDate = substr($dateLC, 0, 10); 
	 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>| SAINSBURY'S | Commercial Invoice |</title>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="normalfnt_size20" style="text-align:center" bgcolor="#CCCCCC" height="40"><?php echo 'HELA CLOTHIING (PVT) LTD.';?></td>
  </tr>
  <tr>
    <td bgcolor="#999999" class="normalfntMid" height="18"><?php echo "No. 306/11,Negombo Road, Welisara" ;?></td>
  </tr>
  <tr>
    <td bgcolor="#999999" class="normalfntMid" height="18"><?php echo "Tel- +94 11 2234000 Fax +94 11 2233678" ;?></td>
  </tr>
  <tr>
    <td class="normalfntMid">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%">&nbsp;</td>
        <td width="60%" style="text-align:center">COMMERCIALE INVOICE</td>
        <td width="20%"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td >
    <TABLE></TABLE>
    </td>
  </tr>
  <?php 
  		$str_summary="select 
		strUnitID,strPriceUnitID,sum(dblAmount) as totamt,sum(dblQuantity) as totqty
		from invoicedetail
		where strInvoiceNo ='$invoiceNo'
		group by strInvoiceNo ";
  		$result_summary=$db->RunQuery($str_summary);
		$row_summary=mysql_fetch_array($result_summary);
		
  ?>
  <tr>
    <td ><table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="202"></td>
        <td width="204"></td>
        <td width="171">&nbsp;</td>
        <td width="176">&nbsp;</td>
        <td width="168"></td>
        <td width="4"></td>
        <td width="152"></td>
        <td width="39">&nbsp;</td>
       
      </tr>
      <tr>
        <td colspan="0">INVOICE NO  </td>
        <td colspan="">: &nbsp;<?php //echo $dataholder['strInvoiceNo'];?></td>
        <td>&nbsp;</td>
        <td>DATE</td>
        <td>: &nbsp;<?php echo $dataholder['dtmInvoiceDate'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="0"><u><strong>SHIPPER</strong></u></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
      </tr>
      <tr>
        <td colspan="0">HELA CLOTHING (PVT) LTD</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong><u>CONSIGNEE</u></strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
       <tr>
        <td colspan="0">NO:309/11 NEGAMBO ROAD</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo $dataholder['BuyerAName'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
       </tr>
       <tr>
        <td colspan="0">WELISARA</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo $dataholder['buyerAddress1'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
     
       </tr>
       <tr>
        <td colspan="0">SRI LANKA</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo $dataholder['buyerAddress2'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo $dataholder['BuyerCountry'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
       
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="0">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
       </tr>
       <tr>
        <td colspan="0"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="0">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
        </tr> 
        <tr>
        <td colspan="0">TERMS OF PAYMENT</td>
        <td>: <?php 
		$paymenTerms=$dataholder['strPay_trms'];
		 			$sql_PayTms="SELECT
								paymentterm.strPaymentTermID,
								paymentterm.strPaymentTerm
								FROM
								paymentterm
								WHERE
								paymentterm.strPaymentTermID = '$paymenTerms'";
                   $result_PayTms=$db->RunQuery($sql_PayTms);
				   $paymen_Terms=mysql_fetch_array($result_PayTms);	
				   
		echo $paymen_Terms['strPaymentTerm']?></td>
        <td>&nbsp;</td>
        <td colspan="0"><strong><u>NOTIFY PARTY</u></strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
        </tr>
       <tr>
        <td colspan="0">TERMS OF DELIVERY</td>
        <td>: <?php echo $dataholder['strIncoterm']?></td>
        <td>&nbsp;</td>
        <td colspan="0">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
       
        </tr>
       <tr>
        <td colspan="0">SHIPMENT FROM</td>
        <td>: <?php echo $dataholder['strPortOfLoading']?></td>
        <td>&nbsp;</td>
        <td colspan="0">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
        </tr>
       <tr>
        <td colspan="0">SHIPMENT TO</td>
        <td>: <?php echo strtoupper($dataholder['strFinalDest']);?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="0">MODE OF SHIPMENT</td>
        <td>: <?php echo strtoupper($dataholder['strTransportMode']);?> FREIGHT</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
       <tr>
        <td colspan="0">CUSTOMER</td>
        <td colspan="0">:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
       <tr>
        <td colspan="0">MANU REF</td>
        <td>:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
       <tr>
        <td colspan="0">CATEGORY NO</td>
        <td>: <?php 
						$str_hs="select distinct	
										strCatNo						 
										from 
										invoicedetail 
										where 
										strInvoiceNo='$invoiceNo'";
										$boo_count=0;
						$result_hs=$db->RunQuery($str_hs);
						while($row_hs=mysql_fetch_array($result_hs))
						{
							if($boo_count!=0)
								echo ", ";
							echo $row_hs["strCatNo"];
							$boo_count=1;
						}
	  ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
       <tr>
        <td colspan="0">&nbsp;</td>
        <td colspan="0">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
       <tr>
        <td colspan="0">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
       </tr> 
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
       </tr>
      <?php 
	  	 $str_summary="select 
		strUnitID,
		strPriceUnitID,
		dblUnitPrice,
		dblQuantity,
		dblAmount,
		intNoOfCTns,
		strDescOfGoods,
		sum(dblAmount) as totamt,
		sum(dblQuantity) as totqty,
		shipmentforecast_detail.strPackType
		from invoicedetail
		INNER JOIN shipmentforecast_detail ON shipmentforecast_detail.strPoNo = invoicedetail.strBuyerPONo
		where strInvoiceNo ='$invoiceNo'
		order by intItemNo ";
  		$result_summary=$db->RunQuery($str_summary);
		while($row_HS_summary=mysql_fetch_array($result_summary))
		{
			$packType=$row_HS_summary['strPackType'];
			$noOfCtn+=$row_HS_summary['intNoOfCTns'];
			$tot+=$row_HS_summary["dblAmount"];
			$totqty+=$row_HS_summary["dblQuantity"];
				
	  ?>
       <tr>
        <td class="border-bottom" style="font-size:12px; text-align:center">No of ctns</td>
        <td colspan="0" class="border-bottom" style="font-size:12px; text-align:center">Description of Goods</td>
        <td class="border-bottom" style="font-size:12px; text-align:center" >Quantity PCS</td>
        <td class="border-bottom" style="font-size:12px; text-align:center">U/Price per  PCS FOB US $</td>
        <td class="border-bottom" style="font-size:12px; text-align:center"> Total FOB US $</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
       </tr> 
      <tr>
      	<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
       
                
      </tr>
      <tr>
        <td align="center"><?php echo $row_HS_summary['intNoOfCTns'];?></td>
        <td colspan="0" align="center"><?php echo $row_HS_summary['strDescOfGoods'];?></td>
        <td align="center"><?php echo $row_HS_summary['dblQuantity'];?></td>
        <td align="center"><?php echo number_format($row_HS_summary["dblUnitPrice"],2);?></td>
        <td align="center"><?php echo number_format($row_HS_summary["dblAmount"],2);?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
     
        
        <?php }?>
      </tr> 
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
       
      </tr> 
      <tr>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
      </tr>
       <tr>
        <td align="center">________________</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center">________________</td>
        <td>&nbsp;</td>
        <td align="center">___________________</td>
        <td>&nbsp;</td>
       
       </tr>
      <tr>
        <td align="center"><?php echo $noOfCtn;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center"><?php echo $totqty;?></td>
        <td>&nbsp;</td>
        <td align="center"><?php echo number_format($tot,2);?></td>
        <td>&nbsp;</td>
       
      </tr>
      <tr>
        <td align="center">________________</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center">________________</td>
        <td>&nbsp;</td>
        <td align="center">___________________</td>
        <td>&nbsp;</td>
        
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
      </tr>
       <tr>
         <td><u>FABRIC</u></td>
         <?php $str_hs="select strHSCode,strFabrication,replace(strFabrication,' ','') as fabric					 
						from 
						invoicedetail 
						where 
						strInvoiceNo='$invoiceNo'
						group by fabric";
						$boo_count=0;
		$result_hs=$db->RunQuery($str_hs);
		while($row_hs=mysql_fetch_array($result_hs))
		{
			if($boo_count!=0){
				echo " /";
				$fabric.=" /";
				
			}
			echo $row_hs["strHSCode"];
			$fabric.=$row_hs["strFabrication"];
			$boo_count=1;
		}?>
         <td colspan="0">:  </td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       
       </tr>
       <tr>
        <td>TEE</td>
        <td colspan="0">: <?php echo $fabric; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
     
      </tr>
       <tr>
        <td>LEGGINGS</td>
        <td colspan="0">:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
       </tr>
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center"></div></td>
        <td><div align="center"></div></td>
        <td>&nbsp;</td>
        
       </tr>
       <tr>
        <td colspan="0"></td>
        <td colspan="0">TOTAL CARTON &nbsp;- <?php 
		
		$mat_array=explode(".",number_format($noOfCtn,2));
		echo convert_number($noOfCtn);
		echo $mat_array[1]!="00"?" AND CENTS ".convert_number($mat_array[1])." ONLY.":" ONLY.";
		?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
        </tr>
      <tr>
        <td colspan="0">&nbsp;</td>
        <td colspan="0">TOTAL PCS - <?php 
		$mat_array=explode(".",number_format($totqty,2));
		echo convert_number($totqty);
		echo $mat_array[1]!="00"?" AND CENTS ".convert_number($mat_array[1])." ONLY.":" ONLY.";
		?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
      </tr>
       <tr>
        <td colspan="0">&nbsp;</td>
        <td colspan="0">TOTAL FOB USD - <?php 
		$mat_array=explode(".",number_format($tot,2));
		echo convert_number($tot);
		echo $mat_array[1]!="00"?" AND CENTS ".convert_number($mat_array[1])." ONLY.":" ONLY.";
		?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
       
       </tr>
      <tr>
        <td colspan="0">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
       
      </tr>
       <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
       
       </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
       
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      
      </tr>
    </table>
    </td>
  </tr>  
 </table>
 <?php 
 function summary_string($obj1,$obj2)
	{
			global $db;
			global $invoiceNo;
			$str_summary_dtl	="select $obj2,replace($obj2,' ','') as grpby from invoicedetail where strInvoiceNo='$invoiceNo' and  strHSCode='$obj1' group by grpby order by strBuyerPONo";
			$result_summary_dtl	=$db->RunQuery($str_summary_dtl);
			$first=0;
			while($row_summary_dtl	=mysql_fetch_array($result_summary_dtl))
			{
				if($first==0){
				$str.=$row_summary_dtl[$obj2];
				$first=1;
				}
				else 
				$str.="/ ".$row_summary_dtl[$obj2];
			}
			return $str;
	}
	?>
</body>
</html>
