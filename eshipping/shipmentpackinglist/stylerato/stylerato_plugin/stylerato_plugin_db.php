<?php
session_start();
include "../../../Connector.php";
header('Content-Type: text/xml'); 
$request			=$_GET["request"];

if($request=='fill_sizeratio_grid')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$orderid		=$_GET["orderid"];
	$xml_string		="<xml_dataset>\n";
    $str_sizes		="select distinct orderspecdetails.strSize,gw.dblWeight,strStyle_No 
						from orderspecdetails 
						inner join orderspec on orderspecdetails.intOrderId = orderspec.intOrderId
						left join finishing_garment_weight gw on gw.strSize=orderspecdetails.strSize and
						gw.strOrderId=orderspec.strOrder_No  
						where orderspec.strOrder_No='$orderid'";
	
	$result_sizes	=$db->RunQuery($str_sizes);	
	while($datarow_sizes=mysql_fetch_array($result_sizes))
	{
		$xml_string	.="<size><![CDATA[" . $datarow_sizes["strSize"] . "]]></size>\n";
		$xml_string	.="<weight><![CDATA[" . $datarow_sizes["dblWeight"] . "]]></weight>\n";
		$xml_string	.="<style><![CDATA[" . $datarow_sizes["strStyle_No"] . "]]></style>\n";
	}
	$xml_string		.="</xml_dataset>\n";
	echo $xml_string;
} 

if($request=='fill_prevSizeRatio_grid')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$styleId		=$_GET["styleId"];
	$xml_string		="<xml_dataset>\n";
    $str_OrderNo		="SELECT DISTINCT
						style_ratio_plugin.strStyle,
						orderspec.strStyle_No
						FROM
						style_ratio_plugin
						INNER JOIN orderspec ON orderspec.strOrder_No = style_ratio_plugin.strStyle
						WHERE strStyle_No='$styleId'";
	
	$result_OrderNo	=$db->RunQuery($str_OrderNo);	
	while($datarow_OrderNo=mysql_fetch_array($result_OrderNo))
	{
		$xml_string	.="<OrderId><![CDATA[" . $datarow_OrderNo["strStyle"] . "]]></OrderId>\n";
	}
	$xml_string		.="</xml_dataset>\n";
	echo $xml_string;
}

if($request=='delete_before_save_sizeratio_grid')
{
	$orderid		=$_GET["orderid"];
	$str_sizes		="delete from style_ratio_plugin where strStyle = '$orderid' ";
	$result_sizes	=$db->RunQuery($str_sizes);	
	
	echo (($result_sizes)?"Deleted":"Error");
	
}

if($request=='save_sizeratio_grid')
{
	
	$orderid		=$_GET["orderid"];
	$size			=$_GET["size"];
	
	$str_sizes		="insert into style_ratio_plugin 
								(strStyle, 
								strSize
								)
								values
								('$orderid', 
								'$size'
								);";
	$result_sizes	=$db->RunQuery($str_sizes);	
	
	echo (($result_sizes)?"Saved":"Error");
} 

if($request=='delete_before_save_garment_weight')
{
	$orderid		=$_GET["orderid"];
	$str_sizes		="delete from finishing_garment_weight where strOrderId = '$orderid' ";
	$result_sizes	=$db->RunQuery($str_sizes);	
	
	echo (($result_sizes)?"Deleted":"Error");	
}

if($request=='save_garment_weight')
{
	
	$orderid		=$_GET["orderid"];
	$size			=$_GET["size"];
	$weight			=$_GET["weight"];
	
	$str_sizes		="insert into finishing_garment_weight 
						(strOrderId, 
						strSize, 
						dblWeight
						)
						values
						('$orderid', 
						'$size', 
						'$weight'
						);";
	$result_sizes	=$db->RunQuery($str_sizes);	
	
	echo (($result_sizes)?"Saved":"Error");
} 

?>