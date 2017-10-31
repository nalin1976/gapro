<?php 
 session_start();
 $backwardseperator 	= "../../";
 include "{$backwardseperator}authentication.inc";
 $report_companyId=$_SESSION['UserID'];
 $dfrom = '2011-03-01';
 $dto = '2011-03-31';
 $styleID = 46;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Sub Contractor report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>
<?php 
include "../../Connector.php";
?>
<body>

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
 <td width="1174" align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">
  <?php include('../../reportHeader.php'); ?>
</td>
</tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="tablez">
      <tr>
        <td colspan="4" height="25" class="normalfntMid"><b>Send</b></td>
        <td colspan="4" class="normalfntMid"><b>Receive</b></td>
        </tr>
      <tr>
        <td width="88" class="normalfntBtab" height="20">Date</td>
        <td width="98" class="normalfntBtab">AOD</td>
        <td width="80" class="normalfntBtab">Qty</td>
        <td width="101" class="normalfntBtab">Total</td>
        <td width="108" class="normalfntBtab">AOD</td>
        <td width="108" class="normalfntBtab">Qty</td>
        <td width="108" class="normalfntBtab">Total</td>
        <td width="109" class="normalfntBtab">Balance</td>
      </tr>
      <?php 
	  	
	$sql = "select  intStyleId,intDocumentNo,strColor,strType,dblQty,date(dtmDate) as dtmDate
 from was_stocktransactions 
where strType in ('SubOut','SubIn') and date(dtmDate) between '$dfrom' and '$dto' 
and intStyleId='$styleID'
order by date(dtmDate)";

	$result =  $db->RunQuery($sql);
	$firstRow = true;
	while($row = mysql_fetch_array($result))
	{
		$CurrDate = $row["dtmDate"];
		$strType = $row["strType"];
		
		$adoIN = ($strType == 'SubIn' ? $row["intDocumentNo"] : '&nbsp;');
		$adoQtyIn = ($strType == 'SubIn' ? $row["dblQty"] : '&nbsp;');
		
		$adoOUT = ($strType == 'SubOut' ? $row["intDocumentNo"] : '&nbsp;');
		$adoQtyOut = ($strType == 'SubOut' ? $row["dblQty"] : '&nbsp;');
		
		if($firstRow)
		{
	  ?>
      <tr>
      
        <td class="normalfntTAB"><?php echo $row["dtmDate"]; ?></td>
        <td><?php echo $adoIN; ?></td>
        <td><?php echo $adoQtyIn; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $adoOUT; ?></td>
        <td><?php echo $adoQtyOut ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
		  <?php 
		  	$prevDate = $CurrDate;
			$firstRow = false;
          }
		  else
		  {
		  	if($prevDate != $CurrDate)
				{
          ?>
             <tr>
          
            <td class="normalfntTAB"><?php echo $row["dtmDate"]; ?></td>
            <td><?php echo $adoIN; ?></td>
        <td><?php echo $adoQtyIn; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $adoOUT; ?></td>
        <td><?php echo $adoQtyOut ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
             </tr>
             <?php 
			 	}
			else
				{
			 ?>
             <tr>
          
            <td class="normalfntTAB">&nbsp;</td>
            <td><?php echo $adoIN; ?></td>
        <td><?php echo $adoQtyIn; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $adoOUT; ?></td>
        <td><?php echo $adoQtyOut ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
             </tr>
             <?php 
			 	}
			 ?>
          <?php 
		  
		  }
		  ?>
  <?php 
  	$prevDate = $CurrDate;
  }
   ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
