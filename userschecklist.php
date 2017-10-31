<?php

include "Connector.php";
include "HeaderConnector.php";

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1" width="100%">
<tr><td width="100%">&nbsp;</td></tr>
<tr>
	<td width="20%">&nbsp;</td>
	<?php
    	$sql = " SELECT Name FROM useraccounts WHERE status = 1 ORDER BY Name";
		
		$res_users = $db->RunQuery($sql);
		
		while($row_users = mysql_fetch_array($res_users)){
			
			echo "<td width='80%'>".$row_users["Name"]."</td>";
			
		}
	?>
</tr>
<?php
    	$sql = " SELECT RoleID, RoleName FROM role WHERE intStatus = 1";
		
		$res_roles = $db->RunQuery($sql);
		
		while($row_roles = mysql_fetch_array($res_roles)){
			
			$roleId = $row_roles["RoleID"];
			
			echo "<tr><td>".$row_roles["RoleName"]."</td>";
			
			$sqluser = " SELECT intUserID FROM useraccounts WHERE status = 1 ORDER BY Name";
		
			$res_users = $db->RunQuery($sqluser);
			
			while($row_users = mysql_fetch_array($res_users)){
				
				$intUserId = $row_users["intUserID"];
				
				$sqluseruserrole = " SELECT * FROM userpermission WHERE intUserID = ".$intUserId." AND RoleID = ".$roleId;
				
				$res_userrole = $db->RunQuery($sqluseruserrole);
				
				if(mysql_num_rows($res_userrole)>0)					
					echo "<td align='center'> X</td>";
				else
					echo "<td align='center'> &nbsp;</td>";
				
			}
			
			echo "</tr>";
			
		}
	?>
</table>


</body>
</html>