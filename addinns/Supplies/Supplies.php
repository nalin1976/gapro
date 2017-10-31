<?php
$backwardseperator = "../../";
$curruntFolder=basename(dirname(__FILE__));
session_start();
?>
<?php

$uploadSt=0;
$uploadSt=$_POST["uploadStatus"];
if($uploadSt==1){
$cbosearch=$_POST["cbosearch"];
$txtvatrn=$_POST["txtvatrn"];
$txtSupplierCode=$_POST["txtSupplierCode"];
$txtcompany=$_POST["txtcompany"];
$txtaddress1=$_POST["txtaddress1"];
$txtaddress2=$_POST["txtaddress2"];
$txtOption1=$_POST["txtOption1"];
$txtOption3=$_POST["txtOption3"];
$txtOption2=$_POST["txtOption2"];
$txtContactPerson=$_POST["txtContactPerson"];
$txtstreet=$_POST["txtstreet"];
$cboCountry=$_POST["cboCountry"];
$txtZipCode=$_POST["txtZipCode"];
$txtPhone=$_POST["txtPhone"];
$txtFax=$_POST["txtFax"];
$txtemail=$_POST["txtemail"];
$txtweb	=$_POST["txtweb"];
$cbocurrency=$_POST["cbocurrency"];
$cboorigin=$_POST["cboorigin"];
$cboshipment=$_POST["cboshipment"];
$cbopaymode=$_POST["cbopaymode"];
$cbopaymode=$_POST["cbopaymode"];
$cbopayterms=$_POST["cbopayterms"];
$txtremarks=$_POST["txtremarks"];
$txtkeyitms=$_POST["txtkeyitms"];
$checkbox=$_POST["checkbox"];
$cbotax=$_POST["cbotax"];
$chktax=$_POST["chktax"];
$chkcredit=$_POST["chkcredit"];
$cbocredit=$_POST["cbocredit"];
$chkvat=$_POST["chkvat"];
$txtsupplier=$_POST["txtsupplier"];
$txtReason=$_POST["txtReason"];
$chksupplier=$_POST["chksupplier"];
$docUpload=$_POST["docUpload"];
//$txtApprComments=$_POST["txtApprComments"];
$txtApprComments="";
}
else{
$cbosearch="";
$txtvatrn="";
$txtSupplierCode="";
$txtcompany="";
$txtaddress1="";
$txtaddress2="";
$txtOption1="";
$txtOption3="";
$txtOption2="";
$txtContactPerson="";
$txtstreet="";
$cboCountry="";
$txtZipCode="";
$txtPhone="";
$txtFax="";
$txtemail="";
$txtweb="";
$cbocurrency="";
$cboorigin="";
$cboshipment="";
$cboshipmentTerm="";
$cbopaymode="";
$cbopayterms="";
$txtremarks="";
$txtkeyitms="";
$checkbox="";
$cbotax="";
$chktax="";
$chkcredit="";
$cbocredit="";
$chkvat="";
$txtsupplier="1";
$txtReason="";
$chksupplier="";
$docUpload="";
$txtApprComments="";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Supplies</title>
<script src="Button.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="newMasterData-js.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function PageSubmit()
{
	//alert(document.getElementById("datUpload").value);
	document.getElementById("uploadStatus").value=1;
	document.getElementById("frmSupplies").submit();
}
</script>

</head>

<body>
<?php
include "../../Connector.php";

?>
<form id="frmSupplies" name="frmSupplies" enctype="multipart/form-data" method="post" action="">
<table width="100%" border="0" align="center">
  <tr>
    <td><?php include "../../Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top"><div class="main_text">Suppliers<span class="vol">(Ver 0.4)</span></div></div>
<div class="main_body">
<table width="660" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="650" border="0" align="center">
      <tr>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="96">
              <table width="100%" border="0">
                <tr>
                  <td class="normalfnt"><table width="100%" border="0" class="bcgl1">

                      <tr>
                        <td width="124" height="22" class="normalfnt">Search</td>
                        <td colspan="3"><select name="cbosearch" class="txtbox" onchange="getSuppliesDetails();"id="cbosearch" style="width:380px" tabindex="1">
                          <?php						
			$SQL="SELECT strSupplierID,strTitle FROM suppliers WHERE intStatus='1' order by strTitle;";
			
			$result=$db->RunQuery($SQL);
		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
	if($cbosearch==$row["strSupplierID"]){
	echo "<option value=\"". $row["strSupplierID"] ."\" selected=\""."selected"."\">" . $row["strTitle"] ."</option>" ;
		}
		else{
		echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	}			
						
?>
                        </select></td>
                        </tr>
                      <tr>
                        <td class="normalfnt">Code&nbsp;<span class="compulsoryRed">*</span></td>
                        <td width="154"><input tabindex="2" name="txtSupplierCode" id="txtSupplierCode" type="text" class="txtbox"   value="<?php echo $txtSupplierCode ?>"  style="width:125px" maxlength="10" onkeypress="return checkForTextNumber(this.value, event);"/></td>
                        <td width="90">VAT Reg. No.</td>
                        <td width="242" colspan="1"><input tabindex="3" name="txtvatrn" type="text" class="txtbox" id="txtvatrn"  style="width:125px" value="<?php echo $txtvatrn ?>" maxlength="15" onkeypress="return checkForTextNumber(this.value, event);"/></td>
                        </tr>
                      <tr>
                        <td class="normalfnt">Company Name&nbsp;<span class="compulsoryRed">*</span></td>
                        <td colspan="3"><input tabindex="4" name="txtcompany" id="txtcompany" type="text" class="txtbox"   value="<?php echo $txtcompany ?>" style="width:377px" maxlength="100"/></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Address</td>
                        <td colspan="3"><input tabindex="5" name="txtaddress1" type="text" value="<?php echo $txtaddress1 ?>" class="txtbox" id="txtaddress1" style="width:377px" maxlength="50"/></td>
			          </tr>
				  

                      <tr>
                        <td class="normalfnt">Street</td>
                        <td colspan="3"><input tabindex="6" name="txtstreet" type="text" value="<?php echo $txtstreet ?>" class="txtbox" id="txtstreet"  style="width:377px" maxlength="50"/></td>
                        </tr>
                      <tr>
                        <td height="24" class="normalfnt">City</td>
                        <td width="154"  class="normalfnt"><input name="txtCity" type="text" class="txtbox" value="<?php echo $txtCity ?>" id="txtCity"  style="width:125px" maxlength="50" tabindex="7"/></td>
                        <td >State</td>
                        <td><input tabindex="8" name="txtState" type="text" class="txtbox" id="txtState" value="<?php echo $txtState ?>"  style="width:125px" maxlength="15"/></td>
                        </tr>
                      <tr>
                        <td class="normalfnt">Country<span class="compulsoryRed">*</span></td>
                        <td width="154" class="normalfnt"><select tabindex="9" name="cboCountry" class="txtbox" id="cboCountry" style="width:127px" onchange="GetCountryZipCode(this.value);">
							<?php
			$SQL="SELECT * FROM country WHERE country.intStatus=1 order by country.strCountry;";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"0". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
	if($_SESSION["sys_country"]==$row["intConID"]){
	echo "<option value=\"". $row["intConID"] ."\" selected=\""."selected"."\">" . $row["strCountry"] ."</option>" ;
		}
		else{
		
		echo "<option value=\"". $row["intConID"] ."\">" . $row["strCountry"] ."</option>" ;
	}
	}
		  
					?> 	
						
						
						
						
                        </select>
