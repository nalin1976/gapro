<?php 
session_start();
$document='NI';
include "../../../Connector.php";
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


$invoiceNo = $_GET['InvoiceNo'];
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
					IH.intPackingMthd,
					invoicedetail.dblGOHstatus, 
					invoicedetail.strBuyerPONo, 
					invoicedetail.dblNetMass, 
					invoicedetail.dblGrossMass,
					invoicedetail.strStyleID,
					sum(invoicedetail.dblQuantity) AS dblQuantity, 
					shipmentforecast_detail.strSC_No,
					shipmentforecast_detail.strDeptNo,
					shipmentforecast_detail.strPo_des 
					FROM invoiceheader AS IH 
					LEFT JOIN customers ON IH.strCompanyID = customers.strCustomerID 
					LEFT JOIN buyers ON IH.strBuyerID = buyers.strBuyerID 
					LEFT JOIN buyers AS soldto ON IH.strSoldTo = soldto.strBuyerID 
					LEFT JOIN city ON IH.strFinalDest = city.strCityCode 
					INNER JOIN invoicedetail ON IH.strInvoiceNo = invoicedetail.strInvoiceNo 
					LEFT JOIN shipmentforecast_detail ON shipmentforecast_detail.strPoNo = invoicedetail.strBuyerPONo AND 
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
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PRE-INVOICE</title>
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
        <td width="60%" style="text-align:center; font-size:19px"><u><?PHP echo 'COMMERCIAL INVOICE ';?></u></td>
        <td width="20%"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
    <tr>
        <td class="normalfnth2B">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong></strong></td>
        <td><span style="text-align:center">&nbsp;</span></td>
      </tr>
    <tr>
        <td class="normalfnth2B">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong>SC NO:</strong></td>
        <td><span style="text-align:center"><?PHP echo $dataholder['strSC_No'];?></span></td>
      </tr>
      <tr>
        <td class="normalfnth2B">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong>Invoice Date</strong></td>
        <td><span style="text-align:center"><?PHP  $date_array=explode("-",$dataholder['dtmInvoiceDate']); echo $date_array[2]."/".$date_array[1]."/".$date_array[0]; ?></span></td>
      </tr>
      <tr>
        <td width="22%" class="normalfnth2B">Invoice Number </td>
        <td width="20%"><?PHP echo $dataholder['strInvoiceNo'];?></td>
        <td width="10%">&nbsp;</td>
        <td width="16%">&nbsp;</td>
        <td width="11%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
      </tr>
      
       <tr>
        <td width="22%" class="normalfnth2B"><u>Shipper </u></td>
        <td width="20%">HELA CLOTHING PVT(LTD) </td>
        <td width="10%">&nbsp;</td>
        <td width="16%">&nbsp;</td>
        <td width="11%"><strong><u>Consignee</u></strong>:</td>
        <td width="21%"><?php echo $dataholder['BuyerAName'];?></td>
      </tr>
      
      <tr>
        <td width="22%">&nbsp;</td>
       <td width="20%">309/11, NEGOMBO ROAD</td>
        <td width="10%">&nbsp;</td>
        <td width="16%">&nbsp;</td>
        <td width="11%">&nbsp;</td>
        <td width="21%"><?php echo  $dataholder['buyerAddress1'];?></td>
      </tr>
      <tr>
        <td width="22%" >&nbsp;</td>
        <td width="20%">WELISARA</td>
        <td width="10%">&nbsp;</td>
        <td width="16%">&nbsp;</td>
        <td width="11%">&nbsp;</td>
        <td width="21%"><?php echo $dataholder['BuyerCountry'];?></td>
      </tr>
       <tr>
        <td width="22%" >&nbsp;</td>
        <td width="20%">SRI LANKA</td>
        <td width="10%">&nbsp;</td>
        <td width="16%">&nbsp;</td>
        <td width="11%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
      </tr>
      
      <tr>
        <td class="normalfnth2B">Terms Of Payment :</td>
        <td><?php 
		 $paymenTerms=$dataholder['strPay_trms'];
		 			$sql_PayTms="SELECT
								paymentterm.intPaymentTermID,
								paymentterm.strPaymentTerm
								FROM
								paymentterm
								WHERE
								paymentterm.intPaymentTermID = '$paymenTerms'";
                   $result_PayTms=$db->RunQuery($sql_PayTms);
				   $paymen_Terms=mysql_fetch_array($result_PayTms);	
				   
		echo $paymen_Terms['strPaymentTerm']?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong><u>Notify party</u></strong></td>
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
		
		
        <td><?php echo $notyfy['strName'];?></td>
			
      </tr>
      <tr>
            <tr>
        <td class="normalfnth2B">Terms Of Delivary :</td>
        <td><?php echo $dataholder['strIncoterms']?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo  $notyfy['strAddress1'];?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">Shipment From </td>
        <td><?php echo $dataholder['strPortOfLoading']?>, SRI LANKA </td>
        <td class="normalfnth2B">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td><?php echo  $notyfy['strAddress2'];?></td>
      </tr>
      <tr>
        <td ><span class="normalfnth2B">Shipment To </span></td>
        <td><?php echo strtoupper($dataholder['city']);?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo  $notyfy['strCountry'];?></td>
      </tr>
      <tr>
        <td ><span class="normalfnth2B">Mode of Shipment</span></td>
        <td><?php echo strtoupper($dataholder['strTransportMode']);?> FREIGHT</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td ><span class="normalfnth2B">Country of Origin</span></td>
        <td>SRI LANKA</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><strong>&nbsp;</strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp; </td>
        <td>&nbsp;</td>
         <td>&nbsp;</td>
        <!--<td><strong><?php if($dataholder['soldtoAName']!=""){?>Shipped to<?php }?></strong></td>-->
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td style="font-weight:bold">PO NO</td>
        <td colspan="2"><?php echo $dataholder["strBuyerPONo"];?></td>
        <td>&nbsp;</td>
        <td>BOOKING NO -</td>
        <?php 
			$bookingNum ="SELECT
