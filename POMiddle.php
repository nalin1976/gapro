<?php
/**
 * @Chinthaka Jayasekara
 * @copyright 2009
 */
session_start();
include "Connector.php";
//include "HeaderConnector.php";
//include "permissionProvider.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

//$db =new DBManager();
$userID=$_SESSION["UserID"];
//$baseCurrID = $_SESSION["sys_currency"];
//$userID=1;
$RequestType = $_GET["RequestType"];

if (strcmp($RequestType,"BuyerPO") == 0)
{
	 $ResponseXML = "";
	 $StyleID=$_GET["StyleID"];
	 $ResponseXML .= "<BuyerPO>\n";
	 
	 $result=getBuyerPO($StyleID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
	 	$buyerPoName = '#Main Ratio#';
		if($row["strBuyerPONO"]!='#Main Ratio#')
			$buyerPoName = GetBuyerPoName($row["strBuyerPONO"]);
			
		 $ResponseXML .= "<PO><![CDATA[" . $row["strBuyerPONO"]  . "]]></PO>\n";
		 $ResponseXML .= "<BuyerPoName><![CDATA[" . $buyerPoName . "]]></BuyerPoName>\n";
                       
	 }
	 $ResponseXML .= "</BuyerPO>";
	 echo $ResponseXML;
}

// ====================================================
// Add On - 10/14/2015
// Add By - Nalin Jayakody
// Descri - Listing buyer po numbers for the PO
// ====================================================
if (strcmp($RequestType,"BuyerPOList") == 0)
{
	 $ResponseXML = "";
	 $StyleID=$_GET["StyleID"];
	 $ResponseXML .= "<BuyerPO>\n";
	 
	 /*$result=getBuyerPO($StyleID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
	 	$buyerPoName = '#Main Ratio#';
		if($row["strBuyerPONO"]!='#Main Ratio#')
			$buyerPoName = GetBuyerListing($row["strBuyerPONO"]);
			
		 $ResponseXML .= "<PO><![CDATA[" . $row["strBuyerPONO"]  . "]]></PO>\n";
		 $ResponseXML .= "<BuyerPoName><![CDATA[" . $buyerPoName . "]]></BuyerPoName>\n";
                       
	 }*/
         
         //================================================================
         // Add By - Nalin Jayakody
         // Add On - 02/04/2017
         // Add For - Get buyer PO list from style buyer po table instead of material ratio
         // ================================================================
         
         $ResponseXML .= "<PO><![CDATA[" . '#Main Ratio#'  . "]]></PO>\n";
         $ResponseXML .= "<BuyerPoName><![CDATA[" . '#Main Ratio#' . "]]></BuyerPoName>\n";
         
         $resBuyerPO = GetBuyerPOFromStyleBuyerPO($StyleID);
         
         while(list($strBuyerPO, $strBuyerPOName) = mysql_fetch_array($resBuyerPO)){
             $ResponseXML .= "<PO><![CDATA[" . $strBuyerPOName  . "]]></PO>\n";
             $ResponseXML .= "<BuyerPoName><![CDATA[" . $strBuyerPO . "]]></BuyerPoName>\n";
         }
         // ================================================================
	 $ResponseXML .= "</BuyerPO>";
	 echo $ResponseXML;
}

else if (strcmp($RequestType,"getSupplierData") == 0)
{

	 $ResponseXML = "";
	 $supId=$_GET["supId"];
	 $ResponseXML .= "<supDetails>\n";
	 
	 $sql = "	SELECT
			suppliers.strPayTermId,
			suppliers.strPayModeId,
			suppliers.strShipmentTermId,
			suppliers.intShipmentModeId,
			suppliers.strCurrency,
			suppliers.strCountry
			FROM `suppliers`
			WHERE
			suppliers.strSupplierID =  '$supId'";
			
	 $result=$db->RunQuery($sql);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<strPayTermId><![CDATA[" . $row["strPayTermId"]  . "]]></strPayTermId>\n";
		 $ResponseXML .= "<strPayModeId><![CDATA[" . $row["strPayModeId"]  . "]]></strPayModeId>\n";
		 $ResponseXML .= "<strShipmentTermId><![CDATA[" . $row["strShipmentTermId"]  . "]]></strShipmentTermId>\n";
		 $ResponseXML .= "<intShipmentModeId><![CDATA[" . $row["intShipmentModeId"]  . "]]></intShipmentModeId>\n";
		 $ResponseXML .= "<strCurrency><![CDATA[" . $row["strCurrency"]  . "]]></strCurrency>\n";
		 $ResponseXML .= "<strCountry><![CDATA[" . $row["strCountry"]  . "]]></strCountry>\n";
                       
	 }
	 $ResponseXML .= "</supDetails>";
	 echo $ResponseXML;
}
else if (strcmp($RequestType,"getSupplierData1") == 0)
{

	 $ResponseXML = "";
	 $supId=$_GET["supId"];
	 $sql = "	SELECT
suppliers.strPayTermId,
suppliers.strPayModeId,
suppliers.strShipmentTermId,
suppliers.intShipmentModeId,
(suppliers.strCurrency) as curancy, 
suppliers.strCountry,
currencytypes.strCurrency
FROM
suppliers
left Join currencytypes ON suppliers.strCurrency = currencytypes.intCurID
			WHERE
			suppliers.strSupplierID =  '$supId'";
			
	 $result=$db->RunQuery($sql);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 
		$str .=  "<option value=\"". $row["curancy"] ."\">" . $row["strCurrency"] ."</option>" ;
	}
	
	
	$ResponseXML.="<curType>";
	$ResponseXML.="<strCurrency1><![CDATA[" .$str. "]]></strCurrency1>\n";
	$ResponseXML.="</curType>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"getCurrancyData") == 0)
{

	 $ResponseXML = "";
	
	 $sql = "SELECT intCurID,strCurrency FROM currencytypes c where intStatus='1' order by strCurrency";
			
	 $result=$db->RunQuery($sql);
	 $str .= "<option value=\"". '0' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {
		 
		$str .=  "<option value=\"". $row["intCurID"] ."\">" . $row["strCurrency"] ."</option>" ;
	}
	
	
	$ResponseXML.="<curType1>";
	$ResponseXML.="<strCurrency11><![CDATA[" .$str. "]]></strCurrency11>\n";
	$ResponseXML.="</curType1>";
	echo $ResponseXML;
}

else if (strcmp($RequestType,"getGrnStatus") == 0)
{
	$pono=$_GET["pono"];
	$poYear=$_GET["poYear"];
	$SQL="SELECT grnheader.intGrnNo FROM grnheader WHERE grnheader.intPoNo =  '$pono' and grnheader.intYear = '$poYear' AND grnheader.intStatus = 10";
	$numRows=0;
	$result = $db->RunQuery($SQL);
	$numRows = mysql_num_rows($result);
	echo "<num>$numRows</num>";
}
else if (strcmp($RequestType,"DiliveryDate") == 0)
{
	 $ResponseXML = "";
	 $StyleID=$_GET["StyleID"];
	 $ResponseXML .= "<DiliverDate>\n";
	 
	 $result=getdiliveryDate($StyleID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<Date><![CDATA[" . $row["deliveryDate"]  . "]]></Date>\n";
		 $ResponseXML .= "<DateFormat><![CDATA[" . $row["dateFormat"]  . "]]></DateFormat>\n";             
	 }
	 $ResponseXML .= "</DiliverDate>";
	 echo $ResponseXML;
}
else if (strcmp($RequestType,"SRNo") == 0)
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
else if(strcmp($RequestType,"MainCat") == 0)
{
$ResponseXML = "";
	$StyleID=$_GET["StyleID"];
	 $ResponseXML .= "<MainCat>\n";
	 
	 $result=getMainCat($StyleID);
	 $ComboMC .= "<option value=\"". '' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {
		 $ComboMC .= "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;                   
	 }
	 $ResponseXML.="<main><![CDATA[" .$ComboMC. "]]></main>";
	 $ResponseXML .= "</MainCat>";
	 echo $ResponseXML;
}
else if(strcmp($RequestType,"loadSubCategoryDet") == 0)
{
$ResponseXML = "";
	 
	 $StyleID=$_GET["styleId"];
	 $mainCatId = $_GET["mainCatId"];
	 $ResponseXML .= "<SubCat>\n";
	 
	 $result=getSubCat($StyleID,$mainCatId);
	 $str = '';
	 $str .= "<option value=\"". '' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {
		$str .= "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>";
		 
                       
	 }
	 $ResponseXML .= "<subCatID><![CDATA[" . $str  . "]]></subCatID>\n";
	 $ResponseXML .= "</SubCat>";
	 echo $ResponseXML;
}
if ($RequestType=="GetItemDis")
{

	 $ResponseXML = "";
	 $StyleID=$_GET["StyleID"];
	 /*$buyerPO=$_GET["buyerPO"];
	 $postate=$_GET["postate"];
	 //echo $buyerPO; // MAIN RATIO

	
	 $diliveryDate=$_GET["diliveryDate"];
	 $srNo=$_GET["srNo"];
	 $mainCat=$_GET["mainCatID"];
	 $subCat = $_GET["subCat"];*/
	 
	 $ResponseXML .= "<Items>\n";
	 
	  $supID=$_GET["supID"];
	  if($supID != 'N/A')
	  {
	  		 $result=getItemDeatilsSupWise($StyleID,$supID/*,$buyerPO,$diliveryDate,$srNo,$mainCat,$postate,$supID,$subCat*/);
	  }
	  else
	  {
	  		 $result=getItemDeatils($StyleID/*,$buyerPO,$diliveryDate,$srNo,$mainCat,$postate,$subCat*/);
	  }
	
	 
	 while($row = mysql_fetch_array($result))
  	 {
	 	
		 
		 //start 2010-10-13 display item color,size, pending qty, bulk allo qty and leftover qty in selection grid
		 
		 $ItemID =  $row["intItemSerial"];
		
		 
		 $resultItem=getPOMat($StyleID/*,$buyerPO,$postate,$diliveryDate,$mainCat*/);	
	 
		 while($rowI = mysql_fetch_array($resultItem))
		 {	 	
			$ResponseXML .= "<ItemID><![CDATA[" . $ItemID  . "]]></ItemID>\n";
			$ResponseXML .= "<Color><![CDATA[" . $rowI["strColor"]  . "]]></Color>\n";
			$ResponseXML .= "<Size><![CDATA[" . $rowI["strSize"]  . "]]></Size>\n";
			$ResponseXML .= "<Qty><![CDATA[" . $rowI["dblBalQty"]  . "]]></Qty>\n";
			
			$ResponseXML .= "<ItemName><![CDATA[" . $rowI["strItemDescription"]  . "]]></ItemName>\n";
			$ResponseXML .= "<unitprice><![CDATA[" . $rowI["dblUnitPrice"]  . "]]></unitprice>\n";
			$ResponseXML .= "<dblfreight><![CDATA[" . $rowI["dblfreight"]  . "]]></dblfreight>\n";	
			
			//$orderQty = $rowI["dblQty"];
			//$pendingQty = 0;
			$pendingQty = $rowI["dblBalQty"];
			
			//$Qty = getPOItemPendingQty($pendingQty,$ItemID,$StyleID,$rowI["strColor"],$rowI["strSize"],$buyerPO);
			$Qty = GetMaterialRatioBalQty($StyleID,/*$buyerPO,*/$ItemID,$rowI["strColor"],$rowI["strSize"],0);
			$leftOverQty = getLeftoverStockWithoutPendingQty($ItemID,$StyleID,$rowI["strColor"],$rowI["strSize"]/*,$buyerPO*/);
			$BulkQty = getBulkStockWithoutPendingQty($ItemID,$StyleID,$rowI["strColor"],$rowI["strSize"]/*,$buyerPO*/);
			$liabilityQty = getLiabilityStockWithoutPendingQty($ItemID,$StyleID,$rowI["strColor"],$rowI["strSize"]/*,$buyerPO*/);
			if($Qty<0)
				$Qty = 0;
			
			//start 2011-09-08 get Freight & nonFreight qty,bal qty 
			if($postate == 1)
			{
			 	$totQty = $rowI["dblQty"]; //get material ratio qty for freight items
				$Qty = $rowI["dblFreightBalQty"];
				$leftOverQty =0;
				$BulkQty =0;
			}	
			else
			{
				$totQty = $rowI["dblQty"]+$rowI["dblRecutQty"];
			}	 
			//end 2011-09-08 get Freight & nonFreight qty,bal qty 
				
			$ResponseXML .= "<totQty><![CDATA[" . $totQty  . "]]></totQty>\n";
			$ResponseXML .= "<orderQty><![CDATA[" . $orderQty . "]]></orderQty>\n";
			$ResponseXML .= "<ItemLeftOverQty><![CDATA[" . $leftOverQty . "]]></ItemLeftOverQty>\n";
		 	$ResponseXML .= "<ItemBulkQty><![CDATA[" . $BulkQty . "]]></ItemBulkQty>\n";
			$ResponseXML .= "<liabilityQty><![CDATA[" . $liabilityQty . "]]></liabilityQty>\n";
			$ResponseXML .= "<POTotalQty><![CDATA[" . $dblPOtotal . "]]></POTotalQty>\n";
			$ResponseXML .= "<pendingQty><![CDATA[" . $Qty . "]]></pendingQty>\n";
			$ItemQty=501;
			
			/*if($canOrderAdditional)
			{
				$B = "";
				if ($buyerPO == "#Main Ratio#")
				{            
						$B = 	"SELECT
								(orders.intQty) AS ItemQty
								FROM
								orderdetails
								INNER JOIN orders ON orders.strOrderNo = orderdetails.strOrderNo AND orders.intStyleId = orderdetails.intStyleId INNER JOIN 
								matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial INNER JOIN matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo 
								WHERE
								orderdetails.intStyleId =  '$styleID' AND
								orderdetails.intMatDetailID =  '$value' AND matsubcategory.intAdditionalAllowed = '1'";
				}
				else
				{
					$B = "SELECT DISTINCT dblQty FROM style_buyerponos 
		INNER JOIN orderdetails ON style_buyerponos.intStyleId = orderdetails.intStyleId INNER JOIN 
								matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial INNER JOIN matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo 
		WHERE style_buyerponos.intStyleId = '$styleID' AND style_buyerponos.strBuyerPONO = '$buyerPO' AND matsubcategory.intAdditionalAllowed = '1'  AND orderdetails.intMatDetailID =  '$value' ";
				}		
						
					
				$Bresult=$db->RunQuery($B);
				
				while($Brow = mysql_fetch_array($Bresult))
				{
					$ItemQty = $Brow["ItemQty"];
				}
			}
					
		$ResponseXML .= "<ItemQty><![CDATA[" . $ItemQty . "]]></ItemQty>\n";*/
	 }
                       
	 }
	 $ResponseXML .= "</Items>";
	 echo $ResponseXML;
	
}
else if(strcmp($RequestType,"StyleNo") == 0)
{

	$ResponseXML = "";	 
	$ResponseXML .= "<StyleID>\n";	 
	
	// $result=getStyleID();	
	$result=getStyleNameList();	
	  $ComboString .= "<option value=\"". 'Select One' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
	 
		
		$ComboString .= "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		                
	 }
	 	
	$ResponseXML.="<StyleNo><![CDATA[" .$ComboString. "]]></StyleNo>\n";
	 $ResponseXML .= "</StyleID>";
	 echo $ResponseXML;	
	 //echo $ComboString;
}

