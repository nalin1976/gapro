<?php 
$str_header="select 	
spih.intInvoiceNo, 
spih.strInvoice, 
spih.dtmInvoiceDate, 
spih.intSDPNo, 
bbn.strBranchName as consignee,
exporter.strName as exporter,
mfact.strName as Manufacturer,
pol.strCityName as portOfLoading, 
sm.strDescription as shipmentMode,
pod.strCityName as finalDestinationCity,
(select strCountry from country where intConID=pod.intConID) as finalDesCountry,
(select strCountryCode from country where intConID=pod.intConID) as CountryCode,
st.strShipmentTerm as shipmentTerm, 
pt.strDescription as payTerm,
brnk.strName as branch, 
bnk.strBankName,
bnk.strBankCode,
spih.strDeclaration, 
spih.strOfficeOfEntry, 
spih.strCarrier, 
spih.strVoyage, 
spih.dtmETD, 
spih.dtmETA, 
ct.strCurrency as Currency ,
lct.strCurrency as localCurrency, 
er.rate,
spih.dblInsurancy, 
spih.dblFreight, 
spih.dblOther, 
ua.Name as wharfClerk,
aua.Name as Authorizedby,
spih.dtmSavedDate, 
spih.intUserId,

mfact.strName as manufacturer_name,
mfact.strAddress1 as manufacturer_Address1,
mfact.strAddress2 as manufacturer_Address2,
mfact.strCity as manufacturer_City,
mfact.strTINNo  as manufacturer_tin,

exporter.strName as exporter_name,
exporter.strAddress1 as exporter_Address1,
exporter.strAddress2 as exporter_Address2,
exporter.strCity as exporter_City,
exporter.strTINNo  as exporter_tin,

bbn.strBranchName as consigneeName,
bbn.strCorrespondenceAddress1 as consigneeAddress1,
bbn.strCorrespondenceAddress2 as consigneeAddress2,
(select strCountry from country where intConID=bbn.intCountryId) as consigneeCountry,


brnk.strName as brnch_name,
brnk.strAddress1 as brnch_Address1,
brnk.strAddress1 as brnch_Address2,
brnk.strCity as brnch_City,
brnk.strBranchCode  as brnch_no,
sum(spid.dblAmount) as amount



from 
shipping_pre_inv_header spih
inner join 
companies mfact on mfact.intCompanyID=spih.intManufacturer
inner join 
companies exporter on exporter.intCompanyID=spih.intExporter
inner join 
shipping_sdp sdp on sdp.intSDPID=spih.intSDPNo 
inner join 
finishing_buyer_branch_network bbn on bbn.intBuyerBranchId=spih.intConsignee
inner join 
finishing_final_destination pol on pol.intCityID =spih.intPortOfLoading
inner join 
finishing_final_destination pod on pod.intCityID =spih.intDestination
inner join 
shipmentmode sm on sm.intShipmentModeId=spih.intShipmentMode
inner join 
shipmentterms st on  st.strShipmentTermId=spih.intIncoTerm
inner join 
popaymentmode pt on  pt.strPayModeId=spih.intPayTerm
inner join 
branch brnk on brnk.intBranchId=spih.intBank
inner join 
bank bnk on bnk.intBankId=brnk.intBankId
inner join 
currencytypes ct on ct.intCurID=spih.intCurrency
inner join 
currencytypes lct on lct.intCurID=spih.intLocalCurrcy
inner join 
useraccounts ua on ua.intUserID=spih.intWharfClerk
inner join
shipping_pre_inv_detail spid on spid.intInvoiceNo=spih.intInvoiceNo
inner join
exchangerate er on er.currencyID=spih.intLocalCurrcy
left join 
useraccounts aua on aua.intUserID=spih.intAuthorizedby
where spih.intInvoiceNo='$invoiceNo'
group by spih.intInvoiceNo";

$result_header=$db->RunQuery($str_header);
while($row=mysql_fetch_array($result_header))
{

	$InvoiceNo 		= $row["intInvoiceNo"];
	$Invoice 		= $row["strInvoice"];
	$InvoiceDate 	= $row["dtmInvoiceDate"];
	$SDPNo 			= $row["intSDPNo"];
	$Consignee 		= $row["consignee"];
	$Exporter 		= $row["exporter"];
	$Manufacturer 	= $row["Manufacturer"];
	$PortOfLoading 	= $row["portOfLoading"];
	$ShipmentMode 	= $row["shipmentMode"];
	$FDestCity	 	= $row["finalDestinationCity"];
	$FDestCountry	= $row["finalDesCountry"];
	$CountryCode	= $row["CountryCode"];
	$IncoTerm 		= $row["shipmentTerm"];
	$PayTerm 		= $row["payTerm"];
	$branch 		= $row["branch"];
	$bank	 		= $row["strBankName"];
	$BankCode	 	= $row["strBankCode"];
	$Declaration   	= $row["strDeclaration"];
	$OfficeOfEntry 	= $row["strOfficeOfEntry"];
	$Carrier 		= $row["strCarrier"];
	$Voyage 		= $row["strVoyage"];
	$ETDDate 		= $row["dtmETD"];
	$ETADate 		= $row["dtmETA"];
	$Currency 		= $row["Currency"];
	$LocalCurrcy 	= $row["localCurrency"];
	$Insurancy 		= $row["dblInsurancy"];
	$Freight 		= $row["dblFreight"];
	$Other 			= $row["dblOther"];
	$WharfClerk 	= $row["intWharfClerk"];
	$WharfClerkName = $row["wharfClerk"];
	$SavedDate 		= $row["dtmSavedDate"];
	$UserId 		= $row["intUserId"];
	
	$manuf_name 	= $row["manufacturer_name"];
	$manuf_Addr1 	= $row["manufacturer_Address1"];
	$manuf_Addr2 	= $row["manufacturer_Address2"];
	$manuf_City 	= $row["manufacturer_City"];
	$manuf_tin 		= $row["manufacturer_tin"];
	
	$exp_name 		= $row["exporter_name"];
	$exp_Address1 	= $row["exporter_Address1"];
	$exp_Address2 	= $row["exporter_Address2"];
	$exp_City 		= $row["exporter_City"];
	$exp_tin 		= $row["exporter_tin"];
	
	$brnch_name 	= $row["brnch_name"];
	$brnch_Address1 = $row["brnch_Address1"];
	$brnch_Address2 = $row["brnch_Address2"];
	$brnch_City 	= $row["brnch_City"];
	$brnch_no 		= $row["brnch_no"];	
	
	$consigneeName 	= $row["consigneeName"];
	$consigneeAdd1 	= $row["consigneeAddress1"];
	$consigneeAdd2 	= $row["consigneeAddress2"];
	$consigneeCntry = $row["consigneeCountry"];
	
	$voyageDateArray 		= explode('-',$ETDDate);
	$formatedVoyageDate 	= $voyageDateArray[2]."/".$voyageDateArray[1]."/".$voyageDateArray[0];
	$amount			= $row["amount"];
	$exRate			= $row["rate"];
	$Authorizedby	= $row["Authorizedby"];
	
	
}
?>