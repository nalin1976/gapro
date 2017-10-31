<?php
session_start();
$backwardseperator = '../../../';
include "../../../authentication.inc";
include "../../../Connector.php";

$booFirst 	= false;
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
	
if(!isset($_POST["cboOrderNo"])&&$_POST["cboOrderNo"]==""){
		$booFirst = true;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Invoice Cost Variation Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    table.fixHeader {
        border: thin #CCCCCC;
        border-width: 2px 2px 2px 2px;
        width: 850px;
    }
    tbody.ctbody {
        height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
    }

</style>
<script type="text/javascript" src="../../../javascript/script.js"></script>
<script type="text/javascript">
function resetCompanyBuyer()
{
	document.getElementById("cboFactory").value = "";
	document.getElementById("cboCustomer").value = "";
}

function submitForm()
{
	document.frmcomplete.submit();
}

function DisplayReport(obj)
{
	var styleID = obj.parentNode.parentNode.cells[1].id;
	var revisionNo = obj.parentNode.parentNode.cells[6].childNodes[1].value;
	newwindow=window.open('rptVariation.php?OrderId='+styleID+ '&RevisionNo='+revisionNo,'rptVariation.php');
		if (window.focus) {newwindow.focus()}
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
	var url = "../../orderreport/orderreportxml.php?RequestType=URLStyleWiseOrderNoInReports_Variation&styleNo=" +obj;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboOrderNo').innerHTML  = htmlobj.responseText;
}
function GetStyleWiseScNo(obj)
{	
	var url = "../../orderreport/orderreportxml.php?RequestType=URLStyleWiseScNoInReports_Variation&styleNo=" +obj;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboSR').innerHTML  = htmlobj.responseText;
}
</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="variationList.php">
    <tr>
      <td><?php include $backwardseperator.'Header.php'; ?></td>
    </tr>
  <table width="950" border="0" align="center" class="tableBorder" cellpadding="0" cellspacing="1">
    <tr>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="1">
        
        <tr>
          <td width="96%" class="mainHeading">Invoice Cost Variation Report</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" class="tableBorder" cellpadding="0" cellspacing="1">
            <tr>
              <td width="50%" height="21"><table width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr>
                  <td width="72" class="normalfnt">Factory</td>
                  <td width="72" ><select name="cboFactory" class="txtbox" id="cboFactory" style="width:170px">
                    <option value="" selected="selected">Select One</option>
                    <?php
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
	
	$SQL = "select distinct O.strStyle 
			from orders O 
			inner join history_invoicecostingheader HICH on HICH.intStyleId=O.intStyleId
			where O.intStatus = 11 order by O.strStyle;";
	
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
	
	$SQL = "select O.intStyleId,O.strOrderNo 
			from orders O 
			inner join history_invoicecostingheader HICH on HICH.intStyleId=O.intStyleId ";
	
	if($styleID!="")
		$SQL .= " and O.strStyle='$styleID' ";
		
		$SQL .= " order by O.strOrderNo";	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($orderId ==  $row["intStyleId"])
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="70" class="normalfnt">SC No</td>
                  <td width="150" ><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="GetStyleName(this);resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select S.intStyleId,S.intSRNO 
			from specification S 
			inner join orders O on S.intStyleId = O.intStyleId
			inner join history_invoicecostingheader HICH on HICH.intStyleId=O.intStyleId
			where O.intStatus = 11 ";
	
	if($styleID!="")
		$SQL .= " and O.strStyle='$styleID' ";
		
	$SQL .= "order by S.intSRNO desc";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($srNo==  $row["intStyleId"])
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
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
			echo "<option selected=\"selected\" value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		else
			echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
	}
	?>
                    </select>
                  </td>
                  <td class="normalfnt">Style Like</td>
                  <td><input title="Type 'Style No' here to search" name="txtStyleNo" type="text" class="txtbox" id="txtStyleNo" value="<?php echo $_POST["txtStyleNo"]; ?>"  style="width:148px;" /></td>
                  <td class="normalfnt">Order Like</td>
                  <td><input title="Type 'Order No' here to search" name="txtOrderNo" type="text" class="txtbox" id="txtOrderNo" value="<?php echo $_POST["txtOrderNo"]; ?>" style="width:148px;"/></td>
                  <td>&nbsp;</td>
                  <td><div align="right"><img src="../../../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td>
            <table width="100%" bgcolor="#CCCCFF" border="0" cellpadding="1" cellspacing="1" id="tblPreOders" >
			<thead>
              <tr class="mainHeading4">
                <th width="18%" >Style No </th>
                <th width="20%" height="25" >Order No</th>
                <th width="6%" >SC No </th>
                <th width="28%" >Description</th>
                <th width="7%" >Company</th>
                <th width="5%" >Buyer</th>
                <th width="7%" >Rivisions</th>
                <th width="7%" >View</th>
                <th width="2%" >&nbsp;</th>
              </tr>
			  </thead>
			  <tbody class="ctbody">
