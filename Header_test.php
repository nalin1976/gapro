<?php 
//include "authentication2.inc";

include "HeaderConnector.php";
include "permissionProvider.php";
$xml = simplexml_load_file("${backwardseperator}config.xml");
//$xml = simplexml_load_file("../../config.xml");
$headerPub_AllowOrderStatus = $xml->SystemSettings->AllowOrderStatus;

$pub_projectpath = '/gapro/';
//include "commonPHP/setsession.php";



//$main_url_project = substr($_SERVER["REQUEST_URI"],1,strpos($_SERVER["REQUEST_URI"],'/',1)-1);
//if(isset($_SESSION["Server"]) && ($main_url_project==$_SESSION["Project"]))
//{
//		
///*	if(isset($_SESSION["Requested_Page"]))
//		$page = $_SESSION["Requested_Page"];
//	header("Location:${backwardseperator}$page");*/
//	//exit;
//}
//else
//{
//	
//	
//}
?>

<script src="<?php echo $backwardseperator;?>SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="<?php echo $backwardseperator;?>SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $backwardseperator;?>css/erpstyle.css" rel="stylesheet" type="text/css" />
<!--<link href="fr/css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css" />-->

<script src="<?php echo $backwardseperator;?>jquery-1.10.2.js"></script>
<script src="<?php echo $backwardseperator;?>jquery-ui-1.10.4.custom.min.js"></script>
<script src="<?php echo $backwardseperator;?>jquery-ui-1.10.4.custom.js"></script>


<!--<script src="<?php echo $backwardseperator;?>js/jquery-1.4.2.min.js"></script>
<script src="<?php echo $backwardseperator;?>js/jquery-ui-1.8.9.custom.min.js"></script>
<script src="<?php echo $backwardseperator;?>js/jquery-ui-1.8.9.custom.js"></script>-->



<script type="text/javascript">
	$(document).ready(function() {
		$('#butSave').keypress(function(e) {
			if(e.keyCode==13)
				$('#butSave').trigger('click');
		});
		$('#butDelete').keypress(function(e) {
			if(e.keyCode==13)
				$('#butDelete').trigger('click');
		});
		$('#butReport').keypress(function(e) {
			if(e.keyCode==13)
				$('#butReport').trigger('click');
		});
		$('#butNew').keypress(function(e) {
			if(e.keyCode==13)
				$('#butNew').trigger('click');
		});
		$('#butAdd').keypress(function(e) {
			if(e.keyCode==13)
				$('#butAdd').trigger('click');
		});
		/////////////////////
		
		$('.cboCountry').change(function() {
			
				//alert(this.form.id);
		});
		
	});
</script>

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
.menuLI{
	border-bottom:thin;
	border-bottom-width:thin;
	border-bottom-style:solid;
	border-bottom-color:#B35900;
}

.menuLI_Top{
	border-top:thin;
	border-top-width:thin;
	border-top-style:solid;
	border-top-color:#B35900;
}
-->
</style>
<script type="text/javascript" >
var xmlHttp;
function createXMLHttpRequestHeader() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

function changeFactoryId(id)
{
	var url = '<?php echo $backwardseperator;?>HeaderDB.php?id=changeCompany&factoryId=' + id;
	var htmlobj=$.ajax({url:url,async:false});
	changeCompanyRequest(htmlobj);	
}

function changeCompanyRequest(xmlHttp)
{
	var text = xmlHttp.responseText;
	window.location.reload();
}
</script>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css">
<body oncontextmenu="return false;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr bgcolor="#FFFFFF">
		<td width="12"></td>
      <td width="940" height="44">
	  <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td width="244" rowspan="2"><img src="<?php echo $backwardseperator;?>images/logo.gif" alt="" class="mainImage" onClick="clear();"  /></td>
            <td width="80" rowspan="2">&nbsp;</td>
            <td width="657" rowspan="2" class="tophead" id="companyName"></td>
            <td width="94" class="tophead" id="companyName"><span class="normalfnth2B">Welcome <span class="normalfnth2">
            <?php 
		
		//$SQL ="select useraccounts.intUserID, useraccounts.UserName from useraccounts, role, userpermission where useraccounts.intUserID =" . $_SESSION["UserID"] . " and role.RoleID = userpermission.RoleID and userpermission.intUserID = useraccounts.intUserID and role.RoleName = 'Administration'";
		$SQL = "select Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
		$result = $dbheader->RunQuery($SQL);
	
		while($row = mysql_fetch_array($result))
		{
			echo $row["Name"];
		}
		?>
