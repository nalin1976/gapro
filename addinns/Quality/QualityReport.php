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
<title>Seasons</title>
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
 <td height="10"></td>
</tr>
<tr>
 <td ><table width="100%" border='0' align='center' cellpadding="3" cellspacing="0">
   <thead>
   <tr >
     <td colspan="5" class='border-Left-Top-right-fntsize12'><div align="center"><span class="normalfnt2bldBLACKmid">Quality Report</span></div></td>
     </tr>
   	 <tr bgcolor="#efefef">
     <td class='border-top-left-fntsize12' width="5%"><strong> <div class="normalfntMid">No</div></strong></td>
     <td class='border-top-left-fntsize12' width="20%"><strong> <div class="normalfntMid">Code</div></strong></td>
     <td class='border-top-left-fntsize12' width="30%"><strong> <div class="normalfntMid">Name</div></strong></td>
     <td class='border-top-left-fntsize12' width="40%"><strong> <div class="normalfntMid">Remarks</div></strong></td>
     <td class='border-Left-Top-right-fntsize12' width="5%"><strong> <div class="normalfntMid">Active</div></strong></td>
   </tr></thead>
   <?php

		$SQL="SELECT * FROM quality where intStatus !='10' order by strQuality";
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strQualityCode = cdata($row["strQualityCode"]);
		$strQuality     = cdata($row["strQuality"]);
		$strRemarks     = cdata($row["strRemarks"]);
		$intStatus      = cdata($row["intStatus"]);

		if($intStatus == 1){
		$intStatus='Yes';
		}else{
		$intStatus='No';
		}	?>
	
	<tr>
	
	<tr>
	  		<td class='border-top-left-fntsize12'><div class="normalfntMid"><?php echo $i;?></div></td>
			<td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strQualityCode;?></div></td>
	  		<td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strQuality;?></div></td>
	  		<td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strRemarks;?></div></td>
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
	  </tr></tfoot>
 </table></td>
</table>


</body>
</html>
