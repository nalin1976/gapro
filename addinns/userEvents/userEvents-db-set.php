<?php
include('../../Connector.php');	
	$type=trim($_GET["type"]);
	
//-------------------------------------------------------------------------------------------------------------------------------

 if($type=="deleteBeforeSave"){
  $cboUser = $_GET["cboUser"];
  $sql = "delete from events_visibility where intUserID = '$cboUser'";
  $res = $db->RunQuery($sql);
  echo $res;
}

else if($type=="events_user_groups_Save"){
 $cboUser = $_GET["cboUser"];
 $eventID  = $_GET["eventID"];
 
 $sql = "insert into events_visibility(intEventID,intUserID)VALUES($eventID,$cboUser)";
 $res = $db->RunQuery($sql);
}

//--------------------------------------------------------------------------------------------------------------------------------

?>