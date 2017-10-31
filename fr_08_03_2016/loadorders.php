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
<link href="../css/jquery-ui.css" type="text/css" rel="stylesheet" />
<script src="../js/jquery-1.9.1.js" type="text/javascript" ></script>
<script src="../js/jquery-ui.js" type="text/javascript"></script>
<script src="fr.js" type="text/javascript" ></script>
<style>
	#p{ width:500px; height:28px;
			
	}
	
	div{ font-family:Verdana, Geneva, sans-serif; font-size:10px;}
</style>

</head>
<body onload="GetOrderCnt(); ">

<form id="frmOrderList" action="" method="post">



<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><?php include '../Header.php';  ?></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
 	<tr><td>&nbsp;</td></tr>
   	
 	 <tr><td>
     	<table width="100%" border="0">
            	<tr><td width="20%">&nbsp;</td>
                	<td width="60%">
                    	<table width="100%" border="0">
                        	<tr><td><div style="float:left;">Transfering Order &nbsp;</div><div id="txtHint"></div></td></tr>
                        	<!--<tr><td><div id="txtRecCnt"></div></td></tr>-->
                            <tr><td><progress id="p" value="10" max="1180" ></progress></td></tr>
                            <tr><td><div id="txtLabel"></div></td></tr>
                            <tr><td><div>Page will redirect with in 60 seconds</div><div><a href="orderlist.php">Click here to order list</a></div></td></tr>
                        </table>
                    </td>
                    <td width="20%">&nbsp;</td>
                 </tr>
         </table>           
     </td></tr>
  	
  	
</table> 

<?php   
/*set_time_limit ( 60 ) ;
 $strsql = " SELECT * FROM specification ";
 
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