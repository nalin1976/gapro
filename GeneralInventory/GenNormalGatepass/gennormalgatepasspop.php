<?php
$backwardseperator = "../../";
session_start();
include('../../Connector.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    #tblPrcBody { height:270px;overflow:scroll;}
</style>

</head>
<body>
<table width="550"  border="0" align="center" bgcolor="#FFFFFF" id="popuplayer">
  <tr>
    <td height="205"><table width="100%" border="0" class="tableBorder">
      <tr class="cursercross mainHeading" >
        <td width="94%" height="25">Item Details </td>
        <td width="6%" height="25" ><img src="../../images/cross.png"  onclick="ClosePRPopUp('popupLayer1');" /></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="1">
            <tr>
              <td>PO No</td>
              <td><input name="txtPoPupPRNo" type="text" id="txtPoPupPRNo" style="width:250px" /></td>
            </tr>
            <tr>
              <td width="22%">Main Category </td>
              <td width="78%"><select name="select" id="cboPopMainCat" style="width:250px" onchange="loadSubCategory();" >
                  <?php

$sql="select intID,strDescription from genmatmaincategory where status=1 order by strDescription";
$result=$db->RunQuery($sql);
	echo "<option value="."".">"."All"."</option>\n";
while($row=mysql_fetch_array($result))
{
	echo "<option value=".$row["intID"].">".$row["strDescription"]."</option>\n";
	
}

?>
              </select> </td>
            </tr>
            <tr>
              <td class="normalfnt">Sub Category </td>
              <td><select id="cboPopSubCat" name="cboPopSubCat" style="width:250px">
              </select> </td>
            </tr>
            <tr>
              <td class="normalfnt">Description like </td>
              <td><input name="txtDetail" type="text" id="txtDetail" style="width:250px" />
                  <img src="../../images/search.png" alt="search" align="absmiddle" onclick="LoadPopItems();" /></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="50" colspan="2"><table style="width:550px" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPopItem">
            <thead>
              <tr class="mainHeading4">
                <th width="27" height="25" ><input name="checkbox" type="checkbox" onclick="CheckAll(this); "/></th>
                <th width="432" >Item Description</th>
                <th width="87" >Unit</th>
              </tr>
            </thead>
            <tbody >
              <?php 
$SQL_Processes="select intMainCatID,intItemSerial,strItemDescription,strUnit from genmatitemlist where intStatus=1 order by strItemDescription;";
$resPrc=$db->RunQuery($SQL_Processes);
$i=1;
while($row=mysql_fetch_array($resPrc))
{
?>
              <tr class="bcgcolor-tblrowWhite">
                <td height="20" class="normalfntMid" id="<?php echo $row['intMainCatID'];?>"><input name="checkbox" type="checkbox"/></td>
                <td class="normalfnt" id="<?php echo $row['intItemSerial'];?>"><?php echo $row['strItemDescription'];?></td>
                <td class="normalfnt" id ="<?php echo $row['strUnit'];?>"><?php echo $row['strUnit'];?></td>
              </tr>
              <?php $i++;}?>
            </tbody>
        </table></td>
      </tr>
    </table>
    <table  width="100%" border="0" class="tableBorder">
      <tr>
        <td width="18%" align="center"><img src="../../images/ok.png" alt="ok" onclick="addItemToMainTable();" />&nbsp;<img src="../../images/close.png" onclick="ClosePRPopUp('popupLayer1');"/> </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>