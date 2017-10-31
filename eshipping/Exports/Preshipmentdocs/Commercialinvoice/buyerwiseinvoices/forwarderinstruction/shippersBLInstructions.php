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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SHIPPERS B/L INSTRUCTIONS</title>
</head>

<body>
<table width="985" border="0" cellspacing="0" cellpadding="1" align="center">
<tr>
<td>
	<table width="985" border="0" cellspacing="0" cellpadding="1" align="center">	
	<tr height="10">
		<td width="30%">&nbsp;</td>
    	<td width="23%" class="normalfnBLD1" style="text-align:right">SHIPPERS B/L </td>
		<td width="47%" class="normalfnBLD1" style="text-align:left">INSTRUCTIONS</td>
    </tr>
    <tr>
		<td class="border-top-left" width="30%">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td><span class="normalfnBLD1"><u>SHIPPER:</u></span></td>
				</tr>
			</table>
		</td>
		<td class="border-top" width="23%">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
		<td width="47%" class="border-Left-Top-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="50%"></td>
					<td width="50%"></td>
				</tr>
			</table>
		</td>
	</tr>
	
	
	<tr>
		<td width="30%" rowspan="2" class="border-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="50%" class="normalfnt">
                    &nbsp;<?php echo $Company; ?><br />
                    &nbsp;<?php echo $Address; ?><br />
                    &nbsp;<?php echo $City; ?><br />
                    </td>
				</tr>
			</table>
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="50%" class="normalfnt"></td>
					<td width="50%"></td>
				</tr>
			</table>
	  </td>
	  	<td width="23%">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="50%">&nbsp;</td>
					<td width="50%"></td>
				</tr>
			</table>
		</td>
		<td width="47%" class="border-left-right" height="100%">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td><center><img src="../../../../../images/mac.jpg" height="50"/></center></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width="23%">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="50%"></td>
					<td width="50%"></td>
				</tr>
			</table>
		</td>
	  
	  <td width="47%" class="border-left-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="50%" class="normalfnBLD1" style="text-align:center">MAC SUPPLY CHAIN SOLUTIONS (PVT) LTD.</td>
				</tr>
			</table>
	  </td>
	</tr>
	
	<tr>
		<td width="30%" class="border-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td colspan="2" class="normalfnt">&nbsp;</td>
				</tr>
				<tr>
					<td width="50%" class="normalfnt"></td>
					<td width="50%"></td>
				</tr>
			</table>
	  </td>
	  	<td width="23%">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="50%">&nbsp;</td>
					<td width="50%"></td>
				</tr>
			</table>
		</td>
	  <td width="47%" class="border-left-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="100%" class="normalfnBLD1" style="text-align:center; font-size:9px">"The Wavertree"</td>
				</tr>
				<tr>
					<td width="100%" class="normalfnBLD1" style="text-align:center; font-size:9px">141/9, Vauxhall Street, Colombo 02, Sri Lanka.</td>
				</tr>
			</table>
	  </td>
	</tr>


	<tr>
		<td width="30%" class="border-top-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td class="normalfnBLD1"><U>CONSIGNEE:</U></td>
				</tr>
				<tr>
					<td class="normalfnt">
                    <br />
                    &nbsp;<?php echo $BuyerName; ?><br />
                    &nbsp;<?php echo $BuyerAddress1; ?><br />
                    &nbsp;<?php echo $BuyerAddress2; ?><br />
                    &nbsp;<?php echo $BuyerCountry; ?><br />
                    
                    </td>
				</tr>
			</table>
		</td>
		<td width="23%" class="border-top">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="50%"></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="50%"></td>
					<td width="50%"></td>
				</tr>
			</table>
		</td>
		<td width="47%" class="border-left-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="100%" class="normalfnBLD1" style="text-align:center; font-size:9px">Tel: 94-11-2309200 Fax: 94-11-230814</td>
				</tr>
				<tr>
					<td width="100%" class="normalfnBLD1" style="text-align:center; font-size:9px">Web Site: www.macholdings.com</td>
				</tr>
			</table>
	  </td>
	</tr>
	
	
	<tr>
		<td width="30%" class="border-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td colspan="2" class="normalfnt">&nbsp;</td>
				</tr>
				<tr>
					<td width="50%" class="normalfnt"></td>
					<td width="50%"></td>
				</tr>
			</table>
