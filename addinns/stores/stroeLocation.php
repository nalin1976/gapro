<?php
 session_start();
 $backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
 include "../../Connector.php";
 
 $subStoreID = $_GET["subID"];
 $_SESSION["subStore"] =  $subStoreID;
 $mainID = $_SESSION["mainStore"];
 
$SQL="SELECT *  FROM mainstores WHERE  intSourceStores = '$mainID' AND intAutomateCompany = '1' ";
$result=$db->RunQuery($SQL);
$row=mysql_fetch_array($result);
 $virtualMainStoreID=$row["strMainID"];

 $SQL="select s.strSubID from substores as s join mainstores as m on s.strMainID=m.strMainID WHERE  m.strMainID=s.strMainID AND s.intSourceStores='$subStoreID' AND m.intAutomateCompany=1;";
$result=$db->RunQuery($SQL);
$rowS=mysql_fetch_array($result);
 $virtualSubStore=$rowS["strSubID"];

$factory=$_SESSION["FactoryID"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Locations - Store Location Wizard</title>
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

var mainStore = <?php echo  $mainID;?> ;
var substore = <?php echo  $subStoreID;?> ;
var factory = <?php echo  $factory;?> ;
var messageString = "location " ;
<?php
if($virtualMainStoreID!=0){
?>
var virtualMainStore = <?php echo $virtualMainStoreID;?> ;
var virtualSubStore = <?php echo $virtualSubStore;?> ;
<?php
}
else{
$virtualMainStoreID="''";
$virtualSubStore="''";
?>
var virtualMainStore = <?php echo $virtualMainStoreID;?> ;
var virtualSubStore = <?php echo $virtualSubStore;?> ;
<?php
}
?>
</script>
<script src="../../javascript/script.js" type="text/javascript"></script>
</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "{$backwardseperator}Header.php";?></td>
  </tr>
  <tr>
    <td>
<div id="Layer1" class="divclass" style="height:auto;">
  <table width="515" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="129" class="bcgcolor"><div align="center" class="head1">[ <a href="mainStores.php">Main Stores</a> ]</div></td>
      <td width="129" class="bcgcolor"><div align="center" class="head1">[ <a href="subStores.php?mainID=<?php echo $mainID; ?>">Sub Stores</a> ]</div></td>
      <td width="128" class="bcgcolor-highlighted"><div align="center" class="head1">[ Locations ]</div></td>
      <td width="129" class="bcgcolor"><div align="center" class="head1">[ Bins ]</div></td>
    </tr>
    <!--<tr>
      <td colspan="4" class="head1"><br />
      &nbsp;Locations - Store Location Wizard </td>
    </tr>-->
    <tr>
      <td colspan="4" class="normalfnt2"><br />
      Available locations </td>
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

			$sql = "SELECT strLocID,strLocName,storeslocations.strRemarks, storeslocations.intStatus FROM storeslocations JOIN mainstores on mainstores.strMainID=storeslocations.strMainID WHERE storeslocations.strMainID = '$mainID' AND storeslocations.strSubID = '$subStoreID' and  mainstores.intCompanyId =  '".$_SESSION["FactoryID"]."' and storeslocations.intStatus<>10 order By strLocName";
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
        
          <td><input name="radiobutton" id="<?php echo  $row["strLocID"]; ?>" <?php if($_SESSION["locationID"] == $row["strLocID"]) { ?> checked="checked" <?php } ?> type="radio" value="radiobutton" /></td>
          <td class="normalfnt"><?php echo  $row["strLocName"]; ?></td>
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
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableBorder1">
        <tr>
          <td width="22%">&nbsp;</td>
          <td width="19%"><a href="../../main.php"><img src="../../images/close.png" alt="close" class="mouseover noborderforlink" /></a></td>
          <td width="20%" align="center"><a href="subStores.php?mainID=<?php echo $mainID; ?>"><img src="../../images/back.png" alt="back" class="mouseover noborderforlink" /></a></td>
          <td width="20%" align="center" ><img src="../../images/next.png" onclick="goToURL('bins.php?locID=');" class="mouseover" alt="next" width="95" height="24" /></td>
          <td width="19%" align="center" >&nbsp;</td>
        </tr>
      </table></td>
      </tr>
    <tr>
      <td colspan="4" align="right"  bgcolor="#FFD5AA"><img src="../../images/addnew2.png" onclick="showAddNew('locationStoresDiv',160);" /> </td>
    </tr>
    <tr>
    	<td colspan="4">
        <div style="visibility:hidden;width:100%;height:0px;" id="locationStoresDiv">
<table width="99%" align="center"  cellpadding="1" cellspacing="0" border="0">

       	<tr>
      <td width="105"><span class="normalfnt">Search</span></td>
      <td width="401"><select id="cboSearch" name="cboSearch" style="width:250px;" class="txtbox" onchange="LoadLocationDetails(this);">
        <?php
                
                $SQL = "select strLocID,strLocName  FROM storeslocations JOIN mainstores on mainstores.strMainID=storeslocations.strMainID WHERE storeslocations.strMainID = '$mainID' AND storeslocations.strSubID = '$subStoreID' and  mainstores.intCompanyId =  '".$_SESSION["FactoryID"]."' and storeslocations.intStatus<>10 order By strLocName";
                
                $result = $db->RunQuery($SQL);
                	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
                while($row = mysql_fetch_array($result))
                {
                	echo "<option value=\"". $row["strLocID"] ."\">" . $row["strLocName"] ."</option>" ;
                }
                
                ?>
      </select><input type="hidden" id="cboFactory" name="cboFactory" value="<?php echo $factory ?>" /></td>
      </tr>
    <tr>
      <td class="normalfnt" height="23">Location Name&nbsp;<span class="compulsoryRed">*</span></td>
      <td>
        <input name="txtStoreName" id="txtStoreName" type="text" style="width:250px;" class="txtbox" maxlength="30"/>      </td>
    </tr>
    <tr>
      <td class="normalfnt" height="24">Remarks</td>
      <td>
        <textarea name="txtRemarks" id="txtRemarks" type="text" style="width:340px;height:50px;" class="txtbox " onkeypress="return imposeMaxLength(this,event, 100);"></textarea>      </td>
    </tr>
    <tr>
      <td class="normalfnt" height="24">Active</td>
      <td><input type="checkbox" name="chkSubActive" id="chkSubActive" checked="checked" /></td>
    </tr>
    <tr>
      <td height="36" colspan="2" align="center" class="tableBorder1"><img src="../../images/new.png" class="mouseover" alt="Add" onclick="ClearForm(2);"/><img src="../../images/save.png" onclick="SaveLocation();" class="mouseover" alt="Add" /><img   class="mouseover" src="../../images/delete.png" alt="Delete" name="Delete" id="butDelete" tabindex="6" onclick="ConfirmDeleteLocation(this.name);"/></td>
      </tr>
    </table>
    </div>	    </td>
    </tr>
  </table>
</div>
</td>
</tr>
</table>
</body>
</html>
