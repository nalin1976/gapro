<?php 
include "../../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($RequestType=="loadOrderNowiseCutDetails")
{
	$styleId = $_GET["styleId"];
	$sql = "select intCutBundleSerial,strCutNo from productionbundleheader where intStyleId='$styleId' ";
	$str ="<option value=\"\">Select One</option>";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$str .= "<option value=\"".trim($row["intCutBundleSerial"],' ')."\">".$row["strCutNo"]."</option>";
	}
	echo $str;		
}
if($RequestType=="loadCutwiseBundleDetails")
{
	$cutNo = $_GET["cutNo"];
	$sql = "select dblBundleNo from productionbundledetails where intCutBundleSerial='$cutNo' ";
	$str ="<option value=\"\">Select One</option>";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$str .= "<option value=\"".trim($row["dblBundleNo"],' ')."\">".$row["dblBundleNo"]."</option>";
	}
	echo $str;		
}
?>
