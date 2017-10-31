<?php
 session_start();
 include "authentication.inc";
$factory = $_POST["cboFactory"];
$buyer = $_POST["cboCustomer"];
$styleID = $_POST["cboOrderNo"];
$srNo = $_POST["cboSR"];
$styleName = $_POST["cboStyles"];
if ($factory != "Select One")
{
	$styleID = "Select One";
	$srNo = "Select One";
}
$userQuery = "";


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Order Cancellation</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<script type="text/javascript" src="javascript/bom.js"></script>
<script type="text/javascript">

var index = 0;
var styles =new Array();
var message = "Following Style Numbers has been updated as cancelled.\n\n";

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
	if(pos==0)
	{
		alert("Please select an Order No for cancelation.")
		return;
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
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=cancelOrders&styleID=' + styleID, true);
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

function GetScNo(obj)
{
	document.getElementById('cboSR').value = obj.value;
}
function GetStyleName(obj)
{
	document.getElementById('cboOrderNo').value = obj.value;
}

function getStylewiseOrderNolist()
{
	var stytleName = document.getElementById('cboStyles').value;
	var url="preordermiddletire.php";
					url=url+"?RequestType=getStyleWiseOrderNoinCancelOrder";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;
}

function getStylewiseSCNo()
{
	var stytleName = document.getElementById('cboStyles').value;
	var url="preordermiddletire.php";
					url=url+"?RequestType=getStyleWiseSCinCancelOrder";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboSR').innerHTML =  OrderNo;
}

</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="orderCancellation.php">
    <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
  <table width="950" border="0" align="center" class="bcgl1">
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td colspan="2" bgcolor="#316895"><div align="center" class="mainHeading">Order Cancellation</div></td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0" class="normalfnt">
                <tr>
                  <td width="72" >Factory</td>
                  <td width="72" ><select name="cboFactory" class="txtbox" id="cboFactory" style="width:170px">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
if ($canCancelAnyStyle)
	$userQuery = "";
else
	$userQuery = " and orders.intUserID =" . $_SESSION["UserID"] ;

					
$xml = simplexml_load_file('config.xml');
$reportname = $xml->PreOrder->ReportName;

	include "Connector.php"; 
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
                  <td width="72" >Buyer</td>
                  <td width="72" ><select name="cboCustomer" class="txtbox" style="width:180px" id="cboCustomer">
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
                  <td width="72" >Style No </td>
                  <td width="155" ><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="resetCompanyBuyer();getStylewiseOrderNolist();getStylewiseSCNo();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select distinct orders.strStyle from  orders where  orders.intStatus = 2 or orders.intStatus = 0 " . $userQuery;
		
	$SQL .= " order by orders.strStyle";
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleName==  $row["strStyle"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="70" >SC No</td>
                  <td width="150" ><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="GetStyleName(this);resetCompanyBuyer();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId,specification.intSRNO from specification inner join orders on specification.intStyleId = orders.intStyleId and orders.intStatus = 0 " . $userQuery ;
	
	if($styleName != 'Select One' && $styleName != '')
		$SQL .= " where strStyle='$styleName' ";
		
	$SQL .= " order by specification.intSRNO DESC";
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($srNo==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>Order No</td>
                  <td><select name="cboOrderNo" id="cboOrderNo" style="width:150px;" onchange="resetCompanyBuyer();GetScNo(this);">
                   <option value="Select One" selected="selected">Select One</option>
                   <?php
	
	$SQL = "select orders.intStyleId,orders.strOrderNo from  orders where  (orders.intStatus = 2 or orders.intStatus = 0) " . $userQuery;
	
	if($styleName != '' && $styleName != 'Select One')
		$SQL .= " and strStyle='$styleName' ";
		
	$SQL .= " order by orders.strOrderNo";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                  </select>
                  </td>
                  <td>&nbsp;</td>
                  <td><div align="right"><img src="images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><div id="divData" style="width:950px; height:450px; overflow: scroll; border-width:3px; border-style:solid;border-color:#99CCFF;">
            <table width="908" border="0" cellpadding="0" cellspacing="1" class="bcgl1" id="tblPreOders" >
              <tr>
                <td width="5%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
                <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">Order No</td>
                <td width="23%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Company</td>
                <td width="23%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer</td>
                <td width="14%" bgcolor="#498CC2" class="normaltxtmidb2">Order Qty </td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">View</td>
              </tr>
              <?php
			
			
		
			
			$sql = "SELECT orders.strStyle,orders.intStyleId,strDescription, companies.strComCode, buyers.strName,intQty,strOrderNo FROM orders INNER JOIN companies ON orders.intCompanyID = companies.intCompanyID INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID  WHERE (orders.intStatus = 0 or orders.intStatus = 2)" . $userQuery ;
			
			
			if ($factory != "Select One")
			{
				$sql.= " and orders.intCompanyID = $factory";
			}
			if ($buyer != "Select One" )
			{
				$sql.= " and orders.intBuyerID = $buyer";
			}
			if ($styleID != "Select One" )
			{
				$sql.= " and orders.intStyleId = '$styleID'";
			}
			if($styleName != "Select One")
			{
				$sql .= " and orders.strStyle = '$styleName'";
			}
			$sql .= " order by orders.strStyle";
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
                <td class="normalfntMid"><input name="checkbox" id="<?php echo  $row["intStyleId"]; ?>" type="checkbox" value="checkbox" /></td>
                <td class="normalfnt"><?php echo  $row["strOrderNo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strDescription"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strComCode"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strName"]; ?></td>
                <td class="normalfntRite"><?php echo  $row["intQty"]; ?></td>
                <td class="normalfnt"><a href="<?php echo $reportname; ?>?styleID=<?php echo  $row["intStyleId"]; ?>" target="_blank"><img src="images/view2.png" border="0" class="noborderforlink" /></a></td>
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
      <td><div align="center">
	  <img src="images/conform.png" onclick="startCompletionProcess();" alt="Confirm" width="115" height="24" class="mouseover" />
	  <a href="main.php"><img src="images/close.png" border="0" alt="Close" class="mouseover" /></a>
	  </div></td>
    </tr>
  </table>
</form>
</body>
</html>
