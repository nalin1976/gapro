<?php 
session_start();
$document='NI';
include "../../../../Connector.php";
$xmldoc=simplexml_load_file('../../../../config.xml');
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
					sum(invoicedetail.dblQuantity) AS dblQuantity, 
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
					invoicedetail.strSC_No,
					shipmentforecast_detail.strDeptNo,
					shipmentforecast_detail.intNOF_Ctns 
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
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>| NIKE |Commercial Invoice Final</title>
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
    <td class="normalfnt2bldBLACKmid"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
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
    <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="7"><div align="center">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="22%" class="border-top-left"><u><strong>Vendor</strong></u></td>
              <td width="16%" class="border-top-left">&nbsp;</td>
              <td colspan="4" class="border-top" style="font-weight:bold">INVOICE NO: <?php echo $dataholder['strInvoiceNo'];?></td>
              <td width="9%" class="border-top">&nbsp;</td>
              <td colspan="3" class="border-top-left" style="font-weight:bold">DATE : <?php echo $dataholder['dtmInvoiceDate'];?></td>
              </tr>
            <tr>
              <td rowspan="3" class="border-bottom-left">HELA CLOTHING (PVT) LTD NO309/11 NEGOMBO ROAD WELISARA COLOMBO</td>
              <td class="border-bottom-left">&nbsp;</td>
              <td width="8%" class="border-bottom">&nbsp;</td>
              <td width="8%" class="border-bottom">&nbsp;</td>
              <td width="7%" class="border-bottom">&nbsp;</td>
              <td colspan="2" class="border-bottom" style="font-weight:bold">SC NO: <?php echo $dataholder['strSC_No'];?></td>
              <td width="9%" class="border-bottom-left">&nbsp;</td>
              <td width="7%" class="border-bottom" >&nbsp;</td>
              <td width="6%" class="border-bottom-right">&nbsp;</td>
            </tr>
            <tr>
              <td class="border-left">&nbsp; </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td width="8%">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="border-right">&nbsp;</td>
            </tr>
            <tr>
              <td class="border-bottom-left">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom-left">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom-right">&nbsp;</td>
            </tr>
            <tr>
              <td class="border-left"><strong><u>Consignee</u></strong></td>
              <td class="border-left"><strong><u>Notify Party</u></strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td colspan="3" class="border-left" style="font-weight:bold">BOOKING NO</td>
              <?php 
			$bookingNum ="SELECT
