<?php
 session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Item Request</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="itemReq.js" type="text/javascript" language="javascript"></script>
<script src="../../javascript/script.js" type="text/javascript" language="javascript"></script>
<script src="../../javascript/autofill.js" type="text/javascript"></script>
</head>
<?php
	include "../../Connector.php";

?>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include $backwardseperator.'Header.php'; ?></td>
  </tr>
 </table>
 <div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Item Request <span class="vol">(Ver 0.3)</span><span id="chequeInformation _popup_close_button"><!--<img onclick="" align="right" style="visibility:hidden;" src="../../images/cross.png" />--></span></div>
	</div>
	<div class="main_body">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><form name="frmItemRequest" method="post" action="" id="frmItemRequest">
    <table width="625" border="0" cellpadding="0" cellspacing="0" align="center" class="tableBorder">
    <tr><td>
      <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
       <tr>
          <td height="10"></td>
        </tr>
        <tr>
          <!--<td height="26" class="mainHeading">Item Request</td>-->
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="600" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
            <tr>
              <td width="123" height="20">Main Category</td>
              <td width="178"><select name="cboMainCat" id="cboMainCat" style="width:150px;" onChange="getSubCat();">
              <?php 
			  $intMainCat = $_POST["cboMainCat"];
			  $SQL = 	"SELECT matmaincategory.intID, matmaincategory.strDescription FROM matmaincategory
			            order by matmaincategory.intID ";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
							if($intMainCat==$row["intID"])
								echo "<option selected=\"selected\" value=\"". $row["intID"] ."\">" . trim($row["strDescription"]) ."</option>" ;								
							else
								echo "<option value=\"". $row["intID"] ."\">" . trim($row["strDescription"]) ."</option>" ;
						}
			  ?>
              </select>              </td>
              <td width="98">Sub Category</td>
              <td width="201"><select name="cboSubCat" id="cboSubCat" style="width:170px;" onChange="loadAssignProperties();">
              <?php
						$intSubCatNo = $_POST["cboSubCat"];
							
						$SQL = 	"SELECT MSC.intSubCatNo, MSC.StrCatName FROM matsubcategory  MSC
								WHERE MSC.intCatNo <>'' ";
								
						if($intMainCat!='')
							$SQL .= " AND MSC.intCatNo =  '$intMainCat'";
							
						$SQL .= " order by MSC.StrCatName ";
						
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						/*while($row = mysql_fetch_array($result))
						{
						if($intSubCatNo==$row["intSubCatNo"])
							echo "<option selected=\"selected\" value=\"". $row["intSubCatNo"] ."\">" . trim($row["StrCatName"]) ."</option>" ;								
						else
							echo "<option value=\"". $row["intSubCatNo"] ."\">" . trim($row["StrCatName"]) ."</option>" ;
						}*/
						
						?>
              </select>              </td>
            </tr>
            <tr>
            	<td height="20">Fabric Content</td>
                <td><select name="cbofabric_content" id="cbofabric_content" style="width:150px;">
                <option value=""></option>
				  <?php
				  $SQL = "SELECT contentID,contentName FROM fabriccontent;";
	
				$result = $db->RunQuery($SQL);
				
				while($row = mysql_fetch_array($result))
				{
				  ?>
                    <option value="<?php echo $row["contentID"];  ?>"><?php echo $row["contentName"];?></option>
				<?php
				}
				?>
                </select>
                </td>
               <td>&nbsp;</td>
               <td>&nbsp;</td> 
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr class="mainHeading2">
          <td >Assign Properties</td>
        </tr>
        <tr>
          <td><div id="itemProperty" style="overflow:scroll; height:150px;">
            <table width="600" border="0" cellspacing="1" cellpadding="0" id="tblValues" bgcolor="#CCCCFF">
              <tr class="mainHeading4">
                <td height="25">Property Name</td>
                <td>Property Value</td>
                <td>Display?</td>
                <td>Display Str</td>
                <td>Place</td>
                <td>Serial</td>
              </tr>
            </table>
          </div> </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="600" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
            <tr>
              <td width="123" height="20">Unit</td>
              <td width="178"><select name="cboUnits" id="cboUnits" style="width:96px;">
              </select>              </td>
              <td width="98">Wastage</td>
              <td width="201"><input type="text" name="txtWastage" id="txtWastage" style="width:95px;" maxlength="11"></td>
            </tr>
            <tr>
              <td height="20">Purchase Unit</td>
              <td><select name="cboPurchaseUnit" id="cboPurchaseUnit" style="width:96px;">
              </select></td>
              <td>Unit Price</td>
              <td><input type="text" name="txtUnitPrice" id="txtUnitPrice" style="width:95px;" maxlength="11"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
            <tr>
              <td width="197" height="26">&nbsp;</td>
              <td width="107"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0"></a></td>
              <td width="294"><img src="../../images/finish.png" width="96" height="24" onClick="Savenfinish();"></td>
            </tr>
          </table></td>
        </tr>
      </table>
      </td></tr></table>
        </form>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</div>
</body>
</html>
