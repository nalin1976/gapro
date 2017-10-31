<?php
session_start();
include "Connector.php";
require_once ('classes/permission.php');
//include_once 'mail/mailSender.php';
header('Content-Type: text/xml'); 

$class_permission   = new Permission();
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
else if (strcmp($RequestType,"checkPurchasedUnitprice") == 0)
{
	 $ResponseXML = "";
	 $styleNo=$_GET["styleID"];
	 $itemCode = $_GET["itemCode"]; 
	 $ResponseXML .= "<Result>\n";
	 $highestUnitprice = getItemHighUnitPrice($styleNo,$itemCode); 	
	 $ResponseXML .= "<HighestUnitprice><![CDATA[" . $highestUnitprice  . "]]></HighestUnitprice>\n";	
	 $ResponseXML .= "</Result>";
	 echo $ResponseXML;	
}



else if (strcmp($RequestType,"mailSend") == 0)
{
   
     $styleNo = $_GET["styleNo"];
     $scNo = $_GET["scNo"];
     $itemCode = $_GET["itemCode"];
     $bpoNo = $_GET["bpoNo"];
   
    
     $result=getmailDetail($styleNo,$itemCode,$bpoNo);
      $result_to=getmailAdd($styleNo);
      
 $i=0;
      while($row_emaillAdd = mysql_fetch_array($result_to)){
         $emaillAdd = $row_emaillAdd["strEmail"]; 
         $buyerName = $row_emaillAdd["strName"]; 
         $sa[$i] = $emaillAdd;
         $i++;
      }
     // print_r($sa);
     
    $to = $sa;
    $from = "gapro@helaclothing.com";
    $subject = "SC# ". $scNo." Fabric Consumption Alert";

    //begin of HTML message 
    $message ="
<html> 
  <body> 
    
    <p style=\"text-align:Left;\">
    <span style=\"font-size:14px;\">Hi,</span>
    
        <table width=644  height=289 border=0 cellpadding=0 cellspacing=0 style=\"border-color:#0099FF; border-width:thin; border-style:solid\">
     <tr><td colspan=\"4\" style=\"font-family:Verdana; font-size:12px; font-weight:bold\" align=\"center\" width=\"85%\">Fabric Consumption Alert</td> 
     
  <tr>
    <td width=48>&nbsp;</td>
    <td width=137>&nbsp;</td>
    <td width=32>&nbsp;</td>
    <td width=399>&nbsp;</td>
 </tr>
  <tr>
    <td>&nbsp;</td>
    <td> SC No </td>
    <td>:</td>
    <td><span style=\"font-size:12px;\">".$scNo."</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>BPO No </td>
    <td>:</td>
     <td><span style=\"font-size:12px;\">".$bpoNo."</span></td>
    
  </tr>";
   
  	while($row = mysql_fetch_array($result)){
		$disc = $row["strItemDescription"];
                $matYY = $row["matYY"];
                $color = $row["strColor"];
                
              //  $message .= "<tr><td colspan=\"4\">".$disc."</td></tr>";
	$message .=" <tr>
    <td>&nbsp;</td>
    <td>Fabric Discription </td>
    <td>:</td>
    <td><span style=\" font-size:12px;\">".$disc."</span></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Fabric Color </td>
    <td>:</td>
    <td><span style=\" font-size:12px;\">".$color."</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td >Fabric Consumption </td>
    <td>:</td>
    <td><span style=\" font-size:12px;\">".$matYY."</span></td>
   
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>";
                
        } 
 
$message .="</table>
      
    </p>
    <br/><br/><span style=\" font-size:12px;\">Thanks.</span>
     <br/><br/>
     <br/><br/>
     <hr><span style=\"background-color:#CCCCCC; font-size:14px;\">*** This is a GAPRO System generated email, Please do not reply to this message ***</span>
  </body>
</html>";

 $nofRows= mysql_num_rows($result);
    //end of message 
    $headers  = "From: $from\r\n"; 
    $headers .= "Content-type: text/html\r\n";

    //options to send to cc+bcc 
    //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
    //$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 

    // now lets send the email. 
    if($nofRows>0 && $matYY>0){
        foreach ($to as $to){
        mail($to, $subject, $message, $headers); 
        }
        
      echo "Message has been sent....!";  
    }
    
    

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
else if(strcmp($RequestType,"GetAutocompleteItem") == 0)
{
		$ResponseXML = "";
		$itemId = $_GET["itemId"];
		$text = $_GET["text"];
		
		$sql= "select intItemSerial,strItemDescription from matitemlist where (intSubCatID = (select intSubCatID from matitemlist where intItemSerial = '$itemId')) and strItemDescription like '%$text%'";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$itemDescription_arr.=$row['strItemDescription']."|";
	}
	
	echo $itemDescription_arr;
	
	 	
}
else if(strcmp($RequestType,"DisplaySelectedItem") == 0)
{
	 $ResponseXML = "";
	 $selectedItem = $_GET['selectedItem'];
	 $ResponseXML .= "<Items>\n";
	 
	 $sql= "select intItemSerial,strItemDescription from matitemlist where  strItemDescription = '$selectedItem'";
	 
	 $result=$db->RunQuery($sql);
	 while($row=mysql_fetch_array($result))
	{
		$itemDescription_arr.= $row['strItemDescription'];
		//edited new
		$itemDescription_id.= $row['intItemSerial'];
		//end
	}
	
	$ResponseXML .= "<ItemId><![CDATA[" . $itemDescription_arr . "]]></ItemId>\n";
	$ResponseXML .= "<ItemmainId><![CDATA[" . $itemDescription_id . "]]></ItemmainId>\n";
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
		$newSCNO = "";
	
		$sql = "SELECT intSRNO FROM specification WHERE intStyleId = '$styleNo'";
		$result = $db->RunQuery($sql);
		//echo $reqyest;
		while($row = mysql_fetch_array($result))
		{
			$newSCNO = $row["intSRNO"];
			break;
		}
		$matcde = $newSCNO . "-" . $itemCode .  "-". getCharforID($charpos); 
		
		//$sql = "UPDATE materialratio SET strMatDetailID ='$itemCode', materialRatioID = '$matcde' WHERE strMatDetailID ='$currentItemCode' AND intStyleId = '$styleNo' AND (intStatus != '0' or intStatus IS NULL);";
                $sql = "UPDATE materialratio SET strMatDetailID ='$itemCode', materialRatioID = '$matcde' WHERE strMatDetailID ='$currentItemCode' AND intStyleId = '$styleNo';";
                //echo $sql;
		$db->executeQuery($sql);
	}
	//Start - 20-08-2010 (Comment this because when edit a item material ratio must update)
	//$result = UpdateSpecificationDetails($styleNo,$currentItemCode,$itemCode,$unitType,$unitPrice,$conPc,$wastage,$purchaseType,$orderType,$placement,$ratioType,$reqQty,$totalQty,$totalValue,$costPC,$freight,$originid);
	//End - 20-08-2010 (Comment this because when edit a item material ratio must update)
	
	$oldPurchaseType =   $_GET["purchaseType"];
	$oldTotalQty = $_GET["totalQty"];
	
	$sql = "SELECT strPurchaseMode, dblTotalQty FROM specificationdetails WHERE intStyleId = '$styleNo' AND strMatDetailID = '$itemCode' AND (intStatus = '1' or intStatus IS NULL)";
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
		$sql = "UPDATE materialratio SET dblQty = round((dblQty / $oldTotalQty )* $totalQty) WHERE  intStyleId = '$styleNo' AND strMatDetailID = '$itemCode' AND (intStatus != '0' or intStatus IS NULL)";
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
	$styleNo		= $_GET["styleNo"];
	$ItemCode 		= $_GET["ItemID"];
	$purchaseType 	= $_GET["purchaseType"];	
	
	UpdatePurchaseType($styleNo,$ItemCode,$purchaseType);
	if ($purchaseType == "COLOR" || $purchaseType == "BOTH")
	{
		DeleteContrast($styleNo,$ItemCode);
		
	}
	resetMatRatio($styleNo,$itemCode,$purchaseType);
}
else if (strcmp($RequestType,"GetBuyerPOListForStyle") == 0)
{
	 $ResponseXML = "";
	 $styleID = $_GET["StyleNO"];
	 $ResponseXML .= "<RequestDetails>\n";
	 $result=getBuyerPOListByStyle($styleID);
	 
	 while($row = mysql_fetch_array($result))
  	 {
		 /*$ResponseXML .= "<PONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></PONO>\n";
         $ResponseXML .= "<QTY><![CDATA[" . $row["dblQty"]  . "]]></QTY>\n";   
		 $ResponseXML .= "<CountryCode><![CDATA[" . $row["strCountryCode"]  . "]]></CountryCode>\n";
		  $ResponseXML .= "<BuyerPoName><![CDATA[" . $row["strBuyerPoName"]  . "]]></BuyerPoName>\n";*/           
		  
		 $ResponseXML .= "<PONO><![CDATA[" . $row["intBPO"]  . "]]></PONO>\n";
         $ResponseXML .= "<QTY><![CDATA[" . $row["dblQty"]  . "]]></QTY>\n";   
		 $ResponseXML .= "<CountryCode><![CDATA[" . $row["intCountry"]  . "]]></CountryCode>\n";
		 $ResponseXML .= "<BuyerPoName><![CDATA[" . $row["intBPO"]  . "]]></BuyerPoName>\n";
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
	$styleNo 	= $_GET["styleNo"];
	$buyerPONo 	= $_GET["buyerPONo"];
	$color 		= $_GET["color"];
	$size 		= $_GET["size"];
	$sizeserial = $_GET["sizeserial"];
	$qty 		= $_GET["qty"];
	$exQty 		= $_GET["exQty"];
	$userID 	= $_SESSION["UserID"];
	
	// Check if the size exist in the style ratio table
	$sql = " select distinct styleratio.intserial from `styleratio` WHERE styleratio.intStyleId = '$styleNo' AND styleratio.strSize = '$size' ";
	$resSerial = $db->RunQuery($sql);
	
	if(mysql_num_rows($resSerial)){
		$rowResult = mysql_fetch_row($resSerial);
		$sizeserial = $rowResult[0];	
	}else{
		
		$sql1 = " SELECT Max(styleratio.intserial) as MaxSerial FROM styleratio WHERE styleratio.intStyleId =  '$styleNo'";
		$resMaxSerial = $db->RunQuery($sql1);
		
		if(mysql_num_rows($resMaxSerial)){
			$rowMaxSerial = mysql_fetch_row($resMaxSerial);
			$sizeserial = $rowMaxSerial[0] + 1; 
		}else{
			$sizeserial = 0;
		}
	}
	
	
	
			     
				
				
	 $SQL2 = " SELECT *
FROM `styleratio`
WHERE
styleratio.intStyleId = '$styleNo' AND
styleratio.strSize = '$size' AND
styleratio.strColor = '$color' AND
styleratio.strBuyerPONO = '$buyerPONo';";
			$result2 = $db->RunQuery($SQL2);
			if(mysql_num_rows($result2))
				{
						
						 UpdateStyleRatio1($styleNo,$buyerPONo,$color,$size,$qty,$exQty,$userID,$sizeserial);
				}
					else
					{
			     		SaveStyleRatio($styleNo,$buyerPONo,$color,$size,$qty,$exQty,$userID,$sizeserial);
					}
	            
				
}
else if(strcmp($RequestType,"SaveStyleRatio1") == 0)
{
	$styleNo 	= $_GET["styleNo"];
	$buyerPONo 	= $_GET["buyerPONo"];
	$color 		= $_GET["color"];
	$size 		= $_GET["size"];
	$sizeserial = $_GET["sizeserial"];
	$qty 		= $_GET["qty"];
	$exQty 		= $_GET["exQty"];
	$userID 	= $_SESSION["UserID"];
	
 UpdateStyleRatio($styleNo,$buyerPONo,$color,$size,$qty,$exQty,$userID,$sizeserial);
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
	$sizeserial     = $_GET["sizeserial"];
   
        $yyQty        = $_GET["yyQty"];
        $wastage      = $_GET["wastage"];
        $moq          = $_GET["moq"];
	$sizeserial = $_GET["sizeserial"];
        
        if($yyQty==''){
            $yyQty=0;
        }
        
        if($wastage==''){
            $wastage=0;
        }
        
        if($moq==''){
            $moq=0;
        }
        
  
	$purchasedQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 0);
	$purchasedFreightQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 1);
	
	//start 2010-11-29 getconfirmed Bulk allocation Qty
	//===========================================================================
	// Comment On - 10/15/2015
	// Comment By - Nalin Jayakody
	// Description - Set zero to the bulk allocation qty and left allocation qty 
	//===========================================================================
	/*$bulkAlloQty = confirmgetBulkAlloQty($styleNo,$buyerPONo,$item,$color, $size);
	/$leftAlloQty = confirmLeftOverQty($styleNo,$buyerPONo,$item,$color, $size);*/
	//===========================================================================
	
	$bulkAlloQty = 0;
	$leftAlloQty = 0;
	
	//end 2010-11-29
	
	//start 2011-09-06 get confirmed Recut qty
	//===========================================================================
	// Comment On - 10/15/2015
	// Comment By - Nalin Jayakody
	// Description - Set zero to the bulk allocation qty and left allocation qty 
	//===========================================================================
	$totQty = getTotalSpecItemQty($styleNo,$item);
	/*$confirmRecutQty =  getConfirmRecutQty($styleNo,$item);
	$recutQty = round($confirmRecutQty/$totQty*$qty);*/
	//===========================================================================
	
	$confirmRecutQty = 0;
	$recutQty		 = 0;
	
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
	SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$userID,$dblFreightBal,$matcde,$recutQty,$sizeserial,$yyQty,$wastage,$moq);
}
else if(strcmp($RequestType,"DelStyRatio") == 0)
{
	$styleNo = $_GET["styleNo"];
	$buyerPONo = $_GET["buyerPONo"];
	saveToHistoryStyle($styleNo,$buyerPONo);
	saveToHistoryMaterialRatio($styleNo,$buyerPONo);
	// ==================================================
	// Comment By - Nalin Jayakody
	// Comment On - 12/10/2015
	// Comment For - Duplicating the same query under the  different function name  
	// ==================================================
	# DeleteStyleRatio($styleNo,$buyerPONo);
	// ==================================================
	
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
		 // Comment On - 10/14/2015
		 // Comment By - Nalin Jayakody
		 // Description - Change to deliveryschedule from style_buyerponos
		 //===============================================================
		 //$sql_bp="select dblQty from  style_buyerponos where intStyleId='$styleNo' and strBuyerPONO='$buyerPONo'";
		 //===============================================================
		 
		 $sql_bp = " SELECT dblQty FROM deliveryschedule WHERE deliveryschedule.intBPO = '$buyerPONo' AND deliveryschedule.intStyleId = '$styleNo'";
		 //echo $sql_bp;
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
		 $ResponseXML .= "<intserial><![CDATA[" . $row["intserial"]  . "]]></intserial>\n";
		  $ResponseXML .= "<FOB><![CDATA[" . $row["dblFOB"]  . "]]></FOB>\n"; 
		 $ResponseXML .= "<PackQty><![CDATA[" . $row["dblPackQty"]  . "]]></PackQty>\n";      
		                 
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}
else if (strcmp($RequestType,"GetMatRatio") == 0)
{
	 $ResponseXML = "";
	 $styleNo 	= $_GET["styleNo"];
	 $buyerPONo = $_GET["buyerPONo"];
	 $ItemID 	=  $_GET["ItemID"];
	 $userId       = $_SESSION["UserID"]; 
         
	$sql_waste= "SELECT role.RoleName
                 FROM userpermission Inner Join role ON role.RoleID = userpermission.RoleID
                 WHERE userpermission.intUserID ='$userId' AND role.RoleName ='Wastage Percentage'";
		 $result_waste=$db->RunQuery($sql_waste);
          //echo $sql_waste;   
         
         $class_permission->SetConnection($db);
         $resPermission = $class_permission->IsPermissionAllowed($userId,'yardage yield (YY)');
          
    echo $ResponseXML;
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
		 // Set N/A qty to zero when update purchase type 'BOTH'
		$sqlUpdate = "UPDATE materialratio SET dblQty = 0, dblBalQty = 0 WHERE intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo' and strSize = 'N/A'  and strColor = 'N/A' AND strMatDetailID = '$ItemID' ";
		//$db->executeQuery($sqlUpdate);
		 
		 $sql_bp="select dblQty from  style_buyerponos where intStyleId='$styleNo' and strBuyerPONO='$buyerPONo'";
		 $result_bp=$db->RunQuery($sql_bp);
		 $row_bp=mysql_fetch_array($result_bp);
		 $bdlBuyerPoNo = $row_bp["dblQty"];
	}
	
	 $result=getMatRatioDetails($styleNo,$buyerPONo,$ItemID);
         $result2=getMatRatioDetails($styleNo,$buyerPONo,$ItemID);
         $result3=getMatRatioDetails($styleNo,$buyerPONo,$ItemID);
	 $ResponseXML .= "<TotalBuyerPoNo><![CDATA[" . $bdlBuyerPoNo  . "]]></TotalBuyerPoNo>\n";
	 // echo mysql_num_rows($result);
	 #========================================================================================
	 # Add On - 11/17/2015
	 # Add By - Nalin Jayakody
	 # Add For - Check if ratio not exist in matrial ratio table, then get size and color ratio from template 
	 #========================================================================================
	 $_isRowExist = 0;
         //echo (mysql_num_rows($result));
         switch(mysql_num_rows($result)){
             
            case 0:
                
                // There are no any records in the BOM system will display any template available in the system.
                $resTemplateRatio = GetRatioTemplate($styleNo, $ItemID);
                
                while($row = mysql_fetch_array($resTemplateRatio)){
			
                    $wastage = $row["dblWastage"];
                    
			 $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
			 $ResponseXML .= "<BuyerPONo><![CDATA[" . $buyerPONo  . "]]></BuyerPONo>\n";   
			 $ResponseXML .= "<MatID><![CDATA[" . $row["intMatDetailId"]  . "]]></MatID>\n";
			 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";   
			 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
					
			 $ResponseXML .= "<wastage><![CDATA[" .  $wastage  . "]]></wastage>\n";
             $ResponseXML .= "<yyCon><![CDATA[" . $row["dblYYConsumption"]  . "]]></yyCon>\n";
             $ResponseXML .= "<moq><![CDATA[" . $row["intMoq"]  . "]]></moq>\n";
             
			 $ResponseXML .= "<Qty><![CDATA[" . 0  . "]]></Qty>\n";   
			 $ResponseXML .= "<BalQty><![CDATA[" . 0  . "]]></BalQty>\n"; 
			 $ResponseXML .= "<PoQty><![CDATA[" . 0  . "]]></PoQty>\n";
			 $ResponseXML .= "<totPoQty><![CDATA[" . 0  ."]]></totPoQty>\n";
			 $ResponseXML .= "<interJobQty><![CDATA[" . 0  ."]]></interJobQty>\n";
			 $ResponseXML .= "<ColorPoDone><![CDATA[" . 0  . "]]></ColorPoDone>\n"; //po not done for colors
			 $ResponseXML .= "<SizePoDone><![CDATA[" . 0  . "]]></SizePoDone>\n"; //po not done for size		
  
				if(mysql_num_rows($resPermission)>0){
					$ResponseXML .= "<PermissionAllowed><![CDATA[" . 1 . "]]></PermissionAllowed>\n";        
				}else{
					$ResponseXML .= "<PermissionAllowed><![CDATA[" . 0 . "]]></PermissionAllowed>\n";
				}   

				if(mysql_num_rows($result_waste)>0){
					$ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 1 . "]]></PermissionAllowedWaste>\n";        
				}else{
					$ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 0 . "]]></PermissionAllowedWaste>\n";    
				}
			 
		 }
                
                 
            break;
        
            case 1:
                
                $arrBOM = mysql_fetch_row($result); 
                
                $strColor = $arrBOM[2];
                $strSize  = $arrBOM[3];
                
                if(($strColor == "N/A") && ($strSize == "N/A")){
                    
                    $resTemplateRatio1 = GetRatioTemplate($styleNo, $ItemID);
                
                    while($row = mysql_fetch_array($resTemplateRatio1)){
                        
                        $wastage = $row["dblWastage"];
                                              
                        $ResponseXML .= "<BuyerPONo><![CDATA[" . $buyerPONo  . "]]></BuyerPONo>\n";   
                        $ResponseXML .= "<MatID><![CDATA[" . $row["intMatDetailId"]  . "]]></MatID>\n";
                         $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
                        $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";   
                        $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
						$ResponseXML .= "<wastage><![CDATA[" . $wastage  . "]]></wastage>\n";
                        $ResponseXML .= "<yyCon><![CDATA[" . $row["dblYYConsumption"]  . "]]></yyCon>\n";
                        $ResponseXML .= "<moq><![CDATA[" . $row["intMoq"]  . "]]></moq>\n";
                        
                        $ResponseXML .= "<Qty><![CDATA[" . 0  . "]]></Qty>\n";   
                        $ResponseXML .= "<BalQty><![CDATA[" . 0  . "]]></BalQty>\n"; 
                        $ResponseXML .= "<PoQty><![CDATA[" . 0  . "]]></PoQty>\n";
                        $ResponseXML .= "<totPoQty><![CDATA[" . 0  ."]]></totPoQty>\n";
                        $ResponseXML .= "<interJobQty><![CDATA[" . 0  ."]]></interJobQty>\n";
                        $ResponseXML .= "<ColorPoDone><![CDATA[" . 0  . "]]></ColorPoDone>\n"; //po not done for colors
                        $ResponseXML .= "<SizePoDone><![CDATA[" . 0  . "]]></SizePoDone>\n"; //po not done for size		
                        if(mysql_num_rows($resPermission)>0){
                        $ResponseXML .= "<PermissionAllowed><![CDATA[" . 1 . "]]></PermissionAllowed>\n";        
                        }else{
                                $ResponseXML .= "<PermissionAllowed><![CDATA[" . 0 . "]]></PermissionAllowed>\n";
                        }   

                        if(mysql_num_rows($result_waste)>0){
                                $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 1 . "]]></PermissionAllowedWaste>\n";        
                        }else{
                                $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 0 . "]]></PermissionAllowedWaste>\n";    
                        }
                     }
                    
                    while($row = mysql_fetch_array($result3)){
                        
                        $wastage = $row["dblWastage"];
                        
                        $poQty			= getPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);		 
			$colorPoQty		= getColorPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"]);
			$sizePoQty		= getSizePoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strSize"]);
			$getTotalPoQty	= getTotalPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);
			$interJobQty	= getInterJobQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);
			//End   31-03-2010  (Get purchase qty and purchase color and size)
			 
			 $ResponseXML .= "<BuyerPONo><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONo>\n"; 
                         $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
			 $ResponseXML .= "<MatID><![CDATA[" . $row["strMatDetailID"]  . "]]></MatID>\n";
			 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";   
			 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
			 $ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";   
			 $ResponseXML .= "<BalQty><![CDATA[" . $row["dblBalQty"]  . "]]></BalQty>\n"; 
     
                         $ResponseXML .= "<wastage><![CDATA[" .  $wastage  . "]]></wastage>\n";
                         $ResponseXML .= "<yyCon><![CDATA[" . $row["dblYYConsumption"]  . "]]></yyCon>\n";
                         $ResponseXML .= "<moq><![CDATA[" . $row["intMoq"]  . "]]></moq>\n";
			//Start 31-03-2010 (Get purchase qty and purchase color and size)
			  $ResponseXML .= "<PoQty><![CDATA[" . $poQty  . "]]></PoQty>\n";
			   $ResponseXML .= "<totPoQty><![CDATA[" . $getTotalPoQty  ."]]></totPoQty>\n";
			 $ResponseXML .= "<interJobQty><![CDATA[" . $interJobQty  ."]]></interJobQty>\n";
			 if($colorPoQty>0)
				$ResponseXML .= "<ColorPoDone><![CDATA[" . 1  . "]]></ColorPoDone>\n"; //po done for colors
			 else
				$ResponseXML .= "<ColorPoDone><![CDATA[" . 0  . "]]></ColorPoDone>\n"; //po not done for colors
				
			if($sizePoQty>0)
				$ResponseXML .= "<SizePoDone><![CDATA[" . 1  . "]]></SizePoDone>\n"; //po done for size
			 else
				$ResponseXML .= "<SizePoDone><![CDATA[" . 0  . "]]></SizePoDone>\n";
  
                        if(mysql_num_rows($resPermission)>0){
                            $ResponseXML .= "<PermissionAllowed><![CDATA[" . 1 . "]]></PermissionAllowed>\n";        
                        }else{
                            $ResponseXML .= "<PermissionAllowed><![CDATA[" . 0 . "]]></PermissionAllowed>\n";
                        }   

                        if(mysql_num_rows($result_waste)>0){
                            $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 1 . "]]></PermissionAllowedWaste>\n";        
                        }else{
                            $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 0 . "]]></PermissionAllowedWaste>\n";    
                        }
                       
					   
                    }
                    
                   /* $resTemplateRatio1 = GetRatioTemplate($styleNo, $ItemID);
                
                    while($row = mysql_fetch_array($resTemplateRatio1)){
                        
                        $wastage = $row["dblWastage"];
                                              
                        $ResponseXML .= "<BuyerPONo><![CDATA[" . $buyerPONo  . "]]></BuyerPONo>\n";   
                        $ResponseXML .= "<MatID><![CDATA[" . $row["intMatDetailId"]  . "]]></MatID>\n";
                         $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
                        $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";   
                        $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
						$ResponseXML .= "<wastage><![CDATA[" . $wastage  . "]]></wastage>\n";
                        $ResponseXML .= "<yyCon><![CDATA[" . $row["dblYYConsumption"]  . "]]></yyCon>\n";
                        $ResponseXML .= "<moq><![CDATA[" . $row["intMoq"]  . "]]></moq>\n";
                        
                        $ResponseXML .= "<Qty><![CDATA[" . 0  . "]]></Qty>\n";   
                        $ResponseXML .= "<BalQty><![CDATA[" . 0  . "]]></BalQty>\n"; 
                        $ResponseXML .= "<PoQty><![CDATA[" . 0  . "]]></PoQty>\n";
                        $ResponseXML .= "<totPoQty><![CDATA[" . 0  ."]]></totPoQty>\n";
                        $ResponseXML .= "<interJobQty><![CDATA[" . 0  ."]]></interJobQty>\n";
                        $ResponseXML .= "<ColorPoDone><![CDATA[" . 0  . "]]></ColorPoDone>\n"; //po not done for colors
                        $ResponseXML .= "<SizePoDone><![CDATA[" . 0  . "]]></SizePoDone>\n"; //po not done for size		
                        if(mysql_num_rows($resPermission)>0){
                        $ResponseXML .= "<PermissionAllowed><![CDATA[" . 1 . "]]></PermissionAllowed>\n";        
                        }else{
                                $ResponseXML .= "<PermissionAllowed><![CDATA[" . 0 . "]]></PermissionAllowed>\n";
                        }   

                        if(mysql_num_rows($result_waste)>0){
                                $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 1 . "]]></PermissionAllowedWaste>\n";        
                        }else{
                                $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 0 . "]]></PermissionAllowedWaste>\n";    
                        }
                     }*/
                }else {
                    
                    //echo mysql_num_rows($result);
                    while($row = mysql_fetch_array($result2)){
                    
                        $wastage = $row["dblWastage"];
                       
                    $poQty			= getPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);		 
                    $colorPoQty		= getColorPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"]);
                    $sizePoQty		= getSizePoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strSize"]);
                    $getTotalPoQty	= getTotalPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);
                    $interJobQty	= getInterJobQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);
                    //End   31-03-2010  (Get purchase qty and purchase color and size)
                   
                     $ResponseXML .= "<BuyerPONo><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONo>\n";   
                     $ResponseXML .= "<MatID><![CDATA[" . $row["strMatDetailID"]  . "]]></MatID>\n";
                     $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";  
                       $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
                     $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
                     $ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";   
                     $ResponseXML .= "<BalQty><![CDATA[" . $row["dblBalQty"]  . "]]></BalQty>\n"; 
                     $ResponseXML .= "<PoQty><![CDATA[" . $poQty  . "]]></PoQty>\n";
                       $ResponseXML .= "<totPoQty><![CDATA[" . $getTotalPoQty  ."]]></totPoQty>\n";
                         $ResponseXML .= "<interJobQty><![CDATA[" . $interJobQty  ."]]></interJobQty>\n";
                         
                          if($colorPoQty>0)
                                $ResponseXML .= "<ColorPoDone><![CDATA[" . 1  . "]]></ColorPoDone>\n"; //po done for colors
                         else
                                $ResponseXML .= "<ColorPoDone><![CDATA[" . 0  . "]]></ColorPoDone>\n"; //po not done for colors
                        if($sizePoQty>0)
                                $ResponseXML .= "<SizePoDone><![CDATA[" . 1  . "]]></SizePoDone>\n"; //po done for size
                         else
                                $ResponseXML .= "<SizePoDone><![CDATA[" . 0  . "]]></SizePoDone>\n";
                     
                     $ResponseXML .= "<wastage><![CDATA[" .  $wastage  . "]]></wastage>\n";
                     $ResponseXML .= "<yyCon><![CDATA[" . $row["dblYYConsumption"]  . "]]></yyCon>\n";
                     $ResponseXML .= "<moq><![CDATA[" . $row["intMoq"]  . "]]></moq>\n";
                      if(mysql_num_rows($resPermission)>0){

                            $ResponseXML .= "<PermissionAllowed><![CDATA[" . 1 . "]]></PermissionAllowed>\n";        
                        }else{

                            $ResponseXML .= "<PermissionAllowed><![CDATA[" . 0 . "]]></PermissionAllowed>\n";
                        }   

                        if(mysql_num_rows($result_waste)>0){
                            $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 1 . "]]></PermissionAllowedWaste>\n";        
                        }else{
                            $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 0 . "]]></PermissionAllowedWaste>\n";    
                        }
                        
                        $poQty		= getPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);		 
                        $colorPoQty		= getColorPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"]);
                        $sizePoQty		= getSizePoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strSize"]);
                        $getTotalPoQty	= getTotalPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);
                        $interJobQty	= getInterJobQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);
                        //End   31-03-2010  (Get purchase qty and purchase color and size)
                         $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
                         $ResponseXML .= "<BuyerPONo><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONo>\n";   
                         $ResponseXML .= "<MatID><![CDATA[" . $row["strMatDetailID"]  . "]]></MatID>\n";
                         $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";   
                         $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
                         $ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";   
                         $ResponseXML .= "<BalQty><![CDATA[" . $row["dblBalQty"]  . "]]></BalQty>\n"; 
                         
                         $ResponseXML .= "<wastage><![CDATA[" .  $wastage  . "]]></wastage>\n";
                         $ResponseXML .= "<yyCon><![CDATA[" . $row["dblYYConsumption"]  . "]]></yyCon>\n";
                         $ResponseXML .= "<moq><![CDATA[" . $row["intMoq"]  . "]]></moq>\n";
                         //Start 31-03-2010 (Get purchase qty and purchase color and size)
                          $ResponseXML .= "<PoQty><![CDATA[" . $poQty  . "]]></PoQty>\n";
                           $ResponseXML .= "<totPoQty><![CDATA[" . $getTotalPoQty  ."]]></totPoQty>\n";
                         $ResponseXML .= "<interJobQty><![CDATA[" . $interJobQty  ."]]></interJobQty>\n";
                         if($colorPoQty>0)
                                $ResponseXML .= "<ColorPoDone><![CDATA[" . 1  . "]]></ColorPoDone>\n"; //po done for colors
                         else
                                $ResponseXML .= "<ColorPoDone><![CDATA[" . 0  . "]]></ColorPoDone>\n"; //po not done for colors
                        if($sizePoQty>0)
                                $ResponseXML .= "<SizePoDone><![CDATA[" . 1  . "]]></SizePoDone>\n"; //po done for size
                         else
                                $ResponseXML .= "<SizePoDone><![CDATA[" . 0  . "]]></SizePoDone>\n";
                        
						
						if($sizePoQty>0)
                            $ResponseXML .= "<SizePoDone><![CDATA[" . 1  . "]]></SizePoDone>\n"; //po done for size
                     else

                            $ResponseXML .= "<SizePoDone><![CDATA[" . 0  . "]]></SizePoDone>\n";
                     
                     
                     
                        if(mysql_num_rows($resPermission)>0){

                            $ResponseXML .= "<PermissionAllowed><![CDATA[" . 1 . "]]></PermissionAllowed>\n";        
                        }else{

                            $ResponseXML .= "<PermissionAllowed><![CDATA[" . 0 . "]]></PermissionAllowed>\n";
                        }   

                        if(mysql_num_rows($result_waste)>0){
                            $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 1 . "]]></PermissionAllowedWaste>\n";        
                        }else{
                            $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 0 . "]]></PermissionAllowedWaste>\n";    
                        }
                    }                   
                }
               
            break;
            
            default :
            
                while($row = mysql_fetch_array($result)){
                     
                     $wastage = $row["dblWastage"];
                
                    $poQty			= getPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);		 
                    $colorPoQty		= getColorPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"]);
                    $sizePoQty		= getSizePoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strSize"]);
                    $getTotalPoQty	= getTotalPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);
                    $interJobQty	= getInterJobQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);
                    //End   31-03-2010  (Get purchase qty and purchase color and size)
                     $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
                     $ResponseXML .= "<BuyerPONo><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONo>\n";   
                     $ResponseXML .= "<MatID><![CDATA[" . $row["strMatDetailID"]  . "]]></MatID>\n";
                     $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";   
                     $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
                     $ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";   
                     $ResponseXML .= "<BalQty><![CDATA[" . $row["dblBalQty"]  . "]]></BalQty>\n"; 
					 $ResponseXML .= "<wastage><![CDATA[" . $wastage  . "]]></wastage>\n";
                     $ResponseXML .= "<yyCon><![CDATA[" . $row["dblYYConsumption"]  . "]]></yyCon>\n";
                     $ResponseXML .= "<moq><![CDATA[" . $row["intMoq"]  . "]]></moq>\n";
                        
                     //Start 31-03-2010 (Get purchase qty and purchase color and size)
                      $ResponseXML .= "<PoQty><![CDATA[" . $poQty  . "]]></PoQty>\n";
                       $ResponseXML .= "<totPoQty><![CDATA[" . $getTotalPoQty  ."]]></totPoQty>\n";
                     $ResponseXML .= "<interJobQty><![CDATA[" . $interJobQty  ."]]></interJobQty>\n";
                     if($colorPoQty>0)
                            $ResponseXML .= "<ColorPoDone><![CDATA[" . 1  . "]]></ColorPoDone>\n"; //po done for colors
                     else
                            $ResponseXML .= "<ColorPoDone><![CDATA[" . 0  . "]]></ColorPoDone>\n"; //po not done for colors

                    if($sizePoQty>0)
                            $ResponseXML .= "<SizePoDone><![CDATA[" . 1  . "]]></SizePoDone>\n"; //po done for size
                     else
                            $ResponseXML .= "<SizePoDone><![CDATA[" . 0  . "]]></SizePoDone>\n";
						if(mysql_num_rows($resPermission)>0){
                            $ResponseXML .= "<PermissionAllowed><![CDATA[" . 1 . "]]></PermissionAllowed>\n";        
                        }else{
                            $ResponseXML .= "<PermissionAllowed><![CDATA[" . 0 . "]]></PermissionAllowed>\n";
                        }   

                        if(mysql_num_rows($result_waste)>0){
                            $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 1 . "]]></PermissionAllowedWaste>\n";        
                        }else{
                            $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 0 . "]]></PermissionAllowedWaste>\n";    
                        }
                        
                    }
                
            break;   
             
             
         }
         
                 
	 /*while($rowMatTmp = mysql_fetch_array($result)){

            $tmpColor = $rowMatTmp["strColor"];
            $tmpSize  = $rowMatTmp["strSize"];
            $tmpBuyerPO = $rowMatTmp["strBuyerPONO"];
                
                //echo $tmpColor;
                
            if(($tmpColor != "N/A") || ($tmpSize != "N/A")){
                   // $_isRowExist = 1;
                    //break;
            }

            if(($tmpColor == "N/A") && ($tmpSize == "N/A")){
                    $_isRowExist = 0;
                    break;
            }

            if($tmpBuyerPO == "#Main Ratio#"){ $_isRowExist = 0; }
	 }*/
          
	/* $isBuyerPOInMR = IsBuyerPOExistInMR($styleNo, $buyerPONo,$ItemID);
	 if($isBuyerPOInMR > 1){$_isRowExist = 1;} */
	 //echo "Record Status - ".$_isRowExist; 
	 //if(mysql_num_rows($result) == 0){
	 //if(($_isRowExist == 0) || (mysql_num_rows($result) == 0)){
        # ================================================
        /* if(($_isRowExist == '0')){
		
		 # Get ratio from ratio template table
		 $resTemplateRatio = GetRatioTemplate($styleNo, $ItemID);
		 
		 while($row = mysql_fetch_array($resTemplateRatio)){
			 
			 $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
			 $ResponseXML .= "<BuyerPONo><![CDATA[" . $buyerPONo  . "]]></BuyerPONo>\n";   
			 $ResponseXML .= "<MatID><![CDATA[" . $row["intMatDetailId"]  . "]]></MatID>\n";
			 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";   
			 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
			 $ResponseXML .= "<Qty><![CDATA[" . 0  . "]]></Qty>\n";   
			 $ResponseXML .= "<BalQty><![CDATA[" . 0  . "]]></BalQty>\n"; 
			 $ResponseXML .= "<PoQty><![CDATA[" . 0  . "]]></PoQty>\n";
			 $ResponseXML .= "<totPoQty><![CDATA[" . 0  ."]]></totPoQty>\n";
			 $ResponseXML .= "<interJobQty><![CDATA[" . 0  ."]]></interJobQty>\n";
			 $ResponseXML .= "<ColorPoDone><![CDATA[" . 0  . "]]></ColorPoDone>\n"; //po not done for colors
			 $ResponseXML .= "<SizePoDone><![CDATA[" . 0  . "]]></SizePoDone>\n"; //po not done for size		
			 
			$result_yy=getMatRatioDetailsYY($styleNo,$buyerPONo,$ItemID,$row["strColor"],$row["strSize"]);
									 $row_yy = mysql_fetch_array($result_yy);

									 $ResponseXML .= "<yyCon><![CDATA[" . $row_yy["dblYYConsumption"]  . "]]></yyCon>\n";
									 $ResponseXML .= "<wastage><![CDATA[" . $row_yy["dblWastage"]  . "]]></wastage>\n";
									 
									 
				if(mysql_num_rows($resPermission)>0){
					$ResponseXML .= "<PermissionAllowed><![CDATA[" . 1 . "]]></PermissionAllowed>\n";        
				}else{
					$ResponseXML .= "<PermissionAllowed><![CDATA[" . 0 . "]]></PermissionAllowed>\n";
				}   

				if(mysql_num_rows($result_waste)>0){
					$ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 1 . "]]></PermissionAllowedWaste>\n";        
				}else{
					$ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 0 . "]]></PermissionAllowedWaste>\n";    
				}

		
		 }
		 
	 }else{
                //echo "TEMP 1";
	 	$result4=getMatRatioDetails($styleNo,$buyerPONo,$ItemID);
		$i=0;
	 	 
		 while($row = mysql_fetch_array($result4))
		 {	
			 //Start 31-03-2010 (Get purchase qty and purchase color and size)
			$wastage[$i] = $row["dblWastage"];
			//echo "AAA".$row["dblWastage"]."XXX";
			$poQty			= getPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);		 
			$colorPoQty		= getColorPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"]);
			$sizePoQty		= getSizePoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strSize"]);
			$getTotalPoQty	= getTotalPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);
			$interJobQty	= getInterJobQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);
			//End   31-03-2010  (Get purchase qty and purchase color and size)
			 $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
			 $ResponseXML .= "<BuyerPONo><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONo>\n";   
			 $ResponseXML .= "<MatID><![CDATA[" . $row["strMatDetailID"]  . "]]></MatID>\n";
			 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";   
			 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
			 $ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";   
			 $ResponseXML .= "<BalQty><![CDATA[" . $row["dblBalQty"]  . "]]></BalQty>\n"; 
			 $ResponseXML .= "<yyCon><![CDATA[" . $row["dblYYConsumption"]  . "]]></yyCon>\n";
			 $ResponseXML .= "<wastage><![CDATA[" . $wastage[$i]  . "]]></wastage>\n";
			 //Start 31-03-2010 (Get purchase qty and purchase color and size)
			  $ResponseXML .= "<PoQty><![CDATA[" . $poQty  . "]]></PoQty>\n";
			   $ResponseXML .= "<totPoQty><![CDATA[" . $getTotalPoQty  ."]]></totPoQty>\n";
			 $ResponseXML .= "<interJobQty><![CDATA[" . $interJobQty  ."]]></interJobQty>\n";
			 if($colorPoQty>0)
				$ResponseXML .= "<ColorPoDone><![CDATA[" . 1  . "]]></ColorPoDone>\n"; //po done for colors
			 else
				$ResponseXML .= "<ColorPoDone><![CDATA[" . 0  . "]]></ColorPoDone>\n"; //po not done for colors
				
			if($sizePoQty>0)
				$ResponseXML .= "<SizePoDone><![CDATA[" . 1  . "]]></SizePoDone>\n"; //po done for size
			 else
				$ResponseXML .= "<SizePoDone><![CDATA[" . 0  . "]]></SizePoDone>\n"; //po not done for size 
	
	if(mysql_num_rows($resPermission)>0){
        $ResponseXML .= "<PermissionAllowed><![CDATA[" . 1 . "]]></PermissionAllowed>\n";        
    }else{
        $ResponseXML .= "<PermissionAllowed><![CDATA[" . 0 . "]]></PermissionAllowed>\n";
    }   

 if(mysql_num_rows($result_waste)>0){
        $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 1 . "]]></PermissionAllowedWaste>\n";        
    }else{
        $ResponseXML .= "<PermissionAllowedWaste><![CDATA[" . 0 . "]]></PermissionAllowedWaste>\n";    
    }
			 //End   31-03-2010 (Get purchase qty and purchase color and size)           
		 }
	 } */
         # ================================================
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
	 $i=0;
	 
	 while($row = mysql_fetch_array($result))
  	 {
	 	 $poQty=getPoQty($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"]);
		 
		$wastage[$i] = $row["dblWastage"];
		 		 
		 $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
         $ResponseXML .= "<BuyerPONo><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONo>\n";   
		 $ResponseXML .= "<MatID><![CDATA[" . $row["strMatDetailID"]  . "]]></MatID>\n";
		 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";   
		 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
         $ResponseXML .= "<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";   
		 $ResponseXML .= "<BalQty><![CDATA[" . $row["dblBalQty"]  . "]]></BalQty>\n";
		 $ResponseXML .= "<PoQty><![CDATA[" . $poQty  . "]]></PoQty>\n";
		 
		 $ResponseXML .= "<yyCon><![CDATA[" . $row["dblYYConsumption"]  . "]]></yyCon>\n";
		 $ResponseXML .= "<wastage><![CDATA[" . $wastage[$i]  . "]]></wastage>\n";
                 
            $i++; 
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


else if(strcmp($RequestType,"loadRR") == 0)
{
	
   $ResponseXML = "";
   $styleNo = $_GET["styleNo"];
   $buyerPONo = $_GET["buyerPONo"];
   $matID = $_GET["ItemID"];
   $ResponseXML .= "<RequestDetails>\n";        
    
     
    $result=getHistoryMatRatio($styleNo,$buyerPONo,$matID);

	 while($row = mysql_fetch_array($result))
  	 {
             		 		 
		 $ResponseXML .= "<StyleNo><![CDATA[" . $row["intStyleId"]  . "]]></StyleNo>\n";
                 $ResponseXML .= "<BuyerPONo><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONo>\n";   
		 $ResponseXML .= "<MatID><![CDATA[" . $row["strMatDetailID"]  . "]]></MatID>\n";
		 $ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";   
		 $ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
                 $ResponseXML .= "<Qty><![CDATA[" . $row["dblYYConsumption"]  . "]]></Qty>\n";   
		 $ResponseXML .= "<serialNo><![CDATA[" . $row["serialNo"]  . "]]></serialNo>\n";
	
	
	 }
    $ResponseXML .= "</RequestDetails>";
    echo $ResponseXML;		
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
	
	$SQL = "SELECT
orders.intStyleId,
orders.strOrderNo,
specification.intSRNO
FROM
orders
left Join specification ON orders.intStyleId = specification.intStyleId
where intStatus  =11";
		
	if($stytleName != 'Select One' && $stytleName != '')
		$SQL .= " and strStyle='$stytleName' ";
		
		$SQL .= " order by strOrderNo ";
		//echo $SQL;		
	$result = $db->RunQuery($SQL);
		//$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		$str1 .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="<srNo><![CDATA[" .$str1. "]]></srNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"getStyleWiseOrderDetails")==0)
{
	$ResponseXML="";
	$orderName = $_GET["orderName"];
	
	$SQL = "SELECT
orders.intStyleId,
orders.strOrderNo,
specification.intSRNO,
orders.strStyle
FROM
orders
left Join specification ON orders.intStyleId = specification.intStyleId
where   intUserID = " . $_SESSION["UserID"] . " and  intStatus  =11";
		
	if($stytleName != 'Select One' && $stytleName != '')
		$SQL .= " and strStyle='$stytleName' ";
		
		$SQL .= " order by strOrderNo ";
		//echo $SQL;		
	$result = $db->RunQuery($SQL);
		//$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	
	$ResponseXML.="<styleNoList>";
	$ResponseXML.="<styleNo><![CDATA[" .$str. "]]></styleNo>\n";
	$ResponseXML.="</styleNoList>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"getSCWiseStyleDetails")==0)
{
	$ResponseXML="";
	$scNo = $_GET["scNo"];
	
	$SQL = "SELECT
orders.intStyleId,
orders.strOrderNo,
specification.intSRNO,
orders.strStyle
FROM
orders
left Join specification ON orders.intStyleId = specification.intStyleId
where  intStatus  =11";
		
	if($scNo != 'Select One' && $scNo != '')
		$SQL .= " and orders.intStyleId='$scNo' ";
		
		$SQL .= " order by strOrderNo ";
		//echo $SQL;		
	$result = $db->RunQuery($SQL);
		//$str .= "<option value=\"".""."\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		$str1 .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<styleNoLists>";
	$ResponseXML.="<styleNos><![CDATA[" .$str. "]]></styleNos>\n";
	$ResponseXML.="<ordersNos><![CDATA[" .$str1. "]]></ordersNos>\n";
	$ResponseXML.="</styleNoLists>";
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
elseif($RequestType=="getItemUnitprice")
{
	$itemCode = $_GET["itemCode"];
	$style = $_GET["style"];
	$itemUnitprice = getItemUnitPriceDetails($itemCode,$style);
	
	$ResponseXML.="<XMLItemUnitprice>\n";
	$ResponseXML.="<itemUnitprice><![CDATA[" .$itemUnitprice. "]]></itemUnitprice>\n";
	$ResponseXML.="</XMLItemUnitprice>";
	echo $ResponseXML;
}
elseif($RequestType=="CheckRatio")
{
	$ResponseXML = "";
	
	$styleId	= $_GET['styleNo'];
	$itemCode	= $_GET['itemCode'];
	
	$MatRatioCount = GetMaterialRatioTemplate($styleId, $itemCode);
	
	$ResponseXML.="<XMLRatioCount>\n";
	$ResponseXML.="<ratiocount><![CDATA[" .$MatRatioCount. "]]></ratiocount>\n";	
	$ResponseXML.="</XMLRatioCount>\n";
	
	echo $ResponseXML;
	
}
elseif($RequestType=="SaveRatioTemplate"){
	
	$styleId	= $_GET['styleNo'];
	$itemCode	= $_GET['itemCode'];
	$buyerPO	= $_GET['buyerpo'];
	$color		= $_GET['color'];
	$size		= $_GET['size'];
	$sequenceNo	= $_GET['sequnce'];
	
	SaveRatioTemplate($styleId, $itemCode, $buyerPO, $color, $size, $sequenceNo);
}
elseif ($RequestType=="GetMaxSerial") {

	$ResponseXML = "";

	$styleId	= $_GET['styleNo'];
	
	$sql = "select max(intserial) as max_serial from styleratio where intStyleId = '$styleId'  AND intStatus = '1'";

	$result = $db->RunQuery($sql);

	$resArray = mysql_fetch_row($result);

	$ResponseXML = "<MAXSerial>\n";
	$ResponseXML.="<serialCount><![CDATA[" .$resArray[0]. "]]></serialCount>\n";
	$ResponseXML.= "</MAXSerial>";

	echo $ResponseXML;
}
elseif ($RequestType=="UpdateMaxSerial") {
	# code...
	$styleId	= $_GET['styleNo'];
	$MaxSerial  = $_GET['maxserial'];

	$sqlUpdate  = "UPDATE styleratio SET intserial = '$MaxSerial' WHERE intStyleId = '$styleId' AND strBuyerPONO = '#Main Ratio#' AND strColor = 'N/A' AND strSize = 'N/A' ";
	$db->ExecuteQuery($sqlUpdate);
}
elseif ($RequestType=="chkBpoCon") {
	# code...
	$styleId	= $_GET['styleId'];
	$bpoNo  = $_GET['bpoNo'];
        $itemId  = $_GET['itemId'];

        
        $sql = "SELECT
        materialratio.intStyleId,
        materialratio.strMatDetailID,
        materialratio.strBuyerPONO,
        sum(materialratio.dblYYConsumption) as SumOfCon,
        materialratio.intStatus
        FROM
        materialratio
        WHERE
        materialratio.intStyleId = '$styleId' AND
        materialratio.strMatDetailID = '$itemId' AND
        materialratio.intStatus = 1 AND
        materialratio.strBuyerPONO NOT IN('#Main Ratio#','$bpoNo') 
        GROUP BY materialratio.strBuyerPONO,materialratio.intStyleId";

	$result = $db->RunQuery($sql);
        $row=mysql_fetch_array($result);
            if($sumOfCon>0){
                $sumOfCon=$row['SumOfCon'];
            }
            else{
                $sumOfCon=0;
               // echo "YYY".$sumOfCon;
            }
        echo $sumOfCon;
}
elseif ($RequestType=="IsPORaised") {
	
	$styleId = $_GET['styleCode'];
	$ItemID  = $_GET['ItemCode'];
	
	$sql = " SELECT * FROM purchaseorderdetails WHERE intStyleId = '$styleId' AND purchaseorderdetails.intMatDetailID = '$ItemID' ";
	$result = $db->RunQuery($sql);
	
	$ResponseXML = "";
	$ResponseXML = "<POExistItem>\n";
	if(mysql_num_rows($result)>0){
		$ResponseXML.="<IsPOExist><![CDATA[1]]></IsPOExist>\n";
	}else{
		$ResponseXML.="<IsPOExist><![CDATA[0]]></IsPOExist>\n";	
	}

	$ResponseXML .= "</POExistItem>";

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

function getItemHighUnitPrice($styleID,$materialID)
{
	global $db;
	$sql="select COALESCE(Sum(purchaseorderdetails.dblQty),0) as purchasedQty, MAX(purchaseorderdetails.dblUnitPrice) as maxUnitPrice from purchaseorderdetails inner join purchaseorderheader on purchaseorderheader.intPONo = purchaseorderdetails.intPONo where intStyleId = '$styleID' AND purchaseorderdetails.intMatDetailID = '$materialID' AND purchaseorderdetails.intPOType=0 and purchaseorderheader.intStatus = 10;";

	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["maxUnitPrice"];
		
	}
}

function getItemUnitPriceDetails($itemCode,$style)
{
		global $db;
		$sql = " select dblUnitPrice from orderdetails where orderdetails.intMatDetailID ='$itemCode' and orderdetails.intStyleId='$style' ";
		$result = $db->RunQuery($sql);
		$row = mysql_fetch_array($result);
		
		return $row["dblUnitPrice"];
}

function UpdateSpecificationDetails($styleNo,$currentItemCode,$itemCode,$unitType,$unitPrice,$conPc,$wastage,$purchaseType,$orderType,$placement,$ratioType,$reqQty,$totalQty,$totalValue,$costPC,$freight,$originid)
{
	global $db;
        
        // Add By - Nalin Jayakody
        // Add On - 08/30/2016
        // Adding - Check whether change item code exist in the table then update accroding to it
        // ======================================================================================
        $concatcode = "0";
        
        $sql1 = "SELECT * FROM specificationdetails WHERE strMatDetailID = '" . $itemCode. "' AND intStyleId = '" . $styleNo . "'";
        //echo $sql1;
        $res = $db->RunQuery($sql1);
        
        if($currentItemCode != $itemCode){
            if(mysql_num_rows($res)>0){
                $concatcode = $itemCode.$currentItemCode;
                $sql2="update specificationdetails set strMatDetailID = '" . $concatcode . "' WHERE intStyleId = '" . $styleNo . "' AND strMatDetailID = '" . $itemCode . "'";
                $db->executeQuery($sql2);
            }
        }
        
        // ======================================================================================
	$sql="update specificationdetails set strMatDetailID = '" . $itemCode . "', strUnit = '" . $unitType . "' , dblUnitPrice = " . $unitPrice . ", sngConPc = " . $conPc . ", sngWastage = " . $wastage . ", strPurchaseMode = '" . $purchaseType . "' , strOrdType = '" . $orderType . "' ,strPlacement = '" . $placement . "' , intRatioType = " . $ratioType . ", dblReqQty = " . $reqQty . ", dblTotalQty = " . $totalQty . ", dblTotalValue = " . $totalValue . ", dblCostPC = " . $costPC . ", dblfreight = " . $freight . ", intOriginNo = " . $originid . " , intStatus = '1' where intStyleId = '" . $styleNo . "' AND strMatDetailID = '" . $currentItemCode . "'";
        //echo $sql;
	$db->executeQuery($sql);
        
        // =======================================================================================
        $sql3 = "update specificationdetails set strMatDetailID = '" . $currentItemCode . "' WHERE intStyleId = '" . $styleNo . "' AND strMatDetailID = '" . $concatcode . "'";
       // $db->executeQuery($sql3);
        // =======================================================================================
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
	$sql=" delete from specificationdetails where intStyleId = '" . $styleNo . "' AND strMatDetailID = '" . $itemCode . "';";

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
	$sql="insert into specificationdetails 	(intStyleId, 	strMatDetailID, 	strUnit, 	dblUnitPrice, 	sngConPc, 	sngWastage, 	strPurchaseMode, 	strOrdType, 	strPlacement, 	intRatioType, 	dblReqQty, 	dblTotalQty, 	dblTotalValue, 	dblCostPC, 	dblfreight, 	intOriginNo , intStatus	)	values	('$strStyleID', '$strMatDetailID', '$strUnit', $dblUnitPrice, $sngConPc, $sngWastage, '$strPurchaseMode', '$strOrdType', '$strPlacement', '$intRatioType', $dblReqQty, $dblTotalQty, $dblTotalValue, $dblCostPC, $dblfreight, $intOriginNo, '1');";


	$db->executeQuery($sql);
	return true;
}


function getBuyerPOListByStyle($styleID)
{
	global $db;
	// =========================================================
	// Comment On - 10/13/2015
	// Comment By - Nalin Jayakody
	// Description - Change style_buyerponos table to delivery schedule table
	// =========================================================
	//$sql="SELECT  strBuyerPoName,strBuyerPONO,dblQty,strCountryCode FROM style_buyerponos where intStyleId  = '" . $styleID . "';";
	
	// =========================================================
	
	$sql = " SELECT deliveryschedule.intBPO, deliveryschedule.dblQty, deliveryschedule.intCountry FROM deliveryschedule WHERE deliveryschedule.intStyleId = '" . $styleID . "';";
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
	//$sql= "select distinct strSize from sizes where intCustomerID = " . $BuyerID . ";" ;
	$sql= "select distinct strSize from sizes where intCustomerID = " . $BuyerID . " limit 1130;" ;
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

function SaveStyleRatio($styleNo,$buyerPONo,$color,$size,$qty,$exQty,$userID,$sizeserial)
{
	global $db;
	$sql="insert into styleratio (intStyleId,strBuyerPONO,strColor,strSize,dblQty,dblExQty,strUserId,intserial,intStatus) values ('$styleNo','$buyerPONo','$color','$size',$qty,$exQty,'$userID','$sizeserial', '1');";

	$db->executeQuery($sql);
	return true;
}
function UpdateStyleRatio($styleNo,$buyerPONo,$color,$size,$qty,$exQty,$userID,$sizeserial)
{
	global $db;
	 $sql="UPDATE `styleratio` SET `intStatus`='0' WHERE (`intStyleId`='$styleNo') AND (`strBuyerPONO`='$buyerPONo');";
	//echo $sql="UPDATE `styleratio` SET `strColor`='$color', `strSize`='$size', `dblQty`='$qty', `dblExQty`='$exQty', `strUserId`='$userID', `intserial`='$sizeserial' WHERE (`intStyleId`='$styleNo') AND (`strBuyerPONO`='$buyerPONo') ;";

	$db->executeQuery($sql);
	return true;
}
function UpdateStyleRatio1($styleNo,$buyerPONo,$color,$size,$qty,$exQty,$userID,$sizeserial)
{
	global $db;
	 $sql="UPDATE `styleratio` SET `intStatus`='1', `dblQty`='$qty' , `dblExQty`='$exQty'  WHERE (`intStyleId`='$styleNo') AND (`strBuyerPONO`='$buyerPONo') AND (`strColor`='$color') AND (`strSize`='$size');";

	$db->executeQuery($sql);
	return true;
}

function DeleteStyleRatio($styleNo,$buyerPONo)
{
	global $db;
	/*===================================================================================================
	// Comment By - Nalin Jayakody
	// Comment On - 01/15/2016
	// Comment For - Because of duplicating same query, add 'styleratio' table instead of 'martialratio'
	===================================================================================================== */
	# $sql="update materialratio set intStatus = '0' where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo'";
	//===================================================================================================
	
	$sql = " update styleratio set intStatus = '0' where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo'";
	
	$db->executeQuery($sql);
	return true;
}

function getStyleRatioCount($styleNo,$buyerPONo)
{
	global $db;
	$sql= "select count(*) as recCount from styleratio  where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo' AND (intStatus != '0' or intStatus IS NULL);" ;
	return $db->RunQuery($sql);
}

function getMaterialRatioCount($styleNo,$buyerPONo)
{
	global $db;
	 $sql= "select count(*) as recCount from materialratio where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo'AND (intStatus != '0' or intStatus IS NULL);" ;
	return $db->RunQuery($sql);
}

function getStyleRatioDetails($styleNo,$buyerPONo)
{
	global $db;
	$sql= "select intStyleId,strBuyerPONO,strColor,strSize,dblQty,dblExQty,strUserId,intserial,dblFOB,dblPackQty from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo' AND (intStatus != '0' or intStatus IS NULL) order by strColor,strSize" ;
	return $db->RunQuery($sql);
}

function SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$userID,$dblFreightBal,$materialRatioID,$recutQty,$sizeserial,$yyQty,$wastage,$moq)
{

	global $db;
	$sql2 	 = "SELECT *
FROM materialratio
WHERE
materialratio.intStyleId = '$styleNo' AND
materialratio.strMatDetailID = '$item' AND
materialratio.strBuyerPONO = '$buyerPONo'
 AND
materialratio.strColor = '$color'
 AND
materialratio.strSize = '$size'"; 
				$result2 = $db->RunQuery($sql2);
				
				if(mysql_num_rows($result2))
				{
					#==================================================================================================
					# Comment On - 02/27/2014
					# Description - To avoid the chnage of Item Code when saving the 
					#               material ratio
					#==================================================================================================
					
					/*$sql="UPDATE `materialratio` SET `strColor`='$color',`strSize` = '$size', `dblQty` = '$qty' ,`dblBalQty` = '$balQty' , `dblFreightBalQty` = '$dblFreightBal', `materialRatioID`  = '$materialRatioID' , `serialNo`  = '$sizeserial' ,  `dblRecutQty`  = '$recutQty' ,`intStatus` = '1' WHERE (`intStyleId`='$styleNo') AND (`strMatDetailID`='$item') AND (`strBuyerPONO`='$buyerPONo')AND (`strColor`='$color') AND (`strSize`='$size');";*/
					
					#==================================================================================================
					//$sql="UPDATE `materialratio` SET `strColor`='$color',`strSize` = '$size', `dblQty` = '$qty' ,`dblBalQty` = '$balQty' , `dblFreightBalQty` = '$dblFreightBal', `serialNo`  = '$sizeserial' ,  `dblRecutQty`  = '$recutQty' ,`intStatus` = '1' WHERE (`intStyleId`='$styleNo') AND (`strMatDetailID`='$item') AND (`strBuyerPONO`='$buyerPONo')AND (`strColor`='$color') AND (`strSize`='$size');";
					 $sql="UPDATE `materialratio` SET `strColor`='$color',`strSize` = '$size', `dblQty` = '$qty' ,`dblBalQty` = '$balQty' , `dblFreightBalQty` = '$dblFreightBal', `serialNo`  = '$sizeserial' ,  `dblRecutQty`  = '$recutQty' ,intStatus = '1',dblYYConsumption= '$yyQty', dblWastage='$wastage', intMoq='$moq'  WHERE (`intStyleId`='$styleNo') AND (`strMatDetailID`='$item') AND (`strBuyerPONO`='$buyerPONo')AND (`strColor`='$color') AND (`strSize`='$size');";
	
	$db->executeQuery($sql);
				}
				else
				{
					//$sql1="INSERT INTO `materialratio` (`intStyleId`, `strMatDetailID`, `strColor`, `strSize`, `strBuyerPONO`, `dblQty`, `dblBalQty`, `dblFreightBalQty`, `materialRatioID`, `intStatus` ,`serialNo`,`dblRecutQty`) VALUES ('$styleNo', '$item', '$color', '$size', '$buyerPONo', '$qty', '$balQty', '$dblFreightBal', '$materialRatioID', '1','$sizeserial','$recutQty');";
					 $sql1="INSERT INTO `materialratio` (`intStyleId`, `strMatDetailID`, `strColor`, `strSize`, `strBuyerPONO`, `dblQty`, `dblBalQty`, `dblFreightBalQty`, `materialRatioID`, `intStatus` ,`serialNo`,`dblRecutQty`,dblYYConsumption,dblWastage,intMoq) VALUES ('$styleNo', '$item', '$color', '$size', '$buyerPONo', '$qty', '$balQty', '$dblFreightBal', '$materialRatioID', '1','$sizeserial','$recutQty','$yyQty','$wastage','$moq');";
					$db->executeQuery($sql1);
				}
	
	
	
	return true;
}

function DeleteMatRatioforPO($styleNo,$buyerPONo)
{
	global $db;
	$sql="update materialratio set intStatus = '0' where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo'";

	$db->executeQuery($sql);
	return true;
}

function resetMatRatio($styleNo,$itemCode,$reqyest)
{
	global $db;
	$colors = array();
	$sizes = array();
	$sirial = array();
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
	
	$sql = "select distinct strColor from styleratio where intStyleId = '$styleNo' AND intStatus = '1'";
	$result = $db->RunQuery($sql);
	//echo $reqyest;
	while($row = mysql_fetch_array($result))
	{
		$colors[$loopindex] = $row["strColor"];
		$loopindex  ++;
	}
	
	$loopindex = 0;
	
	$sql = "select distinct strSize from styleratio where intStyleId = '$styleNo'  AND intStatus = '1'";
	$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
		$sizes[$loopindex] = $row["strSize"];
		$loopindex  ++;
	}
	
	$loopindex = 0;
	
	$sql = "select distinct intserial from styleratio where intStyleId = '$styleNo'  AND intStatus = '1'";
	$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
		$sirial[$loopindex] = $row["intserial"];
		$loopindex  ++;
	}
	
	$loopindex = 0;
	
	$sql = "select distinct strBuyerPONO  from materialratio where intStyleId = '$styleNo' AND strMatDetailID = '$itemCode'  AND intStatus = '1'";
	$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
		$pos[$loopindex] = $row["strBuyerPONO"];
		$loopindex  ++;
	}
	
	/*if (count($pos) == 0)
	{
		$pos[0] = "#Main Ratio#";
	}*/
	
	if (count($pos) == 0)
	{
		$sql = "select distinct strBuyerPONO  from materialratio where intStyleId = '$styleNo' AND strMatDetailID = '$itemCode'  AND intStatus = '0'";
		$result = $db->RunQuery($sql);
		
		while($row = mysql_fetch_array($result))
		{
			$pos[$loopindex] = $row["strBuyerPONO"];
			$loopindex  ++;
		}
	}
	
	SaveHistoryMatRatioForItem($styleNo,$itemCode);
	//$sql = "update materialratio set intStatus = '0' where intStyleId = '$styleNo' AND strMatDetailID = '$itemCode'";

	//$db->executeQuery($sql);
	
	# ============================================================
	# 
	#
	#
        $sqlInactive = "update materialratio set intStatus = '0' where intStyleId = '$styleNo' AND strMatDetailID = '$itemCode'";
	$db->ExecuteQuery($sqlInactive);
	#===================================================================
	
	$freightCharge = 0;
	$reqQty = 0;
	$OdrQty = 0;
	//$sql = "select dblfreight, dblTotalQty from specificationdetails where intStyleId = '$styleNo' and strMatDetailID = '$itemCode'";
	$sql = "select dblfreight, dblTotalQty, dblQuantity,reaExPercentage  from specificationdetails inner join specification on specificationdetails.intStyleId = specification.intStyleId  inner join orders on orders.intStyleId=specification.intStyleId where specificationdetails.intStyleId = '$styleNo' and strMatDetailID = '$itemCode' AND (specificationdetails.intStatus = '1' or specificationdetails.intStatus IS NULL)";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$freightCharge = $row["dblfreight"];
		$reqQty        = $row["dblTotalQty"];
		$exPecent      = $row["reaExPercentage"];
		$OdrQty        = $row["dblQuantity"];
		//$OdrQty = $OdrQty+(($OdrQty*$exPecent)/100); //Use the percentage qty
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
			
				# ===========================================================================
				# Comment By  - Nalin Jayakody
				# Comment On  - 11/27/2015
				# Comment for - Remove retrieve excess qty form style ratio and get actual qty
				# ===========================================================================
				//$sql = "select sum(dblExQty) as exqty from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$poNumber' and strColor = '$colorName' AND (intStatus != '0' or intStatus IS NULL)";
				# ===========================================================================
				
				$sql = "select sum(dblQty) as exqty from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$poNumber' and strColor = '$colorName' AND (intStatus != '0' or intStatus IS NULL)";
				$result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					
					$matRatioID = $newSCNO . "-" . $itemCode . "-" . getCharforID($charpos);
					
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
					
					$sql="insert into materialratio (intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty,dblFreightBalQty,materialRatioID,dblRecutQty,serialNo,intStatus) values ('$styleNo','$itemCode','$colorName','N/A','$poNumber',$initQty,$matQty,$matFreightQty,'$matRatioID','$recutQty',0,1);";
					$db->executeQuery($sql);
					
					 $sqlSetActive = "UPDATE materialratio SET intStatus = 1 WHERE intStyleId = '$styleNo' AND strMatDetailID = '$itemCode' AND strColor = '$colorName' AND strSize = 'N/A' AND strBuyerPONO = '$poNumber' ";
					$db->executeQuery($sqlSetActive);
					
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
                    print_r($sizeName);
                  //foreach ( array_combine($sizes, $sirial) as $sizeName => $sirialNO) 
                    foreach ($sizes as $sizeName) 
			{
                             
                      
                            
				# ===========================================================================
				# Comment By  - Nalin Jayakody
				# Comment On  - 11/27/2015
				# Comment for - Remove retrieve excess qty form style ratio and get actual qty
				# ===========================================================================
				//$sql = "select sum(dblExQty) as exqty from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$poNumber' and strSize = '$sizeName' AND (intStatus != '0' or intStatus IS NULL)";
				# ===========================================================================
				
				$sql = "select sum(dblQty) as exqty from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$poNumber' and strSize = '$sizeName' AND (intStatus != '0' or intStatus IS NULL)";
				$result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					$matRatioID = $newSCNO . "-" . $itemCode . "-" . getCharforID(0);
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
					
                                        # =====================================================================
                                        # Add On - 07/25/2016
                                        # Add By - Nalin Jayakody
                                        # Add For - Check item avalilability of material ratio
                                        # =====================================================================
                                        
                                        $sql1 = "SELECT * FROM materialratio WHERE intStyleId = '$styleNo' AND strMatDetailID = '$itemCode' AND strColor = 'N/A' AND strSize = '$sizeName' AND strBuyerPONO = '$poNumber' ";
                                        //echo $sql1;
                                        $res = $db->RunQuery($sql1);
                                        //echo(mysql_num_rows($res));
                                        if(mysql_num_rows($res)>0){
                                             $sqlSetActive = "UPDATE materialratio SET intStatus = 1 WHERE intStyleId = '$styleNo' AND strMatDetailID = '$itemCode' AND strColor = 'N/A' AND strSize = '$sizeName' AND strBuyerPONO = '$poNumber' ";
                                            $db->executeQuery($sqlSetActive); 
                                           
                                        }else{          
                                          //  echo "X";
                                            $sql="insert into materialratio (intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty,dblFreightBalQty,materialRatioID,dblRecutQty,serialNo,intStatus) values ('$styleNo','$itemCode','N/A','$sizeName','$poNumber',$initQty,$matQty,$matFreightQty,'$matRatioID','$recutQty','$sirialNO',1);";				
                                            $db->executeQuery($sql);
                                              
                                            
                                            
                                        }
                                        
					
		

		$sqlSetActive = "UPDATE materialratio SET intStatus = 1 WHERE intStyleId = '$styleNo' AND strMatDetailID = '$itemCode' AND strColor = 'N/A' AND strSize = '$sizeName' AND strBuyerPONO = '$poNumber' ";
		$db->executeQuery($sqlSetActive);			
				}
			}
		}
	}
	else if (strcmp($reqyest,"BOTH") == 0)
	{	
		
		resetNAFigure($styleNo,  $itemCode, $poNumber);	
		
		foreach ($pos as $poNumber) 
		{
			
			//foreach (array_combine($sizes, $sirial) as $sizeName => $sirialNO) 
                    foreach ($sizes as $sizeName) 
			{
				$charpos = 0;
					$previousColor = "";
                                        					
				foreach ($colors as $colorName) 
				{
					
					
					
					
					# ===========================================================================
					# Comment By  - Nalin Jayakody
					# Comment On  - 11/27/2015
					# Comment for - Remove retrieve excess qty form style ratio and get actual qty
					# ===========================================================================
					//$sql = "select sum(dblExQty) as exqty from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$poNumber' and strSize = '$sizeName'  and strColor = '$colorName' AND (intStatus != '0' or intStatus IS NULL)";
					# ===========================================================================
					$sql = "select sum(dblQty) as exqty from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$poNumber' and strSize = '$sizeName'  and strColor = '$colorName' AND (intStatus != '0' or intStatus IS NULL)";
					
					$result = $db->RunQuery($sql);
					while($row = mysql_fetch_array($result))
					{
						$matRatioID = $newSCNO . "-" . $itemCode . "-" . getCharforID($charpos);
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
						
						 $sqlSetActive = " UPDATE materialratio SET intStatus = 1, materialRatioID = '$matRatioID'  WHERE intStyleId = '$styleNo' AND strMatDetailID = '$itemCode' AND strColor = '$colorName' AND strSize = '$sizeName' AND strBuyerPONO = '$poNumber' ";
						$db->executeQuery($sqlSetActive);
						
						  $sql="insert into materialratio (intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty,dblFreightBalQty,materialRatioID,dblRecutQty,serialNo,intStatus) values ('$styleNo','$itemCode','$colorName','$sizeName','$poNumber',$initQty,$matQty,$matFreightQty,'$matRatioID','$recutQty','$sirialNO',1);";						
						$db->executeQuery($sql);
						
						# Set inactive items in the material ratio if color is 'N/A' and Size is not 'N/A'
						  $sqlColorInactive = " UPDATE materialratio SET intStatus = 0 WHERE intStyleId = '$styleNo' AND strMatDetailID = '$itemCode' AND strColor = 'N/A' AND strSize = '$sizeName' AND strBuyerPONO = '$poNumber' ";
						$db->executeQuery($sqlColorInactive);
						# =====================================================================================
						
						# Set inactive items in the material ratio if color is not 'N/A' and Size is 'N/A'
						 $sqlSizeInactive = " UPDATE materialratio SET intStatus = 0 WHERE intStyleId = '$styleNo' AND strMatDetailID = '$itemCode' AND strColor = '$colorName' AND strSize = 'N/A' AND strBuyerPONO = '$poNumber' ";
						$db->executeQuery($sqlSizeInactive);
						
						
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
			$sql = "select sum(dblExQty) as exqty from styleratio where intStyleId = '$styleNo' AND strBuyerPONO = '$poNumber' AND (intStatus != '0' or intStatus IS NULL)";
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				$matRatioID = $newSCNO . "-" . $itemCode . "-" . getCharforID(0);
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
				
				$sql="insert into materialratio (intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty,dblFreightBalQty,materialRatioID,dblRecutQty,serialNo,intStatus) values ('$styleNo','$itemCode','$colorName','$sizeName','$poNumber',$initQty,$matQty,$matFreightQty,'$matRatioID','$recutQty','$sirialNO',1);";
				
				//$db->executeQuery($sql);
			}
		}
	}
}

function getMatRatioDetails($styleNo,$buyerPONo,$ItemID)
{
	global $db;
$sql= "select intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty,
               materialratio.dblYYConsumption,
               materialratio.dblWastage, materialratio.intMoq from materialratio 
               where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo' AND strMatDetailID = '$ItemID' AND (intStatus != '0' or intStatus IS NULL) order by serialNo" ;
	
	
	//$sql= "select intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty from materialratio where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo' AND strMatDetailID = '$ItemID' AND (intStatus != '0' or intStatus IS NULL) order by serialNo" ;
	//echo $sql; 
	return $db->RunQuery($sql);
}

function getMatRatioDetailsYY($styleNo,$buyerPONo,$ItemID,$color,$size)
{
	global $db;
         $sql= "select intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty,
                materialratio.dblYYConsumption,
                materialratio.dblWastage
                from materialratio
                WHERE
                materialratio.intStyleId = '$styleNo' AND
                materialratio.strBuyerPONO = '$buyerPONo' AND
                materialratio.strMatDetailID = '$ItemID' AND
                (materialratio.intStatus != '0' OR
                materialratio.intStatus IS NULL) AND
                materialratio.strColor = '$color' AND
                materialratio.strSize = '$size'
                order by serialNo
                " ;	
	//$sql= "select intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty from materialratio where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo' AND strMatDetailID = '$ItemID' AND (intStatus != '0' or intStatus IS NULL) AND dblQty != '0' order by serialNo" ;
	 
	return $db->RunQuery($sql);
}

function DeleteMatRatioforItem($styleNo,$buyerPONo,$matID)
{
	global $db;
	$sql="update materialratio set intStatus = '0' where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo' AND strMatDetailID = '$matID'";
	
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
	$sql= "select specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11  where specification.intStyleId   like '%" . $styleID . "%';";
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
	$sql="update materialratio set intStatus = '0'  where intStyleId = '$styleNo' AND strMatDetailID = '$matID'";	
	$db->executeQuery($sql);
	return true;
}

function SaveHistoryMatRatioForItem($styleNo,$matID)
{
	global $db;
	$sql = "insert into historymaterialratio (intStyleId, strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID)  select  intStyleId, 	strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID from materialratio where intStyleId = '$styleNo' and strMatDetailID ='$matID';";
	
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
	//$sql="insert into historymaterialratio (intStyleId, strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty,materialRatioID)  select  intStyleId, 	strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty,materialRatioID from materialratio where intStyleId = '$styleID' AND strBuyerPONO='$buyerPO'";
$sql="INSERT INTO historymaterialratio (
	intStyleId,
	strMatDetailID,
	strColor,
	strSize,
	strBuyerPONO,
	dblQty,
	dblBalQty,
	dblFreightBalQty,
	materialRatioID,
	dblRecutQty,
	serialNo,
	intStatus,
	dblYYConsumption,
	dblWastage
) SELECT
	intStyleId,
	strMatDetailID,
	strColor,
	strSize,
	strBuyerPONO,
	dblQty,
	dblBalQty,
	dblFreightBalQty,
	materialRatioID,
	dblRecutQty,
	serialNo,
	intStatus,
	dblYYConsumption,
	dblWastage
FROM
	materialratio
        where intStyleId = '$styleID' AND strBuyerPONO='$buyerPO'";

	
	  $db->ExecuteQuery($sql);	
}

