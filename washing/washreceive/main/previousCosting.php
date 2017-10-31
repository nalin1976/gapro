<?php
$backwardseperator = "../../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<style>

#tabbed_box_1 {
	margin: 0px auto 0px auto;
	width:480px;
}
.tabbed_box h4 {
	font-family:Arial, Helvetica, sans-serif;
	font-size:23px;
	color:#ffffff;
	letter-spacing:-1px;
	margin-bottom:10px;
}
.tabbed_box h4 small {
	color:#e3e9ec;
	font-weight:normal;
	font-size:9px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	text-transform:uppercase;
	position:relative;
	top:-4px;
	left:6px;
	letter-spacing:0px;
}
.tabbed_area {
	border:1px solid #FFF;
	background-color:#FFF;
	padding:8px;	
}

ul.tabs {
	margin:0px; padding:0px;
	margin-top:5px;
	margin-bottom:6px;
}
ul.tabs li {
	list-style:none;
	display:inline;
}
ul.tabs li a {
	background-color:#FFF;
	color:#000;
	padding:8px 14px 8px 14px;
	text-decoration:none;
	font-size:9px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-weight:bold;
	/*text-transform:uppercase;*/
	border:1px solid #CCC;
	
	background-image:url(../../images/content_bottom.jpg);
	background-repeat:repeat-x;	 
	background-position:bottom;
}
ul.tabs li a:hover {
	background-color:#CCC;
	border-color:#CCC;
	color:#666;
}
ul.tabs li a.active {
	background-color:#ffffff;
	color:#282e32;
	border:1px solid #CCC; 
	border-bottom: 1px solid #ffffff;
	background-image:url(../../images/tab_on.jpg);
	background-repeat:repeat-x;
	background-position:top;	
}
.content {
	background-color:#ffffff;
	padding:10px;
	border:1px solid #CCC; 	
	font-family:Arial, Helvetica, sans-serif;
	background-image:url(../../images/content_bottom.jpg);
	background-repeat:repeat-x;	 
	background-position:bottom;	
}
#content_2, #content_3 { display:none; }

.content ul {
	margin:0px;
	padding:0px 20px 0px 20px;
}
.content ul li {
	list-style:none;
	border-bottom:1px solid #FFF;
	padding-top:15px;
	padding-bottom:15px;
	font-size:13px;
}
.content ul li:last-child {
	border-bottom:none;
}
.content ul li a {
	text-decoration:none;
	color:#3e4346;
}
.content ul li a small {
	color:#8b959c;
	font-size:9px;
	text-transform:uppercase;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	position:relative;
	left:4px;
	top:0px;
}
.content ul li a:hover {
	color:#a59c83;
}
.content ul li a:hover small {
	color:#baae8e;
}

</style>
</head>

<body>

<?php
include('../../../Connector.php');

?>
<table width="100%"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder">
                        	<tr><td align="right" colspan="4"><img src="../../../images/closelabel.gif" onclick="CloseWindow();" style="width:40px;" /></td></tr>
                        	<tr class="cursercross" onmousedown="grab(document.getElementById('frmPrevious'),event);">
                            	<td height="35" class="mainHeading" colspan="4">Search Previous Costing</td>
                            </tr>
                            <tr>
                            	<td colspan="4">
                                <div id="tabbed_box_1" class="tabbed_box" align="left">
                                <div class="tabbed_area"> 
                                <ul class="tabs">
                                    <li><a href="javascript:tabSwitch('tab_1', 'content_1');" id="tab_1" class="active">Pre Oder Sample</a></li>
                                    <li><a href="javascript:tabSwitch('tab_2', 'content_2');" id="tab_2">Confrim Sample</a></li>
                                </ul>
                                 
                                    <div style="overflow:scroll;height:170px;" id="content_1"  class="content">
                                	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPreOder">
                                    	<tr bgcolor="#498CC2" class="normaltxtmidb2">
                                        	<td>Serial</td>
                                            <td style="width:100px;">Machine</td>
                                            <td style="width:50px;">Category</td>
                                            <td style="width:50px;">Style</td>
                                            <td style="width:50px;">PO No</td>
                                            <td style="width:100px;">Style Name</td>
                                            <td style="width:50px;">Qty</td>
                                 		</tr>    
                                        <?php 
											$sql_w="SELECT intSerialNo,intMatDetailId,intStyleId,dblQty FROM was_budgetcostheader WHERE intStatus=0;";
											$resQ=$db->RunQuery($sql_w);
											while($row=mysql_fetch_array($resQ))
											{
										?>
                                        <tr  class="bcgcolor-tblrowWhite" id="<?php echo $row['intSerialNo']; ?>" ondblclick="loadDetails(this.id,1)">
                                        	<td class="normalfnt"><?php echo $row['intSerialNo']; ?></td>
                                            <td class="normalfnt"><?php echo $row['intMatDetailId']; ?></td>
                                            <td class="normalfnt"><?php echo $row['intStyleId']; ?></td>
                                            <td class="normalfnt"><?php echo $row['']; ?></td>
                                            <td class="normalfnt"><?php echo $row['']; ?></td>
                                            <td class="normalfnt"><?php echo $row['']; ?></td>
                                            <td class="normalfnt"><?php echo $row['dblQty']; ?></td>
                                        </tr>
                                        <?php }?>                              
                                    </table>  
                                    </div>
                                    <div style="overflow:scroll;height:170px;" id="content_2"  class="content" >
                                    	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblConfirm">
                                    	<tr bgcolor="#498CC2" class="normaltxtmidb2">
                                        	<td>Serial</td>
                                            <td style="width:100px;">Machine</td>
                                            <td style="width:50px;">Category</td>
                                            <td style="width:50px;">Style</td>
                                            <td style="width:50px;">PO No</td>
                                            <td style="width:100px;">Style Name</td>
                                            <td style="width:50px;">Qty</td>
                                 		</tr> 
                                        <?php 
											$sql_w="SELECT intSerialNo,intMatDetailId,intStyleId,dblQty FROM was_budgetcostheader WHERE intStatus=1;";
											$resQ=$db->RunQuery($sql_w);
											while($row=mysql_fetch_array($resQ))
											{
										?>
                                        <tr class="bcgcolor-tblrowWhite" id="<?php echo $row['intSerialNo']; ?>" ondblclick="loadDetails(this.id,1);">
                                        	<td  class="normalfnt"><?php echo $row['intSerialNo']; ?></td>
                                            <td  class="normalfnt"><?php echo $row['intMatDetailId']; ?></td>
                                            <td  class="normalfnt"><?php echo $row['intStyleId']; ?></td>
                                            <td  class="normalfnt"><?php echo $row['']; ?></td>
                                            <td  class="normalfnt"><?php echo $row['']; ?></td>
                                            <td  class="normalfnt"><?php echo $row['']; ?></td>
                                            <td  class="normalfnt"><?php echo $row['dblQty']; ?></td>
                                        </tr>
                                        <?php }?>                                   
                                    </table>
                                    </div>
                                    </div>
                                   </div>
                                </td>
                            </tr>
                            <tr>
                            	<td class="normalfnt">Category</td><td><select class="txtbox"><option>  </option></select></td>
                                <td class="normalfnt">Search</td><td><input type="text" class="txtbox" /></td>
                            </tr>
                         </table>
                    </td>
                </tr>
            </table>
         </td>
     </tr>
</table>
</body>
</html>