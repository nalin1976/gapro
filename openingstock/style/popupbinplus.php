<?php
	session_start();
	include "../../Connector.php";		
	$backwardseperator 	= "../";
	$CompanyId			= $_SESSION["FactoryID"];
	$UserId 			= $_SESSION["UserID"];
	$mainStoreID		= $_GET["MainStore"];
	$subStoreID			= $_GET["SubStore"];
	$matDetailID		= $_GET["MatId"];	
	$adjustQty			= $_GET["AdjustQty"];
	$adjestM			= $_GET["AdjestM"];
	$styleId			= "";
	$subCatID			= GetSubCatId($matDetailID);
	$GrnNo				= 1;
	$GrnYear			= date('Y');
	$strColor			= "";
	$strSize			= "";
	
	$sqlColor = "SELECT DISTINCT
materialratio.strMatDetailID,
materialratio.strColor
FROM
materialratio
WHERE
materialratio.strMatDetailID ='$matDetailID'";
	$resultColor = $db->RunQuery($sqlColor);
	$strColor.="<option value=\"". "" ."\">".""."</option>\n";
	while($rowColor=mysql_fetch_array($resultColor))
	{
		$strColor.="<option value=\"". $rowColor["strColor"] ."\">".$rowColor["strColor"]."</option>\n";	
	}
	
	$sqlSize = "SELECT DISTINCT
materialratio.strMatDetailID,
materialratio.strSize
FROM
materialratio
WHERE
materialratio.strMatDetailID ='$matDetailID'";
	$resultSize = $db->RunQuery($sqlSize);
	$strSize.="<option value=\"". "" ."\">".""."</option>\n";
	while($rowSize=mysql_fetch_array($resultSize))
	{
		$strSize.="<option value=\"". $rowSize["strSize"] ."\">".$rowSize["strSize"]."</option>\n";	
	}
	$sqlOrder = "SELECT
orders.strOrderNo,
orders.intStyleId,
orders.intStatus
FROM orders
where orders.intStatus='11'
";
	$resultOrder = $db->RunQuery($sqlOrder);
	$strOrder.="<option value=\"". "" ."\">".""."</option>\n";
	while($rowOrder=mysql_fetch_array($resultOrder))
	{
		$strOrder.="<option value=\"". $rowOrder["intStyleId"] ."\">".$rowOrder["strOrderNo"]."</option>\n";	
	}
	
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
                          <div id="divtblGatePassLeftOverBinItem" style="overflow:scroll;height:200px; width:950px;">
                              <table id="tblLeftOverBinItem" width="1200" cellpadding="2" cellspacing="1" bgcolor="#CCCCFF">
                                <tr class="mainHeading2">
                                  <td height="15" colspan="14" >&nbsp;Left Over</td>
                                </tr>
                                <tr class="mainHeading4">
                                  <td width="82" height="25" >Available Qty</td>
                                  <td width="68" >Req Qty</td>
                                  <td width="40" >Add</td>
                                  <td width="150" >Bin</td>
                                  <td width="150" >Location</td>
                                  <td width="150" >Main Stores</td>
                                  <td width="150" >Sub Stores</td>
                                  <td width="112" >Order No</td>
                                  <td width="170" >Color</td>
                                  <td width="170" >Size</td>
                                  <td width="130" >Unit</td>
                                  <td width="120" >GRN No</td>
                                  <td width="120" >GRN Year</td>
                                  <td width="120" >GRN Type</td>
                           		</tr>
<?php
	
		$result = LoadPlusQty($mainStoreID,$subStoreID,$subCatID,$styleId,$GrnNo,$GrnYear);
	
	while($row=mysql_fetch_array($result))
	{
?> 
     	<tr class="bcgcolor-tblrowWhite">
		  <td class="normalfntRite"><?php echo round($row["BalQty"],0);?></td>
		  <td class="normalfntMid"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" style="text-align:right;width:80px" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onkeyup="validateQty(this);" value="0" /></td>
		  <td class="normalfntMid"><div align="center">
			  <input type="checkbox" name="checkbox" id="checkbox" onclick="GetStockQty(this);">
		  </div></td>
		  <td class="normalfntSM" id="<?php echo $row["binId"];?>"><?php echo $row["binName"];?></td>
		  <td class="normalfntSM" id="<?php echo $row["locId"];?>"><?php echo $row["locName"];?></td>
		  <td class="normalfntSM" id="<?php echo $row["mainSId"]?>"><?php echo $row["mainStoreName"];?></td>
		  <td class="normalfntSM" id="<?php echo $row["subSId"]?>" ><?php echo $row["subStoreName"];?></td>
		  <td class="normalfntSM" ><select name="cboColor" id="cboColor" class="txtbox" style="width:100%" >
          							<?php echo $strOrder; ?>
          							</select></td>
		  <td class="normalfntSM"  ><select name="cboColor" id="cboColor" class="txtbox" style="width:100%" >
          							<?php echo $strColor; ?>
          							</select></td>
		  <td class="normalfntSM"  ><select name="cboSize" id="cboSize" class="txtbox" style="width:100%" >
          							<?php echo $strSize; ?>
          							</select></td>
		  <td class="normalfntSM"  ><?php echo $row["unit"];?></td>
		  <td class="normalfntSM"  ><?php echo $GrnNo;?></td>
		  <td class="normalfntSM"  ><?php echo $GrnYear;?></td>
		  <td class="normalfntSM" id="S"  >Style</td>
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
                        <tr>
                        	<td>&nbsp;</td>
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
function LoadPlusQty($mainStoreID,$subStoreID,$subCatID,$styleId,$GrnNo,$GrnYear)
{
	global $db;
	$sql="SELECT
SBA.strMainID AS mainSId,
SBA.strSubID AS subSId,
SBA.strLocID AS locId,
SBA.strBinID AS binId,
SBA.intSubCatNo AS subCatId,
SBA.strUnit AS unit,
(sum(SBA.dblCapacityQty)-sum(SBA.dblFillQty)) AS BalQty,
SB.strBinName AS binName,
SL.strLocName AS locName,
MS.strName AS mainStoreName,
SS.strSubStoresName AS subStoreName
FROM
storesbinallocation AS SBA
Inner Join storesbins AS SB ON SBA.strBinID = SB.strBinID
Inner Join storeslocations AS SL ON SL.strLocID = SBA.strLocID
Inner Join mainstores AS MS ON MS.strMainID = SBA.strMainID
Inner Join substores AS SS ON SS.strSubID = SBA.strSubID
		WHERE 		
		SBA.strMainID =  '$mainStoreID' AND 
		SBA.strSubID =  '$subStoreID' AND 	
		SBA.intSubCatNo =  '$subCatID' AND 
		SBA.intStatus =  '1' 
		GROUP BY 
		SBA.strMainID, 
		SBA.strSubID, 
		SBA.strLocID, 
		SBA.strBinID, 
		SBA.intSubCatNo;";
		//echo $sql;
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