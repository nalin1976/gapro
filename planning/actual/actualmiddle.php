<?php

include "../../Connector.php";

$id = $_GET["id"];

if($id=="Season"){

	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$ResponseXML .= "<Seasons>";
	$RequestType = $_GET["Seasonload"];
	
	$SQL="SELECT * FROM seasons where intSeasonId='".$RequestType."'";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		// $ResponseXML .= "<SeasonId><![CDATA[" . $row["strSeasonId"]  . "]]></SeasonId>\n";
		 $ResponseXML .= "<SeasonCode><![CDATA[" . $row["strSeasonCode"]  . "]]></SeasonCode>\n";
		 $ResponseXML .= "<SeasonName><![CDATA[" . $row["strSeason"]  . "]]></SeasonName>\n";
		 $ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		
	}
	 $ResponseXML .= "</Seasons>";
	 echo $ResponseXML;
}
if($id=="loadStyle"){

	$team = $_GET["team"];
	
		$SQL="SELECT
			orders.strStyle,
			plan_stripes.strStyleID
			FROM
			plan_stripes
			INNER JOIN orders ON plan_stripes.strStyleID = orders.intStyleId
			WHERE plan_stripes.intTeamNo='$team';";
							
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". 0 ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strStyleID"] ."\">" . $row["strStyle"] ."</option>" ;
	}
}
if($id=="loadStripe"){
	
	$team = $_GET["team"];
	$style = $_GET["style"];
	
	
	$SQL="select intID from plan_stripes where intTeamNo='$team' and strStyleID='$style';";
							
	$result = $db->RunQuery($SQL);
	echo "<option value=\"". 0 ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intID"] ."\">" . $row["intID"] ." </option>" ;
	}
}

if($id=='loadFullQuantity')
{
	$stripNo=$_GET['stripNo'];
	$sql="SELECT dblQty-dblActQty AS tobeFinished FROM plan_stripes WHERE intId='$stripNo';";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	echo $row["tobeFinished"];
}
if($id=="Save"){

	$date = $_GET["date"];
	$startTime = "0000-00-00 ".$_GET["startTime"].":00";
	$endTime = "0000-00-00 ".$_GET["endTime"].":00";
	$intStripeID = $_GET["intStripeID"];
	
	/*
	$sql1="select date,startTime,endTime from plan_actualqty where intStripeID='$intStripeID' ;";
	
	$result1 = $db->RunQuery($sql1);
	
	while($row1 = mysql_fetch_array($result1))
	{
		if($row1["date"]>$row1["date"]){
		
		}
		if($row1["date"]>$row1["date"]){
		
		}
	}
		*/
		
	$intTeamNo = $_GET["intTeamNo"];
	$strStyleID = $_GET["strStyleID"];
	$dblProducedQty = $_GET["dblProducedQty"];
	$dblSMV = $_GET["dblSMV"];
	$intWorkers = $_GET["intWorkers"];
	$intWorkingMins = $_GET["intWorkingMins"];
	
	$sql="insert into plan_actualqty 
	(date, 
	startTime, 
	endTime, 
	intTeamNo, 
	strStyleID, 
	intStripeID, 
	dblProducedQty, 
	dblSMV, 
	intWorkers, 
	intWorkingMins
	)
	values
	('$date', 
	'$startTime', 
	'$endTime', 
	'$intTeamNo', 
	'$strStyleID', 
	'$intStripeID', 
	'$dblProducedQty', 
	'$dblSMV', 
	'$intWorkers', 
	'$intWorkingMins'
	);";
	
	$Result =$db->executeQuery($sql);
	
	if ($Result==1)
			echo "Saved Successfully";
	else
		echo "Unable to Save";
}

if($id=='updateStripActQty')
{
	$stripNo=$_GET['stripNo'];
	$producedQty=$_GET['producedQty'];
	
	
	$SQL="UPDATE plan_stripes
		SET dblActQty=dblActQty+'$producedQty'
		WHERE intID='$stripNo';";
							
	$result = $db->RunQuery($SQL);
	
	if(! $result)
				echo $sql;
			else
				echo 1;
}

if($id=='saveToActProduction')
{
	$date=$_GET['date'];
	$startTime=$_GET['startTime'];
	$endtime=$_GET['endtime'];
	$teamNo=$_GET['intTeamNo'];
	$style=$_GET['strStyleId'];
	$stripNo=$_GET['intStripeId'];
	$producedQty=$_GET['dblProducedQty'];
	$smv=$_GET['dblSMV'];
	$noOfWorkers=$_GET['intWorkers'];
	$workingMinutes=$_GET['intWorkingMins'];
	
	/*$sql_select="SELECT * FROM plan_actualproduction WHERE intStripeId='$stripNo';";
	$result_select = $db->RunQuery($sql_select);
	
	if(mysql_num_rows($result_select)>0)
	{
		$SQL="UPDATE plan_actualproduction
			  SET
			  	date='$date', 
				startTime='$startTime',
				endtime='$endtime',
				intTeamNo='$teamNo',
				strStyleId='$style',
			  	dblProducedQty='$producedQty',
				dblSMV='$smv',
				intWorkers='$noOfWorkers',
				intWorkingMins='$workingMinutes'
			  WHERE intStripeId='$stripNo'";
	}
	else
	{*/
	$SQL="INSERT INTO 							plan_actualproduction(date,startTime,endTime,intTeamNo,strStyleId,intStripeId,dblProducedQty,dblSMV,intWorkers,intWorkingMins)
VALUES('$date','$startTime','$endtime','$teamNo','$style','$stripNo','$producedQty','$smv','$noOfWorkers','$workingMinutes');";
	//}
									
	$result = $db->RunQuery($SQL);
	
	if(! $result)
		echo $SQL;
	else
		echo 10;
	
}
?>
