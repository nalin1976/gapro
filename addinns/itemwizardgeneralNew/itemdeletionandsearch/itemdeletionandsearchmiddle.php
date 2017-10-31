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
$sql="select intSubCatNo,StrCatName from genmatsubcategory where intCatNo='$mainCategoryId' and  intStatus = '1' ORDER BY StrCatName";
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
$sql="select intItemSerial,strItemDescription from genmatitemlist 
	where intItemSerial not in (select intMatDetailID from generalpurchaseorderdetails) 	
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
$sql="update genmatitemlist set intStatus=$status where intItemSerial='$matDetailId'";
$result=$db->RunQuery($sql);
	$ResponseXML .= "<Message><![CDATA[$result]]></Message>\n"; 
	$ResponseXML .= "</ChangeStatus>";
	echo $ResponseXML;
}

elseif($RequestType=="LoadItem")
{
	$intItemSerial	= $_GET["intItemSerial"];
	
	$ResponseXML ="<LoadItem>\n";
	$sql="select intItemSerial,strItemDescription,strUnit,dblLastPrice from genmatitemlist 
		where intItemSerial='$intItemSerial'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<Serial><![CDATA[" .$row["intItemSerial"]. "]]></Serial>\n";
		$ResponseXML.="<ItemName><![CDATA[" .$row["strItemDescription"]. "]]></ItemName>\n";
		$ResponseXML.="<Unit><![CDATA[" .$row["strUnit"]. "]]></Unit>\n";		
		$ResponseXML.="<Price><![CDATA[" .$row["dblLastPrice"]. "]]></Price>\n";
		
		$sql1="SELECT intPropertyId FROM genmatpropertyassign WHERE intSubCatId=(select intSubCatID from genmatitemlist where intItemSerial='$intItemSerial') order by intOrderBy;";
		//$sql1="select intMatPropertyId from genmatpropertyvaluesinitems where intMatItemSerial='$intItemSerial' order by intOrder";
		$result1=$db->RunQuery($sql1);
		$i=-1;	
			
		while($row1=mysql_fetch_array($result1))
		{				
			$sql2="SELECT strPropertyName,intPropertyId FROM genmatproperties where intPropertyId='".$row1["intPropertyId"]."';";
			$result2=$db->RunQuery($sql2);
				
			while($row2=mysql_fetch_array($result2))
			{
				$ResponseXML.="<PropertyName><![CDATA[" .$row2["strPropertyName"]. "]]></PropertyName>\n";			
				$ResponseXML.="<PropertyID><![CDATA[" .$row2["intPropertyId"]. "]]></PropertyID>\n";			
				$i++;
				$sql3="SELECT intSubPropertyid FROM genmatsubpropertyassign where intPropertyId='".$row2["intPropertyId"]."';";
				$result3=$db->RunQuery($sql3);
				while($row3=mysql_fetch_array($result3))
				{	
					$sql4="select strSubPropertyName,intSubPropertyNo from genmatpropertyvalues where intSubPropertyNo='".$row3["intSubPropertyid"]."';";
					$result4=$db->RunQuery($sql4);
					while($row4=mysql_fetch_array($result4))
					{		
						$ResponseXML.="<PropertyValue".$i."><![CDATA[" .$row4["strSubPropertyName"]. "]]></PropertyValue".$i.">\n";
						$ResponseXML.="<PropertyValueID".$i."><![CDATA[" .$row4["intSubPropertyNo"]. "]]></PropertyValueID".$i.">\n";
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
		gmv.strSubPropertyName,
		gpvi.strDisplayString,
		gpvi.intBefore,
		gpvi.intOrder,
		gpvi.intMatPropertyValueId
		FROM
		genmatpropertyvalues gmv
		Inner Join genmatpropertyvaluesinitems gpvi on gmv.intSubPropertyNo=gpvi.intMatPropertyValueId
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
?>