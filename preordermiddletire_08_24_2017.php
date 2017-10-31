<?php
session_start();
include "Connector.php";
include "HeaderConnector.php";
include "permissionProvider.php";

include "d2dConnector.php";

$d2dConnectClass = new ClassConnectD2D();

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


//$db =new DBManager();

$RequestType = $_GET["RequestType"];
$userId		 = $_SESSION["UserID"];
if (strcmp($RequestType,"GetDivision") == 0)
{
	 $ResponseXML = "";
	 $buyerID=$_GET["CustID"];
	 $ResponseXML .= "<Divisions>\n";
	 $result=getDivision($buyerID);
	 	$ResponseXML .= "<DivisionID><![CDATA[" . "Null"  . "]]></DivisionID>\n";
		$ResponseXML .= "<Division><![CDATA[" . "Select One"  . "]]></Division>\n"; 
	 while($row = mysql_fetch_array($result))
  	 {
		 $ResponseXML .= "<DivisionID><![CDATA[" . $row["intDivisionId"]  . "]]></DivisionID>\n";
         $ResponseXML .= "<Division><![CDATA[" . $row["strDivision"]  . "]]></Division>\n";                
	 }
	 $ResponseXML .= "</Divisions>";
	 echo $ResponseXML;
	
}

else if(strcmp($RequestType,"GetBuyingOffice")==0)
{
	$ResponseXML="";
	$buyerID=$_GET["CustID"];
	$ResponseXML.="<BuyingOffice>\n";
	$result=getBuyingOffice($buyerID);
		$ResponseXML .= "<BuyingOfficeID><![CDATA[" . "Null"  . "]]></BuyingOfficeID>\n";
		$ResponseXML .= "<BOffice><![CDATA[" . "Select One"  . "]]></BOffice>\n";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<BuyingOfficeID><![CDATA[" . $row["intBuyingofficeId"]  . "]]></BuyingOfficeID>\n";
		$ResponseXML .= "<BOffice><![CDATA[" . $row["strName"]  . "]]></BOffice>\n";  
	}
	$ResponseXML.="</BuyingOffice>";
	echo $ResponseXML;
}

else if(strcmp($RequestType,"GetSubCategries")==0)
{
	$ResponseXML="";
	$mainCatID=$_GET["mainCatID"];
	$ResponseXML.="<SubCategories>";
	$result=getCategories($mainCatID);
	while($row=mysql_fetch_array($result))
	{
	$ResponseXML.="<CatID><![CDATA[" . $row["intSubCatNo"]  . "]]></CatID>\n";
	$ResponseXML.="<CatName><![CDATA[" . $row["StrCatName"]  . "]]></CatName>\n";
	$ResponseXML.="<CatCode><![CDATA[" . $row["StrCatCode"]  . "]]></CatCode>\n";
	}
	$ResponseXML.="</SubCategories>";
    echo $ResponseXML;
}
else if(strcmp($RequestType,"GetItems")==0)
{
	$ResponseXML="";
	$mainCatID=$_GET["MainCatID"];
	$catID=$_GET["CatID"];
	$result=getItems($mainCatID,$catID);
	$ResponseXML.="<items>";
	$strItemId = "<option value=\"". "Select One"."\">" . "Select One"."</option>" ;
	$strItemName = "<option value=\"". "Select One"."\">" . "Select One"."</option>" ;
	while($row=mysql_fetch_array($result))
	{
		/*$ResponseXML.="<itemID><![CDATA[" .$row["intItemSerial"]. "]]></itemID>\n";
		$ResponseXML.="<itemName><![CDATA[" .$row["strItemDescription"]. "]]></itemName>\n";*/
		
		$strItemId .= "<option value=\"". $row["intItemSerial"] ."\">" . $row["intItemSerial"] ."</option>";
		$strItemName .= "<option value=\"". $row["intItemSerial"] ."\">" . $row["strItemDescription"] ."</option>";
	}
	
	$ResponseXML.="<itemID><![CDATA[" .$strItemId. "]]></itemID>\n";
	$ResponseXML.="<itemName><![CDATA[" .$strItemName. "]]></itemName>\n";
	$ResponseXML.="</items>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"GetItemsForString")==0)
{
	$ResponseXML="";
	$mainCatID=$_GET["MainCatID"];
	$catID=$_GET["CatID"];
	$searchString = $_GET["searchString"];
	$result=getItemsForString($mainCatID,$catID,$searchString);
	$ResponseXML.="<items>";
	while($row=mysql_fetch_array($result))
	{
		/*$ResponseXML.="<itemID><![CDATA[" .$row["intItemSerial"]. "]]></itemID>\n";
		$ResponseXML.="<itemName><![CDATA[" .$row["strItemDescription"]. "]]></itemName>\n";*/
		$strItemId .= "<option value=\"". $row["intItemSerial"] ."\">" . $row["intItemSerial"] ."</option>";
		$strItemName .= "<option value=\"". $row["intItemSerial"] ."\">" . $row["strItemDescription"] ."</option>";
	}
	$ResponseXML.="<itemID><![CDATA[" .$strItemId. "]]></itemID>\n";
	$ResponseXML.="<itemName><![CDATA[" .$strItemName. "]]></itemName>\n";
	$ResponseXML.="</items>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"GetDefaultUnit")==0)
{
	$ResponseXML="";
	$ItemID=$_GET["ItemCode"];
	
	$result=getUnitByItem($ItemID);
	$ResponseXML.="<items>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<Unit><![CDATA[" .$row["strUnit"]. "]]></Unit>\n";
	}
	
	$ResponseXML.="</items>";
	echo $ResponseXML;
	
}

else if(strcmp($RequestType,"GetUnits")==0)
{
	$ResponseXML="";
	$result=getUnits();
	$ResponseXML.="<units>";
	$str = "";
	while($row=mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["strUnit"] ."\">".$row["strUnit"]."</option>\n";	
	}
	$ResponseXML.="<unit><![CDATA[" .$str. "]]></unit>\n";	
	$ResponseXML.="</units>";
	echo $ResponseXML;	
	
}

else if(strcmp($RequestType,"GetOrigin")==0)
{
	$ResponseXML="";
	$result=getOrigine();
	$ResponseXML.="<Origin>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<OriginID><![CDATA[" .$row["intOriginNo"]. "]]></OriginID>\n";
		$ResponseXML.="<OriginType><![CDATA[" .$row["strOriginType"]. "]]></OriginType>\n";
				
	}
	
	$ResponseXML.="</Origin>";
	echo $ResponseXML;	
	
}

else if(strcmp($RequestType,"GetItemDiscription")==0)
{
	$ResponseXML="";
	$itemID=$_GET["ItemID"];
	$result=getItemDiscription($itemID);
	$ResponseXML.="<ItemDiscription>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<Unit><![CDATA[" .$row["strUnit"]. "]]></Unit>\n";
		$wastage = $row["sngWastage"];
		if($wastage == "")
			$wastage = 0;
		$ResponseXML.="<Wastage><![CDATA[" .$wastage. "]]></Wastage>\n";
		$ResponseXML.="<UnitPrice><![CDATA[" .($row["dblUnitPrice"]=="" ? 0:$row["dblUnitPrice"]). "]]></UnitPrice>\n";
				
	}
	
	$ResponseXML.="</ItemDiscription>";
	echo $ResponseXML;
	
}

else if(strcmp($RequestType,"GetConPc")==0)
{
	$ResponseXML="";
	$itemID=$_GET["ItemID"];
	$toUnit=$_GET["SelectedUnit"];
	$previousUnit = $_GET["previousUnit"];
	$conPc=$_GET["ConPc"];
	$result=getUnitConversion($itemID,$previousUnit,$toUnit);
	$conFactor = 0;
	$ResponseXML.="<ConPcConverted>";
	while($row=mysql_fetch_array($result))
	{
		$conFactor=$row["dblFactor"];				
	}
	//$resultUnit=getUnitByItem($itemID);
	//$toUnit="";
	//while($row=mysql_fetch_array($resultUnit))
	//{
		//$toUnit=$row["strUnit"];
		
	//}
	$CalcConPc=$conPc/$conFactor;
	$ResponseXML.="<ConPcCalculated><![CDATA[" . round($CalcConPc,4). "]]></ConPcCalculated>\n";
	$ResponseXML.="<DefaultUnit><![CDATA[" .$toUnit. "]]></DefaultUnit>\n";
	$ResponseXML.="</ConPcConverted>";
	echo $ResponseXML;
	
}