!</span></span></td>
            <td width="100" class="tophead" id="companyName"><div   align="right"><a href="<?php echo $backwardseperator;?>logout.php"> <img  src="<?php echo $backwardseperator;?>images/logout.png" alt="Logout" width="92" height="25" border="0" class="noborderforlink" /></a> </div></td>
        </tr>
          <tr>
            <td colspan="2"  class="normalfnth2B" id="companyName"><div align="left"><span class="tophead"><select style="width:250px;visibility:<?php echo $value; ?>" name="cboCompany" id="cboCompany" onChange="changeFactoryId(this.value);">
              <?php 
				$sql = "SELECT
						companies.strName,
						companies.intCompanyID
						FROM
						companies
						Inner Join usercompany ON usercompany.companyId = companies.intCompanyID
						WHERE
						usercompany.userId =  '".$_SESSION["UserID"]."'";
				$result = $dbheader->RunQuery($sql);
				$compCount = mysql_num_rows($result);
				if($compCount<=1)
					$value = "hidden";

				while($row = mysql_fetch_array($result))
				{
					if($_SESSION['FactoryID']==$row['intCompanyID'])
						echo "<option selected=\"selected\" value=\"".$row["intCompanyID"]."\" >".$row["strName"]."</option>";
					else
						echo "<option value=\"".$row["intCompanyID"]."\" >".$row["strName"]."</option>";
				}
			?>
              </select>
            </span></div></td>
          </tr>
      </table>    </td>
  </tr>
    <tr>
	<td align="center" bgcolor="#FCB334" style="width:30px;"><a href="<?php echo $backwardseperator;?>main.php" title="Home"><img src="<?php echo $backwardseperator;?>images/house.png" alt="Home" width="16" height="16" border="0" /></a></td>
      <td bgcolor="#FCB334">
	  
	<ul id="MenuBar1" class="MenuBarHorizontal">
	<?php if ($addingMenu){?>
    	<li><a href="#" class="MenuBarItemSubmenu  style2">Master Data</a>
        <ul>
		<?php if($addStyleItems || $manageItemRequest || $manageItemRequestConfirmation || $materialDeletion || $canManageStyleSubCategories || $PP_AllowPriceList){?>
		<li><a class="style2 MenuBarItemSubmenu" href="#">Material Wizard</a>
        <ul>
			<?php if($addStyleItems){?>
        	<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itemWizard/Wizard.php?intCatNo=1">Fabric</a></li>
			<?php } ?>
			<?php if($addStyleItems){?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itemWizard/Wizard.php?intCatNo=2">Accessories</a></li>
			<?php } ?>
			<?php if($addStyleItems){?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itemWizard/Wizard.php?intCatNo=4">Services</a></li>
			<?php } ?>
			<?php if($addStyleItems){?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itemWizard/Wizard.php?intCatNo=3">Packing Materials</a></li>
			<?php } ?>
			<?php if($addStyleItems){?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itemWizard/Wizard.php?intCatNo=5">Other</a></li>
			<?php } ?>
			<?php if($addStyleItems){?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itemWizard/Wizard.php?intCatNo=6">Washing</a></li>
			<?php } ?>
			<?php if($addStyleItems){?>
				<li><a class="style2">-----------</a></li>
			<?php } ?>
			
			<?php if($materialDeletion){?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itemWizard/itemdeletionandsearch/itemdeletionandsearch.php?">Material Modify</a></li>
            <?php } ?>
            
            <?php if($PP_AllowPriceList) { ?>
            	<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/stylepricelist/pricelist.php?">Price List</a></li>
            <?php } ?>
				<li><a class="style2">-----------</a></li>
                
			<?php if($canManageStyleSubCategories) { ?>	
				<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itemWizard/manageCategories.php">Manage Categories</a> </li>
			<?php } ?>
			
			<?php if($manageItemRequest){?>				
				<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itemRequest/itemrequest.php">Item Request</a> </li>
			<?php }?>
			
			<?php if($manageItemRequestConfirmation){?>
				<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itemRequest/itemRequestConfirm/itemReqConfirm.php">Item Request Confirmation</a> </li>
			<?php }?>
			
              </ul>
            </li>	
			<?php
			}
			?>
            
<?php if($addgeneralItems){ ?>		
<li><a class="style2" href="#"> General Item Wizard</a> 
<ul>
<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itemwizardgeneral/Wizard.php"> Create Item</a> </li>
<?php if($genaraItemSearchAndDelete){ ?>
<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itemwizardgeneral/itemdeletionandsearch/itemdeletionandsearch.php"> Serch And Delete</a> </li>					
<?php } ?>
<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/genItemReorderLevel/itemwiseReorder.php">Reorder Level</a> </li>

<?php if($PP_AllowGenPriceList){?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/generalpricelist/genpricelist.php?">Price List</a></li>
<?php } ?>

</ul>
</li>
<?php } ?>
			
<?php 
if ($manageStoreLocations){?>            
	<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/stores/mainStores.php">Store Location Wizard</a></li>
<?php } ?>
			              
<!--Start - 28-02-2011 Account Addins-->
<?php if($paymentAddings){ ?>
<li><a class="style2" href="#">Accounts</a>
<ul>
	<?php if($bankform){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/banks/banks.php">Banks</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/branch/branch.php">Branch</a></li>
	<?php } ?>
	
	<?php if($batchCreationForm){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/Batch/BatchCreation.php">Batch Creation</a></li>
	<?php } ?>
	
	<?php if($creditPeriodForm){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/CreditPeriod/CreditPeriodEntry.php">Credit Period</a></li>
	<?php } ?>
	
	<?php if($currencyForm){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/currency/Currency.php">Currency</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/exchangeRate/exchangeRate.php">Exchange Rate</a></li>
	<?php } ?>		
	
	<?php if($manageCostCenters){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/costcenter/costcenter.php">Cost Centers</a></li>
	<?php } ?>
	
	<?php if($glCreationForm){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/AccpacDetails/addGL.php">GL Account Creation</a></li>
	<?php } ?>
	
	<?php if($glAllocationForFactory){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/AccpacDetails/glAllocation.php">GL Allocation for Cost Center</a></li>
	<?php } ?>
	
	<?php if($glAllocationForSupplier){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/AccpacDetails/GLAllocationforSuppliers.php">GL Allocation for Supplier</a></li>
	<?php } ?>
	
	<?php if($manageAlloGlToItem){?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/budget/allocatetomaincat/allocatetomain.php">Assign GL Accounts To Main Category</a></li>
	<?php }?>
					
	<?php if($paymentModeForm){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/PayMode/PayMode.php">Payment Mode</a></li>
	<?php } ?>
	
	<?php if($paymentTermForm){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/PayTerm/PayTerm.php">Payment Term</a></li>
	<?php } ?>
	
	<?php if($taxTypeForm){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/tax/taxType.php">Tax Types</a></li>
	<?php } ?>
	
	<?php if($manageChequeInformation){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/chequeInfo/chequeInfo.php">Cheque Infomation</a></li>
	<?php } ?>
	
</ul>
</li>
<?php } ?>
<!--End - 28-02-2011 Account Addins   -->
			
			<?php if($manageSuppliers){?>
             <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itemGroup/itemGroup.php">Item Group</a></li>
			 <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/Supplies/Supplies.php">Suppliers</a></li>
			 <li><a class="style2" href="<?php echo $backwardseperator;?>SupplierWiseItems/supplierWiseItems.php">Supplier Wise Items</a></li>			
			<?php
			}
			if($buyerform)
			{
			?>
              <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/buyers/buyers.php">Buyers</a></li>
			<?php 
			}
			?>
			<?php if($colorForm){?>
				<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/Colors/Colors.php">Colors</a></li>
			<?php
			}
			$sizeForm=false;
			if($sizeForm)
			{
			?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/size/size.php">Size</a></li>
			<?php 
			}
			if($subContratorForm)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/subContractor/subcontractor.php">Subcontractors</a></li>
			   <?php 
			}
			$shippingAgentForm=false;
			if($shippingAgentForm)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/shipingagents/shipingagents.php">Shiping Agents</a></li>
			  <?php
			  }
			 if($payeeForm)
			  {
			  ?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/payee/payee.php">Payee</a></li>
			
			<?php
			  }
			 // $eventTemplate=false;
			  if($eventTemplate)
			  {
			  ?>
			  <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/eventTemplates/eventtemplates.php">Event Templates</a></li>
			  <?php
			  }
			  if($countryForm)
			{
			?>
			  <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/country/countries.php">Country</a></li>
			<?php 
			}
			if($seasonForm)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/seasons/Seasons.php">Seasons</a></li>
			<?php 
			}
			if($departmentForm)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/department/Department.php">Departments</a></li>
			 <?php 
			}
			if($shipmentTerms)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/shipmentterm/shipmentTerm.php">Shipment 
              Terms</a></li>
			  <?php 
			}
			if ($shippmentModeForm)
			 {
			 ?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/shipment/shipment.php">Shipment Mode</a></li>
			<?php
			 }
			 $GRNExcessQuantity=false;
			 if ($GRNExcessQuantity)
			 {
			 ?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/grn/grn.php">GRN Excess Qty</a></li>
			<?php
			 }
			
			
			
			if($unitForm)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/units/Units.php">Units</a></li>
			  <?php 
			}
			
			  //$eventSchedule=false;
			  if($eventSchedule)
			  {
			  ?>
			  <li><a class="style2" href="#">Events</a>
			 	<ul>
					<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/events/eventschdl.php">Events</a></li>
					<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/group/group.php">Groups</a></li>
					<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/userEvents/userEvents.php">User Events</a></li>
					<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/groupEvents/groupEvents.php">Group Events</a></li>
				</ul>
				</li>
			 <?php
			  }
			  
			  if($purchaseTypeForm)
			  {
			  ?>
              <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/itempurchase/itempurchase.php">Origin Types</a></li>
			   <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/chequeInfo/chequeInfo.php">Cheque Infomation</a></li>
			  <?php
			  }
			  ?>            
			  
			 <?php
			 if($quotaCategoryForm)
			 {
			 ?>
           <!-- <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/Quota Categories/quotacat.php">Quota Categories</a></li>-->
			  <?php
			 }
			 ?>
			 
			 <?php
			 if($manageProductCategory)
			 {
			 ?>
			 	<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/productcaregory/productcategory.php">Product Categories</a></li>
			 <?php
			 }
			 ?>
			 
			 <?php if($manageUnitConversion){ ?>
			 	<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/UnitConversions/unitConversion.php">Unit Conversion</a></li>
			 <?php } ?>
			 
			 <?php  if($manageAddinsFirstSale){ ?>
			 	<li><a class="style2" href="#">First Sale</a>
				<ul>
					<?php  if($manageAddinsFSItemAllocation){ ?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>firstsale/masterdata/formulaAllocation/formulaAllocation.php">Item Allocation</a></li>
					<?php } ?>
                    <li><a class="style2" href="<?php echo $backwardseperator;?>firstsale/holidayCalendar/holidayCalendar.php">Holiday Calendar</a></li>
				</ul>
				</li>
		 	<?php } ?>
			
			<?php if($manageWasDryProcess){?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/addins/drywash/drywash.php">Process</a></li>
		<?php }?>

			<?php if($PP_allowAddingFinishing) {?>
				<li><a class="style2" href="#">Finishing</a>
				<ul>
					<?php if($PP_allowAddingDestinations) {?>
						<li><a class="style2" href="<?php echo $backwardseperator;?>finishing/destinations/destination.php">Destinations</a></li>
					<?php }?>
					<?php if($PP_allowAddingBranchNetwork) {?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>finishing/buyerbranchnetwork/buyerbranchnetwork.php">Branch Network</a></li>
					<?php }?>
					<?php if($PP_allowAddingNotifyParties) {?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>finishing/notifyparty/notifyparty.php">Notify Parties</a></li>
					<?php }?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>finishing/forwaders/forwaders.php">Forwaders</a></li>
				</ul>
				</li>
			<?php }?>
			
			<?php if($PP_manageWIPValuation){?>
				<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/wipValuation/cuttingvalue.php">WIP Valuation</a></li>
			<?php }?>
			
			<?php if($seasonForm){?>
				<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/Quality/Quality.php">Quality</a></li>
			<?php }?>
            
            <?php if($PP_AllowReasonCodes){?>
				<li><a class="style2" href="<?php echo $backwardseperator;?>addinns/reasonCodes/reasonCodes.php">Reason Codes</a></li>
			<?php }?>
          </ul>
		  
        </li>
		<?php
		}
		if ($merchandising)
		{
		?>
        <li><a href="#" class="MenuBarItemSubmenu style3">Merchandising</a>
          <ul>
		<?php if($manageOrderInquiry) { ?>
		 		<li><a class="style2" href="<?php echo $backwardseperator;?>orderInquiry.php">Order Inquiry</a>
			<?php } ?>
			
		<?php if ($preorderCosting) { ?>			
            <li><a class="style2 MenuBarItemSubmenu" href="#">Pre Order Costing</a>
              <ul>
			  	<?php if ($manageCostingSheet) { ?>
                	<li><a class="style2" href="<?php echo $backwardseperator;?>Preorder.php">New Sheet</a></li>
                	<li><a class="style2" href="<?php echo $backwardseperator;?>editpreorder.php">Edit Sheet</a></li>
				<?php } ?>
				
				<?php if ($PP_ManageOrderNoChange) { ?>
                	<li ><a class="style2" href="<?php echo $backwardseperator;?>changestylename/changeorder.php">Change Order No</a></li>
				<?php } ?>				
				
				<?php if ($approvalPreOrder) { ?>
                <li class="menuLI"><a class="style2" href="<?php echo $backwardseperator;?>pendingCostSheets.php">Approval Pre Order</a></li>
				<?php } ?>
				
				<?php if ($PP_AllowRecutProcess) { ?>
                <li ><a class="style2" href="<?php echo $backwardseperator;?>reCut/recutpreorder.php">Recut Cost Sheet</a></li>
				<li ><a class="style2" href="<?php echo $backwardseperator;?>reCut/pendingRecutList.php">Recut Approval List</a></li>
				<?php } ?>
                 <li><a class="style2" href="<?php echo $backwardseperator;?>styleproccess.php">Style Proccess</a></li>
              </ul>
            </li>
			
			<?php
			}
			if ($bomForm)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>bom.php">Bill of Material-BOM</a></li>
			<?php
			}
			if($purchaseorderforms)
			{
			?>
			<li><a class="style2">Purchase Order</a>
			 <ul>
                  <li><a class="style2"  href="<?php echo $backwardseperator;?>Purchaseorder.php">Normal PO</a></li>
                  <?php
                  if($confirmPO)
                  {
                  ?>
						<li><a class="style2"  href="<?php echo $backwardseperator;?>POConfirmation.php">PO Confirm</a></li>
						<?php
						}
						 if($canChangePO)
          			{
          			?>
 						<li><a class="style2" href="<?php echo $backwardseperator;?>changePOList.php">Confirmed PO Correction</a></li>
          			<?php
						}
						 if($canValidatePOs)
                  		{
						?>
						<li><a class="style2"  href="<?php echo $backwardseperator;?>POValidation.php">Pending PO Validation</a></li>
						<?php
						}
			if($canValidatePOs)
                  		{
						?>
						<li><a class="style2"  href="<?php echo $backwardseperator;?>pendingPOcacel.php">Pending PO Cancelation</a></li>
						<?php
						}
						?>
				  <li class="menuLI"><a class="style2"  href="<?php echo $backwardseperator;?>PoPartialCancellation/partialCancellation.php">Confirmed PO Partial Cancellation</a></li>
				
				<?php /*?><?php if($PP_AllowExcessPOFirstApproval) { ?>
				<li class="menuLI"><a class="style2"  href="<?php echo $backwardseperator;?>GRN/expoconfirmation/expolisting.php">Excess PO First Approval</a></li>
				<?php } ?><?php */?>
                <?php if($PP_AllowExcessPOFirstApproval) { ?>
				<li class="menuLI"><a class="style2"  href="<?php echo $backwardseperator;?>GRN/expoconfirmation/expolisting.php">Excess PO Approval</a></li>
				<?php } ?>
				
				<?php /*?><?php if($PP_AllowExcessPOSecondApproval) { ?>
				<li class="menuLI"><a class="style2"  href="<?php echo $backwardseperator;?>GRN/expoconfirmation/exPoBomExceedListing.php">Excess PO Second Approval</a></li>
				<?php } ?><?php */?>
				
                <li ><a class="style2" >Bulk Purchase</a>
			  	  <ul>
					  <li><a class="style2" href="<?php echo $backwardseperator;?>BulkPo/bulkPo.php">Bulk Purchase</a></li>
					  <li><a class="style2" href="<?php echo $backwardseperator;?>BulkPo/bulkPoList.php">Bulk Purchase Listing</a></li>
				  </ul>
				  </li>
              </ul>
			</li>
			<?php
			}
			if($styleRevision)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>ReviceOrderList.php">Revise Styles</a></li>
			<?php
			}
			if($styleCompletion)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>ordercompletion/ordercompletion.php">Order Completion</a></li>
			<?php
			}
			if($orderCancellation)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>orderCancellation.php">Cancel Orders </a></li>
			<?php
			}
			if ($manageStyleBuyerPO)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>styleBuyerPO.php">Style-Buyer PO Nos</a></li>
			<?php
			}
			if($checkStatusForm)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>checkstatus/checkstatus.php">Check Status</a></li>
            <?php
            }
			if($manageApproveAndAthorisInterJob)
			{
			?>	 
            <li><a class="style2" href="<?php echo $backwardseperator;?>InterJobTransfer/approve/approveinterjob.php">Interjob Authorization</a></li>	
			<?php
			}
			//$viewEventSchedule=false;
			if ($viewEventSchedule)
			{
			?>		
            <li><a class="style2" href="#">Event Schedule</a>
				<ul>
					<?php if($manageEventSchedules){?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>EventSchedule/ManageSchedule.php">Manage Event Schedule</a></li>
					<li><a class="style2" href="<?php echo $backwardseperator;?>EventSchedule/approve/pendingapproveeventschedule.php">Approve Event Schedule</a></li>
					
					<li><a class="style2" href="<?php echo $backwardseperator;?>EventSchedule/revise/reviseshedule.php">Revice Event Schedule</a></li>
					<?php } ?>
					
					<?php if($allowApproveEventSchedule){?>
					 <li><a class="style2" href="<?php echo $backwardseperator;?>EventSchedule/approve/pendingapproveeventschedule.php">Approve Event Schedule</a></li>
					 <?php }?>
					 <?php if($allowReviceEventSchedule){?>
					 <li><a class="style2" href="<?php echo $backwardseperator;?>EventSchedule/revise/reviseshedule.php">Revice Event Schedule</a></li>
					 <?php }?>
				</ul>
			</li>
			<?php
			}
			if($manageCostingSheet)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>copyorder.php">Copy Order</a></li>
			<?php
			}
			if($styleTransfer)
			{
			?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>styleTransfer.php">Merchandiser Transfer</a> </li>
			
			<?php
			}
			?>
			
			<?php 
			if($manageInvoiceCosting){
			?>
				<li><a class="style2" href="#">Invoice Costing</a>
				<ul>
					<?php if($manageInvoiceCostingMain){?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>invoiceCosting/Cost/invoiceCost.php">Invoice Costing</a></li>
					<?php }?>
					<?php if($manageInvoiceCostingList){?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>invoiceCosting/Cost/invoiceCostList.php?ReportPlace=I">Invoice Costing List</a></li>
					<?php }?>
                    
                    <?php if($PP_AllowSampleNonInvoiceApproval){?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>invoiceCosting/Cost/samplenoninvoice.php?ReportPlace=I">Sample Non Invoice Approval List</a></li>
					<?php }?>
				</ul>
				</li>
			<?php
			}
			?>
			
			<?php if($manageMonthlyShipmentSchedule || $manageWeeklyShipmentSchedule) {?>
			<li><a class="style2" href="#">Shipment Schedule</a>
			<ul>
				<?php if($manageMonthlyShipmentSchedule) { ?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>finishing/schedule/month/monthShipSchedule.php">Monthly</a>
				<?php } ?>
				
				<?php if($manageWeeklyShipmentSchedule) { ?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>Shipmentforcast.php">Weekly</a>
				<?php } ?>
			</ul></li>	
			<?php } ?>
			
			<?php if($manageManageFabricRecap) { ?>
				<li><a class="style2" href="<?php echo $backwardseperator;?>fabRecap/fabRecap.php">Fabric Recap</a>
			<?php } ?>
			
			<?php if($manageShippingData) { ?>
				<li><a class="style2" href="<?php echo $backwardseperator;?>finishing/orderdata/shippingorderdata.php">Shipment Specification</a>
			<?php } ?>
			
			<?php if($PP_manageLCRequest) { ?>
				<li><a class="style2"  href="<?php echo $backwardseperator;?>booking/booking.php">Booking</a></li>
				<li><a class="style2" href="#">LC Request</a>
				<ul>
                	<li><a class="style2" href="<?php echo $backwardseperator;?>LCRequest/pi_uploadDetails/lc_upload.php">UploadOrder Details</a>
                    <li><a class="style2" href="<?php echo $backwardseperator;?>LCRequest/pi_uploadDetails/lcRequestData.php">View Order Details</a>
                    <?php if($PP_CreateImportLogBatch) { ?>
                    <li><a class="style2" href="<?php echo $backwardseperator;?>LCRequest/pi_uploadDetails/emportLCdata.php">Create Batches</a>
                    <?php } ?>
					<!--<li><a class="style2" href="<?php echo $backwardseperator;?>LCRequest/lcRequest.php">Allocate Orders</a>
					<li><a class="style2" href="<?php echo $backwardseperator;?>LCRequest/editLcRequest.php">Edit Request</a>
					<li><a class="style2" href="<?php echo $backwardseperator;?>LCRequest/lcRequestList.php">Listing</a>-->
				</ul></li>
			<?php } ?>
			
			<?php if($PP_AllowLeftOverReservation) { ?>
				<li><a class="style2" href="<?php echo $backwardseperator;?>leftoverReservation/leftoverReservation.php?">Left Over Reservation</a></li>
			<?php } ?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>styleBuyerPO.php">Style BuyerPO</a>
		  </ul>
        </li>
		<?php
		}		
		?>
		<?php
		if($inventory)
		{
		?>
		<li><a href="#" class="style3 MenuBarItemSubmenu">Inventroy</a>
          <ul>     
	<?php if($generalInventory){?>
		<li><a class="style2" >General</a>
        <ul>
		<?php if($managePR){?>
			<li><a class="style2" href="#">Purchase Requisition</a>
			<ul>
				<li><a class="style2" href="<?php echo $backwardseperator;?>purchaserequisition/purchaserequisition.php">Create New</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>purchaserequisition/purchaserequisitionlisting.php">Listing</a></li>
			</ul>
			</li>
		<?php } ?>
		
		<?php if($generalPO){?>
			<li><a class="style2" href="#">Purchase Order</a>
			<ul>
				<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralPO/generalPo.php">Create New</a></li>	  
				<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralPO/generalPoList.php">Listing</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralPO/itemcancelation/partialCancellation.php">Partial Cancellation</a></li>
			</ul>
			</li>
		<?php } ?>
			  
		<?php if($generalgrn){?>
			<li><a class="style2" href="#">GRN</a>
			<ul>
			<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralGRN/Details/gengrndetails.php">Create New</a></li>
			<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralGRN/pending/genpendingGRN.php">Listing</a></li>
			</ul>
			</li>
		<?php } ?>
		
		<?php if($generalGatePass){ ?>
			<li><a class="style2" href="#">Gate Pass</a>
			<ul>
				<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralGatePass/gengatepass.php">Create New</a></li>
            	<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralGatePass/gengatepasslist.php">Listing</a></li>
			</ul>
			</li>
			
			<li><a class="style2" href="#">Gate Pass TransferIn</a>
			<ul>
				<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GenGatePassTranferIn/gentranferin.php">Create New</a></li>
            	<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GenGatePassTranferIn/gentranferinlist.php">Listing</a></li>
			</ul>
			</li>
		<?php } ?>
		
		<?php if($generalMrn){?>
			<li><a class="style2" href="#">MRN</a>
			<ul>
       		<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralRequisition/genMaterialRequisition.php">Create New</a></li>
       		<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralRequisition/genRequisitionList.php">Listing</a> </li>
			</ul>
			</li>
		<?php } ?>
		
		<?php if($generalIssues){ ?>
			<li><a class="style2" href="#">Issue</a>
			<ul>
              <li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralIssue/genissues.php">Create New</a></li>
              <li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralIssue/genissueslist.php">Listing</a></li>
			</ul>
			</li>			
		<?php } ?>
		
		<?php if ($generalRetunToStore){ ?>
			<li><a class="style2" href="#">Return to Stores</a>
			<ul>
				<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralReturn/genreturn.php">Create New</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralReturn/genreturnlist.php">Listing</a></li>
			</ul>
			</li>
		<?php } ?>
		
		<?php if($generalRetunToSupplier){ ?>
			<li><a class="style2" href="#">Return to Supplier</a>
			<ul>
              <li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralSupplierReturn/gensupplierreturn.php">Return to Supplier</a></li>
              <li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralSupplierReturn/gensupplierreturnlist.php">Listing</a>        </li>
			</ul>
			</li>
		<?php } ?>
		
		<?php if($generalInventory){ ?>
			<li><a class="style2" href="#">Normal Gate Pass</a>
			<ul>
				<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GenNormalGatepass/gennormalgatepass.php">Create New</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GenNormalGatepass/gennormalgatepasslist.php">Listing</a></li>
			</ul></li>
		<?php } ?>
		
         <?php if($PP_AllowGenItemTransfer){ ?>
			  <li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/ItemTranfer/itemTransfer.php">Item Transfer</a></li>
		<?php } ?>
        
         <?php if($PP_AllowGeneralChemicalItemAllocation){ ?>
			  <li title="Allocate two or more chemical items and create a new item"><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/ChemicalAllocation/chemicalAllocation.php">Chemical Allocation</a></li>
		<?php } ?>
        
		<?php if ($generalCheckStatus){ ?>
              <!--<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/GeneralCheckstatus/checkstatus.php">Check Status </a></li>-->
			  <li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/generalStockBalance/stockBalance.php">Stock Balance</a></li>
		<?php } ?>
        	<li><a class="style2" href="<?php echo $backwardseperator;?>GeneralInventory/Reports/stylereports.php">Reports</a></li>
       	</ul>
        </li>
	
	<?php  } ?>
	
	<?php if($grn){ ?>       
			<li><a class="style2 " >GRN</a>
			<ul>
				<li><a class="style2" href="<?php echo $backwardseperator;?>GRN/Details/grndetails.php?id=0">GRN Details</a></li>
				<li class="menuLI"><a class="style2" href="<?php echo $backwardseperator;?>GRN/pending/pendingGRN.php">GRN Listing</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>BulkGRN/Details/grndetails.php">Bulk GRN Details</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>BulkGRN/pending/pendingGRN.php">Bulk GRN Listing</a></li>
			</ul>
			</li>
			<?php
			}
			if($PP_TrimInspection)
			{
			?>
			<li><a class="style2"  href="#">Trim Inspection</a>
			<ul>
            <?php if($PP_AllowTrimInspection) { ?>
				<li><a class="style2"  href="<?php echo $backwardseperator;?>TrimInspection/TrimInspactionGrnWise.php">Inspection</a></li>
			<?php } ?>
            
			<?php if($PP_AllowSpecialTrimInspection) { ?>
				<li><a class="style2"  href="<?php echo $backwardseperator;?>TrimInspection/RejectTrimInspection/RejectTrimInspection.php">Special Approval</a></li>
			<?php } ?>
            
            <?php if($PP_AllowTrimInspectionListing) { ?>
				<li><a class="style2"  href="<?php echo $backwardseperator;?>TrimInspection/listing/triminspectlist.php">Listing</a></li>
         	<?php } ?>	
			</ul>
			</li>
			 <?php
			 }
			 if($mrn)
			 {
			 ?>
			<li><a class="style2 " >MRN</a>
			<ul>
				<li><a class="style2" href="<?php echo $backwardseperator;?>MaterialRequisition.php?id=0">MRN Details</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>pendingMRNlistRpt.php">MRN Listing</a></li>
			</ul>
			</li>
			 <?php
			 }
			// $canMRNClearance = false;
			 if($canMRNClearance)
			 {
			 ?>
			 <li><a class="style2"  href="<?php echo $backwardseperator;?>mrnclearance/mrnclearance.php">MRN Clearance</a></li>
			 <?php
			 }
			 if($issues)
			 {
			 ?>
			 <li><a class="style2"  href="<?php echo $backwardseperator;?>issue/issues.php">Issue</a></li>
			 <?php
			 }
			 if($gatePass)
			 {
			 ?>
			 <li><a class="style2" >Gate Pass</a>
			<ul>
				<?php if($PP_AllowStyleGatePass) { ?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>StyleItemGatePass/styleItemGatePass.php">Style</a></li>
					<li class="menuLI"><a class="style2" href="<?php echo $backwardseperator;?>StyleItemGatePass/Details/gatePassDetails.php">Style Listing</a></li>
				<?php } ?>
				
				<?php if($PP_AllowBulkGatePass) { ?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>bulkgatepass/bulkgatepass.php">Bulk</a></li>
					<li class="menuLI"><a class="style2" href="<?php echo $backwardseperator;?>bulkgatepass/bulkgatepasslist.php">Bulk Listing</a></li>
				<?php } ?>
		
				<?php if($PP_AllowLeftOverGatePass) { ?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>leftover/leftovergatepass/leftovergatepass.php">LeftOver</a></li>
					<li><a class="style2" href="<?php echo $backwardseperator;?>leftover/leftovergatepass/leftovergatepasslist.php">LeftOver Listing</a></li>
				<?php } ?>
			</ul>
			</li>
			<?php
			}
			if($gatePassTransferring)
			{
			?>
			<li><a class="style2" >Gate Pass Transferring</a>
			<ul>
				<?php if($PP_AllowStylerGatePassTI) { ?>
				<li><a class="style2" href="<?php echo $backwardseperator;?>GatePassTrasferIn/GPtransferIn.php">Style</a></li>
				<li class="menuLI"><a class="style2" href="<?php echo $backwardseperator;?>GatePassTrasferIn/Details/TransferInDetails.php">Style Listing</a></li>
				<?php } ?>
				
				<?php if($PP_AllowBulkGatePassTI) { ?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>bulkgatepasstranferin/bulkgatepasstranferin.php">Bulk</a></li>
					<li class="menuLI"><a class="style2" href="<?php echo $backwardseperator;?>bulkgatepasstranferin/bulkgatepasstranferinlist.php">Bulk Listing</a></li>
				<?php } ?>
		
				<?php if($PP_AllowLeftOverGatePassTI) { ?>
					<li><a class="style2" href="<?php echo $backwardseperator;?>leftover/leftovertransferin/leftovertransferin.php">LeftOver</a></li>
					<li><a class="style2" href="<?php echo $backwardseperator;?>leftover/leftovertransferin/leftovertransferin.php">LeftOver Listing</a></li>
				<?php } ?>
		      </ul>
			</li>
			<?php
			}
			if($returnToStore)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>returntostores/returntostores.php">Return to Stores</a></li>
			<?php
			}
			if($returnToSupplier)
			{
			?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>returntosupplier/returntosupplier.php">Return to Supplier</a></li>
			<?php
			}
			if($orderStatusForm)
			{
			?>
            <li><a class="style2" href="<?php echo $backwardseperator;?>orderstatus.php">Order Status</a></li>
			<?php
			}
			if($fabricInspection)
			{
			?>
<li><a class="style2" href="<?php echo $backwardseperator;?>FabricInspection/FabricInspection.php">Fabric Inspection</a></li>
<?php
}
if($fabricRollInspection)
			{
			?>
<li><a class="style2" href="<?php echo $backwardseperator;?>fabricrollinspection/fabricrollinspection.php">Fabric Roll Inspection</a></li>
<?php
}
if($interJobTransfer)
{
?>
          <li><a class="style2" href="<?php echo $backwardseperator;?>InterJobTransfer/materialsTransfer.php" >Inter Job Transfer</a></li>
		  <?php
		  }
		  	 if($normalGatepass)
			  {
			  ?>
			  <li><a class="style2 MenuBarItemSubmenu" href="#">Normal</a>
			    <ul>
			      <li><a class="style2" href="<?php echo $backwardseperator;?>NormalGatepass/nomgatepass.php">Normal Gatepass</a></li>
		          <li><a class="style2" href="<?php echo $backwardseperator;?>NormalGatepass/nomgatepasslist.php">Normal Gatepass Listing</a></li>
			    </ul>
			  </li>
          <?php
			  }	  
		  ?>
		  	  <?php
		  	  if($binToBinTransfer)
		  	  {
		  	  	?>
			 <li><a class="style2" href="#">Bin To Bin Transfer</a>
			 <ul>
			<li><a class="style2" href="<?php echo $backwardseperator;?>binToBinTransfer/binToBinTransfer.php">Style</a></li>
			<li><a class="style2" href="<?php echo $backwardseperator;?>bintobintransfer_leftover/binToBinTransfer.php">Common Stock</a></li>
			 </ul>
			 </li>
		  <?php
		  }
		  ?>
		  
		<?php
		if($fabricRollApprove)
		{
		?>
				<li><a class="style2" href="<?php echo $backwardseperator;?>fabricrollinspection/fabricrollapprove/fabricrollapprove.php">Fabric Roll Approve</a></li>
		<?php
		}
		?>
		
		<?php if($PP_storesAllocation) { ?>
		<li><a class="style2" href="#">Allocation</a>
		<ul>
			<li><a class="style2" href="<?php echo $backwardseperator;?>allocation/leftover/lefetover.php">Left Over</a></li>
			<li><a class="style2" href="<?php echo $backwardseperator;?>allocation/bulk/bulklefetover.php">Bulk</a></li>
		</ul>
		</li>
		<?php } ?>
		
		<?php if($PP_storesItemDisposal) { ?>
		<li><a class="style2" href="#">Item Disposal</a>
		<ul>
		<li><a class="style2" href="<?php echo $backwardseperator;?>itemDispose/itemDispose.php">Dispose</a></li>
			<li><a class="style2" href="<?php echo $backwardseperator;?>itemDispose/itemDisposeListing.php">Listing</a></li>
		</ul>
		</li>
		<?php } ?>
				
		<?php if($PP_storesTransferNote) { ?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>StoresTransferNote/Note/storesTNote.php">Stores Transfer Note</a></li>
		<?php } ?>
		
		<?php if($editInvoiceNumberInGrn) { ?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>GRN/ChangeInvoiceNo/changeInv.php">Change Invoice Number</a></li>
		<?php } ?>
		
		<?php if($manageOpeningStock){?>
			<li><a class="style2" href="#">Adjust Stock</a>
				<ul>
					<li><a class="style2" href="<?php echo $backwardseperator;?>openingstock/style/ostockmain.php">Style</a></li>
				</ul></li>
		<?php }?>
		
		<?php if($manageTransferBulkStockFromOldERP){?>
			<li><a class="style2" href="#">Transfer Bulk Stock From Old ERP</a>
				<ul>
					<li><a class="style2" href="<?php echo $backwardseperator;?>bulkStockTransfer/bulkStockTransMain.php">Create New</a></li>
				</ul></li>
		<?php }?>
		
