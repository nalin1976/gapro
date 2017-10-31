<?php
$backwardseperator = "../../../";
session_start();
include("../../../Connector.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Export Cusdec</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<script src="../../../javascript/script.js" type="text/javascript"></script>
<script src="excusdec.js"></script>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>


<form id="frmBanks" name="form1" method="POST" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="30" bgcolor="#588DE7" class="TitleN2white">Cusdec Details </td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
                        <tr>
						  <td width="2%" height="25"></td>
                          <td width="6%"><input name="radiobutton" type="radio" che="che" checked="checked" value="radiobutton" id="all" />
                           </td>
                          
						  <td width="17%">All</td>
                          <td width="6%"><input name="radiobutton" type="radio" value="general" id="general" /></td>
                          <td width="19%">General</td>
                          <td width="6%"><input name="radiobutton" type="radio" value="boi" id="infact" /></td>
                          <td width="19%">Infact</td>
                          <td width="6%"><input name="radiobutton" type="radio" value="boi" id="boi" /></td>
                          <td width="19%">BOI</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
                        <tr>
                          <td width="2%" height="25">&nbsp;</td>
                          <td width="9%">User</td>
                          <td width="25%"><input name="txtPhone2" type="text" class="txtbox" id="txtPhone2" style="width:100px;" readonly="readonly"  value="<?php echo $_SESSION['UserName'] ;?>"/></td>
                          <td width="7%">Date</td>
                          <td width="25%"><input name="txtInvoiceDate" type="text" readonly="readonly" class="txtbox" id="txtInvoiceDate" style="width:100px;" value="<?php echo date('d/m/Y');?>"/></td>
                          <td width="13%">Declaration</td>
                          <td width="19%"><input name="txtDecleration" type="text" class="txtbox" id="txtDecleration" style="width:100px;" value="EX3" /></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td class="normalfnt"><table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1">
                        <tr>
                          <td width="2%"></td>
                          <td width="17%"></td>
                          <td width="28%"></td>
                          <td width="2%"></td>
                          <td width="7%"></td>
                          <td width="12%"></td>
                          <td width="30%"></td>
                          <td width="2%"></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td  height="25">Invoice No </td>
                          <td><select name="cboInvoice"  class="txtbox" id="cboInvoice" style="width:150px" onchange="loadInvoice();">
										<option value=''></option>                          
                          <?php
                   			$str="SELECT strInvoiceNo FROM invoiceheader order by intInvoiceId desc";
                  			$exec=$db->RunQuery( $str);
									while($row=mysql_fetch_array( $exec)) {?>
						 			<option value="<?php echo $row['strInvoiceNo'];?>"><?php echo $row['strInvoiceNo'];?></option>                 
                      <?php }?>                    		
                          </select></td>
                          <td>&nbsp;</td>
                          <td colspan="2">Exporter</td>
                          <td><select name="cboExporter" disabled="disabled"  class="txtbox" id="cboExporter"style="width:150px">
                            <option value=""></option>
                            <?php
                   $sqlConsignee="SELECT 	strCustomerID, 	strName FROM customers ";
                   $resultConsignee=$db->RunQuery( $sqlConsignee);
						 while($row=mysql_fetch_array( $resultConsignee)) 
						 echo "<option value=".$row['strCustomerID'].">".$row['strName']."</option>";                 
                   			?>
                          </select></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td height="25">Consignee</td>
                          <td><select name="cboConsignee" disabled="disabled"  class="txtbox" id="cboConsignee"style="width:150px">
						  <option value=""></option>                   
                   <?php 
                   $sqlBuyer="SELECT strBuyerID,	strName	FROM buyers ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strName']."</option>";                 
                   ?>							            
                          </select></td>
                          <td>&nbsp;</td>
                          <td colspan="2">Vessel/Flight</td>
                          <td><input name="txtVessel" type="text"  disabled="disabled" class="txtbox" id="txtVessel" style="width:148px" /></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td height="25">Voyage No </td>
                          <td><input name="txtVoyageeNo" type="text" class="txtbox" id="txtVoyageeNo" disabled="disabled" style="width:148px"/></td>
                          <td>&nbsp;</td>
                          <td colspan="2">Voyagee Date </td>
                          <td><input name="txtVoyageeDate" type="text" class="txtbox" disabled="disabled" id="txtVoyageeDate" style="width:148px" /></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="8"></td>
                          </tr>
                      </table></td>
                      </tr>
                    <tr class="bcgl1">
                      <td class="normalfnt">
                        <table width="100%" border="0" cellpadding="1" cellspacing="1" class="bcgl1">
                          <tr>
                            <td colspan="8"></td>
                            </tr>
                          <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="17%" class="normalfnt"> Last Consign </td>
                            <td width="28%" class="normalfnt"><select  disabled="disabled" name="cboCityOf"  class="txtbox" id="cboCityOf"style="width:150px">
                                <option value=""></option>
                                <?php 
                   $sqlCity="SELECT 	strCityCode, strCity FROM city ";
                   $resultCity=$db->RunQuery($sqlCity);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['strCityCode'].">".$row['strCity']."</option>";                 
                   ?>
                            </select></td>
                            <td width="2%" class="normalfnt">&nbsp;</td>
                            <td width="19%" class="normalfnt">Destination  </td>
                            <td width="29%" class="normalfnt"><select name="cboCountry"  class="txtbox" id="cboCountry"style="width:150px">
                                <option value=""></option>
                                <?php 
                   $sqlCity="SELECT 	strCountryCode,	strCountry FROM country  ";
                   $resultCity=$db->RunQuery($sqlCity);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['strCountryCode'].">".$row['strCountry']."</option>";                 
                   ?>
                            </select></td>
                            <td width="1%" class="normalfnt">&nbsp;</td>
                            <td width="2%" class="normalfnt">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">Delivery Trm. </td>
                            <td class="normalfnt"><select name="cboDelivery" style="width:150px" id="cboDelivery" class="txtbox">
                              <?php
$sql_delivery="select strDeliveryCode,concat(strDeliveryCode,'-->',strDeliveryName)AS deliveryName from deliveryterms where intStatus=1";
$result_delivery=$db->RunQuery($sql_delivery);
	echo "<option value=\"".""."\">".""."</option>\n";
while($row_delivery=mysql_fetch_array($result_delivery))
{
	echo "<option value=\"".$row_delivery["strDeliveryCode"]."\">".$row_delivery["deliveryName"]."</option>\n";
}
?>
                            </select></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt" height="25">Office Of Entry </td>
                            <td class="normalfnt" height="25"><select name="txtOfficeEntry"  class="txtbox" id="txtOfficeEntry" style="width:150px">
                                <option value=""></option>
                                <option value="CBIF1">CBIF1</option>
                                <option value="CBEX1">CBEX1</option>
                                <option value="KTEX1">KTEX1</option>
                                <option value="CBBE1">CBBE1</option>
                                <option value="CBBE2">CBBE2</option>
                            </select></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">FCL</td>
                            <td class="normalfnt"><input name="txtFCl" type="text" class="txtbox" id="txtFCl" style="width:148px" /></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt" height="25">Insurence</td>
                            <td class="normalfnt"><input name="txtInsurence" type="text" class="txtbox" id="txtInsurence" style="width:148px" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">Measurement</td>
                            <td class="normalfnt"><input name="txtMeasure" type="text" class="txtbox" id="txtMeasure" style="width:148px" /></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt" height="25">Freight</td>
                            <td class="normalfnt"><input name="txtFrreight" type="text" class="txtbox" id="txtFrreight" style="width:148px" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                          
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt" valign="top">Cage 50</td>
                            <td rowspan="3" class="normalfnt" valign="top"><textarea name="txtCage50"   class="txtbox" style="width:148px;height:60px; " id="txtCage50"  ></textarea></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">Other</td>
                            <td class="normalfnt" height="25"><input name="txtOther" type="text" class="txtbox"  id="txtOther" style="width:148px" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">BL No </td>
                            <td class="normalfnt" height="25"><input name="txtBL" type="text" class="txtbox" id="txtBL" style="width:148px" /></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">Payment Terms<span style="color:#FF0000">*</span></td>
                            <td class="normalfnt" height="25">
                            <select name="cboPayTerms" type="text="text"" tabindex="3" id="cboPayTerms" class="txtbox" style="width:150px" >
                              <option value=""></option>
                              <option value="10">10</option>
                              <option value="20">20</option>
                              <option value="31">31</option>
                              <option value="35">35</option>
                              <option value="41">41</option>
                              <option value="45">45</option>
                              <option value="51">51</option>
                              <option value="55">55</option>
                              <option value="61">61</option>
                              <option value="65">65</option>
                              <option value="90">90</option>
                              <option value="99">99</option>
                            </select>
                            
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                          
                          <tr>
                            <td>&nbsp;</td>
                            <td class="normalfnt">Authorized by </td>
                            <td class="normalfnt"><select name="txtAuthorizeby"  class="txtbox" id="txtAuthorizeby"style="width:150px">
                              <option value=""></option>
                              <?php 
                   $sqlClerk="SELECT 	intWharfClerkID, strName FROM wharfclerks  ";
                   $resultCity=$db->RunQuery($sqlClerk);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['intWharfClerkID'].">".$row['strName']."</option>";                 
                   ?>
                            </select></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">Walf Clerk </td>
                            <td class="normalfnt" height="25"><select name="cboWharfClerk"  class="txtbox" id="cboWharfClerk"style="width:150px">
                                <option value=""></option>
                                <?php 
                   $sqlClerk="SELECT 	intWharfClerkID, strName FROM wharfclerks  ";
                   $resultCity=$db->RunQuery($sqlClerk);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['intWharfClerkID'].">".$row['strName']."</option>";                 
                   ?>
                            </select></td>
                            <td class="normalfnt">&nbsp;</td>
                            <td class="normalfnt">&nbsp;</td>
                          </tr>
                        </table>
                        <span id="txtHint" style="color:#FF0000"></span></td>
                      </tr>
                  </table></td>
                  </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr bgcolor="#d6e7f5">
                <td width="100%"><table width="100%" border="0" cellspacing="0">
                    <tr bgcolor="#d6e7f5">
                      <td width="26">&nbsp;</td>
                      <td width="104"><img src="../../../images/new.png" alt="New" width="100" height="24" name="New" class="mouseover noborderforlink" onclick="pageReload();"/></td>
                      <td width="90"><img src="../../../images/save.png" alt="Save" width="84" height="24" name="Save" class="mouseover noborderforlink" onclick="saveCusdec();"/></td>
                      <td width="102"><img src="../../../images/delete.png" alt="Delete" width="100" height="24" name="Delete"onclick="pageReload();" class="mouseover noborderforlink" /></td>
                      <td width="114"><img src="../../../images/print.png" alt="new" name="butPrint" width="115" height="24" class="mouseover noborderforlink"  id="butPrint" onclick="PrintCusdec();"/></td>
                      <td width="125"><a href="../../../main.php"><img src="../../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
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
  <tr>
    <td>&nbsp;</td>
  </tr>

  
  
  
  
</table>

</form>
</body>
</html>
