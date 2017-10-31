<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="950" height="450" border="0" cellspacing="3" cellpadding="0" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0" cellspacing="3" cellpadding="0" class="bcgl1" bgcolor="#FFFFFF">
      <tr>
        <td><div align="right"><img src="images/closelabel.gif" alt="close" width="66" height="22" onclick="closeWindow();" /></div></td>
      </tr>
      <tr>
        <td class="mainHeading">Select Items          </td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
          <tr>
            <td width="100%"><table width="109%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
              <tr>
                <td width="11%" height="25">Style No</td>
                <td width="22%"><select onchange="styleWiseSCno();styleWiseOrderNo();" style="width: 200px;" class="txtbox" id="cboStyleID" name="cboStyleID">
                    <option value="">Select One</option>
                  </select>
                </td>
                <td width="10%" >Order No</td>
                <td width="24%" ><select name="cboOrderNo" id="cboOrderNo" style="width:200px;" onchange="LoadStyleandSC();LoadBuyerPO();LoadMainCat();">
                  <option value="">Select One</option>
                </select>
                </td>
                <td width="12%">SC No</td>
                <td width="21%"><select onchange="GetStyleID(this); getStyleName(); LoadBuyerPO();LoadMainCat();" style="width: 120px;" id="cboscno" class="txtbox" name="cboscno">
                    <option value="">Select One</option>
                   
                  </select>
                </td>
              </tr>
              <tr>
                <td height="25">Main Category</td>
                <td>
                  <select onchange="LoadSubCat();" style="width: 200px;" id="cbomat" class="txtbox" name="cbomat">
                  </select>
                </td>
                <td>Request Qty</td>
                <td><input type="text" onblur="getReqQty(this);" id="txtReqQty" style="width: 198px;" class="txtbox" name="txtReqQty" maxlength="20" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onkeyup="validateOrderQty();"/></td>
                <td>Order Qty</td>
                <td><input type="text" readonly="true" style="width: 118px; text-align:right" id="txtorderqty" class="txtbox" name="txtorderqty" /></td>
              </tr>
              <tr>
                <td height="25">Sub Category</td>
                <td><select style="width: 200px;" id="cbomaterials" class="txtbox" name="cbomaterials">
                  </select>
                </td>
                <td >Wash Color</td>
                <td id="txtStyleRatioColor" class="normalfnt2BI"><!--<input type="text" name="txtStyleRatioColor" id="txtStyleRatioColor" style="width:118px;" readonly="readonly" />--></td>
                <td rowspan="2" ><img src="images/search.png" alt="Search"align="absmiddle" class="mouseover" onclick="MatToMRN();" /></td>
                <td ><img src="images/cut_qty.png" alt="Search" height="22" align="absmiddle" class="mouseover" onclick="createCutWisePopUP();" style="visibility:hidden"/><span style="visibility:hidden">
                  <select onchange="LoadQty();" style="width: 20px;" id="cbobuyerpono" class="txtbox" name="cbobuyerpono">
                  </select>
                </span></td>
              </tr>
              <tr>
                <td height="25">Pattern No</td>
                <td><select style="width: 200px;" id="cboPatternNo" class="txtbox" name="cboPatternNo">
                </select></td>
                <td >&nbsp;</td>
                <td id="txtStyleRatioColor2" class="normalfnt2BI">&nbsp;</td>
                <td >&nbsp;</td>
              </tr>
            </table></td>
            
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="bcgl1"><div style="overflow: scroll; height: 260px; width: 930px;" id="divcons">
          <table width="1200px" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="mrnMatGrid" class="normalfnt">
            <tbody>
              <tr class="mainHeading4">
                <td width="0%" >&nbsp;</td>
                <td width="0%" >&nbsp;</td>
                <td height="25" width="18%" >Item</td>
                <td width="5%" >Color</td>
                <td width="5%" >Size</td>
                <td width="5%" >UOM</td>
                <td width="4%" >Total Qty</td>
                <td width="6%" >Req Qty</td>
                <td width="3%" >Bal To MRN Qty</td>
                <td width="4%" >MRN Raised</td>
                <td width="5%" >Issued Qty</td>
                <td width="5%" >Issue Balance</td>
                <td width="5%" >Stock Balance </td>
                <td width="3%" >Con Pc</td>
                <td width="5%" >Wastage</td>
                <td width="3%" >App Qty</td>
                <td width="3%" >Not App Qty</td>
                <td width="1%"   class="normaltxtmidb2" style="display:none">*</td>
                <td width="1%"  style="display:none" class="normaltxtmidb2">*</td>
                 <td width="3%"   >GRN No</td>
                <td width="3%"  >GRN Year</td>
                 <td width="3%"  >GRN Type</td>
                  <td width="11%"  >Invoice No</td>
                   <td width="2%" >&nbsp;</td>
              </tr>
            </tbody>
          </table>
        </div></td>
      </tr>
      <tr>
        <td><table width="100%" cellspacing="0" cellpadding="0" class="bcgl1">
          <tbody>
            <tr class="normalfnt">
              <td width="21" >&nbsp;</td>
              <td  width="27" class='txtbox bcgcolor-InvoiceCostTrim'>&nbsp;</td>
              <td width="146">&nbsp;Not Inhouse</td>
            
              <td width="28" class="txtbox bcgcolor-InvoiceCostService">&nbsp;</td>
              <td width="364">&nbsp;MRN Completed</td>
               <!-- <td width="5%" style="background: none repeat scroll 0% 0% rgb(204, 255, 255); border: 1px solid rgb(51, 51, 51);">&nbsp;</td>-->
              <td width="158" style="visibility:hidden">Not Trim Inspected</td>
              <td width="93"><img  onclick="addtoMainGrid();" alt="OK" class="mouseover" src="images/ok.png" /></td>
              <td width="97"><img src="images/close.png" alt="close" border="0" class="mouseover" onclick="closeWindow();" /></td>
            </tr>
          </tbody>
        </table>
        </td>
      </tr>      
    </table></td>
  </tr>
</table>
</body>
</html>