else if(strcmp($RequestType,"getStyleWiseOrderNum") == 0)
{

	$ResponseXML="";
	$stytleName = $_GET["stytleName"];
	
	$SQL = " select intStyleId,strOrderNo
			from orders
			where   intUserID = " . $_SESSION["UserID"] . " and  intStatus  =11";
		
	if($stytleName != '' || $stytleName != 'Select One')
		$SQL .= " and strStyle='$stytleName' ";
		
		$SQL .= "order by strOrderNo ";		
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
else if(strcmp($RequestType,"SCList") == 0)
{

	$ResponseXML = "";	 
	$ResponseXML .= "<StyleID>\n";	 
	$styleName = $_GET["styleName"];
	
	 $result=getSCList($styleName);	
	  $ComboString .= "<option value=\"". 'Select One' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
	 
		//$ResponseXML .= "<Style><![CDATA[" . $row["intStyleId"]  . "]]></Style>\n";
		$ComboString .= "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
		                
	 }	
	 
	 $ResponseXML.="<SCNo><![CDATA[" .$ComboString. "]]></SCNo>\n";
	 $ResponseXML .= "</StyleID>";
	 echo $ResponseXML;	 
	 //echo $ComboString;
	 
}
else if(strcmp($RequestType,"StyleList") == 0)
{

	$ResponseXML = "";	 
	$ResponseXML .= "<scno>\n";	 
	$cboScNo = $_GET["cboScNo"];
	
	 $result=getStyleList($cboScNo);	
	  //$ComboString .= "<option value=\"". 'Select One' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
	 
		//$ResponseXML .= "<Style><![CDATA[" . $row["intStyleId"]  . "]]></Style>\n";
		$ComboString .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
		                
	 }	
	 
	 $ResponseXML.="<StyleNo><![CDATA[" .$ComboString. "]]></StyleNo>\n";
	 $ResponseXML .= "</scno>";
	 echo $ResponseXML;	 
	 //echo $ComboString;
	 
}
else if(strcmp($RequestType,"SupList") == 0)
{

	$ResponseXML = "";	 
	$ResponseXML .= "<currncy>\n";	 
	$cbocurrency = $_GET["cbocurrency"];
	
	 $result=getCurrList($cbocurrency);	
	  //$ComboString .= "<option value=\"". 'Select One' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
	 
		//$ResponseXML .= "<Style><![CDATA[" . $row["intStyleId"]  . "]]></Style>\n";
		$ComboString .= "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
		                
	 }	
	 
	 $ResponseXML.="<SuP><![CDATA[" .$ComboString. "]]></SuP>\n";
	 $ResponseXML .= "</currncy>";
	 echo $ResponseXML;	 
	 //echo $ComboString;
	 
}
else if(strcmp($RequestType,"POMainItems") == 0)				/////////////    xxxxxxxxxxxxxxxxxxx
{

	$ResponseXML = "";	 

	$ResponseXML .= "<POMatItems>\n";	
	
	//$itemList=$_GET["itemIDs"];
	$styleID=$_GET["styleID"];
	$buyerPO=$_GET["buyerPO"];
	$postate=$_GET["poState"];
	$deliveryDate=$_GET["dilDate"];
	$catID = $_GET["material"];
	$itemID = $_GET["matDetailID"];
	$color = $_GET["color"];
	$size  = $_GET["size"]; 
	//$arr = explode(',', $itemList); 

	/*foreach ($arr as $value)
	{*/
	
	 //$result=getPOMat($value,$styleID,$buyerPO,$postate,$deliveryDate,$catID);	
	 $result = getPOMaterialDetails($itemID,$styleID,$buyerPO,$poState,$deliveryDate,$catID,$color,$size);
	 
	 while($row = mysql_fetch_array($result))
  	 {	 
		$unitPrice = $row["dblUnitPrice"];
		//echo $unitPrice;
		if($row["strColor"] != "")
			echo $sql = "SELECT dblUnitPrice FROM conpccalculation WHERE intStyleId = '" . $row["intStyleId"]  . "' AND strMatDetailID = '$value' AND strColor = '" . $row["strColor"]  . "'";
			
		if($row["strSize"] != "")
			$sql = "SELECT dblUnitPrice FROM conpccalculation WHERE intStyleId = '" . $row["intStyleId"]  . "' AND strMatDetailID = '$value' AND strSize = '" . $row["strSize"]  . "'";
			
		if($row["strColor"] != "" && $row["strSize"] != "")
			$sql = "SELECT dblUnitPrice FROM conpccalculation WHERE intStyleId = '" . $row["intStyleId"]  . "' AND strMatDetailID = '$value' AND strColor = '" . $row["strColor"]  . "' AND strSize = '" . $row["strSize"]  . "'";

		$colorResult = $db->RunQuery($sql);
		while($rowcolor = mysql_fetch_array($colorResult))
		{
			$unitPrice = $rowcolor["dblUnitPrice"];
			break;
		}
		$buyerPoName	= '#Main Ratio#';
		if($row["strBuyerPONO"]!='#Main Ratio#')
			$buyerPoName	= GetBuyerPoName($row["strBuyerPONO"]);
			
		$ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"]  . "]]></StyleID>\n";
		$ResponseXML .= "<StyleName><![CDATA[" . $row["strStyle"]  .  " - " . $row["strOrderNo"]  .  "]]></StyleName>\n";
		$ResponseXML .= "<BuyerPO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPO>\n";
		$ResponseXML .= "<BuyerPoName><![CDATA[" . $buyerPoName . "]]></BuyerPoName>\n";
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		//start 2010-10-13 get balance with po,bulk & leftover qty  
		//$ResponseXML .= "<Qty><![CDATA[" . $row["dblBalQty"]  . "]]></Qty>\n";
		$ResponseXML .= "<ItemName><![CDATA[" . $row["strItemDescription"]  . "]]></ItemName>\n";
		$ResponseXML .= "<MainCatName><![CDATA[" . $row["strDescription"]  . "]]></MainCatName>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		$ResponseXML .= "<UnitPrice><![CDATA[" . $unitPrice  . "]]></UnitPrice>\n";
		$ResponseXML .= "<MatDetailID><![CDATA[" . $itemID . "]]></MatDetailID>\n";
		$ResponseXML .= "<dblFreightBalQty><![CDATA[" . $row["dblFreightBalQty"] . "]]></dblFreightBalQty>\n";
		$ResponseXML .= "<dblfreightUnitPrice><![CDATA[" . $row["dblfreight"] . "]]></dblfreightUnitPrice>\n";
		//dblFreightBalQty
		
		$A = "  SELECT
				Sum(purchaseorderdetails.dblQty) AS Tqty
				FROM
				purchaseorderdetails
				Inner Join matitemlist ON matitemlist.intItemSerial = purchaseorderdetails.intMatDetailID
				Inner Join matsubcategory ON matsubcategory.intSubCatNo = matitemlist.intSubCatID
				Inner Join purchaseorderheader ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear
				WHERE
				purchaseorderdetails.intStyleId =  '$styleID' AND
				purchaseorderdetails.intPOType =  '0' AND
				purchaseorderheader.intStatus =  '10' AND
				purchaseorderdetails.intMatDetailID =  '$value' AND
				purchaseorderdetails.strColor =  '".$row["strColor"]."' AND
				purchaseorderdetails.strSize =  '".$row["strSize"]."' AND
				purchaseorderdetails.strBuyerPONO = '$buyerPO' ";
				//echo $A;
				//break;
		$Aresult=$db->RunQuery($A);
		$dblPOtotal=0;
		while($Arow = mysql_fetch_array($Aresult))
  	 	{
			$dblPOtotal = $Arow["Tqty"];
		}
		$ResponseXML .= "<POTotalQty><![CDATA[" . $dblPOtotal . "]]></POTotalQty>\n";
		$ItemQty=501;
		if($canOrderAdditional)
		{
		$B = "";
		if ($buyerPO == "#Main Ratio#")
		{            
				$B = 	"SELECT
						(orders.intQty) AS ItemQty
						FROM
						orderdetails
						INNER JOIN orders ON orders.strOrderNo = orderdetails.strOrderNo AND orders.intStyleId = orderdetails.intStyleId INNER JOIN 
						matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial INNER JOIN matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo 
						WHERE
						orderdetails.intStyleId =  '$styleID' AND
						orderdetails.intMatDetailID =  '$value' AND matsubcategory.intAdditionalAllowed = '1'";
		}
		else
		{
			$B = "SELECT DISTINCT dblQty FROM style_buyerponos 
INNER JOIN orderdetails ON style_buyerponos.intStyleId = orderdetails.intStyleId INNER JOIN 
						matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial INNER JOIN matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo 
WHERE style_buyerponos.intStyleId = '$styleID' AND style_buyerponos.strBuyerPONO = '$buyerPO' AND matsubcategory.intAdditionalAllowed = '1'  AND orderdetails.intMatDetailID =  '$value' ";
		}		
				
			
		$Bresult=$db->RunQuery($B);
		
		while($Brow = mysql_fetch_array($Bresult))
  	 	{
			$ItemQty = $Brow["ItemQty"];
		}
		}
		$ResponseXML .= "<ItemQty><![CDATA[" . $ItemQty . "]]></ItemQty>\n";
		
		$pendingQty = $row["dblBalQty"];
		//Qty = ratioQty - pending Allocation Qty
		//$Qty = getPOItemPendingQty($pendingQty,$itemID,$styleID,$row["strColor"],$row["strSize"],$buyerPO);
		$Qty = GetMaterialRatioBalQty($styleID,/*$buyerPO,*/$itemID,$row["strColor"],$row["strSize"],0);
		
		$leftOverQty = 	getLeftoverStockWithoutPendingQty($itemID,$styleID,$row["strColor"],$row["strSize"]/*,$buyerPO*/);
		$BulkQty = 	getBulkStockWithoutPendingQty($itemID,$styleID,$row["strColor"],$row["strSize"]/*,$buyerPO*/);
		//$liabilityQty = getLiabilityStockWithoutPendingQty($itemID,$styleID,$row["strColor"],$row["strSize"],$buyerPO);
			//if cantPurchaseStockAvailable permission available can't purchase pending qty
			if($cantPurchaseStockAvailable)
			{
				$totAllocationStock = $leftOverQty + $BulkQty;
				if($totAllocationStock > $Qty)
					$Qty=0;
			}
									
				$ResponseXML .= "<Qty><![CDATA[" . $Qty  . "]]></Qty>\n";
	 }
	 
	 //}//end foreach	
	 $ResponseXML .= "</POMatItems>";	 
	 echo $ResponseXML;
}
else if(strcmp($RequestType,"POMainItemsStyle") == 0)
{
global $db;

	$ResponseXML = "";	 

	$ResponseXML .= "<POMatItems>\n";	
	
	$MatDetailID=$_GET["MatID"];
	$styleIDs=$_GET["styleID"];
	$buyerPOs=$_GET["buyerPO"];
	$arrStyle = explode(',', $styleID); 
	$count=0;
	foreach ($arrStyle as $value)
	{
	$buyerPO=$arrStyle[$count];

	 $count++;
	$sql="SELECT DISTINCT r.intStyleId,r.strBuyerPONO,r.strColor,r.strSize,r.dblBalQty,m.strItemDescription,m.strUnit,s.dblUnitPrice FROM materialratio r INNER JOIN matitemlist m ON m.intItemSerial=r.strMatDetailID INNER JOIN specificationdetails s ON s.strMatDetailID=r.strMatDetailID INNER JOIN deliveryschedule d ON d.intStyleId=r.intStyleId  WHERE r.intStyleId='$value' AND s.intStyleId='$value' AND r.strMatDetailID='$MatDetailID' AND r.strBuyerPONO='$buyerPO' AND r.dblBalQty>0 AND d.dtDateofDelivery>now();";
	$result=$db->RunQuery($sql);	
	 
	 while($row = mysql_fetch_array($result))
  	 {	 
	 
		$ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"]  . "]]></StyleID>\n";
		$ResponseXML .= "<BuyerPO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPO>\n";
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<Qty><![CDATA[" . $row["dblBalQty"]  . "]]></Qty>\n";
		$ResponseXML .= "<ItemName><![CDATA[" . $row["strItemDescription"]  . "]]></ItemName>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		$ResponseXML .= "<UnitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></UnitPrice>\n";
		$ResponseXML .= "<MatDetailID><![CDATA[" . $MatDetailID . "]]></MatDetailID>\n";
		
		                
	 }
	 }
	 
	 $ResponseXML .= "</POMatItems>";	 
	 echo $ResponseXML;



}
if($RequestType == "getCompanies")
{
//echo "kkk";
$ResponseXML = "";	
$ResponseXML .= "<Dilivery>\n";
global $db;
$sql="SELECT strComCode,intCompanyID FROM companies c where intStatus='1'";	
$result=$db->RunQuery($sql);
 while($row = mysql_fetch_array($result))
  	 {
	 	 $ResponseXML .= "<CompanyID><![CDATA[" . $row["intCompanyID"]  . "]]></CompanyID>\n";
		 $ResponseXML .= "<Company><![CDATA[" . $row["strComCode"]  . "]]></Company>\n";
	 }
	 
	 $ResponseXML .= "</Dilivery>";
 	 echo $ResponseXML;
}
else if(strcmp($RequestType,"savePOheader") == 0)
{

$intPONo=$_GET["poNo"];
$intYear=$_GET["Year"];
$strSupplierID=$_GET["SupplierID"];
$dtmDeliveryDate=$_GET["DeliveryDate"];
$strCurrency=$_GET["Currency"];
$intStatus=1;
$intInvCompID=$_GET["InvCompID"];
$intPrintStatus="0";
$intDelToCompID=$_GET["DelToCompID"];
$dblPOValue=$_GET["POValue"];
$strPayTerm=$_GET["PayTerm"];
$strPayMode=$_GET["PayMode"];
$strInstructions=$_GET["Instructions"];
$strPINO=$_GET["PINO"];
$strShipmentMode=$_GET["ShipmentMode"];
$strShipmentTerm=$_GET["ShipmentTerm"];
$dtmETA=$_GET["ETA"];
$dtmETD=$_GET["ETD"];
$sewFactory = $_GET["sewFactory"];

//$strInstructions = str_replace("'","''",$strInstructions);
$userID=$_SESSION["UserID"];
global $db;
/*$sql="SELECT intCompanyID FROM useraccounts u WHERE intUserID='$userID';";
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$companyID=$row["intCompanyID"];

}*/
$companyID = $_SESSION["FactoryID"];

if($intPONo!="")
{
updatePOHeaderdata($intPONo,$intYear,$strSupplierID,$dtmDeliveryDate,$strCurrency,$intStatus,$intInvCompID,$intPrintStatus,$intDelToCompID,$dblPOValue,$strPayTerm,$strPayMode,$strInstructions,$strPINO,$strShipmentMode,$strShipmentTerm,$dtmETA,$dtmETD,$sewFactory);
$resultPO=$intPONo;

}
else
{

$resultPO=savePOHeader($intYear,$strSupplierID,$dtmDeliveryDate,$strCurrency,$intStatus,$intInvCompID,$intPrintStatus,$intDelToCompID,$dblPOValue,$strPayTerm,$strPayMode,$strInstructions,$strPINO,$strShipmentMode,$strShipmentTerm,$dtmETA,$dtmETD,$companyID,$sewFactory);

}


$ResponseXML = "";	
$ResponseXML .= "<PONo>\n";
$ResponseXML .= "<po><![CDATA[" . $resultPO . "]]></po>\n";
$ResponseXML .= "</PONo>";
echo $ResponseXML;

}
else if(strcmp($RequestType,"getExchangeRate") == 0)
{
$ResponseXML = "";	
$ResponseXML .= "<RateM>\n";
$currencyType=$_GET["curType"];

global $db;
//$sql="SELECT ER.rate FROM currencytypes CT inner join exchangerate ER on ER.currencyID=CT.intCurID  where CT.strCurrency='$currencyType' and ER.intStatus=1;";
$sql="SELECT ER.rate FROM exchangerate ER where ER.currencyID='$currencyType' and ER.intStatus=1;";

$response =$db->CheckRecordAvailability($sql);
if($response == 1)
	{
		$result=$db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
		$ResponseXML .= "<Rate><![CDATA[" . $row["rate"] . "]]></Rate>\n";
		}
	}
	else
	{
		$rateD = 'NA';
		$ResponseXML .= "<Rate><![CDATA[" . $rateD . "]]></Rate>\n";
	}
$ResponseXML .= "</RateM>";
echo $ResponseXML;


}

else if(strcmp($RequestType,"savePOdetail") == 0)
{
// pono
$ResponseXML .= "<SaveDet>\n";
$intYear=$_GET["Year"];
$strStyleID=$_GET["StyleID"];
$intMatDetailID=$_GET["MatDetailID"];
$strColor=$_GET["Color"];
$strSize=$_GET["Size"];
$strBuyerPONO=$_GET["BuyerPONO"];
$strRemarks=$_GET["Remarks"];
$strUnit=$_GET["Unit"];
$dblUnitPrice=$_GET["UnitPrice"];
$dblQty=$_GET["Qty"];
$dblPending=$_GET["Pending"];
$dblAdditionalQty=$_GET["AdditionalQty"];

if($dblAdditionalQty=="")
	$dblAdditionalQty=0;
	
$intDeliverToCompId=$_GET["DeliverToCompId"];
$dtmItemDeliveryDate=$_GET["ItemDeliveryDate"];
$intPoNou=$_GET["poNou"];
$pono=$_GET["pono"];
$type		= $_GET["type"];


//$strRemarks = str_replace("'","''",$strRemarks);

	if($intPoNou!="")
	{
	  $res = updatePodetails($intYear,$strStyleID,$intMatDetailID,$strColor,$strSize,$strBuyerPONO,$strRemarks,$strUnit,$dblUnitPrice,$dblQty,$dblPending,$dblAdditionalQty,$intDeliverToCompId,$dtmItemDeliveryDate,$intPoNou,$type);
	//$res = 'save';
	
	}
	else
	{
	
	 $res = savePODetails($pono,$intYear,$strStyleID,$intMatDetailID,$strColor,$strSize,$strBuyerPONO,$strRemarks,$strUnit,$dblUnitPrice,$dblQty,$dblPending,$dblAdditionalQty,$intDeliverToCompId,$dtmItemDeliveryDate,$type);
	//$res = 'save';
	
	}
	$ResponseXML .= "<SaveDetResponse><![CDATA[" . $res . "]]></SaveDetResponse>\n";
	$ResponseXML .= "</SaveDet>";
	echo $ResponseXML;
}

