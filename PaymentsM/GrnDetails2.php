<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
	$poYear=$_GET['poYear'];
	$poNo=$_GET['poNo'];
	echo $type=$_GET['type'];
	$advance=$_GET['advance'];
	$balance=$_GET['balance'];
	$paymentNo=$_GET['paymentNo'];
	
	$CompanyID = $_SESSION["CompanyID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
.main_bottom_center2 {
	width:auto; height:auto;
	position : absolute; 
	top : 1px; left:-55px;
	background-color:#FFFFFF;
	border:1px solid;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	border-bottom-color:#550000;
	border-top-color:#550000;
	border-left-color:#550000;
	background-color:#FFFFFF;
	border-right-color:#550000;
	padding-right:15px;
	padding-top:20px;
	padding-bottom:15px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	border-bottom:10px solid #550000;
}

.main_top2 {
	-moz-border-radius-topright:10px;
	-moz-border-radius-topleft:10px;
	background-color:#550000;
	position : absolute; top : -10px; left:-1px; width:100%; height:24px;
	border:1px solid;
	border-bottom-color:#550000;
	border-top-color:#550000;
	border-left-color:#550000;
	border-right-color:#550000;
	cursor:move;
}
</style>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GRN Details</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="mootools/SexyAlertBox/sexyalertbox.css" type="text/css" media="all" />
<script src="../javascript/script.js" type="text/javascript"></script>
<script  src="../js/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="../javascript/table_script.js" type="text/javascript"></script>
<script src="grnDetails2GlAcc.js" type="text/javascript"></script>
<script src="advance_Payment_Settelment.js" type="text/javascript"></script>


</head>
<body>

<div class="main_bottom_center2">
	<div class="main_top2" onmousedown="grab(document.getElementById('fmGrnDetails'),event);" >
		<div class="main_text">GRN Details<span class="vol"></span><span id="grnDet_popup_close_button"></span></div>
	</div>
	
		<form method="post" name="fmGrnDetails" id="fmGrnDetails">
		<table width="600">
			<tr >
				<td width="33"><input type="hidden" id="paymentNo" value="<?php echo $paymentNo;?>"/></td>
				<td width="69" class="normalfnt">Select All</td>
			  <td width="411" align="left"><input type="checkbox" class="txtbox" id="chkAll" onclick="selectAllChk(this);" ></td>
				<td width="67"><input type="hidden" id="CompanyID" name="CompanyID" value="<?php echo $CompanyID;?>"/></td>
				<td>				<input name="btnshowgl" type="button" style="background-color:#fdeec0;vertical-align:top;" id="btnshowgl" value="Show all GLS" onclick="ShowAllGLAccounts();"/></td>
			</tr>
			<tr>
			<td><input type="hidden" id="txtPoNo" value="<?php echo $poNo;?>"/><input type="hidden" id="txtPoYear" value="<?php echo $poYear;?>"/></td>
			</tr>
		</table>
		<br />
		<div style="width:600px;" class="grid_topic_style">GRN</div>
		<div id="divcons2" style="overflow:scroll; height:250px; width:600px;" class="tableBorder">
			<table width="582" cellspacing="1" id="tblGrnMain" class="table_grid_style">
				<thead>
					<tr>
						<td class="grid_header">&nbsp;</td>
						<td class="grid_header">GRN No</td>
						<td class="grid_header">Description</td>
						<td class="grid_header">Qty</td>
						<td class="grid_header">Rate</td>
						<td class="grid_header">Value</td>
						<!--<td class="grid_header">MatID</td>
						<td class="grid_header">Ma</td>-->
						<td class="grid_header">Pay</td>
						<td class="grid_header">Balance</td>
					</tr>
				</thead>
				
				<tbody>
					<?php
				$strSQL="
								SELECT DISTINCT
						concat(grndetails.intGRNYear,'/',grndetails.intGrnNo) AS GRNNO,
						matitemlist.strItemDescription,
						matitemlist.intItemSerial,
						grndetails.dblQty,
						grndetails.dblExcessQty,
						grndetails.dblPoPrice,
						(grndetails.dblPoPrice*grndetails.dblQty) AS VAL,
						(grndetails.dblPaymentPrice*grndetails.dblQty) AS PayVal,
						grndetails.dblValueBalance,
						grndetails.dblAdvBalAmt,
						grndetails.dblAdvPayAmt,
						advancepaymentpos.dblpaidAmount,
						grndetails.intStyleId
						from grndetails inner join matitemlist on matitemlist.intItemSerial = grndetails.intMatDetailID inner join grnheader on grnheader.intGrnNo = grndetails.intGrnNo Inner Join advancepaymentpos ON advancepaymentpos.intPOno = grnheader.intPoNo
						where grnheader.intPoNo='$poNo' AND intYear = '$poYear' 
						GROUP BY
						grndetails.intStyleId";
						
					//	echo $strSQL;
						
				$result=$db->RunQuery($strSQL);
				
				$count=0;
				$cls="";
				while($row=mysql_fetch_array($result)){
				$dblAdvBalAmt = $row['dblAdvBalAmt'];
				$dblAdvBalAmtId = $row['dblAdvBalAmt'];
				if($dblAdvBalAmt == 0){
				 $dblAdvBalAmt = number_format((($row['dblQty']-$row['dblExcessQty'])*$row['dblPoPrice']-$row['dblAdvPayAmt']),2,".","");
				 $dblAdvBalAmtId = number_format((($row['dblQty']-$row['dblExcessQty'])*$row['dblPoPrice']-$row['dblAdvPayAmt']),2,".","");
				}
				$disabled ="";
				if($dblAdvBalAmtId == 0){
				 $disabled = "disabled='disabled'";
				}
				($count%2==0)?$cls="grid_raw":$cls="grid_raw2";?>
				<tr>
					<td class="<?php echo $cls;?>"><input type="checkbox" onclick="setPayAmt(<?php echo $count+1?>);setGrnValue();" <?php echo $disabled?>/></td>
					<td class="<?php echo $cls;?>" id="<?php echo $row['intStyleId'];?>"><?php echo $row['GRNNO'];?></td>
					<td class="<?php echo $cls;?>" id="<?php echo $row['intItemSerial'];?>"><?php echo $row['strItemDescription'];?></td>
					<td class="<?php echo $cls;?>" style="text-align:right;"><?php echo ($row['dblQty']-$row['dblExcessQty']);?></td>
					<td class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblPoPrice'];?></td>
					<td class="<?php echo $cls;?>"><?php echo number_format((($row['dblQty']-$row['dblExcessQty'])*$row['dblPoPrice']),2,".","");?></td>
					<!--<td class="grid_header">MatID</td>
					<td class="grid_header"><?php #echo $result[1][0];?></td>-->
					<td class="<?php echo $cls;?>" style="text-align:center;"><input type="text" style="width:80px;text-align:right; " onkeypress="return CheckforValidDecimal(this.value,1,event);" onkeyup="setBalance(this),setGrnValue();"  <?php echo $disabled?>//></td>
					<td class="<?php echo $cls;?>" id="<?php echo $dblAdvBalAmtId;?>"><?php echo $dblAdvBalAmt;?></td>
				</tr>
				<?php $count++;}	?>
				</tbody>
			</table>
		</div>
		<br />
		 
		 <div style="font-size:15px;color:#550000">GL Allocation</div>
		 <div id="divcons" style="overflow:scroll; height:100px; width:600px;" class="tableBorder">
			<table cellpadding="0" border="0" cellspacing="0" id="tblglaccounts" width="100%">
			  <tr>
				<td height="22" class="grid_header">*</td>
				<td  class="grid_header">GL Acc Id</td>
				<td  class="grid_header">Description</td>
				<td  class="grid_header">Amount</td>
			  </tr>
			</table>
		</div>
						
		<table width="600" >
			<tr>
				<td width="9">&nbsp;</td>
				<td width="179" class="normalfntRite">Advance Paid</td>&nbsp;
			  <td width="98" class="normalfnt"><input type="text" class="txtbox" style="width:75px;text-align:right;" value="<?php echo $advance;?>" readonly="readonly" id="grnPoAmount"  /><input type="hidden" value="<?php echo $balance;?>" id="txtBalance"/></td>
				<td width="86" class="normalfntRite">GRN Value</td>&nbsp;
			  <td width="130" class="normalfnt"><input type="text" class="txtbox"  style="width:75px;text-align:right;" id="txtTotGrn" readonly="readonly"></td>
				<td width="70">&nbsp;</td>
			</tr>
		</table>
		<br />
		<table width="600" border="0" >
			<tr>
				<td align="center"><img  src="../images/save.png" onclick="updateGrnDetails();"/>
				<img src="../images/close.png" border="0" onclick="CloseWindow()"/>
</td>
			</tr>
		</table>
		</form>
	
</div>
</body>
</html>