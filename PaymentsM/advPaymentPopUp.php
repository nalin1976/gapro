<?php
	session_start();
	include "../Connector.php";
	$cbosupplier = $_GET["cbosupplier"];
	$Type	     = $_GET['Type'];//18-04-2011- lasantha - To get the invoice type
	$poYear      = $_GET["poYear"];
	$poNo        = $_GET["poNo"];
	
	//Modified by Nero 2012 February
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body background="#FFFBF0">
<form id="frmBinAvailability">
  <?php

$grn='GRN';
$strSQL = " SELECT
					advancepayment.intPaymentNo,
					advancepayment.dtmPayDate,
					advancepayment.dblPoAmt,
					advancepayment.dblTaxAmt,
					advancepayment.dblTotAmt
					FROM
					advancepayment
					Inner Join advancepaymentpos ON advancepayment.intPaymentNo = advancepaymentpos.intPaymentNo 
					AND advancepayment.strType = advancepaymentpos.strType
					WHERE
					advancepayment.strType =  'S' and advancepayment.intSupplierId='$cbosupplier' and advancepaymentpos.intPOno = '$poNo' and 
					advancepaymentpos.intPOYear = '$poYear' 
					ORDER BY advancepayment.dtmPayDate desc";

			//echo $strSQL;
$result=$db->RunQuery($strSQL);
$count=0;
$cls="";
if(mysql_num_rows($result)){
?>
  <table width="298" border="0">
    <tr>
      <td height="24" colspan="3" bgcolor="#D1BB6F" class="TitleN2white"><table width="100%" border="0">
          <tr>
            <td width="94%">Advance Payment List</td>
            <td width="6%">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="120" colspan="3"><table width="292" height="129" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="100%"><div id="divcons" style="overflow:-moz-scrollbars-vertical; height:120px; width:430px;">
                <table width="430" cellpadding="0" cellspacing="0">
                  <tr class="mainHeading4">
                    <td width="32%" height="22">Payment No</td>
                    <td width="40%">Date</td>
                    <td width="25%">Amount </td>
                    <td width="43%" height="22">Report</td>
                  </tr>
                  <?php
while($row = mysql_fetch_array($result))
{ 
	$intPaymentNo = $row["intPaymentNo"];
	$dblTotAmt = $row["dblTotAmt"];
	$dtmPayDate = $row["dtmPayDate"];
	($count%2==0)?$cls="grid_raw":$cls="grid_raw2";
?>
                  <tr>
                    <td class="<?php echo $cls;?>"><?php echo $intPaymentNo ?></td>
                    <td class="<?php echo $cls;?>"><?php echo $dtmPayDate ?></td>
                    <td class="<?php echo $cls;?>"><?php echo number_format($dblTotAmt,2) ?></td>
                    <td class="<?php echo $cls;?>" ><a target="_blank"  href=<?php echo "advancePayment/rptAdvancePaymentReport.php?PayNo=$intPaymentNo&strPaymentType=$Type" ?>> <img src="../images/view.png" alt="Report " name="butReport" border="0" id="butReport"/> </a> </td>
                  </tr>
                  <?php
$count++;
}
?>
                </table>
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td width="11" bgcolor="#D6E7F5">&nbsp;</td>
      <td width="176" bgcolor="#D6E7F5">&nbsp;</td>
      <td width="97" bgcolor="#D6E7F5"><img src="../images/close.png" alt="Close" width="97" height="24" onclick="closeWindow();"/></td>
    </tr>
  </table>
  <?php
}else{
echo "<table align='center'><tr><td height='100px'><font size='5'>There is no Advance paid</font></td><tr><tr><img src='../images/close.png' alt='Close' width='97' height='24' onclick='closeWindow();'/></tr></table>";
}

?>
</form>
</body>
</html>
