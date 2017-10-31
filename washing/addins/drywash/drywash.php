<?php
session_start();
$backwardseperator = "../../../";
$pub_url = "/gaprohela/";
include "../../../Connector.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Process</title>

<script type="text/javascript" src="../../../javascript/script.js"></script>
<script type="text/javascript" src="../../../javascript/jquery.js"></script>
<script type="text/javascript" src="../../../javascript/jquery-ui.js"></script>
<script type="text/javascript" src="../../../js/jquery-1.3.2.min.js"></script>


<script src="Button.js"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../../css/tableGrib.css" rel="stylesheet" type="text/css" />
	<link href="../../css/JqueryTabs.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="../../../js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="../../../js/jquery-ui-1.7.2.custom.min.js"></script>
	<script type="text/javascript" src="../../../js/tablegrid.js"></script>
<style type="text/css">
.trans_layout2{
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

.trans_text2 {
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
</style>
</head>

<body onload="ClearForm();">
<form id="frmDryProcess" name="frmDryProcess" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<div class="main_bottom">
<div class="main_top"><div class="main_text">Process</div></div>
<div class="main_body" align="center">
<table width="70%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td height="139" ><table width="0" border="0" align="center">
      <tr>
        <td width="62%">
<table width="100%" border="0" class="">
   <tr>
     <td height="7" colspan="3">&nbsp;</td>
   </tr>
   <tr>
     <td class="normalfnt" >Category</td>
      <td align="left">
		<select name="cboCategory" class="txtbox" id="cboCategory" style="width:150px" tabindex="4" <?php if($manageFScategory){?> disabled="disabled" <?php }?> onchange="Loadtxtarea(this.value);">
		                    <option value=""></option>
							<option value="DP">Dry Process</option>
                            <option value="SP">Special Process</option>
							<option value="OP">Other Process</option>
							<option value="MP">Main Process</option>
        </select>
	</td>
  </tr>
  <tr>
    <td width="143" class="normalfnt">Process</td>
    <td width="152" align="left">
		<select name="dryprocess_cboDryProcess" onchange="getDryDetails();loadConditionDetails();"class="txtbox" id="dryprocess_cboDryProcess" style="width:150px" tabindex="1">
			 <?php
				$SQL="SELECT * FROM was_dryprocess  order by strDescription";
					$result = $db->RunQuery($SQL);
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["intSerialNo"] ."\">" . $row["strDescription"] ."</option>" ;
						}  
			 ?>
         </select>                      
	 </td>
   </tr>
   <tr>
      <td class="normalfnt" >Process Code <span class="compulsoryRed">*</span></td>
      <td align="left"><input name="dryprocess_txtcode" type="text" class="txtbox" id="dryprocess_txtcode" style="width:150px"  maxlength="10" onkeypress="return checkForTextNumber(this.value, event);" tabindex="2" <?php if($manageFScategory){?> disabled="disabled" <?php }?>/>
	  </td>
   </tr>
   <tr>
      <td class="normalfnt" >Description <span class="compulsoryRed">*</span></td>
      <td align="left"><input name="dryprocess_txtDes" type="text" class="txtbox" id="dryprocess_txtDes" style="width:150px" maxlength="20" tabindex="3" <?php if($manageFScategory){?> disabled="disabled" <?php }?>/></td>
    </tr>
	<tr>
	   <td class="normalfnt">First Sale Category</td>
	   <td align="left">
	   		<select name="cboFScategory" id="cboFScategory" style="width:150px;" <?php if(!$manageFScategory){?> disabled="disabled" <?php }?>>
                  <?php
					  $SQL="Select intCategoryId,intCategoryName from firstsalecostingcategory where intStatus=1 order by intCategoryId";
					$result = $db->RunQuery($SQL);
					echo "<option value=\"". "Null" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"". $row["intCategoryId"] ."\">" . $row["intCategoryName"] ."</option>" ;
						}  
				  ?>
			</select>
		</td>
	</tr>
	<tr>
        <td class="normalfnt">Active</td>
        <td align="left"><input type="checkbox" name="dryprocess_chkActive" id="dryprocess_chkActive" checked="checked"  tabindex="5" <?php if($manageFScategory){?> disabled="disabled" <?php }?>/></td>
    </tr>
	<tr>
	  <td height="3">&nbsp;</td>
	  <td height="3">&nbsp;<span id="seasons_txtHint" style="color:#FF0000"></span></td>
	  <td width="1" >&nbsp;</td>
	  </tr>            
    </table>
         </td>
    </tr>
</table>
<div style="overflow:auto; height:150px; width:600px; margin-top:10px; display:none;" id="tbltermsCondition1">
          <table width="557" border="1" cellspacing="1" class="transGrid" id="tbltermsCondition" style="width:500px;">
            <thead>
              <tr>
                <td colspan="2">Terms & Conditions</td>
              </tr>
              <tr>
                <td width="37">Serial No.</td>
                <td width="507">Description</td>
              </tr>
            </thead>
            <tbody>
            <!--  <tr>
                <td width="37"><input type="text" readonly="true" align="middle" id="txtNo" name="txtNo" value="" class="textBox" tabindex="7" style="width:15px;"/></td>
                <td width="507"><input type="text" style="width:500px;" align="middle" id="txtDes" name="txtDes" class="textBox" onkeypress="addNewRow(event);" tabindex="8" /></td>
              </tr>-->
            </tbody>
          </table>
		  </div>
</table>
<table border="0" align="center" class="tableFooter">
    <tr align="center">
       <td width="36">&nbsp;</td>
       <td width="36" ><img src="<?php echo $pub_url;?>images/new.png" alt="New" name="New" onclick="ClearForm();" class="mouseover" tabindex="10" id="butNew"/></td>
       <td width="36" id="tdSave" ><img  src="<?php echo $pub_url;?>images/save.png" class="mouseover" alt="Save" name="Save" onclick="butCommand(this.name);deleteBeforeSave();" id="butSave" tabindex="6"/></td>
       <td width="2"><img src="<?php echo $pub_url;?>images/delete.png" class="mouseover" alt="Delete" name="Delete" onclick="ConfirmDelete(this.name);" tabindex="7" id="butDelete" <?php if($manageFScategory){?> style="display:none" <?php }?>/></td>
       <td width="36"  class="normalfnt"><img src="<?php echo $pub_url;?>images/report.png" alt="Report" border="0" class="mouseover" onclick="loadReport();" tabindex="8" id="butReport"/></td>
       <td width="36"  id="tdDelete"><a href="<?php echo $pub_url;?>main.php"><img src="<?php echo $pub_url;?>images/close.png" alt="Close" name="Close"  border="0" id="butClose" tabindex="9"/></a></td>
	   <td width="36">&nbsp;</td>
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
