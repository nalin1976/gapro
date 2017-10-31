<?php
	session_start();
	include "../../Connector.php";		
	$backwardseperator 	= "../../";
	$CompanyId			= $_SESSION["FactoryID"];
	$UserId 			= $_SESSION["UserID"];
	
	$matdetailId		= $_GET["matdetailId"];	
	$color				= $_GET["color"];	
	$size				= $_GET["size"];	
	$mainStoreId		= $_GET["mainStoreId"];
	$reqQty				= $_GET["reqQty"];
	$grnNo				= $_GET["grnNo"];
	$grnYear			= $_GET["grnYear"];
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
<script src="lefetover.js" type="text/javascript"></script>
</head>

<body>
<table width="538" border="0" bgcolor="#FFFFFF">
      <tr>        
        <td width="55%"><form id="frmBinItem" name="frmBinItem">
          <table width="100%" border="0">
            <tr class="mainHeading">
              <td width="94%" height="25" >Bin Items</td>
              <td width="6%" ><img src="../../images/cross.png" alt="close" class="mouseover"onclick="closeWindow()"/></td>
            </tr>
            <tr>
              <td height="17" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="4%" height="25">&nbsp;</td>
                    <td width="23%" class="normalfnt">Req Qty</td>
                    <td width="55%"><input name="txtReqQty" type="text" class="txtbox" id="txtReqQty" size="31" readonly="" value="<?php echo $reqQty ;?>" /></td>
                    <td width="18%">&nbsp;</td>
                  </tr>				  
              </table></td>
            </tr>
            <tr>
              <td height="74" colspan="2"><table width="100%" height="141" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%" height="141"><table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td colspan="3"><div id="divtblGatePassBinItem" style="overflow:scroll; height:239px; width:630px;">
                              <table id="tblBinItem" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                                <tr class="mainHeading4">
                                  <td width="70" height="25" >AVI Qty</td>
                                  <td width="70" >Req Qty</td>
                                  <td width="20" >Add</td>
                                  <td >Bin</td>
                                  <td >Location</td>
                                  <td >Sub Stores</td>
                                  <td >Main Stores</td>
                           </tr>
<?php
	$sqlBin="select sum(dblQty)as stockQty,BST.strMainStoresID,MS.strName,BST.strSubStores,SS.strSubStoresName,BST.strLocation,SL.strLocName,SB.strBinID,SB.strBinName
from stocktransactions_bulk BST
inner join mainstores MS on MS.strMainID=BST.strMainStoresID
inner join substores SS on SS.strSubID=BST.strSubStores
inner join storeslocations SL on SL.strLocID=BST.strLocation
inner join storesbins SB on SB.strBinID=BST.strBin
where intMatDetailId='$matdetailId' 
and strColor='$color' 
and strSize='$size' 
and MS.intStatus=1 
and MS.strMainID='$mainStoreId'
and intBulkGrnNo='$grnNo'
and intBulkGrnYear='$grnYear'
group by BST.strMainStoresID,MS.strName,BST.strSubStores,SS.strSubStoresName,BST.strLocation,SL.strLocName,
SB.strBinID,SB.strBinName";

	$result_bin=$db->RunQuery($sqlBin);
	while($row_bin=mysql_fetch_array($result_bin))
	{
		$availableQty = round($row_bin["stockQty"],2);
		if($availableQty>0)
		{
?> 
     	<tr class="bcgcolor-tblrowWhite">
		  <td class="normalfntRite"><?php echo $availableQty;?></td>
		  <td class="normalfntMid"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="8" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0"/></td>
		  <td class="normalfntMid"><input type="checkbox" name="checkbox" id="checkbox" onclick="GetStockQty(this);"></td>
		  <td class="normalfntSM" nowrap="nowrap" id="<?php echo $row_bin["strBinID"];?>"><?php echo $row_bin["strBinName"];?></td>
		  <td class="normalfntSM" nowrap="nowrap" id="<?php echo $row_bin["strLocation"];?>"><?php echo $row_bin["strLocName"];?></td>
		  <td class="normalfntSM" nowrap="nowrap" id="<?php echo $row_bin["strSubStores"];?>"><?php echo $row_bin["strSubStoresName"];?></td>
		  <td class="normalfntSM" nowrap="nowrap" id="<?php echo $row_bin["strMainStoresID"];?>"><?php echo $row_bin["strName"];?></td>
		</tr>
<?php
		}
	}
?>                 
                            </table>
                          </div></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="32" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
                <tr >
					<td align="center">
                  <img src="../../images/ok.png" alt="ok" width="86" height="24" onclick="SetBinItemQuantity(this);">
                  <img src="../../images/close.png" width="97" height="24" onclick="closeWindow();" />
                  </td>
                </tr>
              </table></td>
            </tr>
          </table>
        </form></td>
      </tr>
  </tr>

</table>
</body>
</html>
