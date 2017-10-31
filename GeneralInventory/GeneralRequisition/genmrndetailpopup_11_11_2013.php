<?php
		  include "../../Connector.php"; 
		  $costCenterId = $_GET["costCenterId"];
?>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<table width="800" border="0" align="center" bgcolor="#FFFFFF">
 
  <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="0">
	  <tr class="cursercross mainHeading">
	  <td height="25" width="95%" >Select Items</td>
	  <td width="5%" ><img src="../../images/cross.png" alt="cross" class="mouseover" onclick="CloseOSPopUp('popupLayer1');" /></td>
	  </tr>
      <tr>
      <td colspan="3" class="normalfnt"><table width="100%" border="0" class="bcgl1"  >       
          <tr>
            <td width="14%" valign="middle" class="normalfnt">Main Category</td>
            <td width="20%"><select name="cboMainCategory" class="txtbox" id="cboMainCategory" style="width:120px" onchange="loadSubCategory();">	
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
            <td width="14%" class="normalfnt">Sub Category</td>
            <td width="25%"><select name="cboSubCategory" class="txtbox" id="cboSubCategory" style="width:110px">
            </select></td>
			<td width="13%" valign="middle" class="normalfnt"><input type="checkbox" name="chkAllItem" id="chkAllItem" />
			  All Items</td>
            <td width="14%"><img src="../../images/search.png" alt="Search" width="80" height="24" onclick="loadPopupItems();" /></td>
            </tr>
        </table></td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:280px; width:800px;">
          <table width="800px" cellpadding="0" cellspacing="1" id="mrnMatGrid" bgcolor="#F3E8FF" >
            <tr class="mainHeading4">
              <th width="3%" ><input type="checkbox" id="chkSelectAll" name="chkSelectAll" onclick="SelectAll(this);"/></th>
             <th width="28%" height="25" >Item Description</th>
              <th width="12%" >Bal To MRN Qty</th>
              <th width="11%">MRN Raised</th>
              <th width="11%" >Issued Qty</th>
			  <th width="11%" >Stock Balance </th>
              <th width="7%" >GRN No</th>
              <th width="7%" >GRN Year</th>
             <!-- <th width="10%" >GL Code</th>-->
            </tr>                     
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="39%" height="29">&nbsp;</td>
        <td width="12%"><img src="../../images/ok.png" alt="OK" width="86" 
		height="24" onclick="addtoMainGrid();" /></td>
        <td width="10%"><img src="../../images/close.png" width="97" 
		"height="24" border="0" onclick="CloseOSPopUp('popupLayer1');"/></td>
        <td width="39%">&nbsp;</td>
      </tr>
    </table></td>
 </tr>
</table>