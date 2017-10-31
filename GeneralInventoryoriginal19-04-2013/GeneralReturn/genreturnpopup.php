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
<table width="850" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" class="tableFooter" align="center">
  <tr class="mainHeading">
    <td colspan="5" height="25"><table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="777">Select Items</td>
    <td width="23"><img src="../../images/cross.png" width="17" height="17" onClick="CloseOSPopUp('popupLayer1')"></td>
  </tr>
</table></td>
  </tr>
  
  <tr>
    <td colspan="5" class="normalfnt">
	<table width="100%" cellspacing="3">
	<tr>
	<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" class="bcgl1" >
      <tr>
        <td width="103">Main Category</td>
        <td width="241"><select name="cboMainCategory" id="cboMainCategory" style="width:150px;" onChange="loadMrnDetailsToGrid();">
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
        <td width="122">Issue No Like</td>
        <td width="192"><input name="txtIssueNo" id="txtIssueNo" type="text" maxlength="5"></td>
        <td width="112" style="text-align:center"><img src="../../images/search.png" alt="" width="80" height="24" onClick="loadMrnDetailsToGrid();"></td>
      </tr>
    </table>
	</td>
	</tr>
	</table>
	</td>
  </tr>
  <tr class="mainHeading2">
    <td colspan="5" >Issue Items</td>
  </tr>
  <tr>
    <td colspan="5"><div id="divIssueItemList" style="overflow:scroll; width:850px; height:250px;">
      <table width="100%" border="0" cellspacing="1" cellpadding="0" id="IssueItem" bgcolor="#CCCCFF">
        <tr class="mainHeading4">
          <td width="30" height="20"><input type="checkbox" name="chkSelectAll" id="chkSelectAll" onClick="SelectAll(this);"></td>
          <td width="228">Details</td>
          <td width="78">Issue No </td>
          <td width="83">Issue Year </td>
          <td width="96">Issue Balance</td>
          <td width="74">Unit</td>
          <td width="74">GRN No </td>
          <td width="93">Cost Center </td>
          <td width="84">GL Code</td>
        </tr>
       </table>
    
    </div></td>
  </tr>
  <tr>
    <td width="101">&nbsp;</td>
    <td width="253">&nbsp;</td>
    <td width="126">&nbsp;</td>
    <td width="143">&nbsp;</td>
    <td width="177">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="tableFooter"> 
      <tr>
        <td align="center"><img src="../../images/addsmall.png" width="95" height="24" onClick="LoaddetailsTomainPage();"><img src="../../images/close.png" width="97" height="24" onClick="CloseOSPopUp('popupLayer1')"></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
