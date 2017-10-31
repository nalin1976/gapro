<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


$RequestType = $_GET["str"];

if (strcmp($RequestType,"subCategoryID") == 0) 
{
	 $ResponseXML .= "<RequestDetails>\n";
	 $subCatID = $_GET["subCat"];
	 $sql = "select intSubCatNo,StrCatCode, 
	StrCatName, 
	intDisplay, 
	intInspection, 
	intAdditionalAllowed,
	intStatus from matsubcategory where intSubCatNo='".$subCatID."';";
		
	 $result = $db->RunQuery($sql);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<CatID><![CDATA[" . $row["intSubCatNo"]  . "]]></CatID>\n"; 
         $ResponseXML .= "<CatCode><![CDATA[" . $row["StrCatCode"]  . "]]></CatCode>\n";   
		 $ResponseXML .= "<CatName><![CDATA[" . $row["StrCatName"]  . "]]></CatName>\n";  
		 $ResponseXML .= "<Display><![CDATA[" . $row["intDisplay"]  . "]]></Display>\n";   
		 $ResponseXML .= "<Inspection><![CDATA[" . $row["intInspection"]  . "]]></Inspection>\n"; 
		 $ResponseXML .= "<AdditionalAllowed><![CDATA[" . $row["intAdditionalAllowed"]  . "]]></AdditionalAllowed>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
	 }
	 
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}

