<?php
 session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
 include "../../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Main Stores - Store Location Wizard</title>
<style type="text/css">
<!--

.divclass {
	border: thin solid #99CCFF;
	position:absolute;
	left:315px;
	top:129px;
	width:515px;
	height:500px;
	z-index:1;
	overflow:inherit;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="stores.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
var messageString = "main store " ;
</script>
<script src="../../javascript/script.js" type="text/javascript"></script>
</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include $backwardseperator."Header.php";?></td>
  </tr>
  <tr>
    <td>
<div id="Layer1" class="divclass" style="height:auto;">
  <table width="515" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="129" class="bcgcolor-highlighted"><div align="center" class="head1">[ Main Stores ]</div></td>
      <td width="129" class="bcgcolor"><div align="center" class="head1">[ Sub Stores ]</div></td>
      <td width="128" class="bcgcolor"><div align="center" class="head1">[ Locations ]</div></td>
      <td width="129" class="bcgcolor"><div align="center" class="head1">[ Bins ]</div></td>
    </tr>
    <!--<tr>
      <td colspan="4" class="head1"><br />
      &nbsp;Main Stores - Store Location Wizard </td>
    </tr>-->
    <tr>
      <td colspan="4" class="normalfnt2"><br />
      Available main stores </td>
    </tr>
    <tr>
      <td colspan="4">
	  <div  style="overflow:scroll; height:150px; width:515px;">
	  <table width="499" id="tblMainStores" bgcolor="#CCCCFF" border="0" cellpadding="0" cellspacing="1" class="bcgl1">
        <tr>
          <td width="27" bgcolor="#498CC2" class="normaltxtmidb2L">&nbsp;</td>
          <td width="300" bgcolor="#498CC2" class="normaltxtmidb2L">Name</td>
          <td width="172" bgcolor="#498CC2" class="normaltxtmidb2L">Remarks</td>
        </tr>
        <?php
		

			$sql = "SELECT strMainID,intCompanyId,strName,strRemarks,intStatus FROM mainstores WHERE
						mainstores.intCompanyId =  '".$_SESSION["FactoryID"]."' AND intAutomateCompany <>1 AND intStatus<>10 order by strName;";
			$result = $db->RunQuery($sql);	
			$pos = 0;
			while($row = mysql_fetch_array($result))
			{
			?>
              <tr class="<?php 
			  if ($pos % 2 == 0)
					echo "bcgcolor-tblrow";
				else
					echo "bcgcolor-tblrowWhite";
			   ?>">
        
          <td><input name="radiobutton" id="<?php echo  $row["strMainID"]; ?>" <?php if($_SESSION["mainStore"] == $row["strMainID"]) { ?> checked="checked" <?php } ?> type="radio" value="radiobutton" /></td>
          <td class="normalfnt"><?php echo  $row["strName"]; ?></td>
          <td class="normalfnt"><?php echo  $row["strRemarks"]; ?></td>
        </tr>
        <?php
        	$pos++;
        }
        ?>
      </table>
	  </div>	  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><table align="center" class="tableBorder1" width="100%">
        <tr>
          <td align="right"><a href="../../main.php"><img src="../../images/close.png" alt="close" class="mouseover noborderforlink" /></a></td>
          <td ><img src="../../images/next.png" onclick="goToURL('subStores.php?mainID=');" class="mouseover" alt="next" width="95" height="24" /></td>
        </tr>
      </table></td>
      </tr>
    <tr>
      <td colspan="4" align="right" bgcolor="#FFD5AA"><img src="../../images/addnew2.png" onclick="showAddNew('storesDiv',214);"/></td>
    </tr>
    <tr>
      <td colspan="4">
      	<div style="visibility:hidden;width:100%;height:0px;" id="storesDiv">
        	<table width="99%" align="center"  cellpadding="1" cellspacing="0" border="0">
                <tr>
                  <td width="120" class="normalfnt">Search</td>
                  <td colspan="3"><select id="cboSearch" name="cboSearch" style="width:250px;" class="txtbox" onchange="LoadMainStoreDetails(this);" tabindex="1">
                    <?php
                
                $SQL = "SELECT strMainID,strName FROM mainstores where mainstores.intCompanyId =  '".$_SESSION["FactoryID"]."' AND intAutomateCompany <>1 AND intStatus<>10 order by strName;";
                
                $result = $db->RunQuery($SQL);
                	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
                while($row = mysql_fetch_array($result))
                {
                    //if ($_SESSION["CompanyID"] ==  $row["intCompanyID"])
                    //	echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
                    //else
                        echo "<option value=\"". $row["strMainID"] ."\">" . $row["strName"] ."</option>" ;
                }
                
                ?>
                  </select></td>
                  </tr>
                <tr>
                  <td class="normalfnt" height="24">Store Name&nbsp;<span class="compulsoryRed">*</span></td>
                  <td colspan="3"><input name="txtStoreName" id="txtStoreName" type="text" style="width:250px;" class="txtbox" maxlength="30" tabindex="2"/></td>
                </tr>
                <tr>
                  <td class="normalfnt" height="24">Company Name&nbsp;<span class="compulsoryRed">*</span></td>
                  <td colspan="3"><select id="cboFactory" name="cboFactory" style="width:250px;" class="txtbox" tabindex="3" disabled="disabled">
                    <?php
                
                $SQL = "SELECT intCompanyID,strName FROM companies c where intStatus='1' order by strName;";
                
                $result = $db->RunQuery($SQL);
                	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
                while($row = mysql_fetch_array($result))
                {
                    if ($_SESSION["FactoryID"] ==  $row["intCompanyID"])
                    	echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
                    else
                        echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
                }
                
                ?>
                  </select></td>
                </tr>
                <tr>
                  <td class="normalfnt" height="24">Remarks</td>
                  <td colspan="3">
                    <textarea name="txtRemarks" id="txtRemarks" type="text" style="width:340px;height:30px;" class="txtbox" onkeypress="return imposeMaxLength(this,event, 50);" tabindex="4"></textarea>                  </td>
                </tr>
                <tr>
                  <td class="normalfnt" height="24">Auto Assign Bin </td>
                  <td width="36"><input type="checkbox" name="chkAutoBin" id="chkAutoBin" tabindex="5" onclick="activeVirtualSubstore();"/></td>
                  <td class="normalfnt" colspan="2">&nbsp;
                    <input name="txtVirSubStore" id="txtVirSubStore" type="text" style="width:200px; display:none" class="txtbox" maxlength="30" tabindex="2"/></td>
                </tr>
<tr>
                  <td class="normalfnt" height="24">Default Bin </td>
                  <td width="36"><input type="checkbox" name="chkCommonBin" id="chkCommonBin" tabindex="6"/></td>
                  <td class="normalfnt" colspan="2">&nbsp;
                    </td>
</tr>                <tr>
                  <td class="normalfnt" height="24">Active</td>
                  <td colspan="3"><input type="checkbox" name="chkMainActive" id="chkMainActive" checked="checked" tabindex="7"/></td>
                </tr>
                <tr>
                  <td height="36" colspan="4" class="tableBorder1" align="center"><img src="../../images/new.png" class="mouseover" alt="Add" id="butNew" name="Add" onclick="ClearForm(1);" tabindex="9"/><img src="../../images/save.png" onclick="SaveMainStores();" class="mouseover" alt="Add" tabindex="8" id="butSave"/><img   class="mouseover" src="../../images/delete.png" alt="Delete" name="Delete" id="butDelete" tabindex="6" onclick="ConfirmDeleteStore(this.name);"/></td>
                  </tr>
            </table>
        </div>      </td>
    </tr>
  </table>
</div>
</td>
</tr>
</table>
</body>
</html>
