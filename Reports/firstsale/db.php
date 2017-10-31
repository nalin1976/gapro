<?php
session_start();

include "../../Connector.php";

$id=$_GET["id"];
$userId		= $_SESSION["UserID"];
$intCompanyId =$_SESSION["FactoryID"];
if ($id=="load_ord_str")
{
	$sql="select strOrderNo from firstsalecostworksheetheader where intStatus=10";
		
			$results=$db->RunQuery($sql);
			//$po_arr = "|";
			while($row=mysql_fetch_array($results))
			{
				$po_arr.= $row['strOrderNo']."|";
				 
			}
			echo $po_arr;
}
?>
