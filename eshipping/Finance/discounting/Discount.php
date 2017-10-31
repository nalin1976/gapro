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

<script type="text/javascript" src="Discount.js"></script>
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
    	<td><?php include $backwardseperator.'Header.php'; ?></td>
	</tr>
  	<tr>
    	<td bgcolor="#316895" class="TitleN2white" style="text-align:center">&nbsp;Discounting (Factoring)</td>
    </tr>
  	<tr>
    	<td>
		  <table align="center" width="676" style="margin-top:15px;">
				<tr>
					<td class="normalfnt">Search Ref No</td>
					<td colspan="3">
					<select name="cboRefNo" style="width:315px" id="cboRefNo" class="txtbox" onchange="loadSavedData();">
							<option value=""></option>
							<?php
							$sql="SELECT DISTINCT strRefNo FROM discount_header WHERE intCancelStatus=0;";
							$result=$db->RunQuery($sql);
							while($row=mysql_fetch_array($result))
							{
							?>
							<option value="<?php echo $row['strRefNo']; ?>">DIS<?php echo $row['strRefNo']; ?></option>
                            <?php
                            $digits = 3;

$len = strlen($strRefNo);
if ($len !== $digits) {
     $missing = $digits - $len;
     for ($i = 1; $i < $missing; $i++) {
          $var = '0'.$var;
     }
} 

                            
							?>
							<?php
							}
							?>
					</select></td>
					<td>&nbsp;</td>
				</tr>
                
                <tr>
				  <td class="normalfnt" style="vertical-align:top"">Date</td>
				  <td><input name="txtDate" tabindex="2" type="text" class="txtbox" id="txtDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
				  <td class="normalfnt">&nbsp;</td>
                  
				  <td width="103"></td>
			  </tr>
                
                
				<tr>
					<td width="110" class="normalfnt">Ref No</td>
					<td colspan="3">
						<input type="text" id="txtRefNo" name="txtRefNo" style="width:315px"  class="txtbox" disabled="disabled"/>			  	  </td>
					<td width="46" class="normalfnt">Bank</td>
			  	  <td width="177">
						<select name="cboBank" style="width:172px" id="cboBank" class="txtbox" onchange="">
							<option value="0"></option>
							<?php
							$sql="SELECT DISTINCT
									bank.strBankCode,
									bank.strName
									FROM
									bank
									ORDER BY strName
									;";
							$result=$db->RunQuery($sql);
							while($row=mysql_fetch_array($result))
							{
							?>
							
							<option value="<?php echo $row['strBankCode']; ?>"><?php echo $row['strName']; ?></option>
							<?php
							}
							?>
						</select>				  </td>
				</tr>
				<tr>
					<td width="110" class="normalfnt">Buyer</td>
					<td colspan="3">
						<select name="cboBuyer" style="width:315px" id="cboBuyer" class="txtbox" onchange="loadGrid();">
							<option value="0"></option>
							<?php
							$sql="SELECT
									buyers_main.intMainBuyerId,
									buyers_main.strMainBuyerName
									FROM
									buyers_main;";
							$result=$db->RunQuery($sql);
							while($row=mysql_fetch_array($result))
							{
							?>
							
							<option value="<?php echo $row['intMainBuyerId']; ?>"><?php echo $row['strMainBuyerName']; ?></option>
							<?php
							}
							?>
						</select>		  	  	  </td>
				  
				    <td><span class="normalfnt">Interest</span></td>
				    <td><input type="text" style="width:170px; text-align:right" id="txtInterest" class="txtbox" name="txtInterest"  value="0"/></td>
				</tr>
				<tr>
					<td class="normalfnt">Discount Amount</td>
				  <td width="108"><input type="text" style="width:100px; text-align:right" id="txtTotNetAmt" class="txtbox" name="txtTotNetAmt" disabled="disabled" value="0"/></td>
					<td width="97" class="normalfnt">Granted Amount</td>
		  	  	  <td width="110"><input type="text" style="width:100px; text-align:right" id="txtGrantedAmt" class="txtbox" name="txtGrantedAmt"  value="0"/></td>
					<td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">&nbsp;</td>
                    
              <tr style="visibility:hidden">
       
           	<td style="text-align:right;" class="normalfnt">Invoice &nbsp; Amount &nbsp;</td>
				  <td width="108"><input type="text" style="width:100px; text-align:right" id="txtTotInvoiceAmt" class="txtbox" name="txtTotInvoiceAmt" disabled="disabled" value="0"/></td>
                  
					<td style="text-align:right;" width="97" class="normalfnt">Discount &nbsp; Amount &nbsp;</td>
		  	  	  <td width="110"><input type="text" style="width:100px; text-align:right" id="txtTotDiscountAmt" class="txtbox" name="txtTotDiscountAmt" disabled="disabled" value="0"/></td>
                 
  	  	    <td style="text-align:right;" width="97" class="normalfnt"> Net Amount </td>
		  	  	  <td width="110"><span class="normalfnt">
		  	  	    <input type="text" style="width:100px; text-align:right" id="txtDiscountAmt" class="txtbox" name="txtDiscountAmt" disabled="disabled" value="0"/>
		  	  	  </span></td>
					
          </tr>
          
          
          
			  	  	<td><!--<img src="../../images/search.png" onclick="validateGrid();" />--></td>
				</tr>
	 	  </table>
		  	<div align="center">
			  <div align="center" style="width:700px; height:212px; overflow:auto;">
					<table align="center" width="680" bgcolor="#CCCCFF" id="tblDiscountData" cellpadding="0" cellspacing="1" border="0">
						<thead>
							<tr  bgcolor="#498CC2" class="normaltxtmidb2">
								<td width="44">Select</td>
								<td width="77">Invoice No</td>	
                                <td width="92">Invoice Date</td>
                                <td width="56">Style Id</td>
                                <td width="88">Buyer PO No</td>					
								<td width="114">Invoice Amount</td>
                                <td width="116">Discount Amount</td>
                                <td width="110">Net Amount</td>
							</tr>
						</thead>
						<tbody>
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
            <td width="4" bgcolor="#ffffff">&nbsp;</td>
   			<td width="8" bgcolor="#ffffff">&nbsp;</td>
            <td width="56" bgcolor="#ffffff">&nbsp;</td>
           	<td style="text-align:right;" class="normalfnt">&nbsp;</td>
				  <td width="112">&nbsp;</td>
                  
					<td style="text-align:right;" width="104" class="normalfnt">&nbsp;</td>
		  	  	  <td width="107"><input type="text" style="width:107px; text-align:right" id="txtSumInvoiceAmt" class="txtbox" name="txtSumInvoiceAmt" disabled="disabled" value="0"/></td>
                 
  	  	    <td style="text-align:right;" width="108" class="normalfnt"><input type="text" style="width:108px; text-align:right" id="txtSumDiscountAmt" class="txtbox" name="txtSumDiscountAmt" disabled="disabled" value="0"/></td>
		  	  	  <td width="143"><input type="text" style="width:102px; text-align:right" id="txtSumNetAmt" class="txtbox" name="txtSumNetAmt" disabled="disabled" value="0"/></td>
					<td width="106" class="normalfnt">&nbsp;</td>
          </tr>
          </table>
          
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
          
          <td width="4" bgcolor="#ffffff">&nbsp;</td>
   			<td width="8" bgcolor="#ffffff">&nbsp;</td>
            <td width="56" bgcolor="#ffffff">&nbsp;</td>
            <td width="68" bgcolor="#ffffff">&nbsp;</td>
   			<td width="112" bgcolor="#ffffff">&nbsp;</td>
            <td width="104" bgcolor="#ffffff">&nbsp;</td>
            </tr>
          
       
          
          <tr>
            <td width="4" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="8" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="56" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="68" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="100" bgcolor="#D6E7F5"><img src="../../images/new.png" alt="new" name="butNew" width="" height="24" class="mouseover"  id="butNew" onclick="clearForm();" align="right"/>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="100" bgcolor="#D6E7F5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../images/save.png" alt="new" name="butIouSave" width="" height="24" class="mouseover"  id="butIouSave" onclick="validateData();"/></td>
            <td width="100" bgcolor="#D6E7F5"><img src="../../images/cancel.jpg" class="mouseover"  onclick="CancelInv();"/></td>
            
            <td width="100" bgcolor="#D6E7F5"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="" height="24" border="0" id="Close" align="left"/></a></td>
            <td width="143" bgcolor="#D6E7F5">&nbsp;</td>
          </tr>
        </table>
	  </td>
	</tr>
</table>