<?php if($PP_allowStoresOrderConfirmation) { ?>
<li><a class="style2" href="<?php echo $backwardseperator;?>ordercompletion/storesconfirmation/storesconfirmation.php?">Stores Order Completion</a></li>
<?php } ?>

<?php if($PP_allowItemWiseLeftOverForm) { ?>
	<li><a class="style2" href="#">Item Wise Left Over</a>
	<ul>
		<li><a class="style2" href="<?php echo $backwardseperator;?>leftover_itemwise/frmItemWiseLeftOver.php?">Create New</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>leftover_itemwise/itemWiseLeftOverList.php?">Listing</a></li>
	</ul>
	</li>
<?php } ?>
          </ul>
        </li>
		<?php
		}
		if($payments)
		{
		?>
        <li><a href="#" class="style3">Payments</a>
		 <ul>
		 <?php
			$withoutPO=false;
			if($withoutPO)
			{
			?>
			<li><a class="style2 MenuBarItemSubmenu" href="#">Without PO Payments</a>
              <ul>
			  <?php
			  if($withoutPOInvoice)
			  {
			  ?>
                <li><a class="style2" href="<?php echo $backwardseperator;?>PaymetsWithoutPO/withoutPOInvoice.php">Without PO Invoice</a></li>
				<?php
				}
				if($withoutPOScheduleForm)
				{
				?>
				<li><a class="style2" href="<?php echo $backwardseperator;?>PaymetsWithoutPO/withoutPOSchedule.php">Without PO Schedule</a></li>
				<?php
				}
				if($withoutPOVoucherForm)
				{
				?>
				<li><a class="style2" href="<?php echo $backwardseperator;?>PaymetsWithoutPO/withoutPOVoucher.php">Without PO Voucher</a></li>
				
				<li><a class="style2" href="<?php echo $backwardseperator;?>PaymetsWithoutPO/withoutPOVoucherFinder.php">Without PO Voucher Finder</a></li>
				<?php
				}
				?>
			 </ul>
            </li>
			<?php
			}
			if($advancePayments)
			{
			?>
            <li><a class="style2"  href="#">Advance Payment</a>
              <ul>
                <li><a class="style2"  href="<?php echo $backwardseperator;?>PaymentsM/advancedpayment.php">Advance Payments</a></li>
                <li><a class="style2"  href="<?php echo $backwardseperator;?>PaymentsM/advancePayment/advancePaymentFinder.php">Payment Listing</a> </li>
				 <li><a class="style2"  href="<?php echo $backwardseperator;?>PaymentsM/advance_payment_settlement.php">Payment Settlement</a> </li>
				  <li><a class="style2"  href="<?php echo $backwardseperator;?>PaymentsM/advancePayment/advancePaymentFinder.php">Advance Payment Finder</a> </li>
              </ul>
            </li>
			<?php
			}
			if($supplierInvice)
			{
			?>
			<li><a class="style2"  href="#">Supplier Invoice</a>
			  <ul>
			    <li><a class="style2"  href="<?php echo $backwardseperator;?>Payments/supplierInv.php">Supplier Invoice</a></li>
		        <li><a class="style2"  href="<?php echo $backwardseperator;?>Payments/supplierinvoice/supplierInvFinder.php">Supplier Invoice Listing</a>  </li>
			  </ul>
			</li>	
			<?php
			}
			if($paymentSchedule)
			{
			?>				
			<li><a class="style2"  href="<?php echo $backwardseperator;?>Payments/paymentSchedule.php">Payment Schedule</a></li>
			<?php
			}
			if ($paymentVoucher)
			{
			?>
			<li><a class="style2"  href="#">Payment Voucher</a>
			  <ul>
			    <li><a class="style2"  href="<?php echo $backwardseperator;?>Payments/paymentVoucher.php">Payment Voucher</a></li>
		        <li><a class="style2"  href="<?php echo $backwardseperator;?>Payments/paymentVoucherFinder.php">Voucher Reports</a> </li>
		      </ul>
			</li>
			<?php
			}
			$chequePrinting = false;
			if($chequePrinting)
			{
			?>
            <li><a class="style2"  href="#">Cheque Printing</a>
              <ul>
                <li><a class="style2"  href="<?php echo $backwardseperator;?>Payments/chequePrinter.php">Print Cheques</a></li>
                <li><a class="style2"  href="<?php echo $backwardseperator;?>Payments/chequePrinterFinder.php">Cheques Search</a></li>
              </ul>
            </li>
			<?php } ?>
			
			<?php if($manageBudgetAddins){?>
			 <li><a class="style2"  href="#">Bugdet</a>
			 <ul>
			 	<li><a class="style2"  href="<?php echo $backwardseperator;?>budget/budgetmodification/budgetmodification.php">Modification</a></li>
				<li><a class="style2"  href="<?php echo $backwardseperator;?>budget/additionalbudget/additionalbudget.php">Additional</a></li>
				<li><a class="style2"  href="<?php echo $backwardseperator;?>budget/budgettransfer/budgettransfer.php">Transfer</a></li>
				<!--<li><a class="style2"  href="<?php echo $backwardseperator;?>budget/budgetactual/budgetactual.php">Actual</a></li>-->
				<!--<li><a class="style2"  href="<?php echo $backwardseperator;?>budget/bugdetforcast/budgetforcast.php">Forcast</a></li>-->
				<li><a class="style2"  href="<?php echo $backwardseperator;?>budget/budgetvsactual/budgetsvsactual.php">Budget Vs Actual</a></li>
				<li><a class="style2"  href="<?php echo $backwardseperator;?>budget/budgetreport/budgetreport.php">Reports</a></li>
			 </ul>
			 </li>
			<?php }?>
	      </ul>
		</li>
		<?php } ?>
		
		<?php if($production){?>
        <li><a href="#" class="style3 MenuBarItemSubmenu">Production</a>
          <ul>
		  <?php
		  if($cadConsumption)
		  {
		  ?>
			<li><a class="style2" >Cutting</a>
			<ul>
				<li><a class="style2" href="<?php echo $backwardseperator;?>production/component/componenteditor.php">Component</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>production/componentallocation/componentallocation.php">Style BreakDown</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>production/cutting/bundleentry/cuttingdataentry.php">Bundle Entry</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>production/cutting/gatepass/gatepass.php">GatePass</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>production/gpListing/gpListing.php">GP Listing</a></li>
                <li><a class="style2" href="<?php echo $backwardseperator;?>tukaExceReader/tuka.php">Consumption Sheet</a></li>
			</ul>
			</li>
			 <?php
		    }
		     ?>
			  <?php
		  if($cadConsumption1)
		  {
		  ?>
			 <li><a class="style2"  >Sewing</a>
              <ul>
			    <?php
		  if($sewing)
		  {
		  ?>
                <li><a class="style2" href="<?php echo $backwardseperator;?>production/cutPc/cutPC.php"  >GP Transfer In</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>production/transferinListing/transfrin.php"  >GPT In Listing</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>production/lineInput/cutPCNewInputEntry.php"  >Line Input</a></li>
				 <li><a class="style2" href="<?php echo $backwardseperator;?>production/inputListing/productionInput.php"  >Line In Listing</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>production/lineOutput/cutPCNewOutPutEntry.php"  >Line Output</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>production/lineOutListing/lineOutListing.php"  >Line Out Listing</a></li>
                <li><a class="style2" href="<?php echo $backwardseperator;?>production/factoryGatepasses/factoryGatepass.php"  >Factory GP</a></li>
				 <li><a class="style2" href="<?php echo $backwardseperator;?>production/finishGoodGPListing/finishGoodGP.php"  >FactoryGP Listing</a></li>
				 <?php
		  		}
		  	?>
				  <?php
		  if($washReady)
		  {
		  ?>
				<li><a class="style2" href="<?php echo $backwardseperator;?>production/productionwashready/washReady.php"  >Wash Ready</a></li>
				<li><a class="style2" href="<?php echo $backwardseperator;?>production/washReadyListing/washReadyListing.php"  >Wash Ready Listing</a></li>
				<?php
		  		}
		  	?>
				 <?php if($PP_AllowChangeFactoryGatePass) { ?>
				 <li><a class="style2" href="<?php echo $backwardseperator;?>production/correctFactoryGPHeader/index.php"  >Correct Factory GatePass</a></li>
				 <?php } ?>
              </ul>
            </li>
			 <?php
		  		}
		  	?>
			<?php
		  if($cadConsumption2)
		  {
		  ?>
            <li><a class="style2"  >CAD Consumption</a>
              <ul>
                <li><a class="style2" href="<?php echo $backwardseperator;?>CAD/cad.php"  >CAD Details</a></li>
                <li><a class="style2" href="<?php echo $backwardseperator;?>CAD/search.php"  >CAD Listing</a></li>
              </ul>
			</li>
		<?php
		   }
		  ?>
			<?php
		  if($defectEntry)
		  {
		  ?>
			 <li><a class="style2"  href="<?php echo $backwardseperator;?>production/cutDeffect/cutDeffect.php"  >Defect Entry</a></li>
		<?php
		   }
		  ?>
           <!-- </li>-->
		   <?php
		  if($cadConsumption3)
		  {
		  ?>
			 <li><a class="style2"  href="<?php echo $backwardseperator;?>production/wip/wip.php"  >Wip Reports</a></li>
             <li><a class="style2"  href="<?php echo $backwardseperator;?>production/wipnew/wip.php"  >Wip New Reports</a></li>
			 <?php
		 }
		  ?>
			<?php
			if($cutTicket)
			{
			?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>CutTicket/cutticket.php"  >Cut Ticket</a></li>
			<?php
			}
			?>
			<?php
			if($packingList)
			{
			?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>shipmentpackinglist/shipmentpackinglist.php"  >Packing List</a></li>
			 <?php
		 	}
		 	 ?>
			 <?php
			if($gatePassReturn)
			{
			?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>production/sewinggatepass/sewinggatepass.php">GatePass Return</a></li>
			 <?php
		 	}
		 	 ?>
            <li><a class="style2" >Monitor</a>
			<ul>
				<li><a class="style2" href="<?php echo $backwardseperator;?>production/charts/chart.html" target="_new">Line</a></li>
            </ul>   
          </ul>
        </li>
		<?php
		}
		?>
		
