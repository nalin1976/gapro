<?php
 session_start();
include "authentication.inc";
 
$factory = $_POST["cboFactory"];
$buyer = $_POST["cboCustomer"];
$styleID = $_POST["cboStyles"];
$srNo = $_POST["cboSR"];
$cboOrderNo = $_POST["cboOrderNo"];

if ($factory != "")
{
	$styleID = "";
	$srNo = "";
}

if ($_POST["txtStyle"] != "")
	$styleName = $_POST["txtStyle"];
	
if($_POST["txtOrderNo"] != "")
	$orderNo = $_POST["txtOrderNo"];	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Pending Cost Sheets</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<script type="text/javascript" src="javascript/bom.js"></script>
<script type="text/javascript">

var index = 0;
var styles =new Array();
var message = "Following Style Numbers has been updated as completed.\n\n";

function resetCompanyBuyer()
{
	document.getElementById("cboFactory").value = "";
	document.getElementById("cboCustomer").value = "";
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

function GetScNo(obj)
{
	document.getElementById('cboSR').value = obj.value;
	document.getElementById('cboOrderNo').value = obj.value;
}
function GetStyleName(obj)
{
	document.getElementById('cboStyles').value = obj.value;
	document.getElementById('cboOrderNo').value = obj.value;
}

function getOrderNo(obj)
{
	document.getElementById('cboSR').value = obj.value;
	document.getElementById('cboStyles').value = obj.value;
}

function GetStyleWiseOrderNo(obj)
{	
	var status = "11,13";
	var booUser	= true;
	var url = "Reports/orderreport/orderreportxml.php?RequestType=GetStyleWiseOrderNoInReports&styleNo=" +obj+ '&status='+status+ '&booUser=' +booUser;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboOrderNo').innerHTML  = htmlobj.responseText;
}
function GetStyleWiseScNo(obj)
{	
	var status = "11,13";
	var booUser	= true;
	var url = "Reports/orderreport/orderreportxml.php?RequestType=GetStyleWiseScNoInReports&styleNo=" +obj+ '&status='+status+ '&booUser=' +booUser;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboSR').innerHTML  = htmlobj.responseText;
}
</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="allpendingcostsheets.php">
    <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
  <table width="950" border="0" align="center" class="bcgl1">
    <tr>
      <td><table width="100%" border="0">
        
        <tr>         
          <td width="96%" class="mainHeading">Pending Cost Sheets</td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0" class="bcgl1">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0" class="normalfnt">
                <tr>
                  <td width="61" >Factory</td>
                  <td width="189" ><select name="cboFactory" class="txtbox" id="cboFactory" style="width:170px">
                    <option value="" selected="selected">Select One</option>
                    <?php
					
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
                  <td width="87" >Style No </td>
                  <td width="151" ><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="GetStyleWiseOrderNo(this.value);GetStyleWiseScNo(this.value);resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select orders.strStyle from orders where orders.intStatus=0;";	
	$result = $db->RunQuery($SQL);	
	while($row = mysql_fetch_array($result))
	{
		if ($styleID==  $row["strStyle"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="72" >Order No</td>
                  <td width="155" ><select name="cboOrderNo" id="cboOrderNo" style="width:150px;" onchange="getOrderNo(this);resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select O.intStyleId,O.strOrderNo from orders O where O.intStatus=0 ";
	if($styleID!="")
		$SQL .= " and O.strOrderNo='$styleID' ";
		
	$SQL .= "order by O.strOrderNo";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($cboOrderNo == $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="71" >SC No</td>
                  <td width="111" ><select name="cboSR" class="txtbox" style="width:130px" id="cboSR" onchange="GetStyleName(this);resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId,specification.intSRNO from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus=0 order by intSRNO desc;";
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
                  <td height="26">Buyer</td>
                  <td><select name="cboCustomer" class="txtbox" style="width:170px" id="cboCustomer">
                    <option value="" selected="selected">Select One</option>
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
                  <td>Like</td>
                  <td><input name="txtStyle" type="text" class="txtbox" id="txtStyle" value="<?php echo $_POST["txtStyle"]; ?>" style="width:148px;" /></td>
                  <td >Like</td>
                  <td><input type="text" name="txtOrderNo" id="txtOrderNo" style="width:148px;" value="<?php echo $_POST["txtOrderNo"]; ?>" /></td>
                  <td>&nbsp;</td>
                  <td><div align="right"><img src="images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
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
                 <td width="10%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">Order No</td>
                <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">SC No </td>
                <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Company</td>
                <td width="15%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer</td>
                <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Approved By </td>
                <td width="14%" bgcolor="#498CC2" class="normaltxtmidb2">Approved Date</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">View</td>
              </tr>
              <?php
$booUse	= false;
			$sql = "SELECT orders.strStyle,orders.intStyleId,strDescription, orders.strOrderNo, companies.strComCode, buyers.strName,intQty,orders.dtmDate,intSRNO, useraccounts.Name FROM orders 
			INNER JOIN companies ON orders.intCompanyID = companies.intCompanyID 
			INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID 
			left join specification ON orders.intStyleId = specification.intStyleId 
			INNER JOIN useraccounts ON orders.intUserID = useraccounts.intUserID 
			WHERE orders.intStatus=0 ";
			
			if($factory != "")
			{
				$booUse	= true;
				$sql.= " and orders.intCompanyID = $factory";
			}
			if($buyer != "" )
			{
				$booUse	= true;
				$sql.= " and orders.intBuyerID = $buyer";
			}
			if($cboOrderNo != "")
			{
				$booUse	= true;
				$sql.= " and orders.intStyleId = '$cboOrderNo'";
			}
			if($styleID != "")
			{
				$booUse	= true;
				$sql.= " and orders.strStyle = '$styleID'";
			}
			if($styleName != '')
			{
				$booUse	= true;
				$sql.= " and orders.strStyle like '%$styleName%'";
			}
			if($orderNo != '')
			{
				$booUse	= true;
				$sql.= " and orders.strOrderNo like '%$orderNo%'";
			}
			
			if($booUse)
				$sql.= " order by dtmDate desc ";
			else
				$sql.= " order by dtmDate desc limit 0,50";
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
                <td height="21" class="normalfnt"><?php echo  $row["strStyle"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strOrderNo"]; ?></td>
                <td class="normalfntMid"><?php echo  ($row["intSRNO"]=="" ? '-':$row["intSRNO"]); ?></td>
                <td class="normalfnt"><?php echo  $row["strDescription"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strComCode"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strName"]; ?></td>
                <td class="normalfnt"><?php echo  $row["Name"]; ?></td>
                <td class="normalfnt"><?php echo  $row["dtmDate"]; ?></td>
                <td class="normalfnt"><a href="<?php echo $reportname; ?>?styleID=<?php echo  urlencode($row["intStyleId"]); ?>" target="_blank"><img src="images/view2.png" border="0" class="noborderforlink" /></a></td>
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