<?php
session_start();
include "../Connector.php";
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
 
	$RequestType = $_GET["RequestType"];
	if (strcmp($RequestType,"SRNo") == 0)
	{
		 $ResponseXML = "";
		 $StyleID=$_GET["StyleID"];
		 $ResponseXML .= "<SRNO>\n";
		 
		 $result=getSRNumber($StyleID);
		 
		 while($row = mysql_fetch_array($result))
		 {
			 $ResponseXML .= "<SR><![CDATA[" . $row["intSRNO"]  . "]]></SR>\n";		   
		 }
		 $ResponseXML .= "</SRNO>";
		 echo $ResponseXML;
	 }
	 else if (strcmp($RequestType,"loadItem") == 0)
	{
		 $ResponseXML = "";
		$mainCat=$_GET["mainCat"];
		$styleNo=$_GET["styleNo"];
		$orderNo=$_GET["orderNo"];	 
		$ResponseXML .= "<DESCRIPTION>\n";	 
	
		 $str =  getItemName($styleNo,$mainCat,$orderNo);
		 
		 $ResponseXML .= "<DES><![CDATA[" . $str  . "]]></DES>\n";
		// $ResponseXML .= "<styleSCNo><![CDATA[" . $strSC  . "]]></styleSCNo>\n";
		 
		 $ResponseXML .= "</DESCRIPTION>";	 
		 echo $ResponseXML;
	 }
	else if(strcmp($RequestType,"StyleNo") == 0)
	{
		$ResponseXML = "";
		$scno=$_GET["ScNo"];	 
		$ResponseXML .= "<StyleID>\n";	 
		
		 $result=getStyleID($scno);	
		  
		 while($row = mysql_fetch_array($result))
		 {
			$ResponseXML .= "<Style><![CDATA[" . $row["intStyleId"]  . "]]></Style>\n";
		 }	
		 $ResponseXML .= "</StyleID>";	 
		 echo $ResponseXML;
	}
	else if(strcmp($RequestType,"LoadBuyerPO") == 0)
	{
		$ResponseXML = "";
		$styleno=$_GET["StyleId"];	 
		$ResponseXML .= "<StyleBuyerPO>\n";	 
		
		 $result=getBuyerPO($styleno);	
		  
		 while($row = mysql_fetch_array($result))
		 {
		 	if($row["strBuyerPONO"]=="#Main Ratio#")
				$buyersPoName	= "#Main Ratio#";
			else
				$buyersPoName = GetBuyerPoName($row["strBuyerPONO"]);
				
			$ResponseXML .= "<BuyerPO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPO>\n";
			$ResponseXML .= "<BuyerPoName><![CDATA[" . $buyersPoName  . "]]></BuyerPoName>\n";
		 }	
		 $ResponseXML .= "</StyleBuyerPO>";	 
		 echo $ResponseXML;
	}
	else if(strcmp($RequestType,"getStyleWiseOrderandSC") == 0)
	{
		$ResponseXML = "";
		$stytleName=$_GET["stytleName"];	 
		$ResponseXML .= "<StyleOrderPO>\n";	 
	
		 $strOrder =  getStyleWiseOrderList($stytleName);
		 $strSC = getStyleWiseSCList($stytleName);
		 
		 $ResponseXML .= "<styleOrderNo><![CDATA[" . $strOrder  . "]]></styleOrderNo>\n";
		 $ResponseXML .= "<styleSCNo><![CDATA[" . $strSC  . "]]></styleSCNo>\n";
		 
		 $ResponseXML .= "</StyleOrderPO>";	 
		 echo $ResponseXML;
	}
	else if(strcmp($RequestType,"getSCWiceStyleNo") == 0)
	{
		$ResponseXML = "";
		$scNO=$_GET["scNO"];	 
		$ResponseXML .= "<scStyleWise>\n";	 
	
		 $strOrder =  getSCWiceStyleNO($scNO);
		 
		 $ResponseXML .= "<styleNOS><![CDATA[" . $strOrder  . "]]></styleNOS>\n";
	
		 $ResponseXML .= "</scStyleWise>";	 
		 echo $ResponseXML;
	}
	else if(strcmp($RequestType,"getMainCategories") == 0)
	{
		$ResponseXML = "";
		$stytleNo=$_GET["stytleNo"];	 
		$ResponseXML .= "<matStyleWise>\n";	 
	
		 $strMatCat =  getMainCategory($stytleNo);
		 
		 $ResponseXML .= "<matCat><![CDATA[" . $strMatCat  . "]]></matCat>\n";
	
		 $ResponseXML .= "</matStyleWise>";	 
		 echo $ResponseXML;
	}
	else if(strcmp($RequestType,"getItemDescription") == 0)
	{
		$ResponseXML = "";
		$stytleNo=$_GET["stytleNo"];	 
		$ResponseXML .= "<descriptionStyleWise>\n";	 
	
		 $strItemDes =  getItemDescriptions($stytleNo);
		 
		 $ResponseXML .= "<ItemDescription><![CDATA[" . $strItemDes  . "]]></ItemDescription>\n";
	
		 $ResponseXML .= "</descriptionStyleWise>";	 
		 echo $ResponseXML;
	}
	function getSRNumber($styleID)
	{
		global $db;
		$sql="SELECT intSRNO FROM specification where intStyleId='".$styleID."' AND intOrdComplete=0;";
		return $db->RunQuery($sql);
	}
	function getMainCategory($stytleNo)
	{
		global $db;
		$sql="SELECT DISTINCT
matitemlist.intMainCatID,
matmaincategory.strDescription
FROM
orderdetails
Left Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial
Inner Join matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
Inner Join orders ON orders.intStyleId = orderdetails.intStyleId
WHERE
orders.strStyle = '".$stytleNo."' ;";
		$result = $db->RunQuery($sql);
		 $str .= "<option value=\"". "" ."\">" . "" ."</option>";
		 
		 while($row = mysql_fetch_array($result))
		 {
			$str .= "<option value=\"". $row["intMainCatID"] ."\">" . $row["strDescription"] ."</option>";
		 }
		 
		 return $str;
	}
	function getItemDescriptions($stytleNo)
	{
		global $db;
		$sql="SELECT DISTINCT
matitemlist.intItemSerial,
matitemlist.strItemDescription
FROM
orderdetails
Left Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial
Inner Join matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
Inner Join orders ON orders.intStyleId = orderdetails.intStyleId
WHERE
orders.strStyle = '".$stytleNo."' ;";
		$result = $db->RunQuery($sql);
		 $str .= "<option value=\"". "" ."\">" . "" ."</option>";
		 
		 while($row = mysql_fetch_array($result))
		 {
			$str .= "<option value=\"". $row["intItemSerial"] ."\">" . $row["strItemDescription"] ."</option>";
		 }
		 
		 return $str;
	}
	function getItemName($styleNo,$mainCat,$orderNo)
	{
		global $db;
		$sql="SELECT
matitemlist.intItemSerial,
matitemlist.strItemDescription,
matitemlist.intMainCatID,
specificationdetails.intStyleId,
specificationdetails.strMatDetailID
FROM
matitemlist
INNER JOIN specificationdetails ON matitemlist.intItemSerial = specificationdetails.strMatDetailID
WHERE  specificationdetails.intStyleId = '$orderNo'";
if($mainCat != '')
				$sql .= " and matitemlist.intMainCatID = '$mainCat'";
				
		
		$result = $db->RunQuery($sql);
		 $str .= "<option value=\"". "" ."\">" . "" ."</option>";
		 
		 while($row = mysql_fetch_array($result))
		 {
			$str .= "<option value=\"". $row["intItemSerial"] ."\">" . $row["strItemDescription"] ."</option>";
		 }
		 
		 return $str;
	}
	
	function getStyleID($scno)
	{
		global $db;
		$sql="SELECT intStyleId FROM specification where intSRNO='".$scno."' AND intOrdComplete=0;";		
		return $db->RunQuery($sql);
	}
	 
	function getBuyerPO($styleno)
	{
		global $db;
		/*$sql="SELECT DISTINCT style_buyerponos.strBuyerPONO
			FROM style_buyerponos
			WHERE style_buyerponos.intStyleId =  '". $styleno ."' ORDER BY style_buyerponos.strBuyerPONO ASC ;";	*/
		$sql="select distinct strBuyerPONO from materialratio where intStyleId='". $styleno ."' ".
			"ORDER BY strBuyerPONO";	
		return $db->RunQuery($sql);
	}
	function GetBuyerPoName($buyerPoId)
	{
		global $db;
		$sql="select strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoId'";
		$result=$db->RunQuery($sql);
		$row = mysql_fetch_array($result);
		return $row["strBuyerPoName"];
	}
	
	function getStyleWiseOrderList($styleName)
	{
		global $db;
		$SQL_Order = "SELECT orders.strOrderNo, orders.intStyleId FROM orders
					Inner Join specification ON orders.intStyleId = specification.intStyleId
					WHERE orders.intStatus not in (2,12,13) ";
					
					
			if($styleName != '')
				$SQL_Order .= " and orders.strStyle = '$styleName'";
				
			$SQL_Order .= " ORDER BY orders.strStyle ASC ";	
			
		 $resultOrder = $db->RunQuery($SQL_Order);
		// $strOrder .= "<option value=\"". "" ."\">" . "" ."</option>";
		 
		 while($rowO = mysql_fetch_array($resultOrder))
		 {
			$strOrder .= "<option value=\"". $rowO["intStyleId"] ."\">" . $rowO["strOrderNo"] ."</option>";
		 }
		 
		 return $strOrder;
	}
	
	function getStyleWiseSCList($styleName)
	{
		global $db;
		$SQL_style = "SELECT specification.intSRNO, specification.intStyleId FROM orders
					Inner Join specification ON orders.intStyleId = specification.intStyleId
					WHERE orders.intStatus  not in (2,12,13)  ";
		
		if($styleName != '')
				$SQL_style .= " and orders.strStyle = '$styleName'";
				
		$SQL_style .= " ORDER BY specification.intSRNO DESC ";	
				
		$result_style = $db->RunQuery($SQL_style);
		
		 //$strSC .= "<option value=\"". "" ."\">" . "" ."</option>";
		 
		 while($row = mysql_fetch_array($result_style))
		 {
			$strSC .= "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>";
		 }
		 
		 return $strSC;
	}
	function getSCWiceStyleNO($scNO)
	{
		global $db;
		$SQL_style = "SELECT specification.intSRNO,orders.strStyle ,specification.intStyleId FROM orders
					Inner Join specification ON orders.intStyleId = specification.intStyleId
					WHERE orders.intStatus  not in (2,12,13)  ";
		
		if($scNO != '')
				$SQL_style .= " and specification.intStyleId = '$scNO'";
				
		$SQL_style .= " ORDER BY specification.intSRNO DESC ";	
			//echo $SQL_style;	
		$result_style = $db->RunQuery($SQL_style);
		
		 //$strSC .= "<option value=\"". "" ."\">" . "" ."</option>";
		 
		 while($row = mysql_fetch_array($result_style))
		 {
			$strSC .= "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>";
		 }
		 
		 return $strSC;
	}
	
	 
?>
