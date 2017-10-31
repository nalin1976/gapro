<?php
session_start();
$backwardseperator = "../../../";
include "../../../Connector.php"; 
$buyer = $_POST["cboBuyer"];
$unitPrice = $_POST["cboUnitPrice"];
$conpc = $_POST["cboConpc"];
$subcategory = $_POST["cboSubcategory"];
//echo $unitPrice;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Formula Allocation</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script language="javascript" type="text/javascript">

function loadItemDetails()
{
	var subCatId = document.getElementById('cboSubcategory').value;
	var buyer = document.getElementById('cboBuyer').value;
	var uprice = document.getElementById('cboUnitPrice').value;
	var conpc = document.getElementById('cboConpc').value;
	if(buyer == '')
	{
		alert("Please select 'Buyer'");
		document.getElementById('cboBuyer').focus();
		return; 
	}
	else if(uprice == 'null')
	{
		alert("Please select 'Unit Price Formula'");
		document.getElementById('cboUnitPrice').focus();
		return; 
	}
	else if(conpc == 'null')
	{
		alert("Please select 'Conpc Formula'");
		document.getElementById('cboConpc').focus();
		return; 
	}
	if(subCatId != 'null')
	{
		document.getElementById("frmFormulaAllo").submit();
	}
}
</script>
<script src="formulaAllocation.js" language="javascript"></script>
<script src="../../../javascript/script.js" language="javascript" type="text/javascript"></script>
</head>

<body>
<form id="frmFormulaAllo" name="frmFormulaAllo" action="formulaAllocation.php" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../../Header.php'?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="1050" border="0" cellspacing="0" cellpadding="2" align="center">
      <tr>
        <td colspan="8" class="mainHeading" height="25">Item Allocation </td>
        </tr>
      <tr>
        <td width="52">&nbsp;</td>
        <td width="178">&nbsp;</td>
        <td width="132">&nbsp;</td>
        <td width="179">&nbsp;</td>
        <td width="114">&nbsp;</td>
        <td width="178">&nbsp;</td>
        <td width="91">&nbsp;</td>
        <td width="126">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">Buyer </td>
        <td><select name="cboBuyer" id="cboBuyer"  style="width:150px;">
        <?php
$sql_buyer="select intBuyerID,strName from buyers where intStatus=1 order by strName";
$result_buyer=$db->RunQuery($sql_buyer);
	echo  "<option value="."".">".""."</option>";
while($row_buyer=mysql_fetch_array($result_buyer))
{
	if($buyer == $row_buyer["intBuyerID"])
		echo  "<option selected=\"selected\" value=".$row_buyer["intBuyerID"].">".$row_buyer["strName"]."</option>";
	else	
		echo  "<option value=".$row_buyer["intBuyerID"].">".$row_buyer["strName"]."</option>";
}
?>
        </select>        </td>
        <td class="normalfnt">Unit Price Formula</td>
        <td><select name="cboUnitPrice" id="cboUnitPrice" style="width:150px;">
        <?php
$sql_up="select intId,strFormulaDesc from firstsale_formula where intType=0 order by strFormulaDesc";
$result_up=$db->RunQuery($sql_up);
	echo  "<option value="."null".">".""."</option>";
while($row_up=mysql_fetch_array($result_up))
{
	if($unitPrice == $row_up["intId"])
		echo  "<option selected=\"selected\" value=".$row_up["intId"].">".$row_up["strFormulaDesc"]."</option>";
	else
		echo  "<option value=".$row_up["intId"].">".$row_up["strFormulaDesc"]."</option>";
}
?>
        </select>        </td>
        <td class="normalfnt">Conpc Formula</td>
        <td><select name="cboConpc" id="cboConpc" style="width:150px;">
        <?php
$sql_up="select intId,strFormulaDesc from firstsale_formula where intType=1 order by strFormulaDesc";
$result_up=$db->RunQuery($sql_up);
	echo  "<option value="."null".">".""."</option>";
while($row_up=mysql_fetch_array($result_up))
{
	if($conpc == $row_up["intId"])
		echo  "<option selected=\"selected\" value=".$row_up["intId"].">".$row_up["strFormulaDesc"]."</option>";
	else
		echo  "<option value=".$row_up["intId"].">".$row_up["strFormulaDesc"]."</option>";
}
?>
        </select>        </td>
        <td class="normalfnt">Sub Category</td>
        <td><select name="cboSubcategory" id="cboSubcategory" style="width:120px;" onChange="loadItemDetails();">
        <?php 
		$sql_s = "select intSubCatNo,StrCatName from matsubcategory order by StrCatName ";
		$result_s = $db->RunQuery($sql_s);
		echo  "<option value="."null".">".""."</option>";
		while($row_s=mysql_fetch_array($result_s))
		{
			if($subcategory == $row_s["intSubCatNo"])
				echo  "<option selected=\"selected\" value=".$row_s["intSubCatNo"].">".$row_s["StrCatName"]."</option>";
			else	
				echo  "<option value=".$row_s["intSubCatNo"].">".$row_s["StrCatName"]."</option>";
		}
		?>
        </select>        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td colspan="8"><div style="overflow:scroll; width:100%; height:500px;">
        <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" align="center" id="tblMainGrid">
          <tr class="mainHeading4">
            <td width="59" height="22"><input type="checkbox" name="chkAll" id="chkAll" onClick="CheckAll(this,'tblMainGrid','0');"></td>
            <td width="158">Sub Category</td>
            <td width="354">Item Description</td>
            <td width="132">Main Category
              <input type="checkbox" name="chkMainCat" id="chkMainCat" onClick="chekMainCategory(this);"></td>
           
            <td width="138">Display Item Name 
              <input type="checkbox" name="chkItemName" id="chkItemName" onClick="CheckAllOther(this,'tblMainGrid','4');"></td>
            <td width="97">Display Item
              <input type="checkbox" name="chkDisplayName" id="chkDisplayName" onClick="CheckAllOther(this,'tblMainGrid','5');" ></td>
              <td width="100">Other Packing Item
              <input type="checkbox" name="chkDisplayName" id="chkDisplayName" onClick="CheckAllOther(this,'tblMainGrid','6');" ></td>
          </tr>
          
          <?php 
		  $sql_fs = "select fs.intSubCatId,fs.intMatDetailId,fs.intMainCatID,fs.intType,mil.strItemDescription,ms.StrCatName,fs.intDisplayItem,intOtherPacking
