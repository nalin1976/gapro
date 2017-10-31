<?php
include "../../Connector.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../GeneralSupplierReturn/gensupplierreturn.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<table width="850" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder" >
<tr class="mainHeading" >
	  <td width="807" height="25" >Select Items</td>
	  <td width="39" ><img src="../../images/cross.png" alt="cross" class="mouseover" onClick="CloseOSPopUp('popupLayer1');" /></td>	 
	  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="100%"><table width="100%" border="0" >
          <tr>
            <td width="6%" class="normalfnt">Material</td>
			<td width="10%" class="normalfnt"><select name="cbomaterial" class="txtbox" id="cbomaterial" style="width:120px" onChange="loadSubCategory();" >
			<?php 			
			$sql = "SELECT intID,strDescription FROM genmatmaincategory ORDER BY strDescription;";	
			$result = $db->RunQuery($sql);
				echo "<option value=\"".""."\">" .""."</option>" ;		
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
			}
		?>
            </select> </td>
            <td width="7%" class="normalfnt">Category</td>
            <td width="14%" class="normalfnt"><select name="cboSubCategory" class="txtbox" id="cboSubCategory" style="width:150px" onChange="loadMrnDetailsToGrid();">
                                    </select></td>
			<td width="7%" class="normalfnt"> Item Like </td>
			<td width="14%" class="normalfnt"><input type="text" id="txtisslike" name="txtisslike" size="13" class="txtbox" /></td>
            <td width="15%" class="normalfntMid"><img src="../../images/search.png" alt="search" width="80" height="24" onClick="loadMrnDetailsToGrid();" /></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr class="mainHeading2">
        <td height="21" ><div align="center">Issue Items</div></td>
        </tr>
      <tr>
        <td class="normalfnt"><div id="divIssueItem" style="overflow:scroll; height:220px; width:850px;">
          <table id="IssueItem" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="3%" height="30" > <input type="checkbox" name="chksel" id="chksel" onChange="SelectAll(this)"/></td>
			  <td width="11%" >Grn No</td>
              <td width="43%" >Description</td>
              <td width="9%" >Unit</td>
              <td width="10%" >Grn Qty </td>
              <td width="11%" >Stock Bal </td>
              <!--<td width="13%" >GL Code</td>-->          
              </tr>
    <!--  				<tr>
			  <td><div align="center">
			  <input type="checkbox" name="chksel" id="chksel" />
			  </div></td>
				  <td class="normalfntMid" >qwdqw</td>
				  <td class="normalfnt">wdq</td>
				  <td class="normalfntMid">dqw</td>
				  <td class="normalfntMid">qwdq</td>				  				 
			</tr>-->    
          </table>
        </div></td>
        </tr>
    </table></td>
 </tr>
  <tr>
    <td colspan="2"><table width="100%" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td height="29" style="text-align:center"><img src="../../images/ok.png" width="86" height="24" onClick="LoaddetailsTomainPage();"/><img src="../../images/close.png" width="97" height="24" border="0" onClick="CloseOSPopUp('popupLayer1');" /></td>
        </tr>
   </table></td>
  </tr>
</table>
</body>
</html>
