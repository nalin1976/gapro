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
<title>eShipping Web - Import Cusdec</title>

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
<?php
$xml = simplexml_load_file('../../config.xml');
$Declarant = $xml->companySettings->Declarant; 
$Destination = $xml->companySettings->Country; 
?>
<?php
$country="";
$sqlcountry="SELECT strCountryCode,strCountry FROM country ORDER BY strCountry";
$result_country=$db->RunQuery($sqlcountry);
		$country .= "<option value=\"".""."\">".""."</option>";		
	while($row_country=mysql_fetch_array($result_country))
	{
		$country .= "<option value=\"".$row_country["strCountryCode"]."\">".$row_country["strCountry"]."</option>";
	} 
?>

<body>
<form name="frmFabricIns" id="frmFabricIns" >
<table width="950" border="0" align="center" bgcolor="#FFFFFF" cellspacing="0">
	<tr>
    	<td><?php include '../../Header.php'; ?></td>
	</tr>
  	<tr>
    	<td bgcolor="#316895" class="TitleN2white" style="text-align:center">&nbsp;DOC </td>
    </tr>
  	<tr>
    	<td>
			<table align="center" width="835" style="margin-top:15px;">
				<tr>
					<td width="59" class="normalfnt">Buyer</td>
					<td width="196">
					<select name="#" style="width:170px" id="#" class="txtbox" onchange="#">
						<option></option>
						<option></option>
						<option></option>
					</select>
				  	</td>
					<td width="87" class="normalfnt">Date From</td>
				  	<td width="223"><input type="text" class="txtbox" style="width:168px" id="#" name="#" /></td>
					<td width="69" class="normalfnt">Date To</td>
				  	<td width="173"><input type="text" class="txtbox" style="width:168px" id="#" name="#" /></td>
				</tr>
				<tr>
					<td width="59" class="normalfnt">Status</td>
					<td width="196">
					<select name="#" style="width:170px" id="#" class="txtbox" onchange="#">
						<option></option>
						<option></option>
						<option></option>
					</select>
				  	</td>
					<td width="87" class="normalfnt">Carrier</td>
				  	<td width="223"><input type="text" class="txtbox" style="width:168px" id="#" name="#" /></td>
					<td width="69" class="normalfnt">Invoice No</td>
				  	<td width="173"><input type="text" class="txtbox" style="width:168px" id="#" name="#" /></td>
				</tr>
	 	  </table>
		  	<div align="center">
				<div align="center" style="width:900px; height:200px; overflow:scroll; margin-top:25px; margin-bottom:25px;">
					<table align="center" width="1580" class="tableGrid">
						<thead>
							<tr>
								<td>Invoice No</td>						
								<td>Date</td>
								<td>Qty</td>
								<td>Amount</td>
								<td>Forwarder Invoice Received ?</td>
								<td>Forwarder Invoice</td>
								<td>Paid to Forwarder</td>
								<td>Cheque No</td>
								<td>eDoc Sent</td>
								<td>FCR Received</td>
								<td>FCR Received Date</td>
								<td>Discount</td>
								<td>Discounted Amount</td>
								<td>Receipt</td>
								<td>Receipt Amount</td>
								<td>Balance</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>***</td>					
								<td>***</td>
								<td>***</td>
								<td>***</td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input class="normalfnt btnForwarder" type="button" value="Forwarder" id="#" class="#" /> </td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="text" class="textbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="text" class="textbox" id="#" name="#" /></td>
								<td style="text-align:center"><input class="normalfnt btnDiscount" type="button" value="Discount" id="#" class="#" /> </td>
								<td>***</td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="text" class="textbox" id="#" name="#" /></td>
								<td>***</td>						
							</tr>
							<tr>
								<td>***</td>					
								<td>***</td>
								<td>***</td>
								<td>***</td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input class="normalfnt btnForwarder" type="button" value="Forwarder" id="#" class="#" /> </td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="text" class="textbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="text" class="textbox" id="#" name="#" /></td>
								<td style="text-align:center"><input class="normalfnt btnDiscount" type="button" value="Discount" id="#" class="#" /> </td>
								<td>***</td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="text" class="textbox" id="#" name="#" /></td>
								<td>***</td>						
							</tr>
							<tr>
								<td>***</td>					
								<td>***</td>
								<td>***</td>
								<td>***</td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input class="normalfnt btnForwarder" type="button" value="Forwarder" id="#" class="#" /> </td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="text" class="textbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="text" class="textbox" id="#" name="#" /></td>
								<td style="text-align:center"><input class="normalfnt btnDiscount" type="button" value="Discount" id="#" class="#" /> </td>
								<td>***</td>
								<td style="text-align:center"><input type="checkbox" id="#" name="#" /></td>
								<td style="text-align:center"><input type="text" class="textbox" id="#" name="#" /></td>
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
<script type="text/javascript">
	$(".btnDiscount").click(function(){
		var url_exhi1		 	="Discount.php";
		var xml_http_obj_exhi1	=$.ajax({url:url_exhi1,async:false});
		var htmltext_exhi1		=xml_http_obj_exhi1.responseText;
		drawPopupArea(630,150,'frmNewOrganize');
		document.getElementById('frmNewOrganize').innerHTML=htmltext_exhi1;
		
		})
		
	$(".btnForwarder").click(function(){
	var url_exhi1		 	="ForwarderInvoice.php";
	var xml_http_obj_exhi1	=$.ajax({url:url_exhi1,async:false});
	var htmltext_exhi1		=xml_http_obj_exhi1.responseText;
	drawPopupArea(850,150,'frmNewOrganize');
	document.getElementById('frmNewOrganize').innerHTML=htmltext_exhi1;
	
	})
	
</script>