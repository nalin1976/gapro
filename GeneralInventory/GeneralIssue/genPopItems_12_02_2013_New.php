<?php
		  include "../../Connector.php";
		  $companyId = $_SESSION["FactoryID"]; 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" class="tableFooter" align="center">
  <tr class="mainHeading">
    <td colspan="5" height="25"><table width="800" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="777">Select Items</td>
    <td width="23"><img src="../../images/cross.png" width="17" height="17" onClick="CloseOSPopUp('popupLayer1')"></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td width="101">&nbsp;</td>
    <td width="253">&nbsp;</td>
    <td width="126">&nbsp;</td>
    <td width="143">&nbsp;</td>
     <td width="177">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="normalfnt"><table width="790" border="0" cellspacing="0" cellpadding="2" align="center">
      <tr>
        <td width="106">Main Category</td>
        <td width="268"><select name="cboMainCategory" id="cboMainCategory" style="width:150px;" onChange="LoadMrnNo();">
        <?php 
			$sql = "SELECT intID,strDescription FROM genmatmaincategory ORDER BY strDescription;";	
			$result = $db->RunQuery($sql);
				echo "<option value=\"".""."\">" .""."</option>" ;		
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
			}
		?>
        </select></td>
        <td width="86">MRN No</td>
        <td width="218"><select name="cboPopMrnNo" id="cboPopMrnNo" style="width:150px;">
        <?php 
			$SQL="SELECT DISTINCT concat(genmatrequisition.intMRNYear,'/',genmatrequisition.intMatRequisitionNo) as strMrnNo ".
					 "FROM genmatrequisition INNER JOIN ".
					 "     genmatrequisitiondetails ON genmatrequisition.intMatRequisitionNo = genmatrequisitiondetails.intMatRequisitionNo ".
					 "     WHERE (genmatrequisition.intStatus =1) ". 
					 "     AND (genmatrequisitiondetails.dblBalQty >0) ".
					 "     AND (genmatrequisition.intCompanyID='$companyId') order by genmatrequisition.intMatRequisitionNo desc";	
					 	
		$result = $db->RunQuery($SQL);
		echo "<option value=\"".""."\">" .""."</option>";
			while($row = mysql_fetch_array($result))
			{ 
				echo "<option value=\"". $row["strMrnNo"] ."\">" . $row["strMrnNo"] ."</option>"; 
			}
		?>
        </select></td>
        <td width="112"><img src="../../images/search.png" alt="" width="80" height="24" onClick="loadMrnDetailsToGrid();"></td>
      </tr>
    </table></td>
  </tr>
  <tr class="mainHeading2">
    <td colspan="5" >Issue Items</td>
  </tr>
  <tr>
    <td colspan="5"><div id="divIssueItemList" style="overflow:scroll; width:800px; height:250px;">
      <table width="800" border="0" cellspacing="1" cellpadding="0" id="IssueItem" bgcolor="#CCCCFF">
        <tr class="mainHeading4">
          <td width="33" height="20"><input type="checkbox" name="chkSelectAll" id="chkSelectAll" onClick="SelectAll(this);"></td>
          <td width="303">Details</td>
          <td width="109">Unit</td>
          <td width="128">Mrn Qty</td>
          <td width="122">Stock Balance</td>
          <td width="90">GRN No </td>
          <td width="95">GRN Location</td>
          <!--<td width="95">Cost Center </td>
          <td width="95">GL Code</td>-->
        </tr>       </table>
    
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><table width="780" border="0" cellspacing="0" cellpadding="0" align="center" class="tableFooter"> 
      <tr>
        <td align="center"><img src="../../images/addsmall.png" width="95" height="24" onClick="LoaddetailsTomainPage();"><img src="../../images/close.png" width="97" height="24" onClick="CloseOSPopUp('popupLayer1')"></td>
      </tr>
    </table></td>
  </tr>
</table>

<div id="divPopUpGRNList" style="width:350px; height:250px;  position:absolute; top:235px; left:470px; border:#000033 thin solid; z-index:9002; background-color:#FC9; visibility:hidden;">
<div style="height:20px; background-color:#600;">
	<span id=sClose style="position:absolute; font-family:Verdana, Geneva, sans-serif; color:#FFFFFF; font-weight:bold; font-size:12px; right:10px; " onClick="CloseDiv('divPopUpGRNList')" onMouseOver="changePointer(this)">Close</span></div>
<div style="overflow:scroll;  height:230px;">
	<table width="100%" cellspacing="1" cellspacing="0" bgcolor="#000000" id="tbGRNList">
    	<tr class="mainHeading4"><td>GRN No</td><td>Unit</td><td>Bal Qty</td><td>Select</td></tr>
    </table>
</div>	
</div>
</body>
</html>
