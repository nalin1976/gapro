<?php
 session_start();
include "../../Connector.php";
$backwardseperator 	= "../../";
	//include "{$backwardseperator}Connector.php" ;	
	include "{$backwardseperator}authentication.inc";
	
	//$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
$cboCustomer   	    = $_GET["cboCustomer"];
//echo 'buyerid'.$cboCustomer;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Buyer Details Report</title>
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
		$strName	=cdata($rows["strName"]);
		$comAddress1=cdata($rows["strAddress1"]);
		$comAddress2=cdata($rows["strAddress2"]);
		$comStreet	=cdata($rows["strStreet"]);
		$comCity	=cdata($rows["strCity"]);
		$comCountry	=cdata($rows["strCountry"]);
		$comZipCode	=cdata($rows["strZipCode"]);
		$strPhone	=cdata($rows["strPhone"]);
		$comEMail	=cdata($rows["strEMail"]);
		$comFax		=cdata($rows["strFax"]);
		$comWeb		=cdata($rows["strWeb"]);
		}			
				?>
<td align="center" style="font-family: Arial;	font-size: 16pt;color: #000000;font-weight: bold;"><?php include "../../reportHeader.php";?></td>				
</tr>

<tr>
 <td align="center" height="10">
<p >
  <?php

		$SQL2="SELECT B.*,C.strCountry as strCountry2 FROM buyers B Inner Join country C ON C.intConID = B.strCountry where B.intBuyerID='$cboCustomer' AND B.intStatus !='10'"; 
			//echo $SQL2;			 		   			    
        $result2 = $db->RunQuery($SQL2);

		while($row = mysql_fetch_array($result2))
		{	
		$buyerCode      = $row["buyerCode"];
		$BuyerName      = $row["strName"];
		$strAddress1    = $row["strAddress1"];
		$strAddress2    = $row["strAddress2"];
		$strStreet      = $row["strStreet"];
		$strCity        = $row["strCity"];
		$strState       = $row["strState"];
		$strCountry     = $row["strCountry2"];
		$strZipCode     = $row["strZipCode"];
		$strPhone       = $row["strPhone"];
		$strEMail       = $row["strEMail"];
		$strFax         = $row["strFax"];
		$strWeb         = $row["strWeb"];
		$strRemarks     = $row["strRemarks"];
		$strAgentName   = $row["strAgentName"];
		$strColorCode   = $row["strColorCode"];
		$strUserID      = $row["strUserID"];
		$intStatus      = $row["intStatus"];
		if($intStatus == 1){
			$intStatus='Yes';
		}else{
			$intStatus='No';
		}
		}
		?>
</p></td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;"><table width="100%" border='0' align='center' cellpadding="3" cellspacing="0"  >
   <thead>
   <tr>
     <td colspan="2" align="center" class='border-Left-Top-right-fntsize12'><div class="normalfnt2bldBLACKmid">Buyer Detail Report</div></td>
     </tr></thead>
   <tr>
     <td align="center" class='border-top-left-fntsize12' width="20%"><span class="normalfnt"><strong> Code</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $buyerCode ?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Name</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $BuyerName?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Address</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strAddress1." ".$strAddress2?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Street</strong></span></td>
     <td class='border-Left-Top-right-fntsize12'><span class="normalfnt"><?php echo $strStreet?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> City </strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strCity?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Country</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strCountry ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>ZipCode</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strZipCode ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>Phone</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strPhone ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Email</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strEMail ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> FAx</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strFax ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Web</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strWeb?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong>Remarks</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strRemarks ?> </span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> AgentName</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strAgentName ?> </span></td>
   </tr>
   
   <tr>
     <td align="center" class='border-top-left-fntsize12' ><span class="normalfnt"><strong> Active</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $intStatus?> </span></td>
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
