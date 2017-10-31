<?php
session_start();
include "authentication.inc";
include "Connector.php";

$reqStyleID = $_POST["txtchangeTo"];
$oldStyle = $_POST["cboStyles"];
$Message = "";

if (isset($reqStyleID) && $reqStyleID != "" && $reqStyleID != null)
{
	//Check Availability
	$sql = "select intStyleId from orders where strStyle = '$reqStyleID'";
	if (!$db->CheckRecordAvailability($sql))
	{
	
		// Update Orders
		$sql = "UPDATE orders SET strStyle = '$reqStyleID' WHERE intStyleId = '$oldStyle';";
		$db->ExecuteQuery($sql);
		
	/*	// Update Order Details
		$sql = "UPDATE orderdetails SET intStyleId = '$reqStyleID' WHERE intStyleId = '$oldStyle';";
		$db->ExecuteQuery($sql);
		
		// Update Delivery Schedules
		$sql = "UPDATE deliveryschedule SET intStyleId = '$reqStyleID' WHERE intStyleId = '$oldStyle';";
		$db->ExecuteQuery($sql);
		
		// Update Style Buyer POs 
		$sql = "UPDATE style_buyerponos SET intStyleId = '$reqStyleID' WHERE intStyleId = '$oldStyle';";
		$db->ExecuteQuery($sql);
		$Message = "Style changed successfully.";*/
	}
	else
	{
		$Message = "The Style $reqStyleID already exists.";
	}
}
else
{
	if($oldStyle == '0')
	$Message = "Please select style you wish to change";
	
	
	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Change Style</title>
<script src="javascript/script.js" type="text/javascript"></script>

<script language="javascript" type="text/javascript">
function checkStyle()
{
	if(document.getElementById('cboStyles').value == '')
	alert('pass');
	}
</script>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form name="frmchangeStyle" method="POST" action="changeStyle.php">
  <tr>
    <td width="752"><?php include 'Header.php'; ?></td>
  </tr>
<table width="965" border="0" align="center">

  <tr>
    <td><table width="100%" border="0"  cellpadding="0" cellspacing="1" class="bcgl1">
      <tr>
        <td colspan="2" >&nbsp;</td>
      </tr>
      <tr>
        <td height="57" align="center">
			<div>
			<table width="52%" >

	<tr>
          <td colspan="5" bgcolor="#316895"><div align="center" class="TitleN2white">Change Style</div></td>
        </tr>			
			<tr>
			<td width="19%" class="txtbox">Style Number</td>		
			<td width="32%" class="txtbox"><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="GetScNo(this);">
                    <option value="0" selected="selected">Select One</option>
                    <?php
	$usercode = $_SESSION["UserID"];
	$SQL = "SELECT intStyleId,strStyle FROM orders WHERE intUserID = '$usercode' order by strStyle;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($reqStyleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
                  </select></td>	
			<td width="4%" class="txtbox">&nbsp;</td>
			<td width="10%" class="txtbox">Sc No</td>
			<td width="35%" class="txtbox"><select name="cboScNo" class="txtbox" style="width:150px" id="cboScNo" onchange="GetStyleName(this);">
              <option value="0" selected="selected">Select One</option>
              <?php
	$usercode = $_SESSION["UserID"];
	$SQL = "SELECT O.intStyleId,S.intSRNO FROM orders O inner join specification S on O.intStyleId=S.intStyleId WHERE O.intUserID = '1' order by S.intStyleId desc;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($reqStyleID==  $row["intStyleId"])
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
			<TD class="txtbox">Change To</td>
			<TD colspan="4" class="txtbox"><input type="text" class="txtbox" style="width:300px;" id="txtchangeTo" name="txtchangeTo"></td>
			</tr>
			
			<tr>
			<td></td>
			<td colspan="4" class="txtbox"><input  style="font-family: Verdana;font-size: 11px;color: #20407B;" type="submit" value="Change Style" ></td>			
			</tr>
			<?php if($Message != ""){ ?>
			<tr>
			<TD ></td>
			<TD colspan="4" class="error1"><?php echo $Message; ?></td>
			</tr
			><?php  } ?>
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
    <td><div align="right"><span class="copyright">&nbsp;</span></div></td>
  </tr>
</table>
</form>
</body>
<script type="text/javascript">
function GetScNo(obj)
{
	document.getElementById('cboScNo').value = obj.value;
}
function GetStyleName(obj)
{
	document.getElementById('cboStyles').value = obj.value;
}
</script>
</html>
