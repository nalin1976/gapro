<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operation Break Down Report</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js"></script>
<script src="button.js"></script>
<script src="../../javascript/styleNoOrderNoLoading.js" type="text/javascript" ></script>

</head>

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
		<div class="main_text">Operation Break Down Report<span id="banks_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<table class="" align="center" width="600" border="0" cellspacing="1">
      <tr>
        <td width="48%"><form id="frmCountries" name="frmCountries" method="post" action="opbdRpt2.php">
          <table width="700" border="0"  cellspacing="0">
            <tr>
              <td height="4" colspan="5">&nbsp;</td>
            </tr>
            <tr>
              <td width="3" ></td>
              <td width="37" class="normalfnt"><b>Style</b></td>
              <td width="160" align="left"><select name="cboStyles" class="txtbox" id="cboStyles" style="width:150px" tabindex="1" 
	onchange="getStylewiseOrderNoNew('OPBDReportGetStylewiseOrderNo',this.value,'opbdrpt_intStyleID');getScNo('OPBDReportgetStyleWiseSCNum','cboScNo');">
                <?php
	
	$SQL = "SELECT
			orders.intStyleId,
			orders.strStyle
			FROM
			ws_operationbreakdownheader
			Inner Join orders ON ws_operationbreakdownheader.strStyleID = orders.intStyleId order by strStyle ASC";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
              </select></td>
			  
			  <td width="76" class="normalfnt"><b>Order No</b></td>
              <td width="159" align="left"><select name="opbdrpt_intStyleID" class="txtbox" id="opbdrpt_intStyleID" style="width:150px" tabindex="1" 
			  onchange="getSC('cboScNo','opbdrpt_intStyleID');">
                <?php
	
	$SQL = "SELECT
			orders.intStyleId,
			orders.strStyle
			FROM
			ws_operationbreakdownheader
			Inner Join orders ON ws_operationbreakdownheader.strStyleID = orders.intStyleId order by strStyle ASC";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
              </select></td>
			  
              <td width="50" class="normalfnt"><b>SC NO</b></td>
              <td width="87" align="left"><select name="cboScNo" class="txtbox" id="cboScNo" style="width:75px" tabindex="1" 
			  onchange="getStyleNoFromSC('cboScNo','opbdrpt_intStyleID');">
                <?php
	
	$SQL = "SELECT
				orders.intStyleId,
				specification.intSRNO
				FROM
				ws_operationbreakdownheader
				Inner Join orders ON ws_operationbreakdownheader.strStyleID = orders.intStyleId
				Inner Join specification ON orders.intStyleId = specification.intStyleId order by intSRNO ASC";
	
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
              </select></td>
	<td width="112"><img id="butReport" src="../../images/report.png" alt="Report" border="0" class="mouseover" onclick="loadReport();" tabindex="9"/></td>
            </tr>

            <tr>
              <td height="21" colspan="5" bgcolor=""><table width="102%" border="0" class="">
              </table></td>
            </tr>
          </table>
        </form>        </td>
      </tr>
    </table></td>
  </tr>
</table>

</div>
</div>



</body>
</html>
