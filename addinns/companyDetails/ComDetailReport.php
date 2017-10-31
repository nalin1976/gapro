<?php
 session_start();
include "../../Connector.php";
$backwardseperator 	= "../../";
	include "{$backwardseperator}authentication.inc";
	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
$cbocompany   	    = $_GET["cbocompany"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Company Detail Report</title>
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
<table align="center" width="900" border="0">
<tr>
<?php
		
					$SQL_address="SELECT * FROM 
						companies
						Inner Join useraccounts ON companies.intCompanyID = useraccounts.intCompanyID
						WHERE
						useraccounts.intUserID =  '".$_SESSION["UserID"]."'";
							
						$result_address = $db->RunQuery($SQL_address);
					
					
		while($rows = mysql_fetch_array($result_address))
		{	
		$strName=$rows["strName"];
		$comAddress1=$rows["strAddress1"];
		$comAddress2=$rows["strAddress2"];
		$comStreet=$rows["strStreet"];
		$comCity=$rows["strCity"];
		$comCountry=$rows["strCountry"];
		$comZipCode=$rows["strZipCode"];
		$strPhone=$rows["strPhone"];
		$comEMail=$rows["strEMail"];
		$comFax=$rows["strFax"];
		$comWeb=$rows["strWeb"];
		}			
				?>
<td align="center" style="font-family: Arial;	font-size: 16pt;color: #000000;font-weight: bold;"><?php include "../../reportHeader.php";?></td>				
</tr>

<tr>
 <td height="10">

  <?php

		$SQL="SELECT * FROM companies where intCompanyID='$cbocompany' AND intStatus !='10'"; 
						 		   			    
        $result = $db->RunQuery($SQL);

		while($row = mysql_fetch_array($result))
		{	
		$strComCode       = $row["strComCode"];
		$strName          = $row["strName"];
		$strAddress1      = $row["strAddress1"];
		$strAddress2      = $row["strAddress2"];
		$strStreet        = $row["strStreet"];
		$strCity          = $row["strCity"];
		$strState         = $row["strState"];
		$strCountry       = $row["strCountry"];
		$strZipCode       = $row["strZipCode"];
		$strEMail         = $row["strEMail"];
		$strPhone         = $row["strPhone"];
		$strFax           = $row["strFax"];
		$strWeb           = $row["strWeb"];
		$strTINNo         = $row["strTINNo"];
		$strGSTNo         = $row["strGSTNo"];
		$strRegNo         = $row["strRegNo"];
		$strBOINo         = $row["strBOINo"];
		$strRemarks       = $row["strRemarks"];
		$dblVatValue      = $row["dblVatValue"];
		$intFacNoSeq_Start = $row["intFacNoSeq_Start"];
		$dblFacNoSeq_End   = $row["dblFacNoSeq_End"];
		$strVatAcNo        = $row["strVatAcNo"];
		$strTQBNO          = $row["strTQBNO"];
		$reaFactroyCostPerMin = $row["reaFactroyCostPerMin"];
		$intOrder             = $row["intOrder"];
		$strManagerEmail      = $row["strManagerEmail"];
		$strDefaultInvoiceTo  = $row["strDefaultInvoiceTo"];
		$intStatus            = $row["intStatus"];
		$intManufac            = $row["intManufacturing"];
		$accountNo            = cdata($row["strAccountNo"]);
		
		if($intStatus == 1){
		$intStatus='Yes';
		}else{
		$intStatus='No';
		}
		}
		?>
</td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;"><table style="width:900px;" border='0' align='center' cellpadding="3" cellspacing="0"  >
   <thead>
   <tr>
     <td colspan="2" align="center" class='border-Left-Top-right-fntsize12'><div class="normalfnt2bldBLACKmid">Company Detail Report</div></td>
     </tr></thead>
   <tr>
     <td align="center" class='border-top-left-fntsize12' style="width:300px;"><span class="normalfnt"><strong> Code</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' style="width:600px;"><span class="normalfnt"><?php echo $strComCode ?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Name</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strName?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Address</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strAddress1." ".$strAddress2?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Phone</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strPhone ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Fax</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strFax ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Email</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strEMail ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Web</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strWeb ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Remarks</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strRemarks?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Tin No</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo strTINNo?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Reg No</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt">
           <?php  echo $strRegNo ?>
     </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Vat No</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strVatAcNo ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Vat%</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $dblVatValue ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> TQB No</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strTQBNO ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> BOI No</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strBOINo ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Fac. Cost Per Min</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $reaFactroyCostPerMin ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Default Invoice to</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strDefaultInvoiceTo ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Account No</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $accountNo ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Active</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $intStatus ?> </span></td>
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
