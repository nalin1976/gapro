<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Component Editor</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script src="componenteditor.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<table width="71%" border="0" align="center" bgcolor="#FFFFFF">
   <tr  bgcolor="#660000" height="25px">
    <td style="color:#FFFFFF; text-align:center;" class="normalfnt">Component Editor</td>
   </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><table width="700" align="center" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF" class="bcgl1">
      <tr>
        <td ></td>
      </tr>
      <tr>
        <td width="60%"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
			   <tr>
                    <td width="35%" height="25" style="text-align:left"><dd>Process
                      </td>
						<td height="25" colspan="2" ><select name="cmbProcessId" class="txtbox" id="cmbProcessId" style="width:230px" onchange=" getComponent();">
                      <option value=""></option>
                      <?php 
			$str="select intProcessId,strProcess from ws_processes order by intProcessId ASC";
		
			$results=$db->RunQuery($str);
			
			while($row=mysql_fetch_array($results))
			{
		?>
                      <option value="<?php echo $row['intProcessId'];?>"><?php echo $row['strProcess'];?></option>
                      <?php } ?>
                      </select></td>
              <td width="27%" id="btnCategory" ><img src="../../images/add.png" alt="n" class="mouseover" onclick="edit_processes();" title='Add a New Process'/></td>
             </tr>
			  				 
				  
                  <tr>
                    <td width="35%" height="25" style="text-align:left"><dd>Component Category
                      </td>
                    <td height="25" colspan="2" ><select name="cmbCategoryId" class="txtbox" id="cmbCategoryId" style="width:230px" onchange=" getComponent();">
                      <option value=""></option>
                      <?php 
			$str="select 	intCategoryNo, 
					strCategory
					from 
					componentcategory 
					where intStatus=1
					order by strCategory";
		
			$results=$db->RunQuery($str);
			
			while($row=mysql_fetch_array($results))
			{
		?>
                      <option value="<?php echo $row['intCategoryNo'];?>"><?php echo $row['strCategory'];?></option>
                      <?php } ?>
                      </select></td>
      <td width="27%" id="btnCategory" ><img src="../../images/add.png" alt="n" class="mouseover" onclick="edit_category();" title='Add a New Component Category'/></td>
                  </tr>
				  
				   
                  <tr>
                    <td>&nbsp;</td>
                    <td width="2%">&nbsp;</td>
                    <td width="36%">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				  

			 
                  <tr>
                    <td height="25"><dd>Component <span style="color:#F00;"> *</span></dd></td>
                    <td colspan="3"><input name="txtComponent" type="text" class="txtbox" id="txtComponent" style="width:230px" tabindex="2" maxlength="100"/><input type="hidden" id="hiddn_componentid" /></td>
                  </tr>
                  <tr>
                    <td height="25"><dd>Description</dd></td>
                    <td colspan="2"><input name="txtDescription" type="text" class="txtbox" id="txtDescription" style="width:230px" tabindex="3" maxlength="200"/></td>
                    <td><div align="left"><input type="image" src="../../images/add_pic.png" alt="a"   class="mouseover" onclick="saveComponent();" tabindex="4"/></div></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="2"></td>
      </tr>
      <tr>
        <td class="bcgl1"><div align="center">
          <div id="divcons"  style="overflow:scroll; height:250px; width:100%;">
            <table width="100%"  cellpadding="0" cellspacing="1" bgcolor="#996f03" id="tblComponent">
                <tr class="grid_header">
                  <td width="10%" height="25" >Delete</td>
                  <td width="10%" height="25" >Edit</td>
				   <td width="25%" >Process</td>
                  <td width="35%" >Component</td>
                  <td width="35%"  >Description</td>
                </tr>
              </table>
          </div>
        </div></td>
      </tr>
      <tr>
        <td height="5"></td>
      </tr>
      <tr>
        <td class="tableBorder"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
                  <tr>
                    <td width="16%"><div align="center"></div></td>
                    <td width="17%"><img src="../../images/new.png" alt="n" width="96" height="24" class="mouseover" onclick="clear_forms()"/></td>
                    <td width="15%"><div align="center"><img src="../../images/save.png" alt="s" width="84" height="24" class="mouseover" onclick="save_all()"/></div></td>
                    <td width="19%"><div align="center"><img src="../../images/delete.png" alt="d" width="100" height="24" class="mouseover" onclick="mainfrm_delete()"/></div></td>
                    <td width="18%"><a href="../../main.php" ><div align="center"><img src="../../images/close.png" alt="c" width="104" height="24" class="mouseover noborderforlink" /></div></a></td>
                    <td width="15%">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="5"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</div>
</div>
</body>
</html>
