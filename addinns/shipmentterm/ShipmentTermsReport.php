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
<title>Shipment Terms</title>
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
		$strName=cdata($rows["strName"]);
		$comAddress1=cdata($rows["strAddress1"]);
		$comAddress2=cdata($rows["strAddress2"]);
		$comStreet=cdata($rows["strStreet"]);
		$comCity=cdata($rows["strCity"]);
		$comCountry=cdata($rows["strCountry"]);
		$comZipCode=cdata($rows["strZipCode"]);
		$strPhone=cdata($rows["strPhone"]);
		$comEMail=cdata($rows["strEMail"]);
		$comFax=cdata($rows["strFax"]);
		$comWeb=cdata($rows["strWeb"]);
		}			
				?>
<td align="center" ><?php include "../../reportHeader.php";?></td>				
</tr>

<tr>
  <td height="10"></td>
</tr>
<tr>
 <td height="10"><table width="100%" border='0' align='center' cellpadding="3" cellspacing="0">
   <thead>
   <tr>   
     <td colspan="4" align="center" class='border-Left-Top-right-fntsize12'><div align="center"><span class="normalfnt2bldBLACKmid">Shipment Term Report</span></div></td>
     </tr>
	 <tr bgcolor="#efefef">
     <td class='border-top-left-fntsize12' width="5%"><strong> <div class="normalfntMid">No</div></strong></td>
     <td class='border-top-left-fntsize12' width="35%"><strong> <div class="normalfntMid">Code</div></strong></td>
     <td class='border-top-left-fntsize12' width="55%"><strong> <div class="normalfntMid">Shipment Term</div></strong></td>
     <td class='border-Left-Top-right-fntsize12' width="5%"><strong> <div class="normalfntMid">Active</div></strong></td>
   </tr>
   </thead>
   <?php

		$SQL="SELECT * FROM shipmentterms where intStatus !='10' order by strShipmentTerm"; 
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strShipmentTermCode = $row["strCode"];
		$strShipmentTerm   = $row["strShipmentTerm"];
		if($row["intStatus"]==1)
			$status = 'Yes';
		else
			$status = 'No';?>
		
	<tr>
	  <td class='border-top-left-fntsize12'><div class="normalfntMid"><?php echo $i;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo cdata($strShipmentTermCode);?></div></td>
	 <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo cdata($strShipmentTerm);?></div></td>
	  
	  <td class='border-Left-Top-right-fntsize12'><div class="normalfntMid"><?php echo $status;?></div></td>
   </tr>
  <?php   $i++;	
   }
  
   ?>
   <tfoot>
   <tr>
		  <td class="border-top-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12">&nbsp;</td>
		  <td class="border-top-fntsize12">&nbsp;</td>
		  
	    </tr></tfoot>
 </table></td>
</tr>
</table>


</body>
</html>
