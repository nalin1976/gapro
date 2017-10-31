<?php
session_start();
include "authentication.inc";
include "Connector.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Copy Order</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" >
var UserID = <?php
 echo $_SESSION["UserID"]; 
 ?>;

function getOrderNoList()
{
	var stytleName = document.getElementById('cboStyleNo').value;
	//alert(stytleName);
	if(stytleName != 'Select One')
	{
	var url="preordermiddletire.php";
					url=url+"?RequestType=getStyleWiseOrderNoinCopyOrder";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;
	}
	else
	{
		location = "copyorder.php?";
		}
}

function GetOrderWiseCopyData(obj)
{
	var url  = "preordermiddletire.php?";
		url += "RequestType=GetOrderWiseCopyData";
		url += "&orderId="+obj.value;
				
	var htmlobj=$.ajax({url:url,async:false});
	var XMLOrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('txtnew').value = XMLOrderNo;
	var XMLStyleNo = htmlobj.responseXML.getElementsByTagName("StyleNo")[0].childNodes[0].nodeValue;
		document.getElementById('txtNewStyleNo').value = XMLStyleNo;
	var XMLColorCode = htmlobj.responseXML.getElementsByTagName("colorCode")[0].childNodes[0].nodeValue;
		document.getElementById('cboColor').value = XMLColorCode;
}
</script>
<script src="javascript/script.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/preorder.js"></script>

</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="450" border="0" align="center">
        
        <tr>
          <td width="100%"><table width="100%" border="0">
            <tr>
              <td width="62%"><table width="100%" border="0" class="tableBorder">
                  <tr>
                    <td height="35" bgcolor="#498CC2" class="mainHeading">Copy Order </td>
                  </tr>
                  <tr>
                    <td height="61"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td colspan="2" class="normalfnt">&nbsp;</td>
                          <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr >
                          <td width="10%" class="normalfnt">&nbsp;</td>
                          <td width="31%" class="normalfnt">Source Style No </td>
                          <td width="44%"><select  name="cboStyleNo"  id="cboStyleNo" style="width:160px;" onchange="getOrderNoList();">
                           <option value="Select One" selected="selected">Select One</option>
						   <?php
			 
	
	
	$SQL = "select distinct orders.strStyle from orders  order by orders.strStyle;";
	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	/*if($row["strCurrency"]=="USD")
	echo "<option value=\"". $row["strCurrency"] ."\" selected=\"selected\">" . $row["strCurrency"] ."</option>";
	else*/
	echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
                          </select></td>
                          <!--<td width="36%"><input name="txtStyleNo" type="text" class="txtbox" id="txtStyleNo" onkeyup="AutoCompleteStyleNos(event);"  /></td>-->
                          <td width="12%" class="normalfnt"><!--DWLayoutEmptyCell-->&nbsp;</td>
                          <td width="3%"><!--DWLayoutEmptyCell-->&nbsp;</td>
                        </tr>
                        <tr >
                          <td height="27" class="normalfnt">&nbsp;</td>
                          <td class="normalfnt">Sourse Order No <span class="compulsoryRed">*</span></td>
                          <td><select name="cboOrderNo" id="cboOrderNo" style="width:160px;" onchange="GetOrderWiseCopyData(this);">
                           <option value="Select One" selected="selected">Select One</option>
						   <?php
			 
	
	
	$SQL = "select orders.strOrderNo, orders.intStyleId from orders  order by orders.strOrderNo;";
	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	/*if($row["strCurrency"]=="USD")
	echo "<option value=\"". $row["strCurrency"] ."\" selected=\"selected\">" . $row["strCurrency"] ."</option>";
	else*/
	echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                          </select>                          </td>
                          <td class="normalfnt"><!--DWLayoutEmptyCell-->&nbsp;</td>
                          <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                        </tr>
                        <tr >
                          <td height="27" class="normalfnt">&nbsp;</td>
                          <td class="normalfnt">New Order No <span class="compulsoryRed">*</span> </td>
                          <td><input name="txtnew" type="text" class="txtbox" id="txtnew" style="width:158px;" /></td>
                          <td class="normalfnt"><!--DWLayoutEmptyCell-->&nbsp;</td>
                          <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                        </tr>
                        <tr >
                          <td height="27" class="normalfnt">&nbsp;</td>
                          <td class="normalfnt">New Style No <span class="compulsoryRed">*</span></td>
                          <td><input name="txtNewStyleNo" type="text" class="txtbox" id="txtNewStyleNo" style="width:158px;" /></td>
                          <td class="normalfnt"><!--DWLayoutEmptyCell-->&nbsp;</td>
                          <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                        </tr>
                        <tr >
                          <td height="27" class="normalfnt">&nbsp;</td>
                          <td class="normalfnt">New Color Code</td>
                          <td><select name="cboColor" id="cboColor" style="width:160px;">
                           <?php 
							$sqlColor = "select distinct strColor from colors where intStatus=1 ";
							
							$resColor =$db->RunQuery($sqlColor); 
							echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
							while($row=mysql_fetch_array($resColor))
							{
								echo "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;
							}
						?>
                          </select>
                          </td>
                          <td class="normalfnt"><!--DWLayoutEmptyCell-->&nbsp;</td>
                          <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                        </tr>

                    </table></td>
                  </tr>
                  <tr>
                    <td ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
                        <tr>
                          <td width="100%" ><table width="100%" border="0">
                              <tr>
                                <td width="100%"><div align="center"><img src="images/save.png" alt="OK" onclick="CopyOrder();" />
                                <a href="main.php"><img src="images/close.png" id="butClose" alt="close" border="0" /></a></div></td>
                               
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
</body>
</html>
