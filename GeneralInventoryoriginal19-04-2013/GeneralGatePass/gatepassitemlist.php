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
<table width="650"  border="0" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
               	  <td height="450"><table width="100%" border="0" class="tableBorder">
                    <tr class="cursercross mainHeading" >
                      <td width="95%" height="25">General Gatepass Item Details </td>
                      <td width="5%" height="25" ><img src="../../images/cross.png" onclick="CloseOSPopUp('popupLayer1');" /></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="1">
                          <tr>
                            <td width="24%">Main Category </td>
                            <td colspan="2"><select name="select" id="cboPopMainCat" style="width:250px" onchange="LoadSubCat(this);">
                                <?PHP		
$sql="select intID, strDescription from genmatmaincategory where status=1 order by strDescription";
//echo $sql; 
$result =$db->RunQuery($sql);
	echo "<option value =\"".""."\">"."Select One"."</option>";
while ($row=mysql_fetch_array($result))
{		
	echo "<option value=\"".$row["intID"]."\">".$row["strDescription"]."</option>";
}
?>
                            </select></td>
                          </tr>
                          <tr>
                            <td class="normalfnt">Sub Category </td>
                            <td colspan="2"><select name="select2" id="cboPopSubCat" style="width:250px">
                                <?PHP		
$sql="select intSubCatNo, StrCatName from genmatsubcategory where intStatus=1  order by StrCatName";	 
$result =$db->RunQuery($sql);
	echo "<option value =\"".""."\">"."Select One"."</option>";
while ($row=mysql_fetch_array($result))
{		
	echo "<option value=\"".$row["intSubCatNo"]."\">".$row["StrCatName"]."</option>";
}
?>
                            </select></td>
                          </tr>
                          <tr>
                            <td class="normalfnt">Item Description </td>
                            <td width="52%"><input name="txtDesc" type="text" id="txtDesc" style="width:300px" onkeypress="LoadPopItems(event);"/></td>
                            <td width="24%"><img src="../../images/search.png" alt="search" align="absmiddle" onclick="LoadPopItems();" /></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" height="424" valign="top"><table style="width:650px" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPopItem1">
                          <thead>
                            <tr class="mainHeading4">
                              <th width="26" height="25" ><input name="checkbox" type="checkbox" onclick="CheckAll(this,'tblPopItem1');"/></th>
                              <th width="333" >Item Description</th>
                              <th width="69" >Unit</th>
                              <th width="83" >Stock Bal Qty</th>
                              <th width="51" >GRN No </th>
                              <th width="81" >GRN Year </th>
                              <th width="90" >Cost Center </th>
                              <th width="90" >GL Code</th>
                            </tr>
                          </thead>
                          <tbody >
                            <?php 
$sql="select MIL.intItemSerial,MIL.strItemDescription,OD.strUnit from orderdetails OD 
inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID
where OD.intStyleId=$styleId order by MIL.strItemDescription;";


$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>
                            <tr class="bcgcolor-tblrowWhite" ondblclick="addProcesses(this.id);">
                              <td height="20" class="normalfntMid" id="<?php echo $row['intMainCatID'];?>"><input name="checkbox" type="checkbox" /></td>
                              <td class="normalfnt" id="<?php echo $row['intItemSerial'];?>"><?php echo $row['strItemDescription'];?></td>
                              <td class="normalfnt"><?php echo $row['strUnit'];?></td>
                              <td class="normalfnt">&nbsp;</td>
                              <td class="normalfnt">&nbsp;</td>
                              <td class="normalfnt">&nbsp;</td>
                              <td class="normalfnt">&nbsp;</td>
                              <td class="normalfnt">&nbsp;</td>
                            </tr>
                            <?php
}
?>
                          </tbody>
                      </table></td>
                    </tr>
                    <tr>
                      <td colspan="2" height="21" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableBorder">
                        <tr>
				<td align="center"><img src="../../images/addsmall.png" alt="add" onclick="AddToMainPage();" />
				<img src="../../images/close.png" alt="close" onclick="CloseOSPopUp('popupLayer1');"  /></td>
				</tr>
                      </table></td>
                    </tr>
					
                    
                  </table></td>
			</table></td>
                </tr>
     <td height="2"></tr>
</table>
</body>
</html>