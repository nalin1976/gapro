<?php
	session_start();
	include "../../Connector.php";		
	$backwardseperator 	= "../";
	$CompanyId			= $_SESSION["FactoryID"];
	$UserId 			= $_SESSION["UserID"];
	
	$qty 				= $_GET["pub_TrasferInQty"];	
	$StoresId			= $_GET["StoresId"];	
	$mainStoreID		= $_GET["mainStoreID"];
	$subStoreID			= $_GET["subStoreID"];
	$issueQty			= $_GET["issueQty"];
	$index				= $_GET["index"];
	$subCatID			= $_GET["subCatID"];
	$styleId			= $_GET['styleId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bin Items</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<!--<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />-->
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="538" border="0">


<!--    <td><table width="100%" border="0">-->
      <tr>
        
        <td width="55%"><form id="frmBinItem" name="frmBinItem">
          <table width="100%" border="0">
            <tr>
              <td height="16" bgcolor="#498CC2" class="TitleN2white">Bin Items</td>
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
                    <td width="100%" height="141"><table width="100%" border="0" class="bcgl1">
                        <tr>
                          <td colspan="3"><div id="divtblGatePassBinItem" style="overflow:scroll; height:200px; width:550px;">
                              <table id="tblBinItem" width="750" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                                <tr>
                                  <td width="8%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Available Qty</td>
                                  <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Req Qty</td>
                                  <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">Add</td>
                                  <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Bin</td>
                                  <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Location</td>
                                  <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Main Stores</td>
                                  <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Sub Stores</td>
                                </tr>
<?php 
$sql="SELECT ".
		"SBA.strMainID, ".
		"SBA.strSubID, ".
		"SBA.strLocID, ".
		"SBA.strBinID, ".
		"SBA.intSubCatNo, ".		
		"SBA.strUnit, ".		
		"(sum(SBA.dblCapacityQty)-sum(SBA.dblFillQty))as BalQty, ".
		"SB.strBinName, ".
		"SL.strLocName, ".
		"MS.strName, ".
		"SS.strSubStoresName ".
		"FROM ".
		"storesbinallocation AS SBA ".
		"Inner Join storesbins AS SB ON SBA.strMainID = SB.strMainID AND SBA.strSubID = SB.strSubID AND SBA.strLocID = SB.strLocID AND SBA.strBinID = SB.strBinID ".
		"Inner Join storeslocations AS SL ON SL.strLocID = SBA.strLocID ".
		"Inner Join mainstores MS ON MS.strMainID=SBA.strMainID ".
		"Inner Join substores SS ON SS.strSubID=SBA.strSubID AND SS.strMainID=SBA.strMainID ".
		"WHERE ".		
		"SBA.strMainID =  '$mainStoreID' AND ".
		"SBA.strSubID =  '$subStoreID' AND ".	
		"SBA.intSubCatNo =  '$subCatID' AND ".
		"SBA.intStatus =  '1' ".
		"GROUP BY ".
		"SBA.strMainID, ".
		"SBA.strSubID, ".
		"SBA.strLocID, ".
		"SBA.strBinID, ".
		"SBA.intSubCatNo;";
//echo $sql;
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>
<tr class="bcgcolor-tblrowWhite">
<td class="normalfntRite"><?php echo $row["BalQty"];?></td>
<td class="normalfntRite"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="8" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0" /></td>
<td class="normalfnt"><div align="center"><input type="checkbox" name="checkbox" id="checkbox" onclick="GetStockQty(this);"></div></td>
<td class="normalfntSM" style="text-align:center" id="<?php echo $row["strBinID"];?>" ><?php echo $row["strBinName"];?></td>
<td class="normalfntSM" style="text-align:center" id="<?php echo $row["strLocID"];?>"><?php echo $row["strLocName"];?></td>
<td class="normalfntSM" style="text-align:center" id="<?php echo $row["strMainID"];?>"><?php echo $row["strName"];?></td>
<td class="normalfntSM" style="text-align:center" id="<?php echo $row["strSubID"];?>"><?php echo $row["strSubStoresName"];?></td>
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
              <td height="32"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr bgcolor="#D6E7F5">
                  <td width="28%"></td>
                  <!--<td width="18%"><img src="../../images/ok.png" alt="ok" width="86" height="24" onclick="SetBinItemQuantity('<?php echo $styleId;?>','<?php echo $index;?>');"></td>-->
                  <td width="18%"><img src="../../images/ok.png" alt="ok" width="86" height="24" onclick="SetBinItemQty(this);"></td>
                  <td width="6%">&nbsp;</td>
                  <td width="20%"><img src="../../images/close.png" width="97" height="24" onclick="closeWindow();" /></td>
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
