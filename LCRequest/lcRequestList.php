<?php 
session_start();
	$backwardseperator = "../";
	include "../authentication.inc";
	include "../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	
	$intStatus = $_POST["cboStatus"];
	 //$allowLCFirstApprove = true; // allow first approval permission
	 //$allowLCSecondApprove = true; //allow second approval permission
	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Internal LC Request</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<link href="../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css"/>
<link href="../javascript/calendar/theme.css" rel="stylesheet" type="text/css"/>
<script src="../javascript/script.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function loadLCListData()
{
	document.getElementById("frmLcReqList").submit();
}
</script>
</head>

<body>
<form id="frmLcReqList" name="frmLcReqList" method="post" action="lcRequestList.php">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
 
  <tr>
    <td><table width="950" border="0" cellspacing="0" cellpadding="2" align="center" class="tableBorder">
      <tr>
        <td colspan="4" class="mainHeading" height="25">Internal L/C Request List </td>
        </tr>
      <tr>
        <td width="85">&nbsp;</td>
        <td width="380">&nbsp;</td>
        <td width="115">&nbsp;</td>
        <td width="252">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">Status</td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="42%"><select name="cboStatus" id="cboStatus" style="width:130px;" onChange="loadLCListData();">
				<option value="0" <?php echo ($intStatus == 0 ? "selected=\"selected\"":"") ?>>Pending</option>
				<option value="1" <?php echo ($intStatus == 1 ? "selected=\"selected\"":"") ?>>Send to Approval</option> 
				<option value="2" <?php echo ($intStatus == 2 ? "selected=\"selected\"":"") ?>>First Approved</option>
				<option value="3" <?php echo ($intStatus == 3 ? "selected=\"selected\"":"") ?>>Second Approved</option>
            </select>            </td>
            <td width="58%">&nbsp;</td>
          </tr>
        </table></td>
        <td class="normalfnt">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" valign="top"><div id="divLC" style="overflow:scroll; width:100%; height:350px;">
          <table width="100%" border="0" cellspacing="1" cellpadding="0" id="tblMain" bgcolor="#CCCCFF" >
          <thead>
            <tr class="mainHeading4">
            <th width="10%">LC No</th>
              <th width="12%" height="20" >LC Name</th>
              <th width="17%">Created Date</th>
              <th width="10%">First Approve By</th>
               <th width="12%">First Approve Date</th>
               <th width="7%">First Approve</th>
               <th width="11%">Second Approve By</th>
                <th width="12%">Second Approve Date</th>
                <th width="9%">Second Approve</th>
                
            </tr>
            </thead>
            <?php 
			
			$sql = "select lc.intLCRequestNo,lc.intRequestYear,lc.lcRequestName,lc.dtmDate,lc.intStatus,
(select ua.Name from useraccounts ua where ua.intUserID = lc.intFirstApprovedBy) as intFirstApprovedBy,
lc.dtmFirstAppDate,lc.dtmConfirmedDate,
(select ua.Name from useraccounts ua where ua.intUserID = lc.intConfirmedBy) as intConfirmedBy
from lcrequest_pialloheader lc where lc.intStatus= '$intStatus'";
			
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				$status = $row["intStatus"];
				$firstApproval	= true;
				$firstApproveBy	= $row["intFirstApprovedBy"];			
				if (is_null($firstApproveBy)){
					$firstApproveBy = '-';
					$firstApproval	= false;
				}
				
				$firstApproveDate	= $row["dtmFirstAppDate"];			
				if (is_null($firstApproveDate)){
					$firstApproveDate = '-';
				}
				
				$secondApproval	= true;
				$secondApproveBy	= $row["intConfirmedBy"];			
				if (is_null($secondApproveBy)){
					$secondApproveBy = '-';
					$secondApproval	= false;
				}
				
				$secondApproveDate	= $row["dtmConfirmedDate"];			
				if (is_null($secondApproveDate)){
					$secondApproveDate = '-';
				}
				
				$lcNo = $row["intRequestYear"].'/'.$row["intLCRequestNo"];	
				//lc request in send to approval are allow fist approval
				/*if($status != 1)
					$firstApproval	= false;		*/
			?>
             <tr  class="normalfnt" bgcolor="#FFFFFF">
            <td width="10%"><a href="editLcRequest.php?lcNo=<?php echo  $row["intRequestYear"].'/'.$row["intLCRequestNo"] ?>" target="_blank"><?php echo  $row["intRequestYear"].'/'.$row["intLCRequestNo"] ?></a></td>
              <td width="12%" height="20" ><?php echo $row["lcRequestName"]; ?></td>
              <td width="17%"><?php echo $row["dtmDate"]; ?></td>
              <td width="10%"><?php echo $firstApproveBy; ?></td>
               <td width="12%"><?php echo $firstApproveDate; ?></td>
               <?php
			   
				if(($firstApproval) && ($status !=0))
				{
					$firstAppUrl = "<a href=\"#\"  >Approved</a>";
				}
				else if ((!$firstApproval) && ($status !=0))
				{	
				 $firstAppUrl = "<a href=\"lcRequestReport.php?lcNo=$lcNo\" target=\"_blank\"><img src=\"../images/view2.png\" border=\"0\" class=\"noborderforlink\"/></a>";
				 }
				else if($status == '0')
				{
					$firstAppUrl = "<a href=\"#\"  >&nbsp;</a>";
					}
				
				if(!$allowLCFirstApprove && ($status ==1))
					echo "<td nowrap=\"nowrap\" class=\"normalfntCentretRedSmall\">No Permission</td>";
				else
					echo "<td nowrap=\"nowrap\" >$firstAppUrl</td>";	
				?>
             
               <td width="11%"><?php echo $secondApproveBy; ?></td>
                <td width="12%"><?php echo $secondApproveDate; ?></td>
                <?php 
				
				if(($secondApproval) && ($row["intStatus"]!='0') && ($row["intStatus"]!='1'))
				{					
					$secondAppUrl = "<a href=\"#\">Approved</a>";
				}
				elseif((!$secondApproval) && ($row["intStatus"]!='0') && ($row["intStatus"]!='1'))
				{				
					$secondAppUrl = "<a href=\"lcRequestReport.php?lcNo=$lcNo\" target=\"_blank\"><img src=\"../images/view2.png\" border=\"0\" class=\"noborderforlink\"/></a>";
				}
				elseif(($row["intStatus"]=='0') || ($row["intStatus"]=='1'))
				{
					$firstAppUrl = "<a href=\"#\"  >&nbsp;</a>";
				}
				
				if(!$allowLCSecondApprove && ($status ==2))
					echo "<td nowrap=\"nowrap\" class=\"normalfntCentretRedSmall\">No Permission</td>";
				else
					echo "<td nowrap=\"nowrap\" >$secondAppUrl</td>";
				?>
              <!--  <td width="9%"><?php //echo $secondAppUrl; ?></td>-->
                
            </tr>
            <?php 
			}
			?>
           </table>  </div>     </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<script src="lcRequest.js" language="javascript" type="text/javascript"></script>
<script src="../js/jquery.fixedheader.js" type="text/javascript" language="javascript"></script>
</body>
</html>
