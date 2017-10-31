<?php
session_start(); 
if(isset($_SESSION["Server"]))
{
include "../Connector.php";
$userlogin = false;
include "../usertracking.php";
}
session_unset(); 
session_destroy(); 
header ("Location:mobilogin.php");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Log out</title>
</head>

<body>

</body>
</html>
