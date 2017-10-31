<?php
 session_start();
 include "Connector.php";
 include "authentication.inc";
 $backwardseperator ='';
$factory = $_POST["cboFactory"];
$buyer = $_POST["cboCustomer"];
$styleNo = $_POST["cboOrderNo"];
$styleID = $_POST["cboStyles"];
$srNo = $_POST["cboSR"];
$merchant = $_POST["cboMerchandiser"];

//$allowFirstApprovalPreOrder =true;
//$allowSecondApprovalPreOrder =true;

if ($factory != "Select One")
{
	$styleID = "Select One";
	$srNo = "Select One";
}

if ($_POST["txtStyle"] != "")
	$styleName = $_POST["txtStyle"];

$reportname = "preorderReportApprove.php";
$firstApproveReportname = "preorderReportFirstApprove.php";	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Approved Cost Sheets</title>
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
	document.getElementById("cboFactory").value = 0;
	document.getElementById("cboCustomer").value = "Select One";
}

function submitForm()
{
	document.frmcomplete.submit();
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

function getStyleIDtoCombo(obj)
{
	document.getElementById('cboStyles').value = obj.value;
}

function getSctoCombo(obj)
{
	document.getElementById('cboSR').value = obj.value;
}

function GetOrderNo(obj)
{
	var buyerId	= document.getElementById('cboCustomer').value;
	var url="preordermiddletire.php?RequestType=GetApPenCoSheetOrderNo&styleNo="+obj+"&buyerId="+buyerId;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboStyles').innerHTML = htmlobj.responseText;
}
function GetScNo(obj)
{
	var buyerId	= document.getElementById('cboCustomer').value;
	var url="preordermiddletire.php?RequestType=GetApPenCoSheetScNo&styleNo="+obj+"&buyerId="+buyerId;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboSR').innerHTML = htmlobj.responseText;
}

function LoadBuyerWiseDetails(obj)
{
	var url="preordermiddletire.php?RequestType=GetApPenCoSheetStyleNo&buyerId="+obj;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboOrderNo').innerHTML = htmlobj.responseText;
	GetOrderNo(document.getElementById('cboOrderNo').value);
	GetScNo(document.getElementById('cboOrderNo').value);
}
</script>
</head>

<body>
<form id="frmcomplete" name="frmcomplete" method="post" action="pendingCostSheets.php">
    <tr>
      <td><?php include $backwardseperator.'Header.php'; ?></td>
    </tr>
  <table width="96%" border="0" align="center" class="bcgl1" height="500">

    <tr>
      <td><table width="100%" border="0">
     <tr>
          <td colspan="2" bgcolor="#316895"><div align="center" class="mainHeading">Approval Pending Cost Sheets</div></td>
        </tr>
		<tr>
          <td colspan="2"><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="100%" height="21"><table width="100%" border="0">
                <tr>
                  <td width="72" bgcolor="#99CCFF" class="txtbox">Buyer</td>
                  <td width="72" class="txtbox"><select name="cboCustomer" class="txtbox" style="width:180px" id="cboCustomer" onchange="LoadBuyerWiseDetails(this.value);">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT intBuyerID, strName FROM buyers where intStatus=1 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		if ($buyer == $row["intBuyerID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
		}
	}
	
	?>
                  </select></td>
                  <td width="72" bgcolor="#99CCFF" class="txtbox">Style No </td>
                  <td width="72" class="txtbox"><select name="cboOrderNo" class="txtbox" style="width:180px" id="cboOrderNo" onchange="GetOrderNo(this.value);GetScNo(this.value)">
                    <option value="" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select distinct strStyle,strStyle from orders where orders.intStatus = 10 order by strStyle;";
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
                  </select></td>
                  <td width="72" bgcolor="#99FF66" class="txtbox">Order No </td>
                  <td width="155" class="txtbox"><select name="cboStyles" class="txtbox" style="width:180px" id="cboStyles" onchange="resetCompanyBuyer();getSctoCombo(this);">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select O.intStyleId,O.strOrderNo from orders O where O.intStatus = 10 ";
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
                  </select></td>
                  <td width="70" bgcolor="#99FF66" class="txtbox">Sc No</td>
                  <td width="150" class="txtbox"><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="getStyleIDtoCombo(this);resetCompanyBuyer();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select S.intSRNO,O.intStyleId from specification S inner join orders O on S.intStyleId = O.intStyleId AND O.intStatus = 10 ";
	
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
                  <td width="72" bgcolor="#99CCFF" class="txtbox">Factory</td>
                  <td>
                    <select name="cboFactory" class="txtbox" id="cboFactory" style="width:180px">
                      <option value="Select One" selected="selected">Select One</option>
                      <?php
	 
	$SQL = "SELECT intCompanyID,strName,strCity FROM companies c where intStatus='1' and intManufacturing=1;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($factory == $row["intCompanyID"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ." - "." ". $row["strCity"].""."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ." - "." ". $row["strCity"].""."</option>" ;
		}
	}
	
	?>
                    </select>                  </td>
                  <td bgcolor="#99CCFF" class="txtbox">Merchandiser</td>
                  <td><select name="cboMerchandiser" class="txtbox" style="width:180px"  id="cboMerchandiser">
                          <option value="0" selected="selected" >Select One</option>
                          <?php


	$SQL = "SELECT useraccounts.Name, useraccounts.intUserID FROM useraccounts INNER JOIN userpermission ON useraccounts.intUserID = userpermission.intUserID INNER JOIN role ON userpermission.RoleID = role.RoleID WHERE role.RoleName = 'Merchandising' order by useraccounts.Name"; 

	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		if ($merchant ==  $row["intUserID"])
			echo "<option selected=\"selected\" value=\"". $row["intUserID"] ."\">" . $row["Name"] ."</option>" ;
		else
			echo "<option value=\"". $row["intUserID"] ."\">" . $row["Name"]  ."</option>" ;
	}
	
	?>
                        </select></td>
                  <td bgcolor="#99FF66" class="txtbox">Like</td>
                  <td><input name="txtStyle" type="text" class="txtbox" id="txtStyle" value="<?php echo $_POST["txtStyle"]; ?>" /></td>
                  <td>&nbsp;</td>
                  <td><div align="right"><img src="images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="submitForm();" /></div></td>
                  </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><div id="divData" style="width:100%; height:550px; overflow: scroll; border-width:3px; border-style:solid;border-color:#99CCFF;">
            <table width="100%" border="0" cellpadding="0" cellspacing="1" class="bcgl1" id="tblPreOders" bgcolor="#ECD9FF">
              <tr>
                <td width="19%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">Order No</td>
                <td width="24%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
                <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Company</td>
                <td width="19%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer</td>
                <td bgcolor="#498CC2" class="normaltxtmidb2">Created By</td>
                <td bgcolor="#498CC2" class="normaltxtmidb2">Created Date</td>
                <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">First Approve By </td>
                <td bgcolor="#498CC2" class="normaltxtmidb2">First Approve Date </td>
                <td bgcolor="#498CC2" class="normaltxtmidb2">First Approve</td>
                <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Second Approve By</td>
                <td bgcolor="#498CC2" class="normaltxtmidb2">Second Approve Date</td>
                
                <td bgcolor="#498CC2" class="normaltxtmidb2">Second Approve </td>
               
              </tr>
              <?php
