<?php
	session_start();
	include "../Connector.php";	
	$backwardseperator = "../";
	$UserId = $_SESSION["UserID"];
	$companyId=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Items :: Material Transfer To Eplan Web</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<script type="text/javascript" src="materialsTransferoldtonew.js"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../java.js" type="text/javascript"></script>
</head>

<body >
<form name="frmMeterialsTransfer" id="frmMeterialsTransfer" >
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include '../Header.php'; ?></td>
</tr>
  <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white">Style Items - Material Transfer To Eplan Web </td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td height="39"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            
            <td width="8%" class="normalfnt">New Style</td>
            <td width="18%" class="normalfnt"><select name="cboFrom"  class="txtbox" id="cboFrom" style="width:150px" onchange="SeachFromSC();">
              <?php
		$SQL3="SELECT DISTINCT ".
			  "specification.intSRNO, ".
			  "specification.intStyleId, ".
			  "specification.intOrdComplete ".
			  "FROM ".
			  "specification ".
			  "WHERE ".
			  "specification.intOrdComplete =0 ".
			  "Order By specification.intStyleId";

	$result3 =$db->RunQuery($SQL3);
		
			echo "<option value =\"".""."\">"."Select One"."</option>";
		while ($row3=mysql_fetch_array($result3))
		{			
			echo "<option value=\"".$row3["intSRNO"]."\">".$row3["intStyleId"]."</option>";
		}
			
?>
                        </select></td>
            <td width="7%" class="normalfnt">New SCNO  </td>
            <td width="12%" class="normalfnt"><select name="cboFromScno"  class="txtbox" id="cboFromScno" style="width:100px" onchange="SeachFromStyle();RemoveData();">
<?php
	$SQL4="SELECT DISTINCT ".
		  "specification.intStyleId, ".	
		  "specification.intSRNO ".	 
		  "FROM ".
		  "specification ".
		  "WHERE ".
		  "specification.intOrdComplete =0 ".
		  "Order By specification.intSRNO desc";

	$result4 =$db->RunQuery($SQL4);
		
			echo "<option value =\"".""."\">"."Select One"."</option>";
		while ($row4=mysql_fetch_array($result4))
		{		
			echo "<option value=\"".$row4["intStyleId"]."\">".$row4["intSRNO"]."</option>";
		}
			
?>
            </select></td>           
            <td width="2%" class="normalfnt">&nbsp;</td>
            <td width="6%" class="normalfnt">Old Style</td>
            <td width="18%" class="normalfnt"><input name="cboTo"  class="txtbox" id="cboTo" style="width:150px" maxlength="30">              
            </select></td>
            <td width="7%" class="normalfnt">Old SCNO </td>
            <td width="12%" class="normalfnt"><input name="cboToScno"  class="txtbox" id="cboToScno" style="width:100px" maxlength="5">
              </select></td>
            <td width="10%" class="normalfnt"><img src="../images/search.png" alt="search" id="cmdSearch" name="cmdSearch" width="80" height="24" onclick="LoadDetails()"/></td>
          </tr>
          
          <tr>
            <td colspan="10" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="7%">Main Store</td>
                <td width="16%"><select name="cboMainStores"  class="txtbox" id="cboMainStores" style="width:150px" onchange="LoadSubStores(this.value);">
                  <?php
	$SQL="select strMainID,strName from mainstores where intStatus=1 ";

	$result =$db->RunQuery($SQL);
		
			echo "<option value =\"".""."\">".""."</option>";
		while ($row=mysql_fetch_array($result))
		{		
			echo "<option value=\"".$row["strMainID"]."\">".$row["strName"]."</option>";
		}
			
?>
                </select></td>
                <td width="7%">Sub Store </td>
                <td width="16%"><select name="cboSubStore"  class="txtbox" id="cboSubStore" style="width:150px" onchange="LoadLocation(this.value)">
                  <?php
	$SQL="select strSubID,strSubStoresName from substores where intStatus=1 ";

	$result =$db->RunQuery($SQL1);
		
			echo "<option value =\"".""."\">".""."</option>";
		while ($row=mysql_fetch_array($result))
		{		
			echo "<option value=\"".$row["strSubID"]."\">".$row["strSubStoresName"]."</option>";
		}
			
?>
                </select></td>
                <td width="8%">Location</td>
                <td width="19%"><select name="cboLocation"  class="txtbox" id="cboLocation" style="width:150px" onchange="LoadBins(this.value);">
                  <?php
	$SQL="select strLocID,strLocName from storeslocations where intStatus=1 ";

	$result =$db->RunQuery($SQL1);
		
			echo "<option value =\"".""."\">".""."</option>";
		while ($row=mysql_fetch_array($result))
		{		
			echo "<option value=\"".$row["strLocID"]."\">".$row["strLocName"]."</option>";
		}
			
?>
                </select></td>
                <td width="9%">Bin</td>
                <td width="18%"><select name="cboBins"  class="txtbox" id="cboBins" style="width:150px" >
                  <?php
	$SQL="select strBinID,strBinName from storesbins where intStatus=1 ";

	$result =$db->RunQuery($SQL1);
		
			echo "<option value =\"".""."\">".""."</option>";
		while ($row=mysql_fetch_array($result))
		{		
			echo "<option value=\"".$row["strBinID"]."\">".$row["strBinName"]."</option>";
		}
			