else if(strcmp($RequestType,"GetEfficiencyRate")==0)
{
	$ResponseXML="";
	$styleID=$_GET["styleID"];
	$smvRate=$_GET["smvRate"];
	$qty=$_GET["qty"];
	$ResponseXML.="<Efficiency>";

	$effLevel = updateEfficiancy($styleID,$qty,$smvRate);

	if ($effLevel > 0)
		$ResponseXML.="<EfficencyValue><![CDATA[" .$effLevel. "]]></EfficencyValue>\n";	
	else
		$ResponseXML.="<EfficencyValue><![CDATA[0]]></EfficencyValue>\n";	
	$ResponseXML.="</Efficiency>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"GetShippingMode")==0)
{
	$ResponseXML="";
	$result=getShippingMode();
	$ResponseXML.="<ShippingMode>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<ShipModeID><![CDATA[" .$row["intShipmentModeId"]. "]]></ShipModeID>\n";
		$ResponseXML.="<ShipMode><![CDATA[" .$row["strDescription"]. "]]></ShipMode>\n";
		
				
	}
	
	$ResponseXML.="</ShippingMode>";
	echo $ResponseXML;
	
	
}
else if(strcmp($RequestType,"GetCountries")==0)
{
	$ResponseXML="";
	$result=getCountriesCombo();
	$ResponseXML.="<country>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<countryID><![CDATA[" .$row["intConID"]. "]]></countryID>\n";
		$ResponseXML.="<countryName><![CDATA[" .$row["strCountry"]. "]]></countryName>\n";
		
				
	}
	
	$ResponseXML.="</country>";
	echo $ResponseXML;
	
	
}
//--------------------------------------------------------------------------------------
else if(strcmp($RequestType,"SavePreOrder")==0)
{
	
	$ResponseXML="";
	$orderNo=$_GET["OrderNo"];
	$styleID=$_GET["StyleNo"];
	$companyID=$_GET["factoryID"];
	$description=$_GET["StyleName"];
	$buyerID=$_GET["BuyerID"];
	$qty=$_GET["Qty"];
	$Coordinator=$_GET["MerchantID"];
	$status=$_GET["ApprovalStatus"];
	$customerRefNo=$_GET["RefNo"];
	/*if (is_null($customerRefNo) || $customerRefNo == "")
	{
	$customerRefNo="";
	}*/
	
	$smv=$_GET["SMV"];
	$date=date("Y-m-d");
	$smvRate=$_GET["SMVRate"];
	$fob=$_GET["TargetFOB"];
	$finance=$_GET["FinanceA"];
	if (is_null($finance) || $finance == "")
		$finance = 0;
	$userID=$_GET["UserID"];
	$approvedBy=0;
	$appRemarks="";
	$AppDate=null;
	$exPercentage=$_GET["ExQty"];
	$finPercntage=$_GET["FinanceP"];
	if (is_null($finPercntage) || $finPercntage == "")
		$finPercntage = 0;
	$approvalNo=0;
	$revisedReason="";
	$revisedDate=null;
	$revisedBy=0;
	$confirmedPrice=0;
	$conPriceCurrency="";
	$commission=0;
	$efficiencyLevel=$_GET["EffLevel"];
	if (is_null($efficiencyLevel) || $efficiencyLevel == "")
		$efficiencyLevel = 0;
	$costPerMinute=$_GET["CMValue"];
	$dateSentForApprovals=null;
	$sentForApprovalsTo=0;
	$deliverTo="";
	$freightCharges=0;
	$ECSCharge=$_GET["ESC"];
	$labourCost=0;	
	$buyingOfficeId=$_GET["BuyingOfficeID"];
	$ScheduleMethod = $_GET["ScheduleMethod"];

	//if (is_null($buyingOfficeId) || $buyingOfficeId == "")
		//$buyingOfficeId = 0;
	
	$divisionId=$_GET["DivisionID"];
	//if (is_null($divisionId) || $divisionId == "")
		//$divisionId = 0;

	$seasonId=$_GET["SeasonID"];
		//if (is_null($seasonId) || $seasonId == "")
		//$seasonId = 0;
	
	
	$RPTMark=$_GET["RepeatNo"];
	if (is_null($RPTMark) || $RPTMark == "")
		$RPTMark= "";
	
	$subContractQty=$_GET["subcontractQty"];
	if (is_null($subContractQty) || $subContractQty == "")
		$subContractQty = 0;
		
	$subContractSMV=0;
	$subContractRate=0;
	$subTransportCost=0;
	$subCM=0;
	$lineNos=$_GET["NoOfLines"];
	if (is_null($lineNos) || $lineNos == "")
		$lineNos = 0;
	
	$profit=0;
	$uPCharges=$_GET["UpCharge"];
	if (is_null($uPCharges) || $uPCharges == "")
		$uPCharges = 0;
		
	$facProfit = $_GET["facProfit"];
	if (is_null($facProfit) || $facProfit == "")
		$facProfit = 0;	
		
	$UPChargeDescription= $_GET["UPChargeReason"];
	$fabFinance=0;
	$trimFinance=0;
	$newCM=0;
	$newSMV=0;
	$firstApprovedBy=0;
	$FirstAppDate=null;	
	$color 			= $_GET["color"];
	$OrderType	= $_GET["OrderType"];
	$manufacCompany = $_GET["manufacCompany"];
	$buyerOrderNo = $_GET["buyerOrderNo"];

	$facOHCostPerMin = $_GET["facOHCost"];
	
	$result=saveOrder($orderNo,$styleID,$companyID,$description,$buyerID,$qty,$Coordinator,$status,$customerRefNo,$smv,$date,$smvRate,$fob,$finance,$userID,$approvedBy,$appRemarks,$AppDate,$exPercentage,$finPercntage,$approvalNo,$revisedReason,$revisedDate,$revisedBy,$confirmedPrice,$conPriceCurrency,$commission,$efficiencyLevel,$costPerMinute,$dateSentForApprovals,$sentForApprovalsTo,$deliverTo,$freightCharges,$ECSCharge,$labourCost,$buyingOfficeId,$divisionId,$seasonId,$RPTMark,$subContractQty,$subContractSMV,$subContractRate,$subTransportCost,$subCM,$lineNos,$profit,$uPCharges,$UPChargeDescription,$fabFinance,$trimFinance,$newCM,$newSMV,$firstApprovedBy,$FirstAppDate,$ScheduleMethod,$facProfit,$color,$OrderType,$manufacCompany,$buyerOrderNo, $facOHCostPerMin);
	
	if($status=="10")
	{
		global $db;
		$sql="SELECT strManagerEmail FROM companies c where intCompanyID='".$companyID."';";
			$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
		$reciever=$row["strManagerEmail"];
		}
		$sql="SELECT UserName,Name FROM useraccounts where intUserID=".$userID.";";
		$resultUser=$db->RunQuery($sql);
		while($row=mysql_fetch_array($resultUser))
		{
		$senderEmail=$row["UserName"];
		$senderName=$row["Name"];
		}
		
	include "EmailSender.php";
	$eml =  new EmailSender();
	$eml->SendStyleForApproval($senderEmail,$senderName,$reciever,$styleID);	
		
	}
		$ResponseXML.="<SaveOrder>";
		$ResponseXML.="<SaveState><![CDATA[True]]></SaveState>\n";
		
		$ResponseXML.="<StyleId><![CDATA[".GetSavedStyleId($styleID)."]]></StyleId>\n";
		$ResponseXML.="</SaveOrder>";
		echo $ResponseXML;
}
//--------------------Hemanthi (31/08/2010)--------------------------------------------------------------
else if(strcmp($RequestType,"SaveOrderInquiry")==0)
{
	
	$ResponseXML="";
	$orderId = $_GET["orderId"];
	$orderNo=$_GET["poNo"];
	$styleID=$_GET["StyleNo"];
	//$companyID=$_GET["factoryID"];
	$companyID = $_SESSION["FactoryID"];
	$description=$_GET["StyleName"];
	$buyerID=$_GET["BuyerID"];
	
	$qty=$_GET["Qty"];
	if (is_null($qty) || $qty == "")
	{
	$qty=0;
	}
	
	$customerRefNo=$_GET["RefNo"];
	if (is_null($customerRefNo) || $customerRefNo == "")
	{
	$customerRefNo="";
	}
	
	$date=date("Y-m-d");
	$smv=$_GET["SMV"];
	$smvRate=$_GET["SMVRate"];
	$fob=$_GET["TargetFOB"];
	$finance=$_GET["FinanceA"];
	if (is_null($finance) || $finance == "")
		$finance = 0;
	$userID=$_GET["UserID"];
	$status=2;
	$approvedBy=0;
	$appRemarks="";
	$AppDate=null;
	$finPercntage=$_GET["FinanceP"];
	if (is_null($finPercntage) || $finPercntage == "")
		$finPercntage = 0;
	$approvalNo=0;
	$revisedReason="";
	$revisedDate=null;
	$revisedBy=0;
	$confirmedPrice=0;
	$conPriceCurrency="";
	$commission=0;
	$efficiencyLevel = 0;
	$costPerMinute=$_GET["CMValue"];
	$dateSentForApprovals=null;
	$sentForApprovalsTo=0;
	$deliverTo="";
	$freightCharges=0;
	$ECSCharge=$_GET["ESC"];
	$labourCost=0;	
	$buyingOfficeId=$_GET["BuyingOfficeID"];

	//if (is_null($buyingOfficeId) || $buyingOfficeId == "")
		//$buyingOfficeId = 0;
	
	$divisionId=$_GET["DivisionID"];
	//if (is_null($divisionId) || $divisionId == "")
		//$divisionId = 0;

	$seasonId=$_GET["SeasonID"];
		//if (is_null($seasonId) || $seasonId == "")
		//$seasonId = 0;
	
	
	$RPTMark=$_GET["RepeatNo"];
	if (is_null($RPTMark) || $RPTMark == "")
		$RPTMark= "";
	
		
	$subContractSMV=0;
	$subContractRate=0;
	$subTransportCost=0;
	$subCM=0;
	
	$profit=0;
	$uPCharges=$_GET["UpCharge"];
	if (is_null($uPCharges) || $uPCharges == "")
		$uPCharges = 0;
		
	$facProfit = $_GET["facProfit"];
	if (is_null($facProfit) || $facProfit == "")
		$facProfit = 0;	
		
	$fabFinance=0;
	$trimFinance=0;
	$newCM=0;
	$newSMV=0;
	$firstApprovedBy=0;
	$FirstAppDate=null;
	
	$subContractQty=0;
	$poDate=$_GET["poDate"];
	$AppDateFromArray		= explode('/',$poDate);
	$poDate = $AppDateFromArray[2]."-".$AppDateFromArray[1]."-".$AppDateFromArray[0];
	$userID=$_GET["UserID"];
	$color=$_GET["color"];
	$Mill=$_GET["Mill"];
	$FabricRefNo=$_GET["FabricRefNo"];
	$Fabrication=$_GET["Fabrication"];
	if (is_null($color) || $color == "")
		$color = "";	
	$dimention=$_GET["dimention"];
	if (is_null($dimention) || $dimention == "")
		$dimention = 0;	
	if (is_null($Mill) || $Mill == "")
		$Mill = 0;	
	
	$orderColorCode = $_GET["orderColorCode"];
	$orderType = $_GET["orderType"];
	$buyerOrderNo = $_GET["buyerOrderNo"];
     //$AllreadyExist = false;
	 //$Exist = CheckExistStyle($orderNo,$styleID);
	 //while($row = mysql_fetch_array($Exist))
     //{
	   //$AllreadyExist = true;
	 //}
	 
	 //if ($AllreadyExist == false)
	 if($orderId=='')
	 {
	 $resultO=saveOrderinquiry($orderNo,$styleID,$companyID,$description,$buyerID,$qty,$customerRefNo,$date,$poDate,$smv,$smvRate,$fob,$finance,$userID,$approvedBy,$appRemarks,$AppDate,$finPercntage,$approvalNo,$revisedReason,$revisedDate,$revisedBy,$confirmedPrice,$conPriceCurrency,$commission,$efficiencyLevel,$costPerMinute,$dateSentForApprovals,$sentForApprovalsTo,$deliverTo,$freightCharges,$ECSCharge,$labourCost,$buyingOfficeId,$divisionId,$seasonId,$RPTMark,$subContractQty,$subContractSMV,$subContractRate,$subTransportCost,$subCM,$profit,$uPCharges,$facProfit,$fabFinance,$trimFinance,$newCM,$newSMV,$firstApprovedBy,$FirstAppDate,$userID,$color,$dimention,$Mill,$FabricRefNo,$Fabrication,$status,$orderColorCode,$orderType,$buyerOrderNo);
}	
else{
	 $resultU=UpdateOrderinquiry($orderId,$orderNo,$styleID,$companyID,$description,$buyerID,$qty,$customerRefNo,$date,$poDate,$smv,$smvRate,$fob,$finance,$userID,$approvedBy,$appRemarks,$AppDate,$finPercntage,$approvalNo,$revisedReason,$revisedDate,$revisedBy,$confirmedPrice,$conPriceCurrency,$commission,$efficiencyLevel,$costPerMinute,$dateSentForApprovals,$sentForApprovalsTo,$deliverTo,$freightCharges,$ECSCharge,$labourCost,$buyingOfficeId,$divisionId,$seasonId,$RPTMark,$subContractQty,$subContractSMV,$subContractRate,$subTransportCost,$subCM,$profit,$uPCharges,$facProfit,$fabFinance,$trimFinance,$newCM,$newSMV,$firstApprovedBy,$FirstAppDate,$userID,$color,$dimention,$Mill,$FabricRefNo,$Fabrication,$status,$orderColorCode,$orderType,$buyerOrderNo);
}	
	
	
	
	if($status=="10")
	{
		global $db;
		$sql="SELECT strManagerEmail FROM companies c where intCompanyID='".$companyID."';";
			$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
		$reciever=$row["strManagerEmail"];
		}
		$sql="SELECT UserName,Name FROM useraccounts where intUserID=".$userID.";";
		$resultUser=$db->RunQuery($sql);
		while($row=mysql_fetch_array($resultUser))
		{
		$senderEmail=$row["UserName"];
		$senderName=$row["Name"];
		}
		
	include "EmailSender.php";
	$eml =  new EmailSender();
	$eml->SendStyleForApproval($senderEmail,$senderName,$reciever,$styleID);	
		
	}
		$ResponseXML.="<SaveOrder>";
		
	 if($resultO!=""){
	 $ResponseXML .= "<SaveState><![CDATA[True]]></SaveState>\n";
	 }
	 else if($resultU!=""){
	 $ResponseXML .= "<SaveState><![CDATA[Updated]]></SaveState>\n";
	 }
	 else{
	 $ResponseXML .= "<SaveState><![CDATA[False]]></SaveState>\n";
	 }
		
		$ResponseXML.="<StyleId><![CDATA[".GetSavedStyleId($styleID)."]]></StyleId>\n";
		$ResponseXML.="</SaveOrder>";
		echo $ResponseXML;
}
//---------------------------------------------------------------------------------------------
else if(strcmp($RequestType,"SaveModifiedPreOrder")==0)
{
	
	$ResponseXML="";
	$orderNo=$_GET["OrderNo"];
	$styleID=$_GET["StyleNo"];
	$companyID=$_GET["factoryID"];
	$description=$_GET["StyleName"];
	$buyerID=$_GET["BuyerID"];
	$qty=$_GET["Qty"];
	$Coordinator=$_GET["MerchantID"];
	$status=$_GET["ApprovalStatus"];
	$customerRefNo=$_GET["RefNo"];
	if (is_null($customerRefNo) || $customerRefNo == "")
	{
	$customerRefNo="";
	}
	
	$smv=$_GET["SMV"];
	$date=date("Y-m-d");
	$smvRate=$_GET["SMVRate"];
	$fob=$_GET["TargetFOB"];
	$finance=$_GET["FinanceA"];
	if (is_null($finance) || $finance == "")
		$finance = 0;
	$userID=$_GET["UserID"];
	$approvedBy=0;
	$appRemarks="";
	$AppDate=null;
	$exPercentage=$_GET["ExQty"];
	$finPercntage=$_GET["FinanceP"];
	if (is_null($finPercntage) || $finPercntage == "")
		$finPercntage = 0;
	$approvalNo=0;
	$revisedReason="";
	$revisedDate=null;
	$revisedBy=0;
	$confirmedPrice=0;
	$conPriceCurrency="";
	$commission=0;
	$efficiencyLevel=$_GET["EffLevel"];
	if (is_null($efficiencyLevel) || $efficiencyLevel == "")
		$efficiencyLevel = 0;
	$costPerMinute=$_GET["CMValue"];
	$dateSentForApprovals=null;
	$sentForApprovalsTo=0;
	$deliverTo="";
	$freightCharges=0;
	$ECSCharge=$_GET["ESC"];
	$labourCost=$_GET["labourCost"];	
	$buyingOfficeId=$_GET["BuyingOfficeID"];
	$ScheduleMethod = $_GET["ScheduleMethod"];

	//if (is_null($buyingOfficeId) || $buyingOfficeId == "")
		//$buyingOfficeId = 0;
	
	$divisionId=$_GET["DivisionID"];
	//if (is_null($divisionId) || $divisionId == "")
		//$divisionId = 0;

	$seasonId=$_GET["SeasonID"];
		//if (is_null($seasonId) || $seasonId == "")
		//$seasonId = 0;
	
	
	$RPTMark=$_GET["RepeatNo"];
	if (is_null($RPTMark) || $RPTMark == "")
		$RPTMark= "";
	
	$subContractQty=$_GET["subcontractQty"];
	if (is_null($subContractQty) || $subContractQty == "")
		$subContractQty = 0;

	$subContractSMV=0;
	$subContractRate=0;
	$subTransportCost=0;
	$subCM=0;
	$lineNos=$_GET["NoOfLines"];
	if (is_null($lineNos) || $lineNos == "")
		$lineNos = 0;
	
	$profit=$_GET["margin"];
	if (is_null($profit) || $profit == "")
		$profit = 0;
	$uPCharges=$_GET["UpCharge"];
	if (is_null($uPCharges) || $uPCharges == "")
		$uPCharges = 0;
	$UPChargeDescription=$_GET["UPChargeReason"];
	$fabFinance=0;
	$trimFinance=0;
	$newCM=0;
	$newSMV=0;
	$firstApprovedBy=0;
	$FirstAppDate=null;
	
	$orderUnit=$_GET["orderUnit"];
	if (is_null($orderUnit) || $orderUnit == "")
	{
	$orderUnit="";
	}
	
	$proSubcat=$_GET["proSubcat"];
	if (is_null($proSubcat) || $proSubcat == "")
	{
	$proSubcat="";
	}
	
	//added to orit costsheet-----------profit-------------
	$facProfit = $_GET["facProfit"];
	if (is_null($facProfit) || $facProfit == "")
	{
	$facProfit=0;
	}
	$orderType = $_GET["orderType"];
	$mafactureCompanyID = $_GET["mafactureCompanyID"];
	//-----------------------
        
        // ============== Get Packing SMV ----------------------------
        $dblPackSMV = $_GET["pSMV"];
        // ==========================================
        
        // ============== Get PCD / BCD ----------------------------
        $sStyleLevel = $_GET["stylelevel"];
        $dtPCDDate   = $_GET["dtpcd"];
        
	$result=saveModifiedOrder($orderNo,$styleID,$companyID,$description,$buyerID,$qty,$Coordinator,$status,$customerRefNo,$smv,$date,$smvRate,$fob,$finance,$userID,$approvedBy,$appRemarks,$AppDate,$exPercentage,$finPercntage,$approvalNo,$revisedReason,$revisedDate,$revisedBy,$confirmedPrice,$conPriceCurrency,$commission,$efficiencyLevel,$costPerMinute,$dateSentForApprovals,$sentForApprovalsTo,$deliverTo,$freightCharges,$ECSCharge,$labourCost,$buyingOfficeId,$divisionId,$seasonId,$RPTMark,$subContractQty,$subContractSMV,$subContractRate,$subTransportCost,$subCM,$lineNos,$profit,$uPCharges,$UPChargeDescription,$fabFinance,$trimFinance,$newCM,$newSMV,$firstApprovedBy,$FirstAppDate,$ScheduleMethod,$orderUnit,$proSubcat,$facProfit,$orderType,$mafactureCompanyID,$dblPackSMV,$sStyleLevel,$dtPCDDate);
	
	updateItemDetails($styleID,$qty,$exPercentage);
	
	clearGarbage($styleID);
	updateEfficiancy($styleID,$qty,$smvRate);
	if($status=="10")
	{
		
		global $db;
		$sql="SELECT strManagerEmail FROM companies c where intCompanyID='".$companyID."';";
			$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
		$reciever=$row["strManagerEmail"];
		}
		$sql="SELECT UserName,Name FROM useraccounts where intUserID=".$userID.";";
		$resultUser=$db->RunQuery($sql);
		while($row=mysql_fetch_array($resultUser))
		{
		$senderEmail=$row["UserName"];
		$senderName=$row["Name"];
		}

	include "EmailSender.php";
	$eml =  new EmailSender();
	
	$usermessage 	= $_GET["comments"];
	$serverIp 		= $_SERVER["SERVER_ADDR"];
	$body 		= "User Comments : $usermessage<br><br>".	
				 "<a href=http://".$serverIp."/gapro/preorderReportFirstApprove.php?styleID=$styleID>To view and approve a style click here</a>";			
	$fieldName = 'intFirstAppUserId';
	$styleName =  GetStyle($styleID);
	$subject = "Style Name: $styleName For First Approval";				
	$eml->SendMail($fieldName,$body,$sender,$reciever,$subject);
		
	}
	
	$ResponseXML.="<SaveOrder>";
	//$ResponseXML.="<SaveState><![CDATA[".$result."]]></SaveState>\n";
	$ResponseXML.="<SaveState><![CDATA[True]]></SaveState>\n";
	$ResponseXML.="</SaveOrder>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"SaveItems")==0)
{
	$ResponseXML="";
	$strOrderNo=$_GET["OrderNo"];
	$strStyleID=$_GET["StyleNo"];
	$intMatDetailID=$_GET["ItemCode"];
	$strUnit=$_GET["unitType"];
	$dblUnitPrice=$_GET["UnitPrice"];
	$reaConPc=$_GET["ConPc"];
	$reaWastage=$_GET["wastage"];
	$strCurrencyID="";
	$intOriginNo=$_GET["origin"];
	$dblReqQty=$_GET["ReqQty"];
	$dblTotalQty=$_GET["totalQty"];
	$dblTotalValue=$_GET["value"];
	$dbltotalcostpc=$_GET["price"];
	$freight=$_GET["freight"];
	$mill=$_GET["mill"];
	$mainFabricStatus=$_GET["mainFabricStatus"];
        $isWashable = $_GET["washable"];
	
	$sql = "SELECT * FROM orderdetails WHERE  intStyleId = '$strStyleID' AND intMatDetailID = '$intMatDetailID'";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
	$intStyleId=$row["intStyleId"];
	$intMatDetailID=$row["intMatDetailID"];
	}
	
		if(mysql_num_rows($result))
		{
	   		$sqlUpdate = " UPDATE orderdetails SET strOrderNo = '$strOrderNo' , strUnit = '$strUnit' , dblUnitPrice = '$dblUnitPrice' , reaConPc = '$reaConPc', reaWastage = '$reaWastancyID' , intOriginNo = '$intOriginNo' , dblReqQty = '$dblReqQty' , dblTotalQty ='$dblTotalQty', strCurrencyID = '$strCurrencyID', dblTotalValue ='$dblTotalValue' , dbltotalcostpc = '$dbltotalcostpc' , dblFreight = '$freight' , 
intMillId = '0' , intMainFabricStatus = '0' , intstatus = '1'
WHERE  intStyleId = '$intStyleId' AND intMatDetailID = '$intMatDetailID'";
						  	
			$resultUpdate = $db->RunQuery($sqlUpdate);				
		}
		else
		{
			 //$sqlInsert = "insert into orderdetails(strOrderNo,intStyleId,intMatDetailID,strUnit,dblUnitPrice,reaConPc,reaWastage,strCurrencyID,intOriginNo,dblReqQty,dblTotalQty,dblTotalValue,dbltotalcostpc,dblFreight,intMillId,intMainFabricStatus,intstatus) values ('$strOrderNo','$strStyleID','$intMatDetailID','$strUnit','$dblUnitPrice','$reaConPc','$reaWastage','$strCurrencyID','$intOriginNo','$dblReqQty','$dblTotalQty','$dblTotalValue','$dbltotalcostpc','$freight','0','0','1');";
			 $sqlInsert = "insert into orderdetails(strOrderNo,intStyleId,intMatDetailID,strUnit,dblUnitPrice,reaConPc,reaWastage,strCurrencyID,intOriginNo,dblReqQty,dblTotalQty,dblTotalValue,dbltotalcostpc,dblFreight,intMillId,intMainFabricStatus,intstatus, booWashable) values ('$strOrderNo','$strStyleID','$intMatDetailID','$strUnit','$dblUnitPrice','$reaConPc','$reaWastage','$strCurrencyID','$intOriginNo','$dblReqQty','$dblTotalQty','$dblTotalValue','$dbltotalcostpc','$freight','0','0','1','$isWashable');";
		
			$resultInsert = $db->RunQuery($sqlInsert);	
		
		}
		
	$ResponseXML.="<SaveOrderDeatils>";
	$ResponseXML.="<SaveState><![CDATA[True]]></SaveState>\n";
	$ResponseXML.="</SaveOrderDeatils>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"UpdateItems")==0)
{
	$ResponseXML="";
	$strOrderNo=$_GET["OrderNo"];
	$strStyleID=$_GET["StyleNo"];
	$intMatDetailID=$_GET["ItemCode"];
	$strUnit=$_GET["unitType"];
	$dblUnitPrice=$_GET["UnitPrice"];
	$reaConPc=$_GET["ConPc"];
	$reaWastage=$_GET["wastage"];
	$strCurrencyID="";
	$intOriginNo=$_GET["origin"];
	$dblReqQty=$_GET["ReqQty"];
	$dblTotalQty=$_GET["totalQty"];
	$dblTotalValue=$_GET["value"];
	$dbltotalcostpc=$_GET["price"];
	$freight=$_GET["freight"];
	$mill=$_GET["mill"];
	$mainFabric=$_GET["mainFabric"];
        $IsToBeWashed = $_GET["iswashed"];
	
	RemoveVariations($intMatDetailID,$strStyleID);
	//$result=UpdateOrderDetails($strOrderNo,$strStyleID,$intMatDetailID,$strUnit,$dblUnitPrice,$reaConPc,$reaWastage,$strCurrencyID,$intOriginNo,$dblReqQty,$dblTotalQty,$dblTotalValue,$dbltotalcostpc,$freight,$mill,$mainFabric);
	$result=UpdateOrderDetails($strOrderNo,$strStyleID,$intMatDetailID,$strUnit,$dblUnitPrice,$reaConPc,$reaWastage,$strCurrencyID,$intOriginNo,$dblReqQty,$dblTotalQty,$dblTotalValue,$dbltotalcostpc,$freight,$mill,$mainFabric,$IsToBeWashed);
	$ResponseXML.="<SaveOrderDeatils>";
	$ResponseXML.="<SaveState><![CDATA[True]]></SaveState>\n";
	$ResponseXML.="</SaveOrderDeatils>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"DeleteItemInfo")==0)
{
	$ResponseXML="";
	$strStyleID=$_GET["StyleNo"];
	$intMatDetailID=$_GET["ItemCode"];
	RemoveVariations($intMatDetailID,$strStyleID);
	RemoveItemDetails($intMatDetailID,$strStyleID);
	$ResponseXML.="<DeleteItem>";
	$ResponseXML.="<DeleteStatus><![CDATA[True]]></DeleteStatus>\n";
	$ResponseXML.="</DeleteItem>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"SaveVariations")==0)
{
	$ResponseXML="";
	$strStyleID=$_GET["StyleNo"];
	$strMatDetailID=$_GET["ItemCode"];
	$intNo=$_GET["IncID"];
	$dblConPc=$_GET["conpc"];
	$dblUnitPrice=$_GET["unitprice"];
	$dblWastage=$_GET["wastage"];
	$strColor=$_GET["color"];
	$strRemarks="";
	$intQty=$_GET["qty"];
	$strSize=$_GET["size"];
	if (is_null($intQty) || $intQty == "")
		$intQty = 0;
	$result=SaveVariations($strStyleID,$strMatDetailID,$intNo,$dblConPc,$dblUnitPrice,$dblWastage,$strColor,$strRemarks,$intQty,$strSize);
	
	if($strColor!= "")
	{
		$buyerID = "0";
		$divisionID = "0";
		$colorAvailable = false;
		$sql = "SELECT intBuyerID,intDivisionId FROM orders WHERE intStyleId = '$strStyleID'";
		
		$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$buyerID = $row["intBuyerID"];
			$divisionID = $row["intDivisionId"];
			
			$sql = "SELECT strColor FROM colors WHERE strColor = '$strColor' AND intCustomerId = '$buyerID' AND intDivisionID = '$divisionID'";
			$resultcolor=$db->RunQuery($resultcolor);
			
			while($row=mysql_fetch_array($result))
			{
				$colorAvailable = true;
			}	
			break;
		}
		if(!$colorAvailable)
		{
				$sql = "INSERT INTO colors 
	(strColor, 
	intCustomerId, 
	intDivisionID, 
	strDescription
	)
	VALUES
	('$strColor', 
	'$buyerID', 
	'$divisionID', 
	''
	);";
			$db->ExecuteQuery($sql);
				
		}
	}
	
//	$ResponseXML.="<SaveVariations>";
//		$ResponseXML.="<SaveState><![CDATA[" .$result. "]]></SaveState>\n";
//		$ResponseXML.="</SaveVariations>";
	
}
else if(strcmp($RequestType,"SaveSchedule")==0)
{
	//StyleNo=' + StyleNo + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + remarks,
	$ResponseXML="";
	$strStyleID=$_GET["StyleNo"];
	$dtDateofDelivery=$_GET["ScheduleDate"];
	$dblQty=$_GET["qty"];
	$exQty=$_GET["exqty"];
	$modeID=$_GET["modeID"];
	$dbExQty=$_GET["exqty"];
	$isbase = $_GET["isbase"];
	$bpo = $_GET["bpo"];
	$refNo = $_GET["refNo"];
	$year = substr($dtDateofDelivery,-4);
	$month = substr($dtDateofDelivery,-7,-5);
	$day = substr($dtDateofDelivery,-10,-8);
	$remarks = $_GET["remarks"];
	$leadID = $_GET["LeadID"];
	$dtDateofDelivery = $year . "-" . $month . "-" . $day;
	
	$dtestimated=$_GET["estimateddate"];
	$year = substr($dtestimated,-4);
	$month = substr($dtestimated,-7,-5);
	$day = substr($dtestimated,-10,-8);
	$dtestimated = $year . "-" . $month . "-" . $day;
	
	$handoverDate=$_GET["handoverDate"];
	$year = substr($handoverDate,-4);
	$month = substr($handoverDate,-7,-5);
	$day = substr($handoverDate,-10,-8);
	$handoverDate = $year . "-" . $month . "-" . $day;
	
	$userID 		= $_SESSION["UserID"];
	$dtmDate 		= date('Y-m-d');
	$contry			= $_GET["contry"];
	
	//====================================================
	// Description - Add delivery status and cutoff date to the delivery schedule 
	// Change On   - 2015/08/14
	// Chnage By   - Nalin Jayakody
	//====================================================
	$deliveryStatus = $_GET["deliStatus"];
	$dtCutOffDate	= $_GET["cutOffDate"];
	$year = substr($dtCutOffDate,-4);
	$month = substr($dtCutOffDate,-7,-5);
	$day = substr($dtCutOffDate,-10,-8);
	$dtCutOffDate = $year . "-" . $month . "-" . $day;
	//====================================================
	
	$intManuLocationId = $_GET["manuLocationId"];
	
	
	//$result=saveDeliveryDetails($strStyleID,$dtDateofDelivery,$dblQty,$exQty,$modeID,$dbExQty,$isbase,$leadID,$remarks,$dtestimated,$userID,$dtmDate,$handoverDate,$bpo,$refNo,$dtestimated,$contry,$deliveryStatus,$dtCutOffDate);
	
	$result=saveDeliveryDetails($strStyleID,$dtDateofDelivery,$dblQty,$exQty,$modeID,$dbExQty,$isbase,$leadID,$remarks,$dtestimated,$userID,$dtmDate,$handoverDate,$bpo,$refNo,$dtestimated,$contry,$deliveryStatus,$dtCutOffDate, $intManuLocationId);
	
	$needSendMail = $_GET["needSendMail"];
	if($needSendMail == 'Y')
	{
		include "EmailSender.php";
		$eml =  new EmailSender();
		$today = date("F j, Y, g:i a");      
		$userName     = getUserName();
		$styleName =  GetStyle($strStyleID);
		
		
		$body 		= "Style Name    : $styleName <br>
					   Delivery Date : $dtDateofDelivery <br>
					   Quantity      : $dblQty  <br>
					   Changed User  : $userName &nbsp;  - &nbsp;  $today   <br>
					   Reason        : $remarks  <br>
					   Objective     : For your information <br>	 ";	
					   	
		$fieldName = 'intEditBomDelScheduleId';
		$sender = '';
		$reciever = '';
		
		$subject = "Style Name: $styleName New Delivery Schedule in BOM";				
		$eml->SendMail($fieldName,$body,$sender,$reciever,$subject);
	}
	$ResponseXML.="<SaveDiliveryDetail>";
	$ResponseXML.="<SaveState><![CDATA[True]]></SaveState>\n";
	$ResponseXML.="</SaveDiliveryDetail>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"ChangeSchedule")==0)
{
	//StyleNo=' + StyleNo + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + remarks,
	$ResponseXML="";
	$strStyleID=$_GET["StyleNo"];
	$dtDateofDelivery=$_GET["ScheduleDate"];
	$oldDate = $_GET["oldDate"];
	$dblQty=$_GET["qty"];
	$exQty=$_GET["exqty"];
	$modeID=$_GET["modeID"];
	$dbExQty=$_GET["exqty"];
	$isbase = $_GET["isbase"];
	$bpo = $_GET["bpo"];
	$refNo = $_GET["refNo"];
	$year = substr($dtDateofDelivery,-4);
	$month = substr($dtDateofDelivery,-7,-5);
	$day = substr($dtDateofDelivery,-10,-8);
	$remarks = $_GET["remarks"];
	$leadID = $_GET["LeadID"];
	$dtDateofDelivery = $year . "-" . $month . "-" . $day;
	$oldyear = substr($oldDate,-4);
	$oldmonth = substr($oldDate,-7,-5);
	$oldday = substr($oldDate,-10,-8);
	$oldDate = $oldyear . "-" . $oldmonth . "-" . $oldday;
	
	$dtEstimated=$_GET["estimateddate"];
	$year = substr($dtEstimated,-4);
	$month = substr($dtEstimated,-7,-5);
	$day = substr($dtEstimated,-10,-8);
	$dtEstimated = $year . "-" . $month . "-" . $day;
	
	$handOverdate=$_GET["handOverdate"];
	$year = substr($handOverdate,-4);
	$month = substr($handOverdate,-7,-5);
	$day = substr($handOverdate,-10,-8);
	$handOverdate = $year . "-" . $month . "-" . $day;
	
	$userID = $_SESSION["UserID"];
	$dtmDate = date('Y-m-d');
	$contry = $_GET["cboCountries"];
	
	$deiverystatus 	= $_GET["deliveryStatus"];
	$cutoffdate		= $_GET["cutoff"];
	
	$year = substr($cutoffdate,-4);
	$month = substr($cutoffdate,-7,-5);
	$day = substr($cutoffdate,-10,-8);
	$cutoffdate = $year . "-" . $month . "-" . $day;
	
	
	
	$result=ChangeAndSaveDeliveryDetails($strStyleID,$dtDateofDelivery,$dblQty,$exQty,$modeID,$dbExQty,$isbase,$leadID,$remarks,$oldDate,$dtEstimated,$userID,$dtmDate,$bpo,$refNo,$handOverdate,$contry,$deiverystatus,$cutoffdate);
	
	$updateneed = $_GET["updateEventSchedule"];
	
	
	//start 2010-10-06 update eventschedule details need when buyer PO delivery exists. Orit apperals don't need BPO wise
	//delivery -------------Do not delete
	/*$sql = "UPDATE eventscheduleheader SET dtDeliveryDate = '$dtDateofDelivery' WHERE dtDeliveryDate = '$oldDate' AND intStyleId = '$strStyleID';";
	$db->ExecuteQuery($sql);
	if($updateneed  == "Y")
	{		
	$sql = "SELECT intScheduleId FROM eventscheduleheader WHERE intStyleId = '$strStyleID' AND dtDeliveryDate = '$dtDateofDelivery'";
	
	$eventresult = $db->RunQuery($sql);
	while($eventrow = mysql_fetch_array($eventresult))
	{
		
		$scheduleID = $eventrow["intScheduleId"];
		$sql = "SELECT intEventID,reaOffset FROM eventtemplatedetails INNER JOIN eventtemplateheader ON 
eventtemplatedetails.intSerialNo = eventtemplateheader.intSerialNO 
WHERE eventtemplateheader.intBuyerID = (SELECT intBuyerID FROM orders WHERE intStyleId = '$strStyleID') 
AND eventtemplateheader.intSerialNO =  (SELECT intSerialNO FROM deliveryschedule WHERE intStyleId = '$strStyleID' AND dtDateofDelivery = '$dtDateofDelivery' )";
		
		//echo $sql;
		$resultschedule=$db->RunQuery($sql);
		while($rowschedule=mysql_fetch_array($resultschedule))
		{
			
			$offset = $rowschedule["reaOffset"];
			$eventID = $rowschedule["intEventID"];
			$updated = false;
			
			$sql = "SELECT * FROM eventscheduledetail WHERE intScheduleId = '$scheduleID' AND intEventId = '$eventID'";
			$dataresult = $db->RunQuery($sql);
			
			while($rowresult = mysql_fetch_array($dataresult))
			{	
				
				$sql = "UPDATE eventscheduledetail SET dtmEstimateDate = DATE_ADD('$dtDateofDelivery', INTERVAL $offset DAY) WHERE intScheduleId = '$scheduleID' AND intEventId = '$eventID' AND 
 ISNULL(dtCompleteDate) AND ISNULL(dtChangeDate) ;";
			
				$db->executeQuery($sql);
				$updated = true;
			}
			
			if(!$updated)
			{
				$sql = "INSERT INTO eventscheduledetail 
							(intScheduleId, 
							intEventId, 
							dtmEstimateDate
							)
							VALUES
							('$scheduleID', 
							'$eventID', 
							DATE_ADD('$dtDateofDelivery', INTERVAL $offset DAY) 
							);";
		
				$db->executeQuery($sql);
				
							
			}
	
		}
		
		$sql ="DELETE FROM eventscheduledetail WHERE intEventId NOT IN 
(SELECT intEventID FROM eventtemplatedetails INNER JOIN eventtemplateheader ON 
eventtemplatedetails.intSerialNo = eventtemplateheader.intSerialNO 
WHERE eventtemplateheader.intBuyerID = (SELECT intBuyerID FROM orders WHERE intStyleId = '$strStyleID') 
AND eventtemplateheader.intSerialNO =  (SELECT intSerialNO FROM deliveryschedule WHERE intStyleId = '$strStyleID' AND dtDateofDelivery = '$dtDateofDelivery' ))
AND ISNULL(dtCompleteDate) AND ISNULL(dtChangeDate)";
$db->executeQuery($sql);
	}
	
	}
	removeScheduleBPOAllocation($strStyleID,$oldDate);
	
*/		
	
	//-------------------------end---------------------------------------------------------------------
	
	//start 2010-10-06 send email to authorized users when update the delivery schedule in the BOM
	$needSendMail =  $_GET["needSendMail"];
	
	
	//echo $needSendMail;
	if($needSendMail == 'Y')
	{
		include "EmailSender.php";
		$eml =  new EmailSender();
		$today = date("F j, Y, g:i a");      
		$userName     = getUserName();
		$styleName =  GetStyle($strStyleID);
		$prevQty   = getDeliveryQty($strStyleID,$oldDate);
		
		$body 		= "Style Name    : $styleName <br>
					   Delivery Date : $oldDate &nbsp; - &nbsp;    $dtDateofDelivery <br>
					   Quantity      : $dblQty  &nbsp; - &nbsp;     $prevQty <br>
					   Changed User  : $userName &nbsp;  - &nbsp;  $today   <br>
					   Reason to Edit : $remarks  <br>
					   Objective     : For your information <br>	 ";		
		$fieldName = 'intEditBomDelScheduleId';
		$sender = '';
		$reciever = '';
		
		$subject = "Style Name: $styleName Edit Delivery Schedule in BOM";				
		$eml->SendMail($fieldName,$body,$sender,$reciever,$subject);
	}
	//-------------- end ----------------------------------------------------------------------
	$ResponseXML.="<SaveDiliveryDetail>";
	$ResponseXML.="<SaveState><![CDATA[True]]></SaveState>\n";
	$ResponseXML.="</SaveDiliveryDetail>";
	echo $ResponseXML;
}

else if(strcmp($RequestType,"DeleteSchedule")==0)
{
	//StyleNo=' + StyleNo + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + remarks,
	$ResponseXML="";
	$strStyleID=$_GET["StyleNo"];
	$dtDateofDelivery=$_GET["ScheduleDate"];
        $strBPO = $_GET["ScheduleDate"];
	$year = substr($dtDateofDelivery,-4);
	$month = substr($dtDateofDelivery,-7,-5);
	$day = substr($dtDateofDelivery,-10,-8);
	$dtDateofDelivery = $year . "-" . $month . "-" . $day;
        
        // =======================================================
        // Comment On - 02/22/2017
        // Comment By - Nalin Jayakody
        // Comment For - To add buyer po number instead of delivery date
        // ========================================================        
            /*removeDeleverySchedule($strStyleID,$dtDateofDelivery);
            removeScheduleBPOAllocation($strStyleID,$dtDateofDelivery);
            removeStyleBuyerPos($strStyleID,$dtDateofDelivery);*/
        // ========================================================

        # ==============================================
        removeDeleverySchedule($strStyleID,$strBPO);
	removeScheduleBPOAllocation($strStyleID,$strBPO);
	removeStyleBuyerPos($strStyleID,$strBPO);
        
        # ==============================================
	
	$ResponseXML.="<SaveDiliveryDetail>";
	$ResponseXML.="<SaveState><![CDATA[True]]></SaveState>\n";
	$ResponseXML.="</SaveDiliveryDetail>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"ClearEventScheduleGarbage")==0)
{
	$styleID = $_GET["StyleNo"];
	clearGarbage($styleID);
	
}
else if(strcmp($RequestType,"getStyleName")==0)
{
	$ResponseXML="";
	$InputLatter=$_GET["InputLatter"];
	$result=getStyleName($InputLatter);
	$ResponseXML.="<StyleNo>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<Style><![CDATA[" .$row["strStyleID"]. "]]></Style>\n";
						
	}
	
	$ResponseXML.="</StyleNo>";
	echo $ResponseXML;
	
	
}
else if(strcmp($RequestType,"loadStyletoSCNo")==0)
{
	$ResponseXML = "";
	$srNo = $_GET['srNo'];
	//$result = loadStyletoSCNo($SCNo); 
	$ResponseXML .= "<Style>";
	 $sql="SELECT
specification.intSRNO,
orders.strStyle,
orders.intStyleId
FROM
orders
Inner Join specification ON specification.intStyleId = orders.intStyleId
WHERE specification.intSRNO = '$srNo'";

	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		//$strStyle .=  $row["intStyleId"] ;
		$ResponseXML.="<StyleName><![CDATA[" .$row["strStyle"] . "]]></StyleName>\n";
		$ResponseXML.="<StyleId><![CDATA[" .$row["intStyleId"]. "]]></StyleId>\n";
		//$intStyleId .= "<option value=\"". $row["intStyleId"] ."\">" . $row["intStyleId"] ."</option>"; 
		
	}
	
	$ResponseXML .="</Style>";
	echo $ResponseXML;
}

else if(strcmp($RequestType,"getAcknowledgement")==0)
{

	$ResponseXML="";
	$StyleNo=$_GET["StyleNo"];
	$ItemsCount=$_GET["ItemsCount"];
	$VariationCount=$_GET["VariationCount"];
	$ScheduleCount=$_GET["ScheduleCount"];
	$ResponseXML.="<Acknowledgement>";
	$ResponseXML.="<Style><![CDATA[" .getAcknowledgementOrders($StyleNo). "]]></Style>\n";
	$ResponseXML.="<Items><![CDATA[" .getAcknowledgementItems($StyleNo,$ItemsCount). "]]></Items>\n";
	$ResponseXML.="<Variations><![CDATA[" .getAcknowledgementVari($StyleNo,$VariationCount). "]]></Variations>\n";
	$ResponseXML.="<Schedules><![CDATA[" .getAcknowledgementDelivery($StyleNo,$ScheduleCount). "]]></Schedules>\n";
	$ResponseXML.="</Acknowledgement>";
	echo $ResponseXML;
	
	
}
else if(strcmp($RequestType,"IsExistingStyle")==0)
{
	$ResponseXML="";
	$StyleNo=$_GET["StyleNo"];
	$ResponseXML.="<ExistStyle>";
	$ResponseXML.="<Style><![CDATA[" .getAcknowledgementOrders($StyleNo). "]]></Style>\n";
	$ResponseXML.="</ExistStyle>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"getOrderData")==0)
{
	$ResponseXML="";
	$styleID=$_GET["StyleID"];
	
	//start 2010-09-13 get style status from orders to get order inquiry style details
	$styleStatus = getStyleStatus($styleID);
	$result=getOrdersData($styleID,$styleStatus);
	//end--------------------------------------------------------------------------------
	
	//start 2011-06-28 get purchase qty ---------------------------------
	$purchQty = getPurchasedQty($styleID,'');
	//end 2011-06-28 ------------------------------------------
	
	//$result=getOrdersData($styleID);
	$ResponseXML.="<Orderdata>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<OrderNo><![CDATA[" .$row["strOrderNo"]. "]]></OrderNo>\n";
		$ResponseXML.="<StyleName><![CDATA[" .$row["strStyle"]. "]]></StyleName>\n";
		$ResponseXML.="<StyleID><![CDATA[" .$row["intStyleId"]. "]]></StyleID>\n";
		$ResponseXML.="<CompanyID><![CDATA[" .$row["intCompanyID"]. "]]></CompanyID>\n";
		$ResponseXML.="<Description><![CDATA[" .$row["strDescription"]. "]]></Description>\n";
		$ResponseXML.="<BuyerID><![CDATA[" .$row["intBuyerID"]. "]]></BuyerID>\n";
		$ResponseXML.="<intQty><![CDATA[" .$row["intQty"]. "]]></intQty>\n";
		$ResponseXML.="<Status><![CDATA[" .$row["intStatus"]. "]]></Status>\n";
		$ResponseXML.="<CustomerRefNo><![CDATA[" .$row["strCustomerRefNo"]. "]]></CustomerRefNo>\n";
		$ResponseXML.="<SMVRate><![CDATA[" .$row["reaSMVRate"]. "]]></SMVRate>\n";
		$ResponseXML.="<FOB><![CDATA[" .$row["reaFOB"]. "]]></FOB>\n";
		$ResponseXML.="<Finance><![CDATA[" .$row["reaFinance"]. "]]></Finance>\n";
		$ResponseXML.="<UserID><![CDATA[" .$row["intUserID"]. "]]></UserID>\n";
		$ResponseXML.="<FinPercntage><![CDATA[" .$row["reaFinPercntage"]. "]]></FinPercntage>\n";
		$ResponseXML.="<EfficiencyLevel><![CDATA[" .$row["reaEfficiencyLevel"]. "]]></EfficiencyLevel>\n";
		$ResponseXML.="<CostPerMinute><![CDATA[" .$row["reaCostPerMinute"]. "]]></CostPerMinute>\n";
		$ResponseXML.="<ECSCharge><![CDATA[" .$row["reaECSCharge"]. "]]></ECSCharge>\n";
		$ResponseXML.="<BuyingOfficeId><![CDATA[" .$row["intBuyingOfficeId"]. "]]></BuyingOfficeId>\n";
		$ResponseXML.="<DivisionId><![CDATA[" .$row["intDivisionId"]. "]]></DivisionId>\n";
		$ResponseXML.="<SeasonId><![CDATA[" .$row["intSeasonId"]. "]]></SeasonId>\n";
		$ResponseXML.="<RPTMark><![CDATA[" .$row["strRPTMark"]. "]]></RPTMark>\n";
		$ResponseXML.="<LineNos><![CDATA[" .$row["intLineNos"]. "]]></LineNos>\n";
		$ResponseXML.="<UPCharges><![CDATA[" .$row["reaUPCharges"]. "]]></UPCharges>\n";
		$ResponseXML.="<UPChargesReason><![CDATA[" .$row["strUPChargeDescription"]. "]]></UPChargesReason>\n";
		$ResponseXML.="<AppDate><![CDATA[" .$row["dtmAppDate"]. "]]></AppDate>\n";
		$ResponseXML.="<ExPercentage><![CDATA[" .$row["reaExPercentage"]. "]]></ExPercentage>\n";
		$ResponseXML.="<SMV><![CDATA[" .$row["reaSMV"]. "]]></SMV>\n";
		$ResponseXML.="<Profit><![CDATA[" .$row["reaProfit"]. "]]></Profit>\n";
		$ResponseXML.="<SheduleMethod><![CDATA[" .$row["strScheduleMethod"]. "]]></SheduleMethod>\n";
		$ResponseXML.="<SubQty><![CDATA[" .$row["intSubContractQty"]. "]]></SubQty>\n";
		$ResponseXML.="<orderUnit><![CDATA[" .$row["orderUnit"]. "]]></orderUnit>\n";
		$ResponseXML.="<proSubcat><![CDATA[" .$row["productSubCategory"]. "]]></proSubcat>\n";		
		$ResponseXML.="<Coordinator><![CDATA[" .$row["intCoordinator"]. "]]></Coordinator>\n";	
		$ResponseXML.="<labourCost><![CDATA[" .$row["reaLabourCost"]. "]]></labourCost>\n";		
		$ResponseXML.="<facProfit><![CDATA[" .$row["dblFacProfit"]. "]]></facProfit>\n";
		$ResponseXML.="<IsSampleOrder><![CDATA[" .$row["intOrderType"]. "]]></IsSampleOrder>\n";
		$ResponseXML.="<manufacCompany><![CDATA[" .$row["intManufactureCompanyID"]. "]]></manufacCompany>\n";
                
                // ======================================================
                // Adding On - 02/09/2017
                // Adding By - Nalin Jayakody
                // Adding For - Get status of embellishment of that order.
                // ======================================================
                $ResponseXML.="<IsPrint><![CDATA[" .$row["intPrint"]. "]]></IsPrint>\n";
                $ResponseXML.="<IsEmb><![CDATA[" .$row["intEMB"]. "]]></IsEmb>\n";
                $ResponseXML.="<IsHeatSeal><![CDATA[" .$row["intHeatSeal"]. "]]></IsHeatSeal>\n";
                $ResponseXML.="<IsHandWork><![CDATA[" .$row["intHW"]. "]]></IsHandWork>\n";
                $ResponseXML.="<IsOther><![CDATA[" .$row["intOther"]. "]]></IsOther>\n";
                $ResponseXML.="<IsNA><![CDATA[" .$row["intNA"]. "]]></IsNA>\n";
                $ResponseXML.="<PackSMV><![CDATA[" .$row["reaPackSMV"]. "]]></PackSMV>\n";
                $ResponseXML.="<StyleLevel><![CDATA[" .$row["sStyleLevel"]. "]]></StyleLevel>\n";
                $ResponseXML.="<PCD><![CDATA[" .$row["dtPCD"]. "]]></PCD>\n";
                
                
                // ======================================================
                
		if($styleStatus != '2')
		{
			
			// ======================================================
			// Comment On - 02/25/2016
			// Comment By - Nalin Jayakody
			// Comment For - To change the Fac OH cost in given time, 
			// ======================================================

			/* $ResponseXML.="<facCostPerMin><![CDATA[" .$row["reaFactroyCostPerMin"]. "]]></facCostPerMin>\n";	*/ 
			// ======================================================

			$ResponseXML.="<facCostPerMin><![CDATA[" .$row["dblFacOHCostMin"]. "]]></facCostPerMin>\n";
		}
		else
		{
			$CPM =0;
			$ResponseXML.="<facCostPerMin><![CDATA[" .$CPM. "]]></facCostPerMin>\n";	
		}
		if($purchQty>0)
			$ResponseXML.="<ISpurchase><![CDATA[TRUE]]></ISpurchase>\n";
		else
			$ResponseXML.="<ISpurchase><![CDATA[FALSE]]></ISpurchase>\n";		
	}
	
	$ResponseXML.="</Orderdata>";
	echo $ResponseXML;
	
}

else if(strcmp($RequestType,"getFacCmvVal")==0)
{
	$ResponseXML="";
	$factoryID=$_GET["factoryID"];
	
	$ResponseXML.="<CMVdata>";
	$sql = " select reaFactroyCostPerMin from companies where intCompanyID='$factoryID'";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<facCostPerMin><![CDATA[" .$row["reaFactroyCostPerMin"]. "]]></facCostPerMin>\n";	
	}
	$ResponseXML.="</CMVdata>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"getOrderDetailData")==0)
{
	$ResponseXML="";
	$styleID=$_GET["StyleID"];
	$result=getOrderDetailsData($styleID);
	$ResponseXML.="<Orderdata>";
	while($row=mysql_fetch_array($result))
	{
		$OriginDet =  getOrigineName($row["intOriginNo"]);
		$arrOrigin = explode('*',$OriginDet);
		
		$ResponseXML.="<OrderNo><![CDATA[" .$row["strOrderNo"]. "]]></OrderNo>\n";
		$ResponseXML.="<MatDetailID><![CDATA[" .$row["intMatDetailID"]. "]]></MatDetailID>\n";
		$ResponseXML.="<ItemName><![CDATA[" .$row["strItemDescription"]. "]]></ItemName>\n";
		$ResponseXML.="<OrigineName><![CDATA[" .$arrOrigin[1]. "]]></OrigineName>\n";
		$ResponseXML.="<Unit><![CDATA[" .$row["strUnit"]. "]]></Unit>\n";		
		$ResponseXML.="<UnitPrice><![CDATA[" .$row["dblUnitPrice"]. "]]></UnitPrice>\n";
		$ResponseXML.="<ConPc><![CDATA[" .$row["reaConPc"]. "]]></ConPc>\n";
		$ResponseXML.="<Wastage><![CDATA[" .$row["reaWastage"]. "]]></Wastage>\n";
		$ResponseXML.="<OriginNo><![CDATA[" .$row["intOriginNo"]. "]]></OriginNo>\n";
		$ResponseXML.="<ReqQty><![CDATA[" .$row["dblReqQty"]. "]]></ReqQty>\n";
		$ResponseXML.="<TotalQty><![CDATA[" .$row["dblTotalQty"]. "]]></TotalQty>\n";
		$ResponseXML.="<TotalValue><![CDATA[" .$row["dblTotalValue"]. "]]></TotalValue>\n";
		$ResponseXML.="<totalcostpc><![CDATA[" .$row["dbltotalcostpc"]. "]]></totalcostpc>\n";
		$ResponseXML.="<Freight><![CDATA[" .$row["dblFreight"]. "]]></Freight>\n";
		$ResponseXML.="<MainItem><![CDATA[" .getMainItemName($row["intMatDetailID"]). "]]></MainItem>\n";
		$ResponseXML.="<MatMainCat><![CDATA[" .$row["intMainCatID"]. "]]></MatMainCat>\n";
		$purchQty = getPurchasedQty($styleID,$row["intMatDetailID"]);
		$ResponseXML.="<PurchasedAmount><![CDATA[" .$purchQty. "]]></PurchasedAmount>\n";
		if ($purchQty > 0)
		{
			$ResponseXML.="<PurchasedPrice><![CDATA[" .getPerchasedPrice($styleID,$row["intMatDetailID"]). "]]></PurchasedPrice>\n";
		}
		else
		{
			$ResponseXML.="<PurchasedPrice><![CDATA[0]]></PurchasedPrice>\n";
		}
		$ResponseXML.="<Mill><![CDATA[" .$row["intMillId"]. "]]></Mill>\n";
		$ResponseXML.="<MianFabric><![CDATA[" .$row["intMainFabricStatus"]. "]]></MianFabric>\n";
		$ResponseXML.="<OriginType><![CDATA[" .$arrOrigin[0]. "]]></OriginType>\n";	
	}
	$ResponseXML.="</Orderdata>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"getVariationData")==0)
{

	$ResponseXML="";
	$styleID=$_GET["StyleID"];
	$result=getOrderDetailsData($styleID);
	$ResponseXML.="<Variation>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<Material ID='" .$row["intMatDetailID"]. "'>\n";
		$resultvariations=getVariationData($row["intMatDetailID"],$styleID);
		while($rowvar=mysql_fetch_array($resultvariations))
		{
		$ResponseXML.="<intNo ID='" .$row["intMatDetailID"]. "'><![CDATA[" .$rowvar["intNo"]. "]]></intNo>\n";
		$ResponseXML.="<ConPc ID='" .$row["intMatDetailID"]. "'><![CDATA[" .$rowvar["dblConPc"]. "]]></ConPc>\n";
		$ResponseXML.="<UnitPrice ID='" .$row["intMatDetailID"]. "'><![CDATA[" .$rowvar["dblUnitPrice"]. "]]></UnitPrice>\n";
		$ResponseXML.="<Wastage ID='" .$row["intMatDetailID"]. "'><![CDATA[" .$rowvar["dblWastage"]. "]]></Wastage>\n";
		$ResponseXML.="<Color ID='" .$row["intMatDetailID"]. "'><![CDATA[" .$rowvar["strColor"]. "]]></Color>\n";
		$ResponseXML.="<Remark ID='" .$row["intMatDetailID"]. "'><![CDATA[" .$rowvar["strRemarks"]. "]]></Remark>\n";
		$ResponseXML.="<qty ID='" .$row["intMatDetailID"]. "'><![CDATA[" .$rowvar["intqty"]. "]]></qty>\n";
		}		
		$ResponseXML.="</Material>\n";
	}
	$ResponseXML.="</Variation>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"getItemVariationData")==0)
{
	$styleID=$_GET["styleID"];
	$itemCode=$_GET["itemCode"];
	$ResponseXML.="<Variation>";
	$resultvariations=getVariationData($itemCode,$styleID);
	while($rowvar=mysql_fetch_array($resultvariations))
	{
		$ResponseXML.="<intNo ID='" .$_GET["itemCode"]. "'><![CDATA[" .$rowvar["intNo"]. "]]></intNo>\n";
		$ResponseXML.="<ConPc ID='" .$_GET["itemCode"]. "'><![CDATA[" .$rowvar["dblConPc"]. "]]></ConPc>\n";
		$ResponseXML.="<UnitPrice ID='" .$_GET["itemCode"]. "'><![CDATA[" .$rowvar["dblUnitPrice"]. "]]></UnitPrice>\n";
		$ResponseXML.="<Wastage ID='" .$_GET["itemCode"]. "'><![CDATA[" .$rowvar["dblWastage"]. "]]></Wastage>\n";
		$ResponseXML.="<Color ID='" .$_GET["itemCode"]. "'><![CDATA[" .$rowvar["strColor"]. "]]></Color>\n";
		$ResponseXML.="<Remark ID='" .$_GET["itemCode"]. "'><![CDATA[" .$rowvar["strRemarks"]. "]]></Remark>\n";
		$ResponseXML.="<qty ID='" .$_GET["itemCode"]. "'><![CDATA[" .$rowvar["intqty"]. "]]></qty>\n";
		$ResponseXML.="<size ID='" .$_GET["itemCode"]. "'><![CDATA[" .$rowvar["strSize"]. "]]></size>\n";
	}	
	$ResponseXML.="</Variation>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"getDeliveryData")==0)
{

	$ResponseXML="";
	$styleID=$_GET["StyleID"];
	$result=getDeliveryShedule($styleID);
	$ResponseXML.="<Delivery>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<DateofDelivery><![CDATA[" .$row["dtDateofDelivery"]. "]]></DateofDelivery>\n";
		$ResponseXML.="<Qty><![CDATA[" .$row["dblQty"]. "]]></Qty>\n";
		$ResponseXML.="<Remarks><![CDATA[" .$row["strRemarks"]. "]]></Remarks>\n";
		$ResponseXML.="<ShippingModeID><![CDATA[" .$row["strShippingMode"]. "]]></ShippingModeID>\n";
		$ResponseXML.="<ShippingMode><![CDATA[" .getShippingModeByID($row["strShippingMode"]). "]]></ShippingMode>\n";		
		$ResponseXML.="<ExQty><![CDATA[" .$row["dbExQty"]. "]]></ExQty>\n";
		$ResponseXML.="<isBase><![CDATA[" .$row["isDeliveryBase"]. "]]></isBase>\n";
		$ResponseXML.="<LeadTimeID><![CDATA[" .$row["intSerialNO"]. "]]></LeadTimeID>\n";
		$ResponseXML.="<LeadTime><![CDATA[" .$row["reaLeadTime"]. "]]></LeadTime>\n";
		$ResponseXML.="<EstimatedDate><![CDATA[" .$row["estimatedDate"]. "]]></EstimatedDate>\n";
		$ResponseXML.="<intApprovalNo><![CDATA[" .$row["intApprovalNo"]. "]]></intApprovalNo>\n";
		$ResponseXML.="<intbpo><![CDATA[" .$row["intBPO"]. "]]></intbpo>\n";
		$ResponseXML.="<handOverDate><![CDATA[" .$row["dtmHandOverDate"]. "]]></handOverDate>\n";
		$ResponseXML.="<refNo><![CDATA[" .$row["intRefNo"]. "]]></refNo>\n";
		$ResponseXML.="<intCountry><![CDATA[" .$row["intCountry"]. "]]></intCountry>\n";
		
		
		// ===========================================================
		// Description - Get saved delivery status and cut off date from delivery schedule
		// Add On      - 2015/08/14
		// By          - Nalin Jayakody
		// ===========================================================
		$ResponseXML.="<deliStatus><![CDATA[" .$row["intDeliveryStatus"]. "]]></deliStatus>\n";
		$ResponseXML.="<CutOffDate><![CDATA[" .$row["dtmCutOffDate"]. "]]></CutOffDate>\n";	
		
		// ===========================================================
	}
	$ResponseXML.="</Delivery>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"DeleteData_Edit")==0)
{
	$styleID=$_GET["StyleID"];
	deleteData_edit($styleID);
	
}
else if(strcmp($RequestType,"GetApproved")==0)
{
	$ResponseXML="";
	$ComapnyID=$_GET["CompanyID"];
	$result=getApprovedData($ComapnyID);
	$ResponseXML.="<Approve>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<StyleID><![CDATA[" .$row["intStyleId"]. "]]></StyleID>\n";
		$ResponseXML.="<Date><![CDATA[" .$row["dtmDate"]. "]]></Date>\n";
		$ResponseXML.="<Name><![CDATA[" .$row["Name"]. "]]></Name>\n";
	

	}
	$ResponseXML.="</Approve>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"GetApprovedStyleList")==0)
{
	$ResponseXML="";
	$ComapnyID=$_GET["CompanyID"];
	$result=getApprovedDataList($ComapnyID);
	$ResponseXML.="<Approve>";
	while($row=mysql_fetch_array($result))   
	{
		$ResponseXML.="<StyleID><![CDATA[" .$row["intStyleId"]. "]]></StyleID>\n";
		$ResponseXML.="<Date><![CDATA[" .$row["strDescription"]. "]]></Date>\n";
		$ResponseXML.="<Name><![CDATA[" .$row["dtmAppDate"]. "]]></Name>\n";
	

	}
	$ResponseXML.="</Approve>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"GetBuyerApprovedStyleList")==0)
{
	
	$ResponseXML="";
	$BuyerID=$_GET["BuyerID"];
	$result=getBuyerApprovedDataList($BuyerID);
	$ResponseXML.="<Approve>";
	while($row=mysql_fetch_array($result))   
	{
		$ResponseXML.="<StyleID><![CDATA[" .$row["intStyleId"]. "]]></StyleID>\n";
		$ResponseXML.="<Date><![CDATA[" .$row["strDescription"]. "]]></Date>\n";
		$ResponseXML.="<Name><![CDATA[" .$row["dtmAppDate"]. "]]></Name>\n";
	

	}
	$ResponseXML.="</Approve>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"GetTargetStyle")==0)
{
	$ResponseXML="";
	$StyleID=$_GET["StyleNo"];
	$result=getApprovedDataStyle($StyleID);
	$ResponseXML.="<Approve>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<StyleID><![CDATA[" .$row["intStyleId"]. "]]></StyleID>\n";
		$ResponseXML.="<Date><![CDATA[" .$row["dtmDate"]. "]]></Date>\n";
		$ResponseXML.="<Name><![CDATA[" .$row["Name"]. "]]></Name>\n";
	

	}
	$ResponseXML.="</Approve>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"GetTargetApprovedStyle")==0)
{
	$ResponseXML="";
	$StyleID=$_GET["StyleNo"];
	$result=getApprovedDataStyleList($StyleID);
	$ResponseXML.="<Approve>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<StyleID><![CDATA[" .$row["intStyleId"]. "]]></StyleID>\n";
		$ResponseXML.="<Date><![CDATA[" .$row["strDescription"]. "]]></Date>\n";
		$ResponseXML.="<Name><![CDATA[" .$row["dtmAppDate"]. "]]></Name>\n";
	

	}
	$ResponseXML.="</Approve>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"getStyleNo")==0)
{
	$ResponseXML="";
	$InputLatter=$_GET["InputLatter"];
	$result=getAvailableStyles($InputLatter);
	$ResponseXML.="<Styles>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<Style><![CDATA[" .$row["strStyle"]. "]]></Style>\n";
		$ResponseXML.="<StyleId><![CDATA[" .$row["strStyle"]. "]]></StyleId>\n";
	}
	$ResponseXML.="</Styles>";
	echo $ResponseXML;
	
}
else if(strcmp($RequestType,"CopyOrder")==0)
{
	$ResponseXML="<XMLCopyOrder>";
	$sourceStyleName=$_GET["StyleIDSource"];
	$targetStyleName=$_GET["StyleIDTarget"];
	$newuserID = $_GET["userid"];
	$sourceStyleId = $_GET["SourceStyleID"];
	$newStyleName = $_GET["newStyleName"];
	$orderColorCode = $_GET["orderColorCode"];
	$buyerOrderNo = $_GET["buyerOrderNo"];
	//$IsSourceAvailable=getAcknowledgementOrders($sourceStyleName);
	$IsSourceAvailable=isOrderNoavailability($sourceStyleName);
	if($IsSourceAvailable=="False")
	{
		$ResponseXML.="<Result><![CDATA[Sorry, \"Source Order No\" is not available]]></Result>\n";
	}
	else if($IsSourceAvailable=="True")
	{
		$IsTargetAlreayExist=isOrderNoavailability($targetStyleName);
		
		if($IsTargetAlreayExist=="True")
		{
		$ResponseXML.="<Result><![CDATA[\"New Order No\" is already exists.]]></Result>\n";
		}
		else if($IsTargetAlreayExist=="False")
		{
		//$sourceStyleId = GetSavedStyleId($sourceStyleName);		
		
		copyOrderData($sourceStyleId,$targetStyleName,$newuserID,$newStyleName,$orderColorCode,$buyerOrderNo);
		$targetStyleId = GetCopyStyleId($targetStyleName);
			if(getAcknowledgementOrdersNo($targetStyleName)=="True")	
			{
				$ResponseXML.="<Result><![CDATA[The copy order process is successfully completed.]]></Result>\n";
				$ResponseXML.="<TargetStyleId><![CDATA[" . $targetStyleId . "]]></TargetStyleId>\n";	
			}
		}
		
	}
	$ResponseXML.="</XMLCopyOrder>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"DeleteOrder")==0)
{
		$styleID=$_GET["StyleID"];
		$count=0;
		$ResponseXML="";
		deleteData_edit($styleID);
		if(getAcknowledgementOrders($styleID)=="False")
		{
			if(!IsItemsAvailable($styleID))
			{
				if(!IsVariationAvailable($styleID))
				{
					if(!IsDeliveryShedule($styleID))
					{
					$ResponseXML.="<Result><![CDATA[True]]></Result>\n";
					}
					else
					{
						$count++;
					}
					
				}
				else
				{
					$count++;
				}
			}
			else
			{
			     $count++;	
			}
		}
		else
		{
			$count++;
			
		}
		if($count>0)
		{
		$ResponseXML.="<Result><![CDATA[False]]></Result>\n";	
		}
		echo $ResponseXML;
	
}

else if(strcmp($RequestType,"ToBeRevise")==0)
{
	$companyID=$_GET["companyID"];
	$StyleID=$_GET["styleID"];
	$userID=$_SESSION["UserID"];
	$ResponseXML="";
	$ResponseXML.="<ReviseList>";
	global $db;
	
	if(is_null($StyleID))
	{
	$sql="SELECT intStyleId,strDescription,dtmDate,dtmAppDate,(select Name from useraccounts where intUserID=o.intUserID)As DoneBy,(select Name from useraccounts where intUserID=o.intApprovedBy) as approveBY  FROM orders o  where o.intStatus=11 and o.intCompanyID=".$companyID." and o.intUserID=$userID;";
	}
	else if(is_null($companyID))
	{
	$sql="SELECT intStyleId,strDescription,dtmDate,dtmAppDate,(select Name from useraccounts where intUserID=o.intUserID)As DoneBy,(select Name from useraccounts where intUserID=o.intApprovedBy) as approveBY  FROM orders o  where o.intStatus=11 and o.intStyleId like '%".$StyleID."%'  and o.intUserID=$userID;";
	}
	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<StyleID><![CDATA[" .$row["intStyleId"]. "]]></StyleID>\n";
		$ResponseXML.="<Description><![CDATA[" .$row["strDescription"]. "]]></Description>\n";
		$ResponseXML.="<Date><![CDATA[" .$row["dtmDate"]. "]]></Date>\n";
		$ResponseXML.="<AppDate><![CDATA[" .$row["dtmAppDate"]. "]]></AppDate>\n";
		$ResponseXML.="<DoneBy><![CDATA[" .$row["DoneBy"]. "]]></DoneBy>\n";
		$ResponseXML.="<ApproveBy><![CDATA[" .$row["approveBY"]. "]]></ApproveBy>\n";
	}
	
	$ResponseXML.="</ReviseList>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"UpdateRevice")==0)
{
	$StyleID=$_GET["styleID"];
	$revisedReason=$_GET["ReviseReason"];
	$userID=$_SESSION["UserID"];
	$ResponseXML="";
	$ResponseXML.="<ReviseResult>";
	//global $db;
	
	$chkInvConfirmAv = checkInvoiceCostingConfirmAvailability($StyleID);
	
	$reviseOrder = false;
	
	if($chkInvConfirmAv == 1)
	{
		if($reviseOrderAfterDoneInvoiceCosting)
			$reviseOrder = true;
		else
			$reviseOrder = false;	
	}
	else
	{
		$reviseOrder= true;
	}
	
	if($reviseOrder)
	{
		$sql="update orders set intStatus=0, strRevisedReason='".$revisedReason."',strRevisedDate=NOW(),intRevisedBy=".$userID." where intStyleId='$StyleID';";
		
		$result=$db->executeQuery($sql);
	
		if($result)
		{
		$ResponseXML.="<Result><![CDATA[True]]></Result>\n";
		}
	
	

		// Saving Orders to History Orders
		$appNo = 0;
		$sql="SELECT * FROM orders o where intStyleId='".$StyleID."' ;";
		$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$appNo = $row["intApprovalNo"];
			$newOrderQty = $row["intQty"];
			$newExpercentage = $row["reaExPercentage"];
			saveHistoryOrder($row["strOrderNo"],$StyleID,$row["intCompanyID"],$row["strDescription"],$row["intBuyerID"],$row["intQty"],$row["intCoordinator"],$row["intStatus"],$row["strCustomerRefNo"],$row["reaSMV"],$row["dtmDate"],$row["reaSMVRate"],$row["reaFOB"],$row["reaFinance"],$row["intUserID"],$row["intApprovedBy"],$row["strAppRemarks"],$row["dtmAppDate"],$row["reaExPercentage"],$row["reaFinPercntage"],$row["intApprovalNo"] ,$row["strRevisedReason"],$row["strRevisedDate"],$row["intRevisedBy"],$row["reaConfirmedPrice"],$row["strConPriceCurrency"],$row["reaCommission"],$row["reaEfficiencyLevel"],$row["reaCostPerMinute"],$row["dtmDateSentForApprovals"],$row["intSentForApprovalsTo"],$row["strDeliverTo"],$row["reaFreightCharges"],$row["reaECSCharge"],$row["reaLabourCost"],$row["intBuyingOfficeId"],$row["intDivisionId"],$row["intSeasonId"],$row["strRPTMark"],$row["intSubContractQty"],$row["reaSubContractSMV"],$row["reaSubContractRate"],$row["reaSubTransportCost"],$row["reaSubCM"],$row["intLineNos"],$row["reaProfit"],$row["reaUPCharges"],$row["strUPChargeDescription"],$row["reaFabFinance"],$row["reaTrimFinance"],$row["reaNewCM"],$row["reaNewSMV"],$row["intFirstApprovedBy"],$row["dtmFirstAppDate"],$row["strOrderColorCode"],$row["dblFacProfit"]);
			
			
	
		}
	
	
		$sql="SELECT * FROM orderdetails o where intStyleId='".$StyleID."' AND (o.intstatus != '0' or o.intstatus IS NULL);";
		$resultItems=$db->RunQuery($sql);
		while($rowItems=mysql_fetch_array($resultItems))
		{
			// Saving Order details to History Order Details
			saveHistoryOrderDetails($rowItems["strOrderNo"],$StyleID,$rowItems["intMatDetailID"],$rowItems["strUnit"],$rowItems["dblUnitPrice"],$rowItems["reaConPc"],$rowItems["reaWastage"],$rowItems["strCurrencyID"],$rowItems["intOriginNo"],$rowItems["dblReqQty"],$rowItems["dblTotalQty"],$rowItems["dblTotalValue"],$rowItems["dbltotalcostpc"],$rowItems["dblFreight"],$appNo);
			if(IsVariationAvailable($StyleID))
			{
				$resultVari=getVariationData($rowItems["intMatDetailID"],$StyleID);
				while($rowVari=mysql_fetch_array($resultVari))
				{
					// Saving Variations to History Conpccalc
					SaveHistoryVariations($StyleID,$rowVari["strMatDetailID"],$rowVari["intNo"],$rowVari["dblConPc"],$rowVari["dblUnitPrice"],$rowVari["dblWastage"],$rowVari["strColor"],$rowVari["strRemarks"],$rowVari["intqty"],$appNo,$rowVari["strSize"]);
				}
			}	
		}	
		
		$sql = "Delete FROM orderdetails where intStyleId='".$StyleID."';";
		$db->ExecuteQuery($sql);
		
		$sql = "
INSERT INTO orderdetails 
	(strOrderNo, 
	intStyleId, 
	intMatDetailID, 
	strUnit, 
	dblUnitPrice, 
	reaConPc, 
	reaWastage,  
	intOriginNo, 
	dblReqQty, 
	dblTotalQty, 
	dblTotalValue, 
	dbltotalcostpc, 
	dblFreight,
	intMillId,
	intMainFabricStatus,
	intstatus
	)	
SELECT (SELECT strOrderNo FROM orders WHERE intStyleId = '$StyleID')	 AS orderNO,intStyleId, 
	strMatDetailID, 
	strUnit, 
	dblUnitPrice, 
	sngConPc, 
	sngWastage, 
	intOriginNo,
	dblReqQty, 
	dblTotalQty, 
	dblTotalValue, 
	dblCostPC, 
	dblfreight,
	0,
	0,
	1	 
	FROM 
	specificationdetails 
	WHERE intStyleId = '$StyleID' AND (intStatus != '0' or intStatus IS NULL);";
	$db->ExecuteQuery($sql); 
	
	$sql1="update orders set intFirstApprovedBy=0,dtmFirstAppDate=null,intApprovedBy=0,dtmAppDate=null  where intStyleId='$StyleID';";	
	$db->executeQuery($sql1);
	
	// Sending an email to the merchandiser if the style is reviced
		$senderEmail = "";
		$senderName = "";
		$sql="SELECT UserName,Name FROM useraccounts where intUserID=".$_SESSION["UserID"].";";
		$resultUser=$db->RunQuery($sql);
		while($row=mysql_fetch_array($resultUser))
		{
		$senderEmail=$row["UserName"];
		$senderName=$row["Name"];
		}
		
		$reciever = $adminsEmail;
		$sql = "SELECT useraccounts.UserName FROM orders INNER JOIN useraccounts ON orders.intCoordinator=useraccounts.intUserID WHERE orders.intStyleId = '$StyleID';";
		
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$reciever = $row["UserName"];
		}
		
		/*
		BEGIN - This must uncomment after mail server problem is over 
		include "EmailSender.php";
		$eml =  new EmailSender();
		$Message = "The style No : $styleNo has been reviced. You will not be able to purchase anything while completing the re-approval process.";
		$eml->SendMessage($senderEmail,$senderName,$reciever,"Style No : $StyleID reviced",$Message);
		END - This must uncomment after mail server problem is over
		*/	
	
	}
	else
	{
		$ResponseXML.="<Result><![CDATA[False]]></Result>\n";
	}
	$ResponseXML.="</ReviseResult>";	
	echo $ResponseXML;
	
}
else if (strcmp($RequestType,"GetLeadTimes")==0)
{
	$ResponseXML="";
	$ResponseXML.="<LeadTimeList>";
	$BuyerID=$_GET["buyerID"];
	$sql="SELECT DISTINCT reaLeadTime,intSerialNO FROM eventtemplateheader WHERE intBuyerID = $BuyerID;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<LeadID><![CDATA[" .$row["intSerialNO"]. "]]></LeadID>\n";
		$ResponseXML.="<LeadTime><![CDATA[" .$row["reaLeadTime"]. "]]></LeadTime>\n";
	}
	$ResponseXML.="</LeadTimeList>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"SaveScheduleBuyerPo")==0)
{
	//StyleNo=' + StyleNo + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + remarks,
	$ResponseXML="";
	$strStyleID=$_GET["StyleNo"];
	$dtDateofDelivery=$_GET["ScheduleDate"];
	$dblQty=$_GET["qty"];
	$exQty=$_GET["exqty"];
	$buyerPO=$_GET["buyerPO"];
	$year = substr($dtDateofDelivery,-4);
	$month = substr($dtDateofDelivery,-7,-5);
	$day = substr($dtDateofDelivery,-10,-8);
	$remarks = $_GET["remarks"];
	$dtDateofDelivery = $year . "-" . $month . "-" . $day;

	$result=savePODeliveryDetails($strStyleID,$dtDateofDelivery,$dblQty,$exQty,$buyerPO,$remarks);
	$isedition = $_GET["isedition"];
	
	$hasrecord = false;
	//if ($isedition == "0")
	$sql = "SELECT intScheduleId FROM eventscheduleheader WHERE intStyleId = '$strStyleID' AND dtDeliveryDate = '$dtDateofDelivery' AND strBuyerPONO = '$buyerPO'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$hasrecord = true;
		break;
	}
	if(!$hasrecord);
	SaveEventScheduleDetails($strStyleID,$buyerPO,$dtDateofDelivery);
	
	$ResponseXML.="<SaveDiliveryDetail>";
	$ResponseXML.="<SaveState><![CDATA[True]]></SaveState>\n";
	$ResponseXML.="</SaveDiliveryDetail>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"SaveMainRatioEventSchedule")==0)
{
	//StyleNo=' + StyleNo + '&ScheduleDate=' + date + '&qty=' + qty + '&exqty=' + exqty  + '&modeID=' + modeID + '&remarks=' + remarks,
	$ResponseXML="";
	$strStyleID=$_GET["StyleNo"];
	$dtDateofDelivery=$_GET["ScheduleDate"];
	$buyerPO="#Main Ratio#";
	$year = substr($dtDateofDelivery,-4);
	$month = substr($dtDateofDelivery,-7,-5);
	$day = substr($dtDateofDelivery,-10,-8);
	$dtDateofDelivery = $year . "-" . $month . "-" . $day;

	SaveEventScheduleDetails($strStyleID,$buyerPO,$dtDateofDelivery);
	
	$ResponseXML.="<SaveDiliveryDetail>";
	$ResponseXML.="<SaveState><![CDATA[True]]></SaveState>\n";
	$ResponseXML.="</SaveDiliveryDetail>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"getStyleID")==0)
{
	$ResponseXML="";
	$ResponseXML.="<Details>";
	$scNo=$_GET["scNo"];
	$sql="select intStyleId from specification where intSRNO = '$scNo';";

	$result=$db->RunQuery($sql);
	$haveSC = false;
	while($row=mysql_fetch_array($result))
	{
		$haveSC = true;
		$ResponseXML.="<StyID><![CDATA[" .$row["intStyleId"]. "]]></StyID>\n";
	}
	
	if (!$haveSC)
		$ResponseXML.="<StyID><![CDATA[" ."N/N". "]]></StyID>\n";
		
	$ResponseXML.="</Details>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"getSRNo")==0)
{
	$ResponseXML="";
	$ResponseXML.="<Details>";
	$strStyleID=$_GET["styleID"];
	$sql="select intSRNO from specification where intStyleId = '$strStyleID';";

	$result=$db->RunQuery($sql);
	$haveSC = false;
	while($row=mysql_fetch_array($result))
	{
		$haveSC = true;
		$ResponseXML.="<SrNO><![CDATA[" .$row["intSRNO"]. "]]></SrNO>\n";
	}
	
	if (!$haveSC)
		$ResponseXML.="<SrNO><![CDATA[" ."N/N". "]]></SrNO>\n";
		
	$ResponseXML.="</Details>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"competeOrders") == 0)
{
	$ResponseXML.="<Details>";
	 $styleID=$_GET["styleID"];
	 $sql = "UPDATE orders SET intStatus = 13 WHERE intStyleId = '$styleID'";
	 $affrows = $db->AffectedExecuteQuery($sql);
	 if ($affrows > 0)
	 	$ResponseXML.="<Status><![CDATA[True]]></Status>\n";
	 else
	 	$ResponseXML.="<Status><![CDATA[False]]></Status>\n";
	$ResponseXML.="</Details>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"cancelOrders") == 0)
{
	
	$_intRecCount = 0;
	
	$ResponseXML.="<Details>";
	 $styleID=$_GET["styleID"];
	 
	 #==========================================================================================
	 // Checking if Purchase Order raised before order cancel
	 // If purchase order raised even for single item order cancelation has been blocked
	 #==========================================================================================
	 
	 $strSql = " SELECT Count(purchaseorderdetails.intPoNo) AS NoOfPo FROM purchaseorderdetails ".
	           " WHERE purchaseorderdetails.intStyleId =  '$styleID'";
			   
	 $result = $db->RunQuery($strSql);
	 
	 while($row=mysql_fetch_array($result)){
		$_intRecCount = (int)$row['NoOfPo'];	 
		 
	 }
	 
	 if($_intRecCount>0){
		 $ResponseXML.="<Status><![CDATA[Order cannot be cancel, because of purchase orders has been raised.]]></Status>\n";
	 }else{
	 
		 $sql = "UPDATE orders SET intStatus = 14 WHERE intStyleId = '$styleID'";
		 $affrows = $db->AffectedExecuteQuery($sql);
		 if ($affrows > 0)
			$ResponseXML.="<Status><![CDATA[True]]></Status>\n";
		 else
			$ResponseXML.="<Status><![CDATA[False]]></Status>\n";
			
	 }
	$ResponseXML.="</Details>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"updateCellChanges")==0)
{
	$styleID=$_GET["styleID"];
	$itemCode=$_GET["itemCode"];
	$conpc=$_GET["conpc"];
	$unitprice=$_GET["unitprice"];
	$orderQty=$_GET["orderQty"];
	$excessPercentage=$_GET["excessPercentage"];
	$units=$_GET["units"];
	
	$sql = "update orderdetails set dblUnitPrice = $unitprice, reaConPc = $conpc  where intStyleId = '$styleID' and intMatDetailID = '$itemCode'";
	$db->executeQuery($sql);
	
	updateSingleItemDetails($styleID,$orderQty,$excessPercentage,$itemCode);
	
	$ResponseXML="";
	$ResponseXML.="<itemDetails>";
	
	$sql="select dblReqQty,dblTotalQty,dblTotalValue,dbltotalcostpc from orderdetails  where intStyleId = '$styleID' and intMatDetailID = '$itemCode';";
	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<ReqQty><![CDATA[" .$row["dblReqQty"]. "]]></ReqQty>\n";
		$ResponseXML.="<TotalQty><![CDATA[" .$row["dblTotalQty"]. "]]></TotalQty>\n";
		$ResponseXML.="<TotalValue><![CDATA[" .$row["dblTotalValue"]. "]]></TotalValue>\n";
		$ResponseXML.="<CostPC><![CDATA[" .$row["dbltotalcostpc"]. "]]></CostPC>\n";
	}
	$ResponseXML.="</itemDetails>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"getTransferDetails")==0)
{
	$styleID = $_GET["styleID"];
	
	$ResponseXML="";
	$ResponseXML.="<itemDetails>";
	$sql = "SELECT intStyleId,intCoordinator,intUserID, (SELECT NAME FROM useraccounts WHERE intUserID = orders.intCoordinator) AS Merchandiser, (SELECT NAME FROM useraccounts WHERE intUserID = orders.intUserID) AS CostingBy  FROM orders  WHERE intStyleId = '$styleID';";	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<MerchantID><![CDATA[" .$row["intCoordinator"]. "]]></MerchantID>\n";
		$ResponseXML.="<MerchantName><![CDATA[" .$row["Merchandiser"]. "]]></MerchantName>\n";
		$ResponseXML.="<UserID><![CDATA[" .$row["intUserID"]. "]]></UserID>\n";
		$ResponseXML.="<UserName><![CDATA[" .$row["CostingBy"]. "]]></UserName>\n";
	}
	
	$ResponseXML.="</itemDetails>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"TransferStyle")==0)
{
	$styleID = $_GET["styleID"];
	$merchant = $_GET["merchant"];
	$costing = $_GET["costing"];
	$sql_getoldId ="select intCoordinator,intUserID from orders WHERE intStyleId = '$styleID' ";
	$result_getoldId = $db->RunQuery($sql_getoldId);
	while($row=mysql_fetch_array($result_getoldId))
	{
		$oldmerchant = $row["intCoordinator"];
		$oldcosting  = $row["intUserID"];
	}
	$sql = "UPDATE orders SET intCoordinator = '$merchant' , intUserID = '$costing'  WHERE intStyleId = '$styleID'";
	echo $db->executeQuery($sql);
	$sql = "insert into log_merchanttransfer 
			(intStyleId, 
			intPreviousCoordinator, 
			intPreviousUserId, 
			intNewCoordinator, 
			intNewUserId, 
			intChangeBy, 
			dtmDate
			)
			values
			(
			$styleID,
			$oldmerchant,
			$oldcosting,
			$merchant,
			$costing,
			$userId,
			now()
			)";
	echo $db->executeQuery($sql);
}
else if (strcmp($RequestType,"validateApprovalPossibility")==0)
{
	$styleID = $_GET["StyleID"];
	//start 2010-08-18 check buyer Po delivery schedules availability - if buyer PO available 
	//commented for orit
	/*$sql = "SELECT bpodelschedule.intStyleId, bpodelschedule.dtDateofDelivery FROM bpodelschedule 
INNER JOIN deliveryschedule ON bpodelschedule.intStyleId = deliveryschedule.intStyleId AND bpodelschedule.dtDateofDelivery = deliveryschedule.dtDateofDelivery
WHERE bpodelschedule.intStyleId = '$styleID'";*/
//---------------------------end ---------------------------------------
	
	//start 2010-08-18 check delivery Schedules availability befor approval
	$sql = "SELECT * FROM deliveryschedule WHERE intStyleId='$styleID'";
	//-----------------end----------------------------------------------
	$ResponseXML="";
	echo "<Results>";
	$ResponseXML ="<Value><![CDATA[False]]></Value>\n";
	$result=$db->RunQuery($sql);
	//echo $sql;
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML ="<Value><![CDATA[True]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;
	
}
else if (strcmp($RequestType,"removeDelivery")==0)
{
	$styleID = $_GET["styleID"];

	$sql = "DELETE FROM bpodelschedule WHERE intStyleId = '$styleID';";
	$db->RunQuery($sql);
	
	//===========================================================================================================
	// Description 	- Add existing delivery schedule details to the history delivery schedule table before delete
	//               the current records
	// Add On   	- 01/19/2016
	// Change By   	- Nalin Jayakody
	//===========================================================================================================
					
	$sql_addhistory =  " INSERT INTO history_deliveryschedule (intStyleId, dtDateofDelivery, dblQty, dbExQty, strShippingMode, isDeliveryBase, intSerialNO,strRemarks,intUserId,dtmDate,dtmHandOverDate,intBPO,intRefNo, estimatedDate,intCountry, intDeliveryStatus,dtmCutOffDate,AuditDate,AuditUser)
                         SELECT deliveryschedule.intStyleId, deliveryschedule.dtDateofDelivery, deliveryschedule.dblQty, deliveryschedule.dbExQty, deliveryschedule.strShippingMode, deliveryschedule.isDeliveryBase, deliveryschedule.intSerialNO, deliveryschedule.strRemarks, deliveryschedule.intUserId, deliveryschedule.dtmDate, deliveryschedule.dtmHandOverDate, deliveryschedule.intBPO, deliveryschedule.intRefNo, deliveryschedule.estimatedDate, deliveryschedule.intCountry, deliveryschedule.intDeliveryStatus, deliveryschedule.dtmCutOffDate, now(), '$userId'	
                         FROM deliveryschedule WHERE deliveryschedule.intStyleId = '$styleID'";
				
	$resAddHistory	= $db->RunQuery($sql_addhistory);
					
	//===========================================================================================================				
	
	 $sql = "DELETE FROM deliveryschedule WHERE  intStyleId = '$styleID;'";
	$db->RunQuery($sql);
	
	 $sql = "DELETE FROM style_buyerponos WHERE intStyleId = '$styleID;'";
	$db->RunQuery($sql);
	
	$ResponseXML="";
	echo "<Results>";
	$ResponseXML ="<Value><![CDATA[True]]></Value>\n";	
	$ResponseXML.="</Results>";
	echo $ResponseXML;
}
else if (strcmp($RequestType,"removeBuyerPoNoa")==0)
{
	$styleID 	= $_GET["styleID"];
	$buyerPoId 	= $_GET["buyerPoId"];
	
	$sql = "DELETE FROM style_buyerponos WHERE intStyleId = '$styleID' and strBuyerPONO='$buyerPoId'";
	$db->executeQuery($sql);
}
else if (strcmp($RequestType,"AddDeliveryBPO")==0)
{
	$NoOfPOs = 0;
    
        $styleID 	= $_GET["styleID"];
	$buyerPO 	= $_GET["buyerPO"];
	$buyerPoId 	= $_GET["buyerPoId"];
	$bpoQty 	= $_GET["bpoQty"];
	$bpoLeadTime 	= $_GET["bpoLeadTime"];
	$bpoCountry 	= $_GET["bpoCountry"];

	
	$bpoDelivery 	= trim($_GET["bpoDelivery"]);
	$year 		= substr($bpoDelivery,-4);
	$month 		= substr($bpoDelivery,-7,-5);
	$day 		= substr($bpoDelivery,-10,-8);
	$bpoDelivery 	= $year . "-" . $month . "-" . $day;
	///echo $year;
	$bpoEstimate 	= $_GET["bpoEstimate"];
	$year 		= substr($bpoEstimate,-4);
	$month 		= substr($bpoEstimate,-7,-5);
	$day 		= substr($bpoEstimate,-10,-8);
	$bpoEstimate 	= $year . "-" . $month . "-" . $day;
	
	$bpoHandover 		= $_GET["bpoHandover"];
	$year 			= substr($bpoHandover,-4);
	$month 			= substr($bpoHandover,-7,-5);
	$day 			= substr($bpoHandover,-10,-8);
	$bpoHandover 		= $year . "-" . $month . "-" . $day;
	
	$pcdDate 		= $_GET["pcdDate"];
	$year 			= substr($pcdDate,-4);
	$month 			= substr($pcdDate,-7,-5);
	$day 			= substr($pcdDate,-10,-8);
	$pcdDate 		= $year . "-" . $month . "-" . $day;						   
	
	$bpoShipMode 		= $_GET["bpoShipMode"];
	$bpoRemarks 		= $_GET["bpoRemarks"];
	$userID 		= $_SESSION["UserID"];
	
	$bpoDeliveryStatus	= $_GET["bpoDeliStatus"];
	
	$bpoCutOffDate		= $_GET["bpoCutOffDate"];
	$year 			= substr($bpoCutOffDate,-4);
	$month 			= substr($bpoCutOffDate,-7,-5);
	$day 			= substr($bpoCutOffDate,-10,-8);
	$bpoCutOffDate		= $year . "-" . $month . "-" . $day;
	
	$bpoManuLocation    = $_GET["manuLocationId"];
	$iShipStatus	    = $_GET["shipStatus"];
	$previousBuyerPO    = $_GET["prvBPO"];
        $ishtShipReason     = $_GET["ishtreason"];
        
        // ===================================================================
        // Add On - 11/17/2016
        // Add By - Nalin Jayakody
	// Add For - Check weather any supplier PO raised for the required BPO
        // ===================================================================
        $sqlPOs = " SELECT count(purchaseorderdetails.intPoNo) AS NoPo 
                    FROM purchaseorderdetails
                    WHERE purchaseorderdetails.intStyleId =  '$styleID' AND purchaseorderdetails.strBuyerPONO = '$previousBuyerPO'";
        $resPOS = $db->RunQuery($sqlPOs);
        
        while($rowPOS = mysql_fetch_array($resPOS)){
            $NoOfPOs = (int)$rowPOS["NoPo"];
        }
        
        if($NoOfPOs > 0){
            $tmpBuyerPO = $previousBuyerPO;
        }else{
            $tmpBuyerPO = $buyerPO;
        }
        // ===================================================================
	
		 $sql ="INSERT INTO bpodelschedule 
			(intStyleId, 
			dtDateofDelivery, 
			strBuyerPONO, 
			intQty, 
			strRemarks, 
			intWithExcessQty
			)
			VALUES
			('$styleID', 
			'$bpoDelivery', 
			'$buyerPO', 
			'$bpoQty', 
			'$bpoRemarks', 
			'$bpoQty'
			);";
			$result1 = $db->RunQuery($sql);
			
	
	
	$sql = "INSERT INTO style_buyerponos 
		(intStyleId, 
		strBuyerPONO,
		strBuyerPoName, 
		strCountryCode,
		strRemarks
		)
		VALUES
		('$styleID',
		'$buyerPO', 
		'$tmpBuyerPO', 
		'$bpoCountry',
		'$bpoRemarks'
		);";
	$result2 = $db->RunQuery($sql);
	
	//$sql = "Insert into deliveryschedule(intStyleId,dtDateofDelivery,dblQty,dbExQty,strShippingMode,isDeliveryBase,intSerialNO,strRemarks,intUserId,dtmDate,dtmHandOverDate,intBPO,intRefNo,estimatedDate,intCountry,intDeliveryStatus, dtmCutOffDate)values('".$styleID."','".$bpoDelivery."',".$bpoQty.",'0',".$bpoShipMode.",'N',0,'$bpoRemarks','$userID','$bpoDelivery','$bpoHandover','$buyerPO','0','$bpoEstimate','$bpoCountry','$bpoDeliveryStatus','$bpoCutOffDate');";
	$sql = "Insert into deliveryschedule(intStyleId,dtDateofDelivery,dblQty,dbExQty,strShippingMode,isDeliveryBase,intSerialNO,strRemarks,intUserId,dtmDate,dtmHandOverDate,intBPO,intRefNo,estimatedDate,intCountry,intDeliveryStatus, dtmCutOffDate, intManufacturingLocation, intShortShipped, prvBPO, shortShipId,dtmPCDDate)values('".$styleID."','".$bpoDelivery."',".$bpoQty.",'0',".$bpoShipMode.",'N','$bpoLeadTime','$bpoRemarks','$userID','$bpoDelivery','$bpoHandover','$buyerPO','0','$bpoEstimate','$bpoCountry','$bpoDeliveryStatus','$bpoCutOffDate','$bpoManuLocation','$iShipStatus','$previousBuyerPO', '$ishtShipReason','$pcdDate');";
	
	//echo $sql;
	$result3 = $db->RunQuery($sql);
	
	$result=($result1+$result2+$result3)/3;
	$ResponseXML="";
	$ResponseXML.= "<Results>";
	$ResponseXML.="<Value><![CDATA[".$result. "]]></Value>\n";	
	$ResponseXML.="</Results>";
	echo $ResponseXML; 
}
else if (strcmp($RequestType,"updateDeliveryDetails")==0)
{
	$styleID = $_GET["styleID"];

	$sql = "SELECT strBuyerPONO, SUM(intQty) AS qty FROM bpodelschedule WHERE intStyleId = '$styleID' GROUP BY strBuyerPONO";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$buyerPO = $row["strBuyerPONO"];
		$qty = $row["qty"];
		
		$sql = "UPDATE style_buyerponos SET dblQty = '$qty' WHERE intStyleId = '$styleID' AND strBuyerPONO = '$buyerPO'";
		$db->executeQuery($sql);
			
	}
	
	$sql = "SELECT dtDateofDelivery, SUM(intQty) AS qty FROM bpodelschedule WHERE intStyleId = '$styleID' GROUP BY dtDateofDelivery";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$deliveryDate = $row["dtDateofDelivery"];
		$qty = $row["qty"];
		
		$sql = "UPDATE deliveryschedule 
	SET
	dblQty = '$qty', dbExQty = '$qty' 	 	
	WHERE
	intStyleId = '$styleID' AND dtDateofDelivery = '$deliveryDate' ;";
	
		$db->executeQuery($sql);
			
	}
	
	
	
	$ResponseXML="";
	echo "<Results>";
	$ResponseXML ="<Value><![CDATA[True]]></Value>\n";	
	$ResponseXML.="</Results>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"LoadCustomer")==0)
{
	$ResponseXML="";
	$result=getCustomers();
	$ResponseXML.="<MXLLoadCustomer>\n";
		$ResponseXML.="<option value=\"". "Select One" ."\">" . "Select One" ."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>\n" ;
	}
	$ResponseXML.="</MXLLoadCustomer>";
	echo $ResponseXML;	
}
else if(strcmp($RequestType,"LoadSeason")==0)
{
	$ResponseXML="";
	$result=getSeasons();
	$ResponseXML.="<MXLLoadSeason>\n";
		$ResponseXML.="<option value=\"". "Select One" ."\">" . "Select One" ."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<option value=\"". $row["intSeasonId"] ."\">" . $row["strSeason"] ."</option>\n" ;
	}
	$ResponseXML.="</MXLLoadSeason>";
	echo $ResponseXML;	
}
else if(strcmp($RequestType,"LoadMill")==0)
{
	$ResponseXML="";
	$result=GetMill();
	$ResponseXML.="<MXLLoadMill>\n";
		$ResponseXML.="<option value=\"". "0" ."\">" . "Select One" ."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>\n";
	}
	$ResponseXML.="</MXLLoadMill>";
	echo $ResponseXML;	
}
//start 2010-09-21 getitem wise supplier details from supplierwiseitem table-----------------------
else if(strcmp($RequestType,"LoadMillItemWise")==0)
{
	$ResponseXML="";
	$itemID = $_GET["itemID"];
	$result=GetMillDetItemWise($itemID);
	$ResponseXML.="<MXLLoadMill>\n";
		$ResponseXML.="<option value=\"". "0" ."\">" . "Select One" ."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>\n";
	}
	$ResponseXML.="</MXLLoadMill>";
	echo $ResponseXML;	
}

else if(strcmp($RequestType,"LoadSupplierWiseItem")==0)
{
	$ResponseXML="";
	$SupId = $_GET["SupId"];
	$mainCat = $_GET["mainCat"];
	$subCat = $_GET["subCat"];
	
	$result = getSupWiseItemDetails($SupId,$mainCat,$subCat);
	
	$ResponseXML.="<items>";
	while($row=mysql_fetch_array($result))
	{
		/*$ResponseXML.="<itemID><![CDATA[" .$row["intItemSerial"]. "]]></itemID>\n";
		$ResponseXML.="<itemName><![CDATA[" .$row["strItemDescription"]. "]]></itemName>\n";*/
		$strItemId .= "<option value=\"". $row["intItemSerial"] ."\">" . $row["intItemSerial"] ."</option>";
		$strItemName .= "<option value=\"". $row["intItemSerial"] ."\">" . $row["strItemDescription"] ."</option>";
	}
	$ResponseXML.="<itemID><![CDATA[" .$strItemId. "]]></itemID>\n";
	$ResponseXML.="<itemName><![CDATA[" .$strItemName. "]]></itemName>\n";
	$ResponseXML.="</items>";
	echo $ResponseXML;
	
	
}
//ADD data to supplierwise item table
else if(strcmp($RequestType,"SaveSupplierWiseItem")==0)
{
	$ResponseXML="";
	$SupId = $_GET["SupId"];
	$itemID = $_GET["itemID"];
	$price = $_GET["price"];
	$dtDate = date('Y-m-d');
	
	global $db;
	
	$recAv = checkSupWiseItemAvailability($SupId,$itemID);
	//echo $recAv;
	if($recAv == '1')
	{
		
	}
	else
	{
		$SQL = " insert into supplierwitem 
				(intItemSerial, 
				intSupplierID, 
				dblLastPrice, 
				lastPriceDate 
				)
				values
				('$itemID', 
				'$SupId', 
				'$price', 
				'$dtDate' 
				)";
				$db->RunQuery($SQL);
				
				//echo $SQL;
	}
	
}

//getOriginfinanace details
else if(strcmp($RequestType,"getOriginFinance")==0)
{
	$ResponseXML="";
	$OriginID = $_GET["originID"];
	
	$SQL = "SELECT intType FROM itempurchasetype WHERE intOriginNo='$OriginID'";
	$result = $db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	
	$type = $row["intType"];
	$ResponseXML.="<itemsPurchaseType>";
	$ResponseXML.="<itemPurch><![CDATA[" .$type. "]]></itemPurch>\n";
	$ResponseXML.="</itemsPurchaseType>";
	echo $ResponseXML;
	
}

// start 2010-10-15 get style wise order nos  -------------------
//in preorder 
else if(strcmp($RequestType,"getStyleWiseOrderNo")==0)
{
	$ResponseXML="";
	$stytleName = $_GET["stytleName"];
	
	$SQL = " select intStyleId,strOrderNo
			from orders
			where   intUserID = " . $_SESSION["UserID"] . " and  intStatus  in (0,12,2)";
		
	if($stytleName != '' || $stytleName != 'Select One')
		$SQL .= " and strStyle='$stytleName' ";
		
		$SQL .= "order by strOrderNo ";		
	$result = $db->RunQuery($SQL);
	
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}

else if(strcmp($RequestType,"GetStyleNoWiseScNo")==0)
{
	$ResponseXML="";
	$stytleName = $_GET["stytleName"];
	
	$SQL = " select specification.intSRNO,orders.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus in (0,12,2) and intUserID = " . $_SESSION["UserID"] . " ";
		
	if($stytleName != '' || $stytleName != 'Select One')
		$SQL .= " and orders. strStyle='$stytleName' ";
		
		$SQL .= "order by specification.intSRNO desc";	
		//echo $SQL;
	$result = $db->RunQuery($SQL);
		$str .=  "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<ScNo><![CDATA[" .$str. "]]></ScNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}
// in order inquiry
else if(strcmp($RequestType,"getStyleWiseOrderNoOrderinquiry")==0)
{
	$ResponseXML="";
	$stytleName = $_GET["stytleName"];
	
	$SQL = "select intStyleId,strOrderNo from orders where intUserID=" . $_SESSION["UserID"] . " and intStatus= 2 ";
		
	if($stytleName != '')
		$SQL .= "and strStyle='$stytleName' ";
		
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
//Start 19-10-2010 - Get Style NO and ScNo releted to the order No Approval pencing cost sheet
else if($RequestType=="GetApPenCoSheetOrderNo")
{
	$styleNo		= $_GET["styleNo"];
	$buyerId		= $_GET["buyerId"];
	
	$ResponseXML 	= "<XMLGetApPenCoSheetOrderNo>\n";
	
	$sql="select O.intStyleId,O.strOrderNo from orders O where O.intStatus = 10  ";
	if($styleNo!="")
		$sql .="and O.strStyle='$styleNo' ";
	if($buyerId!="")
		$sql .="and O.intBuyerID='$buyerId' ";	
				
	$sql .= "order by O.strOrderNo";
	
	$result=$db->RunQuery($sql);
		//$ResponseXML .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>";
	}
	$ResponseXML.="</XMLGetApPenCoSheetOrderNo>";
	echo $ResponseXML;;
}
else if($RequestType=="GetStyleno")
{
	$orderNo		= $_GET["orderNo"];
	
	$ResponseXML 	= "<XMLGetStyleNo>\n";
	
	$sql="select O.intStyleId,O.strOrderNo,O.strStyle from orders O where O.intStatus = 10  ";
	if($orderNo!="")
		$sql .="and O.intStyleId='$orderNo' ";
				
	$sql .= "order by O.strOrderNo";
	
	$result=$db->RunQuery($sql);
		//$ResponseXML .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["strStyle"].">".$row["strStyle"]."</option>";
	}
	$ResponseXML.="</XMLGetStyleNo>";
	echo $ResponseXML;;
}

else if($RequestType=="GetApPenCoSheetScNo")
{
	$styleNo	= $_GET["styleNo"];
	$buyerId		= $_GET["buyerId"];
	
	
	$sql="select S.intSRNO,O.intStyleId from specification S inner join orders O on S.intStyleId = O.intStyleId AND O.intStatus = 10 ";
	
	if($styleNo!="")
		$sql .="and O.strStyle='$styleNo' ";
	if($buyerId!="")
		$sql .="and O.intBuyerID='$buyerId' ";
	
	$sql .="order by S.intSRNO desc";
	
	$result=$db->RunQuery($sql);
		//$A .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$A .= "<option value=".$row["intStyleId"].">".$row["intSRNO"]."</option>";
	}
	echo $A;
}
//End 19-10-2010 - Get Style NO and ScNo releted to the order No Approval pencing cost sheet
//Start 19-10-2010 - Get Style NO and ScNo releted to the order No Approved cost sheet (going to revise)
else if($RequestType=="GetApCoSheetOrderNo")
{
	$styleNo		= $_GET["styleNo"];
	$ResponseXML 	= "<XMLGetApPenCoSheetOrderNo>\n";
	$sql="select distinct O.intStyleId,O.strOrderNo from specification S inner join orders O on S.intStyleId = O.intStyleId AND O.intStatus = 11 and O.intUserID =" . $_SESSION["UserID"] . " ";
	
	if($styleNo!="")
		$sql .="and O.strStyle='$styleNo' ";		
	
	$sql .= "order by O.strStyle";
	$result=$db->RunQuery($sql);
		$ResponseXML .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>";
	}
	$ResponseXML.="</XMLGetApPenCoSheetOrderNo>";
	echo $ResponseXML;;
}
else if($RequestType=="GetApCoSheetScNo")
{
	$styleNo	= $_GET["styleNo"];
	$sql="select S.intStyleId,S.intSRNO from specification S inner join orders O  on S.intStyleId = O.intStyleId AND O.intStatus = 11 and O.intUserID =" . $_SESSION["UserID"] . " ";
	
	if($styleNo!="")
		$sql .="and O.strStyle='$styleNo' ";
	
	$sql .="order by S.intSRNO desc";
	
	$result=$db->RunQuery($sql);
		$A .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$A .= "<option value=".$row["intStyleId"].">".$row["intSRNO"]."</option>";
	}
	echo $A;
}
//End 19-10-2010 - Get Style NO and ScNo releted to the order No Approved cost sheet (going to revise)

