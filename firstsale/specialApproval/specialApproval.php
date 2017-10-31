<?php
session_start();
include "../../Connector.php";
include "authentication.inc";
$backwardseperator ='../../';
//$PP_AllowOCFSFirstApproval		= true;	 //Assign user permition to first approve 
//$PP_AllowOCFSSecondApproval	= true;	//Assign user permition to second approve 
//$PP_AllowFSOrderContractCheck = true; //Assign user permission to check Order contract

$status 				= $_POST["cboStatus"];
$orderNo	 			= $_POST["cboOrderNo"];
$buyer 					= $_POST["cboBuyer"];
$txtOrderNo				= $_POST["txtOrderNo"];

$firstApproveReportname = "rptFirstApproval.php";	
$reportname 			= "rptSecondApproval.php";
$ocCheckReport = "rptOCcheck.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Order Contract Special Approval Listing</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../javascript/script.js"></script>
<script type="text/javascript">
function submitForm()
{
	document.frmSpecialApprovalListnig.submit();
}

</script>
</head>

<body>
<form id="frmSpecialApprovalListnig" name="frmSpecialApprovalListnig" method="post" action="specialApproval.php">
    <tr>
      <td><?php include $backwardseperator.'Header.php'; ?></td>
    </tr>
  <table width="1000" border="0" align="center" class="tableBorder" cellpadding="1" cellspacing="0" >
    <tr>
      <td><table width="100%" border="0">
     <tr>
          <td height="25" colspan="2" class="mainHeading" >Order Contract Special Approval Listing</td>
        </tr>
		<tr>
          <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
            <!--DWLayoutTable-->
            <tr>
              <td width="100%" height="21"><table width="100%" border="0">
                <tr>
                  <td width="72" class="normalfnt">Buyer</td>
                  <td width="258" ><select name="cboBuyer" class="txtbox" style="width:180px" id="cboBuyer">
                    <option value="" >Select One</option>
                    <?php
	$SQL = "select distinct B.intBuyerID,B.strName
			from firstsalecostworksheetheader FCWH
			inner join orders O on O.intStyleId=FCWH.intStyleId
			inner join buyers B on O.intBuyerID=B.intBuyerID
			where FCWH.intStatus=10 and FCWH.intExtraApprovalRequired=1 
			order by B.buyerCode";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if($buyer == $row["intBuyerID"])
			echo "<option selected=\"selected\" value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		else
			echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
	}