else if (strcmp($RequestType,"subcat") == 0)
{
		
		$XMLProperty.= "<Property>";
		
		$Subcatid = $_GET["subcatid"];

			$SQL_property="SELECT matproperties.intPropertyId, matproperties.strPropertyName, matsubcategory.intSubCatNo FROM (matproperties INNER JOIN matpropertyassign ON matproperties.intPropertyId = matpropertyassign.intPropertyId) INNER JOIN matsubcategory ON matpropertyassign.intSubCatId = matsubcategory.intSubCatNo WHERE (((matsubcategory.intSubCatNo)=".$Subcatid.")) order by intOrderBy;";

			
			/*		$SQL_property="SELECT matproperties.intPropertyId, matproperties.strPropertyName, matsubcategory.intSubCatNo,matsubcategory.intCatNo
FROM (matproperties INNER JOIN matpropertyassign ON matproperties.intPropertyId = matpropertyassign.intPropertyId) INNER JOIN matsubcategory ON matpropertyassign.intSubCatId = matsubcategory.intSubCatNo
WHERE (((matsubcategory.intSubCatNo)=".$Subcatid."));*/
			
			$result = $db->RunQuery($SQL_property);
			while($row = mysql_fetch_array($result))
			{
				 $XMLProperty .= "<PropertyId><![CDATA[" . $row["intPropertyId"]  . "]]></PropertyId>\n";
				 $XMLProperty .= "<PropertyName><![CDATA[" . $row["strPropertyName"]  . "]]></PropertyName>\n";
						
			 
			}
			 $XMLProperty .= "</Property>";
			 echo $XMLProperty;	 
			 
}
else if (strcmp($RequestType,"getPropValues") == 0) 
{
	 $ResponseXML = "";
	 $propID = $_GET["PropID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getPropertyValues($propID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
         $ResponseXML .= "<PropID><![CDATA[" . $row["intSubPropertyNo"]  . "]]></PropID>\n";   
		 $ResponseXML .= "<PropName><![CDATA[" . $row["strSubPropertyName"]  . "]]></PropName>\n";               
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}

else if (strcmp($RequestType,"getOtherProperties") == 0) 
{
	 $ResponseXML = "";
	 $propID = $_GET["PropID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getOtherPropertyValues($propID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
         $ResponseXML .= "<PropID><![CDATA[" . $row["intSubPropertyNo"]  . "]]></PropID>\n";   
		 $ResponseXML .= "<PropName><![CDATA[" . $row["strSubPropertyName"]  . "]]></PropName>\n";               
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
else if (strcmp($RequestType,"getOtherPropertiesWithSearchText") == 0) 
{
	 $ResponseXML = "";
	 $propID = $_GET["PropID"];
	 $searchTxt = $_GET["searchTxt"];
	 
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getOtherPropertyValuesSearchText($propID,$searchTxt);
	 
	 while($row = mysql_fetch_array($result))
  	 {
         $ResponseXML .= "<PropID><![CDATA[" . $row["intSubPropertyNo"]  . "]]></PropID>\n";   
		 $ResponseXML .= "<PropName><![CDATA[" . $row["strSubPropertyName"]  . "]]></PropName>\n";               
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
else if (strcmp($RequestType,"SaveMaterial") == 0) 
{
	$ItemCode  = $_GET["ItemCode"];
	$ItemName = $_GET["ItemName"];
	$MainCatID = $_GET["MainCatID"];
	$subCatID = $_GET["subCatID"];
	$Wastage = $_GET["Wastage"];
	$unitID = $_GET["unitID"];
	$useID = $_SESSION["UserID"];
	$propIDlist = $_GET["propIDlist"];
	
	//propValueIdList//////////////////////////////
	$propValueIdList = $_GET["propValueIdList"];
	$arrPropertyValueIdList;
	$i=0;
	$token = strtok($propValueIdList, ",");			
	while ($token != false)
	{	
		$arrPropertyValueIdList[$i]=$token;
		$token = strtok(",");
		$i++;
	}
	//////////////////////////////////////////////
	$purchaseUnit = $_GET["purchaseID"];
	$unitPrice = $_GET["unitPrice"];
	$ArrPropId;
	$i=0;
	$token = strtok($propIDlist, ",");			
	while ($token != false)
	{	
		$ArrPropId[$i]=$token;
		$token = strtok(",");
		$i++;
	}
	
	$displayStrList = $_GET["displayStrList"];
	$arrDisplayStrList;
	$i=0;
	$token = strtok($displayStrList, ",");
	while($token != false)
	{
	 $arrDisplayStrList[$i] = $token;
	 $token = strtok(",");
	 $i++;
	}
	
	$strBeforeAfterList = $_GET["strBeforeAfterList"];
	$arrBeforeAfterList;
	$i=0;
	$token = strtok($strBeforeAfterList, ",");
	while($token != false)
	{
	 $arrBeforeAfterList[$i] = $token;
	 $token = strtok(",");
	 $i++;
	}
	
	$serialList = $_GET["serialList"];
	$arrSerialList;
	$i=0;
	$token = strtok($serialList, ",");
	while($token != false)
	{
	 $arrSerialList[$i] = $token;
	 $token = strtok(",");
	 $i++;
	}
	
	//////////mat propety values id list
	//$arrPropertyValueIdList = array($propValueIdList);
	
	
	///////////////////////////////////////////////////
	$sql="delete from matpropertyassign where intSubCatId='$subCatID'";
	$result_check = $db->RunQuery($sql);	
	for($j=0;$j<count($ArrPropId);$j++){
		
		$sql1 = "SELECT intPropertyId FROM matpropertyassign WHERE intSubCatId='$subCatID' and intPropertyId='".$ArrPropId[$j]."';";
		
		$result_check = $db->RunQuery($sql1);	
		
		if($row_check = mysql_fetch_array($result_check)){
		
		}
		else{
			$a++;
			$sql2="INSERT INTO matpropertyassign 
				(intPropertyId, 
				intSubCatId,
				intOrderBy)
				VALUES
				('".$ArrPropId[$j]."', 
				'$subCatID',
				'$a');";
			$result2 = $db->RunQuery($sql2);	
		}
	
	}
			
		if (!$Wastage)
		$Wastage = 0;
	if (!$unitPrice)
		$unitPrice = 0;
	
	$itemExists = false;
	$sql = "SELECT strItemDescription FROM matitemlist WHERE strItemDescription = '$ItemName'";
	
	$result = $db->RunQuery($sql);	 
	 while($row = mysql_fetch_array($result))
  	 {
  	 	$itemExists = true;
  	 	break;
  	 }
	
	if (!$itemExists)
	{
		$ItemCode = str_replace(",", "#", $ItemCode);
		$sql = "insert into matitemlist (strItemCode,strItemDescription,intMainCatID,intSubCatID,strUnit,sngWastage,intStatus,strUserId,dtmDate,strPurchaseUnit,dblUnitPrice) values ('$ItemCode','$ItemName',$MainCatID,$subCatID,'$unitID',$Wastage,1,'$useID',now(),'$purchaseUnit','$unitPrice')";

		$itemSerialNo = $db->AutoIncrementExecuteQuery($sql);
	}
	$ResponseXML .= "<RequestDetails>\n";
	if ($itemExists)
	{
		$ResponseXML .= "<Result><![CDATA[False]]></Result>\n";   
		$ResponseXML .= "<Message><![CDATA[The item name already exists.]]></Message>\n";
	}
	else
	{
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";   
		$ResponseXML .= "<Message><![CDATA[The new item added successfully.\nItem Code : $ItemCode \nItem Name :$ItemName]]></Message>\n";
		
		////////////////////////  	Properties/vlaues assign to matItemNo		//////////////////////////////////////////////
		//propIDlist
		//propValueIdList
		//$ResponseXML .= "<sql>".print_r($ArrPropId)."</sql>";
		for($m=0;$m<count($ArrPropId);$m++)
		{
			
			if($ArrPropId[$m]!='')
			{
			//echo  $arrBeforeAfterList[$m] ;
			$ResponseXML .= "<rb>";
			$sqlm = "INSERT INTO matpropertyvaluesinitems (intMatItemSerial,intMatPropertyId,intMatPropertyValueId,strDisplayString,intBefore,intOrder)
			     VALUES 
				($itemSerialNo,".$ArrPropId[$m].",".$arrPropertyValueIdList[$m].",'$arrDisplayStrList[$m]','$arrBeforeAfterList[$m]',
				'$arrSerialList[$m]')";
					
			$db->RunQuery($sqlm);
			//echo $sqlm;
			$ResponseXML .= $sqlm;
			$ResponseXML .= "</rb>";
			}
		}
		//////////////////////////////////////////////////////////////////////
		
		
	}
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"SaveNewContent") == 0) 
{
	
	$ResponseXML .= "<RequestDetails>\n";
	$contentName = $_GET["contentName"];
	$index = $_GET["index"];
	$sql = "SELECT contentID FROM fabriccontent WHERE contentIndex = '$index'";
	//die($sql);
	$contentAvailable = false;
	$message = "";
	$result = $db->RunQuery($sql);	 
	 while($row = mysql_fetch_array($result))
  	 {
	 	
	 	$contentAvailable = true;
		break;
	 }
	 if ($contentAvailable)
	 {
	 		 $ResponseXML .= "<Result><![CDATA[False]]></Result>\n";   
			 $ResponseXML .= "<Message><![CDATA[The generated content name already exists.]]></Message>\n";   
	 }
	 else
	 {
	 	$sql = "insert into fabriccontent 
					(
					contentName, 
					contentIndex
					)
					values
					(
					'$contentName', 
					'$index'
					);";
		$db->executeQuery($sql);
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";   
			 $ResponseXML .= "<Message><![CDATA[New content name added to the system.]]></Message>\n"; 
	 }
	  $ResponseXML .= "</RequestDetails>";
	  echo $ResponseXML;
}
if (strcmp($RequestType,"changeInspection") == 0)
{
	$ResponseXML .= "<RequestDetails>\n";
	$catID  = $_GET["catID"];
	$status = $_GET["status"];
	$sql = "UPDATE matsubcategory SET intInspection = $status WHERE intSubCatNo = $catID";
	$rst = $db->executeQuery($sql);
	$ResponseXML .= "<Message><![CDATA[$rst]]></Message>\n"; 
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
if (strcmp($RequestType,"changeAdditional") == 0)
{
	$ResponseXML .= "<RequestDetails>\n";
	$catID  = $_GET["catID"];
	$status = $_GET["status"];
	$sql = "UPDATE matsubcategory SET intAdditionalAllowed = $status WHERE intSubCatNo = $catID";
	$rst = $db->executeQuery($sql);
	$ResponseXML .= "<Message><![CDATA[$rst]]></Message>\n"; 
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
if (strcmp($RequestType,"changeStatus") == 0)
{
	$ResponseXML .= "<RequestDetails>\n";
	$catID  = $_GET["catID"];
	$status = $_GET["status"];
	$sql = "UPDATE matsubcategory SET intStatus= $status WHERE intSubCatNo = $catID";
	$rst = $db->executeQuery($sql);
	$ResponseXML .= "<Message><![CDATA[$rst]]></Message>\n"; 
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"UpdateMaterial") == 0) 
{
	ob_get_clean();
	$intItemSerial = $_GET["intItemSerial"];
	$valName = $_GET["valName"];
	$displayText = $_GET["displayText"];
	$listBefore = $_GET["listBefore"];
	$listOrder = $_GET["listOrder"];
	
	$intMatPropertyIdList = $_GET["property"];
	$arrintMatPropertyIdList;
	$i=0;
	$token = strtok($intMatPropertyIdList, ",");
	while($token != false)
	{
	 $arrintMatPropertyIdList[$i] = $token;
	 $token = strtok(",");
	 $i++;
	}
	
	$arrvalNameList;
	$i=0;
	$token = strtok($valName, ",");
	while($token != false)
	{
	 $arrvalNameList[$i] = $token;
	 $token = strtok(",");
	 $i++;
	}
	
	$arrdisplayTextList;
	$i=0;
	$token = strtok($displayText, ",");
	while($token != false)
	{
	 $arrdisplayTextList[$i] = $token;
	 $token = strtok(",");
	 $i++;
	}
	
	$arrlistBefore;
	$i=0;
	$token = strtok($listBefore, ",");
	while($token != false)
	{
	 $arrlistBefore[$i] = $token;
	 $token = strtok(",");
	 $i++;
	}
	
	$arrlistOrder;
	$i=0;
	$token = strtok($listOrder, ",");
	while($token != false)
	{
	 $arrlistOrder[$i] = $token;
	 $token = strtok(",");
	 $i++;
	}
	
	
	$del_sql = "delete from matpropertyvaluesinitems where intMatItemSerial='$intItemSerial'";
	$result1=$db->RunQuery($del_sql);	
	//echo count($arrintMatPropertyIdList);
	for($m=0;$m<count($arrintMatPropertyIdList);$m++)
	{
	$sql_insert = "INSERT INTO matpropertyvaluesinitems (intMatItemSerial,intMatPropertyId,intMatPropertyValueId,strDisplayString,intBefore,intOrder)
			     VALUES 
				('$intItemSerial','$arrintMatPropertyIdList[$m]','$arrvalNameList[$m]','$arrdisplayTextList[$m]','$arrlistBefore[$m]',$arrlistOrder[$m])";
			
	$result3=$db->RunQuery($sql_insert);	
	}
	
	$sql_Item = " select mil.intMainCatID,mil.intSubCatID,ms.StrCatName
from matitemlist mil inner join matsubcategory ms on ms.intSubCatNo=mil.intSubCatID 
and ms.intCatNo = mil.intMainCatID 
where mil.intItemSerial='$intItemSerial' ";
	$result_Item=$db->RunQuery($sql_Item);
	$rowI = mysql_fetch_array($result_Item);
	
	$intMainCatID = $rowI["intMainCatID"];
	$intSubCatID = $rowI["intSubCatID"];
	$StrCatName = $rowI["StrCatName"];
		
	$ItemCode = $_GET["ItemCode"];
	$ItemCode = str_replace(",", "#", $ItemCode);
	$ItemCode =$intMainCatID."_".$intSubCatID."".$ItemCode;
	$ItemName = $StrCatName.$_GET["ItemName"];
	$strUnit = $_GET["strUnit"];
	$dblLastPrice = $_GET["dblLastPrice"];
	//echo $strUnit.'/'.$dblLastPrice;
	$sql = "UPDATE matitemlist 
		SET
		strItemCode='$ItemCode',
		strItemDescription='$ItemName',
		strUnit = '$strUnit' , 
		dblLastPrice = '$dblLastPrice',
		dtmDate=now()
		WHERE
		intItemSerial = '$intItemSerial' ;";
		
	$result=$db->RunQuery($sql);	
	if($result==1)
		$message = "Updated successfully.";		
	else
		$message = "Unable to update.";
		
		
	
	$ResponseXML .= "<RequestDetails>\n";
	$ResponseXML .= "<message><![CDATA[" . $message  . "]]></message>";   
	$ResponseXML .= "</RequestDetails>";
	
	echo $ResponseXML;	
}

function getPropertyValues($propID)
{
	global $db;
	/*
	$sql= "SELECT matpropertyvalues.intSubPropertyNo, matpropertyvalues.strSubPropertyName FROM (matproperties INNER JOIN matsubpropertyassign ON matproperties.intPropertyId = matsubpropertyassign.intPropertyId) INNER JOIN matpropertyvalues ON matsubpropertyassign.intSubPropertyid = matpropertyvalues.intSubPropertyNo WHERE (((matproperties.intPropertyId)=$propID)); " ;
	
	*/
	
	//$sql = "SELECT intSubPropertyNo,strSubPropertyName FROM matpropertyvalues WHERE strSubPropertyCode = '$propID' order by strSubPropertyName";
	
	
/*	$sql = " SELECT DISTINCT matpropertyvalues.intSubPropertyNo,strSubPropertyName FROM matpropertyvalues INNER JOIN matsubpropertyassign 
 ON matsubpropertyassign.intSubPropertyid = matpropertyvalues.intSubPropertyNo OR matsubpropertyassign.intSubPropertyid  = matpropertyvalues.strSubPropertyCode 
 WHERE 
 matsubpropertyassign.intPropertyId  = '$propID' OR matpropertyvalues.strSubPropertyCode = '$propID' ORDER BY strSubPropertyName";*/
 
 // comment by roshan / 2010-09-17
/* $sql = "SELECT DISTINCT matpropertyvalues.intSubPropertyNo,strSubPropertyName
FROM
matpropertyvalues
Inner Join matsubpropertyassign ON matpropertyvalues.strSubPropertyCode = matsubpropertyassign.intPropertyId
WHERE matsubpropertyassign.intPropertyId  = '$propID' OR matpropertyvalues.strSubPropertyCode = '$propID' ORDER BY strSubPropertyName";
 */
 $sql = "	SELECT distinct
			matpropertyvalues.intSubPropertyNo,
			matpropertyvalues.strSubPropertyName
			FROM
			matsubpropertyassign
			Inner Join matpropertyvalues ON matpropertyvalues.intSubPropertyNo = matsubpropertyassign.intSubPropertyid
			WHERE
			matsubpropertyassign.intPropertyId =  '$propID' ORDER BY matpropertyvalues.strSubPropertyName
			";
	return $db->RunQuery($sql);
}

function getOtherPropertyValues($propID)
{
	global $db;
	
	$sql= "select intSubPropertyNo,strSubPropertyName from matpropertyvalues where intSubPropertyNo not in (
SELECT matpropertyvalues.intSubPropertyNo
FROM (matproperties INNER JOIN matsubpropertyassign ON matproperties.intPropertyId = matsubpropertyassign.intPropertyId) INNER JOIN matpropertyvalues ON matsubpropertyassign.intSubPropertyid = matpropertyvalues.intSubPropertyNo
WHERE (((matproperties.intPropertyId)=$propID))) order by strSubPropertyName; " ;

//$sql = "SELECT intSubPropertyNo,strSubPropertyName FROM matpropertyvalues WHERE strSubPropertyCode <> $propID order by strSubPropertyName";
/*$sql = "SELECT
		matpropertyvalues.intSubPropertyNo,
		matpropertyvalues.strSubPropertyName
		FROM
		matsubpropertyassign
		Inner Join matpropertyvalues ON matpropertyvalues.intSubPropertyNo = matsubpropertyassign.intSubPropertyid
		WHERE
		matsubpropertyassign.intPropertyId <>  '$propID' AND matsubpropertyassign.intSubPropertyid not in (select intSubPropertyid from matsubpropertyassign where matsubpropertyassign.intPropertyId ='$propID')
		";*/
	return $db->RunQuery($sql);
}
function getOtherPropertyValuesSearchText($propID,$txt)
{
	global $db;
	
	$sql= "select intSubPropertyNo,strSubPropertyName from matpropertyvalues where intSubPropertyNo not in (
SELECT matpropertyvalues.intSubPropertyNo
FROM (matproperties INNER JOIN matsubpropertyassign ON matproperties.intPropertyId = matsubpropertyassign.intPropertyId) INNER JOIN matpropertyvalues ON matsubpropertyassign.intSubPropertyid = matpropertyvalues.intSubPropertyNo
WHERE (((matproperties.intPropertyId)=$propID))) and strSubPropertyName like '%$txt%' 
order by strSubPropertyName; " ;


	return $db->RunQuery($sql);
}

?>