function saveToHistoryMaterial($styleID,$buyerPO,$matID)
{
	
	global $db;
//	$sql="insert into historymaterialratio (intStyleId, strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID)  select  intStyleId, 	strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID from materialratio where intStyleId = '$styleID' AND strBuyerPONO='$buyerPO' AND strMatDetailID ='$matID'";
$sql="INSERT INTO historymaterialratio (
	intStyleId,
	strMatDetailID,
	strColor,
	strSize,
	strBuyerPONO,
	dblQty,
	dblBalQty,
	dblFreightBalQty,
	materialRatioID,
	dblRecutQty,
	serialNo,
	intStatus,
	dblYYConsumption,
	dblWastage
) SELECT
	intStyleId,
	strMatDetailID,
	strColor,
	strSize,
	strBuyerPONO,
	dblQty,
	dblBalQty,
	dblFreightBalQty,
	materialRatioID,
	dblRecutQty,
	serialNo,
	intStatus,
	dblYYConsumption,
	dblWastage
FROM
	materialratio
        where intStyleId = '$styleID' AND strBuyerPONO='$buyerPO' AND strMatDetailID ='$matID'";
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
		//"and (intStatus=10 or intStatus=1  or intStatus=2  or intStatus=5)";
		"and (intStatus=10 or intStatus=2  or intStatus=5)";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		return $row["poQty"];
	}

}

