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
                            	<td width="94%" height="25">GL Accounts </td>
                                <td width="6%" height="25" ><img src="../images/cross.png" onclick="ClosePRPopUp('popupLayer2');" /></td>
                        	</tr>
                           <tr>
                            	<td colspan="2" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="1">
                                  <tr>
                                    <td width="22%" class="normalfnt">Sub Category </td>
                                    <td width="78%"><select id="cboPopSubCat" style="width:250px">
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
                                </table></td>
                       	  </tr>
                            <tr>
                            	<td colspan="2">
                                	<table style="width:550px" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPopGl">
									<thead>				
                                    	<tr class="mainHeading4">
                                        	<th width="27" height="25" ><input type="checkbox" onclick="CheckAll(this,'tblPopItem');"  /></th>
											<th width="432" >Item Description</th>
											<th width="87" >Unit</th>
										</tr>
										</thead>
                                        <tbody >
<?php 
$SQL_Processes="select intItemSerial,strItemDescription,strUnit from genmatitemlist where intStatus=1 order by strItemDescription;";
$resPrc=$db->RunQuery($SQL_Processes);
$i=1;
while($row=mysql_fetch_array($resPrc))
{
?>                                   
<tr class="bcgcolor-tblrowWhite" ondblclick="addProcesses(this.id);">
<td height="20" class="normalfntMid"><input name="checkbox" type="checkbox"></td>
<td class="normalfnt" id="<?php echo $row['intItemSerial'];?>"><?php echo $row['strItemDescription'];?></td>
<td class="normalfnt"><?php echo $row['strUnit'];?></td>
</tr>
                                        <?php $i++;}?>
                                      </tbody>
                                    </table>                                </td>
                            </tr>
                         </table>
                    </td>
                </tr>
            </table>
         </td>
     </tr>
	 <tr>
	 	<td align="center">
		<img src="../images/addsmall.png" alt="add" width="95" height="24" />
		<img src="../images/close.png" alt="close" width="97" height="24" onclick="closeLayerByName('popupLayer');"/></td>
	 </tr>
</table>
</body>
</html>