<?php
$backwardseperator = "../";
session_start();
include('../Connector.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    #tblPrcBody { height:270px;overflow:scroll;}
</style>
</head>
<body>
<table width="550"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder">
                        	
                        	<tr class="cursercross mainHeading" >
                            	<td width="94%" height="25">Search PR </td>
                                <td width="6%" height="25" ><img src="../images/cross.png" onclick="ClosePRPopUp('popupLayer1');" /></td>
                        	</tr>
                           <tr>
                            	<td colspan="2" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="1">
                                  <tr>
                                    <td width="22%">Factory</td>
                                    <td width="78%"><select id="cboPopMainCat" style="width:250px" onchange="LoadSubCategory(this);">
<?php
$sql="select intID,strDescription from genmatmaincategory where status=1 order by strDescription";
$result=$db->RunQuery($sql);
	echo "<option value="."".">"."All"."</option>\n";
while($row=mysql_fetch_array($result))
{
	echo "<option value=".$row["intID"].">".$row["strDescription"]."</option>\n";
}
?>
</select></td>
                                  </tr>
                                  <tr>
                                    <td class="normalfnt">Supplier</td>
                                    <td><select id="cboPopSubCat" style="width:250px">
<?php
$sql="select intSubCatNo,StrCatName from genmatsubcategory where intStatus=1 order by StrCatName";
$result=$db->RunQuery($sql);
	echo "<option value="."".">"."All"."</option>\n";
while($row=mysql_fetch_array($result))
{
	echo "<option value=".$row["intSubCatNo"].">".$row["StrCatName"]."</option>\n";
}
?>
</select></td>
                                  </tr>
                                  <tr>
                                    <td class="normalfnt">Item Description </td>
                                    <td><input name="txtDesc" type="text" id="txtDesc" style="width:250px"/td />
                                    <img src="../images/search.png" alt="search" align="absmiddle" onclick="LoadPopItems();" /></td>
                                  </tr>
                                </table></td>
                       	  </tr>
                            <tr>
                            	<td colspan="2">
                                	<table style="width:550px" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPopItem">
									<thead>				
                                    	<tr class="mainHeading4">
                                        	<th width="27" height="25" ><input type="checkbox" onclick="CheckAll(this,'tblPopItem');" style="visibility:hidden"/></th>
											<th width="432" >Item Description</th>
											<th width="87" >Unit</th>
										</tr>
										</thead>
                                        <tbody >
<?php 
$SQL_Processes="select intMainCatID,intItemSerial,strItemDescription,strUnit from genmatitemlist where intStatus=1 order by strItemDescription;";
$resPrc=$db->RunQuery($SQL_Processes1);
$i=1;
while($row=mysql_fetch_array($resPrc))
{
?>                                   
<tr class="bcgcolor-tblrowWhite">
<td height="20" class="normalfntMid" id="<?php echo $row['intMainCatID'];?>"><input name="checkbox" type="checkbox" onclick="AddDetailsToMainTbl(this)"></td>
<td class="normalfnt" id="<?php echo $row['intItemSerial'];?>"><?php echo $row['strItemDescription'];?></td>
<td class="normalfnt"><?php echo $row['strUnit'];?></td>
</tr>
                                        <?php $i++;}?>
                                      </tbody>
                                    </table>                                </td>
                            </tr>
                         </table>                    </td>
                </tr>
            </table>         </td>
     </tr>
</table>
</body>
</html>