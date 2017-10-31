<?php
 session_start();
include "../../Connector.php";
$backwardseperator 	= "../../";
	//include "{$backwardseperator}Connector.php" ;	
	include "{$backwardseperator}authentication.inc";
	
	//$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
$cboSearch   	    = $_GET["cboCustomer"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Payee Details Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
</head>
<body>
<table align="center" width="950" border="0">
<tr>
<td align="center" ><?php include "../../reportHeader.php";?></td>				
</tr>

<tr>
 <td height="10">

  <?php

		$SQL="SELECT * FROM payee where intPayeeID='$cboSearch' AND intStatus!=10"; 
			 		   			    
        $result = $db->RunQuery($SQL);

		while($row = mysql_fetch_array($result))
		{	
			$strName      = cdata($row["strTitle"]);
			$strAddress1  = cdata($row["strAddress1"]);
			$strState	  = cdata($row["strState"]);
			$strStreet    = cdata($row["strStreet"]);
			$strCity      = cdata($row["strCity"]);
			$strCountry   = cdata($row["strCountry"]);
			$strZipCode   = cdata($row["strZipCode"]);
			$strPhone     = cdata($row["strPhone"]);
			$strEMail     = cdata($row["strEMail"]);
			$strFax       = cdata($row["strFax"]);
			$strWeb       =	cdata($row["strWeb"]);
			$strRemarks   = cdata($row["strRemarks"]);
			if($row["intStatus"]=='1')
				$status = 'Active';
			else
				$status = 'InActive';
		}
		if($strCountry == "0")
		{
			$strCountry = "";
		}
		?>
</td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;"><table width="100%" border='0' align='center' cellpadding="3" cellspacing="0"  >
  <thead>
   <tr>
     <td colspan="2" align="center" class='border-Left-Top-right-fntsize12'><div class="normalfnt2bldBLACKmid">Payee Detail Report</div></td>
     </tr></thead>
   <tr>
     <td align="center" class='border-top-left-fntsize12' width="20%"><span class="normalfnt"><strong> Name</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strName?></strong></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>  Address</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strAddress1." ".$strAddress2?></strong></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>  Street</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strStreet; ?></strong></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>  City</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strCity; ?> </strong></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>  State</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strState;?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>  Country</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strCountry; ?> </strong></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>  Zip Code</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strZipCode; ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>  Phone</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strPhone; ?> </strong></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>  Fax</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strFax;?> </span></td>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>  Email</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strEMail; ?> </strong></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>  Web</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strWeb; ?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>  Remarks</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strRemarks; ?> </strong></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>  Status</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $status; ?> </span></td>
   </tr>
   <tfoot>
   <tr>
     <td align="center"  class="border-top-fntsize12">&nbsp;</td>
     <td  class="border-top-fntsize12">&nbsp;</td>
   </tr></tfoot>
 </table></td>
</table>

</body>
</html>
