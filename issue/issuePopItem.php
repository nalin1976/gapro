<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body><table width="950" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
  <tr>
    <td class="mainHeading">MRN Details</td>
  </tr>
   <tr>
    <td height="5px;"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
          <tr>
            <td width="7%" class="normalfnt">Style No</td>
            <td width="9%"><select name="cboStyleNo" id="cboStyleNo" style="width:80px;" onChange="LoadStyles(this.value);">
            </select>            </td>
            <td width="7%" class="normalfnt">Order No</td>
            <td width="9%"><select name="cboorderno" id="cboorderno" style="width:80px;" onChange="LoadBuyerPoNo();LoadSCNO(this);">
            </select>            </td>
            <td width="5%" class="normalfnt">SC No</td>
            <td width="7%"><select name="cboScNo" id="cboScNo" style="width:50px;" onChange="LoadStyleID(this); loadstyleName();">
            </select>            </td>
            <td width="8%" class="normalfnt">Buyer Po No</td>
            <td width="9%"><select name="cbobuyerpono" id="cbobuyerpono" style="width:80px;" onChange="LoadMrnNo();">
            </select>            </td>
            <td width="6%" class="normalfnt">Material</td>
            <td width="9%"><select name="cbomaterial" id="cbomaterial" style="width:80px;">
            </select>            </td>
            <td width="6%" class="normalfnt">MRN No</td>
            <td width="9%"><select name="cbomrnno" id="cbomrnno" style="width:80px;" onChange="loadMrnDetailsToGrid();">
            </select>            </td>
            <td width="9%"><img src="../images/search.png" width="80" height="24" onClick="loadMrnDetailsToGrid();"></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="5px;"></td>
  </tr>
  <tr class="mainHeading2">
    <td height="21">Issue Items</td>
  </tr>
  <tr>
    <td><div style="overflow:scroll; height:332px; width:950px;" id="divIssueItem">
      <table width="100%" border="0" cellspacing="1" cellpadding="0" id="IssueItem" bgcolor="#CCCCFF">
        <tr class="mainHeading4">
          <td width="3%" height="25"><input type="checkbox" name="chk" id="chk" onClick="SelectAll(this);"></td>
          <td width="20%">Details</td>
          <td width="7%">Color</td>
          <td width="7%">Size</td>
          <td width="7%">Unit</td>
          <td width="7%">Req Qty</td>
          <td width="9%">GRN Balance</td>
          <td width="3%">&nbsp;</td>
          <td width="9%">Order No</td>
          <td width="9%">Buyer PO No</td>
          <td width="5%">GRN No</td>
          <td width="7%">GRN Year</td>
          <td width="7%">GRN Type</td>
        </tr>
      </table>
    
    </div></td>
  </tr>
   <tr>
    <td height="5px;"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><img src="../images/ok.png" width="86" height="24" onClick="LoaddetailsTomainPage();"><img src="../images/close.png" width="97" height="24" onClick="CloseOSPopUp('popupLayer1');"></td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td height="5px;"></td>
  </tr>
</table>

</body>
</html>
