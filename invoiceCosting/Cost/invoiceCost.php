<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Invoice Costing</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../js/jquery-ui-1.8.9.custom.css"/>

<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="invoiceCost-java.js?n=1" type="text/javascript"></script>
<style type="text/css">
<!--
.style1 {color: #00CC99}
-->
</style>
</head>

<body onload="loadInvoiceCostForm(
<?php 	
$id = $_GET["id"];
if($id!=0)
{
	$intStyleId = $_GET["intStyleId"] ;
	echo "'$id'" ; echo "," ; echo "'$intStyleId'" ; 
}
else
	echo "0,99";
?> );">

<form name="frminvcost" id="frminvcost">
<td><?php include '../../Header.php'; ?></td>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  
  <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="mainHeading">INVOICE COSTING</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="76"><table width="100%" border="0" class="tableBorder">
              <tr>
                <td width="9%" class="normalfnt">Style No</td>
                <td width="19%" class="normalfnt"><select name="cbointStyleId" id="cbointStyleId" class="txtbox" style="width:152px"  onchange="clearTable();loadOrderNo(this.value);">
                  <?php
                       $id = $_GET["id"];
					   if($id == 1){
					   $SQL = "SELECT distinct strStyle FROM orders
					           LEFT JOIN invoicecostingheader ON orders.intStyleId = invoicecostingheader.intStyleId
					           WHERE invoicecostingheader.intStyleId = '$intStyleId'";
					   }else{
						$SQL = "SELECT  distinct strStyle FROM orders WHERE orders.intStyleId  NOT IN (SELECT invoicecostingheader.intStyleId FROM invoicecostingheader) and intStatus=11 ORDER BY orders.strStyle";
							echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						}
				$result = $db->RunQuery($SQL);		
				
				
				while($row = mysql_fetch_array($result))
				{
				echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
				}
				
				?>
                </select></td>
                <td width="14%"  class="normalfnt">Order No</td>
                <td width="22%" class="normalfnt"><select name="strOrderNo" class="txtbox" id="strOrderNo" style="width:152px" onchange="loadCostHeader();">
                  <?php
					if($id == 1)
					{
						$SQL = "SELECT distinct orders.intStyleId,orders.strOrderNo FROM orders
					           LEFT JOIN invoicecostingheader ON orders.intStyleId = invoicecostingheader.intStyleId
					           WHERE invoicecostingheader.intStyleId = '$intStyleId' order by orders.strOrderNo ";
					}
					else
					{
						$SQL = "SELECT  distinct orders.intStyleId,orders.strOrderNo FROM orders WHERE orders.intStyleId  NOT IN (SELECT invoicecostingheader.intStyleId FROM invoicecostingheader) and intStatus=11 ORDER BY orders.strOrderNo";	
						 echo "<option value=\"".""."\">" .""."</option>";
					}
                        $result =$db->RunQuery($SQL);
                        while ($row=mysql_fetch_array($result))
                        {
                            echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
                        }
                
                    ?>
                </select>
                  &nbsp;<img src="../../images/search_1.png" id="popSearch" alt="search" width="16" height="16" onclick="OpenSearchPopUp();" /> </td>
                <td width="10%"  class="normalfnt">Fabric</td>
                <td width="26%"><input name="intFabric" type="text" class="txtbox" id="strFabric" style="width:220px" onfocus=""/></td>
              </tr>
              <tr>
                <td width="9%"  class="normalfnt">CM</td>
                <td width="19%" class="normalfnt"><input name="dblNewCM" type="text" class="txtbox" id="dblNewCM" style="width:150px;text-align:right;font:bold" onkeypress="return CheckforValidDecimal(this.value, 7,event);" maxlength="20" value="0"/></td>
                <td width="14%"  class="normalfnt">CM Reduced</td>
                <td width="22%" class="normalfnt"><input name="txtReduceCM" type="text" class="txtbox" id="txtReduceCM" style="width:150px;text-align:right" onkeypress="return CheckforValidDecimal(this.value, 7,event);" maxlength="20"/></td>
                <td  class="normalfnt">Remarks</td>
                <td rowspan="2"><textarea style="width:220px" name="strDescription" rows="2"  class="txtbox" id="strDescription" type="text"> </textarea></td>
              </tr>
              <tr class="normalfnt">
                <td height="22"  class="normalfnt">FOB</td>
                <td><input name="dblFob" type="text" class="txtbox" id="dblFob" style="width:150px;text-align:right" onkeypress="return CheckforValidDecimal(this.value, 7,event);" maxlength="20" disabled="disabled"/></td>
                <td  class="normalfnt">QTY</td>
                <td><input name="dblQty" type="text" class="txtbox" id="dblQty" style="width:150px;text-align:right" readonly=""/></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr >
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="mainHeading4">
        <td width="88%">Invoice Costing Details </td>
        <td width="12%"><img src="../../images/additem.png" alt="addItem" width="112" height="18" onclick="OpenItemPopUp();"/></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2"><div id="divcons2" style="overflow:scroll; height:470px; width:950px;">
          <table width="1000" cellpadding="0" cellspacing="1" id="tblMain" bgcolor="#C58B8B" class="bcgcolor">
            <tr class="mainHeading4">
              <td width="2%" >Edit</td>
              <td width="2%" >Del</td>
              <td nowrap="nowrap">Origin<br/>
                      <select name="cboOriginAll" class="txtbox" id="cboOriginAll" style="width:50px" onchange="ChangeAllOrigin(this);">
                        <option value="">Select One</option>
                        <?php
				
				$sql = "select intOriginNo,strOriginType from itempurchasetype where intStatus=1 order by strOriginType";
				$result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intOriginNo"] ."\">" . $row["strOriginType"] ."</option>" ;
				}
				?>
                      </select>              </td>
              <td width="50%" height="33" >Description</td>
              <td nowrap="nowrap">Con <br/>
                Per Doz</td>
              <td nowrap="nowrap">Waste</td>
              <td nowrap="nowrap">Unit Price </td>
              <td width="6%" >Value</td>
              <td nowrap="nowrap">Finance</td>
              <td width="6%" >Finance<br />
                Value </td>
              <td nowrap="nowrap">Type</td>
              <td nowrap="nowrap">Category</td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellspacing="2" cellpadding="0" >
      <tr>
        <td><table width="100%" border="0" cellspacing="2" cellpadding="0" class="tableFooter">
          <tr>
            <td width="47">&nbsp;</td>
            <td width="24" class="txtbox bcgcolor-InvoiceCostFabric" ></td>
            <td class="normalfnt" width="94">&nbsp;Fabric</td>
            <td width="24" class="txtbox bcgcolor-InvoiceCostPocketing">&nbsp;</td>
            <td width="94" class="normalfnt">&nbsp;Pocketing</td>
            <td width="24" class="txtbox bcgcolor-InvoiceCostNotPocketing">&nbsp;</td>
            <td width="94" class="normalfnt">&nbsp;Not Pocketing</td>
            <td width="24" class="txtbox bcgcolor-InvoiceCostTrim">&nbsp;</td>
            <td width="94" class="normalfnt">&nbsp;Trim</td>
            <td width="24" class="txtbox bcgcolor-InvoiceCostService">&nbsp;</td>
            <td width="94" class="normalfnt">&nbsp;Service</td>
            <td width="24" class="txtbox bcgcolor-InvoiceCostOther">&nbsp;</td>
            <td width="94" class="normalfnt">&nbsp;Other</td>
            <td width="24" class="txtbox bcgcolor-InvoiceCostICNA">&nbsp;</td>
            <td width="94" class="normalfnt">&nbsp;ICNA</td>
            <td width="59"><img src="../../images/aad.png" onclick="loadWashPrices();" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td ><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="tableFooter">
          <tr>
            <td><div align="center" > <a href="invoiceCost.php"> <img title="New" src="../../images/new.png" style="display:inline" alt="new" name="butNew" class="mouseover"  id="butNew" border="0"/></a> <img src="../../images/save.png" style="display:inline" title="Save" alt="save" name="butSave" class="mouseover" id="butSave" onclick="save();" /> <img src="../../images/send2app.png" style="display:none" title="Save" alt="save" name="butSendToApproval" class="mouseover" id="butSave" onclick="SendToApproval();" />
                        <?php 	if ($confirmInvoiceCosting)
        		{
        ?>
                        <img src="../../images/conform.png" style="display:inline" title="Confirm" alt="conform" name="butConform" width="115" height="24" class="mouseover" id="butConform" onclick="saveInvoiceCostConfirmedHeader();" />
                        <?php 
				}
		?>
                        <img src="../../images/copyPO.png" style="display:inline" title="Copy Po" alt="copy PO" id="butCopy"onclick="CopyPopUp();" /> <img src="../../images/porevise.png" style="display:none" title="PO Revise" name="butRevise" class="mouseover" id="butRevise"  onclick="RevisePO();"/> <img src="../../images/report.png" style="display:inline" title="Report" name="butReport" width="108" height="24" class="mouseover" id="butReport"  onclick="OpenReportPopUp(0);"/>
                        <!--<img src="../../images/print.png" style="display:inline" title="E-Mail" name="butMail"  id="butMail"  alt="Email" class="mouseover" onclick="OpenReportPopUp(1);"/>-->
                    <a href="../../main.php"><img style="display:inline" title="Close" src="../../images/close.png" width="97" height="24" border="0" /></a></div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>

