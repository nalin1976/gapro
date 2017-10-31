<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eShipping Web | Commercial Invoice</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->


</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
	font-family: Tahoma;
}
-->
</style>
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="CommercialInvFormat.js"></script>

 <link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	include "../../Connector.php";	
?>

<form id="frmCommercialInvoice" name="frmCommercialInvoice" method="post">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
	<td><?php include '../../Header.php'; ?></td>
</tr>
<tr>
	<td><table width="100%" border="0">
		<tr>
			<td width="10%">&nbsp;</td>
			<td width="80%">
				<table width="100%" border="0">
					<tr>
						<td height="30" bgcolor="#588DE7" class="TitleN2white" align="center">Standard Document Procedure</td>
					</tr>
					<tr bgcolor="#D8E3FA">
						<td ><table width="101%" border="0" class="normalfnt" cellpadding="2">
						  <tr>
						    <td height="5" colspan="5"></td>
					      </tr>
						  <tr>
						    <td width="1%">&nbsp;</td>
						    <td width="15%" class="normalfnt">Invoice Format</td>
						    <td colspan="3"><select name="cboView" class="txtbox" onchange="loadDetails()" id="cboView"   style="width:100%;">
						      <option value=""></option>
						      <?php 
                   $strInvFormat="select intCommercialInvId,strCommercialInv from commercialinvformat order by strCommercialInv";
                   $resultInvFormat=$db->RunQuery($strInvFormat);
						 while($row_InvFormat=mysql_fetch_array( $resultInvFormat)) 
						 echo "<option value=".$row_InvFormat['intCommercialInvId'].">".$row_InvFormat['strCommercialInv']."</option>";                 
                   ?>
					        </select></td>
					      </tr>
						  <tr>
						    <td>&nbsp;</td>
						    <td class="normalfnt">Title<span style="color:#F00"> *</span></td>
						    <td colspan="3"><input type="text" class="txtbox" name="txtCommercialInv" id="txtCommercialInv" style="width:100%;" maxlength="100"/></td>
					      </tr>
						  <tr>
						    <td>&nbsp;</td>
						    <td class="normalfnt">Buyer<span style="color:#F00"> *</span></td>
						    <td><select name="cboBuyer" class="txtbox" onchange=""  id="cboBuyer"  style="width:200px;">
						      <option value=""></option>
						      <?php 
                   $sqlBuyer="SELECT strBuyerID,strBuyerCode,strName	FROM buyers where intDel=0 ORDER BY strBuyerCode ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";                 
                   ?>
					        </select></td>
					        <td>Buyer Title</td>
					        <td><input type="text" class="txtbox" name="txtBuyerTitle" id="txtBuyerTitle" style="width:195px;" maxlength="100"/></td>
						  </tr>
						  <tr>
						    <td>&nbsp;</td>
						    <td class="normalfnt">Destination<span style="color:#F00"> *</span></td>
						    <td width="35%"><select name="cboDestination" class="txtbox"  onchange=""  id="cboDestination" style="width:200px;">
						      <option value=""></option>
						      <?php 
                   $sqlCity="SELECT strPortOfLoading,strCityCode, strCity FROM city  order by strCity";
                   $resultCity=$db->RunQuery($sqlCity);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['strCityCode'].">".$row['strCity']." --> ".$row['strPortOfLoading']."</option>";                 
                   ?>
					        </select></td>
						    <td width="16%">Transport Mode <span style="color:#F00"> *</span></td>
						    <td width="33%"><select name="cboTransport" class="txtbox"  onchange=""  id="cboTransport" style="width:200px;">
						      <option value=""></option>
		            <option value="Sea">Sea Freight</option>
		            <option value="Air">Air Freight</option>
					        </select></td>
					      </tr>
						  
                          						  <tr>
						    <td>&nbsp;</td>
						    <td class="normalfnt">Broker/ Bill to</td>
						    <td><select name="cboNotify1" class="txtbox"  onchange=""  id="cboNotify1" style="width:200px;">
						      <option value="" ></option>
						      <?php 
                   $sqlBuyer="SELECT strBuyerID,strBuyerCode,strName	FROM buyers where intDel=0 ORDER BY strBuyerCode ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";                 
                   ?>
						      </select></td>
						    <td class="normalfnt">Broker Title</td>
						    <td><input type="text" class="txtbox" name="txtBrokerTitle" id="txtBrokerTitle" style="width:195px;" maxlength="100"/></td>
					      </tr>
						                          <tr>
						                            <td>&nbsp;</td>
						                            <td class="normalfnt">Accountee</td>
						                            <td><select name="cboAccountee" class="txtbox"  onchange=""  id="cboAccountee" style="width:200px;">
                                                      <option value=""></option>
                                                      <?php 
                   $sqlBuyer="SELECT strBuyerID,strBuyerCode,strName	FROM buyers where intDel=0 ORDER BY strBuyerCode ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";                 
                   ?>
                                                    </select></td>
						                            <td class="normalfnt">Accountee Title </td>
						                            <td><input type="text" class="txtbox" name="txtAccounteeTitle" id="txtAccounteeTitle" style="width:195px;" maxlength="100"/></td>
                          </tr>
                          <tr>
						    <td>&nbsp;</td>
						    <td class="normalfnt">Notify i </td>
						    <td><select name="cboNotify2" class="txtbox"  onchange=""  id="cboNotify2" style="width:200px;">
						      <option value=""></option>
						      <?php 
                   $sqlBuyer="SELECT strBuyerID,strBuyerCode,strName	FROM buyers where intDel=0 ORDER BY strBuyerCode ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";                 
                   ?>
						      </select></td>
						    <td class="normalfnt">Notify i Title </td>
						    <td><input type="text" class="txtbox" name="txtNotify1Title" id="txtNotify1Title" style="width:195px;" maxlength="100"/></td>
					      </tr>
						  <tr>
						    <td>&nbsp;</td>
						    <td class="normalfnt">Notify ii</td>
						    <td><select name="cboNotify3" class="txtbox"  onchange=""  id="cboNotify3" style="width:200px;">
                              <option value=""></option>
                              <?php 
                   $sqlBuyer="SELECT strBuyerID,strBuyerCode,strName	FROM buyers where intDel=0 ORDER BY strBuyerCode ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";                 
                   ?>
                            </select></td>
						    <td class="normalfnt">Notify ii Title </td>
						    <td><input type="text" class="txtbox" name="txtNotify2Title" id="txtNotify2Title" style="width:195px;" maxlength="100"/></td>
					      </tr>
						  <tr>
						    <td>&nbsp;</td>
						    <td class="normalfnt">CSC</td>
						    <td><select name="cboCsc" class="txtbox"  onchange=""  id="cboCsc" style="width:200px;">
                              <option value=""></option>
                              <?php 
                   $sqlBuyer="SELECT strBuyerID,strBuyerCode,strName	FROM buyers where intDel=0 ORDER BY strBuyerCode ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";                 
                   ?>
                            </select></td>
						    <td class="normalfnt">CSC Title </td>
						    <td><input type="text" class="txtbox" name="txtCSCTitle" id="txtCSCTitle" style="width:195px;" maxlength="100"/></td>
					      </tr>
						  <tr>
						    <td>&nbsp;</td>
						    <td class="normalfnt">Sold/Delivery to</td>
						    <td><select name="cboSold" class="txtbox"  onchange=""  id="cboSold" style="width:200px;">
                              <option value=""></option>
                              <?php 
                   $sqlBuyer="SELECT strBuyerID,strBuyerCode,strName	FROM buyers where intDel=0 ORDER BY strBuyerCode ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";                 
                   ?>
                            </select></td>
						    <td class="normalfnt">Sold Title </td>
						    <td><input type="text" class="txtbox" name="txtSoldTitle" id="txtSoldTitle" style="width:195px;" maxlength="100"/></td>
					      </tr>
						  <tr>
						    <td>&nbsp;</td>
						    <td class="normalfnt">INCOTERM </td>
						    <td><select name="cboIncoTerm" class="txtbox"    id="cboIncoTerm" style="width:200px;">
						      <option value=""></option>
						      <?php
