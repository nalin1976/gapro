<?php
	session_start();
	include "../Connector.php";		
	$backwardseperator 	= "../";
	$CompanyId			= $_SESSION["FactoryID"];
	$UserId 			= $_SESSION["UserID"];
	
	$StoresId			= $_GET["StoresId"];	
	$mainStoreID		= $_GET["mainStoreID"];
	$subStoreID			= $_GET["subStoreID"];
	$issueQty			= $_GET["issueQty"];
	$styleID			= $_GET["styleID"];
	$matDetailID		= $_GET["matDetailID"];	
	$buyerPoNo			= $_GET["buyerPoNo"];
	$color				= $_GET["color"];
	$size				= $_GET["size"];
	$grnNo				= $_GET["grnNo"];
	$arrayGrnNo			= explode('/',$grnNo);
	$isTempStock		= $_GET["isTempStock"];
	$tableName 			= ($isTempStock=='0' ? "stocktransactions":"stocktransactions_temp");

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
<!--<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />-->
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="538" border="0" bgcolor="#FFFFFF">


<!--    <td><table width="100%" border="0">-->
      <tr>
        
        <td width="55%"><form id="frmBinItem" name="frmBinItem">
          <table width="100%" border="0">
            <tr>
              <td height="16" class="mainHeading">Bin Items</td>
            </tr>
            <tr>
              <td height="17"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="4%" height="25">&nbsp;</td>
                    <td width="23%" class="normalfnt">Return Qty</td>
                    <td width="55%"><input name="txtReqQty" type="text" class="txtbox" id="txtReqQty" size="31" readonly="" value="<?php echo $issueQty ;?>" /></td>
                    <td width="18%">&nbsp;</td>
                  </tr>				  
              </table></td>
            </tr>
            <tr>
              <td height="74"><table width="100%" height="141" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%" height="141"><table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td colspan="3"><div id="divtblGatePassBinItem" style="overflow:scroll; height:198px; width:550px;">
                              <table id="tblBinItem" width="625" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                                <tr class="mainHeading2">
                                  <td width="70" class="normalfntMid">Available Qty</td>
                                  <td width="70" class="normalfntMid">Req Qty</td>
                                  <td width="20" class="normalfntMid">Add</td>
                                  <td width="150" class="normalfntMid">Bin</td>
                                  <td width="150" class="normalfntMid">Location</td>
                                  <td width="40" class="normalfntMid">Main Stores</td>
                                  <td width="40" class="normalfntMid">Sub Stores</td>
                           </tr>
<?php
	$sqlBin="SELECT ".
			"Sum(ST.dblQty)AS StockBal, ".
			"SL.strLocName, ".
			"SB.strBinName, ".
			"ST.strMainStoresID, ".
			"ST.strSubStores, ".
			"ST.strLocation, ".
			"ST.strBin ".
			"FROM ".
			"$tableName AS ST ".
			"Inner Join storeslocations AS SL ON SL.strLocID = ST.strLocation ".
			"Inner Join storesbins AS SB ON ST.strBin = SB.strBinID ".
			"Inner Join useraccounts AS UA ON ST.intUser = UA.intUserID ".
			"WHERE ".
			"ST.intStyleId =  '$styleID' and ".
			"ST.strBuyerPoNo =  '$buyerPoNo' and ".
			"ST.intMatDetailId =  '$matDetailID' and ".
			"ST.strColor =  '$color' and ".
			"ST.strSize =  '$size' and ".
			//"UA.intCompanyID =  '$CompanyId' AND ".
			"ST.strMainStoresID = '$mainStoreID' and ".
			"ST.strSubStores = '$subStoreID' and ".
			"ST.intGrnNo=$arrayGrnNo[1] and ".
			"ST.intGrnYear=$arrayGrnNo[0] and ST.strGRNType ='S'".
			"GROUP BY ".
			"ST.strMainStoresID, ".
			"ST.strSubStores, ".
			"ST.strLocation, ".
			"ST.strBin, ".
			"ST.intStyleId, ".
			"ST.strBuyerPoNo, ".
			"ST.intMatDetailId, ".
			"ST.strColor, ".
			"ST.strSize,ST.strGRNType";
	$result_bin=$db->RunQuery($sqlBin);
	while($row_bin=mysql_fetch_array($result_bin))
	{
?> 
     	<tr class="bcgcolor-tblrowWhite">
		  <td class="normalfntRite"><?php echo round($row_bin["StockBal"],2);?></td>
		  <td class="normalfntMid"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="8" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0" /></td>
		  <td class="normalfntMid"><div align="center">
			  <input type="checkbox" name="checkbox" id="checkbox" onclick="GetStockQty(this);">
		  </div></td>
		  <td class="normalfntSM" id="<?php echo $row_bin["strBin"];?>"><?php echo $row_bin["strBinName"];?></td>
		  <td class="normalfntSM" id="<?php echo $row_bin["strLocation"];?>"><?php echo $row_bin["strLocName"];?></td>
		  <td class="normalfntSM" ><?php echo $row_bin["strMainStoresID"];?></td>
		  <td class="normalfntSM" ><?php echo $row_bin["strSubStores"];?></td>
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
              <td height="32"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
                <tr >
                  <td ><div align="center">
                  <img src="../images/ok.png" alt="ok" width="86" height="24" onclick="SetBinItemQuantity(this);">                  
                  <img src="../images/close.png" width="97" height="24" onclick="closeWindow();" />
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
