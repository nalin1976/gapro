<?php
	session_start();
	include "../Connector.php";
	$cbosupplier = $_GET["cbosupplier"];
	$Type	     = $_GET['Type'];//18-04-2011- lasantha - To get the invoice type
	$poYear      = $_GET["poYear"];
	$poNo        = $_GET["poNo"];
	
	//Modified by Nero 2012 February
	$reportname = "../GRN/expoconfirmation/expoconfirmationreport.php";
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

$strSQL = "SELECT DISTINCT PH.intGrnNo,PH.intGrnYear,PH.intUserID,suppliers.strTitle,PH.intStatus, PH.dblPOValue, PH.dblPOBalance, 
          (SELECT strComCode FROM companies WHERE intCompanyID = PH.intInvCompID ) AS invTo , 
          (SELECT strComCode FROM companies WHERE intCompanyID = PH.intDelToCompID ) AS delTo ,useraccounts.Name 
           FROM purchaseorderheader_excess PH
           INNER JOIN purchaseorderdetails_excess PD ON PH.intGrnNo = PD.intGrnNo AND PH.intGrnYear = PD.intGrnYear 
           INNER JOIN useraccounts ON PH.intUserID = useraccounts.intUserID  
           INNER JOIN suppliers ON PH.strSupplierID = suppliers.strSupplierID  
		   WHERE PD.intPoNo = '$poNo' AND PD.intYear = '$poYear' ";

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
        <td width="100%"><div id="divcons" style="overflow:-moz-scrollbars-vertical; height:120px; width:620px;">
          <table width="620" cellpadding="0" cellspacing="0">
            <tr class="mainHeading4">
              <td width="15%" height="22">Po No</td>
			  <td width="10%">Year</td>
              <td width="10%">PO Value </td>
              <td width="10%" height="22">Balance Value</td>
			  <td width="25%"> User </td>
              <td width="11%">View</td>
            </tr>
<?php
while($row = mysql_fetch_array($result))
{ 
	$intGrnNo   = $row["intGrnNo"];
	$intGrnYear = $row["intGrnYear"];
	$dblPOValue = $row["dblPOValue"];
	$dblPOBalance = $row["dblPOBalance"];
	$Name = $row["Name"];
	($count%2==0)?$cls="grid_raw":$cls="grid_raw2";
?>
            <tr>
              <td class="<?php echo $cls;?>"><?php echo $intGrnNo ?></td>
			  <td class="<?php echo $cls;?>"><?php echo $intGrnYear ?></td>
              <td class="<?php echo $cls;?>"><?php echo number_format($dblPOValue,2) ?></td>
			  <td class="<?php echo $cls;?>"><?php echo number_format($dblPOBalance,2) ?></td>
			  <td class="<?php echo $cls;?>" style="text-align:left"><?php echo $Name ?></td>
                <td class="normalfnt"><div align="center"><a href="<?php echo $reportname; ?>?serialNo=<?php echo  $row["intGrnNo"]; ?>&serialYear=<?php echo  $row["intGrnYear"]; ?>" target="_blank"><img src="../images/view2.png" border="0" class="noborderforlink" /></a></div></td>
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
echo "<table align='center'><tr><td height='100px'><font size='5'>There is no Excess PO</font></td><tr><tr><img src='../images/close.png' alt='Close' width='97' height='24' onclick='closeWindow();'/></tr></table>";
}

?>		

</form>
</body>
</html>
