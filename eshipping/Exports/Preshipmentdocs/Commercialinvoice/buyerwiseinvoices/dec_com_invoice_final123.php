<?php 
session_start();
$document='NI';
include "../../../../Connector.php";
$xmldoc=simplexml_load_file('../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
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
IH.strIncoterms, 
IH.strPay_trms, 
IH.strVesselName, 
IH.dtmVesselDate, 
IH.strPortOfDischarge,
invoicedetail.dblGOHstatus, 
invoicedetail.strBuyerPONo, 
invoicedetail.dblNetMass, 
invoicedetail.dblGrossMass, 
shipmentforecast_detail.strSC_No,
shipmentforecast_detail.strDeptNo 
FROM invoiceheader AS IH 
LEFT JOIN customers ON IH.strCompanyID = customers.strCustomerID 
LEFT JOIN buyers ON IH.strBuyerID = buyers.strBuyerID 
LEFT JOIN buyers AS soldto ON IH.strSoldTo = soldto.strBuyerID 
LEFT JOIN city ON IH.strFinalDest = city.strCityCode 
INNER JOIN invoicedetail ON IH.strInvoiceNo = invoicedetail.strInvoiceNo 
INNER JOIN shipmentforecast_detail ON shipmentforecast_detail.strPoNo = invoicedetail.strBuyerPONo AND 
shipmentforecast_detail.strStyleNo = invoicedetail.strStyleID 
WHERE 
IH.strInvoiceNo='$invoiceNo'";
	
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
<title>| Decatholon | Commercial Invoice Final</title>
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
        <td width="60%" style="text-align:center"><?PHP echo 'COMMERCIAL INVOICE NO : ';?></td>
        <td width="20%"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
    <tr>
      <td width="26%" class="border-bottom-fntsize12">&nbsp;</td>
      <td width="25%" class="border-bottom-fntsize12">&nbsp;</td>
      <td colspan="2" class="border-bottom-fntsize12">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" class="border-left-fntsize12"><u>Shipper</u></td>
        <td colspan="2" class="border-left-right-fntsize12"><u>Invoice No.&amp; Date<span style="text-align:center">&nbsp;</span></u></td>
        </tr>
    <tr>
        <td colspan="2" class="border-left-fntsize12">HELA CLOTHING PVT(LTD) </td>
        <td class="border-bottom-left-fntsize12"><strong><?php echo $dataholder['strInvoiceNo'];?></strong></td>
        <td class="border-bottom-right-fntsize12"><strong><?PHP echo $dataholder['dtmInvoiceDate'];?></strong></td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-fntsize12">309/11, NEGOMBO ROAD</td>
        <td width="19%" class="border-left-fntsize12">Seller`s / Shipper`s Ref</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-fntsize12">WELISARA</td>
        <td class="border-bottom-left-fntsize12">SC NO : <?php echo $dataholder['strSC_No'];?></td>
        <td width="29%" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
      </tr>
      
       <tr>
         <td colspan="2" class="border-bottom-left-fntsize12">SRI LANKA</td>
         <td colspan="2" class="border-Left-bottom-right-fntsize12"><strong>FCR/BL/AWB NO &amp; DATE</strong></td>
        </tr>
      
      <tr>
        <td class="border-left-fntsize12"><u>Consignee/ Applicant</u></td>
        <td cla>&nbsp;</td>
        <td colspan="2" class="border-left-right-fntsize12"><u>Buyer(Other than Consignee);</u></td>
        </tr>
       <tr>
        <td class="border-left-fntsize12"><?php echo $dataholder['BuyerAName'];?></td>
        <td>&nbsp;</td>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['BuyerAName'];?></td>
        </tr>
      
      <tr>
        <td class="border-left-fntsize12"><?php echo $dataholder['buyerAddress1'];?></td>
        <td>&nbsp;</td>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['buyerAddress1'];?></td>
        <?php $notifyParty1Id = $dataholder['strNotifyID1'];
		 $sql_NotPty=" SELECT buyers.strBuyerID,
						buyers.strBuyerCode,
						buyers.strName,
						buyers.strAddress1,
						buyers.strAddress2,
						buyers.strCountry
						FROM buyers
						WHERE strBuyerID='$notifyParty1Id'";
		
				
	$result=$db->RunQuery($sql_NotPty);
	$notyfy=mysql_fetch_array($result);		 
	?>	
        
        </tr>
      <tr>
        <td class="border-left-fntsize12"><?php echo $dataholder['buyerAddress2'];?></td>
        <td>&nbsp;</td>
        <td colspan="2" class="border-left-right-fntsize12"><?php echo $dataholder['buyerAddress2'];?></td>
        </tr>
      <tr>
        <td colspan="2" class="border-bottom-left-fntsize12"><?php echo $dataholder['BuyerCountry'];?></td>
        <td colspan="2" class="border-bottom-left-fntsize12"><?php echo $dataholder['BuyerCountry'];?></td>
        </tr>
      <tr>
        <td class="border-left-fntsize12"><u>Notify Party</u></td>
        <td>&nbsp;</td>
        <td colspan="2" class="border-left-right-fntsize12"><u>Terms of Delivery &amp; Payment</u></td>
        </tr>
      <tr>
        <td class="border-left-fntsize12"><?php echo $dataholder['BuyerAName'];?></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
        <td width="1%">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12"><?php echo $dataholder['buyerAddress1'];?> </td>
        <td>&nbsp;</td>
         <!--<td><strong><?php if($dataholder['soldtoAName']!=""){?>Shipped to<?php }?></strong></td>-->
        <td class="border-left-fntsize12">Terms of Delivery  -</td>
        <td class="border-right-fntsize12"><?php echo $dataholder['strIncoterms']?></td>
        </tr>
      <tr>
        <td class="border-left-fntsize12"><?php echo $dataholder['buyerAddress2'];?></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">Terms of Payment-</td>
        <td class="border-right-fntsize12"><?php 
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
        </tr>
        
        
         <tr>
           <td colspan="2" class="border-bottom-left-fntsize12"><?php echo $dataholder['BuyerCountry'];?></td>
           <td class="border-bottom-left-fntsize12">&nbsp;</td>
           <td class="border-bottom-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12"><u>Carrier</u></td>
        <td class="border-left-fntsize12"><u>Port of Loading</u></td>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      
      <tr>
        <td class="border-bottom-left-fntsize12">&nbsp;<?php echo $dataholder['strCarrier'];?></td>
        <td class="border-bottom-left-fntsize12"><?php echo $dataholder['strPortOfLoading'];?>,SRI LANKA</td>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12"><u>Port of Discharge</u></td>
        <td class="border-left-fntsize12"><u>Final Destination</u></td>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left">&nbsp;</td>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td class="border-bottom-left-fntsize12">&nbsp;<?php echo $dataholder['strPortOfDischarge'];?></td>
        <td class="border-bottom-left-fntsize12"><?php echo $dataholder['city'];?></td>
        <td class="border-bottom-left-fntsize12">&nbsp;</td>
        <td class="border-bottom-right-fntsize10">&nbsp;</td>
        </tr>
    </table>
    
    <table width="99%" border="0" cellspacing="0" cellpadding="3" class="normalfnt"> 
    <tr>
      <td width="31%" class="border-left-fntsize12"><u>Container / Seal Nos.</u></td>
      <td width="26%" class="border-left-fntsize12"><u>No &amp; Kind of Package </u></td>
      <td width="16%"  class="border-left-fntsize12" align="center"><u>Quantity</u></td>
      <td width="14%"  class="border-left-fntsize12" align="center"><u>Unit /Price</u></td>
      <td width="13%"  class="border-Left-Top-right-fntsize12" align="center"><u>Amount</u></td>
    </tr>
      <tr>
        <td class="border-left-fntsize12">Shipping Marks</td>
        <td class="border-left">Discription of good &amp; category</td>
        <td class="border-left" align="center"><strong>(Unit)</strong></td>
        <td ><strong> PER/PCS</strong></td>
        <td class="border-right-fntsize12"><strong>F.O.B.</strong></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">As Per Ctn Sticker</td>
        <td>&nbsp;</td>
        <td style="text-align:center"><strong><u>PCS</u></strong></td>
        <td style="text-align:center"><strong><u>US$</u></strong></td>
        <td class="border-right-fntsize12" style="text-align:center"><strong><u>US$</u></strong></td>
      </tr>
      <?php 
  		$str_summary="select 
		strUnitID,strPriceUnitID,sum(dblAmount) as totamt,sum(dblQuantity) as totqty,strDescOfGoods
		from invoicedetail
		where strInvoiceNo ='$invoiceNo'
		group by strInvoiceNo ";
  		$result_summary=$db->RunQuery($str_summary);
		$row_summary=mysql_fetch_array($result_summary);
		
  ?>
      <tr>
        <td class="border-left-fntsize12">SENDER</td>
        <td><?php echo $dataholder['intNoOfCartons'];?>&nbsp;<?php if($dataholder['intPackingMthd']=='1'){echo "Cartoons";} else if($dataholder['intPackingMthd']=='2') {echo "GOH";} ?> CONTAINING..,</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td class="border-left-fntsize12">ORDER NO;</td>
        <td><?php echo ($row_summary["strUnitID"]!='DZN'?$row_summary["totqty"]:$row_summary["totqty"]*12) ." PCS";?> OF <?php echo $row_summary["strDescOfGoods"];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      
            <?php 
  		$str_summary="select 
		strUnitID,
		strPriceUnitID,
		dblUnitPrice,
		dblQuantity,
		dblAmount,
		sum(dblAmount) as totamt,
		sum(dblQuantity) as totqty
		from invoicedetail
		where strInvoiceNo ='$invoiceNo'
		group by strInvoiceNo ";
  		$result_summary=$db->RunQuery($str_summary);
		$row_HS_summary=mysql_fetch_array($result_summary)
		
  ?>
      <tr>
        <td class="border-left-fntsize12"> CONSIGNEE</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">DESIGNATION</td>
        <td>&nbsp;</td>
        <td class="border-bottom-fntsize12" style="text-align:center"><?php echo $row_HS_summary['dblQuantity'];?></td>
        <td style="text-align:center"><?php echo number_format($row_HS_summary['dblUnitPrice'],2);?></td>
        <?php  
	
		
		
		?>
        <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo number_format($row_HS_summary['dblAmount'],2);?></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">QUANTITY</td>
        <td align="right"><strong>TOTAL </strong></td>
        <td class="bord border-bottom-fntsize12" style="text-align:center"><?php echo $row_HS_summary['totqty'];?></td>
        <td>&nbsp;</td>
        <td class="border-bottom-right-fntsize12" style="text-align:center"><?php echo number_format($row_HS_summary['totamt'],2);?></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">SIZE</td>
        <td>ORDER NO:</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">PARCEL LBEL</td>
        <td>MODEL:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">ITEM CODE</td>
        <td>IMAN CODE</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">SELLING DATE</td>
        <td>DEPARTMENT</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">MADE IN SRI LANKA</td>
        <td>CRITERION NO :</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
        </tr>
    </table>
  <?php 
  		$str_summary="select 
		strUnitID,strPriceUnitID,sum(dblAmount) as totamt,sum(dblQuantity) as totqty
		from invoicedetail
		where strInvoiceNo ='$invoiceNo'
		group by strInvoiceNo ";
  		$result_summary=$db->RunQuery($str_summary);
		$row_summary=mysql_fetch_array($result_summary);
		
  ?>  
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
