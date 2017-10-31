<?php
include('../../Connector.php');	
	$type=trim($_GET["type"]);
	
//-------------------------------------------------------------------------------------------------------------------------------

 if($type=="deleteBeforeSave"){
  $cboGroup = $_GET["cboGroup"];
  $sql = "delete from events_eventgroup_visibility where intGroupID = '$cboGroup'";
  $res = $db->RunQuery($sql);
  echo $res;
}

else if($type=="events_user_groups_Save"){
 $cboGroup = $_GET["cboGroup"];
 $eventID  = $_GET["eventID"];
 
echo  $sql = "insert into events_eventgroup_visibility(intEventID,intGroupID)VALUES($eventID,$cboGroup)";
 $res = $db->RunQuery($sql);
}

//--------------------------------------------------------------------------------------------------------------------------------

?>