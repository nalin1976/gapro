<?php
include "../../Connector.php";
//require("../../PHPMailer/class.phpmailer.php");

$Button 	= $_GET["q"];
$ComName	= $_GET["ComName"];

//mail function
function smtpmailer($to, $from, $from_name, $subject, $body) { 
define('GUSER', 'accsyst@gmail.com'); // Gmail username
define('GPWD', 'accsystaccsyst'); // Gmail password$headers["From"] = "user@somewhere.com";
	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465; 
	$mail->Username = GUSER;  
	$mail->Password = GPWD;           
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}

if($Button=="Save")
{ 
$supplierCode		= $_GET["supplierCode"];
$ComName			= $_GET["ComName"];
$VatReNo			= $_GET["VatReNo"];
$Address1			= $_GET["Address1"];
$Option1			= $_GET["Option1"];
$Option2			= $_GET["Option2"];
$Option3			= $_GET["Option3"];
$ContactPerson		= $_GET["ContactPerson"];
$street				= $_GET["street"];
$City				= $_GET["City"];
$State				= $_GET["State"];
$Country			= $_GET["Country"];
$ZipCode			= $_GET["ZipCode"];
$Phone				= $_GET["Phone"];
$Fax				= $_GET["Fax"];
$email				= $_GET["email"];
$Web				= $_GET["Web"];
$Remarks			= $_GET["Remarks"];
$Keyitems			= $_GET["Keyitems"];
$Currcncy			= $_GET["Currcncy"];
$Origin				= $_GET["Origin"];
$taxenable			= $_GET["taxenable"];
$creditallowed		= $_GET["creditallowed"];
$vatsuspended		= $_GET["vatsuspended"];
$supplierappo		= $_GET["supplierappo"];
$SupplierStatus		= $_GET["SupplierStatus"];
$SupplierID			= $_GET["SupplierID"];
$Taxtype			= $_GET["Taxtype"];
$Creditperi			= $_GET["Creditperi"];
$SVATNo				= $_GET["SVATNo"];

if($Creditperi=="" || $creditallowed!=1)
	$Creditperi		= 0;

$intShipmentModeId	= $_GET["intShipmentModeId"];
$strShipmentTermId	= $_GET["strShipmentTermId"];
$strPayModeId		= $_GET["strPayModeId"];
$strPayTermId		= $_GET["strPayTermId"];
$txtReason			= $_GET["txtReason"];
$cboSupApp			= $_GET["cboSupApp"];//user id
$appComments		= $_GET["txtApprComments"];
$VATNo				= $_GET["VATNo"];
$fabRefNo			= $_GET["fabRefNo"];
$accPaccID 			= $_GET["accPaccID"];
$entryNoRequire		= $_GET["EntryNoRequire"];
	
$SQL_update="update suppliers set strTitle='".$ComName."',strAddress1='".$Address1."',strOption1='".$Option1."',strOption2='".$Option2."',strOption3='".$Option3."',strContactPerson='".$ContactPerson."',strStreet='".$street."',strCity='".$City."',strState='".$State."',strCountry='".$Country."',strZipCode='".$ZipCode."',strPhone='".$Phone."',strEMail='".$email."',strFax='".$Fax."',strWeb='".$Web."',strRemarks='".$Remarks."',strKeyItems='".$Keyitems."',strOrigin='".$Origin."',strCurrency='".$Currcncy."',strVatRegNo='".$VatReNo."',intTaxEnabled='".$taxenable."',intVATSuspended='".$vatsuspended."',strTaxTypeID='".$Taxtype."',intCreditPeriod='".$Creditperi."',intStatus=1,intApproved='".$supplierappo."',intSupplierStatus='".$SupplierStatus."',intCreditAllowed='".$creditallowed."',strSupplierCode='".$supplierCode."',intShipmentModeId='".$intShipmentModeId."',strShipmentTermId='".$strShipmentTermId."',strPayModeId='".$strPayModeId."',strPayTermId='".$strPayTermId."',strReason='".$txtReason."',cboSupApp='".$cboSupApp."',strAppComments='".$appComments."',strVATNo='".$VATNo."',strFabricRefNo='".$fabRefNo."' , strAccPaccID = '$accPaccID',intEntryNoRequire='$entryNoRequire',strTQBNo='$SVATNo' where strSupplierID = '".$SupplierID."'";
$db->ExecuteQuery($SQL_update);
echo "Updated successfully";
	
//-----------generate theemail-----------
$emailMessage="The following record Saved";
//smtpmailer('hemanthibu@yahoo.com',  'hemanthi.bu@gmail.com', 'Hemanthi', 'notice', $emailMessage);
//-----------------------------------------------------------------------		
}
elseif($Button=="New")
{
$supplierCode		= $_GET["supplierCode"];
$ComName			= $_GET["ComName"];
$VatReNo			= $_GET["VatReNo"];
$Address1			= $_GET["Address1"];
$Option1			= $_GET["Option1"];
$Option2			= $_GET["Option2"];
$Option3			= $_GET["Option3"];
$ContactPerson		= $_GET["ContactPerson"]; 
$street				= $_GET["street"];
$City				= $_GET["City"];
$State				= $_GET["State"];
$Country			= $_GET["Country"];
$ZipCode			= $_GET["ZipCode"];
$Phone				= $_GET["Phone"];
$Fax				= $_GET["Fax"];
$email				= $_GET["email"];
$Web				= $_GET["Web"];
$Remarks			= $_GET["Remarks"];

$Keyitems			= $_GET["Keyitems"];
$Currcncy			= $_GET["Currcncy"];
$Origin				= $_GET["Origin"];
$taxenable			= $_GET["taxenable"];
$creditallowed		= $_GET["creditallowed"];
$vatsuspended		= $_GET["vatsuspended"];
$supplierappo		= $_GET["supplierappo"];
$SupplierStatus		= $_GET["SupplierStatus"];
$SupplierID			= $_GET["SupplierID"];
$Taxtype			= $_GET["Taxtype"];
$Creditperi			= $_GET["Creditperiod"];
$Creditperi			= $_GET["Creditperi"];
$SVATNo				= $_GET["SVATNo"];

if($Creditperi=="" || $creditallowed!=1)
	$Creditperi		= 0;

$txtReason			= $_GET["txtReason"];
$intShipmentModeId 	= $_GET["intShipmentModeId"];
$strShipmentTermId 	= $_GET["strShipmentTermId"];
$strPayModeId 		= $_GET["strPayModeId"];
$strPayTermId 		= $_GET["strPayTermId"];
$cboSupApp 			= $_GET["cboSupApp"];
$appComments		= $_GET["txtApprComments"];
$VATNo				= $_GET["VATNo"];
$fabRefNo			= $_GET["fabRefNo"];
$accPaccID 			= $_GET["accPaccID"];
$entryNoRequire		= $_GET["EntryNoRequire"];
	 
$SQL_insert="insert into suppliers (strTitle,strAddress1,strOption1,strOption2,strOption3,strContactPerson,strStreet,strCity, strState,strCountry,strZipCode,strPhone,strEMail,strFax,strWeb,strRemarks, strKeyItems,intStatus,intApproved,strOrigin,strAccPaccID,strCurrency,intCreditAllowed,strVatRegNo,intTaxEnabled,intVATSuspended,strTaxTypeID,intCreditPeriod,intSupplierStatus,strSupplierCode,intShipmentModeId,strShipmentTermId,strPayModeId,strPayTermId,strReason,cboSupApp,strAppComments,strTQBNo,strFabricRefNo,intEntryNoRequire,strVATNo) values ('$ComName','".$Address1."','".$Option1."','".$Option2."','".$Option3."','".$ContactPerson."','".$street."','".$City."','".$State."','".$Country."','".$ZipCode."','".$Phone."','".$email."','".$Fax."','".$Web."','".$Remarks."','".$Keyitems."','1','".$supplierappo."','".$Origin."','$accPaccID','".$Currcncy."','".$creditallowed."','".$VatReNo."','".$taxenable."','".$vatsuspended."','".$Taxtype."','".$Creditperi."','".$SupplierStatus."','".$supplierCode."','".$intShipmentModeId."','".$strShipmentTermId."','".$strPayModeId."','".$strPayTermId."','".$txtReason."','".$cboSupApp."','".$appComments."','".$SVATNo."','".$fabRefNo."','$entryNoRequire','$VATNo')";
$db->ExecuteQuery($SQL_insert);
echo "Saved successfully";
			
//-----------generate theemail-----------
$emailMessage="The following record Saved";
//smtpmailer('hemanthibu@yahoo.com',  'hemanthi.bu@gmail.com', 'Hemanthi', 'notice', $emailMessage);
//-----------------------------------------------------------------------		
}			 
elseif($Button=="Delete")
{	
$suppCode=$_GET["ComName"];	
	$SQL ="delete from suppliers where strSupplierID='$suppCode'";
	$result = $db->RunQuery2($SQL);
 	if(gettype($result)=='string')
 	{
		echo $result;
		return;
 	}

 	echo "Deleted successfully.";

//-----------generate theemail-----------
$emailMessage="The following record Deleted";
//smtpmailer('hemanthibu@yahoo.com',  'hemanthi.bu@gmail.com', 'Hemanthi', 'notice', $emailMessage);
//-----------------------------------------------------------------------		
}
else if($Button=="LoadCountryMode")
{
	$SQL="SELECT country.strCountry,country.intConID FROM country WHERE country.intStatus<>10 order by country.strCountry;";
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intConID"] ."\">" . $row["strCountry"] ."</option>" ;
	}
}
?>