else if(strcmp($RequestType,"POValidity") == 0)
{
$pono=$_GET["Pono"];
$result=ISValidPO($pono);
$ResponseXML = "";	
$ResponseXML .= "<IsvalidPO>\n";
$ResponseXML .= "<POValid><![CDATA[" . $result . "]]></POValid>\n";
$ResponseXML .= "</IsvalidPO>";
echo $ResponseXML;
}
else if(strcmp($RequestType,"copyPO") == 0)
{
$ResponseXML = "";	 
$ResponseXML .= "<PODetail>\n";	
$formatedETADate="";
$formatedETDDate="";	
$poNo=$_GET["pono"];
$year = $_GET["year"];
$result=getPOHederDetailsCopy($poNo,$year);	
	  
	 while($row = mysql_fetch_array($result))
  	 {	 
	 $shortDate=substr($row["dtmDate"] ,0,10);
	 $DateArray=explode('-',$shortDate);
	 $formatedDate=$DateArray[2]."/".$DateArray[1]."/".$DateArray[0];
	 $shortDiliveryDate=substr($row["dtmDeliveryDate"] ,0,10);
	 $DateDilArray=explode('-',$shortDiliveryDate);
	 $formatedDilDate=$DateDilArray[2]."/".$DateDilArray[1]."/".$DateDilArray[0];
	 if($row["dtmETA"]!="")
	 {
	 $shortETADate=substr($row["dtmETA"] ,0,10);
	 $ETADateArray=explode('-',$shortETADate);
	 $formatedETADate=$ETADateArray[2]."/".$ETADateArray[1]."/".$ETADateArray[0];
	 }
	 if($row["dtmETD"]!="")
	 {
	 $shortETDDate=substr($row["dtmETD"] ,0,10);
	 $ETDDateArray=explode('-',$shortETDDate);
	 $formatedETDDate=$ETDDateArray[2]."/".$ETDDateArray[1]."/".$ETDDateArray[0];
	 }
	
		$ResponseXML .= "<PONo><![CDATA[" . $row["intPONo"]  . "]]></PONo>\n";
		$ResponseXML .= "<Year><![CDATA[" . $row["intYear"]  . "]]></Year>\n";
		$ResponseXML .= "<Date><![CDATA[" . $formatedDate . "]]></Date>\n";
		$ResponseXML .= "<UserID><![CDATA[" . $row["intUserID"]  . "]]></UserID>\n";
		$ResponseXML .= "<SupplierID><![CDATA[" . $row["strSupplierID"]  . "]]></SupplierID>\n";
		$ResponseXML .= "<DeliveryDate><![CDATA[" . $formatedDilDate . "]]></DeliveryDate>\n";
		$ResponseXML .= "<Currency><![CDATA[" . $row["strCurrency"]  . "]]></Currency>\n";
		$ResponseXML .= "<InvCompID><![CDATA[" . $row["intInvCompID"]  . "]]></InvCompID>\n";
		$ResponseXML .= "<DelToCompID><![CDATA[" . $row["intDelToCompID"]  . "]]></DelToCompID>\n";
		$ResponseXML .= "<POValue><![CDATA[" . $row["dblPOValue"]  . "]]></POValue>\n";
		$ResponseXML .= "<ExchangeRate><![CDATA[" . $row["dblExchangeRate"]  . "]]></ExchangeRate>\n";
		$ResponseXML .= "<PayTerm><![CDATA[" . $row["strPayTerm"]  . "]]></PayTerm>\n";
		$ResponseXML .= "<PayMode><![CDATA[" . $row["strPayMode"]  . "]]></PayMode>\n";
		$ResponseXML .= "<Instructions><![CDATA[" . $row["strInstructions"]  . "]]></Instructions>\n";
		$ResponseXML .= "<PINO><![CDATA[" . $row["strPINO"]  . "]]></PINO>\n";
		$ResponseXML .= "<ShipmentMode><![CDATA[" . $row["strShipmentMode"]  . "]]></ShipmentMode>\n";
		$ResponseXML .= "<ShipmentTerm><![CDATA[" . $row["strShipmentTerm"]  . "]]></ShipmentTerm>\n";
		$ResponseXML .= "<ETA><![CDATA[" . $formatedETADate  . "]]></ETA>\n";
		$ResponseXML .= "<ETD><![CDATA[" . $formatedETDDate  . "]]></ETD>\n";
		
		                
	 }
	 $orderType =''; //used to retrieve pending po detals
	 $result2=getPOMatDetails($poNo,$year,$orderType);
	 while($row = mysql_fetch_array($result2))
  	 {
	 $matDetailID=$row["intMatDetailID"];
	 $resultMat=getMatInfo($matDetailID);
	 while($rowMat = mysql_fetch_array($resultMat))
	 {
	 $mainCategory=$rowMat["strDescription"];
	 $itemDetail=$rowMat["strItemDescription"];
	 }
//Start - 11-03-2010 - (When po loadibg max order Qty taken from materil ratio)	 
	 	$ratioBalQty	= GetMaterialRatioBalQty($row["intStyleId"],$matDetailID,$row["strColor"],$row["strSize"],$row["intPOType"],$row["strBuyerPONO"]);
//End - 11-03-2010 - (When po loadibg max order balQty taken from materil ratio)

		$buyerPoName = '#Main Ratio#';
		if($row["strBuyerPONO"]!='#Main Ratio#')
			$buyerPoName = GetBuyerPoName($row["strBuyerPONO"]);
			
	 	$maxUSD=getMaxUnitPriceUSD($matDetailID,$row["intStyleId"]);
	    $shortDiliveryDate=substr($row["dtmItemDeliveryDate"] ,0,10);
	 	$ItemDeliveryDateArray=explode('-',$shortDiliveryDate);
	 	$formatedItemDilDate=$ItemDeliveryDateArray[2]."/".$ItemDeliveryDateArray[1]."/".$ItemDeliveryDateArray[0];
	 	$ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"]  . "]]></StyleID>\n";
		$ResponseXML .= "<StyleName><![CDATA[" . $row["strOrderNo"]  . "]]></StyleName>\n";
		$ResponseXML .= "<MatDetailID><![CDATA[" . $matDetailID  . "]]></MatDetailID>\n";
		$ResponseXML .= "<MainCategory><![CDATA[" . $mainCategory  . "]]></MainCategory>\n";
		$ResponseXML .= "<ItemDetail><![CDATA[" . $itemDetail  . "]]></ItemDetail>\n";
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<BuyerPONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONO>\n";
		$ResponseXML .= "<BuyerPoName><![CDATA[" . $buyerPoName  . "]]></BuyerPoName>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		$ResponseXML .= "<UnitPrice><![CDATA[" . $row["dblUnitPrice"]  . "]]></UnitPrice>\n";
		$ResponseXML .= "<MaxUSD><![CDATA[" . $maxUSD . "]]></MaxUSD>\n";
		$ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";
		$ResponseXML .= "<Pending><![CDATA[" . $row["dblPending"]  . "]]></Pending>\n";
		$ResponseXML .= "<AdditionalQty><![CDATA[" . $row["dblAdditionalQty"]  . "]]></AdditionalQty>\n";
		$ResponseXML .= "<DeliverToCompId><![CDATA[" . $row["intDeliverToCompId"]  . "]]></DeliverToCompId>\n";
		$ResponseXML .= "<ItemDeliveryDate><![CDATA[" . $formatedItemDilDate  . "]]></ItemDeliveryDate>\n";
		$ResponseXML .= "<intPOType><![CDATA[" . $row["intPOType"]  . "]]></intPOType>\n";
		$ResponseXML .= "<RatioBalQty><![CDATA[" . $ratioBalQty  . "]]></RatioBalQty>\n";
		//intPOType
		
		
		
		////////// added by roshan 2009-06-06//////////////////////////////////////////////////////
		$A = "  SELECT
				Sum(purchaseorderdetails.dblQty) AS Tqty
				FROM
				purchaseorderdetails
				Inner Join matitemlist ON matitemlist.intItemSerial = purchaseorderdetails.intMatDetailID
				Inner Join matsubcategory ON matsubcategory.intSubCatNo = matitemlist.intSubCatID
				Inner Join purchaseorderheader ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear
				WHERE
				purchaseorderdetails.intStyleId =  '".$row["intStyleId"]."' AND
				purchaseorderdetails.intPOType =  '0' AND
				purchaseorderheader.intStatus =  '10' AND
				purchaseorderdetails.intMatDetailID =  '$matDetailID' AND
				purchaseorderdetails.strColor =  '".$row["strColor"] ."' AND
				purchaseorderdetails.strSize =  '".$row["strSize"]."' AND
				purchaseorderdetails.strBuyerPONO = '".$row["strBuyerPONO"]."'";
				//echo $A;
				//break;
		//echo $A;
		$Aresult=$db->RunQuery($A);
		$dblPOtotal=0;
		while($Arow = mysql_fetch_array($Aresult))
  	 	{
			$dblPOtotal = $Arow["Tqty"];
		}
		$ResponseXML .= "<POTotalQty><![CDATA[" . $dblPOtotal . "]]></POTotalQty>\n";
		                
				$B = 	"SELECT
						sum(style_buyerponos.dblQty) as ItemQty
						FROM style_buyerponos
						WHERE
						style_buyerponos.intStyleId =  '".$row["intStyleId"]."' AND
						style_buyerponos.strBuyerPONO =  '".$row["BuyerPONO"]."'";
						
		$Bresult=$db->RunQuery($B);
		$ItemQty=0;
		while($Brow = mysql_fetch_array($Bresult))
  	 	{
			$ItemQty = $Brow["ItemQty"];
		}
		$ResponseXML .= "<ItemQty><![CDATA[" . $ItemQty . "]]></ItemQty>\n";
		///////////////////////////////////////////// end of line roshan /////////////////////////
	 }
	 
	 $ResponseXML .= "</PODetail>";	 
	 echo $ResponseXML;


}
else if(strcmp($RequestType,"findPO") == 0)
{
$ResponseXML = "";	 
$ResponseXML .= "<PODetail>\n";	
	
$poNo=$_GET["pono"];
$poYear = $_GET["year"];
$orderType = $_GET["orderType"];
$result=getPOHederDetails($poNo,$poYear);	
if(mysql_num_rows($result)>0)
{

	 while($row = mysql_fetch_array($result))
  	 {	 
	 $shortDate=substr($row["dtmDate"] ,0,10);
	 $DateArray=explode('-',$shortDate);
	 $formatedDate=$DateArray[2]."/".$DateArray[1]."/".$DateArray[0];
	 $shortDiliveryDate=substr($row["dtmDeliveryDate"] ,0,10);
	 $DateDilArray=explode('-',$shortDiliveryDate);
	 $formatedDilDate=$DateDilArray[2]."/".$DateDilArray[1]."/".$DateDilArray[0];
	 if($row["dtmETA"]!="")
	 {
	 $shortETADate=substr($row["dtmETA"] ,0,10);
	 $ETADateArray=explode('-',$shortETADate);
	 $formatedETADate=$ETADateArray[2]."/".$ETADateArray[1]."/".$ETADateArray[0];
	 }
	 if($row["dtmETD"]!="")
	 {
	 $shortETDDate=substr($row["dtmETD"] ,0,10);
	 $ETDDateArray=explode('-',$shortETDDate);
	 $formatedETDDate=$ETDDateArray[2]."/".$ETDDateArray[1]."/".$ETDDateArray[0];
	 }
	
		$ResponseXML .= "<PONo><![CDATA[" . $row["intPONo"]  . "]]></PONo>\n";
		$ResponseXML .= "<Year><![CDATA[" . $row["intYear"]  . "]]></Year>\n";
		$ResponseXML .= "<Date><![CDATA[" . $formatedDate . "]]></Date>\n";
		$ResponseXML .= "<UserID><![CDATA[" . $row["intUserID"]  . "]]></UserID>\n";
		$ResponseXML .= "<SupplierID><![CDATA[" . $row["strSupplierID"]  . "]]></SupplierID>\n";
		$ResponseXML .= "<DeliveryDate><![CDATA[" . $formatedDilDate . "]]></DeliveryDate>\n";
		$ResponseXML .= "<Currency><![CDATA[" . $row["strCurrency"]  . "]]></Currency>\n";
		$ResponseXML .= "<InvCompID><![CDATA[" . $row["intInvCompID"]  . "]]></InvCompID>\n";
		$ResponseXML .= "<DelToCompID><![CDATA[" . $row["intDelToCompID"]  . "]]></DelToCompID>\n";
		$ResponseXML .= "<POValue><![CDATA[" . $row["dblPOValue"]  . "]]></POValue>\n";
		$ResponseXML .= "<ExchangeRate><![CDATA[" . $row["dblExchangeRate"]  . "]]></ExchangeRate>\n";
		$ResponseXML .= "<PayTerm><![CDATA[" . $row["strPayTerm"]  . "]]></PayTerm>\n";
		$ResponseXML .= "<PayMode><![CDATA[" . $row["strPayMode"]  . "]]></PayMode>\n";
		$ResponseXML .= "<Instructions><![CDATA[" . $row["strInstructions"]  . "]]></Instructions>\n";
		$ResponseXML .= "<PINO><![CDATA[" . $row["strPINO"]  . "]]></PINO>\n";
		$ResponseXML .= "<ShipmentMode><![CDATA[" . $row["strShipmentMode"]  . "]]></ShipmentMode>\n";
		$ResponseXML .= "<ShipmentTerm><![CDATA[" . $row["strShipmentTerm"]  . "]]></ShipmentTerm>\n";
		$ResponseXML .= "<ETA><![CDATA[" . $formatedETADate  . "]]></ETA>\n";
		$ResponseXML .= "<ETD><![CDATA[" . $formatedETDDate  . "]]></ETD>\n";
		$ResponseXML .= "<sewFactory><![CDATA[" . $row["intSewCompID"]  . "]]></sewFactory>\n";
		
		$supplierCountry = getSupplierCountry($row["strSupplierID"]);
		$ResponseXML .= "<supplierCountry><![CDATA[" . $supplierCountry  . "]]></supplierCountry>\n";                
	 }
	 
	 $result2=getPOMatDetails($poNo,$poYear,$orderType);
	 
	 while($row = mysql_fetch_array($result2))
  	 {
	 $matDetailID=$row["intMatDetailID"];
	 $resultMat=getMatInfo($matDetailID);
		 while($rowMat = mysql_fetch_array($resultMat))
		 {
		 $mainCategory=$rowMat["strDescription"];
		 $itemDetail=$rowMat["strItemDescription"];
		 }
		 
//Start - 11-03-2010 - (When po loadibg max order Qty taken from materil ratio)	 
	 	$ratioBalQty	= GetMaterialRatioBalQty($row["intStyleId"],$row["strBuyerPONO"],$matDetailID,$row["strColor"],$row["strSize"],$row["intPOType"]);
//End - 11-03-2010 - (When po loadibg max order balQty taken from materil ratio)


	 	$maxUSD=getMaxUnitPriceUSD($matDetailID,$row["intStyleId"]);
	    $shortDiliveryDate=substr($row["dtmItemDeliveryDate"] ,0,10);
	 	$ItemDeliveryDateArray=explode('-',$shortDiliveryDate);
	 	$formatedItemDilDate=$ItemDeliveryDateArray[2]."/".$ItemDeliveryDateArray[1]."/".$ItemDeliveryDateArray[0];
		
		$buyerPoName = '#Main Ratio#';
		if($row["strBuyerPONO"]!='#Main Ratio#')
			$buyerPoName = GetBuyerPoName($row["strBuyerPONO"]);
			
	 	$ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"]  . "]]></StyleID>\n";
		$ResponseXML .= "<StyleName><![CDATA[" . $row["strOrderNo"]  . "]]></StyleName>\n";
		$ResponseXML .= "<MatDetailID><![CDATA[" . $matDetailID  . "]]></MatDetailID>\n";
		$ResponseXML .= "<MainCategory><![CDATA[" . $mainCategory  . "]]></MainCategory>\n";
		$ResponseXML .= "<ItemDetail><![CDATA[" . $itemDetail  . "]]></ItemDetail>\n";
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<BuyerPONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONO>\n";
		$ResponseXML .= "<BuyerPoName><![CDATA[" . $buyerPoName . "]]></BuyerPoName>\n";
		$ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		$ResponseXML .= "<UnitPrice><![CDATA[" . round($row["dblUnitPrice"],5)  . "]]></UnitPrice>\n";
		$ResponseXML .= "<MaxUSD><![CDATA[" . $maxUSD . "]]></MaxUSD>\n";
		$ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";
		$ResponseXML .= "<Pending><![CDATA[" . $row["dblPending"]  . "]]></Pending>\n";
		$ResponseXML .= "<AdditionalQty><![CDATA[" . $row["dblAdditionalQty"]  . "]]></AdditionalQty>\n";
		$ResponseXML .= "<DeliverToCompId><![CDATA[" . $row["intDeliverToCompId"]  . "]]></DeliverToCompId>\n";
		$ResponseXML .= "<ItemDeliveryDate><![CDATA[" . $formatedItemDilDate  . "]]></ItemDeliveryDate>\n";
		$ResponseXML .= "<intPOType><![CDATA[" . $row["intPOType"]  . "]]></intPOType>\n";
		$ResponseXML .= "<RatioBalQty><![CDATA[" . $ratioBalQty  . "]]></RatioBalQty>\n";
		
		
		////////// added by roshan 2009-06-06//////////////////////////////////////////////////////
		$A = "  SELECT
				Sum(purchaseorderdetails.dblAdditionalQty) AS Tqty
				FROM
				purchaseorderdetails
				Inner Join matitemlist ON matitemlist.intItemSerial = purchaseorderdetails.intMatDetailID
				Inner Join matsubcategory ON matsubcategory.intSubCatNo = matitemlist.intSubCatID
				Inner Join purchaseorderheader ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear
				WHERE
				purchaseorderdetails.intStyleId =  '".$row["intStyleId"]."' AND
				purchaseorderdetails.intPOType =  '0' AND
				purchaseorderheader.intStatus =  '10' AND
				purchaseorderdetails.intMatDetailID =  '$matDetailID' AND
				purchaseorderdetails.strColor =  '".$row["strColor"] ."' AND
				purchaseorderdetails.strSize =  '".$row["strSize"]."' AND
				purchaseorderdetails.strBuyerPONO = '".$row["strBuyerPONO"]."'";
				//echo $A;
				//break;
		$Aresult=$db->RunQuery($A);
		$dblPOtotal=0;
		while($Arow = mysql_fetch_array($Aresult))
  	 	{
			$dblPOtotal = $Arow["Tqty"];
		}
		$ResponseXML .= "<POTotalQty><![CDATA[" . $dblPOtotal . "]]></POTotalQty>\n";
		 /*               
				$B = 	"SELECT
						sum(style_buyerponos.dblQty) as ItemQty
						FROM style_buyerponos
						WHERE
						style_buyerponos.intStyleId =  '".$row["intStyleId"]."' AND
						style_buyerponos.strBuyerPONO =  '".$row["BuyerPONO"]."'";
						
		$Bresult=$db->RunQuery($B);
		
		$ItemQty=0;
		while($Brow = mysql_fetch_array($Bresult))
  	 	{
			$ItemQty = $Brow["ItemQty"];
		}
		*/
		$ItemQty=501;
		if($canOrderAdditional)
		{
		
		$buyerPO = $row["strBuyerPONO"];
		$styleID = $row["intStyleId"];
		$value = $matDetailID;
		$B = "";
		if ($buyerPO == "#Main Ratio#")
		{            
				$B = 	"SELECT
						(orders.intQty) AS ItemQty
						FROM
						orderdetails
						INNER JOIN orders ON orders.strOrderNo = orderdetails.strOrderNo AND orders.intStyleId = orderdetails.intStyleId INNER JOIN 
						matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial INNER JOIN matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo 
						WHERE
						orderdetails.intStyleId =  '$styleID' AND
						orderdetails.intMatDetailID =  '$value' AND matsubcategory.intAdditionalAllowed = '1'";
		}
		else
		{
			$B = "SELECT DISTINCT dblQty FROM style_buyerponos 
INNER JOIN orderdetails ON style_buyerponos.intStyleId = orderdetails.intStyleId INNER JOIN 
						matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial INNER JOIN matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo 
WHERE style_buyerponos.intStyleId = '$styleID' AND style_buyerponos.strBuyerPONO = '$buyerPO' AND matsubcategory.intAdditionalAllowed = '1'  AND orderdetails.intMatDetailID =  '$value' ";
		}		
				
	
		$Bresult=$db->RunQuery($B);
		
		while($Brow = mysql_fetch_array($Bresult))
  	 	{
			$ItemQty = $Brow["ItemQty"];
		}
		}
		$ResponseXML .= "<ItemQty><![CDATA[" . $ItemQty . "]]></ItemQty>\n";
		///////////////////////////////////////////// end of line roshan /////////////////////////
	 }
	 }
	 $ResponseXML .= "</PODetail>";	 
	 echo $ResponseXML;


}
else if(strcmp($RequestType,"GetPO") == 0)
{
	global $db;
	$poYear = $_GET["year"];
	$sql="SELECT DISTINCT p.intPONo FROM purchaseorderheader p INNER JOIN purchaseorderdetails d  ON p.intPONo=d.intPoNo where intStatus='11' and p.intYear='$poYear' ;";

	$result=$db->RunQuery($sql);
	$ResponseXML = "";	
	$ResponseXML .= "<PONos>\n";
		while($row = mysql_fetch_array($result))
		{
		//$ResponseXML .= "<PO><![CDATA[" . $row["intPONo"]. "]]></PO>\n";
			$str .= "<option value=\"". $row["intPONo"] ."\">" . $row["intPONo"] ."</option>";
		}
		$ResponseXML .= "<PO><![CDATA[" . $str . "]]></PO>\n";
	$ResponseXML .= "</PONos>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"postate") == 0)
{
	$ResponseXML="";
	$poNo=$_GET["Pono"];
	global $db;
	$sql="SELECT intStatus FROM purchaseorderheader WHERE intPONo='".$poNo."';";
	$ResponseXML .= "<POState>\n";
	$result=$db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
		$ResponseXML .= "<State><![CDATA[" . $row["intStatus"]. "]]></State>\n";
		}
	$ResponseXML .= "</POState>";
	echo $ResponseXML;

}
else if(strcmp($RequestType,"confirm") == 0)
{
	$ResponseXML="";
	$ResponseXML .= "<Confirm>\n";
	$pono=$_GET["pono"];
	$userID=$_SESSION["UserID"];
	$poYear = $_GET["year"];//getPOYear($pono);
	global $db;
	$sql="UPDATE purchaseorderheader SET intStatus='10' , intConfirmedBy='$userID',dtmConfirmedDate=NOW()  WHERE intPONo='".$pono."' AND intYear=$poYear;";
	//echo $sql;
	$db->executeQuery($sql);

	$ResponseXML .= "<State><![CDATA[TRUE]]></State>\n";
	$ResponseXML .= "</Confirm>";
	echo $ResponseXML;

}
//PO first approval
else if(strcmp($RequestType,"confirmfirstApprove") == 0)
{
	$ResponseXML="";
	$ResponseXML .= "<Confirm>\n";
	$pono=$_GET["pono"];
	$userID=$_SESSION["UserID"];
	$poYear = $_GET["year"];//getPOYear($pono);
	global $db;
	$sql="UPDATE purchaseorderheader SET intStatus='2' , intFirstApprovedBy='$userID',dtmFirstAppDate=NOW()  WHERE intPONo='".$pono."' AND intYear=$poYear;";
	//echo $sql;
	$result = $db->RunQuery($sql);
	if($result == '1')
	{
		$ResponseXML .= "<State><![CDATA[TRUE]]></State>\n";
	}
	else
	{
		$ResponseXML .= "<State><![CDATA[FALSE]]></State>\n";
	}
	
	$ResponseXML .= "</Confirm>";
	echo $ResponseXML;

}
//po send to approval
else if(strcmp($RequestType,"confirmSendToApprove") == 0)
{
	$ResponseXML="";
	$ResponseXML .= "<Confirm>\n";
	$pono=$_GET["pono"];
	$userID=$_SESSION["UserID"];
	$poYear = $_GET["year"];//getPOYear($pono);
	global $db;
	$sql="UPDATE purchaseorderheader SET intStatus='2' , intFirstApprovedBy='$userID',dtmFirstAppDate=NOW()  WHERE intPONo='".$pono."' AND intYear=$poYear;";
	//echo $sql;
	$result = $db->RunQuery($sql);
	if($result == '1')
	{
		$ResponseXML .= "<State><![CDATA[TRUE]]></State>\n";
	}
	else
	{
		$ResponseXML .= "<State><![CDATA[FALSE]]></State>\n";
	}
	
	$ResponseXML .= "</Confirm>";
	echo $ResponseXML;

}
else if(strcmp($RequestType,"changeMatRatio") == 0)
{
	$pono=$_GET["pono"];
	$year=$_GET["year"];
	$ResponseXML="";
	$ResponseXML .= "<ConfermState>\n";

    $sql="SELECT intPoNo,intYear,intStyleId,intMatDetailID,strColor,strSize,strBuyerPONO,dblQty,intPOType FROM purchaseorderdetails where intPoNo='$pono' AND intYear='$year';";
	$resultMat=$db->RunQuery($sql);
	while($row = mysql_fetch_array($resultMat))
	{
	$styleID=$row["intStyleId"];
	$matDetailId=$row["intMatDetailID"];
	$color=$row["strColor"];
	$size=$row["strSize"];
	$buyerPOno=$row["strBuyerPONO"];
	$poqty=$row["dblQty"];
	$intType	= $row["intPOType"];
	global $db;


	$sql="SELECT dblBalQty,dblFreightBalQty FROM materialratio WHERE intStyleId='".$styleID."' AND strMatDetailID='".$matDetailId."' AND strColor='".$color."' AND strSize='".$size."' AND strBuyerPONO='".$buyerPOno."';";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
		{
		$qty0=$row["dblBalQty"];
		$qty1=$row["dblFreightBalQty"];
		}
	
	if($intType==0)	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%     NOT FOR FRAIGHT  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	{
		$balqty=$qty0-$poqty;
	
	$sql="UPDATE materialratio SET dblBalQty='".$balqty."' WHERE intStyleId='".$styleID."' AND strMatDetailID='".$matDetailId."' AND strColor='".$color."'
	 AND strSize='".$size."' AND strBuyerPONO='".$buyerPOno."';";
	$db->executeQuery($sql);

	}
	else//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%     FOR FRAIGHT  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	{
		$balqty=$qty1-$poqty;
	
	$sql="UPDATE materialratio SET dblFreightBalQty='".$balqty."' WHERE intStyleId='".$styleID."' AND strMatDetailID='".$matDetailId."' AND strColor='".$color."' AND strSize='".$size."' AND strBuyerPONO='".$buyerPOno."';";
	$db->executeQuery($sql);

	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	}
	
	$ResponseXML .= "<State><![CDATA[TRUE]]></State>\n";
	$ResponseXML .= "</ConfermState>";
	echo $ResponseXML;
	

}
else if(strcmp($RequestType,"getCancelPOData") == 0)
{
$xml = simplexml_load_file('config.xml');
$advanceID = $xml->PurchaseOrder->PaymentTermAdvanceID;
//echo $advanceID;
$pono			= "";
$fromDate		= "";
$toDate			= "";
$ResponseXML	= "";
$pono			= $_GET["pono"];
$supplierID		= $_GET["supplierID"];
$fromDate		= $_GET["from"];
$toDate			= $_GET["to"];
$type			= $_GET["type"];

$ResponseXML 	.= "<CancelPO>\n";
$result=getCancelPOdata($pono,$supplierID,$fromDate,$toDate,$advanceID);
//echo $advanceID;
while($row = mysql_fetch_array($result))
		{
			$paymentTerm	= $row["strPayTerm"];
			$ResponseXML .= "<poNo><![CDATA[" . $row["intPONo"]. "]]></poNo>\n";
			$ResponseXML .= "<poYear><![CDATA[" . $row["intYear"]. "]]></poYear>\n";
			$ResponseXML .="<GRNState><![CDATA[".isValidtoCancel($row["intPONo"],$row["intYear"])."]]></GRNState>\n";
			$ResponseXML .= "<date><![CDATA[" . $row["datePO"]. "]]></date>\n";
			$ResponseXML .= "<poValue><![CDATA[" . $row["dblPOValue"]. "]]></poValue>\n";
			if($type=="revision"){	
				if($paymentTerm==1){
					if($poRevisePTermAdvance)
						$ResponseXML .= "<PayTerm><![CDATA[1]]></PayTerm>\n";
					else
						$ResponseXML .= "<PayTerm><![CDATA[0]]></PayTerm>\n";
				}
				else
					$ResponseXML .= "<PayTerm><![CDATA[1]]></PayTerm>\n";	
			}
			elseif($type=="cancel"){
				if($paymentTerm==1){
					if($poCancelPTermAdvance)
						$ResponseXML .= "<PayTerm><![CDATA[1]]></PayTerm>\n";
					else
						$ResponseXML .= "<PayTerm><![CDATA[0]]></PayTerm>\n";
				}
				else
					$ResponseXML .= "<PayTerm><![CDATA[1]]></PayTerm>\n";			
			}
		}
		$ResponseXML .= "</CancelPO>\n";
		echo $ResponseXML;
}
else if(strcmp($RequestType,"CancelPO") == 0)
{
$pono=$_GET["pono"];
$poYear=$_GET["year"];
global $db;
global $userID;

$sql="UPDATE purchaseorderheader SET intStatus='11', dtmCanceledDate=NOW(), intCancelledUserId='$userID' WHERE intPONo=$pono AND intYear=$poYear;";
$db->executeQuery($sql);


$sql="SELECT intYear,intStyleId,intMatDetailID,strColor,strSize,strBuyerPONO,dblQty,intPOType FROM purchaseorderdetails where intPoNo=$pono AND intYear=$poYear;";
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$qty=$row["dblQty"];
$styleID=$row["intStyleId"];
$MatDetail=$row["intMatDetailID"];
$color=$row["strColor"];
$size=$row["strSize"];
$buyerPO=$row["strBuyerPONO"];
$intType	= $row["intPOType"];

if($intType==0)
{
	$sql="UPDATE materialratio SET dblBalQty=dblBalQty+$qty WHERE intStyleId='$styleID' AND strMatDetailID='$MatDetail' AND strColor='$color' AND strSize='$size' 
	AND strBuyerPONO='$buyerPO';";
}
else
{
	$sql="UPDATE materialratio SET dblFreightBalQty=dblFreightBalQty+$qty WHERE intStyleId='$styleID' AND strMatDetailID='$MatDetail' AND strColor='$color' AND strSize='$size' 
	AND strBuyerPONO='$buyerPO';";
}
$db->executeQuery($sql);

}
}
///////////////////////////////////////////////////// revise section //////////////////
else if(strcmp($RequestType,"revisePo") == 0)
{
	$pono=$_GET["pono"];
	global $db;
	global $userID;
	$poYear = $_GET["POYear"];
	$sql="UPDATE purchaseorderheader SET intStatus='1' , intRevisionNo = COALESCE(intRevisionNo,0) + 1, dtmRevisionDate = now(), intPrintStatus ='0', intRevisedBy = " . $_SESSION["UserID"] . " ,
	 dtmFirstAppDate=Null,
	 intFirstApprovedBy = Null,
	 intConfirmedBy = Null,
	dtmConfirmedDate = Null
	WHERE intPONo=$pono AND intYear=$poYear ;";
	$db->executeQuery($sql);
	//echo $sql;
	
	
	$sql="SELECT intYear,intStyleId,intMatDetailID,strColor,strSize,strBuyerPONO,dblQty,intPOType FROM purchaseorderdetails where intPoNo=$pono AND intYear=$poYear;";
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$qty=$row["dblQty"];
		$styleID=$row["intStyleId"];
		$MatDetail=$row["intMatDetailID"];
		$color=$row["strColor"];
		$size=$row["strSize"];
		$buyerPO=$row["strBuyerPONO"];
		$intType	= $row["intPOType"];
		
		if($intType==0)
		{
			$sql="UPDATE materialratio SET dblBalQty=dblBalQty+$qty WHERE intStyleId='$styleID' AND strMatDetailID='$MatDetail' AND strColor='$color' AND strSize='$size' 
			AND strBuyerPONO='$buyerPO';";
		}
		else
		{
			$sql="UPDATE materialratio SET dblFreightBalQty=dblFreightBalQty+$qty WHERE intStyleId='$styleID' AND strMatDetailID='$MatDetail' AND strColor='$color' AND strSize='$size' 
			AND strBuyerPONO='$buyerPO';";
		}
		$db->executeQuery($sql);
	
	}
}

///////////////////////////////////////////////////////////////////////////////

else if(strcmp($RequestType,"getSuppliers1") == 0)
{	
		$ResponseXML .= "<currSup>";
		$SQL="SELECT currencytypes.intCurID,currencytypes.strCurrency,suppliers.strSupplierID,suppliers.strTitle FROM suppliers Inner Join currencytypes ON currencytypes.intCurID = suppliers.strCurrency";
				
		$result = $db->RunQuery($SQL);
		$str = '';
		//$str .= "<option value=\"". "0" ."\">" . "Select One" ."</option>";
		while($row = mysql_fetch_array($result))
		{
			  $str .= "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>";
		}
		$ResponseXML .= "<suppliers1><![CDATA[" . $str  . "]]></suppliers1>\n";
		$ResponseXML .= "</currSup>";
		echo $ResponseXML;
}

