<?php 
session_start();
include "../Connector.php";
$xmldoc=simplexml_load_file('../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

$invoiceNo=$_GET['iouNo'];	
$sqlinvoiceheader="SELECT intIOUNo,
 customers.strName AS customer,
 customers.strTIN as vatno,
 strEntryNo,
 CONCAT(customers.strAddress1,', ',customers.strAddress2) AS customeraddress,
 IOH.strVessel AS vessel,
 IOH.strPrevDoc AS bl,
 suppliers.strName AS supliers,
 IOH.strMerchandiser,
 forwaders.strName AS forwader,
 wharfclerks.strName AS wharfclerk,
 strLCNumber AS LC ,
 deliverynote.strContainerNo AS container,
 IOH.dblPackages,
 IOH.intIOUPrint AS printStatus,
 paymentterm.strPaymentTerm AS PaymentTerms
FROM tbliouheader IOH
LEFT JOIN customers ON IOH.strCustomerID=customers.strCustomerID 
LEFT JOIN suppliers ON IOH.intExporterID=suppliers.strSupplierId
LEFT JOIN	forwaders ON IOH.intForwarder=forwaders.intForwaderID
LEFT JOIN wharfclerks ON IOH.intWharfClerk=wharfclerks.intWharfClerkID
LEFT JOIN deliverynote ON IOH.intDeliveryNo=deliverynote.intDeliveryNo
LEFT JOIN paymentterm ON IOH.strPaymentTerms=paymentterm.strPaymentTermID
WHERE IOH.intIOUNo='$invoiceNo'";
	
	$idresult=$db->RunQuery($sqlinvoiceheader);
	$dataholder=mysql_fetch_array($idresult);
	
	$dateVariable = $dataholder['dtmInvoiceDate'];
	$dateInvoice = substr($dateVariable, 0, 10); 
	//die ("$dateInvoice"); 
	$dateLC = $dataholder['LCDate'];
	$LCDate = substr($dateLC, 0, 10); 
	  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web :: Export :: Commercial Invoice</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
.fontColor12 {FONT-SIZE:7PT; FONT-FAMILY:Verdana; }
.adornment10 {border-color:#000000; border-style:none; border-bottom-width:0PX; border-left-width:0PX; border-top-width:0PX; border-right-width:0PX; }
.fontColor121 {FONT-SIZE:21PT;  FONT-FAMILY:Verdana; }
.fontColor10 {FONT-SIZE:9PT;  FONT-FAMILY:Verdana; }
-->
</style>
</head>

<body>
<table width="618" height="907" border="0" align="center">
  <tr>
    <td width="608" height="193" ><table width="88%" cellpadding="0" cellspacing="0">
      
      <tr>
        <td width="17%" rowspan="4" ><img   src="../images/callogo.jpg" width="62" height="50" align="top" /></td>
        <td width="166%" colspan="2" ><div align="left"><span class="tophead"><?php echo $Company; ?>.</span></div></td>
      </tr>
      <tr>
        <td height="18" colspan="2" class="normalfnt"><div align="left"><span class="normalfnBLD1"><?php echo $Address." ".$City.", ".$Country.".";?></span></div></td>
        </tr>
      <tr>
        <td height="18" colspan="2" class="normalfnt"><div align="left"><span class="normalfnBLD1">Tel- <?php echo $phone; ?> Fax: <?php echo $Fax; ?></span></div></td>
        </tr>
      <tr>
        <td height="19" colspan="2" class="normalfnt"><div align="left"><span class="normalfnBLD1">email: <?php echo $Email;?> Web Site : <?php echo $Website; ?></span></div></td>
        </tr>
      
      <tr>
        <td height="85" colspan="3" ><table width="588" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="15" rowspan="4"></td>
            <td width="352" rowspan="4"><fieldset style="width:350px;  height:20; border-color:#000080 " class="roundedCorners" >
              <legend><span style="background-color:#ffffff" class="normalfnt"><strong>&nbsp;Customer:&nbsp;</strong></span></legend>
              <span class="fontColor10"></span>
              <table width="349" border="0" class="fontColor10">
                <tr>
                  <td width="53" height="20" class="normalfnt">Name</td>
                  <td width="286" class="normalfnt">:<?php echo $dataholder['customer'];?></td>
                </tr>
                <tr height="3">
                  <td height="20" class="normalfnt">Address</td>
                  <td class="normalfnt_size10">:<?php echo $dataholder['customeraddress'];?></td>
                </tr>
                <tr>
                  <td height="16" class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                </tr>
              </table>
            </fieldset></td>
            <td width="10">&nbsp;</td>
            <td width="211" rowspan="4"><div align="left" class="normalfnt">
              <fieldset style="width:190px; border-color:#000080;" class="fontColor10 roundedCorners">
                <div align="right"><span class="fontColor10"> </span>
                  <table width="209" height="80" border="0" class="normalfnt">
                    <tr>
                      <td width="47" height="20" class="normalfnt"><span class="normalfnt_size10" style="width:350px;border-color:#000080 "><strong>Date&nbsp;</strong></span><span class="roundedCorners" style="width:350px;border-color:#000080 "><span class="fontColor10"><strong>&nbsp;</strong></span></span></td>
                          <td width="152" class="normalfnt_size10">:<?php echo date("d/m/Y");?></td>
                        </tr>
                    <tr>
                      <td height="20" class="normalfnt"><span class="normalfnt_size10">Inv No</span></td>
                          <td class="normalfnt_size10">:<?php echo $dataholder['intIOUNo'];?></td>
                        </tr>
                    <tr>
                      <td height="14" class="normalfnt"><span class="normalfnt_size10">SE NO&nbsp;</span></td>
                          <td class="normalfnt_size10">:</td>
                        </tr>
                    <tr>
                      <td height="16" class="normalfnt"><span class="normalfnt_size10">Im/Ex</span></td>
                          <td class="normalfnt_size10">:IMPORT</td>
                        </tr>
                  </table>
                </div>
              </fieldset>
            </div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="28">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="80"><table width="97%" border="0" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" id="tblInvoice" class="normalfnt" >
      <tr>
        <td colspan="5" ><div align="center" class="normalfnt2bldBLACKmid"><strong>IOU INVOICE </strong></div></td>
      </tr>
      
      <tr>
        <td width="21%" >Vessel Name </td>
        <td width="33%" class="border-bottom" ><span class="fontColor10"><?php echo $dataholder['vessel'];?></span></td>
        <td width="13%" >&nbsp;&nbsp;No of Ctns </td>
        <td width="33%" colspan="2" class="border-bottom" ><span class="fontColor10"><?php echo $dataholder['dblPackages'];?></span></td>
      </tr>
      <tr>
        <td >Custom Entry No </td>
        <td class="border-bottom"><?php echo $dataholder['strEntryNo'];?></td>
        <td ><strong>&nbsp;&nbsp;Imp.Ref</strong></td>
        <td colspan="2" class="border-bottom"><span class="fontColor10"><?php echo $dataholder['dblPackages'];?></span></td>
      </tr>
      <tr>
        <td >Customer Vat No. </td>
        <td class="border-bottom">114316598-700</td>
        <td >&nbsp;</td>
        <td colspan="2" >&nbsp;</td>
      </tr>
      <tr>
        <td height="13" colspan="5" >&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td height="73"  ><table width="597" border="0" cellspacing="0">
      <tr height="13">
        <td width="26" class="border-top-left-fntsize10">&nbsp;</td>
        <td width="342" class="border-top-fntsize10"><strong>PERTICULARS</strong></td>
        <td width="100" class="border-top-left-fntsize10"t">&nbsp;</td>
        <td width="121" class="border-Left-Top-right-fntsize10"><div align="center"><strong>AMOUNT</strong></div></td>
      </tr>
		 <tr>
		   <td colspan="2" class="border-top-left">&nbsp;</td>
		   <td class="border-top-left"t">&nbsp;</td>
		   <td class="border-Left-Top-right">&nbsp;</td>
	    </tr>
		<?php
			//set proper font class		
		
		$sql="SELECT 
				(SELECT strDescription FROM expensestype WHERE 
				tblioudetails.intExpensesID=expensestype.intExpensesID)AS Expense, 
				dblEstimate, dblActual, 
				(dblActual-dblEstimate)AS short,
				dblInvoice
				FROM tblioudetails WHERE intIOUNo='$invoiceNo'";
		//die($sql);
			$result= $db -> RunQuery ($sql);
		$totEstimate=0;
		$intnum=1;
		while($row=mysql_fetch_array($result))
		{
		if($intnum<10)
			$lineno="<strong>0".$intnum.".</strong>";
			else
		$lineno="<strong>".$intnum.".</strong>";
		 echo"<tr> <td width='26' class='border-top-left'><div align='left' >".$lineno."</div></td>
		 <td width='342'  class='border-top' >".$row['Expense']."</td>";
		 echo"<td width='100' class='border-top-left't'>&nbsp;</td>";
		 $totEstimate+=$row['dblEstimate'];
		 $totActual+=$row['dblActual'];		 
		 $totShortage+=$row['short'];
		 $totinvoice+=$row['dblInvoice'];
		 
		 echo " <td width='121' class='border-Left-Top-right'><div align='right' >".$row['dblInvoice']."</div></td>";
		 
		 
		 //echo"<td td width='121' class='border-bottom-right' ><div align='right' >".$row['dblInvoice']."</div></td>";
		 //echo"</tr>";
		 $intnum++;
		}
		echo"<tr><td class='border-top-left'  colspan='3' style='text-align:right'><strong>Total Amount Payable</strong></td>
		<td class='border-Left-Top-right'><div align='right' ><strong>". $totinvoice. "</strong></div></td>"; 
		?>
		<tr>
		   <td height="23" colspan="2" class="border-top-bottom">(Tear off)</td>
		   <td class="border-top-bottom"t">&nbsp;</td>
		   <td class="border-top-bottom">&nbsp;</td>
	    </tr>
    </table></td>
  </tr>
  <tr ><td width="608" height="2" >
  </td>
  </tr>
  <tr ><td width="608" height="2" >
  </td>
  </tr>
  
  <tr ><td width="608" height="2" >
  </td>
  </tr>
  <tr ><td width="608" height="2" >
  </td>
  </tr>
  <tr ><td width="608" height="197" ><table width="604" border="0" >
  
  <tr>
    <td width="72" rowspan="4"><div align="center"><img src="../images/callogo.jpg" width="62" height="50" align="top" /></div></td>
    <td width="493"><div align="left"><span class="tophead"><?php echo $Company; ?>.</span></div></td>
  </tr>
  
  <tr>
    <td><span class="normalfnBLD1"><?php echo $Address." ".$City.", ".$Country.".";?></span></td>
  </tr>
  <tr>
    <td height="20"><span class="normalfnBLD1">Tel- <?php echo $phone; ?> Fax: <?php echo $Fax; ?></span></td>
  </tr>
  <tr>
    <td><span class="normalfnBLD1">email: <?php echo $Email;?> Web Site : <?php echo $Website; ?></span></td>
  </tr>
  
  <tr>
    <td colspan="2"><div align="center" class="normalfnt2bldBLACKmid">TAX INVOICE </div></td>
  </tr>
  
  <tr>
    <td height="71" colspan="2"><table width="599" border="0">
      <tr>
        <td width="118" class="normalfnBLD1">Vat Reg. No.</td>
        <td width="232"><span class="normalfnt"><?php echo $dataholder['vatno'];?></span></td>
        <td width="70"><span class="normalfnBLD1">Date </span></td>
        <td width="161"><span class="normalfnt"><?php echo date("d/m/Y");?></span></td>
      </tr>
      <tr>
        <td class="normalfnBLD1">Customer Name </td>
        <td class="normalfnt"><?php echo $dataholder['customer'];?></td>
        <td><span class="normalfnBLD1">Invoice No </span></td>
        <td><span class="normalfnt"><?php echo $dataholder['intIOUNo'];?></span></td>
      </tr>
      <tr>
        <td height="21"><span class="normalfnBLD1">Customer Vat No </span></td>
        <td><span class="normalfnt"><?php echo $dataholder['vatno'];?></span></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>

    </table></td>
    </tr>
  </table>
</tr>
  <tr>
    <td height="21">
	<table width="606" border="0" cellspacing='0' class='normalfnt'>
      <tr>
        <td class='border-top-left'>&nbsp;</td>
        <td width="450" class='border-top'>01. HangingCharges </td>
        <td width="113" class="border-Left-Top-right">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class='border-top-left'>&nbsp;</td>
        <td class="border-Left-Top-right">&nbsp;</td>
      </tr>
      <tr>
        <td class='border-top-left'>&nbsp;</td>
        <td class='border-top'>02. Docmentation Charges </td>
        <td class="border-Left-Top-right">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class='border-top-left'>&nbsp;</td>
        <td class="border-Left-Top-right">&nbsp;</td>
      </tr>
      <tr>
        <td class='border-top-left'>&nbsp;</td>
        <td class='border-top'>03. AgencyFee </td>
        <td class="border-Left-Top-right">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class='border-top-left'>&nbsp;</td>
        <td class="border-Left-Top-right">&nbsp;</td>
      </tr>
      <tr>
        <td class='border-top-left'>&nbsp;</td>
        <td class='border-top'>04. Other </td>
        <td class="border-Left-Top-right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-top-left"><div align="right">Sub Total </div></td>
        <td class="border-Left-Top-right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-left"><div align="right" class="normalfnt2bldBLACK">VAT 12% </div></td>
        <td class="border-Left-bottom-right" >&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-left"><div align="right">Total</div></td>
        <td class="border-Left-bottom-right" >&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2" class="border-bottom-left">&nbsp;</td>
        <td class="border-Left-bottom-right">&nbsp;</td>
      </tr>
	  
		<tr>
        <td colspan="3"><table width="607" border="0" cellspacing='0'>
          <tr>
            <td width="90" class="normalfnBLD1">Bill Amount </td>
            <td width="173" class="border-bottom">&nbsp;</td>
            <td width="107">&nbsp;</td>
            <td width="228">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td><span class="normalfnBLD1">Balance</span></td>
            <td class="border-bottom">&nbsp;</td>
            <td>&nbsp;</td>
            <td class="border-bottom">&nbsp;</td>
          </tr>
          <tr>
            <td height="15">&nbsp;</td>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center"><span class="normalfnBLD1">Authorized Signature </span></div></td>
          </tr>
        </table></td>
        </tr>
		
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td colspan="2" class="normalfnBLD1"><div align="left">Chequea Should be draw in favour of &quot;Califolink Logistics(Pvt)Ltd&quot; &amp; A/C Payee only. </div></td>
	    </tr>
		<tr>
        <td height="15">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		</tr>
  </table>
  </tr>
  <tr>
    <td height="27">  </tr>
</table>

<p>&nbsp;</p>
</body>
</html>
