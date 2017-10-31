
<script language="javascript" type="text/javascript" src="mainPagePanelViewers/planPanel/planDetail.js"></script>
<!--<script type="text/javascript" src="../../issue/issue.js"></script>
<script type="text/javascript" src="../../issue/issue.js"></script>
--><script type="text/javascript">

</script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script>
	$(function() {
		
		$( "#accordion" ).accordion();
		

		
		var availableTags = [
			"ActionScript",
			"AppleScript",
			"Asp",
			"BASIC",
			"C",
			"C++",
			"Clojure",
			"COBOL",
			"ColdFusion",
			"Erlang",
			"Fortran",
			"Groovy",
			"Haskell",
			"Java",
			"JavaScript",
			"Lisp",
			"Perl",
			"PHP",
			"Python",
			"Ruby",
			"Scala",
			"Scheme"
		];
		$( "#autocomplete" ).autocomplete({
			source: availableTags
		});
		

		
		$( "#button" ).button();
		$( "#radioset" ).buttonset();
		

		
		$( "#tabs" ).tabs();
		

		
		$( "#dialog" ).dialog({
			autoOpen: false,
			width: 400,
			buttons: [
				{
					text: "Ok",
					click: function() {
						$( this ).dialog( "close" );
					}
				},
				{
					text: "Cancel",
					click: function() {
						$( this ).dialog( "close" );
					}
				}
			]
		});

		// Link to open the dialog
		$( "#dialog-link" ).click(function( event ) {
			$( "#dialog" ).dialog( "open" );
			event.preventDefault();
		});
		

		
		$( "#datepicker" ).datepicker({
			inline: true
		});
		

		
		$( "#slider" ).slider({
			range: true,
			values: [ 17, 67 ]
		});
		

		
		$( "#progressbar" ).progressbar({
			value: 20
		});
		

		// Hover states on the static widgets
		$( "#dialog-link, #icons li" ).hover(
			function() {
				$( this ).addClass( "ui-state-hover" );
			},
			function() {
				$( this ).removeClass( "ui-state-hover" );
			}
		);
	});
	</script>
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
<link href="../panelCSS.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../css/erpstyle.css"/>
<form id="frm">

<p>Date: <input type="text" id="datepicker1"></p>

 <input type="text" id="datepicker">
<table width="930" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
     	 <td>
              <div id="mainGridHeadDivPD" style="width:913px;height:30px;overflow:scroll;overflow-x:hidden;overflow-y:hidden;">
                <table width="928" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" id="table1PD" style="width:913px;">
                  <tr class="gridHdrTxtPnlMn">
                      <td style="background-color:#FFF;"></td>
                  </tr>
                  <tr bgcolor="#fbbf6f" class="gridHdrTxtPnl" style="width:100%;" >
                    <td width="20%"><!--<input type="checkbox" id="chkAll"  onclick="CheckAll();"/>--> Planing Confirmation</td>
                    <td width="10%"  height="30">Style No</td>
                    <td width="15%" >Order No</td>
                    <td width="20%">Factory</td>
                    <td width="10%">Line No</td>
                    <td width="15%">Date From</td>
                    <td width="15%">Date To</td>
                  </tr>
                </table>
              </div>
     	 </td>
 	 </tr>
	<tr>
 		 <td>
         	<div id="mainGridDataDivPD" style="overflow:scroll; height:450px; width:930px;" onmousedown="scrollGridHead('mainGridHeadDivPD','mainGridDataDivPD');">
                <table  style="width:913px;" border="0" cellpadding="0" cellspacing="1" id="plantbl" bgcolor="#FFFFFF">
                    <thead>
                      <tr class="gridHdrTxtPnlMn">
                          <th width="20%"></th>
                            <th width="10%"></th>
                            <th width="15%" ></th>
                            <th width="20%"></th>
                            <th width="10%"></th>
                            <th width="15%"></th>
                            <th width="15%"></th>
                      </tr>
			        </thead>
                      <tbody>
                      		<?php 
								$sql="SELECT
												orders.strStyle,
												orders.intStyleId,
												orders.strOrderNo,
												orders.intBuyerCon,
												orders.intPlanConfirm,
												orders.dtmOCD_Date,
												orders.dtmPCD_Date,
												companies.strName,
												companies.strComCode
									FROM
												orders
												LEFT JOIN companies ON orders.intManufactureCompanyID = companies.intCompanyID
									WHERE
												orders.intBuyerCon = 1 ORDER BY orders.strStyle";
								$rec=$db->RunQuery($sql);
								$r=0;
								while($rows=mysql_fetch_array($rec)){ ?>
									
			                         <tr class="gridHdrTxtPnlMn" >
                                     <?php if( $rows['intPlanConfirm']==1) { ?>  
                                     	<td width="20%"><input type="checkbox" id="<?php echo $r; //$r++;?>" onclick="Confirm(this);"  disabled="disabled"/></td>
                                       <?php }else {?> 
                                     	 <td width="20%"><input type="checkbox" id="<?php echo $r;// $r++;?>" onclick="Confirm(this);" /></td>
                                       <?php }?> 
                                        <td width="10%" id="<?php echo $rows['intStyleId']; ?>"><?php echo $rows['strStyle']; ?> </td>
                                        <td width="15%"><?php echo $rows['strOrderNo']; ?></td>
                                        <td width="20%"><?php echo $rows['strComCode']; ?></td>
                                        <td width="10%"><select id="comLineNo<?php echo $r; ?>" class="txtbox"  >
                                        	<option value="">select one</option>
                                            <?php 
													$sqlLine="SELECT plan_teams.strTeam,plan_teams.intTeamNo FROM plan_teams WHERE
plan_teams.strTeam LIKE 'LINE%' order by strTeam ASC";
														 $rslt=$db->RunQuery($sqlLine);
														 while($rowLine=mysql_fetch_array($rslt))
														 {
													?>		
															<option value="<?php echo $rowLine['intTeamNo']; ?>" ><?php echo $rowLine['strTeam']; ?></option>
													<?php		 
														 }			
													?>
											</select>
                                        </td>
                                        <td width="15%">	
                                        	<input name="txtFromDate" type="text" class="txtbox" id='txtFromDate<?php echo $r;?>'  value="" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" style="width:80px;" /><input type="reset" value=""  class="txtbox" style="visibility:hidden; width:10px;"   onclick="return showCalendar(this.id, '%Y/%m/%d');">
                     </td>
                                        <td width="15%">
                                        	<input name="txtToDate" type="text" class="txtbox" id='txtToDate<?php echo $r;?>'  value="" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" style="width:80px;" /><input type="reset" value=""  class="txtbox" style="visibility:hidden; width:10px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');">
                                        </td>
                                     </tr>
							<?php
							$r++;
								}
							?>
<!--                          <td style="background-color:#FFF;"></td>
-->     			    
				      </tbody>
		    </table>
	    </div>
  		</td>
  </tr>
  <tr>
  <td>
		<img  align="right" src="images/ok.png" id="btnOK"  onclick="sendConfirm();" />
<!--		<input type="button"  align="right"  id="btnOK"  onclick="sendConfirm();" />
-->  </td>
  </tr>
</table>
</form>