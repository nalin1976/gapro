<?php
session_start();
$Date     = "";
$Date1    = "";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Purchase order</title>
<link  rel="stylesheet" type="text/css" href="css/erpstyle.css"/>
	
<script type="text/javascript" src="javascript/script.js"></script>    
<script type="text/javascript" src="javascript/jquery.js"></script>
<script type="text/javascript" src="javascript/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />

<script type="text/javascript" src="POScript.js"></script>
<script type="text/javascript" src="calendar_functions.js" ></script>
<script type="text/javascript" src="javascript/calendar/calendar.js" ></script>
<script type="text/javascript" src="javascript/calendar/calendar-en.js" ></script>
	<link href="css/tableGrib.css" rel="stylesheet" type="text/css" />
	<link href="css/JqueryTabs.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
	<script type="text/javascript" src="js/tablegrid.js"></script>
	
<style type="text/css">
	.trans_layoutNEw{
	width:800px; height:auto;
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
	
	</style>
<?php
include "Connector.php";
?>	
</head>
<body>
<form id="frmPopItem" name="frmPopItem">
 <table width="718" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFFF" align="center">
  <tr  bgcolor="#660000" height="25px">
   <td colspan="2" style="color:#FFFFFF; text-align:center" class="normalfnt">Purchase order</td>
    </tr>
 	 <tr>
	  <td>
	   <table align="left" width="339" id="1">
		<tr>
		 <td class="normalfnt" width="116">Buyer</td>
		  <td>
		   <select id="cboBuyer" name="cboBuyer" class="textbox" style="width:180px;" onChange="LoadStyleNo();">
			<option value="">Select One</option>
			 <?php
			  $SQL = "SELECT intBuyerID, strName FROM buyers where intStatus=1 order by strName";
			  $result = $db->RunQuery($SQL);
			  while($row = mysql_fetch_array($result))
			   {
				 echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
			   }
			 ?>
			</select>					
		   </td>
		  </tr>
		  <tr>
		   <td class="normalfnt" width="116">Season</td>
			<td width="211">
			 <select id="cboSeason" name="cboSeason" class="textbox" style="width:180px;">
			  <option>Select One</option>
							<?php
	                         $SQL = "SELECT orders.intSeasonId,seasons.strSeason FROM materialratio
			                         Inner Join orders ON materialratio.intStyleId = orders.intStyleId
			                         Inner Join seasons ON seasons.intSeasonId = orders.intSeasonId
			                         WHERE orders.intBuyerID =  '13' AND materialratio.dblBalQty >=  '0' GROUP BY                    			 	 orders.intSeasonId ASC";
							 $result = $db->RunQuery($SQL);
							 while($row = mysql_fetch_array($result))
								{
								 echo "<option value=\"". $row["intSeasonId"] ."\">" . $row["strSeason"] ."</option>" ;
								}
							?>
		   </select>
		  </td>
		 </tr>
		 <tr>
		  <td class="normalfnt"> Style Group</td>
		   <td width="211"> 
			<select id="style" name="" class="textbox" style="width:180px;">
			 <option></option>
			</select>
		   </td>
		  </tr>
		  <tr>
		   <td class="normalfnt">Style No</td>
			<td width="211"> 
			 <select id="cboStyleNo" name="cboStyleNo" class="textbox" style="width:180px;" onChange="LoadOrderNo();  LoadSCNOList();">
			  <option value="Select One">Select One</option>
			 </select>
		   </td>
		  </tr>
		 
		   <tr>
		    <td class="normalfnt">SC No</td>
			 <td width="211"> 
			  <select id="cboScNo" name="cboScNo" class="textbox" style="width:180px;" onChange="LoadstyleNo();loadItems();"></select>
			 </td>
			</tr>
		    <tr>
			 <td class="normalfnt">Buyer PO No</td>
			  <td width="211"> 
			   <select id="cboBuyerPO" name="cboBuyerPO" style="width:80px; ">
				<option>#Main Ratio#</option>
			   </select>
			    <input type="checkbox" id="chkAllPO" name="chkAllPO" /><span class="normalfnt">&nbsp;All buyer Pos</span>				              </td>
			 </tr>
			 <tr>
			  <td class="normalfnt">PO Item Adding</td>
			   <td width="211">
			    <select id="cboPoItems" name="cboPoItems" class="textbox" style="width:180px;">
			  	 <option value="1">All Items</option>
                 <option value="2">Freight Items</option>
                 <option value="3">Non Freight Items</option>
                </select>			  	  
			   </td>
			  </tr>
			  <tr>
			   <td class="normalfnt">Delivery  Date</td>
				<td width="211"> 
				 <input type="text"  class="txtbox" style="width:68px;" input name="txtDate" value="<?php echo date('Y')."-".date('m')."-".date('d'); ?>" id="txtDate" size="15" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();"  onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;" onClick="return showCalendar(this.id, '%Y-%m-%d');" />
				 <input type="text"  class="txtbox" style="width:68px;" input name="txtDate1" value="<?php echo date('Y')."-".date('m')."-".date('d'); ?>" id="txtDate1" size="15" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();"  onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;" onClick="return showCalendar(this.id, '%Y-%m-%d');" />				  
			   </td>
			  </tr>
			  <tr>
			   <td class="normalfnt">Main Category</td>
			    <td width="211">
				 <select id="cboMaterial" name="cboMaterial" class="textbox" style="width:180px;" onChange="loadSubCategory(this.value);">
                    <option value=""></option>
                 </select>
				</td>
			   </tr>
			   <tr>
			    <td class="normalfnt">Sub Category</td>
				 <td width="211">
				  <select id="cboSubCategory" name="cboSubCategory" class="textbox" style="width:180px;" onChange="loadItems();">
				   <option value="">Select One</option>
				  </select>	
    			 </td>
				</tr>
				<tr>
				 <td class="normalfnt">Item</td>
				  <td width="211">
                   <select id="cboItems" name="cboItems" class="textbox" style="width:180px;">
					<option value=""></option>
				  </select>
				 </td>
				</tr>
                 <tr>
		   <td class="normalfnt" style="visibility:hidden;">Order No</td>
		  	<td width="211" style="visibility:hidden;"> 
		  	 <select id="cboOrderNo" name="cboOrderNo" class="textbox" style="width:180px;" onChange="dsableOkBtton();" >    
			  <option value="">Select One</option>
			 </select>
			</td>
		   </tr>
		  </table>		</td>
	  <td>
		<div style="overflow:scroll; height:170px; width:358px;" id="divOrderDetails">
			<table width="340"   border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblStyleDetails" align="left">
				<tr class="mainHeading4">
					<td><input type="checkbox" checked="checked" onClick="checkedAll(this);"></td>
    				<td>Style No</td>
    				<td>Order No</td>
  				</tr>
		  </table>
	    </div>
				
	    <table width="360" border="0" cellspacing="1" cellpadding="0" bgcolor="#ffffff" id="" align="center">
          <tr>&nbsp;</tr>
          <tr>
            <td width="12%"><img src="images/view.png" align="left" id="butView" name="butView" alt="close" border="0" onClick="new1();"/></td>
            <td width="12%"><img src="images/view_2.png" name="butOk"border="0" align="left" id="butOk" onClick="showOrderDetails();" /></td>
            <td class="normalfnt"><input type="checkbox" id="chk" name="chk"/>
              &nbsp;Supplier wise Item</td>
          </tr>
        </table>
		</td>
 	</tr>
  </table>
  
  	<table align="center" width="710" bgcolor="#FFFFFF">
  		<tr>
  	  		<td colspan="4"><table width="690" border="0" cellpadding="1" class="bcgl1">
  				<tr>
    				<td>
  				  
			  <tr>
            <td width="26" height="18" class="txtbox bcgcolor-InvoiceCostTrim">&nbsp;</td>
            <td width="324" class="normalfnt">&nbsp;&nbsp;Stock Available(Bulk or Leftover)</td>
            <td width="26" class="txtbox bcgcolor-InvoiceCostFabric">&nbsp;</td>
            <td width="316" class="normalfnt">&nbsp;&nbsp;Ratio Qty 0 Items</td>
          </tr>
        </table>
		<table>
			<tr>
				
				<td colspan="4"><div style="overflow:scroll; width:100%; height:200px;">
          <table width="690" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblMatrialGrid" align="center">
            <tr>
              <td colspan="11" class="mainHeading2">Material Detail</td>
            	</tr>
            <tr class="mainHeading4">
              <td width="22" height="20"><input name="chkAll" type="checkbox" onClick="checkAll(this);" id="chkAll"></td>
              <td width="259">Description</td>
              <td width="86">Color</td>
              <td width="78">Size</td>
              <td width="74">Tot Qty</td>
              <td width="74">Pending Qty</td>
              <td width="63">Bulk Stock Qty</td>
              <td width="72">Left Stock Qty</td>
              <td width="72">Liability Qty</td>
              <td width="52">Allocation</td>
             <!-- <td width="16" style="visibility:hidden"><img src="images/house.png"></td>-->
            </tr>
			<tr>
				<td>
          </table>
        </div>
        
        </td></tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="690" border="0" cellpadding="2" class="bcgl1">
  <tr>
    <td align="center">
	<img src="images/addsmall.png" width="95" height="24" onClick="validateExrateBeforAddItem();convertRates();"><img src="images/close.png" onClick="CloseOSPopUp('popupLayer1');">
	</td>
  </tr>
</table>
	</td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
</table>
</form>                
</body>
</html>
