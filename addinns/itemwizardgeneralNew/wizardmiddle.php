<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
//echo "sfsdfsdfsdfd";

 $RequestType = $_GET["str"];

if (strcmp($RequestType,"GetMainCategory") == 0) 
{
	 $ResponseXML .= "<RequestDetails>\n";
	 $mainCat = $_GET["mainCat"];
	 $sql = "select strID,strDescription,dblGRNExcess from genmatmaincategory where intID='".$mainCat."';";		
	 $result = $db->RunQuery($sql);	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<CatCode><![CDATA[" . $row["strID"]  . "]]></CatCode>\n"; 
         $ResponseXML .= "<CatName><![CDATA[" . $row["strDescription"]  . "]]></CatName>\n";   
		 $ResponseXML .= "<AllowEx><![CDATA[" . $row["dblGRNExcess"]  . "]]></AllowEx>\n";  
	 }
	 
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
elseif (strcmp($RequestType,"subCategoryID") == 0) 
{
	 $ResponseXML .= "<RequestDetails>\n";
	 $subCatID = $_GET["subCat"];
	 $sql = "select intSubCatNo,StrCatCode, 
			StrCatName, 
			intDisplay, 
			intInspection
			from genmatsubcategory where intSubCatNo='".$subCatID."';";
	 $result = $db->RunQuery($sql);	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<CatID><![CDATA[" . $row["intSubCatNo"]  . "]]></CatID>\n"; 
         $ResponseXML .= "<CatCode><![CDATA[" . $row["StrCatCode"]  . "]]></CatCode>\n";   
		 $ResponseXML .= "<CatName><![CDATA[" . $row["StrCatName"]  . "]]></CatName>\n";  
		 $ResponseXML .= "<Display><![CDATA[" . $row["intDisplay"]  . "]]></Display>\n";   
		 $ResponseXML .= "<Inspection><![CDATA[" . $row["intInspection"]  . "]]></Inspection>\n"; 		 
	 }
	 
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
else if (strcmp($RequestType,"subcat") == 0)
{		
	$XMLProperty.= "<Property>";	
	$Subcatid = $_GET["subcatid"];
	$SQL_property="SELECT MP.intPropertyId, MP.strPropertyName
				   FROM genmatproperties MP 
				   INNER JOIN genmatpropertyassign GMPA ON MP.intPropertyId = GMPA.intPropertyId				   
				   WHERE GMPA.intSubCatId=".$Subcatid." order by intOrderBy;";
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
else if (strcmp($RequestType,"SaveMaterial") == 0) 
{
$ItemCode 		= $_GET["ItemCode"];
$ItemName 		= $_GET["ItemName"];
$MainCatID 		= $_GET["MainCatID"];
$subCatID		= $_GET["subCatID"];
$Wastage 		= $_GET["Wastage"];
$unitID 		= $_GET["unitID"];
$useID 			= $_SESSION["UserID"];
$propIDlist 	= $_GET["propIDlist"];
$reorderLevel	= $_GET["ReorderLevel"];
$reorderLevel = ($reorderLevel ==''?0:$reorderLevel);	
	//propValueIdList//////////////////////////////
	$propValueIdList = $_GET["propValueIdList"];
	$arrPropertyValueIdList;
	$i=0;
	$token = strtok($propValueIdList, ",");			
	while ($token != false)
	{	
		$arrPropertyValueIdList[$i]=$token;
		//echo $arrPropertyValueIdList[$i];
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
	$sql="delete from genmatpropertyassign where intSubCatId='$subCatID'";
	$result_check = $db->RunQuery($sql);	
	
	for($j=0;$j<count($ArrPropId);$j++)
	{
		$sql1 = "SELECT intPropertyId FROM genmatpropertyassign WHERE intSubCatId='$subCatID' and intPropertyId='".$ArrPropId[$j]."';";		
		$result_check = $db->RunQuery($sql1);	
			
		if($row_check = mysql_fetch_array($result_check)){
			
		}
		else{
			$a++;
			$sql2="INSERT INTO genmatpropertyassign 
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
	$sql = "SELECT strItemDescription FROM genmatitemlist WHERE strItemDescription = '$ItemName'";
	
	$result = $db->RunQuery($sql);	 
	while($row = mysql_fetch_array($result))
  	{
  		$itemExists = true;
  	 	break;
  	 }
	
	if (!$itemExists)
	{
		$ItemCode = str_replace(",", "#", $ItemCode);
		$sql = "insert into genmatitemlist (strItemCode,strItemDescription,intMainCatID,intSubCatID,strUnit,sngWastage,intStatus,strUserId,dtmDate,dblReorderLevel) values ('$ItemCode','$ItemName',$MainCatID,$subCatID,'$unitID',$Wastage,1,'$useID',now(),$reorderLevel)";

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
		for($m=0;$m<count($ArrPropId);$m++)
		{
			//echo $arrPropertyValueIdList[$m].'-'.$m.'</br>';
			if($arrPropertyValueIdList[$m]!='N/A')
			{
			$ResponseXML .= "<rb>";
			$sqlm = "INSERT INTO genmatpropertyvaluesinitems (intMatItemSerial,intMatPropertyId,intMatPropertyValueId,strDisplayString,intBefore,intOrder)
			     VALUES 
				($itemSerialNo,".$ArrPropId[$m].",".$arrPropertyValueIdList[$m].",'$arrDisplayStrList[$m]','$arrBeforeAfterList[$m]',
				'$arrSerialList[$m]')";
					
			$db->RunQuery($sqlm);
			$ResponseXML .= $sqlm;
			$ResponseXML .= "</rb>";
			}
		}
	}
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"changeInspection") == 0)
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
else if (strcmp($RequestType,"changeAdditional") == 0)
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

else if (strcmp($RequestType,"UpdateMaterial") == 0) 
{
	ob_get_clean();
	$intItemSerial = $_GET["intItemSerial"];
	$propValueIdList = $_GET["propValueIdList"];
	$displayText = $_GET["displayStrList"];
	$listBefore = $_GET["strBeforeAfterList"];
	$listOrder = $_GET["serialList"];
	
	$intMatPropertyIdList = $_GET["propIDlist"];
	$arrintMatPropertyIdList;
	$i=0;
	//echo $intMatPropertyIdList;
	$token = strtok($intMatPropertyIdList, ",");
	while($token != false)
	{
	 $arrintMatPropertyIdList[$i] = $token;
	 $token = strtok(",");
	 $i++;
	}
	
	$arrvalNameList;
	$i=0;
	$token = strtok($propValueIdList, ",");
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
	
	
	$del_sql = "delete from genmatpropertyvaluesinitems where intMatItemSerial='$intItemSerial'";
	$result1=$db->RunQuery($del_sql);	
	//echo count($arrintMatPropertyIdList);
	for($m=0;$m<count($arrintMatPropertyIdList);$m++)
	{
	$sql_insert = "INSERT INTO genmatpropertyvaluesinitems (intMatItemSerial,intMatPropertyId,intMatPropertyValueId,strDisplayString,intBefore,intOrder)
			     VALUES 
				('$intItemSerial','$arrintMatPropertyIdList[$m]','$arrvalNameList[$m]','$arrdisplayTextList[$m]','$arrlistBefore[$m]',$arrlistOrder[$m])";
		//echo $sql_insert;			
	$result3=$db->RunQuery($sql_insert);	
	}
	$sql1="SELECT 	 
	intMainCatID, 
	intSubCatID	
	FROM 
	genmatitemlist where intItemSerial = '$intItemSerial' ;";	
	$result1=$db->RunQuery($sql1);	 
	
	while($row1 = mysql_fetch_array($result1))
  	{
		$intMainCatID=$row1["intMainCatID"];
		$intSubCatID=$row1["intSubCatID"];
	}
	
	$sql2=" SELECT StrCatName
		    FROM 
			genmatsubcategory where intSubCatNo='$intSubCatID' ORDER BY StrCatName;";	
			$result2=$db->RunQuery($sql2);	 
			while($row2 = mysql_fetch_array($result2))
			{
				$StrCatName=trim($row2["StrCatName"]);
			}
		
	$ItemCode = $_GET["ItemCode"];
	$ItemCode = str_replace(",", "#", $ItemCode);
	$ItemCode =$intMainCatID."_".$intSubCatID."".$ItemCode;
	$ItemName = $StrCatName.$_GET["ItemName"];
	$strUnit = $_GET["strUnit"];
	$dblLastPrice = $_GET["dblLastPrice"];
	
	$sql = "UPDATE genmatitemlist 
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
	$ResponseXML .= "<ItemName><![CDATA[" . $ItemName  . "]]></ItemName>";   
	$ResponseXML .= "<strUnit><![CDATA[" . $strUnit  . "]]></strUnit>";  
	$ResponseXML .= "<dblLastPrice><![CDATA[" . $dblLastPrice  . "]]></dblLastPrice>";      
	$ResponseXML .= "</RequestDetails>";
	
	echo $ResponseXML;	
}
else if(strcmp($RequestType,"GetUnits")==0)
{
	$ResponseXML="";
	$sql="SELECT strUnit,strUnit FROM units u where u.intStatus=1 ORDER BY strUnit;";
	$result=$db->RunQuery($sql);
	$ResponseXML.="<units>";
	$str = "";
	while($row=mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["strUnit"] ."\">".$row["strUnit"]."</option>\n";	
	}
	$ResponseXML.="<unit><![CDATA[" .$str. "]]></unit>\n";	
	$ResponseXML.="</units>";
	echo $ResponseXML;	
	
}

function getPropertyValues($propID)
{
global $db;

	$sql = "SELECT distinct
	PV.intSubPropertyNo,
	PV.strSubPropertyName
	FROM
	genmatsubpropertyassign PA
	Inner Join genmatpropertyvalues PV ON PV.intSubPropertyNo = PA.intSubPropertyid
	WHERE
	PA.intPropertyId =  '$propID' ORDER BY PV.strSubPropertyName";
	return $db->RunQuery($sql);
}

function getOtherPropertyValues($propID)
{
global $db;

/*$sql= "select intSubPropertyNo,strSubPropertyName from matpropertyvalues where intSubPropertyNo not in (
SELECT matpropertyvalues.intSubPropertyNo
FROM (matproperties INNER JOIN matsubpropertyassign ON matproperties.intPropertyId = matsubpropertyassign.intPropertyId) INNER JOIN matpropertyvalues ON matsubpropertyassign.intSubPropertyid = matpropertyvalues.intSubPropertyNo
WHERE (((matproperties.intPropertyId)=$propID))); " ;*/

$sql="select intSubPropertyNo,strSubPropertyName 
	from genmatpropertyvalues 
	where intSubPropertyNo 
	not in (SELECT genmatpropertyvalues.intSubPropertyNo
	FROM (genmatproperties 
	INNER JOIN genmatsubpropertyassign ON genmatproperties.intPropertyId = genmatsubpropertyassign.intPropertyId) 
	INNER JOIN genmatpropertyvalues ON genmatsubpropertyassign.intSubPropertyid = genmatpropertyvalues.intSubPropertyNo
	WHERE genmatproperties.intPropertyId=$propID);";
return $db->RunQuery($sql);
}

?>

