<?php
include "mobiauthentication.inc";
include "../HeaderConnector.php";
include "../permissionProvider.php";
?>

<html>
<head><title>ePlan Mobile</title></head>
<body>
	<table>
	<tr>
		<td>Welcome - ePlan Mobile</td>
	</tr>
	<tr>
		<td>&nbsp;</td>	
	</tr>
	<?php
	if($approvalPreOrder)
	{
	?>
	<tr>
		<td><a href="pendinglist.php">Pre Order Approval</a></td>	
	</tr>
	<?php
	}
	?>
	<tr>
		<td>&nbsp;</td>	
	</tr>
	<tr>
		<td><a href="mobilogout.php">Log out</a></td>	
	</tr>
	</table>
</body>
</html>
