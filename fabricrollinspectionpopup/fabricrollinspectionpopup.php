<?php
	include "../Connector.php";
	session_start();
	
	$StyleID		= $_GET["StyleID"];
	$MatDetailID	= $_GET["MatdetailID"];
	$BuyerPoNo		= $_GET["BuyerPoNo"];
	$Color			= $_GET["Color"];
	$category		= $_GET["category"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fabric Roll Inspection :: Details</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->

</style>
<script type="text/javascript" src="fabricrollinspectionpopup.js"></script>
</head>

<body onload="LoadItemDetails">

<form name="frmMaterialsPopUp" id="frmMaterialsPopUp">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="21" bgcolor="#9BBFDD" class="normalfnt2bldBLACKmid mouseover" id="titHeaderCategory" title="<?php echo $category?>">Roll Plan Allocation - <?php echo $category?></td>
        </tr>
      <tr>
        <td class="normalfnt"><div id="divIssueItem" style="overflow:scroll; height:280px; width:950px;">
          <table id="tblMatPopUp" width="930" cellpadding="0" cellspacing="1">
            <tr>
              <td width="4%" height="33" bgcolor="#498CC2" class="normaltxtmidb2" onclick="SelectAll();" ondblclick="UnSelectAll();">Select</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Roll Serial No</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2L">Roll NO</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Batch NO</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Width</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Length</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Weight</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Balance Qty</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Issue Qty</td>			  
              </tr>
  <?php
$SQL="select concat(FRH.intFRollSerialYear,'/',FRH.intFRollSerialNO) as SerialNo,
FRD.intRollNo,
FRH.intCompanyBatchNo,
FRD.dblSuppWidth,
FRD.dblSuppLength,
FRD.dblSuppWeight,
FRD.dblQty,
FRD.dblBalQty
from fabricrollheader FRH
inner join fabricrolldetails FRD
ON FRH.intFRollSerialNO=FRD.intFRollSerialNO And FRH.intFRollSerialYear=FRD.intFRollSerialYear
where intStyleId='$StyleID' and 
strMatDetailID=$MatDetailID and 
strBuyerPoNo='$BuyerPoNo' and 
strColor ='$Color' and 
intStatus=1 and 
intStoresID =1";

		$result =$db->RunQuery($SQL);		
		while ($row=mysql_fetch_array($result))
		{			
			$AvailableQty=$row["dblBalQty"];
			
?>
            <tr class="bcgcolor-tblrow">
              <td><div align="center">
                <input type="checkbox" name="chksel" id="chksel" onclick="ChangeIssueQty(this);"/>
                </div></td>
              <td class="normalfnt"><?php echo $row["SerialNo"];?></td>
              <td class="normalfnt"><?php echo $row["intRollNo"];?></td>
              <td class="normalfntMid"><?php echo $row["intCompanyBatchNo"];?></td>
              <td class="normalfntMid"><?php echo $row["dblSuppWidth"];?></td>
              <td class="normalfntMid"><?php echo $row["dblSuppLength"];?></td>
              <td class="normalfntMid"><?php echo $row["dblSuppWeight"];?></td>
              <td class="normalfntMid"><?php echo $AvailableQty;?></td>
              <td class="normalfntMid"><input name="txtSuppWith" type="text" class="txtbox" id="txtSuppWith" size="15" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" tabindex="10" value="0" onkeyup="CalculateTotalIssueQty();ValidatePopUpQty(this);"/></td>			  					  
              </tr>
  <?php
			}  
?>
            </table>
          </div></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
      <td width="16%">&nbsp;</td>
  	<td width="16%">&nbsp;</td>
    <td width="16%">&nbsp;</td>
    <td width="16%">&nbsp;</td>
    <td width="16%" class="normalfntRite">Issue Qty</td>
    <td width="16%" ><span class="normalfntMid">
      <input name="txtPopUpIssueQty" type="text" class="txtbox" id="txtPopUpIssueQty" disabled="disabled" size="15" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" tabindex="10" value="0"/>
    </span></td>
  </tr>
      <tr>
      	<td width="16%">&nbsp;</td>
        <td width="16%" height="29"></td>
        <td width="16%"><img src="../images/ok.png" width="86" height="24" onclick="GetPopUpIssueQtyToText();" /></td>
        <td width="16%"><img src="../images/close.png" width="97" height="24" border="0" onclick="closeWindow();" /></td>
        <td width="16%">&nbsp;</td>
         <td width="16%">&nbsp;</td>
        
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
