<?php
session_start();
include "../Connector.php";
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

/*$ResponseXML .= "<order>";

$StyleID = $_GET["StyleID"];
$Color = $_GET["Color"];
$Size = $_GET["Size"];

	
    $SQL="SELECT grnheader.intStatus,grndetails.intGrnNo,purchaseorderdetails.intPoNo,grndetails.dblQty,purchaseorderdetails.dblQty as poqty FROM grnheader INNER JOIN grndetails ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear RIGHT JOIN purchaseorderdetails ON grndetails.intStyleId = purchaseorderdetails.intStyleId AND grndetails.intMatDetailID = purchaseorderdetails.intMatDetailID AND grndetails.strColor = purchaseorderdetails.strColor AND grndetails.strSize = purchaseorderdetails.strSize WHERE purchaseorderdetails.intStyleId =  '".$StyleID."' AND purchaseorderdetails.strColor =  '".$Color."' AND purchaseorderdetails.strSize =  '".$Size."' AND purchaseorderdetails.intMatDetailID =  '9';";
	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
         $ResponseXML .= "<PoNo><![CDATA[" . $row["intPoNo"]  . "]]></PoNo>\n";
		 $ResponseXML .= "<GrnNo><![CDATA[" . $row["intGrnNo"]  . "]]></GrnNo>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		 $ResponseXML .= "<PoQty><![CDATA[" . $row["poqty"]  . "]]></PoQty>\n";
		 $ResponseXML .= "<GrnQty><![CDATA[" . $row["dblQty"]  . "]]></GrnQty>\n";
         $confirm = $row["intStatus"];
		 if ($confirm==1)
		 {
		   $ResponseXML .= "<Confirm><![CDATA[Confirm]]></Confirm>\n";
		 }
		 else if ($confirm==0)
		 {
		   $ResponseXML .= "<Confirm><![CDATA[Pending]]></Confirm>\n";
		 }
		 else 
		 {
		   $ResponseXML .= "<Confirm><![CDATA[Cancel]]></Confirm>\n";
		 }
	}
	 $ResponseXML .= "</order>";
	 echo $ResponseXML;*/
	 
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
			$ResponseXML .= "<BuyerPO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPO>\n";
		 }	
		 $ResponseXML .= "</StyleBuyerPO>";	 
		 echo $ResponseXML;
	}
	
	function getSRNumber($styleID)
	{
		global $db;
		$sql="SELECT intSRNO FROM specification where intStyleId='".$styleID."';";
		return $db->RunQuery($sql);
	}
	
	function getStyleID($scno)
	{
		global $db;
		/*$sql="SELECT DISTINCT materialratio.intStyleId FROM materialratio inner join orders on  materialratio.intStyleId = orders.intStyleId  where ( dblBalQty>0 or dblFreightBalQty>0 ) AND orders.intStatus = 11; ";*/
		$sql="SELECT intStyleId FROM specification where intSRNO='".$scno."';";		
		return $db->RunQuery($sql);
	}
	 
	function getBuyerPO($styleno)
	{
		global $db;
		$sql="SELECT DISTINCT style_buyerponos.strBuyerPONO
			FROM style_buyerponos
			WHERE style_buyerponos.intStyleId =  '". $styleno ."' ORDER BY style_buyerponos.strBuyerPONO ASC ;";		
		return $db->RunQuery($sql);
	}
	 
?>
