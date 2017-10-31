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
<title>Shipment Mode</title>
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
<table width="950" border="0" align="center" cellpadding="0">
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
<thead>
  <tr>
     <td colspan="4" class="normalfnt2bldBLACKmid">Shipment Mode Report</td>
  </tr>
 <tr>
 <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' ><b> No</font></td>
 <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' ><b> Shipment Code</font></td>
 <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' ><b> Shipment Mode</font></td>
 <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' ><b> Active</font></td>
  </tr>
</thead>
	   <?php

		$SQL="SELECT * FROM shipmentmode where intStatus !='10'  order by strDescription"; 
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$intShipmentModeId = $row["intShipmentModeId"];
		$strCode    = $row["strCode"];
		$strDescription    = $row["strDescription"];
		if( $row["intStatus"]=='1')
			$status = 'Yes';
		else
			$status = 'No';
	
	echo "<tr>";
	  echo"<td class='normalfntMid'>$i</td>";
	  echo"<td class='normalfnt'>".cdata($strCode)."</td>";
	  echo"<td class='normalfnt'>".cdata($strDescription)."</td>";
	  echo"<td class='normalfntMid'>$status</td>";
   echo"</tr>";	
    $i++;	
   }
  
   ?>						
</table>
</td>
  </tr>
  </table></body>
</html>
