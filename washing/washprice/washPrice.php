<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php"; 	  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>Wash Price</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="washPrice-java.js" type="text/javascript"></script>
<script src="washprice_outside.js" type="text/javascript"></script>

<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
</head>

<body onload="loadDryProcess();">

<form id="washPrice" name="washPrice" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<!--<div class="main_bottom_center">
	<div class="main_top"><div class="main_text">Wash Price</div></div>
<div class="main_body">-->
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder"> 
    <tr>
        <td class="mainHeading"> Wash Price </td>
    </tr>
  <tr>
    <td>
  <table width="950" border="0" align="center" cellpadding="0" cellspacing="0" class="normalfnt">
    <tr>
      <td width="526" height="28" bgcolor="#FFFFFF"><table width="266" height="30" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="95"><input name="InOrOut" type="radio" id="radioCat" value="0" checked="checked" onclick="loadWashPriceTypeData(this);"/>
              In House </td>
            <td width="92"><input name="InOrOut" type="radio" id="radioCat" value="1"  onclick="loadWashPriceTypeData(this);" />
              Out Side </td>
              <td width="58"><input type="hidden" name="proFinshRecComId" id="proFinshRecComId" value="" /></td>
          </tr>
      </table></td>
      <td width="406" ><div align="center" class="boldfnt11px" style="color:#316895;">Dry Process Description </div></td>
    </tr>
    <tr>
      <td height="57"><fieldset class="fieldsetStyle" style="width:500px;-moz-border-radius: 5px;">
      <table width="510" border="0">
        <tr>
          <td width="89"></td>
          <td width="154"></td>
          <td width="81"></td>
          <td width="158"></td>
        </tr>
        <tr>
          <td>PO No. <span class="compulsoryRed">*</span> </td>
          <td colspan="0"><select name="cboPoNo" class="txtbox" id="cboPoNo" style="width:150px" onchange="loadHeaderInfo();"> 

		<?php
		
		/*$SQL="SELECT orders.intStyleId,orders.strOrderNo FROM orders WHERE intStyleId  NOT IN ( SELECT orders.intStyleId
              FROM  orders INNER JOIN 
              was_washpriceheader ON orders.intStyleId = was_washpriceheader.intStyleId) order by orders.strOrderNo ";*/
		/*$SQL="SELECT DISTINCT
				orders.strOrderNo,
				orders.intStyleId
				FROM
				was_issuedtowashheader
				Inner Join orders ON was_issuedtowashheader.intStyleNo = orders.intStyleId
				WHERE orders.intStyleId  NOT IN ( SELECT orders.intStyleId
				FROM  orders INNER JOIN 
				was_washpriceheader ON orders.intStyleId = was_washpriceheader.intStyleId) order by orders.strOrderNo;";*/
				/*$SQL="select distinct wst.intStyleId,o.strOrderNo from was_stocktransactions wst 
inner join orders o on o.intStyleId=wst.intStyleId
where  wst.intStyleId 
not in (select intStyleId from was_washpriceheader) order by o.strOrderNo;";*/

//21-06-2011
//wst.strType='IWash' and 
// changed due to pro. flow
// Special Requesition for mr.sandun and manjula 

	$SQL="SELECT DISTINCT
