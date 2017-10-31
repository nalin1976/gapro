<?php
$backwardseperator = "../../";
include '../../Connector.php' ;
session_start();
$styleNo = $_POST["cboStyle"];
$orderNo = $_POST["cboOrderNo"];
$color = $_POST["cboColor"];
$issueNo = $_POST["cboIssueNo"];
$txtIssueNo = $_POST["txtIssueNo"];
$txtOrderNo = $_POST["txtOrderNo"];

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Gapro | Finishing Line Issue In List</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="lineIssueIn.js" language="javascript"></script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td><?php include '../../Header.php';?>
  <tr>
    <td><form name="frmFinishLineIn" method="post" action="lineIssueInList.php" id="frmFinishLineIn">
  
      <table width="800" border="0" cellspacing="0" cellpadding="2" align="center" class="tableFooter">
        <tr>
          <td><table width="800" border="0" cellspacing="0" cellpadding="2">
            <tr>
              <td class="mainHeading" height="25">Finishing Line Issue In List</td>
            </tr>
          </table></td>
        </tr>
       
         <tr>
          <td><table width="800" border="0" cellspacing="1" cellpadding="2" class="tableFooter">
            <tr class="normalfnt">
              <td width="85">Style No</td>
              <td width="266"><select name="cboStyle" id="cboStyle" style="width:250px;" onChange="loadStylewiseOrders();">
            <option value=""></option>
            <?php 
			$SQL = " SELECT DISTINCT O.strStyle
FROM orders O INNER JOIN was_issuestofinishing_header WIFH ON 
O.intStyleId = WIFH.intStyleId 
WHERE O.intStatus<>13 AND WIFH.intStatus=1";
			$result = $db->RunQuery($SQL);
			while($row=mysql_fetch_array($result))
			{
				if($styleNo == $row["strStyle"])
					echo "<option selected value=".$row["strStyle"].">".$row["strStyle"]."</option>\n";
				else	
				 	echo "<option value=".$row["strStyle"].">".$row["strStyle"]."</option>\n";
			}
			?>
            </select></td>
              <td width="128">&nbsp;</td>
              <td width="94">Issue No</td>
              <td width="205"><select name="cboIssueNo" id="cboIssueNo" style="width:200px;">
              <option value=""></option>
              <?php 
			  $SQL = "SELECT CONCAT(FLIH.intFLIssueYear,'/',FLIH.intFLIssueID) AS IssueNo
FROM finishing_lineissue_header FLIH
WHERE FLIH.intStatus=1 ";
				$result = $db->RunQuery($SQL);
			while($row=mysql_fetch_array($result))
			{
				if($issueNo == $row["IssueNo"])
				 	echo "<option selected value=".$row["IssueNo"].">".$row["IssueNo"]."</option>\n";
				else
					echo "<option value=".$row["IssueNo"].">".$row["IssueNo"]."</option>\n";	
			}
			  ?>
              </select></td>
            </tr>
            <tr class="normalfnt">
              <td>Order No</td>
              <td><select name="cboOrderNo" id="cboOrderNo" style="width:250px;" onChange="loadOrderwiseColors();">
            <option value=""></option>
            <?php 
			$SQL = " SELECT  O.intStyleId, O.strOrderNo
FROM orders O INNER JOIN was_issuestofinishing_header WIFH ON 
O.intStyleId = WIFH.intStyleId 
WHERE O.intStatus<>13 AND WIFH.intStatus=1";
			$result = $db->RunQuery($SQL);
			while($row=mysql_fetch_array($result))
			{
				if($orderNo == $row["intStyleId"])
					 echo "<option selected value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>\n";
				else	 
				 	echo "<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>\n";
			}
			?>
            </select></td>
              <td>&nbsp;</td>
              <td>Issue No Like</td>
              <td><input type="text" name="txtIssueNo" id="txtIssueNo" style="width:198px;" value="<?php echo $txtIssueNo; ?>"></td>
            </tr>
            <tr class="normalfnt">
              <td>Color</td>
              <td><select name="cboColor" id="cboColor" style="width:250px;">
             <option value=""></option>
             <?php 
			$SQL = " SELECT DISTINCT WIFH.strColor
FROM  was_issuestofinishing_header WIFH 
WHERE WIFH.intStatus=1";
			$result = $db->RunQuery($SQL);
			while($row=mysql_fetch_array($result))
			{
				if($color == $row["strColor"])
					 echo "<option selected value=".$row["strColor"].">".$row["strColor"]."</option>\n";
				else	 
					 echo "<option value=".$row["strColor"].">".$row["strColor"]."</option>\n";
			}
			?>
            </select></td>
              <td>&nbsp;</td>
              <td>Order No Like</td>
              <td><input type="text" name="txtOrderNo" id="txtOrderNo" style="width:198px;" value="<?php echo $txtOrderNo; ?>"></td>
            </tr>
            <tr class="normalfnt">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right"><img src="../../images/search.png" width="80" height="24" onClick="submitPage();"></td>
            </tr>
          </table></td>
        </tr>
        
        <tr>
          <td><div id="divLineIn" style="width:800px; height:350px; overflow:scroll;">
            <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCFF">
              <tr class="mainHeading4">
                <td width="18%" height="22">Issue No</td>
                <td width="31%">Order No</td>
                <td width="18%">Color</td>
                <td width="14%">Issue Qty</td>
                <td width="19%">Date</td>
              </tr>
              <?php 
			  $sql = "SELECT CONCAT(FLIH.intFLIssueYear,'/',FLIH.intFLIssueID) AS IssueNo,O.strOrderNo,
FLIH.strColor,DATE(FLIH.dtmDate) AS IssueDate,SUM(FLID.dblQty) AS Qty
FROM finishing_lineissue_header FLIH INNER JOIN orders O ON O.intStyleId=FLIH.intStyleId
INNER JOIN finishing_lineissue_details FLID ON 
FLID.intFLIssueID = FLIH.intFLIssueID AND FLID.intFLIssueYear = FLIH.intFLIssueYear ";

			if($styleNo != '')
				$sql .= " and O.strStyle = '$styleNo'";
			if($orderNo != '')
				$sql .= " and O.intStyleId = $orderNo ";
			if($color != '')
				$sql .= " and FLIH.strColor = '$color' ";
			if($issueNo != '')
			{
				$arrIssueNo = explode('/',$issueNo);
				$sql .= " and FLIH.intFLIssueYear=".$arrIssueNo[0]." and FLIH.intFLIssueID = ".$arrIssueNo[1]."";
			}
			if($txtIssueNo != '')
				$sql .= " and  FLIH.intFLIssueID like '%$txtIssueNo%'";
			if($txtOrderNo != '')
				$sql .= " and O.strOrderNo like '%$txtOrderNo%'";
							
			$sql .= " GROUP BY IssueNo ";
			$result = $db->RunQuery($sql);
			while($row=mysql_fetch_array($result))
			{	
			  ?>
              <tr bgcolor="#FFFFFF" class="normalfnt">
                <td height="20"><?php echo $row["IssueNo"] ?></td>
                <td><?php echo $row["strOrderNo"]; ?></td>
                <td><?php echo $row["strColor"]; ?></td>
                <td class="normalfntRite"><?php echo $row["Qty"] ?></td>
                <td><?php echo $row["IssueDate"]; ?></td>
              </tr>
              <?php 
			}
			  ?>
            </table>
          </div></td>
        </tr>
    </table>  </form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>