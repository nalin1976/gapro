<?php
session_start();
include "../authentication.inc";
include "../Connector.php";
$backwardseperator	= "../";
$status = '13,14';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Change Order</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" >
var UserID = <?php
 echo $_SESSION["UserID"]; 
 ?>;

</script>
<script src="../javascript/script.js" type="text/javascript"></script>
</head>

<body>
<tr>
  <td><?php include '../Header.php'; ?></td>
</tr>
<form id="form1" name="form1" method="post" action="">
  <table width="650" border="0" align="center" >
    
    <tr>
      <td><table width="100%" border="0">
        
        <tr>
          <td width="100%"><table width="100%" border="0">
            <tr>
              <td width="62%"><table width="100%" border="0" class="tableBorder">
                  <tr>
                    <td height="25" bgcolor="#498CC2" class="mainHeading">Change Order</td>
                  </tr>
                  <tr>
                    <td height="61"><table width="100%" border="0" cellpadding="0" cellspacing="2">
                        <tr>
                          <td class="normalfnt">&nbsp;</td>
                          <td class="normalfnt">Style No </td>
                          <td colspan="3"><select name="cboOrderNo" class="txtbox" id="cboOrderNo" style="width:150px"  onchange="GetOrderNo(this.value);GetScNo(this.value)">
                            <option value="" selected="selected">Select One</option>
                            <?php 

			$sql = "select distinct strStyle from orders where intStatus not in ($status) order By strStyle";	
			$result = $db->RunQuery($sql);		
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
			}
		?>
                          </select></td>
                        </tr>
                        <tr>
                          <td width="1%" class="normalfnt">&nbsp;</td>
                          <td width="28%" class="normalfnt">Order No <span class="compulsoryRed">*</span></td>
                          <td width="26%">
                            <select name="cboStyleId" class="txtbox" id="cboStyleId" style="width:150px"  onchange="GetScByOrderNo(this);">
                              <option value="" selected="selected">Select One</option>
                              <?php 

			$sql = "select intStyleId,strOrderNo from orders where intStatus not in ($status) order By strOrderNo";	
			$result = $db->RunQuery($sql);		
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
			}
		?>
                            </select>                          </td>
                          <td width="15%" class="normalfnt">Sc No </td>
                          <td width="30%"><span class="normalfnt">
                            <select name="cboScNo" class="txtbox" id="cboScNo" style="width:100px" onchange="GetOrderNoBySc(this);">
                              <option value="" selected="selected">Select One</option>
                              <?php 

			$sql = "select O.intStyleId,S.intSRNO from orders O inner join specification S on S.intStyleId=O.intStyleId where intStatus not in ($status) order By S.intSRNO desc ";	
			$result = $db->RunQuery($sql);		
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
			}
		?>
                            </select>
                          </span></td>
                        </tr>
                        <tr>
                          <td class="normalfnt">&nbsp;</td>
                          <td class="normalfnt">Sewing Factory <span class="compulsoryRed">*</span></td>
                          <td colspan="3"><select name="cboManufacFactory" id="cboManufacFactory" style="width:365px;">
                          <option value=""  selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT intCompanyID,strName,strCity FROM companies c where intStatus=1 and intManufacturing=1 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ." - "." ". $row["strCity"].""."</option>" ;
	}
	
	?>
                          </select>                          </td>
                          </tr>
                        <tr>
                          <td class="normalfnt">&nbsp;</td>
                          <td class="normalfnt">Change To Order No <span class="compulsoryRed">*</span></td>
                          <td><input name="txtChangeToStyleName" type="text" class="txtbox" id="txtChangeToStyleName" style="width:150px" maxlength="35"/></td>
                          <td class="normalfnt">Color code</td>
                          <td><select name="cboColor" id="cboColor" style="width:100px;">
                           <?php 
							$sqlColor = "select distinct strColor from colors where intStatus=1 ";
							
							$resColor =$db->RunQuery($sqlColor); 
							echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
							while($row=mysql_fetch_array($resColor))
							{
								echo "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;
							}
						?>
                          </select>                          </td>
                        </tr>
                        <tr>
                          <td class="normalfnt">&nbsp;</td>
                          <td class="normalfnt">Change To Style No <span class="compulsoryRed">*</span></td>
                          <td><input name="txtChangeToStyleNo" type="text" class="txtbox" id="txtChangeToStyleNo" style="width:150px" maxlength="35"/></td>
                          <td class="normalfnt"><!--DWLayoutEmptyCell-->&nbsp;</td>
                          <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                        </tr>
						<tr class="normalfnt">
                        	<td>&nbsp;</td>
                            <td>Change To Sewing Factory <span class="compulsoryRed">*</span></td>
                            <td colspan="3"><select name="cboChangeFactory" id="cboChangeFactory" style="width:365px;">
                            <option value=""  selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT intCompanyID,strName,strCity FROM companies c where intStatus=1 and intManufacturing=1 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ." - "." ". $row["strCity"].""."</option>" ;
	}
	
	?>
                            </select>                            </td>
                            </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
                        <tr>
                          <td width="100%" ><table width="100%" border="0">
                              <tr>
                                <td width="27%">&nbsp;</td>
                                <td width="18%"><img src="../images/new.png" alt="new" id="butNew" width="96" height="24" onclick="ClearForm();" /></td>
                                <td width="16%"><img src="../images/save.png" alt="save" id="butSave" width="84" height="24" onclick="ChangeOrder();" /></td>
                                <td width="19%"><a href="../main.php"><img src="../images/close.png" id="butClose" alt="close" width="97" height="24" border="0" /></a></td>
                                <td width="20%">&nbsp;</td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
