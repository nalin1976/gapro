<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sample Requisitions Pop Up</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/tablegrid.js"></script>

<script src="../../javascript/script.js"></script>
<script src="SampleRegisterFunction.js"></script> 

<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script type="text/javascript" src="../../javascript/calendar/calendar.js" ></script>
<script type="text/javascript" src="../../javascript/calendar/calendar-en.js" ></script>
<script type="text/javascript" src="../../javascript/calendar/functions.js" ></script>
<style type="text/css">
.trans_layoutS{
	
	width:450px; height:auto;
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
</style>
</head>
<body>
<div>
	<div align="center">
		<div class="trans_layoutS" id="popup1">
        
		  <div class="trans_text">
          <table width="100%">
          <tr>
          	<td width="15%"></td>
            <td width="90%">Sample Register Pop Up</td>
            <td valign="top" align="right"><img src="../../images/cross.png" alt="close" onclick="closePopUp();"/>
            </td>
          </tr>
          </table>
          </div>
      
        <table width="75%" border="0" class="bcgl1" style="margin-bottom:1px">
				<tr>
				<td align="center">	
       
		  <div style="overflow-x:hidden; overflow-y:scroll; height:150px; width:450px; ">
              <table width="100%" border="0" cellspacing="1" id="opt_table" bgcolor="#CCCCFF">
                <thead>
                  <tr class="mainHeading2">
                    <td colspan="4" class="normaltxtmidb2"><b>Sample Operators Pop UpDetails</b></td>
                  </tr>
                  <tr class="mainHeading2">
                    <td width="7%" class="mainHeading4">Select</td>
                    <td width="75%" class="mainHeading4">Operator Name</td>
                    <td width="15%" class="mainHeading4">Start Date</td>
                    <td width="15%" class="mainHeading4">No of Days</td>
                  </tr>
				  
				  <?php
				  	$id=$_GET['id'];
					$StyleNo=$_GET['StyleNo'];
								$SQL_opt="select intOperatorID,strOperator from operators";
										$result_opt=$db->RunQuery($SQL_opt);
										//$i=1;
										//$glacc="";
										
										while($row=mysql_fetch_array($result_opt))
										{
											$intOptId = $row["intOperatorID"];
											
										 $sql_chk="select * from sampleoperator where intStyleId='$StyleNo' and intOperatorId='$intOptId'"; 
										$req="";
										$startDate="";
										$noDays="";
											$result_chk=$db->RunQuery($sql_chk);
											while($rows=mysql_fetch_array($result_chk))
											{
												
													$req=" checked='checked'";
													$startDate=$rows["dtmStartDate"];
													$noDays=$rows["dblNoofDays"];													
				
													
											}
											//echo $startDate;
				  ?>
	             <tr class="bcgcolor-tblrowWhite">
                    <td style="text-align:center" class="normalfnt" width="7%">&nbsp;<input type="checkbox" name="checkGL2" id="<?php echo $row['intOperatorID'] ; ?>" <?php if($req!=""){ echo "checked='checked'";} ?> /></td>
                    <td style="text-align:center" class="normalfnt" width="75%">&nbsp;<?php echo $row['strOperator'];?></td>
                    <td style="text-align:center" class="normalfnt" width="15%"><input type="text" style="width: 70px;" class="txtbox" name="<?php echo $row['strOperator']; ?>"  id="<?php echo $row['strOperator']; ?>"  value="<?php echo $startDate; ?>" onclick="return showCalendar(this.id, '%Y-%m-%d');" /><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;height:1px !important;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" /></td>
					
                    <td style="text-align:center" class="normalfnt" width="15%"><input type="text" style="width: 80px;" value="<?php echo $noDays; ?>"/></td>
                  </tr>
				  <?php } ?>
				  
				  
                </thead>
			</table>	
		  </div>
          </td>
          </tr>
          </table>
				<br />
			<table align="center" width="293" border="0">
      			<tr>
					<td width="37%">&nbsp;</td>
					<td width="29%"><img src="../../images/save.png" width="80"  onclick="validateOperatorPopUp();"/></td>
					<td width="17%">&nbsp;</td>	
					<td width="17%">&nbsp;</td>
      			</tr>
		  </table>
	  </div>
  </div>
		</div>
	</body>
</html>	