<?php

session_start();
include "../Connector.php";

$RequestType = $_GET['RequestType'];


if($RequestType=='loadOders')
{
	$stylename = $_GET['stylename'];
	
	$html = "<option></option>";
	
	$SQL1 = "SELECT OD.strOrderNo,OD.intStyleId
			 FROM orders OD
			 WHERE OD.intStatus = 11 AND OD.strStyle = '$stylename' ORDER BY OD.strOrderNo";
	
	$result1 = $db->RunQuery($SQL1);	
	
	while($row = mysql_fetch_array($result1))
	{
		$html .= "<option value=".$row['intStyleId'].">".$row['strOrderNo']."</option>";
	}
	
	echo $html;
	
}
else if($RequestType=='loadDocuments')
{
	$styleid 	  = $_GET['styleid'];
	$documentname = $_GET['documentname'];
	
	$string="";
	$fileCount=0;
	$filePath=$PATH.'../styleDocument/'.$styleid.'/'.$documentname.'/'; # Specify the path you want to look in. 
	$dir = opendir($filePath); # Open the path
	while ($file = readdir($dir)) 
	{ 
  		if (eregi("\.jpg",$file)) 
		{ # Look at only files with a .jpg extension
    		$string .= $file.",";
    		$fileCount++;
  		}
	}
		if ($fileCount > 0) 
		{
  			echo sprintf("<strong>List of Files in %s</strong><br />%s<strong>Total Files: %s</strong>",$filePath,$string,$fileCount);
		}

}

else if($RequestType=='deleteImage')
{
	$filename = $_GET['filename'];
	$styleid  = $_GET['styleid'];
	$doc      = $_GET['doc'];
	
	if(file_exists("../styleDocument/".$styleid."/".$doc."/".$filename))
	{
		unlink("../styleDocument/".$styleid."/".$doc."/".$filename);
	}
}













?>