<?php 
	session_start();
	include("../../Connector.php");	
	$xmldoc=simplexml_load_file('../../config.xml');
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report :: IOU Summery</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><table width="90%" border="0" cellspacing="1" cellpadding="0" class="normalfnt">
      <tr>
        <td rowspan="4" width="30%" valign="top" ><div align="right"><img src="../../images/callogo.jpg" alt="logo" width="62" height="50" /></div></td>
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
    </table></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr bgcolor="#666666">
        <td width="10%" height="31" bgcolor="#999999"><div align="center" class="normalfnt2bldBLACKmid">Invoice No</div></td>
        <td width="10%" bgcolor="#999999"><div align="center" class="normalfnt2bldBLACKmid">IOU No</div></td>
        <td width="30%" bgcolor="#999999"><div align="center" class="normalfnt2bldBLACKmid">Consignee</div></td>
        <td width="10%" bgcolor="#999999"><div align="center" class="normalfnt2bldBLACKmid">Date</div></td>
        <td width="20%" bgcolor="#999999"><div align="center" class="normalfnt2bldBLACKmid">Total Amount</div></td>
        <td width="20%" bgcolor="#999999"><div align="center" class="normalfnt2bldBLACKmid">Received Amount</div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
