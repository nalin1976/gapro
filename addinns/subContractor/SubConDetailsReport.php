<?php
 session_start();
$backwardseperator 	= "../../";
	//include "{$backwardseperator}Connector.php" ;	
	include "{$backwardseperator}authentication.inc";
	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];include "../../Connector.php";

$cboSearch   	    = $_GET["cboSearch"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>sub con Details Report</title>
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
		//$comAddress2=$rows["strAddress2"];
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
<p >
  <?php

		$SQL="SELECT * FROM subcontractors where strSubContractorID='$cboSearch' AND intStatus!=10"; 
						 		   			    
        $result = $db->RunQuery($SQL);

		while($row = mysql_fetch_array($result))
		{	
		$strName      = cdata($row["strName"]);
		$strAddress1  = cdata($row["strAddress1"]);
		$strAddress2  = cdata($row["strAddress2"]);
		$strState     = cdata($row["strState"]);
		$strStreet    = cdata($row["strStreet"]);
		$strCity      = cdata($row["strCity"]);
		$strCountry   = cdata($row["strCountry"]);
		$strZipCode   = cdata($row["strZipCode"]);
		$strPhone     = cdata($row["strPhone"]);
		$strEMail     = cdata($row["strEMail"]);
		$strFax       = cdata($row["strFax"]);
		$strWeb       = cdata($row["strWeb"]);
		$strRemarks   = cdata($row["strRemarks"]);
		$intStatus    = cdata($row["intStatus"]);

		if($intStatus == 1){
		$intStatus='Active';
		}else{
		$intStatus='Inactive';
		}	
		
		}
		?>
</p></td>
</tr>
<tr>
 <td ><table width="100%" border='0' align='center' cellpadding="3" cellspacing="0"  >
   <thead>
   <tr>
     <td colspan="2" align="center" class='border-Left-Top-right-fntsize12'><div class="normalfnt2bldBLACKmid">Subcontractor Detail Report</div></td>
     </tr></thead>
   <tr>
     <td align="center" class='border-top-left-fntsize12'width="20%"><span class="normalfnt"><strong> Name</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strName?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Address</strong></span></td>
     <td class='border-Left-Top-right-fntsize12'><span class="normalfnt"><?php echo $strAddress1." ".$strAddress2?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Street</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strStreet ?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>City</strong></span></td>
     <td class='border-Left-Top-right-fntsize12'><span class="normalfnt"><?php echo $strCity ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>State</strong></span></td>
     <td class='border-Left-Top-right-fntsize12'><span class="normalfnt"><?php echo $strState ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Country</strong></span></td>
     <td class='border-Left-Top-right-fntsize12'><span class="normalfnt"><?php echo $strCountry ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Zip Code</strong></span></td>
     <td class='border-Left-Top-right-fntsize12'><span class="normalfnt"><?php echo $strZipCode ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Phone</strong></span></td>
     <td class='border-Left-Top-right-fntsize12'><span class="normalfnt"><?php echo $strPhone ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Fax</strong></span></td>
     <td class='border-Left-Top-right-fntsize12'><span class="normalfnt"><?php echo $strFax?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Email</strong></span></td>
     <td class='border-Left-Top-right-fntsize12'><span class="normalfnt"><?php echo $strEMail ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Web</strong></span></td>
     <td class='border-Left-Top-right-fntsize12'><span class="normalfnt"><?php echo $strWeb ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Remarks</strong></span></td>
     <td class='border-Left-Top-right-fntsize12'><span class="normalfnt"><?php echo $strRemarks ?> </span></td>
   </tr>
  
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Status</strong></span></td>
     <td class='border-Left-Top-right-fntsize12'><span class="normalfnt"><?php echo $intStatus ?> </span></td>
   </tr>
   <tfoot>
    <tr>
     <td align="center"  class="border-top-fntsize12">&nbsp;</td>
     <td  class="border-top-fntsize12">&nbsp;</td>
   </tr></tfoot>
  
 </table></td></tr>
</table>

</body>
</html>
