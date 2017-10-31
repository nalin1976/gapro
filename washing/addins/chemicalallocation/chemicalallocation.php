<?php
$backwardseperator = "../../../";
include "../../../Connector.php";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Chemical Allocation</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="chemicalallocation.js"></script>
<script src="../../../javascript/script.js"></script>
</head>
<body>

<form id="frmChemicalAllocation" name="frmChemicalAllocation"  method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "../../../Header.php";?></td>
  </tr>
  <tr>
    <td><table width="600" border="0" align="center">
      <tr>
        <td width="62%"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="35" align="center" bgcolor="#660000" class="mainHeading">Chemical Allocation</td>
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
                  <td width="25%" height="11" class="normalfnt">Process Name </td>
                  <td><select name="cboSearch" class="txtbox" id="cboSearch" style="width:200px" tabindex="1" onchange="LoadChemical(this.value);">		  
				  <?php
	$SQL="select intSerialNo,strProcessName from was_washformula where intStatus=1 order by strProcessName";		
	$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intSerialNo"] ."\">" . $row["strProcessName"] ."</option>" ;
	}		  
			  
				  ?>

				  
                                                      </select></td>
                </tr>
              
				      
                <tr>
                  <td width="8%" class="normalfnt">&nbsp;</td>
				  
                  <td class="normalfnt">&nbsp;</td>                 
				  <td>&nbsp;</td>
                  </tr>
				    <tr class="mainHeading4" >
                        <td colspan="3"><img src="../../../images/add_pic.png" alt="add New"align="right" onclick="OpenChemicalPopUp();"/></td>
                  </tr>
				  <tr>
				    <td colspan="3" class="normalfntMid" >
					<div style="overflow:scroll;height:300px;">
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" id="tblMain">
                    
						
                      <tr class="mainHeading4" height="25" >
                        <th width="4%">Del</th>
                        <th width="64%">Chemical Description </th>
                        <th width="18%">Unit</th>
                        <th width="14%">Unit Price </th>
                      </tr>
                    </table>
					</div></td>
                      </tr>                
              </table>            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0"class="tableBorder">
			<tr>
				<td width="25%" align="center"><img src="../../../images/new.png" alt="New" name="New" width="96" height="24" onclick="ClearForm();" class="mouseover" id="butNew" tabindex="10"/>
				<img src="../../../images/save.png" alt="Save" name="Save" width="84" height="24" onclick="SaveRow();" class="mouseover" id="butSave" tabindex="6"/><a href="../../../main.php"><img src="../../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="butClose" tabindex="9"/></a></td>			  	  
			</tr>
            </table></td>
          </tr>
        </table></td>
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
