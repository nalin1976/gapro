<?php
session_start();
include "../../Connector.php";


	$batchId = $_GET["cboSearch"];
	//$batchId = "106";
	$sql_getFileName = "select strBatchFileName from batch where intBatch='$batchId'";
	$result = $db->RunQuery($sql_getFileName);
	while($row=mysql_fetch_array($result))
	{
		$fileName = $row["strBatchFileName"];
		$path = "Batch/$fileName";
		$file = basename($path);
		$size = filesize($path);
		
		header ("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$fileName");
		header("Content-Length: $size");
	
	readfile($path);
	
	}


?>