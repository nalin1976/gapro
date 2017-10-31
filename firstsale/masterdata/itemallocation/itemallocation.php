<?php
session_start();
$backwardseperator = "../../../";
include "../../../Connector.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | First Sale - Item Allocation</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../../javascript/script.js" type="text/javascript"></script>
<script type="text/javascript" src="jscolor.js"></script>
<script src="itemallocation.js" type="text/javascript"></script>
</head>
<body>

<form name="frmItemAllocation" id="frmItemAllocation">
<td><?php include '../../../Header.php'; ?></td>
<table width="1000" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>  </tr>
    <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="mainHeading">Item Allocation</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2"><div id="divcons2" style="overflow:scroll; height:470px; width:100%;">
          <table width="1020" cellpadding="0" cellspacing="1" id="tblMain" bgcolor="#C58B8B" class="bcgcolor">
		  <thead>
            <tr class="mainHeading4"  height="25" >
              <th width="21" >Del</th>
              <th width="100" >Main Materials </th>
              <th width="194">Sub Category </th>
              <th width="200"  nowrap="nowrap">Buyer</th>
              <th width="200" nowrap="nowrap">Unit Price Formulas </th>
			  <th width="200" nowrap="nowrap">ConPC Formulas </th>
              <th width="62" >Color</th>
              <th width="32" >Type</th>
            </tr>
			 </thead>
			
<?php
$sql="select FSA.intMainCatID,FSA.intSubCatId,MSC.StrCatName,FSA.strColor from fistsalesubcategoryallocation FSA inner join matsubcategory MSC on FSA.intSubCatId=MSC.intSubCatNo order by FSA.intMainCatID,MSC.StrCatName;";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>			
            <tr bgcolor="<?php echo $row["strColor"];?>">
              <td align="center"><img src="../../../images/del.png" alt="delete" width="15" height="15" /></td>
              <td >
<select name="cboAllocate" id="cboAllocate" style="width:100px" onchange="AllocateMaterials(this);">
<?php
$sql_1="select intCategoryId,intCategoryName from firstsalecostingcategory where intStatus=1 order by intOrderId";
$result_1=$db->RunQuery($sql_1);
	echo  "<option value="."null".">".""."</option>";
while($row_1=mysql_fetch_array($result_1))
{
	if($row_1['intCategoryId']==$row['intMainCatID'])
		echo "<option selected=\"selected\" value=\"".$row_1["intCategoryId"]."\" >".$row_1["intCategoryName"]."</option>";
	else 
		echo  "<option value=".$row_1["intCategoryId"].">".$row_1["intCategoryName"]."</option>";
}
?>
</select>              </td>
              <td class="normalfnt" id="<?php echo $row["intSubCatId"]?>">&nbsp;<?php echo $row["StrCatName"]?>&nbsp;</td>
              <td nowrap="nowrap">
<select name="cboBuyer" id="cboBuyer" style="width:200px" onchange="LoadFormulas(this);">
<?php
$sql_buyer="select intBuyerID,strName from buyers where intStatus=1 order by strName";
$result_buyer=$db->RunQuery($sql_buyer);
	echo  "<option value="."".">".""."</option>";
while($row_buyer=mysql_fetch_array($result_buyer))
{
		echo  "<option value=".$row_buyer["intBuyerID"].">".$row_buyer["strName"]."</option>";
}
?>
</select></td>
              <td nowrap="nowrap">
<select name="cboUPFormila" id="cboUPFormila" style="width:200px" onchange="AllocateFormula(this);">
<?php
$sql_up="select intId,strFormulaDesc from firstsale_formula where intType=0 order by strFormulaDesc";
$result_up=$db->RunQuery($sql_up);
	echo  "<option value="."null".">".""."</option>";
while($row_up=mysql_fetch_array($result_up))
{
		echo  "<option value=".$row_up["intId"].">".$row_up["strFormulaDesc"]."</option>";
}
?>
</select></td>
              <td nowrap="nowrap">
<select name="cboConFormula" id="cboConFormula" style="width:200px" onchange="AllocateFormula(this);">
<?php
$sql_cp="select intId,strFormulaDesc from firstsale_formula where intType=1 order by strFormulaDesc";
$result_cp=$db->RunQuery($sql_cp);
	echo  "<option value="."null".">".""."</option>";
