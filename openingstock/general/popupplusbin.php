<?php
	session_start();
	include "../../Connector.php";		
	include("../../GeneralInventory/class.glcode.php");
	$objgl = new glcode();
	$backwardseperator 	= "../";
	$CompanyId			= $_SESSION["FactoryID"];
	$UserId 			= $_SESSION["UserID"];
	$costCenter			= $_GET["costCenter"];
	$matDetailID		= $_GET["MatId"];	
	$adjustQty			= $_GET["AdjustQty"];
	$adjestM			= $_GET["AdjestM"];
	$mainCatId			= $_GET["mainCatId"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bin Items</title>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="450" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="tableBorder">
      <tr>
        
        <td width="100%"><form id="frmBinItem" name="frmBinItem">
          <table width="100%" border="0">
            <tr>
              <td height="25" class="mainHeading">Bin Items</td>
            </tr>
            <tr>
              <td height="17"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="4%" height="25">&nbsp;</td>
                    <td width="23%" class="normalfnt">Return Qty</td>
                    <td width="55%" align="left"><input name="txtReqQty" type="text" class="txtbox" id="txtReqQty" style="width:100px;text-align:right" disabled="disabled" value="<?php echo $adjustQty ;?>" /><input type="hidden" id="txtHiddnReturnQty" name="txtHiddnReturnQty" value="<?php echo $adjustQty ;?>" ></td>
                    <td width="18%">&nbsp;</td>
                  </tr>				  
              </table></td>
            </tr>
            <tr>
              <td ><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%" ><table width="100%" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td colspan="3"><table width="100%" border="0" class="tableBorder" >
                          <tr>
                          <td>
                          <div id="divtblGatePassLeftOverBinItem" style="overflow:scroll;height:150px; width:450px;">
                              <table id="tblBinItem" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                                <tr class="mainHeading2">
                                  <td height="15" colspan="4" >&nbsp;Stock Details</td>
                                </tr>
                                <tr class="mainHeading4">
                                  <td width="24%"  height="25" >Req Qty</td>
                                  <td width="10%"  >Add</td>
                                  <td width="23%"  >GL Code</td>
                                  <td width="43%"  >GL Description</td>
                                  </tr>
<?php
	$sql = "select BAMC.intGlId,GA.strDescription,GF.GLAccAllowNo,concat(GA.strAccID,'-',C.strCode) as GLCode
			from budget_glallocationtomaincategory BAMC
			inner join glaccounts GA on GA.intGLAccID = BAMC.intGlId
			inner join glallowcation GF on GF.GLAccNo=GA.intGLAccID
			inner join costcenters C on C.intCostCenterId=GF.FactoryCode
			where intMatCatId='$mainCatId' and GF.FactoryCode='$costCenter' ";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$GLAllowId    = $row["GLAccAllowNo"];
		$GLCode       = $row["GLCode"];
		$GLDes		  = $row["strDescription"];
?> 
     	<tr class="bcgcolor-tblrowWhite">
		  <td class="normalfntMid" id="<?php echo $mainCatId; ?>"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" style="text-align:right;width:80px" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onblur="validatePlusQty(this);" value="0" /></td>
		  <td class="normalfntMid" ><div align="center">
		    <input type="checkbox" name="chkStockQty" id="chkStockQty" onblur="checkStockQty(this);" >
		    </div></td>
		  <td class="normalfntSM" style="text-align:center" id="<?php echo $GLAllowId; ?>" ><?php echo $GLCode; ?></td>
		  <td class="normalfntSM" style="text-align:left" >&nbsp;<?php echo $GLDes; ?>&nbsp;</td>
		  </tr>
<?php
	}
?>                 
                            </table>
                          </div>
                          </td>
                          </tr>
                          </table>
                          </td>
                        </tr>
                       
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="32"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
                <tr >
                  <td ><div align="center">
                  <img src="../../images/ok.png" alt="ok" width="86" height="24" onclick="SetPlusBinItemQuantity(this);">                  
                  <img src="../../images/close.png" width="97" height="24" onclick="CloseOSPopUp('popupLayer1');" />
				  </div></td>                  
                </tr>
              </table></td>
            </tr>
          </table>
        </form></td>
        
      </tr>
   <!-- </table></td>-->
  </tr>

</table>
</body>
</html>
<?php
function LoadMiLeftOverQty($costCenter,$mainCatId)
{
	global $db;
	
	$sql = "select BAMC.intGlId,GA.strAccID,GA.strDescription,C.strCode,GF.GLAccAllowNo
			from budget_glallocationtomaincategory BAMC
			inner join glaccounts GA on GA.intGLAccID = BAMC.intGlId
			inner join glallowcation GF on GF.GLAccNo=GA.intGLAccID
			inner join costcenters C on C.intCostCenterId=GF.FactoryCode
			where intMatCatId=1 and GF.FactoryCode=10";
	return $db->RunQuery($sql);
}

?>