commercial_invoice_header.strBookingNo,
commercial_invoice_header.strTransportMode
FROM
commercial_invoice_header
WHERE
commercial_invoice_header.strInvoiceNo = '$invoiceNo'";
$result_bn=$db->RunQuery($bookingNum);
						$bookinumber=mysql_fetch_array($result_bn);
		?>
              <td colspan="3" class="border-right">: <?php echo $bookinumber['strBookingNo'];?></td>
              </tr>
            <tr>
              <td rowspan="3" class="border-left"><div><?php echo $dataholder['BuyerAName'];?></div> <div><?php echo $dataholder['buyerAddress1'];?></div><div><?php echo $dataholder['buyerAddress2'];?></div><div><?php echo $dataholder['BuyerCountry'];?></div></td>
              <td colspan="3" rowspan="8" class="border-bottom-left"><div><?php echo $dataholder['BuyerAName'];?></div> <div><?php echo $dataholder['buyerAddress1'];?></div><div><?php echo $dataholder['buyerAddress2'];?></div><div><?php echo $dataholder['BuyerCountry'];?></div></td>
              <td colspan="3"  class="border-left" style="font-weight:bold">PROFILE ID</td>
              <td colspan="3" class="border-right">:</td>
              </tr>
            <tr>
              <td colspan="3"  class="border-left" style="font-weight:bold">UOM</td>
              <td colspan="3" class="border-right">:</td>
              </tr>
            <tr>
              <td colspan="3"  class="border-left" style="font-weight:bold">BUY GROUP</td>
              <td colspan="3" class="border-right">:</td>
              </tr>
            <tr>
              <td class="border-top-left"><strong><u>SHIP TO</u></strong></td>
              <td colspan="3"  class="border-left" style="font-weight:bold">SHIP-TO/PLANT</td>
              <td colspan="3" class="border-right">:</td>
              </tr>
            <tr>
              <td rowspan="4" class="border-bottom-left"><div><?php echo $dataholder['BuyerAName'];?></div> <div><?php echo $dataholder['buyerAddress1'];?></div><div><?php echo $dataholder['buyerAddress2'];?></div><div><?php echo $dataholder['BuyerCountry'];?></div></td>
              <td colspan="3"  class="border-left" style="font-weight:bold">DEST.REGION</td>
              <td colspan="3" class="border-right">:</td>
              </tr>
            <tr>
              <td colspan="3"  class="border-left" style="font-weight:bold">XGA</td>
              <td colspan="3" class="border-right">:</td>
              </tr>
            <tr>
              <td colspan="3"  class="border-left" style="font-weight:bold">COUNTRY OF ORIGION</td>
              <td colspan="3" class="border-right">: <?php echo $dataholder['strPortOfLoading'];?> </td> 
              </tr><tr>
              <td colspan="6" class="border-Left-bottom-right">&nbsp;</td>
              </tr>
            <tr>
              <td class="border-left" style="font-weight:bold"><div align="center">FLIGHT /VSL</div></td>
              <td colspan="3" class="border-left" style="font-weight:bold"><div align="center">SHIP DATE</div></td>
              <td colspan="3" class="border-left" style="font-weight:bold"><div align="center">P.O.ID</div></td>
              <td colspan="3" class="border-left-right" style="font-weight:bold"><div align="center">CAT</div></td>
              </tr> <tr>
              <td class="border-bottom-left"><?php echo $bookinumber['strTransportMode'];?></td>
              <td colspan="3" class="border-bottom-left"><?php echo $dataholder['dtmVesselDate'];?></td>
              <td colspan="3" class="border-bottom-left">&nbsp;</td>
              
              <td colspan="3" class="border-Left-bottom-right"><?php 
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
              </tr>
               <tr>
              <td class="border-left" style="font-weight:bold"><div align="center">FROM</div></td>
              <td colspan="3" class="border-left" style="font-weight:bold"><div align="center">TO</div></td>
              <td colspan="3" class="border-left" style="font-weight:bold"><div align="center">P.O.NO</div></td>
              <td colspan="3" class="border-left-right" style="font-weight:bold"><div align="center">P.O.TYPE</div></td>
              </tr> <tr>
              <td class="border-bottom-left"><?php echo $dataholder['strPortOfLoading']?></td>
              <td colspan="3" class="border-bottom-left"><?php echo strtoupper($dataholder['city']);?></td>
              <td colspan="3" class="border-bottom-left"><?php echo $dataholder["strBuyerPONo"];?></td>
              <td colspan="3" class="border-Left-bottom-right">&nbsp;</td>
              </tr>
             <tr>
              <td class="border-left" style="font-weight:bold"><div align="center">SHIPPING MARKS</div></td>
              <td colspan="5" style="font-weight:bold" ><div align="center">DESCRIPTION OF GOODS</div></td>
              <td rowspan="2" class="border-bottom-left" style="font-weight:bold"><div align="center">QTY</div></td>
              <td rowspan="2" class="border-bottom-left" style="font-weight:bold"><div align="center">UNIT PRICE FOB</div></td>
              <td colspan="2" rowspan="2" class="border-Left-bottom-right" style="font-weight:bold"><div align="center">TOTAL FOB</div></td>
              </tr>
             <tr>
              <td class="border-bottom-left">&nbsp;</td>
              <td colspan="5" class="border-bottom" style="font-weight:bold"><div align="right">MATERIAL CODE</div></td>
              </tr>
             <tr>
              <td class="border-left">CHENNAI, INDIA</td>
              <td colspan="5" class="border-left"><?php echo $dataholder['intNoOfCartons']; ?> <?php if($dataholder['intPackingMthd']=='1'){echo "CARTONS";} else if($dataholder['intPackingMthd']=='2') {echo "GOH";} ?>&nbsp;CONTAINING</td>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td colspan="2" class="border-left-right">&nbsp;</td>
              </tr>
              <tr>
              <td class="border-left">COUNTRY OF ORIGIN :</td>
              <td colspan="5" class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td colspan="2" class="border-left-right">&nbsp;</td>
              </tr>
            <tr>
              <td class="border-left">SRI LANKA</td>
              <?php 
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
			  
              <td colspan="5" class="border-left"><?php echo $row_desc["strDescOfGoods"];?></td>
              <td class="border-left" style="text-align:center"><?php echo $row_desc["dblQuantity"];?></td>
              <td class="border-left" style="text-align:center"><?php echo number_format($row_desc["dblUnitPrice"],2);?></td>
              <td colspan="2" class="border-left-right" style="text-align:center"><?php echo number_format($row_desc["dblAmount"],2);?></td>
              </tr>
              <?php } ?>
            <tr>
              <td class="border-left">&nbsp;</td>
              <td colspan="5" class="border-left"> &nbsp; <?php 
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
			 $row_hs["strHSCode"];
			echo $fabric.=$row_hs["strFabrication"];
			$boo_count=1;
		}
	  ?></td>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td colspan="2" class="border-left-right">&nbsp;</td>
              </tr>
              <tr>
              <td class="border-left">&nbsp;</td>
              <td colspan="5" class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td colspan="2" class="border-left-right">&nbsp;</td>
              </tr>
              <tr>
              <td class="border-left">&nbsp;</td>
              <td colspan="5" class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td colspan="2" class="border-left-right">&nbsp;</td>
              </tr>
              <tr>
              <td class="border-left">&nbsp;</td>
              <td colspan="5" class="border-left"><?php 
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
	  ?></td>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td colspan="2" class="border-left-right">&nbsp;</td>
              </tr>
              <tr>
              <td class="border-left">&nbsp;</td>
              <td colspan="5" class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td colspan="2" class="border-left-right">&nbsp;</td>
              </tr><tr>
              <td class="border-left">&nbsp;</td>
              <td colspan="5" class="border-left">LINE ITEM :</td>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td colspan="2" class="border-left-right">&nbsp;</td>
              </tr>
              <?php 
			  		$invNum=$dataholder['strInvoiceNo'];
			 $qty="SELECT