<?php if($manageWashing){ ?>	
<li><!--<a href="#" class="style3 MenuBarItemSubmenu">Washing</a>-->
<ul>
	<?php if($manageWasAdding){ ?>
	<li><a class="style2" href="#">Addins</a>
	<ul>
		<?php if($manageWasDryProcess){?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/addins/drywash/drywash.php">Process</a></li>
		<?php }?>
		<?php if($manageWasGarmentType){?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/addins/garmenttype/garmenttype.php">Garment Type</a></li>					
		<?php } ?>
		<?php if($manageWasOperator){?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/addins/operators/operators.php">Operators</a></li>
		<?php } ?>
		<?php if($manageWasWashFormula){?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/addins/washFormula/wFormula.php">Wash Formula</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/addins/chemicalallocation/chemicalallocation.php">Chemical Allocation</a></li>
		<?php } ?>
		<?php if($manageWasWashType){?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/addins/washType/washType.php">Wash Type</a></li>
		<?php } ?>
		<?php if($manageWasMachineType){?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/addins/machineType/machType.php">Machine Type</a></li>
		<?php } ?>
		<?php if($manageWasMachineCategory){?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/addins/wMachine/wMach.php">Machine Category</a></li>					
		<?php } ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/addins/outsidecompanies/companydetails.php">Outside Factory</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/addins/fabricdetails/fabricDetails.php">Fabric Details</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/outsidepo/outsidepo.php">Outside PO</a></li>		
	</ul>
	</li>
	<?php }?>

<?php
 if($PP_allowWashReceive){ ?>
<li><a class="style2" href="#">Wash Receive</a>
<ul>
	<li><a class="style2" href="<?php echo $backwardseperator;?>production/finishGoodsReceive/finishGoodsReceive.php">Create New</a></li>
	<li><a class="style2" href="<?php echo $backwardseperator;?>production/finishGDRecieveListing/finishGoodRcv.php">Listing</a></li>
	<li><a class="style2" href="<?php echo $backwardseperator;?>washing/washreceiveSummary/washReceiveSummaryList.php">Summary</a></li>
</ul>
</li>
<?php } ?>

<?php if($PP_allowReturnToFactory){ ?>
<li><a class="style2" href="#">Return To Factory</a>
<ul>
	<li><a class="style2" href="<?php echo $backwardseperator;?>washing/returnToFactory/retrunToFactory.php">Create New</a></li>
	<li><a class="style2" href="<?php echo $backwardseperator;?>washing/returnToFactoryList/returnToFactoryList.php">Listing</a></li>
</ul></li>
<?php } ?>

	<?php if($PP_allowExternalGatePass){ ?>
	<li><a class="style2" href="#">External GatePass</a>
	<ul>
		<li><a class="style2" href="<?php echo $backwardseperator;?>production/washing_factoryGatepass/factoryGatepass.php">Create New</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>production/washing_factoryGatepassListing/finishGoodGP.php">Listing</a></li>
	</ul>
	</li>
	<?php } ?>
		
	<?php if($PP_manageSubContract){  ?>
	<li><a class="style2" href="#">Sub Contract</a>
	<ul>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/subcontract/subcontract.php">Create New</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/subcontractorList/subContractList.php">Listing</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/subcontract/subcontractDet.php">Log</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/subcontract/OutSideWip.php">WIP</a></li>
	</ul></li>
	<?php } ?>
	
	<?php if($manageWasIssuedToWash){  ?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>washing/issuedWash/issuedWash.php">Issued To Washing</a>
	<ul>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/issuedWash/issuedWash.php">New</a>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/issuedWashList/issuedwashList.php">Listing</a>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/issuedWash/todayReceive.php">Production Report</a>
	</ul></li>
	<?php } ?>
	
	<?php if($manageWasWashPrice){ ?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>washing/washprice/washPrice.php">Wash Price</a></li>
	<?php } ?>
	
	<?php if($manageWasBudgetCost){ ?>
	<li><a class="style2" href="#">Budgeted Cost Sheet</a>
	<ul>
		<?php if($manageWasBudgetCostForm) { ?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>washing/budgetCost/budgetCost.php">Create New</a></li>
		<?php } ?>
		<?php if($manageWasBudgetCostList) { ?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>washing/budgetCost/budgetCostList.php">Listing</a></li>
		<?php } ?>
	</ul></li>
	<?php } ?>
	
	<?php if($manageWasActualCost){ ?>
	<li><a class="style2" href="#">Actual Cost Sheet</a>
	<ul>
		<?php if($manageWasActualCostListForm) { ?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>washing/actualcost/actualcost.php">Create New</a></li>
		<?php } ?>
		<?php if($manageWasActualCostList) { ?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>washing/actualcost/actualCostList.php">Listing</a></li>
		<?php } ?>
	</ul></li>
	<?php } ?>
	
	<?php if($PP_manageChemicalInventory){ ?>
	<li><a class="style2" href="#">Inventory</a>
	<ul>
	<li><a class="style2" href="<?php echo $backwardseperator;?>washing/chemicalrequisition/chemicalrequisition.php">Chemical Requisition</a></li>
	<li><a class="style2" href="<?php echo $backwardseperator;?>washing/chemicalissue/chemicalissue.php">Chemical Issue</a></li>
	</ul>
	</li>
	<?php }?>
	
	<?php if($PP_allowInternalGatePass){ ?>
	<li><a class="style2" href="#">Internal GatePass</a>
	<ul>
		<li><a class="style2" href="#">GatePass</a>
		<ul>
			<li><a class="style2" href="<?php echo $backwardseperator;?>washing/issuedToOtherFactories/issuedToOther.php">Create New</a></li>
			<li><a class="style2" href="<?php echo $backwardseperator;?>washing/issuedToOtherFactoriesList/internalGpList.php">Listing</a></li>
		</ul>
		</li>
		<li><a class="style2" href="#">GatePass TransferIn</a>
		<ul>
			<li><a class="style2" href="<?php echo $backwardseperator;?>washing/rcvFromOtherFactories/rvcdToOther.php">Create New</a></li>
			<li><a class="style2" href="<?php echo $backwardseperator;?>washing/rcvdFromOtherFactoriesList/internalGpTransferInList.php">Listing</a>										</li>
		</ul>
		</li>
	</ul>
	</li>
	<?php }?>
	
	<?php if($manageWasMachineLoading){ ?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>washing/washing_lotCreation/washing_lot_creation.php">Lot Creation</a></li>
	<li><a class="style2" href="<?php echo $backwardseperator;?>washing/rootCard/rootCard.php">Root Card</a></li>
	<?php } ?>
	<?php if($manageWasMachineLoading){ ?>
	<li><a class="style2" href="#">Machine Loading</a>
	<ul>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/machineLoading/machineLoading.php">Create New</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/machineLoading/machineLoadingList.php">Listing</a></li>
	</ul>
	</li>
	<?php } ?>
	
	<?php if($manageWasIssuedToFinishing){ ?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>washing/washIssues/washIssue.php">Issued To Finishing</a></li>
	<?php } ?>
	
	<?php if($PP_allowSample) {?>
	<li><a class="style2" href="#">Sample</a>
	<ul>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/mrn/mrnDetails.php">MRN</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/mrnList/mrnList.php">MRN Listing</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/issue/issuedetails.php">Issue</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/issueList/issueLis.php">Issue Listing</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/mrnReturn/mrnReturn.php">Return</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>washing/mrnReturnList/mrnReturnList.php">Return Listing</a></li>
	</ul>
	</li>
	<?php } ?>
	
	<?php if($PP_AllowChangeFactoryGatePass) { ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>production/correctFactoryGPHeader/index.php"  >Correct Factory GatePass</a></li>
	<?php } ?>
				 
	<?php if($manageWasWip){ ?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>washing/wip/Wip.php">WIP</a></li>
	<?php } ?>	
	
	<li><a class="style2" href="#">Reports</a>
	<ul>
		<!--<li><a class="style2" href="<?php echo $backwardseperator;?>washing/machineLoading/machineLoadingRpt.php">Machine Loading</a></li>-->
		<?php if($manageWasActualCostList) { ?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>washing/actualcost/actualCostList.php">Actual Cost</a></li>
		<?php } ?>
		
		<?php if($manageWasBudgetCostList) { ?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>washing/budgetCost/budgetCostList.php">Budget Cost</a></li>
		<?php } ?>
		
		<?php if($PP_AllowGatePassLog) { ?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>washing/factoryGPSendReceiveList/gpSendReceiveList.php">Gate Pass Log</a></li>
		<?php } ?>
		
		<?php if($PP_AllowWashingOrderBook) { ?>
			<li><a class="style2" href="<?php echo $backwardseperator;?>washing/washingOrderBook/storesWashingOrderBookReport.php">Order Book</a></li>
		<?php } ?>
	</ul></li>
</ul>
</li>
<?php } ?>

