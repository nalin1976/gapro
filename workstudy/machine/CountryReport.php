<?php
 session_start();
 $backwardseperator = "../../";
include "../../Connector.php";
$report_companyId = $_SESSION["FactoryID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Countries</title>
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
<table width="900" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%"><?php include "../../reportHeader.php";?></td>

              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  


  <tr>
    <td colspan="5" style="text-align:center">


<table width="100%" border='1' cellpadding="3" cellspacing="0" rules="all">
<thead style="height:25px">
  <tr>
     <td colspan="5" class="normalfnt2bldBLACKmid">Countries Report</td>
  </tr>
      <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' ><b> No</b></font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' ><b> Code</b></font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' ><b> Name</b></font></td>
      <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' ><b>Zip Code</b></font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' ><b>Active</b></font></td>
	  </tr>
	  </thead>
	   <?php

		$SQL="SELECT * FROM country where intStatus !='10' order by strCountry asc"; 
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strCountryCode = cdata($row["strCountryCode"]);
		$strCountry     = cdata($row["strCountry"]);
		$intStatus      = cdata($row["intStatus"]);
		$zipCode      	= cdata($row["strZipCode"]);
		
		if($intStatus == 1){
		$intStatus='Yes';
		}else{
		$intStatus='No';
		}	
	echo "<tr>";
	  echo"<td class='normalfntMid'>$i</td>";
	  echo"<td class='normalfnt'>$strCountryCode</td>";
	  echo"<td class='normalfnt'>$strCountry</td>";
	  echo"<td class='normalfnt'>$zipCode</td>"; 
	  echo"<td class='normalfntMid'>$intStatus</td>";
   echo"</tr>";	
    $i++;	
   }
  
   ?>						
    </table></td>
  </tr>
  </table>
</body>
</html>
