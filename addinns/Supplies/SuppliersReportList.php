<?php
 session_start();
include "../../Connector.php";
$backwardseperator 	= "../../";
//include "{$backwardseperator}Connector.php" ;	
include "{$backwardseperator}authentication.inc";

$userId	= $_GET["UserId"];
$report_companyId  = $_SESSION["FactoryID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Supplier List Report</title>
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
<table align="center" width="1000" border="0">
<tr>
<td align="center" style="font-family: Arial;	font-size: 16pt;color: #000000;font-weight: bold;"><?php include "../../reportHeader.php";?></td>				
</tr>

<tr>
 <td align="center" height="10"></td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;"><table width="100%" border='0' align='center' cellpadding="3" cellspacing="0">
   <thead>
   <tr>
     <td colspan="8" class='border-Left-Top-right-fntsize12'><div align="center"><span class="normalfnt2bldBLACKmid">Suppliers Report</span></div></td>
     </tr>
   <tr bgcolor="#efefef">
     <td class='border-top-left-fntsize12' width="5%"><strong> <div class="normalfntMid"> No</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid">Vat Reg No</div></strong></td>
     <td class='border-top-left-fntsize12' width="20%"><strong> <div class="normalfntMid"> Supplier </div>
     </strong></td>
     <td class='border-top-left-fntsize12' width="30%"><strong> <div class="normalfntMid"> Address</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid"> Phone</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid"> Email</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid"> Web</div></strong></td>
     <td class='border-Left-Top-right-fntsize12' width="5%"><strong> <div class="normalfntMid">Active</div></strong></td>
   </tr></thead>
   <?php

		$SQL="SELECT * FROM suppliers where intStatus != '10' order by strTitle"; 
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strVatRegNo    = $row["strVatRegNo"];
		$strTitle      	= $row["strTitle"];
		$strAddress1  	= $row["strAddress1"];
		$strAddress2  	= $row["strAddress2"];
		$strStreet    	= $row["strStreet"];
		$strCity      	= $row["strCity"];
		$strState		= $row["strState"];
		$strCountry   	= getCountry($row["strCountry"]);
		$strZipCode   	= $row["strZipCode"];
		$strPhone     	= $row["strPhone"];
		$strEMail    	= $row["strEMail"];
		$strFax      	= $row["strFax"];
		$strWeb       	= $row["strWeb"];
		$strRemarks   	= $row["strRemarks"];
		$intStatus      = $row["intStatus"];

		if($intStatus == 1){
			$intStatus='Yes';
		}else{
			$intStatus='No';
		}	
?>
		
		<tr>
	  		<td class='border-top-left-fntsize12'><div class="normalfntMid"><?php echo $i;?></div></td>
	        <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strVatRegNo;?></div></td>
		  	<td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strTitle;?></div></td>
	 		<td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strAddress1." ".$strAddress2." ".$strStreet." ".$strCity." ".$strState." ".$strCountry;?></div></td>
	 		<td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strPhone;?></div></td>
			<td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strEMail;?></div></td>
	  		<td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo$strWeb;?></div></td>
	 		<td class='border-Left-Top-right-fntsize12'><div class="normalfntMid"><?php echo $intStatus;?></div></td>
   		</tr>
   <?php $i++;	
   }
  
   ?>
  <tfoot>
   <tr>
		  <td class="border-top-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12">&nbsp;</td>
	    </tr></tfoot>
 </table></td>
</table>
<?php
function getCountry($comID)
{
global $db;
	$SQL = "SELECT CN.strCountry FROM country CN INNER JOIN companies CM ON
			CN.intConID = CM.intCountry 
			WHERE CM.intCompanyID=2";			 
	$result = $db->RunQuery($SQL);
	$row 	= mysql_fetch_array($result);
	$Country = $row["strCountry"];			
return $Country;	
}
?>
</body>
</html>
