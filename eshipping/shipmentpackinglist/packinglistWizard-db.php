<?php
session_start();
$userId	 	= $_SESSION["UserID"];
$backwardseperator = "../";
include "$backwardseperator".''."Connector.php";
header('Content-Type: text/xml'); 	
$request=$_GET["request"];

if ($request=='load_size')
{
	$orderId=$_GET['orderId'];
	$sql="SELECT DISTINCT
			strSize
			FROM style_ratio_plugin
			WHERE strStyle='$orderId'";
	$result=$db->RunQuery($sql);
	$size="";
	while($row=mysql_fetch_array($result))
	{
		$size.=$row['strSize'];
		$size.=",";
	}
	echo $size;
}
if ($request=='load_color')
{
	$orderId=$_GET['orderId'];
	$sql="SELECT DISTINCT
			strColor
			FROM
			orderspecdetails
			WHERE
			intOrderId=$orderId";
	$result=$db->RunQuery($sql);
	$color="";		
	while($row=mysql_fetch_array($result))
	{
		$color.=$row['strColor'];
		$color.=",";
	}
	echo $color;
}
if($request=='load_OrderQty')
{
	$orderId=$_GET['orderId'];
	$color=$_GET['color'];
	$size=$_GET['size'];
	$preType=$_GET['preType'];
	
	$color = addslashes($color);
	
	$sql="SELECT sum(dblPcs) AS dblPcs
		  FROM orderspecdetails 
		  WHERE intOrderId=$orderId AND strColor='$color' AND strSize='$size' AND strPrePackType='$preType'";
	
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		echo round($row['dblPcs'],0);
	}
	
}
if ($request=='gen_ctns_combo')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$str="SELECT 	
		intCartoonId, 
		intLength, 
		intWidth, 
		intHeight, 
		strCartoon, 
		dblWeight, 
		strDescription, 
		dtmSaveDate, 
		intUserId		 
		FROM
		cartoon
		WHERE intUserId='$userId'	 
		   ";
	$result=$db->RunQuery($str);
	$xml_string='<data>';
	while($row = mysql_fetch_array($result))
	{			
		$xml_string .= "<CartonId><![CDATA[" . $row["intCartoonId"]   . "]]></CartonId>\n";	
		$xml_string .= "<Carton><![CDATA[" . $row["strCartoon"]   . "]]></Carton>\n";	
		$xml_string .= "<Weight><![CDATA[" . $row["dblWeight"]   . "]]></Weight>\n";	
	}
	$xml_string.='</data>';
	echo $xml_string;
}
if($request=='save_pl_no')
{
		$str_plno			="select dblPLno from  syscontrol";
		$result_plno		=$db->RunQuery($str_plno);
		$holder_plno		=mysql_fetch_array($result_plno);
		$str_plno_update	="update syscontrol set dblPLno=dblPLno+1";
		$result_plno_update	=$db->RunQuery($str_plno_update);
		$PLNo				=$holder_plno['dblPLno'];
		
		/*$str_plno			="select dblPLno from  syscontrol";
		$result_plno		=$mdb->RunQueryM($str_plno);
		$holder_plno		=mysql_fetch_array($result_plno);
		$str_plno_update	="update syscontrol set dblPLno=dblPLno+1";
		$result_plno_update	=$mdb->RunQueryM($str_plno_update);
		$PLNo				=$holder_plno['dblPLno'];*/
		
		echo $PLNo;
}

if($request=='save_pl_header')
{
	$PLNo=$_GET['plno'];
	$orderId=$_GET['orderId'];
	
	$str_del_header			="delete from shipmentplheader where strPLNo='$PLNo'";
	$result_del_header		=$db->RunQuery($str_del_header);
	$str_del_index			="delete from shipmentplsizeindex where strPLNo='$PLNo'";
	$result_del_index		=$db->RunQuery($str_del_index);
	$str_del_detail			="delete from shipmentpldetail where strPLNo='$PLNo'";
	$result_del_detail		=$db->RunQuery($str_del_detail);
	$str_del_subdetail		="delete from shipmentplsubdetail where strPLNo='$PLNo'";
	$result_del_subdetail	=$db->RunQuery($str_del_subdetail);
	
	$sql_style="SELECT strStyle_No FROM orderspec WHERE strOrder_No='$orderId';";
	$result_style=$db->RunQuery($sql_style);
	$row_style=mysql_fetch_array($result_style);
	$productCode = $row_style['strStyle_No'];
	
	$str		="insert into shipmentplheader 
	(strPLNo, strStyle, strProductCode, strSailingDate)
	values
	('$PLNo','$orderId','$productCode',now())";
	
	$result=$db->RunQuery($str);
}

if($request=='load_pack_no')
{
	$size=$_GET['size'];
	$poNo=$_GET['poNo'];
	$color=$_GET['color'];
	$packType=$_GET['packType'];
	
	if($packType=='1Pre Pack')
		$packType='SINGLE';
	else if($packType=='2Ratio')
		$packType='MULTIPLE';
	else if($packType=='3Bulk')
		$packType='BULK';
	
	$str_packno			="SELECT
							orderspecdetails.strPrePackNo
							FROM
							orderspecdetails
							WHERE intOrderId=$poNo AND strColor='$color' AND strSize='$size'
							AND strPrePackType='$packType'";
		$result_packno		=$db->RunQuery($str_packno);
		$holder_packno		=mysql_fetch_array($result_packno);
		$PACKNo				=$holder_packno['strPrePackNo'];
		
		echo $PACKNo;
}

if($request=='load_pre_pack_no')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$poNo = $_GET['poNo'];
	$sql_order = "SELECT
					orderspecdetails.strSize,
					orderspecdetails.strColor,
					orderspecdetails.strPrePackType,
					orderspecdetails.strPrePackNo
					FROM
					orderspecdetails
					INNER JOIN orderspec ON orderspec.intOrderId = orderspecdetails.intOrderId
					WHERE orderspec.intOrderId='$poNo'
					";
					
	$result_pre = $db->RunQuery($sql_order);
	$xml_string='<data>';
	while($row_pre = mysql_fetch_array($result_pre))
	{			
		$xml_string .= "<Size><![CDATA[" . $row_pre["strSize"]   . "]]></Size>\n";	
		$xml_string .= "<Color><![CDATA[" . $row_pre["strColor"]   . "]]></Color>\n";	
		$xml_string .= "<PrePackType><![CDATA[" . $row_pre["strPrePackType"]   . "]]></PrePackType>\n";
		$xml_string .= "<PrePackNo><![CDATA[" . $row_pre["strPrePackNo"]   . "]]></PrePackNo>\n";	
	}
	$xml_string.='</data>';
	echo $xml_string;
}

?>