commercial_invoice_header.strBookingNo
FROM
commercial_invoice_header
WHERE
commercial_invoice_header.strInvoiceNo = '$invoiceNo'";
$result_bn=$db->RunQuery($bookingNum);
						$bookinumber=mysql_fetch_array($result_bn);
		?>
        <td><?php echo $bookinumber['strBookingNo'];?></td>
        </tr>
        
        
         <tr>
        <td style="font-weight:bold">STROKE NO/ STYLE NO</td>
        <td colspan="2"><?php echo $dataholder['strStyleID'];?></td>
        <td>&nbsp;</td>
        <td>VSL -</td>
        <td><?php echo $dataholder['strVesselName'];?></td>
        </tr>
      <tr>
        <td style="font-weight:bold">DEPT. NO:</td>
        <td colspan="2"><?php echo $dataholder['strDeptNo'];?></td>
        <td>&nbsp;</td>
        <td>Voyage No -</td>
        <td><?php echo $dataholder['strVoyegeNo'];?> </td>
        </tr>
      <tr>
        <td style="font-weight:bold">CATEGORY NO :</td>
        <td colspan="2"><?php 
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
        <td colspan="2">Date -&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $dataholder['dtmVesselDate'];?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
    </table></td>
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
    <td ><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt">
      <tr><thead>
        <td height="20" class="border-top-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">Marks & Nos.</span></td>
        <td colspan="5" class="border-top-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">Description of goods</span> </td>
        <td class="border-top-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">Unit Price </span></td>
        <td class="border-top-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">Amount</span></td></thead>
      </tr>
	  
      <tr>
        <td >&nbsp;</td>
        <td colspan="5" class="border-left-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30%"><?php echo $dataholder['intNoOfCartons']; ?> <?php if($dataholder['intPackingMthd']=='1'){echo "Cartoons";} else if($dataholder['intPackingMthd']=='2') {echo "GOH";} ?></td>
            <td width="30%"><?php echo ($row_summary["strUnitID"]!='DZN'?$row_summary["totqty"]:$row_summary["totqty"]*12) ." PCS";?></td>
            <td width="40%">&nbsp;</td>
          </tr>
        </table></td>
        <td colspan="2" class="border-left-fntsize12" style="text-align:center"><span class="normalfnth2B"><?php echo $dataholder['strIncoterms']."";?> </span></td>
      </tr>
      <tr>
        <td ></td>
        <td colspan="5" class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:center"><span class="normalfnth2B"><?php echo $dataholder['strCurrency']."/".$row_summary["strPriceUnitID"];?></span></td>
        <td class="border-left-fntsize12" style="text-align:center"><span class="normalfnth2B"><?php echo $dataholder['strCurrency'];?> </span></td>
      </tr>
      <tr>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><textarea name="textarea" style="width:200px;border:0px; overflow:hidden;height:25px;line-height:20px;" id="textarea" readonly="readonly"><?php echo $dataholder['strMarksAndNos']; ?></textarea></td>
          </tr>
        </table></td>
        <td colspan="5" class="border-left-fntsize12" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
          <tr>
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
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            </tr>
           
         
          <tr>
            <td width="20%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
          </tr>
        </table></td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td valign="top">&nbsp;</td>
        <td class="border-left-fntsize12" colspan="5">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td width="20%">&nbsp;</td>
        <td class="border-left-fntsize12" width="15%">&nbsp;</td>
        <td width="15%" class="border-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">PO#</span></td>
        <td width="10%" class="border-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">QTY/<?php echo $row_summary["strUnitID"];?></span></td>
        <td width="15%" class="border-bottom-fntsize12" style="text-align:center"><span class="normalfnth2B">&nbsp;</span></td>
        <td width="5%">&nbsp;</td>
        <td class="border-left-fntsize12" width="10%">&nbsp;</td>
        <td class="border-left-fntsize12" width="10%">&nbsp;</td>
      </tr>
      <?php 
	  /*$str_desc="select
					strDescOfGoods,
					strBuyerPONo,
					dblQuantity,
					dblUnitPrice,
					dblAmount,
					strISDno
					from
					invoicedetail					
					where 
					strInvoiceNo='$invoiceNo' order by intItemNo";*/
					$str_desc="SELECT
								invoicedetail.strDescOfGoods,
								invoicedetail.strBuyerPONo,
								invoicedetail.dblQuantity,
								invoicedetail.dblUnitPrice,
								invoicedetail.dblAmount,
								invoicedetail.strISDno,
								shipmentforecast_detail.strPackType
								FROM
								invoicedetail
								LEFT JOIN shipmentforecast_detail ON shipmentforecast_detail.strPoNo = invoicedetail.strBuyerPONo
								where 
								strInvoiceNo='$invoiceNo' order by intItemNo";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		while($row_desc=mysql_fetch_array($result_desc))
		{
			$packType=$row_desc["strPackType"];			
			$tot+=$row_desc["dblAmount"];
			$totqty+=$row_desc["dblQuantity"];
	  ?>
	  <tr>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:center" height="25"><span ><?php echo $row_desc["strDescOfGoods"];?></span></td>
        <td style="text-align:center"><?php echo $row_desc["strBuyerPONo"];?></td>
        <td style="text-align:right"><?php echo $row_desc["dblQuantity"];?></td>
        <td style="text-align:center">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:right"><span class="normalfnt"><?php echo number_format($row_desc["dblUnitPrice"],2);?></span></td>
        <td class="border-left-fntsize12" style="text-align:right"><span class="normalfnt"><?php echo number_format($row_desc["dblAmount"],2);?></span></td>
      </tr>
	  <?php }?>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-All-fntsize12" style="text-align:center"><span class="normalfnth2B"><?php echo $totqty;?></span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:right"><span class="normalfnt"><strong><?php echo number_format($tot,2);?></strong></span></td>
      </tr>
	   <?php 
  		$str_HS_summary="select 
						strUnitID,strDescOfGoods,strHSCode,sum(dblAmount) as totamt,sum(dblQuantity) as totqty
						from invoicedetail
						where strInvoiceNo ='$invoiceNo'
						group by strHSCode ";
  		$result_HS_summary=$db->RunQuery($str_HS_summary);
		while($row_HS_summary=mysql_fetch_array($result_HS_summary)){		
  ?>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize12"><?php echo summary_string($row_HS_summary["strHSCode"],'strDescOfGoods');?></td>
        <td nowrap="nowrap" colspan="2"><?php echo $dataholder['strCurrency']." ".number_format($row_HS_summary["totamt"],2);?></td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12" style="text-align:right">&nbsp;</td>
      </tr><?php }?>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
      </tr>
      <tr>
      		<td >&nbsp;</td>
            <td valign="top" class="border-left">HS CODE NO </td>
            <td colspan="4" rowspan="2" valign="top">
              <textarea name="textarea2" style="width:400px;border:0px; overflow:hidden;height:40px;" id="textarea2" readonly="readonly"><?php 
	  	$str_hs="select strHSCode,strFabrication,replace(strFabrication,' ','') as fabric					 
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
		}
	  ?></textarea></td>
      <td class="border-left">&nbsp;</td>
      <td class="border-left">&nbsp;</td>
      
      </tr>
      <tr>
      		<td>&nbsp;</td>
            <td valign="top" class="border-left">&nbsp;</td>
            <td class="border-left">&nbsp;</td>
            <td class="border-left">&nbsp;</td>
        </tr>
      <tr>
      <tr>
      		<td>&nbsp;</td>
            <td valign="top" class="border-left"><u>FABRIC</u> : </td>
            <td colspan="4" rowspan="2" valign="top"><textarea name="txtMarksnnosarea" style="width:400px;border:0px; overflow:hidden;height:150px;" id="txtMarksnnosarea" readonly="readonly"><?php echo $fabric; ?></textarea></td>
            <td class="border-left">&nbsp;</td>
            <td class="border-left">&nbsp;</td>
            </tr>
      <tr>
      
        <td>&nbsp;</td>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left">&nbsp;</td>
        <td colspan="1" class="border-left"><?php if ($type=='CIF'){?><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
          <tr>
            <td height="35">TOTAL CIF</td>
            <td style="text-align:right"><strong><?php echo number_format($tot,2);?></strong></td>
            </tr>
          <tr>
            <td height="20">INSURANCE</td>
            <td  style="text-align:right"><span class="normalfnth2B"><?php echo number_format(round($totqty*.03),2);?></span></td>
            </tr>
          <tr>
            <td height="20">FREIGHT</td>
            <td style="text-align:right"><span class="normalfnth2B" ><?php echo number_format(round($totqty*.07),2);?></span></td>
            </tr>
          <tr>
            <td width="50%" height="20">FOB</td>
            <td width="50%" class="border-top-bottom-fntsize10" style="text-align:right;border-bottom-style:double;border-bottom-width:3px;"><span class="normalfnth2B"><?php echo number_format(($tot-(round($totqty*.03))-round(($totqty*.07))),2);?></span></td>
            </tr>
        </table><?php }?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
      <?php $invNo=$dataholder['strInvoiceNo'];
	  		 $sql_GOH=" SELECT
							invoicedetail.strInvoiceNo,
							invoicedetail.dblGOHstatus,
							invoicedetail.strBuyerPONo,
							sum(invoicedetail.dblQuantity) as dblQty
							FROM
							invoicedetail
							WHERE
							invoicedetail.strInvoiceNo = '$invNo'";
		
				
	$result_goh=$db->RunQuery($sql_GOH);
	$goh=mysql_fetch_array($result_goh);	
	   ?>
        <td colspan="8" >
		<?php 
			{
				$poNo = $goh["strBuyerPONo"];
				$qty = $goh["dblQty"];
				if($goh['dblGOHstatus']==1)
					{
						echo "PO NO - ".$poNo. " - ". $qty." PCS - GSP A - APPLICABLE";
					}
			}
		
		?></td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        </tr>
        <tr> 
        <td>&nbsp;</td>
        </tr>
        <tr> 
        <td style="font-family:'Times New Roman', Times, serif">PURCHACE ORDER DESCRIPTION-</td>
        <td><?php echo $dataholder['strPo_des'];?></td>
        </tr>
        <tr> 
        <td>&nbsp;</td>
        </tr>
         <tr>      
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="font-family:'Times New Roman', Times, serif; font-size:11px; "></td>
        <td style="text-align:center; font-weight:bold">&nbsp;</td>
        <td style="text-align:center; font-weight:bold">&nbsp;</td>
        </tr>
        <tr>      
        <td style="font-family:'Times New Roman', Times, serif; font-size:11px">TOTAL NET WEIGHT </td>
        <td>: <?php echo $dataholder['dblGrossMass']." KGS";?></td>
        <td>&nbsp;</td>
        <td style="font-family:'Times New Roman', Times, serif; font-size:11px;" width="15%">&nbsp;</td>
        <td style="text-align:center">
        			
        
        
        </td>
        <?php $invNum=$dataholder['strInvoiceNo'];
			 $qty="SELECT
