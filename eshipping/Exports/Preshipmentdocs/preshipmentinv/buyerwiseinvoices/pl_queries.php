<?php 
$xmldoc=simplexml_load_file('../../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

$str_header		="select 
date(dtmSailingDate) as dtmSailingDate,
date(dtmInvoiceDate) as dtmInvoiceDate,
sum(dblGrossMass) as dblGrossMass,
sum(dblNetMass) as dblNetMass,
sum(dblNetNet) as dblNetNet,
strISDno,
strContainer,
strVoyegeNo,
strCarrier,
strSealNo,
strBL,
strHAWB,
strMAWB,

dto.strName AS dtoName, 
dto.strAddress1 AS dtoAddress1 ,
dto.strAddress2 AS dtoAddress2,
dto.strCountry AS dtoCountry,
dto.strPhone AS dtophone,
dto.strFax AS dtoFax,
dto.strContactPerson AS dtoContactPerson,
dto.strRemarks AS dtoremarks,

city.strCity AS destination,
city.strDestination AS city,
city.strPortOfLoading AS port,
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
commercial_invoice_header.strPayTerm,
useraccounts.Name as UserName,
commercial_invoice_header.strLCNo,
date_format(dtmLCDate,'%b %d,%Y')as  dtmLCDate,
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
finalinvoice.dblConTypeId,

commercial_invoice_detail.strDc
from 
commercial_invoice_header
left join finalinvoice on commercial_invoice_header.strInvoiceNo=finalinvoice.strInvoiceNo
left join commercial_invoice_detail on commercial_invoice_header.strInvoiceNo=commercial_invoice_detail.strInvoiceNo
LEFT JOIN city ON commercial_invoice_header.strFinalDest =city.strCityCode
LEFT JOIN useraccounts ON commercial_invoice_header.intUserId =useraccounts.intUserID
LEFT JOIN buyers ON commercial_invoice_header.strBuyerID =buyers.strBuyerID 
LEFT JOIN buyers dto ON commercial_invoice_header.strDeliverTo =dto.strBuyerID 
left join commercialinvformat cif on cif.intCommercialInvId=commercial_invoice_header.strComInvFormat
where  commercial_invoice_header.strInvoiceNo='$invoiceNo' group by finalinvoice.strInvoiceNo";
//die($str_header);
$result_header	=$db->RunQuery($str_header);
$data_header	=mysql_fetch_array($result_header);

	$mainmark1			=$data_header['strMMLine1'];
	$mainmark2			=$data_header['strMMLine2'];
	$mainmark3			=$data_header['strMMLine3'];
	$mainmark4			=$data_header['strMMLine4'];
	$mainmark5			=$data_header['strMMLine5'];
	$mainmark6			=$data_header['strMMLine6'];
	$mainmark7			=$data_header['strMMLine7'];
	$sidemark1			=$data_header['strSMLine1'];
	$sidemark2			=$data_header['strSMLine2'];
	$sidemark3			=$data_header['strSMLine3'];
	$sidemark4			=$data_header['strSMLine4'];
	$sidemark5			=$data_header['strSMLine5'];
	$sidemark6			=$data_header['strSMLine6'];
	$sidemark7			=$data_header['strSMLine7'];
	$payterms			=$data_header['strPayTerm'];

?>