<?php if($managePlanningBoard){ ?>	
<li><a href="#" class="style3 MenuBarItemSubmenu">Planning</a>  
<ul>
	<li><a class="style2"  href="<?php echo $backwardseperator;?>planning/plan/plan.php">Planning Board</a></li>
	<li><a class="style2"  href="<?php echo $backwardseperator;?>planning/actual/actual.php">Actual Production</a></li>
	<li><a class="style2"  href="<?php echo $backwardseperator;?>planning/productionPlan/productionPlan.php">View Plan</a></li>
</ul>  
</li> 
<?php } ?>

<?php if($manageFixedAssetsManagement){ ?>
<li><a href="#" class="style3 MenuBarItemSubmenu">Fixed Ast. Mgt.</a>  
<ul>
	<li><a class="style2"  href="<?php echo $backwardseperator;?>fixedAssetsManagement/Fixedassets/Fixedassets.php">Fixed Assets</a></li>
	<li><a class="style2"  href="<?php echo $backwardseperator;?>fixedAssetsManagement/Fixedassetsrent/Fixedassetsrent.php">F. Assets Rent</a></li>
	<li><a class="style2"  href="<?php echo $backwardseperator;?>fixedAssetsManagement/Fixedassetsrentreturndetails/Fixedassetsrentreturndetails.php">F. Ast Return</a></li>
	<li><a class="style2"  href="<?php echo $backwardseperator;?>fixedAssetsManagement/Fixedassettransfer/Fixedassettransfer.php">F. Ast. Trans</a></li>
	<li><a class="style2"  href="<?php echo $backwardseperator;?>fixedAssetsManagement/Fixedassettransfernote/Fixedassettransfernote.php">FA Trans Note</a></li>
</ul>  
</li> 
<?php } ?>

