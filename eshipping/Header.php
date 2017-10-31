<?php
ini_set('session.gc_maxlifetime', 90*60);
if(!isset($_SESSION["Server"]))
{
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $backwardseperator . '/login.php">';
	die("");
}
include "HeaderConnector.php";
include "permissionProvider.php";



?>
<script src="<?php echo $backwardseperator;?>SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="<?php echo $backwardseperator;?>SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $backwardseperator;?>css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {
	font-size: 10px;
	font-weight: bold;
	font-family: Verdana;
	color: #FFFFFF;
}
.style3 {
	font-family: Verdana;
	font-size: 10px;
	font-weight: bold;
}
-->
</style>
<table width="952" border="0" cellpadding="0" cellspacing="0">
<tr bgcolor="#FFFFFF">
		<td width="12"></td>
      <td width="940" height="44">
	  <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td width="21%" rowspan="2"><img src="<?php echo $backwardseperator;?>images/logo_wave_edge.jpg" alt="" width="" /></td>
            <td width="7%" rowspan="2">&nbsp;</td>
            <td width="46%" rowspan="2" class="tophead" id="companyName"></td>
            <td width="26%" class="tophead" id="companyName">
              <div align="right"><a href="<?php echo $backwardseperator;?>logout.php"><img src="<?php echo $backwardseperator;?>images/button_log_out.png" alt="Logout" width="92" height="25" border="0" class="noborderforlink" /></a> </div></td>
        </tr>
          <tr>
            <td class="normalfnth2B" id="companyName"><div align="right" style="color:#936cb0;">Welcome <span class="normalfnth2"><?php 
		
		//$SQL ="select useraccounts.intUserID, useraccounts.UserName from useraccounts, role, userpermission where useraccounts.intUserID =" . $_SESSION["UserID"] . " and role.RoleID = userpermission.RoleID and userpermission.intUserID = useraccounts.intUserID and role.RoleName = 'Administration'";
		$SQL = "select Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
		$result = $dbheader->RunQuery($SQL);
	
		while($row = mysql_fetch_array($result))
		{
			echo $row["Name"];
		}
		?>! </span></div></td>
          </tr>
      </table>    </td>
  </tr>
    <tr>
	<td align="center" bgcolor="#594693" style="width:30px;"><a href="<?php echo $backwardseperator;?>main.php" title="Home"><img src="<?php echo $backwardseperator;?>images/house.png" alt="Home" width="16" height="16" border="0" /></a></td>
      <td bgcolor="#594693">
	  
	  <ul id="MenuBar1" class="MenuBarHorizontal">
