<?php 
session_start();
include "../../../../Connector.php";
$invoiceNo=$_GET['InvoiceNo'];	

$str_summary	="select
sum(dblNetMass) as dblNetMass,
sum(dblGrossMass) as dblGrossMass,
strISDno,
strCat,
strDescOfGoods,
strGender,
strStyleID
from 
commercial_invoice_detail
left join finalinvoice on finalinvoice.strInvoiceNo=commercial_invoice_detail.strInvoiceNo
left join commercial_invoice_header on commercial_invoice_header.strInvoiceNo=commercial_invoice_detail.strInvoiceNo
where finalinvoice.strInvoiceNo='$invoiceNo'";
$result_summary	=$db->RunQuery($str_summary);
$summary_data	=mysql_fetch_array($result_summary)
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Addendum Sheet</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function check_value(obj)
{
	if (obj.innerHTML==""||obj.innerHTML=='&nbsp;'){
	obj.innerHTML="<strong>X</strong>"
	}
	else 
	obj.innerHTML=""
}
</script>

<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table cellspacing="0" cellpadding="0" class="normalfnt_size12">
  <col width="23" />
  <col width="29" />
  <col width="89" />
  <col width="33" />
  <col width="109" />
  <col width="34" />
  <col width="91" />
  <col width="35" />
  <col width="30" />
  <col width="70" />
  <col width="28" />
  <col width="38" />
  <col width="27" />
  <col width="88" />
  <tr height="17">
    <td height="17" width="23"></td>
    <td width="29"></td>
    <td width="89"></td>
    <td width="33"></td>
    <td width="109"></td>
    <td width="34"></td>
    <td width="91"></td>
    <td width="35"></td>
    <td width="30"></td>
    <td width="70"></td>
    <td width="28"></td>
    <td width="38"></td>
    <td width="27"></td>
    <td width="88"></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td colspan="3">PART D &ndash; APPENDIX I</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="19">
    <td height="19"></td>
    <td colspan="4">Addendum Sheet for&nbsp; &ndash; Invoice no.</td>
    <td colspan="5"><?PHP echo $invoiceNo;?></td>
    <td></td>
    <td colspan="2">ISD NO</td>
    <td><strong><?PHP echo $summary_data['strISDno'];?></strong></td>
  </tr>
  <tr height="19">
    <td height="19"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="19">
    <td height="19"></td>
    <td colspan="4">WOVEN PANTS&nbsp; &ndash; DESCRIPTION</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <?php $str_product	="select
			distinct strStyleID
			from 
			commercial_invoice_detail
			where strInvoiceNo='$invoiceNo' 
			order by strBuyerPONo
			";
			$result_product	=$db->RunQuery($str_product);
			$row=0;
			$boo_first=1;
			while(($row_product	=mysql_fetch_array($result_product))||($row<6)){?>
  <tr height="23">
    <td height="23"></td>
    <td colspan="3"><?php if($boo_first==1)echo "PRODUCT CODE :";?></td>
    <td colspan="6"><?php echo $row_product['strStyleID'];?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr><?php $row++;$boo_first=0;}?>
  <tr height="23">
    <td height="23"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td colspan="2">GARMENT TYPE :</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td class="border-All" style="text-align:center" onclick="check_value(this)"><STRONG>X</STRONG></td>
    <td style="text-align:center">PANTS</td>
    <td class="border-All" style="text-align:center" onclick="check_value(this)">&nbsp;</td>
    <td style="text-align:center">SHORTS</td>
    <td class="border-All" style="text-align:center" onclick="check_value(this)">&nbsp;</td>
    <td style="text-align:center">SKIRTS</td>
    <td>&nbsp;</td>
    <td class="border-All" style="text-align:center" onclick="check_value(this)">&nbsp;</td>
    <td style="text-align:center">SKORT</td>
    <td></td>
    <td class="border-All" style="text-align:center" onclick="check_value(this)">&nbsp;</td>
    <td colspan="2" style="text-align:center">DRESS</td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td class="border-All" style="text-align:center" onclick="check_value(this)">&nbsp;</td>
    <td style="text-align:center">OVERALL</td>
    <td class="border-All" style="text-align:center" onclick="check_value(this)">&nbsp;</td>
    <td style="text-align:center">COVERALL</td>
    <td class="border-All" style="text-align:center" onclick="check_value(this)">&nbsp;</td>
    <td style="text-align:center">JUMPER</td>
    <td>&nbsp;</td>
    <td class="border-All" style="text-align:center" onclick="check_value(this)">&nbsp;</td>
    <td style="text-align:center">DRESS</td>
    <td></td>
    <td class="border-All" style="text-align:center" onclick="check_value(this)">&nbsp;</td>
    <td colspan="2" style="text-align:center">OTHERS</td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td colspan="2">GENDER / AGE :</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td class="border-All" onclick="check_value(this)" style="text-align:center" id="MENS">&nbsp;</td>
    <td style="text-align:center">MENS</td>
    <td class="border-All" onclick="check_value(this)" style="text-align:center" id="WOMENS">&nbsp;</td>
    <td style="text-align:center">WOMENS</td>
    <td class="border-All" onclick="check_value(this)" style="text-align:center" id="BOYS">&nbsp;</td>
    <td style="text-align:center">BOYS</td>
    <td>&nbsp;</td>
    <td class="border-All" onclick="check_value(this)" style="text-align:center" id="GIRLS">&nbsp;</td>
    <td style="text-align:center">GIRLS</td>
    <td></td>
    <td class="border-All" onclick="check_value(this)" style="text-align:center" id="INFANTS">&nbsp;</td>
    <td colspan="2" style="text-align:center">INFANTS</td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td colspan="3" valign="top">FABRIC CONTENT :&nbsp;&nbsp;</td>
    <td colspan="3"><?php 
	$str_product	="select distinct
			strFabric
			from 
			commercial_invoice_detail
			where strInvoiceNo='$invoiceNo'
			order by strBuyerPONo";
			$result_product	=$db->RunQuery($str_product);
	while($row_product	=mysql_fetch_array($result_product)){ echo $row_product['strFabric']."<br/>";}?></td>
    <td></td>
    <td colspan="3" valign="top">QUOTA CATEGORY :</td>
    <td></td>
    <td colspan="2" valign="top"><?PHP echo $summary_data['strCat'];?></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td colspan="2">FABRIC TYPE :&nbsp;&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td class="border-All"onclick="check_value(this)" style="text-align:center" >&nbsp;</td>
    <td style="text-align:center">YARN DYED</td>
    <td class="border-All" onclick="check_value(this)" style="text-align:center">&nbsp;</td>
    <td style="text-align:center">PIECE DYED</td>
    <td class="border-All" onclick="check_value(this)" style="text-align:center"><STRONG>X</STRONG></td>
    <td colspan="2" style="text-align:center">TOPPING DYED</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td class="border-All" onclick="check_value(this)" style="text-align:center">&nbsp;</td>
    <td style="text-align:center">CORDUROY</td>
    <td class="border-All" onclick="check_value(this)" style="text-align:center">&nbsp;</td>
    <td style="text-align:center">CHAMBRAY</td>
    <td class="border-All" onclick="check_value(this)" style="text-align:center">&nbsp;</td>
    <td style="text-align:center">TWILL</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td class="border-All" onclick="check_value(this)" style="text-align:center" id="WOMENS"><STRONG>X</STRONG></td>
    <td colspan="3" >&nbsp;&nbsp; DENIM&nbsp; (INDICATE COLOR:)</td>
    <td colspan="2">&nbsp;&nbsp;INDIGO</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td class="border-All" onclick="check_value(this)" style="text-align:center" id="WOMENS">&nbsp;</td>
    <td>&nbsp;&nbsp; OTHERS :</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="17">
    <td height="17"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
</body>
<script type="text/javascript">
document.getElementById("<?php echo $summary_data['strGender'];?>").innerHTML="<strong>X</strong>";


</script>
</html>
