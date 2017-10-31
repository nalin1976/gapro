<?php
	session_start();
	include "../Connector.php";	
	$companyId = $_SESSION["FactoryID"];
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Bulk Stock Transfer</title>
<script type="text/javascript" src="bulkStockTrans.js"></script>
<script type="text/javascript" src="../javascript/script.js"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
</head>

<body >
<form id="frmStyleStockAdjestment" name="frmStyleStockAdjestment">
<tr>
<td><?php include '../Header.php'; ?></td>
</tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td height="26" class="mainHeading">Bulk Stock Transfer</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">      	
		<tr>
			<td><table width="100%" border="0" cellspacing="1" cellpadding="0" class="tableBorder">
              <tr>
                <td width="7%"><span class="normalfnt">&nbsp;No</span></td>
                <td width="17%"><input  type="text" name="txtSerialNo" class="txtbox" id="txtSerialNo" style="width:80px" disabled="disabled"/></td>
                <td width="6%">&nbsp;</td>
                <td width="17%"><img src="../images/view.png" alt="view" align="absbottom" onclick="SearchPopUp();" style="visibility:hidden" /></td>
                <td width="10%">&nbsp;</td>
                <td width="11%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
              </tr>
              <tr>
                <td><span class="normalfnt">&nbsp;Style No</span></td>
                <td><select class="txtbox" id="cboStyleNo" style="width:150px" onchange="LoadOrderAndSc(this);" tabindex="1">
                  <?php
	$sql="select distinct strStyle from orders where intStatus =11 order by strStyle";
	$result=$db->RunQuery($sql);
		echo "<option value=\"".""."\">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value =\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
	}
?>
                </select></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><span class="normalfnt">Main Store </span></td>
                <td><select name="cboMainCategory" class="txtbox" id="cboMainCategory" style="width:285px" onchange="LoadSubStore(this);" tabindex="4">
                  <?PHP		
$sql="select strMainID,strName from mainstores where intStatus=1 and intCompanyId=$companyId order by strName";	 
$result =$db->RunQuery($sql);
	echo "<option value =\"".""."\">"."Select One"."</option>";
while ($row=mysql_fetch_array($result))
{		
	echo "<option value=\"".$row["strMainID"]."\">".$row["strName"]."</option>";
}
?>
                </select></td>
              </tr>
              <tr>
                <td><span class="normalfnt">&nbsp;Order No</span></td>
                <td><select class="txtbox" id="cboOrderNo" style="width:150px" onchange="SetScNo(this);LoadOrderDetails(this);" tabindex="2">
                  <?php
	$sql="select intStyleId,strOrderNo from orders where intStatus =11 order by strStyle";
	$result=$db->RunQuery($sql);
		echo "<option value=\"".""."\">"."Select One"."</option>";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value =\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
	}
?>
                </select></td>
                <td><span class="normalfnt">SCNo</span></td>
                <td><span class="normalfnt">
                  <select name="select6" class="txtbox" id="cboScNo" style="width:150px" onchange="SetOrderNo(this);LoadOrderDetails(this);" tabindex="3">
                    <?php
	$sql="select S.intSRNO,S.intStyleId from specification S inner join orders O on O.intStyleId=S.intStyleId where O.intStatus =11 order by S.intSRNO desc";
	$result=$db->RunQuery($sql);		
		echo "<option value=\"".""."\">"."Select One"."</option>";		
	while($row=mysql_fetch_array($result))
	{
		echo "<option value =\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
	}
