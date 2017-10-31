<?php
session_start();
include "authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Pre Order Cost : : Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
var currentStyleNo 	= '<?php echo $_GET["styleID"];?>';
var permission 		= '<?php echo $_GET["Permission"];?>';
</script>
<script type="text/javascript" src="javascript/reviseorder.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<script type="text/javascript">

var shouldHaveReason = '<?php

$xml = simplexml_load_file('config.xml');
$reasonMust = $xml->PreOrder->ShouldProvideReviceReason;
echo $reasonMust;

?>';

function ValidateRevision(obj,approveNo)
{
	if (document.getElementById('txtRemarks').value == "" || document.getElementById('txtRemarks').value == null)
	{
		alert("You can't proceed with order revision. You should provide revise reason.");
		document.getElementById('txtRemarks').focus();
	}
	else if(maxApproveNo<='0')
	{
		alert("Max approval no not set in the system. Please contact system administrator to set 'Max Approval No'");
		return;
	}
	else
	{
		if((parseInt(approveNo)>parseInt(maxApproveNo)) && (permission!='1'))
		{
			alert("You don't have permission to revise this cost sheet because the approval no get exceed the control level.Max approval no is "+ maxApproveNo+" . If you want to revise this cost sheet Please get approval from high authorised permission.");
		}
		else
		{
			ConfirmReviceOrder(obj);
		}
	}	
}
</script>
</head>
<body>
<table width="800" align="center">
  <tr>
    <td>
	<?php 
	
	$reportname = $xml->PreOrder->ReportName;
	include $reportname;
	$maxApproveNo = GetMaxApproveNo($_GET["styleID"]);
	?>    
    </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="4" class="normalfnt"></td>
        </tr>
      <tr>
        <td width="140" valign="middle" class="normalfnt"><span class="compulsoryRed">Revise Reason</span></td>
        <td colspan="3"><textarea name="textfield" cols="75" id="txtRemarks"></textarea></td>
      </tr>
      <tr bgcolor="#D6E7F5">
        <td>&nbsp;</td>
        <td width="212"><div align="right"><img id="<?php echo $strStyleID;?>" src="images/conform_rev.png" class="mouseover" alt="Confirm" width="161" height="24" onclick="ValidateRevision(this,<?php echo $maxApproveNo?>);" /></div></td>
        <td width="175"><div align="center"><a href="ReviseOrder.php"></a></div></td>
        <td width="265">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript">
var maxApproveNo = '<?php echo GetMaxApprovalNoFromSetting();?>';
</script>
<?php
function GetMaxApproveNo($styleId)
{
global $db;
$maxApproveNo	= 0;
	$sql="select COALESCE(intApprovalNo,0)as intApprovalNo from orders where intStyleId='$styleId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$maxApproveNo	= $row["intApprovalNo"];
	}
return $maxApproveNo;
}

function GetMaxApprovalNoFromSetting()
{
global $db;
$no = 0;
	$sql="select strValue from settings where strKey='SetMaxOrderApprovalNo'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$no	= $row["strValue"];
	}
return $no;
}
?>