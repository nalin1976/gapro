<?php 

session_start();
$document='NI';
include "../../../../Connector.php";
include 'common_report.php';
$xmldoc=simplexml_load_file('../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
$Com_TinNo=$xmldoc->companySettings->TinNo;

$invoiceNo=$_GET['InvoiceNo'];

include("invoice_queries.php");	


$factoryId = $_SESSION["FactoryID"];
$checkDate	= $_GET["CheckDate"];
$dateFrom	= $_GET["DateFrom"];
$dateTo	    = $_GET["DateTo"];
$buyerId	= $_GET["BuyerId"];
$invoNoFrom	= $_GET["InvoNoFrom"];
$InvoNoTo	= $_GET["InvoNoTo"];
        			
				 $forwader="SELECT
							forwaders.strName,
							forwaders.strAddress1,
							forwaders.strAddress2,
							forwaders.strCountry,
							commercial_invoice_header.strBookingNo
							FROM
							forwaders
							INNER JOIN commercial_invoice_header ON forwaders.intForwaderID = commercial_invoice_header.strForwader
							WHERE
							commercial_invoice_header.strInvoiceNo = '$invoiceNo'";
		$result_forwdr=$db->RunQuery($forwader);
		$dataforwdr=mysql_fetch_array($result_forwdr);
				
		

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>| M&amp;S | Guarantee Later For Late Delivery |</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2"><div align="center"><strong>HELA CLOTHING (PVT)LTD</strong></div></td>
  </tr>
  <tr>
    <td><table width="997" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="146">TELEPHONE</td>
        <td width="686">: 011-4791888</td>
        <td width="153">304, 1st FLOOR,</td>
      </tr>
      <tr>
        <td width="146">FAX</td>
        <td width="686">: 011-4791800</td>
        <td>GRACE LAND BUILDING,</td>
        </tr>
      <tr>
        <td width="146">EMAIL ADDRESS</td>
        <td width="686">: <u>kolitha@helaclothing.com</u></td>
        <td>NEGOMBO ROAD,</td>
        </tr>
      <tr>
        <td width="146">&nbsp;</td>
        <td width="686">&nbsp;</td>
        <td>PELIYAGODA</td>
        </tr>
      <tr>
        <td width="146">&nbsp;</td>
        <td width="686">&nbsp;</td>
        <td>SRI LANKA</td>
      </tr>
      <tr>
        <td width="146"><b><i>
          <?php 
		echo date("d,m,y");?>
        </i></b></td>
        <td width="686">&nbsp;</td>
        <td width="153">&nbsp;</td>
      </tr>
      <tr>
        <td width="146"></td>
        <td width="686">&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td width="146"><b><i>THE MANAGER,</i></b></td>
        <td width="686">&nbsp;</td>
        <td>,</td>
        </tr>
      <tr>
        <td width="146"><b><i>NO 709/17 </i></b></td>
        <td width="686">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    
      <tr>
     
        <td width="146"><b><i>LIYANGEMULLA</i></b></td>
        <td width="686">&nbsp;</td>
        <td width="153">&nbsp;</td>
      </tr>
      <tr>
        <td width="146"><b><i>SEEDUWA</i></b></td>
        <td width="686">&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td width="146"><b><i>JA-ELA</i></b></td>
        <td width="686">&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td width="146">&nbsp;</td>
        <td align="center" class="head2"><u><strong>Guarantee Letter For Late Delivery</strong></u></td>
        
        <td>&nbsp;</td>
      </tr>
      <?php
			     $guaranteeDetail="SELECT
						invoicedetail.strBuyerPONo,
						invoicedetail.strStyleID,
						shipmentforecast_detail.dtmFOBdate,
						invoiceheader.strVoyegeNo,
						invoiceheader.strVesselName
						FROM
						invoicedetail
						INNER JOIN invoiceheader ON invoiceheader.strInvoiceNo = invoicedetail.strInvoiceNo
						LEFT JOIN shipmentforecast_detail ON shipmentforecast_detail.strSC_No = invoicedetail.strSC_No
						WHERE
						invoiceheader.strInvoiceNo = '$invoiceNo'";
							  
								$result_guarantee=$db->RunQuery($guaranteeDetail);
								$dataguarantee=mysql_fetch_array($result_guarantee);
	  ?>
      <tr>
        <td width="146">&nbsp;</td>
        <td width="686">&nbsp;</td>
        <td width="153">&nbsp;</td>
      </tr>
      <tr>
        <td width="146">P.O.</td>
        <td width="686">: <?php echo $dataguarantee['strBuyerPONo'];?></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td width="146">Stoke No</td>
        <td width="686">: <?php echo $dataguarantee['strStyleID'];?></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td width="146">Vessel / Voy</td>
        <td width="686">: <?php echo $dataguarantee['strVesselName']."/".$dataguarantee['strVoyegeNo'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="146">FOB Date</td>
        <td width="686">: <?php echo $dataguarantee['dtmFOBdate'];?></td>
        <td width="153">&nbsp;</td>
      </tr>
      <tr>
        <td width="146">------------------------</td>
        <td width="686">----------------------------------------------</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td width="146">&nbsp;</td>
        <td width="686">&nbsp; </td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="3" class="normalfnt2Black"><p>This is to inform you that we have got approval to deliver the above mentioned PO for the above
          vessal from APLL under Booking NO <b><?php echo $dataforwdr['strBookingNo']; ?></b> and sending herewith cargo for consolidation.
          
          <br>
          <br>
          Please be kind enough to make necessary arrangements to unload the above mentioned consignment at your whrehouse.
          <br>
          <br>
          We agree that unloading goods will not make APLL/GTL liable for any costs / claims arising from delays and non shipment of goods on scheduled vessel due to non
          <br>
          
          conformance of delivary  slot, documentation
          deficiencies ,non conformation toM &amp; S requirements of goods delivered ,C N I / Firwall procedures, lack of container space due to late deliverey and cargo shut out.</p>
          <p>We undertake to bear any cost /claim incurred by M &amp; S, APLL or GTL ,including late delivery charges,charges for handling rejected shipments and charges for storage exceeding 14 days.</p>
          <p>Thank you,</p></td>
        </tr>
      <tr>
        <td width="146">&nbsp;</td>
        <td width="686">&nbsp;</td>
        <td width="153">&nbsp;</td>
      </tr>
      <tr>
        <td width="146">&nbsp;</td>
        <td width="686">&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>