<?php
session_start();
	include "../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../../";
	include "../../authentication.inc";
	$mainCategory = $_POST["cboMainCategory"];
	$subCategory = $_POST["cboSubCategory"];
	$itemDisc = $_POST["txtItemLike"];
	$costCenter = $_POST["cboCostCenter"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Item wise Reorder Level</title>
<link href="../../css/erpstyle.css" rel="stylesheet"  type="text/css"/>
<script src="itemwiseReorder.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function loadDetails()
{
	if(document.getElementById('cboCostCenter').value == '')
	{
		alert("Please select 'Cost Center'");
		document.getElementById('cboCostCenter').focus();
		return;
	}
	else if(document.getElementById('cboSubCategory').value == '')
	{
		alert("Please select 'Sub Category'");
		document.getElementById('cboSubCategory').focus();
		return;
	}
	else
	{
		document.getElementById("frmReorderLevel").submit();
	}
}
function enterSubmitLoadDetais(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				loadDetails();
}

</script>
</head>

<body>
<form name="frmReorderLevel"  id="frmReorderLevel" method="post" action="itemwiseReorder.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  
  <tr>
    <td><table width="680" border="0" align="center" class="tableBorder">
      <tr>
        <td colspan="2" class="mainHeading" height="25">Item Wise Reorder Level</td>
        </tr>
      
      <tr>
        <td width="213" class="normalfnt">Cost Center</td>
        <td width="467"><select name="cboCostCenter" id="cboCostCenter" style="width:250px;">
        <?php
		$SQL ="select intCostCenterId,strDescription from costcenters order by strDescription;";	
		
		$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		if ($costCenter == $row["intCostCenterId"] )
			echo "<option selected=\"selected\" value=\"". $row["intCostCenterId"] ."\">" . $row["strDescription"] ."</option>" ;
		else
			echo "<option value=\"". $row["intCostCenterId"] ."\">" . $row["strDescription"] ."</option>" ;
	}		  
		 ?>
        </select>        </td>
      </tr>
      <tr>
        <td class="normalfnt">Main Category</td>
        <td><select name="cboMainCategory" id="cboMainCategory" style="width:250px;" onChange="loadSubCategoryList();">
          <?php
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	$SQL = "select intID,strDescription from genmatmaincategory where status=1 order by strDescription";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
			if ($mainCategory == $row["intID"] )
				echo "<option selected=\"selected\" value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
			else
				echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
        </select>        </td>
      </tr>
      <tr>
        <td class="normalfnt">Sub Category</td>
        <td><select name="cboSubCategory" id="cboSubCategory" style="width:250px;" onChange="loadDetails();">
        <?php 
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		$sql = "SELECT intSubCatNo,StrCatName FROM genmatsubcategory WHERE intStatus = 1 order by StrCatName ";
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			if ($subCategory == $row["intSubCatNo"] )
				echo "<option selected=\"selected\" value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
			else
				echo "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
		}
		?>
        </select>        </td>
      </tr>
      <tr>
        <td class="normalfnt">Item Like</td>
        <td><input type="text" name="txtItemLike" id="txtItemLike" style="width:249px;" value="<?php echo $itemDisc; ?>" onKeyPress="enterSubmitLoadDetais(event);"></td>
      </tr>
      
      <tr>
        <td colspan="2"><div id="divData" style="width:100%; height:400px; overflow: scroll; ">
          <table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCFF" id="tblItem">
            <tr class="mainHeading4">
              <th width="78%" height="20">Item Description </th>
              <th width="22%">Reorder Level</th>
            </tr>
            <?php 
			$sql = "select mil.intItemSerial, mil.strItemDescription,rl.dblReorderLevel
from genmatitemlist mil inner join genitemwisereorderlevel rl on
mil.intItemSerial = rl.intMatDetailID
where  mil.intSubCatID='$subCategory' and rl.intCostCenterId='$costCenter'";
if($itemDisc != '')
	$sql .= " and mil.strItemDescription like '%$itemDisc%' ";

$sql .= " union 
select mil.intItemSerial, mil.strItemDescription,'0'
from genmatitemlist mil
where mil.intSubCatID='$subCategory' ";
if($itemDisc != '')
	$sql .= " and mil.strItemDescription like '%$itemDisc%' ";
	
$sql .= " and mil.intItemSerial not in 
(select rl.intMatDetailID from genitemwisereorderlevel rl inner join genmatitemlist mil on
mil.intItemSerial = rl.intMatDetailID 
where  mil.intSubCatID='$subCategory' and rl.intCostCenterId='$costCenter' ";
if($itemDisc != '')
	$sql .= " and mil.strItemDescription like '%$itemDisc%' ";
	$sql .=" )
order by strItemDescription ";
$result = $db->RunQuery($sql);
//echo $sql;
		while($row = mysql_fetch_array($result))
		{
			?>  
            <tr bgcolor="#FFFFFF">
              <td id="<?php echo $row["intItemSerial"]; ?>" class="normalfnt"><?php echo $row["strItemDescription"]; ?></td>
              <td><input type="text" name="txtRlevel" id="txtRlevel" value="<?php echo $row["dblReorderLevel"]; ?>" style="text-align:right" onBlur="saveItemDetails(this);" onKeyPress="return CheckforValidDecimal(this.value, 4,event);"></td> 
            </tr>
            <?php 
		}
			?>
          </table>
        </div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><table width="680" border="0" cellspacing="0" cellpadding="2" align="center" class="tableBorder">
          <tr>
            <td align="center"><img src="../../images/new.png" width="96" height="24" onClick="clearPage();"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0"></a></td>
          </tr>
        </table></td>
        </tr>
    </table>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
