<?php
session_start();
include "../../Connector.php";



$RequestType = $_GET["RequestType"];

if ($RequestType=="save")
{
	$styleId          = $_GET["styleId"];
	$styledescription = $_GET["styledescription"];
	$status			  = $_GET["status"];
	
		if($styleId!="")
		{
			$updateSQL = "UPDATE styledocumenttypes SET strdescription='$styledescription',intStatus=$status WHERE id=$styleId";
			$result = $db->RunQuery($updateSQL);
			if($result)
				echo "1";
			else
				echo "0";
		}
		else
		{
			$SQL    = "INSERT INTO styledocumenttypes (strdescription,intStatus) VALUES('$styledescription',$status)";
			$result = $db->RunQuery($SQL);
	
			if($result)
				echo "1";
			else
				echo "0";
		}
}
else if ($RequestType=="delete")
{
	$styleId = $_GET["styleId"];
	$SQL     = "DELETE FROM styledocumenttypes WHERE id=$styleId";
	$result  = $db->RunQuery($SQL);
	
	if($result)
		echo "1";
	else
		echo "0";
}
?>