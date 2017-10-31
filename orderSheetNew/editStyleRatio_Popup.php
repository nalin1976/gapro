<?php
$backwardseperator = "../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Style Ratio</title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="editStyleRatio_Popup-js.js"></script>
<script type="text/javascript" src="../javascript/script.js"></script>

<script src="../javascript/jquery.js"></script>
<script src="../javascript/jquery-ui.js"></script>
<script>
function reloadPage(){
document.frmEditStyleRatio.submit();
}
</script>
<style type="text/css">
	.subCon_layout{
	width:960px; height:auto;
	border:1px solid;
	border-bottom-color:#550000;
	border-top-color:#550000;
	border-left-color:#550000;
	border-right-color:#550000;
	background-color:#FFFFFF;
	padding-right:15px;
	padding-top:10px;
	padding-left:30px;
	padding-right:30px;
	margin-top:20px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	-moz-border-radius-topright:10px;
	-moz-border-radius-topleft:10px;
	border-bottom:13px solid #550000;
	border-top:30px solid #550000;
}

.subcon_text {
	position:relative;
	top : -35px; left:-1px; width:100%; height:24px;
	text-align:center;
	font-size: 12px;
	font-family: Verdana;
	padding-top:4px;
	width:100%;
	color:#ffffff;
	text-align:center;
	font-weight:normal;
}
</style>


</head>
<?php
$strStyleID=$_POST["cboOrderNo"];
//$strStyleID=151;
?>
<body>

<?php include "../Connector.php"; ?>
<form name="frmEditStyleRatio" id="frmEditStyleRatio" action="editStyleRatio_Popup.php" method="post">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td width="954"><?php include $backwardseperator.'Header.php'; ?></td>
  </tr>
 </table> 
  <div>
	<div align="center">
		<div class="subCon_layout" style="padding-bottom:20px;">
			<div class="subcon_text">Sample Definition<span class="volu"></span></div>
	
	<table width="100%" border="0"  bgcolor="#FFFFFF">
	<tr>
		<td align="center">
		<table width="954" align="center" border="0" class="tableBorder">
		<tr><td align="right" colspan="5"><img src="images/closelabel.gif" onclick="CloseWindowStyleRatioPopup();" style="width:40px;"  class="mouseover"/></td></tr>

			<tr>
				<td>&nbsp;</td>
			</tr>
            <?php
		$SQL="SELECT orders.strOrderNo,orders.intStyleId, orders.intQty, orders.reaExPercentage, buyers.strName, specification.intSRNO, orders.strDescription, useraccounts.Name, orders.intCompanyID
