<?php
 session_start();
include "authentication.inc";
 
$delTo = $_POST["cboDeliverTo"];
$invTo = $_POST["cboInvoiceTo"];
$styleID = $_POST["cboOrderNo"];
$srNo = $_POST["cboSR"];
$supplier = $_POST["cboSupplier"];
$poNo = $_POST["txtPO"];
$poyear = $_POST["cboYear"];
$styleName = $_POST["cboStyles"];

$pageName = "changePO.php";

$status =10;
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Purchase Order Correction</title>
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
	document.getElementById("cboDeliverTo").value = "";
	document.getElementById("cboSupplier").value = "";
	document.getElementById("cboInvoiceTo").value = "";
}

function ClearChangePoList()
{
//alert("hi");
	//document.getElementById('cboStyles').value = "Select One";
	document.frmcomplete.reset();
	
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

function viewConfirmPOUpdateDetails(pageName,poNo,POyear)
{
	window.open("changePO.php?pono=" + poNo + "&year=" + POyear,'frmcomplete');
	//window.open(pageName+"?pono=" + poNo + "&year=" + POyear,'frmcomplete');
	//alert(pageName);
}

function getStyleOrderNolist()
{
var stytleName = document.getElementById('cboStyles').value;
	var url="bomMiddletire.php";
					url=url+"?RequestType=getStyleWiseOrderNum";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;
}

function getStyleSCNo()
{
	document.getElementById('cboSR').value = document.getElementById('cboOrderNo').value;
}

function submitForm()
{
	document.getElementById('frmcomplete').submit();
}
</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="changePOList.php">
  <table width="100%" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="950" border="0" align="center" class="bcgl1">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="4%"><div align="center"><img src="images/butt_1.png" width="15" height="15" /></div></td>
          <td width="96%" class="head1">Purchase Orders (Confirmed) - Corrections </td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0" class="bcgl1">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0">
                <tr>
                  <td width="72" class="normalfnt">Deliver To </td>
                  <td width="72" ><select name="cboDeliverTo" class="txtbox" id="cboDeliverTo" style="width:170px">
                    <option value="" selected="selected">Select One</option>
                    <?php

	include "Connector.php"; 
	$SQL = "SELECT intCompanyID,strName FROM companies c where intStatus='1' order by strName;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($delTo== $row["intCompanyID"])
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
                  <td width="72"  class="normalfnt">Style No</td>
                  <td width="72" ><select name="cboStyles" class="txtbox" style="width:170px" id="cboStyles" onchange="getScNo();getStyleOrderNolist();resetCompanyBuyer();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	/*$SQL = "select specification.intStyleId, orders.strStyle from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by strStyle;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
	}*/
	
	$SQL = "select distinct orders.strStyle from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by orders.strStyle;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleName ==  $row["strStyle"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="72"  class="normalfnt">Order No</td>
                  <td width="155" ><select name="cboOrderNo" id="cboOrderNo" style="width:152px;" onchange="getStyleSCNo();">
                   <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId,orders.strOrderNo from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 ";
	
	if($styleName != 'Select One' && $styleName != '')
		$SQL .= " and  orders.strStyle = '$styleName' ";
		
		$SQL .= " order by orders.strOrderNo";
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                  </select>
                  </td>
                  <td width="70"  class="normalfnt">SC No</td>
                  <td width="150" ><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="getStyleNo();resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intSRNO,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 ";
	
	if($styleName != 'Select One' && $styleName != '')
		$SQL .= " and  orders.strStyle = '$styleName' ";
		
		$SQL .= " order by  intSRNO desc ";
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleID==  $row["intStyleId"])
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
                  <td height="26"  class="normalfnt">Supplier</td>
                  <td>
                    <select name="cboSupplier" class="txtbox" id="cboSupplier" style="width:170px">
                      <option value="" selected="selected">Select One</option>
                      <?php
					
	$SQL = "SELECT strSupplierID,strTitle FROM suppliers where intApproved=1 order by strTitle;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($supplier == $row["strSupplierID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
		}
	}
	
	?>
                    </select>
                 </td>
                  <td><span class="normalfnt">Invoice To</span></td>
                  <td><select name="cboInvoiceTo" class="txtbox" style="width:170px" id="cboInvoiceTo">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT intCompanyID,strName FROM companies c where intStatus='1' order by strName;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($invTo == $row["intCompanyID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		}
	}
	
	?>
                  </select>                  </td>
                  <td  class="normalfnt">PO# Like</td>
                  <td><input name="txtPO" type="text" class="txtbox" style="width:150px" id="txtPO" value="<?php echo $_POST["txtPO"]; ?>" /></td>
                  <td class="normalfnt">Year</td>
                  <td><select name="cboYear" class="txtbox" style="width:150px" id="cboYear">
				  <?php
			for ($loop = date("Y") ; $loop >= 2008; $loop --)
			{
				if ($poyear ==  $loop)
					echo "<option selected=\"selected\" value=\"$loop\">$loop</option>";
				else
					echo "<option value=\"$loop\">$loop</option>";
			}
	?>
				
                  </select>
                  </td>
                  </tr>
                <tr>
                  <td height="26">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><div align="right"><img src="images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><div id="divData" style="width:930px; height:400px; overflow: scroll; border-width:3px; border-style:solid;border-color:#FFD5AA;">
            <table width="910" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" class="bcgl1" id="tblPreOders" >
              <tr>
                <td width="9%" height="19" bgcolor="#804000" class="normaltxtmidb2">PO No</td>
                <td width="9%" bgcolor="#804000" class="normaltxtmidb2">Year</td>
                <td width="20%" bgcolor="#804000" class="normaltxtmidb2">Supplier</td>
                <td width="7%" bgcolor="#804000" class="normaltxtmidb2">Deliver To </td>
                <td width="8%" bgcolor="#804000" class="normaltxtmidb2">Invoice To </td>
                <td width="12%" bgcolor="#804000" class="normaltxtmidb2">PO Value </td>
                <td width="12%" bgcolor="#804000" class="normaltxtmidb2">Balance Value </td>
                <td width="12%" bgcolor="#804000" class="normaltxtmidb2"> User </td>
                <td width="11%" bgcolor="#804000" class="normaltxtmidb2">View</td>
              </tr>
              <?php
			
			
			$user = $_SESSION["UserID"];
			
			$sql = "SELECT DISTINCT purchaseorderheader.intPONo,purchaseorderheader.intYear,purchaseorderheader.intUserID,suppliers.strTitle,purchaseorderheader.intStatus, purchaseorderheader.dblPOValue,  purchaseorderheader.dblPOBalance, (SELECT strComCode FROM companies WHERE intCompanyID = purchaseorderheader.intInvCompID ) AS invTo , (SELECT strComCode FROM companies WHERE intCompanyID = purchaseorderheader.intDelToCompID ) AS delTo ,useraccounts.Name FROM purchaseorderheader 
INNER JOIN purchaseorderdetails ON purchaseorderheader.intPoNo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear 
inner join orders on orders.intStyleId=purchaseorderdetails.intStyleId 
INNER JOIN useraccounts ON purchaseorderheader.intUserID = useraccounts.intUserID INNER JOIN suppliers ON
purchaseorderheader.strSupplierID = suppliers.strSupplierID and purchaseorderheader.intStatus=$status  " ;
			
			if (!$administration)
				$sql.= " and purchaseorderheader.intUserID='$user' ";
			
			if ($delTo != "")
			{
				$sql.= " and purchaseorderheader.intDelToCompID = $delTo";
			}
			if ($invTo != "")
			{
				$sql.= " and purchaseorderheader.intInvCompID = $invTo";
			}
			if ($styleID != "")
			{
				$sql.= " and purchaseorderdetails.intStyleId = '$styleID'";
			}
			if ($styleName != "Select One")
			{
				$sql.= " and orders.strStyle = '$styleName'";
			}
			if ($poyear != "")
			{
				$sql.= " and purchaseorderdetails.intYear = $poyear";
			}
			if ($poNo != "")
			{
				$sql.= " and purchaseorderheader.intPoNo like '%$poNo%'";
			}
			if ($supplier != "" )
			{
				$sql.= " and purchaseorderheader.strSupplierID = '$supplier' ";
			}
			$sql.= " order by purchaseorderheader.intPONo, purchaseorderheader.intYear  ";
			
			//echo $sql;
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
					
					$intPONo = $row["intPONo"];
					$intyear = $row["intYear"];
					//$pageName = "changePO.php";
			   ?>">
                <td height="21" class="normalfnt"><?php echo  $row["intPONo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["intYear"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strTitle"]; ?></td>
                <td class="normalfnt"><?php echo  $row["delTo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["invTo"]; ?></td>
                <td class="normalfnt"><div align="right"><?php echo  number_format($row["dblPOValue"],2); ?></div></td>
                <td class="normalfnt"><div align="right"><?php echo  number_format($row["dblPOBalance"],2); ?></div></td>
                <td class="normalfnt"><div align="right"><?php echo  $row["Name"]; ?></div></td>
                <!--<td class="normalfnt"><div align="center"><a href="<?php //echo $pageName; ?>?pono=<?php //echo  $row["intPONo"]; ?>&year=<?php //echo  $row["intYear"]; ?>" target="_blank"><img src="images/view2.png" border="0" class="noborderforlink" /></a></div></td>-->
                <td class="normalfnt"><div align="center"><img src="images/view2.png" border="0" class="noborderforlink" onclick="viewConfirmPOUpdateDetails(<?php echo $pageName.','.$intPONo.','.$intyear ?>)" /></div></td>
              </tr>
              <?php
			  $pos ++;
			}
			?>
            </table>
          </div></td>
        </tr>
		<tr bgcolor="#FFD5AA"><td colspan="2" align="center" >
		<img onclick="ClearChangePoList();" src="images/new.png" border="0" />
		<a href="main.php" target="_self"><img src="images/close.png" border="0" /></a></td></tr>
      </table></td>
    </tr>
    <tr>
      <td><div align="right"></div></td>
    </tr>
  </table>
</form>
</body>
</html>
