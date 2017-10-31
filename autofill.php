<?php
session_start();
include "Connector.php";

header('Content-Type: text/xml'); 
$RequestType = $_GET["RequestType"];
$text = $_GET["Input"];
$ResponseXML = "";
$ResponseXML.="<Data>";
if ( $RequestType == "styleItemProperty") 
{
	$sql = "SELECT distinct matproperties.intPropertyId, matproperties.strPropertyName FROM matproperties WHERE strPropertyName like '%$text%' ";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
  	 {	 
  	 	$ResponseXML.="<Value><![CDATA[" .$row["intPropertyId"]. "]]></Value>\n";
  	 	$ResponseXML.="<Text><![CDATA[" .$row["strPropertyName"]. "]]></Text>\n";		                
	 }	
}
else if ( $RequestType == "categories") 
{
	$sql = "SELECT DISTINCT intSubCatNo,StrCatName FROM matsubcategory WHERE StrCatName like '%$text%' ";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
  	 {	 
  	 	$ResponseXML.="<Value><![CDATA[" .$row["intSubCatNo"]. "]]></Value>\n";
  	 	$ResponseXML.="<Text><![CDATA[" .$row["StrCatName"]. "]]></Text>\n";		                
	 }	
}
else if ( $RequestType == "propertyValues") 
{
	$sql = "select intSubPropertyNo,strSubPropertyName  from matpropertyvalues  WHERE strSubPropertyName like '%$text%' ";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
  	 {	 
  	 	$ResponseXML.="<Value><![CDATA[" .$row["intSubPropertyNo"]. "]]></Value>\n";
  	 	$ResponseXML.="<Text><![CDATA[" .$row["strSubPropertyName"]. "]]></Text>\n";		                
	 }	
}
else if ($RequestType == "generalItemProperty") 
{
	$sql = "SELECT distinct intPropertyId, strPropertyName FROM genmatproperties WHERE strPropertyName like '%$text%' ";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
  	 {	 
  	 	$ResponseXML.="<Value><![CDATA[" .$row["intPropertyId"]. "]]></Value>\n";
  	 	$ResponseXML.="<Text><![CDATA[" .$row["strPropertyName"]. "]]></Text>\n";		                
	 }	
}
else if ( $RequestType == "generalCategories") 
{
	$sql = "SELECT DISTINCT intSubCatNo,StrCatName FROM genmatsubcategory WHERE StrCatName like '%$text%' ";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
  	 {	 
  	 	$ResponseXML.="<Value><![CDATA[" .$row["intSubCatNo"]. "]]></Value>\n";
  	 	$ResponseXML.="<Text><![CDATA[" .$row["StrCatName"]. "]]></Text>\n";		                
	 }	
}
else if ( $RequestType == "GeneralMainCategories") 
{
	$sql = "select intID,strDescription from genmatmaincategory where strDescription like '%$text%'";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
  	 {	 
  	 	$ResponseXML.="<Value><![CDATA[" .$row["intID"]. "]]></Value>\n";
  	 	$ResponseXML.="<Text><![CDATA[" .$row["strDescription"]. "]]></Text>\n";		                
	 }	
}
else if ( $RequestType == "GeneralPropertyValues") 
{
	$sql = "select intSubPropertyNo,strSubPropertyName  from genmatpropertyvalues  WHERE strSubPropertyName like '%$text%' ";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
  	 {	 
  	 	$ResponseXML.="<Value><![CDATA[" .$row["intSubPropertyNo"]. "]]></Value>\n";
  	 	$ResponseXML.="<Text><![CDATA[" .$row["strSubPropertyName"]. "]]></Text>\n";		                
	 }	
}
else if ( $RequestType == "OrderData_DestNo") 
{
	$sql = "select intDestId from destination where intStatus=1 and intDestId like '%$text%' order by intDestId";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
  	 {	 
  	 	$ResponseXML.="<Value><![CDATA[" .$row["intDestId"]. "]]></Value>\n";
  	 	$ResponseXML.="<Text><![CDATA[" .$row["intDestId"]. "]]></Text>\n";		                
	 }	
}
else if ( $RequestType == "OrderData_DestName") 
{
	$sql = "select intDestCode,strDestName from destination where intStatus=1 and strDestName like '%$text%' order by strDestName";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
  	 {	 
  	 	$ResponseXML.="<Value><![CDATA[" .$row["intDestId"]. "]]></Value>\n";
  	 	$ResponseXML.="<Text><![CDATA[" .$row["strDestName"]. "]]></Text>\n";		                
	 }	
}
$ResponseXML.="</Data>";
echo $ResponseXML ;

?>