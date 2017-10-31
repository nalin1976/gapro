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
	
	$days1=$numDays;
	$days=$numDays;
	
	$startDateArr = explode("-", $stDt);		  
	$startDate = mktime(0,0,0,$startDateArr[1],$startDateArr[2],$startDateArr[0]);
	
	$Arr;
	$Dates;
	$stripesDays;
	$Stripes;
	$Efficiency;
	$PlannedQty;
	$ActualQty;
	$PlannedcumTtl;
	$ActualcumTtl;
	//$shortQty=0;
	//$SuggQty;
	$Style;
	$repeatDates;
	$arrTeams;
	$teamIndex=0;
	
	$SQL="select distinct plan_teams.intTeamNo,plan_teams.strTeam,plan_stripes.intTeamNo from plan_teams,plan_stripes where plan_teams.intTeamNo=plan_stripes.intTeamNo;";
		
	$result = $db->RunQuery($SQL);
	while($row1 = mysql_fetch_array($result))
	{				
		$tmpdate=$startDate;
		$arrTeams[$teamIndex++]=$row1["intTeamNo"];
		
		for($i=0,$n=-1;$i<$numDays;$i++){
		
			$SQL2="select intTeamId as num from plan_calender where intTeamId='".$row1["intTeamNo"]."' and dtmDate='".date("Y-m-d", $tmpdate)."' and dblWorkingHours>0;";
			
			$result2 = $db->RunQuery($SQL2);
			
			$flag1=true;
			
			while($row3 = mysql_fetch_array($result2))
			{
				$SQL1="select intID,strStyleID,startDate,endDate,totalHours,intLearningCuveId from plan_stripes where intTeamNo='".$row1["intTeamNo"]."' and startDate<='".date("Y-m-d", $tmpdate)."' and endDate>='".date("Y-m-d", $tmpdate)."';";		
				$result1 = $db->RunQuery($SQL1);
				
				while($row2 = mysql_fetch_array($result1))
				{
					/*
					$SQL3="select dblWorkingHours from plan_calender where intTeamId='".$row1["intTeamNo"]."' and dtmDate>='".$row2["startDate"]."' and dtmDate<='".$row2["endDate"]."';";		
					$result3 = $db->RunQuery($SQL3);
					$completedHours=0;
					*/
					if($flag1){
						$flag1=false;	
						$Arr[$row1["intTeamNo"]][date("Y-m-d", $tmpdate)]=1;																											
					}
					else
					{							
						$Arr[$row1["intTeamNo"]][date("Y-m-d", $tmpdate)]+=1;	
						$days1++;							
					}		
					
					//$stripesDays[$row2["intID"]];
					//$stripesDays[$row2["intID"]][$id]=$row2["intID"];
					$startDateArr1 = explode("-", $row2["startDate"]);		  
					$tmpdate1 = mktime(0,0,0,$startDateArr1[1],$startDateArr1[2],$startDateArr1[0]);
					$day=1;
					
					while($row2["endDate"]>=date("Y-m-d", $tmpdate1)){
						
						if($row2["intLearningCuveId"]==0){
						
							$SQL3="select intTeamEfficency from plan_calender where intTeamId='".$row1["intTeamNo"]."' and dtmDate='".date("Y-m-d", $tmpdate1)."' and dblWorkingHours>0;";						
							$result3 = $db->RunQuery($SQL3);
					
							while($row4 = mysql_fetch_array($result3)){
								
								$stripesDays[$row2["intID"]][date("Y-m-d", $tmpdate1)]=$row4["intTeamEfficency"];
							}
						}	
						else
						{
							$SQL3="select intCurveDay,dblEfficency from plan_learningcurvedetails where id='".$row2["intLearningCuveId"]."';";
							$result3 = $db->RunQuery($SQL3);
							$maxEfficiency1=0;
							$flag11=true;
							
							while($row4 = mysql_fetch_array($result3))
							{
								
								if($day==$row4["intCurveDay"])
								{
								
									$stripesDays[$row2["intID"]][date("Y-m-d", $tmpdate1)]=$row4["dblEfficency"];
									$flag11=false;	
									//break;
								}	
								else if($maxEfficiency1<$row4["dblEfficency"])
									$maxEfficiency1=$row4["dblEfficency"];					
							}	
							if($flag11)
								$stripesDays[$row2["intID"]][date("Y-m-d", $tmpdate1)]=$maxEfficiency1;		
																			
						} 							
						
						$tmpdate1+=24 * 60 * 60;	
						$day++;
						
					}
				}										
			}
			
			if($flag1)
				$Arr[$row1["intTeamNo"]][date("Y-m-d", $tmpdate)]=0;
										
			$tmpdate+=24 * 60 * 60;
		}
		if($days1>$days){
			$days=$days1;
			$days1=$numDays;
		}
	}
	
	$width=8+60+80+(75+2)*$days;	
	
	$Response.="<table width=\"".$width."\"  border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#162350\"  id=\"tblMain\"><tr><td  class=\"normaltxtmidb2\" ><div id=\"boxdiv1\" ><div  class=\"tableCellProductPlan1\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">Team</div><div  class=\"tableCellProductPlan1\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Title</div>";
	
	$tmpdate1=$startDate;
	
	for($i=0,$index=0;$i<$numDays;$i++){		
		
		$maxDays=1;
		
		for($tmIndex=0;$tmIndex<count($arrTeams);$tmIndex++){
		
			if($maxDays<$Arr[$arrTeams[$tmIndex]][date("Y-m-d", $tmpdate1)])
				$maxDays=$Arr[$arrTeams[$tmIndex]][date("Y-m-d", $tmpdate1)];
		}
		
		for($j=1;$j<=$maxDays;$j++){
		
			$Response.="<div  class=\"tableCellProductPlan1\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".date("d", $tmpdate1)."/".date("M", $tmpdate1)."</div>";
			$Dates[$index++]=date("Y-m-d", $tmpdate1);	
			
		}		
		$tmpdate1+=24 * 60 * 60;	
	}	
	
	$Response.="</div></td></tr>";
	$styleRow="";
	
	for($tmIndex=0;$tmIndex<count($arrTeams);$tmIndex++){
			
		$styleRow.="<tr><td  class=\"normaltxtmidb2\" ><div id=\"boxdiv1\" >";
		$styleRow.="<div  class=\"tableCellProductPlan2\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
		$styleRow.="<div  class=\"tableCellProductPlan2\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Style No.</div>";			
		
		for($i=0;$i<$days;$i++){
		
			$flag1=true;
			
			$SQL2="select intTeamId as num from plan_calender where intTeamId='".$arrTeams[$tmIndex]."' and dtmDate='".$Dates[$i]."' and dblWorkingHours>0;";
			
			$result2 = $db->RunQuery($SQL2);
			
			while($row3 = mysql_fetch_array($result2))
			{
				$SQL1="select intID,strStyleID,startDate,endDate from plan_stripes where intTeamNo='".$arrTeams[$tmIndex]."' and startDate<='".$Dates[$i]."' and  endDate>='".$Dates[$i]."' order by endDate;";		
				$result1 = $db->RunQuery($SQL1);
				
				$dayRepeat=false;
				
				while($row2 = mysql_fetch_array($result1))
				{														
					$styleRow.="<div  class=\"tableCellProductPlan2\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$row2["strStyleID"]."</div>";
					$flag1=false;
					if($dayRepeat)$i++;
					$dayRepeat=true;
					$Stripes[$arrTeams[$tmIndex]][$i]=$row2["intID"];
					$Style[$arrTeams[$tmIndex]][$i]=$row2["strStyleID"];											
				}										
			}
			
			if($flag1){
				$styleRow.="<div  class=\"tableCellProductPlan2\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";		
				$Stripes[$arrTeams[$tmIndex]][$i]=0;
				$Style[$arrTeams[$tmIndex]][$i]=0;
			}
			$maxDays=1;
			
			for($k=0;$k<count($arrTeams);$k++){
				if(($arrTeams[$k]!=$arrTeams[$tmIndex])&&($maxDays<$Arr[$arrTeams[$k]][$Dates[$i]]))
					$maxDays=$Arr[$arrTeams[$k]][$Dates[$i]];
			}
			
			for($j=1;$j<$maxDays;$j++){
				$styleRow.="<div  class=\"tableCellProductPlan2\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";		
				$i++;
				$Stripes[$arrTeams[$tmIndex]][$i]=0;
				$Style[$arrTeams[$tmIndex]][$i]=0;
			}
		}				
		
		$styleRow.="</div></td></tr>";
		$Response.=$styleRow;	
		$Response.="<tr><td  class=\"normaltxtmidb2\" ><div id=\"boxdiv1\" >";
		
		$SQL4="select strTeam from plan_teams where intTeamNo='".$arrTeams[$tmIndex]."';";
		$result4 = $db->RunQuery($SQL4);
		while($row5 = mysql_fetch_array($result4)){
		
			$Response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">".$row5["strTeam"]."</div>";			
		}
		$effRow="";
		$effRow.="<tr><td  class=\"normaltxtmidb2\" ><div id=\"boxdiv1\" >";
		$effRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
		$effRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Planned Eff</div>";
		
		for($i=0;$i<count($Dates);$i++){
		
			if($Stripes[$arrTeams[$tmIndex]][$i]==0)
				
				$effRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";	
				
			
			else
				
				$effRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates[$i]]."</div>";
							
		}
			
		$effRow.="</div></td></tr>";		
			
		$Response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Planned Qty</div>";
		
		for($i=0;$i<$days;$i++)
		{
		
			if($Stripes[$arrTeams[$tmIndex]][$i]==0){
				$Response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";				
				$PlannedQty[$arrTeams[$tmIndex]][$i]=0;				
			}
			else{
				$SMV=0;
				
				$sql1 ="select dblSewwingSmv from orders where intStyleID='".$Style[$arrTeams[$tmIndex]][$i]."';";
				$result1 = $db->RunQuery($sql1);
				while($row1=mysql_fetch_array($result1))
				{
					$SMV=$row1["dblSewwingSmv"];		
				}
				
				$SQL="select dblWorkingHours,intMachines from plan_calender where dtmDate='".$Dates[$i]."' and intTeamId='".$arrTeams[$tmIndex]."';";
				$result = $db->RunQuery($SQL);
				
				$SQL2 = "SELECT startTime,endTime,startDate,endDate FROM plan_stripes
						WHERE intID='".$Stripes[$arrTeams[$tmIndex]][$i]."';";
				$result2 = $db->RunQuery($SQL2);
				$row2 = mysql_fetch_array($result2);
				
				
				while($row = mysql_fetch_array($result))
				{
					//$Stripes[$arrTeams[$tmIndex]][$i];
					
					$workingTime = split("[.]",$row["dblWorkingHours"]);
					$workingMinutes=($workingTime[0]*60)+$workingTime[1];
					
					if($Dates[$i]==$row2['startDate'] && $Dates[$i]==$row2['endDate'])
					{
						//echo $row2['endTime']-$row2["startTime"];
				   		$PlannedQty[$arrTeams[$tmIndex]][$i]=round((($row2['endTime']-$row2["startTime"])*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates[$i]])/(100*$SMV));
					}
		
					else if($Dates[$i]==$row2['startDate'])
					{
						//echo ($row["dblWorkingHours"]*60);
						$PlannedQty[$arrTeams[$tmIndex]][$i]=round((($workingMinutes-$row2["startTime"])*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates[$i]])/(100*$SMV));
					}	
					else if($Dates[$i]==$row2['endDate'])
						$PlannedQty[$arrTeams[$tmIndex]][$i]=round((($row2["endTime"])*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates[$i]])/(100*$SMV));
					
					else
						$PlannedQty[$arrTeams[$tmIndex]][$i]=round(($workingMinutes*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates[$i]])/(100*$SMV));
						
					$Response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$PlannedQty[$arrTeams[$tmIndex]][$i]."</div>";
													
				}
			}
		}	
			
		$Response.="</div></td></tr>"; 
		$plndttlROW="";
		$plndttlROW.="<tr><td  class=\"normaltxtmidb2\" ><div id=\"boxdiv1\" >";
		$plndttlROW.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
		$plndttlROW.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Planned TTL</div>";
		
		for($i=0;$i<$days;$i++){
		
			$SQL1="select startDate,endDate,startTime,endTime from plan_stripes where intID='".$Stripes[$arrTeams[$tmIndex]][$i]."';";		
			$result1 = $db->RunQuery($SQL1);
			
			while($row1 = mysql_fetch_array($result1))
			{			
				$SMV=0;
				
				$SQL2 ="select dblSewwingSmv from orders where intStyleID='".$Style[$arrTeams[$tmIndex]][$i]."';";
				$result2 = $db->RunQuery($SQL2);
				while($row2=mysql_fetch_array($result2))
				{
					$SMV=$row2["dblSewwingSmv"];		
				}
				
				$startDateArr = explode("-", $row1["startDate"]);		  
				$tmpdate = mktime(0,0,0,$startDateArr[1],$startDateArr[2],$startDateArr[0]);
				$PlannedcumTtl[$arrTeams[$tmIndex]][$i]=0;
				while(date("Y-m-d", $tmpdate)<=$Dates[$i])
				{
				
					$SQL="select dblWorkingHours,intMachines from plan_calender where dtmDate='".date("Y-m-d", $tmpdate)."' and intTeamId='".$arrTeams[$tmIndex]."';";
					$result = $db->RunQuery($SQL);
					
						
				/*$SQL3 = "SELECT startTime,endTime,startDate,endDate FROM plan_stripes
						WHERE intID='".$Stripes[$arrTeams[$tmIndex]][$i]."';";
				$result3 = $db->RunQuery($SQL3);
				$row3 = mysql_fetch_array($result3);*/
					
					
					while($row = mysql_fetch_array($result)) 
					{
					
					$workingTime1 = split("[.]",$row["dblWorkingHours"]);
					$workingMinutes1=($workingTime1[0]*60)+$workingTime1[1];
					
					if(date("Y-m-d", $tmpdate)==$row1['startDate'] && date("Y-m-d", $tmpdate)==$row1['endDate'])
				   		$PlannedcumTtl[$arrTeams[$tmIndex]][$i]+=round((($row1['endTime']-$row1["startTime"])*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates[$i]])/(100*$SMV));
							
					else if(date("Y-m-d", $tmpdate)==$row1['startDate'])
						$PlannedcumTtl[$arrTeams[$tmIndex]][$i]+=round((($workingMinutes1-$row1["startTime"])*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates[$i]])/(100*$SMV));
						
					else if(date("Y-m-d", $tmpdate)==$row1['endDate'])
						$PlannedcumTtl[$arrTeams[$tmIndex]][$i]+=round((($row1["endTime"])*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates[$i]])/(100*$SMV));
					
					else
						$PlannedcumTtl[$arrTeams[$tmIndex]][$i]+=round(($workingMinutes1*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates[$i]])/(100*$SMV));
					

											//$PlannedcumTtl[$arrTeams[$tmIndex]][$i]+=round(($row["dblWorkingHours"]*60*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][date("Y-m-d", $tmpdate)])/(100*$SMV));
						
					}
					$tmpdate+=24 * 60 * 60;
				}
			}			
			
			if($Stripes[$arrTeams[$tmIndex]][$i]!=0){
				/*
				$PlannedcumTtl[$arrTeams[$tmIndex]][$i]=0;
				
				for($k=0;$k<=$i;$k++){
				
					if($Stripes[$arrTeams[$tmIndex]][$i]==$Stripes[$arrTeams[$tmIndex]][$k])
						$PlannedcumTtl[$arrTeams[$tmIndex]][$i]+=$PlannedQty[$arrTeams[$tmIndex]][$k];
				}
				*/
				$plndttlROW.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$PlannedcumTtl[$arrTeams[$tmIndex]][$i]."</div>";
				
			}
			else
				$plndttlROW.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
		}	
			
		$plndttlROW.="</div></td></tr>";
		
		if($pTTL=="TRUE")$Response.=$plndttlROW;
		$plndttlROW="";
		if($pEfy=="TRUE")$Response.=$effRow;
		$effRow="";
		
		if($aQty=="TRUE"||$aTTL=="TRUE"||$aEfy=="TRUE")$Response.=$styleRow;
		$styleRow="";
		
		$actQtyRow="";
		$actQtyRow.="<tr><td  class=\"normaltxtmidb2\" ><div id=\"boxdiv1\" >";
		
			$actQtyRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
			$actQtyRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Actual Qty</div>";
						
			for($i=0;$i<$days;$i++){
			
				$SQL1="select count(dblProducedQty) as num,dblProducedQty from plan_actualproduction where intTeamNo='".$arrTeams[$tmIndex]."' and date='".$Dates[$i]."';";		
				$result1 = $db->RunQuery($SQL1);
				while($row2 = mysql_fetch_array($result1))
				{
					if($row2["num"]!=0){
						$actQtyRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".round($row2["dblProducedQty"])."</div>";	
						$ActualQty[$arrTeams[$tmIndex]][$i]=round($row2["dblProducedQty"]);
					}
					else
						$actQtyRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";			
				}
			}	
		
		$actQtyRow.="</div></td></tr>";
		
		if($aQty=="TRUE")$Response.=$actQtyRow;
		$actQtyRow="";
		
		$actTTLRow="";
		$actTTLRow.="<tr><td  class=\"normaltxtmidb2\" ><div id=\"boxdiv1\" >";
		
			$actTTLRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
			$actTTLRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Actual TTL</div>";
		
			$tmpStripeID="";
			
			for($i=0;$i<$days;$i++){
			
				$SQL1="select intStripeID,count(intStripeID) as sum from plan_actualproduction where intTeamNo='".$arrTeams[$tmIndex]."' and date='".$Dates[$i]."';";		
				$result1 = $db->RunQuery($SQL1);
				while($row2 = mysql_fetch_array($result1))
				{
					if($row2["sum"]>0){
					
						if($tmpStripeID==$row2["intStripeID"]){
						
							$SQL2="select sum(dblProducedQty) as sum, count(*) as num from plan_actualproduction where intTeamNo='".$arrTeams[$tmIndex]."' and date<='".$Dates[$i]."' and intStripeID='".$tmpStripeID."';";	
							
						}
						else{
							$tmpStripeID=$row2["intStripeID"];
							$SQL2="select sum(dblProducedQty) as sum, count(*) as num from plan_actualproduction where intTeamNo='".$arrTeams[$tmIndex]."' and date<='".$Dates[$i]."' and intStripeID='".$row2["intStripeID"]."';";
							
						}
						
						$result2 = $db->RunQuery($SQL2);
						while($row3 = mysql_fetch_array($result2))
						{
							if($row3["num"]>0){
								$actTTLRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".round($row3["sum"])."</div>";		
								$ActualcumTtl[$arrTeams[$tmIndex]][$i]=round($row3["sum"]);
							}
							else{
								$actTTLRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";			
								$ActualcumTtl[$arrTeams[$tmIndex]][$i]=0;
							}
						}
					}
					else{
						$actTTLRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";	
						$ActualcumTtl[$arrTeams[$tmIndex]][$i]=0;
					}
				}
			}	
		
		$actTTLRow.="</div></td></tr>";
		
		if($aTTL=="TRUE")$Response.=$actTTLRow;
		$actTTLRow="";
		
		$actEffRow="";
		$actEffRow.="<tr><td  class=\"normaltxtmidb2\" ><div id=\"boxdiv1\" >";		
		$actEffRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
		$actEffRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Actual Eff</div>";
	
		for($i=0;$i<$days;$i++){
		
			if($Stripes[$arrTeams[$tmIndex]][$i]==0){
			
				$actEffRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";				
				$PlannedQty[$arrTeams[$tmIndex]][$i]=0;				
			}
			
			else{
			
				$SMV=0;
				
				$sql1 ="select dblSewwingSmv from orders where intStyleID='".$Style[$arrTeams[$tmIndex]][$i]."';";
				$result1 = $db->RunQuery($sql1);
				
				while($row1=mysql_fetch_array($result1))
				{
					$SMV=$row1["dblSewwingSmv"];		
				}
				
				$SQL="select dblWorkingHours,intMachines from plan_calender where dtmDate='".$Dates[$i]."' and intTeamId='".$arrTeams[$tmIndex]."';";
				$result = $db->RunQuery($SQL);
				
				while($row = mysql_fetch_array($result))
				{		
					if($ActualQty[$arrTeams[$tmIndex]][$i]==0)
						$actEffRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
					else			
						$actEffRow.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".round(($ActualQty[$arrTeams[$tmIndex]][$i]*100*$SMV)/($row["dblWorkingHours"]*60*$row["intMachines"]))."</div>";								
				}
			}
		}	
		
		$actEffRow.="</div></td></tr>";
		
		if($aEfy=="TRUE")$Response.=$actEffRow;
		$actEffRow="";
		
		$varRow="";
		$varRow.="<tr><td  class=\"normaltxtmidb2\" ><div id=\"boxdiv1\" >";

			$varRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
			$varRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Variance</div>";
			
			for($i=0;$i<$days;$i++){
			
				if($PlannedcumTtl[$arrTeams[$tmIndex]][$i]==0||$ActualcumTtl[$arrTeams[$tmIndex]][$i]==0)
					$varRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
				else
				{
					$varRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".($ActualcumTtl[$arrTeams[$tmIndex]][$i]-$PlannedcumTtl[$arrTeams[$tmIndex]][$i])."</div>";
					//$shortQty=$ActualcumTtl[$arrTeams[$tmIndex]][$i]-$PlannedcumTtl[$arrTeams[$tmIndex]][$i];
				}
					
			}
			
			
			
			
			
			
			
			
			
			
		$varRow.="</div></td></tr>";
		if($aQty=="TRUE"||$aTTL=="TRUE"||$aEfy=="TRUE")$Response.=$varRow;
		$varRow="";
		
		$varRow.="<tr><td  class=\"normaltxtmidb2\" ><div id=\"boxdiv1\" >";

			$varRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
			$varRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Sugg:Qty</div>";
			
			for($i=0;$i<$days;$i++)
			{
			
			$SQL1="select startDate,endDate,startTime,endTime from plan_stripes where intID='".$Stripes[$arrTeams[$tmIndex]][$i]."';";		
			$result1 = $db->RunQuery($SQL1);
			$row1=mysql_fetch_array($result1);
			
			$stripId=$Stripes[$arrTeams[$tmIndex]][$i];
					
			$SQL_getDate="SELECT plan_actualproduction.date FROM plan_actualproduction WHERE plan_actualproduction.intStripeId=$stripId ORDER BY date DESC LIMIT 1;";
			$result_getDate = $db->RunQuery($SQL_getDate);
			$row_getDate = mysql_fetch_array($result_getDate);
			
			$date1 = $row1['endDate'];
			$date2 = $row_getDate['date'];
			
			$sql_getHolidays="SELECT COUNT(strDayStatus) AS Holidays FROM plan_calender
			WHERE (strDayStatus='sunday' OR strDayStatus='off') AND dtmDate>='$date2' AND dtmDate<='$date1' AND intTeamId=$arrTeams[$tmIndex];";
			$result_getHolidays = $db->RunQuery($sql_getHolidays);
			$row_getHolidays = mysql_fetch_array($result_getHolidays);
			
			
			

			$diff1 = (strtotime($date1) - strtotime($date2))/(60*60*24);
		
			$diff  = $diff1-$row_getHolidays['Holidays'];
			
			
			
			if($PlannedcumTtl[$arrTeams[$tmIndex]][$i]==0 && $ActualcumTtl[$arrTeams[$tmIndex]][$i]==0)
					$varRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
			else
			{
			
				if($Dates[$i]<=$row_getDate['date'])
				{
					$shortQty=$ActualcumTtl[$arrTeams[$tmIndex]][$i]-$PlannedcumTtl[$arrTeams[$tmIndex]][$i];
					$suggQty=0;
				}
				else
					$suggQty=round(($PlannedQty[$arrTeams[$tmIndex]][$i]-($shortQty/$diff)));
				
				$varRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$suggQty."</div>";
			}
			
			}
			
			
			
			
			
		$varRow.="</div></td></tr>";
		if($aQty=="TRUE"||$aTTL=="TRUE"||$aEfy=="TRUE")$Response.=$varRow;
		
		
			
			
		
			
			
			
			
			
	}
	
	
	$Response.="</table>";
	//echo $Response;
}

?>
