<?php
//session_start();
include "../../Connector.php";

//global $objPHPExcel;
error_reporting(E_ALL);
require_once '../../excel/Classes/PHPExcel.php';
require_once '../../excel/Classes/PHPExcel/IOFactory.php';

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
	
	$Letters=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	
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
	$Dates["Col"];
	$Dates["Date"];
	$Stripes;
	$stripesDays;
	$Efficiency;
	$PlannedQty;
	$ActualQty;
	$PlannedcumTtl;
	$ActualcumTtl;
	$shortQty;
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
				{/*
					$SQL3="select dblWorkingHours from plan_calender where intTeamId='".$row1["intTeamNo"]."' and dtmDate>='".$row2["startDate"]."' and dtmDate<='".$row2["endDate"]."';";		
					$result3 = $db->RunQuery($SQL3);
					$completedHours=0;
					*/
					if($flag1){
						$flag1=false;	
						$Arr[$row1["intTeamNo"]][date("Y-m-d", $tmpdate)]=1;																											
					}
					else{							
						$Arr[$row1["intTeamNo"]][date("Y-m-d", $tmpdate)]+=1;	
						$days1++;							
					}	
					$stripesDays[$row2["intID"]];
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
						else{
							$SQL3="select intCurveDay,dblEfficency from plan_learningcurve where strCurve='".$row2["intLearningCuveId"]."';";
							$result3 = $db->RunQuery($SQL3);
							$maxEfficiency1=0;
							$flag11=true;
							
							while($row4 = mysql_fetch_array($result3)){
								
								if($day==$row4["intCurveDay"]){
								
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
	
	$tmpdate1=$startDate;	
	
	for($i=0,$index=0;$i<$numDays;$i++){		
		
		$maxDays=1;
		
		for($tmIndex=0;$tmIndex<count($arrTeams);$tmIndex++){
		
			if($maxDays<$Arr[$arrTeams[$tmIndex]][date("Y-m-d", $tmpdate1)])
				$maxDays=$Arr[$arrTeams[$tmIndex]][date("Y-m-d", $tmpdate1)];
		}
		
		for($j=1;$j<=$maxDays;$j++){
		
			$num1=floor(($index+2)/26);
			$num2=($index+2)%26;
			
			if($num1==0)
				$Dates["Col"][$index]=$Letters[$num2];
			else
				$Dates["Col"][$index]=$Letters[$num1]."".$Letters[$num2];	
			
			$objPHPExcel->getActiveSheet()->getColumnDimension($Dates["Col"][$index])->setWidth(15);
			$objPHPExcel->getActiveSheet()->setCellValue($Dates["Col"][$index]."3",date("d", $tmpdate1)."/".date("M", $tmpdate1));
			$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$index]."3")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);			
			$Dates["Date"][$index++]=date("Y-m-d", $tmpdate1);	
		}		
		$tmpdate1+=24 * 60 * 60;				
	}	
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
	
	for($tmIndex=0;$tmIndex<count($arrTeams);$tmIndex++){
	
		for($i=0;$i<count($Dates["Date"]);$i++){
			
			$flag1=true;
			
			$SQL2="select intTeamId as num from plan_calender where intTeamId='".$arrTeams[$tmIndex]."' and dtmDate='".$Dates["Date"][$i]."' and dblWorkingHours>0;";
			
			$result2 = $db->RunQuery($SQL2);
			
			while($row3 = mysql_fetch_array($result2))
			{
				$SQL1="select intID,strStyleID,startDate,endDate,totalHours from plan_stripes where intTeamNo='".$arrTeams[$tmIndex]."' and startDate<='".$Dates["Date"][$i]."' and  endDate>='".$Dates["Date"][$i]."' order by endDate;";		
				$result1 = $db->RunQuery($SQL1);
				
				$dayRepeat=false;
				
				while($row2 = mysql_fetch_array($result1))
				{									
					$flag1=false;
					if($dayRepeat)$i++;
					$dayRepeat=true;
					$Stripes[$arrTeams[$tmIndex]][$i]=$row2["intID"];
					$Style[$arrTeams[$tmIndex]][$i]=$row2["strStyleID"];	
					$objPHPExcel->getActiveSheet()->setCellValue($Dates["Col"][$i].($tmIndex*10+4),$row2["strStyleID"]);
					$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+4))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->setCellValue($Dates["Col"][$i].($tmIndex*10+8),$row2["strStyleID"]);
					$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+8))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);										
				}										
			}
			
			if($flag1){
				$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+4))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+8))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
				$Stripes[$arrTeams[$tmIndex]][$i]=0;
				$Style[$arrTeams[$tmIndex]][$i]=0;
			}
			$maxDays=1;
			
			for($k=0;$k<count($arrTeams);$k++){
				if(($arrTeams[$k]!=$arrTeams[$tmIndex])&&($maxDays<$Arr[$arrTeams[$k]][$Dates["Date"][$i]]))
					$maxDays=$Arr[$arrTeams[$k]][$Dates["Date"][$i]];
			}
			
			for($j=1;$j<$maxDays;$j++){
				$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+4))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+8))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
				$i++;
				$Stripes[$arrTeams[$tmIndex]][$i]=0;
				$Style[$arrTeams[$tmIndex]][$i]=0;
			}
		}
		
		$SQL4="select strTeam from plan_teams where intTeamNo='".$arrTeams[$tmIndex]."';";
		$result4 = $db->RunQuery($SQL4);
		while($row5 = mysql_fetch_array($result4)){
		
			$objPHPExcel->getActiveSheet()->setCellValue('A'.($tmIndex*10+5),$row5["strTeam"]);
			$objPHPExcel->getActiveSheet()->getStyle('A'.($tmIndex*10+5))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);		
		}
		
		
		
		for($i=0;$i<count($Dates["Date"]);$i++){
		
			if($Stripes[$arrTeams[$tmIndex]][$i]==0)
				
				$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+7))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				//$effRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";	
				
			
			else{
				$objPHPExcel->getActiveSheet()->setCellValue($Dates["Col"][$i].($tmIndex*10+7),$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates["Date"][$i]]);
				$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+7))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				
				//$effRow.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates[$i]]."</div>";
			}			
		}
		
		for($i=0;$i<count($Dates["Date"]);$i++){	
		
			if($Stripes[$arrTeams[$tmIndex]][$i]==0){
				$PlannedQty[$arrTeams[$tmIndex]][$i]=0;		
				$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+5))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);		
			}
			else{
				$SMV=0;
				
				$sql1 ="select dblSewwingSmv from orders where intStyleID='".$Style[$arrTeams[$tmIndex]][$i]."';";
				$result1 = $db->RunQuery($sql1);
				while($row1=mysql_fetch_array($result1))
				{
					$SMV=$row1["dblSewwingSmv"];		
				}
				
				$SQL="select dblWorkingHours,intMachines from plan_calender where dtmDate='".$Dates["Date"][$i]."' and intTeamId='".$arrTeams[$tmIndex]."';";
				$result = $db->RunQuery($SQL);
				
				$SQL2 = "SELECT startTime,endTime,startDate,endDate FROM plan_stripes WHERE intID='".$Stripes[$arrTeams[$tmIndex]][$i]."';";
				$result2 = $db->RunQuery($SQL2);
				$row2 = mysql_fetch_array($result2);
				
				while($row = mysql_fetch_array($result))
				{
					//$PlannedQty[$arrTeams[$tmIndex]][$i]=round(($row["dblWorkingHours"]*60*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates["Date"][$i]])/(100*$SMV));
					
					$workingTime = split("[.]",$row["dblWorkingHours"]);
					$workingMinutes=($workingTime[0]*60)+$workingTime[1];
					
					if($Dates["Date"][$i]==$row2['startDate'] && $Dates["Date"][$i]==$row2['endDate'])
					{
						//echo $row2['endTime']-$row2["startTime"];
				   		$PlannedQty[$arrTeams[$tmIndex]][$i]=round((($row2['endTime']-$row2["startTime"])*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates["Date"][$i]])/(100*$SMV));
					}
		
					else if($Dates["Date"][$i]==$row2['startDate'])
					{
						//echo ($row["dblWorkingHours"]*60);
						$PlannedQty[$arrTeams[$tmIndex]][$i]=round((($workingMinutes-$row2["startTime"])*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates["Date"][$i]])/(100*$SMV));
					}	
					else if($Dates["Date"][$i]==$row2['endDate'])
						$PlannedQty[$arrTeams[$tmIndex]][$i]=round((($row2["endTime"])*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates["Date"][$i]])/(100*$SMV));
					
					else
						$PlannedQty[$arrTeams[$tmIndex]][$i]=round(($workingMinutes*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates["Date"][$i]])/(100*$SMV));
					
					
					$objPHPExcel->getActiveSheet()->setCellValue($Dates["Col"][$i].($tmIndex*10+5),$PlannedQty[$arrTeams[$tmIndex]][$i]);
					$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+5))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);							
				}
			}
		}	
		
		for($i=0;$i<count($Dates["Date"]);$i++){	
		
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
				while(date("Y-m-d", $tmpdate)<=$Dates["Date"][$i]){
				
					$SQL="select dblWorkingHours,intMachines from plan_calender where dtmDate='".date("Y-m-d", $tmpdate)."' and intTeamId='".$arrTeams[$tmIndex]."';";
					$result = $db->RunQuery($SQL);
					while($row = mysql_fetch_array($result))
					{
					
						$workingTime1 = split("[.]",$row["dblWorkingHours"]);
					$workingMinutes1=($workingTime1[0]*60)+$workingTime1[1];
					
					if(date("Y-m-d", $tmpdate)==$row1['startDate'] && date("Y-m-d", $tmpdate)==$row1['endDate'])
				   		$PlannedcumTtl[$arrTeams[$tmIndex]][$i]+=round((($row1['endTime']-$row1["startTime"])*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates["Date"][$i]])/(100*$SMV));
							
					else if(date("Y-m-d", $tmpdate)==$row1['startDate'])
						$PlannedcumTtl[$arrTeams[$tmIndex]][$i]+=round((($workingMinutes1-$row1["startTime"])*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates["Date"][$i]])/(100*$SMV));
						
					else if(date("Y-m-d", $tmpdate)==$row1['endDate'])
						$PlannedcumTtl[$arrTeams[$tmIndex]][$i]+=round((($row1["endTime"])*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates["Date"][$i]])/(100*$SMV));
					
					else
						$PlannedcumTtl[$arrTeams[$tmIndex]][$i]+=round(($workingMinutes1*$row["intMachines"]*$stripesDays[$Stripes[$arrTeams[$tmIndex]][$i]][$Dates["Date"][$i]])/(100*$SMV));
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
				$objPHPExcel->getActiveSheet()->setCellValue($Dates["Col"][$i].($tmIndex*10+6),$PlannedcumTtl[$arrTeams[$tmIndex]][$i]);
				$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+6))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				
			}
			else
				$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+6))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}
		
		for($i=0;$i<count($Dates["Date"]);$i++){	
			
			$SQL1="select count(dblProducedQty) as num,dblProducedQty from plan_actualproduction where intTeamNo='".$arrTeams[$tmIndex]."' and date='".$Dates["Date"][$i]."';";		
			$result1 = $db->RunQuery($SQL1);
			while($row2 = mysql_fetch_array($result1))
			{
				if($row2["num"]!=0){
					$objPHPExcel->getActiveSheet()->setCellValue($Dates["Col"][$i].($tmIndex*10+9),round($row2["dblProducedQty"]));
					$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+9))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$ActualQty[$arrTeams[$tmIndex]][$i]=round($row2["dblProducedQty"]);
				}
				else
					$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+9))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			}
		}	
		
		$tmpStripeID="";
		
		for($i=0;$i<count($Dates["Date"]);$i++){	
		
			$SQL1="select intStripeID,count(intStripeID) as sum from plan_actualproduction where intTeamNo='".$arrTeams[$tmIndex]."' and date='".$Dates["Date"][$i]."';";		
			$result1 = $db->RunQuery($SQL1);
			while($row2 = mysql_fetch_array($result1))
			{
				if($row2["sum"]>0){
				
					if($tmpStripeID==$row2["intStripeID"]){
					
						$SQL2="select sum(dblProducedQty) as sum, count(*) as num from plan_actualproduction where intTeamNo='".$arrTeams[$tmIndex]."' and date<='".$Dates["Date"][$i]."' and intStripeID='".$tmpStripeID."';";	
						
					}
					else{
						$tmpStripeID=$row2["intStripeID"];
						$SQL2="select sum(dblProducedQty) as sum, count(*) as num from plan_actualproduction where intTeamNo='".$arrTeams[$tmIndex]."' and date<='".$Dates["Date"][$i]."' and intStripeID='".$row2["intStripeID"]."';";
						
					}
					
					$result2 = $db->RunQuery($SQL2);
					while($row3 = mysql_fetch_array($result2))
					{
						if($row3["num"]>0){
								
							$ActualcumTtl[$arrTeams[$tmIndex]][$i]=round($row3["sum"]);
							$objPHPExcel->getActiveSheet()->setCellValue($Dates["Col"][$i].($tmIndex*10+10),round($row3["sum"]));
							$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+10))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
						}
						else{
							$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+10))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
							$ActualcumTtl[$arrTeams[$tmIndex]][$i]=0;
						}
					}
				}
				else{
					$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+10))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$ActualcumTtl[$arrTeams[$tmIndex]][$i]=0;
				}
			}
		}
		
		for($i=0;$i<count($Dates["Date"]);$i++){	
		
			if($Stripes[$arrTeams[$tmIndex]][$i]==0){
			
				$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+11))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
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
				
				$SQL="select dblWorkingHours,intMachines from plan_calender where dtmDate='".$Dates["Date"][$i]."' and intTeamId='".$arrTeams[$tmIndex]."';";
				$result = $db->RunQuery($SQL);
				
				while($row = mysql_fetch_array($result))
				{		
					if($ActualQty[$arrTeams[$tmIndex]][$i]==0)
						$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+11))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					else{
						$objPHPExcel->getActiveSheet()->setCellValue($Dates["Col"][$i].($tmIndex*10+11),round(($ActualQty[$arrTeams[$tmIndex]][$i]*100*$SMV)/($row["dblWorkingHours"]*60*$row["intMachines"])));
						$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+11))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);											
					}					
				}
			}
		}
		
			
		
		for($i=0;$i<count($Dates["Date"]);$i++){	
			
			if($PlannedcumTtl[$arrTeams[$tmIndex]][$i]==0||$ActualcumTtl[$arrTeams[$tmIndex]][$i]==0)
				$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+12))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			else{
				$Response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".($ActualcumTtl[$arrTeams[$tmIndex]][$i]-$PlannedcumTtl[$arrTeams[$tmIndex]][$i])."</div>";
					$objPHPExcel->getActiveSheet()->setCellValue($Dates["Col"][$i].($tmIndex*10+12),($ActualcumTtl[$arrTeams[$tmIndex]][$i]-$PlannedcumTtl[$arrTeams[$tmIndex]][$i]));
					$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+12))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			}				
		}
		
		
			$shortQty=0;
			$suggQty=0;
		for($i=0;$i<count($Dates["Date"]);$i++)
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
					$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+13))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				else
				{
			
					if($Dates["Date"][$i]<=$row_getDate['date'])
					{
						$shortQty=$ActualcumTtl[$arrTeams[$tmIndex]][$i]-$PlannedcumTtl[$arrTeams[$tmIndex]][$i];
						$suggQty=0;
					}
					else
						$suggQty=round(($PlannedQty[$arrTeams[$tmIndex]][$i]-($shortQty/$diff)));
						//$suggQty=number_format(($PlannedcumTtl[$arrTeams[$tmIndex]][$i]-($shortQty/$diff)), 2, '.','');
					
						$Response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".($suggQty)."</div>";
						$objPHPExcel->getActiveSheet()->setCellValue($Dates["Col"][$i].($tmIndex*10+13),($suggQty));
						$objPHPExcel->getActiveSheet()->getStyle($Dates["Col"][$i].($tmIndex*10+13))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				}
			
			}
		
		
		
		
		
		
		
		
		
		
		
		
		
		$objPHPExcel->getActiveSheet()->setCellValue('B'.($tmIndex*10+4),'Style No.');
		$objPHPExcel->getActiveSheet()->getStyle('A'.($tmIndex*10+4))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('B'.($tmIndex*10+4))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->duplicateStyleArray(
		array(
			'font'    => array(
				'size'      => 8
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'bottom'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
				'left'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK,
				),
				'right'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK,
				)				
			),
			'fill' => array(
				
				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
				'rotation'   => 90,
				'startcolor' => array(
					'argb' => '00f3f7fa'
				)
			)
		),
		'A'.($tmIndex*10+4).':'.$Dates["Col"][count($Dates["Col"])-1].($tmIndex*10+4));		
		
		$objPHPExcel->getActiveSheet()->setCellValue('B'.($tmIndex*10+5),'Planned Qty');
		$objPHPExcel->getActiveSheet()->getStyle('B'.($tmIndex*10+5))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->duplicateStyleArray(
			array(			
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
					'left'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					)				
				),
				'fill' => array(
					
					'type'       => PHPExcel_Style_Fill::FILL_SOLID,
					'rotation'   => 90,
					'startcolor' => array(
						'argb' => '00F8DDB6'
					)
				)
			),
			'A'.($tmIndex*10+5).':'.$Dates["Col"][count($Dates["Col"])-1].($tmIndex*10+5));
			
		$objPHPExcel->getActiveSheet()->setCellValue('B'.($tmIndex*10+6),'Planned TTL');
		$objPHPExcel->getActiveSheet()->getStyle('B'.($tmIndex*10+6))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->duplicateStyleArray(
			array(			
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
					'left'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					)				
				),
				'fill' => array(
					
					'type'       => PHPExcel_Style_Fill::FILL_SOLID,
					'rotation'   => 90,
					'startcolor' => array(
						'argb' => '00F8DDB6'
					)
				)
			),
			'A'.($tmIndex*10+6).':'.$Dates["Col"][count($Dates["Col"])-1].($tmIndex*10+6));
			
		$objPHPExcel->getActiveSheet()->setCellValue('B'.($tmIndex*10+7),'Planned Eff');
		$objPHPExcel->getActiveSheet()->getStyle('B'.($tmIndex*10+7))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->duplicateStyleArray(
			array(			
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
					'left'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					)				
				),
				'fill' => array(
					
					'type'       => PHPExcel_Style_Fill::FILL_SOLID,
					'rotation'   => 90,
					'startcolor' => array(
						'argb' => '00F8DDB6'
					)
				)
			),
			'A'.($tmIndex*10+7).':'.$Dates["Col"][count($Dates["Col"])-1].($tmIndex*10+7));
			
		$objPHPExcel->getActiveSheet()->setCellValue('B'.($tmIndex*10+8),'Style No.');
		$objPHPExcel->getActiveSheet()->getStyle('A'.($tmIndex*10+8))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);		
		$objPHPExcel->getActiveSheet()->getStyle('B'.($tmIndex*10+8))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->duplicateStyleArray(
		array(
			'font'    => array(
				'size'      => 8
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'bottom'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
				'left'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK,
				),
				'right'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK,
				)				
			),
			'fill' => array(
				
				'type'       => PHPExcel_Style_Fill::FILL_SOLID,
				'rotation'   => 90,
				'startcolor' => array(
					'argb' => '00f3f7fa'
				)
			)
		),
		'A'.($tmIndex*10+8).':'.$Dates["Col"][count($Dates["Col"])-1].($tmIndex*10+8));
		
		$objPHPExcel->getActiveSheet()->setCellValue('B'.($tmIndex*10+9),'Actual Qty');
		$objPHPExcel->getActiveSheet()->getStyle('B'.($tmIndex*10+9))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->duplicateStyleArray(
			array(			
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
					'left'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					)				
				),
				'fill' => array(
					
					'type'       => PHPExcel_Style_Fill::FILL_SOLID,
					'rotation'   => 90,
					'startcolor' => array(
						'argb' => '00FFE8DA'
					)
				)
			),
			'A'.($tmIndex*10+9).':'.$Dates["Col"][count($Dates["Col"])-1].($tmIndex*10+9));
			
		$objPHPExcel->getActiveSheet()->setCellValue('B'.($tmIndex*10+10),'Actual TTL');
		$objPHPExcel->getActiveSheet()->getStyle('B'.($tmIndex*10+10))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->duplicateStyleArray(
			array(			
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
					'left'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					)				
				),
				'fill' => array(
					
					'type'       => PHPExcel_Style_Fill::FILL_SOLID,
					'rotation'   => 90,
					'startcolor' => array(
						'argb' => '00FFE8DA'
					)
				)
			),
			'A'.($tmIndex*10+10).':'.$Dates["Col"][count($Dates["Col"])-1].($tmIndex*10+10));
			
		$objPHPExcel->getActiveSheet()->setCellValue('B'.($tmIndex*10+11),'Actual Eff');
		$objPHPExcel->getActiveSheet()->getStyle('B'.($tmIndex*10+11))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->duplicateStyleArray(
			array(			
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
					'left'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					)				
				),
				'fill' => array(
					
					'type'       => PHPExcel_Style_Fill::FILL_SOLID,
					'rotation'   => 90,
					'startcolor' => array(
						'argb' => '00FFE8DA'
					)
				)
			),
			'A'.($tmIndex*10+11).':'.$Dates["Col"][count($Dates["Col"])-1].($tmIndex*10+11));
			
		$objPHPExcel->getActiveSheet()->setCellValue('B'.($tmIndex*10+12),'Variance');
		$objPHPExcel->getActiveSheet()->getStyle('B'.($tmIndex*10+12))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->duplicateStyleArray(
			array(			
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
					'left'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					)				
				),
				'fill' => array(
					
					'type'       => PHPExcel_Style_Fill::FILL_SOLID,
					'rotation'   => 90,
					'startcolor' => array(
						'argb' => '00F8DDB6'
					)
				)
			),
			'A'.($tmIndex*10+12).':'.$Dates["Col"][count($Dates["Col"])-1].($tmIndex*10+12));
			
			
				
		$objPHPExcel->getActiveSheet()->setCellValue('B'.($tmIndex*10+13),'Sugg:Qty');
		$objPHPExcel->getActiveSheet()->getStyle('B'.($tmIndex*10+13))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->duplicateStyleArray(
			array(			
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
					'left'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THICK,
					)				
				),
				'fill' => array(
					
					'type'       => PHPExcel_Style_Fill::FILL_SOLID,
					'rotation'   => 90,
					'startcolor' => array(
						'argb' => '00F8DDB6'
					)
				)
			),
			'A'.($tmIndex*10+13).':'.$Dates["Col"][count($Dates["Col"])-1].($tmIndex*10+13));
			
			
	}
	
	
	
	$objPHPExcel->getActiveSheet()->mergeCells('A1:'.$Dates["Col"][count($Dates["Col"])-1].'1');
	$objPHPExcel->getActiveSheet()->setCellValue('A1','Production Plan - From:'.$stDt.' To:'.$endDt);
	
	$objPHPExcel->getActiveSheet()->setCellValue('A3','Team');
	$objPHPExcel->getActiveSheet()->setCellValue('B3','Title');
	$objPHPExcel->getActiveSheet()->getStyle('A3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->getActiveSheet()->getStyle('B3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	
	$objPHPExcel->getActiveSheet()->duplicateStyleArray(
	array(
		'font'    => array(
			'bold'      => true
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		),
		'borders' => array(
			'top'     => array(
				'style' => PHPExcel_Style_Border::BORDER_THICK,
			),
			'bottom'     => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
			),
			'left'     => array(
				'style' => PHPExcel_Style_Border::BORDER_THICK,
			),
			'right'     => array(
				'style' => PHPExcel_Style_Border::BORDER_THICK,
			)				
		),
		'fill' => array(
			
			'type'       => PHPExcel_Style_Fill::FILL_SOLID,
			'rotation'   => 90,
			'startcolor' => array(
				'argb' => '00ECE9D8'
			)
		)
	),
	'A3:'.$Dates["Col"][count($Dates["Col"])-1]."3");	
	
	
	
	
	
			

///////////////////////////////////////////////// download file //////////////////////////
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=ProductionPlan'.$stDt.'-'.$endDt.'.xls');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 

//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//$objWriter->save("temp.xls");

echo 'done';
exit;

?>