<?php
if ($addingMenu)
{
?>
<li><a href="#" class="MenuBarItemSubmenu  style2">Master Data</a>
	<ul>
	<?php 		
	if($manageCities)
	{
	?>
    <li>
   	<a class="style2" href="<?php echo $backwardseperator;?>MasterData/banks/banks.php" target=\"_TOP1\">Bank</a>
  	</li>	
	<?php
	}
	?>
		<?php 		
	if($manageBuyers)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/buyers/buyers.php" target=\"_TOP37\"> Buyers</a></li>	
    <li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/mainbuyer/mainBuyer.php" target=\"_TOP3\">Main Buyers</a>
    </li>
	<?php
	}
	?>
    <?php 		
	if($manageGender)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/gender/gender.php" >Gender</a></li>	
	<?php
	}
	?>
    <?php 		
	if($manageBrands)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/brand/brand.php">Brands</a></li>	
	<?php
	}
	?>
	
	<?php 		
	if($manageCities)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/cities/cities.php" target=\"_TOP4\">Cities</a></li>	
	<?php
	}
	?>
    
     <?php 		
	if($manageCities)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/shippmentForcast/ShipmentForecast.php" target=\"_TOP41\">Shipment Forecast</a></li>	
	<?php
	}
	?>
    
    
	
	<?php 		
	if($manageCommodityCodes)
	{
	?>
	<li><a class="style2" href="#">Commodity Codes</a>
	<ul>
		<?php
		 if($manageImCommodityCodes)
		 {
		?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/commodityCodes/commodityCodes.php" target=\"_TOP5\">Import</a><li>
		<?php
		}
		?>
		<?php
		 if($manageExCommodityCodes)
		 {
		?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/exporthscodes/exhscodes.php" target=\"_TOP6\">Export</a><li>
		<?php
		}
		?>
	</ul>
	</li>
	<?php
	}	
	?>
	
	<?php 	
	if ($manageCountries)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/country/countries.php" target=\"_TOP7\">Countries</a></li>
	<?php 
	}
	?>
	
	<?php 	
	if ($manageCurrency)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/currency/Currency.php" target=\"_TOP8\">Currency</a></li>
	<?php 
	}
	?>
	
	<?php 		
	if($manageCustomer)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/customer/customer.php" target=\"_TOP9\">Manufacturers</a></li>	
	<?php
	}
	?>
	<li><a class="style2" href="#">Packing List</a>
    	<ul>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/cartoons/cartoons.php" target=\"_TOP10\">Cartons</a></li>	
        </ul>
    </li>	
	<?php 		
	if($manageDeliveryTerms)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/shipmentterm/shipmentterm.php" target=\"_TOP11\">Delivery Terms</a></li>	
	<?php
	}
	?>
	
	<?php 		
	if($manageExpenceType)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/expensesType/Listing.php" target=\"_TOP12\">Expense Type</a></li>	
	<?php
	}
	?>
	
	<?php 		
	if($manageForwaders)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/forwaders/forwaders.php" target=\"_TOP13\">Forwarders</a></li>	
	<?php
	}
	?>
	
	<?php 		
	if($manageImportItem)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/importItems/importItems.php" target=\"_TOP14\">Import Item</a></li>	
	<?php
	}
	?>
		
	<?php 		
	if($manageMode)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/mode/details.php" target=\"_TOP15\">Mode</a></li>	
	<?php
	}
	?>
	
	<?php 		
	if($managePackageType)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/packagetype/packagetype.php" target=\"_TOP16\">Package Type</a></li>	
	<?php
	}
	?>
	
	<?php 		
	if($managePaymentTerms)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/paymentTerms/paymentTerm.php" target=\"_TOP17\">Payment Term</a></li>	
	<?php
	}
	?>
	
	<?php 		
	if($manageShipmentTerms)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/shipment Term/shipment Term.php" target=\"_TOP18\">Shipment Term</a></li>	
	<?php
	}
	?>
	
	<?php 		
	if($manageSuppliers)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/suppliers/suppliers.php" target=\"_TOP19\">Suppliers</a></li>	
	<?php
	}
	?>
	
	<?php 		
	if($manageTaxes)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/taxes/details.php" target=\"_TOP20\">Taxes</a></li>	
	<?php
	}
	?>
	
	<?php 		
	if($manageTransportChargers)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/transportChargers/tcharglist.php" target=\"_TOP21\">Transport Chargers</a></li>	
	<?php
	}
	?>
	
	<?php 		
	if($manageUnits)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/units/Units.php" target=\"_TOP22\">Units</a></li>	
	<?php
	}
	?>
	
	<?php 		
	if($manageWharlfClerks)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>MasterData/WharfClerks/details.php" target=\"_TOP23\">Wharf Clerk</a></li>	
	<?php
	}
	?>
	
  </ul>
</li>
<?php
}		
?>

<?php
if($importsMenu)
{
?>
<li><a href="#" class="style3 MenuBarItemSubmenu">Imports</a>
<ul>
	<?php 		
	if($manageImportsCusdec)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Imports/Cusdec/cusdec.php">Cusdecs</a></li>	
	<?php
	}
	?>
	
	<?php 		
	if($manageImportEntry)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Imports/ImportEntry/Details/importentry.php">Import Entry</a></li>	
	<?php
	}
	?>	
</ul>
</li>
<?php 
}
?>

