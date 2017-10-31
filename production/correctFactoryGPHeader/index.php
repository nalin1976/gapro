<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
include "${backwardseperator}Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gapro | Correct Factory GatePass Header</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script language="javascript">
 function loadGPFactories(obj){
	var path="correctPFG_db.php?req=loadGPFacories&gpNo="+obj.value.trim();
	htmlobj = $.ajax({url:path,async:false});
	var XMLFromFac=htmlobj.responseXML.getElementsByTagName('FromFac');
	var XMLToFac=htmlobj.responseXML.getElementsByTagName('ToFac');
	document.getElementById('cboFromFac').value=XMLFromFac[0].childNodes[0].nodeValue;
	document.getElementById('cboToFac').value=XMLToFac[0].childNodes[0].nodeValue;
 }
 function saveChange(){
	var path="correctPFG_db.php?req=updateDet&gpNo="+document.getElementById('cboGP').value.trim()+"&fromFac="+document.getElementById('cboFromFac').value+"&toFac="+document.getElementById('cboToFac').value+"&reason="+document.getElementById('txtReason').value;
	htmlobj = $.ajax({url:path,async:false});	 
	if(htmlobj.responseText==1)
		alert("Successfully Changed.");
	else
	{
		alert("Changing Fail.");
	}
 }
 
 function clearForm(){
	 document.getElementById('frmCGP').reset();
 }
</script>
</head>
<body>
	<table width="100%">
        <tr>
            <td><?php include '../../Header.php'; ?></td>
        </tr>
        <tr>
            <td align="center">
            <form id="frmCGP">
                <table width="50%" class="main_border_line">
                	<tr>
                    	<td class="mainHeading" colspan="6">
                        	Correct Factory GatePass Header
                        </td>
                    </tr>
                    <tr>
                    	<td class="normalfnt" colspan="6">&nbsp;
                       
                        </td>
                    </tr>
                	<tr>
                    	<td width="10%" class="normalfnt">&nbsp;</td>
                    	<td width="15%" class="normalfnt"> 
                        	GatePass No
                        </td>
                        <td width="25%" class="normalfnt">
                        	<select style="width:150px;" id="cboGP" onchange="loadGPFactories(this);" tabindex="1">
                            <option value="">Select One</option>
                            <?php
                            $sql="select concat(p.intGPyear,'/',p.intGPnumber) as GP from productionfggpheader p 
							
							where p.strFromFactory='".$_SESSION['FactoryID']."' AND 
							concat(p.intGPYear,'/',p.intGPnumber) 
							NOT IN
							(SELECT  concat(pr.intGPYear,'/',pr.dblGatePassNo) AS GP 
							FROM productionfinishedgoodsreceiveheader pr)
							ORDER BY p.intGPYear ASC,p.intGPnumber ASC;";
						//	die($sql);
							
							$res=$db->RunQuery($sql);					
							while($row=mysql_fetch_assoc($res)){
								echo "<option value=\"".$row['GP']."\">".$row['GP']."</option>";
							}
							?>
                            </select>
                        </td>
                        <td width="15%" class="normalfnt">
                        	Date
                        </td>
                        <td width="25%">
                        	<input style="width:100px;" class="txtbox"  tabindex="2" value="<?php echo date('Y-m-d');?>"/>
                        </td>
                        <td width="10%" class="normalfnt">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td width="10%" class="normalfnt">&nbsp;</td>
                    	<td class="normalfnt">
                        	From Factory
                        </td>
                        <td colspan="3">
                        	<select style="width:450px;" id="cboFromFac" disabled="disabled"  tabindex="3">
                            <option value=""></option>
                            <?php
								$sqlF="SELECT
										companies.intCompanyID,
										concat(companies.strName) AS COMName
										FROM companies
										ORDER BY companies.strName ;";
								$resF=$db->RunQuery($sqlF);
								while($rowF=mysql_fetch_assoc($resF)){
									echo "<option value=\"".$rowF['intCompanyID']."\">".$rowF['COMName']."</option>";
								}
                            ?>
                            </select>
                        </td>
                        <td width="10%" class="normalfnt">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td width="10%" class="normalfnt">&nbsp;</td>
                    	<td class="normalfnt" >
                        To Factory
                      </td>
                        <td colspan="3">
                        <select style="width:450px;" id="cboToFac"  tabindex="4">
                        <option value=""></option>
                        	<?php
								$sqlF="SELECT
										companies.intCompanyID,
										concat(companies.strName) AS COMName
										FROM companies
										ORDER BY companies.strName ;";
								$resF=$db->RunQuery($sqlF);
								while($rowF=mysql_fetch_assoc($resF)){
									echo "<option value=\"".$rowF['intCompanyID']."\">".$rowF['COMName']."</option>";
								}
                            ?>
                        </select>
                        </td>
                        <td width="10%" class="normalfnt">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td width="10%" class="normalfnt">&nbsp;</td>
                    	<td class="normalfnt" valign="baseline">
                        Reason
                      </td>
                        <td colspan="3">
                        <textarea  rows="1" cols="53" onkeypress="return imposeMaxLength(this,event, 150);"  tabindex="5" id="txtReason"></textarea>
                        </td>
                        <td width="10%" class="normalfnt">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td class="normalfnt" colspan="6">&nbsp;
                       
                        </td>
                    </tr>
                    <tr>
                    	<td  colspan="6" align="center">
                       	<div align="center">
                        	<img src="../../images/new.png"  tabindex="7" onclick="clearForm();"/>
                        	<img src="../../images/save.png"  tabindex="6" onclick="saveChange();"/>
                             <a href="../../main.php"><img src="../../images/close.png"  border="0" class="mouseover" tabindex='8'/></a>
                        </div>
                        </td>
                    </tr>
                </table>
                </form>
            </td>
        </tr>
    </table>
</body>
</html>
