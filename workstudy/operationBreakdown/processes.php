<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<script src="ajaxupload.js"></script>
<script src="Operation.js"></script>
<script src="../../javascript/script.js"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
</head>

<body>
<table width="450" border="0" cellspacing="4" cellpadding="0" bgcolor="#FFFFFF" height="200" >
  <tr>
    <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1 normalfnt">
      <tr>
        <td colspan="2" ><div align="right"><img src="../../images/closelabel.gif" alt="close" width="66"  onclick="close_process();" /></div></td>
      </tr>
      <tr>
        <td colspan="2" class="mainHeading" style="text-align:center"> Processes</td>
        </tr>
      <tr>
        <td width="35%">&nbsp;</td>
        <td width="65%">&nbsp;</td>
      </tr>
      <tr>
        <td height="35"><dd>Process</td>
        <td><select name="cmbPopProcessId" class="txtbox" id="cmbPopProcessId" style="width:230px" onchange=" getProcess();">
          <option value=""></option>
          <?php 
			$str="select intProcessId,strProcess from ws_processes order by intProcessId ASC";
		
			$results=$db->RunQuery($str);
			
			while($row=mysql_fetch_array($results))
			{
		?>
          <option value="<?php echo $row['intProcessId'];?>"><?php echo $row['strProcess'];?></option>
          <?php } ?>
        </select></td>
      </tr>
      <tr>
        <td height="25"><dd>Process<span class="compulsoryRed"> *</span></dd></td>
        <td><input name="txtPopProcess" type="text" class="txtbox" id="txtPopProcess" style="width:230px;" tabindex="2" maxlength="50"/></td>
      </tr>
      <tr>
        <td height="25"><dd>Description</dd></td>
        <td><input name="txtPopDscr" type="text" class="txtbox" id="txtPopDscr" style="width:230px;" tabindex="2" maxlength="100"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="37%"><div align="right"><img src="../../images/new.png" alt="n" width="96" height="24" class="mouseover" onclick="clear_processes()"/></div></td>
            <td width="25%"><div align="center"><img src="../../images/save.png" alt="s" width="84" height="24" class="mouseover" onclick="dosaveprocess()"/></div></td>
            <td width="38%"><div align="left"><img src="../../images/delete.png" alt="d" width="100" height="24" class="mouseover" onclick="delete_Process()"/></div></td>
            </tr>
          
        </table></td>
        </tr>
        <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>


</body>
</html>
