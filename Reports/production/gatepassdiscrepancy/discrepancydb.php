<?php
include "../../../Connector.php";

$requestType = $_GET["RequestType"];

if($requestType=="LoadOrderNo")
{
$styleNo	= $_GET["StyleNo"];

	$SQL = "select distinct O.intStyleId,O.strOrderNo from productiongpheader PGH inner join orders O on O.intStyleId=PGH.intStyleId ";
if($styleNo!="")
	$SQL .= "and O.strStyle='$styleNo' ";
	
	$SQL .= "order by O.strOrderNo;";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
	}
}
elseif($requestType=="LoadSCNo")
{
$styleNo	= $_GET["StyleNo"];

$SQL="select distinct S.intStyleId,S.intSRNO from productiongpheader PGH inner join specification S on S.intStyleId=PGH.intStyleId
inner join orders O on O.intStyleId=PGH.intStyleId ";
if($styleNo!="")
	$SQL .= "and O.strStyle='$styleNo' ";
	
$SQL .= "order by S.intSRNO DESC";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
	}
	
}
?>