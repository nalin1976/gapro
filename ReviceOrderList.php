<?php
 session_start();
 include "authentication.inc";
 
$factory = $_POST["cboFactory"];
$buyer = $_POST["cboCustomer"];
$styleID = $_POST["cboStyles"];
$srNo = $_POST["cboSR"];
$orderNo = $_POST["cboOrderNo"];

if ($factory != "Select One")
{
	$styleID = "";
	$srNo = "";
}

if ($_POST["txtStyle"] != "")
	$styleName = $_POST["txtStyle"];

$xml = simplexml_load_file('config.xml');
$reportname = $xml->PreOrder->ReportName;

	include "Connector.php";	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Approved Cost Sheets</title>
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

function GetScFromOrderNo(obj)
{
	document.getElementById('cboSR').value = obj.value;
}
function GetOrderNoFromSc(obj)
{
	document.getElementById('cboOrderNo').value = obj.value;
}

function GetOrderNo(obj)
{
	var url="preordermiddletire.php?RequestType=GetApCoSheetOrderNo&styleNo="+obj;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboOrderNo').innerHTML = htmlobj.responseText;
}

function GetScNo(obj)
{
	var url="preordermiddletire.php?RequestType=GetApCoSheetScNo&styleNo="+obj;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboSR').innerHTML = htmlobj.responseText;
}
</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="ReviceOrderList.php">
   <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
  <table width="950" border="0" align="center"  class="tableBorder">
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td height="25" colspan="2" bgcolor="#316895"  class="mainHeading"><div align="center">Approved Cost Sheets</div></td>
        </tr>

        <tr>
          <td colspan="2"><table width="100%" border="0" class="tableBorder">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0">
                <tr>
                  <td width="72" class="normalfnt">Buyer</td>
                  <td width="72" ><select name="cboCustomer" class="txtbox" style="width:180px" id="cboCustomer">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers where intStatus =1 order by strName;";
	
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
                  <td width="72"  class="normalfnt">Style No</td>
                  <td width="72" ><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="GetOrderNo(this.value);GetScNo(this.value);">
                    <option value="" >Select One</option>
                    <?php
	
	$SQL = "select distinct O.strStyle from specification S inner join orders O on S.intStyleId = O.intStyleId AND O.intStatus = 11 ";
	if(!$PP_ReviseMoreThanMaximumApproval)
		$SQL .= "and O.intUserID =" . $_SESSION["UserID"] . " ";
		$SQL .= "order by O.strStyle;";
	
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
                  <td width="72" class="normalfnt">Order No</td>
                  <td width="155" ><select name="cboOrderNo" id="cboOrderNo" style="width:150px;" onchange="GetScFromOrderNo(this)">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select distinct O.intStyleId,O.strOrderNo from specification S inner join orders O on S.intStyleId = O.intStyleId AND O.intStatus = 11 ";if(!$PP_ReviseMoreThanMaximumApproval)
	$SQL .= "and O.intUserID =" . $_SESSION["UserID"] . " ";
	
if($styleID!="")
	$SQL .= " and O.strStyle='$styleID' ";	
	
	$SQL .= "order by O.strStyle";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($orderNo==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="70" class="normalfnt">SC No</td>
                  <td width="150" ><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="GetOrderNoFromSc(this);resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select S.intStyleId,S.intSRNO from specification S inner join orders O  on S.intStyleId = O.intStyleId AND O.intStatus = 11 ";
if(!$PP_ReviseMoreThanMaximumApproval)
	$SQL .= "and O.intUserID =" . $_SESSION["UserID"] . " ";
if($styleID!="")
	$SQL .="and O.strStyle='$styleID' ";

	$SQL .="order by S.intSRNO desc";
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
                  <td height="26" class="normalfnt">Factory</td>
                  <td><select name="cboFactory" class="txtbox" id="cboFactory" style="width:180px">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
					
 
	$SQL = "SELECT intCompanyID,strName FROM companies c where intStatus='1' order by strName;";	
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
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td  class="normalfnt">Like</td>
                  <td><input name="txtStyle" type="text" class="txtbox" style="width:148px;" id="txtStyle" value="<?php echo $_POST["txtStyle"]; ?>" /></td>
                  <td>&nbsp;</td>
                  <td><div align="right"><img src="images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><div id="divData" style="width:930px; height:450px; overflow: scroll;">
            <table width="910" border="0" bgcolor="#CCCCFF" cellpadding="0" cellspacing="1" id="tblPreOders" >
              <tr class="mainHeading4">
                <th width="13%"  height="19" >Style No </th>
                <th width="14%">Order No</th>
                <th width="5%">SC No </th>
                <th width="19%">Description</th>
                <th width="9%">Company</th>
                <th width="12%">Buyer</th>
                <th width="11%">Approved By </th>
                <th width="7%">Approved Date</th>
                <th width="10%">View</th>
              </tr>
              <?php
			$sql = "SELECT O.strStyle,O.strOrderNo,O.intStyleId,strDescription, companies.strComCode, buyers.strName,intQty,dtmAppDate,intSRNO, useraccounts.Name FROM orders O INNER JOIN companies ON O.intCompanyID = companies.intCompanyID INNER JOIN buyers ON O.intBuyerID = buyers.intBuyerID INNER JOIN specification ON O.intStyleId = specification.intStyleId INNER JOIN useraccounts ON O.intApprovedBy = useraccounts.intUserID  WHERE O.intStatus = 11 ";
			if(!$PP_ReviseMoreThanMaximumApproval)
			{
				$sql.= "and O.intUserID =".$_SESSION["UserID"]."";
			}			
			if ($factory != "Select One" && $factory != "")
			{
				$sql.= " and O.intCompanyID = $factory";
			}
			if ($buyer != "Select One" && $buyer != "" )
			{
				$sql.= " and O.intBuyerID = $buyer";
			}
			if ($orderNo != "")
			{
				$sql.= " and O.intStyleId = $orderNo";
			}
			if($styleName != "")
			{
				$sql.= " and O.strOrderNo like '%$styleName%'";
			}
			if($styleID != "")
			{
				$sql.= " and O.strStyle = '$styleID'";
			}
			$sql.= " order by dtmAppDate desc ";
			
			
			$result = $db->RunQuery($sql);	
			$pos = 0;
			//echo $sql;
			while($row = mysql_fetch_array($result))
			{
			?>
              <tr class="<?php 
			  if ($pos % 2 == 0)
					echo "bcgcolor-tblrowWhite";
				else
					echo "bcgcolor-tblrowWhite";
			   ?>">
                <td class="normalfnt"><?php echo  $row["strStyle"]; ?></td>
                <td height="21" class="normalfnt"><?php echo  $row["strOrderNo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["intSRNO"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strDescription"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strComCode"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strName"]; ?></td>
                <td class="normalfnt"><?php echo  $row["Name"]; ?></td>
                <td nowrap="nowrap" class="normalfnt"><?php echo  $row["dtmAppDate"]; ?></td>
                <td nowrap="nowrap" class="normalfnt"><a href="ReviceConfirm.php?styleID=<?php echo urlencode($row["intStyleId"]);?>&Permission=<?php echo $PP_ReviseMoreThanMaximumApproval;?>" target="_blank"><img src="images/revise.png" border="0" class="noborderforlink" /></a></td>
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
