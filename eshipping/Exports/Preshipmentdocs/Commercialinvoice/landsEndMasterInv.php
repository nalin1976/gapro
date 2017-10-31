<?php 
	session_start();
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
$Vat=$xmldoc->companySettings->Vat;

$masInvNo=$_GET['masInvNo'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LandEndMasterInv</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="4">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td width="243">&nbsp;</td>
    <td width="150">&nbsp;</td>
    <td width="41">&nbsp;</td>
    <td width="49">&nbsp;</td>
    <td width="176">&nbsp;</td>
    <td width="68">&nbsp;</td>
    <td width="98">&nbsp;</td>
    <td width="195">&nbsp;</td>
    <td width="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="11" class="border-top-left" style="text-align:center"><span class="normalfnBLD1"><?php echo $Company; ?></span></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="11" class="border-left" style="text-align:center"><span class="normalfnBLD1"><?php echo $Address; ?></span></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="11" class="border-left" style="text-align:center"><span class="normalfnBLD1"><?php echo $City; ?></span></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="11" class="border-left" style="text-align:center"><span class="normalfnBLD1">TEL: <?php echo $phone; ?>  FAX: <?php echo $Fax; ?></span></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="11" class="border-left" style="text-align:center">COMMERCIAL INVOICE</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <?php
  	$sql_Inv_header="SELECT DISTINCT
customers.strName As manufacName,
customers.strMLocation,
commercial_invoice_header.strInvoiceNo,
customers.strCompanyCode,
date(commercial_invoice_header.dtmInvoiceDate) AS dtmInvoiceDate,
customers.strAddress1 AS manufacAddress1,
customers.strAddress2 AS manufacAddress2,
customers.strCountry AS manufacCountry,
b.strName,
b.strAddress1,
b.strAddress2,
b.strAddress3,
b.strCountry,
a.strName AS accounteeName,
a.strAddress1 AS accounteeAdd1,
a.strAddress2 AS accounteeAdd2,
a.strAddress3 AS accounteeAdd3,
a.strCountry AS accounteeCountry,
commercial_invoice_header.strPortOfLoading,
commercial_invoice_header.strIncoterms,
city.strPortOfLoading AS strPortOfDischarge,
city.strCity AS strFinalDestination,
commercial_invoice_header.strCarrier,
round(sum(commercial_invoice_detail.dblNetMass),2) AS sumNet,
round(sum(commercial_invoice_detail.dblGrossMass),2) AS sumGross,
commercial_invoice_header.dtmETA,
Sum(commercial_invoice_detail.intNoOfCTns) AS intNoOfCTns,
Sum(commercial_invoice_detail.dblQuantity) AS sumPcs,
commercialinvformat.strCommercialInv,
commercialinvformat.strMMLine1,
commercialinvformat.strMMLine2,
commercialinvformat.strMMLine3,
commercialinvformat.strMMLine4,
commercialinvformat.strMMLine5,
commercialinvformat.strMMLine6,
commercialinvformat.strMMLine7,
commercialinvformat.strSMLine1,
commercialinvformat.strSMLine2,
commercialinvformat.strSMLine3,
commercialinvformat.strSMLine4,
commercialinvformat.strSMLine5,
commercialinvformat.strSMLine6,
commercialinvformat.strSMLine7,
intCommercialInvId,
bank.strName AS bankName,
bank.strAddress1 AS bankAddress1,
bank.strAddress2 AS bankAddress2,
bank.strCountry As bankCountry,
bank.strSwiftCode,
bank.strAccName AS bankAccNo,
DATE(commercial_invoice_header.dtmInvoiceDate) As dtmInvoiceDate
FROM
commercial_invoice_header
INNER JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
INNER JOIN customers ON customers.strCustomerID = commercial_invoice_header.strCompanyID
INNER JOIN buyers AS b ON b.strBuyerID = commercial_invoice_header.strBuyerID
LEFT JOIN buyers AS a ON a.strBuyerID = commercial_invoice_header.strAccounteeId
INNER JOIN city ON city.strCityCode = commercial_invoice_header.strFinalDest
INNER JOIN commercialinvformat ON commercialinvformat.intCommercialInvId = commercial_invoice_header.strComInvFormat
LEFT JOIN bank ON bank.strBankCode = commercial_invoice_header.intBankId
WHERE commercial_invoice_header.strInvoiceNo='$masInvNo'
GROUP BY commercial_invoice_header.strInvoiceNo

						";
						
		$result_Inv_header=$db->RunQuery($sql_Inv_header);
		$row_Inv_header=mysql_fetch_array($result_Inv_header);
  ?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-top-left" style="text-align:left"><span class="normalfnBLD1">SHIPPER:</span></td>
    <td colspan="6" class="border-top-left" style="text-align:left">INVOICE # : <span class="normalfnBLD1"><?php echo $masInvNo; ?></span></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-left" style="text-align:left">EAM Maliban Textiles (PVT) Ltd</td>
    <td colspan="6" class="border-left" style="text-align:left">DATE: <?php echo $row_Inv_header['dtmInvoiceDate']; ?></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-left" style="text-align:left">261,Siri Dhamma Mawatha,</td>
    <td colspan="6" class="border-left" style="text-align:left"><span class="normalfnBLD1">LOCATION OF STUFFING &amp; LOADING: FTY.CODE <?php echo $row_Inv_header['factoryCode']; ?></span></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-left" style="text-align:left">Colombo 10,</td>
    <td class="border-top-left" style="text-align:left"><span class="normalfnBLD1">FROM:</span></td>
    <td colspan="5" class="border-top" style="text-align:left"><?php echo $row_Inv_header['strPortOfLoading']; ?></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-left" style="text-align:left">Sri Lanka</td>
    <td class="border-left" style="text-align:left">&nbsp;</td>
    <td colspan="5" class="normalfnt" style="text-align:left">SRI LANKA</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-top-left" style="text-align:left"><span class="normalfnBLD1">SHIP TO : (CONSIGNEE)</span></td>
    <td colspan="3" class="border-left" style="text-align:left"><span class="normalfnBLD1">TERMS OF SALES</span></td>
    <td colspan="3" class="normalfnt" style="text-align:left"><?php echo $row_Inv_header['strIncoterms']; ?>-SRI LANKA</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-left" style="text-align:left"><?php echo $row_Inv_header['strName']; ?></td>
    <td colspan="6" class="border-top-left" style="text-align:left">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-left" style="text-align:left"><?php echo $row_Inv_header['strAddress1']; ?></td>
    <td colspan="3" class="border-left" style="text-align:left"><span class="normalfnBLD1">PAYMENT TERMS:</span></td>
    <td colspan="3" class="normalfnt" style="text-align:left">PAYMENT BY TT</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-left" style="text-align:left"><?php echo $row_Inv_header['strAddress2']; ?></td>
    <td colspan="5" class="border-left" style="text-align:left"><span class="normalfnBLD1">DATE OF EXPORT FROM SRI LANKA : </span></td>
    <td class="normalfnt" style="text-align:left"><?php echo $row_Inv_header['dtmETA']; ?></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-left" style="text-align:left"><?php echo $row_Inv_header['strCountry']; ?></td>
    <td colspan="6" class="border-left" style="text-align:left">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-top-left" style="text-align:left"><span class="normalfnBLD1">BILL TO :</span></td>
    <td colspan="6" class="border-top-left" style="text-align:left"><span class="normalfnBLD1">MANUFACTURER'S NAME &amp; ADDRESS</span></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-left" style="text-align:left">ACCOUNTS DEPT</td>
    <td colspan="6" class="border-left" style="text-align:left"><?php echo $row_Inv_header['manufacName']; ?></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-left" style="text-align:left"><?php echo $row_Inv_header['accounteeName']; ?></td>
    <td colspan="6" class="border-left" style="text-align:left"><?php echo $row_Inv_header['manufacAddress1']; ?></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-left" style="text-align:left"><?php echo $row_Inv_header['accounteeAdd1']; ?></td>
    <td colspan="6" class="border-left" style="text-align:left"><?php echo $row_Inv_header['manufacAddress2']; ?></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-left" style="text-align:left"><?php echo $row_Inv_header['accounteeAdd2']; ?></td>
    <td colspan="6" class="border-left" style="text-align:left"><?php echo $row_Inv_header['manufacCountry']; ?></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5" class="border-left" style="text-align:left"><?php echo $row_Inv_header['accounteeCountry']; ?></td>
    <td colspan="6" class="border-left" style="text-align:left">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="border-top-left" style="text-align:left"><span class="normalfnBLD1">PORT OF DISCHARGE</span></td>
    <td colspan="2" class="border-top-left" style="text-align:left"><span class="normalfnBLD1">FINAL DESTINATION</span></td>
    <td colspan="3" class="border-top-left" style="text-align:left"><span class="normalfnBLD1">LK EAM MAL COL</span></td>
    <td colspan="2" class="border-top" style="text-align:RIGHT"><span class="normalfnBLD1">FTY CODE:</span></td>
    <td class="border-top" style="text-align:left"><span class="normalfnBLD1"><?php echo $row_Inv_header['factoryCode']; ?></span></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="border-left" style="text-align:left"><span class="normalfnt"><?php echo $row_Inv_header['strPortOfDischarge']; ?></span></td>
    <td colspan="2" class="border-left" style="text-align:left"><span class="normalfnt"><?php echo $row_Inv_header['strFinalDestination']; ?></span></td>
    <td colspan="2" class="border-top-left" style="text-align:left"><span class="normalfnBLD1">NET WEIGHT:</span></td>
    <td class="border-top" style="text-align:left"><span class="normalfnBLD1"><?php echo $row_Inv_header['sumNet']; ?>KG</span></td>
    <td colspan="2" class="border-top-left" style="text-align:right"><span class="normalfnBLD1">GROSS WT:</span></td>
    <td class="border-top" style="text-align:left"><span class="normalfnBLD1"><?php echo round($row_Inv_header['sumGross'],2); ?>KGS</span></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="border-top-left" style="text-align:left"><span class="normalfnBLD1">CARRIER</span></td>
    <td colspan="2" class="border-top-left" style="text-align:left"><span class="normalfnBLD1">SAILING ON OR ABT</span></td>
    <td colspan="6" class="border-top-left" style="text-align:left">"GOODS ARE PACKED IN COUNTRY SRI LANKA</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="border-left" style="text-align:left"><?php echo $row_Inv_header['strCarrier']; ?></td>
    <td colspan="2" class="border-left" style="text-align:left"><?php echo $row_Inv_header['dtmETA']; ?></td>
    <td colspan="6" class="border-left" style="text-align:left">FOR FINAL EXPORT TO THE US&quot;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="border-top-left" style="text-align:center"><span class="normalfnBLD1" style="font-size:9px">Marks and Nos</span></td>
    <td colspan="8" class="border-top" style="text-align:left"><span class=" normalfnBLD1">FULL DESCRIPTION</span></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="border-left" style="text-align:center">&nbsp;</td>
    <td colspan="8" class="" style="text-align:left">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="normalfnt">&nbsp;</td>
        </tr>
       <?php
	    $invFormat=$row_Inv_header['intCommercialInvId'];
		
		$sql_marks="SELECT
						commercialinvformat.strMMLine1,
						commercialinvformat.strMMLine2,
						commercialinvformat.strMMLine3,
						commercialinvformat.strMMLine4,
						commercialinvformat.strMMLine5,
						commercialinvformat.strMMLine6,
						commercialinvformat.strMMLine7,
						commercialinvformat.strSMLine1,
						commercialinvformat.strSMLine2,
						commercialinvformat.strSMLine3,
						commercialinvformat.strSMLine4,
						commercialinvformat.strSMLine5,
						commercialinvformat.strSMLine6,
						commercialinvformat.strSMLine7
						FROM
						commercialinvformat
						WHERE
						intCommercialInvId=$invFormat";
						
		$result_marks=$db->RunQuery($sql_marks);
		$row_marks=mysql_fetch_array($result_marks);
	   ?>
      <tr>
        <td class="normalfnt"><?php echo $row_marks['strMMLine1']; ?></td>
        </tr>
      <tr>
        <td class="normalfnt"><?php echo $row_marks['strMMLine2']; ?></td>
        </tr>
      <tr>
        <td class="normalfnt"><?php echo $row_marks['strMMLine3']; ?></td>
        </tr>
      <tr>
        <td class="normalfnt"><?php echo $row_marks['strMMLine4']; ?></td>
        </tr>
      <tr>
        <td class="normalfnt"><?php echo $row_marks['strMMLine5']; ?></td>
        </tr>
      <tr>
        <td class="normalfnt"><?php echo $row_marks['strMMLine6']; ?></td>
        </tr>
      <tr>
        <td class="normalfnt"><p><?php echo $row_marks['strMMLine7']; ?></p>
          <p>&nbsp;</p></td>
        </tr>
      <tr>
        <td class="normalfnt"><?php echo $row_marks['strSMLine1']; ?></td>
        </tr>
      <tr>
        <td class="normalfnt"><?php echo $row_marks['strSMLine2']; ?></td>
        </tr>
      <tr>
        <td class="normalfnt"><?php echo $row_marks['strSMLine3']; ?></td>
      </tr>
      <tr>
        <td class="normalfnt"><?php echo $row_marks['strSMLine4']; ?></td>
      </tr>
      <tr>
        <td class="normalfnt"><?php echo $row_marks['strSMLine5']; ?></td>
      </tr>
      <tr>
        <td class="normalfnt"><?php echo $row_marks['strSMLine6']; ?></td>
      </tr>
      <tr>
        <td class="normalfnt"><?php echo $row_marks['strSMLine7']; ?></td>
      </tr>
    </table></td>
    <td colspan="8" class="" style="text-align:left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="31%" class="normalfnBLD1"><?php echo $row_Inv_header['noOfCtns']; ?> CTNS CONTAINING <?php echo $row_Inv_header['sumPcs'] ?> PCS</td>
        <td width="11%">&nbsp;</td>
        <td width="8%">&nbsp;</td>
        <td width="7%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="8%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        </tr>
      <tr>
        <td class="normalfnBLD1">&nbsp;</td>
        <td class="normalfnBLD1" style="text-align:center">OUR INV #</td>
        <td class="normalfnBLD1" style="text-align:center">P.O #</td>
        <td class="normalfnBLD1" style="text-align:center">CTNS </td>
        <td class="normalfnBLD1" style="text-align:center">STYLE #</td>
        <td class="normalfnBLD1" style="text-align:center">PCS</td>
        <td class="normalfnBLD1" style="text-align:center">UNIT PRICE</td>
        <td class="normalfnBLD1" style="text-align:center">AMOUNT USD</td>
        </tr>
      <?php
	  $sql_inv_det="SELECT
commercial_invoice_detail.strBuyerPONo,
commercial_invoice_detail.strDescOfGoods,
Sum(commercial_invoice_detail.dblQuantity) AS dblQuantity,
commercial_invoice_detail.strStyleID,
ROUND(SUM(commercial_invoice_detail.dblAmount),2) AS dblAmount,
ROUND(SUM(commercial_invoice_detail.dblGrossMass),2) AS dblGrossMass,
ROUND(SUM(commercial_invoice_detail.dblNetMass),2) AS dblNetMass,
Sum(commercial_invoice_detail.intNoOfCTns) AS intNoOfCTns,
commercial_invoice_detail.strFabric,
commercial_invoice_detail.dblUnitPrice,
cdn_detail.strInvoiceNo,
invoiceheader.intShellBox
FROM
commercial_invoice_detail
INNER JOIN cdn_detail ON cdn_detail.strBuyerPONo = commercial_invoice_detail.strBuyerPONo
INNER JOIN invoiceheader ON invoiceheader.strInvoiceNo = cdn_detail.strInvoiceNo
WHERE commercial_invoice_detail.strInvoiceNo='$masInvNo'
GROUP BY commercial_invoice_detail.strBuyerPONo
";
	$result_Inv_det=$db->RunQuery($sql_inv_det);
	while($row_Inv_det=mysql_fetch_array($result_Inv_det))
	{
	  ?>
      <tr>
        <td class="normalfnBLD1">&nbsp;</td>
        <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
        <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
        <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
        <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
        <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
        <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
        <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
        </tr>
      <tr>
        <td class="normalfnt"><?php echo $row_Inv_det['strDescOfGoods']; ?></td>
        <td class="normalfnt" style="text-align:center"><?php echo $row_Inv_det['strInvoiceNo']; ?></td>
        <td class="normalfnt" style="text-align:center"><?php echo $row_Inv_det['strBuyerPONo']; ?></td>
        <td class="normalfnt" style="text-align:center"><?php echo $row_Inv_det['intNoOfCTns']; ?></td>
        <td class="normalfnt" style="text-align:center"><?php echo $row_Inv_det['strStyleID']; ?></td>
        <td class="normalfnt" style="text-align:center"><?php echo $row_Inv_det['dblQuantity'];$totPcs+=$row_Inv_det['dblQuantity']; ?></td>
        <td class="normalfnt" style="text-align:center"><?php echo $row_Inv_det['dblUnitPrice']; ?></td>
        <td class="normalfnt" style="text-align:center">$<?php echo number_format($row_Inv_det['dblAmount'],2);$totAmt+=$row_Inv_det['dblAmount']; ?></td>
        </tr>
      <tr>
        <td colspan="3" class="normalfnt"><?php echo $row_Inv_det['strFabric']; ?></td>
        <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
        <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
        <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
        <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
        <td class="normalfnBLD1" style="text-align:center">&nbsp;</td>
        </tr>
        <?php
		if($row_Inv_det['intShellBox']==1)
		{
		?>
      <tr>
        <td class="normalfnt" bgcolor="#CCCCCC">Common Name: Trochus</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt" nowrap="nowrap" bgcolor="#CCCCCC">Scientific Name: Tectus Niloticus</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
      </tr>
      <?php
		}
	  ?>
      <?php
	}
	?>
    </table></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">&nbsp;</td>
    <td colspan="8" class="normalfnt" style="text-align:left" valign="top"><?php 
		include "../../../Reports/numbertotext.php";
		$mat_array=explode(".",number_format($totPcs,2));
		echo convert_number($totPcs);
		echo " PIECES ONLY.";
		?></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">&nbsp;</td>
    <td colspan="8" class="normalfnt" style="text-align:left" valign="top">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">&nbsp;</td>
    <td colspan="8" class="normalfnt" style="text-align:left" valign="top">AMOUNT PAYABLE US DOLLARS <?php 
		include "../../../../../../Reports/numbertotext.php";
		$mat_array=explode(".",number_format($totAmt,2));
		echo convert_number($totAmt);
		echo $mat_array[1]!="00"?" AND ".convert_number($mat_array[1])." CENTS ONLY.":" ONLY.";
		?></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">&nbsp;</td>
    <td class="normalfnt" style="text-align:left" valign="top">&nbsp;</td>
    <td class="normalfnt" style="text-align:left" valign="top">&nbsp;</td>
    <td class="normalfnt" style="text-align:left" valign="top">&nbsp;</td>
    <td class="normalfnt" style="text-align:left" valign="top">&nbsp;</td>
    <td class="normalfnt" style="text-align:left" valign="top">&nbsp;</td>
    <td colspan="2" valign="top" class="normalfnt" style="text-align:left">TOTAL</td>
    <td class="border-top-bottom" style="text-align:center" valign="top">$<?php echo number_format($totAmt,2); ?></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">&nbsp;</td>
    <td colspan="5" valign="top" class="normalfnt" style="text-align:left">&nbsp;</td>
    <td colspan="2" valign="top" class="normalfnt" style="text-align:left">&nbsp;</td>
    <td class="border-top" style="text-align:left" valign="top">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">&nbsp;</td>
    <td colspan="5" valign="top" class="normalfnt" style="text-align:left">&nbsp;</td>
    <td colspan="2" valign="top" class="normalfnt" style="text-align:left">&nbsp;</td>
    <td class="" style="text-align:left" valign="top">&nbsp;</td>

    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">&nbsp;</td>
    <td colspan="8" valign="top" class="normalfnBLD1" style="text-align:left">PLEASE MAKE THE PAYMENT BY TT DIRECT TO <?php echo $row_Inv_header['bankName']; ?></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">&nbsp;</td>
    <td colspan="8" valign="top" class="normalfnBLD1" style="text-align:left"><?php echo $row_Inv_header['bankAddress1']; ?>, <?php echo $row_Inv_header['bankAddress2']; ?>, <?php echo $row_Inv_header['bankCountry']; ?>.SWIFT CODE <?php echo $row_Inv_header['strSwiftCode']; ?></td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">&nbsp;</td>
    <td colspan="8" valign="top" class="normalfnBLD1" style="text-align:left"> BANK A/C # <?php echo $row_Inv_header['bankAccNo']; ?> &amp; BENIFICIARY EAM MALIBAN TEXTILES PVT LTD.</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">&nbsp;</td>
    <td colspan="8" valign="top" class="normalfnBLD1" style="text-align:left">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">&nbsp;</td>
    <td colspan="8" valign="top" class="normalfnBLD1" style="text-align:left">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">&nbsp;</td>
    <td colspan="8" valign="top" class="normalfnBLD1" style="text-align:left">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="23" class="border-left" style="text-align:center">&nbsp;</td>
    <td width="158" class="dotborder-bottom" style="text-align:center">&nbsp;</td>
    <td width="23" class="" style="text-align:center">&nbsp;</td>
    <td colspan="8" valign="top" class="normalfnBLD1" style="text-align:left">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">IQBAL MOOSA</td>
    <td colspan="8" valign="top" class="normalfnBLD1" style="text-align:left">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">EXPORT MANAGER</td>
    <td colspan="8" valign="top" class="normalfnBLD1" style="text-align:left">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" class="border-left" style="text-align:center">&nbsp;</td>
    <td colspan="8" valign="top" class="normalfnBLD1" style="text-align:left">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="11" valign="top" class="border-bottom-left" style="text-align:center">&nbsp;</td>
    <td class="border-left">&nbsp;</td>
  </tr>
</table>

</body>
</html>