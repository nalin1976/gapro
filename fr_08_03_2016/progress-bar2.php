<?Php
//***************************************
// This is downloaded from www.plus2net.com //
/// You can distribute this code with the link to www.plus2net.com ///
//  Please don't  remove the link to www.plus2net.com ///
// This is for your learning only not for commercial use. ///////
//The author is not responsible for any type of loss or problem or damage on using thisqs script.//
/// You can use it at your own risk. /////
//*****************************************
//error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);
set_time_limit ( 60 ) ;

require "../Connector.php"; // Database connection details 
//////////////////////////////// Main Code starts /////////////////////////////////////////////
$strSql = "select count(intSRNO) as stage from specification";

$result = $db->RunQuery($strSql);

while($row=mysql_fetch_array($result)){
	$q = $row['stage'];
}

//$q=mysql_fetch_object(mysql_query("select max(intSRNO) as stage from specification"));
//echo $q->stage;

///////////////////////////////////////////////
//$width=$_POST['width'];
$width=$q;//*20;
echo 0;//$width;
?>