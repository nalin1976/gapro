<div class="mainPanelDiv" id="mainPanelDiv">
<table width="950" height="550" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="mainPanelTable">
    	<div class="subPanelDiv" id="subPanel0">
   		<!--<table align="center"><tr><td align="center">-->
     <!--   <img src="images/imgTeam.png" width="256" height="49" />-->
        <?php include "mainPagePanelViewers/mrnPanel/mrnDetail.php";?>
    	<!--</td></tr></table>-->
        </div>
        
        <div class="subPanelDiv" id="subPanel4">
        <?php include "mainPagePanelViewers/OSOPanel/openSalesOrderDetail.php";?>
        </div>
        
        
		<div class="subPanelDiv" id="subPanel1">
    		<?php include "mainPagePanelViewers/sewingProduction/sewingProduction.php";?>
    	</div>
            
    	<div class="subPanelDiv" id="subPanel2">
    		<?php include "mainPagePanelViewers/eventSchedule/eventSchedule.php";?>
    	</div>
<!-- ===========2014-03-11===============================================================  --> 
    	<div class="subPanelDiv" id="subPanel3">
    		<?php include "planPanel/planDetail.php";?>
    	</div>
<!--end ===========2014-03-11===============================================================  --> 
    
    </td>
    </tr>
  <tr>
    <td height="15" align="center"><img src="images/btPanelUp.png" width="80" height="15" border="0" class="mouseover" onclick="closePanel();"/></td>
  </tr>
</table>

</div>