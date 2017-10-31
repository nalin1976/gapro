<?php 
session_start();
include("../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["request"];
if ($request=='getData')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$categoryid=$_GET['categoryid'];
	
	
	$str="select 	intComponentId, 
					intCategory, 
					strComponent, 
					strDescription	 
					from 
					cutting_component 
				where intCategory='$categoryid' and intStatus!=0";
	
	$XMLString= "<Data>";
	$XMLString .= "<Componentz>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<ComponentId><![CDATA[" . $row["intComponentId"]  . "]]></ComponentId>\n";
		$XMLString .= "<Category><![CDATA[" . $row["intCategory"]  . "]]></Category>\n";
		$XMLString .= "<Component><![CDATA[" . $row["strComponent"]  . "]]></Component>\n";
		$XMLString .= "<Description><![CDATA[" . $row["strDescription"]   . "]]></Description>\n";		
	}
	
	$XMLString .= "</Componentz>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='saveData')
{	$categoryid=$_GET['categoryid'];
	$description=$_GET['description'];
	$component=$_GET['component'];
	$componentid=$_GET['componentid'];
	
	if($componentid=="")
	{
			$str="insert into cutting_component 
					( 
					intCategory, 
					strComponent, 
					strDescription
					)
					values
					( 
					'$categoryid', 
					'$component', 
					'$description'
					);";
	}
	else 
	{
		$str="update cutting_component 
					set
					
					strComponent = '$component' , 
					strDescription = '$description' 	
					
					where
					intComponentId = '$componentid' and intCategory = '$categoryid'  ;";
	
	}
	
	$result = $db->RunQuery($str); 
	if($result)
	echo "ok";

}

if ($request=='saveCat')
{
	$catid=$_GET['catid'];
	$cat_description=$_GET['cat_description'];
	$category=$_GET['category'];
	if($catid=="")
		{
		$str="insert into component_category 
		(strCategory,strDescription)
		values
		('$category','$cat_description');";
		}
	else
		{
		$str="update component_category set strCategory = '$category' ,
		 strDescription = '$cat_description' 
		 where	intCategoryNo = '$catid' ;";
		}
	$result = $db->RunQuery($str); 
	if($result)
	echo "ok";

}

if ($request=='delete_component')
{	
	$categoryid=$_GET['categoryid'];
	$componentid=$_GET['componentid'];
	
	$str="update cutting_component set intStatus=0 where intComponentId = '$componentid' and intCategory='$categoryid';";
	$result = $db->RunQuery($str); 
	if($result)
	echo "ok";

}
if ($request=='get_category')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$catid=$_GET['catid'];
	
	
	$str="select 	intCategoryNo, strCategory,strDescription
					from 
					component_category 
					where  intCategoryNo='$catid'";
	
	
	$XMLString= "<Data>";
	$XMLString .= "<Componentz>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<CategoryNo><![CDATA[" . $row["intCategoryNo"]  . "]]></CategoryNo>\n";
		$XMLString .= "<Category><![CDATA[" . $row["strCategory"]  . "]]></Category>\n";
		$XMLString .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
	}
	
	$XMLString .= "</Componentz>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='delete_category')
{	
	$categoryid=$_GET['categoryid'];
	$str="update component_category set intStatus=0 where intCategoryNo='$categoryid'";
	$result = $db->RunQuery($str); 
	if($result)
	{
		$str="update cutting_component set intStatus=0 where  intCategory='$categoryid';";
		$result = $db->RunQuery($str); 
		if($result)
			echo "ok";	
	}
}

if ($request=='check_component')
{
		$component=$_GET['component'];
		$componentid=$_GET['componentid'];
		$str="select strCategory
				 from cutting_component 
				 left join component_category on component_category.intCategoryNo=cutting_component.intCategory
				 where strComponent='$component' and cutting_component.intStatus!=0 and component_category.intStatus!=0 and cutting_component.intComponentId!='$componentid'";
		$result=$db->RunQuery($str);
		$row=mysql_fetch_array($result);
		$category=$row["strCategory"];
		if($category=='')
			$category=-999;
		echo $category;
}

if ($request=='check_category')
{
		$category=$_GET['category'];
		$categoryid=$_GET['categoryid'];
		$str="select intCategoryNo from component_category where intStatus!=0 and intCategoryNo!='$categoryid' and strCategory='$category'";
		$result=$db->RunQuery($str);
		$row=mysql_fetch_array($result);
		$category=$row["intCategoryNo"];
		if($category=='')
			$category=-999;
		echo $category;
}
?>