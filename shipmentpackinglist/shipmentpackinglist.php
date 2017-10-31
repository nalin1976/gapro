<?php
session_start();
$backwardseperator = "../";
include "$backwardseperator".''."Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

<title>Shipment Packing List</title>
<script src="../javascript/script.js" type="text/javascript"></script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include "".$backwardseperator."Header.php"; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    <div class="main_bottom_center">
	<div class="main_top"><div class="main_text">Shipment Packing List</div></div>
	<div class="main_body">
    <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td><form id="pl_header"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt tableBorder">
          <tr>
            <td height="5" colspan="8"></td>
          </tr>
          <tr>
            <td height="25">PL No <span class="compulsoryRed"> *</span></td>
            <td id='plno_cell'><input name="txtPLNo" type="text" class="txtbox" id="txtPLNo" style="width:146px"  /></td>
            <td>Manufacturer</td>
            <td><select name="cboFactory"  class="txtbox" style="width:150px" id="cboFactory"   >
              <option value=""></option>
              <?php 
			$strtofactory="select intCompanyID,strComCode,strName from companies where intStatus=1 order by strName";
		
			$factresults=$db->RunQuery($strtofactory);
			
			while($factrow=mysql_fetch_array($factresults))
			{
		?>
              <option value="<?php echo $factrow['intCompanyID'];?>"><?php echo $factrow['strName'];?></option>
              <?php } ?>
            </select></td>
            <td>Order No</td>
            <td><select name="cmbStyle" class="txtbox" id="cmbStyle" style="width:150px" >
              <option value=""></option>
              <?php 
			$buyerstr="select 	intStyleId, strStyle from orders where intStatus=11 order by strStyle  ";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{1
		?>
              <option value="<?php echo $buyerrow['intStyleId'];?>"><?php echo $buyerrow['strStyle'];?></option>
              <?php } ?>
            </select></td>
            <td>CTNS</td>
            <td><input name="txtCTNS" type="text" class="txtbox" id="txtCTNS" style="width:146px"  maxlength="50"/></td>
          </tr>
          <tr>
            <td height="25">Manu. Ord. #</td>
            <td><input name="txtManufactOrderNo" type="text" class="txtbox" id="txtManufactOrderNo" style="width:146px"  maxlength="50" /></td>
            <td>Manu. Style</td>
            <td><input name="txtManufactStyle" type="text" class="txtbox" id="txtManufactStyle" style="width:146px" maxlength="50"/></td>
            <td>Invoice #</td>
            <td><input name="txtInvoiceNo" type="text" class="txtbox" id="txtInvoiceNo" style="width:146px"  maxlength="50"/></td>
            <td>Product Code</td>
            <td><input name="txtProductCode" type="text" class="txtbox" id="txtProductCode" style="width:146px" maxlength="50" /></td>
          </tr>
          <tr>
            <td height="25">Fabric</td>
            <td><input name="txtFabric" type="text" class="txtbox" id="txtFabric" style="width:146px" maxlength="50" /></td>
            <td>Label</td>
            <td><input name="txtLable" type="text" class="txtbox" id="txtLable" style="width:146px"  maxlength="50"/></td>
            <td>TTL Qty</td>
            <td><input name="txtTotalQty" type="text" class="txtbox" id="txtTotalQty" style="width:146px" maxlength="50" /></td>
            <td>Vessel </td>
            <td><input name="txtVessel" type="text" class="txtbox" id="txtVessel" style="width:146px"  maxlength="50"/></td>
          </tr>
          <tr>
            <td height="25">Sailing Date</td>
            <td><input name="txtSailingDate" type="text" class="txtbox" id="txtSailingDate" style="width:146px" maxlength="50" /></td>
            <td>Origin Country</td>
            <td><input name="txtOrginCountry" type="text" class="txtbox" id="txtOrginCountry" style="width:146px" maxlength="50" /></td>
            <td>Container #</td>
            <td><input name="txtContainer" type="text" class="txtbox" id="txtContainer" style="width:146px" maxlength="50" /></td>
            <td>Seal #</td>
            <td><input name="txtSeal" type="text" class="txtbox" id="txtSeal" style="width:146px" maxlength="50" /></td>
          </tr>
          <tr>
            <td height="25">BL</td>
            <td><input name="txtBL" type="text" class="txtbox" id="txtBL" style="width:146px" maxlength="50" /></td>
            <td>Gross</td>
            <td><input name="txtGross" type="text" class="txtbox" id="txtGross" style="width:146px" maxlength="50" /></td>
            <td>Net</td>
            <td><input name="txtNet" type="text" class="txtbox" id="txtNet" style="width:146px" maxlength="50" /></td>
            <td>Total Shipped</td>
            <td><input name="txtTotalShipQty" type="text" class="txtbox" id="txtTotalShipQty" style="width:146px" maxlength="50" /></td>
          </tr>
          <tr>
            <td height="25">Carton </td>
            <td><input name="txtCartoon" type="text" class="txtbox" id="txtCartoon" style="width:146px" maxlength="50" /></td>
            <td>L/C No</td>
            <td><input name="txtLCNO" type="text" class="txtbox" id="txtLCNO" style="width:146px" maxlength="50" /></td>
            <td>Bank</td>
            <td><input name="txtBank" type="text" class="txtbox" id="txtBank" style="width:146px" maxlength="50" /></td>
            <td>Sorting Type</td>
            <td><input name="txtSortingType" type="text" class="txtbox" id="txtSortingType" style="width:146px" maxlength="50" /></td>
          </tr>
          <tr>
            <td height="25">PrePacK Code</td>
            <td><input name="txtPrePackCode" type="text" class="txtbox" id="txtPrePackCode" style="width:146px" maxlength="50" /></td>
            <td>Wash Code</td>
            <td><input name="txtWashCode" type="text" class="txtbox" id="txtWashCode" style="width:146px" maxlength="50" /></td>
            <td>Color</td>
            <td><input name="txtColor" type="text" class="txtbox" id="txtColor" style="width:146px" maxlength="50" /></td>
            <td>Article</td>
            <td><input name="txtArticle" type="text" class="txtbox" id="txtArticle" style="width:146px" maxlength="50" /></td>
          </tr>
          <tr>
            <td width="10%" height="5"></td>
            <td width="15%"></td>
            <td width="10%"></td>
            <td width="15%"></td>
            <td width="10%"></td>
            <td width="15%"></td>
            <td width="10%"></td>
            <td width="15%"></td>
          </tr>
        </table></form></td>
      </tr>
      <tr>
        <td height="5"></td>
      </tr>
       <tr>
        <td class="mainHeading2" style="text-align:left"> Packing List Details</td>
      </tr>
      <tr>
        <td class="tableBorder"> <div id="divcons"  style="overflow:scroll; height:250px; width:980px;" >
            <table style="width:100%;"  cellpadding="0" cellspacing="1" bgcolor="#996f03"  id="tblPL">
              <tr class="mainHeading4">
                <td height="17">Style Ratio</td>
                </tr>
            </table>
        </div></td>
      </tr>
      <tr>
        <td height="5"></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" class="tableBorder" cellspacing="0" cellpadding="0">
          <tr >
            <td width="25%" height="30"><div align="right">
              <input type="image" tabindex="17" src="../images/new.png" alt="n" id='btnNew'/>
            </div></td>
            <td width="12%" ><div align="center">
              <input name="image" type="image" class="mouseover" tabindex="18" src="../images/view.png" alt="s" id="btnView" />
            </div></td>
            <td width="10%"><div align="center">
              <input type="image" tabindex="19" src="../images/save.png" alt="p"  class="mouseover" id='btnSave'/>
            </div></td>
            <td width="13%"><div align="center">
              <input type="image" tabindex="20" src="../images/report.png " alt="c"  class="mouseover"  id="btnPrint"/>
            </div></td>
            <td width="13%"><div align="center">
              <input type="image" tabindex="21"src="../images/delete.png" onclick="delete_cut();"/>
            </div></td>
            <td width="27%"><a href="<?php echo $backwardseperator?>main.php"><img src="../images/close.png" alt="c"  class="mouseover noborderforlink"  /></a></td>
          </tr>
        </table></td>
      </tr>
      
	</table>
    </div>
    </div>
 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
<script src="shipmentpackinglist.js" type="text/javascript"></script>
</html>