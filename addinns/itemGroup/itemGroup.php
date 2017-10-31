<?php
session_start();
$backwardseperator = "../../";

include "../../Connector.php";	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Item Grouping</title>
<script src="itemGrp.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="frmItemGroup" id="frmItemGroup" method="post" action="" >
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Item Group<span class="vol">(Ver 0.3)</span><span id="itemGroup_popup_close_button"></span></div>
	</div>
	<div class="main_body">
  <table width="100%" border="0">
<!--    <tr>
      <td><?php #include "../../Header.php"; ?></td>
    </tr>-->
    <tr>
      <td><table width="550" border="0" align="center" class="tableBorder">
       <!-- <tr>
          <td colspan="5" height="35" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
                <td width="72%" class="mainHeading">Item Group</td>
                <td width="15%" class="seversion"> (Ver 0.3) </td>
              </tr>
            </table></td>
          </tr>-->
        <tr>
          <td width="17%">&nbsp;</td>
          <td width="23%">&nbsp;</td>
          <td width="33%">&nbsp;</td>
          <td width="17%">&nbsp;</td>
          <td width="10%">&nbsp;</td>
        </tr>
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Main Category <span class="compulsoryRed">*</span></td>
          <td><select name="cmbMainCat" id="cmbMainCat" class="txtbox" style="width:180px" onChange="getSubCatDetails();" tabindex="1">
          <?php 
		  		$SQL = "SELECT * FROM matmaincategory ";
				global $db;
				$result =$db->RunQuery($SQL);
		
			echo "<option value =\"".""."\">"."Select One"."</option>";
				while ($row=mysql_fetch_array($result))
				{
					echo "<option value=\"".$row["intID"]."\">".$row["strDescription"]."</option>";
				}
		  ?>
          </select>          </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Sub Category <span class="compulsoryRed">*</span></td>
          <td><select name="cmbSubCat" id="cmbSubCat" class="txtbox" style="width:180px" onChange="getItemDetails();" tabindex="2">
          </select>           </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Group Name</td>
          <td><select name="cmbGroup" id="cmbGroup" class="txtbox" style="width:180px" onChange="getGruopItemDetails()" tabindex="3">
          <?php 
		  	$SQL = "select matItemGroupId,matItemGroupName from matitemgroup ORDER BY matItemGroupName";
				global $db;
				$result =$db->RunQuery($SQL);
		
			echo "<option value =\"".""."\">"."Select One"."</option>";
				while ($row=mysql_fetch_array($result))
				{
					echo "<option value=\"".$row["matItemGroupId"]."\">".$row["matItemGroupName"]."</option>";
				}
		  ?>
          </select>          </td>
          <td><img src="../../images/add.png" alt="add"   class="mouseover" onClick="SaveGroup();"/></td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td colspan="5"><div align="center" id="divItem" style="overflow:scroll; width:550px; height:250px;"><table width="550" border="0" bgcolor="#996F03" cellspacing="1" id="tblItem">
            <tr >
             <td width="10%" bgcolor="#D1A739" class="mainHeading4">Select </td>
            <td width="20%" bgcolor="#D1A739" class="mainHeading4">Item Code</td>
              <td width="70%" bgcolor="#D1A739" class="mainHeading4">Item Name</td>
            </tr>
           <!-- <tr>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
            </tr>-->
          </table></div></td>
          </tr>
       	<tr>
       	  <td>&nbsp;</td>
       	  <td>&nbsp;</td></tr>
          <tr>
            <td height="34" colspan="5"><table width="550" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor=""><table width="550" border="0" class="tableFooter">
                    <tr>
                      <td width="11%">&nbsp;</td>
                      
					  					  				  					  					                     <td width="12%"><img  src="../../images/new.png" alt="New" name="New" id="butNew" tabindex="8" onClick="clearItemGroup();" class="mouseover" /></td>
					  					  				  					  					                     <td class="normalfnt" width="16%"><img id="butSave" src="../../images/save.png" width="84" height="24"  onClick="SaveGroupItem();" tabindex="4"></td>
                      <td width="19%"><img id="butDelete" src="../../images/delete.png"  onClick="deleteGroup();" tabindex="5"></td>
                      <td width="21%"><img id="butReport" tabindex="6" src="../../images/report.png"  onClick="viewGroupDetails();"></td>
                      <td width="21%"><a href="../../main.php"><img id="butClose" src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" tabindex="7"/></a></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
  </div>
  </div>
</form>
</body>
</html>
