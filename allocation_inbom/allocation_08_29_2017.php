<?php
session_start();
$backwardseperator = "../";
include "../Connector.php";
include "../HeaderConnector.php";
include "../permissionProvider.php";
$companyId 		=  $_SESSION["FactoryID"]; 
$matDetailId 	= $_GET["matDetailId"];
$bomQty         = $_GET["bomQty"];
$freightPrice   = $_GET["FreightPrice"];
$styleId	= $_GET["styleId"];
$strColor       = $_GET["strColor"];
$strSize        = $_GET["strSize"];
$strBuyerPO     = $_GET["buyerPO"];
$color_array 	= array();
$size_array 	= array();
$pub_url = "/gapro/";
//$canAllocateTotalRatioQty = true;
//$canAllocateTotalQtyFromLeftover = false;
echo "Buyer PO" . $strBuyerPO;
//echo "Color Is '$strColor'";
?>
<?php
$sqldesc="select strItemDescription from matitemlist where intItemSerial= $matDetailId";
//echo $sqldesc;
$result_desc=$db->RunQuery($sqldesc);
while($row_desc=mysql_fetch_array($result_desc))
{
	$itemDescription 	= $row_desc["strItemDescription"];
}
/*$loop1 =0;
$sql_color="select distinct strColor from materialratio where intStyleId='$styleId' and strMatDetailID='$matDetailId '";
$result_color=$db->RunQuery($sql_color);
while($row_color=mysql_fetch_array($result_color))
{
	$color_array[$loop1] = "'" . $row_color["strColor"] . "'";
	$loop1++;
}

$loop2 =0;
$sql_size="select distinct strSize from materialratio where intStyleId='$styleId' and strMatDetailID='$matDetailId '";
$result_size=$db->RunQuery($sql_size);
while($row_size=mysql_fetch_array($result_size))
{
	$size_array[$loop2] = "'" . $row_size["strSize"] . "'";
	$loop2++;
}*/
?>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="allocation.js"></script>


<script type="text/javascript" language="javascript">
    
var MainStoreID = "<?php echo $_GET["matDetailId"]; ?>";
</script>
<table width="100%" border="0" bgcolor="#FFFFFF">
            <tr>
            <td width="100%" height="16"  class="TitleN2white">
			<table width="100%"border="0" bgcolor="#0E4874">
                <tr class="mainHeading">
                  <td class="cursercross" width="95%">Stock Allocation</td>
                  <td width="5%"  class="mouseover">
		            <div align="center"><img src="images/cross.png" alt="close" width="17" height="17"
				 onClick="closeAllocationWindow();" />				  </div></td>
                </tr>
              </table></td>
            </tr>
			<tr>
				<td title="<?php echo $matDetailId;?>" class="normalfnth2" id="tdMatDetailId">Item Description : <?php echo $itemDescription;?>
                                    <input type="hidden" id="hndColor" value="<?php echo $strColor; ?>" />
                                    <input type="hidden" id="hndSize" value="<?php echo $strSize; ?>" />
                                    <input type="hidden" id="cboToBuyerPoNo" value="<?php echo $strBuyerPO; ?>" />
                                </td>
			</tr>
         <tr style="visibility:hidden" title="<?php echo $bomQty+$freightPrice; ?>" id="tdBOMQty"><td height="3"></td></tr>
          <tr style="visibility:hidden" title="<?php echo $styleId; ?>" id="tdStyleId"><td height="3"></td></tr>
           <tr style="visibility:hidden" title="<?php echo $canAllocateTotalRatioQty; ?>" id="tdAlloTotRatio"><td height="3"></td></tr>
          <tr style="visibility:hidden" title="<?php echo $canAllocateTotalQtyFromLeftover; ?>" id="tdAlloTotRatioLO"><td height="3"></td></tr>
	<tr>
	<td class="normalfntMid"><button id="butA" onclick="validatePopUp1(this.name);" name="realtooltip1" style="display:none">View Bulk</button>
            
            <a href="#" onclick="validatePopUp1('realtooltip1');">Left Over Allocation</a> ||
    <a href="#" onclick="validatePopUp1('realtooltip2');">Bulk Allocation</a>||
    <a href="#" onclick="validatePopUp1('realtooltip3');">Laibility Allocation</a>
    </td>
	</tr>
	    </table>
