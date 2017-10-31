<?php
session_start();
$backwardseperator 	= "../../";
include "../../authentication.inc";
include "{$backwardseperator}Connector.php";

$delTo 		= $_POST["cboDeliverTo"];
$invTo 		= $_POST["cboInvoiceTo"];
$styleID 	= $_POST["cboStyles"];
$srNo 		= $_POST["cboSR"];
$supplier 	= $_POST["cboSupplier"];
$status 	= $_POST["cboStatus"];
$poNo 		= $_POST["txtPO"];
$poyear 	= $_POST["cboYear"];

$reportname = "expoconfirmationreport.php";

if(!isset($status))
$status =10;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ePlan Web | Excess Purchase Order Listing</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}

-->

.main_bottom1{
	width:auto; height:auto;
	position : absolute; 
	top : 150px; left:160px;
	border:1px solid;
	float:left;
	border-bottom-color:#550000;
	border-top-color:#550000;
	border-left-color:#550000;
	background-color:#FFFFFF;
	border-right-color:#550000;
	padding-right:15px;
	padding-top:20px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	border-bottom:13px solid #550000;
}
</style>



<script type="text/javascript" src="javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<script type="text/javascript" src="javascript/bom.js"></script>
<script type="text/javascript">


function resetCompanyBuyer()
{
	document.getElementById("cboFactory").value = "Select One";
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
	window.open("expoconfirmationreport.php?serialNo=" + PONo + "&serialYear=" + year);
}

function GetScNo(obj)
{
	document.getElementById('cboSR').value = obj.value;
}

function GetStyleId(obj)
{
	document.getElementById('cboStyles').value = obj.value;
}
</script>
</head>

<body>

<form id="frmcomplete" name="frmcomplete" method="post" action="expolisting.php">
  <table width="100%" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include '../../Header.php'; ?></td>
    </tr>
	</table>
<table align="center">
	<tr>
		<td>
