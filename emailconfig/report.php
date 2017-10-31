<?php
	session_start();
	$backwardseperator 	= "../";
	include "{$backwardseperator}Connector.php" ;	
	include "{$backwardseperator}authentication.inc";
	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro :: Email Configuration Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.style1 {font-size: 12pt}
.style2 {font-size: 14pt}
-->
</style>
</head>


<body>
<table width="950" border="0" align="center" cellpadding="0">
  <tr>
    <td width="100%" colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%"><?php include "../reportHeader.php";?></td>

              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="5" class="normalfnt2bldBLACKmid">&nbsp;</td>
  </tr>
  <tr>
     <td colspan="5" class="normalfnt2bldBLACKmid">Email Configuration Report</td>
  </tr>
  
  <tr>
    <td colspan="5" style="text-align:center"><table width="100%" border='1' cellpadding="0" cellspacing="0" rules="all">        
		  
	
<?php 
$sql="select intUserId,intPermissionId,strUserEmails from emails ";  
if($userId!="")
	$sql.=" where intUserId='$userId';";
$result = $db->RunQuery($sql);
$rowCount = mysql_num_rows($result);
while($row=mysql_fetch_array($result))
{	
	$userId				= $row["intUserId"];
	$userName			= GetUserName($userId);
	$permissionId		= $row["intPermissionId"];
	$userEmails			= $row["strUserEmails"];

?>

<?php if($preUserId!=$row["intUserId"]){
	$preUserId=$row["intUserId"];
?>
	 <tr bgcolor="#EFEFEF" >
		<td colspan="18" class="normalfnt" style="text-align:center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="10%" class="normalfnt"><b>User Name &nbsp; :</b></td>
			<td width="90%" class="normalfnt"><b><?php echo $userName;?></b></td>
		  </tr>
		</table></td>
		</tr>
<?php
}
?>
		 <tr height="15"  bgcolor="#F8F8F8">	
		<td colspan="2" nowrap="nowrap" class="normalfntRite"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="9%" class="normalfntRite">&nbsp;</td>
            <td width="91%" class="normalfnt">&nbsp;&nbsp;<?php echo GetPermission($permissionId);?>&nbsp;</td>
          </tr>
        </table></tr>

		   <?php
		   	$loop = 0;
			$privil=explode(",",$userEmails);
			$arrayCount=sizeof($privil);
			$PrivilageLength=strlen($privilageList);
				foreach($privil AS $values)
				{
					$emailAccount = GetEmailAccount($values);
					if($emailAccount!=""){
			?>
								 <tr  onmouseover="this.style.background ='#F5F9FA';" onmouseout="this.style.background=''" height="20">
		   <td width="13%" nowrap="nowrap" class="normalfntRite"><?php echo ++$loop;?>&nbsp;</td>
		   <td width="87%" nowrap="nowrap" class="fntwithWite">&nbsp;&nbsp;<?php echo $emailAccount;?></td>
 			<?php
					echo "</tr>";
				}
			}
		   ?>
	    </tr>
		<tr height="1">
		<td colspan="2" nowrap="nowrap" class="normalfntRite">&nbsp;</td>
		</tr>
<?php
}
?> 
    </table></td>
  </tr>
  </table>
<?php
function GetUserName($userId)
{
global $db;
	$qty = 0;
	$sql="select UserName from useraccounts where intUserID='$userId';";	
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		return  $row["UserName"];
	}	
}

function GetPermission($permissionId)
{
global $db;
	$sql="select strDescription from emailconfig where intSerialId='$permissionId';";	
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		return  $row["strDescription"];
	}	
}
function GetEmailAccount($userId)
{
	global $db;
	$sql="select UserName from useraccounts where intUserID='$userId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$emalAccount = $row["UserName"];
	}
	return $emalAccount;
}
?>

<script type="text/javascript">
function closeWindow(){
window.close();
}
var rowCount =<?php echo $rowCount?>;
if(rowCount<=0){
	alert("Sorry!\nNo Records found in selected options.")
	window.close();
}
</script>
</body>
</html>
