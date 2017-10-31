<?php
session_start();
include "authentication.inc";
$backwardseperator ='../';
include "../Connector.php";
$styleNo = $_POST["cboStyleNo"];
$styleID = $_POST["cboOrderNo"];
$status = $_POST["cboStatus"];
$status =($status == ''?0:$status);
//$allowRecutFirstApprove= true;
//$allowRecutSecondApprove= true;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro - Approval Pending Recut</title>
<link href="../css/erpstyle.css" rel="stylesheet"/>
<link href="../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css"/>

<script language="javascript" src="../javascript/script.js"></script>
</head>

<body>
<form name="frmPenRecut" method="post" id="frmPenRecut" action="pendingRecutList.php">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td><?php include $backwardseperator.'Header.php';?></td>
    </tr>
    <tr>
      <td><table width="90%" border="0" cellspacing="0" cellpadding="2" align="center" class="bcgl1">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="mainHeading" height="25">Approval Pending Recut</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="1">
                <tr class="normalfnt">
                  <td width="2%" >&nbsp;</td>
                  <td width="12%" >Recut No</td>
                  <td width="11%"><input type="text" name="txtRecutNo" id="txtRecutNo" style="width:100px;"></td>
                  <td width="15%"><select name="cboYear" id="cboYear" style="width:90px;" onChange="loadRecutNoList();">
                  <?php
			for ($loop = date("Y")+1 ; $loop >= 2008; $loop --)
			{
				if($loop==date("Y"))
					echo "<option  value=\"$loop\" selected=\"selected\">$loop</option>";
				else	
					echo "<option value=\"$loop\">$loop</option>";
			}
			?>
                  </select>                  </td>
                  <td width="7%">Style No</td>
                  <td width="17%"><select name="cboStyleNo" id="cboStyleNo" style="width:150px;" onChange="getStyleWiseOrderNo();">
                   <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select distinct strStyle,strStyle from orders where orders.intStatus = 11 order by strStyle;";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($styleNo==  $row["strStyle"])
		{
			echo "<option selected=\"selected\" value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	?>
                  </select>                  </td>
                  <td width="6%">Order No</td>
                  <td width="16%"><select name="cboOrderNo" id="cboOrderNo" style="width:150px;" onChange="getSCno();">
                  <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select O.intStyleId,O.strOrderNo from orders O where O.intStatus = 11 ";
	if($styleNo!="")
		$SQL .="and O.strStyle='$styleNo' ";
	$SQL .= "order by O.strOrderNo";
		
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
                  </select>                  </td>
                  <td width="4%">SC No</td>
                  <td width="10%"><select name="cboScNo" id="cboScNo" style="width:80px;" onChange="getOrderNo();">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select S.intSRNO,O.intStyleId from specification S inner join orders O on S.intStyleId = O.intStyleId AND O.intStatus = 11 ";
	
	if($styleNo!="")
		$SQL .="and O.strStyle='$styleNo' ";
	
	$SQL .="order by S.intSRNO desc";
	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		if ($srNo==  $row["intSRNO"])
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
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Status</td>
                  <td><select name="cboStatus" id="cboStatus" style="width:101px;" onChange="loadRecutNoList();">
                   <option <?php echo ($status==0 ? 'selected="selected"':'')?> value="0">Pending</option>
					<option <?php echo ($status==1 ? 'selected="selected"':'')?> value="1">Send To Approve</option>
					<option <?php echo ($status==2 ? 'selected="selected"':'')?> value="2">First Approved</option>
					<option <?php echo ($status==3 ? 'selected="selected"':'')?> value="3">Confirmed</option>
			        </select>                  </td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><img src="../images/search.png" width="80" height="24" onClick="submitPage();"></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
             <tr>
              <td><div id="divData" style="overflow:scroll; height:350px; width:100%">
			  <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF">
                <tr class="mainHeading4">
                  <td height="20">Recut No</td>
                  <td >Order No</td>
                  <td >Description</td>
                  <td >Created By</td>
                  <td >Created Date</td>
                  <td >First Approve By</td>
                  <td >First Approved Date</td>
                  <td >First Approve</td>
                  <td >Second Approve By</td>
                  <td >Second Approve Date</td>
                  <td >Second Approve</td>
                  <td >Report</td>
                </tr>
                <?php 
				$sql = "select orc.intRecutNo,orc.intRecutYear,orc.intStyleId,o.strOrderNo,o.strDescription,
(select u.Name from useraccounts u where u.intUserID = orc.intUserID) as createdUser,orc.dtmRecutDate,
orc.intFirstApprovedBy,orc.dtmFirstAppDate,orc.intStyleId,
(select u.Name from useraccounts u where u.intUserID = orc.intFirstApprovedBy)  as firstAppUser,
orc.intConfirmedBy,orc.dtmConfirm,orc.intStatus,
(select u.Name from useraccounts u where u.intUserID = orc.intConfirmedBy)  as confirmBy
from orders o inner join orders_recut orc on o.intStyleId = orc.intStyleId 
where orc.intStatus ='$status' ";
			if($styleNo != '')
				$sql .= " o.strStyle = '$styleNo'";
			if($styleID != '')
				$sql .= " o.intStyleId = '$styleID'";	
	$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{
		$recutStatus = $row["intStatus"];
		$styleId = $row["intStyleId"];	
		
		$firstApproval	= true;
		$firstApproveBy	= $row["firstAppUser"];			
		if (is_null($firstApproveBy)){
			$firstApproveBy = '-';
			$firstApproval	= false;
		}
		
		$firstApproveDate	= $row["dtmFirstAppDate"];			
		if (is_null($firstApproveDate)){
			$firstApproveDate = '-';
		}
		
		$secondApproval	= true;
		$secondApproveBy	= $row["confirmBy"];			
		if (is_null($secondApproveBy)){
			$secondApproveBy = '-';
			$secondApproval	= false;
		}
		
		$secondApproveDate	= $row["dtmConfirm"];			
		if (is_null($secondApproveDate)){
			$secondApproveDate = '-';
		}
		$recutNo = 	$row["intRecutYear"].'/'.$row["intRecutNo"];
				?>
                <tr bgcolor="#FFFFFF">
                <?php 
				if($recutStatus == 0)
				{
					$url = "recutpreorder.php?StyleNo=$styleId&recutNo=".$row["intRecutNo"]."&recutYear=".$row["intRecutYear"];
				?>
                <td nowrap="nowrap" height="20" class="normalfnt">&nbsp;<a href="<?php echo $url; ?>" target="_blank"><?php echo $row["intRecutYear"].'/'.$row["intRecutNo"]; ?></a>&nbsp;</td>
                <?php 
				}
				else
				{
				?>
                  <td nowrap="nowrap" class="normalfnt"><?php echo $row["intRecutYear"].'/'.$row["intRecutNo"]; ?></td>
                 <?php 
				 }
				 ?> 
                  <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strOrderNo"]; ?>&nbsp;</td>
                  <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strDescription"]; ?>&nbsp;</td>
                  <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["createdUser"]; ?>&nbsp;</td>
                  <td nowrap="nowrap" class="normalfntMid">&nbsp;<?php echo $row["dtmRecutDate"]; ?>&nbsp;</td>
                  <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $firstApproveBy; ?>&nbsp;</td>
                  <td nowrap="nowrap" class="normalfntMid">&nbsp;<?php echo $firstApproveDate; ?>&nbsp;</td>
                 <?php 
				 if(($firstApproval) && ($status !=0))
				{
					$firstAppUrl = "<a href=\"#\"  >Approved</a>";
				}
				else if ((!$firstApproval) && ($status !=0))
				{	
				 $firstAppUrl = "<a href=\"recutFirstApproveReport.php?recutNo=$recutNo\" target=\"_blank\"><img src=\"../images/view2.png\" border=\"0\" class=\"noborderforlink\"/></a>";
				 }
				else if($status == '0')
				{
					$firstAppUrl = "<a href=\"#\"  >&nbsp;</a>";
				}
				
				if(!$allowRecutFirstApprove && ($status ==1))
					echo "<td nowrap=\"nowrap\" class=\"normalfntCentretRedSmall\">No Permission</td>";
				else
					echo "<td nowrap=\"nowrap\" class=\"normalfntMid\">$firstAppUrl</td>";
				 ?>
                  <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $secondApproveBy; ?>&nbsp;</td>
                  <td nowrap="nowrap" class="normalfntMid">&nbsp;<?php echo $secondApproveDate; ?>&nbsp;</td>
                
                   <?php 
				
				if(($secondApproval) && ($row["intStatus"]!='0') && ($row["intStatus"]!='1'))
				{					
					$secondAppUrl = "<a href=\"#\">Approved</a>";
				}
				elseif((!$secondApproval) && ($row["intStatus"]!='0') && ($row["intStatus"]!='1'))
				{				
					$secondAppUrl = "<a href=\"confirmRecutReport.php?recutNo=$recutNo\" target=\"_blank\"><img src=\"../images/view2.png\" border=\"0\" class=\"noborderforlink\"/></a>";
				}
				elseif(($row["intStatus"]=='0') || ($row["intStatus"]=='1'))
				{
					$firstAppUrl = "<a href=\"#\"  >&nbsp;</a>";
				}
				
				if(!$allowRecutSecondApprove && ($status ==2))
					echo "<td nowrap=\"nowrap\" class=\"normalfntCentretRedSmall\">No Permission</td>";
				else
					echo "<td nowrap=\"nowrap\" class=\"normalfntMid\">$secondAppUrl</td>";
				?>
				<td nowrap="nowrap" class="normalfntMid"><a href="recutReport.php?recutNo=<?php echo $row["intRecutYear"].'/'.$row["intRecutNo"] ?>" target="recutReport.php"><img src="../images/view2.png" border="0" class="noborderforlink"/></a></td>
                </tr>
             <?php 
	}
			 ?>   
              </table>
              </div></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<script language="javascript" type="text/javascript">
$(document).ready(function() 
{
	var status=0;
	var intYear = '';
	var url					='recutpreorderdb.php?RequestType=recutNoList&status='+status+'&intYear='+intYear;
		var htmlobj	=$.ajax({url:url,async:false});
		var htmlobjResponse			=htmlobj.responseXML.getElementsByTagName("recutNo")[0].childNodes[0].nodeValue;
		var pub_po_arr = htmlobjResponse.split("|");
		
		$( "#txtRecutNo" ).autocomplete({
			source: pub_po_arr
		});
			
});
function loadRecutNoList()
{
	var status=document.getElementById('cboStatus').value;
	var intYear = document.getElementById('cboYear').value;
	
	var url					='recutpreorderdb.php?RequestType=recutNoList&status='+status+'&intYear='+intYear;
		var htmlobj	=$.ajax({url:url,async:false});
		var htmlobjResponse			=htmlobj.responseXML.getElementsByTagName("recutNo")[0].childNodes[0].nodeValue;
		var pub_po_arr = htmlobjResponse.split("|");
		
		$( "#txtRecutNo" ).autocomplete({
			source: pub_po_arr
		});
}
function submitPage()
{
	document.getElementById('frmPenRecut').submit();
}
function getSCno()
{
	document.getElementById('cboScNo').value = document.getElementById('cboOrderNo').value;
}
function getOrderNo()
{
	document.getElementById('cboOrderNo').value = document.getElementById('cboScNo').value;
}
function getStyleWiseOrderNo()
{
	var styleName = document.getElementById('cboStyleNo').value;
	var chkUser ='FALSE';
	var url = "recutpreorderdb.php?RequestType=getStyleWiseData&styleName="+URLEncode(styleName)+"&chkUser="+chkUser;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboOrderNo').innerHTML = htmlobj.responseXML.getElementsByTagName("OrderNoList")[0].childNodes[0].nodeValue;
	document.getElementById('cboScNo').innerHTML = htmlobj.responseXML.getElementsByTagName("SCNolist")[0].childNodes[0].nodeValue;
}
</script>
</body>
</html>
