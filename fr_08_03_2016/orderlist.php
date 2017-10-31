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
<title>FR data exporter</title>

<link href="css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet" />
<link href="../css/cssStyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript" src="fr.js"></script>
<script>
	$(function(){
		$("#tabs").tabs();
	});
</script>
<style>
	
	.demoHeaders {
		margin-top: 2em;
	}
	#dialog-link {
		padding: .4em 1em .4em 20px;
		text-decoration: none;
		position: relative;
	}
	#dialog-link span.ui-icon {
		margin: 0 5px 0 0;
		position: absolute;
		left: .2em;
		top: 50%;
		margin-top: -8px;
	}
	#icons {
		margin: 0;
		padding: 0;
	}
	#icons li {
		margin: 2px;
		position: relative;
		padding: 4px 0;
		cursor: pointer;
		float: left;
		list-style: none;
	}
	#icons span.ui-icon {
		float: left;
		margin: 0 4px;
	}
	.fakewindowcontain .ui-widget-overlay {
		position: absolute;
	}
	#tabs-1{ overflow:scroll; height:330px;}
	#tabs-2{ overflow:scroll; height:330px;}
	#tabs-3{ overflow:scroll; height:330px;}
	
	.wrap table{ table-layout:fixed; }
	.inner_table{ overflow-y: auto;}
	</style>
</head>
<!--<body onload="GetOrderCnt();">-->
<body onload="LoadNotTransferList()">
<form id="frmOrderList" action="" method="post">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><?php include '../Header.php';  ?></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
 	<tr><td>
    		<table width="100%" border="0">
            	<tr><td width="10%">&nbsp;</td>
                	<td width="60%">
                		<div id="tabs">	
                			<ul style="font:Verdana, Geneva, sans-serif; font-size:10px;">
                            	<li id="list-orders"><a href="#tabs-1">Order List</a></li>
                                <li id="revise-order"><a href="#tabs-2">Revise Order</a></li>
                                <li id="revise-product"><a href="#tabs-3">Revise Product</a></li>
                            </ul>
                            <div id="tabs-1">
                            	
                            </div>
                            <div id="tabs-2">
                            	
                            </div>
                            <div id="tabs-3">
                            	
                            </div>
                        </div>
                	</td>
                    <td width="30%">&nbsp;</td>
                </tr>
                <tr><td>&nbsp;</td>
                	<td align="right"><span style="padding:0px 140px 0px 180px;"><input type="checkbox" id="chkNewFormat" checked="checked"/>&nbsp;<span class="newformat">New Format</span></span> <img id="imgClose" alt="Close" src="../images/close.png" style="float:right;" /> <img id="btnCreateFile" alt="Create File" src="../images/exceldw.gif" onclick="ExportFile();LoadNotTransferList();" style="float:right;" /> <img id="imgUpdate" alt="Update" src="../images/ok.png" /> 
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
    	</td>
    </tr>
  	<!--<tr><td><div id="txtHint"></div></td></tr>
 	 <tr><td>&nbsp;</td></tr>
  	<tr><td><div id="txtRecCnt"></div></td></tr>
  	<tr><td>&nbsp;</td></tr>
  	<tr><td><progress id="p" value="10" max="1180" ></progress></td></tr>
  	<tr><td>&nbsp;</td></tr>
  	<tr><td><div id="txtLabel"></div></td></tr>-->
</table> 
<div id="divDelivery">
<table id="tbDelivery" width="100%" border="0">
	<thead>
    	<th>Buyer PO No</th>
        <th>Delivery Qty</th>
        <th>Delivery Date</th>
        <th>Estimate Date</th>
        <th>HandOver Date</th>
    </thead>
	<tbody id="tbodyDelivery" class="tbBody"></tbody>
</table>

</div>
<?php   
//set_time_limit ( 60 ) ;
 /*$strsql = " SELECT * FROM specification ";
 
  $result = $db->RunQuery($strsql);
  $delay = 1;
  while($row=mysql_fetch_array($result)){
	  
	  
	  echo $row['intSRNO']."<br />";
	  flush();
	  ob_flush();
	  sleep($delay);
  }
 */
 
?>
</form>

</body>
</html>