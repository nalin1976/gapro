<?php 
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];
if ($RequestType=="LoadSubCatDetails")
{
	$mainCat = $_GET["mainCat"];
	$ResponseXML .="<LoadSubCat>\n";
	$SQL="SELECT * FROM matsubcategory where intCatNo='$mainCat' and intStatus=1 order by StrCatName";
	
	$result=$db->RunQuery($SQL);
	
	while ($row=mysql_fetch_array($result))
	{		
		 $ResponseXML .= "<SubID><![CDATA[" . $row["intSubCatNo"]  . "]]></SubID>\n";
		 $ResponseXML .= "<Name><![CDATA[" . $row["StrCatName"]  . "]]></Name>\n";
	}
	$ResponseXML .="</LoadSubCat>";
	echo $ResponseXML;
}

if ($RequestType=="getGroupedItemDetails")
{
	$groupID   = $_GET["groupid"];
	$subCat    = $_GET["subCat"];
	
	$ResponseXML .="<groupedItemsDetails>\n";
	$SQL = "Select m.matDetailId from matitemgroupdetails m inner join matitemlist mt on 
				m.matDetailId = mt.intItemSerial
				 where groupID = '$groupID' and intSubCatID='$subCat'";
	//echo $SQL;			 
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<matID><![CDATA[" . $row["matDetailId"]  . "]]></matID>\n";
	}
	
	 $ResponseXML .="</groupedItemsDetails>";
	echo $ResponseXML;
}


if ($RequestType=="LoadItemDetails")
{
	$mainCat = $_GET["mainCat"];
	$subCat  = $_GET["SubCat"];
	$ResponseXML .="<LoadItem>\n";
	$SQL="SELECT intItemSerial,strItemCode,strItemDescription FROM matitemlist
         WHERE intMainCatID='$mainCat' AND intSubCatID='$subCat' AND intStatus=1 Order by strItemDescription";
	
	$result=$db->RunQuery($SQL);
	
	while ($row=mysql_fetch_array($result))
	{		
		 $ResponseXML .= "<ItemSerial><![CDATA[" . $row["intItemSerial"]  . "]]></ItemSerial>\n";
		 $ResponseXML .= "<ItemCode><![CDATA[" . $row["strItemCode"]  . "]]></ItemCode>\n";
		 $ResponseXML .= "<ItemName><![CDATA[" . $row["strItemDescription"]  . "]]></ItemName>\n";
	}
	$ResponseXML .="</LoadItem>";
	echo $ResponseXML;
}



if ($RequestType=="SaveGroup")
{

	$groupName = $_GET["groupName"];
	$ResponseXML .="<LoadGroupSaveDet>\n";
	
	$Response = '';
	if(checkGroupAvailability($groupName) == 1)
	{
		$Response = "AV";
		$ResponseXML .= "<GroupSave><![CDATA[" . $Response  . "]]></GroupSave>\n";
	}
	else
	{
		SaveGroupDet($groupName);
		$Response = "Save";
		$ResponseXML .= "<GroupSave><![CDATA[" . $Response  . "]]></GroupSave>\n";
		$maxID = getMaxGroupID();
		$ResponseXML .= "<GroupMaxID><![CDATA[" . $maxID  . "]]></GroupMaxID>\n";
	}
	$ResponseXML .="</LoadGroupSaveDet>";
	echo $ResponseXML;
}



if ($RequestType=="GroupComb")
{
	$mainCat = $_GET["mainCat"];
	$ResponseXML .="<LoadSGroup>\n";
	
	$SQL="SELECT * FROM matitemgroup ";
	
	$result=$db->RunQuery($SQL);
	
	while ($row=mysql_fetch_array($result))
	{		
		 $ResponseXML .= "<GroupID><![CDATA[" . $row["matItemGroupId"]  . "]]></GroupID>\n";
		 $ResponseXML .= "<GroupName><![CDATA[" . $row["matItemGroupName"]  . "]]></GroupName>\n";
	}
	$ResponseXML .="</LoadSGroup>";
	echo $ResponseXML;
}



if ($RequestType=="SaveGroupMatItemDetails")
{
	$matItemid = $_GET["matId"];
	$groupID   = $_GET["groupName"];
	
	$SQL = "insert into matitemgroupdetails 
	(matDetailId, 
	groupID
	)
	values
	('$matItemid', 
	'$groupID'
	)";
	
	$result=$db->RunQuery($SQL);
}

else if ($RequestType=="DeleteResponse")
{
	$groupID   = $_GET["groupName"];
	$ResponseXML .="<delResponse>\n";
	$res = detleteItemDetails($groupID);
	if($res == '1')
	{
		$result = 'del';
	}
	else 
	{
		$result = 'NA';
	}
	 $ResponseXML .= "<Delresult><![CDATA[" . $result  . "]]></Delresult>\n";
	 $ResponseXML .="</delResponse>";
	echo $ResponseXML;
}





function checkGroupAvailability($GrpName)
{
	$SQL = "Select * from matitemgroup    where matItemGroupName = '$GrpName'";
	//echo $SQL;
	global $db;
	return $db->CheckRecordAvailability($SQL);
}

function SaveGroupDet($GrpName)
{
	$SQL = "insert into matitemgroup 
	(matItemGroupName
	)
	values
	('$GrpName')";
	
	global $db;
	
	return $db->RunQuery($SQL);
}

function getMaxGroupID()
{
	$SQL = "select max(matItemGroupId) as maxid from matitemgroup";
	global $db;
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["maxid"];
}
function detleteItemDetails($groupID)
{
	$SQL = "Delete from matitemgroupdetails where groupID = $groupID";
	global $db;
	$result=$db->RunQuery($SQL);
}
?>