<?php if($manageWorkStudy){ ?>
<li><a href="#" class="MenuBarItemSubmenu  style2">WorkStudy</a>
<ul>
				<li><a class="style2"  href="#">Master Data</a>
					<ul>
                    	<li><a class="style2"  href="<?php echo $backwardseperator;?>workstudy/component/componenteditor.php">Component</a></li>

						<li><a class="style2"  href="<?php echo $backwardseperator;?>workstudy/EditOperations/editOperations.php">Operations</a></li>
                       <!-- <li><a class="style2"  href="<?php echo $backwardseperator;?>workstudy/EditMachines/machines.php">Machine Types</a></li>-->


						<li><a class="style2"  href="<?php echo $backwardseperator;?>workstudy/machine/machine.php">Machines</a></li>
						<li><a class="style2"  href="<?php echo $backwardseperator;?>workstudy/stitchType/stitchType.php">Stitch Types</a></li>
						<li><a class="style2"  href="<?php echo $backwardseperator;?>workstudy/seamType/seamType.php">Seam Types</a></li>
						<li><a class="style2"  href="<?php echo $backwardseperator;?>workstudy/Factor/Factor.php">Factor</a></li>
						<li><a class="style2"  href="<?php echo $backwardseperator;?>workstudy/thread_consumption/Stitch_Ratio.php">Stitch Ratio</a></li>
						<li><a class="style2"  href="<?php echo $backwardseperator;?>workstudy/tex/tex.php">Tex</a></li>
						<li><a class="style2"  href="<?php echo $backwardseperator;?>workstudy/thread/thread.php">Thread</a></li>
					</ul>
				</li>
				
				<li><a class="style2"  href="<?php echo $backwardseperator;?>workstudy/operationbreakdown/Operation_Break_Down_Sheet.php">Operation Break Down Sheet</a></li>
				<li><a class="style2"  href="<?php echo $backwardseperator;?>workstudy/thread_consumption/thread_consumption.php">Thread Consumption</a></li>
				<li><a class="style2"  href="<?php echo $backwardseperator;?>workstudy/opbdReport/opbdRpt1.php">OPBD Report</a></li>
			</ul>
</li>
<?php } ?>

<?php if($manageSample){?>	
<li><a href="#" class="style3 MenuBarItemSubmenu">Sample Module</a>
	<ul>
		<li><a href="<?php echo $backwardseperator;?>SampleModule/SampleModule.php" class="style2">Sample Module</a>
		<li><a href="<?php echo $backwardseperator;?>SampleModule/Instructions.php" class="style2">Instruction</a>
		<li><a href="<?php echo $backwardseperator;?>SampleModule/MaterialsAndTrims.php" class="style2">Material And Terms</a>
		<li><a href="<?php echo $backwardseperator;?>SampleModule/SizeSpecification.php" class="style2">Size Specification</a>
		<li><a href="<?php echo $backwardseperator;?>SampleModule/ColorBlockContrastColor.php" class="style2">Color Block Contrast Color</a>
	</ul>
</li>
<?php }?>

