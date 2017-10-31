<?php
 session_start();
 include "authentication.inc";
$delTo 		= $_POST["cboDeliverTo"];
$invTo 		= $_POST["cboInvoiceTo"];
$styleID 	= $_POST["cboOrderNo"];
$srNo 		= $_POST["cboSR"];
$supplier 	= $_POST["cboSupplier"];
$poNo 		= $_POST["txtPO"];
$poyear 	= $_POST["cboYear"];
$styleName 	= $_POST["cboStyles"];
$reportname = "poConfirmReport.php";

$status 	= 5;
	
$allowFirstApprovalPurchaseOrder =true;
$allowSecondApprovalPurchaseOrder =$allowSecondApprovalPO;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PO Confirm</title>
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
	document.getElementById("cboInvoiceTo").value = "";
	document.getElementById("cboSupplier").value = "";
}

function submitForm()
{
	document.frmcompletePO.submit();
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

function clearFrm()
{
	document.getElementById('frmcompletePO').reset();
}

function viewPOfirstAppDetails(poNO, intYear)
{
	window.open("poFirstApprovalReport.php?pono=" + poNO + "&year=" + intYear,'frmcompletePO');
	//alert(reportname);
}

function viewPOSecondAppDetails(poNO, intYear)
{
	var newwindow=window.open("poConfirmReport.php?pono=" + poNO + "&year=" + intYear);
	if (window.focus) {newwindow.focus()}
	//alert(reportname);
}

function getStyleSCNo()
{
	document.getElementById('cboSR').value = document.getElementById('cboOrderNo').value
}
function getStyleOrderNo()
{
var stytleName = document.getElementById('cboStyles').value;
	var url="bomMiddletire.php";
					url=url+"?RequestType=getStyleWiseOrderNum";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;
		var srNo = htmlobj.responseXML.getElementsByTagName("srNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboSR').innerHTML =  srNo;
}
function getOrderNo()
{
var orderName = document.getElementById('cboOrderNo').value;
	var url="bomMiddletire.php";
					url=url+"?RequestType=getStyleWiseOrderDetails";
					url += '&orderName='+URLEncode(orderName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var styleNo = htmlobj.responseXML.getElementsByTagName("styleNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboStyles').innerHTML =  styleNo;
}
function getStyleNo()
{
	var scNo = document.getElementById('cboSR').value;
	var url="bomMiddletire.php";
					url=url+"?RequestType=getSCWiseStyleDetails";
					url += '&scNo='+URLEncode(scNo);
					
		var htmlobj=$.ajax({url:url,async:false});
		var styleNos = htmlobj.responseXML.getElementsByTagName("styleNos")[0].childNodes[0].nodeValue;
		document.getElementById('cboStyles').innerHTML =  styleNos;
		var ordersNos = htmlobj.responseXML.getElementsByTagName("ordersNos")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  ordersNos;
}
</script>
</head>

<body>
<form id="frmcompletePO" name="frmcompletePO" method="post" action="POConfirmation.php">
  <table width="100%" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include 'Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="1100" border="0" align="center" class="bcgl1">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="4%"><div align="center"><img src="images/butt_1.png" width="15" height="15" /></div></td>
          <td width="96%" class="head1">Purchase Orders to be confirm </td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="1100" border="0" class="bcgl1">
                <tr>
                  <td width="82" class="normalfnt">Deliver To </td>
                  <td width="201" ><select name="cboDeliverTo" class="txtbox" id="cboDeliverTo" style="width:170px">
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
                  <td width="85" class="normalfnt">Style No </td>
                  <td width="193" ><select name="cboStyles" class="txtbox" style="width:170px" id="cboStyles" onchange="getStyleOrderNo();resetCompanyBuyer();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
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
                  <td width="69" class="normalfnt">Order No</td>
                  <td width="193" ><select name="cboOrderNo" id="cboOrderNo" style="width:170px;" onchange="getStyleSCNo();resetCompanyBuyer(); getOrderNo();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId,orders.strOrderNo from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 ";
	
	if($styleName != '' && $styleName !='Select One')
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
                  </select></td>
                  <td width="71" class="normalfnt">SC No</td>
                  <td width="170" ><select name="cboSR" class="txtbox" style="width:170px" id="cboSR" onchange="getStyleNo();resetCompanyBuyer();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intSRNO,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 ";
	
	
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
                    </select>                  </td>
                  <td class="normalfnt">Invoice To</td>
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
                  </select></td>
                  <td  class="normalfnt">PO# Like</td>
                  <td><input name="txtPO" type="text" class="txtbox" style="width:170px" id="txtPO" value="<?php echo $_POST["txtPO"]; ?>" /></td>
                  <td  class="normalfnt">Year</td>
                  <td><select name="cboYear" class="txtbox" style="width:170px" id="cboYear">
                    <?php
			for ($loop = date("Y") ; $loop >= 2008; $loop --)
			{
				if ($poyear ==  $loop)
					echo "<option selected=\"selected\" value=\"$loop\">$loop</option>";
				else
					echo "<option value=\"$loop\">$loop</option>";
			}
	?>
                  </select></td>
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
          <td colspan="2"><div id="divData" style="width:1100px; height:400px; overflow: scroll; border-width:3px; border-style:solid;border-color:#FFD5AA;">
            <table width="1080" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" class="bcgl1" id="tblPreOders" >
              <tr>
                <td width="9%" height="19" bgcolor="#804000" class="normaltxtmidb2">PO No</td>
                <td width="9%" bgcolor="#804000" class="normaltxtmidb2">Year</td>
                <td width="20%" bgcolor="#804000" class="normaltxtmidb2">Supplier</td>
                <td width="8%" bgcolor="#804000" class="normaltxtmidb2">Deliver To </td>
                <td width="8%" bgcolor="#804000" class="normaltxtmidb2">Invoice To </td>
                <td width="8%" bgcolor="#804000" class="normaltxtmidb2">PO Value </td>
                <td width="8%" bgcolor="#804000" class="normaltxtmidb2">Balance Value </td>
                <td width="8%" bgcolor="#804000" class="normaltxtmidb2"> User </td>
                <!-- <td width="5%" bgcolor="#804000" class="normaltxtmidb2">First Approve By</td>
                <td width="5%" bgcolor="#804000" class="normaltxtmidb2">First Approve Date</td>
                <td width="5%" bgcolor="#804000" class="normaltxtmidb2">First Approve</td>-->
                <td width="5%" bgcolor="#804000" class="normaltxtmidb2">Approve By</td>
                <td width="5%" bgcolor="#804000" class="normaltxtmidb2">Approve Date</td>
                <?php if($allowSecondApprovalPO) 
				{
				?>
                <td width="5%" bgcolor="#804000" class="normaltxtmidb2">Approve</td>
                <?php 
				}
				?>
              </tr>
              <?php
			$sql = "SELECT DISTINCT purchaseorderheader.intPONo,purchaseorderheader.intYear,purchaseorderheader.intUserID,suppliers.strTitle,purchaseorderheader.intStatus, purchaseorderheader.dblPOValue,  purchaseorderheader.dblPOBalance, (SELECT strComCode FROM companies WHERE intCompanyID = purchaseorderheader.intInvCompID ) AS invTo , (SELECT strComCode FROM companies WHERE intCompanyID = purchaseorderheader.intDelToCompID ) AS delTo ,useraccounts.Name,purchaseorderheader.intStatus, 
			(select Name from useraccounts UA where UA.intUserID=purchaseorderheader.intFirstApprovedBy) as firstApprovedUser,
			purchaseorderheader.dtmFirstAppDate,purchaseorderheader.dtmConfirmedDate,
			(select Name from useraccounts UA where UA.intUserID=purchaseorderheader.intConfirmedBy) as secondApprovedUser
			FROM purchaseorderheader 
INNER JOIN purchaseorderdetails ON purchaseorderheader.intPoNo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear
inner join orders on orders.intStyleId=purchaseorderdetails.intStyleId 
INNER JOIN useraccounts ON purchaseorderheader.intUserID = useraccounts.intUserID INNER JOIN suppliers ON
purchaseorderheader.strSupplierID = suppliers.strSupplierID and purchaseorderheader.intStatus in ('5','2') " ;
			
			
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
			/*if ($styleName != "Select One")
			{
				$sql.= " and orders.strStyle = '$styleName'";
			}*/
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
			$sql.= " order by purchaseorderheader.intYear, purchaseorderheader.intPONo  DESC";
			
	
			//echo $sql;
			$result = $db->RunQuery($sql);	
			$pos = 0;
			while($row = mysql_fetch_array($result))
			{
			
				$firstApproval	= true;
				$firstApproveBy	= $row["firstApprovedUser"];			
				if (is_null($firstApproveBy)){
					$firstApproveBy = '-';
					
				}
				
				$firstApproveDate	= $row["dtmFirstAppDate"];			
				if (is_null($firstApproveDate)){
					$firstApproveDate = '-';
					$firstApproval	= false;
				}
				
				$secondApproval	= true;
				$secondApproveBy	= $row["secondApprovedUser"];			
				if (is_null($secondApproveBy)){
					$secondApproveBy = '-';
					$secondApproval	= false;
				}
				
				$secondApproveDate	= $row["dtmAppDate"];			
				if (is_null($secondApproveDate)){
					$secondApproveDate = '-';
				}
				
				$poNO = $row["intPONo"];
				$intYear = 	$row["intYear"];	
				
				

				$status =$row["intStatus"];
				
				if($status == '5')
				{
					$reportname = "poFirstApprovalReport.php";
				}
				else
				{
					$reportname = "poConfirmReport.php";
				}
			?>
              <tr class="<?php 
			  if ($pos % 2 == 0)
					echo "bcgcolor-tblrow";
				else
					echo "bcgcolor-tblrowWhite";
					//poFirstApprovalReport.php
			   ?>">
                <td height="21" class="normalfnt"><?php echo  $row["intPONo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["intYear"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strTitle"]; ?></td>
                <td class="normalfnt"><?php echo  $row["delTo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["invTo"]; ?></td>
                <td class="normalfnt"><div align="right"><?php echo  number_format($row["dblPOValue"],2); ?></div></td>
                <td class="normalfnt"><div align="right"><?php echo  number_format($row["dblPOBalance"],2); ?></div></td>
                <td class="normalfnt"><div align="right"><?php echo  $row["Name"]; ?></div></td>
                  <!--<td  class="normalfntMid"><?php echo $firstApproveBy; ?></td>
                <td  class="normalfntMid"><?php echo $firstApproveDate; ?></td>
                 <?php if(($allowFirstApprovalPurchaseOrder) && ($firstApproval)){					
					$firstAppUrl = "<a href=\"#\"  >Approved</a>";
				}else{					
					/*$firstAppUrl = "<a href=\"$reportname?pono=$poNO&year=$intYear\" target=\"_blank\"><img src=\"images/view2.png\" border=\"0\" class=\"noborderforlink\"/></a>";*/
					
					$firstAppUrl = "<img src=\"images/view2.png\" border=\"0\" class=\"noborderforlink\" onclick=\"viewPOfirstAppDetails($poNO,$intYear)\" />";
				}?>
                <td class="normalfnt"><?php echo $firstAppUrl; ?></td>-->
                 <td  class="normalfntMid"><?php echo $secondApproveBy; ?></td>
                <td  class="normalfntMid"><?php echo $secondApproveDate; ?></td>
                 <?php if(($allowSecondApprovalPO) && (!$firstApproval)){					
					$secondAppUrl = '';//"<a href=\"#\"  >Approved</a>";
				}else{					
					/*$secondAppUrl = "<a href=\"$reportname?pono=$poNO&year=$intYear\" target=\"_blank\"><img src=\"images/view2.png\" border=\"0\" class=\"noborderforlink\"/></a>";*/
					
					$secondAppUrl = "<img src=\"images/view2.png\" border=\"0\" class=\"noborderforlink\" onclick=\"viewPOSecondAppDetails($poNO,$intYear)\" />";
				}?>
                <?php if($allowSecondApprovalPO) 
				{
				?>
                <td class="normalfnt"><?php echo $secondAppUrl; ?></td>
                <?php 
				}
				?>
              </tr>
              <?php
			  $pos ++;
			}
			?>
            </table>
          </div></td>
        </tr>
		<tr bgcolor="#FFD5AA"><td colspan="2" align="center" ><img onclick="clearFrm();" src="images/new.png" border="0" /><a href="main.php" target="_self"><img src="images/close.png" border="0" /></a></td>
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