var xmlHttp = [];
function createXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}
function ClearForm1(){	
	setTimeout("location.reload(true);",0);
}
function GetOrderNoBySc(obj)
{
	document.getElementById('cboStyleId').value = obj.value;
	//document.getElementById('txtChangeToStyleName').value = document.getElementById('cboStyleId').options[document.getElementById('cboStyleId').selectedIndex].text;	
	GetOrderWiseCopyData(obj.value);
}
function GetScByOrderNo(obj)
{
	document.getElementById('cboScNo').value = obj.value;
	//document.getElementById('txtChangeToStyleName').value = document.getElementById('cboStyleId').options[document.getElementById('cboStyleId').selectedIndex].text;
	GetOrderWiseCopyData(obj.value);
}
function ClearForm()
{
	var url="changeorderdb.php?RequestType=ReLoadStyleNo";
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboOrderNo').innerHTML = htmlobj.responseText;
	
	var url="changeorderdb.php?RequestType=ReLoadOrderNo";
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboStyleId').innerHTML = htmlobj.responseText;
	
	var url="changeorderdb.php?RequestType=ReLoadScNo";
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboScNo').innerHTML = htmlobj.responseText;
	
	document.getElementById('cboScNo').value = "";
	document.getElementById('cboStyleId').value = "";
	document.getElementById('txtChangeToStyleName').value = "";
	document.getElementById('txtChangeToStyleNo').value = "";
	document.getElementById('cboColor').value = "";
}
function ChangeOrder()
{
	var sourceStyleId		= document.getElementById('cboStyleId').value;
	var changeToStyleName	= document.getElementById('txtChangeToStyleName').value.trim();
	var styleName			= document.getElementById('cboStyleId').options[document.getElementById('cboStyleId').selectedIndex].text;	
	var changeToStyleNo		= document.getElementById('txtChangeToStyleNo').value.trim();
	var manufacFactory      = document.getElementById('cboChangeFactory').value;
	if(sourceStyleId==""){
		alert("Please select the 'Order No'.");
		document.getElementById('cboStyleId').focus();
		return;
	}
	if(changeToStyleName==""){
		alert("Please enter the 'Change To Order No'.");
		document.getElementById('txtChangeToStyleName').select();
		return;
	}
	if(changeToStyleNo=="")
	{
		alert("Please enter the 'Change To Style No'.");
		document.getElementById('txtChangeToStyleNo').select();
		return;
	}
	var color = $("#cboColor option:selected").text();
	var colorCode = $("#cboColor").val();
	var orderLen=parseInt(changeToStyleName.length)
	if(color != "Select One" )
	{
		orderLen += parseInt(color.length)
		changeToStyleName = changeToStyleName+'-'+colorCode;
	}
	
	if(orderLen>=35)
	{
		alert("Exceed the maximum length of \"Order No\" with Color");	
		document.getElementById('txtChangeToStyleName').focus();
		return false;
	}
	if(manufacFactory == '')
	{
		alert("Please select 'Change To Sewing Factory'");
		document.getElementById('cboChangeFactory').focus();
		return false;
	}
	var buyerPoNo = document.getElementById('txtChangeToStyleName').value.trim();	
	/*if(styleName==changeToStyleName)
	{
		alert("'Change To Order No' must be different from 'Previous Order No'.");
		document.getElementById('txtChangeToStyleName').select();
		return;
	}*/
	//alert(changeToStyleName);
	//return;
	
	createXMLHttpRequest(1);
    xmlHttp[1].onreadystatechange = ChangeOrderRequest;
    xmlHttp[1].open("GET", 'changeorderdb.php?RequestType=ChangeOrder&sourceStyleId=' +sourceStyleId+ '&changeToStyleName=' +URLEncode(changeToStyleName)+ '&styleName='+URLEncode(styleName)+ '&changeToStyleNo='+URLEncode(changeToStyleNo)+'&colorCode='+URLEncode(colorCode)+'&buyerPoNo='+URLEncode(buyerPoNo)+'&manufacFactory='+manufacFactory, true);
    xmlHttp[1].send(null);  
}

