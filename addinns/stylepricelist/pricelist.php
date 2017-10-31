<?php
session_start();
include "../../Connector.php";

if(!isset($_POST["txtItemDes"]))	
	{
		$status = 10;
	}
	else
	{
		$status = 1;
	}
	
	$MainCategory	= $_POST["cboMainCategory"];
	$SubCategory	= $_POST["cboSubCategory"];
	$ItemDes		= $_POST["txtItemDes"];

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Price List</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">

    table.fixHeader {

        border: solid #FFFFFF;

        border-width: 1px 1px 1px 1px;

        width: 900px;

    }

    tbody.ctbody {

        height: 580px;
		
        overflow-y: auto;

        overflow-x: hidden;

    }
</style>

<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script src="../../js/jquery-1.4.2.min.js"></script>
<script>
BundleEntryEventSetter_layer();
function setSubCategory(obj)
{
	var url     = 'pricelistdb.php?request=setSubCategory&mainCatId='+obj.value;
	var htmlobj = $.ajax({url:url,async:false});
	document.getElementById('cboSubCategory').innerHTML = htmlobj.responseText;
	
}
function ReloadPage()
{
	showPleaseWait();
	var mainCatId = document.getElementById('cboMainCategory').value;
	var subCatId  = document.getElementById('cboSubCategory').value;
	var itemDes   = document.getElementById('txtItemDes').value;
	if(itemDes=="" && subCatId=="" && mainCatId=="")
	{
		if(confirm('Without selecting any search criteria it will take long time to load the data \n Are you sure you want to continue the process ?'))
		{
			document.frmStylePriceList.submit();
			hidePleaseWait();
		}
		else
		{
			hidePleaseWait();
			return;
		}
	}
	else
	{
		document.frmStylePriceList.submit();
		hidePleaseWait();
	}
	
}
function updateUnitPrice(obj,unitPrice)
{
	var rw = obj.parentNode.parentNode;
	if(unitPrice=="")
	{
		rw.cells[3].childNodes[0].value = 0;
		unitPrice = 0;
	}
	var itemCode = obj.parentNode.id;
	var url      = 'pricelistdb.php?request=updateUnitPrice&unitPrice='+unitPrice+'&itemCode='+itemCode;
	var htmlobj  = $.ajax({url:url,async:false});
}
function isEnterKey(evt)
{
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode == 13)
	 {
		 ReloadPage();
	 }
}
function BundleEntryEventSetter_layer()
{
	$('.txtbox.keymove').live('keydown', function(e) {
		var tbl 			= document.getElementById('tblMain');
		var rw				= tbl.parentNode.parentNode.parentNode;
		var keyCode 		= e.keyCode || e.which;
		var row_cell		= this.parentNode.cellIndex;
		var row_index		= this.parentNode.parentNode.rowIndex;
		$no=1;
		switch(keyCode)
		{			
			
			case 38: //up
				row_index  	= row_index - $no; 
				break; 	
				
			case 40: //down
				row_index 	= row_index + $no; 
				break; 	
		}
		var val_row = parseFloat(tbl.rows.length)-1;
			/*if(row_cell<1||row_cell>=start_auto_cell+10||row_index<0||row_index>=val_row)
				return;	*/
		if(row_index<1 || row_index>=val_row)
			return;
		if(keyCode==37 || keyCode==38 || keyCode==39 || keyCode==40)
		{
			tbl.rows[row_index].cells[row_cell].childNodes[0].focus();		
			tbl.rows[row_index].cells[row_cell].childNodes[0].select();
		}
	});

}
</script>
</head>
<body>
<form id="frmStylePriceList" name="frmStylePriceList" method="post" action="pricelist.php">
<table width="900" align="center" cellpadding="1" cellspacing="1" border="0" class="tableBorder">
<tr>
	<td>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
     <td class="head2">Style Price List</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><table width="100%" align="center" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="11%" class="normalfnt">Main Category</td>
          <td width="20%" class="normalfnt">
            <select name="cboMainCategory" id="cboMainCategory" class="txtbox" style="width:150px" onchange="setSubCategory(this);">
              <option value="" selected="selected" >Select One</option>
              <?php
		$sql = "select intID,strDescription from matmaincategory order by intID";
		$result = $db->RunQuery($sql);		
		while($row = mysql_fetch_array($result))
			{
				if($MainCategory==$row['intID'])
				{
					echo "<option selected=\"selected\" value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
				}
				else
				{
					echo "<option value=\"". $row["intID"] ."\">" . $row["strDescription"] ."</option>" ;
				}
			}
		?>
              </select></td>
          <td width="10%" class="normalfnt">Sub Category</td>
          <td width="19%" class="normalfnt"><select name="cboSubCategory" id="cboSubCategory" class="txtbox" style="width:150px">
            <option value="" selected="selected" >Select One</option>
            <?php
		$sql = "select intSubCatNo,StrCatName from matsubcategory where intStatus=1 
				  and intCatNo='$MainCategory'";
		$result = $db->RunQuery($sql);		
		while($row = mysql_fetch_array($result))
			{
				if($SubCategory==$row['intSubCatNo'])
				{
					echo "<option selected=\"selected\" value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
				}
				else
				{
					echo "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>" ;
				}
			}
		?>
            </select></td>
          <td width="12%" class="normalfnt">Item Description</td>
          <td width="18%" class="normalfnt">
            <input type="text" name="txtItemDes" id="txtItemDes" class="txtbox" width="150px" value="<?php echo ($ItemDes==""?"":$ItemDes) ?>" onkeypress="isEnterKey(event);" /></td>
          <td width="10%" class="normalfnt"><span class="normalfnt" style="text-align:right"><img src="../../images/search.png" alt="search" onclick="ReloadPage();"/></span></td>
          </tr>
        </table>
  </td>
    </tr>
    <tr>
      <td align="center">
        <table width="100%" cellspacing="1" cellpadding="2" border="0" id="tblMain" bgcolor="#000000">
          <thead>
            <tr bgcolor="#CCCCCC" class="normalfntMid">
              <th width="14%" height="25" >ITEM CODE</th>
              <th width="56%" >ITEM DESCRIPTION </th>
              <th width="14%" >UNIT</th>
              <th width="13%" >PRICE</th>
              <th width="2%" >&nbsp;</th>
              </tr>
            </thead>
          <tbody class="ctbody">
            <?php
	  $sql = "select intItemSerial,strItemDescription,strUnit,dblUnitPrice
			  from matitemlist where intStatus='$status' ";
	
	  if($MainCategory!="")
	  	$sql.="AND intMainCatID='$MainCategory' ";
		
	  if($SubCategory!="")
	  	$sql.="AND intSubCatID='$SubCategory' ";
		
	  if($ItemDes!="")
	  	$sql.="AND strItemDescription like '%$ItemDes%' ";
	
	  $sql.="order by strItemDescription ";
					 
	  $result=$db->RunQuery($sql);
	  
      while($row=mysql_fetch_array($result))
	  {
	  ?>
            <tr class="bcgcolor-tblrowWhite">
              <td width="14%" height="20" class="normalfnt"><?php echo $row['intItemSerial'];?></td>
              <td width="56%" class="normalfnt">&nbsp;<?php echo $row['strItemDescription'];?>&nbsp;</td>
              <td width="14%" class="normalfnt">&nbsp;<?php echo $row['strUnit'];?>&nbsp;</td>
              <td class="normalfntMid" id="<?php echo $row['intItemSerial']; ?>"><input name="txtUnitPrice" id="txtUnitPrice" style="text-align:right;width:100px" class="txtbox keymove" type="text" value="<?php echo $row['dblUnitPrice']; ?>" onblur="updateUnitPrice(this,this.value);" onkeypress="return CheckforValidDecimal(this.value,3,event);" /></td>
              <td class="normalfnt">&nbsp;</td>
              </tr>
            <?php
			
	  }
	  ?>
            <tr class="bcgcolor-tblrowWhite" >
              <td colspan="5" >&nbsp;</td>
              </tr>
            </tbody>
          </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    </table>
    </td>
</tr>
</table>
</form>
</body>
</html>