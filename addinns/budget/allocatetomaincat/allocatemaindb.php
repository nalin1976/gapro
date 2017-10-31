<?php

include "../../../Connector.php";

$request=$_GET["request"];

if($request=="save_detail")
{
	$glcode=$_GET["glcode"];
	$mainCat=$_GET["mainCat"];
	
	$sql="INSERT INTO budget_glallocationtomaincategory (intMatCatId,intGlId) VALUES ('$mainCat','$glcode');";
	
	$result = $db->RunQuery($sql);
	
	if($result)
		{
			echo "saved";
		}
		else
		{
			echo "Error" ;
		}
}

if($request=="delete_detail")
{
	$glcode=$_GET["glcode"];
	$mainCat=$_GET["mainCat"];
	
	$sql="DELETE FROM budget_glallocationtomaincategory WHERE intMatCatId='$mainCat' and intGlId='$glcode' ;";
	
	$result = $db->RunQuery($sql);
	
	if($result)
		{
			echo "saved";
		}
		else
		{
			echo "error";
		}
}

?>