$sql = "SELECT O.strOrderNo,O.strStyle,O.intStyleId,strDescription, C.strComCode, buyers.strName,intQty,O.dtmDate,
(select Name from useraccounts UA where UA.intUserID=O.intUserID)as createdUserId,
(select Name from useraccounts UA where UA.intUserID=O.intFirstApprovedBy)as firstApprovedUser,
O.dtmFirstAppDate,
(select Name from useraccounts UA where UA.intUserID=O.intApprovedBy)as secondApprovedUser,
O.dtmAppDate
FROM orders O
INNER JOIN companies C ON O.intCompanyID = C.intCompanyID 
INNER JOIN buyers ON O.intBuyerID = buyers.intBuyerID  WHERE O.intStatus = 10 " ;
			
			
			if ($factory != "Select One" and isset($factory) )
			{
				$sql .= " and O.intCompanyID = $factory";
			}
			if ($buyer != "Select One" && $buyer != "" )
			{
				$sql .= " and O.intBuyerID = $buyer";
			}
			if ($styleID != "Select One" && $styleID != "" )
			{
				$sql .= " and O.intStyleId = '$styleID'";
			}
			if($merchant != 0)
			{
				$sql .= " and O.intCoordinator = $merchant "; 
			}
			if($styleName != "")
			{
				$sql .= " and O.strOrderNo like '%$styleName%'";
			}			
			if($styleNo != "")
			{
				$sql .= " and O.strStyle='$styleNo'";
			}
				$sql .= " order by dtmDate desc ";		
			
			$result = $db->RunQuery($sql);	
			$pos = 0;
			while($row = mysql_fetch_array($result))
			{
				$styleName	= $row["strOrderNo"];
				$styleId 	= $row["intStyleId"];
				
				$firstApproval	= true;
				$firstApproveBy	= $row["createdUserId"];			
				if (is_null($firstApproveBy)){
					$firstApproveBy = '-';
					$firstApproval	= false;
				}
				
				$firstApproveDate	= $row["dtmDate"];			
				if (is_null($firstApproveDate)){
					$firstApproveDate = '-';
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
                 <td height="21" class="normalfnt"><a href="editpreorder.php?StyleNo=<?php echo  $row["intStyleId"]; ?>" target="_blank"><?php echo  $row["strOrderNo"]; ?></a></td>
                <?php
                }
                else
                {              	
                	echo "<td height=\"21\" class=\"normalfntMid\">$styleName</td>";              
                }
                ?>
                <td class="normalfnt"><?php echo  $row["strDescription"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strComCode"]; ?></td>
                <td class="normalfnt"><?php echo  $row["strName"]; ?></td>
                <td nowrap="nowrap" class="normalfntMid"><?php echo  $row["createdUserId"];?></td>
                <td nowrap="nowrap" class="normalfnt"><?php echo  $row["dtmDate"]; ?></td>
                <td class="normalfntMid"><?php echo $firstApproveBy;?></td>
                <td nowrap="nowrap" class="normalfntMid"><?php echo $firstApproveDate;?></td>
				
				<?php if(($allowFirstApprovalPreOrder) && ($firstApproval)){					
					$firstAppUrl = "<a href=\"#\"  >Approved</a>";
				}else{					
					$firstAppUrl = "<a href=\"$firstApproveReportname?styleID=$styleId\" target=\"_blank\"><img src=\"images/view2.png\" border=\"0\" class=\"noborderforlink\"/></a>";
				}?>
				<?php if($allowFirstApprovalPreOrder)
						echo "<td nowrap=\"nowrap\" class=\"normalfntMid\">$firstAppUrl</td>";
					else
						echo "<td nowrap=\"nowrap\" class=\"normalfntMid\">No Permission</td>";
				?>
                <td class="normalfntMid"><?Php echo $secondApproveBy;?></td>
                <td nowrap="nowrap" class="normalfntMid"><?Php echo $secondApproveDate;?></td>
								
				<?php if(($allowSecondApprovalPreOrder) && (!$firstApproval)){					
					$secondAppUrl = "<a href=\"#\"></a>";
				}else{				
					$secondAppUrl = "<a href=\"$reportname?styleID=$styleId\" target=\"_blank\"><img src=\"images/view2.png\" border=\"0\" class=\"noborderforlink\"/></a>";
				}?>
				<?php 	if($allowSecondApprovalPreOrder)
							echo "<td nowrap=\"nowrap\" class=\"normalfntMid\">$secondAppUrl</td>";
						else
							echo "<td nowrap=\"nowrap\" class=\"normalfntMid\">No Permission</td>";
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
      <td><div align="right"></div></td>
    </tr>
  </table>
</form>
</body>
</html>
