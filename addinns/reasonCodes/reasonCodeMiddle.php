<?php
require_once('../../Connector.php');
$request=$_GET['req'];


if($request == "saveProcesses")
{
	$proName  = $_GET['proName'];
	$processId = $_GET["processId"];
	if($processId == '')
	{
		$sql_chkExist="SELECT * FROM tblprocesses WHERE strProcessName='$proName' AND intStatus != 10;";
		$resChk=$db->RunQuery($sql_chkExist);
		if(mysql_num_rows($resChk) == 0)
		{
			$sql_AddProc="INSERT INTO tblprocesses(strProcessName,intStatus) VALUES('$proName',1);";
			$res=$db->RunQuery($sql_AddProc);
			$sql_new="SELECT max(intCode) CD FROM tblprocesses;";
			$resN=$db->RunQuery($sql_new);
			while($row=mysql_fetch_array($resN))
			{
				echo "1-".$row['CD'];
			}
		}
		else
		{
			echo 2;
		}
	}
	else
	{
		$sql = " update tblprocesses  set 	strProcessName = '$proName' 	where 	intCode = '$processId'";
		$result = $db->RunQuery($sql);
		echo "N/A";
	}
	
}
if($request == "saveReasons")
{
	$resCode   = $_GET['resCode'];
	$resDesc   = $_GET['resDesc'];
	$intStatus  = $_GET["intStatus"];
	
	$sql = " insert into tblreasoncodes (strCode,strDescription,intStatus)
values 	('$resCode','$resDesc','1') ";

	$res=$db->RunQuery($sql);
	
	$sql_r = " select intResonCodeId from tblreasoncodes where strCode = '$resCode' ";
	$result=$db->RunQuery($sql_r);
	$row = mysql_fetch_array($result);
	
	echo $row["intResonCodeId"];
}
if($request == "deleteReasonAllocationCode")
{
	$cboCode  = $_GET["cboCode"];
	$resCode   = $_GET['resCode'];
	$resDesc   = $_GET['resDesc'];
	$intStatus = $_GET["intStatus"];
	
	$sql_d = " delete from tblreasoncodeallocation 
	where 	intResonCodeId = '$cboCode' ";
	$result=$db->RunQuery($sql_d);
	
	$sql_u = " update tblreasoncodes 
	set
	strCode = '$resCode' , strDescription = '$resDesc', intStatus='$intStatus' 	
	where
	intResonCodeId = '$cboCode' ";
	
	$res=$db->RunQuery($sql_u);
}
if($request == "saveReasonsAllocation")
{
	
	$reasonCodeId   = $_GET['reasonCodeId'];
	$processCode = $_GET["processCode"]; 
		
	$sql_R = " insert into tblreasoncodeallocation (intResonCodeId,intCode)
values ('$reasonCodeId', '$processCode') ";
	$result=$db->RunQuery($sql_R);
}

if($request == "updateReasons")
{
	$resCode   = $_GET['resCode'];
	$resDesc   = $_GET['resDesc'];
	$intCode   = $_GET['intPrcCode'];
	$intPrcCode= split('~',$intCode);
	
	$sql_del="DELETE FROM tblreasoncodes WHERE strCode='$resCode' AND intStatus != 10";
			//echo $sql_del;
			$res=$db->RunQuery($sql_del);
			
		for($i=0;$i<count($intPrcCode);$i++)
		{
		$sql_Addreasons="INSERT INTO tblreasoncodes(intProcessCode,strCode,strDescription,intStatus) VALUES(".$intPrcCode[$i].",'$resCode','$resDesc',1)";
			$res=$db->RunQuery($sql_Addreasons);
		}
			echo "Updated successfully.";
}

/*if($request == "saveReasons")
{
	
}
if($request == "delReasons")
{
		$resCode   = $_GET['resCode'];
		if($resCode !="")
		{
			$sql_del="DELETE FROM tblreasoncodes WHERE strCode='$resCode'";
			//echo $sql_del;
			$res=$db->RunQuery($sql_del);
			echo 1;
		}
		else
		{
			echo 2;
		}
}*/

