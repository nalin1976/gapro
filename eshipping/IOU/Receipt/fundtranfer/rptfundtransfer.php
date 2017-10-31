<?php 
	session_start();
	include("../../../Connector.php");	
	$xmldoc=simplexml_load_file('../../../config.xml');
	$serial=$_GET["frmserial"];
	
	$Company=$xmldoc->companySettings->Declarant;
	$Address=$xmldoc->companySettings->Address;
	$City=$xmldoc->companySettings->City;
	$phone=$xmldoc->companySettings->phone;
	$Fax=$xmldoc->companySettings->Fax;
	$email=$xmldoc->companySettings->Email;
	$Website=$xmldoc->companySettings->Website;
	$Country=$xmldoc->companySettings->Country;
	$Vat=$xmldoc->companySettings->Vat;
	$customerid=$_GET["customerid"];
	$advserialno=$_GET["advserialno"];
	$amount=$_GET["amount"];
	$invoiceno=$_GET["invoiceno"];
	$allocatingamt=$_GET["allocatingamt"];
	$str="select strName from customers where strCustomerID='$customerid'";
	$results=$db->RunQuery($str);
	$row=mysql_fetch_array($results);
	$customer=$row["strName"];
	
	$strheader="select 	strFTserial, 
							intbankId, 
							dtmDate, 
							dblTotal	 
							from 
							fundtransferheader 
							where strFTserial='$serial'";
	$resultheader=$db->RunQuery($strheader);
	$rowhead=mysql_fetch_array($resultheader);
			$bankid=$rowhead["intbankId"];
			
	$strBank="select 	strBankCode, 
						strName, 
						strAddress1, 
						strAddress2
						from 
						bank 
						where strBankCode='$bankid'";	
	$resultbank=$db->RunQuery($strBank);
	$rowbank=mysql_fetch_array($resultbank);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receipt</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.companyTital{
	font-family: Verdana;
	font-size: 36px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.letterHead2{
	font-family: "Times New Roman", Times, serif;
	font-size: 15px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	font-weight:600;
	
}	
.letterHead3{
	font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	font-weight:600;
	
}	
.letter{
	font-family:"Times New Roman", Times, serif;
	font-size: 14px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:600;
}
.companyTital1 {	font-family: Verdana;
	font-size: 36px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.letterHead31 {	font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:600;
}
.letter1 {	font-family:"Times New Roman", Times, serif;
	font-size: 14px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:600;
}
</style>
</head>

<body><table align="center" width="740" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="10%">&nbsp;</td>
    <td width="90%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <table width="100%" border="0" cellspacing="1" cellpadding="0" class="normalfnt">
        <tr>
          <td rowspan="4" width="9%" valign="top" ><div align="center"><img src="../../../images/callogo.jpg" alt="logo" width="62" height="50" /></div></td>
          <td width="91%"><span class="companyTital"><?php echo $Company;?></span></td>
        </tr>
        <tr>
          <td height="20"><i><?php echo $Address." ".$City.", ".$Country. ". Tel :".$phone." Fax : ".$Fax;?></i></td>
        </tr>
        <tr>
          <td height="20"><i><?php echo "Hot Line 947727737232 E-Mail :".$email." REG. NO. PV3481";?></i></td>
        </tr>
        <tr>
          <td height="20">&nbsp;</td>
        </tr>
      </table>
    </div></td>
  </tr>
  

  <tr>
    <td  colspan="2"  align="center" ><table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
    <td colspan="2" class="normalfnt_size12" ><dd><dd>THE MANAGER,</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt_size12" ><dd><dd><?php echo $rowbank["strName"];?>,</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt_size12" ><dd><dd><?php if($rowbank["strAddress1"])echo $rowbank["strAddress1"].",";?></td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt_size12" ><dd><dd><?php echo $rowbank["strAddress2"];?></td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt_size12" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt_size12" ><dd><dd><?php echo $rowhead["dtmDate"];?></td>
  </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt_size12" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnt_size12" ><dd>Dear Sir/ Madam,</td>
  </tr>
  <tr>
    <td height="30" colspan="2" class="letterHead2" ><dd><u>TRANSFER OF FUNDS.</u></td>
  </tr>
  <tr>
    <td colspan="2" class="letter"  height="25"><dd>&nbsp;&nbsp;&nbsp;&nbsp;Please be kind enouogh to debit our current account No 2289700029 &amp; proceed following fund transfers</td>
  </tr>
  <tr>
    <td class="letter" >&nbsp;</td>
    <td class="letter"><span class="letter1">as earliest.</span></td>
  </tr>
  <tr>
    <td colspan="2" >&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="2" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="letterHead3">
        <td width="15%">&nbsp;</td>
        <td  width="37%">&nbsp;<u>Name Of Account</u></td>
        <td width="20%">&nbsp;<u>Account Number</u></td>
        <td width="28%">
          <div align="center"><u>Amount</u></div></td>
      </tr>
	   <tr class="normalfnt_size12" >
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
	  <?php
	  	$strDetail="select 	strFTserial, 
					intWharfNo, 
					strAccountName, 
					strAccountNo, 
					dblAmount					 
					from 
					fundtransferdetail 
					where strFTserial='$serial';";
		$detailresult=$db->RunQuery($strDetail);
		$cnt=1;
		while($row=mysql_fetch_array($detailresult))
		{
	   ?>
     
      <tr class="normalfnt_size12" >
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="normalfnt-rite_size12" height="25"><?php echo $cnt;$cnt++;?></td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        <td>&nbsp;<?php echo $row["strAccountName"];?></td>
        <td>&nbsp;<?php echo $row["strAccountNo"];?></td>
        <td  class="normalfnt-rite_size12">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="62%" class="normalfnt-rite_size12"><?php echo number_format($row["dblAmount"],2);?></td>
              <td width="38%">&nbsp;</td>
            </tr>
          </table></td>
      </tr><?php } $cnt++; ?>
	   <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="63%"  class="border-bottom-fntsize12">&nbsp;</td>
            <td width="37%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
        <td class="letterHead3"><div align="center">Total</div></td>
        <td>&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="63%"  class="border-bottom-fntsize12 "><div class="normalfnt-rite_size12 letterHead3"><?php echo number_format($rowhead["dblTotal"],2);?></div></td>
            <td width="37%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
	  <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td width="63%"  class="border-top-fntsize12">&nbsp;</td>
            <td width="37%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>  
	  <?php for($i=$cnt;$i<21;$i++){?>
      <tr>
        <td height="25">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
     <?php }?>
	 <tr>
	   <td colspan="2" class="normalfnt_size12"  height="25"><dd>Thanking You, </td>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	   </tr>
	 <tr>
	   <td colspan="2" class="letterHead3"><dd><?php echo $Company;?></td>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	   </tr>
	 <tr>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	   </tr>
	 <tr>
	   <td colspan="2"><span class="letterHead31"><dd>..................................................</span></td>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	   </tr>
	 <tr>
	   <td colspan="2" class="normalfnt_size12"><dd>DIRECTOR/ AUTHORISED SIGNATORIES </td>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	   </tr>
	 <tr>
	   <td colspan="2" class="letterHead31"><dd>..................................................</td>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	   </tr>
	 <tr>
        <td colspan="2" class="normalfnt_size12"><dd>Director/ Authorized Signatories</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>  
    </table></td>
  </tr>
</table>

</body>
</html>
