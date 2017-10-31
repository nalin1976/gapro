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
		$ResponseXML .= "<DESCRIPTION>\n";	 
	
		 $str =  getItemName($styleNo,$mainCat);
		 
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
	
	function getSRNumber($styleID)
	{
		global $db;
		$sql="SELECT intSRNO FROM specification where intStyleId='".$styleID."' AND intOrdComplete=0;";
		return $db->RunQuery($sql);
	}
	function getItemName($styleNo,$mainCat)
	{
		global $db;
		$sql="SELECT
orderdetails.intStyleId,
orderdetails.intMatDetailID,
matitemlist.intItemSerial,
matitemlist.strItemDescription,
matitemlist.intMainCatID,
orders.strStyle
FROM
orders
Inner Join orderdetails ON orders.intStyleId = orderdetails.intStyleId
Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial where strStyle='".$styleNo."' AND intMainCatID='".$mainCat."'";
		
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
		 $strOrder .= "<option value=\"". "" ."\">" . "" ."</option>";
		 
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
		
		 $strSC .= "<option value=\"". "" ."\">" . "" ."</option>";
		 
		 while($row = mysql_fetch_array($result_style))
		 {
			$strSC .= "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>";
		 }
		 
		 return $strSC;
	}
	 
?>