else if(strcmp($RequestType,"getSuppliers") == 0)
{
$ResponseXML="";
$ResponseXML .= "<suppliers>\n";
global $db;
$sql="SELECT strTitle,strSupplierID FROM suppliers s where intStatus='1' ORDER BY s.strTitle;";
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$ResponseXML .= "<SupID><![CDATA[" . $row["strSupplierID"]. "]]></SupID>\n";
$ResponseXML .= "<Supplier><![CDATA[" . $row["strTitle"]. "]]></Supplier>\n";
}
$ResponseXML .= "</suppliers>\n";
echo $ResponseXML;
}
else if(strcmp($RequestType,"AcknowledgePO") == 0)
{
global $db;
$ResponseXML="";
$ResponseXML .= "<ACKPoheader>\n";
$pono=$_GET["pono"];
$year=$_GET["year"];
$count=$_GET["count"];
$sql="SELECT COUNT(intPONo) AS recCount FROM purchaseorderheader where intPONo=$pono AND intYear=$year;";
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$PoHeadCount=$row["recCount"];

if($PoHeadCount>0)
{
$ResponseXML .= "<Ack><![CDATA[TRUE]]></Ack>\n";
}
else
{
$ResponseXML .= "<Ack><![CDATA[FALSE]]></Ack>\n";
}

}
$sql="SELECT COUNT(intPoNo) AS ackPodeatail FROM purchaseorderdetails WHERE intPoNo=$pono AND intYear=$year;";
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$recCount=$row["ackPodeatail"];
if($recCount==$count)
{
$ResponseXML .= "<AckDetial><![CDATA[TRUE]]></AckDetial>\n";
}
else
{
$ResponseXML .= "<AckDetial><![CDATA[FALSE]]></AckDetial>\n";
}

}
$ResponseXML .= "</ACKPoheader>\n";
$_SESSION['pono']=0;
echo $ResponseXML;
}

else if(strcmp($RequestType,"getPOAccSuplly") == 0)
{
$ResponseXML	= "";
$ResponseXML   .= "<MainPONo>";
$supplierID		= $_GET["supID"];
$intCompanyId	= $_SESSION["FactoryID"];
global $db;

		$sql="SELECT DISTINCT p.intPONo FROM purchaseorderheader p LEFT JOIN purchaseorderdetails d ON d.intPoNo=p.intPONo and d.intYear=p.intYear where p.intStatus='1' and p.intCompanyID = '$intCompanyId' ";
	
	/*if($userID!='1')
		$sql .= "and p.intUserID='$userID' ";
		*/
	if($supplierID!='0')
		$sql .= "and p.strSupplierID='$supplierID' ";
		
		$sql .= "order by p.intPONo desc";	 
		//echo $sql;
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<PONo><![CDATA[" . $row["intPONo"]. "]]></PONo>\n";
	}
$ResponseXML.="</MainPONo>";
echo $ResponseXML;
}

else if(strcmp($RequestType,"getPOAccState") == 0)
{

$state=$_GET["state"];
$year=$_GET["year"];
$supplierID = $_GET["supid"];
$ResponseXML="";
$ResponseXML.="<PoNos>";
global $db;


$sql="SELECT DISTINCT p.intPONo FROM purchaseorderheader p INNER JOIN purchaseorderdetails d ON p.intPONo=d.intPoNo where p.intStatus='$state' AND p.intYear='$year'";

if ($supplierID != "0" && $supplierID != "")
	$sql="SELECT DISTINCT p.intPONo FROM purchaseorderheader p INNER JOIN purchaseorderdetails d ON p.intPONo=d.intPoNo where p.intStatus='$state' AND p.intYear='$year' AND p.strSupplierID = '$supplierID'";

//echo $sql;
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$ResponseXML .= "<PONo><![CDATA[" . $row["intPONo"]. "]]></PONo>\n";
}
$ResponseXML.="</PoNos>";
echo $ResponseXML;
}

else if(strcmp($RequestType,"checkState") == 0)
{
global $db;
$ResponseXML="";
$ResponseXML.="<FindSate>";
$pono=$_GET["pono"];
$year=$_GET["year"];
$sql="SELECT intStatus FROM purchaseorderheader where intPONo='$pono' and intYear='$year'";
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]. "]]></Status>\n";
}
$ResponseXML.="</FindSate>";
echo $ResponseXML;
}
else if(strcmp($RequestType,"MainCatMat") == 0)
{
global $db;
$ResponseXML="";
$ResponseXML.="<Material>\n";
$sql="SELECT intID,strDescription FROM matmaincategory";
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$ResponseXML .= "<Mat><![CDATA[" . $row["strDescription"]. "]]></Mat>\n";
$ResponseXML .= "<MatID><![CDATA[" . $row["intID"]. "]]></MatID>\n";
}
$ResponseXML.="</Material>";
echo $ResponseXML;
}
else if(strcmp($RequestType,"SubCatMat") == 0)
{
global $db;
$ResponseXML="";
$ResponseXML.="<SubCategory>\n";
$mainCatID=$_GET["catID"];
$sql="SELECT DISTINCT StrCatName,intSubCatNo FROM matitemlist m INNER JOIN materialratio o ON o.strMatDetailID=m.intItemSerial INNER JOIN matsubcategory s ON s.intSubCatNo=m.intSubCatID   WHERE intMainCatID='$mainCatID' ORDER BY s.StrCatName;";
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$ResponseXML .= "<SubMat><![CDATA[" . $row["StrCatName"]. "]]></SubMat>\n";
$ResponseXML .= "<SubMatID><![CDATA[" . $row["intSubCatNo"]. "]]></SubMatID>\n";
}

$ResponseXML.="</SubCategory>";
echo $ResponseXML;
}
else if(strcmp($RequestType,"ItemListMat") == 0)
{
global $db;
$mainCatID=$_GET["MaincatID"];
$subCatID=$_GET["subCat"];
$ResponseXML="";
$ResponseXML.="<ItemList>\n";
$sql="SELECT intItemSerial,strItemDescription FROM matitemlist WHERE intMainCatID='$mainCatID' AND intSubCatID='$subCatID';";
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$ResponseXML .= "<ItemDis><![CDATA[" . $row["strItemDescription"]. "]]></ItemDis>\n";
$ResponseXML .= "<ItemID><![CDATA[" . $row["intItemSerial"]. "]]></ItemID>\n";
}
$ResponseXML.="</ItemList>";
echo $ResponseXML;
}
else if(strcmp($RequestType,"styleList") == 0)
{
global $db;
$mainCatID=$_GET["matDetailID"];
$ResponseXML="";
$ResponseXML.="<styleList>\n";
$sql="SELECT intStyleId,strBuyerPONO FROM materialratio WHERE strMatDetailID='$mainCatID';";
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"]. "]]></StyleID>\n";
$ResponseXML .= "<BuyerPONO><![CDATA[" . $row["strBuyerPONO"]. "]]></BuyerPONO>\n";
}
$ResponseXML.="</styleList>";
echo $ResponseXML;
}
else if (strcmp($RequestType,"ConfirmValidation") == 0)
{
	 $ResponseXML = "";
	 $message="";
	 $messageresult = "true";
	 $poNo=$_GET["pono"];
	 $poYear=$_GET["year"];
	 $xml = simplexml_load_file('config.xml');
	 $ans = $xml->PurchaseOrder->POTotalValueValidationRequired;
	 $POTotalValueValidationRequired = false;
	 if($ans == "true")
	 $POTotalValueValidationRequired = true;
	 $ResponseXML .= "<Message>\n";
	 
	 
	 $sql = "SELECT intPoNo,intYear,intStyleId,intMatDetailID,strColor,strSize,strBuyerPONO,strRemarks,strUnit,dblUnitPrice,dblQty,dblPending,dblAdditionalQty,dblAdditionalPendingQty,intDeliverToCompId,dtmItemDeliveryDate,intPOType FROM purchaseorderdetails WHERE intPoNo = '$poNo' AND intYear = '$poYear'";

	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{ 

		$styleID = $row["intStyleId"];
		$materialID = $row["intMatDetailID"];
		$buyerPO = $row["strBuyerPONO"];
		$color = $row["strColor"];
		$size = $row["strSize"];
		$unit = $row["strUnit"];
		$POquantity = $row["dblQty"];
		$poType = $row["intPOType"];
		$unitPrice = $row["dblUnitPrice"];
		
		$orderNo = getStyleOrderNo($styleID);
		$itemName = getMatItemName($materialID);
		
		if($POTotalValueValidationRequired)
		{
			
			$sqlstmnt = "SELECT DISTINCT purchaseorderdetails.intPOType,purchaseorderheader.strCurrency, orderdetails.dblTotalValue, matitemlist.strItemDescription FROM purchaseorderdetails INNER JOIN purchaseorderheader ON purchaseorderdetails.intPoNo = purchaseorderheader.intPoNo AND purchaseorderdetails.intYear = purchaseorderheader.intYear INNER JOIN orderdetails ON purchaseorderdetails.intStyleId = orderdetails.intStyleId  AND purchaseorderdetails.intMatDetailID = orderdetails.intMatDetailID INNER JOIN matitemlist ON purchaseorderdetails.intMatDetailID  = matitemlist.intItemSerial WHERE purchaseorderdetails.intPoNo = '$poNo' AND purchaseorderdetails.intYear = '$poYear' AND purchaseorderdetails.intMatDetailID = '$materialID' AND purchaseorderdetails.intStyleId ='$styleID' ";

			/*
			$messageresult = "false";
			$message = "$sqlstmnt";
			break 1;
			*/
			
			$resultdata=$db->RunQuery($sqlstmnt);
			
			while($rowData = mysql_fetch_array($resultdata))
			{
				//echo "pass";
				
				
				$currency = trim($rowData["strCurrency"]);
				//--------------2012-08-09 get material ratio qty as  costing total qty
				//$costingTotalValue = round($rowData["dblTotalValue"],4);
				//start get recut costing value 2011-09-05
				//$costingTotalValue += getRecutCostingValue($styleID,$materialID);
				// end get recut costing value 2011-09-05
				//--------------2012-08-09 get material ratio qty as  costing total qty
				
				$costingTotalValue = getCostingTotalValue($styleID,$materialID);
				$description = $rowData["strItemDescription"];
				
				$PurchasedValue = getPurchasedUSDValue($styleID,$materialID);
				$currentPOValue = getCurrentPOValue($styleID,$materialID,$poNo,$poYear);
				/*if ($currency != "USD")
				{
					$currentPOValue = getUSDValue($currentPOValue,$currency);
				}*/
				
				//start 2010-09-14 base currency 
				//$baseCurrncy = getBaseCurrency();
				//end ---------------------------------------------
				if ($currency != trim($baseCurrncy))
				{
					$currentPOValue = getUSDValue($currentPOValue,$currency);
				}
				
				$totwilbe = round(($PurchasedValue + $currentPOValue),4);
				//echo $currentPOValue.'/'.$PurchasedValue.'/'.$totwilbe.'/'.$costingTotalValue.'/'.$currentPOValue1;	
				
				//start 2010-11-17 get currency name  --------------------------
					
					$POcurrencyCode = getCurrencyCode($currency);
					$baseCurrencyCode = getCurrencyCode($baseCurrncy);
					$PurchasedValue = round($PurchasedValue,2);
				//end 2010-11-17 -----------------------------------------------
				
				if ($costingTotalValue < $totwilbe)
				{
						$messageresult = "false";
						$message = "Sorry! You can't exceed costing total value for following specification.\nOrder No : $orderNo\nItem Name : $description \nItem Code : $materialID \nCosting Total Value : $baseCurrencyCode  $costingTotalValue \nAlready Purchased Value : $baseCurrencyCode $PurchasedValue \nCurrent PO Value : $baseCurrencyCode $currentPOValue \nTotal Will be : $baseCurrencyCode $totwilbe  ";
						break 2;
				}
					
					
			}	 
		
		}		

	
		$sqldetails = "SELECT materialratio.dblBalQty,materialratio.dblFreightBalQty,materialratio.materialRatioID, specificationdetails.strUnit, matitemlist.strItemDescription FROM materialratio INNER JOIN specificationdetails ON materialratio.intStyleId = specificationdetails.intStyleId AND materialratio.strMatDetailID = specificationdetails.strMatDetailID INNER JOIN matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial  WHERE materialratio.intStyleId = '$styleID' AND materialratio.strMatDetailID = '$materialID' AND materialratio.strColor = '$color' AND materialratio.strSize = '$size' AND materialratio.strBuyerPONO = '$buyerPO';" ;
		
		//echo $sqldetails;
		$resultDetails=$db->RunQuery($sqldetails);
		$noOfRows = mysql_num_rows($resultDetails);
		
		if ($noOfRows <= 0)
		{
			//echo $sqldetails;
			$messageresult = "false";
			$message = "Sorry! You can't proceed with confirming. \nSome selected items in your PO has been removed by style revision. May be the Style/Material ratio reset by the merchandiser. Please compare it with costing sheet and BOM.\nPlease check the item  \n Order No : $orderNo \n Item : $materialID \n Item Name : $itemName \n Color : $color \n Size : $size \n Buyer PO : $buyerPO";
			break 1;
		}
		
		while($rowDetails = mysql_fetch_array($resultDetails))
		{ 
			$possibleItemQty =  $rowDetails["dblBalQty"];
			$possibleFreightQty =  $rowDetails["dblFreightBalQty"];
			$possibleUnit = $rowDetails["strUnit"];
			$itemName =  $rowDetails["strItemDescription"];
			if ($possibleUnit != $unit )
			{
				$messageresult = "false";
				$message = "The unit type of the item '$itemName' / Code: '$materialID'  of the Order No '$orderNo' is not match with your approved unit type. \n\nApproved Unit : $possibleUnit. \nPO Unit : $unit. \n\nPlease do neccessary changes  & save them to continue.";
				break 2;
			}
			
			if ($poType == 0)
			{
				if ($possibleItemQty < $POquantity)
				{
					$messageresult = "false";
					$message = "The PO quantity of the item '$itemName' / Code: '$materialID' of the Order No '$orderNo' is exceeding the allocated BOM quantity.\n\nPO Quantity : $POquantity.\nAvailable BOM Quantity : $possibleItemQty.\n\nPlease do neccessary adjustment & save them to continue.";
					break 2;
				}
			}
			else if ($poType == 1)
			{
				if ($possibleFreightQty < $POquantity)
				{
					$messageresult = "false";
					$message = "The PO quantity of the freight item '$itemName' / Code: '$materialID' of the Order No '$orderNo' is exceeding the allocated BOM quantity.\n\nPO Quantity : $POquantity.\nAvailable BOM Quantity : $possibleItemQty.\n\nPlease do neccessary adjustment & save them to continue.";
					break 2;
				}
			}
		}		
	}
	  
	 
	
	$ResponseXML .= "<Result><![CDATA[" . $messageresult  . "]]></Result>\n";
	$ResponseXML .= "<Body><![CDATA[" . $message  . "]]></Body>\n";
                       
	
	 $ResponseXML .= "</Message>";
	 echo $ResponseXML;
	
}
else if (strcmp($RequestType,"ConfirmValidationPOStatus") == 0)
{
	 $ResponseXML = "";
	 $message="";
	global $db;
	 $poNo=$_GET["pono"];
	 $poYear=$_GET["year"];
	 
	 $sql = "select intStatus from purchaseorderheader where intPONo='$poNo' and intYear='$poYear'";
	 $result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	$status = $row["intStatus"];
	
	 $ResponseXML .= "<Message>\n";
	$ResponseXML .= "<status><![CDATA[" . $status  . "]]></status>\n";               
	
	 $ResponseXML .= "</Message>";
	 
	 echo $ResponseXML;
	 
}
else if (strcmp($RequestType,"changePOstatus") == 0)
{
	 $ResponseXML = "";
	 $message="";
	global $db;
	 $poNo=$_GET["poNo"];
	 $poYear=$_GET["poYear"];
	 
	 $sql = "update purchaseorderheader 
			set
			intStatus = '0' 
			where
			intPONo = '$poNo' and intYear = '$poYear' ";
			
	 $result=$db->RunQuery($sql);
	
	
	
	 $ResponseXML .= "<Message>\n";
	$ResponseXML .= "<status><![CDATA[" . $result  . "]]></status>\n";               
	
	 $ResponseXML .= "</Message>";
	 
	 echo $ResponseXML;
	 
}
//2011-04-07 reject send to approve po and first approve po
else if (strcmp($RequestType,"RejectSendToApprovePO") == 0)
{
	 $ResponseXML = "";
	 $message="";
	global $db;
	 $poNo=$_GET["pono"];
	 $poYear=$_GET["year"];
	 
	 $updateResultPO = updateRejectPOdetials($poNo,$poYear);
	 $sql = "select intStatus from purchaseorderheader where intPONo='$poNo' and intYear='$poYear'";
	 $result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	$status = $row["intStatus"];
	
	 $ResponseXML .= "<Message>\n";
	$ResponseXML .= "<status><![CDATA[" . $status  . "]]></status>\n";               
	
	 $ResponseXML .= "</Message>";
	 
	 echo $ResponseXML;
	 
}
//end 2011-04-07-----------------------------------------------
//get order numbers
else if (strcmp($RequestType,"getOrderNo") == 0)
{
	 $ResponseXML = "";	 
	$ResponseXML .= "<OrderID>\n";	 
	$styleName = $_GET["styleName"];
	
	 $result=getStyleID($styleName);	
	  $ComboString .= "<option value=\"". 'Select One' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
	 
		//$ResponseXML .= "<Style><![CDATA[" . $row["intStyleId"]  . "]]></Style>\n";
		$ComboString .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		                
	 }
	 	
	$ResponseXML.="<OrderNo><![CDATA[" .$ComboString. "]]></OrderNo>\n";
	 $ResponseXML .= "</OrderID>";
	 echo $ResponseXML;
	 
}
else if($RequestType=="deliveryDateValidation")
{
	$delDate = $_GET["delDate"];
	$tDate = date('Y-m-d');
	
	$ResponseXML.="<XMLDeliveyDateValidate>\n";
	
	$result = ($delDate>=$tDate ? 1:0);
	
	$ResponseXML.="<XMLResponse><![CDATA[" .$result. "]]></XMLResponse>\n";
	
	$ResponseXML.="</XMLDeliveyDateValidate>";
	echo $ResponseXML;
	
}


function isValidtoCancel($pono,$poyear)
{
global $db;
$sql="SELECT COUNT(intPoNo) as poCount FROM grnheader where intPoNo='$pono' and intYear='$poyear' and intStatus=1;";
//$sql="SELECT COUNT(intPoNo) as poCount FROM grnheader where intPoNo='$pono' and intYear='$poyear' and intStatus=9;";

$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
return $row["poCount"];

}
return 0;


}
function getCancelPOdata($pono,$supplierID,$fromDate,$toDate,$advanceID)
{
$advanceID = -50;
global $db;
$mysqlDate=explode('/', $fromDate);
$mysqlFormatDate=$mysqlDate[2]."-".$mysqlDate[1]."-".$mysqlDate[0];
$mysqlToDate=explode('/', $toDate);
$mysqlFormatToDate=$mysqlToDate[2]."-".$mysqlToDate[1]."-".$mysqlToDate[0];

$sql="SELECT intPONo, intYear, DATE(dtmDate)AS datePO,dblPOValue,strPayTerm FROM purchaseorderheader WHERE intStatus='10' AND strPayTerm <> $advanceID ";
if($pono!="")
$sql .=" AND intPONo=$pono";

if($supplierID!=0)
$sql .=" AND strSupplierID='$supplierID'";

if($fromDate!="")
$sql .=" AND dtmDate > '$mysqlFormatDate'";

if($toDate!="")
$sql .=" dtmDate < '$mysqlFormatToDate'";

$sql .=" order by  dtmDate ";
//echo $sql;

return $db->RunQuery($sql);

}
function updatePOHeaderdata($poNO,$intYear,$strSupplierID,$dtmDeliveryDate,$strCurrency,$intStatus,$intInvCompID,$intPrintStatus,$intDelToCompID,$dblPOValue,$strPayTerm,$strPayMode,$strInstructions,$strPINO,$strShipmentMode,$strShipmentTerm,$dtmETA,$dtmETD,$sewFactory)
{
$poYear = $intYear;
global $db;
global $userID;

$sql="SELECT ER.rate FROM exchangerate ER WHERE ER.currencyID='".$strCurrency."' and ER.intStatus=1;";
$resultRate=$db->RunQuery($sql);
while($row = mysql_fetch_array($resultRate))
{
$rate=$row["rate"];
}

$diliveryDateUnformat=explode('/', $dtmDeliveryDate);
$mysqlFormatDilivery=$diliveryDateUnformat[2]."-".$diliveryDateUnformat[1]."-".$diliveryDateUnformat[0];
if($dtmETA!="")
{
	$ETAUnformat=explode('/', $dtmETA);
	$mysqlFormatETA=$ETAUnformat[2]."-".$ETAUnformat[1]."-".$ETAUnformat[0];
}
if($dtmETD!="")
{
	$ETDUnformat=explode('/', $dtmETD);
	$mysqlFormatETD=$ETDUnformat[2]."-".$ETDUnformat[1]."-".$ETDUnformat[0];
}
if($dtmETA!="" && $dtmETD!="")
{
$sql="UPDATE  purchaseorderheader SET intYear='".$intYear."',dtmDate=NOW(),intUserID='".$userID."',strSupplierID='".$strSupplierID."',dtmDeliveryDate='".$mysqlFormatDilivery."',strCurrency='".$strCurrency."',intInvCompID='".$intInvCompID."',intDelToCompID = '$intDelToCompID',dblPOValue='".$dblPOValue."',dblPOBalance='".$dblPOValue."',
strPayTerm=$strPayTerm,strPayMode=$strPayMode,strInstructions='".$strInstructions."',strPINO='".$strPINO."',strShipmentMode=$strShipmentMode,strShipmentTerm=$strShipmentTerm,dtmETA='".$mysqlFormatETA."',dtmETD='".$mysqlFormatETD."',dblExchangeRate='".$rate."',intSewCompID='$sewFactory' WHERE intPONo='".$poNO."' AND intYear=$poYear;";
$db->executeQuery($sql);

}
else if($dtmETA=="" && $dtmETD!="")
{
$sql="UPDATE  purchaseorderheader SET intYear='".$intYear."',dtmDate=NOW(),intUserID='".$userID."',strSupplierID='".$strSupplierID."',dtmDeliveryDate='".$mysqlFormatDilivery."',strCurrency='".$strCurrency."',intInvCompID='".$intInvCompID."',intDelToCompID = '$intDelToCompID', dblPOValue='".$dblPOValue."',dblPOBalance='".$dblPOValue."',
strPayTerm=$strPayTerm,strPayMode=$strPayMode,strInstructions='".$strInstructions."',strPINO='".$strPINO."',strShipmentMode=$strShipmentMode,strShipmentTerm=$strShipmentTerm,dtmETD='".$mysqlFormatETD."',dblExchangeRate='".$rate."' ,intSewCompID='$sewFactory' WHERE intPONo='".$poNO."' AND intYear=$poYear;";
$db->executeQuery($sql);

}
else if($dtmETA!="" && $dtmETD=="")
{
$sql="UPDATE  purchaseorderheader SET intYear='".$intYear."',dtmDate=NOW(),intUserID='".$userID."',strSupplierID='".$strSupplierID."',dtmDeliveryDate='".$mysqlFormatDilivery."',strCurrency='".$strCurrency."',intInvCompID='".$intInvCompID."',intDelToCompID = '$intDelToCompID', dblPOValue='".$dblPOValue."',dblPOBalance='".$dblPOValue."',
strPayTerm=$strPayTerm,strPayMode=$strPayMode,strInstructions='".$strInstructions."',strPINO='".$strPINO."',strShipmentMode=$strShipmentMode,strShipmentTerm=$strShipmentTerm,dtmETA='".$mysqlFormatETA."',dblExchangeRate='".$rate."' ,intSewCompID='$sewFactory' WHERE intPONo='".$poNO."' AND intYear=$poYear;";

$db->executeQuery($sql);

}
else
{
$sql="UPDATE  purchaseorderheader SET intYear='".$intYear."',dtmDate=NOW(),intUserID='".$userID."',strSupplierID='".$strSupplierID."',dtmDeliveryDate='".$mysqlFormatDilivery."',strCurrency='".$strCurrency."',intInvCompID='".$intInvCompID."',intDelToCompID = '$intDelToCompID', dblPOValue='".$dblPOValue."',dblPOBalance='".$dblPOValue."',
strPayTerm=$strPayTerm,strPayMode=$strPayMode,strInstructions='".$strInstructions."',strPINO='".$strPINO."',strShipmentMode=$strShipmentMode,strShipmentTerm=$strShipmentTerm,dblExchangeRate='".$rate."',intSewCompID='$sewFactory'  WHERE intPONo='".$poNO."' AND intYear=$poYear;";

$db->executeQuery($sql);

}
$sql="DELETE FROM purchaseorderdetails WHERE intPoNo='$poNO' AND intYear='$intYear';";

$db->executeQuery($sql);


}

