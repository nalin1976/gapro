<?php
session_start();
$facId = $_SESSION["FactoryID"];
include "../Connector.php";

$id=$_GET["id"];


if($id=="saveMapHeader")
{
	$mapId = $_GET["mapId"];
	$buyer = $_GET["buyer"];
	
	if($mapId=='')
	{
	$sql = "insert into packinglist_map_header
			(
				buyerName, 
				excelTemplateName, 
				intCompany, 
				dtDate
			)
			values
			(
				'$buyer', 
				'', 
				'$facId', 
				 NOW()
			)
			";
	}
	else
	{
		$sql = "update packinglist_map_header set buyerName='$buyer' ,dtDate=NOW() where id=$mapId";
		
	}
	$result = $db->open($sql);
	$autoNo = mysql_insert_id();
	if($autoNo!=0)
		$mapId = $autoNo;
		
	if($result)
		echo $mapId;
	else
		echo 'error';
	
	$sql = "delete from packinglist_map_details where id=$mapId";
	$result = $db->open($sql);
	
}

if($id=="saveMapDetails")
{
		$mapId				= $_GET["mapId"];
		$type				= $_GET["type"];
		$cellColumnIndex	= $_GET["cellColumnIndex"];
		$cellColumnCH		= $_GET["cellColumnCH"];
		$cellRow			= $_GET["cellRow"];
		
		$sql = "insert into packinglist_map_details
				(id, 
				mapTypeId, 
				mapType, 
				`column`, 
				columnIndex,
				`row`
				)
				values
			   ('$mapId', 
				0, 
			   '$type', 
			   '$cellColumnCH', 
				$cellColumnIndex,
			   '$cellRow'
				)
				";
		$result= $db->open($sql);
		if($result)
			echo 'saved';
		else
			echo 'error';
}
?>