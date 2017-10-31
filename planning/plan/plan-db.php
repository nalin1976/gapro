<?php
include "../../Connector.php";


$id  = $_GET["id"];

if($id=='getPreDate')
{
	$this_month=date('m');
	$chk_date=date('Y').'-'.$this_month.'-01';
	$sql_date="select distinct dtmdate from plan_calender where intCompanyId=$intPubCompanyId AND dtmDate<'$chk_date'";
	$result_date=$db->RunQuery($sql_date);
	
	if(mysql_num_rows($result_date)==0)
		echo 0;
			
}

if($id=='getStripWidth')
{
	$teamId 	= $_GET["teamId"];
	$style		= $_GET["style"];
	
		$sql = "SELECT plan_teams.intEfficency FROM `plan_teams` WHERE plan_teams.intTeamNo =  '$teamId'";
		$result = $db->RunQuery($sql);
		//echo $sql;
		while($row=mysql_fetch_array($result))
		{
			$efficency =  $row["intEfficency"];
		}
		
		$sql = "select reaSMV from orders where strStyle='$style'";
		$result = $db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$smv =  $row["reaSMV"];
		}
		
		
}

if($id=='getOrderStyle')
{
	$styleId=$_GET['styleId'];
	$sql = "SELECT strStyle FROM orders where intStyleId=$styleId";
	$result = $db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	echo $row['strStyle'];
}
//thuz
if($id=='savePlanDetails')
{
		$style			=	$_GET['style'];
		$smv			=	(float)$_GET['smv'];
		$stripId		=	$_GET['stripId'];
		$new			=	$_GET['new'];
		$qty			=	$_GET['qty'];
		$actQty			=	$_GET['actQty'];
		$startDate		=	$_GET['startDate'];
		$startTime		=	$_GET['startTime'];
		$endDate		=	$_GET['endDate'];
		$endTime		=	$_GET['endTime'];
		
		$team			=	$_GET['team'];
		$curve			=	$_GET['curve'];
		$totalHours		=	$_GET['totalHours'];
		$stripLeft		=	$_GET['stripLeft'];
		$cellLeft		=	$_GET['cellLeft'];
		$stripWidth 	=	$_GET['stripWidth'];
		$workingHours  	=	$_GET['workingHours'];
		$teameffi  		=	$_GET['teameffi'];
		$machines  		=	$_GET['machines'];
		$changeTeamParam  	=	$_GET['changeTeamParam'];
		
		//echo $endDate;
		
		if($new)
		{
			$sql = "insert into plan_stripes 
						( 
						strStyleID, 
						smv,
						intTeamNo, 
						intLearningCuveId, 
						dblLeftPercent,
						startDate, 
						startTime, 
						endDate, 
						endTime, 
						totalHours, 
						dblQty,
						dblStripWidth,
						dblWorkingHours
					
						)
						values
						(
						'$style', 
						'$smv',
						'$team', 
						'$curve', 
						'$cellLeft',
						'$startDate', 
						'$startTime', 
						'$endDate', 
						'$endTime', 
						'$totalHours', 
						'$qty',
						'$stripWidth',
						'$workingHours'
						
						);
					";
			$result = $db->RunQuery($sql);
			if(! $result)
				echo $sql;
			else
				echo 1;
				//echo "strip $stripId saved ";
		}
		else
		{
			$sql = "		update plan_stripes 
						set
							intTeamNo 			= '$team' , 
							intLearningCuveId 	= '$curve' , 
							startDate 			= '$startDate' , 
							startTime 			= '$startTime' , 
							endDate 			= '$endDate' , 
							endTime 			= '$endTime' , 
							totalHours 			= '$totalHours' , 
							dblQty 				= '$qty' , 
							dblActQty 			= '$actQty',
							dblLeftPercent		= '$cellLeft',
							dblStripWidth       = '$stripWidth',
							dblWorkingHours		= '$workingHours',
							intTeamEfficency    = '$teameffi',
							intNoOfMachine		= '$machines',
							intChangeParamStatus = '$changeTeamParam'
							
						where
							intID 				= '$stripId'";
							
			$result = $db->RunQuery($sql);
			if(! $result)
				echo $sql;
			else
				echo 1;
				//echo "strip $stripId Updated ";

		}
}

//thuz
if($id=='deleteStrip')
{
	$activeStrip=$_GET['activeStrip'];
	/*$orderId=$_GET['orderId'];
	$styleId=$_GET['styleId'];
	$qty=$_GET['qty'];
	$smv=$_GET['smv'];
	*/
	$sql_delete="DELETE FROM plan_stripes WHERE intID='$activeStrip'";
	
	$result_delete = $db->RunQuery($sql_delete);
	
	if($result_delete)
	{	
		echo 1;
	}
	
}

