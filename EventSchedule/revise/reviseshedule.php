<?php
 session_start();
$backwardseperator = "../../";
include "../../authentication.inc";
include "../../Connector.php";
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
<title>GaPro - Approved Schedule - Ready For Revision</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}

-->
</style>



<script type="text/javascript" src="../../javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="../../javascript/bom.js"></script>
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

</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="reviseshedule.php">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include '../../Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="4%"><div align="center"><img src="../../images/butt_1.png" width="15" height="15" /></div></td>
          <td width="96%" class="head1">Approved Schedule - Ready For Revision</td>
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
					
$xml = simplexml_load_file('config.xml');
$reportname = $xml->PreOrder->ReportName;

 
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
	
	$SQL = "select intStyleId from eventscheduleheader where intStatus=2;";
	
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
	
	$SQL = "select specification.intSRNO from specification inner join eventscheduleheader on specification.intStyleId = eventscheduleheader.intStyleId AND eventscheduleheader.intStatus = 2 order by intSRNO desc;";
	
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
                  <td><div align="right"><img src="../../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><div id="divData" style="width:930px; height:400px; overflow: scroll; border-width:3px; border-style:solid;border-color:#99CCFF;">
            <table width="910" border="0" bgcolor="#CCCCFF" cellpadding="0" cellspacing="1" class="bcgl1" id="tblPreOders" >
              <tr>
                <td width="13%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">Style No</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">SC No </td>
                <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Company</td>
                <td width="17%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer</td>
                <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Approved By </td>
                <td width="17%" bgcolor="#498CC2" class="normaltxtmidb2">Approved Date</td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">View</td>
              </tr>
              <?php
			
			
		
			
			$sql = "SELECT orders.intStyleId,strDescription, companies.strComCode, buyers.strName,intQty,dtmAppDate,intSRNO, useraccounts.Name FROM orders INNER JOIN companies ON orders.intCompanyID = companies.intCompanyID 
			INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID 
			INNER JOIN specification ON orders.intStyleId = specification.intStyleId 
			INNER JOIN useraccounts ON orders.intApprovedBy = useraccounts.intUserID 
			INNER JOIN eventscheduleheader EH ON EH.intStyleId=orders.intStyleId
			 WHERE EH.intStatus = 2 ";
			
			
			if ($factory != "Select One" && $factory != "")
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
			$sql.= " order by dtmAppDate desc ";
			
			
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
                <td class="normalfnt"><?php echo  $row["intSRNO"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strDescription"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strComCode"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strName"]; ?></td>
                <td class="normalfnt"><?php echo  $row["Name"]; ?></td>
                <td class="normalfnt"><?php echo  $row["dtmAppDate"]; ?></td>
                <td class="normalfnt"><a href="reviseschedulereport.php?styleID=<?php echo urlencode($row["intStyleId"]); ?>" target="_blank"><img src="../../images/revise.png" border="0" class="noborderforlink" /></a></td>
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
      <td><div align="right"></div></td>
    </tr>
  </table>
</form>
</body>
</html>
