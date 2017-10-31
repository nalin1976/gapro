<?php
$backwardseperator = "../../";
session_start();
include('../../Connector.php');
$orderNo	= $_GET["OrderNo"];
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
<table width="550"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder">
                        	
                        	<tr class="cursercross mainHeading" >
                            	<td width="94%" height="25">Item Details </td>
                                <td width="6%" height="25" ><img src="../../images/cross.png" onclick="CloseInvoiceCostPopUp('popupLayer1');" /></td>
                        	</tr>
                           <tr>
                            	<td colspan="2" class="normalfnt" style="display:none"><table width="100%" border="0" cellspacing="0" cellpadding="1">
                                  <tr>
                                    <td width="22%">Main Category </td>
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
                                    <td class="normalfnt">Sub Category </td>
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
                                    <img src="../../images/search.png" alt="search" align="absmiddle" onclick="LoadPopItems();" /></td>
                                  </tr>
                                </table></td>
                       	  </tr>
                            <tr>
                            	<td colspan="2" height="427" valign="top">
                                	<table style="width:550px;" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPopItem">
									<thead>				
                                    	<tr class="mainHeading4">
                                        	<th width="27" height="25" ><input type="checkbox" onclick="CheckAll(this,'tblPopItem');" /></th>
											<th width="432" >Item Description</th>
											<th width="87" >Unit</th>
										</tr>
										</thead>
                                        <tbody >
<?php 
$sql="select OD.intMatDetailID,MIL.strItemDescription,OD.strUnit from orderdetails OD
inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intMatDetailID not in (select strItemCode from invoicecostingdetails where intStyleId='$orderNo') and intStyleId='$orderNo' order by MIL.strItemDescription;";
$resPrc=$db->RunQuery($sql);
$i=1;
while($row=mysql_fetch_array($resPrc))
{
?>                                   
<tr class="bcgcolor-tblrowWhite">
<td height="20" class="normalfntMid" id="<?php echo $row['intMainCatID'];?>"><input name="checkbox" type="checkbox"></td>
<td class="normalfnt" id="<?php echo $row['intMatDetailID'];?>"><?php echo $row['strItemDescription'];?></td>
<td class="normalfnt"><?php echo $row['strUnit'];?></td>
</tr>
<?php 
$i++;
}
?>
                                      </tbody>
                                      </table></td>
                            </tr>
                         </table></td>
                </tr>

            </table></td>
     </tr>
	             	<tr>
            	  <td class="normalfntMid"><img src="../../images/addsmall.png" alt="Add" width="96" height="24" onclick="AddItemToMainGrid(<?php echo $orderNo;?>);" />
				  <img src="../../images/close.png" alt="close" width="97" height="24" onclick="CloseInvoiceCostPopUp('popupLayer1');"/></td>
          	  </tr>
</table>
</body>
</html>