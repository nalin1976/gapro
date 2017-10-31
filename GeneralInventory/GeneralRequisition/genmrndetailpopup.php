<script language="javascript" type="text/javascript">

	//alert('Test');	
	


</script>
<?php
		  include "../../Connector.php"; 
		  //$costCenterId = $_GET["costCenterId"];
		  $storesId = $_GET["mainStoresId"];
?>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.ui-autocomplete{position:absolute; 				 
				 width:1px; 
				 border:#CCC thin solid; 				
				 font-family:Arial, Helvetica, sans-serif;
				 font-size:12px; line-height:22px; background-color:#FFFFFF; max-height:300px;  }
				 
.ui-menu{list-style:none; position:absolute; padding:10px 5px 5px 10px; width:50px; overflow:scroll;  }
.ui-menu-ietm{margin:0; padding:0; zoom:1; float:left; clear:left; }
/*.ui-menu-divider{border:#000000 thin solid;}
.ui-corner-all
{
    border-bottom-left-radius: 4px;
	border-bottom-right-radius: 4px;
}*/

.ui-state-hover {	
	width:150px;
	cursor:pointer;  
	padding:10px 5px 5px 0px; width:50px;
	
	
}

#menu_container{width::50px; cursor:pointer;}
</style>

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
            <td width="14%"><img src="../../images/search.png" alt="Search" width="80" height="24" onclick="loadPopupItems(<?php echo $storesId; ?>);" /></td>
            </tr>
            <tr>
        	<td colspan="2" >
            	<table width="100%" border="0" > 
                	<td width="28%" valign="middle" class="normalfnt">Item Code</td>
                    <div id="menu_container"></div>
                    <td width="72%"><input type='text' id="txtItemCode" name="txtItemCode" class="txtbox" onkeyup="listCodes()"/></td>	
                </table>
            </td>
            <td colspan="2">
            	<table width="100%" border="0" > 
                	<td width="28%" valign="middle" class="normalfnt">Item Like</td>
                    <div id="menu_container"></div>
                    <td width="72%"><input type='text' id="txtItemDescLike" name="txtItemDescLike" class="txtbox"/></td>	
                </table>
            </td>
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
              <th width="15%" height="25" align="left" >&nbsp;Item Code</th>
              <th width="32%" height="25" >Item Description</th>
              <th width="8%" >Bal To MRN Qty</th>
              <th width="9%">MRN Raised</th>
              <th width="9%" >Issued Qty</th>
			  <th width="9%" >Stock Balance </th>
              <th width="8%" >GRN No</th>
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
		height="24" border="0" onclick="CloseOSPopUp('popupLayer1');"/></td>
        <td width="39%">&nbsp;</td>
      </tr>
    </table></td>
 </tr>
</table>
