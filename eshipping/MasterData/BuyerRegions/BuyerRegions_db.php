<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";

$id=$_GET['id'];

if($id=='saveData')
{

	$cboSearch = $_GET['cboSearch'];
	$txtDescription = $_GET['txtDescription'];

	
	if($cboSearch=="")
	{
		$sql="INSERT INTO buyerregion(strBuyerRegion)VALUES('$txtDescription')";
		$result=$db->RunQuery($sql);
		
		$row=mysql_fetch_array($result);
	
		echo "Saved Successfully";
	}
	else
	{
		$s_sql="UPDATE buyerregion SET strBuyerRegion='$txtDescription' WHERE intBuyerRegionId=$cboSearch";
		$r_result=$db->RunQuery($s_sql);
		
		$r_row=mysql_fetch_array($r_result);
	
		echo "Update Successfully";
	}
}	
	
	
	
	if($id=='dataRetrive')	
	{
	
	$cboSearch=$_GET['cboSearch'];
	$sql="SELECT strBuyerRegion FROM buyerregion WHERE intBuyerRegionId=$cboSearch;";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	
	echo $row["strBuyerRegion"];

	}
	
	if($id=='delete')
	{
		$cboSearch=$_GET['cboSearch'];
		$sql_l="DELETE FROM buyerregion WHERE intBuyerRegionId=$cboSearch";
		$result_t=$db->RunQuery($sql_l);
		$row_w=mysql_fetch_array($result_t);
	
		echo "Delete Successfully";

		}
?>