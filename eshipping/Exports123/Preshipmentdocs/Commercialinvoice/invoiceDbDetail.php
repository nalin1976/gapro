<?php 
session_start();
include("../../../Connector.php");
header('Content-Type: text/xml'); 	
$request=$_GET["REQUEST"];


if ($request=='getDetailData')
{	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$invoiceno	=$_GET["invoiceno"];
	$isd_no		=$_GET["isd_no"];
	
	$sqlDetail="SELECT DISTINCT	
	cdn_detail.strInvoiceNo,
	cdn_detail.strPLNO,
	cdn_detail.strColor, 
	cdn_detail.strStyleID, 
	cdn_detail.intItemNo, 
	cdn_detail.strBuyerPONo, 
	cdn_detail.strDescOfGoods, 
	cdn_detail.dblQuantity, 
	cdn_detail.strUnitID,
	cdn_detail.dblUnitPrice, 
	cdn_detail.strPriceUnitID, 
	cdn_detail.dblCMP, 
	cdn_detail.dblAmount, 
	cdn_detail.strHSCode, 
	cdn_detail.dblGrossMass, 
	cdn_detail.dblNetMass, 
	cdn_detail.strProcedureCode, 
	cdn_detail.strCatNo, 
	cdn_detail.intNoOfCTns, 
	cdn_detail.strKind,
	cdn_detail.dblUMOnQty1, 
	cdn_detail.UMOQtyUnit1, 
	cdn_detail.dblUMOnQty2, 
	cdn_detail.UMOQtyUnit2, 
	cdn_detail.dblUMOnQty3, 
	cdn_detail.strISDno,
	cdn_detail.strFabrication
	FROM 
	cdn_detail 
	INNER JOIN invoicedetail ON cdn_detail.strInvoiceNo=invoicedetail.strInvoiceNo
	WHERE cdn_detail.strInvoiceNo='$invoiceno' ";
	
	
	
	if($isd_no)
	$sqlDetail.=" and strISDno='$isd_no'";
	
	$sqlDetail.=" ORDER BY intItemNo";
	//die($sqlDetail);
	
	$detailResult=$db->RunQuery($sqlDetail);
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	while($detailrow=mysql_fetch_array($detailResult))
	{		//die("pass");
			$XMLString .= "<InvoiceNo><![CDATA[" . $detailrow["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$XMLString .= "<Color><![CDATA[" . $detailrow["strColor"]  . "]]></Color>\n";
			$XMLString .= "<StyleID><![CDATA[" . $detailrow["strStyleID"]  . "]]></StyleID>\n";
			$XMLString .= "<ItemNo><![CDATA[" . $detailrow["intItemNo"]  . "]]></ItemNo>\n";
			$XMLString .= "<BuyerPONo><![CDATA[" . $detailrow["strBuyerPONo"]  . "]]></BuyerPONo>\n";
			$XMLString .= "<DescOfGoods><![CDATA[" . $detailrow["strDescOfGoods"]  . "]]></DescOfGoods>\n";
			$XMLString .= "<Quantity><![CDATA[" . $detailrow["dblQuantity"]  . "]]></Quantity>\n";
			$XMLString .= "<UnitID><![CDATA[" . $detailrow["strUnitID"]  . "]]></UnitID>\n";
			$XMLString .= "<UnitPrice><![CDATA[" . $detailrow["dblUnitPrice"]  . "]]></UnitPrice>\n";
			$XMLString .= "<lCMP><![CDATA[" . $detailrow["dblCMP"]  . "]]></lCMP>\n";
			$XMLString .= "<Amount><![CDATA[" . $detailrow["dblAmount"]  . "]]></Amount>\n";
			$XMLString .= "<HSCode><![CDATA[" . $detailrow["strHSCode"]  . "]]></HSCode>\n";
			$XMLString .= "<GrossMass><![CDATA[" . $detailrow["dblGrossMass"]  . "]]></GrossMass>\n";
			$XMLString .= "<NetMass ><![CDATA[" . $detailrow["dblNetMass"]  . "]]></NetMass >\n";
			$XMLString .= "<PriceUnitID><![CDATA[" . $detailrow["strPriceUnitID"]  . "]]></PriceUnitID>\n";
			$XMLString .= "<NoOfCTns><![CDATA[" . $detailrow["intNoOfCTns"]  . "]]></NoOfCTns>\n";
			$XMLString .= "<Category><![CDATA[" . $detailrow["strCatNo"]  . "]]></Category>\n";
			$XMLString .= "<ProcedureCode><![CDATA[" . $detailrow["strProcedureCode"]  . "]]></ProcedureCode>\n";
			$XMLString .= "<dblUMOnQty1><![CDATA[" . $detailrow["dblUMOnQty1"]  . "]]></dblUMOnQty1>\n";
			$XMLString .= "<dblUMOnQty2><![CDATA[" . $detailrow["dblUMOnQty2"]  . "]]></dblUMOnQty2>\n";
			$XMLString .= "<dblUMOnQty3><![CDATA[" . $detailrow["dblUMOnQty3"]  . "]]></dblUMOnQty3>\n";
			$XMLString .= "<UMOQtyUnit1><![CDATA[" . $detailrow["UMOQtyUnit1"]  . "]]></UMOQtyUnit1>\n";
			$XMLString .= "<UMOQtyUnit2><![CDATA[" . $detailrow["UMOQtyUnit2"]  . "]]></UMOQtyUnit2>\n";
			$XMLString .= "<UMOQtyUnit3><![CDATA[" . $detailrow["UMOQtyUnit3"]  . "]]></UMOQtyUnit3>\n";
			$XMLString .= "<ISD><![CDATA[" . $detailrow["strISDno"]  . "]]></ISD>\n";
			$XMLString .= "<Fabric><![CDATA[" . $detailrow["strFabrication"]  . "]]></Fabric>\n";
			$XMLString .= "<PLno><![CDATA[" . $detailrow["strPLNO"]  . "]]></PLno>\n";
			$XMLString .= "<Dc><![CDATA[" . $detailrow["strDc"]  . "]]></Dc>\n";
			$XMLString .= "<netnet><![CDATA[" . $detailrow["dblNetNet"]  . "]]></netnet>\n";
			$XMLString .= "<SD><![CDATA[" . $detailrow["strSD"]  . "]]></SD>\n";
			$XMLString .= "<consttype><![CDATA[" . $detailrow["strConstType"]  . "]]></consttype>\n";
			$XMLString .= "<specdetail><![CDATA[" . $detailrow["strSpecDesc"]  . "]]></specdetail>\n";
			
				
	}
	
	$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='editData')
{
	$invoiceno=$_GET["invoiceno"];
	$bpo=$_GET["bpo"];
	$cm=$_GET["cm"];
	$ctns=$_GET["ctns"];
	$dsc=$_GET["dsc"];
	$gross=$_GET["gross"];	
	$hs=$_GET["hs"];	
	$net=$_GET["net"];	
	$style=$_GET["style"];	
	$unit=$_GET["unit"];	
	$unitprice=$_GET["unitprice"];	
	$unitqty=$_GET["unitqty"];	
	$value=$_GET["value"];
	$pos=$_GET["pos"];	
	$wut=$_GET["wut"];
	$qty=$_GET["qty"];
	$category=$_GET["category"];
	$procedurecode=$_GET["procedurecode"];
	$umoqty1=$_GET["umoqty1"];
	$umoqty2=$_GET["umoqty2"];
	$umoqty3=$_GET["umoqty3"];
	$umoUnit1=$_GET["umoUnit1"];
	$umoUnit2=$_GET["umoUnit2"];
	$umoUnit3=$_GET["umoUnit3"];
	$ISDNo		=$_GET["ISDNo"];
	$sd			=$_GET["sd"];
	$dc			=$_GET["dc"];
	if ($gross=="")
		$gross=0;
	if ($net=="")
		$net=0;
	if ($ctns=="")
		$ctns=0;
	if ($umoqty1=="")
		$umoqty1=0;
	if ($umoqty2=="")
		$umoqty2=0;
	if ($umoqty3=="")
		$umoqty3=0;
	if ($cm=="")
		$cm=0;
	
	
	if ($wut=='update')
	{
	$sqlupdate="UPDATE invoicedetail 
	SET
	strInvoiceNo = '$invoiceno' , 
	strStyleID = '$style' , 
	intItemNo = '$pos' , 
	strBuyerPONo = '$bpo' , 
	strDescOfGoods = '$dsc' , 
	dblQuantity = '$qty' , 
	strUnitID = '$unitqty' , 
	dblUnitPrice = '$unitprice' , 
	strPriceUnitID = '$unit' , 
	dblCMP = '$cm' , 
	dblAmount = '$value' , 
	strHSCode = '$hs' , 
	dblGrossMass = '$gross' , 
	dblNetMass = '$net' , 
	strProcedureCode = '$procedurecode' , 
	strCatNo = '$category' , 
	intNoOfCTns = '$ctns' , 
	strKind = '1',
	dblUMOnQty1 = '$umoqty1' , 
	UMOQtyUnit1 = '$umoUnit1' , 
	dblUMOnQty2 = '$umoqty2' , 
	UMOQtyUnit2 = '$umoUnit2' , 
	dblUMOnQty3 = '$umoqty3' , 
	UMOQtyUnit3 = '$umoUnit3',
	strISDno = '$ISDNo'
	WHERE
	strInvoiceNo = '$invoiceno' AND 
	intItemNo = '$pos'";
	
	$updateresult=$db->RunQuery($sqlupdate);
	
	if($updateresult){
	echo "Successfully updated";
	$state=1;
	}
	else 
	echo $sqlupdate; 
	//echo "Sorry,Operation Failed!";	
	
	
	}
	
	if ($wut=='insert')
	{
	 $sqlinsert="INSERT INTO invoicedetail 
	(strInvoiceNo, 
	strStyleID, 
	intItemNo, 
	strBuyerPONo, 
	strDescOfGoods, 
	dblQuantity, 
	strUnitID, 
	dblUnitPrice, 
	strPriceUnitID, 
	dblCMP, 
	dblAmount, 
	strHSCode, 
	dblGrossMass, 
	dblNetMass, 
	strProcedureCode, 
	strCatNo, 
	intNoOfCTns, 
	strKind,
	dblUMOnQty1, 
	UMOQtyUnit1, 
	dblUMOnQty2, 
	UMOQtyUnit2, 
	dblUMOnQty3, 
	strISDno
	)
	VALUES
	('$invoiceno', 
	'$style', 
	'$pos', 
	'$bpo', 
	'$dsc', 
	'$qty', 
	'$unitqty', 
	'$unitprice', 
	'$unit', 
	'$cm', 
	'$value', 
	'$hs', 
	'$gross', 
	'$net', 
	'$procedurecode', 
	'$category', 
	'$ctns', 
	'1',
	'$umoqty1',
	'$umoUnit1',
	'$umoqty2',
	'$umoUnit2',
	'$umoqty3',
	'$ISDNo'
	);";
	 $insertresultsql=$db->RunQuery($sqlinsert);
	 if ($insertresultsql)
	 {
	 echo "Successfully saved";	
	 $state=1;
	 }
	 else 
	 	echo $sqlinsert; 
	  //echo "Sorry,Operation Failed!";	
	 		
	}
	
	if($state==1)
	{
		$strdelfirst="DELETE FROM excusdectax 
					WHERE
					strInvoiceNo = '$invoiceno' AND intPosition='$pos';";
		$resultstrdelfirst=$db->RunQuery($strdelfirst);
		$extaxstr="SELECT
 		strCommodityCode, 
		strTaxCode, 
		intPosition, 
		dblPercentage, 
		strRemarks, 
		intMP	 
		FROM 
		excommoditycodes 
		WHERE
		strCommodityCode='$hs' and strTaxCode!=''";
		$taxpos=1;
		$extaxresult=$db->RunQuery($extaxstr);
		while($taxresultrow=mysql_fetch_array($extaxresult))
		{
			$taxcodeof=$taxresultrow["strTaxCode"];
			$Percentage=$taxresultrow["dblPercentage"];
			/*$taxcodeof=$taxresultrow["strTaxCode"];
			$taxcodeof=$taxresultrow["strTaxCode"];
			$taxcodeof=$taxresultrow["strTaxCode"];*/
			//$amount=$umoqty1*50/100;
			$amount=$umoqty1*$taxresultrow["dblPercentage"];
			$strtaxing="INSERT INTO excusdectax 
						(strInvoiceNo, 
						strHScode, 
						strTaxCode, 
						intPosition, 
						dblTaxBase, 
						dblRate, 
						dblAmount, 
						intMP, 
						RecordType)
						VALUES
						('$invoiceno', 
						'$hs', 
						'$taxcodeof', 
						'$pos', 
						'$umoqty1', 
						'$Percentage', 
						'$amount', 
						'1', 
						'0');";
			$strtaxingresult=$db->RunQuery($strtaxing);
			//die($strtaxing ."  ".$pos);
		}
	//die($TaxCode);
	
	}	
		
}
if ($request=='deleteData')
{	
	$invoiceno=$_GET["invoiceno"];
	$item=$_GET["item"];
	
	$sqlDelete="DELETE FROM invoicedetail WHERE
	strInvoiceNo = '$invoiceno' AND 
	intItemNo = '$item' ;";
	$resultDelete=$db->RunQuery($sqlDelete);
	
	if ($resultDelete)
	{	
		echo "Sucessfully deleted";
		$strdelfirst="DELETE FROM excusdectax 
					WHERE
					strInvoiceNo = '$invoiceno' AND intPosition='$item';";
		$resultstrdelfirst=$db->RunQuery($strdelfirst);
		
	}

}

if ($request=='save_po_wise_ci')
{	
	$BL				=$_GET["BL"];
	$BTM			=$_GET["BTM"];
	$CTNNos			=$_GET["CTNNos"];
	$CTNSize		=$_GET["CTNSize"];
	$CTNType		=$_GET["CTNType"];
	$Cat			=$_GET["Cat"];
	$Container		=$_GET["Container"];
	$DestCh			=$_GET["DestCh"];
	$FinishStd		=$_GET["FinishStd"];
	$Freight		=$_GET["Freight"];
	$other			=$_GET["other"];	
	$totDestCh		=$_GET["totDestCh"];
	$totFreight		=$_GET["totFreight"];
	$totInsurance	=$_GET["totInsurance"];
	$totother		=$_GET["totother"];	
	$Gender			=$_GET["Gender"];
	$GmntType		=$_GET["GmntType"];
	$Insurance		=$_GET["Insurance"];
	$PackStd		=$_GET["PackStd"];
	$Vat			=$_GET["Vat"];
	$brand			=$_GET["brand"];
	$InvoiceNo		=$_GET["InvoiceNo"];
	$Quality		=$_GET["Quality"];
	$SealNo			=$_GET["SealNo"];
	$HAWB			=$_GET["HAWB"];
	$MAWB			=$_GET["MAWB"];
	$FreightPC		=$_GET["FreightPC"];
	$PS				=$_GET["PS"];
	$ShipmentRef	=$_GET["ShipmentRef"];
	$discount	=$_GET["discount"];
	$discountType=$_GET['discountType'];
	$contype	=$_GET["contype"];
	$webtoolid	=$_GET["webtoolid"];
	$samplecode	=$_GET["samplecode"];
	
	$FCR				=$_GET["FCR"];
	$ExFile				=$_GET["ExFile"];
	$DocDue				=$_GET["DocDue"];
	$DocSub				=$_GET["DocSub"];
	$PayDue				=$_GET["PayDue"];
	$PaySub				=$_GET["PaySub"];
	$ExportNo			=$_GET["ExportNo"];
	$SGSIONO			=$_GET["SGSIONO"];

	$str_check="select 	strInvoiceNo from finalinvoice where strInvoiceNo='$InvoiceNo'";
	
	$result_check=$db->RunQuery($str_check);
	$no=mysql_num_rows($result_check);
	
	if($no<1)
	{
	$str="insert into finalinvoice 
							(strInvoiceNo, 
							strBrand, 
							strQuality, 
							strFinishedStd, 
							strPackStd, 
							strGender, 
							strGarmentType, 
							strBTM, 
							strCat, 
							strCTNSType, 
							strCTNnos, 
							strCTNSize, 
							dblOther, 
							dblFreight, 
							dblInsurance, 
							dblDestCharge, 
							strBL, 
							strVAT, 
							strContainer, 
							strSealNo, 
							strHAWB, 
							strMAWB, 
							strFreightPC, 
							strPSno, 
							strShipmentRef, 
							dblDiscount, 
							dblTotFreight, 
							dblTotInsuranse, 
							dblTotDest, 
							dblTotOther,
							dblConTypeId, 
							dblWebToolId, 
							dblSampleQuote, 
							dtmDocumentDueDate, 
							dtmDocumentSubDate, 
							dtmPaymentDueDate, 
							dtmPaymentSubDate, 
							strFCR, 
							strFileNo,
							strExportNo, 
							strSGSIONO,
							strDiscountType
							)
							values
							('$InvoiceNo', 
							'$brand', 
							'$Quality', 
							'$FinishStd', 
							'$PackStd', 
							'$Gender', 
							'$GmntType', 
							'$BTM', 
							'$Cat', 
							'$CTNType', 
							'$CTNNos', 
							'$CTNSize', 
							'$other', 
							'$Freight', 
							'$Insurance', 
							'$DestCh', 
							'$BL', 
							'$Vat', 
							'$Container', 
							'$SealNo', 
							'$HAWB', 
							'$MAWB', 
							'$FreightPC', 
							'$PS', 
							'$ShipmentRef', 
							'$discount', 
							'$totFreight', 
							'$totInsurance', 
							'$totDestCh', 
							'$totother',
							'$contype',
							'$webtoolid',
							'$samplecode', 
							'$DocDue', 
							'$DocSub', 
							'$PayDue', 
							'$PaySub', 
							'$FCR', 
							'$ExFile', 
							'$ExportNo', 
							'$SGSIONO',
							'$discountType'
							);";
	}
	else
	{
		$str="update finalinvoice 
						set
						strBrand = '$brand' , 
						strQuality = '$Quality' , 
						strFinishedStd = '$FinishStd' , 
						strPackStd = '$PackStd' , 
						strGender = '$Gender' , 
						strGarmentType = '$GmntType', 
						strBTM = '$BTM', 
						strCat = '$Cat', 
						strCTNSType = '$CTNType', 
						strCTNnos = '$CTNNos', 
						strCTNSize = '$CTNSize', 
						dblOther = '$other', 
						dblFreight = '$Freight', 
						dblInsurance = '$Insurance', 
						dblDestCharge = '$DestCh', 
						strBL = '$BL', 
						strVAT = '$Vat', 
						strContainer = '$Container', 
						strSealNo = '$SealNo', 
						strHAWB = '$HAWB',  
						strMAWB = '$MAWB', 
						strFreightPC = '$FreightPC', 
						strPSno = '$PS', 
						strShipmentRef = '$ShipmentRef', 
						dblDiscount = '$discount' , 
						dblTotFreight = '$totFreight', 
						dblTotInsuranse = '$totInsurance', 
						dblTotDest = '$totDestCh',
						dblTotOther = '$totother',
						dblConTypeId = '$contype',
						dblWebToolId = '$webtoolid',
						dblSampleQuote = '$samplecode', 
						dtmDocumentDueDate = '$DocDue' , 
						dtmDocumentSubDate = '$DocSub' , 
						dtmPaymentDueDate = '$PayDue' , 
						dtmPaymentSubDate = '$PaySub' , 
						strFCR = '$FCR' , 
						strFileNo = '$ExFile', 
						strExportNo = '$ExportNo',
						strSGSIONO = '$SGSIONO',
						strDiscountType='$discountType'
						
						where
						strInvoiceNo = '$InvoiceNo' ;	";
	}
	$result=$db->RunQuery($str);
	
	if ($result)
	{	
		echo "saved";
				
	}

}

if ($request=='retrv_po_wise_ci')
{	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$InvoiceNo=$_GET["InvoiceNo"];
	$str="select 	*				 
					from 
					finalinvoice 
					where
					strInvoiceNo='$InvoiceNo'";
	$result=$db->RunQuery($str);
	//die($str);	
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	while($row=mysql_fetch_array($result))
	{		
			$XMLString .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$XMLString .= "<Brand><![CDATA[" . $row["strBrand"]  . "]]></Brand>\n";
			$XMLString .= "<Quality><![CDATA[" . $row["strQuality"]  . "]]></Quality>\n";
			$XMLString .= "<FinishedStd><![CDATA[" . $row["strFinishedStd"]  . "]]></FinishedStd>\n";
			$XMLString .= "<PackStd><![CDATA[" . $row["strPackStd"]  . "]]></PackStd>\n";
			$XMLString .= "<Gender><![CDATA[" . $row["strGender"]  . "]]></Gender>\n";
			$XMLString .= "<GarmentType><![CDATA[" . $row["strGarmentType"]  . "]]></GarmentType>\n";
			$XMLString .= "<BTM><![CDATA[" . $row["strBTM"]  . "]]></BTM>\n";
			$XMLString .= "<Cat><![CDATA[" . $row["strCat"]  . "]]></Cat>\n";	
			$XMLString .= "<CTNSType><![CDATA[" . $row["strCTNSType"]  . "]]></CTNSType>\n";	
			$XMLString .= "<CTNnos><![CDATA[" . $row["strCTNnos"]  . "]]></CTNnos>\n";
			$XMLString .= "<CTNSize><![CDATA[" . $row["strCTNSize"]  . "]]></CTNSize>\n";
			$XMLString .= "<other><![CDATA[" . $row["dblOther"]  . "]]></other>\n";
			$XMLString .= "<Freight><![CDATA[" . $row["dblFreight"]  . "]]></Freight>\n";
			$XMLString .= "<Insurance><![CDATA[" . $row["dblInsurance"]  . "]]></Insurance>\n";
			$XMLString .= "<DestCharge><![CDATA[" . $row["dblDestCharge"]  . "]]></DestCharge>\n";
			
			$XMLString .= "<TotFreight><![CDATA[" . $row["dblTotFreight"]  . "]]></TotFreight>\n";
			$XMLString .= "<TotInsuranse><![CDATA[" . $row["dblTotInsuranse"]  . "]]></TotInsuranse>\n";
			$XMLString .= "<TotDest><![CDATA[" . $row["dblTotDest"]  . "]]></TotDest>\n";
			$XMLString .= "<TotOther><![CDATA[" . $row["dblTotOther"]  . "]]></TotOther>\n";
			
			$XMLString .= "<BL><![CDATA[" . $row["strBL"]  . "]]></BL>\n";		
			$XMLString .= "<VAT><![CDATA[" . $row["strVAT"]  . "]]></VAT>\n";		
			$XMLString .= "<Container><![CDATA[" . $row["strContainer"]  . "]]></Container>\n";
			
			$XMLString .= "<SealNo><![CDATA[" . $row["strSealNo"]  . "]]></SealNo>\n";	
			$XMLString .= "<FreightPC><![CDATA[" . $row["strFreightPC"]  . "]]></FreightPC>\n";	
			$XMLString .= "<HAWB><![CDATA[" . $row["strHAWB"]  . "]]></HAWB>\n";	
			$XMLString .= "<MAWB><![CDATA[" . $row["strMAWB"]  . "]]></MAWB>\n";	
			$XMLString .= "<PSno><![CDATA[" . $row["strPSno"]  . "]]></PSno>\n";
			$XMLString .= "<ShipmentRef><![CDATA[" . $row["strShipmentRef"]  . "]]></ShipmentRef>\n";
			
			$XMLString .= "<Discount><![CDATA[" . $row["dblDiscount"]  . "]]></Discount>\n";
			$XMLString .= "<ConType><![CDATA[" . $row["dblConTypeId"]  . "]]></ConType>\n";
			$XMLString .= "<WebToolId><![CDATA[" . $row["dblWebToolId"]  . "]]></WebToolId>\n";
			$XMLString .= "<SampleCode><![CDATA[" . $row["dblSampleQuote"]  . "]]></SampleCode>\n";
			
			$XMLString .= "<Discount><![CDATA[" . $row["dblDiscount"]  . "]]></Discount>\n";
			$XMLString .= "<DiscountType><![CDATA[" . $row["strDiscountType"]  . "]]></DiscountType>\n";
			$XMLString .= "<ConType><![CDATA[" . $row["dblConTypeId"]  . "]]></ConType>\n";
			$XMLString .= "<Discount><![CDATA[" . $row["dblDiscount"]  . "]]></Discount>\n";
			$XMLString .= "<ConType><![CDATA[" . $row["dblConTypeId"]  . "]]></ConType>\n";
			$XMLString .= "<Discount><![CDATA[" . $row["dblDiscount"]  . "]]></Discount>\n";
			$XMLString .= "<ConType><![CDATA[" . $row["dblConTypeId"]  . "]]></ConType>\n";
			
			$XMLString .= "<DocumentDueDate><![CDATA[" . $row["dtmDocumentDueDate"]  . "]]></DocumentDueDate>\n";
			$XMLString .= "<DocumentSubDate><![CDATA[" . $row["dtmDocumentSubDate"]  . "]]></DocumentSubDate>\n";
			$XMLString .= "<PaymentDueDate><![CDATA[" . $row["dtmPaymentDueDate"]  . "]]></PaymentDueDate>\n";
			$XMLString .= "<PaymentSubDate><![CDATA[" . $row["dtmPaymentSubDate"]  . "]]></PaymentSubDate>\n";
			$XMLString .= "<FCR><![CDATA[" . $row["strFCR"]  . "]]></FCR>\n";
			$XMLString .= "<FileNo><![CDATA[" . $row["strFileNo"]  . "]]></FileNo>\n";
			$XMLString .= "<ExportNo><![CDATA[" . $row["strExportNo"]  . "]]></ExportNo>\n";
			$XMLString .= "<SGSIONO><![CDATA[" . $row["strSGSIONO"]  . "]]></SGSIONO>\n";
							
	}
	
	$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;

}

if ($request=='delete_po_wise_ci')
{	
	$InvoiceNo=$_GET["InvoiceNo"];
	$str="delete from commercialinvoice 
	where
	strInvoiceNo = '$InvoiceNo'";
	$result=$db->RunQuery($str);
	echo($str);
}
/*
if($request=='rowupdater')
{

$invoiceno=$_GET["invoiceno"];
	$item=$_GET["item"];
	$newitem=$_GET["new"];



$sqlRowUp="
UPDATE invoicedetail 
	SET
	
	intItemNo = '$newitem'  
	
	WHERE
	strInvoiceNo = '$invoiceno' AND 
	intItemNo = '$item' ";
	
	$resultRowUp=$db->RunQuery($sqlRowUp);
	
	if ($resultRowUp)		
		echo "Rowupdatd";


}
*/
if ($request=='load_isd')
{	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$invoiceno=$_GET["invoiceno"];
	$sql="select distinct strISDno from invoicedetail where strInvoiceNo='$invoiceno'";
	
	$XMLString= "<Data>";
	$XMLString .= "<DeliveryData>";	
	
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{
		
		$XMLString .= "<isd><![CDATA[" . $row["strISDno"]  . "]]></isd>\n";
		
	
	}

$XMLString .= "</DeliveryData>";
	$XMLString .= "</Data>";
	echo $XMLString;

}

if ($request=='save_final_inv')
{	
	$ctns			=$_GET["ctns"];
	$desc			=$_GET["desc"];
	$gross			=$_GET["gross"];
	$hs				=$_GET["hs"];
	$invoiceno		=$_GET["invoiceno"];
	$isd			=$_GET["isd"];
	$net			=$_GET["net"];
	$po				=$_GET["po"];
	$price			=$_GET["price"];
	$price_unit		=$_GET["price_unit"];
	$qty			=$_GET["qty"];
	$qty_unit		=$_GET["qty_unit"];
	$style			=$_GET["style"];
	$value			=$_GET["value"];
	$netnet			=$_GET["netnet"];
	$pl				=$_GET["pl"];
	$fabric			=$_GET["fabric"];
	$sd				=$_GET["sd"];
	$dc				=$_GET["dc"];
	$item_no		=$_GET["item_no"];
	$specdetail		=$_GET["specdetail"];
	$consttype		=$_GET["consttype"];
	$retprice		=$_GET["retprice"];
	$cbm			=($_GET["cbm"]==""?'0':$_GET["cbm"]);
	$entryno		=$_GET["entryno"];
	$color			=$_GET["color"];
					
	
	$str	   		="insert into commercial_invoice_detail 
						(strInvoiceNo, 
						strStyleID, 
						intItemNo, 
						strBuyerPONo, 
						strDescOfGoods, 
						dblQuantity, 
						strUnitID, 
						dblUnitPrice, 
						strPriceUnitID, 
						dblAmount, 
						strHSCode, 
						dblGrossMass, 
						dblNetMass, 
						strProcedureCode, 
						intNoOfCTns, 
						strKind, 
						strISDno,
						strFabric, 
						strPLno, 
						strDc, 
						dblNetNet,
						strSD, 
						strConstType, 
						strSpecDesc,
						strMRP,
						dblCBM,
						strEntryNo,
						strColor
						)
						values
						('$invoiceno', 
						'$style', 
						'$item_no', 
						'$po', 
						'$desc', 
						'$qty', 
						'$qty_unit', 
						'$price', 
						'$price_unit', 
						'$value', 
						'$hs', 
						'$gross', 
						'$net', 
						'0000.000', 
						'$ctns', 
						'0', 
						'$isd',
						'$fabric', 
						'$pl', 
						'$dc',
						'$netnet',
						'$sd',
						'$consttype',
						'$specdetail',
						'$retprice',
						'$cbm',
						'$entryno',
						'$color'
						);	";	
						
	$result    		=$db->RunQuery($str); 
	if($result)
		echo "Saved";
	else 
		echo "Error";
		

}

if ($request=='load_final_inv_dtl')
{	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$invoiceno	=$_GET["invoiceno"];
	$isd_no		=$_GET["isd_no"];
	
	$sqlDetail="select 	strInvoiceNo, 
						strStyleID, 
						intItemNo, 
						strBuyerPONo, 
						strDescOfGoods, 
						dblQuantity, 
						strUnitID, 
						dblUnitPrice, 
						strPriceUnitID, 
						dblAmount, 
						strHSCode, 
						dblGrossMass, 
						dblNetMass, 
						strProcedureCode, 
						intNoOfCTns, 
						strKind, 
						strISDno, 
						strFabric, 
						strPLno, 
						strDc, 
						dblNetNet,
						strSD , 
						strConstType, 
						strSpecDesc,
						strMRP,
						dblCBM,
						strEntryNo,
						strColor					 
						from 
						commercial_invoice_detail 
						where strInvoiceNo='$invoiceno' order by strBuyerPONo";	
	//die($sqlDetail);
	
	$detailResult=$db->RunQuery($sqlDetail);
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	while($detailrow=mysql_fetch_array($detailResult))
	{		
			$XMLString .= "<InvoiceNo><![CDATA[" . $detailrow["strInvoiceNo"]  . "]]></InvoiceNo>\n";
			$XMLString .= "<Color><![CDATA[" . $detailrow["strColor"]  . "]]></Color>\n";
			$XMLString .= "<StyleID><![CDATA[" . $detailrow["strStyleID"]  . "]]></StyleID>\n";
			$XMLString .= "<ItemNo><![CDATA[" . $detailrow["intItemNo"]  . "]]></ItemNo>\n";
			$XMLString .= "<BuyerPONo><![CDATA[" . $detailrow["strBuyerPONo"]  . "]]></BuyerPONo>\n";
			$XMLString .= "<DescOfGoods><![CDATA[" . $detailrow["strDescOfGoods"]  . "]]></DescOfGoods>\n";
			$XMLString .= "<Quantity><![CDATA[" . $detailrow["dblQuantity"]  . "]]></Quantity>\n";
			$XMLString .= "<UnitID><![CDATA[" . $detailrow["strUnitID"]  . "]]></UnitID>\n";
			$XMLString .= "<UnitPrice><![CDATA[" . $detailrow["dblUnitPrice"]  . "]]></UnitPrice>\n";
			$XMLString .= "<lCMP><![CDATA[" . $detailrow["dblCMP"]  . "]]></lCMP>\n";
			$XMLString .= "<Amount><![CDATA[" . $detailrow["dblAmount"]  . "]]></Amount>\n";
			$XMLString .= "<HSCode><![CDATA[" . $detailrow["strHSCode"]  . "]]></HSCode>\n";
			$XMLString .= "<GrossMass><![CDATA[" . $detailrow["dblGrossMass"]  . "]]></GrossMass>\n";
			$XMLString .= "<NetMass ><![CDATA[" . $detailrow["dblNetMass"]  . "]]></NetMass >\n";
			$XMLString .= "<PriceUnitID><![CDATA[" . $detailrow["strPriceUnitID"]  . "]]></PriceUnitID>\n";
			$XMLString .= "<NoOfCTns><![CDATA[" . $detailrow["intNoOfCTns"]  . "]]></NoOfCTns>\n";
			$XMLString .= "<Category><![CDATA[" . $detailrow["strCatNo"]  . "]]></Category>\n";
			$XMLString .= "<ProcedureCode><![CDATA[" . $detailrow["strProcedureCode"]  . "]]></ProcedureCode>\n";
			$XMLString .= "<ISD><![CDATA[" . $detailrow["strISDno"]  . "]]></ISD>\n";
			$XMLString .= "<Fabric><![CDATA[" . $detailrow["strFabric"]  . "]]></Fabric>\n";
			$XMLString .= "<PLno><![CDATA[" . $detailrow["strPLno"]  . "]]></PLno>\n";
			$XMLString .= "<Dc><![CDATA[" . $detailrow["strDc"]  . "]]></Dc>\n";
			$XMLString .= "<SD><![CDATA[" . $detailrow["strSD"]  . "]]></SD>\n";
			$XMLString .= "<netnet><![CDATA[" . $detailrow["dblNetNet"]  . "]]></netnet>\n";
			$XMLString .= "<consttype><![CDATA[" . $detailrow["strConstType"]  . "]]></consttype>\n";
			$XMLString .= "<specdetail><![CDATA[" . $detailrow["strSpecDesc"]  . "]]></specdetail>\n";	
			$XMLString .= "<retprice><![CDATA[" . $detailrow["strMRP"]  . "]]></retprice>\n";
			$XMLString .= "<dblCBM><![CDATA[" . $detailrow["dblCBM"]  . "]]></dblCBM>\n";
			$XMLString .= "<strEntryNo><![CDATA[" . $detailrow["strEntryNo"]  . "]]></strEntryNo>\n";
				
	}
	
	$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='del_final_inv')
{	
	$InvoiceNo=$_GET["invoiceno"];
	$str="delete from commercial_invoice_detail where strInvoiceNo= '$InvoiceNo'";
	$result=$db->RunQuery($str);
	if($result);
	echo "deleted";
}

if ($request=='getMass')
{	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$plno		=$_GET["plno"];
	
	$sqlDetail="select shipmentpldetail.strPLNo,sum(dblQtyPcs) as qty,sum(dblNoofCTNS) as ctns,sum(dblTotGross) as dblGorss, sum(dblTotNet) as dblNet, sum(dblTotNetNet) as dblNetNet,strStyle,strProductCode,strISDno,strItem,strDO,strLable,strUnit,strFabric,strMaterial,strCTNsvolume,strDc
				from shipmentpldetail 
				left join shipmentplheader on shipmentplheader.strPLNo=shipmentpldetail.strPLNo
				where shipmentpldetail.strPLNo='$plno' group by  shipmentpldetail.strPLNo ";
						
	$detailResult=$db->RunQuery($sqlDetail);
	$XMLString= "<Data>";
	$XMLString .= "<InvoiceData>";
	
	while($detailrow=mysql_fetch_array($detailResult))
	{		
	
			$seight_array=explode("/",color_wise_ctns($plno));	
			$ctns				=$seight_array[0];
			$totgross			=$seight_array[1];
			$totnet				=$seight_array[2];
			$totNetNet			=$seight_array[3];
			
			$vol_arr=explode("X",$detailrow['strCTNsvolume']);
		  	$cbm_fm=round($vol_arr[0]*$vol_arr[1]*$vol_arr[2]*$ctns*.0000164,2);
				
			$isd=($detailrow["strISDno"]==""?$detailrow["strDO"]:$detailrow["strISDno"]);
			
			$Gorss		=($detailrow["strUnit"]=="lbs"?round(($totgross*0.4536),2):round($totgross,2));
			$Net		=($detailrow["strUnit"]=="lbs"?round(($totnet*0.4536),2):round($totnet,2));						
			$NetNet		=($detailrow["strUnit"]=="lbs"?round(($totNetNet*0.4536),2):round($totNetNet,2));
			$XMLString .= "<plno><![CDATA[" . $detailrow["strPLNo"]  . "]]></plno>\n";
			$XMLString .= "<Gorss><![CDATA[" . $Gorss  . "]]></Gorss>\n";
			$XMLString .= "<Net><![CDATA[" . $Net. "]]></Net>\n";
			$XMLString .= "<NetNet><![CDATA[" . $NetNet . "]]></NetNet>\n";	
			$XMLString .= "<ctns><![CDATA[" . $ctns . "]]></ctns>\n";	
			$XMLString .= "<qty><![CDATA[" . $detailrow["qty"] . "]]></qty>\n";	
			$XMLString .= "<PO><![CDATA[" . $detailrow["strStyle"] . "]]></PO>\n";	
			$XMLString .= "<style><![CDATA[" . ($detailrow["strProductCode"]==""?$detailrow["strMaterial"]:$detailrow["strProductCode"]) . "]]></style>\n";
			$XMLString .= "<ISDno><![CDATA[" . $isd . "]]></ISDno>\n";
			$XMLString .= "<Item><![CDATA[" . $detailrow["strItem"] . "]]></Item>\n";
			$XMLString .= "<pllable><![CDATA[" . $detailrow["strLable"] . "]]></pllable>\n";	
			$XMLString .= "<plfabric><![CDATA[" . $detailrow["strFabric"] . "]]></plfabric>\n";	
			$XMLString .= "<Dc><![CDATA[" . $detailrow["strDc"] . "]]></Dc>\n";		
			$XMLString .= "<CBM><![CDATA[" . $cbm_fm . "]]></CBM>\n";				
				
	}
	
	$XMLString .= "</InvoiceData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

function color_wise_ctns($pl)
{
	global $db;
	$ctns				=0;
	$totgross			=0;
	$totnet				=0;
	$totNetNet			=0;
	$str			="select  dblNoofCTNS ,dblTotGross,dblTotNet,dblTotNetNet from shipmentpldetail where strPLNo='$pl'group by dblPLNoFrom,dblPlNoTo";
	$results		=$db->RunQuery($str);
	while($row=mysql_fetch_array($results))
	{
		$ctns		+=$row['dblNoofCTNS'];
		$totgross	+=$row['dblTotGross'];
		$totnet		+=$row['dblTotNet'];
		$totNetNet	+=$row['dblTotNetNet'];
	}
	
	return $ctns."/".$totgross."/".$totnet."/".$totNetNet;
}
?>	