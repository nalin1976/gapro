<?php
 session_start();
$backwardseperator = "../";
include "${backwardseperator}authentication.inc";
$factory = $_POST["cboFactory"];
$buyer = $_POST["cboCustomer"];
$styleID = $_POST["cboStyles"];
$srNo = $_POST["cboSR"];

if ($factory != "Select One")
{
	$styleID = "Select One";
	$srNo = "Select One";
}

if ($_POST["txtStyle"] != "")
	$styleID = $_POST["txtStyle"];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Pending Cost Sheets</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}

-->
</style>



<script type="text/javascript" src="../javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="../javascript/script.js"></script>
<script type="text/javascript" src="../javascript/bom.js"></script>
<script type="text/javascript">

var index = 0;
var styles =new Array();
var message = "Following Style Numbers has been updated as completed.\n\n";

function resetCompanyBuyer()
{
	document.getElementById("cboFactory").value = "Select One";
	document.getElementById("cboCustomer").value = "Select One";
}

function submitForm()
{
	document.frmcomplete.submit();
}

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

function startCompletionProcess()
{
	var pos = 0;
	var tbl = document.getElementById('tblPreOders');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if (tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			styles[pos] = tbl.rows[loop].cells[0].childNodes[0].id;
			pos ++;
		}
	}
	process();
}

function process()
{
	if (index > styles.length -1)
	{
		alert("Process completed.");
		window.location = window.location;
		return;
	}
	var styleID = URLEncode(styles[index]);
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = HandleProcess;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=competeOrders&styleID=' + styleID, true);
    xmlHttp.send(null);  
}

function HandleProcess()
{
    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			if (xmlHttp.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue == "True")
			{
				message += styles[index] +", ";
				index ++;
				process();
			}
		}
	}
}

function openReport(type)
{
	var factoryID = document.getElementById("cboFactory").value;
	if(factoryID == "Select One")
	{
		alert("Please select a company/factory.");
		document.getElementById("cboFactory").focus();
		return ;
	}
	
	if(type == "critical")
		window.open("criticalScheduleReport.php?companyID=" + factoryID);
	else if (type == "completed")
		window.open("completedEvents.php?companyID=" + factoryID);
	else
		window.open("revisedEvents.php?companyID=" + factoryID);
}

</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="eventStyleList.php">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include '../Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="4%"><div align="center"><img src="../images/butt_1.png" width="15" height="15" /></div></td>
          <td width="96%" class="head1">Time & Action Plan Reports</td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0">
                <tr>
                  <td width="72" bgcolor="#99CCFF" class="txtbox">Factory</td>
                  <td width="72" class="txtbox"><select name="cboFactory" class="txtbox" id="cboFactory" style="width:170px">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
					

