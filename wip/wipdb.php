<?php
	session_start();
	include "../../Connector.php";	
	header('Content-Type: text/xml'); 	
	$request=$_GET["request"];
	
if ($request=='getwip')
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$Style=$_GET['style'];
	$factory=$_GET['factory'];
	if($factory!="" && $Style!="")
	$str_where="where pwip.intStyleID='$Style' and pwip.intDestinationFactroyID='$factory'";
	else if($factory!="" )
	$str_where="where pwip.intDestinationFactroyID='$factory'";
	else if($Style!="")
	$str_where="where pwip.intStyleID='$Style'";
	else
	$str_where="";
	
	$str="select 	comp.strName,
					ordr.strStyle,
					ordr.strOrderNo,
					pwip.intStyleID, 
					pwip.strColor, 
					pwip.strSeason, 
					pwip.intSourceFactroyID, 
					pwip.intDestinationFactroyID, 
					pwip.intOrderQty, 
					pwip.intCutQty, 
					pwip.intCutIssueQty, 
					pwip.intCutReceiveQty, 
					pwip.intCutReturnQty, 
					pwip.intInputQty, 
					pwip.intOutPutQty, 
					pwip.intMissingPcs, 
					pwip.intWashReady, 
					pwip.intSentToWash, 
					pwip.intMissingPcsBeforeWash, 
					pwip.intIssuedtoWash, 
					pwip.intFGReturnsBeforeWash,
					pwip.intFGgatePass, 
					pwip.intFGReceived,
					ordr.intQty,
					ordr.intSeasonId
					from 
					productionwip pwip inner join orders ordr on ordr.intStyleID=pwip.intStyleID
					left join companies comp on comp.intCompanyID=pwip.intDestinationFactroyID
					";
	$str.=$str_where;
	//die($str);
	$XMLString= "<Data>";
	$XMLString .= "<cutz>";
	
	
	$result = $db->RunQuery($str); 
	while($row = mysql_fetch_array($result))
	{
		$season = '';
		if($row["intSeasonId"] != '')	
			$season = getSeason($row["intSeasonId"]);
			
		$XMLString .= "<style><![CDATA[" . $row["strStyle"]  . "]]></style>\n";
		$XMLString .= "<OrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></OrderNo>\n";
		$XMLString .= "<StyleID><![CDATA[" . $row["intStyleID"]  . "]]></StyleID>\n";
		$XMLString .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$XMLString .= "<CutQty><![CDATA[" . $row["intCutQty"]  . "]]></CutQty>\n";
		$XMLString .= "<CutIssueQty><![CDATA[" . $row["intCutIssueQty"]  . "]]></CutIssueQty>\n";
		$XMLString .= "<CutReceiveQty><![CDATA[" . $row["intCutReceiveQty"]  . "]]></CutReceiveQty>\n";
		$XMLString .= "<CutReturnQty><![CDATA[" . $row["intCutReturnQty"]  . "]]></CutReturnQty>\n";
		$XMLString .= "<InputQty><![CDATA[" . $row["intInputQty"]  . "]]></InputQty>\n";
		$XMLString .= "<OutPutQty><![CDATA[" . $row["intOutPutQty"]  . "]]></OutPutQty>\n";
		$XMLString .= "<WashReady><![CDATA[" . $row["intWashReady"]  . "]]></WashReady>\n";
		$XMLString .= "<FGgatePass><![CDATA[" . $row["intFGgatePass"]  . "]]></FGgatePass>\n";
		$XMLString .= "<FGReceived><![CDATA[" . $row["intFGReceived"]  . "]]></FGReceived>\n";
		$XMLString .= "<orderQty><![CDATA[" . $row["intQty"]  . "]]></orderQty>\n";
		$XMLString .= "<season><![CDATA[" . $season  . "]]></season>\n";
		$XMLString .= "<factory_name><![CDATA[" . $row["strName"]  . "]]></factory_name>\n";
		//$XMLString .= "<CutIssueQty><![CDATA[" . $row["intCutIssueQty"]  . "]]></CutIssueQty>\n";
		
	}
	
	$XMLString .= "</cutz>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if ($request=='save_comment')
{
	$styleid=$_GET['styleid'];
	$date=$_GET['commentdate'];
	$comment=$_GET['comment'];	
	$str="INSERT INTO wip_comment 
			(intStyleId, 
			dtmDateComment, 
			stComment
			)
			VALUES
			('$styleid', 
			'$date', 
			'$comment'
			);";
	$result=$db->RunQuery($str);
	if($result)
		echo get_comment($styleid);
		
}
function get_comment($styleid)
{
	global $db;
	/*echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$str="SELECT intStyleId FROM wip WHERE intStatus=1 and intStyleId=''";
	$result=$db->RunQuery($str);
	$XMLString = "<data>\n";
	while($row=mysql_fetch_array($result))
	{
		$styleid=$row['intStyleId'];*/
		$comment='';
		$str_comment="select concat('<p><strong>Date : </strong>', DATE_FORMAT(dtmDateComment ,'%D/ %M') ,'</p><p><strong>',stComment,'</strong></p>') as comment from wip_comment where intStyleId='$styleid' ORDER BY dtmDateComment DESC ";
		$result_comment=$db->RunQuery($str_comment);
		while($row_comment=mysql_fetch_array($result_comment))
		{
			$comment.=$row_comment["comment"];
		}
		return $comment;
		/*$XMLString .= "<style><![CDATA[" . $styleid  . "]]></style>\n";
		$XMLString .= "<comment><![CDATA[" . $comment  . "]]></comment>\n";
	}
	$XMLString .= "</data>";
	echo $XMLString;	*/	
}

function getSeason($seasonId)
{
	global $db;
	$sql = " select strSeason from seasons where intSeasonId='$seasonId' ";
	$result = $db->RunQuery($sql); 
	$row = mysql_fetch_array($result);	
	return $row["strSeason"];
}
?>