function getInterJobQty($styleID,$buyerPoNo,$matdetailId,$color,$size)
{
	global $db;
		$interjobsql = "SELECT
					 	IF(ISNULL(sum(itemtransferdetails.dblQty)),0,sum(itemtransferdetails.dblQty))  AS qty
						FROM
						itemtransfer
						Inner Join itemtransferdetails ON itemtransferdetails.intTransferId = itemtransfer.intTransferId 
						AND itemtransferdetails.intTransferYear = itemtransfer.intTransferYear
						WHERE
						itemtransfer.intStyleIdTo= '$styleID' AND
						itemtransferdetails.intMatDetailId =  '$matdetailId' and
						itemtransferdetails.strColor =  '$color' and
						itemtransferdetails.strSize =  '$size' and
						itemtransferdetails.strBuyerPoNo =  '$buyerPoNo'";
						
				//echo $interjobsql;
	$interjobresult = $db->RunQuery($interjobsql);
	$interjobqty=0;
	while($interjobrow=mysql_fetch_array($interjobresult))
	{
		$interjobqty = $interjobrow['qty'];
	}	
	return $interjobqty;
}
function getTotalPoQty($styleID,$buyerPoNo,$matdetailId,$color,$size)
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
		//"and (intStatus=10 or intStatus=1 )";
		"and (intStatus=10)";
	
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
		"and (intStatus=10 or intStatus=1  or intStatus=2  or intStatus=5)";
	
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
	$sql= "select count(*) as recCount from materialratio where intStyleId = '$styleNo' AND strBuyerPONO = '$buyerPONo' AND strMatDetailID='$matDetailId' AND (intStatus != '0' or intStatus IS NULL)";	
	return $db->RunQuery($sql);
}
function UpdateMatRatioBalQty($styleNo,$itemCode,$freight)
{
global $db;
	$sql="select distinct strBuyerPONO,strColor,strSize from materialratio where intStyleId='$styleNo' and strMatDetailID='$itemCode' AND (intStatus != '0' or intStatus IS NULL)";
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
		$sql_update="update materialratio set dblBalQty = dblQty - $poQty,dblFreightBalQty=dblQty-$freightPoQty where intStyleId='$styleNo' and strBuyerPONO='$buyerPoNo' and strMatDetailID='$itemCode' and strColor='$color' and strSize='$size' AND (intStatus != '0' or intStatus IS NULL) ";		
	}
	else
		$sql_update="update materialratio set dblBalQty = dblQty - $poQty,dblFreightBalQty=0 where intStyleId='$styleNo' and strBuyerPONO='$buyerPoNo' and strMatDetailID='$itemCode' and strColor='$color' and strSize='$size' AND (intStatus != '0' or intStatus IS NULL) ";
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
	$sql = " select dblTotalQty from specificationdetails where intStyleId='$styleNo' and strMatDetailID='$item' AND (intStatus != '0' or intStatus IS NULL) ";
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
function GetMaterialRatioTemplate($prmStyleId, $prmMatId){
	
	global $db;
	
	$sql = " SELECT Count(materialratio_template.intStyleId) AS RatioCount ".
	       " FROM   materialratio_template ".
		   " WHERE  materialratio_template.intStyleId =  '$prmStyleId' AND materialratio_template.intMatDetailId =  '$prmMatId'";
	//echo $sql;	   
	$result = $db->RunQuery($sql);
	
	$row = mysql_fetch_row($result);
	
	return $row[0];	   	
}

