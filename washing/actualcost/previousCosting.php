<?php
$backwardseperator = "../../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

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

<?php
include('../../Connector.php');

?>
<table width="100%"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td>
                    	<table width="49%" border="0" class="tableBorder">
                        	<tr><td align="right" colspan="5"><img src="../../images/closelabel.gif" onclick="CloseWindow();" style="width:40px;" /></td></tr>
                        	<tr >
                            	<td height="35" class="mainHeading" colspan="5">Search Previous Costing</td>
                            </tr>
                            <tr >
                        	  <td width="2%" >&nbsp;</td>
                        	  <td width="24%" ><b><select id="cboSType" style="width:110px" >
							  <option value="" >Select One To Search</option>
							  <option value="intSerialNo">Serial No</option>
							  <option value="intStyleId">PO No</option>
							 <!-- <option value="strFabricId">Fabric Name</option>-->
							  <option value="strColor">Color</option>
							  </select></b></td>
                        	  <td width="51%" colspan="2" valign="middle"><input type="text" id="txtStype" style="width:300px" /></td>
                        	  <td width="19%" valign="middle">&nbsp;</td>
                      	  </tr>
                        	<tr >
                        	  <td >&nbsp;</td>
                        	  <td class="normalfnt">&nbsp;<b>Category</b></td>
                        	  <td valign="middle" align="left"><select name="cboPCCat" id="cboPCCat" style="width:110px" >
                                <option value="">All</option>
                                <option value="0">In House</option>
                                <option value="1">Out Side</option>
                              </select></td>
                        	  <td valign="middle" align="left"><img src="../../images/view2.png" alt="view" onclick="SearchPreCosting(0);"/></td>
                        	  <td valign="middle">&nbsp;</td>
                      	  </tr>
                            <tr>
                            	<td colspan="6">
                                <div id="tabbed_box_1" class="tabbed_box" align="left">
                                <div class="tabbed_area"> 
                                <ul class="tabs">
                                    <li><a href="javascript:tabSwitch('tab_1', 'content_1');" id="tab_1" class="active"  onclick="ChangeCat(0);">Pre Oder Sample</a></li>
                                    <li><a href="javascript:tabSwitch('tab_2', 'content_2');" id="tab_2" onclick="ChangeCat(1);">Confrim Sample</a></li>
                                </ul>
                                 
                                    <div style="overflow:scroll;height:200px;" id="content_1"  class="content">
                                	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPreOder">
                                    	<tr bgcolor="#498CC2" class="normaltxtmidb2">
                                        	<td height="25" class="grid_header">Serial</td>
                                            <!--<td class="grid_header"  style="width:50px;">Category</td>-->
                                            <td  class="grid_header" style="width:100px;">PO No</td>
                                            <td  class="grid_header" style="width:100px;">Style Name</td>
                                            
                                            <td  class="grid_header" style="width:100px;">Color</td>
                                            <td  class="grid_header" style="width:50px;">Qty</td>
                                 		</tr>    
                                        <?php 
											//$sql_w="SELECT intSerialNo,intMatDetailId,intStyleId,dblQty FROM was_actualcostheader WHERE intStatus=0;";
											$sql_w="SELECT was_actualcostheader.intSerialNo,
													was_actualcostheader.intMachineType, 
													was_actualcostheader.intStyleId, 
													was_actualcostheader.dblQty, 
													was_actualcostheader.strColor,
													orders.strStyle, 
													orders.strOrderNo, 
													was_machinetype.strMachineType, 
													was_actualcostheader.intCat,
													orders.strDescription
													FROM was_actualcostheader 
													left Join orders ON orders.intStyleId = was_actualcostheader.intStyleId 
													Inner Join was_machinetype ON was_machinetype.intMachineId = was_actualcostheader.intMachineType 
													WHERE was_actualcostheader.intStatus=0 and was_actualcostheader.intCat='0' order by was_actualcostheader.intSerialNo ASC;";
													//echo $sql_w;
											$resQ=$db->RunQuery($sql_w);
											while($row=mysql_fetch_array($resQ))
											{
											$c=0;
											$r="";
											($c%2==0)?$r="grid_raw":$r="grid_raw2";
										?>
                                        <tr  class="bcgcolor-tblrowWhite" id="<?php echo $row['intSerialNo']; ?>" ondblclick="loadActCostDetails(this.id,1,0)">
                                        	<td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['intSerialNo']; ?></td>
                                           <!-- <td class="<?php echo $r;?>" style="text-align:left"><?php if($row['intCat']==0){
																			echo "In House";
																		}
																		else{echo "Out Side";} ?></td>--> 
                                            <td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['strOrderNo']; ?></td>
                                            <td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['strDescription']; ?></td>
                                           
                                            <td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['strColor']; ?></td>
                                            <td class="<?php echo $r;?>" style="text-align:right;"><?php echo $row['dblQty']; ?></td>
                                        </tr>
                                        <?php $c++;}     
										
										$sqloutSide="SELECT
													was_actualcostheader.intSerialNo,
													was_actualcostheader.intMachineType,
													was_actualcostheader.intStyleId,
													was_actualcostheader.dblQty,
													was_outsidepo.strStyleDes,
													was_outsidepo.intPONo,
													was_actualcostheader.strColor,
													was_machinetype.strMachineType,
													was_actualcostheader.intCat,
													was_actualcostheader.intStatus
													FROM was_actualcostheader 
													Inner Join was_outsidepo ON was_outsidepo.intId = was_actualcostheader.intStyleId 
													Inner Join was_machinetype ON was_machinetype.intMachineId = was_actualcostheader.intMachineType 
													WHERE was_actualcostheader.intStatus = 0  and was_actualcostheader.intCat='1' order by was_actualcostheader.intSerialNo ASC;";                         
												$resQOS=$db->RunQuery($sqloutSide);
											while($row=mysql_fetch_array($resQOS))
											{
											$c=0;
											$r="";
											($c%2==0)?$r="grid_raw":$r="grid_raw2";
										?>
                                        <tr  class="bcgcolor-tblrowWhite" id="<?php echo $row['intSerialNo']; ?>" ondblclick="loadActCostDetails(this.id,1,1)">
                                        	<td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['intSerialNo']; ?></td>
                                            <!--<td class="<?php echo $r;?>" style="text-align:left"><?php if($row['intCat']==0){
																			echo "In House";
																		}
																		else{echo "Out Side";} ?></td>-->
                                            <td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['intPONo']; ?></td>
                                            <td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['strStyleDes']; ?></td>
                                            
                                            <td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['strColor']; ?></td>
                                            <td class="<?php echo $r;?>" style="text-align:right;"><?php echo $row['dblQty']; ?></td>
                                        </tr>
                                        <?php $c++;}  ?>
                                    </table>  
                                    </div>
                                    <div style="overflow:scroll;height:200px;" id="content_2"  class="content" >
                                    	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblConfirm">
                                    	<tr bgcolor="#498CC2" class="normaltxtmidb2">
                                        	<td height="25" class="grid_header">Serial</td>
                                            <!--<td class="grid_header"  style="width:50px;">Category</td>-->
                                            <td  class="grid_header" style="width:100px;">PO No</td>
                                            <td  class="grid_header" style="width:100px;">Style Name</td>
                                            
                                            <td  class="grid_header" style="width:100px;">Color</td>
                                            <td  class="grid_header" style="width:50px;">Qty</td>
                                 		</tr> 
                                        <?php 
											$sql_w="SELECT was_actualcostheader.intSerialNo,
													was_actualcostheader.intMachineType, 
													was_actualcostheader.intStyleId, 
													was_actualcostheader.dblQty, 
													was_actualcostheader.strColor,
													orders.strStyle, 
													orders.strOrderNo, 
													was_machinetype.strMachineType, 
													was_actualcostheader.intCat,
													orders.strDescription 
													FROM was_actualcostheader 
													Inner Join orders ON orders.intStyleId = was_actualcostheader.intStyleId 
													Inner Join was_machinetype ON was_machinetype.intMachineId = was_actualcostheader.intMachineType 
													WHERE was_actualcostheader.intStatus=1 and was_actualcostheader.intCat='0' order by was_actualcostheader.intSerialNo ASC;";
													//echo $sql_w;
											$resQ=$db->RunQuery($sql_w);
											while($row=mysql_fetch_array($resQ))
											{
											$c=0;
											$r="";
											($c%2==0)?$r="grid_raw":$r="grid_raw2";
										?>
                                        <tr class="bcgcolor-tblrowWhite" id="<?php echo $row['intSerialNo']; ?>" ondblclick="loadActCostDetails(this.id,1,0);">
                                        	<td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['intSerialNo']; ?></td>
                                            <!--<td class="<?php echo $r;?>" style="text-align:left"><?php if($row['intCat']==0){
																			echo "In House";
																		}
																		else{echo "Out Side";} ?></td>-->
                                             <td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['strOrderNo']; ?></td>
                                            <td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['strDescription']; ?></td>
                                            
                                            <td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['strColor']; ?></td>
                                            <td class="<?php echo $r;?>" style="text-align:right;"><?php echo $row['dblQty']; ?></td>
                                        </tr>
                                        <?php $c++;}$sqloutSide="SELECT
													was_actualcostheader.intSerialNo,
													was_actualcostheader.intMachineType,
													was_actualcostheader.intStyleId,
													was_actualcostheader.dblQty,
													was_outsidepo.strStyleDes,
													was_outsidepo.intPONo,
													was_actualcostheader.strColor,
													was_machinetype.strMachineType,
													was_actualcostheader.intCat,
													was_actualcostheader.intStatus
													FROM was_actualcostheader 
													Inner Join was_outsidepo ON was_outsidepo.intId = was_actualcostheader.intStyleId 
													Inner Join was_machinetype ON was_machinetype.intMachineId = was_actualcostheader.intMachineType 
													WHERE was_actualcostheader.intStatus = 1 and was_actualcostheader.intCat='1' order by was_actualcostheader.intSerialNo ASC;";                         //echo $sqloutSide;
												$resQOS=$db->RunQuery($sqloutSide);
											while($row=mysql_fetch_array($resQOS))
											{
											$c=0;
											$r="";
											($c%2==0)?$r="grid_raw":$r="grid_raw2";
										?>
                                        <tr  class="bcgcolor-tblrowWhite" id="<?php echo $row['intSerialNo']; ?>" ondblclick="loadActCostDetails(this.id,1,1)">
                                        	<td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['intSerialNo']; ?></td>
                                          <!-- <td class="<?php echo $r;?>" style="text-align:left"><?php if($row['intCat']==0){
																			echo "In House";
																		}
																		else{echo "Out Side";} ?></td>-->
                                                                        
                                            <td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['intPONo']; ?></td>
                                            <td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['strStyleDes']; ?></td>
                                            
                                            <td class="<?php echo $r;?>" style="text-align:left"><?php echo $row['strColor']; ?></td>
                                            <td class="<?php echo $r;?>" style="text-align:right;"><?php echo $row['dblQty']; ?></td>
                                        </tr>
                                        <?php $c++;}  ?>                                   
                                    </table>
                                    </div>
                                    </div>
                                   </div>
                                </td>
                            </tr>
                            <!--<tr>
                            	<td class="normalfnt">Category</td><td><select class="txtbox"><option>  </option></select></td>
                                <td class="normalfnt">Search</td><td><input type="text" class="txtbox" /></td>
                            </tr>-->
                         </table>
                    </td>
                </tr>
            </table>
         </td>
     </tr>
</table>
</body>
</html>