<div id="realtooltip1" style="display:inline"><table width="100%" border="0" class="bcgl1" bgcolor="#FFFFFF">
		  	<tr>
			<td height="20" colspan="2" class="normalfnt"><a href="#" >Left Over Allocation
</a></td>
		    <td width="20%" class="normalfnt">&nbsp;</td>
      <td width="25%" align="left">&nbsp;</td>
      <td width="11%">&nbsp;</td>
  	</tr>
    <!-- <tr>
    	<td width="12%" class="normalfnt">Buyer PONo</td>
        <td width="32%" align="left"><span class="normalfnt">
          <select name="cboToBuyerPoNo" class="txtbox" id="cboToBuyerPoNo" style="width:150px">
            <?php
	  $SQL ="select distinct strBuyerPoName,strBuyerPONO from style_buyerponos where intStyleId='$styleId'";		
		
		$result =$db->RunQuery($SQL);
		
			echo "<option value =\""."#Main Ratio#"."\">"."#Main Ratio#"."</option>";
		while ($row=mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["strBuyerPONO"] ."\">".$row["strBuyerPoName"]."</option>";
		}
	  
	  ?>
          </select>
        </span></td>
      <td class="normalfnt">Main Store</td>
        <td align="left"><select name="cboMainStore" id="cboMainStore" style="width:220px;" onchange="viewLeftOver();">
          <option value="0" selected="selected">Select One</option>
          <?php 
	  $SQL_store = " select strMainID,strName 
					from mainstores
					where intStatus=1 ";
					
				$resultS =$db->RunQuery($SQL_store);
				
			//	echo "<option value =\""."0"."\">"."Select One"."</option>";
		while ($rowS=mysql_fetch_array($resultS))
		{
			echo "<option value=\"". $rowS["strMainID"] ."\">".$rowS["strName"]."</option>";
		}	
					
	  ?>
        </select></td>
        <td align="left">&nbsp;</td>
    </tr> -->
    <tr>
      <td class="normalfnt">Remarks</td>
      <td align="left"><input type="text" name="txtLAlloRemarks" id="txtLAlloRemarks" style="width:230px;" maxlength="150" /></td>
      <td class="normalfnt">Manufacturing Company</td>      
      <td align="left">
          <select name="cboManufactLeftCompany" id="cboManufactLeftCompany" style="width:220px;">
        <option value="" selected="selected">Select One</option>
        <?php 
	  $SQL_com = " select intCompanyID,strName from companies where intManufacturing=1 ";
					
				$resultC =$db->RunQuery($SQL_com);
				
			//	echo "<option value =\""."0"."\">"."Select One"."</option>";
		while ($rowC=mysql_fetch_array($resultC))
		{
			echo "<option value=\"". $rowC["intCompanyID"] ."\">".$rowC["strName"]."</option>";
		}	
					
	  ?>
      </select></td>
      <td align="left">&nbsp;<!-- <img src="<?php echo $pub_url?>images/view.png" alt="search" width="91" height="19" onclick="viewLeftOver();" />--></td>
    </tr>
                <tr>
                  <td colspan="5">
				 
                    <div id="divMain" style="overflow:scroll; height:323px; width:100%">
                      <table id="tblLeftOver" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                      	<tr bgcolor="#498CC2">
                            <td width="2%" class="normaltxtmidb2">&nbsp;</td>
                            <td width="9%" class="normaltxtmidb2">Main Store</td>
                            <td width="4%" height="15" class="normaltxtmidb2">SC No</td>
                            <td width="10%" height="15" class="normaltxtmidb2">Style No</td>
                            <td width="6%" class="normaltxtmidb2">Buyer PoNo</td>
                            <td width="8%" class="normaltxtmidb2">Color</td>
                            <td width="8%" class="normaltxtmidb2">Size</td>
                            <td width="4%" class="normaltxtmidb2">Unit</td>
                            <td width="6%" class="normaltxtmidb2">Stock Qty</td>
                            <td width="2%" class="normaltxtmidb2"></td>
                            <td width="6%" class="normaltxtmidb2">Transfer Qty</td>
                            <td width="5%" class="normaltxtmidb2">GRN No</td>
                            <td width="5%" class="normaltxtmidb2">GRN Year</td>
                            <td width="3%" class="normaltxtmidb2">GRN Type </td>
                            <td width="5%" class="normaltxtmidb2">Sub Stores</td>
                            <td width="7%" class="normaltxtmidb2">Location </td>
                            <td width="5%" class="normaltxtmidb2">BIN No</td>
                            
                   	</tr>

                      </table>
                    </div>                  </td>
            </tr>
                <tr>
                  <td colspan="5" class="normalfntMid"><img id="butAllocatonSave" src="images/save.png" alt="save" onclick="ValidationLeftOver();" /></td>
                </tr>
              </table>
