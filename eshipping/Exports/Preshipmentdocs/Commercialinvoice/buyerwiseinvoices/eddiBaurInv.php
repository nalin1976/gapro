<?php 
session_start();
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
$invoiceNo=$_GET['InvoiceNo'];
include("invoice_queries.php");	


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Commercial Invoice</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1200" border="0" cellspacing="0" cellpadding="0">
  
  
  <tr>
    <td height="49" colspan="2" rowspan="4"><img src="../../../../images/callogo.jpg" align="right" /></td>
    <td width="30%" height="26" style="text-align:center; font-size:14px" class="normalfnBLD1"><?php echo $Company; ?></td>
    <td width="36%" colspan="2" rowspan="4" style="text-align:center">&nbsp;</td>
  </tr>
  <tr>
    <td height="18" style="text-align:center; font-size:14px" class="normalfnBLD1"><?php echo $Address ;?></td>
  </tr>
  <tr>
    <td style="text-align:center; font-size:14px" class="normalfnBLD1"><?php echo $City ;?></td>
  </tr>
  <tr>
    <td style="text-align:center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" style="text-align:center; font-size:14px" class="normalfnBLD1"><u>COMMERCIAL INVOICE</u></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="5">
	
	</td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8%">&nbsp;</td>
        <td width="8%" class="normalfnBLD1">SOLD TO :</td>
        <td colspan="3" class="normalfnt"><?php echo $BuyerName; ?></td>
        <td width="9%">&nbsp;</td>
        <td width="14%" class="normalfnt">Invoice No :</td>
        <td width="17%" class="normalfnt"><?php echo $invoiceNo; ?></td>
        <td width="11%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" class="normalfnt"><?php echo $BuyerAddress1; ?></td>
        <td>&nbsp;</td>
        <td class="normalfnt">Invoice Date : </td>
        <td class="normalfnt"><?php echo $dateInvoice; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" class="normalfnt"><?php echo $BuyerAddress2; ?></td>
        <td>&nbsp;</td>
        <td class="normalfnt">Payment Term: </td>
        <td class="normalfnt"><?php echo $PayTerm; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt">Ship Mode: </td>
        <td colspan="3" class="normalfnt">From <?php echo $PortOfLoading; ?> Sri Lanka To <?php echo $countryDest; ?> by <?php echo $TransportMode; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td colspan="3" class="normalfnt">Freight Collect </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td colspan="3" class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-top-bottom-left" style="text-align:center">&nbsp;</td>
        <td colspan="3" class="border-top-bottom-left" style="text-align:center"><span class="normalfnBLD1">Description of Goods</span></td>
        <td class="border-top-bottom-left" style="text-align:center"><span class="normalfnBLD1">Quantity</span></td>
        <td class="border-top-bottom-left" style="text-align:center"><span class="normalfnBLD1">Unit Price(USD)</span></td>
        <td class="border-All" style="text-align:center"><span class="normalfnBLD1">Amount(USD)</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnBLD1" style="text-align:center"><u><?php echo $Inco_terms; ?> SRI LANKA</u></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
	  <?php
	  	$sql_select="SELECT distinct
					strBuyerPONo,
					strStyleID,
					strDescOfGoods
					FROM
					commercial_invoice_detail
					WHERE
					strInvoiceNo='$invoiceNo'
					"; 
		$result_select=$db->RunQuery($sql_select);
		while($row_select=mysql_fetch_array($result_select))
		{
			$poNumber .=$row_select['strBuyerPONo']." ";
			$styleCode .=$row_select['strStyleID']." ";
		}
	  ?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="21%" class="normalfnt">LKZ NO : </td>
            <td width="79%" class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td class="normalfnt">PO NO : </td>
            <td class="normalfnt"><?php echo $poNumber ; ?></td>
          </tr>
          <tr>
            <td class="normalfnt">STYLE NO: </td>
            <td class="normalfnt"><?php echo $styleCode ; ?></td>
          </tr>
          <tr>
            <td class="normalfnt">SEASON:</td>
            <td class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td class="normalfnt">BUYING DEPT: </td>
            <td class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td class="normalfnt">STYLE DEPT: </td>
            <td class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td class="normalfnt">CAT#:</td>
            <td class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td class="normalfnt">C/O NO: </td>
            <td class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td class="normalfnt">DESCRIPTION</td>
            <td class="normalfnt"><?php echo $row_select['strDescOfGoods']; ?></td>
          </tr>
        </table>		</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="13%">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
	  <?php
	  	$sql_qty="SELECT
					shipmentplheader.strItemNo,
					commercial_invoice_detail.intItemNo,
					commercial_invoice_detail.strColor,
					commercial_invoice_detail.dblQuantity,
					commercial_invoice_detail.strUnitID,
					commercial_invoice_detail.dblUnitPrice,
					commercial_invoice_detail.dblAmount
					FROM
					commercial_invoice_detail
					INNER JOIN shipmentplheader ON shipmentplheader.strPLNo = commercial_invoice_detail.strPLno
					WHERE commercial_invoice_detail.strInvoiceNo='$invoiceNo'
					";
		$result_qty=$db->RunQuery($sql_qty);
		$totPCS=0;
		$totAmount=0;
		while($row_qty=mysql_fetch_array($result_qty))
		{	
			$totPCS=$totPCS+$row_qty['dblQuantity'];
			$totAmount=$totAmount+($row_qty['dblQuantity']*$row_qty['dblUnitPrice']);
	  ?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt">EBG ITEM No:</td>
        <td class="normalfnt" style="text-align:center"><?php echo $row_qty['strItemNo'];?></td>
        <td class="normalfnt" style="text-align:center"><?php echo $row_qty['strColor'];?></td>
        <td class="normalfnt" style="text-align:center"><?php echo $row_qty['dblQuantity'];?> <?php echo $row_qty['strUnitID'];?></td>
        <td class="normalfnt" style="text-align:center">USD <?php echo $row_qty['dblUnitPrice'];?></td>
        <td class="normalfnt" style="text-align:center">USD <?php echo $row_qty['dblQuantity']*$row_qty['dblUnitPrice'];?></td>
        <td>&nbsp;</td>
      </tr>
	  <?php
	  	$unitId=$row_qty['strUnitID'];
	  }
	  ?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="border-top" style="text-align:center"><span class="normalfnt"><?php echo $totPCS; ?> <?php echo $unitId;?></span></td>
        <td class="border-top" style="text-align:center">&nbsp;</td>
        <td class="border-top" style="text-align:center"><span class="normalfnt">USD <?php echo $totAmount; ?></span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" class="normalfnt">COUNTRY OF ORIGIN: </td>
        <td class="normalfnt" style="text-align:center">SRI LANKA </td>
        <td class="normalfnt" style="text-align:center">Total</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="border-top-bottom" style="text-align:center"><span class="normalfnt">USD <?php echo $totAmount; ?></span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" class="normalfnt">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="border-top" style="text-align:center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6" class="normalfnt">SAY TOTAL U.S DOLLARS <?php 
		include "../../../../Reports/numbertotext.php";
		$mat_array=explode(".",number_format($totAmount,2));
		echo convert_number($totAmount);
		echo $mat_array[1]!="00"?" AND CENTS ".convert_number($mat_array[1])." ONLY.":" ONLY.";
		?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6" class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6" class="normalfnBLD1">SHIP TO ADDRESS:</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6" class="normalfnt"><?php echo $dtoName; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6" class="normalfnt"><?php echo $dtoAddress1; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6" class="normalfnt"><?php echo $dtoAddress2; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6" class="normalfnt"><?php echo $dtoCountry; ?></td>
        <td>&nbsp;</td>
      </tr>
	  <?php
	  	$sql_tot="SELECT
				SUM(intNoOfCTns) AS totCTNS,
				SUM(dblNetMass) AS totNet,
				SUM(dblGrossMass) AS totGross
				FROM
				commercial_invoice_detail
				WHERE commercial_invoice_detail.strInvoiceNo='$invoiceNo'";
		$result_tot=$db->RunQuery($sql_tot);
		$row_tot=mysql_fetch_array($result_tot);
	  ?>
	  <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" class="normalfnt">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td class="normalfnt" style="text-align:center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="2" class="normalfnt">TOTAL CARTONS: </td>
	    <td class="normalfnt" style="text-align:right"><?php echo $row_tot['totCTNS']; ?></td>
	    <td class="normalfnt">&nbsp;CTNS</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="2" class="normalfnt">TOTAL QUANTITY: </td>
	    <td class="normalfnt" style="text-align:right"><?php echo $totPCS; ?></td>
	    <td class="normalfnt">&nbsp;<?php echo $unitId; ?></td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="2" class="normalfnt">TOTAL NET WEIGHT: </td>
	    <td class="normalfnt" style="text-align:right"><?php echo $row_tot['totNet']; ?></td>
	    <td class="normalfnt">&nbsp;KGS</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="2" class="normalfnt">TOTAL GROSS MASS: </td>
	    <td class="normalfnt" style="text-align:right"><?php echo $row_tot['totGross']; ?></td>
	    <td class="normalfnt">&nbsp;KGS</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="2" class="normalfnt">&nbsp;</td>
	    <td class="normalfnt" style="text-align:right">&nbsp;</td>
	    <td class="normalfnt">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="2" class="normalfnt">BANKING DETAILS: </td>
	    <td colspan="2" class="normalfnt">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="2" class="normalfnt">ACCOUNT NO: </td>
	    <td colspan="3" class="normalfnt"><?php echo $bankref; ?></td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="2" class="normalfnt">ACCOUNT NAME: </td>
	    <td colspan="3" class="normalfnt"><?php echo $accName; ?></td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="2" class="normalfnt">SWIFT:</td>
	    <td colspan="2" class="normalfnt"><?php echo $swiftCode; ?></td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="4" class="normalfnt">BANK'S FULL NAME &amp; FULL ADDRESS.. </td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="4" class="normalfnt"><?php echo $bankName ; ?></td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="4" class="normalfnt"><?php echo $bankAddress1 ; ?></td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="4" class="normalfnt"><?php echo $bankAddress2 ; ?></td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="4" class="normalfnt"><?php echo $bankCountry; ?></td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td class="normalfnt" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="4" class="normalfnt">&nbsp;</td>
	    <td colspan="2" class="dotborder-bottom" style="text-align:center">&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="4" class="normalfnt">&nbsp;</td>
	    <td colspan="2" class="normalfnBLD1" style="text-align:center">Authorised Signature</td>
	    <td>&nbsp;</td>
	    </tr>
	  
    </table></td>
  </tr>
</table>

</body>
</html>
