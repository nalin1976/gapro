<?php

$chemperid  = $_GET["chemperid"];
$bulkPoNo	= $_GET["bulkPoNo"];
$intYear	= $_GET["intYear"];

if($chemperid==1)
{
	include "rptChemical.php"; 
}
else
{
	include "oritgeneralpurcahseorderreport.php";
}

?>