<?php
if($exportMenu)
{
?>
<li><a href="#" class="style3 MenuBarItemSubmenu">Export</a>
<ul>
	<?php 
	
	if($uploadPO)
	{
	?>
   <li> <a class="style2" href="#">Orders Spec</a><ul>
   	<li>
    <a class="style2" href="<?php echo $backwardseperator;?>Exports/order/orderspec/orderspec.php" target=\"_TOPe1\">New</a>
    	</li>
    <li>
    <a class="style2" href="<?php echo $backwardseperator;?>Exports/po_plugin/uploadpos/poupload.php" target=\"_TOPe2\">Upload</a>
        </li>
      </ul></li>
      <li>
      <a class="style2" href="<?php echo $backwardseperator;?>Exports/bookings/booking/bookingInstructions.php" target=\"_TOPe3\">Booking</a></li>  
    <?php
	}
	if($pledit)
	{
	?>
	<li><a class="style2" href="#">Packing List</a><ul>
        <li> <a class="style2" href="<?php echo $backwardseperator;?>shipmentpackinglist/stylerato/stylerato_plugin/stylerato_plugin.php" target=\"_TOPe4\">New</a></li>
        <li> <a class="style2" href="<?php echo $backwardseperator;?>shipmentpackinglist/pl_plugin_search/pl_plugin_search.php" target=\"_TOPe5\">Search</a></li>
        <li> <a class="style2" href="<?php echo $backwardseperator;?>shipmentpackinglist/pop_Direct_printer.php" target=\"_TOPe5\">Direct_print</a></li>
       <?php if($RevisePacking)
	{?>	
    	<li> <a class="style2" href="<?php echo $backwardseperator;?>shipmentpackinglist/revisepl/revisepl.php" target=\"_TOPe6\">Revise</a></li>
        <?php }?>
        </ul>
    </li>	
	
	<?php
	}
	?>

	<?php 		
	if($managePreShipmentDocs)
	{
	?>
    
	<li><a class="style2" href="#">Pre-Shipment Docs.</a>
	<ul>
		<?php
		if($manageExCommercialInvoice)
		{
		?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>Exports/Preshipmentdocs/preshipmentinv/Commercialinvoice.php" target=\"_TOPe7\">Invoice</a></li>
            <li><a class="style2" href="<?php echo $backwardseperator;?>Exports/Preshipmentdocs/preshipmentinv/searchPreInv/searchPreInv.php" target=\"_TOPe8\">Search Invoice</a></li>
             <li><a class="style2" href="<?php echo $backwardseperator;?>Exports/Preshipmentdocs/forwaderInstruction/forInstruction.php" target=\"_TOPe9\">Forwarder Instructions</a></li>
             <li><a class="style2" href="<?php echo $backwardseperator;?>Exports/fclReports/fclReport.php" target=\"_TOPe10\">Fcl Report</a></li>
		<?php
		}
		?>
		
		<?php
		if($manageExCusdec)
		{
		?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>Exports/Preshipmentdocs/Cusdecs/details.php" target=\"_TOPe11\">Cusdec</a></li>
		<?php
		}
		?>
		
	</ul>
	</li>	
	<?php
	}
	?>
	
	<?php 		
	if($manageShippingNote)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Exports/ShippingNotes/shippingnotes.php" target=\"_TOPe12\">Shipping Note</a>
	</li>	
	
	<?php
	}
	?>
    <?php 		
	if($exportaod)
	{
	?>
    <li><a class="style2" href="#">Export AOD</a><ul>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Exports/DispatchNote/Details/DispathNote.php" target=\"_TOPe13\">New</a>
    <li><a class="style2" href="<?php echo $backwardseperator;?>Exports/DispatchNote/Search/search.php" target=\"_TOPe14\">Search</a>
	</li>
    </ul>
    </li>    
	<?php
	}
	?>	
	
	<?php 		
	if($manageExCDN)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Exports/cdn/cdn.php" target=\"_TOPe15\">Cargo Dispatch Note</a>
	</li>
    	<li><a class="style2" href="<?php echo $backwardseperator;?>Exports/Preshipmentdocs/preshipmentinv/documentchecklist/maersk.php" target=\"_TOPe25\">Maersk Reports</a>
	</li>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Exports/ShortShipmentdeclation/shortShipmentDeclaration.php" target=\"_TOPe16\">Shipment Declaration</a>
	</li>
    <li><a class="style2" href="<?php echo $backwardseperator;?>Exports/exportrelease/exportrelease.php" target=\"_TOPe17\">Export Release</a>
	</li>
    <li><a class="style2" href="<?php echo $backwardseperator;?>Exports/pre_export_registry/pre_shipment_registry.php" target=\"_TOPe18\">Pre-Export Registry</a>
	</li>
	<?php
	}
	?>	
    <?php 		
	if($manageExCDN)
	{
	?>
    
	<li><a class="style2" href="<?php echo $backwardseperator;?>Exports/CommercialInvoiceFormat/CommercialInvFormat.php" target=\"_TOPe19\">SDP </a>
	</li>
    <li><a class="style2" href="#">Commercial Invoice</a>
    	<ul>
        	<li><a class="style2" href="<?php echo $backwardseperator;?>Exports/Preshipmentdocs/Commercialinvoice/Commercialinvoice.php" target=\"_TOPe20\">Commercial Invoice</a></li>
            <li><a class="style2" href="<?php echo $backwardseperator;?>Exports/Preshipmentdocs/Commercialinvoice/searchCDNInv/searchCDNInv.php" target=\"_TOPe21\">Search CDN Invoice</a></li>
        </ul>
    </li>
    <li><a class="style2" href="<?php echo $backwardseperator;?>Exports/masterInvoice/masterInvoice.php" target=\"_TOPe22\">Master Invoice</a>
	</li>
    <li><a class="style2" href="<?php echo $backwardseperator;?>Exports/exportreport/exportreport.php" target=\"_TOPe22\">Invoice Summaries</a>
	</li>
    <li><a class="style2" href="<?php echo $backwardseperator;?>Exports/DocumentList/documentList.php" target=\"_TOPe23\">Document List </a>
	</li>	
     <li><a class="style2" href="<?php echo $backwardseperator;?>Exports/updateinvoice/updateinv.php" target=\"_TOPe24\">Document Submission</a>
	</li>		
	<?php
	}
	?>	
	
		<?php 		
	if($manageExportIOU)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Exports/IOU/iou.php" target=\"_TOPe25\">IOU</a>
	</li>	
	<?php
	}
	?>
	<?php 		
	if($manageExportCO)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Exports/Certificateoforigin/certificateoforgin.php" target=\"_TOPe26\">Certificate of Origin</a>
	</li>	
	<?php
	}
	?>
    <?php 		
	if($exportregistry)
	{
	?>
   
	<li><a class="style2" href="<?php echo $backwardseperator;?>Exports/exportregistry/exportregistry.php" target=\"_TOPe27\">Export Registry</a>
	</li>
    <li><a class="style2" href="<?php echo $backwardseperator;?>Exports/summarycharts/summary_charts.php" target=\"_TOPe27\">Shipment Summary</a>
	</li>
    	
	<?php
	}
	if($invtrack)
	{
	?>
    <li><a class="style2" href="<?php echo $backwardseperator;?>Exports/invoicetracking/invoicetracking.php" target=\"_TOPe28\">Invoice Tracking</a>
	</li>	
	<?php
	}
	?>
    
