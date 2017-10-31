<?php 
session_start();
include "../../Connector.php";
$xmldoc=simplexml_load_file('../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

$invoiceNo=$_GET['invoiceNo'];

$qty1=0;	
$CTN1=0;
				
$qty2=0;
$CTN2=0;

$qty3=0;
				
$amout=0;
$currency='';
$exchange=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Short Shipment Declaration Report</title>
</head>

<body>
<table width="100" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="normalfnt_size20" style="text-align:center" bgcolor="" height="10"></td>
  </tr>
  <tr>
    <td class="normalfntMid" height="18"></td>
  </tr>
  <tr>
    <td class="normalfntMid">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
      <tr>
        <td width="93%" class="">
        <table width="848">
        	<tr>
            	<td width="840" height="30" style="text-align:center;"><h1><u>SHORT SHIPMENT DECLARATION</u></h1></u></td>
                
            </tr>
        </table>
        </td>
      </tr>
	  
	  <tr>
        <td width="93%" class="">
        <table width="844">
		<tr>
			
			<td width="836">&nbsp;</td>
			
		</tr>
		<tr>
			
			<td width="836">&nbsp;</td>
			
		</tr>
		<tr>
			
			<td width="836" align="left"><h3>MANAGER-VERIFICATION(BOI)/SLC</h3></td>
			
		</tr>
		</table>
		</td>
	</tr>
	
	 
	  <tr>
        <td width="93%" class="">
        <table width="857" cols="4">
		<tr>
			<?php
				$sql_date="SELECT dtmInvoiceDate FROM shipmentdeclarationheader
WHERE strInvoiceNo='$invoiceNo';";
				$result_date=$db->RunQuery($sql_date);
				$row_date=mysql_fetch_array($result_date);
				$shipmentDate=$row_date['dtmInvoiceDate'];
				
				if($shipmentDate!='')
				{
				$shipmentDateArray 	= explode('-',$shipmentDate);
				$shipmentDayArray	= explode(' ',$shipmentDateArray[2]);
				$FormatDateShipment = $shipmentDayArray[0]."/".$shipmentDateArray[1]."/".$shipmentDateArray[0];
			}
			else
				$FormatDateShipment='';
				
			?>
			<td width="831" class="normalfnt" height="25" style="font-size:14px;">Please be informed that we have short shipped goods,declared on Export CUSDE No <b><?php echo $invoiceNo; ?></b> of <b><?php echo $FormatDateShipment; ?></b> as shown below.</td>
			
		</tr>
		</table>
		
		</td>
	</tr>
	
	
	 <tr>
        <td width="93%">
        <table width="855" border="0" cellspacing="0">
		<tr>
		
			<td width="10%" class="border-top-left" height="25" style="text-align:center" ><span class="normalfnt-center_size12" style="text-align:center;">&nbsp;Item No As per CUSDEC&nbsp;</span></td>
			<td width="10%" class="border-top-left" style="text-align:center"><span class="normalfnt-center_size12" style="text-align:center;">&nbsp;HS CODE</span></td>
			<td width="30%" class="border-top-left" style="text-align:center" colspan="3"><span class="normalfnt-center_size12" style="text-align:center;">Quantity short shipped<br />(as per HS)</span></td>
			<td width="30%" class="border-top-left" style="text-align:center" colspan="4"><span class="normalfnt-center_size12" style="text-align:center;">Quantity Shipped <br />
			    (as per HS CODE)</span></td>
			<td width="20%" class="border-Left-Top-right" height="25" style="text-align:center"><span class="normalfnt-center_size12">FOB value of the shipped quantity in</span></td>
			
		</tr>
		<tr>
			<td class="border-bottom-left" height="25" style="text-align:center">&nbsp;</td>
			<td class="border-bottom-left" style="text-align:center">&nbsp;</td>
			<td  class="border-top-bottom-left"style="text-align:center">&nbsp;<b>CTN/PKGS</b></td>
			<td class="border-top-bottom-left" style="text-align:center">&nbsp;<b>QTY</b></td>
			<td class="border-top-bottom-left"  style="text-align:center">&nbsp;<b>UOM</b></td>
			
			<td class="border-top-bottom-left" style="text-align:center">&nbsp;<b>CTN/PKGS</b></td>
			<td  class="border-top-bottom-left" style="text-align:center">&nbsp;<b>QTY</b></td>
			<td class="border-top-bottom-left" style="text-align:center">&nbsp;<b>UOM</b></td>
			<td class="border-top-bottom-left"  style="text-align:center">&nbsp;<b>QTY IN PCS</b></td>
			<td class="border-Left-bottom-right"  style="text-align:center">&nbsp;<span class="normalfnt-center_size12"><b>Foreign Currency</b></span></td>
		</tr>
		        <?php
			$sql="SELECT
shipmentdeclarationdetail.strInvoiceNo,
shipmentdeclarationdetail.strStyleID,
shipmentdeclarationdetail.intItemNo,
shipmentdeclarationdetail.strBuyerPONo,
shipmentdeclarationdetail.strDescOfGoods,
shipmentdeclarationdetail.dblQuantity,
shipmentdeclarationdetail.strUnitID,
shipmentdeclarationdetail.dblUnitPrice,
shipmentdeclarationdetail.strPriceUnitID,
shipmentdeclarationdetail.dblCMP,
shipmentdeclarationdetail.dblAmount,
shipmentdeclarationdetail.strHSCode,
shipmentdeclarationdetail.dblGrossMass,
shipmentdeclarationdetail.dblNetMass,
shipmentdeclarationdetail.strProcedureCode,
shipmentdeclarationdetail.strCatNo,
shipmentdeclarationdetail.intNoOfCTns,
shipmentdeclarationdetail.strKind,
shipmentdeclarationdetail.dblUMOnQty1,
shipmentdeclarationdetail.UMOQtyUnit1,
shipmentdeclarationdetail.dblUMOnQty2,
shipmentdeclarationdetail.UMOQtyUnit2,
shipmentdeclarationdetail.dblUMOnQty3,
shipmentdeclarationdetail.UMOQtyUnit3,
shipmentdeclarationdetail.strISDno,
shipmentdeclarationdetail.strFabrication,
shipmentdeclarationdetail.strPLNO,
shipmentdeclarationheader.strCurrency,
shipmentdeclarationheader.dblExchange
FROM
shipmentdeclarationdetail
LEFT JOIN shipmentdeclarationheader ON shipmentdeclarationheader.strInvoiceNo = shipmentdeclarationdetail.strInvoiceNo
				  where shipmentdeclarationdetail.strInvoiceNo='$invoiceNo';";
				  
			$result=$db->RunQuery($sql);
			while($row=mysql_fetch_array($result))
			{
				$qty1=$qty1+$row['dblQuantity'];
				$CTN1=$CTN1+$row['intNoOfCTns'];
				
				$qty2=$qty2+$row['dblQuantity'];
				$CTN2=$CTN2+$row['intNoOfCTns'];
				
	            if($row['strPriceUnitID']=='DOZ')
					$qty3=$qty3+($row['dblQuantity']*12);
				else
					$qty3=$qty3+$row['dblQuantity'];
				$amout=$amount+$row['dblAmount'];
				$currency=$row['strCurrency'];
				$exchange=$row['dblExchange'];
		?>
		<tr>

			<td class="border-bottom-left" height="25" style="text-align:center">&nbsp;<?php echo $row['intItemNo']; ?></td>
			<td class="border-bottom-left" style="text-align:center">&nbsp;<?php echo $row['strHSCode']; ?></td>
			<td  class="border-bottom-left"style="text-align:center">&nbsp;<?php echo $row['intNoOfCTns']; ?></td>
			<td class="border-bottom-left" style="text-align:center">&nbsp;<?php echo $row['dblQuantity']; ?></td>
			<td class="border-bottom-left"  style="text-align:center">&nbsp;<?php echo $row['strPriceUnitID']; ?></td>
			
			<td class="border-bottom-left" style="text-align:center">&nbsp;<?php echo $row['intNoOfCTns']; ?></td>
			<td  class="border-bottom-left" style="text-align:center">&nbsp;<?php echo $row['dblQuantity']; ?></td>
			<td class="border-bottom-left" style="text-align:center">&nbsp;<?php echo $row['strPriceUnitID']; ?></td>
            <?php
            if($row['strPriceUnitID']=='DOZ')
			{
			?>
			<td class="border-bottom-left"  style="text-align:center">&nbsp;<?php echo $row['dblQuantity']*12; ?></td>
            <?php 
			}
			else
			{
			?>
            <td class="border-bottom-left"  style="text-align:center">&nbsp;<?php echo $row['dblQuantity']; ?></td>
            <?php
			}
			?>
			<td class="border-Left-bottom-right"  style="text-align:center">&nbsp;<?php echo $row['strCurrency']; ?> <?php echo  $row['dblAmount']*$row['dblExchange']; ?></td>
		</tr>
        <?php
			}
		?>
        
		<?php
			for($i=0;$i<7;$i++)
			{
		?>
		<tr>
			<td class="border-bottom-left" height="25" style="text-align:center" >&nbsp;</td>
			<td class="border-bottom-left" style="text-align:center">&nbsp;</td>
			<td  class="border-bottom-left"style="text-align:center">&nbsp;</td>
			<td class="border-bottom-left" style="text-align:center">&nbsp;</td>
			<td class="border-bottom-left"  style="text-align:center">&nbsp;</td>
			
			<td class="border-bottom-left" style="text-align:center">&nbsp;</td>
			<td  class="border-bottom-left" style="text-align:center">&nbsp;</td>
			<td class="border-bottom-left" style="text-align:center">&nbsp;</td>
			<td class="border-bottom-left"  style="text-align:center">&nbsp;</td>
			<td class="border-Left-bottom-right"  style="text-align:center">&nbsp;</td>
		</tr>
        <?php
			}
		?>
        
		
        <tr>
			<td class="border-bottom-left" height="25" style="text-align:center" >&nbsp;</td>
			<td class="border-bottom-left" style="text-align:center">&nbsp;</td>
			<td  class="border-bottom-left"style="text-align:center">&nbsp;</td>
			<td class="border-bottom-left" style="text-align:center">&nbsp;</td>
			<td class="border-bottom-left"  style="text-align:center">&nbsp;</td>
			
			<td class="border-bottom-left" style="text-align:center">&nbsp;</td>
			<td  class="border-bottom-left" style="text-align:center">&nbsp;</td>
			<td class="border-bottom-left" style="text-align:center">&nbsp;</td>
			<td class="border-bottom-left"  style="text-align:center">&nbsp;</td>
			<td class="border-Left-bottom-right"  style="text-align:center">&nbsp;</td>
		</tr>


        
        
        
        
		<tr>
			<td class="border-bottom-left" height="25" style="text-align:center" >&nbsp;<span class="normalfnBLD1">TOTAL</span></td>
			<td class="border-bottom-left" style="text-align:center">&nbsp;</td>
			<td  class="border-bottom-left"style="text-align:center">&nbsp;<span class="normalfnBLD1"><?php echo $CTN1; ?></span></td>
			<td class="border-bottom-left" style="text-align:center">&nbsp;<span class="normalfnBLD1"><?php echo $qty1; ?></span></td>
			<td class="border-bottom-left"  style="text-align:center">&nbsp;<span class="normalfnBLD1">PCS</span></td>
			
			<td class="border-bottom-left" style="text-align:center">&nbsp;<span class="normalfnBLD1"><?php echo $CTN2; ?></span></td>
			<td  class="border-bottom-left" style="text-align:center">&nbsp;<span class="normalfnBLD1"><?php echo $qty2; ?></span></td>
			<td class="border-bottom-left" style="text-align:center">&nbsp;<span class="normalfnBLD1">PCS</span></td>
			<td class="border-bottom-left"  style="text-align:center">&nbsp;<span class="normalfnBLD1"><?php echo $qty3; ?></span></td>
			<td class="border-Left-bottom-right"  style="text-align:center">&nbsp;<span class="normalfnBLD1"><?php echo $currency;?>  <?php echo $amout*$exchange; ?></span></td>
		</tr>
		
		</table>
		 <table width="855" border="0" cellspacing="0">
		 	<tr>
			<td class="border-top" height="25" style="text-align:center">&nbsp;</td>
			<td class="border-top" style="text-align:center">&nbsp;</td>
			<td class="border-top" style="text-align:center">&nbsp;</td>
			<td class="border-top" style="text-align:center">&nbsp;</td>
			<td  class="border-top"  style="text-align:center">&nbsp;</td>
			
			<td class="border-top" style="text-align:center">&nbsp;</td>
			<td  class="border-top" style="text-align:center">&nbsp;</td>
			<td class="border-top" style="text-align:center">&nbsp;</td>
			<td class="border-top"  style="text-align:center">&nbsp;</td>
			<td class="border-top"  style="text-align:center">&nbsp;</td>
		</tr>
		 </table>
		</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	</tr><tr>
	<td><h3>Details of the Exporter or his representative</h3></td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td>
		<table height="60" cellspacing="0" border="0">
		<tr>
			<td width="108" height="21"><span class="normalfnt-center_size12">Signature</span></td>
			<td width="46">:-</td>
			<td width="687">.............................................................</td>
		</tr>
		<tr>
			<td height="21"><span class="normalfnt-center_size12">Name</span></td>
			<td>:-</td>
			<td>.............................................................</td>
		</tr>
		<tr>
			<td height="23"><span class="normalfnt-center_size12">Tel No</span></td>
			<td>:-</td>
			<td>.............................................................</td>
		</tr>
		<tr>
			<td><span class="normalfnt-center_size12">Date</span></td>
			<td>:-</td>
			<td>.............................................................</td>
		</tr>
		<tr>
			<td class="border-bottom"></td>
			<td class="border-bottom"></td>
			<td class="border-bottom"></td>
		</tr>
		</table>
		</td>
	</tr>
	
	  
    </table></td>
  </tr>
  
  <tr>
	<td>
		<table height="30" cellspacing="0" border="0">
		<tr>
			<td class="normalfnt" style="font-size:14px;">Certified and Confirmed.</td>
		</tr>
		</table>
	</td>
 </tr>
 
 <tr>
	<td>
		<table height="60" cellspacing="0" border="0">
		<tr>
			<td class="normalfnt">........................................................................................</td>
		</tr>
		<tr>
			<td class="normalfnt" style="font-size:14px;">Signature of SLC Officer / Verification (BOI) VO No</td>
			
		</tr>
		<tr>
			<td class="normalfnt" style="font-size:14px;">Date            :- ......................................</td>
			
		</tr>
		<tr>
			<td class="normalfnt" style="font-size:12px;">&nbsp;</td>
			
		</tr>
		<tr>
			<td class="normalfnt" style="font-size:12px;"><b><i>N.B.: If several unit prices are involved, an amended invoice should be submitted</i></b></td>
			
		</tr>
		</table>
	</td>
 </tr>
	
	  
    </table></td>
  </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
 </table>
</body>
</html>