function SaveRatioTemplate($prmStyleCode, $prmMatId, $prmBuyerPO, $prmColor, $prmSize, $prmSequenceNo){
	
	global $db;
	
	$strsql = " INSERT INTO materialratio_template(intStyleId, intMatDetailId, strBuyerPO, strColor, strSize, intSequenceNo) ".
	          " VALUES ('$prmStyleCode', '$prmMatId', '$prmBuyerPO', '$prmColor', '$prmSize', '$prmSequenceNo')";
	
	$db->ExecuteQuery($strsql);	   
	
}

function GetRatioTemplate($prmStyleID, $prmMatId){

	global $db;
	
	$strSql = " SELECT materialratio_template.intStyleId, materialratio_template.intMatDetailId, materialratio_template.strBuyerPO, ".
	          "        materialratio_template.strColor, materialratio_template.strSize, materialratio_template.intSequenceNo ".
              " FROM   materialratio_template".	
			  " WHERE  materialratio_template.intStyleId = '$prmStyleID' AND materialratio_template.intMatDetailId = '$prmMatId' ".
			  " ORDER BY materialratio_template.intSequenceNo ";
			  
	$result = $db->RunQuery($strSql);
	//echo $strSql;
	return $result;
}


function getHistoryMatRatio($styleNo,$buyerPONo,$matID){

	global $db;
	
	$strSql = "SELECT
        historymaterialratio.intStyleId,
        historymaterialratio.strMatDetailID,
        historymaterialratio.strColor,
        historymaterialratio.strSize,
        historymaterialratio.strBuyerPONO,
        historymaterialratio.dblQty,
        historymaterialratio.dblYYConsumption,
        historymaterialratio.serialNo
        FROM
        historymaterialratio
        WHERE
        historymaterialratio.intStyleId = '$styleNo' AND
        historymaterialratio.strMatDetailID = '$matID' AND
        historymaterialratio.strBuyerPONO = '$buyerPONo' AND
        historymaterialratio.intStatus = 1
        ORDER BY
        historymaterialratio.intHistiryMatID ASC,
        historymaterialratio.serialNo ASC";
			  
	$result = $db->RunQuery($strSql);
	return $result;
}

