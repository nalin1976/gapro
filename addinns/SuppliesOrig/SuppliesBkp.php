<?php
$backwardseperator = "../../";
session_start();
?>
<?php
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
$txtCountry=$_POST["txtCountry"];
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
$txtApprComments=$_POST["txtApprComments"];
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
$txtCountry="";
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
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "../../Header.php";?></td>
  </tr>
  
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="35" bgcolor="#498CC2" class="mainHeading">Supplies</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0">
                <tr>
                  <td class="normalfnt"><table width="100%" border="0" class="bcgl1">
					  <tr>
					  <td width="20%"></td>
					  <td width="28%"></td>
					  <td width="8%"></td>
					  <td width="39%"></td>
					  <td width="5%"></td>
					  </tr>
                      <tr>
                        <td height="22" class="normalfnt">Search</td>
                        <td colspan="3"><select name="cbosearch" class="txtbox" onchange="getSuppliesDetails();"id="cbosearch" style="width:377px">
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
                        <td class="normalfnt" align="right"><img  src="../../images/refresh.png" size="1" onclick="getRefresh('cbocurrency','cboshipment','cboshipmentTerm','cbopaymode','cbopayterms','cbotax','cbocredit','divCurruncy','divShipMode','divShipTerm','divPayMode','divPayTerms','divTaxType','divCredPeriod','getRefreahedPage.php')" title="Refrsh page" /></td>
                        </tr>
                      <tr>
                        <td class="normalfnt">VAT reg. no</td>
                        <td><input name="txtvatrn" type="text" class="txtbox" id="txtvatrn" size="21" value="<?php echo $txtvatrn ?>" /></td>
                        <td><div align="right">Code</div></td>
                        <td colspan="1"><input name="txtSupplierCode" id="txtSupplierCode" type="text" class="txtbox"   value="<?php echo $txtSupplierCode ?>" size="21" /></td>
						<td></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Company Name</td>
                        <td colspan="3"><input name="txtcompany" type="text" class="txtbox"   value="<?php echo $txtcompany ?>" style="width:377px" /></td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Address</td>
                        <td colspan="3"><input name="txtaddress1" type="text" value="<?php echo $txtaddress1 ?>" class="txtbox" id="txtaddress1" style="width:377px" /></td>
                        <td class="normalfnt">&nbsp;</td>
			          </tr>
                      <tr>
                        <td class="normalfnt">&nbsp;</td>
                        <td colspan="3"><input name="txtaddress2" type="text" value="<?php echo $txtaddress2 ?>" class="txtbox" id="txtaddress2" style="width:377px" /></td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
					  <tr>
                        <td class="normalfnt">Option 1</td>
                        <td colspan="3"><input name="txtOption1" type="text" value="<?php echo $txtOption1 ?>" class="txtbox" id="txtOption1"  style="width:377px" /></td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
					  <tr>
                        <td class="normalfnt">Option 2</td>
                        <td colspan="3"><input name="txtOption2" type="text" value="<?php echo $txtOption2 ?>" class="txtbox" id="txtOption2"  style="width:377px" /></td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
					  <tr>
                        <td class="normalfnt">Option 3</td>
                        <td colspan="3"><input name="txtOption3" type="text" value="<?php echo $txtOption3 ?>" class="txtbox" id="txtOption3"  style="width:377px" /></td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
					  <tr>
                        <td class="normalfnt">Contact Person</td>
                        <td colspan="3"><input name="txtContactPerson" type="text" value="<?php echo $txtContactPerson ?>" class="txtbox" id="txtContactPerson"  style="width:377px" /></td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Street</td>
                        <td colspan="3"><input name="txtstreet" type="text" value="<?php echo $txtstreet ?>" class="txtbox" id="txtstreet"  style="width:377px" /></td>
                        <td class="normalfnt">&nbsp;</td>
                        </tr>
                      <tr>
                        <td class="normalfnt">City</td>
                        <td class="normalfnt"><input name="txtCity" type="text" class="txtbox" value="<?php echo $txtCity ?>" id="txtCity" size="21" /></td>
                        <td align="right">State</td>
                        <td><input name="txtState" type="text" class="txtbox" id="txtState" value="<?php echo $txtState ?>" size="21" /></td>
                        <td>&nbsp;</td>
                        </tr>
                      <tr>
                        <td class="normalfnt">Country</td>
                        <td class="normalfnt"><input name="txtCountry" type="text" value="<?php echo $txtCountry ?>" class="txtbox" id="txtCountry" size="21" /></td>
                        <td align="right">Zip Code</td>
                        <td><input name="txtZipCode" type="text" value="<?php echo $txtZipCode ?>" class="txtbox" id="txtZipCode" size="21" /></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Phone</td>
                        <td class="normalfnt"><input name="txtPhone" value="<?php echo $txtPhone ?>" type="text" class="txtbox" id="txtPhone" size="21" /></td>
                        <td align="right">Fax</td>
                        <td><input name="txtFax" type="text" value="<?php echo $txtFax ?>" class="txtbox" id="txtFax" size="21" /></td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt">e-Mail</td>
                        <td colspan="3"><input name="txtemail" value="<?php echo $txtemail ?>" type="text" class="txtbox" id="txtemail" style="width:377px" /></td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Website</td>
                        <td colspan="3"><input name="txtweb" value="<?php echo $txtweb ?>" type="text" class="txtbox" id="txtweb" style="width:377px" /></td>
                        <td class="normalfnt">&nbsp;</td>
					  </tr>
                      <tr>
                        <td class="normalfnt">Currency</td>
                        <td><div id="divCurruncy"><select name="cbocurrency" class="txtbox" id="cbocurrency" style="width:100px">
							<?php
			$SQL="SELECT currencytypes.strCurrency,currencytypes.strTitle,currencytypes.dblRate FROM currencytypes WHERE (((currencytypes.intStatus)=1));";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	
	while($row = mysql_fetch_array($result))
	{
	if($cbocurrency==$row["strCurrency"]){
	echo "<option value=\"". $row["strCurrency"] ."\" selected=\""."selected"."\">" . $row["strCurrency"] ."</option>" ;
		}
		else{
		echo "<option value=\"". $row["strCurrency"] ."\">" . $row["strCurrency"] ."</option>" ;
	}
	}
		  
					?> 	
						
						
						
						
                        </select>
                          <img  src="../../images/addmark.png" size="1" onclick="openr('currency')" /></div></td>
						  
                        <td align="right">Origin</td>
                        <td><select name="cboorigin" class="txtbox" id="cboorigin" style="width:100px">
						                <?php
		$SQL="SELECT intOriginNo,strOriginType FROM itempurchasetype WHERE intStatus=1;";
		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;	
			while($row = mysql_fetch_array($result))
			
	{
	if($cboorigin==$row["strOriginType"]){
	echo "<option value=\"". $row["strOriginType"] ."\" selected=\""."selected"."\">" . $row["strOriginType"] ."</option>" ;
		}
		else{
		echo "<option value=\"". $row["strOriginType"] ."\">" . $row["strOriginType"] ."</option>" ;
	}
	}	  
				  
				  
				  ?>
						
						
						
                        </select>                          </td>
                        </td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Shipment Mode</td>
                        <td><div id="divShipMode"><select name="cboshipment" class="txtbox" id="cboshipment" style="width:100px">
                          <option value="0" selected="selected">Select One</option>
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
                        </select>  <img  src="../../images/addmark.png" size="1" onclick="openr('shipment')" /></div></td>
                        <td align="right">Shipment Term</td>
                        <td colspan="1"><div id="divShipTerm"><select name="cboshipmentTerm" class="txtbox" id="cboshipmentTerm" style="width:100px">
                          <option value="0" selected="selected">Select One</option>
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
                        </select>  <img  src="../../images/addmark.png" size="1" onclick="openr('shipmentTerms')" /></div></td>
                        <td class="normalfnt">&nbsp;</td>
                        </tr>
                      <tr>
                        <td class="normalfnt">Pay mode</td>
                        <td><div id="divPayMode"><select name="cbopaymode" class="txtbox" id="cbopaymode" style="width:100px">
                          <?php
	
	$SQL = "SELECT strPayModeId,strDescription FROM popaymentmode p where intstatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if (($row["strPayModeId"] == 8) OR ($cbopaymode==$row["strPayModeId"]))
		{
			echo "<option selected=\"selected\" value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
	}
	
	?>
                        </select> <img  src="../../images/addmark.png" size="1" onclick="openr('payMode')" /></div></td>
                        <td align="right">Pay Terms</td>
                        <td colspan="1"><div id="divPayTerms"><select name="cbopayterms" class="txtbox" id="cbopayterms" style="width:100px">
                          <?php
	
	$SQL = "SELECT strPayTermId,strDescription FROM popaymentterms p where intStatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if (($row["strPayTermId"] == 3) OR ($cbopayterms==$row["strPayTermId"]))
		{
			echo "<option selected=\"selected\" value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
	}
	
	?>
                        </select> <img  src="../../images/addmark.png" size="1" onclick="openr('payTerms')" /></div></td>
                        <td class="normalfnt">&nbsp;</td>
                        </tr>
                      <tr>
                        <td class="normalfnt">&nbsp;</td>
                        <td class="normalfnt">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      </table></td>
                  </tr>
				  
				  
				  
                <tr>
                  <td class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td width="19%">Remarks</td>
                      <td width="81%"><input name="txtremarks" value="<?php echo $txtremarks ?>" type="text" class="txtbox" id="txtremarks"  style="width:377px"/></td>
                    </tr>
                    <tr>
                      <td valign="top">Key Items</td>
                      <td><input name="txtkeyitms" value="<?php echo $txtkeyitms ?>" type="text" class="txtbox" id="txtkeyitms" size="61" style="height:50px"/></td>
                    </tr>
                  </table></td>
                </tr>
				
				
				
                <tr>
                  <td class="normalfnt"><table width="100%" border="0" class="bcgl1">
					  <tr>
					  <td width="20%"></td>
					  <td width="20%"></td>
					  <td width="15%"></td>
					  <td width="35%"></td>
					  <td width="10%"></td>
					  </tr>
                    <tr> 						  

                      <td>Tax Enabled</td>
                      <td><input type="checkbox" name="chktax" id="chktax" <?php if($chktax=='on'){ ?> checked="checked" <?php }?>  /></td>
                      <td align="right">Tax Types</td>
                      <td><div id="divTaxType"><select name="cbotax" class="txtbox" id="cbotax" style="width:100px">
                      <?php
					  $SQL_taxtype="SELECT taxtypes.strTaxTypeID,taxtypes.strTaxType FROM taxtypes";
					  $result_taxtype = $db->RunQuery($SQL_taxtype);
						
					  echo "<option value=\"". "" ."\">" . "" ."</option>" ;	
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
                              </select> <img  src="../../images/addmark.png" size="1" onclick="openr('taxType')" /></div></td>
                    </tr>
                    <tr>
                      <td>Credit Allowed</td>
                      <td><input type="checkbox" name="chkcredit" id="chkcredit" <?php if($chkcredit=='on'){ ?> checked="checked" <?php }?> /></td>
                      <td align="right">Credit Period</td>
                      <td><div id="divCredPeriod"><select name="cbocredit" class="txtbox" id="cbocredit" style="width:100px">
                                            <?php
					  $SQL_creditper="SELECT creditperiods.intSerialNO,creditperiods.strDescription FROM creditperiods";
					  $result_creditper = $db->RunQuery($SQL_creditper);
						
					  echo "<option value=\"". "" ."\">" . "" ."</option>" ;	
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
                              </select> <img  src="../../images/addmark.png" size="1" onclick="openr('creditPeriod')" /></div></td>
                    </tr>
                    <tr>
                      <td>VAT Suspended</td>
                      <td><input type="checkbox" name="chkvat"  <?php if($chkvat=='on'){ ?> checked="checked" <?php }?> id="chkvat" /></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
				
				
				  <tr>
                  <td class="normalfnt"><table width="100%" border="0" class="bcgl1">
				
                <tr>
                  <td class="normalfnt"><table width="100%" border="0">
                    <tr>
                      <td width="20%">Supplier Status</td>
                      <td width="5%" align="left"><input name="txtsupplier" value="<?php echo $txtsupplier ?>" type="text"  id="txtsupplier" size="3" onkeyup="Blacklistreason();"/></td>
                      <td width="75%" class="normalfntp2" align="left">1=Best Suppliers | 10=Black Listed Suppliers</td>
                    </tr></table>
					<table width="100%" border="0"  align="center">
					<tr style="display:none" id="reasonBlacklistreason">
					  <td width="63%"></td>
                      <td class="normalfnt">Reason</td>
                      <td class="normalfnt"><input type="text" value="<?php echo $txtReason ?>" name="txtReason" id="txtReason" /></td>
                    </tr></table>
					<table width="100%" border="0" >
                      <tr>
                        <td width="16%">Supplier Approved</td>
                        <td width="8%" align="left"><input type="checkbox" <?php if($chksupplier=='on'){ ?> checked="checked" <?php }?> name="chksupplier" id="chksupplier" onclick="supplierApproved();"/>
                            </td>
                        <?php
						$user= $_SESSION["UserID"];
						$SQL="SELECT * FROM useraccounts WHERE intUserID='$user'";
						$result =$db->RunQuery($SQL);
						$rowU=mysql_fetch_array($result);
						$userName= $rowU["Name"];
					  ?>
                        <td width="22%" class="normalfntp2"  style="display:yes" id="supapp" align="left"><?php
					//hem*  $SQL_creditper="SELECT intUserID,Name FROM useraccounts";
					//hem*  $result_creditper = $db->RunQuery($SQL_creditper);
						
					//hem*  echo "<option value=\"". "" ."\">" . "" ."</option>" ;	
					//hem*  while($row = mysql_fetch_array($result_creditper))
							
					//hem*  {
					
					//	echo "<option value=\"". $user ."\">" . $userName ."</option>" ;
					//hem*  }
					  ?>                        </td> 
                        <td width="38%" class="normalfntp2" align="left">Supplier Status should be between 1-10</td>
                      </tr>
                      <tr>
                        <td colspan="4"><table id="ss" <?php if($chksupplier!='on'){ ?>style="display:none" <?php }?> width="100%">
                            <tr>
                              <td>Upload File</td>
                              <td align="left" colspan="2"><input name="docUpload" type="file"  class="normalfnt" id="docUpload" size="50px;"><img src="../../images/revise.png" width="115" height="24" class="mouseover" onClick="PageSubmit();"><input type="hidden" id="uploadStatus" name="uploadStatus" value="0" /></td>
                            </tr>
                            <tr>
                              <td>Approved person. . . .</td>
                              <td align="left" colspan="2"><input type="hidden" name="cboSupApp" class="txtbox" id="cboSupApp" style="width:150px" value="<?php echo $_SESSION["UserID"] ?>" /><input type="text" name="txtUsrName" id="txtUsrName" value="<?php echo $userName ?>" readonly="" style="width:120px" />                              </td>
                            </tr>
                            <tr>
                              <td>Comments</td>
                              <td colspan="2"><input type="text"  value="<?php echo $txtApprComments ?>" name="txtApprComments" class="txtbox"
							   id="txtApprComments"  style="width:377px" /></td>
                            </tr>
                            <tr>
                              <td colspan="3"><?php 
	
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
	?></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
            </td>
          </tr>
		  
		  </table>
		  </td>
		  </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor=""><table width="100%" border="0" class="tableFooter">
                    <tr>
                      <td width="11%">&nbsp;</td>
                      <td width="20%"><img src="../../images/new.png" alt="New" name="New" onclick="ClearForm();"width="96" height="24" /></td>
                      <td width="19%"><img src="../../images/save.png" alt="Save" name="Save" onclick="butCommand(this.name)" width="84" height="24" /></td>
                      <td width="22%"><img src="../../images/delete.png" alt="Delete" name="Delete" onclick="ConfirmDelete(this.name)"width="100" height="24" /></td>
			          <td width="12%" class="normalfnt"><img src="../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="listORDetails();"  /></td>
                      <td width="17%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                      <td width="11%">&nbsp;</td>
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

<div style="left:570px; top:778px; z-index:10; position:absolute; width: 122px; visibility:hidden; height: 20px;" id="divlistORDetails">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="list" onclick="loadReport();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="details" onclick="loadReport();"/></div></td>
  </tr>
  </table>	  
  </div>
</form>
</body>
</html>
