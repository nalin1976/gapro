<?php
 session_start();
include "../../Connector.php";
	$backwardseperator 	= "../../";
	//include "{$backwardseperator}Connector.php" ;	
	include "{$backwardseperator}authentication.inc";
	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
	$branchiD = $_GET["branchID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Branch listing Report</title>
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
     <td colspan="7" class="normalfnt2bldBLACKmid">Branch List Report</td>
  </tr>
      <tr>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' >No</font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' >Branch</font> <font  style='font-size:11px;' >Code</font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' > Branch Name</font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' >Bank Code </font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' >Address</font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' >Phone</font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' >Contact Person</font></td>
	  <td class='normalfntBtab' align="center"><font  style='font-size: 11px;' ><b>Active</font></td>
	  </tr>
  </thead>

	   <?php

		$SQL="SELECT 
			BR.strBranchCode, 
			BR.strName, 
			BA.strBankCode, 
			BR.strContactPerson, 
			BR.intStatus,
			BR.strAddress1,
			BR.strStreet,
			BR.strCity,
			C.strCountry,
			BR.strPhone
			FROM branch BR
			Inner Join bank BA ON BA.intBankId = BR.intBankId
			inner join country C on C.intConID=BR.strCountry
			where BR.intStatus !='10'"; 
						 		   			    
        $result = $db->RunQuery($SQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{		
		$strBranchCode    = cdata($row["strBranchCode"]);
		$strName          = cdata($row["strName"]);
		$strBankCode   	  = cdata($row["strBankCode"]);
		$strPhone         = cdata($row["strPhone"]);
		$strContactPerson = cdata($row["strContactPerson"]);
		$intStatus        = cdata($row["intStatus"]);
		$strAddress1      = cdata($row["strAddress1"]);
		$strStreet        = cdata($row["strStreet"]);
		$strCity          = cdata($row["strCity"]);
		$strCountry       = cdata($row["strCountry"]);
		
		if($intStatus == 1){
		$intStatus='Yes';
		}else{
		$intStatus='No';
		}	
	  echo "<tr>";
	  echo"<td class='normalfntMid'>$i</td>";
	  echo"<td class='normalfnt'>$strBranchCode</td>";
	  echo"<td class='normalfnt'>$strName</td>";
	  echo"<td class='normalfnt'>$strBankCode</td>";
	  echo"<td class='normalfnt'>$strAddress1 $strStreet $strCity $strCountry</td>";
	  echo"<td class='normalfnt'>$strPhone </td>";
	  echo"<td class='normalfnt'>$strContactPerson</td>";
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
