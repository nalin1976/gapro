<?php
$backwardseperator = "../../../";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operators</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="operators.js"></script>
<script src="../../../javascript/script.js"></script>
</head>
<body>
<?php
include "{$backwardseperator}Connector.php";
?>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "{$backwardseperator}Header.php";?></td>
  </tr>
 </table>
<form id="frmOperators" name="frmOperators"  method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="70%" border="0" align="center">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="35" align="center" bgcolor="#660000" class="mainHeading">Operators</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0">
                <tr>
                  <td colspan="2" class="normalfnt">&nbsp; </td>
                  <td width="67%">&nbsp;</td>		
                </tr>
                <tr>
                  <td width="8%" class="normalfnt">&nbsp;</td>
                  <td width="25%" height="11" class="normalfnt">Search</td>
                  <td><select name="cboSearch" class="txtbox" id="cboSearch" onchange="LoadDetails(this);" style="width:252px" tabindex="1">		  <?php
	$SQL="SELECT intOperatorId ,strName FROM was_operators WHERE intStatus <> 10 order by strName ASC";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intOperatorId"] ."\">" . $row["strName"] ."</option>" ;
	}		  
			  
				  ?>

				  
                                                      </select></td>
        
                </tr>
              <tr>
				  <td width="8%" class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Section&nbsp;<span class="compulsoryRed">*</span></td>                 
				  <td>
                  	<select name="cboSection" class="txtbox" id="cboSection" onchange="selectOpatatorType(this)" style="width:160px" tabindex="2">		  			  
                  	<?php
					$sql = "select intDepartmentId,strDepartmentName from was_department where intStatus=1 order by strDepartmentName"; 
					$result = $db->RunQuery($sql);
					echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intDepartmentId"] ."\">" . $row["strDepartmentName"] ."</option>" ;
					}		  
					?>
                    </select>
                  </td>
         
				 
                  </tr>
				      
                <tr id="machineRow">
				  <td width="8%" class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Machine name&nbsp;<span class="compulsoryRed">*</span></td>                 
				  <td><select name="cboMachineName" class="txtbox" id="cboMachineName" onchange=""style="width:160px" tabindex="2">		  <?php
	$SQL="SELECT intMachineId,strMachineName FROM was_machine WHERE   strMachineName <> 10 ";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intMachineId"] ."\">" . $row["strMachineName"] ."</option>" ;
	}		  
			  
				  ?>

				  
                                                      </select></td>
         
				 
                  </tr>
				  
				  <tr>
                  <td width="8%" class="normalfnt">&nbsp;</td>
				  <td class="normalfnt"> Shift&nbsp;<span class="compulsoryRed">*</span> </td>
				  <td><select name="cboShitf" class="txtbox" id="cboShitf" onchange=""style="width:160px" tabindex="3">
				  		  <?php
	$SQL="SELECT intShiftId,strShiftName FROM was_shift WHERE intStatus <>10 order by strShiftName";		
		$result = $db->RunQuery($SQL);
		
		echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intShiftId"] ."\">" . $row["strShiftName"] ."</option>" ;
	}		  
			  
				  ?>

				  
                                                      </select> </td>
				  </tr>
                  <tr>
                  <td width="8%" class="normalfnt">&nbsp;</td>
				  <td class="normalfnt">Epf Number&nbsp;<span class="compulsoryRed">*</span></td>
				  <td><input name="txtEpfNo" type="text" class="txtbox" id="txtEpfNo"  style="width:100px;" maxlength="10" tabindex="4"/></td></tr>
				  <tr>
				  <tr>
                  <td width="8%" class="normalfnt">&nbsp;</td>
				  <td class="normalfnt">Name&nbsp;<span class="compulsoryRed">*</span></td>
				  <td><input name="txtName" type="text" class="txtbox" id="txtName"  style="width:250px;" maxlength="50" tabindex="4"/></td></tr>
				  <tr>
                  
                  <td width="8%" class="normalfnt">&nbsp;</td>
				  <td class="normalfnt">Remarks</td>
				  <td><input name="textRemarks" type="text"  class="textbox" id="txtRemarks"  style="width:250px;" maxlength="50" tabindex="5"/></td>
				  </tr>
				  <tr>
                
                  	  <td width="8%" class="normalfnt">&nbsp;</td>
                      <td width="23%"  class="normalfnt">Active</td>
                      <td><input type="checkbox" name="chkActive" id="chkActive" checked="checked" tabindex="6"/></td>
                    </tr>                
              </table>
            </td>
          </tr>
          <tr>
            <td height="34" align="center">
            <div style="border:solid #CCC 1px;">
              <img src="../../../images/new.png" alt="New" name="New" width="96" height="24" onclick="ClearForm();" class="mouseover" id="butNew" tabindex="10"/><img src="../../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="optSave(this);" class="mouseover" id="butSave" tabindex="6"/><img src="../../../images/delete.png" alt="Delete" name="Delete"
					  width="100" height="24" onclick="ConfirmDelete(this.name)" class="mouseover" id="butDelete" tabindex="7"/><img src="../../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="ViewOperatorReport();" id="butReport" tabindex="8" style="display:none;"/><a href="../../../main.php">
                       <img src="../../../images/close.png" name="Close"  border="0" id="butClose" tabindex="9"/>
                       </a>
               </div>     
              </td>
             </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp; </td>
      </tr>
    </table></td>
  </tr>
  </tr>
  <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
