<?PHP
session_start();
include("../../../Connector.php");	
	$RequestType	= $_GET["RequestType"];
	$CompanyId  	= $_SESSION["FactoryID"];
	$UserId			= $_SESSION["UserID"];

if($RequestType=="SaveDetails")
{
$deliveryNo 	= $_GET["deliveryNo"];
$entryNo		= $_GET["entryNo"];
$merchandiser 	= $_GET["merchandiser"];
$locationOfGood = $_GET["locationOfGood"];
$clearedBy 		= $_GET["clearedBy"];
$clearedOn 		= $_GET["clearedOn"];
$styleID 		= $_GET["styleID"];

$sql="update deliverynote 
	set strEntryNo='$entryNo',
	strMerchandiser='$merchandiser',
	strLocationOfGoods='$locationOfGood',
	dtmClearedOn=now(),
	intClearedBy='$clearedBy',
	strStyleId='$styleID',
	intStatus=1
	where
	intDeliveryNo = '$deliveryNo'";

$result=$db->RunQuery($sql);
echo $result;
}
elseif($RequestType=="Cancel")
{

$deliveryNo 	= $_GET["deliveryNo"];

$sql="update deliverynote
	SET intStatus=0
	where
	intDeliveryNo = '$deliveryNo'";

$result=$db->RunQuery($sql);
echo $result;
}
?>