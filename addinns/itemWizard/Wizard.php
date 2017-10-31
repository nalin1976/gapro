<?php
 session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Material Wizard</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="wizard.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/autofill.js" type="text/javascript"></script>
<script src="../../javascript/tablednd.js" type="text/javascript"></script>
<script src="organizeCategory.js"></script>

<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>

<script type="text/javascript" language="javascript">
var mainID = <?php echo $_GET["intCatNo"]; ?>;
</script>

<script>
function validateSpecialCharacters() 
{ 
	var spclChars = "!@#$^&*'"; 
	var content = document.getElementById("itemwizard_txtassign").value; 
	for (var i = 0; i < content.length; i++) 
	{ 
		if (spclChars.indexOf(content.charAt(i)) != -1) 
		{ 
			alert ("Special characters are not allowed."); 
			document.getElementById("itemwizard_txtassign").value = ""; 
			return false; 
		} 
	} 
} 
</script>
</head>

<body>
  <?php
	include "../../Connector.php";

?>
 <table width="100%"  border="0" align="center" bgcolor="#FFFFFF">
   <tr><td ><?php include $backwardseperator.'Header.php'; ?></td>
   </tr><tr><td>
<form id="frmItemWizard" name="frmItemWizard">
  <table width="500" class="tableBorder" align="center">
    <tr>
      <td width="486" height="24" class="mainHeading"><table width="100%" border="0">
          <tr>
            <td width="88%" >Material Wizard -
              <?php
            	switch ($_GET["intCatNo"])
            	{
            		case 1:
            			echo " Fabric";
            			break;
            		case 2 :
            			echo " Accessories";
            			break;
            		case 3:
            			echo " Packing Materials";
            			break;
            		case 4:
            			echo " Services";
            			break;
            		case 5:
            			echo " Other";
            			break;
					case 6:
            			echo " Washing";
            			break;
            		default :
            			echo "";
            	
            	} 
            
            ?></td>
            <td width="12%" class="seversion">(Ver 0.3)</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
          <tr>
            <td width="22%">&nbsp;</td>
            <td width="30%" class="normalfnt">Sub Category</td>
            <td width="48%" ><select name="itemwizard_cbocategories" class="txtbox" onchange="GetProperty();" tabindex="1" id="itemwizard_cbocategories"style="width:150px">
                <?php
	
	$intCatNo=$_GET["intCatNo"];
	//$intCatNo=1;
	
	$SQL = "SELECT matsubcategory.intSubCatNo, matsubcategory.StrCatCode, matsubcategory.StrCatName, matsubcategory.intCatNo FROM matsubcategory WHERE intStatus = 1 AND intCatNo= ".$_GET["intCatNo"]." ORDER BY matsubcategory.StrCatName;";
	
	$_SESSION["CatID"]=$_GET["intCatNo"];
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		//echo "<option value=\"". "" ."\">" . "" ."Pass</option>" ;
		if(isset($_SESSION["intCatNo"]))
		{
			if ($_SESSION["intCatNo"] == $row["intSubCatNo"] )
				echo "<option selected=\"selected\" value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
			else
				echo "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
		}
	}
	
	?>
              </select>
			  
              &nbsp;<img src="../../images/addmark.png" style="vertical-align:bottom;" alt="Add" width="47" height="24" class="mouseover" onclick="getSubCatID();" id="imgP" /> </td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="273"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="20" colspan="3" bgcolor="#80AED5" class="mainHeading">&nbsp;</td>
          </tr>
          <tr>
            <td width="46%" class="mainHeading2" >Properties</td>
            <td width="8%" class="mainHeading2">&nbsp;</td>
            <td width="46%" class="mainHeading2">Available Properties</td>
          </tr>
          <tr>
            <td height="141" valign="top"><select name="itemwizard_cbocolors" size="10" class="txtbox" id="itemwizard_cbocolors" tabindex="2" ondblclick="MoveItemRight();" style="width:225px">
                <?php
	
	$SQL = "SELECT * FROM matproperties WHERE intStatus = 1  ORDER BY matproperties.strPropertyName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intPropertyId"] ."\">" . $row["strPropertyName"] ."</option>" ;
	}
	
	?>
            </select></td>
            <td><table width="100%" border="0">
                <tr>
                  <td><div align="center"><img src="../../images/bw.png" alt="&gt;" width="18" height="19" class="mouseover" onclick="MoveItemRight();" /></div></td>
                </tr>
                <tr>
                  <td><div align="center"><img src="../../images/fw.png" alt="&lt;" width="18" height="19" class="mouseover" onclick="MoveItemLeft();" /></div></td>
                </tr>
                <tr>
                  <td><div align="center"></div></td>
                </tr>
                <tr>
                  <td><div align="center"><img src="../../images/ff.png" alt="&gt;&gt;" width="18" height="19" class="mouseover" onclick="MoveAllItemsLeft();"/></div></td>
                </tr>
                <tr>
                  <td><div align="center"><img src="../../images/fb.png" alt="&lt;&lt;" width="18" height="19" class="mouseover" onclick="MoveAllItemsRight();" onkeypress="" /></div></td>
                </tr>
            </table></td>
            <td valign="top"><select name="itemwizard_cboAvailable" size="10" multiple="multiple" class="txtbox" tabindex="3" id="itemwizard_cboAvailable" ondblclick="MoveItemLeft();" onkeypress="DeleteItem(event);"  style="width:225px">
            </select></td>
          </tr>
          <tr>
            <td height="15" colspan="3" class="normaltxtmidb2L">&nbsp;</td>
          </tr>
          <tr>
            <td height="11" ><table width="100%" border="0" class="tableBorder">
                <tr>
                  <td height="21" colspan="2" class="mainHeading2">Property</td>
				  <td height="21" class="mainHeading2"><img src="../../images/edit.png" style="vertical-align:bottom;" alt="Add" width="20" height="15" class="mouseover" onclick="showPropertyModifyForm();" />&nbsp;</td>
                </tr>
                <tr>
                  <td width="75%"><input name="itemwizard_txtassign" type="text"  class="txtbox" id="itemwizard_txtassign" size="20" tabindex="4" maxlength="20" onclick="closeList();" onkeydown="ItemListKeyEventHandler(event);" onkeyup="GetAutoComplete(event,this.value,'../../autofill.php?RequestType=styleItemProperty&',this.id); validateSpecialCharacters();"/></td>
                  <td width="5%"><input type="checkbox" name="itemwizard_chkassign" id="itemwizard_chkassign" checked="checked"/></td>
                  <td width="*" class="normalfnt">Assign</td>
                </tr>
                <tr>
				  <td class="mbari13" colspan="3"><div align="right"><img src="../../images/addsmall.png" alt="add" width="95" height="24" class="mouseover"  onclick="saveAndAssign();" /></div></td>				   
                </tr>
            </table></td>
			<td>&nbsp;			</td>
			<td height="11" >
			<?php
			if($intCatNo==1)
			{
			?>
			<table width="99%" border="0" class="tableBorder">
                <tr>
                  <td height="21" class="mainHeading2">Fabric Content </td>
                </tr>
                <tr>
                  <td><select name="itemwizard_cboFabricContent" class="txtbox" id="itemwizard_cboFabricContent" tabindex="5"  style="width:212px;">
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
                  </select>                  </td>
                </tr>
                <tr>
                  <td class="mbari13"><div align="right"><img src="../../images/addsmall.png" alt="add" width="95" height="24" class="mouseover" onclick="showFabricContentForm();" /></div></td>
                </tr>
            </table>
			<?php
			}
			?>			</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="32" class="mbari13"><table width="100%" border="0">
          <tr>
            <td width="25%" height="26">&nbsp;</td>
            <td width="29%">&nbsp;</td>
            <td width="21%" align="right"><a href="../../main.php"><img src="../../images/close.png" alt="Close" width="97" height="24" border="0" class="mouseover" /></a></td>
            <td width="25%" align="right"><img src="../../images/next.png" alt="next" width="95" height="24" class="mouseover" onclick="ShowNameCreationWindow();" /></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
</td><td height="417">
 </tr></table>
<script type="text/javascript" language="javascript">
var UnitsIDs = [];
var UnitsNames = [];
 <?php
	
	$SQL = "select strUnit,strTitle from units  order by strTitle;";
	
	$result = $db->RunQuery($SQL);
	
	$loop = 0;
	
	while($row = mysql_fetch_array($result))
	{
		echo "UnitsIDs[". $loop  ."] = \"" . $row["strUnit"] ."\";" ;
		echo "UnitsNames[". $loop  ."] = \"" . $row["strTitle"] ."\";" ;
		$loop ++;
	}
	
	?>
</script>
</body>
</html>
