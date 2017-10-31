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
$invoiceNo=$_GET['iouNo'];	

				$str_header="select 	intInvoiceNo, 
										intIOUNo, 
										strCustomerID, 
										date(dtmInvoiceDate) as dtmInvoiceDate, 
										strEntryNo, 
										strSENo, 
										dblAgencyFee, 
										dblDocumentation, 
										dblHanging, 
										dblOther, 
										dblTotalAmount, 
										dblPayableAmt, 
										dblAdvAllocated,
										intVat,
										(select	strType	from tbliouheader ih where ih.intIOUNo=tbliouinvoice.intIOUNo) as type									
										from 
										tbliouinvoice 
										where intIOUNo='$invoiceNo'";
									//die($str_header);	
				$result_header=$db->RunQuery($str_header);
				$row_header=mysql_fetch_array($result_header);
						$customerid=$row_header["strCustomerID"];
						$invoicedate=explode("-",$row_header["dtmInvoiceDate"]);
						$invoicedate=$invoicedate[2]."/".$invoicedate[1]."/".$invoicedate[0];
						$InvoiceNo=$row_header["intInvoiceNo"];
						$type=$row_header["type"];
							if($type=='IM')
								$type='IMPORT';
							else if ($type=='EX')
								$type='EXPORT';
						$AgencyFee=$row_header["dblAgencyFee"];
						$Documentation=$row_header["dblDocumentation"];
						$Hanging=$row_header["dblHanging"];
						$Other=$row_header["dblOther"];
						$TotalAmount=$row_header["dblTotalAmount"];
						$incVat=$row_header["intVat"];
						$seno=$row_header["strSENo"];

				$str_customer="select 	strCustomerID, 
										intSequenceNo, 
										strName, 
										strAddress1, 
										strAddress2, 
										strCountry, 
										strTIN, 
										strCode, 
										strLocation, 
										strTQBNo, 
										strExportRegNo, 
										strRefNo, 
										strCompanyCode, 
										RecordType, 
										strPPCCode, 
										bitLocatedAtAZone, 
										strAuthorizedPerson, 
										strVendorCode, 
										strMIDCode, 
										bitMailClearanceInfo, 
										intDelStatus, 
										strLicenceNo							 
										from 
										customers 
										where strCustomerID='$customerid';";
				$result_customer=$db->RunQuery($str_customer);
				$row_customer=mysql_fetch_array($result_customer);
												$customername=$row_customer['strName'];
												$customeraddress1=$row_customer['strAddress1'];
												$customeraddress2=$row_customer['strAddress2'];
												$tin=$row_customer['strTIN'];
	$str_advance="select sum(dblamount) as advance from 	advancedetail where intiouno='$invoiceNo'";
	$result_advance=$db->RunQuery($str_advance);
	$row_advance=mysql_fetch_array($result_advance);
	$advance=(($row_advance["advance"]) ? $row_advance["advance"]:0);
													
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>IOU Invoice</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.normaltext{
color:#000000;
font-family:Verdana;
font-size:11px;
font-weight:normal;
line-height:14px;
margin:0;

}
.header1text{
color:#000000;
font-family:Verdana;
font-size:24px;
font-weight:normal;
line-height:30px;
margin:0;
font-weight:500;
}
.header2text{
color:#000000;
font-family:Verdana;
font-size:12px;
font-weight:normal;
line-height:14px;
margin:0;
font-weight:500;
}
.header3text{
color:#000000;
font-family:Verdana;
font-size:14px;
font-weight:normal;
line-height:16px;
margin:0;
font-weight:500;
}
.header1text1 {color:#000000;
font-family:Verdana;
font-size:24px;
font-weight:normal;
line-height:30px;
margin:0;
font-weight:500;
}
.header2text1 {color:#000000;
font-family:Verdana;
font-size:12px;
font-weight:normal;
line-height:14px;
margin:0;
font-weight:500;
}
</style>
</head>
<body>
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%" rowspan="4"><div align="right"><img src="../../images/callogo.jpg" alt="logo" width="62" height="50" /></div></td>
        <td width="80%" class="header1text"><?php echo $Company;?></td>
      </tr>
      <tr>
        <td class="header2text" height="15"><span class="normalfnBLD1"><?php echo $Address." ".$City.", ".$Country.".";?></span></td>
      </tr>
      <tr>
        <td class="header2text" height="15"><span class="normalfnBLD1">Tel- <?php echo $phone; ?> Fax: <?php echo $Fax; ?></span></td>
      </tr>
      <tr>
        <td class="header2text" height="15"><span class="normalfnBLD1">email: <?php echo $Email;?> Web Site : <?php echo $Website; ?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div align="center">
      <table width="80%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="60%"><fieldset style="width:100%;  border-color:#000080 " class="roundedCorners" >
              <legend><span style="background-color:#ffffff" class="normalfnt"><strong>&nbsp;Customer:&nbsp;</strong></span></legend>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="normaltext">
                <tr>
                  <td width="30%" height="22">&nbsp;&nbsp;&nbsp;Name</td>
                  <td width="70%">:<?php echo $customername;?></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;Address</td>
                  <td>:<?php echo $customeraddress1.", ".$customeraddress2;?></td>
                </tr>
              </table>
              <span class="fontColor10"></span>
          </fieldset></td>
          <td width="5%">&nbsp;</td>
		  <td width="35%">
		  <fieldset style="width:100%; border-color:#000080;" class="fontColor10 roundedCorners">
              <div align="right"><span class="fontColor10"> </span>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="normaltext">
                  <tr>
                    <td width="35%">&nbsp;&nbsp;&nbsp;Date</td>
                    <td width="65%">:<?php echo $invoicedate;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;&nbsp;&nbsp;Invoice No</td>
                    <td>:<?php echo $InvoiceNo;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;&nbsp;&nbsp;SE No </td>
                    <td>:<?php echo $seno;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;&nbsp;&nbsp;Im/Ex</td>
                    <td>:<?php echo $type;?></td>
                  </tr>
                </table>
              </div>
              </fieldset>		  </td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td class="header3text" align="center" height="25" >IOU INVOICE</td>
  </tr>
  <tr>
    <td class="header3text" align="center" height="18" valign="bottom"><table width="80%" border="0" cellspacing="0" cellpadding="0" class="normaltext">
      <tr>
        <td width="20%">&nbsp;&nbsp;&nbsp;Vessel Name</td>
        <td class="border-bottom-fntsize12" width="30%">&nbsp;</td>
        <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No of Ctns</td>
        <td class="border-bottom-fntsize12" width="30%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;Custom Entry No </td>
        <td class="border-bottom-fntsize12">&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Ref</strong></td>
        <td class="border-bottom-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;Customer Vat No.</td>
        <td class="border-bottom-fntsize12">&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div align="center">
      <table width="80%" border="0" cellspacing="0" cellpadding="0" class="normaltext">
        <tr>
          <td class="border-top-left-fntsize12" width="5%">&nbsp;</td>
		  <td colspan="2" class="border-top-fntsize12" width="60%"><strong>PARTICULARS</strong></td>
          <td class="border-top-left-fntsize12" width="15%"><div align="center">&nbsp;</div></td>
          <td class="border-Left-Top-right-fntsize12"  width="20%"><div align="center"><strong>AMOUNT</strong></div></td>
        </tr>
		<tr>
          <td class="border-top-left-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12" colspan="2">&nbsp;</td>
		  <td class="border-top-left-fntsize12">&nbsp;</td>
		  <td class="border-Left-Top-right-fntsize12">&nbsp;</td>
        </tr>
		<?php
				$str_detail="SELECT (SELECT strDescription FROM expensestype et WHERE 
									idtl.intExpensesID= et.intExpensesID)AS Expense, 
									dblEstimate, dblActual, 
									dblInvoice
									FROM tblioudetails idtl WHERE intIOUNo='$invoiceNo' and intOtherExpense=0 and intDoInvoice=1";
				$result_details=$db->RunQuery($str_detail);
				$count=0;
				$tot=0;
		 while(($detail_row=mysql_fetch_array($result_details)) && ($count<18)) { $count++;	$tot+=$detail_row["dblInvoice"]; ?>
		<tr>
          <td class="border-top-left-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12" colspan="2"><div class="normalfnt"><?php echo $detail_row["Expense"];?></div></td>
		  <td class="border-top-left-fntsize12">&nbsp;</td>
		  <td class="border-Left-Top-right-fntsize12"><div class="normalfntRite"><?php echo number_format($detail_row["dblInvoice"],2);?></div></td>
        </tr>
		<?php } ?>
		<tr>
          <td class="border-top-left-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12" width="5%">&nbsp;</td>
		  <td class="border-top-fntsize12" width="55%"><div class="normalfnt"><strong>OTHER</strong></div></td>
		  <td class="border-top-left-fntsize12">&nbsp;</td>
		  <td class="border-Left-Top-right-fntsize12">&nbsp;</td>
        </tr>
		<?php
				$str_detail_other="SELECT (SELECT strDescription FROM expensestype et WHERE 
									idtl.intExpensesID= et.intExpensesID)AS Expense, 
									dblEstimate, dblActual, 
									dblInvoice
									FROM tblioudetails idtl WHERE intIOUNo='$invoiceNo' and intOtherExpense=1 ";
				$result_details_other=$db->RunQuery($str_detail_other);
								
		 while(($detail_row_other=mysql_fetch_array($result_details_other)) && ($count<25)) { $count++; $tot+=$detail_row_other["dblInvoice"];?>
		<tr>
          <td class="border-top-left-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12" >&nbsp;</td>
		  <td class="border-top-fntsize12"><dd><div class="normalfnt"><?php echo $detail_row_other["Expense"];?></div></td>
		  <td class="border-top-left-fntsize12">&nbsp;</td>
		  <td class="border-Left-Top-right-fntsize12"><div class="normalfntRite"><?php echo number_format($detail_row_other["dblInvoice"],2);?></div></td>
        </tr>
		<?php } ?>
		<?php while($count<25) { $count++; ?>
		<tr>
          <td class="border-top-left-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12" >&nbsp;</td>
		  <td class="border-top-fntsize12"><dd><div class="normalfnt"></div></td>
		  <td class="border-top-left-fntsize12">&nbsp;</td>
		  <td class="border-Left-Top-right-fntsize12"><div class="normalfntRite"></td>
        </tr>
		<?php } ?>
		<tr>
          <td class="border-top-bottom-left-fntsize12">&nbsp;</td>
          <td class="border-top-bottom-fntsize12" colspan="3"><div class="normalfntRite"><strong>TOTAL AMOUNT PAYABLE * </strong></div></td>
		  <td class="border-All-fntsize12"><div class="normalfntRite"><strong><?php echo number_format($tot,2);?></strong></div></td>
        </tr>
       </table>
    </div></td>
  </tr>
  <tr>
    <td class="border-bottom-fntsize10" height="25">(Tear Off) </td>
  </tr>
  <tr>
    <td  height="18">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%" rowspan="4"><div align="right"><img src="../../images/callogo.jpg" alt="logo" width="62" height="50" /></div></td>
        <td width="80%" class="header1text1" height="30"><?php echo $Company;?></td>
      </tr>
      <tr>
        <td class="header2text1" height="15"><span class="normalfnBLD1"><?php echo $Address." ".$City.", ".$Country.".";?></span></td>
      </tr>
      <tr>
        <td class="header2text1" height="15"><span class="normalfnBLD1">Tel- <?php echo $phone; ?> Fax: <?php echo $Fax; ?></span></td>
      </tr>
      <tr>
        <td class="header2text1" height="15"><span class="normalfnBLD1">email: <?php echo $Email;?> Web Site : <?php echo $Website; ?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="header3text" align="center" height="25" >TAX INVOICE</td>
  </tr>
  <tr>
    <td><table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td width="20%" height="20"><span class="normalfnBLD1">Vat Reg. No.</span></td>
        <td width="40%" class="normalfnt"><?php echo $tin;?></td>
        <td width="15%"><span class="normalfnBLD1">Date </span></td>
        <td width="15%" class="normalfnt"><?php echo $invoicedate;?></td>
      </tr>
      <tr>
        <td><span class="normalfnBLD1" height="20">Customer Name </span></td>
        <td class="normalfnt"><?php echo $customername;?></td>
        <td><span class="normalfnBLD1">Invoice No</span></td>
        <td class="normalfnt"><?php echo $InvoiceNo;?></td>
      </tr>
      <tr>
        <td><span class="normalfnBLD1" height="20">Customer Vat No</span></td>
        <td class="normalfnt"><?php echo $tin;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="80%" border="0" cellspacing="0" cellpadding="0" class='normalfnt'>
      <tr>
        <td height="10" width="70%"></td>
        <td width="20%"></td>
      </tr>
      <tr>
        <td  class='border-top-left'><dd>01. HangingCharges</td>
        <td class="border-Left-Top-right"><div class="normalfntRite"><?php echo number_format($Hanging,2);?></div></td>
      </tr>
      <tr>
        <td  class='border-top-left'>&nbsp;</td>
        <td class="border-Left-Top-right">&nbsp;</td>
      </tr>
      <tr>
        <td  class='border-top-left'><dd>02. Docmentation Charges</td>
        <td class="border-Left-Top-right"><div class="normalfntRite"><?php echo number_format($Documentation,2);?></div></td>
      </tr>
      <tr>
        <td  class='border-top-left'>&nbsp;</td>
        <td class="border-Left-Top-right">&nbsp;</td>
      </tr>
      <tr>
        <td  class='border-top-left'><dd>03. AgencyFee</td>
        <td class="border-Left-Top-right"><div class="normalfntRite"><?php echo number_format($AgencyFee,2);?></div></td>
      </tr>
      <tr>
        <td  class='border-top-left'>&nbsp;</td>
        <td class="border-Left-Top-right">&nbsp;</td>
      </tr>
      <tr>
        <td  class='border-top-left'><dd><span>04. Other </span></td>
        <td class="border-Left-Top-right"><div class="normalfntRite"><?php echo number_format($Other,2);?></div></td>
      </tr>
      <tr>
        <td  class='border-top-left' height="20"><div align="right">Sub Total </div></td>
        <td class="border-Left-Top-right"><div class="normalfntRite"><?php $tot=$Other+$AgencyFee+$Documentation+$Hanging; echo number_format($tot,2);?></div></td>
      </tr>
      
      <tr>
        <td class="border-left"><div align="right" class="normalfnt2bldBLACK">VAT 12% </div></td>
        <td class="border-Left-bottom-right"><div class="normalfntRite"><?php $vatamt=($incVat==1?($tot*12/100):0); echo number_format($vatamt,2);?></div></td>
      </tr>
      
      <tr>
        <td  class="border-bottom-left"><div align="right">Total</div></td>
        <td class="border-Left-bottom-right"><div class="normalfntRite"><?php $tot+=$vatamt; echo number_format($tot,2);?></div></td>
      </tr>
     
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="70%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      
      <tr>
        <td height="25" width="25%"><span class="normalfnBLD1">Bill Amount</span></td>
        <td width="30%" ><div class="normalfntRite"><?php $bill_amt=$TotalAmount+$vatamt; echo number_format($bill_amt,2);?></div></td>
        <td width="10%">&nbsp;</td>
        <td width="40%">&nbsp;</td>
      </tr>
      <tr>
        <td height="25"><span class="normalfnBLD1">Advance Anount </span></td>
        <td class="border-bottom"><div align="right"><span class="normalfntRite"><?php echo number_format($advance,2);?></span></div></td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td height="25"><span class="normalfnBLD1">Balance</span></td>
        <td class="border-bottom"><div class="normalfntRite"><?php echo number_format($bill_amt-$advance,2);?></div></td>
        <td>&nbsp;</td>
        <td class="border-bottom">&nbsp;</td>
      </tr>
	   <tr>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td ><div align="center"><span class="normalfnBLD1">Authorized Signature </span></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="normalfnBLD1">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnBLD1"><div align="center">Cheques Should be draw in favour of &quot;Califolink Logistics(Pvt)Ltd&quot; &amp; A/C Payee only. </div></td>
  </tr>
</table>
</body>
</html>
