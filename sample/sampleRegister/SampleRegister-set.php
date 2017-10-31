<?php
include "../../Connector.php";
header('Content-Type: text/xml'); 


$id=$_GET["id"];
$styleno=$_GET["styleno"];
$intStatus=$_GET["intStatus"];
$optCode=$_GET["optCode"];
$startDate=$_GET["startDate"];
$noDays=$_GET["noDays"];
$chkId=$_GET["chkId"];
$stylename=$_GET["stylename"];

if($id=="loadOrderNo")
{
  $SQL="SELECT * FROM orders WHERE strStyle='$stylename'";

$result = $db->RunQuery($SQL);	
	$html = "<option></option>";			 
	while($row=mysql_fetch_array($result))
	{
		$html .= "<option value=\"".$row['intStyleId']."\">".$row['strOrderNo']."</option>";
		
	}
		echo $html;
}


//Loading the CheckBoxes

else if($id=='loadCheckBox1')
{
$SQL="SELECT * FROM  samplerequestheader WHERE intStyleId='$styleno'";
$result = $db->RunQuery($SQL);	
	$html="";
	while($row=mysql_fetch_array($result))
	{
	$html .="".$row['intOriginalSample']."";
	}
	echo $html;
}

else if($id=='loadCheckBox2')
{
$SQL="SELECT * FROM  samplerequestheader WHERE intStyleId='$styleno'";
$result = $db->RunQuery($SQL);	
	$html="";
	while($row=mysql_fetch_array($result))
	{
	$html .="".$row['intFabric']."";
	}
	echo $html;
}

else if($id=='loadCheckBox3')
{
$SQL="SELECT * FROM  samplerequestheader WHERE intStyleId='$styleno'";
$result = $db->RunQuery($SQL);	
	$html="";
	while($row=mysql_fetch_array($result))
	{
	$html .="".$row['intAccessories']."";
	}
	echo $html;
}
//End

//Loading the Sample Register Grid

else if($id=="loadGrid")
{

		
   echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


	$ResponseXML = "<loadStyle>";
	
	$SQL="SELECT
		  SS.dtmDueDate,ST.strDescription
		  FROM orders OD
		  Inner Join sampleschedule SS ON OD.intStyleId = SS.intStyleId
		  Inner Join sampletypes ST ON ST.intSampleId = OD.strSampleId
		  WHERE
		  SS.intStyleId=$styleno"; 

		
	$result = $db->RunQuery($SQL);	
	//$html = "";			 
	while($row=mysql_fetch_array($result))
	{
		//$html .= ;
		//$ResponseXML .= "<SAMPLE_NO><![CDATA[" . $row["intSampleNo"]  . "]]></SAMPLE_NO>\n";
		$ResponseXML .= "<SAMPLE_DESCRIPTION><![CDATA[" . $row["strDescription"]  . "]]></SAMPLE_DESCRIPTION>\n"; 
		$ResponseXML .= "<SAMPLE_DUE_DATE><![CDATA[" . $row["dtmDueDate"]  . "]]></SAMPLE_DUE_DATE>\n"; 
		
	}
		//echo $html;	
		$ResponseXML .= "</loadStyle>";
		echo $ResponseXML;
}


else if($id=="loadPopUpGrid")
{

		
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


	$ResponseXML = "<loadStyle>";
	$SQL="SELECT * FROM operators";
		
	$result = $db->RunQuery($SQL);
	//echo $SQL;	
	//$html = "";			 
	while($row=mysql_fetch_array($result))
	{
		//$html .= ;
		$ResponseXML .= "<XML_OPERATOR_NAME><![CDATA[" . $row["strOperator"]  . "]]></XML_OPERATOR_NAME>\n";
		$ResponseXML .= "<XML_OPERATOR_ID>".$row["intOperatorID"]."</XML_OPERATOR_ID>\n";
		
	}
		//echo $html;	
		$ResponseXML .= "</loadStyle>";
		echo $ResponseXML;
}

else if($id=="selectedData")
{
	
	$SQL="SELECT * FROM sampleoperator WHERE intOperatorId='$chkId'";
	$result=$db->RunQuery($SQL);
	//echo(mysql_num_rows($result));
	$html="";
	while($row=mysql_fetch_array($result))
	{
		$html .="".$row['intOperatorId']."";
		//$html .="".$row['dtmStartDate']."";
		//$html .="".$row['dblNoofDays']."";
	}
	echo $html;
}



else if($id=="updateSampleOpt")
{
		echo $sql="INSERT INTO sampleoperator VALUES ('$styleno',(SELECT intSampleType FROM samplerequestdetails WHERE intStyleID='$styleno'),(SELECT intSampleNo FROM samplerequestdetails WHERE intStyleID='$styleno'),(SELECT intOperatorId FROM operators WHERE intOperatorId='$optCode'),'$startDate','$noDays')";
		
	 	$result = $db->RunQuery($sql);	
  	    if($result)
				echo "Saved successfully.";
				else
				echo "Data saving error.";
}


?>