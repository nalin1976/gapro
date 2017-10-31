<?php
	session_start();
	$backwardseperator = "../";
	include "../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	
	$mainStoreID    = $_GET["mainStore"];
	$subStores 		= $_GET["subStore"];	
	$subCatID	    = $_GET["subCatId"];
	$ReqGatePassQty = $_GET["ReqGatePassQty"];
	$index			= $_GET["index"];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Bin Item</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
</head>
<body>
<table align="center" width="615" border="0" bgcolor="#FFFFFF" class="tableBorder">
            <tr>
              <td height="25" class="mainHeading">Bin Items</td>
            </tr>
           <tr>
              <td height="17"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                  <tr>
				<td width="10%" height="25">&nbsp;</td>
				<td width="18%" class="normalfnt">Req Qty</td>
				<td width="54%"><input name="txtReqQty" type="text" class="txtbox" value="<?php echo $ReqGatePassQty;  ?>" id="txtReqQty" size="31" readonly=""/></td>
				<td width="18%">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>			  
            <tr>
              <td height="74"><table width="100%" height="141" border="0" cellpadding="0" cellspacing="0" >
                  <tr >
                    <td width="100%" height="141"><table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td colspan="3"><div id="divGPTransferBinItem" style="overflow:scroll; height:208px; width:100%;">
                            <table id="tblGPTransferBinItem" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                              <tr class="mainHeading4">
                                <td width="103" height="25" >Main Stores</td>
                                <td width="100">Sub Stores</td>
                                <td width="96">Location</td>
                                <td width="91">Bin ID</td>
                                <td width="86">AVI Qty</td>
                                <td width="82" nowrap="nowrap">Req Qty</td>
                                <td width="33">Add</td>
                              </tr>
							  <?php
							  $SQL= "SELECT strMainID,
		 (select strName from mainstores MS where MS.strMainID=SBA.strMainID)AS mainStoreName, strSubID,
		 (select strSubStoresName from substores SS where SS.strSubID=SBA.strSubID AND SS.strMainID = SBA.strMainID)AS subStoreName, strLocID,
		 (select strLocName from storeslocations SL where SL.strLocID=SBA.strLocID AND SL.strMainID = SBA.strMainID AND SL.strSubID=SBA.strSubID)AS locationName, strBinID, 
		(select strBinName from storesbins SB where SB.strBinID=SBA.strBinID AND SB.strLocID=SBA.strLocID AND SB.strMainID = SBA.strMainID AND SB.strSubID=SBA.strSubID)AS binName, strUnit,intSubCatNo,
		 Sum(dblCapacityQty)-Sum(dblFillQty) as AvalableQty  
		FROM storesbinallocation AS SBA 
		WHERE SBA.intSubCatNo ='$subCatID' AND SBA.strMainID ='$mainStoreID' AND SBA.strSubID ='$subStores' 
		GROUP BY strMainID,strSubID,strLocID,strBinID,intSubCatNo";
				  $result=$db->RunQuery($SQL);
					
				while($row=mysql_fetch_array($result))
							{			
							  ?>
                              <tr class="bcgcolor-tblrowWhite">
                                <td width="103" nowrap="nowrap" class="normalfnt" id="<?php echo $row["strMainID"];  ?>"><?php echo $row["mainStoreName"];?></td>
                                <td width="100" nowrap="nowrap" class="normalfnt" id="<?php echo $row["strSubID"];  ?>"><?php echo $row["subStoreName"];?></td>
                                <td width="96" nowrap="nowrap" class="normalfnt" id="<?php echo $row["strLocID"];  ?>"><?php echo $row["locationName"];?></td>
                                <td width="91" nowrap="nowrap" class="normalfnt" id="<?php echo $row["strBinID"];  ?>"><?php echo $row["binName"];?></td>
                                <td width="86" nowrap="nowrap" class="normalfntRite" id="<?php echo $row["intSubCatNo"]; ?>"><?php echo round($row["AvalableQty"],2) ?></td>
                                <td width="82" nowrap="nowrap" class="normalfnt"><input type="text" name="txtIssueQty" id="txtIssueQty" class="txtbox" size="12" style="text-align:right" onkeypress="return CheckforValidDecimal(this.value, 4,event);" value="0" /></td>
                                <td width="33" nowrap="nowrap" class="normalfnt"><div align="center"><input type="checkbox" onclick="SetBinQty(this);" id="checkBin" name="checkBin" />
						  </div></td>
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
                  <td align="center"><img src="../images/ok.png" alt="ok" width="86" height="24" onclick="SetBinQuantityToArray(this,<?php echo $index; ?>);"/><img src="../images/close.png" width="97" height="24" onclick="CloseOSPopUp('popupLayer1');" /></td>
                </tr>
              </table></td>
            </tr>
          </table>
</body>
</html>