</div>
<div id="realtooltip2" style="display:none"><table width="100%" border="0" class="bcgl1" bgcolor="#FFFFFF">
<tr>
			<td height="20" colspan="2" class="normalfnt"><a href="#">Bulk Allocation
</a></td>
		    <td width="20%" class="normalfnt">&nbsp;</td>
      <td width="25%" align="left">&nbsp;</td>
      <td width="11%">&nbsp;</td>
  	</tr>
    <tr>
    	<td width="12%" class="normalfnt">Buyer PONo</td>
        <td width="32%" align="left">
         <select name="cboBulkToBuyerPoNo" class="txtbox" id="cboBulkToBuyerPoNo" style="width:150px">
			<?php
	  $SQL ="select distinct strBuyerPoName,strBuyerPONO from style_buyerponos where intStyleId='$styleId'";		
		
		$result =$db->RunQuery($SQL);
		
			echo "<option value =\""."#Main Ratio#"."\">"."#Main Ratio#"."</option>";
		while ($row=mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["strBuyerPONO"] ."\">".$row["strBuyerPoName"]."</option>";
		}
	  
	  ?></select>
        </td>
      <td class="normalfnt">Main Store</td>
        <td align="left"><select name="cboMainStoreBulk" id="cboMainStoreBulk" style="width:220px;" onchange="viewBulkDetails(<?php echo $matDetailId; ?>,<?php echo $styleId; ?>);">
       <option value="0" selected="selected">Select One</option>
       <?php 
	  $SQL_store = " select strMainID,strName 
					from mainstores
					where intStatus=1 ;";
					
				$resultS =$db->RunQuery($SQL_store);
				
				//echo "<option value =\""."0"."\">"."Select One"."</option>";
		while ($rowS=mysql_fetch_array($resultS))
		{
			echo "<option value=\"". $rowS["strMainID"] ."\">".$rowS["strName"]."</option>";
		}	
					
	  ?>
      </select></td>
        <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td class="normalfnt">Remarks</td>
      <td align="left"><input type="text" name="txtBAlloRemarks" id="txtBAlloRemarks" style="width:230px;" maxlength="150" /></td>
      <td class="normalfnt">Manufact. Company</td>
      <td align="left"><select name="cboManufactBulkCompany" id="cboManufactBulkCompany" style="width:220px;">
        <option value="" selected="selected">Select One</option>
        <?php 
	  $SQL_com = " select intCompanyID,strName from companies where intManufacturing=1 ";
					
				$resultC =$db->RunQuery($SQL_com);
				
			//	echo "<option value =\""."0"."\">"."Select One"."</option>";
		while ($rowC=mysql_fetch_array($resultC))
		{
			echo "<option value=\"". $rowC["intCompanyID"] ."\">".$rowC["strName"]."</option>";
		}	
					
	  ?>
      </select></td>
      <td align="left"><img src="<?php echo $pub_url?>images/view.png" width="91" height="19" onclick="viewBulkDetails(<?php echo $matDetailId; ?>,<?php echo $styleId; ?>);" /></td>
    </tr>
		  	
                <tr>
                  <td colspan="6">
				 
                    <div id="divMain" style="overflow:scroll; height:323px; width:100%">
                      <table id="tblBulk" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                      		<tr bgcolor="#498CC2">
			<td width="1%" class="normaltxtmidb2">&nbsp;</td>
            <td width="10%" class="normaltxtmidb2">Bulk PO No</td>
              <td width="10%" class="normaltxtmidb2">Bulk GRN No</td>
              <td width="10%" class="normaltxtmidb2">Invoice No</td>
			<td width="10%" class="normaltxtmidb2">Main Store</td>
			<td width="10%" class="normaltxtmidb2">Color</td>
			<td width="10%" class="normaltxtmidb2">Size</td>
			<td width="10%" class="normaltxtmidb2">Unit</td>
            <td width="10%" class="normaltxtmidb2">PO Qty</td>
			<td width="10%" class="normaltxtmidb2">Bal Qty</td>
			<td width="1%" class="normaltxtmidb2"><input type="checkbox" id="chkBulkCheckAll" name="chkBulkCheckAll" onclick="chkBulkCheckAll(this);"/></td>
			<td width="10%" class="normaltxtmidb2">Allocate Qty</td>
            <td width="8%" class="normaltxtmidb2">PO price</td>
		</tr>

                      </table>
                    </div>					                 </td>
            </tr>
                <tr>
                 <td colspan="6" class="normalfntMid"><img id="butBulkSave" src="images/save.png" alt="save" onclick="ValidationBulk();" /></td>
                </tr>
              </table>
