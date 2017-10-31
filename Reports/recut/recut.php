<?php 
session_start();
$backwardseperator = "../../";
include "../../Connector.php";
include $backwardseperator."authentication.inc";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro | Recut</title>
<link href="../../css/erpstyle.css" rel="stylesheet"/>
<script language="javascript" src="../../javascript/script.js"></script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td><?php include $backwardseperator.'Header.php';?></td>
  </tr>
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="2" class="bcgl1" align="center">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="4" class="mainHeading" height="25">Recut Summary Report</td>
            </tr>
          <tr>
            <td width="9%">&nbsp;</td>
            <td width="22%">&nbsp;</td>
            <td width="39%">&nbsp;</td>
            <td width="30%">&nbsp;</td>
          </tr>
          <tr class="normalfnt">
            <td height="20">&nbsp;</td>
            <td>Style No</td>
            <td><select name="cboStyleNo" id="cboStyleNo" style="width:200px;">
            <option value="" selected="selected">Select One</option>
             <?php
	
	$SQL = "select distinct strStyle,strStyle from orders where orders.intStatus = 11 order by strStyle;";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	?>
            </select>            </td>
            <td>&nbsp;</td>
          </tr>
          <tr class="normalfnt">
            <td height="20">&nbsp;</td>
            <td>Order No</td>
            <td><select name="cboOrderNo" id="cboOrderNo" style="width:200px;">
             <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select O.intStyleId,O.strOrderNo from orders O where O.intStatus = 11 ";
	if($styleNo!="")
		$SQL .="and O.strStyle='$styleNo' ";
	$SQL .= "order by O.strOrderNo";
		
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
            </select>            </td>
            <td>&nbsp;</td>
          </tr>
           <tr class="normalfnt">
            <td height="20">&nbsp;</td>
            <td>Status</td>
            <td><select name="cboStatus" id="cboStatus" style="width:200px;">
            <option value="" selected>All</option>
                    <option value="0">Pending</option>
					<option  value="1">Send To Approve</option>
					<option  value="2">First Approved</option>
					<option  value="3">Confirmed</option>
			        </select>   
            </select>            </td>
            <td>&nbsp;</td>
          </tr>
           <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
           <tr>
            <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableFooter">
              <tr>
                <td align="center">
                <a href="recut.php"><img src="../../images/new.png" border="0"></a>
                <img src="../../images/report.png" onClick="viewRecutReport();">
                 <a href="../../main.php"><img src="../../images/close.png" border="0"></a>
                </td>
              </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script language="javascript" type="text/javascript">
function viewRecutReport()
{
	var styleNo = URLEncode(document.getElementById('cboStyleNo').value);
	var orderNo = URLEncode(document.getElementById('cboOrderNo').value);
	var status = document.getElementById('cboStatus').value;
	var strOrderNo = $("#cboOrderNo option:selected").text();
	var strStatus = $("#cboStatus option:selected").text();
	
	var url ="recutReport.php?styleNo="+styleNo;
	url += "&orderNo="+orderNo;
	url += "&status="+status;
	url += "&strOrderNo="+URLEncode(strOrderNo);
	url += "&strStatus="+URLEncode(strStatus);
	
	window.open(url,'recutReport.php');
}
</script>
</body>
</html>
