<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";
include "${backwardseperator}authentication.inc";
$report_companyId =$_SESSION["FactoryID"];

	  $comID = $_GET["fac"];
	  $styleNo = $_GET["sNo"];
	  $styleID = $_GET["oNo"];
	  $issueNofrm = $_GET["cbomMrnNofrom"];
	  $issueNoto = $_GET["cboMrnNoTo"];
	  $dfrom = $_GET["Dfrom"];
	  $dto = $_GET["Dto"];
	  $intyear = $_GET["cboYear"];
	  //$intStatus=$_GET['cboStatus'];
	  $style=$_GET['cboStyle'];
	  $store=$_GET['wasMrn_cboStore'];
	  $reason=$_GET['R'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Gatepass Listing Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<table width="80%" align="center">
	<tr>
    	<td>
        <?php include("{$backwardseperator}reportHeader.php"); ?>
        </td>
    </tr>
    <tr>
    	<td class="head2" >Internal Gatepass Listing Report</td>
    </tr>
</table>
<table align="center" width="70%" rules="all" border="1">
	
    <tr>
    	<td width="13%" class="normalfntBtab">Gatepass No</td>
        <td width="15%" class="normalfntBtab">PO No</td>
        <td width="18%" class="normalfntBtab">Style No</td>
        <td width="18%" class="normalfntBtab">Color</td>
        <td width="18%" class="normalfntBtab">Reason</td>
        <td width="10%" class="normalfntBtab">Date</td>
        <td width="8%" class="normalfntBtab">Qty</td>
    </tr>
    <?php 
	$sqlIssue = " SELECT
										orders.strOrderNo,
										orders.strStyle,
										w.dblQty,
										w.strColor,
										w.dtmDate,
										concat(w.intYear,'/',w.dblGPNo) AS gp,
										w.intYear,
										w.dblGPNo,
										was_washformula.strProcessName,
										was_washformula.intSerialNo
										FROM
										was_issuedtootherfactory AS w
										INNER JOIN orders ON orders.intStyleId = w.intStyleId
										LEFT JOIN was_washformula ON w.intReason = was_washformula.intSerialNo
										WHERE
										w.intCompanyId='".$_SESSION['FactoryID']." '
										";
						
						
						if($comID != '')
							$sqlIssue .= "  and w.intToFactory= '$comID' ";
							
						if($style != '')
							$sqlIssue .= " and orders.strStyle = '$style' ";
											
						if($styleID != '')
							$sqlIssue .= " and  w.intStyleId= '$styleID' ";
						
						if($dfrom != '')
							$sqlIssue .= " and  date(w.dtmDate) >= '$dfrom' ";
							
						if($dto != '')
							$sqlIssue .= " and  date(w.dtmDate) <= '$dto' ";
						
						if($reason != '')
						   $sqlIssue .= " and  was_washformula.intSerialNo = '$reason' ";
							
						$sqlIssue .= " order by gp; ";	
						$result = $db->RunQuery($sqlIssue);
					$totQty=0;
						while($row = mysql_fetch_array($result))
						{ ?>
						<tr>
							<td width="13%" class="normalfnt"><?php echo $row['gp'];?></td>
							<td width="15%" class="normalfnt"><?php echo $row['strOrderNo'];?></td>
							<td width="18%" class="normalfnt"><?php echo $row['strStyle'];?></td>
							<td width="18%" class="normalfnt"><?php echo $row['strColor'];?></td>
							<td width="18%" class="normalfnt"><?php echo $row['strProcessName'];?></td>
							<td width="10%" class="normalfnt"><?php echo substr($row['dtmDate'],0,10);?></td>
							<td width="8%" class="normalfntRite"><?php echo $row['dblQty'];$totQty+=$row['dblQty'];?></td>
						</tr>
						<?php  } ?>
                        <tr>
							<td width="13%" class="normalfnt">&nbsp;</td>
							<td width="15%" class="normalfnt">&nbsp;</td>
							<td width="18%" class="normalfnt">&nbsp;</td>
							<td width="18%" class="normalfnt">&nbsp;</td>
							<td width="18%" class="normalfnt">&nbsp;</td>
							<td width="10%" class="normalfnt">&nbsp;</td>
							<td width="8%" class="normalfntRite"><?php echo $totQty; ?></td>
						</tr>
                        
</table>
<table  align="center" width="70%" >
	<tr>
    	<td width="11%">&nbsp;</td>
    	<td width="17%"></td>
        <td width="72%"></td>
    </tr>
	<tr>
    	<td width="11%"></td>
    	<td width="17%" align="center" class="normalfntMid"><?php getUser();?></td>
        <td width="72%"></td>
    </tr>
    <tr style="height:5px;">
    	<td></td>
    	<td class="normalfntMid">.............................</td>
        <td></td>
    </tr>
    <tr>
    	<td></td>
    	<td class="normalfntMid">Prepared by</td>
        <td></td>
    </tr>
    <tr>
    	<td class="normalfntMid"></td>
    	<td class="normalfntMid"><?php echo date('Y-d-m');?></td>
        <td></td>
    </tr>
    <tr style="height:5px;">
    	<td></td>
    	<td class="normalfntMid">.............................</td>
        <td></td>
    </tr>
    <tr>
    	<td class="normalfntMid"></td>
    	<td class="normalfntMid">Date</td>
        <td></td>
    </tr>
</table>
<?php
function getUser(){
	global $db;
	$sql="select Name from useraccounts where intUserId=".$_SESSION['UserID'];	
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_assoc($res);
	echo $row['Name'];
}
?>
</body>
</html>
