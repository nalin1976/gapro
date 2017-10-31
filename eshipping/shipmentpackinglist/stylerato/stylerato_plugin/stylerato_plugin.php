<?php
session_start();
	include "../../../Connector.php";		
	$backwardseperator = "../../../";
	include "../../../authentication.inc";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Ratio Plug-In</title>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../js/jquery-1.3.2.min.js"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>
<script src="styleratioplplugin.js" type="text/javascript"></script>
<script src="../../../javascript/tablednd.js" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}

-->
</style>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../../Header.php';?></td>
  </tr>
  <tr>
    <td align="center"><table width="400" border="0" cellspacing="0" cellpadding="0" style="padding:15px;">
      <tr>
        <th width="399" height="20" bgcolor="#316895" class="TitleN2white">Style Ratio Plug-In</th>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt bcgl1">
          
          <tr>
            <td  colspan="2" ><table width="100%" cellpadding="2" cellspacing="0">
              <tr>
                <td width="32%"  height="25">Order No</td>
                <td width="4%">&nbsp;</td>
                <td width="64%"><select name="cboOrder" class="txtbox ordercls" style="width:200px" id="cboOrder" onchange="fill_sizeratio_grid();">
                  <option value="Select One">Select One</option>
                  <?php $str_order		="select intOrderId,strOrder_No from orderspec where intStatus=1 order by strOrder_No";
		   		 $result_order	=$db->RunQuery($str_order);
				 while($datarow_order=mysql_fetch_array($result_order)){
			?>
                  <option value="<?php echo $datarow_order['intOrderId']?>"><?php echo $datarow_order['strOrder_No']?></option>
                  <?php 
			}			
			?>
                  </select></td>
              </tr>
              <tr>
                <td  height="25" colspan="2">Select a Previous Order(If you want)</td>
                <td><select name="cboPreOrder" class="txtbox" style="width:200px" id="cboPreOrder" onchange="fill_prevSizeRatio_grid(this);">
                  <option value="Select One">Select One</option>
                </select></td>
              </tr>
              </table></td>
            </tr>
         <!-- <tr>
            <th  colspan="2" class="mainHeading2" style="background-color:#CCC; text-align:center">Size Ratio</th>
            </tr>
          <tr>-->
            <td height="298" colspan="2" valign="top"><table width="399" border="0" cellspacing="1" cellpadding="0"  bgcolor="#CCCCFF" id="sizeratio_grid">
              <thead>
                <tr bgcolor="#498CC2" class="normaltxtmidb2">
                  <th width="10%" height="22" style="text-align:center"><input type="checkbox" id="checkBoxAll" name="checkBoxAll" /></th>
                  <th width="45%" style="text-align:center">Size</th>
                  <th width="45%" style="text-align:center">Net Weight</th>
                  </tr>
                </thead>
              <tbody>
                </tbody>
              </table>
              
              </td>
            </tr>
          <tr>
            <td height="15" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
              <tr>
                <td width="29%" height="36" >&nbsp;</td>
                <td width="24%"><img src="../../../images/save.png" id="butSave" /></td>
                <td width="22%"><img src="../../../images/next.png" id="butNext" />
                  </td>
                <td width="25%" style="text-align:center"></td>
                
                </tr>
              </table></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
<script src="../../../js/jquery.fixedheader.js" type="text/javascript"></script>
<script src="stylerato_plugin.js" type="text/javascript"></script>
</html>