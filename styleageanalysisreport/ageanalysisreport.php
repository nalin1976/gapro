<?php
	session_start();
	include "../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Age Analysis :: Report</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../Units/css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js"></script>
<script type="text/javascript" src="ageanalysisreport.js"></script>
</head>

<body>
<form id="frmbanks" name="form1" method="post" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="35" bgcolor="#498CC2" class="TitleN2white">Stock Reports</td>
          </tr>
          <tr>
            <td height="96"><table width="575" border="0">
              <tr>
                <td width="162" class="normalfnt2bld">Main Category </td>
                <td width="403"><select name="cboMainCat" class="txtbox" id="cboMainCat" style="width:285px" onchange="LoadSubCategory(this);">
<?php
	$sqlMainCat="select intID,strDescription from matmaincategory;";
	$result_MainCat=$db->RunQuery($sqlMainCat);
			echo "<option value=></option>";
		while($row_MainCat=mysql_fetch_array($result_MainCat)){
			echo "<option value=\"".$row_MainCat["intID"]."\">".$row_MainCat["strDescription"]."</option>";
		}
?>     
	            </select></td>
              </tr>
              <tr>
                <td class="normalfnt2bld">Sub Category </td>
                <td><select name="cboMatSubCat" class="txtbox" id="cboMatSubCat" style="width:285px" onchange="LoadMatDescription();">
                </select></td>
              </tr>
              <tr>
                <td class="normalfnt2bld">Description </td>
                <td><select name="cboMatDescription" class="txtbox" id="cboMatDescription" style="width:285px">
                </select></td>
              </tr>
              <tr>
                <td class="normalfnt2bld">Color</td>
                <td><select name="cboColor" class="txtbox" id="cboColor" style="width:285px">
<?php
	$sqlColor="select strColor from colors where intStatus=1 order by strColor;";
	$result_Color=$db->RunQuery($sqlColor);
			echo "<option value=></option>";
		while($row_Color=mysql_fetch_array($result_Color)){
			echo "<option value=>".$row_Color["strColor"]."</option>";
		}
?>
                </select></td>
              </tr>
              <tr>
                <td class="normalfnt2bld">Size</td>
                <td><select name="cboSize" class="txtbox" id="cboSize" style="width:285px">
<?php
	$sqlSize="select distinct strSize from sizes where intStatus=1 order by strSize;";
	$result_Size=$db->RunQuery($sqlSize);
			echo "<option value=></option>";
		while($row_Size=mysql_fetch_array($result_Size)){
			echo "<option value=>".$row_Size["strSize"]."</option>";
		}
?>
                </select></td>
              </tr>
              <tr bgcolor="#D6E7F5">
                <td class="normalfnt2bld">Company</td>
                <td><select name="cboCompany" class="txtbox" id="cboCompany" style="width:285px">
<?php
	$sqlCompany="select intCompanyID,strName from companies where intStatus=1;";
	$result_Company=$db->RunQuery($sqlCompany);
			echo "<option value=></option>";
		while($row_Company=mysql_fetch_array($result_Company)){
			echo "<option value=\"".$row_Company["intCompanyID"]."\">".$row_Company["strName"]."</option>";
		}
?>
                </select></td>
              </tr>
            </table>            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
                    <tr>
                      <td width="22%">&nbsp;</td>
                      <td width="20%"><img src="../images/refreshico.png" alt="New" name="New" width="96" height="24" onclick="ClearForm();"/></td>
                      <td width="22%"><img src="../images/report.png" alt="report" width="108" height="24" onclick="ViewReport();" /></td>
                      <td width="21%"><a href="../main.php"><img src="../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                      <td width="15%">&nbsp;</td>
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
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>


</body>
</html>