<div style="left:345px; top:360px; z-index:10; position:absolute; width: 240px; visibility:hidden;" id="copyPOMain"><table width="221" height="58" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="69">&nbsp;</td>
            <td width="115">&nbsp;</td>
			<td width="1" class="normalfntRiteTAB style1" bgcolor="#FF0000" ><a href="#" onclick="closeCopyPo();">X</a></td>
          </tr>
          <tr>
            <td><div align="center">PO No </div></td>
            <td><select name="select" class="txtbox" id="cboPONo" style="width:100px" onchange="copyPO();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>		
</div>
<div id="divCopy" style="background-color: #999999;position:absolute;width:293px;left:531px;top:606px;visibility:hidden;border: 1px solid #333333">
  <table width="294">	
				<tr>
					<td width="102"  class="normalfnt">Sourse Order No </td>
				  <td width="180" class="normalfnt mouseover"><input type="text" name="cboCopySoOrderNo" class="txtbox" id="cboCopySoOrderNo" style="width:180px">
                                        <?php
				
				$sql = "select O.intStyleId,O.strOrderNo from invoicecostingheader IH inner join orders O on O.intStyleId=IH.intStyleId where IH.intStatus <>10";
				$result = $db->RunQuery($sql1);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
				}
				?>
                  </select></td>
				</tr>
				
				<tr>
				  <td  class="normalfnt">Target Order No </td>
				  <td class="normalfnt mouseover"><input type="text" name="cboCopyTaOrderNo" class="txtbox" id="cboCopyTaOrderNo" style="width:180px">
                   
                    <?php
				
				$sql = "SELECT O.intStyleId,O.strOrderNo FROM orders O WHERE O.intStyleId  NOT IN (SELECT invoicecostingheader.intStyleId FROM invoicecostingheader) and  O.intStatus=11 ORDER BY O.strOrderNo";
				$result = $db->RunQuery($sql1);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
				}
				
				?>
                  </select></td>
    </tr>	
					
				<tr>
					<td colspan="2" class="tableFooter1"><div align="center"><img src="../../images/copyPO.png" alt="copy" class="mouseover" onclick="CopyInvoiceCosting();"/></div></td>
				</tr>	
  </table>	
