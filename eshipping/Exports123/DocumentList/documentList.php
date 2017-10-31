<?php
$backwardseperator = "../../";
session_start();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document List</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
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
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="documentList.js"></script>

 <link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body onload="clearPage('tblDescription')">
<?php
	include "../../Connector.php";	
?>
<form id="frmDocumentList" name="frmDocumentList" method="post">
<table width="950" border="0" align="center" bgcolor="#FFFFFF" >
<tr>
	<td><?php include '../../Header.php'; ?></td>
</tr>
<tr>
 <td><table width="100%" border="0">
		<tr>
			<td width="10%" height="489">&nbsp;</td>
			<td width="80%"><table width="100%" border="0">
			  <tr>
			    <td height="34" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
			      <tr>
			        <td width="100%" bgcolor="#d6e7f5"><table width="743" border="0">
			          <tr>
			            <td width="104"><table width="100%" border="0">
			              <tr>
			                <td height="30" bgcolor="#588DE7" class="TitleN2white" align="center">Document List </td>
			                </tr>
			              <tr bgcolor="#D8E3FA">
			                <td ><table width="101%" border="0" class="normalfnt" cellpadding="2">
			                  <tr>
			                    <td height="5" colspan="7"></td>
			                    </tr>
			                  <tr>
			                    <td width="1%" height="31">&nbsp;</td>
			                    <td width="15%" class="normalfnt">Invoice Number<span style="color:#F00"> *</span></td>
			                    <td width="23%"><select name="cboFinalInvoice"   class="txtbox" id="cboFinalInvoice"style="width:160px" onchange="getDocListForInvoice(this);" tabindex="1">
			                      <option value="" ></option>
			                      <?php 
                     $sqlInvoice="SELECT strInvoiceNo FROM commercial_invoice_header order by strInvoiceNo";
                     $resultInvoice=$db->RunQuery($sqlInvoice);
                           while($row=mysql_fetch_array( $resultInvoice)) { ?>
			                      <option value="<?php echo $row['strInvoiceNo'];?>"><?php echo $row['strInvoiceNo'];?></option>
			                      <?php }?>
			                      </select></td>
			                    <td width="8%">&nbsp;</td>
			                    <td colspan="3">&nbsp;</td>
			                    </tr>
			                  <tr>
			                    <td>&nbsp;</td>
			                    <td class="normalfnt">GPA No</td>
			                    <td><input name="txtGpaNo"  class="txtbox" id="txtGpaNo" style="width:160px; hight:35px; "/></td>
			                    <td class="normalfnt">P.I.C No</td>
			                    <td width="21%"><input name="txtPicNo"  class="txtbox" id="txtPicNo" style="width:140px; hight:35px; "/></td>
			                    <td width="12%">Cert Of Origin</td>
			                    <td width="20%"><input name="txtCrt"  class="txtbox" id="txtCrt" style="width:140px; hight:35px; "/></td>
			                    </tr>
			                  <tr>
			                    <td>&nbsp;</td>
			                    <td colspan="6" class="normalfnt"><div style="overflow: scroll; height: 250px; width:100%;" id="selectitem">
			                      <table width="100%" align="center" cellpadding="0" cellspacing="1" class="bcgl1" id="tblDescription">
			                        <!-- <tbody id="tblDescriptionOfGood">-->
                                    <thead>
			                        <tr>
			                          <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Select</td>
			                          <td height="25" width="11%"bgcolor="#498CC2" class="normaltxtmidb2">Edit</td>
			                          <td width="7%"bgcolor="#498CC2" class="normaltxtmidb2"  style="display:none">Delete</td>
			                          <td width="28%"bgcolor="#498CC2" class="normaltxtmidb2">Document</td>
			                          <td bgcolor="#498CC2" class="normaltxtmidb2">Description &nbsp;&nbsp;&nbsp;<img src="../../images/add_alone.png" width="72" height="18" class="mouseover" onclick="loadDocDescPopUp();loadComboBox()" /></td>
			                          </tr>
                                      </thead><tbody>
			                        <!--   code goes here-->
                                    <?php
									$sql = "SELECT
											document_list.intDocumentFormatId,
											document_list.StrDocument,
											document_list.strDocDesc
											FROM
											document_list
											where strStatus = 0
											";
											
											
									$result = $db -> RunQuery($sql);
									$c=0;
									$cls ='';
									while($row=mysql_fetch_array($result)){
										($c % 2==0)? $cls="bcgcolor-tblrow": $cls="bcgcolor-tblrowWhite" ?>
										<tr class="<?php echo $cls;?>">
                                        <td   ><input type="checkbox" class="chkbx"  ></td>
                                        <td class="normalfntMid"  ><img src="../../images/edit.png" width="15" height="15" align="absmiddle" class="mouseover" onclick="loadDocDescPopUp();loadComboBox();loadSelectRow(this)" /></td>
                                        <td class="normalfntMid"  style="display:none"><img src="../../images/del.png" width="15" height="15" class="mouseover" onclick="deleteRec(this)" /></td>
                                        <td class="normalfnt" id ="<?php echo $row["intDocumentFormatId"]; ?>" ><?php echo $row["StrDocument"]; ?></td>
                                        <td  class="normalfnt"  id ="<?php ?>" > <?php echo $row["strDocDesc"]; ?></td>
                                        </tr>
										
									<?php	$c++;}
									
									?>
                                    </tbody>
			                        </table>
			                      </div></td>
			                    </tr>
			                  <tr>
			                    <td colspan="7"></td>
			                    </tr>
			                  </table></td>
			                </tr>
			              <tr>
			                <td height="34" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
			                  <tr >
			                    <td width="100%" bgcolor="#d6e7f5"><table width="743" border="0">
			                      <tr>
			                        <td width="122">&nbsp;</td>
			                        <td width="108" ><img src="../../images/report.png" width="108" height="24" onclick="showReport();" /></td>
			                        <td width="84" ><img src="../../images/save.png" alt="Save" width="84" height="24" name="btnSave" id="btnSave"  class="mouseover" onclick="saveToInvoiceDocList()" /></td>
			                        <td width="100" style="display:none"><a href="../../main.php"><img src="../../images/delete.png" alt="Delete" name="btnDelete" border="0" id="btnDelete" class="mouseover"/></a></td>
			                        <td width="307" ><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="84" height="24" border="0"  class="mouseover" id="btnClose"lass="mouseover" /></a></td>
			                        </tr>
			                      </table></td>
			                    </tr>
			                  </table></td>
			                </tr>
			              </table>			              <a href="../../main.php"></a></td>
			            </tr>
			          </table></td>
			        </tr>
			      </table></td>
			    </tr>
			</table></td>
	  
			<td width="10%"></td>
		</tr>
	</table>
	</td>
</tr>
</table>





</form>




</body>
</html>