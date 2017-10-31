<?php
$backwardseperator = "../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reason Codes</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="reasonCodes.js"></script>
<script src="../../javascript/script.js"></script>
<style type="text/css">
<!--
.style1 {color: #800040}
-->
</style>
</head>

<body>
<?php
include('../../Connector.php');
?>
<table width="100%"  border="0" align="center" bgcolor="#FFFFFF">
	<tr>
    	<td><?php include('../../Header.php'); ?></td>
    </tr>
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td width="19%">&nbsp;</td>
                	<td  width="62%">
                    	<table width="550" border="0" class="tableBorder" align="center">
                        	<tr>
                            	<td height="35" class="mainHeading">Reason Codes</td>
                            </tr>
                            <tr>
                            	<td><table width="90%" border="0" align="center">
                            	  <tr>
                            	    <td class="normalfnt">Search</td>
                            	    <td><select class="txtbox" value="" id="reasonCodes_cboReasonCode" name="reasonCodes_cboReasonCodes" style="width:150px;" onchange="loadData();">
                            	      <option value=""></option>
                            	      <?php
                                                $sql_loadReasonCodes="SELECT intResonCodeId,strCode FROM tblreasoncodes  GROUP BY strCode;"	;				$res=$db->RunQuery($sql_loadReasonCodes);
												while($row=mysql_fetch_array($res))
												{
												?>
                            	      <option value="<?php echo $row['intResonCodeId'];?>"><?php echo $row['strCode'];?></option>
                            	      <?php }  ?>
                          	      </select></td>
                          	    </tr>
                            	  <tr>
                            	    <td class="normalfnt">Reason Code <span class="compulsoryRed">*</span></td>
                            	    <td><input type="text" class="txtbox" style="width:150px;" id="reasonCodes_txtReasonCode" name="reasonCodes_txtReasonCode" maxlength="10"/></td>
                          	    </tr>
                            	  <tr>
                            	    <td class="normalfnt"> Description <span class="compulsoryRed">*</span></td>
                            	    <td><input type="text" class="txtbox" style="width:300px;" id="reasonCodes_txtReasonDescription" name="reasonCodes_txtReasonDescription"  maxlength="50"/></td>
                          	    </tr>
                                <tr>
                                	<td class="normalfnt">Active</td>
                                    <td><input type="checkbox" name="reasonCode_chkActive" id="reasonCode_chkActive" checked="checked" tabindex="5" /></td>
                                </tr>
                            	  <tr>
                            	    <td colspan="2" valign="top"><table border="0" width="100%" id="tblProcesses" class="bcgl1" cellspacing="1" bgcolor="#CCCCFF">
                            	      <tr class="mainHeading4">
                            	        <th style="width:10px;" height="20">&nbsp;</th>
                            	        <th style="width:10px;">Code</th>
                            	        <th style="width:300px;" class="">Process</th>
                            	        <th width="20" class=""><img src="../../images/add.png" onclick="openProcessesPopUp()" style="cursor:pointer;" /></th>
                          	        </tr>
                            	      <?php 
													$sql_loadPrc="SELECT intCode,strProcessName FROM tblprocesses WHERE intStatus != 10;";
													$res=$db->RunQuery($sql_loadPrc);
													while($row=mysql_fetch_array($res))
													{?>
                            	      <tr class="bcgcolor-tblrowWhite" onmouseover="this.style.backgroundColor='#A9F097';" onmouseout="this.style.backgroundColor='#FFFFFF';" >
                            	        <td height="20" class="normalfntMid"><img src="../../images/del.png" id="<?php echo $row['intCode'];?>"  onclick="removeRow(this)"/></td>
                            	        <td class="normalfntR" ><?php echo $row['intCode'];?></td>
                            	        <td class="normalfnt" onclick="editProcess(this);"><?php echo $row['strProcessName'];?></td>
                            	        <td class="normalfntMid"><input type="checkbox" id="<?php echo "chk".$row['intCode'];?>"/></td>
                          	        </tr>
                            	      <?php }?>
                          	      </table></td>
                            	   
                          	    </tr>
                            	  <tr>
                            	    <td height="21" colspan="2" bgcolor=""><table width="100%" border="0" class="tableFooter">
                            	      <tr>
                            	        <td width="7%">&nbsp;</td>
                            	        <td width="22%"><img src="../../images/new.png" alt="New" width="100" height="24" name="New"onclick="ClearForm();"/></td>
                            	        <td width="20%"><img src="../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="saveReasonCodes();"/></td>
                            	        <td width="23%"><img src="../../../gapro/images/delete.png" onclick="deleteReson();" /></td>
                            	        <td width="28%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                          	        </tr>
                          	      </table></td>
                          	    </tr>
                          	  </table></td>
                            </tr>
                        </table>
                  </td>
                    <td width="19%">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>