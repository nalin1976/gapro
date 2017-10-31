<?php
session_start();
$backwardseperator = "../../../";
include('../../../Connector.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro :: Washilg-Addins-Wash Type</title>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="washType.js"></script>
<script src="../../../javascript/jquery.js"></script>
<script src="../../../javascript/script.js"></script>
</head>

<body>

<form id="frmWashType" name="frmWashType" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<div class="main_bottom">
	<div class="main_top"><div class="main_text">Wash Type</div></div>
<div class="main_body">
<table width="100%"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td align="center">        
        	<table  width="500" border="0">
            	<tr>
                	<td>
                	<fieldset class="fieldsetStyle" style="width:500px;-moz-border-radius: 5px;">
                    	<table width="100%" border="0" class="">
                            <tr>
                            	<td>
                                	<table width="450" border="0" align="center">
                                    <tr>
                                    <td width="116" class="normalfnt" >Search</td>
                                    <td width="324" ><select style="width:167px" class="txtbox" id="washType_cboSearchWashType" name="washType_cboSearchWashType" onchange="loadWashType(this.id);" >
                                    	  <option> </option>
                                    	  <?php
                                            $sql_loadWashDets="SELECT intWasID,strWasType FROM was_washtype; ";
                                            $resW=$db->RunQuery($sql_loadWashDets);
                                            while($row=mysql_fetch_array($resW))
                                            {?>
                                    	  <option value="<?php echo $row['intWasID']; ?>"><?php echo $row['strWasType']; ?></option>
                                    	  <?php }?>
                                  	  </select></td>
                                      </tr>
                           			<tr>
                            	<td class="normalfnt" >Wash Type <span class="compulsoryRed">*</span></td>
                                <td class="normalfnt" ><input type="text" style="width:165px" class="txtbox" id="washType_txtWashType" name="washType_txtWashType" maxlength="30" /></td>
                            </tr>
                            <tr>
                            	<td class="normalfnt" >Unit Price <span class="compulsoryRed">*</span></td>
                                <td class="normalfnt" ><input type="text" style="width:100px;text-align:right;" class="txtbox"  id="washType_txtWashUnitPrice" name="washType_txtWashUnitPrice" onkeypress="return CheckforValidDecimal(this.value,3,event); " onkeyup="checkfirstDecimal(this);" onchange="checkLastDecimal(this);" maxlength="10"/></td>
                            </tr>
                            <tr>
                            	<td class="normalfnt">Active</td><td><input type="checkbox" class="txtbox"  id="washType_chkActInAct" name="washType_chkActInAct"/></td>
                            </tr>
                            		</table>                            	</td>
                            </tr>
                            <tr>
                            	<td align="center">
                                    <table>
                                        <tr>
                                            <td><img src="../../../images/new.png" onclick="ClearWashTypeForm();"/></td>
                                            <td><img src="../../../images/save.png" onclick="saveWashType();" /></td>
                                            <td><img src="../../../images/delete.png" onclick="deleteWashType();" /></td>
                                            <td><img src="../../../images/report.png" onclick="washTypeReport();"/></td>
                                            <td><a href="../../../main.php"><img src="../../../images/close.png" width="97" height="24" border="0" class="mouseover"/></a></td>
                                        </tr>
                                    </table>                                </td>
                            </tr>
                         </table>
                         </fieldset>
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