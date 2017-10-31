<?php
	session_start();
	include "../Connector.php";
	$invNo=$_GET["invNo"];

	$Type	=$_GET['Type'];//18-04-2011- lasantha - To get the invoice type
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="frmBinAvailability">
<table width="298" border="0">
  <tr>
    <td height="24" colspan="3" bgcolor="#498CC2" class="TitleN2white"><table width="100%" border="0">
      <tr>
        <td width="94%">GRN List</td>
        <td width="6%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="120" colspan="3"><table width="292" height="129" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="100%"><div id="divcons" style="overflow:-moz-scrollbars-vertical; height:120px; width:280px;">
          <table width="259" cellpadding="0" cellspacing="0">
            <tr>
			  <td width="32%" height="22" bgcolor="#498CC2" class="grid_header">INV No</td>
              <td width="32%" height="22" bgcolor="#498CC2" class="grid_header">GRN No</td>
              <td width="25%" bgcolor="#498CC2" class="grid_header">GRN Year </td>
              <td width="43%" height="22" bgcolor="#498CC2" class="grid_header">Report</td>
            </tr>
			
<?php
/*$strSQL= "SELECT
			grnheader.intGrnNo,
			grnheader.intGRNYear
			FROM
			grnheader
			WHERE
			grnheader.strInvoiceNo =  '$invNo'
			";
$result=$db->RunQuery($strSQL);
$count=0;
$cls="";
while($row = mysql_fetch_array($result))
{ 
	$grnNo = $row["intGrnNo"];
	$grnYear = $row["intGRNYear"];
	($count%2==0)?$cls="grid_raw":$cls="grid_raw2";
?>
            <tr class="backcolorGreen">
              <td class="<?php echo $cls;?>"><?php echo $grnNo ?></td>
              <td class="<?php echo $cls;?>"><?php echo $grnYear ?></td>
              <td class="<?php echo $cls;?>" ><a target="_blank"  href=<?php echo "../GRN/Details/grnReport.php?grnno=$grnNo&grnYear=$grnYear" ?>><img src="../images/view.png" alt="Report " name="butReport" border="0" id="butReport"/></a></td>
            </tr>
			
<?php
$count++;
}*/
//18-04-2011-lasantha 
//grn types popups
$grn='GRN';
if ($Type=="S"){
$strSQL= "SELECT
			grnheader.intGrnNo AS GRNNO,
			grnheader.intGRNYear AS GRNYEAR,
			grnheader.strInvoiceNo
			FROM
			grnheader
           WHERE grnheader.strInvoiceNo = '$invNo' ;";
}
else if($Type=="G"){
$strSQL="SELECT
			gengrnheader.strGenGrnNo AS GRNNO,
			gengrnheader.intYear AS GRNYEAR
			FROM gengrnheader 
			WHERE gengrnheader.strInvoiceNo = '$invNo' ;";
}
else if($Type=="B"){
$strSQL="SELECT 
		bulkgrnheader.intBulkGrnNo  AS GRNNO, 
		bulkgrnheader.intYear AS GRNYEAR
		FROM bulkgrnheader 
		WHERE bulkgrnheader.strInvoiceNo = '$invNo' ;";
		$grn='BulkGRN';
}

			//echo $strSQL;
$result=$db->RunQuery($strSQL);
$count=0;
$cls="";
while($row = mysql_fetch_array($result))
{ 
	$grnNo = $row["GRNNO"];
	$grnYear = $row["GRNYEAR"];
	($count%2==0)?$cls="grid_raw":$cls="grid_raw2";
?>
            <tr class="backcolorGreen">
			  <td class="<?php echo $cls;?>"><?php echo $invNo ?></td>
              <td class="<?php echo $cls;?>"><?php echo $grnNo ?></td>
              <td class="<?php echo $cls;?>"><?php echo $grnYear ?></td>
              <td class="<?php echo $cls;?>" ><a target="_blank"  href=<?php echo "../$grn/Details/grnReport.php?grnno=$grnNo&grnYear=$grnYear" ?>><img src="../images/view.png" alt="Report " name="butReport" border="0" id="butReport"/></a></td>
            </tr>
		
<?php
$count++;
}

?>		
          </table>
        </div></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td width="11" bgcolor="#D6E7F5">&nbsp;</td>
    <td width="176" bgcolor="#D6E7F5">&nbsp;</td>
    <td width="97" bgcolor="#D6E7F5"><img src="../images/close.png" alt="Close" width="97" height="24" onclick="closeWindow();"/></td>
  </tr>
</table>
</form>
</body>
</html>
