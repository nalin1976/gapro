<?php
$backwardseperator = "../../../";
session_start();
include('../../../Connector.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    #tblPrcBody { height:270px;overflow:scroll;}
</style>
</head>
<body>
<table width="500" height="139"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td height="135">
        	<table width="100%" border="0" class="tableBorder">
              <tr class="cursercross mainHeading" >
                <td height="25" colspan="3">GL Accounts</td>
                <td width="10%" height="25" ><img src="../../../images/cross.png" onclick="CloseWindowInBC();" /></td>
              </tr>
              <tr>
                <td width="8%" class="normalfnt">Search</td>
                <td width="41%" align="left"><input name="txtGLSearch" type="text" id="txtGLSearch" style="width:200px" onkeypress="searchGLAcc(this,event);"/></td>
                <td width="41%" align="left"><b><select id="cboGL" name="cboGL" style="width:110px" >
							  <option value="strDescription" >Select One To Search</option>
							  <option value="strAccID">GL Code</option>
							  <option value="strDescription">GL Description</option>
							  </select></b></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4"><div style="overflow:scroll;height:350px;"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPrc">
                    <thead>
                      <tr bgcolor="#498CC2" class="normaltxtmidb2" height="20px;">
                        <th width="10%" class="grid_header"><input name="chkSelectAll" id="chkSelectAll" type="checkbox" value="checkbox" onclick="SelectAll(this)" /></th>
                        <th width="35%" class="grid_header">GL code</th>
                        <th width="65%" class="grid_header">GL Description</th>
                      </tr>
                    </thead>
                    <tbody >
                      <?php
										$id=$_GET['id'];
										
			$SQL_gl="select intGLAccID,strAccID,strDescription from glaccounts
where glaccounts.intStatus=1 order by strDescription";
										$result_gl=$db->RunQuery($SQL_gl);
										$i=1;
										$glacc="";
										while($row=mysql_fetch_array($result_gl))
										{
											$glacc = $row["intGLAccID"];
											
										$sql_chk="select intMatCatId,intGlId from budget_glallocationtomaincategory where 		intMatCatId='$id' and intGlId='$glacc' ;"; 
										$req="";
											$result_chk=$db->RunQuery($sql_chk);
											while($rows=mysql_fetch_array($result_chk))
											{
												
													$req="checked=\"checked\"";
											
													
											}
										
										$color=""; 
											if(($i%2)==1){$color='grid_raw';}else{$color='grid_raw2';}?>
                      <tr class="bcgcolor-tblrowWhite" id="<?php echo $i;?>" style="height:20px;cursor:pointer;">
                        <td class="<?php echo $color;?>"><input type="checkbox" name="checkGL2"  id="checkGL2" <?php echo $req ;?> />                        </td>
                        <td style="width:300px;text-align:left;" class="<?php echo $color;?>" id="<?php  echo $row["intGLAccID"];?>"><?php echo $row['strAccID'];?></td>
                        <td class="<?php echo $color;?>" style="width:10px;text-align:left"><?php echo $row['strDescription'];?></td>
                      </tr>
                      <?php $i++;}?>
                    </tbody>
                </table></div></td>
              </tr>
            </table>
        	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
              <tr>
                <td width="30%" align="center">
                <img src="../../../images/save.png" id="saveIMG" style="display:inline" onclick="saveData();"/>
                <img src="../../../images/close.png" border="0" class="mouseover" id="closeIMG" style="display:inline" onclick="CloseWindowInBC();"/></td>
              </tr>
      </table></td>
  </tr>
</table>
</body>
</html>