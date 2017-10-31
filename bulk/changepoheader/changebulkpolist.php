<?php
 session_start();
 include "../../Connector.php";
 include "../../authentication.inc";
$backwardseperator = "../../";
 
$delTo    = $_POST["cboDeliverTo"];
$invTo    = $_POST["cboInvoiceTo"];
$supplier = $_POST["cboSupplier"];
$poNo	  = $_POST["txtPO"];
$poyear   = $_POST["cboYear"];


$pageName = "changeBulkPO.php";
if(!isset($_POST["cboDeliverTo"]))
	{
		$DateFrom	= date("Y-m-d");
	}	

$status =1;
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Bulk Purchase Order Correction</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="../../javascript/bom.js"></script>
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
	window.location.href='changebulkpolist.php';
	
}
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
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

function viewConfirmPOUpdateDetails(poNo,POyear)
{
	window.open("changeBulkPO.php?pono=" + poNo + "&year=" + POyear,'frmcomplete');
	//window.open(pageName+"?pono=" + poNo + "&year=" + POyear,'frmcomplete');
	//alert(pageName);
}

/*function getStyleOrderNolist()
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
}*/

function submitForm()
{
	document.frmcomplete.submit();
}
</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="changebulkpolist.php">
  <table width="100%" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include '../../Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="957" border="0" align="center" class="bcgl1">
        
        <tr>
          <td height="25" class="mainHeading">Bulk Purchase Orders (Confirmed) - Corrections </td>
          </tr>
        <tr>
          <td><table width="100%" border="0" class="bcgl1">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" border="0">
                <tr>
                  <td width="72" class="normalfnt">Deliver To </td>
                  <td width="72" ><select name="cboDeliverTo" class="txtbox" id="cboDeliverTo" style="width:170px">
                    <option value="" selected="selected">Select One</option>
                    <?php 
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
                  <td width="72"  class="normalfnt">Supplier</td>
                  <td width="72" ><select name="cboSupplier" class="txtbox" id="cboSupplier" style="width:170px">
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
                  </select></td>
                  <td width="72"  class="normalfnt">Invoice To</td>
                  <td width="155" ><select name="cboInvoiceTo" class="txtbox" style="width:170px" id="cboInvoiceTo">
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
                  <td width="70"  class="normalfnt">PO# Like</td>
                  <td width="150" ><input name="txtPO" type="text" class="txtbox" style="width:150px" id="txtPO" value="<?php echo $_POST["txtPO"]; ?>" /></td>
                </tr>
                <tr>
                  <td height="26"  class="normalfnt">Year</td>
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
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td  class="normalfnt">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td><div align="right"><img src="../../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  </tr>
                
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
			<td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
				<tr>
				<td class="mainHeading2">&nbsp;</td>
				</tr>
				<tr>
          <td><div id="divData" style="width:957px; height:400px; overflow: scroll;">
            <table width="940" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" id="tblPreOders" >
              <tr class="mainHeading4">
                <td width="9%" height="25" >PO No</td>
                <td width="9%" >Year</td>
                <td width="20%">Supplier</td>
                <td width="7%" >Deliver To </td>
                <td width="8%" >Invoice To </td>
                <td width="12%">PO Value </td>
                <td width="12%">Balance Value </td>
                <td width="12%"> User </td>
                <td width="11%">View</td>
              </tr>
              <?php
			
			
			$user = $_SESSION["UserID"];
			
			$sql = "SELECT DISTINCT BPH.intBulkPoNo,BPH.intYear,BPH.intUserID,S.strTitle,BPH.intStatus,BPH.dblTotalValue,BPH.dblPoBalance, 
(SELECT strComCode FROM companies WHERE intCompanyID = BPH.intInvoiceComp ) AS invTo , 
(SELECT strComCode FROM companies WHERE intCompanyID = BPH.intDeliverTo ) AS delTo ,UA.Name 
FROM bulkpurchaseorderheader BPH 
INNER JOIN bulkpurchaseorderdetails BPD ON BPH.intBulkPoNo = BPD.intBulkPoNo AND BPH.intYear = BPD.intYear 
INNER JOIN useraccounts UA ON BPH.intUserID = UA.intUserID 
INNER JOIN suppliers S ON BPH.strSupplierID = S.strSupplierID and BPH.intStatus='$status'";
			
			if ($DateFrom!="")
				$sql.= " where BPH.dtDate <= '$DateFrom' ";
			
			if (!$administration)
				$sql.= " and BPH.intUserID='$user' ";
			
			if ($delTo != "")
			{
				$sql.= " and BPH.intDeliverTo = $delTo";
			}
			if ($invTo != "")
			{
				$sql.= " and BPH.intInvoiceComp = $invTo";
			}
			
			if ($poyear != "")
			{
				$sql.= " and BPD.intYear = $poyear";
			}
			if ($poNo != "")
			{
				$sql.= " and BPH.intBulkPoNo like '%$poNo%'";
			}
			if ($supplier != "" )
			{
				$sql.= " and BPH.strSupplierID = '$supplier' ";
			}
			$sql.= " order by BPH.dtDate desc  ";
			if ($DateFrom!="")
				$sql.= " limit 0, 50 ";
			
			$result = $db->RunQuery($sql);	
			$pos = 0;
			while($row = mysql_fetch_array($result))
			{
			?>
              <tr class="<?php 
			  if ($pos % 2 == 0)
					echo "txtbox bcgcolor-InvoiceCostTrim";
				else
					echo "bcgcolor-tblrowWhite";
					
					$intPONo = $row["intBulkPoNo"];
					$intyear = $row["intYear"];
					//$pageName = "changePO.php";
			   ?>">
                <td height="21" class="normalfnt"><?php echo  $row["intBulkPoNo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["intYear"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strTitle"]; ?></td>
                <td class="normalfnt"><?php echo  $row["delTo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["invTo"]; ?></td>
                <td class="normalfnt"><div align="right"><?php echo  number_format($row["dblTotalValue"],2); ?></div></td>
                <td class="normalfnt"><div align="right"><?php echo  number_format($row["dblPoBalance"],2); ?></div></td>
                <td class="normalfnt"><div align="right"><?php echo  $row["Name"]; ?></div></td>
                <!--<td class="normalfnt"><div align="center"><a href="<?php //echo $pageName; ?>?pono=<?php //echo  $row["intPONo"]; ?>&year=<?php //echo  $row["intYear"]; ?>" target="_blank"><img src="images/view2.png" border="0" class="noborderforlink" /></a></div></td>-->
                <td class="normalfnt"><div align="center"><img src="../../images/view2.png" border="0" class="noborderforlink" onclick="viewConfirmPOUpdateDetails(<?php echo $intPONo.','.$intyear ?>)" /></div></td>
              </tr>
              <?php
			  $pos ++;
			}
			?>
            </table>
          </div></td>
        </tr>
		</table>
		</td>
		</tr>
		<tr><td align="center" ><table width="100%" border="0" class="bcgl1">
      <tr>
        <td width="18%" class="normalfntMid">
       <img onclick="ClearChangePoList();" src="../../images/new.png" border="0" />
		<a href="../../main.php" target="_self"><img src="../../images/close.png" border="0" /></a>
        </td>
      </tr>
    </table></td>
		
      </table></td>
    </tr>
   
  </table>
</form>
</body>
</html>
