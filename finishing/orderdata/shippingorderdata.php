<?php
$backwardseperator = "../../";
include '../../Connector.php' ;
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shipping Order Data</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/autofill.js" type="text/javascript"></script>
<script src="shippingorderdata.js"></script>

</head>
<body>

 
  <table width ="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder" cellspacing="0">
    
    <tr>
      <td height="25"class="mainHeading"> Shipping Data </td>
	</tr>
	<tr>
		<td>
		<table width="100%" border="0" cellspacing="2" cellpadding="0">
		  <tr>
			<td height="38"><table width="100%" border="0" cellspacing="2" cellpadding="0" class="bcgl1">
              <tr>
                <td>
				<form id="frmShipHeader" name="frmShipHeader" >
				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="30" bgcolor="#FBF8B3"  >
                  <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="10%" class="normalfnt">Style No </td>
                    <td width="21%"><select name="cboStyle" class="txtbox" id="cboStyle" onchange="LoadOrderNo(this.value);" style="width:160px" tabindex="1">
                        <?php
	$SQL="select distinct O.strStyle
			from specification SP
			INNER JOIN orders O ON O.intStyleId=SP.intStyleId
			where O.intStatus=0 or O.intStatus=10 or O.intStatus=11
			order by O.strStyle asc;";		
		
		$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}		  
			  
				  ?>
                    </select></td>
                    <td width="1%">&nbsp;</td>
                    <td width="12%" class="normalfnt">Order No </td>
                    <td width="18%"><select name="cboOrderNo" class="txtbox" id="cboOrderNo" onchange="SetSCNo(this);loadDetails(this.value);" style="width:160px" tabindex="2">
                        <?php
	$SQL="select distinct SP.intStyleId,O.strOrderNo
			from specification SP
			INNER JOIN orders O ON O.intStyleId=SP.intStyleId
			where O.intStatus=0 or O.intStatus=10 or O.intStatus=11
			order by O.strOrderNo asc;";	
	$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}		  
			  
				  ?>
                    </select></td>
                    <td width="1%">&nbsp;</td>
                    <td width="11%" class="normalfnt">SC No </td>
                    <td width="25%"><select name="cboSCNo" class="txtbox" id="cboSCNo" onchange="SetOrderNo(this);loadDetails(this.value);" style="width:160px" tabindex="3">
                        <?php
	$SQL="select SP.intStyleId,SP.intSRNO
			from specification SP
			INNER JOIN orders O ON O.intStyleId=SP.intStyleId
			where O.intStatus=0 or O.intStatus=10 or O.intStatus=11
			order by SP.intStyleId desc;";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}		  
			  
				  ?>
                    </select></td>
                  </tr>
                </table></form></td>
              </tr>
            </table></td>
		  </tr>
		  <tr>
		  	<td>
			<form id="frmShipDetail" name="frmShipDetail" >
			<table width="100%" border="0" cellspacing="0" cellpadding="5" class="tableBorder">
			  <tr>
			    <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
			    <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
			    <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
			    <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
			    <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
			    <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
			    <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
			    <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
			    </tr>
			  <tr>
			    <td class="normalfnt" nowrap="nowrap">Material #</td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtMaterial" type="text" class="txtbox" id="txtMaterial" style="width:146px" maxlength="150" tabindex="5"/></td>
			    <td class="normalfnt" nowrap="nowrap">Construction Type </td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtConType" type="text" class="txtbox" id="txtConType" style="width:146px" maxlength="150" tabindex="6"/></td>
			    <td class="normalfnt" nowrap="nowrap">Label</td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtLable" type="text" class="txtbox" id="txtLable" style="width:146px" maxlength="200" tabindex="7"/></td>
			    <td class="normalfnt" nowrap="nowrap">Color</td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtColor" type="text" class="txtbox" id="txtColor" style="width:146px" maxlength="30" readonly="true" tabindex="8"/></td>
			    </tr>
				<tr>
				<td class="normalfnt" nowrap="nowrap">MRP</td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtMRP" type="text" class="txtbox" id="txtMRP" style="width:146px" maxlength="30" onkeypress="return CheckforValidDecimal(this.value, 2,event);" tabindex="8"/></td>
			    <td class="normalfnt" nowrap="nowrap">PrePacK Code</td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtPrePackCode" type="text" class="txtbox" id="txtPrePackCode" style="width:146px" maxlength="150" tabindex="9"/></td>
			    <td class="normalfnt" nowrap="nowrap">Season</td>
			    <td class="normalfnt" nowrap="nowrap"><select name="cboSeason" class="txtbox" style="width:146px" id="cboSeason" disabled="disabled">
               
			     <?php
	$SQL="select distinct S.strSeason,O.intSeasonId
			from seasons S
			INNER JOIN orders O ON O.intSeasonId=S.intSeasonId
			where O.intStatus=0 or O.intStatus=10 or O.intStatus=11
			order by S.strSeason asc;";	
	$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intSeasonId"] ."\">" . $row["strSeason"] ."</option>" ;
	}		  
			  
				  ?>
			   
			   
			    </select>				</td>
			    <td class="normalfnt" nowrap="nowrap">Division</td>
			    <td class="normalfnt" nowrap="nowrap"><select name="cboDivision" class="txtbox" style="width:146px" id="cboDivision" disabled="disabled">
                 <?php
	$SQL="select distinct BD.strDivision,O.intDivisionId
			from buyerdivisions BD
			INNER JOIN orders O ON O.intDivisionId=BD.intDivisionId
			where O.intStatus=0 or O.intStatus=10 or O.intStatus=11
			order by BD.strDivision asc;";	
	$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intDivisionId"] ."\">" . $row["strDivision"] ."</option>" ;
	}		  
			  
				  ?>
				
				</select></td>
				</tr>
				<tr>
				<td class="normalfnt" nowrap="nowrap">CTN Volume</td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txt_l" type="text" class="txtbox" id="txt_l" style="width:45px;text-align:right" maxlength="30" onkeypress="return CheckforValidDecimal(this.value, 2,event);" tabindex="10"/> <input name="txt_w" type="text" class="txtbox" id="txt_w" style="width:45px;text-align:right" maxlength="30" onkeypress="return CheckforValidDecimal(this.value, 2,event);" tabindex="11"/> <input name="txt_h" type="text" class="txtbox" id="txt_h" style="width:45px;text-align:right" maxlength="30" onkeypress="return CheckforValidDecimal(this.value, 2,event);" tabindex="12"/></td>
			    <td class="normalfnt" nowrap="nowrap">Wash Code</td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtWashCode" type="text" class="txtbox" id="txtWashCode" style="width:146px" maxlength="150" tabindex="13"/></td>
			    <td class="normalfnt" nowrap="nowrap">Article</td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtArticle" type="text" class="txtbox" id="txtArticle" style="width:146px" maxlength="150" tabindex="14"/></td>
			    <td class="normalfnt" nowrap="nowrap">Item #</td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtItemNo" type="text" class="txtbox" id="txtItemNo" style="width:146px" maxlength="150" tabindex="15"/></td>
				</tr>
				<tr>
				<td class="normalfnt" nowrap="nowrap">Item Gen Desc </td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtGenItem" type="text" class="txtbox" id="txtGenItem" style="width:146px" maxlength="500" tabindex="16"/></td>
			    <td class="normalfnt" nowrap="nowrap">Item Spec Desc </td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtSpecItem" type="text" class="txtbox" id="txtSpecItem" style="width:146px" maxlength="500" tabindex="17"/></td>
			    <td class="normalfnt" nowrap="nowrap">Manu. Ord. #</td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtManuOrdNo" type="text" class="txtbox" id="txtManuOrdNo" style="width:146px" maxlength="50" tabindex="18"/></td>
			    <td class="normalfnt" nowrap="nowrap">Manu. Style</td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtManuStyle" type="text" class="txtbox" id="txtManuStyle" style="width:146px" maxlength="50" tabindex="19"/></td>
				</tr>
				<tr>
				<td class="normalfnt" nowrap="nowrap">Sorting Type</td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtSortType" type="text" class="txtbox" id="txtSortType" style="width:146px" maxlength="100" tabindex="20"/></td>
			    <td class="normalfnt" nowrap="nowrap">Manufacturer</td>
			    <td class="normalfnt" nowrap="nowrap"><select name="cboManufacturee" class="txtbox" style="width:146px" id="cboManufacturee" disabled="disabled">
				 <?php
	$SQL="select distinct C.strName,O.intCompanyID
			from companies C			
			INNER JOIN orders O ON O.intCompanyID=C.intCompanyID
			where O.intStatus=0 or O.intStatus=10 or O.intStatus=11
			order by C.strName asc;";	
	$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
	}		  
			  
				  ?>
				
                </select></td>
			    <td class="normalfnt" nowrap="nowrap">WT Unit </td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtWTUnit" type="text" class="txtbox" id="txtWTUnit" style="width:146px" maxlength="50" tabindex="21"/></td>
			    <td class="normalfnt" nowrap="nowrap">HS Code </td>
			    <td class="normalfnt" nowrap="nowrap"><input name="txtHSCode" type="text" class="txtbox" id="txtHSCode" style="width:146px" maxlength="50" tabindex="22"/></td>
				</tr>
				 <tr>
				   <td class="normalfnt" nowrap="nowrap">Mondial PO # </td>
				   <td class="normalfnt" nowrap="nowrap"><input name="txtMondialPONo" type="text" class="txtbox" id="txtMondialPONo" style="width:146px" maxlength="50" tabindex="23"/></td>
				   <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
				   <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
				   <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
				   <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
				   <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
				   <td class="normalfnt" nowrap="nowrap">&nbsp;</td>
				   </tr>
			  
			</table></form>
			</td>
		  </tr>
		  <tr>
            <td height="34"><table width="100%" border="0"class="tableBorder" cellspacing="0">
              <tr>                
                      <td align="center"><img src="../../images/new.png" alt="New" name="New" width="96" height="24" onclick="ClearForm();" class="mouseover" style="display:inline" tabindex="25"/>
                      <img src="../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="SaveShipingData();" class="mouseover" style="display:inline" tabindex="24"/>
                      <img src="../../images/delete.png" alt="Delete" name="Delete" width="100" height="24" onclick="ConfirmDelete()" class="mouseover" style="display:none" id="butDelete"/>
                    	<img src="../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="ViewShippingdataReport();" style="display:inline" tabindex="26"/>
                       <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close" style="display:inline" tabindex="27"/></a></td> 					  	  
              </tr>
		</table>

		</td>
	</tr>

	</table>
	</td>
  </tr>
 </table>
 </td>
 </tr>
 </table>  
</body>
</html>
