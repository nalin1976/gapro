<?php
	session_start();
	$backwardseperator = "../../";
	include "../../Connector.php";		
	include "{$backwardseperator}authentication.inc";
	$companyId=$_SESSION["FactoryID"];
	$cboSType=$_POST['cboSType'];
	$inOrOut=$_POST['cboPCCat'];
	$cboStatus=$_POST['cboStatus'];
	$txtStype=$_POST['txtStype'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Budgeted Cost Listing</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function SearchPreCosting(){
	document.getElementById('frmBudgetCostList').submit();
}

function washReport(obj,r){
		var sNO=obj.parentNode.parentNode.cells[0].innerHTML;
		var loc=obj.parentNode.parentNode.cells[1].innerHTML;
		
		var po_location=(loc=='In House'?'inhouse':'outside')
		if(r==0)
			window.open("washingFormulaReport.php?q="+sNO+'&po_location='+po_location,'new1' ); 
		else
			window.open("budgetCostSheetReport.php?q="+sNO+'&po_location='+po_location,'new2' );
}
</script>
<style>

#tabbed_box_1 {
	margin: 0px auto 0px auto;
	width:800px;
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

<table width="100%"  border="0" align="center" bgcolor="#FFFFFF">
    <tr>
    	<td>
        	<table  width="100%" border="0">
            	<tr>
                	<td><?php include("{$backwardseperator}Header.php");?></td>
                </tr>
            	<tr>
                	<td>
                    <form id="frmBudgetCostList" method="post">
                    	<table width="60%" border="0" class="tableBorder" align="center">
                        	
                        	<tr >
                            	<td height="35" class="mainHeading" colspan="5">Budgeted  Cost Listing</td>
                            </tr>
                            <tr >
                        	  <td width="2%" >&nbsp;</td>
                        	  <td width="24%" ><b><select id="cboSType" name="cboSType" style="width:200px" >
							  <option value="n" <?php if($cboSType=="n"){echo "selected=\"selected\"";} ?>>Select One To Search</option>
							  <option value="intSerialNo" <?php if($cboSType=="intSerialNo"){echo "selected=\"selected\"";} ?>>Serial No</option>
							  <option value="strStyleName" <?php if($cboSType=="strStyleName"){echo "selected=\"selected\"";} ?>>Style Name</option>
                              <option value="strColor" <?php if($cboSType=="strColor"){echo "selected=\"selected\"";} ?>>Color</option>
							  <option value="strFabricId" <?php if($cboSType=="strFabricId"){echo "selected=\"selected\"";} ?>>Fabric Name</option>
							  
							  </select></b></td>
                        	  <td width="51%" colspan="2" valign="middle"><input type="text" id="txtStype" name="txtStype" style="width:300px" value="<?php echo $txtStype;?>" /></td>
                        	  <td width="19%" valign="middle">&nbsp;</td>
                      	  </tr>
                          <tr >
                        	  <td >&nbsp;</td>
                        	  <td class="normalfnt">&nbsp;<b>Category</b></td>
                        	  <td valign="middle" align="left"><select name="cboPCCat" id="cboPCCat" style="width:110px" >
                                <option value="n" <?php if($inOrOut=="n"){echo "selected=\"selected\"";} ?>>All</option>
                                <option value="0" <?php if($inOrOut=="0"){echo "selected=\"selected\"";} ?>>In House</option>
                                <option value="1" <?php if($inOrOut=="1"){echo "selected=\"selected\"";} ?>>Out Side</option>
                              </select></td>
                        	  <td valign="middle" align="left">&nbsp;</td>
                        	  <td valign="middle">&nbsp;</td>
                      	  </tr>
                          <tr >
                        	  <td >&nbsp;</td>
                        	  <td class="normalfnt">&nbsp;<b>Mode</b></td>
                        	  <td valign="middle" align="left">
                              <select name="cboStatus" id="cboStatus" style="width:110px" >
                                <option value="n" <?php if($cboStatus=="n"){echo "selected=\"selected\"";} ?>>All</option>
                                <option value="0" <?php if($cboStatus=="0"){echo "selected=\"selected\"";} ?>>Pending</option>
                                <option value="1" <?php if($cboStatus=="1"){echo "selected=\"selected\"";} ?>>Confirm</option>
                              </select></td>
                        	  <td valign="middle" align="left"><img src="../../images/view2.png" alt="view" onclick="SearchPreCosting();"/></td>
                        	  <td valign="middle">&nbsp;</td>
                      	  </tr>
                            <tr>
                            	<td colspan="6">
                                <div id="tabbed_box_1" class="tabbed_box" align="left" style="height:500px;overflow:scroll;">
                                  <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#F3E8FF" id="tblPreOder">
                                    <tr bgcolor="#498CC2" class="normaltxtmidb2">
                                      <td width="10%" height="25"  class="grid_header">Serial</td>
                                      <td width="11%" class="grid_header" style="display:none;" >Category</td>
                                      <td width="11%"  class="grid_header" >Style Name</td>
                                      <td width="21%"  class="grid_header">Color</td>
                                      <td width="12%"  class="grid_header">Fabric Name</td>
                                      <td width="9%"  class="grid_header" >Qty</td>
                                      <td width="13%"  class="grid_header" >Fomula</td>
                                      <td width="13%"  class="grid_header" >Cost Sheet</td>
                                    </tr>
                                    <?php 
											//$sql_w="SELECT intSerialNo,intMatDetailId,intStyleId,dblQty FROM was_actualcostheader WHERE intStatus=0;";
										$sql="SELECT WBCH.intSerialNo as serial,
											  WBCH.intMachineId,
											  WBCH.dblQty,
											  WBCH.strStyleName,
											  WM.strMachineName,
											  WBCH.intCat,
											  WBCH.strColor,
											  WBCH.strFabricId 
											  FROM was_budgetcostheader WBCH 
											  left Join was_machine WM ON WM.intMachineId = WBCH.intMachineId ";
												
											        if(!isset($cboStatus) || $cboStatus=="n")
														$sql.=" WHERE WBCH.intStatus in('0','1')";
													if($cboStatus!="n" && isset($cboStatus))
														$sql.=" WHERE WBCH.intStatus='$cboStatus'";
													if(isset($inOrOut) && $inOrOut!="n")
														$sql.=" AND WBCH.intCat like '%$inOrOut%'";
										/*			if(isset($txtStype))
														if(isset($cboSType) && $cboSType!="n" )
															$sql_w.=" AND TBL.$cboSType like '%$txtStype%'";*/
										if($cboSType!='' && $cboSType!="n")
											$sql .= "AND WBCH.$cboSType like '%$txtStype%' ";
																					
											$sql .= "order by WBCH.intSerialNo ASC";
										$res_search=$db->RunQuery($sql);
										//echo $sql;
										
										while($row=mysql_fetch_array($res_search))
										{ 
										$c=0;
											$r="";
											($c%2==0)?$r="grid_raw":$r="grid_raw2";?>
                                    <tr class="bcgcolor-tblrowWhite" id="<?php echo $row['serial']; ?>">
                                      <td class="<?php echo $r;?>" style="text-align:left;" ><?php echo $row['serial']; ?></td>
                                      <td class="<?php echo $r;?>" style="text-align:left;"><?php echo $row['strStyleName']; ?></td>
                                      <td class="<?php echo $r;?>" style="text-align:left;"><?php echo $row['strColor']; ?></td>
                                      <td class="<?php echo $r;?>" style="text-align:left;"><?php echo $row['strFabricId']; ?></td>
                                      <td class="<?php echo $r;?>" style="text-align:right;"><?php echo $row['dblQty']; ?></td>
                                      <td class="<?php echo $r;?>" ><img src="../../images/report.png" onclick="washReport(this,0);" width="100"/></td>
                                      <td class="<?php echo $r;?>" style="text-align:right;"><img src="../../images/report.png" onclick="washReport(this,1);" width="100"/></td>
                                    </tr>
                                    <?php }?>
                                  </table>
                                   </div>
                                </td>
                            </tr>
                            <!--<tr>
                            	<td class="normalfnt">Category</td><td><select class="txtbox"><option>  </option></select></td>
                                <td class="normalfnt">Search</td><td><input type="text" class="txtbox" /></td>
                            </tr>-->
                         </table>
                         </form>
                    </td>
                </tr>
            </table>
         </td>
     </tr>
</table>
</body>
</html>