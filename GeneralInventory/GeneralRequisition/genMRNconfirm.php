<?php 
session_start();
//include "../../Connector.php";
/*$matreqno=$_GET["mrnNo"];
$year=$_GET["year"];
$report_companyId  	= $_SESSION["FactoryID"];*/
$backwardseperator = '../../';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>General MRN Confirm</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo $backwardseperator;?>js/jquery-1.4.2.min.js"></script>
<script src="<?php echo $backwardseperator;?>js/jquery-ui-1.8.9.custom.min.js"></script>
<script language="javascript" type="text/javascript">
function confirmMRNDet()
{	
	
	var mrnNo = <?php echo $_GET["mrnNo"]; ?>;
	var mrnYear = <?php echo $_GET["year"]; ?>;
	var url = 'genMRNMiddle.php?RequestType=UpdateStatus&genMRNno='+mrnNo+'&genMRNyear='+mrnYear;
	htmlobj=$.ajax({url:url,async:false});
	
	var res = htmlobj.responseXML.getElementsByTagName("confirmResponse")[0].childNodes[0].nodeValue
	
	if(res == '1')
	{
		alert('Confirmed successfully');
		window.open('genmrnrep.php?mrnNo='+mrnNo+ '&year=' +mrnYear ,'frmMrn');
	}
	else
		return;	
}


</script>
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php include "genmrnrep.php";?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>  
  <tr><td>&nbsp;</td></tr>
  <tr>
    <td><table width="800" border="0" cellspacing="0" cellpadding="0" class="tablezRED">
    	
      <tr>
        <td align="center"><img src="../../images/conform.png" width="115" height="24" onClick="confirmMRNDet()"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
