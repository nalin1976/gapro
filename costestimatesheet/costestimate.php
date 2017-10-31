<?php
	session_start();
	include "../Connector.php";	
	$companyId = $_SESSION["FactoryID"];
	
	$backwardseperator = "../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Post Order Costing Report</title>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style>
<link href="../Units/css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js"></script>
<script type="text/javascript" src="ageanalysisreport.js"></script>
<script type="text/javascript" src="costestimate.js"></script>
</head>

<body>
<form id="frmbanks" name="form1" method="post" action="">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
<table width="750" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
        <td ><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="25" class="mainHeading">Post Order Costing</td>
          </tr>
          <tr>
            <td height="50"><table width="100%" border="0" class="tableBorder">
			<tr>
	  	      <td colspan="6"><table width="100%" border="0"  class="tableBorder">

            <tr>
              <td width="15%" height="25" class="normalfnt" ><input type="radio" id="rbAllStyle" name="radio" checked="checked" onchange="LoadCompleteStyle('','')"/>&nbsp;All Orders</td>
              <td width="20%"   class="normalfnt"><input type="radio" id="rbCompleteStyle" name="radio" onchange="LoadCompleteStyle(13,13)"/>&nbsp;Completed Orders</td>
              <td width="20%" class="normalfnt" ><input type="radio" id="rbPendingStyle" name="radio" value="0" onchange="LoadCompleteStyle(0,10)"/>
              &nbsp;Pending Orders </td>
			</tr> 
			</table></td> 
              <tr>
                <td width="106" class="normalfnt" height="24">Style No</td>
               <td width="216"><select name="cboStyleID" class="txtbox" id="cboStyleID" style="width:200px" onchange="LoadOrderNo(this.value);">
                       <option value="" selected="selected">Select One</option>
                  <?php
	$sql="select distinct strStyle from orders O Order By O.strStyle;";
	$result=$db->RunQuery($sql);
			
		while($row=mysql_fetch_array($result)){
			echo "<option value=\"".trim($row["strStyle"],' ')."\">".$row["strStyle"]."</option>";
		}
?>
                </select></td>
                <td width="54" class="normalfnt">SC No </td>
             <td width="122"><select name="cboScNo" class="txtbox" id="cboScNo" style="width:100px"  onchange="SetOrderNo(this)">
                       <option value="" selected="selected">Select One</option>
<?php
		$sql="select SP.intStyleId,SP.intSRNO
				from specification SP
				INNER JOIN orders O ON O.intStyleId=SP.intStyleId
				order by SP.intSRNO ;";
				
		$result=$db->RunQuery($sql);		
		while($row=mysql_fetch_array($result)){
		echo "<option value=\"".trim($row["intStyleId"],' ')."\">".$row["intSRNO"]."</option>";
		}
?>  
                </select></td>
                <td width="72" class="normalfnt">Order No </td>
               <td width="138"><select name="cboOrderNo" id="cboOrderNo" style="width:100px;" onchange="SetSCNo(this);">
                       <option value="" selected="selected">Select One</option>
                        <?php
	
	$SQL = "select distinct SP.intStyleId,O.strOrderNo
			from specification SP
			INNER JOIN orders O ON O.intStyleId=SP.intStyleId
			order by O.strOrderNo ;";
	$result = $db->RunQuery($SQL);

	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                      </select></td>
              </tr>
              <tr>
              	<td class="normalfnt">Buyer</td>
                <td><select name="cboBuyer" id="cboBuyer" style="width:200px;">
                 <?php 	
	$SQL="select B.intBuyerID,B.strName from buyers B where B.intStatus=1 order by B.strName";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intBuyerID"]."\">".$row["strName"]."</option>";
	}
?>
                </select>                </td>
                <td colspan="2" class="normalfnt"></td>
                <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                <td class="normalfnt">Report Category</td>
                 <td><select name="cboReportCategory" id="cboReportCategory" style="width:200px;">
                <option value="0">Postorder - Detail Report</option>
				<option value="1">Postorder - Summary Report</option>
                </select></td>
                  <td>&nbsp;</td>
                   <td>&nbsp;</td>
                </tr>
            </table>            </td>
          </tr>
          <tr>
            <td ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
              <tr>
                <td width="100%" ><table width="100%" border="0">
                    <tr>
                      <td align="center">
					  <img src="../images/new.png" alt="New" name="New" id="butNew" onclick="ClearForm();">
					  <img src="../images/report.png" alt="Report" name="Report" id="butReport" onclick="ViewReport();"/>
					   <img src="../images/download.png" alt="Report" name="Report" id="butReport" onclick="ViewExReport();"/>
					  <a href="../main.php"><img src="../images/close.png" alt="Close" name="Close" border="0" id="Close"/></a></td>
                      </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<script language="javascript">

