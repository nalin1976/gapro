<?php 
session_start();
include("../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["request"];

if ($request=='getData')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$categoryid=$_GET['categoryid'];
	$style	   =$_GET['style'];		
	$str="select 	intComponentId, 
	intCategory, 
	strComponent, 
	strDescription, 
	intStatus
	 
	from 
	cutting_component 
	where intCategory='$categoryid' and intStatus=1 and intComponentId not in (select intComponentId from style_cut_compo_dtl	where intStyleId='$style') 
	";
	
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<ComponentId><![CDATA[" . $row["intComponentId"]  . "]]></ComponentId>\n";
		$XMLString .= "<Category><![CDATA[" . $row["intCategory"]  . "]]></Category>\n";
		$XMLString .= "<Component><![CDATA[" . $row["strComponent"]  . "]]></Component>\n";
		$XMLString .= "<Description><![CDATA[" . $row["strDescription"]   . "]]></Description>\n";		
	}
	
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='filter')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$buyer=$_GET['buyer'];
	
	
	$str="select  intStyleId, concat(strOrderNo,'/ ',strStyle) as strOrderNo from orders where intBuyerID='$buyer' and  intStatus=11 order by strOrderNo";
	
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<StyleId><![CDATA[" . $row["intStyleId"]  . "]]></StyleId>\n";
		$XMLString .= "<Style><![CDATA[" . $row["strOrderNo"]  . "]]></Style>\n";
		//$XMLString .= "<Qty><![CDATA[" . $row["intQty"]  . "]]></Qty>\n";
	}
	
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='getStyleheader')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$Style=$_GET['Style'];
	
	$str="select intStyleId, intActualCutPcs, intQty from style_cut_compo_header where intStyleId='$Style'";
	$result = $db->RunQuery($str); 
	
	if(mysql_num_rows($result)<1)
	{
	$str="select intStyleId, strStyle, intQty from orders where intStyleId='$Style' order by strStyle";
	$result = $db->RunQuery($str); 
	}
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	if(!$row["intActualCutPcs"])
			$row["intActualCutPcs"]=0;
		$XMLString .= "<StyleId><![CDATA[" . $row["intStyleId"]  . "]]></StyleId>\n";
		$XMLString .= "<Style><![CDATA[" . $row["strStyle"]  . "]]></Style>\n";
		$XMLString .= "<Qty><![CDATA[" . $row["intQty"]  . "]]></Qty>\n";
		$XMLString .= "<Actual><![CDATA[" . $row["intActualCutPcs"]  . "]]></Actual>\n";
	}
	
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='saveHeader')
{	$Style=$_GET['Style'];
	$actual=$_GET['actual'];
	$qtypcs=$_GET['qtypcs'];
	$check="select intStyleId from style_cut_compo_header where intStyleId='$Style'";
	$checkResult = $db->RunQuery($check); 
	if(mysql_num_rows($checkResult)>0)
		$edit="update";
	else 
		$edit="insert";	
	if($edit=="insert")
		{
		$str="insert into style_cut_compo_header 
				(intStyleId, 
				intActualCutPcs, 
				intQty,
				intBundleNo,
				intNumberRange
				)
				values(
				'$Style',
				'$actual', 
				'$qtypcs',
				1,
				1
				);";
	
	
	
	}
	else if($edit=="update")
		{
			$str="update style_cut_compo_header 
			set 
			intActualCutPcs = '$actual' where	intStyleId = '$Style' ;";
	
	
			
			
		}
	$result = $db->RunQuery($str); 
	if($result)
	echo "Saved sucessfully.";
	else 
	echo "Sorry, something went wrong.";
}



if ($request=='getStyleCutData')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$Style=$_GET['Style'];
	
			
	$str="select  scd.intStyleId, 
				scd.intCategoryId, 
				scd.intComponentId,
				cc.intCategory,
				cc.strComponent,
				cc.strDescription
				 
				from 
				style_cut_compo_dtl  scd
				inner join cutting_component cc on cc.intComponentId=scd.intComponentId
				where scd.intStyleId='$Style'";
	
	$XMLString= "<Data>";
	$XMLString .= "<stylez>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{	
		$XMLString .= "<ComponentId><![CDATA[" . $row["intComponentId"]  . "]]></ComponentId>\n";
		$XMLString .= "<Category><![CDATA[" . $row["intCategory"]  . "]]></Category>\n";
		$XMLString .= "<Component><![CDATA[" . $row["strComponent"]  . "]]></Component>\n";
		$XMLString .= "<Description><![CDATA[" . $row["strDescription"]   . "]]></Description>\n";		
	}
	
	$XMLString .= "</stylez>";
	$XMLString .= "</Data>";
	echo $XMLString;
}


if ($request=='saveDetail')
{	

	$component=$_GET['component'];
	$style=$_GET['style'];
	$category=$_GET['category'];
	
	$check="select 	intserial from 	style_cut_compo_dtl where intStyleId='$style' and intCategoryId='$category' and intComponentId='$component'";
	$checkResult = $db->RunQuery($check); 
	
	if(mysql_num_rows($checkResult)<1)
			{
				$str="insert into style_cut_compo_dtl 
				(intStyleId, 
				intCategoryId, 
				intComponentId
				)
				values
				('$style', 
				'$category', 
				'$component');";
	
				$result = $db->RunQuery($str); 
			}
	if($result)	
	echo "Saved sucessfully!";
	else 
	echo "Sorry, something went wrong.";
}

if ($request=='del_first')
{	

	
	$style=$_GET['style'];
	
	
	
	$str="delete from style_cut_compo_dtl 	where intStyleId = '$style';";
	
	$result = $db->RunQuery($str); 
			
	if($result)	
	echo "Deleted sucessfully!";
	else 
	echo "Sorry, something went wrong.";
}

if ($request=='get_style_buyer')
{	

	$style=$_GET['style'];
	
	$str="select intBuyerID from orders where intStyleId='$style'";
	
	$result = $db->RunQuery($str); 
	$row=mysql_fetch_array($result);		
	echo $row["intBuyerID"];
}
?>