<?php
$backwardseperator = "../";
session_start();
include('../Connector.php');
$styleId	= $_GET["StyleId"];
$color		= $_GET["color"];
$size		= $_GET["size"];
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
<table width="550"  border="0" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder">
                        	
                        	<tr class="cursercross mainHeading" >
                            	<td width="94%" height="25">Item Details </td>
                                <td width="6%" height="25" ><img src="../images/cross.png" onclick="CloseOSPopUp('popupLayer1');" /></td>
                        	</tr>
                           <tr>
                            	<td colspan="2" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="1">
                                  <tr>
                                    <td width="22%">Main Category </td>
                                    <td width="78%"><select id="cboPopMainCat" style="width:250px" onchange="LoadSubCat(this);">
<?PHP		
$sql="select distinct MC.intID,MC.strDescription from matmaincategory MC 
inner join matitemlist MIL on  MIL.intMainCatID=MC.intID
inner join orderdetails OD on OD.intMatDetailID=MIL.intItemSerial
where OD.intStyleId=$styleId order by MC.intID";
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
                                    <td><select id="cboPopSubCat" style="width:250px">
<?PHP		
$sql="select distinct MSC.intSubCatNo,MSC.StrCatName from matsubcategory MSC 
inner join matitemlist MIL on  MIL.intSubCatID=MSC.intSubCatNo
inner join orderdetails OD on OD.intMatDetailID=MIL.intItemSerial
where OD.intStyleId=$styleId order by MSC.StrCatName";	 
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
                                    <td><input name="txtDesc" type="text" id="txtDesc" style="width:250px" onkeypress="LoadPopItems(event);"/>
                                    <img src="../images/search.png" alt="search" align="absmiddle" onclick="LoadPopItems();" /></td>
                                  </tr>
                                </table></td>
                       	  </tr>
                            <tr>
                            	<td colspan="2">
                                	<table style="width:550px" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPopItem">
									<thead>				
                                    	<tr class="mainHeading4">
                                        	<th width="27" height="25" ><input type="checkbox" onclick="CheckAll(this,'tblPopItem');"/></th>
											<th width="432" >Item Description</th>
											<th width="87" >Unit</th>
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
<td height="20" class="normalfntMid" id="<?php echo $row['intMainCatID'];?>"><input name="checkbox" type="checkbox"></td>
<td class="normalfnt" id="<?php echo $row['intItemSerial'];?>"><?php echo $row['strItemDescription'];?></td>
<td class="normalfnt"><?php echo $row['strUnit'];?></td>
</tr>
<?php
}
?>                                     </tbody>
                                    </table></td>
                            </tr>
                         </table></td>
                </tr>
				<tr>
				<td align="center"><img src="../images/addsmall.png" alt="add" onclick="AddToMainPage();" />
				<img src="../images/close.png" alt="close" onclick="CloseOSPopUp('popupLayer1');"  /></td>
				</tr>
            </table></td>
     </tr>
</table>
</body>
</html>