<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
	$poNo=$_GET['po'];
	$type=$_GET['type'];
	$poAmount=$_GET['poAmount'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GRN Details</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js" type="text/javascript"></script>
<script  src="../js/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="../javascript/table_script.js" type="text/javascript"></script>
<script src="advance_Payment_Settelment.js" type="text/javascript"></script>
</head>
<body>
<table width="100%">
	<tr>
		<td id="td_GrnHeader"><?php include $backwardseperator ."Header.php";?></td>
	</tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">GRN Details<span class="vol"></span><span id="grnDet_popup_close_button"></span></div>
	</div>
	<div class="main_body">
		<form method="post">
		<table width="600">
			<tr>
				<td width="10">&nbsp;</td>
				<td width="51" class="normalfnt">Select</td>
			  <td width="450" align="left"><input type="checkbox" class="txtbox" id="chkAll" onclick="selectAllChk(this);" ></td>
				<td width="69">&nbsp;</td>
			</tr>
		</table>
		<br />
		<div style="width:600px;" class="grid_topic_style">GRN</div>
		<div id="divcons2" style="overflow:scroll; height:250px; width:600px;">
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
				$strSQL="select concat(grndetails.intGrnNo,'/',grndetails.intGRNYear) AS GRNNO,matitemlist.strItemDescription,grndetails.dblQty, 			grndetails.dblPoPrice,(grndetails.dblPoPrice*grndetails.dblQty) AS VAL,(grndetails.dblPaymentPrice*grndetails.dblQty) AS PayVal,grndetails.dblValueBalance
						from grndetails 
						inner join matitemlist on matitemlist.intItemSerial = grndetails.intMatDetailID
						inner join grnheader on grnheader.intGrnNo = grndetails.intGrnNo
						-- inner join popaymentterms on popaymentterms.strPayTermId=purchaseorderheader.strPayTerm
						where grnheader.intPoNo='$poNo' ;";
						
						//echo $strSQL;
						
				$result=$db->RunQuery($strSQL);
				
				$count=0;
				$cls="";
				while($row=mysql_fetch_array($result)){
				($count%2==0)?$cls="grid_raw":$cls="grid_raw2";?>
						<tr>
							<td class="<?php echo $cls;?>"><input type="checkbox" onclick="setGrnValue();"/></td>
							<td class="<?php echo $cls;?>"><?php echo $row['GRNNO'];?></td>
							<td class="<?php echo $cls;?>"><?php echo $row['strItemDescription'];?></td>
							<td class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblQty'];?></td>
							<td class="<?php echo $cls;?>" style="text-align:right;"><?php echo $row['dblPoPrice'];?></td>
							<td class="<?php echo $cls;?>"><?php echo $row['dblValueBalance'];?></td>
							<!--<td class="grid_header">MatID</td>
							<td class="grid_header"><?php #echo $result[1][0];?></td>-->
							<td class="<?php echo $cls;?>" style="text-align:center;"><input type="text" style="width:80px;text-align:right; " onkeypress="return CheckforValidDecimal(this.value,1,event);" onkeyup="setBalance(this),setGrnValue();"  /></td>
							<td class="<?php echo $cls;?>"></td>
						</tr>
				<?php $count++;}	?>
				</tbody>
			</table>
		</div>
		<table width="600">
			<tr>
				<td width="10">&nbsp;</td>
				<td width="85" class="normalfnt">Advance Paid</td>
				<td width="141"><input type="text" class="txtbox" style="width:125px;text-align:right;" value="<?php echo $poAmount;?>" readonly="readonly" id="grnPoAmount"  /></td>
				<td width="91" class="normalfnt">GRN Value</td>
				<td width="227"><input type="text" class="txtbox"  style="width:125px;text-align:right;" id="txtTotGrn" readonly="readonly"></td>
				<td width="25">&nbsp;</td>
			</tr>
		</table>
		<br />
		<table width="600" border="0">
			<tr>
				<td width="19%">&nbsp;</td>
				<td width="7%"></td>
				<td width="7%"></td>
				<td width="17%"></td>
				<td width="17%"><img  src="../images/New.png"/></td>
				<td width="15%"><img  src="../images/Save.png"/></td>
				<td width="17%" id="td_GrnDelete"><a href="../main.php"><img src="../images/close.png" border="0" onclick="advclose()"/></a></td>
				<td width="1%">&nbsp;</td>
			</tr>
		</table>
		</form>
	</div>
</div>
