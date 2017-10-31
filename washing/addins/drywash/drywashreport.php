<?php
session_start();
$backwardseperator = "../../../";
include "../../../Connector.php";
$report_companyId=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Dry Process</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
<table align="center" width="800" border="0">

<tr>
      <td ><?php include '../../../reportHeader.php';?></td>
</tr>	
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">Process
 </td>
 </tr>

</table>


<table width="800" border='1' align='center' CELLPADDING=3 CELLSPACING=1>


<tr>
 <tr>
 <td class='normalfntBtab' > <strong>No</strong></td>
 <td class='normalfntBtab' > <strong>Code</strong></td>
 <td class='normalfntBtab' > <strong>Description</strong></td>
 <td class='normalfntBtab' > <strong>Active</strong></td>
  </tr>
	   <?php

		$SQL="SELECT * FROM was_dryprocess where intStatus !='10' order by strDescription";
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strDryProCode = $row["strDryProCode"];
		$strDescription = $row["strDescription"];
		$intStatus      = $row["intStatus"];

		if($intStatus == 1){
		$intStatus='Yes';
		}else{
		$intStatus='No';
		}	
	
   echo "<tr>";
	  echo"<td class='normalfntMid'>$i</td>";
	  echo"<td class='normalfnt'>$strDryProCode</td>";
	  echo"<td class='normalfnt'>$strDescription</td>";
	  echo"<td class='normalfnt'>$intStatus</td>";
   echo"</tr>";	
    $i++;	
   }
  
   ?>						
</table>	
</body>
</html>
