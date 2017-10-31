<?php
session_start();
include "LoginDBManager.php";
include "Connector.php";
$dbepl =  new LoginDBManager();
$userRequest = false;
$pword = md5($_POST["txtPassword"]);
$userID = "";
if(isset($_SESSION['changingUser']))
{
	$userID = $_SESSION["changingUser"];
}
else
{
	$userRequest = true;
	$userID = $_SESSION["UserID"];
}

$sql = "update users set Password = '$pword' where UserID = '$userID';";
$dbepl->ExecuteQuery($sql);

$sql = "update useraccounts set Password = '$pword' where intUserID ='$userID';";
$db->ExecuteQuery($sql);

unset($_SESSION['changingUser']); 

if(!$userRequest)
	echo "<META HTTP-EQUIV=\"Refresh\" Content=\"0; URL=permissionManager.php?userID=$userID\">";
else
	echo "<b>Your password has beeen changed successfully. Please close this tab or popup.</b>";




?>