function ChangeOrderRequest()
{
	  if(xmlHttp[1].readyState == 4) 
    {
        if(xmlHttp[1].status == 200) 
        {  
			alert(xmlHttp[1].responseText);
			if(xmlHttp[1].responseText=="Style updated.")
				ClearForm();
		}
	}
}

function GetOrderNo(obj)
{
	var url="changeorderdb.php?RequestType=GetOrderNo&styleNo="+obj;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboStyleId').innerHTML = htmlobj.responseText;
	
	document.getElementById('txtChangeToStyleName').value = "";
	document.getElementById('txtChangeToStyleNo').value = "";
}
function GetScNo(obj)
{
	var url="changeorderdb.php?RequestType=GetScNo&styleNo="+obj;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboScNo').innerHTML = htmlobj.responseText;
	
	document.getElementById('txtChangeToStyleName').value = "";
	document.getElementById('txtChangeToStyleNo').value = "";
}
function GetOrderWiseCopyData(obj)
{
	var url  = "../preordermiddletire.php?";
		url += "RequestType=GetOrderWiseCopyData";
		url += "&orderId="+obj;
				
	var htmlobj=$.ajax({url:url,async:false});
	var XMLOrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('txtChangeToStyleName').value = XMLOrderNo;
	var XMLStyleNo = htmlobj.responseXML.getElementsByTagName("StyleNo")[0].childNodes[0].nodeValue;
		document.getElementById('txtChangeToStyleNo').value = XMLStyleNo;
	var XMLColorCode = htmlobj.responseXML.getElementsByTagName("colorCode")[0].childNodes[0].nodeValue;
		document.getElementById('cboColor').value = XMLColorCode;
	document.getElementById('cboManufacFactory').value = htmlobj.responseXML.getElementsByTagName("sewFactory")[0].childNodes[0].nodeValue;
	document.getElementById('cboChangeFactory').value = htmlobj.responseXML.getElementsByTagName("sewFactory")[0].childNodes[0].nodeValue;		
}
</script>
</body>
</html>