from firstsale_formulaallocation fs inner join matitemlist mil on
mil.intItemSerial= fs.intMatDetailId
inner join matsubcategory ms on ms.intSubCatNo=fs.intSubCatId
where fs.intSubCatId='$subcategory' and intBuyerId='$buyer' and intUnitPriceFormulaId='$unitPrice' and intConPcFormulaId='$conpc' ";

		$result_fs = $result=$db->RunQuery($sql_fs);
		while($row_fs = mysql_fetch_array($result_fs))
		{
		  ?>
         	 <tr bgcolor="#FFFFFF">
            <td class="normalfntMid"><input type="checkbox" name="checkbox" id="checkbox" checked onClick="saveFormulaAllocation(this);"></td>
            <td class="normalfnt" id="<?php echo $row_fs["intSubCatId"]; ?>"><?php echo $row_fs["StrCatName"]; ?></td>
            <td class="normalfnt" id="<?php echo $row_fs["intMatDetailId"]; ?>"><?php echo $row_fs["strItemDescription"]; ?></td>
            <td><select name="cboAllocate" id="cboAllocate" style="width:120px" >
<?php
$sql_1="select intCategoryId,intCategoryName from firstsalecostingcategory where intStatus=1 order by intOrderId";
$result_1=$db->RunQuery($sql_1);
	echo  "<option value="."null".">".""."</option>";
while($row_1=mysql_fetch_array($result_1))
{
	if($row_1['intCategoryId']==$row_fs['intMainCatID'])
		echo "<option selected=\"selected\" value=\"".$row_1["intCategoryId"]."\" >".$row_1["intCategoryName"]."</option>";
	else 
		echo  "<option value=".$row_1["intCategoryId"].">".$row_1["intCategoryName"]."</option>";
}
?>
</select>    </td>
            <td class="normalfntMid"><input type="checkbox" name="checkbox2" id="checkbox2" <?php if($row_fs["intType"] ==1){?> checked <?php }?>></td>
            <td class="normalfntMid"><input type="checkbox" name="checkbox3" id="checkbox3" <?php if($row_fs["intDisplayItem"] ==1){?> checked <?php }?>></td>
            <td class="normalfntMid"><input type="checkbox" name="checkbox3" id="checkbox3" <?php if($row_fs["intOtherPacking"] ==1){?> checked <?php }?>></td>
          </tr> 
          <?php 
		 } 
		  ?>
          <?php 
		  $sql = "select mil.intItemSerial,mil.intSubCatID,mil.strItemDescription,msub.StrCatName
from matitemlist mil inner join matsubcategory msub on
mil.intSubCatID = msub.intSubCatNo
where mil.intSubCatID='$subcategory' and mil.intItemSerial not in (select fs.intMatDetailId from firstsale_formulaallocation fs where fs.intSubCatId='$subcategory' and intBuyerId='$buyer'
and intUnitPriceFormulaId='$unitPrice' and intConPcFormulaId='$conpc') order by mil.strItemDescription";
		$result = $result=$db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
		  ?>
          <tr bgcolor="#FFFFFF">
            <td class="normalfntMid"><input type="checkbox" name="checkbox" id="checkbox" onClick="saveFormulaAllocation(this);"></td>
            <td class="normalfnt" id="<?php echo $row["intSubCatID"]; ?>"><?php echo $row["StrCatName"]; ?></td>
            <td class="normalfnt" id="<?php echo $row["intItemSerial"]; ?>"><?php echo $row["strItemDescription"]; ?></td>
            <td><select name="cboAllocate" id="cboAllocate" style="width:120px" >
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
</select>    </td>
            <td class="normalfntMid"><input type="checkbox" name="checkbox2" id="checkbox2"></td>
            <td class="normalfntMid"><input type="checkbox" name="checkbox4" id="checkbox4"></td>
             <td class="normalfntMid"><input type="checkbox" name="checkbox5" id="checkbox5"></td>
          </tr>
          <?php 
		 }
		  ?>
        </table></div></td>
        </tr>
        <tr><td colspan="8"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
          <tr>
            <td align="center"><img src="../../../images/new.png" onClick="clearPage();">
            <img src="../../../images/save.png" width="84" height="24" onClick="saveFormulaAllocation();" style="display:none"><img src="../../../images/report.png" width="108" height="24" onClick="viewFormulaReport();"><a href="../../../main.php"><img src="../../../images/close.png" width="97" height="24" border="0"></a></td>
          </tr>
        </table></td></tr>
    </table></td>
  </tr>
  <tr>
    <td align="center"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
