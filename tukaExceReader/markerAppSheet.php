<?php
include "../Connector.php";

$marker = $_GET["marker"];
$report_companyId  = $_SESSION["FactoryID"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Marker Approval Sheet</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%">
<tr>
 <td width="100%"><?php include "../reportHeader.php";?></td>
</tr>
</table>
<br>
<table width="100%" border='1' align='center' CELLPADDING=3 CELLSPACING=1  RULES=COLS,ROWS FRAME=BOX >
<thead>
 <tr>
  <td class="normalfntMid"><b>DATE</b></td>
  <td class="normalfntMid"><b>COMMENTS</b></td>
  <td class="normalfntMid"><b>MARKER NAME</b></td>
  <td class="normalfntMid"><b>PTTN NAME</b></td>
  <td class="normalfntMid"><b>STYLE</b></td>
  <td class="normalfntMid"><b>DIV</b></td>
  <?php
   $sql = "SELECT distinct
			markerdetails.strSize
			FROM
			markerheader
			Inner Join markerdetails ON markerheader.intSerialNo = markerdetails.intSerialNo
			WHERE
			markerheader.strMarkerName =  '$marker'";
   $result=$db->RunQuery($sql);
   $a=0;
   	while($row = mysql_fetch_array($result))
	{
	 $strSize = $row["strSize"];
	 $a++;
	}
  ?>
  <td class="normalfntMid" colspan="<?php echo $a;?>"><b>RATIO</b></td>
  <td class="normalfntMid"><b>FABRIC WIDTH</b></td>
  <td class="normalfntMid"><b>MM SHR</b></td>
  <td class="normalfntMid"><b>MARKER LENGTH</b></td>
  <td class="normalfntMid"><b>PCS</b></td>
  <td class="normalfntMid"><b>1 PCS YY</b></td>
  <td class="normalfntMid"><b>1 PCS YY with 5%</b></td>
 </tr>
</thead>

<tbody>
 <tr>

<?php
   $sql1 = "SELECT
			markerheader.intSerialNo,
			markerheader.strMarkerName,
			markerheader.strMarkerWidth,
			markerheader.strMarkerLength,
			markerheader.intPiles,
			markerheader.strLayout,
			markerheader.strMaterial,
			markerheader.intTotPieces,
			markerheader.intPlaced,
			markerheader.strEffi,
			markerheader.strSumArea,
			markerheader.strCutLength,
			markerheader.dtmDate,
			markerheader.strShrinkage,
			markerheader.dblYeildPerBundle,
			markerheader.strPercentage,
			markerheader.strPttn,
			markerheader.strComments,
			markerheader.strStyle,
			
			markerdetails.dtmDate as detailsDate,
			markerdetails.intSerialNo,
			markerdetails.strMaterial,
			markerdetails.strSize,
			markerdetails.strOrder,
			sum(markerdetails.dblCompBundles)as dblCompBundles,
			markerdetails.dblInCompBundles,
			markerdetails.dblPieces,
			markerdetails.dblPlaced
			FROM
			markerheader
			Inner Join markerdetails ON markerheader.intSerialNo = markerdetails.intSerialNo
			WHERE
			markerheader.strMarkerName =  '$marker' group by markerheader.strMarkerName,markerheader.dtmDate";
			
  $result1=$db->RunQuery($sql1);
  
	while($row = mysql_fetch_array($result1))
	{
	 $dtmDate           = $row["dtmDate"];
	 $detailsDate       = $row["detailsDate"];
	 
	 $strMarkerName     = $row["strMarkerName"];
	 $strStyle          = $row["strStyle"];
	 $strMarkerWidth    = $row["strMarkerWidth"];
	 $strMarkerLength   = $row["strMarkerLength"];
	 $dblCompBundles    = $row["dblCompBundles"];
	 $strShrinkage      = $row["strShrinkage"];
	 $dblYeildPerBundle = $row["dblYeildPerBundle"];
	 $dblYeildPerBundle = $row["dblYeildPerBundle"];
	 $strPercentage     = $row["strPercentage"];
	 $strPttn           = $row["strPttn"];
	 $strComments           = $row["strComments"];
	 
	 echo "<tr>";
	  echo "<td class='normalfnt'>$dtmDate</td>"; 
      echo "<td class='normalfnt'>$strComments</td>";
	  echo "<td class='normalfnt'>$strMarkerName</td>";
	  echo "<td class='normalfnt'>$strPttn</td>";
	  echo "<td class='normalfnt'>$strStyle</td>";
	  echo "<td class='normalfnt'></td>";
	  
	  
   $sql2 = "SELECT distinct
			markerdetails.strSize
			FROM
			markerheader
			Inner Join markerdetails ON markerheader.intSerialNo = markerdetails.intSerialNo
			WHERE
			markerheader.strMarkerName =  '$marker'";
   $result2=$db->RunQuery($sql2);
   	while($row2 = mysql_fetch_array($result2))
	{
	 $strSize = $row2["strSize"];
	 echo "<td class='normalfnt'>$strSize,</td>";
	}
	
	echo "<td class='normalfnt'>$strMarkerWidth</td>";
	echo "<td class='normalfnt'>$strShrinkage</td>";
	echo "<td class='normalfnt'>$strMarkerLength</td>";
	echo "<td class='normalfnt'>$dblCompBundles</td>";
	echo "<td class='normalfnt'>$dblYeildPerBundle</td>";
	echo "<td class='normalfnt'>$strPercentage</td>";		
   echo "</tr>";
	}
?>
 </tr>
</tbody>
</table>
</body>
</html>
