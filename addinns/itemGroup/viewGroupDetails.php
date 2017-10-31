<?php
 session_start();
include "../../Connector.php";
	$backwardseperator 	= "../../";
	//include "{$backwardseperator}Connector.php" ;	
	include "{$backwardseperator}authentication.inc";
	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
	$groupid   	    = $_GET["groupid"];
	$groupName      = $_GET["groupName"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Group Details</title>
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
     <td colspan="2" class="normalfnt2bldBLACKmid">Group Details Report </td>
  </tr>
  <tr>
     <td colspan="2" class="normalfnt2bldBLACKmid">Group Name - <?php echo $groupName; ?> </td>
  </tr>
      <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' >Item Code</font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size:11px;' >Item Name</font></td>
	  </tr>
  </thead>

	   <?php

	   $SQL = "select m.strItemCode,m.strItemDescription
from matitemlist m inner join matitemgroupdetails mg on m.intItemSerial = mg.matDetailId
where mg.groupID='$groupid'";
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strCode    = cdata($row["strItemCode"]);
		$strName    = cdata($row["strItemDescription"]);
	echo "<tr>";
	  echo"<td class='normalfnt'>$strCode</td>";
	  echo"<td class='normalfnt'>$strName</td>";
   echo"</tr>";	
    $i++;	
   }
  
   ?>						
</table>
</td>
  </tr>
  </table></body>
</html>
