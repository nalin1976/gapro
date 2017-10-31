<?php
	session_start();
	include "../Connector.php";		
	$backwardseperator 	= "../";
	$CompanyId			= $_SESSION["FactoryID"];
	$UserId 			= $_SESSION["UserID"];
	
	$styleID			= $_GET["StyleId"];
	$mainStoreID		= $_GET["MainStore"];
	$subStoreID			= $_GET["SubStore"];
	$matDetailID		= $_GET["MatId"];	
	$buyerPoNo			= $_GET["BuyerPoNo"];
	$color				= $_GET["Color"];
	$size				= $_GET["Size"];
	$adjustQty			= $_GET["AdjustQty"];
	$grnNo				= $_GET["GRNNo"];
	$arrayGrnNo			= explode('/',$grnNo);
	$grnTypeId			= $_GET["GRNTypeId"];
	$subCatID			= GetSubCatId($matDetailID);
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
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="650" border="0" bgcolor="#FFFFFF">
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
                    <td width="23%" class="normalfnt">LeftOver Qty</td>
                    <td width="55%" align="left"><input name="txtReqQty" type="text" class="txtbox" id="txtReqQty" style="width:100px;text-align:right" disabled="disabled"value="<?php echo $adjustQty ;?>" /></td>
                    <td width="18%">&nbsp;</td>
                  </tr>				  
              </table></td>
            </tr>
            <tr>
              <td ><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%" ><table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td colspan="3"><div id="divtblGatePassBinItem" style="overflow:scroll; height:250px; width:650px;">
                              <table id="tblBinItem" width="700" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                                <tr class="mainHeading2">
                                  <td width="82" height="25" class="normalfntMid">Available Qty</td>
                                  <td width="68" class="normalfntMid">Req Qty</td>
                                  <td width="22" class="normalfntMid">Add</td>
                                  <td width="101" class="normalfntMid">Bin</td>
                                  <td width="123" class="normalfntMid">Location</td>
                                  <td width="132" class="normalfntMid">Main Stores</td>
                                  <td width="112" class="normalfntMid">Sub Stores</td>
                           		</tr>
<?php
	$result = LoadMiQty($mainStoreID,$subStoreID,$styleID,$buyerPoNo,$matDetailID,$color,$size,$grnTypeId);
	while($row=mysql_fetch_array($result))
	{
?> 
     	<tr class="bcgcolor-tblrowWhite">
		  <td class="normalfntRite"><?php echo $row["BalQty"];?></td>
		  <td class="normalfntMid"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" style="text-align:right;width:80px" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0" /></td>
		  <td class="normalfntMid"><div align="center">
			  <input type="checkbox" name="checkbox" id="checkbox" onclick="GetStockQty(this);">
		  </div></td>
		  <td class="normalfntSM" id="<?php echo $row["binId"];?>"><?php echo $row["binName"];?></td>
		  <td class="normalfntSM" id="<?php echo $row["locId"];?>"><?php echo $row["locName"];?></td>
		  <td class="normalfntSM" id="<?php echo $row["mainSId"]?>"><?php echo $row["mainStoreName"];?></td>
		  <td class="normalfntSM" id="<?php echo $row["subSId"]?>" ><?php echo $row["subStoreName"];?></td>
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
                  <img src="../images/close.png" width="97" height="24" onclick="CloseIWLOItem('popupLayer1');" />
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
function LoadMiQty($mainStoreID,$subStoreID,$styleId,$buyerPoNo,$matDetailId,$color,$size,$grnTypeId)
{
global $db;
global $arrayGrnNo;
global $tableName;
	$sql="SELECT ".
		"Sum(ST.dblQty)AS BalQty, ".
		"ST.strMainStoresID as mainSId, ".
		"ST.strSubStores as subSId, ".
		"ST.strLocation as locId, ".
		"ST.strBin as binId, ".
		"MS.strName as mainStoreName, ".
		"SL.strLocName as locName, ".
		"SB.strBinName as binName, ".
		"SS.strSubStoresName  as subStoreName ".
		"FROM ".
		"stocktransactions AS ST ".
		"inner join mainstores MS on MS.strMainID=ST.strMainStoresID ".
		"inner join substores SS on SS.strSubID=ST.strSubStores ".
		"Inner Join storeslocations AS SL ON SL.strLocID = ST.strLocation ".
		"Inner Join storesbins AS SB ON ST.strBin = SB.strBinID ".
		"WHERE ".
		"ST.intStyleId =  '$styleId' and ".
		"ST.strBuyerPoNo =  '$buyerPoNo' and ".
		"ST.intMatDetailId =  '$matDetailId' and ".
		"ST.strColor =  '$color' and ".
		"ST.strSize =  '$size' and ".
		"ST.strMainStoresID = '$mainStoreID' and ".
		"ST.strSubStores = '$subStoreID' and ".
		"ST.intGrnNo='$arrayGrnNo[1]' and ".
		"ST.intGrnYear='$arrayGrnNo[0]' and ".
		"ST.strGRNType='$grnTypeId' ".
		"GROUP BY ".
		"ST.strMainStoresID, ".
		"ST.strSubStores, ".
		"ST.strLocation, ".
		"ST.strBin, ".
		"ST.intStyleId, ".
		"ST.strBuyerPoNo, ".
		"ST.intMatDetailId, ".
		"ST.strColor, ".
		"ST.strSize;";
	return $db->RunQuery($sql);
}

function GetSubCatId($matDetailID)
{
global $db;
$sql="select intSubCatID from matitemlist where intItemSerial='$matDetailID'";
$result=$db->RunQuery($sql);
$row = mysql_fetch_array($result);
return $row["intSubCatID"];
}
?>