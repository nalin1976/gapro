<?php
$backwardseperator = "../../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src=".js"></script>
</head>

<body>

<?php
include "../../../Connector.php";

?>
<table width="100%"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder">
                        	<tr><td align="right" colspan="3"><img src="../../../images/closelabel.gif" onclick="CloseWindow();" style="width:40px;" /></td></tr>
                        	<tr class="cursercross" onmousedown="grab(document.getElementById('frmWashType'),event);">
                            	<td height="35" class="mainHeading" colspan="3">Wash Type</td>
                            </tr>
                            <tr>
                            	<td>
                                	<table border="0">
                                    	<td class="normalfnt"  style="width:80px;">Search</td><td  style="width:100px;">
                                        <select style="width:100px;" class="txtbox" id="cboSearchWashType" name="cboSearchWashType" onchange="loadWashType(this.id);" >
                                        	<option>  </option> 
                                            <?php
                                            $sql_loadWashDets="SELECT intWasID,strWasType FROM was_washtype; ";
                                            $resW=$db->RunQuery($sql_loadWashDets);
                                            while($row=mysql_fetch_array($resW))
                                            {?>
                                            	<option value="<?php echo $row['intWasID']; ?>"><?php echo $row['strWasType']; ?></option>
                                            <?php }?>
                                        </select></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	<table border="0">
                           					<tr>
                            	<td class="normalfnt" style="width:80px;">Wash Type</td><td><input type="text" style="width:100px;" class="txtbox" id="txtWashType" name="txtWashType" /></td>
                            </tr>
                            <tr>
                            	<td class="normalfnt">Unit Price</td><td><input type="text" style="width:100px;" class="txtbox"  id="txtUnitPrice" name="txtUnitPrice"/></td>
                            </tr>
                            		</table>
                            	</td>
                            </tr>
                            <tr>
                            	<td colspan="2" align="center">
                                <table>
                                    <tr>
                                        <td>
                                        	<img src="../../../images/new.png" onclick="clearWashTypeForm();"/>
                                        </td>
                                        <td>
                                        	<img src="../../../images/save.png" onclick="saveWashType();" />
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                         </table>
                    </td>
                </tr>
            </table>
         </td>
     </tr>
</table>
</body>
</html>