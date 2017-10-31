<?php
session_start();
include "../Connector.php";
$backwardseperator = "../";
$companyId	= $_SESSION["FactoryID"];
$userId		= $_SESSION["UserID"];

$SQL = "select Name from useraccounts where intUserID = $userId";
$result = $db->RunQuery($SQL);	
while($row = mysql_fetch_array($result))
{
	$userName = $row["Name"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Purchase Requisition</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/tablegrid.js"></script>

<script type="text/javascript" src="../javascript/script.js"></script>
<script type="text/javascript" src="purchaserequisition.js?n=1"></script>
</head>

<body onload="LoadSavedDeials(<?php 	
$id = $_GET["Id"];
if($id=='1')
{
	$noArray = explode('/',$_GET["No"]);
	//echo "'$id'" ; echo "," ; echo "'$noArray[0]'" ;  ; 
	echo $id.",".$noArray[0].",".$noArray[1];
}
else
	echo "0,0,0";
?>);">

<form id="frmPurchaseRequisition" name="frmPurchaseRequisition">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../Header.php'; ?></td>
	</tr> 
</table>
<!--<div>
	<div align="center">-->
		<!--<div class="trans_layoutL">-->
		<!--<div class="trans_text">Purchase Requisition<span class="volu"></span></div>-->
<table width="950" border="0" align="center" class="tableBorder">
<tr>
	<td class="mainHeading" height="25">Purchase Requisition</td>
</tr>
<tr>
	<td><table width="100%" border="0">
				<tr>
				  <td width="4%" class="normalfnt">&nbsp;</td>
					<td width="15%" class="normalfnt">PR No</td>
			  	  <td width="29%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" id="txtPRNo" disabled="disabled" />
		  	      <input type="text" disabled="disabled" class="txtbox" id="txtSerialNo" style="width:88px;visibility:visible"/></td>
					<td width="1%" class="normalfnt"></td>
					<td width="13%" class="normalfnt">Cost Center <span class="compulsoryRed">*</span></td>
					<td width="38%" class="normalfnt">
						<select style="width: 250px;" class="txtbox" id="cboCostCenter" name="cboCostCenter">
<?php
$sql="select intCostCenterId,strDescription from costcenters where intStatus=1 and intFactoryId='$companyId' order by strDescription";
$result=$db->RunQuery($sql);
	echo "<option value="."".">"."Select One"."</option>\n";
while($row=mysql_fetch_array($result))
{
		echo "<option value=".$row["intCostCenterId"].">".$row["strDescription"]."</option>\n";
}
?>
				  </select>			  	  </td>
				</tr>
				<tr>
				  <td width="4%" class="normalfnt">&nbsp;</td>
					<td width="15%" class="normalfnt">Date</td>
			  	  <td width="29%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" value="<?php echo date("d-m-Y")?>" disabled="disabled" /></td>
					<td width="1%" class="normalfnt"></td>
					<td width="13%" class="normalfnt"><!-- Supplier -->Department<span class="compulsoryRed">*</span> </td>
				  	<td width="38%" class="normalfnt">
                    
                    <!-- Remove supplier selection from purchase requestion form  -->
                    <!-- It has done from Purchase Order Section-->
					<!--	<select style="width: 250px;" class="txtbox" onchange="LoadSuppDetails(this);loadCommonSupplierDetails(this);" id="cboSupplier">
<?php
$sql="select strSupplierID,strTitle from suppliers where intApproved=1 order by strTitle";
$result=$db->RunQuery($sql);
	echo "<option value="."null".">"."Select One"."</option>\n";
while($row=mysql_fetch_array($result))
{
	echo "<option value=".$row["strSupplierID"].">".$row["strTitle"]."</option>\n";
}
?>
				  </select>	-->			 
                  <select style="width: 250px;" class="txtbox" id="cboDepartment">
<?php
$sql="select intDepID,strDepartment from department where intStatus=1 and intCompayID='$companyId' order by strDepartment";
$result=$db->RunQuery($sql);
	echo "<option value="."null".">"."Select One"."</option>\n";
while($row=mysql_fetch_array($result))
{
	echo "<option value=".$row["intDepID"].">".$row["strDepartment"]."</option>\n";
}
?>
				  </select>				            </td>
				</tr>
				<tr>
				  <td width="4%" class="normalfnt">&nbsp;</td>
					<td width="15%" class="normalfnt">Requested By</td>
			  	  <td width="29%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" value="<?php echo $userName?>" disabled="disabled" /></td>
					<td width="1%" class="normalfnt"></td>
					<td width="13%" class="normalfnt">Attention</td>
				  	<td width="38%" class="normalfnt"><input type="text" class="txtbox" style="width:250px;" id="txtAttension" /></td>
				</tr>
				<tr>
				  <td width="4%" class="normalfnt">&nbsp;</td>
					<td width="15%" class="normalfnt"><!--Currency <span class="compulsoryRed">*</span>-->Job No / Type</td>
				  	<td width="29%" class="normalfnt">
						<!--<select id="cboCurrencyId" style="width: 90px;" class="txtbox" onchange="LoadCurrencyRate(this);">
<?php
$sql="select intCurID,strCurrency from currencytypes where intStatus=1 order by strCurrency";
$result=$db->RunQuery($sql);
	echo "<option value="."null".">"."Select One"."</option>\n";
while($row=mysql_fetch_array($result))
{
		echo "<option value=".$row["intCurID"].">".$row["strCurrency"]."</option>\n";
}
?>
						</select>
				  <input type="text" class="txtbox" style="width:55px;text-align:right" id="txtExRate" disabled="disabled"/>-->				 
                  <input type="text" class="txtbox" style="width:150px;" id="txtJobNo" maxlength="20" />
			  	      <select name="cboJobType" class="txtbox" id="cboJobType" style="width: 90px;">
					  	<option value="">Select One</option>
						<option value="0">Normal Job</option>
						<option value="1">Special Job</option>
                      </select>
                   </td>
					<td width="1%" class="normalfnt"></td>
					<td width="13%" class="normalfnt">Remarks</td>
			  	  <td width="38%" class="normalfnt"><textarea name="txtIntroduction" style="width:250px;height:20px" rows="1" class="txtbox" id="txtIntroduction" tabindex="4" onkeypress="return imposeMaxLength(this,event, 200);" onblur="ControlableKeyAccess(event);" ></textarea></td>
				</tr>
				<tr>
				  <td width="4%" class="normalfnt">&nbsp;</td>
					<td width="15%" class="normalfnt">&nbsp;</td>
		  	      <td width="29%" class="normalfnt">&nbsp;</td>
					<td width="1%" class="normalfnt"></td>
					<td width="13%" class="normalfnt">&nbsp;</td>
					<td width="38%" class="normalfnt">&nbsp;</td>				
				</tr>
				<tr>
				  <th colspan="6" class="mainHeading4" >GL Account Description </th>
	    </tr>
			</table>
			<div style="overflow:scroll; height:150px; width:940px;">
				<table id="tblGlMain" style="width:100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCFF">
					<thead>							
						<tr class="mainHeading4">
							<td width="6%" height="25">GL Code</td>
							<td width="18%">Account Description</td>
							<td width="6%">Budget</td>	
							<td width="8%">Additional</td>
							<td width="7%">Transfer</td>
							<td width="9%">Total Budget</td>	
							<td width="8%">Actual</td>
							<td width="7%">Pending</td>
							<td width="12%">Budget Variance</td>
							<td width="8%">Requested</td>
							<td width="11%">Current Budget</td>		
						</tr>		
					</thead>	
					<tbody>
					</tbody>
				</table>
			</div>
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
      			<tr>
					<td align="right"><img src="../images/additem.png" alt="additem" id="butAddItem" onclick="OpenItemPopUp();"></td>					
      			</tr>
      			<tr>
					<th class="mainHeading4">Item Description</th>					
      			</tr>
			</table>
	  <div style="overflow:scroll; height:250px; width:940px;">
	    <table style="width:105%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCFF" id="tblItemMain">
          <thead>
            <tr class="mainHeading4">
              <td width="20" height="25">Del</td>
              <td width="51">Item Code</td>
              <td width="209">Item Description</td>
              <td width="49">Unit</td>
              <td width="56">Unit Price</td>
              <td width="60">Price Updated</td>
              <td width="74">Current Stock</td>
              <td width="73">Reorder Level</td>
              <td width="56">Order Qty</td>
              <td width="63">Value</td>
              <td width="53">Discount<br/>
                %</td>
              <td width="62">Discount<br/>
                Value</td>
              <td width="54">Final<br/>
                Value</td>
              <td width="45">Asset</td>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
	  </div>
			<table width="100%" border="0">
				<tr>
					<td width="2%" >&nbsp;</td>
			  	  	<td width="46%" class="normalfnt">&nbsp;</td>
			  	  	<td width="11%" class="normalfnt">&nbsp;</td>
				  	<td width="15%" class="normalfnt">Total</td>
				  	<td width="26%" class="normalfnt"><input type="text" class="txtbox" style="width:157px;text-align:right" id="txtTotalValue"  disabled="disabled" value="0"/></td>
				</tr>
				<tr>
					<td width="2%" class="txtbox bcgcolor-InvoiceCostTrim">&nbsp;</td>
			  	  	<td width="46%" class="normalfnt">Stock balance less than  reorder level </td>
			  	  	<td width="11%" class="normalfnt">&nbsp;</td>
				  	<td width="15%" class="normalfnt">Discount %</td>
				  	<td width="26%" class="normalfnt">
						<input type="text" class="txtbox" style="width:50px;text-align:right" id="txtDisPercent" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onkeyup="CalculateDiscount(this);" value="0"/>
				  <input type="text" class="txtbox" style="width:100px;text-align:right" id="txtDisValue" disabled="disabled" value="0"/>					</td>
				</tr>
				<tr>
					<td width="2%" class="normalfnt">&nbsp;</td>
			  	  	<td width="46%" class="normalfnt">&nbsp;</td>
			  	  	<td width="11%" class="normalfnt">&nbsp;</td>
				  	<td width="15%" class="normalfnt">PR  Value</td>
				  	<td width="26%" class="normalfnt"><input type="text" class="txtbox" style="width:157px;text-align:right" id="txtPRValue" disabled="disabled" value="0"/></td>
				</tr>
			</table>
			<table width="100%" border="0" class="tableBorder">
      			<tr>
					<td width="24%" align="center">
					<img src="../images/new.png" title="Click here to clear the form" onclick="ClearForm();"/>
					<img src="../images/save.png" id="butSave" title="Click here to save" onclick="SavePR();"/>
					<img src="../images/send2app.png" id="butSendToApproval" title="Click here to send for the first approval" onclick="SendToApproval();"/>
                    <img src="../images/approve.png" id="butHOApproval" title="Click here to second approval" style="display:none" onclick="SaveAndConfirmSecondApproval();"/>
					<img src="../images/revise_new.png" id="butRevise" title="Click here to Revise the PR" onclick="RevisePR();" style="display:none"/>
					<img src="../images/cancel.jpg" id="butCancel" title="Click here to Cancel the PR" onclick="CancelPR();" style="display:none"/>
					<img src="../images/upload.jpg" id="butUpload" title="Click here to upload documents" onclick="UploadFile();"/>
					<img src="../images/report.png" title="Click here to view report" onclick="ViewReport();"/>
					<a href="../main.php"><img src="../images/close.png" id="butClose" border="0" title="Click here to goto main page"/></a>
					</td>
      			</tr>
			</table>
		<!--</div>-->
	<!--</div>-->
<!--</div>--></td>
</tr>
</table>
</form>
</body>
</html>
 <script type="text/javascript" src="../js/jquery.fixedheader.js"></script>