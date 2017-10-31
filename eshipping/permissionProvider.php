<?php

session_start();

$administration 			= false;
$styleTransfer 				= false;
$manageUsers 				= false;

$addingMenu 				= false;
$manageBuyers				= false;
$manageGender				= false;
$manageBrands				= false;
$manageCities				= false;
$ShipmentForecast			= false;
$manageCurrency				= false;
$manageImCommodityCodes		= false;
$manageExCommodityCodes		= false;
$manageBank					= false;
$manageExpenceType			= false;
$manageForwaders			= false;
$manageImportItem			= false;
$manageMode					= false;
$managePaymentTerms			= false;
$manageShipmentTerms		= false;
$manageSuppliers 			= false;
$manageTaxes				= false;
$manageTransportChargers 	= false;
$manageUnits				= false;
$manageWharlfClerks			= false;
$managePackageType			= false;
$manageDeliveryTerms		= false;
$manageCommodityCodes		= false;
$manageCountries			= true;

$importsMenu				= false;
$manageImportsCusdec		= false;
$manageImportEntry			= false;
$manageCopyCusdec 			= false;

$exportMenu					= false;
$managePreShipmentDocs 		= false;
$manageExCommercialInvoice	= false;
$$manageExCusdec			= false;
$manageExCDN				= false;
$manageShippingNote			= false;
$reportMenu					= false;
$pledit						= false;
$exportregistry				= false;

$iouMenu					= false;
$iouadvance					= false;
$manageIou					= false;
$manageIouInvoice			= false;
$coustomerreceipt			= false;
$IOUCancellation			= false;
$IOUsummery					= false;
$IOUcndnote					= false;
$IOUfundtransfer			= false;


$helpMenu 					= false;
$manageExportIOU			= false;
$manageExportCO			    = false;

$financeMenu			    = false;

$resetPassword 				= false;

$sql = "select role.RoleName from useraccounts, role, userpermission where useraccounts.intUserID =" . $_SESSION["UserID"] . " and role.RoleID = userpermission.RoleID and userpermission.intUserID = useraccounts.intUserID ";

$result = $dbheader->RunQuery($sql);
	
