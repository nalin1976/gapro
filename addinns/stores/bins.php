<?php
 session_start();
 $backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
 include "../../Connector.php";
 
$locationID = $_GET["locID"];
$_SESSION["locationID"] =  $locationID;
$mainID = $_SESSION["mainStore"];
$subStoreID = $_SESSION["subStore"] ;
$factory=$_SESSION["FactoryID"];

$SQL="SELECT *  FROM mainstores WHERE  strMainID = '$mainID'";
$result=$db->RunQuery($SQL);
$row=mysql_fetch_array($result);
$commonBin=$row["intCommonBin"];

$SQL="SELECT *  FROM mainstores WHERE  intSourceStores = '$mainID' AND intAutomateCompany = '1' ";
$result=$db->RunQuery($SQL);
$row=mysql_fetch_array($result);
$virtualMainStoreID=$row["strMainID"];
 
//if($virtualMainStoreID!=0){ 
$SQL="select s.strSubID from substores as s join mainstores as m on s.strMainID=m.strMainID WHERE  m.strMainID=s.strMainID AND s.intSourceStores='$subStoreID' AND m.intAutomateCompany=1;";
$result=$db->RunQuery($SQL);
$rowS=mysql_fetch_array($result);
$virtualSubStore=$rowS["strSubID"];

$SQL="select s.strLocID from storeslocations as s join mainstores as m on s.strMainID=m.strMainID WHERE  m.strMainID=s.strMainID AND s.intSourceStores='$locationID' AND m.intAutomateCompany=1;";
$result=$db->RunQuery($SQL);
$rowL=mysql_fetch_array($result);
$virtualLocation=$rowL["strLocID"];
//}
 
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Bins - Store Location Wizard</title>
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
<script src="../../javascript/script.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
var messageString = "bin " ;
var mainStore = <?php echo  $mainID;?> ;
var substore = <?php echo  $subStoreID;?> ;
var locationID = <?php echo  $locationID;?> ;
var commonBin = <?php echo $commonBin;?> ;

<?php
if($virtualMainStoreID==""){
 $virtualMainStoreID="''";
 $virtualSubStore="''";
 $virtualLocation="''";
 }
?>

var virtualMainStore = <?php echo $virtualMainStoreID;?> ;
var virtualSubStore = <?php echo $virtualSubStore;?> ;
var virtualLocation = <?php echo $virtualLocation;?> ;

</script>
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
      <td width="128" class="bcgcolor"><div align="center" class="head1">[ <a href="stroeLocation.php?subID=<?php echo $subStoreID; ?>">Locations</a> ]</div></td>
      <td width="129" class="bcgcolor-highlighted"><div align="center" class="head1">[ Bins ]</div></td>
    </tr>
    <!--<tr>
      <td colspan="4" class="head1"><br />
      &nbsp;Manage Bins - Store Location Wizard </td>
    </tr>-->
    <tr>
      <td colspan="4" class="normalfnt2"><br />
      Available Bins </td>
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

			$sql = "SELECT strBinID,strLocID,strBinName,storesbins.strRemarks,storesbins.intStatus FROM storesbins join mainstores on mainstores.strMainID=storesbins.strMainID WHERE storesbins.strMainID = '$mainID' AND storesbins.strSubID = '$subStoreID' AND storesbins.strLocID = '$locationID' and  mainstores.intCompanyId =  '".$_SESSION["FactoryID"]."' and storesbins.intStatus<>10 order by storesbins.strBinName;" ;
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
        
		<?php 
		if($commonBin==1){
		?>
          <td height="5">&nbsp;</td>
		<?php 
		}else{
		?>
          <td><img src="../../images/manage.png" id="<?php echo  $row["strBinID"]; ?>" alt="<?php echo  $row["strBinName"]; ?>" onClick="showManageBinForm(this);" class="mouseover"></td>
		<?php 
		}
		?>
		  
          <td class="normalfnt"><?php echo  $row["strBinName"]; ?></td>
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
          <td align="right"><a href="../../main.php"><img src="../../images/close.png" alt="close" class="mouseover noborderforlink" /></a></td>
          <td align="left" ><a href="stroeLocation.php?subID=<?php echo $subStoreID; ?>"><img src="../../images/back.png" alt="back" class="mouseover noborderforlink" /></a></td>
        </tr>
      </table></td>
      </tr>
    <tr>
      <td colspan="4"   bgcolor="#FFD5AA" align="right"><img src="../../images/addnew2.png" onclick="showAddNew('binStoresDiv',161);" /></td>
    </tr>
    <tr>
    	<td colspan="4">
        <div style="visibility:hidden;width:100%;height:0px;" id="binStoresDiv">
		<table width="99%" align="center"  cellpadding="1" cellspacing="0" border="0">
    <tr>
      <td width="80"><span class="normalfnt">Search</span></td>
      <td width="426"><select id="cboSearch" name="cboSearch" style="width:250px;" class="txtbox" onchange="LoadBinDetails(this);">
        <?php
                
			$SQL = "SELECT strBinID,strLocID,strBinName,storesbins.strRemarks,storesbins.intStatus FROM storesbins join mainstores on mainstores.strMainID=storesbins.strMainID WHERE storesbins.strMainID = '$mainID' AND storesbins.strSubID = '$subStoreID' AND storesbins.strLocID = '$locationID' and  mainstores.intCompanyId =  '".$_SESSION["FactoryID"]."'  and storesbins.intStatus<>10 order by storesbins.strBinName;" ;
                
                $result = $db->RunQuery($SQL);
                	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
                while($row = mysql_fetch_array($result))
                {
                	echo "<option value=\"". $row["strBinID"] ."\">" . $row["strBinName"] ."</option>" ;
                }
                
                ?>
      </select><input type="hidden" id="cboFactory" name="cboFactory" value="<?php echo $factory ?>" /></td>
      </tr>
    <tr>
      <td class="normalfnt" height="24">Bin Name&nbsp;<span class="compulsoryRed">*</span></td>
      <td>
        <input name="txtStoreName" id="txtStoreName" type="text" style="width:250px;" class="txtbox" maxlength="30"/>      </td>
    </tr>
    <tr>
      <td class="normalfnt" height="24">Remarks</td>
      <td>
        <textarea name="txtRemarks" id="txtRemarks" type="text" style="width:340px;height:50px;" class="txtbox" onkeypress="return imposeMaxLength(this,event, 100);"></textarea>      </td>
    </tr>
    <tr>
      <td class="normalfnt" height="24">Active</td>
      <td><input type="checkbox" name="chkSubActive" id="chkSubActive" checked="checked" /></td>
    </tr>
    <tr>
      <td height="36" colspan="2" align="center" class="tableBorder1"><img src="../../images/new.png" class="mouseover" alt="Add" onclick="ClearForm(2);"/><img src="../../images/save.png" onclick="SaveBin();" class="mouseover" alt="Add" /><img   class="mouseover" src="../../images/delete.png" alt="Delete" name="Delete" id="butDelete" tabindex="6" onclick="ConfirmDeleteBin(this.name);"/></td>
      </tr>
    </table>
    </div>
      </table>
</div>
</td>
</tr>
</table>
</body>
</html>
