<?php
session_start();
include "authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Preorder</title>
<script type="text/javascript">

function showPreorder(style)
{
	location = "editpreorder.php?StyleNo=" + style;
}

</script>

<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style></head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="4%"><div align="center"><img src="images/butt_1.png" width="15" height="15" /></div></td>
          <td width="96%" class="head1">Preorder to be Modified</td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
            <tr>
              <td width="30%" height="29" bgcolor="#498CC2" class="normaltxtmidb2">Style No</td>
              <td width="24%" bgcolor="#498CC2" class="normaltxtmidb2">Style Name </td>
              <td width="28%" bgcolor="#498CC2" class="normaltxtmidb2">Last Saved Date </td>
              <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">View</td>
            </tr>
			<?php

			include "Connector.php";
			 
			
			$SQL = "SELECT intStyleId, strDescription, dtmDate FROM orders where intUserID = " .  $_SESSION["UserID"] . " AND intStatus = 0;";
	
			$result = $db->RunQuery($SQL);
			
			while($row = mysql_fetch_array($result))
			{
				echo " <tr>" .
			         "<td class=\"normalfnt\">" . $row["intStyleId"] . "</td>" .
             		 "<td class=\"normalfntMid\">" . $row["strDescription"] . "</td>" .
              		 "<td class=\"normalfntMid\">" . $row["dtmDate"] . "</td>" .
              		 "<td><div align=\"center\"><img id=\"" . $row["intStyleId"] . "\" src=\"images/view.png\" alt=\"view\" width=\"91\" height=\"19\" onClick=\"showPreorder(this.id);\" /></div></td>" .
            		 "</tr>" ;
			}
			
			?>

          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
