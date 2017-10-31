<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<table width="850" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border="0" align="center" cellspacing="0">
    <tr><td colspan="3"><?php include 'grnReport.php'; ?>
    
    </td></tr>
	<?php if($grnStatus==0) { ?>
      <tr bgcolor="#D6E7F5">
        <td width="40%">&nbsp;</td>
        <td width="20%" class="normalfntMid"><img src="../../images/conform.png" alt="conform" name="butConform" width="115" height="24" class="mouseover" id="butConform" onClick="conform(<?php echo $_GET["grnno"]; ?>,<?php echo $_GET["grnYear"]; ?>,<?php echo $Autocom; ?>,<?php echo $MainStoreCompanyID.','.$SubStoreID.','.$intYear.','.$intPONo; ?>);" /></td>
        
        <td width="40%">&nbsp;</td>
      </tr>
	  <?php } ?>
    </table></td>
  </tr>
</table>