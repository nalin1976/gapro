<?php 
session_start();
include "mobiauthentication.inc";
include "../Connector.php";
?>
<html>
<head><title>ePlan Mobile</title></head>
<body>
	<table border="0" celspacing="1" bgcolor="#CCCCFF">
	<tr bgcolor="#ffffff">
		<td colspan="2">Approval Pending Styles</td>
	</tr>
	<tr bgcolor="#ffffff">
		<td colspan="2">&nbsp;</td>	
	</tr>
	<tr bgcolor="#ffffff">
		<td>Style</td>	
		<td>Factory</td>
	</tr>
	<?php
	$SQL = "SELECT orders.intStyleId,orders.intCompanyID,companies.strComCode FROM orders INNER JOIN  companies ON orders.intCompanyID = companies.intCompanyID WHERE orders.intStatus = 10;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
	?>
	<tr bgcolor="#ffffff">
		<td><a href="styledetails.php?styleID=<?php echo $row["intStyleId"]; ?>"><?php echo $row["intStyleId"]; ?></td>	
		<td><?php echo $row["strComCode"]; ?></td>	
	</tr>
	<?php
	}
	?>
	</table>
</body>
</html>