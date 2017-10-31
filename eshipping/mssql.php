<?php
session_start();
include "Connector.php";
$sql="SELECT
cartoon.intCartoonId,
cartoon.strCartoon
FROM
cartoon
WHERE intUserId=8
";
$result=$db->RunQuery($sql);

while($row=mysql_fetch_array($result))
{
	$carton=$row['strCartoon'];
	$cartonId=$row['intCartoonId'];
	$sql1 = "SELECT DISTINCT 
			strCTN
			FROM
			shipmentpldetail
			INNER JOIN cartoon ON cartoon.intCartoonId = shipmentpldetail.strCTN
			INNER JOIN shipmentplheader ON shipmentplheader.strPLNo = shipmentpldetail.strPLNo
			WHERE strFactory='5' AND cartoon.strCartoon='$carton'
			ORDER BY strCTN
			";
	$result1 = $db->RunQuery($sql1);
	$row1 = mysql_fetch_array($result1);
	$prevCtn=$row1['strCTN'];
	if(mysql_num_rows($result1)>0)
	{
		echo $up = "UPDATE shipmentpldetail JOIN shipmentplheader ON 		shipmentplheader.strPLNo=shipmentpldetail.strPLNo SET strCTN='$cartonId' WHERE strCTN='$prevCtn' 	AND strFactory='5';";
	}

}?>