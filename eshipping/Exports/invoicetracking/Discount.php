<?php
	session_start();
	

	include("../../Connector.php");
	$backwardseperator = "../../";
	$companyID=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Discount</title>

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}

-->
</style>

<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="cusdec.js" type="text/javascript"></script>
<script src="cusdecdescription.js" type="text/javascript"></script>
<script src="iou.js" type="text/javascript"></script>
<script src="search.js" type="text/javascript"></script>

<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>

<style type="text/css">
.tableGrid{
	border:1px solid #cccccc;
}

.tableGrid thead{
	background-color:#7cabc4;
	text-align:center;
	color:#ffffff;
	padding:10px 5px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
}

.tableGrid tbody{
	background-color:#e3e9ec;
	text-align:left;
	color:#333333;
	padding:4px;
}
</style>
</head>


<body>
<form name="frmFabricIns" id="frmFabricIns" >
<table width="700" border="0" align="center" bgcolor="#FFFFFF" cellspacing="0">
	<tr>
    	<td><?php include '../../Header.php'; ?></td>
	</tr>
  	<tr>
    	<td bgcolor="#316895" class="TitleN2white" style="text-align:center">&nbsp;Discount </td>
    </tr>
  	<tr>
    	<td>
			<table align="center" width="676" style="margin-top:15px;">
				<tr>
					<td width="110" class="normalfnt">Ref No</td>
					<td colspan="3">
						<select name="#" style="width:315px" id="#" class="txtbox" onchange="#">
							<option></option>
							<option></option>
							<option></option>
						</select>
			  	  </td>
					<td width="46" class="normalfnt">Bank</td>
				  	<td width="177">
						<select name="#" style="width:172px" id="#" class="txtbox" onchange="#">
							<option></option>
							<option></option>
							<option></option>
						</select>
				  </td>
				</tr>
				<tr>
					<td width="110" class="normalfnt">Buyer</td>
					<td colspan="5">
						<select name="#" style="width:315px" id="#" class="txtbox" onchange="#">
							<option></option>
							<option></option>
							<option></option>
						</select>
		  	  	  </td>
				</tr>
				<tr>
					<td class="normalfnt">Discount Amount</td>
				  <td width="108"><input type="text" style="width:100px" id="#" class="txtbox"/></td>
					<td width="97" class="normalfnt">Granted Amount</td>
		  	  	  <td width="110"><input type="text" style="width:100px" id="#" class="txtbox"/></td>
					<td class="normalfnt">Interest</td>
			  	  	<td><input type="text" style="width:170px" id="#" class="txtbox"/></td>
				</tr>
	 	  </table>
		  	<div align="center">
				<div align="center" style="width:500px; height:200px; overflow:scroll; margin-top:25px; margin-bottom:25px;">
					<table align="center" width="480" class="tableGrid">
						<thead>
							<tr>
								<td>Select</td>
								<td>Invoice No</td>						
								<td>Invoice Amount</td>
								<td>Invoice Date</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>***</td>					
								<td>***</td>
								<td>***</td>
								<td>***</td>							
							</tr>
							<tr>
								<td>***</td>					
								<td>***</td>
								<td>***</td>	
								<td>***</td>		
							</tr>
							<tr>
								<td>***</td>					
								<td>***</td>
								<td>***</td>
								<td>***</td>					
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</td>
	</tr>
	<tr>
    	<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
         
          <tr>
            <td width="6%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="6%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="9%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="6%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="8%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="12%" bgcolor="#D6E7F5"><img src="../../images/print.png" alt="new" name="butIouPrint" width="115" height="24" class="mouseover"  id="butIouPrint" onclick="PrintIOU();"/></td>
            <td width="9%" bgcolor="#D6E7F5"><img src="../../images/save.png" alt="new" name="butIouSave" width="84" height="24" class="mouseover"  id="butIouSave" onclick="SaveIOU();"/></td>
            <td width="10%" bgcolor="#D6E7F5"><img src="../../images/close.png" alt="new" name="butNew" width="97" height="24" class="mouseover"  id="butNew" onclick="ClearForm();"/></td>
            <td width="34%" bgcolor="#D6E7F5">&nbsp;</td>
          </tr>
        </table>
		</td>
	</tr>
</table>