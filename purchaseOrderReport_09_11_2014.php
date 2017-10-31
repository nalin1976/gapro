<?php
 session_start();
 
$delTo	 	= $_POST["cboDeliverTo"];
$invTo 		= $_POST["cboInvoiceTo"];
$styleID 	= $_POST["cboStyles"];
$srNo 		= $_POST["cboSR"];
$supplier 	= $_POST["cboSupplier"];
$status 	= $_POST["cboStatus"];
$poNo 		= $_POST["txtPO"];
$poyear 	= $_POST["cboYear"];

$reportname = "reportpurchase.php";

if(!isset($status))
$status =10;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Purchase Order Reports</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<script type="text/javascript" src="javascript/bom.js"></script>
<script type="text/javascript">


function resetCompanyBuyer()
{	
	document.getElementById("cboCustomer").value = "Select One";
}

function submitForm()
{
	document.frmcomplete.submit();
}

function ViewPO()
{
	if (document.getElementById("txtPO").value == "")
	{
		alert("Please enter the PO Number.");
		document.getElementById("txtPO").focus();
	}
	var PONo = document.getElementById("txtPO").value;
	var year = document.getElementById("cboYear").value;
	window.open("reportpurchase.php?pono=" + PONo + "&year=" + year + "&printState=1",'report');
}


function viewReport(pono,year)
{	//alert(pono);
	window.open("reportpurchase.php?pono=" + pono + "&year=" + year + "&printState=1",'report');
}

function viewReport2(pono,year)
{
	window.open("reportpurchaseOther.php?pono=" + pono + "&year=" + year,'Detail Report');
}

function AutoSelect(obj,controler)
{
	document.getElementById(controler).value = obj.value;
}

function loadOrderNo(){
var stytleName = document.getElementById("cboStNo").options[document.getElementById("cboStNo").selectedIndex].text;
 var type = "poReportGetStylewiseOrderNo";
   var url="commonPHP/styleNoOrderNoSCLoadingXML.php";
				url=url+"?RequestType="+type+"";
				    url += '&stytleName='+URLEncode(stytleName);
				
	var htmlobj=$.ajax({url:url,async:false});
	var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
	document.getElementById("cboStyles").innerHTML =  OrderNo;
}

</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="purchaseOrderReport.php">
<table width="100%" border="0">
<tr><td><?php include 'Header.php'; ?></td></tr>
<tr><td>
  <table width="1100" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" class="bcgl1">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="4%"><div align="center"><img src="images/butt_1.png" width="15" height="15" /></div></td>
          <td width="96%" class="head1">Purchase Order Reports </td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="1100" border="0" class="bcgl1">
                <tr>
                  <td width="79"  class="normalfnt">Deliver To </td>
                  <td width="195" ><select name="cboDeliverTo" class="txtbox" id="cboDeliverTo" style="width:170px">
                    <option value="Select One" selected="selected">Select One</option>
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
                  <td width="71"  class="normalfnt">Invoice To </td>
                  <td width="199"><select name="cboInvoiceTo" class="txtbox" style="width:170px" id="cboInvoiceTo">
                    <option value="Select One" selected="selected">Select One</option>
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
                  <td width="67"  class="normalfnt">Style No </td>
                  <td width="203" ><select name="cboStNo" class="txtbox" style="width:170px" id="cboStNo" onchange="AutoSelect(this,'cboSR');loadOrderNo();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId, orders.strStyle from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by orders.strOrderNo ;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($styleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="61"  class="normalfnt">SC No</td>
                  <td colspan="2" ><select name="cboSR" class="txtbox" style="width:170px" id="cboSR" onchange="AutoSelect(this,'cboStyles');">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId,specification.intSRNO from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by  intSRNO desc;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($srNo==  $row["intStyleId"])
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
                      <option value="Select One" selected="selected">Select One</option>
                      <?php
					
	$SQL = "SELECT strSupplierID,strTitle FROM suppliers order by strTitle ;";	
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
                  <td  class="normalfnt">Status</td>
                  <td><select name="cboStatus" class="txtbox" id="cboStatus" style="width:170px">
                    <option <?php if ($status ==1) {  ?> selected="selected" <?php } ?> value="1">Pending</option>
                    <option  <?php if ($status ==10) {  ?> selected="selected" <?php } ?>  value="10">Confirmed</option>
                    <option  <?php if ($status ==11) {  ?> selected="selected" <?php } ?>  value="11">Cancelled</option>
                  </select>                  </td>
                  <td  class="normalfnt">Order No</td>
                  <td><table width="85%" cellpadding="0" cellspacing="0">
                    <tr><td width="67%">
                  <select name="cboStyles" class="txtbox" style="width:170px" id="cboStyles" onchange="AutoSelect(this,'cboSR');">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId, orders.strOrderNo from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by orders.strOrderNo ;";
	
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
						</td><td width="33%" align="right">&nbsp;</td>
                  </tr></table>                  </td>
                  <td  class="normalfnt">Year</td>
                  <td colspan="2"><select name="cboYear" class="txtbox" style="width:170px" id="cboYear">
				  <?php
			for ($loop = date("Y") ; $loop >= 2006; $loop --)
			{
				if ($poyear ==  $loop)
					echo "<option selected=\"selected\" value=\"$loop\">$loop</option>";
				else
					echo "<option value=\"$loop\">$loop</option>";
			}
	?>
				
                  </select>                  </td>
                  </tr>
                <tr>
                  <td  class="normalfnt">PO# Like</td>
                  <td><input name="txtPO" type="text" class="txtbox" style="width:168px" id="txtPO" value="<?php echo $_POST["txtPO"]; ?>"/>
				  &nbsp;&nbsp; </td>
                  <td align="left"><img src="images/go.png" class="mouseover" onClick="ViewPO();"> </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td width="170"><div align="right"><img src="images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  <td width="15">&nbsp;</td>
                </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td align="center" colspan="2"><div align="center" id="divData" style="width:1100px; height:500px; overflow: scroll; border-width:3px; border-style:solid;border-color:#99CCFF;">
            <table width="1090" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" class="bcgl1" id="tblPreOders" >
              <tr>
                <td width="9%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">PO No</td>
                <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Year</td>
                <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Supplier</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Deliver To </td>
                <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Invoice To </td>
                <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">PO Value </td>
                <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Balance Value </td>
                <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2"> User </td>
                <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Normal Rpt</td>
				<!--<td width="15%" bgcolor="#498CC2" class="normaltxtmidb2">Detail Rpt</td>-->
              </tr>
              <?php
			$sql = "SELECT DISTINCT purchaseorderheader.intPONo,purchaseorderheader.intYear,purchaseorderheader.intUserID,suppliers.strTitle,purchaseorderheader.intStatus, purchaseorderheader.dblPOValue,  purchaseorderheader.dblPOBalance, (SELECT strComCode FROM companies WHERE intCompanyID = purchaseorderheader.intInvCompID ) AS invTo , (SELECT strComCode FROM companies WHERE intCompanyID = purchaseorderheader.intDelToCompID ) AS delTo ,useraccounts.Name FROM purchaseorderheader 
