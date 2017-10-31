<?php
$backwardseperator = "../../";
include('../../Connector.php');
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script language="javascript">

</script>
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
	
	background-image:url(../images/content_bottom.jpg);
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
	background-image:url(../images/tab_on.jpg);
	background-repeat:repeat-x;
	background-position:top;	
}
.content {
	background-color:#ffffff;
	padding:10px;
	border:1px solid #CCC; 	
	font-family:Arial, Helvetica, sans-serif;
	background-image:url(../images/content_bottom.jpg);
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
<table width="500"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="100%" border="0" class="tableBorder" cellpadding="0" cellspacing="0">
                        	
                        	<tr class="cursercross mainHeading" >
                            	<td height="25" colspan="5" >Search Previous Costing</td>
                                <td width="4%" height="25"><img src="../../images/cross.png" alt="cross" width="17" height="17" onclick="CloseWindowInBC();"/></td>
                        	</tr>
                        	<tr >
                        	  <td width="2%" >&nbsp;</td>
                        	  <td width="24%" ><b><select id="cboSType" style="width:110px" >
							  <option value="" >Select One To Search</option>
							  <option value="intSerialNo">Serial No</option>
							  <option value="strStyleName">Style Name</option>
							  <option value="strFabricId">Fabric Name</option>
							  <option value="strColor">Color</option>
							  </select></b></td>
                        	  <td width="51%" colspan="2" valign="middle"><input type="text" id="txtStype" style="width:300px" /></td>
                        	  <td width="19%" valign="middle">&nbsp;</td>
                        	  <td height="25">&nbsp;</td>
                      	  </tr>
                        	<tr >
                        	  <td >&nbsp;</td>
                        	  <td class="normalfnt">&nbsp;<b>Category</b></td>
                        	  <td valign="middle" align="left"><select name="cboPCCat" id="cboPCCat" style="width:110px" >
                                <option value="">All</option>
                                <option value="0">In House</option>
                                <option value="1">Out Side</option>
                              </select></td>
                        	  <td valign="middle" align="left"><img src="../../images/view2.png" alt="view" onclick="SearchPreCosting();"/></td>
                        	  <td valign="middle" colspan="2"><img src="../../images/download.png" width="104" onclick="saveDetToExl();" style="display:none;"/></td>
                      	  </tr>
                            <tr >
                            	<td colspan="6">
                                <div id="tabbed_box_1" class="tabbed_box" align="left">
                                <div class="tabbed_area"> 
                                <ul class="tabs">
                                    <li><a href="javascript:tabSwitch('tab_1', 'content_1');" id="tab_1" class="active" onclick="ChangeCat(0);">Pre Oder Costing</a></li>
                                    <li><a href="javascript:tabSwitch('tab_2', 'content_2');" id="tab_2" onclick="ChangeCat(1);">Confrim Costing</a></li>
                                </ul>
                                 
                                    <div style="width:450px" id="content_1"  class="content">
                                	<table style="width:500px" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPreOder">
									<thead>
                                    	<tr bgcolor="#498CC2" class="normaltxtmidb2" >
                                        	<th class="grid_header" height="25" style="width:50px;">Serial</th>
                                            <th class="grid_header" style="width:50px;display:none;">Category</th>
                                            <th class="grid_header" style="width:100px;">Style Name</th>
											<th class="grid_header" style="width:100px;">Color</th>
											<th class="grid_header" style="width:100px;">Fabric Name</th>
                                            <th class="grid_header" style="width:50px;">Qty</th>
                                 		</tr>
									</thead> 
									<tbody>
                                        <?php 
											$sql_w="SELECT
													WBCH.intSerialNo,
													WBCH.intMachineId,
													WBCH.dblQty,
													WBCH.strStyleName,
													WM.strMachineType,
													WBCH.intCat,
													WBCH.strColor,
													WBCH.strFabricId
													FROM
													was_budgetcostheader WBCH
													Inner Join was_machinetype WM ON WM.intMachineId = WBCH.intMachineId
													WHERE WBCH.intStatus=0 order by date(WBCH.dtmDate) DESC  ;"; //limit 0,50
													
											$resQ=$db->RunQuery($sql_w);
											while($row=mysql_fetch_array($resQ))
											{
												$cat="";
												($row['intCat']==0)?$cat="In House":$cat="Out Side";
												$c="";
												$r="";
												($c%2==0)?$r="grid_raw":$r="grid_raw2";
										?> 
                                        <tr  class="bcgcolor-tblrowWhite mouseover" id="<?php echo $row['intSerialNo']; ?>" ondblclick="loadDetails(this.id,1)">
                                        	<td height="20" style="text-align:left" class="<?php echo $r;?>"><?php echo $row['intSerialNo']; ?></td>
                                            <td style="text-align:left;display:none;" class="<?php echo $r;?>"><?php echo $cat; ?></td>
                                            <td style="text-align:left" class="<?php echo $r;?>"><?php echo $row['strStyleName']; ?></td>
											<td style="text-align:left" class="<?php echo $r;?>"><?php echo $row['strColor']; ?></td>
											<td style="text-align:left" class="<?php echo $r;?>"><?php echo $row['strFabricId']; ?></td>
                                            <td style="text-align:right" class="<?php echo $r;?>"><?php echo $row['dblQty']; ?></td>
                                        </tr>
                                        <?php $c++; }?>
										</tbody>                          
                                    </table>  
                                    </div>
                                    <div style="width:450px" id="content_2"  class="content" >
                                    	<table style="width:500px" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblConfirm">
										<thead>
                                    	<tr bgcolor="#498CC2" class="normaltxtmidb2">
                                        	<th class="grid_header" height="25">Serial</th>
                                            <th style="width:50px;display:none;" class="grid_header">Category</th>
                                            <th style="width:100px;" class="grid_header">Style Name</th>
											<th class="grid_header" style="width:100px;">Color</th>
											<th class="grid_header" style="width:100px;">Fabric Name</th>
                                            <th style="width:50px;" class="grid_header">Qty</th>
                                 		</tr> 
										</thead>
										<tbody>
                                        <?php 
											$sql_w="SELECT WBCH.intSerialNo,
													WBCH.intMachineId,
													WBCH.strStyleName,
													WBCH.dblQty,
													WH.strMachineType,
													WBCH.intCat,
													WBCH.strColor,
													WBCH.strFabricId
													FROM
													was_budgetcostheader WBCH
													Inner Join was_machinetype WH ON WH.intMachineId = WBCH.intMachineId
													WHERE WBCH.intStatus=1 order by date(WBCH.dtmDate) DESC  ;";				//limit 0,50							
											$resQ=$db->RunQuery($sql_w);
											while($row=mysql_fetch_array($resQ))
											{
											$cat="";
												($row['intCat']==0)?$cat="In House":$cat="Out Side";
											$c="";
											$r="";
												($c%2==0)?$r="grid_raw":$r="grid_raw2";
										?>
                                        <tr class="bcgcolor-tblrowWhite mouseover" id="<?php echo $row['intSerialNo']; ?>" ondblclick="loadDetails(this.id,1);">
                                        	<td height="20" style="text-align:lef;width:50px;" class="<?php echo $r;?>"><?php echo $row['intSerialNo']; ?></td>
                                            <td style="text-align:left;display:none;" class="<?php echo $r;?>"><?php echo $cat; ?></td>
                                            <td style="text-align:left" class="<?php echo $r;?>"><?php echo $row['strStyleName']; ?></td>
											<td style="text-align:left" class="<?php echo $r;?>"><?php echo $row['strColor']; ?></td>
											<td style="text-align:left" class="<?php echo $r;?>"><?php echo $row['strFabricId']; ?></td>
                                            <td style="text-align:left" class="<?php echo $r;?>"><?php echo $row['dblQty']; ?></td>
                                        </tr>
                                        <?php }?> 
										</tbody>                                 
                                    </table>
                                    </div>
                                    </div>
                                   </div>                                </td>
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