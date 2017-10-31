<?php
 session_start();
 $backwardseperator = "../../";
 include "../../Connector.php";
 #chk updates
 
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Document</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="../js/tablegrid.js"></script>
<script type="text/javascript" src="styleDocumentJS.js"></script>
<script src="/gapro/javascript/script.js" type="text/javascript"></script>
</head>
<body>

<form name="frmCreditPeriod" id="frmCreditPeriod" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">
		  <div align="center">Style Document<span class="vol">(Ver 0.3)</span><span id="creditperiod_popup_close_button"><!--<img onclick="" align="right" src="../../images/cross.png" />--></span></div>
		</div>
	</div>
	<div class="main_body">
<table width="46%" border="0" align="center" bgcolor="#FFFFFF">

  <tr>
    <td><div align="center"></div>
      <table width="300" border="0" align="center" class="tableBorder">
      <tr>
        <td width="300" >
          <table width="85%" border="0" >
            <tr>
              <td height="17"><table width="60%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="9%"  height="25">&nbsp;</td>
                    <td width="19%" class="normalfnt">ID&nbsp;<span class="compulsoryRed">*</span></td>
                    <td width="37" id="title_Description" title="">
                    <?php
						
						/*$sqlFirst = "SELECT MAX(id) AS maxid FROM styledocumenttypes";
						$result = $db->RunQuery($sqlFirst);
						$row1   = mysql_fetch_array($result);
						$maxID  = $row1['maxid']+1;*/
					?>
                    <input name="txtstyleid" type="text" class="txtbox" id="txtstyleid" size="10" maxlength="50" tabindex="1" disabled="disabled"/></td>
                    <td width="35%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="24">&nbsp;</td>
                    <td class="normalfnt">Description&nbsp;<span class="compulsoryRed">*</span></td>
                    <td align="left" width="37" ><input name="txtstyledescription" type="text" class="txtbox" id="txtstyledescription" size="25" maxlength="100" style="text-align:left"  tabindex="1"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="23" >&nbsp;</td>
                    <td class="normalfnt">Status</td>
                    <td align="left" width="37"><input type="checkbox" id="chkStatus" checked="checked">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td  colspan="4" >
                      <table  width="321" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                          <td ><div align="right" style="width:40px"></div></td>
                          <td ><img src="../../images/new.png" alt="New" name="New" onClick="ClearCPForm();" class="mouseover" tabindex="5"/></td>
                          <td ><img src="../../images/save.png" onclick="NewCreditPeriod();" alt="save"  tabindex="3"/></td>
                          <td  id="tdDelete"><a href="../../main.php"><img src="../../images/close.png" alt="close"  border="0" tabindex="4"/></a></td>
                          <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                          </tr>
                      </table>
                    </td>
                  </tr>
              </table>
                <div align="center"></div></td>
            </tr>
            <tr>
              <td height="161"><table width="100%" height="159" border="0" cellpadding="0" cellspacing="0">
                  <tr class="bcgl1">
                    <td width="100%" height="138"><table width="99%" border="0" class="bcgl1">
                        <tr>
                          <td colspan="3"><div id="divcons" style="overflow-x:hidden; height:150px; width:350px;">
                              <table width="116%" id="tblCreditPeriod" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
                                <tr class="mainHeading2">
                                  <td width="28" bgcolor="" class="normaltxtmidb2">Del</td>
                                  <td width="33" bgcolor="" class="normaltxtmidb2">Edit</td>
                                  
                                  <td width="166" height="20" bgcolor="" class="normaltxtmidb2"><div align="center">Description</div></td>
                                  <td width="67" bgcolor="" class="normaltxtmidb2">Status</td>
                                  </tr>
		  						  <?php
								  	$SQL = "SELECT id,strdescription,intStatus FROM styledocumenttypes  order by id ASC";	
									$result = $db->RunQuery($SQL);	
									while($row = mysql_fetch_array($result))
									{
										
								  ?>	
                                <tr class="bcgcolor-tblrowWhite">
                                  <td class="normalfnt"><div align="center"><img src="../../images/del.png" onclick="DeleteStyle(this)" alt="Delete" width="15" height="15"  class="mouseover" id="<?php echo $row["id"];  ?>" /></div></td>
                                  <td class="normalfnt"><div align="center"><img src="../../images/edit.png"  onclick="loadData(this)" alt="Edit" width="15" height="15" class="mouseover" id="<?php echo $row["id"];  ?>" /></div></td>
                                  
                                  <td class="normalfnt" style="text-align:center" ><?php echo $row["strdescription"];  ?>                                </td>
                                  <td class="normalfnt" style="text-align:center"><?php if($row["intStatus"]==1){ echo "<input type='checkbox' checked='checked' disabled='disabled'/>";} else{echo "<input type='checkbox' disabled='disabled'/>";}?></td>
                                  </tr>    
								  <?php
								  }
								  ?>                            
                              </table>
                          </div></td>
                        </tr>
                    </table></td>
                  </tr>
                  
              </table></td>
            </tr>
          </table>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
<div align="center"></div>
</form>
</body>
</html>