<img  src="../../images/add.png" width="16" height="16" onclick="showCountryPopUpInSupplier()" class="mouseover" align="absbottom"/></td>
                        <td width="90" >Zip Code</td>
						<?php
							$SQL="SELECT * FROM country WHERE intConID='".$_SESSION["sys_country"]."'";
							$result = $db->RunQuery($SQL);
							while($row = mysql_fetch_array($result))
							{
								$txtZipCode  = $row['strZipCode'];
							}
							
						?>
                        <td><input name="txtZipCode" tabindex="10" type="text" value="<?php echo $txtZipCode ?>" class="txtbox" id="txtZipCode"  style="width:125px" maxlength="15" readonly=""/></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Phone</td>
                        <td width="154"  class="normalfnt"><input tabindex="11" name="txtPhone" value="<?php echo $txtPhone ?>" type="text" class="txtbox" id="txtPhone"  style="width:125px"   maxlength="50"/></td>
                        <td align="left">Fax</td>
                        <td><input name="txtFax" tabindex="12" type="text" value="<?php echo $txtFax ?>" class="txtbox" id="txtFax"   style="width:125px"   maxlength="50"/></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">e-Mail</td>
                        <td colspan="3"><input tabindex="13" name="txtemail" value="<?php echo $txtemail ?>" type="text" class="txtbox" id="txtemail" style="width:377px" maxlength="50"/></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Website</td>
                        <td colspan="3"><input tabindex="14" name="txtweb" value="<?php echo $txtweb ?>" type="text" class="txtbox" id="txtweb" style="width:377px" maxlength="50"/></td>
					  </tr>
					  
					   <tr>
                        <td class="normalfnt">Contact Person</td>
                        <td colspan="3"><input tabindex="15" name="txtContactPerson" type="text" value="<?php echo $txtContactPerson ?>" class="txtbox" id="txtContactPerson"  style="width:377px" maxlength="100"/></td>
                      </tr>
					  
                      <tr>
                        <td class="normalfnt">Currency&nbsp;<span class="compulsoryRed">*</span></td>
                        <td><div id="divCurruncy"><select tabindex="16" name="cbocurrency" class="txtbox" id="cbocurrency" style="width:127px">
							<?php
			$SQL="SELECT CT.intCurID,CT.strCurrency FROM currencytypes CT WHERE CT.intStatus=1 order by CT.strCurrency;";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"0". "" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
	if($cbocurrency==$row["intCurID"]){
	echo "<option value=\"". $row["intCurID"] ."\" selected=\""."selected"."\">" . $row["strCurrency"] ."</option>" ;
		}
		else{
		echo "<option value=\"". $row["intCurID"] ."\">" . $row["strCurrency"] ."</option>" ;
	}
	}
		  
					?> 	
						
						
						
						
                        </select>
