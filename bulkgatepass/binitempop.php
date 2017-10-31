<?php
	session_start();
	$backwardseperator = "../";
	include "../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	include "../authentication.inc";
	
	$matDetailId 	= $_GET["matDetailId"];
	$color 			= $_GET["color"];
	$size 		 	= $_GET["size"];
	$itemUnit 	 	= $_GET["itemUnit"];
	$grnNo 		 	= $_GET["grnNo"];
	$grnYear 	 	= $_GET["grnYear"];
	$ReqGatePassQty = $_GET["ReqGatePassQty"];
	$mainStId		= $_GET["mainStId"];
	$index			= $_GET["index"];
	
	$arrayDetails	= $_GET["binArray"];
	$binArray		= explode(',',$arrayDetails);
	$MainStores		= $binArray[0];
	$SubStores		= $binArray[1];
	$Location		= $binArray[2];
	$BinID			= $binArray[3];
	$IssueQty		= $binArray[4];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
</head>
<body>
<table width="600" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
            <tr>
              <td height="16" class="mainHeading">Bin Items</td>
            </tr>
            <tr>
             <td height="17"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
                  <tr>
                    <td width="4%" height="25">&nbsp;</td>
                    <td width="23%" class="normalfnt">GatePass Qty</td>
                    <td width="55%"><input name="txReqGatePassQty" type="text" class="txtbox" id="txReqGatePassQty" size="31" value="<?php echo $ReqGatePassQty; ?>" readonly="" style="text-align:right" /></td>
                    <td width="18%">&nbsp;</td>
                  </tr>
              </table>
			  </td>
            </tr>
			<tr>
              <td height="74"><table width="100%" height="141" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%" height="141"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td colspan="3">
					<div id="divGatePassBinItem" style="overflow:scroll; height:217px; width:604px;" class="tableBorder">
					<table id="tblGatePassBinItem" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
						<tr class="mainHeading4">
						  <td width="25%" height="25" c >Main Stores</td>
						  <td width="20%" >Sub Stores</td>
						  <td width="20%"  >Location</td>
						  <td width="15%"  >Bin ID</td>
						  <td width="10%" >AVI Qty</td>
						  <td width="8%"  >Req Qty</td>
						  <td width="2%"  >Add</td>
                        </tr>
						<?php
						$sql_bin = "SELECT BST.strMainStoresID, 
									 MS.strName, 
									 BST.strSubStores, 
									 SS.strSubStoresName, 
									 BST.strLocation, 
									 SL.strLocName, 
									 BST.strBin, 
									 SB.strBinName, 
									 MIL.intSubCatID, 
									 Sum(BST.dblQty) AS stockBal 
									 FROM stocktransactions_bulk AS BST 
									 Inner Join mainstores AS MS ON MS.strMainID = BST.strMainStoresID  
									 Inner Join substores SS on SS.strSubID=BST.strSubStores and SS.strMainID=BST.strMainStoresID 
									 Inner Join storeslocations SL on SL.strLocID=BST.strLocation and SL.strMainID=BST.strMainStoresID and SL.strSubID=BST.strSubStores 
									 Inner Join storesbins SB On SB.strBinID=BST.strBin and SB.strMainID=BST.strMainStoresID and SB.strSubID=BST.strSubStores and SB.strLocID=BST.strLocation 
									 Inner Join matitemlist MIL on MIL.intItemSerial=BST.intMatDetailId 
									 WHERE BST.intMatDetailId ='$matDetailId'
									 and BST.strColor =  '$color' 
									 and BST.strSize =  '$size'
									 and MS.strMainID ='$mainStId' 
									 and MS.intStatus =1 
									 and BST.intBulkGrnYear =  '$grnYear' 
									 and BST.intBulkGrnNo =  '$grnNo'
									 GROUP BY BST.strMainStoresID,BST.strSubStores,BST.strLocation,BST.strBin";
									$result_bin=$db->RunQuery($sql_bin);	
						while ($row=mysql_fetch_array($result_bin))
						{
						?>
						<tr class="bcgcolor-tblrowWhite">
						  <td width="25%" height="25" class="normalfnt" id="<?php echo $row["strMainStoresID"]; ?>" ><?php echo $row["strName"]; ?></td>
						  <td width="20%" class="normalfnt" id="<?php echo $row["strSubStores"]; ?>"  ><?php echo $row["strSubStoresName"]; ?></td>
						  <td width="20%" class="normalfnt" id="<?php echo $row["strLocation"]; ?>" ><?php echo $row["strLocName"]; ?></td>
						  <td width="15%" class="normalfnt" id="<?php echo $row["strBin"]; ?>" ><?php echo $row["strBinName"]; ?></td>
						  <td width="10%" class="normalfnt" id="<?php echo $row["intSubCatID"]; ?>" ><?php echo $row["stockBal"]; ?></td>
						  <td width="8%" class="normalfnt" ><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="8" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0" /></td>
						  <td width="2%" class="normalfnt" ><div align="center"><input type="checkbox" onclick="GetStockQty(this);" id="checkBin" name="checkBin" />
						  </div></td>
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
			</table>
			</td>
			</tr>
			<tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableBorder">
				  <tr>
					<td align="center"><img src="../images/ok.png" alt="ok" width="86" height="24" onclick="SetBinItemQuantity(this,<?php echo $index; ?>);"/><img src="../images/close.png" width="97" height="24" onclick="CloseOSPopUp('popupLayer1');" /></td>
                  </tr>
				  </table>
				  <tr >
					<td colspan="5"><div id="divGatePassBinItemArray" style="overflow:scroll; height:105px; width:600px;" class="tableBorder">
					<table id="divGatePassBinItemArray" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
						<tr class="mainHeading4">
						  <td width="25%" height="25" >Main Stores</td>
						  <td width="20%"  >Sub Stores</td>
						  <td width="20%"  >Location</td>
						  <td width="15%" >Bin ID</td>
						  <td width="10%" >Allocated Qty</td>
                        </tr>
						<?php
						if($arrayDetails!="undefined" )
						{
							$sql = "SELECT distinct
									MS.strName, 
									SS.strSubStoresName, 
									SL.strLocName, 
									SB.strBinName
									FROM stocktransactions_bulk AS BST 
									Inner Join mainstores AS MS ON MS.strMainID = BST.strMainStoresID  
									Inner Join substores SS on SS.strSubID=BST.strSubStores and SS.strMainID=BST.strMainStoresID 
									Inner Join storeslocations SL on SL.strLocID=BST.strLocation and SL.strMainID=BST.strMainStoresID and SL.strSubID=BST.strSubStores 
									Inner Join storesbins SB On SB.strBinID=BST.strBin and SB.strMainID=BST.strMainStoresID and SB.strSubID=BST.strSubStores and SB.strLocID=BST.strLocation 
									Inner Join matitemlist MIL on MIL.intItemSerial=BST.intMatDetailId 
									where BST.strMainStoresID='$MainStores'
									and BST.strSubStores='$SubStores'
									and  BST.strLocation='$Location'
									and BST.strBin='$BinID'";
									$result = $result_bin=$db->RunQuery($sql);	
						while ($row=mysql_fetch_array($result))
						{
					
						?>
						<tr class="bcgcolor-tblrowWhite">
						  <td width="25%" height="25" class="normalfnt"><?php echo $row["strName"]; ?></td>
						  <td width="20%" class="normalfnt" ><?php echo $row["strSubStoresName"]; ?></td>
						  <td width="20%" class="normalfnt" ><?php echo $row["strLocName"]; ?></td>
						  <td width="15%" class="normalfnt" ><?php echo $row["strBinName"]; ?></td>
						  <td width="10%" class="normalfnt" ><?php echo $IssueQty; ?></td>
                        </tr>
						<?php
						}
							
						}
						?>
				</table>
				</div>
				</td>
				
			</tr>
			</table>
			
			
</body>
</html>