</ul>
</li>
<?php 
}
?>

<?php
if($financeMenu)
{
?>
<li><a href="#" class="style3 MenuBarItemSubmenu">Finance</a>
	<ul>
   		<li><a class="style2" href="<?php echo $backwardseperator;?>Finance/invoicetracking/invoicetracking.php" target=\"_TOPf1\">Invoice Tracking</a></li>
        <li><a class="style2" href="<?php echo $backwardseperator;?>Finance/forwaderinvoice/ForwarderInvoice.php" target=\"_TOPf2\">Forwarder Inv</a></li>
        <li><a class="style2" href="<?php echo $backwardseperator;?>Finance/forwaderpayment/payment.php" target=\"_TOPf3\">Forwarder Payments</a></li>
        <li><a class="style2" href="<?php echo $backwardseperator;?>Finance/fcr/fcr.php" target=\"_TOPf4\">FCR</a></li>
        <li><a class="style2" href="<?php echo $backwardseperator;?>Finance/discounting/Discount.php" target=\"_TOPf5\">Discounting</a></li>
        <li><a class="style2" href="<?php echo $backwardseperator;?>Finance/bankletter/bankLetter.php" target=\"_TOPf6\">Bank Letter</a></li>
        <li><a class="style2" href="<?php echo $backwardseperator;?>Finance/receipt/receipt.php" target=\"_TOPf7\">Receipt</a></li>
   		<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/FinacialReports/finaceReports.php" target=\"_TOPf8\">Finance Reports</a></li>
    </ul>
</li>
<?php
}
?>
<?php
if($iouMenu)
{
?>		
<li><a href="#" class="style3 MenuBarItemSubmenu">IOU</a>
<ul>		
	<?php 		
	if($manageIou)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>IOU/IOU/iou.php">IOU Settlement</a></li>	
	<?php
	}
	?>
	<?php 		
	if($iouadvance)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>IOU/Receipt/advanceallocation/advanceallocation.php">IOU Advance Allocation</a></li>	
	<?php
	}
	?>
	<?php 		
	if($manageIouInvoice)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>IOU/IOUInvoice/iouinvoice.php">IOU Invoice</a></li>	
	<?php
	}
	?>
		
	<?php 		
	if($coustomerreceipt)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>IOU/Receipt/customerreceipt/customerreceipt.php">Customer Receipt</a></li>	
	<?php
	}
	?>
    <?php 		
	if($IOUfundtransfer)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>IOU/Receipt/fundtranfer/fundtransfer.php">Fund Transfer</a></li>	
	<?php
	}
	?>
    <?php 		
	if($IOUcndnote)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>IOU/Receipt/creditdebitnote/creditdebitnote.php">Credit/ Debit Notes</a></li>	
	<?php
	}
	?>
	<?php 		
	if($IOUCancellation)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>IOU/ioucancellation/canceliou.php">Cancel IOU</a></li>	
	<?php
	}
	?>
    <?php 		
	if($IOUsummery)
	{
	?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>IOU/ioulist/IOUlist.php">IOU Summery</a></li>	
	<?php
	}
	?>
		</ul></li>