function RomoveData(data){
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 0) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}
function LoadOrderNo(style)
{
	if(document.getElementById("rbAllStyle").checked)
	{
		var status1 = "";
		var status2 = "";
	}
	if(document.getElementById("rbCompleteStyle").checked)
	{
		var status1 = 13;
		var status2 = 13;
	}
	if(document.getElementById("rbPendingStyle").checked)
	{
		var status1 = 0;
		var status2 = 10;
	}
	var url = 'costestimatexml.php?RequestType=getStyleWiseOrderNo&style='+URLEncode(style)+'&status1='+status1+'&status2='+status2;
	htmlobj = $.ajax({url:url,async:false});
	var XMLItem = htmlobj.responseText;
	document.getElementById('cboOrderNo').innerHTML = XMLItem;
	LoadSCNo(style,status1,status2);
}
function LoadSCNo(style,status1,status2)
{
	var url = 'costestimatexml.php?RequestType=getStyleWiseSCNo&style='+URLEncode(style)+'&status1='+status1+'&status2='+status2;
	htmlobj = $.ajax({url:url,async:false});
	var XMLScNo = htmlobj.responseText;
	document.getElementById('cboScNo').innerHTML = XMLScNo;
	
}
function SetOrderNo(obj)
{
	$('#cboOrderNo').val(obj.value);
}

function SetSCNo(obj)
{
	$('#cboScNo').val(obj.value);
}

//-------------------------------
function LoadCompleteStyle(status1,status2)
{
	RomoveData('cboStyleID');
	RomoveData('cboScNo');
	RomoveData('cboOrderNo');
	var url ='costestimatexml.php?RequestType=LoadAllStyle&status1=' +status1+'&status2='+status2;
	htmlobj = $.ajax({url:url,async:false});
	var XMLStyle = htmlobj.responseText;
	document.getElementById('cboStyleID').innerHTML = XMLStyle;
	LoadSCNo("",status1,status2);
	laodStatusWiseOrder("",status1,status2);
}
function laodStatusWiseOrder(style,status1,status2)
{
	var url = 'costestimatexml.php?RequestType=getStyleWiseOrderNo&style='+URLEncode(style)+'&status1='+status1+'&status2='+status2;
	htmlobj = $.ajax({url:url,async:false});
	var XMLItem = htmlobj.responseText;
	document.getElementById('cboOrderNo').innerHTML = XMLItem;
}
function ViewReport()
{
	var StyleID =document.getElementById('cboOrderNo').value;
	var reportId = document.getElementById('cboReportCategory').value; 	
	var buyer = document.getElementById('cboBuyer').value; 
	var styleName = document.getElementById('cboStyleID').value; 
	
	if(StyleID=="" && reportId==0)
	{
		alert("Please select 'Order No'.");
		return false;
	}
	if(reportId==0)
		var reportName = "postordercostingRpt.php";
	else if(reportId==1)
		var reportName = "rptPostOrderCostingSummary.php";	
	var url =reportName+"?&StyleID="+StyleID+"&buyer="+buyer+"&styleName="+URLEncode(styleName);
	window.open(url,reportName);
	/*newwindow=window.open('postordercostingRpt.php?StyleID='+StyleID ,'costestimatesheet.php');
		if (window.focus) {newwindow.focus()}*/
}

function ViewExReport()
{
	var StyleID =document.getElementById('cboOrderNo').value;
	var reportId = document.getElementById('cboReportCategory').value; 	
	var buyer = document.getElementById('cboBuyer').value; 
	var styleName = document.getElementById('cboStyleID').value; 
	
	if(StyleID=="" && reportId==0)
	{
		alert("Please select 'Order No'.");
		return false;
	}
	if(reportId==0)
		var reportName = "xclcostestimatesheet.php?";
	else if(reportId==1)
		var reportName = "rptPostOrderCostingSummary.php";	
	var url =reportName+"?&StyleID="+StyleID+"&buyer="+buyer+"&styleName="+URLEncode(styleName);
	window.open(url,reportName);
	/*var StyleID = document.getElementById('cboOrderNo').value;	
	if(StyleID=="")
	{
		alert("Please select 'Order No'.");
		return false;
	}
	newwindow=window.open('xclcostestimatesheet.php?StyleID='+StyleID ,'xclcostestimatesheet.php');
		if (window.focus) {newwindow.focus()}*/
}
</script>
</body>
</html>