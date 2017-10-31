<?php 
	include "../../Connector.php";
	
$RequestType	= $_GET["RequestType"];

if($RequestType=="Update")
{
$DeliveryCode	= $_GET["DeliveryCode"];
$DeliveryName	= $_GET["DeliveryName"];

$sqlupdate="update deliveryterms 
			set strDeliveryName = '$DeliveryName',
			strDeliveryCode	= '$DeliveryCode'
			where strDeliveryCode = '$DeliveryCode';";
$result_update=$db->RunQuery($sqlupdate);
echo $result_update;
}
elseif($RequestType=="Save")
{
$DeliveryCode	= $_GET["DeliveryCode"];
$DeliveryName	= $_GET["DeliveryName"];

$sqlinsert="insert into deliveryterms 
			(strDeliveryCode, 
			strDeliveryName)
			values
			('$DeliveryCode', 
			'$DeliveryName');";

$result_insert=$db->RunQuery($sqlinsert);
echo $result_insert;

}
?>