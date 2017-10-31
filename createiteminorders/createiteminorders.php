<?php
session_start();
$backwardseperator = "../";
include "../Connector.php";

			$mainMaterial		= $_GET["mainMaterial"];		
			$subCategory		= $_GET["subCategory"];	
			$subCatName         = $_GET["subCatName"];

?>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #B3F9AE}
-->
</style>
<!--<script language="javascript" type="text/javascript" src="../addinns/itemWizard/wizard.js"></script>-->
<script type="text/javascript" src="javascript/autofill.js"></script>

<table width="70%" border="0" >
            <tr>
            <td height="16" colspan="2"  bgcolor="#498cc2" class="mainHeading">
			<table width="100%"border="0" >
                <tr>
                  <td width="93%" class="cursercross" onmousedown="grab(document.getElementById('frmCreateiteminorders'),event);" >Create item - <?php echo $subCatName; ?></td>
                  <td width="7%">
		         <img src="images/cross.png" alt="close" width="17" height="17"
				 onClick="closePopupBox(10);" class="mouseover"/></td>
                </tr>
              </table></td>
            </tr>

            <tr>
          <td height="0" colspan="2" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                <tr>
                  <td width="100%"><div align="center">
                    <div id="divcons" style="overflow:scroll; height:155px; width:100%;">
                      <table id="tblValues" width="620" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                        <tr>
						<td height="20" width="17" bgcolor="#498CC2" class="normaltxtmidb2">No</td>
                          <td width="115" bgcolor="#498CC2" class="normaltxtmidb2">Property Name </td>
                          <td width="152"  height="15" bgcolor="#498CC2" class="normaltxtmidb2" colspan="2">Property Value </td>
                           <!--<td width="25"  height="15" bgcolor="#498CC2" class="normaltxtmidb2">+ </td>-->
                          <td width="53" bgcolor="#498CC2" class="normaltxtmidb2">Display</td>
						  <td width="155" bgcolor="#498CC2" class="normaltxtmidb2">Display Description </td>
						   <td width="53" bgcolor="#498CC2" class="normaltxtmidb2">Place</td>
						    <td width="53" bgcolor="#498CC2" class="normaltxtmidb2">Serial</td>
					    </tr>
<?php 
	$count=1;
$sql="select matproperties.intPropertyId,intSubCatId,strPropertyName from  matpropertyassign inner join matproperties on matproperties.intPropertyId=matpropertyassign.intPropertyId where intSubCatId='$subCategory';";
$result=$db->RunQuery($sql);
$numRows = mysql_num_rows($result);
while($row=mysql_fetch_array($result))
{
$propertyId = $row["intPropertyId"];
?>
<tr class="bcgcolor-tblrowWhite">
	<td class="normalfntMid"><input name="checkbox" type="checkbox" checked="checked"></td>
	<td class="normalfntMid" id="<?php echo $row["intPropertyId"];?>"><?php echo $row["strPropertyName"];?></td>
	<td class="normalfntMid" ><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" >
 <?php

	$sql_1 = "SELECT DISTINCT matpropertyvalues.intSubPropertyNo,strSubPropertyName FROM matpropertyvalues 
INNER JOIN matsubpropertyassign  ON matsubpropertyassign.intSubPropertyid = matpropertyvalues.intSubPropertyNo OR matsubpropertyassign.intSubPropertyid  = matpropertyvalues.strSubPropertyCode  
WHERE  matsubpropertyassign.intPropertyId  = '$propertyId' OR matpropertyvalues.strSubPropertyCode = '$propertyId' 
ORDER BY strSubPropertyName;";	
	$result_1 = $db->RunQuery($sql_1);
	
	while($row_1 = mysql_fetch_array($result_1))
	{
			echo "<option value=\"". $row_1["intSubPropertyNo"] ."\">" . $row_1["strSubPropertyName"] ."</option>" ;
	}
	
?>
                      </select></td>
                      <td width="25"  height="15" ><img src="images/add.png" width="16" height="16" onclick="ShowNewValueForm(this);" /></td>
	<td class="normalfntMid" ><input type="checkbox"  /></td>
	<td class="normalfntMid" ><input type="text" class="txtbox" name="txtDisplayStr" id="txtDisplayStr" /></td>
	<td class="normalfntMid" ><select name="cboStyles" class="txtbox" style="width:50px" id="cboStyles" >
		<option value="Before">Before</option>
		<option value="After">After</option>
	</select></td>
	<td class="normalfntMid" ><select name="cboStyles" class="txtbox" style="width:50px" id="cboStyles" >
    <?php for($i=0; $i<$numRows; $i++)
		{
			if($i+1 == $count)
			{
	?>
	<option selected=selected value="<?php echo $count;?>"><?php echo $count;?></option>
    <?php }
	else
	{
	?>
    <option  value="<?php echo $i+1;?>"><?php echo $i+1;?></option>
    <?php
	
	}
	}?>
	</select></td>
	</tr> 
<?PHP
$count++;
}
?>
                      </table>
                    </div>
                  </div></td>
            </tr>
              </table></td>
  </tr>
            <tr>
              <td width="50%" height="0" align="right"><img src="images/save.png" alt="save" width="84" height="24" onclick="SaveFinish();" /></td>
              
              <td width="50%" align="left" ><img src="images/close.png" width="97" height="24" border="0" onclick="closePopupBox(10);"/></td>
            </tr>
</table>
</td>
            </tr>
</table>
