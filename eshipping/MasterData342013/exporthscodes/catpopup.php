<?php
$backwardseperator = "../../";
session_start();
include("../../Connector.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.9.custom.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="CommodityCode.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cat No</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
</head>

<body>
<table width="320" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="22" bgcolor="#588DE7" class="TitleN2white">Category</td>
          </tr>
          <tr bgcolor="#D8E3FA">
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" height="126" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Search Category </td>
                      <td width="51%"><select name="cboCategory" class="txtbox"  onchange="serchcat(this.value)" style="width:160px"
					   id="cboCategory" tabindex="1">
					  <option value="0"></option>
                        <?php
	
	$SQL = "SELECT intId,strCatNo FROM quotacat
			ORDER BY strCatNo ";
	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
	?>
	<option value="<?php echo $row['intId']; ?>"	><?php echo $row['strCatNo']; ?></option>
	<?php 
	}
	?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="13%" class="normalfnt">&nbsp;</td>
                      <td width="36%" class="normalfnt">Category Name </td>
                      <td><input name="txtCategory" type="text" class="txtbox" id="txtCategory"  size="25" tabindex="2" /></td>
                    </tr> 
					<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="13%" class="normalfnt">&nbsp;</td>
                      <td width="36%" class="normalfnt">Category Number </td>
                      <td><input name="txtCatnum" type="text" class="txtbox" id="txtCatnum"  size="25"  tabindex="3"/></td>
                    </tr>
										<tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
					<tr>
					 <td width="13%">&nbsp;</td>
              <td width="36%" height="0" class="normalfnt">Country</td>
              <td width="51%"><select name="cboCountryList" class="txtbox" tabindex="4" id="cboCountryList" style="width:160px" onchange="getCountryDetails();">
   
 <?php
	
	$SQL = "SELECT country.strCountryCode, country.strCountry FROM country WHERE (((country.intStatus)=1));";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strCountry"] ."\">" . $row["strCountry"] ."</option>" ;
	}
	
	?>
	
	 </select></td>
	 
             
            </tr> 
                  </table></td>
                  </tr>
              </table>
              </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
                    <tr>
                      <td width="22%">&nbsp;</td>
                      <td width="19%"><img src="../../images/new.png" alt="New" name="New" onclick="newCategory();" class="mouseover"/></td>
					  <td><img src="../../images/save.png" alt="Save" name="save" width="84" height="24" onclick="saveCategoryData();" class="mouseover"/></td>
                      <td width="15%"><img src="../../images/delete.png" alt="Delete" name="Delete" width="100" height="24" onclick="deleteCategory();" class="mouseover"/></td>
                      <td width="18%"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close" onclick="closeWindow();" class="mouseover"/></td>
                      <td width="26%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  </table>
</body>
</html>