?>
                  </select>
                </span></td>
                <td>&nbsp;</td>
                <td><span class="normalfnt">Sub Store </span></td>
                <td><select name="select7" class="txtbox" id="cboSubCat" style="width:285px" tabindex="5">
                </select></td>
              </tr>
              <tr>
                <td><span class="normalfnt">&nbsp;Color</span></td>
                <td><span class="normalfnt">
                  <select name="cboColor" class="txtbox" id="cboColor" style="width:150px" tabindex="6">
                  </select>
                </span></td>
                <td><span class="normalfnt">Size</span></td>
                <td><span class="normalfnt">
                  <select name="cboSize" class="txtbox" id="cboSize" style="width:150px" tabindex="7">
                  </select>
                </span></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
		</tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainHeading2">
          <tr>
            <td width="32%" title="<?php //echo $commonBinID ;?>" id="titCommonBinID">&nbsp;</td>
            <td width="57%" title="<?php echo $Status ;?>" id="titStatus">&nbsp;</td>
            <td width="11%" ><img src="../images/add-new.png" width="109" id="butNew" height="18" onclick="OpenItemPopUp();" tabindex="8" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="divMain" style="overflow:scroll; height:300px; width:950px;">
          <table id="tblMain" width="1050" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="4%" height="25" >Del</td>
			  <td width="23%" >Description</td>
              <td width="15%" >Order No</td>
              <td width="10%" >Color</td>
              <td width="9%" >Size</td>
              <td width="7%" >Unit</td>
              <td width="5%" >Balance Qty</td>
              <td width="4%" >Allo  Qty</td>
              <td width="5%" >Order Unitprice</td>
              <td width="5%" >Unitprice</td>
			  <td width="4%" >GRN No</td>
              <td width="4%" >GRN Year</td>
              <td width="5%">Location</td>
              <td width="4%" >PO No</td>
              <td width="4%" >PO Year</td>
              <td width="4%" >From Order No</td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr >
    <td height="30"><table width="100%" border="0" class="tableBorder">
      <tr>	
        <td width="15%" class="normalfntMid">
        <img src="../images/new.png" alt="new" border="0" id="butNew" style="display:inline" onclick="ClearForm();" />
        <img src="../images/save-confirm.png" alt="Save" id="butSave" style="display:inline" onclick="SaveOpenStock();" />
		<img src="../images/report.png" alt="Report" border="0" id="butReport" style="display:inline" onclick="ViewReport();"/>
        <a href="../main.php"><img src="../images/close.png" alt="close" border="0" id="butClose" style="display:inline" /></a>
		</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<!--Start - Search popup-->
<div style="left:418px; top:142px; z-index:10; position:absolute; width: 261px; visibility:hidden; height: 61px;" id="NoSearch" >
  <table width="260" height="71" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td height="22" class="mainHeading" colspan="6"><span class="mainHeading"><img src="../images/cross.png" alt="rep" align="right" onclick="closeFindReturn();" /></span></td>
            
          </tr>
          <tr>
		  	<td width="4" height="22" class="normalfnt"></td>
            <td width="44" height="22" class="normalfnt">State </td>
            <td width="108"><select name="select3" class="txtbox" id="cboState" style="width:100px" onchange="LoadPopUpNo();">              
              <option value="1">Saved & Confirmed</option>              
			  <option value="10">Cancelled</option>
            </select></td>
            <td width="37" class="normalfnt">Year</td>
            <td width="55"><select name="select4" class="txtbox" id="cboYear" style="width:55px" onchange="LoadPopUpNo();">
             
			   <?php
	
	$SQL = "SELECT DISTINCT intReturnToSupYear FROM returntosupplierheader ORDER BY intReturnToSupYear DESC;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intReturnToSupYear"] ."\">" . $row["intReturnToSupYear"] ."</option>" ;
	}
	
	?>
            </select></td>
            <td width="10">&nbsp;</td>
          </tr>
          <tr>
		  <td width="4" height="27" class="normalfnt"></td>
            <td><div align="center" class="normalfnt">Job No</div></td>
            <td><select name="select" class="txtbox" id="cboNo" style="width:100px" onchange="loadPopUpReturnToStores();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
  </table>
		

</div>
<!--End - Search popup-->
</body>
</html>
 <script type="text/javascript" src="../js/jquery.fixedheader.js"></script>