//start 2010-10-19 get style wise order no list to copy order
//copy order
else if(strcmp($RequestType,"getStyleWiseOrderNoinCopyOrder")==0)
{
	$ResponseXML="";
	$stytleName = $_GET["stytleName"];
	
	$SQL = " select intStyleId,strOrderNo
			from orders ";
		
	if($stytleName != '' || $stytleName != 'Select One')
		$SQL .= " where strStyle='$stytleName' ";
		
		$SQL .= "order by strOrderNo ";		
	$result = $db->RunQuery($SQL);
		$str .=  "<option value=\"". "Select One" ."\">" . "Select One" ."</option>" ;
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}
// end -----------------------------------------------------

//start 2010-10-19 get style wise order no list & SC list to cancel order 
//get Order No list 
else if(strcmp($RequestType,"getStyleWiseOrderNoinCancelOrder")==0)
{
	$ResponseXML="";
	$stytleName = $_GET["stytleName"];
	
	if ($canCancelAnyStyle)
	$userQuery = "";
	else
	$userQuery = " and orders.intUserID =" . $_SESSION["UserID"] ;
	
	
	$SQL = "select orders.intStyleId,orders.strOrderNo from orders where  (orders.intStatus = 0 or orders.intStatus = 2) " . $userQuery;
		
	if($stytleName != 'Select One')
		$SQL .= " and strStyle='$stytleName' ";
		
		$SQL .= " order by strOrderNo ";		
	$result = $db->RunQuery($SQL);
	
	$str .= "<option value=\"Select One\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}

//get SC list

else if(strcmp($RequestType,"getStyleWiseSCinCancelOrder")==0)
{
	$ResponseXML="";
	$stytleName = $_GET["stytleName"];
	
	if ($canCancelAnyStyle)
	$userQuery = "";
	else
	$userQuery = " and orders.intUserID =" . $_SESSION["UserID"] ;
	
	
	$SQL = "select specification.intStyleId,specification.intSRNO from specification inner join orders on specification.intStyleId = orders.intStyleId and orders.intStatus = 0 " . $userQuery ;
		
	if($stytleName != 'Select One')
		$SQL .= " where strStyle='$stytleName' ";
		
		$SQL .= " order by specification.intSRNO DESC ";
	$result = $db->RunQuery($SQL);
	
	$str .= "<option value=\"Select One\" selected=\"selected\">Select One</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
	
}
//end ----------------------------------------------------------------------------
//Start - 26-10-2010 - Get fabric ref no from supplier Table
else if(strcmp($RequestType,"GetFabricRefNo")==0)
{
$millId = $_GET["MillId"];
$ResponseXML.="<XMLGetFabricRefNo>\n";

	$SQL = "select strFabricRefNo from suppliers where strSupplierID=$millId";		
	$result = $db->RunQuery($SQL);	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML.="<FabricRefNo><![CDATA[" .$row["strFabricRefNo"]. "]]></FabricRefNo>\n";
	}
	$ResponseXML.="</XMLGetFabricRefNo>";
	echo $ResponseXML;
}
//End - 26-10-2010 - Get fabric ref no from supplier Table
elseif($RequestType=="GetApPenCoSheetStyleNo")
{
$buyerId	= $_GET["buyerId"];
	$sql="select distinct strStyle from orders where orders.intStatus = 10 ";
	if(!$buyerId=="")
		$sql .=	"and intBuyerID=$buyerId";
	$sql .= " order by strStyle";
	//echo $sql;
	$result=$db->RunQuery($sql);
		$ResponseXML .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["strStyle"].">".$row["strStyle"]."</option>";
	}
	echo $ResponseXML;

}
//Start
elseif($RequestType=="GetOrderWiseCopyData")
{
$orderId	= $_GET["orderId"];	
$ResponseXML.="<XMLGetOrderWiseCopyData>\n";
	$sql="select strOrderNo,strStyle,strOrderColorCode,intManufactureCompanyID from orders where intStyleId='$orderId'";			
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$orderNoLength 		= strlen($row["strOrderNo"]);
		$colorCodeLength    = strlen($row["strOrderColorCode"]);
		
		if($colorCodeLength == 0)
			$orderNo = substr($row["strOrderNo"],0,$orderNoLength-$colorCodeLength);
		else
			$orderNo = substr($row["strOrderNo"],0,$orderNoLength-$colorCodeLength);
			
		$ResponseXML.="<OrderNo><![CDATA[" .$orderNo. "]]></OrderNo>\n";
		$ResponseXML.="<StyleNo><![CDATA[" .$row["strStyle"]. "]]></StyleNo>\n";
		$ResponseXML.="<colorCode><![CDATA[" .$row["strOrderColorCode"]. "]]></colorCode>\n";
		$ResponseXML.="<sewFactory><![CDATA[" .$row["intManufactureCompanyID"]. "]]></sewFactory>\n";
	}
