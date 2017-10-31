<?php 
session_start();
include "../../authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Purchase Order Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function winClose(){
	window.opener.location.reload();	
}
</script>
<script language="javascript" src="../../js/jquery-1.4.2.min.js" ></script>

<style type="text/css">
<!--
.style1 {font-size: 10px}
-->
</style>
</head>


<body>

<table width="800" border="0" align="center" cellpadding="0" celspacing="0">
<tr><td colspan="4"><?php //include 'oritgeneralpurcahseorderreport.php';?></td></tr>
  <tr>
    <td colspan="4">
		<table width="100%">
		<tr>
		<td colspan="4"></td>		
		</tr>
			<tr bgcolor="#d6e7f5" align="center">
				<td width="35%" class="normalfntLeftTABNoBorder">&nbsp;</td>
                <?php 
					$poNo=$_GET["bulkPoNo"];
					$year=$_GET["intYear"];
					
					$SQL= " SELECT intStatus FROM generalpurchaseorderheader GH WHERE GH.intGenPONo =  '$poNo' and GH.intYear =  '$year' ";	
					
					$result = $db->RunQuery($SQL);
					$row = mysql_fetch_array($result);
					
					$intStatus=$row["intStatus"];
					
					include "../../HeaderConnector.php";
					include "../../permissionProvider.php";
	
					if($intStatus==0){
						
						if($confirmGeneralPO){
					?>
							
						<td width="15%" class="normalfntLeftTABNoBorder"><img src="../../images/conform.png" class="mouseover" onclick="ConfirmGenPo();" alt="view" /></td>			
					<?php		
						}						
					}
					
					if($intStatus==2){
						if($approveGeneralPo){
					?>
                    	<td width="15%" class="normalfntLeftTABNoBorder"><img src="../../images/approve.png" class="mouseover" onclick="ApproveGenPo();" alt="view" /></td>		
                    <?php		
						}
						
					}
					
					if($intStatus!=1){
					?>
                    	<td width="15%" class="normalfntLeftTABNoBorder"><img src="../../images/reject.png" alt="reject" /></td>
                   <?php 		
					}
				 ?>
                
                
				                
				
				<td width="35%">&nbsp;</td>
                <!--<td colspan="4"><img src="../../images/approve.png" class="mouseover" onclick="ApproveGenPo();" alt="view" /></td>-->
			</tr>
		</table>    
    </td>
  </tr>
</table>
<script type="text/javascript">

function ApproveGenPo(){
	var genpono =<?php echo $_GET["bulkPoNo"];?>;
	var genyear =<?php echo $_GET["intYear"];?>;
	
	var url = 'generalPo-db.php?id=approveBulkPo&intGenPONo=' +genpono+ '&intYear=' +genyear
	var xml_http_obj=$.ajax({url:url,async:false});
	
	var intConfirm = xml_http_obj.responseText;
			if(intConfirm){	
				location="oritgeneralpurcahseorderreport.php?bulkPoNo="+ genpono+"&intYear="+genyear;	
				//window.top.location.reload(true);
				//window.top.location.href = top.location.href;
				window.opener.location.href = window.opener.location;
				//setTimeout("opener.location.reload()",1000);
			}
			else
				alert("Error \nGeneral PO is not approved");
}

function ConfirmGenPo(){
	
	var genpono =<?php echo $_GET["bulkPoNo"];?>;
	var genyear =<?php echo $_GET["intYear"];?>;
	
	var url = 'generalPo-db.php?id=confirmBulkPo&intGenPONo=' +genpono+ '&intYear=' +genyear
	var xml_http_obj=$.ajax({url:url,async:false});
	
	var intConfirm = xml_http_obj.responseText;
			if(intConfirm){	
			location="oritgeneralpurcahseorderreport.php?bulkPoNo="+ genpono+"&intYear="+genyear;	
				//window.opener.location.reload();
				//setTimeout("location.reload(true);",0);*/
				window.opener.location.href = window.opener.location;
				}
			else
				alert("Error \nGeneral PO is not confirmed");
	
}

</script>
</body>
</html>
