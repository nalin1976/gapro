<?php
 session_start();
include "../../Connector.php";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seasons</title>
<link href="../css/planning.css" rel="stylesheet" type="text/css" />
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
 Seasons
 </td>
</table>


<table width="800" border='1' align='center' CELLPADDING=3 CELLSPACING=1>
 <tr>
 <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> No</font></td>
 <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Code</font></td>
 <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Name</font></td>
 <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Remarks</font></td>
  </tr>
	   <?php

		$SQL="SELECT * FROM seasons where intStatus !='10'"; 
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strSeasonCode = $row["strSeasonCode"];
		$strSeason     = $row["strSeason"];
		$strRemarks    = $row["strRemarks"];
	
	echo "<tr>";
	  echo"<td class='normalfntMid'>$i</td>";
	  echo"<td class='normalfnt'>$strSeasonCode</td>";
	  echo"<td class='normalfnt'>$strSeason</td>";
	  echo"<td class='normalfnt'>$strRemarks</td>";
   echo"</tr>";	
    $i++;	
   }
  
   ?>						
</table>	
</body>
</html>
