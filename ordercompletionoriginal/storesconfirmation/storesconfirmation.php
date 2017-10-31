<?php
session_start();
$backwardseperator = "../../";
session_start();
include "../../authentication.inc";
include "../../Connector.php";	
$companyId=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stores Confirmation</title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="storesconfirmation.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="../../javascript/jquery.js"></script>
<script src="../../javascript/styleNoOrderNoLoading.js" type="text/javascript"></script>
</head>

<body onload="loadOrderDetails(<?php echo $_GET["StyleNo"];?>);">

<?php
$StyleNo=$_GET["StyleNo"];
?>
<tr>
	<td><?php include '../../Header.php'; ?></td>
</tr>
<table width="950" border="0" align="center" class="bcgl1">
    <tr>
      <td>
		<table width="100%" border="0">
        	<tr>
          		<td bgcolor="#316895">
					<div align="center" class="mainHeading">Stores Confirmation </div>
				</td>
        	</tr>
        	<tr>
          		<td>
					<table width="100%"  border="0" align="center" bgcolor="#FFFFFF">
    					<tr>
    						<td>
        						<table  width="100%" border="0">
            						<tr>
                						<td>
                    						<table width="100%" border="0" class="">
											<tr>	
												<td>
													<table>
														<tr>
															<td width="87" class="normalfnt">Main Stores</td>
														  <td width="191">
															<select name="cboMainStores" class="txtbox" id="cboMainStores" style="width:150px" onchange="LoadSubStores();" title="">
																<?php
																	
																	$sqlstores="select strMainID,strName from mainstores where intStatus=1 AND intCompanyId=$companyId";
																	$result_stores=$db->RunQuery($sqlstores);
																		
																		echo "<option value=\"".""."\">"."Select Main Store"."</option>";
																		
																	while($rowstores=mysql_fetch_array($result_stores))
																	{
																		echo "<option value =\"".$rowstores["strMainID"]."\">".$rowstores["strName"]."</option>";
																	}
																?>
															</select>
														  </td>
                                                                <td width="13">&nbsp;</td>
																<td class="normalfnt">Sub Stores</td>
															<td>
															<select name="cboSubStores" class="txtbox" id="cboSubStores" style="width:150px"></select>
														  </td>
                                                                <td width="60">&nbsp;</td>
																<td width="197">&nbsp;</td>

    
													  </tr>
														<tr>
															<td width="87" class="normalfnt">Style</td>
                                                                 <td width="191"><select name="cboStyles" id="cboStyles" style="width:150px;" onchange="ClearTable('tblMain');getStylewiseOrderNoNew('StoresConfirmGetStylewiseOrderNo',this.value,'cboOrderNo');getScNo('StoresConfirmgetStyleWiseSCNum','cboSCNO');">
                                                                 <?php 
													$sql = "select distinct o.strStyle from orders o inner join stocktransactions st on
o.intStyleId = st.intStyleId  inner join mainstores ms on ms.strMainID= st.strMainStoresID
where o.intStatus=13 and ms.intCompanyId='$companyId' ";
		
		$result=$db->RunQuery($sql);
							echo "<option value=\"".""."\">".""."</option>";
																		
							while($row=mysql_fetch_array($result))
							{
								echo "<option value =\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
							}
																 ?>
                                                                 </select>
                                                          </td>
                                                                <td>&nbsp;</td>
<td width="93" class="normalfnt">Order No</td>
                                                                 <td width="212"><select name="cboOrderNo" id="cboOrderNo" style="width:150px;" onchange="getSC('cboSCNO','cboOrderNo');getStyleNoFromSC('cboSCNO','cboOrderNo');loadOrderDetails();">
                                                                 <?php 
													$sql = "select distinct o.intStyleId, o.strOrderNo from orders o inner join stocktransactions st on
o.intStyleId = st.intStyleId  inner join mainstores ms on ms.strMainID= st.strMainStoresID
where o.intStatus=13 and ms.intCompanyId='$companyId' ";
		
		$result=$db->RunQuery($sql);
							echo "<option value=\"".""."\">".""."</option>";
																		
							while($row=mysql_fetch_array($result))
							{
								echo "<option value =\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
							}
																 ?>
                                                                 </select>
          </td>
<td width="60" class="normalfnt">SC No</td>
<td width="197"><select name="cboSCNO" id="cboSCNO" style="width:150px;" onchange="getStyleNoFromSC('cboSCNO','cboOrderNo');loadOrderDetails();">
                                                                 <?php 
									$sql = "SELECT DISTINCT
											o.intStyleId,
											specification.intSRNO
											FROM
											orders AS o
											Inner Join stocktransactions AS st ON o.intStyleId = st.intStyleId
											Inner Join mainstores AS ms ON ms.strMainID = st.strMainStoresID
											Inner Join specification ON o.intStyleId = specification.intStyleId
											where o.intStatus=13 and ms.intCompanyId='$companyId' ";
		
		                    $result=$db->RunQuery($sql);
							echo "<option value=\"".""."\">".""."</option>";
																		
							while($row=mysql_fetch_array($result))
							{
								echo "<option value =\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
							}
																 ?>
                                                                 </select>
                                                          </td>
													  </tr>
													</table>
												</td>
											</tr>
                            					<tr>
                            						<td>
														<div style="overflow:scroll;height:320px; width:950px;">
														<table align="center" width="1200" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblMain">
										  					<thead>
																<tr class="mainHeading4">
																  <td  height="25" title="Style">Order No</td>
																  <td >Buyer PO </td>
																  <td >Material Desc</td>
																  <td  height="25">Color</td>
																  <td  height="25">Size</td>
																  <td  height="25">Unit</td>
																  <td >Qty </td>
																  <td >Dispose </td>
																  <td >Dispose Qty</td>
																  <td >Balance Qty</td>
																  <td  height="25"></td>
																  <td height="25">BIN</td>
																  <td >Main Stores</td>
																  <td >Sub Stores </td>
																  <td >Location</td>
																  
																  <td  height="25">GRN No</td>
																  <td  height="25">GRN Type</td>
																</tr>
										  					</thead>
										  					<tbody>
															<?php																		
