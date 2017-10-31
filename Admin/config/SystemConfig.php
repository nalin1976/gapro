<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>System Configuation</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="SystemConfig.js"></script>
<script src="../../javascript/script.js"></script>
</head>

<body>
<?php
include "../../Connector.php";

$check_db="select intBaseCurrency,intBaseCountry from systemconfiguration";
$results_check=$db->RunQuery($check_db);
$row_sys=mysql_fetch_array($results_check);
$currency=$row_sys["intBaseCurrency"];
$country=$row_sys["intBaseCountry"];

?>
<form id="frmCompanyDetails" name="frmCompanyDetails" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "../../Header.php";?></td>
  </tr>
  <tr>
    <td><table width="585" border="0" align="center">
      <tr>
        <td width="62%"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="35" bgcolor="#498CC2" class="mainHeading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="13%" valign="middle" class="normaltxtmidb2">&nbsp;</td>
                  <td width="72%" class="mainHeading">System Configuration </td>
                  <td width="15%" class="seversion"> (Ver 0.3) </td>
                </tr>
              </table></td>
          </tr>         
          <tr>
            <td height="47"><table width="100%" border="0" class="">
              
              <tr>
                <td width="79" class="normalfnt">&nbsp;</td>
                <td width="145" class="normalfnt">Base Currency&nbsp;<span class="compulsoryRed">*</span></td>
                <td width="130"><span class="normalfnt">
                  <select name="sys_currency" class="txtbox" id="sys_currency" style="width:165px">
                    <?php
					$SQL="SELECT currencytypes.strCurrency,currencytypes.intCurID FROM currencytypes WHERE (((currencytypes.intStatus)=1)) order by strCurrency";
					
				$result = $db->RunQuery($SQL);
				
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			
			while($row = mysql_fetch_array($result))
			{
				if($currency==$row["intCurID"]){?>
				<option value="<?php echo $row['intCurID'] ;?> " selected="selected"><?php echo $row['strCurrency'] ;?></option>
				<?php }else{ ?>
				<option value="<?php echo $row['intCurID'] ;?> "><?php echo $row['strCurrency'] ;?></option> 
			
		  
					<?php }}?>
                  </select>
                </span></td>
                <td width="199">&nbsp;</td>
              </tr>
			  <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Default Country <span class="compulsoryRed">*</span></td>
                <td><select name="sys_country" class="txtbox" id="sys_country" style="width:165px" tabindex="4" >
                  <?php
	
	$str_country = "SELECT country.intConID, country.strCountry FROM country where intStatus<>10 order by strCountry asc;";
	
	$result_country = $db->RunQuery($str_country);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row_country = mysql_fetch_array($result_country))
	{
	if($row_country["intConID"]==$country){?>
				<option value="<?php echo $row_country['intConID'] ;?>" selected="selected"><?php echo $row_country['strCountry'] ;?></option>
				<?php }else{ ?>
				<option value="<?php echo $row_country['intConID'] ;?>"><?php echo $row_country['strCountry'] ;?></option> 
			
		  
				<?php }}?>
                </select></td>
                <td>&nbsp;</td>
              </tr>
			  
            </table></td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor=""><table width="50" border="0" align="center">
                    <tr>
                      <td width="19%"><img src="../../images/save.png" alt="Save" name="Save"width="84" height="24" onclick="save_configuration()" class="mouseover"/></td>
                      <td width="12%" class="normalfnt">&nbsp;</td>
                      <td width="17%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close" class="mouseover"/></a></td>
                      </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<div style="left:572px; top:496px; z-index:10; position:absolute; width: 122px; visibility:hidden; height: 20px;" id="divlistORDetails">
  <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
  <tr>
    <td width="43"><div align="center">List</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="list" onclick="loadReport();"/></div></td>
	<td width="57"><div align="center">Details</div></td>
	<td width="20"><div align="center"><input type="radio" name="radioListORdetails" id="radioListORdetails" value="details" onclick="loadReport();"/></div></td>
  </tr>
  </table>	  
  </div>
</form>
</body>
</html>
