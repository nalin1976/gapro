<?php 
	session_start();
	include("../../../Connector.php");	
	$xmldoc=simplexml_load_file('../../../config.xml');
	$noteno=$_GET["noteno"];
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
	
	$strheader="select 	strCnDNo, 
						dtmDate, 
						intCustomerId, 
						strVatNo, 
						strType
						 
						from 
						tblcndnoteheader 
						where strCnDNo='$noteno'";
	$resultheader=$db->RunQuery($strheader);
	$rowhead=mysql_fetch_array($resultheader);
	$CnDNo=$rowhead["strCnDNo"];
	$datearray=explode("-",$rowhead["dtmDate"]);
	$cnddate=$datearray[2]."/".$datearray[1]."/".$datearray[0];
	$type=$rowhead["strType"];
	$notetype=($type=='C'? "CREDIT NOTE":"DEBIT NOTE");
	$customerid=$rowhead["intCustomerId"];
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
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receipt</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body><table align="center" width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="65%">&nbsp;</td>
    <td width="35%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="bcgl1"><div align="center">
      <table width="90%" border="0" cellspacing="1" cellpadding="0" class="normalfnt">
        <tr>
          <td rowspan="4" width="30%" valign="top" ><div align="right"><img src="../../../images/callogo.jpg" alt="logo" width="62" height="50" /></div></td>
          <td width="70%"><span class="topheadBLACK"><?php echo $Company;?></span></td>
        </tr>
        <tr>
          <td height="20"><?php echo $Address." ".$City;?></td>
        </tr>
        <tr>
          <td height="20"><?php echo "Tel :".$phone." Fax : ".$Fax;?></td>
        </tr>
        <tr>
          <td height="20"><?php echo "E mail :".$email;?></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="head2"><?php echo $notetype;?></td>
  </tr>
  <tr>
    <td align="right"><fieldset style="width:90%;  height:20; border-color:#000080 " class="roundedCorners" >
              <legend><span style="background-color:#ffffff" class="normalfnt"><strong>&nbsp;Customer:&nbsp;</strong></span></legend>
              <span class="fontColor10"></span>
              <table width="100%" border="0" class="fontColor10">
                <tr>
                  <td width="25%" height="20" class="normalfnt">Name</td>
                  <td width="75%" class="normalfnt">:<?php echo $customername;?></td>
                </tr>
                <tr height="3">
                  <td height="20" class="normalfnt">Address</td>
                  <td class="normalfnt_size10">:<?php echo $customeraddress1." ".$customeraddress2;?></td>
                </tr>
                <tr>
                  <td height="16" class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                </tr>
              </table>
            </fieldset></td>
    <td align="center">
    <fieldset style="width:220px; border-color:#000080;" class="fontColor10 roundedCorners">
      <div align="right"><span class="fontColor10"> </span>
                  <table width="100%" height="62" border="0" class="normalfnt">
                    <tr>
                      <td width="103" height="20" class="normalfnt"><span class="roundedCorners" style="width:40%;border-color:#000080 "><span class="normalfnt_size10"><?php echo $notetype."  NO.";?></span></span></td>
                          <td width="107" class="normalfnt_size10">:<?php echo $CnDNo;?></td>
                    </tr>
                    <tr>
                      <td height="20" class="normalfnt"><span class="normalfnt_size10">Date</span></td>
                          <td class="normalfnt_size10">:<?php echo $cnddate;?></td>
                    </tr>
                    <tr>
                      <td height="14" class="normalfnt"><span class="normalfnt_size10">VAT Reg No</span></td>
                          <td class="normalfnt_size10">:</td>
                    </tr>
                  </table>
                </div>
              </fieldset>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="left">
      <table width="90%" border="0"  cellspacing="0" cellpadding="0" class="normalfnt">
        <tr >
          <td width="55%" height="22" class="border-top-left-fntsize12"><strong>Debit Detail</strong></td>
          <td width="15%"  class="border-top-left-fntsize12"><div align="center"><strong>Value</strong></div></td>
          <td width="15%"  class="border-top-left-fntsize12"><div align="center"><strong>VAT</strong></div></td>
          <td width="15%" class="border-Left-Top-right-fntsize12"><div align="center"><strong>Total</strong></div></td>
        </tr>
		 <tr bgcolor="#FFFFFF">
          <td class="border-top-left-fntsize12">&nbsp;</td>
          <td class="border-top-left-fntsize12">&nbsp;</td>
          <td class="border-top-left-fntsize12">&nbsp;</td>
          <td class="border-Left-Top-right-fntsize12">&nbsp;</td>
        </tr>
		<?php $str_detail="select 	strCnDNo, 
									intInvoiceNo, 
									strDescription, 
									dblAmount, 
									dblVat, 
									dblTotal
									 
									from 
									tblcndnotedetail 
									where strCnDNo='$noteno'";
				
				$result_details=$db->RunQuery($str_detail);
				$count=0;
				
		 while($detail_row=mysql_fetch_array($result_details)) { $count++;	?>
       
        <tr bgcolor="#FFFFFF">
          <td class="border-left-fntsize12"><span class="normalfnt"><?php echo "  ".$detail_row["strDescription"];?></span></td>
          <td class="border-left-fntsize12"><div class="normalfntRite"><?php echo $detail_row["dblAmount"]." ";?></div></td>
          <td class="border-left-fntsize12"><div class="normalfntRite"><?php echo number_format($detail_row["dblVat"],2)."  ";?></div></td>
          <td class="border-left-right-fntsize12"><div class="normalfntRite"><?php echo  number_format($detail_row["dblTotal"],2)."  ";?></div></td>
        </tr>
		<tr bgcolor="#FFFFFF">
          <td class="border-left-fntsize12">&nbsp;</td>
          <td class="border-left-fntsize12">&nbsp;</td>
          <td class="border-left-fntsize12">&nbsp;</td>
          <td class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
		<?php }?>
		 
        <tr bgcolor="#FFFFFF">
          <td class="border-top-fntsize12">&nbsp;</td>
          <td class="border-top-fntsize12">&nbsp;</td>
          <td class="border-top-fntsize12">&nbsp;</td>
          <td class="border-top-fntsize12">&nbsp;</td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td class="normalfnt_size12">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="normalfnt_size12">Your account has credited the above amount</span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="normalfnt_size12"><?php echo $Company;?></td>
  </tr>
  <tr>
    <td height="19">&nbsp;</td>
    <td rowspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="72%" class="border-bottom-fntsize12">&nbsp;</td>
        <td width="28%">&nbsp;</td>
      </tr>
      <tr>
        <td><div align="center" class="normalfnt-center_size12">Authorized Signature</div></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>