function updatePodetails($intYear,$strStyleID,$intMatDetailID,$strColor,$strSize,$strBuyerPONO,$strRemarks,$strUnit,$dblUnitPrice,$dblQty,$dblPending,$dblAdditionalQty,$intDeliverToCompId,$dtmItemDeliveryDate,$pono,$type)
{
global $db;
$mysqlDate=explode('/', $dtmItemDeliveryDate);
$mysqlFormatDate=$mysqlDate[2]."-".$mysqlDate[1]."-".$mysqlDate[0];

try{
	$sql="INSERT INTO purchaseorderdetails(intPoNo,intYear,intStyleId,intMatDetailID,strColor,strSize,strBuyerPONO,strRemarks,strUnit,dblUnitPrice,dblQty,dblPending,dblAdditionalQty,intDeliverToCompId,dtmItemDeliveryDate,intPOType,dblInvoicePrice)Values(".$pono.",'".$intYear."','".$strStyleID."','".$intMatDetailID."','".$strColor."','".$strSize."','".$strBuyerPONO."','".$strRemarks."','".$strUnit."','".$dblUnitPrice."','".$dblQty."','".($dblPending+$dblAdditionalQty)."','".$dblAdditionalQty."','".$intDeliverToCompId."','".$mysqlFormatDate."','$type','".$dblUnitPrice."');";
	
	$db->executeQuery($sql);
	return 'save';
	}
	catch(Exception $e)
	{
		return 'error';
	}

}

function ISValidPO($poNo)
{
global $db;
$sql="SELECT COUNT(intPoNo) AS poCount FROM purchaseorderheader WHERE intPoNo='".$poNo."';";
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
if($row["poCount"]>0)
{
return "True";
}
else return "False";
}
}
function getMatInfo($matDetailID)
{
global $db;
$sql="SELECT strItemDescription, t.strDescription FROM matitemlist m INNER JOIN matmaincategory t ON m.intMainCatID=t.intID where m.intItemSerial='".$matDetailID."';";
return $db->RunQuery($sql);

}
function getPOHederDetails($pono,$poYear)
{
global $db;
$sql="SELECT intPONo,intYear,dtmDate,intUserID,strSupplierID,dtmDeliveryDate,strCurrency,intInvCompID,intDelToCompID,dblPOValue,dblExchangeRate,strPayTerm,strPayMode,strInstructions,strPINO,strShipmentMode,strShipmentTerm,dtmETA,dtmETD,intSewCompID FROM purchaseorderheader where intStatus='1' AND intYear='$poYear' AND intPONo='".$pono."';";
return $db->RunQuery($sql);

}
function getPOHederDetailsCopy($pono,$year)
{
global $db;
$sql="SELECT intPONo,intYear,dtmDate,intUserID,strSupplierID,dtmDeliveryDate,strCurrency,intInvCompID,intDelToCompID,dblPOValue,dblExchangeRate,strPayTerm,strPayMode,strInstructions,strPINO,strShipmentMode,strShipmentTerm,dtmETA,dtmETD FROM purchaseorderheader where intPONo=".$pono." and intYear=$year;";
return $db->RunQuery($sql);

}
function getPOMatDetails($poNo,$year,$orderType)
{
global $db;
$sql="SELECT o.strOrderNo,p.intStyleId,intMatDetailID,strColor,strSize,strBuyerPONO,strRemarks,p.strUnit,p.dblUnitPrice,dblQty,dblPending, dblAdditionalQty,intDeliverToCompId,dtmItemDeliveryDate,intPOType FROM purchaseorderdetails p inner join orders o on o.intStyleId=p.intStyleId
inner join matitemlist mil on mil.intItemSerial = p.intMatDetailID
 where intPONo=".$poNo." and intYear='$year'";
 if($orderType == 0)
 {
 	$sql .= " order by o.strOrderNo,mil.strItemDescription";
 }
 else if($orderType == 1)
 {
 	$sql .= " order by mil.strItemDescription";
 }
 else if($orderType == 2)
 {
 	$sql .= " order by o.strOrderNo";
 }

return $db->RunQuery($sql);

}

function getPOMat(/*$MatItem,*/$styleID/*,$buyerPO,$poState,$deliveryDate,$catID*/)
{
global $db;
$poState=0;
//$matID=(string)$MatItem;
	/*if($poState!=0)
	{
		$sql="SELECT  DISTINCT orders.strStyle,r.intStyleId,r.strBuyerPONO,r.strColor,r.strSize,r.dblBalQty,m.strItemDescription,c.strDescription,s.strUnit,s.dblUnitPrice,s.dblfreight ,r.dblFreightBalQty,r.dblQty,r.dblRecutQty FROM materialratio r INNER JOIN matitemlist m ON m.intItemSerial=r.strMatDetailID INNER JOIN matmaincategory c ON c.intID=m.intMainCatID INNER JOIN specificationdetails s ON s.strMatDetailID=r.strMatDetailID INNER JOIN orders on s.intStyleId=orders.intStyleId where  r.strMatDetailID='$matID' AND r.intStyleId='$styleID' AND s.intStyleId='$styleID' AND (r.dblBalQty>=0 OR s.dblfreight>0  );";
	}
	else
	{
		if ($catID == '4')
		{
			$sql="SELECT  DISTINCT orders.strStyle,r.intStyleId,r.strBuyerPONO,r.strColor,r.strSize,r.dblBalQty,m.strItemDescription,c.strDescription,s.strUnit,s.dblUnitPrice,s.dblfreight,r.dblFreightBalQty,r.dblQty,r.dblRecutQty FROM materialratio r INNER JOIN matitemlist m ON m.intItemSerial=r.strMatDetailID INNER JOIN matmaincategory c ON c.intID=m.intMainCatID INNER JOIN specificationdetails s ON s.strMatDetailID=r.strMatDetailID INNER JOIN orders on s.intStyleId=orders.intStyleId where  r.strMatDetailID='$matID' AND r.intStyleId='$styleID' AND s.intStyleId='$styleID' AND r.strBuyerPONO='$buyerPO' AND (r.dblBalQty>=0 OR s.dblfreight>0  ) ;";
		}
		else
		{
			$sql="SELECT  DISTINCT orders.strStyle,r.intStyleId,r.strBuyerPONO,r.strColor,r.strSize,r.dblBalQty,m.strItemDescription,c.strDescription,s.strUnit,s.dblUnitPrice,s.dblfreight,r.dblFreightBalQty,r.dblQty,r.dblRecutQty FROM materialratio r INNER JOIN matitemlist m ON m.intItemSerial=r.strMatDetailID INNER JOIN matmaincategory c ON c.intID=m.intMainCatID INNER JOIN specificationdetails s ON s.strMatDetailID=r.strMatDetailID INNER JOIN deliveryschedule d ON d.intStyleId=r.intStyleId INNER JOIN orders on s.intStyleId=orders.intStyleId where  r.strMatDetailID='$matID' AND r.intStyleId='$styleID' AND s.intStyleId='$styleID' AND r.strBuyerPONO='$buyerPO' AND (r.dblBalQty>=0 OR s.dblfreight>0  ) AND d.dtDateofDelivery='$deliveryDate';";
		}
	}*/
	//echo $sql;
	 $sql = "SELECT  DISTINCT orders.strStyle,r.intStyleId,r.strBuyerPONO,r.strColor,r.strSize,r.dblBalQty,m.strItemDescription,c.strDescription,s.strUnit,
s.dblUnitPrice,s.dblfreight,r.dblFreightBalQty,r.dblQty,r.dblRecutQty FROM materialratio r 
INNER JOIN matitemlist m ON m.intItemSerial=r.strMatDetailID INNER JOIN matmaincategory c ON c.intID=m.intMainCatID 
INNER JOIN specificationdetails s ON s.strMatDetailID=r.strMatDetailID INNER JOIN orders on s.intStyleId=orders.intStyleId 
	INNER JOIN deliveryschedule d ON d.intStyleId=r.intStyleId 
	where r.intStyleId='".$styleID."' AND s.intStyleId='".$styleID."'";
	
	switch($poState)
	{
		case 0:
		{
			/*if($catID == '4')
			{*/
				$sql .= " AND r.dblBalQty>=0 ";
			/*}
			else
			{
				$sql .= " AND r.dblBalQty>=0 ";
			}*/
			break;
		}
		/*case 1:
		{
			$sql .= " AND s.dblfreight>0  ";
			break;
		}*/
		case 2:
		{
			/*if($catID == '4')
			{*/
				$sql .= " AND (r.dblBalQty>=0) ";
			/*}
			else
			{
				$sql .= " AND (r.dblBalQty>=0)";
			}*/
			break;
		}
	}
	//echo $sql;
	return $db->RunQuery($sql);
}

// start 2010-11-03 get po items color and size wise
function getPOMaterialDetails($MatItem,$styleID,$buyerPO,$postate,$deliveryDate,$catID,$color,$size)
{
global $db;

$matID=(string)$MatItem;
//echo $matID; 
	//if($postate!=0)
	//{
	 #================================================================
	 // Comment On - 2015-10-29
	 // Comment By - Nalin Jayakody
	 // Comment For - Add buyer po number to the 'WHERE' clause
	 #=================================================================
	  //  $sql="SELECT  DISTINCT orders.strOrderNo,orders.strStyle,r.intStyleId,r.strBuyerPONO,r.strColor,r.strSize,r.dblBalQty,m.strItemDescription,c.strDescription,s.strUnit,s.dblUnitPrice,s.dblfreight ,r.dblFreightBalQty,r.dblQty FROM materialratio r INNER JOIN matitemlist m ON m.intItemSerial=r.strMatDetailID INNER JOIN matmaincategory c ON c.intID=m.intMainCatID INNER JOIN specificationdetails s ON s.strMatDetailID=r.strMatDetailID INNER JOIN orders on s.intStyleId=orders.intStyleId where  r.strMatDetailID='$matID' AND r.intStyleId='$styleID' AND s.intStyleId='$styleID' AND (r.dblBalQty>=0 OR s.dblfreight>0  ) and r.strColor ='$color' and r.strSize='$size';";
	 #=================================================================
	  
	  $sql="SELECT  DISTINCT orders.strOrderNo,orders.strStyle,r.intStyleId,r.strBuyerPONO,r.strColor,r.strSize,r.dblBalQty,m.strItemDescription,c.strDescription,s.strUnit,s.dblUnitPrice,s.dblfreight ,r.dblFreightBalQty,r.dblQty FROM materialratio r INNER JOIN matitemlist m ON m.intItemSerial=r.strMatDetailID INNER JOIN matmaincategory c ON c.intID=m.intMainCatID INNER JOIN specificationdetails s ON s.strMatDetailID=r.strMatDetailID INNER JOIN orders on s.intStyleId=orders.intStyleId where  r.strMatDetailID='$matID' AND r.intStyleId='$styleID' AND s.intStyleId='$styleID' AND (r.dblBalQty>=0 OR s.dblfreight>0  ) and r.strColor ='$color' and r.strSize='$size' and r.strBuyerPONO = '$buyerPO';";
	/*}
	else
	{
		if ($catID == '4')
		{
			$sql="SELECT  DISTINCT orders.strOrderNo,orders.strStyle,r.intStyleId,r.strBuyerPONO,r.strColor,r.strSize,r.dblBalQty,m.strItemDescription,c.strDescription,s.strUnit,s.dblUnitPrice,s.dblfreight,r.dblFreightBalQty,r.dblQty FROM materialratio r INNER JOIN matitemlist m ON m.intItemSerial=r.strMatDetailID INNER JOIN matmaincategory c ON c.intID=m.intMainCatID INNER JOIN specificationdetails s ON s.strMatDetailID=r.strMatDetailID INNER JOIN orders on s.intStyleId=orders.intStyleId where  r.strMatDetailID='$matID' AND r.intStyleId='$styleID' AND s.intStyleId='$styleID' AND r.strBuyerPONO='$buyerPO' AND (r.dblBalQty>0 OR s.dblfreight>0  )and r.strColor ='$color' and r.strSize='$size' ;";
		}
		else
		{
			$sql="SELECT  DISTINCT orders.strOrderNo,orders.strStyle,r.intStyleId,r.strBuyerPONO,r.strColor,r.strSize,r.dblBalQty,m.strItemDescription,c.strDescription,s.strUnit,s.dblUnitPrice,s.dblfreight,r.dblFreightBalQty,r.dblQty FROM materialratio r INNER JOIN matitemlist m ON m.intItemSerial=r.strMatDetailID INNER JOIN matmaincategory c ON c.intID=m.intMainCatID INNER JOIN specificationdetails s ON s.strMatDetailID=r.strMatDetailID INNER JOIN deliveryschedule d ON d.intStyleId=r.intStyleId INNER JOIN orders on s.intStyleId=orders.intStyleId where  r.strMatDetailID='$matID' AND r.intStyleId='$styleID' AND s.intStyleId='$styleID' AND r.strBuyerPONO='$buyerPO' AND (r.dblBalQty>0 OR s.dblfreight>0  ) AND d.dtDateofDelivery='$deliveryDate' and r.strColor ='$color' and r.strSize='$size';";
		}
	}*/
	
	//echo $sql;
	return $db->RunQuery($sql);
}
//end 2010-11-03

function getStyleID($styleName)
{
global $db;
$sql="SELECT DISTINCT materialratio.intStyleId,orders.strStyle,orders.strOrderNo FROM materialratio inner join orders on  materialratio.intStyleId = orders.intStyleId  where ( dblBalQty>0 or dblFreightBalQty>0 ) AND orders.intStatus = 11  ";

	if($styleName != '')
		$sql .= " and orders.intStyleId = '$styleName' ";
		
		//echo $sql;
return $db->RunQuery($sql);
}

function getStyleNameList()
{
global $db;
$sql="SELECT DISTINCT orders.strStyle FROM materialratio inner join orders on  materialratio.intStyleId = orders.intStyleId  where ( dblBalQty>0 or dblFreightBalQty>0 ) AND orders.intStatus = 11 order by orders.strStyle; ";

return $db->RunQuery($sql);
}



function getSCList($styleName)
{
global $db;
$sql="SELECT DISTINCT specification.intSRNO, specification.intStyleId  FROM materialratio INNER JOIN orders ON  materialratio.intStyleId = orders.intStyleId INNER JOIN specification ON materialratio.intStyleId = specification.intStyleId WHERE ( dblBalQty>0 OR dblFreightBalQty>0 ) AND orders.intStatus = 11 ";

	if($styleName != '')
		$sql .= " and orders.intStyleId = '$styleName'";
		
	$sql .= " order by specification.intSRNO desc ";
	//echo $sql; 

return $db->RunQuery($sql);
}
function getStyleList($cboScNo)
{
global $db;
$sql="SELECT DISTINCT specification.intSRNO, specification.intStyleId,orders.strStyle  FROM materialratio INNER JOIN orders ON  materialratio.intStyleId = orders.intStyleId INNER JOIN specification ON materialratio.intStyleId = specification.intStyleId WHERE ( dblBalQty>0 OR dblFreightBalQty>0 ) AND orders.intStatus = 11 ";

	if($cboScNo != '')
		$sql .= " and specification.intStyleId = '$cboScNo'";
		
	//$sql .= " order by specification.intSRNO desc ";
	//echo $sql; 

return $db->RunQuery($sql);
}
function getCurrList($cbocurrency)
{
global $db;
$sql="SELECT DISTINCT
suppliers.strSupplierID,
suppliers.strTitle,
currencytypes.intCurID,
currencytypes.strCurrency,
suppliers.strCurrency
FROM
currencytypes
Inner Join suppliers ON currencytypes.intCurID = suppliers.strCurrency
WHERE
suppliers.intStatus =  '1'
";

	if($cbocurrency != '')
		$sql .= " and currencytypes.intCurID = '$cbocurrency'";
		
	//$sql .= " order by specification.intSRNO desc ";
	//echo $sql; 

return $db->RunQuery($sql);
}
function getBuyerPO($styleID)
{
global $db;
$sql="SELECT DISTINCT strBuyerPONO FROM materialratio where intStyleId='".$styleID."';";
return $db->RunQuery($sql);
}

function getItemDeatils($styleID/*,$buyerPO,$diliveryDate,$srNo,$mainCat,$postate,$subCat*/)
{
global $db;

//if($postate==0)
//{
	//if ($mainCat == '4')
	//{
	$sql="SELECT DISTINCT l.strItemDescription,l.intItemSerial  FROM materialratio m
 INNER JOIN specificationdetails s ON s.intStyleId=m.intStyleId INNER JOIN matitemlist l ON l.intItemSerial=m.strMatDetailID 
WHERE m.intStyleId='".$styleID."' AND (m.dblBalQty>=0 ) order by l.strItemDescription";
	
		
	//}
	//else
	//{

	/*$sql="SELECT DISTINCT l.strItemDescription,l.intItemSerial  FROM materialratio m INNER JOIN deliveryschedule d ON m.intStyleId=d.intStyleId INNER JOIN specificationdetails s ON s.intStyleId=m.intStyleId INNER JOIN matitemlist l ON l.intItemSerial=m.strMatDetailID WHERE m.intStyleId='".$styleID."' AND (m.dblBalQty>=0) and l.intSubCatID='$subCat' order by l.strItemDescription;";*/
	//}
//}
//else
//{
/*$sql="SELECT DISTINCT l.strItemDescription,l.intItemSerial  FROM materialratio m INNER JOIN deliveryschedule d ON m.intStyleId=d.intStyleId INNER JOIN specificationdetails s ON s.intStyleId=m.intStyleId INNER JOIN matitemlist l ON l.intItemSerial=m.strMatDetailID WHERE m.intStyleId='".$styleID."' AND(m.dblBalQty>=0) order by l.strItemDescription;";*/
//}

//echo $sql;
return $db->RunQuery($sql);
}

function getItemDeatilsSupWise($styleID,$supID/*,$buyerPO,$diliveryDate,$srNo,$mainCat,$postate,$supID,$subCat*/)
{
	global $db;

//if($postate==0)
//{
	//if ($mainCat == '4')
	//{
	 $sql="SELECT   DISTINCT l.strItemDescription,l.intItemSerial   FROM materialratio m  INNER  JOIN specification s  ON s.intStyleId=m.intStyleId  INNER JOIN matitemlist l  ON l.intItemSerial=m.strMatDetailID
	inner join supplierwitem sw on sw.intItemSerial =  m.strMatDetailID and l.intItemSerial = sw.intItemSerial
	 WHERE m.intStyleId='".$styleID."' AND sw.intSupplierID='".$supID."' AND (m.dblBalQty>=0) order by l.strItemDescription";
	//}
	//else
	//{

	/*$sql="SELECT DISTINCT l.strItemDescription,l.intItemSerial  FROM materialratio m INNER JOIN deliveryschedule d ON m.intStyleId=d.intStyleId 
INNER JOIN specification s ON s.intStyleId=m.intStyleId INNER JOIN matitemlist l ON l.intItemSerial=m.strMatDetailID
	inner join supplierwitem sw on sw.intItemSerial =  m.strMatDetailID and l.intItemSerial = sw.intItemSerial
	 WHERE m.intStyleId='".$styleID."' AND sw.intSupplierID='".$supID."' 
AND (m.dblBalQty>=0) order by l.strItemDescription";*/
	//}
//}
//else
//{
/*$sql="SELECT DISTINCT l.strItemDescription,l.intItemSerial  FROM materialratio m INNER JOIN deliveryschedule d ON m.intStyleId=d.intStyleId
 INNER JOIN specification s ON s.intStyleId=m.intStyleId INNER JOIN matitemlist l ON l.intItemSerial=m.strMatDetailID 
inner join supplierwitem sw on sw.intItemSerial =  m.strMatDetailID and l.intItemSerial = sw.intItemSerial
WHERE m.intStyleId='".$styleID."' AND sw.intSupplierID='".$supID."' AND (m.dblBalQty>=0 ) order by l.strItemDescription;";*/
//}

//echo $sql;
return $db->RunQuery($sql);
}