<?php
}

?>

<?php
if($reportMenu)
{
?>
<li><a href="#" class="style3 MenuBarItemSubmenu">Reports</a>
<ul>
</ul>
</li>
<?php 
}
?>



<?php		
if ($administration)
{
?>		
<li><a href="#" class="style3 MenuBarItemSubmenu">Administration</a>
<ul>		
	<?php	
	if($manageUsers)
	{
	?>         
	<li><a class="style2"  href="<?php echo $backwardseperator;?>userManager.php">User Management</a>            </li>
	<li><a class="style2" href="<?php echo $backwardseperator;?>setpermission.php" target="_blank">Create Permission</a></li>
	<?php
	}
	
	
	?>
		  <li><a class="style2" >----------------------------</a></li>
		  <li><a class="style2" href="<?php echo $backwardseperator;?>resetPassword.php" target="_blank">Reset Password</a></li>

		</ul></li>
<?php
}
?>

<?php
if($helpMenu)
{
?>
<li><a href="#" class="style3 MenuBarItemSubmenu">Help</a>
<ul>
<?php
if($resetPassword){
?>
<li><a class="style2" href="<?php echo $backwardseperator;?>resetPassword.php" target="_blank">Reset Password</a></li>
<li><a class="style2" >----------------------------</a></li>
<?php
}
?>
<li><a class="style2" href="<?php echo $backwardseperator;?>softwares/FirefoxSetup3.0.11.exe">Download Firefox for Windows</a></li>
<li><a class="style2" href="<?php echo $backwardseperator;?>softwares/firefox-3.0.11.tar.bz2">Download Firefox for Linux</a></li>
<li><a class="style2" href="<?php echo $backwardseperator;?>softwares/Firefox3.0.11.dmg">Download Firefox for Apple</a></li>
<li><a class="style2" href="<?php echo $backwardseperator;?>softwares/printpdf-0.75-fx-win.xpi">Add PDF Printer</a></li>

</ul>
</li>
<?php
}
?>
</ul>     
	   </td>
  </tr>
</table>

<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"<?php echo $backwardseperator;?>SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
    </script>
