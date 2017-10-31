<?php
 session_start();

$backwardseperator = '../../';

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Good Received Note : Confirmation</title>

<?php 
//echo " <style type=\"text/css\"> body {background-image: url(../../images/not-valid.png);} </style>"


	$MainStoreCompanyID = $_GET["MainStoreID"];
	$SubStoreID 		= $_GET["SubStoreID"];
	$Autocom 			= $_GET["pub_AutomateBin"];
	//include $backwardseperator."Connector.php";
	/*$Sql_Store = "SELECT intAutomateCompany FROM mainstores WHERE strMainID='$MainStoreCompanyID' ";
	
	$result_StoreDet = $db->RunQuery($Sql_Store);

		
		while($rowS = mysql_fetch_array($result_StoreDet))
		{
			$Autocom = $rowS["intAutomateCompany"];
		}
		$report_companyId =$_SESSION["FactoryID"];
		$grnno=$_GET["grnno"];
		$grnYear = $_GET["grnYear"];*/
?>


</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include 'grnReport.php';?></td>
  </tr>
  <tr>
    <td class="tablezRED" align="center"><table width="270" border="0">
      <tr>
        <td  ><img src="../../images/conform.png" alt="conform" name="butConform" width="115" height="24" class="mouseover" id="butConform" onClick="conform(<?php echo $_GET["grnno"]; ?>,<?php echo $_GET["grnYear"]; ?>,<?php echo $Autocom; ?>,<?php echo $MainStoreCompanyID.','.$SubStoreID.','.$intYear.','.$intPONo; ?>);" /></td>
        <td width="25">&nbsp;</td>
        <td width="128">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table>
</body>
</html>
