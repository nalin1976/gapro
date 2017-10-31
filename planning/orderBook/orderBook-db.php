<?php
include "../../Connector.php";

$id  = $_GET["id"];

if($id=='updateOrders')
{
	$styleId=$_GET['styleId'];
	$dblCuttingSmv=$_GET['dblCuttingSmv'];
	$dblSewingSmv=$_GET['dblSewingSmv'];
	$dblPackingSmv=$_GET['dblPackingSmv'];
	
	
	$sqlCheck="SELECT intStyleId FROM orders WHERE intStyleId='$styleId'";
	$resultCheck = $db->RunQuery($sqlCheck);
	if(mysql_num_rows($resultCheck)>0)
	{
	$sql="UPDATE orders
		  SET dblCuttingSmv='$dblCuttingSmv',
		  dblSewwingSmv='$dblSewingSmv',
		  dblPackingSmv='$dblPackingSmv'
		  WHERE intStyleId='$styleId'";
	
	$result = $db->RunQuery($sql);
	if(! $result)
		echo $sql;
	else
		echo 1;
	}
	else
	{
	$sql="UPDATE plan_newoders
		  SET dblCuttingSmv='$dblCuttingSmv',
		  dblSewwingSmv='$dblSewingSmv',
		  dblPackingSmv='$dblPackingSmv'
		  WHERE strStyleId='$styleId'";
	
	$result = $db->RunQuery($sql);
	if(! $result)
		echo $sql;
	else
		echo 1;
	}
}

?>