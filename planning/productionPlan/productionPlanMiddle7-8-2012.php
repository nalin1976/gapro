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
plan_stripes.smv
FROM
plan_stripes
INNER JOIN plan_teams ON plan_stripes.intTeamNo = plan_teams.intTeamNo
where plan_stripes.intTeamNo='$arrTeams[$tmIndex]' and plan_stripes.startDate<='$Dates[$i]' and  plan_stripes.endDate>='$Dates[$i]' order by plan_stripes.endDate";

			 $result1 = $db->RunQuery($SQL1);
			 while($row2 = mysql_fetch_array($result1))
			 {
				 $flag1= false;
				 $styleId = $row2["strStyleID"];
				 $styleRow.="<div class=\"tableCellProductPlan2\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$styleId."</div>";
				 $Stripes[$arrTeams[$tmIndex]][$i]= $row2["intID"];
				 //$strDate[$arrTeams[$tmIndex]][$i]= $row2["startDate"];
				 $teamEff[$arrTeams[$tmIndex]]= $row2["intEfficency"];
				 $teamWorkingMin[$arrTeams[$tmIndex]]= $row2["dblWorkingHours"];
				 $teamSMV[$arrTeams[$tmIndex]]= $row2["smv"];
				 $teamMachines[$arrTeams[$tmIndex]]= $row2["intMachines"];
				 //echo $teamWorkingMin[$arrTeams[$tmIndex]];
			 }
			 if($flag1)
			 {
			 	$styleRow.="<div class=\"tableCellProductPlan2\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
				$Stripes[$arrTeams[$tmIndex]][$i]= "";
				//echo $Stripes[$arrTeams[$tmIndex]][$i];
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
plan_stripes.dblQty
FROM
plan_stripes WHERE plan_stripes.intID='".$Stripes[$arrTeams[$tmIndex]][$i]."'";
				
				 $result4 = $db->RunQuery($SQL4);
				 if(mysql_num_rows($result4)<1)
				 {
					$Response.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$PlannedQty[$arrTeams[$tmIndex]][$i]."</div>";
				 }
				 while($row4 = mysql_fetch_array($result4))
				 {
					 if($Dates[$i]==$row4["startDate"] && $Dates[$i]==$row4["endDate"])
					 {
						 //echo $Stripes[$arrTeams[$tmIndex]][$i];
						 //$PlannedQty[$arrTeams[$tmIndex]][$i]=$row4["dblQty"];
						 $PlannedQty[$arrTeams[$tmIndex]][$i]=round((($row4["endTime"]-$row4["startTime"])*$teamMachines[$arrTeams[$tmIndex]]*$teamEff[$arrTeams[$tmIndex]])/(100*$teamSMV[$arrTeams[$tmIndex]]));
					 }
					 else if($Dates[$i]==$row4["startDate"])
					 { 
					 	 $PlannedQty[$arrTeams[$tmIndex]][$i]=round((($teamWorkingMin[$arrTeams[$tmIndex]]-$row4["startTime"])*$teamMachines[$arrTeams[$tmIndex]]*$teamEff[$arrTeams[$tmIndex]])/(100*$teamSMV[$arrTeams[$tmIndex]]));
					 }
					 else if($Dates[$i]==$row4["endDate"])
					 {
						 //$PlannedQty[$arrTeams[$tmIndex]][$i]=213;
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
			 
			$planTtl.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
			
		 }
		 $planTtl.="</div></td></tr>";
		 $Response.=$planTtl;
		 
		 
		 
		 
		 
		 $planEff="";
		 $planEff.="<tr><td class=\"normaltxtmidb2\"><div id=\"boxdiv1\">";
		 $planEff.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
		 $planEff.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Planned Eff</div>";
		 for($i=0; $i<$numDays; $i++)
		 {
			 if($Stripes[$arrTeams[$tmIndex]][$i]=="")
			 {
				 $planEff.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
			 }
			 else
			 {
				 $planEff.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$teamEff[$arrTeams[$tmIndex]]."</div>";
			 }
		 }
		 $planEff.="</div></td></tr>";
		 $Response.=$planEff;
		 
		 
		 
		 
		 
		 $actqty="";
		 $actqty.="<tr><td class=\"normaltxtmidb2\"><div id=\"boxdiv1\">";
		 $actqty.="<div class=\"tableCellProductPlan4\" id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
		 $actqty.="<div class=\"tableCellProductPlan4\" id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Actual Qty</div>";
		 for($i=0; $i<$numDays; $i++)
		 {
			 $SQL5 = "SELECT SUM(productionlineoutputheader.dblTotQty)AS actualQty
FROM productionlineoutputheader
INNER JOIN plan_stripes ON plan_stripes.strStyleID = productionlineoutputheader.intStyleId
WHERE productionlineoutputheader.dtmDate='".$Dates[$i]."' AND productionlineoutputheader.strTeamNo='".$arrTeams[$tmIndex]."'";
			 $result5 = $db->RunQuery($SQL5);
			 while($row5 = mysql_fetch_array($result5))
			 {
				 $actualQty[$arrTeams[$tmIndex]][$i]= $row5["actualQty"];
			 	$actqty.="<div class=\"tableCellProductPlan4\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$row5["actualQty"]."</div>";
			 }
		 }
		 $actqty.="</div></td></tr>";
		 $Response.=$actqty;
		 
		 
		 
		 
		 
		 $actTtl= "";
		 $actTtl.="<tr><td class=\"normaltxtmidb2\"><div id=\"boxdiv1\">";
		 $actTtl.="<div class=\"tableCellProductPlan4\" id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
		 $actTtl.="<div class=\"tableCellProductPlan4\" id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Actual TTL</div>";
		 for($i=0; $i<$numDays; $i++)
		 {
			 $actTtl.="<div class=\"tableCellProductPlan4\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
		 }
		 $actTtl.="</div></td></tr>";
		 $Response.=$actTtl;
		 
		 
		 
		 
		 
		 $actEff= "";
		 $actEff.="<tr><td class=\"normaltxtmidb2\"><div id=\"boxdiv1\">";
		 $actEff.="<div class=\"tableCellProductPlan4\" id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
		 $actEff.="<div class=\"tableCellProductPlan4\" id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Actual Eff</div>";
		 for($i=0; $i<$numDays; $i++)
		 {
			 if( $actualQty[$arrTeams[$tmIndex]][$i]=="")
			   $actEff.="<div class=\"tableCellProductPlan4\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
			 else
			 {
			   $actualEff[$arrTeams[$tmIndex]][$i] = round(($actualQty[$arrTeams[$tmIndex]][$i]*$teamSMV[$arrTeams[$tmIndex]]*100)/($teamWorkingMin[$arrTeams[$tmIndex]]*$teamMachines[$arrTeams[$tmIndex]])); 
			   $actEff.="<div class=\"tableCellProductPlan4\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$actualEff[$arrTeams[$tmIndex]][$i]."</div>";
			 }
		 }
		 $actEff.="</div></td></tr>";
		 $Response.=$actEff;
		 
		 
		 
		 
		 
		 $varRow= "";
		 $varRow.="<tr><td class=\"normaltxtmidb2\"><div id=\"boxdiv1\">";
		 $varRow.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
		 $varRow.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Variance</div>";
		 for($i=0; $i<$numDays; $i++)
		 {
			 if( $actualQty[$arrTeams[$tmIndex]][$i]=="")
			 {
			   $varRow.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
			 }
			 else
			 {
			   $shortQty = $PlannedQty[$arrTeams[$tmIndex]][$i]-$actualQty[$arrTeams[$tmIndex]][$i];
			   $varRow.="<div class=\"tableCellProductPlan3\" id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$shortQty."</div>";
			 }
		 }
		 $varRow.="</div></td></tr>";
		 $Response.=$varRow;
	 }// end of for($tmIndex=0; $tmIndex<count($arrTeams); $tmIndex++)
	
	 
	 $Response.="</table>"; 
	 
	 echo $Response;
	
}

?>
