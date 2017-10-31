<?php
session_start();
$backwardseperator = "../../";
$user=$_SESSION["UserID"];
$factory=$_SESSION['FactoryID'];
include("${backwardseperator}authentication.inc");
include("${backwardseperator}Connector.php");

$sql = "select intDepartmentId,strDepartmentName from was_department where intStatus=1 order by intDepartmentId";
$result=$db->RunQuery($sql);
$rowCount = mysql_num_rows($result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Root Card</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<style>
/* TimeEntry styles */
.timeEntry_control {
	vertical-align: middle;
	margin-left: 3px;
}
* html .timeEntry_control { /* IE only */
	margin-top: -4px;
}

</style>

<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="rootCard.js" type="text/javascript"></script>

<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>

<script>
function viewReport(rootcrdId)
{
		var url ="rootCardRpt.php?rootCardNo="+rootcrdId;
		$("#NoSearch").hide(500);
		document.getElementById('cboRptRootcrdNo').value="";
		window.open(url,"rootCardRpt");
}
function showRptPopup()
{
	$("#NoSearch").show(500);
}
function closeFindPO()
{
	$("#NoSearch").hide(500);
}

$(function () 
{
	var NoOfDep = <?php echo $rowCount; ?>;
	for(var x=0;x<NoOfDep;x++)
	{
		$('#txtTimeIn'+x).timeEntry({spinnerImage: 'spinnerDefault.png'});
		$('#txtTimeOut'+x).timeEntry({spinnerImage: 'spinnerDefault.png'});
	}
});
</script>
</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td><?php include($backwardseperator.'Header.php'); ?></td>
	</tr>
</table>
<script type="text/javascript" src="../javascript/jquery.timeentry.js"></script>
<script type="text/javascript" src="../javascript/jquery.mousewheel.js"></script>
<form name="frmRootCard" id="frmRootCard" method="post" action="">
	<table width="900" align="center">
    <tr>
    <td>
	<table border="0" align="center" class="main_border_line" width="100%">
        <tr>
			<td class="mainHeading" colspan="4">Root Card</td>
 		</tr>
         <tr>
			<td class="normalfntSubHeader" colspan="4" style="text-align:center;">ORIT APPARELS LANKA(PVT) LIMITED</td>
 		</tr>
        <tr>
			<td class="normalfntMid" colspan="4">WASHING PLANT - <?php echo getCompanyName($factory);?></td>
 		</tr>
        <tr>
			<td class="normalfnth1B" colspan="4" style="text-align:center;">PROCESS CONTROL SHEET</td>
 		</tr>
        <tr>
			<td class="normalfnt" width="15%">&nbsp;</td>
            <td class="normalfnt" width="37%">&nbsp;</td>
            <td class="normalfnt" width="13%">&nbsp;</td>
            <td class="" width="35%">&nbsp;</td>
 		</tr>
        <tr>
			<td class="normalfnt" width="15%">Plan ID</td>
            <td class="normalfnt" width="37%"><select name="cboPlanId" id="cboPlanId" style="width:250px;" class="txtbox" onchange="getPlanDetails(this);">
              <option value="">Select Plan</option>
              <?php
                $sql="SELECT DISTINCT concat(was_planheader.intPlanYear,'/',was_planheader.intPlanNo) AS PlanNo from  was_planheader order by PlanNo ASC;";
				$res=$db->RunQuery($sql);
				while($row=mysql_fetch_array($res)){
					echo "<option value=\"".$row['PlanNo']."\">".$row['PlanNo']."</option>";
				}
				?>
            </select></td>
            <td class="normalfnt" width="13%">Date</td>
            <td class="" width="35%"><input type="text" readonly="readonly" id="txtDate" name="txtDate" value="<?php echo date('Y'.'-'.'m'.'-'.'d');?>" style="width:100px;" class="txtbox"/></td>
 		</tr>
        <tr>
			<td class="normalfnt" width="15%">Batch #</td>
            <td class="normalfnt" width="37%"><select id="cboBatchNo" name="cboBatchNo" style="width:250px;" class="txtbox" onchange="getCostDetails(this)">
              <option value="">Select Batch</option>
              <?php 
					$sql="";
					?>
            </select></td><td class="normalfnt" width="13%">P.O.#</td>
            <td class="" width="35%"><span class="normalfnt">
              <select name="cboRootCardPONO" id="cboRootCardPONO" style="width:250px;" class="txtbox">
                <option value="">Select PO</option>
              </select>
            </span></td>
 		</tr>
        <tr>
			<td class="normalfnt">Style Name</td>
            <td class="normalfnt"><input type="text" readonly="readonly" value="" style="width:248px;" class="txtbox" name="txtRootCardStyleName" id="txtRootCardStyleName"/></td>
            <td class="normalfnt">Root Card #</td>
            <td class="normalfnt"><input type="text" readonly="readonly" value="" style="width:248px;text-align:right;" class="txtbox" name="txtRootCardNo" id="txtRootCardNo" /></td>
 		</tr>
        <tr>
			<td class="normalfnt">COLOUR</td>
            <td class="normalfnt"><input type="text" readonly="readonly" value="" style="width:248px;" class="txtbox" name="txtRootCardColor" id="txtRootCardColor"/></td>
            <td class="normalfnt">WEIGHT OF LOAD</td>
            <td class="normalfnt"><input type="text" readonly="readonly" value="" style="width:248px;text-align:right;" class="txtbox" name="txtRootCardWOL" id="txtRootCardWOL"/></td>
 		</tr>
        <tr>
			<td class="normalfnt">NUMBER OF PCS</td>
            <td class="normalfnt"><input type="text" value="" style="width:100px;text-align:right;" class="txtbox" name="txtRootCardPCs" id="txtRootCardPCs" /></td>
            <td class="normalfnt">SHADE</td>
            <td class="normalfnt"><input type="text" maxlength="25" value="" style="width:248px;text-align:right;" class="txtbox" id="txtShade" name="txtShade"/></td>
 		</tr>
        <tr>
			<td class="" colspan="4">
            
            	<table width="100%" class="main_border_line" rules="all" id="tblDepartment">
                	<thead>
                		<tr>
                        	<td rowspan="2" class="normalfntMid" >Department</td>
                            <td width="9%" rowspan="2" class="normalfntMid" >No. Of PCs</td>
                            <td rowspan="2" class="normalfntMid" >Machine Operator's Name</td>
                            <td width="10%" rowspan="2" class="normalfntMid" >EPF No</td>
                            <td colspan="2" class="normalfntMid">
								TIME
                            </td>
                            <td rowspan="2" class="normalfntMid" >REMARKS</td>
                        </tr>
                        <tr>
 
                                <td class="normalfntMid" width="12%">IN</td>
                                <td class="normalfntMid" width="12%">OUT</td>

                        </tr>	
                    </thead>
                    <tbody>
                    <?php 
					$i = 0;
					$sql = "select intDepartmentId,strDepartmentName from was_department where intStatus=1 order by intDepartmentId";
					$result=$db->RunQuery($sql);
					while($row=mysql_fetch_array($result))
					{
					?>
                    <tr>
                    	<td class="normalfnt" width="17%" id="<?php echo $row["intDepartmentId"];?>"><?php echo $row["strDepartmentName"];?></td>
                        <td class="normalfntMid" width="9%"><input type="text" id="txtNoOfPcs" name="txtNoOfPcs" style="width:75px;" class="txtbox" value="" onkeypress="return CheckforValidDecimal(this.value, 2,event);" maxlength="10" /></td>
                        <td class="normalfntMid" width="20%"><input type="text" id="txtCounter" name="txtCounter" style="width:170px;" class="txtbox" value="" maxlength="50"/></td>
                        <td class="normalfntMid" width="10%"><input type="text" id="txtEPFNo" name="txtEPFNo" style="width:80px;" class="txtbox" value="" maxlength="10"/></td>
                        <td class="normalfnt" width="12%"><input type="text" id='txtTimeIn<?php echo $i;?>' name="txtTimeIn" style="width:75px;" class="txtbox" value=""/></td>
                        <td class="normalfnt" width="12%"><input type="text" id='txtTimeOut<?php echo $i;?>' name="txtTimeOut" style="width:75px;" class="txtbox" value=""/></td>
                        <td class="normalfnt" width="20%"><input type="text" id="txtRemarks" name="txtRemarks" style="width:170px;" class="txtbox" value="" maxlength="100"/></td>
                    </tr>
                    <?php 
					$i++;
					} 
					?>
                    </tbody>
                </table>
                
            </td>
 		</tr>
        <tr>
			<td class="normalfnt" width="15%">MATCH BY (LEADER'S NAME)</td>
            <td colspan="3">:......................................................................................................................................................................</td>
 		</tr>
        <tr>
			<td class="normalfnt" width="15%">MESUREMENT</td>
            <td  colspan="3">:......................................................................................................................................................................</td>
 		</tr>
        <tr>
			<td class="normalfnt" width="15%">COMMENTS</td>
            <td  colspan="3">:...................................................................................................................................................................... </td>
 		</tr>
        <tr>
			<td class="normalfnt" width="15%">Q.C. COMMENTS</td>
            <td  colspan="3">:......................................................................................................................................................................            </td>
 		</tr>
	</table>
    </td>
    </tr>
    
    <tr>
    <td>
    <table border="0" align="center" class="main_border_line" width="100%" cellpadding="2" cellspacing="2">
    	<tr>
			<td colspan="2" class="normalfnt">Chemical Requirenment</td>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="17%">&nbsp;</td>
              <td width="83%"><div style="position:absolute; width: 295px;height: 50px;display:none" id="NoSearch" >
  <table width="297" border="0" cellpadding="2" cellspacing="0" class="tablezRED">
    <tr>
      <td  colspan="3" class="mainHeading" valign="middle"><img src="../../images/cross.png" alt="rep" align="right" onclick="closeFindPO();" /></td>
    </tr>
    <tr>
      <td width="2" height="22" class="normalfnt"></td>
      <td width="86" height="22" class="normalfnt">Root Card No</td>
      <td width="193"><select name="cboRptRootcrdNo" class="txtbox" id="cboRptRootcrdNo" style="width:170px" onchange="viewReport(this.value);">
        <option value="">Select One</option>
        <?php
		$sql = "select concat(dblRootCartNo,'/',intRYear) as rootCrdNo from was_rootcard order by intRYear,dblRootCartNo"; 
		$res=$db->RunQuery($sql);
		while($row=mysql_fetch_array($res))
		{
			echo "<option value=\"".$row['rootCrdNo']."\">".$row['rootCrdNo']."</option>";
		}
		?>
      </select></td>
      </tr>
  </table>
</div></td>
            </tr>
          </table></td>
			<td class="normalfnt">&nbsp;</td>
			<td class="normalfnt">&nbsp;</td>
          </tr>
        <tr>
			<td class=""><span class="normalfnt">Machine No.</span></td>
            <td class=""><select  name="cboCINM" id="cboCINM" class="txtbox" style="width:202px;" >
              <option>Select Machine</option>
            </select></td>
            <td class="normalfnt">PO #</td>
            <td class=""><input type="text"  class="txtbox" style="width:200px;" name="txtCINPO" id="txtCINPO"/></td>
            <td class="normalfnt">Style</td>
            <td class=""><input type="text" name="txtCINStyle" id="txtCINStyle" class="txtbox" style="width:200px;"/></td>
 		</tr>
        <tr>
			<td class="normalfnt" width="13%">Date</td>
            <td class="normalfnt" width="25%"><input type="text" name="" id="" value="<?php echo date('Y'.'-'.'m'.'-'.'d');?>" class="txtbox" style="width:100px;"/></td>
            <td class="normalfnt" width="7%">Color</td>
            <td class="normalfnt" width="25%"><input type="text" name="txtCINColor" id="txtCINColor" class="txtbox" style="width:200px;"/></td>
            <td class="normalfnt" width="6%">Sheet #</td>
            <td class="normalfnt" width="24%"><input type="text" name="" id="" class="txtbox" style="width:200px;"/></td>
 		</tr>
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt"></td>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="6" class="normalfnt">
          <div id="divchemTable" style="display:inline">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" id="tblChemical">
            <tr bgcolor="#E6E6E6">
              <td height="20" width="3%" class="border-top-left-fntsize10" style="text-align:center">&nbsp;<b></b>&nbsp;</td>
              <td width="24%" class="border-top-left-fntsize10" style="text-align:center">&nbsp;<b>PROCESS</b>&nbsp;</td>
              <td width="47%" class="border-top-left-fntsize10" style="text-align:center">&nbsp;<b>CHEMICAL</b>&nbsp;</td>
              <td width="13%" class="border-top-left-fntsize10" style="text-align:center">&nbsp;<b>QTY</b>&nbsp;</td>
              <td width="13%" class="border-Left-Top-right-fntsize10" style="text-align:center">&nbsp;<b>UNIT</b>&nbsp;</td>
            </tr>
          </table>
          </div>
          </td>
          </tr>
        </table>
        
    </td>
    </tr>
    <tr>
    <td>
    <table width="100%" align="center" class="tableBorder">
    <tr>
    	<td align="center"><img src="../../images/new.png" /><img src="../../images/save.png" onclick="saveRootCard()" /><img src="../../images/report.png" id="btnReport" onclick="showRptPopup()" /><a href="../../main.php"><img src="../../images/close.png" border="0" /></a></td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
</form>

<?php 
function getCompanyName($fac){
	global $db;
	$sql="SELECT companies.strCity FROM companies where companies.intCompanyID='$fac';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['strCity'];
}

function getPos(){
	global $db;
	$sql="SELECT DISTINCT orders.strOrderNo,orders.intStyleId FROM was_actualcostheader INNER JOIN orders ON was_actualcostheader.intStyleId = orders.intStyleId
WHERE was_actualcostheader.intStatus = 1;";
	return $db->RunQuery($sql);
}

function getDepartments()
{
	
}
?>
</body>
</html> 