<?php
 session_start();

 include "../Connector.php"; 
$backwardseperator	= "../";
 include "../authentication.inc";
$factory 			= $_POST["cboFactory"];
$buyer 				= $_POST["cboCustomer"];
$styleID 			= $_POST["cboStyles"];
$srNo 				= $_POST["cboSR"];
$status	 			= $_POST["cboStatus"];

if ($factory != "Select One")
{
	//$styleID = "Select One";
	$srNo = "Select One";
}
$userQuery = "";
$xml = simplexml_load_file('../config.xml');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Completion</title>
<link href="../css/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap-select.css" rel="stylesheet" type="text/css" />
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="../css/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-select.js"></script>
<script type="text/javascript" src="../javascript/script.js"></script>
<script type="text/javascript" src="ordercompletion.js"></script>


<!--  -->


<!--<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>



 -->
 <style>
     .btn{
         width:75px;
     }
 </style>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" action="ordercompletion.php">

  <table width="100%" border="0" align="center" class="">
      <tr>
      <td colspan="3"><?php include '../Header.php'; ?></td>
    </tr>
    <tr>
        <td width="10%">&nbsp;</td>  
      <td width="80%"><table width="100%" border="0">
        <tr>
          <td colspan="3" bgcolor="#316895"><div align="center" class="TitleN2white">Order Completion</div></td>
        </tr>
              <tr><td>&nbsp;</td></tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <tr>
              <td width="50%" height="21"><table width="960" border="0">
                <tr>
                  
                  
                  <td width="72" bgcolor="#99CCFF" class="form-lable">&nbsp;Buyer</td>
                  <td width="72" class="">
                      <select name="cboCustomer" class="selectpicker" style="width:180px" id="cboCustomer" data-live-search="true"></select>
                  </td>
                  <td width="72" bgcolor="#99CCFF" class="form-lable">&nbsp;Style No </td>
                  <td width="155" class="">
                      <select name="cboStyles" class="selectpicker" data-live-search="true" style="width:150px" id="cboStyles">
                            </select></td>
                  <td width="70" bgcolor="#99CCFF" class="form-lable">&nbsp;SC No</td>
                  <td width="150" class="">
                      <select name="cboSR" class="selectpicker" data-live-search="true" style="width:150px" id="cboSR"></select></td>
                  <td><div align="right">
                          <button type="button" class="btn btn-warning" id="btnSearch" name="btnSearch"><strong>Search</strong> </button>
                      </div></td>
                  </tr>
                
              </table></td>
              </tr>
          </table></td>
          </tr>
           <tr><td>&nbsp;</td></tr>
        <tr>
          <td colspan="3"><div id="divData" style="width:960px; height:450px; overflow: scroll; border-width:3px; border-style:solid;border-color:#99CCFF;">
                  <table width="937" border="0" cellpadding="0" cellspacing="1"  id="tblCompleteOrders" name="tblCompleteOrders" bgcolor="#ccccff" class="table table-bordered">
              <thead> 
                <tr>
                  <td width="2%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">
                      <!-- <input name="chkSelectAll" id="chkSelectAll" type="checkbox" value="checkbox" onchange="SelectAll(this)"/> -->
                      Select
                  </td>
                  <td width="2%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">
                      Raw Material Write-Off
                  </td>
                    <td width="16%" bgcolor="#498CC2" class="normaltxtmidb2">SC No</td>
                  <td width="16%" bgcolor="#498CC2" class="normaltxtmidb2">Style No</td>
                  <td width="24%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>              
                  <td width="24%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer</td>
                  <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Order Qty </td>
                  <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">View</td>
                </tr>
              </thead> 
                <tbody> </tbody>                    
            </table>
          </div></td>
        </tr>
        <tr><td>&nbsp;</td></tr>  
        <tr>
            <td width="507" bgcolor="" class="normalfntMid">&nbsp;</td>
            <td width="451" bgcolor="" align="right">
                <button class="btn btn-success btn-sm" type="button" id="btnSave" name="btnSave"><strong>Save</strong></button>
                <button class="btn btn-warning btn-sm" type="button" id="btnClose" name="btnClose"><strong>Close</strong></button>
               <!-- <img src="../images/save.png" alt="Confirm" align="right" class="mouseover" onclick="startCompletionProcess();" />
                <a href="../main.php"><img border="0" src="../images/close.png" align="right" class="mouseover" /></a>-->
            </td>
            <td>&nbsp;</td>
        </tr>
      </table></td>
        <td width="10%">&nbsp;</td>  
    </tr>
    
    
  </table>
</form>
    
</body>
</html>
