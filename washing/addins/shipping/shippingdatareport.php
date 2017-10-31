<?php
session_start();
$backwardseperator = "../../../";
include "../../../Connector.php";
$report_companyId = $_SESSION["FactoryID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type"content="text/html; charset=utf-8"/>
<title>Shipping Data Report</title>
<link href="../../../css/erpstyle.css"rel="stylesheet"type="text/css"/>
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
    <td colspan="8" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
 <tr>
<td colspan="8" style="text-align:center">
<table width="100%" border='1' cellpadding="0"cellspacing="0"rules="all">
<thead style="height:25px">
  <tr>
     <td colspan="8" class="normalfnt2bldBLACKmid">Shipping Data Report</td>
  </tr>
      <tr>
	  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Order No</b></font></td>
	  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Pcs Per Pack</b></font></td>
	  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Vessal Data</b></font></td>
      <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Dimension</b></font></td>
      <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Wash Code</b></font></td>
	  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Qty</b></font></td>
	  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Buyer Po No</b></font></td>
	  <td class='normalfntBtab' align="center"><font style='font-size:9px;'><b>Garment Type</b></font></td>
	   
	   </tr>
	  </thead>
	   <?php
         
$SQL="SELECT orders.strOrderNo,orderdata.strDimention,orderdata.dblPcsPerPack,orderdata.strWashCode,orderdata.dtVessalDate,orderdata.intQty,orderdata.strPONo,orderdata.strGrmtType
FROM orderdata
Inner Join orders ON orderdata.intStyleID = orders.intStyleId
order by  strOrderNo  ASC"; 
						
		$result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strOrderNo=$row["strOrderNo"];
		$dblPcsPerPack=$row["dblPcsPerPack"];
		$dtVessalDate=$row["dtVessalDate"];
		$strDimention=$row["strDimention"];
	    $strWashCode=$row["strWashCode"];  
	    $intQty=$row["intQty"]; 
	    $strPONo=$row["strPONo"];
	    $strGrmtType=$row["strGrmtType"];
				
	  echo "<tr>";
	  echo"<td class='normalfnt'>$strOrderNo</td>";
	  echo"<td class='normalfnt'>$dblPcsPerPack</td>";
	  echo"<td class='normalfnt'>$dtVessalDate</td>";
	  echo"<td class='normalfnt'>$strDimention</td>"; 
	  echo"<td class='normalfnt'>$strWashCode</td>"; 
	  echo"<td class='normalfnt'>$intQty</td>"; 
	  echo"<td class='normalfnt'>$strPONo</td>";
	  echo"<td class='normalfnt'>$strGrmtType</td>";  
	  echo"</tr>";	
    $i++;	
   }  
   ?>						
  </table></td>
  </tr>
  </table>
</body>
</html>