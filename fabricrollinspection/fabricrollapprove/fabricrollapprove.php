<?php
	session_start();
	include "../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro : : Fabric Roll Inspection Approve</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="fabricrollapprove.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>

<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />

<style type="text/css">
<!--
.style1 {color: #FF0000}
#lyrLoading {
	position:absolute;
	left:595px;
	top:443px;
	width:75px;
	height:21px;
	z-index:1;
	background-color: #FFFFFF;
	overflow: hidden;
}
-->
</style>
</head>

<body>
<script type="text/javascript">
function SubmitForm()
{
	document.getElementById('frmFabricRollApprove').submit();	
}
</script>
<form id="frmFabricRollApprove" name="frmFabricRollApprove">
  <table width="950" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
    <tr>
      <td height="75" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="100%" height="44" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="6" colspan="3"><?php include '../../Header.php'; ?></td>
                </tr>
              <tr>
                <td width="8%" height="7"><span class="head1">Stores : </span></td>
                <td width="84%">&nbsp;</td>
                <td width="8%" rowspan="2"></td>
              </tr>
              <tr>
                <td height="18" colspan="2"><table width="100%" border="0">
               
                  </table></td>
                </tr>
            </table>              </td>
          </tr>

          <tr>
            <td><table width="100%" class="bcgl1">
                <tr>
                  <td width="68%"><table width="100%">
                      <tr>
                        <td width="73" class="normalfnt">Style ID </td>
                        <td width="176"><select name="cboStyleId" class="txtbox" style="width:170px" id="cboStyleId" tabindex="3" onchange="LoadScNo();LoadSupplierBatch();">
 <?php
		$SQL ="select distinct intStyleId,
(select intSRNO from specification S where S.intStyleId=FRH.intStyleId) AS SCNO
from fabricrollheader FRH
Order By FRH.intStyleId;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{				
				echo "<option value=\"".$row["SCNO"]."\">".$row["intStyleId"]."</option>";
			}
	
 	?>
                        </select></td>
                        <td width="34" class="normalfnt">SCNO</td>
                        <td width="170"><select name="cboScNo" class="txtbox" style="width:80px" id="cboScNo" onchange="LoadStyleID();LoadSupplierBatch();">
<?php
		$SQL ="select distinct intStyleId,
