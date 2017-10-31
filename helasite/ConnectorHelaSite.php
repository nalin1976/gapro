<?php
	session_start();
	include "DBManagerHelaSite.php";
	$dbHelaSite =  new DBManagerHelaSite();
	$dbHelaSite->SetConnectionString('172.23.1.136','root','He20La14','hela_admin');
	$dbHelaSite->setFormName ($_SERVER["SCRIPT_NAME"]);
		
	//$xml = simplexml_load_file("${backwardseperator}config.xml");
	//$xml = simplexml_load_file("../config.xml");
	//$xml = simplexml_load_file("../../config.xml");
	//$xml = simplexml_load_file("../../../config.xml");
	//$xml = simplexml_load_file("config.xml");
	//$headerPub_AllowOrderStatus = $xml->SystemSettings->AllowOrderStatus;
	
	/*function cdata($value)
	{
		return str_replace("<","&lt;",$value);
	}*/
	
	//$result = $db->RunQuery("select * from bank");
	//$_SESSION['Test123'] = mysql_num_rows($result);
	//include "commonPHP/commonFunction.php";
?>