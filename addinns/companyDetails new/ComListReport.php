<?php
 session_start();
include "../../Connector.php";
$backwardseperator 	= "../../";
	include "{$backwardseperator}authentication.inc";
	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Company Details listing Report</title>
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
		$strName			= $rows["strName"];
		$comAddress1		= $rows["strAddress1"];
		$comAddress2		= $rows["strAddress2"];
		$comStreet			= $rows["strStreet"];
		$comCity			= $rows["strCity"];
		$comCountry			= $rows["strCountry"];
		$comZipCode			= $rows["strZipCode"];
		$strPhone			= $rows["strPhone"];
		$comEMail			= $rows["strEMail"];
		$comFax				= $rows["strFax"];
		$comWeb				= $rows["strWeb"];		
		}			
				?>
<td align="center" style="font-family: Arial;	font-size: 16pt;color: #000000;font-weight: bold;"><?php include "../../reportHeader.php";?></td>				
</tr>

<tr>
 <td height="10"></td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;"><table style="width:900px;" border='0' align='center' cellpadding="3" cellspacing="0">
 	<thead>
   <tr>
     <td colspan="10" align="center" class='border-Left-Top-right-fntsize12'><div align="center"><span class="normalfnt2bldBLACKmid">Company Detail  Report</span></div></td>
     </tr>
   <tr bgcolor="#efefef">
     <td class='border-top-left-fntsize12' width="5%"><strong> <div class="normalfntMid"> No</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid"> Code</div></strong></td>
     <td class='border-top-left-fntsize12' width="20%"><strong> <div class="normalfntMid"> Name</div></strong></td>
    <td class='border-top-left-fntsize12' width="25%"><strong> <div class="normalfntMid">Address</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid">Phone</div></strong></td>
     <td class='border-top-left-fntsize12' width="15%"><strong> <div class="normalfntMid">Email</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid">Account No</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid">Seq. No<br/>Start</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid">Seq. No<br/>End</div></strong></td>
     <td class='border-Left-Top-right-fntsize12' width="5%"><strong> <div class="normalfntMid">Active</div></strong></td>
   </tr></thead>
   <?php

		$SQL="SELECT * FROM companies where intStatus !='10'"; 
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strComCode       = cdata($row["strComCode"]);
		$strName          = cdata($row["strName"]);
		$strAddress1      = cdata($row["strAddress1"]);
		$strAddress2      = cdata($row["strAddress2"]);
		$strStreet        = cdata($row["strStreet"]);
		$strCity          = cdata($row["strCity"]);
		$strState         = cdata($row["strState"]);
		$strCountry       = cdata($row["strCountry"]);
		$strZipCode       = cdata($row["strZipCode"]);
		$strEMail         = cdata($row["strEMail"]);
		$strPhone         = cdata($row["strPhone"]);
		$strFax           = cdata($row["strFax"]);
		$strWeb           = cdata($row["strWeb"]);
		$strTINNo         = cdata($row["strTINNo"]);
		$strGSTNo         = cdata($row["strGSTNo"]);
		$strRegNo         = cdata($row["strRegNo"]);
		$strBOINo         = cdata($row["strBOINo"]);
		$strRemarks       = cdata($row["strRemarks"]);
		$dblVatValue      = cdata($row["dblVatValue"]);
		$intFacNoSeq_Start = cdata($row["intFacNoSeq_Start"]);
		$dblFacNoSeq_End   = cdata($row["dblFacNoSeq_End"]);
		$strVatAcNo        = cdata($row["strVatAcNo"]);
		$strTQBNO          = cdata($row["strTQBNO"]);
		$reaFactroyCostPerMin = cdata($row["reaFactroyCostPerMin"]);
		$intOrder             = cdata($row["intOrder"]);
		$strManagerEmail      = cdata($row["strManagerEmail"]);
		$strDefaultInvoiceTo  = cdata($row["strDefaultInvoiceTo"]);
		$intStatus            = cdata($row["intStatus"]);
		$accountNo            = cdata($row["strAccountNo"]);

		if($intStatus == 1){
		$intStatus='Yes';
		}else{
		$intStatus='No';
		}?>	
	<tr>
	  <td class='border-top-left-fntsize12'><div class="normalfntMid"><?php echo $i;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strComCode;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strName;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strAddress1." ".$strAddress2;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strPhone;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strEMail;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $accountNo;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $intFacNoSeq_Start;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $dblFacNoSeq_End;?></div></td>
	  <td class='border-Left-Top-right-fntsize12'><div class="normalfntMid"><?php echo $intStatus;?></div></td>
   </tr>
  <?php  $i++;	
   }
  
   ?>
   <tfoot>
   <tr>
     <td colspan="9" class="border-top-fntsize12">&nbsp;</td>
     </tr></tfoot>
 </table></td>
</table>


</body>
</html>