(select intSRNO from specification S where S.intStyleId=FRH.intStyleId) AS SCNO
from fabricrollheader FRH
Order By SCNO;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["SCNO"]."</option>";
			}
	
 	?>
                        </select>                        </td>
                        <td width="126" class="normalfnt">Supplier Batch No </td>
                        <td width="163" class="normalfnt"><select name="cboSupplierBatchNo" class="txtbox" style="width:100px" id="cboSupplierBatchNo" onchange="LoadSupplier();">
						
                        </select></td>
                        <td colspan="2" rowspan="2" align="center" valign="middle" class="normalfnt"><img src="../../images/view.png" alt="view" width="91" height="19" onclick="LoadDetailsToMainTable();"/></td>
                      </tr>
                      <tr>
                        <td class="normalfnt">Supplier</td>
                        <td colspan="3"><select name="cboSupplier" class="txtbox" style="width:300px" id="cboSupplier" tabindex="2" onchange="LoadRollNo();">
                        </select></td>
                        <td class="normalfnt">Roll No </td>
                        <td><span class="normalfnt">
                          <select name="cboRollNo" class="txtbox" style="width:100px" id="cboRollNo">
                          </select>
                        </span></td>
                      </tr>
                   
                     
                                      
                  </table></td>                  
                </tr>            
            </table></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="72" valign="top"><table width="100" cellpadding="0" cellspacing="0">
          <tr>
            <td width="841" height="20" bgcolor="#9BBFDD"><div align="center" class="normalfnth2">Details</div></td>
            <td width="109" bgcolor="#9BBFDD"><div align="right"></div></td>
          </tr>
          <tr>
            <td colspan="2"><div id="divcons" style="overflow:scroll; height:220px; width:950px;">
              <table width="1200" id="tblMain" bgcolor="#CCCCFF"  cellpadding="0" cellspacing="1">
                <tr bgcolor="#498CC2" height="20">
                  <td width="1%" class="normaltxtmidb2">Del</td>
                  <td width="4%" class="normaltxtmidb2">Roll No </td>
                  <td width="8%" class="normaltxtmidb2">Style ID </td>
                  <td width="4%" class="normaltxtmidb2">Sc No </td>
                  <td width="6%" class="normaltxtmidb2">BuyerPONO </td>
                  <td width="10%" class="normaltxtmidb2">Description </td>
                  <td width="6%" class="normaltxtmidb2">Color </td>
                  <td width="6%" class="normaltxtmidb2">Supp Batch  </td>
                  <td width="14%" class="normaltxtmidb2">Supplier Name  </td>
                  <td width="2%" class="normaltxtmidb2">Ins</td>
                  <td width="2%" class="normaltxtmidb2">App </td>
                  <td width="6%" class="normaltxtmidb2">Length</td>
                  <td width="5%" class="normaltxtmidb2">App. Length </td>
                  <td width="6%" class="normaltxtmidb2">Rej. Length </td>
                  <td width="19%" class="normaltxtmidb2">Special Comments </td>
                </tr>
			<!--	<tr class="bcgcolor-tblrow">
				  <td class="normalfnt"><div align="center"><img src="../../images/del.png"/></div></td>
				  <td class="normalfnt">2</td>
				  <td class="normalfnt">2</td>
				  <td class="normalfnt">2</td>
				  <td class="normalfnt">2</td>
				  <td class="normalfnt">2</td>
				  <td class="normalfnt">2</td>
				  <td class="normalfnt">2</td>
				  <td class="normalfnt">2</td>
				  <td class="normalfnt"><input type="checkbox" /></td>
				  <td class="normalfnt"><input name="checkbox" type="checkbox" /></td>
				  <td class="normalfnt">3</td>
				  <td class="normalfnt">3</td>
				  <td class="normalfnt">3</td>
				  <td class="normalfnt">12</td>
				</tr>-->
              </table>
            </div></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="21" valign="top">&nbsp;</td>
    </tr>

    <tr>
      <td bgcolor="#D6E7F5"><table width="100%">
          <tr>
            <td width="27%"><p align="right"><img src="../../images/new.png" alt="new" width="96" height="24" onclick="ClearForm();" /></p></td>
            <td width="21%"><div align="center"><img src="../../images/save-confirm.png" id="cmdSave" alt="save_confirm" width="174" height="24" onclick="SaveValidation();" /></div></td>
            <td width="14%"><div align="center"><img src="../../images/cancel.jpg" id="cmdCancel" alt="cancel" width="104" height="24" /></div></td>
            <td width="14%"><a href="#"><img src="../../images/report.png" width="108" height="24" border="0" onclick="SearchPopUp();" /></a></td>
            <td width="24%"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" /></a></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<!--Start - Search popup-->
<div style="left:665px; top:541px; z-index:10; position:absolute; width: 261px; visibility:hidden; height: 61px;" id="NoSearch" >
  <table width="260" height="59" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
		  	<td width="4" height="22" class="normalfnt"></td>
            <td width="44" height="22" class="normalfnt">State </td>
            <td width="108"><select name="select3" class="txtbox" id="cboState" style="width:100px" onchange="LoadPopUpNo();">              
              <option value="1">Saved & Confirmed</option>		  
            </select></td>
            <td width="37" class="normalfnt">Year</td>
            <td width="55"><select name="cboPopupYear" class="txtbox" id="cboPopupYear" style="width:55px" onchange="LoadPopUpNo();">
             
			   <?php
	
	$SQL = "SELECT DISTINCT intFRollSerialYear FROM fabricrollheader ORDER BY intFRollSerialYear DESC;";	
	$result = $db->RunQuery($SQL);	
		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intFRollSerialYear"] ."\">" . $row["intFRollSerialYear"] ."</option>" ;
	}
	
	?>
            </select></td>
            <td width="10">&nbsp;</td>
          </tr>
          <tr>
		  <td width="4" height="27" class="normalfnt"></td>
            <td><div align="center" class="normalfnt">Job No</div></td>
            <td><select name="select" class="txtbox" id="cboNo" style="width:100px" onchange="ViewReport();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
        
  </table>
		
<script type="text/javascript">
function LoadStyleID(){
	var ScNo =document.getElementById("cboScNo").options[document.getElementById("cboScNo").selectedIndex].text;
	document.getElementById("cboStyleId").value =ScNo;	
}
function LoadScNo(){
	var StyleID =document.getElementById("cboStyleId").options[document.getElementById("cboStyleId").selectedIndex].text;
	document.getElementById("cboScNo").value =StyleID;	
}
</script>
</div>
<!--End - Search popup-->
</html>