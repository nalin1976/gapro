<?php
session_start();
$backwardseperator = "../../../";
include "{$backwardseperator}authentication.inc";
include "../../../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Washing - Fabric Details</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<link href="../../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../js/jquery-1.4.2.min.js"></script>
<script src="fabricDetaisl.js"></script>
<script src="../../../javascript/script.js"></script>

</head>
<body>		

<form id="frmFabricDet" name="frmFabricDet" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<table  width="600" class="tableBorder" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
  		<td class="mainHeading" height="25">Fabric Details</td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" align="center">
      <tr>
        <td width="62%">
        <table width="100%" border="0" class="">
          <tr>
		  	<td>
				<table width="100%">
					<tr>
						<td colspan="5">&nbsp;</td>
					</tr>
					<tr>
						<td width="16%" class="normalfnt">Search </td>
						<td colspan="4">
						<select id="cboFabId" name="cboFabId" maxlength="30" tabindex="1" style="width:300px;" onchange="loadData(this)">
							<option value=""></option>
							<?php 
							$sql="select intId,strFabricId from was_outsidewash_fabdetails order by strFabricId;";
							$res=$db->RunQuery($sql);
							while($row=mysql_fetch_array($res)){
							?>
								<option value="<?php echo $row['intId'];?>"><?php echo $row['strFabricId'];?></option>
							<?php }?>
						</select>						</td>
					</tr>
					<tr>
						<td colspan="5">&nbsp;</td>
					</tr>
					<tr>
						<td class="normalfnt">Buyer</td>
						<td colspan="4"><select id="cboBuyer" name="cboBuyer"  tabindex="2" style="width:150px;" onchange="loadBuyerDivision(this);">
						<option value=""></option>
						<?php 
						$sql="select intBuyerID,strName from buyers order by strName;";
						$res=$db->RunQuery($sql);
						while($row=mysql_fetch_array($res)){?>
							<option value="<?php echo $row['intBuyerID'];?>"><?php echo $row['strName'];?></option>
						<?php }?>
						
						</select></td>
					</tr>
					<tr>
						<td class="normalfnt">Fabric ID</td>
						<td width="32%"><input type="text" id="txtFabId" name="txtFabId" maxlength="30" tabindex="3" style="width:150px;"/></td>
						<td width="2%">&nbsp;</td>
						<td width="21%" class="normalfnt">Fabric Description</td>
						<td width="29%"><input type="text" id="txtDescription" name="txtDescription" maxlength="50" tabindex="4" style="width:150px;"/></td>
					</tr>
					<tr>
						<td class="normalfnt">Style Name </td>
						<td><input type="text" id="txtStyle" name="txtStyle" maxlength="30" tabindex="5" style="width:150px;"/></td>
						<td>&nbsp;</td>
						<td class="normalfnt">Fabric Content </td>
						<td><input type="text" id="txtFabContent" name="txtFabContent" maxlength="50" tabindex="6" style="width:150px;"/></td>
					</tr>
					<tr>
						<td class="normalfnt">Division</td>
						<td><select id="cboDivision" name="cboDivision" maxlength="30" tabindex="7" style="width:150px;">
						<option value=""></option>
						</select></td>
						<td>&nbsp;</td>
						<td class="normalfnt">Mill</td>
						<td><select id="cboMill" name="cboMill" maxlength="30" tabindex="8" style="width:150px;">
						<option value=""></option>
								<?php 
							$sql="select distinct strSupplierID,strTitle from suppliers order by  strTitle;";
							$res=$db->RunQuery($sql);
							while($row=mysql_fetch_array($res)){?>
								<option value="<?php echo $row['strSupplierID'];?>"><?php echo $row['strTitle'];?></option>
							<?php }	?>
						
						</select></td>
					</tr>
					<tr>
						<td class="normalfnt">Color</td>
						<td><select id="cboColor" name="cboColor" maxlength="30" tabindex="9" style="width:150px;">
							<option value=""></option>
								<?php 
							$sql="select distinct strColor from colors order by strColor;";
							$res=$db->RunQuery($sql);
							while($row=mysql_fetch_array($res)){?>
								<option value="<?php echo $row['strColor'];?>"><?php echo $row['strColor'];?></option>
							<?php }	?>
						</select></td>
						<td>&nbsp;</td>
						<td class="normalfnt">Wash Type </td>
						<td><select id="cboWashType" name="cboWashType" tabindex="10" style="width:150px;">
							<option value=""></option>
							<?php 
						$sql="select intWasID,strWasType from was_washtype  order by strWasType;";
						$res=$db->RunQuery($sql);
						while($row=mysql_fetch_array($res)){?>
							<option value="<?php echo $row['intWasID'];?>"><?php echo $row['strWasType'];?></option>
						<?php }	?>
						</select></td>
					</tr>
					<tr>
						<td class="normalfnt">Garment</td>
						<td>
						<select id="cboGarment" name="cboGarment" tabindex="11" style="width:150px;">
						<option value=""></option>
						<?php 
						$sql="select intGamtID,strGarmentName from was_garmenttype  order by strGarmentName;";
						$res=$db->RunQuery($sql);
						while($row=mysql_fetch_array($res)){?>
							<option value="<?php echo $row['intGamtID'];?>"><?php echo $row['strGarmentName'];?></option>
						<?php }	?>
						</select></td>
						<td>&nbsp;</td>
						<td class="normalfnt">Factory</td>
						<td><select id="cboFactory" name="cboFactory" tabindex="12" style="width:150px;">
							<option value=""></option>
							<?php
								$sql="select intCompanyID,strName from was_outside_companies where intStatus=1 order by strName;";
								$res=$db->RunQuery($sql);
								while($row=mysql_fetch_array($res)){?>
								<option value="<?php echo $row['intCompanyID'];?>"><?php echo $row['strName'];?></option>
							<?php }	?>
						</select></td>
					</tr>
					<tr>
						<td class="normalfnt">Active</td>
						<td colspan="4">
							<input type="checkbox" id="chkStatus" name="chkStatus" tabindex="13" checked="checked"/>						</td>
					</tr>
					<tr>
						<td colspan="5">&nbsp;</td>
					</tr>
				</table>			</td>		  
		  </tr>
          <tr>
            <td height="34"><table width="100%" border="0" class="tableBorder">
              <tr>
				<td align="center" >
				<img src="../../../images/new.png" alt="New" name="New" width="96" height="24" onclick="ClearForm();" class="mouseover" tabindex="18"/>
				<img src="../../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="checkDet();" class="mouseover" tabindex="14" id="butSave"/>
				<img src="../../../images/delete.png" alt="Delete" name="Delete" width="100" height="24" onclick="ConfirmDelete()" class="mouseover" tabindex="15"/>
				<img src="../../../images/report.png" alt="Report" width="108" height="24" border="0" tabindex="16" class="mouseover" onclick="ViewFabricDesreport();"  />
				<a href="../../../main.php"><img src="../../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" tabindex="17" id="Close"/></a></td>	
              </tr>
            </table></td>
          </tr>
        </table>
        </td>
       </tr>
    </table>
	</td>
  </tr>
</table>
</form>
</body>
</html>