<!--Start - 28-02-2011 - First Sale Module-->
<?php if($manageFirstSale){?>
<li><!--<a href="#" class="style3 MenuBarItemSubmenu">First Sale</a>-->
<ul>
	<?php if($manageFSCostWorkSheet){?>
	<li><a href="#" class="style2">Cost Work Sheet</a>
	<ul>
		<?php if($manageFSCostWorkSheet_Finance){?>
			<li><a href="<?php echo $backwardseperator;?>firstsale/costworksheet/costworksheet.php" class="style2">Finance</a></li>
		<?php } ?>
		<?php if($manageFSCostWorkSheet_Shipping){?>
			<li><a href="<?php echo $backwardseperator;?>firstsale/costworksheet/shippingCWS.php" class="style2">Shipping</a></li>
		<?php } ?>
	</ul>
	</li>		
	<?php } ?>
	<?php if($manageFSCostWorkSheet_Approval){?>
		<li><a href="<?php echo $backwardseperator;?>firstsale/costworksheet/pendingApprovalCWSlist.php" class="style2">Pending Approval</a></li>
	<?php } ?>
		
	
	<?php if($PP_allowActualConsumptionForm) { ?>
		<li><a href="<?php echo $backwardseperator;?>firstsale/actualConpc/aConpc.php" class="style2">Actual Consumption</a></li>
	<?php } ?>
	
	<?php if($PP_OrderContractApproval) { ?>
		<li><a href="<?php echo $backwardseperator;?>firstsale/specialApproval/specialApproval.php" class="style2">Order Contract Approval</a></li>
	<?php } ?>
    <?php if($PP_CostworksheetRevise) { ?>
		<li><a href="<?php echo $backwardseperator;?>firstsale/revise/costworksheetrevise.php" class="style2">Revise Cost Work Sheet </a></li>
	<?php } ?>
</ul>
</li>
<?php } ?>
<!--End - 28-02-2011 - First Sale Module-->	

<!--Start - 24-06-2011 - Finishing Module-->
<?php
if($PP_manageFinishingModule){ ?>
<li><a href="#" class="style3 MenuBarItemSubmenu">Finishing</a>
<ul>
	<li><a href="#" class="style2">Line In</a>
    <ul>
    	<li><a href="<?php echo $backwardseperator;?>finishing/finish_line_In_manual/lineIssueIn.php" class="style2">New</a></li>
        <li><a href="<?php echo $backwardseperator;?>finishing/finish_line_In_manual/lineIssueInList.php" class="style2">Listing</a></li>
    </ul>
    </li>
    
    <li><a href="#" class="style2">Line Out</a>
    <ul>
    	<li><a href="<?php echo $backwardseperator;?>finishing/finish_line_out/lineIssueOut.php" class="style2">New</a></li>
        <li><a href="<?php echo $backwardseperator;?>finishing/finish_line_out/lineIssueOutList.php" class="style2">Listing</a></li>
    </ul>
    </li>
	
	<?php if($PP_manageSchedule){ ?>
		<li><a href="#" class="style2">Shipment Schedule</a>
		<ul>
		<?php if($PP_allowMonthlyShipmentSchedule) { ?>
			<li><a href="<?php echo $backwardseperator;?>finishing/schedule/month/monthShipSchedule.php" class="style2">Month</a></li>
		<?php } ?>
		<?php if($PP_allowWeeklyShipmentSchedule) { ?>
			<li><a href="<?php echo $backwardseperator;?>finishing/schedule/week/weekShipSchedule.php" class="style2">Weekly</a></li>
		<?php } ?>
		</ul>
		</li>
	<?php } ?>
	
	<?php if($PP_allowExportGatePass) { ?>
		<li><a href="<?php echo $backwardseperator;?>finishing/exportAOD/exportgatepass.php" class="style2">Export GatePass</a></li>
	<?php } ?>
	
	<?php if($PP_allowShippingAdvise) { ?>
		<li><a href="<?php echo $backwardseperator;?>finishing/shippingadvise/shippingadvise.php" class="style2">Shipping Advise</a></li>
	<?php } ?>
    <?php if($PP_allowColorSizePlugin) { ?>
		<li><a href="<?php echo $backwardseperator;?>finishing/shipmentpackinglist/stylerato_plugin/stylerato_plugin.php" class="style2">Style Ratio Plug-in</a></li>
	<?php } ?>
    <?php if($PP_allowPackingList) { ?>
		<li><a href="<?php echo $backwardseperator;?>finishing/shipmentpackinglist/shipmentpackinglist.php" class="style2">Packing List</a></li>
	<?php } ?>
</ul>
</li>
<?php } ?>
<!--End - 24-06-2011 - Finishing Module-->	

<!--Start - 19-07-2011 - Sub Contract Module-->

<?php if($manageSubcontract){ ?>
<li><a href="#" class="style3 MenuBarItemSubmenu">Subcontract</a>
<ul>
<?php if($PP_manageSubContractModule){ ?>

	<li><a href="#" class="style2">sub-contractor</a>
	<ul>
		<li><a href="<?php echo $backwardseperator;?>SubContract/Details/SubContractNew.php" class="style2">Agreement</a></li>
		<li><a href="<?php echo $backwardseperator;?>SubContract/Details/SubContractListing.php" class="style2">Listing</a></li>
	</ul></li>

<?php } ?>
<?php if($PP_manageSubContractModule1){ ?>
	<li><a href="#" class="style2">Advice Of Dispatch</a>
	<ul>
		<li><a href="<?php echo $backwardseperator;?>SubContract/AOD/advice_Of_Dispatch.php" class="style2">Advice Of Dispatch</a></li>
		<li><a href="<?php echo $backwardseperator;?>SubContract/aodListing/adviceOfDispatchListing.php" class="style2">Listing</a></li>
	</ul>
	</li>
	
	<li><a href="#" class="style2">Subcontract GRN</a>
	<ul>
		<li><a href="<?php echo $backwardseperator;?>SubContract/emblishment_grn/emblishmentGrn.php" class="style2">Subcontract GRN</a></li>
		<li><a href="<?php echo $backwardseperator;?>SubContract/emblishment_grn/grnListing/emblishmentGrnListing.php" class="style2">Listing</a></li>
	</ul>
	</li>
<?php } ?>
</ul>
</li>
<?php } ?>

