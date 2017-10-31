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
<title>Item Purchase Type </title>
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
<td align="center">
  <?php include "../../reportHeader.php";?>
</td>				
</tr>

<tr>
 <td height="10"></td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;"><table width="100%" border='0' align='center' cellpadding="3" cellspacing="0">
   <thead>
   <tr>
     <td colspan="5" class='border-Left-Top-right-fntsize12'><div class="normalfnt2bldBLACKmid">Origin Types  Report</div></td>
     </tr>
   <tr bgcolor="#efefef">
      <td class='border-top-left-fntsize12' width="5%"><strong> <div class="normalfntMid"> No</div></strong></td>
     <td class='border-top-left-fntsize12' width="30%"><strong> <div class="normalfntMid"> Origin Type</div></strong></td>
     <td class='border-top-left-fntsize12' width="30%"><strong> <div class="normalfntMid"> Origin Description</div></strong></td>
     <td class='border-top-left-fntsize12' width="30%"><strong> <div class="normalfntMid"> Finance or Non Finance</div></strong></td>
     <td class='border-Left-Top-right-fntsize12' width="5%"><strong> <div class="normalfntMid"> Active</div></strong></td>
   </tr></thead>
   <?php

		$SQL="SELECT * FROM itempurchasetype where intStatus !='10' ORDER BY strOriginType ASC"; 
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strOriginType    = cdata($row["strOriginType"]);
		$intType          = cdata($row["intType"]);
		$intStatus        = cdata($row["intStatus"]);
		$strOriginDescription = cdata($row["strDescription"]);
		
		if($intStatus == 0){
		$intStatus = "No";
		}
	    if($intStatus == 1){
		$intStatus = "Yes";
		}
		if(	$intType =='1'){
			$intType = 'Non Finance';
		}else{
			$intType = 'Finance';
		}?>
	
	
	<tr>
	  <td class='border-top-left-fntsize12'><div class="normalfntMid"><?php echo $i;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strOriginType;?></div></td>
       <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $strOriginDescription;?></div></td>
	  <td class='border-top-left-fntsize12'><div class="normalfnt"><?php echo $intType;?></div></td>
	  <td class='border-Left-Top-right-fntsize12'><div class="normalfntMid"><?php echo $intStatus;?></div></td>
   </tr>
  <?php  $i++;	
   }
  
   ?>
   <tfoot>
   <tr>
	  <td colspan="5" class="border-top-fntsize12">&nbsp;</td>
	  </tr></tfoot>
 </table></td>
</table>


</body>
</html>
