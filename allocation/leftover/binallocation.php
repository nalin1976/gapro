<?php
	session_start();
	include "../../Connector.php";		
	$backwardseperator 	= "../../";
	$CompanyId			= $_SESSION["FactoryID"];
	$UserId 			= $_SESSION["UserID"];
	
	$mainStoreId		= $_GET["MainStoreId"];
	$buyerPoNo			= $_GET["BuyerPoNo"];
	$reqQty				= $_GET["ReqQty"];
	$styleId			= $_GET["StyleId"];
	$matDetailId		= $_GET["MatDetailId"];
	$color				= $_GET["Color"];
	$size				= $_GET["Size"];
	$grnNo				= $_GET["grnNo"];
	$grnNoArray			= explode('/',$grnNo);
	$grnType			= $_GET["grnType"];
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
            <tr  class="mainHeading">
              <td width="94%" height="25">Bin Items</td>
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
	//$sqlBin="select  SBA.strMainID,MS.strName,SBA.strSubID,SS.strSubStoresName,SBA.strLocID,SL.strLocName,SBA.strBinID,SB.strBinName,(dblCapacityQty-dblFillQty)As availableQty  from storesbinallocation  SBA inner join mainstores MS On MS.strMainID=SBA.strMainID inner join substores SS on SS.strSubID=SBA.strSubID inner join storeslocations SL on SL.strLocID=SBA.strLocID inner join storesbins SB on SB.strBinID=SBA.strBinID where SBA.strMainID='$mainStoreId' and intSubCatNo='$subCatId'";
	$sqlBin ="select ST.strMainStoresID,MS.strName,ST.strSubStores,SS.strSubStoresName,ST.strLocation,SL.strLocName,ST.strBin,SB.strBinName,sum(dblQty)as stockQty
		from stocktransactions_leftover ST 
		inner join mainstores MS On MS.strMainID=ST.strMainStoresID 
		inner join substores SS on SS.strSubID=ST.strSubStores 
		inner join storeslocations SL on SL.strLocID=ST.strLocation 
		inner join storesbins SB on SB.strBinID=ST.strBin 
		where ST.strMainStoresID='$mainStoreId'
		and ST.intStyleId='$styleId'
		and ST.strBuyerPoNo='$buyerPoNo'
		and ST.intMatDetailId='$matDetailId'
		and ST.strColor='$color'
		and ST.strSize='$size'
		and ST.intGrnNo='$grnNoArray[1]'
		and ST.intGrnYear='$grnNoArray[0]'
		and ST.strGRNType='$grnType'
		group by strMainStoresID,strSubStores,strLocation,strBin
		having stockQty >0";
	$result_bin=$db->RunQuery($sqlBin);
	while($row_bin=mysql_fetch_array($result_bin))
	{
?> 
     	<tr class="bcgcolor-tblrowWhite">
		  <td class="normalfntRite"><?php echo $row_bin["stockQty"];?></td>
		  <td class="normalfntMid"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="8" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0"/></td>
		  <td class="normalfntMid"><input type="checkbox" name="checkbox" id="checkbox" onclick="GetStockQty(this);"></td>
		  <td class="normalfntSM" nowrap="nowrap" id="<?php echo $row_bin["strBin"];?>"><?php echo $row_bin["strBinName"];?></td>
		  <td class="normalfntSM" nowrap="nowrap" id="<?php echo $row_bin["strLocation"];?>"><?php echo $row_bin["strLocName"];?></td>
		  <td class="normalfntSM" nowrap="nowrap" id="<?php echo $row_bin["strSubStores"];?>"><?php echo $row_bin["strSubStoresName"];?></td>
		  <td class="normalfntSM" nowrap="nowrap" id="<?php echo $row_bin["strMainStoresID"];?>"><?php echo $row_bin["strName"];?></td>
		</tr>
<?php
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
                  <td width="28%" align="center">
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