?>
                </select></td>
                </tr>
            </table></td>
            </tr>
        </table></td>
        </tr>
		
		
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="89%" bgcolor="#9BBFDD" class="normalfnth2"></td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:350px; width:950px;">
          <table width="930" cellpadding="0" cellspacing="0" id="tblMain">
            <tr>
              <td width="3%" height="33" bgcolor="#498CC2" class="normaltxtmidb2"><input type="checkbox" onclick="SelectAll(this);" /></td>
              <td width="32%" bgcolor="#498CC2" class="normaltxtmidb2">Discription1</td>
              <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">BuyerPoNo</td>
              <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
              <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Trans. Qty</td>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Unit Price</td>
              <td width="17%" bgcolor="#498CC2" class="normaltxtmidb2">Remarks </td>              
              </tr>
<!--      <tr>
              <td><div align="center"><img src="../images/del.png" alt="del" width="15" height="15" /></div></td>
              <td class="normalfnt">POC</td>
              <td class="normalfnt">#main Ratio#</td>
              <td class="normalfntMidSML">wedwewe</td>
              <td class="normalfntMidSML">0</td>
              <td class="normalfnt">Pocketing</td>
              <td class="normalfntRite">653.45</td>
              <td class="normalfntMid"><div align="right"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="8" style="text-align:right" onkeypress="return isNumberKey(event);" value="0" /></div> </td>
              <td class="normalfntRite"><div align="center"><img src="../images/location.png" alt="del" width="80" height="20" /></div></td>
              </tr>-->
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="28%" height="29">&nbsp;</td>
        <td width="11%"><img src="../images/new.png" alt="new" name="cmdNew" width="96" height="24" class="mouseover"  id="cmdNew" onclick="ClearForm();"/></td>
        
        <td width="9%"><img src="../images/save.png" alt="save" width="84" id="butSave" height="24" onclick="SaveValidation();"/></td>
        <td width="11%"><a href="../main.php"><img src="../images/close.png" width="97" height="24" border="0" class="mouseover" /></a></td>
        <td width="28%"><label></label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td id="StatusBar">&nbsp;</td>
  </tr>
</table>
</form>
<!--Start - Open search job no window-->
<div style="left:426px; top:149px; z-index:10; position:absolute; width: 261px; visibility:hidden; height: 61px;" id="jobSearch" ><table width="260" height="59" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
		  	<td width="4" height="22" class="normalfnt"></td>
            <td width="44" height="22" class="normalfnt">State </td>
            <td width="108"><select name="select3" class="txtbox" id="cboState" style="width:100px" onchange="LoadPopUpJobNo();">              
              <option value="0">Saved</option>
              <option value="1">Approved</option>
			  <option value="2">Autorised</option>
			  <option value="3">Confirmed</option>
			  <option value="10">Cancelled</option>
            </select></td>
            <td width="37" class="normalfnt">Year</td>
            <td width="55"><select name="select4" class="txtbox" id="cboYear" style="width:55px" onchange="LoadPopUpJobNo();">
             
			   <?php
	
	$SQL = "SELECT DISTINCT intTransferYear FROM itemtransfer ORDER BY intTransferYear DESC;";	
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
            <td><div align="center" class="normalfnt">Job No</div></td>
            <td><select name="select" class="txtbox" id="cboJobNo" style="width:100px" onchange="loadTransferIn();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
        
        </table>
		

</div>
<!--End - Open search job no window-->		
<!--Start - open Mian Bin locations-->
<div style="left:525px; top:113px; z-index:10; position:absolute; width: 408px; visibility:hidden; height: 86px;" id="ShowMainBin" >
  <table width="407" height="88" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
		  	<td width="2" height="28" class="normalfnt"></td>
            <td width="99" height="28" class="normalfnt">Main Stores </td>
           <td width="279"><select name="select3" class="txtbox" id="cboMainStores" style="width:250px" onchange="LoadPopUpSubStores();"> 
		   <option value="Select One" selected="selected">Select One</option>           </select></td>
           <td width="25" align="right" valign="top"><img src="../images/cross.png" alt="close" width="17" height="17" align="top" onclick="CloseMainBin();" /></td>
          </tr>
          <tr>
		  <td width="2" height="27" class="normalfnt"></td>
            <td><div align="center" class="normalfnt">Sub Stores </div></td>
            <td colspan="2"><select name="select" class="txtbox" id="cboSubStores" style="width:250px" onchange="LoadPopUpLocations();">
			<option value="Select One" selected="selected">Select SubStores</option>
            </select>            </td>
          </tr>
		   <tr>
		  <td width="2" height="27" class="normalfnt"></td>
            <td><div align="center" class="normalfnt">Location</div></td>
            <td colspan="2"><select name="select" class="txtbox" id="cboLocation" style="width:250px" onchange="loadTransferIn();">
			<option value="Select One" selected="selected">Select Location</option>
            </select>            </td>
          </tr>
  </table>
		
	
</div>
<!--End - open Mian Bin locations-->
<script type="text/javascript">
var canSaveInterjobTransfer = <?php echo $canSaveInterjobTransfer?"true":"false"; ?>;
var canApproveInterjobTransfer = <?php echo $canApproveInterjobTransfer?"true":"false"; ?>;
var canAuthorizeInterjobTransfer = <?php echo $canAuthorizeInterjobTransfer?"true":"false"; ?>;
var canConfirmInterjobTransfer = <?php echo $canConfirmInterjobTransfer?"true":"false"; ?>;
var canCancelInterjobTransfer = <?php echo $canCancelInterjobTransfer?"true":"false"; ?>;
</script>
</body>
</html>


