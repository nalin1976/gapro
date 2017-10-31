<?php
session_start();
include "authentication.inc";
include "Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Merchandiser Transfer</title>
<script src="javascript/script.js" type="text/javascript"></script>
<script type="text/javascript" >
var xmlHttp;


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


function getScNo()
{
	
	var styleID = document.getElementById('cboStyles').value;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = handlestyshow;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=getSRNo&styleID=' + URLEncode(styleID) , true);   
	xmlHttp.send(null);
}

function handlestyshow()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("SrNO");	
			var ctyID = XMLResult[0].childNodes[0].nodeValue;
			document.getElementById('cboSR').value = "Select One";
			document.getElementById('cboSR').value = ctyID;
			LoadStyleDetails();
		}		
	}	
}

function getStyleNo()
{
	var scNo = document.getElementById('cboSR').value;
	createXMLHttpRequest();
   xmlHttp.onreadystatechange = handleSCshow;
   xmlHttp.open("GET", 'preordermiddletire.php?RequestType=getStyleID&scNo=' + scNo , true);   
	xmlHttp.send(null); 
}

function handleSCshow()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var XMLResult = xmlHttp.responseXML.getElementsByTagName("StyID");	
			var ctyID = XMLResult[0].childNodes[0].nodeValue;
			document.getElementById('cboStyles').value = "Select One";
			document.getElementById('cboStyles').value = ctyID;
			LoadStyleDetails();
		}		
	}	
}

function LoadStyleDetails()
{
	var styleID = document.getElementById('cboStyles').value;
	createXMLHttpRequest();
   xmlHttp.onreadystatechange = handleTransferDetails;
   xmlHttp.open("GET", 'preordermiddletire.php?RequestType=getTransferDetails&styleID=' + styleID , true);   
	xmlHttp.send(null); 
}

function handleTransferDetails()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
			var userID = xmlHttp.responseXML.getElementsByTagName("UserID")[0].childNodes[0].nodeValue;
			var userName = xmlHttp.responseXML.getElementsByTagName("UserName")[0].childNodes[0].nodeValue;
			var merchantID = xmlHttp.responseXML.getElementsByTagName("MerchantID")[0].childNodes[0].nodeValue;
			var merchantName = xmlHttp.responseXML.getElementsByTagName("MerchantName")[0].childNodes[0].nodeValue;
			document.getElementById('costingby').innerHTML = userName;
			document.getElementById('merchandiser').innerHTML = merchantName;
			document.getElementById('cboCosting').value = userID;
			document.getElementById('cboMerchant').value = merchantID;
			
					
			
		   }		
	 }	
}

function transferStyle()
{
	var currentMerchant = document.getElementById('merchandiser').innerHTML.trim();
	var newMerchant     = document.getElementById('cboMerchant').options[document.getElementById('cboMerchant').selectedIndex].text.trim();
	var currentCostingDoneBy = document.getElementById('costingby').innerHTML.trim();
	var newCostingDoneBy     = document.getElementById('cboCosting').options[document.getElementById('cboCosting').selectedIndex].text.trim();
	
	if( document.getElementById('cboStyles').value == "Select One")
	{
		alert("Please select the 'Order No'.");
		document.getElementById('cboStyles').focus();
		return;
	}
	else if(currentMerchant == newMerchant && currentCostingDoneBy == newCostingDoneBy)
	{
		alert("Please select different user for 'New Merchandiser' or 'Costing Done By'.");
		document.getElementById('cboMerchant').focus();
		return;
	}
	
	else if( document.getElementById('cboMerchant').value == "Select One")
	{
		alert("Please select the 'Merchandiser'.");
		document.getElementById('cboMerchant').focus();
		return;
	}
	
	var styleID = document.getElementById('cboStyles').value;
	var merchant = document.getElementById('cboMerchant').value;
	var costing = document.getElementById('cboCosting').value;
	createXMLHttpRequest();
   xmlHttp.onreadystatechange = handleTransfer;
   xmlHttp.open("GET", 'preordermiddletire.php?RequestType=TransferStyle&styleID=' + styleID + '&merchant=' + merchant + '&costing=' + costing , true);   
	xmlHttp.send(null); 
}

