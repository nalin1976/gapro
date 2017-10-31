<?php 
session_start();
include "../../../../Connector.php";
$xmldoc=simplexml_load_file('../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

$dispatchNo=$_GET['dispatchNo'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Vessal Transfer Report</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="985" border="0" cellspacing="0" cellpadding="1" align="center">
	<tr>
	<td>
		<table width="100%" border="0" cellspacing="0" align="0">
		<tr>
		<td width="192">&nbsp;</td>
		<td width="112">
			<table width="100%" border="0" cellspacing="0" align="center">
				<tr>
					<td><img src="../../../../images/callogo.jpg" /></td>
				</tr>
			</table>	  </td>
		<td width="455">
			<table width="100%" border="0" cellspacing="0" align="center">
				<tr>
					<td class="normalfnBLD1" style="font-size:18px">EAM Maliban Textiles (Pvt) Ltd</td>
				</tr>
				<tr>
					<td class="normalfnBLD1">261, Siri Dhamma Mw.,Colombo 10, Sri Lanka</td>
				</tr>
				<tr>
					<td class="normalfnBLD1">Telephone: 94 1 686391   Facsimile: 94 1 699513</td>
				</tr>
				<tr>
					<td class="normalfnBLD1">E-Mail: general@maliban.com</td>
				</tr>
			</table>	  </td>
		<td width="218">&nbsp;</td>
	</tr>

</table>
</td>
</tr>
	<tr>
		<td>
			<table width="100%" align="center" cellspacing="0"  border="0">
			<tr>
				<td width="20%">&nbsp;</td>
				<td width="47%">&nbsp;</td>
				<td width="33%">&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">24-Aug-11</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">The Officer in Charge </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">Sri Lanka Port Authority </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">Colombo</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">Dear Sir, </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px"><b>SLPA No</b>: 44126 </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">The above numbered SLPA was passed for the Vessal, </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px"><b>ACX MIMOSA</b> of <b>10-Jun-11</b>. However due to a delay in our </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">production and packing, we could meet the deadline for this </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">vessel. Our Buyers have now requested us to ship this </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">Consigment on <b>APL JAPAN</b> of <b>21-06-11</b>. </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">We would be much obliged if you could amend the name of the </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">vessal on the SLPA to <b>APL JAPAN</b> of <b>21-06-11</b>. </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">and permi us to ship our goods. </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">Thanking you for your kind cooperation. </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">Yours faithfully, </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">EAM MALIBAN TEXTILES (PVT) LTD </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">SHIPPING MANAGER </td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt" style="font-size:14px">(k.Ravindren)</td>
			  <td>&nbsp;</td>
			  </tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>