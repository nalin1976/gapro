<?php
$backwardseperator = "../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Sheet</title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/script.js"></script>

<script type="text/javascript">
function getStylewiseOrderNoNew()
{
	var stytleName = document.getElementById('cboStyles').value;
	
	//if(stytleName != 'Select One')
	//{
	var url="../bomMiddletire.php";
					url=url+"?RequestType=getStylewiseOrderNoNew";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;
	//}
	//else
	//{
		//location = "bom.php?styleName="+stytleName;
		//}
				
}

function getScNo()
{
	//start 2010-10-16 get style wise SC no ------------------------------
	/*var styleID = document.getElementById('cboStyles').value;
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = handlestyshow;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=getSRNo&styleID=' + URLEncode(styleID) , true);   
	xmlHttp.send(null);*/
	
	var styleName = document.getElementById('cboStyles').value;
	var url="../bomMiddletire.php";
					url=url+"?RequestType=getStyleWiseSCNum";
					url += '&styleName='+URLEncode(styleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("SCNO")[0].childNodes[0].nodeValue;
		document.getElementById('cboSR').innerHTML =  OrderNo;
	
}

function getStyleNo()
{
	var scNo = document.getElementById('cboSR').value;
	// start 2010-10-16 get order no 
	document.getElementById('cboOrderNo').value = scNo;
	/*createXMLHttpRequest();
    xmlHttp.onreadystatechange = handleSCshow;
    xmlHttp.open("GET", 'preordermiddletire.php?RequestType=getStyleID&scNo=' + scNo , true);   
	xmlHttp.send(null); */
}

function getStyleandSC()
{
		//alert(document.getElementById('cboOrderNo').value);
		//document.getElementById('cboStyles').value = document.getElementById('cboOrderNo').value;
		document.getElementById('cboSR').value = document.getElementById('cboOrderNo').value;
}

function loadBomReport()
{

	var styleID =document.getElementById('cboOrderNo').value;
	window.open("ordersitemreport.php?styleID=" + styleID,'frmbom'); 	
}
</script>
</head>

<body>

<?php
include "../Connector.php";

?>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="td_coHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom">
	<div class="main_top">
		<div class="main_text">ORDER SHEET</div>
	</div>
	<div class="main_body">
<table class="" align="center" width="600" border="0" cellspacing="1">
      <tr>
        <td width="48%"><form id="frmCountries" name="frmCountries" method="post" action="">
          <table width="590" border="0"  cellspacing="0">
            <tr>
              <td height="7" colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td width="95" >&nbsp;</td>
              <td width="120" class="normalfnt">Style No</td>
              <td width="369"><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="getStylewiseOrderNoNew();getScNo();">
                    <option   value="Select One" selected="selected">Select One</option>
                    <?php
	
	/*$SQL = "select specification.intStyleId,orders.strStyle from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11;";*/
	$SQL = "select distinct orders.strStyle,orders.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by  orders.strStyle;";

	$result = $db->RunQuery($SQL);

	

	while($row = mysql_fetch_array($result))
	{
	
		if ($styleName==  $row["strStyle"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strStyle"] ."\" title=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option  value=\"". $row["strStyle"] ."\" title=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	?>
                </select></td>
            </tr>
            <tr>
              <td >&nbsp;</td>
              <td class="normalfnt">SC&nbsp;</td>
               <td><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="getStyleNo();">
                      <option value="Select One" selected="selected">Select One</option>
                      <?php
	
	$SQL = "select specification.intSRNO,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11";
	
	if($styleName != 'Select One' && $styleName != '')
		$SQL .= " and orders.strStyle='$styleName' ";
		
		$SQL .= " order by specification.intSRNO desc";
		
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
              <td  >&nbsp;</td>
              <td class="normalfnt">Order No&nbsp;</td>
              <td><select name="cboOrderNo" class="txtbox" style="width:150px" id="cboOrderNo" onchange="getStyleandSC();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId,orders.strOrderNo from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11";
	
	if($styleName != 'Select One' && $styleName != "")
		$SQL .= " where  orders.strStyle = '$styleName'";
		
		$SQL .= " order by strOrderNo ";	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($reqStyleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                  </select></td>
            </tr>
            
            <tr>
              <td height="21" colspan="3" bgcolor=""><table width="102%" border="0" class="">
                <tr>
                  <td align="center">    
		<img id="butReport" src="../images/report.png" alt="Report" border="0" class="mouseover" onclick="loadBomReport();" tabindex="9"  />
                  <a id="td_coDelete" href="../main.php"><img src="../images/close.png" alt="Close" name="Close" border="0" id="butClose" tabindex="10"/></a></td>
    
                </tr>
              </table></td>
            </tr>
          </table>
         </form>        </td>
      </tr>
    </table></td>
  </tr>
</table>

</div>
</div>
</body>
</html>