INNER JOIN purchaseorderdetails ON purchaseorderheader.intPoNo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear 
INNER JOIN useraccounts ON purchaseorderheader.intUserID = useraccounts.intUserID INNER JOIN suppliers ON
purchaseorderheader.strSupplierID = suppliers.strSupplierID and purchaseorderheader.intStatus=$status  " ;
			
			
			if ($delTo != "Select One")
			{
				$sql.= " and purchaseorderheader.intDelToCompID = $delTo";
			}
			if ($invTo != "Select One")
			{
				$sql.= " and purchaseorderheader.intInvCompID = $invTo";
			}
			if ($styleID != "Select One")
			{
				$sql.= " and purchaseorderdetails.intStyleId = '$styleID'";
			}
			if ($poyear != "Select One")
			{
				$sql.= " and purchaseorderdetails.intYear = $poyear";
			}
			if ($poNo != "")
			{
				$sql.= " and purchaseorderheader.intPoNo like '%$poNo%'";
			}
			if ($supplier != "Select One" )
			{
				$sql.= " and purchaseorderheader.strSupplierID = '$supplier' ";
			}
			$sql.= " order by purchaseorderheader.intYear, purchaseorderheader.intPONo  DESC";
			
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
			   ?>">
                <td height="21" class="normalfnt">000<?php echo  $row["intPONo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["intYear"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strTitle"]; ?></td>
                <td class="normalfnt"><?php echo  $row["delTo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["invTo"]; ?></td>
                <td class="normalfnt"><div align="right"><?php echo  number_format($row["dblPOValue"],2); ?></div></td>
                <td class="normalfnt"><div align="right"><?php echo  number_format($row["dblPOBalance"],2); ?></div></td>
                <td class="normalfnt"><div align="left"><?php echo  $row["Name"]; ?></div></td>
                <td class="normalfnt"><div align="center"><img onclick="viewReport(<?php echo  $row["intPONo"]; ?>,<?php echo  $row["intYear"]; ?>,<?php echo 1; ?>);" src="images/view2.png" border="0" class="noborderforlink" /></div></td>
				<?php /*?><td class="normalfnt"><div align="center"><img onclick="viewReport2(<?php echo  $row["intPONo"]; ?>,<?php echo  $row["intYear"]; ?>);" src="images/view2.png" border="0" class="noborderforlink" /></div></td><?php */?>
              </tr>
              <?php
			  $pos ++;
			}
			?>
            </table>
          </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><div align="right"></div></td>
    </tr>
  </table>
  </td></tr></table>
</form>
</body>
</html>
