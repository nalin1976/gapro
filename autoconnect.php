<?php
	session_start();
	include "DBManager.php";
	$db =  new DBManager();
	//$db->SetConnectionString($_SESSION["Server"],$_SESSION["UserName"],$_SESSION["Password"],$_SESSION["Database"]);
	$db->SetConnectionString('localhost','root','He20La14','gapro');
        //echo $_SESSION["UserName"];
	$db->setFormName ($_SERVER["SCRIPT_NAME"]);
		
        $xml = simplexml_load_file("${backwardseperator}config.xml");
	//$xml = simplexml_load_file("../config.xml");
        //$xml = simplexml_load_file("../../config.xml");
	//$xml = simplexml_load_file("../../../config.xml");
	//$xml = simplexml_load_file("config.xml");
	$headerPub_AllowOrderStatus = $xml->SystemSettings->AllowOrderStatus;
	
	function cdata($value)
	{
		return str_replace("<","&lt;",$value);
	}
	
	//$result = $db->RunQuery("select * from bank");
	//$_SESSION['Test123'] = mysql_num_rows($result);
	//include "commonPHP/commonFunction.php";
?>