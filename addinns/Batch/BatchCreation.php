<?php
 	session_start();
	$backwardseperator = "../../";
	include "../../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />

<title>GaPro | Batch Creation</title>

<script type="text/javascript" src="BatchJS.js"></script>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>


</head>

<body onload="setDefaultDate(<?php echo $_SESSION['FactoryID'];?>)">
<?php

	$CompanyID = $_SESSION["FactoryID"];
	//echo $CompanyID;
?>
<form name="frmBatchCreation" id="frmBatchCreation" method="get" action="readfile.php" target="_blank">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../../Header.php'; ?></td>
	</tr> 
</table>
<div class="main_bottom_center">
	<div class="main_top"><div class="main_text">Batch Creation</div></div>
	<div class="main_body">
<table width="800" border="0">
      <tr>
        <td>
          <table width="100%" border="0">            
            <tr>
              <td height="364">              
              <table width="100%" height="165" border="0" cellpadding="0" cellspacing="0">
                <tr class="">
                  <td width="100%" valign="top">                  
                  <table width="100%" border="0" class="">
                    <tr>
                      <td valign="top" align="center">
                      <fieldset class="fieldsetStyle" style="width:800px;-moz-border-radius: 5px;">
                      <table width="80%" border="0" cellpadding="1" cellspacing="1">  
                        <tr>
                          <td width="30%" class="normalfnt">Search</td>
                            <td width="37%" colspan="2"><select name="cboSearch" class="txtbox" id="cboSearch" onchange="LoadBatch(this);" style="width:255px" tabindex="1" >
				<option value="0" selected="selected">Select One</option>
				<?php	
					$SQL = "SELECT intBatch, strDescription FROM batch where batch.intCompID=".$_SESSION["FactoryID"]." ORDER BY strDescription;";
				
					$result = $db->RunQuery($SQL);	
								
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intBatch"] ."\">" . $row["strDescription"] ."</option>" ;
					}	
				?>
                                  </select></td>
						</tr>
                        <tr>
                          <td class="normalfnt">Batch No</td>
                                <td colspan="2"><input name="txtBatchNo"  disabled="disabled" type="text" class="txtbox" id="txtBatchNo" style="width:253px" readonly="true" /> </td>
                        </tr>
                        <tr>
                          <td class="normalfnt">Description <span class="redText">*</span></td>
                          
                                <td><input name="txtDescription" type="text" class="txtbox" id="txtDescription" style="width:253px" maxlength="50" tabindex="2"  /></td>
                        </tr>
                        <tr>
                          <td class="normalfnt">Date <span class="redText">*</span></td>
                                <td><input name="txtDate" type="text" class="txtbox" id="txtDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date('d/m/Y'); ?>" tabindex="3" /><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td><td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td class="normalfnt">Batch Type <span class="redText">*</span></td>
                          <td><select name="cboBatchType" class="txtbox" id="cboBatchType" style="width:255px" tabindex="4" onchange="ManageInterface(this.value);">
                              <option value="0" selected="selected"></option>
                              
                              <?php	
							echo "<option value=\"". 1 ."\">" ."Invoice". "</option>" ;
							echo "<option value=\"". 2 ."\">" ."Payment". "</option>" ;
					?>
                            </select></td>
                            <td width="37%">&nbsp;</td>
                        </tr>
                        <tr id="trBank">
                          <td colspan="3" class="normalfnt">
						 <div style="display:inline" id="divbank">
						  <table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td width="170">Bank <span class="redText">*</span></td>
    <td width="256"><select name="cboBank" class="txtbox" id="cboBank" style="width:255px" tabindex="5" onchange="LoadAccountDetails(this);">
      <option value="null" selected="selected"></option>
      <?php	
						$SQL = "SELECT intBranchId, strName FROM branch where intStatus=1 order by strName;";	
						$result = $db->RunQuery($SQL);
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["intBranchId"] ."\">" . $row["strName"] ."</option>" ;
						}	
					?>
    </select></td>
    <td width="200"><img src="../../images/add.png" alt="add" onclick="batch_creation_popupBank();"/></td>
  </tr>
  <tr>
    <td>Bank Account No <span class="redText">*</span></td>
    <td><select name="cboBatch_accountName" class="txtbox" id="cboBatch_accountName" style="width:255px" tabindex="6" onchange="LoadCurrency(this);">
      <option value="null" selected="selected"></option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
</table></div>
<div style="display:inline" id="B">
<table width="100%" border="0" cellpadding="1" cellspacing="1">
                            <tr>
                              <td width="170">Currency<span class="redText"> *</span></td>
                              <td width="256"><select name="cboCurrency" class="txtbox" id="cboCurrency"  style="width:255px" tabindex="7" disabled="disabled" >
                                <option value="null" selected="selected"></option>
                                <?php	
						$SQL = "SELECT intCurID,strCurrency FROM currencytypes WHERE intStatus=1 order by strCurrency;";	
						$result = $db->RunQuery($SQL);						
						while($row = mysql_fetch_array($result))
						{						
							echo "<option value=\"". $row["intCurID"] ."\">" .$row["strCurrency"]. "</option>" ;
						}	
					?>
                              </select></td>
                              <td width="200"><img src="../../images/add.png" alt="add" onclick="loadCurrencyPopUp();" style="visibility:hidden"/></td>
                            </tr>
                          </table></div>						 
						  </td>
                          </tr>
                        </table>
                        </fieldset>
							</td>
                          </tr>
                          <tr>
                          	<td bgcolor="" colspan="3" >
                          	
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr align="center">
							<td><img src="../../images/new.png" alt="NEW" width="96" height="24" onclick="setFroNew(<?php echo $_SESSION['FactoryID'];?>)" tabindex="9" />
							<img src="../../images/save.png" alt="SAVE" id="butSave" width="84" height="24" onclick="saveBatch(<?php echo $_SESSION['FactoryID'];?>);"  tabindex="7" />
							 <img src="../../images/delete.png" alt="delete" id="butDelete" onclick="DeleteBatch();" tabindex="8" />
							<a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" tabindex="9" /></a></td>
                           </tr>
                    </table>                    
					</td>
                   </tr>     
                    <tr>
                      <td height="156" valign="top">
                      <fieldset class="fieldsetStyle" style="width:800px;-moz-border-radius: 5px;">
                      <div id="divBatches" style="overflow:scroll; height:150px; width:800px;">
                        <table width="100%" bgcolor="" height="41" cellpadding="0" cellspacing="1" id="tblBatch">
                          <tr>
                            <td width="53" bgcolor="" class="grid_header">Edit</td>
                            <td width="61" height="21" bgcolor="" class="grid_header">Status</td>
                            <td width="79" bgcolor="" class="grid_header">Batch No</td>
                            <td width="221" bgcolor="" class="grid_header">Description</td>
                            <td width="72" bgcolor="" class="grid_header">Type</td>
                            <td width="77" bgcolor="" class="grid_header">Date</td>
                            <td width="83" bgcolor="" class="grid_header">Currency</td>
                            <td width="281" bgcolor="" class="grid_header">Bank</td>
                          </tr>
                        </table>
                      </div>
                      </fieldset></td>
                          </tr>
                    </table>
					</td>
                    </tr>
            </table>
        </td>
        </tr>
    </table>
	</td>
  </tr>
</table>
</div>
</div>
</form>
</body>
</html>