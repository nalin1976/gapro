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
<title>Departments</title>
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
     <td colspan="6" class="normalfnt2bldBLACKmid">Department Report</td>
  </tr>
 <tr>
 <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' >No</font></td>
 <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' >Code</font></td>
 <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' >Name</font></td>
 <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' >Company Name</font></td>
  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' >Remarks</font></td>
  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' >Active</font></td>
  </tr>
</thead>
	   <?php
		$comid = $_GET["intCompayID"];
		$SQL="SELECT d.*,c.strName 
FROM department d inner join companies c on  d.intCompayID = c.intCompanyID where d.intStatus !='10' ";

		if($comid != 'NA')
			$SQL .= "and intCompayID = '$comid'";
			
		$SQL .= " order by strDepartment";	
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strDepartmentCode	 = cdata($row["strDepartmentCode"]);
		$strDepartment    	 = cdata($row["strDepartment"]);
		$strRemarks    		 = cdata($row["strRemarks"]);
		$ComName     		 = cdata($row["strName"]);
		$intStatus      	 = cdata($row["intStatus"]);

		if($intStatus == 1){
		$intStatus='Yes';
		}else{
		$intStatus='No';
		}	
		
	echo "<tr>";
	  echo"<td class='normalfntMid'>$i</td>";
	  echo"<td class='normalfnt'>$strDepartmentCode</td>";
	  echo"<td class='normalfnt'>$strDepartment</td>";
	  echo"<td class='normalfnt'>$ComName</td>";
	   echo"<td class='normalfnt'>$strRemarks</td>";
	   echo"<td class='normalfntMid'>$intStatus</td>";
   echo"</tr>";	
    $i++;	
   }
  
   ?>						
</table>
</td>
  </tr>
  </table></body>
</html>
