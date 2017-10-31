<link href="../mainPagePanelViewers/panelCSS.css" rel="stylesheet" type="text/css" />
<?php $perMsg = "onclick=\"alert('You don\'t have permission for access this.');\""; ?>

<?php //// this is temp one
//$allowProductionPanel = true;
$allowTnAPanel = true;
$allowProductionPanel=true;
$allowmrnPanel = true;
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
            <td width="100" class="bgMenuPanel" onclick="viewPanel('PLAN');">PLAN</td><!-- ================2014-03-11=======================-->
            <td width="100" class="bgMenuPanel" onclick="viewPanel('Empty');">Empty</td>
            <td width="100" class="bgMenuPanel" onclick="viewPanel('Empty');">Empty</td>
          </tr>
        </table>
    </td>
    </tr>
</table>
</div>