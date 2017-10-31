<?php
session_start();
$backwardseperator = "../../";
$companyID 			= $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Item Transfer</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--

-->
</style>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="itemTransfer.js" type="text/javascript"></script>
<script type="text/javascript">

</script>

<style type="text/css">
<!--
.style1 {font-size: 9px}
.style3 {font-family: Verdana}
/*body {
	background-color: #CCCCCC;
}*/
-->
</style>
</head>

<body>
<?php

	include "../../Connector.php";	
	$arrStatus  = explode(',',$headerPub_AllowOrderStatus);
?>
<form name="frmItemTransfer" id="frmItemTransfer">
<table width="100%" border="0" align="center">
	<tr><td><?php include '../../Header.php'; ?>
     </td>
    </tr>
    <tr><td>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="bcgl1">

  <tr>
  	<td height="25" colspan="8"  class="mainHeading">Item transfer</td>
  </tr>
  <tr>
    <td colspan="7"><table width="100%" border="0">
      <tr>
	    <tr>
   <td height="6" colspan="8" class="normalfnt2bld"><table width="100%">
       <tr>
         <td width="21%">Source Bin</td>
         <td width="10%"><span class="normalfnt">Main Category </span></td>
         <td width="15%"><select name="cboMainCategory" class="txtbox" id="cboMainCategory" style="width:120px" onchange="loadSubStores(this.value);">
           <?PHP		
					$SQL = "select intID,strDescription from genmatmaincategory where status=1";
							
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						echo "<option value=\"".$row["intID"]."\">".$row["strDescription"]."</option>";
					}
				
				?>
         </select></td>
         <td width="10%" class="normalfnt">Sub Category </td>
         <td width="15%">
           <select name="cboSubCategory" class="txtbox" id="cboSubCategory" style="width:120px" >
             <?PHP		
				
					$SQL = "select intSubCatNo,StrCatName from genmatsubcategory where intStatus=1 
							and intCatNo='$cboMainCategory'";
							
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						echo "<option value=\"".$row["intSubCatNo"]."\">".$row["StrCatName"]."</option>";
					}
				
			?>
           </select>        </td>
         <td width="6%" class="normalfnt"> Item </td>
         <td width="23%">
           <input type="text" name="txtItemDiscription" id="txtItemDiscription" class="txtbox" width="200px" /></td>
       </tr>
     </table></td>
  </tr>
        <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
		
          <tr>
            <td width="75" height="25" class="normalfnt">&nbsp;</td>
            <td width="131" class="normalfnt">&nbsp;</td>
            <td width="75" class="normalfnt">&nbsp;</td>
            <td width="122" class="normalfnt">&nbsp;</td>
          <td width="84" class="normalfnt">&nbsp;</td>
          <td width="16" class="normalfnt">&nbsp;</td>
            <td width="79" class="normalfnt">Cost Center</td>
            <td width="271" class="normalfnt"><select name="cboCostCenter" class="txtbox" id="cboCostCenter" style="width:250px" onchange="emtyBothTable();">
				
				<?PHP		
				
					$SQL="select intCostCenterId,strDescription from costcenters where intStatus=1 
					and intFactoryId='$companyID'";
					
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						echo "<option value=\"".$row["intCostCenterId"]."\">".$row["strDescription"]."</option>";
					}
				
				?>
                    </select></td>
            <td width="80" class="normalfnt"><img src="../../images/search.png" alt="search" class="mouseover" onclick="LoadSourceBinDetails();" /></td>
            <td width="9" class="normalfnt">&nbsp;</td>
          </tr>
        </table></td>
        </tr>

    </table></td>
  </tr>
  
   <tr>
    <td height="15" colspan="7"  class="normalfnt" ><div id="divcons" style="overflow:scroll; height:200px; width:950px;">
      <table id="tblSource" width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF">
        <tr  class="mainHeading4">
          <td width="23%" height="25" >Item Description</td>
          <td width="7%" >Unit</td>
          <td width="8%" >Item Qty </td>
          <td width="11%">Trans Qty </td>
          <td width="6%" > Transfer</td>
           <td width="7%" > GRN No</td>
           <td width="7%" >GLCode</td>
            </tr>
      </table>
    </div></td>
  </tr>
  <tr><td><table width="100%">
  <tr>
    <td width="136" class="normalfnt2bld">Destination Bin </td>
    <td width="9" class="normalfnt2BI">&nbsp;</td>
    <td width="52" class="normalfnt2BI">&nbsp;</td>
    <td width="90" class="normalfnt2BI">&nbsp;</td>
    <td width="163" class="normalfnt2BI">&nbsp;</td>
    <td width="93" class="normalfnt2BI"><span id="spanOrderTransferCount"></span></td>
    <td width="117" align="right" class="normalfnt2BI"></td>
    <td width="254" class="normalfnt2BI">&nbsp;</td>
  </tr>
  </table>
  </td>
  </tr>
<td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
  <tr>
    <td width="8%" height="25" class="normalfnt">Cost Center</td>
    <td class="normalfnt"><select name="cboDesCostCenter" class="txtbox" id="cboDesCostCenter" style="width:250px" onchange="emptyDesTable();"  >
      <?PHP		
				
					$SQL="select intCostCenterId,strDescription from costcenters where intStatus=1 
					and intFactoryId='$companyID'";
					
					$result =$db->RunQuery($SQL);
					echo "<option value =\"".""."\">"."Select One"."</option>";
					while ($row=mysql_fetch_array($result))
					{	
						echo "<option value=\"".$row["intCostCenterId"]."\">".$row["strDescription"]."</option>";
					}
				
				?>
    </select></td>
    <td width="9%" class="normalfnt">&nbsp;</td>
    <td width="13%" class="normalfnt">&nbsp;</td>
    <td width="6%" class="normalfnt">&nbsp;</td>
    <td width="15%" class="normalfnt">&nbsp;</td>
    <td width="5%" class="normalfnt">&nbsp;</td>
    <td width="9%" class="normalfnt">&nbsp;</td>
  </tr>
</table></td>
 
   <tr>
    <td height="15" colspan="7"  class="normalfnt" ><div id="divcons" style="overflow:scroll; height:200px; width:950px;">
      <table id="tblDestination" width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF">
        <tr  class="mainHeading4">
          <td width="5%" >Del</td>
          <td width="31%" height="25" >Item Description</td>
          <td width="12%" >Unit</td>
          <td width="12%" >Item Qty </td>
          <td width="12%">Trans Qty </td>
          <td width="15%" > GRN No</td>
          <td width="13%" >GL Code</td>
            </tr>
      </table>
    </div></td>
  </tr>
	    
	    <tr>
    <td height="15" colspan="7"  class="normalfnt" ><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
      <tr>
        <td width="40%" class="normalfntMid">
		<img src="../../images/new.png" alt="new" onclick="clearAll();" />
        <img src="../../images/save.png" id="butSave" alt="save" width="84" height="24" class="mouseover" onclick="GetNo();" />
        <a href="../../main.php"><img src="../../images/close.png" alt="closed" width="97" height="24" border="0" class="mouseover" /></a>
        </td>
      </tr>
    </table></td>
    </tr>
</table>
</td></tr></table>
</form>
</body>
</html>