o.strOrderNo,
o.intStyleId,
o.intStatus
FROM
orders AS o
WHERE
o.intStyleId NOT IN (select intStyleId from was_washpriceheader)
-- AND o.intStatus='11'
order by o.strOrderNo";

			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			}
	
 	    ?>
 </select></td>
          <td>Color</td>
          <td colspan="0"><select name="cboColor" class="txtbox" id="cboColor" style="width:150px"> 

		<?php
		//echo "<option value=\"".""."\">" .""."</option>";
		/*
		$SQL="SELECT  DISTINCT strColor,intStyleId from styleratio ORDER BY strColor";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\""."0"."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strColor"]."</option>";
			}
	     */
 	    ?>
 </select></td>
        </tr>
        <tr>
          <td>Style Name <span class="compulsoryRed">*</span></td>
          <td colspan="0"><select name="cboStyleName" class="txtbox" id="cboStyleName" style="width:150px"> 

		<?php
		//echo "<option value=\"".""."\">" .""."</option>";
		/*
		$SQL="SELECT  intStyleId,strDescription from orders ORDER BY strDescription";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\""."0"."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strDescription"]."</option>";
			}
	*/
 	    ?>
 </select></td>
          <td>Style No </td>
          <td><input type="text" name="txtStyleNo" id="txtStyleNo" class="txtbox" style="width:148px" readonly="readonly"/></td>
        </tr>
        <tr>
          <td>Wash Income<span class="compulsoryRed">*</span></td>
          <td><input type="text" name="txtWashIncome" id="txtWashIncome" class="txtbox" onkeypress="return CheckforValidDecimal(this.value, 3,event);" style="width:148px;text-align:right;"  maxlength="10" onchange="checkLastDecimal(this);" onkeyup="checkfirstDecimal(this);"/>
          </td>
          <td rowspan="2">Fabric Des </td>
          <td rowspan="2"><textarea name="txtFabricDes" id="txtFabricDes"  class="txtbox" value="" style="height:40px;width:148px;" disabled="disabled" ></textarea></td>
        </tr>
        <tr>
          <td>Wash Cost <span class="compulsoryRed">*</span></td>
          <td><input name="txtWashCost" type="text" class="txtbox" id="txtWashCost" onkeypress="return CheckforValidDecimal(this.value, 3,event);" style="width:148px;text-align:right;" maxlength="10" onchange="checkLastDecimal(this);" onkeyup="checkfirstDecimal(this);"/></td>
        </tr>
        <tr>
          <td>Wash Type <span class="compulsoryRed">*</span></td>
          <td colspan="0"><select name="cboWashType" class="txtbox" id="cboWashType" style="width:150px"> 

		<?php
		
		$SQL="SELECT  intWasID,strWasType from was_washtype ORDER BY strWasType";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intWasID"]."\">".$row["strWasType"]."</option>";
			}
	
 	    ?>
 </select></td>
 
          <td rowspan="2">Factory</td>
          <td rowspan="2"><textarea name="txtFactory" class="txtbox" id="txtFactory" value="" style="height:40px;width:148px;" disabled="disabled" > </textarea>
          <input type="hidden" id="fac"  />
          </td>
        </tr>
        <tr>
          <td>Garment <span class="compulsoryRed">*</span></td>
          <td colspan="0"><select name="cboGmtType" class="txtbox" id="cboGmtType" style="width:150px"> 

		<?php
		
		$SQL="SELECT DISTINCT productcategory.intCatId,productcategory.strCatName FROM productcategory WHERE productcategory.intStatus =  '1' ORDER BY strCatName";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intCatId"]."\">".$row["strCatName"]."</option>";
			}
	
 	    ?>
 </select></td>
        </tr>
        <tr height="5">
          <td></td>
        </tr>
      </table>
      </fieldset></td>
      <td valign="top"><fieldset style="width:200px;-moz-border-radius: 5px;" class="fieldsetStyle">
      <div id="txtemp"  style="overflow:scroll; width:400px; height:143px;">
        <table width="380" border="0" cellpadding="0" cellspacing="1" id="tblDryPro" bgcolor="">
          <tr  class="grid_header">

            <td width="3%" height="30" class="grid_header">Select</td>
            <td width="50%" class="grid_header">Description</td>
            <td width="12%" class="grid_header">Wash Price </td>
          </tr>
        </table>
      </div>
      </fieldset></td>
    </tr>
    <tr>
      <td height="35"><table width="511" border="0">
          <tr>
            <td width="99"><div align="center">PO No. Like </div></td>
            <td width="153"><input type="text" name="poNoLike" id="poNoLike" class="txtbox" onkeyup="enter(event);" style="width:148px"/></td>
            <td width="103" style="display:none;"><input name="poAvable" type="radio" id="poAvable" value="1" checked="checked" style="display:none;"/>
              PO Available </td>
            <td width="138" style="display:none;"><input name="poAvable" type="radio" id="poAvable" value="0" style="display:none;"/>
              PO Not Available</td>
          </tr>
      </table></td>
      <td><table align="center" border="0"><tr><td><img src="../../images/new.png" alt="new" width="84" height="24" border="0" onclick="refreshPage();"/>
	  <img src="../../images/save.png" alt="save" width="84" height="24" border="0" onclick="saveWashPriceHeader();"/>
	  <img src="../../images/report.png" alt="print" width="84" height="24" border="0" onclick="printPoAvailable();" />
	  <a href="../../main.php"><img src="../../images/close.png" alt="close" width="84" height="24" border="0"/></a></td></tr></table></td>
    </tr>
    <tr>
      <td height="30" colspan="2"><fieldset style="width:930px;"class="fieldsetStyle">
      <div id="div"  style="overflow:scroll; width:930px; height:200px;">
        <table width="1000" border="0" cellpadding="0" cellspacing="1" id="tblWashPriceGrid" bgcolor="">
          <tr  class="normalfntWhiteText">
		    <td width="30" height="30" class="grid_header">Edit</td>
            <td width="49" height="30" class="grid_header">In/Out</td>
            <td width="109" class="grid_header">PO No.</td>
            <td width="94" class="grid_header">Style No.</td>
            <td width="124" class="grid_header">Style Name</td>
            <td width="97" class="grid_header">Wash Income</td>
            <td width="67" class="grid_header">Cost Price</td>
            <td width="90" class="grid_header">Garment</td>
            <td width="114" class="grid_header">Wash Type</td>
            <td width="130" class="grid_header">Color</td>
          </tr>
        </table>
      </div>
      </fieldset></td>
    </tr>
  </table>  
    </td>  
  </tr>
</table>
<!--	</div>
 </div>-->
</form>
</body>
</html>