<?php
	$sql = "select O.intStyleId,O.strStyle,O.strOrderNo,S.intSRNO,B.buyerCode,O.strDescription,C.strComCode,ICH.intApprovalNo
from history_invoicecostingheader ICH
inner join orders O on O.intStyleId=ICH.intStyleId
inner join specification S on S.intStyleId=ICH.intStyleId
inner join buyers B on B.intBuyerID=O.intBuyerID
inner join companies C  on C.intCompanyID=O.intCompanyID " ;
if ($factory != "")
	$sql.= " and O.intCompanyID = $factory";
if ($buyer != "")
	$sql.= " and O.intBuyerID = $buyer";
if ($orderId != "")
	$sql.= " and O.intStyleId ='$orderId'";
if ($styleID != "")
	$sql.= " and O.strStyle ='$styleID'";
if ($styleNo != "" )
	$sql.= " and O.strStyle like '%$styleNo%'";
if ($orderNo != "" )
	$sql.= " and O.strOrderNo like '%$orderNo%'";
if($booFirst)
	$sql.= " order by date(ICH.dtmCreateDate) desc limit 0,50 ";
else
	$sql.= " order by O.strOrderNo ";
$result = $db->RunQuery($sql);	
while($row = mysql_fetch_array($result))
{
?>
		  <tr bgcolor="#FFFFFF">
			<td class="normalfntSM" ><?php echo  $row["strStyle"]; ?></td>
			<td height="20" class="normalfntSM" id="<?php echo  $row["intStyleId"]; ?>"><?php echo  $row["strOrderNo"]; ?></td>
			<td class="normalfnt"><?php echo  $row["intSRNO"]; ?></td>
			<td class="normalfntSM"><?php echo  $row["strDescription"]; ?></td>
			<td class="normalfnt"><?php echo  $row["strComCode"]; ?></td>
			<td class="normalfnt"><?php echo  $row["buyerCode"]; ?></td>
			<td width="7%" class="normalfnt">
			<select name="cboApprova" class="cboApprova" style="width:64px" id="cboSR" >                                    
			<?php
			 for($loop = 1; $loop <= $row["intApprovalNo"] ; $loop ++)
			 {
			 ?>
			 	<option value="<?php echo  $loop; ?>" ><?php echo  $loop; ?></option>
			 <?php
			 }
			 ?>
				</select></td>
			<td class="normalfntMid"><img src="../../../images/view2.png" border="0" class="mouseover" onClick="DisplayReport(this);" /></td>
		    <td class="normalfntMid">&nbsp;&nbsp;</td>
		  </tr>
<?php
}
?>
		<tr class="bcgcolor-tblrowWhite">
			<td colspan="9" class="normalfntSM">&nbsp;</td>
			</tr>
		</tbody>
            </table>
          </td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>
<script type="text/javascript">

var prev_row_no=-99;

var pub_bg_color_click='#FFFFFF';

$(document).ready(function()
{
     $('#tblPreOders tbody tr').click(function()
	 {
        if($(this).attr('bgColor')!='#82FF82')
    	{
			var color=$(this).attr('bgColor')
			$(this).attr('bgColor','#82FF82')
			
			if(prev_row_no!=-99)
			{
				$('#tblPreOders tbody')[0].rows[prev_row_no].bgColor = pub_bg_color_click;           
			}
			
			if(prev_row_no==$(this).index())
			{
				prev_row_no=-99
			}			
			else		
				prev_row_no=$(this).index()                                   
			
			pub_bg_color_click=color                  
		}                                             
	})
});

</script>