</td>
				<td width="23%">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="50%"></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="50%"></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="50%"></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="50%">&nbsp;</td>
					<td width="50%"></td>
				</tr>


			</table>
		</td>
		
		<td width="47%" class="border-left-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="100%" class="normalfnBLD1" style="text-align:center;"></td>
				</tr>
				<tr>
					<td width="100%" class="normalfnBLD1" style="text-align:center;"></td>
				</tr>
				<tr>
					<td width="100%" class="normalfnBLD1" style="text-align:center;"></td>
				</tr>
				<tr>
					<td width="100%" class="normalfnBLD1" style="text-align:center;"></td>
				</tr>
			</table>
	  </td>
	</tr>
	
	
		<tr>
		<td width="30%" class="border-top-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1"><u>NOTIFY PARTY</u></td></tr>
				<tr><td>
                <br /><br />
                &nbsp;<?php echo $BrokerName; ?><br />
                &nbsp;<?php echo $BrokerAddress1; ?><br />
                &nbsp;<?php echo $BrokerAddress2; ?><br />
                &nbsp;<?php echo $BrokerCountry; ?><br />
                </td></tr>
				<tr><td>&nbsp;</td></tr>
			</table>
		</td>
		<td width="23%" class="border-top">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1">&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
			</table>
		</td>
		<td width="47%" class="border-Left-Top-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="70%" class="normalfnBLD1">&nbsp;</td>
					<td width="30%" class="normalfnt">&nbsp;</td>
				</tr>
				<tr>
					<td class=""><b>CARGO READY DATE :</b></td>
					<td class="normalfnt" style="text-align:center">&nbsp;&nbsp;<?php echo $SailingDate; ?></td>
				</tr>
				<tr>
					<td class="normalfnBLD1">&nbsp;</td>
					<td class="normalfnt">&nbsp;</td>
				</tr>
			</table>
	  </td>
	</tr>
	
	<tr>
		<td width="30%" class="border-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1">&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
			</table>
		</td>
		<td width="23%">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1">&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
			</table>
		</td>
		<td width="47%" class="border-Left-Top-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="70%" class="normalfnBLD1">&nbsp;</td>
					<td width="30%" class="normalfnt">&nbsp;</td>
				</tr>
				<tr>
					<td class="normalfnBLD1">NO OF ORIGINALS :</td>
					<td class="normalfnt" style="text-align:center">&nbsp;</td>
				</tr>
				<tr>
					<td class="normalfnBLD1">&nbsp;</td>
					<td class="normalfnt">&nbsp;</td>
				</tr>
			</table>
	  </td>
	</tr>
	
	<tr>
		<td width="30%" class="border-top-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class=""><b>VESSAL : </b>&nbsp;&nbsp;<?php echo $Carrier; ?></td></tr>
			</table>
		</td>
		<td width="23%" class="border-top-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class=""></td></tr>
			</table>
		</td>
		<td width="47%" class="border-Left-Top-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="76%" class="normalfnBLD1">GROSS WEIGHT (KG):</td>
					<td width="24%" class="normalfnt" style="text-align:center"><?php  echo $r_summary->summary_sum($invoiceNo,'dblGrossMass');?></td>
				</tr>
			</table>
	  </td>
	</tr>
	
	
	<tr>
		<td width="30%" class="border-top-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class=""><b>PORT OF LOADING : </b>&nbsp;&nbsp;<?php echo $PortOfLoading; ?></td></tr>
			</table>
		</td>
		<td width="23%" class="border-top-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class=""></td></tr>
			</table>
		</td>
		<td width="47%" class="border-Left-Top-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="76%" class="normalfnBLD1">NETT WEIGHT (KG):</td>
					<td width="24%" class="normalfnt" style="text-align:center"><?php  echo $r_summary->summary_sum($invoiceNo,'dblNetMass');?></td>
				</tr>
			</table>
	  </td>
	</tr>
		
		
	<tr>
		<td width="30%" class="border-top-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
				  <td class=""><b>PORT OF DISCHARGE :</b> &nbsp;<?php echo $Destinationcity;?></td></tr>
			</table>
		</td>
		<td width="23%" class="border-top-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class=""><b>FINAL DESTINATION :</b>&nbsp;<?php echo $Destinationport;?></td></tr>
			</table>
		</td>
		
		<td width="47%" class="border-Left-Top-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1">MEASUREMENT (CBM):</td>
                <td width="24%" class="normalfnt" style="text-align:center"><?php echo $CartonMeasurement; ?></td>
                
                </tr>
			</table>
		</td>
		
	</tr>
	
	<tr>
		<td width="30%" class="border-top-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1" style="text-align:center">MARK(S) &amp; NUMBERS</td></tr>
			</table>
		</td>
		<td width="23%" class="border-top-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1" style="text-align:center">NO OF PKGS</td></tr>
			</table>
		</td>
		
		<td width="47%" class="border-Left-Top-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1" style="text-align:center">DESCRIPTION OF GOODS</td></tr>
			</table>
		</td>
		
	</tr>
	
		
	  <tr>
		<td width="30%" class="border-top-bottom-left" height="100">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="" style="text-align:center"><br />
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
                </td></tr>
			</table>
		</td>
		<td width="23%" class="border-top-bottom-left" height="100" valign="top">
			<table cellspacing="0" border="0" width="100%" style="vertical-align:top">
				<tr><td class="" style="text-align:center; vertical-align:text-top"><br /><?php  echo $r_summary->summary_sum($invoiceNo,'intNoOfCTns');?>&nbsp;CTN</td></tr>
			</table>
		</td>
		
		<td width="47%" class="border-All" height="100" valign="top">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="" style="text-align:left">
                <br />
                &nbsp;
                <?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity'); ?>&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strUnitID'); ?>&nbsp;OF&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strDescOfGoods'); ?>&nbsp;IN&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strFabric'); ?>
                <br /><br />
                PO NO :&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strBuyerPONo'); ?><br /><br />
                STYLE :&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strStyleID'); ?>
                </td></tr>
			</table>
		</td>
		
	</tr>
		
	<tr>
		<td width="30%" class="border-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1" style="font-size:9px">TOTAL FREIGHT TO BE COLLECTED AT DESTINATION</td></tr>
			</table>
		</td>
		<td width="23%">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td class="normalfnBLD1" style="text-align:center; font-size:9px">&nbsp;</td>
					<td class="border-All" style="font-size:9px">&nbsp;</td>
					<td style="font-size:9px">&nbsp;</td>
				</tr>
			</table>
		</td>
		
		<td width="47%" class="border-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1" style="font-size:9px">( )% TO BE COLLECT.( )% TO BE PREPAID </td>
				<td width="22%" class="border-All">&nbsp;</td>
					<td width="5%">&nbsp;</td>

				</tr>
			</table>
		</td>
		
	</tr>
	
	
	
	<tr>
		<td width="30%" class="border-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1" style="font-size:9px">TOTAL FREIGHT TO BE PREPARED BY SHIPPER</td></tr>
			</table>
		</td>
		<td width="23%">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td class="normalfnBLD1" style="text-align:center; font-size:9px">&nbsp;</td>
					<td class="border-All" style="font-size:9px">&nbsp;</td>
					<td style="font-size:9px">&nbsp;</td>
				</tr>
			</table>
		</td>
		
		<td width="47%" class="border-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="73%" class="normalfnBLD1" style="font-size:9px">OTHER CHARGES TO BE COLLECTED</td>
					<td width="22%" class="border-All">&nbsp;</td>
					<td width="5%">&nbsp;</td>
				</tr>
			</table>
		</td>
		
	</tr>
	
	
	<tr>
		<td width="30%" class="border-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1" style="font-size:9px">TOTAL FREIGHT TO BE PAID BY A THIRD PARTY</td></tr>
			</table>
		</td>
		<td width="23%">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td class="normalfnBLD1" style="text-align:center; font-size:9px">&nbsp;</td>
					<td class="border-All" style="font-size:9px">&nbsp;</td>
					<td style="font-size:9px">&nbsp;</td>
				</tr>
				
			</table>
		</td>
		
		<td width="47%" class="border-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="73%" class="normalfnBLD1" style="font-size:9px">OTHER CHARGES TO BE PREPARED</td>
					<td width="22%" class="border-All">&nbsp;</td>
					<td width="5%">&nbsp;</td>
				</tr>
			</table>
		</td>
		
	</tr>

		
	<tr>
		<td width="30%" class="border-top-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1"><u>REMARKS</u></td></tr>
			</table>
		</td>
		<td width="23%" class="border-top">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td >&nbsp;</td>
				</tr>
				
			</table>
		</td>
		
		<td width="47%" class="border-top-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="73%">&nbsp;</td>
					<td width="22%">&nbsp;</td>
					<td width="5%">&nbsp;</td>
				</tr>
			</table>
		</td>
		
	</tr>
	
		
	<tr>
		<td width="30%" class="border-bottom-left">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr><td class="normalfnBLD1">&nbsp;</td></tr>
			</table>
		</td>
		<td width="23%" class="border-bottom">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td>&nbsp;</td>
				</tr>
				
			</table>
		</td>
		
		<td width="47%" class="border-bottom-right">
			<table cellspacing="0" align="center" border="0" width="100%">
				<tr>
					<td width="73%" height="38">&nbsp;</td>
				</tr>
			</table>
		</td>
		
	</tr>
		
		
</table>
</td>
</tr>

<tr>
	<td>&nbsp;</td>
</tr>

<tr>
	<td class="normalfnBLD1" style="text-align:center">Our mission :</td>
</tr>

<tr>
	<td class="normalfnt" style="text-align:center">Provide quality and excellent global logistics and transportation solutions to our customers in a partnership with our<br />global business partners by investing in modern technology, infrastructure and enhancement of our personnel.</td>
</tr>

</table>
</body>
</html>
