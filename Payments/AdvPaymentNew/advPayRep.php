<?php
 session_start();
include "../../Connector.php";
	$backwardseperator 	= "../../";
	//include "{$backwardseperator}Connector.php" ;	
	include "{$backwardseperator}authentication.inc";
	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
	
	 $supID=$_GET["supID"];
	 $dateFrom=$_GET["dateFrom"];
	 $dateTo=$_GET["dateTo"];	
	 $poNo=$_GET['poNo'];
	 $poYear=$_GET['poYear'];
	 $cboUser=$_GET['cboUser'];
	 $strPaymentType=$_GET["strPaymentType"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Advance Payments List</title>
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
     <td colspan="7" class="normalfnt2bldBLACKmid">Advance Payments List</td>
  </tr>
 <tr>
 <td class='normalfntBtab' align="center" width="3%"><font  style='font-size: 11px;' > No</font></td>
 <td class='normalfntBtab' align="center" width="14%"><font  style='font-size: 11px;' >PO No</font></td>
 <td class='normalfntBtab' align="center" width="24%"><font  style='font-size: 11px;' > Payment No</font></td>
 <td class='normalfntBtab' align="center" width="19%"><font  style='font-size: 11px;' > Payment Date</font></td>
 <td class='normalfntBtab' align="center" width="16%"><font  style='font-size: 11px;' > Amount</font></td>
 <td class='normalfntBtab' align="center" width="12%"><font  style='font-size: 11px;' > Tax</font></td>
 <td class='normalfntBtab' align="center" width="12%"><font  style='font-size: 11px;' > Total Amount</font></td>
  </tr>
</thead>
	   <?php

	$strSQL=" SELECT  distinct advancepayment.PaymentNo, advancepayment.paydate,advancepayment.poamount,advancepayment.taxamount,
			advancepayment.totalamount,advancepayment.userID,concat(advancepaymentpos.POYear,'/',advancepaymentpos.POno)pono
			FROM advancepayment 
			inner join advancepaymentpos on advancepaymentpos.PaymentNo=advancepayment.PaymentNo
			WHERE advancepayment.strType='$strPaymentType' ";
			if(!empty($supid)){
				$strSQL.=" and advancepayment.supid='$supid'";
			}
			else if(!empty($dateFrom) && !empty($dateTo)){
				$strSQL.=" and advancepayment.paydate>='$dateFrom'  and advancepayment.paydate<='$dateTo' " ;
			}		
			else if(!empty($poNo) && !empty($poYear)){
				$strSQL.=" and advancepaymentpos.POno='$poNo'  and advancepaymentpos.POYear='$poYear'";
			}
			if(!empty($cboUser)){
				$strSQL.=" and advancepayment.userID='$cboUser'";
			}
			
			 $strSQL.=" ORDER BY advancepayment.paydate desc";
						 		   			    
        $result = $db->RunQuery($strSQL);
	    $i=1;
		while($row = mysql_fetch_array($result))
		{	
		$pono = $row["pono"];	
		$PaymentNo = $row["PaymentNo"];
		$paydate    = cdata($row["paydate"]);
		$poamount = $row["poamount"];
		$taxamount = $row["taxamount"];
		$totalamount = $row["totalamount"];

	
	echo "<tr>";
	  echo"<td class='normalfntMid'>$i</td>";
	  echo"<td class='normalfnt'>$pono</td>";
	  echo"<td class='normalfnt'>$PaymentNo</td>";
	  echo"<td class='normalfnt'>$paydate</td>";
	  echo"<td class='normalfntRite'>$poamount</td>";
	  echo"<td class='normalfntRite'>$taxamount</td>";
	  echo"<td class='normalfntRite'>$totalamount</td>";
   echo"</tr>";	
    $i++;	
   }
  
   ?>						
</table>
</td>
  </tr>
  </table></body>
</html>
