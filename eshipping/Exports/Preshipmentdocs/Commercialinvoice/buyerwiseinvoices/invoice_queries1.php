<?php 

$sqlinvoiceheader="SELECT 	
	ID.strInvoiceNo, 
	date_format(dtmInvoiceDate,'%d-%b-%y')as  dtmInvoiceDate,
	date_format(dtmInvoiceDate,'%b %d,%Y')as  dtmFullInvoiceDate,
	bytType,
	sum(dblGrossMass) as gross,
	sum(dblNetMass) as net,
	sum(dblNetNet) as netnet,
	sum(intNoOfCTns) as noofctns,
	sum(dblAmount) as dblAmount,
	sum(dblQuantity) as dblQuantity,
	customers.strName AS CustomerName,
	CONCAT(customers.strAddress1,' ',customers.strAddress2 ) AS CustomerAddress, 
	customers.strAddress1,
	customers.strAddress2,
	customers.strAddress1,	
	customers.strMIDCode,
	customers.strLocation as locationcode,		
	customers.strcountry AS CustomerCountry,
	
	buyers.strBuyerID,
	buyers.strName AS BuyerAName, 
	buyers.strAddress1 AS buyerAddress1 ,
	buyers.strAddress2 AS buyerAddress2,
	buyers.strCountry AS BuyerCountry,
	buyers.strPhone AS buyerphone,
	buyers.strFax AS BuyerFax,
	buyers.strContactPerson AS BuyerContactPerson,
	buyers.strEMail AS BuyerMail,
	buyers.strTINNo AS BuyerTINNo,
	buyers.strRemarks AS BuyerRemarks,
		
	csc.strName AS cscName, 
	csc.strAddress1 AS cscAddress1 ,
	csc.strAddress2 AS cscAddress2,
	csc.strCountry AS cscCountry,
	csc.strPhone AS cscphone,
	csc.strFax AS cscFax,
	csc.strContactPerson AS cscPerson,	
	csc.strRemarks AS cscteeremarks,
		
	accountee.strName AS accounteeAName, 
	accountee.strAddress1 AS accounteeAddress1 ,
	accountee.strAddress2 AS accounteeAddress2,
	accountee.strCountry AS accounteeCountry,
	accountee.strPhone AS accounteephone,
	accountee.strFax AS accounteeFax,
	accountee.strContactPerson AS accounteeContactPerson,
	accountee.strRemarks AS accounteeremarks,
		
	dto.strName AS dtoName, 
	dto.strAddress1 AS dtoAddress1 ,
	dto.strAddress2 AS dtoAddress2,
	dto.strCountry AS dtoCountry,
	dto.strPhone AS dtophone,
	dto.strFax AS dtoFax,
	dto.strContactPerson AS dtoContactPerson,
	dto.strRemarks AS dtoremarks,
	
	byr.strName AS BrokerName , 
	byr.strAddress1 AS BrokerAddress1 ,
	byr.strAddress2 AS BrokerAddress2,
	byr.strCountry AS BrokerCountry,
	byr.strPhone AS Brokerphone,
	byr.strFax AS BrokerFax,
	byr.strContactPerson AS BrokerContactPerson,
	byr.strEMail AS BrokerMail,
	byr.strTINNo AS BrokerTINNo,
	byr.strRemarks AS BrokerRemarks,
	
	notify2.strName AS notify2Name , 	
	notify2.strAddress1 AS notify2Address1 ,
	notify2.strAddress2 AS notify2Address2,
	notify2.strCountry AS notify2Country,
	notify2.strPhone AS notify2phone,
	notify2.strFax AS notify2Fax,
	notify2.strEMail AS notify2Mail,
	notify2.strContactPerson AS notify2ContactPerson,
	notify2.strRemarks AS notify2remarks,
	ID.strPayTerm,
	ID.strIncoterms,
	forwaders.strName as forwaderName, 
	
	strNotifyID1, 
	strNotifyID2,
	strLCNo AS LCNO,
	date_format(dtmLCDate,'%b %d,%Y')as  dtmLCDate, 
	strLCBankID, 
	ID.strPortOfLoading, 
	ID.intMarchantId,
	ID.strPreInvoiceNo,
	ID.strTransportMode,
	city.strCity AS city,
	city.strPortOfLoading AS port,
	city.strtoLocation AS tolocation,
	(select strCountry from country where country.strCountryCode=city.strCountryCode)as countrydest,
	strCarrier, 
	strVoyegeNo, 
	date_format(dtmSailingDate,'%b %d,%Y')as  dtmSailingDate,
	strCurrency, 
	dblExchange, 	
	intNoOfCartons, 
	intMode, 
	strCartonMeasurement, 
	strCBM, 
	strMarksAndNos, 
	strGenDesc, 
	bytStatus, 
	intFINVStatus,
	bank.strName as bankname,
	bank.strAddress1 as bankaddress1,
	bank.strAddress2 as bankaddress2, 
	bank.strCountry as bankcountry, 
	bank.strRefNo as bankref,
	bank.strSwiftCode as swiftCode,
	bank.strAccName as accName,
	
	banklc.strName as banklcname,
	banklc.strAddress1 as banklcaddress1,
	banklc.strAddress2 as banklcaddress2, 
	banklc.strCountry as banklccountry, 
	banklc.strRefNo as banklcref, 
	
	intCusdec,
	strIncoterms,
	date_format(dtmETA,'%b %d,%Y')as  dtmETA,
	
	cif.strMMLine1,
	cif.strMMLine2,
	cif.strMMLine3,
	cif.strMMLine4,
	cif.strMMLine5,
	cif.strMMLine6,
	cif.strMMLine7,
	cif.strSMLine1,	
	cif.strSMLine2,
	cif.strSMLine3,
	cif.strSMLine4,
	cif.strSMLine5,
	cif.strSMLine6,
	cif.strSMLine7,
	cif.strPtLine3 as billtovatno, 
	cif.strBuyerTitle, 
	cif.strBrokerTitle, 
	cif.strAccounteeTitle, 
	cif.strNotify1Title, 
	cif.strNotify2Title, 
	cif.strCSCTitle, 
	cif.strSoldTitle,
	cif.strIncoDesc,
	strProInvoiceNo,
	ID.strFinalDest
	
			 
	FROM 
	invoiceheader ID
	LEFT JOIN customers ON ID.strCompanyID=customers.strCustomerID
	LEFT JOIN buyers ON ID.strBuyerID =buyers.strBuyerID 
	LEFT JOIN buyers notify2 ON ID.strNotifyID2 =notify2.strBuyerID
	LEFT JOIN buyers byr ON ID.strNotifyID1 =byr.strBuyerID 		
	LEFT JOIN buyers csc ON ID.strCSCId =csc.strBuyerID 
	LEFT JOIN buyers accountee ON ID.strAccounteeId =accountee.strBuyerID 
	LEFT JOIN buyers dto ON ID.strDeliverTo =dto.strBuyerID 	
	LEFT JOIN city ON ID.strFinalDest =city.strCityCode 
	LEFT JOIN bank banklc ON ID.strLCBankID =banklc.strBankCode
	LEFT JOIN bank ON ID.intBankId =bank.strBankCode 
	left join commercialinvformat cif on cif.intCommercialInvId=ID.strComInvFormat
	LEFT JOIN invoicedetail ON invoicedetail.strInvoiceNo=ID.strInvoiceNo
	LEFT JOIN forwaders ON forwaders.intForwaderID=ID.strForwader
	LEFT JOIN wharfclerks ON wharfclerks.intWharfClerkID=ID.intMarchantId
	WHERE  ID.strInvoiceNo='$invoiceNo' group by ID.strInvoiceNo";
	
	$idresult				=$db->RunQuery($sqlinvoiceheader);
	$dataholder				=mysql_fetch_array($idresult);
	$invoiceNo				= $dataholder['strInvoiceNo'];
	$dateVariable 			= $dataholder['dtmInvoiceDate'];
	$dateInvoice 			= $dateVariable;
	$FullInvoiceDate 		= $dataholder['dtmFullInvoiceDate'];
	$Inco_terms				= $dataholder['strIncoterms'];
	$bytType				= $dataholder['bytType'];
	$gross					= $dataholder['gross'];
	$net					= $dataholder['net'];
	$netNet					= $dataholder['netNet'];
	$noOfCtns				= $dataholder['noofctns'];
	$amount					= $dataholder['dblAmount'];
	$quantity				= $dataholder['dblQuantity'];
	$PayTerm				= $dataholder['strPayTerm'];	
	$customerName			= $dataholder['CustomerName'];
	$customerAddress		= $dataholder['CustomerAddress'];
	$customerAddress1		= $dataholder['strAddress1'];
	$customerAddress2		= $dataholder['strAddress2'];
	$customerMIDCode		= $dataholder['strMIDCode'];
	$customerLocationCode	= $dataholder['locationcode'];//location
	$customerCountry    	= $dataholder['CustomerCountry'];
	$MerchID				= $dataholder['intMarchantId'];
	
	
	$BuyerId				= $dataholder['strBuyerID'];
	$BuyerName				= $dataholder['BuyerAName'];
	$BuyerAddress1			= $dataholder['buyerAddress1'];
	$BuyerAddress2			= $dataholder['buyerAddress2'];
	$BuyerCountry			= $dataholder['BuyerCountry'];
	$BuyerPhone				= $dataholder['buyerphone'];
	$BuyerFax				= $dataholder['BuyerFax'];
	$BuyerContactPerson		= $dataholder['BuyerContactPerson'];
	$BuyerMail				= $dataholder['BuyerMail'];
	$BuyerRemarks			= $dataholder['BuyerRemarks'];
	$BuyerTINNo				= $dataholder['BuyerTINNo'];
	
	
	$cscName				= $dataholder['cscName'];
	$cscAddress1			= $dataholder['cscAddress1'];
	$cscAddress2			= $dataholder['cscAddress2'];
	$cscCountry				= $dataholder['cscCountry'];
	$cscphone				= $dataholder['cscphone'];
	$cscFax					= $dataholder['cscFax'];
	$cscPerson				= $dataholder['cscPerson'];
	$cscRemarks				= $dataholder['cscteeremarks'];
	
	
	$accounteeName			= $dataholder['accounteeAName'];
	$accounteeAddress1		= $dataholder['accounteeAddress1'];
	$accounteeAddress2		= $dataholder['accounteeAddress2'];
	$accounteeCountry		= $dataholder['accounteeCountry'];
	$accounteephone			= $dataholder['accounteephone'];
	$accounteeFax			= $dataholder['accounteeFax'];
	$accounteeContactPerson	= $dataholder['accounteeContactPerson'];
	$accounteeRemarks		= $dataholder['accounteeremarks'];
	
	$dtoName				= $dataholder['dtoName'];//ship to address
	$dtoAddress1			= $dataholder['dtoAddress1'];
	$dtoAddress2			= $dataholder['dtoAddress2'];
	$dtoCountry				= $dataholder['dtoCountry'];
	$dtophone				= $dataholder['dtophone'];
	$dtoFax					= $dataholder['dtoFax'];
	$dtoContactPerson		= $dataholder['dtoContactPerson'];
	$dtoRemarks				= $dataholder['dtoremarks'];
	
	$BrokerName				= $dataholder['BrokerName'];
	$BrokerAddress1			= $dataholder['BrokerAddress1'];
	$BrokerAddress2			= $dataholder['BrokerAddress2'];
	$BrokerCountry			= $dataholder['BrokerCountry'];
	$Brokerphone			= $dataholder['Brokerphone'];
	$BrokerFax				= $dataholder['BrokerFax'];
	$BrokerMail				= $dataholder['BrokerMail'];
	$BrokerContactPerson	= $dataholder['BrokerContactPerson'];
	$BrokerTINNo			= $dataholder['BrokerTINNo'];
	$BrokerRemarks			= $dataholder['BrokerRemarks'];
	
	
	$notify2Name			= $dataholder['notify2Name'];
	$notify2Address1		= $dataholder['notify2Address1'];
	$notify2Address2		= $dataholder['notify2Address2'];
	$notify2Country			= $dataholder['notify2Country'];
	$notify2phone			= $dataholder['notify2phone'];
	$notify2Fax				= $dataholder['notify2Fax'];
	$notify2Mail			= $dataholder['notify2Mail'];
	$notify2ContactPerson	= $dataholder['notify2ContactPerson'];
	$notify2remarks		 	= $dataholder['notify2remarks'];
	
	
	$NotifyID1				= $dataholder['strNotifyID1'];
	$NotifyID2				= $dataholder['strNotifyID2'];
	$LCNO					= $dataholder['LCNO'];
	$LCDate					= $dataholder['dtmLCDate'];
	$PortOfLoading			= $dataholder['strPortOfLoading'];
	$PreInvoiceNo			= $dataholder['strPreInvoiceNo'];
	$TransportMode			= $dataholder['strTransportMode'];
	$Destinationcity	    = $dataholder['city'];
	$Destinationport		= $dataholder['port'];
	$toLocation				= $dataholder['tolocation'];
	$countryDest			= $dataholder['countrydest'];
	$Carrier				= $dataholder['strCarrier'];//Vessel
	$VoyegeNo				= $dataholder['strVoyegeNo'];
	$SailingDate			= $dataholder['dtmSailingDate'];
	$Currency				= $dataholder['strCurrency'];
	$Exchange				= $dataholder['dblExchange'];
	$noOfCartons			= $dataholder['intNoOfCartons'];
	$Mode					= $dataholder['intMode'];
	$CartonMeasurement		= $dataholder['strCartonMeasurement'];
	$CBM					= $dataholder['strCBM'];
	$MarksAndNos			= $dataholder['strMarksAndNos'];
	$GenDesc				= $dataholder['strGenDesc'];
	$bytStatus				= $dataholder['bytStatus'];
	$FINVStatus				= $dataholder['intFINVStatus'];
	
	
	$bankName				= $dataholder['bankname'];
	$bankAddress1			= $dataholder['bankaddress1'];
	$bankAddress2			= $dataholder['bankaddress2'];
	$bankCountry			= $dataholder['bankcountry'];
	$bankref				= $dataholder['bankref'];
	$swiftCode				= $dataholder['swiftCode'];
	$accName				= $dataholder['accName'];
	
	$banklcname				= $dataholder['banklcname'];
	$banklcaddress1			= $dataholder['banklcaddress1'];
	$banklcaddress2			= $dataholder['banklcaddress2'];
	$banklccountry			= $dataholder['banklccountry'];
	$banklcref				= $dataholder['banklcref'];
	
			
	$mainmark1			=$dataholder['strMMLine1'];
	$mainmark2			=$dataholder['strMMLine2'];
	$mainmark3			=$dataholder['strMMLine3'];
	$mainmark4			=$dataholder['strMMLine4'];
	$mainmark5			=$dataholder['strMMLine5'];
	$mainmark6			=$dataholder['strMMLine6'];
	$mainmark7			=$dataholder['strMMLine7'];
	$sidemark1			=$dataholder['strSMLine1'];
	$sidemark2			=$dataholder['strSMLine2'];
	$sidemark3			=$dataholder['strSMLine3'];
	$sidemark4			=$dataholder['strSMLine4'];
	$sidemark5			=$dataholder['strSMLine5'];
	$sidemark6			=$dataholder['strSMLine6'];
	$sidemark7			=$dataholder['strSMLine7'];
	$billtovatno		=($dataholder['billtovatno']!=""?"Vat No:".$dataholder['billtovatno']:$billtovatno);
	
	$BuyerTitle			=$dataholder['strBuyerTitle'];
	$AccounteeTitle		=$dataholder['strAccounteeTitle'];
	$Notify2Title		=$dataholder['strNotify2Title'];
	$CSCTitle			=$dataholder['strCSCTitle'];
	$IncoDesc			=$dataholder['strIncoDesc'];
	$ProInvoiceNo		=$dataholder['strProInvoiceNo'];
	$BrokerTitle		=$dataholder['strBrokerTitle'];
	$SoldTitle			=$dataholder['strSoldTitle'];
	$Notify1Title		=$dataholder['strNotify1Title'];
	$Cusdec				=$dataholder['intCusdec'];
	$Incoterms			=$dataholder['strIncoterms'];
	$dateETA			=$dataholder['dtmETA'];
	$finalDest			=$dataholder['strFinalDest'];	
	//$dateLC = $dataholder['LCDate'];
	//$LCDate = substr($dateLC, 0, 10); 
	
	$forwaderName		=$dataholder['forwaderName'];
	
	$str_commercial_inv="select *
				from finalinvoice
				where 
				strInvoiceNo='$invoiceNo'";
				$result_com_inv=$db->RunQuery($str_commercial_inv);
				$com_inv_dataholder=mysql_fetch_array($result_com_inv);
				
				$freight_ch=($com_inv_dataholder['dblFreight']==""?0:$com_inv_dataholder['dblFreight']);
				$insurance_ch=($com_inv_dataholder['dblInsurance']==""?0:$com_inv_dataholder['dblInsurance']);
				$dest_ch=($com_inv_dataholder['dblDestCharge']==""?0:$com_inv_dataholder['dblDestCharge']);
				$tot_ch=$freight_ch+$insurance_ch+$dest_ch;
				
				$inco_terms=($tot_ch==0?"FOB":$dataholder['strIncoterms']);
				$discount=$com_inv_dataholder['dblDiscount'];
				
				$Brand        		= $com_inv_dataholder['strBrand'];
				$Quality			= $com_inv_dataholder['strQuality'];
				$FinishedStd		= $com_inv_dataholder['strFinishedStd'];
				$PackStd			= $com_inv_dataholder['strPackStd'];
				$Gender				= $com_inv_dataholder['strGender'];
				$GarmentType		= $com_inv_dataholder['strGarmentType'];
				$BTM				= $com_inv_dataholder['strBTM'];
				$Cat				= $com_inv_dataholder['strCat'];
				$CTNSType			= $com_inv_dataholder['strCTNSType'];
				$CTNnos				= $com_inv_dataholder['strCTNnos'];
				$CTNSize			= $com_inv_dataholder['strCTNSize'];
				$Other				= $com_inv_dataholder['dblOther'];
				$Freight			= $com_inv_dataholder['dblFreight'];
				$Insurance			= $com_inv_dataholder['dblInsurance'];
				$DestCharge			= $com_inv_dataholder['dblDestCharge'];
				$BL					= $com_inv_dataholder['strBL'];
				$VAT				= $com_inv_dataholder['strVAT'];
				$Container			= $com_inv_dataholder['strContainer'];
				$SealNo				= $com_inv_dataholder['strSealNo'];
				$HAWB				= $com_inv_dataholder['strHAWB'];
				$MAWB				= $com_inv_dataholder['strMAWB'];
				$FreightPC			= $com_inv_dataholder['strFreightPC'];
				$PSno				= $com_inv_dataholder['strPSno'];
				$ShipmentRef		= $com_inv_dataholder['strShipmentRef'];
				$Discount			= $com_inv_dataholder['dblDiscount'];
				$TotFreight			= $com_inv_dataholder['dblTotFreight'];	
				$TotInsuranse		= $com_inv_dataholder['dblTotInsuranse'];
				$TotDest			= $com_inv_dataholder['dblTotDest'];
				$TotOther			= $com_inv_dataholder['dblTotOther'];
				$ConTypeId			= $com_inv_dataholder['dblConTypeId'];
				$WebToolId			= $com_inv_dataholder['dblWebToolId'];
				$SampleQuote		= $com_inv_dataholder['dblSampleQuote'];
				$DocumentDueDate	= $com_inv_dataholder['dtmDocumentDueDate'];
				$DocumentSubDate	= $com_inv_dataholder['dtmDocumentSubDate'];
				$PaymentDueDate		= $com_inv_dataholder['dtmPaymentDueDate'];
				$PaymentSubDate		= $com_inv_dataholder['dtmPaymentSubDate'];
				$FCR				= $com_inv_dataholder['strFCR'];
				$FileNo				= $com_inv_dataholder['strFileNo'];
				$ExportNo			= $com_inv_dataholder['strExportNo'];
				$SGSIONO			= $com_inv_dataholder['strSGSIONO'];
				
				
				
		     	
				
		$str_Detail_Sum =  "SELECT
							invoicedetail.dblQuantity,
							invoicedetail.dblUnitPrice,
							invoicedetail.dblAmount,
							invoicedetail.strUnitID
							FROM
							invoicedetail
							WHERE
							invoicedetail.strInvoiceNo = '$invoiceNo'";
		$result_Detail_Sum = $db->RunQuery($str_Detail_Sum);
	
?>