$SQL = "SELECT
st.strBuyerPoNo,
st.strColor,
st.strSize,
st.strUnit,
storeslocations.strLocName,
storesbins.strBinName,
substores.strSubStoresName,
mainstores.strName,
matitemlist.strItemDescription,
concat(st.intGrnYear,'/',st.intGrnNo) AS GRN,
orders.strOrderNo,
st.intStyleId,
Sum(st.dblQty) AS QTY,
st.strBin,
st.strLocation,
st.strSubStores,
st.strMainStoresID,
matitemlist.intSubCatID,
matitemlist.intItemSerial
FROM
stocktransactions AS st
Inner Join storeslocations ON storeslocations.strLocID = st.strLocation
Inner Join storesbins ON storesbins.strBinID = st.strBin
Inner Join substores ON substores.strSubID = st.strSubStores
Inner Join mainstores ON st.strMainStoresID = mainstores.strMainID
Inner Join matitemlist ON st.intMatDetailId = matitemlist.intItemSerial
Inner Join orders ON st.intStyleId = orders.intStyleId
WHERE ";
$SQL .= " st.intStyleId='$StyleNo' and ";
$SQL .= " mainstores.intCompanyId ='$companyId' and  ";
$SQL .= "st.strType <> 'LeftOver' and st.strType <> 'Dispose'";
$SQL .="group by 
st.strBuyerPoNo,
st.strColor,
st.strSize,
storeslocations.strLocName,
storesbins.strBinName,
substores.strSubStoresName,
mainstores.strName,
st.intMatDetailId,
st.intGrnNo,
st.intGrnYear,
st.intStyleId 
having QTY > 0;";
																		
																		$loop=0;
														while($row =mysql_fetch_array($result))
														{
														$loop++;
														$disposedQty=0;
														$balQty=$row["AvQty"]-$disposedQty;
															?>
															<tr>
															  <td  bgcolor="#FFFFFF" class="normalfnt" id="<?php echo $row['intStyleId'];?>"><?php echo $row["strOrderNo"]; ?></td>
															  <td  bgcolor="#FFFFFF" class="normalfnt" id="" title=""><?php  echo $row["strBuyerPoNo"];?>  </td>
															  <td bgcolor="#FFFFFF" class="normalfnt" id="<?php echo $row['intItemSerial'];?>"> <?php echo $row["strItemDescription"]; ?> </td>
															  <td bgcolor="#FFFFFF" class="normalfnt"><?php echo $row["strColor"]; ?></td>
															  <td bgcolor="#FFFFFF" class="normalfnt"><?php echo $row["strSize"]; ?></td>
															  <td bgcolor="#FFFFFF" class="normalfnt"><?php echo $row["strUnit"]; ?></td>
															  <td bgcolor="#FFFFFF" class="normalfntRite"><?php echo $row["QTY"]; ?></td>
															  <td bgcolor="#FFFFFF" class="normalfnt"><div align="center"><input onClick="setQty(this);" type="checkbox" name="chkDispose" id="chkDispose" ></div></td> 
															  <td bgcolor="#FFFFFF" class="normalfntRite"><input type="text" name="txtdisposeQty" id="txtdisposeQty" class="txtboxRightAllign" size="10" value="0" onKeyUp="setBalance(this);" onKeyPress="return CheckforValidDecimal(this.value,4,event);" style="text-align:right;"  /></td>
															  <td bgcolor="#FFFFFF" class="normalfntRite"></td>
															  <td bgcolor="#FFFFFF" class="normalfnt" id="<?php echo $row["strBinName"]; ?>"> 
															  <img height="20" src="../../images/location.png" onclick="ValidatePopUpItems(this,<?php echo $row['intSubCatID'];?>,<?php echo $loop ;?>);" />
														
															  </td>
															  <td bgcolor="#FFFFFF" class="normalfnt" id="<?php echo $row["strBin"];?>"> <?php echo $row["strBinName"]; ?></td>
															  <td bgcolor="#FFFFFF" class="normalfnt" id="<?php echo $row["strMainStoresID"];?>"><?php echo $row["strName"]; ?></td>
															  <td bgcolor="#FFFFFF" class="normalfnt" id="<?php echo $row["strSubStores"];?>"><?php echo $row["strSubStoresName"]; ?></td>
															  <td bgcolor="#FFFFFF" class="normalfnt" id="<?php echo $row["strLocation"];?>"><?php echo $row["strLocName"]; ?></td>
															  
															  <td bgcolor="#FFFFFF" class="normalfnt"><?php echo $row["GRN"]; ?></td>
															</tr>
											<?php 
										}
											?>
													</tbody>
										  				</table>
										  				</div>
													</td>
												</tr>
                             				</table>
										</td>
                           	 		</tr>
                            		<tr>
										<!--<td align="center"> <img src="../../images/save.png" onclick="saveDisposedAndLeft();" /> </td>-->
                                        <td align="center"> <img src="../../images/save.png" onclick="saveDisposedAndLeftOverData();" /> </td>
									</tr>
                         		</table>
                    		</td>
                		</tr>
            		</table>
         		</td>
     		</tr>
		</table>
	  </td>
	</tr>
</table>
</body>
</html>