<?php
session_start();
include "../../Connector.php";
header('Content-Type: text/xml'); 
$Request=$_GET["Request"];

if($Request=="loadItem")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$styleID = $_GET["styleID"];
	$ResponseXML = "<XMLLoadItem>\n";
	
	$sql_load = "select SP.intStyleId,O.strOrderNo
					from specification SP
					INNER JOIN orders O ON O.intStyleId=SP.intStyleId
					where (O.intStatus=0 or O.intStatus=10 or O.intStatus=11)";
					
	if($styleID!="")
	{
		$sql_load.="and O.strStyle='$styleID'";
	}
	$sql_load.="order by O.strOrderNo asc";
	
	$result_load =$db->RunQuery($sql_load);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
		while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["strOrderNo"]."</option>\n";	
		}
		$ResponseXML .= "</XMLLoadItem>\n";
		echo $ResponseXML;
}
if($Request=="loadSCNo")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$styleID = $_GET["styleID"];
	$ResponseXML = "<XMLLoadSCNO>\n";
	
	$sql_load = "select SP.intStyleId,SP.intSRNO
					from specification SP
					INNER JOIN orders O ON O.intStyleId=SP.intStyleId
					where (O.intStatus=0 or O.intStatus=10 or O.intStatus=11) ";
	if($styleID!="")
	{
		$sql_load.="and O.strStyle='$styleID'";
	}
	$sql_load.="order by SP.intStyleId desc";
	
	$result_load =$db->RunQuery($sql_load);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
		while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["intSRNO"]."</option>\n";	
		}
		$ResponseXML .= "</XMLLoadSCNO>\n";
		echo $ResponseXML;
}
if($Request=="loadshippingData")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$ResponseXML="<XMLShippingdata>";
	$orderID = $_GET["orderID"];
	$booCheck = CheckSaveData($orderID);
	if($booCheck)
	{
		$sql_saveData = "select 	FOS.intStyleId, 
									FOS.strMaterialNo, 
									FOS.strConstructionType, 
									FOS.strLabel, 
									FOS.strPrePackCode, 
									FOS.dblCTN_l, 
									FOS.dblCTN_w, 
									FOS.dblCTN_h, 
									FOS.strWashCode, 
									FOS.strArticle, 
									FOS.strItemNo, 
									FOS.strItemGeneralDesc, 
									FOS.strItemSpecDesc, 
									FOS.strManufactOrderNo, 
									FOS.strManufactStyle, 
									FOS.strSortingType, 
									FOS.strWeightUnit, 
									FOS.strMRP,
									FOS.strHSCode,
									FOS.strMondialPONo,
									O.intSeasonId,
									O.intDivisionId,
									O.intCompanyID,
									O.strOrderColorCode,
									O.strStyle
									 
									from 
									finishing_order_spec FOS
									INNER JOIN orders O ON O.intStyleId=FOS.intStyleId
									where O.intStyleId='$orderID';";
		
		$result = $db->RunQuery($sql_saveData);
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"]  . "]]></StyleID>\n";
			$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
			$ResponseXML .= "<strMaterialNo><![CDATA[" . $row["strMaterialNo"]  . "]]></strMaterialNo>\n";
			$ResponseXML .= "<strConstructionType><![CDATA[" . $row["strConstructionType"]  . "]]></strConstructionType>\n";
			$ResponseXML .= "<strLabel><![CDATA[" . $row["strLabel"]  . "]]></strLabel>\n";
			$ResponseXML .= "<strPrePackCode><![CDATA[" . $row["strPrePackCode"]  . "]]></strPrePackCode>\n";
			$ResponseXML .= "<dblCTN_l><![CDATA[" . $row["dblCTN_l"]  . "]]></dblCTN_l>\n";
			$ResponseXML .= "<dblCTN_w><![CDATA[" . $row["dblCTN_w"]  . "]]></dblCTN_w>\n";
			$ResponseXML .= "<dblCTN_h><![CDATA[" . $row["dblCTN_h"]  . "]]></dblCTN_h>\n";
			$ResponseXML .= "<strWashCode><![CDATA[" . $row["strWashCode"]  . "]]></strWashCode>\n";
			$ResponseXML .= "<strArticle ><![CDATA[" . $row["strArticle"]  . "]]></strArticle>\n";
			$ResponseXML .= "<strItemNo ><![CDATA[" . $row["strItemNo"]  . "]]></strItemNo>\n";		
			$ResponseXML .= "<strItemGeneralDesc ><![CDATA[" . $row["strItemGeneralDesc"]  . "]]></strItemGeneralDesc>\n";
			$ResponseXML .= "<strItemSpecDesc ><![CDATA[" . $row["strItemSpecDesc"]  . "]]></strItemSpecDesc>\n";
			$ResponseXML .= "<strManufactOrderNo><![CDATA[" . $row["strManufactOrderNo"]  . "]]></strManufactOrderNo>\n";
			$ResponseXML .= "<strManufactStyle><![CDATA[" . $row["strManufactStyle"]  . "]]></strManufactStyle>\n";
			$ResponseXML .= "<strSortingType><![CDATA[" . $row["strSortingType"]  . "]]></strSortingType>\n";
			$ResponseXML .= "<strWeightUnit><![CDATA[" . $row["strWeightUnit"]  . "]]></strWeightUnit>\n";
			$ResponseXML .= "<strMRP><![CDATA[" . $row["strMRP"]  . "]]></strMRP>\n";			
			$ResponseXML .= "<intDivisionId><![CDATA[" . $row["intDivisionId"]  . "]]></intDivisionId>\n";
			$ResponseXML .= "<intSeasonId><![CDATA[" . $row["intSeasonId"]  . "]]></intSeasonId>\n";
			$ResponseXML .= "<intCompanyID><![CDATA[" . $row["intCompanyID"]  . "]]></intCompanyID>\n";
			$ResponseXML .= "<strOrderColorCode><![CDATA[" . $row["strOrderColorCode"]  . "]]></strOrderColorCode>\n";
			$ResponseXML .= "<strHSCode><![CDATA[" . $row["strHSCode"]  . "]]></strHSCode>\n";
			$ResponseXML .= "<MondialPONo><![CDATA[" . $row["strMondialPONo"]  . "]]></MondialPONo>\n";
			$ResponseXML .= "<Type><![CDATA[" . 1  . "]]></Type>\n";
		
		}
	}
	else
	{
		$sql_order = "  select  O.intStyleId,
						O.strStyle,
						O.intDivisionId ,
						O.strOrderColorCode,
						O.intSeasonId,
						O.intCompanyID
						
						from orders O
						where O.intStyleId ='$orderID';";
		$result = $db->RunQuery($sql_order);
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"]  . "]]></StyleID>\n";
			$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"]  . "]]></strStyle>\n";
			$ResponseXML .= "<intSeasonId><![CDATA[" . $row["intSeasonId"]  . "]]></intSeasonId>\n";
			$ResponseXML .= "<intDivisionId><![CDATA[" . $row["intDivisionId"]  . "]]></intDivisionId>\n";
			$ResponseXML .= "<strOrderColorCode><![CDATA[" . $row["strOrderColorCode"]  . "]]></strOrderColorCode>\n";
			$ResponseXML .= "<intCompanyID><![CDATA[" . $row["intCompanyID"]  . "]]></intCompanyID>\n";
			$ResponseXML .= "<Type><![CDATA[" . 0 . "]]></Type>\n";
			
		}
	}
	$ResponseXML .="</XMLShippingdata>"; 
	echo $ResponseXML;
}
if($Request=="SaveshippingData")
{
	$orderNo		= $_GET['orderNo'];
	$material		= $_GET['material'];
	$ConType		= $_GET['ConType'];
	$Lable			= $_GET['Lable'];
	$MRP			= ($_GET['MRP']==""?'null':$_GET['MRP']);
	$PrePackCode	= $_GET['PrePackCode'];
	$CTN_l			= ($_GET['CTN_l']==""?'null':$_GET['CTN_l']);
	$CTN_w			= ($_GET['CTN_w']==""?'null':$_GET['CTN_w']);
	$CTN_h			= ($_GET['CTN_w']==""?'null':$_GET['CTN_w']);
	$WashCode		= $_GET['WashCode'];
	$Article		= $_GET['Article'];
	$ItemNo			= $_GET['ItemNo'];
	$GenItem		= $_GET['GenItem'];
	$SpecItem		= $_GET['SpecItem'];
	$ManuOrdNo		= $_GET['ManuOrdNo'];
	$ManuStyle		= $_GET['ManuStyle'];
	$SortType		= $_GET['SortType'];
	$WTUnit			= $_GET['WTUnit'];
	$HSCode			= $_GET['HSCode'];
	$mondialPONo	= $_GET['mondialPONo'];

  if(!checkValueExist($orderNo))
  {	
	$sql_save = "insert into finishing_order_spec 
					(intStyleId, 
					 strMaterialNo, 
					 strConstructionType, 
					 strLabel, 
					 strPrePackCode, 
					 dblCTN_l, 
					 dblCTN_w, 
					 dblCTN_h, 
					 strWashCode, 
					 strArticle, 
					 strItemNo, 
					 strItemGeneralDesc, 
					 strItemSpecDesc, 
					 strManufactOrderNo, 
					 strManufactStyle, 
					 strSortingType, 
					 strWeightUnit, 
					 strMRP, 
					 strHSCode,
					 strMondialPONo
					)
					values
					(
					  $orderNo,
					 '$material',
					 '$ConType',
					 '$Lable',
					 '$PrePackCode',
					  $CTN_l,
					  $CTN_w,
					  $CTN_h,
					 '$WashCode',
					 '$Article',
					 '$ItemNo',
					 '$GenItem',
					 '$SpecItem',
					 '$ManuOrdNo',
					 '$ManuStyle',
					 '$SortType',
					 '$WTUnit',
					  $MRP,
					 '$HSCode',
					 '$mondialPONo'
					)
					";
	$result_save=$db->RunQuery($sql_save) ;
	if($result_save)
		echo "saved";
	else
		echo "error";	
  }
  else
  {
  	$sql_update = "update finishing_order_spec 
					set
					intStyleId = $orderNo , 
					strMaterialNo = '$material' , 
					strConstructionType = '$ConType' , 
					strLabel = '$Lable' , 
					strPrePackCode = '$PrePackCode' , 
					dblCTN_l = $CTN_l , 
					dblCTN_w = $CTN_w , 
					dblCTN_h = $CTN_h , 
					strWashCode = '$WashCode' , 
					strArticle = '$Article' , 
					strItemNo = '$ItemNo' , 
					strItemGeneralDesc = '$GenItem' , 
					strItemSpecDesc = '$SpecItem' , 
					strManufactOrderNo = '$ManuOrdNo' , 
					strManufactStyle = '$ManuStyle' , 
					strSortingType = '$SortType' , 
					strWeightUnit = '$WTUnit' , 
					strMRP = $MRP , 
					strHSCode = '$HSCode',
					strMondialPONo = '$mondialPONo'
					where
					intStyleId = $orderNo ;";
	
	 $result_update=$db->RunQuery($sql_update) ;
		
		if($result_update)
			echo"update";
		else
			echo"updateerror";
  }	

	
}
function checkValueExist($orderNo)
{
	global $db;
	$sql="select * from finishing_order_spec where intStyleId='$orderNo';";
	$result=$db->RunQuery($sql);
	if(mysql_num_rows($result) > 0)
	 return true;
	else
	 return false;
}
function CheckSaveData($orderId)
{
global $db;
	$boo = false;
	$sql="select intStyleId from finishing_order_spec where intStyleId='$orderId'";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$boo = true;
	}
return $boo;
}
?>