<?php
	session_start();
	include("../Connector.php");
	$backwardseperator = "../";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../javascript/script.js"></script>
<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.9.custom.min.js"></script>
<script type="text/javascript" src="../javascript/tablednd.js"></script>

<title>Packing List Wizard</title>
<script src="packinglistWizard.js" type="text/javascript"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include $backwardseperator.'Header.php';?></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:15px;">
      <tr>
        <th height="20" bgcolor="#316895" class="TitleN2white">Packing List Wizard</th>
      </tr>
      <tr>
        <td>
        
        <table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt bcgl1">
          <tr>
            <td >
            <table width="100%" cellpadding="2" cellspacing="0">
              <tr>
                <td width="36%"  height="25" class="normalfnt" style="text-align:center">&nbsp;</td>
                <td width="13%"><span class="normalfnt" style="text-align:center">Order No</span></td>
                <td width="51%"><select name="cboOrder" class="txtbox ordercls" style="width:250px" id="cboOrder" onchange="">
                  <option value="Select One">Select One</option>
                  <?php $str_order		="select intOrderId,strOrder_No from orderspec where intStatus=1 order by strOrder_No";
		   		 $result_order	=$db->RunQuery($str_order);
				 while($datarow_order=mysql_fetch_array($result_order)){
			?>
                  <option value="<?php echo $datarow_order['intOrderId']?>"><?php echo $datarow_order['strOrder_No']?></option>
                  <?php 
			}			
			?>
                  </select></td>
              </tr>
              
              <tr>
                <td  height="25" colspan="2" class="normalfnt" style="text-align:center; padding:10px">
                  <fieldset class="normalfnt" style="border:#CCCCFF 1px solid; width:100%">
                    <legend>Pack
                      </legend>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="2%">&nbsp;</td>
                        <td width="12%"><span class="normalfnt" style="text-align:center">Pre Pack</span></td>
                        <td width="5%"><input type="checkbox" id="chk_pre" /></td>
                        <td width="4%">&nbsp;</td>
                        <td width="15%"><span class="normalfnt" style="text-align:center">Bulk Pack</span></td>
                        <td width="6%"><input type="checkbox" id="chk_bulk" /></td>
                        <td width="4%">&nbsp;</td>
                        <td width="9%"><span class="normalfnt" style="text-align:center">Ratio </span></td>
                        <td width="7%"><input type="checkbox" id="chk_ratio" /></td>
                        <td width="26%">Include Order Qty</td>
                        <td width="10%"><input type="checkbox" id="chk_addOrderQty" /></td>
                        </tr>
                      <tr>
                        <td colspan="11" style="text-align:center"><img src="../images/Actions-insert-table-icon.png" onclick="validateOrderPackType();" id="btnConfirm" class="mouseover" /></td>
                        </tr>
                      </table>
                    </fieldset>
                  </td>
                <td  height="25" class="normalfnt" style="text-align:center; padding:10px">
                <fieldset class="normalfnt" style="border:#CCCCFF 1px solid; width:96%">
                    <legend>Additional</legend>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10%">&nbsp;</td>
                        <td>(This Button will show the Percentage Pop Up)</td>
                        <td width="25%">Add Percentage</td>
                        <td width="22%"><input type="text" id="txtPrecentage" name="txtPrecentage" class="txtbox" style="width:50px" onkeypress='return CheckforValidDecimal(this.value, 4,event);'  value=""/>
                        %</td>
                        </tr>
                      <tr>
                        <td height="29" style="text-align:center">&nbsp;</td>
                        <td height="29" style="text-align:center"><img src="../images/Document-Add-icon.png" onclick="createPercentagePopUp();" class="mouseover" /></td>
                        <td height="29" colspan="2" style="text-align:center"><img src="../images/add_value.png" onclick="addPercentage();" /></td>
                        </tr>
                      </table>
                    </fieldset>
                </td>
                  
              </tr>
              </table></td>
          </tr>
		  
          <tr>
            <td style="padding:10px">
            <fieldset class="normalfnt" style="border:#CCCCFF 1px solid"><legend>Packing Details</legend>
            <div id="divcons"  style="overflow:scroll; height:200px; width:900px;">
            <table width="100%" border="0" cellspacing="1" cellpadding="0"  id="tblPackingListDet" bgcolor="#CCCCFF">
              <thead>
                <tr bgcolor="#498CC2" class="normaltxtmidb2">                  
                  <th width="138" height="25" style="text-align:center">Color</th>
                  <th width="300" style="text-align:center">Size</th>
                  <th width="108" style="text-align:center">Pack Type</th>
                  </tr>
                </thead>
              </table>
              </div>
              </fieldset>
              </td>
          </tr>
          <tr>
            <td height="3"></td>
          </tr>
          <tr>
            <td style="padding:10px">
            <fieldset class="normalfnt" style="border:#CCCCFF 1px solid"><legend>Carton Details</legend>
            <div id="divcons"  style="overflow:scroll; height:120px; width:900px;">
            <table width="100%" border="0" cellspacing="1" cellpadding="0"  bgcolor="#CCCCFF" id="tblCartonDet">
              <thead>
                <tr bgcolor="#498CC2" class="normaltxtmidb2">                  
                  <th width="165" height="25" style="text-align:center" >Carton Type</th>
                  <th width="100" style="text-align:center">Pack Type</th>
                  <th width="100" style="text-align:center">Color</th>
                  <th width="281" style="text-align:center">Size</th>
                  </tr>
                </thead>
              </table>
              </div>
              </fieldset>
              </td>
          </tr>
          <tr>
            <td align="center"><img src="../images/Generate-tables-icon.png" onclick="loadPLGrid();" align="middle" class="mouseover" /></td>
            </tr>
           
          <tr id="plVisibility" style="display:none">
            <td style="padding:10px">
            <fieldset class="normalfnt" style="border:#CCCCFF 1px solid"><legend>Packing Details</legend>
            <div id="divcons"  style="overflow:scroll; height:200px; width:900px;">
              <table width="100%" border="0" cellspacing="1" cellpadding="0" id="tblPackingData" bgcolor="#CCCCFF">
                <tr>
                  <td style="text-align:center; height:25" bgcolor="#498CC2" class="normaltxtmidb2">Style Ratio</td>
                </tr>
              </table>
                          </div>
              </fieldset>
              </td>
            </tr>
             <tr>
            <td align="center"><img src="../images/next.png" onclick="save_pl_no();" align="middle" class="mouseover" id="nxtImage" style="display:none" /></td>
            </tr>
            
          </table></td>
      </tr>
      
    </table></td>
  </tr>
</table>
</body>
</html>