commercial_invoice_detail.strInvoiceNo,
sum(commercial_invoice_detail.dblQuantity) as quantity,
commercial_invoice_detail.dblAmount
FROM
commercial_invoice_detail
WHERE
commercial_invoice_detail.strInvoiceNo = '$invNum'
";

	$result_qty=$db->RunQuery($qty);
	 //echo $qty;
	$qty11=mysql_fetch_array($result_qty);
?>
        <td style="text-align:center">&nbsp;</td>
        </tr>
        <tr>
        <td style="font-family:'Times New Roman', Times, serif; font-size:11px">TOTAL GRS WEIGHT </td>
        <td>: <?php echo $dataholder['dblNetMass']." KGS";?></td>
        <td>&nbsp;</td>
        <td style="font-family:'Times New Roman', Times, serif; font-size:11px;">&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-align:center">&nbsp;</td>
        </tr>
        <tr>
        <td style="font-family:'Times New Roman', Times, serif; font-size:11px">TOTAL CBM </td>
        <td>: <?php echo $dataholder['strCBM'];?></td>
        <td>&nbsp;</td>
        <td style="font-family:'Times New Roman', Times, serif; font-size:11px;">&nbsp;</td>
        <td>&nbsp;</td>
        <td style="text-align:center">&nbsp;</td>
        </tr>
      
    </table></td>
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