$ResponseXML.="</XMLGetOrderWiseCopyData>";
echo $ResponseXML;
}
//End
elseif($RequestType=="GetStyleWiseOrderNoInReports")
{
$sqldata = $_GET["sql"];
$styleNo = $_GET["styleNo"];
$ResponseXML.="<XMLGetOrderWiseCopyData>\n";
$sql= $sqldata;
if($styleNo!="")
	$sql .=" and o.strStyle='".$styleNo ."'";
	
$ResponseXML.="</XMLGetOrderWiseCopyData>";
echo $ResponseXML;
}

elseif($RequestType=="deliveryDateValidation")
{
	$delDate = $_GET["delDate"];
	$tDate = date('Y-m-d');
	
	$ResponseXML.="<XMLDeliveyDateValidate>\n";
	
	$result = ($delDate>=$tDate ? 1:0);
	
	$ResponseXML.="<XMLResponse><![CDATA[" .$result. "]]></XMLResponse>\n";
	
	$ResponseXML.="</XMLDeliveyDateValidate>";
	echo $ResponseXML;
	
}
elseif($RequestType=="URLSendForApproval")
{
	$styleID	= $_GET["styleID"];
	$ResponseXML.="<XMLDeliveyDateValidate>\n";
	$sql="update orders set intStatus=10 where intStyleId='$styleID'";
	$result=$db->RunQuery($sql);
	$ResponseXML.="<XMLResponse><![CDATA[" .$result. "]]></XMLResponse>\n";
	
	$ResponseXML.="</XMLDeliveyDateValidate>";
	echo $ResponseXML;
	
}
elseif($RequestType=="getItemUnitprice")
{
	$itemCode = $_GET["itemCode"];
	$itemUnitprice = getItemUnitPriceDetails($itemCode);
	
	$ResponseXML.="<XMLItemUnitprice>\n";
	$ResponseXML.="<itemUnitprice><![CDATA[" .$itemUnitprice. "]]></itemUnitprice>\n";
	$ResponseXML.="</XMLItemUnitprice>";
	echo $ResponseXML;
}

