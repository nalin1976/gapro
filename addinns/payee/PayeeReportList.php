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
<title>GaPro | Payees List Report</title>
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
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;"><table width="100%" border='0' align='center' cellpadding="3" cellspacing="0">
   <thead>
   <tr>
     <td colspan="7" class='border-Left-Top-right-fntsize12'><div align="center"><span class="normalfnt2bldBLACKmid">Payee Report</span></div></td>
     </tr>
    <tr bgcolor="#efefef">
     <td class='border-top-left-fntsize12' width="5%"><strong> <div class="normalfntMid"> No</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid">  Name</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid"> Address</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid"> Phone</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid"> Email</div></strong></td>
     <td class='border-top-left-fntsize12' width="10%"><strong> <div class="normalfntMid"> Web</div></strong></td>
     <td class='border-Left-Top-right-fntsize12' width="10%"><strong> <div class="normalfntMid"> Active</div></strong></td>
   </tr></thead>
   <?php

		$SQL="SELECT P.strTitle,P.strAddress1,P.strAddress2,P.strStreet,P.strCity,P.strState,C.strCountry,P.strZipCode,P.strPhone,P.strEMail,P.strFax,P.strWeb,P.strRemarks,P.intStatus FROM payee P inner join country C on C.intConID=P.strCountry where P.intStatus != '10' order by P.strTitle "; 
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strTitle     = cdata($row["strTitle"]);
		$strAddress1  = cdata($row["strAddress1"]);
		$strAddress2  = cdata($row["strAddress2"]);
		$strStreet    = cdata($row["strStreet"]);
		$strCity      = cdata($row["strCity"]);
		$strState	  = cdata($row["strState"]);
		$strCountry   = cdata($row["strCountry"]);
		$strZipCode   = cdata($row["strZipCode"]);
		$strPhone     = cdata($row["strPhone"]);
		$strEMail     = cdata($row["strEMail"]);
		$strFax       = cdata($row["strFax"]);
		$strWeb       = cdata($row["strWeb"]);
		$strRemarks   = cdata($row["strRemarks"]);
		$intStatus      = cdata($row["intStatus"]);
		if($intStatus == 1){
		$intStatus='Yes';
		}else{
		$intStatus='No';
		}	
		
		if($strCountry=="0")
		{
			$strCountry="";
		}?>
	
	<tr>
	  <td class='border-top-left-fntsize12'><div class="normalfntMid"><?php echo $i;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strTitle;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strAddress1." ".$strAddress2." ".$strStreet." ".$strCity." ".$strState." ".$strCountry;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strPhone;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strEMail ;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strWeb;?></div></td>
	  <td class='border-Left-Top-right-fntsize12'><div class="normalfntMid"><?php echo $intStatus;?></div></td>
   </tr>	
  <?php   $i++;	
   }
  
   ?>
   <tfoot>
   <tr>
	  <td colspan="7" class="border-top-fntsize12">&nbsp;</td>
	  </tr></tfoot>
 </table></td>
</table>


</body>
</html>
