<?php
include('../../../Connector.php');
$request=$_GET['req'];
$cboWashType=$_GET['cboWashType'];
$washType=$_GET['washType'];
$unitPrice=$_GET['unitPrice'];
$status=$_GET['status'];

if($request=="saveType")
{
	$sql_insert="INSERT INTO was_washtype(strWasType,dblUnitPrice,intStatus) VALUES('$washType','$unitPrice','$status');";
	$resInsert=$db->RunQuery($sql_insert);
	if($resInsert==1)
	{
		echo "Saved successfully.";
	}
}
elseif($request=="update")
{
		$sql_update="UPDATE was_washtype SET strWasType='$washType',dblUnitPrice='$unitPrice',intStatus='$status' WHERE intWasID='$cboWashType';";
		$resUpdate=$db->RunQuery($sql_update);
		if($resUpdate==1)
		{
			echo "Updated successfully.";
		}
}
elseif($request=="delete")
{
		$sql_delete="DELETE FROM was_washtype WHERE intWasID='$cboWashType';";
		$resDelete=$db->RunQuery($sql_delete);
		if($resDelete==1)
		{
			echo "Deleted successfully.";
		}
}
elseif($request=="loadDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<XMLWashType>";

	$SQL="SELECT strWasType,dblUnitPrice,intStatus FROM was_washtype WHERE intWasID='".$cboWashType."';";	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
        $ResponseXML .= "<strWasType><![CDATA[" . $row["strWasType"]  . "]]></strWasType>\n";
        $ResponseXML .= "<dblUnitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></dblUnitPrice>\n";
		$ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n";
	}	
	 $ResponseXML .= "</XMLWashType>";
	 echo $ResponseXML;
}
?>