elseif($RequestType=="getItemWashStatus")
{
	$itemCode = $_GET["itemCode"];
        $styleId  = $_GET["styleId"];
	$itemWashStatus = getItemWashStatusDetails($itemCode, $styleId);
	
	$ResponseXML.="<XMLItemWashStatus>\n";
	$ResponseXML.="<washStatus><![CDATA[" .$itemWashStatus. "]]></washStatus>\n";
	$ResponseXML.="</XMLItemWashStatus>";
	echo $ResponseXML;
}
elseif($RequestType=="getDelQty")
{
	$styleNo = $_GET["styleNo"];
	$Qty = getStyleDelQty($styleNo);
	
	$ResponseXML.="<XMLQTY>\n";
	$ResponseXML.="<QTY><![CDATA[" .$Qty. "]]></QTY>\n";
	$ResponseXML.="</XMLQTY>";
	echo $ResponseXML;
}
function getStyleDelQty($styleNo)
{
		global $db;
		$sql = " SELECT Sum(deliveryschedule.dblQty) as totQty FROM deliveryschedule WHERE deliveryschedule.intStyleId='$styleNo' ";
		$result = $db->RunQuery($sql);
		$row = mysql_fetch_array($result);
		
		return $row["totQty"];
}
function getItemUnitPriceDetails($itemCode)
{
        global $db;
        $sql = " select dblUnitPrice from matitemlist where intItemSerial='$itemCode' ";
        $result = $db->RunQuery($sql);
        $row = mysql_fetch_array($result); 

        return $row["dblUnitPrice"];
}

function getItemWashStatusDetails($itemCode, $styleID){
    
    global $db;
    $sql = "SELECT booWashable FROM orderdetails WHERE intStyleId = '$styleID' AND intMatDetailID = '$itemCode'";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_row($result);
    //echo $sql;
    return $row[0];
    
}
function GetMillDetItemWise($itemID)
{
	global $db;
	$SQL = "SELECT strSupplierID,strTitle
			FROM suppliers S INNER JOIN supplierwitem SW ON
			S.strSupplierID = SW.intSupplierID
			WHERE SW.intItemSerial='$itemID' ";
			
			return $db->RunQuery($SQL);
}

function getSupWiseItemDetails($SupId,$mainCat,$subCat)
{
	global $db;
	$SQL = "SELECT M.intItemSerial,M.strItemDescription
			FROM matitemlist M INNER JOIN supplierwitem S ON
			M.intItemSerial = S.intItemSerial 
			WHERE S.intSupplierID = '$SupId' AND M.intMainCatID = '$mainCat' AND M.intSubCatID='$subCat' ";
			
			return $db->RunQuery($SQL);
}

function checkSupWiseItemAvailability($SupId,$itemID)
{
	global $db;
	
	$SQL = " SELECT * FROM supplierwitem
			WHERE intItemSerial='$itemID' AND intSupplierID='$SupId' ";
			
			return $db->CheckRecordAvailability($SQL);
			
}
//end ----------------------------------------------------------------------------------------------
function updateSingleItemDetails($styleID,$qty,$exPercentage,$itemCode)
{
	
	
	global $db;
	$sql= "select orderdetails.intMatDetailID,matitemlist.intMainCatID,orderdetails.reaConPc,orderdetails.reaWastage from orderdetails inner join matitemlist on orderdetails.intMatDetailID = matitemlist.intItemSerial where orderdetails.intStyleId = '$styleID' and orderdetails.intMatDetailID = '$itemCode';";
	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$matMainCat = $row["intMainCatID"];
		$matID = $row["intMatDetailID"];
		$excessallowed= false;
		$wastagealowed= false;
		
		$orderQty = ($qty + ($qty*$exPercentage)/100);
		$conpc = $row["reaConPc"];
		$wastage = $row["reaWastage"];
		$reqQty = $conpc*$qty;
		$totalQty = $reqQty;
		
		// ----------------------------------
		$SQL = "select intID,strID,strDescription,preorderExcessallowed,preorderWastageAllowed from matmaincategory where intID=$matMainCat" ;
		$resultsub = $db->RunQuery($SQL);
		while($rowsub = mysql_fetch_array($resultsub))
		{
			if ($rowsub["preorderExcessallowed"])
			{
				$excessallowed = true;
				$totalQty = ($reqQty+($reqQty*$exPercentage)/100); 
			}
			
			
			if ($rowsub["preorderWastageAllowed"])
			{
				$wastagealowed= true;
			}

		}
		
		
		
		// -----------------------------------------
		
		/*if ($wastagealowed )
		{
			
			$sql="update orderdetails set dblReqQty = reaConPc * $qty , dblTotalQty = reaConPc * $qty  , dblTotalValue = dblTotalQty * (dblUnitPrice + dblFreight ), dbltotalcostpc = dblTotalValue / $qty  where intStyleId = '$styleID' AND intMatDetailID =$matID;";
			//echo $sql;
			$db->executeQuery($sql);

		}
		else
		{
			
			$sql="update orderdetails set dblReqQty = reaConPc * $qty , dblTotalQty = (reaConPc * $qty) + (reaConPc * $qty * reaWastage / 100) + (reaConPc * $qty * $exPercentage / 100) , dblTotalValue = dblTotalQty * (dblUnitPrice + dblFreight ) , dbltotalcostpc = dblTotalValue / $qty where intStyleId = '$styleID' AND intMatDetailID =$matID;";
			$db->executeQuery($sql);

		}*/
		
		if($wastagealowed)
		{
			$totalQty = ($totalQty + ($reqQty*$wastage)/100);
				if($reqQty<1)
					$reqQty=1;
				else
					$reqQty = round($reqQty,0);
			
			if($totalQty<1)
				$totalQty=1;
				
			$sql = "update orderdetails set 
			        dblReqQty = $reqQty , 
					dblTotalQty = CEIL($totalQty) , 
					dblTotalValue = round(CEIL($totalQty)*(dblUnitPrice+dblFreight),4) , 
					dbltotalcostpc = round(CEIL($totalQty)*(dblUnitPrice+dblFreight)/$qty,4)
					where intStyleId = '$styleID' AND intMatDetailID =$matID;";
					
					$db->executeQuery($sql);
		}
		else
		{
			if($reqQty<1)
					$reqQty=1;
				else
					$reqQty = round($reqQty,0);
			
			if($totalQty<1)
				$totalQty=1;
				
			$sql = "update orderdetails set 
			        dblReqQty = $reqQty , 
					dblTotalQty = CEIL($totalQty) , 
					dblTotalValue = round(CEIL($totalQty)*(dblUnitPrice+dblFreight),4) , 
					dbltotalcostpc = round(CEIL($totalQty)*(dblUnitPrice+dblFreight)/$qty,4)
					where intStyleId = '$styleID' AND intMatDetailID =$matID;";
					
					$db->executeQuery($sql);
		}
	}
	
	
}


function copyOrderData($SourceStyleID,$TargetStyleName,$newUserID,$newStyleName,$orderColorCode,$buyerOrderNo)
{
	global $db;

	// =============================================
	// Add On - 02/25/2016
	// Add By - Nalin Jayakody
	// Add For - Get factory OH cost from the relavant company table while copying order
	// =============================================

	$SQLOH = "SELECT reaFactroyCostPerMin FROM companies where intCompanyID=" . $_SESSION["CompanyID"]  . ";";
	
	$rsFacOHCost = $db->RunQuery($SQLOH);
	$arrFacOH	= mysql_fetch_row($rsFacOHCost);

	$dblFacOHCost = $arrFacOH[0];

	// =============================================

	$sql="SELECT * FROM orders o where intStyleId='$SourceStyleID';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
	//$divisionId	= ($row["intDivisionId"]=="" ? "Null":$row["intDivisionId"]);
	$divisionId = "Null";
	$buyingOfficeId	= ($row["intBuyingOfficeId"]=="" ? "Null":$row["intBuyingOfficeId"]);
	$seasonId	= ($row["intSeasonId"]=="" ? "Null":$row["intSeasonId"]);
	$lineNo	= ($row["intLineNos"]=="" ? "Null":$row["intLineNos"]);
	$coordinator	= ($row["intCoordinator"]=="" ? "Null":$row["intCoordinator"]);
	$description = str_replace("'","''",$row["strDescription"]);
	$reviseReason = 'Null';
	$reviseDate = 'Null';
	$reviseBy = '0';
	$manufactureId = ($row["intManufactureCompanyID"]==''?"Null":$row["intManufactureCompanyID"]);


	
	saveOrder($TargetStyleName,$newStyleName,$row["intCompanyID"],$description,$row["intBuyerID"],'0',$coordinator,0,$row["strCustomerRefNo"],$row["reaSMV"],$row["dtmDate"],$row["reaSMVRate"],$row["reaFOB"],$row["reaFinance"],$newUserID,'0','','',$row["reaExPercentage"],$row["reaFinPercntage"],'',$reviseReason,$reviseDate,$reviseBy,$row["reaConfirmedPrice"],$row["strConPriceCurrency"],$row["reaCommission"],$row["reaEfficiencyLevel"],$row["reaCostPerMinute"],$row["dtmDateSentForApprovals"],$row["intSentForApprovalsTo"],$row["strDeliverTo"],$row["reaFreightCharges"],$row["reaECSCharge"],$row["reaLabourCost"],$buyingOfficeId,$divisionId,$seasonId,"",$row["intSubContractQty"],$row["reaSubContractSMV"],$row["reaSubContractRate"],$row["reaSubTransportCost"],$row["reaSubCM"],$lineNo,$row["reaProfit"],$row["reaUPCharges"],$row["strUPChargeDescription"],$row["reaFabFinance"],$row["reaTrimFinance"],$row["reaNewCM"],$row["reaNewSMV"],$row["intFirstApprovedBy"],$row["dtmFirstAppDate"],$row["strScheduleMethod"],$row["dblFacProfit"],$orderColorCode,$row["intOrderType"],$manufactureId,$buyerOrderNo,$dblFacOHCost);
		
	}
	//$TargetStyleID = GetSavedStyleId($TargetStyleName);
	$TargetStyleID = GetCopyStyleId($TargetStyleName);
	
	$sql="SELECT * FROM orderdetails o where intStyleId='$SourceStyleID' AND (o.intstatus != '0' or o.intstatus IS NULL);";
	$resultItems=$db->RunQuery($sql);
	while($rowItems=mysql_fetch_array($resultItems))
	{	
		saveOrderDetails($TargetStyleName,$TargetStyleID,$rowItems["intMatDetailID"],$rowItems["strUnit"],$rowItems["dblUnitPrice"],$rowItems["reaConPc"],$rowItems["reaWastage"],$rowItems["strCurrencyID"],$rowItems["intOriginNo"],$rowItems["dblReqQty"],$rowItems["dblTotalQty"],$rowItems["dblTotalValue"],$rowItems["dbltotalcostpc"],$rowItems["dblFreight"],$rowItems["intMillId"],$rowItems["intMainFabricStatus"]);
	
	
	if(IsVariationAvailable($SourceStyleID))
	{
		$resultVari=getVariationData($rowItems["intMatDetailID"],$SourceStyleID);
		while($rowVari=mysql_fetch_array($resultVari))
		{			
			SaveVariations($TargetStyleID,$rowVari["strMatDetailID"],$rowVari["intNo"],$rowVari["dblConPc"],$rowVari["dblUnitPrice"],$rowVari["dblWastage"],$rowVari["strColor"],$rowVari["strRemarks"],$rowVari["intqty"],$rowVari["strSize"]);
		
		}
		
	}
	}
	$sql = "insert into stylepartdetails (intStyleId,intPartId,intPartNo,strPartName,dblsmv,dblSmvRate,dblEffLevel,intStatus) select '$TargetStyleID',intPartId,intPartNo,strPartName,dblsmv,dblSmvRate,dblEffLevel,intStatus from stylepartdetails where intStyleId = '$SourceStyleID'";
	$db->executeQuery($sql);
}
function getShippingModeByID($shippingModeID)
{
	global $db;
	$sql="SELECT intShipmentModeId,strDescription FROM shipmentmode s where intStatus='1' AND intShipmentModeId='".$shippingModeID."';";
    $result=$db->RunQuery($sql);
    while($row=mysql_fetch_array($result))
    {
		return $row["strDescription"];
	}
}
function getMainItemName($ItemID)
{
	global $db;
	$sql="SELECT strDescription,intID FROM matmaincategory m Inner Join matitemlist i ON m.intID=i.intMainCatID where i.intItemSerial='".$ItemID."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
	return $row["strDescription"];	
	}
	
}
function getApprovedDataStyle($StyleID)
{
	global $db;
	$sql="SELECT o.intStyleId,o.dtmDate,u.Name FROM orders o INNER JOIN useraccounts u ON o.intUserID=u.intUserID where o.intStatus='10' AND o.intStyleId like '%".$StyleID."%';";
	return $db->RunQuery($sql);
}
function getApprovedDataStyleList($StyleID)
{
	global $db;
	$sql = "SELECT intStyleId, strDescription, dtmAppDate FROM orders where (intStatus = 11 or intStatus = 13) AND intStyleId like '%$StyleID%';";
	//$sql="SELECT o.intStyleId,o.dtmDate,u.Name FROM orders o INNER JOIN useraccounts u ON o.intUserID=u.intUserID where o.intStatus='10' AND o.intStyleId='".$StyleID."';";
	return $db->RunQuery($sql);
}
function getApprovedData($companyID)
{
	global $db;
	$sql="SELECT o.intStyleId,o.dtmDate,u.Name FROM orders o INNER JOIN useraccounts u ON o.intUserID=u.intUserID where o.intStatus='10' AND o.intCompanyID='".$companyID."';";
	return $db->RunQuery($sql);
}
function getItemName($itemID)
{
	global $db;
	$sql="SELECT strItemDescription FROM matitemlist where intItemSerial='".$itemID."'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
	return $row["strItemDescription"];	
	}
	
	
}
function getOrigineName($orgineID)
{
	global $db;
	$sql="SELECT strOriginType,intType FROM itempurchasetype where intOriginNo='".$orgineID."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$str = $row["intType"].'*'.$row["strOriginType"];
		//$str = $row["strOriginType"];
	}
	return $str;	
}
function getUnitType($ItemNo)
{
	global $db;
	$sql="SELECT strUnit FROM matitemlist m where intItemSerial='".$ItemNo."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
	return $row["strUnit"];	
	}
	
}
function deleteData_edit($styleID)
{
	global $db;
	
	$sql="DELETE FROM orders where intStyleId='".$styleID."';";
    $db->executeQuery($sql);

    
    $sql="DELETE FROM orderdetails WHERE intStyleId='".$styleID."';";
	$db->executeQuery($sql);


	$sql="DELETE FROM conpccalculation WHERE intStyleId='".$styleID."';";	
	$db->executeQuery($sql);
			
	saveHistoryDeliveryDetails($styleID);

	$sql="DELETE FROM deliveryschedule WHERE intStyleId='".$styleID."';";
	$db->executeQuery($sql);

}


function SaveEventScheduleDetails($styleID,$buyerPONo,$DeleveryDate)
{
	global $db;
	$headerID = 0;
	$isUpdated = false;
	$sql = "SELECT intScheduleId FROM eventscheduleheader WHERE intStyleId = '$styleID' AND strBuyerPONO = '$buyerPONo' and dtDeliveryDate ='$DeleveryDate'";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$headerID = $row["intScheduleId"];
		$sql = "UPDATE eventscheduleheader SET dtDeliveryDate = '$DeleveryDate'  WHERE intStyleId = '$styleID' AND strBuyerPONO = '$buyerPONo' and dtDeliveryDate ='$DeleveryDate'";		
		$db->executeQuery($sql);
		$isUpdated = true;
	}	
	
	if(!$isUpdated)
	{
	$sql = "INSERT INTO eventscheduleheader 
	(intStyleId, 
	dtDeliveryDate, 
	strBuyerPONO
	)
	VALUES
	('$styleID', 
	'$DeleveryDate', 
	'$buyerPONo'
	);";
	$headerID = $db->AutoIncrementExecuteQuery($sql);
	}
	$scheduleID = $headerID;
	$sql = "SELECT intEventID,reaOffset FROM eventtemplatedetails INNER JOIN eventtemplateheader ON 
eventtemplatedetails.intSerialNo = eventtemplateheader.intSerialNO 
WHERE eventtemplateheader.intBuyerID = (SELECT intBuyerID FROM orders WHERE intStyleId = '$styleID') 
AND eventtemplateheader.intSerialNO =  (SELECT intSerialNO FROM deliveryschedule WHERE intStyleId = '$styleID' AND dtDateofDelivery = '$DeleveryDate' ) ";

	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
	
			$offset = $row["reaOffset"];
			$eventID = $row["intEventID"];
			$updated = false;
			
			$sql = "SELECT * FROM eventscheduledetail WHERE intScheduleId = '$scheduleID' AND intEventId = '$eventID'";
			$dataresult = $db->RunQuery($sql);
			
			while($rowresult = mysql_fetch_array($dataresult))
			{	
				
				$sql = "UPDATE eventscheduledetail SET dtmEstimateDate = DATE_ADD('$DeleveryDate', INTERVAL $offset DAY) WHERE intScheduleId = '$scheduleID' AND intEventId = '$eventID' AND 
 ISNULL(dtCompleteDate) AND ISNULL(dtChangeDate) ;";
			
				$db->executeQuery($sql);
				$updated = true;
			}
			
			if(!$updated)
			{
				$sql = "INSERT INTO eventscheduledetail 
							(intScheduleId, 
							intEventId, 
							dtmEstimateDate
							)
							VALUES
							('$scheduleID', 
							'$eventID', 
							DATE_ADD('$DeleveryDate', INTERVAL $offset DAY) 
							);";
		
				$db->executeQuery($sql);
		
							
			}		
	
	}
	
}

function saveHistoryDeliveryDetails($strStyleID)
{
	global $db;
	$sql="
insert into history_deliveryschedule 
	(intDeliveryId,
	intStyleId, 
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
	estimateddate,
	intUserId,
	dtmDate
	)
	
select * from deliveryschedule where intStyleId = '$strStyleID'";

	return	$db->executeQuery($sql);
}
	


