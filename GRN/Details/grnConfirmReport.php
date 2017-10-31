<?php
 session_start();
include "../../Connector.php";
$backwardseperator = '../../';
$xml = simplexml_load_file('../../config.xml');
$DisplayRatioCodeInReport = $xml->GRN->DisplayRatioCodeInReport;
$DisplayLocationInReport = $xml->GRN->DisplayLocationInReport;
$ReportISORequired = $xml->companySettings->ReportISORequired;
$DisplayScNo = $xml->GRN->DisplayReportScNo;
$DisplayReportBuyerPoNo  = $xml->GRN->DisplayReportBuyerPoNo;
$DisplayReportOrderNo = $xml->GRN->DisplayOrderNoInReport;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Good Received Note : Confirmation</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="java.js" type="text/javascript"></script>

<style type="text/css">
<!--
.style4 {
	font-size: xx-large;
	color: #FF0000;
}
.style3 {
	font-size: xx-large;
	color: #FF0000;
}
-->

</style>
<?php 
//echo " <style type=\"text/css\"> body {background-image: url(../../images/not-valid.png);} </style>"


	$MainStoreCompanyID = $_GET["MainStoreID"];
	$SubStoreID 		= $_GET["SubStoreID"];
	
	$Sql_Store = "SELECT intAutomateCompany FROM mainstores WHERE strMainID='$MainStoreCompanyID' ";
	
	$result_StoreDet = $db->RunQuery($Sql_Store);

		
		while($rowS = mysql_fetch_array($result_StoreDet))
		{
			$Autocom = $rowS["intAutomateCompany"];
		}
		$report_companyId =$_SESSION["FactoryID"];
		$grnno=$_GET["grnno"];
		$grnYear = $_GET["grnYear"];
?>

</head>

<body>
<table width="800" border="0" align="center" >
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td><?php include 'grnReport.php';?></td>
        </tr>
      
  </table>
 
  </tr>
 
  <tr>
    <td class="normalfnt">GRN Status : Pending <?php  //echo "(".$ConfirmedPerson."-".$dtmConfirmedDateNewDate."/".$dtmConfirmedDateNewMonth."/".$dtmConfirmedDateNewYear.")";?></td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="tablezRED"><table width="270" border="0">
      <tr>
        <td width="117"><img src="../../images/conform.png" alt="conform" name="butConform" width="115" height="24" class="mouseover" id="butConform" onclick="conform(<?php echo $_GET["grnno"]; ?>,<?php echo $_GET["grnYear"]; ?>,<?php echo $Autocom; ?>,<?php echo $MainStoreCompanyID.','.$SubStoreID.','.$intYear.','.$intPONo; ?>);" /></td>
        <td width="25">&nbsp;</td>
        <td width="128">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<?php 
function getBuerPOName($StyleID,$buyerPOno)
{
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos
			 WHERE intStyleId='$StyleID' AND strBuyerPONO='$buyerPOno'";
			 
			 global $db;
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
				$BPOname = $row["strBuyerPoName"];
			}
		return $BPOname;	 
			 
}
function  GetPoCurrencyName($poCurrency)
{
global $db;
$sql="select strCurrency from currencytypes where intCurID='$poCurrency'";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
return $row["strCurrency"];
}
if($grnStatus==10)
{
echo " <style type=\"text/css\"> body {background-image: url(../../images/not-valid.png);} </style>";
}

?>
</body>
</html>
