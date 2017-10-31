<?php 
session_start();
$backwardseperator 	= "../../";
include "../../authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Purchase Order Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script type="text/javascript" >
var xmlHttp;
var no = '<?php echo $_GET["serialNo"]; ?>';
var year = '<?php echo $_GET["serialYear"]; ?>';

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

function ConfirmExGrn()
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = handleConfirm;
	xmlHttp.open("GET", '../Details/db.php?id=ConfirmExGrn&grnNo='+no + '&grnYear=' + year, true);	
	xmlHttp.send(null); 
}
function handleConfirm()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var state=xmlHttp.responseText;
			//alert(state);
			if(parseInt(state)=="1")
			{				
				location = "exreportpurchase.php?serialNo="+ no + "&serialYear=" + year;
			}
			else
			{
				location = "expoconfirmationreport.php?serialNo="+ no + "&serialYear=" + year;
			}
		}
	}
	
}

function deductQtyFromMatRatio(){
var tblMain = document.getElementById("tblMain");
var rowCount = tblMain.rows.length;

for(var a=1;a<=rowCount-2;a++){

	var buyerPONO = tblMain.rows[a].cells[0].lastChild.nodeValue;
	var matId = tblMain.rows[a].cells[1].id;
	var styleId	 = tblMain.rows[a].cells[2].id;
	var size	 = tblMain.rows[a].cells[3].lastChild.nodeValue;
	var color	 = tblMain.rows[a].cells[4].lastChild.nodeValue;
	var exQty	 = tblMain.rows[a].cells[7].childNodes[0].lastChild.nodeValue;

	var path = "../Details/db.php?id=deductQtyFromMatRatio";
	    path += "&buyerPONO="+URLEncode(buyerPONO);
	    path += "&matId="+matId;
		path += "&styleId="+styleId;
		path += "&size="+size;
	    path += "&color="+color;
		path += "&exQty="+exQty;
		path += "&grnNo="+no;
		path += "&grnYear="+year;
	htmlobj2=$.ajax({url:path,async:false});
	
/*			var state=htmlobj2.responseText;
			//alert(state);
			if(parseInt(state)=="1")
			{				
				location = "exreportpurchase.php?serialNo="+ no + "&serialYear=" + year;
			}
			else
			{
				location = "expoconfirmationreport.php?serialNo="+ no + "&serialYear=" + year;
			}*/
}

}

</script>
<style type="text/css">
<!--
.style1 {font-size: 10px}
-->
</style>
</head>


<body>

<table width="800" border="0" align="center" cellpadding="0" celspacing="0">
  <tr>
    <td colspan="4">
		<table width="100%">
		<tr>
		<td colspan="3"> <?php include "exreportpurchaseExceedBomQty.php" ?></td>		
		</tr>
		<?PHP if($poStatus==2){ ?>
			<tr bgcolor="#d6e7f5">
				<td class="normalfntLeftTABNoBorder" style="visibility:hidden"><input type="radio" checked id="normalreport" name="report"> Normal Report</td>
				<td class="normalfntLeftTABNoBorder" style="visibility:hidden"><input type="radio" id="otherreport" name="report"> Other Report</td>
				<td><div align="right"><img src="../../images/approve.png" class="mouseover" onclick="ConfirmExGrn();" alt="view" /></div></td>
			</tr>
			<?php } ?>
		</table>    
    </td>
  </tr>
</table>

</body>
</html>