commercial_invoice_detail.strInvoiceNo,
sum(commercial_invoice_detail.dblQuantity) as quantity,
sum(commercial_invoice_detail.intNoOfCTns) as qtyOFcarton,
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
          <tr>
          <td class="border-left">&nbsp;</td>
          <td colspan="5" class="border-left">&nbsp;&nbsp;&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td colspan="2" class="border-left-right">&nbsp;</td>
              </tr>
              <tr>
              <td class="border-left">&nbsp;</td>
              <td colspan="5" class="border-left">&nbsp;&nbsp;&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td colspan="2" class="border-left-right">&nbsp;</td>
              </tr>
              <tr>
              <td class="border-left">&nbsp;</td>
              <td colspan="5" class="border-left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td colspan="2" class="border-left-right">&nbsp;</td>
              </tr>
              <tr>
              <td class="border-left">&nbsp;</td>
              <td colspan="5" class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td colspan="2" class="border-left-right">&nbsp;</td>
              </tr>
              <tr>
              <td class="border-left">&nbsp;</td>
              <td colspan="5" class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td colspan="2" class="border-left-right">&nbsp;</td>
              </tr>
            <tr>
              <td class="border-bottom-left" style="font-weight:bold">TOTAL</td>
              <td colspan="5" class="border-bottom-left" style="font-weight:bold">MASTER PO ID #</td>
              <td class="border-bottom-left">&nbsp;</td>
              <td class="border-bottom-left">&nbsp;</td>
              <td colspan="2" class="border-Left-bottom-right">&nbsp;</td>
              </tr>
            <tr>
              <td colspan="6" class="border-bottom-left" style="font-weight:bold">TOTAL</td>
              <td colspan="2"  class="border-bottom-right" style="text-align:left"><?php echo $totqty;?></td>
              <td colspan="2"   class="border-Left-bottom-right" style="text-align:center"><?php echo number_format($tot,2);?></td>
              </tr>
            <tr>
              <td colspan="8" class="border-bottom-left" style="font-weight:bold">US $</td>
              <td colspan="2" class="border-Left-bottom-right">&nbsp;</td>
              </tr>
            <tr>
              <td class="border-bottom-left" style="font-weight:bold">GROSS WEIGHT</td>
              <td colspan="5" class="border-bottom-left" style="font-weight:bold; text-align:center">&nbsp;&nbsp;&nbsp; TOTAL SIZE WISE BREAKDOWN</td>
              <td colspan="4" class="border-bottom-right" style="font-weight:bold; text-align:center">TOTAL</td>
              </tr>
              <tr>
              <td class="border-left" style="text-align:center"><?php echo $dataholder['dblGrossMass']." KG";?></td>
              <td class="border-bottom-left" style="font-weight:bold">&nbsp;&nbsp;MATERIAL CODE</td>
              <td class="border-bottom" style="font-weight:bold; text-align:center">S</td>
              <td class="border-bottom" style="font-weight:bold; text-align:center">M</td>
              <td class="border-bottom" style="font-weight:bold; text-align:center">L</td>
              <td class="border-bottom" style="font-weight:bold; text-align:center">XL</td>
              <td class="border-bottom" style="font-weight:bold; text-align:center">XXL</td>
              <td class="border-bottom">&nbsp;</td>
              <td colspan="2" class="border-bottom-right" style="font-weight:bold; text-align:center">UNITS</td>
              </tr>
              <tr>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="border-right">&nbsp;</td>
            </tr>
              <tr>
              <td class="border-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="border-right">&nbsp;</td>
            </tr>  <tr>
              <td class="border-left">&nbsp;</td>
              <td class="border-bottom-left">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom-right">&nbsp;</td>
            </tr>
              <tr>
              <td class="border-bottom-left">&nbsp;</td>
              <td class="border-bottom-left" style="font-weight:bold">TOTAL</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom-right">&nbsp;</td>
            </tr>
             
              <tr>
              <td class="border-bottom-left" style="font-weight:bold"><div align="center">NET WEIGHT</div></td>
              <td colspan="9" class="border-Left-bottom-right" style="font-weight:bold"><div align="left">&nbsp;&nbsp;NET NET WEIGHT BREAKDOWN</div></td>
              </tr>
              <tr>
              <td class="border-bottom-left" style="text-align:center"><?php echo $dataholder['dblNetMass']." KG";?></td>
              <td colspan="9" class="border-left-right">&nbsp;</td>
              </tr>  <tr>
              <td class="border-bottom-left"><strong>Actual Manufacture Identification</strong></td>
              <td class="border-left">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="border-right">&nbsp;</td>
            </tr>
             <tr>
              <td rowspan="5" class="border-bottom-left">&nbsp;</td>
              <td class="border-left">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="border-right">&nbsp;</td>
            </tr>
             <tr>
              <td class="border-left">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="border-right">&nbsp;</td>
            </tr>
             <tr>
              <td class="border-left">&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="border-right">&nbsp;</td>
            </tr>
             <tr>
              <td class="border-bottom-left">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom-right">&nbsp;</td>
            </tr> <tr>
              <td class="border-bottom-left" style="font-weight:bold">TOTAL</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom">&nbsp;</td>
              <td class="border-bottom-right">&nbsp;</td>
            </tr> 
             <tr>
              <td class="border-bottom-left" style="font-weight:bold"> <div align="center">M.A.W.B.NO</div></td>
              <td colspan="9" class="border-Left-bottom-right" style="font-weight:bold"><div align="center">H.A.W.B.NO</div></td>
              </tr> 
            
          </table>
       </td>
        </tr>
      <tr>
        
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
