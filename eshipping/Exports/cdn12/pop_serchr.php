
<?php
$backwardseperator = "../../";
session_start();
include("../../Connector.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Packing List Printer</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
        
        
<script type="text/javascript" src="../../js/jquery-1.4.4.min.js"></script>
<link href="../../css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-ui-1.8.9.custom.min.js"></script>

	
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="cdn.js" type="text/javascript"></script>
<script type="text/javascript">




function save_pl_format()
{
		var plno			=('#cboPLnumber').val;
		var pl_report			=('#cboRptFormat').val;
		if(plno=="")
		{
			alert("Please select a Packing List Number.");
			return;
		}
		if(pl_report=="")
		{
			alert("Please select a Packing List Format.");
			return;
		}
		var url				='shipmentpackinglistdb.php?request=save_pl_format&plno='+plno+'&pl_report='+pl_report;
		var xml_http_obj	=$.ajax({url:url,async:false});
		if(xml_http_obj.responseText=='saved')
			alert("Saved successfully.");
		if(xml_http_obj.responseText=='failed')
			alert("Sorry, please try again later.");
	
}

/*
function load_pl_format()

{
	
			var plno			=('#cboPLnumber').val;
			var url				='shipmentpackinglistdb.php?request=load_pl_format&plno='+plno;
			//alert("oi");
			var xml_http_obj	=$.ajax({url:url,async:false});
			$('#cboRptFormat').val(xml_http_obj.responseText);
}

*/


function serch()
{
	var serch_val=document.getElementById('txtpendingCDNInvNo').value;
	alert(serch_val)
	//var plno			=('#cboPLnumber').val;
	//var plno=document.getElementById('cboPLnumber').value;
	//alert(pl_no);
	//var url_format				=('#cboRptFormat').val;
	//var url_format=document.getElementById('cboRptFormat').value;
	//alert(url_format);
	//if(plno=="")
		
	//url		=url_format+ "?plno="+plno;
	//window.open(url,'pl')
	//var url				='shipmentpackinglistdb.php?request=save_pl_format&plno='+plno+'&pl_report='+url_format;
	//var xml_http_obj	=$.ajax({url:url,async:false});
}



</script>
<link href="file:///C|/wamp/www/css/erpstyle.css" rel="stylesheet" type="text/css" />


</head>

<body>

<?php

include "file:///C|/wamp/www/Connector.php";

?>


</head>

<body>
<table width="500" height="150" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE" align="center">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr class="bcgcolor-highlighted">
    <td height="35" colspan="4"  class="normaltxtmidb2L"  bgcolor="#588DE7">&nbsp; Packing List Printer</td>
  </tr>
  <tr>
    <td height="5" colspan="4"></td>
  </tr>
  <tr>
  
  
  
    
    <td  width="952" class="normalfnth2Bm" style="text-align:center"><table width="477" height="88" border="0" align="center">
        <tr>
          <td width="118"><span class="normalfnth2Bm" style="text-align:left">PL Number :</span></td>
          <td width="293"><input name="txtCDNBuyerPO" type="text" maxlength="100" class="txtbox" id="txtpendingCDNInvNo" size="25" style="width:130px" onkeyup="changeCDNPoCombo(this,event);"   onclick="abc_pre();"/></td>
        </tr>
    </table></td>
  </tr>
  
  <tr>
  
    <td class="normalfnth2Bm" style="text-align:center">&nbsp;</td>
  </tr><tr height="5">
  </tr>
  
  
  
  
  <tr align="center">
    <td colspan="3"><img src="../../images/save_small.jpg" alt="save" width="36" height="29" class="mouseover" title="Save report format." onclick="save_pl_format()" />&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../images/go.png" width="44" height="32" alt="go" onclick="serch()" class="mouseover" title="Print"/></td>

  </tr>
</table>
</body>
</html>
