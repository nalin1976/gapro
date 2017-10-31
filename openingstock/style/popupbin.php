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
                              <table id="tblLeftOverBinItem" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                                <tr class="mainHeading2">
                                  <td height="15" colspan="14" >&nbsp;Left Over</td>
                                </tr>
                                <tr class="mainHeading4">
                                  <td width="82" height="25" >Available Qty</td>
                                  <td width="68" >Req Qty</td>
                                  <td width="22" >Add</td>
                                  <td width="101" >Bin</td>
                                  <td width="123" >Location</td>
                                  <td width="132" >Main Stores</td>
                                  <td width="112" >Sub Stores</td>
                                  <td width="112" >Order No</td>
                                  <td width="112" >Color</td>
                                  <td width="112" >Size</td>
                                  <td width="112" >Unit</td>
                                  <td width="112" >GRN No</td>
                                  <td width="112" >GRN Year</td>
                                  <td width="112" >GRN Type</td>
                           		</tr>
<?php
	if($adjestM=='+')
		$result = LoadPlusQty($mainStoreID,$subStoreID,$subCatID);
	else
		$result = LoadMiLeftOverQty($mainStoreID,$subStoreID,$matDetailID);
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
		  <td class="normalfntSM" id="<?php echo $row["StyleId"]?>" ><?php echo $row["OrderNo"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["Color"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["Size"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["Unit"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["GrnNo"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["GrnYear"];?></td>
		  <td class="normalfntSM" id="<?php echo $row["GRNType"];?>"  ><?php echo ($row["GRNType"]=='B'?"Bulk":"Style");?></td>
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
                        <tr>
                          <td colspan="3"><table width="100%" border="0" class="tableBorder" >
                          <tr>
                          <td>
                          <div id="divtblGatePassBulkBinItem" style="overflow:scroll; height:150px;width:950px;">
                              <table id="tblBulkBinItem" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                                <tr class="mainHeading2">
                                  <td height="15" colspan="12" >&nbsp;Bulk</td>
                                </tr>
                                <tr class="mainHeading4">
                                  <td width="82" height="25" >Available Qty</td>
                                  <td width="68" >Req Qty</td>
                                  <td width="22" >Add</td>
                                  <td width="101" >Bin</td>
                                  <td width="123" >Location</td>
                                  <td width="132" >Main Stores</td>
                                  <td width="112" >Sub Stores</td>
                                  <td width="112" >Color</td>
                                  <td width="112" >Size</td>
                                  <td width="112" >Unit</td>
                                  <td width="112" >BulkGRN No</td>
                                  <td width="112" >BulkGRN Year</td>
                                </tr>
<?php
	if($adjestM=='+')
		$result = LoadPlusQty($mainStoreID,$subStoreID,$subCatID);
	else
		$result = LoadMiBulkQty($mainStoreID,$subStoreID,$matDetailID);
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
		  <td class="normalfntSM"  ><?php echo $row["Color"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["Size"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["Unit"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["GrnNo"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["GrnYear"];?></td>
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
                        <tr>
                          <td colspan="3"><table width="100%" border="0" class="tableBorder" >
                          <tr>
                          <td>
                          <div id="divtblGatePassRunningBinItem" style="overflow:scroll;height:150px; width:950px;">
                              <table id="tblRunningBinItem" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                                <tr class="mainHeading2">
                                  <td height="15" colspan="14" >&nbsp;Running</td>
                                </tr>
                                <tr class="mainHeading4">
                                  <td width="82" height="25" >Available Qty</td>
                                  <td width="68" >Req Qty</td>
                                  <td width="22" >Add</td>
                                  <td width="101" >Bin</td>
                                  <td width="123" >Location</td>
                                  <td width="132" >Main Stores</td>
                                  <td width="112" >Sub Stores</td>
                                  <td width="112" >Order No</td>
                                  <td width="112" >Color</td>
                                  <td width="112" >Size</td>
                                  <td width="112" >Unit</td>
                                  <td width="112" >GRN No</td>
                                  <td width="112" >GRN Year</td>
                                  <td width="112" >GRN Type</td>
                           		</tr>
<?php
	if($adjestM=='+')
		$result = LoadPlusQty($mainStoreID,$subStoreID,$subCatID);
	else
		$result = LoadMiRunningQty($mainStoreID,$subStoreID,$matDetailID);
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
		  <td class="normalfntSM" id="<?php echo $row["StyleId"]?>" ><?php echo $row["OrderNo"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["Color"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["Size"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["Unit"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["GrnNo"];?></td>
		  <td class="normalfntSM"  ><?php echo $row["GrnYear"];?></td>
		   <td class="normalfntSM" id="<?php echo $row["GRNType"];?>"  ><?php echo ($row["GRNType"]=='B'?"Bulk":"Style");?></td>
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
function LoadPlusQty($mainStoreID,$subStoreID,$subCatID)
{
global $db;
	$sql="SELECT 
		SBA.strMainID as mainSId, 
		SBA.strSubID as subSId, 
		SBA.strLocID as locId, 
		SBA.strBinID as binId, 
		SBA.intSubCatNo as subCatId, 		
		SBA.strUnit as unit, 		
		(sum(SBA.dblCapacityQty)-sum(SBA.dblFillQty))as BalQty, 
		SB.strBinName as binName, 
		SL.strLocName as locName, 
		MS.strName as mainStoreName, 
		SS.strSubStoresName  as subStoreName
		FROM 
		storesbinallocation AS SBA 
		Inner Join storesbins AS SB ON SBA.strBinID = SB.strBinID 
		Inner Join storeslocations AS SL ON SL.strLocID = SBA.strLocID 
		Inner Join mainstores MS ON MS.strMainID=SBA.strMainID 
		Inner Join substores SS ON SS.strSubID=SBA.strSubID
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
		//echo  $sql;
	return $db->RunQuery($sql);
}

function LoadMiLeftOverQty($mainStoreID,$subStoreID,$matDetailID)
{
	global $db;
	
	$sql = "SELECT 
			round(Sum(STL.dblQty),2) - coalesce((select round(sum(CLD.dblQty),2)as A from commonstock_leftoverdetails CLD
inner join commonstock_leftoverheader CLH on CLH.intTransferNo=CLD.intTransferNo and CLH.intTransferYear=CLD.intTransferYear
where CLD.intMatDetailId=STL.intMatDetailId and CLH.intMainStoresId=STL.strMainStoresID and CLD.intFromStyleId=STL.intStyleId and CLD.strColor=STL.strColor and CLD.strSize=STL.strSize and CLD.intGrnNo=STL.intGrnNo and CLD.intGrnYear=STL.intGrnYear and CLD.strGRNType=STL.strGRNType and CLH.intStatus=0 
group by CLD.intMatDetailId,CLH.intMainStoresId),0) AS BalQty,
			STL.strMainStoresID as mainSId, 
			STL.strSubStores as subSId, 
			STL.strLocation as locId, 
			STL.strBin as binId, 
			STL.intStyleId as StyleId,
			STL.strColor as Color,
			STL.strSize as Size,
			STL.intGrnNo as GrnNo,
			STL.intGrnYear as GrnYear,
			STL.strGRNType as GRNType,
			STL.strUnit as Unit,
			O.strOrderNo as OrderNo,
			MS.strName as mainStoreName, 
			SL.strLocName as locName, 
			SB.strBinName as binName, 
			SS.strSubStoresName  as subStoreName 
			FROM 
			stocktransactions_leftover AS STL 
			inner join mainstores MS on MS.strMainID=STL.strMainStoresID 
			inner join substores SS on SS.strSubID=STL.strSubStores 
			Inner Join storeslocations AS SL ON SL.strLocID = STL.strLocation 
			Inner Join storesbins AS SB ON STL.strBin = SB.strBinID 
			Inner Join orders AS O ON STL.intStyleId = O.intStyleId 
			WHERE 
			STL.intMatDetailId = '$matDetailID' and
			STL.strMainStoresID ='$mainStoreID' and
			STL.strSubStores ='$subStoreID'
			GROUP BY 
			STL.strMainStoresID, 
			STL.strSubStores, 
			STL.strLocation, 
			STL.strBin, 
			STL.intStyleId, 
			STL.strColor, 
			STL.intMatDetailId, 
			STL.strSize, 
			STL.intGrnNo,
			STL.intGrnYear,
			STL.strGRNType -- ,STL.strUnit
			having BalQty>0
			order by STL.intGrnYear,STL.intGrnNo";
	return $db->RunQuery($sql);
}
function LoadMiBulkQty($mainStoreID,$subStoreID,$matDetailID)
{
	global $db;
	
	$sql = "SELECT 
		round(Sum(STB.dblQty),2) - coalesce((select round(sum(CBD.dblQty),2)as A from commonstock_bulkdetails CBD 
inner join commonstock_bulkheader CBH on CBH.intTransferNo=CBD.intTransferNo and CBH.intTransferYear=CBD.intTransferYear
where CBD.intMatDetailId=STB.intMatDetailId and CBH.intMainStoresId=STB.strMainStoresID and CBD.strColor=STB.strColor and CBD.strSize=STB.strSize and CBD.intBulkGrnNo=STB.intBulkGrnNo and CBD.intBulkGRNYear=STB.intBulkGrnYear and CBH.intStatus=0 
group by CBD.intMatDetailId,CBH.intMainStoresId),0) AS BalQty,
		STB.strMainStoresID as mainSId, 
		STB.strSubStores as subSId, 
		STB.strLocation as locId, 
		STB.strBin as binId, 
		STB.strColor as Color,
		STB.strSize as Size,
		STB.intBulkGrnNo as GrnNo,
		STB.intBulkGrnYear as GrnYear,
		STB.strUnit as Unit,
		MS.strName as mainStoreName, 
		SL.strLocName as locName, 
		SB.strBinName as binName, 
		SS.strSubStoresName  as subStoreName 
		FROM 
		stocktransactions_bulk AS STB
		inner join mainstores MS on MS.strMainID=STB.strMainStoresID 
		inner join substores SS on SS.strSubID=STB.strSubStores 
		Inner Join storeslocations AS SL ON SL.strLocID = STB.strLocation 
		Inner Join storesbins AS SB ON STB.strBin = SB.strBinID 
		WHERE 
		STB.intMatDetailId = '$matDetailID' and
		STB.strMainStoresID ='$mainStoreID' and  
		STB.strSubStores ='$subStoreID'
		GROUP BY 
		STB.strMainStoresID, 
		STB.strSubStores, 
		STB.strLocation, 
		STB.strBin, 
		STB.strColor, 
		STB.intMatDetailId, 
		STB.strSize, 
		STB.intBulkGrnNo,
		STB.intBulkGrnYear -- ,STB.strUnit
		having BalQty>0
		order by STB.intBulkGrnYear,STB.intBulkGrnNo";
	return $db->RunQuery($sql);
}
function LoadMiRunningQty($mainStoreID,$subStoreID,$matDetailID)
{
	global $db;
	
	$sql = "SELECT 
			round(Sum(ST.dblQty),2) AS BalQty,
			ST.strMainStoresID as mainSId, 
			ST.strSubStores as subSId, 
			ST.strLocation as locId, 
			ST.strBin as binId, 
			ST.intStyleId as StyleId,
			ST.strColor as Color,
			ST.strSize as Size,
			ST.strUnit as Unit,
			ST.intGrnNo as GrnNo,
			ST.intGrnYear as GrnYear,
			ST.strGRNType as GRNType,
			O.strOrderNo as OrderNo,
			MS.strName as mainStoreName, 
			SL.strLocName as locName, 
			SB.strBinName as binName, 
			SS.strSubStoresName  as subStoreName 
			FROM 
			stocktransactions AS ST
			inner join mainstores MS on MS.strMainID=ST.strMainStoresID 
			inner join substores SS on SS.strSubID=ST.strSubStores 
			Inner Join storeslocations AS SL ON SL.strLocID = ST.strLocation 
			Inner Join storesbins AS SB ON ST.strBin = SB.strBinID 
			Inner Join orders AS O ON ST.intStyleId = O.intStyleId 
			WHERE 
			ST.intMatDetailId = '$matDetailID' and
			ST.strMainStoresID ='$mainStoreID' and
			ST.strSubStores ='$subStoreID' 
			GROUP BY 
			ST.strMainStoresID, 
			ST.strSubStores, 
			ST.strLocation, 
			ST.strBin, 
			ST.intStyleId, 
			ST.strColor, 
			ST.intMatDetailId, 
			ST.strSize, 
			ST.intGrnNo,
			ST.intGrnYear,
			ST.strGRNType -- ,ST.strUnit
			having BalQty>0
			order by ST.intGrnYear,ST.intGrnNo";
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