<?php 
session_start();
include "../../../../../Connector.php";

$xmldoc=simplexml_load_file('../../../../../config.xml');
include "../common_report.php";
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

$invoiceNo=$_GET['InvoiceNo'];
include "../invoice_queries.php";

$type=($_GET['type']==""? "FOB":$_GET['type']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Shipper Instructions</title>
<link href="../../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="985" border="0" cellspacing="0" cellpadding="1" align="center">
	<tr height="2%">
    	<td class="normalfnt" style="text-align:center">SHIPPERS INSTRUCTIONS DISPATCH AND ISSUING B/L /HAWB</td>
    </tr>
    <tr height="98%">
   	  <td>
<table cellspacing="0" border="0" align="center" width="100%" height="20%">
            	<tr>
                	<td width="19%" class="border-top-left" style="font-size:10px"><b>REQUESTED ROUTING:</b></td>
                    <td width="25%" class="border-top-right"></td>
                    <td width="7%" class="border-top"></td>
                    <td width="8%" class="border-top"><span class="normalfnBLD1">ATTN:</span></td>
                    <td width="34%" class="border-top" style="text-align:center"><span class="normalfnBLD1">SHIRFAZ / SHAKEER</span></td>
                    <td width="7%" class="border-top-right"></td>
                </tr>
            	<tr>
            	  <td class="border-top-left" style="font-size:10px"><b>REQUESTED BOOKING:</b></td>
            	  <td class="border-top-right"></td>
            	  <td></td>
            	  <td class="border-top">&nbsp;</td>
            	  <td class="border-top">&nbsp;</td>
            	  <td class="border-right"></td>
          	  </tr>
            	<tr>
            	  <td class="border-top-left" style="font-size:10px"><b>PORT OF LOADING</b></td>
            	  <td class="border-Left-Top-right" style="font-size:10px"><b>PORT OF DISCHARGE</b></td>
            	  <td></td>
            	  <td class="border-top-left" style="font-size:12px"><b>&nbsp;MWAB:</b></td>
            	  <td class="border-top-right">&nbsp;</td>
            	  <td class="border-right"></td>
          	  </tr>
            	<tr>
            	  <td class="border-bottom-left" style="font-size:10px"><?php echo $PortOfLoading; ?></td>
            	  <td class="border-Left-bottom-right" style="font-size:10px">&nbsp;<?php echo $Destinationport; ?></td>
            	  <td></td>
            	  <td class="border-bottom-left" style="font-size:12px">&nbsp;</td>
            	  <td class="border-bottom-right">&nbsp;</td>
            	  <td class="border-right"></td>
          	  </tr>
            	<tr>
            	  <td class="border-left" style="font-size:10px">&nbsp;</td>
            	  <td class="border-right" style="font-size:10px">&nbsp;</td>
            	  <td></td>
            	  <td class="border-left" style="font-size:12px"><b>&nbsp;HWAB:</b></td>
            	  <td class="border-right">&nbsp;</td>
            	  <td class="border-right"></td>
          	  </tr>
            	<tr>
            	  <td class="border-bottom-left" style="font-size:10px">&nbsp;</td>
            	  <td class="border-bottom-right" style="font-size:10px">&nbsp;</td>
            	  <td></td>
            	  <td class="border-bottom-left" style="font-size:12px">&nbsp;</td>
            	  <td class="border-bottom-right">&nbsp;</td>
            	  <td class="border-right"></td>
          	  </tr>
            </table>
        <table cellspacing="0" border="0" align="center" width="100%" height="20%">
            <tr>
            	<td width="44%" class="border-left-right"><span class="normalfnBLD1"><b>CONSIGNEE</b></span></td>
                <td width="7%"></td>
                <td width="42%"></td>
                <td width="7%" class="border-right"></td>
            </tr>
            <tr>
              <td class="border-left-right">&nbsp;</td>
              <td></td>
              <td></td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td height="67" class="border-left-right">
              <table cellspacing="0" border="=0" width="100%">
              <tr>
              	<td class="normalfnt">
                 	&nbsp;<?php echo $BuyerName; ?><br />
                    &nbsp;<?php echo $BuyerAddress1; ?><br />
                    &nbsp;<?php echo $BuyerAddress2; ?><br />
                    &nbsp;<?php echo $BuyerCountry; ?><br />
                </td>
              </tr>
              </table>
              </td>
              <td></td>
              <td><img src="../../../../../images/bax.gif" /></td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td class="border-left-right">&nbsp;</td>
              <td></td>
              <td></td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td class="border-Left-Top-right"><span class="normalfnBLD1">SHIPPER</span></td>
              <td></td>
              <td class="normalfnt">LEVEL 30, WEST TOWER,</td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td class="border-left-right">&nbsp;</td>
              <td></td>
              <td class="normalfnt">WORLD TRADE CENTER, COLOMBO 01</td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td rowspan="4" class="border-left-right">
              		&nbsp;<?php echo $Company; ?><br />
                    &nbsp;<?php echo $Address; ?><br />
                    &nbsp;<?php echo $City; ?><br />
              </td>
              <td></td>
              <td class="normalfnt">SRI LANKA</td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td></td>
              <td class="normalfnt">TEL:94 11 4728300  FAX: 94 11 4728324</td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td></td>
              <td class="normalfnt">E-MAIL : colombo@baxglobal.com</td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td class="border-left-right">&nbsp;</td>
              <td></td>
              <td></td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td class="border-Left-Top-right"><span class="normalfnBLD1">ALSO NOTIFY</span></td>
              <td></td>
              <td style="font-size:9px" class="normalfnt">We hereby request and authorize Bax Global Private Limited</td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td class="border-left-right">&nbsp;</td>
              <td></td>
              <td style="font-size:9px" class="normalfnt">or nominee upon receipt of the consignment described</td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td rowspan="5" class="border-left-right">
                &nbsp;<?php echo $BrokerName; ?><br />
                &nbsp;<?php echo $BrokerAddress1; ?><br />
                &nbsp;<?php echo $BrokerAddress2; ?><br />
                &nbsp;<?php echo $BrokerCountry; ?><br />
              </td>
              <td></td>
              <td style="font-size:9px" class="normalfnt">herein to prepare and sign the Airway bill and other </td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td></td>
              <td style="font-size:9px" class="normalfnt">necesary documents on our behalf and dispatch the </td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td></td>
              <td style="font-size:9px" class="normalfnt">consignment in accordance with your conditions of </td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td></td>
              <td style="font-size:9px" class="normalfnt">Concrate.We also hereby agree to reimburse Bax Global All </td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td></td>
              <td style="font-size:9px" class="normalfnt">charges pertaining to this shipment.</td>
              <td class="border-right"></td>
            </tr>
            <tr>
              <td class="border-left-right">&nbsp;</td>
              <td></td>
              <td style="font-size:9px"></td>
              <td class="border-right"></td>
            </tr>
        </table></td>
    </tr>
    <tr>
    	<td>
        	<table cellspacing="0" border="0" align="center" width="100%" height="30%">
            	<tr>
                <td class="border-top-left"><span class="normalfnBLD1">MARKS AND NUMBERS</span></td>
                <td class="border-top-left"><span class="normalfnBLD1">NO AND KIND OF PACKAGES</span></td>
                <td class="border-top-left"><span class="normalfnBLD1">DESCRIPTION OF GOODS</span></td>
                <td class="border-top-left"><span class="normalfnBLD1">GROSS WEIGHT</span></td>
                <td class="border-Left-Top-right"><span class="normalfnBLD1">MEASUREMENT</span></td>
                </tr>
                <tr>
                	<td class="border-top-left">&nbsp;</td>
                    <td class="border-top-left">&nbsp;</td>
                    <td class="border-top-left">&nbsp;</td>
                    <td class="border-top-left">&nbsp;</td>
                    <td class="border-Left-Top-right">&nbsp;</td>
                </tr>
                <?php
				
				?>
                <tr>
                	<td class="border-left">
                     	<?php echo $mainmark1; ?><br />
						<?php echo $mainmark2; ?><br />
                        <?php echo $mainmark3; ?><br />
                        <?php echo $mainmark4; ?><br />
                        <?php echo $mainmark5; ?><br />
                        <?php echo $mainmark6; ?><br />
                        <?php echo $mainmark7; ?><br />
                        <?php echo $sidemark1; ?><br />
                        <?php echo $sidemark2; ?><br />
                        <?php echo $sidemark3; ?><br />
                        <?php echo $sidemark4; ?><br />
                        <?php echo $sidemark5; ?><br />
                        <?php echo $sidemark6; ?><br />
                        <?php echo $sidemark7; ?><br />
                    
                    </td>
                    <td class="border-left" style="vertical-align:text-top">&nbsp;<?php  echo $r_summary->summary_sum($invoiceNo,'intNoOfCTns');?>&nbsp;&nbsp;Cartons Containing</td>
                    <td class="border-left" style="vertical-align:text-top">
                     <br />
        &nbsp;<b>Style No :</b> <?php echo $r_summary->summary_string($invoiceNo,'strStyleID'); ?>
        <br /><br />
        &nbsp;<b>Order No :</b> <?php echo $r_summary->summary_string($invoiceNo,'strBuyerPONo'); ?>
        <br /><br />
        &nbsp;<b>Cat No   :</b>
        <br /><br />
        &nbsp;<b><u>DESCRIPTION</u></b><br /><br />
        <?php echo $r_summary->summary_sum($invoiceNo,'intNoOfCTns'); ?>&nbsp;Cartons Containing<br />
        <?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity'); ?>&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strUnitID'); ?>&nbsp;of&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strDescOfGoods'); ?><br /><br /><?php echo $r_summary->summary_string($invoiceNo,'strFabric'); ?>
                    
                    </td>
                    <td class="border-left" style="vertical-align:text-top">&nbsp;<?php  echo $r_summary->summary_sum($invoiceNo,'dblGrossMass');?>&nbsp;KG</td>
                	<td class="border-left-right" style="vertical-align:text-top">
                   
                    </td>
                </tr>
                <?php
				
				?>
                <tr>
                	<td class="border-bottom-left">&nbsp;</td>
                    <td class="border-bottom-left">&nbsp;</td>
                    <td class="border-bottom-left">&nbsp;</td>
                    <td class="border-bottom-left">&nbsp;</td>
                    <td class="border-Left-bottom-right">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    <td class="normalfnt">DOCUMENTS</td>
    </tr>
    <tr>
    <td class="normalfnt">ACCOMPANYING SHIPMENT</td>
    </tr>
    
    <tr>
    	<td>
        <table cellspacing="0" border="0" align="center" width="100%" height="10%">
        	<tr>
            	<td width="11%" class="border-top-left"></td>
                <td width="4%" class="border-top-left"><center>X</center></td>
                <td width="9%" class="border-top-left"><span class="normalfnt">PREPAID</span></td>
                <td width="7%" class="border-top-left"></td>
                <td width="10%" class="border-top"><span class="normalfnt">OTHER</span></td>
                <td width="4%" class="border-top-left"></td>
                <td width="11%" class="border-top-left"><span class="normalfnt">PREPAID</span></td>
                <td width="44%" class="border-Left-Top-right"><span class="normalfnt">INSURANCE-AMOUNT REQUESTED</span></td>
            </tr>
        	<tr>
        	  <td class="border-left"><span class="normalfnt">FREIGHT</span></td>
        	  <td class="border-top">&nbsp;</td>
        	  <td class="normalfnt">&nbsp;</td>
        	  <td class="border-left"></td>
        	  <td class="normalfnt">CHARGES</td>
        	  <td class="border-top"></td>
        	  <td>&nbsp;</td>
        	  <td class="border-left-right">&nbsp;</td>
      	  </tr>
        	<tr>
        	  <td class="border-left">CHARGES</td>
        	  <td class="border-top-left">&nbsp;</td>
        	  <td class="border-left">COLLECT</td>
        	  <td class="border-left"></td>
        	  <td class="normalfnt">AT ORIIN</td>
        	  <td class="border-top-left"></td>
        	  <td class="border-left"></td>
        	  <td class="border-left-right">&nbsp;</td>
      	  </tr>
        </table>
        </td>
    </tr>
    <tr>
    <td>
    	<table cellspacing="0" border="0" align="center" width="100%" height="10%">
        <tr>
        	<td width="69%" class="border-top-left" style="text-align:center" colspan="2"><span class="normalfnBLD1">DECLARED VALUES</span></td>
            <td width="31%" class="border-Left-Top-right"><span class="normalfnt">SHIPPERS C.O.D AMOUNT</span></td>
        </tr>
        <tr>
        <td class="border-top-left">FOR CUSTOMS</td>
        <td class="border-top-left">FOR CARRIAGE</td>
        <td class="border-left-right"></td>
        </tr>
        <tr>
          <td class="border-top-left">hANDLING INFORMATION</td>
          <td class="border-top">&nbsp;</td>
          <td class="border-left-right"></td>
        </tr>
        <tr>
          <td class="border-top"><u>REMARKS:</u></td>
          <td class="border-top">&nbsp;</td>
          <td class="border-top"></td>
        </tr>
        </table>
    </td>
    </tr>
    <tr>
    	<td>
        <table cellspacing="0" border="0" align="center" width="100%" height="10%">
        <tr>
        	<td width="82%" class="normalfnt" style="font-size:9px">We declare that above particulars are correct and complete and</td>
            <td width="18%" class="border-Left-Top-right"></td>
        </tr>
        <tr>
          <td class="normalfnt" style="font-size:9px">accept full responsibility for such declarations.</td>
          <td class="border-left-right"><span class="normalfnt">DATE..............</span></td>
        </tr>
        <tr>
          <td class="normalfnt" style="font-size:9px">&nbsp;</td>
          <td class="border-Left-bottom-right">&nbsp;</td>
        </tr>
        </table>
        </td>
    </tr>
</table>
</body>
</html>