<?php
include "../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if($RequestType=="LoadSubcat")
{
	$mainId = $_GET["mainCat"];

	$ResponseXML = "<XMLloadMainCategory>\n";
	
	$sql="SELECT MSC.intSubCatNo, MSC.StrCatName FROM matsubcategory MSC WHERE MSC.intCatNo<>''";
	
	if($mainId!="")
		$sql .=" AND MSC.intCatNo = '$mainId'";
		
	$sql .=" order by MSC.StrCatName";
	$result=$db->RunQuery($sql);
		$str .= "<option value=\"". "" ."\">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["intSubCatNo"] ."\">".$row["StrCatName"]."</option>\n";	
	}
	
	$ResponseXML .= "<SubCat><![CDATA[" . $str . "]]></SubCat>\n";
	$ResponseXML .= "</XMLloadMainCategory>\n";
	echo $ResponseXML;
}

else if($RequestType=="loadPropertyDetails")
{
	$subCat = $_GET["subCat"];
	$ResponseXML = "<XMLloadProperty>\n";
	
	$SQL_property="SELECT matproperties.intPropertyId, matproperties.strPropertyName, matsubcategory.intSubCatNo FROM (matproperties INNER JOIN matpropertyassign ON matproperties.intPropertyId = matpropertyassign.intPropertyId) INNER JOIN matsubcategory ON matpropertyassign.intSubCatId = matsubcategory.intSubCatNo WHERE (((matsubcategory.intSubCatNo)='$subCat'))";
	$i=0;
	
	$result = $db->RunQuery($SQL_property);
	$recCount = mysql_num_rows($result);
			while($row = mysql_fetch_array($result))
			{
				
				 $htmlText .= "<tr bgcolor=\"#FFFFFF\"><td class=\"normalfnt\" id=" .$row["intPropertyId"].">".$row["strPropertyName"]. "</td><td class=\"normalfnt\"><table width=\"93%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
										  <tr>
										<td width=\"79%\"><select name=\"CBOadd\" class=\"txtbox\" id=\"CBOadd\" style=\"width:90px\">";
						//load property values
						$htmlText .= "<option></option>";
						$reProVal = getPropertyValues($row["intPropertyId"]);	
						while($rowp = mysql_fetch_array($reProVal))
						{
							$htmlText .= "<option>".$rowp["strSubPropertyName"]."</option>";
						}			
										$htmlText .="</select></td>
											<td width=\"21%\"><img src=\"../../images/add.png\" alt=\"[+]\" width=\"16\" height=\"16\" class=\"mouseover\" onClick=\"ShowNewValueForm(this);\" /></td>
										  </tr>
										</table></td>
										<td class=\"normalfntRite\"><div align=\"center\">
										  <input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"displayStrCtrl(this,".$i.");\" />
									</div></td>
										<td><input name=\"textfield".$i."\" id=\"textfield".$i."\" type=\"text\" class=\"txtbox\" size=\"15\" disabled=\"disabled\" /></td>
										<td><select name=\"select2\" class=\"txtbox\">
										 <option value=\"Before\">Before</option>
										 <option value=\"After\">After</option>
										</select>                    </td>";
					$htmlText .= "<td><div align=\"center\">
										 <select name=\"select2\" class=\"txtbox\">";
										for ($x = 0 ; $x < $recCount ; $x++)
										{
											if ($i == $x )
											$htmlText .= "<option value=\"" .( $x + 1) . "\" selected=\"selected\">" .($x + 1) ."</option>";
											else
											$htmlText .= "<option value=\"" .( $x + 1) . "\">" . ($x + 1) ."</option>";
										}
							$HTMLText .=	  "</select>
										</div></td>				
										</tr>";	
			
									  $i++;
			}
			
			$ResponseXML .= "<propertyData><![CDATA[" . $htmlText . "]]></propertyData>\n";
			$ResponseXML .= "</XMLloadProperty>\n";
	echo $ResponseXML;

}
else if (strcmp($RequestType,"getOtherProperties") == 0) 
{
	 $ResponseXML = "";
	 $propID = $_GET["PropID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getOtherPropertyValues($propID);
	 //echo $propID;
	 while($row = mysql_fetch_array($result))
  	 {
        	 $str .= "<option value=\"". $row["intSubPropertyNo"] ."\">".$row["strSubPropertyName"]."</option>\n";	     
	 }
	 $ResponseXML .= "<PropName><![CDATA[" . $str  . "]]></PropName>\n"; 
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
	
	
	for($j=0;$j<count($ArrPropId);$j++){
		
		$sql1 = "SELECT intPropertyId FROM matpropertyassign WHERE intSubCatId='$subCatID' and intPropertyId='".$ArrPropId[$j]."';";
		
		$result_check = $db->RunQuery($sql1);	
		
		if($row_check = mysql_fetch_array($result_check)){
		
		}
		else{
			$sql2="INSERT INTO matpropertyassign 
				(intPropertyId, 
				intSubCatId)
				VALUES
				('".$ArrPropId[$j]."', 
				'$subCatID');";
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
		$sql = "insert into matitemlist_temp (strItemCode,strItemDescription,intMainCatID,intSubCatID,strUnit,sngWastage,intStatus,strUserId,dtmDate,strPurchaseUnit,dblUnitPrice) values ('$ItemCode','$ItemName',$MainCatID,$subCatID,'$unitID',$Wastage,1,'$useID',now(),'$purchaseUnit','$unitPrice')";

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
			
			if(trim($arrPropertyValueIdList[$m])!='')
			{
			//echo  $arrBeforeAfterList[$m] ;
			//$ResponseXML .= "<rb>";
			$sqlm = "INSERT INTO matpropertyvaluesinitems_temp (intMatItemSerial,intMatPropertyId,intMatPropertyValueId,strDisplayString,intBefore,intOrder)
			     VALUES 
				($itemSerialNo,".$ArrPropId[$m].",'$arrPropertyValueIdList[$m]','$arrDisplayStrList[$m]','$arrBeforeAfterList[$m]',
				'$arrSerialList[$m]')";
					
			$db->RunQuery($sqlm);
			//echo $sqlm;
			//$ResponseXML .= $ArrPropId[$m];
			//$ResponseXML .= "</rb>";
			}
		}
		//////////////////////////////////////////////////////////////////////
		
		
	}
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}

function getPropertyValues($propID)
{
	global $db;
	
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


	return $db->RunQuery($sql);
}
?>