while($row_cp=mysql_fetch_array($result_cp))
{
		echo  "<option value=".$row_cp["intId"].">".$row_cp["strFormulaDesc"]."</option>";
}
?>
</select></td>
              <td class="normalfnt" id="<?php echo $row["strColor"]?>"><input class="color{hash:true} txtbox" value="<?php echo $row["strColor"]?>" style="width:60px" onchange="ChangeColor(this);"></td>
              <td class="normalfnt" id="<?php echo $row["strColor"]?>"><div align="center"><input type="checkbox" id="chkType" name="chkType" onchange="SaveType(this);" /></div></td>
            </tr>
			
<?php
}
?>

<?php
$sql="select MSC.intSubCatNo,MSC.StrCatName from matsubcategory MSC where MSC.intSubCatNo not in (select FSA.intSubCatId from fistsalesubcategoryallocation FSA) order by MSC.StrCatName";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>
<tr class="bcgcolor-tblrowWhite">
              <td align="center"><img src="../../../images/del.png" alt="delete" width="15" height="15" /></td>
              <td >
<select name="cboAllocate" id="cboAllocate" style="width:100px" onchange="AllocateMaterials(this);">
<?php
$sql_1="select intCategoryId,intCategoryName from firstsalecostingcategory where intStatus=1 order by intOrderId";
$result_1=$db->RunQuery($sql_1);
	echo  "<option value="."null".">".""."</option>";
while($row_1=mysql_fetch_array($result_1))
{
	if($row_1['intCategoryId']==$row['intMainCatID'])
		echo "<option selected=\"selected\" value=\"".$row_1["intCategoryId"]."\" >".$row_1["intCategoryName"]."</option>";
	else 
		echo  "<option value=".$row_1["intCategoryId"].">".$row_1["intCategoryName"]."</option>";
}
?>
</select>              </td>
              <td class="normalfnt" id="<?php echo $row["intSubCatNo"]?>">&nbsp;<?php echo $row["StrCatName"]?>&nbsp;</td>
              <td nowrap="nowrap">
<select name="cboBuyer" id="cboBuyer" style="width:200px" onchange="LoadFormulas(this);">
<?php
$sql_buyer="select intBuyerID,strName from buyers where intStatus=1 order by strName";
$result_buyer=$db->RunQuery($sql_buyer);
	echo  "<option value="."".">".""."</option>";
while($row_buyer=mysql_fetch_array($result_buyer))
{
		echo  "<option value=".$row_buyer["intBuyerID"].">".$row_buyer["strName"]."</option>";
}
?>
</select></td>
              <td nowrap="nowrap">
<select name="cboUPFormila" id="cboUPFormila" style="width:200px" onchange="AllocateFormula(this);">
<?php
$sql_up="select intId,strFormulaDesc from firstsale_formula where intType=0 order by strFormulaDesc";
$result_up=$db->RunQuery($sql_up);
	echo  "<option value="."null".">".""."</option>";
while($row_up=mysql_fetch_array($result_up))
{
		echo  "<option value=".$row_up["intId"].">".$row_up["strFormulaDesc"]."</option>";
}
?>
</select></td>
              <td nowrap="nowrap">
<select name="cboConFormula" id="cboConFormula" style="width:200px">
<?php
$sql_cp="select intId,strFormulaDesc from firstsale_formula where intType=1 order by strFormulaDesc";
$result_cp=$db->RunQuery($sql_cp);
	echo  "<option value="."null".">".""."</option>";
while($row_cp=mysql_fetch_array($result_cp))
{
		echo  "<option value=".$row_cp["intId"].">".$row_cp["strFormulaDesc"]."</option>";
}
?>
</select></td>
              <td class="normalfnt" id="<?php echo $row["strColor"]?>"><input class="color{hash:true} txtbox" value="<?php echo $row["strColor"]?>" style="width:60px"></td>
              <td class="normalfnt" id="<?php echo $row["strColor"]?>"><div align="center"><input type="checkbox" id="chkType" name="chkType" onchange="SaveType(this);"/></div></td>
</tr>
<?php } ?>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellspacing="2" cellpadding="0" >
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td ><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="tableFooter"> 
          <tr>
            <td><div align="center" >
				<a href="itemallocation.php">
				<img title="New" src="../../../images/new.png" style="display:inline" alt="new" name="butNew" class="mouseover"  id="butNew" border="0"/></a>
                <img src="../../../images/send2app.png" style="display:none" title="Save" alt="save" name="butSendToApproval" class="mouseover" id="butSave" onclick="SendToApproval();" /><img src="../../../images/report.png" style="display:inline" title="Report" name="butReport" width="108" height="24" class="mouseover" id="butReport"  onclick="OpenReportPopUp();"/><a href="../../../main.php"><img style="display:inline" title="Close" src="../../../images/close.png" width="97" height="24" border="0" /></a></div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>