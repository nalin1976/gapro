<?php

	session_start();
	include "../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../";


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Plan line transfer to Navision</title>
<script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="planline.js"></script>
<link href="../bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
<style type="text/css">
	#divForm{border-radius: 4px; padding: 2px 2px 2px 2px; height: 420px; }
	.trStyle{height: 275px;}
	.trProgress{ height: 50px;}
	.listStyle{width:290px; font-family:Tahoma; font-size:8pt;}
	.setProgress{ background-color: #FFFFFF;   }

</style>
</head>
<body>

<form id="frmOrderList" action="" method="post">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><?php include '../Header.php';  ?></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
 	<tr><td>
    		<table width="100%" border="0">
    			<tr><td width="15%">&nbsp;</td>
                	<td width="60%">
                		<div id="divForm" class="form-control">	
                			<table width="100%" border="0">
                				<tr><td colspan="5">&nbsp;</td></tr>
                				<tr class="trStyle" ><td width="5%">&nbsp;</td>
                					<td width="40%" valign="top">
                						
                						<select size="15" id="unassignlist" name="unassignlist" class="listStyle form-control" style="height:270px;">
                							
                						</select>

                					</td>
                					<td width="10%">
                						<button id="btnAssign" name="btnAssign" type="button" class="btn" >>></button><br /><br />
                						<button id="btnUnAssign" name="btnUnAssign" type="button" class="btn" ><<</button>

                					</td>
                					<td width="40%" valign="top">
                						<select size="15" id="assignlist" name="assignlist" class="listStyle form-control" style="height:270px;">
                							
                						</select></td>
                					<td width="5%">&nbsp;</td>	
                				</tr>
                				<tr><td colspan="5">&nbsp;</td></tr>
                				<tr class="trProgress">
                					<td>&nbsp;</td>
                					<td colspan="3">
                						<input type="text" id="txtProgress" name="txtProgress" class="form-control setProgress" readonly="readonly" disabled="disabled"></input>
                					</td>
                					<td>&nbsp;</td>
                				</tr>
                				<tr><td colspan="4" align="right"><button id="btnTransfer" name="btnTransfer" type="button" class="btn"> Transfer </button></td><td>&nbsp;</td></tr>
                			</table>
                        </div>
                	</td>
                    <td width="25%">&nbsp;</td>
                </tr>
    		</table>
    	</td>
    </tr>
 </table>
 </form>   

</body>
</html>