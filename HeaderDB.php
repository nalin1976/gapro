<?php
session_start();

$id = $_GET["id"];

if($id=='changeCompany')
{
	$factoryId = $_GET["factoryId"];
	$_SESSION["FactoryID"] 	=	$factoryId;
	echo $_SESSION["FactoryID"];
}
?>