<?php 

session_start();

include "../Connector.php";

global $db;

	$SQL = "select Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		$user_name = $row["Name"];
	}

	 echo "Report Date - ". date("Y-m-d") . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; User Id - ".$user_name;
?>