if($id=='createStrip')
{
	$curveId=$_GET['curveId'];
	
	
	$sql="SELECT dblEfficency FROM plan_learningcurvedetails WHERE id='$curveId'";
	$effi="";
	
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$effi.=$row['dblEfficency'];
		$effi.=",";
		
	}
	
	echo $effi;
	//echo "";
}

if($id=='loadLearningCurve')
{
	$curveId = $_GET['curveId'];
	
	$sql="SELECT id,strCurveName from plan_learningcurveheader";
	
	$result = $db->RunQuery($sql);
	$details = "";
	 if($curveId==0)
			$details .= "<option selected value=\"0\"></option>\n";
	while($row=mysql_fetch_array($result))
	{
		$id1=$row['id'];
		$name=$row['strCurveName'];
		if($curveId==$id1)
			$details .= "<option selected value=\"$id1\">$name</option>\n";
		else
			$details .= "<option value=\"$id1\">$name</option>\n";
		//echo $effi;
	}
	
	echo $details;
	//echo "";
}



if($id=='disableLearningCurve')
{
	$stripId=$_GET['stripId'];
	$sql="SELECT * FROM plan_actualproduction WHERE intStripeId='$stripId'";
	$result=$db->RunQuery($sql);
	if(mysql_num_rows($result)>0)
		echo 1;
}

if($id=='selectSewingSmv')
{
	$styleId=$_GET['styleId'];	
	$sql="SELECT dblSewwingSmv FROM orders WHERE intStyleId='$styleId'";
	
	$result = $db->RunQuery($sql);
	if(mysql_num_rows($result)>0)
	{
	$row=mysql_fetch_array($result);
	$sewingSmv=$row['dblSewwingSmv'];
	echo $sewingSmv;
	}
	else
	{
	$sql1="SELECT dblSewwingSmv FROM plan_newoders WHERE strStyleId='$styleId'";
	$result1 = $db->RunQuery($sql1);
	$row1=mysql_fetch_array($result1);
	$sewingSmv1=$row1['dblSewwingSmv'];
	echo $sewingSmv1;
	}
	//echo "";
}

if($id=='getOrderNo')
{
	$styleId=$_GET['styleId'];	
	$sql="SELECT strOrderNo FROM orders WHERE intStyleId='$styleId'";
	
	$result = $db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	echo $row['strOrderNo'];
}

if($id=='getDate')
{
	echo date("Y-m-d",strtotime("-1 Months"));	
}

if($id=='completedQty')
{
	$style=$_GET['style'];
	$team=$_GET['team'];
	$stripId=$_GET['stripId'];
	
    $sql="SELECT SUM(dblProducedQty) AS producedQty  FROM plan_actualproduction
			WHERE intStripeId=$stripId && intTeamNo=$team && strStyleId='$style';";
	
	$result = $db->RunQuery($sql);
	 
	$row=mysql_fetch_array($result);
	
	if($row['producedQty']=='')
		echo 0;
	else
		echo $row['producedQty'];
	

}

if($id=='checkStripNo')
{
	$stripId=$_GET['stripId'];
	$sql="SELECT intId FROM plan_stripes WHERE intID='$stripId';";
	$result = $db->RunQuery($sql);
	if(mysql_num_rows($result)>0)
		echo 1;
	else
		echo 0;
}

if($id=='changeDayProperty')
{
	//$active_startTime = 1;
	
	$teamId=$_GET['teamId'];
	$sDate=$_GET['sDate'];
	$eDate=$_GET['eDate'];
	$startTime=$_GET['startTime'];
	$endTime=$_GET['endTime'];
	$sworkingHours=$_GET['sworkingHours'];
	$dayType=$_GET['dayType'];
	$teamEfficiency=$_GET['teamEfficiency'];
	$noOfMachines=$_GET['noOfMachines'];
	//$mealHours			= $_GET['mealHours'];
	
	$actTime=$_GET['actTime'];
	$actEffi=$_GET['actEffi'];
	$actMach=$_GET['actMach'];
	
	$chkAll=$_GET['chkAll'];
	$companyId=$_GET['companyId'];
	
	
	//echo "Updated";

	
	$sql = "UPDATE plan_calender
				SET ";
	if($actTime==1)
	{
		if($actEffi==0 && $actMach==0)
		{
			$sql .=" dblStartTime='$startTime'," ;
			$sql .=" dblEndTime='$endTime'," ;
			$sql .=" dblWorkingHours='$sworkingHours'" ;	
		}
		else
		{
			$sql .=" dblStartTime='$startTime'," ;
			$sql .=" dblEndTime='$endTime'," ;
			$sql .=" dblWorkingHours='$sworkingHours'," ;
		}
	}
		
	if($actEffi==1)
	{
		if($actMach==0)
			$sql .=" intTeamEfficency='$teamEfficiency'";
		else
			$sql .=" intTeamEfficency='$teamEfficiency',";
	}
	
	if($actMach==1)
		  $sql .=" intMachines='$noOfMachines'";
		  	

	$sql .=	" where intCompanyId='$companyId' and dtmDate>='$sDate' and dtmDate<='$eDate'  ";
				
	if($chkAll==0)
		$sql.=" and intTeamId='$teamId' ";
		
	if($dayType=='Sa')
		$sql.=" and strDayStatus='saturday' ";
	else if($dayType=='Su')
		$sql.=" and strDayStatus='sunday' ";
	else if($dayType=='Ho')
		$sql.=" and strDayStatus='off' " ;
		
	$result = $db->RunQuery($sql);
	if(! $result)
		echo $sql;
	else
		echo "Updated Successfully";
}

