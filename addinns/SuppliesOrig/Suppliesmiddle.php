<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<Supplies>";


$RequestType = $_GET["LoadSupplier"];

			
	$SQL="SELECT 	suppliers.strTitle, suppliers.strSupplierCode, suppliers.strAddress1,suppliers.strOption1,suppliers.strOption2,suppliers.strOption3,suppliers.strContactPerson,suppliers.
strStreet,suppliers.strCity,suppliers.strState,suppliers.strCountry,suppliers.strZipCode,suppliers.strPhone,suppliers.strEMail,	suppliers.strFax,suppliers.strWeb,suppliers.strRemarks,suppliers.strVatRegNo,intSupplierStatus,strCurrency,strOrigin,strTaxTypeID,intApproved,intCreditPeriod,intTaxEnabled,intCreditAllowed,intVATSuspended,intShipmentModeId,strShipmentTermId,strPayModeId,strPayTermId,strReason,cboSupApp,strKeyItems,strAppComments,intUsed,strTQBNo,strFabricRefNo,strAccPaccID,intEntryNoRequire,strVATNo FROM suppliers where strSupplierID = '".$RequestType."';";
	//echo $SQL;
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
         $ResponseXML .= "<Title><![CDATA[" . $row["strTitle"]  . "]]></Title>\n";
		 $ResponseXML .= "<SupplierCode><![CDATA[" . $row["strSupplierCode"]  . "]]></SupplierCode>\n";
		 $ResponseXML .= "<VatRegNo><![CDATA[" . $row["strVatRegNo"]  . "]]></VatRegNo>\n";
		 $ResponseXML .= "<Address1><![CDATA[" . $row["strAddress1"]  . "]]></Address1>\n";
		 $ResponseXML .= "<strOption1><![CDATA[" . $row["strOption1"]  . "]]></strOption1>\n";
		 $ResponseXML .= "<strOption2><![CDATA[" . $row["strOption2"]  . "]]></strOption2>\n";
		 $ResponseXML .= "<strOption3><![CDATA[" . $row["strOption3"]  . "]]></strOption3>\n";
		 $ResponseXML .= "<strContactPerson><![CDATA[" . $row["strContactPerson"]  . "]]></strContactPerson>\n";
		 $ResponseXML .= "<Address2><![CDATA[" . $row["strAddress2"]  . "]]></Address2>\n";
		 $ResponseXML .= "<Street><![CDATA[" . $row["strStreet"]  . "]]></Street>\n";
		 $ResponseXML .= "<City><![CDATA[" . $row["strCity"]  . "]]></City>\n"; 
		 $ResponseXML .= "<State><![CDATA[" . $row["strState"]  . "]]></State>\n";
		 $ResponseXML .= "<Country><![CDATA[" . $row["strCountry"]  . "]]></Country>\n";
		 $ResponseXML .= "<ZipCode><![CDATA[" . $row["strZipCode"]  . "]]></ZipCode>\n";          
		 $ResponseXML .= "<Phone><![CDATA[" . $row["strPhone"]  . "]]></Phone>\n";
		 $ResponseXML .= "<Fax><![CDATA[" . $row["strFax"]  . "]]></Fax>\n";
		 $ResponseXML .= "<EMail><![CDATA[" . $row["strEMail"]  . "]]></EMail>\n";
		 $ResponseXML .= "<Web><![CDATA[" . $row["strWeb"]  . "]]></Web>\n";
		 $ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		 $ResponseXML .= "<SupplierStatus><![CDATA[" . $row["intSupplierStatus"]  . "]]></SupplierStatus>\n";
		 $ResponseXML .= "<Currency><![CDATA[" . $row["strCurrency"]  . "]]></Currency>\n";
		 $ResponseXML .= "<Origin><![CDATA[" . $row["strOrigin"]  . "]]></Origin>\n";
		 $ResponseXML .= "<TaxTypeID><![CDATA[" . $row["strTaxTypeID"]  . "]]></TaxTypeID>\n";
		 $ResponseXML .= "<CreditPeriod><![CDATA[" . $row["intCreditPeriod"]  . "]]></CreditPeriod>\n";
		 $ResponseXML .= "<TaxEnabled><![CDATA[" . $row["intTaxEnabled"]  . "]]></TaxEnabled>\n";
		 $ResponseXML .= "<CreditAllowed><![CDATA[" . $row["intCreditAllowed"]  . "]]></CreditAllowed>\n";
		 $ResponseXML .= "<VATSuspended><![CDATA[" . $row["intVATSuspended"]  . "]]></VATSuspended>\n";
		 $ResponseXML .= "<Approved><![CDATA[" . $row["intApproved"]  . "]]></Approved>\n"; 		 
		 $ResponseXML .= "<intShipmentModeId><![CDATA[" . $row["intShipmentModeId"]  . "]]></intShipmentModeId>\n";
		 $ResponseXML .= "<strShipmentTermId><![CDATA[" . $row["strShipmentTermId"]  . "]]></strShipmentTermId>\n";
		 $ResponseXML .= "<strPayModeId><![CDATA[" . $row["strPayModeId"]  . "]]></strPayModeId>\n";
		 $ResponseXML .= "<strPayTermId><![CDATA[" . $row["strPayTermId"]  . "]]></strPayTermId>\n"; 
		 $ResponseXML .= "<strReason><![CDATA[" . $row["strReason"]  . "]]></strReason>\n"; 
		 $ResponseXML .= "<cboSupApp><![CDATA[" . $row["cboSupApp"]  . "]]></cboSupApp>\n"; 
		 $ResponseXML .= "<strKeyitems><![CDATA[" . $row["strKeyItems"]  . "]]></strKeyitems>\n"; 
		 $ResponseXML .= "<strAppComments><![CDATA[" . $row["strAppComments"]  . "]]></strAppComments>\n"; 
		 $ResponseXML .= "<SVATNo><![CDATA[" . $row["strTQBNo"]  . "]]></SVATNo>\n";
		 $ResponseXML .= "<FabricRefNo><![CDATA[" . $row["strFabricRefNo"]  . "]]></FabricRefNo>\n";
		 $ResponseXML .= "<AccPaccID><![CDATA[" . $row["strAccPaccID"]  . "]]></AccPaccID>\n";
		 $ResponseXML .= "<EntryNoRequire><![CDATA[" . $row["intEntryNoRequire"]  . "]]></EntryNoRequire>\n";
		 $ResponseXML .= "<VATNo><![CDATA[" . $row["strVATNo"]  . "]]></VATNo>\n";
		 
		 $TaxEnabled = $row["intTaxEnabled"];
		 if($TaxEnabled==1)
		 {
		 $ResponseXML .= "<TaxEnablednew><![CDATA[TRUE]]></TaxEnablednew>\n";
		 }
		 else
		 {
		 $ResponseXML .= "<TaxEnablednew><![CDATA[FALSE]]></TaxEnablednew>\n";
		 }  
		 
		 $CreditAllowed = $row["intCreditAllowed"];
		 if($CreditAllowed==1)
		 {
		 $ResponseXML .= "<CreditAllowednew><![CDATA[TRUE]]></CreditAllowednew>\n";
		 }
		 else
		 {
		 $ResponseXML .= "<CreditAllowednew><![CDATA[FALSE]]></CreditAllowednew>\n";
		 }
		 
		 $VATSuspended = $row["intVATSuspended"];
		 if($VATSuspended==1)
		 {
		 $ResponseXML .= "<VATSuspendednew><![CDATA[TRUE]]></VATSuspendednew>\n";
		 }
		 else
		 {
		 $ResponseXML .= "<VATSuspendednew><![CDATA[FALSE]]></VATSuspendednew>\n";
		 }
		 
		 $Approved = $row["intApproved"];
		 if($Approved==1)
		 {
		 $ResponseXML .= "<Approvednew><![CDATA[TRUE]]></Approvednew>\n";
		 }
		 else
		 {
		 $ResponseXML .= "<Approvednew><![CDATA[FALSE]]></Approvednew>\n";
		 }
		 
         $ResponseXML .= "<used><![CDATA[" . $row["intUsed"]  . "]]></used>\n"; 
	}
	 $ResponseXML .= "</Supplies>";
	 echo $ResponseXML;

?>
