<?php

include "../../Connector.php";

$id = $_GET["id"];
$Response="";


if($id=="teams"){

	$numDays = $_GET["numDays"];
	$stDt =$_GET["startDate"];	
	$endDt = $_GET["endDate"];	
	
	$pQty = $_GET["plannedQty"];
	$pTTL = $_GET["plannedTTL"];
	$pEfy = $_GET["plannedEfy"];
	$aQty = $_GET["actualQty"];
	$aTTL = $_GET["actualTTL"];
	$aEfy = $_GET["actualEfy"];
	
	$teamIndex=0;
	//echo($teamIndex++);
	
	$SQL = "select distinct plan_teams.intTeamNo,plan_teams.strTeam,plan_stripes.intTeamNo from plan_teams,plan_stripes where plan_teams.intTeamNo=plan_stripes.intTeamNo;";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$arrTeams[$teamIndex++]=$row["intTeamNo"];
		
	}
	
	
	
	
	
	
	
	//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	
	
	
	
	$Response = "";
	
	$startDateArr = explode("-", $stDt);		  
	$startDate = mktime(0,0,0,$startDateArr[1],$startDateArr[2],$startDateArr[0]);
	
		//echo $numDays;
	 $width = 8+60+80+(75+2)*$numDays;
	 $Response.= "<table width=\"".$width."\" boder=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#162350\" id=\"tblMain\"><tr><td><div id=\"boxdiv1\"><div class=\"tableCellProductPlan1\" id=\"divInitialQQ\" style=\"width:60px; height:15px;\">Team</div><div class=\"tableCellProductPlan1\" id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Title</div>";
	 
	 $tempadte1 = $startDate;
	 for($i=0,$index=0; $i<$numDays; $i++)
	 {
		 $Response.="<div class=\"tableCellProductPlan1\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".date("d",$tempadte1)."/".date("M",$tempadte1)."</div>";
		 $Dates[$index++] = date("Y-m-d",$tempadte1);
		 $tempadte1+=24 * 60 * 60;
	 }
	 $Response.="</div></td></tr>";
	 
	
	 for($tmIndex=0; $tmIndex<count($arrTeams); $tmIndex++)
	 {
		 $styleRow = "";
		 $styleRow.="<tr><td class=\"normaltxtmidb2\"><div id=\"boxdiv1\">";
		 $styleRow.="<div class=\"tableCellProductPlan2\" id=\"divInitialQQ\" style=\"width:60px; height:15px\">&nbsp;</div>";
		 $styleRow.="<div class=\"tableCellProductPlan2\" id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Style No</div>";
		 
		 for($i=0; $i<$numDays; $i++)
		 {
			 $flag1= true;
			 $SQL1 = "SELECT
plan_stripes.intID,
plan_stripes.strStyleID,
plan_stripes.startDate,
plan_stripes.endDate,
plan_teams.intEfficency,
plan_teams.intMachines,
plan_stripes.dblWorkingHours,
plan_stripes.smv,
orders.strStyle
FROM
plan_stripes
INNER JOIN plan_teams ON plan_stripes.intTeamNo = plan_teams.intTeamNo
INNER JOIN orders ON orders.intStyleId = plan_stripes.strStyleID
where plan_stripes.intTeamNo='$arrTeams[$tmIndex]' and plan_stripes.startDate<='$Dates[$i]' and  plan_stripes.endDate>='$Dates[$i]' order by plan_stripes.endDate";

			 $result1 = $db->RunQuery($SQL1);
			 while($row2 = mysql_fetch_array($result1))
			 {
				 $flag1= false;
				 $styleId[$arrTeams[$tmIndex]][$i]= $row2["strStyleID"];
				 $styleName = $row2["strStyle"];
				 $styleRow.="<div class=\"tableCellProductPlan2\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$styleName."</div>";
				 $Stripes[$arrTeams[$tmIndex]][$i]		= $row2["intID"];
				 $teamEff[$arrTeams[$tmIndex]]			= $row2["intEfficency"];
				 $teamMachines[$arrTeams[$tmIndex]]		= $row2["intMachines"];
			 }
			 if($flag1)
			 {
			 	$styleRow.="<div class=\"tableCellProductPlan2\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
				$Stripes[$arrTeams[$tmIndex]][$i]= "";
				
			 }
		 }//end of for($i=0; $i<$numDays; $i++)
		 
		 $styleRow.="</div></td></tr>";
		 $Response.=$styleRow;
		 $SQL3 ="SELECT plan_teams.strTeam FROM plan_teams WHERE plan_teams.intTeamNo='$arrTeams[$tmIndex]'";
		 $result3 = $db->RunQuery($SQL3);
		 $Response.="<tr><td class=\"normaltxtmidb2\"><div id=\"boxdiv1\">";
		 while($row3 = mysql_fetch_array($result3))
		 {
			 $Response.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:60px; height:15px;\">".$row3["strTeam"]."</div>";
		 
			 $Response.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Planned Qty</div>";
			 for($i=0; $i<$numDays; $i++)
			 {
				 $SQL4 = "SELECT
plan_stripes.startTime,
plan_stripes.startDate,
plan_stripes.endDate,
plan_stripes.endTime,
plan_stripes.dblQty,
plan_stripes.dblWorkingHours,
plan_stripes.smv
FROM
plan_stripes WHERE plan_stripes.intID='".$Stripes[$arrTeams[$tmIndex]][$i]."'";

				
				 $result4 = $db->RunQuery($SQL4);
				 if(mysql_num_rows($result4)<1)
				 {
					$Response.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$PlannedQty[$arrTeams[$tmIndex]][$i]."</div>";
				 }
				 while($row4 = mysql_fetch_array($result4))
				 {
					 //echo $Dates[$i];
					 
					 $SQL_holiday = "SELECT plan_calender.dblWorkingHours AS pcWorkingHours,plan_holiday_calender.dblworkingHours AS phWorkingHours
FROM plan_calender
RIGHT JOIN plan_holiday_calender ON plan_calender.dtmDate = plan_holiday_calender.dtmDate
WHERE plan_holiday_calender.dtmDate = '$Dates[$i]'
UNION ALL
SELECT plan_calender.dblWorkingHours AS pcWorkingHours,plan_holiday_calender.dblworkingHours AS phWorkingHours
FROM plan_calender
LEFT JOIN plan_holiday_calender ON plan_calender.dtmDate = plan_holiday_calender.dtmDate
WHERE plan_calender.dtmDate = '$Dates[$i]' ";
					 $result_holiday = $db->RunQuery($SQL_holiday); 
					 $weekend =0;
					 $holiday =0;
					 while($row_holiday = mysql_fetch_array($result_holiday))
					 {
						 $weekend = $row_holiday['pcWorkingHours'];
						 $holiday = $row_holiday['phWorkingHours'];
					 }
					 
				
					 
					 
					 
					 
					$teamSMV[$arrTeams[$tmIndex]]			= $row4["smv"];
					 if(date('l',strtotime($Dates[$i]))=='Saturday')
					 { 
					 	if(!$weekend)
						$teamWorkingMin[$arrTeams[$tmIndex]]	= 300;
						else
						$teamWorkingMin[$arrTeams[$tmIndex]]	= $weekend*60;
					 }
					 else if(date('l',strtotime($Dates[$i]))=='Sunday')
					 { 
						if(!$weekend)
						$teamWorkingMin[$arrTeams[$tmIndex]]	= 0;
						else
						$teamWorkingMin[$arrTeams[$tmIndex]]	= $weekend*60;
					 }
					 else
					   $teamWorkingMin[$arrTeams[$tmIndex]]	= $row4["dblWorkingHours"];
					   
					
					 
					 if($Dates[$i]==$row4["startDate"] && $Dates[$i]==$row4["endDate"])
					 {
						$PlannedQty[$arrTeams[$tmIndex]][$i]=round((($row4["endTime"]-$row4["startTime"])*$teamMachines[$arrTeams[$tmIndex]]*$teamEff[$arrTeams[$tmIndex]])/(100*$teamSMV[$arrTeams[$tmIndex]]));
						
					 }
					 else if($Dates[$i]==$row4["startDate"])
					 { 
					
					 	 $PlannedQty[$arrTeams[$tmIndex]][$i]=round((($teamWorkingMin[$arrTeams[$tmIndex]]-$row4["startTime"])*$teamMachines[$arrTeams[$tmIndex]]*$teamEff[$arrTeams[$tmIndex]])/(100*$teamSMV[$arrTeams[$tmIndex]]));
						 //echo $teamSMV[$arrTeams[$tmIndex]];
					 }
					 else if($Dates[$i]==$row4["endDate"])
					 {
						$PlannedQty[$arrTeams[$tmIndex]][$i]= round((($row4["endTime"])*$teamMachines[$arrTeams[$tmIndex]]*$teamEff[$arrTeams[$tmIndex]])/(100*$teamSMV[$arrTeams[$tmIndex]])); 
					 }
					 else 
					 {
					    $PlannedQty[$arrTeams[$tmIndex]][$i]=round(($teamWorkingMin[$arrTeams[$tmIndex]]*$teamMachines[$arrTeams[$tmIndex]]*$teamEff[$arrTeams[$tmIndex]])/(100*$teamSMV[$arrTeams[$tmIndex]]));
					 }
					 
					 	$Response.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$PlannedQty[$arrTeams[$tmIndex]][$i]."</div>";
				 }
			 }
		 }		 
		 $Response.="</div></td></tr>";
		 
		 
		 
		 
		 
		 $planTtl="";
		 $planTtl.="<tr><td class=\"normaltxtmidb2\"><div id=\"boxdiv1\">";
		 $planTtl.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
		 $planTtl.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Planned TTL</div>";
		 for($i=0; $i<$numDays; $i++)
		 {
			 $sql6 = "SELECT
plan_stripes.intID,
DATEDIFF(plan_stripes.endDate,plan_stripes.startDate) AS diffrant
FROM
plan_stripes
where plan_stripes.intTeamNo='$arrTeams[$tmIndex]' and plan_stripes.startDate='$Dates[$i]'";

			$result6 = $db->RunQuery($sql6);
			$flag1 = true;
			while($row6= mysql_fetch_array($result6))
			{
				
				for($j=0; $j<=$row6['diffrant']; $j++)
				{
					$flag1 = false;
					//$stylIdno = $row6['intID'];
					//if($stylIdno==$Stripes[$arrTeams[$tmIndex]][$i])
					//{
						$planTotal = $PlannedQty[$arrTeams[$tmIndex]][$i] + $planTotal;
						$planTtl.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$planTotal."</div>";
					//}
					$i++;
				}
				
				$planTotal = 0;
				$i--;
			}
			 if($flag1)
			 {
				$planTotal = 0;
				$planTtl.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
			 }
			
		 }
		 $planTtl.="</div></td></tr>";
		 $Response.=$planTtl;
		 
		 

		
	 }// end of for($tmIndex=0; $tmIndex<count($arrTeams); $tmIndex++)
	
	 
	 $Response.="</table>"; 
	 
	echo $Response;
	
}

?>
