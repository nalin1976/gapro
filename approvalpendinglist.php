<?php
 session_start();
include "authentication.inc";
 
$factory 	= $_POST["cboFactory"];
$buyer 		= $_POST["cboCustomer"];
$styleID 	= $_POST["cboStyles"];
$srNo 		= $_POST["cboSR"];
$orderId 	= $_POST["cboOrderNo"];
$styleNo	= $_POST["txtStyleNo"];
$orderNo	= $_POST["txtOrderNo"];
if ($factory != "")
{
	$styleID = "";
	$srNo = "";
}

if ($_POST["txtStyle"] != "")
	$styleID = $_POST["txtStyle"];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro Web - Pending Cost Sheets</title>
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
}
function GetStyleName(obj)
{
	document.getElementById('cboOrderNo').value = obj.value;
}

function GetStyleWiseOrderNo(obj)
{	
	var status = "10";
	var booUser	= false;
	var url = "Reports/orderreport/orderreportxml.php?RequestType=GetStyleWiseOrderNoInReports&styleNo=" +obj+ '&status='+status+ '&booUser=' +booUser;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboOrderNo').innerHTML  = htmlobj.responseText;
}
function GetStyleWiseScNo(obj)
{	
	var status = "10";
	var booUser	= false;
	var url = "Reports/orderreport/orderreportxml.php?RequestType=GetStyleWiseScNoInReports&styleNo=" +obj+ '&status='+status+ '&booUser=' +booUser;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboSR').innerHTML  = htmlobj.responseText;
}
</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="approvalpendinglist.php">
    <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
  <table width="950" border="0" align="center" class="bcgl1">

    <tr>
      <td colspan="3"><table width="100%" border="0">
        <tr>
          <td colspan="2" height="25" class="mainHeading">Approval Pending Cost Sheets</td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0" class="tableBorder">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0" >
                <tr>
                  <td width="72" class="normalfnt">Factory</td>
                  <td width="72" ><select name="cboFactory" class="txtbox" id="cboFactory" style="width:170px">
                    <option value="" selected="selected">Select One</option>
                    <?php
					

