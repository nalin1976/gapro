<?php
	session_start();
	include "../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../../";
	include "../../authentication.inc";
	$PP_CancelLiabilityAllocation=true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Allocation - Liability</title>

<script type="text/javascript" src="GPtransferIn.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="liability.js" type="text/javascript"></script>

</head>

<body>
<form name="frmLeftOverAllocation" id="frmLeftOverAllocation">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" class="tableBorder">

  <tr>
    <td height="26" class="mainHeading">Allocation - Liability</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="1">&nbsp;</td>
        <td width="159" class="normalfnt">Liability   No</td>
        <td width="389"><span class="normalfnt">
          <select name="cboNo" class="txtbox" id="cboNo" style="width:378px" onchange="LoadMainDetails();">
	  <?php
	  $SQL ="select concat(intTransferYear,'/',intTransferNo)As no,
(select c.strName from companies c where c.intCompanyID = LH.intManufactCompanyId ) as manufactCompany,
(select ua.Name from useraccounts ua where ua.intUserID = LH.intUserId) as userName,date(LH.dtmDate) as allocationDate
 from commonstock_liabilityheader LH
where intStatus=0 and intCompanyId='$companyId'
order by intTransferYear,intTransferNo desc";		
		
		$result =$db->RunQuery($SQL);
		
			echo "<option value =\"".""."\">"."Select One"."</option>";
		while ($row=mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["no"] ."\">".$row["no"].' - '.$row["manufactCompany"].' - '.$row["userName"].' - '.$row["allocationDate"]."</option>";
		}
	  
	  ?>
	  		</select>
        </span></td>
        <td width="13"></td>
        <td width="92"><span class="normalfnt">Main Stores</span></td>
        <td width="254" class="normalfnt"><select name="cboMainStore" class="txtbox" id="cboMainStore" style="width:252px" onchange="loadStoreDetails();" disabled="disabled">
          <?php
		$SQL ="select strMainID,strName from mainstores where intStatus=1 AND intCompanyId=$companyId";
		$result = $db->RunQuery($SQL);
					
					echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["strMainID"] ."\">" . $row["strName"] ."</option>" ;
					}	
	?>
        </select></td>
        <td width="12"></select></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt">Transfer No</td>
        <td><input  type="text" name="txtTransferNo" class="txtbox" id="txtTransferNo" style="width:100px" readonly="" /><img src="../../images/view.png" alt="view" align="absbottom" onclick="SearchPopUp();" /></td>
        <td>&nbsp;</td>
        <td width="92"><span class="normalfnt">To Order No</span></td>
        <td class="normalfnt" id="tdToStyleId">
          <input  type="text" name="txtToStyle" class="txtbox" id="txtToStyle" style="width:250px" readonly="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt">Remarks</td>
        <td><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks"  maxlength="100" style="text-transform:capitalize; width:375px;"/></td>
        <td>&nbsp;</td>
        <td  class="normalfnt">To Buyer PoNo </td>
        <td class="normalfnt" id="tdBuyerPoId"><input  type="text" name="txtToBuyerPoNo" class="txtbox" id="txtToBuyerPoNo" style="width:250px" readonly="" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt">Merchandiser Remarks</td>
        <td><input name="txtMerchandRemarks" type="text" class="txtbox" id="txtMerchandRemarks"  maxlength="100" style="text-transform:capitalize; width:375px;" readonly=""/></td>
        <td>&nbsp;</td>
        <td  class="normalfnt">&nbsp;</td>
        <td class="normalfnt" id="tdBuyerPoId">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
