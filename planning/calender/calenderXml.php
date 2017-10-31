<?php
 session_start();
 include "../../Connector.php";
 $intPubCompanyId		=$_SESSION["FactoryID"];
 
 $id = $_GET["id"];
 

 
  if($id == 'checkIfAssigened')
  {
	  $intYear  = $_GET["intYear"];
	  $intMonth = $_GET["intMonth"];
  
  		  		$sql="SELECT * FROM plan_calender 
				WHERE
				plan_calender.intYear =  '$intYear' AND
				plan_calender.intMonth =  '$intMonth' and intCompanyId=$intPubCompanyId";
				$result = $db->RunQuery($sql);
				echo mysql_num_rows($result);
  
  }
 

 
 if($id=='isValidDate')
 {
 	
	 $edate  = $_GET["edate"];
	 
 	$sql="	select * from( SELECT
			date_add(dtmDate,interval 1 month) as newDate
			FROM
			plan_calender where intCompanyId=$intPubCompanyId) as tblNew where newDate > '$edate'";
	$result = $db->RunQuery($sql);
	$text =  'false';
	while($row = mysql_fetch_array($result))
	{
		$text =  'true';
	}
	
	$sql="select dtmDate from plan_calender where intCompanyId=$intPubCompanyId";
	$result = $db->RunQuery($sql);
	if( mysql_num_rows($result)<=0)
		$text = 'true';
	
	if($text!='true')
	{
		$sql="select max(dtmDate) as maxDate from plan_calender where intCompanyId=$intPubCompanyId";
		$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				$text =  $row["maxDate"];
			}
	}
 	echo $text;
 }
 ?>
