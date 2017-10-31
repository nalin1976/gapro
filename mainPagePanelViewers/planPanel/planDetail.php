<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link href="../panelCSS.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../css/erpstyle.css"/>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<link href="css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
<link href="css/calander.css"  />
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
    <script language="javascript" type="text/javascript" src="planDetail.js"></script>
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
		

		$('.txtbox').each(function(){
		//$( "#datepicker,#datepicker1").datepicker()
		$(this).datepicker({
			dateFormat: 'yy-mm-dd'})
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
	
	//function Confirm(Ids){
	//alert("ugys");}
</script>
<style>
head{
font: 62.5% "Trebuchet MS", sans-serif;
margin: 50px;
}
.demoHeaders {
margin-top: 2em;
}
#dialog-link {
padding: .4em 1em .4em 20px;
text-decoration: none;
position: relative;
}
#dialog-link span.ui-icon {
margin: 0 5px 0 0;
position: absolute;
left: .2em;
top: 50%;
margin-top: -8px;
}
#icons {
margin: 0;
padding: 0;
}
#icons li {
margin: 2px;
position: relative;
padding: 4px 0;
cursor: pointer;
float: left;
list-style: none;
}
#icons span.ui-icon {
float: left;
margin: 0 4px;
}
.fakewindowcontain .ui-widget-overlay {
position: absolute;
}
</style>

</head>   
<form id="frm">
<table width="1090" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
     	 <td >
              <div id="mainGridHeadDivPD"  align=""style="width:1125px;height:30px;overflow:scroll;overflow-x:hidden;overflow-y:hidden;">
                <table width="1100" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" id="table1PD" style="width:1100px;">
                  <tr class="gridHdrTxtPnlMn">
                      <td style="background-color:#FFF;"></td>
                  </tr>
                  <tr bgcolor="#fbbf6f" class="gridHdrTxtPnl" style="width:100%;" >
                    <td width="8%"><!--<input type="checkbox" id="chkAll"  onclick="CheckAll();"/>--> Planing Con</td>
                    <td width="10%"  height="30">Style No</td>
                    <td width="6%" >SC No</td>
                    <td width="7%">BPO No</td>
                    <td width="6%">PRV BPO</td>
                    <td width="6%">Qty</td>
                    <td width="20%">Factory</td>
                    <td width="8%">PCD Date</td>
                     <td width="8%">HandOver Date</td>
                    <td width="8%">Estimated Date</td>
                    <td width="8%">DateofDelivery</td>
                    
                 </tr>
                </table>
              </div>
     	 </td>
 	 </tr>
	<tr>
 		 <td>
         	<div id="mainGridDataDivPD" style="overflow:scroll; height:450px; width:1125px;" align="" onmousedown="scrollGridHead('mainGridHeadDivPD','mainGridDataDivPD');">
         	  <table  style="width:1100px;" border="1" cellpadding="0" cellspacing="0" id="plantbl" bgcolor="#FFFFFF" bordercolor="#FFFF99">
         	  <tbody>
         	    <tr class="normalfnt" >
         	      <td width="22%"><table  style="width:1100px;" border="1" cellpadding="0" cellspacing="0" id="plantbl2" bgcolor="#FFFFFF" bordercolor="#FFFF99">
         	        <thead>
         	          <tr class="gridHdrTxtPnlMn">
         	            <th width="8%"></th>
         	            <th width="11%"></th>
         	            <th width="6%" ></th>
         	            <th width="8%"></th>
                         <th width="6%"></th>
         	            <th width="7%"></th>
         	            <th width="20%"></th>
         	            <th width="9%"></th>
         	            <td width="8%"></td>
         	            <td width="8%"></td>
         	            <td width="9%"></td>
       	            </tr>
       	          </thead>
         	        <tbody>
         	          <?php 
								$sql="SELECT
specification.intSRNO,
orders.strStyle,
orders.intStyleId,
deliveryschedule.intPlanConfirm,
deliveryschedule.dtmPCDDate,
deliveryschedule.dtmHandOverDate,
deliveryschedule.estimatedDate,
date(deliveryschedule.dtDateofDelivery) as dtDateofDelivery,
companies.strName,
deliveryschedule.intBPO,
deliveryschedule.prvBPO,
deliveryschedule.dblQty,
shipmentmode.strDescription,
useraccounts.`Name`
FROM
deliveryschedule
INNER JOIN specification ON deliveryschedule.intStyleId = specification.intStyleId
INNER JOIN orders ON deliveryschedule.intStyleId = orders.intStyleId
LEFT JOIN companies ON deliveryschedule.intManufacturingLocation = companies.intCompanyID
INNER JOIN shipmentmode ON deliveryschedule.strShippingMode = shipmentmode.intShipmentModeId
INNER JOIN useraccounts ON deliveryschedule.intUserId = useraccounts.intUserID
WHERE
deliveryschedule.intPlanConfirm = 0";
								$rec=$db->RunQuery($sql);
								$r=0;
								while($rows=mysql_fetch_array($rec)){ ?>
         	          <tr class="normalfnt" >
         	            <td width="8%" align="center"><?php if( $rows['intPlanConfirm']==1) { ?>
         	              <input type="checkbox" id="<?php echo $r; //$r++;?>"   checked="checked"/>
         	              <?php }else {?>
         	              <input type="checkbox" id="<?php echo $r;// $r++;?>"  />
         	              <?php }?></td>
         	            <td width="11%" id="<?php echo $rows['intStyleId']; ?>" style="text-align:justify"><?php echo $rows['strStyle']; ?></td>
         	            <td width="6%"><?php echo $rows['intSRNO']; ?></td>
         	            <td width="8%"><?php echo $rows['intBPO']; ?></td>
         	            <td width="6%"><?php echo $rows['prvBPO']; ?></td>
         	            <?php 

											if($rows['dtmPCDDate']=="" || $rows['dtmPCDDate']=="0000-00-00"){
												$PCDDate=date("Y-m-d");
											}else{ $PCDDate=$rows['dtmPCDDate']; }
											
											
										?>
         	            <td width="7%"><?php echo $rows['dblQty']; ?></td>
         	            <td width="20%"><?php echo $rows['strName']; ?></td>
         	            <td width="9%"><input name="pcdDate" type="text" class="txtbox" id='pcdDate<?php echo $r;?>'  value="<?php echo $PCDDate;?>"  style="width:80px;" onchange=" MatchFromdateAndTodate(this.id);" /></td>
         	            <td width="8%"><input name="dtmHandOverDate" type="text" class="txtbox" id='dtmHandOverDate<?php echo $r;?>'  value="<?php echo $rows['dtmHandOverDate'];?>"  style="width:80px;" onchange=" MatchFromdateAndTodate(this.id);" /></td>
         	            <td width="8%"><input name="estimatedDate" type="text" class="txtbox" id='estimatedDate<?php echo $r;?>'  value="<?php echo $rows['estimatedDate'];?>"  style="width:80px;" onchange=" MatchFromdateAndTodate(this.id);" /></td>
         	            <td width="9%"><input name="dtDateofDelivery" type="text" class="txtbox" id='dtDateofDelivery<?php echo $r;?>'  value="<?php echo $rows['dtDateofDelivery'];?>"  style="width:80px;" onchange=" MatchFromdateAndTodate(this.id);" /></td>
       	            </tr>
         	          <?php
							$r++;
								}
								
								$sql="SELECT
