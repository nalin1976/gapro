<?php
session_start();
include "Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

//$db =new DBManager();

$RequestType = $_GET["RequestType"];

if (strcmp($RequestType,"GetItemListforCategory") == 0)
{
	 $ResponseXML = "";
	 $ItemID=$_GET["styleID"];
	 $ResponseXML .= "<Items>\n";
	 $result=getCategoryItemList($ItemID);
	// $str = "<option value=\"Select One\" selected=\"selected\">Select One</option>";
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 /*$ResponseXML .= "<ItemID><![CDATA[" . $row["intItemSerial"]  . "]]></ItemID>\n";
         $ResponseXML .= "<ItemName><![CDATA[" . $row["strItemDescription"]  . "]]></ItemName>\n";*/ 
		  $str .= "<option value=\"". $row["intItemSerial"] ."\">" . $row["strItemDescription"] ."</option>";              
	 }
	 
	 $ResponseXML .= "<ItemID><![CDATA[" . $str . "]]></ItemID>\n";
	 $ResponseXML .= "</Items>";
	 echo $ResponseXML;	
}
else if (strcmp($RequestType,"GetItemListforCategoryText") == 0)
{
	 $ResponseXML = "";
	 $ItemID=$_GET["styleID"];
	 $text=$_GET["filter"];
	 $ResponseXML .= "<Items>\n";
	 $result=getCategoryItemListForText($ItemID,$text);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 /*$ResponseXML .= "<ItemID><![CDATA[" . $row["intItemSerial"]  . "]]></ItemID>\n";
         $ResponseXML .= "<ItemName><![CDATA[" . $row["strItemDescription"]  . "]]></ItemName>\n";          */  
		 $str .= "<option value=\"". $row["intItemSerial"] ."\">" . $row["strItemDescription"] ."</option>";        
	 }
	 
	 $ResponseXML .= "<ItemID><![CDATA[" . $str . "]]></ItemID>\n";
	 $ResponseXML .= "</Items>";
	 echo $ResponseXML;	
}
else if(strcmp($RequestType,"SaveItems") == 0)
{
	$styleNo = $_GET["styleNo"];
	$itemCode = $_GET["itemCode"];
	$unitType = $_GET["unitType"];
	$unitPrice = $_GET["unitPrice"];
	$conPc = $_GET["conPc"];
	$wastage = $_GET["wastage"];
	$purchaseType = $_GET["purchaseType"];
	$orderType = $_GET["orderType"];
	$placement = $_GET["placement"];
	$ratioType = $_GET["ratioType"];
	$reqQty = $_GET["reqQty"];
	$totalQty = $_GET["totalQty"];
	$totalValue = $_GET["totalValue"];
	$costPC = $_GET["costPC"];
	$freight = $_GET["freight"];
	$originid = $_GET["originid"];
	
	$ResponseXML = "";
	$ResponseXML .= "<ResultSet>\n";
	
	$result = SaveSpecificationDetails($styleNo,$itemCode,$unitType,$unitPrice,$conPc,$wastage,$purchaseType,$orderType,$placement,$ratioType,$reqQty,$totalQty,$totalValue,$costPC,$freight,$originid);
	UpdatePurchaseType($styleNo,$itemCode,$purchaseType);
	
	
	if ($result)
	{
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
	}
	else
	{
		$ResponseXML .= "<Result><![CDATA[False]]></Result>\n";
	}
	
	$ResponseXML .= "</ResultSet>\n";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"UpdateItems") == 0)
{
	$styleNo = $_GET["styleNo"];
	$currentItemCode = $_GET["currentitemcode"];
	$itemCode = $_GET["itemCode"];
	$unitType = $_GET["unitType"];
	$unitPrice = $_GET["unitPrice"];
	$conPc = $_GET["conPc"];
	$wastage = $_GET["wastage"];
	$purchaseType = $_GET["purchaseType"];
	$orderType = $_GET["orderType"];
	$placement = $_GET["placement"];
	$ratioType = $_GET["ratioType"];
	$reqQty = $_GET["reqQty"];
	$totalQty = $_GET["totalQty"];
	$totalValue = $_GET["totalValue"];
	$costPC = $_GET["costPC"];
	$freight = $_GET["freight"];
	$originid = $_GET["originid"];
	
	$ResponseXML = "";
	$ResponseXML .= "<ResultSet>\n";
	
	if($currentItemCode != $itemCode)
	{
		$sql = "UPDATE materialratio SET strMatDetailID ='$itemCode' WHERE strMatDetailID ='$currentItemCode' AND intStyleId = '$styleNo';";
		$db->executeQuery($sql);
	}
	//Start - 20-08-2010 (Comment this because when edit a item material ratio must update)
	//$result = UpdateSpecificationDetails($styleNo,$currentItemCode,$itemCode,$unitType,$unitPrice,$conPc,$wastage,$purchaseType,$orderType,$placement,$ratioType,$reqQty,$totalQty,$totalValue,$costPC,$freight,$originid);
	//End - 20-08-2010 (Comment this because when edit a item material ratio must update)
	
	$oldPurchaseType =   $_GET["purchaseType"];
	$oldTotalQty = $_GET["totalQty"];
	
	$sql = "SELECT strPurchaseMode, dblTotalQty FROM specificationdetails WHERE intStyleId = '$styleNo' AND strMatDetailID = '$itemCode'";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
  	{
  		$oldPurchaseType = $row["strPurchaseMode"];
  		$oldTotalQty = $row["dblTotalQty"];
  	}
	
	//Start - 20-08-2010 (add this line after taking a total qty from above sql)
	$result = UpdateSpecificationDetails($styleNo,$currentItemCode,$itemCode,$unitType,$unitPrice,$conPc,$wastage,$purchaseType,$orderType,$placement,$ratioType,$reqQty,$totalQty,$totalValue,$costPC,$freight,$originid);
	//End - 20-08-2010 (add this line after taking a total qty from above sql)

	if($oldPurchaseType != $purchaseType)	
	{
		UpdatePurchaseType($styleNo,$itemCode,$purchaseType);
	}
	else if ( $oldTotalQty  != $totalQty )
	{
		$sql = "UPDATE materialratio SET dblQty = round((dblQty / $oldTotalQty )* $totalQty) WHERE  intStyleId = '$styleNo' AND strMatDetailID = '$itemCode'";
		$db->ExecuteQuery($sql);
		
	}
	UpdateMatRatioBalQty($styleNo,$itemCode,$freight);
	if ($result)
	{
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
	}
	else
	{
		$ResponseXML .= "<Result><![CDATA[False]]></Result>\n";
	}
	
	$ResponseXML .= "</ResultSet>\n";
	echo $ResponseXML;
}

