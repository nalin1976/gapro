<?php 
	session_start();
	include("../../../Connector.php");	
	$xmldoc=simplexml_load_file('../../../config.xml');
	
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receipt</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="500" border="0" cellspacing="0" class="normalfnt_size12">
  <tr>
    <td width="50">&nbsp;</td>
    <td width="100" rowspan="2" ><span class="head2BLCK"><img src="../../../images/callogo.jpg" alt="logo" width="62" height="50" /></span></td>
    <td width="100">&nbsp;</td>
    <td width="100">&nbsp;</td>
    <td width="100">&nbsp;</td>
    <td width="50">&nbsp;</td>
  </tr>
  <tr>
    <td height="39">&nbsp;</td>
    <td colspan="2" class="head2BLCK">Receipt</td>
    <td class="head2BLCK">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="4" class="head2BLCK" bgcolor="#669966" height="3"></td>
    <td></td>
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
    <td><?php echo date("d-M-y");?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4"><dd>Received with thanks from :</dd></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">
      <p align="center" class="normalfnt2bldBLACK"><?php echo $customer;?></p>
    </dd></td>
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
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><dd>Reference Number </dd></td>
     <td colspan="2">:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><dd></td>
    <td colspan="3" class="normalfnt2bldBLACK"><?php echo $advserialno;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><dd/>Description</td>
    <td colspan="2">:</td>
  </tr>  
  <tr>
    <td>&nbsp;</td>
    <td><dd></td>
    <td colspan="3" class="normalfnt2bldBLACK"><?php echo $invoiceno;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><dd>Amount Received </dd></td>
    <td colspan="2">:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><dd></td>
    <td colspan="3" class="normalfnt2bldBLACK"><?php echo number_format($allocatingamt,2);?></td>
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
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" class="cusdec-normalfnt2bldBLACK">
    <div align="center"><?php echo $Company;?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" class="normalfnt"><div align="center"><?php echo $Address." ".$City;?></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4" class="normalfnt">
    <div align="center"><?php echo "Tel :".$phone." Fax : ".$Fax;?></div></td>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>
