<?php
 session_start();
include "../../Connector.php";
$backwardseperator 	= "../../";
	//include "{$backwardseperator}Connector.php" ;	
	include "{$backwardseperator}authentication.inc";
	
	$userId	= $_GET["UserId"];
	$report_companyId  = $_SESSION["FactoryID"];
$cbosearch   	    = $_GET["cbosearch"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Suppliers Detail Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {
	font-size: xx-large;
	color: #FF0000;
}
.style3 {
	font-size: xx-large;
	color: #FF0000;
}
-->

</style>
</head>
<body>
<table align="center" width="900" border="0">
<tr>
<?php
		
					$SQL_address="SELECT * FROM 
						companies
						Inner Join useraccounts ON companies.intCompanyID = useraccounts.intCompanyID
						WHERE
						useraccounts.intUserID =  '".$_SESSION["UserID"]."'";
							
						$result_address = $db->RunQuery($SQL_address);
					
					
		while($rows = mysql_fetch_array($result_address))
		{	
		$strName=$rows["strName"];
		$comAddress1=$rows["strAddress1"];
		$comAddress2=$rows["strAddress2"];
		$comStreet=$rows["strStreet"];
		$comCity=$rows["strCity"];
		$comCountry=$rows["strCountry"];
		$comZipCode=$rows["strZipCode"];
		$strPhone=$rows["strPhone"];
		$comEMail=$rows["strEMail"];
		$comFax=$rows["strFax"];
		$comWeb=$rows["strWeb"];
		}			
				?>
<td ><?php include "../../reportHeader.php";?></td>				
</tr>

<tr>
 <td height="10">
  <?php

		$SQL="SELECT 
		suppliers.strTitle,
		suppliers.strSupplierCode,
		suppliers.strAddress1,
		suppliers.strAddress2,
		suppliers.strOption1,
		suppliers.strOption2,
		suppliers.strOption3,
		suppliers.strContactPerson,
		suppliers.strStreet,
		suppliers.strCity,
		suppliers.strState,		
		(select strCountry from country where country.intConID=suppliers.strCountry) as strCountry,
		suppliers.strZipCode,
		suppliers.strPhone,
		suppliers.strEMail,
		suppliers.strFax,
		suppliers.strWeb,
		suppliers.strRemarks,
		suppliers.strVatRegNo,
		suppliers.strKeyItems,
		suppliers.strAppComments,
		suppliers.intStatus,
		intSupplierStatus,
		strCurrency,
		strOrigin,
		taxtypes.strTaxType,
		intApproved,
		intCreditPeriod,
		intTaxEnabled,intCreditAllowed,intVATSuspended,shipmentmode.strDescription as       	        intShipmentModeId,shipmentterms.strShipmentTerm as strShipmentTermId,
		popaymentmode.strDescription as strPayModeId,popaymentterms.strDescription as       				        strPayTermId,strReason,useraccounts.Name,itempurchasetype.strDescription as strOriginTy,creditperiods.strDescription as strCreditPe
		FROM suppliers 
		LEFT JOIN taxtypes ON suppliers.strTaxTypeID = taxtypes.strTaxTypeID
		LEFT JOIN itempurchasetype ON suppliers.strOrigin = itempurchasetype.intOriginNo
		LEFT JOIN creditperiods ON suppliers.intCreditPeriod = creditperiods.intSerialNO
		
		LEFT JOIN useraccounts ON suppliers.cboSupApp = useraccounts.intUserID
		LEFT JOIN shipmentmode ON suppliers.intShipmentModeId = shipmentmode.intShipmentModeId
		LEFT JOIN shipmentterms ON suppliers.strShipmentTermId = shipmentterms.strShipmentTermId
		LEFT JOIN popaymentmode ON suppliers.strPayModeId = popaymentmode.strPayModeId
		LEFT JOIN popaymentterms ON suppliers.strPayTermId = popaymentterms.strPayTermId
        where suppliers.strSupplierID = '$cbosearch'"; 
	 		   			    
        $result = $db->RunQuery($SQL);

		while($row = mysql_fetch_array($result))
		{	
		$strTitle     		 = cdata($row["strTitle"]);
		$strSupplierCode     = cdata($row["strSupplierCode"]);
		$strVatRegNo  		 = cdata($row["strVatRegNo"]);
		$strAddress1         = cdata($row["strAddress1"]);
		$strAddress2     	 = cdata($row["strAddress2"]);
		$strOption1   		 = cdata($row["strOption1"]);
		$strOption2   		 = cdata($row["strOption2"]);
		$strOption3     	 = cdata($row["strOption3"]);
		$strContactPerson    = cdata($row["strContactPerson"]);
		$strStreet      	 = cdata($row["strStreet"]);
		$strCity          	 = cdata($row["strCity"]);
		$strState            = cdata($row["strState"]);
		$strCountry          = cdata($row["strCountry"]);
		$strZipCode          = cdata($row["strZipCode"]);
		$strPhone            = cdata($row["strPhone"]);
		$strFax   			 = cdata($row["strFax"]);
		$strEMail  			 = cdata($row["strEMail"]);
		$strWeb  			 = cdata($row["strWeb"]);
		$strRemarks   		 = cdata($row["strRemarks"]);
		$strKeyItems   		 = cdata($row["strKeyItems"]);
		$intSupplierStatus   = cdata($row["intSupplierStatus"]);
		$strCurrency  		 = cdata($row["strCurrency"]);
		$strOrigin   		 = cdata($row["strOriginTy"]);
		$strTaxTypeID   	 = cdata($row["strTaxType"]);
		$intCreditPeriod     = cdata($row["strCreditPe"]);
			
		$intTaxEnabled       = cdata($row["intTaxEnabled"]);
		$strContactPerson    = cdata($row["strContactPerson"]);
		$strKeyItems         = cdata($row["strKeyItems"]);
		//$intCreditPeriod     = cdata($row["intCreditPeriod"]);
		$strAppComments      = cdata($row["strAppComments"]);
		$intStatus           = cdata($row["intStatus"]);

/*		if($intStatus == 1){
		$intStatus='Active';
		}else{
		$intStatus='Inactive';
		}	*/
		
		
		
		if($intTaxEnabled == '0'){
		$intTaxEnabled = "No";
		}else{
		$intTaxEnabled = "Yes";
		}
		$intCreditAllowed   = $row["intCreditAllowed"];
		if($intCreditAllowed == '0'){
		$intCreditAllowed = "No";
		}else{
		$intCreditAllowed = "Yes";
		}
		$intVATSuspended  = $row["intVATSuspended"];
		if($intVATSuspended == '0'){
		$intVATSuspended = "No";
		}else{
		$intVATSuspended = "Yes";
		}
		$intApproved   = $row["intApproved"];
		$intShipmentModeId   = $row["intShipmentModeId"];
		$strShipmentTermId   = $row["strShipmentTermId"];
		$strPayModeId   = $row["strPayModeId"];
		$strPayTermId   = $row["strPayTermId"];
		$strReason   = $row["strReason"];
		$cboSupApp   = $row["cboSupApp"];
		$strPayTermId   = $row["strPayTermId"];
		$Name   = $row["Name"];
		}
		?></td>
</tr>
<tr>
 <td align="center" ><table width="100%" border='0' align='center' cellpadding="3" cellspacing="0"  >
  <thead>
   <tr>
     <td colspan="2" align="center" class='border-Left-Top-right-fntsize12'><div class="normalfnt2bldBLACKmid">Supplier Detail Report </div></td>
     </tr></thead>
   <tr>
     <td align="center" class='border-top-left-fntsize12'width="20%"><span class="normalfnt"><strong> Vat Reg No</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' width="80%"><span class="normalfnt"><?php echo $strVatRegNo?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Sup Code</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strSupplierCode;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Company Name</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strTitle;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Address</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strAddress1." ".$strAddress2;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Contact Person</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo  $strContactPerson ;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Street</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strStreet ;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>City</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strCity ;?></span></td>
   </tr>
   <tr>
    <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>State</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strState ;?></span> </td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Country</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strCountry ;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Zip Code</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strZipCode ;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Phone</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strPhone;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Fax</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strFax;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Email</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strEMail;?></span> </td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Web</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strWeb;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Currency</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strCurrency ;?></span> </td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Origin</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strOrigin;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Shipment Mode</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $intShipmentModeId ;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Shipment Term</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strShipmentTermId;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Pay Mode</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strPayModeId ;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Pay Term</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strPayTermId;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Remarks</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strRemarks;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Key Items</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strKeyItems ;?></span> </td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Tax Enabled</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $intTaxEnabled;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Tax Type</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strTaxTypeID;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Credit Allowed</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $intCreditAllowed;?></span> </td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Credit Period</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $intCreditPeriod;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> VAT Suspended</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $intVATSuspended;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Supplier Status</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $intStatus;?></span></td>
   </tr>
   <?php 
  if($intSupplierStatus == '10'){  
 ?>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Reason</strong></span> </td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $intSupplierStatus;?></span></td>
   </tr>
   <?php
 }
 ?>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Approved By</strong></span> </td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $Name;?></span></td>
   </tr>
   
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Comments</strong></span> </td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo $strAppComments;?></span> </td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Option 1</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo  $strOption1 ;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong>Option 2</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo  $strOption2 ;?></span></td>
   </tr>
   <tr>
     <td align="center" class='border-top-left-fntsize12'><span class="normalfnt"><strong> Option 3</strong></span></td>
     <td class='border-Left-Top-right-fntsize12' ><span class="normalfnt"><?php echo  $strOption2 ;?></span></td>
   </tr>
   <tfoot>
   <tr>
     <td align="center"  class="border-top-fntsize12">&nbsp;</td>
     <td  class="border-top-fntsize12">&nbsp;</td>
   </tr></tfoot>
 </table></td>
</table>

</body>
</html>