</div>
<div id="realtooltip3" style="display:none"><table width="100%" border="0" class="bcgl1" bgcolor="#FFFFFF">
		  	<tr>
			<td height="20" colspan="2" class="normalfnt"><a href="#">Liability Allocation
</a></td>
		    <td width="20%" class="normalfnt">&nbsp;</td>
      <td width="25%" align="left">&nbsp;</td>
      <td width="11%">&nbsp;</td>
  	</tr>
    <tr>
    	<td width="12%" class="normalfnt">Buyer PONo</td>
        <td width="32%" align="left"><span class="normalfnt">
          <select name="cboLiabilityBuyerPoNo" class="txtbox" id="cboLiabilityBuyerPoNo" style="width:150px">
            <?php
	  $SQL ="select distinct strBuyerPoName,strBuyerPONO from style_buyerponos where intStyleId='$styleId'";		
		
		$result =$db->RunQuery($SQL);
		
			echo "<option value =\""."#Main Ratio#"."\">"."#Main Ratio#"."</option>";
		while ($row=mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["strBuyerPONO"] ."\">".$row["strBuyerPoName"]."</option>";
		}
	  
	  ?>
          </select>
        </span></td>
      <td class="normalfnt">Main Store</td>
        <td align="left"><select name="cboLiabilityMainStore" id="cboLiabilityMainStore" style="width:220px;" onchange="viewLiability();">
          <option value="0" selected="selected">Select One</option>
          <?php 
	  $SQL_store = " select strMainID,strName 
					from mainstores
					where intStatus=1 ";
					
				$resultS =$db->RunQuery($SQL_store);
				
			//	echo "<option value =\""."0"."\">"."Select One"."</option>";
		while ($rowS=mysql_fetch_array($resultS))
		{
			echo "<option value=\"". $rowS["strMainID"] ."\">".$rowS["strName"]."</option>";
		}	
					
	  ?>
        </select></td>
        <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td class="normalfnt">Remarks</td>
      <td align="left"><input type="text" name="txtLiabilityAlloRemarks" id="txtLiabilityAlloRemarks" style="width:230px;" maxlength="150" /></td>
      <td class="normalfnt">Manufact. Company</td>
      <td align="left"><select name="cboManufactLiabilityCompany" id="cboManufactLiabilityCompany" style="width:220px;">
        <option value="" selected="selected">Select One</option>
        <?php 
	  $SQL_com = " select intCompanyID,strName from companies where intManufacturing=1 ";
					
				$resultC =$db->RunQuery($SQL_com);
				
			//	echo "<option value =\""."0"."\">"."Select One"."</option>";
		while ($rowC=mysql_fetch_array($resultC))
		{
			echo "<option value=\"". $rowC["intCompanyID"] ."\">".$rowC["strName"]."</option>";
		}	
					
	  ?>
      </select></td>
      <td align="left"><img src="<?php echo $pub_url?>images/view.png" alt="search" width="91" height="19" onclick="viewLeftOver();" /></td>
    </tr>
                <tr>
                  <td colspan="5">
				 
                    <div id="divMain" style="overflow:scroll; height:323px; width:100%">
                      <table id="tblLiability" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                      		<tr bgcolor="#498CC2">
			<td width="1%" class="normaltxtmidb2">&nbsp;</td>
			<td width="10%" class="normaltxtmidb2">Main Store</td>
			<td width="10%" height="15" class="normaltxtmidb2">Order No</td>
			<td width="10%" class="normaltxtmidb2">Buyer PoNo</td>
			<td width="10%" class="normaltxtmidb2">Color</td>
			<td width="10%" class="normaltxtmidb2">Size</td>
			<td width="10%" class="normaltxtmidb2">Unit</td>
			<td width="10%" class="normaltxtmidb2">Stock Qty</td>
			<td width="1%" class="normaltxtmidb2"></td>
			<td width="10%" class="normaltxtmidb2">Transfer Qty</td>
            <td width="10%" class="normaltxtmidb2">GRN No</td>
            <td width="8%" class="normaltxtmidb2">GRN Year</td>
		    <td width="8%" class="normaltxtmidb2">GRN Type </td>
                   		</tr>

                      </table>
                    </div>                  </td>
            </tr>
                <tr>
                  <td colspan="5" class="normalfntMid"><img id="butLiabilityAllocatonSave" src="images/save.png" alt="save" onclick="ValidationLiability();" /></td>
                </tr>
              </table>
