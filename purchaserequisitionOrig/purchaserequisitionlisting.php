<?php
session_start();
include "../Connector.php";
include "authentication.inc";
$backwardseperator ='../';
//$PP_AllowFirstApproval		= true;	 //Assign user permition to first approve 
//$PP_AllowSecondApproval	= true;	//Assign user permition to second approve 

$status 				= $_POST["cboStatus"];
$costCenter 			= $_POST["cboCostCenter"];
$pRNo 					= $_POST["cboPRNo"];
$textPRNo 				= $_POST["txtPRNo"];
$supplier				= $_POST["cboSupplier"];

if ($_POST["txtPRNo"] != "")
	$styleName = $_POST["txtPRNo"];
	
$firstApproveReportname = "rptFirstApproval.php";	
$reportname = "rptSecondApproval.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Purchase Requisition Listing</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="javascript/aprovedPreoder.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<script type="text/javascript" src="javascript/bom.js"></script>
<script type="text/javascript">
function submitForm()
{
	document.frmPurchaserequisitionlisting.submit();
}
</script>
</head>

<body>
<form id="frmPurchaserequisitionlisting" name="frmPurchaserequisitionlisting" method="post" action="purchaserequisitionlisting.php">
    <tr>
      <td><?php include $backwardseperator.'Header.php'; ?></td>
    </tr>
  <table width="96%" border="0" align="center" class="tableBorder" cellpadding="1" cellspacing="0" >
    <tr>
      <td><table width="100%" border="0">
     <tr>
          <td height="25" colspan="2" ><div align="center" class="mainHeading">Purchase Requisition Listing</div></td>
        </tr>
		<tr>
          <td colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="0" class="tableBorder">
            <!--DWLayoutTable-->
            <tr>
              <td width="100%" height="21"><table width="100%" border="0">
                <tr>
                  <td width="72" class="normalfnt">Cost Center</td>
                  <td width="72" ><select name="cboCostCenter" class="txtbox" id="cboCostCenter" style="width:180px">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	 
	$SQL = "SELECT intCompanyID,strName,strComCode FROM companies c where intStatus='1' order by strName;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ." - "." ". $row["strComCode"].""."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="72" class="normalfnt">Supplier</td>
                  <td width="72" ><select name="cboSupplier" class="txtbox" style="width:180px" id="cboSupplier">
                    <option value="" >Select One</option>