FROM ((orders INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID) INNER JOIN specification ON orders.intStyleId = specification.intStyleId) INNER JOIN useraccounts ON orders.intUserID = useraccounts.intUserID
WHERE (((orders.intStyleId)='".$strStyleID."'));";
     // echo $SQL;
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{
			$intQty			= $row["intQty"];
			$buyerName		= $row["strName"];
			$intSRNO		= $row["intSRNO"];
			$strDescription	= $row["strDescription"];
			$usrnme			= $row["Name"];
			$intCompanyID	= $row["intCompanyID"];
			$exPercentage 	= $row["reaExPercentage"];
			$orderNo		= $row["strOrderNo"];
		}
		$exQty = $intQty + ($intQty * $exPercentage / 100);
			
			?>		
			<tr>
				<td>
				<table width="800" align="center" border="0" class="bcgl1">
					<tr>
		<?php
		$sql_style="select strStyle from orders where intStyleId='$strStyleID'";
		$result_style=$db->RunQuery($sql_style);
		$row_style = mysql_fetch_array($result_style);
		?>
						<td width="63" height="23" class="normalfnt">Style No</td>
						<td width="194" class="normalfnt"><select name="cboStyles" class="txtbox" style="width:155px" id="cboStyles" onchange="getStylewiseOrderNoNew();getScNo();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select distinct orders.strStyle from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by  orders.strStyle;";
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleName==  $row["strStyle"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	?>
                  </select>
</td>
					  	<td width="86" class="normalfnt">SC No</td>
						<td width="188" class="normalfnt"><select name="cboSR" class="txtbox" style="width:155px" id="cboSR" onchange="getStyleNo();">
                      <option value="Select One" selected="selected">Select One</option>
                      <?php
	
	$SQL = "select specification.intSRNO,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11";
	
	if($styleName != 'Select One' && $styleName != '')
		$SQL .= " and orders.strStyle='$styleName' ";
		
		$SQL .= " order by specification.intSRNO desc";
		
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($reqStyleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
                    </select>
</td>
	<td width="86" class="normalfnt">Order No</td>
						<td width="155" class="normalfnt"><select name="cboOrderNo" class="txtbox" style="width:155px" id="cboOrderNo" onchange="getStyleandSC();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId,orders.strOrderNo from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11";
	
	if($styleName != 'Select One' && $styleName != "")
		$SQL .= " where  orders.strStyle = '$styleName'";
		
		$SQL .= " order by strOrderNo ";	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($strStyleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                  </select>
</td>
					</tr>
					<tr><td></td></tr>
					<tr>
						<td class="normalfnt">Buyer Po </td>
						<td class="normalfnt">
						<select id="cboBuyerPO" name="cboBuyerPO" style="width:155px" onchange="loadRatios()">
  <?php
 	$sql = "select distinct strBuyerPONO from styleratio where intStyleId = '$strStyleID'";
 	$resultbpo = $db->RunQuery($sql); 	
	$buyerPO="#Main Ratio#";
	$loop=0;
	while($rowbpo = mysql_fetch_array($resultbpo))
	{
		$loop++;
		if($loop==0)
		$buyerPO=$rowbpo["strBuyerPONO"];
		
		echo "<option value=\"" . $rowbpo["strBuyerPONO"] ."\">" . $rowbpo["strBuyerPONO"]. "</option>";  
	}
	?>                        </select>
						
						
</td>
					  
<td class="normalfnt">Buyer</td>
						<td class="normalfnt"><input type="text" value="<?php echo $buyerName;?>" readonly="readonly" style="width: 152px;" class="txtbox" maxlength="10" />
</td>
					  	<td class="normalfnt">Merchandiser</td>
						<td class="normalfnt"><input type="text" value="<?php echo $usrnme;?>" readonly="readonly" style="width: 152px;" class="txtbox" maxlength="10" />
					</tr>

					<tr>
					  	<td class="normalfnt">Order Qty</td>
						<td class="normalfnt"><input type="text" value="<?php echo round($intQty,0);?>" readonly="readonly" style="width: 152px; text-align:right" class="txtbox" maxlength="10" />
						<td class="normalfnt">With Excess</td>
						<td class="normalfnt"><input type="text" value="<?php echo round($exQty,0); ?>" readonly="readonly" style="width: 152px; text-align:right" class="txtbox" maxlength="10" />
</td>
                        <td class="normalfnt">Wastage</td>
						<td class="normalfnt">
						<input id="txtWastageForAll" name="txtWastageForAll" type="text" class="txtbox" style="width: 152px;"maxlength="3" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onclick="this.reset"/>
						</td>
					</tr>
					<tr>
					<td colspan="6" align="right"><img src="../images/search.png" name="butSave" align="center" class="mouseover" id="butSave" onclick="reloadPage();"/>	</td>
					</tr>
				</table>

				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="center">
					<div id="divStyleRatio" style="overflow:scroll; height:200px; width:800px;" class="bcgl1">
						<table id="tblStyleRatio" class="thetable" border="0" cellpadding="0" cellspacing="0" >
						<caption>Style Ratio</caption>
										 		
        <tr >
          <th width="15%" class="normalfntBtab">Color/Size</th>
		  <?php
		  
		  $sqlsize = "select distinct strSize from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $buyerPO . "';";
		  $resultsize = $db->RunQuery($sqlsize); 	
		  	$loop = 0;
			while($rowsize = mysql_fetch_array($resultsize))
			{
				$sizearray[$loop] = $rowsize["strSize"]; 
		  ?>
          <th width="5%" class="normalfntBtab"><?php echo $rowsize["strSize"];  ?></th>
          <?php
		  	$loop ++;
		  	}
		  ?>
          <th width="5%" class="normalfntBtab">Total</th>
        </tr>
		<?php
		$sqlcolor = "select distinct strColor from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '". $buyerPO . "';";
		$resultcolor = $db->RunQuery($sqlcolor); 
			$loopRow=0;
		while($rowcolor = mysql_fetch_array($resultcolor))
		{
				$colorarray[$loop] = $rowcolor["strColor"]; 
			$rowtot = 0;
			$loopRow++;
		?>
		<tr>
		  <td class="normalfntTAB"><?php echo $rowcolor["strColor"];  ?></td>
		  <?php
				$loopColom=0;
		  	foreach ($sizearray as $size)
			{
					$loopColom++;
					   $sql="SELECT
styleratio.dblExQty,
sum(case when editedStyleRatio.intStatus ='1' then (editedStyleRatio.dblExQty) end)newExQty
FROM
styleratio
left Join editedStyleRatio ON styleratio.intStyleId = editedStyleRatio.intStyleId AND styleratio.strBuyerPONO = editedStyleRatio.strBuyerPONO AND styleratio.strColor = editedStyleRatio.strColor AND styleratio.strSize = editedStyleRatio.strSize
where styleratio.intStyleId = '$strStyleID' and styleratio.strBuyerPONO = '" . $buyerPO . "' and styleratio.strColor = '".$rowcolor["strColor"]."' and styleratio.strSize = '$size'  group by styleratio.intStyleId, styleratio.strBuyerPONO, styleratio.strColor, styleratio.strSize";
				///echo $sql = "select dblExQty from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $buyerPO . "' and strColor = '".$rowcolor["strColor"]."' and strSize = '$size';";
				$resultqty = $db->RunQuery($sql); 
				while($rowqty= mysql_fetch_array($resultqty))
				{
					$exQtyReal=0;
					$exQtyNew=0;
					$exQtyBal=0;
					
					$exQtyReal=	$rowqty["dblExQty"];
					$exQtyNew=	$rowqty["newExQty"];
					if($rowqty["newExQty"]==''){
					$exQtyNew=	0;
					}
					$exQtyReal=round($exQtyReal,0);
					$exQtyNew=round($exQtyNew,0);
					$exQtyBal=$exQtyReal-$exQtyNew;
					
		  ?>
			<td class="normalfntRiteTAB" id="<?php echo $exQtyBal; ?>" width="25"><input type="text" class="txtbox" value="<?php echo round($exQtyBal,0);  ?>" style="width:45px; text-align:right"  onkeypress="return isNumberKey(event);" onkeyup="compQty(<?php echo $loopRow ?>,<?php echo $loopColom ?>);" /></td>
			<?php
					$rowtot += $exQtyBal;
				}
			}
			?>
			<td class="normalfntMidTAB" width="25">&nbsp;<?php echo number_format($rowtot,0);  ?>&nbsp;</td>
		</tr>
		<?php
		}
		$sumtot = 0;
		?>
		<tr>
		  <td class="normalfntTAB">Total</td>
		  <?php
		$sqlSize = "select distinct strSize from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '". $buyerPO . "';";
		$resultcolor = $db->RunQuery($sqlSize); 
		$loopRow=0;
		
		$exQtyReal=0;
		$exQtyNew=0;
		$exQtyBal=0;

		while($rowsize = mysql_fetch_array($resultcolor))
		{
				   $sql = "SELECT
sum(styleratio.dblExQty) AS sizetotal1
FROM styleratio where styleratio.intStyleId = '$strStyleID' and styleratio.strBuyerPONO = '" . $buyerPO . "' and styleratio.strSize = '".$rowsize["strSize"]."' group by styleratio.intStyleId, styleratio.strBuyerPONO, styleratio.strSize";
				$resulttotqty = $db->RunQuery($sql); 
				$rowtotqty= mysql_fetch_array($resulttotqty);
					
					 $exQtyReal=	$rowtotqty["sizetotal1"];
					
					
$sql2="SELECT
Sum(editedStyleRatio.dblExQty) AS sizetotal2
FROM styleratio left Join editedStyleRatio ON styleratio.intStyleId = editedStyleRatio.intStyleId AND styleratio.strBuyerPONO = editedStyleRatio.strBuyerPONO AND styleratio.strColor = editedStyleRatio.strColor AND styleratio.strSize = editedStyleRatio.strSize
where styleratio.intStyleId = '$strStyleID' and styleratio.strBuyerPONO = '" . $buyerPO . "' and styleratio.strSize = '".$rowsize["strSize"]."' 
and editedStyleRatio.intStatus='1'  group by styleratio.intStyleId, styleratio.strBuyerPONO, styleratio.strSize";			
$resulttotqty = $db->RunQuery($sql2); 
$rowtotqty2= mysql_fetch_array($resulttotqty);
					$exQtyNew=	$rowtotqty2["sizetotal2"];
					
					
					
					if($rowtotqty2["sizetotal2"]==''){
					$exQtyNew=	0;
					}
					$exQtyReal=round($exQtyReal,0);
					$exQtyNew=round($exQtyNew,0);
					$sizeTot=$exQtyReal-$exQtyNew;
					$sumtot += $sizeTot;
		  ?>
		  <td class="normalfntRiteTAB" align="center" width="25"><?php echo number_format($sizeTot,0);?></td>
		  <?php
			  }
		  ?>
		  <td class="normalfntMidTAB" width="25"><?php echo "  ".number_format($sumtot,0)."  ";  ?></td>
	    </tr>
    </table></div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>

			 <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td bgcolor="" align="center" class="tableFooter">
                <table width="200" border="0" style="border:none;" >
                    <tr>
							<td><img src="../images/save.png" name="butClose" class="mouseover" id="butClose" onclick="saveEditedStyleRatio();" /></td>
							<td><img src="../images/report.png" name="butClose" class="mouseover" id="butClose" onclick="loadOrderNos();" /></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
		</table>
		</td>
	</tr>
</table>
<div style="left:750px; top:540px; z-index:10; position:absolute; width: 250px; visibility:hidden; height: 65px;" id="divLoadOrderNos">
  <table width="250" height="56" border="0" cellpadding="0" cellspacing="0" class="tablezRED">     
          <tr>
            <td colspan="3" bgcolor="#550000"  align="right"><img src="../images/cross.png" onClick="callClose()" alt="Close" name="Close" width="17" height="17" id="Close"/></td>
          </tr>
          <tr>
            <td width="120"><div align="center">Order No</div>&nbsp;</td>
<td>
                <select name="cboRatioOrderNos" class="txtbox" id="cboRatioOrderNos" style="width:120px">
			<option value="">select</option>
                <?php
			$sql_query 	="SELECT distinct intOrderNo
						 FROM `editedStyleRatio` where intStyleId='$strStyleID' AND intStatus = '1' order by intOrderNo DESC ";
			
			$result =$db->RunQuery($sql_query);
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intOrderNo"]."\">".$row["intOrderNo"]."</option>";
			}
				?>
                </select></td>
            <td><img src="../images/go.png" alt="editedReport" width="30" height="22" vspace="3" class="mouseover" onclick="loadRatioEditedReport();" /></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td ></td>
          </tr>
  </table>

</div>
</div>
</div>

</form>
</body>
</html>
