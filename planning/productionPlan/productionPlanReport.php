<?php

session_start();
include "../../Connector.php";	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PRODUCTION PLAN</title>

<link href="../css/planning.css" rel="stylesheet" type="text/css" />

<style type="text/css">
	#boxdiv1 div{
		float: left;
		margin: 0px;
	}

	#divInitial div{
		float: left;
		margin: 0px;
	}


	.classTeam div{
		float: left;
		margin: 0px;
		border-top: 0px;
		border-left: 1px solid #B4B4B4;
		border-right: 1px solid ;
		border-bottom: 1px ;
	}
	.classGridBox div{

		border-top: 0px;
		border-left: 1px solid #B4B4B4;
		border-right: 1px solid ;
		border-bottom: 1px ;
	}
	.tableCellProductPlan1 {
		border: 1px solid #666666;
		background-color: #ECE9D8;
		font-family: Verdana;
		font-size: 10px;
		color: #000000;
		text-align: center;
		font-weight: bold;
	}
	.tableCellProductPlan2 {
		border: 1px solid #666666;
		background-color: #808080;
		font-family: Verdana;
		font-size: 10px;
		color: #EFEF10;
		text-align: center;
		font-weight: bold;
	}
	.tableCellProductPlan3 {
		border: 1px solid #666666;
		background-color: #B6F1A5;
		font-family: Verdana;
		font-size: 10px;
		color:  #000000;
		text-align: center;
		font-weight: bold;
	}
	.tableCellProductPlan4 {
		border: 1px solid #666666;
		background-color: #BCFAF7;
		font-family: Verdana;
		font-size: 10px;
		color:  #000000;
		text-align: center;
		font-weight: bold;
	}
	
	.div2{
		position:absolute;
		left:0px;
		margin-left:0px;
	}
</style> 

</head>