$sql_delivery="select intDeliveryID,strDeliveryCode from deliveryterms where intStatus=1";
$result_delivery=$db->RunQuery($sql_delivery);
	echo "<option value=\"".""."\">".""."</option>\n";
while($row_delivery=mysql_fetch_array($result_delivery))
{
	echo "<option value=\"".$row_delivery["strDeliveryCode"]."\">".$row_delivery["strDeliveryCode"]."</option>\n";
}
?>
					        </select></td>
						    <td class="normalfnt">Term Desc</td>
						    <td><input type="text" class="txtbox" name="txtIncoDesc" id="txtIncoDesc" style="width:195px;" maxlength="100"/></td>
					      </tr>
						  <tr>
						    <td>&nbsp;</td>
						    <td class="normalfnt">Payment Term </td>
						    <td><select name="txtLine1"   class="txtbox" id="txtLine1" style="width:200px">
						      <option value=""></option>
						      <?php 
                   $strPayterms="select strPaymentTerm from paymentterm";
                   $resultPayterms=$db->RunQuery($strPayterms);
						 while($row_terms=mysql_fetch_array( $resultPayterms)) 
						 echo "<option value='".$row_terms['strPaymentTerm']."'>".$row_terms['strPaymentTerm']."</option>";                 
                   ?>
					        </select></td>
						    <td class="normalfnt">Authorised Person </td>
						    <td><select name="cboAuthorised" class="txtbox"   id="cboAuthorised" style="width:200px;">
						      <option value=""></option>
						      <?php 
                  		 $sqlBuyer="SELECT intWharfClerkID,strName FROM wharfclerks ORDER BY strName ";
                  		 $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['intWharfClerkID'].">".$row['strName']."</option>";                 
                   ?>
						      </select></td>
					      </tr>
                          <tr>
						    <td>&nbsp;</td>
						    <td class="normalfnt">Bank</td>
						    <td><select name="txtLine2"  class="txtbox" id="txtLine2" style="width:200px">
						      <option value=""></option>
						      <?php 
                   $sqlBuyer="SELECT strBankCode, 	strName FROM  bank ORDER BY strName";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBankCode'].">".$row['strName']."</option>";                 
                   ?>
					        </select></td>
						    <td>Buyer Bank</td>
						    <td><select name="txtBuyerBank"  class="txtbox" id="txtBuyerBank" style="width:200px">
						      <option value=""></option>
						      <?php 
                   $sqlBuyer="SELECT strBankCode, 	strName FROM  bank ORDER BY strName";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBankCode'].">".$row['strName']."</option>";                 
                   ?>
					        </select></td>
					      </tr>
						  <tr>
						    <td>&nbsp;</td>
						    <td class="normalfnt">VAT</td>
						    <td><input type="text" class="txtbox" name="txtLine3" id="txtLine3" style="width:198px;" maxlength="100"/></td>
						    <td>Forwader</td>
						    <td><select name="cboForwader"  class="txtbox" id="cboForwader" style="width:200px">
                              <option value=""></option>
                              <?php 
                   $sqlClerk="SELECT 	intForwaderID, strName FROM forwaders  ";
                   $resultCity=$db->RunQuery($sqlClerk);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['intForwaderID'].">".$row['strName']."</option>";                 
                   ?>
                            </select></td>
					      </tr>
                           <tr>
                             <td>&nbsp;</td>
                             <td class="normalfnt"><strong>Main Marks</strong></td>
                             <td>&nbsp;</td>
                             <td><strong>Side Marks</strong></td>
                             <td>&nbsp;</td>
                           </tr>
                           <tr>
                             <td>&nbsp;</td>
                             <td class="normalfnt">Line 1(Title) </td>
                             <td><input type="text" class="txtbox" name="txtMLine1" id="txtMLine1" style="width:200px;" maxlength="100"/></td>
                             <td>Line 1(Title) </td>
                             <td><input type="text" class="txtbox" name="txtSLine1" id="txtSLine1" style="width:195px;" maxlength="100"/></td>
                           </tr>
                           <tr>
                             <td>&nbsp;</td>
                             <td class="normalfnt">Line 2 (DO/ISD)</td>
                             <td><input type="text" class="txtbox" name="txtMLine2" id="txtMLine2" style="width:200px;" maxlength="100"/></td>
                             <td>Line 2</td>
                             <td><input type="text" class="txtbox" name="txtSLine2" id="txtSLine2" style="width:195px;" maxlength="100"/></td>
                           </tr>
                           <tr>
                             <td>&nbsp;</td>
                             <td class="normalfnt">Line 3</td>
                             <td><input type="text" class="txtbox" name="txtMLine3" id="txtMLine3" style="width:200px;" maxlength="100"/></td>
                             <td>Line 3</td>
                             <td><input type="text" class="txtbox" name="txtSLine3" id="txtSLine3" style="width:195px;" maxlength="100"/></td>
                           </tr>
                           <tr>
                             <td>&nbsp;</td>
                             <td class="normalfnt">Line 4</td>
                             <td><input type="text" class="txtbox" name="txtMLine4" id="txtMLine4" style="width:200px;" maxlength="100"/></td>
                             <td>Line 4 (Gross)</td>
                             <td><input type="text" class="txtbox" name="txtSLine4" id="txtSLine4" style="width:195px;" maxlength="100"/></td>
                           </tr>
                           <tr>
                             <td>&nbsp;</td>
                             <td class="normalfnt">Line 5</td>
                             <td><input type="text" class="txtbox" name="txtMLine5" id="txtMLine5" style="width:200px;" maxlength="100"/></td>
                             <td>Line 5 (Net)</td>
                             <td><input type="text" class="txtbox" name="txtSLine5" id="txtSLine5" style="width:195px;" maxlength="100"/></td>
                           </tr>
                           <tr>
                             <td>&nbsp;</td>
                             <td class="normalfnt">Line 6</td>
                             <td><input type="text" class="txtbox" name="txtMLine6" id="txtMLine6" style="width:200px;" maxlength="100"/></td>
                             <td>Line 6</td>
                             <td><input type="text" class="txtbox" name="txtSLine6" id="txtSLine6" style="width:195px;" maxlength="100"/></td>
                           </tr>
                           <tr>
                             <td>&nbsp;</td>
                             <td class="normalfnt">Line 7</td>
                             <td><input type="text" class="txtbox" name="txtMLine7" id="txtMLine7" style="width:200px;" maxlength="100"/></td>
                             <td>Line 7</td>
                             <td><input type="text" class="txtbox" name="txtSLine7" id="txtSLine7" style="width:195px;" maxlength="100"/></td>
                           </tr>
                           
                           <tr>
                             <td>&nbsp;</td>
                             <td colspan="4" class="normalfnt"><div style="overflow: scroll; height: 250px; width:100%;" id="selectitem">
                               <table width="100%" cellspacing="1" cellpadding="0" class="bcgl1" id="tblDescription">
                                 <tbody id="tblDescriptionOfGood">
                                   <tr>
                                     <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
                                     <td height="25" width="92%"bgcolor="#498CC2" class="normaltxtmidb2">Documents Required</td>
                                   </tr>
                                   <?php 
			$str_format="select strDocumentTitle,intDocumentId from documentformats order by strDocumentTitle";
			$result_format=$db->RunQuery($str_format);
			while($row_format=mysql_fetch_array($result_format))
			{
				$count++;
				if($count%2==1){
			?>
                                   <tr class="bcgcolor-tblrowWhite">
                                     <td align="center" ><input type="checkbox" class="chkbx" id="<?php echo $row_format["intDocumentId"];?>"/></td>
                                     <td ><?php echo $row_format["strDocumentTitle"];?></td>
                                   </tr>
                                   <?php }
			else
								{?>
                                   <tr class="bcgcolor-tblrow">
                                     <td align="center" ><input type="checkbox" class="chkbx" id="<?php echo $row_format["intDocumentId"];?>"/></td>
                                     <td ><?php echo $row_format["strDocumentTitle"];?></td>
                                   </tr>
                                   <?php }}?>
                                 </tbody>
                                 <tbody>
                                 </tbody>
                               </table>
                             </div></td>
                           </tr>
                          <tr>
						    <td colspan="5"></td>
					      </tr>
					    </table></td>
	              </tr>
				  <tr>
            <td height="34" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="743" border="0">
                    <tr>
                      
                      <td width="122">&nbsp;</td>
                      <td width="96"><img src="../../images/new.png" id="btnNew" class="mouseover" name="btnNew" tabindex="29" onclick=""/></td>
                      <td width="91"><img src="../../images/view.png" class="mouseover"  id="btnView" name="btnView" tabindex="30" onclick=""/></td>
                      <td width="84"><img src="../../images/save.png" alt="Save" width="84" height="24" name="btnSave" id="btnSave"  class="mouseover" onclick=""lass="mouseover" /></td>
                      <td width="85"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="84" height="24" border="0"  class="mouseover" id="btnClose"lass="mouseover" /></a></td>
                      <td width="117"><img src="../../images/delete.png" alt="Delete" name="btnDelete" id="btnDelete" class="mouseover"/></td>
                      <td width="118" align="center"><img src="../../images/do_copy.png" width="32" height="31" class="mouseover" onclick="copy_format()" title="Save As New Invoice Format"/></td>
                      </tr>
                    
                </table></td>
              </tr>
			  </table>
			</td>
		  </tr>
			  </table>
	  </td>
	  
			<td width="10%"></td>
		</tr>
	</table>
	</td>
</tr>
</table>
</form>





 

</body>
</html>