function getdiliveryDate($styleID)
{
global $db;
$sql="SELECT DISTINCT DATE_FORMAT(dtDateofDelivery, '%Y %M %D') AS deliveryDate,dtDateofDelivery AS dateFormat FROM deliveryschedule d where intStyleId='".$styleID."' AND dtDateofDelivery> NOW();";
return $db->RunQuery($sql);
}

function getSRNumber($styleID)
{
global $db;
$sql="SELECT intSRNO FROM specification s where intStyleId='".$styleID."' AND intOrdComplete='0';";
return $db->RunQuery($sql);
}

function getMainCat($styleID)
{
global $db;
$sql="SELECT DISTINCT g.intID,g.strDescription FROM materialratio m INNER JOIN matitemlist l ON m.strMatDetailID=l.intItemSerial INNER JOIN matmaincategory g ON l.intMainCatID=g.intID where ( dblBalQty>0 or dblFreightBalQty>0 )";
if($styleID != 'Select One')
		$sql .= " and m.intStyleId = '$styleID'";
		 
		$sql .= "ORDER BY g.intID";
		//echo $sql;
return $db->RunQuery($sql);
}

function savePOHeader($intYear,$strSupplierID,$dtmDeliveryDate,$strCurrency,$intStatus,$intInvCompID,$intPrintStatus,$intDelToCompID,$dblPOValue,$strPayTerm,$strPayMode,$strInstructions,$strPINO,$strShipmentMode,$strShipmentTerm,$dtmETA,$dtmETD,$companyID,$sewFactory)
{
global $db;
global $userID;

//start 2010-09-01 get maxPO no from syscontrol table ------------------------------------------------------
/*$keyVal="MaxID".$companyID;

$sql="SELECT strValue FROM settings  where strKey='$companyID';";
$resultRate=$db->RunQuery($sql);
while($row = mysql_fetch_array($resultRate))
{
$rangeArr=explode("-",$row["strValue"]);

}
$sql="SELECT strValue FROM settings where strKey='$keyVal';";
$result=$db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
$maxID=$row["strValue"];

}

$intMax=0;
$intMax=(int)$maxID;

if($intMax<=(int)$rangeArr[1] && $intMax>=(int)$rangeArr[0])
{
$intPONo=$intMax+1;

$sql="UPDATE settings SET strValue='$intPONo' WHERE strKey='$keyVal';";

$db->executeQuery($sql);

}
else
{
return -1000;
}*/



	$sqlM = "SELECT dblSPoNo FROM syscontrol WHERE intCompanyID='$companyID'";
	$result=$db->RunQuery($sqlM);
	
	while($row = mysql_fetch_array($result))
	{
	$maxID=$row["dblSPoNo"];
	
	}
	
	if($maxID == '' || is_null($maxID))
	{
		return -1000;
	}
	$intMax=0;
	$intMax=(int)$maxID;
	
	$intPONo=$intMax+1;
	
	$sql1="UPDATE syscontrol SET dblSPoNo='$intPONo' WHERE intCompanyID='$companyID'";

	$db->executeQuery($sql1);
//-------------------------------------end --------------------------------------------------------------------------
//$sql="SELECT ER.rate FROM currencytypes CT inner join exchangerate ER on ER.currencyID=CT.intCurID WHERE CT.strCurrency='".$strCurrency."' and ER.intStatus=1;";//16-11-2010

$sql="SELECT ER.rate FROM exchangerate ER WHERE ER.currencyID='".$strCurrency."' and ER.intStatus=1;";
$resultRate=$db->RunQuery($sql);
while($row = mysql_fetch_array($resultRate))
{
$rate=$row["rate"];
}
$diliveryDateUnformat=explode('/', $dtmDeliveryDate);
$mysqlFormatDilivery=$diliveryDateUnformat[2]."-".$diliveryDateUnformat[1]."-".$diliveryDateUnformat[0];
if($dtmETA!="")
{
$ETAUnformat=explode('/', $dtmETA);
$mysqlFormatETA="'".$ETAUnformat[2]."-".$ETAUnformat[1]."-".$ETAUnformat[0]."'";
}
else
{
$mysqlFormatETA="Null";
}
if($dtmETD!="")
{
$ETDUnformat=explode('/', $dtmETD);
$mysqlFormatETD="'".$ETDUnformat[2]."-".$ETDUnformat[1]."-".$ETDUnformat[0]."'";
}
else
{
$mysqlFormatETD="Null";
}


$sql="INSERT INTO purchaseorderheader(intPONo,intYear,dtmDate,intUserID,strSupplierID,dtmDeliveryDate,strCurrency,intStatus,intInvCompID,intPrintStatus,intDelToCompID,dblPOValue,dblPOBalance,dblExchangeRate,strPayTerm,strPayMode,strInstructions,strPINO,strShipmentMode,strShipmentTerm,dtmETA,dtmETD,intCompanyID,dtmCreateDate,intSewCompID)VALUES ('$intPONo','$intYear',NOW(),$userID,'$strSupplierID','$mysqlFormatDilivery','$strCurrency',$intStatus,$intInvCompID,$intPrintStatus,$intDelToCompID,$dblPOValue,$dblPOValue,$rate,$strPayTerm,$strPayMode,'$strInstructions','$strPINO',$strShipmentMode,$strShipmentTerm,$mysqlFormatETA,$mysqlFormatETD,'$companyID',now(),'$sewFactory');";

$db->executeQuery($sql);
//echo $sql;
return $intPONo;

}

function savePODetails($pono,$intYear,$strStyleID,$intMatDetailID,$strColor,$strSize,$strBuyerPONO,$strRemarks,$strUnit,$dblUnitPrice,$dblQty,$dblPending,$dblAdditionalQty,$intDeliverToCompId,$dtmItemDeliveryDate,$type)
{
$mysqlDate=explode('/', $dtmItemDeliveryDate);
$mysqlFormatDate=$mysqlDate[2]."-".$mysqlDate[1]."-".$mysqlDate[0];

global $db;
try{
	$sql="INSERT INTO purchaseorderdetails(intPoNo,intYear,intStyleId,intMatDetailID,strColor,strSize,strBuyerPONO,strRemarks,strUnit,dblUnitPrice,dblQty,dblPending,dblAdditionalQty,intDeliverToCompId,dtmItemDeliveryDate,intPOType,dblInvoicePrice)Values ($pono,'$intYear','$strStyleID','$intMatDetailID','$strColor','$strSize','$strBuyerPONO','$strRemarks','$strUnit','$dblUnitPrice','$dblQty','".($dblPending+$dblAdditionalQty)."','$dblAdditionalQty','$intDeliverToCompId','$mysqlFormatDate','$type','$dblUnitPrice');";
	
	
	$result = $db->RunQuery($sql);
	if($result == '1')
		$a = 'save';
	else
		$a = 'fail';
	return $a;
}
catch(Exception $e)
{
	return 'error';
}
}



function getPOYear($PONumber)
{
	global $db;
	$sql="select intYear from purchaseorderheader where intPONo = $PONumber;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["intYear"];
	}

}

function getMaxUnitPriceUSD($matDetailID,$styleID)
{
global $db;
$sql="SELECT dblUnitPrice FROM specificationdetails where intStyleId='$styleID' AND strMatDetailID='$matDetailID';";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
return $row["dblUnitPrice"];
}

}

function getPurchasedUSDValue($reqStyleID,$materialID)
{
	global $db;
	$purchasedPrice = 0;
	
	$sqlcurrency = "SELECT distinct purchaseorderdetails.intPoNo,purchaseorderheader.strCurrency, purchaseorderdetails.intYear
	 FROM purchaseorderdetails INNER JOIN purchaseorderheader ON purchaseorderdetails.intPONo = purchaseorderheader.intPONo  WHERE purchaseorderdetails.intStyleId = '$reqStyleID'  AND purchaseorderdetails.intMatDetailID = '$materialID'  AND purchaseorderdetails.intPOType=0 and purchaseorderheader.intStatus = 10;";

	$resultcur = $db->RunQuery($sqlcurrency);	
	
	while($rowcur = mysql_fetch_array($resultcur))
	{
		$sqlpurch = "select COALESCE(Sum(purchaseorderdetails.dblQty),0) as purchasedQty, COALESCE(sum(purchaseorderdetails.dblUnitPrice * purchaseorderdetails.dblQty),0) as avgValue  from purchaseorderdetails inner join purchaseorderheader on purchaseorderheader.intPONo = purchaseorderdetails.intPONo AND purchaseorderheader.intYear = purchaseorderdetails.intYear  where intStyleId = '$reqStyleID' AND purchaseorderdetails.intMatDetailID = '$materialID' AND purchaseorderdetails.intPOType=0 and purchaseorderheader.intStatus = 10 AND purchaseorderdetails.intPONo = " . $rowcur["intPoNo"] . " and purchaseorderdetails.intYear = ". $rowcur["intYear"].";";
	
	
		$resultpurch = $db->RunQuery($sqlpurch);
		
		while($rowpurch = mysql_fetch_array($resultpurch))
		{
			$dollarRate = 1;
			$baseCurrncy = getBaseCurrency();
			if ( trim($rowcur["strCurrency"]) != trim($baseCurrncy))
			{
				$sql = "SELECT ER.rate FROM exchangerate ER WHERE ER.currencyID = '". $rowcur["strCurrency"] . "' and ER.intStatus=1;";
				$rst = $db->RunQuery($sql);
				while($rw = mysql_fetch_array($rst))
				{
					$dollarRate = $rw["rate"];
					break;
				}
			}

			$purchasedPrice += $rowpurch["avgValue"] / $dollarRate;
		}
	}
		
	return $purchasedPrice;
}

function getUSDValue($value,$currency)
{
	global $db;
	$dollarRate = 1;
	$sql = "SELECT ER.rate FROM exchangerate ER WHERE ER.currencyID = '". $currency . "' and ER.intStatus=1;";
	$rst = $db->RunQuery($sql);
	while($rw = mysql_fetch_array($rst))
	{
		$dollarRate = $rw["rate"];
		break;
	}
	return round(($value / $dollarRate),4);
}

function getCurrentPOValue($styleID,$matDetailID,$PONo,$POYear)
{
	global $db;
	$sql  = "SELECT SUM(dblUnitPrice * dblQty ) as PValue FROM purchaseorderdetails WHERE purchaseorderdetails.intPoNo = '$PONo' AND purchaseorderdetails.intYear = '$POYear' AND purchaseorderdetails.intMatDetailID = '$matDetailID' AND purchaseorderdetails.intStyleId ='$styleID'";
	$purchasedValue = 0;
	$rst = $db->RunQuery($sql);
	while($rw = mysql_fetch_array($rst))
	{
		$purchasedValue = $rw["PValue"];
		break;
	}

	return $purchasedValue;
}
//Start 11-03-2010
function GetMaterialRatioBalQty($styleId,$buyerPoNo,$matDetailID,$color,$size,$poType)
{
	global $db;
	$qty	= 0;
	if($poType==0){
		$sql="select COALESCE(sum(dblBalQty),0)as balQty from materialratio 
			where intStyleId='$styleId'
			and strMatDetailID='$matDetailID'
			and strColor='$color'
			and strSize='$size'
			and strBuyerPONO = '$buyerPoNo'"; 
			//====================================================
			// Add On - 10/26/2015
			// Add By - Nalin JAyakody
			// Adding - Add buyer po number for the filtering in material ratio
			//====================================================
			
	}
	else{
			$sql="select COALESCE(sum(dblFreightBalQty),0)as balQty from materialratio 
			where intStyleId='$styleId'
			and strMatDetailID='$matDetailID'
			and strColor='$color'
			and strSize='$size'
			and strBuyerPONO = '$buyerPoNo'"; 
			//====================================================
			// Add On - 10/26/2015
			// Add By - Nalin JAyakody
			// Adding - Add buyer po number for the filtering in material ratio
			//====================================================
	}
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$qty =  $row["balQty"];
		}
		
	//start 2011-07-06 get pending allocation details
	if($poType==0)
	{
		$pendingLeftAlloQty = getPendingLrftOverAllocationQty($matDetailID,$styleId,$color,$size,$buyerPoNo,'$Style');
		$pendingBulkAlloQty = getPendingBulkAllocationQty($matDetailID,$styleId,$color,$size,$buyerPoNo,'Style');
		$pendingLiabilityAlloQty = getPendingLiabilityAllocationQty($matDetailID,$styleId,$color,$size,$buyerPoNo,'Style');
		
		$totAlloQty = $pendingLeftAlloQty + $pendingBulkAlloQty+$pendingLiabilityAlloQty;
		$qty -= $totAlloQty;
	}
	
//end 2011-07-06	
	return $qty;
}
//End 11-03-2010
function GetBuyerPoName($buyerPoNo)
{
global $db;
	$sql="select distinct strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoNo'";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];	
}

function GetBuyerPOFromStyleBuyerPO($prmStyleId){
    
    global $db;
    
    $sql = "SELECT DISTINCT
			style_buyerponos.strBuyerPONO,
			style_buyerponos.strBuyerPoName
			FROM
			style_buyerponos
			INNER JOIN deliveryschedule ON style_buyerponos.intStyleId = deliveryschedule.intStyleId AND style_buyerponos.strBuyerPONO = deliveryschedule.intBPO
			WHERE
			style_buyerponos.intStyleId = '$prmStyleId' AND
			deliveryschedule.intPlanConfirm = 1 ";
    $result=$db->RunQuery($sql);
    
    return $result;
}

//===============================================
// Add On - 10/14/2015
// Add By - Nalin Jayakody
// Descrip - Get buyer listing from delivery schedule table instead style_buyerponos
//=============================================== 

function GetBuyerListing($buyerPoNo)
{
global $db;
	$sql="select distinct intBPO from deliveryschedule where intBPO='$buyerPoNo'";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["intBPO"];	
}
//=============================================== 
//get style name

function getStyleOrderNo($styleID)
{
	global $db;
	$sql="select strOrderNo from orders where intStyleId='$styleID'";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strOrderNo"];	
}

function getCommonLeftOverAllocatedQty($itemID,$styleID,$color,$size,$buyerPO)
{
	global $db;
				
	$sql = "select round(sum(dblQty),2) as dblQty from stocktransactions_leftover where intMatDetailId='$itemID' and strColor='$color' and strSize='$size'";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];	
}

function getBulkQty($itemID,$StyleID,$color,$size,$buyerPO)
{
	global $db;
	   
	$sql = "select round(sum(dblQty),2) as dblQty from stocktransactions_bulk
where intMatDetailId='$itemID' and strColor='$color' and strSize='$size'";

	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];
}
function getCommonLiabilityAllocatedQty($itemID,$styleID,$color,$size,$buyerPO)
{
	global $db;
				
	$sql = "select round(sum(dblQty),2) as dblQty from stocktransactions_liability where intMatDetailId='$itemID' and strColor='$color' and strSize='$size'";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];	
}
function getPendingBulkAllocationQty($itemID,$StyleID,$color,$size,$buyerPO,$type)
{
global $db;
	$sql = " select COALESCE(sum(dblQty),0) as dblQty  
		from commonstock_bulkdetails BD inner join commonstock_bulkheader BH on
		BD.intTransferNo = BH.intTransferNo and 
		BD.intTransferYear = BH.intTransferYear 
		where intMatDetailId='$itemID'  and strColor='$color' and strSize='$size' and BH.intStatus=0 ";            
	
	if($type == 'Style')
		$sql .= " and BH.intToStyleId='$StyleID' and BH.strToBuyerPoNo='$buyerPO'";
	//echo $sql;		   
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];
}

function getPendingLrftOverAllocationQty($itemID,$StyleID,$color,$size,$buyerPO,$type)
{
	global $db;
	$sql = "select COALESCE(sum(LD.dblQty),0) as dblQty from commonstock_leftoverdetails LD inner join  commonstock_leftoverheader LH on
LH.intTransferNo = LD.intTransferNo and LD.intTransferYear = LH.intTransferYear 
where LH.intStatus=0  and LD.intMatDetailId='$itemID' and LD.strColor='$color' and LD.strSize='$size' ";
	if($type == 'Style')
		$sql .= " and LH.intToStyleId='$StyleID' and LH.strToBuyerPoNo='$buyerPO'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];
}
function getPendingLiabilityAllocationQty($itemID,$StyleID,$color,$size,$buyerPO,$type)
{
	global $db;
	$sql = "select COALESCE(sum(LD.dblQty),0) as dblQty from commonstock_liabilitydetails LD inner join  commonstock_liabilityheader LH on
LH.intTransferNo = LD.intTransferNo and LD.intTransferYear = LH.intTransferYear 
where LH.intStatus=0  and LD.intMatDetailId='$itemID' and LD.strColor='$color' and LD.strSize='$size' ";
	if($type == 'Style')
		$sql .= " and LH.intToStyleId='$StyleID' and LH.strToBuyerPoNo='$buyerPO'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];
}
function getBaseCurrency()
{
	global $db;
	$cid = getBaseCurrencyID();
	//echo $cid;
	//$sql="select strCurrency from currencytypes where intCurID='$cid'";
	
	//$result=$db->RunQuery($sql);
	//$row=mysql_fetch_array($result);
	return $cid;	
}

function getBaseCurrencyID()
{
	global $db;
	$sql="select intBaseCurrency from systemconfiguration";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	
	return $row["intBaseCurrency"];
}

function getCurrencyCode($cid)
{
	global $db;
	
	$sql="select strCurrency from currencytypes where intCurID='$cid'";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	
	return $row["strCurrency"];
}

function getSubCat($StyleID,$mainCatId)
{
	global $db;

	 $sql = "SELECT DISTINCT g.intSubCatNo,g.StrCatName 
			FROM materialratio m INNER JOIN matitemlist l ON m.strMatDetailID=l.intItemSerial 
			INNER JOIN matsubcategory g ON l.intSubCatID=g.intSubCatNo 
			where ( dblBalQty>0 or dblFreightBalQty>0 )";
			
	if($StyleID != 'Select One')
		$sql .= " and m.intStyleId='$StyleID' ";
			
	if($mainCatId != '')
		$sql .= " and l.intMainCatID='$mainCatId' ";
		
		$sql .= " ORDER BY g.intSubCatNo ";
	//echo $sql;
	return 	$db->RunQuery($sql);
	
}

function updateRejectPOdetials($poNo,$poYear)
{
	global $db;
	
	$sql = "update purchaseorderheader 
	set
	intStatus = 1,
	dtmConfirmedDate = Null , 
	intConfirmedBy = Null,
	intFirstApprovedBy = Null , 
	dtmFirstAppDate = Null
	where
	intPONo = '$poNo' and intYear = '$poYear' ";
	
	$db->RunQuery($sql);
	
}
/*function getPOItemPendingQty($pendingQty,$ItemID,$StyleID,$color,$size,$buyerPO)
{
	$pendingLeftQty = getPendingLrftOverAllocationQty($ItemID,$StyleID,$color,$size,$buyerPO);
	$pendingBulkQty = getPendingBulkAllocationQty($ItemID,$StyleID,$color,$size,$buyerPO);			
	
	$Qty = $pendingQty - $pendingLeftQty - $pendingBulkQty;
		
	return $Qty;	
}*/

function getLeftoverStockWithoutPendingQty($ItemID,$StyleID,$color,$size,$buyerPO)
{
	//get available leftover stock - with pending allocation qty
	$leftOverQty = getCommonLeftOverAllocatedQty($ItemID,$StyleID,$color,$size,$buyerPO);
	
	//get pending leftover allocation qty	
	//$pendingLeftQty = getPendingLrftOverAllocationQty($ItemID,$StyleID,$color,$size,$buyerPO,'total');
	$pendingLeftQty = 0;
			
	$leftOverQty -= $pendingLeftQty;
	
	return $leftOverQty;	 
}

function getBulkStockWithoutPendingQty($ItemID,$StyleID,$color,$size,$buyerPO)
{
	//get bulk available stock qty -  with pending allocation qty
	$BulkQty = getBulkQty($ItemID,$StyleID,$color,$size,$buyerPO);
		
	//get pending bulk allocation qty
	$pendingBulkQty = getPendingBulkAllocationQty($ItemID,$StyleID,$color,$size,$buyerPO,'total');
		
	$BulkQty -= $pendingBulkQty;
	
	return $BulkQty;	
	
}
function getLiabilityStockWithoutPendingQty($ItemID,$StyleID,$color,$size/*,$buyerPO*/)
{
	//get available liability stock - with pending allocation qty
	$liabilityQty = getCommonLiabilityAllocatedQty($ItemID,$StyleID,$color,$size,$buyerPO);
	
	//get pending leftover allocation qty	
	$pendingLiabQty = getPendingLiabilityAllocationQty($ItemID,$StyleID,$color,$size,$buyerPO,'total');
			
	$liabilityQty -= $pendingLiabQty;
	
	return $liabilityQty;	 
}
function getSupplierCountry($suppId)

