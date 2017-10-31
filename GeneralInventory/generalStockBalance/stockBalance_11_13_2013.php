<?php
 session_start();
 $backwardseperator = "../../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General Stock Balance</title>

<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="stockbalance.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	
function viewReport()
{
var cboMainCat 		= document.getElementById('cboMainCat').value;
var cboSubCat  		= document.getElementById('cboSubCat').value;
var cboMatItem 		= document.getElementById('cboMatItem').value;
var txtmaterial 	= document.getElementById('txtmaterial').value;
var costCenter		= document.getElementById("cboCostCenter").value;
var GLCode			= document.getElementById("cboGLCode").value;
if(document.getElementById('bal').checked == true)
	var bal = 0;
else
	var bal = 1;

var x = document.getElementById('cc').value;

if(document.getElementById('detail').checked == true)
{
	var reportName = "detailReport.php";
	var url = reportName+'?id=report&cboMainCat='+cboMainCat+'&cboSubCat='+cboSubCat+'&cboMatItem='+cboMatItem+'&cboCompany='+x+'&bal='+bal;
}
else
{
	var reportName = "genStockbalReport.php";
	var url = reportName+'?id=report&cboMainCat='+cboMainCat+'&cboSubCat='+cboSubCat+'&cboMatItem='+cboMatItem+'&cboCompany='+x+'&bal='+bal+'&txtmaterial='+txtmaterial+'&CostCenter='+costCenter+'&GLCode='+GLCode;
}


window.open(url,reportName);
}

</script>
</head>

<body>

<?php

include "../../Connector.php";

?>


  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0" class="bcgl1">
          <tr>
            <td height="35" class="mainHeading">General Stock Balance</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="92%" class="normalfnt"><table width="100%" border="0" class="bcgl1">
                    <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">Main Category </td>
                      <td width="60%"><select name="cboMainCat" class="txtbox" id="cboMainCat" style="width:285px" onchange="LoadSubCategory(this)">
                        <?php
						$intMainCat = $_POST["cboMainCat"];
							
						$SQL = 	"SELECT genmatmaincategory.intID, genmatmaincategory.strDescription FROM genmatmaincategory ";
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						echo "<option  value=\"". $row["intID"] ."\">" . trim($row["strDescription"]) ."</option>" ;								
						}
						
						?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Sub Category </td>
                      <td><select name="cboSubCat" class="txtbox" id="cboSubCat" style="width:285px" onchange="LoadMaterial()">
                        <?php
						/*
						$intSubCatNo = $_POST["cboSubCat"];
							
						$SQL = 	"SELECT MSC.intSubCatNo, MSC.StrCatName FROM genmatsubcategory  MSC
								WHERE MSC.intCatNo <>'' ";
								
						if($intMainCat!='')
							$SQL .= " AND MSC.intCatNo =  '$intMainCat'";
							
						$SQL .= " order by MSC.StrCatName ";
						
						$result = $db->RunQuery($SQL);*/
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;/*
						while($row = mysql_fetch_array($result))
						{
							echo "<option  value=\"". $row["intSubCatNo"] ."\">" . trim($row["StrCatName"]) ."</option>" ;								
						}
						*/
						?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Material Like</td>
                      <td><input type="text" name="txtmaterial" id="txtmaterial" style="width:284px;" onkeypress="EnterSubmitLoadItem(event);" /></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Material</td>
                      <td><select name="cboMatItem" class="txtbox" id="cboMatItem" style="width:285px">
                    <?php
					/*
					$intMatItem = $_POST["cboMatItem"];
						
					$SQL = 	"SELECT genmatitemlist.intItemSerial, genmatitemlist.strItemDescription 
							FROM genmatitemlist ";		
					
					$SQL .= " Order By strItemDescription";
					$result = $db->RunQuery($SQL);*/
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					/*
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["intItemSerial"] ."\">" . trim($row["strItemDescription"]) ."</option>" ;								
					}
						*/
					?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Factory</td>
                      <td><select  name="cc" class="txtbox" id="cc" style="width:285px" onchange="LoadCostCenter(this)">
                    <?php
					
					$SQL = 	"SELECT intCompanyID,strName FROM companies";		

					$result = $db->RunQuery($SQL);
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["intCompanyID"] ."\">" . trim($row["strName"]) ."</option>" ;								
					}
						
					?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">Cost Center </td>
                      <td><select  name="cboCostCenter" class="txtbox" id="cboCostCenter" style="width:285px" onchange="LoadGLCode(this)">
                        <?php
					
					/*$SQL = 	"SELECT intCompanyID,strName FROM companies";		

					$result = $db->RunQuery($SQL);
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["intCompanyID"] ."\">" . trim($row["strName"]) ."</option>" ;								
					}*/
						
					?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">GL Code</td>
                      <td><select  name="cboGLCode" class="txtbox" id="cboGLCode" style="width:285px">
                        <?php
					
						$SQL = 	"select intGLAccID,strDescription from glaccounts where intStatus=1 
								 order by strDescription";		
	
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						echo "<option value=\"". $row["intGLAccID"] ."\">" . trim($row["strDescription"]) ."</option>" ;								
						}
							
						?>
                      </select></td>
                    </tr>
					
					<tr><td colspan="3"><table width="100%">
					
					                    <tr height="20">
                      <td class="normalfnt" width="5%">&nbsp;</td>
                      <td class="normalfnt" width="23%">&nbsp;</td>
                      <td class="normalfntRite">With 0 Balance&nbsp;<input type="radio" id="bal" name="bal"/></td>
                      <td class="normalfntRite">Without 0 Balance&nbsp;<input type="radio" checked="checked" name="bal"/></td>
                      <td class="normalfnt" width="20%">&nbsp;</td>
                    </tr>
					                    <tr>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfnt">&nbsp;</td>
                      <td class="normalfntRite">Detail Report&nbsp;&nbsp;&nbsp;<input type="radio" id="detail" name="detail" /></td>
                      <td class="normalfntRite">Summery Report&nbsp;&nbsp;<input type="radio" checked="checked"  id="detail" name="detail" /></td>
                      <td class="normalfnt" >&nbsp;</td>
                    </tr>
					
					</table></td></tr>
					
					
					
                  </table></td>
                  </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#FFE1E1"><table width="100%" border="0">
                    <tr>
                      <td width="21%">&nbsp;</td>                     
                      <td width="57%" ><img src="../../images/new.png" alt="new" onclick="ClearForm();"/><img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" onclick="viewReport();"/><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="22%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>

  
  
  
  
</table>

<script type="text/javascript">
function ClearForm(){	
	setTimeout("location.reload(true);",0);
}
</script>

</body>
</html>
