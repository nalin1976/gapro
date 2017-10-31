<?php
session_start();
include "../../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


$RequestType = $_GET["RequestType"];

if($RequestType=="LoadSubCategory")
{
$mainCategoryId	= $_GET["mainCategoryId"];
$ResponseXML ="<LoadSubCategory>\n";
$sql="select intSubCatNo,StrCatName from matsubcategory where intCatNo='$mainCategoryId' order by StrCatName ";
$result=$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"".""."\">"."Select One"."</option>" ;
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
}
$ResponseXML .= "</LoadSubCategory>\n";
echo $ResponseXML;
}
elseif($RequestType=="Validate")
{
$matDetailId	= $_GET["matDetailId"];

$ResponseXML ="<Validate>\n";
$sql="select intItemSerial,strItemDescription from matitemlist 
	where intItemSerial not in (select intMatDetailID from purchaseorderdetails) 	
	and intItemSerial='$matDetailId'";
$result=$db->RunQuery($sql);
$rowCount=mysql_num_rows($result);
	if($rowCount==0)
		$ResponseXML .= "<Status><![CDATA[TRUE]]></Status>"; 
	else
		$ResponseXML .= "<Status><![CDATA[FALSE]]></Status>";  
		
	$ResponseXML .= "</Validate>";
	echo $ResponseXML;
}
elseif($RequestType=="ChangeStatus")
{
$matDetailId	= $_GET["matDetailId"];
$status			= $_GET["status"];

$ResponseXML ="<ChangeStatus>\n";
$sql="update matitemlist set intStatus=$status where intItemSerial='$matDetailId'";
$result=$db->RunQuery($sql);
	$ResponseXML .= "<Message><![CDATA[$result]]></Message>\n"; 
	$ResponseXML .= "</ChangeStatus>";
	echo $ResponseXML;
}

elseif($RequestType=="LoadItem")
{
	$intItemSerial	= $_GET["intItemSerial"];
	
	$ResponseXML ="<LoadItem>\n";
	$sql="select intItemSerial,strItemDescription,strUnit,dblLastPrice from matitemlist 
		where intItemSerial='$intItemSerial'";
		//echo $sql;
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<Serial><![CDATA[" .$row["intItemSerial"]. "]]></Serial>\n";
		$ResponseXML.="<ItemName><![CDATA[" .$row["strItemDescription"]. "]]></ItemName>\n";
		$ResponseXML.="<Unit><![CDATA[" .$row["strUnit"]. "]]></Unit>\n";		
		$ResponseXML.="<Price><![CDATA[" .$row["dblLastPrice"]. "]]></Price>\n";
		
		$sql1="SELECT intPropertyId FROM matpropertyassign WHERE intSubCatId=(select intSubCatID from matitemlist where intItemSerial='$intItemSerial') order by intOrderBy;";
		$result1=$db->RunQuery($sql1);
		$i=-1;	
			
		while($row1=mysql_fetch_array($result1))
		{				
			$sql2="SELECT strPropertyName,intPropertyId FROM matproperties where intPropertyId='".$row1["intPropertyId"]."' order by strPropertyName;";
			$result2=$db->RunQuery($sql2);
				
			while($row2=mysql_fetch_array($result2))
			{
				$ResponseXML.="<PropertyName><![CDATA[" .$row2["strPropertyName"]. "]]></PropertyName>\n";			
				$ResponseXML.="<PropertyID><![CDATA[" .$row2["intPropertyId"]. "]]></PropertyID>\n";			
				$i++;
				//$sql3="SELECT intSubPropertyid FROM matsubpropertyassign where intPropertyId='".$row2["intPropertyId"]."';";
				$sql3="SELECT MPV.intSubPropertyNo,MPV.strSubPropertyName FROM matsubpropertyassign MSPA inner join  matpropertyvalues MPV on MPV.intSubPropertyNo=MSPA.intSubPropertyid where MSPA.intPropertyId='".$row2["intPropertyId"]."' order by MPV.strSubPropertyName;";
				$result3=$db->RunQuery($sql3);
				while($row3=mysql_fetch_array($result3))
				{	
					//$sql4="select strSubPropertyName,intSubPropertyNo from matpropertyvalues where intSubPropertyNo='".$row3["intSubPropertyid"]."' order by strSubPropertyName;";
					//echo $sql4;
					//$result4=$db->RunQuery($sql4);
					//while($row4=mysql_fetch_array($result4))
					{		
						$ResponseXML.="<PropertyValue".$i."><![CDATA[" .$row3["strSubPropertyName"]. "]]></PropertyValue".$i.">\n";
						$ResponseXML.="<PropertyValueID".$i."><![CDATA[" .$row3["intSubPropertyNo"]. "]]></PropertyValueID".$i.">\n";
					}	
					
									
				}				
			}
		}
		
		
	}
	$ResponseXML .= "</LoadItem>";
	echo $ResponseXML;
}

if($RequestType=="loadPropertyValue")
{
 	$intMatPropertyId	= $_GET["intMatPropertyId"];
	$intItemSerial	= $_GET["intItemSerial"];
	
	$ResponseXML ="<loadProperty>\n";
	$sql="SELECT
		matpropertyvalues.strSubPropertyName,
		matpropertyvaluesinitems.strDisplayString,
		matpropertyvaluesinitems.intBefore,
		matpropertyvaluesinitems.intOrder,
		matpropertyvaluesinitems.intMatPropertyValueId
		FROM
		matpropertyvalues
		Inner Join matpropertyvaluesinitems on matpropertyvalues.intSubPropertyNo=matpropertyvaluesinitems.intMatPropertyValueId
		where intMatPropertyId='$intMatPropertyId' AND intMatItemSerial='$intItemSerial'";
		//echo $sql;
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<strDisplayString><![CDATA[" .$row["strDisplayString"]. "]]></strDisplayString>\n";
		$ResponseXML.="<strSubPropertyName><![CDATA[" .$row["strSubPropertyName"]. "]]></strSubPropertyName>\n";
		$ResponseXML.="<strSubPropertyVAL><![CDATA[" .$row["intMatPropertyValueId"]. "]]></strSubPropertyVAL>\n";
		$ResponseXML.="<intBefore><![CDATA[" .$row["intBefore"]. "]]></intBefore>\n";
		$ResponseXML.="<intOrder><![CDATA[" .$row["intOrder"]. "]]></intOrder>\n";	
	}
	$ResponseXML .= "</loadProperty>";
	echo $ResponseXML;
}
 if (strcmp($RequestType,"getOtherPropertiesWithSearchText") == 0) 
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