<div class="main_bottom1">
	<div class="main_top">
		<div class="main_text">Excess Purchase Order Listing </div>
	</div>

	
	 <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="4%"><div align="center"><img src="images/butt_1.png" width="15" height="15" /></div></td>
          <td width="96%" class="head1"><div align="center"></div></td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="931" class="bcgl1">
                <tr>
                  <td width="72"  class="normalfnt">Deliver To </td>
                  <td width="72" class="normalfnt"><select name="cboDeliverTo" class="txtbox" id="cboDeliverTo" style="width:170px">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php

	//include "Connector.php"; 
	$SQL = "SELECT intCompanyID,strName FROM companies c where intStatus='1';";	
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
                  <td width="72"  class="normalfnt">Invoice To </td>
                  <td width="72" class="normalfnt"><select name="cboInvoiceTo" class="txtbox" style="width:170px" id="cboInvoiceTo">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT intCompanyID,strName FROM companies c where intStatus='1';";	
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
                  <td width="72"  class="normalfnt">Style No </td>
                  <td width="155" class="normalfnt"><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="GetScNo(this);">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select distinct PE.strStyleID from purchaseorderdetails_excess PE order by strStyleID;";
	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($styleID==  $row["strStyleID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strStyleID"] ."\">" . $row["strStyleID"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["strStyleID"] ."\">" . $row["strStyleID"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="70"  class="normalfnt">SC No</td>
                  <td width="150" class="normalfnt"><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="GetStyleId(this);">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select distinct PE.strStyleID,SP.intSRNO from purchaseorderdetails_excess  PE inner join specification SP on SP.strStyleID=PE.strStyleID order by SP.intSRNO desc;";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($srNo==  $row["intSRNO"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strStyleID"] ."\">" . $row["intSRNO"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["strStyleID"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  </tr>
                <tr>
                  <td height="26"  class="normalfnt">Supplier</td>
                  <td><span class="normalfnt">
                    <select name="cboSupplier" class="txtbox" id="cboSupplier" style="width:170px">
                      <option value="Select One" selected="selected">Select One</option>
                      <?php
					
	$SQL = "SELECT strSupplierID,strTitle FROM suppliers;";	
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
                  </span></td>
                  <td  class="normalfnt">Status</td>
                  <td><select name="cboStatus" class="normalfnt" id="cboStatus" style="width:170px">
                    <option <?php if ($status ==0) {  ?> selected="selected" <?php } ?> value="0">Pending</option>
                    <option <?php if ($status ==1) {  ?> selected="selected" <?php } ?>  value="1">Confirmed</option>                   
                  </select>
                  </td>
                  <td  class="normalfnt">PoNo Like</td>
                  <td><table><tr><td>
                  <input name="txtPO" type="text" class="normalfnt" style="width:100px" id="txtPO" value="<?php echo $_POST["txtPO"]; ?>" />
						</td><td>						
						<img src="../../../images/go.png" class="mouseover" onClick="ViewPO();">      </td></tr></table>            
                  </td>
                  <td  class="normalfnt">Year</td>
                  <td><select name="cboYear" class="txtbox" style="width:150px" id="cboYear">
				  <?php
			for ($loop = date("Y") ; $loop >= 2006; $loop --)
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
                  <td><div align="right"><img src="../../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><div id="divData" style="width:930px; height:400px; overflow: scroll;" class="bcgl1">
            <table width="910" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" class="bcgl1" id="tblPreOders" >
              <tr>
                <td width="9%" height="19"  class="mainHeading2">GRN No</td>
                <td width="9%"  class="mainHeading2">Year</td>
                <td width="20%"  class="mainHeading2">Supplier</td>
                <td width="7%"  class="mainHeading2">Deliver To </td>
                <td width="8%"  class="mainHeading2">Invoice To </td>
                <td width="12%"  class="mainHeading2">PO Value </td>
                <td width="12%"  class="mainHeading2">Balance Value </td>
                <td width="12%"  class="mainHeading2"> User </td>
                <td width="11%"  class="mainHeading2">View</td>
              </tr>
              <?php
			
			
		
			
			$sql = "SELECT DISTINCT PH.intGrnNo,PH.intGrnYear,PH.intUserID,suppliers.strTitle,PH.intStatus, PH.dblPOValue, PH.dblPOBalance, 
(SELECT strComCode FROM companies WHERE intCompanyID = PH.intInvCompID ) AS invTo , 
(SELECT strComCode FROM companies WHERE intCompanyID = PH.intDelToCompID ) AS delTo ,useraccounts.Name 
FROM purchaseorderheader_excess PH
INNER JOIN purchaseorderdetails_excess PD ON PH.intGrnNo = PD.intGrnNo AND PH.intGrnYear = PD.intGrnYear 
INNER JOIN useraccounts ON PH.intUserID = useraccounts.intUserID 
INNER JOIN suppliers ON PH.strSupplierID = suppliers.strSupplierID and PH.intStatus=$status  " ;
			
			
			if ($delTo != "Select One")
			{
				$sql.= " and PH.intDelToCompID = $delTo";
			}
			if ($invTo != "Select One")
			{
				$sql.= " and PH.intInvCompID = $invTo";
			}
			if ($styleID != "Select One")
			{
				$sql.= " and PD.strStyleID = '$styleID'";
			}
			if ($poyear != "Select One")
			{
				$sql.= " and PD.intGrnYear = '$poyear'";
			}
			if ($poNo != "")
			{
				$sql.= " and PH.intPONo like '%$poNo%'";
			}
			if ($supplier != "Select One" )
			{
				$sql.= " and PH.strSupplierID = '$supplier' ";
			}
			$sql.= " order by PH.intGrnNo, PH.intGrnYear  ";

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
                <td height="21" class="normalfnt"><?php echo  $row["intGrnNo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["intGrnYear"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strTitle"]; ?></td>
                <td class="normalfnt"><?php echo  $row["delTo"]; ?></td>
                <td class="normalfnt"><?php echo  $row["invTo"]; ?></td>
                <td class="normalfnt"><div align="right"><?php echo  number_format($row["dblPOValue"],2); ?></div></td>
                <td class="normalfnt"><div align="right"><?php echo  number_format($row["dblPOBalance"],2); ?></div></td>
                <td class="normalfnt"><div align="right"><?php echo  $row["Name"]; ?></div></td>
                <td class="normalfnt"><div align="center"><a href="<?php echo $reportname; ?>?serialNo=<?php echo  $row["intGrnNo"]; ?>&serialYear=<?php echo  $row["intGrnYear"]; ?>" target="_blank"><img src="../../images/view2.png" border="0" class="noborderforlink" /></a></div></td>
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
  </div>
</form>
</td>
</tr>
</table>
</body>
</html>
