<?php 
function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
        return "$number"; 
    } 

    $Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 
//	    $Dn = floor($number / 10);       /* -10 (deci) */ 
 //   $n = $number % 100;               /* .0 */ 
//	    $Dn = floor($number / 10);       /* -100 (centi) */ 
 //   $n = $number % 1000;               /* .00 */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) . " MILLION"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " THOUSAND"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " HUNDRED"; 
    } 

    $ones = array("", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX", 
        "SEVEN", "EIGHT", "NINE", "TEN", "ELEVEN", "TWELVE", "THIRTEEN", 
        "FOURTEEN", "FIFTEEN", "SIXTEEN", "SEVENTEEN", "EIGHTTEEN", 
        "NINETEEN"); 
    $tens = array("", "", "TWENTY", "THIRTY", "FOURTY", "FIFTY", "SIXTY", 
        "SEVENTY", "EIGHTY", "NINETY"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " AND "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "ZERO"; 
    } 

    return $res; 
	
	
} 
?>
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
	$serial_no=$_GET["serial_no"];
	
	$str_header="select (select strName from customers cst where cst.strCustomerID=ah.intCustomerid)as customer, strAdvanceSerialNo, dtmDate, dblAmount,intCustomerid,dblBalance, strChequeRefNo, intBank, strType from advanceheader ah where ah.strAdvanceSerialNo='$serial_no'";
	$result_header=$db->RunQuery($str_header);
	$row_header=mysql_fetch_array($result_header);
			$customer=$row_header["customer"];
			$Amount=$row_header["dblAmount"];
			$customer=$row_header["customer"];
			$type=$row_header["strType"];
			$checkno=$row_header["strChequeRefNo"];
			$checkno=($type=='cheque'?$checkno:"-");
			$date=$row_header["dtmDate"];
			$date_array=explode("-",$date);
			$date=$date_array[2]."/".$date_array[1]."/".$date_array[0];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
.receiptTitle{
color:#000000;
font-family:Verdana;
font-size:18px;
font-weight:normal;
margin:0;
text-align:left;
font-weight:600;
}
.textUnderline{
color:#000000;
font-family:Verdana;
font-size:12px;
font-weight:normal;
margin:0;
text-align:left;
text-decoration:underline;
}
</style>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.receiptTitle1 {color:#000000;
font-family:Verdana;
font-size:18px;
font-weight:normal;
margin:0;
text-align:left;
font-weight:600;
}
-->
.fontColor12 {FONT-SIZE:10PT; ; FONT-FAMILY:Arial; FONT-WEIGHT:BOLD; }
</style>
</head>
<body>
<table width="510" border="0" cellspacing="0" cellpadding="0" ></tr><td align="center">
<table width="98%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%" rowspan="3"><div align="center"><span class="head2BLCK"><img src="../../../images/callogo.jpg" alt="logo" width="62" height="50" /></span></div></td>
        <td width="80%" class="receiptTitle"><?php echo $Company;?></td>
      </tr>
      <tr>
        <td class="normalfnth2B"><?php echo $Address." ".$City;?></td>
      </tr>
      <tr>
        <td  class="normalfnth2B"><?php echo "Tel :".$phone." Fax : ".$Fax;?></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="40%" >&nbsp;</td>
        <td width="20%" rowspan="2" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="border-All"><div class="normalfnt2bldBLACKmid">RECEIPT</div></td>
          </tr>
        </table></td>
        <td width="40%" class="normalfnt_size10"><dd>RCT No.<span class="normalfnt2bldBLACK">&nbsp;<?php echo $serial_no;?></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt_size10"><dd>Date:<span class="normalfnt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $date;?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnBLD1">
      <tr>
        <td >Received with thanks from:</td>
      </tr>
      <tr>
        <td height="20" valign="top"><div align="center"><span class="normalfnt-center_size12"><?php echo ucwords(strtolower($customer)); ?> </span></div></td>
      </tr>
      <tr>
        <td>Sum of Rupees:</td>
      </tr>
      <tr>
        <td height="20" valign="top"><div align="center"><span class="normalfnt-center_size12">
		<?php $amount=explode(".",round($Amount,2));
		 $amount1=$amount[0];
		  $amount2=($amount[1]!=0? " Rupees And ".convert_number($amount[1])." Cents" : "");
		  
		  echo ucwords(strtolower(convert_number($amount1).$amount2)); ?> </span></div></td>
      </tr>
      <tr>
        <td>Settlement of:</td>
      </tr>
      <tr>
        <td height="20" valign="top"><div align="center"><span class="normalfnt-center_size12"><?php 
		$str_detail="select intiouno from advancedetail where  strAdvanceSerialNo='$serial_no'";
		$result_detail=$db->RunQuery($str_detail);
		while($row_detail=mysql_fetch_array($result_detail)){echo $row_detail["intiouno"].", ";}
		
		?> </span></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnBLD1">
      <tr>
        <td width="25%" height="22">Amount</td>
        <td width="30%" class="border-Left-Top-right-fntsize12"><div align="center"><?php echo number_format($Amount,2)?></div></td>
        <td width="45%" valign="bottom"><div align="center">.................................................</div></td>
      </tr>
      <tr>
        <td  height="22">Cheque No </td>
        <td class="border-Left-Top-right-fntsize12"><div align="center"><?php echo $checkno; ?></div>
        <div align="center"></td>
        <td valign="top"><div align="center" class="normalfnBLD1"><?php echo ucwords(strtolower($Company));?></div></td>
      </tr>
      <tr>
        <td  height="22">Payment Method</td>
        <td class="border-All-fntsize12" ><div align="center"><?php echo ucwords($type); ?></div></td>
        <td valign="bottom"><div align="center">.................................</div></td>
      </tr>
      <tr>
        <td  height="22">&nbsp;</td>
        <td >&nbsp;</td>
        <td align="center" class="normalfnBLD1" valign="top">Accountant</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="normalfnBLD1" height="20"><i>Note: Cheques received for payment are subject to realization</i></td>
  </tr>
</table>
</td></tr></table>
<body>
</body>
</html>