if($id=='loadBPONo')
{
	$styleId=$_GET['orderStyleId'];
	$deliveryDate=$_GET['deliveryDate'];
	
	$cboValues = "";
	$cboValues .= "<option selected value=\"0\"></option>\n";
	
	$sql="SELECT DISTINCT intScheduleId, strBuyerPONO FROM eventscheduleheader
			WHERE strStyleId='$styleId' AND date(dtDeliveryDate)='$deliveryDate'";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$buyerPoNo=$row['strBuyerPONO'];
		$scheduleId=$row['intScheduleId'];
		$cboValues .= "<option value=\"$buyerPoNo\">$buyerPoNo</option>\n";
	}
	
	echo $cboValues;
	
}

if($id=='loadEventSchDataToPopUp')
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<Result>\n";
	$StyleID = $_GET["StyleId"];
	$DeliveryDate = $_GET["DeliveryDate"];
	
	 $buyerPO = $_GET["buyerPo"];
	
		$sql="SELECT `events`.strDescription AS Event, date(eventscheduledetail.dtmEstimateDate) AS estimatedDate,DATEDIFF(CURDATE(),dtmEstimateDate) AS delay
	 	FROM eventscheduledetail
		INNER JOIN `events` ON `events`.intEventID=eventscheduledetail.intEventId
		INNER JOIN eventscheduleheader ON eventscheduleheader.intScheduleId=eventscheduledetail.intScheduleId
		WHERE date(eventscheduleheader.dtDeliveryDate)='$DeliveryDate' AND eventscheduleheader.strBuyerPONO='$buyerPO' AND eventscheduleheader.strStyleId='$StyleID'";
	
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<Event><![CDATA[" . $row["Event"]  . "]]></Event>\n";
		$ResponseXML .= "<EstDate><![CDATA[" . $row["estimatedDate"]  . "]]></EstDate>\n";		
	    if (substr($row["delay"],0,1)=='-')
			$ResponseXML .= "<ProssDiff><![CDATA[" . substr($row["delay"],1) . "]]></ProssDiff>\n";
		else
			$ResponseXML .= "<ProssDiff><![CDATA[" . ($row["delay"]*-1) . "]]></ProssDiff>\n";
			
			
	}
	$ResponseXML .= "</Result>";
	echo $ResponseXML;
}

//thuz
if($id=='saveWorkingHours')
{
	$date = $_GET['cellDate'];
	$workingHours = $_GET['workingHours'];
	$sql_insert = "INSERT INTO plan_calender(dtmDate,dblWorkingHours) VALUES ('$date','$workingHours')";
	$result_insert = $db->RunQuery($sql_insert);
	if(!$result_insert)
	echo $sql_insert;
	else
	echo 1;
}

//thuz
if($id=='getWorkingHours')
{
	$date = $_GET['dateFormat'];
	
	 $sql = "SELECT dtmDate,dblWorkingHours FROM plan_calender WHERE dtmDate='$date'";
	 $result=$db->RunQuery($sql);
	 if(mysql_num_rows($result)>0)
	 {
		 while($row = mysql_fetch_array($result))
		 {
			 $wrkingmin = (floor($row['dblWorkingHours']) * 60);
			 echo $wrkingmin;
		 }
	 }
	 else
	 {
		 $nul = NULL;
		 echo $nul;
	 }
}

if($id=='saveChangeTeamParameters')
{
	$stripId = $_GET['stripId'];
	$teamID = $_GET['teamId'];
	$teameffi = $_GET['teameffi'];
	$machines = $_GET['machines'];
	
	
	$sql_check = "SELECT strStripId FROM plan_changeteamparameters WHERE strStripId='$stripId'";
	$result = $db->RunQuery($sql_check);
	
	if(mysql_num_rows($result)>0)
	{
		$sql_update = "UPDATE plan_changeteamparameters SET intTeamEfficency=$teameffi,intNoOfMachine=$machines WHERE strStripId='$stripId'";
		$re = $db->RunQuery($sql_update);	
		echo $re;
	}
	else
	{
		$sql_insert = "INSERT INTO plan_changeteamparameters (intTeamEfficency,intNoOfMachine,intChangeParamStatus)
VALUES ($teameffi,$machines,1) WHERE intID='$stripId' ";
		$re = $db->RunQuery($sql_insert);
		echo $re;
	}
}
	
?>






