<?php
session_start();
include "../../Connector.php";
$id = $_GET["id"];

if($id=='checkDefaultCompany')
{
	$factoryId = $_GET["compId"];
	
	$sql = "select strDefaultInvoiceTo from companies where intCompanyID=$factoryId and strDefaultInvoiceTo='Yes' and intStatus<>'10'";
	$result = $db->RunQuery($sql);
	$count = mysql_num_rows($result);
	echo $count;
}
?>