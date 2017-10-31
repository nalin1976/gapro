<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="350" height="120" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
  <tr class="bcgcolor-row">
    <td width="10%" >&nbsp;</td>
    <td width="90%"><span  class="normaltxtmidb2L"> Expense Type</span></td>
    <td width="10%" align="right"><img src="../../images/cross.png" alt="c" width="17" height="17" onclick="closeWindow()" class="mouseover"/></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
      <tr>
        <td width="25%" height="30">Expense</td>
        <td width="75%"><select name="popIOU" style="width:200px" id="popIOU" class="txtbox"  >
        <option value=""></option>
		  <?php
				$str = "select intExpensesID,strDescription from expensestype   ";
		
				$result = $db->RunQuery($str);
		
				
				while($row = mysql_fetch_array($result)){?>
				{
					 <option value="<?php echo $row['intExpensesID'];?>"><?php echo $row['strDescription'];?></option>
				}
							<?php }?>
        </select></td>
      </tr>
      <tr>
        <td height="25">Amount</td>
        <td><input name="txtpopamt"  class="normalfntRite txtbox" id="txtpopamt" style="width:100px" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="right"><img src="../../images/do_copy.png" alt="c" width="32" height="31" class="mouseover" onclick="expensetogrid()"/></td>
      </tr>
      
    </table></td>
    <td valign="bottom">&nbsp;</td>
  </tr>
</table>

</body>
</html>