</div>

<div id="divReport" style="background-color: #FFFFFF;position:absolute;width:424px;left:465px;top:603px;visibility:hidden;border: 1px solid #333333">
  <table width="425" border="0" cellpadding="1" cellspacing="0">
  	<tr>
  		<td><table width="100%" class="bcgl1" cellspacing="1" cellpadding="0">
			<tr style="border:solid #666666 2px;">
				<td width="213" class="normalfnt" >&nbsp;
				  <input name="radiobutton" id="rdoReport2" type="radio" value="radiobutton" onclick="ViewReport(this.id);" />
		      Without Pocketing Category</td>
			  <td width="205" class="normalfnt"><input name="radiobutton" id="rdoReport1" type="radio" value="radiobutton" onclick="ViewReport(this.id);" /> 
			  With Pocketing Category </td>
			</tr>	
		</table></td>
	</tr>
	<tr>
		<td>
		<table width="100%" class="bcgl1" cellspacing="1" cellpadding="0">	
			<tr class="bcgl1">
				<td width="213" class="normalfnt">&nbsp;
				  <input name="radiobutton1" id="radio2" type="radio" value="radiobutton" checked="checked" onclick="ChangeReportCategory(1);"/>
		      With 2 Decimal </td>
				<td width="205" ><span class="normalfnt">
				      <input name="radiobutton1" id="radio4" type="radio" value="radiobutton" onclick="ChangeReportCategory(2);"//>
	          With 4 Decimal </span></td>
			</tr>	
		</table></td>
	</tr>
  </table>	
</div>

</body>
</html>
<script type="text/javascript">
var confirmInvoiceCosting ="<?php echo $confirmInvoiceCosting?>";
var PP_ReviseInvoiceCosting ="<?php echo $PP_reviseInvoiceCosting?>";
var PP_InvoiceCostingPowerUser ="<?php echo $PP_InvoiceCostingPowerUser?>";
</script>
<?php

function loadStyleNo()
{
global $db;
include "../../Connector.php"; 

$sqlquery = "(SELECT intStyleId,strStyle FROM orders WHERE orders.intStyleId  NOT IN (SELECT invoicecostingheader.intStyleId FROM                         invoicecostingheader)) ORDER BY orders.intStyleId"; 
$result = $db->RunQuery($sqlquery);
	if(mysql_num_rows($result))
	{
		while($fields_oag = mysql_fetch_array($result,MYSQL_BOTH))
		{
			$intStyleId    = $fields_oag['intStyleId'];
			$strStyle      = $fields_oag['strStyle'];
			$te_return    .= $intStyleId."**".$strStyle."####";
		}
		$te_return = substr($te_return,0,-4);
	}
	else
	{
		$te_return = "";
	}
return "$te_return";
}
?>





