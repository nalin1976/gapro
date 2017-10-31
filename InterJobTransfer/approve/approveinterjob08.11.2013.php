<?php

session_start();
include "../../Connector.php";	
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";


$fromStyle		= $_POST["cboFromStyle"];
$fromSc			= $_POST["cboFromSc"];
$toStyle		= $_POST["cboToStyle"];
$toSc			= $_POST["cboToSc"];
$merchant		= $_POST["cboMerchant"];
$jobNo			= $_POST["txtJobNo"];
$category		= $_POST["cboCategory"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ePlan Web - Inter Job Transfer Authorization</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<style type="text/css">
<!--
.style5 {color: #993333}

.bcgcolor-Approved{background-color: #FFFFCC;}
.bcgcolor-Authorised{background-color: #EAEAFF;}
.bcgcolor-Confirmed{background-color: #E1FFC4;}
.bcgcolor-Canceled{background-color: #FFD2D2;}
-->
</style>
</head>

<body>
<form name="frmInterjobApprove" id="frmInterjobApprove" action="approveinterjob.php" method="post">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td width="8%"  height="25" class="normalfnt">From Style </td>
            <td width="16%" class="normalfnt"><select name="cboFromStyle" class="txtbox" id="cboFromStyle" style="width:150px" onchange="GetFromScNo();">
              <option value="">Select One</option>
              <?php
	
	$sql = "select distinct SP.intSRNO,SP.strStyleID from itemtransfer IT
Inner Join specification SP On IT.strStyleFrom=SP.strStyleID";

	$result = $db->RunQuery($sql);	
	while($row = mysql_fetch_array($result))
	{
		if($fromStyle == $row["intSRNO"])
			echo "<option selected=\"selected\"value=\"". $row["intSRNO"] ."\">" . $row["strStyleID"] ."</option>" ;
		else
			echo "<option value=\"". $row["intSRNO"] ."\">" . $row["strStyleID"] ."</option>" ;
	}
	
	?>
            </select></td>
            <td width="1%" class="normalfnt">&nbsp;</td>
            <td width="9%" class="normalfnt">From ScNo</td>
            <td width="12%" class="normalfnt"><select name="cboFromSc" class="txtbox" id="cboFromSc" style="width:100px" onchange="GetFromStyle();">
               <option value="">Select One</option>
<?php

$sql = "select distinct SP.intSRNO,SP.strStyleID from itemtransfer IT
Inner Join specification SP On IT.strStyleFrom=SP.strStyleID";

$result = $db->RunQuery($sql);	
while($row = mysql_fetch_array($result))
{
	if($fromSc	 == $row["strStyleID"])
		echo "<option selected=\"selected\"value=\"". $row["strStyleID"] ."\">" . $row["intSRNO"] ."</option>" ;
	else
		echo "<option value=\"". $row["strStyleID"] ."\">" . $row["intSRNO"] ."</option>" ;
}

?>
            </select></td>
            <td width="9%" class="normalfnt">Merchandiser</td>
            <td width="17%" class="normalfnt"><select name="cboMerchant" class="txtbox" id="cboMerchant" style="width:150px" onchange="GetFromScNo();">
              <option value="">Select One</option>
              <?php
	
	$sql = "select distinct U.intUserID,U.Name from orders O
Inner Join useraccounts U On U.intUserID=O.intCoordinator";

	$result = $db->RunQuery($sql);	
	while($row = mysql_fetch_array($result))
	{
		if($merchant	 == $row["intUserID"])
			echo "<option selected=\"selected\"value=\"". $row["intUserID"] ."\">" . $row["Name"] ."</option>" ;
		else
			echo "<option value=\"". $row["intUserID"] ."\">" . $row["Name"] ."</option>" ;
	}
	
	?>
            </select></td>
            <td colspan="2" class="normalfnt" ><select name="cboCategory" class="txtbox" id="cboCategory" style="width:150px" onchange="GetFromScNo();">           			
			 <option value="">All</option>
			  <option value="0">Saved</option>
			  <option value="1">Approved</option>
			  <option value="2">Authorised</option>
			  <option value="3">Confirmed</option>
			  <option value="10">Canceld</option>
			  	<?php 
			  	if($category=="")
			  		echo "<option selected=\"selected\"value=\"". $category ."\">" . All ."</option>" ;
				if($category=="0")
			  		echo "<option selected=\"selected\"value=\"". $category ."\">" . Saved ."</option>" ;
				if($category=="1")
			  		echo "<option selected=\"selected\"value=\"". $category ."\">" . Approved ."</option>" ;
				if($category=="2")
			  		echo "<option selected=\"selected\"value=\"". $category ."\">" . Authorised ."</option>" ;
				if($category=="3")
			  		echo "<option selected=\"selected\"value=\"". $category ."\">" . Confirmed ."</option>" ;
				if($category=="10")
			  		echo "<option selected=\"selected\"value=\"". $category ."\">" . Canceld ."</option>" ;
				?>
			</select></td>            
            <td width="9%" class="normalfntleft" ><img src="../../images/search.png" alt="search" width="80" height="24" onclick="SubmitPage();"/></td>
          </tr>
          <tr>
            <td  height="25" class="normalfnt">To Style</td>
            <td class="normalfnt"><select name="cboToStyle" class="txtbox" id="cboToStyle" style="width:150px" onchange="GetToScNo();">
              <option value="">Select One</option>
              <?php

$sql = "select distinct SP.intSRNO,SP.strStyleID from itemtransfer IT
Inner Join specification SP On IT.strStyleTo=SP.strStyleID";

$result = $db->RunQuery($sql);	
while($row = mysql_fetch_array($result))
{
	if($toStyle == $row["intSRNO"])
		echo "<option selected=\"selected\"value=\"". $row["intSRNO"] ."\">" . $row["strStyleID"] ."</option>" ;
	else
		echo "<option value=\"". $row["intSRNO"] ."\">" . $row["strStyleID"] ."</option>" ;
}

?>
            </select></td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">To ScNo</td>
            <td class="normalfnt"><span class="normalfntleft">
              <select name="cboToSc" class="txtbox" id="cboToSc" style="width:100px" onchange="GetToStyle();">
                <option value="">Select One</option>
                <?php

$sql = "select distinct SP.intSRNO,SP.strStyleID from itemtransfer IT
Inner Join specification SP On IT.strStyleTo=SP.strStyleID";

$result = $db->RunQuery($sql);	
while($row = mysql_fetch_array($result))
{
	if($toSc == $row["strStyleID"])
		echo "<option selected=\"selected\"value=\"". $row["strStyleID"] ."\">" . $row["intSRNO"] ."</option>" ;
	else
		echo "<option value=\"". $row["strStyleID"] ."\">" . $row["intSRNO"] ."</option>" ;
}

?>
              </select>
            </span></td>
            <td class="normalfnt">Job No</td>
            <td class="normalfnt"><span class="normalfntleft">
              <input name="txtJobNo" id="txtJobNo" type="text" class="txtbox" size="15" value="<?php echo ($jobNo =="" ? "":$jobNo) ?>"/>
            </span></td>
            <td width="4%" class="normalfnt" >&nbsp;</td>
            <td width="15%" class="normalfntleft" >&nbsp;</td>
            <td class="normalfntleft" >&nbsp;</td>
          </tr>
        </table></td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="bcgl1">
      <tr>
        <td colspan="3"><div id="divcons" style="overflow:scroll; height:425px; width:945px;">
            <table width="100%" bgcolor="#CCCCFF" cellpadding="0" cellspacing="1" id="tblschedule">
              <tr >
                <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2" align="left">No</td>
                <td width="10%" height="33" bgcolor="#498CC2" class="normaltxtmidb2" align="left">InterJob No</td>
                <td width="19%" bgcolor="#498CC2" class="normaltxtmidb2" align="left">From Style </td>
                <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2" align="left">From ScNo</td>
                <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2" align="left">To Style </td>
				<td width="9%" bgcolor="#498CC2" class="normaltxtmidb2" align="left">To ScNo </td>
				<td width="16%" bgcolor="#498CC2" class="normaltxtmidb2" align="left">Approve/Authorised</td>
				<td width="13%" bgcolor="#498CC2" class="normaltxtmidb2" align="left">View</td>
				
              </tr>
<?php
$sql = "select concat(intTransferYear,'/',intTransferId)AS jobNo,
strStyleFrom,
(select intSRNO from specification where specification.strStyleID=IT.strStyleFrom)AS fromScNo,
strStyleTo,
(select intSRNO from specification where specification.strStyleID=IT.strStyleTo)AS toScNo,
IT.intStatus
from itemtransfer IT
Inner Join orders O On O.strStyleID = IT.strStyleTo where intTransferId <> 0 ";

if($fromStyle!="")
	$sql .= "AND IT.strStyleFrom='$fromSc' ";
if($toStyle!="")
	$sql .= "AND IT.strStyleTo='$toSc' ";
if($jobNo!="")
	$sql .= "AND IT.intTransferId='$jobNo' ";
if($merchant!="")
	$sql .= "AND O.intCoordinator='$merchant' ";
if($category!="")
	$sql .= "AND IT.intStatus='$category' ";
$result = $db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
$status	= $row["intStatus"];
if($status==0)
	$class	= "bcgcolor-tblrowWhite";
elseif($status==1)
	$class	= "bcgcolor-Approved";
elseif($status==2)
	$class	= "bcgcolor-Authorised";
elseif($status==3)
	$class	= "bcgcolor-Confirmed";
elseif($status==10)
	$class	= "bcgcolor-Canceled";
	
?>
              <tr class="<?php echo $class;?>">
                <td height="15" class="normalfntMidSML" align="left"><?php echo ++$loop;?></td>
                <td class="normalfntMid" ><?php echo $row["jobNo"];?></td>
                <td class="normalfntMid" ><?php echo $row["strStyleFrom"];?></td>
                <td class="normalfntMid" ><?php echo $row["fromScNo"];?></td>
                <td class="normalfntMid" ><?php echo $row["strStyleTo"];?></td>
                <td class="normalfntMid" ><?php echo $row["toScNo"];?></td>               
				<?php if($status==0 && $canApproveInterjobTransfer){?>
                	<td class="normalfntMidSML" ><a href="#" onclick="Approved(this);"><?php echo "Click here to approve";?></a></td>
				<?php }elseif($status==1 && $canAuthorizeInterjobTransfer){?>
                	<td width="2%" class="normalfntMidSML" ><a href="#" onclick="Authorise(this);"><?php echo "Click here to authorized";?></a></td>
				<?php }else{ ?>
					<td width="1%" class="normalfntMidSML" ><a href="#" >&nbsp;</a></td>
				<?php } ?>
				 <td class="normalfntMid" ><img src="../../images/view.png" onclick="ViewReport(this);"/></td>
				
              </tr>
<?php
}
?>		  
            </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
		<td>
			<table width="100%">
				<tr >
				 	<td height="10" width="10px" style="background:#FFFFFF;border: 1px solid #333333;">&nbsp;</td>
					<td width="5px"></td>
					<td width="60px" class="normalfnt">Saved</td>
					<td width="20px"></td>
					<td width="10px" style="background:#FFFFCC;border: 1px solid #333333;">&nbsp;</td>
					<td width="5px"></td>
					<td width="60px" class="normalfnt">Approved</td>
					<td width="20px"></td>
					<td width="10px" style="background:#EAEAFF;border: 1px solid #333333;">&nbsp;</td>
					<td width="5px"></td>
					<td width="60px" class="normalfnt">Authorised</td>
					<td width="20px"></td>
					<td width="10px" style="background:#E1FFC4;border: 1px solid #333333;">&nbsp;</td>
					<td width="5px"></td>
					<td width="60px" class="normalfnt">Confirmed</td>
					<td width="20px"></td>
					<td width="10px" style="background:#FFD2D2;border: 1px solid #333333;">&nbsp;</td>
					<td width="5px"></td>
					<td width="60px" class="normalfnt">Canceld</td>
					<td width="20px"></td>
				</tr>	
			</table>	
		</td>  
  </tr>
  <tr>
    <td bgcolor="#D6E7F5"><table width="100%" border="0">
	
      <tr>
        <td width="21%" id="tdStatus" class="normalfntMid" style="color:#FF0000"></td>
        <td width="9%">&nbsp;</td>
        <td width="19%">&nbsp;</td>
        <td width="12%">&nbsp;</td>
        <td width="23%">&nbsp;</td>
        <td width="11%">&nbsp;</td>
        <td width="5%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<script type="text/javascript">
function createXMLHttpRequest(){
	if (window.ActiveXObject) 
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp = new XMLHttpRequest();
	}
}

function ViewReport(obj)
{
	var rw	= obj.parentNode.parentNode;
	
	var jobNo		= rw.cells[1].childNodes[0].nodeValue;	
	var array = jobNo.split('/');

	if(jobNo==""){alert("Sorry!\nNo saved details appear to view.");return;}
	if(jobNo!="0"){			
		newwindow=window.open('approvalnote.php?InterJobYear='+array[0]+'&InterJobNo='+array[1],'name');
		if (window.focus) {newwindow.focus()}

	}
}
function GetFromScNo(){
	var fromStyle =document.getElementById("cboFromStyle").options[document.getElementById("cboFromStyle").selectedIndex].text;
	document.getElementById("cboFromSc").value =fromStyle;
}
function GetFromStyle(){
	var fromSc =document.getElementById("cboFromSc").options[document.getElementById("cboFromSc").selectedIndex].text;
	document.getElementById("cboFromStyle").value =fromSc;
}
function GetToScNo(){
	var toStyle =document.getElementById("cboToStyle").options[document.getElementById("cboToStyle").selectedIndex].text;
	document.getElementById("cboToSc").value =toStyle;
}
function GetToStyle(){
	var toSc =document.getElementById("cboToSc").options[document.getElementById("cboToSc").selectedIndex].text;
	document.getElementById("cboToStyle").value =toSc;
}

function Approved(obj)
{	
	var rw	= obj.parentNode.parentNode;
	var No	= rw.cells[1].childNodes[0].nodeValue;
	
	if(No==""){
		alert("Error : ..\n           No Job No to Approved.");
		return;
	}
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = ApprovedRequest;
	xmlHttp.index	= No;
	xmlHttp.open("GET",'../materialsTransferXml.php?RequestType=Approved&No=' +No ,true);
	xmlHttp.send(null);
}
	function ApprovedRequest()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200)
			{
				var Approved = xmlHttp.responseText;
				
				if (Approved!="")
				{
					alert ("Inter Job Transfer No : " + xmlHttp.index +  " Approved");						
				}
			}
		}
	}
function Authorise(obj)
{	
	var rw	= obj.parentNode.parentNode;
	var No	= rw.cells[1].childNodes[0].nodeValue;
	
	if(No==""){
		alert("Error : ..\n           No Job No to Authorise.");
		return;
	}
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = AuthoriseRequest;
	xmlHttp.index	= No;
	xmlHttp.open("GET",'../materialsTransferXml.php?RequestType=Authorise&No=' +No ,true);
	xmlHttp.send(null);
}
	function AuthoriseRequest()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200)
			{
				var Approved = xmlHttp.responseText;
				
				if (Approved!="")
				{
					alert ("Inter Job Transfer No : " + xmlHttp.index +  " Authorise");					
				}
			}
		}
	}	

	
function SubmitPage()
{
	document.getElementById('frmInterjobApprove').submit();
}
</script>

</body>
</html>
