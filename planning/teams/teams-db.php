<?php 
session_start();
$id 				= 	$_GET["id"];
$intCompanyId		=	$_SESSION["FactoryID"];

//echo $id;
include "../../Connector.php";

if($id=="saveTeamsValidateDataGrid")
{
	$teamId 	= $_GET["teamId"];
	$fromDate 	= $_GET["fromDate"];
	$toDate 	= $_GET["toDate"];
	
	
	$sql_check= "SELECT
plan_teamsvaliddates.dtmValidFrom,
plan_teamsvaliddates.dtmValidTo
FROM
plan_teamsvaliddates
WHERE intTeamId='$teamId' AND (((dtmValidFrom<='$fromDate'AND dtmValidTo>='$fromDate')OR (dtmValidFrom<='$toDate' AND dtmValidTo>='$toDate'))OR
(dtmValidFrom >='$fromDate' AND dtmValidTo<='fromDate'	))";
	$result_check = $db->RunQuery($sql_check);
	 
	if(mysql_num_rows($result_check)>0)
	{
		$result = true;
	}	
	else
	{	
	$sql = "insert into plan_teamsvaliddates 
				(intTeamId, 
				intCompanyId, 
				dtmValidFrom, 
				dtmValidTo
				)
				values
				('$teamId', 
				'$intCompanyId', 
				'$fromDate', 
				'$toDate'
				)";
	$result = $db->RunQuery($sql);
	}
	if($result)
	{
		echo "Successfully Saved!";
	}
	else
		echo "Data Saving Error!";
		

}

if($id=="saveTeams")
{
	$intTeamNo 			= $_GET['intTeamNo'];
	$strTeam 			= $_GET['strTeam'];
	$intMachines 		= $_GET['intMachines'];
	$intEfficency 		= $_GET['intEfficency'];
	$intOperators 		= $_GET['intOperators'];
	$dblWorkingHours 	= $_GET['dblWorkingHours'];
	$intSubTeamOf 		= $_GET['intSubTeamOf'];
	$intHelper 			= $_GET['intHelper'];
	$dblStartTime 		= $_GET['dblStartTime'];
	$dblEndTime 		= $_GET['dblEndTime'];
	$dblMealHours		= $_GET['dblMealHours'];
	
	
	
	
	 if(isHaveTeam($intTeamNo))
	{
		$sql = "update plan_teams 
			set
			strTeam 		= '$strTeam' , 
			intCompanyId 	= '$intCompanyId' , 
			intOrderNo 		= '0' , 
			intOperators 	= '$intOperators' , 
			intMachines		= '$intMachines',
			intEfficency 	= '$intEfficency' , 
			intHelper 		= '$intHelper' , 
			dblWorkingHours = '$dblWorkingHours' , 
			intSubTeamOf 	= '$intSubTeamOf' , 
			intSubOrderNo 	= '0' , 
			dblStartTime 	= '$dblStartTime' , 
			dblEndTime 		= '$dblEndTime',
			dblMealHours	= '$dblMealHours'
			where
			intTeamNo = '$intTeamNo' and intCompanyId = '$intCompanyId'";
		$result = $db->RunQuery($sql);  		

	echo $intTeamNo;
		
	}	
	else
	{ 
		$sql = "insert into plan_teams 
					( 
					strTeam, 
					intCompanyId, 
					intOrderNo, 
					intOperators, 
					intMachines,
					intEfficency, 
					intHelper, 
					dblWorkingHours, 
					intSubTeamOf, 
					intSubOrderNo, 
					dblStartTime, 
					dblEndTime,
					dblMealHours
					)
					values
					(
					'$strTeam',
					'$intCompanyId',
					'0',
					'$intOperators',
					'$intMachines',
					'$intEfficency',
					'$intHelper',
					'$dblWorkingHours',
					'$intSubTeamOf',
					'0',
					'$dblStartTime',
					'$dblEndTime',
					'$dblMealHours')";
			
		$result = $db->AutoIncrementExecuteQuery($sql);
			
		$sql2="SELECT intTeamNo FROM plan_teams ORDER BY plan_teams.intTeamNo DESC limit 1;";
		$result2 = $db->RunQuery($sql2);
		$row2 = mysql_fetch_array($result2);
		$firstTeamNo=$row2['intTeamNo'];
			
		echo $firstTeamNo;
			
			
			
			
			

				
	}
		//	$sql ="delete from plan_teamsvaliddates where intTeamId=$intTeamNo and intCompanyId=$intCompanyId";
			//$result = $db->RunQuery($sql); 
			
}

if($id=="teamDelete")
{
	$intTeamNo = $_GET["teamId"];
	
	$sql ="delete from plan_teamsvaliddates where intTeamId=$intTeamNo and intCompanyId=$intCompanyId";
	$result1 = $db->RunQuery($sql);

	$sql = "delete from plan_teams where intTeamNo = '$intTeamNo' and intCompanyId = '$intCompanyId' ; ";
	$result2 = $db->RunQuery($sql);
	//echo $sql;
	if($result2)
		echo "1";
	else
		echo "0";
		
}

function isHaveTeam($id)
{
	global $db;
	global $intCompanyId;
	
	$sql="select * from plan_teams where intTeamNo =$id and intCompanyId=$intCompanyId";
	//echo $sql;
	$result = $db->RunQuery($sql);
	$count = (int)mysql_num_rows($result);
	if($count>0)
	{
		return true;
	}
}
?>