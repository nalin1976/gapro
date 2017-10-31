<link href="../mainPagePanelViewers/panelCSS.css" rel="stylesheet" type="text/css" />
<?php $perMsg = "onclick=\"alert('You don\'t have permission for access this.');\""; ?>

<?php //// this is temp one
//$allowProductionPanel = true;
$allowTnAPanel = true;
$allowProductionPanel=true;
$allowmrnPanel = true;


$allowplanPanel                         = false;

$sql = "select role.RoleName from useraccounts, role, userpermission where useraccounts.intUserID =" . $_SESSION["UserID"] . " and role.RoleID = userpermission.RoleID and userpermission.intUserID = useraccounts.intUserID and intStatus=1 ";

//global $db;

//$result = $db->RunQuery($sql);
$result = $dbheader->RunQuery($sql);
	
while($row = mysql_fetch_array($result))
{
	if ($row["RoleName"] == "Planing Confirmation for DelSchedule")
	{
		$allowplanPanel = true;
	}
}
		
?>
<div class="panelMenuDiv" id="panelMenuDiv">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
        <table height="23" border="0" cellpadding="0" cellspacing="0" class="panelMenuFnt">
          <tr>
          
            <td width="100" class="bgMenuPanel" <?php if($allowProductionPanel){?> onclick="viewPanel('Production');" <?php }else{ echo $perMsg;}?>>Production</td> 
            <td width="100" class="bgMenuPanel" <?php if($allowTnAPanel){?> onclick="viewPanel('TNA');" <?php }else{ echo $perMsg;}?>> T&A </td>
          
            <td width="100" class="bgMenuPanel" <?php if($allowmrnPanel){?>  onclick="viewPanel('MRN');" <?php }else{ echo $perMsg;}?>> MRN</td>
             <td width="100" class="bgMenuPanel" <?php if($allowplanPanel){?>  onclick="viewPanel('PLAN');" <?php }else{ echo $perMsg;}?>> PLAN</td>
           <!-- <td width="100" class="bgMenuPanel" onclick="viewPanel('PLAN');">PLAN</td> ================2017-09-12=======================-->
            <!--<td width="100" class="bgMenuPanel" <?php // if($allowmrnPanel){?>  onclick="viewPanel('GOP');" <?php // }else{ echo $perMsg;}?>>GPO List</td>-->
            <td width="100" class="bgMenuPanel"  onclick="viewPanel('SOReport');">Open Orders</td>
            <td width="100" class="bgMenuPanel" onclick="viewPanel('Empty');">Empty</td>
          </tr>
        </table>
    </td>
    </tr>
</table>
</div>