<?php
session_start();
include "../../Connector.php";

$RequestType = $_GET["RequestType"];
	
//****************************************Load Categories according to the selected style No************************
if($RequestType=="loadCategories")
{
	$styleNo=trim($_GET['styleNo'],' ');

	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$ResponseXML .="<xmlDet>";
	 $sql_categories = "SELECT ws_stylecategorydetails.intCategory FROM ws_stylecategorydetails  WHERE ws_stylecategorydetails.strStyle ='$styleNo'";
	 //echo $sql_categories;
	$result_categories = $db->RunQuery($sql_categories);
	while($row_categories=mysql_fetch_array($result_categories))
	{
	$ResponseXML .= "<category><![CDATA[" .  $row_categories["intCategory"] . "]]></category>\n";
	}
	
	$ResponseXML .="</xmlDet>";
	
	echo $ResponseXML;
}


// created by suMitH HarShan    2011-05-04
// ********************************* Load SC NO of the selected style No*********************************************
 if($RequestType=="loadSCNo")
{
	$styleNo=trim($_GET['styleNo'],' ');
	
    $sql_styleNO = "SELECT DISTINCT specification.intSRNO FROM ws_stylecategorydetails	INNER JOIN specification ON specification.intStyleId = ws_stylecategorydetails.strStyle	WHERE ws_stylecategorydetails.strStyle ='$styleNo'";

	$result_styleNO = $db->RunQuery($sql_styleNO);
	if(mysql_num_rows($result_styleNO)>0)
	{
	  while($row_styleNO=mysql_fetch_array($result_styleNO))
	  {
		$SCNO .= "<option value=\"". $row_styleNO["intSRNO"] ."\" selected=\"selected\">" . $row_styleNO["intSRNO"] ."</option>";	      }
		
	}
	echo $SCNO;
}



// ******************************************  Load SC NO of the selected style No *******************************
 if($RequestType=="loadStyleNo")
{
	$SCNO=trim($_GET['cboScNo'],' ');

	$sql_SCNO = "SELECT DISTINCT ws_stylecategorydetails.strStyle FROM ws_stylecategorydetails INNER JOIN specification ON specification.intStyleId = ws_stylecategorydetails.strStyle WHERE specification.intSRNO = '$SCNO'";
	//$sql_SCNO = "SELECT DISTINCT specification.strStyleID FROM specification WHERE specification.intSRNO ='$SCNO'";

	$result_SCNO = $db->RunQuery($sql_SCNO);
	if(mysql_num_rows($result_SCNO)>0)
	{
	  while($row_SCNO = mysql_fetch_array($result_SCNO))
	  {
		$StyleNO .= "<option value=\"". $row_SCNO["strStyle"] ."\" selected=\"selected\">" . $row_SCNO["strStyle"] ."</option>";	      }
		
	}
	echo $StyleNO;
}


?>