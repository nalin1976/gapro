<?php
 session_start();
include "../../Connector.php";
	$backwardseperator 	= "../../";
	//include "{$backwardseperator}Connector.php" ;	
	include "{$backwardseperator}authentication.inc";
	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
//	$branchiD = $_GET["branchID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cheque Informationt</title>
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
     <td colspan="7" class="normalfnt2bldBLACKmid">Cheque Information Report</td>
  </tr>
      <tr>
	 <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> No</font></td>
	 <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Cheque-book Name</font></td>
	 <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Bank Code</font></td>
	 <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Branch Code</font></td>
	 <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Start No</font></td>
	 <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> End No</font></td>
	 <td class='normalfntBtab' align="center"><font  style='font-size: 9px;' ><b> Status</font></td>
	  </tr>
  </thead>

	   <?php

		$SQL="SELECT 
		bankchequeinfo.strName,
		bankchequeinfo.intBankID,
		bankchequeinfo.intBranchId,
		bank.strBankCode,
		branch.strBranchCode,
		bankchequeinfo.intStartNo,
		bankchequeinfo.intEndNo,
		bankchequeinfo.intStatus,
		bankchequeinfo.intUsed  
		FROM 
		bankchequeinfo 
		INNER JOIN bank ON bankchequeinfo.intBankID = bank.intBankID
		INNER JOIN branch ON bankchequeinfo.intBranchId=branch.intBranchId
		ORDER BY bankchequeinfo.strName asc"; 
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strName       = $row["strName"];
		$strBankCode   = $row["strBankCode"];
		$strBranchCode = $row["strBranchCode"];
		$intStartNo    = $row["intStartNo"];
		$intEndNo      = $row["intEndNo"];
		$bankName      = $row["bankName"];
		$intStatus        = cdata($row["intStatus"]);
		if($intStatus == 1){
		$intStatus='Yes';
		}else{
		$intStatus='No';
		}	
	
	echo "<tr>";
	  echo"<td class='normalfntMid'>$i</td>";
	  echo"<td class='normalfnt'>$strName</td>";
	  echo"<td class='normalfntMid'>$strBankCode</td>";
      echo"<td class='normalfntMid'>$strBranchCode</td>";
	  echo"<td class='normalfntRite'>$intStartNo</td>";
	  echo"<td class='normalfntRite'>$intEndNo</td>";
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