function resetNAFigure($prmStyleID, $prmMatId, $prmPONumber){
	
	global $db;
	$strSql = " UPDATE materialratio SET dblQty = 0, dblBalQty = 0  WHERE intStyleId = '$prmStyleID' AND strMatDetailID = '$prmMatId' AND strColor = 'N/A' AND strSize = 'N/A'" ;
	$db->ExecuteQuery($strSql);	
	
	
	
}

function IsBuyerPOExistInMR($prmStyleID, $prmBuyerPO, $prmMatId){

	global $db;
	$sql = "SELECT count(materialratio.intStyleId) as noLines 
	        FROM materialratio 
	        WHERE materialratio.intStyleId =  '$prmStyleID' AND materialratio.strMatDetailID =  '$prmMatId' AND materialratio.strBuyerPONO =  '$prmBuyerPO' AND materialratio.intStatus =  '1'";

	$result = $db->RunQuery($sql);        

	while($row = mysql_fetch_array($result)){

		$rowCount = $row["noLines"];
	}  

	return $rowCount;      
}


function getmailDetail($styleNo,$itemCode,$bpoNo){

	global $db;
	
//	$sql = "SELECT
//        materialratio.intStyleId,
//        materialratio.strMatDetailID,
//        materialratio.strColor,
//        materialratio.strSize,
//        materialratio.strBuyerPONO,
//        matitemlist.strItemDescription,
//        materialratio.dblYYConsumption as matYY,
//        historymaterialratio.dblYYConsumption as hisYY,
//        (materialratio.dblYYConsumption-historymaterialratio.dblYYConsumption) as diff
//        FROM
//        materialratio
//        INNER JOIN historymaterialratio ON materialratio.intStyleId = historymaterialratio.intStyleId AND materialratio.strMatDetailID = historymaterialratio.strMatDetailID AND materialratio.strColor = historymaterialratio.strColor AND materialratio.strSize = historymaterialratio.strSize AND materialratio.strBuyerPONO = historymaterialratio.strBuyerPONO
//        INNER JOIN matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial
//        WHERE
//        materialratio.intStyleId ='$styleNo' AND
//        materialratio.strMatDetailID = '$itemCode' AND
//        materialratio.strBuyerPONO = '$bpoNo' AND
//        materialratio.intStatus = 1
//        HAVING (materialratio.dblYYConsumption-historymaterialratio.dblYYConsumption)<>0";
//     	$result = $db->RunQuery($sql);
//        return $result;

        
$sql = "SELECT
        materialratio.intStyleId,
        materialratio.strMatDetailID,
        materialratio.strColor,
        materialratio.strSize,
        materialratio.strBuyerPONO,
        matitemlist.strItemDescription,
        materialratio.dblYYConsumption AS matYY
        FROM
        materialratio
        INNER JOIN matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial
        WHERE
        materialratio.intStyleId ='$styleNo' AND
        materialratio.strMatDetailID = '$itemCode' AND
        materialratio.strBuyerPONO = '$bpoNo' AND
        materialratio.intStatus = 1";
$result = $db->RunQuery($sql);
return $result;
        
}


function getmailAdd($styleNo){

	global $db;
	
$sql = "SELECT
buyerwisemerchant.strMerchantName,
buyerwisemerchant.strEmail,
buyerwisemerchant.intBuyerId,
orders.intStyleId,
buyers.strName
FROM
buyerwisemerchant
INNER JOIN orders ON buyerwisemerchant.intBuyerId = orders.intBuyerID
INNER JOIN buyers ON buyerwisemerchant.intBuyerId = buyers.intBuyerID
WHERE
buyerwisemerchant.intStatus = 1 AND
orders.intStyleId ='$styleNo'";

$result_to = $db->RunQuery($sql);
return $result_to;
        
}
?>