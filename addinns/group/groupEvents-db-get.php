<?php
include "../../Connector.php";


$request=$_GET['type'];

//echo $request;
 if($request == "loadExEventsForGroup"){
 
 $cboUser = $_GET["cboUser"];
    header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
 $ResponseXML ="";
		 $ResponseXML .= "<thead>
                    <tr>
							<th width=\"46\">#</th>
							<th width=\"446\">Event</th>
					</tr>
                    </thead>			 		
		    <tbody>";
			
 $sql = "SELECT
            distinct(events.intEventID),
			events.strDescription		
			FROM
			events";
			//echo  $sql;
 $result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{	
	 $ResponseXML.="<tr>
		<td><input type='checkbox'/></td>
		<td id=\"".$row["intEventID"]."\" align=\"left\">".$row["strDescription"]."</td>";
	  $ResponseXML .="</tr>";
	}
	echo $ResponseXML;
}

//---------------------------------------------------------

 else if($request == "check"){
 
    header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$cboGroup = $_GET["cboGroup"];
	 $ResponseXML .= "<loadCheck>";
  $sql = "SELECT
            distinct(events.intEventID),
			events.strDescription		
			FROM
			events
			left Join events_eventgroup_visibility ON events.intEventID = events_eventgroup_visibility.intEventID
			left Join events_group ON events_eventgroup_visibility.intGroupID = events_group.intGroupId
			WHERE
			events_eventgroup_visibility.intGroupID =  '$cboGroup'";
			//echo  $sql;
 $result = $db->RunQuery($sql);
 while($row = mysql_fetch_array($result))
 {	
 $ResponseXML .= "<intEventID><![CDATA[".trim($row["intEventID"])  . "]]></intEventID>\n";
 }
 $ResponseXML .= "</loadCheck>";
 echo $ResponseXML;
 }
?>
