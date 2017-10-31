<?php
session_start();
	include "../../Connector.php";
	include "../../authentication.inc";	
	$backwardseperator = "../../";
	$companyId = $_SESSION["FactoryID"];
	$userId	   = $_SESSION["UserID"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Standard Document Procedure</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="sdp.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>

</head>
<body>
<form id="frmSDP" name="frmSDP" >

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php';?></td>
  </tr>
  <tr>
  	<td height="2"></td>
  </tr>
  <tr>
    <td>
	<table width="800" cellpadding="2" cellspacing="0" border="0" align="center" class="bcgl1">
		<tr>
		<td>
		  <table width="100%" border="0" cellspacing="0" cellpadding="3" >
		  <tr class="mainHeading">
			<td height="25" colspan="4">Standard Document Procedure </td>
		  </tr>
		  <tr>
		    <td colspan="4" class="normalfnt">&nbsp;</td>
		    </tr>
		  <tr>
		  	<td width="114" class="normalfnt">&nbsp;Invoice Format</td>
		    <td colspan="3" class="normalfnt"><select name="cboInvoiceFormat" id="cboInvoiceFormat" onChange="loadInvoiceFormats(this.value);" style="width:660px">
			<option value=""></option>
			
			<?php
				$sql = "select intSDPID,strSDP_Title from shipping_sdp order by strSDP_Title";
				$result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["intSDPID"].">".$row['strSDP_Title']."</option>\n";
				}
			?>
			</select></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Title<span style="color:#F00"> *</span></td>
		    <td colspan="3" class="normalfnt"><input type="text" name="txtTitle" id="txtTitle" style="width:660px"></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Buyer<span style="color:#F00"> *</span></td>
		    <td width="284" class="normalfnt"><select name="cboBuyer" class="txtbox" id="cboBuyer" onChange="loadBuyerBranch(this.value);"  style="width:200px;"/>
			<option value=""></option>
			
			<?php
				$sql_buyer = "select intBuyerID,buyerCode,strName from buyers where intStatus=1 order by strName;";
				$result_buyer = $db->RunQuery($sql_buyer);
				while($row = mysql_fetch_array($result_buyer))
				{
					echo "<option value=".$row["intBuyerID"].">".$row['buyerCode']." ---> ".$row['strName']."</option>\n";
				}
			?>
			</select>			</td>
		    <td width="142" class="normalfnt">&nbsp;Buyer Title</td>
		    <td width="230" class="normalfnt"><label>
		      <input type="text" name="txtBuyerTitle" id="txtBuyerTitle" style="width:200px;" maxlength="100">
		    </label></td>
		  </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Buyer Branch</td>
		    <td class="normalfnt"><select name="cboBuyerBranch" class="txtbox" onChange="loadNotify(this.value);" id="cboBuyerBranch"  style="width:200px;">
            </select></td>
		    <td class="normalfnt">&nbsp;Port of Loading</td>
		    <td class="normalfnt"><select name="cboPortOfLoading" class="txtbox" id="cboPortOfLoading"  style="width:200px;">
              <option value=""></option>
              <?php
				$sql_destination = "select intCityID,strCityName,strPort from finishing_final_destination 
									order by strCityName ";

				$result = $db->RunQuery($sql_destination);
				while($row = mysql_fetch_array($result))
				{
					 echo "<option value=".$row['intCityID'].">".$row['strCityName']." --> ".$row['strPort']."</option>";
				}
			?>
            </select></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Exporter</td>
		    <td class="normalfnt"><select name="cboExporter" class="txtbox" id="cboExporter"  style="width:200px;">
			<option value=""></option>
			<?php
				$sql_destination = "select intCompanyID,strName from companies where intManufacturing!=1 order by strName; ";

				$result = $db->RunQuery($sql_destination);
				while($row = mysql_fetch_array($result))
				{
					 echo "<option value=".$row['intCompanyID'].">".$row['strName']."</option>";
				}
			?>
            </select></td>
		    <td class="normalfnt">&nbsp;Manufacturer</td>
		    <td class="normalfnt"><select name="cboManufacturer" class="txtbox" id="cboManufacturer"  style="width:200px;">
              <option value=""></option>
              <?php
				$sql_destination = "select intCompanyID,strName from companies where intManufacturing=1 order by strName; ";

				$result = $db->RunQuery($sql_destination);
				while($row = mysql_fetch_array($result))
				{
					 echo "<option value=".$row['intCompanyID'].">".$row['strName']."</option>";
				}
			?>
            </select></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Destination<span style="color:#F00"> *</span></td>
		    <td class="normalfnt"><select name="cboDestination" class="txtbox" id="cboDestination"  style="width:200px;">
			<option value=""></option>
			<?php
				$sql_destination = "select intCityID,strCityName,strPort from finishing_final_destination 
									order by strCityName ";

				$result = $db->RunQuery($sql_destination);
				while($row = mysql_fetch_array($result))
				{
					 echo "<option value=".$row['intCityID'].">".$row['strCityName']." --> ".$row['strPort']."</option>";
				}
			?>
            </select></td>
		    <td class="normalfnt">&nbsp;Transport Mode <span style="color:#F00"> *</span></td>
		    <td class="normalfnt"><select name="cboTransportMode" class="txtbox" id="cboTransportMode"  style="width:200px;">
			<option value=""></option>
                 <?php
				 $sql="SELECT * FROM shipmentmode where intStatus='1' order by intShipmentModeId";
				 $result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["intShipmentModeId"].">".$row["strDescription"]."</option>\n";
				}
				?>
            </select></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Notify i</td>
		    <td class="normalfnt"><select name="cboNotify1" class="txtbox" id="cboNotify1"  style="width:200px;">
            </select></td>
		    <td class="normalfnt">&nbsp;Notify i Title</td>
		    <td class="normalfnt"><input type="text" name="txtNotify1" id="txtNotify1" style="width:200px;" maxlength="100"></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Notify ii</td>
		    <td class="normalfnt"><select name="cboNotify2" class="txtbox" id="cboNotify2"  style="width:200px;">
            </select></td>
		    <td class="normalfnt">&nbsp;Notify ii Title</td>
		    <td class="normalfnt"><input type="text" name="txtNotify2" id="txtNotify2" style="width:200px;" maxlength="100"></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Notify iii</td>
		    <td class="normalfnt"><select name="cboNotify3" class="txtbox" id="cboNotify3"  style="width:200px;">
            </select></td>
		    <td class="normalfnt">&nbsp;Notify iii Title</td>
		    <td class="normalfnt"><input type="text" name="txtNotify3" id="txtNotify3" style="width:200px;" maxlength="100"></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Notify iv </td>
		    <td class="normalfnt"><select name="cboNotify4" class="txtbox" id="cboNotify4"  style="width:200px;">
            </select></td>
		    <td class="normalfnt">&nbsp;Notify iv Title</td>
		    <td class="normalfnt"><input type="text" name="txtNotify4" id="txtNotify4" style="width:200px;" maxlength="100"></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Incoterm</td>
		    <td class="normalfnt"><select name="cboIncoterm" class="txtbox" id="cboIncoterm"  style="width:200px;">
			<option value=""></option>
			<?php
			 $sql_shipmentterm = "select strShipmentTermId,strShipmentTerm from shipmentterms where intStatus = 1
			 					  order by strShipmentTerm ";
			 $result = $db->RunQuery($sql_shipmentterm);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["strShipmentTermId"].">".$row["strShipmentTerm"]."</option>\n";
				}
			?>
            </select></td>
		    <td class="normalfnt">&nbsp;Term Desc</td>
		    <td class="normalfnt"><input type="text" name="txtTermDes" id="txtTermDes" style="width:200px;" maxlength="200"></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Payment Term</td>
		    <td class="normalfnt"><select name="cboPaymentTerm" class="txtbox" id="cboPaymentTerm"  style="width:200px;">
			<option value=""></option>
			<?php
				$sql_payTerm = "select strPayTermId,strDescription from popaymentterms where intStatus = 1;";
				$result = $db->RunQuery($sql_payTerm);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["strPayTermId"].">".$row["strDescription"]."</option>\n";
				}
			?>
            </select></td>
		    <td class="normalfnt">&nbsp;Payment Desc</td>
		    <td class="normalfnt"><input type="text" name="txtPaymentDes" id="txtPaymentDes" style="width:200px;" maxlength="200"></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Bank</td>
		    <td class="normalfnt"><select name="cboBank" class="txtbox" id="cboBank"  style="width:200px;">
			<option value=""></option>
			<?php
				$sql_bank = "select intBankId,strBankName from bank where intStatus = 1";
				$result = $db->RunQuery($sql_bank);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["intBankId"].">".$row["strBankName"]."</option>\n";
				}
			?>
            </select></td>
		    <td class="normalfnt">&nbsp;Buyer Bank</td>
		    <td class="normalfnt"><select name="cboBuyerBank" class="txtbox" id="cboBuyerBank"  style="width:200px;">
			<option value=""></option>
			<?php
				$sql_bank = "select intBankId,strBankName from bank where intStatus = 1";
				$result = $db->RunQuery($sql_bank);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["intBankId"].">".$row["strBankName"]."</option>\n";
				}
			?>
            </select></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;VAT</td>
		    <td class="normalfnt"><input type="text" name="txtVAT" id="txtVAT" style="width:200px;" maxlength="50"></td>
		    <td class="normalfnt">&nbsp;Forwader</td>
		    <td class="normalfnt"><select name="cboForwader" class="txtbox" id="cboForwader"  style="width:200px;">
			<option value=""></option>
			<?php
				$sql_bank = "select intForwarderId,strForwarderName from forwarder ;";
				$result = $db->RunQuery($sql_bank);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["intForwarderId"].">".$row["strForwarderName"]."</option>\n";
				}
			?>
            </select></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;<strong>Main Marks</strong></td>
		    <td class="normalfnt">&nbsp;</td>
		    <td class="normalfnt">&nbsp;<strong>Side Marks</strong></td>
		    <td class="normalfnt">&nbsp;</td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Line 1(Title)</td>
		    <td class="normalfnt"><input type="text" name="txtMMLine1" id="txtMMLine1" style="width:200px;" maxlength="200"></td>
		    <td class="normalfnt">&nbsp;Line 1(Title)</td>
		    <td class="normalfnt"><input type="text" name="txtSMLine1" id="txtSMLine1" style="width:200px;" maxlength="200"></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Line 2 (DO/ISD)</td>
		    <td class="normalfnt"><input type="text" name="txtMMLine2" id="txtMMLine2" style="width:200px;" maxlength="200"></td>
		    <td class="normalfnt">&nbsp;Line 2</td>
		    <td class="normalfnt"><input type="text" name="txtSMLine2" id="txtSMLine2" style="width:200px;" maxlength="200"></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Line 3</td>
		    <td class="normalfnt"><input type="text" name="txtMMLine3" id="txtMMLine3" style="width:200px;" maxlength="200"></td>
		    <td class="normalfnt">&nbsp;Line 3</td>
		    <td class="normalfnt"><input type="text" name="txtSMLine3" id="txtSMLine3" style="width:200px;" maxlength="200"></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Line 4</td>
		    <td class="normalfnt"><input type="text" name="txtMMLine4" id="txtMMLine4" style="width:200px;" maxlength="200"></td>
		    <td class="normalfnt">&nbsp;Line 4</td>
		    <td class="normalfnt"><input type="text" name="txtSMLine4" id="txtSMLine4" style="width:200px;" maxlength="200"></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Line 5</td>
		    <td class="normalfnt"><input type="text" name="txtMMLine5" id="txtMMLine5" style="width:200px;" maxlength="200"></td>
		    <td class="normalfnt">&nbsp;Line 5</td>
		    <td class="normalfnt"><input type="text" name="txtSMLine5" id="txtSMLine5" style="width:200px;" maxlength="200"></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Line 6</td>
		    <td class="normalfnt"><input type="text" name="txtMMLine6" id="txtMMLine6" style="width:200px;" maxlength="200"></td>
		    <td class="normalfnt">&nbsp;Line 6</td>
		    <td class="normalfnt"><input type="text" name="txtSMLine6" id="txtSMLine6" style="width:200px;" maxlength="200"></td>
		    </tr>
		  <tr>
		    <td class="normalfnt">&nbsp;Line 7</td>
		    <td class="normalfnt"><input type="text" name="txtMMLine7" id="txtMMLine7" style="width:200px;" maxlength="200"></td>
		    <td class="normalfnt">&nbsp;Line 7</td>
		    <td class="normalfnt"><input type="text" name="txtSMLine7" id="txtSMLine7" style="width:200px;" maxlength="200"></td>
		    </tr>
		  <tr>
		    <td colspan="4"><div style="overflow: scroll; height: 250px; width:100%;" id="selectitem">
                               <table width="100%" cellspacing="1" cellpadding="2" bgcolor="#CCCCFF" id="tblDescription">
                                
                                   <tr class="mainHeading4">
                                     <td width="8%">&nbsp;</td>
                                     <td height="25">Documents Required</td>
                                   </tr>
            <?php 
			$str_format="select strDocumentTitle,intDocumentId from shipping_documentformats order by strDocumentTitle";
			$result_format=$db->RunQuery($str_format);
			while($row_format=mysql_fetch_array($result_format))
			{
				$count++;
				if($count%2==1){
			?>
                                   <tr class="bcgcolor-tblrowWhite">
                                     <td align="center"><input type="checkbox" class="chkbx" id="<?php echo $row_format["intDocumentId"];?>"/></td>
                                     <td class="normalfnt" ><?php echo $row_format["strDocumentTitle"];?></td>
                                   </tr>
							<?php }
							else
								{?>
                                   <tr class="bcgcolor-InvoiceCostFabric">
                                     <td align="center" ><input type="checkbox" class="chkbx" id="<?php echo $row_format["intDocumentId"];?>"></td>
                                     <td class="normalfnt"><?php echo $row_format["strDocumentTitle"];?></td>
                                   </tr>
								    <?php }}?>
                               </table>
                             </div></td>
		    </tr>
			<tr>
				<td colspan="4">
					<table width="100%" border="0" cellspacing="3" cellpadding="0" class="tableBorder">
					  <tr>
						<td width="10%" align="center"></td>
					    <td width="80%" align="center"><img src="../../images/new.png" width="96" height="24" onClick="clearPage();"><img src="../../images/save.png" width="84" height="24" id="butSave" name="Save" onClick="saveData(this.name);"><img src="../../images/delete.png" id="butDelete" onClick="deleteData();"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0"></a></td>
					    <td width="10%" align="center"><img src="../../images/do_copy.png" width="32" height="31" name="copyInv" class="mouseover" onClick="saveData(this.name);" title="Save As New Invoice Format"/></td>
					  </tr>
					</table>				</td>
			</tr>
		  </table>
		</td>
		</tr>
	</table>
	</td>
  </tr>
</table>

</form>
</body>
</html>
