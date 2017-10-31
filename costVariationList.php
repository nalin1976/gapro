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
	$styleName = $_POST["txtStyle"];
	
$xml = simplexml_load_file('config.xml');
$reportname = $xml->Reports->CostVariationReport;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Cost Variation Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<script type="text/javascript" src="javascript/bom.js"></script>
<script type="text/javascript">

var reportName = '<?php echo $reportname; ?>';


function resetCompanyBuyer()
{
	document.getElementById("cboFactory").value = "";
	document.getElementById("cboCustomer").value = "";
}

function submitForm()
{
	document.frmcomplete.submit();
}

function displayReport(obj)
{
	var styleID = obj.parentNode.parentNode.parentNode.cells[0].id;
	var revisionNo = obj.parentNode.parentNode.parentNode.cells[7].childNodes[1].value;
	obj.parentNode.href =  reportName + "?styleID=" + styleID + "&revision=" + revisionNo;
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
	var status = "11";
	var booUser	= false;
	var url = "Reports/orderreport/orderreportxml.php?RequestType=GetStyleWiseOrderNoInReports&styleNo=" +obj+ '&status='+status+ '&booUser=' +booUser;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboOrderNo').innerHTML  = htmlobj.responseText;
}
function GetStyleWiseScNo(obj)
{	
	var status = "11";
	var booUser	= false;
	var url = "Reports/orderreport/orderreportxml.php?RequestType=GetStyleWiseScNoInReports&styleNo=" +obj+ '&status='+status+ '&booUser=' +booUser;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboSR').innerHTML  = htmlobj.responseText;
}
</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="costVariationList.php">
    <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
  <table width="950" border="0" align="center" class="bcgl1">

    <tr>
      <td><table width="100%" border="0">
        
        <tr>
          <td width="96%" class="mainHeading">Cost Variation Report</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" class="tableBorder">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0">
                <tr>
                  <td width="72" class="normalfnt">Factory</td>
                  <td width="72" ><select name="cboFactory" class="txtbox" id="cboFactory" style="width:170px">
                    <option value="" selected="selected">Select One</option>
                    <?php
					


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
	
	$SQL = "select distinct O.strStyle from orders O where O.intStatus = 11 order by O.strStyle;";
	
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
                  <td width="155"  ><select name="cboOrderNo" class="txtbox" style="width:150px" id="cboOrderNo" onchange="GetScNo(this);resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select O.intStyleId,O.strOrderNo from orders O where O.intStatus = 11 ";
	
	if($styleID!="")
		$SQL .= " and O.strStyle='$styleID' ";
		
	$SQL .= " order by O.strOrderNo";
	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($orderId ==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="70" class="normalfnt">SC No</td>
                  <td width="150" ><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="GetStyleName(this);resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select S.intStyleId,S.intSRNO from specification S inner join orders O on S.intStyleId = O.intStyleId AND O.intStatus = 11 ";
	
	if($styleID!="")
		$SQL .= " and O.strStyle='$styleID' ";
		
	$SQL .= "order by S.intSRNO desc";
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
                    </select>
                  </td>
                  <td class="normalfnt">Style Like</td>
                  <td><input title="Type 'Style No' here to search" name="txtStyleNo" type="text" class="txtbox" id="txtStyleNo" value="<?php echo $_POST["txtStyleNo"]; ?>"  style="width:148px;" /></td>
                  <td class="normalfnt">Order Like</td>
                  <td><input title="Type 'Order No' here to search" name="txtOrderNo" type="text" class="txtbox" id="txtOrderNo" value="<?php echo $_POST["txtOrderNo"]; ?>" style="width:148px;"/></td>
                  <td>&nbsp;</td>
                  <td><div align="right"><img src="images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td><div id="divData" style="width:930px; height:400px; overflow: scroll; border-width:3px; border-style:solid;border-color:#99CCFF;">
            <table width="910" bgcolor="#CCCCFF" border="0" cellpadding="0" cellspacing="1" class="bcgl1" id="tblPreOders" >
              <tr>
                <td width="13%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">Style No</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">SC No </td>
                <td width="25%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Company</td>
                <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer</td>
                <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Approved By </td>
                <td width="16%" bgcolor="#498CC2" class="normaltxtmidb2">Approved Date</td>
                <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Compare With</td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">View</td>
              </tr>
              <?php
			
			
		
			
			$sql = "SELECT orders.strOrderNo,orders.intStyleId,strDescription, companies.strComCode, buyers.strName,intQty,dtmAppDate,intSRNO, useraccounts.Name, (SELECT MAX(intApprovalNo) FROM history_orders WHERE intStyleId = orders.intStyleId) AS maxID  FROM orders INNER JOIN companies ON orders.intCompanyID = companies.intCompanyID INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID INNER JOIN specification ON orders.intStyleId = specification.intStyleId INNER JOIN useraccounts ON orders.intApprovedBy = useraccounts.intUserID  WHERE orders.intStatus =11  " ;
			
			
			if ($factory != "")
			{
				$sql.= " and orders.intCompanyID = $factory";
			}
			if ($buyer != "")
			{
				$sql.= " and orders.intBuyerID = $buyer";
			}
			if ($orderId != "")
			{
				$sql.= " and orders.intStyleId ='$orderId'";
			}
			if ($styleID != "")
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
			$sql.= " order by strStyle ";
			
			
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
                <td height="21" class="normalfnt" id="<?php echo  $row["intStyleId"]; ?>"><?php echo  $row["strOrderNo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["intSRNO"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strDescription"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strComCode"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strName"]; ?></td>
                <td class="normalfnt"><?php echo  $row["Name"]; ?></td>
                <td class="normalfnt"><?php echo  $row["dtmAppDate"]; ?></td>
                <td width="5%" class="normalfnt">
					<select name="cboSR" class="txtbox" style="width:50px" id="cboSR" onchange="getStyleNo();resetCompanyBuyer();">
                                    
                <?php
                 for($loop = 1; $loop <= $row["maxID"] ; $loop ++)
                 {
                 ?>
                 <option value="<?php echo  $loop; ?>" ><?php echo  $loop; ?></option>
                 <?php
                 }
                 ?>
					</select>                 </td>
                <td class="normalfnt"><a href="#" target="_blank"><img src="images/view2.png" border="0" class="mouseover" onClick="displayReport(this);" /></a></td>
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