<img  src="../../images/add.png" width="16" height="16" onclick="loadNewCurruncy2()" class="mouseover" align="absbottom"/>						  </div></td>
						  
                        <td>Origin&nbsp;<span class="compulsoryRed">*</span></td>
                        <td><select tabindex="17" name="cboorigin" class="txtbox" id="cboorigin" style="width:127px">
                          <?php
		$SQL="SELECT intOriginNo,strDescription FROM itempurchasetype WHERE intStatus=1 order by strDescription;";
		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"0". "" ."\">" . "" ."</option>" ;	
			while($row = mysql_fetch_array($result))
			
	{
	if($cboorigin==$row["intOriginNo"]){
	echo "<option value=\"". $row["intOriginNo"] ."\" selected=\""."selected"."\">" . $row["strDescription"] ."</option>" ;
		}
		else{
		echo "<option value=\"". $row["intOriginNo"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	}	  
				  
				  
				  ?>
                        </select>
                          <img   src="../../images/add.png" width="16" height="16" onclick="showOrigin();" size="1" class="mouseover" align="absbottom"/></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Shipment Mode</td>
                        <td><div id="divShipMode"><select tabindex="18" name="cboshipment" class="txtbox" id="cboshipment" style="width:127px">
                          <option value="0" selected="selected"></option>
                          <?php
	
	$SQL = "SELECT strDescription,intShipmentModeId FROM shipmentmode s where intStatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	if($cboshipment==$row["intShipmentModeId"]){
	echo "<option value=\"". $row["intShipmentModeId"] ."\" selected=\""."selected"."\">" . $row["strDescription"] ."</option>" ;
		}
		else{
	echo "<option value=\"". $row["intShipmentModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	}
	
	?>
                        </select>  <img  src="../../images/add.png" width="16" height="16" onclick="showPopUpShipmentMode()" size="1" class="mouseover" align="absbottom"/></div></td>
                        <td>Shipment Term</td>
                        <td colspan="1"><div id="divShipTerm"><select tabindex="19" name="cboshipmentTerm" class="txtbox" id="cboshipmentTerm" style="width:127px">
                          <option value="0" selected="selected"></option>
                          <?php
	
	$SQL = "SELECT strShipmentTerm,strShipmentTermId FROM shipmentterms s where intStatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	if($cboshipmentTerm==$row["strShipmentTermId"]){
	echo "<option value=\"". $row["strShipmentTermId"] ."\" selected=\""."selected"."\">" . $row["strShipmentTerm"] ."</option>" ;
		}
		else{
	echo "<option value=\"". $row["strShipmentTermId"] ."\">" . $row["strShipmentTerm"] ."</option>" ;
	}
	}
	
	?>
                        </select>  <img  src="../../images/add.png" width="16" height="16" onclick="showShipmentTrmPopUp()" size="1" class="mouseover" align="absbottom"/></div></td>
                        </tr>
                      <tr>
                        <td align="left">Pay Mode</td>
                        <td><div id="divPayMode"><select tabindex="20" name="cbopaymode" class="txtbox" id="cbopaymode" style="width:127px">
                          <?php
	
	$SQL = "SELECT strPayModeId,strDescription FROM popaymentmode p where intstatus='1';";	
	$result = $db->RunQuery($SQL);	
	echo "<option value=\"0". "" ."\">" . "" ."</option>" ;	
	while($row = mysql_fetch_array($result))
	{
/*		if (($row["strPayModeId"] == 8) OR ($cbopaymode==$row["strPayModeId"]))
		{
			echo "<option selected=\"selected\" value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
		else
		{*/
			echo "<option value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	/*	}*/
	}
	
	?>
                        </select> <img  src="../../images/add.png" width="16" height="16" onclick="showPayModePopUp()" size="1" class="mouseover" align="absbottom"/></div></td>
                        <td>Pay Term</td>
                        <td colspan="1"><div id="divPayTerms"><select tabindex="21" name="cbopayterms" class="txtbox" id="cbopayterms" style="width:127px">
                          <?php
	
	$SQL = "SELECT strPayTermId,strDescription FROM popaymentterms p where intStatus='1';";	
	$result = $db->RunQuery($SQL);		
	echo "<option value=\"0". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
/*		if (($row["strPayTermId"] == 3) OR ($cbopayterms==$row["strPayTermId"]))
		{
			echo "<option selected=\"selected\" value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
		else
		{*/
			echo "<option value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
	/*	}*/
	}
	
	?>
                       </select> <img  src="../../images/add.png" width="16" height="16" onclick="showPayTrmPopUp()" size="1" class="mouseover" align="absbottom"/></div></td>
                        </tr>
                      <tr>
                        <td class="normalfnt">Fabric Ref No</td>
                        <td class="normalfnt"><input tabindex="22" name="txtAddinsFabRefNo" value="<?php echo $txtPhone ?>" type="text" class="txtbox" id="txtAddinsFabRefNo"  style="width:125px"   maxlength="30"/></td>
                        <td>AccPacc ID</td>
                        <td><input type="text" name="txtaccPaccId" id="txtaccPaccId" style="width:125px;" maxlength="30" tabindex="23" /></td>
                      </tr>
                      
                      </table></td>
                  </tr>
				  
				  
				  
                <tr>
                  <td class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td width="96">Remarks</td>
                      <td width="80"><textarea tabindex="24" style="width:377px" onchange="imposeMaxValue(this,200);" name="txtremarks" cols="58" rows="2" class="txtbox" id="txtremarks" onkeypress="return imposeMaxLength(this,event, 200);" ><?php echo $txtremarks ?></textarea>					  </td>
                    </tr>
                    <tr>
                      <td valign="top">Key Items</td>
                      <td>
					  <textarea tabindex="25" style="width:377px" onchange="imposeMaxValue(this,100);" name="txtkeyitms" cols="58" rows="2" class="txtbox" id="txtkeyitms" onkeypress="return imposeMaxLength(this,event, 100);" ><?php echo $txtkeyitms ?></textarea></td>
                    </tr>
                  </table></td>
                </tr>
				
				
				
                <tr>
                  <td class="normalfnt"><table width="100%" border="0" class="bcgl1">
					  <tr>
					  <td width="125"></td>
					  <td width="148"></td>
					  <td width="96"></td>
					  <td width="178"></td>
					  <td width="59"></td>
					  </tr>
                    <tr> 						  

                      <td width="125">Tax Enabled</td>
                      <td><input tabindex="26" type="checkbox" name="chktax" id="chktax" <?php if($chktax=='on'){ ?> checked="checked" <?php }?>  onclick="EnableTaxCombo();"/></td>
                      <td align="left">Tax Types</td>
                      <td><div id="divTaxType"><select tabindex="27" name="cbotax" class="txtbox" id="cbotax" style="width:127px" disabled="disabled">
                      <?php
					  $SQL_taxtype="SELECT taxtypes.strTaxTypeID,taxtypes.strTaxType FROM taxtypes where intStatus=1 Order By strTaxType ASC";
					  $result_taxtype = $db->RunQuery($SQL_taxtype);
						
					  echo "<option></option>" ;	
					  while($row = mysql_fetch_array($result_taxtype))
							
					  {
					if($cbotax==$row["strTaxTypeID"]){
					echo "<option value=\"". $row["strTaxTypeID"] ."\" selected=\""."selected"."\">" . $row["strTaxType"] ."</option>" ;
						}
						else{
						echo "<option value=\"". $row["strTaxTypeID"] ."\">" . $row["strTaxType"] ."</option>" ;
					}
					  }
					  ?>
                              </select> <img  src="../../images/add.png" width="16" height="16" onclick="openPopUpTaxType()" size="1" class="mouseover" align="absbottom" id="imgAddTax" style="visibility:hidden" /></div></td>
                    </tr>
                    <tr>
                      <td>Credit Allowed</td>
                      <td><input tabindex="28" type="checkbox" name="chkcredit" id="chkcredit" <?php if($chkcredit=='on'){ ?> checked="checked" <?php }?>  onclick="EnableCreditPeriodCombo();"/></td>
                      <td align="left">Credit Period</td>
                      <td><div id="divCredPeriod"><select tabindex="29" name="cbocredit" class="txtbox" id="cbocredit" style="width:127px" disabled="disabled">
                                            <?php
					  $SQL_creditper="SELECT creditperiods.intSerialNO,creditperiods.strDescription FROM creditperiods where intStatus=1 order by creditperiods.strDescription ";
					  $result_creditper = $db->RunQuery($SQL_creditper);
						
					  echo "<option></option>" ;	
					  while($row = mysql_fetch_array($result_creditper))
					  {
					if($cbocredit==$row["intSerialNO"]){
					echo "<option value=\"". $row["intSerialNO"] ."\" selected=\""."selected"."\">" . $row[	"strDescription"] ."</option>" ;
						}
						else{
						echo "<option value=\"". $row["intSerialNO"] ."\">" . $row["strDescription"] ."</option>" ;
					}
					  }
					  ?>
                              </select> <img  src="../../images/add.png" width="16" height="16" onclick="showCreditPPopUp()" size="1"  class="mouseover" align="absbottom" id="imgAddCreditPeriod" style="visibility:hidden"/></div></td>
                    </tr>
                    <tr>
                      <td>VAT Suspended</td>
                      <td><input tabindex="30" type="checkbox" name="chkvat"  <?php if($chkvat=='on'){ ?> checked="checked" <?php }?> id="chkvat" onclick="handleSVATNo();" /></td>
                      <td>SVAT No </td>
                      <td><input tabindex="31" name="txtSVATNo" type="text" class="txtbox" id="txtSVATNo"  style="width:125px"   maxlength="20" disabled="disabled"/></td>
                    </tr>
                    <tr>
                      <td>Entry No Require</td>
                      <td><input tabindex="26" type="checkbox" name="chkEntryNoRequire" id="chkEntryNoRequire"/></td>
                      <td>VAT No</td>
                      <td><input tabindex="32" name="txtVATNo" type="text" class="txtbox" id="txtVATNo"  style="width:125px"   maxlength="20"/></td>
                    </tr>
                  </table></td>
                </tr>
				
				
				  <tr>
                  <td class="normalfnt"><table width="100%" border="0" class="bcgl1">
				
                <tr>
                  <td class="normalfnt"><table width="100%" border="0">
                    <tr>
                      <td width="120">Supplier Status</td>
                      <td width="22" align="left"><input tabindex="32" name="txtsupplier" value="<?php echo $txtsupplier ?>" type="text"  id="txtsupplier"  style="width:20px" onkeyup="Blacklistreason(this.value);" maxlength="2" onkeypress="return CheckforValidDecimal(this.value, 0,event);"/></td>
                      <td width="461" class="normalfntp2" align="left">1=Best Suppliers | 10=Black Listed Suppliers</td>
                    </tr></table>
					<table width="100%" border="0"  align="center">
					<tr style="display:none" id="reasonBlacklistreason">
					  <td width="43%"></td>
                      <td width="10%" class="normalfnt">Reason</td>
                      <td width="47%" class="normalfnt"><!--<input tabindex="30" type="text" value="<?php echo $txtReason ?>" name="txtReason" id="txtReason" maxlength="100"/>-->
					  <textarea tabindex="33" onchange="imposeMaxValue(this,100);" name="txtReason" cols="33" rows="2" class="txtbox" id="txtReason" onkeypress="return imposeMaxLength(this,event, 100);" ><?php echo $txtReason ?></textarea>
					  </td>
                    </tr></table>
					<table width="100%" border="0" >
                      <tr>
                        <td width="122">Supplier Approved</td>
                        <td width="63" ><input tabindex="33" type="checkbox" <?php if($chksupplier=='on'){ ?> checked="checked" <?php }?> name="chksupplier" id="chksupplier" onclick="supplierApproved();"/>                            </td>
                        <?php
						$user= $_SESSION["UserID"];
						$SQL="SELECT * FROM useraccounts WHERE intUserID='$user'";
						$result =$db->RunQuery($SQL);
						$rowU=mysql_fetch_array($result);
						$userName= $rowU["Name"];
					  ?>
                        <td width="157" class="normalfntp2"  style="display:yes" id="supapp" align="left"><?php
					//hem*  $SQL_creditper="SELECT intUserID,Name FROM useraccounts";
					//hem*  $result_creditper = $db->RunQuery($SQL_creditper);
						
					//hem*  echo "<option value=\"". "" ."\">" . "" ."</option>" ;	
					//hem*  while($row = mysql_fetch_array($result_creditper))
							
					//hem*  {
					
					//	echo "<option value=\"". $user ."\">" . $userName ."</option>" ;
					//hem*  }
					  ?>                        </td> 
                        <td width="262" class="normalfntp2" align="left">Supplier Status should be between 1-10</td>
                      </tr>
                      <tr>
                        <td colspan="4">
						
						
						<table id="ss" <?php if($chksupplier!='on'){ ?>style="display:none" <?php }?> width="100%">
                            <tr>
                              <td width="117">Upload Documents</td>
                              <td width="487" colspan="2" align="left"><!--<input name="docUpload" type="file"  class="normalfnt" id="docUpload" size="50px;">--><img tabindex="34" src="../../images/add.png" width="16" height="16" class="mouseover" onClick="ShowStyleLoader();" align="absbottom">
                                <input type="hidden" id="uploadStatus" name="uploadStatus" value="0" /></td>
                            </tr>
                            <tr>
                              <td width="117">Approved person..</td>
                              <td align="left" colspan="2"><input type="hidden" name="cboSupApp" class="txtbox" id="cboSupApp" style="width:150px" value="<?php echo $_SESSION["UserID"];?>" /><input type="text" tabindex="35" name="txtUsrName" id="txtUsrName" value="<?php echo $userName ?>" readonly="" style="width:120px" />                              </td>
                            </tr>
                            <tr>
                              <td>Comments</td>
                              <td colspan="2"><!--<input type="text"  value="<?php echo $txtApprComments ?>" name="txtApprComments" id="txtApprComments" class="txtbox"  style="width:377px" maxlength="100"/>	--><textarea tabindex="36" onchange="imposeMaxValue(this,200);" name="txtApprComments" cols="58" rows="2" class="txtbox" id="txtApprComments" onkeypress="return imposeMaxLength(this,event, 200);" ><?php echo $txtApprComments ?></textarea></td>
                            </tr>
                            <tr>
                              <td colspan="3"></td>
                            </tr>
                        </table>						</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                      </tr>
                    </table></td>
                </tr>
              </table>            </td>
          </tr>
		   <tr>
			  <td class="normalfnt">
			  	<table width="100%" border="0" class="bcgl1">
					<tr>
                        <td width="124" class="normalfnt">Option 1</td>
                        <td colspan="3"><input tabindex="37" name="txtOption1" type="text" value="<?php echo $txtOption1 ?>" class="txtbox" id="txtOption1"  style="width:377px" maxlength="100"/></td>
                      </tr>
					  <tr>
                        <td class="normalfnt">Option 2</td>
                        <td colspan="3"><input tabindex="38" name="txtOption2" type="text" value="<?php echo $txtOption2 ?>" class="txtbox" id="txtOption2"  style="width:377px" maxlength="100"/></td>
                      </tr>
					  <tr>
                        <td class="normalfnt">Option 3</td>
                        <td colspan="3"><input tabindex="39" name="txtOption3" type="text" value="<?php echo $txtOption3 ?>" class="txtbox" id="txtOption3"  style="width:377px" maxlength="100"/></td>
                    </tr>
				</table>			  </td>
		   </tr>		  
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor=""><table width="10" border="0" class="tableFooter" align="center">
                    <tr>
					<td width="10%"></td>
                      <td width="15%"><img tabindex="44" id="butNew" src="../../images/new.png" alt="New" name="New" onclick="ClearSupplierForm();" class="mouseover" /></td>
                      <td width="15%"><img tabindex="40" id="butSave" src="../../images/save.png" alt="Save" name="Save" onclick="SupplierButCommand(this.name)" class="mouseover" /></td>
                      <td width="15%"><img tabindex="41" id="butDelete" src="../../images/delete.png" alt="Delete" name="Delete" onclick="supplier_ConfirmDelete(this.name)"class="mouseover"  /></td>
			          <td width="15%" class="normalfnt"><img tabindex="42" id="butReport" src="../../images/report.png" alt="Report" border="0" class="mouseover" onclick="SupplierlistORDetails();"  /></td>
                      <td width="20%"><a href="../../main.php"><img tabindex="43" src="../../images/close.png" alt="Close" name="Close" border="0" id="butClose" class="mouseover" /></a></td>
					<td width="10%"></td>
					<td width="10%"></td>
					<td width="10%"></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
		  </table>		  </td>
		  </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<div style="left:405px; top:680px; z-index:10; position:absolute; width: 122px; visibility:hidden; height: 20px;" id="divlistORDetails">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="list" onclick="loadSupplierReport();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="details" onclick="loadSupplierReport();"/></div></td>
  </tr>
  </table>	  
  </div>
  
 <table><tr><td>
 <?php 
	
		 if ($_FILES["docUpload"]["error"] > 0)
			{
			echo "Error: " . $_FILES["docUpload"]["error"] . "<br />";
			die();
			}
	//die();
  //else
   // {
   
		   if($_FILES["docUpload"]["name"]=='')
			die();
   
 
	mkdir("upload/".$fileName, 0700);
	$filename = basename($_FILES['docUpload']['name']);
	$target_path = dirname(__FILE__).'/upload/'.$_POST["cbosearch"].$filename;
	  
	if(move_uploaded_file($_FILES['docUpload']['tmp_name'], $target_path)) {
	echo "The file ". basename( $_FILES['docUpload']['name']).
	" has been uploaded";
	
	//echo "<h1><a href='claim_try.php'>Back to claim page.</a></h1>";
	}
	 else{
	
	echo "There was an error uploading the file, please try again!";
	
	}
	?>
 </td></tr></table>

</div>
<div class="gap"></div>
</div>
</form>
</body>
</html>
