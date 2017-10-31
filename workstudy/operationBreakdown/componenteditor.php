<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operations</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="Button.js"></script>
<script src="ajaxupload.js"></script>
<script src="Operation.js"></script>
<script src="../../javascript/script.js"></script>

<style type="text/css">
.trans_one{
	width:500px; height:auto;
	border:1px solid;
	border-bottom-color:#FAD163;
	border-top-color:#FAD163;
	border-left-color:#FAD163;
	border-right-color:#FAD163;
	background-color:#FFFFFF;
	padding-right:15px;
	padding-top:10px;
	padding-left:30px;
	padding-right:30px;
	margin-top:20px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	-moz-border-radius-topright:10px;
	-moz-border-radius-topleft:10px;
	border-bottom:13px solid #FAD163;
	border-top:30px solid #FAD163;
}
</style>

</head>

<body>

<?php
include "../../Connector.php";
?>
<form id="frmPopComponents" name="frmPopComponents">
<div>
	<div align="center">
		<div class="trans_one">
		<div class="trans_text">Component Editor<span class="volu"><span id="country_popup_close_button"></span></span></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><table width="500" align="center" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF" class="bcgl1">
      <tr>
        <td ></td>
      </tr>
      <tr>
        <td width="40%"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
			   <tr>
                    <td width="35%" height="25" style="text-align:left"><dd>Process
                      </td>
                      <td height="25" colspan="2" ><select name="cmbProcessID" class="txtbox" id="cmbProcessID" style="width:200px" onchange="getComponent();">
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
              <td width="15%" id="btnCategory" ><img src="../../images/add.png" alt="n" class="mouseover" onclick="edit_processes();" title='Add a New Process'/></td>
             </tr>
			  				 
				  
                  <tr>
                    <td width="35%" height="25" style="text-align:left"><dd>Component Category
                      </td>
                    <td height="25" colspan="2" ><select name="cmbCategoryId" class="txtbox" id="cmbCategoryId" style="width:200px" onchange="getComponent();">
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
      <td width="15%" id="btnCategory" ><img src="../../images/add.png" alt="n" class="mouseover" onclick="edit_category();" title='Add'/></td>
                  </tr>
				  
					 <tr>
                    <td height="25"><dd>Component <span style="color:#F00;"> *</span></dd></td>
                    <td colspan="3"><input name="txtComponent" type="text" class="txtbox" id="txtComponent" style="width:200px" tabindex="2"/><input type="hidden" id="hiddn_componentid" /></td>
                  </tr>
                  <tr>
                    <td height="25"><dd>Description</dd></td>
                    <td colspan="2"><input name="txtDescription" type="text" class="txtbox" id="txtDescription" style="width:200px" tabindex="3"/></td>
                    <td><div align="left"><img src="../../images/add_pic.png" alt="a" width="72" height="18" class="mouseover" onclick="saveComponent();"/></div></td>
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
                  <td width="9%" height="25" >Delete</td>
                  <td width="8%" height="25" >Edit</td>
				   <td width="21%" >Process</td>
                  <td width="29%" >Component</td>
                  <td width="33%"  >Description</td>
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
                    <td width="19%"><div align="center"><img src="../../images/close.png" alt="c" width="97" height="24" class="mouseover" onclick="closePopup('popupLayer1');" /></div>
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
        
</div>
</div>
</div>

</form>
</body>
</html>