$reportname = "preorderReportApprove.php";

	include "../Connector.php"; 
	$SQL = "SELECT intCompanyID,strName FROM companies c where intStatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($factory == $row["intCompanyID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		}
	}
	
	?>
                  </select></td>
                  <td width="72" bgcolor="#99CCFF" class="txtbox">Buyer</td>
                  <td width="72" class="txtbox"><select name="cboCustomer" class="txtbox" style="width:180px" id="cboCustomer">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		if ($buyer == $row["intBuyerID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
	}
	
	?>
                  </select></td>
                  <td width="72" bgcolor="#99FF66" class="txtbox">Style No </td>
                  <td width="155" class="txtbox"><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="getScNo();resetCompanyBuyer();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT DISTINCT eventscheduleheader.intStyleId FROM eventscheduleheader INNER JOIN orders
ON eventscheduleheader.intStyleId = orders.intStyleId where orders.intStatus <> 13;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["intStyleId"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intStyleId"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="70" bgcolor="#99FF66" class="txtbox">SC No</td>
                  <td width="150" class="txtbox"><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="getStyleNo();resetCompanyBuyer();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT DISTINCT eventscheduleheader.intStyleId,specification.intSRNO FROM eventscheduleheader INNER JOIN specification
ON eventscheduleheader.intStyleId = specification.intStyleId INNER JOIN orders 
ON  specification.intStyleId = orders.intStyleId
WHERE orders.intStatus <> 13;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($srNo==  $row["intSRNO"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intSRNO"] ."\">" . $row["intSRNO"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intSRNO"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  </tr>
                <tr>
                  <td height="26">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td bgcolor="#99FF66" class="txtbox">Like</td>
                  <td><input name="txtStyle" type="text" class="txtbox" id="txtStyle" value="<?php echo $_POST["txtStyle"]; ?>" /></td>
                  <td>&nbsp;</td>
                  <td><div align="right"><img src="../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><div id="divData" style="width:930px; height:400px; overflow: scroll; border-width:3px; border-style:solid;border-color:#99CCFF;">
            <table width="910" border="0" cellpadding="0" cellspacing="1" class="bcgl1" id="tblPreOders" >
              <tr>
                <td width="19%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">Style No</td>
                <td width="24%" bgcolor="#498CC2" class="normaltxtmidb2">Company</td>
                <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Merchandiser</td>
                <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Critical</td>
                <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Completed</td>
                <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Revised</td>
                <?php if($approvalPreOrder) { ?>
                
                <?php } ?>
              </tr>
              <?php
			
			
		
			
			$sql = "SELECT DISTINCT eventscheduleheader.intStyleId,specification.intSRNO, companies.strComCode, useraccounts.Name AS merchandiser
FROM eventscheduleheader INNER JOIN orders ON eventscheduleheader.intStyleId = orders.intStyleId 
INNER JOIN companies ON orders.intCompanyID = companies.intCompanyID 
INNER JOIN useraccounts ON orders.intCoordinator = useraccounts.intUserID 
LEFT JOIN specification ON eventscheduleheader.intStyleId = specification.intStyleId  AND specification.intStyleId   = orders.intStyleId 
WHERE orders.intStatus <> 13 " ;
			
			
			if ($factory != "Select One" )
			{
				$sql.= " and orders.intCompanyID = $factory";
			}
			if ($buyer != "Select One" && $buyer != "" )
			{
				$sql.= " and orders.intBuyerID = $buyer";
			}
			if ($styleID != "Select One" && $styleID != "" )
			{
				$sql.= " and orders.intStyleId like '%$styleID%'";
			}
			$sql.= " order by dtmDate desc ";
			
			//echo $sql;
			$result = $db->RunQuery($sql);	
			$pos = 0;
			while($row = mysql_fetch_array($result))
			{
			?>
              <tr class="<?php 
			  if ($pos % 2 == 0)
					echo "bcgcolor-tblrow";
				else
					echo "bcgcolor-tblrowWhite";
			   ?>">
                <td height="21" class="normalfnt"><?php echo  $row["intStyleId"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strComCode"]; ?></td>
                <td class="normalfnt"><?php echo  $row["merchandiser"]; ?></td>
                <td align="center"><a href="criticalScheduleReport.php?styleID=<?php echo  $row["intStyleId"]; ?>" target="_blank"><img class="noborderforlink" src="../images/critical.png"></a></td>
                <td align="center"><a href="completedEvents.php?styleID=<?php echo  $row["intStyleId"]; ?>" target="_blank"><img class="noborderforlink" src="../images/completed.png"></a></td>
               <td align="center"><a href="revisedEvents.php?styleID=<?php echo  $row["intStyleId"]; ?>" target="_blank"><img class="noborderforlink" src="../images/reviseico.png"></a></td>
              </tr>
              <?php
			  $pos ++;
			}
			?>
            </table>
          </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>
		<table width="100%">
			<tr>
				<td width="10"><img class="mouseover" src="../images/allcritical.png" onClick="openReport('critical');"></td>
				<td class="normalfntLeftTABNoBorder"> All Critical Event Report</td>
				<td width="10"><img class="mouseover" src="../images/allcompleted.png" onClick="openReport('completed');"></td>
				<td class="normalfntLeftTABNoBorder">All Completed Event Report</td>
				<td width="10"><img class="mouseover" src="../images/allreviced.png" onClick="openReport('revised');"></td>
				<td class="normalfntLeftTABNoBorder">All Revised Event Report</td>			
			</tr>		
		</table>      
      </td>
    </tr>
  </table>
</form>
</body>
</html>