function IsItemsAvailable($styleID)
{
	global $db;
	$sql="SELECT COUNT(intStyleId)AS ItemCount FROM orderdetails where intStyleId='".$styleID."' AND (orderdetails.intstatus != '0' or orderdetails.intstatus IS NULL);";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($row["ItemCount"]>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
}
function IsVariationAvailable($styleID)
{
		global $db;
	$sql="SELECT COUNT(intStyleId)AS Variation FROM conpccalculation c where intStyleId='".$styleID."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($row["Variation"]>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
function IsDeliveryShedule($styleID)
{
	global $db;
	$sql="SELECT COUNT(intStyleId)AS DeliveryCount FROM deliveryschedule d WHERE intStyleId='".$styleID."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($row["DeliveryCount"]>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
}

//start 2010-09-13 pass style status as a param to get order inquiry data 
function getOrdersData($styleID,$status)
{
	global $db;
	
	if($status != '2')
	{
	//with factory smv value  
		$sql ="SELECT strStyle,strOrderNo,intStyleId,o.intCompanyID,strDescription, reaLabourCost,intBuyerID,intQty,o.intStatus,intCoordinator,strCustomerRefNo,reaSMVRate,reaFOB,reaFinance,intUserID,reaFinPercntage,reaEfficiencyLevel,reaCostPerMinute,reaECSCharge,intBuyingOfficeId,intDivisionId,intSeasonId,strRPTMark,intLineNos,reaUPCharges,strUPChargeDescription,dtmAppDate,reaExPercentage,reaSMV,strScheduleMethod,intSubContractQty,orderUnit,productSubCategory,reaProfit,dblFacProfit,reaFactroyCostPerMin,intOrderType,intManufactureCompanyID, o.dblFacOHCostMin, o.intPrint, o.intEMB, o.intHeatSeal, o.intHW, o.intOther, o.intNA, o.reaPackSMV, o.sStyleLevel, o.dtPCD FROM orders o inner join companies c on o.intCompanyID = c.intCompanyID where intStyleId='$styleID' ";
	}
	else
	{
		$sql="SELECT strStyle,strOrderNo,intStyleId,intCompanyID,strDescription, reaLabourCost,intBuyerID,intQty,intStatus,intCoordinator,strCustomerRefNo,reaSMVRate,reaFOB,reaFinance,intUserID,reaFinPercntage,reaEfficiencyLevel,reaCostPerMinute,reaECSCharge,intBuyingOfficeId,intDivisionId,intSeasonId,strRPTMark,intLineNos,reaUPCharges,strUPChargeDescription,dtmAppDate,reaExPercentage,reaSMV,strScheduleMethod,intSubContractQty,orderUnit,productSubCategory,reaProfit,dblFacProfit,intOrderType,intManufactureCompanyID, o.dblFacOHCostMin, o.intPrint, o.intEMB, o.intHeatSeal, o.intHW, o.intOther, o.intNA FROM orders o where intStyleId='".$styleID."';";
	}
	//echo $sql;
	return $db->RunQuery($sql);
	
}
function getOrderDetailsData($styleID)
{

	global $db;
			$sql="SELECT strOrderNo,intStyleId,intMatDetailID,o.dblUnitPrice,reaConPc,reaWastage,intOriginNo,dblReqQty,dblTotalQty,dblTotalValue,dbltotalcostpc,dblFreight,m.strItemDescription,o.strUnit,intMillId,intMainFabricStatus,intMainCatID
			FROM
			orderdetails AS o
			Inner Join matitemlist AS m ON o.intMatDetailID = m.intItemSerial
			Inner Join matsubcategory ON m.intSubCatID = matsubcategory.intSubCatNo AND m.intMainCatID = matsubcategory.intCatNo
			WHERE
			o.intStyleId =  '$styleID' AND (o.intstatus != '0' or o.intstatus IS NULL)
			ORDER BY m.intMainCatID, m.strItemDescription";
	return $db->RunQuery($sql);
}

function getVariationData($MatDetailID,$styleID)
{
	global $db;
	$sql="SELECT intNo,strMatDetailID,dblConPc,dblUnitPrice,dblWastage,strColor,strRemarks,intqty,strSize FROM conpccalculation c where strMatDetailID='".$MatDetailID."' AND intStyleId= '" .$styleID . "';";
	//echo $sql;
	return $db->RunQuery($sql);
}

function getDeliveryShedule($styleID)
{
global $db;
/*$sql="SELECT intStyleId, DATE_FORMAT(dtDateofDelivery, '%d/%m/%Y') as dtDateofDelivery,dblQty,dbExQty,strRemarks,strShippingMode,isDeliveryBase,deliveryschedule.intSerialNO,reaLeadTime, DATE_FORMAT(estimatedDate, '%d/%m/%Y') as estimatedDate, intDeliveryStatus, dtmCutOffDate FROM deliveryschedule LEFT JOIN eventtemplateheader ON deliveryschedule.intSerialNO = eventtemplateheader.intSerialNO where intStyleId='".$styleID."'";	*/

// Without lead time and estimate date
 $sql="SELECT DISTINCT d.intStyleId, DATE_FORMAT(dtDateofDelivery, '%d/%m/%Y') as dtDateofDelivery,dblQty,dbExQty,
strRemarks,strShippingMode,isDeliveryBase,d.intSerialNO,o.intApprovalNo,DATE_FORMAT(dtmHandOverDate, '%d/%m/%Y') as dtmHandOverDate,d.intBPO,d.intRefNo,DATE_FORMAT(estimatedDate, '%d/%m/%Y') as estimatedDate, d.intCountry, d.intDeliveryStatus, DATE_FORMAT(d.dtmCutOffDate, '%d/%m/%Y') as dtmCutOffDate
FROM deliveryschedule d LEFT JOIN eventtemplateheader e ON d.intSerialNO = e.intSerialNO
inner join orders o on o.intStyleId = d.intStyleId
 where d.intStyleId='$styleID' ";	
return $db->RunQuery($sql);
	
}

function getAcknowledgementOrders($styleID)
{
	global $db;
	$OrderCount=0;
	$sql="SELECT COUNT(strOrderNo)AS OrderC FROM orders where strStyle='".$styleID."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$OrderCount=$row["OrderC"];
	}
	if($OrderCount>0)
	{
		return "True";		
	}
	else
	{
	return "False";
	}
	
}
//start 2010-10-19
function getAcknowledgementOrdersNo($styleID)
{
	global $db;
	$OrderCount=0;
	$sql="SELECT COUNT(strOrderNo)AS OrderC FROM orders where strOrderNo='".$styleID."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$OrderCount=$row["OrderC"];
	}
	if($OrderCount>0)
	{
		return "True";		
	}
	else
	{
	return "False";
	}
	
}

function getAcknowledgementItems($styleID,$itemCount)
{
	global $db;
	$sql="SELECT COUNT(intStyleId)AS ItemCount FROM orderdetails where intStyleId='".$styleID."' AND (orderdetails.intstatus != '0' or orderdetails.intstatus IS NULL); ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($row["ItemCount"]==$itemCount)
		{
			return "True";
		}
		else
		{
			return "False";
		}
	}
	
}
function getAcknowledgementVari($styleID,$variationCount)
{
	
	global $db;
	$sql="SELECT COUNT(intStyleId)AS Variation FROM conpccalculation c where intStyleId='".$styleID."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($row["Variation"]==$variationCount)
		{
			return "True";
		}
		else
		{
			return "False";
		}
	}
}

function getAcknowledgementDelivery($styleID,$sheduleCount)
{
	global $db;
	$sql="SELECT COUNT(intStyleId)AS DeliveryCount FROM deliveryschedule d WHERE intStyleId='".$styleID."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($row["DeliveryCount"]==$sheduleCount)
		{
			return "True";
		}
		else
		{
			return "False";
		}
	}
}
function getStyleName($styleLetter)
{
	global $db;
	$sql="SELECT intStyleId FROM orders o where intStyleId LIKE '".$styleLetter."%';";
	$db->RunQuery($sql);
	
}
function getCostPerMin($companyID)
{
	global $db;
	$sql="SELECT reaFactroyCostPerMin FROM companies c where intCompanyID=".$companyID.";";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["reaFactroyCostPerMin"];
	}
}
function getUnitConversion($itemID,$fromUnit,$toUnit)
{
	global $db;
	$sql="SELECT dblFactor FROM unitconversion u where strFromUnit='".$fromUnit."' and strToUnit='".$toUnit."';";
	
	return $db->RunQuery($sql);
	
}

function getUnitByItem($itemID)
{
	global $db;
	$sql="SELECT strUnit FROM matitemlist m where intItemSerial=".$itemID.";";
	return $db->RunQuery($sql);
	
}
function getCategories($MainCatID)
{
	global $db;
	$sql="SELECT intSubCatNo,StrCatName,StrCatCode FROM matsubcategory where intCatNo=".$MainCatID." and intStatus='1' ORDER BY StrCatName";
	return $db->RunQuery($sql);	
	
}
function getItemDiscription($itemID)
{
	global $db;
	$sql="SELECT strUnit,sngWastage,dblUnitPrice FROM matitemlist m where intItemSerial=".$itemID." and intStatus=1;";
	return $db->RunQuery($sql);	
}

function getOrigine()
{
	global $db;
	$sql="SELECT intOriginNo,strOriginType FROM itempurchasetype i where i.intStatus=1 order by strOriginType;";
	return $db->RunQuery($sql);
	
}
function getUnits()
{
	global $db;
	$sql="SELECT strUnit FROM units u where u.intStatus=1 ORDER BY strUnit;";
	return $db->RunQuery($sql);
	
}
function getItems($MainCatID,$catID)
{
	global $db;
	$sql="SELECT intItemSerial,strItemDescription FROM matitemlist m where intMainCatID=".$MainCatID." and intSubCatid=".$catID." and intStatus=1 ORDER BY strItemDescription";
	return $db->RunQuery($sql);	
}

function getItemsForString($MainCatID,$catID,$searchString)
{
	global $db;
	$sql="SELECT intItemSerial,strItemDescription FROM matitemlist m where intMainCatID=".$MainCatID." and intSubCatid=".$catID." and intStatus=1 and strItemDescription like '%$searchString%' ORDER BY strItemDescription";
	
	return $db->RunQuery($sql);	
}

function getCustomers()
{
	global $db;
	$sql="SELECT B.strName,B.intBuyerID FROM buyers B where B.intStatus=1 order by B.strName;";
	return $db->RunQuery($sql);
	
	
}

function getBuyingOffice($buyerID)
{
	global $db;
	$sql="SELECT B.intBuyingofficeId,B.strName FROM buyerbuyingoffices B where B.intStatus=1 and B.intbuyerId=".$buyerID.";";
	return $db->RunQuery($sql);
}

function getSeasons()
{
	global $db;
	$sql="SELECT intSeasonId,strSeasonCode,strSeason FROM seasons s where intStatus=1 order by strSeason";
	return $db->RunQuery($sql);	
}

function GetMill()
{
	global $db;
	$sql="SELECT S.strSupplierID,S.strTitle FROM suppliers S where S.intSupplierStatus <>10 and S.intApproved=1 order by S.strTitle";
	return $db->RunQuery($sql);	
}

function getShippingMode()
{
	global $db;
	$sql="SELECT intShipmentModeId,strDescription FROM shipmentmode s where intStatus=1";
	return $db->RunQuery($sql);
	
}
function getCountriesCombo()
{
	global $db;
	$sql="SELECT country.intConID,country.strCountry FROM country WHERE country.intStatus =  '1'";
	return $db->RunQuery($sql);
	
}
//---------Hemanthi (01/09/2010) saveOrderinquiry--------------------------------------------------

function saveOrderinquiry($orderNo,$styleID,$companyID,$description,$buyerID,$qty,$customerRefNo,$date,$poDate,$smv,$smvRate,$fob,$finance,$userID,$approvedBy,$appRemarks,$AppDate,$finPercntage,$approvalNo,$revisedReason,$revisedDate,$revisedBy,$confirmedPrice,$conPriceCurrency,$commission,$efficiencyLevel,$costPerMinute,$dateSentForApprovals,$sentForApprovalsTo,$deliverTo,$freightCharges,$ECSCharge,$labourCost,$buyingOfficeId,$divisionId,$seasonId,$RPTMark,$subContractQty,$subContractSMV,$subContractRate,$subTransportCost,$subCM,$profit,$uPCharges,$facProfit,$fabFinance,$trimFinance,$newCM,$newSMV,$firstApprovedBy,$FirstAppDate,$userID,$color,$dimention,$Mill,$FabricRefNo,$Fabrication,$status,$orderColorCode,$orderType,$buyerOrderNo)
{
//BEGIN - 25-04-2011 - Resetting company order no monthly
$companyOrderNo	= CreateCompanyOrderNo();
//END - 25-04-2011 - Resetting company order no monthly
//$customerRefNo = str_replace("'","''",$customerRefNo);
global $db;
$sql="Insert into orders(strOrderNo,
strStyle,intCompanyID,strDescription,
intBuyerID,intQty".
",intStatus,strCustomerRefNo,dtmDate,
reaSMV,reaSMVRate,reaFOB,reaFinance,intUserID".
",intApprovedBy,strAppRemarks,dtmAppDate,reaExPercentage,
reaFinPercntage,intApprovalNo".
",strRevisedReason,intRevisedBy,
reaConfirmedPrice,strConPriceCurrency,reaCommission".
",reaEfficiencyLevel,reaCostPerMinute,
dtmDateSentForApprovals,intSentForApprovalsTo,strDeliverTo".
",reaFreightCharges,reaECSCharge,reaLabourCost,
intBuyingOfficeId,intDivisionId,intSeasonId,strRPTMark".
",intSubContractQty,reaSubContractSMV,
reaSubContractRate,reaSubTransportCost,reaSubCM".
",reaProfit,reaUPCharges,dblFacProfit,
reaFabFinance,reaTrimFinance,reaNewCM,reaNewSMV".
",intFirstApprovedBy,
strColorCode,dblDimension,strSupplierID,strFabricRefNo,strFabrication,strOrderColorCode,intCompanyOrderNo,dtmOrderDate,wipOrderNo,intOrderType,strBuyerOrderNo)values('".$orderNo."',
'".$styleID."',".$companyID.",'".$description."',
".$buyerID.",".$qty.",".$status.",'".$customerRefNo."',
'".$poDate."',".$smv.",".$smvRate.",".$fob.",".$finance.",
".$userID.",'".$approvedBy."','".$appRemarks."',null,0,
".$finPercntage.",0,'".$revisedReason."','".$revisedBy."',
".$confirmedPrice.",'".$conPriceCurrency."',".$commission.",
".$efficiencyLevel.",".$costPerMinute.",null,
'".$sentForApprovalsTo."','".$deliverTo."',".$freightCharges.",
".$ECSCharge.",".$labourCost.",".$buyingOfficeId.",
".$divisionId.",".$seasonId.",'".$RPTMark."',
".$subContractQty.",".$subContractSMV.",".$subContractRate.",
".$subTransportCost.",".$subCM.",".$profit.",
".$uPCharges.",".$facProfit.",".$fabFinance.",
".$trimFinance.",".$newCM.",".$newSMV.",
".$firstApprovedBy.",
'".$color."','".$dimention."',".$Mill.",'".$FabricRefNo."','".$Fabrication."','$orderColorCode',$companyOrderNo,now(),'$orderNo','$orderType','$buyerOrderNo')";


return  $db->ExecuteQuery($sql);
// return $sql;

}
//---------Hemanthi (01/09/2010) Update Orderinquiry--------------------------------------------------

function UpdateOrderinquiry($orderId,$orderNo,$styleID,$companyID,$description,$buyerID,$qty,$customerRefNo,$date,$poDate,$smv,$smvRate,$fob,$finance,$userID,$approvedBy,$appRemarks,$AppDate,$finPercntage,$approvalNo,$revisedReason,$revisedDate,$revisedBy,$confirmedPrice,$conPriceCurrency,$commission,$efficiencyLevel,$costPerMinute,$dateSentForApprovals,$sentForApprovalsTo,$deliverTo,$freightCharges,$ECSCharge,$labourCost,$buyingOfficeId,$divisionId,$seasonId,$RPTMark,$subContractQty,$subContractSMV,$subContractRate,$subTransportCost,$subCM,$profit,$uPCharges,$facProfit,$fabFinance,$trimFinance,$newCM,$newSMV,$firstApprovedBy,$FirstAppDate,$userID,$color,$dimention,$Mill,$FabricRefNo,$Fabrication,$status,$orderColorCode,$orderType,$buyerOrderNo)
{
  	global $db;
	
	$sql="UPDATE orders SET 
	strRPTMark='$RPTMark',
	strOrderNo='$orderNo',
	strStyle='$styleID',
	intCompanyID = '$companyID',
	strDescription='$description',
	intBuyerID='$buyerID',
    intBuyingOfficeId=$buyingOfficeId, 
	intDivisionId=$divisionId,
	strCustomerRefNo='$customerRefNo',
	strFabricRefNo='$FabricRefNo',
	dtmDate='$poDate',
	intQty='$qty',
	intSeasonId=$seasonId,
	strColorCode='$color',
	dblDimension='$dimention',
	strSupplierID=$Mill,
	strFabrication='$Fabrication',
	strOrderColorCode = '$orderColorCode',
	intOrderType = '$orderType',
	strBuyerOrderNo = '$buyerOrderNo'
    WHERE intStyleId='$orderId'";
	
	 return $db->ExecuteQuery($sql);
}
//--------------------------------------------------------------------------------------------------------------------------------

function saveOrder($orderNo,$styleID,$companyID,$description,$buyerID,$qty,$Coordinator,$status,$customerRefNo,$smv,$date,$smvRate,$fob,$finance,$userID,$approvedBy,$appRemarks,$AppDate,$exPercentage,$finPercntage,$approvalNo,$revisedReason,$revisedDate,$revisedBy,$confirmedPrice,$conPriceCurrency,$commission,$efficiencyLevel,$costPerMinute,$dateSentForApprovals,$sentForApprovalsTo,$deliverTo,$freightCharges,$ECSCharge,$labourCost,$buyingOfficeId,$divisionId,$seasonId,$RPTMark,$subContractQty,$subContractSMV,$subContractRate,$subTransportCost,$subCM,$lineNos,$profit,$uPCharges,$UPChargeDescription,$fabFinance,$trimFinance,$newCM,$newSMV,$firstApprovedBy,$FirstAppDate,$ScheduleMethod,$facProfit,$color,$OrderType,$manufacCompany,$buyerOrderNo, $facOHCost)
{
//BEGIN - 25-04-2011 - Resetting company order no monthly
$companyOrderNo	= CreateCompanyOrderNo();
//END - 25-04-2011 - Resetting company order no monthly

//$customerRefNo = str_replace("'","''",$customerRefNo);
global $db;
$sql="Insert into orders(strOrderNo,strStyle,intCompanyID,strDescription,intBuyerID,intQty".
",intCoordinator,intStatus,strCustomerRefNo,reaSMV,dtmDate,reaSMVRate,reaFOB,reaFinance,intUserID".
",intApprovedBy,strAppRemarks,dtmAppDate,reaExPercentage,reaFinPercntage,intApprovalNo".
",strRevisedReason,strRevisedDate,intRevisedBy,reaConfirmedPrice,strConPriceCurrency,reaCommission".
",reaEfficiencyLevel,reaCostPerMinute,dtmDateSentForApprovals,intSentForApprovalsTo,strDeliverTo".
",reaFreightCharges,reaECSCharge,reaLabourCost,intBuyingOfficeId,intDivisionId,intSeasonId,strRPTMark".
",intSubContractQty,reaSubContractSMV,reaSubContractRate,reaSubTransportCost,reaSubCM,intLineNos".
",reaProfit,reaUPCharges,strUPChargeDescription,reaFabFinance,reaTrimFinance,reaNewCM,reaNewSMV".
",intFirstApprovedBy,dtmFirstAppDate,strScheduleMethod,dblFacProfit,strOrderColorCode,intCompanyOrderNo,dtmOrderDate,intOrderType,wipOrderNo,intManufactureCompanyID,strBuyerOrderNo,dblFacOHCostMin)values('".$orderNo."','".$styleID."',".$companyID.",'".$description."',".$buyerID.",".$qty.",".$Coordinator.",".$status.",'".$customerRefNo."',".$smv.",NOW(),".$smvRate.",".$fob.",".$finance.",'".$userID."','".$approvedBy."','".$appRemarks."',null,".$exPercentage.",".$finPercntage.",0,'".$revisedReason."',null,'".$revisedBy."',".$confirmedPrice.",'".$conPriceCurrency."',".$commission.",".$efficiencyLevel.",".$costPerMinute.",null,'".$sentForApprovalsTo."','".$deliverTo."',".$freightCharges.",".$ECSCharge.",".$labourCost.",".$buyingOfficeId.",".$divisionId.",".$seasonId.",'".$RPTMark."',".$subContractQty.",".$subContractSMV.",".$subContractRate.",".$subTransportCost.",".$subCM.",".$lineNos.",0,".$uPCharges.",'".$UPChargeDescription."',".$fabFinance.",".$trimFinance.",0,0,0,null,'$ScheduleMethod','$facProfit','$color','$companyOrderNo',now(),'$OrderType','$orderNo','$manufacCompany','$buyerOrderNo','$facOHCost');";
//echo $sql;
return $db->ExecuteQuery($sql);
}
//-------------------------------------------------------------------------------------------------------------------------------------
 
	function saveHistoryOrder($orderNo,$styleID,$companyID,$description,$buyerID,$qty,$Coordinator,$status,$customerRefNo,$smv,$date,$smvRate,$fob,$finance,$userID,$approvedBy,$appRemarks,$AppDate,$exPercentage,$finPercntage,$approvalNo,$revisedReason,$revisedDate,$revisedBy,$confirmedPrice,$conPriceCurrency,$commission,$efficiencyLevel,$costPerMinute,$dateSentForApprovals,$sentForApprovalsTo,$deliverTo,$freightCharges,$ECSCharge,$labourCost,$buyingOfficeId,$divisionId,$seasonId,$RPTMark,$subContractQty,$subContractSMV,$subContractRate,$subTransportCost,$subCM,$lineNos,$profit,$uPCharges,$UPChargeDescription,$fabFinance,$trimFinance,$newCM,$newSMV,$firstApprovedBy,$FirstAppDate,$strOrderColorCode,$dblFacProfit)
  {  	
	$buyingOfficeId = ($buyingOfficeId=="" ? 'null':$buyingOfficeId);
	$divisionId = ($divisionId=="" ? 'null':$divisionId);
	$seasonId = ($seasonId=="" ? 'null':$seasonId);
  	global $db;
  	$sql="Insert into history_orders(strOrderNo,intStyleId,intCompanyID,strDescription,intBuyerID,intQty".
  	",intCoordinator,intStatus,strCustomerRefNo,reaSMV,dtmDate,reaSMVRate,reaFOB,reaFinance,intUserID".",intApprovedBy,strAppRemarks,dtmAppDate,reaExPercentage,reaFinPercntage,intApprovalNo".  	",strRevisedReason,strRevisedDate,intRevisedBy,reaConfirmedPrice,strConPriceCurrency,reaCommission".
  ",reaEfficiencyLevel,reaCostPerMinute,dtmDateSentForApprovals,intSentForApprovalsTo,strDeliverTo".  	",reaFreightCharges,reaECSCharge,reaLabourCost,intBuyingOfficeId,intDivisionId,intSeasonId,strRPTMark". ",intSubContractQty,reaSubContractSMV,reaSubContractRate,reaSubTransportCost,reaSubCM,intLineNos".
  	",reaProfit,reaUPCharges,strUPChargeDescription,reaFabFinance,reaTrimFinance,reaNewCM,reaNewSMV".
  	",intFirstApprovedBy,dtmFirstAppDate,strOrderColorCode,dblFacProfit)values('".$orderNo."','".$styleID."',".$companyID.",'".$description."',".$buyerID.",".$qty.",'".$Coordinator."',".$status.",'".$customerRefNo."',".$smv.",'".$date."',".$smvRate.",".$fob.",".$finance.",'".$userID."','".$approvedBy."','".$appRemarks."',null,".$exPercentage.",".$finPercntage.",".$approvalNo.",'".$revisedReason."',now(),'".$revisedBy."',".$confirmedPrice.",'".$conPriceCurrency."',".$commission.",".$efficiencyLevel.",".$costPerMinute.",null,'".$sentForApprovalsTo."','".$deliverTo."',".$freightCharges.",".$ECSCharge.",".$labourCost.",".$buyingOfficeId.",".$divisionId.",".$seasonId.",'".$RPTMark."',".$subContractQty.",".$subContractSMV.",".$subContractRate.",".$subTransportCost.",".$subCM.",".$lineNos.",0,".$uPCharges.",'".$UPChargeDescription."',".$fabFinance.",".$trimFinance.",0,0,'".$firstApprovedBy."','".$FirstAppDate."','".$strOrderColorCode."','$dblFacProfit');";
	

	
  	return $db->executeQuery($sql);
  	
  }
function getDivision($buyerID)
{
	global $db;
	$sql="SELECT intDivisionId,strDivision FROM buyerdivisions b where intStatus=1 and intBuyerID=".$buyerID.";";
	return $db->RunQuery($sql);	
}
//companyID is short form of company name  ex- HO
function getEfficiency($qty,$fac,$smv)
{
global $db;
$sql="SELECT dblEfficiency FROM efficiency_qty e INNER JOIN efficiency_qtysmvgrid q ON ".
     "e.intQtyID=q.intQtyID INNER JOIN efficiency_smv s ON q.intSMVID=s.intSMVID where ".
	 "strFromQty<".$qty." and strToQty>".$qty." and q.intStatus='1' and strCompID=".$fac." and ".
	 "s.strFromSMV<".$smv." and s.strToSMV>".$smv.";";
	 return $db->RunQuery($sql);
}

function saveOrderDetails($strOrderNo,$strStyleID,$intMatDetailID,$strUnit,$dblUnitPrice,$reaConPc,$reaWastage,$strCurrencyID,$intOriginNo,$dblReqQty,$dblTotalQty,$dblTotalValue,$dbltotalcostpc,$freight,$mill,$mainFabricStatus)
{
	global $db;
	$sql="insert into orderdetails(strOrderNo,intStyleId,intMatDetailID,strUnit,dblUnitPrice,reaConPc,reaWastage,strCurrencyID,intOriginNo,dblReqQty,dblTotalQty,dblTotalValue,dbltotalcostpc,dblFreight,intMillId,intMainFabricStatus,intstatus) values ('".$strOrderNo."','".$strStyleID."',".$intMatDetailID.",'".$strUnit."',".$dblUnitPrice.",".$reaConPc.",".$reaWastage.",'".$strCurrencyID."',".$intOriginNo.",".$dblReqQty.",".$dblTotalQty.",".$dblTotalValue.",".$dbltotalcostpc.",'".$freight."','0','0','1');";
	
	

return $db->executeQuery($sql);

}
  function saveHistoryOrderDetails($strOrderNo,$strStyleID,$intMatDetailID,$strUnit,$dblUnitPrice,$reaConPc,$reaWastage,$strCurrencyID,$intOriginNo,$dblReqQty,$dblTotalQty,$dblTotalValue,$dbltotalcostpc,$freight,$approvalNo)
{
	global $db;
	$sql="insert into history_orderdetails(strOrderNo,intStyleId,intMatDetailID,strUnit,dblUnitPrice,reaConPc,reaWastage,strCurrencyID,intOriginNo,dblReqQty,dblTotalQty,dblTotalValue,dbltotalcostpc,dblFreight,intApprovalNo) values ('".$strOrderNo."','".$strStyleID."',".$intMatDetailID.",'".$strUnit."',".$dblUnitPrice.",".$reaConPc.",".$reaWastage.",'".$strCurrencyID."',".$intOriginNo.",".$dblReqQty.",".$dblTotalQty.",".$dblTotalValue.",".$dbltotalcostpc.",'".$freight."','".$approvalNo."');";
	

	return $db->executeQuery($sql);
}

function saveDeliveryDetails($strStyleID,$dtDateofDelivery,$dblQty,$exQty,$modeID,$dbExQty,$isbase,$leadID,$remarks,$estimateddate,$userID,$dtmDate,$handoverDate,$bpo,$refNo,$dtestimated,$contry,$deliStatus,$cutOffDate, $intManuLocationId)
{
	global $db;
	$sql="Insert into deliveryschedule(intStyleId,dtDateofDelivery,dblQty,dbExQty,strShippingMode,isDeliveryBase,intSerialNO,strRemarks,intUserId,dtmDate,dtmHandOverDate,intBPO,intRefNo,estimatedDate,intCountry,intDeliveryStatus,dtmCutOffDate, intManufacturingLocation)values('".$strStyleID."','".$dtDateofDelivery."',".$dblQty.",".$dbExQty.",".$modeID.",'$isbase',$leadID,'$remarks','$userID','$dtmDate','$handoverDate','$bpo','$refNo','$dtestimated','$contry','$deliStatus','$cutOffDate', '$intManuLocationId');";
	
	$db->executeQuery($sql);
	$sql="Insert into bpodelschedule(intStyleId,dtDateofDelivery,strBuyerPONO,intQty,strRemarks,intWithExcessQty)values('".$strStyleID."','".$dtDateofDelivery."','$bpo',".$dblQty.",'$remarks',".$dbExQty.");";
	$db->executeQuery($sql);
//echo $sql;

$sql = "INSERT INTO style_buyerponos 
		(intStyleId, 
		strBuyerPONO,
		strBuyerPoName, 
		strRemarks,
		dblQty,
		strCountryCode
		)
		VALUES
		('$strStyleID', 
		'$bpo', 
		'$bpo',
		'$remarks',
		'$dblQty',
		'$contry'
		);";
	return	$db->executeQuery($sql);
	
	
}



