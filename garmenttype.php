<?php
$backwardseperator = "../../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Garmenttype</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="garmenttype.js"></script>
<script src="../../../javascript/script.js"></script>
</head>
<body>		
<?php
include "../../../Connector.php";
?>
<form id="frmGramenttype" name="frmGramenttype" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "{$backwardseperator}Header.php";?></td>
  </tr>
  <tr>
    <td><table width="750" border="0" align="center">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="35" align="center" bgcolor="#660000" class="mainHeading">Garment Type</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0">
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp; </td>
                  <td width="67%">&nbsp;</td>		
                </tr>
                <tr>
                  <td width="8%" rowspan="6" class="normalfnt">&nbsp;</td>
                  <td width="25%" height="11" class="normalfnt">Search</td>
                  <td><select name="cboSearch" class="txtbox" id="cboSearch" onchange="LoadDetails(this);" style="width:160px">		  <?php
	$SQL="SELECT intGamtID ,strGarmentName FROM was_garmenttype WHERE  strGarmentName <> 10 ";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intGamtID"] ."\">" . $row["strGarmentName"] ."</option>" ;
	}		  
			  
				  ?>

				  
                                                      </select></td>
        
                </tr>
              
				      
                <tr>
				  
                  <td class="normalfnt">Descrtiption&nbsp;<span class="compulsoryRed">*</span></td>                 
				  <td><select name="cboDescrtiption" class="txtbox" id="cboDescrtiption" onchange=""style="width:160px">		  <?php
	$SQL="SELECT intGamtID,strGamtDesc FROM was_garmenttype WHERE   strGamtDesc <> 10 ";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intGamtID"] ."\">" . $row["strGamtDesc"] ."</option>" ;
	}		  
			  
				  ?>

				  
                                                      </select></td>
         			                 				 
				  </tr>
				  <tr>
				  <td class="normalfnt">Garment Name&nbsp;<span class="compulsoryRed">*</span></td>
				  <td><input name="txtGarmentName" type="txt" class="txtrbox" id="txtGarmentName" size="45" maxlength="100"/></td>                  
				  </tr>
				   </tr>
                  <tr>
                
                  
                      <td width="23%"  class="normalfnt">Active</td>
                      <td><input type="checkbox" name="chkActive" id="chkActive" checked="checked" /></td>
                    </tr>                
                  <tr>
                  <td colspan="2" class="normalfnt">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                  </tr>
                 </table>
                 </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0"class="bcgl1">
              <tr>
                <td width="100%"><table width="100%" border="0" class="tableFooter">
                    <tr>
                      <td ><img src="../../../images/new.png" alt="New" name="New"
					  width="96" height="24" onclick="ClearForm();" class="mouseover"/></td>
                      <td ><img src="../../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="butCommand(this.name);" class="mouseover"/></td>
                      <td ><img src="../../../images/delete.png" alt="Delete" name="Delete"
					  width="100" height="24" onclick="ConfirmDelete(this.name)" class="mouseover"/></td>
                      <td class="normalfnt"><img src="../../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="ViewOperatorReport();"  /></td>        
                       <td ><a href="../../../main.php"><img src="../../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td> 					  	  
                               
                     </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
       <td width="19%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  </tr>
  <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