$reportname = "oritpreorderReport.php";

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
                  <td width="72" class="normalfnt">Style No </td>
                  <td width="72" ><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="GetStyleWiseOrderNo(this.value);GetStyleWiseScNo(this.value);resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select distinct orders.strStyle from orders where orders.intStatus = 10 ;";
	
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
                  <td width="72" class="normalfnt">Order No </td>
                  <td width="155" ><select name="cboOrderNo" class="txtbox" style="width:150px" id="cboOrderNo" onchange="GetScNo(this);resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select O.intStyleId,O.strOrderNo from orders O where O.intStatus = 10 ";
	if($styleID!="")
		$SQL .= " and O.strStyle='$styleID' ";
		
	$SQL .= " order by O.strOrderNo";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($orderId==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="70" class="normalfnt">SC No</td>
                  <td width="150"  ><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="GetStyleName(this);resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId,specification.intSRNO from specification inner join orders on specification.intStyleId = orders.intStyleId AND (orders.intStatus = 10 OR orders.intStatus = 5 OR orders.intStatus = 20 OR orders.intStatus = 25) ;";
	
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
                  <td height="26" class="normalfnt">Buyer</td>
                  <td>
                    <select name="cboCustomer" class="txtbox" style="width:170px" id="cboCustomer">
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
                    </select>                  </td>
                  <td class="normalfnt">Like</td>
                  <td><input name="txtStyleNo" type="text" class="txtbox" id="txtStyleNo" value="<?php echo $_POST["txtStyleNo"]; ?>" style="width:148px;" /></td>
                  <td class="normalfnt">Like</td>
                  <td><input name="txtOrderNo" type="text" class="txtbox" id="txtOrderNo" value="<?php echo $_POST["txtOrderNo"]; ?>" /></td>
                  <td>&nbsp;</td>
                  <td><div align="right"><img src="images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><div id="divData" style="width:950px; height:400px; overflow: scroll;">
            <table width="100%" border="0" cellpadding="1" cellspacing="1" id="tblPreOders" bgcolor="#CCCCFF">
              <tr class="mainHeading4">
                <th width="8%" height="25" >SC No</th>
                <th width="19%" >Order No</th>
                <th width="16%" >Buyer</th>
                <th width="22%" >Description</th>
                <th width="8%" >Order Qty</th>
                <th width="8%" >EPM</th>
                <th width="9%" >Created Date</th>
                <th width="10%" >View</th>
              </tr>
              <?php
			# =====================================================================
			# Change On - 2015/09/03
			# Chnage By - Nalin Jayakody
			# Description - To add SC number and EPM to the list
			# =====================================================================  
			/*$sql = "SELECT O.strOrderNo,O.intStyleId,O.strDescription,C.strComCode,B.strName,O.intQty,O.dtmDate,O.intFirstApprovedBy FROM orders O INNER JOIN companies C ON O.intCompanyID = C.intCompanyID INNER JOIN buyers B ON O.intBuyerID = B.intBuyerID WHERE O.intStatus = 10 " ;*/
			# =====================================================================
			
                        # =====================================================================
			# Change On - 2017/01/24
			# Chnage By - Nalin Jayakody
			# Description - List pending process and pending 3rd approval orders
                        # =====================================================================
			$sql = "SELECT O.strOrderNo,O.intStyleId,O.strDescription,C.strComCode,B.strName,O.intQty,O.dtmDate,O.intFirstApprovedBy, specification.intSRNO, O.reaSMVRate, O.intStatus FROM orders O INNER JOIN companies C ON O.intCompanyID = C.intCompanyID INNER JOIN buyers B ON O.intBuyerID = B.intBuyerID Left Outer Join specification ON O.intStyleId = specification.intStyleId WHERE (O.intStatus = 10 OR O.intStatus = 5 OR O.intStatus = 20 OR O.intStatus = 25) " ;
			
			if ($factory != "" )
			{
				$sql.= " and O.intCompanyID = $factory";
			}
			if ($buyer != "" )
			{
				$sql.= " and O.intBuyerID = $buyer";
			}
			if ($orderId != "" )
			{
				$sql.= " and O.intStyleId ='$orderId'";
			}
			if ($styleID != "" )
			{
				$sql.= " and O.strStyle ='$styleID'";
			}
			if ($styleNo != "" )
			{
				$sql.= " and O.strStyle like '%$styleNo%'";
			}
			if ($orderNo != "" )
			{
				$sql.= " and O.strOrderNo like '%$orderNo%'";
			}
			$sql.= " order by O.dtmDate desc ";
			$result = $db->RunQuery($sql);	
			$pos = 0;
			while($row = mysql_fetch_array($result))
			{
			?>
              <tr class="<?php 
			 	/*if ($row["intFirstApprovedBy"]=='0')
					echo "bcgcolor-tblrowWhite";
				else
					echo "bcgcolor-InvoiceCostFabric";*/
                                switch($row["intStatus"]){
                                    case "10":
                                        echo "bcgcolor-InvoiceCostFabric";
                                        break;
                                    
                                    case "25":
                                        echo "bcgcolor-creamelight";
                                        break;
                                    
                                    default:
                                        echo "bcgcolor-tblrowWhite";
                                        break;
                                }
                                 
			   ?>">
                <td class="normalfnt"><?php echo  $row["intSRNO"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strOrderNo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strName"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strDescription"]; ?></td>
                <td class="normalfntR"><?php echo  number_format($row["intQty"]); ?>&nbsp;</td>
                <td class="normalfntR"><?php echo  $row["reaSMVRate"]; ?>&nbsp;</td>
                <td class="normalfntR"><?php echo  $row["dtmDate"]; ?>&nbsp;</td>
              
                <td class="normalfntMid"><a href="<?php echo $reportname; ?>?styleID=<?php echo  urlencode($row["intStyleId"]); ?>" target="_blank"><img src="images/view2.png" border="0" class="noborderforlink" /></a></td>
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
    <tr class="tableBorder">
        <td width="100%">
            <table width="100%" b >
                <tr>
                    <td width="38">&nbsp;</td>
                    <td width="20" class="txtbox bcgcolor-InvoiceCostFabric">&nbsp;</td>
                    <td width="150" class="normalfnt"> First Approved Orders </td>
                    <td width="38">&nbsp;</td>
                    <td width="20" class="txtbox bcgcolor-creamelight">&nbsp;</td>
                    <td width="890" class="normalfnt"> Second Approved Orders </td>
                </tr>
            </table>
        </td>  
    </tr>
  </table>
</form>
</body>
</html>