orderbook.intStyleId,
orderbook.strOrderNo,
orderbook.strStyleNo,
date(orderbook.dtmIHDate)as dtmIHDate ,
date(orderbook.dtmDeliveryDate) as dtmDeliveryDate,
date(orderbook.dtmCutDate) as dtmCutDate,
date(orderbook.dtmBuyerOCD) as dtmBuyerOCD,
companies.strComCode
FROM
orderbook
INNER JOIN companies ON companies.intCompanyID = orderbook.intCompanyId
WHERE
orderbook.intStatus = 2";
								$rec=$db->RunQuery($sql);
								
								while($rows=mysql_fetch_array($rec)){ ?>
         	          <tr class="normalfnt" >
         	            <td width="8%" align="center"><?php //if( $rows['intPlanConfirm']==1) { ?>
         	              <!--                                     	<input type="checkbox" id="<?php //echo $r; //$r++;?>" onclick="Confirm(this);"  checked="checked"/>
-->
         	              <?php //}else {?>
         	              <input type="checkbox" id="<?php echo $r;// $r++;?>" onclick="Confirm(this);" />
         	              <?php //}?></td>
         	            <td width="11%" id="<?php echo $rows['intStyleId']; ?>" style="text-align:justify"><?php echo $rows['strStyle']; ?></td>
         	            <td width="6%"><?php echo $rows['intSRNO']; ?></td>
         	            <td width="8%"><?php echo $rows['intBPO']; ?></td>
         	            <td width="6%"><?php echo $rows['prvBPO']; ?></td>
         	            <?php 
											if($rows['dtmFromDate']=="" || $rows['dtmFromDate']=="0000-00-00"){
												$fromDate=date("Y-m-d");
											}else{ $fromDate=$rows['dtmFromDate']; }
											
											if($rows['dtmToDate']=="" || $rows['dtmToDate']=="0000-00-00"){
												$toDate="";
											}else{ $toDate=$rows['dtmToDate']; }
										?>
                        <td width="7%"><?php echo $rows['dblQty']; ?></td>
         	            <td width="20%"><?php echo $rows['strName']; ?></td>
         	            <td width="9%"><input name="pcdDate<?php echo $r;?>" type="text" class="txtbox" id='pcdDate<?php echo $r;?>'  value="<?php echo $PCDDate;?>"  style="width:80px;" onchange=" MatchFromdateAndTodate(this.id);" /></td>
         	            <td width="8%"><input name="dtmHandOverDate" type="text" class="txtbox" id='dtmHandOverDate<?php echo $r;?>'  value="<?php echo $rows['dtmHandOverDate'];?>"  style="width:80px;" onchange=" MatchFromdateAndTodate(this.id);" /></td>
         	            <td width="8%"><input name="estimatedDate" type="text" class="txtbox" id='estimatedDate<?php echo $r;?>'  value="<?php echo $rows['estimatedDate'];?>"  style="width:80px;" onchange=" MatchFromdateAndTodate(this.id);" /></td>
         	            <td width="9%"><input name="dtDateofDelivery" type="text" class="txtbox" id='dtDateofDelivery<?php echo $r;?>'  value="<?php echo $rows['dtDateofDelivery'];?>"  style="width:80px;" onchange=" MatchFromdateAndTodate(this.id);" /></td>
       	            </tr>
         	          <?php
							$r++;
								}
							?>
         	          <!--                          <td style="background-color:#FFF;"></td>
-->
       	          </tbody>
       	        </table></td>
       	      </tr>
       	    </tbody>
         	  </table>
       	   </div>
  		</td>
  </tr>
  <tr>
  <td>
		<img  align="right" src="images/conform.png" id="btnOK"  onclick="sendPlConfirm();" />
<!--		<input type="button"  align="right"  id="btnOK"  onclick="sendConfirm();" />
-->  </td>
  </tr>
</table>
</form>
</html>