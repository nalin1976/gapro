<?php
$backwardseperator = "../";
session_start();
include('../../Connector.php');
$costcenter = $_GET["costcenter"];
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
<table width="550"  border="0" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder">
                        	
                        	<tr class="cursercross mainHeading" >
                            	<td width="94%" height="25">Item Details </td>
                                <td width="6%" height="25" ><img src="../../images/cross.png" onclick="CloseOSPopUp('popupLayer1');" /></td>
                        	</tr>
                           <tr>
                            	<td colspan="2" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="1">
                                  <tr>
                                    <td class="normalfnt">Main Category</td>
                                    <td><select id="cboPopMainCat" name="cboPopMainCat" style="width:250px" onchange="LoadSubCat(this.value);">
                                      <?PHP		
$sql="select distinct intID,strDescription
		from genmatmaincategory
		order by intID";	 
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
                                    <td><select id="cboPopSubCat" name="cboPopSubCat" style="width:250px">
                                      <?PHP		
$sql="select distinct intSubCatNo,StrCatName
		from genmatsubcategory
		order by StrCatName";	 
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
                                    <td width="22%" class="normalfnt">Item Description </td>
                                    <td width="78%"><input name="txtItemDesc" type="text" id="txtItemDesc" style="width:250px"/></td>
                                  </tr>
                                  <tr>
                                    <td class="normalfnt">Item Code </td>
                                    <td><input name="txtItemCode" type="text" id="txtItemCode" style="width:250px" maxlength="10"/>
                                    <div id="comboGLCode" style="width:90px;display:none"><select name="cboGLCode" class="txtbox" id="cboGLCode" style="width:90px" onchange="setGLDescription(this,this.parentNode.parentNode.rowIndex);" >
                  <?PHP		
$sql="select concat(GL.strAccID,'-',C.strCode) as GLCode,GLA.GLAccAllowNo
		from glallowcation GLA
		inner join glaccounts GL on GL.intGLAccID=GLA.GLAccNo
		inner join costcenters C on C.intCostCenterId=GLA.FactoryCode
		where GLA.FactoryCode='$costcenter' ";	 
$result =$db->RunQuery($sql);
	echo "<option value =\"".""."\"></option>";
while ($row=mysql_fetch_array($result))
{		
	echo "<option value=\"".$row["GLAccAllowNo"]."\">".$row["GLCode"]."</option>";
}
?>
                </select></div>
                                    <img src="../../images/search.png" alt="search" align="absmiddle" onclick="LoadPopItems();" /></td>
                                  </tr>
                                </table></td>
                       	  </tr>
                            <tr>
                            	<td colspan="2">
                                	<table style="width:550px" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPopItem">
									<thead>				
                                    	<tr class="mainHeading4">
                                        	<th width="27" height="25" ><input type="checkbox" onclick="CheckAll(this,'tblPopItem');" style="display:none"/></th>
											<th width="432" >Item Description</th>
											<th width="87" >Unit</th>
										</tr>
										</thead>

                                    </table></td>
                            </tr>
                         </table></td>
                </tr>
				<tr>
				<td align="center"><img src="../../images/addsmall.png" alt="add" onclick="AddToMainPage();" />
				<img src="../../images/close.png" alt="close" onclick="CloseOSPopUp('popupLayer1');"  /></td>
				</tr>
            </table></td>
     </tr>
</table>
</body>
</html>