while($row = mysql_fetch_array($result))
{
//Start	- Master Data	
	if ($row["RoleName"] == "Master Data Menu")
	{
		$addingMenu = true;
	}
	elseif ($row["RoleName"] == "Manage Buyers")
	{
		$manageBuyers = true;
	}	
	elseif ($row["RoleName"] == "Manage Gender")
	{
		$manageGender = true;
	}	
	elseif ($row["RoleName"] == "Manage Brands")
	{
		$manageBrands = true;
	}	
	elseif($row["RoleName"]=="Manage Cities")
	{
		$manageCities	= true;	
	}
	
		elseif($row["RoleName"]=="Shipment Forecast")
	{
		$ShipmentForecast	= true;
	}
	
	
	elseif($row["RoleName"]=="Manage Currency")
	{
		$manageCurrency	= true;
	}
	elseif($row["RoleName"]=="Manage Import Commodity Codes")
	{
		$manageImCommodityCodes	= true;
		$manageCommodityCodes	= true;
	}
	elseif($row["RoleName"]=="Manage Export Commodity Codes")
	{
		$manageExCommodityCodes	= true;
		$manageCommodityCodes	= true;
	}
	elseif($row["RoleName"]=="Manage Customers")
	{
		$manageCustomer	= true;
	}
	elseif($row["RoleName"]=="Manage Bank")
	{
		$manageBank	= true;
	}
	elseif($row["RoleName"]=="Manage Expence Type")
	{
		$manageExpenceType	= true;
	}
	elseif($row["RoleName"]=="Manage Forwaders")
	{
		$manageForwaders	= true;
	}
	elseif($row["RoleName"]=="Manage Import Item")
	{
		$manageImportItem	= true;
	}
	elseif($row["RoleName"]=="Manage Mode")
	{
		$manageMode			= true;
	}
	elseif($row["RoleName"]=="Manage Payment Mode")
	{
		$managePaymentTerms	= true;
	}
	elseif($row["RoleName"]=="Manage Shipment Mode")
	{
		$manageShipmentTerms	= true;
	}
	elseif ($row["RoleName"] == "Manage Suppliers")
	{
		$manageSuppliers = true;
	}
	elseif ($row["RoleName"] == "Manage Taxes")
	{
		$manageTaxes = true;
	}
	elseif ($row["RoleName"] == "Manage Transport Chargers")
	{
		$manageTransportChargers	= true;
	}
	elseif ($row["RoleName"] == "Manage Units")
	{
		$manageUnits	= true;
	}
	elseif ($row["RoleName"] == "Manage Wharlf Clerks")
	{
		$manageWharlfClerks	= true;
	}
	elseif ($row["RoleName"] == "Manage Package Type")
	{
		$managePackageType		= true;
	}
	elseif ($row["RoleName"] == "Manage Delivery Terms")
	{
		$manageDeliveryTerms	= true;
	}
	elseif ($row["RoleName"] == "Manage Countries")
	{
		$manageCountries		= true;
	}
//End 	- Master Data
//Start - Imports
	elseif ($row["RoleName"] == "Allow Imports Menu")
	{
		$importsMenu = true;
	}
	elseif ($row["RoleName"] == "Manage Import Cusdec")
	{
		$manageImportsCusdec = true;
	}
	elseif ($row["RoleName"] == "Manage Import Entry")
	{
		$manageImportEntry = true;
	}
	
	elseif ($row["RoleName"] == "Manage Copy Import Cusdec")
	{
		$manageCopyCusdec = true;
	}
	elseif ($row["RoleName"] == "Manage Customer Recipt")
	{
		$coustomerreceipt = true;
	}
	elseif ($row["RoleName"] == "Manage IOU Cancellation")
	{
		$IOUCancellation = true;
	}
	elseif ($row["RoleName"] == "Manage IOU Summery")
	{
		$IOUsummery	 = true;
	}
	
//End	- Imports

//Start	- Export
	elseif ($row["RoleName"] == "Allow Export Menu")
	{
		$exportMenu = true;
	}
	
	elseif ($row["RoleName"] == "Manage Packing List")
	{
		$pledit = true;
			
	}
	elseif ($row["RoleName"] == "Allow Export Commercial Invoive")
	{
		$managePreShipmentDocs = true;
		$manageExCommercialInvoice	= true;
	}
	elseif ($row["RoleName"] == "Allow Export Cusdec")
	{
		$managePreShipmentDocs 	= true;
		$manageExCusdec			= true;
	}	
	elseif($row["RoleName"] == "Manage Cargo Dispatch Note")
	{
		$manageExCDN			= true;
	}	
	elseif($row["RoleName"] == "Dispatch Note")
	{
		$exportaod			= true;
	}
	elseif($row["RoleName"] == "Manage Shipping Note")
	{
		$manageShippingNote			= true;
	}
	elseif($row["RoleName"] == "Manage Export IOU")
	{
		$manageExportIOU			= true;
	}
	elseif($row["RoleName"] == "Export Registry")
	{
		$exportregistry			= true;
	}
	elseif ($row["RoleName"] == "Upload Orders")
	{
		$uploadPO	 = true;
	}	
	elseif ($row["RoleName"] == "Invoice Tracking")
	{
		$invtrack	 = true;
	}
		elseif ($row["RoleName"] == "Revise Packing List")
	{
		$RevisePacking	 = true;
	}
//End	- Export
// Start Finance	
	elseif ($row["RoleName"] == "Allow Finance Menu")
	{
		$financeMenu	 = true;
	}
	
// End Finance
//Start	- IOU
	elseif ($row["RoleName"] == "Manage IOU Menu")
	{
		$iouMenu	 = true;
	}
	elseif ($row["RoleName"] == "Manage IOU")
	{
		$manageIou = true;
	}
	elseif ($row["RoleName"] == "Manage IOU Invoice")
	{
		$manageIouInvoice = true;
	}
	elseif ($row["RoleName"] == "Manage IOU Credit Debit Note")
	{
		$IOUcndnote = true;
	}
	elseif ($row["RoleName"] == "Manage IOU Fund Transfer")
	{
		$IOUfundtransfer = true;
	}
	elseif ($row["RoleName"] == "Manage IOU Summary")
	{
		$IOUsummery	 = true;
	}
	elseif ($row["RoleName"] == "Manage IOU Advance Receipt")
	{
		$iouadvance	 = true;
	}
	
//End	- IOU

//Start	- Reports
	elseif ($row["RoleName"] == "Allow Reports Menu")
	{
		$reportMenu = true;
	}	
//End	- Reports



//Start	- Administration
	elseif ($row["RoleName"] == "Administration")
	{
		$administration = true;
		$manageUsers = true;
	}
//End	- Administration


//Start	- Help
	elseif ($row["RoleName"] == "Allow Help Menu")
	{
		$helpMenu = true;
	}
	elseif ($row["RoleName"] == "Reset Password")
	{
		$resetPassword = true;
	}
	
//Start	- Help
}
?>