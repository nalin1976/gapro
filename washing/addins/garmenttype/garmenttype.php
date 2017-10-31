<?php
session_start();
$backwardseperator = "../../../";
include "{$backwardseperator}authentication.inc";
include "../../../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Garment Type</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="garmenttype.js"></script>
<script src="../../../javascript/script.js"></script>
</head>
<body>		

<form id="frmGarmenttype" name="frmGarmenttype" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<div class="main_bottom">
	<div class="main_top"><div class="main_text">Garment Type</div></div>
<div class="main_body">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="600" border="0" align="center">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%">
        <fieldset class="fieldsetStyle" style="width:500px;-moz-border-radius: 5px;">
        <table width="100%" border="0" class="">
          <tr>
            <td height="96">
              <table width="100%" border="0">
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp; </td>
                  <td width="67%">&nbsp;</td>		
                </tr>
                <tr>
                  <td width="8%" rowspan="6" class="normalfnt">&nbsp;</td>
                  <td width="25%" height="11" class="normalfnt">Garment Type </td>
                   <td><select name="cboSearch" class="txtbox" id="cboSearch" onchange="loadDetails(this);" style="width:160px" tabindex="1">		                 <?php
	$SQL="SELECT intGamtID ,strGarmentName FROM was_garmenttype order by strGarmentName ASC ";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intGamtID"] ."\">" . $row["strGarmentName"] ."</option>" ;
	}		  
			  
				  ?>

				  
                                                      </select></td>
                </tr>
              
				  <tr>
				  <td class="normalfnt"> Garment Name&nbsp;<span class="compulsoryRed">*</span></td>
				  <td><input name="txtGarmentName" type="text" class="txtrbox" id="txtGarmentName" style="width:160px" maxlength="100" tabindex="2"/></td>                  
				  </tr>
				  <tr>
				    <td class="normalfnt">Description&nbsp;<span class="compulsoryRed">*</span></td>
				    <td><input name="cboDescrtiption" type="text" class="txtbox" id="cboDescrtiption" onchange=""style="width:160px" tabindex="3" maxlength="100">
				      </td>
				    </tr>
				  
                  <tr>
                
                  
                      <td width="25%"  class="normalfnt">Active</td>
                      <td><input type="checkbox" name="chkActive" id="chkActive" checked="checked" tabindex="4"/></td>
                    </tr>                
                  <tr>
                  <td colspan="2" class="normalfnt">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                  </tr>
                 </table>
                 </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0"class="">
              <tr>
                <td width="100%"><table width="100%" border="0" class="tableFooter">
                    <tr>
                      <td ><img src="../../../images/new.png" alt="New" name="New"
					  width="96" height="24" onclick="ClearForm();" class="mouseover"/></td>
                      <td ><img src="../../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="butCommand(this.name);" class="mouseover" tabindex="5" id="butSave"/></td>
                      <td ><img src="../../../images/delete.png" alt="Delete" name="Delete"
					  width="100" height="24" onclick="ConfirmDelete(this.name)" class="mouseover"/></td>
                      <td class="normalfnt"><img src="../../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="ViewGarmenttypereport();"  /></td>        
                       <td ><a href="../../../main.php"><img src="../../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td> 					  	  
                               
                     </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
        </fieldset>
        </td>
       <td width="19%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</div>
 </div>
</form>
</body>
</html>