</div>

      

<?php 
function GetBuyerPoName($buyerPoId)
{
global $db;
$sql="select strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoId'";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
return $row["strBuyerPoName"];
}


function GetSavedAlloQty($styleId,$matDetailId,$color,$size)
{
global $db;
global $companyId;
$sql="select sum(LD.dblQty)as stockQty from commonstock_leftoverdetails LD
inner join commonstock_leftoverheader LH on LH.intTransferNo=LD.intTransferNo and LH.intTransferYear=LD.intTransferYear
where LD.intFromStyleId='$styleId'
and LD.intMatDetailId='$matDetailId'
and LD.strColor='$color'
and LD.strSize='$size'
and LH.intCompanyId='$companyId'
and LH.intStatus=0";
$result=$db->RunQuery($sql);
$qty = 0;
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["stockQty"];		
	}
	return $qty;	
}
/*function GetSavedBulkAlloQty($matDetailId,$color,$size)
{
global $db;
global $companyId;
$sql="select sum(BD.dblQty)as stockQty from commonstock_bulkdetails BD
inner join commonstock_bulkheader BH on BH.intTransferNo=BD.intTransferNo and BH.intTransferYear=BD.intTransferYear
where BD.intMatDetailId='$matDetailId'
and BD.strColor='$color'
and BD.strSize='$size'
and BH.intCompanyId='$companyId'
and BH.intStatus=0";
$result=$db->RunQuery($sql);
$qty = 0;
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["stockQty"];		
	}
	return $qty;	
}*/
function GetSavedBulkAlloQty($matDetailId,$color,$size,$poNo, $poYear,$grnNo,$grnYear)
{
global $db;
global $companyId;
$sql="select sum(BD.dblQty) as AlloQty from commonstock_bulkdetails BD
inner join commonstock_bulkheader BH on BH.intTransferNo=BD.intTransferNo and BH.intTransferYear=BD.intTransferYear
where BD.intMatDetailId='$matDetailId'
and BD.strColor='$color'
and BD.strSize='$size'
and BH.intCompanyId='$companyId'
and BH.intStatus=0
and BD.intBulkPoNo='$poNo'
and BD.intBulkPOYear='$poYear'
and BD.intBulkGrnNo='$grnNo'
and BD.intBulkGRNYear='$grnYear'";
$result=$db->RunQuery($sql);
$qty = 0;
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["AlloQty"];		
	}
	return $qty;	
}
?>
