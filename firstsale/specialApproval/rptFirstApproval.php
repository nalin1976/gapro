<?php
session_start();
include "authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro -  Order Contract First Approval Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<script src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript">

function ConfirmFirstApproval(styleId,invoiceId)
{	
	var ApprovalRemarks =document.getElementById("txtApprovalRemarks").value.trim();
	var url  = "../costworksheet/costworksheetXml.php?id=URLConfirmFirstApproval";
		url += "&styleId="+styleId;
		url += "&invoiceId="+invoiceId;
		url += "&ApprovalRemarks="+URLEncode(ApprovalRemarks);
	var htmlobj = $.ajax({url:url,async:false});
	if(htmlobj.responseText=='true'){
		alert("Order Contract First Approval updated successfully.This Order Contract send for Second Approval.");
		window.opener.location.reload();
		location = '../costworksheet/orderContractRpt.php?styleID='+styleId+'&invoiceID='+invoiceId,'orderContractRpt.php';
		
	}
	else{
		alert("Sorry!\nError occur while current process is running. Please click 'Approve' button again.");
	}
}

/*function RejectPR(no)
{
	if(document.getElementById('txtApprovalRemarks').value.trim()=="")
	{
		alert("Please enter reason for reject this PR.");
		document.getElementById('txtApprovalRemarks').focus();
		return;
	}
	if(!confirm("Are you sure you want to reject this PR ?"))
		return;
	var url  = "purchaserequisitiondb.php?RequestType=URLRejectPR";
		url += "&SerialNo="+no;
		url += "&ApprovalRemarks="+URLEncode(document.getElementById('txtApprovalRemarks').value.trim());
	var htmlobj=$.ajax({url:url,async:false});
	if(htmlobj.responseText=='true'){
		alert("Rejected successfully.");
		window.opener.location.reload();
		newwindow=window.open('rptPR.php?No='+no,'rptPR.php');
	}
	else{
		alert("Sorry!\nError occur while current process is running. Please click 'Reject' button again.");
	}
}
*/</script>
<body>
<table width="800" align="center">
  <tr>
    <td>
	<?php
		include '../costworksheet/orderContractRpt.php';		
	?>
	</td>
  </tr>
   <tr>
    <td> 
	</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0">
      <tr>
        <td width="60%">&nbsp;</td>
        <td width="40%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="800px" align="center" border="0" cellpadding="0" cellspacing="0" >
      <tr>
        <td colspan="4" class="head1">Approve/Reject Status </td>
        </tr>
      <tr>
        <td width="140" valign="top" class="normalfnt">Remarks</td>
        <td colspan="3"><textarea name="textfield" cols="75" id="txtApprovalRemarks" ></textarea><br>&nbsp;</td>
      </tr>
      <tr >
        <td colspan="4" align="center">
       	<img src="../../images/approve.png" onclick="ConfirmFirstApproval('<?php echo $styleID;?>','<?php echo $invoiceId;?>');" alt="view" /></div>
        <img src="../../images/reject.png" onclick="RejectPR('<?php echo $_GET["No"];?>');" alt="view" style="display:none"/></div>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
