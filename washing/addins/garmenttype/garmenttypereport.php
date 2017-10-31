<?php
session_start();
$backwardseperator = "../../../";
include "../../../Connector.php";
$report_companyId=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type"content="text/html; charset=utf-8"/>
<title>Garment Type Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
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
    <td colspan="4" style="text-align:center">
<table width="100%" border='1' cellpadding="0" cellspacing="0" rules="all">
<thead style="height:25px">
  <tr>
      <td colspan="4" class="normalfnt2bldBLACKmid">Garment Type Report</td>
      </tr>
      <tr>
	  <td class='normalfntBtab' align="center"><b>No</b></td>
	  <td class='normalfntBtab' align="center"><b>Garment Name</b></td>
	  <td class='normalfntBtab' align="center"><b>Garment Description </b></td>
      <td class='normalfntBtab' align="center"><b>Active</b></td>
	  </tr>
	  </thead>
	  <?php        
		$SQL="SELECT * FROM was_garmenttype where intStatus !='10' order by intGamtID asc";			
        $result=$db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
	{		
		$GamtID=$row["intGamtID"];
		$GarmentName=$row["strGarmentName"];
		$Descrtiption=$row["strGamtDesc"];
		$intStatus=$row["intStatus"];
		
		if($intStatus==1)
		{
		$intStatus='Yes';
		}
		else
		{
		$intStatus='No';
		}	
	  echo "<tr>";
	  echo"<td class='normalfnt'>$i</td>";
	  echo"<td class='normalfnt'>$GarmentName</td>";
	  echo"<td class='normalfnt'>$Descrtiption</td>";
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