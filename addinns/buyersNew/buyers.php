<?php
$backwardseperator = "../../";
session_start();
$pub_url = "/gaprohela/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Buyers</title>


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

<script src="/gaprohela/addinns/buyers/button.js" type="text/javascript"></script>
<script src="/gaprohela/addinns/buyers/Search.js" type="text/javascript"></script>
<script src="/gaprohela/javascript/script.js" type="text/javascript"></script>

</head>

<body>
<?php
	include "../../Connector.php";	
?>
	
<form id="frmBuyers" name="frmBuyers" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Buyers<span class="vol">(Ver 0.3)</span><span id="buyers_popup_close_button"><!--<img onclick="" align="right" style="visibility:hidden;" src="../../images/cross.png" />--></span></div>
	</div>
	<div class="main_body">
<table width="500" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0" align="center">
      
          <tr>
            <td>
              <table width="100%" border="0" cellpadding="3" cellspacing="0" >
                <tr>
                  <td colspan="2" class="normalfnt "><table width="100%" border="0" align="center" class="tableBorder">
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Search</td>
                      <td colspan="3"><select name="cboAddinsCustomer"  onchange="getCustomerDetails(); LoadBuyerDivisionWindow();" style="width:380px" id="cboAddinsCustomer" tabindex="1">
                        <?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers where intStatus<>10 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". cdata($row["intBuyerID"]) ."\">" . cdata($row["strName"]) ."</option>" ;
	}
	
	?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Buyer Code&nbsp;<span class="compulsoryRed">*</span></td>
                      <td colspan="3">
                      	<input name="txtAddinsBuyerCode" type="text" autocompletetype="Disabled" autocomplete="off" class="txtbox" id="txtAddinsBuyerCode"  style="width:380px" maxlength="20" onkeypress="return checkForTextNumber(this.value, event);" tabindex="2"/>                      </td>
                    </tr>
                    <tr>
                      <td width="38" class="normalfnt">&nbsp;</td>
                      <td width="97" class="normalfnt">Name&nbsp;<span class="compulsoryRed">*</span></td>
                      <td colspan="3"><input name="txtAddinsName" type="text" AutoCompleteType="Disabled" autocomplete="off" class="txtbox" id="txtAddinsName" style="width:380px" maxlength="50" tabindex="3"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Address</td>
                      <td colspan="3"><input name="txtAddinsAddress1" type="text" class="txtbox" id="txtAddinsAddress1"  style="width:380px" maxlength="50" tabindex="4"/></td>
                    </tr>

                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Street</td>
                      <td colspan="3"><input name="txtAddinsStreet" type="text" class="txtbox" id="txtAddinsStreet" style="width:380px" maxlength="50" tabindex="5"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">City</td>
                      <td colspan="3"><input name="txtAddinsCity" type="text" class="txtbox" id="txtAddinsCity" style="width:380px" maxlength="50" tabindex="6"/></td>
                    </tr>
					<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Country&nbsp;<span class="compulsoryRed">*</span></td>
                      <td width="154" >
                      <select name="cboAddinsCountry" tabindex="7" class="txtbox" id="cboAddinsCountry" style="width:127px" onchange="buyer_GetCountryZipCode(this.value);">
                      <?php 
		$SQL="SELECT intConID,strCountry FROM country WHERE country.intStatus=1 order by country.strCountry;";
			
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
	if($_SESSION["sys_country"]==$row["intConID"]){
	echo "<option value=\"". cdata($row["intConID"]) ."\" selected=\""."selected"."\">" . cdata($row["strCountry"]) ."</option>" ;
		}
		else{
		
		echo "<option value=\"". $row["intConID"] ."\">" . cdata($row["strCountry"]) ."</option>" ;
	}
	}
                      ?>
                      	</select> <img  src="../../images/add.png" width="16" height="16" align="absmiddle" class="mouseover" onclick="showCountryPopUpInBuyer()" /></td>
						<?php
							$SQL="SELECT * FROM country WHERE intConID='".$_SESSION["sys_country"]."'";
							$result = $db->RunQuery($SQL);
							while($row = mysql_fetch_array($result))
							{
								$txtZipCode  = $row['strZipCode'];;
							}
							
						?>
                      <td width="67" >Zip Code</td>
                      <td width="190" ><input tabindex="8" name="txtAddinsZipCode" type="text" value="<?php echo $txtZipCode ?>" class="txtbox" readonly="readonly" id="txtAddinsZipCode" style="width:127px" maxlength="15"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
					  <td>Fax</td>
                      <td ><input name="txtAddinsFax" type="text" class="txtbox" id="txtAddinsFax" style="width:127px" maxlength="50" tabindex="9"/></td>
                      
                      <td>State</td>
                      <td><input name="txtAddinsState" type="text" class="txtbox" id="txtAddinsState" style="width:127px" maxlength="30" tabindex="10"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt" >&nbsp;</td>
                      <td class="normalfnt">Phone</td>
                      <td colspan="3"><input name="txtAddinsPhone" type="text" class="txtbox" id="txtAddinsPhone" style="width:380px"  maxlength="50" tabindex="11"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">e-Mail</td>
                      <td colspan="3"><input name="txtAddinsEmail" type="text" class="txtbox" id="txtAddinsEmail" style="width:380px" maxlength="50" tabindex="12"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Web</td>
                      <td colspan="3"><input name="txtAddinsWeb" type="text" class="txtbox" id="txtAddinsWeb" style="width:380px" maxlength="50" tabindex="13"/></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Remarks</td>
                      <td colspan="3">
					<textarea name="txtAddinsRemarks" style="width:380px"  rows="2" class="txtbox" id="txtAddinsRemarks" onkeypress="return imposeMaxLength(this,event, 200);" tabindex="14" ></textarea>					  </td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Agent</td>
                      <td colspan="3"><input name="txtAddinsAgent" type="text" class="txtbox" id="txtAddinsAgent" style="width:380px" maxlength="50" tabindex="15"/></td>
                    </tr>
					<tr>
					  <td class="normalfnt">&nbsp;</td>
					  <td>Actual FOB </td>
					  <td colspan="3">
					    <select name="cboActualFOB" id="cboActualFOB" style="width:380px" >
						<option value="0">PreOrder FOB </option>
						<option value="1">Invoice cost FOB </option>
					      </select>
					  </td>
					  </tr>
					<tr>
					  <td class="normalfnt">&nbsp;</td>
					  <td>Pay Term <span class="compulsoryRed">*</span></td>
					  <td><select name="cboPayTerm" id="cboPayTerm" style="width:127px;">
                      <option value=""></option>
                      <?php 
				$sql = "SELECT strPayTermId,strDescription FROM popaymentterms WHERE intStatus=1 ORDER BY strDescription ";
				$result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					  ?>
                      <option value="<?php echo $row["strPayTermId"]; ?>"><?php echo $row["strDescription"]; ?></option>
                 <?php }?>
					    </select></td>
					  <td colspan="2"><label>Date Format </label>
					  &nbsp;<select name="cboAddinsDtFromat" type="text" class="txtbox" id="cboAddinsDtFromat" style="width:127px" tabindex="17">
						  <?php
						  for($i=0;$i<count($dtFormat);$i++)
						  {?>
						  <option><?php echo $dtFormat[$i]; ?></option>
						  <?php }?>
					  </select>	</td>
					  </tr>
					<tr>
	<!--				<a href="file:///E|/Lasanthaxampp/xampp/htdocs/gapro/"></a>-->
					  <?php
						$xml = simplexml_load_file("{$backwardseperator}config.xml");
						$dtFormat = $xml->addins->buyers->dateFormat;
					?>
					   <td class="normalfnt">&nbsp;</td>
					  <td>Active</td>
                      <td><input type="checkbox" name="chkAddinsActive" id="chkAddinsActive" checked="checked" tabindex="16" /></td>
                      
                      <td colspan="2">				  </td>
                    </tr>
                    
                  </table></td>
                  </tr>
				  <tr>
				  	<td width="100%" colspan="2">
					<!--Buyer division-->
					<table width="100%" border="0" cellpadding="0" cellspacing="3" align="center" class="tableBorder">
						<tr>
					<td width="100%" bgcolor="#498CC2" class="mainHeading2" style="text-align:center;">Buyer Division</td> 
						</tr>
						<tr>
						  <td class="normalfnt">
						  
						  <table width="100%" border="0" class="bcgl1">
					
							<tr>
							  <td width="7%" class="normalfnt">&nbsp;</td>
							  <td width="18%">Name</td>
							  <td width="18%"><input name="txtBDName" type="text" class="txtbox" id="txtBDName"  size="10" maxlength="30" tabindex="18"/></td>
							  <td width="19%"><div align="center">Remarks</div></td>
							  <td width="38%" class="normalfnt"><input name="txtBDRemarks" type="text" class="txtbox" id="txtBDRemarks" size="20" tabindex="19" maxlength="50"/> <img src="<?php echo $pub_url;?>images/add.png" name="" align="absmiddle" class="mouseover" id="" onclick="addDivisions();" /></td>
							</tr>
							<tr>							</tr>
						  </table>						  </td>
						 </tr>
						
						<tr>
						  <td class="normalfnt">                   
						  <div id="divcons" style="overflow:scroll; height:100px; background:#FFFFCC;" class="bcgl1">
							  <table id="mytable" width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" class="bcgl1">
								<?php /*
		$sql="select strDivision from buyerdivisions where buyerCode='$buyerName' order By strDivision";
		$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{*/
		?>
								<!--<tr class="bcgcolor-tblrowWhite">
									<td class="normalfntMid"><input type="checkbox" checked="checked"/></td>
									<td class="normalfnt" ><?php echo $row["strDivision"];?></td>
								</tr>-->
		<?php
		#}
		?>
							  </table>
							</div><div align="center"><div style="left:492px; top:600px; z-index:10; position:static; width: 139px; visibility:hidden; height: 20px;" id="divlistORDetails">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="list" onclick="loadBuyerReport();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="details" onclick="loadBuyerReport();"/></div></td>
  </tr>
  </table>	  
  </div></div></td>
						  </tr>
					  </table>
					<!--End-->					</td>
				  </tr>
              </table>              </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
              <tr>
                <td width="100%" bgcolor=""><table width="100%" border="0" >
                    <tr>
                      <td width="22%"><img src="<?php echo $pub_url;?>images/buying-office.png" alt="buying office" width="121" height="24" name="buying office" onClick="LoadBuyingOfficeWindow();" class="mouseover"/></td>
                      <!--<td width="19%"><img src="../../images/division.png" alt="division" width="105" height="24" name="division" onClick="LoadBuyerDivisionWindow();"/></td>-->
					  <td><img src="<?php echo $pub_url;?>images/new.png" alt="New" name="New" onClick="ClearBuyerForm();" class="mouseover" id="butNew" tabindex="24"/></td>
                      <td width="15%"><img src="<?php echo $pub_url;?>images/save.png" alt="Save" name="save" width="84" height="24" onClick="searchDivisions();" class="mouseover" id="butSave" tabindex="20"/></td>
                      <td width="18%"><img src="<?php echo $pub_url;?>images/delete.png" alt="Delete" name="Delete" width="100" height="24" onClick="ConformDeleteBuyer(this.name)" class="mouseover" id="butDelete" tabindex="21"/></td>
					  					          <td width="12%" class="normalfnt"><img src="<?php echo $pub_url;?>images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover"  onclick="listORDetails(event,this.id);"  id="butReport" tabindex="22"/></td>
                      <td width="26%" id="tdDelete"><a href="<?php echo $pub_url;?>main.php"><img src="<?php echo $pub_url;?>images/close.png" alt="Close" name="Close" width="97" height="24" border="0"  class="mouseover" id="butClose" tabindex="23"/></a></td>
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
</div>
</div>
</form>
</body>
</html>
