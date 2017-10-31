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
<table width="950" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="tableBorder">
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
                    <td width="55%" align="left"><input name="txtReqQty" type="text" class="txtbox" id="txtReqQty" style="width:100px;text-align:right" disabled="disabled"value="<?php echo $adjustQty ;?>" /></td>
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
                          <div id="divtblGatePassLeftOverBinItem" style="overflow:scroll;height:150px; width:950px;">
                              <table id="tblBinItem" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                                <tr class="mainHeading2">
                                  <td height="15" colspan="8" >&nbsp;Stock Details</td>
                                </tr>
                                <tr class="mainHeading4">
                                  <td width="82" height="25" >Available Qty</td>
                                  <td width="68" >Req Qty</td>
                                  <td width="22" >Add</td>
                                  <td width="132" >Main Stores</td>
                                  <td width="112" >Unit</td>
                                  <td width="112" >GRN No</td>
                                  <td width="112" >GRN Year</td>
                                  <td width="112" >GL Code</td>
                                  </tr>
<?php
		$result = LoadMiLeftOverQty($costCenter,$CompanyId,$matDetailID);
	while($row=mysql_fetch_array($result))
	{
		$GLAllowId    = $row["intGLAllowId"];
		$GLCode       = $objgl-> getGLCode($GLAllowId);
?> 
     	<tr class="bcgcolor-tblrowWhite">
		  <td class="normalfntRite"><?php echo round($row["BalQty"],0);?></td>
		  <td class="normalfntMid"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" style="text-align:right;width:80px" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onkeyup="validateQty(this);" value="0" /></td>
		  <td class="normalfntMid"><div align="center">
		    <input type="checkbox" name="checkbox" id="checkbox" onclick="GetStockQty(this);">
		    </div></td>
		  <td class="normalfntSM" id="<?php echo $row["mainSId"]?>"><?php echo $row["mainStoreName"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["Unit"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["intGRNNo"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["intGRNYear"];?></td>
		  <td class="normalfntSM" style="text-align:center" id="<?php echo $GLAllowId; ?>" ><?php echo $GLCode;?></td>
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
                  <img src="../../images/ok.png" alt="ok" width="86" height="24" onclick="SetBinItemQuantity(this);">                  
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
function LoadMiLeftOverQty($costCenter,$CompanyId,$matDetailID)
{
	global $db;
	
	$sql = "SELECT round(Sum(GST.dblQty),2) - coalesce((SELECT coalesce(round(sum(MRD.dblBalQty),2),0) AS A FROM genmatrequisitiondetails AS MRD 
Inner Join genmatrequisition AS MR ON MR.intMatRequisitionNo = MRD.intMatRequisitionNo AND MR.intMRNYear = MRD.intYear 
WHERE MRD.strMatDetailID ='$matDetailID' AND MR.intCostCenterId ='$costCenter' and dblBalQty>0 Group By MRD.strMatDetailID,MR.intCostCenterId),0) AS BalQty,
			GST.strMainStoresID as mainSId, 
			GST.strUnit as Unit,
			GST.intGRNNo,
			GST.intGRNYear,
			C.strComCode as mainStoreName,
			GST.intGLAllowId
			FROM 
			genstocktransactions AS GST 
			inner join companies C on C.intCompanyID=GST.strMainStoresID 
			WHERE 
			GST.intMatDetailId = '$matDetailID' and
			GST.strMainStoresID ='$CompanyId' and
			GST.intCostCenterId ='$costCenter'
			GROUP BY 
			GST.intCostCenterId, 
			GST.strMainStoresID, 
			GST.intMatDetailId, 
			GST.intGRNNo,
			GST.intGRNYear,
			GST.intGLAllowId
			having BalQty>0
			order by GST.intGRNYear,GST.intGRNNo";
	return $db->RunQuery($sql);
}

?>