<body>
	<?php

	$response="<table width=\"100%\" border=\"0\" >";
		
	$stDt =$_GET["startDate"];	
	$endDt = $_GET["endDate"];	
		
	  $response.="<tr>";
		$response.="<td width=\"100%\" align=\"center\"><h2>PRODUCTION PLAN</h2><h4>"." ( ".$stDt." - ".$endDt." )"."</h4></td>";
	  $response.="</tr>";	  
	  
		  $startDateArr = explode("-", $stDt);		  
		  $startDate = mktime(0,0,0,$startDateArr[1],$startDateArr[2],$startDateArr[0]);
		  
		  $endDateArr = explode("-", $endDt);		  
		  $endDate = mktime(0,0,0,$endDateArr[1],$endDateArr[2],$endDateArr[0]);
		  
		  $numDays=2+ceil(($endDate-$startDate)/(60*60*24));	
		  
		 
	  $response.="<tr>";
		$response.="<td align=\"center\">";
			$response.="<table width=". 8+60+80+(75+2)*($numDays-1)."  border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#162350\"  id=\"tblMain\">";
				$response.="<tr>";
					$response.="<td  class=\"normaltxtmidb2\" >";
						$response.="<div id=\"boxdiv1\" >";
						$response.="<div  class=\"tableCellProductPlan1\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">Team</div>";
						$response.="<div  class=\"tableCellProductPlan1\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Title</div>";
					
						$tmpdate=$startDate;
						for($i=1;$i<$numDays;$i++){							
												
							$response.="<div  class=\"tableCellProductPlan1\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">".date("d", $tmpdate)."/".date("M", $tmpdate)."</div>";
						
							$tmpdate+=24 * 60 * 60;
						}	
					
					$response.="</div>";
					$response.="</td>";
					$response.="</tr>";
						
					
						$SQL="select distinct plan_teams.intTeamNo,plan_teams.strTeam,plan_stripes.intTeamNo from plan_teams,plan_stripes where plan_teams.intTeamNo=plan_stripes.intTeamNo;";
							
						$result = $db->RunQuery($SQL);
						while($row1 = mysql_fetch_array($result))
						{	
									
							$response.="<tr>";
							$response.="<td  class=\"normaltxtmidb2\" >";
								$response.="<div id=\"boxdiv1\" >";
								$response.="<div  class=\"tableCellProductPlan2\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
								$response.="<div  class=\"tableCellProductPlan2\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Style No.</div>";
							
								for($i=1;$i<$numDays;$i++){							
									$response.="<div  class=\"tableCellProductPlan2\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
							
								}	
							
							$response.="</div>";
							$response.="</td>";
							$response.="</tr>";
							$response.="<tr>";
							$response.="<td  class=\"normaltxtmidb2\" >";
								$response.="<div id=\"boxdiv1\" ><div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">".$row1["strTeam"]."</div>";
								$response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Planned Qty</div>";
							
								for($i=1;$i<$numDays;$i++){
							
									$response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
								
								}	
							
							$response.="</div>";
							$response.="</td>";
							$response.="</tr>";
							$response.="<tr>";
							$response.="<td  class=\"normaltxtmidb2\" >";
								$response.="<div id="boxdiv1" >";		
								$response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
								$response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Planned TTL</div>";
							
								for($i=1;$i<$numDays;$i++){
							
									$response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
							
								}	
							
							$response.="</div>";
							$response.="</td>";
							$response.="</tr>";
							$response.="<tr>";
							$response.="<td  class=\"normaltxtmidb2\" >";
								$response.="<div id=\"boxdiv1\" >";			
								$response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
								$response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Planned Eff</div>";
							
								for($i=1;$i<$numDays;$i++){
							
									$response.="<div  class=\"tableCellProductPlan3\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
								
								}	
							
							$response.="</div>";
							$response.="</td>";
							$response.="</tr>";
							$response.="<tr>";
							$response.="<td  class=\"normaltxtmidb2\" >";
								$response.="<div id=\"boxdiv1\" >";		
								$response.="<div  class=\"tableCellProductPlan2\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
								$response.="<div  class=\"tableCellProductPlan2\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Style No.</div>";
							
								for($i=1;$i<$numDays;$i++){
							
									$response.="<div  class=\"tableCellProductPlan2\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
							
								}	
							
							$response.="</div>";
							$response.="</td>";
							$response.="</tr>";
							$response.="<tr>";
							$response.="<td  class=\"normaltxtmidb2\" >";
								$response.="<div id=\"boxdiv1\" >";			
								$response.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
								$response.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Actual Qty</div>";
							
								for($i=1;$i<$numDays;$i++){
							
									$response.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
							
								}	
							
							$response.="</div>";
							$response.="</td>";
							$response.="</tr>";
							$response.="<tr>";
							$response.="<td  class=\"normaltxtmidb2\" >";
								$response.="<div id=\"boxdiv1\" >";			
								$response.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
								$response.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Actual TTL</div>";
							
								for($i=1;$i<$numDays;$i++){
							
									$response.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
								
								}	
							
							$response.="</div>";
							$response.="</td>";
							$response.="</tr>";
							$response.="<tr>";
							$response.="<td  class=\"normaltxtmidb2\" >";
								$response.="<div id=\"boxdiv1\" >";			
								$response.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:60px; height:15px;\">&nbsp;</div>";
								$response.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:80px; height:15px;\">Actual Eff</div>";
							
								for($i=1;$i<$numDays;$i++){
							
									$response.="<div  class=\"tableCellProductPlan4\"  id=\"divInitialQQ\" style=\"width:75px; height:15px;\">&nbsp;</div>";
								
								}	
							
							$response.="</div>";
							$response.="</td>";
							$response.="</tr>";
						 } 
					 $response.="</table>";
		$response.="</td>";
	  $response.="</tr>";
	$response.="</table>";
	
	
	$response = htmlspecialchars($response);

	//setHeader("inventory.xls");
        
   // echo $response;
	
	
	//$test="<table border=1><tr><td>Cell 1</td><td>Cell 2</td></tr></table>";
	header("Content-type: application/x-msdownload");
	header("Content-Disposition: attachment; filename=xyz.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	print "$header\n$response"; 
	
	//echo $response;
	
	?>
</body>

</html>



