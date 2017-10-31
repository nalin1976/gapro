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
<title>Units</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
<tr>
 <td height="10"><table width="100%" border="0"  cellspacing="0" cellpadding="3" align='center' >
   <thead>
     <tr  >
       <td colspan="5" align="center" class='border-Left-Top-right-fntsize12'><div align="center"><span class="normalfnt2bldBLACKmid">Units Report</span></div></td>
     </tr>
     <tr  bgcolor="#efefef">
       <td align="center" class='border-top-left-fntsize12'><strong>
         <div class="normalfntMid">No</div>
       </strong></td>
       <td align="center" class='border-top-left-fntsize12'><strong>
         <div class="normalfntMid">Unit</div>
       </strong></td>
       <td align="center" class='border-top-left-fntsize12'><strong>
         <div class="normalfntMid">Description</div>
       </strong></td>
       <td align="center" class='border-top-left-fntsize12'><strong>
         <div class="normalfntMid">No of Pcs</div>
       </strong></td>
       <td align="center" class='border-Left-Top-right-fntsize12'><strong>
         <div class="normalfntMid">Active</div>
       </strong></td>
     </tr>
   </thead>
   <?php

		$SQL="SELECT * FROM units where intStatus !='10'"; 
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strUnit      = cdata($row["strUnit"]);
		$strTitle     = cdata($row["strTitle"]);
		$intPcsForUnit= cdata($row["intPcsForUnit"]);
		$intStatus    = cdata($row["intStatus"]);
		if($intStatus == '1'){
		$intStatus = "Yes";
		}else{
		$intStatus = "No";
		}?>
   <tr>
     <td class='border-top-left-fntsize12'><div class="normalfntMid"><?php echo $i?></div></td>
     <td class='border-top-left-fntsize12'><span class="normalfnt"><?php echo $strUnit?></span></td>
     <td class='border-top-left-fntsize12'><span class="normalfnt"><?php echo $strTitle?></span></td>
     <td class='border-top-left-fntsize12' ><div class="normalfntRite"><?php echo $intPcsForUnit?>&nbsp;</div></td>
     <td class='border-Left-Top-right-fntsize12'><div class="normalfntMid"><?php echo $intStatus?></div></td>
   </tr>
   <?php   $i++;	
   }?>
   <tfoot>
     <tr>
       <td class="border-top-fntsize12" width="5%">&nbsp;</td>
       <td class="border-top-fntsize12" width="30%">&nbsp;</td>
       <td class="border-top-fntsize12" width="40%">&nbsp;</td>
       <td class="border-top-fntsize12" width="20%">&nbsp;</td>
       <td class="border-top-fntsize12" width="5%">&nbsp;</td>
     </tr>
   </tfoot>
 </table></td>
</table>


</body>
</html>
