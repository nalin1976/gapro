<?php 
	session_start();
 $backwardseperator = "../";
 
 $mainId = $_GET["mainId"];
 $subId	= $_GET["subCatId"];
 $matItem		= $_GET["ItemID"];
 $mainStores	= $_GET["mainStore"];
 $color 	= $_GET["color"];
 $size		= $_GET["size"];
 $txtmatItem  = $_GET["itemDesc"];
 $tdate = date('Y-m-d');
 
 $report_companyId =$_SESSION["FactoryID"];
 
 $deci = 2; //no of decimal places
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Age Analysis Report</title>
<link href="../css/erpstyle.css" type="text/css" rel="stylesheet" />
</head>

<body>
<?php 
include "../Connector.php";


$sql="CALL users()";
$res = $db->RunQuery($sql);
 while($row=mysql_fetch_array($res))
 {
echo $row['UserName'].'';
 }

?>
</body>
</html>