if($request == "loadReasons")
{
	$resonCode   = $_GET['resonCode'];
	
	$sql_Load="select strCode,strDescription,intStatus from tblreasoncodes where intResonCodeId='$resonCode' ";
		//echo $sql_del;
	$res=$db->RunQuery($sql_Load);
	header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<Reason>";
	while($row = mysql_fetch_array($res))
	{
		 $ResponseXML .= "<strReasonCode><![CDATA[" . $row["strCode"]  . "]]></strReasonCode>\n";
         $ResponseXML .= "<strDesc><![CDATA[" . $row["strDescription"]  . "]]></strDesc>\n";
		 $ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n";
	}
	$ResponseXML .= "</Reason>";
	echo $ResponseXML;
}
if($request == "loadReasonsCodeProcess")
{
	$resonCode   = $_GET['resonCode'];
	
	$sql_Load="select intResonCodeId,intCode from tblreasoncodeallocation where intResonCodeId='$resonCode' ";
		//echo $sql_del;
	$res=$db->RunQuery($sql_Load);
	header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<Reason>";
	while($row = mysql_fetch_array($res))
	{
		 $ResponseXML .= "<processCode><![CDATA[" . $row["intCode"]  . "]]></processCode>\n";
	}
	$ResponseXML .= "</Reason>";
	echo $ResponseXML;
}
if($request == "loadReasonCodes")
{
	
	$sql_Load="SELECT intResonCodeId,strCode FROM tblreasoncodes r   GROUP BY strCode;  ";
		//echo $sql_del;
	$res=$db->RunQuery($sql_Load);
	header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<Reason>";
	$str .= "<option value=\"\"></option>";
	while($row = mysql_fetch_array($res))
	{
		$str .= "<option value=\"". $row["intResonCodeId"] ."\">" . $row["strCode"] ."</option>";
	}
	
	$ResponseXML .= "<strReasonCode><![CDATA[" . $str  . "]]></strReasonCode>\n";
	$ResponseXML .= "</Reason>";
	echo $ResponseXML;
}
if($request =="loadProcesses")
{
	$resCode   = $_GET['resCode'];
	$sql_LoadPrc="SELECT R.intProcessCode FROM tblreasoncodes R WHERE strCode='$resCode';";
		//echo $sql_del;
	$res=$db->RunQuery($sql_LoadPrc);
	header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<Processes>";
	while($row = mysql_fetch_array($res))
	{
		 $ResponseXML .= "<intProcessCode><![CDATA[" . $row["intProcessCode"]  . "]]></intProcessCode>\n";
	}
	$ResponseXML .= "</Processes>";
	echo $ResponseXML;
}
if($request=="fillReasonsCombo")
{
	$resCode   = $_GET['resCode'];
	$sql_fillCombo="SELECT strCode FROM tblreasoncodes WHERE intStatus=1 GROUP BY strCode;";
	$res=$db->RunQuery($sql_fillCombo);
	$htmCombo="<option></option>";
	while($row=mysql_fetch_array($res))
	{
		$htmCombo .="<option value=".$row['strCode'].">".$row['strCode']."</option>";
	}
	echo $htmCombo;
}
if($request=="deleteReson")
{
	$cboResCode = $_GET['cboResCode'];
	$sql_del="Delete from tblreasoncodes  WHERE intResonCodeId='$cboResCode';";
	
	$result = $db->RunQuery2($sql_del);
	if(gettype($result)=='string')
	{
		echo $result;
		return;
	}
	
	echo "Deleted successfully.";
}
if($request=="deleteProcess")
{
	$prcCode = $_GET['prcCode'];
	$sql_del="Delete from tblprocesses  WHERE intCode='$prcCode' ";
	
	$result = $db->RunQuery2($sql_del);
	if(gettype($result)=='string')
	{
		echo $result;
		return;
	}
	
	echo $result;
}

?>