<!--End - 19-07-2011 - Sub Contract Module-->

	
<?php if($reports) { ?>
	<li><a href="#" class="style3 MenuBarItemSubmenu">Reports</a>
	<ul>
	<?php if($preorderReports) { ?>
		<li><a class="style2"  href="#">Order Reports</a>
		<ul>		
		<?php if($canSeeApprovedSheets) { ?>
			<li><a class="style2"  href="<?php echo $backwardseperator;?>approvedCostSheets.php">My Approved Sheets</a></li>				
		<?php } ?>		
		<?php if($canViewAllApprovedSheets) { ?>
			<li><a class="style2"  href="<?php echo $backwardseperator;?>allApprovedCostSheets.php">All Approved Sheets</a></li>
		<?php } ?>		
		<?php if ($canViewRejectedSheets) { ?>
			<li><a class="style2"  href="<?php echo $backwardseperator;?>rejectedCostSheets.php">Rejected Sheets</a></li>
		<?php } ?>
		<?php if ($canSeePendingCostSheetList) { ?>
			<li><a class="style2"  href="<?php echo $backwardseperator;?>allpendingcostsheets.php">Pending Cost Sheet</a></li>
			<li><a class="style2"  href="<?php echo $backwardseperator;?>approvalpendinglist.php">Pending Approval List</a></li>
		<?php } ?>
		<?php if($costVariationReport) { ?>
			<li><a class="style2"  href="<?php echo $backwardseperator;?>costVariationList.php">Cost Variation Report</a></li>
		<?php } ?>
        
		<?php if($CompletedOrderReport) { ?>
			<li><a class="style2"  href="<?php echo $backwardseperator;?>completedCostSheets.php">Completed Order Report</a></li>
		<?php } ?>
        
			<li><a class="style2"  href="<?php echo $backwardseperator;?>reCut/pendingRecutList.php">Recut List</a></li>
            <li><a class="style2"  href="<?php echo $backwardseperator;?>Reports/recut/recut.php">Recut Summary</a></li>
          <?php if($viewdeliveryschedule){ ?>   
            <li><a class="style2"  href="<?php echo $backwardseperator;?>Reports/deliverysch/deliveryschedule.php">Delivery Schedule</a></li>
          <?php } ?>    
		</ul>
		</li>
	<?php } ?>

	<?php if ($purchaseOrderReports) { ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>purchaseOrderReport.php">Purchase Order Reports</a> </li>
	<?php } ?>
	<?php if ($bomReports) { ?>
<li><a class="style2" href="<?php echo $backwardseperator;?>bomreports.php">BOM Reports</a> </li>
<?php } ?>

<?php if($styleReports) { ?>
<li><a class="style2" href="<?php echo $backwardseperator;?>StyleReport/stylereports.php">Style Report</a> </li>
<?php } ?> 

<?php if($bulkReports) { ?>
<li><a class="style2" href="<?php echo $backwardseperator;?>bulkstylereport/stylereports.php">Bulk Report</a> </li>
<?php } ?>

<?php if ($styleMRNReports) { ?>
<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/MRNReport.php">Style MRN Reports</a></li>
<?php } ?>

<?php if($POGRNList || $generalpogrnlist || $PP_AllowBulkPOGrnList){ ?>
<li><a class="style2" href="#">PO GRN List</a>
<ul>
<?php if($POGRNList) {?>
<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/POgrnlist/POGrnList.php">Style</a></li>
<?php } ?>
<?php if($PP_AllowBulkPOGrnList) {?>
<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/POgrnlist/bulk/bulkpogrnlist.php">Bulk</a></li>
<?php } ?>
<?php if($generalpogrnlist) {?>
<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/POgrnlist/general/genPOGrnList.php">General</a></li>
<?php } ?>
</ul>
</li>

<?php } ?>

<?php
if($costEstimateSheet)
{
?>
<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/postOrderCosting/postOrderCosting.php">Post Order Costing</a></li>
<?php
}
$orderStatusTracking = false;
if($orderStatusTracking)
{
?>
<li><a class="style2" href="<?php echo $backwardseperator;?>noworderstatus.php">Order Status</a></li>
<?php
}
if($inventoryReports)
{
?>		
<li><a class="style2"  href="#">Inventory Reports</a>
<ul>
<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/inventory/mrnlistreport.php">Material Requisition Notes</a></li>
<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/inventory/issuelistreport.php">Issue Notes</a></li>
<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/inventory/interjobtransactionlistreport.php">Inter Job Transfer</a></li>
<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/inventory/returntostoreslistreport.php">Return To Stores</a></li>
<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/inventory/returntosupplierlistreport.php">Return To Supplier</a></li>
<li><a class="style2" href="<?php echo $backwardseperator;?>allocation/list/allocationList.php">Bulk Reports</a></li>
<li><a class="style2" href="#">Bin Reports</a>
	<ul>
		<li><a class="style2" href="<?php echo $backwardseperator;?>BinReports/BinInquiry_ItemWise.php">Item Wise Bins</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>BinReports/BinInquiry_BinWise.php">Bin Wise Items</a></li>
	</ul>
</li>
</ul>				
</li>
<?php } ?>

<?php if($costVariationReport) { ?>
<li><a class="style2" href="<?php echo $backwardseperator;?>costVariationList.php">Cost Variation Report</a></li>
<?php } ?>

<?php if($stockBalanceReport) { ?>
<li><a class="style2" href="#">Stock Balance</a>
<ul>
<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/stockbalance/style/stockBalance.php">Style</a>
<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/stockbalance/bulk/bulkStockBalance.php">Bulk</a>
</ul>
</li>		
<?php } ?>

<?php if($manageStockMovementReport) { ?>
<li><a class="style2" href="#">Stock Movement</a>
<ul>
<li><a class="style2" href="<?php echo $backwardseperator;?>stockMovementReport/itemStockmovement.php">Item</a></li>
<li><a class="style2" href="<?php echo $backwardseperator;?>stockMovementReport/styleStockMovement/styleMovement.php">Style</a></li>
</ul>
</li>
<?php } ?>

<?php if($manageAgeAnalysisReport) { ?>
<li><a class="style2" href="#">Age Analysis Report</a>
<ul>
<li><a class="style2" href="<?php echo $backwardseperator;?>ageAnalysisReport/stockReport.php">Style</a></li>
<li><a class="style2" href="<?php echo $backwardseperator;?>bulkAgeAnalysisReport/bulkStock.php">Bulk</a></li>
<li><a class="style2" href="<?php echo $backwardseperator;?>ageAnalysisReport/general/genstockReport.php">General</a></li>
</ul>
</li>

<?php if($manageBinInquiry){?>
<li><a class="style2" href="#">Bin Inquiry</a>
<ul>
<li><a class="style2" href="<?php echo $backwardseperator;?>BinReports/BinInquiry_BinWise.php">Bin Wise</a></li>
<li><a class="style2" href="<?php echo $backwardseperator;?>BinReports/BinInquiry_ItemWise.php">Item Wise</a></li>
</ul>
</li>
<?php }?>

<?php } ?>

<?php if($manageDeliveryScheduleReport){?>
<li><a class="style2" href="<?php echo $backwardseperator;?>deliveryScheduleReport/deliverySchedule.php">Delivery Schedule</a></li>
<?php }?>

<?php if($PP_allowAllocationReports){?>
<li><a class="style2" href="#">Allocation</a>
<ul>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/allocation/bulk/allocationlist.php">Bulk</a>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/allocation/leftover/leftoverlist.php">LeftOver</a>
</ul>
</li>
<?php }?>

<?php
if($subContractorReports)
{
?>
<li><a class="style2" href="<?php echo $backwardseperator;?>subcontractlist.php">Sub Contractor Reports</a></li>
<?php
}
if($canSeeOldToNewTransferReports)
{
?>
<li><a class="style2" href="<?php echo $backwardseperator;?>InterJobTransferoldtonew/reports/mainpage.php">Old -> New Item Transfer Reports</a></li>
<?php
}
if($timeAndActionPlanReports)
{
?>
<li><a class="style2" href="<?php echo $backwardseperator;?>EventSchedule/eventStyleList.php">Time & Action Plan Reports</a></li>
<?php
}
?>

<?php if($manageInvoiceCostingList){?>
	<li><a class="style2" href="#">Invoice Costing</a>
	<ul>
		<li><a class="style2" href="<?php echo $backwardseperator;?>invoiceCosting/Cost/invoiceCostList.php?ReportPlace=R">Listing</a></li>
		<?php if($PP_AllowInvoiceCostingVariationReport) { ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/invoiceCosting/variation/variationList.php">Variation</a></li>
		<?php } ?>
	</ul>
	</li>
<?php }?>

<?php if($PP_allowOrderBookList){?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/orderbook/orderbooklist.php">Order Book</a></li>
<?php }?>

<?php if($PP_AllowExportSalesReport){?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/exportAnalysisReport/exportAnalysis.php">Export Sales Report</a></li>
<?php }?>

<?php if($PP_AllowProduction){?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/production/productionlist.php">Production</a></li>
<?php }?>

<?php if($PP_AllowPaymentSVATReport){?>
	<li><a class="style2" href="#">Payment</a>
	<ul>
		<li><a class="style2" href="<?php echo $backwardseperator;?>Payments/Reports/svat/svatlist.php">SVAT</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/payment/svat/firstsale/svatlist.php">First Sale SVAT</a></li>
        <li><a class="style2" href="<?php echo $backwardseperator;?>Reports/inventory/paymentDiscrepancy/paymentDiscrepancy.php">Discrepancy</a></li>
	</ul></li>
<?php }?>

<?php if($PP_AllowReconciliationReports){?>
	<li><a class="style2" href="#">Reconciliations</a>
	<ul>
		<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/reconciliation/threadReconciliation/reconciliation.php">Thread</a></li>
		<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/reconciliation/pocketReconciliation/pocketingReconciliation.php">Pocketing</a></li>		
	</ul>
	</li>
<?php }?>

<?php if($PP_AllowShippingRegisterReports){?>
	<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/shippingRegister/shippingRegister.php">Shipping Register</a></li>
<?php }?>

<?php if($PP_AllowFirstSaleReport1){?>
	<li><a class="style2" href="#">First Sales</a>
	<ul>
    	<?php if($PP_AlloFirstSaleSummary){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/firstsale/firstSaleReportType.php">Summary</a></li>
        <?php } ?>
        
        <?php if($PP_AllowInterCompanySales){ ?>
		<li><a class="style2" href="<?php echo $backwardseperator;?>Reports/firstsale/monthlySales/monthlySales.php">Inter Company Sales</a></li>
        <?php } ?>
         
        <?php if($PP_AllowBOIGRNNote){ ?>
        <li><a class="style2" href="<?php echo $backwardseperator;?>Reports/firstsale/grn/BOIGRN.php">BOI GRN Note</a></li>
        <?php } ?>
	</ul>
	</li>
<?php }?>

</ul>

</li>

         
<li><a href="#" class="style3 MenuBarItemSubmenu">Data Transfer</a>
<ul><li><a class="style2" href="<?php echo $backwardseperator;?>fr/loadorders.php">Fast React</a></li></ul>

</li>
		  <?php 
		
		}
		if($administration)
		{
		?>		
	 
		
		<li><a href="#" class="style3 MenuBarItemSubmenu">Administration</a>
		  <ul>
		<?php
		}
		else
		{
		?>
		<li><a href="#" class="style3 MenuBarItemSubmenu">Help</a>
		 <ul>
		<?php
		}
		if($manageCompanyForm)
		{			
		?>
		  <li><a class="style2" href="<?php echo $backwardseperator;?>addinns/companyDetails new/CompanyDetails.php">Company Details</a></li>
		<?php
		}
		$viewAuditTrail=false;
		if($viewAuditTrail)
		{			
		?>
		  <li><a class="style2" href="<?php echo $backwardseperator;?>AuditTrial/Reports/auditTrial.php">Audit Trial</a></li>
		<?php 
		}
		if($canGetItemsFromOldSystem)
		{		
		?>

		<?php
		}
		
		if($manageUsers)
		{
		?>
			<li><a class="style2"  href="<?php echo $backwardseperator;?>Admin/config/SystemConfig.php">System Configuration</a>            </li>
			<li><a class="style2"  href="<?php echo $backwardseperator;?>userManager.php">User Management</a></li>
			<li><a class="style2"  href="<?php echo $backwardseperator;?>emailconfig/emailconfig.php">Email Setup</a></li>
			<li><a class="style2"  href="<?php echo $backwardseperator;?>createnewuser.php">Creat Accounts</a></li>
		<?php
		}
		?>
		
		<?php if($PP_allowSpecialSendToApprovalForm) { ?>
			<li><a class="style2"  href="<?php echo $backwardseperator;?>specialapprovepreordersheet.php">Special Send To Approval</a></li>
		<?php } ?>
		
		  <li><a class="style2" >----------------------------</a></li>
		<!--  <li><a class="style2" href="<?php echo $backwardseperator;?>resetPassword.php" target="_blank">Reset Password</a></li>-->
			<li><a class="style2" href="<?php echo $backwardseperator;?>edituser.php">Edit Account</a></li>
		  	<li><a class="style2">-----------------------</a></li>
		  	<li><a class="style2" href="<?php echo $backwardseperator;?>softwares/Firefox Setup 3.6.13.exe">Download Firefox 3.6.16 for Windows</a></li>
		  	<li><a class="style2" href="<?php echo $backwardseperator;?>softwares/firefox-3.0.11.tar.bz2">Download Firefox for Linux</a></li>
		  	<li><a class="style2" href="<?php echo $backwardseperator;?>softwares/Firefox3.0.11.dmg">Download Firefox for Apple</a></li>
		  	<li><a class="style2" href="<?php echo $backwardseperator;?>softwares/printpdf-0.76-fx-win.xpi">Add PDF Printer 0.76</a></li>
			<li><a class="style2" href="<?php echo $backwardseperator;?>softwares/printpdf-0.75-fx-win.xpi">Add PDF Printer 0.75</a></li>
			<li><a class="style2" href="<?php echo $backwardseperator;?>softwares/js_print_setup-0.8.2h-fx.xpi">Print to js 8.0</a></li>
			<li><a class="style2" href="<?php echo $backwardseperator;?>softwares/js_print_setup-0.9.0-fx.xpi">Print to js 9.0</a></li>
			<li><a class="style2" href="<?php echo $backwardseperator;?>softwares/CuteWriter.exe">Cute Writer</a></li>
		  <li><a class="style2" >----------------------------</a></li>
		  <li><a class="style2" href="<?php echo $backwardseperator;?>releasenote/releasenote.php">Release Note</a></li>
		  <li><a class="style2" href="<?php echo $backwardseperator;?>issuesLog.php">Issues Log</a></li>
		 </ul>
		 </ul>
      </li>
      </ul>      </td>
  </tr>
</table>
</body>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"<?php echo $backwardseperator;?>SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