else if(strcmp($RequestType,"DeleteSpecification") == 0)
{
	$styleNo = $_GET["styleNo"];
	$ItemCode = $_GET["ItemID"];
	
	$ResponseXML .= "<ResultSet>\n";
	$purchasedQty = getItemPurchasedQty($styleNo,$ItemCode); 
	$bulkAlloQty = getItemBulkAllocationQty($styleNo,$ItemCode);
	
	$leftAlloQty = getItemLeftoverQty($styleNo,$ItemCode);
	$interjobQty = getItemInterjobQty($styleNo,$ItemCode);
	
	$totQty = $purchasedQty+$bulkAlloQty+$leftAlloQty+$interjobQty; 
	
	if($totQty > 0)	
	{
		if($purchasedQty>0)
			$ResponseXML .= "<Result><![CDATA[Confirm PO raised for this item.]]></Result>\n";
		if($bulkAlloQty>0)
			$ResponseXML .= "<Result><![CDATA[Bulk Allocation available for this item.]]></Result>\n";	
		if($leftAlloQty>0)
			$ResponseXML .= "<Result><![CDATA[Leftover Allocation available for this item.]]></Result>\n";
		if($interjobQty>0)
			$ResponseXML .= "<Result><![CDATA[Interjob Transfer available for this item.]]></Result>\n";		
	}
	else
	{
		DeleteSpecifications($styleNo,$ItemCode);
		DeleteItemMatRatio($styleNo,$ItemCode);
		DeleteContrast($styleNo,$ItemCode);
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
	}
	$ResponseXML .= "</ResultSet>\n";
	echo $ResponseXML;
}
if (strcmp($RequestType,"GetVariations") == 0)
{
	 $ResponseXML = "";
	 $StyleNo=$_GET["styleNo"];
	 $ItemCode=$_GET["itemcode"];
	 $ResponseXML .= "<Items>\n";
	 $result=getVariations($StyleNo,$ItemCode);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<No><![CDATA[" . $row["intNo"]  . "]]></No>\n";
       $ResponseXML .= "<ConPC><![CDATA[" . $row["dblConPc"]  . "]]></ConPC>\n";
		 $ResponseXML .= "<UnitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></UnitPrice>\n";
		 $ResponseXML .= "<Wastage><![CDATA[" . $row["dblWastage"]  . "]]></Wastage>\n";
		 $ResponseXML .= "<Qty><![CDATA[" . $row["intqty"]  . "]]></Qty>\n";
		 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
	 }
	 $ResponseXML .= "</Items>";
	 echo $ResponseXML;	
}
else if(strcmp($RequestType,"DeleteVariations") == 0)
{
	$styleNo = $_GET["styleNo"];
	$ItemCode = $_GET["ItemID"];
	DeleteVariations($styleNo,$ItemCode);
}
else if(strcmp($RequestType,"UpdatePurchaseType") == 0)
{
	$styleNo = $_GET["styleNo"];
	$ItemCode = $_GET["ItemID"];
	$purchaseType = $_GET["purchaseType"];	
	
	UpdatePurchaseType($styleNo,$ItemCode,$purchaseType);
	if ($purchaseType == "COLOR" || $purchaseType == "BOTH")
	{
		DeleteContrast($styleNo,$ItemCode);
	}
	//resetMatRatio($styleNo,$itemCode,$purchaseType);
}
else if (strcmp($RequestType,"GetBuyerPOListForStyle") == 0)
{
	 $ResponseXML = "";
	 $styleID = $_GET["StyleNO"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getBuyerPOListByStyle($styleID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<PONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></PONO>\n";
         $ResponseXML .= "<QTY><![CDATA[" . $row["dblQty"]  . "]]></QTY>\n";   
		 $ResponseXML .= "<CountryCode><![CDATA[" . $row["strCountryCode"]  . "]]></CountryCode>\n";
		  $ResponseXML .= "<BuyerPoName><![CDATA[" . $row["strBuyerPoName"]  . "]]></BuyerPoName>\n";           
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
else if (strcmp($RequestType,"GetBuyerList") == 0)
{
	 $ResponseXML = "";
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getBuyersList();
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<BuyerID><![CDATA[" . $row["intBuyerID"]  . "]]></BuyerID>\n";
         $ResponseXML .= "<BuyerName><![CDATA[" . $row["strName"]  . "]]></BuyerName>\n";   
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;
	
}
else if (strcmp($RequestType,"GetBuyerColors") == 0)
{
	 $ResponseXML = "";
	 $BuyerID = $_GET["BuyerID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getBuyerColors($BuyerID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
else if (strcmp($RequestType,"GetVariationColors") == 0)
{
	 $ResponseXML = "";
	 $styleID = $_GET["styleID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getVariationColors($styleID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
else if (strcmp($RequestType,"GetBuyerSizes") == 0)
{
	 $ResponseXML = "";
	 $BuyerID = $_GET["BuyerID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getBuyerSizes($BuyerID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
else if (strcmp($RequestType,"GetBuyerDivisionColors") == 0)
{
	 $ResponseXML = "";
	 $BuyerID = $_GET["BuyerID"];
	 $DivisionID = $_GET["DivisionID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getBuyerDivisionColors($BuyerID,$DivisionID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
else if (strcmp($RequestType,"GetBuyerDivisionSizes") == 0)
{
	 $ResponseXML = "";
	 $BuyerID = $_GET["BuyerID"];
	 $DivisionID = $_GET["divisionID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getBuyerDivisionSizes($BuyerID,$DivisionID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
else if(strcmp($RequestType,"SaveStyleRatio") == 0)
{
	$styleNo = $_GET["styleNo"];
	$buyerPONo = $_GET["buyerPONo"];
	$color = $_GET["color"];
	$size = $_GET["size"];
	$qty = $_GET["qty"];
	$exQty = $_GET["exQty"];
	$userID = $_SESSION["UserID"];
	SaveStyleRatio($styleNo,$buyerPONo,$color,$size,$qty,$exQty,$userID);
}
else if(strcmp($RequestType,"SaveMatRatio") == 0)
{
	$styleNo = $_GET["styleNo"];
	$buyerPONo = $_GET["buyerPONo"];
	$item = $_GET["itemCode"];
	$color = $_GET["color"];
	$size = $_GET["size"];
	$qty = $_GET["qty"];	
	$userID = $_SESSION["UserID"];
	$charpos = $_GET["posID"];
	$freight = $_GET["freight"];
	$purchasedQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 0);
	$purchasedFreightQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 1);
	
	//start 2010-11-29 getconfirmed Bulk allocation Qty
	$bulkAlloQty = confirmgetBulkAlloQty($styleNo,$buyerPONo,$item,$color, $size);
	$leftAlloQty = confirmLeftOverQty($styleNo,$buyerPONo,$item,$color, $size);
	//end 2010-11-29
	
	//start 2011-09-06 get confirmed Recut qty
	$totQty = getTotalSpecItemQty($styleNo,$item);
	$confirmRecutQty =  getConfirmRecutQty($styleNo,$item);
	$recutQty = round($confirmRecutQty/$totQty*$qty);
	//end 2011-09-06  get confirmed Recut qty
	
	$balQty = $_GET["qty"] + $recutQty - $purchasedQty - $bulkAlloQty - $leftAlloQty;
	$dblFreightBal = $_GET["qty"] - $purchasedFreightQty;
	if ($freight  <= 0)
		$dblFreightBal = 0; 
	//echo "Pass";
	
	$newSCNO = "";
	
	$sql = "SELECT intSRNO FROM specification WHERE intStyleId = '$styleNo'";
	$result = $db->RunQuery($sql);
	//echo $reqyest;
	while($row = mysql_fetch_array($result))
	{
		$newSCNO = $row["intSRNO"];
		break;
	}
	$matcde = $newSCNO . "-" . $item .  "-". getCharforID($charpos); 
	SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$userID,$dblFreightBal,$matcde,$recutQty);
}
else if(strcmp($RequestType,"DelStyRatio") == 0)
{
	$styleNo = $_GET["styleNo"];
	$buyerPONo = $_GET["buyerPONo"];
	saveToHistoryStyle($styleNo,$buyerPONo);
	saveToHistoryMaterialRatio($styleNo,$buyerPONo);
	DeleteStyleRatio($styleNo,$buyerPONo);
	DeleteMatRatioforPO($styleNo,$buyerPONo);
}
else if (strcmp($RequestType,"ValidateTransfer") == 0)
{
	 $ResponseXML = "";
	 $styleNo = $_GET["styleNo"];
	 $buyerPONo = $_GET["buyerPONo"];
	 $ReqCount = $_GET["ReqCount"];
	 $matCount =  $_GET["Matrequest"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getStyleRatioCount($styleNo,$buyerPONo);
	 $styleOK = false;
	 $materialOK = false;
	 while($row = mysql_fetch_array($result))
  	 {
	 	if ($row["recCount"]  ==  $ReqCount)
		{
			$styleOK = true;
		}
		else
		{
			 $styleOK = false;
		}
	 }
	 
	 $result=getMaterialRatioCount($styleNo,$buyerPONo);
	  while($row = mysql_fetch_array($result))
  	 {
	 	if ($row["recCount"]  ==  $matCount)
		{
			$materialOK = true;
		}
		else
		{
			 $materialOK = false;
		}
	 }
	 //echo $ReqCount . "  " .  $matCount ;
	 if ($styleOK && $materialOK )
	{
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
	}
	else
	{
		$ResponseXML .= "<Result><![CDATA[False]]></Result>\n";
	}
	 
	 
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
//Start 16-06-2010
else if (strcmp($RequestType,"ValidateMaterialRatioTransfer") == 0)
{
	 $ResponseXML = "";
	 $styleNo = $_GET["styleNo"];
	 $buyerPONo = $_GET["buyerPONo"];
	 $matDetailId = $_GET["matDetailId"];
	 $matCount =  $_GET["Matrequest"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $materialOK = false;
	
	 $result=GetMaterialRatioCount2($styleNo,$buyerPONo,$matDetailId);
	
	  while($row = mysql_fetch_array($result))
  	 {	 
	 	if ($row["recCount"]  ==  $matCount)
		{
			$materialOK = true;
		}
		else
		{
			 $materialOK = false;
		}
		$A = $row["recCount"];
	 }
	 if ($materialOK)
	{
		$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
		$ResponseXML .= "<A1><![CDATA[".$A."]]></A1>\n";
		$ResponseXML .= "<A2><![CDATA[".$matCount."]]></A2>\n";
	}
	else
	{
		$ResponseXML .= "<Result><![CDATA[False]]></Result>\n";
		$ResponseXML .= "<A1><![CDATA[".$A."]]></A1>\n";
		$ResponseXML .= "<A2><![CDATA[".$matCount."]]></A2>\n";
	}
	 
	 
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
//End 16-06-2010
else if (strcmp($RequestType,"GetStyleRatio") == 0)
{
	 $ResponseXML = "";
	 $styleNo = $_GET["styleNo"];
	 $buyerPONo = $_GET["buyerPONo"];
	 $ResponseXML .= "<RequestDetails>\n";
	 
	if($buyerPONo=="#Main Ratio#")
	{
		 $sql_bp="select intQty from  orders where intStyleId='$styleNo'";
		 $result_bp=$db->RunQuery($sql_bp);
		 $row_bp=mysql_fetch_array($result_bp);
		 $bdlBuyerPoNo = $row_bp["intQty"];		
	}
	else
	{
		 $sql_bp="select dblQty from  style_buyerponos where intStyleId='$styleNo' and strBuyerPONO='$buyerPONo'";
		 $result_bp=$db->RunQuery($sql_bp);
		 $row_bp=mysql_fetch_array($result_bp);
		 $bdlBuyerPoNo = $row_bp["dblQty"];
	}
	 
	 $result=getStyleRatioDetails($styleNo,$buyerPONo);
	 
	 	$ResponseXML .= "<TotalBuyerPoNo><![CDATA[" . $bdlBuyerPoNo  . "]]></TotalBuyerPoNo>\n";
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
         $ResponseXML .= "<BuyerPONo><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONo>\n";   
		 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";   
		 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
         $ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";   
		 $ResponseXML .= "<ExQty><![CDATA[" . $row["dblExQty"]  . "]]></ExQty>\n";                
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
else if (strcmp($RequestType,"GetMatRatio") == 0)
{
	 $ResponseXML = "";
	 $styleNo = $_GET["styleNo"];
	 $buyerPONo = $_GET["buyerPONo"];
	 $ItemID =  $_GET["ItemID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 
	 if($buyerPONo=="#Main Ratio#")
	{
		 $sql_bp="select intQty from  orders where intStyleId='$styleNo'";
		 $result_bp=$db->RunQuery($sql_bp);
		 $row_bp=mysql_fetch_array($result_bp);
		 $bdlBuyerPoNo = $row_bp["intQty"];		
	}
	else
	{
		 $sql_bp="select dblQty from  style_buyerponos where intStyleId='$styleNo' and strBuyerPONO='$buyerPONo'";
		 $result_bp=$db->RunQuery($sql_bp);
		 $row_bp=mysql_fetch_array($result_bp);
		 $bdlBuyerPoNo = $row_bp["dblQty"];
	}
	
	 $result=getMatRatioDetails($styleNo,$buyerPONo,$ItemID);
	 	$ResponseXML .= "<TotalBuyerPoNo><![CDATA[" . $bdlBuyerPoNo  . "]]></TotalBuyerPoNo>\n";
	 while($row = mysql_fetch_array($result))
  	 {	
	 	 //Start 31-03-2010 (Get purchase qty and purchase color and size)
	 	$poQty=getPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);		 
		$colorPoQty=getColorPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"]);
		$sizePoQty=getSizePoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strSize"]);
		//End   31-03-2010  (Get purchase qty and purchase color and size)
		 $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
         $ResponseXML .= "<BuyerPONo><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONo>\n";   
		 $ResponseXML .= "<MatID><![CDATA[" . $row["strMatDetailID"]  . "]]></MatID>\n";
		 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";   
		 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
         $ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";   
		 $ResponseXML .= "<BalQty><![CDATA[" . $row["dblBalQty"]  . "]]></BalQty>\n"; 
		 //Start 31-03-2010 (Get purchase qty and purchase color and size)
		  $ResponseXML .= "<PoQty><![CDATA[" . $poQty  . "]]></PoQty>\n";
		 if($colorPoQty>0)
	      	$ResponseXML .= "<ColorPoDone><![CDATA[" . 1  . "]]></ColorPoDone>\n"; //po done for colors
		 else
		 	$ResponseXML .= "<ColorPoDone><![CDATA[" . 0  . "]]></ColorPoDone>\n"; //po not done for colors
			
		if($sizePoQty>0)
	      	$ResponseXML .= "<SizePoDone><![CDATA[" . 1  . "]]></SizePoDone>\n"; //po done for size
		 else
		 	$ResponseXML .= "<SizePoDone><![CDATA[" . 0  . "]]></SizePoDone>\n"; //po not done for size 
		 //End   31-03-2010 (Get purchase qty and purchase color and size)           
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
//Start   31-03-2010 (Get purchase qty and purchase color and size) 
else if (strcmp($RequestType,"GetMatRatioPoQty") == 0)
{
	 $ResponseXML = "";
	 $styleNo = $_GET["styleNo"];
	 $buyerPONo = $_GET["buyerPONo"];
	 $ItemID =  $_GET["ItemID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getMatRatioDetails($styleNo,$buyerPONo,$ItemID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
	 	 $poQty=getPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);
		 
		 		 
		 $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
         $ResponseXML .= "<BuyerPONo><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONo>\n";   
		 $ResponseXML .= "<MatID><![CDATA[" . $row["strMatDetailID"]  . "]]></MatID>\n";
		 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";   
		 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
         $ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";   
		 $ResponseXML .= "<BalQty><![CDATA[" . $row["dblBalQty"]  . "]]></BalQty>\n";
		$ResponseXML .= "<PoQty><![CDATA[" . $poQty  . "]]></PoQty>\n";
		 
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
//End   31-03-2010 (Get purchase qty and purchase color and size) 
else if(strcmp($RequestType,"DelMatRatio") == 0)
{
	$styleNo = $_GET["styleNo"];
	$buyerPONo = $_GET["buyerPONo"];
	$matID = $_GET["matID"];
	saveToHistoryMaterial($styleNo,$buyerPONo,$matID);
	DeleteMatRatioforItem($styleNo,$buyerPONo,$matID);
}
else if(strcmp($RequestType,"AddNewColor") == 0)
{
	$colorName = $_GET["colorName"];
	$buyer = $_GET["buyer"];
	$division = $_GET["division"];
	if ($division == "Select One") $division = 0;
	SaveNewColor($colorName,$buyer,$division);
	echo "True";
}
else if(strcmp($RequestType,"AddNewSize") == 0)
{
	$sizeName = $_GET["SizeName"];
	$buyer = $_GET["buyer"];
	$division = $_GET["division"];
	if ($division == "Select One") $division = 0;
	SaveNewSize($sizeName,$buyer,$division);
	echo "True";
}
else if(strcmp($RequestType,"DeleteDelivery") == 0)
{
	$StyleID = $_GET["StyleNo"];
	$delDate = $_GET["delDate"];
	$dtDateofDelivery=$_GET["delDate"];
	$year = substr($dtDateofDelivery,-4);
	$month = substr($dtDateofDelivery,-7,-5);
	$day = substr($dtDateofDelivery,-10,-8);
	$dtDateofDelivery = $year . "-" . $month . "-" . $day;
	DeleteDeliveryDetails($StyleID,$dtDateofDelivery);
	echo "True";
}
else if(strcmp($RequestType,"UpdateSchedule")==0)
{
	//StyleNo=' + StyleNo + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + remarks,
	$ResponseXML="";
	$strStyleID=$_GET["StyleNo"];
	
	$dblQty=$_GET["qty"];
	$exQty=$_GET["exqty"];
	$modeID=$_GET["modeID"];
	$dbExQty=$_GET["exqty"];
	$isbase = $_GET["isbase"];
	$leadTime = $_GET["leadTime"];
	$dtDateofDelivery=$_GET["ScheduleDate"];
	$remarks = $_GET["remarks"];
	$year = substr($dtDateofDelivery,-4);
	$month = substr($dtDateofDelivery,-7,-5);
	$day = substr($dtDateofDelivery,-10,-8);
	$dtDateofDelivery = $year . "-" . $month . "-" . $day;
	$delDate=$_GET["delDate"];
	$delyear = substr($delDate,-4);
	$delmonth = substr($delDate,-7,-5);
	$delday = substr($delDate,-10,-8);
	$delDate = $delyear . "-" . $delmonth . "-" . $delday;
	$estimatedDate=$_GET["estimateddate"];
	$estyear = substr($estimatedDate,-4);
	$estmonth = substr($estimatedDate,-7,-5);
	$estday = substr($estimatedDate,-10,-8);
	$estimatedDate = $estyear . "-" . $estmonth . "-" . $estday;
	DeleteDeliveryDetails($strStyleID,$delDate);
	$result=saveDeliveryDetails($strStyleID,$dtDateofDelivery,$dblQty,$exQty,$modeID,$dbExQty,$isbase,$leadTime,$remarks,$estimatedDate);
	
//	$ResponseXML.="<SaveDiliveryDetail>";
//		$ResponseXML.="<SaveState><![CDATA[" .$result. "]]></SaveState>\n";
//		$ResponseXML.="</SaveDiliveryDetail>";
}
else if (strcmp($RequestType,"GetBuyerPOListForStyleBOM") == 0)
{
	 $ResponseXML = "";
	 $styleID = $_GET["StyleNO"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getBuyerPOListByStyleBom($styleID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
		 $ResponseXML .= "<QTY><![CDATA[" . $row["intQty"]  . "]]></QTY>\n";               
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;
	
}
if (strcmp($RequestType,"GetBuyerPOListForCompanyBOM") == 0)
{
	 $ResponseXML = "";
	 $companyID = $_GET["CompanyID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getBuyerPOListByCompanyBom($companyID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
		 $ResponseXML .= "<QTY><![CDATA[" . $row["intQty"]  . "]]></QTY>\n";               
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;
	
}
if (strcmp($RequestType,"checkPurchased") == 0)
{
	 $ResponseXML = "";
	 $styleNo=$_GET["styleID"];
	 $itemCode = $_GET["itemCode"]; 
	 $ResponseXML .= "<Result>\n";
	 $purchaseQty = getItemPurchasedQty($styleNo,$itemCode); 	
	 $ResponseXML .= "<Qty><![CDATA[" . $purchaseQty  . "]]></Qty>\n";	
	 $ResponseXML .= "</Result>";
	 echo $ResponseXML;	
}

// start 2010-10-15 get style wise order nos  -------------------
else if(strcmp($RequestType,"getStyleWiseOrderNum")==0)
{
	$ResponseXML="";
	$stytleName = $_GET["stytleName"];
	
	$SQL = " select intStyleId,strOrderNo
			from orders
			where   intUserID = " . $_SESSION["UserID"] . " and  intStatus  =11";
		
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
else if(strcmp($RequestType,"getStylewiseOrderNoNew")==0)
{
	$ResponseXML="";
	$stytleName = $_GET["stytleName"];
	
	$SQL = " SELECT
orders.intStyleId,
orders.strOrderNo,
specification.intSRNO
FROM
orders
Left Join specification ON orders.intStyleId = specification.intStyleId
			where intStatus  =11";
		
	if($stytleName != 'Select One' && $stytleName != '')
		$SQL .= " and orders.intStyleId='$stytleName' ";
		
		$SQL .= " order by strOrderNo ";
		//echo $SQL;		
	$result = $db->RunQuery($SQL);
		//$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}
//---------------------------------------------

//start 2010-10-16 get style wise SC no -----------------------

else if(strcmp($RequestType,"getStyleWiseSCNum")==0)
{
	$ResponseXML="";
	$stytleName = $_GET["styleName"];
	
	$SQL = "  select specification.intSRNO,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId 
WHERE  orders.intStatus = 11   ";
		
	if($stytleName != 'Select One' && $stytleName != '')
		$SQL .= " and orders.intStyleId='$stytleName' ";
		
		$SQL .= "order by specification.intSRNO desc";	
		//echo $SQL;	
	$result = $db->RunQuery($SQL);
	
		//$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<SCNO><![CDATA[" .$str. "]]></SCNO>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"getSCWiseStyleNum")==0)
{
	$ResponseXML="";
	$srNo = $_GET["srNo"];
	
	$SQL = "  select specification.intSRNO,specification.intStyleId,orders.intStyleId,orders.strStyle from specification inner join orders on specification.intStyleId = orders.intStyleId 
WHERE  orders.intStatus = 11   ";
		
	if($srNo != 'Select One' && $srNo != '')
		$SQL .= " and orders.intStyleId='$srNo' ";
		
		$SQL .= "order by specification.intSRNO desc";	
		//echo $SQL;	
	$result = $db->RunQuery($SQL);
	
		//$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	
	$ResponseXML.="<styleNoList>";
	$ResponseXML.="<stylNo><![CDATA[" .$str. "]]></stylNo>\n";
	$ResponseXML.="</styleNoList>";
	echo $ResponseXML;
	
}

//------------------------------------------------------------
function UpdatePurchaseType($styleNo,$itemCode,$purchaseType)
{
	global $db;
	$sql="update specificationdetails set strPurchaseMode = '" . $purchaseType . "' where intStyleId = '" . $styleNo . "' AND strMatDetailID = '" . $itemCode . "'";

	$db->executeQuery($sql);
	resetMatRatio($styleNo,$itemCode,$purchaseType);
	return true;
}

function UpdateSpecificationDetails($styleNo,$currentItemCode,$itemCode,$unitType,$unitPrice,$conPc,$wastage,$purchaseType,$orderType,$placement,$ratioType,$reqQty,$totalQty,$totalValue,$costPC,$freight,$originid)
{
	global $db;
	$sql="update specificationdetails set strMatDetailID = '" . $itemCode . "', strUnit = '" . $unitType . "' , dblUnitPrice = " . $unitPrice . ", sngConPc = " . $conPc . ", sngWastage = " . $wastage . ", strPurchaseMode = '" . $purchaseType . "' , strOrdType = '" . $orderType . "' ,strPlacement = '" . $placement . "' , intRatioType = " . $ratioType . ", dblReqQty = " . $reqQty . ", dblTotalQty = " . $totalQty . ", dblTotalValue = " . $totalValue . ", dblCostPC = " . $costPC . ", dblfreight = " . $freight . ", intOriginNo = " . $originid . " where intStyleId = '" . $styleNo . "' AND strMatDetailID = '" . $currentItemCode . "'";

	$db->executeQuery($sql);
	return true;
}
function getVariations($styleNo,$itemID)
{
	global $db;
	$sql= "select intNo,dblConPc,dblUnitPrice,dblWastage,intqty,strColor,strSize from conpccalculation where intStyleId = '" . $styleNo . "' AND strMatDetailID = '" . $itemID . "'";
	return $db->RunQuery($sql);
	
}

function DeleteSpecifications($styleNo, $itemCode)
{
	global $db;
	$sql="delete from specificationdetails where intStyleId = '" . $styleNo . "' AND strMatDetailID = '" . $itemCode . "';";

	$db->executeQuery($sql);
	return true;
}

function DeleteVariations($styleNo, $itemCode)
{
	global $db;
	$sql="delete from conpccalculation where intStyleId = '" . $styleNo . "' AND strMatDetailID = '" . $itemCode . "'";

	$db->executeQuery($sql);
	return true;
}

function getCategoryItemList($itemID)
{
	global $db;
	$sql= "select intItemSerial,strItemDescription from matitemlist where (intSubCatID = (select intSubCatID from matitemlist where intItemSerial = " . $itemID . ")) and intStatus=1";
	return $db->RunQuery($sql);
	
}

function getCategoryItemListForText($itemID,$text)
{
	global $db;
	$sql= "select intItemSerial,strItemDescription from matitemlist where (intSubCatID = (select intSubCatID from matitemlist where intItemSerial = " . $itemID . ")) and strItemDescription like '%$text%'";
	return $db->RunQuery($sql);
	
}

function SaveSpecificationDetails($strStyleID, $strMatDetailID, $strUnit, $dblUnitPrice, $sngConPc, $sngWastage, $strPurchaseMode, $strOrdType, $strPlacement, $intRatioType, $dblReqQty, $dblTotalQty, $dblTotalValue, $dblCostPC, $dblfreight, $intOriginNo)
{
	global $db;
	$sql="insert into specificationdetails 	(intStyleId, 	strMatDetailID, 	strUnit, 	dblUnitPrice, 	sngConPc, 	sngWastage, 	strPurchaseMode, 	strOrdType, 	strPlacement, 	intRatioType, 	dblReqQty, 	dblTotalQty, 	dblTotalValue, 	dblCostPC, 	dblfreight, 	intOriginNo	)	values	('$strStyleID', '$strMatDetailID', '$strUnit', $dblUnitPrice, $sngConPc, $sngWastage, '$strPurchaseMode', '$strOrdType', '$strPlacement', '$intRatioType', $dblReqQty, $dblTotalQty, $dblTotalValue, $dblCostPC, $dblfreight, $intOriginNo);";


	$db->executeQuery($sql);
	return true;
}


function getBuyerPOListByStyle($styleID)
{
	global $db;
	$sql="SELECT  strBuyerPoName,strBuyerPONO,dblQty,strCountryCode FROM style_buyerponos where intStyleId  = '" . $styleID . "';";
	return $db->RunQuery($sql);
}

function getBuyersList()
{
	global $db;
	$sql="select intBuyerID,strName from buyers;";
	return $db->RunQuery($sql);
}

function getBuyerColors($BuyerID)
{
	global $db;
	$sql= "select distinct strColor from colors where intCustomerId = " . $BuyerID . ";" ;
	return $db->RunQuery($sql);
}

function getVariationColors($styleID)
{
	global $db;
	$sql= "SELECT DISTINCT strColor FROM conpccalculation WHERE intStyleId = '$styleID';" ;
	return $db->RunQuery($sql);
}

function getBuyerSizes($BuyerID)
{
	global $db;
	$sql= "select distinct strSize from sizes where intCustomerID = " . $BuyerID . ";" ;
	return $db->RunQuery($sql);
}

function getBuyerDivisionColors($BuyerID,$DivisionID)
{
	global $db;
	$sql= "select distinct strColor from colors where intCustomerId = " . $BuyerID . " AND intDivisionID = " . $DivisionID . ";" ;
	return $db->RunQuery($sql);
}

function getBuyerDivisionSizes($BuyerID,$DivisionID)
{
	global $db;
	$sql= "select distinct strSize from sizes where intCustomerID = " . $BuyerID . " AND intDivisionID = " . $DivisionID . ";" ;
	return $db->RunQuery($sql);
}

function SaveStyleRatio($styleNo,$buyerPONo,$color,$size,$qty,$exQty,$userID)
{
	global $db;
	$sql="insert into styleratio (intStyleId,strBuyerPONO,strColor,strSize,dblQty,dblExQty,strUserId) values ('$styleNo','$buyerPONo','$color','$size',$qty,$exQty,'$userID');";

	$db->executeQuery($sql);
	return true;
}

function DeleteStyleRatio($styleNo,$buyerPONo)
{
	global $db;
	$sql="delete from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo'";

	$db->executeQuery($sql);
	return true;
}

function getStyleRatioCount($styleNo,$buyerPONo)
{
	global $db;
	$sql= "select count(*) as recCount from styleratio  where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo'" ;
	return $db->RunQuery($sql);
}

function getMaterialRatioCount($styleNo,$buyerPONo)
{
	global $db;
	$sql= "select count(*) as recCount from materialratio where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo'" ;
	return $db->RunQuery($sql);
}

function getStyleRatioDetails($styleNo,$buyerPONo)
{
	global $db;
	$sql= "select intStyleId,strBuyerPONO,strColor,strSize,dblQty,dblExQty,strUserId from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo' order by strColor,strSize" ;
	return $db->RunQuery($sql);
}

function SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$userID,$dblFreightBal,$materialRatioID,$recutQty)
{

	global $db;
	$sql="insert into materialratio (intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty,dblFreightBalQty,materialRatioID,dblRecutQty) values ('$styleNo','$item','$color','$size','$buyerPONo',$qty,$balQty,$dblFreightBal,'$materialRatioID','$recutQty');";
	
	$db->executeQuery($sql);
	return true;
}

function DeleteMatRatioforPO($styleNo,$buyerPONo)
{
	global $db;
	$sql="delete from materialratio where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo'";

	$db->executeQuery($sql);
	return true;
}

function resetMatRatio($styleNo,$itemCode,$reqyest)
{
	global $db;
	$colors = array();
	$sizes = array();
	$pos = array();
	$loopindex = 0;
	$newSCNO = "";
	
	$sql = "SELECT intSRNO FROM specification WHERE intStyleId = '$styleNo'";
	$result = $db->RunQuery($sql);
	//echo $reqyest;
	while($row = mysql_fetch_array($result))
	{
		$newSCNO = $row["intSRNO"];
		break;
	}
	
	$sql = "select distinct strColor from styleratio where intStyleId = '$styleNo'";
	$result = $db->RunQuery($sql);
	//echo $reqyest;
	while($row = mysql_fetch_array($result))
	{
		$colors[$loopindex] = $row["strColor"];
		$loopindex  ++;
	}
	
	$loopindex = 0;
	
	$sql = "select distinct strSize from styleratio where intStyleId = '$styleNo'";
	$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
		$sizes[$loopindex] = $row["strSize"];
		$loopindex  ++;
	}
	
	$loopindex = 0;
	
	$sql = "select distinct strBuyerPONO  from materialratio where intStyleId = '$styleNo' AND strMatDetailID = '$itemCode'";
	$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
		$pos[$loopindex] = $row["strBuyerPONO"];
		$loopindex  ++;
	}
	
	if (count($pos) == 0)
	{
		$pos[0] = "#Main Ratio#";
	}
	SaveHistoryMatRatioForItem($styleNo,$itemCode);
	$sql = "delete from materialratio where intStyleId = '$styleNo' AND strMatDetailID = '$itemCode'";

	$db->executeQuery($sql);
	
	$freightCharge = 0;
	$reqQty = 0;
	$OdrQty = 0;
	//$sql = "select dblfreight, dblTotalQty from specificationdetails where intStyleId = '$styleNo' and strMatDetailID = '$itemCode'";
	$sql = "select dblfreight, dblTotalQty, dblQuantity,reaExPercentage  from specificationdetails inner join specification on specificationdetails.intStyleId = specification.intStyleId  inner join orders on orders.intStyleId=specification.intStyleId where specificationdetails.intStyleId = '$styleNo' and strMatDetailID = '$itemCode'";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$freightCharge = $row["dblfreight"];
		$reqQty = $row["dblTotalQty"];
		$exPecent = $row["reaExPercentage"];
		$OdrQty = $row["dblQuantity"];
		$OdrQty = $OdrQty+(($OdrQty*$exPecent)/100); //Use the percentage qty
	}
	
	$confirmRecutQty = getConfirmRecutQty($styleNo,$itemCode);
	if (strcmp($reqyest,"COLOR") == 0)
	{	
		foreach ($pos as $poNumber) 
		{			
			$charpos = 0;
			$previousColor = "";
			foreach ($colors as $colorName) 
			{
			
				$sql = "select sum(dblExQty) as exqty from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$poNumber' and strColor = '$colorName'";
				$result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					
					$matRatioID = $newSCNO . "-" . $itemCode . "" . getCharforID($charpos);
					
					$initQty =  round($reqQty/$OdrQty * $row["exqty"]);
					
					//2011-09-07 start calculate recut qty 
					$recutQty = round($confirmRecutQty/$reqQty*$initQty);
					//2011-09-07 end calculate recut qty 
					
					//$matQty = round($initQty - getPurchasedQty($styleNo,$itemCode,$poNumber,$colorName, "N/A", 0));
					$poQty = getPurchasedQty($styleNo,$itemCode,$poNumber,$colorName, "N/A", 0);
					
					$bulkAlloQty = confirmgetBulkAlloQty($styleNo,$poNumber,$itemCode,$colorName, "N/A");
					$leftAlloQty = confirmLeftOverQty($styleNo,$poNumber,$itemCode,$colorName, "N/A");
					$matQty = round($initQty + $recutQty - $poQty - $bulkAlloQty - $leftAlloQty);
					
					$matFreightQty = 0;
					if ($freightCharge > 0)
						$matFreightQty = round($initQty  - getPurchasedQty($styleNo,$itemCode,$poNumber,$colorName, "N/A", 1));
					$sql="insert into materialratio (intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty,dblFreightBalQty,materialRatioID,dblRecutQty) values ('$styleNo','$itemCode','$colorName','N/A','$poNumber',$initQty,$matQty,$matFreightQty,'$matRatioID','$recutQty');";
					
					$db->executeQuery($sql);
					
					if($previousColor != $colorName)
					{
						$charpos ++;
						$previousColor = $colorName;
					}
					
				}					
			}
		}
	}
	else if (strcmp($reqyest,"SIZE") == 0)
	{	
		foreach ($pos as $poNumber) 
		{
			foreach ($sizes as $sizeName) 
			{
				$sql = "select sum(dblExQty) as exqty from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$poNumber' and strSize = '$sizeName'";
				$result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					$matRatioID = $newSCNO . "-" . $itemCode . "" . getCharforID(0);
					$initQty =  round($reqQty/$OdrQty * $row["exqty"]);
					
					//2011-09-07 start calculate recut qty 
					$recutQty = round($confirmRecutQty/$reqQty*$initQty);
					//2011-09-07 end calculate recut qty 
					
					//$matQty = round($initQty -  getPurchasedQty($styleNo,$itemCode,$poNumber,"N/A", $sizeName, 0));
					$poQty = getPurchasedQty($styleNo,$itemCode,$poNumber,"N/A", $sizeName, 0);
					
					$bulkAlloQty = confirmgetBulkAlloQty($styleNo,$poNumber,$itemCode,"N/A",$sizeName);
					$leftAlloQty = confirmLeftOverQty($styleNo,$poNumber,$itemCode,"N/A",$sizeName);
					$matQty = round($initQty + $recutQty - $poQty - $bulkAlloQty - $leftAlloQty);
					
					$matFreightQty = 0;
					if ($freightCharge > 0)
						$matFreightQty = round($initQty - getPurchasedQty($styleNo,$itemCode,$poNumber,"N/A", $sizeName, 1));
					
					$sql="insert into materialratio (intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty,dblFreightBalQty,materialRatioID,dblRecutQty) values ('$styleNo','$itemCode','N/A','$sizeName','$poNumber',$initQty,$matQty,$matFreightQty,'$matRatioID','$recutQty');";
				
					$db->executeQuery($sql);
				}
			}
		}
	}
	else if (strcmp($reqyest,"BOTH") == 0)
	{	
		foreach ($pos as $poNumber) 
		{
			foreach ($sizes as $sizeName) 
			{
				$charpos = 0;
					$previousColor = "";
				foreach ($colors as $colorName) 
				{
					
					$sql = "select sum(dblExQty) as exqty from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$poNumber' and strSize = '$sizeName'  and strColor = '$colorName'";
				
					$result = $db->RunQuery($sql);
					while($row = mysql_fetch_array($result))
					{
						$matRatioID = $newSCNO . "-" . $itemCode . "" . getCharforID($charpos);
						$initQty =  round($reqQty/$OdrQty * $row["exqty"]);
						
					//2011-09-07 start calculate recut qty 
					$recutQty = round($confirmRecutQty/$reqQty*$initQty);
					//2011-09-07 end calculate recut qty 
					
						//$matQty = round($initQty - getPurchasedQty($styleNo,$itemCode,$poNumber,$colorName, $sizeName, 0));
					$poQty = getPurchasedQty($styleNo,$itemCode,$poNumber,$colorName, $sizeName, 0);
					
					$bulkAlloQty = confirmgetBulkAlloQty($styleNo,$poNumber,$itemCode,$colorName,$sizeName);
					$leftAlloQty = confirmLeftOverQty($styleNo,$poNumber,$itemCode,$colorName,$sizeName);
					$matQty = round($initQty + $recutQty - $poQty - $bulkAlloQty - $leftAlloQty);
						$matFreightQty = 0;
						if ($freightCharge > 0)
							$matFreightQty = round($initQty - getPurchasedQty($styleNo,$itemCode,$poNumber,$colorName, $sizeName, 1));
						
						$sql="insert into materialratio (intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty,dblFreightBalQty,materialRatioID,dblRecutQty) values ('$styleNo','$itemCode','$colorName','$sizeName','$poNumber',$initQty,$matQty,$matFreightQty,'$matRatioID','$recutQty');";
				
						$db->executeQuery($sql);
						
						if($previousColor != $colorName)
						{
							$charpos ++;
							$previousColor = $colorName;
						}
					}
				}
			}
		}
	}
	else
	{
		
		foreach ($pos as $poNumber) 
		{
			$sql = "select sum(dblExQty) as exqty from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$poNumber'";
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				$matRatioID = $newSCNO . "-" . $itemCode . "" . getCharforID(0);
				//$initQty =  round($reqQty); //comment this & add following line
				$initQty =  round($reqQty/$OdrQty * $row["exqty"]);
				
				//2011-09-07 start calculate recut qty 
				$recutQty = round($confirmRecutQty/$reqQty*$initQty);
				//2011-09-07 end calculate recut qty 
					
				//$matQty = round($initQty - getPurchasedQty($styleNo,$itemCode,$poNumber,$colorName, $sizeName, 0));
				$poQty = getPurchasedQty($styleNo,$itemCode,$poNumber,$colorName, $sizeName, 0);
					
					$bulkAlloQty = confirmgetBulkAlloQty($styleNo,$poNumber,$itemCode,$colorName,$sizeName);
					$leftAlloQty = confirmLeftOverQty($styleNo,$poNumber,$itemCode,$colorName,$sizeName);
					$matQty = round($initQty + $recutQty - $poQty - $bulkAlloQty - $leftAlloQty);
					
				$matFreightQty = 0;
				if ($freightCharge > 0)
					$matFreightQty = round($initQty - getPurchasedQty($styleNo,$itemCode,$poNumber,$colorName, $sizeName, 1));
				
				$sql="insert into materialratio (intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty, dblFreightBalQty,materialRatioID,dblRecutQty) values ('$styleNo','$itemCode','N/A','N/A','$poNumber',$initQty,$matQty,$matFreightQty,'$matRatioID','$recutQty');";
		
				$db->executeQuery($sql);
			}
		}
	}
}

function getMatRatioDetails($styleNo,$buyerPONo,$ItemID)
{
	global $db;
	$sql= "select intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty from materialratio where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo' AND strMatDetailID = '$ItemID' order by strColor,strSize" ;
	return $db->RunQuery($sql);
}

function DeleteMatRatioforItem($styleNo,$buyerPONo,$matID)
{
	global $db;
	$sql="delete from materialratio where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo' AND strMatDetailID = '$matID'";
	
	$db->executeQuery($sql);
	return true;
}

function SaveNewColor($colorName,$buyer,$division)
{
	global $db;
	$sql = "insert into colors (strColor,intCustomerId,intDivisionID) values ('$colorName',$buyer,$division)";

	$db->executeQuery($sql);
	return true;

}

function SaveNewSize($sizeName,$buyer,$division)
{
	global $db;
	$sql = "insert into sizes (strSize,intCustomerID,intDivisionID) values ('$sizeName',$buyer,$division)";
	
	$db->executeQuery($sql);
	return true;
}

function DeleteDeliveryDetails($StyleID,$delDate)
{
	global $db;
	
	$sql="insert into history_deliveryschedule 
	(intStyleId, 
	dtDateofDelivery, 
	dblQty, 
	dblBalQty, 
	dtPODate, 
	dtGRNDate, 
	strRemarks, 
	intComplete, 
	dtmPlanCutDate, 
	dtmactuCutDate, 
	dtmPlanFabDate, 
	strPPSampleStatus, 
	strTopSampleStatus, 
	intTrimCards, 
	intOffSet, 
	strShippingMode, 
	dbExQty, 
	intMsSql, 
	isDeliveryBase, 
	intSerialNO,
	estimateddate
	)
	
select * from deliveryschedule where intStyleId = '$StyleID' and dtDateofDelivery = '$delDate' ;";
$db->executeQuery($sql);
	
	$sql = "delete from deliveryschedule where intStyleId = '$StyleID' AND dtDateofDelivery = '$delDate';";
	
	$db->executeQuery($sql);
	return true;
}

function saveDeliveryDetails($strStyleID,$dtDateofDelivery,$dblQty,$exQty,$modeID,$dbExQty,$isbase,$leadTime,$remarks,$estimatedDate)
{
	global $db;
	$sql="Insert into deliveryschedule(intStyleId,dtDateofDelivery,dblQty,strRemarks,dbExQty,strShippingMode,isDeliveryBase,intSerialNO,estimatedDate)values('".$strStyleID."','".$dtDateofDelivery."',".$dblQty.",'$remarks',".$dbExQty.",".$modeID.",'$isbase',$leadTime,'$estimatedDate');";
	
	return	$db->executeQuery($sql);	
}

function getBuyerPOListByStyleBom($styleID)
{
	global $db;
	//$sql="select intStyleId,dblQuantity from specification where intStyleId  like '%" . $styleID . "%';";
	$sql= "select specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11  where specification.intStyleId  like '%" . $styleID . "%';";
	//echo $sql;
	return $db->RunQuery($sql);
}

function getBuyerPOListByCompanyBom($companyID)
{
	global $db;
	$sql = "select specification.intStyleId,specification.dblQuantity from specification inner join orders on orders.intStyleId = specification.intStyleId where orders.intCompanyID  = $companyID AND orders.intStatus = 11 ; ";
	//$sql="select intStyleId,dblQuantity from specification where intCompanyID  = " .$companyID . ";";
	//echo $sql;
	return $db->RunQuery($sql);
}

function getItemPurchasedQty($styleID,$materialID)
{
	global $db;
	$sql="select COALESCE(Sum(purchaseorderdetails.dblQty),0) as purchasedQty from purchaseorderdetails inner join purchaseorderheader on purchaseorderheader.intPONo = purchaseorderdetails.intPONo where intStyleId = '$styleID' AND purchaseorderdetails.intMatDetailID = '$materialID' AND purchaseorderdetails.intPOType=0 and purchaseorderheader.intStatus = 10;";

	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["purchasedQty"];
	}
}

function getPurchasedQty($styleNo,$itemCode,$buyerPO,$color, $size, $Type)
{
	global $db;	
	$sql = "select sum(dblQty) as purchasedQty from purchaseorderdetails,purchaseorderheader where purchaseorderdetails.intStyleId = '$styleNo' AND purchaseorderdetails.intMatDetailID = $itemCode AND purchaseorderdetails.strBuyerPONO = '$buyerPO' AND purchaseorderdetails.strColor = '$color' AND purchaseorderdetails.strSize = '$size' AND purchaseorderdetails.intPOType = $Type  AND purchaseorderheader.intPONo = purchaseorderdetails.intPONo AND purchaseorderheader.intYear = purchaseorderdetails.intYear  AND  purchaseorderheader.intStatus = 10";

	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		if ($row["purchasedQty"] == "" || $row["purchasedQty"]  == NULL)
			return 0;
			
		return $row["purchasedQty"];
	}
	
	return 0;
}

function DeleteItemMatRatio($styleNo,$matID)
{
	global $db;
	SaveHistoryMatRatioForItem($styleNo,$matID);
	$sql="delete from materialratio where intStyleId = '$styleNo' AND strMatDetailID = '$matID'";	
	$db->executeQuery($sql);
	return true;
}

function SaveHistoryMatRatioForItem($styleNo,$matID)
{
	global $db;
	$sql = "insert into historymaterialratio (intStyleId, strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID)  select  intStyleId, 	strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID from materialratio where intStyleId = '$styleNo' and strMatDetailID = $matID";
	
	$db->executeQuery($sql);
}

function saveToHistoryStyle($styleID,$buyerPO)
{
	
	global $db;
	$sql="INSERT INTO historystyleratio(intStyleId,strBuyerPONO, strColor,strSize,dblQty,dblExQty,strUserId) SELECT intStyleId,strBuyerPONO, strColor,strSize,dblQty,dblExQty,strUserId FROM styleratio where intStyleId='$styleID' AND strBuyerPONO='$buyerPO';";

	
	  $db->ExecuteQuery($sql);	
}

function saveToHistoryMaterialRatio($styleID,$buyerPO)
{
	
	global $db;
	$sql="insert into historymaterialratio (intStyleId, strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty,materialRatioID)  select  intStyleId, 	strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty,materialRatioID from materialratio where intStyleId = '$styleID' AND strBuyerPONO='$buyerPO'";

	  $db->ExecuteQuery($sql);	
}

function saveToHistoryMaterial($styleID,$buyerPO,$matID)
{
	
	global $db;
	$sql="insert into historymaterialratio (intStyleId, strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID)  select  intStyleId, 	strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID from materialratio where intStyleId = '$styleID' AND strBuyerPONO='$buyerPO' AND strMatDetailID ='$matID'";

	  $db->ExecuteQuery($sql);	
}

 function getCharforID($id)
   {
   		$charVal = "";
		$pos = 0;		
		for ($loop = 'A' ;  $loop <= 'Z' ;  $loop ++)
		{
			if ($pos == $id)
			{
				$charVal .= $loop;
				break;
			}
			$pos ++;		
		}
		return $charVal;
   }

function DeleteContrast($styleNo,$ItemCode)
{
	global $db;
	$sql = "DELETE FROM contrastitem WHERE intStyleId = '$styleNo' AND strMatDetailID = '$ItemCode'";
	$db->ExecuteQuery($sql);	
}
//Start 31-03-2010 (functions that taking purchase qty and purchase color and size)
function getPoQty($styleID,$buyerPoNo,$matdetailId,$color,$size)
{
	global $db;
	$sql="select COALESCE(sum(dblQty),0)as poQty from purchaseorderdetails PD ".
		"inner join purchaseorderheader PH ".
		"on PH.intPONo=PD.intPoNo and PH.intYear=PD.intYear ".
		"where intStyleId='$styleID' ".
		"and strBuyerPONO='$buyerPoNo' ".
		"and intMatDetailID='$matdetailId' ".
		"and strColor='$color' ".
		"and strSize='$size' ".
		"and intStatus=10";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		return $row["poQty"];
	}

}
function getColorPoQty($styleID,$buyerPoNo,$matdetailId,$color)
{
	global $db;
	$sql="select COALESCE(sum(dblQty),0)as colorPoQty from purchaseorderdetails PD ".
		"inner join purchaseorderheader PH ".
		"on PH.intPONo=PD.intPoNo and PH.intYear=PD.intYear ".
		"where intStyleId='$styleID' ".
		"and strBuyerPONO='$buyerPoNo' ".
		"and intMatDetailID='$matdetailId' ".
		"and strColor='$color' ".
		"and intStatus=10";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		return $row["colorPoQty"];
	}

}
function getSizePoQty($styleID,$buyerPoNo,$matdetailId,$size)
{
	global $db;
	$sql="select COALESCE(sum(dblQty),0)as sizePoQty from purchaseorderdetails PD ".
		"inner join purchaseorderheader PH ".
		"on PH.intPONo=PD.intPoNo and PH.intYear=PD.intYear ".
		"where intStyleId='$styleID' ".
		"and strBuyerPONO='$buyerPoNo' ".
		"and intMatDetailID='$matdetailId' ".
		"and strSize='$size' ".
		"and intStatus=10";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		return $row["sizePoQty"];
	}

}
//End 31-03-2010 (functions that taking purchase qty and purchase color and size)
function GetMaterialRatioCount2($styleNo,$buyerPONo,$matDetailId)
{
	global $db;
	$sql= "select count(*) as recCount from materialratio where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo' AND strMatDetailID='$matDetailId'";	
	return $db->RunQuery($sql);
}
function UpdateMatRatioBalQty($styleNo,$itemCode,$freight)
{
global $db;
	$sql="select distinct strBuyerPONO,strColor,strSize from materialratio where intStyleId='$styleNo' and strMatDetailID='$itemCode'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$buyerPoNo 	= $row["strBuyerPONO"];
		$color 		= $row["strColor"];
		$size 		= $row["strSize"];	
		
		$poQty  		= getPurchasedQty($styleNo,$itemCode,$buyerPoNo,$color,$size,0);
		if($freight=='1')
			$freightPoQty  	= getPurchasedQty($styleNo,$itemCode,$buyerPoNo,$color,$size,1);
		else
			$freightPoQty = 0;
		UpdateMaterialRatioBalQty($styleNo,$itemCode,$buyerPoNo,$color,$size,$poQty,$freightPoQty,$freight);
	}
}
function UpdateMaterialRatioBalQty($styleNo,$itemCode,$buyerPoNo,$color,$size,$poQty,$freightPoQty,$freight)
{
global $db;
	if($freight=='1')
	{
		$sql_update="update materialratio set dblBalQty = dblQty - $poQty,dblFreightBalQty=dblQty-$freightPoQty where intStyleId='$styleNo' and strBuyerPONO='$buyerPoNo' and strMatDetailID='$itemCode' and strColor='$color' and strSize='$size' ";		
	}
	else
		$sql_update="update materialratio set dblBalQty = dblQty - $poQty,dblFreightBalQty=0 where intStyleId='$styleNo' and strBuyerPONO='$buyerPoNo' and strMatDetailID='$itemCode' and strColor='$color' and strSize='$size' ";
	//echo $sql_update;	
	$db->executeQuery($sql_update);
}

function confirmgetBulkAlloQty($styleID,$buyerPO,$matId,$color,$size)
{
global $db;
	$sqlBulkAllo = "SELECT COALESCE(sum(BCD.dblQty)) as Bulkqty
					FROM commonstock_bulkdetails BCD INNER JOIN commonstock_bulkheader BCH ON
					BCD.intTransferNo = BCH.intTransferNo AND 
					BCD.intTransferYear = BCH.intTransferYear
					WHERE BCH.intToStyleId = '$styleID'  and BCH.strToBuyerPoNo='$buyerPO' and 
					BCD.strColor = '$color' and BCD.strSize='$size' and 
					BCD.intMatDetailId = '$matId' and BCH.intStatus=1";
					
			$resulBulkAllo = $db->RunQuery($sqlBulkAllo);	
			$rowBulkAllo = mysql_fetch_array($resulBulkAllo);
			$Bulkqty = $rowBulkAllo["Bulkqty"];
			
			if($Bulkqty == '' || is_null($Bulkqty))
				$Bulkqty = 0;
			//echo $sqlBulkAllo;	
			return $Bulkqty;
}

function confirmLeftOverQty($styleID,$buyerPO,$matId,$color,$size)
{

global $db;
	$sqlLeftover = "SELECT COALESCE(sum(LCD.dblQty)) as LeftAlloqty
						FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 
						LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$styleID'  and LCH.strToBuyerPoNo= '$buyerPO' 
						and LCD.strColor = '$color' and LCD.strSize='$size' and 
						LCD.intMatDetailId = '$matId' and LCH.intStatus=1 ";	
						
			$resultLeftAllo = $db->RunQuery($sqlLeftover);	
			$rowLeftAllo = mysql_fetch_array($resultLeftAllo);
			$LeftAlloqty = $rowLeftAllo["LeftAlloqty"];
			//echo $sqlLeftover;
			if($LeftAlloqty == '' || is_null($LeftAlloqty))
				$LeftAlloqty = 0;	
				
		return $LeftAlloqty;
}
function getConfirmRecutQty($styleID,$item)
{
	global $db;
	$sql = "select COALESCE(sum(odr.dblTotalQty),0) as confirmQty from orders_recut orc inner join orderdetails_recut odr on 
orc.intRecutNo = odr.intRecutNo and orc.intRecutYear= odr.intRecutYear 
where orc.intStatus=3 and orc.intStyleId='$styleID' and odr.intMatDetailID='$item' ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["confirmQty"];
}
function getTotalSpecItemQty($styleNo,$item)
{
	global $db;
	$sql = " select dblTotalQty from specificationdetails where intStyleId='$styleNo' and strMatDetailID='$item' ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["dblTotalQty"];
	
}
function getItemBulkAllocationQty($styleNo,$itemCode)
{
	global $db;
	$sqlBulkAllo = "SELECT COALESCE(sum(BCD.dblQty),0) as Bulkqty
					FROM commonstock_bulkdetails BCD INNER JOIN commonstock_bulkheader BCH ON
					BCD.intTransferNo = BCH.intTransferNo AND 
					BCD.intTransferYear = BCH.intTransferYear
					WHERE BCH.intToStyleId = '$styleNo'  and 
					BCD.intMatDetailId = '$itemCode' and BCH.intStatus  not in (11) ";
					
			$resulBulkAllo = $db->RunQuery($sqlBulkAllo);	
			$rowBulkAllo = mysql_fetch_array($resulBulkAllo);
			$Bulkqty = $rowBulkAllo["Bulkqty"];
		
			return $Bulkqty;
}

function getItemLeftoverQty($styleNo,$itemCode)
{
	global $db;
	$sqlLeftover = "SELECT COALESCE(sum(LCD.dblQty),0) as LeftAlloqty
						FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 
						LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$styleNo'  and 
						LCD.intMatDetailId = '$itemCode' and LCH.intStatus not in (11) ";	
						
			$resultLeftAllo = $db->RunQuery($sqlLeftover);	
			$rowLeftAllo = mysql_fetch_array($resultLeftAllo);
			$LeftAlloqty = $rowLeftAllo["LeftAlloqty"];
			
			return $LeftAlloqty;
}
function getItemInterjobQty($styleNo,$itemCode)
{
	global $db;
	$sqlinter="select COALESCE(Sum(ID.dblQty),0) as interJobQty from itemtransfer IH 
inner join itemtransferdetails ID on IH.intTransferId=ID.intTransferId and IH.intTransferYear=ID.intTransferYear
where IH.intStyleIdTo='$styleNo' and  ID.intMatDetailId='$itemCode' and IH.intStatus not in (10) ";
	$result_inter=$db->RunQuery($sqlinter);
	$row = mysql_fetch_array($result_inter);
	
	return $row["interJobQty"];
}

if (strcmp($RequestType,"selectStyles") == 0)
{
	 $ResponseXML = "";
	 $styleId = $_GET["styleId"];
	 $ResponseXML .= "<RequestDetails1>\n";
	 $result=selectStyleDetails($styleId);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<color><![CDATA[" . $row["strColor"]  . "]]></color>\n";   
     }
	 $ResponseXML .= "</RequestDetails1>";
	 echo $ResponseXML;
	
}
function selectStyleDetails($styleId)
{
	global $db;
	$sql="SELECT 
				conpccalculation.strColor
			FROM conpccalculation WHERE
                conpccalculation.intStyleId =  '$styleId'";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
}


?>