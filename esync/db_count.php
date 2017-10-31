<?php
session_start();
include "Connector.php";

	$SQL ="SELECT count(queryID) as intCount FROM queries WHERE flag=0 ";
	$result = $db->RunQuery($SQL);
	$row = mysql_fetch_array($result);
	echo $row['intCount'];

?>