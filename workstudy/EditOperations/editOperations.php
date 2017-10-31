<?php

//**************suMitH HarShan 2011-04-29*************


$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Operations</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/jquery.js"></script>
<script type="text/javascript" src="../../javascript/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script src="editOperations.js"></script>
<script src="../../javascript/script.js"></script>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script type="text/javascript" src="../../calendar_functions.js" ></script>
<script type="text/javascript" src="../../javascript/calendar/calendar.js" ></script>
<script type="text/javascript" src="../../javascript/calendar/calendar-en.js" ></script>
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<link href="../../css/JqueryTabs.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/tablegrid.js"></script>
<style type="text/css">
.trans_layoutS{
	width:500px; height:auto;
	border:1px solid;
	border-bottom-color:#550000;
	border-top-color:#550000;
	border-left-color:#550000;
	border-right-color:#550000;
	background-color:#FFFFFF;
	padding-right:15px;
	padding-top:10px;
	padding-left:30px;
	padding-right:30px;
	margin-top:20px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	-moz-border-radius-topright:10px;
	-moz-border-radius-topleft:10px;
	border-bottom:13px solid #550000;
	border-top:30px solid #550000;
}

.trans_text2 {
	position:relative;
	top : -35px; left:-1px; width:100%; height:24px;
	text-align:center;
	font-size: 12px;
	font-family: Verdana;
	padding-top:4px;
	width:100%;
	color:#ffffff;
	text-align:center;
	font-weight:normal;
}
</style></head>

<body>
<?php
include "../../Connector.php";

?>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">Edit Operations<span id="banks_popup_close_button"></span></div>
	</div>
	<div class="">
<form id="frmeditoperation" name="frmeditoperation" method="post" action="">
  <table width="500" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td>
       <table width="66%" align="center" class="bcgl1">
          <tr>
           <td class="normalfnt" ><table width="101%" align="center" class="bcgl1">
		    <tr>
               <td width="35%" height="25" style="padding-left:40px; padding-right:10px;"><dd>Process
                 </td>
				   <td height="25" colspan="2" ><select name="cmbProcessId" class="txtbox" id="cmbProcessId" style="width:203px" onchange="">
                      <option value=""></option>
                      <?php 
			$str="select intProcessId,strProcess from ws_processes order by intProcessId ASC";
		
			$results=$db->RunQuery($str);
			
			while($row=mysql_fetch_array($results))
			{
		?>
                      <option value="<?php echo $row['intProcessId'];?>"><?php echo $row['strProcess'];?></option>
                      <?php } ?>
                      </select></td>
             </tr>
			 
             <tr>
               <td class="normalfnt" width="226" style="padding-left:80px; padding-right:10px;">Component Catagory</td>
               <td width="378"><select name="cboComponentCatagory" class="txtbox"  id="cboComponentCatagory" style="width:203px;" onchange="loadComponentsCatWise(this.value),loadComponentWiseDetails();">
                 <option value="0"></option>
                 <?php 
	$SQL="SELECT
				componentcategory.intCategoryNo,
				componentcategory.strCategory
				FROM
				componentcategory
				WHERE componentcategory.`intStatus` =1
				ORDER BY componentcategory.strDescription";		
	$result = $db->RunQuery($SQL);	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCategoryNo"] ."\">" . $row["strCategory"] ."</option>" ;
	}		  
	?>
                 </select></td>
             </tr>
            <tr>
              <td class="normalfnt" width="226" style="padding-left:80px">Component</td>
              <td width="378"><select class="txtbox" style="width:203px;" name="cboComponent" id="cboComponent" onchange="loadOperations()">
                  <option value=""></option>
                </select></td>
            </tr>
            <tr>
              <td class="normalfnt" width="226" style="padding-left:80px">Operation  Code</td>
              <td><input style="width: 200px;" class="txtbox" type="text" id="txtOperationCode" name="txtOperationCode" maxlength="100" /></td>
            </tr>
            <tr>
              <td class="normalfnt" width="226" style="padding-left:80px">Operation</td>
              <td><input style="width: 200px;" class="txtbox" type="text" id="txtOperation" name="txtOperation" maxlength="100" /></td>
            </tr>
            <tr>
              <td class="normalfnt" width="226" style="padding-left:80px">Active</td>
              <td><input name="checkbox" type="checkbox" class="chkbox"  id="chkActive" checked="checked" /></td>
            </tr>
            <tr>
              <td align="center" colspan="2">
                <!--buttons table-->
                <table width="100%">
                  <tr>
                    <td width="26%">&nbsp;</td>
                    <td width="51%"><img src="../../images/new.png" onclick="clearForm();" alt="New" name="New" class="mouseover" /><img src="../../images/save.png"  alt="Save" name="Save" onclick="saveOperation();" class="mouseover" /><a href="../../main.php"><img src="../../images/close.png" id="Close" border="0" /></a></td>
                    <td width="23%">&nbsp;</td>
                    </tr>
                  </table> <!--End of the button table-->
                <br/>
                
                
                
                <div id="operationgrid" style="overflow:scroll; height:200px; width:620px;" class="transGrid">
                  <table style="width:600px" id="tbloperation" class="thetable" border="0" cellspacing="1">
                    <caption>
                      Operations Details
                      </caption>
                    <thead>
                      <tr>
                        <th width="26">Edit</th>
                        <th width="34">Del</th>
                        <th width="121">Component Cat.</th>
                        <th width="108">Component</th>
                        <th width="122">Operation Code</th>
                        <th width="122">Operation</th>
                        <th width="43">Active</th>
                        </tr>
                      </thead>
                    <tbody>
                      </tbody>
                    </table>  <!-- End of the grid table-->
                  </div>
                </td>
              
            </table><!--End of the 2nd  table-->
          </td>
          </tr>
        
      </table>  <!--End of the grid table-->
      </td>
      </tr>
    
  </table><!--End of the main table-->
</form>
</div>
</div>
</div>
</body>
</html>