{
	global $db;
	$sql = " select strCountry from suppliers where strSupplierID='$suppId' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strCountry"];
}
function getRecutCostingValue($styleID,$materialID)
{
	global $db;
	$sql = "select sum(odr.dblTotalValue) as dblTotalValue from orders_recut orc inner join orderdetails_recut odr on
orc.intRecutNo = odr.intRecutNo and orc.intRecutYear = odr.intRecutYear
where orc.intStyleId='$styleID' and odr.intMatDetailID='$materialID' and orc.intStatus=3 ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["dblTotalValue"];
}
function getMatItemName($materialID)
{
	global $db;
	$sql = "select strItemDescription from matitemlist where intItemSerial='$materialID' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strItemDescription"];
}
//edit by badra 27/01/2012//////////////////////////////////////////////////////////////
if ($RequestType =="showorderDetails")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<StyleDetails>\n";	 
	$buyer         =$_GET["buyer"];
	$season        =$_GET["season"];
	$mainCat         =$_GET["mainCat"];
	$subCat          =$_GET["subCat"];
	$items           =$_GET["items"];
	/*$style         =$_GET["style"];
	$styleno       =$_GET["styleno"];
	$orderno       =$_GET["orderno"];
	$scno          =$_GET["scno"];
	$buyerPoNo     =$_GET["buyerPoNo"];
	$poitamadding  =$_GET["poitamadding"];
	$maincategory  =$_GET["maincategory"];
	$subcategorys  =$_GET["subcategorys"];
	$items         =$_GET["items"];*/

	
	 $result=getDetails($buyer,$season,$mainCat,$subCat,$items/*,$style,$styleno,$orderno,$scno,$buyerPoNo,$poitamadding,$maincategory,$subcategorys,$items*/);	
	 // $ComboBuyer .= "<option value=\"". '' ."\">" . '' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
		$ResponseXML .= "<selectBox><![CDATA[".$row[""]."]]></selectBox>\n";
		$ResponseXML .= "<styleNo><![CDATA[".$row["strStyle"]."]]></styleNo>\n";
		$ResponseXML .= "<styleID><![CDATA[".$row["intStyleId"]."]]></styleID>\n";
		$ResponseXML .= "<orderNo><![CDATA[".$row["strOrderNo"]."]]></orderNo>\n";	                
	 }
	 $ResponseXML .= "</StyleDetails>";
	 echo $ResponseXML;
}

	 
function getDetails($buyer,$season,$mainCat,$subCat,$items/*,$style,$styleno,$orderno,$scno,$buyerPoNo,$poitamadding,$maincategory,$subcategorys,$items*/)
{
global $db;
$sql = "SELECT orders.strOrderNo,orders.strStyle,orders.intStyleId,orders.intSeasonId,
			   matsubcategory.intSubCatNo,matitemlist.intSubCatID,
			   matitemlist.intMainCatID,matmaincategory.intID,
			   materialratio.strMatDetailID
        FROM
			   materialratio
		Inner Join orders ON materialratio.intStyleId = orders.intStyleId
		Inner Join matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial
		Inner Join matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
		Inner Join matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo
        WHERE
               materialratio.dblBalQty >=  '0' ";
if($buyer!="")	
	 $sql .= "AND orders.intBuyerID =  '$buyer' ";
	 
if($season!="Select One")
	$sql .= "and orders.intSeasonId =  '$season' ";
	
if($mainCat!="")	
	 $sql .= "AND matitemlist.intMainCatID =  '$mainCat' ";
	 
if($subCat!="")
	$sql .= "AND matitemlist.intSubCatID =  '$subCat' ";
	
if($items!="")
	$sql .= "AND materialratio.strMatDetailID =  '$items' ";

	
	 $sql .= "GROUP BY orders.intStyleId";
				//echo $sql;
return $db->RunQuery($sql);
}
//*************************************************************************************************************
/*if ($RequestType =="showorderDetails1")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<StyleDetails1>\n";	 
	$mainCat         =$_GET["mainCat"];
	$subCat          =$_GET["subCat"];
	$items           =$_GET["items"];
	
	 $sql = "SELECT orders.strOrderNo,orders.strStyle,orders.intStyleId,orders.intSeasonId,
              materialratio.strMatDetailID,matitemlist.strItemDescription,
			   matitemlist.intMainCatID,matitemlist.intSubCatID
		FROM   materialratio
			Inner Join orders ON materialratio.intStyleId = orders.intStyleId
			Inner Join matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial
			Inner Join matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
			Inner Join matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo
		WHERE
			materialratio.dblBalQty >=  '0'"; 
if($mainCat!="")	
	 $sql .= "AND matitemlist.intMainCatID =  '$mainCat' ";
if($subCat!="")
	$sql .= "AND matitemlist.intSubCatID =  '$subCat' ";
if($items!="")
	$sql .= "AND materialratio.strMatDetailID =  '$items' ";
	
	 $sql .= "GROUP BY
				materialratio.intStyleId";
				//echo $sql;
		$result = $db->RunQuery($sql);		
	 while($row = mysql_fetch_array($result))
  	 {	 
		$ResponseXML .= "<selectBox1><![CDATA[".$row[""]."]]></selectBox1>\n";
		$ResponseXML .= "<styleNo1><![CDATA[".$row["strStyle"]."]]></styleNo1>\n";
		$ResponseXML .= "<styleID1><![CDATA[".$row["intStyleId"]."]]></styleID1>\n";
		$ResponseXML .= "<orderNo1><![CDATA[".$row["strOrderNo"]."]]></orderNo1>\n";	                
	 }
	 $ResponseXML .= "</StyleDetails1>";
	 echo $ResponseXML;
}*/
////////////////////////////////////////////////////////////////////////////////////////
if ($RequestType =="loadDetails")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<buyerId>\n";	 
	$buyer = $_GET["buyer"];
	
	 $result=getBuyerID($buyer);	
	 // $ComboBuyer .= "<option value=\"". '' ."\">" . '' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
		$ComboBuyer .= "<option value=\"". $row["intSeasonId"] ."\">" . $row["strSeason"] ."</option>" ;	                
	 }
	 	
	$ResponseXML.="<SEASONS><![CDATA[" .$ComboBuyer. "]]></SEASONS>\n";
	 $ResponseXML .= "</buyerId>";
	 echo $ResponseXML;
}

	 
function getBuyerID($buyer)
{
global $db;
$sql="SELECT DISTINCT   seasons.strSeason,seasons.intSeasonId
				FROM
					seasons
				Inner Join orders ON seasons.intSeasonId = orders.intSeasonId
					WHERE
						seasons.intStatus =  '1' ";

	if($buyer != '')
		$sql .= " AND orders.intBuyerID =  '$buyer' ";
		
	$sql .= " ORDER BY seasons.strSeason ASC ";
return $db->RunQuery($sql);
}
////////////////////////////////////////////////////////////////////////////////////////
if ($RequestType =="loadStyleDetails")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<styleId>\n";	 
	$buyers = $_GET["buyers"];
	
	 $result=getBuyer($buyers);	
	  $ComboStyle .= "<option value=\"". '' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
		$ComboStyle .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;	                
	 }
	 	
	$ResponseXML.="<STYLE><![CDATA[" .$ComboStyle. "]]></STYLE>\n";
	 $ResponseXML .= "</styleId>";
	 echo $ResponseXML;
}

	 
function getBuyer($buyers)
{
global $db;
$sql="SELECT orders.strOrderNo,orders.strStyle,orders.intStyleId,orders.intSeasonId
		FROM materialratio
      Inner Join orders ON materialratio.intStyleId = orders.intStyleId
      WHERE
        materialratio.dblBalQty >=  '0'";

	if($buyers != 'Select One')
		$sql .= "AND orders.intBuyerID =  '$buyers'";
		
		$sql .= "GROUP BY materialratio.intStyleId";	
	    
return $db->RunQuery($sql);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($RequestType =="loadOrderDetails")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<order>\n";	 
	$buyer1 = $_GET["buyer1"];
	
	 $result=getOrder($buyer1);	
	  $ComboOrder .= "<option value=\"". '' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
		$ComboOrder .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;	                
	 }
	 	
	$ResponseXML.="<ORDER><![CDATA[" .$ComboOrder. "]]></ORDER>\n";
	 $ResponseXML .= "</order>";
	 echo $ResponseXML;
}

	 
function getOrder($buyer1)
{
global $db;
$sql="SELECT orders.strOrderNo,orders.strStyle,orders.intStyleId,orders.intSeasonId
		FROM materialratio
      Inner Join orders ON materialratio.intStyleId = orders.intStyleId
      WHERE
        materialratio.dblBalQty >=  '0'";

	if($buyer1 != 'Select One')
		$sql .= "AND orders.intBuyerID =  '$buyer1'";
		
		$sql .= "GROUP BY materialratio.intStyleId";	
	    
return $db->RunQuery($sql);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($RequestType =="loadSCDetails")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<scNo>\n";	 
	$buyersdetails1 = $_GET["buyersdetails1"];
	
	 $result=getScNo($buyersdetails1);	
	  $ComboScNo .= "<option value=\"". '' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
		$ComboScNo .= "<option value=\"". $row["intSRNO"] ."\">" . $row["intSRNO"] ."</option>" ;	                
	 }
	 	
	$ResponseXML.="<SCNO><![CDATA[" .$ComboScNo. "]]></SCNO>\n";
	 $ResponseXML .= "</scNo>";
	 echo $ResponseXML;
}

	 
function getScNo($buyersdetails1)
{
global $db;
$sql="SELECT orders.strOrderNo,orders.strStyle,orders.intStyleId,orders.intSeasonId,
			 specification.intSRNO
	  FROM
			 materialratio
	  Inner Join orders ON materialratio.intStyleId = orders.intStyleId
	  Inner Join specification ON orders.intStyleId = specification.intStyleId
	  WHERE
            materialratio.dblBalQty >=  '0'";

	if($buyersdetails1 != 'Select One')
	     $sql .= "AND orders.intBuyerID =  '$buyersdetails1'";
		 
		 $sql .= " GROUP BY
			materialratio.intStyleId";	
	    
return $db->RunQuery($sql);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($RequestType =="loadMainDetails")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<MainCat>\n";	 
	$buyer2 = $_GET["buyer2"];
	
	 $result=getMain($buyer2);	
	 $ComboMainCat .= "<option value=\"". '' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
		$ComboMainCat .= "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;	                
	 }
	 	
	$ResponseXML.="<STYLENOS><![CDATA[" .$ComboMainCat. "]]></STYLENOS>\n";
	 $ResponseXML .= "</MainCat>";
	 echo $ResponseXML;
}

function getMain($buyer2)
{
global $db;
$sql="SELECT orders.intBuyerID,materialratio.intStyleId,matitemlist.intItemSerial,
			 orders.strStyle,orders.intStyleId,orders.strOrderNo,matmaincategory.intID,
			 matmaincategory.strDescription
	  FROM orders
	  Inner Join 
	  		materialratio ON orders.intStyleId = materialratio.intStyleId
	  Inner Join 
	        matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial
	  Inner Join 
	        matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
      WHERE
	  		materialratio.dblBalQty >=  '0'";

	if($buyer2 != 'Select One')
		$sql .= "AND orders.intBuyerID =  '$buyer2'";
		
		$sql .= "GROUP BY matmaincategory.intID";	
	    
return $db->RunQuery($sql);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($RequestType =="loadSubDetails")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<subCat>\n";	 
	$mainCat = $_GET["mainCat"];
	$buyer3 = $_GET["buyer3"];
	 $result=getSub($mainCat,$buyer3);	
	  $ComboSubCat .= "<option value=\"". '' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
		$ComboSubCat .= "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;	                
	 }
	 	
	$ResponseXML.="<MAINCAT><![CDATA[" .$ComboSubCat. "]]></MAINCAT>\n";
	 $ResponseXML .= "</subCat>";
	 echo $ResponseXML;
}

function getSub($mainCat,$buyer3)
{
global $db;
$sql="SELECT orders.intBuyerID,materialratio.intStyleId,matitemlist.intItemSerial,
			 orders.strStyle,orders.intStyleId,orders.strOrderNo,matmaincategory.intID,
			 matmaincategory.strDescription,matsubcategory.intSubCatNo,
			 matsubcategory.StrCatName
      FROM orders
	  Inner Join 
	  		 materialratio ON orders.intStyleId = materialratio.intStyleId
	  Inner Join 
	         matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial
      Inner Join 
	         matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
      Inner Join 
	         matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo
	  WHERE
             materialratio.dblBalQty >=  '0'";
			 
	if($mainCat != 'Select One')
		$sql .= "AND matmaincategory.intID =  '$mainCat'";

	if($buyer3 != 'Select One')
		$sql .= "AND orders.intBuyerID =  '$buyer3'";	
		
		$sql .= "GROUP BY matsubcategory.intSubCatNo";
//echo $sql;

return $db->RunQuery($sql);
}

//**********************************************************************************************************************
if ($RequestType =="loadSubDetails1")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<subCat1>\n";	 
	$mainCat1 = $_GET["mainCat1"];
	
	 $result=getSub1($mainCat1);	
	  $ComboSubCat1 .= "<option value=\"". '' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
		$ComboSubCat1 .= "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;	                
	 }
	 	
	$ResponseXML.="<MAINCAT><![CDATA[" .$ComboSubCat1. "]]></MAINCAT>\n";
	 $ResponseXML .= "</subCat1>";
	 echo $ResponseXML;
}

function getSub1($mainCat1)
{
global $db;
$sql="SELECT orders.intBuyerID,materialratio.intStyleId,matitemlist.intItemSerial,
			 orders.strStyle,orders.intStyleId,orders.strOrderNo,matmaincategory.intID,
			 matmaincategory.strDescription,matsubcategory.intSubCatNo,
			 matsubcategory.StrCatName
      FROM orders
	  Inner Join 
	  		 materialratio ON orders.intStyleId = materialratio.intStyleId
	  Inner Join 
	         matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial
      Inner Join 
	         matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
      Inner Join 
	         matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo
	  WHERE
             materialratio.dblBalQty >=  '0'";
			 
	if($mainCat1 != 'Select One')
		$sql .= "AND matmaincategory.intID =  '$mainCat1'";
		
		$sql .= "GROUP BY matsubcategory.intSubCatNo";
//echo $sql;

return $db->RunQuery($sql);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($RequestType =="loadItems")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<Items>\n";	 
	$subcategory = $_GET["subcategory"];
	$cboStyleNo = $_GET["cboStyleNo"];
	
	 $result=getItems($subcategory,$cboStyleNo);	
	 $ComboItems .= "<option value=\"". '' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
		$ComboItems .= "<option value=\"". $row["intItemSerial"] ."\">" . $row["strItemDescription"] ."</option>" ;	                
	 }
	 	
	$ResponseXML.="<ITEMS><![CDATA[" .$ComboItems. "]]></ITEMS>\n";
	 $ResponseXML .= "</Items>";
	 echo $ResponseXML;
}

function getItems($subcategory,$cboStyleNo)
{
global $db;

#=============================================================================================
# Comment On - 04/22/2014 Nalin Jayakody
# Description - Unlist items while rasing a PO which are removed from BOM
#=============================================================================================  

/*$sql="SELECT DISTINCT
materialratio.intStyleId,
orders.strStyle,
orders.strOrderNo,
materialratio.strMatDetailID,
matitemlist.intSubCatID,
matitemlist.intItemSerial,
matitemlist.strItemDescription
FROM
materialratio
Inner Join orders ON materialratio.intStyleId = orders.intStyleId
Inner Join matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial
where ( dblBalQty>0 or dblFreightBalQty>0 ) AND orders.intStatus = '11' AND (materialratio.intStatus != '0' or materialratio.intStatus IS NULL) ";*/

#=============================================================================================

$sql = " SELECT DISTINCT
materialratio.intStyleId,
orders.strStyle,
orders.strOrderNo,
materialratio.strMatDetailID,
matitemlist.intSubCatID,
matitemlist.intItemSerial,
matitemlist.strItemDescription
FROM
materialratio
Inner Join orders ON materialratio.intStyleId = orders.intStyleId
Inner Join matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial
Inner Join specificationdetails ON materialratio.intStyleId = specificationdetails.intStyleId AND materialratio.strMatDetailID = specificationdetails.strMatDetailID
where ( dblBalQty>0 or dblFreightBalQty>0 ) AND orders.intStatus = '11' AND (materialratio.intStatus != '0' or materialratio.intStatus IS NULL) AND  (specificationdetails.intStatus != '0' or specificationdetails.intStatus IS NULL) ";

	if($subcategory != '')
		$sql .= "AND matitemlist.intSubCatID =  '$subcategory'";	
	if($cboStyleNo != '')
		$sql .= "AND materialratio.intStyleId =  '$cboStyleNo'";	
		
		$sql .= " GROUP BY matitemlist.intItemSerial";	
	//echo $sql;
	    
return $db->RunQuery($sql);
}

////////////////////////////////////////////////////////////////////////////////////////
if ($RequestType =="loadseason")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<season>\n";	 
	$stylens = $_GET["stylens"];
	
	 $result=getseason($stylens);	
	 // $ComboBuyer .= "<option value=\"". '' ."\">" . '' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
		$ComboSeason .= "<option value=\"". $row["intSeasonId"] ."\">" . $row["strSeason"] ."</option>" ;	                
	 }
	 	
	$ResponseXML.="<SEASON><![CDATA[" .$ComboSeason. "]]></SEASON>\n";
	 $ResponseXML .= "</season>";
	 echo $ResponseXML;
}

	 
function getseason($stylens)
{
global $db;
$sql="SELECT DISTINCT orders.strOrderNo,orders.intStyleId,orders.strStyle,
      orders.intStatus,orders.intSeasonId,seasons.strSeason FROM orders
      Inner Join seasons ON seasons.intSeasonId = orders.intSeasonId
      WHERE orders.intStatus =  '11'";

	if($stylens != '')
		$sql .= "AND orders.intStyleId ='$stylens'";	
	    
return $db->RunQuery($sql);
}

////////////////////////////////////////////////////////////////////////////////////////
if ($RequestType =="loadData")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<styleData>\n";	 
	$StyleNo = $_GET["StyleNo"];
	
	 $result=getStyle($StyleNo);	
	 // $ComboBuyer .= "<option value=\"". '' ."\">" . '' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 
	 	$ResponseXML .= "<selectBox><![CDATA[".$row[""]."]]></selectBox>\n";
		$ResponseXML.="<Description><![CDATA[" .$row["strItemDescription"]. "]]></Description>\n";
		$ResponseXML.="<DescriptionId><![CDATA[" .$row["intItemSerial"]. "]]></DescriptionId>\n";
		$ResponseXML.="<Color><![CDATA[" .$row["strColor"]. "]]></Color>\n";
		$ResponseXML.="<size><![CDATA[" .$row["strSize"]. "]]></size>\n";
		$ResponseXML.="<Qty><![CDATA[" .$row["dblQty"]. "]]></Qty>\n";
		$ResponseXML.="<Pending><![CDATA[" .$row["dblPending"]. "]]></Pending>\n";
		$ResponseXML.="<Bulk><![CDATA[" .$row[""]. "]]></Bulk>\n";
		$ResponseXML.="<LeftStock><![CDATA[" .$row[""]. "]]></LeftStock>\n";
		$ResponseXML.="<Liabiltiy><![CDATA[" .$row[""]. "]]></Liabiltiy>\n";
		$ResponseXML.="<Allocation><![CDATA[" .$row[""]. "]]></Allocation>\n";                
	 }
	 $ResponseXML .= "</styleData>";
	 echo $ResponseXML;
}

	 
function getStyle($StyleNo)
{
global $db;
$sql="SELECT orders.intStyleId,matitemlist.intItemSerial,purchaseorderdetails.strColor,
	         purchaseorderdetails.strSize,matitemlist.strItemDescription,
			 purchaseorderdetails.dblQty,purchaseorderdetails.dblPending
      FROM
			 purchaseorderdetails
	  Inner Join 
	         orders 
	  ON
	  	     purchaseorderdetails.intStyleId = orders.intStyleId
	  Inner Join 
	  		 matitemlist
	  ON 
	         purchaseorderdetails.intMatDetailID = matitemlist.intItemSerial
      WHERE
  			 orders.intStyleId =  '$StyleNo'";

return $db->RunQuery($sql);
}
////////////////////////////////////////////////////////////////////////////////////////
if ($RequestType =="loadDate")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<Date>\n";	 
	$styleNos = $_GET["styleNos"];
	
	 $result=getStyleNo($styleNos);	
	 // $ComboBuyer .= "<option value=\"". '' ."\">" . '' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 	
		$ResponseXML.="<Date1><![CDATA[" .substr($row["dtDateofDelivery"],0,10). "]]></Date1>\n";
	    $ResponseXML.="<Date11><![CDATA[" .substr($row["dtDateofDelivery"],0,10). "]]></Date11>\n";                
	 }
	 $ResponseXML .= "</Date>";
	 echo $ResponseXML;
}

	 
function getStyleNo($styleNos)
{
global $db;
$sql="SELECT deliveryschedule.dtDateofDelivery,deliveryschedule.intDeliveryId,
      orders.intStyleId FROM orders
		Inner Join deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId
					WHERE
						orders.intStatus =  '11' ";

	if($styleNos != '')
		$sql .= " AND orders.intStyleId =  '$styleNos' ";
return $db->RunQuery($sql);
}
////////////////////////////////////////////////////////////////////////////////////////
if ($RequestType =="GetItemDis1")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<Details>\n";	 
	$StyleID      = $_GET["StyleID"];
	$material     = $_GET["material"];
	$subCat       = $_GET["subCat"];
	$items        = $_GET["items"];
	$postate        = $_GET["postate"];
	
	 $result=getTblGrid($StyleID,$material,$subCat,$items,$postate);	
	 // $ComboBuyer .= "<option value=\"". '' ."\">" . '' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {
		    $ResponseXML .= "<ItemID><![CDATA[" . $row["intItemSerial"]  . "]]></ItemID>\n";
			$ResponseXML .= "<StyleId><![CDATA[" . $row["intStyleId"]  . "]]></StyleId>\n";	 	
			$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
			$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
			$ResponseXML .= "<Qty><![CDATA[" . $row["dblBalQty"]  . "]]></Qty>\n";
			
			$ResponseXML .= "<ItemName><![CDATA[" . $row["strItemDescription"]  . "]]></ItemName>\n";
			$ResponseXML .= "<unitprice><![CDATA[" . $row["dblUnitPrice"]  . "]]></unitprice>\n";
			$ResponseXML .= "<dblfreight><![CDATA[" . $row["dblFreightBalQty"]  . "]]></dblfreight>\n";	               
	 
	
	 $pendingQty = $row["dblBalQty"];
	 $Qty = GetMaterialRatioBalQty($StyleID,$row["intItemSerial"],$row["strColor"],$row["strSize"],0);
			$leftOverQty = getLeftoverStockWithoutPendingQty($row["intItemSerial"],$StyleID,$row["strColor"],$row["strSize"]);
			$BulkQty = getBulkStockWithoutPendingQty($row["intItemSerial"],$StyleID,$row["strColor"],$row["strSize"]);
			$liabilityQty = getLiabilityStockWithoutPendingQty($row["intItemSerial"],$StyleID,$row["strColor"],$row["strSize"]);
			if($Qty<0)
				$Qty = 0;
				
				if($postate == 1)
			{
			 	$totQty = $row["dblQty"];
				$Qty = $row["dblFreightBalQty"];
				$leftOverQty =0;
				$BulkQty =0;
			}	
			else
			{
				$totQty = $row["dblQty"]+$row["dblRecutQty"];
			}	 
				
			$ResponseXML .= "<totQty><![CDATA[" . $totQty  . "]]></totQty>\n";
			$ResponseXML .= "<orderQty><![CDATA[" . $orderQty . "]]></orderQty>\n";
			$ResponseXML .= "<ItemLeftOverQty><![CDATA[" . $leftOverQty . "]]></ItemLeftOverQty>\n";
		 	$ResponseXML .= "<ItemBulkQty><![CDATA[" . $BulkQty . "]]></ItemBulkQty>\n";
			$ResponseXML .= "<liabilityQty><![CDATA[" . $liabilityQty . "]]></liabilityQty>\n";
			$ResponseXML .= "<POTotalQty><![CDATA[" . $dblPOtotal . "]]></POTotalQty>\n";
			$ResponseXML .= "<pendingQty><![CDATA[" . $Qty . "]]></pendingQty>\n";
			$ItemQty=501;
			}
	 
	 $ResponseXML .= "</Details>";
	 echo $ResponseXML;
}

	 
function getTblGrid($StyleID,$material,$subCat,$items)
{
global $db;
$sql="SELECT matitemlist.strItemDescription,materialratio.strColor,materialratio.strSize,materialratio.dblQty,
				materialratio.dblBalQty,matitemlist.intSubCatID,materialratio.dblFreightBalQty,matitemlist.intItemSerial,
				matitemlist.dblUnitPrice,materialratio.intStyleId,orders.strOrderNo,orders.strStyle,specification.intSRNO
      FROM materialratio
      Inner Join matitemlist ON matitemlist.intItemSerial = materialratio.strMatDetailID
      Inner Join orders ON materialratio.intStyleId = orders.intStyleId
      Inner Join specification ON materialratio.intStyleId = specification.intStyleId
      WHERE
			 materialratio.dblBalQty >  '0'";

	if($StyleID != '')
		$sql .= " AND materialratio.intStyleId =  '$StyleID' ";
	
	if($material != '')
		$sql .= " AND matitemlist.intMainCatID =  '$material' ";
		
	if($subCat != '')
		$sql .= " AND matitemlist.intSubCatID =  '$subCat' ";
	
	if($items != '')
		$sql .= " AND matitemlist.intItemSerial  =  '$items' ";
		//echo $sql;
return $db->RunQuery($sql);
}

