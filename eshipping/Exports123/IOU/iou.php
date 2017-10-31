<?php
	session_start();
	

	include("../../Connector.php");
	$backwardseperator = "../../";
	$companyID=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Import Cusdec</title>

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}

-->
</style>

<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="cusdec.js" type="text/javascript"></script>
<script src="cusdecdescription.js" type="text/javascript"></script>
<script src="iou.js" type="text/javascript"></script>
<script src="search.js" type="text/javascript"></script>

<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
</head>
<?php
$xml = simplexml_load_file('../../config.xml');
$Declarant = $xml->companySettings->Declarant; 
$Destination = $xml->companySettings->Country; 
?>
<?php
$country="";
$sqlcountry="SELECT strCountryCode,strCountry FROM country ORDER BY strCountry";
$result_country=$db->RunQuery($sqlcountry);
		$country .= "<option value=\"".""."\">".""."</option>";		
	while($row_country=mysql_fetch_array($result_country))
	{
		$country .= "<option value=\"".$row_country["strCountryCode"]."\">".$row_country["strCountry"]."</option>";
	} 
?>

<body>
<form name="frmFabricIns" id="frmFabricIns" >
<table width="950" border="0" align="center" bgcolor="#FFFFFF" cellspacing="0">
<tr>
    <td><?php include '../../Header.php'; 
 ?></td>
</tr>
  <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white" style="text-align:center">&nbsp;EXPORT IOU </td>
    </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	<tr class="bcgl1txt1NB">
	  <td>
    
			
			
			
			  <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                <tr >
                  <td width="100%" height="101"   colspan="2">
                      <table width="114%"  border="0" cellpadding="0" cellspacing="0">
                        <tr class="tablezRED">
                          <td width="3%" height="33" ><div  class="normalfnBLD1">
                            <table width="349" height="31"  cellpadding="0" cellspacing="0">
                              <tr class="normalfnt">
                                <td width="115" height="29" class="border-top-bottom-left-fntsize12"><div align="center" class="normalfnt2bldBLACK" >Search IOU</div></td>
                                <td width="202" class="border-top-bottom-right-fntsize12"><select name="cboInvoice" style="width:200px" id="cboInvoice" class="txtbox" onchange="LoadExpenceType();">
                                  <?php
$sqliounosearch="select intIOUNo,strInvoiceNo from tblexiouheader ";
$result_iounumber=$db->RunQuery($sqliounosearch);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_iounumber=mysql_fetch_array($result_iounumber))
	{
		echo "<option value=\"".$row_iounumber["intIOUNo"]."\">".$row_iounumber["intIOUNo"]."-->".$row_iounumber["strInvoiceNo"]."</option>";
	}
?>
                                </select></td>
                              </tr>
                            </table>
                            </div>
                          <div align="left"></div></td>
                          <td width="12%" height="33" >&nbsp;</td>
                          <td width="6%" height="33" >&nbsp;</td>
                          <td width="12%" height="33" >&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="39" colspan="4"  class="normalfnt"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr><td width="1%">&nbsp;</td>
                              <td width="10%" class="normalfnt">Invoice No </td>
                              <td width="15%" class="normalfnt"><select name="cboInvoiceNo" style="width:110px" onchange="LoadExpenceType();" id="cboInvoiceNo" class="txtbox">
                                <?php
									$sqlinvoice="select strInvoiceNo from exportcusdechead where intStatus=1";
									$resultinvno=$db->RunQuery($sqlinvoice);
									echo "<option value=\"".""."\">".""."</option>";
	while($row_invoice=mysql_fetch_array($resultinvno))
	{
		echo "<option value=\"".$row_invoice["strInvoiceNo"]."\">".$row_invoice["strInvoiceNo"]."</option>";
	}
?>
                              </select></td>
                              <td colspan="2" width="10%" class="normalfnt">IOU No </td>
                          <td width="15%" class="normalfnt"><input name="txtIOUNo" style="text-align:right" type="text" class="txtbox" id="txtIOUNo" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" disabled="disabled" value="<?php $striouno='select dblExportIOUNo+1 as iouno from  syscontrol';
		$iounoresult=$db->RunQuery($striouno);
		$row=mysql_fetch_array($iounoresult);
		echo $row['iouno'];
		 ?> "/></td>
                          <td width="10%" class="normalfnt">Exporter</td>
                          <td width="15%" class="normalfnt"><select name="cboSearchConsignee" style="width:110px" id="cboSearchConsignee" class="txtbox" >
                            
                          </select></td>
                          <td width="10%" class="normalfnt">Consignee</td>
                          <td width="15%" class="normalfnt"><select name="cboBuyer" style="width:110px" id="cboBuyer" class="txtbox" >
                          
                          </select></td>
                            </tr>
                          </table></td>
                        </tr>
                    </table>
                  
                  <p></p></td>
                </tr>
              </table>
			</div>
			<div id="tabs-4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="44%" bgcolor="#9BBFDD" class="head1"><div align="right">I O U - </div></td>
        <td width="45%" bgcolor="#9BBFDD" id="tdIouNo" class="head1">&nbsp;<?php 
		echo " ".$row["iouno"];
		 ?></td>
        <!--<td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>-->
      </tr>
      <tr>
        <td height="258" colspan="3" class="normalfnt">
		
		<table width="100%" height="258" class="bcgl1">
		<tr>
		<td  height="252" style="width:900px" ><div id="selectitem" style="overflow:scroll;height:250px;width:930px" ><table id="tblIou" width="900" cellpadding="0" cellspacing="1" class="bcgl1">
          <tr>
            <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
            <td width="2%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">No</td>
            <td width="34%" bgcolor="#498CC2" class="normaltxtmidb2">Expenses Type</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Estimate</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Actual</td>
            <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">variance</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">invoice</td>
            </tr>
		  </table></div></td>
		<td width="10" >&nbsp;</td>
		</tr>
		</table>
			</td>
        </tr>
		<tr><td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         
          <tr>
            <td width="6%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="6%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="9%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="6%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="8%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="17%" bgcolor="#D6E7F5"><img src="../../images/print.png" alt="new" name="butIouPrint" width="115" height="24" class="mouseover"  id="butIouPrint" onclick="PrintIOU();"/></td>
            <td width="13%" bgcolor="#D6E7F5"><img src="../../images/save.png" alt="new" name="butIouSave" width="84" height="24" class="mouseover"  id="butIouSave" onclick="SaveIOU();"/></td>
            <td width="11%" bgcolor="#D6E7F5"><img src="../../images/close.png" alt="new" name="butNew" width="97" height="24" class="mouseover"  id="butNew" onclick="ClearForm();"/></td>
            <td width="24%" bgcolor="#D6E7F5">&nbsp;</td>
          </tr>
        </table></td></tr>
    </table>
			</td>
		</tr>
		
    </table></td>
  </tr>
  
</table>
</form>


<!--Start - Search popup--><!--End - Search popup-->
<!--Start - Unit Conversion-->
<div style="left:90px; top:252px; z-index:10; position:absolute; width: 350px; visibility:hidden; height: 130px;" id="unitConversion">
<!--End - Unit Conversion-->

</body>
</html>