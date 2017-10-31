<?php
session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

//$db =new DBManager();

$RequestType = $_GET["RequestType"];

if(strcmp($RequestType,"getStylewiseOrderNoNew")==0)
{
	$ResponseXML="";
	$stytleName = $_GET["stytleName"];
	
	$SQL = " select intStyleId,strOrderNo
			from orders
			where intStatus  =11";
		
	if($stytleName != 'Select One' && $stytleName != '')
		$SQL .= " and strStyle='$stytleName' ";
		
		$SQL .= " order by strOrderNo ";		
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}

else if(strcmp($RequestType,"getStyleWiseSCNum")==0)
{
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	
	$SQL = " select specification.intSRNO,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 ";
		
	if($stytleName != 'Select One' && $stytleName != '')
		$SQL .= " and orders.strStyle='$stytleName' ";
		
		$SQL .= "order by specification.intSRNO desc";	
			
	$result = $db->RunQuery($SQL);
	
		$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}
?>