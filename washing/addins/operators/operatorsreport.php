<?php
 session_start();
 $backwardseperator = "../../../";
include "../../../Connector.php";
$report_companyId = $_SESSION["FactoryID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operators</title>
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
<table width="750" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%"><?php include "../../../reportHeader.php";?></td>

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


<table width="100%" border='1' cellpadding="0" cellspacing="0" rules="all">
<thead style="height:25px">
  <tr>
     <td colspan="5" class="normalfnt2bldBLACKmid">Operators Report</td>
  </tr>
      <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Name</b></font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Machine name</b></font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Shift</b></font></td>
      <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b>Remarks</b></font></td>
      <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b>Active</b></font></td>
	  </tr>
	  </thead>
	   <?php
         
		$SQL="select o.strName,m.strMachineName,WS.strShiftName,o.strRemarks,o.intStatus
from was_operators o inner join was_machine m on o.intMachineId=m.intMachineId
inner join was_shift WS on WS.intShiftId=o.strShift
where o.intStatus <>'10'
order by o.strName"; 
						
							
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$name = $row["strName"];
		$machine=$row["strMachineName"];
		$shift= $row["strShiftName"];
		$remarks= $row["strRemarks"];
	   $intStatus= $row["intStatus"];
		
		if($intStatus == 1){
		$intStatus='Yes';
		}else{
		$intStatus='No';
		}	
	echo "<tr>";
	  echo"<td class='normalfnt'>$name</td>";
	  echo"<td class='normalfnt'>$machine</td>";
	  echo"<td class='normalfnt'>$shift</td>";
	  echo"<td class='normalfnt'>$remarks</td>"; 
	  echo"<td class='normalfnt'>$intStatus</td>"; 
	   echo"</tr>";	
    $i++;	
   }
  
   ?>						
    </table></td>
  </tr>
  </table>
</body>
</html>
