<?php
	session_start();
	include "../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../../";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ePlan Web :: Material Transfer From Old To New</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js"></script>

</head>

<body>
<form id="frmbanks" name="form1" method="post" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%"><table width="100%" border="0">
          <tr>
            <td height="35" bgcolor="#498CC2" class="TitleN2white">Material Transfer From Old To New - Reports</td>
          </tr>
          <tr>
            <td height="50"><table width="575" border="0">
			<tr>
	  	      <td colspan="6">&nbsp;</td> 
              <tr>
                <td width="90" class="normalfnt2bld"><span class="normalfnt">New Style ID</span></td>
                <td width="240"><span class="normalfnt">
                  <select name="cboNewStyleID" class="txtbox" id="cboNewStyleID" style="width:140px" onchange="SetNewScNo();">
                    <?php
		$SQL ="select distinct strNewStyleID,intNewSCNO from itemtransfertoweb where dblQty >0 ".
			  "Order By strNewStyleID;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboNewStyleID"]==$row["intNewSCNO"])
					echo "<option selected=\"selected\"value=\"". $row["intNewSCNO"] ."\">" . $row["strNewStyleID"] ."</option>" ;
				else
				echo "<option value=\"".$row["intNewSCNO"]."\">".$row["strNewStyleID"]."</option>";
			}
	
 	?>
                  </select>
                </span></td>
                <td width="79" class="normalfnt2bld"><span class="normalfnt">Old Style ID</span></td>
                <td width="148"><span class="normalfnt">
                  <select name="cboOldStyleId" class="txtbox" id="cboOldStyleId" style="width:140px" onchange="SetOldScNo();">
                    <?php
		$SQL ="select distinct strOldStyleID,intOldSCNO from itemtransfertoweb where dblQty >0 ".
		      "Order By strOldStyleID;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboOldStyleId"]==$row["intOldSCNO"])
					echo "<option selected=\"selected\"value=\"". $row["intOldSCNO"] ."\">" . $row["strOldStyleID"] ."</option>" ;
				else
				echo "<option value=\"".$row["intOldSCNO"]."\">".$row["strOldStyleID"]."</option>";
			}
	
 	?>
                  </select>
                </span></td>
              </tr>
              <tr>
                <td class="normalfnt2bld"><span class="normalfnt">New ScNo</span></td>
                <td><span class="normalfnt">
                  <select name="cboNewScNo" class="txtbox" id="cboNewScNo" style="width:140px" onchange="SetNewStyleId();">
                    <?php
 
		$SQL ="select distinct strNewStyleID,intNewSCNO from itemtransfertoweb where dblQty >0 ".
			  "Order By intNewSCNO;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboNewScNo"]==$row["strNewStyleID"])
					echo "<option selected=\"selected\"value=\"". $row["strNewStyleID"] ."\">" . $row["intNewSCNO"] ."</option>" ;
				else
				echo "<option value=\"".$row["strNewStyleID"]."\">".$row["intNewSCNO"]."</option>";
			}
	
 	?>
                  </select>
                </span></td>
                <td class="normalfnt2bld"><span class="normalfnt">Old ScNo</span></td>
                <td><span class="normalfnt">
                  <select name="cboOldScNo" class="txtbox" id="cboOldScNo" style="width:140px" onchange="SetOldStyleId();">
                    <?php
 
	$SQL ="select distinct strOldStyleID,intOldSCNO from itemtransfertoweb where dblQty >0 ".
		      "Order By intOldSCNO;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboOldScNo"]==$row["strOldStyleID"])
					echo "<option selected=\"selected\"value=\"". $row["strOldStyleID"] ."\">" . $row["intOldSCNO"] ."</option>" ;
				else
				echo "<option value=\"".$row["strOldStyleID"]."\">".$row["intOldSCNO"]."</option>";
			}
	
 	?>
                  </select>
                </span></td>
              </tr>
            </table>            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor="#d6e7f5"><table width="100%" border="0">
                    <tr>
                      <td width="22%">&nbsp;</td>
                      <td width="20%"><img src="../../images/refreshico.png" alt="New" name="New" width="96" height="24" onclick="ClearForm();"/></td>
                      <td width="22%"><img src="../../images/report.png" alt="report" width="108" height="24" onclick="ViewReport();" /></td>
                      <td width="21%"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                      <td width="15%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<script language="javascript">
var xmlHttp 			= [];
function SetNewScNo(){

	var styleID =document.getElementById("cboNewStyleID").options[document.getElementById("cboNewStyleID").selectedIndex].text;
	document.getElementById("cboNewScNo").value =styleID;	
}
function SetNewStyleId(){
	var scno =document.getElementById("cboNewScNo").options[document.getElementById("cboNewScNo").selectedIndex].text;
	document.getElementById("cboNewStyleID").value =scno;	
}

function SetOldScNo(){

	var styleID =document.getElementById("cboOldStyleId").options[document.getElementById("cboOldStyleId").selectedIndex].text;
	document.getElementById("cboOldScNo").value =styleID;	
}
function SetOldStyleId(){
	var scno =document.getElementById("cboOldScNo").options[document.getElementById("cboOldScNo").selectedIndex].text;
	document.getElementById("cboOldStyleId").value =scno;	
}

function ViewReport()
{
	var newStyleID =document.getElementById("cboNewStyleID").options[document.getElementById("cboNewStyleID").selectedIndex].text;
	var oldStyleID =document.getElementById("cboOldStyleId").options[document.getElementById("cboOldStyleId").selectedIndex].text;	
	
	//if(IssueNo==""){alert("Sorry!\nNo saved details appear to view.");return;}
			
		newwindow=window.open('report.php?newStyleID='+newStyleID+ '&oldStyleID=' +oldStyleID,'name');
			if (window.focus) {newwindow.focus()}	
}
</script>

</body>
</html>
