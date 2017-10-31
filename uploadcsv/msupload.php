<?php
	$backwardseperator = "../";
	include "../Connector.php";
	session_start();
	
$msServer = "SHANKA-PC";
$msUser = "sa"; 
$msPass = "sa";
$msDb = "eplan";

$msCon = mssql_connect($msServer);
$msSelected = mssql_select_db($msDb,$msCon);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Data Transfer From Old Eplan To GaPro Web</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js"></script>
</head>
<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Data Transfer From Old Eplan To GaPro Web</div>
	</div>
	<div class="main_body">
<table class="" align="center" width="600" border="0" cellspacing="1">
      <tr>
        <td width="48%"><form id="frmDataTranfer" name="frmDataTranfer" >
          <table width="590" border="0"  cellspacing="0">
            <tr>
              <td height="7" colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td width="60" >&nbsp;</td>
              <td width="161" class="normalfnt">Order No </td>
              <td width="345" align="left"><select name="cboOrderNo" class="txtbox" id="cboOrderNo" style="width:167px" tabindex="1">
 <?php
	$SQL = "SELECT strOrderNo,strStyleID FROM Orders order by strStyleID;";
	$result =mssql_query($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mssql_fetch_array($result))
	{
		echo "<option value=\"". $row["strStyleID"] ."\">" . cdata($row["strStyleID"]) ."</option>" ;
	}
	
	?>
	 </select></td>
            </tr>
            
            
            
			
            <tr>
              <td >&nbsp;</td>
              <td height="3" colspan="2">&nbsp;<span id="countries_txtHint" style="color:#FF0000"></span></td>
              </tr>
            <tr>
              <td height="21" colspan="3" bgcolor=""><table width="102%" border="0" class="">
                <tr>
                  <td align="center">
                  <img src="../images/new.png" id="butNew" class="mouseover" alt="New" name="New"onclick="ClearForm();" tabindex="11"/>
                 <img src="../images/save.png" class="mouseover" alt="Save" name="Save"  onclick="SaveOrders()" id="butSave" tabindex="7"/>
				 <a id="td_coDelete" href="../main.php"><img src="../images/close.png" alt="Close" name="Close" border="0" id="butClose" tabindex="10"/></a></td>
                </tr>
              </table></td>
            </tr>
          </table>
         </form>        </td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
function ClearForm()
{
	document.frmDataTranfer.reset();
	document.getElementById('cboOrderNo').focus();
}

function SaveOrders()
{
	showPleaseWait();
	var orderNo	= document.getElementById('cboOrderNo').value;	
	if(orderNo=="")
	{
		alert("Please select the 'Order No'.");
		document.getElementById('cboOrderNo').focus();
		hidePleaseWait();
		return;
	}
	var url = "msuploaddb.php?RequestType=Save&OrderNo="+orderNo;
	htmlobj=$.ajax({url:url,async:false});
	alert(htmlobj.responseText);
	hidePleaseWait();
}

function showPleaseWait()
{
	var popupbox = document.createElement("div");
	popupbox.id = "divBackGroundBalck";
	popupbox.style.position = 'absolute';
	popupbox.style.zIndex = 5;
	popupbox.style.left = 0 + 'px';
	popupbox.style.top = 0 + 'px'; 
	popupbox.style.background="#000000"; 
	popupbox.style.width = window.innerWidth + 'px';
	popupbox.style.height = window.innerHeight + 'px';
	popupbox.style.MozOpacity = 0.5;
	popupbox.style.color = "#FFFFFF";
	popupbox.innerHTML = "<div style=\"margin-top:300px\" align=\"center\"><img src=\"../images/load.gif\"/></div>",
	document.body.appendChild(popupbox);
}

function hidePleaseWait()
{
	try
	{
		var box = document.getElementById('divBackGroundBalck');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}
</script>
</div>
</div>
</body>
</html>