<?PHP
$sqlsetting="select strValue from settings where strKey='CommonStockActivate'";
$result_setting=$db->RunQuery($sqlsetting);
while($row_setting=mysql_fetch_array($result_setting))
{
	$commonBinID	= $row_setting["strValue"];	
}
?>
          <tr class="mainHeading2">
            <td width="32%" title="<?php echo $commonBinID ;?>" id="titCommonBinID">&nbsp;</td>
            <td width="56%" >&nbsp;</td>
            <td width="12%" ><img src="../../images/add-new.png" alt="addItem" title="add details to main grid" onclick="LoadMainDetails()"/></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="divTransInMain" style="overflow:scroll; height:310px; width:950px;">
          <table id="tblMain" width="932" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="2%" height="25" >Del</td>
              <td width="22%" >Item Discription</td>
              <td width="15%">Order No</td>
              <td width="8%">Buyer PoNo</td>
              <td width="9%" >Color</td>
              <td width="6%" >Size</td>
              <td width="6%" >Unit</td>
              <td width="8%" >Allocate Qty </td>
              <td width="8%" > Qty</td>
              <td width="1%" >Location</td>
              <td width="1%" >GRN No </td>
              <td width="1%" >GRN Type </td>
            </tr>   
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
 
  <tr >
    <td height="30"><table width="100%" border="0" class="tableBorder">
      <tr>
        <td width="24%" align="center">
        <img src="../../images/new.png" alt="new"  onclick="ClearForm();" style="display:inline"/>
        <img src="../../images/conform.png" alt="save"  id="cmdConfirm" onclick="SaveValidation();" style="display:inline"/>
        <?php if($PP_CancelLiabilityAllocation) {?>
        <img src="../../images/cancel.jpg" alt="cancel" id="cmdCancel" name="cmdCancel"  onclick="Cancel();" style="display:inline"/>
        <?php 
		}
		?>
        <img src="../../images/report.png" alt="Report" onclick="showReport();" style="display:none"/>
        <a href="../../main.php"><img src="../../images/close.png" alt="close"  border="0" style="display:inline"/></a>
       </td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<div style="left:550px; top:380px; z-index:10; position:absolute; width: 240px; visibility:hidden; " id="gotoReport" ><table width="270" height="65" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="82" height="27">State </td>
            <td width="186"><select name="select3" class="txtbox" id="cboReportState" style="width:100px" onchange="LoadPopUpTransIn();">              
              <option value="1">Confirm</option>
              <option value="10">Cancel</option>
            </select></td>
            <td width="186">Year</td>
            <td width="186"><select name="select4" class="txtbox" id="cboReportYear" style="width:55px" onchange="LoadPopUpTransIn();">
             
			   <?php
	
	$SQL = "SELECT DISTINCT intTINYear FROM gategasstransferinheader ORDER BY intTINYear DESC;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intTINYear"] ."\">" . $row["intTINYear"] ."</option>" ;
	}
	
	?>
            </select></td>
          </tr>
          <tr>
            <td><div align="center">TransIn</div></td>
            <td><select name="select" class="txtbox" id="cboRptTransIn" style="width:100px" onchange="showReport();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		
		
</div>
<!--Start - Search popup-->
<div style="left:418px; top:142px; z-index:10; position:absolute; width: 261px; visibility:hidden; height: 61px;" id="NoSearch" >
  <table width="260" height="59" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
   <tr>           
            <td colspan="6" bgcolor="#550000" align="right"><img src="../../images/cross.png" onClick="SearchPopUp();" alt="Close" name="Close" width="17" height="17" id="Close" /></td>
          </tr>
          <tr>
		  	<td width="4" height="22" class="normalfnt"></td>
            <td width="61" height="22" class="normalfnt">State </td>
            <td width="102"><select name="cboState" class="txtbox" id="cboState" style="width:100px" onchange="LoadPopUpNo();">              
              <option value="1">Saved & Confirmed</option>              
			  <option value="10">Cancelled</option>
            </select></td>
            <td width="26" class="normalfnt">Year</td>
            <td width="55"><select name="select4" class="txtbox" id="cboYear" style="width:55px" onchange="LoadPopUpNo();">
             
			   <?php
	
	$SQL = "SELECT DISTINCT intTransferYear FROM commonstock_leftoverheader ORDER BY intTransferYear DESC;";
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intTransferYear"] ."\">" . $row["intTransferYear"] ."</option>" ;
	}
	
	?>
            </select></td>
            <td width="10">&nbsp;</td>
          </tr>
          <tr>
		  <td width="4" height="27" class="normalfnt"></td>
            <td><div align="center" class="normalfnt">Trans. No</div></td>
            <td><select name="cboPopUpNo" class="txtbox" id="cboPopUpNo" style="width:100px" onchange="loadPopUpDetails(this.value);">
			<option value="" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
        
  </table>
		

</div>
<!--End - Search popup-->
<script language="javascript" type="text/javascript">
var cancelLeftAllo = "<?php echo $PP_CancelLiabilityAllocation ?>";
</script>
</body>
</html>
