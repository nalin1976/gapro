<?php
	session_start();
	include "../Connector.php";		
	$backwardseperator 	= "../";
	$CompanyId			= $_SESSION["FactoryID"];
	$UserId 			= $_SESSION["UserID"];
	$qty 				= $_GET["pub_TrasferInQty"];
	$pub_index 			= $_GET["pub_index"];
	$fromStyleId		= $_GET["fromStyleId"];
	$matDetailId		= $_GET["matDetailId"];
	$buyerPoNo			= $_GET["buyerPoNo"];
	$color				= $_GET["color"];
	$size				= $_GET["size"];
	$grnNo				= $_GET["GRNNo"];
		$grnNoArray 	= explode('/',$grnNo);
	$grnype				= $_GET["GRNType"];
	$StoresId			= $_GET["StoresId"];
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
                    <td width="23%" class="normalfnt">Required Quantity</td>
                    <td width="55%"><input name="txtReqQty" type="text" class="txtbox" id="txtReqQty" size="31" readonly="" value="<?php echo $qty ?>" /></td>
                    <td width="18%">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="74"><table width="100%" height="141" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%" height="141"><table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td colspan="3"><div id="divtblGatePassBinItem" style="overflow:scroll; height:200px; width:550px;">
                              <table id="tblBinItem" width="549" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                                <tr class="mainHeading4">
                                  <td width="56" height="25" >AVI Qty</td>
                                  <td width="51">Alloc Qty</td>
                                  <td width="25" >Add</td>
                                  <td width="130" >Main Stores</td>
                                  <td width="126">Sub Stores</td>
                                  <td width="83">Location</td>
                                  <td width="76">Bin ID</td>
                                </tr>
<?php
$SQL="SELECT ".
		"ST.strMainStoresID, ".
		"ST.strSubStores, ".
		"ST.strLocation, ".
		"ST.strBin, ".
		"Sum(ST.dblQty) AS StockQty, ".
		"mainstores.strName, ".
		"substores.strSubStoresName, ".
		"storeslocations.strLocName, ".
		"storesbins.strBinName ".
		"FROM ".
		"stocktransactions AS ST ".
		"Inner Join mainstores ON mainstores.strMainID = ST.strMainStoresID ".
		"Inner Join substores ON substores.strSubID = ST.strSubStores ".
		"Inner Join storeslocations ON storeslocations.strLocID = ST.strLocation ".
		"Inner Join storesbins ON storesbins.strBinID = ST.strBin ".
		"WHERE ".
		"ST.intStyleId =  '$fromStyleId' AND ".
		"ST.strBuyerPoNo =  '$buyerPoNo' AND ".
		"ST.intMatDetailId =  '$matDetailId' AND ".
		"ST.strColor =  '$color' AND ".
		"ST.strSize =  '$size' AND ".
		"ST.strMainStoresID='$StoresId' AND ".
		"ST.intGrnNo='$grnNoArray[1]' AND ".
		"ST.intGrnYear='$grnNoArray[0]' AND ".
		"ST.strGRNType='$grnype' ".
		"GROUP BY ".
		"ST.strMainStoresID, ".
		"ST.strSubStores, ".
		"ST.strLocation, ".
		"ST.strBin, ".
		"ST.intStyleId, ".
		"ST.strBuyerPoNo, ".
		"ST.intMatDetailId, ".
		"ST.strColor, ".
		"ST.strSize, ".
		"ST.intGrnNo, ".
		"ST.intGrnYear, ".
		"ST.strGRNType;";
// echo $SQL;
		$result =$db->RunQuery($SQL);
		while ($row=mysql_fetch_array($result))
		{
?>
                                <tr class="bcgcolor-tblrowWhite">
                                  <td class="normalfntRite"><?php echo $row["StockQty"]?></td>
                                  <td class="normalfntRite"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="8" style="text-align:right" onkeypress="return isNumberKey(event);" value="0" /></td>
                                  <td class="normalfnt"><div align="center">
                                      <input type="checkbox" name="checkbox" id="checkbox" onclick="GetStockQty(this);">
                                  </div></td>
                                  <td class="normalfntSM" id="<?php echo $row["strMainStoresID"]?>"><?php echo $row["strName"]?></td>
                                  <td class="normalfntSM" id="<?php echo $row["strSubStores"]?>"><?php echo $row["strSubStoresName"]?></td>
                                  <td class="normalfntSM" id="<?php echo $row["strLocation"]?>"><?php echo $row["strLocName"]?></td>
                                  <td class="normalfntSM" id="<?php echo $row["strBin"]?>"><?php echo $row["strBinName"]?></td>
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
                  <td width="28%"></td>
                  <td width="18%"><img src="../images/ok.png" alt="ok" width="86" height="24" onclick="SetBinItemQuantity(this,pub_index);"></td>
                  <td width="6%">&nbsp;</td>
                  <td width="20%"><img src="../images/close.png" width="97" height="24" onclick="closeWindow();" /></td>
                  <td width="28%">&nbsp;</td>
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