////////////////////////////////////////////////////////////////////////////////////////
if ($RequestType =="GetItemDis11")
{

	$ResponseXML  = "";	 
	$ResponseXML .= "<Details>\n";	 
	$styleNo      = $_GET["styleNo"];
	$orderNo      = $_GET["orderNo"];
	$scNo         = $_GET["scNo"];
	$mainCat      = $_GET["mainCat"];
	$subCat       = $_GET["subCat"];
	$itemList     = $_GET["itemList"];
	
	// ========================================================
	// Add On - 10/26/2015
	// Add By - Nalin Jayakody
	// Adding - Add buyer PO number to the variable from query string
	// ========================================================
	 $buyerPO     = $_GET["buyerpo"];
	 $BPOState	  = $_GET["chkallbpo"];
	// ========================================================
	
	
	// ========================================================
	// Add On - 10/26/2015
	// Add By - Nalin Jayakody
	// Adding - Add buyer PO number as variable to the function
	// ========================================================
	//echo $BPOState;
	 $result=getTblGrid1($styleNo,$orderNo,$mainCat,$subCat,$itemList,$buyerPO,$BPOState);	
	 // $ComboBuyer .= "<option value=\"". '' ."\">" . '' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {
		    $ResponseXML .= "<ItemID><![CDATA[" . $row["intItemSerial"]  . "]]></ItemID>\n";
			$ResponseXML .= "<StyleId><![CDATA[" . $row["intStyleId"]  . "]]></StyleId>\n";	 	
			$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
			$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
			$ResponseXML .= "<Qty><![CDATA[" . $row["dblBalQty"]  . "]]></Qty>\n";
			
			$ResponseXML .= "<ItemName><![CDATA[" . $row["strItemDescription"]  . "]]></ItemName>\n";
			$ResponseXML .= "<unitprice><![CDATA[" . $row["dblUnitPrice"]  . "]]></unitprice>\n";
			$ResponseXML .= "<dblfreight><![CDATA[" . $row["dblFreightBalQty"]  . "]]></dblfreight>\n";	    
			$ResponseXML .= "<buyerpono><![CDATA[" . $row["strBuyerPONO"]  . "]]></buyerpono>\n";	               
			 //echo $row["strBuyerPONO"];
			 $orderQty = $row["dblQty"];
			 $pendingQty = $row["dblBalQty"];
			 $Qty1 = GetMaterialRatioBalQty($styleNo,$buyerPO,$row["intItemSerial"],$row["strColor"],$row["strSize"],0);
			$leftOverQty = getLeftoverStockWithoutPendingQty($row["intItemSerial"],$styleNo,$row["strColor"],$row["strSize"], $row["strBuyerPONO"]);
			//echo $leftOverQty;
			$BulkQty = getBulkStockWithoutPendingQty($row["intItemSerial"],$styleNo,$row["strColor"],$row["strSize"],$buyerPO);
			$liabilityQty = getLiabilityStockWithoutPendingQty($row["intItemSerial"],$styleNo,$row["strColor"],$row["strSize"]);
			if($Qty1<0)
				$Qty1 = 0;
				
			if($postate == 1)
			{
			 	$totQty = $row["dblQty"];
				$Qty1 = $row["dblFreightBalQty"];
				$leftOverQty =0;
				$BulkQty =0;
			}	
			else
			{
				$totQty = $row["dblQty"]+$row["dblRecutQty"];
			}	 
				
			$ResponseXML .= "<totQty><![CDATA[" . $totQty  . "]]></totQty>\n";
			$ResponseXML .= "<orderQty><![CDATA[" . $orderQty . "]]></orderQty>\n";
			$ResponseXML .= "<ItemLeftOverQty><![CDATA[" . $leftOverQty . "]]></ItemLeftOverQty>\n";
		 	$ResponseXML .= "<ItemBulkQty><![CDATA[" . $BulkQty . "]]></ItemBulkQty>\n";
			$ResponseXML .= "<liabilityQty><![CDATA[" . $liabilityQty . "]]></liabilityQty>\n";
			$ResponseXML .= "<POTotalQty><![CDATA[" . $dblPOtotal . "]]></POTotalQty>\n";
			$ResponseXML .= "<pendingQty><![CDATA[" . $pendingQty . "]]></pendingQty>\n";
			$ItemQty=501;
	}
	 
	 $ResponseXML .= "</Details>";
	 echo $ResponseXML;
}

if ($RequestType =="GetItemReqTot"){
    
    $styleNo      = $_GET["styleNo"];
    $mainCat      = $_GET["mainCat"];
    $subCat       = $_GET["subCat"];
    $itemList     = $_GET["itemList"];
    
    $ResponseXML  = "";	 
    $ResponseXML .= "<RequiredQty>\n";	
   
    $result = GetTotRequiredQty($styleNo,$mainCat,$subCat,$itemList);
    
    while($row = mysql_fetch_array($result)){
        $ResponseXML .= "<TotRequiredQty><![CDATA[" . $row["TotRequired_Qty"]  . "]]></TotRequiredQty>\n";
    }
        
    $ResponseXML .= "</RequiredQty>";    
    echo $ResponseXML;
    
}

if ($RequestType =="GetTotPOQty"){
    
    $styleNo      = $_GET["styleNo"];
    $mainCat      = $_GET["mainCat"];
    $subCat       = $_GET["subCat"];
    $itemList     = $_GET["itemList"];
    
    $ResponseXML  = "";	 
    $ResponseXML .= "<RequiredQty>\n";	
   
    $result = GetTotRaisedPoQty($styleNo,$mainCat,$subCat,$itemList);
    
    while($row = mysql_fetch_array($result)){
        $ResponseXML .= "<TotPOQty><![CDATA[" . $row["TotPOQty"]  . "]]></TotPOQty>\n";
    }
        
    $ResponseXML .= "</RequiredQty>";    
    echo $ResponseXML;
    
}

// ========================================================
// Add On - 10/26/2015
// Add By - Nalin Jayakody
// Adding - Add buyer po number to as parameter to the function
// ========================================================	 
function getTblGrid1($styleNo,$orderNo,$mainCat,$subCat,$itemList, $buyerPoNo, $allBPOState)
{
global $db;

$BPOState = $allBPOState;

/*$sql="SELECT matitemlist.strItemDescription,materialratio.strColor,materialratio.strSize,materialratio.dblQty,
				materialratio.dblBalQty,matitemlist.intSubCatID,materialratio.dblFreightBalQty,matitemlist.intItemSerial,
				matitemlist.dblUnitPrice,materialratio.intStyleId,orders.strOrderNo,orders.strStyle,specification.intSRNO,matitemlist.intMainCatID, materialratio.strBuyerPONO
      FROM materialratio
      Inner Join matitemlist ON matitemlist.intItemSerial = materialratio.strMatDetailID
      Inner Join orders ON materialratio.intStyleId = orders.intStyleId
      Inner Join specification ON materialratio.intStyleId = specification.intStyleId
      WHERE
			 materialratio.dblBalQty >  '0' AND (materialratio.intStatus != '0' or materialratio.intStatus IS NULL)";*/

	$sql = "SELECT matitemlist.strItemDescription,materialratio.strColor,materialratio.strSize,materialratio.dblQty,
				materialratio.dblBalQty,matitemlist.intSubCatID,materialratio.dblFreightBalQty,matitemlist.intItemSerial,
				matitemlist.dblUnitPrice,materialratio.intStyleId,orders.strOrderNo,orders.strStyle,specification.intSRNO,matitemlist.intMainCatID, materialratio.strBuyerPONO
			FROM materialratio Inner Join matitemlist ON matitemlist.intItemSerial = materialratio.strMatDetailID
			Inner Join orders ON materialratio.intStyleId = orders.intStyleId
			Inner Join specification ON materialratio.intStyleId = specification.intStyleId
			Inner Join specificationdetails ON materialratio.intStyleId = specificationdetails.intStyleId AND materialratio.strMatDetailID = specificationdetails.strMatDetailID
			WHERE
			 materialratio.dblBalQty >  '0' AND (specificationdetails.intStatus != '0' or specificationdetails.intStatus IS NULL) AND 
			 (materialratio.intStatus != '0' or materialratio.intStatus IS NULL) ";		 

	if($styleNo != '')
		$sql .= " AND orders.intStyleId =  '$styleNo' ";
	/*if($orderNo != 'Select One')
		$sql .= " AND orders.intStyleId =  '$orderNo' ";*/
	if($mainCat != '')
		$sql .= " AND matitemlist.intMainCatID =  '$mainCat' ";
	if($subCat != '')
		$sql .= " AND matitemlist.intSubCatID =  '$subCat' ";
	if($itemList != '')
		$sql .= " AND matitemlist.intItemSerial =  '$itemList' ";
	
	//if($BPOState=='false'){
		if($buyerPoNo != ''){
			$sql .= " AND materialratio.strBuyerPONO =  '$buyerPoNo' ";	
		}
	//}
				
	
		//echo $buyerPoNo;
return $db->RunQuery($sql);
}

function GetTotRequiredQty($styleNo,$mainCat,$subCat,$itemList){
    
    global $db;
    
    $sql = " SELECT Sum(specificationdetails.dblTotalQty) AS TotRequired_Qty 
             FROM orders Inner Join specification ON orders.intStyleId = specification.intStyleId Inner Join specificationdetails ON specification.intStyleId = specificationdetails.intStyleId
                   Inner Join matitemlist ON matitemlist.intItemSerial = specificationdetails.strMatDetailID
             WHERE (specificationdetails.intStatus !=  '0' OR specificationdetails.intStatus IS NULL ) ";
    
    if($styleNo != '')
	$sql .= " AND orders.intStyleId =  '$styleNo' ";
	
    if($mainCat != '')
        $sql .= " AND matitemlist.intMainCatID =  '$mainCat' ";
    if($subCat != '')
        $sql .= " AND matitemlist.intSubCatID =  '$subCat' ";
    if($itemList != '')
        $sql .= " AND matitemlist.intItemSerial =  '$itemList' ";
    //echo $sql;
    return $db->RunQuery($sql);
}
//***********************************************************************************************************
if ($RequestType =="POMainItems1")
{
	$ResponseXML = "";	 

	$ResponseXML .= "<POMatItems1>\n";	
	
	//$itemList=$_GET["itemIDs"];
	$styleID	= $_GET["styleID"]; 
	$buyerPO	= $_GET["buyerPO"];
	$postate	= $_GET["poState"];
	$deliveryDate = $_GET["dilDate"];
	$catID 		= $_GET["material"];
	$itemID 	= $_GET["matDetailID"];
	$color 		= $_GET["color"];
	$size  		= $_GET["size"]; 
	//$arr = explode(',', $itemList); 
	$value 		= $itemID;
	/*foreach ($arr as $value)
	{*/
	
	 //$result=getPOMat($value,$styleID,$buyerPO,$postate,$deliveryDate,$catID);	
	 $result = getPOMaterialDetails($itemID,$styleID,$buyerPO,$postate,$deliveryDate,$catID,$color,$size);
	 
	 while($row = mysql_fetch_array($result))
  	 {	 
		$unitPrice = $row["dblUnitPrice"];
		//echo $unitPrice;
		if($row["strColor"] != "")
			 $sql = "SELECT dblUnitPrice FROM conpccalculation WHERE intStyleId = '" . $row["intStyleId"]  . "' AND strMatDetailID = '$value' AND strColor = '" . $row["strColor"]  . "'";
			 //echo $sql;
			
		if($row["strSize"] != "")
			$sql = "SELECT dblUnitPrice FROM conpccalculation WHERE intStyleId = '" . $row["intStyleId"]  . "' AND strMatDetailID = '$value' AND strSize = '" . $row["strSize"]  . "'";
			
		if($row["strColor"] != "" && $row["strSize"] != "")
			$sql = "SELECT dblUnitPrice FROM conpccalculation WHERE intStyleId = '" . $row["intStyleId"]  . "' AND strMatDetailID = '$value' AND strColor = '" . $row["strColor"]  . "' AND strSize = '" . $row["strSize"]  . "'";

		$colorResult = $db->RunQuery($sql);
		while($rowcolor = mysql_fetch_array($colorResult))
		{
			$unitPrice = $rowcolor["dblUnitPrice"];
			break;
		}
		$buyerPoName	= $buyerPO;// '#Main Ratio#';
		if($row["strBuyerPONO"]!='#Main Ratio#')
			$buyerPoName	= GetBuyerPoName($row["strBuyerPONO"]);
			
		$ResponseXML .= "<StyleID><![CDATA[" . $row["intStyleId"]  . "]]></StyleID>\n";
		$ResponseXML .= "<StyleName><![CDATA[" . $row["strStyle"]  .  " - " . $row["strOrderNo"]  .  "]]></StyleName>\n";
		$ResponseXML .= "<BuyerPO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPO>\n";
		$ResponseXML .= "<BuyerPoName><![CDATA[" . $buyerPoName . "]]></BuyerPoName>\n";
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		//start 2010-10-13 get balance with po,bulk & leftover qty  
		//$ResponseXML .= "<Qty><![CDATA[" . $row["dblBalQty"]  . "]]></Qty>\n";
		$ResponseXML .= "<ItemName><![CDATA[" . $row["strItemDescription"]  . "]]></ItemName>\n";
		$ResponseXML .= "<MainCatName><![CDATA[" . $row["strDescription"]  . "]]></MainCatName>\n";
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		$ResponseXML .= "<UnitPrice><![CDATA[" . $unitPrice  . "]]></UnitPrice>\n";
		$ResponseXML .= "<MatDetailID><![CDATA[" . $itemID . "]]></MatDetailID>\n";
		$ResponseXML .= "<dblFreightBalQty><![CDATA[" . $row["dblFreightBalQty"] . "]]></dblFreightBalQty>\n";
		$ResponseXML .= "<dblfreightUnitPrice><![CDATA[" . $row["dblfreight"] . "]]></dblfreightUnitPrice>\n";
		//dblFreightBalQty
		
		$A = "  SELECT
				Sum(purchaseorderdetails.dblQty) AS Tqty
				FROM
				purchaseorderdetails
				Inner Join matitemlist ON matitemlist.intItemSerial = purchaseorderdetails.intMatDetailID
				Inner Join matsubcategory ON matsubcategory.intSubCatNo = matitemlist.intSubCatID
				Inner Join purchaseorderheader ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear
				WHERE
				purchaseorderdetails.intStyleId =  '$styleID' AND
				purchaseorderdetails.intPOType =  '0' AND
				purchaseorderheader.intStatus =  '10' AND
				purchaseorderdetails.intMatDetailID =  '$value' AND
				purchaseorderdetails.strColor =  '".$row["strColor"]."' AND
				purchaseorderdetails.strSize =  '".$row["strSize"]."' AND
				purchaseorderdetails.strBuyerPONO = '$buyerPO' ";
				//echo $A;
				//break;
		$Aresult=$db->RunQuery($A);
		$dblPOtotal=0;
		while($Arow = mysql_fetch_array($Aresult))
  	 	{
			$dblPOtotal = $Arow["Tqty"];
		}
		$ResponseXML .= "<POTotalQty><![CDATA[" . $dblPOtotal . "]]></POTotalQty>\n";
		$ItemQty=501;
		if($canOrderAdditional)
		{
		$B = "";
		if ($buyerPO == "#Main Ratio#")
		{            
				$B = 	"SELECT
						(orders.intQty) AS ItemQty
						FROM
						orderdetails
						INNER JOIN orders ON orders.strOrderNo = orderdetails.strOrderNo AND orders.intStyleId = orderdetails.intStyleId INNER JOIN 
						matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial INNER JOIN matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo 
						WHERE
						orderdetails.intStyleId =  '$styleID' AND
						orderdetails.intMatDetailID =  '$value' AND matsubcategory.intAdditionalAllowed = '1'";
		}
		else

		{
			$B = "SELECT DISTINCT dblQty FROM style_buyerponos 
INNER JOIN orderdetails ON style_buyerponos.intStyleId = orderdetails.intStyleId INNER JOIN 
						matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial INNER JOIN matsubcategory ON matitemlist.intSubCatID = matsubcategory.intSubCatNo 
WHERE style_buyerponos.intStyleId = '$styleID' AND style_buyerponos.strBuyerPONO = '$buyerPO' AND matsubcategory.intAdditionalAllowed = '1'  AND orderdetails.intMatDetailID =  '$value' ";
		}		
				
		echo $B;	
		$Bresult=$db->RunQuery($B);
		
		while($Brow = mysql_fetch_array($Bresult))
  	 	{
			$ItemQty = $Brow["ItemQty"];
		}
		}
		$ResponseXML .= "<ItemQty><![CDATA[" . $ItemQty . "]]></ItemQty>\n";
		
		$pendingQty = $row["dblBalQty"];
		//Qty = ratioQty - pending Allocation Qty
		//$Qty = getPOItemPendingQty($pendingQty,$itemID,$styleID,$row["strColor"],$row["strSize"],$buyerPO);
		$Qty = GetMaterialRatioBalQty($styleID,$buyerPO,$itemID,$row["strColor"],$row["strSize"],0);
		
		$leftOverQty = 	getLeftoverStockWithoutPendingQty($itemID,$styleID,$row["strColor"],$row["strSize"],$buyerPO);
		$BulkQty = 	getBulkStockWithoutPendingQty($itemID,$styleID,$row["strColor"],$row["strSize"],$buyerPO);
		//$liabilityQty = getLiabilityStockWithoutPendingQty($itemID,$styleID,$row["strColor"],$row["strSize"],$buyerPO);
			//if cantPurchaseStockAvailable permission available can't purchase pending qty
			if($cantPurchaseStockAvailable)
			{
				$totAllocationStock = $leftOverQty + $BulkQty;
				if($totAllocationStock > $Qty)
					$Qty=0;
			}
									
				$ResponseXML .= "<Qty><![CDATA[" . $Qty  . "]]></Qty>\n";
	 }
	 
	 //}//end foreach	
	 $ResponseXML .= "</POMatItems1>";	 
	 echo $ResponseXML;

}
if ($RequestType =="getStyleNO")
{

	$ResponseXML = "";	 
	$ResponseXML .= "<StyleNO>\n";	 
	$buyer = $_GET["buyer"];
	
	 $result=StyleNOS($buyer);	
	  $ComboSTYLE .= "<option value=\"". '' ."\">" . 'Select One' ."</option>" ;
	 while($row = mysql_fetch_array($result))
  	 {	 	
		$ComboSTYLE .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;	                
	 }
	 	
	 $ResponseXML.="<StyleNo><![CDATA[" .$ComboSTYLE. "]]></StyleNo>\n";
	 $ResponseXML .= "</StyleNO>";
	 echo $ResponseXML;
}

	 
function StyleNOS($buyer)
{
global $db;
$sql="SELECT DISTINCT materialratio.intStyleId,orders.strStyle,orders.strOrderNo,orders.intBuyerID FROM materialratio inner join orders on  materialratio.intStyleId = orders.intStyleId  where ( dblBalQty>0 or dblFreightBalQty>0 ) AND orders.intStatus = 11";
	if($buyer != '')
		$sql .= " AND orders.intBuyerID =  '$buyer' ";
		//echo $sql; 
return $db->RunQuery($sql);
}
function getCostingTotalValue($styleID,$materialID)
{
	global $db;
	$sql = " SELECT OD.dblUnitPrice*
(SELECT SUM(M.dblQty+M.dblRecutQty) FROM materialratio M WHERE M.intStyleId=OD.intStyleId AND M.strMatDetailID = OD.intMatDetailID) AS CostingValue
FROM  orderdetails OD 
WHERE OD.intStyleId='$styleID' AND OD.intMatDetailID='$materialID'";	

	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return round($row["CostingValue"],4);
}

function GetTotRaisedPoQty($styleNo,$mainCat,$subCat,$itemList){
    
    global $db;
    
    $sql = " SELECT Sum(purchaseorderdetails.dblQty) AS TotPOQty
             FROM purchaseorderdetails Inner Join matitemlist ON purchaseorderdetails.intMatDetailID = matitemlist.intItemSerial
                  Inner Join purchaseorderheader ON purchaseorderdetails.intPoNo = purchaseorderheader.intPONo AND purchaseorderdetails.intYear = purchaseorderheader.intYear 
             WHERE purchaseorderdetails.intStyleId =  '$styleNo' AND purchaseorderheader.intStatus =  '10' ";
    
    	
    if($mainCat != '')
        $sql .= " AND matitemlist.intMainCatID =  '$mainCat' ";
    if($subCat != '')
        $sql .= " AND matitemlist.intSubCatID =  '$subCat' ";
    if($itemList != '')
        $sql .= " AND matitemlist.intItemSerial =  '$itemList' ";
    //echo $sql;
    return $db->RunQuery($sql);        
    
}
?>