<?php
	session_start();
	include "../Connector.php";
	$invNo=$_GET["invNo"];
	$Type	=$_GET['Type'];
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
        <td width="94%">PO List</td>
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
              <td width="32%" height="22" bgcolor="#498CC2" class="normaltxtmidb2">PO No</td>
              <td width="25%" bgcolor="#498CC2" class="normaltxtmidb2">PO Year </td>
              <td width="43%" height="22" bgcolor="#498CC2" class="normaltxtmidb2">Report</td>
            </tr>
			
<?php
if($Type=="S"){
	$strSQL="SELECT
			grnheader.intPoNo AS PO,
			grnheader.intYear  AS YR
			FROM
			grnheader
			WHERE
			grnheader.strInvoiceNo =  '$invNo';";
}
else if($Type=="G"){
	$strSQL= "SELECT 
			gengrnheader.intGenPoNo AS PO, 
			gengrnheader.intYear AS YR
			FROM gengrnheader 
			WHERE gengrnheader.strInvoiceNo = '$invNo';";
}
else if($Type=="B"){
	$strSQL= "SELECT 
			bulkgrnheader.intBulkPoNo AS PO, 
			bulkgrnheader.intYear AS YR
			FROM bulkgrnheader 
			WHERE bulkgrnheader.strInvoiceNo = '$invNo';";
}

$result=$db->RunQuery($strSQL);
while($row = mysql_fetch_array($result))
{ 
	$intPoNo = $row["PO"];
	$intYear = $row["YR"];
?>
            <tr class="backcolorGreen">
              <td class="normalfntMid"><?php echo $intPoNo ?></td>
              <td class="normalfntMid"><?php echo $intYear ?></td>
              <td class="normalfntMid" ><a target="_blank"  href=<?php echo "../reportpurchase.php?pono=$intPoNo&year=$intYear" ?>><img src="../images/view.png" alt="Report " name="butReport" border="0" id="butReport"/></a></td>
            </tr>
			
<?php
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