function handleTransfer()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
        	var styleID = document.getElementById('cboStyles').value;
			var orderName = document.getElementById('cboStyles').options[document.getElementById('cboStyles').selectedIndex].text;
			var merchant = document.getElementById('cboMerchant').options[document.getElementById('cboMerchant').selectedIndex].text;
			var costing = document.getElementById('cboCosting').options[document.getElementById('cboCosting').selectedIndex].text;
			document.getElementById('merchandiser').innerHTML = merchant;	
			alert("The Order No : " + orderName + " has been transferred to the merchandiser : " + merchant + " , Costing Done By : " + costing);	
			clearPage();
			
		   }		
	 }	
}

function clearPage()
{
	document.getElementById('cboStyles').value = 'Select One';
	document.getElementById('cboMerchant').value = 'Select One';
	document.getElementById('cboCosting').value = 'Select One';
	document.getElementById('cboSR').value = 'Select One';
	document.getElementById('merchandiser').innerHTML = '';
	document.getElementById('costingby').innerHTML = '';
}
</script>

<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <tr>
    <td width="752"><?php include 'Header.php'; ?></td>
  </tr>
<table width="965" border="0" align="center">

  <tr>
    <td><table width="100%" border="0"  cellpadding="0" cellspacing="1" class="bcgl1">
      <tr>
        <td height="27" class="mainHeading">Merchandiser Transfer</td>
      </tr>
      <tr>
        <td height="57" align="center">
			<div>
			<table width="50%" >
			<tr>
			<td height="27">&nbsp;</td>		
			</tr>			
			<tr>
			<td class="txtbox">Order No </td>		
			<td class="txtbox"><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="getScNo();">
                    <option value="Select One" selected="selected">Select One</option>
<?php
	
	$SQL = "select specification.intStyleId,orders.strOrderNo from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus in(11,0) order by orders.strOrderNo;";	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($reqStyleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}	
?>
                  </select></td>	
			</tr>
			<tr>
			<TD class="txtbox">SC No</td>
			<TD class="txtbox"><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="getStyleNo();">
                    <option value="Select One" selected="selected">Select One</option>
<?php	
	$SQL = "select specification.intSRNO from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus in(11,0) order by specification.intSRNO desc;";	
	$result = $db->RunQuery($SQL);	
	while($row = mysql_fetch_array($result))
	{
		if ($reqSRNO==  $row["intSRNO"])
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
			<td class="txtbox">Costing Done By</td>
			<td id="costingby" class="txtbox"></td>			
			</tr>
			<tr>
			<td class="txtbox">Current Merchandiser</td>
			<td id="merchandiser" class="txtbox"></td>			
			</tr>
			<tr>
			  <td class="txtbox">New Merchandiser</td>
			  <td class="txtbox"><select name="cboMerchant"  class="txtbox" style="width:150px" id="cboMerchant" >
                <option value="Select One" selected="selected">Select One</option>
                <?php
	
	$SQL = "SELECT useraccounts.Name, useraccounts.intUserID FROM useraccounts INNER JOIN userpermission ON useraccounts.intUserID = userpermission.intUserID INNER JOIN role ON userpermission.RoleID = role.RoleID WHERE role.RoleName = 'Merchandising' order by useraccounts.Name;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
			echo "<option value=\"". $row["intUserID"] ."\">" . $row["Name"] ."</option>" ;
	}
	
	?>
              </select></td>
			  </tr>
			<tr>
			<td class="txtbox">New Costing Done By </td>
			<td class="txtbox"><select name="cboCosting"  class="txtbox" style="width:150px" id="cboCosting">
              <option value="Select One" selected="selected">Select One</option>
              <?php
	
	$SQL = "SELECT useraccounts.Name, useraccounts.intUserID FROM useraccounts INNER JOIN userpermission ON useraccounts.intUserID = userpermission.intUserID INNER JOIN role ON userpermission.RoleID = role.RoleID WHERE role.RoleName = 'Merchandising' order by useraccounts.Name;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
			echo "<option value=\"". $row["intUserID"] ."\">" . $row["Name"] ."</option>" ;
	}
	
	?>
            </select></td>			
			</tr>
			<tr>
			<td></td>
			<td class="txtbox"><span class="mouseover" onClick="transferStyle();"><img src="images/transfer.png" class="mouseover" /><sup class="normalfnt"> Transfer</sup></span></td>			
			</tr>
			</table>			
			</div>
</td>
      </tr>
      <tr>
        <td height="74">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table>
</body>
</html>
