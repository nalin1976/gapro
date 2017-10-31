<?php
 session_start();
include "../../Connector.php";

$cboCustomer   	    = $_GET["cboCustomer"];

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
<table align="center" width="100%" border="0">
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
<td align="center" style="font-family: Arial;	font-size: 16pt;color: #000000;font-weight: bold;"><?php echo $strName; ?></td>				
</tr>

<tr>
 <td align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">
<p >
		  <?php echo $comAddress1." ".$comAddress2." ".$comStreet."<br>".$comCity." ".$comCountry.".<br>"."Tel:".$comPhone." ".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb;?></p></td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">
 Sub Contractor's Details
 </td>
</table>

	   <?php

		$SQL="SELECT * FROM shipping_agents where intAgentId='$cboCustomer' AND intStatus!=10"; 
						 		   			    
        $result = $db->RunQuery($SQL);

		while($row = mysql_fetch_array($result))
		{	
		$strName      = $row["strName"];
		$strAddress1  = $row["strAddress1"];
		$strAddress2  = $row["strAddress2"];
		$strStreet    = $row["strStreet"];
		$strState    = $row["strState"];
		$strCity      = $row["strCity"];
		$strCountry   = $row["strCountry"];
		$strZipCode   = $row["strZipCode"];
		$strPhone     = $row["strPhone"];
		$strEMail     = $row["strEMail"];
		$strFax       = $row["strFax"];
		$strWeb       = $row["strWeb"];
		$strRemarks   = $row["strRemarks"];
		$intStatus      = $row["intStatus"];

		if($intStatus == 1){
		$intStatus='Active';
		}else{
		$intStatus='Inactive';
		}	
		
		}
		?>


<table width="800" border='1' align='center' cellpadding="3" cellspacing="1"  >	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Name</font></td>
	  <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b><?php echo $strName?></font></td>
	  </tr>
	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Address</font></td>
	  <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b><?php echo $strAddress1." ".$strAddress2?></font></td>
	  </tr>
	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Street</font></td>
	  <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b><?php echo $strStreet ?></font></td>
	  </tr>
	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> City</font></td>
	  <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b><?php echo $strCity ?> </font></td>
	  </tr>
	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> State</font></td>
	  <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b> <?php echo $strState ?> </font></td>
	  </tr>
	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Country</font></td>
      <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b><?php echo $strCountry ?>  </font></td>
	  </tr>
	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Zip Code</font></td>
	  <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b><?php echo $strZipCode ?>  </font></td>
	  </tr>
	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Phone</font></td>
	  <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b> <?php echo $strPhone ?> </font></td>
	  </tr>
	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Fax</font></td>
	  <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b><?php echo $strFax?>  </font></td>
	  </tr>
	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Email</font></td>
	  <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b><?php echo $strEMail ?>  </font></td>
	  </tr>
	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Web</font></td>
	  <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b><?php echo $strWeb ?> </font></td>
	  </tr>
	  	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Remarks</font></td>
	  <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b><?php echo $strRemarks ?> </font></td>
	  </tr>	
	  
	  <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Status</font></td>
	  <td class='normalfnt' align="center"><font  style='font-size: 9px;' ><b><?php echo $intStatus ?> </font></td>
	  </tr>					
</table>	

  


</body>
</html>