function SaveVariations($strStyleID,$strMatDetailID,$intNo,$dblConPc,$dblUnitPrice,$dblWastage,$strColor,$strRemarks,$qty,$strSize)
{
	global $db;
	$sql="Insert into conpccalculation(intStyleId,strMatDetailID,intNo,dblConPc,dblUnitPrice,dblWastage,strColor,strRemarks,intqty,strSize)values('".$strStyleID."','".$strMatDetailID."','".$intNo."','".$dblConPc."','".$dblUnitPrice."','".$dblWastage."','".$strColor."','".$strRemarks."','".$qty."','$strSize');";

return	$db->executeQuery($sql);

	
}

function SaveHistoryVariations($strStyleID,$strMatDetailID,$intNo,$dblConPc,$dblUnitPrice,$dblWastage,$strColor,$strRemarks,$qty,$approvalNo,$strSize)
{
	global $db;
	$sql="Insert into history_conpccalc(intStyleId,strMatDetailID,intNo,dblConPc,dblUnitPrice,dblWastage,strColor,strRemarks,intqty,intApprovalNo,$strSize)values('".$strStyleID."','".$strMatDetailID."',".$intNo.",".$dblConPc.",".$dblUnitPrice.",".$dblWastage.",'".$strColor."','".$strRemarks."',".$qty.",".$approvalNo.",'$strSize');";
	

	return	$db->executeQuery($sql);
}

function getAvailableStyles($InputLatter)
{
	global $db;
	$sql="select distinct strStyle from orders where strStyle like '$InputLatter%'";
	return $db->RunQuery($sql);
}
//Operation - Insert Queries -1 , Update Quries - 2, Delete Queries - 3 


function getApprovedDataList($companyID)
{
	global $db;
	$sql = "SELECT intStyleId, strDescription, dtmAppDate FROM orders where (intStatus = 11 or intStatus = 13) AND intCompanyID='".$companyID."';";
	//$sql="SELECT o.intStyleId,o.strDescription,o.dtmAppDate FROM orders o INNER JOIN useraccounts u ON o.intUserID=u.intUserID where o.intStatus='11' AND o.intCompanyID='".$companyID."';";
	return $db->RunQuery($sql);
}

function getBuyerApprovedDataList($BuyerID)
{
	global $db;
	$sql = "SELECT intStyleId, strDescription, dtmAppDate FROM orders where intStatus = 11 AND intBuyerID='".$BuyerID."';";
	//$sql="SELECT o.intStyleId,o.strDescription,o.dtmAppDate FROM orders o INNER JOIN useraccounts u ON o.intUserID=u.intUserID where o.intStatus='11' AND o.intCompanyID='".$companyID."';";

	return $db->RunQuery($sql);
}

function RemoveVariations($matID,$styleID)
{
	global $db;
	$sql="DELETE FROM conpccalculation WHERE strMatDetailID='$matID' AND intStyleId= '$styleID' ";	
	$db->executeQuery($sql);

}

function UpdateOrderDetails($strOrderNo,$strStyleID,$intMatDetailID,$strUnit,$dblUnitPrice,$reaConPc,$reaWastage,$strCurrencyID,$intOriginNo,$dblReqQty,$dblTotalQty,$dblTotalValue,$dbltotalcostpc,$freight,$mill,$mainFabric,$isToBeWash)
{
	global $db;
	$sql="update orderdetails set strOrderNo = '$strOrderNo' , strUnit = '$strUnit' , 	dblUnitPrice = '$dblUnitPrice' , 	reaConPc = '$reaConPc' , 	reaWastage = '$reaWastage' , 	strCurrencyID = '$strCurrencyID' , 	intOriginNo = '$intOriginNo' , 	dblReqQty = '$dblReqQty' , 	dblTotalQty = '$dblTotalQty' , 	dblTotalValue = '$dblTotalValue' , 	dbltotalcostpc = '$dbltotalcostpc' , 	dblFreight = '$freight'	,intMillId='0' , intMainFabricStatus='0', intstatus = '1', booWashable = '$isToBeWash'	where	intStyleId = '$strStyleID' and intMatDetailID = '$intMatDetailID' ;";
	//echo $sql;

	return $db->executeQuery($sql);

}

function RemoveItemDetails($matID,$styleID)
{
	global $db;
	$sql="update orderdetails set intstatus = '0' WHERE intMatDetailID='$matID' AND intStyleId= '$styleID' ";	
	$db->executeQuery($sql);

}

function savePODeliveryDetails($strStyleID,$dtDateofDelivery,$dblQty,$exQty,$buyerPO,$remarks)
{
	global $db;
	//$sql="Insert into deliveryschedule(intStyleId,dtDateofDelivery,dblQty,dbExQty,strShippingMode,isDeliveryBase,intSerialNO,strRemarks)values('".$strStyleID."','".$dtDateofDelivery."',".$dblQty.",".$dbExQty.",".$modeID.",'$isbase',$leadID,'$remarks');";
	$sql = "insert into bpodelschedule (intStyleId,dtDateofDelivery,strBuyerPONO,intQty,strRemarks,intWithExcessQty ) Values ('$strStyleID','$dtDateofDelivery','$buyerPO',$dblQty,'$remarks',$exQty );";
	

	return	$db->executeQuery($sql);
	
	
}

function ChangeAndSaveDeliveryDetails($strStyleID,$dtDateofDelivery,$dblQty,$exQty,$modeID,$dbExQty,$isbase,$leadID,$remarks,$oldDate,$dtestimated,$userID,$dtmDate,$bpo,$refNo,$handOverdate,$contry,$deliverystatus,$prmcutoffdate)
{
	global $db;
	
	$sql="insert into history_deliveryschedule 
	(intDeliveryId,
	intStyleId, 
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
	estimatedDate,
	intUserId,
	dtmDate,
	dtmHandOverDate,
	intBPO,
	intRefNo,
	intCountry,
	intDeliveryStatus,
	dtmCutOffDate
	)
	
select * from deliveryschedule where intStyleId = '$strStyleID' and dtDateofDelivery = '$oldDate' ;";
$db->executeQuery($sql);

	$sql = "DELETE FROM bpodelschedule WHERE intStyleId = '$strStyleID' and dtDateofDelivery = '$oldDate';;";
	$db->RunQuery($sql);
	
	 $sql = "DELETE FROM deliveryschedule WHERE  intStyleId = '$strStyleID' and dtDateofDelivery = '$oldDate'";
	$db->RunQuery($sql);
	
	 $sql = "DELETE FROM style_buyerponos WHERE intStyleId = '$strStyleID' and dtDateofDelivery = '$oldDate'";
	$db->RunQuery($sql);
	saveChangedDeliveryDetails($strStyleID,$dtDateofDelivery,$dblQty,$exQty,$modeID,$dbExQty,$isbase,$leadID,$remarks,$dtestimated,$userID,$dtmDate,$handOverdate,$bpo,$refNo,$dtestimated,$contry,$deliverystatus,$prmcutoffdate);
	
}

function saveChangedDeliveryDetails($strStyleID,$dtDateofDelivery,$dblQty,$exQty,$modeID,$dbExQty,$isbase,$leadID,$remarks,$dtestimated,$userID,$dtmDate,$handOverdate,$bpo,$refNo,$dtestimated,$contry, $deliverystatus, $cutoffdate)
{
global $db;
 $sql="Insert into deliveryschedule(intStyleId,dtDateofDelivery,dblQty,dbExQty,strShippingMode,isDeliveryBase,intSerialNO,strRemarks,intUserId,dtmDate,dtmHandOverDate,intBPO,intRefNo,estimatedDate,intCountry, intDeliveryStatus, dtmCutOffDate)values('".$strStyleID."','".$dtDateofDelivery."',".$dblQty.",".$dbExQty.",".$modeID.",'$isbase',$leadID,'$remarks','$userID','$dtmDate','$handOverdate','$bpo','$refNo','$dtestimated','$contry','$deliverystatus','$cutoffdate');";
	
	$db->executeQuery($sql);
	 $sql="Insert into bpodelschedule(intStyleId,dtDateofDelivery,strBuyerPONO,intQty,strRemarks,intWithExcessQty)values('".$strStyleID."','".$dtDateofDelivery."','$bpo',".$dblQty.",'$remarks',".$dbExQty.");";
	$db->executeQuery($sql);
//echo $sql;

 $sql = "INSERT INTO style_buyerponos 
		(intStyleId, 
		strBuyerPONO,
		strBuyerPoName, 
		strRemarks,
		dblQty,
		strCountryCode
		)
		VALUES
		('$strStyleID', 
		'$bpo', 
		'$bpo',
		'$remarks',
		'$dblQty',
		'$contry'
		);";
	return	$db->executeQuery($sql);
}


//function removeScheduleBPOAllocation($styleID,$dtDateofDelivery)
function removeScheduleBPOAllocation($styleID,$strBpoNo)
{
	global $db;
        // =======================================================
        // Comment On - 02/22/2017
        // Comment By - Nalin Jayakody
        // Comment For - To add buyer po number instead of delivery date
        // ======================================================== 
	 //$sql="delete from bpodelschedule where intStyleId = '$styleID' AND dtDateofDelivery = '$dtDateofDelivery';";
        // ========================================================
        $sql="delete from bpodelschedule where intStyleId = '$styleID' AND strBuyerPONO = '$strBpoNo';";
        //echo $sql;
	return	$db->executeQuery($sql);
}
//function removeStyleBuyerPos($styleID,$dtDateofDelivery)
function removeStyleBuyerPos($styleID,$strBpoNo)
{
	global $db;
        
        // =======================================================
        // Comment On - 02/22/2017
        // Comment By - Nalin Jayakody
        // Comment For - To add buyer po number instead of delivery date
        // ======================================================== 
	 //$sql="delete from style_buyerponos where intStyleId = '$styleID'";
        // ========================================================
        $sql="delete from style_buyerponos where intStyleId = '$styleID' AND strBuyerPONO = '$strBpoNo'";

	return	$db->executeQuery($sql);
}

//function removeDeleverySchedule($strStyleID,$dtDateofDelivery)
function removeDeleverySchedule($strStyleID,$strBpoNo)
{
	global $db;
	
	$sql="
insert into history_deliveryschedule 
	(intDeliveryId,
	intStyleId, 
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
	estimatedDate,
	intUserId,
	dtmDate,
	dtmHandOverDate,
	intBPO,
	intRefNo,
	intCountry
	)
	
select * from deliveryschedule where intStyleId = '$strStyleID' AND intBPO = '$strBpoNo';";

	$db->executeQuery($sql);
	// =======================================================
        // Comment On - 02/22/2017
        // Comment By - Nalin Jayakody
        // Comment For - To add buyer po number instead of delivery date
        // ========================================================          
	//$sql="delete from deliveryschedule where intStyleId = '$strStyleID' AND dtDateofDelivery = '$dtDateofDelivery';";
        // ========================================================  
	$sql="delete from deliveryschedule where intStyleId = '$strStyleID' AND intBPO = '$strBpoNo';";
	$db->executeQuery($sql);

}

function updateItemDetails($styleID,$qty,$exPercentage)
{
	
	
	global $db;
	$sql= "select orderdetails.intMatDetailID,matitemlist.intMainCatID, orderdetails.dblUnitPrice, orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.dblFreight from orderdetails inner join matitemlist on orderdetails.intMatDetailID = matitemlist.intItemSerial where orderdetails.intStyleId = '$styleID' AND (orderdetails.intstatus != '0' or orderdetails.intstatus IS NULL);";
	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$matCatID = $row["intMainCatID"];
		$matID = $row["intMatDetailID"];
		$excessallowed = false;
		$wastagealowed = false;
		$uniPrice = $row["dblUnitPrice"];
		$conPc = $row["reaConPc"];
		$reaWastage = $row["reaWastage"];
		$dblFreight = $row["dblFreight"];
		
		//start 2010-10-19 -- calculate required Qty
		$reqQty = $qty*$conPc;
		
		// Calculate raw material required quantity for excess quantity.
		// ============================================================= 
		$exQty	= 0;//($qty + (($qty * $exPercentage)/100));	
		// =============================================================
		// ----------------------------------
		$SQL = "select intID,strID,strDescription,preorderExcessallowed,preorderWastageAllowed from matmaincategory where intID=$matCatID" ;
		$resultsub = $db->RunQuery($SQL);
		while($rowsub = mysql_fetch_array($resultsub))
		{
				//$exQty	= $qty;
				$totalQty = $reqQty;
			if ($rowsub["preorderExcessallowed"]=='1')
			{
				$excessallowed = true;
				//$exQty	= ($qty + (($qty * $exPercentage)/100));
				$totalQty = $reqQty;// + (($reqQty*$exPercentage)/100);
				
			}
			
			
			if ($rowsub["preorderWastageAllowed"]=='1')
			{
				$wastagealowed= true;
			}

		}
		
		
		
			
		
		if (!$wastagealowed )
		{			
			/*$sql="update orderdetails set dblReqQty = reaConPc * $qty , dblTotalQty = CEIL(reaConPc * $qty)  , dblTotalValue = round((dblTotalQty * (dblUnitPrice + dblFreight )),4), dbltotalcostpc = round((dblTotalValue / $exQty),4) where intStyleId = '$styleID' AND intMatDetailID =$matID;";*/
			//start 2010-10-19
			/*$sql="update orderdetails set dblReqQty = reaConPc * $qty , dblTotalQty = round((reaConPc * $exQty),0)  , dblTotalValue = round((dblTotalQty * (dblUnitPrice + dblFreight )),4), dbltotalcostpc = round((dblTotalValue / $exQty),4) where intStyleId = '$styleID' AND intMatDetailID =$matID;";*/
			
						
			if($reqQty <1)
				$reqQty =1;
			else
				$reqQty = round($reqQty,0);
			
			if($totalQty <1)
				$totalQty =1;
			/*else
				$totalQty = ceil($totalQty);*/
					
			/*$totalValue = round($totalQty*($uniPrice+$dblFreight),4);
			$costPC = round($totalValue/$exQty,4);*/
			
			$sql="update orderdetails set
			 dblReqQty = $reqQty ,
			 dblTotalQty = CEIL($totalQty) ,
			 dblTotalValue = round(CEIL($totalQty)*($uniPrice+$dblFreight),4) , 
			 dbltotalcostpc = round(CEIL($totalQty)*($uniPrice+$dblFreight)/$qty,4)
			 where intStyleId = '$styleID' AND intMatDetailID =$matID;";
			
			
			$db->executeQuery($sql);
		}
		else
		{	
					
			/*$sql="update orderdetails set dblReqQty = reaConPc * $qty , dblTotalQty = CEIL((reaConPc * $qty) + (reaConPc * $qty * reaWastage / 100) + (reaConPc * $qty * $exPercentage / 100)) , dblTotalValue =round((dblTotalQty * (dblUnitPrice + dblFreight )),4) , dbltotalcostpc =round((dblTotalValue / $exQty),4) where intStyleId = '$styleID' AND intMatDetailID =$matID;";*/
			//start 2010-10-19
			/*$sql="update orderdetails set dblReqQty = reaConPc * $qty , dblTotalQty =round(((reaConPc * $exQty) + (reaConPc * $qty * reaWastage / 100)),0) , dblTotalValue =round((dblTotalQty * (dblUnitPrice + dblFreight )),4) , dbltotalcostpc =round((dblTotalValue / $exQty),4) where intStyleId = '$styleID' AND intMatDetailID =$matID;";*/
			
			
			$totalQty = $totalQty + ($reqQty*$reaWastage/100);
			
			if($totalQty <1)
				$totalQty =1;
			/*else
				$totalQty = ceil($totalQty);//round($totalQty,0);
			echo $totalQty.' ';*/
			
			if($reqQty <1)
				$reqQty =1;
			else
				$reqQty = round($reqQty,0);
					
			//$totalValue = round($totalQty*($uniPrice+$dblFreight),4);
			//$costPC = round($totalValue/$exQty,4);
			
			$sql = "update orderdetails set 
			        dblReqQty = $reqQty , 
					dblTotalQty = CEIL($totalQty) , 
					dblTotalValue = round(CEIL($totalQty)*($uniPrice+$dblFreight),4) , 
					dbltotalcostpc = round(CEIL($totalQty)*($uniPrice+$dblFreight)/$qty,4)
					where intStyleId = '$styleID' AND intMatDetailID =$matID;";
			//echo $sql;
			$db->executeQuery($sql);
		}
	}	
}

  function saveModifiedOrder($orderNo,$styleID,$companyID,$description,$buyerID,$qty,$Coordinator,$status,$customerRefNo,$smv,$date,$smvRate,$fob,$finance,$userID,$approvedBy,$appRemarks,$AppDate,$exPercentage,$finPercntage,$approvalNo,$revisedReason,$revisedDate,$revisedBy,$confirmedPrice,$conPriceCurrency,$commission,$efficiencyLevel,$costPerMinute,$dateSentForApprovals,$sentForApprovalsTo,$deliverTo,$freightCharges,$ECSCharge,$labourCost,$buyingOfficeId,$divisionId,$seasonId,$RPTMark,$subContractQty,$subContractSMV,$subContractRate,$subTransportCost,$subCM,$lineNos,$profit,$uPCharges,$UPChargeDescription,$fabFinance,$trimFinance,$newCM,$newSMV,$firstApprovedBy,$FirstAppDate,$ScheduleMethod,$orderUnit,$proSubcat,$facProfit,$orderType,$mafactureCompanyID,$packSMV,$prmStyleLevel,$prmDtPCD)
  {
  
  	global $db;
/*  	$sql="Insert into orders(strOrderNo,strStyle,intCompanyID,strDescription,intBuyerID,intQty".
  	",intCoordinator,intStatus,strCustomerRefNo,reaSMV,dtmDate,reaSMVRate,reaFOB,reaFinance,intUserID".
  	",intApprovedBy,strAppRemarks,dtmAppDate,reaExPercentage,reaFinPercntage,intApprovalNo".
  	",strRevisedReason,strRevisedDate,intRevisedBy,reaConfirmedPrice,strConPriceCurrency,reaCommission".
  	",reaEfficiencyLevel,reaCostPerMinute,dtmDateSentForApprovals,intSentForApprovalsTo,strDeliverTo".
  	",reaFreightCharges,reaECSCharge,reaLabourCost,intBuyingOfficeId,intDivisionId,intSeasonId,strRPTMark".
	  ",intSubContractQty,reaSubContractSMV,reaSubContractRate,reaSubTransportCost,reaSubCM,intLineNos".
  	",reaProfit,reaUPCharges,strUPChargeDescription,reaFabFinance,reaTrimFinance,reaNewCM,reaNewSMV".
  	",intFirstApprovedBy,dtmFirstAppDate,strScheduleMethod)values('".$orderNo."','".$styleID."',".$companyID.",'".$description."',".$buyerID.",".$qty.",'".$Coordinator."',".$status.",'".$customerRefNo."',".$smv.",NOW(),".$smvRate.",".$fob.",".$finance.",'".$userID."','".$approvedBy."','".$appRemarks."',null,".$exPercentage.",".$finPercntage.",".$approvalNo.",'".$revisedReason."',null,'".$revisedBy."',".$confirmedPrice.",'".$conPriceCurrency."',".$commission.",".$efficiencyLevel.",".$costPerMinute.",null,'".$sentForApprovalsTo."','".$deliverTo."',".$freightCharges.",".$ECSCharge.",".$labourCost.",".$buyingOfficeId.",".$divisionId.",".$seasonId.",'".$RPTMark."',".$subContractQty.",".$subContractSMV.",".$subContractRate.",".$subTransportCost.",".$subCM.",".$lineNos.",0,".$uPCharges.",'".$UPChargeDescription."',".$fabFinance.",".$trimFinance.",0,0,0,null,'$ScheduleMethod');";
	*/
	
	//$customerRefNo = str_replace("'","''",$customerRefNo);
	
	 $sql= "update orders ".
			"set ".
			"strOrderNo = '$orderNo' , ".
			"intCompanyID = '$companyID' , ".
			"strDescription = '$description' , ".
			"intBuyerID = '$buyerID' , ".
			"intQty = '$qty' , ".
			"intCoordinator = '$Coordinator' , ".
			"intStatus = '$status' , ".
			"strCustomerRefNo = '$customerRefNo' , ".
			"reaSMV = '$smv' , ".
			//"dtmDate = now() , ".
			"reaSMVRate = '$smvRate' , ".
			"reaFOB = '$fob' , ".
			"reaFinance = '$finance' , ".
			"reaExPercentage = '$exPercentage' , ".
			"reaFinPercntage = '$finPercntage' , ".
			"reaConfirmedPrice = '$confirmedPrice' , ".
			"strConPriceCurrency = '$conPriceCurrency' , ".
			"reaCommission = '$commission' , ".
			"reaEfficiencyLevel = '$efficiencyLevel' , ".
			"reaCostPerMinute = '$costPerMinute' , ".
			"intSentForApprovalsTo = '$sentForApprovalsTo' , ".
			"strDeliverTo = '$deliverTo' , ".
			"reaFreightCharges = '$freightCharges' , ".
			"reaECSCharge = '$ECSCharge' , ".
			"reaLabourCost = '$labourCost' , ".
			"intBuyingOfficeId = $buyingOfficeId , ".
			"intDivisionId = $divisionId , ".
			"intSeasonId = $seasonId , ".
			//"strRPTMark = '$RPTMark' , ".
			"intSubContractQty = '$subContractQty' , ".
			"reaSubContractSMV = '$subContractSMV' , ".
			"reaSubContractRate = '$subContractRate' , ".
			"reaSubTransportCost = '$subTransportCost' , ".
			"reaSubCM = '$subCM' , ".
			"intLineNos = '$lineNos' , ".
			"reaProfit = '$profit' , ".
			"reaUPCharges = '$uPCharges' , ".
			"strUPChargeDescription = '$UPChargeDescription' , ".
			"reaFabFinance = '$fabFinance' , ".
			"reaTrimFinance = '$trimFinance' , ".
			"reaNewCM = '$newCM' , ".
			"reaNewSMV = '$newSMV' , ".
			"intFirstApprovedBy = '$firstApprovedBy' , ".
			"orderUnit = '$orderUnit' , ".
			"productSubCategory = '$proSubcat' , ".
			"strScheduleMethod = '$ScheduleMethod',	".
			"dblFacProfit = '$facProfit', ".
			"intOrderType='$orderType' , 
			intManufactureCompanyID ='$mafactureCompanyID', ".
                        "reaPackSMV = '$packSMV', ".
                        "dtPCD = '$prmDtPCD', ".
                        "sStyleLevel = '$prmStyleLevel'".
			"where ".
			"intStyleId = '$styleID' ;";
	
//echo $sql;
	return $db->ExecuteQuery($sql);
  	
  	 
  }
  
function getPurchasedQty($styleID,$materialID)
{
	global $db;
	$purchasedQty = 0;
	//Start - Get confirm purchase qty
	$sql="select COALESCE(Sum(purchaseorderdetails.dblQty),0) as purchasedQty from purchaseorderdetails inner join purchaseorderheader on purchaseorderheader.intPONo = purchaseorderdetails.intPONo AND purchaseorderheader.intYear = purchaseorderdetails.intYear where intStyleId = '$styleID'  AND purchaseorderdetails.intPOType=0 and purchaseorderheader.intStatus = 10";
	if($materialID != '')
		$sql .= " AND purchaseorderdetails.intMatDetailID = '$materialID' ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$purchasedQty += $row["purchasedQty"];
	}
	
	//End - Get confirm purchase qty
	
	//Start - Get leftOver allocation qty
	$sql="select COALESCE(Sum(LD.dblQty),0) as leftOverAlloQty from commonstock_leftoverheader LH 
inner join commonstock_leftoverdetails LD on LH.intTransferNo=LD.intTransferNo and LH.intTransferYear=LD.intTransferYear
where LH.intToStyleId='$styleID'and intStatus=1";
	if($materialID != '')
		$sql .= " and  LD.intMatDetailId='$materialID'";
		
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$purchasedQty += $row["leftOverAlloQty"];
	}
	
	//End - Get leftOver allocation qty
	
	//Start - Get bulk allocation qty
	$sql="select COALESCE(Sum(BD.dblQty),0) as bulkAlloQty from commonstock_bulkheader BH 
inner join commonstock_bulkdetails BD on BH.intTransferNo=BD.intTransferNo and BH.intTransferYear=BD.intTransferYear
where BH.intToStyleId='$styleID'
 and BH.intStatus=1";
	if($materialID != '')
		$sql .= " and  BD.intMatDetailId='$materialID' ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$purchasedQty += $row["bulkAlloQty"];
	}
	//End - Get bulk allocation qty
	
	//Start - Get interjob allocation qty
	$sql="select COALESCE(Sum(ID.dblQty),0) as interJobQty from itemtransfer IH 
inner join itemtransferdetails ID on IH.intTransferId=ID.intTransferId and IH.intTransferYear=ID.intTransferYear
where IH.intStyleIdTo='$styleID'
and IH.intStatus=3 ";
	if($materialID != '')
		$sql .= " and  ID.intMatDetailId='$materialID'";
		
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$purchasedQty += $row["interJoibQty"];
	}
	//End - Get interjob allocation qty
	
	//Start - Get confirmed Liabilty allocation qty
	$sqlLB = "SELECT COALESCE(sum(LCD.dblQty),0) as LiabilityAlloqty
			FROM commonstock_liabilitydetails LCD INNER JOIN commonstock_liabilityheader LCH ON
			LCH.intTransferNo = LCD.intTransferNo AND 
			LCH.intTransferYear = LCD.intTransferYear
			WHERE LCH.intToStyleId = '$styleID'  and   LCH.intStatus=1 ";	
	if($materialID != '')
		$sqlLB .= " and  LCD.intMatDetailId ='$materialID'";
							
			$resultLB = $db->RunQuery($sqlLB);	
			$rowLB = mysql_fetch_array($resultLB);
			$LBAlloqty = $rowLB["LiabilityAlloqty"];
		
		$purchasedQty += $LBAlloqty;			
	//End - Get confirmed Liabilty allocation qty
	return $purchasedQty;
}

function clearGarbage($styleID)
{
	global $db;
	$sql = "SELECT intScheduleId,dtDeliveryDate FROM eventscheduleheader WHERE dtDeliveryDate NOT IN (SELECT dtDateofDelivery FROM deliveryschedule WHERE intStyleId = '$styleID') AND intStyleId = '$styleID'";
	$result = $db->RunQuery($sql);	
	while($row = mysql_fetch_array($result))
	{
		$sql = "DELETE FROM eventscheduledetail WHERE intScheduleId = '" . $row["intScheduleId"]  . "';";
		$db->executeQuery($sql);
		
		$sql = "DELETE FROM eventscheduleheader WHERE intScheduleId = '" . $row["intScheduleId"]  . "';";
		$db->executeQuery($sql);
	}
	
	$sql = "SELECT dtDateofDelivery FROM deliveryschedule WHERE intStyleId = '$styleID'";
	$result = $db->RunQuery($sql);	
	while($row = mysql_fetch_array($result))
	{
		$sql = "DELETE FROM eventscheduleheader WHERE intStyleId='$styleID' AND dtDeliveryDate ='" . $row["dtDateofDelivery"]  . "' AND strBuyerPONO NOT IN( SELECT strBuyerPONO FROM bpodelschedule WHERE intStyleId = '$styleID' AND dtDateofDelivery = '" . $row["dtDateofDelivery"]  . "') AND strBuyerPONO != '#Main Ratio#';";
		$db->executeQuery($sql);
	}
	
	$sql = "SELECT dtDateofDelivery, strBuyerPONO FROM bpodelschedule WHERE intStyleId = '$styleID'";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$sql = "DELETE FROM eventscheduleheader WHERE intStyleId='$styleID' AND dtDeliveryDate ='" . $row["dtDateofDelivery"]  . "' AND strBuyerPONO = '#Main Ratio#'";
		$db->executeQuery($sql);
	}
	
	// Remove unwanted variations 
	$sql = "DELETE FROM conpccalculation WHERE intStyleId = '$styleID' AND strMatDetailID NOT IN (SELECT intMatDetailID FROM orderdetails WHERE intStyleId = '$styleID')";
	$db->executeQuery($sql);
}

