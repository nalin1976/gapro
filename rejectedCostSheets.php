<?php
 session_start();
include "authentication.inc";
 
$factory 	= $_POST["cboFactory"];
$buyer 		= $_POST["cboCustomer"];
$styleID 	= $_POST["cboStyles"];
$srNo 		= $_POST["cboSR"];
$orderId	= $_POST["cboOrderNo"];
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
<title>GaPro - Rejected Cost Sheets</title>
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

function SendtoPreOrderMode(styleNO)
{
	window.location = "editpreorder.php?StyleNo=" + styleNO + '&updateRequired=Y';
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
	var status = "12";
	var booUser	= true;
	var url = "Reports/orderreport/orderreportxml.php?RequestType=GetStyleWiseOrderNoInReports&styleNo=" +obj+ '&status='+status+ '&booUser=' +booUser;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboOrderNo').innerHTML  = htmlobj.responseText;
}
function GetStyleWiseScNo(obj)
{	
	var status = "12";
	var booUser	= true;
	var url = "Reports/orderreport/orderreportxml.php?RequestType=GetStyleWiseScNoInReports&styleNo=" +obj+ '&status='+status+ '&booUser=' +booUser;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboSR').innerHTML  = htmlobj.responseText;
}
</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="rejectedCostSheets.php">
    <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
  <table width="950" border="0" align="center" class="bcgl1">
    <tr>
      <td><table width="100%" border="0">
        <tr>
         <td colspan="2" bgcolor="#316895"><div align="center" class="mainHeading">Rejected Cost Sheets</div></td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0" class="tableBorder">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0" class="normalfnt">
                <tr>
                  <td width="59" >Factory</td>
                  <td width="187"><select name="cboFactory" class="txtbox" id="cboFactory" style="width:170px">
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
                  <td width="82" >Style No </td>
                  <td width="150"><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="GetStyleWiseOrderNo(this.value);GetStyleWiseScNo(this.value);resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select distinct orders.strStyle from orders where orders.intStatus = 12 ";	
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
                  <td width="59">Order No</td>
                  <td width="152"><select name="cboOrderNo" id="cboOrderNo" style="width:150px;" onchange="resetCompanyBuyer();GetScNo(this);">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select O.intStyleId,O.strOrderNo from orders O where O.intStatus = 12 ";
	
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
                  <td width="58">SC No</td>
                  <td width="150"><select name="cboSR" class="txtbox" style="width:130px" id="cboSR" onchange="GetStyleName(this);resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intSRNO,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 12 order by intSRNO desc;";
	
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
                  <td><input title="Type 'Style No' here to search" name="txtStyleNo" type="text" class="txtbox" id="txtStyleNo" value="<?php echo $_POST["txtStyleNo"]; ?>"  style="width:148px;" /></td>
                  <td >Like</td>
                  <td><input title="Type 'Order No' here to search" name="txtOrderNo" type="text" class="txtbox" id="txtOrderNo" value="<?php echo $_POST["txtOrderNo"]; ?>"  style="width:148px;" /></td>
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
                <td width="19%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">Order No</td>
                <td width="24%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
               <!-- <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Company</td>-->
                <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Reason</td>
                <td width="19%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer</td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Rejected Date</td>
                <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">View</td>
                <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Pre-Mode</td>
              </tr>
              <?php
			
			
		
			
			$sql = "SELECT orders.strOrderNo,intStyleId,strDescription, companies.strComCode,  buyers.strName, intQty, date(dtmAppDate) as dtmAppDate, strAppRemarks FROM orders INNER JOIN companies ON orders.intCompanyID = companies.intCompanyID INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID WHERE orders.intStatus = 12 ";
			
			
			if ($factory != "")
			{
				$sql.= " and orders.intCompanyID = $factory";
			}
			if ($buyer != "" )
			{
				$sql.= " and orders.intBuyerID = $buyer";
			}
			if ($orderId != "" )
			{
				$sql.= " and orders.intStyleId ='$orderId'";
			}
			if ($styleID != "" )
			{
				$sql.= " and orders.strStyle ='$styleID'";
			}
			if ($styleNo != "" )
			{
				$sql.= " and orders.strStyle like '%$styleNo%'";
			}
			if ($orderNo != "" )
			{
				$sql.= " and orders.strOrderNo like '%$orderNo%'";
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
                <td height="21" class="normalfnt"><?php echo  $row["strOrderNo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strDescription"]; ?></td>
              <!--  <td class="normalfnt"><?php //echo  $row["strComCode"]; ?></td>-->
                <td class="normalfnt"><?php echo  $row["strAppRemarks"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strName"]; ?></td>
                <td class="normalfnt"><?php echo  $row["dtmAppDate"]; ?></td>
                <td class="normalfnt"><a href="<?php echo $reportname; ?>?styleID=<?php echo  urlencode($row["intStyleId"]); ?>" target="_blank"><img src="images/view2.png" border="0" class="noborderforlink" /></a></td>
                <td class="normalfnt"><div align=\"center\"><img id="<?php echo  $row["intStyleId"]; ?>" class="mouseover" src="images/premode.png" alt="Pre-Mode" width="91" height="19" onClick="SendtoPreOrderMode(this.id);" /></div></td>
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
