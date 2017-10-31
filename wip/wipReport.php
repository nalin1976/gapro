<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>WIP REPORT</title>

<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../../js/tablegrid.js"></script>

<style type="text/css">
.gaproLayout{
	width:950px; height:auto;
	border:1px solid;
	border-bottom-color:#550000;
	border-top-color:#550000;
	border-left-color:#550000;
	border-right-color:#550000;
	background-color:#FFFFFF;
	padding-right:15px;
	padding-top:10px;
	padding-left:30px;
	padding-right:30px;
	margin-top:20px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	-moz-border-radius-topright:10px;
	-moz-border-radius-topleft:10px;
	border-bottom:13px solid #550000;
	border-top:30px solid #550000;
}

.gaproText {
	position:relative;
	top : -35px; left:-1px; width:100%; height:24px;
	text-align:center;
	font-size: 12px;
	font-family: Verdana;
	padding-top:4px;
	width:100%;
	color:#ffffff;
	text-align:center;
	font-weight:normal;
}

.centered {
	font-family: Verdana;font-size: 11px; margin: 0px; font-weight: normal;
	text-align:center; width:940px; background-color:#b8a485; color:#62523a; margin-top:10px;
	padding-top:4px; padding-bottom:4px; font-weight:bold;
}
</style>

</head>

<body>
<table width="100%" align="center">
	<tr>
    	<td><?php include '../Header.php'; ?></td>
	</tr>
</table>
<div>
	<div align="center">
		<div class="gaproLayout" style="padding-bottom:20px;">
			<div class="gaproText">WIP REPORT<span class="volu"></span></div>
			
			<table width="90%" class="normalfnt" border="0">
				<tr>
					<td width="11%">Factory</td>
					<td width="21%">
						<select style="width: 152px;" class="txtbox">
						<option value=""></option>
						<option value=""></option>
						<option value=""></option>
						</select>
				  </td>
					<td width="13%" >Cut Date From</td>
					<td colspan="2">
						<select style="width: 152px;" class="txtbox">
						<option value=""></option>
						<option value=""></option>
						<option value=""></option>
						</select>
				  </td>
				</tr>
				<tr>
					<td>PO Number</td>
					<td>
						<select style="width: 152px;" class="txtbox">
						<option value=""></option>
						<option value=""></option>
						<option value=""></option>
						</select>
					</td>
					<td>Cut Date To</td>
					<td width="20%">
						<select style="width: 152px;" class="txtbox">
						<option value=""></option>
						<option value=""></option>
						<option value=""></option>
						</select>
				  </td>
				  <td width="35%"><img src="../../images/search.png" alt="search" width="60" onclick="loadwipdata();" /></td>
				</tr>
								<tr>
					<td colspan="5">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" style="margin-top:5px;">
						<input type="radio" name="#" id="#" style="margin-right:5px;" class="txtbox" />Cutting - to - Gate Pass Generation
					</td>
	
					<td colspan="2">
						<input type="radio" name="#" id="#" style="margin-right:5px;" class="txtbox" />Line Input - to - Washing Process 
					</td>

					<td>
						<input type="radio" name="#" id="#" style="margin-right:5px;" class="txtbox" />Washing - to - Shipping Process
					</td>
				</tr>
			</table>
			
			<table align="center">
				<tr>
					<td>
					<div class="centered">FACTORY WISE - WORK IN PROGRESS</div>
					<div style="overflow:scroll; height:150px; width:940px; margin-top:2px;">
						<table style="width:1400px" class="transGrid" border="1" cellspacing="1">
							<thead>
								<tr>
									<td>Buyer</td>
									<td>Order No</td>
									<td>Style No</td>
									<td>Color</td>
									<td>Order Qty</td>
									<td>Cost Qty</td>
									<td>Issued to factory</td>
									<td>Dispose</td>
									<td>Sample</td>
									<td>Missing</td>
									<td>Balance</td>
									<td>Various</td>
									<td>Balance Cutting</td>
									<td>Balance factory Cutting</td>
									<td>Total Balance</td>
									<td>Rate</td>
									<td>Value</td>		
								</tr>		
							</thead>	
							<tbody>
								<tr>
									<td>****</td>
									<td>****</td>
									<td>****</td>	
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
											
								</tr>
								<tr>
									<td>****</td>
									<td>****</td>
									<td>****</td>	
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>
									<td>****</td>			
								</tr>	
							</tbody>
						</table>
					</div>
					</td>
				</tr>
			</table>
			
		</div>
	</div>
</div>

</body>
</html>