?>
                  </select></td>
                  <td width="113" class="normalfnt">Order No</td>
                  <td width="259" ><select name="cboOrderNo" class="txtbox" id="cboOrderNo" style="width:180px">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	 
	$SQL = "select intStyleId,strOrderNo from firstsalecostworksheetheader where intStatus=10 and intExtraApprovalRequired=1 order by strOrderNo;";	
	$result = $db->RunQuery($SQL);		
	
	while($row = mysql_fetch_array($result))
	{
		if($orderNo == $row["intStyleId"])
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">".$row["strOrderNo"]."</option>" ;
		else
			echo "<option value=\"". $row["intStyleId"] ."\">".$row["strOrderNo"]."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="93" class="normalfnt">Status</td>
                  <td colspan="2" ><select name="cboStatus" class="txtbox" style="width:155px" id="cboStatus">
                    <option <?php echo ($status==0 ? 'selected="selected"':'')?> value="0">Pending</option>
                    <option <?php echo ($status==1 ? 'selected="selected"':'')?> value="1">First Approved</option>
                    <option <?php echo ($status==2 ? 'selected="selected"':'')?> value="2">Second Approved</option>
                    <option <?php echo ($status==4 ? 'selected="selected"':'')?> value="4">All</option>
                   
                  </select></td>
                  </tr>
                <tr>
                  <td class="normalfnt" >&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Order No Like</td>
                  <td class="normalfnt"><input type="text" name="txtOrderNo" id="txtOrderNo" style="width:180px;" value="<?php echo ($txtOrderNo!="" ? $txtOrderNo:'')?>" /></td>
                  <td class="normalfnt">&nbsp;</td>
                  <td width="156"><div align="right"><img src="../../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  <td width="19">&nbsp;</td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2" class="tableBorder"><div id="divData" style="width:1000px; height:550px; overflow: scroll;">
            <table width="100%" border="0" cellpadding="0" cellspacing="1"  id="tblPreOders" bgcolor="#ECD9FF">
              <tr class="mainHeading4">
                <td width="7%" height="20" nowrap="nowrap">Order No</td>
                <td width="11%" nowrap="nowrap">Style No</td>
                <td width="11%" nowrap="nowrap">PO No </td>
                <td width="11%">Buyer Code </td>
                 <td width="11%">Check OC </td>
                <td width="7%">First Approved By </td>
                <td width="8%"> First Approved Date </td>
				<td width="6%">First Approval</td>
                <td width="7%">Second Approved By </td>
                <td width="7%">Second Approved Date </td>
				<td width="6%">Second Approval</td>
                <td width="8%">Buyer PO</td>
                </tr>
              <?php
			$sql = " select FCWH.strOrderNo,O.strStyle,FCWH.intStyleId,B.buyerCode,FCWH.intExtraApprovalStatus,
UA1.Name as FirstApproveBy ,FCWH.dtmFirstApproveDate as FirstApproveDate,FCWH.strOrderContractNo,
UA2.Name as SecondApproveBy,FCWH.dtmSecondApproveDate as SecondApproveDate,FCWH.intOCcheckStatus,FCWH.dblInvoiceId
from firstsalecostworksheetheader FCWH
inner join orders O on FCWH.intStyleId=O.intStyleId
inner join buyers B on O.intBuyerID=B.intBuyerID
left join useraccounts UA1 on UA1.intUserID=FCWH.intFirstApproveBy
left join useraccounts UA2 on UA2.intUserID=FCWH.intSecondApproveBy
where FCWH.intExtraApprovalRequired='1' and FCWH.intStatus='10' ";
					
			
			if ($orderNo != "Select One" and isset($orderNo) )
			{
				$sql .= " and FCWH.intStyleId='$orderNo'";
			}
			if ($buyer != "")
			{
				$sql .= " and B.intBuyerID='$buyer'";
			}
			if ($status != "4")
			{
				$sql .= " and FCWH.intExtraApprovalStatus ='$status'";
			}
			if ($txtOrderNo != "")
			{
				$sql .= " and FCWH.strOrderNo like '%$txtOrderNo%'";
			}
			$sql .=" order by FCWH.strOrderNo";
			$result = $db->RunQuery($sql);
			$pos = 0;
			while($row = mysql_fetch_array($result))
			{
				if($row["intExtraApprovalStatus"]=='0')
				{
					$firstApproveBy = '-';
					$firstApproveDate = '-';
					$secondApproveBy = '-';
					$secondApproveDate = '-';
					$firstApproval	= false;
				}
				
				elseif(($row["intExtraApprovalStatus"]=='1' || $row["intExtraApprovalStatus"]=='2') && $row["intOCcheckStatus"]==1)
				{
					$firstApproval	= true;
					$firstApproveBy	= $row["FirstApproveBy"];			
					if (is_null($firstApproveBy))
					{
						$firstApproveBy = '-';
						$firstApproval	= false;
					}
					
					$firstApproveDate	= $row["FirstApproveDate"];			
					if (is_null($firstApproveDate))
					{
						$firstApproveDate = '-';
					}
					
					$secondApproval	= true;
					$secondApproveBy	= $row["SecondApproveBy"];			
					if (is_null($secondApproveBy))
					{
						$secondApproveBy = '-';
						$secondApproval	= false;
					}
					
					$secondApproveDate	= $row["SecondApproveDate"];			
					if (is_null($secondApproveDate))
					{
						$secondApproveDate = '-';
					}
				}
				else if($row["intExtraApprovalStatus"]=='0' && is_null($row["intOCcheckStatus"]))
				{
					$firstApproveBy = '-';
					$firstApproveDate = '-';
					$secondApproveBy = '-';
					$secondApproveDate = '-';
					$firstApproval	= false;
				}
			?>
              <tr class="<?php 
			  if ($pos % 2 == 0)
					echo "bcgcolor-tblrowWhite";
				else
					echo "bcgcolor-tblrowLiteBlue";
			   ?>">
			   	
                <td height="21" class="normalfnt"><?php echo  $row["strOrderNo"]; ?></td>
                <td nowrap="nowrap" class="normalfntMid"><?php echo  $row["strStyle"]; ?></td>
                <td nowrap="nowrap" class="normalfnt" id="<?php echo $row["dblInvoiceId"]; ?>"><a href="../costworksheet/orderContractRpt.php?styleID=<?php echo $row["intStyleId"];?>&invoiceID=<?php echo $row["dblInvoiceId"];?>" target="../costworksheet/orderContractRpt.php"><?php echo  $row["strOrderContractNo"];?></a></td>
                <td nowrap="nowrap" class="normalfntMid"><?php echo  $row["buyerCode"]; ?></td>
                <?php 
				if($row["intOCcheckStatus"] ==1)
					$ocCheckUrl = "Checked";
				else
				$ocCheckUrl = "<a href=\"$ocCheckReport?styleID=".$row["intStyleId"]."&invoiceID=".$row["dblInvoiceId"]."\" target=\"../costworksheet/orderContractRpt.php\"><img src=\"../../images/view2.png\" border=\"0\" class=\"noborderforlink\" /></a>";
				if($PP_AllowFSOrderContractCheck)
						echo "<td nowrap=\"nowrap\" class=\"normalfntMid\">$ocCheckUrl</td>";
					else
						echo "<td nowrap=\"nowrap\" class=\"normalfntCentretRedSmall\">No Permission</td>";
				?>
                <td class="normalfntMid"><?php echo $firstApproveBy;?></td>
                <td nowrap="nowrap" class="normalfntMid"><?php echo $firstApproveDate;?></td>
				
				<?php if(($firstApproval) && ($row["intExtraApprovalStatus"]!='0'))
				{					
					$firstAppUrl = "<a href=\"#\">Approved</a>";
				}
				elseif((!$firstApproval) && ($row["intExtraApprovalStatus"]=='0')&& $row["intOCcheckStatus"]!='')
				{					
					$firstAppUrl = "<a href=\"$firstApproveReportname?styleID=".$row["intStyleId"]."&invoiceID=".$row["dblInvoiceId"]."\" target=\"../costworksheet/orderContractRpt.php\"><img src=\"../../images/view2.png\" border=\"0\" class=\"noborderforlink\" /></a>";
				}
				elseif(($row["intExtraApprovalStatus"]=='0'))
				{
					$firstAppUrl = "<a href=\"#\"  >-</a>";
				}?>
				<?php if($PP_AllowOCFSFirstApproval)
						echo "<td nowrap=\"nowrap\" class=\"normalfntMid\">$firstAppUrl</td>";
					else
						echo "<td nowrap=\"nowrap\" class=\"normalfntCentretRedSmall\">No Permission</td>";
				?>
                <td nowrap="nowrap" class="normalfntMid"><?Php echo $secondApproveBy;?></td> 
                <td nowrap="nowrap" class="normalfntMid"><?php echo $secondApproveDate;?></td>
								
				<?php if(($secondApproval) && ($row["intExtraApprovalStatus"]!='0') && ($row["intExtraApprovalStatus"]!='1'))
				{					
					$secondAppUrl = "<a href=\"#\">Approved</a>";
				}
				elseif((!$secondApproval) && ($row["intExtraApprovalStatus"]!='0') && ($row["intExtraApprovalStatus"]=='1'))
				{				
					$secondAppUrl = "<a href=\"$reportname?styleID=".$row["intStyleId"]."&invoiceID=".$row["dblInvoiceId"]."\" target=\"../costworksheet/orderContractRpt.php\"><img src=\"../../images/view2.png\" border=\"0\" class=\"noborderforlink\" /></a>";
				}
				elseif(($row["intExtraApprovalStatus"]=='0') || ($row["intExtraApprovalStatus"]=='1'))
				{
					$secondAppUrl = "<a href=\"#\" >-</a>";
				}
				?>
				<?php 	if($PP_AllowOCFSSecondApproval)
							echo "<td nowrap=\"nowrap\" class=\"normalfntMid\">$secondAppUrl</td>";
						else
							echo "<td nowrap=\"nowrap\" class=\"normalfntCentretRedSmall\">No Permission</td>";
				?>
			<?php
				$file = "";
			$url = "../../upload files/cws/". $row["intStyleId"]."/BPO/";
			
			$serverRoot = $_SERVER['DOCUMENT_ROOT'];
			$dh = opendir($url);
			
			if(file_exists($url))
			{
			
				while (($file = readdir($dh)) != false)
				{
				
					if($file!='.' && $file!='..')
					{
						$boo = true;
						$file1	= $url.rawurlencode($file);
					}
					else
					{
						$boo = false;
					}
				 
				}
				
				$folder = "../../upload files/cws/". $row["intStyleId"]."/BPO";
			if(count(glob("$folder/*")) === 0)
				echo  "<td>&nbsp;</td>";
			else
				echo "<td align=\"center\"><a href=\" $file1\" target=\"_blank\"><img src=\"../../images/pdf.png\" border=\"0\" /></a></td>";	
			}
			else
			{
				echo  "<td>&nbsp;</td>";
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
      </table></td>
    </tr>
    <tr>
      <td ><div align="right"></div></td>
    </tr>
  </table>
</form>
</body>
</html>