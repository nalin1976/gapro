<?php 
session_start();
include("../../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["REQUEST"];


if ($request=='saveDetails')
{	
	$editOrderNo	  = $_GET["editOrderNo"];
    $orderNo     	  = $_GET["orderNo"];
	$styleNo     	  = $_GET["styleNo"];
	$styleDesc   	  = $_GET["styleDesc"];
	$unitPrice   	  = $_GET["unitPrice"];
	if($unitPrice=="")
	{
		$unitPrice = 0;
	}
	//$maxRePrice  	  = $_GET["maxRePrice"];
	//if($maxRePrice=="")
	//{
		//$maxRePrice = 0;
	//}
	$quality		  = $_GET["quality"];	
	$gender      	  = $_GET["gender"];
	$mateNo      	  = $_GET["mateNo"];
	//$fabric      	  = $_GET["fabric"];
	//$label       	  = $_GET["label"];
	$season      	  = $_GET["season"];
	$buyer       	  = $_GET["buyer"];
	$division    	  = $_GET["division"];
	$itemNo      	  = $_GET["itemNo"];
	$Item        	  = $_GET["Item"];
	$sortingType 	  = $_GET["sortingType"];
	$washCode    	  = $_GET["washCode"];
	$constructionType = $_GET["constructionType"];
	$garment          = $_GET["garment"];
	$unitP			  = $_GET["unitP"];
		
	if($editOrderNo=="")
	{
		$sql = "Insert Into orderspec (strOrder_No,strStyle_No,strStyle_Description,strWFXId,strQuality,
			    strGender,strMaterial,strSeason,strBuyer,strDivision_Brand,strItem_no,strItem,strSorting_Type,
			    strWash_Code,strConstruction,strGarment_Type,intStatus,strUnit) values('$orderNo','$styleNo','$styleDesc','$unitPrice','$quality','$gender','$mateNo',
			    '$season','$buyer','$division','$itemNo','$Item','$sortingType','$washCode','$constructionType','$garment','1','$unitP')";
			  
		$result = $db->RunQuery($sql);
		
		$sqlInvoice="SELECT intOrderId FROM orderspec where strOrder_No='$orderNo'";
        $resultInvoice=$db->RunQuery($sqlInvoice);
		$rowID=mysql_fetch_array( $resultInvoice);
		echo $rowID["intOrderId"];
	}
	else
	{
		$sql = "Update orderspec set strOrder_No='$orderNo',strStyle_No='$styleNo',strStyle_Description='$styleDesc',strWFXId='$unitPrice',
			   strQuality='$quality',strGender='$gender',strMaterial='$mateNo',
			   strSeason='$season',strBuyer='$buyer',strDivision_Brand='$division',strItem_no='$itemNo',
			   strItem='$Item',strSorting_Type='$sortingType',strWash_Code='$washCode',strConstruction='$constructionType',
			   strGarment_Type='$garment',strUnit='$unitP' Where intOrderId='$editOrderNo'";
		  
	$result1 = $db->RunQuery($sql);
	}
	if($result1)
	{
		echo -99;
	}

}

if ($request=='loadDetails')
{	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$orderno = $_GET["orderno"];

	$sql="SELECT * FROM orderspec WHERE intOrderId='$orderno' AND intStatus='1'";
	
	$XMLString .= "<DeliveryData>";	
	
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{
		
		$XMLString .= "<strStyle_No><![CDATA[" . $row["strStyle_No"]  . "]]></strStyle_No>\n";
		$XMLString .= "<strStyle_Description><![CDATA[" . $row["strStyle_Description"]  . "]]></strStyle_Description>\n";
		$XMLString .= "<dblUnit_Price><![CDATA[" . round($row["strWFXId"]) . "]]></dblUnit_Price>\n";
		//$XMLString .= "<dblMax_retail_price><![CDATA[" . $row["dblMax_retail_price"]  . "]]></dblMax_retail_price>\n";
		$XMLString .= "<strQuality><![CDATA[" . $row["strQuality"]  . "]]></strQuality>\n";
		$XMLString .= "<strGender><![CDATA[" . $row["strGender"]  . "]]></strGender>\n";
		$XMLString .= "<strMaterial><![CDATA[" . $row["strMaterial"]  . "]]></strMaterial>\n";
		//$XMLString .= "<strFabric><![CDATA[" . $row["strFabric"]  . "]]></strFabric>\n";
		$XMLString .= "<strUnit><![CDATA[" . $row["strUnit"]  . "]]></strUnit>\n";
		$XMLString .= "<strSeason><![CDATA[" . $row["strSeason"]  . "]]></strSeason>\n";
		$XMLString .= "<strBuyer><![CDATA[" . $row["strBuyer"]  . "]]></strBuyer>\n";
		$XMLString .= "<strDivision_Brand><![CDATA[" . $row["strDivision_Brand"]  . "]]></strDivision_Brand>\n";
		$XMLString .= "<strItem_no><![CDATA[" . $row["strItem_no"]  . "]]></strItem_no>\n";
		$XMLString .= "<strItem><![CDATA[" . $row["strItem"]  . "]]></strItem>\n";
		$XMLString .= "<strSorting_Type><![CDATA[" . $row["strSorting_Type"]  . "]]></strSorting_Type>\n";
		$XMLString .= "<strWash_Code><![CDATA[" . $row["strWash_Code"]  . "]]></strWash_Code>\n";
		$XMLString .= "<strConstruction><![CDATA[" . $row["strConstruction"]  . "]]></strConstruction>\n";
		$XMLString .= "<strGarment_Type><![CDATA[" . $row["strGarment_Type"]  . "]]></strGarment_Type>\n";
		
	
	}

	$XMLString .= "</DeliveryData>";
	
	echo $XMLString;

}