<?php
	$SQL = "SELECT strSupplierID,strTitle FROM suppliers s where intStatus='1' order by strTitle;";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($supplier==$row["strSupplierID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
?>
                  </select></td>
                  <td width="72" class="normalfnt">PR No </td>
                  <td width="155" ><select name="cboPRNo" class="txtbox" style="width:180px" id="cboPRNo">
                    <option value="" selected="selected">Select One</option>
<?php	
	$SQL = "select distinct strPRNo from purchaserequisition_header order by strPRNo";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($pRNo == $row["strPRNo"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strPRNo"] ."\">" . $row["strPRNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["strPRNo"] ."\">" . $row["strPRNo"] ."</option>" ;
	}
	?>
                  </select></td>
                  <td width="70" class="normalfnt">Status</td>
                  <td width="150" ><select name="cboStatus" class="txtbox" style="width:150px" id="cboStatus">
                    <option <?php echo ($status==0 ? 'selected="selected"':'')?> value="0">Pending</option>
					<option <?php echo ($status==1 ? 'selected="selected"':'')?> value="1">Send To Approve</option>
					<option <?php echo ($status==2 ? 'selected="selected"':'')?> value="2">Factory Approved</option>
					<option <?php echo ($status==3 ? 'selected="selected"':'')?> value="3">HO Approved</option>
					<option <?php echo ($status==10 ? 'selected="selected"':'')?> value="10">Canceled</option>
                  </select></td>
                  </tr>
                <tr>
                  <td >&nbsp;</td>
                  <td>&nbsp;</td>
                  <td >&nbsp;</td>
                  <td>&nbsp;</td>
                  <td class="normalfnt">PR No Like</td>
                  <td><input name="txtPRNo" type="text" class="txtbox" id="txtPRNo" value="<?php echo $_POST["txtPRNo"]; ?>" style="width:178px"/></td>
                  <td>&nbsp;</td>
                  <td><div align="right"><img src="../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2" class="tableBorder"><div id="divData" style="width:100%; height:550px; overflow: scroll;">
            <table width="100%" border="0" cellpadding="0" cellspacing="1"  id="tblPreOders" bgcolor="#ECD9FF">
              <tr class="mainHeading4">
                <td width="11%" height="25">PR No </td>
                <td width="36%">Supplier</td>
                <td width="2%">Job No </td>
                <td width="5%">Request By </td>
                <td width="5%">Request Date </td>
                <td width="7%">Approved By </td>
                <td width="6%"> Approved Date </td>
				<td width="6%">Factory Approval</td>
                <td width="6%">HO Approved By </td>
                <td width="6%">HO Approved Date </td>
				<td width="6%">HO Approval</td>
                <td width="3%">Job Card </td>                
                <td width="5%">Quatation</td>               
                <td width="3%">BOQ</td>
                <td width="3%">Report</td>
              </tr>
              <?php
$sql = "select concat(PH.intPRYear,'/',PH.intPRNo)as Id,strPRNo,S.strTitle,strJobNo,PH.intStatus,
(select Name from useraccounts UA where UA.intUserID=PH.intRequestBy)as requestBy ,
DATE_FORMAT(PH.dtmRequestDate,'%d-%M-%Y ')as requestDate,
(select Name from useraccounts UA where UA.intUserID=PH.intFirstApprovedBy)as firstApprovedBy ,
DATE_FORMAT(PH.intFirstApprovedDate,'%d-%M-%Y ')as firstApprovedDate,
(select Name from useraccounts UA where UA.intUserID=PH.intSecondApprovedBy)as secondApprovedBy ,
DATE_FORMAT(PH.intSecondApprovedDate,'%d-%M-%Y ')as secondApprovedDate
from purchaserequisition_header PH
inner join suppliers S on S.strSupplierID=PH.intSupplierId where PH.intStatus=$status " ;
			
			
			if ($costCenter != "Select One" and isset($costCenter) )
			{
				$sql .= " and PH.intCompanyId = $costCenter";
			}
			if ($textPRNo != "Select One" && $textPRNo != "" )
			{
				$sql .= " and PH.strPRNo like '%$textPRNo%'";
			}
			if($supplier!="")
			{
				$sql .= " and PH.intSupplierId='$supplier'";
			}
			if($pRNo!="")
			{
				$sql .= " and PH.strPRNo='$pRNo'";
			}
			
			$result = $db->RunQuery($sql);	
			$pos = 0;
			while($row = mysql_fetch_array($result))
			{
			$serialNoArray	= explode('/',$row["Id"]);
				if($row["intStatus"]=='0')
				{
					$firstApproveBy = '-';
					$firstApproveDate = '-';
					$secondApproveBy = '-';
					$secondApproveDate = '-';
				}
				elseif($row["intStatus"]=='1' || $row["intStatus"]=='2')
				{
					$firstApproval	= true;
					$firstApproveBy	= $row["firstApprovedBy"];			
					if (is_null($firstApproveBy)){
						$firstApproveBy = '-';
						$firstApproval	= false;
					}
					
					$firstApproveDate	= $row["firstApprovedDate"];			
					if (is_null($firstApproveDate)){
						$firstApproveDate = '-';
					}
					
					$secondApproval	= true;
					$secondApproveBy	= $row["secondApprovedBy"];			
					if (is_null($secondApproveBy)){
						$secondApproveBy = '-';
						$secondApproval	= false;
					}
					
					$secondApproveDate	= $row["secondApprovedDate"];			
					if (is_null($secondApproveDate)){
						$secondApproveDate = '-';
					}
				}
				elseif($row["intStatus"]=='3')
				{
					$firstApproveBy 		= $row["firstApprovedBy"];
					$firstApproveDate 		= $row["firstApprovedDate"];
					$secondApproveBy 		= $row["secondApprovedBy"];
					$secondApproveDate 		= $row["secondApprovedDate"];
					$firstApproval			= true;
					$secondApproval			= true;
				}
				elseif($row["intStatus"]=='10')
				{
					$firstApproveBy 		= $row["firstApprovedBy"];
					$firstApproveDate 		= $row["firstApprovedDate"];
					$secondApproveBy 		= $row["secondApprovedBy"];
					$secondApproveDate 		= $row["secondApprovedDate"];
					$firstApproval			= true;
					$secondApproval			= true;
				}
			
			?>
              <tr class="<?php 
			  if ($pos % 2 == 0)
					echo "bcgcolor-tblrowWhite";
				else
					echo "bcgcolor-tblrowLiteBlue";
			   ?>">
			   	<?php
			   	if($canModifyAnyCosting)
			   	{
			   	?>
                 <td height="21" class="normalfnt"><a href="purchaserequisition.php?Id=1&No=<?php echo $row["Id"]; ?>" target="purchaserequisition.php" ><?php echo  $row["strPRNo"]; ?></a></td>
                <?php
                }
                else
                {              	
                	echo "<td height=\"20\" class=\"normalfntMid\">".$row["strPRNo"]."</td>";              
                }
                ?>
                <td class="normalfnt"><?php echo  $row["strTitle"]; ?></td>
                <td nowrap="nowrap" class="normalfntMid"><?php echo  $row["strJobNo"];?></td>
                <td nowrap="nowrap" class="normalfnt"><?php echo  $row["requestBy"]; ?></td>
                <td nowrap="nowrap" class="normalfnt"><?php echo  $row["requestDate"]; ?></td>
                <td class="normalfntMid"><?php echo $firstApproveBy;?></td>
                <td nowrap="nowrap" class="normalfntMid"><?php echo $firstApproveDate;?></td>
				
				<?php if(($firstApproval) && ($row["intStatus"]!='0'))
				{					
					$firstAppUrl = "<a href=\"#\">Approved</a>";
				}
				elseif((!$firstApproval) && ($row["intStatus"]!='0'))
				{					
					$firstAppUrl = "<a href=\"$firstApproveReportname?No=".$row["Id"]."\" target=\"rptPR.php\"><img src=\"../images/view2.png\" border=\"0\" class=\"noborderforlink\" /></a>";
				}
				elseif(($row["intStatus"]=='0'))
				{
					$firstAppUrl = "<a href=\"#\"  >&nbsp;</a>";
				}?>
				<?php if($PP_AllowFirstApproval)
						echo "<td nowrap=\"nowrap\" class=\"normalfntMid\">$firstAppUrl</td>";
					else
						echo "<td nowrap=\"nowrap\" class=\"normalfntCentretRedSmall\">No Permission</td>";
				?>
                <td class="normalfntMid"><?Php echo $secondApproveBy;?></td>
                <td nowrap="nowrap" class="normalfntMid"><?Php echo $secondApproveDate;?></td>
								
				<?php if(($secondApproval) && ($row["intStatus"]!='0') && ($row["intStatus"]!='1'))
				{					
					$secondAppUrl = "<a href=\"#\">Approved</a>";
				}
				elseif((!$secondApproval) && ($row["intStatus"]!='0') && ($row["intStatus"]!='1'))
				{				
					$secondAppUrl = "<a href=\"$reportname?No=".$row["Id"]."\" target=\"rptPR.php\"><img src=\"../images/view2.png\" border=\"0\" class=\"noborderforlink\" /></a>";
				}
				elseif(($row["intStatus"]=='0') || ($row["intStatus"]=='1'))
				{
					$firstAppUrl = "<a href=\"#\"  >&nbsp;</a>";
				}
				?>
				<?php 	if($PP_AllowSecondApproval)
							echo "<td nowrap=\"nowrap\" class=\"normalfntMid\">$secondAppUrl</td>";
						else
							echo "<td nowrap=\"nowrap\" class=\"normalfntCentretRedSmall\">No Permission</td>";
				?>
				
<?php
$boo = true;
$file = "";
$url = "../upload files/purchase requestion/". $serialNoArray[0].'-'.$serialNoArray[1]."/jobCard/";

$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$dh = opendir($url);

if(file_exists($url))
{			
	while (($file = readdir($dh)) != false)
	{				
		if($file!='.' && $file!='..'){
			$boo = true;
			$file1	= $file;
		}
		else
			$boo = false;
	}
	
	if($boo)
		echo "<td class=\"normalfntMid\"><a href=\"$url$file1\" target=\"_blank\" ><img src=\"../images/pdf.png\" alt=\"pdf\" border=\"0\"/></a></td>";
	else
		echo "<td class=\"normalfntMid\">-</td>";
}
else
	echo "<td class=\"normalfntMid\">-</td>";	
?>

<?php 
$boo = true;
$file = "";
$url = "../upload files/purchase requestion/". $serialNoArray[0].'-'.$serialNoArray[1]."/Quatation/";

$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$dh = opendir($url);

if(file_exists($url))
{			
	while (($file = readdir($dh)) != false)
	{				
		if($file!='.' && $file!='..'){
			$boo = true;
			$file1	= $file;
		}
		else			
			$boo = false;
	}
	
	if($boo)
		echo "<td class=\"normalfntMid\"><a href=\"$url$file1\" target=\"_blank\" ><img src=\"../images/pdf.png\" alt=\"pdf\" border=\"0\"/></a></td>";
	else
		echo "<td class=\"normalfntMid\">-</td>";
}
else
	echo "<td class=\"normalfntMid\">-</td>";	
?>

<?php
$boo = true;
$file = "";
$url = "../upload files/purchase requestion/". $serialNoArray[0].'-'.$serialNoArray[1]."/BOQ/";

$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$dh = opendir($url);

if(file_exists($url))
{			
	while (($file = readdir($dh)) != false)
	{				
		if($file!='.' && $file!='..'){
			$boo = true;
			$file1	= $file;
		}
		else		
			$boo = false;
	}
	
	if($boo)
		echo "<td class=\"normalfntMid\"><a href=\"$url$file1\" target=\"_blank\" ><img src=\"../images/pdf.png\" alt=\"pdf\" border=\"0\"/></a></td>";
	else
		echo "<td class=\"normalfntMid\">-</td>";
}
else
	echo "<td class=\"normalfntMid\">-</td>";	
?>
				<td class="normalfntMid"><a href="rptPR.php?No=<?php echo $row["Id"]; ?>" target="rptPR.php" ><img src="../images/view2.png" alt="View" title="View report click here" border="0" /></a></td>
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
</form>
</body>
</html>