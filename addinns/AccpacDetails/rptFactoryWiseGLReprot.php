<?php
 session_start();
 $backwardseperator = "../../";
include "../../Connector.php";
$report_companyId = $_SESSION["FactoryID"];
$fact=$_GET['fact'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Factory Wise GL Report</title>
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
     <td colspan="5" class="normalfnt2bldBLACKmid">Cost Center  Wise GL Report</td>
  </tr>
      <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' ><b> Account ID</b></font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' ><b> Description</b></font></td>
      <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' ><b>Account Type</b></font></td>
	  </tr>
	  </thead>
	   <?php

		$SQL="select gl.strAccID,gl.strDescription,gl.strAccType 
			from glaccounts gl inner join glallowcation glAllo on
			gl.intGLAccID=glAllo.GLAccNo
			where FactoryCode='$fact' order by gl.strAccID"; 
				//echo $SQL;
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$GLAccAllowNo = cdata($row["strAccID"]);
		$GLAccNo     = cdata($row["strDescription"]);
		$accType = $row["strAccType"];
		
		if($accType == '1')
			$AccountType = 'PNL Account';
		else
		   $AccountType = 'Balance Sheet';
			
		$FactoryCode      = cdata($row["FactoryCode"]);	
			echo "<tr>";
	  		echo"<td class='normalfnt'>$GLAccAllowNo</td>";
	  		echo"<td class='normalfnt'>$GLAccNo</td>";
	  		echo"<td class='normalfnt'>$AccountType</td>"; 
   			echo"</tr>";	
		}	



  
   ?>						
    </table></td>
  </tr>
  </table>
</body>
</html>