if ($request=='checkOrderExist')
{	
	$OrderNo = $_GET["orderno"];
	$id      = $_GET["id"];
  
	
		$sql = "Select strOrder_No From orderspec Where strOrder_No='$OrderNo' And intOrderId!='$id'";
		  
	$result = $db->RunQuery($sql);
	
	if(mysql_num_rows($result)>0)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}

}

if($request=='loadDataGrid')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$orderID = $_GET["orderID"];
	
	$sql = "Select * From orderspecdetails Where intOrderId='$orderID'";
	
	$XMLString .= "<DeliveryData>";	
	
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{
		
		$XMLString .= "<strSize><![CDATA[" . $row["strSize"]  . "]]></strSize>\n";
		$XMLString .= "<strColor><![CDATA[" . $row["strColor"]  . "]]></strColor>\n";
		$XMLString .= "<ColorCode><![CDATA[" . $row["strColorCode"]  . "]]></ColorCode>\n";
		$XMLString .= "<dblPcs><![CDATA[" . $row["dblPcs"]  . "]]></dblPcs>\n";
		$XMLString .= "<dblNet><![CDATA[" . $row["dblPrice"]  . "]]></dblNet>\n";
		$XMLString .= "<strDescription><![CDATA[" . $row["strDescription"]  . "]]></strDescription>\n";
		$XMLString .= "<MRP><![CDATA[" . $row["dblMRP"]  . "]]></MRP>\n";
		$XMLString .= "<SKU><![CDATA[" . $row["strSKU"]  . "]]></SKU>\n";
		$XMLString .= "<Fabric><![CDATA[" . $row["strFabric"]  . "]]></Fabric>\n";
		$XMLString .= "<PliNo><![CDATA[" . $row["strPliNo"]  . "]]></PliNo>\n";
		$XMLString .= "<PrePackNo><![CDATA[" . $row["strPrePackNo"]  . "]]></PrePackNo>\n";
		$XMLString .= "<PrePackType><![CDATA[" . $row["strPrePackType"]  . "]]></PrePackType>\n";
		
	}

	$XMLString .= "</DeliveryData>";
	
	echo $XMLString;
	
}

if ($request=='saveDetailData')
{	
	$orderID  = $_GET["orderID"];
	$size	  = $_GET["size"];
	$colour	  = $_GET["colour"];
	$color_code	  = $_GET["color_code"];
	$pcs	  = $_GET["pcs"];
	$net	  = $_GET["net"];
	$mrp	  = $_GET["mrp"];
	$sku	  = $_GET["sku"];
	$fab	  = $_GET["fab"];
	$desc	  = $_GET["desc"];
	$plino	  = $_GET["plino"];
	$prepackno= $_GET["prepackno"];
	$prepacktype= $_GET["prepacktype"];
	
	if($pcs=="")
	{
		$pcs = 0;
	}
	if($net=="")
	{
		$net = 0;
	}
	if($mrp=="")
	{
		$mrp = 0;
	}
	
		
	    $sql2 = "Insert Into orderspecdetails (intOrderId,strSize,strColor,strColorCode,dblPcs,dblPrice,strDescription,intStatus,dblMRP,strSKU,strFabric,strPliNo,strPrePackNo,strPrePackType)
				 Values ('$orderID','$size','$colour','$color_code',$pcs,$net,'$desc','1',$mrp,'$sku','$fab','$plino','$prepackno','$prepacktype')";
	
		 $db->RunQuery($sql2);
	
}

if ($request=='saveHeadData')
{	
	$orderID  = $_GET["orderID"];
	$totsum	  = $_GET["totsum"];
	
		$sql = "Update orderspec set dblOrderQty=$totsum Where intOrderId='$orderID'";
		  
		$result = $db->RunQuery($sql);
	
}

if ($request=='DeleteDetail')
{	
	$orderID  = $_GET["orderID"];
	
	$sql1 = "Delete From orderspecdetails Where intOrderId='$orderID'";
	    $db->RunQuery($sql1);
	
}
?>