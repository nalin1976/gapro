<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
include('../../Connector.php');
include("class.subContractRcvdList.php");
$wrsr=new washReceiveSummary();

$req=$_GET['req'];

if(strcmp($req,"getStyle")==0){
	$po=$_GET['po'];
	$res=$wrsr->getStyle($po);
	$row=mysql_fetch_assoc($res);
	echo $row['strStyle'];
}
if(strcmp($req,"getPo")==0){
	$style=$_GET['style'];
	$res=$wrsr->getPo($style);
	$row=mysql_fetch_assoc($res);
	echo $row['intStyleId'];
}

?>