function getPerchasedPrice($reqStyleID,$materialID)
{
	global $db;
	$purchasedQty = 0;
	$purchValue = 0;
	$bulkPurchQty = 0;
	$bulkPurchValue = 0;
	$averagePrice =0;	
	$sql_s = " select  pd.dblQty,pd.dblUnitPrice/ph.dblExchangeRate as unitprice
from purchaseorderheader ph inner join purchaseorderdetails pd on 
ph.intPoNo = pd.intPoNo and ph.intYear= pd.intYear
where ph.intStatus=10 and pd.intStyleId='$reqStyleID'  and pd.intPOType=0 and pd.intMatDetailID='$materialID' ";
	$result_s = $db->RunQuery($sql_s);	
	while($rowS = mysql_fetch_array($result_s))
	{
		$purchasedQty += $rowS["dblQty"];
		$purchValue += round($rowS["dblQty"]*$rowS["unitprice"],4);
	}
	
	$sql_b = "select bpo.dblUnitPrice/bgh.dblRate as uintprice,cbd.dblQty
from commonstock_bulkheader cbh
 inner join commonstock_bulkdetails cbd on
cbh.intTransferNo = cbd.intTransferNo and cbh.intTransferYear = cbd.intTransferYear
inner join bulkgrnheader bgh on bgh.intBulkGrnNo = cbd.intBulkGrnNo and 
bgh.intYear = cbd.intBulkGRNYear 
inner join bulkpurchaseorderdetails bpo on
bpo.intBulkPoNo = cbd.intBulkPoNo and bpo.intYear = cbd.intBulkPOYear and 
bpo.intBulkPoNo = bgh.intBulkPoNo and bpo.intYear = bgh.intBulkPoYear
inner join bulkpurchaseorderheader bpoh on bpoh.intBulkPoNo = bpo.intBulkPoNo
and bpoh.intYear = bpo.intYear and bpoh.intBulkPoNo = cbd.intBulkPoNo  and
bpoh.intYear = cbd.intBulkPOYear
where cbh.intStatus = 1 and cbh.intToStyleId='$reqStyleID' and bpo.intMatDetailId='$materialID'";
	$result_b = $db->RunQuery($sql_b);	
	
	while($rowB = mysql_fetch_array($result_b))
	{
		$bulkPurchQty += $rowB["dblQty"];
		$bulkPurchValue += round($rowB["dblQty"]*$rowB["uintprice"],4);
	}
	$averagePrice =($purchValue+$bulkPurchValue)/($purchasedQty+$bulkPurchQty);
	return round($averagePrice,4);
}

function updateEfficiancy($styleID,$qty,$smvRate)
{
	global $db;
	$TotSMV=0;
	$TotUM	=0;
        $totalSMV = 0;
	//$sql = "SELECT intPartId, dblsmv FROM stylepartdetails WHERE intStyleId = '$styleID';";
	$sql = "SELECT intPartId, dblsmv, dblPackSMV FROM stylepartdetails WHERE intStyleId = '$styleID';";
	$result=$db->RunQuery($sql);
	
	while ($row=mysql_fetch_array($result))
	{	
		$partID = $row["intPartId"];
		$smv = $row["dblsmv"];
                $packSMV = $row["dblPackSMV"];
                $totalSMV = $smv + $packSMV;
		//$efficiancy = getEfficiancyLevel($smv,$qty);
		$efficiancy = getEfficiancyLevel($totalSMV,$qty);
                
		if ($efficiancy == 0 ) break;
		//$TotSMV +=$smv ;
		$TotSMV +=$totalSMV ;
                /*echo "Total SMV ".$TotSMV."<br />"; 
                echo "Total line SMV $totalSMV ";
                echo "Total Eff ".$efficiancy."<br />";*/
		//$UM=($smv*100)/$efficiancy;
		$UM=($totalSMV*100)/$efficiancy;
		$TotUM+=$UM;
		$sql = "UPDATE stylepartdetails SET dblEffLevel = '$efficiancy', dblSmvRate = '$smvRate' WHERE intStyleId = '$styleID' AND intPartId = '$partID';";
                //echo $sql;
		$db->executeQuery($sql);
	}
	$EffSum=round(($TotSMV/$TotUM)*100);
	$sql = "UPDATE orders SET reaEfficiencyLevel = '$EffSum' WHERE intStyleId = '$styleID';";
	$db->executeQuery($sql);
	return $EffSum;
}

function getEfficiancyLevel($SMV,$Qty)
{
	global $db;
	$efficiancy = 0;
	$SQL="SELECT efficiency_qty.strFromQty, efficiency_qty.strToQty, efficiency_smv.strFromSMV, ".
       	 "efficiency_smv.strToSMV, efficiency_qtysmvgrid.dblEfficiency ".
		 "FROM efficiency_qtysmvgrid ".
		 "INNER JOIN efficiency_qty ".
		 "ON efficiency_qtysmvgrid.intQtyID = efficiency_qty.intQtyID ".
		 "INNER JOIN efficiency_smv ".
		 "ON efficiency_qtysmvgrid.intSMVID = efficiency_smv.intSMVID ".
		 "WHERE ($Qty BETWEEN efficiency_qty.strFromQty AND efficiency_qty.strToQty) ".
		 "AND $SMV BETWEEN efficiency_smv.strFromSMV  AND efficiency_smv.strToSMV ".
		 "AND efficiency_qtysmvgrid.dblEfficiency > 0 ";
	//echo $SQL;
	$result=$db->RunQuery($SQL);
	
	while ($row=mysql_fetch_array($result))
	{		
		 $efficiancy = $row["dblEfficiency"] ;		
	}
	return $efficiancy;
}
function GetSavedStyleId($styleName)
{
	global $db;
	$sql="select intStyleId from orders where strStyle='$styleName'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$sourceStyleId = $row["intStyleId"] ;		
	}
	return $sourceStyleId;
}
function GetStyle($styleId)
{
	global $db;
	$sql="select strStyle from orders where intStyleId='$styleId'";	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$styleName = $row["strStyle"];		
	}
	return $styleName;	
}

function GetCopyStyleId($styleName)
{
	global $db;
	$sql="select intStyleId from orders where strOrderNo='$styleName'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$sourceStyleId = $row["intStyleId"] ;		
	}
	return $sourceStyleId;
}

//--------Hemanthi (2010/09/10)-------------------------------------------------
if(strcmp($RequestType,"getStyleCustomer") == 0)
{
$ResponseXML="";
$ResponseXML.="<MainStyleNo>";
$buyerID=$_GET["buyerID"];
global $db;
if($buyerID!="")
{
$sql="SELECT distinct  strStyle FROM orders where intBuyerID='$buyerID' and intStatus='2' order by strStyle";
}
else
{
	$sql="SELECT distinct strStyle FROM orders where intStatus='2' order by strStyle";
}
 
 $result=$db->RunQuery($sql);
 $str .= "<option value=\"".""."\">Select One</option>";
while($row = mysql_fetch_array($result))
{
	$str .= "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>";
}

$ResponseXML .= "<StyleNo><![CDATA[" . $str . "]]></StyleNo>\n";
$ResponseXML.="</MainStyleNo>";
echo $ResponseXML;
}
//--------Hemanthi (2010/09/10)-------------------------------------------------

//get buyer wise order details to order inquiry
//start 2010-10-16 --------------------------------------------------------------
if(strcmp($RequestType,"getBuyerOrderNo") == 0)
{
$ResponseXML="";
$ResponseXML.="<MainStyleNo>";
$buyerID=$_GET["buyerID"];
global $db;
if($buyerID!="")
{
$sql="SELECT intStyleId,strOrderNo FROM orders where intBuyerID='$buyerID' and intStatus='2' order by strOrderNo";
}
else
{
	$sql="SELECT intStyleId, strOrderNo FROM orders where intStatus='2' order by strOrderNo";
}
 
 $result=$db->RunQuery($sql);
 $str .= "<option value=\"".""."\">Select One</option>";
while($row = mysql_fetch_array($result))
{
//$ResponseXML .= "<StyleNo><![CDATA[" . $row["strStyle"]. "]]></StyleNo>\n";
	$str .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>";
}

$ResponseXML .= "<OrderNo><![CDATA[" . $str . "]]></OrderNo>\n";
$ResponseXML.="</MainStyleNo>";
echo $ResponseXML;
}
//--------------------------------------------------------------------------------
if(strcmp($RequestType,"loadDetailsForStyle") == 0)
{
$ResponseXML="";
$ResponseXML.="<Details>";
$StyleNo=$_GET["StyleNo"];
global $db;
	  $sql = "SELECT * FROM orders where intStyleId = '".$StyleNo."' AND intStatus='2'";
	  $result= $db->RunQuery($sql);
	  $row = mysql_fetch_array($result);
	  
	$poDate=$row["dtmDate"];
	if($poDate!=""){
	$AppDateFromArray		= explode('-',$poDate);
	$AppDateFromArray2		= explode(' ',$AppDateFromArray[2]);	
	$poDate = $AppDateFromArray2[0]."/".$AppDateFromArray[1]."/".$AppDateFromArray[0];
	}
		
		$styleNameLength	= strlen($row["strStyle"]); 
		$repeatLength		= strlen($row["strRPTMark"]); 
		if($repeatLength==0) 
			$styleName 		= substr($row["strStyle"],0,$styleNameLength-$repeatLength);
		else
			$styleName 		= substr($row["strStyle"],0,$styleNameLength-$repeatLength-1);
		
		$orderNoLength 		= strlen($row["strOrderNo"]);
		$colorCodeLength    = strlen($row["strOrderColorCode"]);
		
		if($colorCodeLength == 0)
			$orderNo = substr($row["strOrderNo"],0,$orderNoLength-$colorCodeLength);
		else
			$orderNo = substr($row["strOrderNo"],0,$orderNoLength-$colorCodeLength-1);
		
		$ResponseXML .= "<fabrication><![CDATA[" . $row["strFabrication"]  . "]]></fabrication>\n";
		$ResponseXML .= "<strStyleNo><![CDATA[" . $styleName  . "]]></strStyleNo>\n";
		$ResponseXML .= "<RepeatNo><![CDATA[" . $row["strRPTMark"]  . "]]></RepeatNo>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . $row["strDescription"]  . "]]></strStyle>\n";
		$ResponseXML .= "<customer><![CDATA[" . $row["intBuyerID"]  . "]]></customer>\n";
		$ResponseXML .= "<buyingOffice><![CDATA[" . $row["intBuyingOfficeId"]  . "]]></buyingOffice>\n";
		$ResponseXML .= "<Devision><![CDATA[" . $row["intDivisionId"]  . "]]></Devision>\n";
		$ResponseXML .= "<reffer><![CDATA[" . $row["strCustomerRefNo"]  . "]]></reffer>\n";
		$ResponseXML .= "<fabReffer><![CDATA[" . $row["strFabricRefNo"]  . "]]></fabReffer>\n";
		$ResponseXML .= "<poNo><![CDATA[" . $orderNo  . "]]></poNo>\n";
		$ResponseXML .= "<PoDate><![CDATA[" . $poDate  . "]]></PoDate>\n";
		$ResponseXML .= "<orgPoQty><![CDATA[" . $row["intQty"]  . "]]></orgPoQty>\n";
		$ResponseXML .= "<season><![CDATA[" . $row["intSeasonId"]  . "]]></season>\n";
		$ResponseXML .= "<color><![CDATA[" . $row["strColorCode"]  . "]]></color>\n";
		$ResponseXML .= "<dimension><![CDATA[" . $row["dblDimension"]  . "]]></dimension>\n";
		$ResponseXML .= "<mill><![CDATA[" . $row["strSupplierID"]  . "]]></mill>\n";
		$ResponseXML .= "<fabrication><![CDATA[" . $row["strFabrication"]  . "]]></fabrication>\n";
		$ResponseXML .= "<orderColorCode><![CDATA[" . $row["strOrderColorCode"]  . "]]></orderColorCode>\n";
		$ResponseXML .= "<orderType><![CDATA[" . $row["intOrderType"]  . "]]></orderType>\n";
		
$ResponseXML.="</Details>";
	echo $ResponseXML;	
}

//check orderNo availability in the orders table 
else if(strcmp($RequestType,"IsExistingOrderNo")==0)
{
	$ResponseXML="";
	$orderNo=$_GET["orderNo"];
	$ResponseXML.="<ExistStyle>";
	$ResponseXML.="<Style><![CDATA[" .isOrderNoavailability($orderNo). "]]></Style>\n";
	$ResponseXML.="</ExistStyle>";
	echo $ResponseXML;
}
else if(strcmp($RequestType,"IsExistingOrderNoInOrderQuiry")==0)
{
	$ResponseXML="";
	$orderNo=$_GET["orderNo"];
	$styleId= $_GET["styleId"];
	$ResponseXML.="<ExistStyle>";
	$ResponseXML.="<Style><![CDATA[" .IsExistingOrderNoInOrderQuiry($orderNo,$styleId). "]]></Style>\n";
	$ResponseXML.="</ExistStyle>";
	echo $ResponseXML;
}

else if($RequestType=="GetStyleNo")
{
	//$scNo		= $_GET["scNo"];
	$orderNo    = $_GET["orderNo"];
	$ResponseXML 	= "<XMLGetSCNo>\n";
	
	$sql="SELECT
O.intStyleId,
O.strOrderNo,
specification.intSRNO,
O.strStyle
FROM
orders AS O
Inner Join specification ON O.intStyleId = specification.intStyleId
WHERE
O.intStatus =  10 
 ";
	/*if($scNo!="")
		$sql .="AND
specification.intStyleId =  '$scNo'";*/
	if($orderNo!="")
		$sql .="AND
specification.intStyleId =  '$orderNo'";
				
	$sql .= "order by O.strOrderNo";
	//echo $sql;
	$result=$db->RunQuery($sql);
		//$ResponseXML .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["strStyle"].">".$row["strStyle"]."</option>";
	}
	$ResponseXML.="</XMLGetSCNo>";
	echo $ResponseXML;;
}
else if($RequestType=="GetStyleNo1")
{
	//$scNo		= $_GET["scNo"];
	$scNo    = $_GET["scNo"];
	$ResponseXML 	= "<XMLGetSCNo1>\n";
	
	$sql="SELECT
O.intStyleId,
O.strOrderNo,
specification.intSRNO,
O.strStyle
FROM
orders AS O
Inner Join specification ON O.intStyleId = specification.intStyleId
WHERE
O.intStatus =  11 
 ";
	/*if($scNo!="")
		$sql .="AND
specification.intStyleId =  '$scNo'";*/
	if($scNo!="")
		$sql .="AND
specification.intStyleId =  '$scNo'";
				
	$sql .= "order by O.strOrderNo";
	//echo $sql;
	$result=$db->RunQuery($sql);
		//$ResponseXML .= "<option value="."".">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=".$row["strStyle"].">".$row["strStyle"]."</option>";
	}
	$ResponseXML .= "<OrderNos><![CDATA[" . $ResponseXML . "]]></OrderNos>\n";
	$ResponseXML.="</XMLGetSCNo1>";
	echo $ResponseXML;;
}
// ========================================
// Add On - 11/03/2015
// Add By - Nalin Jayakody
// Adding - Get if buyer po raised for given style and buyer po
// ==========================================
else if($RequestType=="GetSupPo"){
	
	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	
	$ResponseXML	= "";
	$ResponseXML 	= "<SupplierPOExist>";
	
	$sql = " SELECT purchaseorderdetails.intPoNo FROM purchaseorderdetails ".
	       " WHERE  purchaseorderdetails.intStyleId =  '$styleId' AND purchaseorderdetails.strBuyerPONO =  '$buyerpo'";
		   
	$result = $db->RunQuery($sql);
	
	while($rows = mysql_fetch_array($result)){
		$poNo = $rows["intPoNo"];
	}
	
	if(empty($poNo))
		$ResponseXML .= "<POExist><![CDATA[false]]></POExist>\n";
	else
		$ResponseXML .= "<POExist><![CDATA[true]]></POExist>\n";	
	
	/*if(mysql_num_rows($result)>0)	   
		$ResponseXML .= "<POExist><![CDATA[true]]></POExist>\n";
	else
		$ResponseXML .= "<POExist><![CDATA[false]]></POExist>\n";*/
		
		
	$ResponseXML 	.= "</SupplierPOExist>";
	echo $ResponseXML;
}
//======================================================================
else if($RequestType=="UpdateMR"){
	
	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];
	
	$sqlupdateMR = " UPDATE materialratio SET strBuyerPONO = '$buyerpo' WHERE intStyleId = '$styleId' AND strBuyerPONO = '$prvbuyerPO'";
	$res = $db->executeQuery($sqlupdateMR);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";
		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML; 
}
//======================================================================
//======================================================================
else if($RequestType=="UpdatePO"){
	
	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];
	
	$sqlupdatePO = " UPDATE purchaseorderdetails SET strBuyerPONO = '$buyerpo' WHERE intStyleId = '$styleId' AND strBuyerPONO = '$prvbuyerPO'";
	$res = $db->executeQuery($sqlupdatePO);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";
		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML; 
}
//======================================================================

else if($RequestType=="UpdateGRN"){
	
	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];
	
	$sqlupdateGRN = " UPDATE grndetails SET strBuyerPONO = '$buyerpo' WHERE intStyleId = '$styleId' AND strBuyerPONO = '$prvbuyerPO'";
	$res = $db->executeQuery($sqlupdateGRN);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";
		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML; 
}
//======================================================================
else if($RequestType=="UpdateSTR"){
	
	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];
	
	$sqlupdateST = " UPDATE stocktransactions SET strBuyerPoNo = '$buyerpo' WHERE intStyleId = '$styleId' AND strBuyerPoNo = '$prvbuyerPO'";
	$res = $db->executeQuery($sqlupdateST);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";
		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML; 
}
//======================================================================
else if($RequestType=="UpdateSR"){ // Update style ratio

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateSR = " UPDATE styleratio SET strBuyerPONO = '$buyerpo' WHERE intStyleId = '$styleId' AND strBuyerPONO = '$prvbuyerPO'";

	$res = $db->executeQuery($sqlUpdateSR);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}

//======================================================================
else if($RequestType=="UpdateIS"){ // Update issue details table

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateSR = " UPDATE issuesdetails SET strBuyerPONO = '$buyerpo' WHERE intStyleId = '$styleId' AND strBuyerPONO = '$prvbuyerPO'";

	$res = $db->executeQuery($sqlUpdateSR);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
//=======================================================================

//======================================================================
else if($RequestType=="UpdateMAT"){ // Update material requestion details

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMAT = " UPDATE matrequisitiondetails SET strBuyerPONO = '$buyerpo' WHERE intStyleId = '$styleId' AND strBuyerPONO = '$prvbuyerPO'";

	$res = $db->executeQuery($sqlUpdateMAT);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
//=======================================================================

//======================================================================
else if($RequestType=="UpdateGP"){ // Update gatepass details

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMAT = " UPDATE gatepassdetails SET strBuyerPONO = '$buyerpo' WHERE intStyleId = '$styleId' AND strBuyerPONO = '$prvbuyerPO'";

	$res = $db->executeQuery($sqlUpdateMAT);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
//=======================================================================


//======================================================================
else if($RequestType=="UpdateTR"){ // Update Transfer Details in D2D

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMK = " UPDATE d2d_transfer_details SET bpo = '$buyerpo' WHERE scNumber = '$styleId' AND bpo = '$prvbuyerPO'";

	$res = $d2dConnectClass->RunQuery($sqlUpdateMK);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
//=======================================================================

//======================================================================
else if($RequestType=="UpdateMK"){ // Update Cut Marker details in D2D

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMK = " UPDATE d2d_cut_dtlmarker SET bpo = '$buyerpo' WHERE scNumber = '$styleId' AND bpo = '$prvbuyerPO'";

	$res = $d2dConnectClass->RunQuery($sqlUpdateMK);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
//=======================================================================

//======================================================================
else if($RequestType=="UpdateBS"){ // Update Bundle Sheet details in D2D

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMK = " UPDATE d2d_cut_budlesheet SET bpo = '$buyerpo' WHERE scNumber = '$styleId' AND bpo = '$prvbuyerPO'";

	$res = $d2dConnectClass->RunQuery($sqlUpdateMK);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;
}
//=======================================================================

//======================================================================
else if($RequestType=="UpdateLI"){ // Update Line In details in D2D

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMK = " UPDATE d2d_LineIn_Deatils SET bpo = '$buyerpo' WHERE scNumber = '$styleId' AND bpo = '$prvbuyerPO'";

	$res = $d2dConnectClass->RunQuery($sqlUpdateMK);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
//=======================================================================

//======================================================================
else if($RequestType=="UpdateLO"){ // Update Line Out details in D2D

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMK = " UPDATE d2d_LineOut_details SET bpo = '$buyerpo' WHERE scNumber = '$styleId' AND bpo = '$prvbuyerPO'";

	$res = $d2dConnectClass->RunQuery($sqlUpdateMK);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
//=======================================================================

//======================================================================
else if($RequestType=="UpdateAQ"){ // Update AQL details in D2D

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMK = " UPDATE d2d_AqlDetails SET bpo = '$buyerpo' WHERE scNumber = '$styleId' AND bpo = '$prvbuyerPO'";

	$res = $d2dConnectClass->RunQuery($sqlUpdateMK);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
//=======================================================================

//======================================================================
else if($RequestType=="UpdatePL"){ // Update Pack Local Header in D2D

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMK = " UPDATE d2d_Pack_Local_header SET bpo = '$buyerpo' WHERE scNumber = '$styleId' AND bpo = '$prvbuyerPO'";

	$res = $d2dConnectClass->RunQuery($sqlUpdateMK);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
//=======================================================================

//======================================================================
else if($RequestType=="UpdatePE"){ // Update Pack Export Header in D2D

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMK = " UPDATE d2d_Pack_Export_Header SET bpo = '$buyerpo' WHERE scNumber = '$styleId' AND bpo = '$prvbuyerPO'";

	$res = $d2dConnectClass->RunQuery($sqlUpdateMK);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
//=======================================================================

//======================================================================
else if($RequestType=="UpdatePW"){ // Update Pack Washing Details in D2D

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMK = " UPDATE d2d_pack_washing_details SET bpo = '$buyerpo' WHERE scNumber = '$styleId' AND bpo = '$prvbuyerPO'";

	$res = $d2dConnectClass->RunQuery($sqlUpdateMK);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
//=======================================================================

//======================================================================
else if($RequestType=="UpdateST"){ // Update Pack SC transfer from details in D2D

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMK = " UPDATE d2d_packing_sc_transfer_detail SET bpo = '$buyerpo' WHERE scNumber = '$styleId' AND bpo = '$prvbuyerPO'";

	$res = $d2dConnectClass->RunQuery($sqlUpdateMK);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
//=======================================================================

//======================================================================
else if($RequestType=="UpdateTT"){ // Update Pack SC transfer TO details in D2D

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMK = " UPDATE d2d_packing_sc_transfer_detail SET Tobpo = '$buyerpo' WHERE ToScNumber = '$styleId' AND Tobpo = '$prvbuyerPO'";

	$res = $d2dConnectClass->RunQuery($sqlUpdateMK);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
//=======================================================================

//======================================================================
else if($RequestType=="UpdateFG"){ // Update Pack SC transfer TO details in D2D

	$styleId 	= $_GET["styleID"];
	$buyerpo	= $_GET["buyerPO"];
	$prvbuyerPO	= $_GET["prvbuyerPO"];

	$sqlUpdateMK = " UPDATE d2d_fineshedgood_point SET bpo = '$buyerpo' WHERE scNumber = '$styleId' AND bpo = '$prvbuyerPO'";

	$res = $d2dConnectClass->RunQuery($sqlUpdateMK);
	
	$ResponseXML="";
	$ResponseXML.= "<Results>";		
	
	
	if($res){
		$ResponseXML.="<Value><![CDATA[1]]></Value>\n";
	}else{
		$ResponseXML.="<Value><![CDATA[0]]></Value>\n";
	}
	
	$ResponseXML.="</Results>";
	echo $ResponseXML;

}
else if($RequestType=="SetEMB"){
    
    $styleId = $_GET["styleid"];
    $iPrint  = $_GET["print"];
    $iEMB    = $_GET["emb"];
    $iHS     = $_GET["hs"];
    $iHW     = $_GET["hw"];
    $iOther  = $_GET["iother"];
    $iNA     = $_GET["na"];
    $strOtherType = $_GET["other"];
    
    #========================================
    # Adding - New embelishment types to the list
    # Add By - Nalin Jayakody
    # Add On - 04/30/2017
    # =======================================
    $iCPL       = $_GET["cpl"];
    $iPreSew    = $_GET["ps"];
    $iPressing  = $_GET["pressing"];
    $iBNP       = $_GET["bnp"];
    $iHTP       = $_GET["htp"];
    $iSeqAtt    = $_GET["sa"];
    $iDA        = $_GET["da"];
    $iSmoking   = $_GET["smoking"];
    $iPleating  = $_GET["pleating"];
    $iWash      = $_GET["wash"]; 
    # =======================================
    
    
    
    //$sql = " UPDATE orders SET intPrint = '$iPrint', intEMB = '$iEMB', intHeatSeal = '$iHS', intHW = '$iHW', intOther = '$iOther', strOther = '$strOtherType', intNA = '$iNA' WHERE intStyleId = '$styleId'   ";
    $sql = " UPDATE orders SET intPrint = '$iPrint', intEMB = '$iEMB', intHeatSeal = '$iHS', intHW = '$iHW', intOther = '$iOther', strOther = '$strOtherType', intNA = '$iNA', intCPL = '$iCPL', intPreSew = '$iPreSew', intPressing = '$iPressing', intBNP = '$iBNP', intHTP = '$iHTP', intSA = '$iSeqAtt', intDA = '$iDA', intSmoking = '$iSmoking', intPleating = '$iPleating', intWash = '$iWash' WHERE intStyleId = '$styleId'   ";
    //echo $sql;
    $res = $db->RunQuery($sql);
    
    

}

//=======================================================================

//=======================================================================


//-----------Hemanthi(2010/09/10)-----------------------------------------------------------------------------------
function CheckExistStyle($orderNo,$styleNo)
{
	global $db;
	//$sql= "select * from orders WHERE strOrderNo = '".$orderNo."' and strStyle = '$styleNo'"; 
	$sql= "select * from orders WHERE strOrderNo = '".$orderNo."' "; 
	return $db->RunQuery($sql);
}
//--------------------end-------------------------------------------



function getStyleStatus($styleNo)
{
	global $db;
	  $sql = "SELECT intStatus FROM orders where intStyleId = '".$styleNo."'"; 
	  $result= $db->RunQuery($sql);
	  $row = mysql_fetch_array($result);
	  $styleStatus = $row["intStatus"];
	  
	  return $styleStatus;
}

function isOrderNoavailability($orderNo)
{
	global $db;
	$OrderCount=0;
	$sql="SELECT COUNT(strOrderNo)AS OrderC FROM orders where strOrderNo='".$orderNo."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$OrderCount=$row["OrderC"];
	}
	if($OrderCount>0)
	{
		return "True";		
	}
	else
	{
	return "False";
	}
}

function getUserName()
{
	global $db;
	$userID = $_SESSION["UserID"];
	
	$sql = "select Name from useraccounts where intUserID='$userID'"; 
	  $result= $db->RunQuery($sql);
	  $row = mysql_fetch_array($result);
	  $Uname = $row["Name"];
	  
	  return $Uname;
}

function getDeliveryQty($styleID,$dtmDate)
{
	global $db;
	
	$sql = "select dblQty from history_deliveryschedule 
		where intStyleId='$styleID' and dtDateofDelivery='$dtmDate' "; 
	  $result= $db->RunQuery($sql);
	  $row = mysql_fetch_array($result);
	  $dblQty = $row["dblQty"];
	  
	  return $dblQty;
}

function IsExistingOrderNoInOrderQuiry($orderNo,$styleId)
{
	global $db;
	$sql="SELECT intStyleId FROM orders where strOrderNo='".$orderNo."' and intStyleId<>'$styleId';";
	$result=$db->RunQuery($sql);
	$output = 'False';
	while($row = mysql_fetch_array($result))
	{
		$output = 'True';
	}
	 
	 return $output;
}

function GetBaseCurrency()
{
global $db;
$sql="select intBaseCurrency from systemconfiguration";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
return $row["intBaseCurrency"];
}

function GetExchangeRate($currencyId)
{
global $db;
	$sql ="select rate from exchangerate where currencyID=$currencyId and intStatus=1";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["rate"];
}

function checkInvoiceCostingConfirmAvailability($StyleID)
{
	global $db;
	
	$sql = " select * from invoicecostingheader where intStyleId='$StyleID' and intStatus=1 ";
	
	return $db->CheckRecordAvailability($sql);
}

function CreateCompanyOrderNo()
{
global $db;
$month = date("m");
$no = 1;
	$sql="select COALESCE(Max(intCompanyOrderNo),0)as no from orders where month(dtmOrderDate)='$month'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$no =  $row["no"] + 1;
	}
	return $no;
}


?>