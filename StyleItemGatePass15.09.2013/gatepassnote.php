<?php 
 
 session_start();
include "authentication.inc"; 
$xml = simplexml_load_file('../config.xml');
$ReportISORequired = $xml->companySettings->ReportISORequired;
$reportName	= $xml->styleInventory->Gatepass->reportName;
$cboGatePassNo = explode("/",$_GET["cboGatePassNo"]);

$intIssueNo =$expIssue[1];
$year = $expIssue[0];		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Style Items - Issue Note</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
-->
</style>
<style type="text/css">
.tophead1  {
color:#000000;
font-family:"Century Gothic";
font-size:24px;
line-height:24px;
font-weight:normal;
margin:0;
}
.tophead2  {
color:#000000;
font-family:"Century Gothic";
line-height:22px;
font-size:20px;
font-weight:normal;
margin:0;
}
.tophead3  {
color:#000000;
font-family:"Century Gothic";
line-height:18px;
font-size:16px;
font-weight:bold;
margin:0;
}
</style>

</head>

<body>
<?php

include $reportName;
?>
</body>
</html>
