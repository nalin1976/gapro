<?php
session_start();
$backwardseperator = "../";
include "$backwardseperator".''."Connector.php";
header('Content-Type: text/xml'); 	
$request=$_GET["request"];

if ($request=='save_ratio')
{
	$style		=$_GET['style'];
	$size		=$_GET['size'];
	$desc		=$_GET['plno'];
	$pcs		=$_GET['pcs'];
	$gross		=$_GET['gross'];
	$net		=$_GET['net'];
	$netnet		=$_GET['netnet'];
	$color		=$_GET['color'];
	
	$str		="insert into style_ratio_plugin 
										(strStyle, 
										strSize, 
										strDesc, 
										dblNet, 										
										dblPcs,
										strColor
										)
										values
										('$style', 
										'$size', 
										'$desc',										
										'$net', 										 
										'$pcs',
										'$color'
										);
									";
	$result		=$db->RunQuery($str);
	if($result)
		echo 'saved';
}

if ($request=='delete_first')
{
	$style		=$_GET['style'];
		
	$str		="delete from style_ratio_plugin 	where strStyle ='$style'";
	$result		=$db->RunQuery($str);
	if($result)
		echo 'deleted';
}


?>