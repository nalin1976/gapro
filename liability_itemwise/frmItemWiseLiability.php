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
<title>GaPro | Style Items - Item Wise Liability</title>

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
    <td height="26" class="mainHeading">Style Items - Item Wise Liability</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="0">      	
		<tr>
			<td><table width="100%" border="0" cellspacing="1" cellpadding="0" class="tableBorder">
              <tr>
                <td width="7%"><span class="normalfnt">&nbsp;Serial No</span></td>
                <td width="17%"><input  type="text" name="txtSerialNo" class="txtbox" id="txtSerialNo" style="width:148px" disabled="disabled"/></td>
                <td width="6%">&nbsp;</td>
                <td width="17%"><img src="../images/view.png" alt="view" align="absbottom" onclick="SearchPopUp();" /></td>
                <td width="10%">&nbsp;</td>
                <td width="11%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
              </tr>
              <tr>
                <td><span class="normalfnt">&nbsp;Style No</span></td>
                <td><select class="txtbox" id="cboStyleNo" style="width:150px" onchange="LoadOrderAndSc(this);" tabindex="1">
                  <?php
	$sql="select O.strStyle,round(sum(dblQty),2)as stockBal from stocktransactions ST 
inner join orders O on O.intStyleId=ST.intStyleId
inner join mainstores MS on MS.strMainID=ST.strMainStoresID
where MS.intCompanyId='$companyId'
group by O.strStyle having stockBal>0
order by O.strStyle;";
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
                <td><select name="cboMainStore" class="txtbox" id="cboMainStore" style="width:285px" onchange="LoadSubStore();" tabindex="4">
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
                <td><select class="txtbox" id="cboOrderNo" style="width:150px" onchange="SetScNo(this);" tabindex="2">
<?php
$sql="select O.intStyleId,O.strOrderNo,round(sum(dblQty),2)as stockBal from stocktransactions ST 
inner join orders O on O.intStyleId=ST.intStyleId
inner join mainstores MS on MS.strMainID=ST.strMainStoresID
where MS.intCompanyId='$companyId'
group by ST.intStyleId having stockBal>0
order by O.strOrderNo";
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
                  <select name="select6" class="txtbox" id="cboScNo" style="width:150px" onchange="SetOrderNo(this);" tabindex="3">
                    <?php
	$sql="select O.intStyleId,S.intSRNO,round(sum(dblQty),2)as stockBal from stocktransactions ST 
inner join orders O on O.intStyleId=ST.intStyleId
inner join mainstores MS on MS.strMainID=ST.strMainStoresID
inner join specification S on S.intStyleId=O.intStyleId
where MS.intCompanyId='$companyId'
group by ST.intStyleId having stockBal>0
order by S.intSRNO desc;";
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
                <td><select name="cboSubCat" class="txtbox" id="cboSubStore" style="width:285px" tabindex="5">
                </select></td>
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
          <td id="titCommonBinID" title="<?php //echo $commonBinID ;?>" align="right" width="89%">&nbsp;</td>
            <td  align="right" width="11%"><img src="../images/add-new.png" width="109" id="cmdAddNew" height="18" onclick="OpenItemPopUp();" tabindex="8" /></td>
            
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="divMain" style="overflow:scroll; height:350px; width:950px;">
          <table id="tblMain" width="940" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="3%" height="25" >Del</td>
			  <td width="19%" >Description</td>
              <td width="12%" >Order No</td>
              <td width="8%" >Buyer PO No </td>
              <td width="8%" >Color</td>
              <td width="8%" >Size</td>
              <td width="7%" >Unit</td>
              <td width="8%" >Stock Bal </td>
              <td width="8%" >Liability Qty</td>
			   <td width="5%">Location</td>
               <td width="9%">GRN No </td>
               <td width="5%">GRN Type </td>
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
        <img src="../images/save-confirm.png" alt="Save" id="butSave" style="display:inline" onclick="SaveLiability();" />     <img src="../images/cancel.jpg" id="butCancel" style="display:none" onclick="cancelLiability();" />
		<img src="../images/report.png" alt="Report" border="0" id="butReport" onclick="ViewReport();"/>
        <a href="../main.php"><img src="../images/close.png" alt="close" border="0" id="butClose" style="display:inline" /></a>		</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<!--Start - Search popup-->
<div style="left:427px; top:142px; z-index:10; position:absolute; width: 278px; visibility:hidden; height: 61px;" id="NoSearch" >
<table width="276" height="71" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
<tr>
            <td height="22" class="mainHeading" colspan="6"><span class="mainHeading"><img src="../images/cross.png" alt="rep" align="right" onclick="closeFindReturn();" /></span></td>
            
          </tr>
          <tr>
		  	<td width="4" height="22" class="normalfnt"></td>
            <td width="59" height="22" class="normalfnt">State </td>
            <td width="102"><select name="select3" class="txtbox" id="cboState" style="width:100px" onchange="LoadPopUpNo();">              
              <option value="1">Save and Confirm</option>              
			  <option value="10">Cancel</option>
            </select></td>
            <td width="28" class="normalfnt">Year</td>
           <td width="55"><select name="select4" class="txtbox" id="cboYear" style="width:55px" onchange="LoadPopUpNo();">
             
			   <?php
	
	$SQL = "SELECT DISTINCT intSerialYear FROM itemwiseliability_header ORDER BY intSerialYear DESC ";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intSerialYear"] ."\">" . $row["intSerialYear"] ."</option>" ;
	}
	
	?>
            </select></td>
            <td width="10">&nbsp;</td>
          </tr>
          <tr>
		  <td width="4" height="27" class="normalfnt"></td>
            <td><div align="center" class="normalfnt">Serial No</div></td>
            <td><select name="select" class="txtbox" id="cboNo" style="width:100px" onchange="loadPopUpLiabilityDetails();">
			<option value="" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
  </table>
		

</div>
<!--End - Search popup-->
</body>
</html>
<script type="text/javascript" src="frmItemWiseLiability.js"></script>
 <script type="text/javascript" src="../js/jquery.fixedheader.js"></script>