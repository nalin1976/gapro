<?php 
session_start();
include("../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["request"];
if ($request=='getData')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$categoryid=$_GET['categoryid'];
	$processid=$_GET['processid'];
	
	
	$str="select 	intComponentId, 
					intCategory, 
					strComponent, 
					components.strDescription,
					ws_processes.strProcess,
					ws_processes.intProcessId	 
					from 
					components left join ws_processes on components.intStatus=ws_processes.intProcessId";
					
				if($categoryid != '' and $processid != ''){
				$str.= "  where intCategory='$categoryid' and ws_processes.intProcessId='$processid' and intStatus!=0";
				}	
				else if($categoryid != ''){
				$str.= "  where intCategory='$categoryid' and intStatus!=0";
				}
				else if($processid != ''){
				$str.= "  where ws_processes.intProcessId='$processid' and intStatus!=0";
				}

	//echo $str;
	$XMLString= "<Data>";
	$XMLString .= "<Componentz>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<ComponentId><![CDATA[" . $row["intComponentId"]  . "]]></ComponentId>\n";
		$XMLString .= "<Category><![CDATA[" . $row["intCategory"]  . "]]></Category>\n";
		$XMLString .= "<Component><![CDATA[" . $row["strComponent"]  . "]]></Component>\n";
		$XMLString .= "<Description><![CDATA[" . $row["strDescription"]   . "]]></Description>\n";	
		$XMLString .= "<Process><![CDATA[" . $row["strProcess"]   . "]]></Process>\n";	
		$XMLString .= "<ProcessId><![CDATA[" . $row["intProcessId"]   . "]]></ProcessId>\n";		
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
	$processId=$_GET['processId'];
	
	if($componentid=="")
	{
			 $str="insert into components 
					( 
					intCategory, 
					strComponent, 
					strDescription,
					intStatus
					)
					values
					( 
					'$categoryid', 
					'$component', 
					'$description',
					'$processId'
					);";
	}
	else 
	{
		$str="update components
					set
					
					strComponent = '$component' , 
					strDescription = '$description' ,
					intStatus = 	'$processId'
					
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
		$str="insert into componentcategory 
		(strCategory,strDescription)
		values
		('$category','$cat_description');";
		}
	else
		{
		$str="update componentcategory set strCategory = '$category' ,
		 strDescription = '$cat_description' 
		 where	intCategoryNo = '$catid' ;";
		}
	$result = $db->RunQuery($str); 
	if($result)
	echo "ok";

}

if ($request=='saveProcess')
{
	$processid=$_GET['processid'];
	$pro_description=$_GET['pro_description'];
	$process=$_GET['process'];
	if($processid=="")
		{
		$str="insert into ws_processes 
		(strProcess,strDescription)
		values
		('$process','$pro_description');";
		}
	else
		{
		$str="update ws_processes set strProcess = '$process' ,
		 strDescription = '$pro_description' 
		 where	intProcessId = '$processid' ;";
		}
	$result = $db->RunQuery($str); 
	if($result)
	echo "ok";

}

if ($request=='delete_component')
{	
	$categoryid=$_GET['categoryid'];
	$componentid=$_GET['componentid'];
	
	$str="delete from components where intComponentId = '$componentid' and intCategory='$categoryid';";
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
					componentcategory 
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

if ($request=='get_process')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$catid=$_GET['catid'];
	
	
	$str="select intProcessId,strProcess,strDescription from ws_processes where  intProcessId='$catid' order by intProcessId ASC";
	
	
	$XMLString .= "<Pro>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<Process><![CDATA[" . $row["strProcess"]  . "]]></Process>\n";
		$XMLString .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
	}
	
	$XMLString .= "</Pro>";
	echo $XMLString;
}

if ($request=='delete_category')
{	
	$categoryid=$_GET['categoryid'];
	$str="delete from componentcategory where intCategoryNo='$categoryid'";
	$result = $db->RunQuery($str); 
	if($result)
	{
		$str="delete from components where  intCategory='$categoryid';";
		$result = $db->RunQuery($str); 
		if($result)
			echo $result[1];
	}
	
}

if ($request=='check_component')
{
		$component=$_GET['component'];
		$componentid=$_GET['componentid'];
		$str="select strCategory
				 from cutting_component 
				 left join component_category on component_category.intCategoryNo=cutting_component.intCategory
				 where strComponent='$component' and cutting_component.intStatus!=0 and cutting_component.intComponentId!='$componentid'";
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

if ($request=='check_process')
{
		$process=$_GET['process'];
		$processid=$_GET['processid'];
		$str="select intProcessId from ws_processes where  strProcess='$process'";
		$result=$db->RunQuery($str);
		$row=mysql_fetch_array($result);
		$process=$row["intProcessId"];
		if($process=='')
			$process=-999;
		echo $process;
}
?>