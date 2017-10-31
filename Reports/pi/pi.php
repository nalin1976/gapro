<?php
$backwardseperator = "../../";
 session_start();
 include $backwardseperator."authentication.inc";
$factory = $_POST["cboFactory"];
$buyer = $_POST["cboCustomer"];
$styleID = "";

include $backwardseperator."Connector.php"; 
if ($_POST["txtStyle"] != "")
	$styleID = $_POST["txtStyle"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PI Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
<link href="../../bootstrap/css/bootstrap-select.min.css" type="text/css" rel="stylesheet" />

<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}

.textformat{
	font-family: Futura, 'Trebuchet MS', Arial, sans-serif;
	font-size:08pt;
	
}

.setcenter{
    text-align: center;
}
-->
</style>


<script src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="../../javascript/pi.js"></script>
<script type="text/javascript">



function resetCompanyBuyer()
{
	document.getElementById("cboFactory").value = "Select One";
	document.getElementById("cboCustomer").value = "Select One";
}

function submitForm()
{
	document.frmcomplete.submit();
}

function showBomReport()
{
	if (document.getElementById("cboStyles").value == "Select One")
	{
		alert("Please select a style.");
		return false;
	}
	var styleID = document.getElementById("cboStyles").value;
	window.open("bomitemreport.php?styleID=" + styleID);
}

$(function(){
    
    $("#btnSCView").click(function(){
        
        var styleId = $("#cboSR").val();
        
        if(styleId == '-1'){
            ValidateControls('Select style from the list');
            return;
        }
        
        viewReport(styleId)
        
    });
    
    $("#btnStyleView").click(function(){
        var styleId = $("#cboStyles").val();
        if(styleId == '-1'){
            ValidateControls('Select style from the list');
            return;
        }
        viewReport(styleId)
    });
    
    
    $("#btnExcelView").click(function(){
        
        var styleId = $("#cboSR").val();
        if(styleId == '-1'){
            ValidateControls('Select style from the list');
            return;
        }
        viewXLSReport(styleId)
    });
    
    $("#btnExcelViewStyle").click(function(){
        
        var styleId = $("#cboStyles").val();
        if(styleId == '-1'){
            ValidateControls('Select style from the list');
            return;
        }
        viewXLSReport(styleId)
        
    });
    
})

function viewXLSReport(prmstyleId){
   
    window.open("pixlsreport.php?styleID=" + prmstyleId); 
}

function viewReport(prmStyleID){
    
    window.open("bomitemreport.php?styleID=" + prmStyleID);
    
}

function viewreport(prmStyleCode){
    viewReport(prmStyleCode);
}

</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="">
    <tr>
      <td><?php include '../../Header.php'; ?></td>
    </tr>
  <table width="990" border="0" align="center" bgcolor="#FFFFFF"> 

    <tr>
      <td><table width="100%" border="0"  class="tableBorder">
        
        <tr>
          <td width="96%" height="25" class="mainHeading">Generate Production Instruction Report </td>
        </tr>
        <tr>
          <td><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="100%" border="0" class="tableBorder">
                      <tr><td colspan="3">&nbsp;</td></tr>      
                <tr>
                  <td width="10%" class="normalfnt">&nbsp;Buyer</td>
                  <td width="20%" class="normalfnt">
                    <select name="cboCustomer" class="selectpicker textformat" data-live-search="true" style="width:180px" id="cboCustomer">
                    <option value="-1" selected="selected">Select One</option>
                    
                  </select></td>
                  <td width="7%" >&nbsp;<button type="button" id="btnSearch" name="btnSearch" class="btn btn-primary">Search</button></td>
                  <td width="10%" >&nbsp;</td>
                  <td width="90" class="normalfnt">&nbsp;Order No </td>
                  <td width="210" valign="middle" class="normalfnt">
                      <select name="cboStyles" class="selectpicker textformat" data-live-search="true" style="width:150px" id="cboStyles">
                      <option value="-1" selected="selected">Select One</option>
                      </select></td>
                  <td width="48" class="setcenter">&nbsp;<button type="button" class="btn btn-primary" id="btnStyleView" name="btnStyleView">View</button></td>
                  <td width="21">&nbsp;<button type="button" class="btn btn-warning " id="btnExcelViewStyle" name="btnExcelViewStyle"><img src="../../images/excel.png"></img></button></td>
                </tr>
                      <tr><td colspan="4">&nbsp;</td></tr>
                <tr>
                  <td width="10%" class="normalfnt">&nbsp;</td>
                  <td width="20%" class="normalfnt">&nbsp;</td>
                  <td width="8%">&nbsp;</td>
                  <td width="7%">&nbsp;</td>
                  
                  <td width="10%" class="normalfnt">&nbsp;SC No</td>
                  <td width="20%" class="normalfnt">
                      <select name="cboSR" class="selectpicker textformat" data-live-search="true" style="width:150px" id="cboSR">
                      <option value="-1" selected="selected">Select One</option>
                      </select></td>
                  <td width="10%" class="setcenter">&nbsp;<button type="button" class="btn btn-primary" id="btnSCView">View</button></td>
                  
                  <td width="10%">&nbsp;<button type="button" class="btn btn-warning" id="btnExcelView" name="btnExcelView"><img src="../../images/excel.png"></img></button></td>
                  <td width="5%">&nbsp;</td>
                  </tr>
                      <tr><td>&nbsp;</td></tr>    
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td><div id="divData" width="100%" style="height:500px; overflow: scroll;">
            <table width="910" bgcolor="#CCCCFF" border="0" cellpadding="0" cellspacing="1" class=" table tableBorder" id="tblPreOders" >
                <thead>  
                    <tr >
                      <td width="15%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">Style No</td>
                      <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2L">SC No </td>
                      <td width="45%" bgcolor="#498CC2" class="normaltxtmidb2L">Description</td>
                      <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2L">Company</td>
                      <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer</td>                
                      <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Excel</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
          </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><div align="right"></div></td>
    </tr>
  </table>
</form>
<script src="../../bootstrap/js/bootstrap.min.js"></script>     
<script src="../../bootstrap/js/bootstrap-select.js"></script>    
</body>
</html>
